<?php
/**
 * Archives template.
 *
 * @package Sapid
 * @subpackage Templates
 */
   
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
  exit( 'Direct script access denied.' );
}
?>
<?php
get_header(); ?>
<div class="container">
   <div class="row">
      <section id="content" class="<?php sapid_content_class(); ?>">
         <?php 
            if ( have_posts() ) :
               get_template_part( 'template-parts/content', 'loop' );
            endif;
         ?>
      </section>    
      <?php do_action( 'sapid_sidebar' ); ?>
   </div>
</div>
<?php
get_footer();