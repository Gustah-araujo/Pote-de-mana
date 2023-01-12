<?php

class pisol_ppscw_popup{

    private $enabled = true;
    private $position = 'bottom-right';
    private $icon;

    function __construct(){
        $this->enabled = get_option('pi_ppscw_enable_badge',0);
        $this->position = get_option('pi_ppscw_badge_position','bottom-right');

        if(!empty($this->enabled)){
            $this->icon = $this->getShippingIcon();
            add_action('wp_footer', array($this, 'addingBadge'));
        }

        add_action('wp_ajax_pisol_ppscw_popup', array($this, 'popup'));
        add_action('wp_ajax_nopriv_pisol_ppscw_popup', array($this, 'popup'));
    }

    function addingBadge(){

        if(is_cart() || is_checkout()) return;

        $bg = get_option('pi_ppscw_badge_bg_color', '#000000');
        $color = get_option('pi_ppscw_badge_text_color', '#FFFFFF');

        $this->text = get_option('pi_ppscw_badge_text', 'Delivery location');
        
        if(apply_filters('pisol_ppscw_enable_popup',true)){
            $icon_img = $this->getIconImage();
            echo '<div id="pisol-ppscw-badge-container" class="pisol-badge-'.$this->position.'"><a id="pisol-ppscw-badge" href="javascript:void(0);" style="background-color:'.$bg.'; color:'.$color.';">'.$icon_img.' <span>'.$this->text.'</span></a></div>';
        }
    }

    function getShippingIcon(){
        $img_id = get_option("pi_ppscw_badge_icon","");
		$default = plugin_dir_url( __FILE__ ) .'img/icon.svg';
		if(!empty($img_id)){
			$img = wp_get_attachment_url($img_id);
			if($img){
				return $img;
			}
		}
		return $default;
    }

    function getIconImage(){
        if(empty($this->icon)) return false;

        return '<img src="'.$this->icon.'" class="pisol-ppscw-badge-icon" alt="shipping">';
    }

    function popup(){
       $button_text = get_option('pi_ppscw_popup_update_address_title', 'Update Address');
       $layout = get_option('pi_ppscw_address_form_layout', 'pi-vertical');
       $form = pisol_ppscw_address_form::getAddressForm($button_text, $layout);
       echo $this->popupTemplate($form);
       die;
    }

    function popupTemplate($form){
        $bg = get_option('pi_ppscw_popup_header_bg_color', '#000000');
        $color = get_option('pi_ppscw_popup_header_text_color', '#FFFFFF');
        $title = get_option('pi_ppscw_popup_title', 'Set your delivery location');
        ob_start();
        echo '<div class="pisol-ppscw-form-container">';
        echo '<div class="pisol-ppscw-title" style="background-color:'.$bg.'; color:'.$color.';">'.$title.'</div>';
        echo '<div class="pisol-ppscw-content">';
        echo $form;
        echo '</div>';
        echo '</div>';
        $html = ob_get_contents();
        ob_end_clean();
        return $html;
    }
}

new pisol_ppscw_popup();