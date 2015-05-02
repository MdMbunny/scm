<?php

	if ( ! function_exists( 'scm_content_preset_size' ) ) {
        function scm_content_preset_size( $size, $units, $fall = '', $fall2 = 'px' ) {

			$units = is( $units, $fall2 );
	    	$size = ifexists( $size, $fall );
	 		$size = ( is_numeric( $size ) ? $size . $units : ifequal( $size, array( 'auto', 'initial', 'inherit' ), $fall ) );

	 		return $size;

	    }
	}

	if ( ! function_exists( 'scm_content_preset_rgba' ) ) {
        function scm_content_preset_rgba( $color, $alpha, $fall = '', $fall2 = 1 ) {

			$alpha = isNumber( $alpha, $fall2 );
	    	$color = is( $color, $fall );
	 		$color = ifequal( $color, array( '', 'transparent', 'initial', 'inherit', 'none' ), hex2rgba( $color, $alpha ) );

	 		return $color;

	    }
	}

	if ( ! function_exists( 'scm_content_preset_marker' ) ) {
        function scm_content_preset_marker( $luogo, $fields = array(), $mark = 0 ) {

			$marker = is( $fields['luogo-mappa-icon'], 'default' );
			$icon = array( 'icon' => 'fa-map-marker', 'data' => '#000000' );

			switch ( $marker ) {
				case 'icon':
					$fa = is( $fields['luogo-mappa-icon-fa'], 'fa-map-marker' );
					$color = scm_content_preset_rgba( is( $fields['luogo-mappa-rgba-color'], '#e3695f' ), is( $fields['luogo-mappa-rgba-alpha'], 1 ) );
					$icon = array( 'icon' => $fa, 'data' => $color );
					$marker = ' data-icon="' . $fa . '" data-icon-color="' . $color . '"';
				break;

				case 'img':
					$img = is( $fields['luogo-mappa-icon-img'], '' );
					$icon = array( 'icon' => $img, 'data' => 'img' );
					$marker = ( $img ? ' data-img="' . $img . '"' : '' );
				break;
				
				default:
					$term = wp_get_post_terms( $luogo, 'luoghi-tip' );
					
					if( !$term || !sizeof( $term ) )

					$term_field = ( $term && sizeof( $term ) ? get_fields( $term[0] ) : array() );
					$marker = ( is( $term_field ) ? is( $term_field['luogo-tip-mappa-icon'], 'default' ) : 'default' );
					switch ( $marker ) {
						case 'icon':
							$fa = is( $term_field['luogo-tip-mappa-icon-fa'], 'fa-map-marker' );
							$color = scm_content_preset_rgba( is( $term_field['luogo-tip-mappa-rgba-color'], '#e3695f' ), is( $term_field['luogo-tip-mappa-rgba-alpha'], 1 ) );
							$icon = array( 'icon' => $fa, 'data' => $color );
							$marker = ' data-icon="' . $fa . '" data-icon-color="' . $color . '"';
						break;

						case 'img':
							$img = is( $term_field['luogo-tip-mappa-icon-img'], '' );
							$icon = array( 'icon' => $img, 'data' => 'img' );
							$marker = ( $img ? ' data-img="' . $img . '"' : '' );
						break;
						
						default:
							$marker = scm_field( 'opt-tools-mappa-icon', 'icon', 'option' );
							switch ( $marker ) {
								case 'icon':
									$fa = scm_field( 'opt-tools-mappa-icon-fa', 'fa-map-marker', 'option' );
									$color = scm_content_preset_rgba( scm_field( 'opt-tools-mappa-rgba-color', '#e3695f', 'option' ), scm_field( 'opt-tools-mappa-rgba-alpha', 1, 'option' ) );
									$icon = array( 'icon' => $fa, 'data' => $color );
									$marker = ' data-icon="' . $fa . '" data-icon-color="' . $color . '"';
								break;

								case 'img':
									$img = scm_field( 'opt-tools-mappa-icon-img', '', 'option' );
									$icon = array( 'icon' => $img, 'data' => 'img' );
									$marker = ( $img ? ' data-img="' . $img . '"' : '' );
								break;
							}

						break;
					}

				break;
			}

			if( $mark )
			 	return $marker;

			return $icon;

	    }
	}

?>