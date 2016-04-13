<?php
/**
 * @package SCM
 */

// *****************************************************
// *	ACF
// *****************************************************

/*
*****************************************************
*
*   1.0 ACF Field Group
**		Field Group
**		Location
**		Keys
**		Conditional
**		Register
*
*   2.0 ACF Field
**		Set Field
**		Get Field
** 		Get Key by Field Name
*
*   3.0 ACF Flexible Layout
*
*****************************************************
*/

// *****************************************************
// *      1.0 ACF FIELD GROUPS
// *****************************************************

    // Set Field Group
	if ( ! function_exists( 'scm_acf_group' ) ) {
		function scm_acf_group( $name, $key, $position = 'normal' ) {

			if( !$name || !$key )
				return;

			$group = array (
				'key' => $key,
				'title' => $name,
				'fields' => array(),
				'location' => array(
					array(
						array(
							'param' => 'post_type',
							'operator' => '==',
							'value' => 'post',
						),
						array(
							'param' => 'post_type',
							'operator' => '!=',
							'value' => 'post',
						),
					),
				),
				'menu_order' => 0,
				'position' => $position,
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

			if( is_array( $position ) )
	            $group = array_merge( $group, $position );

	        return $group;

		}
	}

	// Set Field Group Locations
	if ( ! function_exists( 'scm_acf_group_location' ) ) {
		function scm_acf_group_location( $list = array(), $param = 'post_type', $equal = '==' ) {

			$list = ( is_array( $list ) ? $list : array( $list, $equal, $param ) );
			if( !ifexists( $list ) || !isset( $list[0] ) )
				return array();

			$list = ( !is_array( $list[0] ) ? array( $list ) : $list );
			
			$location = array();

			foreach ( $list as $loc ) {				
				$val = ( isset( $loc[0] ) ? $loc[0] : '' );
				$val = ( strpos( $val, 'admin' ) === 0 ? 'administrator' : $val );
				if( !$val || !is_string( $val ) )
					continue;
				$equal = ( isset( $loc[1] ) ? $loc[1] : '==' );
				$param = ( isset( $loc[2] ) ? $loc[2] : ( $val == 'administrator' ? 'current_user_role' : 'post_type') );
				$location[] = array (
					'param' => $param,
					'operator' => $equal,
					'value' => $val,
				);
			}

			return $location;

		}
	}

	// Set Fields Key
	if ( ! function_exists( 'scm_acf_group_keys' ) ) {
		function scm_acf_group_keys( $name, $list ) {

			if( !$name || !$list )
				return array();

			$key = $name;

			for ( $i = 0; $i < sizeof( $list ); $i++ ) {

				//if(strpos($key, 'types') !== false){
				/*if( !isset($list[$i]['key']) ){
					printPre('----------------');
					printPre($name);
					printPre($list[$i]);
				}*/
				
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

				//if(stripos($list[$i]['key'], 'repeater')!==false)
					//printPre($list[$i]['name']);


				$list[$i] = scm_acf_group_conditional( $list[$i], $list );
			}

			return $list;
		}
	}


	// Merge Conditional Logics - (( $object )) array( $object ) $object
	if ( ! function_exists( 'scm_acf_group_condition' ) ) {
		function scm_acf_group_condition() {

			if( !func_num_args() )
				return;

			$logic = func_get_args();

			$arr = array();

			foreach ($logic as $value) {

				if( !$value || !is_array( $value ) )
					continue;
				
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

								if( !isset( $last[0] ) ){

									$arr[] = $last;

								}
							}
						}
					}
				}
			}

			return $arr;
		}
	}

	// Set Fields Conditional Logic
	if ( ! function_exists( 'scm_acf_group_conditional' ) ) {
		function scm_acf_group_conditional( $elem, $list ) {

			if( !$elem || !$list )
				return $elem;

			if( !is( $elem['conditional_logic'] ) )
				return $elem;

			$cond = $elem['conditional_logic'];

			for ( $i = 0; $i < sizeof( $cond ); $i++ ) {
				for ( $j = 0; $j < sizeof( $cond[$i] ); $j++ ) {
					$name = $cond[$i][$j]['field'];
					$field = getByValueKey( $list, $name );
					if( $field !== false )
						$cond[$i][$j]['field'] = $list[$field]['key'];
				}
			}

			$elem['conditional_logic'] = $cond;

			return $elem;
		}
	}

	// Register Field Group
	if ( ! function_exists( 'scm_acf_group_register' ) ) {
		function scm_acf_group_register( $group ) {

			$group['fields'] = scm_acf_group_keys( $group['key'], $group['fields'] );
			$group['key'] = 'group_' . hash('ripemd160', $group['key'] );

			register_field_group( $group );

		}
	}

// *****************************************************
// *      2.0 ACF FIELDS
// *****************************************************

	// Set Field
	if ( ! function_exists( 'scm_acf_field' ) ) {
		function scm_acf_field( $name, $default, $label = '', $width = '', $logic = 0, $instructions = '', $required = 0, $class = '' ) {

			if( !isset( $name ) || !isset( $default ) )
				return;

			$def = get_defined_vars();
			
			if( is_array( $name ) ){
                $def = wp_parse_args( $name, $def );

	        }

			$defaultname = ( is_string( $default ) ? $default : ( is_array( $default ) ? ( isset( $default[0] ) ? $default[0] : ( isset( $default['type'] ) ? $default['type'] : 'undefined-field' ) ) : 'undefined-field' ) );

			$field = array (
				'key' => ( $def['name'] ? $def['name'] . '_' : '' ),
				'label' => ( $def['label'] ?: ( is_array( $default ) && isset( $default['label'] ) ? $default['label'] : '' ) ),
				'name' => ( $def['name'] ?: $defaultname ),
				'prefix' => '',
				'instructions' => ( $def['instructions'] ?: '' ),
				'required' => ( $def['required'] ?: 0 ),
				'conditional_logic' => ( is( $def['logic'] ) && !is_string( $def['logic'] ) ? array( scm_acf_group_condition( $def['logic'] ) ) : '' ),
				'wrapper' => array (
					'width' => ( is_numeric( $def['width'] ) ? $def['width'] : '' ),
					'class' => ( $def['class'] ? $def['class'] . ' ' : '' ) . $defaultname,
					'id' => '',
				)
			);

	        if( $def['width'] === 'required' || $def['logic'] === 'required' || $def['instructions'] === 'required' )
	        	$field['required'] = 1;

	        $field = array_merge( $field, scm_acf_field_type( $default ) );

			return $field;

		}
	}

	// Get Field
    if ( ! function_exists( 'scm_field' ) ) {
        function scm_field( $name, $fallback = '', $target = '', $no_option = 0, $before = '', $after = '' ) {
			
			// Get ACF Field through: Post Option > default? > General Option > default? > Fallback

			if( !function_exists( 'get_field' ) )
				return $fallback;
        	
        	if( $target != 'option' ){

	        	global $post;

	        	if( !$post && !$target )
	        		return __( 'post e target non trovati', SCM_THEME );

	        	$id = ( $target ?: $post->ID );

	        	if( !$id )
	        		return __( 'id non trovato', SCM_THEME );

	        	//if( function_exists( 'get_field' ) )
	        		$field = ( ( !is_null( get_field( $name, $id ) ) ) ? get_field( $name, $id ) : '' );
	        		if( !$field && $no_option == -1 )
	        			return $fallback;
	        	//else
	        		//$field = $fallback;

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

        		//if( function_exists( 'get_field' ) )
		        	$field = ( !is_null( get_field( $name, 'option' ) ) ? get_field( $name, 'option' ) : '' );
		        //else
	        		//$field = $fallback;

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
    }

    // Get Fields by type and filter
    if ( ! function_exists( 'scm_field_objects' ) ) {
        function scm_field_objects( $post_id, $fields = array(), $type = 'text', $filter = array() ) {
            $arr = array();
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
    }

    // Get Key by Field Name
    if ( ! function_exists( 'scm_field_key' ) ) {
        function scm_field_key( $post_id, $fields = array(), $name = '', $filter = '' ) {

            if( !isset( $post_id ) )
                return '';

            foreach ( $fields as $key => $value ) {
                
                $field = get_field_object( $key, $post_id, false );

                if( !isset( $field['name'] ) )
                    continue;

                $op = '==';
                if( is_array( $name ) ){
                    $op = $name[0];
                    $name = $name[1];
                }

                $is = stringOperator( $field['name'], $op, $name );

                if( !$is )
                    continue;

                if( !empty( $filter ) ){

                    $op = '==';
                    if( is_array( $filter ) ){
                        $value = ( sizeof( $filter ) === 3 ? $field[$filter[2]] : $value );
                        $op = $filter[0];
                        $filter = $filter[1];
                    }

                    $is = stringOperator( $value, $op, $filter );

                    if( !$is )
                        continue;
                }

                return $field['key'];

            }

            return '';
        }
    }


// *****************************************************
// *      3.0 ACF FLEXIBLE LAYOUTS
// *****************************************************


	if ( ! function_exists( 'scm_acf_layout' ) ) {
		function scm_acf_layout( $name, $type = 'block', $label = 'Layout', $min = '', $max = '', $fields = array() ) {

			if( !$name )
				return;

			$layout = array (
				'key' => $name,
				'name' => 'layout-' . $name,
				'label' => $label,
				'display' => $type,
				'sub_fields' => $fields,
				'min' => $min,
				'max' => $max,
			);

			return $layout;

		}
	}

	// LAYOUT PRESET
	if ( ! function_exists( 'scm_acf_layouts_preset' ) ) {
		function scm_acf_layouts_preset( $list = array(), $link = 0 ) {

			$row1 = 4 + $link;
			$row2 = 3;

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
	}

	// COLUMN SELECTORS
	if ( ! function_exists( 'scm_acf_column_selectors' ) ) {
		function scm_acf_column_selectors( $list = array(), $w1 = 30, $w2 = 30, $w3 = 40 ) {
			
			array_unshift( $list, scm_acf_field( array( 'name'=>'attributes', 'width'=>$w3, 'class'=>'scm-advanced-field' ), 'attributes' ) );
			array_unshift( $list, scm_acf_field_class( 'class', 0, $w2 ) );
			array_unshift( $list, scm_acf_field_id( 'id', 0, $w1 ) );

			return $list;

		}
	}

	// LAYOUT COLUMNS SELECTORS
	/*if ( ! function_exists( 'scm_acf_layouts_selectors' ) ) {
		function scm_acf_layouts_selectors( $list = array(), $w1 = 30, $w2 = 30, $w3 = 40 ) {
			

			for ( $i = 0; $i < sizeof( $list ); $i++ ){

				$list[$i]['sub_fields'] = scm_acf_column_selectors( $list[$i]['sub_fields'], $w1, $w2, $w3 );

			}

			return $list;
		}
	}*/

	// COLUMN WIDTH
	if ( ! function_exists( 'scm_acf_column_width' ) ) {
		function scm_acf_column_width( $list = array(), $width = 100 ) {
			
			array_unshift( $list, scm_acf_field_select_column_width( 'column-width', 0, $width, 0, array( '1/1' => __( 'Larghezza piena', SCM_THEME ), 'auto' => __( 'Auto', SCM_THEME ) ) ) );

			return $list;

		}
	}

	// LAYOUT COLUMNS WIDTH
	/*if ( ! function_exists( 'scm_acf_layouts_width' ) ) {
		function scm_acf_layouts_width( $list = array(), $width = 100 ) {
			

			for ( $i = 0; $i < sizeof( $list ); $i++ ){

				$list[$i]['sub_fields'] = scm_acf_column_width( $list[$i]['sub_fields'], $width );

			}

			return $list;
		}
	}*/

	// COLUMN LINK
	if ( ! function_exists( 'scm_acf_column_link' ) ) {
		function scm_acf_column_link( $list = array(), $width = 100 ) {
			
			array_unshift( $list, scm_acf_field( 'link', array( 'select-template_link', array( 'no' => __( 'Nessun Link', SCM_THEME ) ) ), __( 'Link', SCM_THEME ), $width ) );

			return $list;

		}
	}

	// LAYOUT LINK
	/*if ( ! function_exists( 'scm_acf_layouts_link' ) ) {
		function scm_acf_layouts_link( $list = array(), $width = 100 ) {
			

			for ( $i = 0; $i < sizeof( $list ); $i++ ){
			
				$list[$i]['sub_fields'] = scm_acf_column_link( $list[$i]['sub_fields'], $width );

			}

			return $list;
		}
	}*/

	// COLUMN ALIGN
	if ( ! function_exists( 'scm_acf_column_align' ) ) {
		function scm_acf_column_align( $list = array(), $width = 100 ) {
						
			array_unshift( $list, scm_acf_field( 'alignment', array( 'select-alignment', array( 'default' => __( 'Allineamento generale', SCM_THEME ) ) ), '', $width ) );
			
			return $list;

		}
	}

	// LAYOUT ALIGN
	/*if ( ! function_exists( 'scm_acf_layouts_align' ) ) {
		function scm_acf_layouts_align( $list = array(), $width = 100 ) {
			

			for ( $i = 0; $i < sizeof( $list ); $i++ ){

				$list[$i]['sub_fields'] = scm_acf_column_align( $list[$i]['sub_fields'], $width );

			}

			return $list;
		}
	}*/

	// COLUMN FLOAT
	if ( ! function_exists( 'scm_acf_column_float' ) ) {
		function scm_acf_column_float( $list = array(), $width = 100 ) {
			
			array_unshift( $list, scm_acf_field_select_float( 'float', 0, $width, 0, __( ' - (se auto)', SCM_THEME ) ) );
			
			return $list;

		}
	}

	// LAYOUT FLOAT
	/*if ( ! function_exists( 'scm_acf_layouts_float' ) ) {
		function scm_acf_layouts_float( $list = array(), $width = 100 ) {
			

			for ( $i = 0; $i < sizeof( $list ); $i++ ){

				$list[$i]['sub_fields'] = scm_acf_column_float( $list[$i]['sub_fields'], $width );

			}

			return $list;
		}
	}*/

	// COLUMN OVERLAY
	if ( ! function_exists( 'scm_acf_column_overlay' ) ) {
		function scm_acf_column_overlay( $list = array(), $width = 100 ) {
			
			array_unshift( $list, scm_acf_field_select_overlay( 'overlay', 0, 20, 0 ) );
			
			return $list;

		}
	}

	// LAYOUT OVERLAY
	/*if ( ! function_exists( 'scm_acf_layouts_overlay' ) ) {
		function scm_acf_layouts_overlay( $list = array(), $width = 100 ) {
			

			for ( $i = 0; $i < sizeof( $list ); $i++ ){

				$list[$i]['sub_fields'] = scm_acf_column_overlay( $list[$i]['sub_fields'], $width );

			}

			return $list;
		}
	}*/
?>
