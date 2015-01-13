<?php
/**
 * @package SCM
 */

get_header();

	if( have_posts() ){

		while ( have_posts() ) : the_post();

			get_template_part( SCM_DIR_PARTS_SINGLE, 'scm' );

		endwhile;

	}else{
		get_template_part( SCM_DIR_PARTS, 'none' );
	}

get_footer();

?>
