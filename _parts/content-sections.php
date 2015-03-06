<?php

global $post;

// --
// Pages search for the flexible_rows option, into page $id [ get_template_part(template) ]
// Other elements, like the Footer, may search for the flexible_rows_[element] option, in the general options [ Get_Template_Part(template, element) ]
$id = ( ( isset($this) && isset($this->option) ) ? 'option' : $post->ID );
$flexible = 'flexible_rows';
$flexible .= ( ( isset($this) && isset($this->option) ) ? '_' . $this->option : '' );
// --

$repeater = scm_field( $flexible, array(), $id, 1 );

	if( sizeof( $repeater ) ){

		$id = ( $id == 'option' ? '' : $id );

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

			$section_id = ( $row['row_id'] ?: '' ) ;

			$section_attributes = ( $row['row_attributes'] ?: '' ) ;

			$element = ( isset( $row['acf_fc_layout'] ) ? $row['acf_fc_layout'] : '' );
			if( !$element ) continue;

			switch ($element) {
				case 'section_element':
					
					$single = $row[ 'select_section' ];
            		if(!$single) continue;
		            $post = $single;
		            setup_postdata( $post );
		            Get_Template_Part::get_part( SCM_DIR_PARTS_SINGLE . '-scm-sections.php', array(
		            	'page_id' => $id,
		            	'add_id' => $section_id,
                    	'add_class' => $section_class,
                    	'add_attributes' => $section_attributes,
                    ));

				break;
			}
	    }
	   
	}else{
	    // no layouts found
	}

?>