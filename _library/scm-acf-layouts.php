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
**			Testo
**			Elenco Puntato
**			Elenco Link
**			Elenco File
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
		function scm_acf_object( $type = '', $default = 0 ) {

			$fields = array();

			if( !$type )
				return $fields;

				$fields[] = scm_acf_field_select1( 'type', $default, 'archive_mode', 100, 0, '', 'Elementi' );
			
				$fields[] = scm_acf_field_object( 'template', $default, $type . '_temp', 50, 0, 'Modello' );
				$fields[] = scm_acf_field_select1( 'width', $default, 'columns_width', 50, 0, [ 'auto' => 'Larghezza' ], 'Larghezza Elementi' );
								
				$single = [ 'field' => 'type', 'operator' => '==', 'value' => 'single' ];
				$archive = [ 'field' => 'type', 'operator' => '==', 'value' => 'archive' ];
					
					$fields[] = scm_acf_field_objects( 'single', $default, $type, 100, $single, $type );
					$fields = array_merge( $fields, scm_acf_preset_taxonomies( 'archive', $default, $type, 'Filtra', $archive ) );
				
					// conditional
					$fields[] = scm_acf_field_select1( 'archive-complete', $default, 'archive_complete', 34, $archive, '', 'Opzione' );
					$fields[] = scm_acf_field_select( 'archive-orderby', $default, 'orderby', 33, $archive, '', 'Ordine per' );
					$fields[] = scm_acf_field_select( 'archive-ordertype', $default, 'ordertype', 33, $archive, '', 'Ordine' );

					//$complete = [[[ 'field' => 'archive-complete', 'operator' => '==', 'value' => 'complete' ]]];
					$partial_cond = scm_acf_group_condition( [ 'field' => 'archive-complete', 'operator' => '==', 'value' => 'partial' ], $archive );

						$fields[] = scm_acf_field_positive( 'archive-perpage', $default, 50, $partial_cond, '5', 'Post per pagina', 1 );
						$fields[] = scm_acf_field_select1( 'archive-pagination', $default, 'archive_pagination', 50, $partial_cond, '', 'Paginazione' );
					
					
			return $fields;


		}
	}

	// SLIDER
	if ( ! function_exists( 'scm_acf_object_slider' ) ) {
		function scm_acf_object_slider( $default = 0 ) {

			$fields = array();

			$fields = scm_acf_options_slider( '', $default );

			return $fields;
		}
	}

	// SECTION
	if ( ! function_exists( 'scm_acf_object_section' ) ) {
		function scm_acf_object_section( $default = 0 ) {

			$fields = array();

			$fields[] = scm_acf_field_object( 'sections', $default, 'sections', 100, 0, 'Sezione' );

			return $fields;
		}
	}

	// FORM
	if ( ! function_exists( 'scm_acf_object_form' ) ) {
		function scm_acf_object_form( $default = 0 ) {

			$fields = array();

			$fields[] = scm_acf_field_object( 'form', $default, 'wpcf7_contact_form', 100, 0, 'Modulo Contatti' );

			return $fields;
		}
	}

	// MAP
	if ( ! function_exists( 'scm_acf_object_map' ) ) {
		function scm_acf_object_map( $default = 0, $obj = 1 ) {

			$fields = array();

			if( $obj )
				$fields[] = scm_acf_field_objects( 'luogo', $default, 'luoghi', 100, 0, 'Luoghi' );

			$fields[] = scm_acf_field_positive( 'zoom', $default, 100, 0, '10', 'Zoom' );

			return $fields;
		}
	}

	// SOCIAL FOLLOW
	if ( ! function_exists( 'scm_acf_object_social_follow' ) ) {
		function scm_acf_object_social_follow( $default = 0, $obj = 1 ) {

			$fields = array();

			if( $obj )
				$fields[] = scm_acf_field_object( 'soggetto', $default, 'soggetti', 100, 0, 'Soggetto' );

			$fields = array_merge( $fields, scm_acf_preset_size( 'size', $default, 16, 'px' ) );
			$fields = array_merge( $fields, scm_acf_preset_rgba( 'rgba', $default ) );

			// +++ todo: aggiungere bg_image e tutte bg_cose

			$fields[] = scm_acf_field_select1( 'shape', $default, 'box_shape-no', 100, 0, 'Forma', 'Forma Box' );
				$shape = [ 'field' => 'shape', 'operator' => '!=', 'value' => 'no' ];
				$rounded = scm_acf_group_condition( $shape, [ 'field' => 'shape', 'operator' => '!=', 'value' => 'square' ] );

					$fields[] = scm_acf_field_select1( 'shape-size', $default, 'box_angle_size', 50, $rounded, 'Dimensione', 'Dimensione angoli Box' );
					$fields[] = scm_acf_field_select1( 'shape-angle', $default, 'box_angle_type', 50, $rounded, 'Angoli', 'Angoli Box' );

					$fields = array_merge( $fields, scm_acf_preset_rgba( 'box', $default, '', 1, $shape ) );

			return $fields;
		}
	}

	// DIVIDER
	if ( ! function_exists( 'scm_acf_object_separatore' ) ) {
		function scm_acf_object_separatore( $default = 0 ) {

			$fields = scm_acf_preset_size( 'divider-height', $default, '1', 'px', 'Altezza' );

			// conditional
			$fields[] = scm_acf_field_select1( 'divider-line', 0, 'line_style', 100, 0, '', 'Stile' );
			$do = [ 'field' => 'divider-line', 'operator' => '!=', 'value' => 'no' ];
			$line = [ 'field' => 'divider-line', 'operator' => '==', 'value' => 'line' ];
			$dash = [ 'field' => 'divider-line', 'operator' => '==', 'value' => 'dashed' ];
			$dot = [ 'field' => 'divider-line', 'operator' => '==', 'value' => 'dotted' ];

				$color = scm_acf_preset_rgba( 'divider-color', $default, '', '1', $do );
				$size = scm_acf_preset_size( 'divider-size', $default, '4', 'px', 'Spessore', $do );
				$cap = [ scm_acf_field_select1( 'divider-cap', $default, 'line_cap', 100, $do, '', 'Cap' ) ];
				$space_dash = scm_acf_preset_size( 'divider-space-dash', $default, '26', 'px', 'Spazio', $dash );
				$space_dot = scm_acf_preset_size( 'divider-space-dot', $default, '26', 'px', 'Spazio', $dot );
				$width = scm_acf_preset_size( 'divider-dash', $default, '8', 'px', 'Tratto', $dash );
					
				$fields = array_merge( $fields, $color, $size, $cap, $space_dot, $space_dash, $width );

			return $fields;
		}
	}

	// IMAGE
	if ( ! function_exists( 'scm_acf_object_immagine' ) ) {
		function scm_acf_object_immagine( $default = 0 ) {

			$fields = array();

			// conditional
			$fields[] = scm_acf_field_select_image_format( 'image-format', $default );
			$norm = [ 'field' => 'image-format', 'operator' => '==', 'value' => 'norm' ];
			$quad = [ 'field' => 'image-format', 'operator' => '==', 'value' => 'quad' ];
			$full = [ 'field' => 'image-format', 'operator' => '==', 'value' => 'full' ];

				$imagew = scm_acf_preset_size( 'image-width', $default, 'auto', '%', 'Larghezza', $norm );
				$imageh = scm_acf_preset_size( 'image-height', $default, 'auto', '%', 'Altezza', $norm );
				$imagef = scm_acf_preset_size( 'image-full', $default, 'auto', 'px', 'Altezza', $full );
				$imageq = scm_acf_preset_size( 'image-size', $default, 'auto', 'px', 'Dimensione', $quad );

				$fields = array_merge( $fields, $imagew, $imageh, $imagef, $imageq );

			$fields[] = scm_acf_field_image( 'image', $default );
			$fields[] = scm_acf_field_select_float( 'image-float', $default );

			return $fields;

		}
	}

	// ICON
	if ( ! function_exists( 'scm_acf_object_icona' ) ) {
		function scm_acf_object_icona( $default = 0 ) {

			$fields = array();

			$fields[] = scm_acf_field_icon( 'icon', $default );
			$fields = array_merge( $fields, scm_acf_preset_size( 'icon-size', $default, '1', 'em', 'Dimensione' ) );
			$fields[] = scm_acf_field_select_float( 'icon-float', $default );

			return $fields;
		}
	}

	// TITLE
	if ( ! function_exists( 'scm_acf_object_titolo' ) ) {
		function scm_acf_object_titolo( $default = 0 ) {

			$fields = array();

			$fields[] = scm_acf_field_limiter( 'title', $default );
			$fields[] = scm_acf_field_select_headings( 'title-tag', $default, 1 );

			return $fields;
		}
	}

	// TEXT
	if ( ! function_exists( 'scm_acf_object_testo' ) ) {
		function scm_acf_object_testo( $default = 0 ) {

			$fields = array();

			$fields[] = scm_acf_field_editor( 'editor', $default );

			return $fields;
		}
	}

	// LIST
	if ( ! function_exists( 'scm_acf_object_elenco_puntato' ) ) {
		function scm_acf_object_elenco_puntato( $default = 0 ) {
			
			$fields = array();

			$fields[] = scm_acf_field_select1( 'list-type', $default, 'list_type', 100, 0, 'Stile', 'Stile Punti' );

			$fields[] = scm_acf_field_textarea( 'list-intro', $default, 2, 100, 0, 'Introduzione:' );
			//$fields[] = scm_acf_field_limiter( 'list-intro', $default, 150 );

			$links = scm_acf_field_repeater( 'list', $default, 'Aggiungi Punto', 'Punti', 100, 0, '' );
			
				$links['sub_fields'][] = scm_acf_field( 'element', [ 'text', '', 'inserisci testo' ], 'Punto' );

			$fields[] = $links;

			return $fields;
		}
	}

	// LINKS
	if ( ! function_exists( 'scm_acf_object_elenco_link' ) ) {
		function scm_acf_object_elenco_link( $default = 0 ) {
			
			$fields = array();
			
			$links = scm_acf_field_repeater( 'links', $default, 'Aggiungi Link', 'Link' );
			
				$links['sub_fields'][] = scm_acf_field_name( 'name', $default, 30, 50, 0, '', 'Nome' );
				$links['sub_fields'][] = scm_acf_field_link( 'link', $default, 50, 0, '', 'Link' );
			
			$fields[] = $links;
			
			return $fields;
		}
	}

	// FILES
	if ( ! function_exists( 'scm_acf_object_elenco_file' ) ) {
		function scm_acf_object_elenco_file( $default = 0 ) {
			
			$fields = array();

			$attachments = scm_acf_field_repeater( 'files', $default, 'Aggiungi Allegato', 'Allegati' );
				
				$attachments['sub_fields'][] = scm_acf_field_name_req( 'name', $default, 30, 50, 0, '', 'Nome' );
				$attachments['sub_fields'][] = scm_acf_field_file( 'file', $default, 50, 0, 'File' );

			$fields[] = $attachments;
			
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
	
		$fields[] = scm_acf_field_select1( 'link', $default, 'template_link-no', 34, 0, '', 'Seleziona tipo Link' );
		
		$no = [ 'field' => 'link', 'operator' => '==', 'value' => 'no' ];
		$link = [[[ 'field' => 'link', 'operator' => '!=', 'value' => 'no' ]], [[ 'field' => 'link', 'operator' => '!=', 'value' => 'template-single' ]], [[ 'field' => 'link', 'operator' => '!=', 'value' => 'template' ]]];
		$temp = [[[ 'field' => 'link', 'operator' => '!=', 'value' => 'no' ]], [[  'field' => 'link', 'operator' => '!=', 'value' => 'link-single'  ]], [[  'field' => 'link', 'operator' => '!=', 'value' => 'link'  ]]];

			//$fields[] = scm_acf_field( 'msg-element-nolink', [ 'message', 'Cliccando sull\'elemento non esisterà collegamento.' ], 'Nessun Link', 50, $no );
			$fields[] = scm_acf_field_object( 'template', $default, $slug . '_temp', 33, 0, 'Modello' );
			$fields[] = scm_acf_field_link( 'url', $default, 33, 0 );

// SCM Filter: Passing Fields - Receiving Fields

		$fields = apply_filters( 'scm_filter_acf_element_before', $fields, $slug );

// --- filter

		// general fields

		if( function_exists( 'scm_acf_element_' . $type ) )
			$fields = call_user_func( 'scm_acf_element_' . $type, $fields );

// SCM Filter: Passing Fields - Receiving Fields

		$fields = apply_filters( 'scm_filter_acf_element', $fields, $slug );

// --- filter


		$flexible = scm_acf_field_flexible( 'build', $default, 'Componi ' . $type, '+' );

// TITLE

			$layout_name = scm_acf_layout( 'post-title', 'block', 'Titolo' );

// SCM Filter: Passing Title Link Field and Type - Receiving Title Link Field

				$layout_name['sub_fields'][] = apply_filters( 'scm_filter_acf_layout/title/link', scm_acf_field_select1( 'link', $default, 'template_link-no', 50, 0, '', 'Link' ), $slug );

// --- filter

				$layout_name['sub_fields'][] = scm_acf_field_select_headings( 'tag', $default, 1 );

// SCM Filter: Passing Title Fields and Type - Receiving Title Fields

			$layout_name = apply_filters( 'scm_filter_acf_layout/title', $layout_name, $slug );

// --- filter

// DATE

			$layout_date = scm_acf_layout( 'post-date', 'block', 'Data' );

// SCM Filter: Passing Date Link Field and Type - Receiving Date Link Field

				$layout_date['sub_fields'][] = apply_filters( 'scm_filter_acf_layout/date/link', scm_acf_field_select1( 'link', $default, 'template_link-no', 50, 0, '', 'Link' ), $slug );

// --- filter

				// +++ todo: va bene tag, ma devi almeno aggiungere le fields: flexible date ( day/month/year/week/hour => format )
				$layout_date['sub_fields'][] = scm_acf_field_select_headings( 'tag', $default, 1 );
			

			$layout_taxes = [];
			$taxes = get_object_taxonomies( $slug, 'objects' );
			reset( $taxes );
			if( sizeof( $taxes ) ){
				foreach ($taxes as $value) {
					$layout_tax = [];
					$layout_tax = scm_acf_layout( 'post-' . $value->name, 'block', $value->label );

// SCM Filter: Passing Tax Link Field and Type - Receiving Tax Link Field

						$layout_tax['sub_fields'][] = apply_filters( 'scm_filter_acf_layout/tax/link', scm_acf_field_select1( 'link', $default, 'template_link-no', 50, 0, [ 'self' => 'Link ' . $value->label ], 'Link' ), $value->name, $slug );

// --- filter

						$layout_tax['sub_fields'][] = scm_acf_field( 'prepend', [ 'text', $value->label . ': ', ( $default ? 'default' : '' ), 'Inizio' ], 'Inizio', 25 );
						$layout_tax['sub_fields'][] = scm_acf_field_select_headings( 'tag', $default, 1, 25 );
						$layout_tax['sub_fields'][] = scm_acf_field( 'separator', [ 'text', ', ', ( $default ? 'default' : '' ), 'Separatore' ], 'Separatore', 25 );
						$layout_tax['sub_fields'][] = scm_acf_field( 'append', [ 'text', '.', ( $default ? 'default' : '' ), 'Fine' ], 'Fine', 25 );

// SCM Filter: Passing Tax Fields and Type - Receiving Tax Fields

						$layout_taxes[] = apply_filters( 'scm_filter_acf_layout/tax', $layout_tax, $value->name, $slug );

// --- filter

				}
			}

// SCM Filter: Passing Date Fields and Type - Receiving Date Fields

				$layout_date = apply_filters( 'scm_filter_acf_layout/date', $layout_date, $slug );

// --- filter

// SCM Filter: Passing Layouts and Type - Receiving Layouts

				$flexible['layouts'] = apply_filters( 'scm_filter_acf_layout/width', array_merge( [ $layout_name, $layout_date ], $layout_taxes ), $slug );

// --- filter

			// layout fields

			if( function_exists( 'scm_acf_layout_' . $type ) )
				$flexible['layouts'] = call_user_func( 'scm_acf_layout_' . $type, $flexible['layouts'] );

			$flexible['layouts'] = scm_acf_layouts_link( 'column-link', $flexible['layouts'], 50);
			$flexible['layouts'] = scm_acf_layouts_width( 'column-width', $flexible['layouts'], 50);

// SCM Filter: Passing Layouts and Type - Receiving Layouts ( + Column Width )

				$flexible['layouts'] = apply_filters( 'scm_filter_acf_layout', $flexible['layouts'], $slug );

// --- filter

		$fields[] = $flexible;

		return $fields;

		}
	}

// GALLERIA

	// general fields
	if ( ! function_exists( 'scm_acf_element_gallerie' ) ) {
		function scm_acf_element_gallerie( $fields = [], $default = 0 ) {
			
			// +++ todo: 'sti scm_acf_element_ non li usi, e qui hai un init da utilizzare
			// magari torna all'idea di associare queste field e il loro name, con data- che verrà assegnato all'oggetto intero

			//$fields[] = scm_acf_field_positive( 'init', $default, 100, 0, '0', 'Iniziale' );

			return $fields;
		}
	}
	// layout fields
	if ( ! function_exists( 'scm_acf_layout_gallerie' ) ) {
		function scm_acf_layout_gallerie( $layouts = [], $default = 0 ) {

			/*$index = getByValueKey( $layouts, 'post-title', 'key' );
			if( $index !== false )
				$layouts[ $index ]['sub_fields'][0] = scm_acf_field_select1( 'link', $default, 'template_link-no', 50, 0, [ 'self' => 'Link Galleria' ], 'Link' );*/

				$layout_thumb = scm_acf_layout( 'thumb', 'block', 'Thumb' );
					//$layout_thumb['sub_fields'][] = scm_acf_field_select1( 'link', $default, 'template_link-no', 50, 0, [ 'self' => 'Link Galleria' ], 'Link' );
					$layout_thumb['sub_fields'][] = scm_acf_field_positive( 'btn-img', $default, 100, 0, 0, 'Thumb' );
					$layout_thumb['sub_fields'] = array_merge( $layout_thumb['sub_fields'], scm_acf_preset_size( 'size', $default, '150', 'px', 'Dimensione' ) );

				$layouts[] = $layout_thumb;

			return $layouts;

		}
	}

// SOGGETTO

	// general fields
	if ( ! function_exists( 'scm_acf_element_soggetti' ) ) {
		function scm_acf_element_soggetti( $fields = [], $default = 0 ) {

			return $fields;

		}
	}
	// layout fields
	if ( ! function_exists( 'scm_acf_layout_soggetti' ) ) {
		function scm_acf_layout_soggetti( $layouts = [], $default = 0 ) {

			/*$index = getByValueKey( $layouts, 'post-title', 'key' );
			if( $index !== false )
				$layouts[ $index ]['sub_fields'][0] = scm_acf_field_select1( 'link', $default, 'template_link-no', 50, 0, [ 'self' => 'Link Soggetto' ], 'Link' );*/
				
				$layout_logo = scm_acf_layout( 'logo', 'block', 'Logo' );
					//$layout_logo['sub_fields'][] = scm_acf_field_select1( 'link', $default, 'template_link-no', 50, 0, [ 'self' => 'Link Soggetto' ], 'Link' );
					$layout_logo['sub_fields'] = array_merge( $layout_logo['sub_fields'], scm_acf_preset_size( 'width', $default, 'auto', '%', 'Larghezza' ) );
					$layout_logo['sub_fields'] = array_merge( $layout_logo['sub_fields'], scm_acf_preset_size( 'height', $default, 'auto', '%', 'Altezza' ) );
					$layout_logo['sub_fields'][] = scm_acf_field_select1( 'logo-negative', $default, 'positive_negative', 100, 0, '', 'Scegli una versione' );

				$layout_icon = scm_acf_layout( 'icona', 'block', 'Icona' );
					//$layout_icon['sub_fields'][] = scm_acf_field_select1( 'link', $default, 'template_link-no', 50, 0, [ 'self' => 'Link Soggetto' ], 'Link' );
					$layout_icon['sub_fields'] = array_merge( $layout_icon['sub_fields'], scm_acf_preset_size( 'size', $default, '150', 'px', 'Dimensione' ) );
					$layout_icon['sub_fields'][] = scm_acf_field_select1( 'icon-negative', $default, 'positive_negative', 100, 0, '', 'Scegli una versione' );

				$layout_int = scm_acf_layout( 'intestazione', 'block', 'Intestazione' );
					//$layout_int['sub_fields'][] = scm_acf_field_select1( 'link', $default, 'template_link-no', 50, 0, [ 'self' => 'Link Soggetto' ], 'Link' );
					$layout_int['sub_fields'][] = scm_acf_field_select_headings( 'tag', $default, 1 );

				$layout_piva = scm_acf_layout( 'piva', 'block', 'P.IVA' );
					//$layout_piva['sub_fields'][] = scm_acf_field_select1( 'link', $default, 'template_link-no', 50, 0, [ 'self' => 'Link Soggetto' ], 'Link' );
					$layout_piva['sub_fields'][] = scm_acf_field_select_headings( 'tag', $default, 1 );

				$layout_cf = scm_acf_layout( 'cf', 'block', 'Codice Fiscale' );
					//$layout_cf['sub_fields'][] = scm_acf_field_select1( 'link', $default, 'template_link-no', 50, 0, [ 'self' => 'Link Soggetto' ], 'Link' );
					$layout_cf['sub_fields'][] = scm_acf_field_select_headings( 'tag', $default, 1 );
				
				$layout_form = scm_acf_layout( 'form', 'block', 'Modulo Contatti' );
					$layout_form['sub_fields'] = scm_acf_object_form( $default );

				$layout_social = scm_acf_layout( 'social', 'block', 'Social Link' );
					$layout_social['sub_fields'] = scm_acf_object_social_follow( $default, 0 );			
					
			$layouts = array_merge( $layouts, [ $layout_logo, $layout_icon, $layout_int, $layout_piva, $layout_cf, $layout_form, $layout_social ] );

			return $layouts;
		}
	}

// LUOGO

	// general fields
	if ( ! function_exists( 'scm_acf_element_luoghi' ) ) {
		function scm_acf_element_luoghi( $fields = [], $default = 0 ) {

			return $fields;

		}
	}
	// layout fields
	if ( ! function_exists( 'scm_acf_layout_luoghi' ) ) {
		function scm_acf_layout_luoghi( $layouts = [], $default = 0 ) {

			/*$index = getByValueKey( $layouts, 'post-title', 'key' );
			if( $index !== false )
				$layouts[ $index ]['sub_fields'][0] = scm_acf_field_select1( 'link', $default, 'template_link-no', 50, 0, [ 'self' => 'Link Google Map' ], 'Link' );*/

				$layout_map = scm_acf_layout( 'map', 'block', 'Mappa' );
					$layout_map['sub_fields'] = scm_acf_object_map( $default, 0 );

				$layout_data = scm_acf_layout( 'data', 'block', 'Dati' );
					
					$data = scm_acf_field_flexible( 'datas', $default, 'Componi Dati', '+', 100 );

						$layout_name = scm_acf_layout( 'name', 'block', 'Nome' );
							//$layout_name['sub_fields'][] = scm_acf_field_select1( 'link', $default, 'template_link-no', 50, 0, [ 'self' => 'Link Google Map' ], 'Link' );
							$layout_name['sub_fields'][] = scm_acf_field_select_headings( 'tag', $default, 1 );
						
						$layout_address = scm_acf_layout( 'address', 'block', 'Indirizzo' );
							//$layout_address['sub_fields'][] = scm_acf_field_select1( 'link', $default, 'template_link-no', 50, 0, [ 'self' => 'Link Google Map' ], 'Link' );
							$layout_address['sub_fields'][] = scm_acf_field_select_headings( 'tag', $default, 1 );
							$layout_address['sub_fields'][] = scm_acf_field_text( 'separator', $default, 100, 0, '-', 'Separatore' );
							$layout_address['sub_fields'][] = scm_acf_field_select_hide( 'icon', $default, 'Icona' );

						$layout_num = scm_acf_layout( 'num', 'block', 'Numeri' );
							$layout_num['sub_fields'][] = scm_acf_field_select_headings( 'tag', $default, 1 );
							$layout_num['sub_fields'][] = scm_acf_field_text( 'separator', $default, 100, 0, '-', 'Separatore' );
							$layout_num['sub_fields'][] = scm_acf_field_select_hide( 'icon', $default, 'Icona' );
							$layout_num['sub_fields'][] = scm_acf_field_select_hide( 'legend', $default, 'Legenda' );

						$layout_email = scm_acf_layout( 'email', 'block', 'Email' );
							$layout_email['sub_fields'][] = scm_acf_field_select_headings( 'tag', $default, 1 );
							$layout_email['sub_fields'][] = scm_acf_field_text( 'separator', $default, 100, 0, '-', 'Separatore' );
							$layout_email['sub_fields'][] = scm_acf_field_select_hide( 'icon', $default, 'Icona' );
							$layout_email['sub_fields'][] = scm_acf_field_select_hide( 'legend', $default, 'Legenda' );

						$layout_link = scm_acf_layout( 'link', 'block', 'Link' );
							$layout_link['sub_fields'][] = scm_acf_field_select_headings( 'tag', $default, 1 );
							$layout_link['sub_fields'][] = scm_acf_field_text( 'separator', $default, 100, 0, '-', 'Separatore' );
							$layout_link['sub_fields'][] = scm_acf_field_select_hide( 'icon', $default, 'Icona' );
							$layout_link['sub_fields'][] = scm_acf_field_select_hide( 'legend', $default, 'Legenda' );

					$data['layouts'] = [ $layout_name, $layout_address, $layout_num, $layout_email, $layout_link ];
					$data['layouts'] = scm_acf_layouts_width( 'column-width', $data['layouts']);

				$layout_data['sub_fields'][] = $data;

				$layout_form = scm_acf_layout( 'form', 'block', 'Modulo Contatti' );
					$layout_form['sub_fields'] = scm_acf_object_form( $default );

			$layouts = array_merge( $layouts, [ $layout_map, $layout_data, $layout_form ] );

			return $layouts;
		}
	}

// RASSEGNE STAMPA

	// general fields
	if ( ! function_exists( 'scm_acf_element_rassegne_stampa' ) ) {
		function scm_acf_element_rassegne_stampa( $fields = [], $default = 0 ) {

			return $fields;

		}
	}
	// layout fields
	if ( ! function_exists( 'scm_acf_layout_rassegne_stampa' ) ) {
		function scm_acf_layout_rassegne_stampa( $layouts = [], $default = 0 ) {

			/*$index = getByValueKey( $layouts, 'post-title', 'key' );
			if( $index !== false )
				$layouts[ $index ]['sub_fields'][0] = scm_acf_field_select1( 'link', $default, 'template_link-no', 50, 0, [ 'self' => 'Link Rassegna Stampa' ], 'Link' );*/
			
			return $layouts;
		}
	}

// DOCUMENTI

	// general fields
	if ( ! function_exists( 'scm_acf_element_documenti' ) ) {
		function scm_acf_element_documenti( $fields = [], $default = 0 ) {

			return $fields;
		}
	}
	// layout fields
	if ( ! function_exists( 'scm_acf_layout_documenti' ) ) {
		function scm_acf_layout_documenti( $layouts = [], $default = 0 ) {
			
			/*$index = getByValueKey( $layouts, 'post-title', 'key' );
			if( $index !== false )
				$layouts[ $index ]['sub_fields'][0] = scm_acf_field_select1( 'link', $default, 'template_link-no', 50, 0, [ 'self' => 'Link Documento' ], 'Link' );*/
			
			return $layouts;
		}
	}

// VIDEO

	// general fields
	if ( ! function_exists( 'scm_acf_element_video' ) ) {
		function scm_acf_element_video( $fields = [], $default = 0 ) {

			return $fields;
		}
	}
	// layout fields
	if ( ! function_exists( 'scm_acf_layout_video' ) ) {
		function scm_acf_layout_video( $layouts = [], $default = 0 ) {

			/*$index = getByValueKey( $layouts, 'post-title', 'key' );
			if( $index !== false )
				$layouts[ $index ]['sub_fields'][0] = scm_acf_field_select1( 'link', $default, 'template_link-no', 50, 0, [ 'self' => 'Link YouTube' ], 'Link' );*/
			
			return $layouts;
		}
	}

	global $SCM_acf_objects, $SCM_acf_elements, $SCM_acf_layouts;
	$arr = get_defined_functions();
	foreach ( $arr['user'] as $value ) {
		if( strpos( $value, 'scm_acf_object_') === 0 )
			$SCM_acf_objects[] = str_replace( 'scm_acf_object_', '', $value );
		if( strpos( $value, 'scm_acf_element_') === 0 )
			$SCM_acf_elements[] = str_replace( 'scm_acf_element_', '', $value );
		if( strpos( $value, 'scm_acf_layout_') === 0 )
			$SCM_acf_layouts[] = str_replace( 'scm_acf_layout_', '', $value );
	}

?>