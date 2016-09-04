<?php

/**
 * ACF all available Custom Fields Layouts.
 *
 * @link http://www.studiocreativo-m.it
 *
 * @package SCM
 * @subpackage 2-ACF/Fields/LAYOUT
 * @since 1.0.0
 */

// ------------------------------------------------------
// Groups
//		TEMPLATES (list)
//		TEMPLATE (single)
//
// Layouts
//		Galleria
//		Soggetto + layout
//		Luogo + layout
//		Rassegna + layout
//		Documento + layout
//		Video + layout
//
// ------------------------------------------------------

// ------------------------------------------------------
// GROUPS
// ------------------------------------------------------

/**
* [GET] Fields TEMPLATES (list)
*
* @param {string} name
* @param {array} logic
* @param {string} instructions
* @param {bool} required
* @param {string} class
* @return {array} Fields.
*/
function scm_acf_fields_templates( $name = '', $logic = 0, $instructions = '', $required = 0, $class = 'posts-repeater' ) {

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

/**
* [GET] Fields TEMPLATE (single)
*
* @param {string} type
* @param {misc} default
* @return {array} Fields.
*/
function scm_acf_fields_template( $type = '', $default = 0 ) {

	$fields = array();

	$slug = str_replace( '_', '-', $type);

	$fields[] = scm_acf_field_select( 'link', 'template_link-no', 34, 0, 0, multiText( array( 'Seleziona', 'Link' ) ) );

	$fields[] = scm_acf_field_object( 'template', array( 
        'type'=>'id-null', 
        'types'=>$slug . SCM_TEMPLATE_APP,
        'label'=>multiText( array( 'Seleziona', 'Modello' ) ),
    ), 33 );

	$fields[] = scm_acf_field_link( 'url', 0, 33, 0, 0, multiText( array( 'Inserisci', 'Link' ) ) );

	// SCM Filter: Passing Fields - Receiving Fields
	//$fields = apply_filters( 'scm_filter_element_before_' . $type, $fields );
	//$fields = apply_filters( 'scm_filter_element_before', $fields, $slug );

	// SCM Filter: Passing Fields - Receiving Fields
	//$fields = apply_filters( 'scm_filter_element_' . $type, $fields );
	//$fields = apply_filters( 'scm_filter_element', $fields, $slug );

	$flexible = scm_acf_field_flexible( 'modules', array( 
		'label'=>multiText( 'Componi' ),
		'button'=>'+',
	) );

		// TITLE
		$layout_name = scm_acf_layout( 'titolo', 'block', __( 'Titolo', SCM_THEME ) );

			$layout_name['sub_fields'] = scm_acf_object_titolo( $default, 1 );

	// SCM Filter: Passing Title Fields and Type - Receiving Title Fields
		//$layout_name = apply_filters( 'scm_filter_layout_title_' . $type, $layout_name );
		//$layout_name = apply_filters( 'scm_filter_layout_title', $layout_name, $slug );

		// DATE
		$layout_date = scm_acf_layout( 'data', 'block', __( 'Data', SCM_THEME ), '', 1 );

	// SCM Filter: Passing Date Fields and Type - Receiving Date Fields
			//$layout_date = apply_filters( 'scm_filter_layout_date_' . $type, $layout_date );
			//$layout_date = apply_filters( 'scm_filter_layout_date', $layout_date, $slug );

			// +++ todo: va bene tag, ma devi almeno aggiungere le fields: flexible date ( day/month/year/week/hour => format )
			$layout_date['sub_fields'][] = scm_acf_field( 'prepend', array( 'text', '', ( $default ? 'default' : '' ), __( 'Inizio', SCM_THEME ) ), __( 'Inizio', SCM_THEME ), 50 );
            $layout_date['sub_fields'][] = scm_acf_field( 'append', array( 'text', '', ( $default ? 'default' : '' ), __( 'Fine', SCM_THEME ) ), __( 'Fine', SCM_THEME ), 50 );
            $layout_date['sub_fields'] = array_merge( $layout_date['sub_fields'], scm_acf_object_data( '', 1 ) );			

		$layout_taxes = array();
		$taxes = get_object_taxonomies( $slug, 'objects' );
		reset( $taxes );
		
		foreach ($taxes as $key => $value) {
			if( $key != 'language' && $key != 'post_translations' ){
				$layout_tax = scm_acf_layout( 'SCMTAX-' . $value->name, 'block', $value->label, '', 1 );

					$layout_tax['sub_fields'][] = scm_acf_field( 'prepend', array( 'text', $value->label . ': ', ( $default ? 'default' : '' ), __( 'Inizio', SCM_THEME ) ), __( 'Inizio', SCM_THEME ), 25 );
					$layout_tax['sub_fields'][] = scm_acf_field_select( 'tag', array( 
						'type'=>'headings_low',
						'default'=>'span',
					), 25 );
					$layout_tax['sub_fields'][] = scm_acf_field( 'separator', array( 'text', ', ', ( $default ? 'default' : '' ), __( 'Separatore', SCM_THEME ) ), __( 'Separatore', SCM_THEME ), 25 );
					$layout_tax['sub_fields'][] = scm_acf_field( 'append', array( 'text', '.', ( $default ? 'default' : '' ), __( 'Fine', SCM_THEME ) ), __( 'Fine', SCM_THEME ), 25 );

// SCM Filter: Passing Tax Fields and Type - Receiving Tax Fields
					$layout_tax = apply_filters( 'scm_filter_layout_tax_' . $type, $layout_tax, $value->name ); // Perché era commentato?
					$layout_taxes[] = apply_filters( 'scm_filter_layout_tax', $layout_tax, $value->name, $slug ); // Se lo commenti ricorda di inserire $layout_taxes[ $layout_tax ]
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

	// SCM Filter: Passing Layouts and Type - Receiving Layouts ( Before Column Width and Column Link )
			$flexible['layouts'] = apply_filters( 'scm_filter_layout_' . $type, array_merge( array( $layout_name, $layout_date ), $layout_taxes, $layout_empty ) );
			$flexible['layouts'] = apply_filters( 'scm_filter_layout', $flexible['layouts'], $layout_taxes, $slug );

		// layout fields

		if( function_exists( 'scm_acf_layout_' . $type ) )
			$flexible['layouts'] = call_user_func( 'scm_acf_layout_' . $type, $flexible['layouts'] );

		$flexible['layouts'] = scm_acf_layouts_advanced_options( $flexible['layouts'], 'complete' );

	// SCM Filter: Passing Layouts and Type - Receiving Layouts ( After Column Width and Column Link )
			$flexible['layouts'] = apply_filters( 'scm_filter_layout_after_' . $type, $flexible['layouts'] );
			$flexible['layouts'] = apply_filters( 'scm_filter_layout_after', $flexible['layouts'], $slug );

	$fields[] = $flexible;

	return $fields;
}

// ------------------------------------------------------
// LAYOUTS
// ------------------------------------------------------

/**
* [GET] Layout gallerie
*
* @param {array} layouts
* @param {misc} default
* @return {array} Layouts
*/
function scm_acf_layout_gallerie( $layouts = array(), $default = 0 ) {

		$layout_thumb = scm_acf_layout( 'thumbs', 'block', multiText( 'Galleria' ) );
			
			$layout_thumb['sub_fields'][] = scm_acf_field_tab( 'tab-thumb', array('label'=> __( 'Thumb', SCM_THEME ) ) );
				$layout_thumb['sub_fields'][] = scm_acf_field_option( 'thumb', array( 'default'=>0, 'prepend'=>__( 'Thumb', SCM_THEME ) ) );
				$layout_thumb['sub_fields'] = array_merge( $layout_thumb['sub_fields'], scm_acf_preset_size( 'width', '', '150', 'px', __( 'Larghezza', SCM_THEME ) ) );
				$layout_thumb['sub_fields'] = array_merge( $layout_thumb['sub_fields'], scm_acf_preset_size( 'height', '', '120', 'px', __( 'Altezza', SCM_THEME ) ) );

			$layout_thumb['sub_fields'][] = scm_acf_field_tab( 'tab-nav', array('label'=> __( 'Navigation', SCM_THEME ) ) );
				$layout_thumb['sub_fields'][] = scm_acf_field_false( 'arrows', 0, 33, 0, 0, __('Arrows', SCM_THEME) );
				$layout_thumb['sub_fields'][] = scm_acf_field_false( 'miniarrows', 0, 33, 0, 0, __('Always Mini', SCM_THEME) );

			$layout_thumb['sub_fields'][] = scm_acf_field_tab( 'tab-elems', array('label'=> __( 'Elements', SCM_THEME ) ) );
				$layout_thumb['sub_fields'][] = scm_acf_field_false( 'counter', 0, 33, 0, 0, __('Counter', SCM_THEME) );
				$layout_thumb['sub_fields'][] = scm_acf_field_false( 'name', 0, 33, 0, 0, __('Title', SCM_THEME) );
				$layout_thumb['sub_fields'][] = scm_acf_field_false( 'list', 0, 34, 0, 0, __('List', SCM_THEME) );

				$layout_thumb['sub_fields'][] = scm_acf_field_false( 'info', 0, 50, 0, 0, __('Info', SCM_THEME) );
				$layout_thumb['sub_fields'][] = scm_acf_field_false( 'color', 0, 50, 0, 0, __('Color', SCM_THEME) );

			$layout_thumb['sub_fields'][] = scm_acf_field_tab( 'tab-data', array('label'=> __( 'Images Data', SCM_THEME ) ) );
				$layout_thumb['sub_fields'][] = scm_acf_field_select( 'data', array( 'choices'=>array('float'=>'Float','over'=>'Over','inside'=>'Inside (not implemented)','outside'=>'Outside (not implemented)') ), 50, 0, 0, __('Data Position', SCM_THEME) );
				$layout_thumb['sub_fields'][] = scm_acf_field_false( 'reverse', 0, 50, 0, 0, __('Reverse', SCM_THEME) );

				$layout_thumb['sub_fields'][] = scm_acf_field_false( 'titles', 0, 25, 0, 0, __('Titles', SCM_THEME) );
				$layout_thumb['sub_fields'][] = scm_acf_field_false( 'captions', 0, 25, 0, 0, __('Captions', SCM_THEME) );
				$layout_thumb['sub_fields'][] = scm_acf_field_false( 'alternatives', 0, 25, 0, 0, __('Alternatives', SCM_THEME) );
				$layout_thumb['sub_fields'][] = scm_acf_field_false( 'descriptions', 0, 25, 0, 0, __('Descriptions', SCM_THEME) );

				$layout_thumb['sub_fields'][] = scm_acf_field_false( 'dates', 0, 25, 0, 0, __('Dates', SCM_THEME) );
				$layout_thumb['sub_fields'][] = scm_acf_field_false( 'modifies', 0, 25, 0, 0, __('Modifies', SCM_THEME) );
				$layout_thumb['sub_fields'][] = scm_acf_field_false( 'filenames', 0, 25, 0, 0, __('Filenames', SCM_THEME) );
				$layout_thumb['sub_fields'][] = scm_acf_field_false( 'types', 0, 25, 0, 0, __('Mime Types', SCM_THEME) );

		$layouts[] = $layout_thumb;

	return $layouts;
}

/**
* [GET] Layout soggetti
*
* @param {array} layouts
* @param {misc} default
* @return {array} Layouts
*/
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

	$layout_social = scm_acf_layout( 'social_follow', 'block', __( 'Social Link', SCM_THEME ), '', 1 );
		$layout_social['sub_fields'] = scm_acf_object_social_follow( $default, 1 );			
			
	$layouts = array_merge( $layouts, array( $layout_logo, $layout_icon, $layout_int, $layout_c, $layout_piva, $layout_cf, $layout_map, $layout_address, $layout_social ) );

	return $layouts;
}

/**
* [GET] Layout luoghi
*
* @param {array} layouts
* @param {misc} default
* @return {array} Layouts
*/
function scm_acf_layout_luoghi( $layouts = array(), $default = 0 ) {

	$layout_logo = scm_acf_layout( 'logo', 'block', __( 'Logo', SCM_THEME ) );
		$layout_logo['sub_fields'] = array_merge( $layout_logo['sub_fields'], scm_acf_preset_size( 'width', '', 'auto', '%', __( 'Larghezza', SCM_THEME ) ) );
		$layout_logo['sub_fields'] = array_merge( $layout_logo['sub_fields'], scm_acf_preset_size( 'height', '', 'auto', '%', __( 'Altezza', SCM_THEME ) ) );
		$layout_logo['sub_fields'][] = scm_acf_field_select( 'negative', 'positive_negative', 100, 0, 0, __( 'Scegli una versione', SCM_THEME ) );

	$layout_map = scm_acf_layout( 'map', 'block', __( 'Mappa', SCM_THEME ), '', 1 );
		$layout_map['sub_fields'] = scm_acf_object_map( $default, 1 );

	$layout_data = scm_acf_layout( 'contatti', 'block', __( 'Contatti', SCM_THEME ) );
		$layout_data['sub_fields'] = scm_acf_object_contatti( $default, 1 );		
		
	$layout_address = scm_acf_layout( 'indirizzo', 'block', __( 'Indirizzo', SCM_THEME ) );
		$layout_address['sub_fields'] = scm_acf_object_indirizzo( $default, 1 );

	$layouts = array_merge( $layouts, array( $layout_logo, $layout_map, $layout_address, $layout_data ) );

	return $layouts;
}

/**
* [GET] Layout articoli
*
* @param {array} layouts
* @return {array} Layouts
*/
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

/**
* [GET] Layout news
*
* @param {array} layouts
* @param {misc} default
* @return {array} Layouts
*/
function scm_acf_layout_eventi( $layouts = array(), $default = 0 ) {

	$layout_img = scm_acf_layout( 'immagine', 'block', __( 'Immagine', SCM_THEME ) );
	$layout_mod = scm_acf_layout( 'modules', 'block', __( 'Contenuto', SCM_THEME ) );
	$layout_dat = scm_acf_layout( 'dates', 'block', __( 'Date Evento', SCM_THEME ) );
	$layout_map = scm_acf_layout( 'map', 'block', __( 'Mappa', SCM_THEME ), '', 1 );
		$layout_map['sub_fields'] = scm_acf_object_map( $default, 1 );
	$layout_address = scm_acf_layout( 'indirizzo', 'block', __( 'Indirizzo', SCM_THEME ) );
		$layout_address['sub_fields'] = scm_acf_object_indirizzo( $default, 1 );
	$layouts = array_merge( $layouts, array( $layout_img, $layout_mod, $layout_dat, $layout_map, $layout_address ) );

	return $layouts;
}

/**
* [GET] Layout news
*
* @param {array} layouts
* @param {misc} default
* @return {array} Layouts
*/
function scm_acf_layout_news( $layouts = array(), $default = 0 ) {

	$layout_img = scm_acf_layout( 'immagine', 'block', __( 'Immagine', SCM_THEME ) );
	$layout_mod = scm_acf_layout( 'modules', 'block', __( 'Contenuto', SCM_THEME ) );
	$layouts = array_merge( $layouts, array( $layout_img, $layout_mod ) );

	return $layouts;
}

/**
* [GET] Layout rassegne_stampa
*
* @param {array} layouts
* @param {misc} default
* @return {array} Layouts
*/
function scm_acf_layout_rassegne_stampa( $layouts = array(), $default = 0 ) {
	return $layouts;
}

/**
* [GET] Layout documenti
*
* @param {array} layouts
* @param {misc} default
* @return {array} Layouts
*/
function scm_acf_layout_documenti( $layouts = array(), $default = 0 ) {
	return $layouts;
}

/**
* [GET] Layout video
*
* @param {array} layouts
* @param {misc} default
* @return {array} Layouts
*/
function scm_acf_layout_video( $layouts = array(), $default = 0 ) {
	$layouts[] = scm_acf_layout( 'immagine', 'block', __( 'Thumb', SCM_THEME ) );
	return $layouts;
}

?>