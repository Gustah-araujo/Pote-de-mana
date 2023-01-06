<?php
function sapid_social_icon_register_widget() {
    register_widget( 'sapid_social_icon' );
}
add_action( 'widgets_init', 'sapid_social_icon_register_widget' );

class sapid_social_icon extends WP_Widget {

    function __construct() {
        parent::__construct('sapid_social_icon',__('Sapid Social Icon', 'Sapid'),
            array ('description' => __( 'Sapid Social Icon Description', 'Sapid' ), )
        );
    }
    
  /**
     * Social Icon widget.
     *
     * @since 1.0.0
     *
     * @param array $args Current arguments.
     * @param array $instance Current settings.
     * @return Widget content directly echoed.
     */
    public function widget( $args, $instance ) {

        $classname = empty( $instance['classname'] ) ? 'm-t-20 m-b-30' : $instance['classname'];
        $title         = ! empty( $instance['title'] ) ? $instance['title'] : '';
        echo $args['before_widget'];
        if ( $title ) {
            echo $args['before_title'] . $title . $args['after_title'];
        }
        echo '<div class="'.$classname.'">';    
            do_action('sapid_social_media');
        echo '</div>';  
          
        echo $args['after_widget'];
    } 
    
  /**
     * Outputs the settings form for the Social Icon widget.
     *
     * @since 3.0.0
     *
     * @param array $instance Current settings.
     * @global WP_Customize_Manager $wp_customize
     */
    public function form( $instance ) {
        if ( isset( $instance[ 'title' ] ) )
            $title = $instance[ 'title' ];
        else
            $title = '';

        if ( isset( $instance[ 'classname' ] ) )
            $classname = $instance[ 'classname' ];
        else
            $classname = 'm-t-20 m-b-30';
    ?>
        <p>
            <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id( 'classname' ); ?>"><?php _e( 'Main Div Class:' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'classname' ); ?>" name="<?php echo $this->get_field_name( 'classname' ); ?>" type="text" value="<?php echo esc_attr( $classname ); ?>" />
        </p>
    <?php
    }

  /**
     * Handles updating settings for the current Social Icon widget instance.
     *
     * @since 3.0.0
     *
     * @param array $new_instance New settings for this instance as input by the user via
     * WP_Widget::form().
     * @param array $old_instance Old settings for this instance.
     * @return array Updated settings to save.
     */
    public function update( $new_instance, $old_instance ) {
        $instance = array();
        $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
        $instance['classname'] = ( ! empty( $new_instance['classname'] ) ) ? strip_tags( $new_instance['classname'] ) : '';
        return $instance;
    }
    
}
?>