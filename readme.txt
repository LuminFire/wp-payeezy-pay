=== WP Payeezy Pay ===
Contributors: RickRottman
Donate link: https://www.paypal.me/RichardRottman
Tags: First Data, Payeezy, Hosted Checkout, Payment Page, E-Commerce, Recurring, GGe4, First Data, Donations, Payments, Bank of America, Wells Fargo, Hosted Checkout
Requires at least: 3.0.1
Tested up to: 4.6
Stable tag: 2.68
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Connects a WordPress site to First Data's Payeezy Gateway using the Payment Page/Hosted Checkout method of integration. 

== Description ==

Plugin creates a shortcode that when placed in the page or a post, generates a payment form for a Payeezy Payment Page. The published form includes:

* First Name
* Last Name
* Company Name (optional)
* Street Address
* City
* State (dropdown)
* Zip Code
* Country (dropdown)
* Email Address (optional)
* Phone Number (optional)
* x_invoice_num (optional)
* x_po_num (optional)
* x_reference_3 (optional)
* User Defined 1 (optional)
* User Defined 2 (optional)
* User Defined 3 (optional)
* Amount (optionally recurring every month)
* "Pay Now", "Donate Now", "Continue", or "Continue to Secure Form" button

Once a cardholder enters their information, they press the "Pay Now" or “Donate Now” button. They are then redirected to the secure Payeezy payment form hosted by First Data where they finish entering their information including credit card number, expiration date, and security code. The cardholder then clicks "Pay with your credit card" and the payment is made. Once the transaction is complete, the user is provided a receipt. They can then click a link and be redirected back to the original website. 

== Installation ==

**From your WordPress dashboard**

1. Visit 'Plugins > Add New'.

2. Search for 'WP Payeezy Pay'.

3. Activate WP Payeezy Pay from your Plugins page.

**From WordPress.org**

1. Download WP Payeezy Pay.

2. Upload the 'WP Payeezy Pay' directory to your '/wp-content/plugins/' directory, using your favorite method (ftp, sftp, scp, etc...).

3. Activate WP Payeezy Pay from your Plugins page. 

**Once Activated**

1. Visit 'Menu > WP Payeezy Pay > and enter the Payment Page ID and the Transaction Key. These values are obtained in Payeezy. Also enter a currency code. If your account is setup for US Dollars, enter USD.

2. Choose the Mode you wish to use, Live for a production account, one that actually processes credit cards, or Demo for a non-production testing account.

3. Enter the Type of Transactions you want the Payment Page to make:

    * Payments  - All payments are done on a singular basis. 

    * Payments with optional Recurring - Customer has the option of clicking a box that will repeat their payment automatically in 30 days. If they don’t click the box, the payment is handled as a single payment. Recurring payment will continue until the Payeezy Merchant Administrator goes into Recurring and suspends or deletes the Recurring payment.
 
    * Payments with automatic Recurring - Customer doesn’t get a checkbox to make the payment recurring. The transaction will automatically be made again in 30 days and will continue until the Payeezy Merchant Administrator goes into Recurring and suspends or deletes the Recurring payment. Good for gym memberships, karate schools, etc.

    * Donations - Cardholder will have the option of making a donation by selecting a predefined amount. If none of the predefined amounts are optimal, they can select “Other” and enter their own. Instead of a button labeled “Pay Now” to go to the secure payment form hosted by First Data, the button will be labeled “Donate Now.” 

    * Donations with optional Recurring - This is just like the above, but it gives the cardholder the option of making their donation on a monthly recurring basis by clicking a box. Recurring donations will continue until the Payeezy Merchant Administrator goes into Recurring and suspends or deletes the Recurring donation. 

4. Enter names for the optional payment form fields that you would like to use with your payment form. If you leave any of these fields blank, they will not appear on the published payment for. For example, if you want your customers to enter their invoice number on the bill they are paying, you would enter "Invoice Number" in the x_invoice_num field. A field will then appear on the published payment form for Invoice Number. The value entered by the cardholder will be passed on to Payeezy and it will be part of the transaction record. 

5. Press 'Save Settings'.


**Once Configured**

1. To add a payment form to a Post or a Page, simply add the '[wp_payeezy_payment_form]' shortcode to content. 

2. Publish the Post or Page. 

3. That's it! 


== Frequently Asked Questions ==

= Is this plugin an official First Data Payeezy product? =

No. I use to work for First Data supporting their various e-commerce products. This plugin is independent of First Data Payeezy but was built using their [sample code](https://support.payeezy.com/hc/en-us/articles/204011429-Sample-Code-for-Creating-a-Pay-Button-to-use-with-a-Hosted-Payment-Page) on my own time. 


== Screenshots ==

1. Required Settings.
2. Optional Settings. 
3. Optional Payment Fields.
4. Payment Page ID and Transaction Key in Payeezy. 
5. Recurring Billing ID in Payeezy.

== Changelog ==

= 2.67 =

* The transaction key file is now named after the Payment Page ID. This should enable this plugin to be used multisite.
* Added the x_company field as one of the optional fields.
* Add x_description back to the optional fields. I don’t remember ever removing it, so it must have been by mistake. I made it a textarea field since Payeezy doesn’t seem to have any character restrictions. Most fields are caped at 30 characters. This field has no such restrictions. I’ve tested it with hundreds of words without any errors. If you want a field for the cardholder to write a book, this is the one you want to use.
* Removed unnecessary css from the admin screen.

= 2.66 =

* State and Country selectors now show "Select a State" or "Select a Country" instead of the first option.


= 2.65 =

* Changed the way the admin screen is styled.
* Added the state selector and country selector dropdown values in a separate text file.  

= 2.62 =

* Fixed a problem that allowed donors to enter a negative custom amount.

= 2.61 =

* Donors now not continue to First Data without first selecting an amount to donate.
* If for whatever reason the Transaction Key file is blank and needs to be generated, an error message will appear at the top of any Admin screen advising that the "Save Now" button in Payeezy settings needs to be pressed.


= 2.60 =

* Added the ability to change the text on the submit button.
* Direct link to the stylesheet in the plugin editor.
* Added a link to the WordPress plugin repository to make it easier to leave a 5-star (I hope!) review. 
* Added a warning message if the Transaction Key has not been saved. 

= 2.53 =

* Removed break at the end of every label.
* Added an external stylesheet (wp-payeezy-pay/stylesheet.css) for the form so it can be modified, customized, copied, or manipulated. 


= 2.52 =

* Added a break at the end of every label.


= 2.51 =

* Updated screenshots.

= 2.50 =

* Moved Currency Code to the top of Required settings.
* Now generates a message if Payment Page ID, Transaction Key, or Currency Code is not entered.
* Added a link for a new add-on plugin, Payeezy Transactions. 

= 2.45 = 

* Noticed I had placed Alabama twice in the dropdown. 
* Removed the link to WP Payeezy Transactions. I am not ready to make it live yet. 


= 2.40 = 

* Added the ability to hard-code the amount the card holder will pay. 
* Added Response Key so that WP Payeezy Pay will be compatible with WP Payeezy Transactions, a premium add-on.
* Updated the banner image and the icon image. The purple color was irritating me. 

= 2.36 = 

* Removed two breaks and a horizontal line that was causing an annoying space before the form. Thanks Colette!
* Updated the banner image and the icon image so it (hopefully) looks nicer in the plugin repository. 

= 2.35 =

* Fixed a problem with the currency code. 

= 2.31 =

* Fixed an image. 

= 2.30 = 

* Tested to make sure it is compatible with WordPress 4.4.
* Added Currency Code to the required settings. 
* Cleaned up the CSS to make sure everything looks pretty.

= 2.25 = 

* Minor changes involving support links. 

= 2.2 = 

* Now the cardholder making a donation cannot proceed to Payeezy without picking an amount.  

= 2.1 = 

* Made a change that strengthens security of the plugin. The Transaction Key is no longer visable in the HTML form. It's now stored in a tiny file called key.php located in the plugin's directory.   

= 2.0 = 

* Combined this plugin with my other plugin, WP Payeezy Donate. All features found in that plugin are now rolled into this plugin. Going forward, this will be the only plugin updated, assuming updates are needed. If you select a Transaction Type option that supports Recurring and if you save the settings without entering a Recurring Billing ID, an error is displayed. If the mode is set to Demo, it now displays a notice. I also corrected a few typos and commented most of the code.  

= 1.4 = 

* Added the ability to do Recurring.

= 1.3 = 

* Fixed a typo that wasn't allowing x_reference_3 to work. 

= 1.2 = 

* Removed Recurring. Was causing an error if no Recurring Plan ID was entered in the settings. The ability to add Recurring will be added back in a future update. Stay tuned!

= 1.1 = 

* Changed the field values to be required values if they are added to the form. If a cardholder leaves a field blank, they will be told the field is required before proceeding. 

= 1.0 =

* Initial release.


== Upgrade Notice ==

= 2.67 =

* The transaction key file is now named after the Payment Page ID. This should enable this plugin to be used multisite.
* Added the x_company field as one of the optional fields.
* Add x_description back to the optional fields. I don’t remember ever removing it, so it must have been by mistake. I made it a textarea field since Payeezy doesn’t seem to have any character restrictions. Most fields are caped at 30 characters. This field has no such restrictions. I’ve tested it with hundreds of words without any errors. If you want a field for the cardholder to write a book, this is the one you want to use.
* Removed unnecessary css from the admin screen.


= 2.66 =

* State and Country selectors now show "Select a State" or "Select a Country" instead of the first option.


= 2.65 =

* Changed the way the admin screen is styled.
* Added the state selector and country selector dropdown values in a separate text file.  

= 2.62 =

* Fixed a problem that allowed donors to enter a negative custom amount.

= 2.61 =

* Donors now not continue to First Data without first selecting an amount to donate.
* If for whatever reason the Transaction Key file is blank and needs to be generated, an error message will appear at the top of any Admin screen advising that the "Save Now" button in Payeezy settings needs to be pressed.


= 2.60 =

* Added the ability to change the text on the submit button.
* Direct link to the stylesheet in the plugin editor.
* Added a link to the WordPress plugin repository to make it easier to leave a 5-star (I hope!) review. 
* Added a warning message if the Transaction Key has not been saved. 

= 2.53 =

* Removed break at the end of every label.
* Added an external stylesheet (wp-payeezy-pay/stylesheet.css) for the form so it can be modified, customized, copied, or manipulated. 


= 2.52 =

* Added a break at the end of every label.


= 2.51 =

* Updated screenshots.


= 2.50 =

* Moved Currency Code to the top of Required settings.
* Now generates a message if Payment Page ID, Transaction Key, or Currency Code is not entered.
* Added a link for a new add-on plugin, Payeezy Transactions. 


= 2.45 = 

* Noticed I had placed Alabama twice in the dropdown. 
* Removed the link to WP Payeezy Transactions. I am not ready to make it live yet. 


= 2.40 = 

* Added the ability to hard-code the amount the card holder will pay. 
* Added Response Key so that WP Payeezy Pay will be compatible with WP Payeezy Transactions, a premium add-on.
* Updated the banner image and the icon image. The purple color was irritating me. 

= 2.36 = 

* Removed to breaks and a horizontal line that was causing an annoying space before the form. Thanks Colette!
* Updated the banner image and the icon image so it (hopefully) looks nicer in the plugin repository. 

= 2.35 =

* Fixed a problem with the currency code. 

= 2.31 =

* Fixed an image. 

= 2.30 = 

* Tested to make sure it is compatible with WordPress 4.4.
* Added Currency Code to the required settings. 
* Cleaned up the CSS to make sure everything looks pretty.

= 2.25 = 

* Minor changes involving support links. I also added WP dashicons. 

= 2.2 = 

* Now the cardholder making a donation cannot proceed to Payeezy without picking an amount.  

= 2.1 = 

* IMPORTANT! After upgrading, make sure you go into the plugin's settings and press the blue "Save Changes" button at the bottom of the page. I made a somewhat major change that strengthens the security of the plugin. The Transaction Key is no longer visible in the HTML form. It's now stored in a tiny file called key.php located in the plugin's directory.  If you don't press "Save Changes" it will not save the Transaction Key to this new file. I also included an internal style sheet for the form. Each field now has an ID that will make customizing it much easier. 

= 2.0 = 

* Combined this plugin with my other plugin, WP Payeezy Donate. All features found in that plugin are now rolled into this plugin. Going forward, this will be the only plugin updated, assuming updates are needed. If you select a Transaction Type option that supports Recurring and if you save the settings without entering a Recurring Billing ID, an error is displayed. If the mode is set to Demo, it now displays a notice. I also corrected a few typos and commented most of the code.  

= 1.2 = 

I had to remove the ability to do Recurring. Was causing an error if no Recurring Plan ID was entered in the settings. The ability to add Recurring will be added back in a future update. Stay tuned!

= 1.1 =

Fixed form fields so that they are required to be filled in by the cardholder. If you include a field in the form, the cardholder will not be allowed to proceed to Payeezy until they enter something.