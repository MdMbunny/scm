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

			$template = scm_acf_field_repeater( $name . '-templates', array( 
				'button'=>__( 'Aggiungi Modello', SCM_THEME ),
				'label'=>__( 'Modelli', SCM_THEME ), 
				'instructions'=>$instructions,
				'class'=>$class,
			), 100, $logic, $required );

				$template['sub_fields'][] = scm_acf_field_name( 'name', array( 'placeholder'=>__( 'Nome Modello', SCM_THEME ) ), 60 );
				$template['sub_fields'][] = scm_acf_field( 'id', array( 'text-read', '', '0', __( 'ID', SCM_THEME ) ), '', 40 );
			
			$fields[] = $template;

			return $fields;
		}
	}

	// PAGES
	if ( ! function_exists( 'scm_acf_fields_page' ) ) {
		function scm_acf_fields_page( $name = '' ) {

			$name = ( $name ? $name . '-' : '');

			$fields = array();

			$fields = apply_filters( 'scm_filter_fields_page_before', $fields );

			$fields[] = scm_acf_field_select( $name . 'page-layout', 'main_layout-default', 34 );

			$fields = array_merge( $fields, scm_acf_preset_selectors( $name . 'page', 33, 33 ) );

			$fields[] = scm_acf_field_select( $name . 'page-menu', 'wp_menu', 100, 0, 0, __( 'Menu Principale', SCM_THEME ) );
			
			$fields = array_merge( $fields, scm_acf_preset_flexible_sections( $name ) );

			$fields = apply_filters( 'scm_filter_fields_page', $fields );

			return $fields;
		}
	}

	// BANNERS
	if ( ! function_exists( 'scm_acf_fields_banners' ) ) {
		function scm_acf_fields_banners( $name = '' ) {

			$name = ( $name ? $name . '-' : '');

			$fields = array();

			$fields = apply_filters( 'scm_filter_fields_banner_before', $fields );
			
			$flexible = scm_acf_field_flexible( $name . 'modules', array( 
				'label'=>__( 'Aggiungi Contesto', SCM_THEME ),
				'button'=>__( 'Contesto', SCM_THEME ),
				'min'=>1,
			) );
                $flexible['layouts'][] = scm_acf_layout( 'titolo', 'block', __( 'Titolo', SCM_THEME ), '', '', scm_acf_object_titolo( 0, 0, 2 ) );
                $flexible['layouts'][] = scm_acf_layout( 'quote', 'block', __( 'Quote', SCM_THEME ), '', '', scm_acf_object_quote( 0, 0, 1) );
                $flexible['layouts'][] = scm_acf_layout( 'pulsanti', 'block', __( 'Pulsanti', SCM_THEME ), '', '', scm_acf_object_pulsanti( 0, 0, 1 ) );
                $flexible['layouts'][] = scm_acf_layout( 'elenco_puntato', 'block', __( 'Elenco Puntato', SCM_THEME ), '', '', scm_acf_object_elenco_puntato( 0, 0, 1 ) );
                $flexible['layouts'][] = scm_acf_layout( 'section', 'block', __( 'Banner', SCM_THEME ), '', '', scm_acf_object_section( 0, 0, 'sections-cat:banners' ) );

            $fields[] = $flexible;

            $fields = apply_filters( 'scm_filter_fields_banner', $fields );

			return $fields;
		}
	}
	
	// MODULES
	if ( ! function_exists( 'scm_acf_fields_modules' ) ) {
		function scm_acf_fields_modules( $name = '' ) {

			$name = ( $name ? $name . '-' : '');

			$fields = array();

			$fields = apply_filters( 'scm_filter_fields_module_before', $fields );
			
			$flexible = scm_acf_field_flexible( $name . 'modules', array( 
				'label'=>__( 'Componi', SCM_THEME ),
				'button'=>__( '+', SCM_THEME ),
				'max'=>30,
			) );
                $flexible['layouts'][] = scm_acf_layout( 'titolo', 'block', __( 'Titolo', SCM_THEME ), '', '', scm_acf_object_titolo( 0, 0, 2 ) );
                $flexible['layouts'][] = scm_acf_layout( 'testo', 'block', __( 'Testo', SCM_THEME ), '', '', scm_acf_object_testo( '', 0, 1) ); // Se vedi che i testi inseriti fanno casino, sostituisci 1 con 0
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
		function scm_acf_fields_sections( $name = '', $elements = '' ) {

			$name = ( $name ? $name . '-' : '');

			$fields = array();

			$fields = apply_filters( 'scm_filter_fields_section_before', $fields );

			$fields[] = scm_acf_field_select( $name . 'layout', 'main_layout', 20 );
			$fields = array_merge( $fields, scm_acf_preset_selectors( $name, 20, 20 ) );
			$fields[] = scm_acf_field( $name . 'attributes', 'attributes', '', 40 );

			$fields = array_merge( $fields, scm_acf_preset_repeater_columns( $name, $elements ) );
			$fields = array_merge( $fields, scm_acf_preset_tags( $name . 'section', 0, 'sections' ) );

			$fields = apply_filters( 'scm_filter_fields_section', $fields );

			return $fields;
		}
	}

	// SLIDERS
	if ( ! function_exists( 'scm_acf_fields_sliders' ) ) {
		function scm_acf_fields_sliders( $name = '' ) {

			$name = ( $name ? $name . '-' : '');

			$fields = array();

			$fields = array_merge( $fields, scm_acf_preset_size( $name . 'height', '', 'auto', 'px', __( 'Altezza', SCM_THEME ), 100 ) );
			$fields[] = scm_acf_field_select( $name . 'theme', 'themes_nivo', 100, 0, 0, __( 'Tema', SCM_THEME ) );
			$fields[] = scm_acf_field_select( $name . 'alignment', 'vertical_alignment' );
			
				$fields[] = scm_acf_field_select( $name . 'effect', 'effect_nivo', 100, 0, 0, __( 'Effetto Slider', SCM_THEME ) );
				$fields[] = scm_acf_field_number( $name . 'slices', array( 'default'=>30, 'prepend'=>__( 'Slices', SCM_THEME ), 'min'=>1, 'max'=>30 ) );
				$fields[] = scm_acf_field_number( $name . 'cols', array( 'default'=>8, 'prepend'=>__( 'Colonne', SCM_THEME ), 'min'=>1, 'max'=>8 ) );
				$fields[] = scm_acf_field_number( $name . 'rows', array( 'default'=>8, 'prepend'=>__( 'Righe', SCM_THEME ), 'min'=>1, 'max'=>100 ) );
				$fields[] = scm_acf_field_number( $name . 'speed', array( 'default'=>1, 'prepend'=>__( 'Velocità', SCM_THEME ) ) );
				$fields[] = scm_acf_field_number( $name . 'pause', array( 'default'=>5, 'prepend'=>__( 'Pausa', SCM_THEME ) ) );

				$fields[] = scm_acf_field_option( $name . 'start', array( 'default'=>0, 'prepend'=>__( 'Start', SCM_THEME ) ) );
				$fields[] = scm_acf_field_false( $name . 'hover', 0, 100, 0, 0, __( 'Pause on Hover', SCM_THEME ) );
				$fields[] = scm_acf_field_false( $name . 'manual', 0, 100, 0, 0, __( 'Avanzamento Manuale', SCM_THEME ) );
				$fields[] = scm_acf_field_false( $name . 'direction', 0, 100, 0, 0, __( 'Direction Nav', SCM_THEME ) );
				$fields[] = scm_acf_field_false( $name . 'control', 0, 100, 0, 0, __( 'Control Nav', SCM_THEME ) );
				$fields[] = scm_acf_field_false( $name . 'thumbs', 0, 100, 0, 0, __( 'Thumbs Nav', SCM_THEME ) );
				$fields[] = scm_acf_field_icon( $name . 'prev', array('placeholder'=>'angle-left','label'=>__( 'Prev Icon', SCM_THEME )) );
				$fields[] = scm_acf_field_icon( $name . 'next', array('placeholder'=>'angle-right','label'=>__( 'Next Icon', SCM_THEME )) );

			return $fields;
			
		}
	}

	// SLIDES
	if ( ! function_exists( 'scm_acf_fields_slides' ) ) {
		function scm_acf_fields_slides( $name = '' ) {

			$name = ( $name ? $name . '-' : '');

			$fields = array();
			$hastaxes = checkTaxes( 'slides' );

			$fields = apply_filters( 'scm_filter_fields_slide_before', $fields );

			$fields[] = scm_acf_field_tab_left( $name . 'tab-img-slide', array('label'=>__( 'Immagine', SCM_THEME ) ) );

				$fields[] = scm_acf_field_image_url( $name . 'slide-image' );

			if( $hastaxes ){
				$fields[] = scm_acf_field_tab_left( $name . 'tab-tax-slide', array('label'=>__( 'Impostazioni', SCM_THEME ) ) );
					$fields = array_merge( $fields, scm_acf_preset_categories( $name . 'slide', 'slides' ) );
					$fields = array_merge( $fields, scm_acf_preset_tags( $name . 'slide', 'slides' ) );
			}

			// conditional link
			$fields[] = scm_acf_field_select( $name . 'slide-link', 'links_type', 50, 0, 0, __( 'Collegamento', SCM_THEME ) );

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

				$fields[] = scm_acf_field_link( $name . 'slide-external', 0, 50, $link );
				$fields[] = scm_acf_field_object( $name . 'slide-internal', array( 
                    'type'=>'link', 
                    'types'=>'page',
                ), 50, $page );

			$fields[] = scm_acf_field_tab( $name . 'tab-slide-caption', array('label'=>__( 'Didascalia', SCM_THEME ) ) );
			// conditional caption
			//$fields[] = scm_acf_field_select_disable( 'slide-caption', 0, __( 'Didascalia', SCM_THEME ) );
			$fields[] = scm_acf_field_false( $name . 'slide-caption', 0, 100, 0, 0, __( 'Attiva Didascalia', SCM_THEME ) );

			$caption = array(
				'field' => 'slide-caption',
				'operator' => '==',
				'value' => 1,
			);

				$fields[] = scm_acf_field( $name . 'slide-caption-top', array( 'percent', '', '0' ), __( 'Dal lato alto', SCM_THEME ), 25, $caption );
				$fields[] = scm_acf_field( $name . 'slide-caption-right', array( 'percent', '', '0' ), __( 'Dal lato destro', SCM_THEME ), 25, $caption );
				$fields[] = scm_acf_field( $name . 'slide-caption-bottom', array( 'percent', '', '0' ), __( 'Dal lato basso', SCM_THEME ), 25, $caption );
				$fields[] = scm_acf_field( $name . 'slide-caption-left', array( 'percent', '', '0' ), __( 'Dal lato sinistro', SCM_THEME ), 25, $caption );

				$fields[] = scm_acf_field( $name . 'slide-caption-title', array( 'text', '', __( 'Titolo didascalia', SCM_THEME ), __( 'Titolo', SCM_THEME ) ), __( 'Titolo didascalia', SCM_THEME ), 100, $caption );
				$fields[] = scm_acf_field( $name . 'slide-caption-cont', 'editor-basic-media', __( 'Contenuto didascalia', SCM_THEME ), 100, $caption );

			$fields[] = scm_acf_field_tab( $name . 'tab-slide-advanced', array('label'=>__( 'Avanzate', SCM_THEME ) ) );
			$fields = array_merge( $fields, scm_acf_preset_selectors( $name, 50, 50 ) );

			$fields = apply_filters( 'scm_filter_fields_slide', $fields );

			return $fields;

		}
	}

	// NEWS
	if ( ! function_exists( 'scm_acf_fields_news' ) ) {
		function scm_acf_fields_news( $name = '' ) {

			$name = ( $name ? $name . '-' : '');

			$fields = array();

			$fields = apply_filters( 'scm_filter_fields_news_before', $fields );

			$fields[] = scm_acf_field_image_url( $name . 'image' );
			$fields = array_merge( $fields, scm_acf_fields_modules( $name ) );

			$fields = apply_filters( 'scm_filter_fields_news', $fields );

			return $fields;

		}
	}

	// ARTICOLI
	if ( ! function_exists( 'scm_acf_fields_articoli' ) ) {
		function scm_acf_fields_articoli( $name = '' ) {

			$name = ( $name ? $name . '-' : '');

			$fields = array();
			$hastaxes = checkTaxes( 'articoli' );

			$fields = apply_filters( 'scm_filter_fields_articolo_before', $fields );

			if( $hastaxes )
				$fields[] = scm_acf_field_tab_left( $name . 'tab-set-articolo', array('label'=>__( 'Impostazioni', SCM_THEME ) ) );
				
				$fields[] = scm_acf_field_image_url( $name . 'image' );
				$fields[] = scm_acf_field_textarea( $name . 'excerpt', array( 'rows'=>5, 'label'=>__( 'Anteprima', SCM_THEME ) ) );
				$fields[] = scm_acf_field_editor_basic( $name . 'editor' );

			if( $hastaxes ){
				$fields[] = scm_acf_field_tab_left( $name . 'tab-tax-articolo', array('label'=>__( 'Categorie', SCM_THEME ) ) );
					$fields = array_merge( $fields, scm_acf_preset_categories( $name . 'articolo', 'articoli' ) );
					$fields = array_merge( $fields, scm_acf_preset_tags( $name . 'articolo', 'articoli' ) );
			}

			$fields = apply_filters( 'scm_filter_fields_articolo', $fields );

			return $fields;

		}
	}

	// RASSEGNE STAMPA
	if ( ! function_exists( 'scm_acf_fields_rassegne_stampa' ) ) {
		function scm_acf_fields_rassegne_stampa( $name = '' ) {

			$name = ( $name ? $name . '-' : '');


			$fields = array();
			$hastaxes = checkTaxes( 'rassegne-stampa' );

			$fields = apply_filters( 'scm_filter_fields_rassegna_before', $fields );
			
			if( $hastaxes )
				$fields[] = scm_acf_field_tab_left( $name . 'tab-set-rassegna', array('label'=>__( 'Impostazioni', SCM_THEME ) ) );
				
				// conditional link
				$fields[] = scm_acf_field_select( $name . 'rassegna-type', 'rassegne_type', 100, 0, 0, __( 'Articolo', SCM_THEME ) );

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

					$fields[] = scm_acf_field_file_url( $name . 'rassegna-file', 0, 100, $file );
					$fields[] = scm_acf_field_link( $name . 'rassegna-link', 0, 100, $link );

				
				$fields[] = scm_acf_field( $name . 'rassegna-data', 'date', __( 'Data', SCM_THEME ) );

			if( $hastaxes ){
				$fields[] = scm_acf_field_tab_left( $name . 'tab-tax-rassegna', array('label'=>__( 'Categorie', SCM_THEME ) ) );
					$fields = array_merge( $fields, scm_acf_preset_categories( $name . 'rassegna', 'rassegne-stampa' ) );
					$fields = array_merge( $fields, scm_acf_preset_tags( $name . 'rassegna', 'rassegne-stampa' ) );
			}

			$fields = apply_filters( 'scm_filter_fields_rassegna', $fields );

			return $fields;

		}
	}

	// DOCUMENTI
	if ( ! function_exists( 'scm_acf_fields_documenti' ) ) {
		function scm_acf_fields_documenti( $name = '' ) {

			$name = ( $name ? $name . '-' : '');


			$fields = array();
			$hastaxes = checkTaxes( 'documenti' );

			$fields = apply_filters( 'scm_filter_fields_documento_before', $fields );
			
			if( $hastaxes )
				$fields[] = scm_acf_field_tab_left( $name . 'tab-set-documento', array('label'=>__( 'Impostazioni', SCM_THEME ) ) );
				
				$fields[] = scm_acf_field_file_url( $name . 'documento-file' );

			if( $hastaxes ){
				$fields[] = scm_acf_field_tab_left( $name . 'tab-tax-documento', array('label'=>__( 'Categorie', SCM_THEME ) ) );
					$fields = array_merge( $fields, scm_acf_preset_categories( $name . 'documento', 'documenti' ) );
					$fields = array_merge( $fields, scm_acf_preset_tags( $name . 'documento', 'documenti' ) );
			}

			$fields = apply_filters( 'scm_filter_fields_documento', $fields );

			return $fields;

		}
	}
	
	// GALLERIE
	if ( ! function_exists( 'scm_acf_fields_gallerie' ) ) {
		function scm_acf_fields_gallerie( $name = '' ) {

			$name = ( $name ? $name . '-' : '');


			$fields = array();
			$hastaxes = checkTaxes( 'gallerie' );

			$fields = apply_filters( 'scm_filter_fields_galleria_before', $fields );

			if( $hastaxes )
				$fields[] = scm_acf_field_tab_left( $name . 'tab-set-galleria', array('label'=>__( 'Impostazioni', SCM_THEME ) ) );
				
				$fields[] = scm_acf_field( $name . 'galleria-images', 'gallery', __( 'Immagini', SCM_THEME ) );
			
			if( $hastaxes ){
				$fields[] = scm_acf_field_tab_left( $name . 'tab-tax-galleria', array('label'=>__( 'Categorie', SCM_THEME ) ) );
					$fields = array_merge( $fields, scm_acf_preset_categories( $name . 'galleria', 'gallerie' ) );
					$fields = array_merge( $fields, scm_acf_preset_tags( $name . 'galleria', 'gallerie' ) );
			}

			$fields = apply_filters( 'scm_filter_fields_galleria', $fields );

			return $fields;

		}
	}
	
	// VIDEO
	if ( ! function_exists( 'scm_acf_fields_video' ) ) {
		function scm_acf_fields_video( $name = '' ) {

			$name = ( $name ? $name . '-' : '');


			$fields = array();
			$hastaxes = checkTaxes( 'video' );

			$fields = apply_filters( 'scm_filter_fields_video_before', $fields );

			if( $hastaxes )
				$fields[] = scm_acf_field_tab_left( $name . 'tab-set-video', array('label'=>__( 'Impostazioni', SCM_THEME ) ) );
				
				$fields[] = scm_acf_field( $name . 'video-url', 'video', __( 'Link a YouTube', SCM_THEME ) );

			if( $hastaxes ){
				$fields[] = scm_acf_field_tab_left( $name . 'tab-tax-video', array('label'=>__( 'Categorie', SCM_THEME ) ) );
					$fields = array_merge( $fields, scm_acf_preset_categories( $name . 'video', 'video' ) );
					$fields = array_merge( $fields, scm_acf_preset_tags( $name . 'video', 'video' ) );
			}

			$fields = apply_filters( 'scm_filter_fields_video', $fields );

			return $fields;

		}
	}

	// LUOGHI
	if ( ! function_exists( 'scm_acf_fields_luoghi' ) ) {
		function scm_acf_fields_luoghi( $name = '' ) {

			$name = ( $name ? $name . '-' : '');


			$fields = array();
			$hastaxes = checkTaxes( 'luoghi' );

			$fields = apply_filters( 'scm_filter_fields_luogo_before', $fields );

			$fields[] = scm_acf_field_tab_left( $name . 'tab-set-luogo', array('label'=>__( 'Dati', SCM_THEME ) ) );
				
				/*$fields[] = scm_acf_field( 'msg-luogo-nome', array(
					'message',
					__( 'Il campo Nome è utile per differenziare più luoghi che fanno riferimento ad un unico Soggetto ( es. Sede Operativa, Distaccamento, ...).', SCM_THEME )
				), __( 'Specifica un Nome', SCM_THEME ) );*/

					$fields[] = scm_acf_field_name( $name . 'luogo-nome', array( 'placeholder'=>__( 'es. Sede Operativa, Distaccamento, …', SCM_THEME ) ) );

					$fields[] = scm_acf_field_text( $name . 'luogo-indirizzo', array( 'placeholder'=>'Corso Giulio Cesare 1', 'prepend'=>__( 'Indirizzo', SCM_THEME ) ), 70 );
					$fields[] = scm_acf_field_text( $name . 'luogo-provincia', array( 'placeholder'=>'RM', 'prepend'=>__( 'Provincia', SCM_THEME ) ), 30 );
					
					$fields[] = scm_acf_field_text( $name . 'luogo-citta', array( 'placeholder'=>'Roma', 'prepend'=>__( 'Città/Località', SCM_THEME ) ), 70 );
					$fields[] = scm_acf_field_text( $name . 'luogo-cap', array( 'placeholder'=>'12345', 'prepend'=>__( 'CAP', SCM_THEME ) ), 30 );
					
					$fields[] = scm_acf_field_text( $name . 'luogo-frazione', array( 'placeholder'=>'S. Pietro', 'prepend'=>__( 'Frazione', SCM_THEME ) ), 70 );
					$fields[] = scm_acf_field_text( $name . 'luogo-regione', array( 'placeholder'=>'Lazio', 'prepend'=>__( 'Regione', SCM_THEME ) ), 30 );
					
					$fields[] = scm_acf_field_text( $name . 'luogo-paese', array( 'placeholder'=>'Italy', 'prepend'=>__( 'Paese', SCM_THEME ) ), 70 );
					$fields = array_merge( $fields, scm_acf_preset_map_icon( $name . 'luogo', 30 ) );


			$fields[] = scm_acf_field_tab_left( $name . 'tab-contatti-luogo', array('label'=>__( 'Contatti', SCM_THEME ) ) );

				$contacts = scm_acf_field_flexible( $name . 'luogo-contatti', array( 
					'label'=>__( 'Aggiungi Contatti', SCM_THEME ),
					'button'=>'+',
				) );

					$web = scm_acf_layout( 'web', 'block', __( 'Web', SCM_THEME ) );
						$web['sub_fields'] = scm_acf_preset_button( '', 'link', 'globe_contact', 'web', 2, __( 'Web', SCM_THEME ) );
					$contacts['layouts'][] = $web;

					$email = scm_acf_layout( 'email', 'block', __( 'Email', SCM_THEME ) );
						$email['sub_fields'] = scm_acf_preset_button( '', 'email', 'envelope_contact', 'email', 2, __( 'Email', SCM_THEME ) );
					$contacts['layouts'][] = $email;

					$skype = scm_acf_layout( 'skype', 'block', __( 'Skype', SCM_THEME ) );
						$skype['sub_fields'] = scm_acf_preset_button( '', 'user', 'skype_contact', 'skype', 2, __( 'Skype Name', SCM_THEME ) );
					$contacts['layouts'][] = $skype;

					$phone = scm_acf_layout( 'phone', 'block', __( 'Telefono', SCM_THEME ) );
						$phone['sub_fields'] = scm_acf_preset_button( '', 'phone', 'phone_contact', 'phone', 2, __( 'Tel.', SCM_THEME ) );
					$contacts['layouts'][] = $phone;

					$fax = scm_acf_layout( 'fax', 'block', __( 'Fax', SCM_THEME ) );
						$fax['sub_fields'] = scm_acf_preset_button( '', 'phone', 'file-text_contact', 'fax', 2, __( 'Fax', SCM_THEME ) );
					$contacts['layouts'][] = $fax;

					$more = scm_acf_layout( 'more', 'block', __( 'More', SCM_THEME ) );
						$more['sub_fields'] = scm_acf_preset_button( '', 'link', '', '', 2, __( 'More', SCM_THEME ) );
					$contacts['layouts'][] = $more;

				$fields[] = $contacts;

			if( $hastaxes ){
				$fields[] = scm_acf_field_tab_left( $name . 'tab-tax-luogo', array('label'=>__( 'Categorie', SCM_THEME ) ) );
					$fields = array_merge( $fields, scm_acf_preset_category( $name . 'luogo', 'luoghi' ) );
					$fields = array_merge( $fields, scm_acf_preset_tags( $name . 'luogo', 'luoghi' ) );
			}

			$fields = apply_filters( 'scm_filter_fields_luogo', $fields );

			return $fields;

		}
	}

	// SOGGETTI
	if ( ! function_exists( 'scm_acf_fields_soggetti' ) ) {
		function scm_acf_fields_soggetti( $name = '' ) {

			$name = ( $name ? $name . '-' : '');

			$fields = array();
			$hastaxes = checkTaxes( 'soggetti' );

			$fields = apply_filters( 'scm_filter_fields_soggetto_before', $fields );

			$fields[] = scm_acf_field_tab_left( $name . 'tab-soggetto-brand', array('label'=>__( 'Brand', SCM_THEME ) ) );
				$fields[] = scm_acf_field( $name . 'msg-soggetto-pos', array(
					'message',
					__( 'Carica uno logo e/o un\'icona da utilizzare su fondi chiari.', SCM_THEME ),
				), 'Versione in Positivo', 100 );

				$fields[] = scm_acf_field_image_url( $name . 'soggetto-logo', array('label'=> __( 'Logo', SCM_THEME )), 50 );
				$fields[] = scm_acf_field_image_url( $name . 'soggetto-icona', array('label'=> __( 'Icona', SCM_THEME )), 50 );
				
				$fields[] = scm_acf_field( $name . 'msg-soggetto-neg', array(
					'message',
					__( 'Carica uno logo e/o un\'icona da utilizzare su fondi scuri.', SCM_THEME ),
				), __( 'Versione in Negativo', SCM_THEME ), 100 );
				
				$fields[] = scm_acf_field_image_url( $name . 'soggetto-logo-neg', array('label'=> __( 'Logo', SCM_THEME )), 50 );
				$fields[] = scm_acf_field_image_url( $name . 'soggetto-icona-neg', array('label'=> __( 'Icona', SCM_THEME )), 50 );

			$fields[] = scm_acf_field_tab_left( $name . 'tab-soggetto-dati', array('label'=> __( 'Dati', SCM_THEME ) ) );
				$fields[] = scm_acf_field_link( $name . 'soggetto-link' );
				$fields[] = scm_acf_field_text( $name . 'soggetto-intestazione', array( 'placeholder'=>__('intestazione',SCM_THEME), 'prepend'=>__( 'Intestazione', SCM_THEME ) ), 100 );
				$fields[] = scm_acf_field_text( $name . 'soggetto-piva', array( 'placeholder'=>'0123456789101112', 'prepend'=>__( 'P.IVA', SCM_THEME ) ), 50 );
				$fields[] = scm_acf_field_text( $name . 'soggetto-cf', array( 'placeholder'=>'AAABBB123', 'prepend'=>__( 'C.F.', SCM_THEME ) ), 50 );

			$fields[] = scm_acf_field_tab_left( $name . 'tab-soggetto-luogo', array('label'=>__( 'Luoghi', SCM_THEME ) ) );
				$fields[] = scm_acf_field( $name . 'msg-soggetto-luoghi', array(
					'message',
					__( 'Assegna dei Luoghi a questo Soggetto. Clicca sul pulsante Luoghi nella barra laterale per crearne uno. Il primo Luogo dell\'elenco sarà considerato Luogo Principale per questo Soggetto.', SCM_THEME ),
				), __( 'Luoghi', SCM_THEME ) );

				$fields[] = scm_acf_field_objects( $name . 'soggetto-luoghi', array( 
                    'type'=>'rel-id', 
                    'types'=>'luoghi',
                    'label'=>'Seleziona Luoghi',
                ) );

			$fields[] = scm_acf_field_tab_left( $name . 'tab-social-soggetto', array('label'=>__( 'Social', SCM_THEME ) ) );
				$fields = array_merge( $fields, scm_acf_preset_flexible_buttons( $name . 'soggetto', 'social', __( 'Social', SCM_THEME ) ) );

			if( $hastaxes ){
				$fields[] = scm_acf_field_tab_left( $name . 'tab-tax-soggetto', array('label'=>__( 'Categorie', SCM_THEME ) ) );
					$fields = array_merge( $fields, scm_acf_preset_category( $name . 'soggetto', 'soggetti' ) );
					$fields = array_merge( $fields, scm_acf_preset_tags( $name . 'soggetto', 'soggetti' ) );
			}

			$fields = apply_filters( 'scm_filter_fields_soggetto', $fields );

			return $fields;

		}
	}
	
?>