<?php

// *****************************************************
// *      ACTIONS AND FILTERS
// *****************************************************

    add_action( 'wp_enqueue_scripts', 'scm_site_assets_favicon' );
    add_filter('body_class','scm_body_hook_class');
    //add_filter( 'pre_get_posts', 'scm_post_hook_pagination' );
    add_filter('synved_social_skin_image_list', 'scm_custom_social_icons');

// *****************************************************
// *      HOOKS
// *****************************************************

//************************ FAVICON ***

    //favicon / touch-icons
    if ( ! function_exists( 'scm_site_assets_favicon' ) ) {
        function scm_site_assets_favicon() {

            $out = '';

            if ( get_field('branding_icon_144', 'option') )
                $out .= '<link rel="apple-touch-icon-precomposed" sizes="144x144" href="' . esc_url( get_field('branding_icon_144', 'option') ) . '" /> <!-- for retina iPad -->';
            if ( get_field('branding_icon_114', 'option') )
                $out .= '<link rel="apple-touch-icon-precomposed" sizes="114x114" href="' . esc_url( get_field('branding_icon_114', 'option') ) . '" /> <!-- for retina iPhone -->';
            if ( get_field('branding_icon_72', 'option') )
                $out .= '<link rel="apple-touch-icon-precomposed" href="' . esc_url( get_field('branding_icon_72', 'option') ) . '" /> <!-- for legacy iPad -->';
            if ( get_field('branding_icon_54', 'option') )
                $out .= '<link rel="apple-touch-icon-precomposed" href="' . esc_url( get_field('branding_icon_54', 'option') ) . '" /> <!-- for non-retina devices -->';

            if ( get_field('branding_favicon_png', 'option') )
                $out .= '<link rel="icon" type="image/png" href="' . esc_url( get_field('branding_favicon_png', 'option') ) . '" /> <!-- standard favicon -->';
            if ( get_field('branding_favicon_ico', 'option') )
                $out .= '<link rel="shortcut icon" href="' . esc_url( get_field('branding_favicon_ico', 'option') ) . '" /><!-- IE favicon -->';

            echo $out;
        }
    }

//************************ BODY CLASS HOOKS ***

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


//****************************** POST HOOKS ***

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


//**************************** SOCIAL HOOKS ***

    if ( ! function_exists( 'scm_custom_social_icons' ) ) {
        function scm_custom_social_icons($image_list) {

            include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
            if ( is_plugin_active( 'social-media-feather/social-media-feather.php' ) ) {

                $soc_shape = get_field('social_follow_shape', 'option');

                $path = SCM_DIR_IMG . 'icons/social/typeB/' . $soc_shape;
                $baseURL = SCM_URI_IMG . 'icons/social/typeB/' . $soc_shape;

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

// *****************************************************
// *      PAGINATION
// *****************************************************

    if ( ! function_exists( 'scm_pagination' ) ) {
        function scm_pagination( $query = null, $atts = array() ) {
            $atts = wp_parse_args( $atts, array(
                    'label_previous' => __( 'Precedente', SCM_THEME ),
                    'label_next'     => __( 'Prossima', SCM_THEME),
                    'before_output'  => '<div class="pagination">',
                    'after_output'   => '</div> <!-- /pagination -->',
                    'print'          => true
                ) );
            
            //$atts = apply_filters( 'wmhook_pagination_atts', $atts );

            //WP-PageNavi plugin support (http://wordpress.org/plugins/wp-pagenavi/)
            if ( function_exists( 'wp_pagenavi' ) ) {
                //Set up WP-PageNavi attributes
                    $atts_pagenavi = array(
                            'echo' => false,
                        );
                    if ( $query ) {
                        $atts_pagenavi['query'] = $query;
                    }
                    //$atts_pagenavi = apply_filters( 'wmhook_wppagenavi_atts', $atts_pagenavi );

                //Output
                    if ( $atts['print'] ) {
                        echo $atts['before_output'] . wp_pagenavi( $atts_pagenavi ) . $atts['after_output'];
                        return;
                    } else {
                        return $atts['before_output'] . wp_pagenavi( $atts_pagenavi ) . $atts['after_output'];
                    }
            }

            global $wp_query, $wp_rewrite;

            //Override global WordPress query if custom used
                if ( $query ) {
                    $wp_query = $query;
                }

            //WordPress pagination settings
                $pagination = array(
                        'base'      => @add_query_arg( 'paged', '%#%' ),
                        'format'    => '',
                        'current'   => max( 1, get_query_var( 'paged' ) ),
                        'total'     => $wp_query->max_num_pages,
                        'prev_text' => $atts['label_previous'],
                        'next_text' => $atts['label_next'],
                    );

            //Nice URLs
                if ( $wp_rewrite->using_permalinks() ) {
                    $pagination['base'] = user_trailingslashit( trailingslashit( remove_query_arg( 's', get_pagenum_link( 1 ) ) ) . 'page/%#%/', 'paged' );
                }

            //Search page
                if ( get_query_var( 's' ) ) {
                    $pagination['add_args'] = array( 's' => urlencode( get_query_var( 's' ) ) );
                }

            //Output
                if ( 1 < $wp_query->max_num_pages ) {
                    if ( $atts['print'] ) {
                        echo $atts['before_output'] . paginate_links( $pagination ) . $atts['after_output'];
                    } else {
                        return $atts['before_output'] . paginate_links( $pagination ) . $atts['after_output'];
                    }
                }
        }
    }


//*****************************************************
//*      HEADER
//*****************************************************

    //Prints logo
    if ( ! function_exists( 'scm_logo' ) ) {

        function scm_logo( $align = 'right' ) {
            $logo_id = ( get_field( 'id_branding', 'option' ) ? get_field( 'id_branding', 'option' ) : 'site-branding' );

            $follow = ( get_field('active_social_follow', 'option') ? 1 : 0 );

            $logo_image = esc_url(get_field('branding_header_logo', 'option'));
            $logo_height= numberToStyle(get_field('branding_header_logo_height', 'option'));
            $logo_align = ( $align == 'center' ? 'center' : ( get_field( 'select_alignment_logo', 'option' ) ? get_field( 'select_alignment_logo', 'option' ) : 'left' ) );

            $logo_title = get_bloginfo( 'name' );
            $logo_slogan = get_bloginfo( 'description' );
            $show_slogan = ( get_field('branding_header_slogan', 'option') ? 1 : 0 );
            
            $logo_type = ( get_field('branding_header_type', 'option') ? get_field('branding_header_type', 'option') : 'text' );

            $logo_class = 'header-column site-branding ';
            $logo_class .= ( ( $align != 'center' || $follow ) ? 'half-width ' : 'full ' );
            $logo_class .= $logo_align . ' inlineblock';
            
            //SEO logo HTML tag
            $logo_tag = ( is_front_page() ? 'h1' : 'div' );
            
            //output
            $out = '';

            $out .= '<div id="' . $logo_id . '" class="' . $logo_class . '">';

                $out .= '<' . $logo_tag . ' class="site-title logo ' . $logo_type . '-only">';
                    
                    $out .= '<a href="' . home_url() . '" title="' . $logo_title . '" style="display:block;">';
                    
                        $out .= ( 'img' == $logo_type  ? '<img src="' . $logo_image . '" alt="' . $logo_title . '" title="' . $logo_title . '" style="max-height:' . $logo_height . ';" />' : '' );
                    
                        $out .= '<span class="' . (  'img' == $logo_type ? 'invisible' : 'text-logo' ) . '">' . $logo_title . '</span>';
                    
                    $out .= '</a>';
                
                $out .= '</' . $logo_tag . '>';
                
                $out .= ( $show_slogan ? '<h2 class="site-description">' . $logo_slogan . '</h2>' : '' );

            $out .= '</div><!-- #site-branding -->';

            echo $out;
        }
    }

    //Prints social follow menu
    if ( ! function_exists( 'scm_social_follow' ) ) {
        function scm_social_follow( $align = 'right' ) {

            $follow = ( get_field('active_social_follow', 'option') ? 1 : 0 );

            if( !$follow || !shortcode_exists( 'feather_follow' ) )
                return;
            
            $follow_id = ( get_field( 'id_social_follow', 'option' ) ? get_field( 'id_social_follow', 'option' ) : 'site-social-follow' );

            $follow_align = ( $align == 'center' ? 'center' : ( get_field('select_alignment_social_follow', 'option') ? get_field('select_alignment_social_follow', 'option') : 'right' ) );
            $follow_size = ( get_field('social_follow_size', 'option') ? get_field('social_follow_size', 'option') : 64 );

            $follow_class = 'header-column site-social-follow ';
            $follow_class .= ( $align != 'center' ? 'half-width ' : 'full ' );
            $follow_class .= $follow_align . ' inlineblock';
            

            //output
            $out = '';

            $out .= '<div id="' . $follow_id . '" class="' . $follow_class . '">';
                
                $out .= do_shortcode( '[feather_follow size="' . $follow_size . '"]' );
            
            $out .= '</div><!-- #site-social-follow -->';

            echo $out;

        }
    }

    //Prints main menu
    if ( ! function_exists( 'scm_main_menu' ) ) {
        function scm_main_menu( $align = 'right', $position = 'inline' ) {

            $menu_id = ( get_field( 'id_menu', 'option' ) ? get_field( 'id_menu', 'option' ) : 'site-navigation' );
            
            $menu_class = 'navigation ';
            $menu_class .= ( ( $align == 'center' || $position != 'inline' ) ? 'full ' : 'half-width ' );
            $menu_class .= $align;

            $out = '';

            $out .= '<row class="' . $menu_class . '">';
            
                $out .= '<ul id="%1$s" class="%2$s">%3$s</ul>';

            $out .= '</row>';

            $menu_wrap = $out;

            wp_nav_menu( array(
                "container" => "nav",
                "container_id" => $menu_id,
                "container_class" => $menu_class,
                "menu_id" => "menu-main-menu",
                "menu_class" => "menu",
                "theme_location" => "primary",
                'menu' => '', // id, name or slug
                /*'items_wrap' => $menu_wrap,*/
            ) );
            
            echo '<!-- #site-navigation -->';
        }
    }

    //Prints sticky menu
    if ( ! function_exists( 'scm_sticky_menu' ) ) {
        function scm_sticky_menu() {

            $sticky = ( get_field( 'active_sticky_menu' ) == 'on' ? 1 : 0 );
            $sticky = ( !$sticky ? ( get_field( 'active_sticky_menu', 'option' ) ? 1 : 0 ) : $sticky );

            if( !$sticky )
                return;

            $sticky_id = ( get_field( 'id_menu', 'option' ) ? get_field( 'id_menu', 'option' ) . '-sticky' : 'site-navigation-sticky' );

            $sticky_layout = ( get_field('select_layout_page', 'option') ? get_field('select_layout_page', 'option') : 'full' );
            $sticky_align = ( get_field('select_alignment_site', 'option') ? get_field('select_alignment_site', 'option') : 'center');
            
            $sticky_menu = ( get_field( 'menu_sticky_menu', 'option' ) ? get_field( 'menu_sticky_menu', 'option' ) : 'primary' );
            $sticky_link = ( get_field( 'link_sticky_menu', 'option' ) == 'top' ? '#top' : home_url() );
            $sticky_toggle = ( get_field( 'toggle_sticky_menu', 'option' ) ? 'fa ' . get_field( 'toggle_sticky_menu', 'option' ) : 'fa-bars' );
            $sticky_icon = ( get_field( 'icon_sticky_menu', 'option' ) ? 'fa ' . get_field( 'icon_sticky_menu', 'option' ) : 'fa-home' );
            $sticky_image = ( get_field( 'image_sticky_menu', 'option' ) ? get_field( 'image_sticky_menu', 'option' ) : '' );
            
            $sticky_class = $sticky_layout . ' ' . $sticky_align . ' navigation sticky';
            

            $row_layout = ( get_field('select_layout_sticky_menu', 'option') ? get_field('select_layout_sticky_menu', 'option') : 'full' );                    
            $row_align = ( get_field('select_alignment_sticky', 'option') ? get_field('select_alignment_sticky', 'option') : 'right');
            
            $row_class = $row_layout . ' ' . $row_align;

            $toggle_class = ( $row_align == 'center' ? 'block' : 'float-' . ( $row_align == 'left' ? 'right' : 'left' ) );

            $out = '';

            $out .= '<row class="' . $row_class . '">';
            
                $out .= '<a href="' . $sticky_link . '" class="menu-toggle ' . $toggle_class . '" aria-controls="menu" aria-expanded="false">';
                        $out .= '<i class="sticky-toggle ' . $sticky_toggle . '"></i>';
                        $out .= '<i class="sticky-icon ' . $sticky_icon . '"></i>';
                        if($sticky_image)
                            $out .= '<img class="sticky-image" src="' . $sticky_image . '" height=100% />';
                $out .= '</a>';
            
                $out .= '<ul id="%1$s" class="%2$s">%3$s</ul>';

            $out .= '</row>';

            $sticky_wrap = $out;

            wp_nav_menu( array(
                'container' => 'nav',
                'container_id' => $sticky_id,
                'container_class' => $sticky_class,
                'menu_id' => 'menu-sticky-menu',
                'menu_class' => 'menu',
                'theme_location' => $sticky_menu,
                'menu' => '', // id, name or slug
                'items_wrap' => $sticky_wrap,
            ) );

            echo '<!-- #site-navigation-sticky -->';

        }
    }

//*****************************************************
//*      CONTENTS
//*****************************************************

    //Prints Element Inner Header
    if ( ! function_exists( 'scm_custom_header' ) ) {
        function scm_custom_header( $header, $type = 'all', $custom = '' ) {

            global $post, $SCM_back_query;

            $SCM_back_query = $post;

            if ($header && get_field( 'flexible_headers' . $custom, $header ) ) {

                echo '<header class="full ' . SCM_PREFIX . 'header ' . $type . '-header">';
                    scm_flexible_content( get_field('flexible_headers' . $custom, $header ) );
                echo '</header><!-- ' . $type . '-header -->';
            }
        }
    }

    //Prints Element Flexible Contents
    if ( ! function_exists( 'scm_flexible_content' ) ) {
        function scm_flexible_content( $content ) {

            global $post;

            foreach ($content as $key => $cont) {

                $layout = $cont['acf_fc_layout'];

                switch ($layout) {

                    case 'module_element':

                        $single = $cont[ 'select_module' ];
                        if(!$single) continue;
                        $single_type = $single->post_type;
                        $post = $single;
                        setup_postdata( $post );
                        get_template_part( SCM_DIR_PARTS_SINGLE, 'scm' );

                    break;

                    case 'galleria_element':

                        $single = $cont[ 'select_galleria' ];
                        if(!$single) continue;
                        $single_type = $single->post_type;
                        $post = $single;
                        setup_postdata( $post );
                        Get_Template_Part::get_part( SCM_DIR_PARTS_SINGLE . '-' . $single_type . '.php', array(
                            'b_init'    => $cont[ 'module_galleria_init' ],
                            'b_type'    => $cont[ 'module_galleria_type' ],
                            'b_img'     => $cont[ 'module_galleria_img_num' ],
                            'b_size'    => $cont[ 'module_galleria_img_size' ],
                            'b_txt'     => $cont[ 'module_galleria_txt' ],
                            'b_bg'      => $cont[ 'module_galleria_txt_bg' ],
                            'b_mod'     => $cont[ 'module_galleria_module' ],
                        ));

                    break;

                    case 'soggetto_element':

                        $single = $cont[ 'select_soggetto' ];
                        if(!$single) continue;
                        $single_type = $single->post_type;
                        $build = $cont['flexible_soggetto'];
                        $post = $single;
                        setup_postdata( $post );
                        Get_Template_Part::get_part( SCM_DIR_PARTS_SINGLE . '-' . $single_type . '.php', array(
                           'soggetto_rows' => $build,
                        ));

                    break;

                    case 'contact_form_element':

                        $single = $cont[ 'select_contact_form' ];
                        if(!$single) continue;
                        $single_type = $single->post_type;
                        $post = $single;
                        setup_postdata( $post );
                        get_template_part( SCM_DIR_PARTS_SINGLE, $single_type );

                    break;

                    case 'login_form_element':

                        get_template_part( SCM_DIR_PARTS_SINGLE . 'login-form' );

                    break;

                    case 'icon_element':
                        $icon_float = ( ( $cont[ 'select_float_img' ] && $cont[ 'select_float_img' ] != 'no' ) ? $cont[ 'select_float_img' ] : 'no-float' );
                        $icon_float = ( $icon_float == 'float-center' ? 'float-center text-center' : $icon_float );
                        $icon = $cont[ 'icona' ];
                        $icon_size = $cont[ 'dimensione' ];
                        $icon_class = SCM_PREFIX . 'img ' . $icon_float;
                        $icon_style = 'line-height:0;font-size:' . $icon_size . 'px';

                        echo    '<div class="' . $icon_class . '" style="' . $icon_style . '">
                                    <i class="fa ' . $icon . '"></i>
                                </div><!-- icon -->';
                    break;

                    case 'image_element':
                        $image_float = ( ( $cont[ 'select_float_img' ] && $cont[ 'select_float_img' ] != 'no' ) ? $cont[ 'select_float_img' ] : 'no-float' );
                        $image_float = ( $image_float == 'float-center' ? 'float-center text-center' : $image_float );

                        $image = ( $cont[ 'immagine' ] ? $cont[ 'immagine' ] : '' );
                        $image_fissa = ( $cont[ 'fissa' ] ? $cont[ 'fissa' ] : 'norm' );
                        $image_size = ( $cont[ 'dimensione' ] ? $cont[ 'dimensione' ] . 'px' : '' );
                        $image_width = ( $cont[ 'larghezza' ] ? $cont[ 'larghezza' ] . 'px' : 'auto' );
                        $image_height = ( $cont[ 'altezza' ] ? $cont[ 'altezza' ] . 'px' : $image_width );

                        $image_style = ( $image_fissa == 'quad' ? 'width:' . $image_size . '; height:' . $image_size . ';' : 'width:' . $image_width . '; height:' . $image_height . ';' );

                        $image_class = SCM_PREFIX . 'img ' . $image_float;

                        echo    '<div class="' . $image_class . '" style="' . $image_style . '">
                                    <img src="' . $image . '">
                                </div><!-- icon-image -->';
                    break;

                    case 'full_element':
                        $full = $cont[ 'immagine' ];
                        $full_height = $cont[ 'altezza' ];

                        $full_style = ( $full_height ? 'height:' . $full_height . 'px;' : 'height:auto;' );
                        $full_mask = 'mask';

                        $full_class = SCM_PREFIX . 'full-image ' . $full_mask;

                        echo    '<div class="' . $full_class . '" style="' . $full_style . '">
                                    <img src="' . $full . '" class="full">
                                </div><!-- full-image -->';
                    break;

                    case 'title_element':
                        $text = $cont[ 'testo' ];
                        $text_tag = ( $cont[ 'select_headings' ] != 'default' ? $cont[ 'select_headings' ] : get_field( 'select_headings_1' , 'option') );
                        $text_align = ( $cont[ 'select_txt_alignment_title' ] != 'default' ? $cont[ 'select_txt_alignment_title' ] : '' );
                        
                        $text_class = $text_align . SCM_PREFIX . 'title clear';

                        if( strpos( $text_tag, '.' ) !== false ){
                            $text_class .= ' ' . substr( $text_tag, strpos($text_tag, '.') + 1 );
                            $text_tag = 'h1';
                        }

                        echo '<' . $text_tag . ' class="' . $text_class . '">' . $text . '</' . $text_tag . '><!-- title -->';
                    break;

                    case 'text_element':
                        $content = $cont['testo'];
                        if(!$content) continue;
                        echo $content;

                    break;
                    
                }
                
            }

        }
    }

    //Prints Element Inner Footer
    if ( ! function_exists( 'scm_custom_footer' ) ) {
        function scm_custom_footer( $footer, $type = 'all', $custom = '', $txt_align = 'left' ) {

            global $post, $SCM_back_query;

            $post = $SCM_back_query;
            setup_postdata($post);

            if( $footer && have_rows( 'flexible_footers' . $custom, $footer ) ){
                
                echo '<footer class="full ' . SCM_PREFIX . 'footer ' . $type . '-footer">';

                    while ( have_rows( 'flexible_footers' . $custom, $footer ) ) : the_row();

                        $layout = get_row_layout();

                        switch ($layout) {
                            case 'text_element':

                                $content = get_sub_field('testo');
                                if(!$content) continue;
                                echo $content;
                                    
                            break;
                        }

                        endwhile;

                echo '</footer><!-- ' . $type . '-footer -->';
            }
        }
    }


//*****************************************************
//*      FOOTER
//*****************************************************

    //Prints copyright text
    if ( ! function_exists( 'scm_credits' ) ) {
        function scm_credits() {

            $copyText = get_field('footer_credits', 'option');
            if(!$copyText){
                return;
            }

            $replaceArray = array(
                '(c)'  => '&copy;',
                '(C)'  => '&copy;',

                '(r)'  => '&reg;',
                '(R)'  => '&reg;',

                '(tm)' => '&trade;',
                '(TM)' => '&trade;',

                'YEAR' => date( 'Y' ),

                'TITLE' => get_bloginfo( 'name' ),
            );
            $copyText = strtr( $copyText, $replaceArray );
            ?>
            <!-- CREDITS -->
            <div class="credits">
                <?php echo $copyText; ?>
            </div>
            <?php
        }
    }
    
    //Prints top-of-page link
    if ( ! function_exists( 'scm_top_of_page' ) ) {
        function scm_top_of_page() {
            
            $offset = get_field('tools_topofpage_offset', 'option');
            $icon = get_field('tools_topofpage_icon', 'option');
            $title = __( 'Inizio Pagina', SCM_THEME );

            $output =   '<div class="scroll-to-top" data-spy="affix" data-offset-top="' . $offset . '">';
            $output .=      '<a href="#top" class="smooth-scroll" title="' . $title . '" alt="' . $title . '">';
            $output .=          '<i class="fa ' . $icon . '"></i>';
            $output .=      '</a>';
            $output .=  '</div>';

            echo $output;
        }
    }

?>