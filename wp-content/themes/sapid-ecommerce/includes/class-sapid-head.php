<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Sapid_Head' ) ) :

	/**
	 * The main Sapid_Head class
	 */
	class Sapid_Head {

		/**
		 * Setup class.
		 *
		 * @since 1.0
		 */
		public function __construct() {
			add_action( 'wp_head', [ $this, 'insert_favicons' ], 2 );
			add_action( 'admin_head', [ $this, 'insert_favicons' ], 2 );
			add_action( 'wp_head', [ $this, 'insert_og_meta' ], 5 );
			add_action( 'wp_head', [ $this, 'set_user_agent' ], 1000 );
			add_action( 'wp_head', [ $this, 'add_analytics_code' ], 1000 );
			add_action( 'wp_head', [ $this, 'add_sapid_custom_css' ] , 1000);
		}

		/**
		 * Sapid favicon as set in global options.
		 * These are added to the <head> of the page using the 'wp_head' action.
		 *
		 * @access  public
		 * @since   1.0
		 * @return  void
		 */
		public function insert_favicons() {
			?>
			<?php if ( '' !== sapid_get_theme_option( 'fav-icon') ) : ?>
				<link rel="shortcut icon" href="<?php echo esc_url( sapid_get_theme_option( 'fav-icon') ); ?>" type="image/x-icon" />
			<?php endif; ?>
			<?php
		}

		/**
		 * Sapid extra OpenGraph tags
		 * These are added to the <head> of the page using the 'wp_head' action.
		 *
		 * @access  public
		 * @return void
		 */
		public function insert_og_meta() {

			$is_show_og_tags = sapid_get_theme_option('status-opengraph');
			
			// Early exit if this is not a singular post/page/cpt.
			if ( ! is_singular() || empty($is_show_og_tags) ) {
				return;
			}
			
			
			global $post;

			$settings = sapid_get_theme_option( 'logo' );

			$image = '';
			if ( ! has_post_thumbnail( $post->ID ) ) {
				if ( isset( $settings ) && !empty($settings) ) {
					$image = $settings;
				}
			} else {
				$thumbnail_src = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' );
				$image         = esc_attr( $thumbnail_src[0] );
			}

			if ( is_array( $image ) ) {
				$image = ( isset( $image['url'] ) && ! empty( $image['url'] ) ) ? $image['url'] : '';
			}
			?>

			<meta property="og:title" content="<?php echo esc_attr( strip_tags( str_replace( [ '"', "'" ], [ '&quot;', '&#39;' ], $post->post_title ) ) ); // phpcs:ignore WordPress.WP.AlternativeFunctions.strip_tags_strip_tags ?>"/>
			<meta property="og:type" content="article"/>
			<meta property="og:url" content="<?php echo esc_url_raw( get_permalink() ); ?>"/>
			<meta property="og:site_name" content="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>"/>
			<meta property="og:description" content="<?php echo !empty($post->post_content) ? esc_attr(substr($post->post_content, 0, 100)): get_bloginfo( 'name' ); ?>"/>

			<?php if ( '' != $image ) : // phpcs:ignore WordPress.PHP.StrictComparisons.LooseComparison ?>
				<?php if ( is_array( $image ) ) : ?>
					<?php if ( isset( $image['url'] ) ) : ?>
						<meta property="og:image" content="<?php echo esc_url_raw( $image['url'] ); ?>"/>
					<?php endif; ?>
				<?php else : ?>
					<meta property="og:image" content="<?php echo esc_url_raw( $image ); ?>"/>
				<?php endif; ?>
			<?php endif; ?>
			<?php

		}

		/**
		 * Set the user agent data attribute on the HTML tag.
		 *
		 * @access public
		 * @since 1.0
		 * @return void
		 */
		public function set_user_agent() {
			?>
			<script type="text/javascript">
				var doc = document.documentElement;
				doc.setAttribute( 'data-useragent', navigator.userAgent );
			</script>
			<?php
		}


		/**
		 * Adds analytics code.
		 *
		 * @access public
		 * @since 1.0
		 * @return void
		 */
		public function add_analytics_code() {
			/**
			 * The setting below is not sanitized. In order to be able to take advantage of this,
			 * a user would have to gain access to the database or the filesystem to add a new filter,
			 * in which case this is the least of your worries.
			 */
			echo apply_filters( 'sapid_google_analytics', sapid_get_theme_option( 'google-analytics' ) );
		}

	    public function add_sapid_custom_css(){
	        $css = sapid_get_theme_option( 'custom-css' );
	        if(!empty($css)){
				echo '<style id="sapid-styles-custom-css" type="text/css">'.$css.'</style>';
	        }
	    }

	}
endif;

return new Sapid_Head();
