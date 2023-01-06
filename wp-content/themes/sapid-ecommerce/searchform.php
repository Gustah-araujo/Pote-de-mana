<?php
/**
 * The search-form template.
 *
 * @package Sapid
 * @subpackage Templates
 */

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
  exit( 'Direct script access denied.' );
}
$search_form_design = sapid_get_theme_option('search-form-design'); //search form design type
$live_search = sapid_get_theme_option('live-search'); //live search 

$class = '';

if ( $live_search ) {
  $class .= ' sapid-live-search';
}

$class .= ' sapid-search-form-classic';
$btnClass = 'bg-dark rounded-end';
$iconClass = ' text-white';
$inputClass = ' rounded-0 rounded-start';

?>
<form role="search" method="get" class="search-form<?php echo esc_attr( $class ); ?>" action="<?php echo esc_url( home_url( '/' ) ); ?>"> 
  <div class="d-flex sapid-search-form-content">
  	<div class="sapid-search-field w-100">
    	<label class="w-100">
      	<span class="screen-reader-text">Search for:</span>
				<?php 
				if ( $live_search ) : ?>
				<input type="search" class="s sapid-live-search-input form-control search-field height-50 pt-2 pb-2<?php echo $inputClass; ?>" name="s"  autocomplete="off" placeholder="Search..." required aria-required="true" aria-label="Search..."/>
				<?php else : ?>
				<input type="search" value="<?php echo get_search_query(); ?>" name="s" class="s form-control search-field height-50 pt-2 pb-2<?php echo $inputClass; ?>" placeholder="Search..." required aria-required="true" aria-label="Search..."/>
				<?php endif; ?>
      </label>
    </div>
   	<div class="sapid-search-button search-button d-flex <?php echo $btnClass; ?>">
    	<button class="btn search-submit sapid-search-submit searchsubmit fs-4">
      	<i class="mdi mdi-magnify<?php echo $iconClass; ?>"></i>   
      </button>
   	</div>
	</div>
	<?php if ( $live_search )  : ?>
		<div class="sapid-search-results-wrapper"><div class="sapid-search-results"></div></div> 
	<?php endif; ?>
</form>