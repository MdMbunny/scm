<?php
/**
 * @package SCM
 */

// *****************************************************
// *    SCM CORE
// *****************************************************

/*
*****************************************************
*
*   0.0 Actions and Filters
*   1.0 Theme Support
*   2.0 Register and Enqueue Styles
*   3.0 Register and Enqueue Scripts
*   4.0 Header Styles
*   5.0 Initialize
*
*****************************************************
*/

// *****************************************************
// *      0.0 ACTIONS AND FILTERS
// *****************************************************

    add_filter('query_vars', 'scm_query_vars');

    add_action( 'wp_enqueue_scripts', 'scm_site_register_webfonts_adobe' );
    add_action( 'wp_enqueue_scripts', 'scm_site_register_webfonts_google' );
    add_action( 'wp_enqueue_scripts', 'scm_site_register_styles' );
    add_action( 'wp_enqueue_scripts', 'scm_site_register_styles_inline' );
    
    add_action( 'admin_enqueue_scripts', 'scm_admin_register_assets', 998 );
    add_action( 'login_enqueue_scripts', 'scm_login_register_assets', 10 );
    add_filter( 'login_headerurl', 'scm_login_logo_url' );
    add_filter( 'login_headertitle', 'scm_login_logo_url_title' );
        
    add_action( 'after_setup_theme', 'scm_load_textdomain' );

    //add_filter( 'clean_url', 'scm_site_register_asyncdefer', 11, 1 );


// *****************************************************
// *       1.0 THEME SUPPORT
// *****************************************************


    register_nav_menus( array(
        'primary' => __( 'Menu Principale', SCM_THEME ),
        'secondary' => __( 'Menu Secondario', SCM_THEME ),
        'temporary' => __( 'Menu Temporaneo', SCM_THEME ),
        'auto' => __( 'Menu Auto', SCM_THEME )
        )
    );
        
    add_theme_support( 'title-tag' );
    add_theme_support( 'automatic-feed-links' );
    add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption' ) );
    add_theme_support( 'post-thumbnails' );
    

    //LOCALIZATION

    if ( ! function_exists( 'scm_load_textdomain' ) ) {
        function scm_load_textdomain() {
            load_theme_textdomain( SCM_THEME, SCM_DIR_LANG );
            load_child_theme_textdomain( SCM_CHILD, SCM_DIR_LANG_CHILD );
        }
    }
    
// *****************************************************
// *      2.0 REGISTER AND ENQUEUE STYLES
// *****************************************************   

// Public

    //google fonts
    if ( ! function_exists( 'scm_site_register_webfonts_google' ) ) {
        function scm_site_register_webfonts_google() {
            $fonts =  scm_field( 'styles-google', array(), 'option' );
            $len = sizeof( $fonts );
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

    //styles
    if ( ! function_exists( 'scm_site_register_styles' ) ) {
        function scm_site_register_styles() {

            // SCM
            wp_register_style( 'global', SCM_URI . 'style.css', false, SCM_VERSION );
            wp_enqueue_style( 'global' );

            // SCM Child
            wp_register_style( 'child', SCM_URI_CHILD . 'style.css', false, SCM_VERSION );
            wp_enqueue_style( 'child' );

            // SCM Print
            // +++ todo: if html header is PRINT
            //wp_register_style( 'print', SCM_URI_CSS . 'scm-print.css', false, null, 'print' );
            //wp_enqueue_style( 'print' );

        }
    }

//  Admin

    if ( ! function_exists( 'scm_admin_register_assets' ) ) {
        function scm_admin_register_assets() {

            wp_register_style( 'scm-admin', SCM_URI_CSS . 'scm-admin.css', false, SCM_VERSION );
            wp_enqueue_style('scm-admin');
            wp_register_style( 'scm-admin-child', SCM_URI_ASSETS_CHILD . 'css/admin.css', false, SCM_VERSION );
            wp_enqueue_style('scm-admin-child');

        }
    } 

    if ( ! function_exists( 'scm_login_register_assets' ) ) {
        function scm_login_register_assets() {

            /* Login Page */

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
    }

    if ( ! function_exists( 'scm_login_logo_url' ) ) {
        function scm_login_logo_url() {
            return home_url();
        }
    }

    if ( ! function_exists( 'scm_login_logo_url_title' ) ) {
        function scm_login_logo_url_title() {
            global $SCM_sitename;
            return $SCM_sitename;
        }
    }    

// *****************************************************
// *      3.0 REGISTER AND ENQUEUE SCRIPTS
// *****************************************************

    //adobe fonts
    if ( ! function_exists( 'scm_site_register_webfonts_adobe' ) ) {
        function scm_site_register_webfonts_adobe() {

            $fonts =  scm_field( 'styles-adobe', array(), 'option' );

            foreach ($fonts as $value) { 

                $id = $value['id'];
                $slug = ( $value['name'] ? sanitize_title( $value['name'] ) : $id );
                wp_register_script( 'webfonts-adobe-' . $slug , '//use.typekit.net/' . $id . '.js', false, null );
                wp_enqueue_script( 'webfonts-adobe-' . $slug );
                
            }
        }
    }
    
    // add async and defer to javascripts
    /*function scm_site_register_asyncdefer( $url ) {
        if( is_admin() ) return $url;
        if ( FALSE === strpos( $url, '.js' ) ) return $url;
        if ( strpos( $url, 'jquery.js' ) ) return $url;
        return "$url' async='async' defer='defer";
    }*/



// *****************************************************
// *      4.0 HEADER STYLES
// *****************************************************


    if ( ! function_exists( 'scm_site_register_styles_inline' ) ) {
        function scm_site_register_styles_inline() {

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
    }

// *****************************************************
// *      5.0 INITIALIZE
// *****************************************************

    if ( ! function_exists( 'scm_query_vars' ) ) {
        function scm_query_vars( $public_query_vars ) {

            $public_query_vars[] = 'template';

            return $public_query_vars;

        }
    }

?>