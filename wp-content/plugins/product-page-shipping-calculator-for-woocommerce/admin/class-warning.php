<?php

class pisol_ppscw_warning_messages{

    function __construct(){
        add_action( 'admin_notices', array($this, 'adminNotice') );
    }

    function maxMindSet(){
        $key = get_option('woocommerce_maxmind_geolocation_license_key', "");
        if(empty($key)) return false;

        return true;
    }

    function defaultCustomerLocation(){
        $location = get_option('woocommerce_default_customer_address', "");
        if(empty($location)) return false;

        return true;
    }

    function adminNotice(){
        if(!$this->showNotices()) return;

        $messages = $this->getWarning();

        if(empty($messages)) return;

        foreach($messages as $message){
            echo "<div class=\"notice notice-error is-dismissible\">";
            echo '<p>'.$message.'</p>';
            echo '</div>';
        }
    }

    function showNotices(){
        if(isset($_GET['page']) && $_GET['page'] == 'pisol-shipping-calculator-setting') return true;

        return false;
    }

    function getWarning(){
        $warnings = array();


        if(!$this->defaultCustomerLocation()){
            $warnings[] = sprintf('Default customer location should be set to "Shop based address" or "Geolocation" for proper working <a href="%s"  target="_blank">click to configure</a>',admin_url('admin.php?page=wc-settings#woocommerce_default_customer_address'));
        }

        return $warnings;
    }
}