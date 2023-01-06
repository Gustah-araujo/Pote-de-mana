<?php
/**
 * The template for displaying search result
 *
 * @package Sapid
 * @subpackage Templates
 */

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
  exit( 'Direct script access denied.' );
}
$show_search_field = sapid_get_theme_option('search-input');
get_header(); ?>
<div class="container">
  <div class="row">
    <section id="content" class="<?php sapid_content_class(); ?>">
		  <?php if ( have_posts() ) : ?>
				<?php  if(!empty($show_search_field)) { ?> <!-- condition for search field show or not  -->
					<div class="search-page-search-form">
						<h1 class="entry-title sapid-post-title"><?php esc_html_e('Need a new search?', 'Sapid' ); ?></h1>
						<p><?php esc_html_e( 'If you didn\'t find what you were looking for, try a new search!', 'Sapid' ); ?></p>
						<?php get_search_form(); ?>
					</div>
				<?php } ?>	
					<?php get_template_part( 'template-parts/content', 'loop' ); ?>
			<?php else : ?>
				<div class="post-content">
					<h2 class="page-title"><?php esc_html_e('Couldn\'t find what you\'re looking for!', 'Sapid' ); ?></h2>
					<div class="error-page">
						<div class="sapid-column sapid-error-page-search">
								<h3><?php esc_html_e( 'Try again', 'Sapid' ); ?></h3>
								<p><?php esc_html_e( 'If you want to rephrase your query, here is your chance:', 'Sapid' ); ?></p>
								<div class="search-page-search-form">
									<?php echo get_search_form( false ); ?>
								</div>
							</div>
						</div>
					</div>
				</div>
			<?php endif; ?>
		</section>
    <?php do_action( 'sapid_sidebar' ); ?>
   </div>
</div>
<?php
get_footer();