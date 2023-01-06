<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Sapid_WooCommerce' ) ) :

	/**
	 * The main Sapid_WooCommerce class
	 */
	class Sapid_WooCommerce {

		/**
		 * Setup class.
		 *
		 * @since 1.0
		 */
		public function __construct() {
            add_action( 'wp', array( $this, 'wpsapid' ), 20 );
            add_filter( 'loop_shop_per_page', array( $this, 'sapid_loop_shop_per_page' ), 2);
            add_filter( 'loop_shop_columns',  array( $this, 'sapid_loop_shop_columns' ), 2);
            add_filter( 'woocommerce_output_related_products_args', array( $this,'sapid_related_products_args') );
            /**
            * Remove the breadcrumbs 
            */
            add_action( 'init', array( $this,'sapid_remove_wc_breadcrumbs') );
            add_action( 'woocommerce_before_shop_loop_item_title', array( $this, 'sapid_woo_badge_text') );
            add_action( 'woocommerce_sale_flash', array( $this, 'sapid_woo_badge_text') );
            add_filter( 'woocommerce_get_availability_text', array( $this, 'sapid_woo_badge_text'), 10, 2 );
            add_filter( 'woocommerce_product_get_rating_html', array( $this, 'sapid_product_get_rating_html'), 20, 3);

            add_filter( 'woocommerce_product_single_add_to_cart_text', array( $this, 'sapid_woo_add_to_cart_text')); 
            add_filter( 'woocommerce_product_add_to_cart_text', array( $this, 'sapid_woo_add_to_cart_text') );
            add_filter( 'woocommerce_share', array( $this,'spaid_socail_share'));

            remove_action( 'woocommerce_widget_shopping_cart_buttons', 'woocommerce_widget_shopping_cart_button_view_cart', 10 );
            remove_action( 'woocommerce_widget_shopping_cart_buttons', 'woocommerce_widget_shopping_cart_proceed_to_checkout', 20 );
            add_action( 'woocommerce_widget_shopping_cart_buttons', array( $this, 'sapid_widget_shopping_cart_button_view_cart'), 10 );
            add_action( 'woocommerce_widget_shopping_cart_buttons', array( $this, 'sapid_widget_shopping_cart_proceed_to_checkout'), 20 );

            add_filter( 'woocommerce_placeholder_img_src', array( $this,'sapid_woocommerce_placeholder'), 10 );
            
            add_filter( 'the_title', array( $this,'sapid_woocommerce_myaccount_title_change'), 10 );

            add_filter( 'woocommerce_add_to_cart_fragments', array( $this,'sapid_woocommerce_cart_count_fragments'), 5);
		}


        public function wpsapid() {
            if ( empty(sapid_get_theme_option( 'woocommerce-related-product' ) ) )  {
                remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );
            }

            remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5);
            add_action( 'woocommerce_shop_loop_item_title', 'woocommerce_template_loop_rating', 5);

        }
        /**
         * Change number of products that are displayed per page
         *@param `$per_page` for item. 
        */

        public function sapid_loop_shop_per_page( $per_page) {
            if ( sapid_get_theme_option( 'woo-items' ) ) {
                $per_page = sapid_get_theme_option( 'woo-items' );
            }
            return $per_page;
        }

        /**
         * Calls all the sapid loop shop columns.
         * @return Page colums.
        */
        public function sapid_loop_shop_columns( $columns ) {
            if ( sapid_get_theme_option( 'woocommerce-shop-page-columns' ) ) {
                $columns = sapid_get_theme_option( 'woocommerce-shop-page-columns' );
            }
            return $columns;
        }

         /**
         * Calls all the sapid related post per page.
         * @return POST per page.
        */
        public function sapid_related_products_args( $args ) {
            $args['posts_per_page'] = sapid_get_theme_option('woocommerce-related-columns'); // 4 related products
            return $args;
        }

        /**
         * Remove wc breadcrumbs.
        */
        public function sapid_remove_wc_breadcrumbs() {
            remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0 );
            remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper');
        }

        public function sapid_woo_badge_text() {
            global $product;
            if ( ! $product->is_in_stock() ) : ?>
                <span class="sapid-out-of-stock out-of-stock-badge onsale bg-grad-slid lh-sm p-2 rounded-circle d-flex align-items-center">
                    <?php
                    $out_of_stock_label = sapid_get_theme_option( 'woo-outofstock-badge-text' );
                    if ( '' === $out_of_stock_label ) {
                        $out_of_stock_label = __( 'Out of stock', 'Spaid' );
                    }

                        echo esc_html( $out_of_stock_label );
                    ?>
                </span>
            <?php endif; 
            if ( $product->is_on_sale() ) : ?>
                <span class="sapid-sale sale-badge onsale bg-grad">
                    <?php
                    $sale_label = sapid_get_theme_option( 'woo-sale-badge-text' );
                    if ( '' === $sale_label ) {
                        $sale_label = __( 'Sale!', 'Spaid' );
                    }

                    echo esc_html( $sale_label );
                    ?>
                </span>
            <?php endif;
        } 
      
         /**
         * @param $product for check for in_stock or not
         * @return `$text` for outofstock stage.
         */
        public function themeprefix_change_soldout ( $text, $product) {
            if ( !$product->is_in_stock() ) {
                $out_of_stock_label = sapid_get_theme_option( 'woo-outofstock-badge-text' );
                if ( '' === $out_of_stock_label ) {
                    $out_of_stock_label = __( 'Out of stock', 'Spaid' );
                }

                $text = '<span class="sapid-out-of-stock out-of-stock-badge bg-grad-slid lh-sm p-2 rounded-circle d-flex align-items-center">'.$out_of_stock_label.'</span>';
            }
            return $text;
        }

        /**
         * Calls for text  add to cart.
         * button text of add to cart.
        * @return `$add_to_cart_button` variable .
        */   
        public function sapid_woo_add_to_cart_text() {
            $add_to_cart_button = sapid_get_theme_option( 'woo-add-to-cart-button-text' );
            if ( empty($add_to_cart_button )) {
                $add_to_cart_button = __( 'Add to Cart', 'Spaid' );
            }
            return $add_to_cart_button;
        }
        
        public function spaid_socail_share( ){
            sapid_social_sharing();
        }  

        public function sapid_widget_shopping_cart_button_view_cart() {
            echo '<a href="' . esc_url( wc_get_cart_url() ) . '" class="btn btn-default bg-grad-slid text-white sapid-button">' . esc_html__( 'View cart', 'Spaid' ) . '</a>';
        }

        public function sapid_widget_shopping_cart_proceed_to_checkout() {
            echo '<a href="' . esc_url( wc_get_checkout_url() ) . '" class="btn btn-default bg-grad text-white sapid-button float-end">' . esc_html__( 'Checkout', 'Spaid' ) . '</a>';
        }

        public function sapid_woocommerce_placeholder( $image_url ) {
           $image_url = get_template_directory_uri().'/assets/images/thumb.png';
           return $image_url;
        }

        public function sapid_woocommerce_myaccount_title_change( $title ) {
            if( is_account_page() && $title === __('My account', 'Spaid') && ! is_user_logged_in() ) {
                $title = __( 'Account Login / Register', 'Spaid' );
            }
            return $title;
        }

        public function sapid_woocommerce_cart_count_fragments( $fragments ) {
            $fragments['div.basket-item-count'] = '<div class="basket-item-count"><span class="cart-items-count count sapid-cart-count">' .sapid_number_format_short(WC()->cart->get_cart_contents_count()) . '</span></div>';
            return $fragments;
        }

        public function sapid_product_get_rating_html($html, $rating, $count){
            if ( empty($rating) ) {
                $label = sprintf( __( 'Rated %s out of 5', 'woocommerce' ), $rating );
                $html  ='<div class="star-rating" role="img" aria-label="' . esc_attr( $label ) . '">' . wc_get_star_rating_html( $rating, $count ) . '</div>';
                //$html  ='';
            }
            $star_rating = sapid_get_theme_option( 'woocommerce-star-rating-show' );
            if(empty($star_rating)){
                $html  ='';
            }
            return $html;
        }

	}
endif;

return new Sapid_WooCommerce();