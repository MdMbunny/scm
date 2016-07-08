<?php

/**
* scm-content-options.php.
*
* SCM options functions.
*
* @link http://www.studiocreativo-m.it
*
* @package SCM
* @subpackage Content/Options
* @since 1.0.0
*/

// ------------------------------------------------------
//
// 1.0 STYLE OPTIONS
//      1.1 Set Style Options
//      1.2 Get Style Options
//      1.3 Get Style Option
//      1.4 Get Style
//
// ------------------------------------------------------

// ------------------------------------------------------
// 1.0 STYLE OPTIONS
// ------------------------------------------------------
// ------------------------------------------------------
// 1.1 SET STYLE OPTIONS
// ------------------------------------------------------

/**
* [GET] Setup style option
*
* @param {string=} target Option target (default is '').
* @param {string=} separator Separator in case target is string (default is '-').
* @return {array} Array containing 'type' and 'target' attributes.
*/
function scm_options_set( $target = '', $separator = '-' ) {

    if( is_int( $target ) || $target == 'option' ) {
        return array( 'type' => '', 'target' => $target );
    }elseif( is_array( $target ) ) {
    	return array( 'type' => $target['type'], 'target' => $target['target'] );
    }elseif( is_string( $target ) ) {
        return array( 'type' => $target . $separator, 'target' => 'option' );
    }

    return array( 'type' => false, 'target' => false );
}

// ------------------------------------------------------
// 1.2 GET STYLE OPTIONS
// ------------------------------------------------------

/**
* [GET] Style option
*
* @param {string} option Option name.
* @param {string=} target Option target (default is 'option').
* @param {bool=} add Wrap result in style property (default is false).
* @return {misc|string} Result or result wrapped in style property if add is true.
*/
function scm_options_get( $option = NULL, $target = 'option', $add = false ) {

	if( is_null( $option ) ) return '';

    $target = scm_options_set( $target );
    $type = $target['type'];
    $target = $target['target'];

    switch ( $option ) {
    	case 'align':
    	case 'text_align':
    	case 'text-align':
    	case 'txt_alignment':
    	case 'txt-alignment':
    		return scm_options_get_align( $type, $target, $add );
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
    		return scm_options_get_size( $type, $target, $add );
    	break;

    	case 'font':
    	case 'fonts':
    	case 'font_family':
    	case 'font-family':
    	case 'webfont':
    	case 'webfonts':
    		return scm_options_get_fonts( $type, $target, $add );
    	break;

    	case 'color':
    	case 'text_color':
    	case 'text-color':
    		return scm_options_get_color( $type, $target, $add );
    	break;

    	case 'shadow':
    	case 'text_shadow':
    	case 'text-shadow':
    		return scm_options_get_shadow( $type, $target, $add );
    	break;

    	case 'weight':
    	case 'font_weight':
    	case 'font-weight':
    	case 'text_weight':
    	case 'text-weight':
    		return scm_options_get_weight( $type, $target, $add );
    	break;

    	case 'line_height':
    	case 'line-height':
    	case 'after':
    	case 'space_after':
    	case 'space-after':
    		return scm_options_get_line_height( $type, $target, $add );
    	break;

    	case 'background_image':
    	case 'background-image':
    	case 'bg_image':
    	case 'bg-image':
    		return scm_options_get_bg_image( $type, $target, $add );
    	break;

    	case 'background_repeat':
    	case 'background-repeat':
    	case 'bg_repeat':
    	case 'bg-repeat':
    		return scm_options_get_bg_repeat( $type, $target, $add );
    	break;

    	case 'background_position':
    	case 'background-position':
    	case 'bg_position':
    	case 'bg-position':
    		return scm_options_get_bg_position( $type, $target, $add );
    	break;

    	case 'background_size':
    	case 'background-size':
    	case 'bg_size':
    	case 'bg-size':
    		return scm_options_get_bg_size( $type, $target, $add );
    	break;

    	case 'background_color':
    	case 'background-color':
    	case 'bg_color':
    	case 'bg-color':
    		return scm_options_get_bg_color( $type, $target, $add );
    	break;

    	case 'opacity':
    		return scm_options_get_opacity( $type, $target, $add );
    	break;

    	case 'margin':
    		return scm_options_get_margin( $type, $target, $add );
    	break;

    	case 'padding':
    		return scm_options_get_padding( $type, $target, $add );
    	break;
    	
    	default:
    		return '';
    	break;
    }
}

// ------------------------------------------------------
// 1.3 GET STYLE OPTION
// ------------------------------------------------------

/**
* [GET] Align style option
*
* @param {string=} type Option prefix (default is '').
* @param {string=} target Option target (default is 'option').
* @param {bool=} add Wrap result in style property (default is false).
* @return {misc|string} Result or result wrapped in style property if add is true.
*/
function scm_options_get_align( $type = '', $target = 'option', $add = false ) {
	$align = scm_field( is( $type, 'style-txt-' ) . 'set-alignment', '', $target, 1 );
	
	if( !$align && ( $type || $target != 'option' ) )
		return '';

	$align = ( $align ? $align : 'left' );

    return ( !$add ? $align : 'text-align:' . $align . ';' );
}

/**
* [GET] Size style option
*
* @param {string=} type Option prefix (default is '').
* @param {string=} target Option target (default is 'option').
* @param {bool=} add Wrap result in style property (default is false).
* @return {misc|string} Result or result wrapped in style property if add is true.
*/
function scm_options_get_size( $type = '', $target = 'option', $add = false ) {
	if( $type || $target != 'option' ){
        $size = ( get_field( is( $type, 'style-txt-' ) . 'set-size', $target ) ?: 'default' );
	}else{

        $obj = get_field_object( is( $type, 'style-txt-' ) . 'set-size', $target );

        if( !$obj )
            return '';

        $value = $obj['value'];
        $choices = $obj['choices'];
        $label = $choices[ $value ];

        $sizes = scm_acf_field_choices_preset( 'txt_font_size' );
        $size = getByValue( str_replace( ' ', '', $sizes ), str_replace( ' ', '', $label ) );
    }

	if( $size == 'default' ){
		if( $type || $target != 'option' )
    		return '';
    	$size = '';
    }

	$size = ( $size ?: '16px' );

	return ( !$add ? $size : 'font-size:' . $size . ';' );
}

/**
* [GET] Fonts style option
*
* @param {string=} type Option prefix (default is '').
* @param {string=} target Option target (default is 'option').
* @param {bool=} add Wrap result in style property (default is false).
* @return {misc|string} Result or result wrapped in style property if add is true.
*/
function scm_options_get_fonts( $type = '', $target = 'option', $add = false ) {
    $adobe = ( get_field( is( $type, 'style-txt-' ) .  'webfonts-adobe', $target ) ?: 'default' );
    $google = ( get_field( is( $type, 'style-txt-' ) .  'webfonts-google', $target ) ?: 'default' );
    $family = ( get_field( is( $type, 'style-txt-' ) .  'webfonts-fallback', $target ) ?: 'default' );

    if( $adobe == 'default' && ( $type || $target != 'option' ) ){

        if( $google == 'default' && $family == 'default' )
            return '';

        $adobe = ( get_field( is( $type, 'style-txt-' ) .  'webfonts-adobe', 'option' ) ?: '' );
    }

    if( $google == 'default' && ( $type || $target != 'option' ) ){

    	if( $family == 'default' )
    		return '';

    	$google = ( get_field( is( $type, 'style-txt-' ) .  'webfonts-google', 'option' ) ?: '' );
	}

	if( $family == 'default' && ( $type || $target != 'option' ) )
		$family = get_field( is( $type, 'style-txt-' ) .  'webfonts-fallback', 'option' );

    return font2string( array( $adobe, $google ), $family, $add ) ;
}

/**
* [GET] Color style option
*
* @param {string=} type Option prefix (default is '').
* @param {string=} target Option target (default is 'option').
* @param {bool=} add Wrap result in style property (default is false).
* @return {misc|string} Result or result wrapped in style property if add is true.
*/
function scm_options_get_color( $type = '', $target = 'option', $add = false ) {
	$alpha = ( get_field( is( $type, 'style-txt-' ) .  'rgba-alpha', $target) ?: 1 );
	$color = ( get_field( is( $type, 'style-txt-' ) .  'rgba-color', $target) ?: '' );
	
	if( !$color && ( $type || $target != 'option' ) )
		return '';

    $color = hex2rgba( ( $color ?: '#000000' ), $alpha );

    return ( !$add ? $color : 'color:' . $color . ';' );
}

/**
* [GET] Line height style option
*
* @param {string=} type Option prefix (default is '').
* @param {string=} target Option target (default is 'option').
* @param {bool=} add Wrap result in style property (default is false).
* @param {string=} units Option units (default is '%').
* @return {misc|string} Result or result wrapped in style property if add is true.
*/
function scm_options_get_line_height( $type = '', $target = 'option', $add = false, $units = '%' ) {
	if( $units == '%' )
		$line_height = ( get_field( is( $type, 'style-txt-' ) .  'set-line-height', $target ) != 'default' ? (string)(100 * (float)str_replace( array('-',','), '.', get_field( is( $type, 'style-txt-' ) .  'set-line-height', $target ))) : '' );
	else
		$line_height = scm_field( is( $type, 'style-txt-' ) .  'set-line-height', '', $target, 1 );

	if( !$line_height && ( $type || $target != 'option' ) )
		return '';

	$line_height = ( $line_height ? $line_height . $units : '150%' );

    return ( !$add ? $line_height : 'line-height:' . $line_height . ';' );
}

/**
* [GET] Weight style option
*
* @param {string=} type Option prefix (default is '').
* @param {string=} target Option target (default is 'option').
* @param {bool=} add Wrap result in style property (default is false).
* @return {misc|string} Result or result wrapped in style property if add is true.
*/
function scm_options_get_weight( $type = '', $target = 'option', $add = false ) {
	$weight = scm_field( is( $type, 'style-txt-' ) .  'set-weight', '', $target, 1 );

	if( !$weight && ( $type || $target != 'option' ) )
		return '';

	$weight = ( $weight ?: 'normal' );

    return ( !$add ? $weight : 'font-weight:' . $weight . ';' );
}

/**
* [GET] Shadow style option
*
* @param {string=} type Option prefix (default is '').
* @param {string=} target Option target (default is 'option').
* @param {bool=} add Wrap result in style property (default is false).
* @return {misc|string} Result or result wrapped in style property if add is true.
*/
function scm_options_get_shadow( $type = '', $target = 'option', $add = false ) {
	$shadow = ( get_field( is( $type, 'style-txt-' ) .  'shadow', $target) ?: 'none' );

	if( $shadow === 'none' || $shadow === 'default' ){
		if( $type || $target != 'option' )
            return '';
	}else if( !$shadow || $shadow === 'off' ){
        $shadow = 'none';
    }else{
		$shadow_x = ( get_field( is( $type, 'style-txt-' ) .  'shadow-x-number', $target) ?: '0' ) . ( get_field( is( $type, 'style-txt-' ) .  'shadow-x-units', $target) ?: 'px' );
    	$shadow_y = ( get_field( is( $type, 'style-txt-' ) .  'shadow-y-number', $target) ?: '0' ) . ( get_field( is( $type, 'style-txt-' ) .  'shadow-y-units', $target) ?: 'px' );
    	$shadow_size = ( get_field( is( $type, 'style-txt-' ) .  'shadow-size-number', $target) ?: '0' ) . ( get_field( is( $type, 'style-txt-' ) .  'shadow-x-units', $target) ?: 'px' );
    	$shadow_alpha = ( get_field( is( $type, 'style-txt-' ) .  'shadow-rgba-alpha', $target) ?: '0' );
    	$shadow_color = ( get_field( is( $type, 'style-txt-' ) .  'shadow-rgba-color', $target) ?: '#000000' );
    	$shadow = $shadow_x . ' ' . $shadow_y . ' ' . $shadow_size . ' ' . hex2rgba( $shadow_color, $shadow_alpha );
	}

    return ( !$add ? $shadow : 'text-shadow:' . $shadow . ';' );
}

/**
* [GET] Opacity style option
*
* @param {string=} type Option prefix (default is '').
* @param {string=} target Option target (default is 'option').
* @param {bool=} add Wrap result in style property (default is false).
* @return {misc|string} Result or result wrapped in style property if add is true.
*/
function scm_options_get_opacity( $type = '', $target = 'option', $add = false ) {
	$opacity = get_field( is( $type, 'style-box-' ) . 'alpha', $target);
	if( !is_string( $opacity && ( $type || $target != 'option' ) ) )
		return '';

	$opacity = ( $opacity ?: '1' );

    return ( !$add ? $opacity : 'opacity:' . $opacity . ';' );
}

/**
* [GET] Margin style option
*
* @param {string=} type Option prefix (default is '').
* @param {string=} target Option target (default is 'option').
* @param {bool=} add Wrap result in style property (default is false).
* @return {misc|string} Result or result wrapped in style property if add is true.
*/
function scm_options_get_margin( $type = '', $target = 'option', $add = false ) {
	$margin = get_field( is( $type, 'style-box-' ) . 'margin', $target);

	if( !$margin && ( $type || $target != 'option' ) )
		return '';

	$margin = ( $margin ?: '0' );
    return ( !$add ? $margin : 'margin:' . $margin . ';' );
}

/**
* [GET] Padding style option
*
* @param {string=} type Option prefix (default is '').
* @param {string=} target Option target (default is 'option').
* @param {bool=} add Wrap result in style property (default is false).
* @return {misc|string} Result or result wrapped in style property if add is true.
*/
function scm_options_get_padding( $type = '', $target = 'option', $add = false ) {
	$padding = get_field( is( $type, 'style-box-' ) . 'padding', $target);

	if( !$padding && ( $type || $target != 'option' ) )
		return '';

	$padding = ( $padding ?: '0' );

    return ( !$add ? $padding : 'padding:' . $padding . ';' );
}

/**
* [GET] Bg image style option
*
* @param {string=} type Option prefix (default is '').
* @param {string=} target Option target (default is 'option').
* @param {bool=} add Wrap result in style property (default is false).
* @return {misc|string} Result or result wrapped in style property if add is true.
*/
function scm_options_get_bg_image( $type = '', $target = 'option', $add = false ) {
	$bg_image = scm_field( is( $type, 'style-bg-' ) . 'image', 'none', $target, 1 );

	if( $bg_image === 'none' ){
        if( $type || $target !== 'option' )
		    return '';
    }else{
        $bg_image = 'url(' . $bg_image . ')';
    }

	return ( !$add ? $bg_image : 'background-image:' . $bg_image . ';' );
}

/**
* [GET] Bg repeat style option
*
* @param {string=} type Option prefix (default is '').
* @param {string=} target Option target (default is 'option').
* @param {bool=} add Wrap result in style property (default is false).
* @return {misc|string} Result or result wrapped in style property if add is true.
*/
function scm_options_get_bg_repeat( $type = '', $target = 'option', $add = false ) {
    $bg_repeat = ( get_field( is( $type, 'style-bg-' ) . 'repeat', $target) ?: 'default' );
	$bg_repeat = ( $bg_repeat != 'default' ? $bg_repeat : 'no-repeat' );
	return ( !$add ? $bg_repeat : 'background-repeat:' . $bg_repeat . ';' );
}

/**
* [GET] Bg position style option
*
* @param {string=} type Option prefix (default is '').
* @param {string=} target Option target (default is 'option').
* @param {bool=} add Wrap result in style property (default is false).
* @return {misc|string} Result or result wrapped in style property if add is true.
*/
function scm_options_get_bg_position( $type = '', $target = 'option', $add = false ) {
    $bg_position = ( get_field( is( $type, 'style-bg-' ) . 'position', $target) ?: 'center center' );
    return ( !$add ? $bg_position : 'background-position:' . $bg_position . ';' );
}

/**
* [GET] Bg size style option
*
* @param {string=} type Option prefix (default is '').
* @param {string=} target Option target (default is 'option').
* @param {bool=} add Wrap result in style property (default is false).
* @return {misc|string} Result or result wrapped in style property if add is true.
*/
function scm_options_get_bg_size( $type = '', $target = 'option', $add = false ) {
    $bg_size = ( get_field( is( $type, 'style-bg-' ) . 'size', $target) ?: 'default' );
    $bg_size = ( $bg_size != 'default' ? $bg_size : 'auto' );
    return ( !$add ? $bg_size : 'background-size:' . $bg_size . ';' );
}

/**
* [GET] Bg color style option
*
* @param {string=} type Option prefix (default is '').
* @param {string=} target Option target (default is 'option').
* @param {bool=} add Wrap result in style property (default is false).
* @return {misc|string} Result or result wrapped in style property if add is true.
*/
function scm_options_get_bg_color( $type = '', $target = 'option', $add = false ) {
    $bg_alpha = ( get_field( is( $type, 'style-bg-' ) . 'rgba-alpha', $target) ?: 1 );
    $bg_color = ( get_field( is( $type, 'style-bg-' ) . 'rgba-color', $target) ? hex2rgba( get_field( is( $type, 'style-bg-' ) . 'rgba-color', $target ), $bg_alpha ) : 'transparent' );

    if( $bg_color == 'transparent' && ( $type || $target != 'option' ) )
        return '';

    return ( !$add ? $bg_color : 'background-color:' . $bg_color . ';' );
}

// ------------------------------------------------------
// 1.4 GET STYLE
// ------------------------------------------------------

/**
* [GET] Style from options
*
* @param {string=} target Options target or [bg|nobg] (default is 'option').
* @param {bool=} add Wrap result in style attribute (default is false).
* @param {string=} type Options prefix (default is '').
* @return {string} Result or result wrapped in style attribute if add is true.
*/
function scm_options_style( $target = 'option', $add = false, $type = '' ) {

    if( !$target ) return '';

    $style = '';

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

    return ( $style ? ( !$add ? $style : ' style="' . $style . '"' ) : '' );
}

?>