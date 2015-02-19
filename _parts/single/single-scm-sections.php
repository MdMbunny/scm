<?php

global $post;

$type = $post->post_type;
$id = $post->ID;
$slug = $post->post_name;

$site_align = ( get_field( 'select_alignment_site', 'option' ) ?: 'center' );

$page_id = ( ( isset($this) && isset($this->page_id) ) ? $this->page_id : '' );

$section_id = ( ( isset($this) && isset($this->add_id) && $this->add_id ) ?  ' id="' . $this->add_id . '"' : '' );
$section_class = 'section scm-section scm-object full';
$section_class .= ( ( isset($this) && isset($this->add_class) ) ?  ' ' . $this->add_class : '' );

$row_id = ( get_field('section_id_row') ? ' id="' . get_field('section_id_row') . '"' : '' );
$row_layout = ( ( get_field('select_layout_row') && get_field('select_layout_row') != 'default' ) ? get_field('select_layout_row') : ( get_field('select_layout_page', 'option') != 'responsive' ? ( get_field('select_layout_cont', 'option') ?: 'full' ) : 'full') );
$row_class = 'row scm-row ' . $row_layout . ' float-' . $site_align;
$row_class .= ( get_field('section_class_row') ? ' ' . get_field('section_class_row') : '' );


$style_cont = ' ' . scm_options_get_style( $id, 1, '_sc' );
$style = scm_options_get_style( $id, 0, 'nobg' );

$bg_color = ( scm_options_get( 'bg_color', $id, 1 ) ?: ( scm_options_get( 'bg_color', $page_id, 1 ) ?: '' ) );
$bg_image = ( scm_options_get( 'bg_image', $id, 1 ) ?: ( scm_options_get( 'bg_image', $page_id, 1 ) ?: '' ) );
$bg_repeat = '';
$bg_position = '';
$bg_size = '';

if( $bg_image ){
	$bg_repeat = ( scm_options_get( 'bg_repeat', $id, 1 ) ?: ( scm_options_get( 'bg_repeat', $page_id, 1 ) ?: '' ) );
	$bg_position = ( scm_options_get( 'bg_position', $id, 1 ) ?: ( scm_options_get( 'bg_position', $page_id, 1 ) ?: '' ) );
	$bg_size = ( scm_options_get( 'bg_size', $id, 1 ) ?: ( scm_options_get( 'bg_size', $page_id, 1 ) ?: '' ) );
}

$style .= $bg_color . $bg_image . $bg_repeat . $bg_position . $bg_size;

$style = ( $style ? ' style="' . $style . '"' : '' );


echo '<div' . $section_id . ' class="' . $section_class . '"' . $style_cont . '>';

	$active = ( get_field( 'active_slider' ) == 'on' ?: 0 );
	
	if( $active ){

		$custom_head = ( get_field( 'flexible_headers' ) ?: array() );

		if( sizeof( $custom_head ) ){

			$height = ( get_field( 'height_slider' ) ?: 'auto' );
			$layout = ( get_field( 'select_layout_slider' ) != 'default' ? get_field( 'select_layout_slider' ) : 'responsive' );
			scm_custom_header( $id, $custom_head, $type, $layout, $height );

		}
	}

	echo '<div' . $row_id . ' class="' . $row_class . '"' . $style . '>';

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

		    	$class = 'module scm-module column column-' . $layout;

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

				$id = ( $column['column_id'] ? ' id="' . $column['column_id'] . '"' : '' ) ;
				
				echo '<div' . $id . ' class="' . $class . '">';	
					if( $module )
						scm_flexible_content( $module );
				echo '</div>';

		    }

		}else{
		    // no layouts found
		}

   	echo '</div><!-- row -->';

echo '</div><!-- section -->';

?>