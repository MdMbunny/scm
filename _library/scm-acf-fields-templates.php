<?php

	// TEMPLATE SLIDER OPTIONS
	if ( ! function_exists( 'scm_acf_template_sliders' ) ) {
		function scm_acf_template_sliders( $name = '' ) {

			$default = 0; //todo: da rimuovere

			$name = ( $name ? $name . '-' : '');

			$fields = array();

			//$fields = array_merge( $fields, scm_acf_preset_term( $name, $default, 'sliders', 'Slider' ) );

			//$fields[] = scm_acf_field_select( $name . 'layout', $default, 'layout_main', 100, 0, '', 'Layout' );

			$fields = array_merge( $fields, scm_acf_preset_size( $name . 'height', '', 'auto', 'px', __( 'Altezza', SCM_THEME ), 100 ) );
			$fields[] = scm_acf_field_select( $name . 'theme', $default, 'themes_nivo', 100, 0, '', __( 'Tema', SCM_THEME ) );
			$fields[] = scm_acf_field_select_valign( $name . 'alignment', $default );
			
			// conditional options
			/*$fields[] = scm_acf_field_select_options( $name . 'options', 0, 100, 0, 'hide' );

			$hide = [ 'field' => $name . 'options', 'operator' => '==', 'value' => 'hide' ];
			$options = [ 'field' => $name . 'options', 'operator' => '==', 'value' => 'options' ];
			$advanced = [ 'field' => $name . 'options', 'operator' => '==', 'value' => 'advanced' ];*/

			$hide = 0;
			$options = 0;
			$advanced = 0;

				$fields[] = scm_acf_field_select( $name . 'effect', $default, 'effect_nivo', 100, $options, '', __( 'Effetto Slider', SCM_THEME ) );
				$fields[] = scm_acf_field_number( $name . 'slices', array( 'default'=>30, 'prepend'=>__( 'Slices', SCM_THEME ), 'min'=>1, 'max'=>30 ), 100, $options );
				$fields[] = scm_acf_field_number( $name . 'cols', array( 'default'=>8, 'prepend'=>__( 'Colonne', SCM_THEME ), 'min'=>1, 'max'=>8 ), 100, $options );
				$fields[] = scm_acf_field_number( $name . 'rows', array( 'default'=>8, 'prepend'=>__( 'Righe', SCM_THEME ), 'min'=>1, 'max'=>100 ), 100, $options );
				$fields[] = scm_acf_field_number( $name . 'speed', array( 'default'=>1, 'prepend'=>__( 'Velocità', SCM_THEME ) ), 100, $options );
				$fields[] = scm_acf_field_number( $name . 'pause', array( 'default'=>5, 'prepend'=>__( 'Pausa', SCM_THEME ) ), 100, $options );

				$fields[] = scm_acf_field_option( $name . 'start', array( 'default'=>0, 'prepend'=>__( 'Start', SCM_THEME ) ), 100, $advanced );
				$fields[] = scm_acf_field_select_disable( $name . 'hover', $default, __( 'Pause on Hover', SCM_THEME ), 100, $advanced );
				$fields[] = scm_acf_field_select_disable( $name . 'manual', $default, __( 'Avanzamento Manuale', SCM_THEME ), 100, $advanced );
				$fields[] = scm_acf_field_select_disable( $name . 'direction', $default, __( 'Direction Nav', SCM_THEME ), 100, $advanced );
				$fields[] = scm_acf_field_select_disable( $name . 'control', $default, __( 'Control Nav', SCM_THEME ), 100, $advanced );
				$fields[] = scm_acf_field_select_disable( $name . 'thumbs', $default, __( 'Thumbs Nav', SCM_THEME ), 100, $advanced );
				$fields[] = scm_acf_field_icon( $name . 'prev', array('placeholder'=>'angle-left','label'=>__( 'Prev Icon', SCM_THEME )), 100, $advanced );
				$fields[] = scm_acf_field_icon( $name . 'next', array('placeholder'=>'angle-right','label'=>__( 'Next Icon', SCM_THEME )), 100, $advanced );

			return $fields;
			
		}
	}

?>