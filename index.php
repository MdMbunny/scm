<?php

/**
 * @package SCM
 */

	get_header();

	if ( have_posts() ) :

		while ( have_posts() ) : the_post();
	
				get_template_part( SCM_PARTS_SINGLE, 'scm' );

		endwhile;

		scm_paging_nav();

	else :

		get_template_part( SCM_PARTS, 'none' );

	endif; 

	get_footer();

?>
