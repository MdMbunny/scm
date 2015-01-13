<?php
/**
 * @package SCM
 */

	global $SCM_types;

	get_header();

	while ( have_posts() ) : the_post();

		$type = get_post_type();
		$public = getByKey( $SCM_types['public'], $type );

		if( $public && locate_template( SCM_DIR_PARTS_SINGLE . '-' . $type . '.php' ) ){
			Get_Template_Part::get_part( SCM_DIR_PARTS_SINGLE . '-scm.php', array(
			   'single' => 1,
			));
		}else{
			get_template_part( SCM_DIR_PARTS, 'none' );
		}

	endwhile;

	get_footer();

?>



