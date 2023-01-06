<?php

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}

function sapid_options_section_footer( $sections ) {

	$sections['footer'] = [
		'label'    => esc_html__( 'Footer', 'Sapid' ),
		'id'       => 'heading_footer',
		'priority' => 9,
		'icon'     => 'arrow-down-bold',
		'fields' => [
			'footer_copyright'                       => [
				'label'           => esc_html__( 'Copyright Bar', 'Sapid' ),
				'description'     => esc_html__( 'Display the copyright bar by turning it on.', 'Sapid' ),
				'id'              => 'footer-copyright',
				'default'         => '1',
				'type'            => 'switch',
			],
			'footer_copyright_center_content'        => [
				'label'           => esc_html__( 'Center Copyright Content', 'Sapid' ),
				'description'     => esc_html__( 'Center the copyright bar content by turning it on.', 'Sapid' ),
				'id'              => 'footer-copyright-center-content',
				'default'         => '0',
				'data-parent' 		=>'footer-copyright',
				'data-mode' 		=>'1',
				'type'            => 'switch',
			],
			'footer_text'                            => [
				'label'             => esc_html__( 'Copyright Text', 'Sapid' ),
				'description'       => esc_html__( 'Fill in the text that appears in the copyright bar.', 'Sapid' ),
				'id'                => 'footer-text',
				'type'              => 'text',
				'data-parent' 		=>'footer-copyright',
				'data-mode' 		=>'1',
				'default'           => 'Copyright @2011 - {Y} Sapid Business Ltd. All Rights Reserved',
			],
		],
	];

	return $sections;
}
?>