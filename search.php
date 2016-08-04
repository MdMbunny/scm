<?php

/**
 * search.php
 *
 * Template for search form.
 *
 * @link http://www.studiocreativo-m.it
 *
 * @package SCM
 * @subpackage Root/Templates
 * @since 1.0.0
 */

	if ( have_posts() ) {

		get_header();

		echo '<header class="page-header">';
			echo '<h1 class="page-title">' . printf( __( "Search Results for: %s", SCM_THEME ), "<span><?php get_search_query() ?></span>" ); . '</h1>';
		echo '</header><!-- .page-header -->';

		while ( have_posts() ) : the_post();
		
			get_template_part( SCM_DIR_PARTS, 'search' );

		endwhile;

		get_footer();

	} else {

		<?php get_template_part( SCM_DIR_PARTS, 'none' );
	
	}
?>