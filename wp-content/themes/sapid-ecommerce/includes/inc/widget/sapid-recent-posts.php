<?php
function sapid_recent_posts_register_widget() {
    register_widget( 'sapid_recent_posts' );
}
add_action( 'widgets_init', 'sapid_recent_posts_register_widget' );

class sapid_recent_posts extends WP_Widget {

    function __construct() {
        parent::__construct('sapid_recent_posts',__('Sapid Recent Posts', 'Sapid'),
            array ('description' => __( 'Sapid Recent Posts Description', 'Sapid' ), )
        );
    }
  /**
     * Recent Posts widget.
     *
     * @since 1.0.0
     *
     * @param array $args Current arguments.
     * @param array $instance Current settings.
     * @return Widget content directly echoed.
     */
    public function widget( $args, $instance ) {

        $post_type = empty( $instance['post_type'] ) ? '' : $instance['post_type'];
        $title     = !empty( $instance['title'] ) ? $instance['title'] : '';
        /** This filter is documented in wp-includes/widgets/class-wp-widget-pages.php */
        $title = apply_filters( 'widget_title', $title, $instance, $this->id_base );

        $order = isset( $instance['order'] ) ? $instance['order'] : '';
        $order_by = isset( $instance['order_by'] ) ? $instance['order_by'] : '';
        $show_date = isset( $instance['show_date'] ) ? $instance['show_date'] : 0;
        $show_thumbnail = isset( $instance['show_thumbnail'] ) ? $instance['show_thumbnail'] : 0;
        $number_show = isset( $instance['number_show'] ) ? $instance['number_show'] : 5;
        $footer = sapid_get_theme_option('footer-layout');

        $textColor = '';
        if($footer == 'v1'){
           $textColor = ' text-dark'; 
        }
        
        echo $args['before_widget'];

        if ( $title ) {
            echo $args['before_title'] . $title . $args['after_title'];
        }

        $argPosts = array(
            'posts_per_page' => $number_show,
            'post_type' => $post_type,
            'orderby' => $order_by,
            'order' => $order,
        );
        $query = new WP_Query( $argPosts  );
        if ( $query->have_posts() ) {
            while ( $query->have_posts() ) : $query->the_post();
                $post_id = $query->post->ID;
                echo '<div class="d-flex no-block m-t-20">';
                if(!empty($show_thumbnail)){
                    $img = wp_get_attachment_image_src(get_post_thumbnail_id($post_id), 'thumbnail');
                    $thumbnail = !empty($img) ? $img[0]:get_template_directory_uri().'/assets/images/no-thumb.png';
                    echo '<div class="thumb m-r-20"><img width="50" height="50" src='.$thumbnail.'></div>';
                }
                echo'<div class="btext">';
                    echo'<a href="'.get_permalink($post_id).'" class="link'.$textColor.'">'.$query->post->post_title.'</a>';
                    if(!empty($show_date)){
                        echo'<span class="d-block'.$textColor.'">'.get_the_date().'</span>';
                    }
                echo'</div>
            </div>';
            endwhile;
            wp_reset_postdata();
        }else{
            echo '<p>No Data Found.</p>';
        }
        echo $args['after_widget'];
    } 
    
  /**
     * Outputs the settings form for the Recent Posts widget.
     *
     * @since 3.0.0
     *
     * @param array $instance Current settings.
     * @global WP_Customize_Manager $wp_customize
     */
    public function form( $instance ) {
        global $wp_customize;
        $title     = isset( $instance['title'] ) ? $instance['title'] : '';
        $type = isset( $instance['post_type'] ) ? $instance['post_type'] : '';
        $order = isset( $instance['order'] ) ? $instance['order'] : '';
        $order_by = isset( $instance['order_by'] ) ? $instance['order_by'] : '';
        $show_date = isset( $instance['show_date'] ) ? $instance['show_date'] : 0;
        $show_thumbnail = isset( $instance['show_thumbnail'] ) ? $instance['show_thumbnail'] : 0;
        $number_show = isset( $instance['number_show'] ) ? $instance['number_show'] : 5;

        $args = array(
            'public'   => true,
        );
        $post_types = get_post_types( $args , 'objects'); 
        unset( $post_types['attachment'] );
        $post_orders = ['ASC', 'DESC'];
        $post_order_bys = ['ID', 'title', 'date'];
        ?>
        <div class="recent-post-widget-form-controls">
            <p>
                <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
                <input type="text" class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo esc_attr( $title ); ?>" />
            </p>
            <p>
                <label for="<?php echo $this->get_field_id( 'post_type' ); ?>"><?php _e( 'Post Type:' ); ?></label>
                <select id="<?php echo $this->get_field_id( 'post_type' ); ?>" class="widefat" name="<?php echo $this->get_field_name( 'post_type' ); ?>">
                  <?php
                  foreach ($post_types  as $post_type) {
                    $selected = '';
                    if($type == $post_type->name){
                        $selected = 'selected';
                    }
                  ?>
                    <option value="<?php echo esc_attr($post_type->name); ?>" <?php echo $selected; ?>><?php echo esc_html($post_type->labels->singular_name); ?></option>
                  <?php
                  }
                  ?>
                </select>
            </p>
            <p>
                <label for="<?php echo $this->get_field_id( 'order' ); ?>"><?php _e( 'Order:' ); ?></label>
                <select id="<?php echo $this->get_field_id( 'order' ); ?>" class="widefat" name="<?php echo $this->get_field_name( 'order' ); ?>">
                  <?php
                    foreach ($post_orders  as $post_order) {
                        $selected = '';
                        if($order == $post_order){
                            $selected = 'selected';
                        }
                    ?>
                        <option value="<?php echo esc_attr($post_order); ?>" <?php echo $selected; ?>><?php echo esc_html($post_order); ?></option>
                  <?php } ?>
                </select>
            </p>
            <p>
                <label for="<?php echo $this->get_field_id( 'order_by' ); ?>"><?php _e( 'Order By:' ); ?></label>
                <select id="<?php echo $this->get_field_id( 'order_by' ); ?>" class="widefat" name="<?php echo $this->get_field_name( 'order_by' ); ?>">
                  <?php
                    foreach ($post_order_bys  as $post_order_by) {
                        $selected = '';
                        if($order_by == $post_order_by){
                            $selected = 'selected';
                        }
                    ?>
                        <option value="<?php echo esc_attr($post_order_by); ?>" <?php echo $selected; ?>><?php echo esc_html($post_order_by); ?></option>
                  <?php } ?>
                </select>
            </p>
            <p>
                <label for="number_show">Number of posts to show:</label>
                <input class="tiny-text" id="widget-recent-posts-number_show" name="<?php echo $this->get_field_name( 'number_show' ); ?>" type="number" step="1" min="1" value="<?php echo $number_show; ?>" size="3">
            </p>
            <p>
                <label for="<?php echo $this->get_field_id( 'show_date' ); ?>"><?php _e( 'Show Date:' ); ?></label>
                <input type="checkbox" name="<?php echo $this->get_field_name( 'show_date' ); ?>" <?php echo !empty($show_date) ? 'checked':''; ?>>
            </p>
            <p>
                <label for="<?php echo $this->get_field_id( 'show_thumbnail' ); ?>"><?php _e( 'Show Thumbnail:' ); ?></label>
                <input type="checkbox" name="<?php echo $this->get_field_name( 'show_thumbnail' ); ?>" <?php echo !empty($show_thumbnail) ? 'checked':''; ?>>
            </p>
        </div>
        <?php
    }

    /**
     * Handles updating settings for the current Recent Posts widget instance.
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
        if ( ! empty( $new_instance['title'] ) ) {
            $instance['title'] = sanitize_text_field( $new_instance['title'] );
        }
        $show_date = !empty( $new_instance['show_date'] ) ? 1:0;
        $show_thumbnail = !empty( $new_instance['show_thumbnail'] ) ? 1:0;
        $instance['order_by'] = sanitize_text_field( $new_instance['order_by'] );
        $instance['post_type'] = sanitize_text_field( $new_instance['post_type'] );
        $instance['order'] = sanitize_text_field( $new_instance['order'] );
        $instance['number_show'] = sanitize_text_field( $new_instance['number_show'] );
        $instance['show_date'] = sanitize_text_field( $show_date );
        $instance['show_thumbnail'] = sanitize_text_field( $show_thumbnail );
        return $instance;
    }
}
?>