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
    add_action( 'admin_enqueue_scripts', 'scm_admin_assets', 998 );

	add_action( 'widgets_init', 'scm_widgets_default' );
        
    add_action( 'after_setup_theme', 'scm_load_textdomain' );
    //add_action( 'after_setup_theme', 'scm_default_headers' );
    //add_action( 'comment_form_before', 'scm_enqueue_comments_reply' );

    add_action( 'wp_ajax_scm_anchor', 'scm_anchor' );
    add_action( 'wp_ajax_nopriv_scm_anchor', 'scm_anchor' );

    add_action( 'wp_footer', 'scm_jquery_init' );




// *****************************************************
// *       1.0 THEME SUPPORT
// *****************************************************

    register_nav_menus( array( 'primary' => __( 'Menu Principale', SCM_THEME ) ) );
    register_nav_menus( array( 'secondary' => __( 'Menu Secondario', SCM_THEME ) ) );
    register_nav_menus( array( 'temporary' => __( 'Menu Temporaneo', SCM_THEME ) ) );
    
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
// *      2.0 REGISTER AND ENQUEUE STYLES
// *****************************************************            

    //google fonts
    if ( ! function_exists( 'scm_site_assets_webfonts_google' ) ) {
        function scm_site_assets_webfonts_google() {
            $fonts =  scm_field( 'styles-google', array(), 'option' );
            foreach ($fonts as $value) {    
                $slug = sanitize_title( $value['family'] );           
                $family = str_replace( ' ', '+', $value['family'] );
                $styles = implode( ',', $value['style'] );
                wp_register_style( 'webfonts-google-' . $slug , 'http://fonts.googleapis.com/css?family=' . $family . ':' . $styles, false, SCM_SCRIPTS_VERSION, 'screen' );
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

            if( get_field( 'opt-tools-slider', 'option' ) == 'nivo' ){
                wp_register_style( 'nivo', SCM_URI_CSS . 'nivoSlider-3.2/nivo-slider.css', false, SCM_SCRIPTS_VERSION, 'all' );
                //wp_register_style( 'nivo-theme', SCM_URI_CSS . 'nivoSlider-3.2/themes/default/default.css', false, SCM_SCRIPTS_VERSION, 'all' );
                wp_register_style( 'nivo-theme', SCM_URI_CSS . 'nivoSlider-3.2/themes/scm/scm.css', false, SCM_SCRIPTS_VERSION, 'all' );
                wp_enqueue_style( 'nivo' );
                wp_enqueue_style( 'nivo-theme' );
            }

            // Font Awesome
            
            //wp_register_style('fontawesome', SCM_URI_FONT . 'font-awesome/css/font-awesome.min.css', false, SCM_SCRIPTS_VERSION, 'screen' );
            //wp_enqueue_style( 'fontawesome' );

            global $wp_styles, $is_IE;
            wp_enqueue_style( 'font-awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css', array(), '4.3.0' );
            if ( $is_IE ) {
                wp_enqueue_style( 'font-awesome-ie', '//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome-ie7.min.css', array('font-awesome'), '4.3.0' );
                // Add IE conditional tags for IE 7 and older
                $wp_styles->add_data( 'font-awesome-ie', 'conditional', 'lte IE 7' );
            }

            // SCM

            wp_register_style( 'global', SCM_URI . 'style.css', false, SCM_SCRIPTS_VERSION, 'screen' );
            wp_enqueue_style( 'global' );

            // SCM Child

            wp_register_style( 'child', SCM_URI_CHILD . 'style.css', false, SCM_SCRIPTS_VERSION, 'screen' );
            wp_enqueue_style( 'child' );

            // SCM Print

            // +++ todo: if html header is PRINT
            //wp_register_style( 'print', SCM_URI_CSS . 'print.css', false, SCM_SCRIPTS_VERSION, 'screen' );
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
                $family = str_replace( ' ', '+', $value['family'] );
                $styles = implode( ',', $value['select_webfonts_google_styles'] );
                wp_register_script( 'webfonts-adobe-' . $slug , '//use.typekit.net/' . $id . '.js', false, SCM_SCRIPTS_VERSION, 'screen' );
                wp_enqueue_script( 'webfonts-adobe-' . $slug );
                
            }

            //echo '<script>try{Typekit.load();}catch(e){}</script>';
        }
    }
    
    //scripts
    if ( ! function_exists( 'scm_site_assets_scripts' ) ) {
        function scm_site_assets_scripts() {

            // Select2 Events

            /*wp_register_script( 'select2', SCM_URI_JS . 'select2.js', array( 'jquery' ), SCM_SCRIPTS_VERSION, true );
            wp_enqueue_script( 'select2' );*/

            // Skip Link Focus Fix

            wp_register_script( 'skip-link-focus-fix', SCM_URI_JS . 'skip-link-focus-fix.js', array( 'jquery' ), SCM_SCRIPTS_VERSION, true );
            wp_enqueue_script( 'skip-link-focus-fix' );

            // jQuery Effects Core

            wp_enqueue_script('jquery-effects-core');

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
            
            wp_register_script( 'bootstrap', '//maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js', array( 'jquery' ), SCM_SCRIPTS_VERSION, true );
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

            //wp_register_script( 'parallax',  SCM_URI_JS . 'parallax.js-1.3.1/parallax.min.js', false, '', true );
            //wp_enqueue_script( 'parallax' );

            //wp_register_script( 'sequence',  SCM_URI_JS . 'Sequence/jquery.sequence-min.js', false, '', true );
            //wp_enqueue_script( 'sequence' );

            // Nivo Slider

            if( get_field( 'opt-tools-slider', 'option' ) == 'nivo' ){
                wp_register_script( 'nivo', SCM_URI_JS . 'nivoSlider-3.2/jquery.nivo.slider.pack.js', array( 'jquery' ), SCM_SCRIPTS_VERSION, true );
                wp_enqueue_script( 'nivo' );
            }

            // Google Maps

            wp_register_script( 'gmapapi', 'https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false', false, '', true );
            wp_enqueue_script( 'gmapapi' );

            wp_register_script( 'gmapmarker', 'http://google-maps-utility-library-v3.googlecode.com/svn/trunk/markerwithlabel/src/markerwithlabel.js', false, '', true );
            wp_enqueue_script( 'gmapmarker' );

            // SCM

            wp_register_script( 'jquery-scm-functions', SCM_URI_JS . 'jquery.scm/jquery.functions.js', array( 'jquery' ), SCM_SCRIPTS_VERSION, true );
            wp_enqueue_script( 'jquery-scm-functions' );
            
            wp_register_script( 'jquery-scm-plugins', SCM_URI_JS . 'jquery.scm/jquery.plugins.js', array( 'jquery' ), SCM_SCRIPTS_VERSION, true );
            wp_enqueue_script( 'jquery-scm-plugins' );

            wp_register_script( 'jquery-scm-tools', SCM_URI_JS . 'jquery.scm/jquery.tools.js', array( 'jquery' ), SCM_SCRIPTS_VERSION, true );
            wp_enqueue_script( 'jquery-scm-tools' );

            wp_register_script( 'jquery-scm', SCM_URI_JS . 'jquery.scm/jquery.scm.js', array( 'jquery' ), SCM_SCRIPTS_VERSION, true );
            wp_enqueue_script( 'jquery-scm' );

            // SCM Child

            wp_register_script( 'jquery-scm-child', SCM_URI_JS_CHILD . '/jquery.scm-child.js', array( 'jquery-scm' ), SCM_SCRIPTS_VERSION, true );
            wp_enqueue_script( 'jquery-scm-child' );

        }
    }

     if ( ! function_exists( 'scm_admin_assets' ) ) {
        function scm_admin_assets() {

            wp_register_style( 'admin', SCM_URI_CSS . 'admin.css', false, SCM_SCRIPTS_VERSION, 'screen' );
            wp_enqueue_style('admin');

            wp_register_script( 'jquery-scm-admin', SCM_URI_JS . 'jquery.scm/jquery.admin.js', array( 'jquery' ), SCM_SCRIPTS_VERSION, true );
            wp_enqueue_script( 'jquery-scm-admin' );
            
        }
    } 

// *****************************************************
// *      4.0 HEADER STYLES
// *****************************************************


    if ( ! function_exists( 'scm_site_assets_styles_inline' ) ) {
        function scm_site_assets_styles_inline() {

            $html = scm_options_get( 'bg_color', 'loading', 1 );
            $html .= ( scm_options_get( 'bg_image', 'loading', 1 ) ?: '' );
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
            /*$body .= scm_options_get( 'bg_image', 'sc', 1 );
            $body .= scm_options_get( 'bg_repeat', 'sc', 1 );
            $body .= scm_options_get( 'bg_position', 'sc', 1 );
            $body .= scm_options_get( 'bg_size', 'sc', 1 );
            $body .= scm_options_get( 'bg_color', 'sc', 1 );*/

            $body .= scm_options_get( 'bg_image', 'option', 1 );
            $body .= scm_options_get( 'bg_repeat', 'option', 1 );
            $body .= scm_options_get( 'bg_position', 'option', 1 );
            $body .= scm_options_get( 'bg_size', 'option', 1 );
            $body .= scm_options_get( 'bg_color', 'option', 1 );
            
            /*$primary = scm_options_get( 'font', 'heading_1', 1 );
            $primary .= scm_options_get( 'weight', 'heading_1', 1 ) ?: '700';
            $primary .= scm_options_get( 'color', 'heading_1', 1 );
            $primary .= 'margin-bottom:' . ( (float)scm_options_get( 'after', 'heading_1', 0, '' ) ?: '0' ) . 'em;';
            //$primary .= 'margin-bottom:' . ( (float)scm_options_get( 'after', 'heading_1', 0, '' ) - .3 ?: '0' ) . 'em;';

            $secondary = scm_options_get( 'font', 'heading_2', 1 );
            $secondary .= scm_options_get( 'weight', 'heading_2', 1 ) ?: '700';
            $secondary .= scm_options_get( 'color', 'heading_2', 1 );
            $secondary .= 'margin-bottom:' . ( (float)scm_options_get( 'after', 'heading_2', 0, '' ) ?: '0' ) . 'em;';
            //$secondary .= 'margin-bottom:' . ( (float)scm_options_get( 'after', 'heading_2', 0, '' ) - .3 ?: '0' ) . 'em;';

            $tertiary = scm_options_get( 'font', 'heading_3', 1 );
            $tertiary .= scm_options_get( 'weight', 'heading_3', 1 ) ?: '700';
            $tertiary .= scm_options_get( 'color', 'heading_3', 1 );
            $tertiary .= 'margin-bottom:' . ( (float)scm_options_get( 'after', 'heading_3', 0, '' ) ?: '0' ) . 'em;';
            //$tertiary .= 'margin-bottom:' . ( (float)scm_options_get( 'after', 'heading_3', 0, '' ) - .3 ?: '0' ) . 'em;';*/

            $menu_font = scm_options_get( 'font', 'menu', 1 );

            $top_bg = scm_options_get( 'bg_color', 'topofpage', 1 );
            $top_icon = scm_options_get( 'text_color', 'topofpage', 1 );


            // Print Main Style

            $css = lbreak() . 'html{ ' . $html . ' }' . lbreak();

            $css .= '*, input, textarea{ ' . $font . ' }' . lbreak();

            $css .= 'body { ' . $body . ' }' . lbreak();

            $css .= '.site-page { ' . $opacity . ' }' . lbreak();

            //$css .= '.site-content{ ' . $content . ' }' . lbreak();

            $css .= '.site-content, .site-footer{ ' . $line_height . ' }' . lbreak();

            /*$css .= '.primary, .primary i { ' . $primary . ' }' . lbreak();
            $css .= '.secondary, .secondary i { ' . $secondary . ' }' . lbreak();
            $css .= '.tertiary, .tertiary i { ' . $tertiary . ' }' . lbreak();*/

            $css .= '.navigation { ' . $menu_font . ' }' . lbreak();

            $css .= '.topofpage { ' . $top_bg . ' }' . lbreak();
            $css .= '.topofpage a i { ' . $top_icon . ' }' . lbreak();


            // Responsive

            $r_max = (int)scm_field( 'select_responsive_layouts_max', '1400', 'option' );
            
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

            $r_full = scm_field( 'select_responsive_events_tofull', '', 'option' );
        
            if( $r_full )
                $css .= '.' . $r_full . ' .responsive { width: 100%; }' . lbreak();

            $css .= '.smart .responsive { width: 100%; }' . lbreak();

            $r_desktop = (int)scm_options_get( 'size', 'option' ) + (int)scm_field( 'styles-size-desktop', -1, 'option' );
            $css .= 'body.desktop { font-size: ' . $r_desktop . 'px; }' . lbreak();

            $r_wide = (int)scm_options_get( 'size', 'option' ) + (int)scm_field( 'styles-size-wide', 0, 'option' );
            $css .= 'body.wide { font-size: ' . $r_wide . 'px; }' . lbreak();

            $r_landscape = (int)scm_options_get( 'size', 'option' ) + (int)scm_field( 'styles-size-landscape', 1, 'option' );
            $css .= 'body.landscape { font-size: ' . $r_landscape . 'px; }' . lbreak();

            $r_portrait = (int)scm_options_get( 'size', 'option' ) + (int)scm_field( 'styles-size-portrait', 2, 'option' );
            $css .= 'body.portrait { font-size: ' . $r_portrait . 'px; }' . lbreak();

            $r_smart = (int)scm_options_get( 'size', 'option' ) + (int)scm_field( 'styles-size-smart', 3, 'option' );
            $css .= 'body.smart { font-size: ' . $r_smart . 'px; }' . lbreak();

            
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

    // Used by jQuery to get stored ANCHOR data - [ for smooth scroll from page to page ]
    if ( ! function_exists( 'scm_anchor' ) ) {
        function scm_anchor() {
            $new_value = ( $_POST['data'] ?: '' );

                update_option( 'scm-utils-anchor', $new_value );

                if( !$new_value )
                    die( false );
                else
                    die( true );

        }
    }

    //Initialize
    if ( ! function_exists( 'scm_jquery_init' ) ) {
        function scm_jquery_init(){

            global $SCM_site, $SCM_galleries;
            
        ?>

<script type="text/javascript">

console.log( 'read' );

    var GALLERIES = <?php echo json_encode($SCM_galleries); ?>;

    jQuery(document).ready(function($){

        var site = <?php echo json_encode( $SCM_site ); ?>;
        $( 'body' ).data( 'site', site );

    });
    
</script>

        <?php
        }
    }

?>