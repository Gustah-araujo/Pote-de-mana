<?php 


    add_action('wp_enqueue_scripts', 'pote_enqueue_scripts');
    add_action('wp_enqueue_scripts', 'pote_dequeue_scripts', 9999);
    
    add_filter('woocommerce_account_menu_items', 'remove_downloads_from_my_account', 10, 2);




    function pote_enqueue_scripts() {

        wp_enqueue_style(
            'sapid-ecommerce-child-style',
            get_stylesheet_uri(),
            ['sapid-style', 'sapid-css-style']
        );

        wp_enqueue_script('sapid-script-child', get_stylesheet_directory_uri() . '/assets/js/script.js', ['jquery']);

        wp_localize_script( 'sapid-script-child', 'frontend_header_object',
            array( 
                'ajaxurl' => admin_url( 'admin-ajax.php' ),
                'header_sticky' => sapid_get_theme_option( 'header-sticky' ),
            )
        );

        wp_localize_script( 'sapid-script-child', 'live_search_object',
            array( 
                'live_search_min_char_count' => sapid_get_theme_option( 'live-search-min-char-count' ),
            )
        );

    }

    function pote_dequeue_scripts() {

        wp_dequeue_script('sapid-script');

    }

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
     
           $item = '<li class="nav-item dropdown menu-mini-cart"><a href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true"  class="dropdown-back sapid-mini-cart-box" data-toggle="dropdown"> ';
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

    function remove_downloads_from_my_account($items, $endpoints) {
        if( isset( $items['downloads'] ) ) {
            unset( $items['downloads'] );
        }

        return $items;
    }


?>