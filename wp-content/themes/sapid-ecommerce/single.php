<?php
/**
 * Template used for single posts and other post-types
 * that don't have a specific template.
 *
 * @package Sapid
 * @subpackage Templates
 */

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
  exit( 'Direct script access denied.' );
}
get_header(); ?>
<div class="container">
  <div class="row">
    <section id="content" class="<?php sapid_content_class(); ?>">
      <?php
        while ( have_posts() ) :
          the_post();

          do_action( 'sapid_single_post_before' );
          
          get_template_part( 'template-parts/content', 'single' );
          
          do_action( 'sapid_single_post_after' );

        endwhile; // End of the loop.
      ?>
    </section>
    <?php do_action( 'sapid_sidebar' ); ?>
  </div>
</div>
<?php
get_footer();