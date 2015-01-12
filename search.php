<?php
/**
 * @package SCM
 */

	get_header();

	if ( have_posts() ) :

		echo '<header class="page-header">';
			echo '<h1 class="page-title">' . printf( __( "Search Results for: %s", SCM_THEME ), "<span><?php get_search_query() ?></span>" ); . '</h1>';
		echo '</header><!-- .page-header -->';

		while ( have_posts() ) : the_post();
			get_template_part( SCM_DIR_PARTS, 'search' );

		endwhile;

	else :

		<?php get_template_part( SCM_DIR_PARTS, 'none' );
	endif;

	get_footer();

?>
