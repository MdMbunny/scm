<?php

/**
* scm-acf.php.
*
* ACF Fields and Groups base functions.
*
* @link http://www.studiocreativo-m.it
*
* @package SCM
* @subpackage ACF
* @since 1.0.0
*/

/** ACF Font Awesome icons subsets. */
require_once( SCM_DIR_LIBRARY . 'scm-acf-preset-fa.php' );

/** ACF select choices subsets. */
require_once( SCM_DIR_LIBRARY . 'scm-acf-preset-choices.php' );

/** ACF field preset. */
require_once( SCM_DIR_LIBRARY . 'scm-acf-preset.php' );

// ------------------------------------------------------

/** ACF layouts */
require_once( SCM_DIR_LIBRARY . 'scm-acf-fields-layouts.php' );

/** ACF options */
require_once( SCM_DIR_LIBRARY . 'scm-acf-fields-options.php' );

/** ACF groups */
require_once( SCM_DIR_LIBRARY . 'scm-acf-fields-groups.php' );

/** ACF presets */
require_once( SCM_DIR_LIBRARY . 'scm-acf-fields-presets.php' );

/** ACF fields */
require_once( SCM_DIR_LIBRARY . 'scm-acf-fields.php' );

// ------------------------------------------------------
//
// 1.0 ACF Groups
// 		Set Group
// 		Location
// 		Keys
// 		Conditional
// 		Register
// 2.0 ACF Fields
// 		Set Field
// 		Get Field
// 		Get Key by Field Name
// 3.0 ACF Flexible Layout
// 		Set Layout
// 		Layout Preset
// 		Layout Column Selectors
// 		Layout Column Width
// 		Layout Column Link
// 		Layout Column Align
// 		Layout Column Float
// 		Layout Column Overlay
//
// ------------------------------------------------------

// ------------------------------------------------------
// 1.0 ACF GROUPS
// ------------------------------------------------------

/**
* [GET] Field Group
*
* @param {string} name Required. Field Group name.
* @param {string} key Required. Unique key.
* @param {array=} attr Optional. List of attributes (default is empty array).
* @return {array} Field Group settings.
*/
function scm_acf_group( $name, $key, $attr = array() ) {

	if( !$name || !$key ) return;

	$group = array (
		'key' => $key,
		'title' => $name,
		'fields' => array(),
		'location' => array(
			array(
				scm_acf_group_location_rule( 'post' ),
				scm_acf_group_location_rule_not( 'post' ),
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
* [GET] Field Group location group
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
		$location[] = scm_acf_group_location_rule( $val, $param, $cond );

	return $location;
}

/**
* [GET] Field Group location rule
*
* @param {string} value Required. Single location.
* @param {string=} param Location parameter (default is 'post_type').
* @param {string=} cond Location condition (default is '==').
* @return {array} Location rule.
*/
function scm_acf_group_location_rule( $value = NULL, $param = 'post_type', $cond = '==' ) {
	$rule = array();
	if( is_null( $value ) || !isset( $value ) || !$value || !is_string( $value ) ) return $rule;
	
	$value = ( startsWith( $value, 'admin' ) ? 'administrator' : $value );
	$cond = ( $cond ?: '==' );
	$param = ( $param ?: ( $val == 'administrator' ? 'current_user_role' : 'post_type') );

	$rule = array (
		'param' => $param,
		'operator' => $cond,
		'value' => $val,
	);

	return $rule;
}

/**
* [GET] Field Group location rule 'not equal'
*
* @param {string} value Required. Single location.
* @param {string=} param Location parameter (default is 'post_type').
* @return {array} Location rule.
*/
function scm_acf_group_location_rule_not( $value = NULL, $param = 'post_type' ) {
	$rule = array();
	if( is_null( $value ) || !isset( $value ) || !$value || !is_string( $value ) ) return $rule;
	
	return scm_acf_group_location_rule( $value, $param, '!=' );
}

/**
* [GET] Field Group set keys to fields and return
*
* @param {string} key Key base.
* @param {array} list List of fields.
* @return {array} Modified list of fields.
*/
function scm_acf_group_keys( $key, $list ) {

	if( !$key || !$list )
		return array();

	for ( $i = 0; $i < sizeof( $list ); $i++ ) {

		$new = $key . ( substr( $key, -1 ) != '_' ? '_' : '' ) . $list[$i]['key'];
		$list[$i]['key'] = $new;

		if( isset( $list[$i]['layouts'] ) ){
			
			for ( $j = 0; $j < sizeof( $list[$i]['layouts'] ); $j++ ) {
				$lay = $list[$i]['layouts'][$j]['key'] = 'layout_' . hash('ripemd160', $new . $list[$i]['layouts'][$j]['name'] );
				$list[$i]['layouts'][$j]['sub_fields'] = scm_acf_group_keys( $lay, $list[$i]['layouts'][$j]['sub_fields'] );
			}

		}else if( isset( $list[$i]['sub_fields'] ) ){
			$list[$i]['sub_fields'] = scm_acf_group_keys( $new, $list[$i]['sub_fields'] );
		}

		$list[$i]['key'] = 'field_' . hash('ripemd160', $list[$i]['key'] . $list[$i]['type'] );
		$list[$i] = scm_acf_group_conditional( $list[$i], $list );
	}

	return $list;
}

/**
* [GET] Field Group conditional logics merging
*
* @param {array} ... One or more conditional logic array.
* @return {array} Conditional logic array.
*/
function scm_acf_group_condition() {

	// Get arguments
	if( !func_num_args() ) return;
	$logic = func_get_args();

	$arr = array();

	foreach ($logic as $value) {
		if( !$value || !is_array( $value ) ) continue;
		if( !isset( $value[0] ) ){
			$arr[] = $value;
		}else{
			foreach ($value as $sub) {
				if( !$sub || !is_array( $sub ) )
					continue;
				if( !isset( $sub[0] ) ){
					$arr[] = $sub;				
				}else{
					foreach ($sub as $last) {
						if( !$last || !is_array( $last ) )
							continue;
						if( !isset( $last[0] ) )
							$arr[] = $last;
					}
				}
			}
		}
	}

	return $arr;
}

/**
* [GET] Field Group conditional logic
*
* @param {array} group Field Group.
* @param {array} list List of fields.
* @return {array} Modified Field Group.
*/
function scm_acf_group_conditional( $group, $list ) {

	if( !$group || !$list )
		return $group;

	if( !is( $group['conditional_logic'] ) )
		return $group;

	$cond = $group['conditional_logic'];

	for ( $i = 0; $i < sizeof( $cond ); $i++ ) {
		for ( $j = 0; $j < sizeof( $cond[$i] ); $j++ ) {
			$name = $cond[$i][$j]['field'];
			$field = getByValueKey( $list, $name );
			if( !is_null( $field ) )
				$cond[$i][$j]['field'] = $list[$field]['key'];
		}
	}

	$group['conditional_logic'] = $cond;

	return $group;
}

/**
* [SET] Field Group registration
*
* @param {array} group Field Group.
*/
function scm_acf_group_register( $group ) {

	$group['fields'] = scm_acf_group_keys( $group['key'], $group['fields'] );
	$group['key'] = 'group_' . hash('ripemd160', $group['key'] );

	register_field_group( $group );

}

// ------------------------------------------------------
// 2.0 ACF FIELDS
// ------------------------------------------------------

/**
* [GET] Field
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
* @see scm_acf_field_type()
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
	if( is_array( $name ) )
        $def = wp_parse_args( $name, $def );

	$type = ( is_string( $default ) ? $default : ( is_array( $default ) ? ( isset( $default[0] ) ? $default[0] : ( isset( $default['type'] ) ? $default['type'] : 'undefined-field' ) ) : 'undefined-field' ) );

	if( is_asso( $default ) )
		$def = array_merge( $def, $default );

	$field = array (
		'key' => ( $def['name'] ? $def['name'] . '_' : '' ),
		'label' => ( $def['label'] ?: '' ),
		'name' => ( $def['name'] ?: $type ),
		'prefix' => '',
		'instructions' => ( $def['instructions'] ?: '' ),
		'required' => ( $def['required'] ?: 0 ),
		'conditional_logic' => ( $def['logic'] && is( $def['logic'] ) && !is_string( $def['logic'] ) ? array( scm_acf_group_condition( $def['logic'] ) ) : '' ),
		'wrapper' => array (
			'width' => ( is_numeric( $def['width'] ) ? $def['width'] : '' ),
			'class' => ( $def['class'] ? $def['class'] . ' ' : '' ) . $type,
			'id' => '',
		)
	);

    if( $def['width'] === 'required' || $def['logic'] === 'required' )
    	$field['required'] = 1;

    $field = array_merge( $field, scm_acf_field_type( $default ) );

	return $field;
}

/**
* [GET] Field content or fallback from a selection of fields
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
* [GET] Field content or fallback
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
* @param {bool=} no_option Skip field option fallback (default is true).
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
		$field = ( ( !is_null( $field ) ) ? $field : '' );

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

    	if( is_array( $fallback ) ){
    		if( is_array( $field ) )
    			$field = ( sizeof( $field ) > 0 ? $field : '' );
    	}
		
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

        $field = ( !is_null( get_field( $name, 'option' ) ) ? get_field( $name, 'option' ) : '' );

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
* [GET] Field objects by type and filter
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

// ------------------------------------------------------
// 3.0 ACF LAYOUTS
// ------------------------------------------------------

/**
* [GET] Layout
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
* [GET] Insert layouts presets
*
* @see scm_acf_column_selectors()
* @see scm_acf_column_link()
* @see scm_acf_column_overlay()
* @see scm_acf_column_float()
* @see scm_acf_column_align()
* @see scm_acf_column_width()
*
* @param {array=} list Single layout or list of layouts (default is empty array).
* @param {bool=} link Add link preset field (default is false).
* @return {array} Modified list of layouts.
*/
function scm_acf_layouts_preset( $list = array(), $link = 0 ) {

	$row1 = 4 + $link;
	$row2 = 3;

	$list = toArray( $list, true, true);
	if( !$list ) return array();

	for ( $i = 0; $i < sizeof( $list ); $i++ ){
		$list[$i]['sub_fields'] = scm_acf_column_selectors( $list[$i]['sub_fields'], floor( 75/$row2 ), floor( 75/$row2 ), floor( 150/$row2 ) );
		if( $link )
			$list[$i]['sub_fields'] = scm_acf_column_link( $list[$i]['sub_fields'], floor( 100/$row1 ) );
		$list[$i]['sub_fields'] = scm_acf_column_overlay( $list[$i]['sub_fields'], floor( 100/$row1 ) );
		$list[$i]['sub_fields'] = scm_acf_column_float( $list[$i]['sub_fields'], floor( 100/$row1 ) );
		$list[$i]['sub_fields'] = scm_acf_column_align( $list[$i]['sub_fields'], floor( 100/$row1 ) );
		$list[$i]['sub_fields'] = scm_acf_column_width( $list[$i]['sub_fields'], floor( 100/$row1 ) );
	}

	return $list;
}

/**
* [GET] Insert layout selectors preset
*
* @param {array=} subfields Layout subfields (default is empty array).
* @param {int=} w1 Width id selector (default is 30).
* @param {int=} w2 Width class selector (default is 30).
* @param {int=} w3 Width attributes selector (default is 40).
* @return {array} Modified layout subfields.
*/
function scm_acf_column_selectors( $subfields = array(), $w1 = 30, $w2 = 30, $w3 = 40 ) {
	
	array_unshift( $subfields, scm_acf_field( array( 'name'=>'attributes', 'width'=>$w3, 'class'=>'scm-advanced-field' ), 'attributes' ) );
	array_unshift( $subfields, scm_acf_field_class( 'class', 0, $w2 ) );
	array_unshift( $subfields, scm_acf_field_id( 'id', 0, $w1 ) );

	return $subfields;
}

/**
* [GET] Insert layout width preset
*
* @param {array=} subfields Layout subfields (default is empty array).
* @param {int=} width Field width (default is 100).
* @return {array} Modified layout subfields.
*/
function scm_acf_column_width( $list = array(), $width = 100 ) {
	
	array_unshift( $list, scm_acf_field_select( 'column-width', array( 
		'type'=>'2-columns_width',
		'choices'=>array( '1/1' => __( 'Larghezza piena', SCM_THEME ), 'auto' => __( 'Auto', SCM_THEME ) ),
	), $width, 0 ) );

	return $list;
}

/**
* [GET] Insert layout link preset
*
* @param {array=} subfields Layout subfields (default is empty array).
* @param {int=} width Field width (default is 100).
* @return {array} Modified layout subfields.
*/
function scm_acf_column_link( $list = array(), $width = 100 ) {
	array_unshift( $list, scm_acf_field( 'link', array( 'select-template_link', array( 'no' => __( 'Nessun Link', SCM_THEME ) ) ), '', $width ) );
	return $list;
}

/**
* [GET] Insert layout alignment preset
*
* @param {array=} subfields Layout subfields (default is empty array).
* @param {int=} width Field width (default is 100).
* @return {array} Modified layout subfields.
*/
function scm_acf_column_align( $list = array(), $width = 100 ) {
	array_unshift( $list, scm_acf_field( 'alignment', array( 'select-alignment', array( 'default' => __( 'Allineamento generale', SCM_THEME ) ) ), '', $width ) );
	return $list;
}

/**
* [GET] Insert layout float preset
*
* @param {array=} subfields Layout subfields (default is empty array).
* @param {int=} width Field width (default is 100).
* @return {array} Modified layout subfields.
*/
function scm_acf_column_float( $list = array(), $width = 100 ) {
	array_unshift( $list, scm_acf_field_select( 'float', 'float', $width ) );
	return $list;
}

/**
* [GET] Insert overlay float preset
*
* @param {array=} subfields Layout subfields (default is empty array).
* @param {int=} width Field width (default is 100).
* @return {array} Modified layout subfields.
*/
function scm_acf_column_overlay( $list = array(), $width = 100 ) {
	array_unshift( $list, scm_acf_field_select( 'overlay', 'overlay', 20 ) );
	return $list;
}

?>
