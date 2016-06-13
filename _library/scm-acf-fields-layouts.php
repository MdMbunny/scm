<?php
/**
 * @package SCM
 */

// *****************************************************
// *	ACF LAYOUTS
// *****************************************************

/*
*****************************************************
*
*	1.0 Objects
**			Elementi
**			Section
**			Separatore
**			Immagine
**			Icona
**			Titolo
**			Quote
**			Data
**			Testo
**			Elenco Puntato
**			Contatti
**			Social Follow
**			Pulsanti
*
*	2.0 Elements and Layouts
**			Galleria
**			Soggetto + layout
**			Luogo + layout
**			Rassegna + layout
**			Documento + layout
**			Video + layout
*
*****************************************************
*/



// *****************************************************
// 1.0 OBJECTS
// *****************************************************

	// POST
	if ( ! function_exists( 'scm_acf_object' ) ) {
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
					$fields = array_merge( $fields, scm_acf_preset_taxonomies( 'archive', 0, $type, $archive ) );
					$fields[] = scm_acf_field_text( 'archive-field', array( 'placeholder'=>__( 'field-name', SCM_THEME ), 'prepend'=>__( 'Field', SCM_THEME ) ), 50 );
					$fields[] = scm_acf_field_text( 'archive-value', array( 'placeholder'=>__( 'field-value (default = postID)', SCM_THEME ), 'prepend'=>__( 'Value', SCM_THEME ) ), 50 );
				
					// conditional
					$fields[] = scm_acf_field_select( 'archive-complete', 'archive_complete', 34, $archive, 0, __( 'Opzione', SCM_THEME ) );
					$fields[] = scm_acf_field_select( 'archive-orderby', 'orderby', 33, $archive, 0, __( 'Ordine per', SCM_THEME ) );
					$fields[] = scm_acf_field_select( 'archive-ordertype', 'ordertype', 33, $archive, 0, __( 'Ordine', SCM_THEME ) );

					$custom = array( 'field' => 'archive-orderby', 'operator' => '==', 'value' => 'meta_value' );
						$fields[] = scm_acf_field_text( 'archive-order', array( 'placeholder'=>__( 'field-name', SCM_THEME ), 'prepend'=>__( 'Field', SCM_THEME ) ), 100, $custom );

					$partial_cond = scm_acf_group_condition( array( 'field' => 'archive-complete', 'operator' => '==', 'value' => 'partial' ), $archive );

						$fields[] = scm_acf_field_positive( 'archive-perpage', array( 'default'=>5, 'prepend'=>__( 'Per pagina', SCM_THEME ), 'min'=>1 ), 25, $partial_cond );
						$fields[] = scm_acf_field_number( 'archive-offset', array( 'default'=>0, 'prepend'=>__( 'Offset', SCM_THEME ) ), 25, $partial_cond );
						$fields[] = scm_acf_field_select( 'archive-pagination', 'archive_pagination', 25, $partial_cond, 0, __( 'Paginazione', SCM_THEME ) );
						$fields[] = scm_acf_field_text( 'archive-pag-text', array( 'placeholder'=>'', 'prepend'=>__( 'Button', SCM_THEME ) ), 25, $partial_cond );
				}
				
					$fields[] = scm_acf_field_editor_basic( 'archive-fallback', array( 'default'=>__('No items available yet', SCM_THEME), 'label'=>__('Fallback Text', SCM_THEME) ), 100, $archive );
					
					
			return $fields;


		}
	}

	// SLIDER
	if ( ! function_exists( 'scm_acf_object_slider' ) ) {
		function scm_acf_object_slider( $default = 0, $obj = 0, $simple = 0, $width = 100, $logic = 0 ) {

			$fields = array();

			if( !$obj )
				$fields = scm_acf_preset_term( 'slider', $default, 'sliders', __( 'Slider', SCM_THEME ), $logic, $width );

			return $fields;
		}
	}

	// SECTION
	if ( ! function_exists( 'scm_acf_object_section' ) ) {
		function scm_acf_object_section( $default = 0, $obj = 0, $tax = '', $width = 100, $logic = 0 ) {

			$fields = array();

			if( !$obj ){
				$fields[] = scm_acf_field_object( 'row', array( 
                    'type'=>'id', 
                    'types'=>'sections',
                    'taxes'=>$tax,
                    'label'=> __( 'Sezione', SCM_THEME ),
                ), $width, $logic );
			}

			return $fields;
		}
	}

	// MODULE
	if ( ! function_exists( 'scm_acf_object_module' ) ) {
		function scm_acf_object_module( $default = 0, $obj = 0, $simple = 0, $width = 100, $logic = 0 ) {

			$fields = array();
			$fields[] = scm_acf_field_object( 'row', array( 
                    'type'=>'id', 
                    'types'=>'modules',
                    'label'=>__( 'Modulo', SCM_THEME ),
                ), $width, $logic );

			return $fields;
		}
	}

	// LOGIN
	if ( ! function_exists( 'scm_acf_object_login' ) ) {
		function scm_acf_object_login( $default = 0, $obj = 0, $simple = 0, $width = 100, $logic = 0 ) {

			$fields = array();
			
			//if( !$obj )

			$fields[] = scm_acf_field_select( 'login-type', array( 
				'type'=>'links_type', 
				'choices'=>array( 'admin' => __( 'Admin', SCM_THEME ) ), 
				'label'=>__( 'Redirect', SCM_THEME ),
			), 50 );

			$link = array( 'field' => 'login-type', 'operator' => '==', 'value' => 'link' );
			$page = array( 'field' => 'login-type', 'operator' => '==', 'value' => 'page' );

			$fields[] = scm_acf_field_link( 'login-redirect', 0, 50, $link );
			$fields[] = scm_acf_field_object( 'login-redirect', array( 
                'type'=>'link', 
                'types'=>'page',
                'label'=>__( 'Pagina', SCM_THEME ),
            ), 50, $page );

			$fields[] = scm_acf_field_text( 'login-user', array( 'placeholder'=>__( 'Email Address', SCM_THEME ), 'prepend'=>__( 'Label', SCM_THEME ) ), 50, 0 );
			$fields[] = scm_acf_field_text( 'login-uservalue', array( 'placeholder'=>__( 'email@address.com', SCM_THEME ), 'prepend'=>__( 'Placeholder', SCM_THEME ) ), 50, 0 );

			$fields[] = scm_acf_field_text( 'login-password', array( 'placeholder'=>__( 'Password', SCM_THEME ), 'prepend'=>__( 'Label', SCM_THEME ) ), 50, 0 );
			$fields[] = scm_acf_field_text( 'login-send', array( 'placeholder'=>__( 'Log In', SCM_THEME ), 'prepend'=>__( 'Label', SCM_THEME ) ), 50, 0 );

			$fields[] = scm_acf_field_true( 'login-rememberme', array('label'=>'Remember Me'), 10 );
			$remember = array( 'field' => 'login-rememberme', 'operator' => '==', 'value' => 1 );
			$fields[] = scm_acf_field_text( 'login-remember', array( 'placeholder'=>__( 'Remember me', SCM_THEME ), 'prepend'=>__( 'Label', SCM_THEME ) ), 25, $remember );

			return $fields;
		}
	}

	// FORM
	if ( ! function_exists( 'scm_acf_object_form' ) ) {
		function scm_acf_object_form( $default = 0, $obj = 0, $simple = 0, $width = 100, $logic = 0 ) {

			$fields = array();
			
			if( !$obj )
				$fields[] = scm_acf_field_object( 'form', array( 
	                'type'=>'id', 
	                'types'=>'wpcf7_contact_form',
	                'label'=>__( 'Modulo Contatti', SCM_THEME ),
	            ), $width, $logic );

			return $fields;
		}
	}

	// ADDRESS
	if ( ! function_exists( 'scm_acf_object_indirizzo' ) ) {
		function scm_acf_object_indirizzo( $default = 0, $obj = 0, $simple = 0, $width = 100, $logic = 0, $req = 0 ) {

			$fields = array();

			if( !$obj )
				$fields[] = scm_acf_field_objects( 'element', array( 
	                'type'=>'id', 
	                'types'=>'luoghi',
	                'label'=>__( 'Luoghi', SCM_THEME ),
	            ), $width, $logic );

			$fields[] = scm_acf_field_text( 'separator', array( 'placeholder'=>'-', 'prepend'=>__( 'Separatore', SCM_THEME ) ), $width, $logic );
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
	}

	// MAP
	if ( ! function_exists( 'scm_acf_object_map' ) ) {
		function scm_acf_object_map( $default = 0, $obj = 0, $simple = 0, $width = 100, $logic = 0, $req = 0 ) {

			$fields = array();

			if( !$obj ){
				$fields[] = scm_acf_field_objects( 'element', array( 
	                'type'=>'id', 
	                'types'=>'luoghi',
	                'label'=>__( 'Luoghi', SCM_THEME ),
	            ), $width, $logic );
				$fields = array_merge( $fields, scm_acf_preset_taxonomies( '', $default, 'luoghi' ) );
			}

			$fields[] = scm_acf_field_positive( 'zoom', array( 'default'=>10, 'prepend'=>__( 'Zoom', SCM_THEME ) ), $width, $logic );
			// +++ todo
			/*$fields[] = scm_acf_field_select( 'address', array(
				'type'=>'map_address',
				'choices'=>array( 'no' => __( 'Nascondi indirizzo', SCM_THEME ), 'sotto' => __( 'Indirizzo Sotto', SCM_THEME ), 'up' => __( 'Indirizzo sopra', SCM_THEME ) ),
				'label'=>__( 'Mostra Indirizzo', SCM_THEME ),
			), $width, $logic, $req );*/

			return $fields;
		}
	}

	// DIVIDER
	if ( ! function_exists( 'scm_acf_object_separatore' ) ) {
		function scm_acf_object_separatore( $default = 0, $obj = 0, $simple = 0, $width = 100, $logic = 0, $req = 0 ) {

			$fields = array();

			// conditional
			$fields[] = scm_acf_field_select( 'line', 'line_style', $width, $logic, $req, __( 'Stile', SCM_THEME ) );

			if( !$simple ){

				$do = array( $logic, array( 'field' => 'line', 'operator' => '!=', 'value' => 'no' ) );
				$line = array( $logic, array( 'field' => 'line', 'operator' => '==', 'value' => 'line' ) );
				$dash = array( $logic, array( 'field' => 'line', 'operator' => '==', 'value' => 'dashed' ) );

				// +++ todo: aggiungere bg_image e tutte bg_cose

				$height = scm_acf_preset_size( 'height', 0, '1', 'px', __( 'Altezza', SCM_THEME ), $width );
				$position = scm_acf_preset_size( 'position', '', 50, '%', __( 'Posizione', SCM_THEME ), $width, $dash );
				$size = scm_acf_preset_size( 'size', 0, '4', 'px', __( 'Spessore', SCM_THEME ), $width, $do );
				$space = scm_acf_preset_size( 'space', 0, '26', 'px', __( 'Spazio', SCM_THEME ), $width, $dash );
				//$space_dot = scm_acf_preset_size( 'space', 0, '26', 'px', 'Spazio', $width, $dot );
				$weight = scm_acf_preset_size( 'dash', 0, '8', 'px', __( 'Tratto', SCM_THEME ), $width, $dash );
				$cap = array( scm_acf_field_select( 'cap', 'line_cap', $width, $do, 0, __( 'Cap', SCM_THEME ) ) );
				$color = scm_acf_preset_rgba( 'color', '', 1, $width, $do );
					
				$fields = array_merge( $fields, $height, $position, $cap, $size, $space, $weight, $color );

			}

			return $fields;
		}
	}

	// IMAGE
	if ( ! function_exists( 'scm_acf_object_immagine' ) ) {
		function scm_acf_object_immagine( $default = 0, $obj = 0, $simple = 0, $width = 100, $logic = 0 ) {

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
	}

	// ICON
	if ( ! function_exists( 'scm_acf_object_icona' ) ) {
		function scm_acf_object_icona( $default = 0, $obj = 0, $simple = 0, $width = 100, $logic = 0 ) {

			$fields = array();

			$fields[] = scm_acf_field_icon( 'icon', $default );

			if( !$simple )
				$fields = array_merge( $fields, scm_acf_preset_size( 'size', 1, '1', 'em', __( 'Dimensione', SCM_THEME ), $width, $logic ) );

			return $fields;
		}
	}

	// TITLE
	if ( ! function_exists( 'scm_acf_object_titolo' ) ) {
		function scm_acf_object_titolo( $default = 0, $obj = 0, $filter = '', $width = 100, $logic = 0 ) { // $filter = 1 || low, -1 || min, 2 || max

			$fields = array();

			if ( !$obj )
				$fields[] = scm_acf_field_textarea( 'title', 0, $width, $logic );

			if( !is_string( $filter ) ){
				switch( $filter ) {
					case 1: $filter = '_low'; break;
					case -1: $filter = '_min'; break;
					case 2: $filter = '_max'; break;
					default: $filter = ''; break;
				}
			}elseif( $filter ){
				$filter = '_' . $filter;
			}

			$fields[] = scm_acf_field_select( 'tag', 'headings' . $filter, $width, $logic );

			return $fields;
		}
	}

	// QUOTE
	if ( ! function_exists( 'scm_acf_object_quote' ) ) {
		function scm_acf_object_quote( $default = 0, $obj = 0, $simple = 0, $width = 100, $logic = 0 ) {

			$fields = array();

			$fields[] = scm_acf_field_icon_no( 'prepend', array('default'=>'no_typography', 'filter'=>'quote', 'label'=>__( 'Apertura', SCM_THEME ) ), $width*.5, $logic );
			$fields[] = scm_acf_field_icon_no( 'append', array('default'=>'no_typography', 'filter'=>'quote', 'label'=>__( 'Chiusura', SCM_THEME ) ), $width*.5, $logic );

			if ( !$obj )
				$fields[] = scm_acf_field_textarea( 'title', 0, $width, $logic );

			return $fields;
		}
	}

	// DATE
	if ( ! function_exists( 'scm_acf_object_data' ) ) {
		function scm_acf_object_data( $default = '', $obj = 0, $simple = 0, $width = 100, $logic = 0 ) {

			$fields = array();

			if ( !$obj )
				$fields[] = scm_acf_field_date( 'date', 0, $width, $logic );

			$fields[] = scm_acf_field_select( 'format', 'date_format', $width/3, $logic );
			$fields[] = scm_acf_field_text( 'separator', array( 'default'=>$default, 'placeholder'=>'/', 'prepend'=>__( 'Separatore', SCM_THEME ) ), $width/3, $logic );

			if( !$simple )
				$fields[] = scm_acf_field_select( 'tag', 'headings_low', $width/3, $logic );

			return $fields;
		}
	}

	// TEXT - [ V ]	
	if ( ! function_exists( 'scm_acf_object_testo' ) ) {
		function scm_acf_object_testo( $default = '', $obj = 0, $simple = 0, $width = 100, $logic = 0 ) {

			$fields = array();

			if ( !$obj ){

				if( $simple === 1 )
					$fields[] = scm_acf_field_editor_media( 'editor', $default, $width, $logic );
				else if( $simple === 2 )
					$fields[] = scm_acf_field_editor_basic( 'editor', $default, $width, $logic );
				else
					$fields[] = scm_acf_field_editor( 'editor', $default, $width, $logic );

			}

			return $fields;

		}
	}


	// LIST
	if ( ! function_exists( 'scm_acf_object_elenco_puntato' ) ) {
		function scm_acf_object_elenco_puntato( $default = 0, $obj = 0, $simple = 0, $width = 100, $logic = 0, $req = 0 ) {
			
			$fields = array();

			$fields[] = scm_acf_field_textarea( 'intro', array( 'rows'=>2, 'label'=>__( 'Introduzione:', SCM_THEME ) ), $width, $logic );

			if ( !$obj ){
				
				$links = scm_acf_field_repeater( 'list', array( 
					'button'=>__( 'Aggiungi Punto', SCM_THEME ),
					'label'=>__( 'Punti', SCM_THEME ), 
					'min'=>1,
				), $width, $logic );

					$links['sub_fields'][] = scm_acf_field_editor_basic( 'name', array( 'placeholder'=>'inserisci testo', 'label'=>__( 'Punto', SCM_THEME ) ), $width, $logic );
				$fields[] = $links;
			}
	
				$fields[] = scm_acf_field_select( 'type', 'list_type', $width*.5, $logic, $req, __( 'Punti righe', SCM_THEME ) );
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

			if( !$simple )
				$fields = array_merge( $fields, scm_acf_preset_button_shape() );


			return $fields;
		}
	}

	// CONTATTI
	if ( ! function_exists( 'scm_acf_object_contatti' ) ) {
		function scm_acf_object_contatti( $default = 0, $obj = 0, $simple = 0, $width = 100, $logic = 0, $req = 0 ) {

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

			if( !$simple )
				$fields = array_merge( $fields, scm_acf_preset_button_shape( '', $width, $logic ) );

			return $fields;
		}
	}

	// SOCIAL SHARE
	if ( ! function_exists( 'scm_acf_object_social_share' ) ) {
		function scm_acf_object_social_share( $default = 0, $obj = 0, $simple = 0, $width = 100, $logic = 0 ) {

			$fields = array();

			return $fields;
		}
	}

	// SOCIAL FOLLOW
	if ( ! function_exists( 'scm_acf_object_social_follow' ) ) {
		function scm_acf_object_social_follow( $default = 0, $obj = 0, $simple = 0, $width = 100, $logic = 0 ) {

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

			if( !$simple )
				$fields = array_merge( $fields, scm_acf_preset_button_shape( '', $width, $logic ) );

			return $fields;
		}
	}

	// BUTTONS
	if ( ! function_exists( 'scm_acf_object_pulsanti' ) ) {
		function scm_acf_object_pulsanti( $default = 0, $obj = 0, $simple = 0, $width = 100, $logic = 0, $req = 0 ) {
			
			$fields = array();

			$fields[] = scm_acf_field_textarea( 'intro', array( 'rows'=>2, 'label'=>__( 'Introduzione:', SCM_THEME ) ), $width, $logic );

			if ( !$obj ){

				$flexible = scm_acf_field_flexible( 'list', array( 
					'label'=>__( 'Aggiungi Pulsanti ', SCM_THEME ),
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

			if( !$simple )
				$fields = array_merge( $fields, scm_acf_preset_button_shape( '', $width, $logic ) );

			return $fields;
		}
	}


// *****************************************************
// 2.0 ELEMENTS and LAYOUTS
// *****************************************************

// BUILDER

	if ( ! function_exists( 'scm_acf_build_element' ) ) {
		function scm_acf_build_element( $type = '', $default = 0 ) {

		$fields = array();

		$slug = str_replace( '_', '-', $type);
	
		$fields[] = scm_acf_field_select( 'link', 'template_link-no', 34, 0, 0, __( 'Seleziona tipo Link', SCM_THEME ) );
		
		//$no = array( 'field' => 'link', 'operator' => '==', 'value' => 'no' );
		//$link = [[[ 'field' => 'link', 'operator' => '!=', 'value' => 'no' )], [[ 'field' => 'link', 'operator' => '!=', 'value' => 'template-single' )], [[ 'field' => 'link', 'operator' => '!=', 'value' => 'template' )]];
		//$temp = [[[ 'field' => 'link', 'operator' => '!=', 'value' => 'no' )], [[  'field' => 'link', 'operator' => '!=', 'value' => 'link-single'  )], [[  'field' => 'link', 'operator' => '!=', 'value' => 'link'  )]];

			//$fields[] = scm_acf_field( 'msg-element-nolink', array( 'message', 'Cliccando sull\'elemento non esisterà collegamento.' ), 'Nessun Link', 50, $no );
			$fields[] = scm_acf_field_object( 'template', array( 
                'type'=>'id-null', 
                'types'=>$slug . SCM_TEMPLATE_APP,
                'label'=>__( 'Modello', SCM_THEME ),
            ), 33 );
			$fields[] = scm_acf_field_link( 'url', 0, 33 );

// SCM Filter: Passing Fields - Receiving Fields
		$fields = apply_filters( 'scm_filter_element_before_' . $type, $fields );
		$fields = apply_filters( 'scm_filter_element_before', $fields, $slug );


		// general fields

		if( function_exists( 'scm_acf_element_' . $type ) )
			$fields = call_user_func( 'scm_acf_element_' . $type, $fields );

// SCM Filter: Passing Fields - Receiving Fields
		$fields = apply_filters( 'scm_filter_element_' . $type, $fields );
		$fields = apply_filters( 'scm_filter_element', $fields, $slug );


		$flexible = scm_acf_field_flexible( 'modules', array( 
			'label'=>__( 'Componi', SCM_THEME ),
			'button'=>'+',
		) );

			// TITLE

			$layout_name = scm_acf_layout( 'titolo', 'block', __( 'Titolo', SCM_THEME ), '', 1 );

				$layout_name['sub_fields'] = scm_acf_object_titolo( $default, 1 );

// SCM Filter: Passing Title Fields and Type - Receiving Title Fields
			$layout_name = apply_filters( 'scm_filter_layout_title_' . $type, $layout_name );
			$layout_name = apply_filters( 'scm_filter_layout_title_', $layout_name, $slug );

			// DATE

			$layout_date = scm_acf_layout( 'data', 'block', __( 'Data', SCM_THEME ), '', 1 );

// SCM Filter: Passing Date Fields and Type - Receiving Date Fields
				$layout_date = apply_filters( 'scm_filter_layout_date_' . $type, $layout_date );
				$layout_date = apply_filters( 'scm_filter_layout_date', $layout_date, $slug );

				// +++ todo: va bene tag, ma devi almeno aggiungere le fields: flexible date ( day/month/year/week/hour => format )
				$layout_date['sub_fields'][] = scm_acf_field( 'prepend', array( 'text', '', ( $default ? 'default' : '' ), __( 'Inizio', SCM_THEME ) ), __( 'Inizio', SCM_THEME ), 50 );
                $layout_date['sub_fields'][] = scm_acf_field( 'append', array( 'text', '', ( $default ? 'default' : '' ), __( 'Fine', SCM_THEME ) ), __( 'Fine', SCM_THEME ), 50 );
                $layout_date['sub_fields'] = array_merge( $layout_date['sub_fields'], scm_acf_object_data( '', 1 ) );			

			$layout_taxes = array();
			$taxes = get_object_taxonomies( $slug, 'objects' );
			reset( $taxes );
			if( sizeof( $taxes ) ){
				foreach ($taxes as $key => $value) {
					if( $key != 'language' && $key != 'post_translations' ){
						$layout_tax = array();
						$layout_tax = scm_acf_layout( 'SCMTAX-' . $value->name, 'block', $value->label, '', 1 );

							$layout_tax['sub_fields'][] = scm_acf_field( 'prepend', array( 'text', $value->label . ': ', ( $default ? 'default' : '' ), __( 'Inizio', SCM_THEME ) ), __( 'Inizio', SCM_THEME ), 25 );
							$layout_tax['sub_fields'][] = scm_acf_field_select( 'tag', array( 
								'type'=>'headings_low',
								'default'=>'span',
							), 25 );
							$layout_tax['sub_fields'][] = scm_acf_field( 'separator', array( 'text', ', ', ( $default ? 'default' : '' ), __( 'Separatore', SCM_THEME ) ), __( 'Separatore', SCM_THEME ), 25 );
							$layout_tax['sub_fields'][] = scm_acf_field( 'append', array( 'text', '.', ( $default ? 'default' : '' ), __( 'Fine', SCM_THEME ) ), __( 'Fine', SCM_THEME ), 25 );

	// SCM Filter: Passing Tax Fields and Type - Receiving Tax Fields
							$layout_tax = apply_filters( 'scm_filter_layout_tax_' . $type, $layout_tax, $value->name );
							$layout_taxes[] = apply_filters( 'scm_filter_layout_tax', $layout_tax, $value->name, $slug );
					}
				}
			}

	// Tools

			$layout_empty = array();
			
			$layout_tit = scm_acf_layout( 'titolo-empty', 'block', __( 'Titolo Vuoto', SCM_THEME ) );
                $layout_tit['sub_fields'] = array_merge( $layout_tit['sub_fields'], scm_acf_object_titolo( $default ) );

            $layout_list = scm_acf_layout( 'pulsanti', 'block', __( 'Pulsanti', SCM_THEME ) );
                $layout_list['sub_fields'] = array_merge( $layout_list['sub_fields'], scm_acf_object_pulsanti( $default ) );

            $layout_icon = scm_acf_layout( 'icona', 'block', __( 'Icona', SCM_THEME ) );
                $layout_icon['sub_fields'] = array_merge( $layout_icon['sub_fields'], scm_acf_object_icona( $default ) );

            $layout_divider = scm_acf_layout( 'separatore', 'block', __( 'Divider', SCM_THEME ) );
                $layout_divider['sub_fields'] = array_merge( $layout_divider['sub_fields'], scm_acf_object_separatore( $default ) );

            $layout_share = scm_acf_layout( 'share', 'block', __( 'Social share', SCM_THEME ) );
                $layout_share['sub_fields'] = array_merge( $layout_share['sub_fields'], scm_acf_object_social_share( $default ) );

            $layout_empty[] = $layout_tit;
            $layout_empty[] = $layout_list;
            $layout_empty[] = $layout_icon;
            $layout_empty[] = $layout_divider;
            $layout_empty[] = $layout_share;

// SCM Filter: Passing Layouts and Type - Receiving Layouts ( Column Width and Column Link will be applied )
				$flexible['layouts'] = apply_filters( 'scm_filter_layout_' . $type, array_merge( array( $layout_name, $layout_date ), $layout_taxes, $layout_empty ) );
				$flexible['layouts'] = apply_filters( 'scm_filter_layout', $flexible['layouts'], $layout_taxes, $slug );

			// layout fields

			if( function_exists( 'scm_acf_layout_' . $type ) )
				$flexible['layouts'] = call_user_func( 'scm_acf_layout_' . $type, $flexible['layouts'] );

			$flexible['layouts'] = scm_acf_layouts_preset( $flexible['layouts'], 1 );

// SCM Filter: Passing Layouts and Type - Receiving Layouts ( Column Width and Column Link won't be applied )
				$flexible['layouts'] = apply_filters( 'scm_filter_layout_after_' . $type, $flexible['layouts'] );
				$flexible['layouts'] = apply_filters( 'scm_filter_layout_after', $flexible['layouts'], $slug );


		$fields[] = $flexible;

		return $fields;

		}
	}

// GALLERIA

	// general fields
	if ( ! function_exists( 'scm_acf_element_gallerie' ) ) {
		function scm_acf_element_gallerie( $fields = array(), $default = 0 ) {
			
			// +++ todo: 'sti scm_acf_element_ non li usi, e qui hai un init da utilizzare
			// magari torna all'idea di associare queste field e il loro name, con data- che verrà assegnato all'oggetto intero

			//$fields[] = scm_acf_field_positive( 'init', $default, 100, 0, '0', 'Iniziale' );

			return $fields;
		}
	}
	// layout fields
	if ( ! function_exists( 'scm_acf_layout_gallerie' ) ) {
		function scm_acf_layout_gallerie( $layouts = array(), $default = 0 ) {

				$layout_thumb = scm_acf_layout( 'thumbs', 'block', __( 'Thumbs', SCM_THEME ) );
					$layout_thumb['sub_fields'][] = scm_acf_field_option( 'thumb', array( 'default'=>0, 'prepend'=>__( 'Thumb', SCM_THEME ) ) );
					$layout_thumb['sub_fields'] = array_merge( $layout_thumb['sub_fields'], scm_acf_preset_size( 'width', '', '150', 'px', __( 'Larghezza', SCM_THEME ) ) );
					$layout_thumb['sub_fields'] = array_merge( $layout_thumb['sub_fields'], scm_acf_preset_size( 'height', '', '120', 'px', __( 'Altezza', SCM_THEME ) ) );

				$layouts[] = $layout_thumb;

			return $layouts;

		}
	}

// SOGGETTO

	// general fields
	if ( ! function_exists( 'scm_acf_element_soggetti' ) ) {
		function scm_acf_element_soggetti( $fields = array(), $default = 0 ) {

			return $fields;

		}
	}
	// layout fields
	if ( ! function_exists( 'scm_acf_layout_soggetti' ) ) {
		function scm_acf_layout_soggetti( $layouts = array(), $default = 0 ) {
				
				$layout_logo = scm_acf_layout( 'logo', 'block', __( 'Logo', SCM_THEME ) );
					$layout_logo['sub_fields'] = array_merge( $layout_logo['sub_fields'], scm_acf_preset_size( 'width', '', 'auto', '%', __( 'Larghezza', SCM_THEME ) ) );
					$layout_logo['sub_fields'] = array_merge( $layout_logo['sub_fields'], scm_acf_preset_size( 'height', '', 'auto', '%', __( 'Altezza', SCM_THEME ) ) );
					$layout_logo['sub_fields'][] = scm_acf_field_select( 'negative', 'positive_negative', 100, 0, 0, __( 'Scegli una versione', SCM_THEME ) );

				$layout_icon = scm_acf_layout( 'logo-icona', 'block', __( 'Icona', SCM_THEME ) );
					$layout_icon['sub_fields'] = array_merge( $layout_icon['sub_fields'], scm_acf_preset_size( 'size', '', '150', 'px', __( 'Dimensione', SCM_THEME ) ) );
					$layout_icon['sub_fields'][] = scm_acf_field_select( 'negative', 'positive_negative', 100, 0, 0, __( 'Scegli una versione', SCM_THEME ) );

				$layout_c = scm_acf_layout( 'copy', 'block', __( 'Copyright', SCM_THEME ) );
					$layout_c['sub_fields'][] = scm_acf_field( 'prepend', array( 'text', '(c)', ( $default ? 'default' : '(c) = ©, (tm) = ™, (r) = ®' ), __( 'Inizio', SCM_THEME ) ), __( 'Inizio', SCM_THEME ), 25 );
					$layout_c['sub_fields'] = array_merge( $layout_c['sub_fields'], scm_acf_object_titolo( $default, 1, 1, 75 ) );

				$layout_int = scm_acf_layout( 'intestazione', 'block', __( 'Intestazione', SCM_THEME ) );
					$layout_int['sub_fields'][] = scm_acf_field( 'prepend', array( 'text', '', ( $default ? 'default' : '' ), __( 'Inizio', SCM_THEME ) ), __( 'Inizio', SCM_THEME ), 25 );
					$layout_int['sub_fields'] = array_merge( $layout_int['sub_fields'], scm_acf_object_titolo( $default, 1, 1, 50 ) );
					$layout_int['sub_fields'][] = scm_acf_field( 'append', array( 'text', '', ( $default ? 'default' : '' ), __( 'Fine', SCM_THEME ) ), __( 'Fine', SCM_THEME ), 25 );

				$layout_piva = scm_acf_layout( 'piva', 'block', __( 'P.IVA', SCM_THEME ) );
					$layout_piva['sub_fields'][] = scm_acf_field( 'prepend', array( 'text', __( 'P.IVA', SCM_THEME ) . ' ', ( $default ? 'default' : '' ), __( 'Inizio', SCM_THEME ) ), __( 'Inizio', SCM_THEME ), 25 );
					$layout_piva['sub_fields'] = array_merge( $layout_piva['sub_fields'], scm_acf_object_titolo( $default, 1, 1, 50 ) );
					$layout_piva['sub_fields'][] = scm_acf_field( 'append', array( 'text', '', ( $default ? 'default' : '' ), __( 'Fine', SCM_THEME ) ), __( 'Fine', SCM_THEME ), 25 );

				$layout_cf = scm_acf_layout( 'cf', 'block', __( 'Codice Fiscale', SCM_THEME ) );
					$layout_cf['sub_fields'][] = scm_acf_field( 'prepend', array( 'text', __( 'C.F.', SCM_THEME ) . ' ', ( $default ? 'default' : '' ), __( 'Inizio', SCM_THEME ) ), __( 'Inizio', SCM_THEME ), 25 );
					$layout_cf['sub_fields'] = array_merge( $layout_cf['sub_fields'], scm_acf_object_titolo( $default, 1, 1, 50 ) );
					$layout_cf['sub_fields'][] = scm_acf_field( 'append', array( 'text', '', ( $default ? 'default' : '' ), __( 'Fine', SCM_THEME ) ), __( 'Fine', SCM_THEME ), 25 );

				$layout_map = scm_acf_layout( 'map', 'block', __( 'Mappa', SCM_THEME ), '', 1 );
					$layout_map['sub_fields'] = scm_acf_object_map( $default, 1 );

				$layout_address = scm_acf_layout( 'indirizzo', 'block', __( 'Indirizzo', SCM_THEME ) );
					$layout_address['sub_fields'] = scm_acf_object_indirizzo( $default, 1 );
				
				// non finché non è legato al soggetto
				//$layout_form = scm_acf_layout( 'form', 'block', 'Modulo Contatti' );
					//$layout_form['sub_fields'] = scm_acf_object_form( $default );

				$layout_social = scm_acf_layout( 'social_follow', 'block', __( 'Social Link', SCM_THEME ), '', 1 );
					$layout_social['sub_fields'] = scm_acf_object_social_follow( $default, 1 );			
					
			$layouts = array_merge( $layouts, array( $layout_logo, $layout_icon, $layout_int, $layout_c, $layout_piva, $layout_cf, $layout_map, $layout_address, $layout_social ) );

			return $layouts;
		}
	}

// LUOGO

	// general fields
	if ( ! function_exists( 'scm_acf_element_luoghi' ) ) {
		function scm_acf_element_luoghi( $fields = array(), $default = 0 ) {

			return $fields;

		}
	}
	// layout fields
	if ( ! function_exists( 'scm_acf_layout_luoghi' ) ) {
		function scm_acf_layout_luoghi( $layouts = array(), $default = 0 ) {

				$layout_map = scm_acf_layout( 'map', 'block', __( 'Mappa', SCM_THEME ), '', 1 );
					$layout_map['sub_fields'] = scm_acf_object_map( $default, 1 );

				$layout_data = scm_acf_layout( 'contatti', 'block', __( 'Contatti', SCM_THEME ) );
					$layout_data['sub_fields'] = scm_acf_object_contatti( $default, 1 );		
					
				/*$layout_name = scm_acf_layout( 'nome', 'block', 'Nome' );
					$layout_name['sub_fields'][] = scm_acf_field( 'prepend', array( 'text', '', ( $default ? 'default' : '' ), 'Inizio' ), 'Inizio', 25 );
					$layout_name['sub_fields'] = array_merge( $layout_name['sub_fields'], scm_acf_object_titolo( $default, 1, 1, 50 ) );
					$layout_name['sub_fields'][] = scm_acf_field( 'append', array( 'text', '', ( $default ? 'default' : '' ), 'Fine' ), 'Fine', 25 );*/
						
				$layout_address = scm_acf_layout( 'indirizzo', 'block', __( 'Indirizzo', SCM_THEME ) );
					$layout_address['sub_fields'] = scm_acf_object_indirizzo( $default, 1 );

				/*$layout_form = scm_acf_layout( 'form', 'block', 'Modulo Contatti' );
					$layout_form['sub_fields'] = scm_acf_object_form( $default );*/

			$layouts = array_merge( $layouts, array( $layout_map, $layout_address, $layout_data ) );

			return $layouts;
		}
	}

// ARTICOLI

	// general fields
	if ( ! function_exists( 'scm_acf_element_articoli' ) ) {
		function scm_acf_element_articoli( $fields = array() ) {

			return $fields;

		}
	}
	// layout fields
	if ( ! function_exists( 'scm_acf_layout_articoli' ) ) {
		function scm_acf_layout_articoli( $layouts = array() ) {

				$layout_img = scm_acf_layout( 'immagine', 'block', __( 'Immagine', SCM_THEME ) );

				$layout_exc = scm_acf_layout( 'excerpt', 'block', __( 'Anteprima', SCM_THEME ) );
					$layout_exc['sub_fields'][] = scm_acf_field( 'prepend', array( 'text', '', '', __( 'Inizio', SCM_THEME ) ), __( 'Inizio', SCM_THEME ), 25 );
					$layout_exc['sub_fields'] = array_merge( $layout_exc['sub_fields'], scm_acf_object_titolo( '', 1, 1, 50 ) );
					$layout_exc['sub_fields'][] = scm_acf_field( 'append', array( 'text', '', '', __( 'Fine', SCM_THEME ) ), __( 'Fine', SCM_THEME ), 25 );

				$layout_art = scm_acf_layout( 'testo', 'block', __( 'Testo', SCM_THEME ) );
					$layout_art['sub_fields'] = array_merge( $layout_art['sub_fields'], scm_acf_object_testo( '', 1 ) );

			$layouts = array_merge( $layouts, array( $layout_img, $layout_exc, $layout_art ) );

			return $layouts;
		}
	}

// NEWS

	// general fields
	if ( ! function_exists( 'scm_acf_element_news' ) ) {
		function scm_acf_element_news( $fields = array(), $default = 0 ) {

			return $fields;

		}
	}
	// layout fields
	if ( ! function_exists( 'scm_acf_layout_news' ) ) {
		function scm_acf_layout_news( $layouts = array(), $default = 0 ) {

				$layout_img = scm_acf_layout( 'immagine', 'block', __( 'Immagine', SCM_THEME ) );

				$layout_mod = scm_acf_layout( 'modules', 'block', __( 'News', SCM_THEME ) );

			$layouts = array_merge( $layouts, array( $layout_img, $layout_mod ) );

			return $layouts;
		}
	}

// RASSEGNE STAMPA

	// general fields
	if ( ! function_exists( 'scm_acf_element_rassegne_stampa' ) ) {
		function scm_acf_element_rassegne_stampa( $fields = array(), $default = 0 ) {

			return $fields;

		}
	}
	// layout fields
	if ( ! function_exists( 'scm_acf_layout_rassegne_stampa' ) ) {
		function scm_acf_layout_rassegne_stampa( $layouts = array(), $default = 0 ) {
			
			return $layouts;
		}
	}

// DOCUMENTI

	// general fields
	if ( ! function_exists( 'scm_acf_element_documenti' ) ) {
		function scm_acf_element_documenti( $fields = array(), $default = 0 ) {

			return $fields;
		}
	}
	// layout fields
	if ( ! function_exists( 'scm_acf_layout_documenti' ) ) {
		function scm_acf_layout_documenti( $layouts = array(), $default = 0 ) {
						
			return $layouts;
		}
	}

// VIDEO

	// general fields
	if ( ! function_exists( 'scm_acf_element_video' ) ) {
		function scm_acf_element_video( $fields = array(), $default = 0 ) {

			return $fields;
		}
	}
	// layout fields
	if ( ! function_exists( 'scm_acf_layout_video' ) ) {
		function scm_acf_layout_video( $layouts = array(), $default = 0 ) {

			$layouts[] = scm_acf_layout( 'immagine', 'block', __( 'Thumb', SCM_THEME ) );
			return $layouts;
		}
	}


?>