<?php
/**
 * Template used for pages.
 *
 * @package Sapid
 * @subpackage Templates
 */

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
  exit( 'Direct script access denied.' );
}
?>
<?php get_header(); ?>
<div class="container">
  <div class="row">
    <section id="content" class="<?php sapid_content_class(); ?>">
      <?php 
        while ( have_posts() ) :
          the_post();

          do_action( 'sapid_page_before' );
          
          get_template_part( 'template-parts/content', 'page' );

          /**
           * Functions hooked in to sapid_page_after action
           *
           * @see sapid_display_comments - 10
           */
          do_action( 'sapid_page_after' );
         
        endwhile; // End of the loop.
      ?>
    </section>
    <?php do_action( 'sapid_sidebar' ); ?>
  </div>
</div>
<?php
get_footer();