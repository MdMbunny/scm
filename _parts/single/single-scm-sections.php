<?php

global $post;

$type = $post->post_type;
$id = $post->ID;
$slug = $post->post_name;

$custom_id = ( ( isset($this) && isset($this->add_id) && $this->add_id ) ? $this->add_id : $type . '-' . $id );

$classes = ( ( isset($this) && isset($this->add_class) ) ? $this->add_class . ' ' : '' );

$classes .= ( get_field('custom_classes') ?  ' ' . get_field('custom_classes') . ' ' : '' ) . $slug . ' ' . SCM_PREFIX . 'object full ';
$classes .= implode( ' ', get_post_class() );

$style = scm_options_get_style( $id, 1 );

$sc_bg = scm_options_get( 'bg_image', array( 'type' => 'sc', 'target' => $id ), 1 );
if( $sc_bg ){
	$sc_bg .= scm_options_get( 'bg_repeat', array( 'type' => 'sc', 'target' => $id ), 1 );
	$sc_bg .= scm_options_get( 'bg_position', array( 'type' => 'sc', 'target' => $id ), 1 );
	$sc_bg .= scm_options_get( 'bg_size', array( 'type' => 'sc', 'target' => $id ), 1 );
}
$sc_bg .= scm_options_get( 'bg_color', array( 'type' => 'sc', 'target' => $id ), 1 );

$row_style = '';
$row_id = $custom_id . '-row';
$row_layout = ( get_field('select_layout_row') != 'default' ? get_field('select_layout_row') : ( get_field('select_layout_page', 'option') != 'responsive' ? ( get_field('select_layout_cont', 'option') ?: 'full' ) : 'full') );
$row_class = $row_layout . ' row ' . SCM_PREFIX . 'row ' . $type . '-row';
$row_style = ( $style ?: '' );
$style = ( $sc_bg ? ' style="' . $sc_bg . '"' : '' );

echo '<section id="' . $custom_id . '" class="' . $classes . '" ' . $style . '>';

	$custom_head = ( get_field( 'flexible_headers' ) ?: array() );
	if( sizeof( $custom_head ) ){
		$height = ( get_field('max_height') ? get_field('max_height') . get_field('units') : 'auto' );
		scm_custom_header( $custom_head, $type, $height );
	}

	echo '<row id="' . $row_id . '" class="' . $row_class . '" ' . $row_style . '>';

		$repeater = ( get_field('columns_repeater') ?: array() );

		if( sizeof( $repeater ) ){

			$current_column = 0;
			$counter = 0;

			$odd = '';
			$class = '';

			$modules = array();
			
			$total = sizeof( $repeater );

			foreach ($repeater as $column) {

		    	$layout = $column['select_columns_width'];
		    	$module = $column['flexible_build'];

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

				$class = ( $column['column_classes'] ? $class . ' ' . $column['column_classes'] : $class);

				$id = ( $column['column_id'] ? $column['column_id'] : uniqid( 'light-module-' ) ) ;
				
				echo '<div id="' . $id . '" class="' . $class . '">';	
					if( $module )
						scm_flexible_content( $module );
				echo '</div>';

		    }

		}else{
		    // no layouts found
		}

   	echo '</row><!-- ' . $type . '-row -->';

echo '</section><!-- ' . $type . ' -->';

?>