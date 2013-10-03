<?php

class MobWeb_AutomaticOrderExport_Model_Observer
{
	// This method is called whenever a new order is placed with the store.
	// It pushes the order data directly to an external service, using CURL
	public function salesOrderPlaceAfter( $observer )
	{
		// Get the order object
		$order = $observer->getEvent()->getOrder();

		// Export the order
		$this->_exportOrder( $order );
	}

	// This method is called via an automated cron job.
	// It pushes all the new orders to an external service, using CURL
	public function batchOrderExport( $schedule )
	{
		// Get a collection of all the orders with a status of "NEW"
		$orders = Mage::getModel( 'sales/order' )->getCollection()->addAttributeToFilter( 'state', Mage_Sales_Model_Order::STATE_NEW )->load();

		// Loop through the orders
		foreach( $orders AS $order ) {
			// Export the order
			$this->_exportOrder( $order );

			// Set the status to "PROCESSING" so that no order will be exported
			// twice
			$order->setState( STATE_PROCESSING );

			// Save the new order status
			$order->save();
		}
	}

	// This prototype function can export an order to an external service
	protected function _exportOrder( $order )
	{
		// Set the body
		$body = 'New order placed at your store: ' . $order->getId();

		// Send the request to an external service
		$ch = curl_init( 'https://api.twilio.com/2010-04-01/Accounts/AC8f3addfafdf51dc6418e352dfc92fb76/SMS/Messages.xml' );
		curl_setopt( $ch, CURLOPT_POST, 1 );
		curl_setopt( $ch, CURLOPT_POSTFIELDS, array( 'From' => '+17695535201', 'To' => '+41796943686', 'Body' => $body ) );
		curl_setopt( $ch, CURLOPT_USERPWD, 'AC8f3addfafdf51dc6418e352dfc92fb76:1152f982b0bafe57b0f1bf709aa92f14' );
		curl_exec($ch);

		//TODO: Handle the response
	}
}