<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="sapid-post-content post-content">

		<?php #the_title( '<h1 class="entry-title sapid-post-title">', '</h1>' ); ?>
		
		<?php 
	   	/**
	    * Feature image section.
	    */
		sapid_post_thumbnail('full');
		?>
		<div class="sapid-post-content-container entry-content">
			<?php
			the_content();

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
		<?php
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
</div><!-- #post-<?php the_ID(); ?> -->