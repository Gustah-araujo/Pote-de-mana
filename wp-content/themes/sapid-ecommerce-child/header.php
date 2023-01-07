<?php
/**
 * Header template.
 *
 * @package Sapid
 * @subpackage Templates
 */

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
    exit( 'Direct script access denied.' );
}
?>
<!DOCTYPE html>
<html class="<?php sapid_the_html_class(); ?>" <?php language_attributes(); ?>>
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <?php wp_head(); ?>
    <?php
    echo apply_filters( 'sapid_space_head', sapid_get_theme_option( 'space-head' ) );
    ?>
</head>
<?php
$wrapper_class  = 'sapid-wrapper';
?>
<body <?php body_class(); ?>>
    <?php do_action( 'sapid_before_body_content' ); ?>
    <div id="boxed-wrapper">
        <div id="wrapper" class="<?php echo esc_attr( $wrapper_class ); ?>">
            <?php do_action( 'sapid_header' ); ?>
            <main id="main" class="site-main" role="main">
                <?php sapid_breadcrumbs(); ?>
                    <div class="sapid-row" style="">