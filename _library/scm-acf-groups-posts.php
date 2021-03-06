<?php

/**
 * ACF all available Custom Fields Groups for Posts.
 *
 * @link http://www.studiocreativo-m.it
 *
 * @package SCM
 * @subpackage 2-ACF/Fields/GROUP
 * @since 1.0.0
 */

// ------------------------------------------------------
//
// 1.0 Groups
//		PAGES
//		BANNERS
//		MODULES
//		SECTIONS
//		SLIDERS
//		SLIDES
//		EVENTI
//		NEWS
//		ARTICOLI
//		RASSEGNE STAMPA
//		DOCUMENTI
//		GALLERIE
//		VIDEO
//		LUOGHI
//		SOGGETTI
//
// ------------------------------------------------------

// ------------------------------------------------------
// 1.0 GROUPS
// ------------------------------------------------------

/**
* [GET] Fields PAGES
*
* @param {string} name
* @return {array} Fields.
*/
function scm_acf_fields_page( $name = '' ) {

	$name = ( $name ? $name . '-' : '');

	$fields = array();

	$fields = apply_filters( 'scm_filter_fields_page_before', $fields );

	// ADVANCED
		$fields = array_merge( $fields, scm_acf_preset_advanced_options( $name . 'page', 'page' ) );

		//$fields[] = scm_acf_field_select( $name . 'page-layout', 'main_layout-default', 34 );
		//$fields = array_merge( $fields, scm_acf_preset_selectors( $name . 'page', 33, 33 ) );
		//$fields[] = scm_acf_field_select( $name . 'page-menu', 'wp_menu', 50 );
		//$fields[] = scm_acf_field_false( $name . 'page-form', 0, 50, 0, 0, __( 'Attiva ACF Form', SCM_THEME ) );

	$fields = array_merge( $fields, scm_acf_preset_flexible_sections( $name ) );

	$fields = apply_filters( 'scm_filter_fields_page', $fields );

	return $fields;
}

/**
* [GET] Fields BANNERS
*
* @param {string} name
* @return {array} Fields.
*/
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
        $flexible['layouts'][] = scm_acf_layout( 'elenco_puntato', 'block', __( 'Elenco', SCM_THEME ), '', '', scm_acf_object_elenco_puntato( 0, 0, 1 ) );
        $flexible['layouts'][] = scm_acf_layout( 'section', 'block', __( 'Banner', SCM_THEME ), '', '', scm_acf_object_section( 0, 0, 'sections-cat:banners' ) );

    $fields[] = $flexible;

    $fields = apply_filters( 'scm_filter_fields_banner', $fields );

	return $fields;
}

/**
* [GET] Fields MODULES
*
* @param {string} name
* @return {array} Fields.
*/
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
        $flexible['layouts'][] = scm_acf_layout( 'elenco_puntato', 'block', __( 'Elenco', SCM_THEME ), '', '', scm_acf_object_elenco_puntato( 0, 0, 1 ) );
        $flexible['layouts'][] = scm_acf_layout( 'quote', 'block', __( 'Quote', SCM_THEME ), '', '', scm_acf_object_quote( 0, 0, 1) );
        $flexible['layouts'][] = scm_acf_layout( 'pulsanti', 'block', __( 'Pulsanti', SCM_THEME ), '', '', scm_acf_object_pulsanti( 0, 0, 1 ) );
        $flexible['layouts'][] = scm_acf_layout( 'separatore', 'block', __( 'Separatore', SCM_THEME ), '', '', scm_acf_object_separatore( 0, 0, 1 ) );
		
		$flexible['layouts'] = apply_filters( 'scm_filter_layouts_module', $flexible['layouts'] );

	$fields[] = $flexible;

	$fields = apply_filters( 'scm_filter_fields_module', $fields );

	return $fields;
}

/**
* [GET] Fields SECTIONS
*
* @param {string} name
* @return {array} Fields.
*/
function scm_acf_fields_sections( $name = '' ) {

	//$name = ( $name ? $name . '-' : '');

	$fields = array();

	$fields = apply_filters( 'scm_filter_fields_section_before', $fields );

	// ADVANCED
	$fields = array_merge( $fields, scm_acf_preset_advanced_options( $name, 'module' ) );

	$fields = array_merge( $fields, scm_acf_preset_repeater_columns( $name ) );
	
	// ADVANCED
	$fields = array_merge( $fields, scm_fields_add_class( scm_acf_preset_tags( $name . '-section', 'sections' ), SCM_ADVANCED_OPTIONS . ' hidden' ) );

	$fields = apply_filters( 'scm_filter_fields_section', $fields );

	return $fields;
}

/**
* [GET] Fields SLIDERS
*
* @param {string} name
* @return {array} Fields.
*/
function scm_acf_fields_sliders( $name = '' ) {

	$name = ( $name ? $name . '-' : '');

	$fields = array();

	$fields = array_merge( $fields, scm_acf_preset_size( $name . 'height', '', 'auto', 'px', __( 'Altezza', SCM_THEME ), 99 ) );
	//$fields[] = scm_acf_field_select( $name . 'theme', 'themes_nivo', 100, 0, 0, __( 'Tema', SCM_THEME ) );
	$fields[] = scm_acf_field_select( $name . 'alignment', array( 'type'=>'vertical_alignment', 'default'=>'middle', 'label'=>'Allineamento verticale' ) );
	
		//$fields[] = scm_acf_field_select( $name . 'effect', 'effect_nivo', 100, 0, 0, __( 'Effetto Slider', SCM_THEME ) );
		//$fields[] = scm_acf_field_number( $name . 'slices', array( 'default'=>10, 'prepend'=>__( 'Slices', SCM_THEME ), 'min'=>1, 'max'=>30 ) );
		/*$fields[] = scm_acf_field_number( $name . 'cols', array( 'default'=>8, 'prepend'=>__( 'Colonne', SCM_THEME ), 'min'=>1, 'max'=>8 ) );
		$fields[] = scm_acf_field_number( $name . 'rows', array( 'default'=>8, 'prepend'=>__( 'Righe', SCM_THEME ), 'min'=>1, 'max'=>100 ) );*/
		$fields[] = scm_acf_field_number( $name . 'speed', array( 'default'=>1, 'prepend'=>__( 'Velocità', SCM_THEME ) ) );
		$fields[] = scm_acf_field_number( $name . 'pause', array( 'default'=>3, 'prepend'=>__( 'Pausa', SCM_THEME ) ) );

		$fields[] = scm_acf_field_option( $name . 'start', array( 'default'=>0, 'prepend'=>__( 'Start', SCM_THEME ) ) );
		$fields[] = scm_acf_field_true( $name . 'hover', 0, 100, 0, 0, __( 'Pause on Hover', SCM_THEME ) );
		$fields[] = scm_acf_field_false( $name . 'manual', 0, 100, 0, 0, __( 'Avanzamento Manuale', SCM_THEME ) );
		$fields[] = scm_acf_field_true( $name . 'direction', 0, 100, 0, 0, __( 'Direction Nav', SCM_THEME ) );
		$fields[] = scm_acf_field_false( $name . 'control', 0, 100, 0, 0, __( 'Control Nav', SCM_THEME ) );
		//$fields[] = scm_acf_field_false( $name . 'thumbs', 0, 100, 0, 0, __( 'Thumbs Nav', SCM_THEME ) );
		$fields[] = scm_acf_field_icon( $name . 'prev', array('default'=>'angle-left','label'=>__( 'Prev Icon', SCM_THEME )) );
		$fields[] = scm_acf_field_icon( $name . 'next', array('default'=>'angle-right','label'=>__( 'Next Icon', SCM_THEME )) );

	return $fields;
}

/**
* [GET] Fields SLIDES
*
* @param {string} name
* @return {array} Fields.
*/
function scm_acf_fields_slides( $name = '' ) {

	$name = ( $name ? $name . '-' : '');

	$fields = array();
	$hastaxes = checkTaxes( 'slides' );

	$fields = apply_filters( 'scm_filter_fields_slide_before', $fields );

	$fields[] = scm_acf_field_tab_left( $name . 'tab-img-slide', array('label'=>__( 'Immagine', SCM_THEME ) ) );

		$fields[] = scm_acf_field_image_url( $name . 'slide-image', array( 'preview'=>'medium', 'library'=>'all' ) );

	if( $hastaxes ){
		$fields[] = scm_acf_field_tab_left( $name . 'tab-tax-slide', array('label'=>__( 'Impostazioni', SCM_THEME ) ) );
			$fields = array_merge( $fields, scm_acf_preset_categories( $name . 'slide', 'slides' ) );
			$fields = array_merge( $fields, scm_acf_preset_tags( $name . 'slide', 'slides' ) );
	}

	// conditional link
	$fields[] = scm_acf_field_select( $name . 'slide-link', 'links_type-no', 100, 0, 0, __( 'Collegamento', SCM_THEME ) );

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

		$fields[] = scm_acf_field_link( $name . 'slide-external', 0, 100, $link );
		$fields[] = scm_acf_field_object( $name . 'slide-internal', array( 
            'type'=>'link', 
            'types'=>'page',
        ), 100, $page );

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

/**
* [GET] Fields EVENTI
*
* @param {string} name
* @return {array} Fields.
*/
function scm_acf_fields_eventi( $name = '' ) {

	$name = ( $name ? $name . '-' : '');

	$fields = array();

	$fields = apply_filters( 'scm_filter_fields_evento_before', $fields );

	$fields[] = scm_acf_field_tab_left( $name . 'tab-settings-evento', array('label'=>__( 'Impostazioni', SCM_THEME ) ) );
		//$fields[] = scm_acf_field_image_url( $name . 'image' );
		$fields[] = scm_acf_field_date( 'start-date', 0, 50, 0, 0, __( 'Data inizio', SCM_THEME ) );
		$fields[] = scm_acf_field_date( 'end-date', 0, 50, 0, 0, __( 'Data fine', SCM_THEME ) );
		if( post_type_exists('luoghi') ){
			$fields[] = scm_acf_field_objects( $name . 'luoghi', array( 
		        'type'=>'rel-id', 
		        'types'=>'luoghi',
		        'label'=>'Seleziona Luoghi',
		    ) );
		}

	$fields[] = scm_acf_field_tab_left( $name . 'tab-contenuto-evento', array('label'=>__( 'Contenuto', SCM_THEME ) ) );
		$fields = array_merge( $fields, scm_acf_fields_modules( $name ) );

	$fields[] = scm_acf_field_tab_left( $name . 'tab-media-evento', array('label'=>__( 'Media', SCM_THEME ) ) );
		$fields = array_merge( $fields, scm_acf_preset_attachments() );
		
	$hastaxes = checkTaxes( 'eventi' );	
	if( $hastaxes ){
		$fields[] = scm_acf_field_tab_left( $name . 'tab-tax-evento', array('label'=>__( 'Categorie', SCM_THEME ) ) );
			$fields = array_merge( $fields, scm_acf_preset_categories( $name . 'evento', 'eventi' ) );
			$fields = array_merge( $fields, scm_acf_preset_tags( $name . 'evento', 'eventi' ) );
	}

	$fields = apply_filters( 'scm_filter_fields_evento', $fields );

	return $fields;
}

/**
* [GET] Fields NEWS
*
* @param {string} name
* @return {array} Fields.
*/
function scm_acf_fields_news( $name = '' ) {

	$name = ( $name ? $name . '-' : '');

	$fields = array();

	$fields = apply_filters( 'scm_filter_fields_news_before', $fields );

	$fields[] = scm_acf_field_image( $name . 'image' );
	$fields = array_merge( $fields, scm_acf_fields_modules( $name ) );

	$fields = apply_filters( 'scm_filter_fields_news', $fields );

	return $fields;
}

/**
* [GET] Fields ARTICOLI
*
* @param {string} name
* @return {array} Fields.
*/
function scm_acf_fields_articoli( $name = '' ) {

	$name = ( $name ? $name . '-' : '');

	$fields = array();
	$hastaxes = checkTaxes( 'articoli' );

	$fields = apply_filters( 'scm_filter_fields_articolo_before', $fields );

	if( $hastaxes )
		$fields[] = scm_acf_field_tab_left( $name . 'tab-set-articolo', array('label'=>__( 'Contenuto', SCM_THEME ) ) );
		
		$fields[] = scm_acf_field_image_url( $name . 'image' );
		$fields[] = scm_acf_field_textarea( $name . 'excerpt', array( 'rows'=>5, 'label'=>__( 'Anteprima', SCM_THEME ) ) );
		$fields[] = scm_acf_field_editor_media( $name . 'editor' );

	if( $hastaxes ){
		$fields[] = scm_acf_field_tab_left( $name . 'tab-tax-articolo', array('label'=>__( 'Categorie', SCM_THEME ) ) );
			$fields = array_merge( $fields, scm_acf_preset_categories( $name . 'articolo', 'articoli' ) );
			$fields = array_merge( $fields, scm_acf_preset_tags( $name . 'articolo', 'articoli' ) );
	}

	$fields = apply_filters( 'scm_filter_fields_articolo', $fields );

	return $fields;
}

/**
* [GET] Fields RASSEGNE STAMPA
*
* @param {string} name
* @return {array} Fields.
*/
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

/**
* [GET] Fields DOCUMENTI
*
* @param {string} name
* @return {array} Fields.
*/
function scm_acf_fields_documenti( $name = '', $type = 'documenti' ) {

	$name = ( $name ? $name . '-' : '');

	$fields = array();
	$hastaxes = checkTaxes( $type );

	$fields = apply_filters( 'scm_filter_fields_documento_before', $fields );
	
	if( $hastaxes )
		$fields[] = scm_acf_field_tab_left( $name . 'tab-set-documento', array('label'=>__( 'Impostazioni', SCM_THEME ) ) );
		
		$fields[] = scm_acf_field_file_url( $name . 'documento-file' );

	if( $hastaxes ){
		$fields[] = scm_acf_field_tab_left( $name . 'tab-tax-documento', array('label'=>__( 'Categorie', SCM_THEME ) ) );
			$fields = array_merge( $fields, scm_acf_preset_categories( $name . 'documento', $type ) );
			$fields = array_merge( $fields, scm_acf_preset_tags( $name . 'documento', $type ) );
	}

	$fields = apply_filters( 'scm_filter_fields_documento', $fields );

	return $fields;
}

/**
* [GET] Fields GALLERIE
*
* @param {string} name
* @return {array} Fields.
*/
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

/**
* [GET] Fields VIDEO
*
* @param {string} name
* @return {array} Fields.
*/
function scm_acf_fields_video( $name = '' ) {

	$name = ( $name ? $name . '-' : '');

	$fields = array();
	$hastaxes = checkTaxes( 'video' );

	$fields = apply_filters( 'scm_filter_fields_video_before', $fields );

	if( $hastaxes )
		$fields[] = scm_acf_field_tab_left( $name . 'tab-set-video', array('label'=>__( 'Impostazioni', SCM_THEME ) ) );
		
		$fields[] = scm_acf_field( $name . 'video-url', 'video', __( 'Link YouTube o Facebook', SCM_THEME ) );
		$fields[] = scm_acf_field_image( $name . 'video-image', array( 'label'=> __( 'Immagine d\'anteprima (da utilizzare per link diversi da YouTube o Facebook)', SCM_THEME ) ) );

	if( $hastaxes ){
		$fields[] = scm_acf_field_tab_left( $name . 'tab-tax-video', array('label'=>__( 'Categorie', SCM_THEME ) ) );
			$fields = array_merge( $fields, scm_acf_preset_categories( $name . 'video', 'video' ) );
			$fields = array_merge( $fields, scm_acf_preset_tags( $name . 'video', 'video' ) );
	}

	$fields = apply_filters( 'scm_filter_fields_video', $fields );

	return $fields;
}

/**
* [GET] Fields LUOGHI CATEGORY
*
* @param {string} name
* @return {array} Fields.
*/
function scm_acf_fields_luoghi_tip( $name = '' ) {
	$name = ( $name ? $name . '-' : '');

	$fields = array();
	$fields = apply_filters( 'scm_filter_fields_luoghi_tip_before', $fields );
	$msg = __( 'Verrà utilizzata sulle mappe per indicare i <strong>Luoghi</strong> assegnati a questa <strong>Categoria</strong>. Comparirà anche nella legenda, se sulla mappa sono presenti più <strong>Luoghi</strong>.
    Selezionando l\'opzione <em>Default</em> dal menu a tendina <strong>Icona Mappa</strong>, verrà utilizzata un\'icona standard. Viene sostituita nei <strong>Luoghi</strong> ai quali è stata assegnata un\'icona specifica.', SCM_THEME );
	$fields = array_merge( $fields, scm_acf_preset_map_icon( 'luogo-tip', 100, 0, 0, $msg ) );
	$fields = apply_filters( 'scm_filter_fields_luoghi_tip', $fields );

	return $fields;
}

/**
* [GET] Fields LUOGHI
*
* @param {string} name
* @return {array} Fields.
*/
function scm_acf_fields_luoghi( $name = '' ) {

	$name = ( $name ? $name . '-' : '');

	$fields = array();
	$hastaxes = checkTaxes( 'luoghi' );

	$fields = apply_filters( 'scm_filter_fields_luogo_before', $fields );

	$fields[] = scm_acf_field_tab_left( $name . 'tab-set-luogo', array('label'=>__( 'Dati', SCM_THEME ) ) );
		
		//$fields[] = scm_acf_field_image_url( $name . 'luogo-logo', array('label'=> __( 'Logo (per fondi chiari)', SCM_THEME ) ), 50 );
		//$fields[] = scm_acf_field_image_url( $name . 'luogo-logo-neg', array('label'=> __( 'Logo (per fondi scuri)', SCM_THEME ) ), 50 );
		$fields[] = scm_acf_field_image( $name . 'luogo-logo', array('label'=> __( 'Logo (per fondi chiari)', SCM_THEME ) ), 50 );
		$fields[] = scm_acf_field_image( $name . 'luogo-logo-neg', array('label'=> __( 'Logo (per fondi scuri)', SCM_THEME ) ), 50 );

		$fields[] = scm_acf_field_text( $name . 'luogo-nome', array( 'prepend'=>__( 'Nome', SCM_THEME ), 'placeholder'=>__( 'es. Sede Operativa, Distaccamento, …', SCM_THEME ) ), 100 );

		$fields[] = scm_acf_field_text( $name . 'luogo-indirizzo', array( 'prepend'=>__( 'Indirizzo', SCM_THEME ) ), 50 );
		$fields[] = scm_acf_field_text( $name . 'luogo-frazione', array( 'prepend'=>__( 'Frazione', SCM_THEME ) ), 50 );
		$fields[] = scm_acf_field_text( $name . 'luogo-cap', array( 'prepend'=>__( 'CAP', SCM_THEME ) ), 20 );
		$fields[] = scm_acf_field_text( $name . 'luogo-citta', array( 'prepend'=>__( 'Comune', SCM_THEME ) ), 60 );
		$fields[] = scm_acf_field_text( $name . 'luogo-provincia', array( 'prepend'=>__( 'Provincia', SCM_THEME ) ), 20 );
		
		$fields[] = scm_acf_field_text( $name . 'luogo-regione', array( 'prepend'=>__( 'Regione', SCM_THEME ) ), 50 );
		$fields[] = scm_acf_field_text( $name . 'luogo-paese', array( 'prepend'=>__( 'Paese', SCM_THEME ) ), 50 );

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

/**
* [GET] Fields SOGGETTI
*
* @param {string} name
* @return {array} Fields.
*/
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

		//$fields[] = scm_acf_field_image_url( $name . 'soggetto-logo', array('label'=> __( 'Logo', SCM_THEME )), 50 );
		//$fields[] = scm_acf_field_image_url( $name . 'soggetto-icona', array('label'=> __( 'Icona', SCM_THEME )), 50 );
		$fields[] = scm_acf_field_image( $name . 'soggetto-logo', array('label'=> __( 'Logo', SCM_THEME )), 50 );
		$fields[] = scm_acf_field_image( $name . 'soggetto-icona', array('label'=> __( 'Icona', SCM_THEME )), 50 );
		
		$fields[] = scm_acf_field( $name . 'msg-soggetto-neg', array(
			'message',
			__( 'Carica uno logo e/o un\'icona da utilizzare su fondi scuri.', SCM_THEME ),
		), __( 'Versione in Negativo', SCM_THEME ), 100 );
		
		//$fields[] = scm_acf_field_image_url( $name . 'soggetto-logo-neg', array('label'=> __( 'Logo', SCM_THEME )), 50 );
		//$fields[] = scm_acf_field_image_url( $name . 'soggetto-icona-neg', array('label'=> __( 'Icona', SCM_THEME )), 50 );
		$fields[] = scm_acf_field_image( $name . 'soggetto-logo-neg', array('label'=> __( 'Logo', SCM_THEME )), 50 );
		$fields[] = scm_acf_field_image( $name . 'soggetto-icona-neg', array('label'=> __( 'Icona', SCM_THEME )), 50 );

	$fields[] = scm_acf_field_tab_left( $name . 'tab-soggetto-dati', array('label'=> __( 'Dati', SCM_THEME ) ) );
		$fields[] = scm_acf_field_link( $name . 'soggetto-link' );
		$fields[] = scm_acf_field_text( $name . 'soggetto-intestazione', array( 'placeholder'=>__('intestazione',SCM_THEME), 'prepend'=>__( 'Intestazione', SCM_THEME ) ), 100 );
		$fields[] = scm_acf_field_text( $name . 'soggetto-piva', array( 'placeholder'=>'0123456789101112', 'prepend'=>__( 'P.IVA', SCM_THEME ) ), 50 );
		$fields[] = scm_acf_field_text( $name . 'soggetto-cf', array( 'placeholder'=>'AAABBB123', 'prepend'=>__( 'C.F.', SCM_THEME ) ), 50 );

	if( post_type_exists('luoghi') ){
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
	}

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
	
?>