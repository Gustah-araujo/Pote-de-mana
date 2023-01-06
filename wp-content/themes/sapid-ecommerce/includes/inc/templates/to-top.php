<?php
/**
 * To-Top template.
 * @package Sapid
 */

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
$totopClass = ' totop-left';
$status_totop = sapid_get_theme_option( 'status-totop' );
if (!empty($status_totop )) { ?>
	   <button onclick="topFunction()" id="myBtn" class="bg-grad<?php echo $totopClass; ?>" title="Go to top"><i class="mdi mdi-arrow-up"></i></button>
	<?php
}
