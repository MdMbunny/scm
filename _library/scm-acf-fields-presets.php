<?php

/**
* ACF all available Custom Fields Presets.
*
* @link http://www.studiocreativo-m.it
*
* @package SCM
* @subpackage 2-ACF/Fields/PRESET
* @since 1.0.0
*/

// ------------------------------------------------------
//
// 1.0 Presets
//		ADVANCED OPTIONS
//		INSTRUCTIONS
//		SELECTORS
//		COLUMN WIDTH
//		BEHAVIOUR
//		SIZE
//		COLOR
//		BACKGROUND STYLE
//		TEXT FONT
//		TEXT SET
//		TEXT SHADOW
//		TEXT STYLE
//		BOX SHAPE
//		BOX STYLE
//		MAP ICON
//		TERM
//		TERMS
//		TAXONOMY
//		TAXONOMIES
//		CATEGORY REQUIRED
//		CATEGORY
//		CATEGORIES
//		TAG
//		TAGS
//		COLUMNS
//		BUTTON
//		ICONS
//		BUTTON SHAPE
//		SECTIONS
//		LAYOUTS
//
// ------------------------------------------------------

// ------------------------------------------------------
// 1.0 PRESETS
// ------------------------------------------------------

/**
* [GET] Preset advanced options
*
* @param {string} name
* @param {int} opt [ 0 | 1 or 'nolink' | 2 or 'simple' | 3 or 'module' | 4 or 'row' | 5 or 'section' | 6 or 'page' ]
* @return {array} Fields.
*/
function scm_acf_preset_advanced_options( $name = '', $opt = 0 ) {

	$second = ( $name ? $name . '-' : '');

	$fields = array();

	// ADVANCED

		switch ( $opt ) {
			case 6:
			case 'page':
				$fields = array_merge( $fields, scm_acf_preset_selectors( $name, 30, 0, 0 ) );
				$fields[] = scm_acf_field_select( $second . 'layout', array( 'type'=>'main_layout', 'default'=>array( 'default'=>'Default Layout' ) ), 35 );
				$fields[] = scm_acf_field_select( $second . 'menu', array( 'type'=>'wp_menu', 'default'=>array( 'default'=>'Default Menu' ) ), 35 );
				$fields = array_merge( $fields, scm_fields_add_class( scm_acf_preset_selectors( $name, 0, 30, 70 ), SCM_ADVANCED_OPTIONS . ' hidden' ) );
				$fields[] = scm_field_add_class( scm_acf_field_select( $second . 'selectors', '2-selectors', 60 ), SCM_ADVANCED_OPTIONS . ' hidden' );
				$fields[] = scm_field_add_class( scm_acf_field_false( $second . 'form', 0, 40, 0, 0, __( 'Attiva ACF Form', SCM_THEME ) ), SCM_ADVANCED_OPTIONS . ' hidden' );
				break;
			case 5:
			case 'section':
				$fields = array_merge( $fields, scm_acf_preset_selectors( $name, 25, 0, 0 ) );
				$fields[] = scm_acf_field_select( $second . 'selectors', '2-selectors', 75 );
				$fields = array_merge( $fields, scm_fields_add_class( scm_acf_preset_selectors( $name, 0, 30, 70 ), SCM_ADVANCED_OPTIONS . ' hidden' ) );
				break;
			case 4:
			case 'row':
				$fields[] = scm_acf_field_select( $second . 'layout', 'main_layout-default', 50 );
				$fields[] = scm_acf_field_select( $second . 'selectors', '2-selectors', 50 );
				$fields = array_merge( $fields, scm_fields_add_class( scm_acf_preset_selectors( $name, 20, 20, 60 ), SCM_ADVANCED_OPTIONS . ' hidden' ) );
				break;
			case 3:
			case 'module':
				$fields[] = scm_acf_field_select( $second . 'layout', 'main_layout', 50 );
				$fields[] = scm_acf_field_select( $second . 'selectors', '2-selectors', 50 );
				$fields = array_merge( $fields, scm_fields_add_class( scm_acf_preset_selectors( $name, 20, 20, 60 ), SCM_ADVANCED_OPTIONS . ' hidden' ) );
				break;
			case 2:
			case 'simple':
				$fields = array_merge( $fields, scm_acf_preset_column_width( $name, 50 ) );
				$fields[] = scm_acf_field_select( $second . 'selectors', '2-selectors', 50 );
				$fields = array_merge( $fields, scm_fields_add_class( scm_acf_preset_selectors( $name, 20, 20, 60 ), SCM_ADVANCED_OPTIONS . ' hidden' ) );
				break;
			case 1:
			case 'nolink':
				$fields = array_merge( $fields, scm_acf_preset_column_width( $name, 50 ) );
				$fields[] = scm_acf_field_select( $second . 'selectors', '2-selectors', 50 );
				$fields = array_merge( $fields, scm_fields_add_class( scm_acf_preset_selectors( $name, 20, 20, 60 ), SCM_ADVANCED_OPTIONS . ' hidden' ) );
				$fields = array_merge( $fields, scm_fields_add_class( scm_acf_preset_behaviour( $name, 34, 33, 33 ), 'scm-options hidden' ) ); // deprecated, sistema tutti i siti quando puoi ed elimina
				break;
			default:
				$fields = array_merge( $fields, scm_acf_preset_column_width( $name, 50 ) );
				$fields[] = scm_acf_field_select( $second . 'selectors', '2-selectors', 50 );
				$fields = array_merge( $fields, scm_fields_add_class( scm_acf_preset_selectors( $name, 20, 20, 60 ), SCM_ADVANCED_OPTIONS . ' hidden' ) );
				$fields = array_merge( $fields, scm_fields_add_class( scm_acf_preset_behaviour( $name, 25, 25, 25, 25 ), 'scm-options hidden' ) ); // deprecated, sistema tutti i siti quando puoi ed elimina
				break;
		}
	
	return $fields;
}

/**
* [GET] Preset instructions
*
* @param {string} instructions
* @param {string} name
* @param {string} label
* @param {int} width
* @param {array} logic
* @return {array} Fields.
*/
function scm_acf_preset_instructions( $instructions = '', $name = 'instructions', $label = '', $width = 100, $logic = 0 ) {
	$fields = array();

	if( $instructions )
		$fields[] = scm_acf_field(
			array( 'name'=>$name . 'msg-open', 'width'=>$width, 'logic'=>$logic, 'label'=>( $label ?: __( 'Istruzioni', SCM_THEME ) ) ),
			array( 'type'=>'message', 'message'=>$instructions )
		);

	return $fields;
}

/**
* [GET] Preset selectors
*
* @param {string} name
* @param {int} w1
* @param {int} w2
* @param {int} w3
* @param {array} logic
* @param {bool} required
* @param {string} instructions
* @return {array} Fields.
*/
function scm_acf_preset_selectors( $name = '', $w1 = 100, $w2 = 100, $w3 = 0, $logic = 0, $required = 0, $instructions = '' ) {

	$name = ( $name ? $name . '-' : '');
	$fields = scm_acf_preset_instructions( $instructions, $name, __( 'Aggiungi Selettori', SCM_THEME ) );
	
	if( $w1 ) $fields[] = scm_acf_field_id( $name . 'id', 0, $w1, $logic, $required );
	if( $w2 ) $fields[] = scm_acf_field_class( $name . 'class', 0, $w2, $logic, $required );
	if( $w3 ) $fields[] = scm_acf_field_attributes( $name . 'attributes', 0, $w3, $logic, $required );

	return $fields;
}

/**
* [GET] Preset column width
*
* @param {string} name
* @param {int} width
* @param {array} logic
* @param {bool} required
* @param {string} instructions
* @return {array} Fields.
*/
function scm_acf_preset_column_width( $name = '', $width = 100, $logic = 0, $required = 0, $instructions = '' ) {

	$name = ( $name ? $name . '-' : '');
	$fields = scm_acf_preset_instructions( $instructions, $name, __( 'Aggiungi Larghezza colonna', SCM_THEME ) );
	
	$fields[] = scm_acf_field_select( $name . 'column-width', array( 
		'type'=>'2-columns_width',
		'choices'=>array( '1/1' => __( 'Larghezza piena', SCM_THEME ), 'auto' => __( 'Auto', SCM_THEME ) ),
	), $width, $logic, $required );

	return $fields;
}

/**
* [GET] Preset behaviour
*
* @param {string} name
* @param {int} w1
* @param {int} w2
* @param {int} w3
* @param {int} w4
* @param {array} logic
* @param {bool} required
* @param {string} instructions
* @return {array} Fields.
*/
function scm_acf_preset_behaviour( $name = '', $w1 = 33, $w2 = 33, $w3 = 34, $w4 = 0, $logic = 0, $required = 0, $instructions = '' ) {

	$name = ( $name ? $name . '-' : '');
	$fields = scm_acf_preset_instructions( $instructions, $name, __( 'Aggiungi Comportamenti', SCM_THEME ) );
	
	$fields[] = scm_acf_field( $name . 'alignment', array( 'select-alignment', array( 'default' => __( 'Allineamento generale', SCM_THEME ) ) ), '', $w3, $logic, $required );
	$fields[] = scm_acf_field_select( $name . 'float', 'float', $w2, $logic, $required );
	$fields[] = scm_acf_field_select( $name . 'overlay', 'overlay', $w3, $logic, $required );
	if( $w4 ) $fields[] = scm_acf_field( $name . 'link', array( 'select-template_link', array( 'no' => __( 'Nessun Link', SCM_THEME ) ) ), '', $w4, $logic, $required );

	return $fields;
}


/**
* [GET] Preset size
*
* @param {string} name
* @param {int} default
* @param {string} pl1
* @param {string} pl2
* @param {string} lb1
* @param {int} width
* @param {array} logic
* @param {bool} required
* @param {string} instructions
* @return {array} Fields.
*/
function scm_acf_preset_size( $name = 'size', $default = '', $pl1 = 'auto', $pl2 = 'px', $lb1 = '', $width = 100, $logic = 0, $required = 0, $instructions = '' ) {
	$lb1 = ( $lb1 ?: __( 'Dimensione', SCM_THEME ) );

	$name = ( $name ? $name . '-' : '');
	$fields = scm_acf_preset_instructions( $instructions, ( $name ?: 'size' ), __( 'Impostazioni Dimensioni', SCM_THEME ) );

	$fields[] = scm_acf_field_number( $name . 'number', array( 'default'=>$default, 'placeholder'=>$pl1, 'prepend'=>$lb1 ), $width*.5, $logic, $required );
	//$fields[] = scm_acf_field_positive( $name . 'number', array( 'default'=>$default, 'placeholder'=>$pl1, 'prepend'=>$lb1 ), $width*.5, $logic, $required );
	$fields[] = scm_acf_field_select( $name . 'units', array( 'type'=>'units', 'default'=>$pl2 ), $width*.5, $logic, $required );

	return $fields;
}

/**
* [GET] Preset rgba
*
* @param {string} name
* @param {string} pl1
* @param {string} pl2
* @param {int} width
* @param {array} logic
* @param {string} lb2
* @param {string} lb1
* @param {bool} required
* @param {string} instructions
* @return {array} Fields.
*/
function scm_acf_preset_rgba( $name = '', $pl1 = '', $pl2 = 1, $width = 100, $logic = 0, $lb2 = '', $lb1 = '', $lb3 = '', $required = 0, $instructions = '' ) {

	$default = array();
	if( is_array( $pl1 ) ){
		$default = copyArray( $pl1 );
		$pl1 = '';
	}
	
	$preset = array(
		'library' => array(
			'label' => ( $lb3 ?: __( 'Libreria', SCM_THEME ) ),
		),
		'color' => array(
			'label'=> ( $lb1 ?: __( 'Colore', SCM_THEME ) ),
			'default' => $pl1,
		),
		'alpha' => array(
			'label'=> ( $lb2 ?: __( 'Trasparenza', SCM_THEME ) ),
			'default' => $pl2,
		),
		'width' => $width,
		'logic' => $logic,
		'required' => $required,
		'instructions' => $instructions,
	);

	$preset = array_merge( $preset, $default );

	$name = ( $name ? $name . '-rgba' : 'rgba');
	$fields = scm_acf_preset_instructions( $preset['instructions'], $name, __( 'Imposta RGBA', SCM_THEME ) );	

	$multi = .5;
	if( $preset['library'] ){
		$multi = .33;
		$fields[] = scm_acf_field_select( $name . '-library', 'colors_library', $preset['width']*$multi, $preset['logic'], $preset['required'], $preset['library']['label'] );
	}

	if( $preset['color'] )
		$fields[] = scm_acf_field_color( $name . '-color', $preset['color'], $preset['width']*$multi, $preset['logic'], $preset['required'] );
	if( $preset['alpha'] )
		$fields[] = scm_acf_field_alpha( $name . '-alpha', $preset['alpha'], $preset['width']*$multi, $preset['logic'], $preset['required'] );

	return $fields;
}

/**
* [GET] Preset background style
*
* @param {string} name
* @param {int} width
* @param {array} logic
* @param {string} pl1
* @param {string} pl2
* @param {bool} required
* @param {string} instructions
* @return {array} Fields.
*/
function scm_acf_preset_background_style( $name = '', $width = 100, $logic = 0, $pl1 = 'center center', $pl2 = 'auto auto', $required = 0, $instructions = '' ) {
	
	$name = ( $name ? $name . '-style-bg' : 'style-bg');
	$fields = scm_acf_preset_instructions( $instructions, $name, __( 'Impostazioni Sfondo', SCM_THEME ) );
	

	$fields = array_merge( $fields, scm_acf_preset_rgba( $name, '', 1, $width, $logic ) );
	$fields[] = scm_acf_field_image_url( $name . '-image', array('label'=>__( 'Immagine', SCM_THEME )), $width, $logic );
	$fields[] = scm_acf_field_select( $name . '-repeat', 'bg_repeat', $width, $logic, $required, __( 'Ripetizione', SCM_THEME ) );
	$fields[] = scm_acf_field_text( $name . '-position', array( 'default'=>$pl1, 'prepend'=>__( 'Posizione', SCM_THEME ) ), $width, $logic, $required );
	$fields[] = scm_acf_field_text( $name . '-size', array( 'default'=>$pl2, 'prepend'=>__( 'Dimensione', SCM_THEME ) ), $width, $logic, $required );

	return $fields;
}

/**
* [GET] Preset text font
*
* @param {string} name
* @param {array} logic
* @param {int} width
* @param {bool} required
* @param {string} instructions
* @return {array} Fields.
*/
function scm_acf_preset_text_font( $name = '', $logic = 0, $width = 100, $required = 0, $instructions = '' ) {
	
	$name = ( $name ? $name . '-webfonts' : 'webfonts');
	$fields = scm_acf_preset_instructions( $instructions, $name, __( 'Impostazioni Font', SCM_THEME ) );

	$fields[] = scm_acf_field_select( $name . '-adobe', 'webfonts_adobe', $width*.33, $logic, $required, 'Adobe TypeKit' );
	$fields[] = scm_acf_field_select( $name . '-google', 'webfonts_google', $width*.33, $logic, $required, 'Google Font' );
	$fields[] = scm_acf_field_select( $name . '-fallback', 'webfonts_fallback', $width*.33, $logic, $required, __( 'Famiglia', SCM_THEME ) );

	return $fields;
}

/**
* [GET] Preset text set
*
* @param {string} name
* @param {int} w1
* @param {int} w2
* @param {int} w3
* @param {int} w4
* @param {array} logic
* @param {bool} required
* @param {string} instructions
* @return {array} Fields.
*/
function scm_acf_preset_text_set( $name = '', $w1 = 100, $w2 = 100, $w3 = 100, $w4 = 100, $logic = 0, $required = 0, $instructions = '' ) {
	
	$name = ( $name ? $name . '-set' : 'set');
	$fields = scm_acf_preset_instructions( $instructions, $name, __( 'Impostazioni Font', SCM_THEME ) );

	$fields[] = scm_acf_field_select( $name . '-alignment', 'txt_alignment', $w1, $logic, $required, __( 'Allineamento', SCM_THEME ) );
	$fields[] = scm_acf_field_select( $name . '-weight', 'font_weight', $w2, $logic, $required, __( 'Spessore', SCM_THEME ) );
	$fields[] = scm_acf_field_select( $name . '-size', 'txt_size', $w3, $logic, $required, __( 'Dimensione', SCM_THEME ) );
	$fields[] = scm_acf_field_select( $name . '-line-height', 'line_height', $w4, $logic, $required, __( 'Interlinea', SCM_THEME ) );

	return $fields;
}

/**
* [GET] Preset text shadow
*
* @param {string} name
* @param {array} logic
* @param {bool} required
* @param {string} instructions
* @return {array} Fields.
*/
function scm_acf_preset_text_shadow( $name = '', $logic = 0, $required = 0, $instructions = '' ) {

	$name = ( $name ? $name . '-shadow' : 'shadow');
	$fields = scm_acf_preset_instructions( $instructions, $name, __( 'Impostazioni Ombra Testi', SCM_THEME ) );

	$fields = array_merge( $fields, scm_acf_preset_size( $name . '-x', 1, '1', 'px', 'X', 33, $logic, $required ) );
	$fields = array_merge( $fields, scm_acf_preset_size( $name . '-y', 1, '1', 'px', 'Y', 33, $logic, $required ) );
	$fields = array_merge( $fields, scm_acf_preset_size( $name . '-size', 1, '1', 'px', __( 'Dimensione', SCM_THEME ), 33, $logic, $required ) );
	$fields = array_merge( $fields, scm_acf_preset_rgba( $name, '#000000', .5, 100, $logic, '', '', '', $required ) );

	return $fields;
}

/**
* [GET] Preset text style
*
* @param {string} name
* @param {array} logic
* @param {bool} required
* @param {string} instructions
* @return {array} Fields.
*/
function scm_acf_preset_text_style( $name = '', $logic = 0, $required = 0, $instructions = '' ) {

	$name = ( $name ? $name . '-style-txt' : 'style-txt');
	$fields = scm_acf_preset_instructions( $instructions, $name, __( 'Impostazioni Stile Testi', SCM_THEME ) );

	$fields = array_merge( $fields, scm_acf_preset_rgba( $name ) );
	$fields = array_merge( $fields, scm_acf_preset_text_font( $name ) );
	$fields = array_merge( $fields, scm_acf_preset_text_set( $name ) );

	// conditional ombra
	$fields[] = scm_acf_field_false( $name . '-shadow', 0, 100, 0, 0, __( 'Attiva Ombra', SCM_THEME ) );
	$condition = array(
		'field' => $name . '-shadow',
		'operator' => '==',
		'value' => 1,
	);
		
		$fields = array_merge( $fields, scm_acf_preset_text_shadow( $name, $condition ) );

	return $fields;
}

/**
* [GET] Preset box shape
*
* @param {string} name
* @param {int} width
* @param {array} logic
* @param {bool} required
* @param {string} instructions
* @return {array} Fields.
*/
function scm_acf_preset_box_shape( $name = '', $width = 100, $logic = 0, $required = 0, $instructions = '' ) {

	$name = ( $name ? $name . '-shape' : 'shape');
	$fields = scm_acf_preset_instructions( $instructions, $name, __( 'Impostazioni Box', SCM_THEME ) );

	$fields[] = scm_acf_field_select( $name, 'box_shape-no', $width, $logic, $required, __( 'Forma Box', SCM_THEME ) );
		
		$shape = array( $logic, array( 'field' => $name, 'operator' => '!=', 'value' => 'no' ) );
		$rounded = scm_acf_merge_conditions( $logic, $shape, array( 'field' => $name, 'operator' => '!=', 'value' => 'square' ) );

			$fields[] = scm_acf_field_select( $name . '-angle', 'box_angle_type', $width * .5, $rounded, 0, __( 'Angoli Box', SCM_THEME ) );
			$fields[] = scm_acf_field_select( $name . '-size', 'simple_size', $width * .5, $rounded, 0, __( 'Dimensione angoli Box', SCM_THEME ) );
	
	return $fields;

}

/**
* [GET] Preset box style
*
* @param {string} name
* @param {int} width
* @param {array} logic
* @param {bool} required
* @param {string} instructions
* @return {array} Fields.
*/
function scm_acf_preset_box_style( $name = '', $width = 100, $logic = 0, $required = 0, $instructions = '' ) {

	$name = ( $name ? $name . '-style-box' : 'style-box');
	$fields = scm_acf_preset_instructions( $instructions, $name, __( 'Impostazioni Box', SCM_THEME ) );

	$fields[] = scm_acf_field_text( $name . '-margin', array( 'placeholder'=>'0 0 0 0', 'prepend'=>__( 'Margin', SCM_THEME ) ), $width, $logic, $required );
	$fields[] = scm_acf_field_text( $name . '-padding', array( 'placeholder'=>'0 0 0 0', 'prepend'=>__( 'Padding', SCM_THEME ) ), $width, $logic, $required );
	$fields[] = scm_acf_field_alpha( $name . '-alpha', array( 'default'=>1, 'prepend'=>__( 'Trasparenza', SCM_THEME ) ), $width, $logic );
	$fields = array_merge( $fields, scm_acf_preset_box_shape( $name ) );

	return $fields;

}

/**
* [GET] Preset map icon
*
* @param {string} name
* @param {int} width
* @param {array} logic
* @param {bool} required
* @param {string} instructions
* @return {array} Fields.
*/
function scm_acf_preset_map_icon( $name = '', $width = 100, $logic = 0, $required = 0, $instructions = '' ) {
	
	$name = ( $name ? $name . '-map' : 'map');
	$fields = scm_acf_preset_instructions( $instructions, $name, __( 'Impostazioni Icona Mappa', SCM_THEME ) );

	$fields[] = scm_acf_field_select( $name . '-icon', array( 
		'type'=>'luogo-mappa',
		'choices'=>array( 'no' => __( 'No icon', SCM_THEME ), 'icon' => __( 'Icona', SCM_THEME ), 'img' => __( 'Immagine', SCM_THEME ) ),
	), $width, $logic );

	$icon = array( 'field' => $name . '-icon', 'operator' => '==', 'value' => 'icon' );
	$icon = ( $logic ? scm_acf_merge_conditions( $icon, $logic ) : $icon );
	$img = array( 'field' => $name . '-icon', 'operator' => '==', 'value' => 'img' );
	$img = ( $logic ? scm_acf_merge_conditions( $img, $logic ) : $img );
		
		$fields[] = scm_acf_field_icon( $name . '-icon-fa', array('default'=>'map-marker'), 100, $icon );
		$fields = array_merge( $fields, scm_acf_preset_rgba( $name, '#e3695f', 1, 100, $icon ) );
		$fields[] = scm_acf_field_image_url( $name . '-icon-img', array('label'=>__( 'Carica un\'immagine', SCM_THEME )), 100, $img );

	return $fields;

}

/**
* [GET] Preset term
*
* @param {string} name
* @param tax = 'category'
* @param {string} placeholder
* @param {array} logic
* @param {bool} add
* @param {bool} save
* @param {int} w1
* @param {string} lb1
* @param {string} instructions
* @param {bool} required
* @param {string} class
* @return {array} Fields.
*/
function scm_acf_preset_term( $name = 'term', $tax = 'category', $placeholder = '', $logic = 0, $add = 0, $save = 0, $w1 = '', $lb1 = '', $instructions = '', $required = 0, $class = '' ) {
	$placeholder = ( $placeholder ?: __( 'Termine', SCM_THEME ) );
	$lb1 = ( $lb1 ?: __( 'Seleziona', SCM_THEME ) );
	
	$fields = array();

	if( $instructions )
		$fields[] = scm_acf_field( 'msg-open-' . $name, array( 'message', $instructions ), $placeholder );

	$name = ( $name ? $name . '-' : '');

	$fields[] = scm_acf_field_taxonomy( $name . 'terms', array( 
		'type'=>'id',
		'taxes'=>$tax,
		'label'=>$lb1 . ' ' . $placeholder,
		'add'=>$add,
		'save'=>$save,
		'instructions'=>$instructions,
		'class'=>$class,
	), $w1, $logic, $required );

	return $fields;
}

/**
* [GET] Preset terms
*
* @param {string} name
* @param tax = 'category'
* @param {string} placeholder
* @param {array} logic
* @param {bool} add
* @param {bool} save
* @param {int} w1
* @param {string} lb1
* @param {string} instructions
* @param {bool} required
* @param {string} class
* @return {array} Fields.
*/
function scm_acf_preset_terms( $name = 'terms', $tax = 'category', $placeholder = '', $logic = 0, $add = 0, $save = 0, $w1 = '', $lb1 = '', $instructions = '', $required = 0, $class = '' ) {
	$placeholder = ( $placeholder ?: __( 'Termini', SCM_THEME ) );
	$lb1 = ( $lb1 ?: __( 'Seleziona', SCM_THEME ) );
	
	$fields = array();

	if( $instructions )
		$fields[] = scm_acf_field( 'msg-open-' . $name, array( 'message', $instructions ), $placeholder );

	$name = ( $name ? $name . '-' : '');

	$fields[] = scm_acf_field_taxonomies( $name . 'terms', array( 
		'type'=>'id',
		'taxes'=>$tax,
		'label'=>$lb1 . ' ' . $placeholder,
		'add'=>$add,
		'save'=>$save,
		'instructions'=>$instructions,
		'class'=>$class,
	), $w1, $logic, $required );

	return $fields;
}

/**
* [GET] Preset taxonomy
*
* @param {string} name
* @param {string} type
* @param {array} logic
* @param {bool} add
* @param {bool} save
* @param {int} w1
* @param {string} lb1
* @param {string} instructions
* @param {string} placeholder
* @param {bool} required
* @param {string} class
* @return {array} Fields.
*/
function scm_acf_preset_taxonomy( $name = 'taxonomy', $type = 'post', $logic = 0, $add = 0, $save = 0, $w1 = '', $lb1 = '', $instructions = '', $placeholder = '', $required = 0, $class = '' ) {
	$placeholder = ( $placeholder ?: __( 'Seleziona Relazione', SCM_THEME ) );
	$lb1 = ( $lb1 ?: __( 'Seleziona', SCM_THEME ) );

	$fields = array();

	if( $instructions )
		$fields[] = scm_acf_field( 'msg-open-' . $name, array( 'message', $instructions ), $placeholder );

	$name = ( $name ? $name . '-' : '');

	$taxes = get_object_taxonomies( $type, 'objects' );
	reset( $taxes );
	foreach ($taxes as $key => $value) {
		if( $key != 'language' && $key != 'post_translations' )
			$fields = array_merge( $fields, scm_acf_preset_term( $name . $value->name, $value->name, $value->labels->singular_name, $logic, $add, $save, $w1, $lb1, '', $required, $class ) );
	}

	return $fields;
}

/**
* [GET] Preset taxonomies
*
* @param {string} name
* @param {string} type
* @param {array} logic
* @param {bool} add
* @param {bool} save
* @param {int} w1
* @param {string} lb1
* @param {string} instructions
* @param {string} placeholder
* @param {bool} required
* @param {string} class
* @return {array} Fields.
*/
function scm_acf_preset_taxonomies( $name = 'taxonomies', $type = 'post', $logic = 0, $add = 0, $save = 0, $w1 = '', $lb1 = '', $instructions = '', $placeholder = '', $required = 0, $class = '' ) {
	$placeholder = ( $placeholder ?: __( 'Seleziona Relazioni', SCM_THEME ) );
	$lb1 = ( $lb1 ?: __( 'Seleziona', SCM_THEME ) );

	$fields = array();

	if( $instructions )
		$fields[] = scm_acf_field( 'msg-open-' . $name, array( 'message', $instructions ), $placeholder );

	$taxes = get_object_taxonomies( $type, 'objects' );

	$name = ( $name ? $name . '-' : '');

	reset( $taxes );

	foreach ($taxes as $key => $value) {
		if( $key != 'language' && $key != 'post_translations' )
			$fields = array_merge( $fields, scm_acf_preset_terms( $name . $value->name, $value->name, $value->label, $logic, $add, $save, $w1, $lb1, '', $required, $class ) );
	}

	return $fields;
}

/**
* [GET] Preset category req
* 
* @param {string} name
* @param {string} type
* @param {bool} save
* @param {array} logic
* @param {int} w1
* @param {string} lb1
* @param {string} instructions
* @param {string} placeholder
* @param {bool} required
* @param {string} class
* @return {array} Fields.
*/
function scm_acf_preset_category_req( $name = 'category', $type = 'post', $save = 1, $logic = 0, $w1 = 100, $lb1 = '', $instructions = '', $placeholder = '', $required = 1, $class = '' ) {		
	$placeholder = ( $placeholder ?: __( 'Seleziona Tipologia', SCM_THEME ) );
	$lb1 = ( $lb1 ?: __( 'Seleziona', SCM_THEME ) );

	$fields = array();

	if( $instructions )
		$fields[] = scm_acf_field( 'msg-open-' . $name, array( 'message', $instructions ), $placeholder );

	$name = ( $name ? $name . '-' : '');

	$taxes = get_object_taxonomies( $type, 'objects' );
	reset( $taxes );
	foreach ($taxes as $key => $value) {
		if( $value->hierarchical && $key != 'language' && $key != 'post_translations' )
			$fields = array_merge( $fields, scm_acf_preset_term( $name . $value->name, $value->name, $value->labels->singular_name, $logic, 0, $save, $w1, $lb1, '', $required, $class ) );
	}

	return $fields;
}

/**
* [GET] Preset category
* 
* @param {string} name
* @param {string} type
* @param {bool} save
* @param {array} logic
* @param {int} w1
* @param {string} lb1
* @param {string} instructions
* @param {string} placeholder
* @param {bool} required
* @param {string} class
* @return {array} Fields.
*/
function scm_acf_preset_category( $name = 'category', $type = 'post', $save = 1, $logic = 0, $w1 = 100, $lb1 = '', $instructions = '', $placeholder = '', $required = 0, $class = '' ) {		
	$placeholder = ( $placeholder ?: __( 'Seleziona Tipologia', SCM_THEME ) );
	$lb1 = ( $lb1 ?: __( 'Seleziona', SCM_THEME ) );

	$fields = array();

	if( $instructions )
		$fields[] = scm_acf_field( 'msg-open-' . $name, array( 'message', $instructions ), $placeholder );

	$name = ( $name ? $name . '-' : '');

	$taxes = get_object_taxonomies( $type, 'objects' );
	reset( $taxes );
	foreach ($taxes as $key => $value) {
		if( $value->hierarchical && $key != 'language' && $key != 'post_translations' )
			$fields = array_merge( $fields, scm_acf_preset_term( $name . $value->name, $value->name, $value->labels->singular_name, $logic, 0, $save, $w1, $lb1, '', $required, $class ) );
	}

	return $fields;
}

/**
* [GET] Preset categories
*
* @param {string} name
* @param {string} type
* @param {bool} save
* @param {array} logic
* @param {int} w1
* @param {string} lb1
* @param {string} instructions
* @param {string} placeholder
* @param {bool} required
* @param {string} class
* @return {array} Fields.
*/
function scm_acf_preset_categories( $name = 'categories', $type = 'post', $save = 1, $logic = 0, $w1 = 100, $lb1 = '', $instructions = '', $placeholder = '', $required = 0, $class = '' ) {
	$placeholder = ( $placeholder ?: __( 'Seleziona Tipologie', SCM_THEME ) );
	$lb1 = ( $lb1 ?: __( 'Seleziona', SCM_THEME ) );

	$fields = array();

	if( $instructions )
		$fields[] = scm_acf_field( 'msg-open-' . $name, array( 'message', $instructions ), $placeholder );

	$name = ( $name ? $name . '-' : '');

	$taxes = get_object_taxonomies( $type, 'objects' );
	reset( $taxes );
	foreach ($taxes as $key => $value) {
		if( $value->hierarchical && $key != 'language' && $key != 'post_translations' )
			$fields = array_merge( $fields, scm_acf_preset_terms( $name . $value->name, $value->name, $value->label, $logic, 0, $save, $w1, $lb1, '', $required, $class ) );
	}

	return $fields;
}

/**
* [GET] Preset tag
*
* @param {string} name
* @param {string} type
* @param {bool} save
* @param {array} logic
* @param {int} w1
* @param {string} lb1
* @param {string} instructions
* @param {string} placeholder
* @param {bool} required
* @param {string} class
* @return {array} Fields.
*/
function scm_acf_preset_tag( $name = 'tag', $type = 'post_tag', $save = 1, $logic = 0, $w1 = '', $lb1 = '', $instructions = '', $placeholder = '', $required = 0, $class = '' ) {
	$placeholder = ( $placeholder ?: __( 'Seleziona Categoria', SCM_THEME ) );
	$lb1 = ( $lb1 ?: __( 'Seleziona', SCM_THEME ) );

	$fields = array();

	if( $instructions )
		$fields[] = scm_acf_field( 'msg-open-' . $name, array( 'message', $instructions ), $placeholder );

	$name = ( $name ? $name . '-' : '');

	$taxes = get_object_taxonomies( $type, 'objects' );
	reset( $taxes );
	foreach ($taxes as $key => $value) {
		if( !$value->hierarchical && $key != 'language' && $key != 'post_translations' )
			$fields = array_merge( $fields, scm_acf_preset_term( $name . $value->name, $value->name, $value->labels->singular_name, $logic, 0, $save, $w1, $lb1, '', $required, $class ) );
	}

	return $fields;
}

/**
* [GET] Preset tags
*
* @param {string} name
* @param {string} type
* @param {bool} save
* @param {array} logic
* @param {int} w1
* @param {string} lb1
* @param {string} instructions
* @param {string} placeholder
* @param {bool} required
* @param {string} class
* @return {array} Fields.
*/
function scm_acf_preset_tags( $name = 'tags', $type = 'post_tag', $save = 1, $logic = 0, $w1 = '', $lb1 = '', $instructions = '', $placeholder = '', $required = 0, $class = '' ) {
	$placeholder = ( $placeholder ?: __( 'Seleziona Categorie', SCM_THEME ) );
	$lb1 = ( $lb1 ?: __( 'Seleziona', SCM_THEME ) );

	$fields = array();

	if( $instructions )
		$fields[] = scm_acf_field( 'msg-open-' . $name, array( 'message', $instructions ), $placeholder );
	
	$name = ( $name ? $name . '-' : '');

	$taxes = get_object_taxonomies( $type, 'objects' );
	reset( $taxes );
	foreach ($taxes as $key => $value) {
		if( !$value->hierarchical && $key != 'language' && $key != 'post_translations' )
			$fields = array_merge( $fields, scm_acf_preset_terms( $name . $value->name, $value->name, $value->label, $logic, 1, $save, $w1, $lb1, '', $required, $class ) );
	}

	return $fields;
}

/**
* [GET] Preset repeater columns
*
* @param {string} name
* @param {array} elements
* @param {array} logic
* @param {bool} required
* @param {string} instructions
* @param {string} class
* @return {array} Fields.
*/
function scm_acf_preset_repeater_columns( $name = '', $elements = '', $logic = 0, $required = 0, $instructions = '', $class = 'special-repeater' ) {

	$name = ( $name ? $name . '-columns' : 'columns');
	$fields = scm_acf_preset_instructions( $instructions, $name, __( 'Impostazioni Colonne', SCM_THEME ) );
	
	$columns = scm_acf_field_repeater( $name, array( 
		'button'=>__( 'Aggiungi Colonna', SCM_THEME ),
		'label'=>'', 
		'class'=>$class,
	), 100, $logic, $required );

		$columns['sub_fields'] = array_merge( $columns['sub_fields'], scm_acf_preset_advanced_options( '', 'simple' ) );

		//$columns['sub_fields'][] = scm_acf_preset_column_width( '', 20 );
		//$columns['sub_fields'] = array_merge( $columns['sub_fields'], scm_acf_preset_selectors( '', 10, 15, 45 ) );
		$columns['sub_fields'] = array_merge( $columns['sub_fields'], scm_acf_preset_flexible_elements( '', $elements ) );
		
	$fields[] = $columns;
	
	return $fields;
}

/**
* [GET] Preset button
*
* @param {string} name
* @param {string} type
* @param {string} icon
* @param {string} group
* @param {int} options
* @param {string} label
* @param {int} width
* @param {array} logic
* @param {bool} required
* @return {array} Fields.
*/
function scm_acf_preset_button( $name = '', $type = 'link', $icon = '', $group = '', $options = 0, $label = '', $width = 100, $logic = 0, $required = 0 ) {
				
	$fields = array();
	$name = ( $name ? $name . '-' : '');

	if( $options >= -1 ){
		
		$fields[] = scm_acf_field_name( 'name', array( 'placeholder'=>( $label ?: __( 'senza nome', SCM_THEME ) ) ), 25 );
		
		if( $options >= 0 ){
			$fields[] = scm_acf_field_icon_no( $name . 'icon', array('default'=>( $icon ?: 'no' ),'filter'=>$group), 20 );
		}

		if( $options === 2 )
			$width = 35;
		else
			$width = 55;
	}

	switch ( $type ) {
		case 'link':
			$fields[] = scm_acf_field_link( $name . 'link', 0, $width, $logic, $required );
		break;

		case 'email':
			$fields[] = scm_acf_field_email( $name . 'link', 0, $width, $logic, $required );
		break;

		case 'phone':
			$fields[] = scm_acf_field_phone( $name . 'link', 0, $width, $logic, $required );
		break;

		case 'user':
			$fields[] = scm_acf_field_user( $name . 'link', 0, $width, $logic, $required );
		break;
		
		case 'file':
			$fields[] = scm_acf_field_file_url( $name . 'link', array('label'=> __( 'File', SCM_THEME )), $width );
		break;

		case 'page':
			$fields[] = scm_acf_field_object( $name . 'link', array( 
                'type'=>'link', 
                'types'=>'page',
            ), $width );
		break;
		
		case 'media':
			$fields[] = scm_acf_field_object( $name . 'link', array( 
                'type'=>'id', 
                'types'=>array( 'rassegne-stampa', 'documenti', 'gallerie', 'video' ),
            ), $width );
		break;

		case 'paypal':
			$fields[] = scm_acf_field_text( $name . 'link', array( 'placeholder'=>__( 'Codice PayPal', SCM_THEME ), 'prepend'=>__( 'Code', SCM_THEME ) ), $width, $logic, $required );
		break;
		
		default:
			$fields[] = scm_acf_field_object( $name . 'link', array( 
                'type'=>'id', 
                'types'=>$type,
            ), $width );
		break;
	}
	
	if( $options === 1 )
		$fields[] = scm_acf_field_text( $name . 'tooltip', array( 'prepend'=>__( 'Tooltip', SCM_THEME ) ), 100, $logic, $required );
	else if( $options === 2 )
		$fields[] = scm_acf_field_false( $name . 'onmap', array('label'=>__( 'On Map', SCM_THEME )), 20 );

	return $fields;

}

/**
* [GET] Preset flexible buttons
*
* @param {string} name
* @param {string} group
* @param {string} label
* @param {array} logic
* @param {string} instructions
* @param {bool} required
* @param {string} class
* @return {array} Fields.
*/
function scm_acf_preset_flexible_buttons( $name = '', $group = '', $label = '', $logic = 0, $instructions = '', $required = 0, $class = 'buttons-flexible' ) {

	$fields = array();

	$choices = scm_acf_field_fa_preset( $group );

	if( !isset( $choices ) )
		return $fields;

	if( $instructions )
		$fields[] = scm_acf_field( 'msg-open-buttons' . ( $name ? '-' . $name : '' ), array( 'message', $instructions ), __( 'Istruzioni Pulsanti', SCM_THEME ) . ' ' . $label );

	$name = ( $name ? $name . '-' : '');

	$contacts = scm_acf_field_flexible( $name . 'buttons' , array( 
		//'label'=>__( 'Aggiungi Pulsante', SCM_THEME ),
		'button'=>'+',
		'class'=>$class,
	) );

		foreach ( $choices as $key => $value ) {

			if( $key == 'other' )
				continue;
			
			$layout = scm_acf_layout( $key, 'block', $value[ 'name' ] );

				$layout['sub_fields'] = scm_acf_preset_button( '', 'link', $key . '_' . $group, $key, 0, $value[ 'name' ], __( 'Link', SCM_THEME ) );

			$contacts['layouts'][] = $layout;
		}

	$fields[] = $contacts;

	return $fields;

}

/**
* [GET] Preset button shape
*
* @param {string} name
* @param {int} width
* @param {array} logic
* @param {bool} required
* @param {string} instructions
* @return {array} Fields.
*/
function scm_acf_preset_button_shape( $name = 'but-style', $width = 100, $logic = 0, $required = 0, $instructions = '' ) {

	$fields = array();

	$fields[] = scm_acf_field_select( $name . 'shape', 'box_shape-no', $width, $logic, $required, __( 'Forma Box', SCM_THEME ) );
		
		$shape = array( $logic, array( 'field' => $name . 'shape', 'operator' => '!=', 'value' => 'no' ) );
		$rounded = scm_acf_merge_conditions( $logic, $shape, array( 'field' => $name . 'shape', 'operator' => '!=', 'value' => 'square' ) );

			$fields[] = scm_acf_field_select( $name . 'shape-angle', 'box_angle_type', $width*.5, $rounded, $required, __( 'Angoli Box', SCM_THEME ) );
			$fields[] = scm_acf_field_select( $name . 'shape-size', 'simple_size', $width*.5, $rounded, $required, __( 'Dimensione angoli Box', SCM_THEME ) );

	return $fields;
	
}

/**
* [GET] Preset flexible sections
*
* @param {string} name
* @param {array} logic
* @param {string} instructions
* @param {bool} required
* @param {string} class
* @return {array} Fields.
*/
function scm_acf_preset_flexible_sections( $name = '', $logic = 0, $instructions = '', $required = 0, $class = 'rows-flexible' ) {

	global $SCM_types;

	$fields = array();

	if( $instructions )
		$fields[] = scm_acf_field( 'msg-open-sections' . ( $name ? '-' . $name : '' ), array( 'message', $instructions ), __( 'Istruzioni Righe', SCM_THEME ) );

	$name = ( $name ? $name . '-' : '');

	$sections = scm_acf_field_repeater( $name . 'sections', array( 
		'button'=>__( 'Aggiungi Sezione', SCM_THEME ),
		//'label'=>__( 'Sezioni', SCM_THEME ), 
		'class'=>$class,
	), 100, $logic, $required );

		$sections['sub_fields'] = array_merge( $sections['sub_fields'], scm_acf_preset_advanced_options( '', 'section' ) );
		//$sections['sub_fields'] = array_merge( $sections['sub_fields'], scm_acf_preset_selectors( '', 25, 25, 50 ) );

		$flexible = scm_acf_field_flexible( 'rows', array( 
			//'label'=>__( 'Moduli', SCM_THEME ),
			'button'=>'+',
		), 100 );

			$template = scm_acf_layout( 'template', 'block', __( 'Template', SCM_THEME ) );
				
				$template['sub_fields'] = array_merge( $template['sub_fields'], scm_acf_preset_advanced_options( '', 'row' ) );

				//$template['sub_fields'][] = scm_acf_field_select( 'layout', 'main_layout-default', 20 );
				//$template['sub_fields'] = array_merge( $template['sub_fields'], scm_acf_preset_selectors( '', 20, 20, 40 ) );
				$template['sub_fields'][] = scm_acf_field_text( 'archive', array( 'placeholder'=>'type[:field[=value]', 'prepend'=>__( 'Archivio', SCM_THEME ) ) );
				$template['sub_fields'][] = scm_acf_field_text( 'post', array( 'placeholder'=>__( 'ID or Option Name', SCM_THEME ), 'prepend'=>__( 'Post', SCM_THEME ) ) );
				$template['sub_fields'][] = scm_acf_field_positive( 'template', array( 'prepend'=>__( 'Template', SCM_THEME ) ) );

			$flexible['layouts'][] = $template;

			if( isset( $SCM_types['complete']['sections'] ) ){
				$row = scm_acf_layout( 'row', 'block', 'Section' );

					$row['sub_fields'] = array_merge( $row['sub_fields'], scm_acf_preset_advanced_options( '', 'row' ) );
					
					//$row['sub_fields'][] = scm_acf_field_select( 'layout', 'main_layout-default', 20 );
					//$row['sub_fields'] = array_merge( $row['sub_fields'], scm_acf_preset_selectors( '', 20, 20, 40 ) );
					$row['sub_fields'][] = scm_acf_field_object( 'row', array( 
		                'type'=>'id', 
		                'types'=>'sections',
		            ) );

		        $flexible['layouts'][] = $row;
			}

			if( isset( $SCM_types['complete']['modules'] ) ){
				$module = scm_acf_layout( 'module', 'block', 'Module' );

					$module['sub_fields'] = array_merge( $module['sub_fields'], scm_acf_preset_advanced_options( '', 'row' ) );

					//$module['sub_fields'][] = scm_acf_field_select( 'layout', 'main_layout-default', 20 );
					//$module['sub_fields'] = array_merge( $module['sub_fields'], scm_acf_preset_selectors( '', 20, 20, 40 ) );
					$module['sub_fields'][] = scm_acf_field_object( 'row', array( 
		                'type'=>'id', 
		                'types'=>'modules',
		            ) );

		        $flexible['layouts'][] = $module;
			}

			if( isset( $SCM_types['complete']['banners'] ) ){
				$banner = scm_acf_layout( 'banner', 'block', 'Banner' );

					$banner['sub_fields'] = array_merge( $banner['sub_fields'], scm_acf_preset_advanced_options( '', 'row' ) );

					//$banner['sub_fields'][] = scm_acf_field_select( 'layout', 'main_layout-default', 20 );
					//$banner['sub_fields'] = array_merge( $banner['sub_fields'], scm_acf_preset_selectors( '', 20, 20, 40 ) );
					$banner['sub_fields'][] = scm_acf_field_object( 'row', array( 
		                'type'=>'id', 
		                'types'=>'banners',
		            ) );

		        $flexible['layouts'][] = $banner;
			}

			//$flexible['layouts'] = array( $template, $row, $module, $banner );

		$sections['sub_fields'][] = $flexible;

	$fields[] = $sections;
	
	return $fields;
}

/**
* [GET] Preset flexible elements
*
* @see ACF/Fields/OBJECTS
*
* @param {string} name
* @param {array} elements
* @param {array} logic
* @param {string} instructions
* @param {bool} required
* @param {string} class
* @return {array} Fields.
*/
function scm_acf_preset_flexible_elements( $name = '', $elements = '', $logic = 0, $instructions = '', $required = 0, $class = 'elements-flexible' ) {

	global $SCM_types;

	$objects = array();
	$objects[] = array( 'scm_acf_object_slider', __( 'Slider', SCM_THEME ) );
    $objects[] = array( 'scm_acf_object_section', __( 'Section', SCM_THEME ) );
    $objects[] = array( 'scm_acf_object_module', __( 'Module', SCM_THEME ) );
    $objects[] = array( 'scm_acf_object_form', __( 'Form', SCM_THEME ) );
    $objects[] = array( 'scm_acf_object_indirizzo', __( 'Indirizzo', SCM_THEME ) );
    $objects[] = array( 'scm_acf_object_map', __( 'Map', SCM_THEME ) );
    $objects[] = array( 'scm_acf_object_separatore', __( 'Separatore', SCM_THEME ) );
    $objects[] = array( 'scm_acf_object_immagine', __( 'Immagine', SCM_THEME ) );
    $objects[] = array( 'scm_acf_object_icona', __( 'Icona', SCM_THEME ) );
    $objects[] = array( 'scm_acf_object_titolo', __( 'Titolo', SCM_THEME ) );
    $objects[] = array( 'scm_acf_object_quote', __( 'Quote', SCM_THEME ) );
    $objects[] = array( 'scm_acf_object_data', __( 'Data', SCM_THEME ) );
    $objects[] = array( 'scm_acf_object_testo', __( 'Testo', SCM_THEME ) );
    $objects[] = array( 'scm_acf_object_elenco_puntato', __( 'Elenco puntato', SCM_THEME ) );
    $objects[] = array( 'scm_acf_object_contatti', __( 'Contatti', SCM_THEME ) );
    $objects[] = array( 'scm_acf_object_social_follow', __( 'Social follow', SCM_THEME ) );
    $objects[] = array( 'scm_acf_object_social_share', __( 'Social share', SCM_THEME ) );
    $objects[] = array( 'scm_acf_object_pulsanti', __( 'Pulsanti', SCM_THEME ) );
    $objects[] = array( 'scm_acf_object_login', __( 'Login Form', SCM_THEME ) );

	$fields = array();

	if( $instructions )
		$fields[] = scm_acf_field( 'msg-open-modules' . ( $name ? '-' . $name : '' ), array( 'message', $instructions ), __( 'Istruzioni Elementi', SCM_THEME ) );

	$name = ( $name ? $name . '-' : '');

	$flexible = scm_acf_field_flexible( $name . 'modules', array( 
		'label'=>'',
		'button'=>'+',
		'class'=>$class
	), 100, $logic, $required );

		if( !$elements ){
			$elements = array();
			foreach ( $SCM_types['public'] as $slug => $value) {
				$elements[] = array( $slug, $value );
			}
			$elements = array_merge( $elements, $objects );
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
				$layout['sub_fields'] = array_merge( $layout['sub_fields'], call_user_func( $fun ) ); // Call objects function in scm-acf-objects.php
			else
				$layout['sub_fields'] = array_merge( $layout['sub_fields'], call_user_func( $fun, $key ) ); // Call objects function in scm-acf-objects.php
			
			$flexible['layouts'][] = $layout;
			
		}

		$flexible['layouts'] = scm_acf_layouts_advanced_options( $flexible['layouts'], 'nolink' );

	$fields[] = $flexible;
	
	return $fields;
}

?>