<?php

/**
* ACF all available Custom Fields.
*
* @link http://www.studiocreativo-m.it
*
* @package SCM
* @subpackage 2-ACF/Fields/FIELD
* @since 1.0.0
*/

// ------------------------------------------------------
//
// 1.0 Helpers
// 2.0 Choices
//		2.1 Tab and Message
//		2.2 Number
//		2.3 Text
//		2.4 Limiter
//		2.5 Textarea
//		2.6 Editor
//		2.7 Date Time
//		2.8 Color
//		2.9 Icon
//		2.10 Image
//		2.11 File
//		2.12 True False
//		2.13 Select
//		2.14 Object
//		2.15 Taxonomy
//		2.16 Repeater
//		2.17 Flexible Content
//		2.18 Message
//
// ------------------------------------------------------

// ------------------------------------------------------
// 1.0 HELPERS
// ------------------------------------------------------

/**
* [GET] Main helper for building fields
*
* Use {@see scm_acf_helper_default()} and {@see scm_acf_helper_specific()} to filter arguments
*
* @param {misc} name
* @param {misc} field
* @param {misc} default
* @param {misc} width
* @param {misc} logic
* @param {misc} required
* @return {array} Field.
*/
function scm_acf_helper( $name = '', $field = 0, $default = 0, $width = 100, $logic = 0, $required = 0  ) {
	return scm_acf_field( scm_acf_helper_default( $name, $width, $logic, $required ), scm_acf_helper_specific( $field, $default ) );
}

/**
* [GET] General helper for building fields
*
* Used by {@see scm_acf_helper()}
*
* @param {misc} arg
* @param {misc} width
* @param {misc} logic
* @param {misc} required
* @return {array} General field attributes.
*/
function scm_acf_helper_default( $arg = '', $width = 100, $logic = 0, $required = 0  ) {

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

	if( is_arr( $arg ) ){
        $default = array_merge( $default, $arg );
    }else{
    	$default['name'] = $arg;
    	$default['width'] = $width;
    	$default['logic'] = $logic;
    	$default['required'] = $required;
    }

	return $default;
}

/**
* [GET] Specific helper for building fields
*
* Used by {@see scm_acf_helper()}
*
* @param {misc} field
* @return {array} Specific field attributes.
*/
function scm_acf_helper_specific( $field = 0, $arg = 0 ) {
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

// ------------------------------------------------------
// 2.0 CHOICES
// ------------------------------------------------------
// ------------------------------------------------------
// 2.1 TAB AND MESSAGE
// ------------------------------------------------------

/**
* [GET] TAB field builder
*
* Specific field attributes:
```php
'type' => 'tab'
'place' => 'top'
```
*
* @param {array|string=} name Field name or field general attributes (default is '').
* @param {array|string|0=} field Field specific attributes or field default attribute (default is 0).
* @param {int|0=} width Field width (default is 100).
* @param {array|0=} logic Field conditional logics (default is 0).
* @param {bool=} required Field conditional logics (default is false).
* @param {string=} label Field label (default is '').
* @return {array} Field.
*/
function scm_acf_field_tab( $name = '', $field = 0, $width = 100, $logic = 0, $required = 0, $label = '' ) {
	return scm_acf_helper( $name, $field, array('type' => 'tab','label' => $label), $width, $logic, $required );
}

/**
* [GET] TAB LEFT field builder
*
* Specific field attributes:
```php
'type' => 'tab-left'
'place' => 'left'
```
*
* @see scm_acf_field_tab()
*
* @param {array|string=} name Field name or field general attributes (default is '').
* @param {array|string|0=} field Field specific attributes or field default attribute (default is 0).
* @param {int|0=} width Field width (default is 100).
* @param {array|0=} logic Field conditional logics (default is 0).
* @param {bool=} required Field conditional logics (default is false).
* @param {string=} label Field label (default is '').
* @return {array} Field.
*/
function scm_acf_field_tab_left( $name = '', $field = 0, $width = 100, $logic = 0, $required = 0, $label = '' ) {
	return scm_acf_helper( $name, $field, array('type' => 'tab-left','label' => $label), $width, $logic, $required );
}

/**
* [GET] MESSAGE field builder
*
* Specific field attributes:
```php
'type' => 'message'
'message' => ''
'eschtml' => false
'lines' => '' [''|'br'|'wpautop']
```
*
* @param {array|string=} name Field name or field general attributes (default is '').
* @param {array|string|0=} field Field specific attributes or field default attribute (default is 0).
* @param {int|0=} width Field width (default is 100).
* @param {array|0=} logic Field conditional logics (default is 0).
* @param {bool=} required Field conditional logics (default is false).
* @param {string=} label Field label (default is '').
* @return {array} Field.
*/
function scm_acf_field_message( $name = '', $field = 0, $width = 100, $logic = 0, $required = 0, $label = '' ) {
	return scm_acf_helper( $name, $field, array('type' => 'message','label' => $label), $width, $logic, $required );
}

// ------------------------------------------------------
// 2.2 NUMBER
// ------------------------------------------------------

/**
* [GET] NUMBER field builder
*
* Specific field attributes:
```php
'type' => 'number'
'default' => ''
'placeholder' => ''
'prepend' => ''
'append' => ''
'min' => ''
'max' => ''
'step' => ''
'read' => false
'disabled' => false
```
*
* @param {array|string=} name Field name or field general attributes (default is '').
* @param {array|string|0=} field Field specific attributes or field default attribute (default is 0).
* @param {int|0=} width Field width (default is 100).
* @param {array|0=} logic Field conditional logics (default is 0).
* @param {bool=} required Field conditional logics (default is false).
* @param {string=} label Field label (default is '').
* @return {array} Field.
*/
function scm_acf_field_number( $name = '', $field = 0, $width = 100, $logic = 0, $required = 0, $label = '' ) {
	return scm_acf_helper( $name, $field, array('type' => 'number','label' => $label), $width, $logic, $required );
}

/**
* [GET] OPTION field builder
*
* Specific field attributes:
```php
'type' => 'option'
'min' => -1
```
*
* @see scm_acf_field_number()
*
* @param {array|string=} name Field name or field general attributes (default is '').
* @param {array|string|0=} field Field specific attributes or field default attribute (default is 0).
* @param {int|0=} width Field width (default is 100).
* @param {array|0=} logic Field conditional logics (default is 0).
* @param {bool=} required Field conditional logics (default is false).
* @param {string=} label Field label (default is '').
* @return {array} Field.
*/
function scm_acf_field_option( $name = '', $field = 0, $width = 100, $logic = 0, $required = 0, $label = '' ) {
	return scm_acf_helper( $name, $field, array('type' => 'option','label' => $label), $width, $logic, $required );
}

/**
* [GET] POSITIVE field builder
*
* Specific field attributes:
```php
'type' => 'positive'
'min' => 0
```
*
* @see scm_acf_field_number()
*
* @param {array|string=} name Field name or field general attributes (default is '').
* @param {array|string|0=} field Field specific attributes or field default attribute (default is 0).
* @param {int|0=} width Field width (default is 100).
* @param {array|0=} logic Field conditional logics (default is 0).
* @param {bool=} required Field conditional logics (default is false).
* @param {string=} label Field label (default is '').
* @return {array} Field.
*/
function scm_acf_field_positive( $name = '', $field = 0, $width = 100, $logic = 0, $required = 0, $label = '' ) {
	return scm_acf_helper( $name, $field, array('type' => 'positive','label' => $label), $width, $logic, $required );
}

/**
* [GET] NEGATIVE field builder
*
* Specific field attributes:
```php
'type' => 'negative'
'max' => 0
```
*
* @see scm_acf_field_number()
*
* @param {array|string=} name Field name or field general attributes (default is '').
* @param {array|string|0=} field Field specific attributes or field default attribute (default is 0).
* @param {int|0=} width Field width (default is 100).
* @param {array|0=} logic Field conditional logics (default is 0).
* @param {bool=} required Field conditional logics (default is false).
* @param {string=} label Field label (default is '').
* @return {array} Field.
*/
function scm_acf_field_negative( $name = '', $field = 0, $width = 100, $logic = 0, $required = 0, $label = '' ) {
	return scm_acf_helper( $name, $field, array('type' => 'negative','label' => $label), $width, $logic, $required );
}

/**
* [GET] ALPHA field builder
*
* Specific field attributes:
```php
'type' => 'alpha'
'min' => 0
'max' => 1
'step' => .1
'placeholder' => '1'
```
*
* @see scm_acf_field_number()
*
* @param {array|string=} name Field name or field general attributes (default is '').
* @param {array|string|0=} field Field specific attributes or field default attribute (default is 0).
* @param {int|0=} width Field width (default is 100).
* @param {array|0=} logic Field conditional logics (default is 0).
* @param {bool=} required Field conditional logics (default is false).
* @param {string=} label Field label (default is '').
* @return {array} Field.
*/
function scm_acf_field_alpha( $name = '', $field = 0, $width = 100, $logic = 0, $required = 0, $label = '' ) {
	return scm_acf_helper( $name, $field, array('type' => 'alpha','label' => $label), $width, $logic, $required );
}

// ------------------------------------------------------
// 2.3 TEXT
// ------------------------------------------------------

/**
* [GET] TEXT field builder
*
* Specific field attributes:
```php
'type' => 'text'
'default' => ''
'placeholder' => ''
'prepend' => ''
'append' => ''
'max' => ''
'read' => false
'disabled' => false
```
*
* @param {array|string=} name Field name or field general attributes (default is '').
* @param {array|string|0=} field Field specific attributes or field default attribute (default is 0).
* @param {int|0=} width Field width (default is 100).
* @param {array|0=} logic Field conditional logics (default is 0).
* @param {bool=} required Field conditional logics (default is false).
* @param {string=} label Field label (default is '').
* @return {array} Field.
*/
function scm_acf_field_text( $name = '', $field = 0, $width = 100, $logic = 0, $required = 0, $label = '' ) {
	return scm_acf_helper( $name, $field, array('type' => 'text','label' => $label), $width, $logic, $required );
}

/**
* [GET] ID field builder
*
* Specific field attributes:
```php
'type' => 'id'
'prepend' => '#'
'placeholder' => 'id'
```
*
* @see scm_acf_field_text()
*
* @param {array|string=} name Field name or field general attributes (default is '').
* @param {array|string|0=} field Field specific attributes or field default attribute (default is 0).
* @param {int|0=} width Field width (default is 100).
* @param {array|0=} logic Field conditional logics (default is 0).
* @param {bool=} required Field conditional logics (default is false).
* @param {string=} label Field label (default is '').
* @return {array} Field.
*/
function scm_acf_field_id( $name = '', $field = 0, $width = 100, $logic = 0, $required = 0, $label = '' ) {
	return scm_acf_helper( $name, $field, array('type' => 'id','label' => $label), $width, $logic, $required );
}

/**
* [GET] CLASS field builder
*
* Specific field attributes:
```php
'type' => 'class'
'prepend' => '.'
'placeholder' => 'class'
```
*
* @see scm_acf_field_text()
*
* @param {array|string=} name Field name or field general attributes (default is '').
* @param {array|string|0=} field Field specific attributes or field default attribute (default is 0).
* @param {int|0=} width Field width (default is 100).
* @param {array|0=} logic Field conditional logics (default is 0).
* @param {bool=} required Field conditional logics (default is false).
* @param {string=} label Field label (default is '').
* @return {array} Field.
*/
function scm_acf_field_class( $name = '', $field = 0, $width = 100, $logic = 0, $required = 0, $label = '' ) {
	return scm_acf_helper( $name, $field, array('type' => 'class','label' => $label), $width, $logic, $required );
}

/**
* [GET] ATTRIBUTES field builder
*
* Specific field attributes:
```php
'type' => 'attributes'
'prepend' => 'Data'
'placeholder' => 'data-href="www.website.com" data-target="_blank"'
```
*
* @see scm_acf_field_text()
*
* @param {array|string=} name Field name or field general attributes (default is '').
* @param {array|string|0=} field Field specific attributes or field default attribute (default is 0).
* @param {int|0=} width Field width (default is 100).
* @param {array|0=} logic Field conditional logics (default is 0).
* @param {bool=} required Field conditional logics (default is false).
* @param {string=} label Field label (default is '').
* @return {array} Field.
*/
function scm_acf_field_attributes( $name = '', $field = 0, $width = 100, $logic = 0, $required = 0, $label = '' ) {
	return scm_acf_helper( $name, $field, array('type' => 'attributes', 'label' => $label), $width, $logic, $required );
}

/**
* [GET] NAME field builder
*
* Specific field attributes:
```php
'type' => 'name'
'prepend' => 'Nome'
'placeholder' => 'senza nome'
'max' => 30
```
*
* @see scm_acf_field_text()
*
* @param {array|string=} name Field name or field general attributes (default is '').
* @param {array|string|0=} field Field specific attributes or field default attribute (default is 0).
* @param {int|0=} width Field width (default is 100).
* @param {array|0=} logic Field conditional logics (default is 0).
* @param {bool=} required Field conditional logics (default is false).
* @param {string=} label Field label (default is '').
* @return {array} Field.
*/
function scm_acf_field_name( $name = '', $field = 0, $width = 100, $logic = 0, $required = 0, $label = '' ) {
	return scm_acf_helper( $name, $field, array('type' => 'name','label' => $label), $width, $logic, $required );
}

/**
* [GET] LINK field builder
*
* Specific field attributes:
```php
'type' => 'link'
'prepend' => 'URL'
'placeholder' => 'http://www.website.com'
```
*
* @see scm_acf_field_text()
*
* @param {array|string=} name Field name or field general attributes (default is '').
* @param {array|string|0=} field Field specific attributes or field default attribute (default is 0).
* @param {int|0=} width Field width (default is 100).
* @param {array|0=} logic Field conditional logics (default is 0).
* @param {bool=} required Field conditional logics (default is false).
* @param {string=} label Field label (default is '').
* @return {array} Field.
*/
function scm_acf_field_link( $name = '', $field = 0, $width = 100, $logic = 0, $required = 0, $label = '' ) {
	return scm_acf_helper( $name, $field, array('type' => 'link','label' => $label), $width, $logic, $required );
}

/**
* [GET] EMAIL field builder
*
* Specific field attributes:
```php
'type' => 'email'
'prepend' => '@'
'placeholder' => 'info@.website.com'
```
*
* @see scm_acf_field_text()
*
* @param {array|string=} name Field name or field general attributes (default is '').
* @param {array|string|0=} field Field specific attributes or field default attribute (default is 0).
* @param {int|0=} width Field width (default is 100).
* @param {array|0=} logic Field conditional logics (default is 0).
* @param {bool=} required Field conditional logics (default is false).
* @param {string=} label Field label (default is '').
* @return {array} Field.
*/
function scm_acf_field_email( $name = '', $field = 0, $width = 100, $logic = 0, $required = 0, $label = '' ) {
	return scm_acf_helper( $name, $field, array('type' => 'email','label' => $label), $width, $logic, $required );
}

/**
* [GET] USER field builder
*
* Specific field attributes:
```php
'type' => 'user'
'prepend' => 'User'
'placeholder' => 'user name'
```
*
* @see scm_acf_field_text()
*
* @param {array|string=} name Field name or field general attributes (default is '').
* @param {array|string|0=} field Field specific attributes or field default attribute (default is 0).
* @param {int|0=} width Field width (default is 100).
* @param {array|0=} logic Field conditional logics (default is 0).
* @param {bool=} required Field conditional logics (default is false).
* @param {string=} label Field label (default is '').
* @return {array} Field.
*/
function scm_acf_field_user( $name = '', $field = 0, $width = 100, $logic = 0, $required = 0, $label = '' ) {
	return scm_acf_helper( $name, $field, array('type' => 'user','label' => $label), $width, $logic, $required );
}

/**
* [GET] PHONE field builder
*
* Specific field attributes:
```php
'type' => 'phone'
'prepend' => 'N.'
'placeholder' => '+39 123 4567'
```
*
* @see scm_acf_field_text()
*
* @param {array|string=} name Field name or field general attributes (default is '').
* @param {array|string|0=} field Field specific attributes or field default attribute (default is 0).
* @param {int|0=} width Field width (default is 100).
* @param {array|0=} logic Field conditional logics (default is 0).
* @param {bool=} required Field conditional logics (default is false).
* @param {string=} label Field label (default is '').
* @return {array} Field.
*/
function scm_acf_field_phone( $name = '', $field = 0, $width = 100, $logic = 0, $required = 0, $label = '' ) {
	return scm_acf_helper( $name, $field, array('type' => 'phone','label' => $label), $width, $logic, $required );
}

// ------------------------------------------------------
// 2.4 LIMITER
// ------------------------------------------------------

/**
* [GET] LIMITER field builder
*
* Specific field attributes:
```php
'type' => 'limiter'
'max' => 350
'display' => false
```
*
* @param {array|string=} name Field name or field general attributes (default is '').
* @param {array|string|0=} field Field specific attributes or field default attribute (default is 0).
* @param {int|0=} width Field width (default is 100).
* @param {array|0=} logic Field conditional logics (default is 0).
* @param {bool=} required Field conditional logics (default is false).
* @param {string=} label Field label (default is '').
* @return {array} Field.
*/
function scm_acf_field_limiter( $name = '', $field = 0, $width = 100, $logic = 0, $required = 0, $label = '' ) {
	return scm_acf_helper( $name, $field, array('type'=>'limiter','max'=>350,'display'=>1,'label' => $label), $width, $logic, $required );
}

// ------------------------------------------------------
// 2.5 TEXTAREA
// ------------------------------------------------------

/**
* [GET] TEXTAREA field builder
*
* Specific field attributes:
```php
'type' => 'textarea'
'default' => ''
'placeholder' => ''
'rows' => 8
'max' => ''
'lines' => 'wpautop'
'read' => false
'disabled' => false
```
*
* @param {array|string=} name Field name or field general attributes (default is '').
* @param {array|string|0=} field Field specific attributes or field default attribute (default is 0).
* @param {int|0=} width Field width (default is 100).
* @param {array|0=} logic Field conditional logics (default is 0).
* @param {bool=} required Field conditional logics (default is false).
* @param {string=} label Field label (default is '').
* @return {array} Field.
*/
function scm_acf_field_textarea( $name = '', $field = 0, $width = 100, $logic = 0, $required = 0, $label = '' ) {
	return scm_acf_helper( $name, $field, array('type'=>'textarea', 'rows'=>8,'label' => $label), $width, $logic, $required );
}

/**
* [GET] TEXTAREA CODE field builder
*
* Specific field attributes:
```php
'type' => 'textarea-no'
'lines' => ''
'rows' => 8
'class' => 'widefat code'
```
*
* @see scm_acf_field_textarea()
*
* @param {array|string=} name Field name or field general attributes (default is '').
* @param {array|string|0=} field Field specific attributes or field default attribute (default is 0).
* @param {int|0=} width Field width (default is 100).
* @param {array|0=} logic Field conditional logics (default is 0).
* @param {bool=} required Field conditional logics (default is false).
* @param {string=} label Field label (default is '').
* @return {array} Field.
*/
function scm_acf_field_codearea( $name = '', $field = 0, $width = 100, $logic = 0, $required = 0, $label = '' ) {
	return scm_acf_helper( $name, $field, array('type'=>'textarea-no', 'rows'=>8, 'class'=>'widefat code','label' => $label), $width, $logic, $required );
}

// ------------------------------------------------------
// 2.6 EDITOR
// ------------------------------------------------------

/**
* [GET] EDITOR BASIC MEDIA field builder
*
* Specific field attributes:
```php
'type' => 'editor-media-basic'
'default' => ''
'tabs' => 'all'
'toolbar' => 'basic'
'media' => true
```
*
* @param {array|string=} name Field name or field general attributes (default is '').
* @param {array|string|0=} field Field specific attributes or field default attribute (default is 0).
* @param {int|0=} width Field width (default is 100).
* @param {array|0=} logic Field conditional logics (default is 0).
* @param {bool=} required Field conditional logics (default is false).
* @param {string=} label Field label (default is '').
* @return {array} Field.
*/
function scm_acf_field_editor( $name = '', $field = 0, $width = 100, $logic = 0, $required = 0, $label = '' ) {
	return scm_acf_helper( $name, $field, array('type' => 'editor-media-basic','label' => $label), $width, $logic, $required );
}

/**
* [GET] EDITOR VISUAL MEDIA field builder
*
* Specific field attributes:
```php
'type' => 'editor-media-visual-basic'
'default' => ''
'tabs' => 'visual'
'toolbar' => 'basic'
'media' => true
```
*
* @param {array|string=} name Field name or field general attributes (default is '').
* @param {array|string|0=} field Field specific attributes or field default attribute (default is 0).
* @param {int|0=} width Field width (default is 100).
* @param {array|0=} logic Field conditional logics (default is 0).
* @param {bool=} required Field conditional logics (default is false).
* @param {string=} label Field label (default is '').
* @return {array} Field.
*/
function scm_acf_field_editor_media( $name = '', $field = 0, $width = 100, $logic = 0, $required = 0, $label = '' ) {
	return scm_acf_helper( $name, $field, array('type' => 'editor-media-visual-basic','label' => $label), $width, $logic, $required );
}

/**
* [GET] EDITOR VISUAL field builder
*
* Specific field attributes:
```php
'type' => 'editor-visual-basic'
'default' => ''
'tabs' => 'visual'
'toolbar' => 'basic'
'media' => false
```
*
* @see scm_acf_field_editor()
*
* @param {array|string=} name Field name or field general attributes (default is '').
* @param {array|string|0=} field Field specific attributes or field default attribute (default is 0).
* @param {int|0=} width Field width (default is 100).
* @param {array|0=} logic Field conditional logics (default is 0).
* @param {bool=} required Field conditional logics (default is false).
* @param {string=} label Field label (default is '').
* @return {array} Field.
*/
function scm_acf_field_editor_basic( $name = '', $field = 0, $width = 100, $logic = 0, $required = 0, $label = '' ) {
	return scm_acf_helper( $name, $field, array('type' => 'editor-visual-basic','label' => $label), $width, $logic, $required );
}

// ------------------------------------------------------
// 2.7 DATE TIME
// ------------------------------------------------------

/**
* [GET] DATE field builder
*
* Specific field attributes:
```php
'type' => 'date'
'return' => 'Y-m-d'
'display' => 'd F Y'
'firstday' => 1
```
*
* @param {array|string=} name Field name or field general attributes (default is '').
* @param {array|string|0=} field Field specific attributes or field default attribute (default is 0).
* @param {int|0=} width Field width (default is 100).
* @param {array|0=} logic Field conditional logics (default is 0).
* @param {bool=} required Field conditional logics (default is false).
* @param {string=} label Field label (default is '').
* @return {array} Field.
*/
function scm_acf_field_date( $name = '', $field = 0, $width = 100, $logic = 0, $required = 0, $label = '' ) {
	return scm_acf_helper( $name, $field, array('type' => 'date','label' => $label), $width, $logic, $required );
}

/**
* [GET] TIME field builder
*
* Specific field attributes:
```php
'type' => 'time'
'return' => 'G:i'
'display' => 'G:i'
```
*
* @param {array|string=} name Field name or field general attributes (default is '').
* @param {array|string|0=} field Field specific attributes or field default attribute (default is 0).
* @param {int|0=} width Field width (default is 100).
* @param {array|0=} logic Field conditional logics (default is 0).
* @param {bool=} required Field conditional logics (default is false).
* @param {string=} label Field label (default is '').
* @return {array} Field.
*/
function scm_acf_field_time( $name = '', $field = 0, $width = 100, $logic = 0, $required = 0, $label = '' ) {
	return scm_acf_helper( $name, $field, array('type' => 'time','label' => $label), $width, $logic, $required );
}

/**
* [GET] DATE TIME field builder
*
* Specific field attributes:
```php
'type' => 'datetime'
'return' => 'Y-m-d G:i'
'display' => 'd F Y G:i'
'firstday' => 1
```
*
* @param {array|string=} name Field name or field general attributes (default is '').
* @param {array|string|0=} field Field specific attributes or field default attribute (default is 0).
* @param {int|0=} width Field width (default is 100).
* @param {array|0=} logic Field conditional logics (default is 0).
* @param {bool=} required Field conditional logics (default is false).
* @param {string=} label Field label (default is '').
* @return {array} Field.
*/
function scm_acf_field_datetime( $name = '', $field = 0, $width = 100, $logic = 0, $required = 0, $label = '' ) {
	return scm_acf_helper( $name, $field, array('type' => 'datetime','label' => $label), $width, $logic, $required );
}

// ------------------------------------------------------
// 2.8 COLOR
// ------------------------------------------------------

/**
* [GET] COLOR field builder
*
* Specific field attributes:
```php
'type' => 'color'
'default' => ''
```
*
* @param {array|string=} name Field name or field general attributes (default is '').
* @param {array|string|0=} field Field specific attributes or field default attribute (default is 0).
* @param {int|0=} width Field width (default is 100).
* @param {array|0=} logic Field conditional logics (default is 0).
* @param {bool=} required Field conditional logics (default is false).
* @param {string=} label Field label (default is '').
* @return {array} Field.
*/
function scm_acf_field_color( $name = '', $field = 0, $width = 100, $logic = 0, $required = 0, $label = '' ) {
	return scm_acf_helper( $name, $field, array('type' => 'color','label' => $label), $width, $logic, $required );
}

// ------------------------------------------------------
// 2.9 ICON
// ------------------------------------------------------

/**
* [GET] ICON field builder
*
* Specific field attributes:
```php
'type' => 'icon'
'default' => 'star'
'filter' => array(fa-groups)
'save' => 'class'
'enqueue' => false
'null' => false
'preview' => true
```
*
* @param {array|string=} name Field name or field general attributes (default is '').
* @param {array|string|0=} field Field specific attributes or field default attribute (default is 0).
* @param {int|0=} width Field width (default is 100).
* @param {array|0=} logic Field conditional logics (default is 0).
* @param {bool=} required Field conditional logics (default is false).
* @param {string=} label Field label (default is '').
* @return {array} Field.
*/
function scm_acf_field_icon( $name = '', $field = 0, $width = 100, $logic = 0, $required = 0, $label = '' ) {
	return scm_acf_helper( $name, $field, array('type' => 'icon','default'=>'star','label' => $label), $width, $logic, $required );
}

/**
* [GET] ICON NO field builder
*
* Specific field attributes:
```php
'type' => 'icon-no'
'choices' => ['no'=>'No Icon',...]
```
*
* @see scm_acf_field_icon()
*
* @param {array|string=} name Field name or field general attributes (default is '').
* @param {array|string|0=} field Field specific attributes or field default attribute (default is 0).
* @param {int|0=} width Field width (default is 100).
* @param {array|0=} logic Field conditional logics (default is 0).
* @param {bool=} required Field conditional logics (default is false).
* @param {string=} label Field label (default is '').
* @return {array} Field.
*/
function scm_acf_field_icon_no( $name = '', $field = 0, $width = 100, $logic = 0, $required = 0, $label = '' ) {
	return scm_acf_helper( $name, $field, array('type' => 'icon-no','default'=>'no','label' => $label), $width, $logic, $required );
}

// ------------------------------------------------------
// 2.10 IMAGE
// ------------------------------------------------------

/**
* [GET] IMAGE field builder
*
* Specific field attributes:
```php
'type' => 'image'
'library' => 'uploadedTo'
'preview' => 'thumbnail'
'minwidth' => 0
'maxwidth' => 0
'minheight' => 0
'maxheight' => 0
'minsize' => 0
'maxsize' => 0
'mime' => ''
'return' => 'array'
```
*
* @param {array|string=} name Field name or field general attributes (default is '').
* @param {array|string|0=} field Field specific attributes or field default attribute (default is 0).
* @param {int|0=} width Field width (default is 100).
* @param {array|0=} logic Field conditional logics (default is 0).
* @param {bool=} required Field conditional logics (default is false).
* @param {string=} label Field label (default is '').
* @return {array} Field.
*/
function scm_acf_field_image( $name = '', $field = 0, $width = 100, $logic = 0, $required = 0, $label = '' ) {
	return scm_acf_helper( $name, $field, array('type' => 'image','label'=>($label ?: __( 'Seleziona un\'immagine', SCM_THEME ))), $width, $logic, $required );
}

/**
* [GET] IMAGE URL field builder
*
* Specific field attributes:
```php
'type' => 'image-url'
'return' => 'url'
```
*
* @see scm_acf_field_image()
*
* @param {array|string=} name Field name or field general attributes (default is '').
* @param {array|string|0=} field Field specific attributes or field default attribute (default is 0).
* @param {int|0=} width Field width (default is 100).
* @param {array|0=} logic Field conditional logics (default is 0).
* @param {bool=} required Field conditional logics (default is false).
* @param {string=} label Field label (default is '').
* @return {array} Field.
*/
function scm_acf_field_image_url( $name = '', $field = 0, $width = 100, $logic = 0, $required = 0, $label = '' ) {
	return scm_acf_helper( $name, $field, array('type' => 'image-url','label'=>($label ?: __( 'Seleziona un\'immagine', SCM_THEME ))), $width, $logic, $required );
}

// ------------------------------------------------------
// 2.11 FILE
// ------------------------------------------------------

/**
* [GET] FILE field builder
*
* Specific field attributes:
```php
'type' => 'file'
'library' => 'uploadedTo'
'minsize' => 0
'maxsize' => 0
'mime' => ''
'return' => 'array'
```
*
* @param {array|string=} name Field name or field general attributes (default is '').
* @param {array|string|0=} field Field specific attributes or field default attribute (default is 0).
* @param {int|0=} width Field width (default is 100).
* @param {array|0=} logic Field conditional logics (default is 0).
* @param {bool=} required Field conditional logics (default is false).
* @param {string=} label Field label (default is '').
* @return {array} Field.
*/
function scm_acf_field_file( $name = '', $field = 0, $width = 100, $logic = 0, $required = 0, $label = '' ) {
	return scm_acf_helper( $name, $field, array('type' => 'file','label'=>($label ?: __( 'Seleziona un file', SCM_THEME ))), $width, $logic, $required );
}

/**
* [GET] FILE URL field builder
*
* Specific field attributes:
```php
'type' => 'file-url'
'return' => 'url'
```
*
* @see scm_acf_field_file()
*
* @param {array|string=} name Field name or field general attributes (default is '').
* @param {array|string|0=} field Field specific attributes or field default attribute (default is 0).
* @param {int|0=} width Field width (default is 100).
* @param {array|0=} logic Field conditional logics (default is 0).
* @param {bool=} required Field conditional logics (default is false).
* @param {string=} label Field label (default is '').
* @return {array} Field.
*/
function scm_acf_field_file_url( $name = '', $field = 0, $width = 100, $logic = 0, $required = 0, $label = '' ) {
	return scm_acf_helper( $name, $field, array('type' => 'file-url','label'=>($label ?: __( 'Seleziona un file', SCM_THEME ))), $width, $logic, $required );
}

// ------------------------------------------------------
// 2.12 TRUE FALSE
// ------------------------------------------------------

/**
* [GET] FALSE field builder
*
* Specific field attributes:
```php
'type' => 'true_false'
'default' => false
```
*
* @param {array|string=} name Field name or field general attributes (default is '').
* @param {array|string|0=} field Field specific attributes or field default attribute (default is 0).
* @param {int|0=} width Field width (default is 100).
* @param {array|0=} logic Field conditional logics (default is 0).
* @param {bool=} required Field conditional logics (default is false).
* @param {string=} label Field label (default is '').
* @return {array} Field.
*/
function scm_acf_field_false( $name = '', $field = 0, $width = 100, $logic = 0, $required = 0, $label = '' ) {
	return scm_acf_helper( $name, $field, array('default'=>0, 'type' => 'true_false','label'=>( $label ?: __( 'Abilita', SCM_THEME ) ) ), $width, $logic, $required );
}

/**
* [GET] TRUE field builder
*
* Specific field attributes:
```php
'type' => 'true_false'
'default' => true
```
*
*
* @param {array|string=} name Field name or field general attributes (default is '').
* @param {array|string|0=} field Field specific attributes or field default attribute (default is 0).
* @param {int|0=} width Field width (default is 100).
* @param {array|0=} logic Field conditional logics (default is 0).
* @param {bool=} required Field conditional logics (default is false).
* @param {string=} label Field label (default is '').
* @return {array} Field.
*/
function scm_acf_field_true( $name = '', $field = 0, $width = 100, $logic = 0, $required = 0, $label = '' ) {
	return scm_acf_helper( $name, $field, array('default'=>1, 'type' => 'true_false','label'=>( $label ?: __( 'Abilita', SCM_THEME ) ) ), $width, $logic, $required );
}

// ------------------------------------------------------
// 2.13 SELECT
// ------------------------------------------------------

/**
* [GET] SELECT field builder
*
* Specific field attributes:
```php
'select'
'default' => ''
'placeholder' => ''
'ajax' => false
'null' => false
'ui' => false
'multi' => false
'read' => false
'disabled' => false
'choices' => []
```
*
* @param {array|string=} name Field name or field general attributes (default is '').
* @param {array|string|0=} field Field specific attributes or field default attribute (default is 0).
* @param {int|0=} width Field width (default is 100).
* @param {array|0=} logic Field conditional logics (default is 0).
* @param {bool=} required Field conditional logics (default is false).
* @param {string=} label Field label (default is '').
* @return {array} Field.
*/
function scm_acf_field_select( $name = '', $field = 0, $width = 100, $logic = 0, $required = 0, $label = '' ) {
	$type = 'select';
	if( is_string( $field ) ){
		$type = $type . ( startsWith($field, '2') ? '' : '-') . $field;
		$field = 0;
	}elseif( $field === 1 ){
		$type = $type . '-default';
		$field = 0;
	}elseif( is_array( $field ) && isset( $field['type'] ) && $field['type'] ){
		$field['type'] = $type . '-' . $field['type'];
	}
	return scm_acf_helper( $name, $field, array( 'type'=>$type, 'label'=>$label ), $width, $logic, $required );
}

// ------------------------------------------------------
// 2.14 OBJECT
// ------------------------------------------------------

/**
* [GET] INTERNAL OBJECT field builder
*
* Specific field attributes:
```php
'type' => 'object'
'types' => ''
'taxes' => ''
'placeholder' => ''
'null' => false
'multiple' => false
'return' => 'object'
'filters' => []
'ui' => true
```
*
* @param {array|string=} name Field name or field general attributes (default is '').
* @param {array|string|0=} field Field specific attributes or field default attribute (default is 0).
* @param {int|0=} width Field width (default is 100).
* @param {array|0=} logic Field conditional logics (default is 0).
* @param {bool=} required Field conditional logics (default is false).
* @param {string=} label Field label (default is '').
* @return {array} Field.
*/
function scm_acf_field_object( $name = '', $field = 0, $width = 100, $logic = 0, $required = 0, $label = '' ) {
		$type = 'object';
	if( is_string( $field ) ){
		$type = $type . $field;
		$field = 0;
	}elseif( is_array( $field ) && $field['type'] ){
		$type = $field['type'] = $type . '-' . $field['type'];
	}
	return scm_acf_helper( $name, $field, array( 'type'=>$type, 'label'=>$label ), $width, $logic, $required );
}

/**
* [GET] INTERNAL OBJECTS field builder
*
* Specific field attributes:
```php
'type' => 'objects'
'multiple' => true
```
*
* @see scm_acf_field_object()
*
* @param {array|string=} name Field name or field general attributes (default is '').
* @param {array|string|0=} field Field specific attributes or field default attribute (default is 0).
* @param {int|0=} width Field width (default is 100).
* @param {array|0=} logic Field conditional logics (default is 0).
* @param {bool=} required Field conditional logics (default is false).
* @param {string=} label Field label (default is '').
* @return {array} Field.
*/
function scm_acf_field_objects( $name = '', $field = 0, $width = 100, $logic = 0, $required = 0, $label = '' ) {
		$type = 'objects';
	if( is_string( $field ) ){
		$type = $type . $field;
		$field = 0;
	}elseif( is_array( $field ) && $field['type'] ){
		$type = $field['type'] = $type . '-' . $field['type'];
	}
	return scm_acf_helper( $name, $field, array( 'type'=>$type, 'label'=>$label ), $width, $logic, $required );
}

// ------------------------------------------------------
// 2.15 TAXONOMY
// ------------------------------------------------------

/**
* [GET] TAXONOMY field builder
*
* Specific field attributes:
```php
'type' => 'taxonomy'
'taxes' => ''
'add' => false
'save' => false
'null' => false
'return' => 'object'
'multiple' =>  false
```
*
* @param {array|string=} name Field name or field general attributes (default is '').
* @param {array|string|0=} field Field specific attributes or field default attribute (default is 0).
* @param {int|0=} width Field width (default is 100).
* @param {array|0=} logic Field conditional logics (default is 0).
* @param {bool=} required Field conditional logics (default is false).
* @param {string=} label Field label (default is '').
* @return {array} Field.
*/
function scm_acf_field_taxonomy( $name = '', $field = 0, $width = 100, $logic = 0, $required = 0, $label = '' ) {
		$type = 'taxonomy';
	if( is_string( $field ) ){
		$type = $type . '-' . $field;
		$field = 0;
	}elseif( is_array( $field ) && $field['type'] ){
		$type = $field['type'] = $type . '-' . $field['type'];
	}
	return scm_acf_helper( $name, $field, array( 'type'=>$type, 'label'=>$label ), $width, $logic, $required );
}

/**
* [GET] TAXONOMIES field builder
*
* Specific field attributes:
```php
'type' => 'taxonomies'
'multiple' =>  true
```
*
* @see scm_acf_field_taxonomy()
*
* @param {array|string=} name Field name or field general attributes (default is '').
* @param {array|string|0=} field Field specific attributes or field default attribute (default is 0).
* @param {int|0=} width Field width (default is 100).
* @param {array|0=} logic Field conditional logics (default is 0).
* @param {bool=} required Field conditional logics (default is false).
* @param {string=} label Field label (default is '').
* @return {array} Field.
*/
function scm_acf_field_taxonomies( $name = '', $field = 0, $width = 100, $logic = 0, $required = 0, $label = '' ) {
		$type = 'taxonomies';
	if( is_string( $field ) ){
		$type = $type . '-' . $field;
		$field = 0;
	}elseif( is_array( $field ) && $field['type'] ){
		$type = $field['type'] = $type . '-' . $field['type'];
	}
	return scm_acf_helper( $name, $field, array( 'type'=>$type, 'label'=>$label ), $width, $logic, $required );
}

// ------------------------------------------------------
// 2.16 REPEATER
// ------------------------------------------------------

/**
* [GET] REPEATER field builder
*
* Specific field attributes:
```php
'type' => 'repeater'
'button' => '+'
'min' => 0
'max' => 0
'layout' => 'row'
'sub' => []
```
*
* @param {array|string=} name Field name or field general attributes (default is '').
* @param {array|string|0=} field Field specific attributes or field default attribute (default is 0).
* @param {int|0=} width Field width (default is 100).
* @param {array|0=} logic Field conditional logics (default is 0).
* @param {bool=} required Field conditional logics (default is false).
* @param {string=} label Field label (default is '').
* @return {array} Field.
*/
function scm_acf_field_repeater( $name = '', $field = 0, $width = 100, $logic = 0, $required = 0, $label = '' ) {
	$type = 'repeater';
	if( is_string( $field ) ){
		$type = $type . '-' . $field;
		$field = 0;
	}elseif( is_array( $field ) && isset( $field['type'] ) && $field['type'] ){
		$type = $field['type'] = $type . '-' . $field['type'];
	}else{
		$type = 'repeater-block';
	}

	return scm_acf_helper( $name, $field, array( 'type'=>$type, 'label'=>$label ), $width, $logic, $required );
}

// ------------------------------------------------------
// 2.17 FLEXIBLE CONTENT
// ------------------------------------------------------

/**
* [GET] FLEXIBLE CONTENT field builder
*
* Specific field attributes:
```php
'type' => 'flexible'
'button' => '+'
'min' => 0
'max' => 0
'layouts' => []
```
*
* @param {array|string=} name Field name or field general attributes (default is '').
* @param {array|string|0=} field Field specific attributes or field default attribute (default is 0).
* @param {int|0=} width Field width (default is 100).
* @param {array|0=} logic Field conditional logics (default is 0).
* @param {bool=} required Field conditional logics (default is false).
* @param {string=} label Field label (default is '').
* @return {array} Field.
*/
function scm_acf_field_flexible( $name = '', $field = 0, $width = 100, $logic = 0, $required = 0, $label = '' ) {
	return scm_acf_helper( $name, $field, array( 'type'=>'flexible', 'label'=>$label ), $width, $logic, $required );
}

?>