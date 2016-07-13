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
//
// ------------------------------------------------------

// ------------------------------------------------------
// ACTIONS AND FILTERS
// ------------------------------------------------------

// ENQUEUE
add_action( 'wp_enqueue_scripts', 'scm_hook_site_register_webfonts_adobe' );
add_action( 'wp_enqueue_scripts', 'scm_hook_site_register_webfonts_google' );
add_action( 'wp_enqueue_scripts', 'scm_hook_site_register_styles' );
//add_filter( 'clean_url', 'scm_hook_site_register_asyncdefer', 11, 1 );

// INLINE
add_action( 'wp_enqueue_scripts', 'scm_hook_site_register_styles_inline' );
add_action( 'wp_enqueue_scripts', 'scm_hook_site_assets_favicon' );

// BODY
add_filter( 'body_class','scm_hook_body_class' );

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

// ASYND AND DEFER JS
/*function scm_hook_site_register_asyncdefer( $url ) {
    if( is_admin() ) return $url;
    if ( FALSE === strpos( $url, '.js' ) ) return $url;
    if ( strpos( $url, 'jquery.js' ) ) return $url;
    return "$url' async='async' defer='defer";
}*/

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
* @subpackage 4-Init/Core/1-ENQUEUE
*/
function scm_hook_site_register_styles() {

    // SCM
    wp_register_style( 'global', SCM_URI . 'style.css', false, SCM_VERSION );
    wp_enqueue_style( 'global' );

    // SCM Child
    wp_register_style( 'child', SCM_URI_CHILD . 'style.css', false, SCM_VERSION );
    wp_enqueue_style( 'child' );

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

    $opacity = scm_utils_style_get( 'opacity', 'option', 1 );
    $align = scm_utils_style_get( 'align', 'option', 1 );

    $line_height = scm_utils_style_get( 'line_height', 'option', 1 );

    $body = scm_utils_style_get( 'size', 'option', 1 );
    $body .= scm_utils_style_get( 'color', 'option', 1 );
    $body .= scm_utils_style_get( 'weight', 'option', 1 );
    $body .= scm_utils_style_get( 'shadow', 'option', 1 );
    $body .= scm_utils_style_get( 'margin', 'option', 1 );
    $body .= scm_utils_style_get( 'padding', 'option', 1 );

    $body .= scm_utils_style_get( 'bg_image', 'option', 1 );
    $body .= scm_utils_style_get( 'bg_repeat', 'option', 1 );
    $body .= scm_utils_style_get( 'bg_position', 'option', 1 );
    $body .= scm_utils_style_get( 'bg_size', 'option', 1 );
    $body .= scm_utils_style_get( 'bg_color', 'option', 1 );

    $menu_font = scm_utils_style_get( 'font', 'menu', 1 );

    $top_bg = scm_utils_style_get( 'bg_color', 'opt-tools-topofpage-bg', 1 );
    $top_icon = scm_utils_style_get( 'text_color', 'opt-tools-topofpage-txt', 1 );

    // Print Main Style

    $css = lbreak() . 'html{ ' . $html . ' }' . lbreak();

    $css .= '*, input, textarea{ ' . $font . ' }' . lbreak();

    $css .= 'body { ' . $body . ' }' . lbreak();

    $css .= '.site-page { ' . $opacity . ' }' . lbreak();

    $css .= '.scm-row { ' . $align . ' }' . lbreak();

    $css .= '.site-content, .site-footer{ ' . $line_height . ' }' . lbreak();

    $css .= '.navigation ul li a { ' . $menu_font . ' }' . lbreak();

    $css .= '.topofpage { ' . $top_bg . ' }' . lbreak();
    $css .= '.topofpage a i { ' . $top_icon . ' }' . lbreak();

    // Responsive

    $r_max = (int)scm_field( 'layout-max', '1400', 'option' );

    if( $r_max >= 1400 )
        $css .= '.r1400 .responsive { width: 1250px; }' . lbreak();
    else
        $css .= '.r1400 .responsive, ';

    if( $r_max >= 1120 )
        $css .= '.r1120 .responsive { width: 1120px; }' . lbreak();
    else
        $css .= '.r1120 .responsive, ';

    if( $r_max >= 1030 )
        $css .= '.r1030 .responsive { width: 1030px; }' . lbreak();
    else
        $css .= '.r1030 .responsive, ';

    if( $r_max >= 940 )
        $css .= '.r940 .responsive { width: 940px; }' . lbreak();
    else
        $css .= '.r940 .responsive, ';

    if( $r_max >= 800 )
        $css .= '.r800 .responsive { width: 800px; }' . lbreak();
    else
        $css .= '.r800 .responsive, ';

    if( $r_max >= 700 )
        $css .= '.r700 .responsive { width: 700px; }' . lbreak();

    $r_full = scm_field( 'layout-tofull', '', 'option' );

    $css .= '.tofull .responsive, .smart .responsive { width: 100%; }' . lbreak();

    $base = (int)str_replace( 'px', '', scm_utils_style_get( 'size', 'option' ) );

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

    global $SCM_styles;

    global $post;

    $classes[] = SCM_THEME;

    // PAGE
    if ( is_single() ) {
        foreach ( ( get_the_category( $post->ID ) ) as $category ) {
            $classes[] = 'post-'.$category->category_nicename;
        }
    }
    if ( is_page() ) {
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
    if( function_exists( 'get_browser_name' ) ){

        $browser = strtolower( get_browser_name() );

        $classes[] = $browser;
        if( $browser == 'ie' )
            $classes[] = $browser . (int)get_browser_version();

        if( is_desktop() ) $classes[] = 'is-desktop';
        if( is_tablet() ) $classes[] = 'is-tablet';
        if( is_iphone() ) $classes[] = 'is-iphone';
        if( is_ipad() ) $classes[] = 'is-ipad';
        if( is_ipod() ) $classes[] = 'is-ipod';
        if( is_mobile() ) $classes[] = 'is-mobile';

    }else{

        global $is_gecko, $is_chrome, $is_opera, $is_IE, $is_iphone;

        if ( $is_iphone ) $classes[] = 'safari is-iphone';
        elseif ( $is_gecko ) $classes[] = 'firefox';
        elseif ( $is_chrome ) $classes[] = 'chrome';
        elseif ( $is_opera ) $classes[] = 'opera';
        elseif ( $is_IE ) $classes[] = 'ie';
        elseif ( $is_iphone ) $classes[] = 'safari is-iphone';
        else $classes[] = 'safari';

    }

    $classes[] = $post->post_status;

    // LANGUAGE - NEEDS PolyLang Plugin
    if( function_exists('pll_current_language') )
        $classes[] = 'lang-' . ( pll_current_language() ?: language_attributes() );

    return $classes;
}

?>