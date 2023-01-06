<?php
/**
 * Sapid functions and definitions
 *
 * @package WordPress
 * @subpackage Sapid
 * @since Sapid 1.0
*/

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}

require_once get_template_directory() . '/includes/class-sapid.php';
require_once get_template_directory() . '/includes/class-sapid-main.php';
require_once get_template_directory() . '/includes/class-sapid-head.php';
require_once get_template_directory() . '/includes/class-sapid-post-types.php';
require_once get_template_directory() . '/includes/inc/sapid-sidebar.php';
require_once get_template_directory() . '/includes/inc/sapid-function.php';
require_once get_template_directory() . '/includes/inc/sapid-widgets.php';
require_once get_template_directory() . '/includes/inc/sapid-menu-walker.php';
require_once get_template_directory() . '/includes/inc/sapid-tgm.php';

if ( class_exists( 'WooCommerce' ) ) {
    require_once get_template_directory() . '/includes/class-sapid-woocommerce.php';
}