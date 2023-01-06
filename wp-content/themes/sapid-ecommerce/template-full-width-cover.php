<?php
/**
 * Template Name: Sapid Full Width Cover
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
<div class="container-fluid">
  <div class="row">
    <section id="content">
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
  </div>
</div>
<?php
get_footer();