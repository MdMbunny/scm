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
	if ( ! function_exists( 'scm_acf_object_elementi' ) ) {
		function scm_acf_object_elementi( $default = 0 ) {

			global $SCM_types;

			$fields = array();

			$fields[] = scm_acf_field( 'tab-build-set', 'tab-left', 'Impostazioni' );

				$fields[] = scm_acf_field_select1( 'build-type', $default, 'types_all', 100, 0, '', 'Tipologia' );
				$fields[] = scm_acf_field_select1( 'build-elements', $default, 'archive_mode', 100, 0, '', 'Elementi' );
				
				$single = [[[ 'field' => 'build-elements', 'operator' => '==', 'value' => 'single' ]]];
				$archive = [[[ 'field' => 'build-elements', 'operator' => '==', 'value' => 'archive' ]]];
				reset( $SCM_types['all'] );
				foreach ( $SCM_types['all'] as $key => $value) {
					$condition = [[[ 'field' => 'build-type', 'operator' => '==', 'value' => $key ]]];
					$single_cond = scm_acf_group_condition( $single, $condition );
					$archive_cond = scm_acf_group_condition( $archive, $condition );
					$fields[] = scm_acf_field_objects( 'build-' . $key, $default, $key, 100, $single_cond, $value );
					$fields = array_merge( $fields, scm_acf_preset_taxonomies( 'build-archive-' . $key, $default, $key, 0, 'Filtra', $archive_cond ) );
				}

				// conditional
				$fields[] = scm_acf_field_select1( 'build-archive-complete', $default, 'archive_complete', 100, $archive, '', 'Opzione' );
				
				//$complete = [[[ 'field' => 'build-archive-complete', 'operator' => '==', 'value' => 'complete' ]]];
				$partial = [[[ 'field' => 'build-archive-complete', 'operator' => '==', 'value' => 'partial' ]]];
				$partial_cond = scm_acf_group_condition( $partial, $archive );

					$fields[] = scm_acf_field_number( 'build-archive-perpage', $default, 50, $partial_cond, '5', 'Post per pagina', 1 );
					$fields[] = scm_acf_field_select1( 'build-archive-pagination', $default, 'archive_pagination', 50, $partial_cond, '', 'Paginazione' );
				
				$fields[] = scm_acf_field_select( 'build-archive-orderby', $default, 'orderby', 50, $archive, '', 'Ordine per' );
				$fields[] = scm_acf_field_select( 'build-archive-ordertype', $default, 'ordertype', 50, $archive, '', 'Ordine' );


			$fields[] = scm_acf_field( 'tab-build-template', 'tab-left', 'Modello' );
				reset( $SCM_types['public'] );
				foreach ( $SCM_types['public'] as $key => $value) {

					$condition = [[[ 'field' => 'build-type', 'operator' => '==', 'value' => $key ]]];

					$fields[] = scm_acf_field_select( 'build-template-' . $key, $default, 'templates_' . $key, 100, $condition, [ 'build' => 'Nuovo Modello' ], 'Template' );

					$condition = scm_acf_group_condition( $condition, [ 'field' => 'build-template-' . $key, 'operator' => '==', 'value' => 'build' ] );
					$template = scm_acf_field_repeater( $key . '-template', $default, 'Nuovo Modello', 'Modello', 100, $condition, 1, 1 );

					$key = str_replace( '-', '_', $key);


					if( function_exists( 'scm_acf_element_' . $key ) )
						$template['sub_fields'] = call_user_func( 'scm_acf_element_' . $key, $default );

					$fields[] = $template;

				}

				// +++ todo: aggiungi Field IsLink, che rende tutto il post un link alla pagina single.php, naturalmente se esiste un modello che single.php può pescare

			return $fields;


		}
	}

	// SECTION
	if ( ! function_exists( 'scm_acf_object_section' ) ) {
		function scm_acf_object_section( $default = 0, $logic = 0 ) {

			$fields = array();

			$fields[] = scm_acf_field_objects( 'sections', $default, 'sections', 100, 0, 'Sezione' );

			return $fields;
		}
	}

	// DIVIDER
	if ( ! function_exists( 'scm_acf_object_separatore' ) ) {
		function scm_acf_object_separatore( $default = 0 ) {

			$fields = scm_acf_preset_size( 'divider-height', $default, '1', 'px', 'Altezza' );

			// conditional
			$fields[] = scm_acf_field_select1( 'divider-line', 0, 'line_style', 100, 0, '', 'Stile' );
			$do = [ 'field' => 'divider-line', 'operator' => '!=', 'value' => 'none' ];
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
			$fields[] = scm_acf_field_select( 'title-align', 0, 'txt_alignment', 100, 0, 'Allineamento', 'Allineamento' );

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

			$links = scm_acf_field_repeater( 'list', $default, 'Aggiungi Punto', 'Punti', 100, 0, 1 );
			
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
				
				$attachments['sub_fields'][] = scm_acf_field_name( 'name', $default, 30, 50, 0, '', 'Nome' );
				$attachments['sub_fields'][] = scm_acf_field_file( 'file', $default, 50, 0, 'File' );

			$fields[] = $attachments;
			
			return $fields;

		}
	}

// *****************************************************
// 2.0 ELEMENTS and LAYOUTS
// *****************************************************

	// GALLERIA
	if ( ! function_exists( 'scm_acf_element_gallerie' ) ) {
		function scm_acf_element_gallerie( $default = 0, $logic = 0 ) {

			$fields = array();

			//$fields[] = scm_acf_field_objects( 'gallerie', $default, 'gallerie', 100, 0, 'Galleria' );
			$fields[] = scm_acf_field_positive( 'galleria-init', $default, 100, $logic, '0', 'Iniziale' );

			// conditional link
			$fields[] = scm_acf_field_select( 'galleria-btn', $default, 'gallerie_button', 100, $logic, '', 'Scegli tipo Pulsante' );
			
			$img = scm_acf_group_condition( $logic, [ 'field' => 'galleria-btn', 'operator' => '==', 'value' => 'img' ] );
			$txt = scm_acf_group_condition( $logic, [ 'field' => 'galleria-btn', 'operator' => '==', 'value' => 'txt' ] );
			$section = scm_acf_group_condition( $logic, [ 'field' => 'galleria-btn', 'operator' => '==', 'value' => 'section' ] );

				$fields[] = scm_acf_field_positive( 'galleria-btn-img', $default, 100, $img, '0', 'Thumb' );
				$fields = array_merge( $fields, scm_acf_preset_size( 'galleria-btn-img-size', $default, '150', 'px', 'Dimensione', $img ) );

				$fields[] = scm_acf_field_text( 'galleria-btn-txt', $default, 100, $txt, 'Galleria', 'Testo' );
				$fields[] = scm_acf_field_image( 'galleria-btn-txt-bg', $default, 100, $txt, 'Sfondo pulsante' );

				$fields[] = scm_acf_field_object( 'galleria-btn-section', $default, 'sections', 100, $section, 'Sezione' );

			return $fields;
		}
	}

	// SOGGETTO
	if ( ! function_exists( 'scm_acf_element_soggetti' ) ) {
		function scm_acf_element_soggetti( $default = 0, $logic = 0 ) {

			$fields = array();

			//$fields[] = scm_acf_field_objects( 'soggetti', $default, 'soggetti', 100, 0, 'Soggetto' );
			// conditional link
			$fields[] = scm_acf_field_select( 'soggetto-link', $default, 'soggetto_link', 100, $logic, '', 'Seleziona tipo Link' );
			
			$link = scm_acf_group_condition( $logic, [ 'field' => 'soggetto-link', 'operator' => '==', 'value' => 'add' ] );

				$fields[] = scm_acf_field_link( 'soggetto-url', $default, 100, $link );

			$fields[] = scm_acf_field_select( 'soggetto-neg', $default, 'positive_negative', 100, $logic, '', 'Scegli una versione' );
			$fields[] = scm_acf_layout_soggetti( $default, $logic );

			return $fields;
		}
	}
	// layout
	if ( ! function_exists( 'scm_acf_layout_soggetti' ) ) {
		function scm_acf_layout_soggetti( $default = 0, $logic = 0 ) {


			$flexible = scm_acf_field_flexible( 'soggetto-build', $default, 'Componi Soggetto', '+', 100, $logic );
				
				$layout_logo = scm_acf_layout( 'logo', 'block', 'Logo' );
					$layout_logo['sub_fields'] = scm_acf_preset_size( 'logo-width', $default, '100', '%', 'Larghezza' );

				$layout_icon = scm_acf_layout( 'icona', 'block', 'Icona' );
					$layout_icon['sub_fields'] = scm_acf_preset_size( 'icona-size', $default, '150', 'px', 'Dimensione' );

				$layout_int = scm_acf_layout( 'intestazione', 'block', 'Intestazione' );
					$layout_int['sub_fields'][] = scm_acf_field_select_headings( 'intestazione-tag', $default, 1 );

				$layout_piva = scm_acf_layout( 'piva', 'block', 'P.IVA' );
					$layout_piva['sub_fields'][] = scm_acf_field_select_headings( 'piva-tag', $default, 1 );

				$layout_cf = scm_acf_layout( 'cf', 'block', 'Codice Fiscale' );
					$layout_cf['sub_fields'][] = scm_acf_field_select_headings( 'cf-tag', $default, 1 );

			$flexible['layouts'] = [ $layout_logo, $layout_icon, $layout_int, $layout_piva, $layout_cf ];
			$flexible['layouts'] = scm_acf_layouts_width( 'column-width', $flexible['layouts']);

			return $flexible;
		}
	}

	// LUOGO
	if ( ! function_exists( 'scm_acf_element_luoghi' ) ) {
		function scm_acf_element_luoghi( $default = 0, $logic = 0 ) {

			$fields[] = scm_acf_field_select( 'luogo-map', $default, 'side_position_no_Mappa', 100, $logic, 'no', 'Mappa' );

			$map = scm_acf_group_condition( $logic, [ 'field' => 'luogo-map', 'operator' => '!=', 'value' => 'no' ] );

				$fields = array_merge( $fields, scm_acf_preset_size( 'map-width', $default, '100', '%', 'Larghezza', $map ) );
				$fields[] = scm_acf_field_positive( 'map-zoom', $default, 100, $map, '10', 'Zoom' );

			$fields[] = scm_acf_field_select_disable( 'luogo-legend', $default, 'Mostra Legenda', 100, $logic );
			$fields[] = scm_acf_layout_luoghi( $default, $logic );

			return $fields;
		}
	}
	// layout
	if ( ! function_exists( 'scm_acf_layout_luoghi' ) ) {
		function scm_acf_layout_luoghi( $default = 0, $logic = 0 ) {


			$flexible = scm_acf_field_flexible( 'luogo-build', $default, 'Componi Luogo', '+', 100, $logic );

				$layout_name = scm_acf_layout( 'name', 'block', 'Nome' );
					$layout_name['sub_fields'][] = scm_acf_field_select_headings( 'name-tag', $default, 1 );
				
				$layout_address = scm_acf_layout( 'address', 'block', 'Indirizzo' );
					$layout_address['sub_fields'][] = scm_acf_field_select_headings( 'address-tag', $default, 1 );
					$layout_address['sub_fields'][] = scm_acf_field_text( 'address-separator', $default, 100, 0, '-', 'Separatore' );
					$layout_address['sub_fields'][] = scm_acf_field_select_disable( 'address-icon', $default, 'Mostra Icona' );

				$layout_num = scm_acf_layout( 'num', 'block', 'Numeri' );
					$layout_num['sub_fields'][] = scm_acf_field_select_headings( 'num-tag', $default, 1 );
					$layout_num['sub_fields'][] = scm_acf_field_text( 'num-separator', $default, 100, 0, '-', 'Separatore' );
					$layout_num['sub_fields'][] = scm_acf_field_select_disable( 'num-icon', $default, 'Mostra Icona' );
					$layout_num['sub_fields'][] = scm_acf_field_select_disable( 'num-legend', $default, 'Mostra Legenda' );

				$layout_email = scm_acf_layout( 'email', 'block', 'Email' );
					$layout_email['sub_fields'][] = scm_acf_field_select_headings( 'email-tag', $default, 1 );
					$layout_email['sub_fields'][] = scm_acf_field_text( 'email-separator', $default, 100, 0, '-', 'Separatore' );
					$layout_email['sub_fields'][] = scm_acf_field_select_disable( 'email-icon', $default, 'Mostra Icona' );
					$layout_email['sub_fields'][] = scm_acf_field_select_disable( 'email-legend', $default, 'Mostra Legenda' );

				$layout_link = scm_acf_layout( 'link', 'block', 'Link' );
					$layout_link['sub_fields'][] = scm_acf_field_select_headings( 'link-tag', $default, 1 );
					$layout_link['sub_fields'][] = scm_acf_field_text( 'link-separator', $default, 100, 0, '-', 'Separatore' );
					$layout_link['sub_fields'][] = scm_acf_field_select_disable( 'link-icon', $default, 'Mostra Icona' );
					$layout_link['sub_fields'][] = scm_acf_field_select_disable( 'link-legend', $default, 'Mostra Legenda' );

			$flexible['layouts'] = [ $layout_name, $layout_address, $layout_num, $layout_email, $layout_link ];
			$flexible['layouts'] = scm_acf_layouts_width( 'column-width', $flexible['layouts']);

			return $flexible;
		}
	}

	// RASSEGNE STAMPA
	if ( ! function_exists( 'scm_acf_element_rassegne_stampa' ) ) {
		function scm_acf_element_rassegne_stampa( $default = 0, $logic = 0 ) {

			$fields = [];

			$fields[] = scm_acf_layout_rassegne_stampa( $default, $logic );

			return $fields;
		}
	}
	// layout
	if ( ! function_exists( 'scm_acf_layout_rassegne_stampa' ) ) {
		function scm_acf_layout_rassegne_stampa( $default = 0, $logic = 0 ) {

			//$fields[] = scm_acf_field_objects( 'forms', $default, 'wpcf7_contact_form', 100, 0, 'Modulo Contatti' );
			
			$flexible = scm_acf_field_flexible( 'rassegna-build', $default, 'Componi Rassegna Stampa', '+', 100, $logic );

				$layout_name = scm_acf_layout( 'name', 'block', 'Nome' );
					$layout_name['sub_fields'][] = scm_acf_field_select_headings( 'name-tag', $default, 1 );

				$layout_author = scm_acf_layout( 'author', 'block', 'Autore' );
					$layout_author['sub_fields'][] = scm_acf_field_select_headings( 'author-tag', $default, 1 );

				$layout_date = scm_acf_layout( 'date', 'block', 'Data' );
					$layout_date['sub_fields'][] = scm_acf_field_select_headings( 'date-tag', $default, 1 );


			$flexible['layouts'] = [ $layout_name, $layout_author, $layout_date ];
			$flexible['layouts'] = scm_acf_layouts_width( 'column-width', $flexible['layouts']);


			return $flexible;
		}
	}

	// DOCUMENTI
	if ( ! function_exists( 'scm_acf_element_documenti' ) ) {
		function scm_acf_element_documenti( $default = 0, $logic = 0 ) {

			$fields = [];

			$fields[] = scm_acf_layout_documenti( $default, $logic );

			return $fields;
		}
	}
	// layout
	if ( ! function_exists( 'scm_acf_layout_documenti' ) ) {
		function scm_acf_layout_documenti( $default = 0, $logic = 0 ) {

			//$fields[] = scm_acf_field_objects( 'forms', $default, 'wpcf7_contact_form', 100, 0, 'Modulo Contatti' );
			
			$flexible = scm_acf_field_flexible( 'documento-build', $default, 'Componi Documento', '+', 100, $logic );

				$layout_name = scm_acf_layout( 'name', 'block', 'Nome' );
					$layout_name['sub_fields'][] = scm_acf_field_select_headings( 'name-tag', $default, 1 );

				$layout_category = scm_acf_layout( 'category', 'block', 'Categoria' );
					$layout_category['sub_fields'][] = scm_acf_field_select_headings( 'category-tag', $default, 1 );

				$layout_date = scm_acf_layout( 'date', 'block', 'Data' );
					$layout_date['sub_fields'][] = scm_acf_field_select_headings( 'date-tag', $default, 1 );


			$flexible['layouts'] = [ $layout_name, $layout_category, $layout_date ];
			$flexible['layouts'] = scm_acf_layouts_width( 'column-width', $flexible['layouts']);


			return $flexible;
		}
	}

	// VIDEO
	if ( ! function_exists( 'scm_acf_element_video' ) ) {
		function scm_acf_element_video( $default = 0, $logic = 0 ) {

			$fields = [];

			$fields[] = scm_acf_layout_video( $default, $logic );

			return $fields;
		}
	}
	// layout
	if ( ! function_exists( 'scm_acf_layout_video' ) ) {
		function scm_acf_layout_video( $default = 0, $logic = 0 ) {

			//$fields[] = scm_acf_field_objects( 'forms', $default, 'wpcf7_contact_form', 100, 0, 'Modulo Contatti' );
			
			$flexible = scm_acf_field_flexible( 'video-build', $default, 'Componi Video', '+', 100, $logic );

				$layout_name = scm_acf_layout( 'name', 'block', 'Nome' );
					$layout_name['sub_fields'][] = scm_acf_field_select_headings( 'name-tag', $default, 1 );

				$layout_category = scm_acf_layout( 'category', 'block', 'Categoria' );
					$layout_category['sub_fields'][] = scm_acf_field_select_headings( 'category-tag', $default, 1 );

				$layout_date = scm_acf_layout( 'date', 'block', 'Data' );
					$layout_date['sub_fields'][] = scm_acf_field_select_headings( 'date-tag', $default, 1 );


			$flexible['layouts'] = [ $layout_name, $layout_category, $layout_date ];
			$flexible['layouts'] = scm_acf_layouts_width( 'column-width', $flexible['layouts']);


			return $flexible;
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