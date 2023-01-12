<?php

class pisol_ppscw_design{
    function __construct($plugin_name, $version){
        $this->plugin_name = $plugin_name;
		$this->version = $version;
        add_action('wp_enqueue_scripts', array($this, 'styles'));
    }

    function styles(){
        if(function_exists('is_product') && is_product()){
            wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 	'css/pisol-product-page-shipping-calculator-woocommerce-public.css', array(), $this->version, 'all' );
            $this->addInlineStyle();
		}
    }

    function addInlineStyle(){
        $msg_bg_color = get_option('pi_ppscw_msg_background_color','#cccccc');
        $msg_general_text_color = get_option('pi_ppscw_msg_font_color','#000000');
        $msg_method_text_color = get_option('pi_ppscw_msg_font_color_shipping_method','#000000');
        $msg_method_cost_text_color = get_option('pi_ppscw_msg_font_color_shipping_cost','#000000');
        $button_bg_color = empty(get_option('pi_ppscw_calculate_shipping_bg_color',''))? '' : get_option('pi_ppscw_calculate_shipping_bg_color','');
        $button_text_color = empty(get_option('pi_ppscw_calculate_shipping_text_color','')) ? '' : get_option('pi_ppscw_calculate_shipping_text_color','');

        $update_add_button_bg_color = empty(get_option('pi_ppscw_update_address_bg_color',''))? '' : get_option('pi_ppscw_update_address_bg_color','');
        $update_add_button_text_color = empty(get_option('pi_ppscw_update_address_text_color','')) ? '' : get_option('pi_ppscw_update_address_text_color','');

        $css = "
            .pisol-ppscw-alert{
                background-color:{$msg_bg_color};
                color:{$msg_general_text_color};
            }

            .pisol-ppscw-methods li{
                color:{$msg_method_text_color};
            }

            .pisol-ppscw-methods li .woocommerce-Price-amount{
                color:{$msg_method_cost_text_color};
            }

            .button.pisol-shipping-calculator-button{
                background-color:{$button_bg_color};
                color:{$button_text_color};
            }

            .button.pisol-update-address-button{
                background-color:{$update_add_button_bg_color};
                color:{$update_add_button_text_color};
            }
        ";
        wp_add_inline_style($this->plugin_name, $css);
    }
}

new pisol_ppscw_design($this->plugin_name, $this->version);