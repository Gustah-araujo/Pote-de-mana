<?php

class pisol_ppscw_remove_fields{

    public $plugin_name;

    private $setting = array();

    private $active_tab;

    private $this_tab = 'remove_fields';

    private $tab_name = "Remove fields";

    private $setting_key = 'pisol_ppscw_remove_fields';


    function __construct($plugin_name){
        $this->plugin_name = $plugin_name;

        $this->tab_name = __("Remove fields",'pisol-product-page-shipping-calculator-woocommerce');

        
        $this->tab = sanitize_text_field(filter_input( INPUT_GET, 'tab'));
        $this->active_tab = $this->tab != "" ? $this->tab : 'default';

        $this->settings = array(
            array('field'=>'title', 'class'=> 'bg-primary text-light', 'class_title'=>'text-light font-weight-light h4', 'label'=>__("Remove address form fields from product page calculator<br><small>Warning: If your shipping zone are based on the field then do not disable it else plugin will not be able to select the zone and show the shipping method</small>", 'pisol-product-page-shipping-calculator-woocommerce'), 'type'=>"setting_category"),

            array('field'=>'pi_ppscw_remove_country', 'label'=>__('Remove country field','pisol-product-page-shipping-calculator-woocommerce'),'desc'=>__('Remove country field if your shipping zone are not dependent on the zone or you only ship to single country','pisol-product-page-shipping-calculator-woocommerce'), 'type'=>'switch', 'default'=>0), 

            array('field'=>'pi_ppscw_remove_state', 'label'=>__('Remove state field','pisol-product-page-shipping-calculator-woocommerce'),'desc'=>__('Remove state field if your shipping zone are not dependent on the zone','pisol-product-page-shipping-calculator-woocommerce'), 'type'=>'switch', 'default'=>0), 

            array('field'=>'pi_ppscw_remove_city', 'label'=>__('Remove Town/City field','pisol-product-page-shipping-calculator-woocommerce'),'desc'=>__('Remove city field','pisol-product-page-shipping-calculator-woocommerce'), 'type'=>'switch', 'default'=>0), 

            array('field'=>'pi_ppscw_remove_postcode', 'label'=>__('Remove Postcode/Zip field','pisol-product-page-shipping-calculator-woocommerce'),'desc'=>__('Remove Postcode/Zip field if your shipping zone are not dependent on the postcode','pisol-product-page-shipping-calculator-woocommerce'), 'type'=>'switch', 'default'=>0), 
            
             
            array('field'=>'title', 'class'=> 'bg-primary text-light', 'class_title'=>'text-light font-weight-light h4', 'label'=>__("Remove address form fields from address form (popup)<br><small>Warning: If your shipping zone are based on the field then do not disable it else plugin will not be able to select the zone and show the shipping method</small>", 'pisol-product-page-shipping-calculator-woocommerce'), 'type'=>"setting_category"),

            array('field'=>'pi_ppscw_remove_country_add_form', 'label'=>__('Remove country field','pisol-product-page-shipping-calculator-woocommerce'),'desc'=>__('Remove country field if your shipping zone are not dependent on the zone or you only ship to single country','pisol-product-page-shipping-calculator-woocommerce'), 'type'=>'switch', 'default'=>0), 

            array('field'=>'pi_ppscw_remove_state_add_form', 'label'=>__('Remove state field','pisol-product-page-shipping-calculator-woocommerce'),'desc'=>__('Remove state field if your shipping zone are not dependent on the zone','pisol-product-page-shipping-calculator-woocommerce'), 'type'=>'switch', 'default'=>0), 

            array('field'=>'pi_ppscw_remove_city_add_form', 'label'=>__('Remove Town/City field','pisol-product-page-shipping-calculator-woocommerce'),'desc'=>__('Remove city field','pisol-product-page-shipping-calculator-woocommerce'), 'type'=>'switch', 'default'=>0), 

            array('field'=>'pi_ppscw_remove_postcode_add_form', 'label'=>__('Remove Postcode/Zip field','pisol-product-page-shipping-calculator-woocommerce'),'desc'=>__('Remove Postcode/Zip field if your shipping zone are not dependent on the postcode','pisol-product-page-shipping-calculator-woocommerce'), 'type'=>'switch', 'default'=>0), 
        );

        if($this->this_tab == $this->active_tab){
            add_action($this->plugin_name.'_tab_content', array($this,'tab_content'));
        }

        add_action($this->plugin_name.'_tab', array($this,'tab'),1);

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
        <span class="dashicons dashicons-table-col-delete"></span> <?php echo  $this->tab_name; ?> 
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
        <input type="submit" class="mt-3 btn btn-md btn-primary" value="<?php _e('Save Option','pisol-product-page-shipping-calculator-woocommerce'); ?>" />
        </form>
        <div style="display:none;">
        <div id="hidden-msg" class="alert alert-warning">
            <b>Remove country option is Disabled for you</b> as You can only disable country field when you Ship product to single country, Right now you have configured WooCommerce to ship to <b>more then one country</b>, You can configure shipping country from <a href="<?php echo admin_url("admin.php?page=wc-settings#woocommerce_store_postcode")?>" target="_blank">Click to configure</a>
        </div>
        </div>
       <?php
    }

}


