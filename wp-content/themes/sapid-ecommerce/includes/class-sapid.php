<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Start Class
if ( ! class_exists( 'Sapid_Theme_Options' ) ) {

    class Sapid_Theme_Options {

        /**
         * The template directory path.
         *
         * @static
         * @access public
         * @var string
         */
        public static $template_dir_path = '';

        /**
         * The template directory URL.
         *
         * @static
         * @access public
         * @var string
         */
        public static $template_dir_url = '';

        /**
         * The stylesheet directory path.
         *
         * @static
         * @access public
         * @var string
         */
        public static $stylesheet_dir_path = '';

        /**
         * The stylesheet directory URL.
         *
         * @static
         * @access public
         * @var string
         */
        public static $stylesheet_dir_url = '';

        public static $is_updating = '';

        /**
         * An array of our sections.
         *
         * @access public
         * @var array
         */
        public static $sections = [];

        /**
         * The tab_names.
         *
         * @static
         * @access public
         * @var string
         */
        public static $section_names = [];

        public static $fields;

        public function __construct() {
            self::$is_updating = ( $_GET && isset( $_GET['sapid_update'] ) && '1' == $_GET['sapid_update'] );
            // We only need to register the admin panel on the back-end
            if ( is_admin() ) {
                add_action( 'admin_menu', array( 'Sapid_Theme_Options', 'add_admin_menu' ) );
                add_action( 'admin_init', array( 'Sapid_Theme_Options', 'register_settings' ) );
                add_action('admin_enqueue_scripts', array( 'Sapid_Theme_Options', 'load_css_js') );
                add_action('admin_head', array( 'Sapid_Theme_Options', 'add_inline_css') );
                // Set static vars.
                if ( '' === self::$template_dir_path ) {
                    self::$template_dir_path = wp_normalize_path( get_template_directory() );
                }
                if ( '' === self::$template_dir_url ) {
                    self::$template_dir_url = get_template_directory_uri();
                }
                if ( '' === self::$stylesheet_dir_path ) {
                    self::$stylesheet_dir_path = wp_normalize_path( get_stylesheet_directory() );
                }
                if ( '' === self::$stylesheet_dir_url ) {
                    self::$stylesheet_dir_url = get_stylesheet_directory_uri();
                }

                self::$section_names = [
                    'header',
                    'home',
                    'footer',
                    'sidebars',
                    'breadcrumbs',
                    'blog',
                    'social_media',
                    'extra',
                    'woocommerce',
                    'custom_css',
                    'import_data',
                ];
            }
        }

        /**
         * echo custom css
         *
         * @since 1.0.0
         */
        public static function add_inline_css() {
            echo '<style>
                #adminmenu .toplevel_page_theme-settings .wp-menu-image img {
                    padding-top: 6px;
                    width: 20px;
                    opacity: 1;
                }
            </style>';
        }

        /**
         * Returns all theme options
         *
         * @since 1.0.0
         */
        public static function get_theme_options() {
            return get_option( 'sapid_options' );
        }

        /**
         * Returns single theme option
         *
         * @since 1.0.0
         */
        public static function get_theme_option( $id ) {
            $options = self::get_theme_options();
            if ( isset( $options[$id] ) ) {
                return $options[$id];
            }
        }

        /**
         * Add sub menu page
         *
         * @since 1.0.0
         */
        public static function add_admin_menu() {
            add_menu_page(
                esc_html__( 'Sapid', 'Sapid' ),
                esc_html__( 'Sapid', 'Sapid' ),
                'manage_options',
                'theme-settings',
                array( 'Sapid_Theme_Options', 'create_admin_page' ),
                self::$template_dir_url.'/assets/admin/img/logo.png',
                2
            );
        }

        /**
         * Register a setting and its sanitization callback.
         *
         * We are only registering 1 setting so we can store all options in a single option as
         * an array. You could, however, register a new setting for each option
         *
         * @since 1.0.0
         */
        public static function register_settings() {
            register_setting( 'sapid_options', 'sapid_options', array( 'Sapid_Theme_Options', 'sanitize' ) );
        }

        /**
         * Sanitization callback
         *
         * @since 1.0.0
         */
        public static function sanitize( $options ) {
            // Return sanitized options
            //echo "<pre>"; print_r($options); die;
            return $options;

        }

        /**
         * Include required files.
         *
         * @access public
         */
        public static function include_files() {

            foreach (self::$section_names as $section ) {
                include_once self::$template_dir_path . '/includes/option/' . $section . '.php';
            }

        }

        /**
         * Set the sections.
         *
         * @access public
         */
        public static function set_sections() {
            self::include_files();
            $sections = [];
            foreach ( self::$section_names as $section ) {
                // Make sure the function exists before call_user_func().
                if ( ! function_exists( 'sapid_options_section_' . $section ) ) {
                    continue;
                }
                $sections = call_user_func( 'sapid_options_section_' . $section, $sections );
            }
            return $sections;
            
        }

        /**
         * Sets the menu.
         *
         * @access public
         */
        public static function set_menu() {
            $result = [];
            foreach ( self::set_sections() as $section ) {
                if ( ! isset( $section['id'] ) ) {
                    continue;
                }
                $data['label'] = $section['label'];
                $data['id'] =  $section['id'];
                $data['icon'] =  !empty($section['icon']) ? $section['icon']:'';
                $sub_menu = [];
                // Start parsing the fields.
                foreach ( $section['fields'] as $field ) {
                    if ( ! isset( $field['id'] ) ) {
                        continue;
                    }
                    if ( isset( $field['type'] ) && in_array( $field['type'], [ 'sub-section', 'accordion' ], true ) ) {
   
                            $sub_menu[] = $field['label'];
                        
                    }
                }
                $data['fields'][$section['id']] = $sub_menu;
                $result[]= $data;
            }
            //echo "<pre>"; print_r($result); die;
            return $result;
        }


        /**
         * Settings page output
         *
         * @since 1.0.0
         */
        public static function create_admin_page() { 
            self::load_css_js();
            wp_enqueue_style( 'theme-styles' );
            wp_enqueue_style( 'jquery-ui-styles' );
            wp_enqueue_style( 'chosen-css' );
            wp_enqueue_style( 'material-icons' );
            if ( ! did_action( 'wp_enqueue_media' ) ) {
                wp_enqueue_media();
            }
            wp_enqueue_script( 'chosen-jquery' );
            wp_enqueue_script( 'theme-script' );
            wp_enqueue_script( 'media-upload-script' );
            wp_enqueue_script( 'material-iconpicker' );

            ?>
            <div class="wrap">
                <div class="container">
                    <div class="loader" style="display: none;"><img src="<?php echo self::$template_dir_url; ?>/assets/admin/img/loading.gif"></div>
                    <form method="post" action="options.php" id="sapid-form-wrapper">
                        <?php settings_fields( 'sapid_options' ); ?>
                        <div class="side-nav">
                            <ul class="nav-menu">
                                <?php
                                    $key = 0;
                                    foreach ( self::set_menu() as $x => $section ) {
                                        if ( ! isset( $section['label'] ) ) {
                                            continue;
                                        }
                                        $class = ($key == 0) ? " active" : "";
                                        $icon =  'font-18 mdi mdi-'.$section['icon'];
                                        echo '<li id="'.$key.'_section_group_li" class="nav-item'.$class.'"><a id="'.$key.'_section_group_a" href="javascript:void(0);"><i class="'.$icon.'"></i><span class="menu-text">'. $section['label'].'</span></a>';
                                        if(!empty($section['fields'][$section['id']]) && count($section['fields'][$section['id']]) > 0){
                                            echo '<ul class="sub-menu">';
                                            foreach ( $section['fields'][$section['id']]  as $field ) {
                                                $key++;
                                                echo '<li id="'.$key.'_section_group_li" class="nav-item"><a id="'.$key.'_section_group_a" href="javascript:void(0);"><span class="menu-text">'.$field.'</span></a></li>';
                                            }
                                            echo '</ul>';
                                        }
                                        echo '</li>';
                                        $key++;
                                    }
                                ?>
                            </ul>
                        </div>
                        <div class="sapid-main">
                            <?php
                                $key = 0;
                                $sliderArr = [];
                                $options = self::get_theme_options();
                                foreach ( self::set_sections() as $x => $section ) {
                                    if ( ! isset( $section['fields'] ) ) {
                                        continue;
                                    }
                                    $style = ($key == 0) ? " display: block;" : "display: none;";
                                    echo '<div id="'.$key.'_section_group" class="sapid-group-tab-link-li" style="'.$style.'">';
                                        echo '<h2>'.$section['label'].'</h2>';
                                        echo "<table class='form-table' style='width:100%;'><tbody>";
                                            foreach ( $section['fields'] as $field ) {
                                                if ( ! isset( $field['id'] ) ) {
                                                    continue;
                                                }
                                                $label = $field['label'];
                                                $description = !empty($field['description'] ) ? $field['description']:'';
                                                $id = $field['id'];
                                                $type = $field['type'];
                                                $choices = !empty($field['choices']) ? $field['choices']:[];
                                                $fields = !empty($field['fields']) ? $field['fields']:[];
                                                $default = isset($field['default']) ? $field['default']:'';
                                                $multi = isset($field['multi']) ? $field['multi']:'';
                                                $default = isset($options[$id]) ? $options[$id]:$default;
                                                $data_mode = isset($field['data-mode']) ? $field['data-mode']:'';
                                                $data_parent = isset($field['data-parent']) ? $field['data-parent']:'';
                                                $content = !empty($field['content']) ? $field['content']:'';
                                                if ( isset( $field['type'] ) && in_array( $field['type'], [ 'sub-section', 'accordion' ], true ) ) {
                                                    $key++;
                                                    echo "</tbody></table>";    
                                                    echo'</div>';
                                                    echo '<div id="'.$key.'_section_group" class="sapid-group-tab-link-li" style="'.$style.'">';
                                                    echo '<h2>'.$label.'</h2>';
                                                    echo "<table class='form-table' style='width:100%;'><tbody>";
                                                    foreach ( $field['fields'] as $sub_field ) {
                                                        if ( ! isset( $sub_field['id'] ) ) {
                                                            continue;
                                                        }
                                                        $label = $sub_field['label'];
                                                        $description = !empty($sub_field['description'] ) ? $sub_field['description']:'';
                                                        $id = $sub_field['id'];
                                                        $type = $sub_field['type'];
                                                        $choices = !empty($sub_field['choices']) ? $sub_field['choices']:[];
                                                        $fields = !empty($sub_field['fields']) ? $sub_field['fields']:[];
                                                        $default = isset($sub_field['default']) ? $sub_field['default']:''; 
                                                        $default = isset($options[$id]) ? $options[$id]:$default;
                                                        $content = !empty($sub_field['content']) ? $sub_field['content']:'';
                                                        $multi = isset($sub_field['multi']) ? $sub_field['multi']:'';
                                                        $data_mode = isset($sub_field['data-mode']) ? $sub_field['data-mode']:'';
                                                        $data_parent = isset($sub_field['data-parent']) ? $sub_field['data-parent']:'';
                                                        $m_type = str_replace('-', '_', $type);
                                                        $module = 'option_form_field_'.$m_type;

                                                        $form_before      = self::option_form_before($id, $label, $description, $type, $data_mode, $data_parent);
                                                        $fieldset_start   = self::option_form_fieldset_start($id, $type, $data_mode, $data_parent);
                                                        $moduleCall       = self::$module( $id, $default, $choices, $data_mode, $data_parent, $options, $label, $type, $content, $description, $multi, $fields);
                                                        $form_after      = self::option_form_after();
                                                        $fieldset_end      = self::option_form_fieldset_end();
                                                        if($type != 'info'){
                                                            echo $form_before.$fieldset_start.$moduleCall.$form_after.$fieldset_end;
                                                        }else{
                                                           echo $moduleCall; 
                                                        }

                                                        if($type == 'slider'){
                                                            $sliderArr['id'][] = $id;
                                                            $sliderArr['slider'][] = $id.'_slider';
                                                            $sliderArr['choice'][] = $choices;
                                                            $sliderArr['default'][] = $default;                   
                                                        } 
                                                    }
                                                }else{      
                                                    $m_type = str_replace('-', '_', $type);
                                                    $module = 'option_form_field_'.$m_type;

                                                    $form_before      = self::option_form_before($id, $label, $description, $type, $data_mode, $data_parent);
                                                    $fieldset_start   = self::option_form_fieldset_start($id, $type, $data_mode, $data_parent);
                                                    $moduleCall       = self::$module( $id, $default, $choices, $data_mode, $data_parent, $options, $label, $type, $content, $description, $multi, $fields);
                                                    $form_after      = self::option_form_after();
                                                    $fieldset_end      = self::option_form_fieldset_end();
                                                    if($type != 'info'){
                                                        echo $form_before.$fieldset_start.$moduleCall.$form_after.$fieldset_end;
                                                    }else{
                                                       echo $moduleCall; 
                                                    }

                                                    if($type == 'slider'){
                                                        $sliderArr['id'][] = $id;
                                                        $sliderArr['slider'][] = $id.'_slider';
                                                        $sliderArr['choice'][] = $choices;
                                                        $sliderArr['default'][] = $default;                   
                                                    } 
                                                }
                                            }
                                        echo "</tbody></table>";    
                                    echo'</div>';
                                    $key++;
                                }
                                wp_localize_script( 'theme-script', 'range_slider', $sliderArr );
                                wp_localize_script( 'theme-script', 'backend_object',
                                    array( 
                                        'ajaxurl' => admin_url( 'admin-ajax.php' ),
                                        'ajax_nonce' => wp_create_nonce('sapid_nonce'),
                                        'options' => $options
                                    )
                                );

                                ?>
                            <?php submit_button(); ?>    
                        </div>
                    </form>
                </div>
            </div><!-- .wrap -->
        <?php }

		//theme css and js file load/add
		public static function load_css_js() {
            wp_enqueue_script( 'jquery', self::$template_dir_url .'/assets/admin/js/jquery.min.js', array(), null, false );
            wp_enqueue_script( 'jquery-ui', self::$template_dir_url .'/assets/admin/js/jquery-ui.js', array(), null, false );
            wp_register_style( 'jquery-ui-styles', self::$template_dir_url . '/assets/admin/css/jquery-ui.css', false, '1.0.0' );
            wp_register_style( 'theme-styles', self::$template_dir_url . '/assets/admin/css/theme-style.css', false, '1.0.0' );
            wp_register_style( 'material-icons', self::$template_dir_url . '/assets/css/materialdesignicons.min.css', false, '1.0.0' );
            wp_register_style( 'chosen-css', self::$template_dir_url . '/assets/admin/css/chosen.min.css', false, '1.0.0' );
            wp_register_script( 'theme-script',self::$template_dir_url .'/assets/admin/js/theme-script.js' , array(), null, '1.0.0' );
            wp_register_script( 'media-upload-script',self::$template_dir_url .'/assets/admin/js/media-upload-script.js' , array(), null, '1.0.0' );
            wp_register_script( 'chosen-jquery',self::$template_dir_url .'/assets/admin/js/chosen.jquery.min.js' , array('jquery'), null, '1.0.0' );
            wp_register_script( 'material-iconpicker',self::$template_dir_url .'/assets/admin/js/material-iconpicker.js' , array('jquery'), null, '1.0.0' );
		}

        public static function get_defaults_social( $custom = true, $colors = false ) {
            $networks = [
                'blogger'    => [
                    'label' => 'Blogger',
                ],
                'deviantart' => [
                    'label' => 'Deviantart',
                ],
                'discord'    => [
                    'label' => 'Discord',
                ],
                'digg'       => [
                    'label' => 'Digg',
                ],
                'dribbble'   => [
                    'label' => 'Dribbble',
                ],
                'dropbox'    => [
                    'label' => 'Dropbox',
                ],
                'facebook'   => [
                    'label' => 'Facebook',
                ],
                'flickr'     => [
                    'label' => 'Flickr',
                ],
                'instagram'  => [
                    'label' => 'Instagram',
                ],
                'linkedin'   => [
                    'label' => 'LinkedIn',
                ],
                'myspace'    => [
                    'label' => 'Myspace',
                ],
                'pinterest'  => [
                    'label' => 'Pinterest',
                ],
                'reddit'     => [
                    'label' => 'Reddit',
                ],
                'rss'        => [
                    'label' => 'RSS',
                ],
                'skype'      => [
                    'label' => 'Skype',
                ],
                'teams'      => [
                    'label' => 'Teams',
                ],
                'telegram'   => [
                    'label' => 'Telegram',
                ],
                'tumblr'     => [
                    'label' => 'Tumblr',
                ],
                'twitter'    => [
                    'label' => 'Twitter',
                ],
                'vimeo'      => [
                    'label' => 'Vimeo',
                ],
                'wechat'     => [
                    'label' => 'WeChat',
                ],
                'whatsapp'   => [
                    'label' => 'WhatsApp',
                ],
                'xing'       => [
                    'label' => 'Xing',
                ],
                'yahoo'      => [
                    'label' => 'Yahoo',
                ],
                'youtube'    => [
                    'label' => 'Youtube',
                ]
            ];

            return $networks;
        }

        /**
         * option form before
         * @param  `$id`  for  form field id
         * @param `$label`  for form label
         * @param `$description` for description
         * @param `$type` for input type of form
         * @param `$data_mode`  data mode for active and inactive child elements
         * @param `$data_parent` used for id of parent element 
         */
        public static function option_form_before($id, $label, $description, $type, $data_mode, $data_parent){
            $trClass = '';
            $is_conditional = '';
            $parentClass = '';
            if(!empty($data_parent)){
                $parentClass = ' '.$data_parent.'-parent';
                $is_conditional = ' is_sub_fields';
                $data = explode(',', $data_mode);
                foreach($data as $val){
                    $trClass .= ' '.$data_parent.'-'.$val;
                }
            }
            if(($type == 'import' || $type == 'export' ||  $type == 'custom' || $type == 'radio-image') && $id != 'bg_pattern'){
                return '<tr class="sapid_options '.$type.'-info'.$trClass.$parentClass.$is_conditional.'"><td colspan="2">';
            }else{
                return '<tr class="sapid_options '.$type.$trClass.$parentClass.$is_conditional.'"><th><div class="sapid_field_th">'.$label.'<span class="description">'.$description.'</span></div></th><td>';
            }
        }

        /**
         * option form fieldset start
         * @param  `$id`  for  form field id
         * @param `$type` for input type of form
         * @param `$data_mode`  data mode for active and inactive child elements
         * @param `$data_parent` used for id of parent element 
        */

        public static function option_form_fieldset_start($id, $type, $data_mode, $data_parent){
            return '<fieldset id="sapid_options-'.$id.'" class="sapid_theme_options-'.$id.' sapid-field-container sapid-field sapid-container-'.$type.'" data-id="'.$id.'" data-type="'.$type.'" data-mode="'.$data_mode.'" data-parent="'.$data_parent.'">';
        }

        /**
         * option form fieldset end
        */ 

        public static function option_form_fieldset_end(){
            return '</fieldset>';
        }
          
        /**
        * option form after
        */

        public static function option_form_after(){
            return '</td></tr>';
        }

        /**
         * option form field  radio buttonset
         * @param  `$id`  for  form id
         * @param `$choices` for multiple choice of select input type
         * @param `$default` for default value of select input type
         * @param `$data_parent` used for id of parent element 
         * @param `$data_mode` for data mode 
         * @param `$label` form select input type label 
        */

        public static function option_form_field_radio_buttonset($id, $default, $choices, $data_mode, $data_parent, $options, $label, $type){
            $html ='<div class="radio-toolbar">';
            foreach($choices as $val =>  $choice) { 
                $checked="";
                $class ='';
                if($val == $default){
                    $checked="checked";
                    $class = ' ui-checkboxradio-checked ui-state-active';
                }
                $html .= '<input data-id="'.$id.'" type="radio" id="'.$id.'-buttonset'.$choice.'" class="buttonset-item sapid_options" value="'.$val.'" type="radio" name="sapid_options['.$id.']" '.$checked.'><label for="'.$id.'-buttonset'.$choice.'">'.$choice.'</label>';                                                   
            }
            $html .= '</div>';                                                                
            return $html;
        }

        /**
         * option form field  switch
         * @param  `$id`  for  form id
         * @param `$choices` for multiple choice of radio input type
         * @param `$default` for default value of radio input type
         */

        public static function option_form_field_switch($id, $default, $choices, $data_mode, $data_parent, $options, $label, $type  ){
            
            $cb_enabled = $cb_disabled = ''; //no errors, please
            //Get selected
            if ( (int) $default == 1 ) {
                $cb_enabled = 'checked';
            } else {
                $cb_disabled = 'checked';
            }                                                     
            //Label ON
            $choices['on'] = isset( $choices['on'] ) ? $choices['on'] : __( 'On', 'Sapid' );                                   //Label OFF
            $choices['off'] = isset( $choices['off'] ) ? $choices['off'] : __( 'Off', 'Sapid' );                  

            
            $html = '<div class="radio-toolbar"><input data-id="'.$id.'" type="radio" id="'.$id.'-buttonseton" class="buttonset-item sapid_options" value="1" type="radio" name="sapid_options['.$id.']" '.$cb_enabled.' ><label class="cb-enable" for="'.$id.'-buttonsetboxed">'.$choices['on'].'</label>';
            
            $html .= '<input data-id="'.$id.'" type="radio" id="'.$id.'-buttonsetoff" class="buttonset-item sapid_options" value="0" type="radio" name="sapid_options['.$id.']" '.$cb_disabled.'><label class="cb-disable" for="'.$id.'-buttonsetboxed">'.$choices['off'].'</label>';
            
            $html .= '</div>';
            
            return $html;
        }

        /**
         * option form field  info
         * @param  `$id`  for  form id
         * @param `$label` for  label of input field.
         * @param `$type`  for type of field. 
         */
        
        public static function option_form_field_info($id, $default, $choices, $data_mode, $data_parent, $options, $label, $type){
            
            $html = '</tbody></table><div id="'.$type.'-'.$id.'" class="sapid-normal  sapid_options sapid-notice-field sapid-field-info"><p class="sapid-info-desc"><b>'.$label.'</b><br></p></div><table class="form-table no-border" style="margin-top: 0;"><tbody>';
            
            return $html;
        }


         /**
         * option form field  info
         * @param  `$id`  for  form id 
         * @param `$choices` for select sub options values.
         * @param `$default`  for default value of field. 
         * @param `$multi`  for store multiple select true or false. 
         */
    
        public static function option_form_field_select($id, $default, $choices, $data_mode, $data_parent, $options, $label, $type, $content, $description, $multi){
            $class ='';
            $multiselct ="";
            $name = 'sapid_options['.$id.']';
            if($multi == true){
                $class =' chosen-select';  
                $multiselct ="multiple";
                $name = 'sapid_options['.$id.'][]';
            }
                        
            $html = '<select name="'.$name.'" id="boxed_modal_shadow-select" data-placeholder="Select an item" class="regular-text sapid_options dimension '.$class.'" style="width:100%; border:1px solid #dfdfdf;" '.$multiselct.'>';
            
            foreach($choices as $ckey => $choice) {
                $selected ='';
                if(is_array($default)){
                    if(in_array($ckey, $default)){
                        $selected =' selected';
                    }
                }else{
                    if($default == $ckey){
                        $selected =' selected';
                    }
                }
                $html .= '<option value="'.$ckey.'" '.$selected.'>'.$choice.'</option>';                                                    
            }
                                                                               
            $html .= '</select>';
            return $html;                                                       
        }

        
         /**
         *  form  text field  
         * @param  `$id`  for  form id 
         * @param `$default`  for default value of  text field. 
         */

        public static function option_form_field_text($id, $default, $choices, $data_mode, $data_parent, $options, $label, $type){
            $html = '<input type="text" id="'.$id.'" name="sapid_options['.$id.']" value="'.$default.'" class="regular-text sapid_options">';
            
            return $html; 
        }

        /**
         *  form  textarea  field  
         * @param  `$id`  for  form  field id 
         * @param `$default`  for default value of  textarea field. 
         */
        
        public static function option_form_field_textarea($id, $default, $choices, $data_mode, $data_parent, $options, $label, $type){
            $html = '<textarea id="'.$id.'" class="regular-textarea sapid_options" rows="6" cols="50" name="sapid_options['.$id.']">'.$default.'</textarea>';   
            return $html; 
        }

         /**
         *  slider  
         * @param  `$id`  for   id 
         * @param `$default`  for default value of  slider field. 
         */
    
        public static function option_form_field_slider($id, $default, $choices, $data_mode, $data_parent, $options, $label, $type){
            $html = '<input type="text" id="'.$id.'" name="sapid_options['.$id.']" value="'.$default.'" class="sapid-slider-input sapid-slider-input-one-grid_main_break_point sapid_options"><div id="'.$id.'_slider"></div>'; 
            return $html;
        }

        /**
         *  form  custom field 
         * @param `$description`  description of a field . 
         */

        public static function option_form_field_custom( $id, $default, $choices, $data_mode, $data_parent, $options, $label, $type, $content, $description){
            $html ='<div class="sapid_field_th" style="padding: 0px 0px 10px;"><span class="description">'.$description.'</span></div>';
            return $html;
        }

        /**
        *  form  field media  
        * @param `$id`  for form  field id . 
        * @param `$option`  for options. 
         */

        public static function option_form_field_media($id, $default, $choices, $data_mode, $data_parent, $options, $label, $type, $content ){
            
            $html = '';
            
            if(!empty($options[$id])){  
                $html .= '<img src="'.$options[$id].'" class="sapid-option-image sapid-upload-'.$id.'" />';    
                $html .= '<div class="upload_button_div"><a class="media_upload_button button upload-input" title="' . esc_attr__( 'Upload', 'Sapid' ) . '" href="javascript:void(0);" data-id="'.$id.'" id="upload_'.$id.'_image_button" data-uploader_title="' . $label . '" data-uploader_button_text="'. esc_attr__( 'Upload', 'Sapid' ) . '">' . esc_html__( 'Upload', 'Sapid' ) . '</a><a href="javascript:void(0);" data-id="'.$id.'" id="remove_'.$id.'_image_button" class="remove-upload-img button remove-input">Remove</a></div>';
                $html .= '<input type="hidden" id="upload_'.$id.'_image" name="sapid_options['.$id.']" value="'.$options[$id].'" />';   
            } else {
                $defaultImg =  self::$template_dir_url .$default;
                $html .= '<img src="'.$defaultImg.'" class="sapid-option-image sapid-upload-'.$id.'" style="display:none;" />';    
                $html .= '<div class="upload_button_div"><a class="media_upload_button button upload-input" title="' . esc_attr__( 'Upload', 'Sapid' ) . '" href="javascript:void(0);" data-id="'.$id.'" id="upload_'.$id.'_image_button" data-uploader_title="' . $label . '" data-uploader_button_text="'. esc_attr__( 'Upload', 'Sapid' ) . '">' . esc_html__( 'Upload', 'Sapid' ) . '</a><a href="javascript:void(0);" data-id="'.$id.'" id="remove_'.$id.'_image_button" class="remove-upload-img button remove-input hide">Remove</a></div>';   
                $html .= '<input type="hidden" id="upload_'.$id.'_image" name="sapid_options['.$id.']" value="" />';    
            }     
            return $html;    
        }
         
        /**
        *   form field repeater.  
        * @param `$id`  for form  field id . 
        * @param `$default` default value of a field .
        * @param `$fields` for field type id, description, select, text, textarea, upload.
         */ 

        public static function option_form_field_repeater( $id, $default, $choices, $data_mode, $data_parent, $options, $label, $type, $content, $description, $multi, $fields){
            $html ='<div class="main-social-body-'.$id.'">';
            if(isset($default) && !empty($default)){
                $i = 0;
                foreach ($default as $key => $value) {
                    $valueName = !empty($value['name']) ? $value['name']:'';
                    $html.='<div class="card social-card" data-field="'.$id.'"><div class="card-header social-header"><span class="pull-left clickable close-icon ui-icon-plus"></span><span class="sapid-repeater-header">'.ucfirst($valueName).'</span></div>';

                    $html.='<div id="'.$i.'_social_body" class="social-body card-body">';

                        if(isset($fields) && !empty($fields)){
                            foreach($fields as $field){
                                if ( ! isset( $field['id'] ) ) {
                                    continue;
                                }
                                $fieldId = $field['id'];
                                $defaultValues = !empty($value[$fieldId]) ? $value[$fieldId]:'';
                                $className = isset($field['class']) ? $field['class']:'';
                                if(!empty($field['label'])){
                                    $html.='<h4>'.$field['label'].'</h4>';
                                }
                                if(!empty($field['description'])){
                                    $html.='<span class="description">'.$field['description'].'</span>';
                                }

                                if($field['type'] == 'select'){
                                    $html.='<select data-placeholder="Choose" class="'.$className.'" name="sapid_options['.$id.']['.$i.']['.$fieldId.']">';
                                        $html.='<option value=""></option>';
                                        foreach ($field['choices'] as $key_s => $defaults_social) {
                                            $selected = ($key_s == $defaultValues) ? "selected" : "";
                                            $html.='<option value="'.$key_s.'" '.$selected.'>'.$defaults_social['label'].'</option>';
                                        }
                                    $html.='</select>';
                                }

                                if($field['type'] == 'text'){
                                    $html.='<input type="text" class="'.$className.'" value="'.$defaultValues.'" name="sapid_options['.$id.']['.$i.']['.$fieldId.']">';
                                }

                                if($field['type'] == 'textarea'){
                                    $html.='<textarea class="'.$className.'" name="sapid_options['.$id.']['.$i.']['.$fieldId.']">'.$defaultValues.'</textarea>';
                                }

                                if($field['type'] == 'upload'){
                                    $html.='<input type="text" class="'.$className.'" name="sapid_options['.$id.']['.$i.']['.$fieldId.']" readonly><div class="upload_button_div"><span class="button media_upload_button" id="'.$fieldId.'-'.$i.'-media">Upload</span><span class="button remove-image hide" id="reset_'.$fieldId.'-'.$i.'" rel="'.$fieldId.'-'.$i.'">Remove</span></div>';
                                }
                            }
                        }

                    $html.='<a href="javascript:void(0);" class="button deletion sapidredux-repeaters-remove">Delete </a></div></div>';
                    $i++;
                }
            }
            $html.='</div><a data-name="'.$id.'" href="javascript:void(0);" class="button sapid-repeaters-add button-primary">Add </a>';
            $repeatorHtml ='';
            if(isset($fields) && !empty($fields)){
                foreach($fields as $field){
                    if ( ! isset( $field['id'] ) ) {
                        continue;
                    }
                    $fieldId = $field['id'];
                    $defaultValues = '';
                    $className = isset($field['class']) ? $field['class']:'';
                    $className = str_replace("chosen-select","ch-chosen-select",$className);
                    if(!empty($field['label'])){
                        $repeatorHtml.='<h4>'.$field['label'].'</h4>';
                    }
                    if(!empty($field['description'])){
                        $repeatorHtml.='<span class="description">'.$field['description'].'</span>';
                    }

                    if($field['type'] == 'select'){
                        $repeatorHtml.='<select data-name="'.$fieldId.'" data-placeholder="Choose" class="'.$className.'" name="'.$fieldId.'">';
                            $repeatorHtml.='<option value=""></option>';
                            foreach ($field['choices'] as $key_s => $defaults_social) {
                                $selected = "";
                                $repeatorHtml.='<option value="'.$key_s.'" '.$selected.'>'.$defaults_social['label'].'</option>';
                            }
                        $repeatorHtml.='</select>';
                    }

                    if($field['type'] == 'text'){
                        $repeatorHtml.='<input data-name="'.$fieldId.'" type="text" class="'.$className.'" value="'.$defaultValues.'" name="'.$fieldId.'">';
                    }

                    if($field['type'] == 'textarea'){
                        $repeatorHtml.='<textarea data-name="'.$fieldId.'" class="'.$className.'" name="'.$fieldId.'">'.$defaultValues.'</textarea>';
                    }

                    if($field['type'] == 'upload'){
                        $repeatorHtml.='<input data-name="'.$fieldId.'" type="text" class="'.$className.'" name="'.$fieldId.'" readonly>';
                    }
                }
            }

            $html.='<div class="clone_repeator clone_repeator-'.$id.'"><div class="card social-card" data-field="field"><div class="card-header social-header"><span class="pull-left clickable close-icon ui-icon-plus"></span><span class="sapid-repeater-header">Custom</span></div><div id="custom_social_body" class="social-body card-body">'.$repeatorHtml.'
            <a href="javascript:void(0);" class="button deletion sapidredux-repeaters-remove">Delete </a></div></div></div>';
            return $html;
        }
        

        public static function option_form_field_import( $id, $default, $choices, $data_mode, $data_parent, $options, $label, $type, $content, $description){
            $html ='<div class="sapid_field_th" style="padding: 0px 0px 10px;">'.$label.'<span class="description">'.$description.'</span></div><button type="button" id="sapid-import-data" class="button sapid-primary-button">Import Theme Data</button><span class="description alert-text">WARNING! This will overwrite all existing option values, please proceed with caution!</span></p>';
            return $html;
        }
 
        public static function option_form_field_export( $id, $default, $choices, $data_mode, $data_parent, $options, $label, $type, $content, $description){
            $secret_key = md5( md5( AUTH_KEY . SECURE_AUTH_KEY ) . '-sapid_options');
            $theme_setting_export_link = esc_url( admin_url( 'admin-ajax.php?action=sapid_theme_setting_export_download&secret_key=' . $secret_key) );
            $html ='<div class="sapid_field_th" style="padding: 0px 0px 10px;">'.$label.'<span class="description">'.$description.'</span></div><a href="javascript:void(0);" id="sapid-export-copy-data" class="button-secondary sapid-secondary-button">Copy Data</a><a href="'.$theme_setting_export_link.'" id="sapid-export-download-data" class="button-secondary sapid-secondary-button">Download Data File</a><textarea class="sapid-textarea" id="sapid-export-code-field" rows="2" style="display: none;"></textarea>';
            return $html;
        } 
                                                  
    }
    
}
new Sapid_Theme_Options();

// Helper function to use in your theme to return a theme option value
function sapid_get_theme_option( $id = '' ) {
    return Sapid_Theme_Options::get_theme_option( $id );
}