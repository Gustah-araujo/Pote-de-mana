<?php
/**
 * Pagination - Show numbered pagination for catalog pages
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/pagination.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.3.1
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$total   = isset( $total ) ? $total : wc_get_loop_prop( 'total_pages' );
$current = isset( $current ) ? $current : wc_get_loop_prop( 'current_page' );
$base    = isset( $base ) ? $base : esc_url_raw( str_replace( 999999999, '%#%', remove_query_arg( 'add-to-cart', get_pagenum_link( 999999999, false ) ) ) );
$format  = isset( $format ) ? $format : '';

if ( $total <= 1 ) {
	return;
}

$woo_pagination_alignment = sapid_get_theme_option( 'woo-pagination-alignment' ); // For portfolio text alignment left | center | right

if($woo_pagination_alignment == 'left'){ //  if vlaue is left
    $justify_class   = 'justify-content-start text-start';
}elseif($woo_pagination_alignment == 'right'){
    $justify_class   = 'justify-content-end text-end'; // if vlaue is right
}else{
    $justify_class   = 'justify-content-center text-center';
}

?>
<nav class="woocommerce-pagination">
	<?php
	$paginate_links = paginate_links(
		apply_filters(
			'woocommerce_pagination_args',
			array( // WPCS: XSS ok.
				'base'      => $base,
				'format'    => $format,
				'add_args'  => false,
				'current'   => max( 1, $current ),
				'total'     => $total,
				'prev_text' => '<span class="page-prev mdi mdi-chevron-left"></span><span class="page-text">' . esc_html__( 'Previous', 'Sapid' ) . '</span>',
				'next_text' => '<span class="page-text">' . esc_html__( 'Next', 'Sapid' ) . '</span><span class="page-next mdi mdi-chevron-right"></span>',
				'type'      => 'array',
				'end_size'  => sapid_get_theme_option( 'pagination-range' ),
				'mid_size'  => sapid_get_theme_option( 'pagination-start-end-range' ),
			)
		)
	);
	if ( is_array( $paginate_links ) ) { ?>
        <ul class="pagination sapid-pagination clearfix mt-0 mb-5 <?php echo $justify_class; ?>">
	        <?php foreach ($paginate_links as $paginate_link) { ?>
	            <li class="page-item">
	                <?php
	                $paginate_link = str_replace( 'page-numbers', 'page-link', $paginate_link );
	                echo wp_kses_post($paginate_link)
	                ?>
	            </li>     
	        <?php }  ?>  
        </ul>
    <?php }  ?>
</nav>