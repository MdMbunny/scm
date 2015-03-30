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
		function scm_acf_group_location( $list, $equal = 1, $param = 'post_type' ) {

			$list = ( is_array( $list ) ? $list : array( array( $list, $equal, $param ) ) );
			
			$location = array();

			foreach ($list as $loc) {
				$value = ( isset( $loc[0] ) ? $loc[0] : '' );
				if( !$value || !is_string( $value ) )
					continue;
				$equal = ( !isset( $loc[1] ) || ( isset( $loc[1] ) && $loc[1] ) ? '==' : '!=' );
				$param = ( isset( $loc[2] ) ? $loc[2] : 'post_type' );
				$location[] = array (
					'param' => $param,
					'operator' => $equal,
					'value' => $value,
				);
			}

			return $location;

		}
	}

	// Set Fields Key
	if ( ! function_exists( 'scm_acf_group_keys' ) ) {
		function scm_acf_group_keys( $name, $list ) {

			if( !$name || !$list )
				return [];

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
						
						$lay = $list[$i]['layouts'][$j]['key'] = $new . $list[$i]['layouts'][$j]['name'];
						$list[$i]['layouts'][$j]['sub_fields'] = scm_acf_group_keys( $lay, $list[$i]['layouts'][$j]['sub_fields'] );

					}

				}else if( isset( $list[$i]['sub_fields'] ) ){

					$list[$i]['sub_fields'] = scm_acf_group_keys( $new, $list[$i]['sub_fields'] );

				}

				$list[$i]['key'] = 'field_' . $list[$i]['key'] . $list[$i]['type'];

				//if(stripos($list[$i]['key'], 'repeater')!==false)
					//printPre($list[$i]['name']);

				$list[$i] = scm_acf_group_conditional( $list[$i], $list );
			}

			return $list;
		}
	}


	// Merge Conditional Logics - [[ $object ]] [ $object ] $object
	if ( ! function_exists( 'scm_acf_group_condition' ) ) {
		function scm_acf_group_condition() {

			if( !func_num_args() )
				return;

			$logic = func_get_args();

			$arr = [];

			foreach ($logic as $value) {

				if( !$value || !is_array( $value ) )
					continue;

				$keys = array_keys($value);
				
				if( array_keys($keys) !== $keys ){
					
					$arr[] = $value;

				}else{

					foreach ($value as $sub) {
						if( !$sub || !is_array( $sub ) )
							continue;
						$keys = array_keys($sub);
						if( array_keys($keys) !== $keys ){

							$arr[] = $sub;
						
						}else{

							foreach ($sub as $last) {
								if( !$last || !is_array( $last ) )
									continue;
								$keys = array_keys($last);
								if( array_keys($keys) !== $keys ){

									$arr[] = $last;

								}
							}

						}
					}

				}
			}

			return [ $arr ];
		}
	}

	// Set Fields Conditional Logic
	if ( ! function_exists( 'scm_acf_group_conditional' ) ) {
		function scm_acf_group_conditional( $elem, $list ) {

			if( !$elem || !$list )
				return $elem;

			if( !isset( $elem['conditional_logic'] ) || empty( $elem['conditional_logic'] ) )
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

			/*if( strpos( $group['key'], 'luoghi') !== false )
				consoleLog( $group );*/

			$group['fields'] = scm_acf_group_keys( $group['key'], $group['fields'] );
			$group['key'] = 'group-' . $group['key'];

			//printPre($group['key']);

			register_field_group( $group );

		}
	}

// *****************************************************
// *      2.0 ACF FIELDS
// *****************************************************

	// Set Field
	if ( ! function_exists( 'scm_acf_field' ) ) {
		function scm_acf_field( $name, $type, $label = '', $width = '', $logic = 0, $instructions = '', $required = 0, $class = '' ) {

			if( !isset( $name ) || !$type )
				return;

			/*if( strpos( $name, 'model') !== false )
				consoleLog( $instructions );*/

			//$typ = ( is_string( $type ) ? $type : ( is_array( $type ) && isset( $type[0] ) ? $type[0] : 'undefined' ) );

			$field = array (
				'key' => ( $name ? $name . '_' : '' ),
				'label' => ( $label ?: 'Field' ),
				'name' => ( $name ?: $type ),
				'prefix' => '',
				'instructions' => ( $instructions ?: '' ),
				'required' => ( $required ?: 0 ),
				'conditional_logic' => ( isset( $logic ) && !is_string( $logic ) && !empty( $logic ) ? scm_acf_group_condition( $logic ) : '' ),
				'wrapper' => array (
					'width' => ( is_numeric( $width ) ? $width : '' ),
					'class' => ( is_string( $type ) ? $type : ( is_array( $type ) && isset( $type[0] ) ? $type[0] : 'undefined-field' ) . ( $class ? ' ' . $class : '' ) ),
					'id' => '',
				)
			);

	        if( $width === 'required' || $logic === 'required' || $instructions === 'required' )
	        	$field['required'] = 1;

	        $field = array_merge( $field, scm_acf_field_type( $type ) );

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
	        		return 'post e target non trovati';     	

	        	$id = ( $target ?: $post->ID );

	        	if( !$id )
	        		return 'id non trovato';

	        	if( function_exists( 'get_field' ) )
	        		$field = ( !is_null( get_field( $name, $id ) ) ? get_field( $name, $id ) : '' );
	        	else
	        		$field = $fallback;

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

        		if( function_exists( 'get_field' ) )
		        	$field = ( !is_null( get_field( $name, 'option' ) ) ? get_field( $name, 'option' ) : '' );
		        else
	        		$field = $fallback;

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


    if ( ! function_exists( 'scm_field_objects' ) ) {
        function scm_field_objects( $post_id, $fields = [], $type = 'text', $filter = [] ) {
            $arr = [];
            foreach ($fields as $key => $value) {
                
                $field = get_field_object($key, $post_id );

                if ( $field['type'] == $type ) {

                    if( !empty( $filter ) ){

                        foreach ( $filter as $k => $v ) {
                            if( !isset( $field[ $k ] ) || $field[ $k ] !== $v )
                                continue;
                            if( is_string( $field[ $k ] ) && strpos( $field[ $k ], $v ) === false )
                                continue;
                            if ( $field[ $k ] !== $v )
                                continue;
                        }
                    }

                    $arr[] = $field;
                }
            }
            return $arr;
        }
    }

    /*if ( ! function_exists( 'scm_acf_field_keybytype' ) ) {
        function scm_acf_field_keybytype( $fields = [], $type = '' ) {

            $arr = [];

            foreach ($fields as $key => $field) {
                $k = explode( '_', $key );
                if( $k[ sizeof($k) - 1 ] == $type )
                    $arr[] = $key;
            }

            return $arr;

        }
    }

    if ( ! function_exists( 'scm_acf_field_keybyneedle' ) ) {
        function scm_acf_field_keybyneedle( $fields = [], $needle = '' ) {

            $arr = [];

            foreach ($fields as $key => $field) {
                if( strpos( $key, $needle ) !== false )
                    $arr[] = $key;
            }

            return $arr;

        }
    }*/


// *****************************************************
// *      3.0 ACF FLEXIBLE LAYOUTS
// *****************************************************


	if ( ! function_exists( 'scm_acf_layout' ) ) {
		function scm_acf_layout( $name, $type = 'block', $label = 'Layout', $fields = array() ) {

			if( !$name )
				return;

			$layout = array (
				'key' => $name,
				'name' => 'layout-' . $name,
				'label' => $label,
				'display' => $type,
				'sub_fields' => $fields,
				'min' => '',
				'max' => '',
			);

			return $layout;

		}
	}

?>
