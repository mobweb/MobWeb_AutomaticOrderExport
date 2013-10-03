# MobWeb_AutomaticOrderExport extension for Magento

This extension calls a custom method every time an order is placed with your store. The call includes the order object. From there you can do anything you want with the order data, for example export it to an external service or store it in a separate database.

There are two ways how this extension can be used:
* Call the method instantly after an order is placed via the observer
* Run a cron job every 5 minutes that picks up all the latest orders and sends them to the method

## How it works
* An event observer is registered in `config.xml` that calls `MobWeb_AutomaticOrderExport_Model_Observer::salesOrderPlaceAfter` any time an order is placed with your store. This method then calls its sibling `_exportOrder` that handles the export of the order
* Alternatively, a cron job is run every five minutes that calls `MobWeb_AutomaticOrderExport_Model_Observer::batchOrderExport`. This method gets the latest (unhandled) orders and calls `_exportOrder` on each one of them

## Installation

Install using [colinmollenhour/modman](https://github.com/colinmollenhour/modman/).

## Questions? Need help?

Most of my repositories posted here are projects created for customization requests for clients, so they probably aren't very well documented and the code isn't always 100% flexible. If you have a question or are confused about how something is supposed to work, feel free to get in touch and I'll try and help: [info@mobweb.ch](mailto:info@mobweb.ch).
# 
While studying Magento I found that the easiest way for me personally to learn something new is to break everything down into smaller parts. This extension is such a "smaller part". It doesn't really add any value and can't be used directly, instead it can help to provide an overview about how a task is accomplished in Magento. See my [other repositories](https://github.com/mobweb?tab=repositories) for more such example extensions.