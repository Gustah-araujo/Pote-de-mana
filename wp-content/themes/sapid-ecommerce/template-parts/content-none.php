<?php
/**
 * The template part for displaying a message that posts cannot be found
 * @package sapid
 */
?>

<div class="no-results not-found">
	<h1 class="page-title"><?php _e( 'Nothing Found', 'Sapid' ); ?></h1>
	<div class="sapid-post-content post-content">
		<?php if ( is_home() && current_user_can( 'publish_posts' ) ) : ?>
			<p>
			<?php
			/* translators: %s: Post editor URL. */
			printf( __( 'Ready to publish your first post? <a href="%1$s">Get started here</a>.', 'Sapid' ), esc_url( admin_url( 'post-new.php' ) ) );
			?>
			</p>
		<?php elseif ( is_search() ) : ?>
			<p><?php _e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'Sapid' ); ?></p>
			<?php get_search_form(); ?>
		<?php else : ?>
			<p><?php _e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'Sapid' ); ?></p>
			<?php get_search_form(); ?>

		<?php endif; ?>
	</div><!-- .page-content -->
</div><!-- .no-results -->
