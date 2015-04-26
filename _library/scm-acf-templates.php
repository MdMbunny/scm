<?php

	// TEMPLATE SLIDER OPTIONS
	if ( ! function_exists( 'scm_acf_template_sliders' ) ) {
		function scm_acf_template_sliders( $name = '', $default = 0 ) {

			$name = ( $name ? $name . '-' : '');

			$fields = array();

			//$fields = array_merge( $fields, scm_acf_preset_term( $name, $default, 'sliders', 'Slider' ) );

			//$fields[] = scm_acf_field_select( $name . 'layout', $default, 'layout_main', 100, 0, '', 'Layout' );
			$fields = array_merge( $fields, scm_acf_preset_size( $name . 'height', $default, 'auto', 'px', 'Altezza Massima', 0, 69, 30 ) );
			$fields[] = scm_acf_field_select( $name . 'theme', $default, 'themes_nivo', 100, 0, '', 'Tema' );
			
			// conditional options
			/*$fields[] = scm_acf_field_select_options( $name . 'options', 0, 100, 0, 'hide' );

			$hide = [ 'field' => $name . 'options', 'operator' => '==', 'value' => 'hide' ];
			$options = [ 'field' => $name . 'options', 'operator' => '==', 'value' => 'options' ];
			$advanced = [ 'field' => $name . 'options', 'operator' => '==', 'value' => 'advanced' ];*/

			$hide = 0;
			$options = 0;
			$advanced = 0;

				$fields[] = scm_acf_field_select( $name . 'effect', $default, 'effect_nivo', 100, $options, '', 'Effetto Slider' );
				$fields[] = scm_acf_field_number( $name . 'slices', $default, 100, $options, '30', 'Slices', 1, 30 );
				$fields[] = scm_acf_field_number( $name . 'cols', $default, 100, $options, '8', 'Colonne', 1, 8 );
				$fields[] = scm_acf_field_number( $name . 'rows', $default, 100, $options, '8', 'Righe', 1, 100 );
				$fields[] = scm_acf_field_number( $name . 'speed', $default, 100, $options, '1', 'Velocità' );
				$fields[] = scm_acf_field_number( $name . 'pause', $default, 100, $options, '5', 'Pausa' );

				$fields[] = scm_acf_field_option( $name . 'start', $default, 100, $advanced, '0', 'Start Slide' );
				$fields[] = scm_acf_field_select_enable( $name . 'hover', $default, 'Pause on Hover', 100, $advanced );
				$fields[] = scm_acf_field_select_disable( $name . 'manual', $default, 'Avanzamento Manuale', 100, $advanced );
				$fields[] = scm_acf_field_select_enable( $name . 'direction', $default, 'Direction Nav', 100, $advanced );
				$fields[] = scm_acf_field_select_disable( $name . 'control', $default, 'Control Nav', 100, $advanced );
				$fields[] = scm_acf_field_select_disable( $name . 'thumbs', $default, 'Thumbs Nav', 100, $advanced );
				$fields[] = scm_acf_field_icon( $name . 'prev', $default, 'angle-left', '', 100, $advanced, 'Prev Icon' );
				$fields[] = scm_acf_field_icon( $name . 'next', $default, 'angle-right', '', 100, $advanced, 'Next Icon' );

			return $fields;
			
		}
	}

?>