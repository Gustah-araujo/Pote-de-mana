<?php
/**
 * this is needed so we can directly access the quantity field by product id
 */
class pisol_ppscw_change_quantity_id{
    function __construct(){
        add_filter( 'woocommerce_quantity_input_args', array($this, 'makeIDBasedOnProductID'),10,2);
    }

    function makeIDBasedOnProductID($arg, $product){
        if(function_exists('is_product') && is_product()){
            $id = 'quantity_'.$product->get_id();
            $arg['input_id'] = $id;
        }
        return $arg;
    }
}
new pisol_ppscw_change_quantity_id();