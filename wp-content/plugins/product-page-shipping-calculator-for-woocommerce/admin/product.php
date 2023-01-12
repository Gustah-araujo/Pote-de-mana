<?php

class pisol_ppscw_product_options{
    public function __construct( ) {
		add_action( 'woocommerce_product_data_tabs', array($this,'productTab') );
		/** Adding order preparation days */
		add_action( 'woocommerce_product_data_panels', array($this,'calculatorSetting') );
        add_action( 'woocommerce_process_product_meta', array($this,'calculatorSettingSave') );
    }

    function productTab($tabs){
        $tabs['pisol_ppscw_tab'] = array(
            'label'    => 'Shipping calculator',
            'target'   => 'pisol_ppscw',
            'priority' => 21,
            'class' => 'hide_if_grouped'
        );
        return $tabs;
    }
    
    function calculatorSetting() {
		echo '<div id="pisol_ppscw" class="panel woocommerce_options_panel hidden">';
		woocommerce_wp_select( array(
            'label' => __("Disable shipping cost"), 
            'id' => 'pisol_disable_shipping_calculator', 
            'name' => 'pisol_disable_shipping_calculator', 
            'description' => __("You can disable shipping calculation for this product",'pisol-product-page-shipping-calculator-woocommerce'),
            'options' => array(
              '' => __('Select option','pisol-product-page-shipping-calculator-woocommerce'),
              'disable'=>__('Disable calculator', 'pisol-product-page-shipping-calculator-woocommerce'),
              'enable'=>__('Enable calculator', 'pisol-product-page-shipping-calculator-woocommerce')
            )
          ) );
		echo '</div>';
    }
    
    function calculatorSettingSave( $post_id ) {
        $product = wc_get_product( $post_id );

        $value = isset($_POST['pisol_disable_shipping_calculator']) ? $_POST['pisol_disable_shipping_calculator'] : '';
        $product->update_meta_data( 'pisol_disable_shipping_calculator', sanitize_text_field( $value ) );

        $product->save();
   }
}

new pisol_ppscw_product_options();