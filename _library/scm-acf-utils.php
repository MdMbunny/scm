<?php

/**
* ACF utilities.
*
* @link http://www.studiocreativo-m.it
*
* @package SCM
* @subpackage 2-ACF/UTILS
* @since 1.0.0
*/

// ------------------------------------------------------
//
// 1.0 Helper
// 2.0 Choices
//
// ------------------------------------------------------

// ------------------------------------------------------
// 1.0 HELPER
// ------------------------------------------------------

/**
* [GET] Filter old field structures
*
* @todo Una volta uniformate le chiamate di {@see ACF/scm_acf_field()} questa funzione scompare.
*
* @param {misc} a
* @param {misc} n
* @param {misc} t
* @param {misc} d
* @return {array} Filtered field.
*/
function scm_acf_get_field_to3( $a, $n, $t, $d ) {
	return ( isset( $a[$n] ) ? $a[$n] : ( isset( $a[$t] ) ? $a[$t] : $d ) );
}

/**
* [GET] Value or fallback 
*
* @todo Una volta eliminata {@see 2-ACF/UTILS/scm_acf_get_field_to3() } sostituire con questa nuova funzione.
*
* @param {array} arr Field array.
* @param {string} par Field attribute.
* @param {misc} fallback Fallback value
* @return {array} Field attribute value.
*/
function scm_acf_get_value( $arr = NULL, $par = NULL, $fallback = NULL ) {
	if( is_null( $arr ) ) return '';
	return ( isset( $arr[$par] ) ? $arr[$par] : ( !is_null( $fallback ) ? $fallback : '' ) );
}


// ------------------------------------------------------
// 2.0 CHOICES
// ------------------------------------------------------

/**
* [GET] Field
*
* Complete options:
```php
——————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————

'tab'					$place ['top'|'left'|0|1]

	'-left'				$place = 'left'

'message'				$message ['']				$eschtml [false]			$lines [''|'br'|'wpautop']

——————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————

'repeater'			$button ['+']				$min [0] 					$max [0] 						$layout ['row'|'table'|'block']		$sub [array()]

	'-block':			$layout = 'block'
	'-table':			$layout = 'table'

'flexible'			$button ['+']				$min [0] 					$max [0] 						$layouts = [array()]

——————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————

'number'				$default ['']				$placeholder ['']			$prepend ['']					$append ['']						$min ['']							$max ['']						$step ['']						$read [false]					$disabled [false]

	'positive':			$min = 0
	'negative':			$max = 0
	'option':			$min = -1
	'pixel':			$step = 1 					$append = 'px'
	'percent':			$min = 0 					$max = 100 					$append = '%'
	'alpha':			$min = 0 					$max = 1 					$step = .1 						$placeholder = '1'
	'second':			$min = 0 					$step = .1 					$append = 'sec'					$placeholder = '1'
	'msecond':			$min = 0 					$step = 100					$append = 'ms'					$placeholder = '1000'
	'-max'				$max = 9999
	'-min'				$min = -9999
	'-pos'				$min = 0
	'-neg'				$max = 0
	'-read'				$read-only = true
	'-disabled'			$disabled = true

——————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————

'text'				$default ['']				$placeholder ['']			$prepend ['']					$append [''] 						$max ['']							$read [false]					$disabled [false]

	'id':			 	$prepend = '#'				$placeholder = 'id'
	'class':			$prepend = '.'				$placeholder = 'class'
	'attributes':		$prepend = 'Data'			$placeholder = 'data-href="www.website.com" data-target="_blank"'
	'name':			 	$prepend = 'Nome' 			$placeholder = 'senza nome'									$max = 30		
	'link':			 	$prepend = 'URL' 			$placeholder = 'http://www.website.com'
	'email':			$prepend = '@' 				$placeholder = 'info@.website.com'
	'user':			 	$prepend = 'User' 			$placeholder = 'user name'
	'phone':			$prepend = 'N.' 			$placeholder = '+39 123 4567'
	'video':			$prepend = 'YouTube' 		$placeholder = 'https://www.youtube.com/watch?v=BVKXzNV6Z0c&list=PL4F1941886E6F2A16'
	'-read'				$read = true
	'-disabled'			$disabled = true

'textarea'			$default ['']				$placeholder ['']			$rows [8] 						$max ['']							$lines ['wpautop'|'br'|'']			$read [false]					$disabled [false]

	'-no'				$lines = ''
	'-br'				$lines = 'br'
	'-read'				$read = true
	'-disabled'			$disabled = true

'editor'				$default ['']				$tabs ['all'|'visual']		$toolbar ['normal'|'basic']		$media [false]

	'-visual'			$tabs = 'visual'
	'-basic'			$toolbar = 'basic'
	'-media'			$media = 1

'limiter'				$max [350]					$display [false]

	'-chars'			$display = true

——————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————

'true_false'			$default [false|true]

'select'				$default [''|array()]* 		$placeholder ['']			$ajax [false]					$null [false]						$ui [false]							$multi [false] 				$read [false]					$disabled [false]

	'select2'			$ui = true

'checkbox'			$default [''|array()]*		$layout ['vertical'|'horizontal'|0|1]				 		$toggle [false]

'radio'				$default [''|array()]*		$layout ['vertical'|'horizontal'|0|1]						$more [false]						$save [$more|false]

	'-default'			add 'default' => 'Default' 	to $field['choices']
	'-no'				add 'no' 	  => '-' 		to $field['choices']
	'-multi'			$multiple | $more = true
	'-read'				$read = true
	'-disabled'			$disabled = true
	'-horizontal'		$layout = true

* $default: 			array 				>	 field['choices'] = $default + choices 		field['default_value'] = field['choices'][0]
						string not exist	>	 field['choices'][0] = $default				field['default_value'] = field['choices'][0]
						string exists 		>	 -											field['default_value'] = $default

——————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————

'object'				$types [''|array()]			$taxes [''|array()] 		$placeholder ['']				$null [false]						$multiple [false]					$return ['object'|'id'|0|1]		$filters [array( 'search', 'post_type', 'taxonomy' )]			$ui [true]

'object-rel'			$types [''|array()]			$taxes [''|array()]			$placeholder ['']				$elements [''] 						$max [1]							$return ['object'|'id'|0|1]		$filters [array( 'search', 'post_type', 'taxonomy' )]

	'-id'				$return = 'id'
	'-search'			$filters[] = 'search'
	'-null'				$null = true

'object-link'			$types [''|array()]			$taxes [''|array()]			$placeholder ['']				$null [false] 						$multiple [false]

	'objects'			$multiple = true
	'objects-rel'		$max = 0

——————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————

'category'
'tag'
'taxonomy'			$taxes ['']					$add [false]				$save [$multiple]				$null [false] 						$return ['object'|'id']				($multiple = false)

	'*plural'			$multiple = true
	'-id'				$return = 'id'
	'-add'				$add = true
	'-null'				$null = true
	'-{tax}'			$taxes = '{tax}'

——————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————

'gallery'				$library ['uploadedTo'|'all'|0|1]						$preview ['thumbnail'] 			$min [0] 							$max [0] 							$minwidth [0] 					$maxwidth [0] 					$minheight [0] 					$maxheight [0] 					$minsize [0]				$maxsize [0] 				$mime ['jpg,png,...']*

'file'				$library ['uploadedTo'|'all'|0|1]						$minsize [0]					$maxsize [0] 						$mime ['jpg,png,...']* 				$return ['array'|'url|'id']

	'-url'				$return = 'url'
	'-id'				$return = 'id'
	'-all'				$library = 'all'

'image'				$library ['uploadedTo'|'all'|0|1]						$preview ['thumbnail'] 			$minwidth [0] 						$maxwidth [0] 						$minheight [0] 					$maxheight [0] 					$minsize [0]					$maxsize [0] 					$mime ['jpg,png,...']* 		$return ['array'|'url'|'id']

	'-url'				$return = 'url'
	'-id'				$return = 'id'
	'-all'				$library = 'all'

* $mime: 				'pdf, ppt, pptx, xls, xlsx, doc, docx, pages, numbers, keynote, txt, rtf, jpg, png, gif, zip, rar'

——————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————

'icon'				$default ['star']	 		$filter [array(fa-groups)]	$save ['class'|'unicode'|'element'|'object']						$enqueue' [false]					$null [false] 					$preview [true]

	'-no'				add 'no' => 'No Icon' 		to array('choices')

'color'				$default [''|'#000000'|...]

'date'				$return ['Y-m-d']			$display ['d F Y']			$firstday' [1]

'datetime'			$return ['Y-m-d G:i'] 		$display ['d F Y G:i']		$firstday' [1]

'time'				$return ['G:i']				$display ['G:i']

——————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————
```
* @param {string|array} elem Field type-{options} or associative array.
* @return {array} Field.
*/
function scm_acf_get_field( $elem ) {

	if( !$elem )
		return;

	$field = array();
	$arg = array();

	if( is_array( $elem ) ){

		$el = scm_acf_get_field_to3( $elem, 0, 'type', '' );

		if( !$el )
			return;

		$arg = $elem;
		$elem = $el;
	}
	
	$choices = array();
	if( isset($arg['choices']) && $arg['choices'] ){
		$choices = $arg['choices'];
	}

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
				'message' 				=> scm_acf_get_field_to3( $arg, 1, 'placeholder', '' ),
				'esc_html' 				=> scm_acf_get_field_to3( $arg, 2, 'eschtml', 0 ),
				'new_lines' 			=> scm_acf_get_field_to3( $arg, 3, 'lines', '' ),
			);

    	break;

		case 'tab':
			
    		$field = array(
				'type' 					=> 'tab',
				'placement' 			=> scm_acf_get_field_to3( $arg, 1, 'placeholder', ( strpos( $extra , '-left' ) !== false ? 'left' : 'top' ) ),
			);

    	break;

    	case 'true_false':

    		$field = array(
				'type' 					=> 'true_false',
				'default_value' 		=> scm_acf_get_field_to3( $arg, 1, 'default', 0 ),
			);

		break;

    	case 'select':
    	case 'select2':

    		$default = scm_acf_get_field_to3( $arg, 1, 'default', '' );
    		$choices = scm_acf_field_choices( $default, $choices );

			$ajax = scm_acf_get_field_to3( $arg, 3, 'ajax', ( strpos( $extra , '-ajax' ) !== false ?: 0 ) );
    		$multi = scm_acf_get_field_to3( $arg, 6, 'multi', ( strpos( $extra , '-multi' ) !== false ?: $type == 'select2' ) );
    		$ui = scm_acf_get_field_to3( $arg, 5, 'ui', ( strpos( $extra , '-ui' ) !== false ?: $multi ) );
    		$null = scm_acf_get_field_to3( $arg, 4, 'null', ( strpos( $extra , '-null' ) !== false ?: $multi ) );
    		$read = scm_acf_get_field_to3( $arg, 7, 'read', ( strpos( $extra , '-read' ) !== false ?: 0 ) );
    		$disabled = scm_acf_get_field_to3( $arg, 8, 'disabled', ( strpos( $extra , '-disabled' ) !== false ?: 0 ) );

    		$field = array(
				'type' 					=> 'select',
				'choices' 				=> $choices['choices'],
				'default_value' 		=> ( $multi ? array() : $choices['default_value'] ),
				'ajax' 					=> $ajax,
				'allow_null' 			=> $null,
				'ui' 					=> $ui,
				'multiple' 				=> $multi,
				'readonly' 				=> $read,
				'disabled' 				=> $disabled,
				'preset' 				=> str_replace( array( '-multi', '-read', '-disabled', '-ui', '-ajax' ), '', $extra),
			);

    	break;

    	scm_acf_field( 'style', array( 'checkbox-webfonts_google_styles', '', 'horizontal' ), __( 'Styles', SCM_THEME ) );

    	case 'checkbox':

    		$default = scm_acf_get_field_to3( $arg, 1, 'default', '' );
    		$layout = scm_acf_get_field_to3( $arg, 2, 'layout', 'vertical' );
    		$toggle = scm_acf_get_field_to3( $arg, 3, 'toggle', 0 );
    		$choices = scm_acf_field_choices( $default, $choices );
    		
    		$field = array(
				'type' 					=> 'checkbox',
				'choices' 				=> $choices['choices'],
				'default_value' 		=> $choices['default_value'],
				'toggle' 				=> $toggle,
				'layout' 				=> ( ( $layout && $layout !== 'vertical' ) || strpos( $extra , '-horizontal' ) !== false ? 'horizontal' : 'vertical' ),
				'preset' 				=> str_replace( '-horizontal', '', $extra),
			);

    	break;

    	case 'radio':

    		$default = scm_acf_get_field_to3( $arg, 1, 'default', '' );
    		$layout = scm_acf_get_field_to3( $arg, 1, '' );
    		$choices = scm_acf_field_choices( $default, $choices );
    		$more = scm_acf_get_field_to3( $arg, 3, 'more', ( strpos( $extra , '-multi' ) !== false ? 1 : 0 ) );
    		
    		$field = array(
				'type' 					=> 'radio',
				'choices' 				=> $choices['choices'],
				'default_value' 		=> $choices['default_value'],
				'other_choice' 			=> $more,
				'save_other_choice' 	=> scm_acf_get_field_to3( $arg, 4, 'save', ( isset( $arg[3] ) ? $more : 0 ) ),
				'layout' 				=> ( ( $layout && $layout !== 'vertical' ) || strpos( $extra , '-horizontal' ) !== false ? 'horizontal' : 'vertical' ),
				'preset' 				=> str_replace( array('-multi', '-horizontal'), '', $extra),
			);

    	break;

    	case 'object':
    	case 'objects':

    		$typ = ( strpos( $extra , '-link' ) !== false ? 'page_link' : ( strpos( $extra , '-rel' ) !== false ? 'relationship' : 'post_object' ) );
	        		
			$field = array(
    			'type' 					=> $typ,
				'post_type' 			=> toArray( scm_acf_get_field_to3( $arg, 1, 'types', '' ), 0, 1 ),
				'taxonomy' 				=> toArray( scm_acf_get_field_to3( $arg, 2, 'taxes', '' ), 0, 1 ),
				'placeholder' 			=> scm_acf_get_field_to3( $arg, 3, 'placeholder', '' ),
			);

			switch ( $typ ) {
				case 'post_object':
					$field['allow_null'] = scm_acf_get_field_to3( $arg, 4, 'null', ( strpos( $extra , '-null' ) !== false ? 1 : 0 ) );
					$field['multiple'] = ( $type == 'objects' ? 1 : scm_acf_get_field_to3( $arg, 5, 'multi', 0 ) );
					$field['return_format'] = ( scm_acf_get_field_to3( $arg, 6, 'return', 'object' ) !== 'object' ? 'id' : ( strpos( $extra , '-id' ) !== false ? 'id' : 'object' ) );
					$field['filters'] = toArray( scm_acf_get_field_to3( $arg, 7, 'filters', ( strpos( $extra , '-search' ) !== false ? 'search' : '' ) ), 0, 1 );
					$field['ui'] = scm_acf_get_field_to3( $arg, 8, 'ui', 1 );
				break;
				
				case 'page_link':
					$field['allow_null'] = scm_acf_get_field_to3( $arg, 4, 'null', ( strpos( $extra , '-null' ) !== false ? 1 : 0 ) );
					$field['multiple'] = ( $type == 'objects' ? 1 : scm_acf_get_field_to3( $arg, 5, 'multi', 0 ) );
				break;

				case 'relationship':
					$field['elements'] = scm_acf_get_field_to3( $arg, 4, 'elements', '' );
					$field['max'] = ( $type == 'objects' ? 0 : scm_acf_get_field_to3( $arg, 5, 'max', 1 ) );
					$field['return_format'] = ( scm_acf_get_field_to3( $arg, 6, 'return', 'object' ) !== 'object' ? 'id' : ( strpos( $extra , '-id' ) !== false ? 'id' : 'object' ) );
					$field['filters'] = toArray( scm_acf_get_field_to3( $arg, 7, 'filters', ( strpos( $extra , '-search' ) !== false ? 'search' : '' ) ), 0, 1 );
				break;
			}

    	break;
		
    	case 'tag':
    	case 'tags':
    	case 'category':
    	case 'categories':
    	case 'taxonomy':
    	case 'taxonomies':      		
			
			$multi = ( endsWith( $type, 's' ) ?: 0 );
			$add = scm_acf_get_field_to3( $arg, 2, 'add', 0 );
			$save = ( $add ?: scm_acf_get_field_to3( $arg, 3, 'save', 0 ) );

    		$field = array(
				'type' 						=> 'taxonomy',
				'taxonomy' 					=> scm_acf_get_field_to3( $arg, 1, 'taxes', ( str_replace( array( '-id', '-' ), '', $extra ) ?: 'category' ) ),
				'multiple' 					=> $multi,
				'load_save_terms' 			=> $save,
				'allow_null' 				=> scm_acf_get_field_to3( $arg, 4, 'null', ( str_replace( array( '-null', '-' ), '', $extra ) ?: 0 ) ),
				'return_format' 			=> ( scm_acf_get_field_to3( $arg, 5, 'return', 'object' ) !== 'object' ? 'id' : ( strpos( $extra , '-id' ) !== false ? 'id' : 'object' ) ),
				'field_type' 				=> ( $multi ? ( $save ? 'checkbox' : 'multi_select' ) : ( $save ? 'radio' : 'select' ) ),
				'add_term' 					=> $add
			);

    	break;

    	case 'file':
    		
    		$field = array(
				'type' 						=> 'file',
				'library' 					=> ( scm_acf_get_field_to3( $arg, 1, 'library', ( strpos( $extra , '-all' ) !== false ? 'all' : 'uploadedTo' ) ) !== 'all' ? 'uploadedTo' : 'all' ),
				'min_size' 					=> scm_acf_get_field_to3( $arg, 2, 'minsize', '' ),
				'max_size' 					=> scm_acf_get_field_to3( $arg, 3, 'maxsize', '' ),
				'return_format' 			=> scm_acf_get_field_to3( $arg, 5, 'return', ( strpos( $extra , '-id' ) !== false ? 'id' : ( strpos( $extra , '-url' ) !== false ? 'url' : 'array' ) ) ),
			);

    	break;

    	case 'gallery':
    		
    		$field = array(
				'type' 						=> 'gallery',
				'library' 					=> ( scm_acf_get_field_to3( $arg, 1, 'library', ( strpos( $extra , '-all' ) !== false ? 'all' : 'uploadedTo' ) ) !== 'all' ? 'uploadedTo' : 'all' ),
				'preview_size' 				=> scm_acf_get_field_to3( $arg, 2, 'preview', 'thumbnail' ),
				'min' 						=> scm_acf_get_field_to3( $arg, 3, 'min', 0 ),
				'max' 						=> scm_acf_get_field_to3( $arg, 4, 'max', 0 ),
				'min_width' 				=> scm_acf_get_field_to3( $arg, 5, 'minwidth', 0 ),
				'max_width' 				=> scm_acf_get_field_to3( $arg, 6, 'maxwidth', 0 ),
				'min_height' 				=> scm_acf_get_field_to3( $arg, 7, 'minheight', 0 ),
				'max_height' 				=> scm_acf_get_field_to3( $arg, 8, 'maxheight', 0 ),
				'min_size' 					=> scm_acf_get_field_to3( $arg, 9, 'minsize', 0 ),
				'max_size' 					=> scm_acf_get_field_to3( $arg, 10, 'maxsize', 0 ),
				'mime_types' 				=> scm_acf_get_field_to3( $arg, 11, 'mime', 'jpg, png, JPG, PNG, gif, GIF, jpeg, JPEG' ),
			);

    	break;
		
		case 'image':
    		
    		$field = array(
				'type' 						=> 'image',
				'library' 					=> ( scm_acf_get_field_to3( $arg, 1, 'library', ( strpos( $extra , '-all' ) !== false ? 'all' : 'uploadedTo' ) ) !== 'all' ? 'uploadedTo' : 'all' ),
				'preview_size' 				=> scm_acf_get_field_to3( $arg, 2, 'preview', 'thumbnail' ),
				'min_width' 				=> scm_acf_get_field_to3( $arg, 3, 'minwidth', 0 ),
				'max_width' 				=> scm_acf_get_field_to3( $arg, 4, 'maxwidth', 0 ),
				'min_height' 				=> scm_acf_get_field_to3( $arg, 5, 'minheight', 0 ),
				'max_height' 				=> scm_acf_get_field_to3( $arg, 6, 'maxheight', 0 ),
				'min_size' 					=> scm_acf_get_field_to3( $arg, 7, 'minsize', 0 ),
				'max_size' 					=> scm_acf_get_field_to3( $arg, 8, 'maxsize', 0 ),
				'mime_types' 				=> scm_acf_get_field_to3( $arg, 9, 'mime', '' ),
				'return_format' 			=> scm_acf_get_field_to3( $arg, 10, 'return', ( strpos( $extra , '-id' ) !== false ? 'id' : ( strpos( $extra , '-url' ) !== false ? 'url' : 'array' ) ) ),
			);

    	break;

    	case 'icon':

    		$default = scm_acf_get_field_to3( $arg, 1, 'default', 'fa-star' );
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
				'filter' 					=> scm_acf_get_field_to3( $arg, 2, 'filter', '' ),
				'save_format' 				=> scm_acf_get_field_to3( $arg, 3, 'save', 'class' ),
				'enqueue_fa' 				=> scm_acf_get_field_to3( $arg, 4, 'enqueue', 0 ),
				'allow_null' 				=> scm_acf_get_field_to3( $arg, 5, 'null', 0 ),
				'fa_live_preview' 			=> scm_acf_get_field_to3( $arg, 6, 'preview', 1 ),
				'filter_group' 				=> $filter_group,
				'no_option' 				=> $no,
			);

    	break;


    	case 'date':

    		$field = array(
				'type' 						=> 'date_picker',
				'return_format' 			=> scm_acf_get_field_to3( $arg, 1, 'return', 'd-m-Y' ),
				'display_format' 			=> scm_acf_get_field_to3( $arg, 2, 'display', 'd F Y' ),
				'first_day' 				=> scm_acf_get_field_to3( $arg, 3, 'firstday', 1 ),
			);

    	break;

		case 'datetime':

    		$field = array(
				'type' 						=> 'date_time_picker',
				'return_format' 			=> scm_acf_get_field_to3( $arg, 1, 'return', 'd-m-Y G:i' ),
				'display_format' 			=> scm_acf_get_field_to3( $arg, 2, 'display', 'd F Y G:i' ),
				'first_day' 				=> scm_acf_get_field_to3( $arg, 3, 'firstday', 1 ),
			);

    	break;

    	case 'time':

    		$field = array(
				'type' 						=> 'time_picker',
				'return_format' 			=> scm_acf_get_field_to3( $arg, 1, 'return', 'G:i' ),
				'display_format' 			=> scm_acf_get_field_to3( $arg, 2, 'display', 'G:i' ),
			);

    	break;

    	case 'color':

    		$field = array(
				'type' => 'color_picker',
				'default_value' 			=> scm_acf_get_field_to3( $arg, 1, 'default', '' ),
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

    		$default = scm_acf_get_field_to3( $arg, 1, 'default', '' );

    		switch ( $type ) {
    			case 'number': 		$place = $default;																	break;
    			case 'positive': 	$place = '0';		$min = 0; 														break;
    			case 'negative': 	$place = '0';		$max = 0; 														break;
    			case 'option': 		$place = '0';		$min = -1; 														break;
    			case 'pixel': 		$step = 1; 			$append = 'px';													break;
    			case 'percent':		$min = 0;			$append = '%';		$max = 100;									break;
    			case 'alpha': 		$place = '1';		$min = 0; 			$max = 1;	 		$step = .1; 			break;
    			case 'second': 		$place = '1';		$append = 'sec';	$min = 0; 			$step = .1; 			break;
    			case 'msecond': 	$place = '1000';	$append = 'ms';		$min = 0;			$step = 100;			break;
    		}

    		$field = array(
				'type' 						=> 'number',
				'default_value' 			=> $default,
				'placeholder' 				=> scm_acf_get_field_to3( $arg, 2, 'placeholder', ( isset( $place ) ? $place : '' ) ),
				'prepend' 					=> scm_acf_get_field_to3( $arg, 3, 'prepend', ( isset( $prepend ) ? $prepend : '' ) ),
				'append' 					=> scm_acf_get_field_to3( $arg, 4, 'append', ( isset( $append ) ? $append : '' ) ),
				'min' 						=> scm_acf_get_field_to3( $arg, 5, 'min', ( isset( $min ) ? $min : ( strpos( $extra , '-pos' ) !== false ? 0 : ( strpos( $extra , '-min' ) !== false ? -9999 : '' ) ) ) ),
				'max' 						=> scm_acf_get_field_to3( $arg, 6, 'max', ( isset( $max ) ? $max : ( strpos( $extra , '-neg' ) !== false ? 0 : ( strpos( $extra , '-max' ) !== false ? 9999 : '' ) ) ) ),
				'step' 						=> scm_acf_get_field_to3( $arg, 7, 'step', ( isset( $step ) ? $step : 1 ) ),
				'readonly' 					=> scm_acf_get_field_to3( $arg, 8, 'read', ( isset( $read ) ? $read : ( strpos( $extra , '-read' ) !== false ? 1 : 0 ) ) ),
				'disabled' 					=> scm_acf_get_field_to3( $arg, 9, 'disabled', ( isset( $dis ) ? $dis : ( strpos( $extra , '-disabled' ) !== false ? 1 : 0 ) ) ),
			);

    	break;

    	case 'text':
    	case 'id':
    	case 'class':
    	case 'attributes':
    	case 'name':
    	case 'link':
    	case 'email':
    	case 'user':
    	case 'phone':
    	case 'video':

    		switch ( $type ) {
    			case 'id':				$prepend = '#';								$place = __( 'id', SCM_THEME );															break;
    			case 'class':			$prepend = '.';								$place = __( 'class', SCM_THEME ); 														break;
    			case 'attributes': 		$prepend = __( 'Data', SCM_THEME );			$place = 'data-href="www.website.com" data-target="_blank"';							break;
    			case 'name':			$prepend = __( 'Nome', SCM_THEME );			$place = __( 'senza nome', SCM_THEME ); 			$maxl = 30;							break;
    			case 'link': 			$prepend = __( 'URL', SCM_THEME ); 			$place = 'http://www.website.com';														break;
    			case 'email': 			$prepend = __( 'Email', SCM_THEME ); 		$place = 'info@website.com';															break;
    			case 'user': 			$prepend = __( 'Utente', SCM_THEME ); 		$place = __( 'nome utente', SCM_THEME );												break;
    			case 'phone': 			$prepend = __( 'N.', SCM_THEME ); 			$place = '+39 123 4567';																break;
    			case 'video': 			$prepend = __( 'YouTube', SCM_THEME ); 		$place = 'https://www.youtube.com/watch?v=BVKXzNV6Z0c&list=PL4F1941886E6F2A16';			break;
    		}

			$field = array(
    			'type' 						=> 'text',
				'default_value' 			=> scm_acf_get_field_to3( $arg, 1, 'default', '' ),
				'placeholder' 				=> scm_acf_get_field_to3( $arg, 2, 'placeholder', ( isset( $place ) ? $place : '' ) ),
				'prepend' 					=> scm_acf_get_field_to3( $arg, 3, 'prepend', ( isset( $prepend ) ? $prepend : '' ) ),
				'append' 					=> scm_acf_get_field_to3( $arg, 4, 'append', ( isset( $append ) ? $append : '' ) ),
				'maxlength' 				=> scm_acf_get_field_to3( $arg, 5, 'max', ( isset( $maxl ) ? $maxl : '' ) ),
				'readonly' 					=> scm_acf_get_field_to3( $arg, 6, 'read', ( isset( $read ) ? $read : ( strpos( $extra , '-read' ) !== false ? 1 : 0 ) ) ),
				'disabled' 					=> scm_acf_get_field_to3( $arg, 7, 'disabled', ( isset( $dis ) ? $dis : ( strpos( $extra , '-disabled' ) !== false ? 1 : 0 ) ) ),
			);

		break;

    	case 'textarea':

			$field = array(
				'type' 						=> 'textarea',
				'default_value' 			=> scm_acf_get_field_to3( $arg, 1, 'default', '' ),
				'placeholder' 				=> scm_acf_get_field_to3( $arg, 2, 'placeholder', '' ),
				'rows' 						=> scm_acf_get_field_to3( $arg, 3, 'rows', 8 ),
				'maxlength' 				=> scm_acf_get_field_to3( $arg, 4, 'max', '' ),
				'new_lines' 				=> scm_acf_get_field_to3( $arg, 5, 'lines', ( strpos( $extra , '-no' ) !== false ? '' : ( strpos( $extra , '-br' ) !== false ? 'br' : 'wpautop' ) ) ),
				'readonly' 					=> scm_acf_get_field_to3( $arg, 6, 'read', ( strpos( $extra , '-read' ) !== false ? 1 : 0 ) ),
				'disabled' 					=> scm_acf_get_field_to3( $arg, 7, 'disabled', ( strpos( $extra , '-disabled' ) !== false ? 1 : 0 ) ),
			);

    	break;

    	case 'editor':

    		$field = array(
    			'type' 						=> 'wysiwyg',
    			'default_value' 			=> scm_acf_get_field_to3( $arg, 1, 'default', '' ),
				'tabs' 						=> scm_acf_get_field_to3( $arg, 2, 'tabs', ( strpos( $extra, '-visual' ) !== false ? 'visual' : 'all' ) ),
				'toolbar' 					=> scm_acf_get_field_to3( $arg, 3, 'toolbar', ( strpos( $extra, '-basic' ) !== false ? 'basic' : 'normal' ) ),
				'media_upload' 				=> scm_acf_get_field_to3( $arg, 4, 'media', ( strpos( $extra, '-media' ) !== false ? 1 : 0 ) ),
			);

    	break;

    	case 'limiter':

    		$field = array(
    			'type' 						=> 'limiter',
				'character_number' 			=> scm_acf_get_field_to3( $arg, 1, 'max', ( isset( $max ) ? $max : 350 ) ),
				'display_characters' 		=> scm_acf_get_field_to3( $arg, 2, 'display', ( isset( $chars ) ? $chars : ( strpos( $extra, '-chars' ) !== false ? 1 : 0 ) ) ),
			);

    	break;

    	case 'repeater':

    		$field = array(
				'type' => 'repeater',
				'button_label' => scm_acf_get_field_to3( $arg, 1, 'button', 'Aggiungi' ),
				'min' => scm_acf_get_field_to3( $arg, 2, 'min', 0 ),
				'max' => scm_acf_get_field_to3( $arg, 3, 'max', 0 ),
				'layout' => scm_acf_get_field_to3( $arg, 4, 'layout', ( strpos( $extra , '-block' ) !== false ? 'block' : ( strpos( $extra , '-table' ) !== false ? 'table' : 'row' ) ) ),
				'sub_fields' => scm_acf_get_field_to3( $arg, 5, 'sub', array() ),
			);

    	break;
		
		case 'flexible':

    		$field = array(
				'type' => 'flexible_content',
				'button_label' => scm_acf_get_field_to3( $arg, 1, 'button', '+' ),
				'min' => scm_acf_get_field_to3( $arg, 2, 'min', '' ),
				'max' => scm_acf_get_field_to3( $arg, 3, 'max', '' ),
				'layouts' => scm_acf_get_field_to3( $arg, 4, 'layouts', array() ),
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

?>