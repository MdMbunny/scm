<?php

/**
 * @package SCM
 */

// +++ todo: redirect to NONE || crea elenco di title con link a single, aggiunge Options Page per Type e fields Header, Title...

	get_header();

	if ( have_posts() ){

		//echo '<header class="page-header">';
				//the_archive_title( '<h1 class="page-title">', '</h1>' );
				//the_archive_description( '<div class="taxonomy-description">', '</div>' );
		//echo '</header><!-- .page-header -->';

		while ( have_posts() ) : the_post();

			get_template_part( SCM_DIR_PARTS_SINGLE, 'scm' );
		endwhile;

	}else{

		get_template_part( SCM_DIR_PARTS, 'none' );

	}

	get_footer();

?>
