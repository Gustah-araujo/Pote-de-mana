<?php

class pisol_ppscw_address_form{

    function __construct(){
        add_action('wp_ajax_pisol_save_address_form', array($this, 'saveAddress') );
        add_action('wp_ajax_nopriv_pisol_save_address_form', array($this, 'saveAddress') );

        /**
         * This is needed as wc session is not created for non-loged in users
         */
        add_action( 'woocommerce_init',  array($this, 'startSession') );
    }

    function startSession(){
        if(function_exists('WC') && isset(WC()->session)){
            if ( !is_admin() && !WC()->session->has_session() ) {
                WC()->session->set_customer_session_cookie( true );
            }
        }
    } 

    static function getAddressForm($update_address_btn_text = 'Update address', $layout = 'pi-vertical'){
        if(!function_exists('WC') || !isset(WC()->customer) || !isset(WC()->countries)) return;

        ob_start();
        include 'partials/address-form.php';
        $html = ob_get_contents();
        ob_end_clean();
        return $html;
    }

    function saveAddress(){
        WC_Shortcode_Cart::calculate_shipping();
        $error = wc_print_notices(true);
        if(!empty($error) && strpos($error,'woocommerce-error') !== false){
            wp_send_json_error($this->errorTemplate($error));
        }else{
            $this->getMessage();
        }
        die;
    }

    function getMessage(){
        $popup_function = get_option('pi_ppscw_address_form_working', 'save-location');
        if($popup_function == 'save-location'){
            $msg = __('Your details are saved','pisol-product-page-shipping-calculator-woocommerce');
        }elseif($popup_function == 'show-shipping-available' || $popup_function == 'show-shipping-available-method'){

			WC()->cart->calculate_totals();
            
            if(WC()->cart->get_cart_contents_count() == 0 ){
				$blank_package = pisol_ppscw_product_page_calculator::get_shipping_packages();
				WC()->shipping()->calculate_shipping($blank_package );
			}

            $shipping_methods = WC()->shipping()->get_packages();
            $rates = self::getShippingMethods($shipping_methods);
            if(empty($rates)){
                $msg = __('We do not provide shipping to this location', 'pisol-product-page-shipping-calculator-woocommerce');
                wp_send_json_error($this->errorTemplate($msg));
                return;
            }else{
                $msg = __('We provide shipping to your location','pisol-product-page-shipping-calculator-woocommerce');
            }
        }

        wp_send_json_success($this->successTemplate($msg, $rates));
    }
    
    static function getShippingMethods($packages){
		$shipping_methods = array();
		foreach($packages as $package){
			if(empty($package['rates']) || !is_array($package['rates'])) break;

			foreach($package['rates'] as $id => $rate){
				$title = wc_cart_totals_shipping_method_label($rate);
				$shipping_methods[$id] = $title;
			}
		}
		return $shipping_methods;
	}

    function errorTemplate($msg){
        $msg = strip_tags($msg);
        return '<div class="pi-address-form-error">'.$msg.'</div>';
    }

    function successTemplate($msg, $shipping_methods = array()){
        $msg = strip_tags($msg);
        $methods = $this->getShippingMethod($shipping_methods);
        return '<div class="pi-address-form-success">'.$msg.$methods.'</div>';
    }

    function getShippingMethod($shipping_methods){
        $show_method = get_option('pi_ppscw_address_form_working','save-location');

        if(empty($shipping_methods) || $show_method !== 'show-shipping-available-method') return;

        $html = '<ul class="pisol-ppscw-shipping-method-list">';
        foreach($shipping_methods as $shipping_method){
            $html .= '<li>'.$shipping_method.'</li>';
        }
        $html .= '</ul>';
        return $html;
    }
}

new pisol_ppscw_address_form();