<?php
/**
 * The template part for displaying a message that posts, portfolio cannot be found
 * @package sapid
 */

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}

$related_posts_columns   = (int) sapid_get_theme_option( 'related-posts-columns' );  // related post columns  
$related_posts_columns = ( ! $related_posts_columns ) ? 1 : $related_posts_columns; 
$related_posts_image_size   = sapid_get_theme_option( 'related-posts-image-size' ); // image size of related post
$column_width          = ( 5 === $related_posts_columns ) ? 2 : 12 / $related_posts_columns; // devide width column according to related columns
$css_class =  'item';
$date_format = sapid_get_theme_option( 'date-format' ); // date format of post
$date_format = $date_format ? $date_format : get_option( 'date-format' ); 
$data_image_size     = ( 'cropped' === $related_posts_image_size) ? 'sapid-recent-posts' : 'full'; // crop image size
?>

<div class="owl-carousel owl-theme related-posts">
	<?php
	while ( $related_posts->have_posts() ) :
	    $related_posts->the_post();  
	 	$post_id = get_the_ID(); 
		if($post->post_type == 'sapid-portfolio'){
			$categories = wp_get_object_terms( $post_id, 'sapid-portfolio-categories', array( 'fields' => 'all' ) );
		}else {
			$categories = get_the_category( $post_id );
		}
		$types ='';
		if(!empty($categories) && count($categories) > 0){
		    foreach($categories as $category) {
		        $types .= ucfirst($category->name).', ';
		    }
		    $types = rtrim($types, ', ');
		}

	 	?>
    	<div class="<?php echo esc_attr( $css_class ); ?>">
    		<div class="card">
            	<?php
			    sapid_post_thumbnail($data_image_size);
				?>
				<div class="card-body sapid-meta">
			    <?php the_title(sprintf('<h4 class="sapid-carousel-title related-post-title target="_self""><a href="%s" rel="bookmark">', esc_url(get_permalink())), '</a></h4>');?>
					<small class="text-muted fw-light"><?php echo esc_attr($types ); ?></small>
				</div><!-- sapid-carousel-meta -->
			</div>
		</div>
	<?php endwhile; ?>
	<?php wp_reset_postdata(); ?>
</div>