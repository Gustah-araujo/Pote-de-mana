<?php

class pisol_ppscw_reset_logedin_customer_address{
    function __construct(){
        add_filter('woocommerce_checkout_get_value', array($this, 'resetFields'),10,2);
    }

    function resetFields($val, $input){

        if(apply_filters( 'woocommerce_ship_to_different_address_checked', 'shipping' === get_option( 'woocommerce_ship_to_destination' ) ? 1 : 0 )){
            return null;
        }

        if(isset(WC()->customer)){
            switch($input){
                case 'billing_country':
                    $country = WC()->customer->get_shipping_country();
                    if(!empty($country)) return $country;
                break;

                case 'billing_state':
                    $state = WC()->customer->get_shipping_state();
                    if(!empty($state)) return $state;
                break;

                case 'billing_city':
                    $city = WC()->customer->get_shipping_city();
                    if(!empty($city)) return $city;
                break;

                case 'billing_postcode':
                    $postcode = WC()->customer->get_shipping_postcode();
                    if(!empty($postcode)) return $postcode;
                break;

            }
        }
        return null;
    }
}
new pisol_ppscw_reset_logedin_customer_address();