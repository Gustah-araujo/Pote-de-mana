<?php

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}

function sapid_options_section_extra( $sections ) {

	$sections['extras'] = [
		'label'    => esc_html__( 'Extras', 'Sapid' ),
		'id'       => 'extra_section',
		'priority' => 24,
		'icon'     => 'cog-outline',
		'fields'   => [
			'excerpt_length'     => [
				'label'           => esc_html__( 'Excerpt Length', 'Sapid' ),
				'description'     => esc_html__( 'Manage the length of the post excerpt for all blog pages with excerpt.', 'Sapid' ),
				'id'              => 'excerpt-length',
				'default'         => '10',
				'type'            => 'slider',
				'choices'         => [
					'min'  => '0',
					'max'  => '500',
					'step' => '1',
				],
			],
			'status_totop'                       => [
                'label'       => esc_html__( 'Scroll To Top', 'Sapid' ),
                'description' => esc_html__( 'Switch on to add the "Scroll to Top" functionality.', 'Sapid' ),
                'id'          => 'status-totop',
                'default'     => '1',
                'type'        => 'switch',
            ],
            'status_opengraph'                   => [
                'label'       => esc_html__( 'Open Graph Meta Tags', 'Sapid' ),
                'description' => __( 'Switch on to Enable open graph meta tags, which are commonly used for sharing pages on social networking websites such as Facebook.', 'Sapid' ),
                'id'          => 'status-opengraph',
                'default'     => '1',
                'type'        => 'switch',
            ],
			'tracking_head_body_section'         => [
				'label'       => esc_html__( 'Code Fields (Tracking etc.)', 'Sapid' ),
				'description' => '',
				'id'          => 'tracking_head_body_section',
				'icon'        => true,
				'type'        => 'info',
			],
	        'google_analytics' => [
                'label'       => esc_html__( 'Tracking Code', 'Sapid' ),
                'description' => esc_html__( "Paste your tracking code here. This will be added to your theme's header template. Note: Place the  code between the <script> tags.", 'Sapid' ),
                'id'          => 'google-analytics',
                'default'     => '',
                'type'        => 'textarea',
                'choices'     => [
                    'language' => 'html',
                    'height'   => 300,
                    'theme'    => 'chrome',
                ],
            ],
            'space_head'       => [
                'label'       => esc_html__( 'Add code in the Space before &lt;/head&gt;', 'Sapid' ),
                'description' => esc_html__( 'Accept any code of JavaScript/jQuery wrapped with a &lt;script&gt; tags and Valid HTML markup inside the  &lt;/head&gt;  tag.', 'Sapid' ),
                'id'          => 'space-head',
                'default'     => '',
                'type'        => 'textarea',
                'choices'     => [
                    'language' => 'html',
                    'height'   => 350,
                    'theme'    => 'chrome',
                ],
            ],
            'space_body'       => [
                'label'       => esc_html__( 'Add code in the Space before &lt;/body&gt;', 'Sapid' ),
                'description' => esc_html__( 'Accept any code of JavaScript/jQuery wrapped with a &lt;script&gt; tags and Valid HTML markup inside the  &lt;/body&gt; tag.', 'Sapid' ),
                'id'          => 'space-body',
                'default'     => '',
                'type'        => 'textarea',
                'choices'     => [
                    'language' => 'html',
                    'height'   => 350,
                    'theme'    => 'chrome',
                ],
            ],	
		],
	];

   return $sections;

}