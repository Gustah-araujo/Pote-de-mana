<?php

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}

function sapid_options_section_breadcrumbs( $sections ) {
	
	$sections['breadcrumbs'] = [
		'label'    => esc_html__( 'Breadcrumbs', 'Sapid' ),
		'id'       => 'heading_breadcrumbs',
		'priority' => 7,
		'icon'     => 'chevron-right',
        'fields'   => [
           'breadcrumb'                 => [
              'label'           => esc_html__( 'Breadcrumbs', 'Sapid' ),
              'description'     => esc_html__( 'Turn it on to display Breadcrumbs', 'Sapid' ),
              'id'              => 'breadcrumb',
              'default'         => '1',
              'type'            => 'switch',
           ],
           'breadcrumb_separator'              => [
              'label'           => esc_html__( 'Breadcrumbs Separator', 'Sapid' ),
              'description'     => esc_html__( 'Manage the type of separator used between each breadcrumb.', 'Sapid' ),
              'id'              => 'breadcrumb-separator',
              'default'         => '/',
              'type'            => 'text',
              'soft_dependency' => true,
              'data-mode'       => '1',
              'data-parent'     => 'breadcrumb'
           ],
        ],
	];

	return $sections;
}