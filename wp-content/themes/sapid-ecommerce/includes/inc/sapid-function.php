<?php
/**
 * theme functions.
 *
 * @package    Sapid
 * @since      1.0
 */

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
   exit( 'Direct script access denied.' );
}


if ( ! function_exists( 'sapid_header_default' ) ) {
   function sapid_header_default() {
      /**
       * Sapid Header Call.
       *
       * @return Header Content is directly echoed.
      */
      $header_type = 'v12';
      $sticky_header_logo = ( sapid_get_theme_option( 'sticky-header-logo' ) ) ? true : false;
      $mobile_logo        = ( sapid_get_theme_option( 'mobile-logo' ) ) ? true : false;
      // The sapid_before_header_wrapper hook.
      do_action( 'sapid_before_header_wrapper' );
      $side_header_css = 'clearfix side_header sapid-header-'.$header_type. ' sapid-sticky-logo-' . $sticky_header_logo . ' sapid-mobile-logo-' . $mobile_logo;

      echo '<div id="side-header" class="'.esc_attr( $side_header_css ).'">';
         // The sapid_header_inner_before hook.
         do_action( 'sapid_header_inner_before' );
         get_template_part( 'includes/inc/headers/header-'.$header_type );
         do_action( 'sapid_header_inner_after' );	
         // The sapid_header_inner_after hook.
      echo'</div>';

      // The sapid_after_header_wrapper hook.
      do_action( 'sapid_after_header_wrapper' );
   }
}
add_action( 'sapid_header', 'sapid_header_default' );


if ( ! function_exists( 'sapid_footer_default' ) ) {
   function sapid_footer_default() {
      /**
       * Sapid Footer Call.
       *
       * @return Footer Content is directly echoed.
      */
      $footer = 'v6';
      echo '<div id="side-footer" class="sapid-footers">';
         get_template_part('includes/inc/footer/footer-'.$footer);
      echo'</div>';
   }
}
add_action('sapid_footer', 'sapid_footer_default');


if ( ! function_exists( 'sapid_logo' ) ) {
   function sapid_logo() {
      /**
       * Sapid Logo Call.
       *
       * @return Logo is directly echoed.
      */
      get_template_part( 'includes/inc/templates/logo' );
   }
}

if ( ! function_exists( 'sapid_copy_right' ) ) {
   function sapid_copy_right(){ 
      /**
       * Sapid Copy Right Call.
       *
       * @return Copy right content is directly echoed.
      */
      $array = ['Y' => date('Y')];
      $string = sapid_get_theme_option('footer-text');
      $rearr = array_map(function($k) { return '/\{' . $k . '}/'; }, array_keys($array));
      if(sapid_get_theme_option('footer-copyright') == 1){

         $footer_copyright_center_content   = sapid_get_theme_option( 'footer-copyright-center-content' );
         if(!empty($footer_copyright_center_content)){
            $footer_justify_class   = ' justify-content-center text-center';
         }else{
            $footer_justify_class   = ' justify-content-start text-start';
         }
         echo '<div class="m-t-10 m-b-10 copyright_text'.$footer_justify_class.'">'.preg_replace($rearr, $array, $string).'</div>';
      }
   }
}
add_action('sapid_copy_right', 'sapid_copy_right');

if ( ! function_exists( 'sapid_social_media_default' ) ) {
   function sapid_social_media_default() {
      /**
       * Sapid Social Media.
       *
       * @return social media is directly echoed.
      */
      $social_media_icons = sapid_get_theme_option('social-media-icons');
      if(!empty($social_media_icons) && is_array($social_media_icons)){
         foreach($social_media_icons as $social_media){
            $relAttr = '';
            if ( sapid_get_theme_option( 'nofollow-social-links' ) ) {
               $relAttr = 'rel="nofollow"';
            }
            echo '<a aria-label="'.$social_media['name'].'" href="'.$social_media['value'].'" '.$relAttr.' class="link"><i class="mdi '.$social_media['icon'].' fs-3"></i></a> ';
         }
      }
   }
}
add_action('sapid_social_media', 'sapid_social_media_default');

if ( ! function_exists( 'add_sapid_class_on_li' ) ) {
   /**
    * Add Li class on nav manu.
    *
    * @return classess array.
   */
   function add_sapid_class_on_li($classes, $item, $args) {
      if(isset($args->add_li_class)) {
         $classes[] = $args->add_li_class;
      }
      return $classes;
   }
}
add_filter('nav_menu_css_class', 'add_sapid_class_on_li', 1, 3);

if ( ! function_exists( 'add_sapid_class_on_a' ) ) {
   function add_sapid_class_on_a($classes, $item, $args){
      /**
       * Add Anchor tag class on nav manu.
       *
       * @return classess array.
      */
      if (isset($args->add_a_class)) {
        $classes['class'] = $args->add_a_class;
      }
      return $classes;
   }
}
add_filter('nav_menu_link_attributes', 'add_sapid_class_on_a', 1, 3);

if ( ! function_exists( 'sapid_add_woocommerce_extra_menu' ) ) {
   function sapid_add_woocommerce_extra_menu( $items, $args ) {
      /**
       * add my account and cart nav menu.
       *
       * @return nav menu items array.
      */
      if ( ! class_exists( 'WooCommerce' ) ) {
         return $items;
      }

      $is_main_nav_enabled   =  sapid_get_theme_option( 'woocommerce_acc_link_main_nav' );
      $is_main_minicart_enabled    =  sapid_get_theme_option( 'woocommerce-minicart-link-main-nav' );
      $aMainMenuClass = '';
      $liTopNavClass = 'nav-item';
      $aTopNavClass = 'nav-link';

      if ( $args->theme_location == 'primary-menu') {
         if ( !empty($is_main_nav_enabled )) {
            if ( is_user_logged_in() ) {
               $items .= '<li class="nav-item"><a class="nav-link'.$aMainMenuClass.'" href="'. get_permalink( get_option('woocommerce_myaccount_page_id') ) .'">'.__( 'My Account', 'Sapid' ).'</a></li>';
            }else{
               $items .= '<li class="nav-item"><a class="nav-link'.$aMainMenuClass.'" href="'. get_permalink( get_option('woocommerce_myaccount_page_id') ) .'">'.__( 'Sign In', 'Sapid' ).'</a></li>'; 
            }
         }
         if(!empty($is_main_minicart_enabled)){
            $items .= sapid_mini_cart();
         }
      }
      return $items;
   }
}
add_filter( 'wp_nav_menu_items', 'sapid_add_woocommerce_extra_menu', 10, 2 );

if (!function_exists('sapid_mini_cart')) {
   function sapid_mini_cart() { 
      /**
       * Sapid mini cart.
       *
       * @return Return the HTML markup of the mini cart .
      */
      if ( ! class_exists( 'WooCommerce' ) ) {
         return '';
      }

      $cart_contents_count  = sapid_number_format_short(WC()->cart->get_cart_contents_count());

      $item = '<li class="nav-item dropdown"><a href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true"  class="dropdown-back sapid-mini-cart-box" data-toggle="dropdown"> ';
      $item .= '<i class="mdi mdi-cart" aria-hidden="true"></i>';
      $item .= '<div class="basket-item-count" style="display: inline;">';
      $item .= '<span class="cart-items-count count sapid-cart-count">';
      $item .= $cart_contents_count;
      $item .= '</span>';
      $item .= '</div>';
      $item .= '</a>';
      $item .= '<ul class="dropdown-menu dropdown-menu-mini-cart">';
      $item .= '<li> <div class="widget_shopping_cart_content">';
      $item .= '</div></li></ul></li>';
      return $item;
   }
}


if (!function_exists('sapid_display_comments')) {
    /**
     * Sapid display comments, form
     * @since  1.0.0
     * @return comment form.
     */
    function sapid_display_comments() {
        // If comments are open or we have at least one comment, load up the comment template.
        if (comments_open()) :
            comments_template();
        endif;
    }
}
add_action('sapid_display_comments', 'sapid_display_comments');

if (!function_exists('sapid_header_social')) {
   /**
    * Sapid Social Media
    * @since  1.0.0
    * @return Return the HTML markup of the social media icon.
    */
   function sapid_header_social() {
      $icon = '';
      $header_type =  'v12';
      $social_media_icons = sapid_get_theme_option('social-media-icons');


      $ulClass ='header-social-links d-flex ps-0 mb-0 list-style-none';
      $liClass ='nav-item';
      $aClass ='nav-link dark';

      $iconClass =' text-dblue fs-3';
         
      $startPoint = '<ul class="'.$ulClass.'">';
      $endPoint  ='</ul>';

      if(!empty($social_media_icons) && is_array($social_media_icons)){
         foreach($social_media_icons as $social_media){
            $icon .= '<li class="'.$liClass.'"><a class="'.$aClass.'" href="'.$social_media['value'].'" class="link"><i class="mdi '.$social_media['icon'].$iconClass.'"></i></a></li>';
         }
      }

      return $startPoint.$icon.$endPoint;
   }
}


if (!function_exists('sapid_post_thumbnail')) {
   /**
   * Display post thumbnail
   *
   * @param string $size the post thumbnail size.
   *
   * @uses has_post_thumbnail()
   * @uses the_post_thumbnail
   * @var  $size . thumbnail|medium|large|full|$custom
   * @since 1.0.0
   */
   function sapid_post_thumbnail($size = 'post-thumbnail') {
      if (has_post_thumbnail()) {
         echo '<div class="post-thumbnail sapid-thumbnail">';
            the_post_thumbnail($size ? $size : 'post-thumbnail');
         echo '</div>';
      }else{
         if(!is_page()){
            echo '<div class="post-thumbnail sapid-thumbnail">';
               echo '<img src="'.get_template_directory_uri().'/assets/images/thumb.png'.'">'; 
            echo '</div>';
         }
      }
   }
}

add_filter( 'body_class', 'body_classes');
if (!function_exists('body_classes')) {
   /**
    * Calculate any extra classes for the <body> element.
    *
    * @param  array $classes CSS classes.
    * @return array The needed body classes.
    */
   function body_classes( $classes ) {

      $classes[] = 'sapid-body';

      if ( ! is_rtl() ) {
         $classes[] = 'ltr';
      }

      if ( sapid_get_theme_option( 'header-sticky' ) ) {
         $classes[] = 'sapid-sticky-header';
      }

      $classes[] = 'layout-wide-mode';

      return $classes;
   }
}

if ( ! function_exists( 'sapid_the_html_class' ) ) {
   /**
    * Echo classes for <html>.
    *
    */
   function sapid_the_html_class() {
      $classes    = [];

      // Make sure an array.
      if ( ! is_array( $classes ) ) {
         $classes = (array) $classes;
      }

      // Add layout class.
      $classes[] = 'sapid-html-layout-wide';

      if ( is_archive() && ( ! function_exists( 'is_shop' ) || function_exists( 'is_shop' ) && ! is_shop() ) ) {
         $classes[] = 'sapid-html-is-archive';
      }

      echo esc_attr( implode( ' ', apply_filters( 'sapid_the_html_class', $classes ) ) );
   }
}

if ( ! function_exists( 'sapid_content_class' ) ) {
   /**
    * Echo classes for content div.
    *
    * @param string $class Any additional classes.
    */
   function sapid_content_class( ) {
      $classes    = [];
      $classes[] = 'sapid-content clearfix';
      if(is_page()){
         $is_sidebar       = sapid_get_theme_option('is-page-sidebar');
         $sidebar_position = sapid_get_theme_option('page-sidebar-position');
         if(is_checkout() || is_page( 'cart' ) || is_cart() || is_account_page()){
            $is_sidebar       = sapid_get_theme_option('is-woocommerce-page-sidebar');
            $sidebar_position = sapid_get_theme_option('woocommerce-page-sidebar-position');  
         }
      }elseif(is_single()){
         $is_sidebar = sapid_get_theme_option('is-post-single-sidebar');
         $sidebar_position = sapid_get_theme_option('post-single-sidebar-position');
         if(is_product()){
            $is_sidebar       = sapid_get_theme_option('is-single-product-page-sidebar');
            $sidebar_position = sapid_get_theme_option('single-product-sidebar-position');    
         }
      }elseif(is_search()){
         $is_sidebar = sapid_get_theme_option('is-search-page-sidebar');
         $sidebar_position = sapid_get_theme_option('search-sidebar-position');
      }elseif(is_home() || is_archive() || is_archive() || is_category() || is_tag()){
         $is_sidebar = sapid_get_theme_option('is-post-category-sidebar');
         $sidebar_position = sapid_get_theme_option('post-category-sidebar-position');
         if(is_shop() || is_product_category()){
            $is_sidebar       = sapid_get_theme_option('is-shop-category-page-sidebar');
            $sidebar_position = sapid_get_theme_option('shop-category-sidebar-position');     
         }
      }

      if(!empty($is_sidebar)){
         $classes[] = 'col-sm-9';
         if($sidebar_position =='Left'){
            $classes[] = 'order-2';
         }else{
            $classes[] = 'order-1'; 
         }
      }
      echo esc_attr( implode( ' ', apply_filters( 'sapid_content_class', $classes ) ) );
   }
}


if ( ! function_exists( 'sapid_top_nav' ) ) {
   /**
    * Returns the markup for nav menu.
    * @since 1.0.0
    */
   function sapid_top_nav() {
      if ( has_nav_menu( 'top-menu' ) ) {
         $html = '';
         $ulClass ='navbar-nav';
         $liClass ='nav-item';
         $aClass ='nav-link';

         return wp_nav_menu(
            [
               'theme_location' => 'top-menu',
               'menu_class'     => $ulClass,
               'items_wrap'     => '<ul id="%1$s" class="%2$s">%3$s</ul>',
               'container'      => false,
               'add_li_class'   => $liClass,
               'add_a_class'    => $aClass,
               'echo'           => false,
               'item_spacing'   => 'discard',
            ]
         );
      }
   }
}

if ( ! function_exists( 'sapid_contact_info' ) ) {
   /**
    * Returns the markup for the contact-info area.
    */
   function sapid_contact_info() {
      $phone_number    = sapid_get_theme_option( 'header-number' );
      $email           = sapid_get_theme_option( 'header-email' );
      $timing          = sapid_get_theme_option( 'header-timing' );

      $html = '';

      $aClass ='';
      $iconClass = '';
      $ulClass ='navbar-nav';
      $liClass ='';
      $subClass =' text-dblue-sub';

      $aClass = ' d-flex';
      $iconClass = ' fs-1';

         
      if ( $phone_number || $email || $timing) {
         $html .= '<ul class="'.$ulClass.'">';

         if ( $email ) {
            $html .= '<li class="nav-item'.$liClass.'"><a class="nav-link'.$aClass.'"  href="mailto:'.$email.'"><div class="display-6 m-r-10 f-w'.$subClass.'"><i class="mdi mdi-email-outline'.$iconClass.'"></i></div> <div><small class="f-w'.$subClass.'">EMAIL US AT</small><p class="font-bold mb-0">'.$email.' </p></div></a></li>';
         }
         if ( $phone_number){
            $html .= ' <li class="nav-item'.$liClass.'"><a class="nav-link'.$aClass.'" href="tel:'.$phone_number.'"><div class="display-6 m-r-10 f-w'.$subClass.'"><i class="mdi mdi-phone text-success-gradiant'.$iconClass.'"></i></div> <div><small class="f-w'.$subClass.'">CALL US NOW</small><p class="font-bold mb-0">'.$phone_number.'</p></div></a></li> ';
         }

         if ( $timing ) {
            $html .= '<li class="nav-item'.$liClass.'"><span class="nav-link'.$aClass.'"> <div class="display-6 m-r-10 f-w'.$subClass.'"><i class="mdi mdi-clock-alert-outline text-success-gradiant'.$iconClass.'"></i></div><div><small class="f-w'.$subClass.'">Opening Hours</small><p class="font-bold mb-0">' . $timing . ' </p></div></span></li>';
         }

         $html .= '</ul>';
      }
      return $html;
   }
}

if ( ! function_exists( 'sapid_search' ) ) {
   function sapid_search($content_area){ 
      /**
       * Sapid Search Form.
       *
       * @param  string content_area.
       * @return Render html search form
       */  
      ob_start(); ?>
      <ul class="navbar sapid-search-header nav_<?php echo $content_area; ?>">
         <li class="nav-item nav_item_<?php echo $content_area; ?> search dropdown"><a class="nav-link fs-3" href="javascript:void(0)" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="mdi mdi-card-search"></i></a>
             <div class="dropdown-menu dropdown_menu_<?php echo $content_area; ?> b-none dropdown-menu-right animated fadeInDown">
               <?php get_search_form( true ); ?>
             </div>
         </li>
      </ul>
      <?php
      $output = ob_get_clean();
      return $output;
   }
}

if (! function_exists('get_sapid_logo_image_srcset')){

   /**
    * Get normal and retina logo images in srcset.
    *
    * @since 1.0
    * @param string $normal_logo The name of the normal logo option.
    * @param string $retina_logo The name of the retina logo option.
    * @return array The logo data.
    */

   function get_sapid_logo_image_srcset( $normal_logo, $retina_logo ){

      $logo_srcset_data = [
         'url'       => '',
         'srcset'    => '',
         'style'     => '',
         'is_retina' => false,
         'width'     => '',
         'height'    => '',
      ];

      $standard_logo  = sapid_get_theme_option( $normal_logo );
      $retina_standard_logo  = sapid_get_theme_option( $retina_logo );
      $logo_url       = !empty($standard_logo) ? set_url_scheme($standard_logo):'';
      $logo_srcset_data['srcset'] = $logo_url . ' 1x';
      // Get retina logo, whene default one is not set.
      if ( '' === $logo_url ) {
         $logo_url       = !empty($retina_standard_logo) ? set_url_scheme($retina_standard_logo):'';
         $imgData = wp_getimagesize($logo_url);
         $logo_data_width            = !empty($imgData[0]) ? $imgData[0]/2:'';
         $logo_data_height           = !empty($imgData[1]) ? $imgData[1]/2:'';
         $logo_srcset_data['style']  = '';
         $logo_srcset_data['srcset'] = $logo_url . ' 1x';
         $logo_srcset_data['url']    = $logo_url;

         if ( '' !== $logo_data_width ) {
            $logo_srcset_data['style'] = ' style="max-height:' . $logo_data_height . 'px;height:auto;"';
         }
      }else{
         $imgData = wp_getimagesize($logo_url);
         $logo_data_width            = !empty($imgData[0]) ? $imgData[0]:'';
         $logo_data_height           = !empty($imgData[1]) ? $imgData[1]:'';
         $logo_srcset_data['style']     = '';
         $logo_srcset_data['url']       = $logo_url;
         $logo_srcset_data['is_retina'] = false;
      }

      $logo_srcset_data['width']  = $logo_data_width;
      $logo_srcset_data['height'] = $logo_data_height;


      if ( !empty($retina_standard_logo) && '' !== $retina_standard_logo ) {
         $retina_logo                   = set_url_scheme( $retina_standard_logo );
         $logo_srcset_data['srcset']   .= ', ' . $retina_logo . ' 2x';
         $logo_srcset_data['is_retina'] = $retina_logo;

         if ( '' !== $logo_data_width ) {
            $logo_srcset_data['style'] = ' style="max-height:' . $logo_data_height . 'px;height:auto;"';
         }
      }
      return $logo_srcset_data;
   }
}

if (! function_exists('sapid_comment')){

   /**
    * The comment template.
    *
    * @access public
    * @param Object     $comment The comment.
    * @param array      $args    The comment arguments.
    * @param int|string $depth   The comment depth.
    */

   function sapid_comment( $comment, $args, $depth  ){
      ?>
      <?php $add_below = ''; ?>
      <li <?php comment_class('media d-block d-md-flex text-center text-md-start'); ?> id="comment-<?php comment_ID(); ?>">
         <div class="avatar"><?php echo get_avatar( $comment, 60, null, null, array('class' => array('d-flex', 'm-auto', 'm-md-0',' me-md-3', 'rounded-circle') )); ?></div>
         <div class="the-comment media-body mt-3 mt-md-0 ">
            <div class="comment-box">
               <div class="comment-author meta">
                  <h4 class="mt-0 mb-1"><?php echo get_comment_author_link(); ?></h4>
                  <?php
                  printf(
                     /* translators: %1$s: Comment date. %2$s: Comment time. */
                     esc_attr__( '%1$s at %2$s', 'Sapid' ),
                     get_comment_date(), // phpcs:ignore WordPress.Security.EscapeOutput
                     get_comment_time() // phpcs:ignore WordPress.Security.EscapeOutput
                  );

                  edit_comment_link( __( ' - Edit', 'Sapid' ), '  ', '' );

                  comment_reply_link(
                     array_merge(
                        $args,
                        [
                           'reply_text' => __( ' - Reply', 'Sapid' ),
                           'add_below'  => 'comment',
                           'depth'      => $depth,
                           'max_depth'  => $args['max_depth'],
                        ]
                     )
                  );
                  ?>
               </div>
               <div class="comment-text">
                  <?php if ( '0' == $comment->comment_approved ) : // phpcs:ignore WordPress.PHP.StrictComparisons ?>
                     <em><?php esc_attr_e( 'Your comment is awaiting moderation.', 'Sapid' ); ?></em>
                     <br />
                  <?php endif; ?>
                  <?php comment_text(); ?>
               </div>
            </div>
         </div>
      </li>
      <?php
   }
}

if ( ! function_exists( 'sapid_social_sharing' ) ) {
   /**
    * Renders social sharing links.
    *
    * @param string $post_type The post-type.
    * @return void
    */
   function sapid_social_sharing() {
      global $post;
      //allow users to hook in before display function is called
      do_action('before_sapid_social_sharing');
      $setting_name = ( 'post' === $post->post_type ) ? 'social-sharing-box' : $post->post_type . '-social-sharing-box';
      if ( sapid_get_theme_option( $setting_name ) ) {
         $postLink = urlencode(get_permalink());
         $postTitle = str_replace( ' ', '%20', get_the_title());
         $postContent = substr(wp_strip_all_tags($post->post_content), 0, 300);
         $postThumbnail = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' );
         $image_url = !empty($postThumbnail[0]) ? $postThumbnail[0]:get_template_directory_uri().'/assets/images/thumb.png';
         $social_sharing = sapid_get_theme_option( 'social-sharing' );
         if(!empty($social_sharing) && is_array($social_sharing)){
            $relAttr = '';
            if ( sapid_get_theme_option( 'nofollow-social-links' ) ) {
               $relAttr = ' rel="nofollow"';
            }
            $html = '<ul class="sapid-social-share-icons">';
               if(in_array("facebook",$social_sharing)){
                  $facebookLink = 'https://www.facebook.com/sharer/sharer.php?u='.$postLink;
                  $html .= '<li><a target="_blank" href="'.$facebookLink.'" title="Facebook"'.$relAttr.'><img width="25" src="'.get_template_directory_uri().'/assets/images/facebook.png"></a></li>';
               }

               if(in_array("twitter",$social_sharing)){
                  $twitterLink = 'https://twitter.com/intent/tweet?text='.$postTitle.'&amp;url='.$postLink.'&amp;via=iamsapid';
                  $html .= '<li><a target="_blank" href="'.$twitterLink.'" title="Twitter"'.$relAttr.'><img width="25" src="'.get_template_directory_uri().'/assets/images/twitter.png"></a></li>';
               }

               if(in_array("linkedin",$social_sharing)){
                  $linkedinLink = 'https://www.linkedin.com/shareArticle?mini=true&url='.$postLink.'&amp;title='.$postTitle;
                  $html .= '<li><a target="_blank" href="'.$linkedinLink.'" title="Linkedin"'.$relAttr.'><img width="25" src="'.get_template_directory_uri().'/assets/images/linkedin.png"></a></li>';
               }

               if(in_array("pinterest",$social_sharing)){
                  $pinterestLink = 'https://pinterest.com/pin/create/button/?url='.$postLink.'&amp;media='.$image_url.'&amp;description='.$postTitle;
                  $html .= '<li><a target="_blank" href="'.$pinterestLink.'" title="Pinterest"'.$relAttr.'><img width="25" src="'.get_template_directory_uri().'/assets/images/pinterest.png"></a></li>';
               }

               if(in_array("whatsapp",$social_sharing)){
                  $whatsappLink = 'https://api.whatsapp.com/send?text='.$postLink;
                  $html .= '<li><a href="'.$whatsappLink.'" title="Whatsapp"'.$relAttr.'><img width="25" src="'.get_template_directory_uri().'/assets/images/whatsapp.png"></a></li>';
               }

               if(in_array("reddit",$social_sharing)){
                  $redditLink = 'https://reddit.com/submit?url='.$postLink;
                  $html .= '<li><a target="_blank" href="'.$redditLink.'" title="Reddit"'.$relAttr.'><img width="25" src="'.get_template_directory_uri().'/assets/images/reddit.png"></a></li>';
               }

               if(in_array("tumblr",$social_sharing)){
                  $redditLink = 'https://www.tumblr.com/widgets/share/tool/preview?shareSource=legacy&canonicalUrl=&url='.$postLink.'&posttype=link&title='.$postTitle.'&caption='.$postContent.'&content='.$postLink;
                  $html .= '<li><a target="_blank" href="'.$redditLink.'" title="Tumblr"'.$relAttr.'><img width="25" src="'.get_template_directory_uri().'/assets/images/tumblr.png"></a></li>';
               }

               if(in_array("vk",$social_sharing)){
                  $tumblrLink = 'https://vk.com/share.php?url='.$postLink.'&amp;title='.$postTitle.'&amp;description='.$postContent;
                  $html .= '<li><a target="_blank" href="'.$tumblrLink.'" title="VK"'.$relAttr.'><img width="25" src="'.get_template_directory_uri().'/assets/images/vk.png"></a></li>';
               }

               if(in_array("xing",$social_sharing)){
                  $xingLink = 'https://www.xing.com/social_plugins/share/new?sc_p=xing-share&amp;h=1&amp;url='.$postLink;
                  $html .= '<li><a target="_blank" href="'.$xingLink.'" title="Xing"'.$relAttr.'><img width="25" src="'.get_template_directory_uri().'/assets/images/xing.png"></a></li>';
               }

               if(in_array("email",$social_sharing)){
                  $mailLink = 'mailto:?body='.$postLink.'&amp;subject='.$postTitle;
                  $html .= '<li><a target="_blank" href="'.$mailLink.'" title="Email"'.$relAttr.'><img width="25" src="'.get_template_directory_uri().'/assets/images/email.png"></a></li>';
               }

               if(in_array("telegram",$social_sharing)){
                  $telegramLink = 'https://telegram.me/share/url?url='.$postLink.'&text='.$postTitle;
                  $html .= '<li><a target="_blank" href="'.$telegramLink.'" title="Telegram"'.$relAttr.'><img width="25" src="'.get_template_directory_uri().'/assets/images/telegram.png"></a></li>';
               }
            $html .= ' </ul>';
         }
        echo $html;
      }
      do_action('after_sapid_social_sharing');
   }
}

if ( ! function_exists( 'sapid_breadcrumbs' ) ) {
   /**
    * WordPress Breadcrumbs
    */
   function sapid_breadcrumbs() {
      global $post,$wp_query;
      $separator              = sapid_get_theme_option( 'breadcrumb-separator' );
      $breadcrumbs_id         = 'sapid_breadcrumbs';
      $breadcrumbs_class      = 'sapid_breadcrumbs breadcrumb bg-sec m-b-30 p-3';
      $home_title             = esc_html__('Home', 'Sapid');
      $prefix                 = sapid_get_theme_option( 'breacrumb-prefix' );
      $prefix = !empty($prefix) ? '<span class="sapid-breadcrumb-prefix">'.$prefix.'</span>':'';
      $innerHtml ='';
      $is_show = 1;
      $is_breadcrumb = sapid_get_theme_option('breadcrumb');
      $container_class = 'container ';
        
      if(!empty($is_breadcrumb)){

         if (class_exists('Woocommerce') && is_woocommerce()) {
            if(!empty($is_show)){
               woocommerce_breadcrumb(array('delimiter' => '<li class="separator separator-pd">'.$separator.'</li>', 'wrap_before' => '<div class="sapid-breadcrumb-bar-wrapper pt-4"><div class="'.$container_class.'sapid-breadcrumb-bar"><ul id="' . $breadcrumbs_id . '" class="' . $breadcrumbs_class . '">', 'wrap_after' => '</ul></div></div>', 'before' => '<li>', 'after' => '</li>', 'home' => $prefix.$home_title));
            }
            return;
         }

         if ( !is_front_page()  ) {
            // Home
            $innerHtml .= '<li class="item-home breadcrumb-item"><a class="bread-link bread-home " href="' . get_home_url() . '" title="' . $home_title . '">' .$prefix. $home_title . '</a></li>';
            $innerHtml .= '<li class="separator separator-home separator-pd"> ' . $separator . ' </li>';
              
            if ( is_archive() && !is_tax() && !is_category() && !is_tag() ) {
               $innerHtml .= '<li class="item-current item-archive"><strong class="bread-current bread-archive ">' . post_type_archive_title('', false) . '</strong></li>';
                 
            } else if ( is_archive() && is_tax() && !is_category() && !is_tag() ) {
               // For Custom post type
               $post_type = get_post_type();
                 
               // Custom post type name and link
               if($post_type != 'post' || $post_type != 'product') {
                     
                  $post_type_object = get_post_type_object($post_type);
                  $post_type_archive = get_post_type_archive_link($post_type);
                  if(!empty($post_type_object)){

                     $innerHtml .= '<li class="item-cat item-custom-post-type-' . $post_type . '"><a class=" bread-cat bread-custom-post-type-' . $post_type . '" href="' . $post_type_archive . '" title="' . $post_type_object->labels->singular_name . '">' . $post_type_object->labels->singular_name . '</a></li>';
                     $innerHtml .= '<li class="separator separator-pd"> ' . $separator . ' </li>';
                  }
                 
               }
                 
               $custom_tax_name = get_queried_object()->name;
               $innerHtml .= '<li class="item-current item-archive"><strong class="bread-current bread-archive ">' . $custom_tax_name . '</strong></li>';
                 
            } else if ( is_single() ) {

               $post_type = get_post_type();
               $taxonomies = get_object_taxonomies($post_type);
               if($post_type != 'post' && empty($taxonomies)) {
                     
                  $post_type_object = get_post_type_object($post_type);
                  $post_type_archive = get_post_type_archive_link($post_type);

                  $innerHtml .= '<li class="item-cat item-custom-post-type-' . $post_type . '"><a class=" bread-cat bread-custom-post-type-' . $post_type . '" href="' . $post_type_archive . '" title="' . $post_type_object->labels->name . '">' . $post_type_object->labels->name . '</a></li>';
                  $innerHtml .= '<li class="separator separator-pd"> ' . $separator . ' </li>';
                 
               }
                 
               // Get post category
               $category = get_the_category();
                
               if(!empty($category)) {
                 
                  // Last category post is in
                  $last_category = $category[count($category) - 1];

                  // Parent any categories and create array
                  $get_cat_parents = rtrim(get_category_parents($last_category->term_id, true, ','),',');
                  $cat_parents = explode(',',$get_cat_parents);

                  // Loop through parent categories and store in variable $cat_display
                  $cat_display = '';
                  foreach($cat_parents as $parents) {
                     $cat_display .= '<li class="item-cat">'.$parents.'</li>';
                     $cat_display .= '<li class="separator separator-pd"> ' . $separator . ' </li>';
                  }
                
               }

               if(empty($last_category) && !empty($taxonomies[0])) {
                      
                  $taxonomy_terms = get_the_terms( $post->ID, $taxonomies[0] );
                  if(!empty($taxonomy_terms)){

                     $cat_id         = $taxonomy_terms[0]->term_id;
                     $cat_nicename   = $taxonomy_terms[0]->slug;
                     $cat_link       = get_term_link($taxonomy_terms[0]->term_id, $taxonomies[0]);
                     $cat_name       = $taxonomy_terms[0]->name;
                  }
                  
               }
                 
               // If the post is in a category
               if(!empty($last_category)) {
                  $innerHtml .= $cat_display;
                  $innerHtml .= '<li class="item-current item-' . $post->ID . '"><strong class=" bread-current bread-' . $post->ID . '" title="' . get_the_title() . '">' . get_the_title() . '</strong></li>';
                     
               // Post is in a custom taxonomy
               } else if(!empty($cat_id)) {
                     
                  $innerHtml .= '<li class="item-cat item-cat-' . $cat_id . ' item-cat-' . $cat_nicename . '"><a class=" bread-cat bread-cat-' . $cat_id . ' bread-cat-' . $cat_nicename . '" href="' . $cat_link . '" title="' . $cat_name . '">' . $cat_name . '</a></li>';
                  $innerHtml .= '<li class="separator separator-pd"> ' . $separator . ' </li>';
                  $innerHtml .= '<li class="item-current item-' . $post->ID . '"><strong class=" bread-current bread-' . $post->ID . '" title="' . get_the_title() . '">' . get_the_title() . '</strong></li>';
                 
               } else {
                     
                  $innerHtml .= '<li class="item-current item-' . $post->ID . '"><strong class=" bread-current bread-' . $post->ID . '" title="' . get_the_title() . '">' . get_the_title() . '</strong></li>';
                     
               }
                 
            } else if ( is_category() ) {   
               // Category page
               $innerHtml .= '<li class="item-current item-cat"><strong class=" bread-current bread-cat">' . single_cat_title('', false) . '</strong></li>';
                  
            } else if ( is_page() ) {
                  
               // Standard page
               if( $post->post_parent ){
                      
                  // Get parents 
                  $anc = get_post_ancestors( $post->ID );
                   
                  // Get parents order
                  $anc = array_reverse($anc);
                   
                  // Parent pages
                  if ( !isset( $parents ) ) $parents = null;
                  foreach ( $anc as $ancestor ) {
                     $parents .= '<li class="item-parent item-parent-' . $ancestor . '"><a class=" bread-parent bread-parent-' . $ancestor . '" href="' . get_permalink($ancestor) . '" title="' . get_the_title($ancestor) . '">' . get_the_title($ancestor) . '</a></li>';
                     $parents .= '<li class="separator separator-pd separator-' . $ancestor . '"> ' . $separator . ' </li>';
                  }
                   
                  // Render parent pages
                  $innerHtml .= $parents;
                   
                  // Active page
                  $innerHtml .= '<li class=" item-current item-' . $post->ID . '"><strong title="' . get_the_title() . '"> ' . get_the_title() . '</strong></li>';
                      
               } else {
                      
                  // Just display active page if not parents pages
                  $innerHtml .= '<li class="item-current item-' . $post->ID . '"><strong class=" bread-current bread-' . $post->ID . '"> ' . get_the_title() . '</strong></li>';
                      
               }
                  
            } else if ( is_tag() ) { // Tag page    
               // Tag information
               $term_id        = get_query_var('tag_id');
               $taxonomy       = 'post_tag';
               $args           = 'include=' . $term_id;
               $terms          = get_terms( $taxonomy, $args );
               $get_term_id    = $terms[0]->term_id;
               $get_term_slug  = $terms[0]->slug;
               $get_term_name  = $terms[0]->name;
                  
               // Return tag name
               $innerHtml .= '<li class="item-current item-tag-' . $get_term_id . ' item-tag-' . $get_term_slug . '"><strong class=" bread-current bread-tag-' . $get_term_id . ' bread-tag-' . $get_term_slug . '">' . $get_term_name . '</strong></li>';
              
            } elseif ( is_day() ) { // Day archive page
                  
               // Year link
               $innerHtml .= '<li class="item-year item-year-' . get_the_time('Y') . '"><a class=" bread-year bread-year-' . get_the_time('Y') . '" href="' . get_year_link( get_the_time('Y') ) . '" title="' . get_the_time('Y') . '">' . get_the_time('Y') . ' Archives</a></li>';
               $innerHtml .= '<li class="separator separator-pd separator-' . get_the_time('Y') . '"> ' . $separator . ' </li>';
                  
               // Month link
               $innerHtml .= '<li class="item-month item-month-' . get_the_time('m') . '"><a class=" bread-month bread-month-' . get_the_time('m') . '" href="' . get_month_link( get_the_time('Y'), get_the_time('m') ) . '" title="' . get_the_time('M') . '">' . get_the_time('M') . ' Archives</a></li>';
               $innerHtml .= '<li class="separator separator-pd separator-' . get_the_time('m') . '"> ' . $separator . ' </li>';
                  
               // Day display
               $innerHtml .= '<li class="item-current item-' . get_the_time('j') . '"><strong class=" bread-current bread-' . get_the_time('j') . '"> ' . get_the_time('jS') . ' ' . get_the_time('M') . ' Archives</strong></li>';
                  
            } else if ( is_month() ) { // Month Archive
                  
               // Year link
               $innerHtml .= '<li class="item-year item-year-' . get_the_time('Y') . '"><a class=" bread-year bread-year-' . get_the_time('Y') . '" href="' . get_year_link( get_the_time('Y') ) . '" title="' . get_the_time('Y') . '">' . get_the_time('Y') . ' Archives</a></li>';
               $innerHtml .= '<li class="separator separator-pd separator-' . get_the_time('Y') . '"> ' . $separator . ' </li>';
                  
               // Month display
               $innerHtml .= '<li class="item-month item-month-' . get_the_time('m') . '"><strong class=" bread-month bread-month-' . get_the_time('m') . '" title="' . get_the_time('M') . '">' . get_the_time('M') . ' Archives</strong></li>';
                  
            } else if ( is_year() ) { // Display year archive

               $innerHtml .= '<li class="item-current item-current-' . get_the_time('Y') . '"><strong class=" bread-current bread-current-' . get_the_time('Y') . '" title="' . get_the_time('Y') . '">' . get_the_time('Y') . ' Archives</strong></li>';
                  
            } else if ( is_author() ) { // Author archive
                  
               // Get the author information
               global $author;
               $userdata = get_userdata( $author );
                  
               // Display author name
               $innerHtml .= '<li class="item-current item-current-' . $userdata->user_nicename . '"><strong class=" bread-current bread-current-' . $userdata->user_nicename . '" title="' . $userdata->display_name . '">' . 'Author: ' . $userdata->display_name . '</strong></li>';
              
            } else if ( get_query_var('paged') ) {
                  
               // Paginated archives
               $innerHtml .= '<li class="item-current item-current-' . get_query_var('paged') . '"><strong class=" bread-current bread-current-' . get_query_var('paged') . '" title="Page ' . get_query_var('paged') . '">'.__('Page') . ' ' . get_query_var('paged') . '</strong></li>';
                  
            } else if ( is_search() ) {
              
               // Search results page
               $innerHtml .= '<li class="item-current item-current-' . get_search_query() . '"><strong class=" bread-current bread-current-' . get_search_query() . '" title="Search results for: ' . get_search_query() . '">Search results for: ' . get_search_query() . '</strong></li>';
              
            } elseif ( is_404() ) {
                  
               // 404 page
               $innerHtml .= '<li class="">' . 'Error 404' . '</li>';

            } else if (is_home()){
               // Just display active page if not parents pages
                  $innerHtml .= '<li class="item-current item-' . $post->ID . '"><strong class=" bread-current bread-' . $post->ID . '"> ' . get_the_title( get_option('page_for_posts', true) ) . '</strong></li>';
            }

            echo '<div class="sapid-breadcrumb-bar-wrapper pt-4"><div class="'.$container_class.'sapid-breadcrumb-bar"><ul id="' . $breadcrumbs_id . '" class="' . $breadcrumbs_class . '"> '.$innerHtml.'</ul></div></div>';  
         }
      }
   }
}

// function that runs when shortcode is called
function sapid_breadcrumbs_shortcode() { 
  ob_start();
   sapid_breadcrumbs(); 
   $output = ob_get_clean();
   return $output;
}
// register shortcode
add_shortcode('sapid_breadcrumbs', 'sapid_breadcrumbs_shortcode');


if ( ! function_exists( 'sapid_pagination' ) ) {
   /**
    * Number based pagination.
    *
    * @since 1.0
    * @param string|int    $max_pages       Maximum number of pages.
    * @param integer       $range           How many page numbers to display to either side of the current page.
    * @param string|Object $current_query   The current query.
    * @param string|$class  class.
    * @return string                     The pagination markup.
    */
   function sapid_pagination( $max_pages = '', $range = 1, $current_query = '', $class= '' ) {
      global $paged, $wp_query;

      $start_range = 4;
      $end_range   = 4;

      if ( '' === $current_query ) {
         $current_page = ( empty( $paged ) ) ? 1 : $paged;
      } else {
         $current_page = $current_query->query_vars['paged'];
      }

      if ( '' === $max_pages ) {
         if ( '' === $current_query ) {
            $max_pages = $wp_query->max_num_pages;
            $max_pages = ( ! $max_pages ) ? 1 : $max_pages;
         } else {
            $max_pages = $current_query->max_num_pages;
         }
      }
      $max_pages    = intval( $max_pages );
      $current_page = intval( $current_page );
      $output       = '';

      if ( 1 !== $max_pages ) {

         $output .= '<ul class="pagination clearfix mt-3 mb-4 '.$class.'">';

         $start = $current_page - $range;
         $end   = $current_page + $range;
         if ( 0 >= $start ) {
            $start = ( 0 < $current_page - 1 ) ? $current_page - 1 : 1;
         }

         if ( $max_pages < $end ) {
            $end = $max_pages;
         }

         if ( 1 < $current_page ) {
            $output .= '<li class="page-item"><a class="pagination-prev page-link" rel="prev" href="' . esc_url( get_pagenum_link( $current_page - 1 ) ) . '">';
            $output .= '<span class="page-prev mdi mdi-chevron-left"></span>';
            $output .= '<span class="page-text">' . esc_html__( 'Previous', 'Sapid' ) . '</span>';
            $output .= '</a></li>';

            if ( 0 < $start_range ) {
               if ( $start_range >= $start ) {
                  $start_range = $start - 1;
               }

               for ( $i = 1; $i <= $start_range; $i++ ) {
                  $output .= '<li class="page-item"><a href="' . esc_url( get_pagenum_link( $i ) ) . '" class="page-link inactive">' . absint( $i ) . '</a></li>';
               }

               if ( 0 < $start_range && $start_range < $start - 1 ) {
                  $output .= '<li class="page-item disabled"><a href="javascript:void(0)" class="page-link"><span class="pagination-dots paginations-dots-start">&middot;&middot;&middot;</span></a></li>';
               }
            }
         }

         for ( $i = $start; $i <= $end; $i++ ) {
            if ( $current_page === $i ) {
               $output .= '<li class="page-item disabled"><a href="javascript:void(0)" class="page-link"><span class="current">' . absint( $i ) . '</a></span>';
            } else {
               $output .= '<li class="page-item"><a href="' . esc_url( get_pagenum_link( $i ) ) . '" class="page-link inactive">' . absint( $i ) . '</a></li>';
            }
         }

         if ( $current_page < $max_pages ) {

            if ( 0 < $end_range ) {

               if ( $max_pages - $end_range <= $end ) {
                  $end_range = $max_pages - $end;
               }

               $end_range--;

               if ( $end + 1 < $max_pages - $end_range ) {
                  $output .= '<li class="page-item disabled"><a href="javascript:void(0)" class="page-link"><span class="pagination-dots paginations-dots-end">&middot;&middot;&middot;</span></a></li>';
               }

               for ( $i = $max_pages - $end_range; $i <= $max_pages; $i++ ) {
                  $output .= '<li class="page-item"><a href="' . esc_url( get_pagenum_link( $i ) ) . '" class="page-link inactive">' . absint( $i ) . '</a></li>';
               }
            }

            $output .= '<li class="page-item"><a class="page-link pagination-next" rel="next" href="' . esc_url( get_pagenum_link( $current_page + 1 ) ) . '">';
            $output .= '<span class="page-text">' . esc_html__( 'Next', 'Sapid' ) . '</span>';
            $output .= '<span class="page-next mdi mdi-chevron-right"></span>';
            $output .= '</a></li>';
         }

         $output .= '</ul>';
      }

      return $output;
   }
}

if ( ! function_exists( 'sapid_sidebar' ) ) {
   function sapid_sidebar(){
      $is_sidebar  ='';
      $sidebar  ='';
      $sidebar_position  ='';
      if(is_page()){
         $is_sidebar = sapid_get_theme_option('is-page-sidebar');
         $sidebar    = sapid_get_theme_option('page-sidebar');
         $sidebar_position = sapid_get_theme_option('page-sidebar-position');
         if(is_checkout() || is_page( 'cart' ) || is_cart() || is_account_page()){
            $is_sidebar       = sapid_get_theme_option('is-woocommerce-page-sidebar');
            $sidebar    = sapid_get_theme_option('woocommerce-page-sidebar');
            $sidebar_position = sapid_get_theme_option('woocommerce-page-sidebar-position');  
         }
      }elseif(is_single()){
         $is_sidebar = sapid_get_theme_option('is-post-single-sidebar');
         $sidebar    = sapid_get_theme_option('post-single-sidebar');
         $sidebar_position = sapid_get_theme_option('post-single-sidebar-position');
         if(is_product()){
            $is_sidebar       = sapid_get_theme_option('is-single-product-page-sidebar');
            $sidebar    = sapid_get_theme_option('single-product-sidebar');
            $sidebar_position = sapid_get_theme_option('single-product-sidebar-position');    
         }
      }elseif(is_search()){
         $is_sidebar = sapid_get_theme_option('is-search-page-sidebar');
         $sidebar    = sapid_get_theme_option('search-sidebar');
         $sidebar_position = sapid_get_theme_option('search-sidebar-position');
      }elseif(is_home() || is_archive() || is_archive() || is_category() || is_tag()){
         $is_sidebar = sapid_get_theme_option('is-post-category-sidebar');
         $sidebar    = sapid_get_theme_option('post-category-sidebar');
         $sidebar_position = sapid_get_theme_option('post-category-sidebar-position');
         if(is_shop() || is_product_category()){
            $is_sidebar       = sapid_get_theme_option('is-shop-category-page-sidebar');
            $sidebar    = sapid_get_theme_option('shop-category-sidebar');
            $sidebar_position = sapid_get_theme_option('shop-category-sidebar-position');     
         }
      }
      if(!empty($is_sidebar) && !empty($sidebar)){
         include locate_template( 'sidebar.php' );   
      }
   }
}

add_action( 'sapid_sidebar', 'sapid_sidebar' );
add_action( 'woocommerce_sidebar', 'sapid_sidebar' );


if ( ! function_exists( 'sapid_home_slider' ) ) {

   function sapid_home_slider(){
      $is_home_slider = sapid_get_theme_option('is_home_slider');
      if(!empty($is_home_slider)):
         $slider = sapid_get_theme_option('home_slider');
         if(!empty($slider)){
            $sliderDetail = get_page_by_path( $slider, OBJECT, 'sapid-slider' );
            echo do_shortcode('[sapid_slider id='.$sliderDetail->ID.']');
         }
      endif;
   }

}
add_action( 'sapid_sider', 'sapid_home_slider' );

if ( ! function_exists( 'sapid_home_icon_text' ) ) {
   function sapid_home_icon_text(){
      $is_home_text = sapid_get_theme_option('is_home_text');
      if(!empty($is_home_text)):
         $home_text = sapid_get_theme_option('home_text');
         if(!empty($home_text) && count($home_text) > 0){
            echo '<section class="essr m-0 pt-5 pb-0">
               <div class="container">
                  <div class="row">';
                  foreach( $home_text as $text){
                     echo '<div class="col-lg-2 col-md-4 col-6">
                        <div class="card easy text-center">
                           <div><i class="mdi '.$text['icon'].' text-i"></i></div>
                           <div><h5 class="text-dblue mb-3"> '.$text['name'].'</h5></div>
                        </div>
                     </div>';
                  }
                  echo '</div>
               </div>
            </section>';
         }
      endif;
   }
}

add_action( 'sapid_home_icon_text', 'sapid_home_icon_text' );


if ( ! function_exists( 'sapid_home_featured_product' ) ) {
   function sapid_home_featured_product (){
      $is_home_featured_product = sapid_get_theme_option('is_home_featured_product');
      if(!empty($is_home_featured_product)):
         $home_featured_product_heading = sapid_get_theme_option('home_featured_product_heading');
         $home_featured_product_category = sapid_get_theme_option('home_featured_product_category');
         echo '<section class="shop-listing pt-5 pb-0">
            <div class="container">';
            if(!empty($home_featured_product_heading)){
               echo '<div class="row justify-content-center text-center ">
               <h2 class="heading-h2 pb-5">'.$home_featured_product_heading.'</h2>
               </div>';
            }
            echo do_shortcode('[products limit="8" columns="4" category="'.$home_featured_product_category.'"]');
            echo'</div>
         </section>';
      endif;
   }
}
add_action( 'sapid_home_featured_product', 'sapid_home_featured_product' );

if ( ! function_exists( 'sapid_home_featured_category' ) ) {

   function sapid_home_featured_category (){
      $is_home_featured_category = sapid_get_theme_option('is_home_featured_category');
      $html ='';
      if(!empty($is_home_featured_category)):
         $home_featured_category_heading = sapid_get_theme_option('home_featured_category_heading');
         $home_featured_category = sapid_get_theme_option('home_featured_category');
         $html =  '<section class="shop-category blogs bg-white mt-0 pt-4 pb-0">
            <div class="container">';
               if(!empty($home_featured_category_heading)){
                  $html .= '<div class="row justify-content-center text-center ">
                     <h2 class="heading-h2 pb-5">'.$home_featured_category_heading.'</h2>
                  </div>';
               }
               if(!empty($home_featured_category) && count($home_featured_category) > 0){
                  $html .= '<div class="row justify-content-center">';
                  foreach ($home_featured_category as $key => $home_featured_category) {
                     $categories = get_term_by( 'slug', $home_featured_category, 'product_cat' );
                     $thumbnail_id = get_term_meta( $categories->term_id, 'thumbnail_id', true );
                     $image_url = wp_get_attachment_url( $thumbnail_id );
                     $image_url = !empty($image_url) ? $image_url:get_template_directory_uri().'/assets/images/thumb.png';
                     $html .= '<div class="col-md-4 aos-init">
                        <div class="card mt-0 mb-5">
                           <picture> <img src="'.$image_url.'" alt="'.$categories->name.'"> </picture>
                           <div class="card-body">
                                <a href="'.get_term_link($categories).'" class="d-flex justify-content-between">'.$categories->name.'</a>
                           </div>
                        </div>
                     </div>';
                  }
               }
              $html .= '</div>
            </div>
         </section>';
      endif;
      echo $html; 
   }
}

add_action( 'sapid_home_featured_category', 'sapid_home_featured_category' );

if ( ! function_exists( 'sapid_home_about_us' ) ) {
   function sapid_home_about_us(){
      $is_home_about_section = sapid_get_theme_option('is_home_about_section');
      $html = '';
      if(!empty($is_home_about_section)):
         $home_about_heading = sapid_get_theme_option('home_about_heading');
         $home_about_text = sapid_get_theme_option('home_about_text');
         $home_about_image = sapid_get_theme_option('home_about_image');
         $home_about_call_to_text = sapid_get_theme_option('home_about_call_to_text');
         $home_about_call_to_link = sapid_get_theme_option('home_about_call_to_link');
         $home_about_image = !empty($home_about_image) ? $home_about_image:get_template_directory_uri().'/assets/images/thumb.png';
         $html = '<section class="software-flexcard m-0 pt-5 pb-5">
           <div class="container">
             <div class="row">
               <div class="col-md-4 col-lg-5">
                 <img src="'.$home_about_image.'" alt="s1" class="w-100">
               </div>
               <div class="col-md-8 col-lg-7 pt-3">
                 <h2 class="heading-h2">'.$home_about_heading.'</h2>
                 <p class="mb-2 f-w">'.$home_about_text.'</p>
                 <div class="row ">
                   <div class="col-12 mb-2">
                     <a class="main-solid-btn" href="'.$home_about_call_to_link.'"> <span>'.$home_about_call_to_text.'<i class="fa mdi mdi-arrow-right"></i> </span> </a>
                   </div>
                 </div>
               </div>
             </div>
           </div>
         </section>';
      endif;
      echo $html;  
   }
}

add_action( 'sapid_home_about_us', 'sapid_home_about_us' );
if ( ! function_exists( 'get_blogs' ) ) {
   function get_blogs( $posts_per_page = -1, $orderby = 'ID', $order ='desc', $title ='') {
      $args = array(
         'posts_per_page' => (int) $posts_per_page,
         'post_type' => 'post',
         'orderby' => $orderby,
         'order' => $order,
      );
      $query = new WP_Query( $args  );
      $blogs = '<section class="blogs m-0 pt-5 pb-5 bg-sec">
         <div class="container">';
            if(!empty($title)){
               $blogs .= '<div class="row justify-content-center text-center">
                 <div class="col-lg-6 col-md-8">
                   <h2 class="text-dblue pb-5">'.$title.'</h2>
                 </div>
               </div>';
            }
            $blogs .= '<div class="row">';
               if ( $query->have_posts() ) {
                  while ( $query->have_posts() ) : $query->the_post();
                     $catHtml ='';
                     $post_id = $query->post->ID;
                     $post_title = $query->post->post_title;
                     $image = wp_get_attachment_url( get_post_thumbnail_id($post_id));
                     $image = !empty($image) ? $image:get_template_directory_uri().'/assets/images/thumb.png';
                     $url = get_permalink();
                     $categories = wp_get_post_categories(get_the_ID());
                     foreach($categories as $category){
                        $catHtml .='<a class="text-dblue-sub f-w" href="' . get_category_link($category) . '">' . get_cat_name($category) . '</a>';
                     }

                     $blogs .= '<div class="col-md-6 col-lg-4">
                           <div class="card mt-lg-0">
                              <picture> <img src="'.$image.'" alt="'.$post_title.'"> </picture>
                              <div class="card-body">
                                 <div class="d-flex justify-content-between mb-3"> '.$catHtml.'<span class="text-dblue">'.get_the_date( 'F j, Y' ).'</span> </div>
                                 <h3 class="text-dblue f-w fs-5">'.$post_title.'</h3>            
                                 <p class="text-dblue f-w pt-2">'.get_the_excerpt().'</p>
                              </div>
                           </div>
                        </div>';
                  endwhile;
                  wp_reset_postdata();
               }
            $blogs .= '</div>
         </div>
      </section>';
      return $blogs;
   }
}

add_shortcode( 'blogs', 'blogs_shortcode' );
/**
 * Shortcode to display blogs
 *
 * [blogs posts_per_page="3" orderby="ID" order="desc"]
 */
function blogs_shortcode( $atts ) {
   extract( shortcode_atts( array(
      'posts_per_page' => 3,
      'orderby' => 'ID',
      'order' => 'desc',
      'title' => 'Latest from Our Blog',
   ), $atts ) );

   return get_blogs( $posts_per_page, $orderby, $order, $title);
}


function sapid_home_blogs(){
   $is_home_blog_section = sapid_get_theme_option('is_home_blog_section'); 
   if(!empty($is_home_blog_section)):
      $title = sapid_get_theme_option('home_blog_heading'); 
      echo do_shortcode('[blogs posts_per_page="3" orderby="ID" order="desc" title="'.$title.'"]');
   endif;
}

add_action('sapid_home_blogs', 'sapid_home_blogs');

if ( ! function_exists( 'sapid_number_format_short' ) ) {
   function sapid_number_format_short($n) {
     // first strip any formatting;
     $n = (0+str_replace(",", "", $n));
     // is this a number?
     if (!is_numeric($n)) return false;
      // now filter it;
     if ($n > 1000000000000) return round(($n/1000000000000), 2).'T';
     elseif ($n > 1000000000) return round(($n/1000000000), 2).'B';
     elseif ($n > 1000000) return round(($n/1000000), 2).'M';
     elseif ($n > 1000) return round(($n/1000), 2).'K';

     return number_format($n);
   }
}

if (!function_exists("sapid_json_validate")) {
   function sapid_json_validate($string){
        // decode the JSON data
        $result = json_decode($string, true);
        $error = 1;
        // switch and check possible JSON errors
        switch (json_last_error()) {
            case JSON_ERROR_NONE:
                $error = 0;
                $message = "theme setting JSON data sucessfully import"; // JSON is valid // No error has occurred
                break;
            case JSON_ERROR_DEPTH:
                $message = "The maximum stack depth has been exceeded.";
                break;
            case JSON_ERROR_STATE_MISMATCH:
                $message = "Invalid or malformed JSON.";
                break;
            case JSON_ERROR_CTRL_CHAR:
                $message =
                    "Control character error, possibly incorrectly encoded.";
                break;
            case JSON_ERROR_SYNTAX:
                $message = "Syntax error, malformed JSON.";
                break;
            // PHP >= 5.3.3
            case JSON_ERROR_UTF8:
                $message =
                    "Malformed UTF-8 characters, possibly incorrectly encoded.";
                break;
            // PHP >= 5.5.0
            case JSON_ERROR_RECURSION:
                $message =
                    "One or more recursive references in the value to be encoded.";
                break;
            // PHP >= 5.5.0
            case JSON_ERROR_INF_OR_NAN:
                $message =
                    "One or more NAN or INF values in the value to be encoded.";
                break;
            case JSON_ERROR_UNSUPPORTED_TYPE:
                $message =
                    "A value of a type that cannot be encoded was given.";
                break;
            default:
                $message = "Unknown JSON error occured.";
                break;
        }

      return ["result" => $result, "message" => $message, "error" => $error];
   }
}

if (!function_exists("available_widgets")) {
   function available_widgets(){
      global $wp_registered_widget_controls;
      $widget_controls = $wp_registered_widget_controls;
      $available_widgets = array();
      foreach ($widget_controls as $widget) {
         // No duplicates.
         if (! empty( $widget['id_base'] ) && ! isset( $available_widgets[ $widget['id_base'] ] )) {
            $available_widgets[ $widget['id_base'] ]['id_base'] = $widget['id_base'];
            $available_widgets[ $widget['id_base'] ]['name']    = $widget['name'];
         }
      }

      return $available_widgets;
   }
}


if (!function_exists("sapid_widget_import")) {
   function sapid_widget_import() {

      $directory = trailingslashit( get_template_directory_uri() );
      // Define the URL
      $url = $directory . 'dummy-data/sapid_widgets.json';

      // Make the request
      $request = wp_remote_get( $url );

      // If the remote request fails, wp_remote_get() will return a WP_Error, so let’s check if the $request variable is an error:
      if( is_wp_error( $request ) ) {
         return false; // Bail early
      }

      // Retrieve the data
      $body = wp_remote_retrieve_body( $request );
      $data = json_decode( $body );
      // Have valid data?
      // If no data or could not decode.
      if (empty($data) || ! is_object($data)) {
         return false; // Bail early
      }

      // Get all available widgets site supports.
      $available_widgets = available_widgets();

      $results = array();
      $sidebars_widgets = get_option('sidebars_widgets');
      if(!empty($sidebars_widgets) && count($sidebars_widgets) > 0){
         foreach($sidebars_widgets as $key => $sidebars_widget){
            if(in_array($key, ['wp_inactive_widgets', 'sidebar-1', 'footer-v6-1' ,'footer-v6-2', 'footer-v6-3','footer-v6-4'])){
               $sidebars_widgets[$key] = [];
            }  
         }
         update_option('sidebars_widgets', $sidebars_widgets);
      }
      $widgetsArr = [];
      // Loop import data's sidebars.
      foreach ($data as $sidebar_id => $widgets) {
        // Skip inactive widgets (should not be in export file).
        if ('wp_inactive_widgets' === $sidebar_id) {
            continue;
        }
        $use_sidebar_id       = $sidebar_id;
        // Loop widgets.
         foreach ($widgets as $widget_instance_id => $widget) {
            $fail                = false;
            $id_base            = preg_replace('/-[0-9]+$/', '', $widget_instance_id);
            $instance_id_number = str_replace($id_base . '-', '', $widget_instance_id);
            // Does site support this widget?
            if (!isset($available_widgets[$id_base])) {
               $fail                = true;
            }

            $widget = json_decode(wp_json_encode($widget), true);
            if (! $fail) {
               // Add widget instance
               if(!empty($widget['nav_menu']) && $id_base == 'sapid_nav_menu'){
                  if($widget['title'] =='CATEGORIES'){
                     $cmenu = get_term_by('name', 'Collection Menu', 'nav_menu');
                     if(!empty($cmenu)){
                        $widget['nav_menu'] = $cmenu->term_id;
                     }
                  }
                  if($widget['title'] =='QUICK LINKS'){
                     $menu = get_term_by('name', 'Quick links', 'nav_menu');
                     if(!empty($menu)){
                        $widget['nav_menu'] = $menu->term_id;
                     }
                  }
               }
               if(!in_array($id_base, $widgetsArr)){
                  update_option('widget_' . $id_base, array( '_multiwidget' => 1 ));
               }

               $single_widget_instances   = get_option('widget_' . $id_base); // All instances for that widget ID base, get fresh every time.
               $single_widget_instances   = ! empty($single_widget_instances) ? $single_widget_instances : array(
                 '_multiwidget' => 1,   // Start fresh if have to.
               );
               $single_widget_instances[] = $widget; // Add it.

               // Get the key it was given.
               end($single_widget_instances);
               $new_instance_id_number = key($single_widget_instances);
               // If key is 0, make it 1
               // When 0, an issue can occur where adding a widget causes data from other widget to load,
               // and the widget doesn't stick (reload wipes it).
               if ('0' === strval($new_instance_id_number)) {
                 $new_instance_id_number = 1;
                 $single_widget_instances[$new_instance_id_number] = $single_widget_instances[0];
                 unset($single_widget_instances[0]);
               }
               // Move _multiwidget to end of array for uniformity.
               if (isset($single_widget_instances['_multiwidget'])) {
                 $multiwidget = $single_widget_instances['_multiwidget'];
                 unset($single_widget_instances['_multiwidget']);
                 $single_widget_instances['_multiwidget'] = $multiwidget;
               }

               // Update option with new widget.
               update_option('widget_' . $id_base, $single_widget_instances);

               // Assign widget instance to sidebar.
               // Which sidebars have which widgets, get fresh every time.
               $sidebars_widgets = get_option('sidebars_widgets');

               // Avoid rarely fatal error when the option is an empty string
               // https://github.com/churchthemes/widget-importer-exporter/pull/11.
               if (! $sidebars_widgets) {
                 $sidebars_widgets = array();
               }
               // Use ID number from new widget instance.
               $new_instance_id = $id_base . '-' . $new_instance_id_number;

               // Add new instance to sidebar.
               $sidebars_widgets[$use_sidebar_id][] = $new_instance_id;

               // Save the amended data.
               update_option('sidebars_widgets', $sidebars_widgets);
               $widgetsArr[] = $id_base;
            }
         }
      }
   }
}

if (!function_exists("sapid_theme_setting_data_import")) {
   function sapid_theme_setting_data_import() {

      $directory = trailingslashit( get_template_directory_uri() );
      // Define the URL
      $url = $directory . 'dummy-data/sapid_options.json';

      // Make the request
      $request = wp_remote_get( $url );

      // If the remote request fails, wp_remote_get() will return a WP_Error, so let’s check if the $request variable is an error:
      if( is_wp_error( $request ) ) {
         return false; // Bail early
      }

      // Retrieve the data
      $import_data = wp_remote_retrieve_body( $request );

      $is_validate_json = sapid_json_validate($import_data);
      $status = 0;
      if(empty($is_validate_json['error'])){
         $status = 1;
         $import = $is_validate_json['result'];
         //echo "<pre>"; print_r($import); die;
         update_option( 'sapid_options', $import );
      }
   }
}

if (!function_exists("import_demo_theme_setting")) {
   function import_demo_theme_setting() {
      sapid_theme_setting_data_import();
      sapid_widget_import();
   }
}