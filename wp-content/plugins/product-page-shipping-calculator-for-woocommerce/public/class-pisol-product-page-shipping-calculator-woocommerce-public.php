<?php
class Pisol_Product_Page_Shipping_Calculator_Woocommerce_Public {

	
	private $plugin_name;

	
	private $version;

	
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

		

	}

	

	
	public function enqueue_styles() {

		

	}

	
	public function enqueue_scripts() {

		if(function_exists('is_product') && is_product()){
			wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/pisol-product-page-shipping-calculator-woocommerce-public.js', array( 'jquery', 'woocommerce', 'wc-country-select', 'wc-address-i18n' ), $this->version, false );

			wp_localize_script($this->plugin_name, 'pi_ppscw_data', array(
				'select_variation' => get_option('pi_ppscw_select_variation_msg','Select variation'),
				'disable_shipping_method_list' => get_option('pi_ppscw_disable_view_shipping_method','0'),
				'auto_select_country' => apply_filters('pisol_ppscw_auto_select_country', self::singleShippingCountry())
			));
		}

		$enable_popup = get_option('pi_ppscw_enable_badge',0);
		/**
		 * We do not want to load this JS and CSS when popup option is disabled
		 */
		if(!empty($enable_popup)){
			wp_enqueue_script( $this->plugin_name.'-popup', plugin_dir_url( __FILE__ ) . 'js/jquery.magnific-popup.min.js', array( 'jquery' ), $this->version, false );
			wp_enqueue_script( $this->plugin_name.'-address-form', plugin_dir_url( __FILE__ ) . 'js/address-form.js', array( 'jquery', 'woocommerce', 'wc-country-select', 'wc-address-i18n' ), $this->version, false );
			wp_enqueue_style( $this->plugin_name.'-popup', plugin_dir_url( __FILE__ ) . 'css/magnific-popup.css' );
		}

		wp_localize_script( $this->plugin_name.'-address-form', 'pi_ppscw_setting', array('ajaxUrl'=> admin_url('admin-ajax.php'), 'loading' => 'Loading..', 'auto_select_country'=> apply_filters('pisol_ppscw_auto_select_country', self::singleShippingCountry())) );

		wp_enqueue_style( $this->plugin_name.'-address-form', plugin_dir_url( __FILE__ ) . 'css/address-form.css' );

	}

	static function singleShippingCountry(){
		if(!function_exists('WC') || !is_object(WC()->countries)) return false;

		$countries = WC()->countries->get_shipping_countries();

		if(count($countries) == 1) {
			foreach ( WC()->countries->get_shipping_countries() as $key => $value ) {
				return $key;
			}
		}

		return false;
	}

}
