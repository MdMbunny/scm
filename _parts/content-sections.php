<?php

global $post, $SCM_indent;

// --
// Pages search for the flexible_rows option, into page $id [ get_template_part(template) ]
// Other elements, like the Footer, may search for the flexible_rows_[element] option, in the general options [ Get_Template_Part(template, element) ]
$id = ( ( isset($this) && isset($this->option) ) ? 'option' : $post->ID );
//$flexible = 'page-row';
$name = ( ( isset($this) && isset($this->option) ) ? $this->option . '-sections' : 'sections' );
// --

$site_align = scm_field( 'layout-alignment', 'center', 'option' );

$repeater = scm_field( $name, array(), $id, 1 );

	if( isset( $repeater ) && !empty( $repeater ) ){

		$id = ( $id == 'option' ? '' : $id );

		$current = 0;
		$odd = '';

		$total = sizeof( $repeater );

		foreach ( $repeater as $section ) {

	    	$current++;
			$odd = ( $odd ? '' : ' odd' );

			$section_class = 'section scm-section object scm-object full ' . $site_align;
			$section_class .= $odd;
			$section_class .= scm_count_class( $current, $total );
			$section_class .= ( $section['class'] ? ' ' . $section['class'] : '' );

			$section_id = ( $section['id'] ? ' id="' . $section['id'] . '"' : '' );
			$section_attributes = ( $section['attributes'] ?: '' ) ;
			
			$indent = $SCM_indent + 1;

			indent( $indent + 1, '<div' . $section_id . ' class="' . $section_class . '"' . $section_attributes . '>', 1 );

				$rows = ( $section['rows'] ?: [] );
				if( sizeof( $rows ) ){

					$row_current = 0;
					$row_odd = '';

					$row_total = sizeof( $rows );
			
					foreach ( $rows as $row ) {

						$row_current++;
						$row_odd = ( $row_odd ? '' : ' odd ' );

						$row_class = '';
						$row_class .= $row_odd;
						$row_class .= scm_count_class( $row_current, $row_total );
						$row_class .= ( $row['class'] ? ' ' . $row['class'] : '' );

						$row_id = $row['id'];
						$row_attributes = $row['attributes'];
						$row_layout = $row['layout'];

						$row_fc = ( isset( $row['acf_fc_layout'] ) ? $row['acf_fc_layout'] : '' );
						if( !$row_fc ) continue;

						switch ($row_fc) {
							case 'layout-select-module':
								
								$single = $row[ 'module' ];
			            		if(!$single) continue;
			            		$post = ( is_numeric( $single ) ? get_post( $single ) : $single );
					            setup_postdata( $post );
					            
					            // +++ todo: row in nuovo file single-row.php

					            Get_Template_Part::get_part( SCM_DIR_PARTS_SINGLE . '-row.php', array(
					            	'row_id' => $row_id,
					            	'row_class' => $row_class,
					            	'row_attributes' => $row_attributes,
					            	'row_layout' => $row_layout,
			                    ));

							break;
						}

					}
				}

			indent( $indent + 1, '</div><!-- section -->', 2 );
	    }
	   
	}else{
	    // no sections found
	}

?>