<?php

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
   exit( 'Direct script access denied.' );
}

function sapid_options_section_import_data( $sections ) {   

   $sections['import_data'] = [
      'label'    => esc_html__( 'Import Theme Data', 'Sapid' ),
      'id'       => 'import_export_section',
      'priority' => 27,
      'icon'     => 'cached',
      'fields'   => [
         'import' => [
            'label'       => esc_html__( 'Import Theme Data', 'Sapid' ),
            'id'          => 'import',
            'description' =>esc_html__( "Important: Only Global Options settings can be imported.", 'Sapid' ),
            'default'     => '',
            'type'        => 'import',
         ],
      ],
   ];

   return $sections;
}