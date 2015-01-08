<?php

/**
 * @package SCM
 */

if ( !is_plugin_active( 'advanced-custom-fields-pro/acf.php' ) )
  return;


	get_header();

	if ( have_posts() ){

		//echo '<header class="page-header">';
				//the_archive_title( '<h1 class="page-title">', '</h1>' );
				//the_archive_description( '<div class="taxonomy-description">', '</div>' );
		//echo '</header><!-- .page-header -->';

		while ( have_posts() ) : the_post();
			get_template_part( SCM_PARTS_SINGLE, 'scm' );
		endwhile;

		/*scm_paging_nav();*/

	}else{

		get_template_part( SCM_PARTS, 'none' );

	}

	get_footer();

?>
