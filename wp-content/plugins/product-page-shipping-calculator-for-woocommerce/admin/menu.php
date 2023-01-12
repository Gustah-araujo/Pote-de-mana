<?php

class pisol_ppscw_menu{

    public $plugin_name;
    public $menu;
    
    function __construct($plugin_name , $version){
        $this->plugin_name = $plugin_name;
        $this->version = $version;
        add_action( 'admin_menu', array($this,'plugin_menu') );
        add_action($this->plugin_name.'_promotion', array($this,'promotion'));
    }

    function plugin_menu(){
        
        $this->menu = add_submenu_page(
            'woocommerce',
            __( 'Shipping Calculator', 'isol-product-page-shipping-calculator-woocommerce'),
            __( 'Shipping Calculator', 'isol-product-page-shipping-calculator-woocommerce'),
            'manage_options',
            'pisol-shipping-calculator-setting',
            array($this, 'menu_option_page')
        );

        add_action("load-".$this->menu, array($this,"bootstrap_style"));
    }

    public function bootstrap_style() {
        wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/pisol-product-page-shipping-calculator-woocommerce-admin.css', array(), $this->version, 'all' );

		wp_enqueue_style( $this->plugin_name."_bootstrap", plugin_dir_url( __FILE__ ) . 'css/bootstrap.css', array(), $this->version, 'all' );

        if(function_exists('WC') && is_object(WC()->countries)){
            $countries = WC()->countries->get_shipping_countries();

            if(count($countries) == 1) return;

            $js = 'jQuery(function($){
                jQuery("#row_pi_ppscw_remove_country .custom-control, #row_pi_ppscw_remove_country_add_form .custom-control").html($("#hidden-msg"));
            });';
            wp_add_inline_script('jquery', $js, 'after');
        }
    }

    function menu_option_page(){
        if(function_exists('settings_errors')){
            settings_errors();
        }
        ?>
        <div class="bootstrap-wrapper clear">
        <div class="container mt-2">
            <div class="row">
                    <div class="col-12">
                        <div class='bg-dark'>
                        <div class="row">
                            <div class="col-12 col-sm-2 py-2">
                                    <a href="https://www.piwebsolution.com/" target="_blank"><img class="img-fluid ml-2" src="<?php echo plugin_dir_url( __FILE__ ); ?>img/pi-web-solution.svg"></a>
                            </div>
                            <div class="col-12 col-sm-10 d-flex text-center small pisol-top-menu">
                                
                            </div>
                        </div>
                        </div>
                    </div>
            </div>
            <div class="row">
                <div class="col-12">
                <div class="bg-light border pl-3 pr-3 pb-3 pt-0">
                    <div class="row">
                        <div class="col-12 col-md-2 px-0 border-right">
                            <?php do_action($this->plugin_name.'_tab'); ?>
                        </div>
                        <div class="col">
                        <?php do_action($this->plugin_name.'_tab_content'); ?>
                        </div>
                    </div>
                </div>
                </div>
            </div>
        </div>
        </div>
        <?php
    }

    function promotion(){
        
    }

}