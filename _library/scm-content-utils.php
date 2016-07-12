<?php

/**
* SCM content utilities.
*
* @link http://www.studiocreativo-m.it
*
* @package SCM
* @subpackage 5-Content/UTILS
* @since 1.0.0
*/

// ------------------------------------------------------
//
// 1.0 DATA
// 2.0 CLASS
// 3.0 LINK
// 4.0 STYLE
//      3.1 Set Style
//      3.2 Get Style
//      3.3 Get Specific Style
//      3.4 Get All Styles
// 5.0 PRESET
//
// ------------------------------------------------------

// ------------------------------------------------------
// 1.0 DATA
// ------------------------------------------------------

/**
* [GET] Column data
*
* @param {int=} counter Column counter (default is 0).
* @param {int=} size Column counter size (default is 0).
* @return {array} Array containing 'count' and 'data'.
*/
function scm_utils_data_column( $counter = 0, $size = 0 ) {

    if( $counter == 1 && $size == 1 )
        return array( 'count' => 0, 'data' => 'solo' );
    elseif( $counter == $size || $counter > 1 )
        return array( 'count' => $counter, 'data' => 'first' );
    elseif( $counter == 1 )
        return array( 'count' => 0, 'data' => 'last' );
    else
        return array( 'count' => $counter, 'data' => 'middle' );
}

// ------------------------------------------------------
// 2.0 CLASS
// ------------------------------------------------------

/**
* [GET] Column class
*
* @param {int=} current Current column (default is 0).
* @param {int=} total Column total (default is 0).
* @return {string} String class.
*/
function scm_utils_class_count( $current = 0, $total = 0 ) {

    $class = '';

    if( $current == 1 )
        $class .= ' first';
    if( $current == $total )
        $class .= ' last';

    $class .= ' count-' . ( $current );

    return $class;
}

// ------------------------------------------------------
// 5.0 LINK
// ------------------------------------------------------

// ------------------------------------------------------
// 2.2 POST LINK
// ------------------------------------------------------


/**
* [GET] Post link function
*
* Hooks:
```php
// Filter $content before $link is built
$content = apply_filters( 'scm_filter_object_before_link_{$type}', $content, $id );

// Filter $link after $link is built
$link = apply_filters( 'scm_filter_object_after_link_{$type}', $link, $content, $id );
```
*
* @param {array} content Content array.
* @return {string} Post link.
*/
function scm_utils_link_post( $content = array(), $id = 0 ) {

    global $post;

    if( $id )
        $post = ( is_numeric( $id ) ? get_post( $id ) : $id );

    $type = $post->post_type;
    $id = $post->ID;
    $slug = $post->post_name;
    $link = '';

    $content = apply_filters( 'scm_filter_object_before_link_' . $type, $content, $id );

    switch ( $type ) {
        case 'soggetti':
            $link = ' data-href="' . scm_field( 'soggetto-link', '#', $id ) . '"';
        break;

        case 'luoghi':
            $link = ' data-open-marker="click"';
        break;

        case 'documenti':
            $link = ' data-href="' . scm_field( 'documento-file', '#', $id ) . '"';
        break;

        case 'rassegne-stampa':
            $typ = scm_field( 'rassegna-type', 'file', $id );
            $link = ' data-href="' . ( $typ == 'file' ? scm_field( 'rassegna-file', '#', $id ) : scm_field( 'rassegna-link', '#', $id ) ) . '"';
        break;

        case 'gallerie':
            $link = scm_utils_link_gallery( $content, 'galleria-images', $id );

        break;

        case 'video':
            $video = scm_field( 'video-url', '', $id );
            $video = ( strpos( $video, '/embed/' ) === false ? 'https://www.youtube.com/embed/' . substr( $video, strpos( $video, '=' ) + 1 ) : $video );
            $link = ' data-popup="' . htmlentities( json_encode( array( $video ) ) ) . '"';
            $link .= ' data-popup-type="video"';
            $link .= ' data-popup-title="' . get_the_title( $id ) . '"';

        break;

        case 'articoli':
        case 'news':
            $link = ' data-popup="' . htmlentities( json_encode( array( get_permalink() . ( $content['template'] ? '?template=' . $content['template'] : '' ) ) ) ) . '"';
            $link .= ' data-popup-content="' . ( $id ? '#post-' . $id : '' ) . '"';
            $link .= ' data-popup-type="load"';
        break;

        default:
            $link = apply_filters( 'scm_filter_object_link_' . $type, $link, $content, $id );
        break;
    }

    $link = apply_filters( 'scm_filter_object_after_link_' . $type, $link, $content, $id );

    return $link;
}

/**
* [GET] Post link gallery function
*
* @param {array} content Content array.
* @param {string=} field Gallery field name (default is 'galleria-images').
* @param {int=} id Optional post ID (default is current post ID).
* @return {string} Post link.
*/
function scm_utils_link_gallery( $content = array(), $field = 'galleria-images', $id = 0 ) {

    global $post;

    if( $id )
        $post = ( is_numeric( $id ) ? get_post( $id ) : $id );

    $type = $post->post_type;
    $id = $post->ID;
    $slug = $post->post_name;
    $link = '';

        $init = scm_utils_link_gallery_helper( $content, 'thumb' );
        if( $init == -1 )
            return '';
        $stored = scm_field( $field, array(), $id );
        if( !$stored )
            $stored = array();
        $images = array();
        $path = ( sizeof( $stored ) ? substr( $stored[0]['url'], 0, strpos( $stored[0]['url'], '/' . $type . '/' ) + strlen($type) + 2 ) : '' );

        foreach ( $stored as $image )
            $images[] = array( 'url' => str_replace( $path, '', $image['url'] ), 'title' => $image['title'], 'caption' => $image['caption'], 'alt' => $image['alt'], 'date' => $image['date'], 'modified' => $image['modified'], 'filename' => $image['filename'], 'type' => $image['mime_type'] );

        $link = ' data-popup="' . htmlentities( json_encode( $images ) ) . '"';
        $link .= ' data-popup-path="' . $path . '"';
        $link .= ' data-popup-init="' . $init . '"';
        $link .= ' data-popup-title="' . get_the_title( $id ) . '"';

        $link .= ' data-popup-arrows="' . scm_utils_link_gallery_helper( $content, 'arrows', 0 ) . '"';
        $link .= ' data-popup-miniarrows="' . scm_utils_link_gallery_helper( $content, 'miniarrows', 0 ) . '"';

        $link .= ' data-popup-list="' . scm_utils_link_gallery_helper( $content, 'list', 0 ) . '"';
        $link .= ' data-popup-name="' . scm_utils_link_gallery_helper( $content, 'name', 0 ) . '"';
        $link .= ' data-popup-counter="' . scm_utils_link_gallery_helper( $content, 'counter', 0 ) . '"';

        $link .= ' data-popup-info="' . scm_utils_link_gallery_helper( $content, 'info', 0 ) . '"';
        $link .= ' data-popup-color="' . scm_utils_link_gallery_helper( $content, 'color', 0 ) . '"';

        $link .= ' data-popup-data="' . scm_utils_link_gallery_helper( $content, 'data', 'float' ) . '"';
        $link .= ' data-popup-reverse="' . scm_utils_link_gallery_helper( $content, 'reverse', 0 ) . '"';

        $link .= ' data-popup-titles="' . scm_utils_link_gallery_helper( $content, 'titles', 0 ) . '"';
        $link .= ' data-popup-captions="' . scm_utils_link_gallery_helper( $content, 'captions', 0 ) . '"';
        $link .= ' data-popup-alternates="' . scm_utils_link_gallery_helper( $content, 'alternates', 0 ) . '"';
        $link .= ' data-popup-descriptions="' . scm_utils_link_gallery_helper( $content, 'descriptions', 0 ) . '"';

        $link .= ' data-popup-dates="' . scm_utils_link_gallery_helper( $content, 'dates', 0 ) . '"';
        $link .= ' data-popup-modifies="' . scm_utils_link_gallery_helper( $content, 'modifies', 0 ) . '"';
        $link .= ' data-popup-filenames="' . scm_utils_link_gallery_helper( $content, 'filenames', 0 ) . '"';
        $link .= ' data-popup-types="' . scm_utils_link_gallery_helper( $content, 'types', 0 ) . '"';

    return $link;
}

/**
* [GET] Post link gallery helper
*
* @param {array} content Content array.
* @param {string} attr Attribute to look for.
* @param {misc} fallback Fallback (default is 0).
* @return {misc} Attribute value, or fallback.
*/
function scm_utils_link_gallery_helper( $content = NULL, $attr = NULL, $fallback = 0 ){

    if( is_null( $content ) || is_null( $attr ) ) return $fallback;

    $th = ( isset( $content['modules'] ) ? getByKey( $content['modules'], $attr ) : NULL );

    return ( !empty( $content ) && isset( $content[$attr] ) ? $content[$attr] : ( !is_null( $th ) ? ( isset( $th[$attr] ) ? $th[$attr] : $fallback ) : $fallback ) );
}

// ------------------------------------------------------
// 4.0 STYLE
// ------------------------------------------------------
// ------------------------------------------------------
// 4.1 SET STYLE
// ------------------------------------------------------

/**
* [GET] Setup style option
*
* @param {string=} target Option target (default is '').
* @param {string=} separator Separator in case target is string (default is '-').
* @return {array} Array containing 'type' and 'target' attributes.
*/
function scm_utils_style_set( $target = '', $separator = '-' ) {

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
// 4.2 GET STYLE
// ------------------------------------------------------

/**
* [GET] Style option
*
* @param {string} option Option name.
* @param {string=} target Option target (default is 'option').
* @param {bool=} add Wrap result in style property (default is false).
* @return {misc|string} Result or result wrapped in style property if add is true.
*/
function scm_utils_style_get( $option = NULL, $target = 'option', $add = false ) {

	if( is_null( $option ) ) return '';

    $target = scm_utils_style_set( $target );
    $type = $target['type'];
    $target = $target['target'];

    switch ( $option ) {
    	case 'align':
    	case 'text_align':
    	case 'text-align':
    	case 'txt_alignment':
    	case 'txt-alignment':
    		return scm_utils_style_get_align( $type, $target, $add );
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
    		return scm_utils_style_get_size( $type, $target, $add );
    	break;

    	case 'font':
    	case 'fonts':
    	case 'font_family':
    	case 'font-family':
    	case 'webfont':
    	case 'webfonts':
    		return scm_utils_style_get_fonts( $type, $target, $add );
    	break;

    	case 'color':
    	case 'text_color':
    	case 'text-color':
    		return scm_utils_style_get_color( $type, $target, $add );
    	break;

    	case 'shadow':
    	case 'text_shadow':
    	case 'text-shadow':
    		return scm_utils_style_get_shadow( $type, $target, $add );
    	break;

    	case 'weight':
    	case 'font_weight':
    	case 'font-weight':
    	case 'text_weight':
    	case 'text-weight':
    		return scm_utils_style_get_weight( $type, $target, $add );
    	break;

    	case 'line_height':
    	case 'line-height':
    	case 'after':
    	case 'space_after':
    	case 'space-after':
    		return scm_utils_style_get_line_height( $type, $target, $add );
    	break;

    	case 'background_image':
    	case 'background-image':
    	case 'bg_image':
    	case 'bg-image':
    		return scm_utils_style_get_bg_image( $type, $target, $add );
    	break;

    	case 'background_repeat':
    	case 'background-repeat':
    	case 'bg_repeat':
    	case 'bg-repeat':
    		return scm_utils_style_get_bg_repeat( $type, $target, $add );
    	break;

    	case 'background_position':
    	case 'background-position':
    	case 'bg_position':
    	case 'bg-position':
    		return scm_utils_style_get_bg_position( $type, $target, $add );
    	break;

    	case 'background_size':
    	case 'background-size':
    	case 'bg_size':
    	case 'bg-size':
    		return scm_utils_style_get_bg_size( $type, $target, $add );
    	break;

    	case 'background_color':
    	case 'background-color':
    	case 'bg_color':
    	case 'bg-color':
    		return scm_utils_style_get_bg_color( $type, $target, $add );
    	break;

    	case 'opacity':
    		return scm_utils_style_get_opacity( $type, $target, $add );
    	break;

    	case 'margin':
    		return scm_utils_style_get_margin( $type, $target, $add );
    	break;

    	case 'padding':
    		return scm_utils_style_get_padding( $type, $target, $add );
    	break;
    	
    	default:
    		return '';
    	break;
    }
}

// ------------------------------------------------------
// 4.3 GET SPECIFIC STYLE
// ------------------------------------------------------

/**
* [GET] Align style option
*
* @param {string=} type Option prefix (default is '').
* @param {string=} target Option target (default is 'option').
* @param {bool=} add Wrap result in style property (default is false).
* @return {misc|string} Result or result wrapped in style property if add is true.
*/
function scm_utils_style_get_align( $type = '', $target = 'option', $add = false ) {
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
function scm_utils_style_get_size( $type = '', $target = 'option', $add = false ) {
	if( $type || $target != 'option' ){
        $size = ( get_field( is( $type, 'style-txt-' ) . 'set-size', $target ) ?: 'default' );
	}else{

        $obj = get_field_object( is( $type, 'style-txt-' ) . 'set-size', $target );

        if( !$obj ) return '';

        $value = $obj['default_value'];
        $choices = $obj['choices'];
        $label = $choices[ $value ];

        $sizes = scm_acf_field_choices_preset( 'txt_font_size' );
        $size = getByValue( str_replace( ' ', '', $sizes ), str_replace( ' ', '', $label ) );
    }

	if( $size == 'default' ){
		if( $type || $target != 'option' ) return '';
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
function scm_utils_style_get_fonts( $type = '', $target = 'option', $add = false ) {
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
function scm_utils_style_get_color( $type = '', $target = 'option', $add = false ) {
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
function scm_utils_style_get_line_height( $type = '', $target = 'option', $add = false, $units = '%' ) {
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
function scm_utils_style_get_weight( $type = '', $target = 'option', $add = false ) {
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
function scm_utils_style_get_shadow( $type = '', $target = 'option', $add = false ) {
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
function scm_utils_style_get_opacity( $type = '', $target = 'option', $add = false ) {
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
function scm_utils_style_get_margin( $type = '', $target = 'option', $add = false ) {
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
function scm_utils_style_get_padding( $type = '', $target = 'option', $add = false ) {
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
function scm_utils_style_get_bg_image( $type = '', $target = 'option', $add = false ) {
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
function scm_utils_style_get_bg_repeat( $type = '', $target = 'option', $add = false ) {
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
function scm_utils_style_get_bg_position( $type = '', $target = 'option', $add = false ) {
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
function scm_utils_style_get_bg_size( $type = '', $target = 'option', $add = false ) {
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
function scm_utils_style_get_bg_color( $type = '', $target = 'option', $add = false ) {
    $bg_alpha = ( get_field( is( $type, 'style-bg-' ) . 'rgba-alpha', $target) ?: 1 );
    $bg_color = ( get_field( is( $type, 'style-bg-' ) . 'rgba-color', $target) ? hex2rgba( get_field( is( $type, 'style-bg-' ) . 'rgba-color', $target ), $bg_alpha ) : 'transparent' );

    if( $bg_color == 'transparent' && ( $type || $target != 'option' ) )
        return '';

    return ( !$add ? $bg_color : 'background-color:' . $bg_color . ';' );
}

// ------------------------------------------------------
// 4.4 GET ALL STYLES
// ------------------------------------------------------

/**
* [GET] Style from options
*
* @param {string=} target Options target or [bg|nobg] (default is 'option').
* @param {bool=} add Wrap result in style attribute (default is false).
* @param {string=} type Options prefix (default is '').
* @return {string} Result or result wrapped in style attribute if add is true.
*/
function scm_utils_styles( $target = 'option', $add = false, $type = '' ) {

    if( !$target ) return '';

    $style = '';

    if( strpos( $type, '_' ) === 0 ){

        $bg_image = scm_utils_style_get( 'bg_image', array( 'target' => $target, 'type' => $type ), 1 );
        $bg_repeat = ( $bg_image ? scm_utils_style_get( 'bg_repeat', array( 'target' => $target, 'type' => $type ), 1 ) : '' );
        $bg_position = ( $bg_image ? scm_utils_style_get( 'bg_position', array( 'target' => $target, 'type' => $type ), 1 ) : '' );
        $bg_size = ( $bg_image ? scm_utils_style_get( 'bg_size', array( 'target' => $target, 'type' => $type ), 1 ) : '' );
        $bg_color = scm_utils_style_get( 'bg_color', array( 'target' => $target, 'type' => $type ), 1 );

        $style = $bg_color . $bg_image . $bg_repeat . $bg_position . $bg_size;

    }else{

        if( $type != 'bg' ){

        	$align = scm_utils_style_get( 'align', $target, 1 );
            $size = scm_utils_style_get( 'size', $target, 1 );

            $font = scm_utils_style_get( 'font', $target, 1 );

            $color = scm_utils_style_get( 'color', $target, 1 );
            $line_height = scm_utils_style_get( 'line_height', $target, 1 );
            $weight = scm_utils_style_get( 'weight', $target, 1 );

            $opacity = scm_utils_style_get( 'opacity', $target, 1 );
            $shadow = scm_utils_style_get( 'shadow', $target, 1 );
            $margin = scm_utils_style_get( 'margin', $target, 1 );
            $padding = scm_utils_style_get( 'padding', $target, 1 );

            $style = $align . $size . $font . $color . $line_height . $weight . $opacity . $shadow . $margin . $padding;
        }

        if( $type != 'nobg' ){

            $bg_image = scm_utils_style_get( 'bg_image', $target, 1 );
        	$bg_repeat = ( $bg_image ? scm_utils_style_get( 'bg_repeat', $target, 1 ) : '' );
            $bg_position = ( $bg_image ? scm_utils_style_get( 'bg_position', $target, 1 ) : '' );
            $bg_size = ( $bg_image ? scm_utils_style_get( 'bg_size', $target, 1 ) : '' );
            $bg_color = scm_utils_style_get( 'bg_color', $target, 1 );

            $style .= $bg_color . $bg_image . $bg_repeat . $bg_position . $bg_size;
        }
    }

    return ( $style ? ( !$add ? $style : ' style="' . $style . '"' ) : '' );
}


// ------------------------------------------------------
// 5.0 PRESET
// ------------------------------------------------------

/**
* [GET] Size from preset
*
* @param {float|string} size Size numeric value or [auto|initial|inherit].
* @param {string} units Size units.
* @param {float|string=} fallback Size fallback (default is '').
* @param {string=} fallback Units fallback (default is 'px').
* @return {string} Size value plus units if size is numeric, or just size value if size is string.
*/
function scm_utils_preset_size( $size, $units, $fall = '', $fall2 = 'px' ) {

    $units = is( $units, $fall2 );
    $size = ifexists( $size, $fall );
    $size = ( is_numeric( $size ) ? $size . $units : ifequal( $size, array( 'auto', 'initial', 'inherit' ), $fall ) );

    return $size;
}

/**
* [GET] RGBA from preset
*
* @param {string} color Color hexadecimal value or [transparent|initial|inherit|none].
* @param {float} alpha Alpha value.
* @param {string=} fallback Color fallback (default is '').
* @param {float=} fallback Alpha fallback (default is 1).
* @return {string} Color value in RGBA form.
*/
function scm_utils_preset_rgba( $color, $alpha, $fall = '', $fall2 = 1 ) {

    $alpha = isNumber( $alpha, $fall2 );
    $color = is( $color, $fall );
    $color = ifequal( $color, array( '', 'transparent', 'initial', 'inherit', 'none' ), hex2rgba( $color, $alpha ) );

    return $color;
}

/**
* [GET] Map marker from preset
*
* @param {post:luogo} location Location post.
* @param {array=} fields Location fields (default is empty array).
* @param {bool=} mark Marker instead of icon (default is false).
* @return {array|string} Icon array or marker string if mark is true.
*/
function scm_utils_preset_map_marker( $location = NULL, $fields = array(), $mark = false ) {

    if( is_null( $location ) ) return '';

    $marker = ( isset( $fields['luogo-map-icon'] ) ? $fields['luogo-map-icon'] : 'default' );

    $icon = array( 'icon' => 'fa-map-marker', 'data' => '#000000' );

    switch ( $marker ) {
        case 'icon':
            $fa = is( $fields['luogo-map-icon-fa'], 'fa-map-marker' );
            $color = scm_utils_preset_rgba( is( $fields['luogo-map-rgba-color'], '#e3695f' ), is( $fields['luogo-map-rgba-alpha'], 1 ) );
            $icon = array( 'icon' => $fa, 'data' => $color );
            $marker = ' data-icon="' . $fa . '" data-icon-color="' . $color . '"';
        break;

        case 'img':
            $img = is( $fields['luogo-map-icon-img'], '' );
            $icon = array( 'icon' => $img, 'data' => 'img' );
            $marker = ( $img ? ' data-img="' . $img . '"' : '' );
        break;

        default:
            $term = wp_get_post_terms( $location, 'luoghi-tip' );

            if( !$term || !sizeof( $term ) )

            $term_field = ( $term && sizeof( $term ) ? get_fields( $term[0] ) : array() );
            $marker = ( ( isset( $term_field ) && $term_field ) ? ( isset( $term_field['luogo-tip-map-icon'] ) ? $term_field['luogo-tip-map-icon'] : 'default' ) : 'default' );
            switch ( $marker ) {
                case 'icon':
                    $fa = is( $term_field['luogo-tip-map-icon-fa'], 'fa-map-marker' );
                    $color = scm_utils_preset_rgba( is( $term_field['luogo-tip-map-rgba-color'], '#e3695f' ), is( $term_field['luogo-tip-map-rgba-alpha'], 1 ) );
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
                            $color = scm_utils_preset_rgba( scm_field( 'opt-tools-map-rgba-color', '#e3695f', 'option' ), scm_field( 'opt-tools-map-rgba-alpha', 1, 'option' ) );
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

?>