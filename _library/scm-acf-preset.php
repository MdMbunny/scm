<?php
/**
 * @package SCM
 */

// *****************************************************
// *	ACF PRESETS
// *****************************************************

/*
*****************************************************
*
*	1.0 Field Type
*	2.0 Font Awesome Choices
*	3.0 Field Choices
**		3.1 Field Choices Presets
*
*****************************************************
*/

// *****************************************************
// *****************************************************
// *****************************************************

// *  1.0 Field Type

// *****************************************************
// *****************************************************
// *****************************************************


/* 		
* 		scm_acf_field_type()
*
* ——————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————
* 		
*		'message'				$message = ''								$eschtml = 0 					$newlines = '' | 'br' | 'wpautop'
*		'tab'					$place = 'top | side' || 0 | 1
*			'-side'					$place = 'side'
*
* ——————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————
*
*		'repeater'				$button = '+'							$min = '' 						$max = '' 						$layout = 'row | table | block'				$sub = array()
* ———      	'-block':				$layout = 'block'
* ———      	'-table':				$layout = 'table'
*
*		'flexible'				$button = '+'							$min = '' 						$max = '' 						$layouts = array()
*
* ——————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————
*
*		'number'				$default = ''			$placeholder = ''				$prepend = ''						$append = ''					$min = ''							$max = ''						$step = ''						$read = 0					$disabled = 0
* ———		'positive':				$min = 0
* ———      	'negative':				$max = 0
* ———      	'option':				$min = -1
* ———      	'pixel':				$step = 1 		$append = 'px'
* ———      	'percent':				$min = 0 		$max = 100 		$append = '%'
* ———      	'alpha':				$min = 0 		$max = 1 		$step = .1 			$place = '1'
* ———      	'second':				$min = 0 		$step = .1 		$append = 'sec'		$place = '1'
* ———      	'msecond':				$min = 0 		$step = 100		$append = 'ms'		$place = '1000'
* ———		'-max'					$max = 9999
* ———		'-min'					$min = -9999
* ———		'-pos'					$min = 0
* ———		'-neg'					$max = 0
* ———		'-read'					$read-only = 1
* ———		'-disabled'				$disabled = 1
*
* ——————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————
*
*		'text'					$default = ''					$placeholder = ''				$prepend = ''					$append = '' 						$maxlength = ''					$readonly = 0				$disabled = 0
* ———		'id':			 		$place = 'ID' 					$prepend = '#'	
* ———		'class':			 	$place = 'Class'				$prepend = '.' 
* ———		'attributes':			$prepend = 'Attributes'			$place = 'data-href="www.example.com" data-target="_blank"'
* ———		'name':			 		$place = 'senza titolo' 		$prepend = 'Nome' 		$maxl = 30		
* ———		'link':			 		$prepend = 'Web' 				$place = 'http://www.esempio.com'
* ———		'video':			 	$prepend = 'YouTube' 			$place = 'https://www.youtube.com/watch?v=BVKXzNV6Z0c&list=PL4F1941886E6F2A16'
* ———		'-read'					$readonly = 1
* ———		'-disabled'				$disabled = 1
*
*		'textarea'				$default = ''					$placeholder = ''				$rows = 8 						$maxlength = ''					$newlines = 'wpautop | br | '		$readonly = 0				$disabled = 0
* ———		'-no'					$newlines = ''
* ———		'-br'					$newlines = 'br'
* ———		'-read'					$readonly = 1
* ———		'-disabled'				$disabled = 1
*
*		'editor'				$default = ''					$tabs = 'all | visual'			$toolbar = 'normal | basic'		$media = 0
* ———		'-visual'				$tabs = 'visual'
* ———		'-basic'				$toolbar = 'basic'
* ———		'-media'				$media = 1
*
*		'limiter'				$max = 350			$display = 0
* ———		'-chars'				$display = 1
*
* ——————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————
*
*		'true_false'			$default = 0 || 1
*
*		'select'				$default = '' || array(]	* 						$placeholder = ''									$ajax = 0							$null = 0						$ui = 0						$multiple = 0 				$read = 0				$disabled = 0
* ———		'select2'					$ui = 1
*		'checkbox'				$default = '' || array(]	*						$layout = 'vertical | horizontal' || 0 | 1
*		'radio'					$default = '' || array(]	*						$layout = 'vertical | horizontal' || 0 | 1			$more = 0							$save = $more || 0
* ———		'-default'				add 'default' 	=> 	'Default' 	to array('choices']
* ———		'-no'					add 'no' 		=> 	'-' 		to array('choices']
* ———		'-multi'				$multiple | $more = 1
* ———		'-read'					$read = 1
* ———		'-disabled'				$disabled = 1
* ———		'-horizontal'			$layout = 1
*
* ———		* $default: 			array 			>	 field['choices'] = $default + choices 		field['default_value'] = field['choices'][0]
*									string 		 	>	 field['choices'][0] = $default				field['default_value'] = field['choices'][0]
*									string exists 	>	 -											field['default_value'] = $default
*
* ——————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————
*
*		'object'				$types = '' || array(]					$taxes = '' || array(] 				$placeholder = ''					$null = 0					$multiple = 0				$return = 'object | id'	|| 0 | 1		$filters = array( 'search', 'post_type', 'taxonomy' )		$ui = 1
*		'object-rel'			$types = '' || array(]					$taxes = '' || array(]				$placeholder = ''					$elements = '' 				$max = 1					$return = 'object | id'	|| 0 | 1		$filters = array( 'search', 'post_type', 'taxonomy' )
* ———		'-id'						$return = 'id'
* ———		'-search'					$filters[] = 'search'
* ———		'-null'						$null = 1
*		'object-link'			$types = '' || array(]					$taxes = '' || array(]				$placeholder = ''					$null = 0 					$multiple = 0
* ———		'objects'					$multiple = 1 | $max = 0			
*
* ——————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————
*
*		'category | tag | taxonomy'				$taxes = ''						$add = 0				$save = $multiple					$null = 0 					$return = 'object'
* ———		'categories | tags | taxonomies' 		$multiple = 1
* ———		'-id'									$return = 'id'
* ———		'-add'									$add = 1
* ———		'-{tax}'								$taxes = '{tax}'
*
* ——————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————
*
*		'gallery'				$library = 'all | uploadedTo' || 0 | 1		$preview = 'thumbnail' 		$min = 0 				$max = 0 				$minwidth = 0 			$maxwidth = 0 			$minheight = 0 			$maxheight = 0 			$minsize = 0				$maxsize = '' 				$mime = 'jpg,png'
*
*		'file'					$library = 'all | uploadedTo' || 0 | 1		$minsize = ''						$maxsize = '' 			$mime = '*'		$return = 'array | url | id'
*		'image'					$library = 'all | uploadedTo' || 0 | 1		$preview = 'thumbnail' 		$minwidth = 0 			$maxwidth = 0 			$minheight = 0 		$maxheight = 0 		$minsize = 0				$maxsize = '' 				$mime = 'jpg,png' 			$return = 'array | url | id'
* ———		'-url'						$return = 'url'
* ———		'-id'						$return = 'id'
*
* ——— 		* $mime: 		'file' 	>	'pdf, ppt, pptx, xls, xlsx, doc, docx, pages, numbers, keynote, txt, rtf, jpg, png, gif, zip, rar'
*
* ——————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————
*
*		'icon'					$default = 'star'	 						$filter = array( 'social', 'job', ... )		$save = 'class | unicode | element | object'		$enqueue' = 0			$null = 0					
*		'color'					$default = '' || '#000000' etc.
*		'date'					$return = 'Y-m-d' 							$display = 'd F Y'					$firstday' = 1
*		'datetime'				$picker = 'slider | select' 				$date = 'd F Y'						$time' = 'hh:mm' 				$week = 0 					$save = 1 				$get = 0
*		'time'					$picker = 'slider | select' 				$time' = 'hh:mm'		 			$save = 1 						$get = 0
*
* ——————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————
*/

	if ( ! function_exists( 'scm_acf_field_to3' ) ) {
		function scm_acf_field_to3( $a, $n, $t, $d ) {
			return ( isset( $a[$n] ) ? $a[$n] : ( isset( $a[$t] ) ? $a[$t] : $d ) );
		}
	}


	if ( ! function_exists( 'scm_acf_field_type' ) ) {
		function scm_acf_field_type( $elem, $name = '' ) {

			if( !$elem )
				return;

			$field = array();
			$arg = array();

			if( is_array( $elem ) ){

				$el = scm_acf_field_to3( $elem, 0, 'type', '' );

				if( !$el )
					return;

				$arg = $elem;
				$elem = $el;
			}
			
			$choices = array();

			if( strpos( $elem, '-default' ) !== false ){
				$choices['default'] = 'Default';
				$elem = str_replace( '-default', '', $elem);
			}
	
			if( endsWith( $elem, '-no' ) ){
				$choices['no'] = '-';
				$elem = str_replace( '-no', '', $elem);
			}

			$type = $elem;
			$needle = strpos( $elem, '-' );
			$extra = '';

			if( $needle > 0 ){
				$type = substr( $elem, 0, $needle );
				$extra = str_replace( $type, '', $elem);
			}
			
			switch ( $type ) {

				case 'message':

	        		$field = array(
						'type' 					=> 'message',
						'message' 				=> scm_acf_field_to3( $arg, 1, 'placeholder', '' ),
						'esc_html' 				=> scm_acf_field_to3( $arg, 2, 'eschtml', 0 ),
						'new_lines' 			=> scm_acf_field_to3( $arg, 3, 'newlines', '' ),
					);

	        	break;

				case 'tab':
					
	        		$field = array(
						'type' 					=> 'tab',
						'placement' 			=> scm_acf_field_to3( $arg, 1, 'placeholder', ( strpos( $extra , '-left' ) !== false ? 'left' : 'top' ) ),
					);

	        	break;

	        	case 'true_false':

	        		$field = array(
						'type' 					=> 'true_false',
						'default_value' 		=> scm_acf_field_to3( $arg, 1, 'default', 0 ),
					);

				break;

	        	case 'select':
	        	case 'select2':

	        		$default = scm_acf_field_to3( $arg, 1, 'default', '' );
	        		$choices = scm_acf_field_choices( $default, $choices );

	        		$field = array(
						'type' 					=> 'select',
						'choices' 				=> $choices['choices'],
						'default_value' 		=> $choices['default_value'],
						'placeholder' 			=> scm_acf_field_to3( $arg, 2, 'placeholder', '' ),
						'ajax' 					=> scm_acf_field_to3( $arg, 3, 'ajax', 0 ),
						'allow_null' 			=> scm_acf_field_to3( $arg, 4, 'null', 0 ),
						'ui' 					=> ( $type == 'select2' ? 1 : scm_acf_field_to3( $arg, 5, 'ui', 0 ) ),
						'multiple' 				=> scm_acf_field_to3( $arg, 6, 'multi', ( strpos( $extra , '-multi' ) !== false ? 1 : 0 ) ),
						'readonly' 				=> scm_acf_field_to3( $arg, 7, 'read', ( strpos( $extra , '-read' ) !== false ? 1 : 0 ) ),
						'disabled' 				=> scm_acf_field_to3( $arg, 8, 'disabled', ( strpos( $extra , '-disabled' ) !== false ? 1 : 0 ) ),
						'preset' 				=> str_replace( array( '-multi', '-read', '-disabled' ), '', $elem),
					);

	        	break;

	        	case 'checkbox':

	        		$default = scm_acf_field_to3( $arg, 1, 'default', '' );
	        		$layout = scm_acf_field_to3( $arg, 1, '' );
	        		$choices = scm_acf_field_choices( $default, $choices );
	        		
	        		$field = array(
						'type' 					=> 'checkbox',
						'choices' 				=> $choices['choices'],
						'default_value' 		=> $choices['default_value'],
						'layout' 				=> ( ( $layout && $layout !== 'vertical' ) || strpos( $extra , '-horizontal' ) !== false ? 'horizontal' : 'vertical' ),
						'preset' 				=> str_replace( '-horizontal', '', $elem),
					);

	        	break;

	        	case 'radio':

	        		$default = scm_acf_field_to3( $arg, 1, 'default', '' );
	        		$layout = scm_acf_field_to3( $arg, 1, '' );
	        		$choices = scm_acf_field_choices( $default, $choices );
	        		$more = scm_acf_field_to3( $arg, 3, 'more', ( strpos( $extra , '-multi' ) !== false ? 1 : 0 ) );
	        		
	        		$field = array(
						'type' 					=> 'radio',
						'choices' 				=> $choices['choices'],
						'default_value' 		=> $choices['default_value'],
						'other_choice' 			=> $more,
						'save_other_choice' 	=> scm_acf_field_to3( $arg, 4, 'save', ( isset( $arg[3] ) ? $more : 0 ) ),
						'layout' 				=> ( ( $layout && $layout !== 'vertical' ) || strpos( $extra , '-horizontal' ) !== false ? 'horizontal' : 'vertical' ),
						'preset' 				=> str_replace( array('-multi', '-horizontal'), '', $elem),
					);

	        	break;

	        	case 'object':
	        	case 'objects':

	        		$typ = ( strpos( $extra , '-link' ) !== false ? 'page_link' : ( strpos( $extra , '-rel' ) !== false ? 'relationship' : 'post_object' ) );
	  	        		
					$field = array(
	        			'type' 					=> $typ,
						'post_type' 			=> toArray( scm_acf_field_to3( $arg, 1, 'types', '' ), 0, 1 ),
						'taxonomy' 				=> toArray( scm_acf_field_to3( $arg, 2, 'taxes', '' ), 0, 1 ),
						'placeholder' 			=> scm_acf_field_to3( $arg, 3, 'placeholder', '' ),
					);

					switch ( $typ ) {
						case 'post_object':
							$field['allow_null'] = scm_acf_field_to3( $arg, 4, 'null', ( strpos( $extra , '-null' ) !== false ? 1 : 0 ) );
							$field['multiple'] = ( $type == 'objects' ? 1 : scm_acf_field_to3( $arg, 5, 'multi', 0 ) );
							$field['return_format'] = ( scm_acf_field_to3( $arg, 6, 'return', 'object' ) !== 'object' ? 'id' : ( strpos( $extra , '-id' ) !== false ? 'id' : 'object' ) );
							$field['filters'] = toArray( scm_acf_field_to3( $arg, 7, 'filters', ( strpos( $extra , '-search' ) !== false ? 'search' : '' ) ), 0, 1 );
							$field['ui'] = scm_acf_field_to3( $arg, 8, 'ui', 1 );
						break;
						
						case 'page_link':
							$field['allow_null'] = scm_acf_field_to3( $arg, 4, 'null', ( strpos( $extra , '-null' ) !== false ? 1 : 0 ) );
							$field['multiple'] = ( $type == 'objects' ? 1 : scm_acf_field_to3( $arg, 5, 'multi', 0 ) );
						break;

						case 'relationship':
							$field['elements'] = scm_acf_field_to3( $arg, 4, 'elements', '' );
							$field['max'] = ( $type == 'objects' ? 0 : scm_acf_field_to3( $arg, 5, 'max', 1 ) );
							$field['return_format'] = ( scm_acf_field_to3( $arg, 6, 'return', 'object' ) !== 'object' ? 'id' : ( strpos( $extra , '-id' ) !== false ? 'id' : 'object' ) );
							$field['filters'] = toArray( scm_acf_field_to3( $arg, 7, 'filters', ( strpos( $extra , '-search' ) !== false ? 'search' : '' ) ), 0, 1 );
						break;
					}						

	        	break;
				
	        	case 'tag':
	        	case 'tags':
	        	case 'category':
	        	case 'categories':
	        	case 'taxonomy':
	        	case 'taxonomies':      		
					
					$multi = ( strpos( $type, 's' ) !== false ?: 0 );
					$add = scm_acf_field_to3( $arg, 2, 'add', 0 );
					$save = ( $add ?: scm_acf_field_to3( $arg, 3, 'save', 0 ) );

	        		$field = array(
						'type' 						=> 'taxonomy',
						'taxonomy' 					=> scm_acf_field_to3( $arg, 1, 'taxes', ( str_replace( array( '-id', '-' ), '', $extra ) ?: 'category' ) ),
						'multiple' 					=> $multi,
						'load_save_terms' 			=> $save,
						'allow_null' 				=> scm_acf_field_to3( $arg, 4, 'null', 0 ),
						'return_format' 			=> ( scm_acf_field_to3( $arg, 5, 'return', 'object' ) !== 'object' ? 'id' : ( strpos( $extra , '-id' ) !== false ? 'id' : 'object' ) ),
						'field_type' 				=> ( $multi ? ( $save ? 'checkbox' : 'multi_select' ) : ( $save ? 'radio' : 'select' ) ),
						'add_term' 					=> $add
					);

	        	break;

	        	case 'file':
	        		
	        		$field = array(
						'type' 						=> 'file',
						'library' 					=> ( scm_acf_field_to3( $arg, 1, 'library', 'all' ) !== 'all' ? 'uploadedTo' : 'all' ),
						'min_size' 					=> scm_acf_field_to3( $arg, 2, 'minsize', '' ),
						'max_size' 					=> scm_acf_field_to3( $arg, 3, 'maxsize', '' ),
						'return_format' 			=> scm_acf_field_to3( $arg, 5, 'return', ( strpos( $extra , '-id' ) !== false ? 'id' : ( strpos( $extra , '-url' ) !== false ? 'url' : 'array' ) ) ),
					);

	        	break;

	        	case 'gallery':
	        		
	        		$field = array(
						'type' 						=> 'gallery',
						'library' 					=> ( scm_acf_field_to3( $arg, 1, 'library', 'all' ) !== 'all' ? 'uploadedTo' : 'all' ),
						'preview_size' 				=> scm_acf_field_to3( $arg, 2, 'preview', 'thumbnail' ),
						'min' 						=> scm_acf_field_to3( $arg, 3, 'min', 0 ),
						'max' 						=> scm_acf_field_to3( $arg, 4, 'max', 0 ),
						'min_width' 				=> scm_acf_field_to3( $arg, 5, 'minwidth', 0 ),
						'max_width' 				=> scm_acf_field_to3( $arg, 6, 'maxwidth', 0 ),
						'min_height' 				=> scm_acf_field_to3( $arg, 7, 'minheight', 0 ),
						'max_height' 				=> scm_acf_field_to3( $arg, 8, 'maxheight', 0 ),
						'min_size' 					=> scm_acf_field_to3( $arg, 9, 'minsize', 0 ),
						'max_size' 					=> scm_acf_field_to3( $arg, 10, 'maxsize', 0 ),
						'mime_types' 				=> scm_acf_field_to3( $arg, 11, 'mime', 'jpg, png, JPG, PNG, gif, GIF' ),
					);

	        	break;
				
				case 'image':
	        		
	        		$field = array(
						'type' 						=> 'image',
						'library' 					=> ( scm_acf_field_to3( $arg, 1, 'library', 'all' ) !== 'all' ? 'uploadedTo' : 'all' ),
						'preview_size' 				=> scm_acf_field_to3( $arg, 2, 'preview', 'thumbnail' ),
						'min_width' 				=> scm_acf_field_to3( $arg, 3, 'minwidth', 0 ),
						'max_width' 				=> scm_acf_field_to3( $arg, 4, 'maxwidth', 0 ),
						'min_height' 				=> scm_acf_field_to3( $arg, 5, 'minheight', 0 ),
						'max_height' 				=> scm_acf_field_to3( $arg, 6, 'maxheight', 0 ),
						'min_size' 					=> scm_acf_field_to3( $arg, 7, 'minsize', 0 ),
						'max_size' 					=> scm_acf_field_to3( $arg, 8, 'maxsize', 0 ),
						'mime_types' 				=> scm_acf_field_to3( $arg, 9, 'mime', '' ),
						'return_format' 			=> scm_acf_field_to3( $arg, 10, 'return', ( strpos( $extra , '-id' ) !== false ? 'id' : ( strpos( $extra , '-url' ) !== false ? 'url' : 'array' ) ) ),
					);

	        	break;

	        	case 'icon':

	        		$default = scm_acf_field_to3( $arg, 1, 'default', 'fa-star' );
	        		$no = isset( $choices['no'] );
	        		$filter_group = '';
	        		$new = '';
	        		
	        		$is_filter = strpos( $default, '_' );
	        		if( $is_filter !== false ){
	        			$new = substr( $default, 0, $is_filter );
	        			$filter_group = substr( $default, $is_filter + 1 );
	        			$default = $new;
	        		}

	        		$field = array(
	        			'type' 						=> 'font-awesome',
	        			'default_value' 			=> ( strpos( $default, 'fa-' ) === 0 ? '' : 'fa-' ) . $default,
						'filter' 					=> scm_acf_field_to3( $arg, 2, 'filter', '' ),
						'save_format' 				=> scm_acf_field_to3( $arg, 3, 'save', 'class' ),
						'enqueue_fa' 				=> scm_acf_field_to3( $arg, 4, 'enqueue', 0 ),
						'allow_null' 				=> scm_acf_field_to3( $arg, 5, 'null', 0 ),
						'fa_live_preview' 			=> 1,
						'filter_group' 				=> $filter_group,
						'no_option' 				=> $no,
					);

	        	break;


	        	case 'date':

	        		$field = array(
						'type' 						=> 'date_picker',
						'return_format' 			=> scm_acf_field_to3( $arg, 1, 'return', 'd-m-Y' ),
						'display_format' 			=> scm_acf_field_to3( $arg, 2, 'display', 'd F Y' ),
						'first_day' 				=> scm_acf_field_to3( $arg, 3, 'firstday', 1 ),
					);

	        	break;

				case 'datetime':

	        		$field = array(
						'type' 						=> 'date_time_picker',
						'show_date' 				=> 1,
						'picker' 					=> scm_acf_field_to3( $arg, 1, 'picker',  'select' ),
						'date_format' 				=> scm_acf_field_to3( $arg, 2, 'date',  'd F y' ),
						'time_format' 				=> scm_acf_field_to3( $arg, 3, 'time',  'H:i' ),
						'show_week_number' 			=> scm_acf_field_to3( $arg, 4, 'week',  0 ),
						'save_as_timestamp' 		=> scm_acf_field_to3( $arg, 5, 'save',  1 ),
						'get_as_timestamp' 			=> scm_acf_field_to3( $arg, 5, 'get',  0 ),

					);

	        	break;

	        	case 'time':

	        		$field = array(
						'type' 						=> 'date_time_picker',
						'show_date' 				=> 0,
						'picker' 					=> scm_acf_field_to3( $arg, 1, 'picker', 'select' ),
						'time_format' 				=> scm_acf_field_to3( $arg, 2, 'time', 'hh:mm' ),
						'save_as_timestamp' 		=> scm_acf_field_to3( $arg, 3, 'save', 1 ),
						'get_as_timestamp' 			=> scm_acf_field_to3( $arg, 4, 'get', 0 ),
						'date_format' 				=> '',
						'show_week_number' 			=> 0,

					);

	        	break;

	        	case 'color':

	        		$field = array(
						'type' => 'color_picker',
						'default_value' 			=> scm_acf_field_to3( $arg, 1, 'default', '' ),
					);

	        	break;
				
	        	case 'number':
	        	case 'positive':
	        	case 'negative':
	        	case 'option':
	        	case 'pixel':
	        	case 'percent':
	        	case 'alpha':
	        	case 'second':
	        	case 'msecond':

	        		switch ( $type ) {
	        			case 'positive': 	$min = 0; 																			break;
	        			case 'negative': 	$max = 0; 																			break;
	        			case 'option': 		$min = -1; 																			break;
	        			case 'pixel': 		$step = 1; 			$append = 'px';													break;
	        			case 'percent':		$min = 0;			$max = 100;			$append = '%';								break;
	        			case 'alpha': 		$place = '1';		$min = 0; 			$max = 1;	 		$step = .1; 			break;
	        			case 'second': 		$place = '1';		$min = 0; 			$step = .1; 		$append = 'sec';		break;
	        			case 'msecond': 	$place = '1000';	$min = 0;			$step = 100;		$append = 'ms';			break;
	        		}

	        		$field = array(
						'type' => 'number',
						'default_value' 			=> scm_acf_field_to3( $arg, 1, 'default', '' ),
						'placeholder' 				=> scm_acf_field_to3( $arg, 2, 'placeholder', ( isset( $place ) ? $place : '' ) ),
						'prepend' 					=> scm_acf_field_to3( $arg, 3, 'prepend', ( isset( $prepend ) ? $prepend : '' ) ),
						'append' 					=> scm_acf_field_to3( $arg, 4, 'append', ( isset( $append ) ? $append : '' ) ),
						'min' 						=> scm_acf_field_to3( $arg, 5, 'min', ( isset( $min ) ? $min : ( strpos( $extra , '-pos' ) !== false ? 0 : ( strpos( $extra , '-min' ) !== false ? -9999 : '' ) ) ) ),
						'max' 						=> scm_acf_field_to3( $arg, 6, 'max', ( isset( $max ) ? $max : ( strpos( $extra , '-neg' ) !== false ? 0 : ( strpos( $extra , '-max' ) !== false ? 9999 : '' ) ) ) ),
						'step' 						=> scm_acf_field_to3( $arg, 7, 'step', ( isset( $step ) ? $step : 1 ) ),
						'readonly' 					=> scm_acf_field_to3( $arg, 8, 'read', ( isset( $read ) ? $read : ( strpos( $extra , '-read' ) !== false ? 1 : 0 ) ) ),
						'disabled' 					=> scm_acf_field_to3( $arg, 9, 'disabled', ( isset( $dis ) ? $dis : ( strpos( $extra , '-disabled' ) !== false ? 1 : 0 ) ) ),
					);

	        	break;

	        	case 'text':
	        	case 'id':
	        	case 'class':
	        	case 'attributes':
	        	case 'name':
	        	case 'link':
	        	case 'video':

	        		switch ( $type ) {
	        			case 'id': 				$place = 'ID'; 				$prepend = '#';																			break;
	        			case 'class': 			$place = 'Class';			$prepend = '.'; 																		break;
	        			case 'attributes': 		$prepend = 'Attributes';	$place = 'data-href="www.example.com" data-target="_blank"';							break;
	        			case 'name': 			$place = 'senza titolo'; 	$prepend = 'Nome'; 		$maxl = 30;														break;
	        			case 'link': 			$prepend = 'Web'; 			$place = 'http://www.esempio.com';														break;
	        			case 'video': 			$prepend = 'YouTube'; 		$place = 'https://www.youtube.com/watch?v=BVKXzNV6Z0c&list=PL4F1941886E6F2A16';			break;
	        		}

					$field = array(
	        			'type' 						=> 'text',
						'default_value' 			=> scm_acf_field_to3( $arg, 1, 'default', '' ),
						'placeholder' 				=> scm_acf_field_to3( $arg, 2, 'placeholder', ( isset( $place ) ? $place : '' ) ),
						'prepend' 					=> scm_acf_field_to3( $arg, 3, 'prepend', ( isset( $prepend ) ? $prepend : '' ) ),
						'append' 					=> scm_acf_field_to3( $arg, 4, 'append', ( isset( $append ) ? $append : '' ) ),
						'maxlength' 				=> scm_acf_field_to3( $arg, 5, 'maxlength', ( isset( $maxl ) ? $maxl : '' ) ),
						'readonly' 					=> scm_acf_field_to3( $arg, 6, 'readonly', ( isset( $read ) ? $read : ( strpos( $extra , '-read' ) !== false ? 1 : 0 ) ) ),
						'disabled' 					=> scm_acf_field_to3( $arg, 7, 'disabled', ( isset( $dis ) ? $dis : ( strpos( $extra , '-disabled' ) !== false ? 1 : 0 ) ) ),
					);

				break;

	        	case 'textarea':

					$field = array(
						'type' 						=> 'textarea',
						'default_value' 			=> scm_acf_field_to3( $arg, 1, 'default', '' ),
						'placeholder' 				=> scm_acf_field_to3( $arg, 2, 'placeholder', '' ),
						'rows' 						=> scm_acf_field_to3( $arg, 3, 'rows', 8 ),
						'maxlength' 				=> scm_acf_field_to3( $arg, 4, 'maxlength', '' ),
						'new_lines' 				=> scm_acf_field_to3( $arg, 5, 'newlines', ( strpos( $extra , '-no' ) !== false ? '' : ( strpos( $extra , '-br' ) !== false ? 'br' : 'wpautop' ) ) ),
						'readonly' 					=> scm_acf_field_to3( $arg, 6, 'readonly', ( strpos( $extra , '-read' ) !== false ? 1 : 0 ) ),
						'disabled' 					=> scm_acf_field_to3( $arg, 7, 'disabled', ( strpos( $extra , '-disabled' ) !== false ? 1 : 0 ) ),
					);

	        	break;

	        	case 'editor':

	        		$field = array(
	        			'type' 						=> 'wysiwyg',
	        			'default_value' 			=> scm_acf_field_to3( $arg, 1, 'default', '' ),
						'tabs' 						=> scm_acf_field_to3( $arg, 2, 'tabs', ( strpos( $extra, '-visual' ) !== false ? 'visual' : 'all' ) ),
						'toolbar' 					=> scm_acf_field_to3( $arg, 3, 'toolbar', ( strpos( $extra, '-basic' ) !== false ? 'basic' : 'normal' ) ),
						'media_upload' 				=> scm_acf_field_to3( $arg, 4, 'media', ( strpos( $extra, '-media' ) !== false ? 1 : 0 ) ),
					);

	        	break;

	        	case 'limiter':

	        		$field = array(
	        			'type' 						=> 'limiter',
						'character_number' 			=> scm_acf_field_to3( $arg, 1, 'max', ( isset( $max ) ? $max : 350 ) ),
						'display_characters' 		=> scm_acf_field_to3( $arg, 2, 'display', ( isset( $chars ) ? $chars : ( strpos( $extra, '-chars' ) !== false ? 1 : 0 ) ) ),
					);

	        	break;

	        	case 'repeater':

	        		$field = array(
						'type' => 'repeater',
						'button_label' => scm_acf_field_to3( $arg, 1, 'button', 'Aggiungi' ),
						'min' => scm_acf_field_to3( $arg, 2, 'min', '' ),
						'max' => scm_acf_field_to3( $arg, 3, 'max', '' ),
						'layout' => scm_acf_field_to3( $arg, 4, 'layout', ( strpos( $extra , '-block' ) !== false ? 'block' : ( strpos( $extra , '-table' ) !== false ? 'table' : 'row' ) ) ),
						'sub_fields' => scm_acf_field_to3( $arg, 5, 'sub', array() ),
					);

	        	break;
				
				case 'flexible':

	        		$field = array(
						'type' => 'flexible_content',
						'button_label' => scm_acf_field_to3( $arg, 1, 'button', '+' ),
						'min' => scm_acf_field_to3( $arg, 2, 'min', '' ),
						'max' => scm_acf_field_to3( $arg, 3, 'max', '' ),
						'layouts' => scm_acf_field_to3( $arg, 4, 'layouts', array() ),
					);

	        	break;

	        	default:
	        		$field = array(
						'type' => 'text',
					);
	        	break;
	        }
			
			return $field;

		}
	}


// *****************************************************
// *****************************************************
// *****************************************************

// *  2.0 Font Awesome Choices

// *****************************************************
// *****************************************************
// *****************************************************

	if ( ! function_exists( 'scm_acf_field_fa_preset' ) ) {
        function scm_acf_field_fa_preset( $group = '', $list = '' ){

        	global $SCM_fa;

        	$choices = array();

        	if( isset( $SCM_fa[$group] ) ){

        		if( is_string( $list ) )
        			$list = array( $list );
        		
        		if( isset( $list ) && !empty( $list ) && is_array( $list ) ){

					foreach ( $list as $value) {
    					if( isset( $SCM_fa[$group][$value] ) )
        					$choices = array_merge( $choices, $SCM_fa[$group][$value]['choices'] );
    				}
        		}
				
				if( empty( $choices ) ){
	        		foreach ( $SCM_fa[$group] as $key => $value) {
	    				$choices = array_merge( $choices, $value['choices'] );
	    			}
				}
        	}

        	return $choices;

        }
    }



// *****************************************************
// *****************************************************
// *****************************************************

// *  3.0 Field Choices

// *****************************************************
// *****************************************************
// *****************************************************


	if ( ! function_exists( 'scm_acf_field_choices' ) ) {
        function scm_acf_field_choices( $default, $choices = array() ){
        	
        	$key = '';

        	if( isset( $default ) ){

				if( is_array( $default ) && !empty( $default ) ){

					$choices = array_merge( $choices, $default );

				}else{
					$key = $default;
				}
			}

			if( $key === '' && sizeof( $choices ) ){
	        	reset( $choices );
	        	$key = key( $choices );
	        }

			
			return array( 'choices' => $choices, 'default_value' => $key );
		}
	}



// *****************************************************
// *****************************************************
// *****************************************************

// *  3.1 Field Choices Preset

// *****************************************************
// *****************************************************
// *****************************************************

	// get default select options
	if ( ! function_exists( 'scm_acf_field_choices_preset' ) ) {
        function scm_acf_field_choices_preset( $list, $get = '' ){

        	global $post;

        	$choices = array();
		        				
			if( strpos( $list, 'types_' ) !== false ):
	    		global $SCM_types;

	    		if( strpos( $list, '_complete') !== false )
	    			$choices = $SCM_types['complete'];
	    		else if( strpos( $list, '_private') !== false )
	    			$choices = $SCM_types['private'];
	    		else if( strpos( $list, '_public') !== false )
	    			$choices = $SCM_types['public'];
	    		else
	    			$choices = $SCM_types['all'];

	    	elseif( strpos( $list, 'wp_menu' ) !== false ):

	    		$menus = get_registered_nav_menus();
	    		$lang = '';
	    		$def = '';

	    		/*if( function_exists('pll_get_post_language') )
            		$lang = pll_get_post_language( $post->ID );

            	if( function_exists('pll_default_language') )
            		$def = pll_default_language();

            	$needle = ( $def === $lang ? $def : ( $lang ? '___' . $lang : $def ) );*/

				foreach ( $menus as $location => $description ) {

					//if( ( strpos( $location, '___' ) === false && $needle == $def ) || strpos( $location, $needle ) !== false )
						$choices[$location] = $description;
				};

				$choices['no'] = __( 'Nessun Menu', SCM_THEME );

			elseif( strpos( $list, 'templates_' ) !== false ):
				$pos = strpos( $list, 'templates_' ) + strlen( 'templates_' );
				$type = substr( $list, $pos ) . SCM_TEMPLATE_APP;

				$temps = get_posts( array( 'post_type' => $type, 'orderby' => 'menu_order date', 'posts_per_page' => -1 ) );
				foreach ( $temps as $temp):
					//$choices[ '_' . $temp->ID ) = $temp->post_title;
					$choices[$temp->post_name] = $temp->post_title;
				endforeach;

			elseif( strpos( $list, 'side_position' ) !== false ):
				if( strpos( $list, 'side_position_no' ) !== false ):
					$str = str_replace( '_', '', str_replace( 'side_position_no', '', substr( $list, strpos( $list, 'side_position_no'))));
					$str = ( $str ?: __( 'Elemento', SCM_THEME ) );
					$choices = array(
						'no' => __( 'Nascondi', SCM_THEME ) . ' ' . $str,
						'top' => $str . ' ' . __( 'Sopra', SCM_THEME ),
						'right' => $str . ' ' . __( 'Destra', SCM_THEME ),
						'bottom' => $str . ' ' . __( 'Sotto', SCM_THEME ),
						'left' => $str . ' ' . __( 'Sinistra', SCM_THEME ),
					);
				else:
					$str = str_replace( '_', '', str_replace( 'side_position', '', substr( $list, strpos( $list, 'side_position'))));
					$str = ( $str ?: __( 'Elemento', SCM_THEME ) );
					$choices = array(
						'top' => $str . ' ' . __( 'Sopra', SCM_THEME ),
						'right' => $str . ' ' . __( 'Destra', SCM_THEME ),
						'bottom' => $str . ' ' . __( 'Sotto', SCM_THEME ),
						'left' => $str . ' ' . __( 'Sinistra', SCM_THEME ),
					);
				endif;
					
			elseif( strpos( $list, 'position_menu' ) !== false ):
				$choices = array(
					'top' => __( 'Menu sopra al logo', SCM_THEME ),
					'inline' => __( 'Menu affianco al logo', SCM_THEME ),
					'bottom' => __( 'Menu sotto al logo', SCM_THEME ),
				);

			elseif( strpos( $list, 'sticky_active' ) !== false ):
				$choices = array(
					'self' => __( 'Sticky Self', SCM_THEME ),
					'plus' => __( 'Sticky Plus', SCM_THEME ),
					'head' => __( 'Sticky Head', SCM_THEME ),
				);

			elseif( strpos( $list, 'sticky_attach' ) !== false ):
				$choices = array(
					'nav-top' => __( 'Attach to main navigation TOP', SCM_THEME ),
					'nav-bottom' => __( 'Attach to main navigation BOTTOM', SCM_THEME ),
				);

			elseif( strpos( $list, 'home_active' ) !== false ):
				$choices = array(
					'both' => __( 'Menu + Sticky', SCM_THEME ),
					'sticky' => __( 'Solo Sticky', SCM_THEME ),
					'menu' => __( 'Solo Menu', SCM_THEME ),
					'no' => __( 'Solo Toggle', SCM_THEME ),
				);

			elseif( strpos( $list, 'branding_header' ) !== false ):
				$choices = array(
					'text' => __( 'Usa il nome del sito', SCM_THEME ),
					'img' => __( 'Usa un\'immagine', SCM_THEME ),
				);

			elseif( strpos( $list, 'head_position' ) !== false ):
				$choices = array(
					'menu_down'			=> __( 'Menu sotto a Logo', SCM_THEME ),
					'menu_right'		=> __( 'Menu alla destra del Logo', SCM_THEME ),
				);

			elseif( strpos( $list, 'head_social_position' ) !== false ):
				$choices = array(
					'top' => __( 'Sopra al menu (se menu inline)', SCM_THEME ),
					'bottom' => __( 'Sotto al menu (se menu inline)', SCM_THEME ),
				);
					
			elseif( strpos( $list, 'image_format' ) !== false ):
				$choices = array(
					'norm' => __( 'Normale', SCM_THEME ),
					'quad' => __( 'Quadrata', SCM_THEME ),
					'full' => __( 'Full Width', SCM_THEME ),
				);
			
			elseif( strpos( $list, 'size_icon' ) !== false ):
				$choices = array(
					'16x16' => '16x16',
					'32x32' => '32x32',
					'64x64' => '64x64',
					'128x128' => '128x128',
					'256x256' => '256x256',
				);

			elseif( strpos( $list, 'archive_mode' ) !== false ):
				$choices = array(
					'single' => __( 'Singoli', SCM_THEME ),
					'archive' => __( 'Archivio', SCM_THEME ),
				);
			
			elseif( strpos( $list, 'archive_complete' ) !== false ):
				$choices = array(
					'partial' => __( 'Archivio parziale', SCM_THEME ),
					'complete' => __( 'Archivio completo', SCM_THEME ),
				);
			
			elseif( strpos( $list, 'archive_pagination' ) !== false ):
				$choices = array(
					'yes' => __( 'Paginazione', SCM_THEME ),
					'all' => __( 'Pulsante ALL', SCM_THEME ),
					'more' => __( 'Pulsante MORE', SCM_THEME ),
					'no' => __( 'No paginazione', SCM_THEME ),
				);
			
			elseif( strpos( $list, 'gallerie_button' ) !== false ):
				$choices = array(
					'img' => __( 'Thumb', SCM_THEME ),
					'txt' => __( 'Testo', SCM_THEME ),
					'section' => __( 'Sezione', SCM_THEME ),
				);

			// +++ todo: non più 2, con _complete, ma spostati in alto, dove c'è template_ e lo fai simile
			// chiami tamplate_link{type}, recuperi type, in qualche modo risali alle fields di quel type, becchi la field link/url/file e aggiungi la choice Link Oggetto
			elseif( strpos( $list, 'template_link' ) !== false ):
				if( strpos( $list, '_complete' ) !== false ):

					$choices = array(
						'template' => __( 'Link Template (tutto)', SCM_THEME ),
						'template-single' => __( 'Link Template (singoli elementi)', SCM_THEME ),
						'link' => __( 'Inserisci Link (tutto)', SCM_THEME ),
						'link-single' => __( 'Inserisci Link (singoli elementi)', SCM_THEME ),
					);
				else:
					$choices = array(
						'self' => __( 'Link Oggetto', SCM_THEME ),
						'template' => __( 'Link Template', SCM_THEME ),
						'link' => __( 'Link Inserito', SCM_THEME ),
					);
				endif;
			
			elseif( strpos( $list, 'luogo_data' ) !== false ):
				$choices = array(
					'name' => __( 'Nome', SCM_THEME ),
					'address' => __( 'Indirizzo', SCM_THEME ),
					'num' => __( 'Numeri', SCM_THEME ),
					'email' => __( 'Email', SCM_THEME ),
					'link' => __( 'Link', SCM_THEME ),
				);
			
			elseif( strpos( $list, 'contact_link' ) !== false ):
				$choices = array(
					'web:' => __( 'web:', SCM_THEME ),
					'support:' => __( 'support:', SCM_THEME ),
				);

			elseif( strpos( $list, 'contact_email' ) !== false ):
				$choices = array(
					'e-mail:' => __( 'e-mail:', SCM_THEME ),
				);

			elseif( strpos( $list, 'contact_num' ) !== false ):
				$choices = array(
					'Tel.' => __( 'Tel.', SCM_THEME ),
					'Mobile' => __( 'Mobile', SCM_THEME ),
					'Fax' => __( 'Fax', SCM_THEME ),
				);

			elseif( strpos( $list, 'rassegne_type' ) !== false ):
				$choices = array(
					'file' => __( 'File', SCM_THEME ),
					'link' => __( 'Link', SCM_THEME ),
				);

			elseif( strpos( $list, 'links_type' ) !== false ):
				$choices = array(
					'page' 	=> __( 'Pagina', SCM_THEME ),
					'link' 	=> __( 'Link', SCM_THEME ),
				);

			elseif( strpos( $list, 'waitfor' ) !== false ):
				$choices = array(
					//'window' => 'Window',
					'images' => 'Images',
					'sliders' => 'Sliders',
					'maps' => 'Maps',
				);

			elseif( strpos( $list, 'positive_negative' ) !== false ):
	        	$choices = array(
					'off' => __( 'Versione positiva', SCM_THEME ),
					'on' => __( 'Versione negativa', SCM_THEME ),
				);

	        elseif( strpos( $list, 'show' ) !== false ):
	        	if( strpos( $list, 'options_show' ) !== false ):
					$choices = array(
						'hide' 		=> __( 'Nascondi Opzioni', SCM_THEME ),
						'options' 	=> __( 'Opzioni', SCM_THEME ),
						'advanced' 	=> __( 'Opzioni avanzate', SCM_THEME ),
					);
				else:
		        	$choices = array(
						'on' => __( 'Mostra', SCM_THEME ),
						'off' => __( 'Nascondi', SCM_THEME ),
					);
		        endif;

	        elseif( strpos( $list, 'hide' ) !== false ):
	        	$choices = array(
	        		'off' => __( 'Nascondi', SCM_THEME ),
					'on' => __( 'Mostra', SCM_THEME ),
				);

			elseif( strpos( $list, 'enable' ) !== false ):
	        	$choices = array(
					'on' => __( 'Abilita', SCM_THEME ),
					'off' => __( 'Disabilita', SCM_THEME ),
				);

	        elseif( strpos( $list, 'disable' ) !== false ):
	        	$choices = array(
	        		'off' => __( 'Disabilita', SCM_THEME ),
					'on' => __( 'Abilita', SCM_THEME ),
				);

			elseif( strpos( $list, 'ordertype' ) !== false ):
	        	$choices = array(
	        		'DESC' => __( 'Discendente', SCM_THEME ),
	        		'ASC' => __( 'Ascendente', SCM_THEME ),
				);

	        elseif( strpos( $list, 'orderby' ) !== false ):
	        	$choices = array(
	        		'date' => __( 'Data', SCM_THEME ),
					'title' => __( 'Titolo', SCM_THEME ),
					'modified' => __( 'Data modifica', SCM_THEME ),
					'name' => __( 'Slug', SCM_THEME ),
					'type' => __( 'Tipo', SCM_THEME ),
					'rand' => __( 'Random', SCM_THEME ),
					'meta_value' => __( 'Custom Field', SCM_THEME ),
				);

	        elseif( strpos( $list, 'line_style' ) !== false ):
	        	$choices = array(
	        		'no' => __( 'Vuoto', SCM_THEME ),
	        		'line' => __( 'Linea', SCM_THEME ),
	        		'dashed' => __( 'Tratteggiato', SCM_THEME ),
	        		//'dotted' => __( 'Punteggiato'
				);

	        elseif( strpos( $list, 'line_cap' ) !== false ):
	        	$choices = array(
	        		'round' => __( 'Tondeggiato', SCM_THEME ),
	        		'square' => __( 'Squadrato', SCM_THEME ),
	        		'butt' => __( 'Squadrato a filo', SCM_THEME ),
				);
			
			elseif( strpos( $list, 'list_type' ) !== false ):
	        	$choices = array(
	        		'none' => __( 'Non puntato', SCM_THEME ),
	        		'disc' => __( 'Cerchio', SCM_THEME ),
	        		'circle' => __( 'Cerchio vuoto', SCM_THEME ),
	        		'square' => __( 'Quadrato', SCM_THEME ),
	        		'decimal' => __( 'Decimali', SCM_THEME ),
	        		'decimal-leading-zero' => __( 'Decimali con zero', SCM_THEME ),
	        		'lower-latin' => __( 'Lettere minuscole', SCM_THEME ),
	        		'upper-latin' => __( 'Lettere maiuscole', SCM_THEME ),
					'lower-roman' => __( 'Roman minuscolo', SCM_THEME ),
					'upper-roman' => __( 'Roman maiuscolo', SCM_THEME ),
				);
	        
	        elseif( strpos( $list, 'alignment' ) !== false ):

	        	if( strpos( $list, 'vertical_alignment' ) !== false ){
		        	
		        	$choices = array(
						'top' => __( 'Alto', SCM_THEME ),
						'middle' => __( 'Centro', SCM_THEME ),
						'bottom' => __( 'Basso', SCM_THEME ),
					);

				}else if( strpos( $list, 'txt_alignment' ) !== false ){
		        	
		        	$choices = array(
						'left' => __( 'Sinistra', SCM_THEME ),
						'right' => __( 'Destra', SCM_THEME ),
						'center' => __( 'Centrato', SCM_THEME ),
						'justify' => __( 'Giustificato', SCM_THEME ),
					);

				}else{

		        	$choices = array(
						'left' => __( 'Sinistra', SCM_THEME ),
						'right' => __( 'Destra', SCM_THEME ),
						'center' => __( 'Centrato', SCM_THEME ),
					);

		        };

			elseif( strpos( $list, 'float' ) !== false ):
	        	$choices = array(
	        		'float-none' => __( 'No Float', SCM_THEME ),
					'float-left' => __( 'Float Sinistra', SCM_THEME ),
					'float-right' => __( 'Float Destra', SCM_THEME ),
					'float-center' => __( 'Float Centrato', SCM_THEME ),
				);

	        elseif( strpos( $list, 'overlay' ) !== false ):
	        	$choices = array(
					'no-overlay' => __( 'No Overlay', SCM_THEME ),
					'overlay' => __( 'Overlay', SCM_THEME ),
					'underlay' => __( 'Underlay', SCM_THEME ),
				);

			elseif( strpos( $list, 'units' ) !== false ):
	        	$choices = array(
	        		'px' => 'px',
	        		'%' => '%',
					'em' => 'em',
				);

	        elseif( strpos( $list, 'headings' ) !== false ):

	        	$max = array(
					'h2' => __( 'Primario', SCM_THEME ),
					'h3' => __( 'Secondario', SCM_THEME ),
					'h4' => __( 'Terziario', SCM_THEME ),
				);

	        	$min = array(
					'p' => 'p',
					'span' => 'span',
					'strong' => 'strong',
				);

	        	$low = array(
					'p' => 'p',
					'span' => 'span',
					'strong' => 'strong',
					'div' => 'div',
					'h6' => 'h6',
					'h5' => 'h5',
					'h4' => 'h4',
					'h3' => 'h3',
					'h2' => 'h2',
					'h1' => 'h1',
				);

	        	$choices = array(
					'h1' => 'h1',
					'h2' => 'h2',
					'h3' => 'h3',
					'h4' => 'h4',
					'h5' => 'h5',
					'h6' => 'h6',
					'.h7' => '.h7',
					'.h8' => '.h8',
					'.h9' => '.h9',
					'.h0' => '.h0',
					'strong' => 'strong',
					'div' => 'div',
					'span' => 'span',
					'p' => 'p',
				);

				if( strpos( $list, 'headings_low' ) !== false ){
					$choices = $low;
				}else if( strpos( $list, 'headings_min' ) !== false ){
					$choices = $min;
				}else if( strpos( $list, 'headings_max' ) !== false ){
					$choices = $max;
				};

			elseif( strpos( $list, 'columns_width' ) !== false ):
				$choices = array(
					'1/1' => '1/1',
					'1/2' => '1/2',
					'1/3' => '1/3',
					'2/3' => '2/3',
					'1/4' => '1/4',
					'3/4' => '3/4',
					'1/5' => '1/5',
					'2/5' => '2/5',
					'3/5' => '3/5',
					'4/5' => '4/5',
					'1/6' => '1/6',
					'5/6' => '5/6',
				);

			elseif( strpos( $list, 'txt_size' ) !== false ):
				$choices = array(
					'100%' => 'Normal',
					'60%' => 'XXX-Small',
					'70%' => 'XX-Small',
					'80%' => 'X-Small',
					'90%' => 'Smaller',
					'95%' => 'Small',
					'105%' => 'Medium',
					'110%' => 'Large',
					'120%' => 'X-Large',
					'130%' => 'XX-Large',
					'140%' => 'XXX-Large',
					'150%' => 'Big',
					'160%' => 'X-Big',
					'170%' => 'XX-Big',
					'180%' => 'XXX-Big',
					'200%' => 'Huge',
				);

			elseif( strpos( $list, 'txt_font_size' ) !== false ):
				$choices = array(
					'16px' => 'Normal',
					'10px' => 'XXX-Small',
					'11px' => 'XX-Small',
					'12px' => 'X-Small',
					'13px' => 'Smaller',
					'15px' => 'Small',
					'17px' => 'Medium',
					'18px' => 'Large',
					'19px' => 'X-Large',
					'20px' => 'XX-Large',
					'21px' => 'XXX-Large',
					'22px' => 'Big',
					'23px' => 'X-Big',
					'24px' => 'XX-Big',
					'25px' => 'XXX-Big',
					'26px' => 'Huge',
				);
			
			elseif( strpos( $list, 'layout_main' ) !== false ):
				$choices = array(
					'responsive'		=> 'Responsive',
					'full'				=> 'Full Width',
				);
			
			elseif( strpos( $list, 'responsive_events' ) !== false ):



				if( strpos( $list, '_width' ) !== false ):

					$choices = array(
						'500px'			=> 'Mobile Min',
						'600px'			=> 'Mobile Mid',
						'700px'			=> 'Mobile',
						'800px'			=> 'Tablet Portrait',
						'940px'			=> 'Notebook',
						'1030px'		=> 'Tablet Landscape',
						'1120px'		=> 'Desktop',
					);
				
				else:		

					$choices = array(
						'smartmin'		=> 'Mobile Min',
						'smartmid'		=> 'Mobile Mid',
						'smart'			=> 'Mobile',
						'portrait'		=> 'Tablet Portrait',
						'notebook'		=> 'Notebook',
						'tablet'		=> 'Tablet Landscape',
						'desktop'		=> 'Desktop',
					);

				endif;

			elseif( strpos( $list, 'responsive_up' ) !== false ):
				$choices = array(
					'smartmin'																=> 'Mobile Min',
					'smartmin smartmid'														=> 'Mobile Mid',
					'smartmin smartmid smart'												=> 'Mobile',
					'smartmin smartmid smart portrait'										=> 'Tablet Portrait',
					'smartmin smartmid smart portrait notebook'								=> 'Notebook',
					'smartmin smartmid smart portrait notebook landscape'					=> 'Tablet Landscape',
					'smartmin smartmid smart portrait notebook landscape desktop'			=> 'Desktop',
					'smartmin smartmid smart portrait notebook landscape desktop wide'		=> 'Wide',
				);

			elseif( strpos( $list, 'responsive_down' ) !== false ):
				$choices = array(
					'wide desktop landscape notebook portrait smart smartmid smartmin'		=> 'Mobile Min',
					'wide desktop landscape notebook portrait smart smartmid'				=> 'Mobile Mid',
					'wide desktop landscape notebook portrait smart'						=> 'Mobile',
					'wide desktop landscape notebook portrait'								=> 'Tablet Portrait',
					'wide desktop landscape notebook'										=> 'Notebook',
					'wide desktop landscape'												=> 'Tablet Landscape',
					'wide desktop'															=> 'Desktop',
					'wide'																	=> 'Wide',
				);

			elseif( strpos( $list, 'responsive_layouts' ) !== false ):
				$choices = array(
					'1400px'			=> '1250px',
					'1120px'			=> '1120px',
					'1030px'			=> '1030px',
					'940px'				=> '940px',
					'800px'				=> '800px',
					'700px'				=> '700px',
					'600px'				=> '600px',
				);
			
			elseif( strpos( $list, 'bg_repeat' ) !== false ):
				$choices = array(
					'no-repeat'			=> 'No repeat',
					'repeat'			=> 'Repeat',
					'repeat-x'			=> 'Repeat x',
					'repeat-y'			=> 'Repeat y',
				);
			
			elseif( strpos( $list, 'bg_position' ) !== false ):
				$choices = array(
					'center center'			=> 'center center',
					'center top'			=> 'center top',
					'center bottom'			=> 'center bottom',
					'left center'			=> 'left center',
					'left top'				=> 'left top',
					'left bottom'			=> 'left bottom',
					'right center'			=> 'right center',
					'right top'				=> 'right top',
					'right bottom'			=> 'right bottom',
				);

			elseif( strpos( $list, 'webfonts_adobe' ) !== false ):
				if( strpos( $list, 'webfonts_adobe_styles' ) !== false ):
					$choices = array(
						'n1' => 'Thin',
						'i1' => 'Thin Italic',
						'n3' => 'Light',
						'i3' => 'Light Italic',
						'n4' => 'Normal',
						'i4' => 'Normal Italic',
						'n6' => 'Semi Bold',
						'i6' => 'Semi Bold Italic',
						'n7' => 'Bold',
						'i7' => 'Bold Italic',
						'n8' => 'Extra Bold',
						'i8' => 'Extra Bold Italic',
						'n9' => 'Ultra Bold',
						'i9' => 'Ultra Bold Italic',
					);
				else:
					global $SCM_typekit;

					$choices = array('no' => 'No Adobe font');
					$kits = scm_field( 'styles-adobe', array(), 'option' );
					foreach ( $kits as $field):
						$kit = $SCM_typekit->get( $field['id'] );
						if( !$kit || !$kit['kit'] )
							continue;
						foreach ( $kit['kit']['families'] as $family):
							$choices[$family['slug']] = $family['name'];
						endforeach;
					endforeach;
				endif;

			elseif( strpos( $list, 'webfonts_google' ) !== false ):
				if( strpos( $list, 'webfonts_google_styles' ) !== false ):
					$choices = array(
						'100,' => 'Thin',
						'100italic,' => 'Thin Italic',
						'300,' => 'Light',
						'300italic,' => 'Light Italic',
						'400,' => 'Normal',
						'400italic,' => 'Normal Italic',
						'600,' => 'Semi Bold',
						'600italic,' => 'Semi Bold Italic',
						'700,' => 'Bold',
						'700italic,' => 'Bold Italic',
						'800,' => 'Extra Bold',
						'800italic,' => 'Extra Bold Italic',
						'900,' => 'Ultra Bold',
						'900italic,' => 'Ultra Bold Italic',
					);
				else:
					$choices = array('no' => 'No Google font');
					$fonts = scm_field( 'styles-google', array(), 'option' );
					foreach ( $fonts as $font):
						$choices[$font['family']] = $font['family'];
					endforeach;
				endif;

			elseif( strpos( $list, 'webfonts_fallback' ) !== false ):
				$choices = array(
					'Helvetica_Arial_sans-serif'						=> 'Helvetica, Arial, sans-serif',
					'Lucida Sans Unicode_Lucida Grande_sans-serif'		=> 'Lucida Sans Unicode, Lucida Grande, sans-serif',
					'Trebuchet MS_Helvetica_sans-serif'					=> 'Trebuchet MS, Helvetica, sans-serif',
					'Verdana_Geneva_sans-serif'							=> 'Verdana, Geneva, sans-serif',
					'Georgia_serif'										=> 'Georgia, serif',
					'Times New Roman_Times_serif'						=> 'Times New Roman, Times, serif',
					'Palatino Linotype_Book Antiqua_Palatino_serif'		=> 'Palatino Linotype, Book Antiqua, Palatino, serif',
					'cursive_serif'										=> 'cursive, serif',
					'Courier New_Courier_monospace'						=> 'Courier New, Courier, monospace',
					'Lucida Console_Monaco_monospace'					=> 'Lucida Console, Monaco, monospace',
				);

			elseif( strpos( $list, 'font_weight' ) !== false ):
				$choices = array(
					'lighter' => 'Light',
					'normal' => 'Normal',
					//'semi' => 'Semi Bold',
					'bold' => 'Bold',
					//'900' => 'Extra Bold',
				);

			elseif( strpos( $list, 'line_height' ) !== false ):
				$choices = array(
					'0-0' => __( 'Nessuno spazio', SCM_THEME ),
					'0-25' => __( '1 quarto di linea', SCM_THEME ),
					'0-5' => __( 'Mezza linea', SCM_THEME ),
					'1-0' => __( 'Una linea', SCM_THEME ),
					'1-25' => __( 'Una linea e 1 quarto', SCM_THEME ),
					'1-5' => __( 'Una linea e mezza', SCM_THEME ),
					'1-75' => __( 'Una linea e 3 quarti', SCM_THEME ),
					'2-0' => __( 'Doppia linea', SCM_THEME ),
					'2-5' => __( 'Doppia linea e mezza', SCM_THEME ),
					'3-0' => __( 'Tripla linea', SCM_THEME ),
					'4-0' => __( 'Quadrupla linea', SCM_THEME ),
				);

			elseif( strpos( $list, 'slider_model' ) !== false ):
				$choices = array(
					'nivo' => 'Nivo Slider',
					'bx' => 'BX Slider',
				);

			elseif( strpos( $list, 'effect' ) !== false ):
				if( strpos( $list, '_nivo' ) !== false ):
					$choices = array(
						'sliceDown' => __( 'Slice Down', SCM_THEME ),
						'sliceDownLeft' => __( 'Slice Down Left', SCM_THEME ),
						'sliceUp' => __( 'Slice Up', SCM_THEME ),
						'sliceUpLeft' => __( 'Slice Up Left', SCM_THEME ),
						'sliceUpDown' => __( 'Slice Up Down', SCM_THEME ),
						'sliceUpDownLeft' => __( 'Slice Up Down Left', SCM_THEME ),
						'fold' => __( 'Fold', SCM_THEME ),
						'fade' => __( 'Fade', SCM_THEME ),
						'random' => __( 'Random', SCM_THEME ),
						'slideInRight' => __( 'Slide In Right', SCM_THEME ),
						'slideInLeft' => __( 'Slide In Left', SCM_THEME ),
						'boxRandom' => __( 'Box Random', SCM_THEME ),
						'boxRain' => __( 'Box Rain', SCM_THEME ),
						'boxRainReverse' => __( 'Box Rain Reverse', SCM_THEME ),
						'boxRainGrow' => __( 'Box Rain Grow', SCM_THEME ),
						'boxRainGrowReverse' => __( 'Box Rain Grow Reverse', SCM_THEME ),
					);
				endif;

			elseif( strpos( $list, 'themes_nivo' ) !== false ):
				$choices = array(
					'scm' 		=> 'SCM',
				);

			elseif( strpos( $list, 'box_shape' ) !== false ):
				$choices = array(
					'square' 		=> __( 'Quadrato', SCM_THEME ),
					'circle' 		=> __( 'Cerchio', SCM_THEME ),
					'rounded' 		=> __( 'Arrotondato', SCM_THEME ),
				);

			elseif( strpos( $list, 'simple_size' ) !== false ):
				$choices = array(
					'normal' 	=> __( 'Normale', SCM_THEME ),
					'min' 		=> __( 'Minimo', SCM_THEME ),
					'small' 	=> __( 'Piccolo', SCM_THEME ),
					'medium' 	=> __( 'Medio', SCM_THEME ),
					'big' 		=> __( 'Grande', SCM_THEME ),
					'max' 		=> __( 'Massimo', SCM_THEME ),
				);

			elseif( strpos( $list, 'date_format' ) !== false ):
				$choices = array(
					'dmy' 		=> '31 12 15',
					'dmY' 		=> '31 12 2015',
					'd F Y' 	=> __( '31 Dicembre 2015', SCM_THEME ),
					'd M y' 	=> __( '31 Dic 15', SCM_THEME ),
					'ymd' 		=> '15 12 31',
					'Ymd' 		=> '2015 12 31',
				);
			
			elseif( strpos( $list, 'box_angle_type' ) !== false ):
				$choices = array(
					'all' 					=> __( 'Tutti', SCM_THEME ),
					'round-top' 			=> __( 'Sopra', SCM_THEME ),
					'round-left' 			=> __( 'Sinistra', SCM_THEME ),
					'round-right' 			=> __( 'Destra', SCM_THEME ),
					'round-bottom' 			=> __( 'Sotto', SCM_THEME ),
					'round-leaf-left' 		=> __( 'Foglia A', SCM_THEME ),
					'round-leaf-right' 		=> __( 'Foglia B', SCM_THEME ),
					'round-petal-left' 		=> __( 'Petalo A', SCM_THEME ),
					'round-petal-right' 	=> __( 'Petalo B', SCM_THEME ),
					'round-drop-left' 		=> __( 'Petalo C', SCM_THEME ),
					'round-drop-right' 		=> __( 'Petalo D', SCM_THEME ),
					'round-head-left' 		=> __( 'Singolo A', SCM_THEME ),
					'round-head-right' 		=> __( 'Singolo B', SCM_THEME ),
					'round-foot-left' 		=> __( 'Singolo C', SCM_THEME ),
					'round-foot-right' 		=> __( 'Singolo D', SCM_THEME ),
				);

			elseif( strpos( $list, 'ease' ) !== false ):
				$choices = array(
					'swing' 			=> 'Swing',
					'linear' 			=> 'Linear',
					'easeInQuad' 		=> 'Quad In',
					'easeOutQuad' 		=> 'Quad Out',
					'easeInOutQuad' 	=> 'Quad InOut',
					'easeInCubic' 		=> 'Cubic In',
					'easeOutCubic' 		=> 'Cubic Out',
					'easeInOutCubic' 	=> 'Cubic InOut',
					'easeInQuart' 		=> 'Quart In',
					'easeOutQuart' 		=> 'Quart Out',
					'easeInOutQuart' 	=> 'Quart InOut',
					'easeInQuint' 		=> 'Quint In',
					'easeOutQuint' 		=> 'Quint Out',
					'easeInOutQuint' 	=> 'Quint InOut',
					'easeInExpo' 		=> 'Expo In',
					'easeOutExpo' 		=> 'Expo Out',
					'easeInOutExpo' 	=> 'Expo InOut',
					'easeInSine' 		=> 'Sine In',
					'easeOutSine' 		=> 'Sine Out',
					'easeInOutSine' 	=> 'Sine InOut',
					'easeInCirc' 		=> 'Circ In',
					'easeOutCirc' 		=> 'Circ Out',
					'easeInOutCirc' 	=> 'Circ InOut',
					'easeInElastic' 	=> 'Elastic In',
					'easeOutElastic' 	=> 'Elastic Out',
					'easeInOutElastic' 	=> 'Elastic InOut',
					'easeInBack' 		=> 'Back In',
					'easeOutBack' 		=> 'Back Out',
					'easeInOutBack' 	=> 'Back InOut',
					'easeInBounce' 		=> 'Bounce In',
					'easeOutBounce' 	=> 'Bounce Out',
					'easeInOutBounce' 	=> 'Bounce InOut',
				);

			endif;

			if( $get )
				return ( isset( $choices[$get] ) ? $choices[$get] : '' );

			return $choices;

        }
    }

?>