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
*	1.0 Elements
**		Divider
**		Image
**		Icon
**		Title
**		Text
*
*	2.0 Single
**		Galleria
**		Soggetto
**		Luogo
**		Map
**		Contact Form
**		Section
*
*	3.0 Archives
**		Archive
*
*****************************************************
*/


global $SCM_acf_elements;

$SCM_acf_elements = array(
	//'archive' => __( 'Archivio', SCM_THEME ),
    'divider' => __( 'Separatore', SCM_THEME ),
    'image' => __( 'Immagine', SCM_THEME ),
    'icon' => __( 'Icona', SCM_THEME ),
    'title' => __( 'Titolo', SCM_THEME ),
    'text' => __( 'Testo', SCM_THEME ),
    'section' => __( 'Sezione', SCM_THEME ),

    /*'gallerie' => __( 'Galleria', SCM_THEME ),
    'soggetti' => __( 'Soggetto', SCM_THEME ),
    'map' => __( 'Mappa', SCM_THEME ),
    'luoghi' => __( 'Luogo', SCM_THEME ),
    'wpcf7_contact_form' => __( 'Modulo Contatto', SCM_THEME ),
    */
);

// *****************************************************
// 1.0 ELEMENTS
// *****************************************************

	// DIVIDER
	if ( ! function_exists( 'scm_acf_layout_divider' ) ) {
		function scm_acf_layout_divider( $default = 0 ) {

			$fields = scm_acf_preset_size( 'divider-height', $default, '1', 'px', 'Altezza' );

			return $fields;
		}
	}

	// IMAGE
	if ( ! function_exists( 'scm_acf_layout_image' ) ) {
		function scm_acf_layout_image( $default = 0 ) {

			$fields = array();

			// conditional
			$fields[] = scm_acf_field_select_image_format( 'image-format', $default );
			$norm = [
			[[
				'field' => 'image-format',
				'operator' => '==',
				'value' => 'norm',
			]],
			[[
				'field' => 'image-format',
				'operator' => '==',
				'value' => 'no',
			]]
			];
			$quad = [[[
				'field' => 'image-format',
				'operator' => '==',
				'value' => 'quad',
			]]];
			$full = [[[
				'field' => 'image-format',
				'operator' => '==',
				'value' => 'full',
			]]];

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
	if ( ! function_exists( 'scm_acf_layout_icon' ) ) {
		function scm_acf_layout_icon( $default = 0 ) {

			$fields = array();

			$fields[] = scm_acf_field_icon( 'icon', $default );
			$fields = array_merge( $fields, scm_acf_preset_size( 'icon-size', $default, '1', 'em', 'Dimensione' ) );
			$fields[] = scm_acf_field_select_float( 'icon-float', $default );

			return $fields;
		}
	}

	// TITLE
	if ( ! function_exists( 'scm_acf_layout_title' ) ) {
		function scm_acf_layout_title( $default = 0 ) {

			$fields = array();

			$fields[] = scm_acf_field_limiter( 'title', $default );
			$fields[] = scm_acf_field_select_headings( 'title-tag', $default, 1 );
			$fields[] = scm_acf_field( 'select_txt_alignment_title', [ 'select2-default', '', 'Allineamento' ], 'Allineamento' );

			return $fields;
		}
	}

	// TEXT
	if ( ! function_exists( 'scm_acf_layout_text' ) ) {
		function scm_acf_layout_text( $default = 0 ) {

			$fields = array();

			$fields[] = scm_acf_field_editor( 'editor', $default );

			return $fields;
		}
	}


	// SECTION
	if ( ! function_exists( 'scm_acf_layout_section' ) ) {
		function scm_acf_layout_section( $default = 0, $logic = 0 ) {

			$fields = array();

			$fields[] = scm_acf_field_objects( 'sections', $default, 'sections', 100, 0, 'Sezione' );

			return $fields;
		}
	}

	// POST
	if ( ! function_exists( 'scm_acf_layout_posts' ) ) {
		function scm_acf_layout_posts( $default = 0 ) {

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

					$part = strpos( $key, '-' );
					$key = ( $part !== false ? substr( $key, 0, $part ) : $key );

					if( function_exists( 'scm_acf_layout_' . $key ) )
						$template['sub_fields'] = call_user_func( 'scm_acf_layout_' . $key, $default );

					$fields[] = $template;

				}

				// +++ todo: aggiungi Field IsLink, che rende tutto il post un link alla pagina single.php, naturalmente se esiste un modello che single.php può pescare

			return $fields;


		}
	}

// *****************************************************
// 2.0 OBJECTS
// *****************************************************

	// GALLERIA
	if ( ! function_exists( 'scm_acf_layout_gallerie' ) ) {
		function scm_acf_layout_gallerie( $default = 0, $logic = 0 ) {

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
	if ( ! function_exists( 'scm_acf_layout_soggetti' ) ) {
		function scm_acf_layout_soggetti( $default = 0, $logic = 0 ) {

			$fields = array();

			//$fields[] = scm_acf_field_objects( 'soggetti', $default, 'soggetti', 100, 0, 'Soggetto' );
			// conditional link
			$fields[] = scm_acf_field_select( 'soggetto-link', $default, 'soggetto_link', 100, $logic, '', 'Seleziona tipo Link' );
			
			$link = scm_acf_group_condition( $logic, [ 'field' => 'soggetto-link', 'operator' => '==', 'value' => 'add' ] );

				$fields[] = scm_acf_field_link( 'soggetto-url', $default, 100, $link );

			$fields[] = scm_acf_field_select( 'soggetto-neg', $default, 'positive_negative', 100, $logic, '', 'Scegli una versione' );
			$fields[] = scm_acf_layout_soggetti_build( $default, $logic );

			return $fields;
		}
	}
	// build
	if ( ! function_exists( 'scm_acf_layout_soggetti_build' ) ) {
		function scm_acf_layout_soggetti_build( $default = 0, $logic = 0 ) {


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
			$flexible['layouts'] = scm_acf_layouts_width( '', $flexible['layouts']);

			return $flexible;
		}
	}

	// LUOGO
	if ( ! function_exists( 'scm_acf_layout_luoghi' ) ) {
		function scm_acf_layout_luoghi( $default = 0, $logic = 0 ) {

			$fields[] = scm_acf_field_select( 'luogo-map', $default, 'side_position_no_Mappa', 100, $logic, 'no', 'Mappa' );

			$map = scm_acf_group_condition( $logic, [ 'field' => 'luogo-map', 'operator' => '!=', 'value' => 'no' ] );

				$fields = array_merge( $fields, scm_acf_preset_size( 'map-width', $default, '100', '%', 'Larghezza', $map ) );
				$fields[] = scm_acf_field_positive( 'map-zoom', $default, 100, $map, '10', 'Zoom' );

			$fields[] = scm_acf_field_select_disable( 'luogo-legend', $default, 'Mostra Legenda', 100, $logic );
			$fields[] = scm_acf_layout_luoghi_build( $default, $logic );

			return $fields;
		}
	}
	// build
	if ( ! function_exists( 'scm_acf_layout_luoghi_build' ) ) {
		function scm_acf_layout_luoghi_build( $default = 0, $logic = 0 ) {


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
			$flexible['layouts'] = scm_acf_layouts_width( '', $flexible['layouts']);

			return $flexible;
		}
	}

	// RASSEGNE STAMPA
	if ( ! function_exists( 'scm_acf_layout_rassegne' ) ) {
		function scm_acf_layout_rassegne( $default = 0, $logic = 0 ) {

			$fields = [];

			$fields[] = scm_acf_layout_rassegne_build( $default, $logic );

			return $fields;
		}
	}
	// build
	if ( ! function_exists( 'scm_acf_layout_rassegne_build' ) ) {
		function scm_acf_layout_rassegne_build( $default = 0, $logic = 0 ) {

			//$fields[] = scm_acf_field_objects( 'forms', $default, 'wpcf7_contact_form', 100, 0, 'Modulo Contatti' );
			
			$flexible = scm_acf_field_flexible( 'rassegna-build', $default, 'Componi Rassegna Stampa', '+', 100, $logic );

				$layout_name = scm_acf_layout( 'name', 'block', 'Nome' );
					$layout_name['sub_fields'][] = scm_acf_field_select_headings( 'name-tag', $default, 1 );

				$layout_author = scm_acf_layout( 'author', 'block', 'Autore' );
					$layout_author['sub_fields'][] = scm_acf_field_select_headings( 'author-tag', $default, 1 );

				$layout_date = scm_acf_layout( 'date', 'block', 'Data' );
					$layout_date['sub_fields'][] = scm_acf_field_select_headings( 'date-tag', $default, 1 );


			$flexible['layouts'] = [ $layout_name, $layout_author, $layout_date ];
			$flexible['layouts'] = scm_acf_layouts_width( '', $flexible['layouts']);


			return $flexible;
		}
	}

	// DOCUMENTI
	if ( ! function_exists( 'scm_acf_layout_documenti' ) ) {
		function scm_acf_layout_documenti( $default = 0, $logic = 0 ) {

			$fields = [];

			$fields[] = scm_acf_layout_documenti_build( $default, $logic );

			return $fields;
		}
	}
	// build
	if ( ! function_exists( 'scm_acf_layout_documenti_build' ) ) {
		function scm_acf_layout_documenti_build( $default = 0, $logic = 0 ) {

			//$fields[] = scm_acf_field_objects( 'forms', $default, 'wpcf7_contact_form', 100, 0, 'Modulo Contatti' );
			
			$flexible = scm_acf_field_flexible( 'documento-build', $default, 'Componi Documento', '+', 100, $logic );

				$layout_name = scm_acf_layout( 'name', 'block', 'Nome' );
					$layout_name['sub_fields'][] = scm_acf_field_select_headings( 'name-tag', $default, 1 );

				$layout_category = scm_acf_layout( 'category', 'block', 'Categoria' );
					$layout_category['sub_fields'][] = scm_acf_field_select_headings( 'category-tag', $default, 1 );

				$layout_date = scm_acf_layout( 'date', 'block', 'Data' );
					$layout_date['sub_fields'][] = scm_acf_field_select_headings( 'date-tag', $default, 1 );


			$flexible['layouts'] = [ $layout_name, $layout_category, $layout_date ];
			$flexible['layouts'] = scm_acf_layouts_width( '', $flexible['layouts']);


			return $flexible;
		}
	}

	// VIDEO
	if ( ! function_exists( 'scm_acf_layout_video' ) ) {
		function scm_acf_layout_video( $default = 0, $logic = 0 ) {

			$fields = [];

			$fields[] = scm_acf_layout_video_build( $default, $logic );

			return $fields;
		}
	}
	// build
	if ( ! function_exists( 'scm_acf_layout_video_build' ) ) {
		function scm_acf_layout_video_build( $default = 0, $logic = 0 ) {

			//$fields[] = scm_acf_field_objects( 'forms', $default, 'wpcf7_contact_form', 100, 0, 'Modulo Contatti' );
			
			$flexible = scm_acf_field_flexible( 'video-build', $default, 'Componi Video', '+', 100, $logic );

				$layout_name = scm_acf_layout( 'name', 'block', 'Nome' );
					$layout_name['sub_fields'][] = scm_acf_field_select_headings( 'name-tag', $default, 1 );

				$layout_category = scm_acf_layout( 'category', 'block', 'Categoria' );
					$layout_category['sub_fields'][] = scm_acf_field_select_headings( 'category-tag', $default, 1 );

				$layout_date = scm_acf_layout( 'date', 'block', 'Data' );
					$layout_date['sub_fields'][] = scm_acf_field_select_headings( 'date-tag', $default, 1 );


			$flexible['layouts'] = [ $layout_name, $layout_category, $layout_date ];
			$flexible['layouts'] = scm_acf_layouts_width( '', $flexible['layouts']);


			return $flexible;
		}
	}

?>