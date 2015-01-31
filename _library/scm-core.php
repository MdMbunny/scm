<?php

// *****************************************************
// *      ACTIONS AND FILTERS
// *****************************************************

    add_action( 'wp_enqueue_scripts', 'scm_site_assets_webfonts' );
    add_action( 'wp_enqueue_scripts', 'scm_site_assets_styles' );
    add_action( 'wp_enqueue_scripts', 'scm_site_assets_styles_inline' );
    add_action( 'wp_enqueue_scripts', 'scm_site_assets_scripts' );
    add_action( 'admin_enqueue_scripts', 'scm_admin_assets', 998 );

	add_action( 'widgets_init', 'scm_widgets_default' );
        
    add_action( 'after_setup_theme', 'scm_load_textdomain' );
    //add_action( 'after_setup_theme', 'scm_default_headers' );
    //add_action( 'comment_form_before', 'scm_enqueue_comments_reply' );


// *****************************************************
// *       THEME SUPPORT
// *****************************************************

    register_nav_menus( array( 'primary' => __( 'Menu Principale', SCM_THEME ) ) );

    //add_editor_style( SCM_URI_CSS . 'editor.css' );
    
    add_theme_support( 'title-tag' );
    add_theme_support( 'automatic-feed-links' );
    add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption' ) );
    add_theme_support( 'post-thumbnails' );
    //add_theme_support( 'custom-header' );
    /*add_theme_support( 'custom-background', apply_filters( 'scm_custom_background_args', array(
        'default-color' => 'ffffff',
        'default-image' => '',
    ) ) );*/


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

    // *       HEADERS

    if ( ! function_exists( 'scm_default_headers' ) ) {
        function scm_default_headers() {

            $headers = array(
                'default-header' => array(
                    'description'   => __( 'The Default Header', SCM_THEME ),
                    'url'           => '',
                    'thumbnail_url' => '',
                ),
            );
            register_default_headers( $headers );

        }
    }

    // *       COMMENTS

    if ( ! function_exists( 'scm_enqueue_comments_reply' ) ) {
        function scm_enqueue_comments_reply() {
            if( get_option( 'thread_comments' ) )  {
                wp_enqueue_script( 'comment-reply' );
            }
        }
    }
    
// *****************************************************
// *      REGISTER AND ENQUEUE STYLES AND SCRIPTS
// *****************************************************

    //fonts
    if ( ! function_exists( 'scm_site_assets_webfonts' ) ) {
        function scm_site_assets_webfonts() {
            $fonts =  ( get_field('webfonts', 'option') ? get_field('webfonts', 'option') : array() );
            foreach ($fonts as $value) {    
                $slug = sanitize_title( $value['family'] );           
                $family = str_replace( ' ', '+', $value['family'] );
                $styles = implode( ',', $value['select_webfonts_styles'] );
                wp_register_style( 'webfonts-' . $slug , 'http://fonts.googleapis.com/css?family=' . $family . ':' . $styles, false, SCM_SCRIPTS_VERSION, 'screen' );
                wp_enqueue_style( 'webfonts-' . $slug );
                
            }
        }
    }

    //styles
    if ( ! function_exists( 'scm_site_assets_styles' ) ) {
        function scm_site_assets_styles() {

            wp_register_style( 'animate', SCM_URI_CSS . 'animate.css', false, SCM_SCRIPTS_VERSION, 'screen' );
            wp_enqueue_style( 'animate' );
            
            if( get_field( 'tools_fancybox_active', 'option' ) ){
                wp_register_style( 'fancybox', SCM_URI_CSS . 'fancybox/jquery.fancybox.css', false, SCM_SCRIPTS_VERSION, 'screen' );
                wp_register_style( 'fancybox-thumbs', SCM_URI_CSS . 'fancybox/helpers/jquery.fancybox-thumbs.css', false, SCM_SCRIPTS_VERSION, 'screen' );
                //wp_register_style( 'fancybox-buttons', SCM_URI_JS . 'fancybox/source/helpers/jquery.fancybox-buttons.css', false, SCM_SCRIPTS_VERSION, 'screen' );
                wp_enqueue_style( 'fancybox' );
                wp_enqueue_style( 'fancybox-thumbs' );
                //wp_enqueue_style( 'fancybox-buttons' );
            }

            if( get_field( 'tools_nivo_active', 'option' ) ){
                wp_register_style( 'nivo-default', SCM_URI_CSS . 'nivo/themes/default/default.css', false, SCM_SCRIPTS_VERSION, 'all' );
                wp_register_style( 'nivo', SCM_URI_CSS . 'nivo/nivo-slider.css', false, SCM_SCRIPTS_VERSION, 'all' );
                wp_enqueue_style( 'nivo-default' );
                wp_enqueue_style( 'nivo' );
            }

            //+++ todo: if Color Picker is on page [check how to integrate it]
            //wp_register_style( 'color-picker', SCM_URI_CSS . 'colorpicker.css', false, SCM_SCRIPTS_VERSION, 'screen' );
            //wp_register_script( 'color-picker', SCM_URI_JS . 'colorpicker.js', array( 'jquery' ), SCM_SCRIPTS_VERSION, true);

            wp_register_style( 'global', SCM_URI . 'style.css', false, SCM_SCRIPTS_VERSION, 'screen' );
            wp_enqueue_style( 'global' );

            wp_register_style( 'style', SCM_URI_CSS . 'main.css', false, SCM_SCRIPTS_VERSION, 'screen' );
            wp_enqueue_style( 'style' );

            wp_register_style( 'child', SCM_URI_CHILD . 'style.css', false, SCM_SCRIPTS_VERSION, 'screen' );
            wp_enqueue_style( 'child' );

            // +++ todo: if html header is PRINT
            //wp_register_style( 'print', SCM_URI_CSS . 'print.css', false, SCM_SCRIPTS_VERSION, 'screen' );
            //wp_enqueue_style( 'print' );
            
            //wp_register_style('fontawesome', SCM_URI_FONT . 'font-awesome/css/font-awesome.min.css', false, SCM_SCRIPTS_VERSION, 'screen' );
            //wp_enqueue_style( 'fontawesome' );

        }
    }

    // See scm-styles.php for inline styles 
    
    //scripts
    if ( ! function_exists( 'scm_site_assets_scripts' ) ) {
        function scm_site_assets_scripts() {
            
            wp_register_script( 'scm-functions', SCM_URI_JS . 'scm-functions.js', array( 'jquery' ), SCM_SCRIPTS_VERSION, true );
            wp_enqueue_script( 'scm-functions' );
            
            // +++ todo: check if needed
            //wp_register_script( 'imagesloaded', SCM_URI_JS . 'imagesloaded/jquery.imagesloaded.min.js', array( 'jquery' ), SCM_SCRIPTS_VERSION, true );
            //wp_enqueue_script( 'imagesloaded' );

            wp_register_script( 'single-page-nav', SCM_URI_JS . 'jquery.singlePageNav.min.js', array( 'jquery' ), SCM_SCRIPTS_VERSION, true );
            wp_enqueue_script( 'single-page-nav' );
            
            wp_register_script( 'skip-link-focus-fix', SCM_URI_JS . 'skip-link-focus-fix.js', array( 'jquery' ), SCM_SCRIPTS_VERSION, true );
            wp_enqueue_script( 'skip-link-focus-fix' );

            if( get_field( 'tools_fancybox_active', 'option' ) ){
                //wp_register_script( 'fancybox', SCM_URI_JS . 'fancybox/jquery.fancybox.js', array( 'jquery' ), SCM_SCRIPTS_VERSION, true );
                wp_register_script( 'fancybox', SCM_URI_JS . 'fancybox/jquery.fancybox.pack.js', array( 'jquery' ), SCM_SCRIPTS_VERSION, true );
                wp_register_script( 'fancybox-thumbs', SCM_URI_JS . 'fancybox/helpers/jquery.fancybox-thumbs.js', array( 'jquery' ), SCM_SCRIPTS_VERSION, true );
                //wp_register_script( 'fancybox-buttons', SCM_URI_JS . 'fancybox/helpers/jquery.fancybox-buttons.js', array( 'jquery' ), SCM_SCRIPTS_VERSION, true );
                //wp_register_script( 'fancybox-media', SCM_URI_JS . 'fancybox/helpers/jquery.fancybox-media.js', array( 'jquery' ), SCM_SCRIPTS_VERSION, true );
                wp_enqueue_script( 'fancybox' );
                wp_enqueue_script( 'fancybox-thumbs' );
                //wp_enqueue_script( 'fancybox-buttons' );
                //wp_enqueue_script( 'fancybox-media' );
            }

            if( get_field( 'tools_nivo_active', 'option' ) ){
                wp_register_script( 'nivo', SCM_URI_JS . 'nivo/jquery.nivo.slider.pack.js', array( 'jquery' ), SCM_SCRIPTS_VERSION, true );
                wp_enqueue_script( 'nivo' );
            }
            
            wp_register_script( 'gmapapi', 'https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false', false, '', true );
            // ENQUEUED BY scm-jquery.php IF A MAP IS LOADED

            wp_enqueue_script('jquery-effects-core');

            wp_register_script( 'bootstrap', SCM_URI_JS . 'bootstrap-3.3.2.min.js', array( 'jquery' ), SCM_SCRIPTS_VERSION, true );
            wp_enqueue_script( 'bootstrap' );            

        }
    }

     if ( ! function_exists( 'scm_admin_assets' ) ) {
        function scm_admin_assets() {

            wp_register_style( 'admin', SCM_URI_CSS . 'admin.css', false, SCM_SCRIPTS_VERSION, 'screen' );
            wp_enqueue_style('admin');
            
        }
    } 

// *****************************************************
// *      DEFAULT STYLES
// *****************************************************


    if ( ! function_exists( 'scm_site_assets_styles_inline' ) ) {
        function scm_site_assets_styles_inline() {

            $html = scm_options_get( 'bg_color', 'loading', 1 );
            $html .= ( scm_options_get( 'bg_image', 'loading', 1 ) ?: 'background-image:url(' . SCM_URI_IMG . '/loading.gif);' );
            $html .= scm_options_get( 'bg_size', 'loading', 1 );

            $font = scm_options_get( 'font', 'option', 1 );

            $opacity = scm_options_get( 'opacity', 'option', 1 );

            $line_height = scm_options_get( 'line_height', 'option', 1 );

            $body = scm_options_get( 'align', 'option', 1 );
            $body .= scm_options_get( 'size', 'option', 1 );
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
            
            $primary = scm_options_get( 'font', 'heading_1', 1 );
            $primary .= scm_options_get( 'weight', 'heading_1', 1 ) ?: '700';
            $primary .= scm_options_get( 'color', 'heading_1', 1 );
            $primary .= 'margin-bottom:' . ( (float)scm_options_get( 'after', 'heading_1', 0, '' ) - .3 ?: '0' ) . 'em;';

            $secondary = scm_options_get( 'font', 'heading_2', 1 );
            $secondary .= scm_options_get( 'weight', 'heading_2', 1 ) ?: '700';
            $secondary .= scm_options_get( 'color', 'heading_2', 1 );
            $secondary .= 'margin-bottom:' . ( (float)scm_options_get( 'after', 'heading_2', 0, '' ) - .3 ?: '0' ) . 'em;';

            $tertiary = scm_options_get( 'font', 'heading_3', 1 );
            $tertiary .= scm_options_get( 'weight', 'heading_3', 1 ) ?: '700';
            $tertiary .= scm_options_get( 'color', 'heading_3', 1 );
            $tertiary .= 'margin-bottom:' . ( (float)scm_options_get( 'after', 'heading_3', 0, '' ) - .3 ?: '0' ) . 'em;';

            $menu_font = scm_options_get( 'font', 'menu', 1 );
            $sticky_font = scm_options_get( 'font', 'sticky_menu', 1 );

            $top_bg = scm_options_get( 'bg_color', 'topofpage', 1 );
            $top_icon = scm_options_get( 'text_color', 'topofpage', 1 );

            $css = 'html{ ' . $html . ' }' . PHP_EOL;

            $css .= '*, input, textarea{ ' . $font . ' }' . PHP_EOL;

            $css .= 'body { ' . $body . ' }' . PHP_EOL;

            $css .= '.site-page { ' . $opacity . ' }' . PHP_EOL;

            $css .= '.site-content, .site-footer{ ' . $line_height . ' }' . PHP_EOL;

            $css .= '.primary, .primary i { ' . $primary . ' }' . PHP_EOL;
            $css .= '.secondary, .secondary i { ' . $secondary . ' }' . PHP_EOL;
            $css .= '.tertiary, .tertiary i { ' . $tertiary . ' }' . PHP_EOL;


            $css .= '.navigation { ' . $menu_font . ' }' . PHP_EOL;
            $css .= '.navigation.sticky row { ' . $sticky_font . ' }' . PHP_EOL;

            $css .= '.topofpage { ' . $top_bg . ' }' . PHP_EOL;
            $css .= '.topofpage a i { ' . $top_icon . ' }' . PHP_EOL;

            
            if( !empty( $css ) )
                wp_add_inline_style( 'global', $css );

        }
    }

?>