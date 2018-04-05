<?php

/**
* ACF setup and functions.
*
* @link http://www.studiocreativo-m.it
*
* @package SCM
* @subpackage 2-ACF
* @since 1.0.0
*/

// ------------------------------------------------------
//
// SETUP
// 		SET
//		GET
// FUNCTIONS
//
// ------------------------------------------------------

// ------------------------------------------------------
// SETUP
// ------------------------------------------------------
// ------------------------------------------------------
// SET
// ------------------------------------------------------

// GROUP

/**
* [SET] Group
*
* @subpackage 2-ACF/Core/SET
*
* @param {string} name Required. Field Group name.
* @param {string=} key Unique key (default is '' = sanitized name).
* @param {array=} attr Optional. List of attributes (default is empty array).
* @return {array} Field Group settings.
*/
function scm_acf_group( $name, $key = '', $attr = array() ) {

	if( !$name ) return;

	$key = ( $key ?: sanitize_title( $name ) );

	$group = array (
		'key' => $key,
		'title' => $name,
		'fields' => array(),
		'location' => array(
			array(
				scm_acf_get_location_rule( 'post' ),
				scm_acf_get_location_rule_not( 'post' ),
			),
		),
		'menu_order' => 0,
		'position' => 'normal',
		'style' => 'default',
		'label_placement' => 'top',
		'instruction_placement' => 'label',
		'hide_on_screen' => array(
			0 => 'the_content',
			1 => 'excerpt',
			2 => 'custom_fields',
			3 => 'discussion',
			4 => 'comments',
			5 => 'revisions',
			6 => 'slug',
			7 => 'author',
			8 => 'format',
			9 => 'page_attributes',
			10 => 'featured_image',
			11 => 'categories',
			12 => 'tags',
			13 => 'send-trackbacks',
		),
	);

	if( is_array( $attr ) )
        $group = array_merge( $group, $attr );

    return $group;
}

/**
* [SET] Group registration
*
* @subpackage 2-ACF/Core/SET
*
* @param {array} group Field Group.
*/
function scm_acf_group_register( $group ) {

	$group['fields'] = scm_acf_key_and_condition( $group['key'], $group['fields'] );
	$group['key'] = scm_acf_get_key( $group['key'], 'group_' );

	//register_field_group( $group );
	acf_add_local_field_group( $group );

}

// FIELD

/**
* [SET] Field
*
* @subpackage 2-ACF/Core/SET
*
* General field attributes:
```php
[
'label' => {string}
'name' => {string}
'instructions' => {string}
'required' => {bool}
'conditional_logic' => {array}
'width' => {int}
'class' => {string}
'id' => {string}
];
```
*
* Example usage:
```php
// Best usage
$attr = [
'type'=>'text',
'default'=>'Default text',
'placeholder'=>'Placeholder text',
...
]
scm_acf_field( 'my_field', $attr, 'My Label', 100, $logic, 'My Instructions', false, 'my-classes' );

$main = [
'name'=>'my_field',
'label'=>'My Label',
'width'=>'100',
...
]
scm_acf_field( $main, $attr );

// Quick usage
scm_acf_field( 'my_field', 'text', 'My Label', 100, $logic, 'My Instructions', false, 'my-classes' );

// Critical usage [indexed array with exact order - see todo]
$attr = [
'text',
'Default text',
'Placeholder text',
...
]
scm_acf_field( 'my_field', $attr, 'My Label', 100, $logic, 'My Instructions', false, 'my-classes' );
```
* @see scm_acf_get_field()
*
* @todo Trasforma tutte le chiamate a scm_acf_field( name, {indexed array}) con array associativi, per maggiore leggibilità.
*
* @param {string|array} name Field name or field main attributes.
* @param {string|array} default Field type or field specific attributes.
* @param {string=} label Optional. Field label attribute (default is '') or shortcut 'required'.
* @param {int=|string} width Optional. Field width attribute (default is 100) or shortcut 'required'.
* @param {0|array|string} logic Optional. Field logic attribute (default is 0) or shortcut 'required'.
* @param {string} instructions Optional. Field instructions attribute (default is '').
* @param {bool=} required Optional. Field required attribute (default is false).
* @param {string} class Optional. Field class attribute (default is '').
* @return {array} Field.
*/
function scm_acf_field( $name = NULL, $default = NULL, $label = '', $width = 100, $logic = 0, $instructions = '', $required = false, $class = '' ) {

	if( is_null( $name ) || is_null( $default ) ) return;

	$def = get_defined_vars();
	if( is_arr( $name ) )
        $def = wp_parse_args( $name, $def );

	$type = ( is_string( $default ) ? $default : ( is_arr( $default ) ? ( isset( $default[0] ) ? $default[0] : ( isset( $default['type'] ) ? $default['type'] : 'undefined-field' ) ) : 'undefined-field' ) );

	if( is_asso( $default ) )
		$def = array_merge( $def, $default );

	$field = array (
		'key' => ( $def['name'] ? $def['name'] . '_' : '' ),
		'label' => ( $def['label'] ?: '' ),
		'name' => ( $def['name'] ?: $type ),
		'prefix' => '',
		'instructions' => ( $def['instructions'] ?: '' ),
		'required' => ( $def['required'] ?: 0 ),
		'conditional_logic' => ( $def['logic'] && is( $def['logic'] ) && !is_string( $def['logic'] ) ? array( scm_acf_merge_conditions( $def['logic'] ) ) : '' ),
		'wrapper' => array (
			'width' => ( is_numeric( $def['width'] ) ? $def['width'] : '' ),
			'class' => ( $def['class'] ? $def['class'] . ' ' : '' ) . $type,
			'id' => '',
		)
	);

    if( $def['width'] === 'required' || $def['logic'] === 'required' )
    	$field['required'] = 1;

    $field = array_merge( $field, scm_acf_get_field( $default ) );

	return $field;
}

// LAYOUT

/**
* [SET] Layout
*
* @subpackage 2-ACF/Core/SET
*
* @param {string} name Required. Layout name.
* @param {string=} type Layout type (default is 'block').
* @param {string=} label Layout label (default is 'Layout').
* @param {int=} min Layout min items (default is 0).
* @param {int=} max Layout max items (default is 0).
* @param {array} subfields Layout subfields (default is empty array).
* @return {string} Layout.
*/
function scm_acf_layout( $name, $type = 'block', $label = 'Layout', $min = 0, $max = 0, $subfields = array() ) {

	if( !$name )
		return;

	if( !empty( $subfields ) && ex_attr( $subfields[0], 'name', '' ) != 'layout-advanced' ){
		$subfields = scm_fields_insert( $subfields, scm_field_add_class( scm_acf_field_select( 'layout-advanced', array( 'choices'=>array( 'show' => __( 'Visibile', SCM_THEME ), 'hide' => __( 'Nascondi', SCM_THEME ) ) ) ), '-option hidden' ) );
	}

	$layout = array (
		'key' => $name,
		'name' => 'layout-' . $name,
		'label' => $label,
		'display' => $type,
		'sub_fields' => $subfields,
		'min' => $min,
		'max' => $max,
	);

	return $layout;
}

/**
* [SET] Insert advanced options
*
* @subpackage 2-ACF/Core/SET
*
* @param {array=} list Single layout or list of layouts (default is empty array).
* @param {int=} opt Advanced options preset [ 0 | 1 or 'nolink' | 2 or 'simple' | 3 or 'module' | 4 or 'row' | 5 or 'section' | 6 or 'page' ] (default is 'nolink').
* @return {array} Modified list of layouts.
*/
function scm_acf_layouts_advanced_options( $list = array(), $opt = 'nolink' ) {

	$list = toArray( $list, true, true);
	if( !$list ) return array();

	for ( $i = 0; $i < sizeof( $list ); $i++ )
		$list[$i]['sub_fields'] = array_merge( scm_acf_preset_advanced_options( '', $opt ), $list[$i]['sub_fields'] );

	return $list;
}

// KEY

/**
* [SET] Set key
*
* @subpackage 2-ACF/Core/SET
*
* @param {string} key Required. Key prefix.
* @param {array} list Required. Field or list of fields.
* @return {array} Modified list of fields.
*/
function scm_acf_key_and_condition( $key, $list ) {

	if( !$key || !$list )
		return array();

	$list = toArray( $list, true );

	for ( $i = 0; $i < sizeof( $list ); $i++ ) {

		$nw = $key . ( substr( $key, -1 ) != '_' ? '_' : '' ) . $list[$i]['key'];
		$list[$i]['key'] = $nw;

		if( isset( $list[$i]['layouts'] ) ){
			for ( $j = 0; $j < sizeof( $list[$i]['layouts'] ); $j++ ) {
				$lay = $list[$i]['layouts'][$j]['key'] = scm_acf_get_key( $nw . $list[$i]['layouts'][$j]['name'], 'layout_' );
				$list[$i]['layouts'][$j]['sub_fields'] = scm_acf_key_and_condition( $lay, $list[$i]['layouts'][$j]['sub_fields'] );
			}

		}else if( isset( $list[$i]['sub_fields'] ) ){
			$list[$i]['sub_fields'] = scm_acf_key_and_condition( $nw, $list[$i]['sub_fields'] );
		}

		$list[$i]['key'] = scm_acf_get_key( $list[$i]['key'] . $list[$i]['type'], 'field_' );

		$list[$i] = scm_acf_condition( $list[$i], $list );
	}

	return $list;
}

// CONDITION

/**
* [SET] Conditional logic
*
* @subpackage 2-ACF/Core/SET
*
* @param {array} elem Required. Field.
* @param {array} fields Required. List of fields.
* @return {array} Modified Field.
*/
function scm_acf_condition( $elem, $list ) {

	if( !$elem || !$list )
		return $elem;

	if( !is( $elem['conditional_logic'] ) )
		return $elem;

	$cond = $elem['conditional_logic'];

	for ( $i = 0; $i < sizeof( $cond ); $i++ ) {
		for ( $j = 0; $j < sizeof( $cond[$i] ); $j++ ) {
			$name = $cond[$i][$j]['field'];
			$field = getByValueKey( $list, $name );
			if( $field !== NULL )
				$cond[$i][$j]['field'] = $list[$field]['key'];
		}
	}

	$elem['conditional_logic'] = $cond;

	return $elem;
}

// ------------------------------------------------------
// GET
// ------------------------------------------------------

// LOCATION

/**
* [GET] Group location
*
* @subpackage 2-ACF/Core/GET
*
* @todo [NEXT][CHILD] Change function name to 'scm_acf_get_location'
*
* @param {string|array=} value Single location or array of locations (default is empty array).
* @param {string=} param Location parameter (default is 'post_type').
* @param {string=} cond Location condition (default is '==').
* @return {array} Location group.
*/
function scm_acf_group_location( $value = array(), $param = 'post_type', $cond = '==' ) {

	$location = array();
	$value = toArray( $value, false, true );
	if( !$value || is_asso( $value ) ) return $location;

	foreach( $value as $loc )
		$location[] = scm_acf_get_location_rule( $loc, $param, $cond );

	return $location;
}

/**
* [GET] Group location rule
*
* @subpackage 2-ACF/Core/GET
*
* @param {string} value Required. Single location.
* @param {string=} param Location parameter (default is 'post_type').
* @param {string=} cond Location condition (default is '==').
* @return {array} Location rule.
*/
function scm_acf_get_location_rule( $value = NULL, $param = 'post_type', $cond = '==' ) {
	$rule = array();
	if( is_null( $value ) || !isset( $value ) || !$value || !is_string( $value ) ) return $rule;
	
	$value = ( startsWith( $value, 'admin' ) ? 'administrator' : $value );
	$cond = ( $cond ?: '==' );
	$param = ( $param ?: ( $value == 'administrator' ? 'current_user_role' : 'post_type') );

	$rule = array (
		'param' => $param,
		'operator' => $cond,
		'value' => $value,
	);

	return $rule;
}

/**
* [GET] Group location rule 'not equal'
*
* @subpackage 2-ACF/Core/GET
*
* @param {string} value Required. Single location.
* @param {string=} param Location parameter (default is 'post_type').
* @return {array} Location rule.
*/
function scm_acf_get_location_rule_not( $value = NULL, $param = 'post_type' ) {
	$rule = array();
	if( is_null( $value ) || !isset( $value ) || !$value || !is_string( $value ) ) return $rule;
	
	return scm_acf_get_location_rule( $value, $param, '!=' );
}

// KEY

/**
* [GET] Get key
*
* @subpackage 2-ACF/Core/GET
*
* @param {string} name Required. Key name.
* @param {string=} prepend Prepend string (default is 'key_').
* @return {string} Unique key.
*/
function scm_acf_get_key( $name, $prepend = 'key_' ) {
	if( !$name ) return;
	return $prepend . hash('ripemd160', $name );
}

// CONDITION

/**
* [GET] Merge conditional logics
*
* @subpackage 2-ACF/Core/GET
*
* @param {array} ... One or more conditional logic array.
* @return {array} Conditional logic array.
*/
function scm_acf_merge_conditions() {

	// Get arguments
	if( !func_num_args() ) return;
	$logic = func_get_args();

	$arr = array();

	foreach ($logic as $value) {
		if( !$value || !is_arr( $value ) ) continue;
		if( is_asso( $value ) ){
			$arr[] = $value;
		}else{
			foreach ($value as $sub) {
				
				if( !$sub || !is_arr( $sub ) )
					continue;

				if( is_asso( $sub ) ){
					$arr[] = $sub;				
				}else{
					foreach ($sub as $last) {
						if( !$last || !is_arr( $last ) )
							continue;
						if( is_asso( $last ) )
							$arr[] = $last;
					}
				}
			}
		}
	}

	return $arr;
}


// ------------------------------------------------------
// FUNCTIONS
// ------------------------------------------------------

// FIELD

/**
* [GET] Field content or fallback
*
* @subpackage 2-ACF/FUNCTIONS
*
* Get ACF Field through: Post Option > default? > General Option > default? > Fallback
*
* Example usage:
```php
scm_field( 'my-field', 'My fallback', 'option', false, 'Prepend', 'Append' );
```
*
* @todo 1 - EducateIT usa no_option = -1.<br>
* 		Verifica il suo vero utilizzo (penso sia inutile).<br>
*		Trasforma no_option unicamente in boolean.
*
* @param {sring} name Field name.
* @param {misc=} fallback Field fallback (default is '').
* @param {int|string=} target Post ID or 'option' (default is '', current post ID).
* @param {bool=} no_option Skip field option fallback (default is false).
* @param {string=} before Prepend if string field (default is '').
* @param {string=} after Append if string field (default is '').
* @return {misc} Field content or fallback.
*/
function scm_field( $name, $fallback = '', $target = '', $no_option = false, $before = '', $after = '' ) {

	if( !function_exists( 'get_field' ) || !$name )
		return $fallback;
	
	if( $target != 'option' ){

    	global $post;

    	if( !$post && !$target )
    		return __( 'post e target non trovati', SCM_THEME );

    	$id = ( $target ?: $post->ID );

    	if( !$id )
    		return __( 'id non trovato', SCM_THEME );
		
		$field = get_field( $name, $id );
		$field = ( !is_null( $field ) ? $field : '' );

		// ++todo 1
		if( !$field && $no_option == -1 )
			return $fallback;

    	if( $field === 'no' )
    		return '';

    	if( $field === 'on' )
    		return 1;

    	if( $field === 'off' )
    		return 0;

    	$field = ( $field !== 'default' ? $field : '' );

    	if( is_array( $fallback ) && is_array( $field ) )
    		$field = ( sizeof( $field ) > 0 ? $field : '' );

    	/*if( !$field && $field !== 0 && is_numeric( $fallback ) ){
    		$field = '';
    	}*/
		
    	if( $field !== '' ){
    		if( $before )
    			$field = $before . (string)$field;
    		if( $after )
    			$field = (string)$field . $after;

    		return $field;
    	}

	}else{
		$no_option = 0;
	}

	if( !$no_option ){

		/*global $SCM_options;

		if( !is_array( $fallback ) && isset( $SCM_options[$name] ) )
			$opt = $SCM_options[$name];
		else*/
			$opt = get_field( $name, 'option' );

        $field = ( !is_null( $opt ) ? $opt : '' );

    	if( $field === 'no' )
    		return '';

    	if( $field === 'on' )
    		return 1;

    	if( $field === 'off' )
    		return 0;

    	$field = ( $field !== 'default' ? $field : '' );

    	if( is_array( $fallback ) ){
    		if( !is_array( $field ) )
    			$field = array();
    		$field = ( sizeof( $field ) > 0 ? $field : array() );
    	}

    	/*if( !$field && $field !== 0 && is_numeric( $fallback ) ){
    		$field = '';
    	}*/

        $field = ( $field !== '' ? $field : $fallback );

        if( $field !== '' ){
    		if( $before )
    			$field = $before . (string)$field;
    		if( $after )
    			$field = (string)$field . $after;

    		return $field;
    	}
	}

	return $fallback;
}

/**
* [GET] Field content or fallback from a selection of fields
*
* @subpackage 2-ACF/FUNCTIONS
*
* Example usage:
```php
// Look for a field named 'excerpt' or 'preview'
scm_fields( array( 'excerpt', 'preview' ), 'My fallback', 'option', 0, 'Prepend', 'Append' );
```
*
* @param {array} names List of field names.
* @param {misc=} fallback Field fallback (default is '').
* @param {int|string=} target Post ID or 'option' (default is '', current post ID).
* @param {bool=} no_option Skip field option fallback (default is true).
* @param {string=} before Prepend if string field (default is '').
* @param {string=} after Append if string field (default is '').
* @return {misc} Field content or fallback.
*/
function scm_fields( $names, $fallback = '', $target = '', $no_option = true, $before = '', $after = '' ) {

	if( !names || !is_array( $names ) || empty( $names ) )
		return scm_field( '', $fallback, $target, $no_option, $before, $after );

	foreach ($names as $name) {
		$content = scm_field( $name, '', $target, $no_option, $before, $after );
		if( $content )
			return $content;
	}

	return $fallback;
}

/**
* [GET] Field objects by type and filter
*
* @subpackage 2-ACF/FUNCTIONS
*
* Example usage:
```php
// Filter $my_fields and get all 'text' fields with 'prepend' attribute set to 'Name:'
scm_field_objects( $my_id, $my_fields, 'text', [ 'prepend'=>'Name:' ] );
```
*
* @param {int=} post_id Post ID (default is 0, current post ID).
* @param {array=} fields List of fields (default is empty array).
* @param {string=} type Field type (default is 'text').
* @param {array=} filter Filter fields by attributes (default is empty array).
* @return {array} Filtered list of fields.
*/
function scm_field_objects( $post_id = 0, $fields = array(), $type = 'text', $filter = array() ) {
    global $post;
    $arr = array();
    $post_id = ( $post_id ?: $post->ID );

    foreach ($fields as $key => $value) {

        $field = get_field_object($key, $post_id );

        if ( $field['type'] == $type ) {

            if( !empty( $filter ) ){

                foreach ( $filter as $k => $v ) {
                    if( !isset( $field[$k] ) || $field[$k] !== $v )
                        continue 2;
                    if( is_string( $field[$k] ) && strpos( $field[$k], $v ) === false )
                        continue 2;
                    if ( $field[$k] !== $v )
                        continue 2;
                }
            }

            $arr[] = $field;
        }
    }

    return $arr;
}

/**
* [GET] Field key by field name and filter
*
* @subpackage 2-ACF/FUNCTIONS
*
* @param {int} post_id Required. Post ID.
* @param {array=} fields List of fields (default is empty array).
* @param {string=} name Field name (default is '').
* @param {array|string=} filter Filter fields (default is '').
* @return {string} Field key.
*/
function scm_field_key( $post_id = NULL, $fields = array(), $name = '', $filter = '' ) {

    if( is_null( $post_id ) ) return '';

    foreach ( $fields as $key => $value ) {

        $field = get_field_object( $key, $post_id, false );
        if( !isset( $field['name'] ) ) continue;

        $op = '==';
        if( is_array( $name ) ){
            $op = $name[0];
            $name = $name[1];
        }

        $is = compare( $field['name'], $op, $name );
        if( !$is ) continue;

        if( !empty( $filter ) ){

            $op = '==';
            if( is_array( $filter ) ){
                $value = ( sizeof( $filter ) === 3 ? $field[$filter[2]] : $value );
                $op = $filter[0];
                $filter = $filter[1];
            }

            $is = compare( $value, $op, $filter );
            if( !$is ) continue;
        }

        return $field['key'];
    }

    return '';
}

/**
* [SET] Remove fields (modifies original array)
*
* @subpackage 2-ACF/FUNCTIONS
*
* @param {array=} group List of fields or Field Group containing a 'fields' attribute containing a list of fields (default is empty array).
* @param {array=} names Single field name or list of names (default is empty array).
* @return {array} Removed field.
* WARNING: this function does not return a new array. The original array is altered.
*/
function scm_field_remove( &$group = array(), $name = '' ) {
	$fields = ( isset( $group['fields'] ) ? $group['fields'] : $group );
	$field = NULL;
	if( !is_array( $fields ) || empty( $fields ) ) return $field;
	$ind = getByValueKey( $fields, $name );
	if( !is_null( $ind ) ){
		$field = array_splice( $fields, $ind, 1 );
		if( isset( $group['fields'] ) )
			$group['fields'] = $fields;
	}
	return $field;
}



/**
* [SET] Move field
*
* @subpackage 2-ACF/FUNCTIONS
*
* @param {array=} group List of fields or Field Group containing a 'fields' attribute containing a list of fields (default is empty array).
* @param {array=} new Single field or list of fields (default is empty array).
* @param {int=} index Index where new fileds are insered (default is 0, first array index).
* @return {array} Modified Field Group.
*/
function scm_field_move( $group = array(), $name = '', $index = 0 ) {

	$fields = ( isset( $group['fields'] ) ? $group['fields'] : $group );
	if( !is_array( $fields ) || empty( $fields ) ) return $group;
	reset( $fields );
	
	if( is_string( $index ) )
		$index = getByValueKey( $fields, $index );

	array_splice( $fields, $index, 0, scm_field_remove( $fields, $name ) );

	if( !isset( $group['fields'] ) )
		return $fields;

	$group['fields'] = $fields;
	return $group;
}

/**
* [SET] Insert fields
*
* @subpackage 2-ACF/FUNCTIONS
*
* @param {array=} group List of fields or Field Group containing a 'fields' attribute containing a list of fields (default is empty array).
* @param {array=} new Single field or list of fields (default is empty array).
* @param {string|int=} index Index where new fileds are insered (default is 0, first array index).
* @return {array} Modified Field Group.
*/
function scm_fields_insert( $group = array(), $nw = array(), $index = 0 ) {
	$nw = toArray( $nw, true );
	$fields = ( isset( $group['fields'] ) ? $group['fields'] : $group );
	if( !is_array( $fields ) || empty( $fields ) ) return $group;
	reset( $fields );
	
	if( is_string( $index ) )
		$index = getByValueKey( $fields, $index );

	foreach ( $nw as $field) {

		array_splice( $fields, $index, 0, array( $field ) );
		
		$index++;
	}
	if( !isset( $group['fields'] ) )
		return $fields;

	$group['fields'] = $fields;
	return $group;
}

/**
* [SET] Modify fields
*
* @subpackage 2-ACF/FUNCTIONS
*
* @param {array=} group List of fields or Field Group containing a 'fields' attribute containing a list of fields (default is empty array).
* @param {array=} names Single field name or list of names (default is empty array).
* @param {array=} attr Array containing attributes and new values (default is empty array).
* @return {array} Modified Field Group.
*/
function scm_fields_modify( $group = array(), $names = array(), $attr = array() ) {
	$names = toArray( $names );
	$fields = ( isset( $group['fields'] ) ? $group['fields'] : $group );
	if( !is_array( $fields ) || empty( $fields ) ) return $group;
	foreach ( $names as $name) {
		$ind = getByValueKey( $fields, $name );
		if( !is_null( $ind ) ){
			foreach ( $attr as $key => $value ) {
				$fields[$ind][$key] = $value;
			}
		}
	}
	if( !isset( $group['fields'] ) )
		return $fields;

	$group['fields'] = $fields;
	return $group;
}

/**
* [SET] Modify fields width
*
* @subpackage 2-ACF/FUNCTIONS
*
* @param {array=} group List of fields or Field Group containing a 'fields' attribute containing a list of fields (default is empty array).
* @param {array=} names Single field name or list of names (default is empty array).
* @param {string=} width Width value to set (default is NULL).
* @return {array} Modified Field Group.
*/
function scm_fields_modify_width( $group = array(), $names = array(), $width = NULL ){
	$names = toArray( $names );
	$fields = ( isset( $group['fields'] ) ? $group['fields'] : $group );
	if( !is_array( $fields ) || empty( $fields ) ) return $group;
	foreach ( $names as $name){
		$ind = getByValueKey( $fields, $name );
		if( !is_null( $ind ) )
			$fields[$ind] = scm_field_modify_width( $fields[$ind], $width );
	}
	
	if( !isset( $group['fields'] ) )
		return $fields;

	$group['fields'] = $fields;
	return $group;
}

/**
* [SET] Modify field width
*
* @subpackage 2-ACF/FUNCTIONS
*
* @param {object=} field Field (default is empty array).
* @param {string=} width Width value to set (default is NULL).
* @return {object} Modified Field.
*/
function scm_field_modify_width( $field = array(), $width = NULL ) {

	if( !isset( $field['wrapper'] ) || !isset( $field['wrapper']['width'] ) || is_null( $width ) ) return $field;
	$field['wrapper']['width'] = $width;

	return $field;
}

/**
* [SET] Modify fields class
*
* @subpackage 2-ACF/FUNCTIONS
*
* @param {array=} group List of fields or Field Group containing a 'fields' attribute containing a list of fields (default is empty array).
* @param {string=} class HTML class to add (default is '').
* @param {bool=} replace Replace current class if true (default is false).
* @return {array} Modified Field Group.
*/
function scm_fields_add_class( $group = array(), $class = '', $replace = false ) {
	$fields = ( isset( $group['fields'] ) ? $group['fields'] : $group );
	if( !is_array( $fields ) || empty( $fields ) ) return $group;

	for ($i=0; $i < sizeof( $fields ); $i++)
		$fields[$i] = scm_field_add_class( $fields[$i], $class, $replace );
	
	if( !isset( $group['fields'] ) )
		return $fields;

	$group['fields'] = $fields;
	return $group;
}

/**
* [SET] Modify field class
*
* @subpackage 2-ACF/FUNCTIONS
*
* @param {object=} field Field (default is empty array).
* @param {string=} class HTML class to add (default is '').
* @param {bool=} replace Replace current class if true (default is false).
* @return {object} Modified Field.
*/
function scm_field_add_class( $field = array(), $class = '', $replace = false ) {

	if( !isset( $field['wrapper'] ) || !isset( $field['wrapper']['class'] ) ) return $field;
	$field['wrapper']['class'] = ( $replace ? $class : ( $field['wrapper']['class'] ? $field['wrapper']['class'] . ' ' . $class : $class ) );

	return $field;
}

/**
* [SET] Remove field
*
* @subpackage 2-ACF/FUNCTIONS
*
* @param {array=} group List of fields or Field Group containing a 'fields' attribute containing a list of fields (default is empty array).
* @param {array=} names Single field name or list of names (default is empty array).
* @return {array} Modified Field Group.
*/
function scm_fields_remove( $group = array(), $names = array() ) {
	$names = toArray( $names );
	$fields = ( isset( $group['fields'] ) ? $group['fields'] : $group );
	if( !is_array( $fields ) || empty( $fields ) ) return $group;
	foreach ( $names as $name) {
		$ind = getByValueKey( $fields, $name );
		if( !is_null( $ind ) ) array_splice( $fields, $ind, 1 );
	}
	if( !isset( $group['fields'] ) )
		return $fields;

	$group['fields'] = $fields;
	return $group;
}

/**
* [SET] Remove fields by prefix
*
* @subpackage 2-ACF/FUNCTIONS
*
* @param {array=} group List of fields or Field Group containing a 'fields' attribute containing a list of fields (default is empty array).
* @param {string=} prefix Fields prefix (default is '').
* @return {array} Modified Field Group.
*/
function scm_fields_remove_by_prefix( $group = array(), $prefix = '' ) {
	$fields = ( isset( $group['fields'] ) ? $group['fields'] : $group );
	if( !is_array( $fields ) || empty( $fields ) ) return $group;
	if( $prefix ){
		$prefs = getAllByValuePrefixKey( $fields, $prefix );
		foreach ( $prefs as $pref) {
			$fields = scm_fields_remove( $fields, $pref['name'] );
		}
	}
	if( !isset( $group['fields'] ) )
		return $fields;

	$group['fields'] = $fields;
	return $group;
}

/**
* [SET] Remove Tab fields
*
* @subpackage 2-ACF/FUNCTIONS
*
* @param {array=} group List of fields or Field Group containing a 'fields' attribute containing a list of fields (default is empty array).
* @return {array} Modified Field Group.
*/
function scm_fields_remove_tabs( $group = array() ) {
	return scm_fields_remove_by_prefix( $group, 'tab-' );
}

/**
* [SET] Remove Messages fields
*
* @subpackage 2-ACF/FUNCTIONS
*
* @param {array=} group List of fields or Field Group containing a 'fields' attribute containing a list of fields (default is empty array).
* @return {array} Modified Field Group.
*/
function scm_fields_remove_messages( $group = array() ) {
	return scm_fields_remove_by_prefix( $group, 'msg-' );
}

/**
* [SET] Remove layout
*
* @subpackage 2-ACF/FUNCTIONS
*
* @param {array=} group List of layouts or Layout Group containing a 'layouts' attribute containing a list of layouts (default is empty array).
* @param {array=} names Single layout name or list of names (default is empty array).
* @return {array} Modified List of  Group.
*/
function scm_layouts_remove( $group = array(), $names = array(), $prefix = 'layout-' ) {
	$names = toArray( $names );
	$layouts = ( isset( $group['layouts'] ) ? $group['layouts'] : $group );
	if( !is_array( $layouts ) || empty( $layouts ) ) return $group;
	foreach ( $names as $name) {
		$ind = getByValueKey( $layouts, $prefix . $name );
		if( !is_null( $ind ) ) array_splice( $layouts, $ind, 1 );
	}
	if( !isset( $group['layouts'] ) )
		return $layouts;

	$group['layouts'] = $layouts;
	return $group;
}

?>
