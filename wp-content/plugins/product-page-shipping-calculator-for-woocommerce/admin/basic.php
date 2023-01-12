<?php

class pisol_ppscw_basic_option{

    public $plugin_name;

    private $setting = array();

    private $active_tab;

    private $this_tab = 'default';

    private $tab_name = "Basic setting";

    private $setting_key = 'pisol_ppscw_basic_setting';


    function __construct($plugin_name){
        $this->plugin_name = $plugin_name;

        $this->tab_name = __("Basic setting",'pisol-product-page-shipping-calculator-woocommerce');

        
        $this->tab = sanitize_text_field(filter_input( INPUT_GET, 'tab'));
        $this->active_tab = $this->tab != "" ? $this->tab : 'default';

        $this->settings = array(
            array('field'=>'title', 'class'=> 'bg-primary text-light', 'class_title'=>'text-light font-weight-light h4', 'label'=>__("Position", 'pisol-product-page-shipping-calculator-woocommerce'), 'type'=>"setting_category"),

            array('field'=>'pi_ppscw_calc_position', 'label'=>__('Position of the calculator on product page','pisol-product-page-shipping-calculator-woocommerce'),'type'=>'select','value'=> array('woocommerce_after_add_to_cart_form' => __('After add to cart button', 'pisol-product-page-shipping-calculator-woocommerce'), 'woocommerce_before_add_to_cart_form' => __('Before add to cart button', 'pisol-product-page-shipping-calculator-woocommerce')), 'default'=>'woocommerce_after_add_to_cart_form', 'desc'=>__("Position of the calculator on the single product page", 'pisol-product-page-shipping-calculator-woocommerce')),

            array('field'=>'pi_ppscw_result_position', 'label'=>__('Position of the calculator result','pisol-product-page-shipping-calculator-woocommerce'),'type'=>'select','value'=> array(
                'pi_ppscw_before_calculate_button' => __('Before calculate shipping button', 'pisol-product-page-shipping-calculator-woocommerce'), 'pi_ppscw_after_calculate_button' => __('After calculate shipping button', 'pisol-product-page-shipping-calculator-woocommerce'),'pi_ppscw_before_calculate_form' => __('Before calculate shipping form (inside hidden container)', 'pisol-product-page-shipping-calculator-woocommerce'), 'pi_ppscw_after_calculate_form'=>__('After calculate shipping form (inside hidden container)', 'pisol-product-page-shipping-calculator-woocommerce')), 'default'=>'pi_ppscw_before_calculate_button', 'desc'=>__("Position of the shipping calculation result", 'pisol-product-page-shipping-calculator-woocommerce')),

            array('field'=>'pi_ppscw_default_form_display', 'label'=>__('Shipping calculator form default state','pisol-product-page-shipping-calculator-woocommerce'),'type'=>'select','value'=> array('closed' => __('Closed by default', 'pisol-product-page-shipping-calculator-woocommerce'), 'open' => __('Open by default', 'pisol-product-page-shipping-calculator-woocommerce')), 'default'=>'closed', 'desc'=>__("By default the calculator form will be closed if you want you can make it open", 'pisol-product-page-shipping-calculator-woocommerce')),

            array('field'=>'title', 'class'=> 'bg-primary text-light', 'class_title'=>'text-light font-weight-light h4', 'label'=>__("Auto loading of shipping method (we recommend keeping it disabled)", 'pisol-product-page-shipping-calculator-woocommerce'), 'type'=>"setting_category"),

            array('field'=>'pi_ppscw_auto_calculation', 'label'=>__('Auto calculation of shipping method','pisol-product-page-shipping-calculator-woocommerce'),'type'=>'select','value'=> array('disabled' => __('Disabled', 'pisol-product-page-shipping-calculator-woocommerce'), 'enabled' => __('Enabled', 'pisol-product-page-shipping-calculator-woocommerce')), 'default'=>'enabled', 'desc'=>__("Disabled => It will not show shipping method till user click on Update address manually", 'pisol-product-page-shipping-calculator-woocommerce')),

            array('field'=>'title', 'class'=> 'bg-primary text-light', 'class_title'=>'text-light font-weight-light h4', 'label'=>__("Show shipping as per the quantity field", 'pisol-product-page-shipping-calculator-woocommerce'), 'type'=>"setting_category"),

            array('field'=>'pi_ppscw_consider_quantity_field', 'label'=>__('Product Quantity field','pisol-product-page-shipping-calculator-woocommerce'),'type'=>'select','value'=> array('consider-quantity' => __('Consider product quantity field', 'pisol-product-page-shipping-calculator-woocommerce'), 'dont-consider-quantity-field' => __('Dont consider quantity field', 'pisol-product-page-shipping-calculator-woocommerce')), 'default'=>'dont-consider-quantity-field', 'desc'=>__("Consider product quantity field: Quantity selected in the quantity field + quantity of product in the cart will be considered to calculate the shipping method and cost <strong>(We suggest using this option to get more accurate shipping method)</strong> <br>Don't consider quantity: 1 unit of product will be considered to calculate the shipping method till product is not added to the cart, when product is added to the cart the quantity added in the cart will be used to give the shipping method", 'pisol-product-page-shipping-calculator-woocommerce')),


            array('field'=>'title', 'class'=> 'bg-primary text-light', 'class_title'=>'text-light font-weight-light h4', 'label'=>__("Different messages used in plugin", 'pisol-product-page-shipping-calculator-woocommerce'), 'type'=>"setting_category"),

            array('field'=>'pi_ppscw_no_address_added_yet', 'label'=>__('Message shown when user has not yet added address in form','pisol-product-page-shipping-calculator-woocommerce'),'type'=>'text', 'default'=>'Insert your location to get the shipping method', 'desc'=>""),
            
            array('field'=>'pi_ppscw_open_drawer_button_text', 'label'=>__('Calculate shipping button text','pisol-product-page-shipping-calculator-woocommerce'),'type'=>'text', 'default'=>'Select delivery location', 'desc'=>__('This message will be shown inside calculate shipping button that will open the form','pisol-product-page-shipping-calculator-woocommerce')),

            array('field'=>'pi_ppscw_update_button_text', 'label'=>__('Address form submission button text','pisol-product-page-shipping-calculator-woocommerce'),'type'=>'text', 'default'=>'Update Address', 'desc'=>__('Address form submission button text','pisol-product-page-shipping-calculator-woocommerce')),


             array('field'=>'pi_ppscw_above_shipping_methods', 'label'=>__('Message shown above the available shipping method list','pisol-product-page-shipping-calculator-woocommerce'),'type'=>'text', 'default'=>'Shipping methods available for your location:', 'desc'=>__('[country] => short code can be used to show the name of the country selected by the customer','pisol-product-page-shipping-calculator-woocommerce')),

             array('field'=>'pi_ppscw_no_shipping_methods_msg', 'label'=>__('Message shown when no method available','pisol-product-page-shipping-calculator-woocommerce'),'type'=>'text', 'default'=>'No shipping methods available for your location', 'desc'=>""),

             array('field'=>'pi_ppscw_select_variation_msg', 'label'=>__('Message shown when no variation selected','pisol-product-page-shipping-calculator-woocommerce'),'type'=>'text', 'default'=>'Select variation', 'desc'=>__("This is used on variable product when no variation is selected", 'pisol-product-page-shipping-calculator-woocommerce')),

             array('field'=>'pi_ppscw_free_shipping_price', 'label'=>__('Price shown next to Free shipping methods','pisol-product-page-shipping-calculator-woocommerce'),'type'=>'select','value'=> array('nothing' => __('No price is show', 'pisol-product-page-shipping-calculator-woocommerce'), 'zero' => __('Show Zero', 'pisol-product-page-shipping-calculator-woocommerce')), 'default'=>'nothing', 'desc'=>__("No price shown => It will not show any price next to Free shipping method,<br> Show Zero => $0 will be shown as charge next to free shipping method", 'pisol-product-page-shipping-calculator-woocommerce'))
             
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
        <span class="dashicons dashicons-admin-home"></span> <?php echo $this->tab_name; ?> 
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
       <?php
    }

}


