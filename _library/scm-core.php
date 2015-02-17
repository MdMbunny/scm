<?php


// INTERESSANTE FUNZIONE IN HOOK INIT, PER SALVARE TUTTI O UNA PARTE DEI POST

/*add_action('init','savePosts');

function savePosts(){

    $my_types = get_post_types();
    $my_posts = get_posts( array( 'post_type' => $my_types, 'posts_per_page' => -1) );

    alert( sizeof($my_posts) );

    foreach ( $my_posts as $my_post ): 

    wp_update_post( $my_post );

    endforeach;
}*/


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

    add_action( 'wp_ajax_scm_anchor', 'scm_anchor' );
    add_action( 'wp_ajax_nopriv_scm_anchor', 'scm_anchor' );

    add_action( 'wp_footer', 'scm_jquery_init' );

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

            /*wp_deregister_style( 'jquery.mobile' );
            wp_register_style( 'jquery.mobile', 'https://ajax.googleapis.com/ajax/libs/jquerymobile/1.4.3/jquery.mobile.min.css', false, SCM_SCRIPTS_VERSION, 'screen' );
            wp_enqueue_style( 'jquery.mobile' );*/

            wp_register_style( 'animate', SCM_URI_CSS . 'animate.css', false, SCM_SCRIPTS_VERSION, 'screen' );
            //wp_enqueue_style( 'animate' );
            
            if( get_field( 'tools_fancybox_active', 'option' ) ){
                wp_register_style( 'fancybox', SCM_URI_CSS . 'fancybox/jquery.fancybox.css', false, SCM_SCRIPTS_VERSION, 'screen' );
                wp_register_style( 'fancybox-thumbs', SCM_URI_CSS . 'fancybox/helpers/jquery.fancybox-thumbs.css', false, SCM_SCRIPTS_VERSION, 'screen' );
                //wp_register_style( 'fancybox-buttons', SCM_URI_JS . 'fancybox/source/helpers/jquery.fancybox-buttons.css', false, SCM_SCRIPTS_VERSION, 'screen' );
                wp_enqueue_style( 'fancybox' );
                wp_enqueue_style( 'fancybox-thumbs' );
                //wp_enqueue_style( 'fancybox-buttons' );
            }

            if( get_field( 'select_slider', 'option' ) == 'nivo' ){
                wp_register_style( 'nivo', SCM_URI_CSS . 'nivo/nivo-slider.css', false, SCM_SCRIPTS_VERSION, 'all' );
                wp_register_style( 'nivo-default', SCM_URI_CSS . 'nivo/themes/default/default.css', false, SCM_SCRIPTS_VERSION, 'all' );
                wp_enqueue_style( 'nivo' );
                wp_enqueue_style( 'nivo-default' );
            }

            //+++ todo: if Color Picker is on page [check how to integrate it]
            //wp_register_style( 'color-picker', SCM_URI_CSS . 'colorpicker.css', false, SCM_SCRIPTS_VERSION, 'screen' );
            //wp_register_script( 'color-picker', SCM_URI_JS . 'colorpicker.js', array( 'jquery' ), SCM_SCRIPTS_VERSION, true);

            wp_register_style( 'global', SCM_URI . 'style.css', false, SCM_SCRIPTS_VERSION, 'screen' );
            wp_enqueue_style( 'global' );

            wp_register_style( 'child', SCM_URI_CHILD . 'style.css', false, SCM_SCRIPTS_VERSION, 'screen' );
            wp_enqueue_style( 'child' );

            // +++ todo: if html header is PRINT
            //wp_register_style( 'print', SCM_URI_CSS . 'print.css', false, SCM_SCRIPTS_VERSION, 'screen' );
            //wp_enqueue_style( 'print' );

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

        }
    }

    // See scm-styles.php for inline styles 
    
    //scripts
    if ( ! function_exists( 'scm_site_assets_scripts' ) ) {
        function scm_site_assets_scripts() {

            wp_enqueue_script('jquery-effects-core');

            // jQuery Mobile

            /*wp_deregister_script( 'jquery.mobile' );
            wp_register_script( 'jquery.mobile', 'https://ajax.googleapis.com/ajax/libs/jquerymobile/1.4.3/jquery.mobile.min.js', array( 'jquery' ), SCM_SCRIPTS_VERSION, true );
            wp_enqueue_script( 'jquery.mobile' );*/
            
            wp_deregister_script( 'jquery.mobile' );
            wp_register_script( 'jquery.mobile', SCM_URI_JS . 'jquery.mobile/jquery.mobile.custom.touch.min.js', array( 'jquery' ), SCM_SCRIPTS_VERSION, true );
            wp_enqueue_script( 'jquery.mobile' );

            // jQuery TouchSwipe

            wp_deregister_script( 'jquery.touchSwipe' );
            wp_register_script( 'jquery.touchSwipe', SCM_URI_JS . 'jquery.touchSwipe/jquery.touchSwipe.min.js', array( 'jquery' ), SCM_SCRIPTS_VERSION, true );
            wp_enqueue_script( 'jquery.touchSwipe' );

            // Modernizr

            // *Complete
            /*wp_register_script( 'modernizr', SCM_URI_JS . 'modernizr.custom.js', array( 'jquery' ), false, false );
            wp_enqueue_script( 'modernizr' );*/
            // *Basic
            wp_register_script( 'modernizr-basic', SCM_URI_JS . 'modernizr/modernizr.custom.basic.js', array( 'jquery' ), SCM_SCRIPTS_VERSION, true );
            wp_enqueue_script( 'modernizr-basic' );
            // *Touch
            wp_register_script( 'modernizr-touch', SCM_URI_JS . 'modernizr/modernizr.custom.touch.js', array( 'jquery' ), SCM_SCRIPTS_VERSION, true );
            wp_enqueue_script( 'modernizr-touch' );
            
            // Bootstrap
            
            wp_register_script( 'bootstrap', SCM_URI_JS . 'bootstrap-3.3.2.min.js', array( 'jquery' ), SCM_SCRIPTS_VERSION, true );
            wp_enqueue_script( 'bootstrap' );


            wp_register_script( 'imagesloaded', SCM_URI_JS . 'imagesloaded/jquery.imagesloaded.min.js', array( 'jquery' ), SCM_SCRIPTS_VERSION, true );
            wp_enqueue_script( 'imagesloaded' );

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

            if( get_field( 'select_slider', 'option' ) == 'nivo' ){
                wp_register_script( 'nivo', SCM_URI_JS . 'nivo/jquery.nivo.slider.pack.js', array( 'jquery' ), SCM_SCRIPTS_VERSION, true );
                wp_enqueue_script( 'nivo' );
            }

            wp_register_script( 'gmapapi', 'https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false', false, '', true );
            wp_enqueue_script( 'gmapapi' );

            wp_register_script( 'jquery-transform-2d', SCM_URI_JS . 'jquery.transform/jquery.transform2d.js', array( 'jquery' ), SCM_SCRIPTS_VERSION, true );
            wp_enqueue_script( 'jquery-transform-2d' );

            wp_register_script( 'jquery-transform-3d', SCM_URI_JS . 'jquery.transform/jquery.transform3d.js', array( 'jquery' ), SCM_SCRIPTS_VERSION, true );
            wp_enqueue_script( 'jquery-transform-3d' );

            
            wp_register_script( 'jquery-scm-functions', SCM_URI_JS . 'jquery.scm/jquery.functions.js', array( 'jquery' ), SCM_SCRIPTS_VERSION, true );
            wp_enqueue_script( 'jquery-scm-functions' );
            
            wp_register_script( 'jquery-scm-plugins', SCM_URI_JS . 'jquery.scm/jquery.plugins.js', array( 'jquery' ), SCM_SCRIPTS_VERSION, true );
            wp_enqueue_script( 'jquery-scm-plugins' );

            wp_register_script( 'jquery-scm-tools', SCM_URI_JS . 'jquery.scm/jquery.tools.js', array( 'jquery' ), SCM_SCRIPTS_VERSION, true );
            wp_enqueue_script( 'jquery-scm-tools' );

            wp_register_script( 'jquery-scm', SCM_URI_JS . 'jquery.scm/jquery.scm.js', array( 'jquery' ), SCM_SCRIPTS_VERSION, true );
            wp_enqueue_script( 'jquery-scm' );


            wp_register_script( 'jquery-scm-child', SCM_URI_JS_CHILD . '/jquery.scm-child.js', array( 'jquery' ), SCM_SCRIPTS_VERSION, true );
            wp_enqueue_script( 'jquery-scm-child' );

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
            $html .= ( scm_options_get( 'bg_image', 'loading', 1 ) ?: '' );// 'background-image:url(' . SCM_URI_IMG . '/loading.gif);' );
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
            $body .= scm_options_get( 'bg_image', 'sc', 1 );
            $body .= scm_options_get( 'bg_repeat', 'sc', 1 );
            $body .= scm_options_get( 'bg_position', 'sc', 1 );
            $body .= scm_options_get( 'bg_size', 'sc', 1 );
            $body .= scm_options_get( 'bg_color', 'sc', 1 );

            $content = scm_options_get( 'bg_image', 'option', 1 );
            $content .= scm_options_get( 'bg_repeat', 'option', 1 );
            $content .= scm_options_get( 'bg_position', 'option', 1 );
            $content .= scm_options_get( 'bg_size', 'option', 1 );
            $content .= scm_options_get( 'bg_color', 'option', 1 );
            
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

            $top_bg = scm_options_get( 'bg_color', 'topofpage', 1 );
            $top_icon = scm_options_get( 'text_color', 'topofpage', 1 );


            // Print Main Style

            $css = lbreak() . 'html{ ' . $html . ' }' . lbreak();

            $css .= '*, input, textarea{ ' . $font . ' }' . lbreak();

            $css .= 'body { ' . $body . ' }' . lbreak();

            $css .= '.site-page { ' . $opacity . ' }' . lbreak();

            $css .= '.site-content{ ' . $content . ' }' . lbreak();

            $css .= '.site-content, .site-footer{ ' . $line_height . ' }' . lbreak();

            $css .= '.primary, .primary i { ' . $primary . ' }' . lbreak();
            $css .= '.secondary, .secondary i { ' . $secondary . ' }' . lbreak();
            $css .= '.tertiary, .tertiary i { ' . $tertiary . ' }' . lbreak();

            $css .= '.navigation { ' . $menu_font . ' }' . lbreak();

            $css .= '.topofpage { ' . $top_bg . ' }' . lbreak();
            $css .= '.topofpage a i { ' . $top_icon . ' }' . lbreak();


            // Responsive

            $r_desktop = intval( scm_options_get( 'size', 'option' ) ) + intval( get_field( 'font_size_desktop', 'option' ) );
            $css .= 'body.desktop { font-size: ' . $r_desktop . 'px; }' . lbreak();

            $r_wide = intval( scm_options_get( 'size', 'option' ) ) + intval( get_field( 'font_size_wide', 'option' ) );
            $css .= 'body.wide { font-size: ' . $r_wide . 'px; }' . lbreak();

            $r_landscape = intval( scm_options_get( 'size', 'option' ) ) + intval( get_field( 'font_size_landscape', 'option' ) );
            $css .= 'body.landscape { font-size: ' . $r_landscape . 'px; }' . lbreak();

            $r_portrait = intval( scm_options_get( 'size', 'option' ) ) + intval( get_field( 'font_size_portrait', 'option' ) );
            $css .= 'body.portrait { font-size: ' . $r_portrait . 'px; }' . lbreak();

            $r_smart = intval( scm_options_get( 'size', 'option' ) ) + intval( get_field( 'font_size_smart', 'option' ) );
            $css .= 'body.smart { font-size: ' . $r_smart . 'px; }' . lbreak();

            $r_full = ( get_field( 'select_responsive_events_tofull', 'option' ) ?: '' );
            if( $r_full )
                $css .= '.' . $r_full . ' .responsive { width: 100%; }' . lbreak();

            
            if( !empty( $css ) )
                wp_add_inline_style( 'global', $css );

        }
    }

// *****************************************************
// *      INITIALIZE
// *****************************************************

    // Used by jQuery to get stored ANCHOR data - [ for smooth scroll from page to page ]
    if ( ! function_exists( 'scm_jquery_init' ) ) {
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

            global $SCM_galleries;
            
            $anchor = get_option( 'scm-utils-anchor' );

        ?>

<script type="text/javascript">

    var GALLERIES = <?php echo json_encode($SCM_galleries) ?>;

    jQuery(document).ready(function($){

        $( window ).load( function(e){
            <?php update_option( 'scm-utils-anchor', '' ); ?>
        } );

        var anchor = <?php echo json_encode( $anchor ); ?>;
        $( 'body' ).attr( 'data-anchor', anchor );

    });
    
</script>

        <?php
        }
    }

?>