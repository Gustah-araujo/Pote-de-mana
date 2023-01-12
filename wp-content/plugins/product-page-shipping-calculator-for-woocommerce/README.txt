=== Product page shipping calculator for WooCommerce ===
Contributors: rajeshsingh520
Donate link: piwebsolution.com
Tags: shipping calculator, shipping estimate, shipping cost, check woocommerce pincode, check woocommerce shipping
Requires at least: 3.0.1
Tested up to: 6.1.1
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

This plugin allows you to show shipping methods available on the product page for the WooCommerce. So customer can see if shipping is available to his location and at what cost 

== Description ==

&#9989; Allow your customer to **calculate shipping** before adding product to the cart.

&#9989; Check **available shipping methods** to your area

&#9989; Customer can know if the **product can be shipped to there location or not**, so they don't have to go to checkout page to find out that you don't ship to there area

&#9989; Plugin show the available shipping method even when customer has not added his address, plugin show the method based on the shipping zone assigned to customer by WooCommerce

&#9989; He can **change the delivery location** and he can see the changed cost and shipping method available for that particular location

&#9989; All the **calculation is done on Ajax** so no page reload is needed, and page caching will not affect it as well

&#9989; **Change the position** of the calculator on product page to be above add to cart button or below add to cart button

&#9989; It support **WPML and Polylang**

&#9989; Disable **auto loading** of the Shipping method 

&#9989; Select different **position for the result** from the given 3 positions

&#9989; Disable shipping calculator on specific product

&#9989; Remove state field from the calculator form or address form, do this only if your shipping zones are not dependent on the state

&#9989; Remove city field from the calculator form or address form

&#9989; Remove postcode field, do this only if your shipping zones are not dependent on the postcode 

&#9989; **Remove country** field from the calculator form or address form **(only works when you Ship to a single country)**

&#9989; Consider the quantity user has added in the Quantity field on the product page, and show shipping charge as per that quantity. (Consider quantity option is disabled by default so you need to enable it)
When this option is enabled:

`
When product A is not in cart = shipping will be shown as per the quantity set in the quantity field
    
When product A is present in the cart  = Shipping will be shown as per the quantity set in the quantity field plus the quantity present in the Cart
`

&#9989; This plugin is compatible with our [PRO Estimate delivery date plugin](https://www.piwebsolution.com/product/pro-estimate-delivery-date-for-woocommerce/?utm_source=product-page-shipping-calculator-description&utm_medium=display&utm_campaign=product-page-shipping-calculator), So you can show estimate delivery date for each of the shipping method 

&#9989; Show the location selection box inside a popup

&#9989; Working of the popup: 

Use to get location = In this mode form is only used to get the user location in the popup
    
Show if shipping is available  = In this mode popup is used to take the location and also show the message where shipping is done to that location or not.

For plugin to show shipping is available message there should be a shipping zone present with a shipping method. If there is not shipping zone available matching the user location or if there is zone but there is no shipping method then it will return the message No shipping available for the location.

Show if shipping is available based and also show shipping methods = In this mode it will show the message plus all the shipping method available in that zone

&#9989; you can add the address insertion form by short code as well [pi_address_form]

&#9989; You can check if shipping or delivery is available in particular postcode/zip-code or not

&#9989; Use our PRO Estimate date and time plugin along with this plugin to show estimate delivery date for the customer location

&#9989; [Compatible with WPML](https://wpml.org/plugin/product-page-shipping-calculator-for-woocommerce/)

= Explore our other plugins supercharge your WordPress website: =
<ol>
<li><a href="https://wordpress.org/plugins/estimate-delivery-date-for-woocommerce/">WooCommerce estimated delivery date per product | shipping date per product</a></li>
</ol>

== Frequently Asked Questions ==

= Can I change it as per my language =
Yes you can add your language to the plugin

= Can we show estimate date of each of the shipping method =
When you will use this plugin along with our [PRO Estimate delivery date plugin](https://www.piwebsolution.com/product/pro-estimate-delivery-date-for-woocommerce/?utm_source=product-page-shipping-calculator-description&utm_medium=display&utm_campaign=product-page-shipping-calculator) then you will be able to show the estimate date for each of the shipping method

= Will it show shipping tax =
It follows your WooCommerce Tax setting, so if you have set it to show price including tax then it will show the shipping cost including tax next to the shipping method, but if you have configured it wo show cost excluding tax then it will show only cost and not tax

= Can I change the position of the calculator =
Yes, at preset we have given 2 position option one is above and below the add to cart button on product page.

= Don't want shipping to be calculated automatically =
There is an option to disable the auto loading of estimate, once disabled the estimate will not load automatically, user will have to manually get it calculated

= I want to change the position of the shipping method result =
Plugin gives you 4 position where result can be shown,
1) After calculate shipping button
2) Before calculate shipping button
3) Before calculate shipping form (inside hidden container)
4) After calculate shipping form (inside hidden container)
the position 3 and 4 are inside the container that is hidden click user click on "Calculate shipping button

= The shipping cost is shown as per 1 unit of the product instead of the quantity present in the quantity field =
Set the option "Product Quantity field" to "Consider product quantity field", then the plugin will consider the quantity set in the quantity field to show the shipping method
When this option is enabled:
When product A is not in cart = shipping will be shown as per the quantity set in the quantity field
when product A is present in the cart  = Shipping will be shown as per the quantity set in the quantity field plus the quantity present in the Cart

= Setting default country in the form =
The country of the shop set in the (WooCommerce > settings > General) is the default selected country in the calculator form

= Can I add address Form on some specific page using short code =
Yes you can add that by short code [pi_address_form] and you can set 
Popup Tab > Working of popup  as "Show if shipping is available based and also show shipping methods" so it can show shipping method for the added address

= I want to remove the state field from the calculator form =
Yes you can do that from the Remove fields setting Tab

= I want to remove the postcode field =
Yes you can do that from the Remove fields setting Tab

= I want to remove country field =
Yes if you ship to single country only then you can remove country field as well

= I want to remove the Country field, but the option is disabled for me =
This option is only available when you ship to single country only, so if you ship to single country then Go in WooCommerce > Settings > General and configure your "Shipping location(s)" to a single country once done then this option to remove country will be available to you 



== Changelog ==
= 1.3.11 =
* Option to show zero rate next to free shipping method 

= 1.3.7 =
* Made compatible with PHP 8.1