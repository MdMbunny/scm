<?php
/**
 * @package SCM
 */

// *****************************************************
// *	ACF FIELDS
// *****************************************************

	
	if ( ! function_exists( 'scm_acf_preset' ) ) {
		function scm_acf_preset( $is = array(), $def = '' ) {

			$default = array_merge( array(
				'name' 					=> '',
				'default' 				=> 0,
				'width' 				=> '',
				'logic' 				=> 0,
				'placeholder' 			=> '',
				'label' 				=> '',
				'instructions' 			=> '',
				'required' 				=> 0,
            ), $is );

			if( is_array( $def ) ){
				$default['name'] = '';
                $default = array_merge( $default, $def );
            }

			return $default;
		}
	}

/* Hidden */

	// HAS GROUP
	if ( ! function_exists( 'scm_acf_field_hidden' ) ) {
		function scm_acf_field_hidden( $name = '' ) {
			return scm_acf_field( $name, array( 'number-read', 1, 1 ), $name );
		}
	}

/* Number */

	// NUMBER
	if ( ! function_exists( 'scm_acf_field_number' ) ) {
		function scm_acf_field_number( $name = '', $default = 0, $width = '', $logic = 0, $placeholder = 'auto', $label = '', $min = '', $max = '', $instructions = '', $required = 0 ) {
			//$label = ( $label ?: __( 'Misura', SCM_THEME ) );
			return scm_acf_field( $name, array( 'number', '', ( $default ? 'default' : $placeholder ), __( 'Misura', SCM_THEME ) ), $label, $width, $logic, $instructions, $required );
		}
	}
	
	// OPTION
	if ( ! function_exists( 'scm_acf_field_option' ) ) {
		function scm_acf_field_option( $name = '', $default = 0, $width = '', $logic = 0, $placeholder = 'auto', $label = '', $instructions = '', $required = 0 ) {
			//$label = ( $label ?: __( 'Misura', SCM_THEME ) );
			return scm_acf_field( $name, array( 'option', '', ( $default ? 'default' : $placeholder ), __( 'Misura', SCM_THEME ) ), $label, $width, $logic, $instructions, $required );
		}
	}

	// POSITIVE
	if ( ! function_exists( 'scm_acf_field_positive' ) ) {
		function scm_acf_field_positive( $name = '', $default = '', $width = '', $logic = 0, $placeholder = 'auto', $label = '', $instructions = '', $required = 0 ) {
			//$label = ( $label ?: __( 'Misura', SCM_THEME ) );
			return scm_acf_field( $name, array( 'positive', $default, $placeholder, __( 'Misura', SCM_THEME ) ), $label, $width, $logic, $instructions, $required );
		}
	}
	
	// ALPHA
	if ( ! function_exists( 'scm_acf_field_alpha' ) ) {
		function scm_acf_field_alpha( $name = '', $default = 0, $width = '', $logic = 0, $placeholder = '1', $label = '', $instructions = '', $required = 0 ) {
			//$label = ( $label ?: __( 'Trasparenza', SCM_THEME ) );
			return scm_acf_field( $name, array( 'alpha', '', ( $default ? 'default' : $placeholder ), __( 'Trasparenza', SCM_THEME ) ), $label, $width, $logic, $instructions, $required );
		}
	}
	
/* Text */

	// TEXT
	if ( ! function_exists( 'scm_acf_field_text' ) ) {
		function scm_acf_field_text( $name = '', $default = '', $width = '', $logic = 0, $placeholder = '', $label = '', $append = '', $max = '', $instructions = '', $required = 0 ) {
			$placeholder = ( $placeholder ?: __( 'testo', SCM_THEME ) );
			//$label = ( $label ?: __( 'Testo', SCM_THEME ) );
			return scm_acf_field( $name, array( 'text', $default, $placeholder, $append, '', $max ), $label, $width, $logic, $instructions, $required );
		}
	}
	
	// TEXT REQUIRED
	if ( ! function_exists( 'scm_acf_field_text_req' ) ) {
		function scm_acf_field_text_req( $name = '', $default = 0, $width = '', $logic = 0, $placeholder = '', $label = '', $append = '', $max = '', $instructions = '', $required = 1 ) {
			$placeholder = ( $placeholder ?: __( 'testo', SCM_THEME ) );
			//$label = ( $label ?: __( 'Testo', SCM_THEME ) );
			return scm_acf_field( $name, array( 'text', '', ( $default ? 'default' : $placeholder ), $append, '', $max ), $label, $width, $logic, $instructions, $required );
		}
	}
	
	// ID
	if ( ! function_exists( 'scm_acf_field_id' ) ) {
		function scm_acf_field_id( $name = '', $default = 0, $width = '', $logic = 0, $placeholder = '', $label = '', $max = '', $instructions = '', $required = 0 ) {
			$placeholder = ( $placeholder ?: __( 'id', SCM_THEME ) );
			//$label = ( $label ?: __( 'ID', SCM_THEME ) );
			return scm_acf_field( $name, array( 'id', '', ( $default ? 'default' : $placeholder ) ), $label, $width, $logic, $instructions, $required );
		}
	}

	// CLASS
	if ( ! function_exists( 'scm_acf_field_class' ) ) {
		function scm_acf_field_class( $name = '', $default = 0, $width = '', $logic = 0, $placeholder = '', $label = '', $max = '', $instructions = '', $required = 0 ) {
			$placeholder = ( $placeholder ?: __( 'class', SCM_THEME ) );
			//$label = ( $label ?: __( 'Class', SCM_THEME ) );
			return scm_acf_field( $name, array( 'class', '', ( $default ? 'default' : $placeholder ) ), $label, $width, $logic, $instructions, $required );
		}
	}

	// NAME
	if ( ! function_exists( 'scm_acf_field_name_req' ) ) {
		function scm_acf_field_name_req( $name = '', $default = 0, $max = '', $width = '', $logic = 0, $placeholder = '', $label = '', $instructions = '', $required = 1 ) {
			$placeholder = ( $placeholder ?: __( 'nome', SCM_THEME ) );
			//$label = ( $label ?: __( 'Nome', SCM_THEME ) );
			return scm_acf_field( $name, array( 'name', '', ( $default ? 'default' : $placeholder ), __( 'Nome', SCM_THEME ), '', $max ), $label, $width, $logic, $instructions, $required );
		}
	}

	// NAME
	if ( ! function_exists( 'scm_acf_field_name' ) ) {
		function scm_acf_field_name( $name = '', $default = 0, $max = '', $width = '', $logic = 0, $placeholder = '', $label = '', $instructions = '', $required = 0 ) {
			$placeholder = ( $placeholder ?: __( 'nome', SCM_THEME ) );
			//$label = ( $label ?: __( 'Nome', SCM_THEME ) );
			return scm_acf_field( $name, array( 'name', '', ( $default ? 'default' : $placeholder ), __( 'Nome', SCM_THEME ), '', $max ), $label, $width, $logic, $instructions, $required );
		}
	}

	// LINK
	if ( ! function_exists( 'scm_acf_field_link' ) ) {
		function scm_acf_field_link( $name = '', $default = 0, $width = '', $logic = 0, $placeholder = 'http://www.esempio.com', $label = '', $instructions = '', $required = 0 ) {

			//$label = ( $label ?: __( 'Link', SCM_THEME ) );
			return scm_acf_field( $name, array( 'link', '', ( $default ? 'default' : $placeholder ), __( 'Link', SCM_THEME ) ), $label, $width, $logic, $instructions, $required );
		}
	}
	
	// EMAIL
	if ( ! function_exists( 'scm_acf_field_email' ) ) {
		function scm_acf_field_email( $name = '', $default = 0, $width = '', $logic = 0, $placeholder = 'info@esempio.com', $label = '', $instructions = '', $required = 0, $prepend = 'Email' ) {

            $def = scm_acf_preset( get_defined_vars(), $name );
			$field = array(
				'type' => 'text',
				'placeholder' => $def['placeholder'],
				'prepend' => $def['prepend'],
			);

			return scm_acf_field( $def, $field );
			//return scm_acf_field( $name, array( 'text', '', $placeholder, __( 'Email', SCM_THEME ) ), $label, $width, $logic, $instructions, $required );
		}
	}

	// PHONE
	if ( ! function_exists( 'scm_acf_field_phone' ) ) {
		function scm_acf_field_phone( $name = '', $default = 0, $width = '', $logic = 0, $placeholder = '+39 1234 567890', $label = '', $instructions = '', $required = 0 ) {
			//$label = ( $label ?: __( 'Numero', SCM_THEME ) );
			return scm_acf_field( $name, array( 'text', '', ( $default ? 'default' : $placeholder ), __( 'Numero', SCM_THEME ) ), $label, $width, $logic, $instructions, $required );
		}
	}

/* Limiter */
	
	// LIMITER
	if ( ! function_exists( 'scm_acf_field_limiter' ) ) {
		function scm_acf_field_limiter( $name = '', $default = 0, $max = 350, $char = 1, $width = '', $logic = 0, $label = '', $instructions = '', $required = 0 ) {
			$label = ( $label ?: __( 'Testo', SCM_THEME ) );
			return scm_acf_field( $name, array( 'limiter', $max, $char ), $label, $width, $logic, $instructions, $required );
		}
	}

/* TextArea */
	
	// TEXTAREA
	if ( ! function_exists( 'scm_acf_field_textarea' ) ) {
		function scm_acf_field_textarea( $name = '', $default = 0, $rows = 8, $width = '', $logic = 0, $placeholder = '', $label = '', $instructions = '', $required = 0 ) {
			$label = ( $label ?: __( 'Testo', SCM_THEME ) );
			return scm_acf_field( $name, array( 'textarea', ( $default ? $placeholder : '' ), $placeholder, $rows ), $label, $width, $logic, $instructions, $required );
		}
	}

	// TEXTAREA CODE
	if ( ! function_exists( 'scm_acf_field_codearea' ) ) {
		function scm_acf_field_codearea( $name = '', $default = 0, $rows = 8, $width = '', $logic = 0, $placeholder = '', $label = '', $instructions = '', $required = 0 ) {
			$label = ( $label ?: __( 'Testo', SCM_THEME ) );
			return scm_acf_field( $name, array( 'textarea-no', ( $default ? $placeholder : '' ), $placeholder, $rows ), $label, $width, $logic, $instructions, $required, 'widefat code' );
		}
	}

/* Editor */
	
	// EDITOR BASIC MEDIA
	if ( ! function_exists( 'scm_acf_field_editor' ) ) {
		function scm_acf_field_editor( $name = '', $default = 0, $width = '', $logic = 0, $placeholder = '', $label = '', $instructions = '', $required = 0 ) {
			$label = ( $label ?: __( 'Testo', SCM_THEME ) );
			return scm_acf_field( $name, array( 'editor-media-basic', $placeholder ), $label, $width, $logic, $instructions, $required );
		}
	}

	// EDITOR VISUAL MEDIA
	if ( ! function_exists( 'scm_acf_field_editor_media' ) ) {
		function scm_acf_field_editor_media( $name = '', $default = 0, $width = '', $logic = 0, $placeholder = '', $label = '', $instructions = '', $required = 0 ) {
			$label = ( $label ?: __( 'Testo', SCM_THEME ) );
			return scm_acf_field( $name, array( 'editor-basic-visual-media', $placeholder ), $label, $width, $logic, $instructions, $required );
		}
	}

	// EDITOR VISUAL
	if ( ! function_exists( 'scm_acf_field_editor_basic' ) ) {
		function scm_acf_field_editor_basic( $name = '', $default = 0, $width = '', $logic = 0, $placeholder = '', $label = '', $instructions = '', $required = 0 ) {
			$label = ( $label ?: __( 'Testo', SCM_THEME ) );
			return scm_acf_field( $name, array( 'editor-basic-visual', $placeholder ), $label, $width, $logic, $instructions, $required );
		}
	}

/* Date */
	
	// DATE
	if ( ! function_exists( 'scm_acf_field_date' ) ) {
		function scm_acf_field_date( $name = '', $default = 0, $width = '', $logic = 0, $placeholder = '', $label = '', $instructions = '', $required = 0 ) {
			$label = ( $label ?: __( 'Data', SCM_THEME ) );
			return scm_acf_field( $name, array( 'date', ( $placeholder ?: '' ) ), $label, $width, $logic, $instructions, $required );
		}
	}

/* Color */
	
	// COLOR
	if ( ! function_exists( 'scm_acf_field_color' ) ) {
		function scm_acf_field_color( $name = '', $default = 0, $width = '', $logic = 0, $placeholder = '', $label = '', $instructions = '', $required = 0 ) {
			$label = ( $label ?: __( 'Colore', SCM_THEME ) );
			return scm_acf_field( $name, array( 'color', ( $placeholder ?: '' ) ), $label, $width, $logic, $instructions, $required );
		}
	}

/* Icon */

	// ICON
	if ( ! function_exists( 'scm_acf_field_icon' ) ) {
		function scm_acf_field_icon( $name = '', $default = 0, $placeholder = 'star', $filter = '', $width = '', $logic = 0, $label = '', $instructions = '', $required = 0 ) {
			$label = ( $label ?: __( 'Seleziona un\'icona', SCM_THEME ) );
			return scm_acf_field( $name, array( 'icon', $placeholder, $filter ), $label, $width, $logic, $instructions, $required );
		}
	}

	// ICON
	if ( ! function_exists( 'scm_acf_field_icon_no' ) ) {
		function scm_acf_field_icon_no( $name = '', $default = 0, $placeholder = 'no', $filter = '', $width = '', $logic = 0, $label = '', $instructions = '', $required = 0 ) {
			$label = ( $label ?: __( 'Seleziona un\'icona', SCM_THEME ) );
			return scm_acf_field( $name, array( 'icon-no', $placeholder, $filter ), $label, $width, $logic, $instructions, $required );
		}
	}

/* Image */

	// IMAGE
	if ( ! function_exists( 'scm_acf_field_image' ) ) {
		function scm_acf_field_image( $name = '', $default = 0, $width = '', $logic = 0, $label = '', $instructions = '', $required = 0 ) {
			$label = ( $label ?: __( 'Seleziona un\'immagine', SCM_THEME ) );
			return scm_acf_field( $name, 'image-url', $label, $width, $logic, $instructions, $required );
		}
	}

/* File */

	// FILE
	if ( ! function_exists( 'scm_acf_field_file' ) ) {
		function scm_acf_field_file( $name = '', $default = 0, $width = '', $logic = 0, $label = '', $instructions = '', $required = 0 ) {
			$label = ( $label ?: __( 'Seleziona un file', SCM_THEME ) );
			return scm_acf_field( $name, 'file-url', $label, $width, $logic, $instructions, $required );
		}
	}

	// FILE OBJECT
	if ( ! function_exists( 'scm_acf_field_fileobj' ) ) {
		function scm_acf_field_fileobj( $name = '', $default = 0, $width = '', $logic = 0, $label = '', $instructions = '', $required = 0 ) {
			$label = ( $label ?: __( 'Seleziona un file', SCM_THEME ) );
			return scm_acf_field( $name, 'file', $label, $width, $logic, $instructions, $required );
		}
	}

/* True False */

// FALSE/TRUE
	if ( ! function_exists( 'scm_acf_field_false_true' ) ) {
		function scm_acf_field_false_true( $name = '', $default = 0, $width = '', $logic = 0, $label = '', $instructions = '', $required = 0 ) {
			$label = ( $label ?: __( 'Abilita', SCM_THEME ) );

			return scm_acf_field( $name, array( 'true_false' . ( $default ? '-default' : '' ), 0 ), $label, $width, $logic, $instructions, $required );
		}
	}

	// FALSE
	if ( ! function_exists( 'scm_acf_field_falsetrue' ) ) {
		function scm_acf_field_falsetrue( $name = '', $default = 0, $width = '', $logic = 0, $label = '', $instructions = '', $required = 0 ) {
			return scm_acf_field( $name, array( 'true_false', 0 ), $label, $width, $logic, $instructions, $required );
		}
	}

	// FALSE
	if ( ! function_exists( 'scm_acf_field_truefalse' ) ) {
		function scm_acf_field_truefalse( $name = '', $default = 0, $width = '', $logic = 0, $label = '', $instructions = '', $required = 0 ) {
			return scm_acf_field( $name, array( 'true_false', 1 ), $label, $width, $logic, $instructions, $required );
		}
	}

/* Select */

	// SELECT 1
	if ( ! function_exists( 'scm_acf_field_select1' ) ) {
		function scm_acf_field_select1( $name = '', $default = 0, $type = '', $width = '', $logic = 0, $placeholder = '', $label = '', $instructions = '', $required = 0 ) {
			//$label = ( $label ?: __( 'Elementi', SCM_THEME ) );
			return scm_acf_field( $name, array( 'select' . ( $type ? '-' . $type : '' ) . ( $default ? '-default' : '' ), $placeholder, ( $label ? __( 'Seleziona', SCM_THEME ) . ' ' . $label : '' ) ), $label, $width, $logic, $instructions, $required );
		}
	}

	// SELECT 2
	if ( ! function_exists( 'scm_acf_field_select' ) ) {
		function scm_acf_field_select( $name = '', $default = 0, $type = '', $width = '', $logic = 0, $placeholder = '', $label = '', $instructions = '', $required = 0 ) {
			//$label = ( $label ?: __( 'Elementi', SCM_THEME ) );
			return scm_acf_field( $name, array( 'select2' . ( $type ? '-' . $type : '' ) . ( $default ? '-default' : '' ), $placeholder, ( $label ? __( 'Seleziona', SCM_THEME ) . ' ' . $label : '' ) ), $label, $width, $logic, $instructions, $required );
		}
	}

	// DATE FORMAT
	if ( ! function_exists( 'scm_acf_field_select_date' ) ) {
		function scm_acf_field_select_date( $name = '', $default = 0, $width = '', $logic = 0, $placeholder = '', $label = '', $instructions = '', $required = 0 ) {
			$label = ( $label ?: __( 'Formato', SCM_THEME ) );

			return scm_acf_field( $name, array( 'select-date_format' . ( $default ? '-default' : '' ), $placeholder, $label ), $label, $width, $logic, $instructions, $required );
		}
	}

	// COLUMN WIDTH
	if ( ! function_exists( 'scm_acf_field_select_column_width' ) ) {
		function scm_acf_field_select_column_width( $name = '', $default = 0, $width = '', $logic = 0, $placeholder = '', $label = '', $instructions = '', $required = 0 ) {
			$label = ( $label ?: __( 'Larghezza', SCM_THEME ) );

			return scm_acf_field( $name, array( 'select2-columns_width' . ( $default ? '-default' : '' ), $placeholder, $label ), $label, $width, $logic, $instructions, $required );
		}
	}

	// OPTIONS
	if ( ! function_exists( 'scm_acf_field_select_options' ) ) {
		function scm_acf_field_select_options( $name = '', $default = 0, $width = '', $logic = 0, $placeholder = '', $label = '', $instructions = '', $required = 0 ) {
			$label = ( $label ?: __( 'Opzioni', SCM_THEME ) );

			return scm_acf_field( $name, array( 'select-options_show' . ( $default ? '-default' : '' ), $placeholder, $label ), $label, $width, $logic, $instructions, $required );
		}
	}

	// HIDE
	if ( ! function_exists( 'scm_acf_field_select_hide' ) ) {
		function scm_acf_field_select_hide( $name = '', $default = 0, $placeholder = '', $width = '', $logic = 0, $label = '', $instructions = '', $required = 0 ) {
			$label = ( $label ?: __( 'Mostra', SCM_THEME ) );

			return scm_acf_field( $name, array( 'select-hide' . ( $default ? '-default' : '' ), $placeholder, $label ), $label . ( $placeholder ? ' ' . $placeholder : '' ), $width, $logic, $instructions, $required );
		}
	}

	// HIDE2
	if ( ! function_exists( 'scm_acf_field_select_hide2' ) ) {
		function scm_acf_field_select_hide2( $name = '', $default = 0, $placeholder = '', $width = '', $logic = 0, $label = '', $instructions = '', $required = 0 ) {
			$label = ( $label ?: __( 'Mostra', SCM_THEME ) );

			return scm_acf_field( $name, array( 'select2-hide' . ( $default ? '-default' : '' ), $placeholder, $label ), $label . ( $placeholder ? ' ' . $placeholder : '' ), $width, $logic, $instructions, $required );
		}
	}
	
	// SHOW
	if ( ! function_exists( 'scm_acf_field_select_show' ) ) {
		function scm_acf_field_select_show( $name = '', $default = 0, $placeholder = '', $width = '', $logic = 0, $label = '', $instructions = '', $required = 0 ) {
			$label = ( $label ?: __( 'Mostra', SCM_THEME ) );

			return scm_acf_field( $name, array( 'select-show' . ( $default ? '-default' : '' ), $placeholder, $label ), $label . ( $placeholder ? ' ' . $placeholder : '' ), $width, $logic, $instructions, $required );
		}
	}

	// SHOW2
	if ( ! function_exists( 'scm_acf_field_select_show2' ) ) {
		function scm_acf_field_select_show2( $name = '', $default = 0, $placeholder = '', $width = '', $logic = 0, $label = '', $instructions = '', $required = 0 ) {
			$label = ( $label ?: __( 'Mostra', SCM_THEME ) );

			return scm_acf_field( $name, array( 'select2-show' . ( $default ? '-default' : '' ), $placeholder, $label ), $label . ( $placeholder ? ' ' . $placeholder : '' ), $width, $logic, $instructions, $required );
		}
	}

	// DISABLE
	if ( ! function_exists( 'scm_acf_field_select_disable' ) ) {
		function scm_acf_field_select_disable( $name = '', $default = 0, $placeholder = '', $width = '', $logic = 0, $label = '', $instructions = '', $required = 0 ) {
			$label = ( $label ?: __( 'Abilita', SCM_THEME ) );

			return scm_acf_field( $name, array( 'select-disable' . ( $default ? '-default' : '' ), $placeholder, $label ), $label . ( $placeholder ? ' ' . $placeholder : '' ), $width, $logic, $instructions, $required );
		}
	}

	// DISABLE2
	if ( ! function_exists( 'scm_acf_field_select_disable2' ) ) {
		function scm_acf_field_select_disable2( $name = '', $default = 0, $placeholder = '', $width = '', $logic = 0, $label = '', $instructions = '', $required = 0 ) {
			$label = ( $label ?: __( 'Abilita', SCM_THEME ) );

			return scm_acf_field( $name, array( 'select2-disable' . ( $default ? '-default' : '' ), $placeholder, $label ), $label . ( $placeholder ? ' ' . $placeholder : '' ), $width, $logic, $instructions, $required );
		}
	}

	// TRUE/FALSE
	if ( ! function_exists( 'scm_acf_field_true_false' ) ) {
		function scm_acf_field_true_false( $name = '', $default = 0, $width = '', $logic = 0, $label = '', $instructions = '', $required = 0 ) {
			$label = ( $label ?: __( 'Disabilita', SCM_THEME ) );

			return scm_acf_field( $name, array( 'true_false' . ( $default ? '-default' : '' ), 1 ), $label, $width, $logic, $instructions, $required );
		}
	}

	// ENABLE
	if ( ! function_exists( 'scm_acf_field_select_enable' ) ) {
		function scm_acf_field_select_enable( $name = '', $default = 0, $placeholder = '', $width = '', $logic = 0, $label = '', $instructions = '', $required = 0 ) {
			$label = ( $label ?: __( 'Abilita', SCM_THEME ) );

			return scm_acf_field( $name, array( 'select-enable' . ( $default ? '-default' : '' ), $placeholder, $label ), $label . ( $placeholder ? ' ' . $placeholder : '' ), $width, $logic, $instructions, $required );
		}
	}

	// ENABLE2
	if ( ! function_exists( 'scm_acf_field_select_enable2' ) ) {
		function scm_acf_field_select_enable2( $name = '', $default = 0, $placeholder = '', $width = '', $logic = 0, $label = '', $instructions = '', $required = 0 ) {
			$label = ( $label ?: __( 'Abilita', SCM_THEME ) );

			return scm_acf_field( $name, array( 'select2-enable' . ( $default ? '-default' : '' ), $placeholder, $label ), $label . ( $placeholder ? ' ' . $placeholder : '' ), $width, $logic, $instructions, $required );
		}
	}
	
	// HEADINGS
	if ( ! function_exists( 'scm_acf_field_select_headings' ) ) {
		function scm_acf_field_select_headings( $name = '', $default = 0, $opt = 0, $width = '', $logic = 0, $placeholder = '', $label = '', $instructions = '', $required = 0 ) {
			$label = ( $label ?: __( 'Stile', SCM_THEME ) );

			return scm_acf_field( $name, array( 'select-headings' . ( $opt === 1 ? '_low' : ( $opt === -1 ? '_min' : ( $opt === 2 ? '_max' : '' ) ) ) . ( $default ? '-default' : '' ), $placeholder, __( 'Seleziona', SCM_THEME ) . ' ' . $label ), $label, $width, $logic, $instructions, $required );
		}
	}

	// LAYOUT
	if ( ! function_exists( 'scm_acf_field_select_layout' ) ) {
		function scm_acf_field_select_layout( $name = '', $default = 0, $label = '', $width = '', $logic = 0, $placeholder = '', $instructions = '', $required = 0 ) {
			$label = ( $label ?: __( 'Layout', SCM_THEME ) );
			return scm_acf_field( $name, array( 'select-layout_main' . ( $default ? '-default' : '' ), $placeholder, __( 'Seleziona', SCM_THEME ) . ' ' . $label ), $label, $width, $logic, $instructions, $required );
		}
	}

	// IMAGE FORMAT
	if ( ! function_exists( 'scm_acf_field_select_image_format' ) ) {
		function scm_acf_field_select_image_format( $name = '', $default = 0, $width = '', $logic = 0, $placeholder = '', $label = '', $instructions = '', $required = 0 ) {
			$label = ( $label ?: __( 'Formato', SCM_THEME ) );

			return scm_acf_field( $name, array( 'select-image_format' . ( $default ? '-default' : '' ), $placeholder, __( 'Seleziona', SCM_THEME ) . ' ' . $label ), $label, $width, $logic, $instructions, $required );
		}
	}

	// FLOAT
	if ( ! function_exists( 'scm_acf_field_select_float' ) ) {
		function scm_acf_field_select_float( $name = '', $default = 0, $width = '', $logic = 0, $placeholder = '', $label = '', $instructions = '', $required = 0 ) {
			$label = ( $label ?: __( 'Allineamento', SCM_THEME ) );

			return scm_acf_field( $name, array( 'select-float' . ( $default ? '-default' : '' ), $placeholder, __( 'Seleziona', SCM_THEME ) . ' ' . $label ), $label, $width, $logic, $instructions, $required );
		}
	}
	
	// OVERLAY
	if ( ! function_exists( 'scm_acf_field_select_overlay' ) ) {
		function scm_acf_field_select_overlay( $name = '', $default = 0, $width = '', $logic = 0, $placeholder = '', $label = '', $instructions = '', $required = 0 ) {
			$label = ( $label ?: __( 'Overlay', SCM_THEME ) );

			return scm_acf_field( $name, array( 'select-overlay' . ( $default ? '-default' : '' ), $placeholder, __( 'Seleziona', SCM_THEME ) . ' ' . $label ), $label, $width, $logic, $instructions, $required );
		}
	}
	
	// ALIGN
	if ( ! function_exists( 'scm_acf_field_select_align' ) ) {
		function scm_acf_field_select_align( $name = '', $default = 0, $width = '', $logic = 0, $placeholder = '', $label = '', $instructions = '', $required = 0 ) {
			$label = ( $label ?: __( 'Allineamento', SCM_THEME ) );

			return scm_acf_field( $name, array( 'select-alignment' . ( $default ? '-default' : '' ), $placeholder, __( 'Seleziona', SCM_THEME ) . ' ' . $label ), $label, $width, $logic, $instructions, $required );
		}
	}

	// VERTICAL ALIGN
	if ( ! function_exists( 'scm_acf_field_select_valign' ) ) {
		function scm_acf_field_select_valign( $name = '', $default = 0, $width = '', $logic = 0, $placeholder = '', $label = '', $instructions = '', $required = 0 ) {
			$label = ( $label ?: __( 'Allineamento', SCM_THEME ) );

			return scm_acf_field( $name, array( 'select-vertical_alignment' . ( $default ? '-default' : '' ), $placeholder, __( 'Seleziona', SCM_THEME ) . ' ' . $label ), $label, $width, $logic, $instructions, $required );
		}
	}

	// TXT ALIGN
	if ( ! function_exists( 'scm_acf_field_select_txt_align' ) ) {
		function scm_acf_field_select_txt_align( $name = '', $default = 0, $width = '', $logic = 0, $placeholder = '', $label = '', $instructions = '', $required = 0 ) {
			$label = ( $label ?: __( 'Allineamento', SCM_THEME ) );

			return scm_acf_field( $name, array( 'select2-txt_alignment' . ( $default ? '-default' : '' ), $placeholder, __( 'Seleziona', SCM_THEME ) . ' ' . $label ), $label, $width, $logic, $instructions, $required );
		}
	}


	// UNITS
	if ( ! function_exists( 'scm_acf_field_select_units' ) ) {
		function scm_acf_field_select_units( $name = '', $default = 0, $width = '', $logic = 0, $placeholder = 'px', $label = '', $instructions = '', $required = 0 ) {
			$label = ( $label ?: __( 'Unità', SCM_THEME ) );

			return scm_acf_field( $name, array( 'select-units' . ( $default ? '-default' : '' ), $placeholder, __( 'Seleziona', SCM_THEME ) . ' ' . $label ), $label, $width, $logic, $instructions, $required );
		}
	}

/* Object */

	// INTERNAL OBJECT ID BY TAXONOMY
	if ( ! function_exists( 'scm_acf_field_object_tax' ) ) {
		function scm_acf_field_object_tax( $name = '', $default = 0, $type = '', $tax = '', $width = '', $logic = 0, $label = '', $instructions = '', $required = 0 ) {
			$label = ( $label ?: __( 'Contenuto', SCM_THEME ) );
			
			return scm_acf_field( $name, array( 'object-id', $type, $tax , __( 'Seleziona', SCM_THEME ) . ' ' . $label), $label, $width, $logic, $instructions, $required );
		}
	}

	// INTERNAL OBJECTS ID BY TAXONOMY
	if ( ! function_exists( 'scm_acf_field_objects_tax' ) ) {
		function scm_acf_field_objects_tax( $name = '', $default = 0, $type = '', $tax = '', $width = '', $logic = 0, $label = '', $instructions = '', $required = 0 ) {
			$label = ( $label ?: __( 'Contenuto', SCM_THEME ) );

			return scm_acf_field( $name, array( 'objects-id', $type, $tax , __( 'Seleziona', SCM_THEME ) . ' ' . $label), $label, $width, $logic, $instructions, $required );
		}
	}

	// INTERNAL OBJECT OBJ
	if ( ! function_exists( 'scm_acf_field_object_obj' ) ) {
		function scm_acf_field_object_obj( $name = '', $default = 0, $type = '', $width = '', $logic = 0, $label = '', $instructions = '', $required = 0 ) {
			$label = ( $label ?: __( 'Contenuto', SCM_THEME ) );
			return scm_acf_field( $name, array( 'object', $type, '', __( 'Seleziona', SCM_THEME ) . ' ' . $label ), $label, $width, $logic, $instructions, $required );
		}
	}

	// INTERNAL OBJECT OBJ NULL
	if ( ! function_exists( 'scm_acf_field_object_obj_null' ) ) {
		function scm_acf_field_object_obj_null( $name = '', $default = 0, $type = '', $width = '', $logic = 0, $label = '', $instructions = '', $required = 0 ) {
			$label = ( $label ?: __( 'Contenuto', SCM_THEME ) );
			return scm_acf_field( $name, array( 'object-null', $type, '', __( 'Seleziona', SCM_THEME ) . ' ' . $label ), $label, $width, $logic, $instructions, $required );
		}
	}

	// INTERNAL OBJECT ID
	if ( ! function_exists( 'scm_acf_field_object' ) ) {
		function scm_acf_field_object( $name = '', $default = 0, $type = '', $width = '', $logic = 0, $label = '', $instructions = '', $required = 0 ) {
			$label = ( $label ?: __( 'Contenuto', SCM_THEME ) );
			return scm_acf_field( $name, array( 'object-id', $type, '', __( 'Seleziona', SCM_THEME ) . ' ' . $label ), $label, $width, $logic, $instructions, $required );
		}
	}

	// INTERNAL OBJECT ID NULL
	if ( ! function_exists( 'scm_acf_field_object_null' ) ) {
		function scm_acf_field_object_null( $name = '', $default = 0, $type = '', $width = '', $logic = 0, $label = '', $instructions = '', $required = 0 ) {
			$label = ( $label ?: __( 'Contenuto', SCM_THEME ) );
			return scm_acf_field( $name, array( 'object-id-null', $type, '', __( 'Seleziona', SCM_THEME ) . ' ' . $label ), $label, $width, $logic, $instructions, $required );
		}
	}

	// INTERNAL OBJECT ID REL
	if ( ! function_exists( 'scm_acf_field_object_rel' ) ) {
		function scm_acf_field_object_rel( $name = '', $default = 0, $type = '', $width = '', $logic = 0, $label = '', $instructions = '', $required = 0 ) {
			$label = ( $label ?: __( 'Contenuto', SCM_THEME ) );

			return scm_acf_field( $name, array( 'object-rel-id', $type, '', __( 'Seleziona', SCM_THEME ) . ' ' . $label ), $label, $width, $logic, $instructions, $required );
		}
	}

	// INTERNAL OBJECTS
	if ( ! function_exists( 'scm_acf_field_object_objs' ) ) {
		function scm_acf_field_object_objs( $name = '', $default = 0, $type = '', $width = '', $logic = 0, $label = '', $instructions = '', $required = 0 ) {
			$label = ( $label ?: __( 'Contenuto', SCM_THEME ) );

			return scm_acf_field( $name, array( 'objects', $type, '', __( 'Seleziona', SCM_THEME ) . ' ' . $label ), $label, $width, $logic, $instructions, $required );
		}
	}

	// INTERNAL OBJECTS ID
	if ( ! function_exists( 'scm_acf_field_objects' ) ) {
		function scm_acf_field_objects( $name = '', $default = 0, $type = '', $width = '', $logic = 0, $label = '', $instructions = '', $required = 0 ) {
			$label = ( $label ?: __( 'Contenuti', SCM_THEME ) );

			return scm_acf_field( $name, array( 'objects-id', $type, '', __( 'Seleziona', SCM_THEME ) . ' ' . $label ), $label, $width, $logic, $instructions, $required );
		}
	}

	// INTERNAL OBJECTS ID REL
	if ( ! function_exists( 'scm_acf_field_objects_rel' ) ) {
		function scm_acf_field_objects_rel( $name = '', $default = 0, $type = '', $width = '', $logic = 0, $label = '', $instructions = '', $required = 0 ) {
			$label = ( $label ?: __( 'Contenuti', SCM_THEME ) );

			return scm_acf_field( $name, array( 'objects-rel-id', $type, '', __( 'Seleziona', SCM_THEME ) . ' ' . $label ), $label, $width, $logic, $instructions, $required );
		}
	}

	// INTERNAL LINKS
	if ( ! function_exists( 'scm_acf_field_object_link' ) ) {
		function scm_acf_field_object_link( $name = '', $default = 0, $type = '', $width = '', $logic = 0, $label = '', $instructions = '', $required = 0 ) {
			$label = ( $label ?: __( 'Contenuto', SCM_THEME ) );

			return scm_acf_field( $name, array( 'object-link', $type, '', __( 'Seleziona', SCM_THEME ) . ' ' . $label ), $label, $width, $logic, $instructions, $required );
		}
	}

	// INTERNAL LINKS
	if ( ! function_exists( 'scm_acf_field_objects_link' ) ) {
		function scm_acf_field_objects_link( $name = '', $default = 0, $type = '', $width = '', $logic = 0, $label = '', $instructions = '', $required = 0 ) {
			$label = ( $label ?: __( 'Contenuti', SCM_THEME ) );

			return scm_acf_field( $name, array( 'objects-link', $type, '', __( 'Seleziona', SCM_THEME ) . ' ' . $label ), $label, $width, $logic, $instructions, $required );
		}
	}

/* Taxonomy */

	// TAXONOMY
	if ( ! function_exists( 'scm_acf_field_taxonomy' ) ) {
		function scm_acf_field_taxonomy( $name = '', $default = 0, $tax = '', $label = '', $add = 1, $save = 0, $width = '', $logic = 0, $instructions = '', $required = 0 ) {
			$label = ( $label ?: __( 'Taxonomy', SCM_THEME ) );

			//printPre( $name . ' - ' . $tax . ' - ' . $label . ' - ' . $save );

			return scm_acf_field( $name, array( 'taxonomy-id', $tax, $add, $save ), $label, $width, $logic, $instructions, $required );
		}
	}

	// TAXONOMIES
	if ( ! function_exists( 'scm_acf_field_taxonomies' ) ) {
		function scm_acf_field_taxonomies( $name = '', $default = 0, $tax = '', $label = '', $add = 1, $save = 0, $width = '', $logic = 0, $instructions = '', $required = 0 ) {
			$label = ( $label ?: __( 'Taxonomies', SCM_THEME ) );
			//printPre( $name . ' - ' . $tax . ' - ' . $label . ' - ' . $save );
			return scm_acf_field( $name, array( 'taxonomies-id', $tax, $add, $save ), $label, $width, $logic, $instructions, $required );
		}
	}

/* Repeater */

	// REPEATER BLOCK
	if ( ! function_exists( 'scm_acf_field_repeater' ) ) {
		function scm_acf_field_repeater( $name = '', $default = 0, $button = '', $label = '', $width = '', $logic = 0, $min = '', $max = '', $instructions = '', $required = 0, $class = '' ) {
			$button = ( $button ?: __( 'Aggiungi', SCM_THEME ) );
			$label = ( $label ?: __( 'Elementi', SCM_THEME ) );
			return scm_acf_field( $name, array( 'repeater-block', $button, $min, $max ), $label, 100, $logic, $instructions, $required, $class );
		}
	}

	// REPEATER BLOCK LABELS
	if ( ! function_exists( 'scm_acf_field_repeater_labels' ) ) {
		function scm_acf_field_repeater_labels( $name = '', $default = 0, $button = '', $label = '', $width = '', $logic = 0, $min = '', $max = '', $instructions = '', $required = 0, $class = '' ) {
			$button = ( $button ?: __( 'Aggiungi', SCM_THEME ) );
			$label = ( $label ?: __( 'Elementi', SCM_THEME ) );
			$class .= ' repeater-labels' ;
			return scm_acf_field( $name, array( 'repeater-block', $button, $min, $max ), $label, 100, $logic, $instructions, $required, $class );
		}
	}

	// REPEATER ROW
	if ( ! function_exists( 'scm_acf_field_repeater_row' ) ) {
		function scm_acf_field_repeater_row( $name = '', $default = 0, $button = '', $label = '', $width = '', $logic = 0, $min = '', $max = '', $instructions = '', $required = 0, $class = '' ) {
			$button = ( $button ?: __( 'Aggiungi', SCM_THEME ) );
			$label = ( $label ?: __( 'Elementi', SCM_THEME ) );
			return scm_acf_field( $name, array( 'repeater-row', $button, $min, $max ), $label, 100, $logic, $instructions, $required, $class );
		}
	}

	// REPEATER TABLE
	if ( ! function_exists( 'scm_acf_field_repeater_table' ) ) {
		function scm_acf_field_repeater_table( $name = '', $default = 0, $button = '', $label = '', $width = '', $logic = 0, $min = '', $max = '', $instructions = '', $required = 0, $class = '' ) {
			$button = ( $button ?: __( 'Aggiungi', SCM_THEME ) );
			$label = ( $label ?: __( 'Elementi', SCM_THEME ) );
			return scm_acf_field( $name, array( 'repeater-table', $button, $min, $max ), $label, 100, $logic, $instructions, $required, $class );
		}
	}

/* Flexible Content */

	// FLEXIBLE CONTENT
	if ( ! function_exists( 'scm_acf_field_flexible' ) ) {
		function scm_acf_field_flexible( $name = '', $default = 0, $label = '', $button = '+', $width = '', $logic = 0, $min = '', $max = '', $instructions = '', $required = 0, $class = '' ) {
			$label = ( $label ?: __( 'Componi', SCM_THEME ) );
			return scm_acf_field( $name, array( 'flexible', $button, $min, $max ), $label, 100, $logic, $instructions, $required, $class );
		}
	}
	
?>