<?php
/**
 * @package SCM
 */

// *****************************************************
// *	ACF FIELDS OPTIONS
// *****************************************************

	// DEFAULT TYPES OPTIONS
	if ( ! function_exists( 'scm_acf_options_default_types' ) ) {
		function scm_acf_options_default_types( $cont = array(), $default = array() ) {

			$fields = array();

			$fields[] = scm_acf_preset( 'default-types-list', array( 'default' => $default, 'choices' => $cont, 'toggle' => 1 ), array( 'type' => 'checkbox' ) );

			return $fields;
		}
	}

	// DEFAULT TAXONOMIES OPTIONS
	if ( ! function_exists( 'scm_acf_options_default_taxonomies' ) ) {
		function scm_acf_options_default_taxonomies( $cont = array(), $default = array() ) {

			$fields = array();

			$fields[] = scm_acf_preset( 'default-taxonomies-list', array( 'default' => $default, 'choices' => $cont, 'toggle' => 1 ), array( 'type' => 'checkbox' ) );

			return $fields;
		}
	}
	
	// CUSTOM TYPES OPTIONS
	if ( ! function_exists( 'scm_acf_options_types' ) ) {
		function scm_acf_options_types( $name = '', $min = 0, $max ) {

			$default = 0; // todo: da rimuovere

			$name = ( $name ? $name . '-' : '' );

			$fields = array();

			$types = scm_acf_field_repeater( $name . 'types-list', $default, __('Aggiungi Type', SCM_THEME), '', 100, 0, $min, $max );
			$types['sub_fields'][] = scm_acf_field_false_true( 'SHOW', $default, 25, 0, __( 'Mostra Opzioni', SCM_THEME ) );
			$types['sub_fields'][] = scm_acf_field_false_true( 'active', $default, 25, 0, __( 'Attiva Type', SCM_THEME ) );
			$types['sub_fields'][] = scm_acf_field_name( 'plural', array( 'placeholder'=>__( 'Produzioni', SCM_THEME ), 'prepend'=>__( 'Plurale', SCM_THEME ), 'max' => 18 ), 50, 0, 1 );

			$active = array(
				'field' => 'SHOW',
				'operator' => '==',
				'value' => '1',
			);
			
				$types['sub_fields'][] = scm_acf_field( 'tab-admin', 'tab', __( 'Admin', SCM_THEME ), 0, $active );
					$types['sub_fields'][] = scm_acf_field_false_true( 'admin', $default, 20, $active, __( 'Admin', SCM_THEME ) );
					$types['sub_fields'][] = scm_acf_field_false_true( 'public', $default, 20, $active, __( 'Archivi', SCM_THEME ) );
					$types['sub_fields'][] = scm_acf_field_false_true( 'add_cap', $default, 20, $active, __( 'Capabilities', SCM_THEME ) );
					$types['sub_fields'][] = scm_acf_field_false_true( 'hidden', $default, 20, $active, __( 'Hidden', SCM_THEME ) );
					$types['sub_fields'][] = scm_acf_field_false_true( 'post', $default, 20, $active, __( 'Post', SCM_THEME ) );

				$types['sub_fields'][] = scm_acf_field( 'tab-archive', 'tab', __( 'Archivi', SCM_THEME ), 0, $active );
					$types['sub_fields'][] = scm_acf_field_select( 'orderby', $default, 'orderby', 50, $active, '', __( 'Ordina per', SCM_THEME ) );
					$types['sub_fields'][] = scm_acf_field_select( 'ordertype', $default, 'ordertype', 50, $active, '', __( 'Ordinamento', SCM_THEME ) );

				$types['sub_fields'][] = scm_acf_field( 'tab-menu', 'tab', __( 'Menu', SCM_THEME ), 0, $active );
					$types['sub_fields'][] = scm_acf_field_text( 'icon', array( 'default'=>'admin-site', 'placeholder'=>'admin-site (see below)', 'prepend'=>__( 'Icona', SCM_THEME ) ), 100, $active );
					$types['sub_fields'][] = scm_acf_field_text( 'menu', array( 'default'=>'types', 'placeholder'=>'menu-group (see below)', 'prepend'=>__( 'Zona Menu', SCM_THEME ) ), 50, $active );
					$types['sub_fields'][] = scm_acf_field_positive( 'menupos', array( 'default'=>0, 'prepend'=>__( 'Posizione Menu', SCM_THEME ), 'min'=>0, 'max'=>91 ), 50, $active );

				$types['sub_fields'][] = scm_acf_field( 'tab-labels', 'tab', __( 'Labels', SCM_THEME ), 0, $active );
					
					$types['sub_fields'][] = scm_acf_field_name( 'singular', array( 'placeholder'=>__( 'Produzione', SCM_THEME ), 'prepend'=>__( 'Singolare', SCM_THEME ), 'max'=>18 ), 50, $active );
					$types['sub_fields'][] = scm_acf_field_name( 'slug', array( 'placeholder'=>__( 'produzioni', SCM_THEME ), 'prepend'=>__( 'Slug', SCM_THEME ), 'max'=>18 ), 50, $active );
					$types['sub_fields'][] = scm_acf_field_name( 'short-singular', array( 'placeholder'=>__( 'Prod.', SCM_THEME ), 'prepend'=>__( 'Singolare Corto', SCM_THEME ), 'max'=>18 ), 50, $active );
					$types['sub_fields'][] = scm_acf_field_name( 'short-plural', array( 'placeholder'=>__( 'Prods.', SCM_THEME ), 'prepend'=>__( 'Plurale Corto', SCM_THEME ), 'max'=>18 ), 50, $active );
			
			$fields[] = $types;

			$fields[] = scm_acf_field( 'msg-types-instructions', array(
						'message',
						__( 'Visita <a href="https://developer.wordpress.org/resource/dashicons/" target="_blank">https://developer.wordpress.org/resource/dashicons/</a> per un elenco delle icone disponibili e dei corrispettivi nomi, da inserire nel seguente campo.', SCM_THEME ) . '<br><br>' .
						'
						<strong>Posizione in Menu (menu):</strong>
						<br>
						scm = SCM Options<br>
						pages = Pages and Sections<br>
						types = Custom Types<br>
						media = Media<br>
						contacts = Contacts<br>
						settings = Settings<br>
						\' \' = Plugins ...
						<br><br>
						<strong>Posizione in Gruppo (menupos):</strong>
						<br>
						0 = to end<br>
						1 = first position<br>
						2 = second position<br>
						...
						',
					), 'Icona' );

			return $fields;
		}
	}

	// TAXONOMIES OPTIONS
	if ( ! function_exists( 'scm_acf_options_taxonomies' ) ) {
		function scm_acf_options_taxonomies( $name = '', $min = 0, $max, $cont ) {

			$default = 0; // todo: da rimuovere

			$name = ( $name ? $name . '-' : '' );

			$fields = array();

			$taxes = scm_acf_field_repeater( $name . 'taxonomies-list', $default, __( 'Aggiungi Taxonomy', SCM_THEME ), __( 'Taxonomies', SCM_THEME ), 100, 0, $min, $max );
			$taxes['sub_fields'][] = scm_acf_field_false_true( 'SHOW', $default, 25, 0, __( 'Mostra Opzioni', SCM_THEME ) );
			$taxes['sub_fields'][] = scm_acf_field_false_true( 'active', $default, 25, 0, __( 'Attiva Taxonomy', SCM_THEME ) );
			$taxes['sub_fields'][] = scm_acf_field_name( 'plural', array( 'max'=>18, 'placeholder'=>__( 'Nome Categorie', SCM_THEME ), 'prepend'=>__( 'Plurale', SCM_THEME ) ), 50, 0, 1 );

			$active = array(
				'field' => 'SHOW',
				'operator' => '==',
				'value' => '1',
			);

			$taxes['sub_fields'][] = scm_acf_field( 'tab-admin', 'tab', __( 'Admin', SCM_THEME ), 0, $active );
				$taxes['sub_fields'][] = scm_acf_field_false_true( 'template', $default, 33, $active, __( 'Template', SCM_THEME ) );
				$taxes['sub_fields'][] = scm_acf_field_false_true( 'add_cap', $default, 33, $active, __( 'Capabilities', SCM_THEME ) );
				$taxes['sub_fields'][] = scm_acf_field_false_true( 'hierarchical', $default, 34, $active, __( 'Hierarchical', SCM_THEME ) );
				//$taxes['sub_fields'][] = scm_acf_field( 'hierarchical', array( 'select' . ( $default ? '-default' : '' ), array( __( 'Tag', SCM_THEME ), __( 'Categoria', SCM_THEME ) ) ), __( 'Seleziona Tipologia', SCM_THEME ), 34, $active );

			$taxes['sub_fields'][] = scm_acf_field( 'tab-labels', 'tab', __( 'Labels', SCM_THEME ), 0, $active );
				$taxes['sub_fields'][] = scm_acf_field_name( 'singular', array( 'max'=>18, 'placeholder'=>__( 'Nome Categoria', SCM_THEME ), 'prepend'=>__( 'Singolare', SCM_THEME ) ), 50, $active );
				$taxes['sub_fields'][] = scm_acf_field_name( 'slug', array( 'max'=>18, 'placeholder'=>__( 'slug-categoria', SCM_THEME), 'prepend'=>__( 'Slug', SCM_THEME ) ), 50, $active );

			$taxes['sub_fields'][] = scm_acf_field( 'tab-locations', 'tab', __( 'Locations', SCM_THEME ), 0, $active );
				$taxes['sub_fields'][] = scm_acf_field( 'types', array( 'select2-multi-types_complete-horizontal' . ( $default ? '-default' : '' ) ), __( 'Seleziona Locations', SCM_THEME ), 100, $active );

			$fields[] = $taxes;

			return $fields;
		}
	}

	// MODULE OPTIONS
	/*if ( ! function_exists( 'scm_acf_options_module_p' ) ) {
		function scm_acf_options_module_p( $name = '', $default = 0, $width = 100, $placeholder = '', $label = 'Link a Pagina' ) {

			$name = ( $name ? $name . '-' : '' );

			$fields = array();

			$fields[] = scm_acf_field_object( $name . 'page', $default, 'page', $width, '', 'Pagina Modulo' );

            return $fields;
		}
	}*/

	// SLIDER OPTIONS
	if ( ! function_exists( 'scm_acf_options_slider' ) ) {
		function scm_acf_options_slider( $name = '', $default = 0, $width = 100, $placeholder = '', $label = '' ) {
			$label = ( $label ?: __( 'Attiva Slider', SCM_THEME ) );

			$name = ( $name ? $name . '-' : '' );

			$fields = array();
			
			$fields[] = scm_acf_field_select1( $name . 'slider-active', $default, 'slider_model-no', $width, 0, array( 'no' => __( 'Disattiva', SCM_THEME ) ), $label );
                $slider_enabled = array( array( 'field' => $name . 'slider-active', 'operator' => '!=', 'value' => 'no' ), array( 'field' => $name . 'slider-active', 'operator' => '!=', 'value' => 'default' ) );
                    $fields = array_merge( $fields, scm_acf_preset_term( $name . 'slider', 0, 'sliders', __( 'Slider', SCM_THEME ), $slider_enabled, 0, 0, $width ) );

            return $fields;
		}
	}

	// INTRO OPTIONS
	if ( ! function_exists( 'scm_acf_options_intro' ) ) {
		function scm_acf_options_intro( $name = '', $default = 0 ) {

			$name = ( $name ? $name . '-' : '' );

			$const = get_defined_constants( true );
			$const = $const[ 'user' ];
			$const = getAllByPrefix( $const, 'SCM_', 2 );
			$const = arrayToHTML( $const );

			$fields = array();

			$fields[] = scm_acf_field( 'tab-' . $name . 'intro-constants', 'tab-left', __( 'Costanti', SCM_THEME ) );
				$fields[] = scm_acf_field( 'msg-constants', array('message', $const, 0, ''), 'Constants List' );

			return $fields;

		}
	}


	// GENERAL OPTIONS
	if ( ! function_exists( 'scm_acf_options_general' ) ) {
		function scm_acf_options_general() {

			$default = 0; // todo: da rimuovere ovunque

			$fields = array();

			$fields[] = scm_acf_field( 'tab-opt-staff', 'tab-left', __( 'Staff', SCM_THEME ) );
				$fields[] = scm_acf_field_email( 'opt-staff-email', 0, 50 );
				$fields[] = scm_acf_field_image( 'opt-staff-logo', $default, 50, 0, __( 'Logo Login', SCM_THEME ) );

			$fields[] = scm_acf_field( 'tab-branding-settings', 'tab-left', __( 'Favicon', SCM_THEME ), 33 );
				$fields[] = scm_acf_field_image( 'opt-branding-ico', $default, 33, 0, __( 'ICO 16', SCM_THEME ) );
				$fields[] = scm_acf_field_image( 'opt-branding-54', $default, 33, 0, __( 'ICO 54', SCM_THEME ) );
				$fields[] = scm_acf_field_image( 'opt-branding-114', $default, 33, 0, __( 'Icon 114', SCM_THEME ) );
				$fields[] = scm_acf_field_image( 'opt-branding-png', $default, 33, 0, __( 'PNG 16', SCM_THEME ) );
				$fields[] = scm_acf_field_image( 'opt-branding-72', $default, 33, 0, __( 'Icon 72', SCM_THEME ) );
				$fields[] = scm_acf_field_image( 'opt-branding-144', $default, 33, 0, __( 'Icon 144', SCM_THEME ) );

			$fields[] = scm_acf_field( 'tab-uploads-settings', 'tab-left', 'Media Upload' );
				$fields[] = scm_acf_field( 'opt-uploads-quality', array( 'percent', 100, '100', __( 'Qualità immagini', SCM_THEME ) ), __( 'Qualità', SCM_THEME ) );
				$fields[] = scm_acf_field( 'opt-uploads-width', array( 'pixel-max', 1800, '1800', __( 'Largezza massima immagini', SCM_THEME ) ), __( 'Larghezza Massima', SCM_THEME ) );
				$fields[] = scm_acf_field( 'opt-uploads-height', array( 'pixel-max', 1800, '1800', __( 'Altezza massima immagini', SCM_THEME ) ), __( 'Altezza Massima', SCM_THEME ) );

			$fields[] = scm_acf_field( 'tab-tools-settings', 'tab-left', __( 'Strumenti', SCM_THEME ) );
				$fields[] = scm_acf_field( 'msg-fader', 'message', __( 'Pages Fader', SCM_THEME ) );
					$fields[] = scm_acf_field_select( 'opt-tools-fade-waitfor', $default, 'waitfor-no', 100, 0, '', __( 'Wait for', SCM_THEME ) );
					$fields[] = scm_acf_field( 'opt-tools-fade-in', array( 'second', '', '1', __( 'Fade In', SCM_THEME ), __( 'sec', SCM_THEME ), 0, 10 ), '', __( 'Fade In', SCM_THEME ) );
					$fields[] = scm_acf_field( 'opt-tools-fade-out', array( 'second', '', '1', __( 'Fade Out', SCM_THEME ), __( 'sec', SCM_THEME ), 0, 10 ), '', __( 'Fade Out', SCM_THEME ) );
				$fields[] = scm_acf_field( 'msg-toppage', 'message', __( 'Top Of Page', SCM_THEME ) );
					$fields[] = scm_acf_field( 'opt-tools-topofpage-offset', array( 'pixel', 200, 200, __( 'Offset', SCM_THEME ) ), __( 'Offset', SCM_THEME ) );
					$fields[] = scm_acf_field_icon( 'opt-tools-topofpage-icon', $default, 'angle-up' );
					$fields[] = scm_acf_field( 'opt-tools-topofpage-title', array( 'name', __( 'Inizio pagina', SCM_THEME ), __( 'Inizio pagina', SCM_THEME ) ), __( 'Titolo', SCM_THEME ) );
					$fields = array_merge( $fields, scm_acf_preset_rgba( 'opt-tools-topofpage-txt') );
					$fields = array_merge( $fields, scm_acf_preset_rgba( 'opt-tools-topofpage-bg', '#DDDDDD' ) );
				$fields[] = scm_acf_field( 'msg-smooth', 'message', __( 'Smooth Scroll', SCM_THEME ) );
					$fields[] = scm_acf_field( 'opt-tools-smoothscroll-duration', array( 'second-max', '', '0', __( 'Durata', SCM_THEME ) ), __( 'Durata', SCM_THEME ) );
					$fields[] = scm_acf_field( 'opt-tools-smoothscroll-delay', array( 'second', '', '0', __( 'Delay', SCM_THEME ) ), __( 'Delay', SCM_THEME ) );
					$fields[] = scm_acf_field_select_enable( 'opt-tools-smoothscroll-page', $default, __( 'Smooth Scroll (su nuove pagine)', SCM_THEME ) );
					$fields[] = scm_acf_field( 'opt-tools-smoothscroll-delay-new', array( 'type'=>'second', 'placeholder'=>'0,3', 'prepend'=>__( 'Delay su nuova pagina', SCM_THEME ) ) );
					$fields = array_merge( $fields, scm_acf_preset_size( 'opt-tools-smoothscroll-offset', 0, '0', 'px', __( 'Offset', SCM_THEME ) ) );
					$fields[] = scm_acf_field_select( 'opt-tools-smoothscroll-ease', $default, 'ease', 100, 0, '', __( 'Ease', SCM_THEME ) );
				$fields[] = scm_acf_field( 'msg-singlenav', 'message', __( 'Single Page Nav', SCM_THEME ) );
					$fields[] = scm_acf_field( 'opt-tools-singlepagenav-activeclass', array( 'class', 'active', 'active', __( 'Active Class', SCM_THEME ) ), __( 'Active Class', SCM_THEME ) );
					$fields[] = scm_acf_field( 'opt-tools-singlepagenav-interval', array( 'second', '', '500', __( 'Interval', SCM_THEME ) ), __( 'Interval', SCM_THEME ) );
					$fields = array_merge( $fields, scm_acf_preset_size( 'opt-tools-singlepagenav-offset', 0, '0', 'px', __( 'Offset', SCM_THEME ) ) );
					$fields[] = scm_acf_field( 'opt-tools-singlepagenav-threshold', array( 'pixel', '', '150', __( 'Threshold', SCM_THEME ) ), __( 'Threshold', SCM_THEME ) );
				$fields[] = scm_acf_field( 'msg-fadecontent', 'message', __( 'Fade Content on Scroll', SCM_THEME ) );
					$fields[] = scm_acf_field_text( 'opt-tools-fadecontent', array( 'default'=>'.scm-section:not(.first) > .scm-row', 'placeholder'=>'.scm-section:not(.first) > .scm-row' ) );
					$fields[] = scm_acf_field_text( 'opt-tools-fadecontent-offset', array( 'default'=>'100%', 'placeholder'=>'100%' ) );
				$fields[] = scm_acf_field( 'msg-tools', 'message', __( 'Tools', SCM_THEME ) );
					$fields[] = scm_acf_field_falsetrue( 'opt-tools-parallax', 0, 20, 0, 'Parallax' );
					$fields[] = scm_acf_field_falsetrue( 'opt-tools-fancybox', 0, 20, 0, 'Fancybox' );
				$fields[] = scm_acf_field( 'msg-slider', 'message', __( 'Main Slider', SCM_THEME ) );
					$fields = array_merge( $fields, scm_acf_options_slider( 'main', $default ) );
					$fields[] = scm_acf_field_falsetrue( 'opt-tools-nivo', 0, 20, 0, 'Nivo Slider' );
					$fields[] = scm_acf_field_truefalse( 'opt-tools-bx', 0, 20, 0, 'BX Slider' );
				$fields[] = scm_acf_field( 'msg-gmaps', 'message', __( 'Google Maps', SCM_THEME ) );
					$fields = array_merge( $fields, scm_acf_preset_map_icon( 'opt-tools' ) );

			$fields[] = scm_acf_field( 'tab-fallback-settings', 'tab-left', 'Old Browsers' );
				$fields[] = scm_acf_field( 'opt-ie-version', array( 'positive', 10, '10', __( 'Internet Explorer', SCM_THEME ), '', 10 ), __( 'Versione Minima', SCM_THEME ) );
				$fields[] = scm_acf_field( 'opt-firefox-version', array( 'positive', 38, '38', __( 'Firefox', SCM_THEME ), '', 23 ), __( 'Versione Minima', SCM_THEME ) );
				$fields[] = scm_acf_field( 'opt-chrome-version', array( 'positive', 43, '43', __( 'Chrome', SCM_THEME ), '', 28 ), __( 'Versione Minima', SCM_THEME ) );
				$fields[] = scm_acf_field( 'opt-opera-version', array( 'positive', 23, '23', __( 'Opera', SCM_THEME ), '', 18 ), __( 'Versione Minima', SCM_THEME ) );
				$fields[] = scm_acf_field( 'opt-safari-version', array( 'positive', 7, '7', __( 'Safari', SCM_THEME ), '', 5 ), __( 'Versione Minima', SCM_THEME ) );
				$fields[] = scm_acf_field_image( 'opt-fallback-logo', $default, 100, 0, __( 'Logo', SCM_THEME ) );

			return $fields;

		}
	}

	// STYLES OPTIONS
	if ( ! function_exists( 'scm_acf_options_styles' ) ) {
		function scm_acf_options_styles() {

			$default = 0; //todo: da rimuovere

			$fields = array();

			$fields[] = scm_acf_field( 'tab-testi', 'tab-left', __( 'Testi', SCM_THEME ) );
                $fields = array_merge( $fields, scm_acf_preset_text_style() );

            $fields[] = scm_acf_field( 'tab-sfondo', 'tab-left', __( 'Sfondo', SCM_THEME ) );
                $fields = array_merge( $fields, scm_acf_preset_background_style() );

			$fields[] = scm_acf_field( 'tab-loadingpage', 'tab-left', __( 'Loading Page', SCM_THEME ) );
				$fields = array_merge( $fields, scm_acf_preset_background_style( 'loading' ) );

			$fields[] = scm_acf_field( 'tab-fonts', 'tab-left', 'Fonts' );
				$gfonts = scm_acf_field_repeater( 'styles-google', $default, __( 'Aggiungi Google Web Font', SCM_THEME ), __( 'Includi Google Web Fonts', SCM_THEME ), '', 0, '', '', __( 'Visita <a href="https://www.google.com/fonts">https://www.google.com/fonts</a>, scegli la famiglia e gli stili da includere.', SCM_THEME ) );

					$gfonts['sub_fields'][] = scm_acf_field( 'family', array( 'text', '', 'Open Sans', __( 'Family', SCM_THEME ) ), __( 'Family', SCM_THEME ), 'required' );
					$gfonts['sub_fields'][] = scm_acf_field( 'style', array( 'checkbox-webfonts_google_styles', '', 'horizontal' ), __( 'Styles', SCM_THEME ) );

				$fields[] = $gfonts;

				$afonts = scm_acf_field_repeater( 'styles-adobe', $default, __( 'Aggiungi Adobe TypeKit', SCM_THEME ), __( 'Includi Adobe TypeKit', SCM_THEME ) );

					$afonts['sub_fields'][] = scm_acf_field( 'id', array( 'text', '', '000000', __( 'ID', SCM_THEME ) ), __( 'ID', SCM_THEME ), 'required' );
					$afonts['sub_fields'][] = scm_acf_field( 'name', array( 'text', '', __( 'Nome Kit', SCM_THEME ), __( 'Kit', SCM_THEME ) ), __( 'Nome', SCM_THEME ) );

				$fields[] = $afonts;

			$fields[] = scm_acf_field( 'tab-responsive', 'tab-left', 'Responsive' );
				
				$fields[] = scm_acf_field( 'msg-responsive-size', array( 'message', __( 'Aggiungi o togli px dalla dimensione generale.', SCM_THEME ) ), __( 'Dimensione testi', SCM_THEME ) );

					$fields[] = scm_acf_field( 'styles-size-wide', array( 'number', 0, '0', '+/-', 'px', -100, 100 ), 'Wide' );
					$fields[] = scm_acf_field( 'styles-size-desktop', array( 'number', 0, '0', '+/-', 'px', -100, 100 ), 'Desktop' );
					$fields[] = scm_acf_field( 'styles-size-landscape', array( 'number', 0, '0', '+/-', 'px', -100, 100 ), 'Tablet Landscape' );
					$fields[] = scm_acf_field( 'styles-size-portrait', array( 'number', 0, '0', '+/-', 'px', -100, 100 ), 'Tablet Portrait' );
					$fields[] = scm_acf_field( 'styles-size-smart', array( 'number', 0, '0', '+/-', 'px', -100, 100 ), 'Mobile' );


			return $fields;
		}
	}

	// LAYOUT OPTIONS
	if ( ! function_exists( 'scm_acf_options_layout' ) ) {
		function scm_acf_options_layout( $name = '', $default = 0 ) {

			$name = ( $name ? $name . '-' : '');

			$fields = array();

			$fields[] = scm_acf_field_select_align( $name . 'layout-alignment', $default );
			
			// conditional
			$fields[] = scm_acf_field_select_layout( $name . 'layout-page', $default, __( 'Larghezza Pagine', SCM_THEME ), 100, 0, 'responsive' );
			
			$layout = array(
				'field' => $name . 'layout-page',
				'operator' => '==',
				'value' => 'full',
			);

				$fields[] = scm_acf_field_select_layout( $name . 'layout-head', $default, __( 'Larghezza Header', SCM_THEME ), 34, $layout, 'responsive' );
				$fields[] = scm_acf_field_select_layout( $name . 'layout-content', $default, __( 'Larghezza Contenuti', SCM_THEME ), 33, $layout, 'responsive' );
				$fields[] = scm_acf_field_select_layout( $name . 'layout-foot', $default, __( 'Larghezza Footer', SCM_THEME ), 33, $layout, 'responsive' );
				$fields[] = scm_acf_field_select_layout( $name . 'layout-menu', $default, __( 'Larghezza Menu', SCM_THEME ), 50, $layout, 'responsive' );
				$fields[] = scm_acf_field_select_layout( $name . 'layout-sticky', $default, __( 'Larghezza Sticky Menu', SCM_THEME ), 50, $layout, 'responsive' );

			$fields[] = scm_acf_field_select1( $name . 'layout-tofull',  $default, 'responsive_events', 34, 0, '', __( 'Responsive to Full', SCM_THEME ) );
			$fields[] = scm_acf_field_select1( $name . 'layout-tocolumn',  $default, 'responsive_events', 33, 0, '', __( 'Responsive Columns', SCM_THEME ) );
			$fields[] = scm_acf_field_select1( $name . 'layout-max',  $default, 'responsive_layouts', 33, 0, '', __( 'Max Responsive Width', SCM_THEME ) );

			return $fields;

		}
	}

	// HEAD ALL OPTIONS
	if ( ! function_exists( 'scm_acf_options_head' ) ) {
		function scm_acf_options_head() {

			$fields = array();

			// +++ todo: elimina i 3 HEAD OPTIONS, la Head diventa come il Foot, con ripetitore sezioni, o qualcosa di simile ma chiuso (con elementi come Social, Logo, Menu)
			
			$fields[] = scm_acf_field( 'tab-head-brand', 'tab-left', __( 'Brand', SCM_THEME ) );
                $fields = array_merge( $fields, scm_acf_options_head_branding() );

            $fields[] = scm_acf_field( 'tab-head-menu', 'tab-left', __( 'Menu', SCM_THEME ) );
                $fields = array_merge( $fields, scm_acf_options_head_menu() );

            $fields[] = scm_acf_field( 'tab-head-social', 'tab-left', __( 'Social', SCM_THEME ) );
                $fields = array_merge( $fields, scm_acf_options_head_social() );

			return $fields;
		}
	}

	// HEAD BRANDING OPTIONS
	if ( ! function_exists( 'scm_acf_options_head_branding' ) ) {
		function scm_acf_options_head_branding( $name = '' ) {

			$default = 0; //todo: da rimuovere
			
			$name = ( $name ? $name . '-brand' : 'brand');

			$fields = array();
			
			$fields[] = scm_acf_field_select_align( $name . '-alignment', $default );
			// conditional
			$fields[] = scm_acf_field_select( $name . '-head', $default, 'branding_header', 100, 0, '', __( 'Tipo', SCM_THEME ) );
			$tipo = array(
				'field' => $name . '-head',
				'operator' => '==',
				'value' => 'img',
			);
			
				$fields[] = scm_acf_field_image( $name . '-logo', $default, 100, $tipo, __( 'Logo', SCM_THEME ) );
				$fields = array_merge( $fields, scm_acf_preset_size( $name . '-height', '', '40', 'px', __( 'Altezza Massima', SCM_THEME ), 100, $tipo ) );

			$fields[] = scm_acf_field_select_disable( $name . '-link', $default, __( 'Link', SCM_THEME ) );

			$fields[] = scm_acf_field_select_hide( $name . '-slogan', $default, __( 'Slogan', SCM_THEME ) );

			return $fields;
		}
	}

	// HEAD MENU OPTIONS
	if ( ! function_exists( 'scm_acf_options_head_menu' ) ) {
		function scm_acf_options_head_menu( $name = '' ) {

			$default = 0; //todo: da rimuovere
			
			$name = ( $name ? $name . '-menu' : 'menu');

			$fields = array();
			
			$fields[] = scm_acf_field( 'msg-menu', 'message', __( 'Opzioni Menu', SCM_THEME ) );

				$fields[] = scm_acf_field_falsetrue( $name . '-auto', 0, 100, 0, 'Automatic Menu' );

				$fields[] = scm_acf_field_select( $name . '-wp', $default, 'wp_menu', 50, 0, '', __( 'Menu', SCM_THEME ) );
				
				$fields[] = scm_acf_field_select_disable( $name . '-overlay', $default, __( 'Overlay', SCM_THEME ), 50 );
				$fields[] = scm_acf_field_select( $name . '-position', $default, 'position_menu', 50, 0, '', __( 'Posizione', SCM_THEME ) );
				$fields[] = scm_acf_field_select_align( $name . '-alignment', $default, 50 );
				
				$fields = array_merge( $fields, scm_acf_preset_text_font( $name ) );

			$fields[] = scm_acf_field( 'msg-toggle', 'message', __( 'Toggle Menu', SCM_THEME ) );
				$fields[] = scm_acf_field_select( $name . '-toggle', $default, 'responsive_up', 34, 0, '', __( 'Attiva Toggle Menu', SCM_THEME ) );
				$fields[] = scm_acf_field_icon( $name . '-toggle-icon-open', $default, 'bars', '', 33, 0, __( 'Icona Apri Toggle Menu', SCM_THEME ) );
				$fields[] = scm_acf_field_icon( $name . '-toggle-icon-close', $default, 'arrow-circle-up', '', 33, 0, __( 'Icona Chiudi Toggle Menu', SCM_THEME ) );

			$fields[] = scm_acf_field( 'msg-home', 'message', __( 'Home Button', SCM_THEME ) );
				$fields[] = scm_acf_field_select( $name . '-home', $default, 'home_active', 50, 0, '', __( 'Attiva Home Button', SCM_THEME ) );
				$fields[] = scm_acf_field_icon( $name . '-home-icon', $default, 'home', '', 50, 0, __( 'Icona Home Button', SCM_THEME ) );
				$fields[] = scm_acf_field_select( $name . '-home-logo', $default, 'responsive_down-no', 50, 0, '', __( 'Attiva Logo', SCM_THEME ) );
				$fields[] = scm_acf_field_image( $name . '-home-image', $default, 50, 0, __( 'Logo Home', SCM_THEME ) );

			$fields[] = scm_acf_field( 'msg-sticky', 'message', __( 'Sticky Menu', SCM_THEME ) );
				$fields[] = scm_acf_field_select_disable( $name . '-sticky-out', $default, __( 'Fuori da Header', SCM_THEME ) );
				// conditional
				$fields[] = scm_acf_field_select( $name . '-sticky', $default, 'sticky_active-no', 100, 0, '', __( 'Seleziona Tipo', SCM_THEME ) );
				$sticky = array(
					'field' => $name . '-sticky',
					'operator' => '==',
					'value' => 'plus',
				);
					$fields[] = scm_acf_field_select( $name . '-sticky-attach', $default, 'sticky_attach-no', 50, $sticky, '', __( 'Attach to Menu', SCM_THEME ) );
					$fields[] = scm_acf_field( $name . '-sticky-offset', array( 'pixel', '', '0', __( 'Offset', SCM_THEME ) ), __( 'Offset', SCM_THEME ), 50, $sticky );

			return $fields;
		}
	}

// MANNAGGIA ALLE COZZE, VEDI DI LEVARE STE OPZIONI COMPLESSE

	// HEAD SOCIAL OPTIONS
	if ( ! function_exists( 'scm_acf_options_head_social' ) ) {
		function scm_acf_options_head_social( $name = '' ) {

			$default = 0; //todo: da rimuovere

			$orig = $name;
			$name = ( $name ? $name . '-follow' : 'follow');

			$fields = array();
			
			// conditional
			$fields[] = scm_acf_field_select_hide( $name . '-enabled', $default, __( 'Social', SCM_THEME ) );
			$social = array( 'field' => $name . '-enabled', 'operator' => '==', 'value' => 'on' );

				$fields[] = scm_acf_field_object( 'element', $default, 'soggetti', 100, $social, __( 'Soggetto', SCM_THEME ) ); // mmmh
				$fields[] = scm_acf_field_select( $name . '-position', $default, 'head_social_position', 50, $social, '', __( 'Posizione', SCM_THEME ) );
				$fields[] = scm_acf_field_select_align( $name . '-alignment', $default, 50, $social );
				
				$fields = array_merge( $fields, scm_acf_preset_size( $name . '-size', '', 16, 'px', __( 'Dimensione Icone', SCM_THEME ), 100, $social ) );
				$fields = array_merge( $fields, scm_acf_preset_rgba( $orig, '', 1, 100, $social ) );

			// +++ todo: aggiungere bg_image e tutte bg_cose nella lista Forma Box
				
				$fields[] = scm_acf_field_select1( $name . '-shape', $default, 'box_shape-no', 100, $social, __( 'Forma', SCM_THEME ), __( 'Forma Box', SCM_THEME ) );
				$shape = scm_acf_group_condition( $social, array( 'field' => $name . '-shape', 'operator' => '!=', 'value' => 'no' ) );
				$rounded = scm_acf_group_condition( $shape, array( 'field' => $name . '-shape', 'operator' => '!=', 'value' => 'square' ) );

					$fields[] = scm_acf_field_select1( $name . '-shape-size', $default, 'simple_size', 50, $rounded, __( 'Dimensione', SCM_THEME ), __( 'Dimensione angoli Box', SCM_THEME ) );
					$fields[] = scm_acf_field_select1( $name . '-shape-angle', $default, 'box_angle_type', 50, $rounded, __( 'Angoli', SCM_THEME ), __( 'Angoli Box', SCM_THEME ) );

					$fields = array_merge( $fields, scm_acf_preset_rgba( $name . 'box', '', 1, 100, $shape ) );

			return $fields;
		}
	}

	// FOOTER
	if ( ! function_exists( 'scm_acf_options_foot' ) ) {
		function scm_acf_options_foot( $name = '', $default = 0 ) {

			$name = ( $name ? $name . '-' : '');

			$fields = array();

			$fields = array_merge( $fields, scm_acf_preset_flexible_sections( $name . 'footer', $default ) );

			return $fields;
		}
	}


	
?>