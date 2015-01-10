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

	add_action( 'init', 'scm_register_assets' );
	add_action( 'widgets_init', 'scm_widgets_default' );
        
    add_action( 'after_setup_theme', 'scm_load_textdomain' );
    add_action( 'after_setup_theme', 'scm_default_headers' );
    add_action( 'comment_form_before', 'scm_enqueue_comments_reply' );
    
// *****************************************************
// *      REGISTER STYLES AND SCRIPTS
// *****************************************************


if ( ! function_exists( 'scm_register_assets' ) ) {
	function scm_register_assets() {
		//$protocol = ( is_ssl() ? 'https' : 'http' );
		wp_register_style('fontawesome', SCM_URI_FONT . 'font-awesome/css/font-awesome.min.css', false, SCM_SCRIPTS_VERSION, 'screen' );
		wp_register_script( 'bootstrap', SCM_URI_JS . 'bootstrap-3.1.1.min.js', array( 'jquery' ), SCM_SCRIPTS_VERSION, true );

		if( !is_admin()) :

		    wp_register_style( 'animate', SCM_URI_CSS . 'animate.css', false, SCM_SCRIPTS_VERSION, 'screen' );

            wp_register_style( 'global', SCM_URI . 'style.css', false, SCM_SCRIPTS_VERSION, 'screen' );
            wp_register_style( 'style', SCM_URI_CSS . 'main.css', false, SCM_SCRIPTS_VERSION, 'screen' );

            wp_register_style( 'child', SCM_URI_CHILD . 'style.css', false, SCM_SCRIPTS_VERSION, 'screen' );
            wp_register_style( 'print', SCM_URI_CSS . 'print.css', false, SCM_SCRIPTS_VERSION, 'screen' );

            wp_register_style( 'color-picker', SCM_URI_CSS . 'colorpicker.css', false, SCM_SCRIPTS_VERSION, 'screen' );

        // +++ todo: register only if Fancybox is present into the page

            //for jquery plugins
            wp_register_style( 'fancybox', SCM_URI_JS . 'fancybox/source/jquery.fancybox.css', false, SCM_SCRIPTS_VERSION, 'screen' );
            wp_register_style( 'fancybox-thumbs', SCM_URI_JS . 'fancybox/source/helpers/jquery.fancybox-thumbs.css', false, SCM_SCRIPTS_VERSION, 'screen' );
            

        // +++ todo: register only if Slider is present into the page

            //sliders
            wp_register_style( 'flex', SCM_URI_CSS . 'flex/flex.css', false, SCM_SCRIPTS_VERSION, 'all' );
            wp_register_style( 'nivo', SCM_URI_CSS . 'nivo/nivo.css', false, SCM_SCRIPTS_VERSION, 'all' );
            wp_register_style( 'roundabout', SCM_URI_CSS . 'roundabout/roundabout.css', false, SCM_SCRIPTS_VERSION, 'all' );

            wp_register_script( 'scm-functions', SCM_URI_JS . 'scm-functions.js', array( 'jquery' ), SCM_SCRIPTS_VERSION, true );
            /*wp_register_script( 'navigation', SCM_URI_JS . 'navigation.js', array( 'jquery' ), SCM_SCRIPTS_VERSION, true );*/
            wp_register_script( 'skip-link-focus-fix', SCM_URI_JS . 'skip-link-focus-fix.js', array( 'jquery' ), SCM_SCRIPTS_VERSION, true );
            wp_register_script( 'single-page-nav', SCM_URI_JS . 'jquery.singlePageNav.min.js', array( 'jquery' ), SCM_SCRIPTS_VERSION, true );
            wp_register_script( 'easing', SCM_URI_JS . 'jquery.easing/jquery.easing-1.3.pack.js', array( 'jquery' ), SCM_SCRIPTS_VERSION, true );
            wp_register_script( 'drag', SCM_URI_JS . 'jquery.dragdrop/jquery.event.drag.min.js', array( 'jquery' ), SCM_SCRIPTS_VERSION, true );
            wp_register_script( 'drop', SCM_URI_JS . 'jquery.dragdrop/jquery.event.drop.min.js', array( 'jquery' ), SCM_SCRIPTS_VERSION, true );
            wp_register_script( 'fancybox', SCM_URI_JS . 'fancybox/source/jquery.fancybox.js', array( 'jquery' ), SCM_SCRIPTS_VERSION, true );
            wp_register_script( 'fancybox-thumbs', SCM_URI_JS . 'fancybox/source/helpers/jquery.fancybox-thumbs.js', array( 'jquery' ), SCM_SCRIPTS_VERSION, true );
            wp_register_script( 'color-picker', SCM_URI_JS . 'colorpicker.js', array( 'jquery' ), SCM_SCRIPTS_VERSION, true);
            wp_register_script( 'jquery-cookies', SCM_URI_JS . 'jquery.cookies.js', array( 'jquery' ), SCM_SCRIPTS_VERSION, true );

        //sliders
            wp_register_script( 'flex', SCM_URI_JS . 'flex/jquery.flexslider-min.js', array( 'jquery' ), SCM_SCRIPTS_VERSION, true );
            wp_register_script( 'apply-flex', SCM_URI_JS . 'flex/apply-flex.js.php', array( 'jquery', 'flex' ), SCM_SCRIPTS_VERSION, true );
            wp_register_script( 'nivo', SCM_URI_JS . 'nivo/jquery.nivo.slider.pack.js', array( 'jquery' ), SCM_SCRIPTS_VERSION, true );
            wp_register_script( 'apply-nivo', SCM_URI_JS . 'nivo/apply-nivo.js.php', array( 'jquery', 'nivo' ), SCM_SCRIPTS_VERSION, true );
            wp_register_script( 'roundabout', SCM_URI_JS . 'roundabout/jquery.roundabout.min.js', array( 'jquery' ), SCM_SCRIPTS_VERSION, true );
            wp_register_script( 'roundabout-shapes', SCM_URI_JS . 'roundabout/jquery.roundabout-shapes.min.js', array( 'jquery', 'roundabout' ), SCM_SCRIPTS_VERSION, true );
            wp_register_script( 'apply-roundabout', SCM_URI_JS . 'roundabout/apply-roundabout.js.php', array( 'jquery', 'roundabout' ), SCM_SCRIPTS_VERSION, true );

        //frontend
            wp_register_script( 'bootstrap', SCM_URI_JS . 'bootstrap-3.1.1.min.js', array( 'jquery' ), SCM_SCRIPTS_VERSION, true );
            wp_register_script( 'imagesloaded', SCM_URI_JS . 'imagesloaded/jquery.imagesloaded.min.js', array( 'jquery' ), SCM_SCRIPTS_VERSION, true );
            wp_register_script( 'lwtCountdown', SCM_URI_JS . 'lwtCountdown/jquery.lwtCountdown-1.0.js', array( 'jquery' ), SCM_SCRIPTS_VERSION, true );
            wp_register_script( 'gmapapi', 'https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false', false, '', true );

        else :

            wp_register_style( 'admin', SCM_URI_CSS . 'admin.css', false, SCM_SCRIPTS_VERSION, 'screen' );

       	endif;

	}
}

// *****************************************************
// *       THEME SUPPORT
// *****************************************************


    register_nav_menus( array( 'primary' => __( 'Menu Principale', SCM_THEME ) ) );

    add_editor_style( SCM_URI_CSS . 'editor.css' );
    
    add_theme_support( 'title-tag' );
    add_theme_support( 'automatic-feed-links' );
    add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption' ) );
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'custom-header' );
    add_theme_support( 'custom-background', apply_filters( 'scm_custom_background_args', array(
        'default-color' => 'ffffff',
        'default-image' => '',
    ) ) );


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
// *      HOOKS
// *****************************************************

//*********************************************
//************************ BODY CLASS HOOKS ***
//*********************************************

//Add body class
    if ( ! function_exists( 'scm_body_hook_class' ) ) {
        function scm_body_hook_class($classes) {

            global $SCM_styles;

            // POST and PAGE classes
            global $post;

            $classes[] = SCM_THEME;

            if (is_single() ) {
                foreach((get_the_category($post->ID)) as $category) {
                    $classes[] = 'post-'.$category->category_nicename;
                }
            }
            if (is_page() ) {
                if ($parents = get_post_ancestors($post->ID)) {
                    foreach ((array)$parents as $parent) {
                        if ($page = get_page($parent)) {
                            $classes[] = "{$page->post_type}-{$page->post_name}";
                        }
                    }
                }
                $classes[] = "{$post->post_type}-{$post->post_name}";
            }

            // BROWSER classes
            global $is_gecko, $is_safari, $is_chrome, $is_opera, $is_IE, $is_iphone;

            if ($is_gecko) $classes[] = 'firefox';
            elseif ($is_safari) $classes[] = 'safari';
            elseif ($is_chrome) $classes[] = 'chrome';
            elseif ($is_opera) $classes[] = 'opera';
            elseif ($is_IE) $classes[] = 'ie';
            elseif ($is_iphone) $classes[] = 'safari iphone';
            else $classes[] = 'safari';

            // LANGUAGE classes ----------> NEEDS PolyLang Plugin - (includerlo nel tema?)
            if(function_exists('pll_current_language')){
                $classes[] = 'lang-' . pll_current_language();
            }

            $SCM_styles['align'] = ( get_field('select_txt_alignment', 'option') != 'default' ? get_field('select_txt_alignment', 'option') : 'left');
            $SCM_styles['size'] = ( get_field('select_txt_size', 'option') != 'default' ? get_field('select_txt_size', 'option') : 'normal');
            
            $classes[] = $SCM_styles['align'];
            $classes[] = $SCM_styles['size'];


            return $classes;
        }
    }


//*********************************************
//****************************** POST HOOKS ***
//*********************************************

//Assign custom pagination value to custom type archives
    if ( ! function_exists( 'scm_post_hook_pagination' ) ) {
        function scm_post_hook_pagination( $query ) {
            if(!is_admin()){
                $slug = thePost('type');
                $tax = thePost('taxonomy');
                $term = thePost('term');

                //$pages = scm_option('pagination');
                $typ = ( isset($query->query_vars['post_type']) ? $query->query_vars['post_type'] : '' );
                $page = getByKey($pages, $typ);
                if(!$page) $page = getByKey($pages, $term);
                if(!$page) $page = getByKey($pages, $tax);
                //if(!$page) $page = getByKey($pages, $slug);
                if(!$page) $page = getByKey($pages, 'default');

                $list = $page[0];
                $archive = $page[1];
                if($archive == null) $archive = $list;  

                if(is_archive()) $query->query_vars['posts_per_page'] = $archive ;
                else $query->query_vars['posts_per_page'] = $list ;
            }
            
            return $query;
        }
    }


//*********************************************
//**************************** SOCIAL HOOKS ***
//*********************************************

    if ( ! function_exists( 'scm_custom_social_icons' ) ) {
        function scm_custom_social_icons($image_list) {

            include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
            if ( is_plugin_active( 'social-media-feather/social-media-feather.php' ) ) {

                $soc_shape = get_field('social_follow_shape', 'option');

                $path = get_template_directory() . '/assets/img/icons/social/typeB/' . $soc_shape;
                $baseURL = get_template_directory_uri() . '/assets/img/icons/social/typeB/' . $soc_shape;

                $dirs = glob($path . '/*', GLOB_ONLYDIR);
                $dirs = array_map('basename', $dirs);
                $sizes = array();
                
                foreach ($dirs as $dirname) {

                    $parts = explode('x', $dirname);

                    if (!empty($parts[0])) {
                        $sizes[] = (int) $parts[0];
                    }
                }
                sort($sizes, SORT_NUMERIC);

                foreach (array_keys($image_list) as $site) {
                    $icons = array();
                    foreach ($sizes as $size) {
                        $imagepath = "$path/{$size}x{$size}/$site.png";
                        if (file_exists($imagepath)) {
                            $icons[$size] = array (
                                'name' => "{$size}x{$size}",
                                'sub' => "/$site.png",
                                'path' => $imagepath,
                                'uri' => "$baseURL/{$size}x{$size}/$site.png",
                            );
                        }
                    }

                    if (count($icons) > 0)
                        $image_list[$site] = $icons;
                }

                return $image_list;
            }
        }
    }

?>