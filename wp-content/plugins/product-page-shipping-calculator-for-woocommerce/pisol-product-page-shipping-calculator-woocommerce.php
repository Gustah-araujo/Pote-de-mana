<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              piwebsolution.com
 * @since             1.3.11
 * @package           Pisol_Product_Page_Shipping_Calculator_Woocommerce
 *
 * @wordpress-plugin
 * Plugin Name:       Product page shipping calculator for WooCommerce
 * Plugin URI:        piwebsolution.com/woocommerce-shipping-calculator
 * Description:       Product page shipping calculator for WooCommerce
 * Version:           1.3.11
 * Author:            PI Websolution
 * Author URI:        piwebsolution.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       pisol-product-page-shipping-calculator-woocommerce
 * Domain Path:       /languages
 * WC tested up to:   7.2.2
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
if(!is_plugin_active( 'woocommerce/woocommerce.php')){
    function pisol_ppscw_free_woo() {
        ?>
        <div class="error notice">
            <p><?php _e( 'Please Install and Activate WooCommerce plugin, without that this plugin cant work', 'pisol-product-page-shipping-calculator-woocommerce' ); ?></p>
        </div>
        <?php
    }
    add_action( 'admin_notices', 'pisol_ppscw_free_woo' );
    return;
}

function pisol_ppscw_estimate_pro_present(){
    include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
    if(is_plugin_active( 'estimate-delivery-date-for-woocommerce-pro/pi-edd.php') && version_compare(PI_EDD_VERSION, '4.5','>=')){
        return true;
    }
    return false;
}

/**
 * Currently plugin version.
 * Start at version 1.3.11 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'PISOL_PRODUCT_PAGE_SHIPPING_CALCULATOR_WOOCOMMERCE_VERSION', '1.3.11' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-pisol-product-page-shipping-calculator-woocommerce-activator.php
 */
function activate_pisol_product_page_shipping_calculator_woocommerce() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-pisol-product-page-shipping-calculator-woocommerce-activator.php';
	Pisol_Product_Page_Shipping_Calculator_Woocommerce_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-pisol-product-page-shipping-calculator-woocommerce-deactivator.php
 */
function deactivate_pisol_product_page_shipping_calculator_woocommerce() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-pisol-product-page-shipping-calculator-woocommerce-deactivator.php';
	Pisol_Product_Page_Shipping_Calculator_Woocommerce_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_pisol_product_page_shipping_calculator_woocommerce' );
register_deactivation_hook( __FILE__, 'deactivate_pisol_product_page_shipping_calculator_woocommerce' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-pisol-product-page-shipping-calculator-woocommerce.php';

add_action( 'plugin_action_links_' . plugin_basename( __FILE__ ),  'pisol_product_page_shipping_method_plugin_link' );

function pisol_product_page_shipping_method_plugin_link( $links ) {
    $links = array_merge( array(
        '<a href="' . esc_url( admin_url( '/admin.php?page=pisol-shipping-calculator-setting' ) ) . '">' . __( 'Settings', 'pisol-product-page-shipping-calculator-woocommerce' ) . '</a>',
        '<a style="color:#0a9a3e; font-weight:bold;" target="_blank" href="https://wordpress.org/support/plugin/product-page-shipping-calculator-for-woocommerce/reviews/#bbp_topic_content">' . __( 'GIVE SUGGESTION','pisol-product-page-shipping-calculator-woocommerce' ) . '</a>'
    ), $links );
    return $links;
}

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.3.11
 */
function run_pisol_product_page_shipping_calculator_woocommerce() {

	$plugin = new Pisol_Product_Page_Shipping_Calculator_Woocommerce();
	$plugin->run();

}
run_pisol_product_page_shipping_calculator_woocommerce();
