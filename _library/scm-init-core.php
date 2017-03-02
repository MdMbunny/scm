<?php

/**
* SCM core init hooks.
*
* @link http://www.studiocreativo-m.it
*
* @package SCM
* @subpackage 4-Init/Core
* @since 1.0.0
*/

// ------------------------------------------------------
//
// ACTIONS AND FILTERS
//      1-Register and enqueue scripts and styles
//      2-Register and enqueue inline styles
//      3-Body
//      4-Query
//
// ------------------------------------------------------

// ------------------------------------------------------
// ACTIONS AND FILTERS
// ------------------------------------------------------

// ENQUEUE
//add_action( 'wp_head', 'scm_hook_site_policies' );
add_action( 'wp_enqueue_scripts', 'scm_hook_site_register_webfonts_adobe' );
add_action( 'wp_enqueue_scripts', 'scm_hook_site_register_webfonts_google' );
add_action( 'admin_enqueue_scripts', 'scm_hook_site_register_webfonts_adobe' );
add_action( 'admin_enqueue_scripts', 'scm_hook_site_register_webfonts_google' );
add_action( 'wp_enqueue_scripts', 'scm_hook_site_register_styles' );
add_action( 'wp_enqueue_scripts', 'scm_hook_site_libraries' );
add_action( 'admin_enqueue_scripts', 'scm_hook_site_libraries' );

// INLINE
add_action( 'wp_enqueue_scripts', 'scm_hook_site_register_styles_inline' );
add_action( 'wp_enqueue_scripts', 'scm_hook_site_assets_favicon' );

// BODY
add_filter( 'body_class','scm_hook_body_class' );

// QUERY
add_filter( 'query_vars', 'scm_hook_query_vars' );
add_action( 'wp_ajax_nopriv_load_archive', 'scm_hook_load_archive' );
add_action( 'wp_ajax_load_archive', 'scm_hook_load_archive' );
add_action( 'wp_ajax_nopriv_load_single', 'scm_hook_load_single' );
add_action( 'wp_ajax_load_single', 'scm_hook_load_single' );

// REMOVE
remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
remove_action( 'wp_print_styles', 'print_emoji_styles' );
remove_action( 'admin_print_styles', 'print_emoji_styles' );
remove_action( 'wp_head', 'feed_links_extra', 3 );
remove_action( 'wp_head', 'feed_links', 2 );
remove_action( 'wp_head', 'wlwmanifest_link' );
remove_action( 'wp_head', 'rsd_link' );
remove_action( 'wp_head', 'wp_generator' );

// ------------------------------------------------------
// 1-ENQUEUE
// ------------------------------------------------------

// ASYNC AND DEFER JS
/*function scm_hook_site_register_asyncdefer( $url ) {
    if( is_admin() ) return $url;
    if ( FALSE === strpos( $url, '.js' ) ) return $url;
    if ( strpos( $url, 'jquery.js' ) ) return $url;
    consoleLog( $url );
    return "$url' async='async' defer='defer";
}*/
//add_filter( 'clean_url', 'scm_hook_site_register_asyncdefer', 11, 1 );
/*add_filter( 'script_loader_tag', function ( $tag, $handle ) {
    if ( strpos($handle, 'scroll-magic') === false && strpos($handle, 'jquery-scm') === false && strpos($handle, 'fancybox') === false && strpos($handle, 'nivo') === false && 'contact-form-7' !== $handle )
        return $tag;

    return str_replace( ' src', ' defer="defer" src', $tag );
}, 10, 2 );*/

if( !is_admin() ){
    /* Add defer attr to scripts to Static Resources */ // DUBBI, VERIFICA
    /*function defer_parsing_of_js ( $url ) {
        if ( FALSE === strpos( $url, '.js' ) ) return $url;
        if ( strpos( $url, 'jquery.js' ) ) return $url;
        return "$url' defer onload='";
    }
    add_filter( 'clean_url', 'defer_parsing_of_js', 11, 1 );*/

    /* Remove Query String from Static Resources */
    function remove_cssjs_ver( $src ) {
        
        if( strpos( $src, '?ver=' ) )
        $src = remove_query_arg( 'ver', $src );
        return $src;
    }
    add_filter( 'style_loader_src', 'remove_cssjs_ver', 10, 2 );
    add_filter( 'script_loader_src', 'remove_cssjs_ver', 10, 2 );
}


/**
* [SET] Iubenda Policies Script
*
* Hooked by 'wp_head'
* @subpackage 4-Init/Core/1-ENQUEUE
*/
function scm_hook_site_policies() {

    $siteid = scm_field( 'opt-policies-id', 0, 'option' );
    $policy = scm_utils_preset_policies();

    if( !$policy || !is_asso( $policy ) || empty( $policy ) ) return;
    
    echo '<script type="text/javascript">';
        echo 'var _iub = _iub || [];';
        echo '_iub.csConfiguration = {';
            echo 'cookiePolicyId: ' . $policy['id'] . ',';
            echo 'siteId: ' . $siteid . ',';
            echo 'lang: "' . $policy['lang'] . '"';
        echo '};';
    echo '</script>';
    echo '<script type="text/javascript" src="//cdn.iubenda.com/cookie_solution/safemode/iubenda_cs.js" charset="UTF-8" async></script>';

}

/**
* [SET] Register and enqueue Adobe Typekit script
*
* Hooked by 'wp_enqueue_scripts'
* @subpackage 4-Init/Core/1-ENQUEUE
*/
function scm_hook_site_register_webfonts_adobe() {

    $fonts =  scm_field( 'styles-adobe', array(), 'option' );

    if( sizeof( $fonts ) > 0 ){

        global $SCM_typekit;
        $SCM_typekit = new Typekit_Client();

        foreach ($fonts as $value) {
            $id = $value['id'];
            $slug = ( $value['name'] ? sanitize_title( $value['name'] ) : $id );
            wp_register_script( 'webfonts-adobe-' . $slug , '//use.typekit.net/' . $id . '.js', false, null );
            wp_enqueue_script( 'webfonts-adobe-' . $slug );
        }
    }
}

/**
* [SET] Register and enqueue Google Webfonts style
*
* Hooked by 'wp_enqueue_scripts'
* Hooked by 'admin_enqueue_scripts'
*
* @subpackage 4-Init/Core/1-ENQUEUE
*/
function scm_hook_site_register_webfonts_google() {
    $fonts =  scm_field( 'styles-google', array(), 'option' );
    $len = sizeof( $fonts );
    if( $len ){
        $script = 'https://fonts.googleapis.com/css?family=';
        for ($i=0; $i < $len; $i++) {
            $value = $fonts[$i];
            $slug = sanitize_title( $value['family'] );
            $family = str_replace( ' ', '+', $value['family'] );
            $styles = implode( '', $value['style'] );
            $script .= $family . ':' . $styles;
            if( $i < $len - 1 )
                $script .= '|';
        }
        wp_register_style( 'webfonts-google' , $script, false, null );
        wp_enqueue_style( 'webfonts-google' );
    }
}

/**
* [SET] Register and enqueue styles
*
* Hooked by 'wp_enqueue_scripts'
* Hooked by 'admin_enqueue_scripts'
*
* @subpackage 4-Init/Core/1-ENQUEUE
*/
function scm_hook_site_register_styles() {

    // SCM
    wp_register_style( 'global', SCM_URI . 'style.css', false, NULL );
    wp_enqueue_style( 'global' );

    // ACF
    //wp_register_style( 'scm-acf', SCM_URI_CSS . 'scm-acf.css', false, NULL );
    //wp_enqueue_style('scm-acf');

    // SCM Child
    wp_register_style( 'child', SCM_URI_CHILD . 'style.css', false, NULL );
    wp_enqueue_style( 'child' );

}

/**
* [SET] Set Colors and Fonts Library
*
* Hooked by 'wp_enqueue_scripts'
* Hooked by 'admin_enqueue_scripts'
*
* @subpackage 4-Init/Core/1-ENQUEUE
*/
function scm_hook_site_libraries(){

    global $SCM_libraries, $SCM_typekit;
    
    $SCM_libraries = array(
        'colors' => array(),
        'selectors' => array(),
        'fonts' => array(),
    );

    $SCM_libraries['selectors']['colors'] = array( 'color-white', 'color-black', 'bg-color-white', 'bg-color-black' );
    $SCM_libraries['selectors']['text'] = array( 'text-min', 'text-minion', 'text-half', 'text-small', 'text-normal', 'text-medium', 'text-big', 'text-huge', 'text-max', 'text-double', 'text-triple', 'text-quadruple' );
    $SCM_libraries['selectors']['alignment'] = array( 'text-left', 'text-right', 'text-center', 'text-justify', 'align-left', 'align-right', 'align-center', 'align-none', 'clear-none', 'clearfix' );
    $SCM_libraries['selectors']['pointer'] = array( 'pointer', 'no-pointer' );
    $SCM_libraries['selectors']['layout'] = array( 'responsive', 'full-width', 'full-height', 'prepend', 'append', 'tocolumn', 'scm-object' );
    $SCM_libraries['selectors']['display'] = array( 'display-none', 'display-block', 'display-inline-block', 'display-inline', 'mask' );
    $SCM_libraries['selectors']['position'] = array( 'position-fixed', 'position-absolute', 'position-relative', 'fixed-top', 'absolute-top', 'relative-top', 'fixed-bottom', 'absolute-bottom', 'relative-bottom', 'fixed-left', 'absolute-left', 'relative-left', 'fixed-right', 'absolute-right', 'relative-right', 'middle', 'overlay', 'underlay' );
    $SCM_libraries['selectors']['shape'] = array( 'square', 'rounded', 'rounded-min', 'rounded-small', 'rounded-medium', 'rounded-big', 'rounded-max', 'circle', 'circle-min', 'circle-small', 'circle-medium', 'circle-big', 'circle-max', 'round-top', 'round-bottom', 'round-left', 'round-right', 'round-head', 'round-head-left', 'round-head-right', 'round-foot', 'round-foot-left', 'round-foot-right', 'round-leaf', 'round-leaf-left', 'round-leaf-right', 'round-petal', 'round-petal-left', 'round-petal-right', 'round-drop', 'round-drop-left', 'round-drop-right' );
    $SCM_libraries['selectors']['link'] = array( 'disabled', 'enabled', 'button', );

    $colors = scm_field( 'styles-colors', array(), 'option' );
    foreach ( $colors as $color ) {
        $slug = sanitize_title( $color['name'] );
        $SCM_libraries['colors'][ $slug ] = array(
            'name' => $color['name'],
            'color' => $color['rgba-color'],
            'alpha' => $color['rgba-alpha'],
        );
        $SCM_libraries['selectors']['colors'][] = 'color-' . $slug;
        $SCM_libraries['selectors']['colors'][] = 'bg-color-' . $slug;
    }

    $g_fonts = scm_field( 'styles-google', array(), 'option' );
    foreach ( $g_fonts as $g_font ) {
        $SCM_libraries['fonts'][ sanitize_title( $g_font['family'] ) ] = array(
            'family' => $g_font['family'],
            'style' => $g_font['style'],
            'type' => 'google'
        );
    }

    $a_fonts = scm_field( 'styles-adobe', array(), 'option' );
    if( sizeof( $a_fonts ) > 0 ){

        foreach ( $a_fonts as $a_font ) {
            $kit = $SCM_typekit->get( $a_font['id'] );
            if( !$kit || !$kit['kit'] ) continue;
            foreach( $kit['kit']['families'] as $family){
                $choices[$family['slug']] = $family['name'];
                $SCM_libraries['fonts'][ $family['slug'] ] = array(
                    'family' => $family['name'],
                    'style' => $family['style'],
                    'type' => 'adobe'
                );
            }
        }
    }
}


// ------------------------------------------------------
// 2-INLINE
// ------------------------------------------------------

/**
* [SET] Echo SCM favicons in header
*
* Hooked by 'wp_enqueue_scripts'
* @subpackage 4-Init/Core/2-INLINE
*/
function scm_hook_site_assets_favicon() {

    $ico144 = scm_field('opt-branding-144', '', 'option');
    $ico114 = scm_field('opt-branding-114', '', 'option');
    $ico72 = scm_field('opt-branding-72', '', 'option');
    $ico54 = scm_field('opt-branding-54', '', 'option');
    $png = scm_field('opt-branding-png', '', 'option');
    $ico = scm_field('opt-branding-ico', '', 'option');

    indent( 0, lbreak() . '<!-- Favicon and Touch Icons -->', 2 );

    if ( $ico144 )
        indent( 0, '<link rel="apple-touch-icon-precomposed" sizes="144x144" href="' . esc_url( $ico144 ) . '" /> <!-- for retina iPad -->', 1 );
    if ( $ico114 )
        indent( 0, '<link rel="apple-touch-icon-precomposed" sizes="114x114" href="' . esc_url( $ico114 ) . '" /> <!-- for retina iPhone -->', 1 );
    if ( $ico72 )
        indent( 0, '<link rel="apple-touch-icon-precomposed" href="' . esc_url( $ico72 ) . '" /> <!-- for legacy iPad -->', 1 );
    if ( $ico54 )
        indent( 0, '<link rel="apple-touch-icon-precomposed" href="' . esc_url( $ico54 ) . '" /> <!-- for non-retina devices -->', 1 );

    if ( $png )
        indent( 0, '<link rel="icon" type="image/png" href="' . esc_url( $png ) . '" /> <!-- standard favicon -->', 1 );
    if ( $ico )
        indent( 0, '<link rel="shortcut icon" href="' . esc_url( $ico ) . '" /><!-- IE favicon -->', 2 );
}

/**
* [SET] Echo SCM style in header
*
* Hooked by 'wp_enqueue_scripts'
* @subpackage 4-Init/Core/2-INLINE
*/
function scm_hook_site_register_styles_inline() {

    $html = scm_utils_style_get( 'bg_color', 'loading-style-bg', 1 );
    $html .= ( scm_utils_style_get( 'bg_image', 'loading-style-bg', 1 ) ?: '' );
    $html .= scm_utils_style_get( 'bg_size', 'loading-style-bg', 1 );

    $font = scm_utils_style_get( 'font', 'option', 1 );
    $align = scm_utils_style_get( 'align', 'option', 1 );
    $line_height = scm_utils_style_get( 'line_height', 'option', 1 );

    $body = indent() . scm_utils_style_get( 'size', 'option', 1 ) . lbreak();
    $body .= indent() . scm_utils_style_get( 'color', 'option', 1 ) . lbreak();
    $body .= indent() . scm_utils_style_get( 'weight', 'option', 1 ) . lbreak();
    $body .= indent() . scm_utils_style_get( 'shadow', 'option', 1 ) . lbreak();
    $body .= indent() . scm_utils_style_get( 'margin', 'option', 1 ) . lbreak();
    $body .= indent() . scm_utils_style_get( 'padding', 'option', 1 ) . lbreak();

    $body .= indent() . scm_utils_style_get( 'bg_image', 'option', 1 ) . lbreak();
    $body .= indent() . scm_utils_style_get( 'bg_repeat', 'option', 1 ) . lbreak();
    $body .= indent() . scm_utils_style_get( 'bg_position', 'option', 1 ) . lbreak();
    $body .= indent() . scm_utils_style_get( 'bg_size', 'option', 1 ) . lbreak();
    $body .= indent() . scm_utils_style_get( 'bg_color', 'option', 1 ) . lbreak();

    $menu_font = scm_utils_style_get( 'font', 'menu', 1 );

    $top_bg = scm_utils_style_get( 'bg_color', 'opt-tools-topofpage-bg', 1 );
    $top_icon = scm_utils_style_get( 'text_color', 'opt-tools-topofpage-txt', 1 );

    // Print Main Style

    $css = lbreak() . '/* Main Styles */' . lbreak(2);
    $css .= 'html{ ' . $html . ' }' . lbreak();
    $css .= '*, input, textarea{ ' . $font . ' }' . lbreak();
    $css .= 'body {' . lbreak() . $body . '}' . lbreak();
    $css .= '.scm-row { ' . $align . ' }' . lbreak();
    $css .= '.site-content, .site-footer{ ' . $line_height . ' }' . lbreak();
    $css .= '.navigation ul li a { ' . $menu_font . ' }' . lbreak();
    $css .= '.topofpage a { ' . $top_bg . ' }' . lbreak();
    $css .= '.topofpage a i { ' . $top_icon . ' }' . lbreak();

    // Responsive

    $css .= lbreak() . '/* Responsive Styles */' . lbreak(2);

    $r_max = (int)scm_field( 'layout-max', '1400', 'option' );

    if( $r_max >= 1400 ) $css .= '.r1400 .responsive { width: 1250px; }' . lbreak();
    else $css .= '.r1400 .responsive, ';

    if( $r_max >= 1120 ) $css .= '.r1120 .responsive { width: 1120px; }' . lbreak();
    else $css .= '.r1120 .responsive, ';

    if( $r_max >= 1030 ) $css .= '.r1030 .responsive { width: 1030px; }' . lbreak();
    else $css .= '.r1030 .responsive, ';

    if( $r_max >= 940 ) $css .= '.r940 .responsive { width: 940px; }' . lbreak();
    else $css .= '.r940 .responsive, ';

    if( $r_max >= 800 ) $css .= '.r800 .responsive { width: 800px; }' . lbreak();
    else $css .= '.r800 .responsive, ';

    if( $r_max >= 700 ) $css .= '.r700 .responsive { width: 700px; }' . lbreak();

    $r_full = scm_field( 'layout-tofull', '', 'option' );

    $css .= '.tofull .responsive, .smart .responsive { width: 100%; }' . lbreak();

    $base = (int)str_replace( 'px', '', scm_utils_style_get( 'size', 'option' ) );
    $base = (int)str_replace( 'px', '', scm_field( 'style-txt-set-size', '16px', 'option' ) );
    $base = ( $base ?: 16 );

    $r_desktop = $base + (int)scm_field( 'styles-size-desktop', -1, 'option' );
    $css .= 'body.desktop { font-size: ' . $r_desktop . 'px; }' . lbreak();

    $r_wide = $base + (int)scm_field( 'styles-size-wide', 0, 'option' );
    $css .= 'body.wide { font-size: ' . $r_wide . 'px; }' . lbreak();

    $r_landscape = $base + (int)scm_field( 'styles-size-landscape', 1, 'option' );
    $css .= 'body.landscape { font-size: ' . $r_landscape . 'px; }' . lbreak();

    $r_portrait = $base + (int)scm_field( 'styles-size-portrait', 2, 'option' );
    $css .= 'body.portrait { font-size: ' . $r_portrait . 'px; }' . lbreak();

    $r_smart = $base + (int)scm_field( 'styles-size-smart', 3, 'option' );
    $css .= 'body.smart { font-size: ' . $r_smart . 'px; }' . lbreak();

    $css .= lbreak() . '/* Fade Content Styles */' . lbreak(2);

    $cont_fade = scm_field( 'opt-tools-fadecontent', '', 'option' );
    if( $cont_fade )
        $css .= '.content-fade ' . $cont_fade . '{ opacity: 0; transition: opacity .5s; }' . lbreak();
    //$css .= '.content-fade ' . $cont_fade . '{ opacity: 0; top: 3em; transition: opacity .5s, top .5s; }' . lbreak();

    global $SCM_libraries;

    $css .= lbreak() . '/* Colors Library Styles */' . lbreak(2);

    $css .= '.color-white { color:#FFF; }' . lbreak();
    $css .= '.bg-color-white { background-color:#FFF; }' . lbreak();
    $css .= '.color-black { color:#000; }' . lbreak();
    $css .= '.bg-color-black { background-color:#000; }' . lbreak();

    foreach ($SCM_libraries['colors'] as $key => $color) {
        $css .= '.color-' . $key .' { color: ' . hex2rgba( ( $color['color'] ?: '' ), $color['alpha'] ) . ' }' . lbreak();
        $css .= '.bg-color-' . $key .' { background-color: ' . hex2rgba( ( $color['color'] ?: '' ), $color['alpha'] ) . ' }' . lbreak();
    }

    $css = apply_filters( 'scm_filter_inline_style', $css );

    if( $css )
        wp_add_inline_style( 'global', $css );
}

// ------------------------------------------------------
// 3-BODY
// ------------------------------------------------------

/**
* [GET] Body classes (page, browser, language)
*
* Hooked by 'body_class'
* @subpackage 4-Init/Core/3-BODY
*
* @param {array=} classes List of classes (default is empty array).
* @return {array} Modified list of classes.
*/
function scm_hook_body_class( $classes = array() ) {

    global $post, $SCM_agent;

    // THEME
    $classes[] = SCM_THEME;

    // POST
    $classes[] = $post->post_status;
    if( is_single() ){
        $classes[] = "{$post->post_type}-{$post->post_name}";
        foreach ( ( get_the_category( $post->ID ) ) as $category ) {
            $classes[] = 'post-'.$category->category_nicename;
        }
    }

    // PAGE
    if( is_page() ){
        if ( $parents = get_post_ancestors( $post->ID ) ) {
            foreach ( (array)$parents as $parent ) {
                if ( $page = get_page( $parent ) ) {
                    $classes[] = "{$page->post_type}-{$page->post_name}";
                }
            }
        }
        $classes[] = "{$post->post_type}-{$post->post_name}";
    }

    // BROWSER
    $classes[] = $SCM_agent['browser']['slug'];
    $classes[] = $SCM_agent['browser']['slug'] . (string)$SCM_agent['browser']['ver'];

    // DEVICE
    if( $SCM_agent['device']['desktop'] )
        $classes[] = 'is-desktop';
    if( $SCM_agent['device']['mobile'] )
        $classes[] = 'is-mobile';
    if( $SCM_agent['device']['tablet'] )
        $classes[] = 'is-tablet';
    if( $SCM_agent['device']['phone'] )
        $classes[] = 'is-phone';

    // TOUCH
    if( wp_script_is( 'jquery-touch-swipe' ) )
        $classes[] = 'touch';
    else
        $classes[] = 'mouse';

    // PLATFORM
    $classes[] = $SCM_agent['platform']['slug'];

    // LANGUAGE
    $classes[] = 'lang-' . $SCM_agent['lang']['slug'];

    $classes[] = 'r' . (int)scm_field( 'layout-max', '1400', 'option' );

    $classes[] = ( $SCM_agent['device']['tablet'] ? 'landscape' : ( $SCM_agent['device']['mobile'] ? 'smart' : 'desktop' ) );

    return $classes;
}

// ------------------------------------------------------
// 4-QUERY
// ------------------------------------------------------

/**
* [GET] Add custom query vars
*
* template = template id for dynamic content<br />
* action = edit|view
*
* Hooked by 'query_vars'
* @subpackage 4-Init/Core/4-QUERY
*
* @param {array=} public_query_vars List of query vars (default is empty array).
* @return {array} Modified list of query vars.
*/
function scm_hook_query_vars( $public_query_vars = array() ) {
    $public_query_vars[] = 'template';
    $public_query_vars[] = 'action';
    return $public_query_vars;
}

/**
* [GET] Load dynamic archive content
*
* Hooked by 'wp_ajax_nopriv_load_archive'
* Hooked by 'wp_ajax_load_archive'
* @subpackage 4-Init/Core/4-QUERY
*
*/
function scm_hook_load_archive() {
        
    // ARCHIVE
    $archive = $_POST['archive'];
    if( !is_null( $archive ) )
        scm_post( $archive );
    die;
}
/**
* [GET] Load dynamic single content
*
* Hooked by 'wp_ajax_nopriv_load_single'
* Hooked by 'wp_ajax_load_single'
* @subpackage 4-Init/Core/4-QUERY
*
*/
function scm_hook_load_single() {

    // SINGLE
    $single = $_POST['single'];
    $template = $_POST['template'];

    if( !is_null( $single ) )
        scm_post( (int)$single, (int)$template );
    die;
}


?>