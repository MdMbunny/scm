<?php



// *****************************************************
// *      REQUIRED FILES
// *****************************************************


//Slider generator functions
	//require_once( SCM_DIR_SLIDERS . 'flex.php' );
	//require_once( SCM_DIR_SLIDERS . 'nivo.php' );
	//require_once( SCM_DIR_SLIDERS . 'roundabout.php' );



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
                wp_register_style( 'webfonts' . $slug , 'http://fonts.googleapis.com/css?family=' . $family . ':' . $styles, false, SCM_SCRIPTS_VERSION, 'screen' );
                wp_enqueue_style( 'webfonts' . $slug );
                
            }
        }
    }

    //styles
    if ( ! function_exists( 'scm_site_assets_styles' ) ) {
        function scm_site_assets_styles() {

            wp_register_style( 'animate', SCM_URI_CSS . 'animate.css', false, SCM_SCRIPTS_VERSION, 'screen' );
            wp_enqueue_style( 'animate' );
            
            //+++ todo: if Fancybox is on page
            wp_register_style( 'fancybox', SCM_URI_JS . 'fancybox/source/jquery.fancybox.css', false, SCM_SCRIPTS_VERSION, 'screen' );
            wp_register_style( 'fancybox-thumbs', SCM_URI_JS . 'fancybox/source/helpers/jquery.fancybox-thumbs.css', false, SCM_SCRIPTS_VERSION, 'screen' );
            wp_enqueue_style( 'fancybox' );
            wp_enqueue_style( 'fancybox-thumbs' );

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

            //sliders
            /*wp_register_style( 'flex', SCM_URI_CSS . 'flex/flex.css', false, SCM_SCRIPTS_VERSION, 'all' );
            wp_register_style( 'nivo', SCM_URI_CSS . 'nivo/nivo.css', false, SCM_SCRIPTS_VERSION, 'all' );
            wp_register_style( 'roundabout', SCM_URI_CSS . 'roundabout/roundabout.css', false, SCM_SCRIPTS_VERSION, 'all' );
            wp_enqueue_style( 'flex' );
            wp_enqueue_style( 'nivo' );
            wp_enqueue_style( 'roundabout' );*/
            
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

            //+++ todo: if Fancybox is on page
            wp_register_script( 'fancybox', SCM_URI_JS . 'fancybox/source/jquery.fancybox.js', array( 'jquery' ), SCM_SCRIPTS_VERSION, true );
            wp_register_script( 'fancybox-thumbs', SCM_URI_JS . 'fancybox/source/helpers/jquery.fancybox-thumbs.js', array( 'jquery' ), SCM_SCRIPTS_VERSION, true );
            wp_enqueue_script( 'fancybox' );
            wp_enqueue_script( 'fancybox-thumbs' );
            
            //+++ todo: if Google Map is on page
            wp_register_script( 'gmapapi', 'https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false', false, '', true );
            wp_enqueue_script( 'gmapapi' );

            wp_enqueue_script('jquery-effects-core');

            wp_register_script( 'bootstrap', SCM_URI_JS . 'bootstrap-3.1.1.min.js', array( 'jquery' ), SCM_SCRIPTS_VERSION, true );
            wp_enqueue_script( 'bootstrap' );

            // +++ todo: register only if Slider is present into the page
            /* wp_register_script( 'flex', SCM_URI_JS . 'flex/jquery.flexslider-min.js', array( 'jquery' ), SCM_SCRIPTS_VERSION, true );
            wp_register_script( 'apply-flex', SCM_URI_JS . 'flex/apply-flex.js.php', array( 'jquery', 'flex' ), SCM_SCRIPTS_VERSION, true );
            wp_register_script( 'nivo', SCM_URI_JS . 'nivo/jquery.nivo.slider.pack.js', array( 'jquery' ), SCM_SCRIPTS_VERSION, true );
            wp_register_script( 'apply-nivo', SCM_URI_JS . 'nivo/apply-nivo.js.php', array( 'jquery', 'nivo' ), SCM_SCRIPTS_VERSION, true );
            wp_register_script( 'roundabout', SCM_URI_JS . 'roundabout/jquery.roundabout.min.js', array( 'jquery' ), SCM_SCRIPTS_VERSION, true );
            wp_register_script( 'roundabout-shapes', SCM_URI_JS . 'roundabout/jquery.roundabout-shapes.min.js', array( 'jquery', 'roundabout' ), SCM_SCRIPTS_VERSION, true );
            wp_register_script( 'apply-roundabout', SCM_URI_JS . 'roundabout/apply-roundabout.js.php', array( 'jquery', 'roundabout' ), SCM_SCRIPTS_VERSION, true );
            wp_enqueue_script( 'flex' );
            wp_enqueue_script( 'apply-flex' );
            wp_enqueue_script( 'nivo' );
            wp_enqueue_script( 'apply-nivo' );
            wp_enqueue_script( 'roundabout' );
            wp_enqueue_script( 'roundabout-shapes' );
            wp_enqueue_script( 'apply-roundabout' );*/
            

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

    if ( ! function_exists( 'scm_site_assets_get_fonts' ) ) {
        function scm_site_assets_get_fonts( $type ) {

            $target = 'option';
            if( gettype( $type ) == 'integer' ){
                $target = $type;
                $type = '';
            }else{
                $type = '_' . $type;
            }



            $webfont = ( get_field( 'select_webfonts_families' . $type, $target ) != 'default' ? get_field( 'select_webfonts_families' . $type, $target ) : '' );
            $family = ( get_field( 'select_webfonts_default_families' . $type, $target ) != 'default' ? get_field( 'select_webfonts_default_families' . $type, $target ) : get_field( 'select_webfonts_default_families', 'option' ) );
            return ( !$webfont ? '' : font2string( $webfont, $family, false ) );
        }
    }

    if ( ! function_exists( 'scm_site_assets_styles_inline' ) ) {
        function scm_site_assets_styles_inline() {

            $align = ( get_field('select_txt_alignment', 'option') != 'default' ? get_field('select_txt_alignment', 'option') : 'left');
            $size = scm_acf_select_preset( 'select_txt_font_size', ( get_field('select_txt_size', 'option') != 'default' ? get_field('select_txt_size', 'option') : 'normal' ) );

            $alpha = ( get_field('text_alpha', 'option') != null ? get_field('text_alpha', 'option') : 1 );
            $color = hex2rgba( ( get_field('text_color', 'option') ? get_field('text_color', 'option') : '#000000' ), $alpha );
            $opacity = ( get_field('text_opacity', 'option') != null ? get_field('text_opacity', 'option') : 1);
            $shadow = ( get_field('text_shadow', 'option') ? get_field('text_shadow_x', 'option') . 'px ' . get_field('text_shadow_y', 'option') . 'px ' . get_field('text_shadow_size', 'option') . 'px rgba(' . hex2rgba( ( get_field('text_shadow_color', 'option') ? get_field('text_shadow_color', 'option') : '#000000'), ( get_field('text_shadow_alpha', 'option') != null ? get_field('text_shadow_alpha', 'option') : 1 ), true ) . ')' : 'none' );

            $webfont = ( get_field( 'select_webfonts_families', 'option' ) ? get_field( 'select_webfonts_families', 'option' ) : '' );
            $family = ( get_field( 'select_webfonts_default_families', 'option' ) ? get_field( 'select_webfonts_default_families', 'option' ) : '' );
            $font = font2string( $webfont, $family );

            //$line_height = (string)(float)substr($size, 0, -2) * (float)( get_field('select_line_height', 'option') != 'default' ? get_field('select_line_height', 'option') : '1.5') . 'px';
            $line_height = (string)(100 * (float)( get_field('select_line_height', 'option') != 'default' ? get_field('select_line_height', 'option') : '1.5')) . '%';
            
            $weight = ( get_field('select_font_weight', 'option') != 'default' ? get_field('select_font_weight', 'option') : '400');

            $bg_image = ( get_field('background_image', 'option') ? 'url(' . get_field('background_image', 'option') . ')' : 'none' );
            $bg_repeat = ( get_field('select_bg_repeat', 'option') != 'default' ? get_field('select_bg_repeat', 'option') : 'no-repeat' );
            $bg_position = ( get_field('select_bg_position', 'option') != null ? get_field('select_bg_position', 'option') : 'center center' );
            $bg_size = ( get_field('background_size', 'option') != null ? get_field('background_size', 'option') : 'auto' );
            $bg_alpha = ( get_field('background_alpha', 'option') != null ? get_field('background_alpha', 'option') : 1 );
            $bg_color = hex2rgba( ( get_field('background_color', 'option') != null ? get_field('background_color', 'option') : '#FFFFFF' ), $bg_alpha );
            $margin = ( get_field('margin', 'option') != null ? get_field('margin', 'option') : '0');
            $padding = ( get_field('padding', 'option') != null ? get_field('padding', 'option') : '0');

            $heading_font_1 = ( scm_site_assets_get_fonts( 'heading_1' ) ? scm_site_assets_get_fonts( 'heading_1' ) : '' );
            $heading_weight_1 = ( get_field('select_font_weight_heading_1', 'option') != 'default' ? get_field('select_font_weight_heading_1', 'option') : '700');
            $heading_color_1 = ( get_field('color_heading_1', 'option') !=null ? hex2rgba( get_field('color_heading_1', 'option'), $alpha ) : $color );
            $heading_after_1 = ( get_field('select_line_height_heading_1', 'option') != 'default' ? get_field('select_line_height_heading_1', 'option') . 'em' : '0em');

            $heading_font_2 = ( scm_site_assets_get_fonts( 'heading_2' ) ? scm_site_assets_get_fonts( 'heading_2' ) : '' );
            $heading_weight_2 = ( get_field('select_font_weight_heading_2', 'option') != 'default' ? get_field('select_font_weight_heading_2', 'option') : '700');
            $heading_color_2 = ( get_field('color_heading_2', 'option') !=null ? hex2rgba( get_field('color_heading_2', 'option'), $alpha ) : $color );
            $heading_after_2 = ( get_field('select_line_height_heading_2', 'option') != 'default' ? get_field('select_line_height_heading_2', 'option') . 'em' : '0em');

            $heading_font_3 = ( scm_site_assets_get_fonts( 'heading_3' ) ? scm_site_assets_get_fonts( 'heading_3' ) : '' );
            $heading_weight_3 = ( get_field('select_font_weight_heading_3', 'option') != 'default' ? get_field('select_font_weight_heading_3', 'option') : '700');
            $heading_color_3 = ( get_field('color_heading_3', 'option') !=null ? hex2rgba( get_field('color_heading_3', 'option'), $alpha ) : $color );
            $heading_after_3 = ( get_field('select_line_height_heading_3', 'option') != 'default' ? get_field('select_line_height_heading_3', 'option') . 'em' : '0em');

            $menu_font = ( scm_site_assets_get_fonts( 'menu' ) ? scm_site_assets_get_fonts( 'menu' ) : '' );
            $sticky_font = ( scm_site_assets_get_fonts( 'sticky_menu' ) ? scm_site_assets_get_fonts( 'sticky_menu' ) : '' );

            $css = '
                *, input, textarea{
                    font-family: ' . $font . ';
                }

                body {
                    background-color: ' . $bg_color . ';
                    background-image: ' . $bg_image . ';
                    background-repeat: ' . $bg_repeat . ';
                    background-position: ' . $bg_position . ';
                    background-size: ' . $bg_size . ';
                    text-shadow: ' . $shadow . ';
                    margin: ' . $margin . ';
                    padding: ' . $padding . ';
                    text-align: ' . $align . ';
                    
                    font-size: ' . $size . ';
                    font-weight: ' . $weight . ';
                    color: ' . $color . ';
                }

                .site-page {
                    opacity: ' . $opacity . ';
                }

                .site-content,
                .site-footer{
                    line-height: ' . $line_height . ';
                }

                .primary,
                .primary i {' .
                    ( $heading_font_1 ? 'font-family: ' . $heading_font_1 . ';' : '' )
                . ' font-weight: ' . $heading_weight_1 . ';
                    color: ' . $heading_color_1 . ';
                    margin-bottom: ' . $heading_after_1 . ';
                }

                .secondary,
                .secondary i {' .
                    ( $heading_font_2 ? 'font-family: ' . $heading_font_2 . ';' : '' )
                . ' font-weight: ' . $heading_weight_2 . ';
                    color: ' . $heading_color_2 . ';
                    margin-bottom: ' . $heading_after_2 . ';
                }

                .tertiary,
                .tertiary i {' .
                    ( $heading_font_3 ? 'font-family: ' . $heading_font_3 . ';' : '' )
                . ' font-weight: ' . $heading_weight_3 . ';
                    color: ' . $heading_color_3 . ';
                    margin-bottom: ' . $heading_after_3 . ';
                }

                .navigation {' .
                    ( $menu_font ? 'font-family: ' . $menu_font . ';' : '' )
                . '}

                .navigation.sticky row {' .
                    ( $sticky_font ? 'font-family: ' . $sticky_font . ';' : '' )
                . '}';

            
            if( !empty( $css ) )
                wp_add_inline_style( 'global', $css );

        }
    }

?>