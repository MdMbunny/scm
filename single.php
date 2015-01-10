<?php
/**
 * @package SCM
 */

/*if ( !is_plugin_active( 'advanced-custom-fields-pro/acf.php' ) )
  return;*/


	get_header();

	while ( have_posts() ) : the_post();

		get_template_part( SCM_DIR_PARTS_SINGLE, 'scm' );

	endwhile;

	get_footer();

?>



