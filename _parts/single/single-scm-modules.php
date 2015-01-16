<?php
/**
 * @package SCM
 */

global $post;
$elements = ( get_field('flexible_content') ? get_field('flexible_content') : 0 );

if( $elements ):

	scm_flexible_content( $elements );

else :

    // no layouts found

endif;



?>