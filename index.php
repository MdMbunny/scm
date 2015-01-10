<?php
/**
 * @package SCM
 */

/*if ( !is_plugin_active( 'advanced-custom-fields-pro/acf.php' ) )
  return;*/

	get_header();

	if ( have_posts() ) :

		while ( have_posts() ) : the_post();
	
				get_template_part( SCM_DIR_PARTS_SINGLE, 'scm' );

		endwhile;

		scm_paging_nav();

	else :

		get_template_part( SCM_DIR_PARTS, 'none' );

	endif; 

	get_footer();

?>
