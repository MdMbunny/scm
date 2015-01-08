<?php

// *****************************************************
// *      ACTIONS AND FILTERS
// *****************************************************
        
    add_action( 'after_setup_theme', 'scm_load_textdomain' );
    add_action( 'after_setup_theme', 'scm_default_headers' );

	add_action( 'wp_enqueue_scripts', 'scm_site_assets', 998 );
    add_action( 'comment_form_before', 'scm_enqueue_comments_reply' );
    
    add_filter('body_class','scm_body_hook_class');

    //add_filter( 'pre_get_posts', 'scm_post_hook_pagination' );

    add_filter('synved_social_skin_image_list', 'scm_custom_social_icons');


// *****************************************************
// *       THEME SUPPORT
// *****************************************************

    register_nav_menus( array( 'primary' => __( 'Menu Principale', SCM_THEME ) ) );

    add_editor_style( SCM_REL_CSS . 'editor.css' );
    
    add_theme_support( 'title-tag' );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption' ) );
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'custom-header' );
	add_theme_support( 'custom-background', apply_filters( 'scm_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );


// *****************************************************
// *      LOCALIZATION
// *****************************************************

    
    if ( ! function_exists( 'scm_load_textdomain' ) ) {
        function scm_load_textdomain() {
            load_theme_textdomain( SCM_THEME, SCM_LANG_THEME );
            load_child_theme_textdomain( SCM_CHILD, SCM_LANG_CHILD );
        }
    }

// *****************************************************
// *       HEADERS
// *****************************************************
    
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

// *****************************************************
// *       COMMENTS
// *****************************************************

    if ( ! function_exists( 'scm_enqueue_comments_reply' ) ) {
        function scm_enqueue_comments_reply() {
            if( get_option( 'thread_comments' ) )  {
                wp_enqueue_script( 'comment-reply' );
            }
        }
    }


// *****************************************************
// *      ASSETS AND DESIGN
// *****************************************************

    
//Frontend HTML head assets
    if ( ! function_exists( 'scm_site_assets' ) ) {
        function scm_site_assets() {
        //styles

            wp_enqueue_style( 'animate' );

            wp_enqueue_style( 'fancybox' );
            wp_enqueue_style( 'fancybox-thumbs' );


            wp_enqueue_style( 'global' );
            wp_enqueue_style( 'style' );
            wp_enqueue_style( 'child' );
            //wp_enqueue_style( 'print' );
            wp_enqueue_style( 'fontawesome' );

        //scripts

            wp_enqueue_script( 'scm-functions' );
            wp_enqueue_script( 'imagesloaded' );
            /*wp_enqueue_script( 'navigation' );*/
            wp_enqueue_script( 'single-page-nav' );
            wp_enqueue_script( 'skip-link-focus-fix' );


            wp_enqueue_script('jquery-effects-core');
            wp_enqueue_script( 'bootstrap' );

            wp_enqueue_script( 'fancybox' );
            wp_enqueue_script( 'fancybox-thumbs' );

            wp_enqueue_script( 'gmapapi' );
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