<?php

class pisol_ppscw_design_setting{

    public $plugin_name;

    private $setting = array();

    private $active_tab;

    private $this_tab = 'design-setting';

    private $tab_name = "Design";

    private $setting_key = 'pisol_ppscw_design_setting';


    function __construct($plugin_name){
        $this->plugin_name = $plugin_name;

        $this->tab_name = __("Design",'pisol-product-page-shipping-calculator-woocommerce');
        
        $this->tab = sanitize_text_field(filter_input( INPUT_GET, 'tab'));
        $this->active_tab = $this->tab != "" ? $this->tab : 'default';

        $this->settings = array(

            array('field'=>'title', 'class'=> 'bg-primary text-light', 'class_title'=>'text-light font-weight-light h4', 'label'=>__("Box showing result of shipping methods", 'pisol-product-page-shipping-calculator-woocommerce'), 'type'=>"setting_category"),

            array('field'=>'pi_ppscw_msg_background_color', 'label'=>__('Background color of shipping methods','pisol-product-page-shipping-calculator-woocommerce'),'type'=>'color', 'default'=> '#cccccc', 'desc'=>__('Background color of the area where the result are shown','pisol-product-page-shipping-calculator-woocommerce')),
            
            array('field'=>'pi_ppscw_msg_font_color', 'label'=>__('Text color of message','pisol-product-page-shipping-calculator-woocommerce'),'type'=>'color', 'default'=> '#000000', 'desc'=>__('Text color of the resulting text','pisol-product-page-shipping-calculator-woocommerce')),

            array('field'=>'pi_ppscw_msg_font_color_shipping_method', 'label'=>__('Text color of shipping methods name','pisol-product-page-shipping-calculator-woocommerce'),'type'=>'color', 'default'=> '#000000', 'desc'=>__('Text color of the shipping method name','pisol-product-page-shipping-calculator-woocommerce')),

            array('field'=>'pi_ppscw_msg_font_color_shipping_cost', 'label'=>__('Text color of shipping charges','pisol-product-page-shipping-calculator-woocommerce'),'type'=>'color', 'default'=> '#000000', 'desc'=>__('Text color of the shipping method price','pisol-product-page-shipping-calculator-woocommerce')),

            array('field'=>'title', 'class'=> 'bg-primary text-light', 'class_title'=>'text-light font-weight-light h4', 'label'=>__("Button", 'pisol-product-page-shipping-calculator-woocommerce'), 'type'=>"setting_category"),

            array('field'=>'pi_ppscw_calculate_shipping_bg_color', 'label'=>__('Calculate shipping button background color','pisol-product-page-shipping-calculator-woocommerce'),'type'=>'color', 'default'=> '', 'desc'=>__('Leave blank and it will follow your theme button color','pisol-product-page-shipping-calculator-woocommerce')),

            array('field'=>'pi_ppscw_calculate_shipping_text_color', 'label'=>__('Calculate shipping button text color','pisol-product-page-shipping-calculator-woocommerce'),'type'=>'color', 'default'=> '', 'desc'=>__('Leave blank and it will follow your theme button color','pisol-product-page-shipping-calculator-woocommerce')),

            array('field'=>'pi_ppscw_update_address_bg_color', 'label'=>__('Update address button background color','pisol-product-page-shipping-calculator-woocommerce'),'type'=>'color', 'default'=> '', 'desc'=>__('Leave blank and it will follow your theme button color','pisol-product-page-shipping-calculator-woocommerce')),

            array('field'=>'pi_ppscw_update_address_text_color', 'label'=>__('Update address button text color','pisol-product-page-shipping-calculator-woocommerce'),'type'=>'color', 'default'=> '', 'desc'=>__('Leave blank and it will follow your theme button color','pisol-product-page-shipping-calculator-woocommerce')),
        );

        if($this->this_tab == $this->active_tab){
            add_action($this->plugin_name.'_tab_content', array($this,'tab_content'));
        }

        add_action($this->plugin_name.'_tab', array($this,'tab'),2);

        $this->register_settings();
        
    }

    function register_settings(){   

        foreach($this->settings as $setting){
            register_setting( $this->setting_key, $setting['field']);
        }
    
    }

    function tab(){
        ?>
        <a class=" pi-side-menu  <?php echo ($this->active_tab == $this->this_tab ? 'bg-primary' : 'bg-secondary'); ?>" href="<?php echo admin_url( 'admin.php?page='.sanitize_text_field($_GET['page']).'&tab='.$this->this_tab ); ?>">
        <span class="dashicons dashicons-art"></span> <?php echo $this->tab_name; ?> 
        </a>
        <?php
    }

    function tab_content(){
       ?>
        <form method="post" action="options.php"  class="pisol-setting-form">
        <?php settings_fields( $this->setting_key ); ?>
        <?php
            foreach($this->settings as $setting){
                new pisol_class_form_ppscw($setting, $this->setting_key);
            }
        ?>
        <input type="submit" class="mt-3 btn btn-primary btn-md" value="<?php _e('Save Option','pisol-product-page-shipping-calculator-woocommerce'); ?>" />
        </form>
       <?php
    }

}


