<?php

/**
* scm-core.php.
*
* SCM core functions.
*
* @link http://www.studiocreativo-m.it
*
* @package SCM
* @subpackage Core
* @since 1.0.0
*/

/** SCM core admin. */
require_once( SCM_DIR_LIBRARY . 'scm-core-admin.php' );

/** SCM feed. */
//require_once( SCM_DIR_LIBRARY . 'scm-core-feed.php' );

// ------------------------------------------------------
//
// 0.0 Actions and Filters
//      0.1 Init
//      0.2 Register and Enqueue Scripts
//      0.3 Register and Enqueue Styles
//      0.4 Register and Enqueue Admin and Login
//      0.5 Header Styles
//      0.6 Body Classes
//
// ------------------------------------------------------

// ------------------------------------------------------
// 0.0 ACTIONS AND FILTERS
// ------------------------------------------------------

add_filter( 'query_vars', 'scm_hook_query_vars' );
add_action( 'after_setup_theme', 'scm_hook_load_textdomain' );
add_action( 'after_setup_theme', 'scm_hook_register_menus' );
add_action( 'after_setup_theme', 'scm_hook_old_browser' );

//add_filter( 'clean_url', 'scm_hook_site_register_asyncdefer', 11, 1 );
add_action( 'wp_enqueue_scripts', 'scm_hook_site_register_webfonts_adobe' );
add_action( 'wp_enqueue_scripts', 'scm_hook_site_register_webfonts_google' );
add_action( 'wp_enqueue_scripts', 'scm_hook_site_register_styles' );
add_action( 'wp_enqueue_scripts', 'scm_hook_site_register_styles_inline' );
add_action( 'wp_enqueue_scripts', 'scm_hook_site_assets_favicon' );

add_action( 'admin_enqueue_scripts', 'scm_hook_admin_register_assets', 998 );
add_action( 'login_enqueue_scripts', 'scm_hook_login_register_assets', 10 );
add_filter( 'login_headerurl', 'scm_hook_login_logo_url' );
add_filter( 'login_headertitle', 'scm_hook_login_logo_url_title' );

add_filter( 'body_class','scm_hook_body_class' );

add_theme_support( 'title-tag' );
add_theme_support( 'automatic-feed-links' );
add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption' ) );
add_theme_support( 'post-thumbnails' );

// ------------------------------------------------------
//  0.1 INIT
// ------------------------------------------------------

/**
* [GET] Add query vars
*
* Hooked by 'query_vars'
*
* @param {array=} public_query_vars List of query vars (default is empty array).
* @return {array} Modified list of query vars.
*/
function scm_hook_query_vars( $public_query_vars = array() ) {
    $public_query_vars[] = 'template';
    return $public_query_vars;
}

/**
* [SET] Load textdomain
*
* Hooked by 'after_setup_theme'
*/
function scm_hook_load_textdomain() {
    load_theme_textdomain( SCM_THEME, SCM_DIR_LANG );
    load_child_theme_textdomain( SCM_CHILD, SCM_DIR_LANG_CHILD );
}

/**
* [SET] Register menus
*
* Hooked by 'after_setup_theme'
*/
function scm_hook_register_menus() {
    register_nav_menus( array(
        'primary' => __( 'Menu Principale', SCM_THEME ),
        'secondary' => __( 'Menu Secondario', SCM_THEME ),
        'temporary' => __( 'Menu Temporaneo', SCM_THEME ),
        'auto' => __( 'Menu Auto', SCM_THEME )
        )
    );
}

/**
* [SET] Redirect old browsers
*
* Hooked by 'after_setup_theme'
*/
function scm_hook_old_browser() {
    if( function_exists('get_browser_name') ){

        $version = ( (int)get_browser_version() ?: 1000 );

        if( (is_ie() && $version < (int)scm_field( 'opt-ie-version', '10', 'option' )) ||
            (is_safari() && $version < (int)scm_field( 'opt-safari-version', '7', 'option' )) ||
            (is_firefox() && $version < (int)scm_field( 'opt-firefox-version', '38', 'option' )) ||
            (is_chrome() && $version < (int)scm_field( 'opt-chrome-version', '43', 'option' )) ||
            (is_opera() && $version < (int)scm_field( 'opt-opera-version', '23', 'option' )) ) {

            get_template_part( SCM_DIR_PARTS, 'old' );
            die();
        }
    }
}

// ------------------------------------------------------
// 0.2 REGISTER AND ENQUEUE SCRIPTS
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

// ------------------------------------------------------
// 0.3 REGISTER AND ENQUEUE STYLES
// ------------------------------------------------------

/**
* [SET] Register and enqueue Google Webfonts style
*
* Hooked by 'wp_enqueue_scripts'
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
*
* @todo 1 - Se Header PRINT aggiungi:
```php
// SCM Print
wp_register_style( 'print', SCM_URI_CSS . 'scm-print.css', false, null, 'print' );
wp_enqueue_style( 'print' );
```
*/
function scm_hook_site_register_styles() {

    // SCM
    wp_register_style( 'global', SCM_URI . 'style.css', false, SCM_VERSION );
    wp_enqueue_style( 'global' );

    // SCM Child
    wp_register_style( 'child', SCM_URI_CHILD . 'style.css', false, SCM_VERSION );
    wp_enqueue_style( 'child' );

    // ++todo 1
}

// ------------------------------------------------------
// 0.4 REGISTER AND ENQUEUE ADMIN AND LOGIN
// ------------------------------------------------------

/**
* [SET] Register and enqueue admin styles
*
* Hooked by 'wp_enqueue_scripts'
*/
function scm_hook_admin_register_assets() {
    wp_register_style( 'scm-admin', SCM_URI_CSS . 'scm-admin.css', false, SCM_VERSION );
    wp_enqueue_style('scm-admin');
    wp_register_style( 'scm-admin-child', SCM_URI_ASSETS_CHILD . 'css/admin.css', false, SCM_VERSION );
    wp_enqueue_style('scm-admin-child');
} 

/**
* [SET] Register and enqueue login styles
*
* Hooked by 'wp_enqueue_scripts'
*/
function scm_hook_login_register_assets() {
    wp_register_style( 'scm-login', SCM_URI_CSS . 'scm-login.css', false, SCM_VERSION );
    wp_enqueue_style('scm-login');

    $login_logo = scm_field('opt-staff-logo', '', 'option');

    if( $login_logo ):
        ?>
        <style type="text/css">
            body.login h1 a {
                background-image: url(<?php echo esc_url( $login_logo ); ?>);
            }
        </style>
        <?php
    else:
        ?>
        <style type="text/css">
            body.login h1 a {
                display: none !important;
            }
        </style>
        <?php
    endif;

    wp_register_style( 'scm-login-child', SCM_URI_ASSETS_CHILD . 'css/login.css', false, SCM_VERSION );
    wp_enqueue_style('scm-login-child');
}

/**
* [GET] Get login logo URL
*
* Hooked by 'login_headerurl'
*
* @return {string} The home page URL
*/
function scm_hook_login_logo_url() {
    return home_url();
}

/**
* [GET] Get login logo URL title
*
* Hooked by 'login_headertitle'
*
* @return {string} The website name
*/
function scm_hook_login_logo_url_title() {
    global $SCM_sitename;
    return $SCM_sitename;
}

// ------------------------------------------------------
// 0.5 HEADER STYLES
// ------------------------------------------------------

/**
* [SET] Echo SCM favicons in header
*
* Hooked by 'wp_enqueue_scripts'
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
*/
function scm_hook_site_register_styles_inline() {

    $html = scm_options_get( 'bg_color', 'loading-style-bg', 1 );
    $html .= ( scm_options_get( 'bg_image', 'loading-style-bg', 1 ) ?: '' );
    $html .= scm_options_get( 'bg_size', 'loading-style-bg', 1 );

    $font = scm_options_get( 'font', 'option', 1 );

    $opacity = scm_options_get( 'opacity', 'option', 1 );
    $align = scm_options_get( 'align', 'option', 1 );

    $line_height = scm_options_get( 'line_height', 'option', 1 );

    $body = scm_options_get( 'size', 'option', 1 );
    $body .= scm_options_get( 'color', 'option', 1 );
    $body .= scm_options_get( 'weight', 'option', 1 );
    $body .= scm_options_get( 'shadow', 'option', 1 );
    $body .= scm_options_get( 'margin', 'option', 1 );
    $body .= scm_options_get( 'padding', 'option', 1 );

    $body .= scm_options_get( 'bg_image', 'option', 1 );
    $body .= scm_options_get( 'bg_repeat', 'option', 1 );
    $body .= scm_options_get( 'bg_position', 'option', 1 );
    $body .= scm_options_get( 'bg_size', 'option', 1 );
    $body .= scm_options_get( 'bg_color', 'option', 1 );

    $menu_font = scm_options_get( 'font', 'menu', 1 );

    $top_bg = scm_options_get( 'bg_color', 'opt-tools-topofpage-bg', 1 );
    $top_icon = scm_options_get( 'text_color', 'opt-tools-topofpage-txt', 1 );

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

    $base = (int)str_replace( 'px', '', scm_options_get( 'size', 'option' ) );

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
// 0.6 BODY CLASSES
// ------------------------------------------------------

/**
* [GET] Body classes (page, browser, language)
*
* Hooked by 'body_class'
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