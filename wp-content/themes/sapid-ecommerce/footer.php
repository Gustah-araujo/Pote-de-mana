					</div>
			    </main><!-- #main -->
				<?php do_action( 'sapid_before_footer' ); ?>
				
				<div class="sapid-footer">
					<?php do_action( 'sapid_footer' ); ?>
				</div>

				<?php do_action( 'sapid_after_footer' ); ?>
			</div> <!-- wrapper -->
		</div> <!-- #boxed-wrapper -->

		<?php get_template_part( 'includes/inc/templates/to-top' ); ?>

		<?php wp_footer(); ?>
	</body>
</html>