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

			$marker = ( isset( $fields['luogo-map-icon'] ) ? $fields['luogo-map-icon'] : 'default' );
			
			$icon = array( 'icon' => 'fa-map-marker', 'data' => '#000000' );

			switch ( $marker ) {
				case 'icon':
					$fa = is( $fields['luogo-map-icon-fa'], 'fa-map-marker' );
					$color = scm_content_preset_rgba( is( $fields['luogo-map-rgba-color'], '#e3695f' ), is( $fields['luogo-map-rgba-alpha'], 1 ) );
					$icon = array( 'icon' => $fa, 'data' => $color );
					$marker = ' data-icon="' . $fa . '" data-icon-color="' . $color . '"';
				break;

				case 'img':
					$img = is( $fields['luogo-map-icon-img'], '' );
					$icon = array( 'icon' => $img, 'data' => 'img' );
					$marker = ( $img ? ' data-img="' . $img . '"' : '' );
				break;
				
				default:
					$term = wp_get_post_terms( $luogo, 'luoghi-tip' );
					
					if( !$term || !sizeof( $term ) )

					$term_field = ( $term && sizeof( $term ) ? get_fields( $term[0] ) : array() );
					$marker = ( ( isset( $term_field ) && $term_field ) ? ( isset( $term_field['luogo-tip-map-icon'] ) ? $term_field['luogo-tip-map-icon'] : 'default' ) : 'default' );
					switch ( $marker ) {
						case 'icon':
							$fa = is( $term_field['luogo-tip-map-icon-fa'], 'fa-map-marker' );
							$color = scm_content_preset_rgba( is( $term_field['luogo-tip-map-rgba-color'], '#e3695f' ), is( $term_field['luogo-tip-map-rgba-alpha'], 1 ) );
							$icon = array( 'icon' => $fa, 'data' => $color );
							$marker = ' data-icon="' . $fa . '" data-icon-color="' . $color . '"';
						break;

						case 'img':
							$img = is( $term_field['luogo-tip-map-icon-img'], '' );
							$icon = array( 'icon' => $img, 'data' => 'img' );
							$marker = ( $img ? ' data-img="' . $img . '"' : '' );
						break;
						
						default:
							$marker = scm_field( 'opt-tools-map-icon', 'icon', 'option' );
							switch ( $marker ) {
								case 'icon':
									$fa = scm_field( 'opt-tools-map-icon-fa', 'fa-map-marker', 'option' );
									$color = scm_content_preset_rgba( scm_field( 'opt-tools-map-rgba-color', '#e3695f', 'option' ), scm_field( 'opt-tools-map-rgba-alpha', 1, 'option' ) );
									$icon = array( 'icon' => $fa, 'data' => $color );
									$marker = ' data-icon="' . $fa . '" data-icon-color="' . $color . '"';
								break;

								case 'img':
									$img = scm_field( 'opt-tools-map-icon-img', '', 'option' );
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