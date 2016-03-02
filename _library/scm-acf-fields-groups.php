<?php
/**
 * @package SCM
 */

// *****************************************************
// *	ACF FIELDS GROUPS
// *****************************************************

	// TEMPLATES
	if ( ! function_exists( 'scm_acf_fields_template' ) ) {
		function scm_acf_fields_template( $name = '', $default = 0, $logic = 0, $instructions = '', $required = 0, $class = 'posts-repeater' ) {

			$instructions = ( $instructions ?: __( 'Costruisci dei modelli da poter poi scegliere durante la creazione di nuovi contenuti. Per ogni modello è obbligatorio inserire almeno il Nome.', SCM_THEME ) );

			if( !$name )
				return;

			$fields = array();


			$template = scm_acf_field_repeater( $name . '-templates', $default, __( 'Aggiungi Modello', SCM_THEME ), __( 'Modelli', SCM_THEME ), 100, $logic, '', '', $instructions, $required, $class );

				$template['sub_fields'][] = scm_acf_field_name_req( 'name',  $default, '', 60, 0, __( 'Nome Modello', SCM_THEME ), __( 'Nome', SCM_THEME ) );
				$template['sub_fields'][] = scm_acf_field( 'id', array( 'text-read', '', '0', __( 'ID', SCM_THEME ) ), __( 'ID', SCM_THEME ), 40 );
			
			$fields[] = $template;

			return $fields;
		}
	}

	// PAGES
	if ( ! function_exists( 'scm_acf_fields_page' ) ) {
		function scm_acf_fields_page() {

			$default = 0; // todo: da rimuovere ovunque

			$fields = array();

			$fields = apply_filters( 'scm_filter_fields_page_before', $fields );

			$fields[] = scm_acf_field_select_layout( 'page-layout', 1, __( 'Layout', SCM_THEME ), 34, 0, 'default' );

			$fields = array_merge( $fields, scm_acf_preset_selectors( 'page-selectors', $default, 33, 33 ) );

			$fields[] = scm_acf_field_select1( 'page-menu', $default, 'wp_menu', 100, 0, '', __( 'Menu Principale', SCM_THEME ) );
			
			$fields = array_merge( $fields, scm_acf_preset_flexible_sections() );

			$fields = apply_filters( 'scm_filter_fields_page', $fields );

			return $fields;
		}
	}

	// BANNERS
	if ( ! function_exists( 'scm_acf_fields_banners' ) ) {
		function scm_acf_fields_banners() {

			$default = 0; // todo: da rimuovere ovunque

			$fields = array();

			$fields = apply_filters( 'scm_filter_fields_banner_before', $fields );
			
			$flexible = scm_acf_field_flexible( 'modules', 0, __( 'Aggiungi Contesto', SCM_THEME ), __( 'Contesto', SCM_THEME ), 100, 0, 1 );
                $flexible['layouts'][] = scm_acf_layout( 'titolo', 'block', __( 'Titolo', SCM_THEME ), '', '', scm_acf_object_titolo( 0, 0, 2 ) );
                $flexible['layouts'][] = scm_acf_layout( 'quote', 'block', __( 'Quote', SCM_THEME ), '', '', scm_acf_object_quote( 0, 0, 1) );
                $flexible['layouts'][] = scm_acf_layout( 'pulsanti', 'block', __( 'Pulsanti', SCM_THEME ), '', '', scm_acf_object_pulsanti( 0, 0, 1 ) );
                $flexible['layouts'][] = scm_acf_layout( 'elenco_puntato', 'block', __( 'Elenco Puntato', SCM_THEME ), '', '', scm_acf_object_elenco_puntato( 0, 0, 1 ) );
                $flexible['layouts'][] = scm_acf_layout( 'section', 'block', __( 'Banner', SCM_THEME ), '', '', scm_acf_object_section( 0, 0, 'sections-cat:banners' ) );

                //$flexible['sub_fields'][] = scm_acf_field_object_tax( 'banner-section', 0, 'sections', 'sections-cat:banners', '', $deafal_ban );
                //$flexible['sub_fields'] = array_merge( $flexible['sub_fields'], scm_acf_object_titolo( 0, 0, 1, '', $deafal_but ) );
                //$flexible['sub_fields'] = array_merge( $flexible['sub_fields'], scm_acf_object_pulsanti( 0, 0, 1, '', $deafal_but ) );

            $fields[] = $flexible;

            $fields = apply_filters( 'scm_filter_fields_banner', $fields );

			return $fields;
		}
	}
	
	// MODULES
	if ( ! function_exists( 'scm_acf_fields_modules' ) ) {
		function scm_acf_fields_modules() {

			$default = 0; // todo: da rimuovere ovunque

			$fields = array();

			$fields = apply_filters( 'scm_filter_fields_module_before', $fields );
			
			$flexible = scm_acf_field_flexible( 'modules', 0, __( 'Componi', SCM_THEME ), '+', '', 0, 0, 30 );
                $flexible['layouts'][] = scm_acf_layout( 'titolo', 'block', __( 'Titolo', SCM_THEME ), '', '', scm_acf_object_titolo( 0, 0, 2 ) );
                $flexible['layouts'][] = scm_acf_layout( 'testo', 'block', __( 'Testo', SCM_THEME ), '', '', scm_acf_object_testo( 0, 0, 1) ); // Se vedi che i testi inseriti fanno casino, togli sostituisci 1 con 0
                $flexible['layouts'][] = scm_acf_layout( 'elenco_puntato', 'block', __( 'Elenco Puntato', SCM_THEME ), '', '', scm_acf_object_elenco_puntato( 0, 0, 1 ) );
                $flexible['layouts'][] = scm_acf_layout( 'quote', 'block', __( 'Quote', SCM_THEME ), '', '', scm_acf_object_quote( 0, 0, 1) );
                $flexible['layouts'][] = scm_acf_layout( 'pulsanti', 'block', __( 'Pulsanti', SCM_THEME ), '', '', scm_acf_object_pulsanti( 0, 0, 1 ) );
                //$flexible['layouts'][] = scm_acf_layout( 'separatore', 'block', __( 'Separatore', SCM_THEME ), '', '', scm_acf_object_separatore( 0, 0, 1 ) );
				$flexible['layouts'] = apply_filters( 'scm_filter_layouts_module', $flexible['layouts'] );

			$fields[] = $flexible;

			$fields = apply_filters( 'scm_filter_fields_module', $fields );

			return $fields;
		}
	}


	// SECTIONS
	if ( ! function_exists( 'scm_acf_fields_sections' ) ) {
		function scm_acf_fields_sections( $elements = '' ) {

			$default = 0; // todo: da rimuovere ovunque

			$fields = array();

			$fields = apply_filters( 'scm_filter_fields_section_before', $fields );

			$fields[] = scm_acf_field_select_layout( 'layout', $default, __( 'Layout', SCM_THEME ), 20 );
			$fields = array_merge( $fields, scm_acf_preset_selectors( '', $default, 20, 20 ) );
			$fields[] = scm_acf_field( 'attributes', 'attributes', __( 'Attributi', SCM_THEME ), 40 );

			$fields = array_merge( $fields, scm_acf_preset_repeater_columns( '', $default, $elements ) );
			$fields = array_merge( $fields, scm_acf_preset_tags( 'section', $default, 'sections' ) );

			$fields = apply_filters( 'scm_filter_fields_section', $fields );

			return $fields;
		}
	}

	// SLIDES
	if ( ! function_exists( 'scm_acf_fields_slides' ) ) {
		function scm_acf_fields_slides() {

			$default = 0; // todo: da rimuovere ovunque

			$fields = array();

			$fields = apply_filters( 'scm_filter_fields_slide_before', $fields );

			$fields[] = scm_acf_field( 'tab-img-slide', 'tab-left', __( 'Immagine', SCM_THEME ) );

				$fields[] = scm_acf_field_image( 'slide-image', $default );

			$fields[] = scm_acf_field( 'tab-tax-slide', 'tab-left', __( 'Impostazioni', SCM_THEME ) );
				$fields = array_merge( $fields, scm_acf_preset_categories( 'slide', $default, 'slides' ) );
				$fields = array_merge( $fields, scm_acf_preset_tags( 'slide', $default, 'slides' ) );

			// conditional link
			$fields[] = scm_acf_field_select( 'slide-link', $default, 'links_type', 50, 0, '', __( 'Collegamento', SCM_THEME ) );

			$link = array(
				'field' => 'slide-link',
				'operator' => '==',
				'value' => 'link',
			);

			$page = array(
				'field' => 'slide-link',
				'operator' => '==',
				'value' => 'page',
			);

				$fields[] = scm_acf_field_link( 'slide-external', $default, 50, $link );
				$fields[] = scm_acf_field_object_link( 'slide-internal', $default, 'page', 50, $page );

			$fields[] = scm_acf_field( 'tab-slide-caption', 'tab', __( 'Didascalia', SCM_THEME ) );
			// conditional caption
			$fields[] = scm_acf_field_select_disable( 'slide-caption', $default, __( 'Didascalia', SCM_THEME ) );

			$caption = array(
				'field' => 'slide-caption',
				'operator' => '==',
				'value' => 'on',
			);

				$fields[] = scm_acf_field( 'slide-caption-top', array( 'percent', '', '0' ), __( 'Dal lato alto', SCM_THEME ), 25, $caption );
				$fields[] = scm_acf_field( 'slide-caption-right', array( 'percent', '', '0' ), __( 'Dal lato destro', SCM_THEME ), 25, $caption );
				$fields[] = scm_acf_field( 'slide-caption-bottom', array( 'percent', '', '0' ), __( 'Dal lato basso', SCM_THEME ), 25, $caption );
				$fields[] = scm_acf_field( 'slide-caption-left', array( 'percent', '', '0' ), __( 'Dal lato sinistro', SCM_THEME ), 25, $caption );

				$fields[] = scm_acf_field( 'slide-caption-title', array( 'text', '', __( 'Titolo didascalia', SCM_THEME ), __( 'Titolo', SCM_THEME ) ), __( 'Titolo didascalia', SCM_THEME ), 100, $caption );
				$fields[] = scm_acf_field( 'slide-caption-cont', 'editor-basic-media', __( 'Contenuto didascalia', SCM_THEME ), 100, $caption );

			$fields[] = scm_acf_field( 'tab-slide-advanced', 'tab', __( 'Avanzate', SCM_THEME ) );
			$fields = array_merge( $fields, scm_acf_preset_selectors( 'selectors', $default, 50, 50 ) );

			$fields = apply_filters( 'scm_filter_fields_slide', $fields );

			return $fields;

		}
	}

	// NEWS
	if ( ! function_exists( 'scm_acf_fields_news' ) ) {
		function scm_acf_fields_news() {

			$default = 0; // todo: da rimuovere ovunque

			$fields = array();

			$fields = apply_filters( 'scm_filter_fields_news_before', $fields );

			//$fields[] = scm_acf_field( 'tab-set-post', 'tab-left', __( 'Impostazioni', SCM_THEME ) );
				$fields[] = scm_acf_field_image( 'image', $default );
				$fields = array_merge( $fields, scm_acf_fields_modules() );
				//$fields[] = scm_acf_field_limiter( $name . 'post-excerpt', $default, 350, 1, 100, 0, __( 'Anteprima', SCM_THEME ) );
				//$fields[] = scm_acf_field_editor( $name . 'post-content', $default );

			/*$fields[] = scm_acf_field( 'tab-tax-post', 'tab-left', __( 'Categorie', SCM_THEME ) );
				$fields = array_merge( $fields, scm_acf_preset_categories( $name . 'post', $default, 'post' ) );
				$fields = array_merge( $fields, scm_acf_preset_tags( $name . 'post', $default, 'post' ) );*/
				//$fields[] = scm_acf_field_category( $name . 'post-cat', $default, 'post' );

			$fields = apply_filters( 'scm_filter_fields_news', $fields );

			return $fields;

		}
	}

	// ARTICOLI
	if ( ! function_exists( 'scm_acf_fields_articoli' ) ) {
		function scm_acf_fields_articoli() {

			$default = 0; // todo: da rimuovere ovunque

			$fields = array();

			$fields = apply_filters( 'scm_filter_fields_articolo_before', $fields );

			$fields[] = scm_acf_field( 'tab-set-articolo', 'tab-left', __( 'Impostazioni', SCM_THEME ) );
				$fields[] = scm_acf_field_image( 'image', $default );
				$fields[] = scm_acf_field_textarea( 'excerpt', $default, 5, 100, 0, '', __( 'Anteprima', SCM_THEME ) );
				$fields[] = scm_acf_field_editor_basic( 'editor', $default );

			$fields[] = scm_acf_field( 'tab-tax-articolo', 'tab-left', __( 'Categorie', SCM_THEME ) );
				$fields = array_merge( $fields, scm_acf_preset_categories( 'articolo', $default, 'articoli' ) );
				$fields = array_merge( $fields, scm_acf_preset_tags( 'articolo', $default, 'articoli' ) );
				//$fields[] = scm_acf_field_category( $name . 'post-cat', $default, 'post' );

			$fields = apply_filters( 'scm_filter_fields_articolo', $fields );

			return $fields;

		}
	}

	// RASSEGNE STAMPA
	if ( ! function_exists( 'scm_acf_fields_rassegne_stampa' ) ) {
		function scm_acf_fields_rassegne_stampa() {

			$default = 0; // todo: da rimuovere ovunque

			$fields = array();

			$fields = apply_filters( 'scm_filter_fields_rassegna_before', $fields );

			$fields[] = scm_acf_field( 'tab-set-rassegna', 'tab-left', __( 'Impostazioni', SCM_THEME ) );
				// conditional link
				$fields[] = scm_acf_field_select( 'rassegna-type', $default, 'rassegne_type', 100, 0, '', __( 'Articolo', SCM_THEME ) );

				$link = array(
					'field' => 'rassegna-type',
					'operator' => '==',
					'value' => 'link',
				);

				$file = array(
					'field' => 'rassegna-type',
					'operator' => '==',
					'value' => 'file',
				);

					$fields[] = scm_acf_field_file( 'rassegna-file', $default, 100, $file );
					$fields[] = scm_acf_field_link( 'rassegna-link', $default, 100, $link );

				
				$fields[] = scm_acf_field( 'rassegna-data', 'date', __( 'Data', SCM_THEME ) );

			$fields[] = scm_acf_field( 'tab-tax-rassegna', 'tab-left', __( 'Categorie', SCM_THEME ) );
				$fields = array_merge( $fields, scm_acf_preset_categories( 'rassegna', $default, 'rassegne-stampa' ) );
				$fields = array_merge( $fields, scm_acf_preset_tags( 'rassegna', $default, 'rassegne-stampa' ) );

			$fields = apply_filters( 'scm_filter_fields_rassegna', $fields );
			
			return $fields;

		}
	}

	// DOCUMENTI
	if ( ! function_exists( 'scm_acf_fields_documenti' ) ) {
		function scm_acf_fields_documenti() {

			$default = 0; // todo: da rimuovere ovunque

			$fields = array();

			$fields = apply_filters( 'scm_filter_fields_documento_before', $fields );

			$fields[] = scm_acf_field( 'tab-set-documento', 'tab-left', __( 'Impostazioni', SCM_THEME ) );
				$fields[] = scm_acf_field_file( 'documento-file', $default );

			$fields[] = scm_acf_field( 'tab-tax-documento', 'tab-left', __( 'Categorie', SCM_THEME ) );
				$fields = array_merge( $fields, scm_acf_preset_categories( 'documento', $default, 'documenti' ) );
				$fields = array_merge( $fields, scm_acf_preset_tags( 'documento', $default, 'documenti' ) );
			//$fields[] = scm_acf_field_category( 'documento-cat', $default, 'documenti' );

			$fields = apply_filters( 'scm_filter_fields_documento', $fields );

			return $fields;

		}
	}
	
	// GALLERIE
	if ( ! function_exists( 'scm_acf_fields_gallerie' ) ) {
		function scm_acf_fields_gallerie() {

			$default = 0; // todo: da rimuovere ovunque

			$fields = array();

			$fields = apply_filters( 'scm_filter_fields_galleria_before', $fields );

			$fields[] = scm_acf_field( 'tab-set-galleria', 'tab-left', __( 'Impostazioni', SCM_THEME ) );
				$fields[] = scm_acf_field( 'galleria-images', 'gallery', __( 'Immagini', SCM_THEME ) );

			$fields[] = scm_acf_field( 'tab-tax-galleria', 'tab-left', __( 'Categorie', SCM_THEME ) );
				$fields = array_merge( $fields, scm_acf_preset_categories( 'galleria', $default, 'gallerie' ) );
				$fields = array_merge( $fields, scm_acf_preset_tags( 'galleria', $default, 'gallerie' ) );
			//$fields[] = scm_acf_field_category( 'galleria-cat', $default, 'gallerie' );

			$fields = apply_filters( 'scm_filter_fields_galleria', $fields );

			return $fields;

		}
	}
	
	// VIDEO
	if ( ! function_exists( 'scm_acf_fields_video' ) ) {
		function scm_acf_fields_video() {

			$default = 0; // todo: da rimuovere ovunque

			$fields = array();

			$fields = apply_filters( 'scm_filter_fields_video_before', $fields );

			$fields[] = scm_acf_field( 'tab-set-video', 'tab-left', __( 'Impostazioni', SCM_THEME ) );
				$fields[] = scm_acf_field( 'video-url', 'video', __( 'Link a YouTube', SCM_THEME ) );

			$fields[] = scm_acf_field( 'tab-tax-video', 'tab-left', __( 'Categorie', SCM_THEME ) );
				$fields = array_merge( $fields, scm_acf_preset_categories( 'video', $default, 'video' ) );
				$fields = array_merge( $fields, scm_acf_preset_tags( 'video', $default, 'video' ) );
			//$fields[] = scm_acf_field_category( 'video-cat', $default, 'video' );

			$fields = apply_filters( 'scm_filter_fields_video', $fields );

			return $fields;

		}
	}

	// LUOGHI
	if ( ! function_exists( 'scm_acf_fields_luoghi' ) ) {
		function scm_acf_fields_luoghi() {

			$default = 0; // todo: da rimuovere ovunque

			$fields = array();

			$fields = apply_filters( 'scm_filter_fields_luogo_before', $fields );

			$fields[] = scm_acf_field( 'tab-set-luogo', 'tab-left', __( 'Dati', SCM_THEME ) );
				
				/*$fields[] = scm_acf_field( 'msg-luogo-nome', array(
					'message',
					__( 'Il campo Nome è utile per differenziare più luoghi che fanno riferimento ad un unico Soggetto ( es. Sede Operativa, Distaccamento, ...).', SCM_THEME )
				), __( 'Specifica un Nome', SCM_THEME ) );*/

					$fields[] = scm_acf_field_name( 'luogo-nome', $default, '', 100, 0, __( 'es. Sede Operativa, Distaccamento, …', SCM_THEME ) );

					$fields[] = scm_acf_field_text( 'luogo-indirizzo', $default, 70, 0, 'Corso Giulio Cesare 1', '', __( 'Indirizzo', SCM_THEME ) );
					$fields[] = scm_acf_field_text( 'luogo-provincia', $default, 30, 0, 'RM', '', __( 'Provincia', SCM_THEME ) );
					
					$fields[] = scm_acf_field_text( 'luogo-citta', $default, 70, 0, 'Roma', '', __( 'Città/Località', SCM_THEME ) );
					$fields[] = scm_acf_field_text( 'luogo-cap', $default, 30, 0, '12345', '', __( 'CAP', SCM_THEME ) );
					
					$fields[] = scm_acf_field_text( 'luogo-frazione', $default, 70, 0, 'S. Pietro', '', __( 'Frazione', SCM_THEME ) );
					$fields[] = scm_acf_field_text( 'luogo-regione', $default, 30, 0, 'Lazio', '', __( 'Regione', SCM_THEME ) );
					
					$fields[] = scm_acf_field_text( 'luogo-paese', $default, 70, 0, 'Italy', '', __( 'Paese', SCM_THEME ) );
					$fields = array_merge( $fields, scm_acf_preset_map_icon( 'luogo-mappa', 1, 30, 0, '' ) );


			$fields[] = scm_acf_field( 'tab-contatti-luogo', 'tab-left', __( 'Contatti', SCM_THEME ) );

				$contacts = scm_acf_field_flexible( 'luogo-contatti', $default, __( 'Aggiungi Contatti', SCM_THEME ), '+' );

					$web = scm_acf_layout( 'web', 'block', __( 'Web', SCM_THEME ) );
						$web['sub_fields'] = scm_acf_preset_button( '', $default, 'link', 'globe_contact', 'web', 2, __( 'Web', SCM_THEME ), __( 'URL', SCM_THEME ) );
					$contacts['layouts'][] = $web;

					$email = scm_acf_layout( 'email', 'block', __( 'Email', SCM_THEME ) );
						$email['sub_fields'] = scm_acf_preset_button( '', $default, 'link', 'envelope_contact', 'email', 2, __( 'Email', SCM_THEME ), __( 'Address', SCM_THEME ) );
					$contacts['layouts'][] = $email;

					$skype = scm_acf_layout( 'skype', 'block', __( 'Skype', SCM_THEME ) );
						$skype['sub_fields'] = scm_acf_preset_button( '', $default, 'link', 'skype_contact', 'skype', 2, __( 'Skype Name', SCM_THEME ), __( 'User', SCM_THEME ) );
					$contacts['layouts'][] = $skype;

					$phone = scm_acf_layout( 'phone', 'block', __( 'Telefono', SCM_THEME ) );
						$phone['sub_fields'] = scm_acf_preset_button( '', $default, 'link', 'phone_contact', 'phone', 2, __( 'Tel.', SCM_THEME ), __( 'Number', SCM_THEME ) );
					$contacts['layouts'][] = $phone;

					$fax = scm_acf_layout( 'fax', 'block', __( 'Fax', SCM_THEME ) );
						$fax['sub_fields'] = scm_acf_preset_button( '', $default, 'link', 'file-text_contact', 'fax', 2, __( 'Fax', SCM_THEME ), __( 'Number', SCM_THEME ) );
					$contacts['layouts'][] = $fax;

					$more = scm_acf_layout( 'more', 'block', __( 'More', SCM_THEME ) );
						$more['sub_fields'] = scm_acf_preset_button( '', $default, 'link', '', '', 2, __( 'More', SCM_THEME ), __( 'Link', SCM_THEME ) );
					$contacts['layouts'][] = $more;

				$fields[] = $contacts;

			$fields[] = scm_acf_field( 'tab-tax-luogo', 'tab-left', __( 'Categorie', SCM_THEME ) );
				$fields = array_merge( $fields, scm_acf_preset_category( 'luogo', $default, 'luoghi' ) );
				$fields = array_merge( $fields, scm_acf_preset_tags( 'luogo', $default, 'luoghi' ) );

			$fields = apply_filters( 'scm_filter_fields_luogo', $fields );

			return $fields;

		}
	}

	// SOGGETTI
	if ( ! function_exists( 'scm_acf_fields_soggetti' ) ) {
		function scm_acf_fields_soggetti() {

			$default = 0; // todo: da rimuovere ovunque

			$fields = array();

			$fields = apply_filters( 'scm_filter_fields_soggetto_before', $fields );

			$fields[] = scm_acf_field( 'tab-soggetto-brand', 'tab-left', __( 'Brand', SCM_THEME ) );
				$fields[] = scm_acf_field( 'msg-soggetto-pos', array(
					'message',
					__( 'Carica uno logo e/o un\'icona da utilizzare su fondi chiari.', SCM_THEME ),
				), 'Versione in Positivo', 100 );

				$fields[] = scm_acf_field_image( 'soggetto-logo', $default, 50, 0, __( 'Logo', SCM_THEME ) );
				$fields[] = scm_acf_field_image( 'soggetto-icona', $default, 50, 0, __( 'Icona', SCM_THEME ) );
				
				$fields[] = scm_acf_field( 'msg-soggetto-neg', array(
					'message',
					__( 'Carica uno logo e/o un\'icona da utilizzare su fondi scuri.', SCM_THEME ),
				), __( 'Versione in Negativo', SCM_THEME ), 100 );
				
				$fields[] = scm_acf_field_image( 'soggetto-logo-neg', $default, 50, 0, __( 'Logo', SCM_THEME ) );
				$fields[] = scm_acf_field_image( 'soggetto-icona-neg', $default, 50, 0, __( 'Icona', SCM_THEME ) );

			$fields[] = scm_acf_field( 'tab-soggetto-dati', 'tab-left', 'Dati' );
				$fields[] = scm_acf_field_link( 'soggetto-link', $default, 100 );
				$fields[] = scm_acf_field_text( 'soggetto-intestazione', $default, 100, 0, 'intestazione', '', __( 'Intestazione', SCM_THEME ) );
				$fields[] = scm_acf_field_text( 'soggetto-piva', $default, 50, 0, '0123456789101112', '', __( 'P.IVA', SCM_THEME ) );
				$fields[] = scm_acf_field_text( 'soggetto-cf', $default, 50, 0, 'AAABBB123', '', __( 'C.F.', SCM_THEME ) );

			$fields[] = scm_acf_field( 'tab-soggetto-luogo', 'tab-left', __( 'Luoghi', SCM_THEME ) );
				$fields[] = scm_acf_field( 'msg-soggetto-luoghi', array(
					'message',
					__( 'Assegna dei Luoghi a questo Soggetto. Clicca sul pulsante Luoghi nella barra laterale per crearne uno. Il primo Luogo dell\'elenco sarà considerato Luogo Principale per questo Soggetto.', SCM_THEME ),
				), __( 'Luoghi', SCM_THEME ) );

				$fields[] = scm_acf_field_objects_rel( 'soggetto-luoghi', $default, 'luoghi', 100, 0, __( 'Seleziona Luoghi', SCM_THEME ) );

			$fields[] = scm_acf_field( 'tab-social-soggetto', 'tab-left', __( 'Social', SCM_THEME ) );
				$fields = array_merge( $fields, scm_acf_preset_flexible_buttons( 'soggetto', $default, 'social', __( 'Social', SCM_THEME ) ) );

			$fields[] = scm_acf_field( 'tab-tax-soggetto', 'tab-left', __( 'Categorie', SCM_THEME ) );
				$fields = array_merge( $fields, scm_acf_preset_category( 'soggetto', $default, 'soggetti' ) );
				$fields = array_merge( $fields, scm_acf_preset_tags( 'soggetto', $default, 'soggetti' ) );

			$fields = apply_filters( 'scm_filter_fields_soggetto', $fields );

			return $fields;

		}
	}
	
?>