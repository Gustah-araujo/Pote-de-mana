<?php

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}

function sapid_options_section_home( $sections ) {
	$sliders = get_posts( array(
		'post_type'      => 'sapid-slider',
		'posts_per_page' => -1,
		'post_status'    => 'publish',
	) );
	$choices = [];
	if(!empty($sliders) && count($sliders) > 0){
		foreach ($sliders as $key => $value) {
			$choices[$value->post_name] = $value->post_title;
		}
	}

	$cat_args = array(
	    'orderby'    => 'name',
	    'order'      => 'asc',
	    'hide_empty' => false,
	);
	 
	$choicescategories = [];
	if ( class_exists( 'WooCommerce' ) ) { 
		$product_categories = get_terms( 'product_cat', $cat_args );
		if(!empty($product_categories) && count($product_categories) > 0){
			foreach ($product_categories as $key => $value) {
				$choicescategories[$value->slug] = $value->name;
			}
		}
	}
	$sections['home'] = [
		'label'    => esc_html__( 'Home Page', 'Sapid' ),
		'id'       => 'home',
		'priority' => 9,
		'icon'     => 'home',
		'fields' => [
           'is_home_slider'                 => [
              'label'           => esc_html__( 'Slider on Home Page', 'Sapid' ),
              'description'     => esc_html__( 'Enable the display of slider on home page by turning it on.', 'Sapid' ),
              'id'              => 'is_home_slider',
              'default'         => '1',
              'type'            => 'switch',
           	],
            "home_slider" => [
                "label" => esc_html__("Home Slider", "Sapid"),
                "description" => esc_html__("Select Slider Home page.", "Sapid"),
                "id" => "home_slider",
                "default" => '',
                "type" => "select",
                "choices" => $choices,
                'data-mode' => '1',
                'data-parent' => 'is_home_slider'
            ],
            'is_home_text'                 => [
              'label'           => esc_html__( 'Icon Text on Home Page', 'Sapid' ),
              'description'     => esc_html__( 'Enable to display icons text on home page by turning it on.', 'Sapid' ),
              'id'              => 'is_home_text',
              'default'         => '1',
              'type'            => 'switch',
           	],
    		'home_text' => [
				'label'           => esc_html__( 'Home Page Icon Text', 'Sapid' ),
				'description'     => esc_html__( '', 'Sapid' ),
				'id'              => 'home_text',
				'default'         => [
					[
						'name'  =>  'Free Shipping',
						'icon'  =>  'mdi-truck',
					],
					[
						'name'  =>  '1 Year Warranty',
						'icon'  =>  'mdi-sticker-emoji',
					],
					[
						'name'  =>  'Secure Payments',
						'icon'  =>  'mdi-cash-check',
					],
					[
						'name'  =>  '24/7 Support',
						'icon'  =>  'mdi-face-agent',
					],
					[
						'name'  =>  'Easy Returns',
						'icon'  =>  'mdi-target-account',
					],

				],
				'type'            => 'repeater',
				'fields'  		  => [
					'name'          => [
						'id'          => 'name',
						'class'       => 'form-control',
						'type'        => 'text',
						'label'       => esc_html__( 'Text', 'Sapid' ),
						'description' => esc_html__( 'Text', 'Sapid' ),
						'default'     => 'none',
					],
					'icon'     => [
						'type'        => 'text',
						'id'          => 'icon',
						'class'       => 'form-control use-material-icon-picker',
						'label'     => esc_attr__( 'Icon', 'Sapid' ),
						'description' => esc_attr__( 'Click an icon to select, click again to deselect.', 'Sapid' ),
						'default'     => '',
					],
				],
				'data-mode' => '1',
				'data-parent' => 'is_home_text'
			],
            'is_home_featured_product'                 => [
              'label'           => esc_html__( 'Featured Product on Home Page', 'Sapid' ),
              'description'     => esc_html__( 'Enable to display featured product on home page by turning it on.', 'Sapid' ),
              'id'              => 'is_home_featured_product',
              'default'         => '1',
              'type'            => 'switch',
           	],
            "home_featured_product_heading" => [
                "label" => esc_html__("Featured Product Heading", "Sapid"),
                "description" => esc_html__("Fill in the text that appears in the Featured product heading.", "Sapid"),
                "id" => "home_featured_product_heading",
                "default" => 'Featured Products',
                "type" => "text",
				'data-mode' => '1',
				'data-parent' => 'is_home_featured_product'
            ],
            "home_featured_product_category" => [
                "label" => esc_html__("Featured Product Category", "Sapid"),
                "description" => esc_html__("Select featured product category.", "Sapid"),
                "id" => "home_featured_product_category",
                "default" => '',
                "type" => "select",
                "choices" => $choicescategories,
				'data-mode' => '1',
				'data-parent' => 'is_home_featured_product'
            ],
            'is_home_featured_category'                 => [
              'label'           => esc_html__( 'Featured Category on Home Page', 'Sapid' ),
              'description'     => esc_html__( 'Enable the display of featured category on home page by turning it on.', 'Sapid' ),
              'id'              => 'is_home_featured_category',
              'default'         => '1',
              'type'            => 'switch',
           	],
            "home_featured_category_heading" => [
                "label" => esc_html__("Featured Category Heading", "Sapid"),
                "description" => esc_html__("Fill in the text that appears in the Featured category heading.", "Sapid"),
                "id" => "home_featured_category_heading",
                "default" => 'Featured Category',
                "type" => "text",
				'data-mode' => '1',
				'data-parent' => 'is_home_featured_category'
            ],
            "home_featured_category" => [
                "label" => esc_html__("Featured Product Category", "Sapid"),
                "description" => esc_html__("Select featured product category.", "Sapid"),
                "id" => "home_featured_category",
                "default" => '',
                'multi' => true,
                "type" => "select",
                "choices" => $choicescategories,
				'data-mode' => '1',
				'data-parent' => 'is_home_featured_category'
            ],
            'is_home_about_section'                 => [
              'label'           => esc_html__( 'About Us Section on Home Page', 'Sapid' ),
              'description'     => esc_html__( 'Enable the display of about us section on home page by turning it on.', 'Sapid' ),
              'id'              => 'is_home_about_section',
              'default'         => '1',
              'type'            => 'switch',
           	],
            "home_about_heading" => [
                "label" => esc_html__("About Us Heading", "Sapid"),
                "description" => esc_html__("Fill in the text that appears in the About Us heading.", "Sapid"),
                "id" => "home_about_heading",
                "default" => 'About Us',
                "type" => "text",
				'data-mode' => '1',
				'data-parent' => 'is_home_about_section'
            ],
            "home_about_text" => [
                "label" => esc_html__("About Us Heading", "Sapid"),
                "description" => esc_html__("Fill in the text that appears in the About Us heading.", "Sapid"),
                "id" => "home_about_text",
                "default" => 'About Us',
                "type" => "textarea",
				'data-mode' => '1',
				'data-parent' => 'is_home_about_section'
            ],
	        "home_about_image" => [
	            "label" => esc_html__("About Us Image", "Sapid"),
	            "description" => esc_html__("For your about us image, choose an image file.","Sapid" ),
	            "id" => "home_about_image",
	            "default" => "/assets/images/thumb.png",
	            "type" => "media",
				'data-mode' => '1',
				'data-parent' => 'is_home_about_section'
	        ],
	        "home_about_call_to_text" => [
                "label" => esc_html__("About Us Call To Text", "Sapid"),
                "description" => esc_html__("Fill in the text that appears in the About Us Call To Text.", "Sapid"),
                "id" => "home_about_call_to_text",
                "default" => 'Read More',
                "type" => "text",
				'data-mode' => '1',
				'data-parent' => 'is_home_about_section'
            ],
	        "home_about_call_to_link" => [
                "label" => esc_html__("About Us Call To Action", "Sapid"),
                "description" => esc_html__("Fill in the text that appears in the About Us Call To Action.", "Sapid"),
                "id" => "home_about_call_to_link",
                "default" => '#',
                "type" => "text",
				'data-mode' => '1',
				'data-parent' => 'is_home_about_section'
            ],
           'is_home_blog_section'                 => [
              'label'           => esc_html__( 'Latest Blog Section on Home Page', 'Sapid' ),
              'description'     => esc_html__( 'Enable the display of latest blog section on home page by turning it on.', 'Sapid' ),
              'id'              => 'is_home_blog_section',
              'default'         => '1',
              'type'            => 'switch',
           	],
           	"home_blog_heading" => [
                "label" => esc_html__("Latest Blog Heading", "Sapid"),
                "description" => esc_html__("Fill in the text that appears in the Blog Heading.", "Sapid"),
                "id" => "home_blog_heading",
                "default" => 'Latest from Our Blog',
                "type" => "text",
				'data-mode' => '1',
				'data-parent' => 'is_home_blog_section'
            ],
		],
	];

	return $sections;
}
?>