<?php

class pisol_ppscw_estimate_setting{

    public $plugin_name;

    private $setting = array();

    private $active_tab;

    private $this_tab = 'estiamte-setting';

    private $tab_name = "Estimate date";

    private $setting_key = 'pisol_ppscw_estimate_setting';


    function __construct($plugin_name){
        $this->plugin_name = $plugin_name;

        $this->tab_name = __("Estimate date",'pisol-product-page-shipping-calculator-woocommerce');
        
        $this->tab = sanitize_text_field(filter_input( INPUT_GET, 'tab'));
        $this->active_tab = $this->tab != "" ? $this->tab : 'default';

        $this->settings = array(

            array('field'=>'pi_ppscw_show_estimate_date', 'label'=>__('Show estimate date for each shipping methods on product page','pisol-product-page-shipping-calculator-woocommerce'),'type'=>'switch', 'default'=> 1, 'desc'=>__('This will show the estimate date below each of the shipping method','pisol-product-page-shipping-calculator-woocommerce')),

            array('field'=>'pi_ppscw_disable_view_shipping_method', 'label'=>__('Don\'t show shipping methods','pisol-product-page-shipping-calculator-woocommerce'),'type'=>'switch', 'default'=> 0, 'desc'=>__('It will only update  the location selected and will not show the shipping method for the selected location (If you are using our estimate plugin then it will update the estimate date as well)','pisol-product-page-shipping-calculator-woocommerce')),
            
            array('field'=>'pi_ppscw_show_estimate_as_per', 'label'=>__('Shipping method estimate as per','pisol-product-page-shipping-calculator-woocommerce'), 'type'=>'select', 'default'=> 'cart', 'value'=>array('product'=>__('Product estimate','pisol-product-page-shipping-calculator-woocommerce'), 'cart'=>__('Cart estimate','pisol-product-page-shipping-calculator-woocommerce')), 'desc'=>__('It will show the estimate date for each of the shipping method:<br> Product estimate=> estimate will be based on this particular product (useful when you ship item separately)<br>Cart estimate => estimate will be based on all the product in cart (useful when you ship item in order together)','pisol-product-page-shipping-calculator-woocommerce')),

        );

        if($this->this_tab == $this->active_tab){
            add_action($this->plugin_name.'_tab_content', array($this,'tab_content'));
        }

        add_action($this->plugin_name.'_tab', array($this,'tab'),4);

        $this->register_settings();
        
    }

    function register_settings(){   

        foreach($this->settings as $setting){
            register_setting( $this->setting_key, $setting['field']);
        }
    
    }

    function tab(){
        $this->tab_name = __("Estimate date",'pisol-product-page-shipping-calculator-woocommerce');
        ?>
        <a class=" pi-side-menu  <?php echo ($this->active_tab == $this->this_tab ? 'bg-primary' : 'bg-secondary'); ?>" href="<?php echo admin_url( 'admin.php?page='.sanitize_text_field($_GET['page']).'&tab='.$this->this_tab ); ?>">
        <span class="dashicons dashicons-calendar-alt"></span> <?php  echo $this->tab_name; ?> 
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


