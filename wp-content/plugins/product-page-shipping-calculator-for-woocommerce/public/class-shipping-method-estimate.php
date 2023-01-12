<?php

class pisol_ppscw_shipping_methods_estimate{

    function __construct(){
        
        if(!pisol_ppscw_estimate_pro_present()) return;

        if(!class_exists('pisol_edd_plugin_settings') || !class_exists('pisol_edd_message') || !class_exists('pisol_edd_order_estimate')) return ;

        $this->settings = pisol_edd_plugin_settings::init();

        add_filter('pisol_ppscw_shipping_method_name', array($this, 'addShippingEstimate'),10,4);
    }

    function addShippingEstimate($title, $method, $product_id, $variation_id){

        $show_estimate = apply_filters('pisol_ppscw_show_estimate_dates', get_option('pi_ppscw_show_estimate_date',1), $product_id, $variation_id);

        if(empty($show_estimate)) return $title;

        $estimate = $this->methodEstimate($method, $product_id, $variation_id);
        $msg = $this->getMessage($estimate);
        $msg = str_replace('{icon}',"", $msg);
        $message = pisol_edd_message::msg($estimate, $msg, 0, 'method','pi-edd-cart');
        return $title.' '. $message;
    }

    function methodEstimate($method, $product_id, $variation_id){
        $estimate_based_on = get_option('pi_ppscw_show_estimate_as_per','cart'); // product or cart
        $shipping_method_settings = $this->getShippingSetting($method);
        if($estimate_based_on == 'product'){
            return $this->productMethodEstimate($shipping_method_settings, $product_id, $variation_id);
        }else{
            return $this->cartMethodEstimate($shipping_method_settings, $product_id, $variation_id);
        }
    }

    function productMethodEstimate($shipping_method_settings, $product_id, $variation_id){
        $cart_items =  $this->onlyProductBasedCartItems($product_id, $variation_id);
        $estimate = pisol_edd_order_estimate::orderEstimate($cart_items, $shipping_method_settings);
        return $estimate;
    }

    function onlyProductBasedCartItems($product_id, $variation_id){
        $cart_items = WC()->cart->get_cart_contents();
        if(!is_array($cart_items)) return $cart_items;

        foreach($cart_items as $key => $item){
            $cart_product_id = $item['product_id'];
            $cart_variation_id = $item['variation_id'];
            if($product_id != $cart_product_id || $cart_variation_id != $variation_id){
                unset($cart_items[$key]);
            }
        }
        return $cart_items;
    }

    
    function cartMethodEstimate($shipping_method_settings, $product_id, $variation_id){
        $this->cart_items = WC()->cart->get_cart_contents();
        $cart_items =  isset($this->cart_items) && !empty($this->cart_items) ? $this->cart_items : array();
        $estimate = pisol_edd_order_estimate::orderEstimate($cart_items, $shipping_method_settings);
        return $estimate;
    }

    function getShippingSetting($method){
        $method_name = $method->id;
        $shipping_method_settings = pisol_min_max_holidays::getMinMaxHolidaysValues($method_name);
        return $shipping_method_settings;
    }

    function getMessage($estimate){
        if(empty($estimate)) return null;

        $today = current_time('Y/m/d');
        $tomorrow = date('Y/m/d', strtotime($today.' +1 day'));
        $msg = "";
        if(isset($estimate['min_date']) && isset($estimate['max_date']) && !empty($estimate['min_date']) && !empty($estimate['max_date'])){
            
                if($estimate['min_date'] == $estimate['max_date']){
                    $msg = $this->settings['shipping_method_estimate_simple_msg'];
                }else{
                    $msg = $this->settings['shipping_method_estimate_range_msg'];
                }
        }

        if(!empty($this->settings['enable_different_msg_for_same_day_estimate']) && $estimate['min_date'] == $today && $estimate['max_date'] == $today){
            $msg = $this->settings['msg_for_same_day_delivery'];
        }

        if(!empty($this->settings['enable_different_msg_for_next_day_estimate']) && $estimate['min_date'] == $tomorrow && $estimate['max_date'] == $tomorrow){
            $msg = $this->settings['msg_for_next_day_delivery'];
        }
        
        return $msg;
    }

}

new pisol_ppscw_shipping_methods_estimate();