<?php
/**
 * @package SCM
 */

// *****************************************************
// *    SCM OPTIONS
// *****************************************************

/*
*****************************************************
*
*   1.0 Set Options
*   2.0 Get Options
*   3.0 Options
*
*****************************************************
*/

// *****************************************************
// *      1.0 SET OPTIONS
// *****************************************************

	if ( ! function_exists( 'scm_options_set' ) ) {
        function scm_options_set( $target = '', $separator = '_' ) {

            if( is_int( $target ) || $target == 'option' ) {
                return array( 'type' => '', 'target' => $target );
            }elseif( is_array( $target ) ) {
            	return array( 'type' => $target['type'], 'target' => $target['target'] );
            }elseif( is_string( $target ) ) {
                return array( 'type' => $separator . $target, 'target' => 'option' );
            }

            return array( 'type' => false, 'target' => false );
        }
    }

// *****************************************************
// *      2.0 GET OPTIONS
// *****************************************************

    if ( ! function_exists( 'scm_options_get' ) ) {
        function scm_options_get( $option, $target = 'option', $add = false, $units = '%' ) {

        	if( !$option )
        		return '';

	        $target = scm_options_set( $target );
	        $type = $target['type'];
	        $target = $target['target'];

	        switch ( $option ) {
	        	case 'align':
	        	case 'text_align':
	        	case 'text-align':
	        	case 'txt_alignment':
	        	case 'txt-alignment':
	        		return scm_options_get_align( $type, $target, $add, $units );
	        	break;

	        	case 'size':
	        	case 'text_size':
	        	case 'text-size':
	        	case 'txt_size':
	        	case 'txt-size':
	        	case 'font_size':
	        	case 'font-size':
	        	case 'txt_font_size':
	        	case 'txt-font-size':
	        		return scm_options_get_size( $type, $target, $add, $units );
	        	break;

	        	case 'font':
	        	case 'fonts':
	        	case 'font_family':
	        	case 'font-family':
	        	case 'webfont':
	        	case 'webfonts':
	        		return scm_options_get_fonts( $type, $target, $add, $units );
	        	break;

	        	case 'color':
	        	case 'text_color':
	        	case 'text-color':
	        		return scm_options_get_color( $type, $target, $add, $units );
	        	break;

	        	case 'shadow':
	        	case 'text_shadow':
	        	case 'text-shadow':
	        		return scm_options_get_shadow( $type, $target, $add, $units );
	        	break;

	        	case 'weight':
	        	case 'font_weight':
	        	case 'font-weight':
	        	case 'text_weight':
	        	case 'text-weight':
	        		return scm_options_get_weight( $type, $target, $add, $units );
	        	break;

	        	case 'line_height':
	        	case 'line-height':
	        	case 'after':
	        	case 'space_after':
	        	case 'space-after':
	        		return scm_options_get_line_height( $type, $target, $add, $units );
	        	break;

	        	case 'background_image':
	        	case 'background-image':
	        	case 'bg_image':
	        	case 'bg-image':
	        		return scm_options_get_bg_image( $type, $target, $add, $units );
	        	break;

	        	case 'background_repeat':
	        	case 'background-repeat':
	        	case 'bg_repeat':
	        	case 'bg-repeat':
	        		return scm_options_get_bg_repeat( $type, $target, $add, $units );
	        	break;

	        	case 'background_position':
	        	case 'background-position':
	        	case 'bg_position':
	        	case 'bg-position':
	        		return scm_options_get_bg_position( $type, $target, $add, $units );
	        	break;

	        	case 'background_size':
	        	case 'background-size':
	        	case 'bg_size':
	        	case 'bg-size':
	        		return scm_options_get_bg_size( $type, $target, $add, $units );
	        	break;

	        	case 'background_color':
	        	case 'background-color':
	        	case 'bg_color':
	        	case 'bg-color':
	        		return scm_options_get_bg_color( $type, $target, $add, $units );
	        	break;

	        	case 'opacity':
	        		return scm_options_get_opacity( $type, $target, $add, $units );
	        	break;

	        	case 'margin':
	        		return scm_options_get_margin( $type, $target, $add, $units );
	        	break;

	        	case 'padding':
	        		return scm_options_get_padding( $type, $target, $add, $units );
	        	break;
	        	
	        	default:
	        		return '';
	        	break;
	        }
        }
    }

// *****************************************************
// *      3.0 OPTIONS
// *****************************************************

    if ( ! function_exists( 'scm_options_get_align' ) ) {
        function scm_options_get_align( $type = '', $target = 'option', $add = false ) {
			
			$align = scm_field( 'select_txt_alignment' . $type, '', $target, 1 );
        	
        	if( !$align && ( $type || $target != 'option' ) )
        		return '';

        	$align = ( $align ? $align : 'left' );

            return ( !$add ? $align : 'text-align:' . $align . ';' );

        }
    }

    if ( ! function_exists( 'scm_options_get_size' ) ) {
        function scm_options_get_size( $type = '', $target = 'option', $add = false ) {

        	if( $type || $target != 'option' ){
                $size = ( get_field( 'select_txt_size' . $type, $target ) ?: 'default' );
                $size = ( $size == 'default' ? $size : $size . '%' );
			}else{
                $obj = get_field_object( 'select_txt_size' . $type, $target );
                
               if( !$obj )
                    return '';
                
                $value = $obj['value'];
                $choices = $obj['choices'];
                $label = $choices[ $value ];
                $sizes = scm_acf_field_choices_preset( 'select_txt_font_size' );
                $size = getByValue( $sizes, $label );
            }

        	if( $size == 'default' ){
        		if( $type || $target != 'option' )
	        		return '';
	        	$size = '';
	        }

        	$size = ( $size ?: '16px' );

			return ( !$add ? $size : 'font-size:' . $size . ';' );

        }
    }

    if ( ! function_exists( 'scm_options_get_fonts' ) ) {
        function scm_options_get_fonts( $type = '', $target = 'option', $add = false ) {

            $webfont = ( get_field( 'select_webfonts_google' . $type, $target ) ?: 'default' );
            $family = ( get_field( 'select_webfonts_fallback' . $type, $target ) ?: 'default' );

            if( $webfont == 'default' && ( $type || $target != 'option' ) ){

            	if( $family == 'default' )
            		return '';

            	$webfont = ( get_field( 'select_webfonts_google', 'option' ) ?: '' );

			}

			if( $family == 'default' && ( $type || $target != 'option' ) )
				$family = get_field( 'select_webfonts_defult_families', 'option' );
            
            return font2string( $webfont, $family, $add ) ;

        }
    }

    if ( ! function_exists( 'scm_options_get_color' ) ) {
        function scm_options_get_color( $type = '', $target = 'option', $add = false ) {

        	$alpha = ( get_field('text_alpha' . $type, $target) ?: '' );
        	$color = ( get_field('text_color' . $type, $target) ?: '' );
        	
        	if( !$color && ( $type || $target != 'option' ) )
        		return '';

            $color = hex2rgba( ( $color ?: '#000000' ), $alpha );

            return ( !$add ? $color : 'color:' . $color . ';' );

        }
    }

    if ( ! function_exists( 'scm_options_get_line_height' ) ) {
        function scm_options_get_line_height( $type = '', $target = 'option', $add = false, $units = '%' ) {
			
			if( $units == '%' )
				$line_height = ( get_field( 'select_line_height' . $type, $target ) != 'default' ? (string)(100 * (float)get_field( 'select_line_height' . $type, $target )) : '' );
			else
				$line_height = scm_field( 'select_line_height' . $type, '', $target, 1 );
        	
        	if( !$line_height && ( $type || $target != 'option' ) )
        		return '';

        	$line_height = ( $line_height ? $line_height . $units : '150%' );

            return ( !$add ? $line_height : 'line-height:' . $line_height . ';' );

        }
    }

    if ( ! function_exists( 'scm_options_get_weight' ) ) {
        function scm_options_get_weight( $type = '', $target = 'option', $add = false ) {

			$weight = scm_field( 'select_font_weight' . $type, '', $target, 1 );

        	if( !$weight && ( $type || $target != 'option' ) )
        		return '';

        	$weight = ( $weight ?: '400' );

            return ( !$add ? $weight : 'font-weight:' . $weight . ';' );

        }
    }

    if ( ! function_exists( 'scm_options_get_shadow' ) ) {
        function scm_options_get_shadow( $type = '', $target = 'option', $add = false ) {

        	$shadow = ( scm_field( 'select_disable_text_shadow' . $type, $target) ?: 'none' );

			if( $shadow === 'none' || $shadow === 'default' ){

				if( $type || $target != 'option' )
        			return '';

        	}else if( $shadow === 'off' ){

                $shadow = 'none';

            }else{

        		$shadow_x = ( get_field('text_shadow_x' . $type, $target) ?: '0' ) . 'px';
	        	$shadow_y = ( get_field('text_shadow_y' . $type, $target) ?: '0' ) . 'px';
	        	$shadow_size = ( get_field('text_shadow_size' . $type, $target) ?: '0' ) . 'px';
	        	$shadow_alpha = ( get_field('text_shadow_alpha' . $type, $target) ?: '0' );
	        	$shadow_color = ( get_field('text_shadow_color' . $type, $target) ?: '#000000' );
	        	$shadow = $shadow_x . ' ' . $shadow_y . ' ' . $shadow_size . ' ' . hex2rgba( $shadow_color, $shadow_alpha );

        	}

            return ( !$add ? $shadow : 'text-shadow:' . $shadow . ';' );

        }
    }
	
	if ( ! function_exists( 'scm_options_get_opacity' ) ) {
        function scm_options_get_opacity( $type = '', $target = 'option', $add = false ) {

			$opacity = get_field('opacity' . $type, $target);
        	if( !is_string( $opacity && ( $type || $target != 'option' ) ) )
        		return '';

        	$opacity = ( $opacity ?: '1' );

            return ( !$add ? $opacity : 'opacity:' . $opacity . ';' );

        }
    }

    if ( ! function_exists( 'scm_options_get_margin' ) ) {
        function scm_options_get_margin( $type = '', $target = 'option', $add = false ) {

			$margin = get_field('margin' . $type, $target);

        	if( !$margin && ( $type || $target != 'option' ) )
        		return '';

        	$margin = ( $margin ?: '0' );

            return ( !$add ? $margin : 'margin:' . $margin . ';' );

        }
    }

    if ( ! function_exists( 'scm_options_get_padding' ) ) {
        function scm_options_get_padding( $type = '', $target = 'option', $add = false ) {

			$padding = get_field('padding' . $type, $target);

        	if( !$padding && ( $type || $target != 'option' ) )
        		return '';

        	$padding = ( $padding ?: '0' );

            return ( !$add ? $padding : 'padding:' . $padding . ';' );

        }
    }

    if ( ! function_exists( 'scm_options_get_bg_image' ) ) {
        function scm_options_get_bg_image( $type = '', $target = 'option', $add = false ) {

			$bg_image = scm_field( 'background_image' . $type, 'none', $target, 1 );

			if( $bg_image === 'none' ){
                if( $type || $target !== 'option' )
				    return '';
            }else{
                $bg_image = 'url(' . $bg_image . ')';
            }

			return ( !$add ? $bg_image : 'background-image:' . $bg_image . ';' );

		}
    }

	if ( ! function_exists( 'scm_options_get_bg_repeat' ) ) {
        function scm_options_get_bg_repeat( $type = '', $target = 'option', $add = false ) {

            $bg_repeat = ( get_field('select_bg_repeat' . $type, $target) ?: 'default' );
			$bg_repeat = ( $bg_repeat != 'default' ? $bg_repeat : 'no-repeat' );
			return ( !$add ? $bg_repeat : 'background-repeat:' . $bg_repeat . ';' );

		}
    }

	if ( ! function_exists( 'scm_options_get_bg_position' ) ) {
        function scm_options_get_bg_position( $type = '', $target = 'option', $add = false ) {
            
            $bg_position = ( get_field('select_bg_position' . $type, $target) ?: 'center center' );
            return ( !$add ? $bg_position : 'background-position:' . $bg_position . ';' );

        }
    }

	if ( ! function_exists( 'scm_options_get_bg_size' ) ) {
        function scm_options_get_bg_size( $type = '', $target = 'option', $add = false ) {

            $bg_size = ( get_field('background_size' . $type, $target) ?: 'default' );
            $bg_size = ( $bg_size != 'default' ? $bg_size : 'auto' );
            return ( !$add ? $bg_size : 'background-size:' . $bg_size . ';' );

        }
    }

	if ( ! function_exists( 'scm_options_get_bg_color' ) ) {
        function scm_options_get_bg_color( $type = '', $target = 'option', $add = false ) {

            $bg_alpha = ( get_field('background_alpha' . $type, $target) ?: '' );
            $bg_color = ( get_field('background_color' . $type, $target) ? hex2rgba( get_field( 'background_color' . $type, $target ), $bg_alpha ) : 'transparent' );

            if( $bg_color == 'transparent' && ( $type || $target != 'option' ) )
				return '';

            return ( !$add ? $bg_color : 'background-color:' . $bg_color . ';' );

        }
    }
	
    if ( ! function_exists( 'scm_options_get_style' ) ) {
        function scm_options_get_style( $target = 'option', $add = 0, $type = '' ) {

            if( !$target )
                return '';

            if( strpos( $type, '_' ) === 0 ){

                $bg_image = scm_options_get( 'bg_image', array( 'target' => $target, 'type' => $type ), 1 );
                $bg_repeat = ( $bg_image ? scm_options_get( 'bg_repeat', array( 'target' => $target, 'type' => $type ), 1 ) : '' );
                $bg_position = ( $bg_image ? scm_options_get( 'bg_position', array( 'target' => $target, 'type' => $type ), 1 ) : '' );
                $bg_size = ( $bg_image ? scm_options_get( 'bg_size', array( 'target' => $target, 'type' => $type ), 1 ) : '' );
                $bg_color = scm_options_get( 'bg_color', array( 'target' => $target, 'type' => $type ), 1 );

                $style = $bg_color . $bg_image . $bg_repeat . $bg_position . $bg_size;

            }else{

                if( $type != 'bg' ){

                	$align = scm_options_get( 'align', $target, 1 );
                    $size = scm_options_get( 'size', $target, 1 );

                    $font = scm_options_get( 'font', $target, 1 );

                    $color = scm_options_get( 'color', $target, 1 );
                    $line_height = scm_options_get( 'line_height', $target, 1 );
                    $weight = scm_options_get( 'weight', $target, 1 );
                    
                    $opacity = scm_options_get( 'opacity', $target, 1 );
                    $shadow = scm_options_get( 'shadow', $target, 1 );
                    $margin = scm_options_get( 'margin', $target, 1 );
                    $padding = scm_options_get( 'padding', $target, 1 );

                    $style = $align . $size . $font . $color . $line_height . $weight . $opacity . $shadow . $margin . $padding;

                }

                if( $type != 'nobg' ){

                    $bg_image = scm_options_get( 'bg_image', $target, 1 );
                	$bg_repeat = ( $bg_image ? scm_options_get( 'bg_repeat', $target, 1 ) : '' );
                    $bg_position = ( $bg_image ? scm_options_get( 'bg_position', $target, 1 ) : '' );
                    $bg_size = ( $bg_image ? scm_options_get( 'bg_size', $target, 1 ) : '' );
                    $bg_color = scm_options_get( 'bg_color', $target, 1 );

                    $style .= $bg_color . $bg_image . $bg_repeat . $bg_position . $bg_size;

                }
            }
            
            if( !$style )
            	return '';

            return ( !$add ? $style : ' style="' . $style . '"' );

        }
    }


?>