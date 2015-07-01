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

/* Checkbox */

	// HAS GROUP
	if ( ! function_exists( 'scm_acf_field_hidden' ) ) {
		function scm_acf_field_hidden( $name = '' ) {

			return scm_acf_field( $name, array( 'number-read', 1, 1 ), $name );
		}
	}

/* Number */

	

	// NUMBER
	if ( ! function_exists( 'scm_acf_field_number' ) ) {
		function scm_acf_field_number( $name = '', $default = 0, $width = '', $logic = 0, $placeholder = 'auto', $label = '', $min = '', $max = '', $instr = '', $required = 0 ) {
			$label = ( $label ?: __( 'Misura', SCM_THEME ) );
			return scm_acf_field( $name, array( 'number', '', ( $default ? 'default' : $placeholder ), $label ), $label, $width, $logic, $instr, $required );
		}
	}
	
	// OPTION
	if ( ! function_exists( 'scm_acf_field_option' ) ) {
		function scm_acf_field_option( $name = '', $default = 0, $width = '', $logic = 0, $placeholder = 'auto', $label = '', $instr = '', $required = 0 ) {
			$label = ( $label ?: __( 'Misura', SCM_THEME ) );
			return scm_acf_field( $name, array( 'option', '', ( $default ? 'default' : $placeholder ), $label ), $label, $width, $logic, $instr, $required );
		}
	}

	// POSITIVE
	if ( ! function_exists( 'scm_acf_field_positive' ) ) {
		function scm_acf_field_positive( $name = '', $default = 0, $width = '', $logic = 0, $placeholder = 'auto', $label = '', $instr = '', $required = 0 ) {
			$label = ( $label ?: __( 'Misura', SCM_THEME ) );
			return scm_acf_field( $name, array( 'positive', '', ( $default ? 'default' : $placeholder ), $label ), $label, $width, $logic, $instr, $required );
		}
	}
	
	// ALPHA
	if ( ! function_exists( 'scm_acf_field_alpha' ) ) {
		function scm_acf_field_alpha( $name = '', $default = 0, $width = '', $logic = 0, $placeholder = '1', $label = '', $instr = '', $required = 0 ) {
			$label = ( $label ?: __( 'Trasparenza', SCM_THEME ) );
			return scm_acf_field( $name, array( 'alpha', '', ( $default ? 'default' : $placeholder ), $label ), $label, $width, $logic, $instr, $required );
		}
	}
	
/* Text */

	// TEXT
	if ( ! function_exists( 'scm_acf_field_text' ) ) {
		function scm_acf_field_text( $name = '', $default = 0, $width = '', $logic = 0, $placeholder = '', $label = '', $append = '', $max = '', $instr = '', $required = 0 ) {
			$placeholder = ( $placeholder ?: __( 'testo', SCM_THEME ) );
			$label = ( $label ?: __( 'Testo', SCM_THEME ) );
			return scm_acf_field( $name, array( 'text', '', ( $default ? 'default' : $placeholder ), ( $append ?: $label ), '', $max ), $label, $width, $logic, $instr, $required );
		}
	}
	
	// TEXT REQUIRED
	if ( ! function_exists( 'scm_acf_field_text_req' ) ) {
		function scm_acf_field_text_req( $name = '', $default = 0, $width = '', $logic = 0, $placeholder = '', $label = '', $append = '', $max = '', $instr = '', $required = 1 ) {
			$placeholder = ( $placeholder ?: __( 'testo', SCM_THEME ) );
			$label = ( $label ?: __( 'Testo', SCM_THEME ) );
			return scm_acf_field( $name, array( 'text', '', ( $default ? 'default' : $placeholder ), ( $append ?: $label ), '', $max ), $label, $width, $logic, $instr, $required );
		}
	}
	
	// ID
	if ( ! function_exists( 'scm_acf_field_id' ) ) {
		function scm_acf_field_id( $name = '', $default = 0, $width = '', $logic = 0, $placeholder = '', $label = '', $max = '', $instr = '', $required = 0 ) {
			$placeholder = ( $placeholder ?: __( 'id', SCM_THEME ) );
			$label = ( $label ?: __( 'ID', SCM_THEME ) );
			return scm_acf_field( $name, array( 'id', '', ( $default ? 'default' : $placeholder ) ), $label, $width, $logic, $instr, $required );
		}
	}

	// CLASS
	if ( ! function_exists( 'scm_acf_field_class' ) ) {
		function scm_acf_field_class( $name = '', $default = 0, $width = '', $logic = 0, $placeholder = '', $label = '', $max = '', $instr = '', $required = 0 ) {
			$placeholder = ( $placeholder ?: __( 'class', SCM_THEME ) );
			$label = ( $label ?: __( 'Class', SCM_THEME ) );
			return scm_acf_field( $name, array( 'class', '', ( $default ? 'default' : $placeholder ) ), $label, $width, $logic, $instr, $required );
		}
	}

	// NAME
	if ( ! function_exists( 'scm_acf_field_name_req' ) ) {
		function scm_acf_field_name_req( $name = '', $default = 0, $max = '', $width = '', $logic = 0, $placeholder = '', $label = '', $instr = '', $required = 1 ) {
			$placeholder = ( $placeholder ?: __( 'nome', SCM_THEME ) );
			$label = ( $label ?: __( 'Nome', SCM_THEME ) );
			return scm_acf_field( $name, array( 'name', '', ( $default ? 'default' : $placeholder ), $label, '', $max ), $label, $width, $logic, $instr, $required );
		}
	}

	// NAME
	if ( ! function_exists( 'scm_acf_field_name' ) ) {
		function scm_acf_field_name( $name = '', $default = 0, $max = '', $width = '', $logic = 0, $placeholder = '', $label = '', $instr = '', $required = 0 ) {
			$placeholder = ( $placeholder ?: __( 'nome', SCM_THEME ) );
			$label = ( $label ?: __( 'Nome', SCM_THEME ) );
			return scm_acf_field( $name, array( 'name', '', ( $default ? 'default' : $placeholder ), $label, '', $max ), $label, $width, $logic, $instr, $required );
		}
	}

	// LINK
	if ( ! function_exists( 'scm_acf_field_link' ) ) {
		function scm_acf_field_link( $name = '', $default = 0, $width = '', $logic = 0, $placeholder = 'http://www.esempio.com', $label = '', $instr = '', $required = 0 ) {

			$label = ( $label ?: __( 'Link', SCM_THEME ) );
			return scm_acf_field( $name, array( 'link', '', ( $default ? 'default' : $placeholder ), $label ), $label, $width, $logic, $instr, $required );
		}
	}
	
	// EMAIL
	if ( ! function_exists( 'scm_acf_field_email' ) ) {
		function scm_acf_field_email( $name = '', $default = 0, $width = '', $logic = 0, $placeholder = 'info@esempio.com', $label = '', $instr = '', $required = 0 ) {

			$label = ( $label ?: __( 'Email', SCM_THEME ) );
			return scm_acf_field( $name, array( 'text', '', ( $default ? 'default' : $placeholder ), $label ), $label, $width, $logic, $instr, $required );
		}
	}

	// PHONE
	if ( ! function_exists( 'scm_acf_field_phone' ) ) {
		function scm_acf_field_phone( $name = '', $default = 0, $width = '', $logic = 0, $placeholder = '+39 1234 567890', $label = '', $instr = '', $required = 0 ) {
			$label = ( $label ?: __( 'Numero', SCM_THEME ) );
			return scm_acf_field( $name, array( 'text', '', ( $default ? 'default' : $placeholder ), $label ), $label, $width, $logic, $instr, $required );
		}
	}

/* Limiter */
	
	// LIMITER
	if ( ! function_exists( 'scm_acf_field_limiter' ) ) {
		function scm_acf_field_limiter( $name = '', $default = 0, $max = 350, $char = 1, $width = '', $logic = 0, $label = '', $instr = '', $required = 0 ) {
			$label = ( $label ?: __( 'Testo', SCM_THEME ) );
			return scm_acf_field( $name, array( 'limiter', $max, $char ), $label, $width, $logic, $instr, $required );
		}
	}

/* TextArea */
	
	// TEXTAREA
	if ( ! function_exists( 'scm_acf_field_textarea' ) ) {
		function scm_acf_field_textarea( $name = '', $default = 0, $rows = 8, $width = '', $logic = 0, $placeholder = '', $label = '', $instr = '', $required = 0 ) {
			$label = ( $label ?: __( 'Testo', SCM_THEME ) );
			$placeholder = ( $label ?: __( 'Inserisci testo', SCM_THEME ) );
			return scm_acf_field( $name, array( 'textarea', '', $placeholder, $rows ), $label, $width, $logic, $instr, $required );
		}
	}

/* Editor */
	
	// EDITOR BASIC MEDIA
	if ( ! function_exists( 'scm_acf_field_editor' ) ) {
		function scm_acf_field_editor( $name = '', $default = 0, $width = '', $logic = 0, $placeholder = '', $label = '', $instr = '', $required = 0 ) {
			$label = ( $label ?: __( 'Testo', SCM_THEME ) );
			$placeholder = ( $label ?: __( 'Inserisci testo', SCM_THEME ) );
			return scm_acf_field( $name, array( 'editor-media-basic', $placeholder ), $label, $width, $logic, $instr, $required );
		}
	}

	// EDITOR VISUAL MEDIA
	if ( ! function_exists( 'scm_acf_field_editor_media' ) ) {
		function scm_acf_field_editor_media( $name = '', $default = 0, $width = '', $logic = 0, $placeholder = '', $label = '', $instr = '', $required = 0 ) {
			$label = ( $label ?: __( 'Testo', SCM_THEME ) );
			$placeholder = ( $label ?: __( 'Inserisci testo', SCM_THEME ) );
			return scm_acf_field( $name, array( 'editor-basic-visual-media', $placeholder ), $label, $width, $logic, $instr, $required );
		}
	}

	// EDITOR VISUAL
	if ( ! function_exists( 'scm_acf_field_editor_basic' ) ) {
		function scm_acf_field_editor_basic( $name = '', $default = 0, $width = '', $logic = 0, $placeholder = '', $label = '', $instr = '', $required = 0 ) {
			$label = ( $label ?: __( 'Testo', SCM_THEME ) );
			$placeholder = ( $label ?: __( 'Inserisci testo', SCM_THEME ) );
			return scm_acf_field( $name, array( 'editor-basic-visual', $placeholder ), $label, $width, $logic, $instr, $required );
		}
	}

/* Date */
	
	// DATE
	if ( ! function_exists( 'scm_acf_field_date' ) ) {
		function scm_acf_field_date( $name = '', $default = 0, $width = '', $logic = 0, $placeholder = '', $label = '', $instr = '', $required = 0 ) {
			$label = ( $label ?: __( 'Data', SCM_THEME ) );
			return scm_acf_field( $name, array( 'date', ( $placeholder ?: '' ) ), $label, $width, $logic, $instr, $required );
		}
	}

/* Color */
	
	// COLOR
	if ( ! function_exists( 'scm_acf_field_color' ) ) {
		function scm_acf_field_color( $name = '', $default = 0, $width = '', $logic = 0, $placeholder = '', $label = '', $instr = '', $required = 0 ) {
			$label = ( $label ?: __( 'Colore', SCM_THEME ) );
			return scm_acf_field( $name, array( 'color', ( $placeholder ?: '' ) ), $label, $width, $logic, $instr, $required );
		}
	}

/* Icon */

	// ICON
	if ( ! function_exists( 'scm_acf_field_icon' ) ) {
		function scm_acf_field_icon( $name = '', $default = 0, $placeholder = 'star', $filter = '', $width = '', $logic = 0, $label = '', $instr = '', $required = 0 ) {
			$label = ( $label ?: __( 'Seleziona un\'icona', SCM_THEME ) );
			return scm_acf_field( $name, array( 'icon', $placeholder, $filter ), $label, $width, $logic, $instr, $required );
		}
	}

	// ICON
	if ( ! function_exists( 'scm_acf_field_icon_no' ) ) {
		function scm_acf_field_icon_no( $name = '', $default = 0, $placeholder = 'no', $filter = '', $width = '', $logic = 0, $label = '', $instr = '', $required = 0 ) {
			$label = ( $label ?: __( 'Seleziona un\'icona', SCM_THEME ) );
			return scm_acf_field( $name, array( 'icon-no', $placeholder, $filter ), $label, $width, $logic, $instr, $required );
		}
	}

/* Image */

	// IMAGE
	if ( ! function_exists( 'scm_acf_field_image' ) ) {
		function scm_acf_field_image( $name = '', $default = 0, $width = '', $logic = 0, $label = '', $instr = '', $required = 0 ) {
			$label = ( $label ?: __( 'Seleziona un\'immagine', SCM_THEME ) );
			return scm_acf_field( $name, 'image-url', $label, $width, $logic, $instr, $required );
		}
	}

/* File */

	// FILE
	if ( ! function_exists( 'scm_acf_field_file' ) ) {
		function scm_acf_field_file( $name = '', $default = 0, $width = '', $logic = 0, $label = '', $instr = '', $required = 0 ) {
			$label = ( $label ?: __( 'Seleziona un file', SCM_THEME ) );
			return scm_acf_field( $name, 'file-url', $label, $width, $logic, $instr, $required );
		}
	}

/* Select */

	// SELECT 1
	if ( ! function_exists( 'scm_acf_field_select1' ) ) {
		function scm_acf_field_select1( $name = '', $default = 0, $type = '', $width = '', $logic = 0, $placeholder = '', $label = '', $instr = '', $required = 0 ) {
			$label = ( $label ?: __( 'Elementi', SCM_THEME ) );
			return scm_acf_field( $name, array( 'select' . ( $type ? '-' . $type : '' ) . ( $default ? '-default' : '' ), $placeholder, __( 'Seleziona', SCM_THEME ) . ' ' . $label ), $label, $width, $logic, $instr, $required );
		}
	}

	// SELECT 2
	if ( ! function_exists( 'scm_acf_field_select' ) ) {
		function scm_acf_field_select( $name = '', $default = 0, $type = '', $width = '', $logic = 0, $placeholder = '', $label = '', $instr = '', $required = 0 ) {
			$label = ( $label ?: __( 'Elementi', SCM_THEME ) );
			return scm_acf_field( $name, array( 'select2' . ( $type ? '-' . $type : '' ) . ( $default ? '-default' : '' ), $placeholder, __( 'Seleziona', SCM_THEME ) . ' ' . $label ), $label, $width, $logic, $instr, $required );
		}
	}

	// DATE FORMAT
	if ( ! function_exists( 'scm_acf_field_select_date' ) ) {
		function scm_acf_field_select_date( $name = '', $default = 0, $width = '', $logic = 0, $placeholder = '', $label = '', $instr = '', $required = 0 ) {
			$label = ( $label ?: __( 'Formato', SCM_THEME ) );

			return scm_acf_field( $name, array( 'select-date_format' . ( $default ? '-default' : '' ), $placeholder, $label ), $label, $width, $logic, $instr, $required );
		}
	}

	// COLUMN WIDTH
	if ( ! function_exists( 'scm_acf_field_select_column_width' ) ) {
		function scm_acf_field_select_column_width( $name = '', $default = 0, $width = '', $logic = 0, $placeholder = '', $label = '', $instr = '', $required = 0 ) {
			$label = ( $label ?: __( 'Larghezza', SCM_THEME ) );

			return scm_acf_field( $name, array( 'select2-columns_width' . ( $default ? '-default' : '' ), $placeholder, $label ), $label, $width, $logic, $instr, $required );
		}
	}

	// OPTIONS
	if ( ! function_exists( 'scm_acf_field_select_options' ) ) {
		function scm_acf_field_select_options( $name = '', $default = 0, $width = '', $logic = 0, $placeholder = '', $label = '', $instr = '', $required = 0 ) {
			$label = ( $label ?: __( 'Opzioni', SCM_THEME ) );

			return scm_acf_field( $name, array( 'select-options_show' . ( $default ? '-default' : '' ), $placeholder, $label ), $label, $width, $logic, $instr, $required );
		}
	}

	// HIDE
	if ( ! function_exists( 'scm_acf_field_select_hide' ) ) {
		function scm_acf_field_select_hide( $name = '', $default = 0, $placeholder = '', $width = '', $logic = 0, $label = '', $instr = '', $required = 0 ) {
			$label = ( $label ?: __( 'Mostra', SCM_THEME ) );

			return scm_acf_field( $name, array( 'select-hide' . ( $default ? '-default' : '' ), $placeholder, $label ), $label . ( $placeholder ? ' ' . $placeholder : '' ), $width, $logic, $instr, $required );
		}
	}

	// HIDE2
	if ( ! function_exists( 'scm_acf_field_select_hide2' ) ) {
		function scm_acf_field_select_hide2( $name = '', $default = 0, $placeholder = '', $width = '', $logic = 0, $label = '', $instr = '', $required = 0 ) {
			$label = ( $label ?: __( 'Mostra', SCM_THEME ) );

			return scm_acf_field( $name, array( 'select2-hide' . ( $default ? '-default' : '' ), $placeholder, $label ), $label . ( $placeholder ? ' ' . $placeholder : '' ), $width, $logic, $instr, $required );
		}
	}
	
	// SHOW
	if ( ! function_exists( 'scm_acf_field_select_show' ) ) {
		function scm_acf_field_select_show( $name = '', $default = 0, $placeholder = '', $width = '', $logic = 0, $label = '', $instr = '', $required = 0 ) {
			$label = ( $label ?: __( 'Mostra', SCM_THEME ) );

			return scm_acf_field( $name, array( 'select-show' . ( $default ? '-default' : '' ), $placeholder, $label ), $label . ( $placeholder ? ' ' . $placeholder : '' ), $width, $logic, $instr, $required );
		}
	}

	// SHOW2
	if ( ! function_exists( 'scm_acf_field_select_show2' ) ) {
		function scm_acf_field_select_show2( $name = '', $default = 0, $placeholder = '', $width = '', $logic = 0, $label = '', $instr = '', $required = 0 ) {
			$label = ( $label ?: __( 'Mostra', SCM_THEME ) );

			return scm_acf_field( $name, array( 'select2-show' . ( $default ? '-default' : '' ), $placeholder, $label ), $label . ( $placeholder ? ' ' . $placeholder : '' ), $width, $logic, $instr, $required );
		}
	}

	// DISABLE
	if ( ! function_exists( 'scm_acf_field_select_disable' ) ) {
		function scm_acf_field_select_disable( $name = '', $default = 0, $placeholder = '', $width = '', $logic = 0, $label = '', $instr = '', $required = 0 ) {
			$label = ( $label ?: __( 'Abilita', SCM_THEME ) );

			return scm_acf_field( $name, array( 'select-disable' . ( $default ? '-default' : '' ), $placeholder, $label ), $label . ( $placeholder ? ' ' . $placeholder : '' ), $width, $logic, $instr, $required );
		}
	}

	// DISABLE2
	if ( ! function_exists( 'scm_acf_field_select_disable2' ) ) {
		function scm_acf_field_select_disable2( $name = '', $default = 0, $placeholder = '', $width = '', $logic = 0, $label = '', $instr = '', $required = 0 ) {
			$label = ( $label ?: __( 'Abilita', SCM_THEME ) );

			return scm_acf_field( $name, array( 'select2-disable' . ( $default ? '-default' : '' ), $placeholder, $label ), $label . ( $placeholder ? ' ' . $placeholder : '' ), $width, $logic, $instr, $required );
		}
	}

	// ENABLE
	if ( ! function_exists( 'scm_acf_field_select_enable' ) ) {
		function scm_acf_field_select_enable( $name = '', $default = 0, $placeholder = '', $width = '', $logic = 0, $label = '', $instr = '', $required = 0 ) {
			$label = ( $label ?: __( 'Abilita', SCM_THEME ) );

			return scm_acf_field( $name, array( 'select-enable' . ( $default ? '-default' : '' ), $placeholder, $label ), $label . ( $placeholder ? ' ' . $placeholder : '' ), $width, $logic, $instr, $required );
		}
	}

	// ENABLE2
	if ( ! function_exists( 'scm_acf_field_select_enable2' ) ) {
		function scm_acf_field_select_enable2( $name = '', $default = 0, $placeholder = '', $width = '', $logic = 0, $label = '', $instr = '', $required = 0 ) {
			$label = ( $label ?: __( 'Abilita', SCM_THEME ) );

			return scm_acf_field( $name, array( 'select2-enable' . ( $default ? '-default' : '' ), $placeholder, $label ), $label . ( $placeholder ? ' ' . $placeholder : '' ), $width, $logic, $instr, $required );
		}
	}
	
	// HEADINGS
	if ( ! function_exists( 'scm_acf_field_select_headings' ) ) {
		function scm_acf_field_select_headings( $name = '', $default = 0, $opt = 0, $width = '', $logic = 0, $placeholder = '', $label = '', $instr = '', $required = 0 ) {
			$label = ( $label ?: __( 'Stile', SCM_THEME ) );

			return scm_acf_field( $name, array( 'select-headings' . ( $opt === 1 ? '_low' : ( $opt === -1 ? '_min' : ( $opt === 2 ? '_max' : '' ) ) ) . ( $default ? '-default' : '' ), $placeholder, __( 'Seleziona', SCM_THEME ) . ' ' . $label ), $label, $width, $logic, $instr, $required );
		}
	}

	// LAYOUT
	if ( ! function_exists( 'scm_acf_field_select_layout' ) ) {
		function scm_acf_field_select_layout( $name = '', $default = 0, $label = '', $width = '', $logic = 0, $placeholder = '', $instr = '', $required = 0 ) {
			$label = ( $label ?: __( 'Layout', SCM_THEME ) );
			return scm_acf_field( $name, array( 'select-layout_main' . ( $default ? '-default' : '' ), $placeholder, __( 'Seleziona', SCM_THEME ) . ' ' . $label ), $label, $width, $logic, $instr, $required );
		}
	}

	// IMAGE FORMAT
	if ( ! function_exists( 'scm_acf_field_select_image_format' ) ) {
		function scm_acf_field_select_image_format( $name = '', $default = 0, $width = '', $logic = 0, $placeholder = '', $label = '', $instr = '', $required = 0 ) {
			$label = ( $label ?: __( 'Formato', SCM_THEME ) );

			return scm_acf_field( $name, array( 'select-image_format' . ( $default ? '-default' : '' ), $placeholder, __( 'Seleziona', SCM_THEME ) . ' ' . $label ), $label, $width, $logic, $instr, $required );
		}
	}

	// FLOAT
	if ( ! function_exists( 'scm_acf_field_select_float' ) ) {
		function scm_acf_field_select_float( $name = '', $default = 0, $width = '', $logic = 0, $placeholder = '', $label = '', $instr = '', $required = 0 ) {
			$label = ( $label ?: __( 'Allineamento', SCM_THEME ) );

			return scm_acf_field( $name, array( 'select-float' . ( $default ? '-default' : '' ), $placeholder, __( 'Seleziona', SCM_THEME ) . ' ' . $label ), $label, $width, $logic, $instr, $required );
		}
	}
	
	// OVERLAY
	if ( ! function_exists( 'scm_acf_field_select_overlay' ) ) {
		function scm_acf_field_select_overlay( $name = '', $default = 0, $width = '', $logic = 0, $placeholder = '', $label = '', $instr = '', $required = 0 ) {
			$label = ( $label ?: __( 'Overlay', SCM_THEME ) );

			return scm_acf_field( $name, array( 'select-overlay' . ( $default ? '-default' : '' ), $placeholder, __( 'Seleziona', SCM_THEME ) . ' ' . $label ), $label, $width, $logic, $instr, $required );
		}
	}
	
	// ALIGN
	if ( ! function_exists( 'scm_acf_field_select_align' ) ) {
		function scm_acf_field_select_align( $name = '', $default = 0, $width = '', $logic = 0, $placeholder = '', $label = '', $instr = '', $required = 0 ) {
			$label = ( $label ?: __( 'Allineamento', SCM_THEME ) );

			return scm_acf_field( $name, array( 'select-alignment' . ( $default ? '-default' : '' ), $placeholder, __( 'Seleziona', SCM_THEME ) . ' ' . $label ), $label, $width, $logic, $instr, $required );
		}
	}

	// VERTICAL ALIGN
	if ( ! function_exists( 'scm_acf_field_select_valign' ) ) {
		function scm_acf_field_select_valign( $name = '', $default = 0, $width = '', $logic = 0, $placeholder = '', $label = '', $instr = '', $required = 0 ) {
			$label = ( $label ?: __( 'Allineamento', SCM_THEME ) );

			return scm_acf_field( $name, array( 'select-vertical_alignment' . ( $default ? '-default' : '' ), $placeholder, __( 'Seleziona', SCM_THEME ) . ' ' . $label ), $label, $width, $logic, $instr, $required );
		}
	}

	// TXT ALIGN
	if ( ! function_exists( 'scm_acf_field_select_txt_align' ) ) {
		function scm_acf_field_select_txt_align( $name = '', $default = 0, $width = '', $logic = 0, $placeholder = '', $label = '', $instr = '', $required = 0 ) {
			$label = ( $label ?: __( 'Allineamento', SCM_THEME ) );

			return scm_acf_field( $name, array( 'select2-txt_alignment' . ( $default ? '-default' : '' ), $placeholder, __( 'Seleziona', SCM_THEME ) . ' ' . $label ), $label, $width, $logic, $instr, $required );
		}
	}


	// UNITS
	if ( ! function_exists( 'scm_acf_field_select_units' ) ) {
		function scm_acf_field_select_units( $name = '', $default = 0, $width = '', $logic = 0, $placeholder = 'px', $label = '', $instr = '', $required = 0 ) {
			$label = ( $label ?: __( 'Unità', SCM_THEME ) );

			return scm_acf_field( $name, array( 'select-units' . ( $default ? '-default' : '' ), $placeholder, __( 'Seleziona', SCM_THEME ) . ' ' . $label ), $label, $width, $logic, $instr, $required );
		}
	}

/* Object */

	// INTERNAL OBJECT ID BY TAXONOMY
	if ( ! function_exists( 'scm_acf_field_object_tax' ) ) {
		function scm_acf_field_object_tax( $name = '', $default = 0, $type = '', $tax = '', $width = '', $logic = 0, $label = '', $instr = '', $required = 0 ) {
			$label = ( $label ?: __( 'Contenuto', SCM_THEME ) );
			
			return scm_acf_field( $name, array( 'object-id', $type, $tax , __( 'Seleziona', SCM_THEME ) . ' ' . $label), $label, $width, $logic, $instr, $required );
		}
	}

	// INTERNAL OBJECTS ID BY TAXONOMY
	if ( ! function_exists( 'scm_acf_field_objects_tax' ) ) {
		function scm_acf_field_objects_tax( $name = '', $default = 0, $type = '', $tax = '', $width = '', $logic = 0, $label = '', $instr = '', $required = 0 ) {
			$label = ( $label ?: __( 'Contenuto', SCM_THEME ) );

			return scm_acf_field( $name, array( 'objects-id', $type, $tax , __( 'Seleziona', SCM_THEME ) . ' ' . $label), $label, $width, $logic, $instr, $required );
		}
	}

	// INTERNAL OBJECT ID
	if ( ! function_exists( 'scm_acf_field_object_obj' ) ) {
		function scm_acf_field_object_obj( $name = '', $default = 0, $type = '', $width = '', $logic = 0, $label = '', $instr = '', $required = 0 ) {
			$label = ( $label ?: __( 'Contenuto', SCM_THEME ) );

			return scm_acf_field( $name, array( 'object', $type, '', __( 'Seleziona', SCM_THEME ) . ' ' . $label ), $label, $width, $logic, $instr, $required );
		}
	}

	// INTERNAL OBJECT ID
	if ( ! function_exists( 'scm_acf_field_object' ) ) {
		function scm_acf_field_object( $name = '', $default = 0, $type = '', $width = '', $logic = 0, $label = '', $instr = '', $required = 0 ) {
			$label = ( $label ?: __( 'Contenuto', SCM_THEME ) );

			return scm_acf_field( $name, array( 'object-id', $type, '', __( 'Seleziona', SCM_THEME ) . ' ' . $label ), $label, $width, $logic, $instr, $required );
		}
	}

	// INTERNAL OBJECT ID REL
	if ( ! function_exists( 'scm_acf_field_object_rel' ) ) {
		function scm_acf_field_object_rel( $name = '', $default = 0, $type = '', $width = '', $logic = 0, $label = '', $instr = '', $required = 0 ) {
			$label = ( $label ?: __( 'Contenuto', SCM_THEME ) );

			return scm_acf_field( $name, array( 'object-rel-id', $type, '', __( 'Seleziona', SCM_THEME ) . ' ' . $label ), $label, $width, $logic, $instr, $required );
		}
	}

	// INTERNAL OBJECTS
	if ( ! function_exists( 'scm_acf_field_object_objs' ) ) {
		function scm_acf_field_object_objs( $name = '', $default = 0, $type = '', $width = '', $logic = 0, $label = '', $instr = '', $required = 0 ) {
			$label = ( $label ?: __( 'Contenuto', SCM_THEME ) );

			return scm_acf_field( $name, array( 'objects', $type, '', __( 'Seleziona', SCM_THEME ) . ' ' . $label ), $label, $width, $logic, $instr, $required );
		}
	}

	// INTERNAL OBJECTS ID
	if ( ! function_exists( 'scm_acf_field_objects' ) ) {
		function scm_acf_field_objects( $name = '', $default = 0, $type = '', $width = '', $logic = 0, $label = '', $instr = '', $required = 0 ) {
			$label = ( $label ?: __( 'Contenuti', SCM_THEME ) );

			return scm_acf_field( $name, array( 'objects-id', $type, '', __( 'Seleziona', SCM_THEME ) . ' ' . $label ), $label, $width, $logic, $instr, $required );
		}
	}

	// INTERNAL OBJECTS ID REL
	if ( ! function_exists( 'scm_acf_field_objects_rel' ) ) {
		function scm_acf_field_objects_rel( $name = '', $default = 0, $type = '', $width = '', $logic = 0, $label = '', $instr = '', $required = 0 ) {
			$label = ( $label ?: __( 'Contenuti', SCM_THEME ) );

			return scm_acf_field( $name, array( 'objects-rel-id', $type, '', __( 'Seleziona', SCM_THEME ) . ' ' . $label ), $label, $width, $logic, $instr, $required );
		}
	}

	// INTERNAL LINKS
	if ( ! function_exists( 'scm_acf_field_object_link' ) ) {
		function scm_acf_field_object_link( $name = '', $default = 0, $type = '', $width = '', $logic = 0, $label = '', $instr = '', $required = 0 ) {
			$label = ( $label ?: __( 'Contenuto', SCM_THEME ) );

			return scm_acf_field( $name, array( 'object-link', $type, '', __( 'Seleziona', SCM_THEME ) . ' ' . $label ), $label, $width, $logic, $instr, $required );
		}
	}

	// INTERNAL LINKS
	if ( ! function_exists( 'scm_acf_field_objects_link' ) ) {
		function scm_acf_field_objects_link( $name = '', $default = 0, $type = '', $width = '', $logic = 0, $label = '', $instr = '', $required = 0 ) {
			$label = ( $label ?: __( 'Contenuti', SCM_THEME ) );

			return scm_acf_field( $name, array( 'objects-link', $type, '', __( 'Seleziona', SCM_THEME ) . ' ' . $label ), $label, $width, $logic, $instr, $required );
		}
	}

/* Taxonomy */

	// TAXONOMY
	if ( ! function_exists( 'scm_acf_field_taxonomy' ) ) {
		function scm_acf_field_taxonomy( $name = '', $default = 0, $tax = '', $label = '', $add = 1, $save = 0, $width = '', $logic = 0, $instr = '', $required = 0 ) {
			$label = ( $label ?: __( 'Taxonomy', SCM_THEME ) );

			//printPre( $name . ' - ' . $tax . ' - ' . $label . ' - ' . $save );

			return scm_acf_field( $name, array( 'taxonomy-id', $tax, $add, $save ), $label, $width, $logic, $instr, $required );
		}
	}

	// TAXONOMIES
	if ( ! function_exists( 'scm_acf_field_taxonomies' ) ) {
		function scm_acf_field_taxonomies( $name = '', $default = 0, $tax = '', $label = '', $add = 1, $save = 0, $width = '', $logic = 0, $instr = '', $required = 0 ) {
			$label = ( $label ?: __( 'Taxonomies', SCM_THEME ) );
			//printPre( $name . ' - ' . $tax . ' - ' . $label . ' - ' . $save );
			return scm_acf_field( $name, array( 'taxonomies-id', $tax, $add, $save ), $label, $width, $logic, $instr, $required );
		}
	}

/* Repeater */

	// REPEATER BLOCK
	if ( ! function_exists( 'scm_acf_field_repeater' ) ) {
		function scm_acf_field_repeater( $name = '', $default = 0, $button = '', $label = '', $width = '', $logic = 0, $min = '', $max = '', $instr = '', $required = 0, $class = '' ) {
			$button = ( $button ?: __( 'Aggiungi', SCM_THEME ) );
			$label = ( $label ?: __( 'Elementi', SCM_THEME ) );
			return scm_acf_field( $name, array( 'repeater-block', $button, $min, $max ), $label, 100, $logic, $instr, $required, $class );
		}
	}

	// REPEATER ROW
	if ( ! function_exists( 'scm_acf_field_repeater_row' ) ) {
		function scm_acf_field_repeater_row( $name = '', $default = 0, $button = '', $label = '', $width = '', $logic = 0, $min = '', $max = '', $instr = '', $required = 0, $class = '' ) {
			$button = ( $button ?: __( 'Aggiungi', SCM_THEME ) );
			$label = ( $label ?: __( 'Elementi', SCM_THEME ) );
			return scm_acf_field( $name, array( 'repeater-row', $button, $min, $max ), $label, 100, $logic, $instr, $required, $class );
		}
	}

	// REPEATER TABLE
	if ( ! function_exists( 'scm_acf_field_repeater_table' ) ) {
		function scm_acf_field_repeater_table( $name = '', $default = 0, $button = '', $label = '', $width = '', $logic = 0, $min = '', $max = '', $instr = '', $required = 0, $class = '' ) {
			$button = ( $button ?: __( 'Aggiungi', SCM_THEME ) );
			$label = ( $label ?: __( 'Elementi', SCM_THEME ) );
			return scm_acf_field( $name, array( 'repeater-table', $button, $min, $max ), $label, 100, $logic, $instr, $required, $class );
		}
	}

/* Flexible Content */

	// FLEXIBLE CONTENT
	if ( ! function_exists( 'scm_acf_field_flexible' ) ) {
		function scm_acf_field_flexible( $name = '', $default = 0, $label = '', $button = '+', $width = '', $logic = 0, $min = '', $max = '', $instr = '', $required = 0, $class = '' ) {
			$label = ( $label ?: __( 'Componi', SCM_THEME ) );
			return scm_acf_field( $name, array( 'flexible', $button, $min, $max ), $label, 100, $logic, $instr, $required, $class );
		}
	}

// *****************************************************
// 2.0 PRESETS
// *****************************************************

	// SELECTORS
	if ( ! function_exists( 'scm_acf_preset_selectors' ) ) {
		function scm_acf_preset_selectors( $name = 'selectors', $default = 0, $w1 = 100, $w2 = 100, $logic = 0, $pl1 = '', $pl2 = '', $lb1 = '', $lb2 = '', $instr = '', $req = 0 ) {
			$pl1 = ( $pl1 ?: __( 'id', SCM_THEME ) );
			$pl2 = ( $pl2 ?: __( 'class', SCM_THEME ) );
			$lb1 = ( $lb1 ?: __( 'ID', SCM_THEME ) );
			$lb2 = ( $lb2 ?: __( 'Class', SCM_THEME  ) );

			$fields = array();

			if( $instr )
				$fields[] = scm_acf_field( 'msg-open-' . $name, array( 'message', $instr ), __( 'Aggiungi Selettori', SCM_THEME ) );

			$name = ( $name ? $name . '-' : '');

			$fields[] = scm_acf_field_id( $name . 'id', $default, $w1, $logic, $pl1 , $lb1, $instr, $req );
			$fields[] = scm_acf_field_class( $name . 'class', $default, $w2, $logic, $pl2, $lb2, $instr, $req );

			return $fields;
		}
	}

	// SIZE
	if ( ! function_exists( 'scm_acf_preset_size' ) ) {
		function scm_acf_preset_size( $name = 'size', $default = 0, $pl1 = 'auto', $pl2 = 'px', $lb1 = '', $logic = 0, $w1 = '', $w2 = '', $lb2 = '', $instr = '', $req = 0 ) {
			$lb1 = ( $lb1 ?: __( 'Dimensione', SCM_THEME ) );
			$lb2 = ( $lb2 ?: __( 'Unità', SCM_THEME ) );

			$fields = array();

			$fields = array();

			if( $w1 === '' )
				$w1 = $w2 = 50;
			if( $w2 === '' ){
				$w2 = .5 * $w1;
				$w1 = .5 * $w1;
			}

			if( $instr )
				$fields[] = scm_acf_field( 'msg-open-' . $name, array( 'message', $instr ), __( 'Imposta', SCM_THEME ) . ' ' . $lb1 );

			$name = ( $name ? $name . '-' : '');

			$fields[] = scm_acf_field_positive( $name . 'number', $default, $w1, $logic, $pl1, $lb1, '', $req );
			$fields[] = scm_acf_field_select_units( $name . 'units', $default, $w2, $logic, $pl2, $lb2, '', $req );

			return $fields;
		}
	}

	// POSITION
	if ( ! function_exists( 'scm_acf_preset_position' ) ) {
		function scm_acf_preset_position( $name = 'position', $default = 0, $pl1 = 'auto', $pl2 = 'px', $lb1 = '', $logic = 0, $w1 = '', $w2 = '', $lb2 = '', $instr = '', $req = 0 ) {
			$lb1 = ( $lb1 ?: __( 'Posizione', SCM_THEME ) );
			$lb2 = ( $lb2 ?: __( 'Unità', SCM_THEME ) );

			$fields = array();

			$fields = array();

			if( $w1 === '' )
				$w1 = $w2 = 50;
			if( $w2 === '' ){
				$w2 = .5 * $w1;
				$w1 = .5 * $w1;
			}

			if( $instr )
				$fields[] = scm_acf_field( 'msg-open-' . $name, array( 'message', $instr ), __( 'Imposta', SCM_THEME ) . ' ' . $lb1 );

			$name = ( $name ? $name . '-' : '');

			$fields[] = scm_acf_field_number( $name . 'number', $default, $w1, $logic, $pl1, $lb1, '', $req );
			$fields[] = scm_acf_field_select_units( $name . 'units', $default, $w2, $logic, $pl2, $lb2, '', $req );

			return $fields;
		}
	}
	
	// COLOR
	if ( ! function_exists( 'scm_acf_preset_rgba' ) ) {
		function scm_acf_preset_rgba( $name = 'rgba', $default = 0, $pl1 = '', $pl2 = '1', $logic = 0, $w1 = '', $w2 = '', $lb2 = '', $lb1 = '', $instr = '', $req = 0 ) {
			$lb2 = ( $lb2 ?: __( 'Trasparenza', SCM_THEME ) );
			$lb1 = ( $lb1 ?: __( 'Colore', SCM_THEME ) );

			$fields = array();

			if( $w1 === '' )
				$w1 = $w2 = 50;
			if( $w2 === '' ){
				$w2 = .5 * $w1;
				$w1 = .5 * $w1;
			}

			if( $instr )
				$fields[] = scm_acf_field( 'msg-open-' . $name, array( 'message', $instr ), __( 'Imposta', SCM_THEME ) .' ' . $lb1 );

			$name = ( $name ? $name . '-' : '');

			$fields[] = scm_acf_field_color( $name . 'color', $default, $w1, $logic, $pl1, $lb1, '', $req );
			$fields[] = scm_acf_field_alpha( $name . 'alpha', $default, $w2, $logic, $pl2, $lb2, '', $req );

			return $fields;
		}
	}

	// TXT COLOR
	if ( ! function_exists( 'scm_acf_preset_rgba_txt' ) ) {
		function scm_acf_preset_rgba_txt( $name = 'rgba-txt', $default = 0, $pl1 = '', $pl2 = '1', $logic = 0, $w1 = '', $w2 = '', $lb2 = '', $lb1 = '', $instr = '', $req = 0 ) {
			$lb2 = ( $lb2 ?: __( 'Trasparenza', SCM_THEME ) );
			$lb1 = ( $lb1 ?: __( 'Colore Testi', SCM_THEME ) );

			$fields = array();

			$fields = array();

			if( $w1 === '' )
				$w1 = $w2 = 50;
			if( $w2 === '' ){
				$w2 = .5 * $w1;
				$w1 = .5 * $w1;
			}

			if( $instr )
				$fields[] = scm_acf_field( 'msg-open-' . $name, array( 'message', $instr ), __( 'Imposta', SCM_THEME ) .' ' . $lb1 );

			$name = ( $name ? $name . '-' : '');

			$fields[] = scm_acf_field_color( $name . 'color', $default, $w1, $logic, $pl1, $lb1, '', $req );
			$fields[] = scm_acf_field_alpha( $name . 'alpha', $default, $w2, $logic, $pl2, $lb2, '', $req );

			return $fields;
		}
	}

	// BG COLOR
	if ( ! function_exists( 'scm_acf_preset_rgba_bg' ) ) {
		function scm_acf_preset_rgba_bg( $name = 'rgba-bg', $default = 0, $pl1 = '', $pl2 = '1', $logic = 0, $w1 = '', $w2 = '', $lb2 = '', $lb1 = '', $instr = '', $req = 0 ) {
			$lb2 = ( $lb2 ?: __( 'Trasparenza', SCM_THEME ) );
			$lb1 = ( $lb1 ?: __( 'Colore Sfondo', SCM_THEME ) );

			$fields = array();

			if( $w1 === '' )
				$w1 = $w2 = 50;
			if( $w2 === '' ){
				$w2 = .5 * $w1;
				$w1 = .5 * $w1;
			}

			if( $instr )
				$fields[] = scm_acf_field( 'msg-open-' . $name, array( 'message', $instr ), __( 'Imposta', SCM_THEME ) .' ' . $lb1 );

			$name = ( $name ? $name . '-' : '');

			$fields[] = scm_acf_field_color( $name . 'color', $default, $w1, $logic, $pl1, $lb1, '', $req );
			$fields[] = scm_acf_field_alpha( $name . 'alpha', $default, $w2, $logic, $pl2, $lb2, '', $req );

			return $fields;
		}
	}

	// BACKGROUND STYLE
	if ( ! function_exists( 'scm_acf_preset_background_style' ) ) {
		function scm_acf_preset_background_style( $name = 'bg-style', $default = 0, $width = 100, $logic = 0, $pl1 = '', $pl2 = 'center center', $pl3 = 'auto auto', $instr = '', $req = 0 ) {

			$fields = array();

			if( $instr )
				$fields[] = scm_acf_field( 'msg-open-' . $name, array( 'message', $instr ), __( 'Impostazioni Sfondo', SCM_THEME ) );

			$name = ( $name ? $name . '-' : '');

			$fields = array_merge( $fields, scm_acf_preset_rgba_bg( $name . 'rgba', $default, '', 1, $logic, $width ) );
			$fields[] = scm_acf_field_image( $name . 'image', $default, $width, $logic, __( 'Immagine', SCM_THEME ) );
			$fields[] = scm_acf_field_select1( $name . 'repeat', $default, 'bg_repeat', $width, $logic, $pl1, __( 'Ripetizione', SCM_THEME ) );
			$fields[] = scm_acf_field_text( $name . 'position', $default, $width, $logic, $pl2, __( 'Posizione', SCM_THEME ) );
			$fields[] = scm_acf_field_text( $name . 'size', $default, $width, $logic, $pl3, __( 'Dimensione', SCM_THEME ) );

			return $fields;
		}
	}

	// TEXT FONT
	if ( ! function_exists( 'scm_acf_preset_text_font' ) ) {
		function scm_acf_preset_text_font( $name = 'txt-font', $default = 0, $logic = 0, $w1 = 100, $w2 = 100, $w3 = 100, $instr = '', $req = 0 ) {

			$fields = array();

			if( $instr )
				$fields[] = scm_acf_field( 'msg-open-' . $name, array( 'message', $instr ), __( 'Impostazioni Testi', SCM_THEME ) );

			$name = ( $name ? $name . '-' : '');

			$fields[] = scm_acf_field_select1( $name . 'adobe', $default, 'webfonts_adobe', $w1, $logic, '', 'Adobe TypeKit' );
			$fields[] = scm_acf_field_select1( $name . 'google', $default, 'webfonts_google', $w2, $logic, '', 'Google Font' );
			$fields[] = scm_acf_field_select1( $name . 'fallback', $default, 'webfonts_fallback', $w3, $logic, '', __( 'Famiglia', SCM_THEME ) );

			return $fields;
		}
	}
	
	// TEXT SET
	if ( ! function_exists( 'scm_acf_preset_text_set' ) ) {
		function scm_acf_preset_text_set( $name = 'txt-settings', $default = 0, $logic = 0, $w1 = 100, $w2 = 100, $w3 = 100, $w4 = 100, $instr = '', $req = 0 ) {

			$fields = array();

			if( $instr )
				$fields[] = scm_acf_field( 'msg-open-' . $name, array( 'message', $instr ), __( 'Impostazioni Testi', SCM_THEME ) );

			$name = ( $name ? $name . '-' : '');

			$fields[] = scm_acf_field_select1( $name . 'alignment', $default, 'txt_alignment', $w1, $logic, '', __( 'Allineamento', SCM_THEME ) );
			$fields[] = scm_acf_field_select1( $name . 'weight', $default, 'font_weight', $w2, $logic, '', __( 'Spessore', SCM_THEME ) );
			$fields[] = scm_acf_field_select1( $name . 'size', $default, 'txt_size', $w3, $logic, '', __( 'Dimensione', SCM_THEME ) );
			$fields[] = scm_acf_field_select1( $name . 'line-height', $default, 'line_height', $w4, $logic, '', __( 'Interlinea', SCM_THEME ) );

			return $fields;
		}
	}

	// TEXT SHADOW
	if ( ! function_exists( 'scm_acf_preset_text_shadow' ) ) {
		function scm_acf_preset_text_shadow( $name = 'txt-shadow', $default = 0, $logic = 0, $instr = '', $req = 0 ) {

			$fields = array();

			if( $instr )
				$fields[] = scm_acf_field( 'msg-open-' . $name, array( 'message', $instr ), __( 'Impostazioni Testi', SCM_THEME ) );

			$name = ( $name ? $name . '-' : '');

			$fields = array_merge( $fields, scm_acf_preset_position( $name . 'x', $default, '1', 'px', 'X', $logic ) );
			$fields = array_merge( $fields, scm_acf_preset_position( $name . 'y', $default, '1', 'px', 'Y', $logic ) );
			$fields = array_merge( $fields, scm_acf_preset_size( $name . 'size', $default, '1', 'px', __( 'Dimensione', SCM_THEME ), $logic ) );
			$fields = array_merge( $fields, scm_acf_preset_rgba( $name . 'rgba', $default, '#000000', .5, $logic ) );

			return $fields;
		}
	}

	// TEXT STYLE
	if ( ! function_exists( 'scm_acf_preset_text_style' ) ) {
		function scm_acf_preset_text_style( $name = 'txt-style', $default = 0, $instr = '', $req = 0 ) {

			$fields = array();

			if( $instr )
				$fields[] = scm_acf_field( 'msg-open-' . $name, array( 'message', $instr ), __( 'Impostazioni Testi', SCM_THEME ) );

			$name = ( $name ? $name . '-' : '');

			$fields = array_merge( $fields, scm_acf_preset_rgba_txt( $name . 'rgba', $default ) );
			$fields = array_merge( $fields, scm_acf_preset_text_font( $name . 'webfonts', $default ) );
			$fields = array_merge( $fields, scm_acf_preset_text_set( $name . 'set', $default ) );

			// conditional ombra
			$fields[] = scm_acf_field_select_disable( $name . 'shadow', $default, __( 'Ombra', SCM_THEME ) );
			$condition = array(
				'field' => $name . 'shadow',
				'operator' => '==',
				'value' => 'on',
			);
				
				$fields = array_merge( $fields, scm_acf_preset_text_shadow( $name . 'txt-shadow', $default, $condition ) );

			return $fields;
		}
	}

	// BOX SHAPE
	if ( ! function_exists( 'scm_acf_preset_box_shape' ) ) {
		function scm_acf_preset_box_shape( $name = 'box-shape', $default = 0, $width = 100, $logic = 0, $placeholder = '', $instr = '', $req = 0 ) {

			$fields = array();

			$fields[] = scm_acf_field_select1( $name . 'shape', $default, 'box_shape-no', $width, $logic, __( 'Forma', SCM_THEME ), __( 'Forma Box', SCM_THEME ) );
				
				$shape = array( $logic, array( 'field' => $name . 'shape', 'operator' => '!=', 'value' => 'no' ) );
				$rounded = scm_acf_group_condition( $logic, $shape, array( 'field' => $name . 'shape', 'operator' => '!=', 'value' => 'square' ) );

					$fields[] = scm_acf_field_select1( $name . 'shape-angle', $default, 'box_angle_type', $width * .5, $rounded, __( 'Angoli', SCM_THEME ), __( 'Angoli Box', SCM_THEME ) );
					$fields[] = scm_acf_field_select1( $name . 'shape-size', $default, 'simple_size', $width * .5, $rounded, __( 'Dimensione', SCM_THEME ), __( 'Dimensione angoli Box', SCM_THEME ) );
			
			return $fields;

		}
	}

	// BOX STYLE
	if ( ! function_exists( 'scm_acf_preset_box_style' ) ) {
		function scm_acf_preset_box_style( $name = 'box-style', $default = 0, $instr = '', $req = 0 ) {

			$fields = array();

			if( $instr )
				$fields[] = scm_acf_field( 'msg-open-' . $name, array( 'message', $instr ), __( 'Impostazioni Box', SCM_THEME ) );

			$name = ( $name ? $name . '-' : '');

			$fields[] = scm_acf_field_text( $name . 'margin', $default, 100, 0, '0 0 0 0', __( 'Margin', SCM_THEME ) );
			$fields[] = scm_acf_field_text( $name . 'padding', $default, 100, 0, '0 0 0 0', __( 'Padding', SCM_THEME ) );
			$fields[] = scm_acf_field_alpha( $name . 'alpha', $default, 100, 0, '1', __( 'Trasparenza', SCM_THEME ) );
			$fields = array_merge( $fields, scm_acf_preset_box_shape( $name, $default ) );

			return $fields;

		}
	}
	
	// MAP ICON
	if ( ! function_exists( 'scm_acf_preset_map_icon' ) ) {
		function scm_acf_preset_map_icon( $name = 'map-icon', $default = 0, $w1 = 100, $logic = 0, $label = '', $instr = '', $req = 0 ) {
			$label = ( $label ?: __( 'Icona', SCM_THEME ) );
			
			$fields = array();

			if( $instr )
				$fields[] = scm_acf_field( 'msg-open-' . $name, array( 'message', $instr ), $label, $w1 );

			$name = ( $name ? $name . '-' : '');

			$fields[] = scm_acf_field_select1( $name . 'icon', $default, 'luogo-mappa', $w1, $logic, array( 'icon' => __( 'Icona', SCM_THEME ), 'img' => __( 'Immagine', SCM_THEME ) ), __( 'Icona Mappa', SCM_THEME ) );

			$icon = array( 'field' => $name . 'icon', 'operator' => '==', 'value' => 'icon' );
			$icon = ( $logic ? scm_acf_group_condition( $icon, $logic ) : $icon );
			$img = array( 'field' => $name . 'icon', 'operator' => '==', 'value' => 'img' );
			$img = ( $logic ? scm_acf_group_condition( $img, $logic ) : $img );
				
				$fields[] = scm_acf_field_icon( $name . 'icon-fa', $default, 'map-marker', '', '', $icon, __( 'Seleziona un\'icona', SCM_THEME ) );
				$fields = array_merge( $fields, scm_acf_preset_rgba( $name . 'rgba', $default, '#e3695f', 1, $icon ) );
				$fields[] = scm_acf_field_image( $name . 'icon-img', $default, '', $img, __( 'Carica un\'immagine', SCM_THEME ) );

			return $fields;

		}
	}

	// TERM
	if ( ! function_exists( 'scm_acf_preset_term' ) ) {
		function scm_acf_preset_term( $name = 'term', $default = 0, $tax = 'category', $placeholder = '', $logic = 0, $add = 0, $save = 0, $w1 = '', $lb1 = '', $instr = '', $required = 0, $class = '' ) {
			$placeholder = ( $placeholder ?: __( 'Termine', SCM_THEME ) );
			$lb1 = ( $lb1 ?: __( 'Seleziona', SCM_THEME ) );
			
			$fields = array();

			if( $instr )
				$fields[] = scm_acf_field( 'msg-open-' . $name, array( 'message', $instr ), $placeholder );

			$name = ( $name ? $name . '-' : '');

			$fields[] = scm_acf_field_taxonomy( $name . 'terms', $default, $tax, $lb1 . ' ' . $placeholder, $add, $save, $w1, $logic, $instr, $required );

			return $fields;
		}
	}

	// TERMS
	if ( ! function_exists( 'scm_acf_preset_terms' ) ) {
		function scm_acf_preset_terms( $name = 'terms', $default = 0, $tax = 'category', $placeholder = '', $logic = 0, $add = 0, $save = 0, $w1 = '', $lb1 = '', $instr = '', $required = 0, $class = '' ) {
			$placeholder = ( $placeholder ?: __( 'Termini', SCM_THEME ) );
			$lb1 = ( $lb1 ?: __( 'Seleziona', SCM_THEME ) );
			
			$fields = array();

			if( $instr )
				$fields[] = scm_acf_field( 'msg-open-' . $name, array( 'message', $instr ), $placeholder );

			$name = ( $name ? $name . '-' : '');

			$fields[] = scm_acf_field_taxonomies( $name . 'terms', $default, $tax, $lb1 . ' ' . $placeholder, $add, $save, $w1, $logic, $instr, $required );

			return $fields;
		}
	}

	// TAXONOMY
	if ( ! function_exists( 'scm_acf_preset_taxonomy' ) ) {
		function scm_acf_preset_taxonomy( $name = 'taxonomy', $default = 0, $type = 'post', $logic = 0, $add = 0, $save = 0, $w1 = '', $lb1 = '', $instr = '', $placeholder = '', $required = 0, $class = '' ) {
			$placeholder = ( $placeholder ?: __( 'Seleziona Relazione', SCM_THEME ) );
			$lb1 = ( $lb1 ?: __( 'Seleziona', SCM_THEME ) );

			$fields = array();

			if( $instr )
				$fields[] = scm_acf_field( 'msg-open-' . $name, array( 'message', $instr ), $placeholder );

			$name = ( $name ? $name . '-' : '');

			$taxes = get_object_taxonomies( $type, 'objects' );
			reset( $taxes );
			foreach ($taxes as $key => $value) {
				if( $key != 'language' && $key != 'post_translations' )
					$fields = array_merge( $fields, scm_acf_preset_term( $name . $value->name, $default, $value->name, $value->labels->singular_name, $logic, $add, $save, $w1, $lb1, '', $required, $class ) );
			}

			return $fields;
		}
	}

	// TAXONOMIES
	if ( ! function_exists( 'scm_acf_preset_taxonomies' ) ) {
		function scm_acf_preset_taxonomies( $name = 'taxonomies', $default = 0, $type = 'post', $logic = 0, $add = 0, $save = 0, $w1 = '', $lb1 = '', $instr = '', $placeholder = '', $required = 0, $class = '' ) {
			$placeholder = ( $placeholder ?: __( 'Seleziona Relazioni', SCM_THEME ) );
			$lb1 = ( $lb1 ?: __( 'Seleziona', SCM_THEME ) );

			$fields = array();

			if( $instr )
				$fields[] = scm_acf_field( 'msg-open-' . $name, array( 'message', $instr ), $placeholder );

			$taxes = get_object_taxonomies( $type, 'objects' );

			$name = ( $name ? $name . '-' : '');

			reset( $taxes );
			foreach ($taxes as $key => $value) {
				if( $key != 'language' && $key != 'post_translations' )
					$fields = array_merge( $fields, scm_acf_preset_terms( $name . $value->name, $default, $value->name, $value->label, $logic, $add, $save, $w1, $lb1, '', $required, $class ) );
			}

			return $fields;
		}
	}

	// CATEGORY REQUIRED
	if ( ! function_exists( 'scm_acf_preset_category_req' ) ) {
		function scm_acf_preset_category_req( $name = 'category', $default = 0, $type = 'post', $save = 1, $logic = 0, $w1 = 100, $lb1 = '', $instr = '', $placeholder = '', $required = 1, $class = '' ) {		
			$placeholder = ( $placeholder ?: __( 'Seleziona Tipologia', SCM_THEME ) );
			$lb1 = ( $lb1 ?: __( 'Seleziona', SCM_THEME ) );

			$fields = array();

			if( $instr )
				$fields[] = scm_acf_field( 'msg-open-' . $name, array( 'message', $instr ), $placeholder );

			$name = ( $name ? $name . '-' : '');

			$taxes = get_object_taxonomies( $type, 'objects' );
			reset( $taxes );
			foreach ($taxes as $key => $value) {
				if( $value->hierarchical && $key != 'language' && $key != 'post_translations' )
					$fields = array_merge( $fields, scm_acf_preset_term( $name . $value->name, $default, $value->name, $value->labels->singular_name, $logic, 0, $save, $w1, $lb1, '', $required, $class ) );
			}

			return $fields;
		}
	}

	// CATEGORY
	if ( ! function_exists( 'scm_acf_preset_category' ) ) {
		function scm_acf_preset_category( $name = 'category', $default = 0, $type = 'post', $save = 1, $logic = 0, $w1 = 100, $lb1 = '', $instr = '', $placeholder = '', $required = 0, $class = '' ) {		
			$placeholder = ( $placeholder ?: __( 'Seleziona Tipologia', SCM_THEME ) );
			$lb1 = ( $lb1 ?: __( 'Seleziona', SCM_THEME ) );

			$fields = array();

			if( $instr )
				$fields[] = scm_acf_field( 'msg-open-' . $name, array( 'message', $instr ), $placeholder );

			$name = ( $name ? $name . '-' : '');

			$taxes = get_object_taxonomies( $type, 'objects' );
			reset( $taxes );
			foreach ($taxes as $key => $value) {
				if( $value->hierarchical && $key != 'language' && $key != 'post_translations' )
					$fields = array_merge( $fields, scm_acf_preset_term( $name . $value->name, $default, $value->name, $value->labels->singular_name, $logic, 0, $save, $w1, $lb1, '', $required, $class ) );
			}

			return $fields;
		}
	}

	// CATEGORIES
	if ( ! function_exists( 'scm_acf_preset_categories' ) ) {
		function scm_acf_preset_categories( $name = 'categories', $default = 0, $type = 'post', $save = 1, $logic = 0, $w1 = 100, $lb1 = '', $instr = '', $placeholder = '', $required = 0, $class = '' ) {
			$placeholder = ( $placeholder ?: __( 'Seleziona Tipologie', SCM_THEME ) );
			$lb1 = ( $lb1 ?: __( 'Seleziona', SCM_THEME ) );

			$fields = array();

			if( $instr )
				$fields[] = scm_acf_field( 'msg-open-' . $name, array( 'message', $instr ), $placeholder );

			$name = ( $name ? $name . '-' : '');

			$taxes = get_object_taxonomies( $type, 'objects' );
			reset( $taxes );
			foreach ($taxes as $key => $value) {
				if( $value->hierarchical && $key != 'language' && $key != 'post_translations' )
					$fields = array_merge( $fields, scm_acf_preset_terms( $name . $value->name, $default, $value->name, $value->label, $logic, 0, $save, $w1, $lb1, '', $required, $class ) );
			}

			return $fields;
		}
	}

	// TAG
	if ( ! function_exists( 'scm_acf_preset_tag' ) ) {
		function scm_acf_preset_tag( $name = 'tag', $default = 0, $type = 'post_tag', $save = 1, $logic = 0, $w1 = '', $lb1 = '', $instr = '', $placeholder = '', $required = 0, $class = '' ) {
			$placeholder = ( $placeholder ?: __( 'Seleziona Categoria', SCM_THEME ) );
			$lb1 = ( $lb1 ?: __( 'Seleziona', SCM_THEME ) );

			$fields = array();

			if( $instr )
				$fields[] = scm_acf_field( 'msg-open-' . $name, array( 'message', $instr ), $placeholder );

			$name = ( $name ? $name . '-' : '');

			$taxes = get_object_taxonomies( $type, 'objects' );
			reset( $taxes );
			foreach ($taxes as $key => $value) {
				if( !$value->hierarchical && $key != 'language' && $key != 'post_translations' )
					$fields = array_merge( $fields, scm_acf_preset_term( $name . $value->name, $default, $value->name, $value->labels->singular_name, $logic, 0, $save, $w1, $lb1, '', $required, $class ) );
			}

			return $fields;
		}
	}

	// TAGS
	if ( ! function_exists( 'scm_acf_preset_tags' ) ) {
		function scm_acf_preset_tags( $name = 'tags', $default = 0, $type = 'post_tag', $save = 1, $logic = 0, $w1 = '', $lb1 = '', $instr = '', $placeholder = '', $required = 0, $class = '' ) {
			$placeholder = ( $placeholder ?: __( 'Seleziona Categorie', SCM_THEME ) );
			$lb1 = ( $lb1 ?: __( 'Seleziona', SCM_THEME ) );

			$fields = array();

			if( $instr )
				$fields[] = scm_acf_field( 'msg-open-' . $name, array( 'message', $instr ), $placeholder );
			
			$name = ( $name ? $name . '-' : '');

			$taxes = get_object_taxonomies( $type, 'objects' );
			reset( $taxes );
			foreach ($taxes as $key => $value) {
				if( !$value->hierarchical && $key != 'language' && $key != 'post_translations' )
					$fields = array_merge( $fields, scm_acf_preset_terms( $name . $value->name, $default, $value->name, $value->label, $logic, 1, $save, $w1, $lb1, '', $required, $class ) );
			}

			return $fields;
		}
	}

	// COLUMNS
	if ( ! function_exists( 'scm_acf_preset_repeater_columns' ) ) {
		function scm_acf_preset_repeater_columns( $name = '', $default = 0, $elements = '', $logic = 0, $instr = '', $required = 0, $class = 'special-repeater' ) {

			$fields = array();

			if( $instr )
				$fields[] = scm_acf_field( 'msg-open-columns' . ( $name ? '-' . $name : '' ), array( 'message', $instr ), __( 'Istruzioni Colonne', SCM_THEME ) );

			$name = ( $name ? $name . '-' : '');

			$columns = scm_acf_field_repeater( $name . 'columns', $default, __( 'Aggiungi Colonna', SCM_THEME ), __( 'Colonne', SCM_THEME ), 100, $logic, '', '', '', $required, $class );

				$columns['sub_fields'][] = scm_acf_field_select_column_width( 'column-width',  $default, 36, 0, '1/1', __( 'Larghezza', SCM_THEME ) );
				$columns['sub_fields'] = array_merge( $columns['sub_fields'], scm_acf_preset_selectors( '', $default, 24, 36 ) );
				$columns['sub_fields'] = array_merge( $columns['sub_fields'], scm_acf_preset_flexible_elements( '', $default, $elements ) );
				
			$fields[] = $columns;
			
			return $fields;
		}
	}

	// BUTTON
	if ( ! function_exists( 'scm_acf_preset_button' ) ) {
		function scm_acf_preset_button( $name = '', $default = 0, $type = 'link', $placeholder = '', $filter = '', $tooltip = 0, $pl2 = '', $pl3 = '', $logic = 0, $instr = '', $required = 0 ) {
			$pl2 = ( $pl2 ?: __( 'Nome', SCM_THEME ) );
			
			$fields = array();

			$name = ( $name ? $name . '-' : '');

			$fields[] = scm_acf_field_icon_no( $name . 'icon', $default, ( $placeholder ?: 'no' ), $filter, 25, 0, __( 'Seleziona un\'icona', SCM_THEME ) );
			$fields[] = scm_acf_field_name( $name . 'name', $default, 30, 30, 0, $pl2 );

			switch ( $type ) {
				case 'link':
					$fields[] = scm_acf_field_link( $name . 'link', $default, 45, 0, ( $pl3 ?: __( 'Inserisci un Link', SCM_THEME ) ) );
				break;
				
				case 'file':
					$fields[] = scm_acf_field_file( $name . 'link', $default, 45, 0, $pl3 );
				break;

				case 'page':
					$fields[] = scm_acf_field_object_link( $name . 'link', $default, 'page', 45, 0, ( $pl3 ?: __( 'Pagina', SCM_THEME ) ) );
				break;
				
				case 'media':
					$fields[] = scm_acf_field_object( $name . 'link', $default, array( 'rassegne-stampa', 'documenti', 'gallerie', 'video' ), 45, 0, ( $pl3 ?: __( 'Media', SCM_THEME ) ) );
				break;

				case 'paypal':
					$fields[] = scm_acf_field_text( $name . 'link', $default, 45, 0, ( $pl3 ?: __( 'Inserisci Codice PayPal', SCM_THEME ) ), __( 'Code', SCM_THEME ) );
				break;
				
				default:
					$fields[] = scm_acf_field_object( $name . 'link', $default, $type, 45, 0, ( $pl3 ?: __( 'Elemento', SCM_THEME ) ) );
				break;
			}
			
			if( $tooltip )
				$fields[] = scm_acf_field_text( $name . 'tooltip', $default, 100, 0, '', __( 'Tooltip', SCM_THEME ) );

			return $fields;

		}
	}

	// ICONS
	if ( ! function_exists( 'scm_acf_preset_flexible_buttons' ) ) {
		function scm_acf_preset_flexible_buttons( $name = '', $default = 0, $group = '', $label = '', $logic = 0, $instr = '', $required = 0, $class = 'buttons-flexible' ) {

			$fields = array();

			global $SCM_fa;

			if( !isset( $SCM_fa[ $group ] ) )
				return $fields;

			if( $instr )
				$fields[] = scm_acf_field( 'msg-open-buttons' . ( $name ? '-' . $name : '' ), array( 'message', $instr ), __( 'Istruzioni Pulsanti', SCM_THEME ) . ' ' . $label );

			$name = ( $name ? $name . '-' : '');

			$contacts = scm_acf_field_flexible( $name . 'buttons' , $default, __( 'Aggiungi Pulsante', SCM_THEME ), '+' );			

				foreach ( $SCM_fa[ $group ] as $key => $value ) {

					if( $key == 'other' )
						continue;
					
					$layout = scm_acf_layout( $key, 'block', $value[ 'name' ] );

						$layout['sub_fields'] = scm_acf_preset_button( '', $default, 'link', $key . '_' . $group, $key, 0, $value[ 'name' ], __( 'Inserisci un Link', SCM_THEME ) );

					$contacts['layouts'][] = $layout;
				}

			$fields[] = $contacts;

			return $fields;

		}
	}

	// BUTTON SHAPE
	if ( ! function_exists( 'scm_acf_preset_button_shape' ) ) {
		function scm_acf_preset_button_shape( $name = 'but-style', $default = 0, $width = 100, $logic = 0, $placeholder = '', $instr = '', $req = 0 ) {

			$fields = array();
			
			//$fields = array_merge( $fields, scm_acf_preset_rgba( $name . 'rgba', $default ) );

			$fields[] = scm_acf_field_select1( $name . 'shape', $default, 'box_shape-no', 100, $logic, __( 'Forma', SCM_THEME ), __( 'Forma Box', SCM_THEME ) );
				
				$shape = array( $logic, array( 'field' => $name . 'shape', 'operator' => '!=', 'value' => 'no' ) );
				$rounded = scm_acf_group_condition( $logic, $shape, array( 'field' => $name . 'shape', 'operator' => '!=', 'value' => 'square' ) );

					$fields[] = scm_acf_field_select1( $name . 'shape-angle', $default, 'box_angle_type', 50, $rounded, __( 'Angoli', SCM_THEME ), __( 'Angoli Box', SCM_THEME ) );
					$fields[] = scm_acf_field_select1( $name . 'shape-size', $default, 'simple_size', 50, $rounded, __( 'Dimensione', SCM_THEME ), __( 'Dimensione angoli Box', SCM_THEME ) );
					
				//$fields = array_merge( $fields, scm_acf_preset_rgba( $name . 'box', $default, '', 1, $shape ) );

			return $fields;
			
		}
	}

	// SECTIONS
	if ( ! function_exists( 'scm_acf_preset_flexible_sections' ) ) {
		function scm_acf_preset_flexible_sections( $name = '', $default = 0, $elements = '', $logic = 0, $instr = '', $required = 0, $class = 'rows-flexible' ) {

			$fields = array();

			if( $instr )
				$fields[] = scm_acf_field( 'msg-open-sections' . ( $name ? '-' . $name : '' ), array( 'message', $instr ), __( 'Istruzioni Righe', SCM_THEME ) );

			$name = ( $name ? $name . '-' : '');

			$sections = scm_acf_field_repeater( $name . 'sections', $default, __( 'Aggiungi Sezione', SCM_THEME ), __( 'Sezioni', SCM_THEME ), 100, $logic, '', '', '', $required, $class );

				$sections['sub_fields'] = array_merge( $sections['sub_fields'], scm_acf_preset_selectors( '', $default, 25, 25 ) );
				$sections['sub_fields'][] = scm_acf_field( 'attributes', 'attributes', __( 'Attributi', SCM_THEME ), 50 );

				$flexible = scm_acf_field_flexible( 'rows', $default, __( 'Moduli', SCM_THEME ) );			

					$template = scm_acf_layout( 'template', 'block', __( 'Template', SCM_THEME ) );
						
						$template['sub_fields'][] = scm_acf_field_select_layout( 'layout', 1, __( 'Layout', SCM_THEME ), 20 );
						$template['sub_fields'] = array_merge( $template['sub_fields'], scm_acf_preset_selectors( '', $default, 20, 20 ) );
						$template['sub_fields'][] = scm_acf_field( 'attributes', 'attributes', __( 'Attributi', SCM_THEME ), 40 );
						$template['sub_fields'][] = scm_acf_field_text( 'archive', $default, 100, 0, 'type{:field=value}', __( 'Archivio', SCM_THEME ) );
						$template['sub_fields'][] = scm_acf_field_text( 'post', $default, 100, 0, __( 'ID or Option Name', SCM_THEME ), __( 'Post', SCM_THEME ) );
						$template['sub_fields'][] = scm_acf_field_positive( 'template', $default, 100, 0, 0, __( 'Template', SCM_THEME ) );

					$row = scm_acf_layout( 'row', 'block', 'Section' );
						
						$row['sub_fields'][] = scm_acf_field_select_layout( 'layout', 1, __( 'Layout', SCM_THEME ), 20 );
						$row['sub_fields'] = array_merge( $row['sub_fields'], scm_acf_preset_selectors( '', $default, 20, 20 ) );
						$row['sub_fields'][] = scm_acf_field( 'attributes', 'attributes', __( 'Attributi', SCM_THEME ), 40 );
						$row['sub_fields'][] = scm_acf_field_object( 'row', $default, 'sections' );

					$module = scm_acf_layout( 'module', 'block', 'Module' );

						$module['sub_fields'][] = scm_acf_field_select_layout( 'layout', 1, __( 'Layout', SCM_THEME ), 20 );
						$module['sub_fields'] = array_merge( $module['sub_fields'], scm_acf_preset_selectors( '', $default, 20, 20 ) );
						$module['sub_fields'][] = scm_acf_field( 'attributes', 'attributes', __( 'Attributi', SCM_THEME ), 40 );
						$module['sub_fields'][] = scm_acf_field_object( 'row', $default, 'modules' );

					$banner = scm_acf_layout( 'banner', 'block', 'Banner' );

						$banner['sub_fields'][] = scm_acf_field_select_layout( 'layout', 1, __( 'Layout', SCM_THEME ), 20 );
						$banner['sub_fields'] = array_merge( $banner['sub_fields'], scm_acf_preset_selectors( '', $default, 20, 20 ) );
						$banner['sub_fields'][] = scm_acf_field( 'attributes', 'attributes', __( 'Attributi', SCM_THEME ), 40 );
						$banner['sub_fields'][] = scm_acf_field_object( 'row', $default, 'banners' );

					$flexible['layouts'] = array( $template, $row, $module, $banner );

				$sections['sub_fields'][] = $flexible;

			$fields[] = $sections;
			
			return $fields;
		}
	}

	// LAYOUTS ( vedi scm-acf-layouts.php )
	if ( ! function_exists( 'scm_acf_preset_flexible_elements' ) ) {
		function scm_acf_preset_flexible_elements( $name = '', $default = 0, $elements = '', $logic = 0, $instr = '', $required = 0, $class = 'elements-flexible' ) {

			global $SCM_acf_objects, $SCM_types;

			$SCM_acf_objects[] = array( 'scm_acf_object_slider', __( 'Slider', SCM_THEME ) );
            $SCM_acf_objects[] = array( 'scm_acf_object_section', __( 'Section', SCM_THEME ) );
            $SCM_acf_objects[] = array( 'scm_acf_object_form', __( 'Form', SCM_THEME ) );
            $SCM_acf_objects[] = array( 'scm_acf_object_indirizzo', __( 'Indirizzo', SCM_THEME ) );
            $SCM_acf_objects[] = array( 'scm_acf_object_map', __( 'Map', SCM_THEME ) );
            $SCM_acf_objects[] = array( 'scm_acf_object_separatore', __( 'Separatore', SCM_THEME ) );
            $SCM_acf_objects[] = array( 'scm_acf_object_immagine', __( 'Immagine', SCM_THEME ) );
            $SCM_acf_objects[] = array( 'scm_acf_object_icona', __( 'Icona', SCM_THEME ) );
            $SCM_acf_objects[] = array( 'scm_acf_object_titolo', __( 'Titolo', SCM_THEME ) );
            $SCM_acf_objects[] = array( 'scm_acf_object_quote', __( 'Quote', SCM_THEME ) );
            $SCM_acf_objects[] = array( 'scm_acf_object_data', __( 'Data', SCM_THEME ) );
            $SCM_acf_objects[] = array( 'scm_acf_object_testo', __( 'Testo', SCM_THEME ) );
            $SCM_acf_objects[] = array( 'scm_acf_object_elenco_puntato', __( 'Elenco puntato', SCM_THEME ) );
            $SCM_acf_objects[] = array( 'scm_acf_object_contatti', __( 'Contatti', SCM_THEME ) );
            $SCM_acf_objects[] = array( 'scm_acf_object_social_follow', __( 'Social follow', SCM_THEME ) );
            $SCM_acf_objects[] = array( 'scm_acf_object_pulsanti', __( 'Pulsanti', SCM_THEME ) );

			$fields = array();

			if( $instr )
				$fields[] = scm_acf_field( 'msg-open-modules' . ( $name ? '-' . $name : '' ), array( 'message', $instr ), __( 'Istruzioni Elementi', SCM_THEME ) );

			$name = ( $name ? $name . '-' : '');

			$flexible = scm_acf_field_flexible( $name . 'modules', $default, __( 'Componi', SCM_THEME ), '+', 100, $logic, '', '', '', $required, $class );

				if( !$elements ){
					$elements = array();
					foreach ( $SCM_types['public'] as $slug => $value) {
						$elements[] = array( $slug, $value );
					}
					$elements = array_merge( $elements, $SCM_acf_objects );
				}
				
				if( !is_array( $elements ) )
					$elements = array( $elements );


				foreach ($elements as $el) {

					if( gettype( $el ) != 'array' )
						return;

					$fun = ( strpos( $el[0], 'scm_acf_object_' ) === 0 ? $el[0] : 'scm_acf_object');
					$element = $el[1];
					$key = str_replace( 'scm_acf_object_', '', $el[0] );

					$layout = scm_acf_layout( $key, 'block', $element );

					if( $fun != 'scm_acf_object' && function_exists( $fun ) )
						$layout['sub_fields'] = array_merge( $layout['sub_fields'], call_user_func( $fun, $default ) ); // Call Elements function in scm-acf-layouts.php
					else
						$layout['sub_fields'] = array_merge( $layout['sub_fields'], call_user_func( $fun, $key, $default ) ); // Call Elements function in scm-acf-layouts.php
					
					$flexible['layouts'][] = $layout;
					
				}

				$flexible['layouts'] = scm_acf_layouts_preset( '', $flexible['layouts'] );

			$fields[] = $flexible;
			
			return $fields;
		}
	}

// *****************************************************
// 3.0 FIELDS
// *****************************************************

	// TEMPLATES
	if ( ! function_exists( 'scm_acf_fields_template' ) ) {
		function scm_acf_fields_template( $name = '', $default = 0, $logic = 0, $instr = '', $required = 0, $class = 'posts-repeater' ) {

			$instr = ( $instr ?: __( 'Costruisci dei modelli da poter poi scegliere durante la creazione di nuovi contenuti. Per ogni modello è obbligatorio inserire almeno il Nome.', SCM_THEME ) );

			if( !$name )
				return;

			$fields = array();


			$template = scm_acf_field_repeater( $name . '-templates', $default, __( 'Aggiungi Modello', SCM_THEME ), __( 'Modelli', SCM_THEME ), 100, $logic, '', '', $instr, $required, $class );

				$template['sub_fields'][] = scm_acf_field_name_req( 'name',  $default, '', 60, 0, __( 'Nome Modello', SCM_THEME ), __( 'Nome', SCM_THEME ) );
				$template['sub_fields'][] = scm_acf_field( 'id', array( 'text-read', '', '0', __( 'ID', SCM_THEME ) ), __( 'ID', SCM_THEME ), 40 );
			
			$fields[] = $template;

			return $fields;
		}
	}

	// PAGES
	if ( ! function_exists( 'scm_acf_fields_page' ) ) {
		function scm_acf_fields_page( $name = '', $default = 0 ) {

			$name = ( $name ? $name . '-' : '');

			$fields = array();

			$fields[] = scm_acf_field_select_layout( $name . 'page-layout', 1, __( 'Layout', SCM_THEME ), 34, 0, 'default' );

			$fields = array_merge( $fields, scm_acf_preset_selectors( $name . 'page-selectors', $default, 33, 33 ) );

			$fields[] = scm_acf_field_select1( $name . 'page-menu', $default, 'wp_menu', 100, 0, '', __( 'Menu Principale', SCM_THEME ) );
			
			$fields = array_merge( $fields, scm_acf_preset_flexible_sections( $name, $default ) );

			return $fields;
		}
	}

	// BANNERS
	if ( ! function_exists( 'scm_acf_fields_banner' ) ) {
		function scm_acf_fields_banner( $name = '', $default = 0 ) {

			$name = ( $name ? $name . '-' : '');

			$fields = array();
			
			$flexible = scm_acf_field_flexible( $name . 'modules', 0, __( 'Aggiungi Contesto', SCM_THEME ), __( 'Contesto', SCM_THEME ), 100, 0, 1 );
                $flexible['layouts'][] = scm_acf_layout( 'titolo', 'block', __( 'Titolo', SCM_THEME ), '', '', scm_acf_object_titolo( 0, 0, 2 ) );
                $flexible['layouts'][] = scm_acf_layout( 'quote', 'block', __( 'Quote', SCM_THEME ), '', '', scm_acf_object_quote( 0, 0, 1) );
                $flexible['layouts'][] = scm_acf_layout( 'pulsanti', 'block', __( 'Pulsanti', SCM_THEME ), '', '', scm_acf_object_pulsanti( 0, 0, 1 ) );
                $flexible['layouts'][] = scm_acf_layout( 'elenco_puntato', 'block', __( 'Elenco Puntato', SCM_THEME ), '', '', scm_acf_object_elenco_puntato( 0, 0, 1 ) );
                $flexible['layouts'][] = scm_acf_layout( 'section', 'block', __( 'Banner', SCM_THEME ), '', '', scm_acf_object_section( 0, 0, 'sections-cat:banners' ) );

                //$flexible['sub_fields'][] = scm_acf_field_object_tax( 'banner-section', 0, 'sections', 'sections-cat:banners', '', $deafal_ban );
                //$flexible['sub_fields'] = array_merge( $flexible['sub_fields'], scm_acf_object_titolo( 0, 0, 1, '', $deafal_but ) );
                //$flexible['sub_fields'] = array_merge( $flexible['sub_fields'], scm_acf_object_pulsanti( 0, 0, 1, '', $deafal_but ) );

            $fields[] = $flexible;

			return $fields;
		}
	}
	
	// MODULES
	if ( ! function_exists( 'scm_acf_fields_module' ) ) {
		function scm_acf_fields_module( $name = '', $default = 0 ) {

			$name = ( $name ? $name . '-' : '');

			$fields = array();
			
			$flexible = scm_acf_field_flexible( $name . 'modules', 0, __( 'Componi', SCM_THEME ), '+', '', 0, 0, 30 );
                $flexible['layouts'][] = scm_acf_layout( 'titolo', 'block', __( 'Titolo', SCM_THEME ), '', '', scm_acf_object_titolo( 0, 0, 2 ) );
                $flexible['layouts'][] = scm_acf_layout( 'testo', 'block', __( 'Testo', SCM_THEME ), '', '', scm_acf_object_testo( 0, 0, 1) ); // Se vedi che i testi inseriti fanno casino, togli sostituisci 1 con 0
                $flexible['layouts'][] = scm_acf_layout( 'elenco_puntato', 'block', __( 'Elenco Puntato', SCM_THEME ), '', '', scm_acf_object_elenco_puntato( 0, 0, 1 ) );
                $flexible['layouts'][] = scm_acf_layout( 'quote', 'block', __( 'Quote', SCM_THEME ), '', '', scm_acf_object_quote( 0, 0, 1) );
                $flexible['layouts'][] = scm_acf_layout( 'pulsanti', 'block', __( 'Pulsanti', SCM_THEME ), '', '', scm_acf_object_pulsanti( 0, 0, 1 ) );
                //$flexible['layouts'][] = scm_acf_layout( 'separatore', 'block', __( 'Separatore', SCM_THEME ), '', '', scm_acf_object_separatore( 0, 0, 1 ) );
			
			$fields[] = $flexible;

			return $fields;
		}
	}


	// SECTIONS
	if ( ! function_exists( 'scm_acf_fields_section' ) ) {
		function scm_acf_fields_section( $name = '', $default = 0, $elements = '' ) {

			//$name = ( $name ? $name . '-' : '');

			$fields = array();

			$fields[] = scm_acf_field_select_layout( 'layout', $default, __( 'Layout', SCM_THEME ), 20 );
			$fields = array_merge( $fields, scm_acf_preset_selectors( '', $default, 20, 20 ) );
			$fields[] = scm_acf_field( 'attributes', 'attributes', __( 'Attributi', SCM_THEME ), 40 );

			$fields = array_merge( $fields, scm_acf_preset_repeater_columns( '', $default, $elements ) );
			$fields = array_merge( $fields, scm_acf_preset_tags( 'section', $default, 'sections' ) );

			return $fields;
		}
	}

	// SLIDES
	if ( ! function_exists( 'scm_acf_fields_slide' ) ) {
		function scm_acf_fields_slide( $name = '', $default = 0 ) {

			$name = ( $name ? $name . '-' : '');

			$fields = array();

			$fields[] = scm_acf_field( 'tab-img-slide', 'tab-left', __( 'Immagine', SCM_THEME ) );

				$fields[] = scm_acf_field_image( $name . 'slide-image', $default );

			$fields[] = scm_acf_field( 'tab-tax-slide', 'tab-left', __( 'Impostazioni', SCM_THEME ) );
				$fields = array_merge( $fields, scm_acf_preset_categories( $name . 'slide', $default, 'slides' ) );
				$fields = array_merge( $fields, scm_acf_preset_tags( $name . 'slide', $default, 'slides' ) );

			// conditional link
			$fields[] = scm_acf_field_select( $name . 'slide-link', $default, 'links_type', 50, 0, '', __( 'Collegamento', SCM_THEME ) );

			$link = array(
				'field' => $name . 'slide-link',
				'operator' => '==',
				'value' => 'link',
			);

			$page = array(
				'field' => $name . 'slide-link',
				'operator' => '==',
				'value' => 'page',
			);

				$fields[] = scm_acf_field_link( $name . 'slide-external', $default, 50, $link );
				$fields[] = scm_acf_field_object_link( $name . 'slide-internal', $default, 'page', 50, $page );

			$fields[] = scm_acf_field( 'tab-slide-caption', 'tab', __( 'Didascalia', SCM_THEME ) );
			// conditional caption
			$fields[] = scm_acf_field_select_disable( $name . 'slide-caption', $default, __( 'Didascalia', SCM_THEME ) );

			$caption = array(
				'field' => $name . 'slide-caption',
				'operator' => '==',
				'value' => 'on',
			);

				$fields[] = scm_acf_field( $name . 'slide-caption-top', array( 'percent', '', '0' ), __( 'Dal lato alto', SCM_THEME ), 25, $caption );
				$fields[] = scm_acf_field( $name . 'slide-caption-right', array( 'percent', '', '0' ), __( 'Dal lato destro', SCM_THEME ), 25, $caption );
				$fields[] = scm_acf_field( $name . 'slide-caption-bottom', array( 'percent', '', '0' ), __( 'Dal lato basso', SCM_THEME ), 25, $caption );
				$fields[] = scm_acf_field( $name . 'slide-caption-left', array( 'percent', '', '0' ), __( 'Dal lato sinistro', SCM_THEME ), 25, $caption );

				$fields[] = scm_acf_field( $name . 'slide-caption-title', array( 'text', '', __( 'Titolo didascalia', SCM_THEME ), __( 'Titolo', SCM_THEME ) ), __( 'Titolo didascalia', SCM_THEME ), 100, $caption );
				$fields[] = scm_acf_field( $name . 'slide-caption-cont', 'editor-basic-media', __( 'Contenuto didascalia', SCM_THEME ), 100, $caption );

			$fields[] = scm_acf_field( 'tab-slide-advanced', 'tab', __( 'Avanzate', SCM_THEME ) );
			$fields = array_merge( $fields, scm_acf_preset_selectors( $name . 'selectors', $default, 50, 50 ) );

			return $fields;

		}
	}

	// NEWS
	if ( ! function_exists( 'scm_acf_fields_news' ) ) {
		function scm_acf_fields_news( $name = '', $default = 0 ) {

			$name = ( $name ? $name . '-' : '');

			$fields = array();

			//$fields[] = scm_acf_field( 'tab-set-post', 'tab-left', __( 'Impostazioni', SCM_THEME ) );
				$fields[] = scm_acf_field_image( 'image', $default );
				$fields = array_merge( $fields, scm_acf_fields_module() );
				//$fields[] = scm_acf_field_limiter( $name . 'post-excerpt', $default, 350, 1, 100, 0, __( 'Anteprima', SCM_THEME ) );
				//$fields[] = scm_acf_field_editor( $name . 'post-content', $default );

			/*$fields[] = scm_acf_field( 'tab-tax-post', 'tab-left', __( 'Categorie', SCM_THEME ) );
				$fields = array_merge( $fields, scm_acf_preset_categories( $name . 'post', $default, 'post' ) );
				$fields = array_merge( $fields, scm_acf_preset_tags( $name . 'post', $default, 'post' ) );*/
				//$fields[] = scm_acf_field_category( $name . 'post-cat', $default, 'post' );

			return $fields;

		}
	}

	// ARTICOLI
	if ( ! function_exists( 'scm_acf_fields_articolo' ) ) {
		function scm_acf_fields_articolo( $name = '', $default = 0 ) {

			$name = ( $name ? $name . '-' : '');

			$fields = array();

			$fields[] = scm_acf_field( 'tab-set-articolo', 'tab-left', __( 'Impostazioni', SCM_THEME ) );
				$fields[] = scm_acf_field_image( 'image', $default );
				$fields[] = scm_acf_field_textarea( 'excerpt', $default, 5, 100, 0, '', __( 'Anteprima', SCM_THEME ) );
				$fields[] = scm_acf_field_editor_basic( 'editor', $default );

			$fields[] = scm_acf_field( 'tab-tax-articolo', 'tab-left', __( 'Categorie', SCM_THEME ) );
				$fields = array_merge( $fields, scm_acf_preset_categories( $name . 'articolo', $default, 'articoli' ) );
				$fields = array_merge( $fields, scm_acf_preset_tags( $name . 'articolo', $default, 'articoli' ) );
				//$fields[] = scm_acf_field_category( $name . 'post-cat', $default, 'post' );

			return $fields;

		}
	}

	// RASSEGNE STAMPA
	if ( ! function_exists( 'scm_acf_fields_rassegna' ) ) {
		function scm_acf_fields_rassegna( $name = '', $default = 0 ) {

			$name = ( $name ? $name . '-' : '');

			$fields = array();

			$fields[] = scm_acf_field( 'tab-set-rassegna', 'tab-left', __( 'Impostazioni', SCM_THEME ) );
				// conditional link
				$fields[] = scm_acf_field_select( $name . 'rassegna-type', $default, 'rassegne_type', 100, 0, '', __( 'Articolo', SCM_THEME ) );

				$link = array(
					'field' => $name . 'rassegna-type',
					'operator' => '==',
					'value' => 'link',
				);

				$file = array(
					'field' => $name . 'rassegna-type',
					'operator' => '==',
					'value' => 'file',
				);

					$fields[] = scm_acf_field_file( $name . 'rassegna-file', $default, 100, $file );
					$fields[] = scm_acf_field_link( $name . 'rassegna-link', $default, 100, $link );

				
				$fields[] = scm_acf_field( $name . 'rassegna-data', 'date', __( 'Data', SCM_THEME ) );

			$fields[] = scm_acf_field( 'tab-tax-rassegna', 'tab-left', __( 'Categorie', SCM_THEME ) );
				$fields = array_merge( $fields, scm_acf_preset_categories( $name . 'rassegna', $default, 'rassegne-stampa' ) );
				$fields = array_merge( $fields, scm_acf_preset_tags( $name . 'rassegna', $default, 'rassegne-stampa' ) );
			
			return $fields;

		}
	}

	// DOCUMENTI
	if ( ! function_exists( 'scm_acf_fields_documento' ) ) {
		function scm_acf_fields_documento( $name = '', $default = 0 ) {

			$name = ( $name ? $name . '-' : '');

			$fields = array();

			$fields[] = scm_acf_field( 'tab-set-documento', 'tab-left', __( 'Impostazioni', SCM_THEME ) );
				$fields[] = scm_acf_field_file( $name . 'documento-file', $default );

			$fields[] = scm_acf_field( 'tab-tax-documento', 'tab-left', __( 'Categorie', SCM_THEME ) );
				$fields = array_merge( $fields, scm_acf_preset_categories( $name . 'documento', $default, 'documenti' ) );
				$fields = array_merge( $fields, scm_acf_preset_tags( $name . 'documento', $default, 'documenti' ) );
			//$fields[] = scm_acf_field_category( $name . 'documento-cat', $default, 'documenti' );

			return $fields;

		}
	}
	
	// GALLERIE
	if ( ! function_exists( 'scm_acf_fields_galleria' ) ) {
		function scm_acf_fields_galleria( $name = '', $default = 0 ) {

			$name = ( $name ? $name . '-' : '');

			$fields = array();

			$fields[] = scm_acf_field( 'tab-set-galleria', 'tab-left', __( 'Impostazioni', SCM_THEME ) );
				$fields[] = scm_acf_field( $name . 'galleria-images', 'gallery', __( 'Immagini', SCM_THEME ) );

			$fields[] = scm_acf_field( 'tab-tax-galleria', 'tab-left', __( 'Categorie', SCM_THEME ) );
				$fields = array_merge( $fields, scm_acf_preset_categories( $name . 'galleria', $default, 'gallerie' ) );
				$fields = array_merge( $fields, scm_acf_preset_tags( $name . 'galleria', $default, 'gallerie' ) );
			//$fields[] = scm_acf_field_category( $name . 'galleria-cat', $default, 'gallerie' );

			return $fields;

		}
	}
	
	// VIDEO
	if ( ! function_exists( 'scm_acf_fields_video' ) ) {
		function scm_acf_fields_video( $name = '', $default = 0 ) {

			$name = ( $name ? $name . '-' : '');

			$fields = array();

			$fields[] = scm_acf_field( 'tab-set-video', 'tab-left', __( 'Impostazioni', SCM_THEME ) );
				$fields[] = scm_acf_field( $name . 'video-url', 'video', __( 'Link a YouTube', SCM_THEME ) );

			$fields[] = scm_acf_field( 'tab-tax-video', 'tab-left', __( 'Categorie', SCM_THEME ) );
				$fields = array_merge( $fields, scm_acf_preset_categories( $name . 'video', $default, 'video' ) );
				$fields = array_merge( $fields, scm_acf_preset_tags( $name . 'video', $default, 'video' ) );
			//$fields[] = scm_acf_field_category( $name . 'video-cat', $default, 'video' );

			return $fields;

		}
	}

	// LUOGHI
	if ( ! function_exists( 'scm_acf_fields_luogo' ) ) {
		function scm_acf_fields_luogo( $name = '', $default = 0 ) {

			$name = ( $name ? $name . '-' : '');

			$fields = array();

			$fields[] = scm_acf_field( 'tab-set-luogo', 'tab-left', __( 'Dati', SCM_THEME ) );
				
				$fields[] = scm_acf_field( 'msg-luogo-nome', array(
					'message',
					__( 'Il campo Nome è utile per differenziare più luoghi che fanno riferimento ad un unico Soggetto ( es. Sede Operativa, Distaccamento, ...).', SCM_THEME )
				), __( 'Specifica un Nome', SCM_THEME ) );

					$fields[] = scm_acf_field_name_req( $name . 'luogo-nome', $default, '', 100, 0, __( 'es. Sede Operativa, Distaccamento, …', SCM_THEME ) );

					$fields[] = scm_acf_field_text( $name . 'luogo-indirizzo', $default, 70, 0, 'Corso Giulio Cesare 1', __( 'Indirizzo', SCM_THEME ) );
					$fields[] = scm_acf_field_text( $name . 'luogo-provincia', $default, 30, 0, 'RM', __( 'Provincia', SCM_THEME ) );
					
					$fields[] = scm_acf_field_text( $name . 'luogo-citta', $default, 70, 0, 'Roma', __( 'Città/Località', SCM_THEME ) );
					$fields[] = scm_acf_field_text( $name . 'luogo-cap', $default, 30, 0, '12345', __( 'CAP', SCM_THEME ) );
					
					$fields[] = scm_acf_field_text( $name . 'luogo-frazione', $default, 70, 0, 'S. Pietro', __( 'Frazione', SCM_THEME ) );
					$fields[] = scm_acf_field_text( $name . 'luogo-regione', $default, 30, 0, 'Lazio', __( 'Regione', SCM_THEME ) );
					
					$fields[] = scm_acf_field_text( $name . 'luogo-paese', $default, 70, 0, 'Italy', __( 'Paese', SCM_THEME ) );
					$fields = array_merge( $fields, scm_acf_preset_map_icon( $name . 'luogo-mappa', 1, 30, 0, 'Icona Luogo' ) );

					$fields[] = scm_acf_field( $name . 'luogo-lat', array( 'number-read', '', '0', 'Lat.' ), __( 'Latitudine', SCM_THEME ), 50 );
					$fields[] = scm_acf_field( $name . 'luogo-lng', array( 'number-read', '', '0', 'Long.' ), __( 'Longitudine', SCM_THEME ), 50 );

			$fields[] = scm_acf_field( 'tab-contatti-luogo', 'tab-left', __( 'Contatti', SCM_THEME ) );

				$contacts = scm_acf_field_flexible( $name . 'luogo-contatti', $default, __( 'Aggiungi Contatti', SCM_THEME ), '+' );

					$web = scm_acf_layout( 'web', 'block', __( 'Web', SCM_THEME ) );
						$web['sub_fields'] = scm_acf_preset_button( '', $default, 'link', 'globe_contact', 'web', 0, __( 'Web', SCM_THEME ) );
					$contacts['layouts'][] = $web;

					$email = scm_acf_layout( 'email', 'block', __( 'Email', SCM_THEME ) );
						$email['sub_fields'] = scm_acf_preset_button( '', $default, 'link', 'envelope_contact', 'email', 0, __( 'Email', SCM_THEME ) );
					$contacts['layouts'][] = $email;

					$skype = scm_acf_layout( 'skype', 'block', __( 'Skype', SCM_THEME ) );
						$skype['sub_fields'] = scm_acf_preset_button( '', $default, 'link', 'skype_contact', 'skype', 0, __( 'Skype Name', SCM_THEME ), __( 'User Name', SCM_THEME ) );
					$contacts['layouts'][] = $skype;

					$phone = scm_acf_layout( 'phone', 'block', __( 'Telefono', SCM_THEME ) );
						$phone['sub_fields'] = scm_acf_preset_button( '', $default, 'link', 'phone_contact', 'phone', 0, __( 'Tel.', SCM_THEME ) );
					$contacts['layouts'][] = $phone;

					$fax = scm_acf_layout( 'fax', 'block', __( 'Fax', SCM_THEME ) );
						$fax['sub_fields'] = scm_acf_preset_button( '', $default, 'link', 'file-text_contact', 'fax', 0, __( 'Fax', SCM_THEME ) );
					$contacts['layouts'][] = $fax;

				$fields[] = $contacts;

			$fields[] = scm_acf_field( 'tab-tax-luogo', 'tab-left', __( 'Categorie', SCM_THEME ) );
				$fields = array_merge( $fields, scm_acf_preset_category( $name . 'luogo', $default, 'luoghi' ) );
				$fields = array_merge( $fields, scm_acf_preset_tags( $name . 'luogo', $default, 'luoghi' ) );

			return $fields;

		}
	}

	// SOGGETTI
	if ( ! function_exists( 'scm_acf_fields_soggetto' ) ) {
		function scm_acf_fields_soggetto( $name = '', $default = 0 ) {

			$name = ( $name ? $name . '-' : '');

			$fields = array();

			$fields[] = scm_acf_field( 'tab-soggetto-brand', 'tab-left', __( 'Brand', SCM_THEME ) );
				$fields[] = scm_acf_field( 'msg-soggetto-pos', array(
					'message',
					__( 'Carica uno logo e/o un\'icona da utilizzare su fondi chiari.', SCM_THEME ),
				), 'Versione in Positivo', 100 );

				$fields[] = scm_acf_field_image( $name . 'soggetto-logo', $default, 50, 0, __( 'Logo', SCM_THEME ) );
				$fields[] = scm_acf_field_image( $name . 'soggetto-icona', $default, 50, 0, __( 'Icona', SCM_THEME ) );
				
				$fields[] = scm_acf_field( 'msg-soggetto-neg', array(
					'message',
					__( 'Carica uno logo e/o un\'icona da utilizzare su fondi scuri.', SCM_THEME ),
				), __( 'Versione in Negativo', SCM_THEME ), 100 );
				
				$fields[] = scm_acf_field_image( $name . 'soggetto-logo-neg', $default, 50, 0, __( 'Logo', SCM_THEME ) );
				$fields[] = scm_acf_field_image( $name . 'soggetto-icona-neg', $default, 50, 0, __( 'Icona', SCM_THEME ) );

			$fields[] = scm_acf_field( 'tab-soggetto-dati', 'tab-left', 'Dati' );
				$fields[] = scm_acf_field_link( $name . 'soggetto-link', $default, 100 );
				$fields[] = scm_acf_field_text( $name . 'soggetto-intestazione', $default, 100, 0, 'intestazione', __( 'Intestazione', SCM_THEME ) );
				$fields[] = scm_acf_field_text( $name . 'soggetto-piva', $default, 50, 0, '0123456789101112', __( 'P.IVA', SCM_THEME ) );
				$fields[] = scm_acf_field_text( $name . 'soggetto-cf', $default, 50, 0, 'AAABBB123', __( 'Codice Fiscale', SCM_THEME ) );

			$fields[] = scm_acf_field( 'tab-soggetto-luogo', 'tab-left', __( 'Luoghi', SCM_THEME ) );
				$fields[] = scm_acf_field( 'msg-soggetto-luoghi', array(
					'message',
					__( 'Assegna dei Luoghi a questo Soggetto. Clicca sul pulsante Luoghi nella barra laterale per crearne uno. Il primo Luogo dell\'elenco sarà considerato Luogo Principale per questo Soggetto.', SCM_THEME ),
				), __( 'Luoghi', SCM_THEME ) );

				$fields[] = scm_acf_field_objects_rel( $name . 'soggetto-luoghi', $default, 'luoghi', 100, 0, __( 'Seleziona Luoghi', SCM_THEME ) );

			$fields[] = scm_acf_field( 'tab-social-soggetto', 'tab-left', __( 'Social', SCM_THEME ) );
				$fields = array_merge( $fields, scm_acf_preset_flexible_buttons( $name . 'soggetto', $default, 'social', __( 'Social', SCM_THEME ) ) );

			$fields[] = scm_acf_field( 'tab-tax-soggetto', 'tab-left', __( 'Categorie', SCM_THEME ) );
				$fields = array_merge( $fields, scm_acf_preset_category( $name . 'soggetto', $default, 'soggetti' ) );
				$fields = array_merge( $fields, scm_acf_preset_tags( $name . 'soggetto', $default, 'soggetti' ) );

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

			$types = scm_acf_field_repeater( $name . 'types-list', $default, 'Aggiungi Type', __( 'Types', SCM_THEME ) );
			$types['sub_fields'][] = scm_acf_field_name_req( 'plural', $default, 18, 100, 0, __( 'Produzioni', SCM_THEME ), __( 'Plurale', SCM_THEME ) );
			
				$types['sub_fields'][] = scm_acf_field( 'tab-labels', 'tab-left', __( 'Labels', SCM_THEME ) );
					
					$types['sub_fields'][] = scm_acf_field_name( 'singular', $default, 18, 100, 0, __( 'Produzione', SCM_THEME ), __( 'Singolare', SCM_THEME ) );
					$types['sub_fields'][] = scm_acf_field_name( 'slug', $default, 18, 100, 0, __( 'produzioni', SCM_THEME ), __( 'Slug', SCM_THEME ) );
					$types['sub_fields'][] = scm_acf_field_name( 'short-singular', $default, 18, 100, 0, __( 'Prod.', SCM_THEME ), __( 'Singolare Corto', SCM_THEME ) );
					$types['sub_fields'][] = scm_acf_field_name( 'short-plural', $default, 18, 100, 0, __( 'Prods.', SCM_THEME ), __( 'Plurale Corto', SCM_THEME ) );

				$types['sub_fields'][] = scm_acf_field( 'tab-admin', 'tab-left', __( 'Admin', SCM_THEME ) );
					$types['sub_fields'][] = scm_acf_field_select_disable( 'active', $default, __( 'Type', SCM_THEME ), 25 );
					$types['sub_fields'][] = scm_acf_field_select_disable( 'public', $default, __( 'Archivi', SCM_THEME ), 25 );
					$types['sub_fields'][] = scm_acf_field_text( 'icon', $default, 50, 0, 'admin-site', __( 'Icona', SCM_THEME ), __( 'Icona', SCM_THEME ), '', __( 'Visita <a href="https://developer.wordpress.org/resource/dashicons/" target="_blank">https://developer.wordpress.org/resource/dashicons/</a> per un elenco delle icone disponibili e dei corrispettivi nomi, da inserire nel seguente campo.', SCM_THEME ) );
					$types['sub_fields'][] = scm_acf_field_positive( 'menu', $default, 100, 0, '0', __( 'Zona Menu', SCM_THEME ), 0, 3 );

				$types['sub_fields'][] = scm_acf_field( 'tab-archive', 'tab-left', __( 'Archivi', SCM_THEME ) );
					$types['sub_fields'][] = scm_acf_field_select( 'orderby', $default, 'orderby', 100, 0, '', __( 'Ordina per', SCM_THEME ) );
					$types['sub_fields'][] = scm_acf_field_select( 'ordertype', $default, 'ordertype', 100, 0, '', __( 'Ordinamento', SCM_THEME ) );
			
			$fields[] = $types;

			$fields[] = scm_acf_field( 'msg-types-menupos', array(
						'message',
						'<strong>Groups: 0 = Pages | 1 = Custom | 2 = Custom | 3 = Media | 4 = Contacts</strong>

						0.1 [ SCM ]
						0.2 [ SCM Types ]
						0.3 [ SCM Templates ]

						1 > 3 <strong>free</strong>

						4 —

						5 [ PAGES ]
						6 [ SECTIONS ]
						7 [ MODULES ]
						8 [ BANNERS ]
						9 <strong>free</strong>

						10 —

						11 <strong>free</strong>
						12 > 19 <strong>[ 1 ]</strong>

						20 —

						21 <strong>free</strong>
						22 > 25 <strong>[ 2 ]</strong>

						26 —

						27 [ MEDIA ]
						28 > 41 <strong>[ 3 ]</strong>

						42 —

						44 > 55 <strong>[ 4 ]</strong>
						56 [ USERS ]
						57 [ CF7 ]
						58 <strong>free</strong>

						59 —

						...

						91 > ... default',
					), 'Posizione in Menu' );

			return $fields;
		}
	}

	// TAXONOMIES OPTIONS
	if ( ! function_exists( 'scm_acf_options_taxonomies' ) ) {
		function scm_acf_options_taxonomies( $name = '', $default = 0 ) {

			$name = ( $name ? $name . '-' : '' );

			$fields = array();

			$taxes = scm_acf_field_repeater( $name . 'taxonomies-list', $default, __( 'Aggiungi Taxonomy', SCM_THEME ), __( 'Taxonomies', SCM_THEME ) );

				$taxes['sub_fields'][] = scm_acf_field_select_disable( 'template', $default, __( 'Template', SCM_THEME ), 33 );
				$taxes['sub_fields'][] = scm_acf_field_select_disable( 'manage', $default, __( 'Manage', SCM_THEME ), 33 );
				$taxes['sub_fields'][] = scm_acf_field( 'hierarchical', array( 'select' . ( $default ? '-default' : '' ), array( __( 'Tag', SCM_THEME ), __( 'Categoria', SCM_THEME ) ) ), __( 'Seleziona Tipologia', SCM_THEME ), 34 );
				$taxes['sub_fields'][] = scm_acf_field_name_req( 'plural', $default, 18, 100, 0, __( 'Nome Categorie', SCM_THEME ), __( 'Plurale', SCM_THEME ) );
				$taxes['sub_fields'][] = scm_acf_field_name( 'singular', $default, 18, 100, 0, __( 'Nome Categoria', SCM_THEME ), __( 'Singolare', SCM_THEME ) );
				$taxes['sub_fields'][] = scm_acf_field_name( 'slug', $default, 18, 100, 0, 'slug-categoria', __( 'Slug', SCM_THEME ) );
				$taxes['sub_fields'][] = scm_acf_field( 'types', array( 'select2-multi-types_complete-horizontal' . ( $default ? '-default' : '' ) ), __( 'Seleziona Locations', SCM_THEME ) );

			$fields[] = $taxes;

			return $fields;
		}
	}

	// MODULE OPTIONS
	/*if ( ! function_exists( 'scm_acf_options_module_p' ) ) {
		function scm_acf_options_module_p( $name = '', $default = 0, $width = 100, $placeholder = '', $label = 'Link a Pagina' ) {

			$name = ( $name ? $name . '-' : '' );

			$fields = array();

			$fields[] = scm_acf_field_object( $name . 'page', $default, 'page', $width, '', 'Pagina Modulo' );

            return $fields;
		}
	}*/

	// SLIDER OPTIONS
	if ( ! function_exists( 'scm_acf_options_slider' ) ) {
		function scm_acf_options_slider( $name = '', $default = 0, $width = 100, $placeholder = '', $label = '' ) {
			$label = ( $label ?: __( 'Attiva Slider', SCM_THEME ) );

			$name = ( $name ? $name . '-' : '' );

			$fields = array();
			
			$fields[] = scm_acf_field_select1( $name . 'slider-active', $default, 'slider_model-no', $width, 0, array( 'no' => __( 'Disattiva', SCM_THEME ) ), $label );
                $slider_enabled = array( array( 'field' => $name . 'slider-active', 'operator' => '!=', 'value' => 'no' ), array( 'field' => $name . 'slider-active', 'operator' => '!=', 'value' => 'default' ) );
                    $fields = array_merge( $fields, scm_acf_preset_term( $name . 'slider', 0, 'sliders', __( 'Slider', SCM_THEME ), $slider_enabled, 0, 0, $width ) );

            return $fields;
		}
	}


	// GENERAL OPTIONS
	if ( ! function_exists( 'scm_acf_options_general' ) ) {
		function scm_acf_options_general( $name = '', $default = 0 ) {

			$name = ( $name ? $name . '-' : '' );

			$fields = array();

			$fields[] = scm_acf_field( 'tab-branding-settings', 'tab-left', __( 'Favicon', SCM_THEME ), 33 );
				$fields[] = scm_acf_field_image( $name . 'opt-branding-ico', $default, 33, 0, __( 'ICO 16', SCM_THEME ) );
				$fields[] = scm_acf_field_image( $name . 'opt-branding-54', $default, 33, 0, __( 'ICO 54', SCM_THEME ) );
				$fields[] = scm_acf_field_image( $name . 'opt-branding-114', $default, 33, 0, __( 'Icon 114', SCM_THEME ) );
				$fields[] = scm_acf_field_image( $name . 'opt-branding-png', $default, 33, 0, __( 'PNG 16', SCM_THEME ) );
				$fields[] = scm_acf_field_image( $name . 'opt-branding-72', $default, 33, 0, __( 'Icon 72', SCM_THEME ) );
				$fields[] = scm_acf_field_image( $name . 'opt-branding-144', $default, 33, 0, __( 'Icon 144', SCM_THEME ) );

			$fields[] = scm_acf_field( 'tab-uploads-settings', 'tab-left', 'Media Upload' );
				$fields[] = scm_acf_field( $name . 'opt-uploads-quality', array( 'percent', 100, '100', __( 'Qualità immagini', SCM_THEME ) ), __( 'Qualità', SCM_THEME ) );
				$fields[] = scm_acf_field( $name . 'opt-uploads-width', array( 'pixel-max', 1800, '1800', __( 'Largezza massima immagini', SCM_THEME ) ), __( 'Larghezza Massima', SCM_THEME ) );
				$fields[] = scm_acf_field( $name . 'opt-uploads-height', array( 'pixel-max', 1800, '1800', __( 'Altezza massima immagini', SCM_THEME ) ), __( 'Altezza Massima', SCM_THEME ) );

			$fields[] = scm_acf_field( 'tab-tools-settings', 'tab-left', __( 'Strumenti', SCM_THEME ) );
				$fields[] = scm_acf_field( 'msg-fader', 'message', __( 'Pages Fader', SCM_THEME ) );
					$fields[] = scm_acf_field( $name . 'opt-tools-fade-in', array( 'second', '', '1', __( 'Fade In', SCM_THEME ), __( 'sec', SCM_THEME ), 0, 10 ), __( 'Fade In', SCM_THEME ) );
					$fields[] = scm_acf_field( $name . 'opt-tools-fade-out', array( 'second', '', '1', __( 'Fade Out', SCM_THEME ), __( 'sec', SCM_THEME ), 0, 10 ), __( 'Fade Out', SCM_THEME ) );
					$fields[] = scm_acf_field_select( $name . 'opt-tools-fade-waitfor', $default, 'waitfor-no', 100, 0, '', __( 'Wait for', SCM_THEME ) );
				$fields[] = scm_acf_field( 'msg-toppage', 'message', __( 'Top Of Page', SCM_THEME ) );
					$fields[] = scm_acf_field( $name . 'opt-tools-topofpage-offset', array( 'pixel', 200, 200, __( 'Offset', SCM_THEME ) ), __( 'Offset', SCM_THEME ) );
					$fields[] = scm_acf_field_icon( $name . 'opt-tools-topofpage-icon', $default, 'angle-up' );
					$fields[] = scm_acf_field( $name . 'opt-tools-topofpage-title', array( 'name', __( 'Inizio pagina', SCM_THEME ), __( 'Inizio pagina', SCM_THEME ) ), __( 'Titolo', SCM_THEME ) );
					$fields = array_merge( $fields, scm_acf_preset_rgba_txt( $name . 'opt-tools-topofpage-txt-rgba', $default ) );
					$fields = array_merge( $fields, scm_acf_preset_rgba_bg( $name . 'opt-tools-topofpage-bg-rgba', $default, '#DDDDDD' ) );
				$fields[] = scm_acf_field( 'msg-smooth', 'message', __( 'Smooth Scroll', SCM_THEME ) );
					$fields[] = scm_acf_field( $name . 'opt-tools-smoothscroll-duration', array( 'second-max', '', '0', __( 'Durata', SCM_THEME ) ), __( 'Durata', SCM_THEME ) );
					$fields[] = scm_acf_field( $name . 'opt-tools-smoothscroll-delay', array( 'second', '', '0', __( 'Delay', SCM_THEME ) ), __( 'Delay', SCM_THEME ) );
					$fields[] = scm_acf_field_select_enable( $name . 'opt-tools-smoothscroll-page', $default, __( 'Smooth Scroll (su nuove pagine)', SCM_THEME ) );
					$fields[] = scm_acf_field( $name . 'opt-tools-smoothscroll-delay-new', array( 'second', '', '0,3', __( 'Delay su nuova pagina', SCM_THEME ) ), __( 'Delay su nuova pagina', SCM_THEME ) );
					$fields[] = scm_acf_field( $name . 'opt-tools-smoothscroll-offset', array( 'pixel', 50, 50, __( 'Offset', SCM_THEME ) ), __( 'Offset', SCM_THEME ) );
					$fields[] = scm_acf_field_select( $name . 'opt-tools-smoothscroll-ease', $default, 'ease', 100, 0, '', __( 'Ease', SCM_THEME ) );
				$fields[] = scm_acf_field( 'msg-singlenav', 'message', __( 'Single Page Nav', SCM_THEME ) );
					$fields[] = scm_acf_field( $name . 'opt-tools-singlepagenav-activeclass', array( 'class', 'active', 'active', __( 'Active Class', SCM_THEME ) ), __( 'Active Class', SCM_THEME ) );
					$fields[] = scm_acf_field( $name . 'opt-tools-singlepagenav-interval', array( 'second', '', '500', __( 'Interval', SCM_THEME ) ), __( 'Interval', SCM_THEME ) );
					$fields[] = scm_acf_field( $name . 'opt-tools-singlepagenav-offset', array( 'pixel', '', '0', __( 'Offset', SCM_THEME ) ), __( 'Offset', SCM_THEME ) );
					$fields[] = scm_acf_field( $name . 'opt-tools-singlepagenav-threshold', array( 'pixel', '', '150', __( 'Threshold', SCM_THEME ) ), __( 'Threshold', SCM_THEME ) );
				$fields[] = scm_acf_field( 'msg-fancybox', 'message', 'Fancybox' );
					$fields[] = scm_acf_field_select_disable( $name . 'opt-tools-fancybox', $default, 'Fancybox' );
				$fields[] = scm_acf_field( 'msg-slider', 'message', __( 'Slider', SCM_THEME ) );
					$fields = array_merge( $fields, scm_acf_options_slider( 'main', $default ) );
				$fields[] = scm_acf_field( 'msg-gmaps', 'message', __( 'Google Maps', SCM_THEME ) );
					$fields = array_merge( $fields, scm_acf_preset_map_icon( $name . 'opt-tools-mappa', $default ) );
				/*$fields[] = scm_acf_field( 'msg-accordion', 'message', 'Accordion' );
					$fields[] = scm_acf_field( $name . 'opt-tools-accordion-duration', array( 'second-max', '', '500', 'Durata' ), 'Durata' );*/

			$fields[] = scm_acf_field( 'tab-' . $name . 'opt-.private-settings', 'tab-left', __( 'Area Privata', SCM_THEME ) );
				$fields[] = scm_acf_field_select_disable( $name . 'opt-private-login', $default, __( 'Footer Login', SCM_THEME ) );

			$fields[] = scm_acf_field( 'tab-ids-settings', 'tab-left', 'ID\'s' );
				$fields[] = scm_acf_field( $name . 'opt-ids-pagina', array( 'id', 'site-page' ), __( 'Pagina ID', SCM_THEME ) );
				$fields[] = scm_acf_field( $name . 'opt-ids-header', array( 'id', 'site-header' ), __( 'Header ID', SCM_THEME ) );
				$fields[] = scm_acf_field( $name . 'opt-ids-branding', array( 'id', 'site-branding' ), __( 'Branding ID', SCM_THEME ) );
				$fields[] = scm_acf_field( $name . 'opt-ids-menu', array( 'id', 'site-navigation' ), 'Main Menu ID' );
				//$fields[] = scm_acf_field( $name . 'opt-ids-follow', array( 'id', 'site-follow' ), 'Social Follow Menu ID' );
				$fields[] = scm_acf_field( $name . 'opt-ids-content', array( 'id', 'site-content' ), __( 'Content ID', SCM_THEME ) );
				$fields[] = scm_acf_field( $name . 'opt-ids-footer', array( 'id', 'site-footer' ), __( 'Footer ID', SCM_THEME ) );
				$fields[] = scm_acf_field( $name . 'opt-ids-topofpage', array( 'id', 'site-topofpage' ), 'Top Of Page ID' );

			$fields[] = scm_acf_field( 'tab-ie-settings', 'tab-left', 'IE' );
				$fields[] = scm_acf_field( $name . 'opt-ie-version', array( 'positive', '', '9', __( 'Internet Explorer', SCM_THEME ), '', 7, 12 ), __( 'Versione Minima', SCM_THEME ) );
				$fields[] = scm_acf_field_object_link( $name . 'opt-ie-redirect', $default, 'page', 100, 0, __( 'Pagina', SCM_THEME ) );

			return $fields;

		}
	}

	// STYLE OPTIONS
	if ( ! function_exists( 'scm_acf_options_style' ) ) {
		function scm_acf_options_style( $name = '', $default = 0 ) {

			$name = ( $name ? $name . '-' : '');

			$fields = array();

            $fields[] = scm_acf_field( 'tab-style-testi', 'tab-left', __( 'Testi', SCM_THEME ) );
                $fields = array_merge( $fields, scm_acf_preset_text_style( $name . 'style-txt', $default ) );
            $fields[] = scm_acf_field( 'tab-style-sfondo', 'tab-left', __( 'Sfondo', SCM_THEME ) );
                $fields = array_merge( $fields, scm_acf_preset_background_style( $name . 'style-bg', $default ) );
            //$fields[] = scm_acf_field( 'tab-style-contenitore', 'tab-left', __( 'Contenitore', SCM_THEME ) );
                //$fields = array_merge( $fields, scm_acf_preset_background_style( $name . 'style-bg-container', $default ) );
            $fields[] = scm_acf_field( 'tab-style-box', 'tab-left', __( 'Box', SCM_THEME ) );
                $fields = array_merge( $fields, scm_acf_preset_box_style( $name . 'style-box', $default ) );

            return $fields;

		}
	}

	// STYLES OPTIONS
	if ( ! function_exists( 'scm_acf_options_styles' ) ) {
		function scm_acf_options_styles( $name = '', $default = 0 ) {

			$name = ( $name ? $name . '-' : '');

			$fields = array();

			$fields[] = scm_acf_field( 'tab-loadingpage', 'tab-left', __( 'Loading Page', SCM_THEME ) );
				$fields = array_merge( $fields, scm_acf_preset_background_style( $name . 'styles-loading', $default ) );

			$fields[] = scm_acf_field( 'tab-fonts', 'tab-left', 'Fonts' );
				$gfonts = scm_acf_field_repeater( $name . 'styles-google', $default, __( 'Aggiungi Google Web Font', SCM_THEME ), __( 'Includi Google Web Fonts', SCM_THEME ), '', 0, '', '', __( 'Visita <a href="https://www.google.com/fonts">https://www.google.com/fonts</a>, scegli la famiglia e gli stili da includere.', SCM_THEME ) );

					$gfonts['sub_fields'][] = scm_acf_field( 'family', array( 'text', '', 'Open Sans', __( 'Family', SCM_THEME ) ), __( 'Family', SCM_THEME ), 'required' );
					$gfonts['sub_fields'][] = scm_acf_field( 'style', array( 'checkbox-webfonts_google_styles', '', 'horizontal' ), __( 'Styles', SCM_THEME ) );

				$fields[] = $gfonts;

				$afonts = scm_acf_field_repeater( $name . 'styles-adobe', $default, __( 'Aggiungi Adobe TypeKit', SCM_THEME ), __( 'Includi Adobe TypeKit', SCM_THEME ) );

					$afonts['sub_fields'][] = scm_acf_field( 'id', array( 'text', '', '000000', __( 'ID', SCM_THEME ) ), __( 'ID', SCM_THEME ), 'required' );
					$afonts['sub_fields'][] = scm_acf_field( 'name', array( 'text', '', __( 'Nome Kit', SCM_THEME ), __( 'Kit', SCM_THEME ) ), __( 'Nome', SCM_THEME ) );

				$fields[] = $afonts;

			$fields[] = scm_acf_field( 'tab-responsive', 'tab-left', 'Responsive' );
				
				$fields[] = scm_acf_field( 'msg-responsive-size', array(
					'message',
					__( 'Aggiungi o togli px dalla dimensione generale.', SCM_THEME ),
				), __( 'Dimensione testi', SCM_THEME ) );

					$fields[] = scm_acf_field( $name . 'styles-size-wide', array( 'number', '', '-1', '+/-', 'px', -100, 100 ), 'Wide' );
					$fields[] = scm_acf_field( $name . 'styles-size-desktop', array( 'number', '', '0', '+/-', 'px', -100, 100 ), 'Desktop' );
					$fields[] = scm_acf_field( $name . 'styles-size-landscape', array( 'number', '', '1', '+/-', 'px', -100, 100 ), 'Tablet Landscape' );
					$fields[] = scm_acf_field( $name . 'styles-size-portrait', array( 'number', '', '2', '+/-', 'px', -100, 100 ), 'Tablet Portrait' );
					$fields[] = scm_acf_field( $name . 'styles-size-smart', array( 'number', '', '3', '+/-', 'px', -100, 100 ), 'Mobile' );


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
			$fields[] = scm_acf_field_select_layout( $name . 'layout-page', $default, __( 'Larghezza Pagine', SCM_THEME ), 100, 0, 'responsive' );
			
			$layout = array(
				'field' => $name . 'layout-page',
				'operator' => '==',
				'value' => 'full',
			);

				$fields[] = scm_acf_field_select_layout( $name . 'layout-head', $default, __( 'Larghezza Header', SCM_THEME ), 34, $layout, 'responsive' );
				$fields[] = scm_acf_field_select_layout( $name . 'layout-content', $default, __( 'Larghezza Contenuti', SCM_THEME ), 33, $layout, 'responsive' );
				$fields[] = scm_acf_field_select_layout( $name . 'layout-foot', $default, __( 'Larghezza Footer', SCM_THEME ), 33, $layout, 'responsive' );
				$fields[] = scm_acf_field_select_layout( $name . 'layout-menu', $default, __( 'Larghezza Menu', SCM_THEME ), 50, $layout, 'responsive' );
				$fields[] = scm_acf_field_select_layout( $name . 'layout-sticky', $default, __( 'Larghezza Sticky Menu', SCM_THEME ), 50, $layout, 'responsive' );

			$fields[] = scm_acf_field_select1( $name . 'layout-tofull',  $default, 'responsive_events', 34, 0, '', __( 'Responsive to Full', SCM_THEME ) );
			$fields[] = scm_acf_field_select1( $name . 'layout-tocolumn',  $default, 'responsive_events', 33, 0, '', __( 'Responsive Columns', SCM_THEME ) );
			$fields[] = scm_acf_field_select1( $name . 'layout-max',  $default, 'responsive_layouts', 33, 0, '', __( 'Max Responsive Width', SCM_THEME ) );

			return $fields;

		}
	}

	// HEAD ALL OPTIONS
	if ( ! function_exists( 'scm_acf_options_head' ) ) {
		function scm_acf_options_head( $name = '', $default = 0 ) {

			$name = ( $name ? $name . '-' : '');

			$fields = array();

			// +++ todo: elimina i 3 HEAD OPTIONS, la Head diventa come il Foot, con ripetitore sezioni, o qualcosa di simile ma chiuso (con elementi come Social, Logo, Menu)
			
			$fields[] = scm_acf_field( 'tab-head-brand', 'tab-left', __( 'Branding', SCM_THEME ) );
                $fields = array_merge( $fields, scm_acf_options_head_branding( $name . 'brand' ) );

            $fields[] = scm_acf_field( 'tab-head-menu', 'tab-left', __( 'Menu', SCM_THEME ) );
                $fields = array_merge( $fields, scm_acf_options_head_menu( $name . 'menu' ) );

            $fields[] = scm_acf_field( 'tab-head-social', 'tab-left', __( 'Social', SCM_THEME ) );
                $fields = array_merge( $fields, scm_acf_options_head_social( $name . 'follow' ) );

			return $fields;
		}
	}

	// HEAD BRANDING OPTIONS
	if ( ! function_exists( 'scm_acf_options_head_branding' ) ) {
		function scm_acf_options_head_branding( $name = '', $default = 0 ) {

			$name = ( $name ? $name . '-' : '');

			$fields = array();
			
			$fields[] = scm_acf_field_select_align( $name . 'alignment', $default );
			// conditional
			$fields[] = scm_acf_field_select( $name . 'head', $default, 'branding_header', 100, 0, '', __( 'Tipo', SCM_THEME ) );
			$tipo = array(
				'field' => $name . 'head',
				'operator' => '==',
				'value' => 'img',
			);
			
				$fields[] = scm_acf_field_image( $name . 'logo', $default, 100, $tipo, __( 'Logo', SCM_THEME ) );
				$fields = array_merge( $fields, scm_acf_preset_size( $name . 'height', $default, '40', 'px', __( 'Altezza Massima', SCM_THEME ), $tipo ) );

			$fields[] = scm_acf_field_select_hide( $name . 'slogan', $default, __( 'Slogan', SCM_THEME ) );

			return $fields;
		}
	}

	// HEAD MENU OPTIONS
	if ( ! function_exists( 'scm_acf_options_head_menu' ) ) {
		function scm_acf_options_head_menu( $name = '', $default = 0 ) {

			$name = ( $name ? $name . '-' : '');

			$fields = array();
			
			$fields[] = scm_acf_field( 'msg-menu', 'message', __( 'Opzioni Menu', SCM_THEME ) );
				$fields[] = scm_acf_field_select( $name . 'wp', $default, 'wp_menu', 50, 0, '', __( 'Menu', SCM_THEME ) );
				
				$fields[] = scm_acf_field_select_disable( $name . 'overlay', $default, __( 'Overlay', SCM_THEME ), 50 );
				$fields[] = scm_acf_field_select( $name . 'position', $default, 'position_menu', 50, 0, '', __( 'Posizione', SCM_THEME ) );
				$fields[] = scm_acf_field_select_align( $name . 'alignment', $default, 50 );
				
				$fields = array_merge( $fields, scm_acf_preset_text_font( $name . 'webfonts', $default, 0, 33, 33, 33 ) );

			$fields[] = scm_acf_field( 'msg-toggle', 'message', __( 'Toggle Menu', SCM_THEME ) );
				$fields[] = scm_acf_field_select( $name . 'toggle', $default, 'responsive_up', 34, 0, '', __( 'Attiva Toggle Menu', SCM_THEME ) );
				$fields[] = scm_acf_field_icon( $name . 'toggle-icon-open', $default, 'bars', '', 33, 0, __( 'Icona Apri Toggle Menu', SCM_THEME ) );
				$fields[] = scm_acf_field_icon( $name . 'toggle-icon-close', $default, 'arrow-circle-up', '', 33, 0, __( 'Icona Chiudi Toggle Menu', SCM_THEME ) );

			$fields[] = scm_acf_field( 'msg-home', 'message', __( 'Home Button', SCM_THEME ) );
				$fields[] = scm_acf_field_select( $name . 'home', $default, 'home_active', 50, 0, '', __( 'Attiva Home Button', SCM_THEME ) );
				$fields[] = scm_acf_field_icon( $name . 'home-icon', $default, 'home', '', 50, 0, __( 'Icona Home Button', SCM_THEME ) );
				$fields[] = scm_acf_field_select( $name . 'home-logo', $default, 'responsive_down-no', 50, 0, '', __( 'Attiva Logo', SCM_THEME ) );
				$fields[] = scm_acf_field_image( $name . 'home-image', $default, 50, 0, __( 'Logo Home', SCM_THEME ) );

			$fields[] = scm_acf_field( 'msg-sticky', 'message', __( 'Sticky Menu', SCM_THEME ) );
				// conditional
				$fields[] = scm_acf_field_select( $name . 'sticky', $default, 'sticky_active-no', 100, 0, '', __( 'Seleziona Tipo', SCM_THEME ) );
				$sticky = array(
					'field' => $name . 'sticky',
					'operator' => '==',
					'value' => 'plus',
				);
					$fields[] = scm_acf_field_select( $name . 'sticky-attach', $default, 'sticky_attach-no', 50, $sticky, '', __( 'Attach to Menu', SCM_THEME ) );
					$fields[] = scm_acf_field( $name . 'sticky-offset', array( 'pixel', '', '0', __( 'Offset', SCM_THEME ) ), __( 'Offset', SCM_THEME ), 50, $sticky );

			return $fields;
		}
	}

// MANNAGGIA ALLE COZZE, VEDI DI LEVARE STE OPZIONI COMPLESSE

	// HEAD SOCIAL OPTIONS
	if ( ! function_exists( 'scm_acf_options_head_social' ) ) {
		function scm_acf_options_head_social( $name = '', $default = 0 ) {

			$name = ( $name ? $name . '-' : '');

			$fields = array();
			
			// conditional
			$fields[] = scm_acf_field_select_hide( $name . 'enabled', $default, __( 'Social', SCM_THEME ) );
			$social = array( 'field' => $name . 'enabled', 'operator' => '==', 'value' => 'on' );

				$fields[] = scm_acf_field_object( 'element', $default, 'soggetti', 100, $social, __( 'Soggetto', SCM_THEME ) ); // mmmh
				$fields[] = scm_acf_field_select( $name . 'position', $default, 'head_social_position', 50, $social, '', __( 'Posizione', SCM_THEME ) );
				$fields[] = scm_acf_field_select_align( $name . 'alignment', $default, 50, $social );
				
				$fields = array_merge( $fields, scm_acf_preset_size( $name . 'size', $default, 16, 'px', __( 'Dimensione Icone', SCM_THEME ), $social ) );
				$fields = array_merge( $fields, scm_acf_preset_rgba( $name . 'rgba', $default, '', 1, $social ) );

			// +++ todo: aggiungere bg_image e tutte bg_cose nella lista Forma Box
				
				$fields[] = scm_acf_field_select1( $name . 'shape', $default, 'box_shape-no', 100, $social, __( 'Forma', SCM_THEME ), __( 'Forma Box', SCM_THEME ) );
				$shape = scm_acf_group_condition( $social, array( 'field' => $name . 'shape', 'operator' => '!=', 'value' => 'no' ) );
				$rounded = scm_acf_group_condition( $shape, array( 'field' => $name . 'shape', 'operator' => '!=', 'value' => 'square' ) );

					$fields[] = scm_acf_field_select1( $name . 'shape-size', $default, 'simple_size', 50, $rounded, __( 'Dimensione', SCM_THEME ), __( 'Dimensione angoli Box', SCM_THEME ) );
					$fields[] = scm_acf_field_select1( $name . 'shape-angle', $default, 'box_angle_type', 50, $rounded, __( 'Angoli', SCM_THEME ), __( 'Angoli Box', SCM_THEME ) );

					$fields = array_merge( $fields, scm_acf_preset_rgba( $name . 'box', $default, '', 1, $shape ) );

			return $fields;
		}
	}

	// FOOTER
	if ( ! function_exists( 'scm_acf_options_foot' ) ) {
		function scm_acf_options_foot( $name = '', $default = 0 ) {

			$name = ( $name ? $name . '-' : '');

			$fields = array();

			$fields = array_merge( $fields, scm_acf_preset_flexible_sections( $name . 'footer', $default ) );

			return $fields;
		}
	}


	
?>