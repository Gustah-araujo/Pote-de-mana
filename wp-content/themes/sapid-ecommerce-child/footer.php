					</div>
			    </main><!-- #main -->
				<?php do_action( 'sapid_before_footer' ); ?>
				
				<div class="sapid-footer row px-3 py-5">
					
					<div class="d-flex align-items-center col-6 px-4">
						<p class="my-1">Copyright @ - <?php echo date("Y") ?> Pote de Mana. Todos os direitos reservados.</p>
					</div>

					<div class="col-3 px-4">
						<?php wp_nav_menu( [
							'theme_location' => 'footer_nav_menu_left'
						] ) ?>
					</div>

					<div class="col-3 px-4">
						<?php wp_nav_menu( [
							'theme_location' => 'footer_nav_menu_right'
						] ) ?>
					</div>

				</div>

				<?php do_action( 'sapid_after_footer' ); ?>
			</div> <!-- wrapper -->
		</div> <!-- #boxed-wrapper -->

		<?php get_template_part( 'includes/inc/templates/to-top' ); ?>

		<?php wp_footer(); ?>
	</body>
</html>