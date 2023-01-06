<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Start Class
if ( ! class_exists( 'Sapid_Post_Types' ) ) {

    class Sapid_Post_Types {

        public function __construct() {
            add_action( 'init', array( 'Sapid_Post_Types', 'sapid_register_post_types' ) );
            add_action( 'add_meta_boxes', array( 'Sapid_Post_Types','sapid_meta_box') );
            add_action( 'save_post_sapid-slider', array( 'Sapid_Post_Types','sapid_sliders_save_post') );
            add_shortcode( 'sapid_slider', array( 'Sapid_Post_Types','sapid_slider_shortcode') );
            add_filter('manage_sapid-slider_posts_columns', array( 'Sapid_Post_Types','sapid_slider_shortcode_columns'), 10,2);
            add_action('manage_sapid-slider_posts_custom_column', array( 'Sapid_Post_Types','sapid_slider_shortcode_columns_content'), 10, 2);
        }

        /**
         * Register post types.
         */
        public static function sapid_register_post_types() {
 
            //Sapid Slider    
            $labels = array(
                'name' => 'Sapid Slider',
                'singular_name' => 'Sapid Slider',
                'add_new' => 'Add New',
                'add_new_item' => 'Add New Slider',
                'edit_item' => 'Edit Slider',
                'new_item' => 'New Slider',
                'view_item' => 'View Slider',
                'search_items' => 'Search Sliders',
                'not_found' =>  'No Sliders found',
                'not_found_in_trash' => 'No Portfolios in the trash',
                'parent_item_colon' => '',
            );
         
            $args = array(
                'labels' => $labels,
                'public' => false,
                'publicly_queryable'  => false,
                'show_ui' => true,
                'exclude_from_search' => true,
                'show_in_admin_bar'   => false,
                'show_in_nav_menus'   => false,
                'query_var' => false,
                'rewrite' => true,
                'capability_type' => 'post',
                'has_archive' => true,
                'hierarchical' => false,
                'menu_position' => 11,
                'menu_icon' => 'dashicons-slides',
                'supports' => array('title')
            );
            register_post_type( 'sapid-slider', $args);    
        }    

        /**
         * meta box.
         */
        public static function sapid_meta_box(){
            add_meta_box( 'slider_gallery_form', 'Slider Gallery',  array( 'Sapid_Post_Types', 'sapid_slider_gallery_form' ), 'sapid-slider', 'normal', 'high' );
        }
           
        /**
         * slider meta box show function.
         */
        public static function sapid_slider_gallery_form() {
            global $post;
            $slider_data = get_post_meta( $post->ID, 'slider_data', true );
            // Use nonce for verification
            wp_nonce_field( 'slider_nonce', 'slider_nonce' );
            if ( ! did_action( 'wp_enqueue_media' ) ) {
                wp_enqueue_media();
            }
            ?>
            <div id="dynamic_form">
                <div id="field_wrap">
                    <?php 
                    if ( !empty( $slider_data ) && count($slider_data) > 0 ) {
                        foreach ( $slider_data as $field ) { 
                            $image = !empty($field['slider']) ? $field['slider']:'';
                            ?>
                            <div class="field_row">
                                <div class="field_left">
                                    <div class="form_field">
                                        <img class="slider-upload-img" src="<?php echo esc_url( $image ) ?>" />
                                        <a href="#" class="button slider-upload">Slider</a>
                                        <input type="hidden" class="slider-upload-id" name="slider[]" value="<?php echo $image; ?>">
                                    </div>
                                </div>
                                <div class="field_right">
                                    <div class="field-input">
                                        <label>Heading</label>
                                        <input type="text" name="heading[]" value="<?php echo $field['heading']; ?>">
                                    </div>
                                    <div class="field-input">
                                        <label>Sub Heading</label>
                                        <textarea name="sub_heading[]"><?php echo $field['sub_heading']; ?></textarea>
                                    </div>
                                    <div class="field-input">
                                        <label>Call To Action</label>
                                        <input type="text" name="call_to_action[]" value="<?php echo $field['call_to_action']; ?>">
                                    </div>
                                    <div class="field-input">
                                        <label>Call To Link</label>
                                        <input type="text" name="call_to_link[]" value="<?php echo $field['call_to_link']; ?>">
                                    </div>
                                    <input class="button remove-slider" type="button" value="Remove Slider Box" onclick="remove_field(this)" />
                                </div>
                                <div class="clear" /></div> 
                            </div>
                        <?php
                        } // endif
                    } // endforeach
                    ?>
                </div>
                <div style="display:none" id="master-row">
                    <div class="field_row">
                        <div class="field_left">
                            <div class="form_field">
                                <img class="slider-upload-img" src="" style="display:none" />
                                <a href="#" class="button slider-upload">Upload Slider</a>
                                <input type="hidden" class="slider-upload-id" name="slider[]" value="">
                            </div>
                        </div>
                        <div class="field_right">
                            <div class="field-input">
                                <label>Heading</label>
                                <input type="text" name="heading[]" value="">
                            </div>
                            <div class="field-input">
                                <label>Sub Heading</label>
                                <textarea name="sub_heading[]"></textarea>
                            </div>
                            <div class="field-input">
                                <label>Call To Action</label>
                                <input type="text" name="call_to_action[]" value="">
                            </div>
                            <div class="field-input">
                                <label>Call To Link</label>
                                <input type="text" name="call_to_link[]" value="">
                            </div>
                            <input class="button remove-slider" type="button" value="Remove Slider Box" onclick="remove_field(this)" />
                        </div>
                        <div class="clear"></div>
                    </div>
                </div>
                <div id="add_field_row">
                    <input class="button add-slider" type="button" value="Add Field" onclick="add_field_row();" />
                </div>
            </div>
            <style type="text/css">
                .field_left {
                    float:left;
                    width:46%;
                }

                .field_right {
                    float:left;
                    margin-left:10px;
                    width:46%;
                }
             
                img.slider-upload-img {
                    max-width: 100%;
                }
                  .clear {
                    clear:both;
                  }
             
                #dynamic_form input[type=text], #dynamic_form textarea {
                    width: 100%;
                    padding: 3px 10px;
                }
             
                #dynamic_form .field_row {
                    border:1px solid #999;
                    margin-bottom:10px;
                    padding:10px;
                }

                #dynamic_form .field-input {
                    display: inline-block;
                    width: 100%;
                    padding: 5px;
                }
             
                #dynamic_form label {
                    display: block;
                    font-size: 13px;
                    font-weight: 500;
                    padding: 5px 0;
                }

                .button.slider-upload, .remove-slider, .add-slider {
                    color: #32373c;
                    border-color: #dfdfdf;
                    background-color: #ffffff;
                    border-radius: 4px;
                    font-weight: 600;
                    height: 31px;
                }
                .button.remove-slider {
                    color: #F44336;
                    border-color: #dfdfdf;
                    margin-left: 5px;
                    margin-top: 10px;
                }
            </style>
         
            <script type="text/javascript">
                jQuery( 'body' ).on( 'click', '.slider-upload', function( event ){
                    var link = jQuery(this);
                    event.preventDefault();
                    var button = link,
                    custom_uploader = wp.media({
                      title: 'Slider Image',
                      library : {
                        type : 'image'
                      },
                      button: {
                        text: 'Upload' // button label text
                      },
                      multiple: false
                    }).on('select', function() { // it also has "open" and "close" events
                        var attachment = custom_uploader.state().get('selection').first().toJSON();
                        link.parent().find('.slider-upload-id').val(attachment.url);
                        link.parent().find('.slider-upload-img').attr('src',attachment.url);
                        link.parent().find('.slider-upload-img').show();
                    }).open();
                });

                function remove_field(obj) {
                    var parent = jQuery(obj).parent().parent();
                    parent.remove();
                }
         
                function add_field_row() {
                    var row = jQuery('#master-row').html();
                    jQuery(row).appendTo('#field_wrap');
                }
            </script>
          <?php
        }
         
        /**
         * save meta box testimonial function.
        * @param `$post_id` for id of percular blog post.
         */    
        public static function sapid_sliders_save_post( $post_id ) {
            if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
                return;
         
            if ( ! empty( $_POST['slider_nonce'] ) && ! wp_verify_nonce( $_POST['slider_nonce'], 'slider_nonce' ) )
                return;
         
            if ( ! current_user_can( 'edit_post', $post_id ) )
                return;
    
         
            $new = array();
            $slider = isset($_POST['slider']) ? $_POST['slider']:[];
            $heading = isset($_POST['heading']) ? $_POST['heading']:[];
            $sub_heading = isset($_POST['sub_heading']) ?$_POST['sub_heading']:[];
            $call_to_action = isset($_POST['call_to_action']) ? $_POST['call_to_action']:[];
            $call_to_link = isset($_POST['call_to_link']) ? $_POST['call_to_link']:[];
            $count = count( $slider );
            for ( $i = 0; $i < $count; $i++ ) {
                if ( $slider[$i] != '' ) :
                    $new[$i]['slider'] = stripslashes(  $slider[$i]  );
                    $new[$i]['heading'] = stripslashes(  $heading[$i]  );
                    $new[$i]['sub_heading'] = stripslashes( $sub_heading[$i] ); // and however you want to sanitize
                    $new[$i]['call_to_action'] = stripslashes( $call_to_action[$i] ); // and however you want to sanitize
                    $new[$i]['call_to_link'] = stripslashes( $call_to_link[$i] ); // and however you want to sanitize
                endif;
            }
            if(!empty($new) && count($new) > 0){
                update_post_meta( $post_id, 'slider_data', $new );
            }else{
                delete_post_meta($post_id, 'slider_data');
            }
        }

        /**  
        *manage shortcode coloumn
        *@param `$colums`
        */
        
        public static function sapid_slider_shortcode_columns($columns) {

            $columns['shortcode'] = __( 'Shortcode', 'Sapid' );

            return $columns;
        }

        /** 
         *show shortcode coloumn value
         * @param `$column_name`  for name of the column.
         * @param  `$post_ID`  for id of the blog post.
         * @return shortcode of  sapid_slider.  
         */

        public static function sapid_slider_shortcode_columns_content($column_name, $post_ID) {
            if ($column_name == 'shortcode') {
                echo '[sapid_slider id='.$post_ID.']';
            }
        }

        /**
         * Shortcode to display testimonials
         *
         * [sapid_slider id=12]
         */
        public static function sapid_slider_shortcode( $atts ) {
            extract( shortcode_atts( array(
                'id' => $atts['id']
            ), $atts ) );
         
            return self::get_slider( $id);
        }

        /**
         * get slider functions
         * @param `$id`  for slider id
         * @param `$style` for slider layout  style
        */

        public static function get_slider( $id){
            $autoplay = sapid_get_theme_option( 'tfes-autoplay')? sapid_get_theme_option( 'tfes-interval') :'false';
            $innerHtml ='';
            if(!empty($id)){
                $post = get_post($id);
                if(!empty($post) && $post->post_type =='sapid-slider'){
                    $slider_data = get_post_meta( $post->ID, 'slider_data', true );
                    if(!empty($slider_data) && is_array($slider_data)){
                        $innerHtml = '<div id="charitycarousel" class="carousel sapid-slider-carousel slidel slider2" data-bs-ride="carousel">
                            <div class="carousel-indicators">';
                                for ($i=0; $i < count($slider_data); $i++) { 
                                    $rowClass  = ($i == 0) ? "active" : "";
                                    $innerHtml .= '<button type="button" data-bs-target="#charitycarousel" data-bs-slide-to="'.$i.'" class="'.$rowClass.'" aria-current="true" aria-label="Slide-'.$i.'"></button>';
                                }
                            $innerHtml .= '</div>';
                            $innerHtml .= '<div class="carousel-inner overlay-banner">';
                            foreach ( $slider_data as $x => $field ) { 
                                $xClass  = ($x == 0) ? "active" : "";
                                $image = $field['slider'];
                                $innerHtml .= '<div class="carousel-item overlay-bx '.$xClass.'" style="background-image: url('.$image.')">';
                                if(!empty($field['heading'])){
                                    $innerHtml .= '<div class="carousel-caption text-start"><div class="card text-center" data-aos="flip-up">';
                                        $innerHtml .= '<h3 class="pt-2 pb-2 mb-0">'.$field['heading'].'</h3>';
                                        if(!empty($field['sub_heading'])){
                                            $innerHtml .= '<p class="mb-2">'.$field['sub_heading'].'</p>';
                                        }
                                        if(!empty($field['call_to_action'])){
                                            $call_to_link = !empty($field['call_to_link']) ? $field['call_to_link']:'#';
                                            $innerHtml .= '<a class="main-solid-btn m-auto" href="'.$call_to_link.'"><span>'.$field['call_to_action'].'<i class="fa mdi mdi-arrow-right"></i> </span> </a>';
                                        }
                                    $innerHtml .= '</div></div>';
                                }
                                $innerHtml .= '</div>';
                            }
                            $innerHtml .= '</div><button class="carousel-control-prev" type="button" data-bs-target="#charitycarousel" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon d-none d-lg-block" aria-hidden="true"></span>
                                <span class="visually-hidden">Previous</span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#charitycarousel" data-bs-slide="next">
                                <span class="carousel-control-next-icon  d-none d-lg-block" aria-hidden="true"></span>
                                <span class="visually-hidden">Next</span>
                            </button>
                        </div>'; 
                    }else{
                        $innerHtml = "<div>Slider Not Found</div>";
                    }

                }else{
                    $innerHtml = "<div>Invalid Slider Id</div>";
                }
            }else{
                $innerHtml = "<div>Slider Not Found</div>";
            }
            return $innerHtml;
        }
    }
}
new Sapid_Post_Types();