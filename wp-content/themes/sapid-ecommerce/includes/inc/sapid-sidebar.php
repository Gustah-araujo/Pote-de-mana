<?php

class sapidSidebar {

    public function __construct(){
        $this->sapid_widgets_init();
    }
    
    public function sapid_widgets_init(){
     /**
      *  @access public
       * Sapid Sidebar  Widgets.
       *
       * @return Return the HTML markup of Elements.
     */
        $footer = 'v6';

        $before_title1 = '<p class="widget-title font-medium">';
        $after_title1 = '</p>';
        $before_widget1 = '<aside id="%1$s" class="widget %2$s">';
        $after_widget1 = '</aside>';
        
        $before_title2 = '<p class="widget-title font-medium">';
        $after_title2 = '</p>';
        $before_widget2 = '<aside id="%1$s" class="widget %2$s">';
        $after_widget2 = '</aside>';
        
        $before_title3 = '<p class="widget-title font-medium">';
        $after_title3 = '</p>';
        $before_widget3 = '<aside id="%1$s" class="widget %2$s">';
        $after_widget3 = '</aside>';
        
        $before_title4 = '<p class="widget-title font-medium">';
        $after_title4 = '</p>';
        $before_widget4 = '<aside id="%1$s" class="widget %2$s">';
        $after_widget4 = '</aside>';
        
        register_sidebar( array(
            'name'          => __( 'Sidebar 1', 'Sapid' ),
            'id'            => 'sidebar-1',
            'description'   => __( 'Add widgets here to appear in your sidebar.', 'Sapid' ),
            'before_widget' => '<section id="%1$s" class="widget %2$s">',
            'after_widget'  => '</section>',
            'before_title'  => '<h2 class="widget-title">',
            'after_title'   => '</h2>',
        ) ); 

        register_sidebar( array(
            'name'          => __( 'Sidebar 2', 'Sapid' ),
            'id'            => 'sidebar-2',
            'description'   => __( 'Add widgets here to appear in your sidebar.', 'Sapid' ),
            'before_widget' => '<section id="%1$s" class="widget %2$s">',
            'after_widget'  => '</section>',
            'before_title'  => '<h2 class="widget-title">',
            'after_title'   => '</h2>',
        ) ); 

        register_sidebar( array(
            'name'          => __( 'Footer 1', 'Sapid' ),
            'id'            => 'footer-'.$footer.'-1',
            'before_widget' => $before_widget1,
            'after_widget'  => $after_widget1,
            'before_title'  => $before_title1,
            'after_title'   => $after_title1,
        ) );
        
        register_sidebar( array(
            'name'          => __( 'Footer 2', 'Sapid' ),
            'id'            => 'footer-'.$footer.'-2',
            'before_widget' => $before_widget2,
            'after_widget'  => $after_widget2,
            'before_title'  => $before_title2,
            'after_title'   => $after_title2,
        ) );
        
        register_sidebar( array(
            'name'          => __( 'Footer 3', 'Sapid' ),
            'id'            => 'footer-'.$footer.'-3',
            'before_widget' => $before_widget3,
            'after_widget'  => $after_widget3,
            'before_title'  => $before_title3,
            'after_title'   => $after_title3,
        ) );


        register_sidebar( array(
            'name'          => __( 'Footer 4', 'Sapid' ),
            'id'            => 'footer-'.$footer.'-4',
            'before_widget' => $before_widget4,
            'after_widget'  => $after_widget4,
            'before_title'  => $before_title4,
            'after_title'   => $after_title4,
        ) );
    
    }
}
$sapid_sidebar_obj = new sapidSidebar();

?>