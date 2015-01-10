<?php

if( have_rows('flexible_columns') ):

	global $post;

	$current_column = 0;
	$counter = 0;

	$odd = '';
	$class = '';

	$modules = array();

	$total = sizeof( get_field( 'flexible_columns' ) );

    while ( have_rows('flexible_columns') ) : the_row();
		    	
    	$layout = get_row_layout();
    	$sub = substr($layout, 7);
    	$size = (int)$sub[0] / (int)$sub[1];
    	$counter += $size;
    	$current_column++;

    	$class = 'column ' . $layout;

    	if( $counter == 1 && $size == 1 ){

    		$class .= ' column-solo';
    		$counter = 0;

    	}elseif( $counter == $size || $counter > 1 ){

    		$class .= ' column-first';

    	}elseif( $counter == 1 ){

    		$class .= ' column-last clear';
    		$counter = 0;

    	}else{
    		$class .= ' column-middle';
    	}
		
		if( $current_column == 1 )
			$class .= ' first';
		elseif( $current_column == $total )
			$class .= ' last';

		$odd = ( $odd ? '' : ' column-odd odd' );
		$class .= $odd;
		$class .= ' count-' . ( $current_column );

		$module = get_sub_field('contenuto');

		if(!$module) continue;
		
		$modules[] = array( $module, $class );

    endwhile;

    foreach ($modules as $value) {
    	$post = $value[0];
		setup_postdata( $post );
		Get_Template_Part::get_part( SCM_DIR_PARTS_SINGLE . '-scm.php', array(
		   'add_class' => $value[1]
		));	
	}

else :

    // no layouts found

endif;

?>