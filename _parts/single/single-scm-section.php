<?php

global $post;

$type = $post->post_type;
$id = $post->ID;
$slug = $post->post_name;

$indent = ( ( isset($this) && isset($this->indent) && $this->indent ) ?  $this->indent : 0 );

$site_align = scm_field( 'select_alignment_site', 'center', 'option' );

$page_id = ( ( isset($this) && isset($this->page_id) ) ? $this->page_id : '' );

$section_id = ( ( isset($this) && isset($this->add_id) && $this->add_id ) ?  ' id="' . $this->add_id . '"' : '' );
$section_class = 'section scm-section scm-object full ' . $site_align;
$section_class .= ( ( isset($this) && isset($this->add_class) ) ?  ' ' . $this->add_class : '' );
$section_style = ' ' . scm_options_get_style( $id, 1, '_sc' );
$section_attributes = ( ( isset($this) && isset($this->add_attributes) && $this->add_attributes ) ?  ' ' . $this->add_attributes : '' );

$row_id = scm_field( 'section_id_row', '', $id, 1, ' id="', '"' );

$default = ( scm_field( 'select_layout_page', 'full', 'option' ) === 'responsive' ? 'full' : scm_field( 'select_layout_cont', 'responsive', 'option' ) );
$row_layout = scm_field( 'select_layout_row', $default );

$row_class = 'row scm-row ' . scm_options_get( 'align', 'option', 0 ) . ' ' . $row_layout;// . ' float-' . $site_align;

$row_class .= scm_field( 'section_class_row', '', $id, 1, ' ' );
$row_style = scm_options_get_style( $id, 0, 'nobg' );
$row_attributes = scm_field( 'section_attributes_row', '', $id, 1, ' ' );

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

$row_style .= $bg_color . $bg_image . $bg_repeat . $bg_position . $bg_size;
$row_style = ( $row_style ? ' style="' . $row_style . '"' : '' );

indent( $indent + 1, '<div' . $section_id . ' class="' . $section_class . '"' . $section_style . $section_attributes . '>', 1 );

	indent( $indent + 2, '<div' . $row_id . ' class="' . $row_class . '"' . $row_style . $row_attributes . '>', 1 );

		$repeater = scm_field( 'columns_repeater', array(), $id, 1 );

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
				
				if( $current_column == $total )
					$class .= ' last';

				$odd = ( $odd ? '' : ' column-odd odd' );
				$class .= $odd;
				$class .= ' count-' . ( $current_column );

				$class = ( $column['column_classes'] ? $class . ' ' . $column['column_classes'] : $class);

				$id = ( $column['column_id'] ? ' id="' . $column['column_id'] . '"' : '' ) ;
				
				indent( $indent + 3, '<div' . $id . ' class="' . $class . '">', 1 );	
					if( $module )
						scm_flexible_content( $module );
				indent( $indent + 3, '</div>', 1 );

		    }

		}else{
		    // no layouts found
		}

   	indent( $indent + 2, '</div><!-- row -->', 1 );

indent( $indent + 1, '</div><!-- section -->', 2 );

?>