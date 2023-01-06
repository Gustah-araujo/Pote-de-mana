<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Sapid' ) ) :

	/**
	 * The main Sapid class
	 */
	class Sapid {

		/**
		 * Setup class.
		 *
		 * @since 1.0
		 */
		public function __construct() {
			add_action( 'after_setup_theme', array( $this, 'setup' ) );
			add_action( 'wp_enqueue_scripts', array( $this,'sapid_theme_scripts') );
			add_filter( 'excerpt_length', array( $this,'sapid_excerpt_length') );
			add_filter(	'excerpt_more', array( $this,'sapid_excerpt_more'));
			add_filter( 'pre_get_posts', array( $this, 'sapid_edit_search_filter') );
			add_filter( 'posts_search', array( $this, 'sapid_search_by_title_only'), 500, 2 );	
			// ajax search.
			add_action( 'wp_ajax_sapid_live_search_posts', [ $this, 'sapid_live_search_posts' ] );
			add_action( 'wp_ajax_nopriv_sapid_live_search_posts', [ $this, 'sapid_live_search_posts' ] );
			// download theme setting option
			add_action( 'wp_ajax_sapid_theme_setting_export_download', [ $this, 'sapid_theme_setting_export_download' ] );
			add_action( 'wp_ajax_nopriv_sapid_theme_setting_export_download', [ $this, 'sapid_theme_setting_export_download' ] );
			// import theme setting option
			add_action( 'wp_ajax_sapid_theme_setting_import', [ $this, 'sapid_theme_setting_import' ] );
			add_action( 'wp_ajax_nopriv_sapid_theme_setting_import', [ $this, 'sapid_theme_setting_import' ] );
			add_action( 'wp_footer', array( $this, 'add_wp_footer_scripts' ), 99 );
			remove_action( 'set_comment_cookies', 'wp_set_comment_cookies', 5 );
		}

		/**
		 * Sets up theme defaults and registers support for various WordPress features.
		 *
		 * Note that this function is hooked into the after_setup_theme hook, which
		 * runs before the init hook. The init hook is too late for some features, such
		 * as indicating support for post thumbnails.
		 */
		public function setup() {

			/**
			 * Add language pot file in Sapid.
			 */

			load_theme_textdomain( 'Sapid', get_template_directory() . '/languages' );
			
			/**	
			 * Add default posts and comments RSS feed links to head.
			 */
			add_theme_support( 'automatic-feed-links' );
			/*
			 * Let WordPress manage the document title.
			 * By adding theme support, we declare that this theme does not use a
			 * hard-coded <title> tag in the document head, and expect WordPress to
			 * provide it for us.
			 */
			add_theme_support( 'title-tag' );

			// Default custom header.
			add_theme_support( 'custom-header' );

			// Default custom backgrounds.
			add_theme_support( 'custom-background' );
			
			/*
			 * Enable support for Post Thumbnails on posts and pages.
			 *
			 * @link https://developer.wordpress.org/reference/functions/add_theme_support/#Post_Thumbnails
			 */
			add_theme_support( 'post-thumbnails' );
			set_post_thumbnail_size( 1000, 565, true );

		    //WooCommerce Support.
		    add_theme_support( 'woocommerce');
			add_theme_support( 'wc-product-gallery-zoom' );
			add_theme_support( 'wc-product-gallery-slider' );
			add_theme_support( 'wc-product-gallery-lightbox' );

			/**
			 * Register menu locations.
			 */
			register_nav_menus(
				apply_filters(
					'sapid_register_nav_menus', array(
						'primary-menu' => __( 'Primary Menu' ),
						'top-menu' => _( 'Top Menu' )
					)
				)
			);
			/*
			 * Switch default core markup for search form, comment form, comments, galleries, captions and widgets
			 * to output valid HTML5.
			 */
			add_theme_support(
				'html5', apply_filters(
					'sapid_html5_args', array(
						'search-form',
						'comment-list',
						'gallery',
						'caption',
						'widgets',
					)
				)
			);
		}

		/**
		 * Enqueue scripts and styles.
		 *
		 * @since  1.0.0
		 */
		public function sapid_theme_scripts() {
		    wp_enqueue_style( 'sapid-bootstrap-style', get_template_directory_uri() . '/assets/css/bootstrap.min.css');
		    wp_enqueue_style( 'sapid-css-style', get_template_directory_uri() . '/assets/css/styles.css');
		    wp_enqueue_style( 'sapid-d-style', get_template_directory_uri() . '/assets/css/materialdesignicons.min.css');
		    wp_enqueue_style( 'sapid-style', get_template_directory_uri() . '/style.css');

		    wp_enqueue_script( 'sapid-jquery', get_template_directory_uri() . '/assets/js/jquery.js', '', '1.0', true);
		    wp_enqueue_script( 'sapid-popper-script', get_template_directory_uri() . '/assets/js/popper.min.js', '', '1.0', true);
		    wp_enqueue_script( 'sapid-bootstrap-script', get_template_directory_uri() . '/assets/js/bootstrap.min.js', '', '1.0', true);
		    wp_enqueue_script( 'sapid-bootstrap-bundle-script', get_template_directory_uri() . '/assets/js/bootstrap.bundle.min.js', '', '1.0', true);
		    wp_enqueue_script( 'sapid-script', get_template_directory_uri() . '/assets/js/script.js', '', '1.0', true);

		    wp_localize_script( 'sapid-script', 'frontend_header_object',
		        array( 
		            'ajaxurl' => admin_url( 'admin-ajax.php' ),
		            'header_sticky' => sapid_get_theme_option( 'header-sticky' ),
		        )
		    );

		    wp_localize_script( 'sapid-script', 'live_search_object',
		        array( 
		            'live_search_min_char_count' => sapid_get_theme_option( 'live-search-min-char-count' ),
		        )
		    );
		}

		/**
		 * Add scripts to the wp_footer action hook.
		 *
		 * @since 1.0
		 * @access public
		 * @return void.
		 */
		public function add_wp_footer_scripts() {
			/**
			 * Echo the scripts added to the "before </body>" field in Global Options.
			 * The 'space_body' setting is not sanitized.
			 * In order to be able to take advantage of this,
			 * a user would have to gain access to the database
			 * in which case this is the least of your worries.
			 */
			echo sapid_get_theme_option( 'space-body' ); 
		}

		/**
		 * edits the search filter.
		 *
		 * @access public
		 * @param object $query The search query.
		 * @return object $query The edits search query.
		 */
		public function sapid_edit_search_filter( $query ) {
			if (! is_admin() && is_search() && $query->is_search && ! empty( $query->query['s'] ) ) {
				if ( isset( $_GET ) && ( 2 < count( $_GET ) ) ) { 
					return $query;
				}

				$query->set( 'post_type', $this->get_sapid_search_post_types() );
			}
			return $query;
		}

		/**
		 * Gets the post types for search results filtering.
		 */
		public function get_sapid_search_post_types() {
			$search_post_type = sapid_get_theme_option( 'search-post-type' );
			return apply_filters( 'sapid_search_post_types', $search_post_type );
		}

		/**
		 * excerpt length
		 */
		public function sapid_excerpt_length($length) {
		   	global $post;
		    return sapid_get_theme_option( 'excerpt-length' );
		}

		/**
		 * excerpt more
		 */
		public function sapid_excerpt_more($more) {
		   global $post;
			$read_more_text = 'Read More';
			$excerpt_more = ' <a class="text-dblue-sub f-w" href="' . get_permalink( get_the_ID() ) . '">"' . $read_more_text . '"</a>';
			return $excerpt_more;
		}

		/**
		 * serch page
		 * @return Search results.
		 */
		public function sapid_live_search_posts(){
			$post_types = $this->get_sapid_search_post_types();
			$args = array(
				's'                   => trim( strip_tags( $_POST['search'] ) ), 
				'post_type'           => $post_types,
				'posts_per_page'      => !empty(sapid_get_theme_option('live-search-results-per-page')) ? sapid_get_theme_option('live-search-results-per-page'):10, 
				'post_status'         => 'publish',
			);
			$args = apply_filters( 'sapid_live_search_query_args', $args );
			$search_limit_to_post_titles = sapid_get_theme_option( 'search-limit-to-post-titles' );
			if ( $search_limit_to_post_titles ) {
				add_filter( 'posts_where', array( $this, 'sapid_search_by_title_only' ), 10, 2 );
				$search_results = new WP_Query( $args );
				remove_filter('posts_where', array( $this, 'sapid_search_by_title_only' ), 10, 2 );
			} else {
				$search_results = new WP_Query( $args );
			}

			$ajax_search_results = [];
			$html ='';
			if ( $search_results->have_posts() ) {
				while ( $search_results->have_posts() ) {
					$search_results->the_post();
					global $post;
					$image_url = get_the_post_thumbnail_url( $post->ID, 'thumbnail' );
					$image_url = !empty($image_url) ? $image_url:get_template_directory_uri().'/assets/images/thumb.png';
					if($post->post_type != 'revision'){
						$imgUrl = '<div class="sapid-search-image"><img  src="'.$image_url.'" alt="'.$post->post_title.'"></div>';									
						$html .='<a class="sapid-search-result" href="'.get_the_permalink( $post->ID ).'" title="'.$post->post_title.'">'.$imgUrl.'<div class="sapid-search-content"><div class="sapid-search-post-title">'.$post->post_title.'</div></div></a>';
					}
				}
			}else{
				$html .='<a class="sapid-search-result">No search data match your query. Please try again</a>';
			}
			wp_reset_postdata();
			$ajax_search_results = ['html' => $html, 'success' => 1];
			wp_send_json( $ajax_search_results );
		}

		/**
		 * serch by title 
		 * `$seach` for search query 
		 * `$wp_query`  for query varibles.
		 * @return search query
		 */
		public function sapid_search_by_title_only( $search, $wp_query ){
		    global $wpdb;
		 	$search_limit_to_post_titles = sapid_get_theme_option( 'search-limit-to-post-titles' );
			$search_post_type = sapid_get_theme_option( 'search-post-type' );
		    if ( empty( $search ) || ! $search_limit_to_post_titles)
		        return $search; // skip processing - no search term in query
		 
		    $q = $wp_query->query_vars;    
		    $n = ! empty( $q['exact'] ) ? '' : '%';
		    $search =
		    $searchand = '';
		 
		    foreach ( (array) $q['search_terms'] as $term ) {
		    	//Function like_escape is deprecated since version 4.0.0! Use wpdb::esc_like()
		        //$term = esc_sql( like_escape( $term ) );
		        $term      = esc_sql( $wpdb->esc_like( $term ) );
		        $search .= "{$searchand}($wpdb->posts.post_title LIKE '{$n}{$term}{$n}') AND ($wpdb->posts.post_type IN ('".$search_post_type."'))";
		        $searchand = ' AND ';
		    }
		 
		    if ( ! empty( $search ) ) {
		        $search = " AND ({$search}) ";
		        if ( ! is_user_logged_in() ){
		            $search .= " AND ($wpdb->posts.post_password = '') ";
		        }
		    }
		    return $search;
		}

		public function sapid_theme_setting_export_download(){
			if ( ! isset( $_GET['secret_key'] ) || $_GET['secret_key'] != md5( md5( AUTH_KEY . SECURE_AUTH_KEY ) . '-sapid_options' ) ) {
				wp_die( 'Invalid Secret Key for options use' );
				exit;
			}

			/**
			 * export data
			 * echo $export_data of theme options.
			 */
			$export_data   = Sapid_Theme_Options::get_theme_options();
			$export_data['sapid-backup'] = '1';
			header( 'Content-Description: File Transfer' );
			header( 'Content-type: application/txt' );
			header( 'Content-Disposition: attachment; filename="sapid_options_backup_' . date( 'd-m-Y' ) . '.json"' );
			header( 'Content-Transfer-Encoding: binary' );
			header( 'Expires: 0' );
			header( 'Cache-Control: must-revalidate' );
			header( 'Pragma: public' );
			echo wp_json_encode($export_data, JSON_UNESCAPED_SLASHES);
			exit;
		}
		
		public function sapid_theme_setting_import(){
			if ( ! wp_verify_nonce( $_POST['nonce'], 'sapid_nonce' ) ) {
				wp_die( 'Invalid Secret nonce for options use' );
				exit;
			}
			import_demo_theme_setting();
			$homePage = get_page_by_title( 'Home' );
			if(!empty($homePage)){
				update_option( 'page_on_front', $homePage->ID);
				update_option( 'show_on_front', 'page');
			}

			$blogPage = get_page_by_title( 'Blog' );
			if(!empty($blogPage)){
				update_option( 'page_for_posts', $blogPage->ID);
			}

			$menu = get_term_by('name', 'Main Menu', 'nav_menu');
			if(!empty($menu)){
				$locations['primary-menu'] = $menu->term_id;
				set_theme_mod( 'nav_menu_locations', $locations );
			}
			
			update_option( 'theme_settings_import', 1);
			echo wp_json_encode( ['status' => 1, 'message'=> 'Your theme data has been successfully imported']); exit;
		}
		
	}
endif;

return new Sapid();
