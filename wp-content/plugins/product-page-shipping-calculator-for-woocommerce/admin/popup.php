<?php

class pisol_ppscw_badge_option{

    private $setting = array();

    private $active_tab;

    private $this_tab = 'badge';

    private $tab_name = "Popup";

    private $setting_key = 'pisol_ppscw_badge_setting';

    function __construct($plugin_name){
        $this->plugin_name = $plugin_name;

        $this->active_tab = (isset($_GET['tab'])) ? sanitize_text_field($_GET['tab']) : 'default';

        $this->settings = array(
            
            
                array('field'=>'pi_ppscw_enable_badge',  'label'=>__("Enable delivery location in popup",'pisol-product-page-shipping-calculator-woocommerce'), 'type'=>"switch", 'default'=>0, 'desc'=> __('This will add a button to your website clicking on which opens a popup to insert the delivery location','pisol-product-page-shipping-calculator-woocommerce')),

                array('field'=>'pi_ppscw_address_form_working', 'label'=>__('Working of popup','pisol-product-page-shipping-calculator-woocommerce'),'default'=>'save-location', 'type'=>'select','value'=> array('save-location'=> __('Use for getting location','pisol-product-page-shipping-calculator-woocommerce'), 'show-shipping-available' => __('Show if shipping is available based on the shipping zone','pisol-product-page-shipping-calculator-woocommerce'), 'show-shipping-available-method' => __('Show if shipping is available based and also show shipping methods','pisol-product-page-shipping-calculator-woocommerce'))),

                array('field'=>'title', 'class'=> 'bg-primary text-light', 'class_title'=>'text-light font-weight-light h4', 'label'=>__("Popup button",'pisol-product-page-shipping-calculator-woocommerce'), 'type'=>"setting_category"),

                array('field'=>'pi_ppscw_badge_position', 'label'=>__('Button Position','pisol-product-page-shipping-calculator-woocommerce'), 'type'=>'select', 'value'=>array('top-left' =>__('Top Left','pisol-product-page-shipping-calculator-woocommerce'), 'top-right'=>__('Top Right','pisol-product-page-shipping-calculator-woocommerce'),  'bottom-left'=>__('Bottom Left','pisol-product-page-shipping-calculator-woocommerce'), 'bottom-right'=>__('Bottom Right','pisol-product-page-shipping-calculator-woocommerce'), 'left-center'=>__('Left Center','pisol-product-page-shipping-calculator-woocommerce'), 'right-center'=>__('Right Center','pisol-product-page-shipping-calculator-woocommerce')), 'default'=>'bottom-right','desc'=>""), 

                array('field'=>'pi_ppscw_badge_text', 'type'=>'text', 'default'=>'Delivery Location','label'=>__('Text shown inside the button','pisol-product-page-shipping-calculator-woocommerce'),'desc'=>""),

                array('field'=>'pi_ppscw_badge_icon', 'type'=>'image', 'default'=>'','label'=>__('Button Icon image','pisol-product-page-shipping-calculator-woocommerce'),'desc'=>""),

                array('field'=>'pi_ppscw_badge_bg_color', 'type'=>'color', 'default'=>'#000000','label'=>__('Button background color','pisol-product-page-shipping-calculator-woocommerce'),'desc'=>""),
                
                array('field'=>'pi_ppscw_badge_text_color', 'type'=>'color', 'default'=>'#ffffff','label'=>__('Button text color','pisol-product-page-shipping-calculator-woocommerce'),'desc'=>""),

                array('field'=>'title', 'class'=> 'bg-primary text-light', 'class_title'=>'text-light font-weight-light h4', 'label'=>__("Popup",'pisol-product-page-shipping-calculator-woocommerce'), 'type'=>"setting_category"),

                array('field'=>'pi_ppscw_address_form_layout', 'label'=>__('Popup layout','pisol-product-page-shipping-calculator-woocommerce'),'default'=>'pi-vertical', 'type'=>'select','value'=> array('pi-vertical'=> __('Vertical layout','pisol-product-page-shipping-calculator-woocommerce'), 'pi-horizontal' => __('Horizontal layout','pisol-product-page-shipping-calculator-woocommerce'))),

                array('field'=>'pi_ppscw_popup_title', 'type'=>'text', 'default'=>'Set your delivery location','label'=>__('Popup title','pisol-product-page-shipping-calculator-woocommerce'),'desc'=>""),

                array('field' => 'pi_ppscw_popup_update_address_title', 'type' => 'text', 'default' => 'Update Address','label' => __('Update address button','pisol-product-page-shipping-calculator-woocommerce'),'desc'=>""),

                array('field'=>'pi_ppscw_popup_header_bg_color', 'type'=>'color', 'default'=>'#000000','label'=>__('Popup header background color','pisol-product-page-shipping-calculator-woocommerce'),'desc'=>""),

                array('field'=>'pi_ppscw_popup_header_text_color', 'type'=>'color', 'default'=>'#FFFFFF','label'=>__('Popup header text color','pisol-product-page-shipping-calculator-woocommerce'),'desc'=>""),
                
            );
        

        if($this->this_tab == $this->active_tab){
            add_action($this->plugin_name.'_tab_content', array($this,'tab_content'));
        }

        add_action($this->plugin_name.'_tab', array($this,'tab'),3);    

        $this->register_settings();
    }

    function register_settings(){   

        foreach($this->settings as $setting){
                register_setting( $this->setting_key, $setting['field']);
        }
    
    }

    function tab(){
        $this->tab_name = __("Popup",'pisol-product-page-shipping-calculator-woocommerce');
        ?>
        <a class="  pi-side-menu  <?php echo ($this->active_tab == $this->this_tab ? 'bg-primary' : 'bg-secondary'); ?>" href="<?php echo admin_url( 'admin.php?page='.sanitize_text_field($_GET['page']).'&tab='.$this->this_tab ); ?>">
        <span class="dashicons dashicons-twitch"></span> <?php echo $this->tab_name; ?> 
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
        <input type="submit" name="submit" id="submit" class="btn btn-primary btn-md my-3" value="<?php echo __('Save Changes','pisol-product-page-shipping-calculator-woocommerce'); ?>">
        </form>
       <?php
    }

}

/* if we have pro version setting for time tab then we can disable this */
//new pisol_ppscw_badge_option($this->plugin_name);




