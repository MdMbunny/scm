<?php


// *****************************************************
// *      ACTIONS AND FILTERS
// *****************************************************

add_filter('acf/settings/dir', 'scm_acf_settings_dir');
add_filter('acf/settings/path', 'scm_acf_settings_path');

add_filter('acf/settings/save_json', 'scm_acf_json_save');
add_filter('acf/settings/load_json', 'scm_acf_json_load');

add_filter('acf/load_field', 'scm_acf_select_field');
add_action('acf/save_post', 'scm_acf_google_latlng', 1);
//add_action('acf/save_post', 'scm_acf_assign_soggetti', 1);

//add_filter('acf/fields/relationship/query/name=select_luoghi', 'scm_acf_select_luoghi', 10, 3);

add_filter( 'bfa_force_fallback', 'scm_force_fallback' );

// *****************************************************
// *      FONT AWESOME FALLBACK FIX
// *****************************************************

function scm_force_fallback( $force_fallback ) {
	return true;
}


// *****************************************************
// *      CUSTOM FIELDS ACTIONS
// *****************************************************

// *** PLUGIN SETTINGS

	// customize ACF plugin path
	if ( ! function_exists( 'scm_acf_settings_path' ) ) {
		function scm_acf_settings_path( $path ) {
		    
		    $path = SCM_DIR_ACF_PLUGIN;
		    return $path;
		    
		}	
	}
	 
	// customize ACF plugin dir
	if ( ! function_exists( 'scm_acf_settings_dir' ) ) {
		function scm_acf_settings_dir( $dir ) {
		    
		    $dir = SCM_URI_ACF_PLUGIN;
		    return $dir;
		    
		}
	}

	// customize ACF json path for saving field groups
	 if ( ! function_exists( 'scm_acf_json_save' ) ) {
		function scm_acf_json_save( $path ) {

		    $path = SCM_DIR_ACF_JSON;

		    return $path;

		}
	}

	// customize ACF json path for loading field groups
	if ( ! function_exists( 'scm_acf_json_load' ) ) {
		function scm_acf_json_load( $paths ) {
	    
			//unset($paths[0]);
			$paths[] = SCM_DIR_ACF_JSON;
			
		    return $paths;
		}
	}


	if ( ! function_exists( 'scm_acf_google_latlng' ) ) {
        function scm_acf_google_latlng( $post_id ) {
           
			if( empty($_POST['acf']) || !isset( $_POST['post_type'] ) )
				return;
            if( $_POST['post_type'] != 'scm-luoghi' )
                return;

            $fields = $_POST['acf'];
            
            $country = $fields[SCM_ACF_LUOGO_COUNTRY];
            $region = $fields[SCM_ACF_LUOGO_REGION];
            $province = $fields[SCM_ACF_LUOGO_PROVINCE];
            $code = $fields[SCM_ACF_LUOGO_CODE];
            $city = $fields[SCM_ACF_LUOGO_CITY];
            $town = $fields[SCM_ACF_LUOGO_TOWN];
            $address = $fields[SCM_ACF_LUOGO_ADDRESS];

            $google_address = $address . ' ' . $town . ' ' . $code . ' ' . $city . ' ' . $province . ' ' . $region;

            $ll = getGoogleMapsLatLng( $google_address, $country );
            $lat = $ll['lat'];
            $lng = $ll['lng'];

            $_POST['acf'][SCM_ACF_LUOGO_LATITUDE] = $lat;
            $_POST['acf'][SCM_ACF_LUOGO_LONGITUDE] = $lng; 
        }
	}

	/*if ( ! function_exists( 'scm_acf_assign_soggetti' ) ) {
        function scm_acf_assign_soggetti( $post_id ) {
        	if( empty($_POST['acf']) || !isset( $_POST['post_type'] ) )
				return;
            if( $_POST['post_type'] != 'scm-soggetti' )
                return;

            $fields = $_POST['acf'];

            foreach ( get_posts(array( 'post_type' => 'scm-luoghi' )) as $luogo) {
            	$luogo_id = $luogo->ID;
            	$soggetti = ( gettype(get_field( SCM_ACF_LUOGO_SOGGETTI, $luogo_id )) == 'array' ? get_field( SCM_ACF_LUOGO_SOGGETTI, $luogo_id ) : array() );
            	$index = array_search($post_id, $soggetti);
				if ( $index !== false ) {
					unset( $soggetti[$index] );
				}
				$soggetti = ( sizeof($soggetti) > 0 ? $soggetti : null );
				update_field( SCM_ACF_LUOGO_SOGGETTI, $soggetti, $luogo_id );
				//printPre($luogo_id);
				//printPre(get_field('luoghi_soggetti', $luogo_id));
            }

            if( $fields[SCM_ACF_SOGGETTO_LUOGHI] ){
	            foreach ($fields[SCM_ACF_SOGGETTO_LUOGHI] as $luogo_id) {
	            	
	            	$soggetti = ( get_field( SCM_ACF_LUOGO_SOGGETTI, $luogo_id ) ?: array() );
	            	$soggetti = array_merge($soggetti, array($post_id));
					
	            	update_field( SCM_ACF_LUOGO_SOGGETTI, $soggetti, $luogo_id );
	            	//printPre($luogo_id);
	            	//printPre(get_field('luoghi_soggetti', $luogo_id));
	            }
	        }

            //foreach ( get_posts(array( 'post_type' => 'scm-luoghi' )) as $luogo) {
            	//$luogo_id = $luogo->ID;
            	//printPre($luogo_id);
				//printPre(get_field('luoghi_soggetti', $luogo_id));
            //}
        }
    }

	// insert default select options from default presets
	if ( ! function_exists( 'scm_acf_select_luoghi' ) ) {
        function scm_acf_select_luoghi( $args, $field, $post ){
        	//print($post->ID);
        	//printPre($args['meta_query']);
        	//alert('PIPPO');
        	$obj = get_field( 'select_soggetto' );
        	$id = $obj->ID;

            $args['meta_query'] = array(
		        array(
		            'key' => 'luoghi_soggetti',
		            'value' => $id,
		            'compare' => 'LIKE'
		        )
		    );

		    return $args;
        }
	}*/

// *****************************************************
// *      PRESETS
// *****************************************************

	// insert default select options from default presets
	if ( ! function_exists( 'scm_acf_select_field' ) ) {
        function scm_acf_select_field( $field ){

            $default = scm_acf_select_preset($field['name']);

            if( $default ){

            	$inherit = array();
	            
				if( isset( $field['choices'] ) ){
			    	foreach ( $field['choices'] as $key => $value ) {
			        	if( $key == 'default' || $key == 'no' )
			        		$inherit[$key] = $value;
			        }
				}
	        
	        	$field['choices'] = $inherit + $default ;
	    	}
            
            return $field;
        }
	}

	// get default select options
	if ( ! function_exists( 'scm_acf_select_preset' ) ) {
        function scm_acf_select_preset( $list, $get = '', $separator = '' ){

        	$arr = array();
        	//return $arr;
		        				
			if( strpos( $list, 'select_types' ) !== false ):
	    		global $SCM_types;

	    		$arr = array();

	    		if( strpos( $list, '_complete') !== false )
	    			$arr = $SCM_types['complete'];
	    		else if( strpos( $list, '_private') !== false )
	    			$arr = $SCM_types['private'];
	    		else if( strpos( $list, '_public') !== false )
	    			$arr = $SCM_types['public'];
	    		else
	    			$arr = $SCM_types['all'];
	    	elseif( strpos( $list, 'select_menu' ) !== false ):

	    		$menus = get_registered_nav_menus();

				foreach ( $menus as $location => $description ) {
					if( !strpos( $location, '__en' ) )
						$arr[ $location ] = $description;
				}
	        elseif( strpos( $list, 'select_alignment' ) !== false ):
	        	$arr = array(
					'left' => 'Sinistra',
					'right' => 'Destra',
					'center' => 'Centrato',
				);
			elseif( strpos( $list, 'select_txt_alignment' ) !== false ):
	        	$arr = array(
					'left' => 'Sinistra',
					'right' => 'Destra',
					'center' => 'Centrato',
					'justify' => 'Giustificato',
				);
			elseif( strpos( $list, 'select_float' ) !== false ):
	        	$arr = array(
					'no' => 'No float',
					'float-left' => 'Sinistra',
					'float-right' => 'Destra',
					'float-center' => 'Centrato',
				);
			elseif( strpos( $list, 'select_headings' ) !== false ):
	        	$arr = array(
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
	        elseif( strpos( $list, 'select_complete_headings' ) !== false ):
	        	$arr = array(
	        		"select_headings_1" => "Primario",
	        		"select_headings_2" => "Secondario",
	        		"select_headings_3" => "Terziario",
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
	        elseif( strpos( $list, 'select_default_headings_classes' ) !== false ):
	        	$arr = array(
	        		"select_headings_1" => "primary",
	        		"select_headings_2" => "secondary",
	        		"select_headings_3" => "tertiary",
	        	);
			elseif( strpos( $list, 'select_columns_width' ) !== false ):
				$arr = array(
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
			elseif( strpos( $list, 'select_txt_size' ) !== false ):
				$arr = array(
					'60' => 'XXX-Small',
					'70' => 'XX-Small',
					'80' => 'X-Small',
					'90' => 'Smaller',
					'95' => 'Small',
					'100' => 'Normal',
					'105' => 'Medium',
					'110' => 'Large',
					'120' => 'X-Large',
					'130' => 'XX-Large',
					'140' => 'XXX-Large',
					'150' => 'Big',
					'160' => 'X-Big',
					'170' => 'XX-Big',
					'180' => 'XXX-Big',
					'200' => 'Huge',
				);

			elseif( strpos( $list, 'select_txt_font_size' ) !== false ):
				$arr = array(
					'10px' => 'XXX-Small',
					'11px' => 'XX-Small',
					'12px' => 'X-Small',
					'13px' => 'Smaller',
					'15px' => 'Small',
					'16px' => 'Normal',
					'17px' => 'Medium',
					'18px' => 'Large',
					'19px' => 'X-Large',
					'20px' => 'XX-Large',
					'21px' => 'XXX-Large',
					'22px' => 'Big',
					'23px' => 'X-Big',
					'24px' => 'XX-Big',
					'25px' => 'XXX-Big',
					'26px' => 'Huge',
				);
			
			elseif( strpos( $list, 'select_layout' ) !== false ):
				$arr = array(
					'responsive'		=> 'Responsive',
					'full'				=> 'Full Width',
				);
			
			elseif( strpos( $list, 'select_responsive_events' ) !== false ):
				$arr = array(
					'smart'			=> 'Mobile',
					'portrait'		=> 'Tablet Portrait',
					'tablet'		=> 'Tablet Landscape',
					'desktop'		=> 'Desktop',
				);

			elseif( strpos( $list, 'select_responsive_up' ) !== false ):
				$arr = array(
					'smart'									=> 'Mobile',
					'smart portrait'						=> 'Tablet Portrait',
					'smart portrait landscape'				=> 'Tablet Landscape',
					'smart portrait landscape desktop'		=> 'Desktop',
				);

			elseif( strpos( $list, 'select_responsive_down' ) !== false ):
				$arr = array(
					'desktop landscape portrait smart'		=> 'Mobile',
					'desktop landscape portrait'			=> 'Tablet Portrait',
					'desktop landscape'						=> 'Tablet Landscape',
					'desktop'								=> 'Desktop',
				);

			elseif( strpos( $list, 'select_responsive_layouts' ) !== false ):
				$arr = array(
					'1400'			=> '1250px',
					'1120'			=> '1120px',
					'1030'			=> '1030px',
					'940'			=> '940px',
					'800'			=> '800px',
					'700'			=> '700px',
				);
			
			elseif( strpos( $list, 'select_head_layout' ) !== false ):
				$arr = array(
					'menu_down'			=> 'Menu sotto a Logo',
					'menu_right'		=> 'Menu alla destra del Logo',
				);
			
			elseif( strpos( $list, 'select_bg_repeat' ) !== false ):
				$arr = array(
					'no-repeat'			=> 'No repeat',
					'repeat'			=> 'Repeat',
					'repeat-x'			=> 'Repeat x',
					'repeat-y'			=> 'Repeat y',
				);
			
			elseif( strpos( $list, 'select_bg_position' ) !== false ):
				$arr = array(
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

			elseif( strpos( $list, 'select_webfonts_families' ) !== false ):
				$arr = array('no' => 'No Google font');
				$arr['Roboto'] = 'Roboto';
				$fonts = get_field( 'webfonts', 'option' );
				if( $fonts ):
					foreach ( $fonts as $font):
						$arr[$font['family']] = $font['family'];
					endforeach;
				endif;
			elseif( strpos( $list, 'select_webfonts_default_families' ) !== false ):
				$arr = array(
					'Helvetica_Arial_sans-serif'						=> 'Helvetica, Arial, sans-serif',
					'Lucida Sans Unicode_Lucida Grande_sans-serif'		=> 'Lucida Sans Unicode, Lucida Grande, sans-serif',
					'Trebuchet MS_Helvetica_sans-serif'					=> 'Trebuchet MS, Helvetica, sans-serif',
					'Verdana_Geneva_sans-serif'							=> 'Verdana, Geneva, sans-serif',
					'Georgia_serif'										=> 'Georgia, serif',
					'Times New Roman_Times_serif'						=> 'Times New Roman, Times, serif',
					'Palatino Linotype_Book Antiqua_Palatino_serif'		=> 'Palatino Linotype, Book Antiqua, Palatino, serif',
					'cursive_serif'										=> 'cursive, serif',
					'Courier New_Courier_monospace'						=> 'Courier New, Courier, monospace',
					'Lucida Console_Monaco_monospace'					=> 'Lucida Console, Monaco, monospace',
				);
			elseif( strpos( $list, 'select_webfonts_styles' ) !== false ):
				$arr = array(
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
			elseif( strpos( $list, 'select_font_weight' ) !== false ):
				$arr = array(
					'300' => 'Light',
					'400' => 'Normal',
					'600' => 'Semi Bold',
					'700' => 'Bold',
					'800' => 'Extra Bold',
				);
			elseif( strpos( $list, 'select_line_height' ) !== false ):
				$arr = array(
					'0.0' => 'Nessuno spazio',
					'0.25' => '1 quarto di linea',
					'0.5' => 'Mezza linea',
					'1' => 'Una linea',
					'1.25' => 'Una linea e 1 quarto',
					'1.5' => 'Una linea e mezza',
					'1.75' => 'Una linea e 3 quarti',
					'2' => 'Doppia linea',
					'2.5' => 'Doppia linea e mezza',
					'3' => 'Tripla linea',
					'4' => 'Quadrupla linea',
				);
			elseif( strpos( $list, 'select_slider' ) !== false ):
				$arr = array(
					'nivo' => 'Nivo Slider',
				);
			elseif( strpos( $list, 'select_effect' ) !== false ):
				if( strpos( $list, '_nivo' ) !== false ):
					$arr = array(
						'sliceDown' => 'Slice Down',
						'sliceDownLeft' => 'Slice Down Left',
						'sliceUp' => 'Slice Up',
						'sliceUpLeft' => 'Slice Up Left',
						'sliceUpDown' => 'Slice Up Down',
						'sliceUpDownLeft' => 'Slice Up Down Left',
						'fold' => 'Fold',
						'fade' => 'Fade',
						'random' => 'Random',
						'slideInRight' => 'Slide In Right',
						'slideInLeft' => 'Slide In Left',
						'boxRandom' => 'Box Random',
						'boxRain' => 'Box Rain',
						'boxRainReverse' => 'Box Rain Reverse',
						'boxRainGrow' => 'Box Rain Grow',
						'boxRainGrowReverse' => 'Box Rain Grow Reverse'
					);
				endif;			
			elseif( strpos( $list, 'select_ease' ) !== false ):
				$arr = array(
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

			if( $get )
				return ( isset( $arr[ $get ] ) ? $arr[ $get ] . $separator : '' );

			return $arr;

        }
    }

// *****************************************************
// *      INCLUDE ACF PLUGIN
// *****************************************************

    include( SCM_DIR_ACF_PLUGIN . 'acf.php' );

?>
