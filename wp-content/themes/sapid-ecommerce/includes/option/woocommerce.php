<?php

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}

function sapid_options_section_woocommerce( $sections ) {

	$sections['woocommerce'] = (class_exists( 'WooCommerce' ) ) ? [
		'label'    => esc_html__( 'WooCommerce', 'Sapid' ),
		'id'       => 'heading_woocommerce',
		'priority' => 26,
		'icon'     => 'cart',
		'fields'   => [
			'woo_items' => [
				'label'       => esc_html__( 'WooCommerce Number of Products per Page', 'Sapid' ),
				'description' => esc_html__( 'Controls the number of products that display per page. ', 'Sapid' ),
				'id'          => 'woo-items',
				'default'     => '12',
				'type'        => 'slider',
				'choices'     => [
					'min'  => '1',
					'max'  => '50',
					'step' => '1',
				],
			],
			'woocommerce_shop_page_columns' => [
				'label'           => esc_html__( 'WooCommerce Number of Product Columns', 'Sapid' ),
				'description'     => esc_html__( 'Controls the number of columns for the main shop page.', 'Sapid' ),
				'id'              => 'woocommerce-shop-page-columns',
				'default'         => 4,
				'type'            => 'slider',
				'choices'     => [
					'min'  => 1,
					'max'  => 6,
					'step' => 1,
				],
			],
			'woocommerce_related_product' => [
				'label'           => esc_html__( 'WooCommerce Related Product', 'Sapid' ),
				'description'     => esc_html__( 'Turn on to display the related product single page.', 'Sapid' ),
				'id'              => 'woocommerce-related-product',
				'default'         => '1',
				'type'            => 'switch',
			],
			'woocommerce_related_columns' => [
				'label'           => esc_html__( 'WooCommerce Related/Up-Sell/Cross-Sell Product Number of Columns', 'Sapid' ),
				'description'     => esc_html__( 'Controls the number of columns for the related and up-sell products on single posts and cross-sells on cart page.', 'Sapid' ),
				'id'              => 'woocommerce-related-columns',
				'default'         => 4,
				'type'            => 'slider',
				'choices'     => [
					'min'  => 0,
					'max'  => 6,
					'step' => 1,
				],
				'data-parent' => 'woocommerce-related-product',
				'data-mode'   => '1'
			],
			'woocommerce_acc_link_main_nav' => [
				'label'           => esc_html__( 'WooCommerce My Account Link in Primary Menu', 'Sapid' ),
				'description'     => esc_html__( 'Turn on to display the "My Account" link in the primary menu. Not compatible with other menu plugins.', 'Sapid' ),
				'id'              => 'woocommerce_acc_link_main_nav',
				'default'         => '0',
				'type'            => 'switch',
			],
			'woocommerce_minicart_link_main_nav' => [
				'label'           => esc_html__( 'WooCommerce Mini Cart in Primary Menu', 'Sapid' ),
				'description'     => esc_html__( 'Turn on to display the cart icon in the primary menu. Not compatible with other menu plugins.', 'Sapid' ),
				'id'              => 'woocommerce-minicart-link-main-nav',
				'default'         => '1',
				'type'            => 'switch',
			],
			'woocommerce_acc_link_top_nav' => [
				'label'           => esc_html__( 'WooCommerce My Account Link in Top Menu', 'Sapid' ),
				'description'     => esc_html__( 'Turn on to display the "My Account" link in the Top menu. Not compatible with other menu plugins.', 'Sapid' ),
				'id'              => 'woocommerce-acc-link-top-nav',
				'default'         => '1',
				'type'            => 'switch',
				'data-mode' => 'v2,v3,v4,v5,v6,v7,v8,v9,v10,v11,v12,v13,v14,v15',
				'data-parent' => 'header_layout',
			],
			'product_social_sharing_box' => [
				'label'           => esc_html__( 'WooCommerce Social Icons', 'Sapid' ),
				'description'     => esc_html__( 'Turn on to display the social icons on single product posts.', 'Sapid' ),
				'id'              => 'product-social-sharing-box',
				'default'         => '1',
				'type'            => 'switch',
			],
			'woocommerce_star_rating_show' => [
				'label'           => esc_html__( 'WooCommerce Star Rating Show on Product', 'Sapid' ),
				'description'     => esc_html__( 'Turn on to display the "Star Rating" in product.', 'Sapid' ),
				'id'              => 'woocommerce-star-rating-show',
				'default'         => '1',
				'type'            => 'switch',
			],
			'woo_sale_badge_text' => [
				'label'           => esc_html__( 'WooCommerce Sale Badge Text', 'Sapid' ),
				'description'     => esc_html__( '[percentage] and [value] placeholders can be used to display product discount as percentage or as a value, ex: [percentage] Off!', 'Sapid' ),
				'id'              => 'woo-sale-badge-text',
				'default'         => __( 'Sale!', 'Sapid' ),
				'type'            => 'text',
			],
			'woo_add_to_cart_button_text' => [
				'label'           => esc_html__( 'WooCommerce Add to Cart button Text', 'Sapid' ),
				'description'     => esc_html__( 'WooCommerce Add to Cart button Text', 'Sapid' ),
				'id'              => 'woo-add-to-cart-button-text',
				'default'         => __( 'Add to Cart!', 'Sapid' ),
				'type'            => 'text',
			],
			'woo_outofstock_badge_text' => [
				'label'           => esc_html__( 'WooCommerce Out Of Stock Badge Text', 'Sapid' ),
				'description'     => esc_html__( 'Default value is: Out of stock', 'Sapid' ),
				'id'              => 'woo-outofstock-badge-text',
				'default'         => __( 'Out of stock', 'Sapid' ),
				'type'            => 'text',
			],
		],
	] : [];

	return $sections;

}
