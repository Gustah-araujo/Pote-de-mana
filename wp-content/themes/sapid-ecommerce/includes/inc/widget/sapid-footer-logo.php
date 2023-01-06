<?php
function sapid_footer_logo_register_widget() {
    register_widget( 'sapid_footer_logo' );
}
add_action( 'widgets_init', 'sapid_footer_logo_register_widget' );

class sapid_footer_logo extends WP_Widget {

    function __construct() {
        parent::__construct('sapid_footer_logo',__('Sapid Logo', 'Sapid'),
            array ('description' => __( 'Sapid Logo Description', 'Sapid' ), )
        );
    }
    
    /**
    * The footer logo widget.
    *
    * @access public
    * @param array      $args — The widget arguments.
    * @param array      $instance — The settings for the particular instance of the widget.
    * @return           Widget logo is directly echoed.
    */
    public function widget( $args, $instance ) {
        
        sapid_footer_logo(); 
    } 
    
    /**
    * The footer logo widget form.
    *
    * @access public
    * @param array      $instance — The settings for the particular instance of the widget.
    * @return           Form html elements.
    */
    public function form( $instance ) {
        if ( isset( $instance[ 'title' ] ) )
            $title = $instance[ 'title' ];
        else
            $title = '';
    ?>
        <p>
            <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
        </p>
    <?php
    }

    /**
    * update footer logo widget form.
    *
    * @access public
    * @param array      $new_instance — New settings for this instance.
    * @param array      $old_instance — Old settings for this instance.
    * @return array     $instance — Settings to save or bool false to cancel saving.
    */
    public function update( $new_instance, $old_instance ) {
        $instance = array();
        $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
        return $instance;
    }
    
}
?>