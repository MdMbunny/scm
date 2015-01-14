<?php
/**
 * @package SCM
 */



if( have_rows('flexible_content') ):

	global $post;

	scm_flexible_content( get_field('flexible_content') );

/*    while ( have_rows('flexible_content') ) : the_row();
		
		$layout = get_row_layout();

		 the_row() );

    endwhile;*/

else :

    // no layouts found

endif;



?>