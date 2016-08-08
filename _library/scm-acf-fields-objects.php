<?php

/**
 * ACF all available Custom Fields Objects.
 *
 * @todo Trova un modo per poter eventualmente aggiungere un prefisso a tutti i nomi delle field
 *
 * @link http://www.studiocreativo-m.it
 *
 * @package SCM
 * @subpackage 2-ACF/Fields/OBJECT
 * @since 1.0.0
 */

// ------------------------------------------------------
//
// Objects
//		Elementi
//		Section
//		Separatore
//		Immagine
//		Icona
//		Titolo
//		Quote
//		Data
//		Testo
//		Elenco Puntato
//		Contatti
//		Social Follow
//		Pulsanti
//
// ------------------------------------------------------

// ------------------------------------------------------
// OBJECTS
// ------------------------------------------------------

/**
* [GET] Object POST
*
* @param {string} type
* @param {bool} obj
* @return {array} Fields.
*/
function scm_acf_object( $type = '', $obj = 0 ) {

	$fields = array();

	if( !$type )
		return $fields;
	
	if( !$obj )
		$fields[] = scm_acf_field_select( 'type', 'archive_mode', 100, 0, 0, __( 'Elementi', SCM_THEME ) );
	
		$fields[] = scm_acf_field_object( 'template', array( 
            'type'=>'id', 
            'types'=>$type . SCM_TEMPLATE_APP,
            'label'=>'Modello'
        ), 50 );
		$fields[] = scm_acf_field_select( 'width', array(
			'type'=>'columns_width',
			'choices'=>array( 'auto' => __( 'Larghezza', SCM_THEME ) ),
			'label'=>__( 'Larghezza Elementi', SCM_THEME ),
		), 50 );
	
	if( !$obj ){	
		$single = array( 'field' => 'type', 'operator' => '==', 'value' => 'single' );
		$archive = array( 'field' => 'type', 'operator' => '==', 'value' => 'archive' );
	}else{
		$single = 1;
		$archive = 0;
	}
			
	if( !$obj ){
		$fields[] = scm_acf_field_objects( 'single', array( 
            'type'=>'id', 
            'types'=>$type,
            'label'=>$type,
        ), 100, $single );
		$fields = array_merge( $fields, scm_acf_preset_taxonomies( 'archive', $type, $archive ) );
		$fields[] = scm_acf_field_text( 'archive-field', array( 'placeholder'=>__( 'field-name', SCM_THEME ), 'prepend'=>__( 'Field', SCM_THEME ) ), 50 );
		$fields[] = scm_acf_field_text( 'archive-value', array( 'placeholder'=>__( 'field-value (default = postID)', SCM_THEME ), 'prepend'=>__( 'Value', SCM_THEME ) ), 50 );
	
		// conditional
		$fields[] = scm_acf_field_select( 'archive-complete', 'archive_complete', 34, $archive, 0, __( 'Opzione', SCM_THEME ) );
		$fields[] = scm_acf_field_select( 'archive-orderby', 'orderby', 33, $archive, 0, __( 'Ordine per', SCM_THEME ) );
		$fields[] = scm_acf_field_select( 'archive-ordertype', 'ordertype', 33, $archive, 0, __( 'Ordine', SCM_THEME ) );

		$custom = array( 'field' => 'archive-orderby', 'operator' => '==', 'value' => 'meta_value' );
			$fields[] = scm_acf_field_text( 'archive-order', array( 'placeholder'=>__( 'field-name', SCM_THEME ), 'prepend'=>__( 'Field', SCM_THEME ) ), 100, $custom );

		$partial_cond = scm_acf_merge_conditions( array( 'field' => 'archive-complete', 'operator' => '==', 'value' => 'partial' ), $archive );

			$fields[] = scm_acf_field_positive( 'archive-perpage', array( 'default'=>5, 'prepend'=>__( 'Per pagina', SCM_THEME ), 'min'=>1 ), 33, $partial_cond );
			$fields[] = scm_acf_field_select( 'archive-pagination', 'archive_pagination', 33, $partial_cond );
			$fields[] = scm_acf_field_text( 'archive-pag-text', array( 'placeholder'=>'', 'prepend'=>__( 'Button', SCM_THEME ) ), 34, $partial_cond );
	}
		
	$fields[] = scm_acf_field_editor_basic( 'archive-fallback', array( 'default'=>__('No items available yet', SCM_THEME), 'label'=>__('Fallback Text', SCM_THEME) ), 100, $archive );
			
	return $fields;
}

/**
* [GET] Object SLIDER
*
* @param {misc} default
* @param {bool} obj
* @param {misc} opt
* @param {int} width
* @param {array} logic
* @param {bool} req
* @return {array} Fields.
*/
function scm_acf_object_slider( $default = '', $obj = 0, $opt = '', $width = 100, $logic = 0, $req = 0 ) {

	$fields = array();

	if( !$obj )
		$fields = scm_acf_preset_term( 'slider', 'sliders', __( 'Slider', SCM_THEME ), $logic, $width );

	return $fields;
}

/**
* [GET] Object SECTION
*
* @param {misc} default
* @param {bool} obj
* @param {misc} opt
* @param {int} width
* @param {array} logic
* @param {bool} req
* @return {array} Fields.
*/
function scm_acf_object_section( $default = '', $obj = 0, $opt = '', $width = 100, $logic = 0, $req = 0 ) {

	$fields = array();

	if( !$obj ){
		$fields[] = scm_acf_field_object( 'row', array( 
            'type'=>'id', 
            'types'=>'sections',
            'taxes'=>$opt,
            'label'=> __( 'Sezione', SCM_THEME ),
        ), $width, $logic );
	}

	return $fields;
}

/**
* [GET] Object MODULE
*
* @param {misc} default
* @param {bool} obj
* @param {misc} opt
* @param {int} width
* @param {array} logic
* @param {bool} req
* @return {array} Fields.
*/
function scm_acf_object_module( $default = '', $obj = 0, $opt = '', $width = 100, $logic = 0, $req = 0 ) {

	$fields = array();
	$fields[] = scm_acf_field_object( 'row', array( 
            'type'=>'id', 
            'types'=>'modules',
            'label'=>__( 'Modulo', SCM_THEME ),
        ), $width, $logic );

	return $fields;
}

/**
* [GET] Object LOGIN
*
* @param {misc} default
* @param {bool} obj
* @param {misc} opt
* @param {int} width
* @param {array} logic
* @param {bool} req
* @return {array} Fields.
*/
function scm_acf_object_login( $default = '', $obj = 0, $opt = '', $width = 100, $logic = 0, $req = 0 ) {

	$fields = array();
	
	$fields[] = scm_acf_field_select( 'login-type', array( 
		'type'=>'links_type', 
		'choices'=>array( 'admin' => __( 'Admin', SCM_THEME ) ), 
		'label'=>__( 'Redirect', SCM_THEME ),
	), 100 );

	$link = array( 'field' => 'login-type', 'operator' => '!=', 'value' => 'page' );
	$page = array( 'field' => 'login-type', 'operator' => '==', 'value' => 'page' );

	$fields[] = scm_acf_field_link( 'login-redirect', 0, 100, $link );
	$fields[] = scm_acf_field_object( 'login-redirect', array( 
        'type'=>'link', 
        'types'=>'page',
        'label'=>'',
    ), 100, $page );

	$fields[] = scm_acf_field_text( 'login-label-user', array( 'default'=>__( 'User', SCM_THEME ), 'prepend'=>__( 'User Label', SCM_THEME ) ), 50, 0 );
	$fields[] = scm_acf_field_text( 'login-value-user', array( 'placeholder'=>__( 'email@address.com', SCM_THEME ), 'prepend'=>__( 'Default User', SCM_THEME ) ), 50, 0 );

	$fields[] = scm_acf_field_text( 'login-label-password', array( 'default'=>__( 'Password', SCM_THEME ), 'prepend'=>__( 'Password Label', SCM_THEME ) ), 100, 0 );
	$fields[] = scm_acf_field_text( 'login-send', array( 'default'=>__( 'Log In', SCM_THEME ), 'prepend'=>__( 'Submit Button Label', SCM_THEME ) ), 100, 0 );

	$fields[] = scm_acf_field_false( 'login-remember', array( 'label'=>'Remember Me' ), 20 );
	$remember = array( 'field' => 'login-remember', 'operator' => '==', 'value' => 1 );
	$fields[] = scm_acf_field_text( 'login-label-remember', array( 'default'=>__( 'Remember me', SCM_THEME ), 'prepend'=>__( 'Remember Me Label', SCM_THEME ) ), 40, $remember );
	$fields[] = scm_acf_field_false( 'login-value-remember', array( 'label'=>'Default Remember Me' ), 40, $remember );

	$buttons = scm_acf_field_repeater( 'login-buttons', array( 'button'=>__( 'Aggiungi Pulsante', SCM_THEME ) ), 100 );
		$buttons['sub_fields'][] = scm_acf_field_select( 'type', array( 'choices'=>array( 'edit'=>__( 'Edit', SCM_THEME ), 'enter'=>__( 'Enter', SCM_THEME ), 'logout'=>__( 'Log Out', SCM_THEME ) ) ) );
		$buttons['sub_fields'][] = scm_acf_field_text( 'label', array( 'placeholder'=>__( 'Override default Label', SCM_THEME), 'prepend'=>__( 'Label', SCM_THEME ) ) );
		$buttons['sub_fields'][] = scm_acf_field_select( 'login', array( 
			'type'=>'links_type', 
			'choices'=>array( 'admin' => __( 'Admin', SCM_THEME ) ), 
			'label'=>__( 'Redirect', SCM_THEME ),
		), 100 );

		$lnk = array( 'field' => 'login', 'operator' => '!=', 'value' => 'page' );
		$pag = array( 'field' => 'login', 'operator' => '==', 'value' => 'page' );

		$buttons['sub_fields'][] = scm_acf_field_link( 'redirect', 0, 100, $lnk );
		$buttons['sub_fields'][] = scm_acf_field_object( 'redirect', array( 
	        'type'=>'link', 
	        'types'=>'page',
	        'label'=>'',
	    ), 100, $pag );

	$fields[] = $buttons;

	return $fields;
}

/**
* [GET] Object FORM
*
* @param {misc} default
* @param {bool} obj
* @param {misc} opt
* @param {int} width
* @param {array} logic
* @param {bool} req
* @return {array} Fields.
*/
function scm_acf_object_form( $default = '', $obj = 0, $opt = '', $width = 100, $logic = 0, $req = 0 ) {

	$fields = array();
	
	if( !$obj )
		$fields[] = scm_acf_field_object( 'form', array( 
            'type'=>'id', 
            'types'=>'wpcf7_contact_form',
            'label'=>__( 'Modulo Contatti', SCM_THEME ),
        ), $width, $logic );

	return $fields;
}

/**
* [GET] Object ADDRESS
*
* @param {misc} default
* @param {bool} obj
* @param {misc} opt
* @param {int} width
* @param {array} logic
* @param {bool} req
* @return {array} Fields.
*/
function scm_acf_object_indirizzo( $default = '', $obj = 0, $opt = '', $width = 100, $logic = 0, $req = 0 ) {

	$fields = array();

	if( !$obj )
		$fields[] = scm_acf_field_objects( 'element', array( 
            'type'=>'id', 
            'types'=>'luoghi',
            'label'=>__( 'Luoghi', SCM_THEME ),
        ), $width, $logic );

	$fields[] = scm_acf_field_text( 'separator', array( 'placeholder'=>'-', 'prepend'=>__( 'Separatore', SCM_THEME ) ), $width*.5, $logic, $req );
	$fields[] = scm_acf_field_false( 'googlemaps', 0, $width*.5, $logic, $req, __('Link to Google Maps', SCM_THEME) );

	$fields[] = scm_acf_field_select( 'icon', array( 
		'choices'=>array( 
			'no' => __( 'Nascondi icona', SCM_THEME ), 
			'inside' => __( 'Icona interna', SCM_THEME ), 
			'outside' => __( 'Icona esterna', SCM_THEME ),
		),
		'label'=>__( 'Icona Luogo', SCM_THEME ),
	), $width, $logic, $req );

	return $fields;
}

/**
* [GET] Object MAP
*
* @param {misc} default
* @param {bool} obj
* @param {misc} opt
* @param {int} width
* @param {array} logic
* @param {bool} req
* @return {array} Fields.
*/
function scm_acf_object_map( $default = '', $obj = 0, $opt = '', $width = 100, $logic = 0, $req = 0 ) {

	$fields = array();

	if( !$obj ){
		$fields[] = scm_acf_field_objects( 'element', array( 
            'type'=>'id', 
            'types'=>'luoghi',
            'label'=>__( 'Luoghi', SCM_THEME ),
        ), $width, $logic );
		$fields = array_merge( $fields, scm_acf_preset_taxonomies( '', 'luoghi' ) );
	}

	$fields[] = scm_acf_field_positive( 'zoom', array( 'default'=>10, 'prepend'=>__( 'Zoom', SCM_THEME ) ), $width, $logic );

	return $fields;
}

/**
* [GET] Object DIVIDER
*
* @param {misc} default
* @param {bool} obj
* @param {misc} opt
* @param {int} width
* @param {array} logic
* @param {bool} req
* @return {array} Fields.
*/
function scm_acf_object_separatore( $default = '', $obj = 0, $opt = '', $width = 100, $logic = 0, $req = 0 ) {

	$fields = array();

	// conditional
	$fields[] = scm_acf_field_select( 'line', 'line_style', $width, $logic, $req, __( 'Stile', SCM_THEME ) );

	if( !$opt ){

		$all = array( 'field' => 'line', 'operator' => '!=', 'value' => 'no' );
		$line = array( 'field' => 'line', 'operator' => '==', 'value' => 'line' );
		$dash = array( 'field' => 'line', 'operator' => '==', 'value' => 'dashed' );

		// +++ todo: aggiungere bg_image e tutte bg_cose

		$height = scm_acf_preset_size( 'height', 0, '1', 'px', __( 'Altezza', SCM_THEME ), $width );
		$position = scm_acf_preset_size( 'position', '', 50, '%', __( 'Posizione', SCM_THEME ), $width, $dash );
		$size = scm_acf_preset_size( 'size', 0, '4', 'px', __( 'Spessore', SCM_THEME ), $width, $all );
		$space = scm_acf_preset_size( 'space', 0, '26', 'px', __( 'Spazio', SCM_THEME ), $width, $dash );
		//$space_dot = scm_acf_preset_size( 'space', 0, '26', 'px', 'Spazio', $width, $allt );
		$weight = scm_acf_preset_size( 'dash', 0, '8', 'px', __( 'Tratto', SCM_THEME ), $width, $dash );
		$cap = array( scm_acf_field_select( 'cap', 'line_cap', $width, $all, 0, __( 'Cap', SCM_THEME ) ) );
		$color = scm_acf_preset_rgba( 'color', '', 1, $width, $all );
			
		$fields = array_merge( $fields, $height, $position, $cap, $size, $space, $weight, $color );

	}

	return $fields;
}

/**
* [GET] Object IMAGE
*
* @param {misc} default
* @param {bool} obj
* @param {misc} opt
* @param {int} width
* @param {array} logic
* @param {bool} req
* @return {array} Fields.
*/
function scm_acf_object_immagine( $default = '', $obj = 0, $opt = '', $width = 100, $logic = 0, $req = 0 ) {

	$fields = array();

	// conditional
	$fields[] = scm_acf_field_select( 'format', 'image_format', $width, $logic, $req, __( 'Seleziona Formato', SCM_THEME ) );
	$norm = array( $logic, array( 'field' => 'format', 'operator' => '==', 'value' => 'norm' ) );
	$quad = array( $logic, array( 'field' => 'format', 'operator' => '==', 'value' => 'quad' ) );
	$full = array( $logic, array( 'field' => 'format', 'operator' => '==', 'value' => 'full' ) );

		$imagew = scm_acf_preset_size( 'width', '', 'auto', '%', __( 'Larghezza', SCM_THEME ), $width, $norm );
		$imageh = scm_acf_preset_size( 'height', '', 'auto', '%', __( 'Altezza', SCM_THEME ), $width, $norm );
		$imagef = scm_acf_preset_size( 'full', '', 'auto', 'px', __( 'Altezza', SCM_THEME ), $width, $full );
		$imageq = scm_acf_preset_size( 'size', '', 'auto', 'px', __( 'Dimensione', SCM_THEME ), $width, $quad );

		$fields = array_merge( $fields, $imagew, $imageh, $imagef, $imageq );
	
	if( !$obj )
		$fields[] = scm_acf_field_image_url( 'image', 0, $width, $logic );
	
	return $fields;
}

/**
* [GET] Object ICON
*
* @param {misc} default
* @param {bool} obj
* @param {misc} opt
* @param {int} width
* @param {array} logic
* @param {bool} req
* @return {array} Fields.
*/
function scm_acf_object_icona( $default = '', $obj = 0, $opt = '', $width = 100, $logic = 0, $req = 0 ) {

	$fields = array();

	$fields[] = scm_acf_field_icon( 'icon', $default );

	if( !$opt )
		$fields = array_merge( $fields, scm_acf_preset_size( 'size', 1, '1', 'em', __( 'Dimensione', SCM_THEME ), $width, $logic ) );

	return $fields;
}

/**
* [GET] Object TITLE
*
* @param {misc} default
* @param {bool} obj
* @param {misc} opt
* @param {int} width
* @param {array} logic
* @param {bool} req
* @return {array} Fields.
*/
function scm_acf_object_titolo( $default = 0, $obj = 0, $opt = '', $width = 100, $logic = 0, $req = 0 ) { // $opt = 1 || low, -1 || min, 2 || max

	$fields = array();

	if ( !$obj )
		$fields[] = scm_acf_field_textarea( 'title', $default, $width, $logic, $req );

	if( !is_string( $opt ) ){
		switch( $opt ) {
			case 1: $opt = '_low'; break;
			case -1: $opt = '_min'; break;
			case 2: $opt = '_max'; break;
			default: $opt = ''; break;
		}
	}elseif( $opt ){
		$opt = '_' . $opt;
	}

	$fields[] = scm_acf_field_select( 'tag', 'headings' . $opt, $width, $logic );

	return $fields;
}

/**
* [GET] Object QUOTE
*
* @param {misc} default
* @param {bool} obj
* @param {misc} opt
* @param {int} width
* @param {array} logic
* @param {bool} req
* @return {array} Fields.
*/
function scm_acf_object_quote( $default = '', $obj = 0, $opt = '', $width = 100, $logic = 0, $req = 0 ) {

	$fields = array();

	$fields[] = scm_acf_field_icon_no( 'prepend', array('default'=>'no_typography', 'filter'=>'quote', 'label'=>__( 'Apertura', SCM_THEME ) ), $width*.5, $logic );
	$fields[] = scm_acf_field_icon_no( 'append', array('default'=>'no_typography', 'filter'=>'quote', 'label'=>__( 'Chiusura', SCM_THEME ) ), $width*.5, $logic );

	if ( !$obj )
		$fields[] = scm_acf_field_textarea( 'title', 0, $width, $logic );

	return $fields;
}

/**
* [GET] Object DATE
*
* @param {misc} default
* @param {bool} obj
* @param {misc} opt
* @param {int} width
* @param {array} logic
* @param {bool} req
* @return {array} Fields.
*/
function scm_acf_object_data( $default = '', $obj = 0, $opt = '', $width = 100, $logic = 0, $req = 0 ) {

	$fields = array();

	if ( !$obj )
		$fields[] = scm_acf_field_date( 'date', 0, $width, $logic );

	$fields[] = scm_acf_field_select( 'format', 'date_format', $width/3, $logic );
	$fields[] = scm_acf_field_text( 'separator', array( 'default'=>$default, 'placeholder'=>'/', 'prepend'=>__( 'Separatore', SCM_THEME ) ), $width/3, $logic );

	if( !$opt )
		$fields[] = scm_acf_field_select( 'tag', 'headings_low', $width/3, $logic );

	return $fields;
}

/**
* [GET] Object TEXT
*
* @param {misc} default
* @param {bool} obj
* @param {misc} opt
* @param {int} width
* @param {array} logic
* @param {bool} req
* @return {array} Fields.
*/
function scm_acf_object_testo( $default = '', $obj = 0, $opt = '', $width = 100, $logic = 0, $req = 0 ) {

	$fields = array();

	if ( !$obj ){

		if( $opt === 1 )
			$fields[] = scm_acf_field_editor_media( 'editor', $default, $width, $logic );
		else if( $opt === 2 )
			$fields[] = scm_acf_field_editor_basic( 'editor', $default, $width, $logic );
		else
			$fields[] = scm_acf_field_editor( 'editor', $default, $width, $logic );

	}

	return $fields;
}

/**
* [GET] Object LIST
*
* @param {misc} default
* @param {bool} obj
* @param {misc} opt
* @param {int} width
* @param {array} logic
* @param {bool} req
* @return {array} Fields.
*/
function scm_acf_object_elenco_puntato( $default = '', $obj = 0, $opt = '', $width = 100, $logic = 0, $req = 0 ) {
	
	$fields = array();

	$fields[] = scm_acf_field_textarea( 'intro', array( 'rows'=>2, 'label'=>__( 'Introduzione:', SCM_THEME ) ), $width, $logic );

	if ( !$obj ){
		
		$links = scm_acf_field_repeater( 'list', array( 
			'button'=>__( 'Aggiungi Punto', SCM_THEME ),
			//'label'=>__( 'Punti', SCM_THEME ), 
			'min'=>1,
		), $width, $logic );

			$links['sub_fields'][] = scm_acf_field_editor_basic( 'name', array( 'placeholder'=>'inserisci testo' ), $width, $logic );
		$fields[] = $links;
	}

	$fields[] = scm_acf_field_select( 'type', 'list_type', $width*.5, $logic, $req, __( 'Punti elenco', SCM_THEME ) );
	$fields[] = scm_acf_field_select( 'position', array(
		'type'=>'list_position',
		'choices'=>array( 'outside' => __( 'Esterni', SCM_THEME ), 'inside' => __( 'Interni', SCM_THEME ) ),
		'label'=>__( 'Posizione punti', SCM_THEME ),
	), $width*.5, $logic, $req );

	$fields[] = scm_acf_field_select( 'size', 'simple_size', $width*.5, $logic, $req, __( 'Dimensione', SCM_THEME ) );
	$fields[] = scm_acf_field_select( 'display', array( 
		'choices'=>array( 'inline-block' => __( 'In fila', SCM_THEME ), 'block' => __( 'In colonna', SCM_THEME ) ),
		'label'=>__( 'Disposizione', SCM_THEME ), 
	), $width*.5, $logic, $req );

	if( !$opt )
		$fields = array_merge( $fields, scm_acf_preset_button_shape() );

	return $fields;
}

/**
* [GET] Object CONTATTI
*
* @param {misc} default
* @param {bool} obj
* @param {misc} opt
* @param {int} width
* @param {array} logic
* @param {bool} req
* @return {array} Fields.
*/
function scm_acf_object_contatti( $default = '', $obj = 0, $opt = '', $width = 100, $logic = 0, $req = 0 ) {

	$fields = array();

	$fields[] = scm_acf_field_textarea( 'intro', array( 'rows'=>2, 'label'=>__( 'Introduzione:', SCM_THEME ) ), $width, $logic );

	if( !$obj )
		$fields[] = scm_acf_field_object( 'element', array( 
            'type'=>'id', 
            'types'=>'luoghi',
            'label'=>__( 'Luogo', SCM_THEME ),
        ), $width, $logic );

	$fields[] = scm_acf_field_select( 'size', 'simple_size', $width*.5, $logic, $req, __( 'Dimensione', SCM_THEME ) );
	$fields[] = scm_acf_field_select( 'display', array(
		'choices'=>array( 'block' => __( 'In colonna', SCM_THEME ), 'inline-block' => __( 'In fila', SCM_THEME ) ),
		'label'=>__( 'Disposizione', SCM_THEME ),
	), $width*.5, $logic, $req );

	if( !$opt )
		$fields = array_merge( $fields, scm_acf_preset_button_shape( '', $width, $logic ) );

	return $fields;
}

/**
* [GET] Object SOCIAL SHARE
*
* @param {misc} default
* @param {bool} obj
* @param {misc} opt
* @param {int} width
* @param {array} logic
* @param {bool} req
* @return {array} Fields.
*/
function scm_acf_object_social_share( $default = '', $obj = 0, $opt = '', $width = 100, $logic = 0, $req = 0 ) {

	$fields = array();

	return $fields;
}

/**
* [GET] Object SOCIAL FOLLOW
*
* @param {misc} default
* @param {bool} obj
* @param {misc} opt
* @param {int} width
* @param {array} logic
* @param {bool} req
* @return {array} Fields.
*/
function scm_acf_object_social_follow( $default = '', $obj = 0, $opt = '', $width = 100, $logic = 0, $req = 0 ) {

	$fields = array();

	$fields[] = scm_acf_field_textarea( 'intro', array( 'rows'=>2, 'label'=>__( 'Introduzione:', SCM_THEME ) ), $width, $logic );

	if( !$obj )
		$fields[] = scm_acf_field_object( 'element', array( 
            'type'=>'id', 
            'types'=>'soggetti',
            'label'=>__( 'Soggetto', SCM_THEME ),
        ), $width, $logic );

	$fields[] = scm_acf_field_select( 'size', 'simple_size', $width*.5, $logic, $req, __( 'Dimensione', SCM_THEME ) );
	$fields[] = scm_acf_field_select( 'display', array(
		'choices'=>array( 'block' => __( 'In colonna', SCM_THEME ), 'inline-block' => __( 'In fila', SCM_THEME ) ),
		'label'=>__( 'Disposizione', SCM_THEME ),
	), $width*.5, $logic, $req );

	if( !$opt )
		$fields = array_merge( $fields, scm_acf_preset_button_shape( '', $width, $logic ) );

	return $fields;
}

/**
* [GET] Object BUTTONS
*
* @param {misc} default
* @param {bool} obj
* @param {misc} opt
* @param {int} width
* @param {array} logic
* @param {bool} req
* @return {array} Fields.
*/
function scm_acf_object_pulsanti( $default = '', $obj = 0, $opt = '', $width = 100, $logic = 0, $req = 0 ) {
	
	$fields = array();

	$fields[] = scm_acf_field_textarea( 'intro', array( 'rows'=>2, 'label'=>__( 'Introduzione:', SCM_THEME ) ), $width, $logic );

	if ( !$obj ){

		$flexible = scm_acf_field_flexible( 'list', array( 
			//'label'=>__( 'Aggiungi Pulsanti ', SCM_THEME ),
			'button'=>'+',
		), $width, $logic );

			$layout_link = scm_acf_layout( 'link', 'block', __( 'Link', SCM_THEME ) );
				$layout_link['sub_fields'] = scm_acf_preset_button( '', 'link', 'no' );

			$layout_page = scm_acf_layout( 'page', 'block', __( 'Pagina', SCM_THEME ) );
				$layout_page['sub_fields'] = scm_acf_preset_button( '', 'page', 'no' );

			$layout_media = scm_acf_layout( 'media', 'block', __( 'Media', SCM_THEME ) );
				$layout_media['sub_fields'] = scm_acf_preset_button( '', 'media', 'no' );

			$layout_file = scm_acf_layout( 'file', 'block', __( 'File', SCM_THEME ) );
				$layout_file['sub_fields'] = scm_acf_preset_button( '', 'file', 'no' );

			$layout_paypal = scm_acf_layout( 'paypal', 'block', __( 'PayPal', SCM_THEME ) );
				$layout_paypal['sub_fields'] = scm_acf_preset_button( '', 'paypal', 'no' );

		$flexible['layouts'] = array( $layout_link, $layout_page, $layout_media, $layout_file, $layout_paypal );

		$fields[] = $flexible;

	}
	
	$fields[] = scm_acf_field_icon_no( 'icon-even', array('default'=>'no', 'label'=>__( 'Icone pari', SCM_THEME )), $width*.5, $logic );
	$fields[] = scm_acf_field_icon_no( 'icon-odd', array('default'=>'no', 'label'=>__( 'Icone dispari', SCM_THEME )), $width*.5, $logic );
	$fields[] = scm_acf_field_select( 'size', 'simple_size', $width*.5, $logic, $req, __( 'Dimensione', SCM_THEME ) );
	$fields[] = scm_acf_field_select( 'display', array(
		'choices'=>array( 'block' => __( 'In colonna', SCM_THEME ), 'inline-block' => __( 'In fila', SCM_THEME ) ),
		'label'=>__( 'Disposizione', SCM_THEME ),
	), $width*.5, $logic, $req );

	if( !$opt )
		$fields = array_merge( $fields, scm_acf_preset_button_shape( '', $width, $logic ) );

	return $fields;
}

?>