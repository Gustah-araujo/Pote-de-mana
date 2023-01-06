<?php
class sapid_menu_walker extends Walker {

  var $db_fields = array( 'parent' => 'menu_item_parent', 'id' => 'db_id' );


   /**
   * Starts the list before the elements are added.
   *
   * @since 1.0.0
   *
   * @see Sapid Walker::start_lvl()
   *
   * @param string   $output Used to append additional content (passed by reference).
   * @param int      $depth  Depth of menu item. Used for padding.
   * @param stdClass $args   An object of wp_nav_menu() arguments.
   */
  function start_lvl( &$output, $depth = 0, $args = array() ) {
    
    $header_type =  sapid_get_theme_option( 'header-layout' );
    $ulClassname = '';
    if($header_type == 'v6'){
      $ulClassname = ' b-none';
    }

    $indent = str_repeat( "\t", $depth );
    if( $depth===0){
        $output .= "\n$indent<ul role=\"menu\" class=\"dropdown-menu animated".$ulClassname." fadeInUp\">\n";
    }else if( $depth===1){
        $output .= "\n$indent<ul role=\"menu\" class=\" dropdown-menu shadow\">\n";
    }else if( $depth===2){
        $output .= "\n$indent<ul role=\"menu\" class=\"wsmenu-submenu-sub\">\n";
    }else{
        $output .= "\n$indent<ul role=\"menu\" class=\" wsmenutest\">\n";
    }

  }

   /**
   * Ends the list of after the elements are added.
   *
   * @since 1.0.0
   *
   * @see Sapid Walker::end_lvl()
   *
   * @param string   $output Used to append additional content (passed by reference).
   * @param int      $depth  Depth of menu item. Used for padding.
   * @param stdClass $args   An object of wp_nav_menu() arguments.
   */
  function end_lvl( &$output, $depth = 0, $args = array() ) {
    $indent = str_repeat("\t", $depth);
    $output .= "$indent</ul>\n";
  }


 /**
   * Starts the element output.
   *
   * @since 1.0.0
   * @since 1.0.0 The {@see 'nav_menu_item_args'} filter was added.
   * @since 1.0.0 Renamed `$item` to `$data_object` and `$id` to `$current_object_id`
   *              to match parent class for PHP 8 named parameter support.
   *
   * @see Sapid Walker::start_el()
   *
   * @param string   $output            Used to append additional content (passed by reference).
   * @param int      $depth             Depth of menu item. Used for padding.
   * @param stdClass $args              An object of wp_nav_menu() arguments.
   * @param int      $id Optional. ID of the current menu item. Default 0.
   */
  function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
     
    global $wp_query;
    $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';
    $class_names = $value = '';        
    $classes = empty( $item->classes ) ? array() : (array) $item->classes;
    $class = empty( $item->class ) ? array() : (array) $item->class;

    $header_type =  sapid_get_theme_option( 'header-layout' );

    /* Add active class */
    if(in_array('current-menu-item', $classes)) {
      $classes[] = 'active';
      unset($classes['current-menu-item']);
    }
    /* Add active class a */
    if(in_array('current-menu-item', $class)) {
      $class[] = 'active';
      unset($class['current-menu-item']);
    }
    $class[] = 'menu-item-' . $item->ID;

    $classes[] = 'menu-item-' . $item->ID;
    if ( $depth === 0 ) $classes[] = 'nav-item';
    /* Check for children */
    $children = get_posts(array('post_type' => 'nav_menu_item', 'nopaging' => true, 'numberposts' => 1, 'meta_key' => '_menu_item_menu_item_parent', 'meta_value' => $item->ID));
    if (!empty($children)) {
      if ( $depth === 0 ) $classes[] = 'dropdown';
      if ( $depth === 1 ) $classes[] = 'dropstart';
    }
    $anchorClassname = '';
    if(!empty($args->walker->has_children) ){
      $anchorClassname = 'dropdown-toggle ';
    }

    $depthAnchorClassname = '';
    if($item->menu_item_parent == 0 && $header_type == 'v6'){
      $depthAnchorClassname = 'text-dark ';
    }  else if($item->menu_item_parent == 0 && $header_type == 'v10'){
      $depthAnchorClassname = 'text-white ';
    }

    $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args ) );
    $class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

    if( $depth == 0 ){
      if(!empty( $args->walker->has_children)){
        $a_class_names = join(' ', apply_filters( 'nav_menu_css_class', array_filter( $class ), $item, $args ) );
        !empty ( $a_class_names ) and $a_class_names = ' class="nav-link d-inline-block '. $depthAnchorClassname.esc_attr( $a_class_names ) . '"';
      }else{
        $a_class_names = join(' ', apply_filters( 'nav_menu_css_class', array_filter( $class ), $item, $args ) );
        !empty ( $a_class_names ) and $a_class_names = ' class="nav-link '. $depthAnchorClassname.esc_attr( $a_class_names ) . '"';
      }

    } elseif( $depth == 1 ) {
      $a_class_names = join(' ', apply_filters( 'nav_menu_css_class', array_filter( $class ), $item, $args ) );
      !empty ( $a_class_names ) and $a_class_names = ' class="dropdown-item '.$anchorClassname. esc_attr( $a_class_names ) . '"';
    }elseif( $depth == 2 ) {
      $a_class_names = join(' ', apply_filters( 'nav_menu_css_class', array_filter( $class ), $item, $args ) );
      !empty ( $a_class_names ) and $a_class_names = ' class="dropdown-item '.$anchorClassname. esc_attr( $a_class_names ) . '"';
    }


    $id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args );
    $id = $id ? ' id="' . esc_attr( $id ) . '"' : '';

    $output .= $indent . '<li' . $id . $value . $class_names .'>';

    $attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
    $attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
    $attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
    $attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';
    if(!empty($args->walker->has_children) ){
      if($item->menu_item_parent == 0){
        $attributes .= ! empty( $args->walker->has_children)  ? ' data-hover="dropdown"  aria-haspopup="true" aria-expanded="false"' : '';
      }else{
        $attributes .= ! empty( $args->walker->has_children)  ? ' data-bs-toggle="dropdown"  aria-haspopup="true" aria-expanded="false"' : '';
      }
    }

    $item_output = !empty($args->before) ? $args->before:'';
    $link_before = !empty($args->link_before) ? $args->link_before:'';
    $link_after = !empty($args->link_after) ? $args->link_after:'';
    $item_output .= '<a '. $attributes . $a_class_names  .'>';
    $item_output .= $link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $link_after;
    $item_output .= !empty( $args->walker->has_children) && $item->menu_item_parent == 0  ? '<i class="mdi mdi-chevron-down d-none d-xl-inline-block m-l-5"></i>' : '';
    $item_output_mobile = !empty( $args->walker->has_children) && $item->menu_item_parent == 0  ? '<a class="d-xl-none nav-link dropdown-toggle d-inline-block float-end p-0" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="mdi mdi-chevron-down fs-5"></i></a>' : '';
    $item_output .= '</a>'.$item_output_mobile;
    $item_output .= !empty($args->after) ? $args->after:'';

    $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
  }


   
  /**
   * Ends the element output, if needed.
   *
   * @since 1.0.0
   * @since 1.0.0 Renamed `$item` to `$data_object` to match parent class for PHP 8 named parameter support.
   *
   * @see Sapid Walker::end_el()
   *
   * @param string   $output      Used to append additional content (passed by reference).
   * @param int      $depth       Depth of page. Not Used.
   * @param stdClass $args        An object of wp_nav_menu() arguments.
   */
  
function end_el( &$output, $item, $depth = 0, $args = array() ) {
    $output .= "</li>\n";
  }
}