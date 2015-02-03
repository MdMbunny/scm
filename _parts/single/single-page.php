<?php

global $post;

$type = $post->post_type;
$slug = $post->post_name;

$id = $post->ID;
$custom_id = ( get_field('custom_id') ?: $type . '-' . $id );

$class = get_post_class();
$custom_classes = ( get_field('custom_classes') ?: '' );
$classes =  implode( ' ', $class ) . ' ' . $slug . ' ' . SCM_PREFIX . 'object ' . $custom_classes;

$style = scm_options_get_style( $id, 1 );

$single = ( ( isset($this) && isset($this->single) ) ? $this->single : 0 );

echo '<article id="' . $custom_id . '" class="' . $classes . '" ' . $style . '>';
	
	// --- Header
	$custom_head = (  get_field( 'flexible_headers' ) ?: ( get_field( 'flexible_headers', 'option' ) ?: array() ) );
	//$custom_head = ( $single ? get_field( 'flexible_headers' ) : ( get_field( 'flexible_headers', 'option' ) ?: array() ) );
	$units = ( $single ? get_field( 'units_' . $type, 'option' ) : get_field( 'units' ) );
	$units = ( $units ?: ( get_field( 'units', 'option' ) ?: 'px' ) );
	$height = ( $single ? get_field( 'max_height_' . $type, 'option' ) : get_field( 'max_height' ) );
	$height = ( $height ?: ( get_field( 'max_height', 'option' ) ?: 'auto' ) );
	$height = ( $height == 'auto' ?: $height . $units );

	if( sizeof( $custom_head ) ){
		scm_custom_header( $id, $custom_head, $type, $height );
	}

	if( $single ){

        get_template_part( SCM_DIR_PARTS_SINGLE, $type );

	}else{

		$repeater = ( get_field('flexible_rows') ?: array() );
		
		if( sizeof( $repeater ) ){

			$current_row = 0;

			$odd = '';

			$total = sizeof( $repeater );

			foreach ($repeater as $row) {

				$classes = 'section';

		    	$current_row++;
				
				if( $current_row == 1 )
					$classes .= ' first';
				elseif( $current_row == $total )
					$classes .= ' last';

				$odd = ( $odd ? '' : ' row-odd odd' );
				$classes .= $odd;
				$classes .= ' count-' . ( $current_row );

				$class = ( $row['row_classes'] ? $classes . ' ' . $row['row_classes'] : $classes);

				$row_id = ( $row['row_id'] ?: '' ) ;

				$element = ( isset( $row['acf_fc_layout'] ) ?: '' );
				if( !$element ) continue;

				switch ($element) {
					case 'section_element':
						
						$single = $row[ 'select_section' ];
	            		if(!$single) continue;
			            $post = $single;
			            setup_postdata( $post );
			            Get_Template_Part::get_part( SCM_DIR_PARTS_SINGLE . '-scm-sections.php', array(
			            	'add_id' => $row_id,
                        	'add_class' => $class,
                        ));

					break;
				}
		    }
		   
		}else{
		    // no layouts found
		}
	}

echo '</article><!-- page -->';

?>
