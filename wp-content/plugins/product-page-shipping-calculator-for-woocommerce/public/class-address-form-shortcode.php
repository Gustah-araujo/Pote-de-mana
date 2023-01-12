<?php

class pisol_ppscw_address_form_shortcode{
    function __construct(){
        add_shortcode('pi_address_form', array($this, 'addressForm'));
    }

    function addressForm(){
        return pisol_ppscw_address_form::getAddressForm(__('Update Address','pisol-product-page-shipping-calculator-woocommerce'));
    }
}
new pisol_ppscw_address_form_shortcode();