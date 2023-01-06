<?php
function sapid_footer_contact_register_widget() {
    register_widget( 'sapid_footer_contact' );
}
add_action( 'widgets_init', 'sapid_footer_contact_register_widget' );

class sapid_footer_contact extends WP_Widget {

    function __construct() {
        parent::__construct('sapid_footer_contact',__('Sapid Contact', 'Sapid'),
            array ('description' => __( 'Sapid Contact Description', 'Sapid' ), )
        );
    }

    /**
    * The footer contact widget.
    *
    * @access public
    * @param array      $args — The widget arguments.
    * @param array      $instance — The settings for the particular instance of the widget.
    * @return           Widget Content is directly echoed.
    */
    public function widget( $args, $instance ) {
        $title    = ! empty( $instance['title'] ) ? $instance['title'] : '';
        $footer = sapid_get_theme_option('footer-layout');
        $footer = !empty($footer)? $footer:'v3';
        $footer_Phone_Number = sapid_get_theme_option( 'header-number' );
        $footer_Email = sapid_get_theme_option('header-email');
        $footer_Address = sapid_get_theme_option('header-address');
        $footer_timing = sapid_get_theme_option('header-timing');

        $hide_address = isset( $instance['hide_address'] ) ? $instance['hide_address'] : 0;
        $hide_email = isset( $instance['hide_email'] ) ? $instance['hide_email'] : 0;
        $hide_phone = isset( $instance['hide_phone'] ) ? $instance['hide_phone'] : 0;
        $hide_timing = isset( $instance['hide_timing'] ) ? $instance['hide_timing'] : 0;
        $hide_icon = isset( $instance['hide_icon'] ) ? $instance['hide_icon'] : 'No';

        echo $args['before_widget'];
        if ( $title && $footer != 'v1' ) {
            echo $args['before_title'] . $title . $args['after_title'];
        }
        $titleTag = '';
        if($footer == 'v1'){
            $titleTag = '<span>'.$title.'</span>';
        }
        echo '<div class="info-box">';
            if(empty($hide_address) && !empty($footer_Address)){
                if($hide_icon == 'No'){
                    echo '<div class="d-flex align-items-center"><div class="display-7"><i class="mdi mdi-map-marker-multiple-outline"></i></div><div class="info">'.$titleTag.'<p class="mb-0"><span>'.$footer_Address.'</span></p></div></div>';
                }else{
                    echo'<p>'.$footer_Address.'</p>';
                }
            }

            if(empty($hide_timing) && !empty($footer_timing)){
                if($hide_icon == 'No'){
                    echo '<div class="d-flex align-items-center"><div class="display-7"><i class="mdi mdi-timeline-clock-outline"></i></div><div class="info"><span>'.$footer_timing.'</span></div></div>';
                }else{
                    echo'<p><span>'.$footer_timing.'</span></p>';
                }
            }

            if(empty($hide_phone) && !empty($footer_Phone_Number)){
                if($hide_icon == 'No'){
                    echo '<div class="d-flex no-block align-items-center"><div class="display-7"><i class="mdi mdi-phone-voip"></i></div><div class="info"><a href="tel:'.$footer_Phone_Number.'">'.$footer_Phone_Number.'</a></div></div>';
                }else{
                    echo'<p><a class="font-medium text-dark db  m-t-5" href="tel:'.$footer_Phone_Number.'">'.$footer_Phone_Number.'</a></p>';
                }
            }
            if(empty($hide_email) && !empty($footer_Email)){
                if($hide_icon == 'No'){
                    echo '<div class="d-flex no-block align-items-center"><div class="display-7"><i class="mdi mdi-email-edit-outline"></i></div><div class="info"><a href="mailto: '.$footer_Email.'">'.$footer_Email.'</a></div></div>';
                }else{
                    echo'<p><a class="link text-black" href="mailto: '.$footer_Email.'">'.$footer_Email.'</a></p>';
                }
            }
        echo '</div>';
        echo $args['after_widget'];
    } 
    
    /**
    * The footer contact widget form.
    *
    * @access public
    * @param array      $instance — The settings for the particular instance of the widget.
    * @return           Form html elements.
    */
    public function form( $instance ) {
        $hide_address = isset( $instance['hide_address'] ) ? $instance['hide_address'] : 0;
        $hide_email = isset( $instance['hide_email'] ) ? $instance['hide_email'] : 0;
        $hide_phone = isset( $instance['hide_phone'] ) ? $instance['hide_phone'] : 0;
        $hide_timing = isset( $instance['hide_timing'] ) ? $instance['hide_timing'] : 0;
        $hide_icon = isset( $instance['hide_icon'] ) ? $instance['hide_icon'] : 'No';
        $posts = ['Yes', 'No'];
        if ( isset( $instance[ 'title' ] ) )
            $title = $instance[ 'title' ];
        else
            $title = '';
    ?>
        <p>
            <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id( 'hide_icon' ); ?>"><?php _e( 'Hide Icon:' ); ?></label>
            <select id="<?php echo $this->get_field_id( 'hide_icon' ); ?>" class="widefat" name="<?php echo $this->get_field_name( 'hide_icon' ); ?>">
              <?php
                foreach ($posts  as $post) {
                    $selected = '';
                    if($hide_icon == $post){
                        $selected = 'selected';
                    }
                ?>
                <option value="<?php echo $post; ?>" <?php echo $selected; ?>><?php echo $post; ?></option>
                <?php
                  }
                ?>
            </select>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id( 'hide_address' ); ?>"><?php _e( 'Hide Address:' ); ?></label>
            <input type="checkbox" name="<?php echo $this->get_field_name( 'hide_address' ); ?>" <?php echo !empty($hide_address) ? 'checked':''; ?>>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id( 'hide_email' ); ?>"><?php _e( 'Hide Email Address:' ); ?></label>
            <input type="checkbox" name="<?php echo $this->get_field_name( 'hide_email' ); ?>" <?php echo !empty($hide_email) ? 'checked':''; ?>>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id( 'hide_phone' ); ?>"><?php _e( 'Hide Phone Number:' ); ?></label>
            <input type="checkbox" name="<?php echo $this->get_field_name( 'hide_phone' ); ?>" <?php echo !empty($hide_phone) ? 'checked':''; ?>>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id( 'hide_timing' ); ?>"><?php _e( 'Hide Clock Timing:' ); ?></label>
            <input type="checkbox" name="<?php echo $this->get_field_name( 'hide_timing' ); ?>" <?php echo !empty($hide_timing) ? 'checked':''; ?>>
        </p>
    <?php
    }

    /**
    * update footer contact widget form.
    *
    * @access public
    * @param array      $new_instance — New settings for this instance.
    * @param array      $old_instance — Old settings for this instance.
    * @return array     $instance — Settings to save or bool false to cancel saving.
    */
    public function update( $new_instance, $old_instance ) {
        $instance = array();
        $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
        $hide_address = !empty( $new_instance['hide_address'] ) ? 1:0;
        $instance['hide_address'] = sanitize_text_field( $hide_address );
        $hide_email = !empty( $new_instance['hide_email'] ) ? 1:0;
        $instance['hide_email'] = sanitize_text_field( $hide_email );
        $hide_phone = !empty( $new_instance['hide_phone'] ) ? 1:0;
        $instance['hide_phone'] = sanitize_text_field( $hide_phone );
        $hide_icon = $new_instance['hide_icon'];
        $instance['hide_icon'] = sanitize_text_field( $hide_icon );
        $hide_timing = $new_instance['hide_timing'];
        $instance['hide_timing'] = sanitize_text_field( $hide_timing );
        return $instance;
    }
}
?>