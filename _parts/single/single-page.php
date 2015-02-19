<?php

global $post;

$type = $post->post_type;
$slug = $post->post_name;

$id = $post->ID;

$page_id = ( get_field('custom_id') ? ' id="' . get_field('custom_id') . '"' : '' );
$page_class = 'page scm-page scm-object';
$page_class .= ( get_field('custom_classes') ? ' ' . get_field('custom_classes') : '' );

$single = ( ( isset($this) && isset($this->single) ) ? $this->single : 0 );

echo '<article' . $page_id . ' class="' . $page_class . '">';
	
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

			$current = 0;

			$odd = '';

			$total = sizeof( $repeater );

			foreach ($repeater as $row) {

				$section_class = '';

		    	$current++;
				
				if( $current == 1 )
					$section_class .= 'first ';
				if( $current == $total )
					$section_class .= 'last ';

				$odd = ( $odd ? '' : 'odd ' );
				$section_class .= $odd;
				$section_class .= 'count-' . ( $current );

				$section_class .= ( $row['row_classes'] ? ' ' . $row['row_classes'] : '' );

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
                        	'add_class' => $section_class,
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
