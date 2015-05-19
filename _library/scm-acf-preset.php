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
*		'message'				$message = ''								$esc_html = 0
*		'tab'					$placement = 'top | side' || 0 | 1
*			'-side'					$placement = 'side'
*
* ——————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————
*
*		'repeater'				$button-label = '+'							$min = '' 						$max = '' 						$layout = 'row | table | block'				$sub-fields = array()
* ———      	'-block':				$layout = 'block'
* ———      	'-table':				$layout = 'table'
*
*		'flexible'				$button-label = '+'							$min = '' 						$max = '' 						$layouts = array()
*
* ——————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————
*
*		'number'				$default = ''			$placeholder = ''				$prepend = ''						$append = ''					$min = ''							$max = ''						$step = ''						$read-only = 0					$disable = 0
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
*		'text'					$default = ''					$placeholder = ''				$prepend = ''					$append = '' 						$max-length = ''					$read-only = 0				$disable = 0
* ———		'id':			 		$place = 'ID' 					$prepend = '#'	
* ———		'class':			 	$place = 'Class'				$prepend = '.' 
* ———		'attributes':			$prepend = 'Attributes'			$place = 'data-href="www.example.com" data-target="_blank"'
* ———		'name':			 		$place = 'senza titolo' 		$prepend = 'Nome' 		$maxl = 30		
* ———		'link':			 		$prepend = 'Web' 				$place = 'http://www.esempio.com'
* ———		'video':			 	$prepend = 'YouTube' 			$place = 'https://www.youtube.com/watch?v=BVKXzNV6Z0c&list=PL4F1941886E6F2A16'
* ———		'-read'					$read-only = 1
* ———		'-disabled'				$disabled = 1
*
*		'textarea'				$default = ''					$placeholder = ''				$rows = 8 						$max-length = ''					$new-lines = 'wpautop | br | '		$read-only = 0				$disable = 0
* ———		'-no'					$new-lines = ''
* ———		'-br'					$new-lines = 'br'
* ———		'-read'					$read-only = 1
* ———		'-disabled'				$disabled = 1
*
*		'editor'				$default = ''					$tabs = 'all | visual'			$toolbar = 'normal | basic'		$media-upload = 0
* ———		'-visual'				$tabs = 'visual'
* ———		'-basic'				$toolbar = 'basic'
* ———		'-media'				$media = 1
*
*		'limiter'				$character-number = 350			$display-characters = 0
* ———		'-chars'				$display-characters = 1
*
* ——————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————
*
*		'select'				$default = '' || array(]	* 						$placeholder = ''									$ajax = 0							$allow_null = 0						$ui = 0						$multiple = 0 				$read-only = 0				$disable = 0
* ———		'select2'					$ui = 1
*		'checkbox'				$default = '' || array(]	*						$layout = 'vertical | horizontal' || 0 | 1
*		'radio'					$default = '' || array(]	*						$layout = 'vertical | horizontal' || 0 | 1			$more = 0							$load_save_terms = $more || 0
* ———		'-default'				add 'default' 	=> 	'Default' 	to array('choices']
* ———		'-no'					add 'no' 		=> 	'-' 		to array('choices']
* ———		'-multi'				$multiple | $more = 1
* ———		'-read'					$read-only = 1
* ———		'-disabled'				$disabled = 1
* ———		'-horizontal'			$layout = 1
*
* ———		* $default: 			array 			>	 field['choices'] = $default + choices 		field['default_value'] = field['choices'][0]
*									string 		 	>	 field['choices'][0] = $default				field['default_value'] = field['choices'][0]
*									string exists 	>	 -											field['default_value'] = $default
*
* ——————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————
*
*		'object'				$post_types = '' || array(]					$taxonomy = '' || array(] 				$placeholder = ''					$allow_null = 0					$multiple = 0						$return_format = 'object | id'	|| 0 | 1	$filters = array( 'search', 'post_type', 'taxonomy' )	$ui = 1
*		'object-rel'			$post_types = '' || array(]					$taxonomy = '' || array(]				$placeholder = ''					$elements = '' 					$max = 1							$return_format = 'object | id'	|| 0 | 1	$filters = array( 'search', 'post_type', 'taxonomy' )
* ———		'-id'						$return_format = 'id'
* ———		'-search'					$filters[] = 'search'
*		'object-link'			$post_types = '' || array(]					$taxonomy = '' || array(]				$placeholder = ''					$allow_null = 0 				$multiple = 0
* ———		'objects'					$multiple = 1 | $max = 0			
*
* ——————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————
*
*		'category | tag | taxonomy'				$taxonomy = ''						$add = 0				$load_save_terms = $multiple		$allow_null = 0 				$return_format = 'object'
* ———		'categories | tags | taxonomies' 		$multiple = 1
* ———		'-id'									$return_format = 'id'
* ———		'-add'									$add = 1
* ———		'-{tax}'								$taxonomy = '{tax}'
*
* ——————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————
*
*		'gallery'				$library = 'all | uploadedTo' || 0 | 1		$preview_size = 'thumbnail' 		$min = 0 				$max = 0 				$min_width = 0 			$max_width = 0 			$min_height = 0 			$max_height = 0 			$min_size = 0				$max_size = '' 				$mime_types = 'jpg,png'
*
*		'file'					$library = 'all | uploadedTo' || 0 | 1		$min_size = ''						$max_size = '' 			$mime_types = '*'		$return_format = 'array | url | id'
*		'image'					$library = 'all | uploadedTo' || 0 | 1		$preview_size = 'thumbnail' 		$min_width = 0 			$max_width = 0 			$min_height = 0 		$max_height = 0 		$min_size = 0				$max_size = '' 				$mime_types = 'jpg,png' 	$return_format = 'array | url | id'
* ———		'-url'						$return_format = 'url'
* ———		'-id'						$return_format = 'id'
*
* ——— 		* $mime_types: 		'file' 	>	'pdf, ppt, pptx, xls, xlsx, doc, docx, pages, numbers, keynote, txt, rtf, jpg, png, gif, zip, rar'
*
* ——————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————
*
*		'icon'					$default = 'star'	 						$filter = array( 'social', 'job', ... )	$save_format = 'class | unicode | element | object'			$enqueue_fa' = 0		$allow_null = 0					
*		'color'					$default = '' || '#000000' etc.
*		'date'					$return_format = 'Y-m-d' 					$display_format = 'd F Y'			$first_day' = 1
*		'datetime'				$picker = 'slider | select' 				$date_format = 'd F Y'				$time_format' = 'hh:mm' 		$show_week_number = 0 			$save_as_timestamp = 1 			$get_as_timestamp = 0
*		'time'					$picker = 'slider | select' 				$time_format' = 'hh:mm' 			$save_as_timestamp = 1 			$get_as_timestamp = 0
*
* ——————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————
*/


	if ( ! function_exists( 'scm_acf_field_type' ) ) {
		function scm_acf_field_type( $elem, $name = '' ) {

			if( !$elem )
				return;

			$field = array();
			$arg = array();

			if( is_array( $elem ) ){

				if( !isset( $elem[0] ) )
					return;

				$arg = $elem;
				$elem = $elem[0];
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
					$msg = ( isset( $arg[1] ) ? $arg[1] : '' );
					$html = ( isset( $arg[2] ) ? $arg[2] : 0 );
	        		$field = array(
						'type' => 'message',
						'message' => $msg,
						'esc_html' => $html,

					);
	        	break;

				case 'tab':
					$place = ( isset( $arg[1] ) && $arg[1] && $arg[1] !== 'top' ? 'left' : ( strpos( $extra , '-left' ) !== false ? 'left' : 'top' ) );
	        		$field = array(
						'type' => 'tab',
						'placement' => $place,
					);
	        	break;

	        	case 'select':
	        	case 'select2':

	        		$default = ( isset( $arg[1] ) ? $arg[1] : '' );
	        		
	        		$place = ( isset( $arg[2] ) ? $arg[2] : '' );
	        		$ajax = ( isset( $arg[3] ) ? $arg[3] : 0 );
	        		$null = ( isset( $arg[4] ) ? $arg[4] : 0 );
	        		$ui = ( $type == 'select2' ? 1 : ( isset( $arg[5] ) ? $arg[5] : 0 ) );
	        		$multi = ( isset( $arg[6] ) ? $arg[6] : ( strpos( $extra , '-multi' ) !== false ? 1 : 0 ) );
	        		$read = ( isset( $arg[7] ) ? $arg[7] : ( strpos( $extra , '-read' ) !== false ? 1 : 0 ) );
	        		$dis = ( isset( $arg[8] ) ? $arg[8] : ( strpos( $extra , '-disabled' ) !== false ? 1 : 0 ) );
	        		$extra = str_replace( array( '-multi', '-read', '-disabled' ), '', $elem);
	        		$choices = scm_acf_field_choices( $default, $choices );

	        		$field = array(
						'type' => 'select',
						'choices' => $choices['choices'],
						'default_value' => $choices['default_value'],
						'ui' => $ui,
						'multiple' => $multi,
						'allow_null' => $null,
						'ajax' => $ajax,
						'placeholder' => $place,
						'readonly' => $read,
						'disabled' => $dis,
						'preset' => $extra,
					);

	        	break;

	        	case 'checkbox':

	        		$default = ( isset( $arg[1] ) ? $arg[1] : '' );
	        		$layout = ( ( isset( $arg[2] ) && $arg[2] && $arg[2] !== 'vertical' ) || strpos( $extra , '-horizontal' ) !== false ? 'horizontal' : 'vertical' );
	        		$extra = str_replace( '-horizontal', '', $elem);
	        		$choices = scm_acf_field_choices( $default, $choices );
	        		
	        		$field = array(
						'type' => 'checkbox',
						'choices' => $choices['choices'],
						'default_value' => $choices['default_value'],
						'layout' => $layout,
						'preset' => $extra,
					);

	        	break;

	        	case 'radio':

	        		$default = ( isset( $arg[1] ) ? $arg[1] : '' );
	        		$layout = ( ( isset( $arg[2] ) && $arg[2] && $arg[2] !== 'vertical' ) || strpos( $extra , '-horizontal' ) !== false ? 'horizontal' : 'vertical' );
	        		$more = ( isset( $arg[3] ) ? $arg[3] : ( strpos( $extra , '-multi' ) !== false ? 1 : 0 ) );
	        		$save = ( isset( $arg[4] ) ? $arg[4] : ( isset( $arg[3] ) ? $more : 0 ) );
	        		$extra = str_replace( '-multi', '', $elem);
	        		$extra = str_replace( '-horizontal', '', $elem);
	        		$choices = scm_acf_field_choices( $default, $choices );
	        		
	        		$field = array(
						'type' => 'radio',
						'choices' => $choices['choices'],
						'default_value' => $choices['default_value'],
						'layout' => $layout,
						'other_choice' => $more,
						'save_other_choice' => $save,
						'preset' => $extra,
					);

	        	break;

	        	case 'object':
	        	case 'objects':

	        		$typ = ( strpos( $extra , '-link' ) !== false ? 'page_link' : ( strpos( $extra , '-rel' ) !== false ? 'relationship' : 'post_object' ) );

	        		$types = ( isset( $arg[1] ) ? $arg[1] : '' );
	        		$types = ( !is_array( $types ) && $types ? array( $types ) : $types );
	        		$tax = ( isset( $arg[2] ) ? $arg[2] : '' );
	        		$tax = ( !is_array( $tax ) && $tax ? array( $tax ) : $tax );

	        		$place = ( isset( $arg[3] ) ? $arg[3] : '' );

	        		$null = ( isset( $arg[4] ) ? $arg[4] : 0 );
	        		$elems = ( isset( $arg[4] ) ? $arg[4] : '' );

	        		$multi = ( $type == 'objects' ? 1 : ( isset( $arg[5] ) ? $arg[5] : 0 ) );
	        		$max = ( $type == 'objects' ? 0 : ( isset( $arg[5] ) ? $arg[5] : 1 ) );

	        		$ret = ( isset( $arg[6] ) && $arg[6] && $arg[6] !== 'object' ? 'id' : ( strpos( $extra , '-id' ) !== false ? 'id' : 'object' ) );

	        		$filters = ( isset( $arg[7] ) ? $arg[7] : ( strpos( $extra , '-search' ) !== false ? 'search' : '' ) );
	        		$filters = ( !is_array( $filters ) ? array( $filters ) : $filters );

	        		$ui = ( isset( $arg[8] ) ? $arg[8] : 1 );

					$field = array(
	        			'type' => $typ,
						'post_type' => $types,
						'taxonomy' => $tax,
						'placeholder' => $place,
					);

					switch ( $typ ) {
						case 'post_object':
							$field['allow_null'] = $null;
							$field['multiple'] = $multi;
							$field['return_format'] = $ret;
							$field['filters'] = $filters;
							$field['ui'] = $ui;
						break;
						
						case 'page_link':
							$field['allow_null'] = $null;
							$field['multiple'] = $multi;
						break;

						case 'relationship':
							$field['elements'] = $elems;
							$field['max'] = $max;
							$field['return_format'] = $ret;
							$field['filters'] = $filters;
						break;
					}						

	        	break;
				
	        	case 'tag':
	        	case 'tags':
	        	case 'category':
	        	case 'categories':
	        	case 'taxonomy':
	        	case 'taxonomies':

	        		$null = ( isset( $arg[4] ) ? $arg[4] : 0 );
	        		$ret = ( isset( $arg[5] ) && $arg[5] && $arg[5] !== 'object' ? 'id' : ( strpos( $extra , '-id' ) !== false ? 'id' : 'object' ) );
	        		$extra = str_replace( '-id', '', $extra );
	        		$extra = str_replace( '-', '', $extra );

	        		$tax = ( isset( $arg[1] ) ? $arg[1] : ( $extra ?: 'category' ) );
					
					$multi = ( strpos( $type, 's' ) !== false ?: 0 );
					$add = ( isset( $arg[2] ) ? $arg[2] : 0 );
					$save = ( $add ?: isset( $arg[3] ) ? $arg[3] : 0 );

					$typ = ( $multi ? ( $save ? 'checkbox' : 'multi_select' ) : ( $save ? 'radio' : 'select' ) );
										
	        		//$typ = ( isset( $arg[2] ) && is_string( $arg[2] ) ? $arg[2] : ( $multi ? ( $save ? 'checkbox' : 'checkbox' ) : 'select' ) );
	        		
//printPre( $name . ' : ' . $tax . ' save: ' . $save. ' arg: ' . $arg[3] . ' multi: ' . $multi );

	        		$field = array(
						'type' => 'taxonomy',
						'taxonomy' => $tax,
						'multiple' => $multi,
						'load_save_terms' => $save,
						'allow_null' => $null,
						'return_format' => $ret,
						'field_type' => $typ,
						'add_term' => $add
					);

	        	break;

	        	case 'file':

					$lib = ( isset( $arg[1] ) && $arg[1] && $arg[1] !== 'all' ? 'uploadedTo' : 'all' );
					$min = ( isset( $arg[2] ) ? $arg[2] : '' );
					$max = ( isset( $arg[3] ) ? $arg[3] : '' );
					$mime = ( isset( $arg[4] ) ? $arg[4] : 'pdf, ppt, pptx, xls, xlsx, doc, docx, pages, numbers, keynote, txt, rtf, jpg, png, gif, zip, rar' );
					$ret = ( isset( $arg[5] ) ? $arg[5] : ( strpos( $extra , '-id' ) !== false ? 'id' : ( strpos( $extra , '-url' ) !== false ? 'url' : 'array' ) ) );
	        		$field = array(
						'type' => 'file',
						'library' => $lib,
						'min_size' => $min,
						'max_size' => $max,
						'mime_types' => $mime,
						'return_format' => $ret,
					);

	        	break;

	        	case 'gallery':

	        		$lib = ( isset( $arg[1] ) && $arg[1] && $arg[1] !== 'all' ? 'uploadedTo' : 'all' );
					$pre = ( isset( $arg[2] ) ? $arg[2] : 'thumbnail' );
					$min = ( isset( $arg[3] ) ? $arg[3] : 0 );
					$max = ( isset( $arg[4] ) ? $arg[4] : 0 );
					$minw = ( isset( $arg[5] ) ? $arg[5] : 0 );
					$maxw = ( isset( $arg[6] ) ? $arg[6] : 0 );
					$minh = ( isset( $arg[7] ) ? $arg[7] : 0 );
					$maxh = ( isset( $arg[8] ) ? $arg[8] : 0 );
					$mins = ( isset( $arg[9] ) ? $arg[9] : 0 );
					$maxs = ( isset( $arg[10] ) ? $arg[10] : 0 );
					$mime = ( isset( $arg[11] ) ? $arg[11] : 'jpg, png, JPG, PNG, gif, GIF' );
	        		$field = array(
						'type' => 'gallery',
						'library' => $lib,
						'preview_size' => $pre,
						'min' => $min,
						'max' => $max,
						'min_width' => $minw,
						'max_width' => $maxw,
						'min_height' => $minh,
						'max_height' => $maxh,
						'min_size' => $mins,
						'max_size' => $maxs,
						'mime_types' => $mime,
					);

	        	break;
				
				case 'image':

					$lib = ( isset( $arg[1] ) && $arg[1] && $arg[1] !== 'all' ? 'uploadedTo' : 'all' );
					$pre = ( isset( $arg[2] ) ? $arg[2] : 'thumbnail' );
					$minw = ( isset( $arg[3] ) ? $arg[3] : 0 );
					$maxw = ( isset( $arg[4] ) ? $arg[4] : 0 );
					$minh = ( isset( $arg[5] ) ? $arg[5] : 0 );
					$maxh = ( isset( $arg[6] ) ? $arg[6] : 0 );
					$mins = ( isset( $arg[7] ) ? $arg[7] : 0 );
					$maxs = ( isset( $arg[8] ) ? $arg[8] : 0 );
					$mime = ( isset( $arg[9] ) ? $arg[9] : 'jpg, png, gif, ico' );
					$ret = ( isset( $arg[5] ) ? $arg[5] : ( strpos( $extra , '-id' ) !== false ? 'id' : ( strpos( $extra , '-url' ) !== false ? 'url' : 'array' ) ) );
	        		$field = array(
						'type' => 'image',
						'library' => $lib,
						'preview_size' => $pre,
						'min_width' => $minw,
						'max_width' => $maxw,
						'min_height' => $minh,
						'max_height' => $maxh,
						'min_size' => $mins,
						'max_size' => $maxs,
						//'mime_types' => $mime,
						'return_format' => $ret,
					);

	        	break;

	        	case 'icon':

	        		$default = ( isset( $arg[1] ) ? $arg[1] : 'fa-star' );
	        		$filter = ( isset( $arg[2] ) ? $arg[2] : '' );
	        		$format = ( isset( $arg[3] ) ? $arg[3] : 'class' );
	        		$enqueue = ( isset( $arg[4] ) ? $arg[4] : 0 );
	        		$null = ( isset( $arg[5] ) ? $arg[5] : 0 );

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
	        			'type' => 'font-awesome',
	        			'default_value' => ( strpos( $default, 'fa-' ) === 0 ? '' : 'fa-' ) . $default,
						'save_format' => $format,
						'enqueue_fa' => $enqueue,
						'allow_null' => $null,
						'fa_live_preview' => 1,
						'filter_group' => $filter_group,
						'filter' => $filter,
						'no_option' => $no,
					);

	        	break;


	        	case 'date':

	        		$ret = ( isset( $arg[1] ) ? $arg[1] : 'Y-m-d' );
	        		$dis = ( isset( $arg[2] ) ? $arg[2] : 'd F Y' );
	        		$first = ( isset( $arg[3] ) ? $arg[3] : 1 );
	        		$field = array(
						'type' => 'date_picker',
						'return_format' => $ret,
						'display_format' => $dis,
						'first_day' => $first,
					);

	        	break;

				case 'datetime':

	        		$picker = ( isset( $arg[1] ) ? $arg[1] : 'select' );
	        		$date = ( isset( $arg[2] ) ? $arg[2] : 'd F y' );
	        		$time = ( isset( $arg[3] ) ? $arg[3] : 'H:i' );
	        		$week = ( isset( $arg[4] ) ? $arg[4] : 0 );
	        		$save = ( isset( $arg[5] ) ? $arg[5] : 1 );
	        		$get = ( isset( $arg[5] ) ? $arg[5] : 0 );

	        		$field = array(
						'type' => 'date_time_picker',
						'show_date' => 1,
						'picker' => $picker,
						'date_format' => $date,
						'time_format' => $time,
						'show_week_number' => $week,
						'save_as_timestamp' => $save,
						'get_as_timestamp' => $get,

					);

	        	break;

	        	case 'time':

	        		$picker = ( isset( $arg[1] ) ? $arg[1] : 'select' );
	        		$time = ( isset( $arg[2] ) ? $arg[2] : 'hh:mm' );
	        		$save = ( isset( $arg[3] ) ? $arg[3] : 1 );
	        		$get = ( isset( $arg[4] ) ? $arg[4] : 0 );

	        		$field = array(
						'type' => 'date_time_picker',
						'show_date' => 0,
						'picker' => $picker,
						'date_format' => '',
						'time_format' => $time,
						'show_week_number' => 0,
						'save_as_timestamp' => $save,
						'get_as_timestamp' => $get,

					);

	        	break;

	        	case 'color':

	        		$default = ( isset( $arg[1] ) ? $arg[1] : '' );
	        		$field = array(
						'type' => 'color_picker',
						'default_value' => $default,
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
	        			case 'positive': 	$min = 0; 			break;
	        			case 'negative': 	$max = 0; 			break;
	        			case 'option': 		$min = -1; 			break;
	        			case 'pixel': 		$step = 1; 			$append = 'px';		break;
	        			case 'percent':		$min = 0;			$max = 100;			$append = '%';		break;
	        			case 'alpha': 		$place = '1';		$min = 0; 			$max = 1;	 		$step = .1; 		break;
	        			case 'second': 		$place = '1';		$min = 0; 			$step = .1; 		$append = 'sec';	break;
	        			case 'msecond': 	$place = '1000';	$min = 0;			$step = 100;		$append = 'ms';		break;
	        		}

	        		$default = ( isset( $arg[1] ) ? $arg[1] : '' );
	        		$place = ( isset( $arg[2] ) ? $arg[2] : ( isset( $place ) ? $place : '' ) );
	        		$prepend = ( isset( $arg[3] ) ? $arg[3] : ( isset( $prepend ) ? $prepend : '' ) );
	        		$append = ( isset( $arg[4] ) ? $arg[4] : ( isset( $append ) ? $append : '' ) );
	        		$min = ( isset( $arg[5] ) ? $arg[5] : ( isset( $min ) ? $min : ( strpos( $extra , '-pos' ) !== false ? 0 : ( strpos( $extra , '-min' ) !== false ? -9999 : '' ) ) ) );
	        		$max = ( isset( $arg[6] ) ? $arg[6] : ( isset( $max ) ? $max : ( strpos( $extra , '-neg' ) !== false ? 0 : ( strpos( $extra , '-max' ) !== false ? 9999 : '' ) ) ) );
	        		$step = ( isset( $arg[7] ) ? $arg[7] : ( isset( $step ) ? $step : 1 ) );
	        		$read = ( isset( $arg[8] ) ? $arg[8] : ( isset( $read ) ? $read : ( strpos( $extra , '-read' ) !== false ? 1 : 0 ) ) );
	        		$dis = ( isset( $arg[9] ) ? $arg[9] : ( isset( $dis ) ? $dis : ( strpos( $extra , '-disabled' ) !== false ? 1 : 0 ) ) );

	        		$field = array(
						'type' => 'number',
						'default_value' => $default,
						'placeholder' => $place,
						'prepend' => $prepend,
						'append' => $append,
						'min' => $min,
						'max' => $max,
						'step' => $step,
						'disabled' => $dis,
						'readonly' => $read,
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
	        			case 'id': 				$place = 'ID'; 				$prepend = '#';			break;
	        			case 'class': 			$place = 'Class';			$prepend = '.'; 		break;
	        			case 'attributes': 		$prepend = 'Attributes';	$place = 'data-href="www.example.com" data-target="_blank"';							break;
	        			case 'name': 			$place = 'senza titolo'; 	$prepend = 'Nome'; 		$maxl = 30;				break;
	        			case 'link': 			$prepend = 'Web'; 			$place = 'http://www.esempio.com';				break;
	        			case 'video': 			$prepend = 'YouTube'; 		$place = 'https://www.youtube.com/watch?v=BVKXzNV6Z0c&list=PL4F1941886E6F2A16';			break;
	        		}
	        		
	        		$default = ( isset( $arg[1] ) ? $arg[1] : '' );
	        		$place = ( isset( $arg[2] ) ? $arg[2] : ( isset( $place ) ? $place : '' ) );
	        		$prepend = ( isset( $arg[3] ) ? $arg[3] : ( isset( $prepend ) ? $prepend : '' ) );
	        		$append = ( isset( $arg[4] ) ? $arg[4] : ( isset( $append ) ? $append : '' ) );
	        		$maxl = ( isset( $arg[5] ) ? $arg[5] : ( isset( $maxl ) ? $maxl : '' ) );
	        		$read = ( isset( $arg[6] ) ? $arg[6] : ( isset( $read ) ? $read : ( strpos( $extra , '-read' ) !== false ? 1 : 0 ) ) );
	        		$dis = ( isset( $arg[7] ) ? $arg[7] : ( isset( $dis ) ? $dis : ( strpos( $extra , '-disabled' ) !== false ? 1 : 0 ) ) );

					$field = array(
	        			'type' => 'text',
						'default_value' => $default,
						'placeholder' => $place,
						'prepend' => $prepend,
						'append' => $append,
						'maxlength' => $maxl,
						'readonly' => $read,
						'disabled' => $dis,
					);

				break;

	        	case 'textarea':

	        		$default = ( isset( $arg[1] ) ? $arg[1] : '' );
	        		$place = ( isset( $arg[2] ) ? $arg[2] : '' );
	        		$rows = ( isset( $arg[3] ) ? $arg[3] : 8 );
	        		$maxl = ( isset( $arg[4] ) ? $arg[4] : '' );
	        		$format = ( isset( $arg[5] ) ? $arg[5] : ( strpos( $extra , '-no' ) !== false ? '' : ( strpos( $extra , '-br' ) !== false ? 'br' : 'wpautop' ) ) );
	        		$read = ( isset( $arg[6] ) ? $arg[6] : ( strpos( $extra , '-read' ) !== false ? 1 : 0 ) );
	        		$dis = ( isset( $arg[7] ) ? $arg[7] : ( strpos( $extra , '-disabled' ) !== false ? 1 : 0 ) );
					
					$field = array(
						'type' => 'textarea',
						'default_value' => $default,
						'placeholder' => $place,
						'rows' => $rows,
						'maxlength' => $maxl,
						'new_lines' => $format,
						'readonly' => $read,
						'disabled' => $dis,
					);

	        	break;

	        	case 'editor':

	        		$default = ( isset( $arg[1] ) ? $arg[1] : '' );
	        		$tabs = ( isset( $arg[2] ) ? $arg[2] : ( strpos( $extra, '-visual' ) !== false ? 'visual' : 'all' ) );
	        		$toolbar = ( isset( $arg[2] ) ? $arg[2] : ( strpos( $extra, '-basic' ) !== false ? 'basic' : 'normal' ) );
	        		$media = ( isset( $arg[2] ) ? $arg[2] : ( strpos( $extra, '-media' ) !== false ? 1 : 0 ) );
	        		$field = array(
	        			'type' => 'wysiwyg',
	        			'default_value' => $default,
						'tabs' => $tabs,
						'toolbar' => $toolbar,
						'media_upload' => $media,
					);

	        	break;

	        	case 'limiter':

		        	$max = ( isset( $arg[1] ) ? $arg[1] : ( isset( $max ) ? $max : 350 ) );
		        	$chars = ( isset( $arg[2] ) ? $arg[2] : ( isset( $chars ) ? $chars : ( strpos( $extra, '-chars' ) !== false ? 1 : 0 ) ) );

	        		$field = array(
	        			'type' => 'limiter',
						'character_number' =>$max,
						'display_characters' => $chars,
					);

	        	break;

	        	case 'repeater':

					$label = ( isset( $arg[1] ) ? $arg[1] : 'Aggiungi' );
					$minr = ( isset( $arg[2] ) ? $arg[2] : '' );
					$maxr = ( isset( $arg[3] ) ? $arg[3] : '' );
					$layout = ( isset( $arg[4] ) ? $arg[4] : ( strpos( $extra , '-block' ) !== false ? 'block' : ( strpos( $extra , '-table' ) !== false ? 'table' : 'row' ) ) );
					$sub = ( isset( $arg[5] ) && !empty( $arg[5] ) ? $arg[5] : array() );
	        		$field = array(
						'type' => 'repeater',
						'button_label' => $label,
						'min' => $minr,
						'max' => $maxr,
						'layout' => $layout,
						'sub_fields' => $sub,
					);

	        	break;
				
				case 'flexible':

					$label = ( isset( $arg[1] ) ? $arg[1] : '+' );
					$minr = ( isset( $arg[2] ) ? $arg[2] : '' );
					$maxr = ( isset( $arg[3] ) ? $arg[3] : '' );
					$layouts = ( isset( $arg[4] ) && !empty( $arg[4] ) ? $arg[4] : array() );
	        		$field = array(
						'type' => 'flexible_content',
						'button_label' => $label,
						'min' => $minr,
						'max' => $maxr,
						'layouts' => $layouts,
					);

	        	break;

	        	default:
	        		$field = array(
						'type' => 'text',
					);
	        	break;
	        }

	        //$field['key'] = ( $name ? $name . '-' : '' ) . $field['type'];

	        //$field = scm_acf_loadfield_hook_choices_get( $field );
			
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
					$str = ( $str ?: 'Elemento' );
					$choices = array(
						'no' => 'Nascondi ' . $str,
						'top' => $str . ' Sopra',
						'right' => $str . ' Destra',
						'bottom' => $str . ' Sotto',
						'left' => $str . ' Sinistra',
					);
				else:
					$str = str_replace( '_', '', str_replace( 'side_position', '', substr( $list, strpos( $list, 'side_position'))));
					$str = ( $str ?: 'Elemento' );
					$choices = array(
						'top' => $str . ' Sopra',
						'right' => $str . ' Destra',
						'bottom' => $str . ' Sotto',
						'left' => $str . ' Sinistra',
					);
				endif;
					
			elseif( strpos( $list, 'position_menu' ) !== false ):
				$choices = array(
					'top' => 'Menu sopra al logo',
					'inline' => 'Menu affianco al logo',
					'bottom' => 'Menu sotto al logo',
				);

			elseif( strpos( $list, 'sticky_active' ) !== false ):
				$choices = array(
					'self' => 'Sticky Self',
					'plus' => 'Sticky Plus',
				);

			elseif( strpos( $list, 'sticky_attach' ) !== false ):
				$choices = array(
					'nav-top' => 'Attach to main navigation TOP',
					'nav-bottom' => 'Attach to main navigation BOTTOM',
				);

			elseif( strpos( $list, 'home_active' ) !== false ):
				$choices = array(
					'both' => 'Menu + Sticky',
					'sticky' => 'Solo Sticky',
					'menu' => 'Solo Menu',
					'no' => 'Solo Toggle',
				);

			elseif( strpos( $list, 'branding_header' ) !== false ):
				$choices = array(
					'text' => 'Usa il nome del sito',
					'img' => 'Usa un\'immagine',
				);

			elseif( strpos( $list, 'head_position' ) !== false ):
				$choices = array(
					'menu_down'			=> 'Menu sotto a Logo',
					'menu_right'		=> 'Menu alla destra del Logo',
				);

			elseif( strpos( $list, 'head_social_position' ) !== false ):
				$choices = array(
					'top' => 'Sopra al menu (se menu inline)',
					'bottom' => 'Sotto al menu (se menu inline)',
				);
					
			elseif( strpos( $list, 'image_format' ) !== false ):
				$choices = array(
					'norm' => 'Normale',
					'quad' => 'Quadrata',
					'full' => 'Full Width',
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
					'single' => 'Singoli',
					'archive' => 'Archivio',
				);
			
			elseif( strpos( $list, 'archive_complete' ) !== false ):
				$choices = array(
					'partial' => 'Archivio parziale',
					'complete' => 'Archivio completo',
				);
			
			elseif( strpos( $list, 'archive_pagination' ) !== false ):
				$choices = array(
					'yes' => 'Paginazione',
					'all' => 'Pulsante ALL',
					'more' => 'Pulsante MORE',
					'no' => 'No paginazione',
				);
			
			elseif( strpos( $list, 'gallerie_button' ) !== false ):
				$choices = array(
					'img' => 'Thumb',
					'txt' => 'Testo',
					'section' => 'Sezione',
				);

			// +++ todo: non più 2, con _complete, ma spostati in alto, dove c'è template_ e lo fai simile
			// chiami tamplate_link{type}, recuperi type, in qualche modo risali alle fields di quel type, becchi la field link/url/file e aggiungi la choice Link Oggetto
			elseif( strpos( $list, 'template_link' ) !== false ):
				if( strpos( $list, '_complete' ) !== false ):

					$choices = array(
						'template' => 'Link Template (tutto)',
						'template-single' => 'Link Template (singoli elementi)',
						'link' => 'Inserisci Link (tutto)',
						'link-single' => 'Inserisci Link (singoli elementi)',
					);
				else:
					$choices = array(
						'self' => 'Link Oggetto',
						'template' => 'Link Template',
						'link' => 'Link Inserito',
					);
				endif;
			
			elseif( strpos( $list, 'luogo_data' ) !== false ):
				$choices = array(
					'name' => 'Nome',
					'address' => 'Indirizzo',
					'num' => 'Numeri',
					'email' => 'Email',
					'link' => 'Link',
				);
			
			elseif( strpos( $list, 'contact_link' ) !== false ):
				$choices = array(
					'web:' => 'web:',
					'support:' => 'support:',
				);

			elseif( strpos( $list, 'contact_email' ) !== false ):
				$choices = array(
					'e-mail:' => 'e-mail:',
				);

			elseif( strpos( $list, 'contact_num' ) !== false ):
				$choices = array(
					'Tel.' => 'Tel.',
					'Mobile' => 'Mobile',
					'Fax' => 'Fax',
				);

			elseif( strpos( $list, 'rassegne_type' ) !== false ):
				$choices = array(
					'file' => 'File',
					'link' => 'Link',
				);

			elseif( strpos( $list, 'links_type' ) !== false ):
				$choices = array(
					'page' 	=> 'Pagina',
					'link' 	=> 'Link',
				);

			elseif( strpos( $list, 'waitfor' ) !== false ):
				$choices = array(
					'window' => 'Window',
					'images' => 'Images',
					'sliders' => 'Sliders',
					'maps' => 'Maps',
				);

			elseif( strpos( $list, 'positive_negative' ) !== false ):
	        	$choices = array(
					'off' => 'Versione positiva',
					'on' => 'Versione negativa',
				);

	        elseif( strpos( $list, 'show' ) !== false ):
	        	if( strpos( $list, 'options_show' ) !== false ):
					$choices = array(
						'hide' 		=> 'Nascondi Opzioni',
						'options' 	=> 'Opzioni',
						'advanced' 	=> 'Opzioni avanzate',
					);
				else:
		        	$choices = array(
						'on' => 'Mostra',
						'off' => 'Nascondi',
					);
		        endif;

	        elseif( strpos( $list, 'hide' ) !== false ):
	        	$choices = array(
	        		'off' => 'Nascondi',
					'on' => 'Mostra',
				);

			elseif( strpos( $list, 'enable' ) !== false ):
	        	$choices = array(
					'on' => 'Abilita',
					'off' => 'Disabilita',
				);

	        elseif( strpos( $list, 'disable' ) !== false ):
	        	$choices = array(
	        		'off' => 'Disabilita',
					'on' => 'Abilita',
				);

			elseif( strpos( $list, 'ordertype' ) !== false ):
	        	$choices = array(
	        		'DESC' => 'Discendente',
	        		'ASC' => 'Ascendente',
				);

	        elseif( strpos( $list, 'orderby' ) !== false ):
	        	$choices = array(
	        		'date' => 'Data',
					'title' => 'Titolo',
					'modified' => 'Data modifica',
					'name' => 'Slug',
					'type' => 'Tipo',
					'rand' => 'Random',
				);

	        elseif( strpos( $list, 'line_style' ) !== false ):
	        	$choices = array(
	        		'no' => 'Vuoto',
	        		'line' => 'Linea',
	        		'dashed' => 'Tratteggiato',
	        		//'dotted' => 'Punteggiato'
				);

	        elseif( strpos( $list, 'line_cap' ) !== false ):
	        	$choices = array(
	        		'round' => 'Tondeggiato',
	        		'square' => 'Squadrato',
	        		'butt' => 'Squadrato a filo',
				);
			
			elseif( strpos( $list, 'list_type' ) !== false ):
	        	$choices = array(
	        		'none' => 'Non puntato',
	        		'disc' => 'Cerchio',
	        		'circle' => 'Cerchio vuoto',
	        		'square' => 'Quadrato',
	        		'decimal' => 'Decimali',
	        		'decimal-leading-zero' => 'Decimali con zero',
	        		'lower-latin' => 'Lettere minuscole',
	        		'upper-latin' => 'Lettere maiuscole',
					'lower-roman' => 'Roman minuscolo',
					'upper-roman' => 'Roman maiuscolo',
				);
	        
	        elseif( strpos( $list, 'alignment' ) !== false ):

	        	if( strpos( $list, 'vertical_alignment' ) !== false ){
		        	
		        	$choices = array(
						'top' => 'Alto',
						'middle' => 'Centro',
						'bottom' => 'Basso',
					);

				}else if( strpos( $list, 'txt_alignment' ) !== false ){
		        	
		        	$choices = array(
						'left' => 'Sinistra',
						'right' => 'Destra',
						'center' => 'Centrato',
						'justify' => 'Giustificato',
					);

				}else{

		        	$choices = array(
						'left' => 'Sinistra',
						'right' => 'Destra',
						'center' => 'Centrato',
					);

		        };

			elseif( strpos( $list, 'float' ) !== false ):
	        	$choices = array(
	        		'float-none' => 'No Float',
					'float-left' => 'Float Sinistra',
					'float-right' => 'Float Destra',
					'float-center' => 'Float Centrato',
				);

	        elseif( strpos( $list, 'overlay' ) !== false ):
	        	$choices = array(
					'no-overlay' => 'No Overlay',
					'overlay' => 'Overlay',
					'underlay' => 'Underlay',
				);

			elseif( strpos( $list, 'units' ) !== false ):
	        	$choices = array(
	        		'px' => 'px',
	        		'%' => '%',
					'em' => 'em',
				);

	        elseif( strpos( $list, 'headings' ) !== false ):

	        	$max = array(
					'h2' => 'Primario',
					'h3' => 'Secondario',
					'h4' => 'Terziario',
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
						'700px'			=> 'Mobile',
						'800px'			=> 'Tablet Portrait',
						'1030px'		=> 'Tablet Landscape',
						'1120px'		=> 'Desktop',
					);
				
				else:		

					$choices = array(
						'smart'			=> 'Mobile',
						'portrait'		=> 'Tablet Portrait',
						'tablet'		=> 'Tablet Landscape',
						'desktop'		=> 'Desktop',
					);

				endif;

			elseif( strpos( $list, 'responsive_up' ) !== false ):
				$choices = array(
					'smart'									=> 'Mobile',
					'smart portrait'						=> 'Tablet Portrait',
					'smart portrait landscape'				=> 'Tablet Landscape',
					'smart portrait landscape desktop'		=> 'Desktop',
				);

			elseif( strpos( $list, 'responsive_down' ) !== false ):
				$choices = array(
					'desktop landscape portrait smart'		=> 'Mobile',
					'desktop landscape portrait'			=> 'Tablet Portrait',
					'desktop landscape'						=> 'Tablet Landscape',
					'desktop'								=> 'Desktop',
				);

			elseif( strpos( $list, 'responsive_layouts' ) !== false ):
				$choices = array(
					'1400px'			=> '1250px',
					'1120px'			=> '1120px',
					'1030px'			=> '1030px',
					'940px'				=> '940px',
					'800px'				=> '800px',
					'700px'				=> '700px',
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
					'0.0' => 'Nessuno spazio',
					'0.25' => '1 quarto di linea',
					'0.5' => 'Mezza linea',
					'1' => 'Una linea',
					'1.25' => 'Una linea e 1 quarto',
					'1.5' => 'Una linea e mezza',
					'1.75' => 'Una linea e 3 quarti',
					'2' => 'Doppia linea',
					'2.5' => 'Doppia linea e mezza',
					'3' => 'Tripla linea',
					'4' => 'Quadrupla linea',
				);

			elseif( strpos( $list, 'slider_model' ) !== false ):
				$choices = array(
					'nivo' => 'Nivo Slider',
				);

			elseif( strpos( $list, 'effect' ) !== false ):
				if( strpos( $list, '_nivo' ) !== false ):
					$choices = array(
						'sliceDown' => 'Slice Down',
						'sliceDownLeft' => 'Slice Down Left',
						'sliceUp' => 'Slice Up',
						'sliceUpLeft' => 'Slice Up Left',
						'sliceUpDown' => 'Slice Up Down',
						'sliceUpDownLeft' => 'Slice Up Down Left',
						'fold' => 'Fold',
						'fade' => 'Fade',
						'random' => 'Random',
						'slideInRight' => 'Slide In Right',
						'slideInLeft' => 'Slide In Left',
						'boxRandom' => 'Box Random',
						'boxRain' => 'Box Rain',
						'boxRainReverse' => 'Box Rain Reverse',
						'boxRainGrow' => 'Box Rain Grow',
						'boxRainGrowReverse' => 'Box Rain Grow Reverse'
					);
				endif;

			elseif( strpos( $list, 'themes_nivo' ) !== false ):
				$choices = array(
					'scm' 		=> 'SCM',
				);

			elseif( strpos( $list, 'box_shape' ) !== false ):
				$choices = array(
					'square' 		=> 'Quadrato',
					'circle' 		=> 'Cerchio',
					'rounded' 		=> 'Arrotondato',
				);

			elseif( strpos( $list, 'simple_size' ) !== false ):
				$choices = array(
					'normal' 	=> 'Normale',
					'min' 		=> 'Minimo',
					'small' 	=> 'Piccolo',
					'medium' 	=> 'Medio',
					'big' 		=> 'Grande',
					'max' 		=> 'Massimo',
				);

			elseif( strpos( $list, 'date_format' ) !== false ):
				$choices = array(
					'dmy' 		=> '09 06 15',
					'dmY' 		=> '09 06 2015',
					'd F Y' 	=> '09 Giugno 2015',
					'd M y' 	=> '09 Giu 15',
				);
			
			elseif( strpos( $list, 'box_angle_type' ) !== false ):
				$choices = array(
					'all' 					=> 'Tutti',
					'round-top' 			=> 'Sopra',
					'round-left' 			=> 'Sinistra',
					'round-right' 			=> 'Destra',
					'round-bottom' 			=> 'Sotto',
					'round-leaf-left' 		=> 'Foglia A',
					'round-leaf-right' 		=> 'Foglia B',
					'round-petal-left' 		=> 'Petalo A',
					'round-petal-right' 	=> 'Petalo B',
					'round-drop-left' 		=> 'Petalo C',
					'round-drop-right' 		=> 'Petalo D',
					'round-head-left' 		=> 'Singolo A',
					'round-head-right' 		=> 'Singolo B',
					'round-foot-left' 		=> 'Singolo C',
					'round-foot-right' 		=> 'Singolo D',
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