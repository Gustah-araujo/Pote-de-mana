<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       piwebsolution.com
 * @since      1.0.0
 *
 * @package    Pisol_Product_Page_Shipping_Calculator_Woocommerce
 * @subpackage Pisol_Product_Page_Shipping_Calculator_Woocommerce/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Pisol_Product_Page_Shipping_Calculator_Woocommerce
 * @subpackage Pisol_Product_Page_Shipping_Calculator_Woocommerce/includes
 * @author     PI Websolution <sales@piwebsolution.com>
 */
class Pisol_Product_Page_Shipping_Calculator_Woocommerce_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'pisol-product-page-shipping-calculator-woocommerce',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
