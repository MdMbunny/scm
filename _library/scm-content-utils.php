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
// 4.0 TEMPLATE
// 5.0 STYLE
//      5.1 Set Style
//      5.2 Get Style
//      5.3 Get Specific Style
//      5.4 Get All Styles
// 6.0 PRESET
//
// ------------------------------------------------------

// ------------------------------------------------------
// 0.0 OPTIONS
// ------------------------------------------------------

/**
* [GET] Option
*
* @param {string=} opt Option name (default is '').
* @param {string=} field Field key (default is '').
* @param {misc=} fall Fallback (default is '').
* @return {array} Option from autoloaded, or from field key, or fallback.
*/
function scm_utils_option( $opt = '', $field = '', $fall = '' ) {
    global $SCM_options;
    $var = ex_attr( $SCM_options, $opt, NULL );
    if( is_null( $var ) ) scm_field( $field, $fall, 'option' );
    return $var;
}

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

/**
* [GET] Row data
*
* @param {int=} current Current column (default is 0).
* @param {int=} total Column total (default is 0).
* @return {string} String row.
*/
function scm_utils_data_row( $current = 0, $total = 0, $count = 0 ) {

    if( $current <= $count )
        return 'first';
    if( $current > $total - $count )
        return 'last';
    return '';
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
// 3.0 LINK
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

    global $post, $SCM_types;
    $old = $post;

    if( $id )
        $post = ( is_numeric( $id ) ? get_post( $id ) : $id );

    $type = $post->post_type;
    $id = $post->ID;
    $link = '';

    if( strpos( $content['acf_fc_layout'], 'layout-SCMTAX') !== false ) return '';

    $content = apply_filters( 'scm_filter_object_before_link_' . $type, $content, $id );

    $set = ex_attr( $SCM_types['settings'], $type, '' ) ?: array( 'link'=>'self', 'link-field'=>'' );
    $link_type = ex_attr( $content, 'link-type', '' ) ?: $set['link'];
    $link_field = ex_attr( $content, 'link-field', '' ) ?: $set['link-field'];
    $template = ex_attr( $content, 'template', '' );
    
    if( is_asso( $link_field ) ){
        foreach ($link_field as $typ => $choices) {
            foreach ($choices as $choice => $field) {
                if( scm_field( $typ, '', $id ) === $choice ){
                    $link_field = $field;
                    $link_type = $choice;
                    break 2;
                }
            }
        }
    }

    switch ( $link_type ) {
        case 'self':
            $link = ' data-href="' . get_permalink( $id ) . ( $template ? '?template=' . $template : '' ) . '" data-target="_self"';
        break;
        case 'load':
            $link = ' data-href="' . get_permalink( $id ) . '" data-target="_self" data-load-single="' . $id . '" data-load-template="' . ( $template ?: '' ) . '"';
        break;
        case 'file':
        case 'attachment':
            $file = scm_field( $link_field, 0, $id );
            $file = ( (int)$file ? wp_get_attachment_url( scm_field( $link_field, 0, $id ) ) : $file );
            $link = ' data-href="' . $file . '"';
        break;
        case 'link':
            $link = ' data-href="' . scm_field( $link_field, '#', $id ) . '"';
        break;

        case 'map':
            $link = ' data-open-marker="click"';
        break;

        case 'gallery':
            $link = scm_utils_link_gallery( $content, $link_field, $id );
        break;

        case 'video':
            $vurl = scm_field( 'video-url', '', $id );
            $vtype = getVideoType( $vurl );
            $video = getVideoURL( $vurl );
            
            $link = ' data-popup="' . htmlentities( json_encode( array( $video ) ) ) . '"';
            $link .= ' data-popup-type="video"';
            $link .= ' data-popup-video-type="' . $vtype . '"';
            $link .= ' data-popup-title="' . get_the_title( $id ) . '"';
        break;

        case 'popup':
            $link = ' data-popup="' . htmlentities( json_encode( array( ( $id ? array( $id ) : '' ) ) ) ) . '"';
            $link .= ' data-popup-template="' . $template . '"';
            $link .= ' data-popup-type="load"';
        break;

        default:
            $link = apply_filters( 'scm_filter_object_link_' . $type, $link, $content, $id );
        break;
    }

    $link = apply_filters( 'scm_filter_object_after_link_' . $type, $link, $content, $id );

    $post = $old;
    //wp_reset_query();

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
    $field = !isset( $field ) || !$field ? 'galleria-images' : $field;
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
function scm_utils_link_gallery_helper( $content, $attr, $fallback = 0 ){

    if( !$content || !$attr ) return $fallback;

    $th = ( isset( $content['modules'] ) ? getByKey( $content['modules'], $attr ) : NULL );

    return ( !empty( $content ) && isset( $content[$attr] ) ? $content[$attr] : ( !is_null( $th ) ? ( isset( $th[$attr] ) ? $th[$attr] : $fallback ) : $fallback ) );
}

// ------------------------------------------------------
// 4.0 TEMPLATE
// ------------------------------------------------------

function scm_utils_get_template( $type = '', $template_id = 0 ){
    
    $template_post = 0;
    $type = ( $type && is_string( $type ) ? $type : '' );

    if( $template_id ){
        
        if( is_numeric($template_id) ){
            
            $template_id = (int)$template_id;
            $template_post = get_post( $template_id );
        
        }elseif( $type && is_string( $template_id ) ){
            
            $template_post = get_page_by_path( $template_id, OBJECT, $type . SCM_TEMPLATE_APP );

        }
    }

    if( $type && !$template_post ){
        $templates = scm_field( $type . '-templates', '', 'option' );
        if( !empty( $templates ) )
            $template_post = get_post( (int)$templates[0]['id'] );
    }

    return $template_post;
}

function scm_utils_get_template_id( $type = '', $template_id = 0, $start = 0 ){
    
    $type = ( $type && is_string( $type ) ? $type : '' );

    if( $template_id ){
        
        if( is_numeric($template_id) ){
            
            $template_id = (int)$template_id;
        
        }elseif( $type && is_string( $template_id ) ){
            
            $template_post = get_page_by_path( $template_id, OBJECT, $type . SCM_TEMPLATE_APP );
            if( $template_post )
                $template_id = $template_post->ID;
            else
                $template_id = 0;
        }
    }

    if( !$template_id ){
        $templates = scm_field( $type . '-templates', '', 'option' );

        if( !empty( $templates ) ){
            $ind = 0;
            if( $start && ex_index( $templates, 1, 0 ) )
                $ind = 1;
            $template_id = (int)$templates[0]['id'];
        }else{
            $template_id = 0;
        }
    }
    return $template_id;
}

// ------------------------------------------------------
// 5.0 STYLE
// ------------------------------------------------------
// ------------------------------------------------------
// 5.1 SET STYLE
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
// 5.2 GET STYLE
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
// 5.3 GET SPECIFIC STYLE
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
    
    $library = scm_field( is( $type, 'style-txt-' ) . 'rgba-library', 0, $target, (bool)$type );
    if( $library ){
        global $SCM_libraries;
        $alpha = $SCM_libraries['colors'][$library]['alpha'];
        $color = $SCM_libraries['colors'][$library]['color'];
    }else{
    	$alpha = scm_field( is( $type, 'style-txt-' ) . 'rgba-alpha', 1, $target, (bool)$type );
        $color = scm_field( is( $type, 'style-txt-' ) . 'rgba-color', '', $target, (bool)$type );
	}

    $color = hex2rgba( ( $color ?: '' ), $alpha );
    if( !$color ) return '';

	/*if( !$color && ( $type || $target != 'option' ) )
		return '';*/

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
    $weight = startsWith( $weight, 'w' ) ? str_replace( 'w', '', $weight) : $weight;

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
    
    $library = scm_field( is( $type, 'style-bg-' ) . 'rgba-library', 0, $target, (bool)$type );
    if( $library ){
        global $SCM_libraries;
        $bg_alpha = $SCM_libraries['colors'][$library]['alpha'];
        $bg_color = $SCM_libraries['colors'][$library]['color'];
    }else{
        $bg_alpha = scm_field( is( $type, 'style-bg-' ) . 'rgba-alpha', 1, $target, (bool)$type );
        $bg_color = scm_field( is( $type, 'style-bg-' ) . 'rgba-color', '', $target, (bool)$type );
    }

    $bg_color = hex2rgba( $bg_color, $bg_alpha );
    if( !$bg_color ) return '';

    /*if( $bg_color == 'transparent' && ( $type || $target != 'option' ) )
        return '';*/

    return ( !$add ? $bg_color : 'background-color:' . $bg_color . ';' );
}

// ------------------------------------------------------
// 5.4 GET ALL STYLES
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
// 6.0 PRESET
// ------------------------------------------------------

/**
* [GET] Date (from preset)
*
* @return {array} Array containing date attributes.
*/
function scm_utils_preset_dates( $obj = NULL, $start = '', $end = '', $format = 'd/m/Y', $lang = '' ) {

    if( !is_null( $obj ) ){
        $start = $start ?: 'start-date';
        $end = $end ?: 'end-date';
        $start = scm_field( $start, '', ( $obj === 0 ? NULL : $obj ) );
        $end = scm_field( $end, '', ( $obj === 0 ? NULL : $obj ) );
    }
    if( !$start ) return false;
    $date = array();
    $current = (int)date('Ymd');
    $date['start'] = date( 'Ymd', strtotime( $start ) );
    $date['end'] = ( $end ? date( 'Ymd', strtotime( $end ) ) : $date['start'] );
    $lang = ( $lang ?: ( function_exists( 'pll_current_language' ) ? pll_current_language('locale') : str_replace( '-', '_', substr( $_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 5 ) ) ) );
    setlocale( LC_ALL, $lang );
    $date['single'] = !$end || $date['start'] == $date['end'];
    $date['current'] = (int)$date['start'] < $current && (int)$date['end'] >= $current;
    $date['past'] = (int)$date['end'] < $current;
    $date['next'] = (int)$date['start'] > $current;
    $date['after_date'] = strftime( '%d %B %Y', strtotime('+1 day', strtotime( $date['end'] ) ) );
    $date['before_date'] = strftime( '%d %B %Y', strtotime('-1 day', strtotime( $date['start'] ) ) );
    $date['start_date'] = strftime( '%d %B %Y', strtotime( $date['start'] ) );
    $date['end_date'] = strftime( '%d %B %Y', strtotime( $date['end'] ) );
    $date['start_format'] = dateFormat( $date['start'], 'Ymd', $format );
    $date['end_format'] = dateFormat( $date['end'], 'Ymd', $format );
    $date['state'] = ( $date['next'] ? 'next' : ( $date['current'] ? 'current' : ( $date['past'] ? 'past' : 'unknown' ) ) );

    return $date;
}
// USED BY cittadelladanza > REPLACE WITH scm_utils_preset_dates
function scm_utils_preset_date( $start = '', $end = '', $lang = '' ) {

    $dates = scm_utils_preset_date( $start, $end, '/', $lang );
    $dates['old'] = $dates['past'];
    $dates['same'] = $dates['single'];

    return $dates;
}


/**
* [GET] Policies from preset
*
* @return {array} Array containing policy ID and LANG.
*/
function scm_utils_preset_policies() {

    $policies = scm_field( 'opt-policies-list', array(), 'option' );
    if( !$policies || empty( $policies ) ) return array();

    $index = 0;
    $lang = scm_field( 'opt-policies-lang', 'en', 'option' );
    
    if( sizeof( $policies ) >= 1 && function_exists( 'pll_current_language' ) ){
        $current = pll_current_language();

        foreach ( $policies as $key=>$policy ) {
        
            if( $policy['lang'] === $current ){
                $index = $key;
                break;
            }

            if( $policy['lang'] === $lang ){
                $index = $key;
            }
        
        }
    }

    return $policies[$index];
}

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
function scm_utils_preset_rgba( $col = '', $alp = '', $fall = '', $fall2 = 1 ) {

    $color = $col;
    $alpha = $alp;

    if( is_array($col) ){
        global $SCM_libraries;
        $lib = $col[ $alp . '-rgba-library' ];
        
        if( $lib && ex_attr( $SCM_libraries['colors'], $lib ) ){
            $alpha = $SCM_libraries['colors'][$lib]['alpha'];
            $color = $SCM_libraries['colors'][$lib]['color'];
            
        }else{

            $color = $col[ $alp . '-rgba-color' ];
            $alpha = $col[ $alp . '-rgba-alpha' ];
        }
    }else{
        $alpha = isNumber( $alp, $fall2 );
        $color = is( $col, $fall );
    }

    $color = ifequal( $color, array( '', 'transparent', 'initial', 'inherit', 'none' ), hex2rgba( $color, $alpha ) );

    return $color;
}

/**
* [GET] Map marker from preset
*
* @param {post:luogo} luogo ID Luogo.
* @param {array=} fields Luogo fields (default is empty array).
* @param {bool=} mark Marker instead of icon (default is false).
* @return {array|string} Icon array or marker string if mark is true.
*/
function scm_utils_preset_map_marker( $luogo = NULL, $fields = array(), $mark = false ) {

    if( is_null( $luogo ) ) return '';
    if( empty($fields) ) $fields = get_fields( $luogo );

    $marker = ( isset( $fields['luogo-map-icon'] ) ? $fields['luogo-map-icon'] : 'default' );

    $icon = array( 'icon' => 'fa-map-marker-alt', 'data' => '#000000' );



    switch ( $marker ) {
        case 'icon':

            $fa = is( $fields['luogo-map-icon-fa'], 'fa-map-marker-alt' );
            $color = scm_utils_preset_rgba( $fields, 'luogo-map' );//is( $fields['luogo-map-rgba-color'], '#e3695f' ), is( $fields['luogo-map-rgba-alpha'], 1 ) );
            //$color = scm_utils_preset_rgba( $fields, 'luogo-map', '#e3695f', 1 );
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
                    $fa = is( $term_field['luogo-tip-map-icon-fa'], 'fa-map-marker-alt' );
                    $color = scm_utils_preset_rgba( $fields, 'luogo-map' );// is( $term_field['luogo-tip-map-rgba-color'], '#e3695f' ), is( $term_field['luogo-tip-map-rgba-alpha'], 1 ) );
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
                            $fa = scm_field( 'opt-tools-map-icon-fa', 'fa-map-marker-alt', 'option' );

                            $color = scm_utils_style_get_color( 'opt-tools-map-', 'option' );

                            //$color = scm_utils_preset_rgba( scm_field( 'opt-tools-map-rgba-color', '#e3695f', 'option' ), scm_field( 'opt-tools-map-rgba-alpha', 1, 'option' ) );
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

/**
* [GET] Luogo address
*/
function scm_utils_get_region_name( $region = '' ) {
    if( strlen( $region ) == 2 ){
        if( class_exists( 'Locale' ) )
            return Locale::getDisplayRegion('-' . $region, 'en') ?: '';
    }
    return '';
}
function scm_utils_preset_address_helper( $elem = '', $name = '', $separator = '', $old = '' ) {
    if( $elem ){
        if( $separator ){
            return ( $old ? '<span class="separator">' . $separator . '</span>' : '' ) . '<span class="' . $name . '">' . $elem . '</span>';
        }else{
            return '<span class="float-none ' . $name . '">' . $elem . '</span>';
        }
    }
    return '';
}
function scm_utils_preset_address( $luogo = NULL, $fields = array(), $title = '', $separator = '', $break = '<br>', $prepend = '', $append = '' ) {

    if( is_null( $luogo ) || !$luogo ) return '';
    if( empty($fields) ) $fields = get_fields( $luogo );

    $arr = array();
    $arr['name'] = $title ? get_the_title( $luogo ) : ex_attr( $fields, 'luogo-nome', '' );
    $arr['street'] = ex_attr( $fields, 'luogo-indirizzo', '' );
    $arr['town'] = ex_attr( $fields, 'luogo-frazione', '' );
    $arr['city'] = ex_attr( $fields, 'luogo-citta', '' );
        $arr['code'] = ex_attr( $fields, 'luogo-cap', '' );
        $arr['province'] = ex_attr( $fields, 'luogo-provincia', '' );
        $arr['city'] = trim( doublesp( $arr['code'] . ' ' . $arr['city'] . ' ' . ( $arr['province'] ?: '' ) ) );
    $arr['region'] = ex_attr( $fields, 'luogo-regione', '' );
    $arr['country'] = ex_attr( $fields, 'luogo-paese', '' ) ? scm_utils_get_region_name( $fields['luogo-paese'] ) : '';

    $ret = '';
    $ret .= $arr['street'] ?: '';
    $ret .= $arr['town'] ? ( $ret ? ', ' : '' ) . $arr['town'] : '';
    $ret .= $arr['city'] ? ( $ret ? ', ' : '' ) . $arr['city'] : '';
    $ret .= $arr['region'] ? ( $ret ? ', ' : '' ) . $arr['region'] : '';
    $ret .= $arr['country'] ? ( $ret ? ', ' : '' ) . $arr['country'] : '';
    $arr['inline'] = $ret;

    $name = ( $arr['name'] ? '<strong class="name">' . $arr['name'] . '</strong>' . ( $ret ? $break : '' ) : '' );

    $html = ( $arr['street'] ? '<span class="street">' . $arr['street'] . '</span>' : '' );
    $html .= scm_utils_preset_address_helper( $arr['town'], 'town', $separator, $html );
    $html .= scm_utils_preset_address_helper( $arr['city'], 'city', $separator, $html );
    $html .= scm_utils_preset_address_helper( $arr['region'], 'region', $separator, $html );
    $html .= scm_utils_preset_address_helper( $arr['country'], 'country', $separator, $html );

    $html = $prepend . $name . $html . $append;
    $arr['html'] = $html;

    return $arr;
}

?>