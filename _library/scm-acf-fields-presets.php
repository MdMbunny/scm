<?php
/**
 * @package SCM
 */

// *****************************************************
// *	ACF FIELDS PRESETS
// *****************************************************

	// INSTRUCTIONS (GENERAL)
	if ( ! function_exists( 'scm_acf_preset_instructions' ) ) {
		function scm_acf_preset_instructions( $instructions = '', $name = 'instructions', $label = '', $width = 100, $logic = 0 ) {
			$fields = array();

			if( $instructions )
				$fields[] = scm_acf_field(
					array( 'name'=>$name . 'msg-open', 'width'=>$width, 'logic'=>$logic, 'label'=>( $label ?: __( 'Istruzioni', SCM_THEME ) ) ),
					array( 'type'=>'message', 'message'=>$instructions )
				);
	
			return $fields;
		}
	}

	// SELECTORS
	if ( ! function_exists( 'scm_acf_preset_selectors' ) ) {
		function scm_acf_preset_selectors( $name = '', $w1 = 100, $w2 = 100, $logic = 0, $req = 0, $instructions = '' ) {

			//$name = ( $name ? $name . '-selectors' : 'selectors');
			$name = ( $name ? $name . '-' : '');
			$fields = scm_acf_preset_instructions( $instructions, $name, __( 'Aggiungi Selettori', SCM_THEME ) );
			
			$fields[] = scm_acf_field_id( $name . 'id', 0, $w1, $logic, $req );
			$fields[] = scm_acf_field_class( $name . 'class', 0, $w2, $logic, $req );

			return $fields;
		}
	}

	// SIZE
	if ( ! function_exists( 'scm_acf_preset_size' ) ) {
		function scm_acf_preset_size( $name = 'size', $default = '', $pl1 = 'auto', $pl2 = 'px', $lb1 = '', $width = 100, $logic = 0, $req = 0, $instructions = '' ) {
			$lb1 = ( $lb1 ?: __( 'Dimensione', SCM_THEME ) );

			$name = ( $name ? $name . '-' : '');
			$fields = scm_acf_preset_instructions( $instructions, ( $name ?: 'size' ), __( 'Impostazioni Dimensioni', SCM_THEME ) );

			$fields[] = scm_acf_field_positive( $name . 'number', array( 'default'=>$default, 'placeholder'=>$pl1, 'prepend'=>$lb1 ), $width*.5, $logic, $req );
			$fields[] = scm_acf_field_select_units( $name . 'units', '', $width*.5, $logic, $pl2, '', '', $req );

			return $fields;
		}
	}
	
	// COLOR
	if ( ! function_exists( 'scm_acf_preset_rgba' ) ) {
		function scm_acf_preset_rgba( $name = '', $pl1 = '', $pl2 = 1, $width = 100, $logic = 0, $lb2 = '', $lb1 = '', $req = 0, $instructions = '' ) {
			$lb2 = ( $lb2 ?: __( 'Trasparenza', SCM_THEME ) );
			$lb1 = ( $lb1 ?: __( 'Colore', SCM_THEME ) );

			$name = ( $name ? $name . '-rgba' : 'rgba');
			$fields = scm_acf_preset_instructions( $instructions, $name, __( 'Imposta RGBA', SCM_THEME ) );	

			$fields[] = scm_acf_field_color( $name . '-color', array( 'default'=>$pl1, 'label'=>$lb1 ), $width*.5, $logic, $req );
			$fields[] = scm_acf_field_alpha( $name . '-alpha', array( 'default'=>$pl2, 'label'=>$lb2 ), $width*.5, $logic, $req );

			return $fields;
		}
	}

	// BACKGROUND STYLE
	if ( ! function_exists( 'scm_acf_preset_background_style' ) ) {
		function scm_acf_preset_background_style( $name = '', $width = 100, $logic = 0, $pl1 = '', $pl2 = 'center center', $pl3 = 'auto auto', $req = 0, $instructions = '' ) {

			$default = 0; // todo: da rimuovere
			
			$name = ( $name ? $name . '-style-bg' : 'style-bg');
			$fields = scm_acf_preset_instructions( $instructions, $name, __( 'Impostazioni Sfondo', SCM_THEME ) );
			

			$fields = array_merge( $fields, scm_acf_preset_rgba( $name, '', 1, $logic, $width ) );
			$fields[] = scm_acf_field_image( $name . '-image', $default, $width, $logic, __( 'Immagine', SCM_THEME ) );
			$fields[] = scm_acf_field_select1( $name . '-repeat', $default, 'bg_repeat', $width, $logic, $pl1, __( 'Ripetizione', SCM_THEME ) );
			$fields[] = scm_acf_field_text( $name . '-position', array( 'default'=>$pl2, 'prepend'=>__( 'Posizione', SCM_THEME ) ), $width, $logic, $req );
			$fields[] = scm_acf_field_text( $name . '-size', array( 'default'=>$pl3, 'prepend'=>__( 'Dimensione', SCM_THEME ) ), $width, $logic, $req );

			return $fields;
		}
	}

	// TEXT FONT
	if ( ! function_exists( 'scm_acf_preset_text_font' ) ) {
		function scm_acf_preset_text_font( $name = '', $logic = 0, $width = 100, $req = 0, $instructions = '' ) {

			$default = 0; // todo: da rimuovere
			
			$name = ( $name ? $name . '-webfonts' : 'webfonts');
			$fields = scm_acf_preset_instructions( $instructions, $name, __( 'Impostazioni Font', SCM_THEME ) );

			$fields[] = scm_acf_field_select1( $name . '-adobe', $default, 'webfonts_adobe', $width*.33, $logic, '', 'Adobe TypeKit' );
			$fields[] = scm_acf_field_select1( $name . '-google', $default, 'webfonts_google', $width*.33, $logic, '', 'Google Font' );
			$fields[] = scm_acf_field_select1( $name . '-fallback', $default, 'webfonts_fallback', $width*.33, $logic, '', __( 'Famiglia', SCM_THEME ) );

			return $fields;
		}
	}
	
	// TEXT SET
	if ( ! function_exists( 'scm_acf_preset_text_set' ) ) {
		function scm_acf_preset_text_set( $name = '', $w1 = 100, $w2 = 100, $w3 = 100, $w4 = 100, $logic = 0, $req = 0, $instructions = '' ) {

			$default = 0; // todo: da rimuovere
			
			$name = ( $name ? $name . '-set' : 'set');
			$fields = scm_acf_preset_instructions( $instructions, $name, __( 'Impostazioni Font', SCM_THEME ) );

			$fields[] = scm_acf_field_select1( $name . '-alignment', $default, 'txt_alignment', $w1, $logic, '', __( 'Allineamento', SCM_THEME ) );
			$fields[] = scm_acf_field_select1( $name . '-weight', $default, 'font_weight', $w2, $logic, '', __( 'Spessore', SCM_THEME ) );
			$fields[] = scm_acf_field_select1( $name . '-size', $default, 'txt_size', $w3, $logic, '', __( 'Dimensione', SCM_THEME ) );
			$fields[] = scm_acf_field_select1( $name . '-line-height', $default, 'line_height', $w4, $logic, '', __( 'Interlinea', SCM_THEME ) );

			return $fields;
		}
	}

	// TEXT SHADOW - [ V ]
	if ( ! function_exists( 'scm_acf_preset_text_shadow' ) ) {
		function scm_acf_preset_text_shadow( $name = '', $logic = 0, $req = 0, $instructions = '' ) {

			$name = ( $name ? $name . '-shadow' : 'shadow');
			$fields = scm_acf_preset_instructions( $instructions, $name, __( 'Impostazioni Ombra Testi', SCM_THEME ) );

			$fields = array_merge( $fields, scm_acf_preset_size( $name . '-x', 1, '1', 'px', 'X', 33, $logic, $req ) );
			$fields = array_merge( $fields, scm_acf_preset_size( $name . '-y', 1, '1', 'px', 'Y', 33, $logic, $req ) );
			$fields = array_merge( $fields, scm_acf_preset_size( $name . '-size', 1, '1', 'px', __( 'Dimensione', SCM_THEME ), 33, $logic, $req ) );
			$fields = array_merge( $fields, scm_acf_preset_rgba( $name, '#000000', .5, 100, $logic, $req ) );

			return $fields;
		}
	}

	// TEXT STYLE
	if ( ! function_exists( 'scm_acf_preset_text_style' ) ) {
		function scm_acf_preset_text_style( $name = '', $logic = 0, $req = 0, $instructions = '' ) {

			$default = 0; // todo: da rimuovere

			$name = ( $name ? $name . '-style-txt' : 'style-txt');
			$fields = scm_acf_preset_instructions( $instructions, $name, __( 'Impostazioni Stile Testi', SCM_THEME ) );

			$fields = array_merge( $fields, scm_acf_preset_rgba( $name ) );
			$fields = array_merge( $fields, scm_acf_preset_text_font( $name ) );
			$fields = array_merge( $fields, scm_acf_preset_text_set( $name ) );

			// conditional ombra
			$fields[] = scm_acf_field_select_disable( $name . '-shadow', $default, __( 'Ombra', SCM_THEME ) );
			$condition = array(
				'field' => $name . 'shadow',
				'operator' => '==',
				'value' => 'on',
			);
				
				$fields = array_merge( $fields, scm_acf_preset_text_shadow( $name, $condition ) );

			return $fields;
		}
	}

	// BOX SHAPE
	if ( ! function_exists( 'scm_acf_preset_box_shape' ) ) {
		function scm_acf_preset_box_shape( $name = '', $width = 100, $logic = 0, $req = 0, $instructions = '' ) {

			$default = 0; // todo: da rimuovere

			$name = ( $name ? $name . '-shape' : 'shape');
			$fields = scm_acf_preset_instructions( $instructions, $name, __( 'Impostazioni Box', SCM_THEME ) );

			$fields[] = scm_acf_field_select1( $name, $default, 'box_shape-no', $width, $logic, __( 'Forma', SCM_THEME ), __( 'Forma Box', SCM_THEME ) );
				
				$shape = array( $logic, array( 'field' => $name, 'operator' => '!=', 'value' => 'no' ) );
				$rounded = scm_acf_group_condition( $logic, $shape, array( 'field' => $name, 'operator' => '!=', 'value' => 'square' ) );

					$fields[] = scm_acf_field_select1( $name . '-angle', $default, 'box_angle_type', $width * .5, $rounded, __( 'Angoli', SCM_THEME ), __( 'Angoli Box', SCM_THEME ) );
					$fields[] = scm_acf_field_select1( $name . '-size', $default, 'simple_size', $width * .5, $rounded, __( 'Dimensione', SCM_THEME ), __( 'Dimensione angoli Box', SCM_THEME ) );
			
			return $fields;

		}
	}

	// BOX STYLE - [ V ]
	if ( ! function_exists( 'scm_acf_preset_box_style' ) ) {
		function scm_acf_preset_box_style( $name = '', $width = 100, $logic = 0, $req = 0, $instructions = '' ) {

			$name = ( $name ? $name . '-style-box' : 'style-box');
			$fields = scm_acf_preset_instructions( $instructions, $name, __( 'Impostazioni Box', SCM_THEME ) );

			$fields[] = scm_acf_field_text( $name . '-margin', array( 'placeholder'=>'0 0 0 0', 'prepend'=>__( 'Margin', SCM_THEME ) ), $width, $logic, $req );
			$fields[] = scm_acf_field_text( $name . '-padding', array( 'placeholder'=>'0 0 0 0', 'prepend'=>__( 'Padding', SCM_THEME ) ), $width, $logic, $req );
			$fields[] = scm_acf_field_alpha( $name . '-alpha', array( 'default'=>1, 'prepend'=>__( 'Trasparenza', SCM_THEME ) ), $width, $logic );
			$fields = array_merge( $fields, scm_acf_preset_box_shape( $name ) );

			return $fields;

		}
	}
	
	// MAP ICON
	if ( ! function_exists( 'scm_acf_preset_map_icon' ) ) {
		function scm_acf_preset_map_icon( $name = '', $width = 100, $logic = 0, $req = 0, $instructions = '' ) {

			$default = 0; // todo: da rimuovere
			
			$name = ( $name ? $name . '-map' : 'map');
			$fields = scm_acf_preset_instructions( $instructions, $name, __( 'Impostazioni Icona Mappa', SCM_THEME ) );

			$fields[] = scm_acf_field_select1( $name . '-icon', $default, 'luogo-mappa', $width, $logic, array( 'no' => __( 'No icon', SCM_THEME ), 'icon' => __( 'Icona', SCM_THEME ), 'img' => __( 'Immagine', SCM_THEME ) ) );

			$icon = array( 'field' => $name . '-icon', 'operator' => '==', 'value' => 'icon' );
			$icon = ( $logic ? scm_acf_group_condition( $icon, $logic ) : $icon );
			$img = array( 'field' => $name . '-icon', 'operator' => '==', 'value' => 'img' );
			$img = ( $logic ? scm_acf_group_condition( $img, $logic ) : $img );
				
				$fields[] = scm_acf_field_icon( $name . '-icon-fa', $default, 'map-marker', '', '', $icon );
				$fields = array_merge( $fields, scm_acf_preset_rgba( $name, '#e3695f', 1, 100, $icon ) );
				$fields[] = scm_acf_field_image( $name . '-icon-img', $default, '', $img, __( 'Carica un\'immagine', SCM_THEME ) );

			return $fields;

		}
	}

// ************* DA QUI

	// TERM
	if ( ! function_exists( 'scm_acf_preset_term' ) ) {
		function scm_acf_preset_term( $name = 'term', $default = 0, $tax = 'category', $placeholder = '', $logic = 0, $add = 0, $save = 0, $w1 = '', $lb1 = '', $instructions = '', $required = 0, $class = '' ) {
			$placeholder = ( $placeholder ?: __( 'Termine', SCM_THEME ) );
			$lb1 = ( $lb1 ?: __( 'Seleziona', SCM_THEME ) );
			
			$fields = array();

			if( $instructions )
				$fields[] = scm_acf_field( 'msg-open-' . $name, array( 'message', $instructions ), $placeholder );

			$name = ( $name ? $name . '-' : '');

			$fields[] = scm_acf_field_taxonomy( $name . 'terms', $default, $tax, $lb1 . ' ' . $placeholder, $add, $save, $w1, $logic, $instructions, $required );

			return $fields;
		}
	}

	// TERMS
	if ( ! function_exists( 'scm_acf_preset_terms' ) ) {
		function scm_acf_preset_terms( $name = 'terms', $default = 0, $tax = 'category', $placeholder = '', $logic = 0, $add = 0, $save = 0, $w1 = '', $lb1 = '', $instructions = '', $required = 0, $class = '' ) {
			$placeholder = ( $placeholder ?: __( 'Termini', SCM_THEME ) );
			$lb1 = ( $lb1 ?: __( 'Seleziona', SCM_THEME ) );
			
			$fields = array();

			if( $instructions )
				$fields[] = scm_acf_field( 'msg-open-' . $name, array( 'message', $instructions ), $placeholder );

			$name = ( $name ? $name . '-' : '');

			$fields[] = scm_acf_field_taxonomies( $name . 'terms', $default, $tax, $lb1 . ' ' . $placeholder, $add, $save, $w1, $logic, $instructions, $required );

			return $fields;
		}
	}

	// TAXONOMY
	if ( ! function_exists( 'scm_acf_preset_taxonomy' ) ) {
		function scm_acf_preset_taxonomy( $name = 'taxonomy', $default = 0, $type = 'post', $logic = 0, $add = 0, $save = 0, $w1 = '', $lb1 = '', $instructions = '', $placeholder = '', $required = 0, $class = '' ) {
			$placeholder = ( $placeholder ?: __( 'Seleziona Relazione', SCM_THEME ) );
			$lb1 = ( $lb1 ?: __( 'Seleziona', SCM_THEME ) );

			$fields = array();

			if( $instructions )
				$fields[] = scm_acf_field( 'msg-open-' . $name, array( 'message', $instructions ), $placeholder );

			$name = ( $name ? $name . '-' : '');

			$taxes = get_object_taxonomies( $type, 'objects' );
			reset( $taxes );
			foreach ($taxes as $key => $value) {
				if( $key != 'language' && $key != 'post_translations' )
					$fields = array_merge( $fields, scm_acf_preset_term( $name . $value->name, $default, $value->name, $value->labels->singular_name, $logic, $add, $save, $w1, $lb1, '', $required, $class ) );
			}

			return $fields;
		}
	}

	// TAXONOMIES
	if ( ! function_exists( 'scm_acf_preset_taxonomies' ) ) {
		function scm_acf_preset_taxonomies( $name = 'taxonomies', $default = 0, $type = 'post', $logic = 0, $add = 0, $save = 0, $w1 = '', $lb1 = '', $instructions = '', $placeholder = '', $required = 0, $class = '' ) {
			$placeholder = ( $placeholder ?: __( 'Seleziona Relazioni', SCM_THEME ) );
			$lb1 = ( $lb1 ?: __( 'Seleziona', SCM_THEME ) );

			$fields = array();

			if( $instructions )
				$fields[] = scm_acf_field( 'msg-open-' . $name, array( 'message', $instructions ), $placeholder );

			$taxes = get_object_taxonomies( $type, 'objects' );

			$name = ( $name ? $name . '-' : '');

			reset( $taxes );

			foreach ($taxes as $key => $value) {
				if( $key != 'language' && $key != 'post_translations' )
					$fields = array_merge( $fields, scm_acf_preset_terms( $name . $value->name, $default, $value->name, $value->label, $logic, $add, $save, $w1, $lb1, '', $required, $class ) );
			}

			return $fields;
		}
	}

	// CATEGORY REQUIRED
	if ( ! function_exists( 'scm_acf_preset_category_req' ) ) {
		function scm_acf_preset_category_req( $name = 'category', $default = 0, $type = 'post', $save = 1, $logic = 0, $w1 = 100, $lb1 = '', $instructions = '', $placeholder = '', $required = 1, $class = '' ) {		
			$placeholder = ( $placeholder ?: __( 'Seleziona Tipologia', SCM_THEME ) );
			$lb1 = ( $lb1 ?: __( 'Seleziona', SCM_THEME ) );

			$fields = array();

			if( $instructions )
				$fields[] = scm_acf_field( 'msg-open-' . $name, array( 'message', $instructions ), $placeholder );

			$name = ( $name ? $name . '-' : '');

			$taxes = get_object_taxonomies( $type, 'objects' );
			reset( $taxes );
			foreach ($taxes as $key => $value) {
				if( $value->hierarchical && $key != 'language' && $key != 'post_translations' )
					$fields = array_merge( $fields, scm_acf_preset_term( $name . $value->name, $default, $value->name, $value->labels->singular_name, $logic, 0, $save, $w1, $lb1, '', $required, $class ) );
			}

			return $fields;
		}
	}

	// CATEGORY
	if ( ! function_exists( 'scm_acf_preset_category' ) ) {
		function scm_acf_preset_category( $name = 'category', $default = 0, $type = 'post', $save = 1, $logic = 0, $w1 = 100, $lb1 = '', $instructions = '', $placeholder = '', $required = 0, $class = '' ) {		
			$placeholder = ( $placeholder ?: __( 'Seleziona Tipologia', SCM_THEME ) );
			$lb1 = ( $lb1 ?: __( 'Seleziona', SCM_THEME ) );

			$fields = array();

			if( $instructions )
				$fields[] = scm_acf_field( 'msg-open-' . $name, array( 'message', $instructions ), $placeholder );

			$name = ( $name ? $name . '-' : '');

			$taxes = get_object_taxonomies( $type, 'objects' );
			reset( $taxes );
			foreach ($taxes as $key => $value) {
				if( $value->hierarchical && $key != 'language' && $key != 'post_translations' )
					$fields = array_merge( $fields, scm_acf_preset_term( $name . $value->name, $default, $value->name, $value->labels->singular_name, $logic, 0, $save, $w1, $lb1, '', $required, $class ) );
			}

			return $fields;
		}
	}

	// CATEGORIES
	if ( ! function_exists( 'scm_acf_preset_categories' ) ) {
		function scm_acf_preset_categories( $name = 'categories', $default = 0, $type = 'post', $save = 1, $logic = 0, $w1 = 100, $lb1 = '', $instructions = '', $placeholder = '', $required = 0, $class = '' ) {
			$placeholder = ( $placeholder ?: __( 'Seleziona Tipologie', SCM_THEME ) );
			$lb1 = ( $lb1 ?: __( 'Seleziona', SCM_THEME ) );

			$fields = array();

			if( $instructions )
				$fields[] = scm_acf_field( 'msg-open-' . $name, array( 'message', $instructions ), $placeholder );

			$name = ( $name ? $name . '-' : '');

			$taxes = get_object_taxonomies( $type, 'objects' );
			reset( $taxes );
			foreach ($taxes as $key => $value) {
				if( $value->hierarchical && $key != 'language' && $key != 'post_translations' )
					$fields = array_merge( $fields, scm_acf_preset_terms( $name . $value->name, $default, $value->name, $value->label, $logic, 0, $save, $w1, $lb1, '', $required, $class ) );
			}

			return $fields;
		}
	}

	// TAG
	if ( ! function_exists( 'scm_acf_preset_tag' ) ) {
		function scm_acf_preset_tag( $name = 'tag', $default = 0, $type = 'post_tag', $save = 1, $logic = 0, $w1 = '', $lb1 = '', $instructions = '', $placeholder = '', $required = 0, $class = '' ) {
			$placeholder = ( $placeholder ?: __( 'Seleziona Categoria', SCM_THEME ) );
			$lb1 = ( $lb1 ?: __( 'Seleziona', SCM_THEME ) );

			$fields = array();

			if( $instructions )
				$fields[] = scm_acf_field( 'msg-open-' . $name, array( 'message', $instructions ), $placeholder );

			$name = ( $name ? $name . '-' : '');

			$taxes = get_object_taxonomies( $type, 'objects' );
			reset( $taxes );
			foreach ($taxes as $key => $value) {
				if( !$value->hierarchical && $key != 'language' && $key != 'post_translations' )
					$fields = array_merge( $fields, scm_acf_preset_term( $name . $value->name, $default, $value->name, $value->labels->singular_name, $logic, 0, $save, $w1, $lb1, '', $required, $class ) );
			}

			return $fields;
		}
	}

	// TAGS
	if ( ! function_exists( 'scm_acf_preset_tags' ) ) {
		function scm_acf_preset_tags( $name = 'tags', $default = 0, $type = 'post_tag', $save = 1, $logic = 0, $w1 = '', $lb1 = '', $instructions = '', $placeholder = '', $required = 0, $class = '' ) {
			$placeholder = ( $placeholder ?: __( 'Seleziona Categorie', SCM_THEME ) );
			$lb1 = ( $lb1 ?: __( 'Seleziona', SCM_THEME ) );

			$fields = array();

			if( $instructions )
				$fields[] = scm_acf_field( 'msg-open-' . $name, array( 'message', $instructions ), $placeholder );
			
			$name = ( $name ? $name . '-' : '');

			$taxes = get_object_taxonomies( $type, 'objects' );
			reset( $taxes );
			foreach ($taxes as $key => $value) {
				if( !$value->hierarchical && $key != 'language' && $key != 'post_translations' )
					$fields = array_merge( $fields, scm_acf_preset_terms( $name . $value->name, $default, $value->name, $value->label, $logic, 1, $save, $w1, $lb1, '', $required, $class ) );
			}

			return $fields;
		}
	}

	// COLUMNS
	if ( ! function_exists( 'scm_acf_preset_repeater_columns' ) ) {
		function scm_acf_preset_repeater_columns( $name = '', $elements = '', $logic = 0, $req = 0, $instructions = '', $class = 'special-repeater' ) {

			$default = 0; //todo: da rimuovere

			$name = ( $name ? $name . '-columns' : 'columns');
			$fields = scm_acf_preset_instructions( $instructions,  $name, __( 'Impostazioni Colonne', SCM_THEME ) );
			
			$columns = scm_acf_field_repeater( $name, $default, __( 'Aggiungi Colonna', SCM_THEME ), '', 100, $logic, '', '', '', $req, $class );

				$columns['sub_fields'][] = scm_acf_field_select_column_width( 'column-width',  $default, 20, 0, '1/1' );
				$columns['sub_fields'] = array_merge( $columns['sub_fields'], scm_acf_preset_selectors( '', 10, 15 ) );
				$columns['sub_fields'][] = scm_acf_field( 'attributes', 'attributes', '', 45 );
				$columns['sub_fields'] = array_merge( $columns['sub_fields'], scm_acf_preset_flexible_elements( '', $elements ) );
				
			$fields[] = $columns;
			
			return $fields;
		}
	}

	// BUTTON
	if ( ! function_exists( 'scm_acf_preset_button' ) ) {
		function scm_acf_preset_button( $name = '', $type = 'link', $icon = '', $group = '', $options = 0, $label = '', $w = 100, $logic = 0, $req = 0 ) {
			
			$default = 0; //todo: da rimuovere
			
			$fields = array();
			$name = ( $name ? $name . '-' : '');

			$width = $w;

			if( $options >= -1 ){
				
				$fields[] = scm_acf_field_name( 'name', array( 'placeholder'=>( $label ?: __( 'senza nome', SCM_THEME ) ) ), 25 );
				
				if( $options >= 0 ){
					$fields[] = scm_acf_field_icon_no( $name . 'icon', $default, ( $icon ?: 'no' ), $group, 20 );
				}

				if( $options === 2 )
					$width = 35;
				else
					$width = 55;
			}



			switch ( $type ) {
				case 'link':
					$fields[] = scm_acf_field_link( $name . 'link', 0, $width, $logic, $req );
				break;

				case 'email':
					$fields[] = scm_acf_field_email( $name . 'link', 0, $width, $logic, $req );
				break;

				case 'phone':
					$fields[] = scm_acf_field_phone( $name . 'link', 0, $width, $logic, $req );
				break;

				case 'user':
					$fields[] = scm_acf_field_user( $name . 'link', 0, $width, $logic, $req );
				break;
				
				case 'file':
					$fields[] = scm_acf_field_file( $name . 'link', $default, $width, 0, __( 'File', SCM_THEME ) );
				break;

				case 'page':
					$fields[] = scm_acf_field_object_link( $name . 'link', $default, 'page', $width, 0, __( 'Pagina', SCM_THEME ) );
				break;
				
				case 'media':
					$fields[] = scm_acf_field_object( $name . 'link', $default, array( 'rassegne-stampa', 'documenti', 'gallerie', 'video' ), $width, 0, __( 'Media', SCM_THEME ) ); // todo: in install crea array di types Media (aggiungi campo Media nella creazione di types)
				break;

				case 'paypal':
					$fields[] = scm_acf_field_text( $name . 'link', array( 'placeholder'=>__( 'Codice PayPal', SCM_THEME ), 'prepend'=>__( 'Code', SCM_THEME ) ), $width, $logic, $req );
				break;
				
				default:
					$fields[] = scm_acf_field_object( $name . 'link', $default, $type, $width, 0, __( 'Elemento', SCM_THEME ) );
				break;
			}
			
			if( $options === 1 )
				$fields[] = scm_acf_field_text( $name . 'tooltip', array( 'prepend'=>__( 'Tooltip', SCM_THEME ) ), 100, $logic, $req );
			else if( $options === 2 )
				$fields[] = scm_acf_field_falsetrue( $name . 'onmap', $default, 20, 0, __( 'Map', SCM_THEME ) );

			return $fields;

		}
	}

	// ICONS
	if ( ! function_exists( 'scm_acf_preset_flexible_buttons' ) ) {
		function scm_acf_preset_flexible_buttons( $name = '', $default = 0, $group = '', $label = '', $logic = 0, $instructions = '', $required = 0, $class = 'buttons-flexible' ) {

			$fields = array();

			global $SCM_fa;

			if( !isset( $SCM_fa[ $group ] ) )
				return $fields;

			if( $instructions )
				$fields[] = scm_acf_field( 'msg-open-buttons' . ( $name ? '-' . $name : '' ), array( 'message', $instructions ), __( 'Istruzioni Pulsanti', SCM_THEME ) . ' ' . $label );

			$name = ( $name ? $name . '-' : '');

			$contacts = scm_acf_field_flexible( $name . 'buttons' , $default, __( 'Aggiungi Pulsante', SCM_THEME ), '+' );			

				foreach ( $SCM_fa[ $group ] as $key => $value ) {

					if( $key == 'other' )
						continue;
					
					$layout = scm_acf_layout( $key, 'block', $value[ 'name' ] );

						$layout['sub_fields'] = scm_acf_preset_button( '', 'link', $key . '_' . $group, $key, 0, $value[ 'name' ], __( 'Link', SCM_THEME ) );

					$contacts['layouts'][] = $layout;
				}

			$fields[] = $contacts;

			return $fields;

		}
	}

	// BUTTON SHAPE
	if ( ! function_exists( 'scm_acf_preset_button_shape' ) ) {
		function scm_acf_preset_button_shape( $name = 'but-style', $default = 0, $width = 100, $logic = 0, $placeholder = '', $instructions = '', $req = 0 ) {

			$fields = array();

			$fields[] = scm_acf_field_select1( $name . 'shape', $default, 'box_shape-no', 100, $logic, __( 'Forma', SCM_THEME ), __( 'Forma Box', SCM_THEME ) );
				
				$shape = array( $logic, array( 'field' => $name . 'shape', 'operator' => '!=', 'value' => 'no' ) );
				$rounded = scm_acf_group_condition( $logic, $shape, array( 'field' => $name . 'shape', 'operator' => '!=', 'value' => 'square' ) );

					$fields[] = scm_acf_field_select1( $name . 'shape-angle', $default, 'box_angle_type', 50, $rounded, __( 'Angoli', SCM_THEME ), __( 'Angoli Box', SCM_THEME ) );
					$fields[] = scm_acf_field_select1( $name . 'shape-size', $default, 'simple_size', 50, $rounded, __( 'Dimensione', SCM_THEME ), __( 'Dimensione angoli Box', SCM_THEME ) );

			return $fields;
			
		}
	}

	// SECTIONS
	if ( ! function_exists( 'scm_acf_preset_flexible_sections' ) ) {
		function scm_acf_preset_flexible_sections( $name = '', $default = 0, $elements = '', $logic = 0, $instructions = '', $required = 0, $class = 'rows-flexible' ) {

			$fields = array();

			if( $instructions )
				$fields[] = scm_acf_field( 'msg-open-sections' . ( $name ? '-' . $name : '' ), array( 'message', $instructions ), __( 'Istruzioni Righe', SCM_THEME ) );

			$name = ( $name ? $name . '-' : '');

			$sections = scm_acf_field_repeater( $name . 'sections', $default, __( 'Aggiungi Sezione', SCM_THEME ), __( 'Sezioni', SCM_THEME ), 100, $logic, '', '', '', $required, $class );

				$sections['sub_fields'] = array_merge( $sections['sub_fields'], scm_acf_preset_selectors( '', 25, 25 ) );
				$sections['sub_fields'][] = scm_acf_field( 'attributes', 'attributes', '', 50 );

				$flexible = scm_acf_field_flexible( 'rows', $default, __( 'Moduli', SCM_THEME ) );			

					$template = scm_acf_layout( 'template', 'block', __( 'Template', SCM_THEME ) );
						
						$template['sub_fields'][] = scm_acf_field_select_layout( 'layout', 1, '', 20 );
						$template['sub_fields'] = array_merge( $template['sub_fields'], scm_acf_preset_selectors( '', 20, 20 ) );
						$template['sub_fields'][] = scm_acf_field( 'attributes', 'attributes', '', 40 );
						$template['sub_fields'][] = scm_acf_field_text( 'archive', array( 'placeholder'=>'type[:field[=value]', 'prepend'=>__( 'Archivio', SCM_THEME ) ) );
						$template['sub_fields'][] = scm_acf_field_text( 'post', array( 'placeholder'=>__( 'ID or Option Name', SCM_THEME ), 'prepend'=>__( 'Post', SCM_THEME ) ) );
						$template['sub_fields'][] = scm_acf_field_positive( 'template', array( 'prepend'=>__( 'Template', SCM_THEME ) ) );

					$row = scm_acf_layout( 'row', 'block', 'Section' );
						
						$row['sub_fields'][] = scm_acf_field_select_layout( 'layout', 1, '', 20 );
						$row['sub_fields'] = array_merge( $row['sub_fields'], scm_acf_preset_selectors( '', 20, 20 ) );
						$row['sub_fields'][] = scm_acf_field( 'attributes', 'attributes', '', 40 );
						$row['sub_fields'][] = scm_acf_field_object( 'row', $default, 'sections' );

					$module = scm_acf_layout( 'module', 'block', 'Module' );

						$module['sub_fields'][] = scm_acf_field_select_layout( 'layout', 1, '', 20 );
						$module['sub_fields'] = array_merge( $module['sub_fields'], scm_acf_preset_selectors( '', 20, 20 ) );
						$module['sub_fields'][] = scm_acf_field( 'attributes', 'attributes', '', 40 );
						$module['sub_fields'][] = scm_acf_field_object( 'row', $default, 'modules' );

					$banner = scm_acf_layout( 'banner', 'block', 'Banner' );

						$banner['sub_fields'][] = scm_acf_field_select_layout( 'layout', 1, '', 20 );
						$banner['sub_fields'] = array_merge( $banner['sub_fields'], scm_acf_preset_selectors( '', 20, 20 ) );
						$banner['sub_fields'][] = scm_acf_field( 'attributes', 'attributes', '', 40 );
						$banner['sub_fields'][] = scm_acf_field_object( 'row', $default, 'banners' );

					$flexible['layouts'] = array( $template, $row, $module, $banner );

				$sections['sub_fields'][] = $flexible;

			$fields[] = $sections;
			
			return $fields;
		}
	}

	// LAYOUTS ( vedi scm-acf-layouts.php )
	if ( ! function_exists( 'scm_acf_preset_flexible_elements' ) ) {
		function scm_acf_preset_flexible_elements( $name = '', $elements = '', $logic = 0, $instructions = '', $required = 0, $class = 'elements-flexible' ) {

			$default = 0; //todo: da rimuovere

			global $SCM_acf_objects, $SCM_types;

			$SCM_acf_objects[] = array( 'scm_acf_object_slider', __( 'Slider', SCM_THEME ) );
            $SCM_acf_objects[] = array( 'scm_acf_object_section', __( 'Section', SCM_THEME ) );
            $SCM_acf_objects[] = array( 'scm_acf_object_module', __( 'Module', SCM_THEME ) );
            $SCM_acf_objects[] = array( 'scm_acf_object_form', __( 'Form', SCM_THEME ) );
            $SCM_acf_objects[] = array( 'scm_acf_object_indirizzo', __( 'Indirizzo', SCM_THEME ) );
            $SCM_acf_objects[] = array( 'scm_acf_object_map', __( 'Map', SCM_THEME ) );
            $SCM_acf_objects[] = array( 'scm_acf_object_separatore', __( 'Separatore', SCM_THEME ) );
            $SCM_acf_objects[] = array( 'scm_acf_object_immagine', __( 'Immagine', SCM_THEME ) );
            $SCM_acf_objects[] = array( 'scm_acf_object_icona', __( 'Icona', SCM_THEME ) );
            $SCM_acf_objects[] = array( 'scm_acf_object_titolo', __( 'Titolo', SCM_THEME ) );
            $SCM_acf_objects[] = array( 'scm_acf_object_quote', __( 'Quote', SCM_THEME ) );
            $SCM_acf_objects[] = array( 'scm_acf_object_data', __( 'Data', SCM_THEME ) );
            $SCM_acf_objects[] = array( 'scm_acf_object_testo', __( 'Testo', SCM_THEME ) );
            $SCM_acf_objects[] = array( 'scm_acf_object_elenco_puntato', __( 'Elenco puntato', SCM_THEME ) );
            $SCM_acf_objects[] = array( 'scm_acf_object_contatti', __( 'Contatti', SCM_THEME ) );
            $SCM_acf_objects[] = array( 'scm_acf_object_social_follow', __( 'Social follow', SCM_THEME ) );
            $SCM_acf_objects[] = array( 'scm_acf_object_social_share', __( 'Social share', SCM_THEME ) );
            $SCM_acf_objects[] = array( 'scm_acf_object_pulsanti', __( 'Pulsanti', SCM_THEME ) );
            $SCM_acf_objects[] = array( 'scm_acf_object_login', __( 'Login Form', SCM_THEME ) );

			$fields = array();

			if( $instructions )
				$fields[] = scm_acf_field( 'msg-open-modules' . ( $name ? '-' . $name : '' ), array( 'message', $instructions ), __( 'Istruzioni Elementi', SCM_THEME ) );

			$name = ( $name ? $name . '-' : '');

			$flexible = scm_acf_field_flexible( $name . 'modules', $default, '', '+', 100, $logic, '', '', '', $required, $class );

				if( !$elements ){
					$elements = array();
					foreach ( $SCM_types['public'] as $slug => $value) {
						$elements[] = array( $slug, $value );
					}
					$elements = array_merge( $elements, $SCM_acf_objects );
				}
				
				if( !is_array( $elements ) )
					$elements = array( $elements );


				foreach ($elements as $el) {

					if( gettype( $el ) != 'array' )
						return;

					$fun = ( strpos( $el[0], 'scm_acf_object_' ) === 0 ? $el[0] : 'scm_acf_object');
					$element = $el[1];
					$key = str_replace( 'scm_acf_object_', '', $el[0] );

					$layout = scm_acf_layout( $key, 'block', $element );

					if( $fun != 'scm_acf_object' && function_exists( $fun ) )
						$layout['sub_fields'] = array_merge( $layout['sub_fields'], call_user_func( $fun ) ); // Call Elements function in scm-acf-layouts.php
					else
						$layout['sub_fields'] = array_merge( $layout['sub_fields'], call_user_func( $fun, $key ) ); // Call Elements function in scm-acf-layouts.php
					
					$flexible['layouts'][] = $layout;
					
				}

				$flexible['layouts'] = scm_acf_layouts_preset( $flexible['layouts'] );

			$fields[] = $flexible;
			
			return $fields;
		}
	}

	
?>