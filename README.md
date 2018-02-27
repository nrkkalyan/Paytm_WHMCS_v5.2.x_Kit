# Introduction

This integration kit is used in WHMCS PHP E-Commerce Application. This library provides support for Paytm payment gateway.

# Installation

Copy the files from this plugin into the corresponding folders on your installation, as mentioned below:
 1. Copy the Paytm/gateways/paytm.php file into your installation's /module/gateways/ folder
 2. Copy the Paytm/gateways/callback/paytm.php file into your installation's /module/gateways/callback folder.
 3. Copy the Paytm/gateways/paytm-sdk folder into your /module/gateways folder

# Configuration

Provide the values for the following in the *Configuration Settings* of the Admin Panel.
 1. Merchant ID
 2. Website
 3. Merchant Key
 4. Channel ID
 5. Industry Type ID

# Paytm PG URL Details
	staging	
		Transaction URL             => https://securegw-stage.paytm.in/theia/processTransaction
		Transaction Status Url      => https://securegw-stage.paytm.in/merchant-status/getTxnStatus

	Production
		Transaction URL             => https://securegw.paytm.in/theia/processTransaction
		Transaction Status Url      => https://securegw.paytm.in/merchant-status/getTxnStatus
