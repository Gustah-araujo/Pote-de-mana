<?php
/**
 * Footer-v6 template.
 *
 * @author     Sapid
 * @copyright  (c) Copyright by Sapid
 * @package    Sapid
 * @subpackage Core
 */

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
    exit( 'Direct script access denied.' );
}
?>
<?php
$footer_widget_columns   = 4;
$footer_widget_columns = ( ! $footer_widget_columns ) ? 1 : $footer_widget_columns;
$column_width          = ( 5 === $footer_widget_columns ) ? 2 : 12 / $footer_widget_columns;
$default_column_width = ['2','2','3','5'];
$container_class = 'container ';
?>
<div class="sapid-footer-widget-area sapid-widget-area footer5 pt-5 pb-3">
    <div class="<?php echo $container_class; ?>">
        <div class="row">
            <?php for ( $i = 1; $i < 5; $i++ ) : ?>
                <?php if ( $i <= $footer_widget_columns ) : ?>
                    <?php
                    if($footer_widget_columns == 4){
                        $column_width          = $default_column_width[$i-1];
                    }
                    $css_class = 'foot-5 sapid-column' . ( $footer_widget_columns === $i ? ' sapid-column-last' : '' ) . ' col-lg-' . $column_width . ' col-md-6';
                    if($i <= 2){
                        $css_class = 'foot-5 sapid-column' . ( $footer_widget_columns === $i ? ' sapid-column-last' : '' ) . ' col-lg-' . $column_width . ' col-md-6 col-6';    
                    }

                    ?>
                    <div class="<?php echo esc_attr( $css_class ); ?>">
                        <?php dynamic_sidebar('footer-v6-'.$i); ?>
                    </div>
                <?php endif; ?>
            <?php endfor; ?>
        </div>
    </div>
    <div class="f1-bottom-bar">
        <div class="<?php echo $container_class; ?>">
            <div class="copy">
                <?php do_action('sapid_copy_right'); ?>
            </div>
        </div>
    </div>
</div>