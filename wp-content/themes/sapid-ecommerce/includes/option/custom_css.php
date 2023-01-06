<?php

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
   exit( 'Direct script access denied.' );
}

function sapid_options_section_custom_css( $sections ) {   

   $sections['custom_css'] = [
      'label'    => esc_html__( 'Custom CSS', 'Sapid' ),
      'id'       => 'custom_css_section',
      'priority' => 27,
      'icon'     => 'language-css3',
      'fields'   => [
         'custom_css' => [
            'label'       => esc_html__( 'CSS Code', 'Sapid' ),
            'id'          => 'custom-css',
            'description' => sprintf( esc_html__( "In the area below, enter your CSS code. There should be no tags or HTML in this field. The theme CSS will be overridden if custom CSS is set here! Crucial tag may be required. Images and SVG routes should not be URL encoded. This field's contents will be automatically encoded.", 'Sapid' ), '<code>!important</code>' ),
            'default'     => '',
            'type'        => 'textarea',
            'choices'     => [
               'language' => 'css',
               'height'   => 450,
               'theme'    => 'chrome',
               'minLines' => 40,
               'maxLines' => 50,
            ],
         ],
      ],
   ];

   return $sections;
}