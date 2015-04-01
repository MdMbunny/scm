<?php
/**
 * @package SCM
 */

// *****************************************************
// *	ACF FIELDS
// *****************************************************

/*
*****************************************************
*
*	1.0 Fields
*	2.0 Presets
*	3.0 Fields
*	4.0 Options
*
*****************************************************
*/

// *****************************************************
// 1.0 FIELDS
// *****************************************************

/* Number */

	// NUMBER
	if ( ! function_exists( 'scm_acf_field_number' ) ) {
		function scm_acf_field_number( $name = '', $default = 0, $width = '', $logic = 0, $placeholder = 'auto', $label = 'Misura', $min = '', $max = '', $instr = '', $required = 0 ) {

			return scm_acf_field( $name, [ 'number', '', ( $default ? 'default' : $placeholder ), $label ], $label, $width, $logic, $instr, $required );
		}
	}
	
	// OPTION
	if ( ! function_exists( 'scm_acf_field_option' ) ) {
		function scm_acf_field_option( $name = '', $default = 0, $width = '', $logic = 0, $placeholder = 'auto', $label = 'Misura', $instr = '', $required = 0 ) {

			return scm_acf_field( $name, [ 'option', '', ( $default ? 'default' : $placeholder ), $label ], $label, $width, $logic, $instr, $required );
		}
	}

	// POSITIVE
	if ( ! function_exists( 'scm_acf_field_positive' ) ) {
		function scm_acf_field_positive( $name = '', $default = 0, $width = '', $logic = 0, $placeholder = 'auto', $label = 'Misura', $instr = '', $required = 0 ) {

			return scm_acf_field( $name, [ 'positive', '', ( $default ? 'default' : $placeholder ), $label ], $label, $width, $logic, $instr, $required );
		}
	}
	
	// ALPHA
	if ( ! function_exists( 'scm_acf_field_alpha' ) ) {
		function scm_acf_field_alpha( $name = '', $default = 0, $width = '', $logic = 0, $placeholder = '1', $label = 'Trasparenza', $instr = '', $required = 0 ) {

			return scm_acf_field( $name, [ 'alpha', '', ( $default ? 'default' : $placeholder ), $label ], $label, $width, $logic, $instr, $required );
		}
	}
	
/* Text */

	// TEXT
	if ( ! function_exists( 'scm_acf_field_text' ) ) {
		function scm_acf_field_text( $name = '', $default = 0, $width = '', $logic = 0, $placeholder = 'testo', $label = 'Testo', $append = '', $max = '', $instr = '', $required = 0 ) {

			return scm_acf_field( $name, [ 'text', '', ( $default ? 'default' : $placeholder ), ( $append ?: $label ), '', $max ], $label, $width, $logic, $instr, $required );
		}
	}
	
	// TEXT REQUIRED
	if ( ! function_exists( 'scm_acf_field_text_req' ) ) {
		function scm_acf_field_text_req( $name = '', $default = 0, $width = '', $logic = 0, $placeholder = 'testo', $label = 'Testo', $append = '', $max = '', $instr = '', $required = 1 ) {

			return scm_acf_field( $name, [ 'text', '', ( $default ? 'default' : $placeholder ), ( $append ?: $label ), '', $max ], $label, $width, $logic, $instr, $required );
		}
	}
	
	// ID
	if ( ! function_exists( 'scm_acf_field_id' ) ) {
		function scm_acf_field_id( $name = '', $default = 0, $width = '', $logic = 0, $placeholder = 'id', $label = 'ID', $max = '', $instr = '', $required = 0 ) {

			return scm_acf_field( $name, [ 'id', '', ( $default ? 'default' : $placeholder ) ], $label, $width, $logic, $instr, $required );
		}
	}

	// CLASS
	if ( ! function_exists( 'scm_acf_field_class' ) ) {
		function scm_acf_field_class( $name = '', $default = 0, $width = '', $logic = 0, $placeholder = 'class', $label = 'Class', $max = '', $instr = '', $required = 0 ) {

			return scm_acf_field( $name, [ 'class', '', ( $default ? 'default' : $placeholder ) ], $label, $width, $logic, $instr, $required );
		}
	}

	// NAME
	if ( ! function_exists( 'scm_acf_field_name' ) ) {
		function scm_acf_field_name( $name = '', $default = 0, $max = '', $width = '', $logic = 0, $placeholder = 'nome', $label = 'Nome', $instr = '', $required = 1 ) {

			return scm_acf_field( $name, [ 'name', '', ( $default ? 'default' : $placeholder ), $label, '', $max ], $label, $width, $logic, $instr, $required );
		}
	}

	// LINK
	if ( ! function_exists( 'scm_acf_field_link' ) ) {
		function scm_acf_field_link( $name = '', $default = 0, $width = '', $logic = 0, $placeholder = 'http://www.esempio.com', $label = 'Link', $instr = '', $required = 0 ) {

			return scm_acf_field( $name, [ 'link', '', ( $default ? 'default' : $placeholder ), $label ], $label, $width, $logic, $instr, $required );
		}
	}
	
	// LINK
	if ( ! function_exists( 'scm_acf_field_email' ) ) {
		function scm_acf_field_email( $name = '', $default = 0, $width = '', $logic = 0, $placeholder = 'info@esempio.com', $label = 'Email', $instr = '', $required = 0 ) {

			return scm_acf_field( $name, [ 'text', '', ( $default ? 'default' : $placeholder ), $label ], $label, $width, $logic, $instr, $required );
		}
	}

	// PHONE
	if ( ! function_exists( 'scm_acf_field_phone' ) ) {
		function scm_acf_field_phone( $name = '', $default = 0, $width = '', $logic = 0, $placeholder = '+39 1234 567890', $label = 'Numero', $instr = '', $required = 0 ) {

			return scm_acf_field( $name, [ 'text', '', ( $default ? 'default' : $placeholder ), $label ], $label, $width, $logic, $instr, $required );
		}
	}

/* Limiter */
	
	// LIMITER
	if ( ! function_exists( 'scm_acf_field_limiter' ) ) {
		function scm_acf_field_limiter( $name = '', $default = 0, $max = 350, $char = 1, $width = '', $logic = 0, $label = 'Inserisci testo', $instr = '', $required = 0 ) {

			return scm_acf_field( $name, [ 'limiter', $max, $char ], $label, $width, $logic, $instr, $required );
		}
	}

/* Editor */
	
	// EDITOR BASIC MEDIA
	if ( ! function_exists( 'scm_acf_field_editor' ) ) {
		function scm_acf_field_editor( $name = '', $default = 0, $width = '', $logic = 0, $placeholder = '', $label = 'Inserisci testo', $instr = '', $required = 0 ) {

			return scm_acf_field( $name, [ 'editor-media-basic', $placeholder ], $label, $width, $logic, $instr, $required );
		}
	}

/* Color */
	
	// COLOR
	if ( ! function_exists( 'scm_acf_field_color' ) ) {
		function scm_acf_field_color( $name = '', $default = 0, $width = '', $logic = 0, $placeholder = '', $label = 'Colore', $instr = '', $required = 0 ) {

			return scm_acf_field( $name, [ 'color', ( $placeholder ?: '' ) ], $label, $width, $logic, $instr, $required );
		}
	}

/* Icon */

	// ICON
	if ( ! function_exists( 'scm_acf_field_icon' ) ) {
		function scm_acf_field_icon( $name = '', $default = 0, $placeholder = 'star', $width = '', $logic = 0, $label = 'Seleziona un\'icona', $instr = '', $required = 0 ) {

			return scm_acf_field( $name, [ 'icon', $placeholder ], $label, $width, $logic, $instr, $required );
		}
	}

/* Image */

	// IMAGE
	if ( ! function_exists( 'scm_acf_field_image' ) ) {
		function scm_acf_field_image( $name = '', $default = 0, $width = '', $logic = 0, $label = 'Seleziona un\'immagine', $instr = '', $required = 0 ) {

			return scm_acf_field( $name, 'image-url', $label, $width, $logic, $instr, $required );
		}
	}

/* File */

	// FILE
	if ( ! function_exists( 'scm_acf_field_file' ) ) {
		function scm_acf_field_file( $name = '', $default = 0, $width = '', $logic = 0, $label = 'Seleziona un file', $instr = '', $required = 0 ) {

			return scm_acf_field( $name, 'file-url', $label, $width, $logic, $instr, $required );
		}
	}

/* Select */

	// SELECT
	if ( ! function_exists( 'scm_acf_field_select1' ) ) {
		function scm_acf_field_select1( $name = '', $default = 0, $type = '', $width = '', $logic = 0, $placeholder = '', $label = 'Elementi', $instr = '', $required = 0 ) {

			return scm_acf_field( $name, [ 'select' . ( $type ? '-' . $type : '' ) . ( $default ? '-default' : '' ), $placeholder, 'Seleziona ' . $label ], $label, $width, $logic, $instr, $required );
		}
	}

	// SELECT
	if ( ! function_exists( 'scm_acf_field_select' ) ) {
		function scm_acf_field_select( $name = '', $default = 0, $type = '', $width = '', $logic = 0, $placeholder = '', $label = 'Elementi', $instr = '', $required = 0 ) {

			return scm_acf_field( $name, [ 'select2' . ( $type ? '-' . $type : '' ) . ( $default ? '-default' : '' ), $placeholder, 'Seleziona ' . $label ], $label, $width, $logic, $instr, $required );
		}
	}

	// COLUMN WIDTH
	if ( ! function_exists( 'scm_acf_field_select_column_width' ) ) {
		function scm_acf_field_select_column_width( $name = '', $default = 0, $width = '', $logic = 0, $placeholder = '', $label = 'Larghezza', $instr = '', $required = 0 ) {

			return scm_acf_field( $name, [ 'select2-columns_width' . ( $default ? '-default' : '' ), $placeholder, $label ], $label, $width, $logic, $instr, $required );
		}
	}

	// OPTIONS
	if ( ! function_exists( 'scm_acf_field_select_options' ) ) {
		function scm_acf_field_select_options( $name = '', $default = 0, $width = '', $logic = 0, $placeholder = '', $label = 'Opzioni', $instr = '', $required = 0 ) {

			return scm_acf_field( $name, [ 'select2-options_show' . ( $default ? '-default' : '' ), $placeholder, $label ], $label, $width, $logic, $instr, $required );
		}
	}
	
	// DISABLE
	if ( ! function_exists( 'scm_acf_field_select_disable' ) ) {
		function scm_acf_field_select_disable( $name = '', $default = 0, $label = 'Attivazione', $width = '', $logic = 0, $placeholder = '', $instr = '', $required = 0 ) {

			return scm_acf_field( $name, [ 'select2-disable' . ( $default ? '-default' : '' ), $placeholder, $label ], $label, $width, $logic, $instr, $required );
		}
	}

	// ENABLE
	if ( ! function_exists( 'scm_acf_field_select_enable' ) ) {
		function scm_acf_field_select_enable( $name = '', $default = 0, $label = 'Attivazione', $width = '', $logic = 0, $placeholder = '', $instr = '', $required = 0 ) {

			return scm_acf_field( $name, [ 'select2-enable' . ( $default ? '-default' : '' ), $placeholder, $label ], $label, $width, $logic, $instr, $required );
		}
	}
	
	// HEADINGS
	if ( ! function_exists( 'scm_acf_field_select_headings' ) ) {
		function scm_acf_field_select_headings( $name = '', $default = 0, $complete = 0, $width = '', $logic = 0, $placeholder = '', $label = 'Stile', $instr = '', $required = 0 ) {

			return scm_acf_field( $name, [ 'select2-headings' . ( $complete ? '_complete' : '' ) . ( $default ? '-default' : '' ), $placeholder, 'Seleziona ' . $label ], $label, $width, $logic, $instr, $required );
		}
	}

	// LAYOUT
	if ( ! function_exists( 'scm_acf_field_select_layout' ) ) {
		function scm_acf_field_select_layout( $name = '', $default = 0, $label = 'Layout', $width = '', $logic = 0, $placeholder = '', $instr = '', $required = 0 ) {

			return scm_acf_field( $name, [ 'select2-layout_main' . ( $default ? '-default' : '' ), $placeholder, 'Seleziona ' . $label ], $label, $width, $logic, $instr, $required );
		}
	}

	// IMAGE FORMAT
	if ( ! function_exists( 'scm_acf_field_select_image_format' ) ) {
		function scm_acf_field_select_image_format( $name = '', $default = 0, $width = '', $logic = 0, $placeholder = '', $label = 'Formato', $instr = '', $required = 0 ) {

			return scm_acf_field( $name, [ 'select2-image_format' . ( $default ? '-default' : '' ), $placeholder, 'Seleziona ' . $label ], $label, $width, $logic, $instr, $required );
		}
	}

	// FLOAT
	if ( ! function_exists( 'scm_acf_field_select_float' ) ) {
		function scm_acf_field_select_float( $name = '', $default = 0, $width = '', $logic = 0, $placeholder = '', $label = 'Allineamento', $instr = '', $required = 0 ) {

			return scm_acf_field( $name, [ 'select2-float' . ( $default ? '-default' : '' ), $placeholder, 'Seleziona ' . $label ], $label, $width, $logic, $instr, $required );
		}
	}

	// ALIGN
	if ( ! function_exists( 'scm_acf_field_select_align' ) ) {
		function scm_acf_field_select_align( $name = '', $default = 0, $width = '', $logic = 0, $placeholder = '', $label = 'Allineamento', $instr = '', $required = 0 ) {

			return scm_acf_field( $name, [ 'select2-alignment' . ( $default ? '-default' : '' ), $placeholder, 'Seleziona ' . $label ], $label, $width, $logic, $instr, $required );
		}
	}

	// TXT ALIGN
	if ( ! function_exists( 'scm_acf_field_select_txt_align' ) ) {
		function scm_acf_field_select_txt_align( $name = '', $default = 0, $width = '', $logic = 0, $placeholder = '', $label = 'Allineamento', $instr = '', $required = 0 ) {

			return scm_acf_field( $name, [ 'select2-txt_alignment' . ( $default ? '-default' : '' ), $placeholder, 'Seleziona ' . $label ], $label, $width, $logic, $instr, $required );
		}
	}


	// UNITS
	if ( ! function_exists( 'scm_acf_field_select_units' ) ) {
		function scm_acf_field_select_units( $name = '', $default = 0, $width = '', $logic = 0, $placeholder = 'px', $label = 'Unità', $instr = '', $required = 0 ) {

			return scm_acf_field( $name, [ 'select-units' . ( $default ? '-default' : '' ), $placeholder, 'Seleziona ' . $label ], $label, $width, $logic, $instr, $required );
		}
	}

/* Object */

	// INTERNAL OBJECT
	if ( ! function_exists( 'scm_acf_field_object' ) ) {
		function scm_acf_field_object( $name = '', $default = 0, $type = '', $width = '', $logic = 0, $label = 'Contenuto', $instr = '', $required = 0 ) {

			return scm_acf_field( $name, [ 'object', $type, '', 'Seleziona ' . $label ], $label, $width, $logic, $instr, $required );
		}
	}

	// INTERNAL OBJECTS
	if ( ! function_exists( 'scm_acf_field_objects' ) ) {
		function scm_acf_field_objects( $name = '', $default = 0, $type = '', $width = '', $logic = 0, $label = 'Contenuti', $instr = '', $required = 0 ) {

			return scm_acf_field( $name, [ 'objects', $type, '', 'Seleziona ' . $label ], $label, $width, $logic, $instr, $required );
		}
	}

	// INTERNAL LINKS
	if ( ! function_exists( 'scm_acf_field_object_link' ) ) {
		function scm_acf_field_object_link( $name = '', $default = 0, $type = '', $width = '', $logic = 0, $label = 'Contenuto', $instr = '', $required = 0 ) {

			return scm_acf_field( $name, [ 'object-link', $type, '', 'Seleziona ' . $label ], $label, $width, $logic, $instr, $required );
		}
	}

	// INTERNAL LINKS
	if ( ! function_exists( 'scm_acf_field_object_links' ) ) {
		function scm_acf_field_object_links( $name = '', $default = 0, $type = '', $width = '', $logic = 0, $label = 'Contenuti', $instr = '', $required = 0 ) {

			return scm_acf_field( $name, [ 'objects-link', $type, '', 'Seleziona ' . $label ], $label, $width, $logic, $instr, $required );
		}
	}

/* Taxonomy */

	// TAXONOMY
	if ( ! function_exists( 'scm_acf_field_taxonomy' ) ) {
		function scm_acf_field_taxonomy( $name = '', $default = 0, $tax = '', $add = 1, $label = 'Taxonomy', $width = '', $logic = 0, $instr = '', $required = 0 ) {

			return scm_acf_field( $name, [ 'taxonomy', $tax, 0, $add ], $label, $width, $logic, $instr, $required );
		}
	}

	// TAXONOMIES
	if ( ! function_exists( 'scm_acf_field_taxonomies' ) ) {
		function scm_acf_field_taxonomies( $name = '', $default = 0, $tax = '', $add = 1, $label = 'Taxonomies', $width = '', $logic = 0, $instr = '', $required = 0 ) {

			return scm_acf_field( $name, [ 'taxonomies', $tax, 1, $add ], $label, $width, $logic, $instr, $required );
		}
	}

/* Repeater */

	// REPEATER BLOCK
	if ( ! function_exists( 'scm_acf_field_repeater' ) ) {
		function scm_acf_field_repeater( $name = '', $default = 0, $button = 'Aggiungi', $label = 'Elementi', $width = '', $logic = 0, $min = '', $max = '', $instr = '', $required = 0, $class = '' ) {
			return scm_acf_field( $name, [ 'repeater-block', $button, $min, $max ], $label, 100, $logic, $instr, $required, $class );
		}
	}

	// REPEATER ROW
	if ( ! function_exists( 'scm_acf_field_repeater_row' ) ) {
		function scm_acf_field_repeater_row( $name = '', $default = 0, $button = 'Aggiungi', $label = 'Elementi', $width = '', $logic = 0, $min = '', $max = '', $instr = '', $required = 0, $class = '' ) {
			return scm_acf_field( $name, [ 'repeater-row', $button, $min, $max ], $label, 100, $logic, $instr, $required, $class );
		}
	}

	// REPEATER TABLE
	if ( ! function_exists( 'scm_acf_field_repeater_table' ) ) {
		function scm_acf_field_repeater_table( $name = '', $default = 0, $button = 'Aggiungi', $label = 'Elementi', $width = '', $logic = 0, $min = '', $max = '', $instr = '', $required = 0, $class = '' ) {
			return scm_acf_field( $name, [ 'repeater-table', $button, $min, $max ], $label, 100, $logic, $instr, $required, $class );
		}
	}

/* Flexible Content */

	// FLEXIBLE CONTENT
	if ( ! function_exists( 'scm_acf_field_flexible' ) ) {
		function scm_acf_field_flexible( $name = '', $default = 0, $label = 'Componi', $button = '+', $width = '', $logic = 0, $min = '', $max = '', $instr = '', $required = 0, $class = '' ) {
			return scm_acf_field( $name, [ 'flexible', $button, $min, $max ], $label, 100, $logic, $instr, $required, $class );
		}
	}

// *****************************************************
// 2.0 PRESETS
// *****************************************************

	// SELECTORS
	if ( ! function_exists( 'scm_acf_preset_selectors' ) ) {
		function scm_acf_preset_selectors( $name = '', $default = 0, $w1 = 100, $w2 = 100, $logic = 0, $pl1 = 'id', $pl2 = 'class', $lb1 = 'ID', $lb2 = 'Class', $instr = '', $req = 0 ) {

			$name = ( $name ? $name . '-' : '');

			$fields = array();

			if( $instr )
				$fields[] = scm_acf_field( 'msg-open-selectors', [ 'message', $instr ], 'Aggiungi Selettori' );

			$fields[] = scm_acf_field_id( $name . 'id', $default, $w1, $logic, $pl1 , $lb1, $instr, $req );
			$fields[] = scm_acf_field_class( $name . 'class', $default, $w2, $logic, $pl2, $lb2, $instr, $req );

			return $fields;
		}
	}

	// SIZE
	if ( ! function_exists( 'scm_acf_preset_size' ) ) {
		function scm_acf_preset_size( $name = '', $default = 0, $pl1 = 'auto', $pl2 = 'px', $lb1 = 'Dimensione', $logic = 0, $w1 = 60, $w2 = 40, $lb2 = 'Unità', $instr = '', $req = 0 ) {

			$name = ( $name ? $name . '-' : '');

			$fields = array();

			if( $instr )
				$fields[] = scm_acf_field( 'msg-open-size', [ 'message', $instr ], 'Imposta ' . $lb1 );

			$fields[] = scm_acf_field_positive( $name . 'number', $default, $w1, $logic, $pl1, $lb1, '', $req );
			$fields[] = scm_acf_field_select_units( $name . 'units', $default, $w2, $logic, $pl2, $lb2, '', $req );

			return $fields;
		}
	}

	// POSITION
	if ( ! function_exists( 'scm_acf_preset_position' ) ) {
		function scm_acf_preset_position( $name = '', $default = 0, $pl1 = 'auto', $pl2 = 'px', $lb1 = 'Posizione', $logic = 0, $w1 = 60, $w2 = 40, $lb2 = 'Unità', $instr = '', $req = 0 ) {

			$name = ( $name ? $name . '-' : '');

			$fields = array();

			if( $instr )
				$fields[] = scm_acf_field( 'msg-open-position', [ 'message', $instr ], 'Imposta ' . $lb1 );

			$fields[] = scm_acf_field_number( $name . 'number', $default, $w1, $logic, $pl1, $lb1, '', $req );
			$fields[] = scm_acf_field_select_units( $name . 'units', $default, $w2, $logic, $pl2, $lb2, '', $req );

			return $fields;
		}
	}
	
	// COLOR
	if ( ! function_exists( 'scm_acf_preset_rgba' ) ) {
		function scm_acf_preset_rgba( $name = '', $default = 0, $pl1 = '', $pl2 = '1', $logic = 0, $w1 = 60, $w2 = 40, $lb2 = 'Trasparenza', $lb1 = 'Colore', $instr = '', $req = 0 ) {

			$name = ( $name ? $name . '-' : '');

			$fields = array();

			if( $instr )
				$fields[] = scm_acf_field( 'msg-open-rgba', [ 'message', $instr ], 'Imposta ' . $lb1 );

			$fields[] = scm_acf_field_color( $name . 'color', $default, $w1, $logic, $pl1, $lb1, '', $req );
			$fields[] = scm_acf_field_alpha( $name . 'alpha', $default, $w2, $logic, $pl2, $lb2, '', $req );

			return $fields;
		}
	}

	// TXT COLOR
	if ( ! function_exists( 'scm_acf_preset_rgba_txt' ) ) {
		function scm_acf_preset_rgba_txt( $name = '', $default = 0, $pl1 = '', $pl2 = '1', $logic = 0, $w1 = 60, $w2 = 40, $lb2 = 'Trasparenza', $lb1 = 'Colore Testi', $instr = '', $req = 0 ) {

			$name = ( $name ? $name . '-' : '');

			$fields = array();

			if( $instr )
				$fields[] = scm_acf_field( 'msg-open-rgba-txt', [ 'message', $instr ], 'Imposta ' . $lb1 );

			$fields[] = scm_acf_field_color( $name . 'color', $default, $w1, $logic, $pl1, $lb1, '', $req );
			$fields[] = scm_acf_field_alpha( $name . 'alpha', $default, $w2, $logic, $pl2, $lb2, '', $req );

			return $fields;
		}
	}

	// BG COLOR
	if ( ! function_exists( 'scm_acf_preset_rgba_bg' ) ) {
		function scm_acf_preset_rgba_bg( $name = '', $default = 0, $pl1 = '', $pl2 = '1', $logic = 0, $w1 = 60, $w2 = 40, $lb2 = 'Trasparenza', $lb1 = 'Colore Sfondo', $instr = '', $req = 0 ) {

			$name = ( $name ? $name . '-' : '');

			$fields = array();

			if( $instr )
				$fields[] = scm_acf_field( 'msg-open-rgba-bg', [ 'message', $instr ], 'Imposta ' . $lb1 );

			$fields[] = scm_acf_field_color( $name . 'color', $default, $w1, $logic, $pl1, $lb1, '', $req );
			$fields[] = scm_acf_field_alpha( $name . 'alpha', $default, $w2, $logic, $pl2, $lb2, '', $req );

			return $fields;
		}
	}

	// BACKGROUND STYLE
	if ( ! function_exists( 'scm_acf_preset_background_style' ) ) {
		function scm_acf_preset_background_style( $name = '', $default = 0, $width = 100, $logic = 0, $pl1 = '', $pl2 = 'center center', $pl3 = 'auto auto', $instr = '', $req = 0 ) {

			$name = ( $name ? $name . '-' : '');

			$fields = array();

			if( $instr )
				$fields[] = scm_acf_field( 'msg-open-bg-style', [ 'message', $instr ], 'Impostazioni Sfondo' );

			$fields = array_merge( $fields, scm_acf_preset_rgba_bg( $name . 'rgba', $default, $width, $logic ) );
			$fields[] = scm_acf_field_image( $name . 'image', $default, $width, $logic, 'Immagine' );
			$fields[] = scm_acf_field_select( $name . 'repeat', $default, 'bg_repeat', $width, $logic, $pl1, 'Ripetizione' );
			$fields[] = scm_acf_field_text( $name . 'position', $default, $width, $logic, $pl2, 'Posizione' );
			$fields[] = scm_acf_field_text( $name . 'size', $default, $width, $logic, $pl3, 'Dimensione' );

			return $fields;
		}
	}

	// TEXT FONT
	if ( ! function_exists( 'scm_acf_preset_text_font' ) ) {
		function scm_acf_preset_text_font( $name = '', $default = 0, $logic = 0, $w1 = 100, $w2 = 100, $w3 = 100, $instr = '', $req = 0 ) {

			$name = ( $name ? $name . '-' : '');

			$fields = array();

			if( $instr )
				$fields[] = scm_acf_field( 'msg-open-txt-font', [ 'message', $instr ], 'Impostazioni Testi' );

			$fields[] = scm_acf_field_select( $name . 'adobe', $default, 'webfonts_adobe', $w1, $logic, '', 'Adobe TypeKit' );
			$fields[] = scm_acf_field_select( $name . 'google', $default, 'webfonts_google', $w2, $logic, '', 'Google Font' );
			$fields[] = scm_acf_field_select( $name . 'fallback', $default, 'webfonts_fallback', $w3, $logic, '', 'Famiglia' );

			return $fields;
		}
	}
	
	// TEXT SET
	if ( ! function_exists( 'scm_acf_preset_text_set' ) ) {
		function scm_acf_preset_text_set( $name = '', $default = 0, $logic = 0, $w1 = 100, $w2 = 100, $w3 = 100, $instr = '', $req = 0 ) {

			$name = ( $name ? $name . '-' : '');

			$fields = array();

			if( $instr )
				$fields[] = scm_acf_field( 'msg-open-txt-settings', [ 'message', $instr ], 'Impostazioni Testi' );

			$fields[] = scm_acf_field_select( $name . 'alignment', $default, 'txt_alignment', $w1, $logic, '', 'Allineamento' );
			$fields[] = scm_acf_field_select( $name . 'size', $default, 'txt_size', $w2, $logic, '', 'Dimensione' );
			$fields[] = scm_acf_field_select( $name . 'line-height', $default, 'line_height', $w3, $logic, '', 'Interlinea' );

			return $fields;
		}
	}

	// TEXT SHADOW
	if ( ! function_exists( 'scm_acf_preset_text_shadow' ) ) {
		function scm_acf_preset_text_shadow( $name = '', $default = 0, $logic = 0, $instr = '', $req = 0 ) {

			$name = ( $name ? $name . '-' : '');

			$fields = array();

			if( $instr )
				$fields[] = scm_acf_field( 'msg-open-txt-shadow', [ 'message', $instr ], 'Impostazioni Testi' );

			$fields = array_merge( $fields, scm_acf_preset_position( $name . 'x', $default, '1', 'px', 'X', $logic ) );
			$fields = array_merge( $fields, scm_acf_preset_position( $name . 'y', $default, '1', 'px', 'Y', $logic ) );
			$fields = array_merge( $fields, scm_acf_preset_size( $name . 'size', $default, '1', 'px', 'Dimensione', $logic ) );
			$fields = array_merge( $fields, scm_acf_preset_rgba( $name . 'color', $default, '#000000', '0.5', $logic ) );

			return $fields;
		}
	}

	// TEXT STYLE
	if ( ! function_exists( 'scm_acf_preset_text_style' ) ) {
		function scm_acf_preset_text_style( $name = '', $default = 0, $instr = '', $req = 0 ) {

			$name = ( $name ? $name . '-' : '');

			$fields = array();

			if( $instr )
				$fields[] = scm_acf_field( 'msg-open-txt-style', [ 'message', $instr ], 'Impostazioni Testi' );

			$fields = array_merge( $fields, scm_acf_preset_rgba_txt( $name . 'rgba', $default ) );
			$fields = array_merge( $fields, scm_acf_preset_text_font( $name . 'webfonts', $default ) );
			$fields = array_merge( $fields, scm_acf_preset_text_set( $name . 'set', $default ) );

			// conditional ombra
			$fields[] = scm_acf_field_select_disable( $name . 'shadow', $default, 'Attiva Ombra' );
			$condition = [[[
				'field' => $name . 'shadow',
				'operator' => '==',
				'value' => 'on',
			]]];
				
				$fields = array_merge( $fields, scm_acf_preset_text_shadow( $name . 'shadow', $default, $condition ) );

			return $fields;
		}
	}

	// BOX STYLE
	if ( ! function_exists( 'scm_acf_preset_box_style' ) ) {
		function scm_acf_preset_box_style( $name = '', $default = 0, $instr = '', $req = 0 ) {

			$name = ( $name ? $name . '-' : '');

			$fields = array();

			if( $instr )
				$fields[] = scm_acf_field( 'msg-open-box-style', [ 'message', $instr ], 'Impostazioni Box' );

			$fields[] = scm_acf_field_text( $name . 'margin', $default, 100, 0, '0 0 0 0', 'Margin' );
			$fields[] = scm_acf_field_text( $name . 'padding', $default, 100, 0, '0 0 0 0', 'Padding' );
			$fields[] = scm_acf_field_alpha( $name . 'alpha', $default, 100, 0, '1', 'Trasparenza' );

			return $fields;

		}
	}

	// TERM
	if ( ! function_exists( 'scm_acf_preset_term' ) ) {
		function scm_acf_preset_term( $name = 'term', $default = 0, $tax = 'category', $add = 1, $placeholder = 'Termine', $logic = 0, $w1 = '', $w2 = 40, $lb1 = 'Seleziona', $lb2 = 'Aggiungi', $instr = '', $required = 0, $class = '' ) {
			
			$name = ( $name ? $name . '-' : '');
			$w1 = ( $w1 ?: ( $add ? 60 : 100 ) );

			$fields = array();

			if( $instr )
				$fields[] = scm_acf_field( 'msg-open-term', [ 'message', $instr ], $placeholder );

			$fields[] = scm_acf_field_taxonomy( $name . 'terms', $default, $tax, $add, $lb1 . ' ' . $placeholder, $w1, $logic );
			if( $add )
				$fields[] = scm_acf_field_text( $name . 'new-term', $default, $w2, $logic, $placeholder . ' 1, ' . $placeholder . ' 2', $lb2 . ' ' . $placeholder, ' + ' );

			return $fields;
		}
	}

	// TERMS
	if ( ! function_exists( 'scm_acf_preset_terms' ) ) {
		function scm_acf_preset_terms( $name = 'terms', $default = 0, $tax = 'category', $add = 1, $placeholder = 'Termini', $logic = 0, $w1 = '', $w2 = 40, $lb1 = 'Seleziona', $lb2 = 'Aggiungi', $instr = '', $required = 0, $class = '' ) {
			
			$name = ( $name ? $name . '-' : '');
			$w1 = ( $w1 ?: ( $add ? 60 : 100 ) );

			$fields = array();

			if( $instr )
				$fields[] = scm_acf_field( 'msg-open-terms', [ 'message', $instr ], $placeholder );

			$fields[] = scm_acf_field_taxonomies( $name . 'terms', $default, $tax, $add, $lb1 . ' ' . $placeholder, $w1, $logic );
			if( $add )
				$fields[] = scm_acf_field_text( $name . 'new-term', $default, $w2, $logic, $placeholder . ' 1, ' . $placeholder . ' 2', $lb2 . ' ' . $placeholder, ' + ' );

			return $fields;
		}
	}

	// TAXONOMY
	if ( ! function_exists( 'scm_acf_preset_taxonomy' ) ) {
		function scm_acf_preset_taxonomy( $name = 'taxonomy', $default = 0, $type = 'post', $add = 1, $placeholder = 'Gestisci Relazioni', $logic = 0, $w1 = '', $w2 = 40, $lb1 = 'Seleziona', $lb2 = 'Aggiungi', $instr = '', $required = 0, $class = '' ) {
			
			$name = ( $name ? $name . '-' : '');
			$w1 = ( $w1 ?: ( $add ? 60 : 100 ) );

			$fields = array();

			if( $instr )
				$fields[] = scm_acf_field( 'msg-open-' . $name, [ 'message', $instr ], $placeholder );

			$taxes = get_object_taxonomies( $type, 'objects' );
			reset( $taxes );
			foreach ($taxes as $key => $value) {
				$fields = array_merge( $fields, scm_acf_preset_term( $name . '-' . $value->name, $default, $value->name, $add, $value->label, $logic, $w1, $w2, $lb1, $lb2, '', $required, $class ) );
			}

			return $fields;
		}
	}

	// TAXONOMIES
	if ( ! function_exists( 'scm_acf_preset_taxonomies' ) ) {
		function scm_acf_preset_taxonomies( $name = 'taxonomies', $default = 0, $type = 'post', $add = 1, $placeholder = 'Gestisci Relazioni', $logic = 0, $w1 = '', $w2 = 40, $lb1 = 'Seleziona', $lb2 = 'Aggiungi', $instr = '', $required = 0, $class = '' ) {
			
			$name = ( $name ? $name . '-' : '');
			

			$fields = array();

			if( $instr )
				$fields[] = scm_acf_field( 'msg-open-' . $name, [ 'message', $instr ], $placeholder );

			$taxes = get_object_taxonomies( $type, 'objects' );
			$w1 = ( $w1 ?: ( $add ? 60 : ( sizeof( $taxes ) ? 100 / sizeof( $taxes ) : 100 ) ) );

			reset( $taxes );
			foreach ($taxes as $key => $value) {
				$fields = array_merge( $fields, scm_acf_preset_terms( $name . '-' . $value->name, $default, $value->name, $add, $value->label, $logic, $w1, $w2, $lb1, $lb2, '', $required, $class ) );
			}

			return $fields;
		}
	}

	// CATEGORY
	if ( ! function_exists( 'scm_acf_preset_category' ) ) {
		function scm_acf_preset_category( $name = 'category', $default = 0, $type = 'post', $add = 1, $placeholder = 'Gestisci Categorie', $logic = 0, $w1 = '', $w2 = 40, $lb1 = 'Seleziona', $lb2 = 'Aggiungi', $instr = '', $required = 0, $class = '' ) {
			
			$name = ( $name ? $name . '-' : '');
			$w1 = ( $w1 ?: ( $add ? 60 : 100 ) );

			$fields = array();

			if( $instr )
				$fields[] = scm_acf_field( 'msg-open-' . $name, [ 'message', $instr ], $placeholder );

			$taxes = get_object_taxonomies( $type, 'objects' );
			reset( $taxes );
			foreach ($taxes as $key => $value) {
				if( $value->hierarchical )
					$fields = array_merge( $fields, scm_acf_preset_term( $name . '-' . $value->name, $default, $value->name, $add, $value->label, $logic, $w1, $w2, $lb1, $lb2, '', $required, $class ) );
			}

			return $fields;
		}
	}

	// CATEGORIES
	if ( ! function_exists( 'scm_acf_preset_categories' ) ) {
		function scm_acf_preset_categories( $name = 'categories', $default = 0, $type = 'post', $add = 1, $placeholder = 'Gestisci Categorie', $logic = 0, $w1 = '', $w2 = 40, $lb1 = 'Seleziona', $lb2 = 'Aggiungi', $instr = '', $required = 0, $class = '' ) {
			
			$name = ( $name ? $name . '-' : '');
			$w1 = ( $w1 ?: ( $add ? 60 : 100 ) );

			$fields = array();

			if( $instr )
				$fields[] = scm_acf_field( 'msg-open-' . $name, [ 'message', $instr ], $placeholder );

			$taxes = get_object_taxonomies( $type, 'objects' );
			reset( $taxes );
			foreach ($taxes as $key => $value) {
				if( $value->hierarchical )
					$fields = array_merge( $fields, scm_acf_preset_terms( $name . '-' . $value->name, $default, $value->name, $add, $value->label, $logic, $w1, $w2, $lb1, $lb2, '', $required, $class ) );
			}

			return $fields;
		}
	}

	// TAG
	if ( ! function_exists( 'scm_acf_preset_tag' ) ) {
		function scm_acf_preset_tag( $name = 'tag', $default = 0, $type = 'post_tag', $add = 1, $placeholder = 'Gestisci Tag', $logic = 0, $w1 = '', $w2 = 40, $lb1 = 'Seleziona', $lb2 = 'Aggiungi', $instr = '', $required = 0, $class = '' ) {
			
			$name = ( $name ? $name . '-' : '');
			$w1 = ( $w1 ?: ( $add ? 60 : 100 ) );

			$fields = array();

			if( $instr )
				$fields[] = scm_acf_field( 'msg-open-' . $name, [ 'message', $instr ], $placeholder );

			$taxes = get_object_taxonomies( $type, 'objects' );
			reset( $taxes );
			foreach ($taxes as $key => $value) {
				if( !$value->hierarchical )
					$fields = array_merge( $fields, scm_acf_preset_term( $name . '-' . $value->name, $default, $value->name, $add, $value->label, $logic, $w1, $w2, $lb1, $lb2, '', $required, $class ) );
			}

			return $fields;
		}
	}

	// TAGS
	if ( ! function_exists( 'scm_acf_preset_tags' ) ) {
		function scm_acf_preset_tags( $name = 'tags', $default = 0, $type = 'post_tag', $add = 1, $placeholder = 'Gestisci Tags', $logic = 0, $w1 = '', $w2 = 40, $lb1 = 'Seleziona', $lb2 = 'Aggiungi', $instr = '', $required = 0, $class = '' ) {
			
			$name = ( $name ? $name . '-' : '');
			$w1 = ( $w1 ?: ( $add ? 60 : 100 ) );

			$fields = array();

			if( $instr )
				$fields[] = scm_acf_field( 'msg-open-' . $name, [ 'message', $instr ], $placeholder );

			$taxes = get_object_taxonomies( $type, 'objects' );
			reset( $taxes );
			foreach ($taxes as $key => $value) {
				if( !$value->hierarchical )
					$fields = array_merge( $fields, scm_acf_preset_terms( $name . '-' . $value->name, $default, $value->name, $add, $value->label, $logic, $w1, $w2, $lb1, $lb2, '', $required, $class ) );
			}

			return $fields;
		}
	}

	// COLUMNS
	if ( ! function_exists( 'scm_acf_preset_repeater_columns' ) ) {
		function scm_acf_preset_repeater_columns( $name = 'repeater', $default = 0, $elements = '', $logic = 0, $instr = '', $required = 0, $class = 'special-repeater' ) {

			$fields = array();

			$columns = scm_acf_field_repeater( $name . '-columns', $default, 'Aggiungi Colonna', 'Colonne', 100, $logic, '', '', $instr, $required, $class );

				$columns['sub_fields'][] = scm_acf_field_select_column_width( 'column-width',  $default, 36, 0, '1/1', 'Larghezza' );
				$columns['sub_fields'] = array_merge( $columns['sub_fields'], scm_acf_preset_selectors( '', $default, 24, 36 ) );
				$columns['sub_fields'] = array_merge( $columns['sub_fields'], scm_acf_preset_flexible_elements( 'build', $default, $elements ) );
				
			$fields[] = $columns;
			
			return $fields;
		}
	}

	// SECTIONS
	if ( ! function_exists( 'scm_acf_preset_flexible_rows' ) ) {
		function scm_acf_preset_flexible_rows( $name = 'flexible', $default = 0, $logic = 0, $instr = '', $required = 0, $class = '' ) {

			$fields = array();

			$sections = scm_acf_field_flexible( $name . '-rows', $default, 'Righe', '+', 100, $logic, '', '', $instr, $required, $class );

				$layout = scm_acf_layout( 'sections', 'block', 'Sezione' );
					$layout['sub_fields'][] = scm_acf_field_object( 'section', $default, 'sections', 33, 0, 'Sezione' );
					$layout['sub_fields'] = array_merge( $layout['sub_fields'], scm_acf_preset_selectors( 'section-selectors', $default, 33, 33 ) );
					$layout['sub_fields'][] = scm_acf_field( 'section-attributes', 'attributes', 'Attributi' );
					$layout['sub_fields'] = scm_acf_column_width( 'column-width', $layout['sub_fields'] );
				$sections['layouts'][] = $layout;

			$fields[] = $sections;
			
			return $fields;
		}
	}

	// LAYOUTS ( vedi scm-acf-layouts.php )
	if ( ! function_exists( 'scm_acf_preset_flexible_elements' ) ) {
		function scm_acf_preset_flexible_elements( $name = 'flexible', $default = 0, $elements = '', $logic = 0, $instr = '', $required = 0, $class = '' ) {

			global $SCM_acf_objects;

			$fields = array();

			$flexible = scm_acf_field_flexible( $name . '-elements', $default, 'Componi', '+', 100, $logic, '', '', $instr, $required, $class );

				/*$all = [
					'posts' => __( 'Post', SCM_THEME ),
					'divider' => __( 'Separatore', SCM_THEME ),
				    'image' => __( 'Immagine', SCM_THEME ),
				    'icon' => __( 'Icona', SCM_THEME ),
				    'title' => __( 'Titolo', SCM_THEME ),
				    'text' => __( 'Testo', SCM_THEME ),
				    'list' => __( 'Elenco Puntato', SCM_THEME ),
				    'links' => __( 'Elenco Link', SCM_THEME ),
				    'files' => __( 'Elenco File', SCM_THEME ),
				    'section' => __( 'Sezione', SCM_THEME ),
				];*/

				if( !$elements )
					$elements = $SCM_acf_objects;
				if( !is_array( $elements ) )
					$elements = [ $elements ];

				foreach ($elements as $key) {

					$low = str_replace( '_', ' ', $key);
					$element = ucwords( $low );

					$layout = scm_acf_layout( $key, 'block', $element );

					if( function_exists( 'scm_acf_object_' . $key ) )
						$layout['sub_fields'] = array_merge( $layout['sub_fields'], call_user_func( 'scm_acf_object_' . $key, $default ) ); // Call Elements function in scm-acf-layouts.php
					else
						consoleLog( 'No Flexible Element found: ' . 'scm_acf_object_' . $key );
					
					$layout['sub_fields'] = scm_acf_column_width( 'column-width', $layout['sub_fields'] );

					if( $layout )
						$flexible['layouts'][] = $layout;
					
				}

			$fields[] = $flexible;
			
			return $fields;
		}
	}

// *****************************************************
// 3.0 FIELDS
// *****************************************************

	// TEMPLATES
	if ( ! function_exists( 'scm_acf_fields_template' ) ) {
		function scm_acf_fields_template( $name = '', $default = 0, $logic = 0, $instr = 'Costruisci dei modelli da poter poi scegliere durante la creazione di nuovi contenuti. Per ogni modello è obbligatorio inserire almeno il Nome.', $required = 0, $class = 'posts-repeater' ) {

			if( !$name )
				return;

			$fields = array();

			$template = scm_acf_field_repeater( $name . '-templates', $default, 'Aggiungi Modello', 'Modelli', 100, $logic, '', '', $instr, $required, $class );

				$template['sub_fields'][] = scm_acf_field_name( 'name',  $default, '', 60, 0, 'Nome Modello', 'Nome' );
				$template['sub_fields'][] = scm_acf_field( 'id', [ 'text-read', '', '0', 'ID' ], 'ID', 40 );
			
			$fields[] = $template;

			return $fields;
		}
	}

	// PAGES
	if ( ! function_exists( 'scm_acf_fields_page' ) ) {
		function scm_acf_fields_page( $name = '', $default = 0 ) {

			$name = ( $name ? $name . '-' : '');

			$fields = scm_acf_preset_selectors( $name . 'page-selectors', $default, 50, 50 );

			$fields[] = scm_acf_field_select( $name . 'page-menu', $default, 'wp_menu', 100, 0, '', 'Menu Principale' );
			
			$fields = array_merge( $fields, scm_acf_preset_flexible_rows( $name . 'page', $default ) );

			return $fields;
		}
	}
	
	// SECTIONS
	if ( ! function_exists( 'scm_acf_fields_section' ) ) {
		function scm_acf_fields_section( $name = '', $default = 0, $elements = '' ) {

			$name = ( $name ? $name . '-' : '');

			$fields = scm_acf_preset_selectors( $name . 'row', $default, 50, 50 );

            $fields[] = scm_acf_field_select_layout( $name . 'row-layout', $default, 'Layout', 50 );

			$fields[] = scm_acf_field( $name . 'row-attributes', 'attributes', 'Attributi', 50 );
						
			$fields = array_merge( $fields, scm_acf_preset_repeater_columns( $name . 'row', $default, $elements ) );

			return $fields;
		}
	}

	// SLIDES
	if ( ! function_exists( 'scm_acf_fields_slide' ) ) {
		function scm_acf_fields_slide( $name = '', $default = 0 ) {

			$name = ( $name ? $name . '-' : '');

			$fields = array();

			/*$fields[] = scm_acf_field( 'tab-slide', 'tab', 'Slide' );
			$fields[] = scm_acf_field_taxonomy( $name . 'slide-tax', $default, 'sliders', 'Sliders' );*/
			$fields[] = scm_acf_field( 'tab-tax-slide', 'tab-left', 'Relazioni' );
				$fields = array_merge( $fields, scm_acf_preset_taxonomies( $name . 'slide-tax', $default, 'slides' ) );

			// conditional link
			$fields[] = scm_acf_field_select( $name . 'slide-link', $default, 'links_type', 50, 0, '', 'Link' );

			$link = [[[
				'field' => $name . 'slide-link',
				'operator' => '==',
				'value' => 'link',
			]]];

			$page = [[[
				'field' => $name . 'slide-link',
				'operator' => '==',
				'value' => 'page',
			]]];

				$fields[] = scm_acf_field_link( $name . 'slide-external', $default, 50, $link );
				$fields[] = scm_acf_field_object_link( $name . 'slide-internal', $default, 'page', 50, $page );

			$fields[] = scm_acf_field_image( $name . 'slide-image', $default );

			$fields[] = scm_acf_field( 'tab-slide-caption', 'tab', 'Didascalia' );
			// conditional caption
			$fields[] = scm_acf_field_select_disable( $name . 'slide-caption', $default, 'Didascalia' );

			$caption = [[[
				'field' => $name . 'slide-caption',
				'operator' => '==',
				'value' => 'on',
			]]];

				$fields[] = scm_acf_field( $name . 'slide-caption-top', [ 'percent', '', '0' ], 'Dal lato alto', 25, $caption );
				$fields[] = scm_acf_field( $name . 'slide-caption-right', [ 'percent', '', '0' ], 'Dal lato destro', 25, $caption );
				$fields[] = scm_acf_field( $name . 'slide-caption-bottom', [ 'percent', '', '0' ], 'Dal lato basso', 25, $caption );
				$fields[] = scm_acf_field( $name . 'slide-caption-left', [ 'percent', '', '0' ], 'Dal lato sinistro', 25, $caption );

				$fields[] = scm_acf_field( $name . 'slide-caption-title', [ 'text', '', 'Titolo didascalia', 'Titolo' ], 'Titolo didascalia', 100, $caption );
				$fields[] = scm_acf_field( $name . 'slide-caption-cont', 'editor-visual-basic-media', 'Contenuto didascalia', 100, $caption );

			$fields[] = scm_acf_field( 'tab-slide-adv', 'tab', 'Avanzate' );
				$fields = array_merge( $fields, scm_acf_preset_selectors( $name . 'slide-selectors', $default, 50, 50 ) );

			return $fields;

		}
	}

	// ARTICOLI
	if ( ! function_exists( 'scm_acf_fields_articolo' ) ) {
		function scm_acf_fields_articolo( $name = '', $default = 0 ) {

			$name = ( $name ? $name . '-' : '');

			$fields = array();

			$fields[] = scm_acf_field( 'tab-set-post', 'tab-left', 'Impostazioni' );
				$fields[] = scm_acf_field_image( $name . 'post-image', $default );
				$fields[] = scm_acf_field_limiter( $name . 'post-excerpt', $default, 350, 1, 100, 0, 'Anteprima' );
				$fields[] = scm_acf_field_editor( $name . 'post-content', $default );

			$fields[] = scm_acf_field( 'tab-tax-post', 'tab-left', 'Relazioni' );
				$fields = array_merge( $fields, scm_acf_preset_taxonomies( $name . 'post-tax', $default, 'post' ) );
				//$fields[] = scm_acf_field_category( $name . 'post-cat', $default, 'post' );

			return $fields;

		}
	}

	// RASSEGNE STAMPA
	if ( ! function_exists( 'scm_acf_fields_rassegna' ) ) {
		function scm_acf_fields_rassegna( $name = '', $default = 0 ) {

			$name = ( $name ? $name . '-' : '');

			$fields = array();

			$fields[] = scm_acf_field( 'tab-set-rassegna', 'tab-left', 'Impostazioni' );
				// conditional link
				$fields[] = scm_acf_field_select( $name . 'rassegna-type', $default, 'rassegne_type', 100, 0, '', 'Articolo' );

				$link = [[[
					'field' => $name . 'rassegna-type',
					'operator' => '==',
					'value' => 'link',
				]]];

				$file = [[[
					'field' => $name . 'rassegna-type',
					'operator' => '==',
					'value' => 'file',
				]]];

					$fields[] = scm_acf_field_file( $name . 'rassegna-file', $default, 100, $file );
					$fields[] = scm_acf_field_link( $name . 'rassegna-link', $default, 100, $link );

				
				$fields[] = scm_acf_field( $name . 'rassegna-data', 'date', 'Data' );

			$fields[] = scm_acf_field( 'tab-tax-rassegna', 'tab-left', 'Relazioni' );
				$fields = array_merge( $fields, scm_acf_preset_taxonomies( $name . 'rassegna-tax', $default, 'rassegne-stampa' ) );
				//$fields = array_merge( $fields, scm_acf_preset_terms( $name . 'autore', $default, 'rassegne-autori', 1, 'Autori' ) );
				//$fields = array_merge( $fields, scm_acf_preset_terms( $name . 'testata', $default, 'rassegne-testate', 1, 'Testate' ) );
			
			return $fields;

		}
	}

	// DOCUMENTI
	if ( ! function_exists( 'scm_acf_fields_documento' ) ) {
		function scm_acf_fields_documento( $name = '', $default = 0 ) {

			$name = ( $name ? $name . '-' : '');

			$fields = array();

			$fields[] = scm_acf_field( 'tab-set-documento', 'tab-left', 'Impostazioni' );
				$fields[] = scm_acf_field_file( $name . 'documento-file', $default );

			$fields[] = scm_acf_field( 'tab-tax-documento', 'tab-left', 'Relazioni' );
				$fields = array_merge( $fields, scm_acf_preset_taxonomies( $name . 'documento-tax', $default, 'documenti' ) );
			//$fields[] = scm_acf_field_category( $name . 'documento-cat', $default, 'documenti' );

			return $fields;

		}
	}
	
	// GALLERIE
	if ( ! function_exists( 'scm_acf_fields_galleria' ) ) {
		function scm_acf_fields_galleria( $name = '', $default = 0 ) {

			$name = ( $name ? $name . '-' : '');

			$fields = array();

			$fields[] = scm_acf_field( 'tab-set-galleria', 'tab-left', 'Impostazioni' );
				$fields[] = scm_acf_field( $name . 'galleria-images', 'gallery', 'Immagini' );

			$fields[] = scm_acf_field( 'tab-tax-galleria', 'tab-left', 'Relazioni' );
				$fields = array_merge( $fields, scm_acf_preset_taxonomies( $name . 'galleria-tax', $default, 'gallerie' ) );
			//$fields[] = scm_acf_field_category( $name . 'galleria-cat', $default, 'gallerie' );

			return $fields;

		}
	}
	
	// VIDEO
	if ( ! function_exists( 'scm_acf_fields_video' ) ) {
		function scm_acf_fields_video( $name = '', $default = 0 ) {

			$name = ( $name ? $name . '-' : '');

			$fields = array();

			$fields[] = scm_acf_field( 'tab-set-video', 'tab-left', 'Impostazioni' );
				$fields[] = scm_acf_field( $name . 'video-url', 'video', 'Link a YouTube' );

			$fields[] = scm_acf_field( 'tab-tax-video', 'tab-left', 'Relazioni' );
				$fields = array_merge( $fields, scm_acf_preset_taxonomies( $name . 'video-tax', $default, 'video' ) );
			//$fields[] = scm_acf_field_category( $name . 'video-cat', $default, 'video' );

			return $fields;

		}
	}

	// LUOGHI
	if ( ! function_exists( 'scm_acf_fields_luogo' ) ) {
		function scm_acf_fields_luogo( $name = '', $default = 0 ) {

			$name = ( $name ? $name . '-' : '');

			$fields = array();

			$fields[] = scm_acf_field( 'tab-set-luogo', 'tab', 'Impostazioni' );
				
				$fields[] = scm_acf_field( 'msg-luogo-nome', [
					'message',
					'Il campo Nome è utile per differenziare più luoghi che fanno riferimento ad un unico Soggetto ( es. Sede Operativa, Distaccamento, ...).'
				], 'Specifica un Nome' );

					$fields[] = scm_acf_field_name( $name . 'luogo-nome', $default );

				$fields[] = scm_acf_field( 'msg-luogo-dati', [
					'message',
					'Più dettagliati sono i dati geografici, più preciso sarà il puntatore sulla mappa.
	Nello stesso tempo, più dati si inseriscono, più lungo e completo sarà l\'indirizzo, dove presente.
	Se inseriti tutti, l\'indirizzo risulterà: Indirizzo — Codice Postale, Località, Frazione, (Provincia) — Regione, Paese.',
				], 'Dati geografici' );

					$fields[] = scm_acf_field_text( $name . 'luogo-indirizzo', $default, 33, 0, 'Corso Giulio Cesare 1', 'Indirizzo' );
					$fields[] = scm_acf_field_text( $name . 'luogo-citta', $default, 33, 0, 'Roma', 'Città' );
					$fields[] = scm_acf_field_text( $name . 'luogo-frazione', $default, 33, 0, 'S. Pietro', 'Frazione' );
					$fields[] = scm_acf_field_text( $name . 'luogo-provincia', $default, 33, 0, 'RM', 'Provincia' );
					$fields[] = scm_acf_field_text( $name . 'luogo-cap', $default, 33, 0, '12345', 'CAP' );
					$fields[] = scm_acf_field_text( $name . 'luogo-regione', $default, 33, 0, 'Lazio', 'Regione' );
					$fields[] = scm_acf_field_text( $name . 'luogo-paese', $default, 33, 0, 'Italy', 'Paese' );

			$fields[] = scm_acf_field( 'tab-luogo-icone', 'tab', 'Icone' );

				$fields[] = scm_acf_field( 'msg-luogo-icona', [
					'message',
					'Verrà utilizzata sulle mappe per indicare questo esatto luogo.
	Comparirà anche nella legenda, se sulla mappa sono presenti più luoghi.',
				], 'Carica un\'icona', 25 );

					$fields[] = scm_acf_field_image( $name . 'luogo-marker', $default, 25, 0, 'Map Marker' );

				$fields[] = scm_acf_field( 'msg-luogo-icon', [
					'message',
					'Icona utilizzata per precedere l\'indirizzo, se ne è prevista la presenza.',
				], 'Seleziona un\'icona', 25 );

					$fields[] = scm_acf_field_icon( $name . 'luogo-icon', $default, 'map-marker', 25, 0, 'Icona Indirizzo' );

			$fields[] = scm_acf_field( 'tab-tax-luogo', 'tab-left', 'Relazioni' );
				$fields = array_merge( $fields, scm_acf_preset_taxonomies( $name . 'luogo-tax', $default, 'luoghi' ) );

			$fields[] = scm_acf_field( 'tab-luogo-coord', 'tab', 'Coordinate' );

				$fields[] = scm_acf_field( 'msg-luogo-coord', [
					'message',
					'Questi valori vengono calcolati automaticamente in base ai dati inseriti nella sezione Luogo.',
				], 'Dati automatici', 40 );

					$fields[] = scm_acf_field( $name . 'luogo-lat', [ 'number-read', '', '0', 'Lat.' ], 'Latitude', 30 );
					$fields[] = scm_acf_field( $name . 'luogo-lng', [ 'number-read', '', '0', 'Long.' ], 'Longitude', 30 );

			return $fields;

		}
	}

	// CONTATTI
	if ( ! function_exists( 'scm_acf_fields_contatto' ) ) {
		function scm_acf_fields_contatto( $name = '', $default = 0 ) {

			$name = ( $name ? $name . '-' : '');

			$fields = array();

			$fields[] = scm_acf_field( 'tab-contatto-numeri', 'tab', 'Numeri' );

				$numeri = scm_acf_field( $name . 'contatto-num', [ 'repeater-table', 'Aggiungi Numero' ], 'Elenco Numeri' );
					$numeri['sub_fields'][] = scm_acf_field_icon( 'num-icon', $default, 'phone', 15, 0, 'Icona Numero' );
					$numeri['sub_fields'][] = scm_acf_field( 'num-title', [ 'radio-contact_num', '', 1, 1 ], 'Nome', 35 );
					$numeri['sub_fields'][] = scm_acf_field_phone( 'num-data', $default, 50 );
				$fields[] = $numeri;

			$fields[] = scm_acf_field( 'tab-contatto-email', 'tab', 'Email' );

				$email = scm_acf_field( $name . 'contatto-email', [ 'repeater-table', 'Aggiungi Email' ], 'Elenco Email' );
					$email['sub_fields'][] = scm_acf_field_icon( 'email-icon', $default, 'envelope', 15, 0, 'Icona Email' );
					$email['sub_fields'][] = scm_acf_field( 'email-title', [ 'radio-contact_email', '', 1, 1 ], 'Nome', 35 );
					$email['sub_fields'][] = scm_acf_field_email( 'email-data', $default, 50 );
				$fields[] = $email;

			$fields[] = scm_acf_field( 'tab-contatto-link', 'tab', 'Link' );

				$link = scm_acf_field( $name . 'contatto-link', [ 'repeater-table', 'Aggiungi Link' ], 'Elenco Link' );
					$link['sub_fields'][] = scm_acf_field_icon( 'link-icon', $default, 'globe', 15, 0, 'Icona Link' );
					$link['sub_fields'][] = scm_acf_field( 'link-title', [ 'radio-contact_link', '', 1, 1 ], 'Nome', 35 );
					$link['sub_fields'][] = scm_acf_field_link( 'link-data', $default, 50 );
				$fields[] = $link;

			return $fields;

		}
	}

	// SOGGETTI
	if ( ! function_exists( 'scm_acf_fields_soggetto' ) ) {
		function scm_acf_fields_soggetto( $name = '', $default = 0 ) {

			$name = ( $name ? $name . '-' : '');

			$fields = array();

			/*$fields[] = scm_acf_field( 'tab-soggetto-tipo', 'tab-left', 'Tipologie' );
				$fields[] = scm_acf_field_categories( $name . 'soggetto-cat', $default, 'soggetti' );*/

			

			$fields[] = scm_acf_field( 'tab-soggetto-logo', 'tab-left', 'Loghi' );
				$fields[] = scm_acf_field_image( $name . 'soggetto-logo', $default, 50, 0, 'Logo' );
				$fields[] = scm_acf_field_image( $name . 'soggetto-logo-neg', $default, 50, 0, 'Logo negativo' );

			$fields[] = scm_acf_field( 'tab-soggetto-icona', 'tab-left', 'Icone' );
				$fields[] = scm_acf_field_image( $name . 'soggetto-icona', $default, 50, 0, 'Icona' );
				$fields[] = scm_acf_field_image( $name . 'soggetto-icona-neg', $default, 50, 0, 'Icona negativo' );

			$fields[] = scm_acf_field( 'tab-soggetto-luogo', 'tab-left', 'Luoghi' );
				$fields[] = scm_acf_field_objects( $name . 'soggetto-luoghi', $default, 'luoghi', 100, 0, 'Luoghi' );

			$fields[] = scm_acf_field( 'tab-soggetto-dati', 'tab-left', 'Dati' );
				$fields[] = scm_acf_field_link( $name . 'soggetto-link', $default );
				$fields[] = scm_acf_field_text( $name . 'soggetto-intestazione', $default, 100, 0, 'intestazione', 'Intestazione' );
				$fields[] = scm_acf_field_text( $name . 'soggetto-piva', $default, 100, 0, '0123456789101112', 'P.IVA' );
				$fields[] = scm_acf_field_text( $name . 'soggetto-cf', $default, 100, 0, 'AAABBB123', 'Codice Fiscale' );

			$fields[] = scm_acf_field( 'tab-tax-soggetto', 'tab-left', 'Relazioni' );
				$fields = array_merge( $fields, scm_acf_preset_taxonomies( $name . 'soggetto-tax', $default, 'soggetti' ) );

			return $fields;

		}
	}

// *****************************************************
// 4.0 OPTIONS
// *****************************************************

	// TYPES OPTIONS
	if ( ! function_exists( 'scm_acf_options_types' ) ) {
		function scm_acf_options_types( $name = '', $default = 0 ) {

			$name = ( $name ? $name . '-' : '' );

			$fields = array();

			$types = scm_acf_field_repeater( $name . 'types-list', $default, 'Aggiungi Type', 'Types' );

				$types['sub_fields'][] = scm_acf_field( 'tab-labels', 'tab-left', 'Labels' );
					$types['sub_fields'][] = scm_acf_field_text_req( 'plural', $default, 100, 0, 'Produzioni', 'Plurale' );
					$types['sub_fields'][] = scm_acf_field_text( 'singular', $default, 100, 0, 'Produzione', 'Singolare' );
					$types['sub_fields'][] = scm_acf_field_text( 'slug', $default, 100, 0, 'produzioni', 'Slug' );
					$types['sub_fields'][] = scm_acf_field_text( 'short-singular', $default, 100, 0, 'Prod.', 'Singolare Corto' );
					$types['sub_fields'][] = scm_acf_field_text( 'short-plural', $default, 100, 0, 'Prods.', 'Plurale Corto' );

				$types['sub_fields'][] = scm_acf_field( 'tab-admin', 'tab-left', 'Admin' );
					$types['sub_fields'][] = scm_acf_field_select_disable( 'active', $default, 'Attivazione' );
					$types['sub_fields'][] = scm_acf_field_select_disable( 'public', $default, 'Pubblico' );
					$types['sub_fields'][] = scm_acf_field_text( 'icon', $default, 50, 0, 'f111', 'Icona', 'Icona', '', 'Visita <a href="https://developer.wordpress.org/resource/dashicons/" target="_blank">https://developer.wordpress.org/resource/dashicons/</a> per un elenco delle icone disponibili e dei corrispettivi codici, da inserire nel seguente campo.' );
					$types['sub_fields'][] = scm_acf_field_number( 'menu', $default, 50, 0, '0', 'Zona Menu', 0, 3 );

				$types['sub_fields'][] = scm_acf_field( 'tab-archive', 'tab-left', 'Archivi' );
					$types['sub_fields'][] = scm_acf_field_select( 'orderby', $default, 'orderby', 100, 0, '', 'Ordina per' );
					$types['sub_fields'][] = scm_acf_field_select( 'ordertype', $default, 'ordertype', 100, 0, '', 'Ordinamento' );
			
			$fields[] = $types;

			return $fields;
		}
	}

	// TAXONOMIES OPTIONS
	if ( ! function_exists( 'scm_acf_options_taxonomies' ) ) {
		function scm_acf_options_taxonomies( $name = '', $default = 0 ) {

			$name = ( $name ? $name . '-' : '' );

			$fields = array();

			$taxes = scm_acf_field_repeater( $name . 'taxonomies-list', $default, 'Aggiungi Taxonomy', 'Taxonomies' );

				$taxes['sub_fields'][] = scm_acf_field( 'hierarchical', [ 'select' . ( $default ? '-default' : '' ), [ 'Categoria', 'Tag' ] ], 'Seleziona Tipologia' );
				$taxes['sub_fields'][] = scm_acf_field_text_req( 'plural', $default, 100, 0, 'Nome Categorie', 'Plurale' );
				$taxes['sub_fields'][] = scm_acf_field_text( 'singular', $default, 100, 0, 'Nome Categoria', 'Singolare' );
				$taxes['sub_fields'][] = scm_acf_field_text( 'slug', $default, 100, 0, 'slug-categoria', 'Slug' );
				$taxes['sub_fields'][] = scm_acf_field( 'types', [ 'select2-multi-types_complete-horizontal' . ( $default ? '-default' : '' ) ], 'Seleziona Locations' );

			$fields[] = $taxes;

			return $fields;
		}
	}

	// GENERAL OPTIONS
	if ( ! function_exists( 'scm_acf_options_general' ) ) {
		function scm_acf_options_general( $name = '', $default = 0 ) {

			$name = ( $name ? $name . '-' : '' );

			$fields = array();

			$fields[] = scm_acf_field( 'tab-branding-settings', 'tab-left', 'Favicon', 33 );
				$fields[] = scm_acf_field_image( $name . 'opt-branding-ico', $default, 33, 0, 'ICO 16' );
				$fields[] = scm_acf_field_image( $name . 'opt-branding-54', $default, 33, 0, 'ICO 54' );
				$fields[] = scm_acf_field_image( $name . 'opt-branding-114', $default, 33, 0, 'Icon 114' );
				$fields[] = scm_acf_field_image( $name . 'opt-branding-png', $default, 33, 0, 'PNG 16' );
				$fields[] = scm_acf_field_image( $name . 'opt-branding-72', $default, 33, 0, 'Icon 72' );
				$fields[] = scm_acf_field_image( $name . 'opt-branding-144', $default, 33, 0, 'Icon 144' );

			$fields[] = scm_acf_field( 'tab-uploads-settings', 'tab-left', 'Media Upload' );
				$fields[] = scm_acf_field( $name . 'opt-uploads-quality', [ 'percent', 100, '100', 'Qualità immagini' ], 'Qualità' );
				$fields[] = scm_acf_field( $name . 'opt-uploads-width', [ 'pixel-max', 1800, '1800', 'Largezza massima immagini' ], 'Larghezza Massima' );
				$fields[] = scm_acf_field( $name . 'opt-uploads-height', [ 'pixel-max', 1800, '1800', 'Altezza massima immagini' ], 'Altezza Massima' );

			$fields[] = scm_acf_field( 'tab-tools-settings', 'tab-left', 'Strumenti' );
				$fields[] = scm_acf_field( 'msg-fader', 'message', 'Pages Fader' );
					$fields[] = scm_acf_field( $name . 'opt-tools-fade-in', [ 'second', '', '1', 'Fade In', 'sec', 0, 10 ], 'Fade In' );
					$fields[] = scm_acf_field( $name . 'opt-tools-fade-out', [ 'second', '', '1', 'Fade Out', 'sec', 0, 10 ], 'Fade Out' );
					$fields[] = scm_acf_field_select( $name . 'opt-tools-fade-waitfor', $default, 'waitfor-no', 100, 0, '', 'Wait for' );
				$fields[] = scm_acf_field( 'msg-toppage', 'message', 'Top Of Page' );
					$fields[] = scm_acf_field( $name . 'opt-tools-topofpage-offset', [ 'pixel', 200, 200, 'Offset' ], 'Offset' );
					$fields[] = scm_acf_field_icon( $name . 'opt-tools-topofpage-icon', $default, 'angle-up' );
					$fields[] = scm_acf_field( $name . 'opt-tools-topofpage-title', [ 'name', 'Inizio pagina', 'Inizio pagina'], 'Titolo' );
					$fields = array_merge( $fields, scm_acf_preset_rgba_txt( $name . 'opt-tools-topofpage-txt', $default ) );
					$fields = array_merge( $fields, scm_acf_preset_rgba_bg( $name . 'opt-tools-topofpage-bg', $default, '#DDDDDD' ) );
				$fields[] = scm_acf_field( 'msg-smooth', 'message', 'Smooth Scroll' );
					$fields[] = scm_acf_field( $name . 'opt-tools-smoothscroll-duration', [ 'second-max', '', '0', 'Durata' ], 'Durata' );
					$fields[] = scm_acf_field( $name . 'opt-tools-smoothscroll-delay', [ 'second', '', '0', 'Delay' ], 'Delay' );
					$fields[] = scm_acf_field_select_enable( $name . 'opt-tools-smoothscroll-page', $default, 'Smooth Scroll su nuove pagine' );
					$fields[] = scm_acf_field( $name . 'opt-tools-smoothscroll-delay-new', [ 'second', '', '300', 'Delay su nuova pagina' ], 'Delay su nuova pagina' );
					$fields[] = scm_acf_field( $name . 'opt-tools-smoothscroll-offset', [ 'pixel', 50, 50, 'Offset' ], 'Offset' );
					$fields[] = scm_acf_field_select( $name . 'opt-tools-smoothscroll-ease', $default, 'ease', 100, 0, '', 'Ease' );
				$fields[] = scm_acf_field( 'msg-singlenav', 'message', 'Single Page Nav' );
					$fields[] = scm_acf_field( $name . 'opt-tools-singlepagenav-activeclass', [ 'class', 'active', 'active', 'Active Class' ], 'Active Class' );
					$fields[] = scm_acf_field( $name . 'opt-tools-singlepagenav-interval', [ 'second', '', '500', 'Interval' ], 'Interval' );
					$fields[] = scm_acf_field( $name . 'opt-tools-singlepagenav-offset', [ 'pixel', '', '0', 'Offset' ], 'Offset' );
					$fields[] = scm_acf_field( $name . 'opt-tools-singlepagenav-threshold', [ 'pixel', '', '150', 'Threshold' ], 'Threshold' );
				$fields[] = scm_acf_field( 'msg-fancybox', 'message', 'Fancybox' );
					$fields[] = scm_acf_field_select_disable( $name . 'opt-tools-fancybox', $default, 'Attivazione Fancybox' );
				$fields[] = scm_acf_field( 'msg-slider', 'message', 'Slider' );
					$fields[] = scm_acf_field_select( $name . 'opt-tools-slider', $default, 'slider_model', 100, 0, '', 'Slider' );
				$fields[] = scm_acf_field( 'msg-gmaps', 'message', 'Google Maps' );
					$fields[] = scm_acf_field_image( $name . 'opt-tools-gmap-marker', $default, 100, 0, 'Marker' );
				$fields[] = scm_acf_field( 'msg-accordion', 'message', 'Accordion' );
					$fields[] = scm_acf_field( $name . 'opt-tools-accordion-duration', [ 'second-max', '', '500', 'Durata' ], 'Durata' );

			$fields[] = scm_acf_field( 'tab-' . $name . 'opt-.private-settings', 'tab-left', 'Area Privata' );
				$fields[] = scm_acf_field_select_disable( $name . 'opt-private-login', $default, 'Attivazione Footer Login' );

			$fields[] = scm_acf_field( 'tab-ids-settings', 'tab-left', 'ID\'s' );
				$fields[] = scm_acf_field( $name . 'opt-ids-pagina', [ 'id', 'site-page' ], 'Pagina ID' );
				$fields[] = scm_acf_field( $name . 'opt-ids-header', [ 'id', 'site-header' ], 'Header ID' );
				$fields[] = scm_acf_field( $name . 'opt-ids-branding', [ 'id', 'site-branding' ], 'Branding ID' );
				$fields[] = scm_acf_field( $name . 'opt-ids-menu', [ 'id', 'site-navigation' ], 'Main Menu ID' );
				$fields[] = scm_acf_field( $name . 'opt-ids-social-follow', [ 'id', 'site-social-follow' ], 'Social Follow Menu ID' );
				$fields[] = scm_acf_field( $name . 'opt-ids-content', [ 'id', 'site-content' ], 'Content ID' );
				$fields[] = scm_acf_field( $name . 'opt-ids-footer', [ 'id', 'site-footer' ], 'Footer ID' );
				$fields[] = scm_acf_field( $name . 'opt-ids-topofpage', [ 'id', 'site-topofpage' ], 'Top Of Page ID' );

			$fields[] = scm_acf_field( 'tab-ie-settings', 'tab-left', 'IE' );
				$fields[] = scm_acf_field( $name . 'opt-ie-version', [ 'positive', '', '9', 'Internet Explorer', '', 7, 12 ], 'Versione Minima' );
				$fields[] = scm_acf_field_object_link( $name . 'opt-ie-redirect', $default, 'page', 100, 0, 'Pagina' );

			return $fields;

		}
	}

	// STYLE OPTIONS
	if ( ! function_exists( 'scm_acf_options_style' ) ) {
		function scm_acf_options_style( $name = '', $default = 0 ) {

			$name = ( $name ? $name . '-' : '');

			$fields = array();

            $fields[] = scm_acf_field( 'tab-style-testi', 'tab-left', 'Testi' );
                $fields = array_merge( $fields, scm_acf_preset_text_style( $name . 'style-txt', $default ) );
            $fields[] = scm_acf_field( 'tab-style-sfondo', 'tab-left', 'Sfondo' );
                $fields = array_merge( $fields, scm_acf_preset_background_style( $name . 'style-bg', $default ) );
            $fields[] = scm_acf_field( 'tab-style-contenitore', 'tab-left', 'Contenitore' );
                $fields = array_merge( $fields, scm_acf_preset_background_style( $name . 'style-bg-container', $default ) );
            $fields[] = scm_acf_field( 'tab-style-box', 'tab-left', 'Box' );
                $fields = array_merge( $fields, scm_acf_preset_box_style( $name . 'style-box', $default ) );

            return $fields;

		}
	}

	// STYLES OPTIONS
	if ( ! function_exists( 'scm_acf_options_styles' ) ) {
		function scm_acf_options_styles( $name = '', $default = 0 ) {

			$name = ( $name ? $name . '-' : '');

			$fields = array();

			$fields[] = scm_acf_field( 'tab-loadingpage', 'tab-left', 'Loading Page' );
				$fields = array_merge( $fields, scm_acf_preset_background_style( $name . 'styles-loading', $default ) );

			$fields[] = scm_acf_field( 'tab-fonts', 'tab-left', 'Fonts' );
				$gfonts = scm_acf_field_repeater( $name . 'styles-google', $default, 'Aggiungi Google Web Font', 'Includi Google Web Fonts', '', 0, '', '', 'Visita <a href="https://www.google.com/fonts">https://www.google.com/fonts</a>, scegli la famiglia e gli stili da includere.' );

					$gfonts['sub_fields'][] = scm_acf_field( 'family', [ 'text', '', 'Open Sans', 'Family' ], 'Family', 'required' );
					$gfonts['sub_fields'][] = scm_acf_field( 'style', [ 'checkbox-webfonts_google_styles', '', 'horizontal' ], 'Styles' );

				$fields[] = $gfonts;

				$afonts = scm_acf_field_repeater( $name . 'styles-adobe', $default, 'Aggiungi Adobe TypeKit', 'Includi Adobe TypeKit' );

					$afonts['sub_fields'][] = scm_acf_field( 'id', [ 'text', '', '000000', 'ID' ], 'ID', 'required' );
					$afonts['sub_fields'][] = scm_acf_field( 'name', [ 'text', '', 'Nome Kit', 'Kit' ], 'Nome' );

				$fields[] = $afonts;

			/*$fields[] = scm_acf_field( 'tab-styling', 'tab-left', 'Styling' );
				$fields[] = scm_acf_field( 'msg-heading', 'message', 'Heading' );
					$fields[] = scm_acf_field( 'select_headings_1', [ 'select2' . ( $default ? '-default' : '' ), 'h1' ], 'Primario', 33 );
					$fields[] = scm_acf_field( 'select_headings_2', [ 'select2' . ( $default ? '-default' : '' ), 'h2' ], 'Secondario', 33 );
					$fields[] = scm_acf_field( 'select_headings_3', [ 'select2' . ( $default ? '-default' : '' ), 'h3' ], 'Terziario', 33 );

					$fields[] = scm_acf_field( 'select_webfonts_google_heading_1', 'select2' . ( $default ? '-default' : '' ), 'Google Font', 33 );
					$fields[] = scm_acf_field( 'select_webfonts_google_heading_2', 'select2' . ( $default ? '-default' : '' ), 'Google Font', 33 );
					$fields[] = scm_acf_field( 'select_webfonts_google_heading_3', 'select2' . ( $default ? '-default' : '' ), 'Google Font', 33 );

					$fields[] = scm_acf_field( 'select_webfonts_fallback_heading_1', 'select2' . ( $default ? '-default' : '' ), 'Famiglia', 33 );
					$fields[] = scm_acf_field( 'select_webfonts_fallback_heading_2', 'select2' . ( $default ? '-default' : '' ), 'Famiglia', 33 );
					$fields[] = scm_acf_field( 'select_webfonts_fallback_heading_3', 'select2' . ( $default ? '-default' : '' ), 'Famiglia', 33 );

					$fields[] = scm_acf_field( 'text_color_heading_1', 'color', 'Colore', 33 );
					$fields[] = scm_acf_field( 'text_color_heading_2', 'color', 'Colore', 33 );
					$fields[] = scm_acf_field( 'text_color_heading_3', 'color', 'Colore', 33 );

					$fields[] = scm_acf_field( 'select_font_weight_heading_1', [ 'select2' . ( $default ? '-default' : '' ), '700' ], 'Spessore', 33 );
					$fields[] = scm_acf_field( 'select_font_weight_heading_2', [ 'select2' . ( $default ? '-default' : '' ), '700' ], 'Spessore', 33 );
					$fields[] = scm_acf_field( 'select_font_weight_heading_3', [ 'select2' . ( $default ? '-default' : '' ), '700' ], 'Spessore', 33 );

					$fields[] = scm_acf_field( 'select_line_height_heading_1', 'select2' . ( $default ? '-default' : '' ), 'Spazio Dopo', 33 );
					$fields[] = scm_acf_field( 'select_line_height_heading_2', 'select2' . ( $default ? '-default' : '' ), 'Spazio Dopo', 33 );
					$fields[] = scm_acf_field( 'select_line_height_heading_3', 'select2' . ( $default ? '-default' : '' ), 'Spazio Dopo', 33 );*/

			$fields[] = scm_acf_field( 'tab-responsive', 'tab-left', 'Responsive' );
				
				$fields[] = scm_acf_field( 'msg-responsive-size', [
					'message',
					'Aggiungi o togli px dalla dimensione generale.',
				], 'Dimensione testi' );

					$fields[] = scm_acf_field( $name . 'styles-size-wide', [ 'number', '', '-1', '+/-', 'px', -100, 100 ], 'Wide' );
					$fields[] = scm_acf_field( $name . 'styles-size-desktop', [ 'number', '', '0', '+/-', 'px', -100, 100 ], 'Desktop' );
					$fields[] = scm_acf_field( $name . 'styles-size-landscape', [ 'number', '', '1', '+/-', 'px', -100, 100 ], 'Tablet Landscape' );
					$fields[] = scm_acf_field( $name . 'styles-size-portrait', [ 'number', '', '2', '+/-', 'px', -100, 100 ], 'Tablet Portrait' );
					$fields[] = scm_acf_field( $name . 'styles-size-smart', [ 'number', '', '3', '+/-', 'px', -100, 100 ], 'Mobile' );


			return $fields;
		}
	}

	// LAYOUT OPTIONS
	if ( ! function_exists( 'scm_acf_options_layout' ) ) {
		function scm_acf_options_layout( $name = '', $default = 0 ) {

			$name = ( $name ? $name . '-' : '');

			$fields = array();

			$fields[] = scm_acf_field_select_align( $name . 'layout-alignment', $default );
			
			// conditional
			$fields[] = scm_acf_field_select_layout( $name . 'layout-page', $default, 'Larghezza Pagine' );
			
			$layout = [[[
				'field' => $name . 'layout-page',
				'operator' => '==',
				'value' => 'full',
			]]];

				$fields[] = scm_acf_field_select_layout( $name . 'layout-head', $default, 'Larghezza Header', 33, $layout );
				$fields[] = scm_acf_field_select_layout( $name . 'layout-content', $default, 'Larghezza Contenuti', 33, $layout );
				$fields[] = scm_acf_field_select_layout( $name . 'layout-foot', $default, 'Larghezza Footer', 33, $layout );
				$fields[] = scm_acf_field_select_layout( $name . 'layout-menu', $default, 'Larghezza Menu', 33, $layout );
				$fields[] = scm_acf_field_select_layout( $name . 'layout-sticky', $default, 'Larghezza Sticky Menu', 33, $layout );

			$fields[] = scm_acf_field_select( $name . 'layout-tofull',  $default, 'responsive_events', 100, 0, '', 'Responsive to Full' );
			$fields[] = scm_acf_field_select( $name . 'layout-max',  $default, 'responsive_layouts', 100, 0, '', 'Max Responsive Width' );

			return $fields;

		}
	}

	// HEAD ALL OPTIONS
	if ( ! function_exists( 'scm_acf_options_head' ) ) {
		function scm_acf_options_head( $name = '', $default = 0 ) {

			$name = ( $name ? $name . '-' : '');

			$fields = array();
			
			$fields[] = scm_acf_field( 'tab-head-brand', 'tab-left', 'Branding' );
                $fields = array_merge( $fields, scm_acf_options_head_branding( $name . 'head' ) );

            $fields[] = scm_acf_field( 'tab-head-menu', 'tab-left', 'Menu' );
                $fields = array_merge( $fields, scm_acf_options_head_menu( $name . 'head' ) );

            $fields[] = scm_acf_field( 'tab-head-social', 'tab-left', 'Social' );
                $fields = array_merge( $fields, scm_acf_options_head_social( $name . 'head' ) );

            $fields[] = scm_acf_field( 'tab-head-slider', 'tab-left', 'Slider' );
                $fields = array_merge( $fields, scm_acf_options_slider( $name . 'head' ) );

			return $fields;
		}
	}

	// HEAD BRANDING OPTIONS
	if ( ! function_exists( 'scm_acf_options_head_branding' ) ) {
		function scm_acf_options_head_branding( $name = '', $default = 0 ) {

			$name = ( $name ? $name . '-' : '');

			$fields = array();
			
			$fields[] = scm_acf_field_select_align( $name . 'brand-alignment', $default );
			// conditional
			$fields[] = scm_acf_field_select( $name . 'brand-head', $default, 'branding_header', 100, 0, '', 'Tipo' );
			$tipo = [[[
				'field' => $name . 'brand-head',
				'operator' => '==',
				'value' => 'img',
			]]];
			
				$fields[] = scm_acf_field_image( $name . 'brand-logo', $default, 100, $tipo, 'Logo' );
				$fields = array_merge( $fields, scm_acf_preset_size( $name . 'brand-height', $default, '40', 'px', 'Altezza Massima', 100, $tipo ) );

			$fields[] = scm_acf_field_select_disable( $name . 'brand-slogan', $default, 'Attivazione Slogan' );

			return $fields;
		}
	}

	// HEAD MENU OPTIONS
	if ( ! function_exists( 'scm_acf_options_head_menu' ) ) {
		function scm_acf_options_head_menu( $name = '', $default = 0 ) {

			$name = ( $name ? $name . '-' : '');

			$fields = array();
			
			$fields[] = scm_acf_field( 'msg-menu', 'message', 'Opzioni Menu' );
				$fields[] = scm_acf_field_select( $name . 'menu-wp', $default, 'wp_menu', 50, 0, '', 'Menu' );
				
				$fields[] = scm_acf_field_select_disable( $name . 'menu-overlay', $default, 'Attivazione Overlay', 50 );
				$fields[] = scm_acf_field_select( $name . 'menu-position', $default, 'position_menu', 50, 0, '', 'Posizione' );
				$fields[] = scm_acf_field_select_align( $name . 'menu-alignment', $default, 50 );
				
				$fields = array_merge( $fields, scm_acf_preset_text_font( $name . 'menu-webfonts', $default, 0, 33, 33, 33 ) );

			$fields[] = scm_acf_field( 'msg-toggle', 'message', 'Toggle Menu' );
				$fields[] = scm_acf_field_select( $name . 'menu-toggle', $default, 'responsive_up', 50, 0, '', 'Attiva Toggle Menu');
				$fields[] = scm_acf_field_icon( $name . 'menu-toggle-icon', $default, 'bars', 50, 0, 'Icona Toggle Menu' );

			$fields[] = scm_acf_field( 'msg-home', 'message', 'Home Button' );
				$fields[] = scm_acf_field_select( $name . 'menu-home', $default, 'home_active', 50, 0, '', 'Attiva Home Button' );
				$fields[] = scm_acf_field_icon( $name . 'menu-home-icon', $default, 'home', 50, 0, 'Icona Home Button' );
				$fields[] = scm_acf_field_select( $name . 'menu-home-logo', $default, 'responsive_down-no', 50, 0, '', 'Attiva Logo' );
				$fields[] = scm_acf_field_image( $name . 'menu-home-image', $default, 50, 0, 'Logo Home' );

			$fields[] = scm_acf_field( 'msg-sticky', 'message', 'Sticky Menu' );
				// conditional
				$fields[] = scm_acf_field_select( $name . 'menu-sticky', $default, 'sticky_active-no', 100, 0, '', 'Seleziona Tipo' );
				$sticky = [[[
					'field' => $name . 'menu-sticky',
					'operator' => '==',
					'value' => 'plus',
				]]];
					$fields[] = scm_acf_field_select( $name . 'menu-sticky-attach', $default, 'sticky_attach-no', 50, $sticky, '', 'Attach to Menu' );
					$fields[] = scm_acf_field( $name . 'menu-sticky-offset', [ 'pixel', '', '0', 'Offset' ], 'Offset', 50, $sticky );

			return $fields;
		}
	}

	// HEAD SOCIAL OPTIONS
	if ( ! function_exists( 'scm_acf_options_head_social' ) ) {
		function scm_acf_options_head_social( $name = '', $default = 0 ) {

			$name = ( $name ? $name . '-' : '');

			$fields = array();
			
			// conditional
			$fields[] = scm_acf_field_select_disable( $name . 'social-follow-enabled', $default, 'Attivazione Social' );
			$social = [[[
				'field' => $name . 'social-follow-enabled',
				'operator' => '==',
				'value' => 'on',
			]]];

				$fields[] = scm_acf_field_select( $name . 'social-follow-position', $default, 'head_social_position', 50, $social, '', 'Posizione' );
				$fields[] = scm_acf_field_select_align( $name . 'social-follow-alignment', $default, 50, $social );
				$fields[] = scm_acf_field_select( $name . 'social-follow-shape', $default, 'social_shape', 50, $social, '', 'Forma' );
				$fields[] = scm_acf_field_select( $name . 'social-follow-icon', $default, 'size_icon', 50, $social, '', 'Dimensione' );

			return $fields;
		}
	}

	// FOOTER
	if ( ! function_exists( 'scm_acf_options_foot' ) ) {
		function scm_acf_options_foot( $name = '', $default = 0 ) {

			$name = ( $name ? $name . '-' : '');

			$fields = array();

			$fields = array_merge( $fields, scm_acf_preset_flexible_rows( $name . 'footer', $default ) );

			return $fields;
		}
	}

	// SLIDER OPTIONS
	if ( ! function_exists( 'scm_acf_options_slider' ) ) {
		function scm_acf_options_slider( $name = '', $default = 0 ) {

			$name = ( $name ? $name . '-' : '');

			$fields = array();

			// conditional slider
			$fields[] = scm_acf_field_select_disable( $name . 'slider-enabled', $default, 'Attivazione Slider' );

			$condition = [[[
				'field' => $name . 'slider-enabled',
				'operator' => '==',
				'value' => 'on',
			]]];

				// +++ todo: NON field_objects, MA field_category (Slides > Slider) + all

				//$fields[] = scm_acf_field_objects( $name . 'slider-slides', $default, 'slides', 100, $condition, 'Slide' );
				$fields = array_merge( $fields, scm_acf_preset_term( $name . 'slider-slides', $default, 'sliders', 0, 'Slider', $condition ) );

				$fields[] = scm_acf_field_select( $name . 'slider-layout', $default, 'layout_main', 100, $condition, '', 'Layout' );
				$fields = array_merge( $fields, scm_acf_preset_size( $name . 'slider-height', $default, 'auto', 'px', 'Altezza Massima', $condition ) );
				$fields[] = scm_acf_field_select( $name . 'slider-theme', $default, 'themes_nivo', 100, $condition, '', 'Tema' );
				
				// conditional options
				$fields[] = scm_acf_field_select_options( $name . 'slider-options', $default, 100, $condition, 'hide' );

				$hide = [[
					$condition[0][0],
					[
					'field' => $name . 'slider-options',
					'operator' => '==',
					'value' => 'hide',
					]
				]];
				$options = [[
					$condition[0][0],
					[
					'field' => $name . 'slider-options',
					'operator' => '==',
					'value' => 'options',
					]
				]];
				$advanced = [[
					$condition[0][0],
					[
					'field' => $name . 'slider-options',
					'operator' => '==',
					'value' => 'advanced',
					]
				]];

					$fields[] = scm_acf_field_select( $name . 'slider-effect', $default, 'effect_nivo', 100, $options, '', 'Effetto Slider' );
					$fields[] = scm_acf_field_number( $name . 'slider-slices', $default, 33, $options, '30', 'Slices', 1, 30 );
					$fields[] = scm_acf_field_number( $name . 'slider-cols', $default, 33, $options, '8', 'Colonne', 1, 8 );
					$fields[] = scm_acf_field_number( $name . 'slider-rows', $default, 33, $options, '8', 'Righe', 1, 100 );
					$fields[] = scm_acf_field_number( $name . 'slider-speed', $default, 50, $options, '1', 'Velocità' );
					$fields[] = scm_acf_field_number( $name . 'slider-pause', $default, 50, $options, '5', 'Pausa' );

					$fields[] = scm_acf_field_option( $name . 'slider-start', $default, 33, $advanced, '0', 'Start Slide' );
					$fields[] = scm_acf_field_select_enable( $name . 'slider-pause', $default, 'Pause on Hover', 33, $advanced );
					$fields[] = scm_acf_field_select_disable( $name . 'slider-manual', $default, 'Manual Advance', 33, $advanced );
					$fields[] = scm_acf_field_select_enable( $name . 'slider-direction', $default, 'Direction Nav', 33, $advanced );
					$fields[] = scm_acf_field_select_disable( $name . 'slider-control', $default, 'Control Nav', 33, $advanced );
					$fields[] = scm_acf_field_select_disable( $name . 'slider-thumbs', $default, 'Thumbs Nav', 33, $advanced );
					$fields[] = scm_acf_field_icon( $name . 'slider-prev', $default, 'angle-left', 50, $advanced, 'Prev Icon' );
					$fields[] = scm_acf_field_icon( $name . 'slider-next', $default, 'angle-right', 50, $advanced, 'Next Icon' );

				return $fields;
			
		}
	}


	
?>