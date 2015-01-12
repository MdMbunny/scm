<?php
/**
 * @package SCM
 */

	get_header();

	while ( have_posts() ) : the_post();

		get_template_part( SCM_DIR_PARTS_SINGLE, 'scm' );

	endwhile;

	get_footer();

?>



