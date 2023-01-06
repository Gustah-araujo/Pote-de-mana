<?php
/**
 * Template used for single content page
 * that have a specific single template.
 *
 * @package Sapid
 * @subpackage Templates
 */

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}

$categories = get_the_category( $post->ID );
$types ='';
if(!empty($categories) && count($categories) > 0){
    foreach($categories as $category) {
        $types .= ucfirst($category->name).', ';
    }
    $types = rtrim($types, ', ');
}

$blog_post_tags = get_the_tags(); // get blog tags
$tag =[];
$post_tags='';
if ( !empty($blog_post_tags)) { // check array is empty or not
	foreach($blog_post_tags as $single_tag){
		$tag[] = $single_tag->name;  
	}
	$post_tags = implode(',',$tag);  // store comma seprate post tags
}

?>
<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <div class="sapid-post-content post-content">
        <?php 
        if (is_single()) {
            the_title('<h1 class="entry-title sapid-post-title">', '</h1>');
			if(!empty(sapid_get_theme_option('single-result-meta'))){ ?>
				<div class="sapid-entry-meta float-left">
					<ul class="p-0">
						<li><i class="mdi mdi-calendar-month"></i> <?php the_date(); ?></li>
						<li><i class="mdi mdi-account"></i> <?php echo get_the_author(); ?></li>
						<?php echo !empty($types) ? '<li><i class="mdi mdi-folder"></i>'.$types.'</li>':''; ?>
						<?php echo !empty($post_tags) ? '<li><i class="mdi mdi-folder"></i>'.$post_tags.'</li>':''; ?>
					</ul>
				</div>
			<?php } 
        } else {
            the_title(sprintf('<h2 class="entry-title sapid-post-title"><a href="%s" rel="bookmark">', esc_url(get_permalink())), '</a></h2>');
        }

		if (is_single()) {
			sapid_post_thumbnail('full'); 
		}else{
			sapid_post_thumbnail('thumbnail');
		}
	?>
        <div class="sapid-post-content-container entry-content mt-3">
            <?php
		if (is_single()) {
			the_content();
		} else {
            the_excerpt();
        }

		wp_link_pages(
			array(
				'before'      => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'Sapid' ) . '</span>',
				'after'       => '</div>',
				'link_before' => '<span>',
				'link_after'  => '</span>',
				'pagelink'    => '<span class="screen-reader-text">' . __( 'Page', 'Sapid' ) . ' </span>%',
				'separator'   => '<span class="screen-reader-text">, </span>',
			)
		);
		?>
        </div><!-- .entry-content -->
        <?php sapid_social_sharing(); ?>
		<!-- Comment Section -->
		<?php
		if (comments_open()) :
			echo '<section class="comments bg-white mt-0 pt-3 pb-5">
						<div class="row justify-content-center">';
							comments_template();
			echo'</div></section>';

		endif;
		?>
		<!-- Pagination -->
		<?php
		if(!empty(sapid_get_theme_option('blog-pn-nav'))){
			echo '<div class="pagination-previous float-start">';
				previous_post_link('%link', 'Previous');
			echo '</div>';

			echo '<div class="pagination-next float-end">';
				next_post_link('%link', 'Next' );
			echo '</div>';
		}
			edit_post_link(
				sprintf(
					/* translators: %s: Post title. Only visible to screen readers. */
					__( 'Edit<span class="screen-reader-text"> "%s"</span>', 'Sapid' ),
					get_the_title()
				),
				'<footer class="entry-footer"><span class="edit-link">',
				'</span></footer><!-- .entry-footer -->'
			);
		?>
    </div>
</div>