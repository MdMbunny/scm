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

    add_action( 'wp_enqueue_scripts', 'scm_site_assets_webfonts_adobe' );
    add_action( 'wp_enqueue_scripts', 'scm_site_assets_webfonts_google' );
    add_action( 'wp_enqueue_scripts', 'scm_site_assets_styles' );
    add_action( 'wp_enqueue_scripts', 'scm_site_assets_styles_inline' );
    add_action( 'wp_enqueue_scripts', 'scm_site_assets_scripts' );

    add_action( 'widgets_init', 'scm_widgets_default' );
        
    add_action( 'after_setup_theme', 'scm_load_textdomain' );


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
    
    /*
    add_editor_style( SCM_URI_CSS . 'editor.css' );
    add_theme_support( 'custom-header' );
    add_theme_support( 'custom-background', apply_filters( 'scm_custom_background_args', array(
        'default-color' => 'ffffff',
        'default-image' => '',
    ) ) );
    */

    // *      WIDGETS

    if ( ! function_exists( 'scm_widgets_default' ) ) {
        function scm_widgets_default() {
            register_sidebar( array(
                'name'          => __( 'Barra Laterale', SCM_THEME ),
                'id'            => 'sidebar-1',
                'description'   => '',
                'before_widget' => '<aside id="%1$s" class="widget %2$s">',
                'after_widget'  => '</aside>',
                'before_title'  => '<h1 class="widget-title">',
                'after_title'   => '</h1>',
            ) );
        }
    }

    // *      LOCALIZATION

    if ( ! function_exists( 'scm_load_textdomain' ) ) {
        function scm_load_textdomain() {
            load_theme_textdomain( SCM_THEME, SCM_DIR_LANG );
            load_child_theme_textdomain( SCM_CHILD, SCM_DIR_LANG_CHILD );
        }
    }
    
// *****************************************************
// *      2.0 REGISTER AND ENQUEUE STYLES
// *****************************************************            

    //google fonts
    if ( ! function_exists( 'scm_site_assets_webfonts_google' ) ) {
        function scm_site_assets_webfonts_google() {
            $fonts =  scm_field( 'styles-google', array(), 'option' );
            foreach ($fonts as $value) {    
                $slug = sanitize_title( $value['family'] );           
                $family = str_replace( ' ', '+', $value['family'] );
                $styles = implode( '', $value['style'] );
                wp_register_style( 'webfonts-google-' . $slug , 'https://fonts.googleapis.com/css?family=' . $family . ':' . $styles, false, SCM_SCRIPTS_VERSION, 'screen' );
                wp_enqueue_style( 'webfonts-google-' . $slug );                
            }
        }
    }

    //styles
    if ( ! function_exists( 'scm_site_assets_styles' ) ) {
        function scm_site_assets_styles() {

            // Fancybox
            
            if( scm_field( 'opt-tools-fancybox', 0, 'option' ) ){
                wp_register_style( 'fancybox', SCM_URI_CSS . 'fancybox-2.1.5/jquery.fancybox.css', false, SCM_SCRIPTS_VERSION, 'screen' );
                wp_register_style( 'fancybox-thumbs', SCM_URI_CSS . 'fancybox-2.1.5/helpers/jquery.fancybox-thumbs.css', false, SCM_SCRIPTS_VERSION, 'screen' );
                wp_register_style( 'fancybox-buttons', SCM_URI_CSS . 'fancybox-2.1.5/helpers/jquery.fancybox-buttons.css', false, SCM_SCRIPTS_VERSION, 'screen' );
                wp_enqueue_style( 'fancybox' );
                wp_enqueue_style( 'fancybox-thumbs' );
                wp_enqueue_style( 'fancybox-buttons' );
            }

            // Nivo Slider

            if( get_field( 'main-slider-active', 'option' ) == 'nivo' || get_field( 'opt-tools-nivo', 'option' ) ){
                wp_register_style( 'nivo', SCM_URI_CSS . 'nivoSlider-3.2/nivo-slider.css', false, SCM_SCRIPTS_VERSION, 'all' );
                //wp_register_style( 'nivo-theme', SCM_URI_CSS . 'nivoSlider-3.2/themes/default/default.css', false, SCM_SCRIPTS_VERSION, 'all' );
                wp_register_style( 'nivo-theme', SCM_URI_CSS . 'nivoSlider-3.2/themes/scm/scm.css', false, SCM_SCRIPTS_VERSION, 'all' );
                wp_enqueue_style( 'nivo' );
                wp_enqueue_style( 'nivo-theme' );
            }

            // BX Slider

            if( get_field( 'main-slider-active', 'option' ) == 'bx' || get_field( 'opt-tools-bx', 'option' ) ){
                wp_register_style( 'bx', SCM_URI_CSS . 'jquery.bxslider/jquery.bxslider.css', false, SCM_SCRIPTS_VERSION, 'all' );
                wp_enqueue_style( 'bx' );
            }

            // Font Awesome
            
            wp_register_style('font-awesome', SCM_URI_FONT . 'font-awesome-4.5.0/css/font-awesome.min.css', false, SCM_SCRIPTS_VERSION, 'screen' );
            wp_enqueue_style( 'font-awesome' );

            /*global $wp_styles, $is_IE;
            wp_enqueue_style( 'font-awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css', array(), '4.3.0' );
            if ( $is_IE ) {
                wp_enqueue_style( 'font-awesome-ie', '//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome-ie7.min.css', array('font-awesome'), '4.3.0' );
                // Add IE conditional tags for IE 7 and older
                $wp_styles->add_data( 'font-awesome-ie', 'conditional', 'lte IE 7' );
            }*/

            // SCM

            wp_register_style( 'global', SCM_URI . 'style.css', false, SCM_SCRIPTS_VERSION, 'screen' );
            wp_enqueue_style( 'global' );

            // SCM Child

            wp_register_style( 'child', SCM_URI_CHILD . 'style.css', false, SCM_SCRIPTS_VERSION, 'screen' );
            wp_enqueue_style( 'child' );

            // Parallax

            if( scm_field( 'opt-tools-parallax', 0, 'option' ) ){
                wp_register_style( 'parallax', SCM_URI_CSS . 'parallax.css', false, SCM_SCRIPTS_VERSION, 'screen' );
                wp_enqueue_style( 'parallax' );
            }

            // Login Page

            /*wp_register_style( 'scm-login', SCM_URI_CSS . 'scm-login.css', false, SCM_SCRIPTS_VERSION, 'screen' );
            wp_enqueue_style('scm-login');
            wp_register_style( 'scm-login-child', SCM_URI_CSS_CHILD . 'login.css', false, SCM_SCRIPTS_VERSION, 'screen' );
            wp_enqueue_style('scm-login-child');*/
            
            // SCM Print

            // +++ todo: if html header is PRINT
            //wp_register_style( 'print', SCM_URI_CSS . 'scm-print.css', false, SCM_SCRIPTS_VERSION, 'print' );
            //wp_enqueue_style( 'print' );

        }
    }

    
    

// *****************************************************
// *      3.0 REGISTER AND ENQUEUE SCRIPTS
// *****************************************************

    //adobe fonts
    if ( ! function_exists( 'scm_site_assets_webfonts_adobe' ) ) {
        function scm_site_assets_webfonts_adobe() {
            $fonts =  scm_field( 'styles-adobe', array(), 'option' );

            foreach ($fonts as $value) { 

                $id = $value['id'];
                $slug = ( $value['name'] ? sanitize_title( $value['name'] ) : $id );
                wp_register_script( 'webfonts-adobe-' . $slug , '//use.typekit.net/' . $id . '.js', false, SCM_SCRIPTS_VERSION, 'screen' );
                wp_enqueue_script( 'webfonts-adobe-' . $slug );
                
            }

            //echo '<script>try{Typekit.load();}catch(e){}</script>';
        }
    }
    
    //scripts
    if ( ! function_exists( 'scm_site_assets_scripts' ) ) {
        function scm_site_assets_scripts() {

            wp_register_script( 'jquery-scm-presets', SCM_URI_JS . 'jquery.scm/jquery.presets.js', array( 'jquery' ), SCM_SCRIPTS_VERSION, false );
            wp_enqueue_script( 'jquery-scm-presets' );

            wp_register_script( 'jquery-scm-functions', SCM_URI_JS . 'jquery.scm/jquery.functions.js', array( 'jquery' ), SCM_SCRIPTS_VERSION, false );
            wp_enqueue_script( 'jquery-scm-functions' );
            
            wp_register_script( 'jquery-scm-plugins', SCM_URI_JS . 'jquery.scm/jquery.plugins.js', array( 'jquery' ), SCM_SCRIPTS_VERSION, false );
            wp_enqueue_script( 'jquery-scm-plugins' );

            wp_register_script( 'jquery-scm-tools', SCM_URI_JS . 'jquery.scm/jquery.tools.js', array( 'jquery' ), SCM_SCRIPTS_VERSION, false );
            wp_enqueue_script( 'jquery-scm-tools' );

            // jQuery Effects Core

            wp_enqueue_script('jquery-effects-core');


            // Skip Link Focus Fix

            wp_register_script( 'skip-link-focus-fix', SCM_URI_JS . 'skip-link-focus-fix.js', array( 'jquery' ), SCM_SCRIPTS_VERSION, true );
            wp_enqueue_script( 'skip-link-focus-fix' );

            
            // jQuery Transform

            wp_register_script( 'jquery-transform-2d', SCM_URI_JS . 'jquery.transform/jquery.transform2d.js', array( 'jquery' ), SCM_SCRIPTS_VERSION, true );
            wp_enqueue_script( 'jquery-transform-2d' );

            /*wp_register_script( 'jquery-transform-3d', SCM_URI_JS . 'jquery.transform/jquery.transform3d.js', array( 'jquery' ), SCM_SCRIPTS_VERSION, true );
            wp_enqueue_script( 'jquery-transform-3d' );*/

            // jQuery Mobile
            
            //wp_deregister_script( 'jquery.mobile' );
            wp_register_script( 'jquery-mobile-touch', SCM_URI_JS . 'jquery.mobile-1.4.5/jquery.mobile.touch.min.js', array( 'jquery' ), SCM_SCRIPTS_VERSION, true );
            wp_enqueue_script( 'jquery-mobile-touch' );

            // jQuery TouchSwipe

            //wp_deregister_script( 'jquery.touchSwipe' );
            wp_register_script( 'jquery-touch-swipe', SCM_URI_JS . 'touchSwipe-1.6.8/jquery.touchSwipe.min.js', array( 'jquery' ), SCM_SCRIPTS_VERSION, true );
            wp_enqueue_script( 'jquery-touch-swipe' );

            // Modernizr Touch

            wp_register_script( 'modernizr-touch', SCM_URI_JS . 'modernizr-2.8.3/modernizr.touch.js', array( 'jquery' ), SCM_SCRIPTS_VERSION, true );
            wp_enqueue_script( 'modernizr-touch' );
            
            // Bootstrap

            wp_register_script( 'bootstrap', SCM_URI_JS . 'bootstrap-3.3.6-dist/js/bootstrap.min.js', array( 'jquery' ), SCM_SCRIPTS_VERSION, true );
            wp_enqueue_script( 'bootstrap' );

            // Images Loaded
            
            wp_register_script( 'imagesloaded', SCM_URI_JS . 'imagesloaded-3.1.8/imagesloaded.pkgd.min.js', array( 'jquery' ), SCM_SCRIPTS_VERSION, true );
            wp_enqueue_script( 'imagesloaded' );

            // Fancybox

            if( scm_field( 'opt-tools-fancybox', 0, 'option' ) ){
                wp_register_script( 'fancybox', SCM_URI_JS . 'fancybox-2.1.5/jquery.fancybox.pack.js', array( 'jquery' ), SCM_SCRIPTS_VERSION, true );
                wp_register_script( 'fancybox-thumbs', SCM_URI_JS . 'fancybox-2.1.5/helpers/jquery.fancybox-thumbs.js', array( 'jquery' ), SCM_SCRIPTS_VERSION, true );
                wp_register_script( 'fancybox-buttons', SCM_URI_JS . 'fancybox-2.1.5/helpers/jquery.fancybox-buttons.js', array( 'jquery' ), SCM_SCRIPTS_VERSION, true );
                wp_register_script( 'fancybox-media', SCM_URI_JS . 'fancybox-2.1.5/helpers/jquery.fancybox-media.js', array( 'jquery' ), SCM_SCRIPTS_VERSION, true );
                wp_enqueue_script( 'fancybox' );
                wp_enqueue_script( 'fancybox-thumbs' );
                wp_enqueue_script( 'fancybox-buttons' );
                wp_enqueue_script( 'fancybox-media' );
            }

            // Parallax Scrolling

            if( scm_field( 'opt-tools-parallax', 0, 'option' ) ){
                wp_register_script( 'parallax',  SCM_URI_JS . 'parallax.js-1.3.1/parallax.min.js', false, SCM_SCRIPTS_VERSION, true );
                wp_enqueue_script( 'parallax' );
            }

            // Nivo Slider

            if( get_field( 'main-slider-active', 'option' ) == 'nivo' || get_field( 'opt-tools-nivo', 'option' ) ){
                wp_register_script( 'nivo', SCM_URI_JS . 'nivoSlider-3.2/jquery.nivo.slider.pack.js', array( 'jquery' ), SCM_SCRIPTS_VERSION, true );
                wp_enqueue_script( 'nivo' );
            }

            // BX Slider

            if( get_field( 'main-slider-active', 'option' ) == 'bx' || get_field( 'opt-tools-bx', 'option' ) ){
                wp_register_script( 'bx', SCM_URI_JS . 'jquery.bxslider/jquery.bxslider.min.js', array( 'jquery' ), SCM_SCRIPTS_VERSION, true );
                wp_enqueue_script( 'bx' );
            }

            // Tooltip

            wp_register_script( 'tooltip',  SCM_URI_JS . 'jquery.powertip-1.2.0/jquery.powertip.min.js', array( 'jquery' ), SCM_SCRIPTS_VERSION, true );
            wp_enqueue_script( 'tooltip' );

            // Waypoints

            wp_register_script( 'waypoints',  SCM_URI_JS . 'waypoints-4.0.0/lib/jquery.waypoints.min.js', array( 'jquery' ), SCM_SCRIPTS_VERSION, true );
            wp_enqueue_script( 'waypoints' );
            //wp_register_script( 'waypoints-debug',  SCM_URI_JS . 'waypoints-4.0.0/lib/waypoints.debug.js', false, SCM_SCRIPTS_VERSION, true );
            //wp_enqueue_script( 'waypoints-debug' );
            // import waypoints shortcuts if needed (sticky, infinite, ...)

            // SCM

            wp_register_script( 'jquery-scm', SCM_URI_JS . 'jquery.scm/jquery.scm.js', array( 'jquery' ), SCM_SCRIPTS_VERSION, true );
            wp_enqueue_script( 'jquery-scm' );

            // SCM Child

            wp_register_script( 'jquery-scm-child', SCM_URI_JS_CHILD . 'jquery.scm-child.js', array( 'jquery-scm' ), SCM_SCRIPTS_VERSION, true );
            wp_enqueue_script( 'jquery-scm-child' );

        }
    }


// *****************************************************
// *      4.0 HEADER STYLES
// *****************************************************


    if ( ! function_exists( 'scm_site_assets_styles_inline' ) ) {
        function scm_site_assets_styles_inline() {

            $html = scm_options_get( 'bg_color', 'styles-loading', 1 );
            $html .= ( scm_options_get( 'bg_image', 'styles-loading', 1 ) ?: '' );
            $html .= scm_options_get( 'bg_size', 'styles-loading', 1 );

            $font = scm_options_get( 'font', 'option', 1 );
            //$font .= scm_options_get( 'size', 'option', 1 );

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

            //$css .= '.site-content{ ' . $content . ' }' . lbreak();

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

            //if( $r_full )
                //$css .= '{ width: 100%; }' . lbreak();
            //$css .= '.' . $r_full . ' .responsive { width: 100%; }' . lbreak();

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


            /* Login Page */

            /*if( isLoginPage() ){
                $login_logo = scm_field('opt-staff-logo', '', 'option');
                //consoleLog(esc_url( $login_logo ));

                if( $login_logo )
                    $css. = 'body.login div#login h1 { logo-image: url("' . esc_url( $login_logo ) . '"); }' . lbreak();
                else
                    $css. = 'body.login div#login h1 { display: none !important; }' . lbreak();
            }*/

            
            if( !empty( $css ) )
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