<?php
/**
 * Template name:Home
 *
 * @package Sapid
 * @subpackage Templates
 */

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
  exit( 'Direct script access denied.' );
}
?>
<?php get_header();  

    do_action('sapid_sider'); 

    do_action('sapid_home_icon_text'); 

    do_action('sapid_home_featured_product'); 

    do_action('sapid_home_featured_category'); 

    do_action('sapid_home_about_us'); 

    do_action('sapid_home_blogs'); 

get_footer();