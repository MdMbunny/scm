<?php


// *****************************************************
// *      ACTIONS AND FILTERS
// *****************************************************

add_filter('acf/load_field', 'scm_acf_select_field');
add_action('acf/save_post', 'scm_acf_google_latlng', 1);

// *****************************************************
// *      CUSTOM FIELDS ACTIONS
// *****************************************************

    if ( ! function_exists( 'scm_acf_select_field' ) ) {
        function scm_acf_select_field( $field ){

            $default = scm_acf_select_preset($field['name']);

            if( $default ){

            	$inherit = array();
	            
	            if( isset( $field['choices'] ) ){
		        	foreach ( $field['choices'] as $key => $value ) {
		        		if( $key == 'default' || $key == 'no' )
		        			$array[$key] = $value;
		        	}
				}
	            $field['choices'] = $inherit + $default ;
	            /*if( $field['type'] == 'radio' )
	            	$field['default_value'] = (string)current(array_keys($field['choices']));
	            else
		            $field['default_value'] = array((string)current(array_keys($field['choices'])) => reset($field['choices']));*/
	        }

            return $field;
        }
    }


    if ( ! function_exists( 'scm_acf_google_latlng' ) ) {
        function scm_acf_google_latlng( $post_id ) {
        	//printPre($_POST);
           
			if( empty($_POST['acf']) || !isset( $_POST['post_type'] ) )
				return;
            if( $_POST['post_type'] != 'scm-luoghi' )
                return;

            $fields = $_POST['acf'];
            
            $country = $fields['field_548f253744f97'];
            $region = $fields['field_548f25f644f98'];
            $province = $fields['field_548f265644f99'];
            $code = $fields['field_548ee4b8fd2bc'];
            $city = $fields['field_548ee4cbfd2bd'];
            $town = $fields['field_548ee501fd2bf'];
            $address = $fields['field_548ee49dfd2bb'];

            $google_address = $address . ' ' . $town . ' ' . $code . ' ' . $city . ' ' . $province . ' ' . $region;
            $ll = getGoogleMapsLatLng( $google_address, $country );
            $lat = $ll['lat'];
            $lng = $ll['lng'];

            $fields['field_548fe73047972'] = $lat;
            $fields['field_54945fd9fdd3e'] = $lng; 
        }
    }

    // *****************************************************
// *      PRESETS
// *****************************************************

	if ( ! function_exists( 'scm_acf_select_preset' ) ) {
        function scm_acf_select_preset( $list ){
		        				
			if( strpos( $list, 'select_types' ) !== false ):
	    		global $SCM_types_slug;

	    		$add = array(
	    			'wpcf7_contact_form' => 'Contact Form',
	    		);

	    		$arr = ( strpos( $list, '_complete') !== false ? array_merge( $SCM_types_slug, $add ) : $SCM_types_slug );
	    		
	    		return $arr;
	    	endif;

	        if( strpos( $list, 'select_alignment' ) !== false ):
	        	return array(
					'left' => 'Sinistra',
					'right' => 'Destra',
					'center' => 'Centrato',
				);
			endif;

	        if( strpos( $list, 'select_txt_alignment' ) !== false ):
	        	return array(
					'left' => 'Sinistra',
					'right' => 'Destra',
					'center' => 'Centrato',
					'justify' => 'Giustificato',
				);
			endif;
    		
    		if( strpos( $list, 'select_float' ) !== false ):
	        	return array(
					'no' => 'No float',
					'float-left' => 'Sinistra',
					'float-right' => 'Destra',
					'float-center' => 'Centrato',
				);
			endif;
    		
    		if( strpos( $list, 'select_headings' ) !== false ):
	        	return array(
					"h1" => "h1",
					"h2" => "h2",
					"h3" => "h3",
					"h4" => "h4",
					"h5" => "h5",
					"h6" => "h6",
					".h7" => ".h7",
					".h8" => ".h8",
					".h9" => ".h9",
					".h0" => ".h0",
					"strong" => "strong",
					"div" => "div",
				);
			endif;
    		
    		if( strpos( $list, 'select_columns_width' ) !== false ):
				return array(
					'11' => '1/1',
					'12' => '1/2',
					'13' => '1/3',
					'23' => '2/3',
					'14' => '1/4',
					'34' => '3/4',
					'15' => '1/5',
					'25' => '2/5',
					'35' => '3/5',
					'45' => '4/5',
					'16' => '1/6',
					'56' => '5/6',
				);
			endif;
			
			if( strpos( $list, 'select_txt_size' ) !== false ):
				return array(
					'normal' => 'Normale',
					'minion' => 'Minuscolo',
					'half' => 'Met&agrave;',
					'small' => 'Piccolo',
					'medium' => 'Medio',
					'big' => 'Grande',
					'huge' => 'Enorme',
					'double' => 'Doppio',
				);
			endif;

			if( strpos( $list, 'select_layout' ) !== false ):
				return array(
					'responsive'		=> 'Responsive',
					'full'				=> 'Full Width',
				);
			endif;

			if( strpos( $list, 'select_head_layout' ) !== false ):
				return array(
					'menu_down'			=> 'Menu sotto a Logo',
					'menu_right'		=> 'Menu alla destra del Logo',
				);
			endif;

			if( strpos( $list, 'select_bg_repeat' ) !== false ):
				return array(
					'no-repeat'			=> 'No repeat',
					'repeat'			=> 'Repeat',
					'repeat-x'			=> 'Repeat x',
					'repeat-y'			=> 'Repeat y',
				);
			endif;

			if( strpos( $list, 'select_bg_position' ) !== false ):
				return array(
					'center center'			=> 'center center',
					'center top'			=> 'center top',
					'center bottom'			=> 'center bottom',
					'left center'			=> 'left center',
					'left top'				=> 'left top',
					'left bottom'			=> 'left bottom',
					'right center'			=> 'right center',
					'right top'				=> 'right top',
					'right bottom'			=> 'right bottom',
				);
			endif;
			
			if( strpos( $list, 'select_webfonts_families' ) !== false ):
				$arr = array('no' => 'No Google font');
				$fonts = get_field( 'webfonts', 'option' );
				if( $fonts ){
					foreach ( $fonts as $font) {
						$arr['"' . $font['family'] . '"'] = $font['family'];
					}
				}
				return $arr;
			endif;

			if( strpos( $list, 'select_webfonts_default_families' ) !== false ):
				return array(
					'Helvetica_Arial_sans-serif'							=> 'Helvetica, Arial, sans-serif',
					'"Lucida Sans Unicode"_"Lucida Grande"_sans-serif'		=> '"Lucida Sans Unicode", "Lucida Grande", sans-serif',
					'"Trebuchet MS"_Helvetica_sans-serif'					=> '"Trebuchet MS", Helvetica, sans-serif',
					'Verdana_Geneva_sans-serif'								=> 'Verdana, Geneva, sans-serif',
					'Georgia_serif'											=> 'Georgia, serif',
					'"Times New Roman"_Times_serif'							=> '"Times New Roman", Times, serif',
					'"Palatino Linotype"_"Book Antiqua"_Palatino_serif'		=> '"Palatino Linotype", "Book Antiqua", Palatino, serif',
					'cursive_serif'											=> 'cursive, serif',
					'"Courier New"_Courier_monospace'						=> '"Courier New", Courier, monospace',
					'"Lucida Console"_Monaco_monospace'						=> '"Lucida Console", Monaco, monospace',
				);
			endif;
			
			if( strpos( $list, 'select_webfonts_styles' ) !== false ):
				return array(
					'300' => 'Light',
					'300italic' => 'Light Italic',
					'400' => 'Normal',
					'400italic' => 'Normal Italic',
					'600' => 'Semi Bold',
					'600italic' => 'Semi Bold Italic',
					'700' => 'Bold',
					'700italic' => 'Bold Italic',
					'800' => 'Extra Bold',
					'800italic' => 'Extra Bold Italic',
				);
			endif;

			if( strpos( $list, 'select_font_weight' ) !== false ):
				return array(
					'300' => 'Light',
					'400' => 'Normal',
					'600' => 'Semi Bold',
					'700' => 'Bold',
					'800' => 'Extra Bold',
				);
			endif;

			if( strpos( $list, 'select_ease' ) !== false ):
				return array(
					'linear' 			=> 'Linear',
					'swing' 			=> 'Swing',
					'easeInQuad' 		=> 'Quad In',
					'easeOutQuad' 		=> 'Quad Out',
					'easeInOutQuad' 	=> 'Quad InOut',
					'easeInCubic' 		=> 'Cubic In',
					'easeOutCubic' 		=> 'Cubic Out',
					'easeInOutCubic' 	=> 'Cubic InOut',
					'easeInQuart' 		=> 'Quart In',
					'easeOutQuart' 		=> 'Quart Out',
					'easeInOutQuart' 	=> 'Quart InOut',
					'easeInQuint' 		=> 'Quint In',
					'easeOutQuint' 		=> 'Quint Out',
					'easeInOutQuint' 	=> 'Quint InOut',
					'easeInExpo' 		=> 'Expo In',
					'easeOutExpo' 		=> 'Expo Out',
					'easeInOutExpo' 	=> 'Expo InOut',
					'easeInSine' 		=> 'Sine In',
					'easeOutSine' 		=> 'Sine Out',
					'easeInOutSine' 	=> 'Sine InOut',
					'easeInCirc' 		=> 'Circ In',
					'easeOutCirc' 		=> 'Circ Out',
					'easeInOutCirc' 	=> 'Circ InOut',
					'easeInElastic' 	=> 'Elastic In',
					'easeOutElastic' 	=> 'Elastic Out',
					'easeInOutElastic' 	=> 'Elastic InOut',
					'easeInBack' 		=> 'Back In',
					'easeOutBack' 		=> 'Back Out',
					'easeInOutBack' 	=> 'Back InOut',
					'easeInBounce' 		=> 'Bounce In',
					'easeOutBounce' 	=> 'Bounce Out',
					'easeInOutBounce' 	=> 'Bounce InOut',
				);
			endif;

        }
    }

?>