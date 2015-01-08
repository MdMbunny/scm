<?php

if( have_rows('flexible_rows') ):

	global $post;

	$current_row = 0;

	$odd = '';

	$sections = array();

	$total = sizeof( get_field( 'flexible_rows' ) );

    while ( have_rows('flexible_rows') ) : the_row();
		
		$class = 'section';

    	$current_row++;
		
		if( $current_row == 1 )
			$class .= ' first';
		elseif( $current_row == $total )
			$class .= ' last';

		$odd = ( $odd ? '' : ' section-odd odd' );
		$class .= $odd;
		$class .= ' count-' . ( $current_row );

		$section = get_sub_field('contenuto');

		if(!$section) continue;
		
		$sections[] = array( $section, $class );

    endwhile;

    foreach ($sections as $value) {
    	$post = $value[0];
		setup_postdata( $post );
		Get_Template_Part::get_part( SCM_PARTS_SINGLE . '-scm.php', array(
		   'add_class' => $value[1]
		));	
	}

else :

    // no layouts found

endif;


?>
