<?php
/**
 * @package SCM
 */

// *****************************************************
// *	ACF FIELDS
// *****************************************************

/* General */

	if ( ! function_exists( 'scm_acf_preset' ) ) {
		function scm_acf_preset( $name = '', $field = 0, $default = 0, $width = 100, $logic = 0, $required = 0  ) {
			return scm_acf_field( scm_acf_preset_default( $name, $width, $logic, $required ), scm_acf_preset_specific( $field, $default ) );
		}
	}

	if ( ! function_exists( 'scm_acf_preset_default' ) ) {
		function scm_acf_preset_default( $arg = '', $width = 100, $logic = 0, $required = 0  ) {

			$default = array(
				'name' 					=> '',
				'label' 				=> '',
				'logic' 				=> 0,
				'instructions' 			=> '',
				'required' 				=> 0,
				'width' 				=> '',
				'class' 				=> '',
				'id' 					=> '',
            );

			if( is_array( $arg ) ){
                $default = array_merge( $default, $arg );
            }else{
            	$default['name'] = $arg;
            	$default['width'] = $width;
            	$default['logic'] = $logic;
            	$default['required'] = $required;
            }

			return $default;
		}
	}

	if ( ! function_exists( 'scm_acf_preset_specific' ) ) {
		function scm_acf_preset_specific( $field = 0, $arg = 0 ) {
			$default = '';
			if( $field && is_string( $field ) ){
				$default = $field;
				$field = 0;
			}
			$arg = array_merge( ( $arg ?: array() ), ( $field ?: array() ) );
			$arg['type'] = ( $arg['type'] ?: 'text' );
			$arg['default'] = ( $default ?: ( isset($arg['default']) ? $arg['default'] : '' ) );
			return $arg;
		}
	}

/* Tab */

	// TAB
	function scm_acf_field_tab( $name = '', $field = 0, $width = 100, $logic = 0, $required = 0, $label = '' ) {
		return scm_acf_preset( $name, $field, array('type' => 'tab','label' => $label), $width, $logic, $required );
	}

	// TAB LEFT
	function scm_acf_field_tab_left( $name = '', $field = 0, $width = 100, $logic = 0, $required = 0, $label = '' ) {
		return scm_acf_preset( $name, $field, array('type' => 'tab-left','label' => $label), $width, $logic, $required );
	}

/* Number */

	// NUMBER
	function scm_acf_field_number( $name = '', $field = 0, $width = 100, $logic = 0, $required = 0, $label = '' ) {
		return scm_acf_preset( $name, $field, array('type' => 'number','label' => $label), $width, $logic, $required );
	}
	
	// OPTION
	function scm_acf_field_option( $name = '', $field = 0, $width = 100, $logic = 0, $required = 0, $label = '' ) {
		return scm_acf_preset( $name, $field, array('type' => 'option','label' => $label), $width, $logic, $required );
	}

	// POSITIVE
	function scm_acf_field_positive( $name = '', $field = 0, $width = 100, $logic = 0, $required = 0, $label = '' ) {
		return scm_acf_preset( $name, $field, array('type' => 'positive','label' => $label), $width, $logic, $required );
	}

	// NEGATIVE
	function scm_acf_field_negative( $name = '', $field = 0, $width = 100, $logic = 0, $required = 0, $label = '' ) {
		return scm_acf_preset( $name, $field, array('type' => 'negative','label' => $label), $width, $logic, $required );
	}
	
	// ALPHA
	function scm_acf_field_alpha( $name = '', $field = 0, $width = 100, $logic = 0, $required = 0, $label = '' ) {
		return scm_acf_preset( $name, $field, array('type' => 'alpha','label' => $label), $width, $logic, $required );
	}
	
/* Text */

	// TEXT
	function scm_acf_field_text( $name = '', $field = 0, $width = 100, $logic = 0, $required = 0, $label = '' ) {
		return scm_acf_preset( $name, $field, array('type' => 'text','label' => $label), $width, $logic, $required );
	}
	
	// ID
	function scm_acf_field_id( $name = '', $field = 0, $width = 100, $logic = 0, $required = 0, $label = '' ) {
		return scm_acf_preset( $name, $field, array('type' => 'id','label' => $label), $width, $logic, $required );
	}

	// CLASS
	function scm_acf_field_class( $name = '', $field = 0, $width = 100, $logic = 0, $required = 0, $label = '' ) {
		return scm_acf_preset( $name, $field, array('type' => 'class','label' => $label), $width, $logic, $required );
	}

	// NAME
	function scm_acf_field_name( $name = '', $field = 0, $width = 100, $logic = 0, $required = 0, $label = '' ) {
		return scm_acf_preset( $name, $field, array('type' => 'name','label' => $label), $width, $logic, $required );
	}

	// LINK
	function scm_acf_field_link( $name = '', $field = 0, $width = 100, $logic = 0, $required = 0, $label = '' ) {
		return scm_acf_preset( $name, $field, array('type' => 'link','label' => $label), $width, $logic, $required );
	}
	
	// EMAIL
	function scm_acf_field_email( $name = '', $field = 0, $width = 100, $logic = 0, $required = 0, $label = '' ) {
		return scm_acf_preset( $name, $field, array('type' => 'email','label' => $label), $width, $logic, $required );
	}

	// USER
	function scm_acf_field_user( $name = '', $field = 0, $width = 100, $logic = 0, $required = 0, $label = '' ) {
		return scm_acf_preset( $name, $field, array('type' => 'user','label' => $label), $width, $logic, $required );
	}
	
	// PHONE
	function scm_acf_field_phone( $name = '', $field = 0, $width = 100, $logic = 0, $required = 0, $label = '' ) {
		return scm_acf_preset( $name, $field, array('type' => 'phone','label' => $label), $width, $logic, $required );
	}


/* Limiter */
	
	// LIMITER
	function scm_acf_field_limiter( $name = '', $field = 0, $width = 100, $logic = 0, $required = 0, $label = '' ) {
		return scm_acf_preset( $name, $field, array('type'=>'limiter','max'=>350,'display'=>1,'label' => $label), $width, $logic, $required );
	}

/* TextArea */
	
	// TEXTAREA
	function scm_acf_field_textarea( $name = '', $field = 0, $width = 100, $logic = 0, $required = 0, $label = '' ) {
		return scm_acf_preset( $name, $field, array('type'=>'textarea', 'rows'=>8,'label' => $label), $width, $logic, $required );
	}

	// TEXTAREA CODE
	function scm_acf_field_codearea( $name = '', $field = 0, $width = 100, $logic = 0, $required = 0, $label = '' ) {
		return scm_acf_preset( $name, $field, array('type'=>'textarea-no', 'rows'=>8, 'class'=>'widefat code','label' => $label), $width, $logic, $required );
	}

/* Editor */
	
	// EDITOR BASIC MEDIA
	function scm_acf_field_editor( $name = '', $field = 0, $width = 100, $logic = 0, $required = 0, $label = '' ) {
		return scm_acf_preset( $name, $field, array('type' => 'editor-media-basic','label' => $label), $width, $logic, $required );
	}

	// EDITOR VISUAL MEDIA
	function scm_acf_field_editor_media( $name = '', $field = 0, $width = 100, $logic = 0, $required = 0, $label = '' ) {
		return scm_acf_preset( $name, $field, array('type' => 'editor-media-visual-basic','label' => $label), $width, $logic, $required );
	}

	// EDITOR VISUAL
	function scm_acf_field_editor_basic( $name = '', $field = 0, $width = 100, $logic = 0, $required = 0, $label = '' ) {
		return scm_acf_preset( $name, $field, array('type' => 'editor-visual-basic','label' => $label), $width, $logic, $required );
	}

/* Date */
	
	// DATE
	function scm_acf_field_date( $name = '', $field = 0, $width = 100, $logic = 0, $required = 0, $label = '' ) {
		return scm_acf_preset( $name, $field, array('type' => 'date','label' => $label), $width, $logic, $required );
	}

/* Color */
	
	// COLOR
	function scm_acf_field_color( $name = '', $field = 0, $width = 100, $logic = 0, $required = 0, $label = '' ) {
		return scm_acf_preset( $name, $field, array('type' => 'color','label' => $label), $width, $logic, $required );
	}

/* Icon */

	// ICON
	function scm_acf_field_icon( $name = '', $field = 0, $width = 100, $logic = 0, $required = 0, $label = '' ) {
		return scm_acf_preset( $name, $field, array('type' => 'icon','default'=>'star','label' => $label), $width, $logic, $required );
	}

	// ICON NO
	function scm_acf_field_icon_no( $name = '', $field = 0, $width = 100, $logic = 0, $required = 0, $label = '' ) {
		return scm_acf_preset( $name, $field, array('type' => 'icon-no','default'=>'no','label' => $label), $width, $logic, $required );
	}

/* Image */

	// IMAGE
	function scm_acf_field_image( $name = '', $field = 0, $width = 100, $logic = 0, $required = 0, $label = '' ) {
		return scm_acf_preset( $name, $field, array('type' => 'image','label'=>($label ?: __( 'Seleziona un\'immagine', SCM_THEME ))), $width, $logic, $required );
	}

	// IMAGE URL
	function scm_acf_field_image_url( $name = '', $field = 0, $width = 100, $logic = 0, $required = 0, $label = '' ) {
		return scm_acf_preset( $name, $field, array('type' => 'image-url','label'=>($label ?: __( 'Seleziona un\'immagine', SCM_THEME ))), $width, $logic, $required );
	}

/* File */

	// FILE
	function scm_acf_field_file( $name = '', $field = 0, $width = 100, $logic = 0, $required = 0, $label = '' ) {
		return scm_acf_preset( $name, $field, array('type' => 'file','label'=>($label ?: __( 'Seleziona un file', SCM_THEME ))), $width, $logic, $required );
	}

	// FILE URL
	function scm_acf_field_file_url( $name = '', $field = 0, $width = 100, $logic = 0, $required = 0, $label = '' ) {
		return scm_acf_preset( $name, $field, array('type' => 'file-url','label'=>($label ?: __( 'Seleziona un file', SCM_THEME ))), $width, $logic, $required );
	}

/* True False */
	
	// FALSE
	function scm_acf_field_false( $name = '', $field = 0, $width = 100, $logic = 0, $required = 0, $label = '' ) {
		return scm_acf_preset( $name, $field, array('default'=>0, 'type' => 'true_false','label'=>( $label ?: __( 'Abilita', SCM_THEME ) ) ), $width, $logic, $required );
	}

	// TRUE
	function scm_acf_field_true( $name = '', $field = 0, $width = 100, $logic = 0, $required = 0, $label = '' ) {
		return scm_acf_preset( $name, $field, array('default'=>1, 'type' => 'true_false','label'=>( $label ?: __( 'Abilita', SCM_THEME ) ) ), $width, $logic, $required );
	}

/* Select */

	// SELECT
	function scm_acf_field_select( $name = '', $field = 0, $width = 100, $logic = 0, $required = 0, $label = '' ) {
		$type = 'select';
		if( is_string( $field ) ){
			$type = $type . ( strpos($field, '2') === 0 ? '' : '-') . $field;
			$field = 0;
		}elseif( $field === 1 ){
			$type = $type . '-default';
			$field = 0;
		}elseif( is_array( $field ) && $field['type'] ){
			$field['type'] = $type . '-' . $field['type'];
		}
		return scm_acf_preset( $name, $field, array( 'type'=>$type, 'label'=>$label ), $width, $logic, $required );
	}

// ************* DA QUI

/* Object */

	// INTERNAL OBJECT ID BY TAXONOMY
	if ( ! function_exists( 'scm_acf_field_object_tax' ) ) {
		function scm_acf_field_object_tax( $name = '', $default = 0, $type = '', $tax = '', $width = '', $logic = 0, $label = '', $instructions = '', $required = 0 ) {
			//$label = ( $label ?: __( 'Contenuto', SCM_THEME ) );
			
			return scm_acf_field( $name, array( 'object-id', $type, $tax , __( 'Seleziona', SCM_THEME ) . ' ' . $label), $label, $width, $logic, $instructions, $required );
		}
	}

	// INTERNAL OBJECTS ID BY TAXONOMY
	if ( ! function_exists( 'scm_acf_field_objects_tax' ) ) {
		function scm_acf_field_objects_tax( $name = '', $default = 0, $type = '', $tax = '', $width = '', $logic = 0, $label = '', $instructions = '', $required = 0 ) {
			//$label = ( $label ?: __( 'Contenuto', SCM_THEME ) );

			return scm_acf_field( $name, array( 'objects-id', $type, $tax , __( 'Seleziona', SCM_THEME ) . ' ' . $label), $label, $width, $logic, $instructions, $required );
		}
	}

	// INTERNAL OBJECT OBJ
	if ( ! function_exists( 'scm_acf_field_object_obj' ) ) {
		function scm_acf_field_object_obj( $name = '', $default = 0, $type = '', $width = '', $logic = 0, $label = '', $instructions = '', $required = 0 ) {
			//$label = ( $label ?: __( 'Contenuto', SCM_THEME ) );
			return scm_acf_field( $name, array( 'object', $type, '', __( 'Seleziona', SCM_THEME ) . ' ' . $label ), $label, $width, $logic, $instructions, $required );
		}
	}

	// INTERNAL OBJECT OBJ NULL
	if ( ! function_exists( 'scm_acf_field_object_obj_null' ) ) {
		function scm_acf_field_object_obj_null( $name = '', $default = 0, $type = '', $width = '', $logic = 0, $label = '', $instructions = '', $required = 0 ) {
			//$label = ( $label ?: __( 'Contenuto', SCM_THEME ) );
			return scm_acf_field( $name, array( 'object-null', $type, '', __( 'Seleziona', SCM_THEME ) . ' ' . $label ), $label, $width, $logic, $instructions, $required );
		}
	}

	// INTERNAL OBJECT ID
	if ( ! function_exists( 'scm_acf_field_object' ) ) {
		function scm_acf_field_object( $name = '', $default = 0, $type = '', $width = '', $logic = 0, $label = '', $instructions = '', $required = 0 ) {
			//$label = ( $label ?: __( 'Contenuto', SCM_THEME ) );
			return scm_acf_field( $name, array( 'object-id', $type, '', __( 'Seleziona', SCM_THEME ) . ' ' . $label ), $label, $width, $logic, $instructions, $required );
		}
	}

	// INTERNAL OBJECT ID NULL
	if ( ! function_exists( 'scm_acf_field_object_null' ) ) {
		function scm_acf_field_object_null( $name = '', $default = 0, $type = '', $width = '', $logic = 0, $label = '', $instructions = '', $required = 0 ) {
			//$label = ( $label ?: __( 'Contenuto', SCM_THEME ) );
			return scm_acf_field( $name, array( 'object-id-null', $type, '', __( 'Seleziona', SCM_THEME ) . ' ' . $label ), $label, $width, $logic, $instructions, $required );
		}
	}

	// INTERNAL OBJECT ID REL
	if ( ! function_exists( 'scm_acf_field_object_rel' ) ) {
		function scm_acf_field_object_rel( $name = '', $default = 0, $type = '', $width = '', $logic = 0, $label = '', $instructions = '', $required = 0 ) {
			//$label = ( $label ?: __( 'Contenuto', SCM_THEME ) );

			return scm_acf_field( $name, array( 'object-rel-id', $type, '', __( 'Seleziona', SCM_THEME ) . ' ' . $label ), $label, $width, $logic, $instructions, $required );
		}
	}

	// INTERNAL OBJECTS
	if ( ! function_exists( 'scm_acf_field_object_objs' ) ) {
		function scm_acf_field_object_objs( $name = '', $default = 0, $type = '', $width = '', $logic = 0, $label = '', $instructions = '', $required = 0 ) {
			//$label = ( $label ?: __( 'Contenuto', SCM_THEME ) );

			return scm_acf_field( $name, array( 'objects', $type, '', __( 'Seleziona', SCM_THEME ) . ' ' . $label ), $label, $width, $logic, $instructions, $required );
		}
	}

	// INTERNAL OBJECTS ID
	if ( ! function_exists( 'scm_acf_field_objects' ) ) {
		function scm_acf_field_objects( $name = '', $default = 0, $type = '', $width = '', $logic = 0, $label = '', $instructions = '', $required = 0 ) {
			//$label = ( $label ?: __( 'Contenuti', SCM_THEME ) );

			return scm_acf_field( $name, array( 'objects-id', $type, '', __( 'Seleziona', SCM_THEME ) . ' ' . $label ), $label, $width, $logic, $instructions, $required );
		}
	}

	// INTERNAL OBJECTS ID REL
	if ( ! function_exists( 'scm_acf_field_objects_rel' ) ) {
		function scm_acf_field_objects_rel( $name = '', $default = 0, $type = '', $width = '', $logic = 0, $label = '', $instructions = '', $required = 0 ) {
			//$label = ( $label ?: __( 'Contenuti', SCM_THEME ) );

			return scm_acf_field( $name, array( 'objects-rel-id', $type, '', __( 'Seleziona', SCM_THEME ) . ' ' . $label ), $label, $width, $logic, $instructions, $required );
		}
	}

	// INTERNAL LINKS
	if ( ! function_exists( 'scm_acf_field_object_link' ) ) {
		function scm_acf_field_object_link( $name = '', $default = 0, $type = '', $width = '', $logic = 0, $label = '', $instructions = '', $required = 0 ) {
			//$label = ( $label ?: __( 'Contenuto', SCM_THEME ) );

			return scm_acf_field( $name, array( 'object-link', $type, '', __( 'Seleziona', SCM_THEME ) . ' ' . $label, 1 ), $label, $width, $logic, $instructions, $required );
		}
	}

	// INTERNAL LINKS
	if ( ! function_exists( 'scm_acf_field_objects_link' ) ) {
		function scm_acf_field_objects_link( $name = '', $default = 0, $type = '', $width = '', $logic = 0, $label = '', $instructions = '', $required = 0 ) {
			//$label = ( $label ?: __( 'Contenuti', SCM_THEME ) );

			return scm_acf_field( $name, array( 'objects-link', $type, '', __( 'Seleziona', SCM_THEME ) . ' ' . $label, 1 ), $label, $width, $logic, $instructions, $required );
		}
	}

/* Taxonomy */

	// TAXONOMY
	if ( ! function_exists( 'scm_acf_field_taxonomy' ) ) {
		function scm_acf_field_taxonomy( $name = '', $default = 0, $tax = '', $label = '', $add = 1, $save = 0, $width = '', $logic = 0, $instructions = '', $required = 0 ) {
			//$label = ( $label ?: __( 'Taxonomy', SCM_THEME ) );

			//printPre( $name . ' - ' . $tax . ' - ' . $label . ' - ' . $save );

			return scm_acf_field( $name, array( 'taxonomy-id', $tax, $add, $save ), $label, $width, $logic, $instructions, $required );
		}
	}

	// TAXONOMIES
	if ( ! function_exists( 'scm_acf_field_taxonomies' ) ) {
		function scm_acf_field_taxonomies( $name = '', $default = 0, $tax = '', $label = '', $add = 1, $save = 0, $width = '', $logic = 0, $instructions = '', $required = 0 ) {
			//$label = ( $label ?: __( 'Taxonomies', SCM_THEME ) );
			//printPre( $name . ' - ' . $tax . ' - ' . $label . ' - ' . $save );
			return scm_acf_field( $name, array( 'taxonomies-id', $tax, $add, $save ), $label, $width, $logic, $instructions, $required );
		}
	}

/* Repeater */

	// REPEATER BLOCK
	if ( ! function_exists( 'scm_acf_field_repeater' ) ) {
		function scm_acf_field_repeater( $name = '', $default = 0, $button = '', $label = '', $width = '', $logic = 0, $min = '', $max = '', $instructions = '', $required = 0, $class = '' ) {
			$button = ( $button ?: __( 'Aggiungi', SCM_THEME ) );
			//$label = ( $label ?: __( 'Elementi', SCM_THEME ) );
			return scm_acf_field( $name, array( 'repeater-block', $button, $min, $max ), $label, 100, $logic, $instructions, $required, $class );
		}
	}

	// REPEATER BLOCK LABELS
	if ( ! function_exists( 'scm_acf_field_repeater_labels' ) ) {
		function scm_acf_field_repeater_labels( $name = '', $default = 0, $button = '', $label = '', $width = '', $logic = 0, $min = '', $max = '', $instructions = '', $required = 0, $class = '' ) {
			$button = ( $button ?: __( 'Aggiungi', SCM_THEME ) );
			//$label = ( $label ?: __( 'Elementi', SCM_THEME ) );
			$class .= ' repeater-labels' ;
			return scm_acf_field( $name, array( 'repeater-block', $button, $min, $max ), $label, 100, $logic, $instructions, $required, $class );
		}
	}

	// REPEATER ROW
	if ( ! function_exists( 'scm_acf_field_repeater_row' ) ) {
		function scm_acf_field_repeater_row( $name = '', $default = 0, $button = '', $label = '', $width = '', $logic = 0, $min = '', $max = '', $instructions = '', $required = 0, $class = '' ) {
			$button = ( $button ?: __( 'Aggiungi', SCM_THEME ) );
			//$label = ( $label ?: __( 'Elementi', SCM_THEME ) );
			return scm_acf_field( $name, array( 'repeater-row', $button, $min, $max ), $label, 100, $logic, $instructions, $required, $class );
		}
	}

	// REPEATER TABLE
	if ( ! function_exists( 'scm_acf_field_repeater_table' ) ) {
		function scm_acf_field_repeater_table( $name = '', $default = 0, $button = '', $label = '', $width = '', $logic = 0, $min = '', $max = '', $instructions = '', $required = 0, $class = '' ) {
			$button = ( $button ?: __( 'Aggiungi', SCM_THEME ) );
			//$label = ( $label ?: __( 'Elementi', SCM_THEME ) );
			return scm_acf_field( $name, array( 'repeater-table', $button, $min, $max ), $label, 100, $logic, $instructions, $required, $class );
		}
	}

/* Flexible Content */

	// FLEXIBLE CONTENT
	if ( ! function_exists( 'scm_acf_field_flexible' ) ) {
		function scm_acf_field_flexible( $name = '', $default = 0, $label = '', $button = '+', $width = '', $logic = 0, $min = '', $max = '', $instructions = '', $required = 0, $class = '' ) {
			
			return scm_acf_field( $name, array( 'flexible', $button, $min, $max ), $label, 100, $logic, $instructions, $required, $class );
		}
	}
	
?>