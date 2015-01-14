<?php


global $post;

if( have_rows('columns_repeater') ):

	$current_column = 0;
	$counter = 0;

	$odd = '';
	$class = '';

	$modules = array();
	
	$total = sizeof( get_field( 'columns_repeater' ) );

    while ( have_rows('columns_repeater') ) : the_row();

    	$layout = get_sub_field('select_columns_width');
    	$module = get_sub_field('flexible_build');

    	$size = (int)$layout[0] / (int)$layout[1];
    	$counter += $size;
    	$current_column++;

    	$class = 'light-module column column-' . $layout;

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

		$class = ( get_sub_field('column_classes') ? $class . ' ' . get_sub_field('column_classes') : $class);

		$id = ( get_sub_field('column_id') ? get_sub_field('column_id') : uniqid( 'light-module-' ) ) ;
		
		$modules[] = array( $module, $id, $class );

    endwhile;
	
	    foreach ($modules as $value) {
	    	echo '<div id="' . $value[1] . '" class="' . $value[2] . '">';	
				scm_flexible_content( $value[0] );
			echo '</div>';
		}
	

else :

    // no layouts found

endif;



?>