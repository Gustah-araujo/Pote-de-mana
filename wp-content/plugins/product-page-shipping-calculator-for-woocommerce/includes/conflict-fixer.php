<?php

class pisol_ppscw_conflict_fixer{

    function __construct(){
        add_action( 'admin_enqueue_scripts', array($this,'removeConflictingScript'), 100 );
    }

    function removeConflictingScript(){
        if(isset($_GET['page']) && $_GET['page'] == 'pisol-shipping-calculator-setting'){
            wp_dequeue_script( 'print-invoices-packing-slip-labels-for-woocommerce' );
        }
    }
}

new pisol_ppscw_conflict_fixer();