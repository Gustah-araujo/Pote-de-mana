<?php

class pisol_ppscw_product_page_calculator{

    function __construct(){

		$position = apply_filters('pi_ppscw_cal_position_filter', get_option('pi_ppscw_calc_position', 'woocommerce_after_add_to_cart_form'));

        add_action( $position, array(__CLASS__, 'calculator'));

		add_action('wp_ajax_pisol_cal_shipping', array(__CLASS__, 'applyShipping') );
        add_action('wp_ajax_nopriv_pisol_cal_shipping', array(__CLASS__, 'applyShipping') );
		add_filter( 'woocommerce_notice_types',array(__CLASS__, 'onlyPassErrorNotice') );
		
		add_filter('pi_ppscw_hide_calculator_on_single_product_page',array(__CLASS__, 'hideCalculator'),10,2 );

		$result_position = apply_filters('pi_ppscw_result_positon', get_option('pi_ppscw_result_position','pi_ppscw_before_calculate_button'));
		add_action($result_position, array(__CLASS__, 'resultHtml'));

		/**
		 * WooCommerce > Setting > Shipping > Shipping options > "Hide shipping costs until an address is entered"
		 * this option should be disabled, but some time this is enabled so to overcome that issue we will disable this option whenever they are checking through our plugin ajax 
		 */
		add_filter( "option_woocommerce_shipping_cost_requires_address", [$this, 'enableShippingCalculationWithoutAddress']);
    }

	static function resultHtml(){
		echo '<div id="pisol-ppscw-alert-container"></div>';
	}

    static function calculator(){
		global $product;

		

		if(apply_filters('pi_ppscw_hide_calculator_on_single_product_page',false, $product)){
			return;
		}

		if(is_object($product)){
			$product_id = $product->get_id();
		}else{
			$product = "";
		}

		$disable_product = get_post_meta($product_id, 'pisol_disable_shipping_calculator', true);

		if($disable_product === 'disable') return;

		$button_text = get_option('pi_ppscw_open_drawer_button_text','Select delivery location');
		$update_address_btn_text = get_option('pi_ppscw_update_button_text','Update Address');

		include 'partials/shipping-calculator.php';
	}

	static function hideCalculator($val, $product){
		if(is_object($product) && $product->is_virtual()) return true;

		return $val;
	}

	static function applyShipping(){
		if ( self::doingCalculation() ){

			if(isset($_POST['action_auto_load']) && self::disableAutoLoadEstimate()){
				$return['shipping_methods'] = sprintf('<div class="pisol-ppscw-alert">%s</div>', get_option('pi_ppscw_no_address_added_yet', 'Insert your location to get the shipping method'));
				wp_send_json($return);
			}

			$return = array();
			WC_Shortcode_Cart::calculate_shipping();
			WC()->cart->calculate_totals();


			$item_key = self::addTestProductForProperShippingCost();
			

			if(WC()->cart->get_cart_contents_count() == 0 ){
				$blank_package = self::get_shipping_packages();
				WC()->shipping()->calculate_shipping($blank_package );
			}
			$packages = WC()->shipping()->get_packages();
			$shipping_methods = self::getShippingMethods($packages);
			$return['error'] = wc_print_notices(true);
			//error_log(print_r($return,true));
			//wc_clear_notices();
			$return['shipping_methods'] = self::messageTemplate($shipping_methods);
			echo json_encode($return);

			if($item_key){
				WC()->cart->remove_cart_item($item_key);
			}
		}
		die;
	}

	static function noShippingLocationInserted(){
		$country = WC()->customer->get_shipping_country();
		if(empty($country) || $country == 'default') return true;

		return false;
	}

	static function onlyPassErrorNotice($notice_type){
		if ( self::doingCalculation() ){
			return array('error');
		}
		return $notice_type;
	}

	static function doingCalculation(){
		if ( ! empty( $_POST['calc_shipping'] )  && isset($_POST['pisol-woocommerce-shipping-calculator-nonce']) ){
			return true;
		}
		return false;
	}

	static function addTestProductForProperShippingCost(){
			$product_id = filter_input(INPUT_POST, 'product_id');
			$quantity = filter_input(INPUT_POST, 'quantity');
			if(empty($quantity)) $quantity = 1;

			if($product_id){
				$variation_id = filter_input(INPUT_POST, 'variation_id');
				if(!$variation_id){
					$variation_id = 0;
				}
				$item_key = self::addProductToCart($product_id, $variation_id, $quantity);
			}else{
				$item_key = "";
			}
			return $item_key;
	}

	static function addProductToCart($product_id, $variation_id, $quantity = 1){
		$consider_product_quantity = apply_filters('pisol_ppscw_consider_quantity_in_shipping_calculation', get_option('pi_ppscw_consider_quantity_field', 'dont-consider-quantity-field'), $product_id, $variation_id, $quantity);

		if($consider_product_quantity == 'dont-consider-quantity-field'){
			if(self::productExistInCart( $product_id, $variation_id )) return "";
			$quantity = 1;
		}

		if(!empty($variation_id)){
			$variation = self::getVariationAttributes( $variation_id );
		}else{
			$variation = array();
		}
		
		$item_key = WC()->cart->add_to_cart(
			$product_id,
			$quantity,
			$variation_id,
			$variation,
			array(
				'pisol_test_product_for_calculation'   => '1',
			)
		);
		return $item_key;
	}

	static function getVariationAttributes( $product_id ){
		
		if(empty($product_id)) return array();
		
		$product = wc_get_product($product_id);

		if(!is_object($product)) return array();
		
		$variation = array();
		$type = $product->get_type();
		if($type == 'variation'){
				$parent_id = $product->get_parent_id();
				$parent_obj = wc_get_product($parent_id);
				$default_attributes = $parent_obj->get_default_attributes();
				$variation_attributes = $product->get_variation_attributes( );
				$variation = self::getAttributes($variation_attributes, $default_attributes);
				return $variation;
		}
		return $variation;
	}

	static function getAttributes($variation_attributes, $default_attributes){
		$list = array();
		foreach($variation_attributes as $name => $value){
			$att_name = str_replace('attribute_',"",$name);
			if(empty($value)){
				$value = isset($default_attributes[$att_name]) ? $default_attributes[$att_name] : "";
			}
			$list[$name] = $value;
		}
		return $list;
	}

	static function productExistInCart( $product_id, $variation_id ) {
		if ( ! WC()->cart->is_empty() ) {
			foreach(WC()->cart->get_cart() as $cart_item ) {
				if( $cart_item['product_id'] == $product_id && $cart_item['variation_id'] == $variation_id){
					return true;
				}
			}
		}
		return false; 
	}

	static function get_shipping_packages() {
		return array(
				array(
					'contents'        => array(),
					'contents_cost'   => 0,
					'applied_coupons' => '',
					'user'            => array(
						'ID' => get_current_user_id(),
					),
					'destination'     => array(
						'country'   => self::get_customer()->get_shipping_country(),
						'state'     => self::get_customer()->get_shipping_state(),
						'postcode'  => self::get_customer()->get_shipping_postcode(),
						'city'      => self::get_customer()->get_shipping_city(),
						
					),
					'cart_subtotal'   => 0,
				),
			);
	
	}

	static function get_customer() {
		return WC()->customer;
	}


	static function getShippingMethods($packages){
		$shipping_methods = array();
		$product_id = filter_input(INPUT_POST, 'product_id');
		$variation_id = filter_input(INPUT_POST, 'variation_id');
		foreach($packages as $package){
			if(empty($package['rates']) || !is_array($package['rates'])) break;

			foreach($package['rates'] as $id => $rate){
				$title = wc_cart_totals_shipping_method_label($rate);
				$title = self::modifiedTitle( $title, $rate );
				$shipping_methods[$id] = apply_filters('pisol_ppscw_shipping_method_name',$title, $rate, $product_id, $variation_id);
			}
		}
		return $shipping_methods;
	}

	static function noMethodAvailableMsg(){

		if(self::noShippingLocationInserted()){
			return get_option('pi_ppscw_no_address_added_yet', 'Insert your location to get the shipping method');
		}else{
			return get_option('pi_ppscw_no_shipping_methods_msg', 'No shipping methods available for your location');
		}
	}

	static function disableAutoLoadEstimate(){
		$auto_loading = get_option('pi_ppscw_auto_calculation', 'enabled');

		if($auto_loading == 'enabled') return false;

		return true;
	}

	static function messageTemplate($shipping_methods){

		

		$message_above = get_option('pi_ppscw_above_shipping_methods', 'Shipping methods available for your location:');

		$message_above = self::shortCode($message_above);

		if(is_array($shipping_methods) && !empty($shipping_methods)){
			$html = '';
			foreach($shipping_methods as $id=> $method){
				$html .= sprintf('<li id="%s">%s</li>',esc_attr($id), $method);
			}
			if(!empty($html)){
				$shipping_methods_msg = '<ul class="pisol-ppscw-methods">'.$html.'</ul>';
			}else{
				$shipping_methods_msg = "";
			}
		}else{
			$shipping_methods_msg = "";
		}

		$when_shipping_msg = $message_above.'<br>'.$shipping_methods_msg;

		$msg = is_array($shipping_methods) && !empty($shipping_methods) ? $when_shipping_msg : self::noMethodAvailableMsg();

		return sprintf('<div class="pisol-ppscw-alert">%s</div>', $msg);
	}

	static function shortCode($message){
		
		$country = __('Country','pisol-product-page-shipping-calculator-woocommerce');

		if(isset(WC()->customer)){
			$country_code = self::get_customer()->get_shipping_country();
			if(!empty($country_code) && isset(WC()->countries) && $country_code !== 'default'){
				$country = WC()->countries->countries[ $country_code ];
			}
		} 

		$find_replace = array(
			'[country]' => $country
		);

		$message = str_replace(array_keys($find_replace), array_values($find_replace), $message);

		return $message;
	}

	function enableShippingCalculationWithoutAddress( $val ){
		if((isset($_POST['action']) && $_POST['action'] === 'pisol_cal_shipping') || (isset($_POST['action']) && $_POST['action'] === 'pisol_save_address_form')){
			return null;
		}
		return $val;
	}

	static function modifiedTitle( $title, $rate ){

		if(isset($rate->cost) && $rate->cost == 0){
			$free_display_type = get_option('pi_ppscw_free_shipping_price', 'nothing');

			if($free_display_type == 'nothing') return $title;

			if($free_display_type == 'zero'){
				$label = $rate->get_label();
				$title = $label.': '.wc_price($rate->cost);
			}
		}

		return $title;
	}
}

new pisol_ppscw_product_page_calculator();