<?php
/**
 * The Sidebar containing the main widget area
 * @package Sapid
 */

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
$classes ='';
if(!empty($sidebar_position)){
   if($sidebar_position =='Left'){
      $classes = ' order-1';
   }else{
      $classes = ' order-2'; 
   }
}
if(!empty($sidebar)){
?>
<div id="sidebar" class="sidebar sapid-sidebar sidebar-widget-area col-sm-3<?php echo $classes; ?>">
    <?php dynamic_sidebar( $sidebar ); ?>
</div><!-- #sidebar -->
<?php } ?>