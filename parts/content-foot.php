		<?php

			//wp_reset_postdata();

			// If comments are open or we have at least one comment, load up the comment template
			if ( comments_open() || get_comments_number() ) :
				comments_template();
			endif;
		?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
	//get_sidebar();
	get_footer();
?>