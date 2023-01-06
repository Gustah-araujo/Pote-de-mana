<?php

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}

function sapid_options_section_sidebars( $sections ) {
	$sidebars['None'] = 'None';
	foreach ( $GLOBALS['wp_registered_sidebars'] as $sidebar ) { 
		$sidebars[$sidebar['id']] = $sidebar['name'];
	}

	$sections['sidebars'] = [
		'label'    => esc_html__( 'Sidebars', 'Sapid' ),
		'id'       => 'heading_sidebars',
		'is_panel' => true,
		'priority' => 10,
		'icon'     => 'page-layout-sidebar-left',
		'fields'   => [
			'pages_sidebars_section'                       => [
				'label'  => esc_html__( 'Pages', 'Sapid' ),
				'id'     => 'pages_sidebars_section',
				'icon'   => true,
				'type'   => 'sub-section',
				'fields' => [
					'is_page_sidebar' => [
						'label'           => esc_html__( 'Show Sidebar For Pages', 'Sapid' ),
						'description'     => esc_html__( 'Enable if you want the same sidebars to appear on all pages except HomePage.', 'Sapid' ),
						'id'              => 'is-page-sidebar',
						'default'         => '0',
						'type'            => 'switch',
					],
					'page_sidebar'        => [
						'label'           => esc_html__( 'Page Sidebar ', 'Sapid' ),
						'description'     => esc_html__( 'Select sidebar that will display on all pages.', 'Sapid' ),
						'id'              => 'page-sidebar',
						'default'         => 'None',
						'type'            => 'select',
						'data-mode'   => '1',
						'data-parent' => 'is-page-sidebar',
						'choices'        =>  $sidebars
					],
					'page_sidebar_position'  => [
						'label'           => esc_html__( 'Page Sidebar Position', 'Sapid' ),
						'description'     => esc_html__( 'Controls the position (left & right) of sidebar for all pages.', 'Sapid' ),
						'id'              => 'page-sidebar-position',
						'default'         => 'Right',
						'type'            => 'radio-buttonset',
						'data-mode'   => '1',
						'data-parent' => 'is-page-sidebar',
						'choices'         => [
							'Left'  => esc_html__( 'Left', 'Sapid' ),
							'Right' => esc_html__( 'Right', 'Sapid' ),
						],
					],
				],
			],
			'post_category_sidebar_section'                  => [
				'label'       => esc_html__( 'Blog Archive / Category', 'Sapid' ),
				'description' => '',
				'id'          => 'post_category_sidebar_section',
				'icon'        => true,
				'type'        => 'sub-section',
				'fields'      => [
					'is_post_category_sidebar'  => [
						'label'       => esc_html__( 'Sidebars For Blog Archive / Category', 'Sapid' ),
						'description' => esc_html__( 'You can use the same sidebars on each blog post by turning it on.', 'Sapid' ),
						'id'          => 'is-post-category-sidebar',
						'default'     => '0',
						'type'        => 'switch',
					],
					'post_category_sidebar'         => [
						'label'         => esc_html__( 'Blog Post Sidebar', 'Sapid' ),
						'description'   => esc_html__( 'Choose sidebar to appear on all blog posts.', 'Sapid' ),
						'id'            => 'post-category-sidebar',
						'default'       => 'None',
						'type'          => 'select',
						'data-parent'   => 'is-post-category-sidebar',
						'data-mode'     => '1',
						'choices'       =>  $sidebars
					],
					'post_category_sidebar_position' => [
						'label'       => esc_html__( 'Blog Sidebar Position', 'Sapid' ),
						'description' => esc_html__( 'Manage the position of sidebar for archive pages and blog posts.', 'Sapid' ),
						'id'          => 'post-category-sidebar-position',
						'default'     => 'Right',
						'type'        => 'radio-buttonset',
						'data-parent' => 'is-post-category-sidebar',
						'data-mode'   => '1',
						'choices'     => [
							'Left'  => esc_html__( 'Left', 'Sapid' ),
							'Right' => esc_html__( 'Right', 'Sapid' ),
						],
					],
				],
			],
			'post_single_sidebar_section' => [
				'label'       => esc_html__( 'Blog Single', 'Sapid' ),
				'description' => '',
				'id'          => 'post_single_sidebar_section',
				'icon'        => true,
				'type'        => 'sub-section',
				'fields'      => [
					'is_post_single_sidebar'   => [
						'label'           => esc_html__( 'Sidebars For Blog Single Posts', 'Sapid' ),
						'description'     => esc_html__( 'Turn on if you’re willing to use the exact sidebars on all old blog posts. The page choices are replaced by this option.', 'Sapid' ),
						'id'              => 'is-post-single-sidebar',
						'default'         => '0',
						'type'            => 'switch',
					],
					'post_single_sidebar'             => [
						'label'           => esc_html__( 'Single Blog Sidebar Type', 'Sapid' ),
						'description'     => esc_html__( 'Choose sidebar to appear on the single blog page.', 'Sapid' ),
						'id'              => 'post-single-sidebar',
						'default'         => 'None',
						'type'            => 'select',
						'data-parent'     => 'is-post-single-sidebar',
						'data-mode'       => '1',
						'choices'        =>  $sidebars
					],
					'post_single_sidebar_position' => [
						'label'           => esc_html__( 'Single Blog Sidebar Position', 'Sapid' ),
						'description'     => esc_html__( "Controls the placement of the single blog page's sidebar.", 'Sapid' ),
						'id'              => 'post-single-sidebar-position',
						'default'         => 'Right',
						'type'            => 'radio-buttonset',
						'data-parent'     => 'is-post-single-sidebar',
						'data-mode'       => '1',
						'choices'         => [
							'Left'  => esc_html__( 'Left', 'Sapid' ),
							'Right' => esc_html__( 'Right', 'Sapid' ),
						],
					],
				],
			],
			'search_sidebars_section'                      => [
				'label'       => esc_html__( 'Search Page', 'Sapid' ),
				'description' => '',
				'id'          => 'search_only',
				'icon'        => true,
				'type'        => 'sub-section',
				'fields'      => [
					'is_search_page_sidebar'   => [
						'label'           => esc_html__( 'Sidebars For Search Page', 'Sapid' ),
						'description'     => esc_html__( 'Turn on if you’re willing to use the exact sidebars on all old blog posts.', 'Sapid' ),
						'id'              => 'is-search-page-sidebar',
						'default'         => '0',
						'type'            => 'switch',
					],
					'search_sidebar'          => [
						'label'           => esc_html__( 'Search Page Sidebar Type', 'Sapid' ),
						'description'     => esc_html__( 'Choose sidebar that you want to get appeared on the SERPs.', 'Sapid' ),
						'id'              => 'search-sidebar',
						'default'         => 'Search Sidebar',
						'type'            => 'select',
						'data-parent'     => 'is-search-page-sidebar',
						'data-mode'       => '1',
						'choices'        =>  $sidebars
					],
					'search_sidebar_position' => [
						'label'           => esc_html__( 'Search Sidebar Position', 'Sapid' ),
						'description'     => esc_html__( 'Controls the position of sidebar for the SERPs.', 'Sapid' ),
						'id'              => 'search-sidebar-position',
						'default'         => 'Right',
						'type'            => 'radio-buttonset',
						'data-parent'     => 'is-search-page-sidebar',
						'data-mode'       => '1',
						'choices'         => [
							'Left'  => esc_html__( 'Left', 'Sapid' ),
							'Right' => esc_html__( 'Right', 'Sapid' ),
						],
					],
				],
			],
		],
	];
	$sections['sidebars']['fields']['woocommerce_sidebars_section'] = (class_exists( 'WooCommerce' ) ) ? [
		'label'       => esc_html__( 'Woocommerce Sidebar', 'Sapid' ),
		'description' => '',
		'id'          => 'woocommerce_sidebars_section',
		'icon'        => true,
		'type'        => 'sub-section',
		'fields'      => [
			'is_shop_category_page_sidebar'   => [
				'label'           => esc_html__( 'Sidebars For Woocommerce Category / Shop Page', 'Sapid' ),
				'description'     => esc_html__( 'Turn on if you’re willing to use the exact sidebars on category / shop page.', 'Sapid' ),
				'id'              => 'is-shop-category-page-sidebar',
				'default'         => '0',
				'type'            => 'switch',
			],
			'shop_category_sidebar'          => [
				'label'           => esc_html__( 'Woocommerce Category / Shop Page Sidebar Type', 'Sapid' ),
				'description'     => esc_html__( 'Choose sidebar that you want to get appear on category / shop page.', 'Sapid' ),
				'id'              => 'shop-category-sidebar',
				'default'         => 'none',
				'type'            => 'select',
				'data-parent'     => 'is-shop-category-page-sidebar',
				'data-mode'       => '1',
				'choices'        =>  $sidebars
			],
			'shop_category_sidebar_position' => [
				'label'           => esc_html__( 'Woocommerce Category / Shop Page Sidebar Position', 'Sapid' ),
				'description'     => esc_html__( 'Controls the position of sidebar for category / shop page.', 'Sapid' ),
				'id'              => 'shop-category-sidebar-position',
				'default'         => 'Right',
				'type'            => 'radio-buttonset',
				'data-parent'     => 'is-shop-category-page-sidebar',
				'data-mode'       => '1',
				'choices'         => [
					'Left'  => esc_html__( 'Left', 'Sapid' ),
					'Right' => esc_html__( 'Right', 'Sapid' ),
				],
			],
			'woocommerce_page_sidebars'         => [
				'label'       => esc_html__( 'Woocommerce Pages( Cart / Checkout / My Account )', 'Sapid' ),
				'description' => '',
				'id'          => 'woocommerce_page_sidebars',
				'icon'        => true,
				'type'        => 'info',
			],
			'is_woocommerce_page_sidebar'   => [
				'label'           => esc_html__( 'Sidebars For Woocommerce Pages( Cart / Checkout / My Account )', 'Sapid' ),
				'description'     => esc_html__( 'Turn on if you’re willing to use the exact sidebars on all woocommerce pages (Cart / Checkout / My Account).', 'Sapid' ),
				'id'              => 'is-woocommerce-page-sidebar',
				'default'         => '0',
				'type'            => 'switch',
			],
			'woocommerce_page_sidebar'          => [
				'label'           => esc_html__( 'Woocommerce Pages Sidebar Type', 'Sapid' ),
				'description'     => esc_html__( 'Choose sidebar that you want to get appear on the woocommerce pages ( Cart / Checkout / My Account ).', 'Sapid' ),
				'id'              => 'woocommerce-page-sidebar',
				'default'         => 'none',
				'type'            => 'select',
				'data-parent'     => 'is-woocommerce-page-sidebar',
				'data-mode'       => '1',
				'choices'        =>  $sidebars
			],
			'woocommerce_page_sidebar_position' => [
				'label'           => esc_html__( 'Woocommerce Pages Sidebar Position', 'Sapid' ),
				'description'     => esc_html__( 'Controls the position of sidebar for the woocommerce pages ( Cart / Checkout / My Account ).', 'Sapid' ),
				'id'              => 'woocommerce-page-sidebar-position',
				'default'         => 'Right',
				'type'            => 'radio-buttonset',
				'data-parent'     => 'is-woocommerce-page-sidebar',
				'data-mode'       => '1',
				'choices'         => [
					'Left'  => esc_html__( 'Left', 'Sapid' ),
					'Right' => esc_html__( 'Right', 'Sapid' ),
				],
			],
			'woocommerce_single_product_page_sidebars'         => [
				'label'       => esc_html__( 'Woocommerce Single Product Page', 'Sapid' ),
				'description' => '',
				'id'          => 'woocommerce_single_product_page_sidebars',
				'icon'        => true,
				'type'        => 'info',
			],
			'is_single_product_page_sidebar'   => [
				'label'           => esc_html__( 'Sidebars For Woocommerce Single Product Page', 'Sapid' ),
				'description'     => esc_html__( 'Turn on if you’re willing to use the exact sidebars on single product page.', 'Sapid' ),
				'id'              => 'is-single-product-page-sidebar',
				'default'         => '0',
				'type'            => 'switch',
			],
			'single_product_sidebar'          => [
				'label'           => esc_html__( 'Woocommerce Single Product Page Sidebar Type', 'Sapid' ),
				'description'     => esc_html__( 'Choose sidebar that you want to get appear on single product page.', 'Sapid' ),
				'id'              => 'single-product-sidebar',
				'default'         => 'none',
				'type'            => 'select',
				'data-parent'     => 'is-single-product-page-sidebar',
				'data-mode'       => '1',
				'choices'        =>  $sidebars
			],
			'single_product_sidebar_position' => [
				'label'           => esc_html__( 'Woocommerce Single Product Page Position', 'Sapid' ),
				'description'     => esc_html__( 'Controls the position of sidebar for single product page.', 'Sapid' ),
				'id'              => 'single-product-sidebar-position',
				'default'         => 'Right',
				'type'            => 'radio-buttonset',
				'data-parent'     => 'is-single-product-page-sidebar',
				'data-mode'       => '1',
				'choices'         => [
					'Left'  => esc_html__( 'Left', 'Sapid' ),
					'Right' => esc_html__( 'Right', 'Sapid' ),
				],
			],
		],
	] : [];
   return $sections;

}