<?php

// *****************************************************
// *      ACTIONS AND FILTERS
// *****************************************************

    add_action( 'wp_enqueue_scripts', 'scm_site_assets_favicon' );
    add_filter('body_class','scm_body_hook_class');
    add_filter('synved_social_skin_image_list', 'scm_custom_social_icons');

// *****************************************************
// *      HOOKS
// *****************************************************

//************************ FAVICON ***

    //favicon / touch-icons
    if ( ! function_exists( 'scm_site_assets_favicon' ) ) {
        function scm_site_assets_favicon( $ico144 = '', $ico114 = '', $ico72 = '', $ico54 = '', $png = '', $ico = '' ) {

            $ico144 = ( $ico144 ?: get_field('branding_icon_144', 'option') );
            $ico114 = ( $ico114 ?: get_field('branding_icon_114', 'option') );
            $ico72 = ( $ico72 ?: get_field('branding_icon_72', 'option') );
            $ico54 = ( $ico54 ?: get_field('branding_icon_54', 'option') );
            $png = ( $png ?: get_field('branding_icon_png', 'option') );
            $ico = ( $ico ?: get_field('branding_icon_ico', 'option') );

            if ( $ico144 )
                echo '<link rel="apple-touch-icon-precomposed" sizes="144x144" href="' . esc_url( $ico144 ) . '" /> <!-- for retina iPad -->';
            if ( $ico114 )
                echo '<link rel="apple-touch-icon-precomposed" sizes="114x114" href="' . esc_url( $ico114 ) . '" /> <!-- for retina iPhone -->';
            if ( $ico72 )
                echo '<link rel="apple-touch-icon-precomposed" href="' . esc_url( $ico72 ) . '" /> <!-- for legacy iPad -->';
            if ( $ico54 )
                echo '<link rel="apple-touch-icon-precomposed" href="' . esc_url( $ico54 ) . '" /> <!-- for non-retina devices -->';

            if ( $png )
                echo '<link rel="icon" type="image/png" href="' . esc_url( $png ) . '" /> <!-- standard favicon -->';
            if ( $ico )
                echo '<link rel="shortcut icon" href="' . esc_url( $ico ) . '" /><!-- IE favicon -->';

        }
    }

//************************ BODY CLASS HOOKS ***

//Add body class
    if ( ! function_exists( 'scm_body_hook_class' ) ) {
        function scm_body_hook_class( $classes ) {

            global $SCM_styles;

            // POST and PAGE classes
            global $post;

            $classes[] = SCM_THEME;

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

            // BROWSER classes

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

                if ( $is_gecko ) $classes[] = 'firefox';
                elseif ( $is_chrome ) $classes[] = 'chrome';
                elseif ( $is_opera ) $classes[] = 'opera';
                elseif ( $is_IE ) $classes[] = 'ie';
                elseif ( $is_iphone ) $classes[] = 'safari is-iphone';
                else $classes[] = 'safari';

            }

            // LANGUAGE classes - NEEDS PolyLang Plugin - (includerlo nel tema?)
            if(function_exists('pll_current_language')){
                $classes[] = 'lang-' . pll_current_language();
            }

            return $classes;
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
        function scm_pagination( $query = null ) {

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
                    'prev_text' => '<i class="fa fa-chevron-left"></i>',
                    'next_text' => '<i class="fa fa-chevron-right"></i>',
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
                return '<div class="pagination">' . paginate_links( $pagination ) . '</div> <!-- pagination -->' . lbreak();
            }
        }
    }


//*****************************************************
//*      HEADER
//*****************************************************

    //Prints logo
    if ( ! function_exists( 'scm_logo' ) ) {

        function scm_logo( $in = 0 ) {
            
            $logo_id = ( get_field( 'id_branding', 'option' ) ?: 'site-branding' );

            $follow = ( get_field('active_social_follow', 'option') ?: 0 );

            $logo_image = esc_url( get_field( 'branding_header_logo', 'option' ) );
            $logo_height= numberToStyle(get_field( 'branding_header_logo_height', 'option' ) );
            $logo_align = ( get_field( 'select_alignment_logo', 'option' ) ?: 'left' );

            $logo_title = get_bloginfo( 'name' );
            $logo_slogan = get_bloginfo( 'description' );
            $show_slogan = ( get_field( 'branding_header_slogan', 'option' ) ?: 0 );
            
            $logo_type = ( get_field('branding_header_type', 'option') ?: 'text' );

            $logo_class = 'header-column site-branding ';
            $logo_class .= ( ( $logo_align != 'center' || $follow ) ? 'half-width ' : 'full ' );
            $logo_class .= $logo_align . ' inlineblock';
            
            //SEO logo HTML tag
            $logo_tag = ( is_front_page() ? 'h1' : 'div' );
            
            indent( $in, '<div id="' . $logo_id . '" class="' . $logo_class . '">' );

                indent( $in+1 , '<' . $logo_tag . ' class="site-title logo ' . $logo_type . '-only">' );
                    
                    indent( $in+2 , '<a href="' . home_url() . '" title="' . $logo_title . '" style="display:block;">' );
                    
                    if( 'img' == $logo_type )
                        indent( $in+3 , '<img src="' . $logo_image . '" alt="' . $logo_title . '" title="' . $logo_title . '" style="max-height:' . $logo_height . ';" />' );
                    
                        indent( $in+3 , '<span class="' . (  'img' == $logo_type ? 'invisible' : 'text-logo' ) . '">' . $logo_title . '</span>' );
                    
                    indent( $in+2 , '</a>' );
                
                indent( $in+1 , '</' . $logo_tag . '>' );
                
            if( $show_slogan )
                indent( $in+1 , '<h2 class="site-description">' . $logo_slogan . '</h2>' );

            indent( $in , '</div><!-- #site-branding -->' );

        }
    }

    //Prints social follow menu
    if ( ! function_exists( 'scm_social_follow' ) ) {
        function scm_social_follow( $in = 0 ) {

            $follow = ( get_field( 'active_social_follow', 'option' ) ?: 0 );

            if( !$follow || !shortcode_exists( 'feather_follow' ) )
                return;
            
            $follow_id = ( get_field( 'id_social_follow', 'option' ) ?: 'site-social-follow' );

            $follow_align = ( get_field( 'select_alignment_social_follow', 'option' ) ?: 'right' );
            $follow_size = ( get_field( 'social_follow_size', 'option' ) ?: 64 );

            $follow_class = 'header-column site-social-follow ';
            $follow_class .= ( $follow_align != 'center' ? 'half-width ' : 'full ' );
            $follow_class .= $follow_align . ' inlineblock';
            

            indent( $in, '<div id="' . $follow_id . '" class="' . $follow_class . '">' );
                
                indent( $in+1, do_shortcode( '[feather_follow size="' . $follow_size . '"]' ) );
            
            indent( $in, '</div><!-- #site-social-follow -->' );

        }
    }

    //Prints menu
    if ( ! function_exists( 'scm_main_menu' ) ) {
        function scm_main_menu( $align = 'right', $position = 'inline', $in = 0 ) {

            $sticky = ( get_field( 'active_sticky_menu', 'option' ) ?: 'no' );
            $offset = ( $sticky != 'self' ? ( intval( get_field( 'offset_sticky_menu', 'option' ) ) ?: 0 ) : 0 );
            $attach = ( $sticky != 'self' ? ( get_field( 'attach_sticky_menu', 'option' ) ?: 'nav-top' ) : 'nav-top' );
            
            $menu = ( get_field( 'select_menu', 'option' ) ?: 'primary' );
            
            $id = ( get_field( 'id_menu', 'option' ) ?: 'site-navigation' );
            
            $site_align = ( get_field( 'select_alignment_site', 'option' ) ?: 'center' );

            $toggle_active = ( get_field( 'select_responsive_up_toggle', 'option' ) ?: 'smart' );
            $home_active = ( get_field( 'home_active', 'option' ) ?: 'no' );
            $image_active = ( get_field( 'select_responsive_down_logo', 'option' ) ?: 'no' );

            $menu_id = $id;
            $menu_class = 'navigation ';
            $menu_class .= ( get_field( 'overlay_menu', 'option' ) ? 'overlay ' : '' );
            $menu_class .= ( get_field('select_layout_page', 'option') ?: 'full' );

            $row_layout = ( get_field('select_layout_menu', 'option') ?: 'full' );
            $row_class = $row_layout . ' float-' . $site_align . ' ' . $align;

            $menu_data_toggle = $toggle_active;
            $menu_data_home = ( ( $home_active == 'both' || $home_active == 'menu' ) ? 'true' : 'false' );
            $menu_data_image = ( $menu_data_home ? $image_active : 'no' );

            // Print Main Menu
            scm_get_menu( array(
                'id' => $menu_id,
                'class' => $menu_class,
                'row_class' => $row_class,
                'toggle_active' => $menu_data_toggle,
                'home_active' => $menu_data_home,
                'image_active' => $menu_data_image,
                'menu' => $menu,
                'indent' => $in
            ));

            if( $sticky != 'no' ){

                $sticky_id = $id . '-sticky';

                $sticky_layout = ( get_field('select_layout_page', 'option') ?: 'full' );
                $sticky_class = 'navigation sticky ' . ( ( $sticky && $sticky != 'no' ) ? $sticky . ' ' : '' ) . $sticky_layout;

                $sticky_row_layout = ( get_field('select_layout_sticky_menu', 'option') ?: 'full' );
                $sticky_row_class = $sticky_row_layout . ' float-' . $site_align . ' ' . $align;

                $sticky_data_toggle = $toggle_active;
                $sticky_data_home = ( ( $home_active == 'both' || $home_active == 'sticky' ) ? 'true' : 'false' );
                $sticky_data_image = ( $sticky_data_home ? $image_active : 'no' );
                
                // Print Sticky Menu
                scm_get_menu( array(
                    'id' => $sticky_id,
                    'class' => $sticky_class,
                    'row_class' => $sticky_row_class,
                    'toggle_active' => $sticky_data_toggle,
                    'home_active' => $sticky_data_home,
                    'image_active' => $sticky_data_image,
                    'menu' => $menu,
                    'sticky' => $id,
                    'type' => $sticky,
                    'offset' => $offset,
                    'attach' => $attach,
                    'indent' => $in
                ));
            }
        }
    }

    if ( ! function_exists( 'scm_get_menu' ) ) {
        
        class Sublevel_Walker extends Walker_Nav_Menu {
            function start_lvl( &$output, $depth = 0, $args = array() ) {
                $output .= lbreak() . indent( 7 + $depth ) . '<ul class="toggle-content sub-menu depth-' . $depth . '">' . lbreak();

            }

            function end_lvl( &$output, $depth = 0, $args = array() ) {
                $output .= indent( 7 + $depth ) . '</ul>' . lbreak() . indent( 6 );
            }

            function start_el( &$output, $object, $depth = 0, $args = array(), $current_object_id = 0 ) {
                
                $ind = 7;
                if( !$depth ) $ind = 6;

                $current = $object->current;
                $class = ( $current ? ' current' : '' );
                
                $url = $object->url;
                $content = $object->title;
                $type = 'site';
                $anchor = '';
                $button = '';
                $data = '';

                if( $current )
                    $url = '#top';

                if( strpos( $url, '#') === 0 ){
                    $type = 'page';
                }else if( strpos( $url, SCM_URL ) === false ){
                    $type = 'external';
                }

                $has_children = getByValue( $object->classes, 'menu-item-has-children' );
                
                $link = '<a href="' . $url . '"' . $anchor . '>' . $content . '</a>';

                if( $has_children >= 0 ){
                    $data = 'data-toggle="true" ';
                    $class .= ' has-children toggle no-toggled';
                    $link = '<div class="toggle-button">' . $link . '</div>';
                }
                
                $output .= indent( $ind + $depth ) . '<li class="menu-item link-' . $type . $class . '"' . $data . '>' . $link;
            
            }

            function end_el( &$output, $object, $depth = 0, $args = array() ) {
                $output .= '</li>' . lbreak();
            }
        }



        function scm_get_menu( $id = 'site-navigation', $class = 'navigation full' , $row_class = 'full' , $toggle_active = 'smart', $home_active = 'false', $image_active = 'no', $menu = 'primary', $sticky = '', $type = 'self', $offset = 0, $attach = 'nav-top', $indent = 0 ) {

            $default = array(
                'id'               => 'site-navigation',
                'class'            => 'navigation full',
                'row_class'        => 'full',
                'toggle_active'    => 'smart',
                'home_active'      => 'false',
                'image_active'     => 'no',
                'menu'             => 'primary',
                'sticky'           => '',
                'type'             => 'self',
                'offset'           => 0,
                'attach'           => 'nav-top',
                'indent'           => 0
            );

            if( is_array( $id ) )
                extract( wp_parse_args( $id, $default ) );

            $perma = get_permalink();
            $home = get_home_url();

            $toggle_link = ( strpos($perma, $home) !== false ? '#top' : $home );

            $toggle_icon = 'fa ' . ( get_field( 'toggle_icon', 'option' ) ?: 'fa-bars' );
            $home_icon = 'fa ' . ( get_field( 'home_icon', 'option' ) ?: 'fa-home' );
            $image_icon = ( get_field( 'image_icon', 'option' ) ?: '' );

            $ul_id = $id . '-menu';
            $ul_class = 'menu';

            $data = ( $sticky ? 'data-sticky="' . $sticky . '" data-sticky-type="' . $type . '" data-sticky-offset="' . $offset . '" data-sticky-attach="' . $attach . '" ' : '' );

            $wrap = indent( $indent ) . '<nav id="' . $id . '" class="' . $class . '" data-toggle="true" data-switch-toggle="' . $toggle_active . '"' . $data . '>' . lbreak();

                $wrap .= indent( $indent + 1 ) . '<div class="row ' . $row_class . '">' . lbreak( 2 );

                    $wrap .= indent( $indent + 2 ) . '<div class="toggle-button" data-switch="' . $toggle_active . '">' . lbreak();

                        $wrap .= indent( $indent + 3 ) . '<i class="icon-toggle ' . $toggle_icon . '" data-toggle-button="off"></i>' . lbreak();
                        $wrap .= indent( $indent + 3 ) . '<a href="' . $toggle_link . '" data-toggle-button="on"><i class="' . $home_icon . '"></i></a>' . lbreak();

                    $wrap .= indent( $indent + 2 ) . '</div>' . lbreak();
                
                if( $home_active == 'true' ){
                
                    if( $image_active && $image_active != 'no' ){

                        $wrap .= indent( $indent + 3 ) . '<a class="toggle-home" href="' . $toggle_link . '" data-switch><i class="' . $home_icon . '"></i></a>' . lbreak();
                        $wrap .= indent( $indent + 3 ) . '<a class="toggle-image" href="' . $toggle_link . '" data-switch="' . $image_active . '"><img src="' . $image_icon . '" alt="" /></a>' . lbreak();
                    
                    }else{
                    
                        $wrap .= indent( $indent + 3 ) . '<a class="toggle-home" href="' . $toggle_link . '" data-switch><i class="' . $home_icon . '"></i></a>' . lbreak();
                    
                    }

                }

                    $wrap .= indent( $indent + 2 ) . '<ul class="toggle-content %2$s">' . lbreak();

                        $wrap .= '%3$s' . lbreak();

                    $wrap .= indent( $indent + 2 ) . '</ul>' . lbreak();

                $wrap .= indent( $indent + 1 ) . '</div>' . lbreak();

            $wrap .= indent( $indent ) . '</nav><!-- #' . $id . ' -->' . lbreak( 2 );

            // Print Menu
            wp_nav_menu( array(
                    'container' => false,
                    'menu_id' => $ul_id,
                    'menu_class' => $ul_class,
                    'theme_location' => $menu,
                    'menu' => '', // id, name or slug
                    'items_wrap' => $wrap,
                    'walker' => new Sublevel_Walker
                ) );

        }
    }

//*****************************************************
//*      NIVO SLIDER
//*****************************************************

    //Prints Element Inner Header
    if ( ! function_exists( 'scm_custom_header' ) ) {
        function scm_custom_header( $id, $slides, $type = '', $layout = '', $height = '' ) {

            $i = 0;
            $slider = ( get_field( 'select_slider', 'option' ) ?: 'nivo' );
            $align = ( get_field('select_alignment_site', 'option') ?: 'center' );

            // +++ todo: Slide diventa un nuovo Post Type e avrà il suo ID
            // E tutte le sue belle opzioni
            $images = '<div class="slider ' . $slider . ' ' . $layout . ' mask float-' . $align . ' ' . $align . '" 
                            data-slider="' . $slider . '" 
                            data-slider-effect="fold" 
                            data-slider-slices="15" 
                            data-slider-cols="8" 
                            data-slider-rows="4" 
                            data-slider-speed="500" 
                            data-slider-time="5000" 
                            data-slider-start="0" 
                            data-slider-random="false" 
                            data-slider-hover="true" 
                            data-slider-manual="false" 
                            data-slider-direction="true" 
                            data-slider-control="false" 
                            data-slider-thumbs="false" 
                            data-slider-prev="Prev" 
                            data-slider-next="Next" 
                            data-max-height="' . $height . '" 
                            data-equal="img" 
                            data-equal-max="height" 
                        >';

            $captions = '';

            foreach ($slides as $slide) {
                $i++;
                $img = $slide[ 'immagine' ];
                $link = ( $slide[ 'slide_link' ] == 'page' ? $slide[ 'slide_internal' ] : ( $slide[ 'slide_link' ] == 'link' ? $slide[ 'slide_external' ] : '' ) );
                $caption = '';
                $slide_id = $slide[ 'slide_id' ];
                $slide_class = $slide[ 'slide_class' ];
                $title = '';

                $caption_id = 'caption-' . $id . '-' . $i;

                $top = ( $slide[ 'caption_top' ] != '' ? $slide[ 'caption_top' ] . '%' : 'initial' );
                $right = ( $slide[ 'caption_right' ] != '' ? $slide[ 'caption_right' ] . '%' : 'initial' );
                $bottom = ( $slide[ 'caption_bottom' ] != '' ? $slide[ 'caption_bottom' ] . '%' : 'initial' );
                $left = ( $slide[ 'caption_left' ] != '' ? $slide[ 'caption_left' ] . '%' : 'initial' );
                $class = 'box' . ( $slide_class ? ' ' . $slide_class : '' );
                $style = ' style="top:' . $top . ';right:' . $right . ';bottom:' . $bottom . ';left:' . $left . ';"';
                    
                $caption = '<div id="' . $caption_id . '" class="nivo-html-caption' . ( $slide_class ? ' ' . $slide_class : '' ) . ' count-' . $i . '">';
                    if( $slide[ 'active_caption' ] ){
                        $caption .= '<div' . ( $slide_id ? ' id="' . $slide_id . '"' : '' ) . ' class="' . $class . '"' . $style . '>';
                            
                                $caption .= ( $slide[ 'caption_title'] ? '<h3>' . $slide[ 'caption_title' ] . '</h3>' : '' );
                                $caption .= $slide['caption'];
                            
                        $caption .= '</div>';
                    }
                $caption .= '</div>';

                $title = ( $caption ? '#' . $caption_id : '' );

                $images .= ( $link ? '<a href="' . $link . '">' : '' );
                    $images .= '<img class="slide-image" src="' . $img . '" data-thumb="' . $img . '" alt="" title="' . $title . '">';
                $images .= ( $link ? '</a>' : '' );

                $captions .= $caption;

            }

            $images .= '</div>';

            echo '<header class="' . SCM_PREFIX . 'header ' . $type . '-header full full-image slider-wrapper theme-default">';
                
            echo $images;               

            echo $captions;

            echo '</header><!-- ' . $type . '-header -->';

        }
    }

//*****************************************************
//*      CONTENT
//*****************************************************

    //Prints Element Flexible Contents
    if ( ! function_exists( 'scm_flexible_content' ) ) {
        function scm_flexible_content( $content ) {
            if( !$content )
                return;

            global $post;

            foreach ($content as $cont) {

                $back_query = $post;

                $element = ( isset( $cont['acf_fc_layout'] ) ? $cont['acf_fc_layout'] : '' );

                switch ($element) {

                    case 'archive':

                        $args = array(
                            'post_type' => $cont['select_types_public'],
                            'orderby' => $cont['orderby'],
                            'order' => $cont['order'],
                            'posts_per_page' => ( (int)$cont['all'] ? -1 : $cont['max'] ),
                        );

                        if( $cont['categories'] ){
                            $args['tax_query'] = array(
                                array(
                                    'taxonomy' => 'categories-' . $cont['select_types_public'],
                                    'field'    => 'slug',
                                    'terms'    => explode( ' ', $cont['categories'] ),
                                ),
                            );
                        }

                        Get_Template_Part::get_part( 'archive.php', array(
                            'pargs' => $args,
                            'pagination' => ( (int)$cont['all'] ? 'no' : $cont['pagination'] ),
                            'layout' => $cont['layout'],
                        ));

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
                            'b_section' => $cont[ 'module_galleria_section' ],
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

                    case 'map_element':

                        $luoghi = $cont[ 'select_luoghi' ];
                        if(!$luoghi) continue;
                        $width = ( $cont['larghezza'] >= 0 ? $cont['larghezza'] : 100);
                        $zoom = ( $cont['zoom'] >= 0 ? $cont['zoom'] : 10);

                        Get_Template_Part::get_part( SCM_DIR_PARTS_SINGLE . '-map.php', array(
                            'map_luoghi' => $luoghi,
                            'map_width' => $width,
                            'map_zoom' => $zoom
                        ));

                    break;

                    case 'luogo_element':

                        $luoghi = $cont[ 'select_luoghi' ];
                        if(!$luoghi) continue;
                        $build = $cont['build_luoghi'];
                        $width = ( $cont['larghezza'] >= 0 ? $cont['larghezza'] : 100);
                        $legend = ( $cont['legend'] ?: 0);

                        foreach ($luoghi as $luogo) {
                            $single_type = $luogo->post_type;
                            $post = $luogo;
                            setup_postdata( $post );
                            Get_Template_Part::get_part( SCM_DIR_PARTS_SINGLE . '-' . $single_type . '.php', array(
                                'luogo_rows' => $build,
                                'luogo_width' => $width,
                                'luogo_legend' => $legend
                            ));
                        }

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

                        get_template_part( SCM_DIR_PARTS_SINGLE, 'login-form' );

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
                        $class = '';
                        $image = ( $cont[ 'immagine' ] ?: '' );
                        $image_fissa = ( $cont[ 'fissa' ] ?: 'norm' );
                        $image_units = ( $cont[ 'units' ] ?: 'px' );
                        
                        $image_float = ( ( $cont[ 'select_float_img' ] && $cont[ 'select_float_img' ] != 'no' ) ? $cont[ 'select_float_img' ] : 'no-float' );
                        $image_float = ( $image_float == 'float-center' ? 'float-center text-center' : $image_float );

                        $image_class = SCM_PREFIX . 'img ' . $image_float;
                        
                        switch ($image_fissa) {
                            case 'full':
                                $class = ' class="full"';
                                $image_float = '';
                                $image_height = ( $cont[ 'altezza_full' ] ? $cont[ 'altezza_full' ] . $image_units : 'initial' );
                                $image_style = 'max-height:' . $image_height . ';';
                                $image_class = SCM_PREFIX . 'full-image mask';
                            break;

                            case 'quad':
                                $image_size = ( $cont[ 'dimensione' ] ? $cont[ 'dimensione' ] . $image_units : 'auto' );
                                $image_style = 'width:' . $image_size . '; height:' . $image_size . ';';
                            break;
                            
                            default:
                                $image_width = ( $cont[ 'larghezza' ] ? $cont[ 'larghezza' ] . $image_units : 'auto' );
                                $image_height = ( $cont[ 'altezza' ] ? $cont[ 'altezza' ] . $image_units : $image_width );
                                $image_style = 'width:' . $image_width . '; height:' . $image_height . ';';
                            break;
                        }

                        if( !$image )
                            continue;

                        echo    '<div class="' . $image_class . '" style="' . $image_style . '">
                                    <img src="' . $image . '"' . $class . ' alt="">
                                </div><!-- icon-image -->';

                    break;

                    case 'title_element':
                        $text = $cont[ 'testo' ];
                        $text_default = ( $cont[ 'select_complete_headings' ] ?: '' );
                        $text_tag = ( strpos( $text_default, 'select_' ) === false ? $cont[ 'select_complete_headings' ] : ( get_field( $text_default , 'option') ? get_field( $text_default , 'option') : 'h1' ) );
                        $text_align = ( $cont[ 'select_txt_alignment_title' ] != 'default' ? $cont[ 'select_txt_alignment_title' ] . ' ' : '' );
                        $text_class = scm_acf_select_preset( 'select_default_headings_classes',  $text_default, ' ' );
                        $text_class .= $text_align . SCM_PREFIX . 'title clear';


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

                    case 'section_element':
                        $single = $cont[ 'select_section' ];
                        if(!$single) continue;
                        $post = $single;
                        setup_postdata( $post );
                        get_template_part( SCM_DIR_PARTS_SINGLE, 'scm-sections' );
                    break;                    
                }
            }
        }
    }


//*****************************************************
//*      FOOTER
//*****************************************************

    //Prints copyright text
    if ( ! function_exists( 'scm_credits' ) ) {     // ENTRERÀ A FAR PARTE DEGLI ELEMENTI SELEZIONABILI DAL FLEXIBLE CONTENT
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
            
            $id = ( get_field('id_topofpage', 'option') ?: 'site-topofpage' );
            $icon = get_field('tools_topofpage_icon', 'option');
            $text = ( get_field('tools_topofpage_title', 'option') ?: 'Inizio Pagina' );
            $offset = ( get_field('tools_topofpage_offset', 'option') ?: 0 );
            $title = $text;

            $output =   '<div id="' . $id . '" class="topofpage" data-affix="top" data-affix-offset="' . $offset . '">';
            $output .=      '<a href="#top" title="' . $title . '">';
            $output .=          '<i class="fa ' . $icon . '"></i>';
            $output .=      '</a>';
            $output .=  '</div>';

            echo $output;
        }
    }

?>