<?php

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}

function sapid_options_section_social_media( $sections ) {

	$sections['social_media'] = [
		'label'    => esc_html__( 'Social Media', 'Sapid' ),
		'id'       => 'heading_social_media',
		'priority' => 18,
		'icon'     => 'arrow-right-top-bold',
		'fields'   =>  [
			'social_media_icons_important_note_info' => [
				'label'       => '',
				'description' => '<div class="sapid-redux-important-notice">' . __( '<strong>VALUABLE NOTE:</strong> This option regulates which social networks show in the footers and headers of legacy pages. The Person element and the Social Links can both use the customised icons your design here.', 'Avada' ) . '</div>',
				'id'          => 'social-media-icons-important-note-info',
				'type'        => 'custom',
			],
			'social_media_icons' => [
				'label'           => esc_html__( 'Social Media Links / Icons', 'Sapid' ),
				'description'     => esc_html__( 'Social media links support one network per field and use a repeater field. The "Add" button can be used to add extra fields.', 'Sapid' ),
				'id'              => 'social-media-icons',
				'default'         => [
					[
						'name'  =>  'facebook',
						'icon'  =>  'mdi-facebook',
						'value' =>  '#',
					],
					[
						'name'  =>  'twitter',
						'icon'  =>  'mdi-twitter',
						'value' =>  '#',
					],
					[
						'name'  =>  'instagram',
						'icon'  =>  'mdi-instagram',
						'value' =>  '#',
					],
					[
						'name'  =>  'pinterest',
						'icon'  =>  'mdi-pinterest',
						'value' =>  '#',
					],

				],
				'type'            => 'repeater',
				'fields'  		  => [
					'name'          => [
						'id'          => 'name',
						'class'       => 'form-select chosen-select',
						'type'        => 'select',
						'label'       => esc_html__( 'Social Network', 'Sapid' ),
						'description' => esc_html__( 'Select a social network to automatically add its icon', 'Sapid' ),
						'default'     => 'none',
						'choices'     => Sapid_Theme_Options::get_defaults_social(),
					],
					'icon'     => [
						'type'        => 'text',
						'id'          => 'icon',
						'class'       => 'form-control use-material-icon-picker',
						'label'     => esc_attr__( 'Icon', 'Sapid' ),
						'description' => esc_attr__( 'Click an icon to select, click again to deselect.', 'Sapid' ),
						'default'     => '',
					],
					'value'           => [
						'id'          => 'value',
						'type'        => 'text',
						'class'       => 'custom-link form-control',
						'label'       => esc_html__( 'Custom Link', 'Sapid' ),
						'description' => esc_html__( 'Insert your custom link here', 'Sapid' ),
						'default'     => '',
					],
				],
			],
			'social_share_box_icon_info'         => [
				'label'       => esc_html__( 'Social Sharing Icons', 'Sapid' ),
				'description' => '',
				'id'          => 'social-share-box-icon-info',
				'icon'        => true,
				'type'        => 'info',
			],
			'social_sharing'                     => [
				'label'                  => esc_html__( 'Social Sharing', 'Sapid' ),
				'description'            => esc_html__( 'You can choose which social network should appear in the social share box.', 'Sapid' ),
				'id'                     => 'social-sharing',
				'default'                => [ 'facebook', 'twitter', 'reddit', 'linkedin', 'whatsapp', 'telegram', 'tumblr', 'pinterest', 'vk', 'xing', 'email' ],
				'type'                   => 'select',
				'multi'                  => true,
				'choices'                => [
					'facebook'  => esc_html__( 'Facebook', 'Sapid' ),
					'twitter'   => esc_html__( 'Twitter', 'Sapid' ),
					'reddit'    => esc_html__( 'Reddit', 'Sapid' ),
					'linkedin'  => esc_html__( 'LinkedIn', 'Sapid' ),
					'whatsapp'  => esc_html__( 'WhatsApp', 'Sapid' ),
					'telegram'  => esc_html__( 'Telegram', 'Sapid' ),
					'tumblr'    => esc_html__( 'Tumblr', 'Sapid' ),
					'pinterest' => esc_html__( 'Pinterest', 'Sapid' ),
					'vk'        => esc_html__( 'VK', 'Sapid' ),
					'xing'      => esc_html__( 'Xing', 'Sapid' ),
					'email'     => esc_html__( 'Email', 'Sapid' ),
				],
			],
		],
	];

   return $sections;

}