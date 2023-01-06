<?php
/**
 * The template for displaying 404 pages (Not Found)
 *
 * @package Sapid
 * @subpackage Templates
 */

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
  exit( 'Direct script access denied.' );
}
get_header(); ?>
<section id="content" class="full-width">
	<div id="post-404page">
		<div class="sapid-post-content post-content container">
			<h1 class="page-title"><?php _e( '404', 'Sapid' ); ?></h1>
			<div class="sapid-post-content-container entry-content">
				<h2><?php _e( 'Oops, This Page Could Not Be Found!', 'Sapid' ); ?></h2>
				<div class="sapid-column sapid-error-page-search">
					<h3><?php esc_html_e( 'Search Our Website', 'Sapid' ); ?></h3>
					<p><?php esc_html_e( 'Can\'t find what you need? Take a moment and do a search below!', 'Sapid' ); ?></p>
					<div class="search-page-search-form">
						<?php echo get_search_form( false ); ?>
					</div>
				</div>
			</div><!-- .page-content -->
		</div>
	</div>
</section>
<?php get_footer(); ?>