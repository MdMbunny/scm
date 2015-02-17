<?php

global $post;

$type = $post->post_type;
$slug = $post->post_name;

$id = $post->ID;
$custom_id = ( get_field('custom_id') ?: $type . '-' . $id );

$class = get_post_class();
$custom_classes = ( get_field('custom_classes') ?: '' );
$classes =  implode( ' ', $class ) . ' ' . $slug . ' ' . SCM_PREFIX . 'object ' . $custom_classes;

$single = ( ( isset($this) && isset($this->single) ) ? $this->single : 0 );

echo '<article id="' . $custom_id . '" class="' . $classes . '">';
	
	// --- Header

	$active = ( get_field( 'active_slider' ) == 'on' ?: 0 );

	if( $active ){
		$custom_head = (  get_field( 'flexible_headers' ) ?: ( get_field( 'flexible_headers', 'option' ) ?: array() ) );
		$layout = ( get_field( 'select_layout_slider' ) != 'default' ? get_field( 'select_layout_slider' ) : ( get_field( 'select_layout_slider', 'option' ) != 'default' ? get_field( 'select_layout_slider', 'option' ) : 'responsive' ) );
		$height = get_field( 'height_slider' );
		
		if( !$height )
			$height = ( get_field( 'height_slider', 'option' ) ?: 'initial' );

		if( sizeof( $custom_head ) )
			scm_custom_header( $id, $custom_head, $type, $layout, $height );
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

				$classes = '';

		    	$current_row++;
				
				if( $current_row == 1 )
					$classes .= 'first';
				if( $current_row == $total )
					$classes .= 'last';

				$odd = ( $odd ? '' : ' row-odd odd' );
				$classes .= $odd;
				$classes .= ' count-' . ( $current_row );

				$classes .= ( $row['row_classes'] ? ' ' . $row['row_classes'] : '' );

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
			            	'page_id' => $id,
			            	'add_id' => $row_id,
                        	'add_class' => $classes,
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
