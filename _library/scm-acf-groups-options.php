<?php

/**
* ACF all available Custom Fields Groups for Options.
*
* @link http://www.studiocreativo-m.it
*
* @package SCM
* @subpackage 2-ACF/Fields/OPTIONS
* @since 1.0.0
*/

// ------------------------------------------------------
//
// 1.0 Options
//		DEFAULT TYPES OPTIONS
//		DEFAULT TAXONOMIES OPTIONS
//		CUSTOM TYPES OPTIONS
//		TAXONOMIES OPTIONS
//		SLIDER OPTIONS
//		INTRO OPTIONS
//		GENERAL OPTIONS
//		STYLES OPTIONS
//		LAYOUT OPTIONS
//		NAVIGATION ALL OPTIONS
//		NAVIGATION BRANDING OPTIONS
//		NAVIGATION MENU OPTIONS
//		NAVIGATION SOCIAL OPTIONS
//		FOOTER
//		ROLES
//
// ------------------------------------------------------

// ------------------------------------------------------
// 1.0 OPTIONS
// ------------------------------------------------------

/**
* [GET] Options default types
* 
* @param {array} cont
* @param {array} default
* @return {array} Fields.
*/
function scm_acf_options_default_types( $cont = array(), $default = array() ) {

	$fields = array();

	$fields[] = scm_acf_field( 'default-types-list', array( 'type' => 'checkbox', 'default' => $default, 'choices' => $cont, 'toggle' => 1 ) );

	return $fields;
}

/**
* [GET] Options default taxonomies
*
* @param {array} cont
* @param {array} default
* @return {array} Fields.
*/
function scm_acf_options_default_taxonomies( $cont = array(), $default = array() ) {

	$fields = array();

	$fields[] = scm_acf_field( 'default-taxonomies-list', array( 'type' => 'checkbox', 'default' => $default, 'choices' => $cont, 'toggle' => 1 ) );

	return $fields;
}

/**
* [GET] Options types
* 
* @return {array} Types fields.
*/
function scm_acf_options_types() {

	$fields = array();

	$types = scm_acf_field_repeater( 'types-list', array( 
		'button'=>__( 'Aggiungi Type', SCM_THEME ),
	) );

	$types['sub_fields'][] = scm_acf_field_false( 'active', 0, 30, 0, 0, __( 'Attiva', SCM_THEME ) );
	$types['sub_fields'][] = scm_acf_field_name( 'plural', array( 'placeholder'=>__( 'Produzioni', SCM_THEME ), 'prepend'=>__( 'Plurale', SCM_THEME ), 'max' => 18 ), 70, 0, 1 );

	
		$types['sub_fields'][] = scm_acf_field_tab( 'tab-admin', array('label'=> __( 'Admin', SCM_THEME ) ) );
			$types['sub_fields'][] = scm_acf_field_false( 'admin', 0, 20, 0, 0, __( 'Admin', SCM_THEME ) );
			$types['sub_fields'][] = scm_acf_field_false( 'public', 0, 20, 0, 0, __( 'Archivi', SCM_THEME ) );
			$types['sub_fields'][] = scm_acf_field_false( 'add_cap', 0, 20, 0, 0, __( 'Capabilities', SCM_THEME ) );
			$types['sub_fields'][] = scm_acf_field_false( 'hidden', 0, 20, 0, 0, __( 'Hidden', SCM_THEME ) );
			$types['sub_fields'][] = scm_acf_field_false( 'post', 0, 20, 0, 0, __( 'Post', SCM_THEME ) );

		$types['sub_fields'][] = scm_acf_field_tab( 'tab-archive', array('label'=> __( 'Archivi', SCM_THEME ) ) );
			$types['sub_fields'][] = scm_acf_field_select( 'orderby', 'orderby', 50, 0, 0, __( 'Ordina per', SCM_THEME ) );
			$types['sub_fields'][] = scm_acf_field_select( 'ordertype', 'ordertype', 50, 0, 0, __( 'Ordinamento', SCM_THEME ) );

		$types['sub_fields'][] = scm_acf_field_tab( 'tab-menu', array('label'=> __( 'Menu', SCM_THEME ) ) );
			$types['sub_fields'][] = scm_acf_field_text( 'icon', array( 'default'=>'admin-site', 'placeholder'=>'admin-site (see below)', 'prepend'=>__( 'Icona', SCM_THEME ) ), 100, 0 );
			$types['sub_fields'][] = scm_acf_field_text( 'menu', array( 'default'=>'types', 'placeholder'=>'menu-group (see below)', 'prepend'=>__( 'Zona Menu', SCM_THEME ) ), 50, 0 );
			$types['sub_fields'][] = scm_acf_field_positive( 'menupos', array( 'default'=>0, 'prepend'=>__( 'Posizione Menu', SCM_THEME ), 'min'=>0, 'max'=>91 ), 50, 0 );

		$types['sub_fields'][] = scm_acf_field_tab( 'tab-labels', array('label'=> __( 'Labels', SCM_THEME ) ) );
			
			$types['sub_fields'][] = scm_acf_field_name( 'singular', array( 'placeholder'=>__( 'Produzione', SCM_THEME ), 'prepend'=>__( 'Singolare', SCM_THEME ), 'max'=>18 ), 50, 0 );
			$types['sub_fields'][] = scm_acf_field_name( 'slug', array( 'placeholder'=>__( 'produzioni', SCM_THEME ), 'prepend'=>__( 'Slug', SCM_THEME ), 'max'=>18 ), 50, 0 );
			$types['sub_fields'][] = scm_acf_field_name( 'short-singular', array( 'placeholder'=>__( 'Prod.', SCM_THEME ), 'prepend'=>__( 'Singolare Corto', SCM_THEME ), 'max'=>18 ), 50, 0 );
			$types['sub_fields'][] = scm_acf_field_name( 'short-plural', array( 'placeholder'=>__( 'Prods.', SCM_THEME ), 'prepend'=>__( 'Plurale Corto', SCM_THEME ), 'max'=>18 ), 50, 0 );
	
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

/**
* [GET] Options taxonomies
* 
* @return {array} Taxonomies fields.
*/
function scm_acf_options_taxonomies() {

	$fields = array();

	$taxes = scm_acf_field_repeater( 'taxonomies-list', array( 
		'button'=>__( 'Aggiungi Taxonomy', SCM_THEME ),
		'label'=>__( 'Taxonomies', SCM_THEME )
	) );

	$taxes['sub_fields'][] = scm_acf_field_false( 'active', 0, 30, 0, 0, __( 'Attiva', SCM_THEME ) );
	$taxes['sub_fields'][] = scm_acf_field_name( 'plural', array( 'max'=>25, 'placeholder'=>__( 'Nome Categorie', SCM_THEME ), 'prepend'=>__( 'Plurale', SCM_THEME ) ), 70, 0, 1 );

	$taxes['sub_fields'][] = scm_acf_field_tab( 'tab-admin', array( 'label'=> __( 'Admin', SCM_THEME )) );
		$taxes['sub_fields'][] = scm_acf_field_false( 'template', 0, 33, 0, 0, __( 'Template', SCM_THEME ) );
		$taxes['sub_fields'][] = scm_acf_field_false( 'add_cap', 0, 33, 0, 0, __( 'Capabilities', SCM_THEME ) );
		$taxes['sub_fields'][] = scm_acf_field_false( 'hierarchical', 0, 34, 0, 0, __( 'Hierarchical', SCM_THEME ) );

	$taxes['sub_fields'][] = scm_acf_field_tab( 'tab-labels', array( 'label'=> __( 'Labels', SCM_THEME )) );
		$taxes['sub_fields'][] = scm_acf_field_name( 'singular', array( 'max'=>25, 'placeholder'=>__( 'Nome Categoria', SCM_THEME ), 'prepend'=>__( 'Singolare', SCM_THEME ) ), 50, 0 );
		$taxes['sub_fields'][] = scm_acf_field_name( 'slug', array( 'max'=>25, 'placeholder'=>__( 'slug-categoria', SCM_THEME), 'prepend'=>__( 'Slug', SCM_THEME ) ), 50, 0 );

	$taxes['sub_fields'][] = scm_acf_field_tab( 'tab-locations', array( 'label'=> __( 'Locations', SCM_THEME )) );
		$taxes['sub_fields'][] = scm_acf_field( 'types', array( 'select2-multi-types_complete-horizontal' ), __( 'Seleziona Locations', SCM_THEME ), 100, 0 );

	$fields[] = $taxes;

	return $fields;
}

/**
* [GET] Options slider
* 
* @return {array} Slider fields.
*/
function scm_acf_options_slider( $default = '' ) {
	
	$fields = array();
	
	$fields[] = scm_acf_field_select( 'main-slider-active', array( 
		'type'=>'slider_model-no' . ( $default ? '-default' : '' ),
	), 100, 0, 0, __( 'Attiva Slider', SCM_THEME ) );

        $slider_enabled = array( array( 'field' => 'main-slider-active', 'operator' => '!=', 'value' => 'no' ), array( 'field' => 'main-slider-active', 'operator' => '!=', 'value' => 'default' ) );
            $fields[] = scm_acf_field_text( 'main-slider-field', array( 'placeholder'=>'[field name]' ), __( 'Slider', SCM_THEME ), $slider_enabled, 0, 0, 100 );
            $fields = array_merge( $fields, scm_acf_preset_term( 'main-slider', 'sliders', __( 'Slider', SCM_THEME ), $slider_enabled, 0, 0, 100 ) );

    return $fields;
}

/**
* [GET] Options intro
*
* @return {array} Intro fields.
*/
function scm_acf_options_intro() {

	$fields = array();

	$const = get_defined_constants( true );
	$const = $const[ 'user' ];
	$const = getAllByPrefix( $const, 'SCM_', 2 );
	$const = arrayToHTML( $const );

	$fields[] = scm_acf_field_tab_left( 'tab-intro-constants', array('label'=>__( 'Costanti', SCM_THEME )) );
		$fields[] = scm_acf_field( 'msg-constants', array('message', $const, 0, ''), 'Constants List' );

	$glob = $GLOBALS;
	$glob = getAllByPrefix( $glob, 'SCM_', 1 );
	$glob = arrayToHTML( $glob );

	$fields[] = scm_acf_field_tab_left( 'tab-intro-globals', array('label'=>__( 'Globali', SCM_THEME )) );
		$fields[] = scm_acf_field( 'msg-globals', array('message', $glob, 0, ''), 'Globals List' );

	$fields[] = scm_acf_field_tab_left( 'tab-intro-admin', array('label'=>__( 'Admin', SCM_THEME )) );
		$fields[] = scm_acf_field_false( 'admin-reset-roles', 0, 60, 0, 0, __( 'Reset Ruoli', SCM_THEME ) );
		$fields[] = scm_acf_field_positive( 'admin-level-advanced', array( 'default'=>0, 'placeholder'=>0, 'label'=>__( 'Advanced Level', SCM_THEME ) ), 60 );
		$fields[] = scm_acf_field_positive( 'admin-level-edit', array( 'default'=>30, 'placeholder'=>0, 'label'=>__( 'Edit Level', SCM_THEME ) ), 60 );

	return $fields;
}

/**
* [GET] Options general
*
* @return {array} General fields.
*/
function scm_acf_options_general() {

	$fields = array();

	$fields[] = scm_acf_field_tab_left( 'tab-opt-staff', array( 'label'=> __( 'Staff', SCM_THEME ) ) );
		$fields[] = scm_acf_field_email( 'opt-staff-email', 0, 50 );
		$fields[] = scm_acf_field_image_url( 'opt-staff-logo', array( 'label'=>'' ) );
		
	$fields[] = scm_acf_field_tab_left( 'tab-opt-footer', array( 'label'=> __( 'Footer', SCM_THEME ) ) );
		$fields = array_merge( $fields, scm_acf_preset_flexible_sections( 'footer' ) );
	$fields[] = scm_acf_field_tab_left( 'tab-opt-credits', array( 'label'=> __( 'Credits', SCM_THEME ) ) );
		$fields[] = scm_acf_field_false( 'opt-credits-login', array('label'=> __( 'Attiva Footer Login', SCM_THEME ) ), 60 );
		$fields[] = scm_acf_field_id( 'opt-credits-id', 0, 60 );
		$fields[] = scm_acf_field_class( 'opt-credits-class', 0, 60 );
		$fields[] = scm_acf_field_text( 'opt-credits-credits', array( 'prepend'=>__( 'Copyright', SCM_THEME ), 'default'=>'(C) (Y) TITLE', 'placeholder'=>'(C) (Y) TITLE' ), 60 );
		$fields[] = scm_acf_field_text( 'opt-credits-separator', array( 'prepend'=>__( 'Separatore', SCM_THEME ), 'default'=>'|', 'placeholder'=>'|' ), 60 );
		$fields[] = scm_acf_field_text( 'opt-credits-piva', array( 'prepend'=>__( 'P.IVA', SCM_THEME ), 'placeholder'=>'0123456789101112' ), 60 );
		$fields[] = scm_acf_field_false( 'opt-credits-policy', array('label'=> __( 'Privacy Policy Link', SCM_THEME ) ), 60 );
		$fields[] = scm_acf_field_text( 'opt-credits-policy-link', array( 'prepend'=>__( 'Policy Link', SCM_THEME ), 'placeholder'=>'Default is Iubenda Policy link (see Policies options)' ), 60 );
		$fields[] = scm_acf_field_text( 'opt-credits-designed', array( 'prepend'=>__( 'Designed by', SCM_THEME ), 'placeholder'=>'SCM' ), 60 );
		$fields[] = scm_acf_field_text( 'opt-credits-designed-link', array( 'prepend'=>__( 'Designed Link', SCM_THEME ), 'placeholder'=>'info@website.com' ), 60 );

	$fields[] = scm_acf_field_tab_left( 'tab-layout-settings', array('label'=>__( 'Layout', SCM_THEME )) );

		$fields[] = scm_acf_field_select( 'layout-alignment', 'alignment', 100, 0, 0, __( 'Allineamento Generale', SCM_THEME ) );
		
		// conditional
		$fields[] = scm_acf_field_select( 'layout-page', array(
			'type'=>'main_layout',
			'label'=>__( 'Larghezza Pagine', SCM_THEME ),
		) );
		
		$layout = array(
			'field' => 'layout-page',
			'operator' => '==',
			'value' => 'full',
		);

			$fields[] = scm_acf_field_select( 'layout-head', array( 
				'type'=>'main_layout',
				'label'=> __( 'Larghezza Header', SCM_THEME ),
				'default'=>'responsive',
			), 34, $layout );
			$fields[] = scm_acf_field_select( 'layout-content', array( 
				'type'=>'main_layout',
				'label'=> __( 'Larghezza Contenuti', SCM_THEME ),
				'default'=>'responsive',
			), 33, $layout );
			$fields[] = scm_acf_field_select( 'layout-foot', array( 
				'type'=>'main_layout',
				'label'=> __( 'Larghezza Footer', SCM_THEME ),
				'default'=>'responsive',
			), 33, $layout );
			$fields[] = scm_acf_field_select( 'layout-menu', array( 
				'type'=>'main_layout',
				'label'=> __( 'Larghezza Menu', SCM_THEME ),
				'default'=>'responsive',
			), 50, $layout );
			$fields[] = scm_acf_field_select( 'layout-sticky', array( 
				'type'=>'main_layout',
				'label'=> __( 'Larghezza Sticky Menu', SCM_THEME ),
				'default'=>'responsive',
			), 50, $layout );

		$fields[] = scm_acf_field_select( 'layout-tofull', 'responsive_events', 34, 0, 0, __( 'Responsive to Full', SCM_THEME ) );
		$fields[] = scm_acf_field_select( 'layout-tocolumn', 'responsive_events', 33, 0, 0, __( 'Responsive Columns', SCM_THEME ) );
		$fields[] = scm_acf_field_select( 'layout-max', 'responsive_layouts', 33, 0, 0, __( 'Max Responsive Width', SCM_THEME ) );	

	$fields[] = scm_acf_field_tab_left( 'tab-branding-settings', array('label'=> __( 'Favicon', SCM_THEME )) );
		$fields[] = scm_acf_field_image_url( 'opt-branding-ico', array('label'=>__( 'ICO 16', SCM_THEME )), 33 );
		$fields[] = scm_acf_field_image_url( 'opt-branding-54', array('label'=>__( 'ICO 54', SCM_THEME )), 33 );
		$fields[] = scm_acf_field_image_url( 'opt-branding-114', array('label'=>__( 'Icon 114', SCM_THEME )), 33 );
		$fields[] = scm_acf_field_image_url( 'opt-branding-png', array('label'=>__( 'PNG 16', SCM_THEME )), 33 );
		$fields[] = scm_acf_field_image_url( 'opt-branding-72', array('label'=>__( 'Icon 72', SCM_THEME )), 33 );
		$fields[] = scm_acf_field_image_url( 'opt-branding-144', array('label'=>__( 'Icon 144', SCM_THEME )), 33 );

	$fields[] = scm_acf_field_tab_left( 'tab-uploads-settings', array('label'=>__( 'Media Upload', SCM_THEME )) );
		$fields[] = scm_acf_field( 'opt-uploads-quality', array( 'percent', 85, '85', __( 'Qualità immagini', SCM_THEME ) ), __( 'Qualità', SCM_THEME ) );
		$fields[] = scm_acf_field( 'opt-uploads-width', array( 'pixel-max', 1600, '1600', __( 'Largezza massima immagini', SCM_THEME ) ), __( 'Larghezza Massima', SCM_THEME ) );
		$fields[] = scm_acf_field( 'opt-uploads-height', array( 'pixel-max', 1100, '1100', __( 'Altezza massima immagini', SCM_THEME ) ), __( 'Altezza Massima', SCM_THEME ) );

	$fields[] = scm_acf_field_tab_left( 'tab-fallback-settings', array('label'=>__( 'Old Browsers', SCM_THEME )) );
		$fields[] = scm_acf_field( 'opt-ie-version', array( 'positive', 10, '10', __( 'Internet Explorer', SCM_THEME ), '', 10 ), __( 'Versione Minima', SCM_THEME ) );
		$fields[] = scm_acf_field( 'opt-firefox-version', array( 'positive', 38, '38', __( 'Firefox', SCM_THEME ), '', 23 ), __( 'Versione Minima', SCM_THEME ) );
		$fields[] = scm_acf_field( 'opt-chrome-version', array( 'positive', 43, '43', __( 'Chrome', SCM_THEME ), '', 28 ), __( 'Versione Minima', SCM_THEME ) );
		$fields[] = scm_acf_field( 'opt-opera-version', array( 'positive', 23, '23', __( 'Opera', SCM_THEME ), '', 18 ), __( 'Versione Minima', SCM_THEME ) );
		$fields[] = scm_acf_field( 'opt-safari-version', array( 'positive', 7, '7', __( 'Safari', SCM_THEME ), '', 5 ), __( 'Versione Minima', SCM_THEME ) );
		$fields[] = scm_acf_field_image_url( 'opt-fallback-logo', array('label'=>__( 'Logo', SCM_THEME )) );

	$fields[] = scm_acf_field_tab_left( 'tab-opt-policies', array( 'label'=> __( 'Policies', SCM_THEME ) ) );
		$fields[] = scm_acf_field_positive( 'opt-policies-id', array( 'prepend'=>__( 'Iubenda Site ID', SCM_THEME ) ), 50 );
		$fields[] = scm_acf_field_text( 'opt-policies-lang', array( 'max'=>2, 'prepend'=>__( 'Main Language', SCM_THEME ) ), 50 );
		$fields[] = scm_acf_field_repeater( 'opt-policies-list', array( 'label'=>__( 'Iubenda Policies List', SCM_THEME ), 'sub'=>array(
			scm_acf_field_positive( 'id', array( 'prepend'=>__( 'Policy ID', SCM_THEME ) ), 50 ),
			scm_acf_field_text( 'lang', array( 'max'=>2, 'prepend'=>__( 'Policy Language', SCM_THEME ) ), 50 ),
		) ) );

	return $fields;
}

/**
* [GET] Options navigation
*
* @return {array} Navigation fields.
*/
function scm_acf_options_nav() {

	$fields = array();
	
	$fields[] = scm_acf_field_tab_left( 'tab-nav-brand', array('label'=>__( 'Logo', SCM_THEME )) );
        $fields = array_merge( $fields, scm_acf_options_nav_branding() );

    $fields[] = scm_acf_field_tab_left( 'tab-nav-menu', array('label'=>__( 'Main Menu', SCM_THEME )) );
        $fields = array_merge( $fields, scm_acf_options_nav_menu() );

    $fields[] = scm_acf_field_tab_left( 'tab-nav-home', array('label'=>__( 'Home Menu', SCM_THEME )) );
        $fields = array_merge( $fields, scm_acf_options_nav_home() );

    $fields[] = scm_acf_field_tab_left( 'tab-nav-toggle', array('label'=>__( 'Toggle Menu', SCM_THEME )) );
        $fields = array_merge( $fields, scm_acf_options_nav_toggle() );

    $fields[] = scm_acf_field_tab_left( 'tab-nav-sticky', array('label'=>__( 'Sticky Menu', SCM_THEME )) );
        $fields = array_merge( $fields, scm_acf_options_nav_sticky() );

    $fields[] = scm_acf_field_tab_left( 'tab-nav-side', array('label'=>__( 'Side Menu', SCM_THEME )) );
        $fields = array_merge( $fields, scm_acf_options_nav_side() );

    $fields[] = scm_acf_field_tab_left( 'tab-nav-social', array('label'=>__( 'Social Menu', SCM_THEME )) );
        $fields = array_merge( $fields, scm_acf_options_nav_social() );

	return $fields;
}

/**
* [GET] Options nav branding
*
* @return {array} Brand fields.
*/
function scm_acf_options_nav_branding() {
	
	$fields = array();
	
	$fields[] = scm_acf_field_select( 'brand-alignment', 'alignment' );
	$fields[] = scm_acf_field_text( 'brand-field', array('placeholder'=> '[field name]' ) );
	// conditional
	$fields[] = scm_acf_field_select( 'brand-head', 'branding_header' );
	$tipo = array(
		'field' => 'brand-head',
		'operator' => '==',
		'value' => 'img',
	);
	
		$fields[] = scm_acf_field_image_url( 'brand-logo', 0, 100, $tipo );
		$fields = array_merge( $fields, scm_acf_preset_size( 'brand-height', '', '40', 'px', __( 'Altezza Massima', SCM_THEME ), 100, $tipo ) );

	$fields[] = scm_acf_field_true( 'brand-link', array('label'=> __( 'Attiva Link', SCM_THEME ) ), 50 );
	$fields[] = scm_acf_field_true( 'brand-slogan', array('label'=> __( 'Attiva Slogan', SCM_THEME ) ), 50 );

	return $fields;
}

/**
* [GET] Options nav menu
*
* @return {array} Menu fields.
*/
function scm_acf_options_nav_menu() {
	
	$fields = array();
	
	$fields[] = scm_acf_field_select( 'menu-wp', 'wp_menu', 50 );
	
	$fields[] = scm_acf_field_false( 'menu-overlay', array('label'=> __( 'Attiva Overlay', SCM_THEME ) ), 50 );
	$fields[] = scm_acf_field_select( 'menu-position', 'position_menu', 50 );
	$fields[] = scm_acf_field_select( 'menu-alignment', 'alignment', 50 );
	
	$fields = array_merge( $fields, scm_acf_preset_text_font( 'menu' ) );
	
	return $fields;
}

/**
* [GET] Options home button
*
* @return {array} Menu fields.
*/
function scm_acf_options_nav_home() {
	
	$fields = array();

	$fields[] = scm_acf_field_select( 'menu-home', 'home_active-no', 100 );
	$fields[] = scm_acf_field_icon_no( 'menu-home-icon', 0, 33 );
	$fields[] = scm_acf_field_image_url( 'menu-home-image', 0, 34 );
	$fields[] = scm_acf_field_text( 'menu-home-text', 0, 33 );
	
	return $fields;
}

/**
* [GET] Options nav toggle menu
*
* @return {array} Menu fields.
*/
function scm_acf_options_nav_toggle() {
	
	$fields = array();

	$fields[] = scm_acf_field_select( 'menu-toggle', 'responsive_up', 34, 0, 0, __( 'Attiva Toggle Menu', SCM_THEME ) );
	$fields[] = scm_acf_field_icon( 'menu-toggle-icon-open', array('label'=>__( 'Icona Apri Toggle Menu', SCM_THEME ),'default'=>'bars'), 33 );
	$fields[] = scm_acf_field_icon( 'menu-toggle-icon-close', array('label'=>__( 'Icona Chiudi Toggle Menu', SCM_THEME ),'default'=>'arrow-circle-up'), 33 );

	$fields[] = scm_acf_field_false( 'menu-toggle-top', array( 'label'=>__( 'Scroll to #top' ) ), 50 );
	$fields[] = scm_acf_field_false( 'menu-toggle-home', array( 'label'=>__( 'Home link' ) ), 50 );

	return $fields;
}

/**
* [GET] Options nav sticky menu
*
* @return {array} Menu fields.
*/
function scm_acf_options_nav_sticky() {
	
	$fields = array();
	
	$fields[] = scm_acf_field_select( 'menu-sticky', 'sticky_active-no', 100, 0, 0, __( 'Seleziona Tipo', SCM_THEME ) );
	
	$sticky = array(
		'field' => 'menu-sticky',
		'operator' => '==',
		'value' => 'plus',
	);
	
		$fields[] = scm_acf_field_select( 'menu-sticky-attach', 'sticky_attach-no', 40, $sticky, 0, __( 'Attach to Menu', SCM_THEME ) );
		$fields[] = scm_acf_field_select( 'menu-sticky-anim', 'sticky_anim', 40, $sticky, 0, __( 'Animation', SCM_THEME ) );
		$fields[] = scm_acf_field( 'menu-sticky-offset', array( 'pixel', '', '0', __( 'Offset', SCM_THEME ) ), __( 'Offset', SCM_THEME ), 20, $sticky );
	
	$head = array(
		array(
			'field' => 'menu-sticky',
			'operator' => '!=',
			'value' => 'no',
		),
		array(
			'field' => 'menu-sticky',
			'operator' => '!=',
			'value' => 'head',
		)
	);

		$fields[] = scm_acf_field_false( 'menu-sticky-out', array('label'=> __( 'Fuori da Header', SCM_THEME ) ), 100, $head );

	return $fields;
}

/**
* [GET] Options nav side menu
*
* @return {array} Side Nav fields.
*/
function scm_acf_options_nav_side() {

	$fields = array();
	
	// conditional
	$fields[] = scm_acf_field_false( 'side-enabled', array('label'=> __( 'Attiva Side Menu', SCM_THEME ) ) );
	//$side = array( 'field' => 'side-enabled', 'operator' => '==', 'value' => 1 );

	return $fields;

}

/**
* [GET] Options nav social menu
*
* @return {array} Social Nav fields.
*/
function scm_acf_options_nav_social() {

	$fields = array();
	
	// conditional
	$fields[] = scm_acf_field_false( 'follow-enabled', array('label'=> __( 'Attiva Social Menu', SCM_THEME ) ) );
	$social = array( 'field' => 'follow-enabled', 'operator' => '==', 'value' => 1 );

		$fields[] = scm_acf_field_object( 'element', array( 
            'type'=>'id', 
            'types'=>'soggetti',
            'label'=>__( 'Soggetto', SCM_THEME ),
        ), 100, $social );

		$fields[] = scm_acf_field_select( 'follow-position', 'head_social_position', 50, $social, 0, __( 'Posizione', SCM_THEME ) );
		$fields[] = scm_acf_field_select( 'follow-alignment', 'alignment', 50, $social, 0, __( 'Allineamento', SCM_THEME ) );
		
		$fields = array_merge( $fields, scm_acf_preset_size( 'follow-size', '', 16, 'px', __( 'Dimensione Icone', SCM_THEME ), 100, $social ) );
		$fields = array_merge( $fields, scm_acf_preset_rgba( 'follow', '', 1, 100, $social ) );
		
		$fields[] = scm_acf_field_select( 'follow-shape', 'box_shape-no', 100, $social, 0, __( 'Forma Box', SCM_THEME ) );
		$shape = scm_acf_merge_conditions( $social, array( 'field' => 'follow-shape', 'operator' => '!=', 'value' => 'no' ) );
		$rounded = scm_acf_merge_conditions( $shape, array( 'field' => 'follow-shape', 'operator' => '!=', 'value' => 'square' ) );

			$fields[] = scm_acf_field_select( 'follow-shape-size', 'simple_size', 50, $rounded, 0, __( 'Dimensione angoli Box', SCM_THEME ) );
			$fields[] = scm_acf_field_select( 'follow-shape-angle', 'box_angle_type', 50, $rounded, 0, __( 'Angoli Box', SCM_THEME ) );

			$fields = array_merge( $fields, scm_acf_preset_rgba( 'follow-box', '', 1, 100, $shape ) );

	return $fields;
}

/**
* [GET] Options footer
*
* @return {array} Footer fields.
*/
/*function scm_acf_options_foot() {

	$fields = array();

	$fields = array_merge( $fields, scm_acf_preset_flexible_sections( 'footer' ) );

	return $fields;
}*/

/**
* [GET] Options tools
*
* @return {array} Tools fields.
*/
function scm_acf_options_tools() {

	$fields = array();

	$fields[] = scm_acf_field_tab_left( 'tab-tools-fader', array( 'label'=>'Page Fader' ) );
		$fields[] = scm_acf_field_select( 'opt-tools-fade-waitfor', 'waitfor-no', 100, 0, 0, __( 'Wait for', SCM_THEME ) );
		$fields[] = scm_acf_field( 'opt-tools-fade-in', array( 'second', .5, '.5', __( 'Fade In', SCM_THEME ), __( 'sec', SCM_THEME ), 0, 10 ), '', __( 'Fade In', SCM_THEME ) );
		$fields[] = scm_acf_field( 'opt-tools-fade-out', array( 'second', .3, '.3', __( 'Fade Out', SCM_THEME ), __( 'sec', SCM_THEME ), 0, 10 ), '', __( 'Fade Out', SCM_THEME ) );
		$fields[] = scm_acf_field( 'opt-tools-fade-opacity', array( 'percent', 0, '0', __( 'Fade Opacity', SCM_THEME ), __( '/10', SCM_THEME ), 0, 10 ), '', __( 'Fade Opacity', SCM_THEME ) );
	$fields[] = scm_acf_field_tab_left( 'tab-tools-fadecontent', array( 'label'=>'Content Fader' ) );
		$fields[] = scm_acf_field_text( 'opt-tools-fadecontent', array( 'prepend' => 'Selectors', 'default'=>'.scm-section:not(.first) > .scm-row, .scm-image', 'placeholder'=>'.scm-section:not(.first) > .scm-row' ) );
		$fields[] = scm_acf_field_percent( 'opt-tools-fadecontent-offset', array( 'prepend' => 'Trigger' ) );
	$fields[] = scm_acf_field_tab_left( 'tab-tools-singlenav', array( 'label'=>'Single Page Nav' ) );
		$fields[] = scm_acf_field( 'opt-tools-singlepagenav-activeclass', array( 'class', 'active', 'active', __( 'Active Class', SCM_THEME ) ), __( 'Active Class', SCM_THEME ) );
		$fields[] = scm_acf_field( 'opt-tools-singlepagenav-interval', array( 'second', '', '500', __( 'Interval', SCM_THEME ) ), __( 'Interval', SCM_THEME ) );
		$fields = array_merge( $fields, scm_acf_preset_size( 'opt-tools-singlepagenav-offset', 0, '0', 'px', __( 'Offset', SCM_THEME ) ) );
		$fields[] = scm_acf_field( 'opt-tools-singlepagenav-threshold', array( 'pixel', '', '150', __( 'Threshold', SCM_THEME ) ), __( 'Threshold', SCM_THEME ) );
	$fields[] = scm_acf_field_tab_left( 'tab-tools-smooth', array( 'label'=>'Smooth Scroll' ) );
		$fields[] = scm_acf_field( 'opt-tools-smoothscroll-duration', array( 'second-max', '', '0', __( 'Durata', SCM_THEME ) ), __( 'Durata', SCM_THEME ) );
		$fields[] = scm_acf_field( 'opt-tools-smoothscroll-delay', array( 'second', '', '0', __( 'Delay', SCM_THEME ) ), __( 'Delay', SCM_THEME ) );
		$fields[] = scm_acf_field_true( 'opt-tools-smoothscroll-page', 0, 100, 0, 0, __( 'Smooth Scroll (su nuove pagine)', SCM_THEME ) );
		$fields[] = scm_acf_field( 'opt-tools-smoothscroll-delay-new', array( 'type'=>'second', 'placeholder'=>'0,3', 'prepend'=>__( 'Delay su nuova pagina', SCM_THEME ) ) );
		$fields = array_merge( $fields, scm_acf_preset_size( 'opt-tools-smoothscroll-offset', 0, '0', 'px', __( 'Offset', SCM_THEME ) ) );
		$fields[] = scm_acf_field_false( 'opt-tools-smoothscroll-head', 0, 100, 0, 0, __( 'Includi altezza Sticky Header', SCM_THEME ) );
		$fields[] = scm_acf_field_select( 'opt-tools-smoothscroll-ease', 'ease', 100, 0, 0, __( 'Ease', SCM_THEME ) );
	$fields[] = scm_acf_field_tab_left( 'tab-tools-greensock', array( 'label'=>'Greensock' ) );
		$fields[] = scm_acf_field_false( 'opt-tools-greensock', 0, 20, 0, 0, __( 'Greensock', SCM_THEME ) );
	$fields[] = scm_acf_field_tab_left( 'tab-tools-slider', array( 'label'=>'Main Slider' ) );
		$fields = array_merge( $fields, scm_acf_options_slider() );
		$fields[] = scm_acf_field_false( 'opt-tools-nivo', 0, 20, 0, 0, __( 'Nivo Slider', SCM_THEME ) );
		$fields[] = scm_acf_field_true( 'opt-tools-bx', 0, 20, 0, 0, __( 'BX Slider', SCM_THEME ) );
	$fields[] = scm_acf_field_tab_left( 'tab-tools-parallax', array( 'label'=>'Parallax' ) );
		$fields[] = scm_acf_field_false( 'opt-tools-parallax', 0, 20, 0, 0, __( 'Parallax', SCM_THEME ) );
	$fields[] = scm_acf_field_tab_left( 'tab-tools-fancybox', array( 'label'=>'Fancybox' ) );
		$fields[] = scm_acf_field_false( 'opt-tools-fancybox', 0, 20, 0, 0, __( 'Fancybox', SCM_THEME ) );
	$fields[] = scm_acf_field_tab_left( 'tab-tools-tooltip', array( 'label'=>'Tooltip' ) );
		$fields[] = scm_acf_field_false( 'opt-tools-tooltip', 0, 20, 0, 0, __( 'Tooltip', SCM_THEME ) );
	$fields[] = scm_acf_field_tab_left( 'tab-tools-cursor', array( 'label'=>'Cursor' ) );
		$fields[] = scm_acf_field_false( 'opt-tools-cursor', 0, 20, 0, 0, __( 'Cursor', SCM_THEME ) );
	$fields[] = scm_acf_field_tab_left( 'tab-tools-gmaps', array( 'label'=>'Google Maps' ) );
		$fields[] = scm_acf_field_text( 'opt-tools-map-api', 0, 100, 0, 0, __( 'Google Maps API Key', SCM_THEME ) );
		$fields = array_merge( $fields, scm_acf_preset_map_icon( 'opt-tools' ) );
	$fields[] = scm_acf_field_tab_left( 'tab-tools-toppage', array( 'label'=>'Top Of Page' ) );
		$fields[] = scm_acf_field_icon( 'opt-tools-topofpage-icon', array('default'=>'angle-up') );
		$fields[] = scm_acf_field_text( 'opt-tools-topofpage-text', array( 'default'=>__( 'Inizio pagina', SCM_THEME ), 'placeholder'=>__( 'Titolo', SCM_THEME ), 'prepend'=>__( 'Titolo', SCM_THEME ) ) );
		$fields[] = scm_acf_field_number( 'opt-tools-topofpage-offset', array( 'append'=>'px', 'default'=>200, 'placeholder'=>'0', 'prepend'=>__( 'Offset', SCM_THEME ) ) );
		$fields = array_merge( $fields, scm_acf_preset_rgba( 'opt-tools-topofpage-txt', '#000000', 1, 100, 0, __( 'Trasparenza Icona', SCM_THEME ), __( 'Colore Icona', SCM_THEME )) );
		$fields = array_merge( $fields, scm_acf_preset_rgba( 'opt-tools-topofpage-bg', '#DDDDDD', 1, 100, 0, __( 'Trasparenza Fondo', SCM_THEME ), __( 'Colore Fondo', SCM_THEME ) ) );


	return $fields;
}

/**
* [GET] Options styles
*
* @return {array} Style fields.
*/
function scm_acf_options_styles() {

	$fields = array();

	$fields[] = scm_acf_field_tab_left( 'tab-testi', array('label'=>__( 'Testi', SCM_THEME )) );
        $fields = array_merge( $fields, scm_acf_preset_text_style() );

	$fields[] = scm_acf_field_tab_left( 'tab-responsive', array('label'=>__( 'Responsive', SCM_THEME )) );
		
		$fields[] = scm_acf_field( 'msg-responsive-size', array( 'message', __( 'Aggiungi o togli px dalla dimensione generale.', SCM_THEME ) ), __( 'Dimensione testi', SCM_THEME ) );

			$fields[] = scm_acf_field( 'styles-size-wide', array( 'number', 0, '0', '+/-', 'px', -100, 100 ), 'Wide' );
			$fields[] = scm_acf_field( 'styles-size-desktop', array( 'number', 0, '0', '+/-', 'px', -100, 100 ), 'Desktop' );
			$fields[] = scm_acf_field( 'styles-size-landscape', array( 'number', 0, '0', '+/-', 'px', -100, 100 ), 'Tablet Landscape' );
			$fields[] = scm_acf_field( 'styles-size-portrait', array( 'number', 0, '0', '+/-', 'px', -100, 100 ), 'Tablet Portrait' );
			$fields[] = scm_acf_field( 'styles-size-smart', array( 'number', 0, '0', '+/-', 'px', -100, 100 ), 'Mobile' );

	$fields[] = scm_acf_field_tab_left( 'tab-sfondo', array('label'=>__( 'Sfondo Pagine', SCM_THEME )) );
        $fields = array_merge( $fields, scm_acf_preset_background_style() );

	$fields[] = scm_acf_field_tab_left( 'tab-loadingpage', array('label'=>__( 'Loading Page', SCM_THEME )) );
		$fields = array_merge( $fields, scm_acf_preset_background_style( 'loading' ) );

	return $fields;
}

/**
* [GET] Options library
*
* @return {array} Library fields.
*/
function scm_acf_options_library() {

	$fields = array();

	$fields[] = scm_acf_field_tab_left( 'tab-colors', array('label'=>__( 'Colori', SCM_THEME)) );
		$colors = scm_acf_field_repeater( 'styles-colors', array( 
			'button'=>__( 'Aggiungi Colore', SCM_THEME ),
			'label'=>__( 'Aggiungi colori alla libreria', SCM_THEME )
		));
			$colors['sub_fields'][] = scm_acf_field_text( 'name', array( 'class'=>'sanitize-value', 'label'=>__( 'Nome', SCM_THEME ) ), 30 );
			$colors['sub_fields'] = array_merge( $colors['sub_fields'], scm_acf_preset_rgba( '', array( 'library'=>0, 'width'=>70 ) ) );

		$fields[] = $colors;


	$fields[] = scm_acf_field_tab_left( 'tab-fonts', array('label'=>__( 'Fonts', SCM_THEME)) );
		$gfonts = scm_acf_field_repeater( 'styles-google', array( 
			'button'=>__( 'Aggiungi Google Web Font', SCM_THEME ),
			'label'=>__( 'Includi Google Web Fonts', SCM_THEME ), 
			'instructions'=>__( 'Visita <a href="https://fonts.google.com/">https://fonts.google.com/</a>, scegli la famiglia e gli stili da includere.', SCM_THEME ),
		) );

			$gfonts['sub_fields'][] = scm_acf_field( 'family', array( 'text', '', 'Open Sans', __( 'Family', SCM_THEME ) ), __( 'Family', SCM_THEME ), 'required' );
			$gfonts['sub_fields'][] = scm_acf_field( 'style', array( 'checkbox-webfonts_google_styles', '400', 'horizontal' ), __( 'Styles', SCM_THEME ) );

		$fields[] = $gfonts;

		$afonts = scm_acf_field_repeater( 'styles-adobe', array( 
			'button'=>__( 'Aggiungi Adobe TypeKit', SCM_THEME ),
			'label'=>__( 'Includi Adobe TypeKit', SCM_THEME ), 
		) );

			$afonts['sub_fields'][] = scm_acf_field( 'id', array( 'text', '', '000000', __( 'ID', SCM_THEME ) ), __( 'ID', SCM_THEME ), 'required' );
			$afonts['sub_fields'][] = scm_acf_field( 'name', array( 'text', '', __( 'Nome Kit', SCM_THEME ), __( 'Kit', SCM_THEME ) ), __( 'Nome', SCM_THEME ) );

		$fields[] = $afonts;

	return $fields;
}

?>