<?php
class Pisol_Product_Page_Shipping_Calculator_Woocommerce_Admin {

	
	private $plugin_name;

	
	private $version;

	
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
		add_action('wp_loaded', array($this,'register_menu'));
		
	}

	public function register_menu(){
		if(is_admin() && ! ( defined( 'DOING_AJAX' ) && DOING_AJAX )){
			new pisol_ppscw_menu( $this->plugin_name, $this->version );
			
			new pisol_ppscw_basic_option($this->plugin_name);
			new pisol_ppscw_remove_fields($this->plugin_name);
			new pisol_ppscw_design_setting($this->plugin_name);
			new pisol_ppscw_badge_option($this->plugin_name);
			if(pisol_ppscw_estimate_pro_present()){
				new pisol_ppscw_estimate_setting($this->plugin_name);
			}else{
				new pisol_ppscw_free_estimate_setting($this->plugin_name);
			}
			new pisol_ppscw_other_plugins($this->plugin_name);
			new pisol_ppscw_warning_messages();
		}
	}

	
	public function enqueue_styles() {

		

		
	}

	
	public function enqueue_scripts() {

		

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/pisol-product-page-shipping-calculator-woocommerce-admin.js', array( 'jquery' ), $this->version, false );

	}

}
