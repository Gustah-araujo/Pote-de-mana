<?php

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}

function sapid_options_section_blog( $sections ) {

	$sections['blog'] = [
		'label'    => esc_html__( 'Blog', 'Sapid' ),
		'id'       => 'blog',
		'icon'     => 'file-edit-outline',
		'fields'   => [
			'blog_archive_columns'            => [
				'label'           => esc_html__( 'Number of Columns in a Category/ Blog Archive', 'Sapid' ),
				'description'     => __( 'For blog archive pages, select the number of columns per row.', 'Sapid' ),
				'id'              => 'blog-archive-columns',
				'default'         => 1,
				'type'            => 'slider',
				'choices'         => [
					'min'  => 1,
					'max'  => 6,
					'step' => '1',
				],
			],	
			'excerpt_display'          => [
				'label'       => esc_html__( 'Excerpt Display ', 'Sapid' ),
				'description' => esc_html__( 'Manage whether or not the blog excerpt appears for the specified blog page.', 'Sapid' ),
				'id'          => 'excerpt-display',
				'default'         => '0',
				'type'            => 'switch',
			],
			'blog_result_meta'                                  => [
				'label'           => esc_html__( 'General Blog Meta', 'Sapid' ),
				'description'     => esc_html__( 'Make post meta visible by turning it on.', 'Sapid' ),
				'id'              => 'blog-result-meta',
				'default'         => '1',
				'type'            => 'switch',
			],
			'blog_single_info'         => [
				'label'       => esc_html__( 'Single Blog', 'Sapid' ),
				'description' => '',
				'id'          => 'box-single-info',
				'icon'        => true,
				'type'        => 'info',
			],
			'blog_pn_nav'                              => [
				'label'           => esc_html__( 'Previous/Next Pagination', 'Sapid' ),
				'description'     => esc_html__( 'Enable to display earlier and next posts pagination for a blog post.', 'Sapid' ),
				'id'              => 'blog-pn-nav',
				'default'         => '1',
				'type'            => 'switch',
			],
			'social_sharing_box'                       => [
				'label'           => esc_html__( 'Social Sharing Box', 'Sapid' ),
				'description'     => esc_html__( 'Enable social sharing box visible.', 'Sapid' ),
				'id'              => 'social-sharing-box',
				'default'         => '1',
				'type'            => 'switch',
			],
			'single_result_meta'                                  => [
				'label'           => esc_html__( 'Blog Meta', 'Sapid' ),
				'description'     => esc_html__( 'Enable to make post meta visible.', 'Sapid' ),
				'id'              => 'single-result-meta',
				'default'         => '0',
				'type'            => 'switch',
			],
		],
	];

   return $sections;

}