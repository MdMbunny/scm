<?php
/**
 * @package SCM
 */

// *****************************************************
// *    SCM FRONT
// *****************************************************

/*
*****************************************************
*
*   0.0 Actions and Filters
*   1.0 Front Hooks
*   2.0 Front Pagination
*   3.0 Front Head
*   4.0 Front Content
*   5.0 Front Footer
*
*****************************************************
*/

// *****************************************************
// *      0.0 ACTIONS AND FILTERS
// *****************************************************

    add_action( 'wp_enqueue_scripts', 'scm_site_assets_favicon' );
    add_filter('body_class','scm_body_hook_class');
    add_filter('synved_social_skin_image_list', 'scm_custom_social_icons');

// *****************************************************
// *      1.0 FRONT HOOKS
// *****************************************************

//************************ FAVICON ***

    //favicon / touch-icons
    if ( ! function_exists( 'scm_site_assets_favicon' ) ) {
        function scm_site_assets_favicon() {

            $ico144 = scm_field('branding_icon_144', '', 'option');
            $ico114 = scm_field('branding_icon_114', '', 'option');
            $ico72 = scm_field('branding_icon_72', '', 'option');
            $ico54 = scm_field('branding_icon_54', '', 'option');
            $png = scm_field('branding_favicon_png', '', 'option');
            $ico = scm_field('branding_favicon_ico', '', 'option');

            indent( 0, lbreak() . '<!------ Favicon and Touch Icons ------>', 2 );

            if ( $ico144 )
                indent( 0, '<link rel="apple-touch-icon-precomposed" sizes="144x144" href="' . esc_url( $ico144 ) . '" /> <!-- for retina iPad -->', 1 );
            if ( $ico114 )
                indent( 0, '<link rel="apple-touch-icon-precomposed" sizes="114x114" href="' . esc_url( $ico114 ) . '" /> <!-- for retina iPhone -->', 1 );
            if ( $ico72 )
                indent( 0, '<link rel="apple-touch-icon-precomposed" href="' . esc_url( $ico72 ) . '" /> <!-- for legacy iPad -->', 1 );
            if ( $ico54 )
                indent( 0, '<link rel="apple-touch-icon-precomposed" href="' . esc_url( $ico54 ) . '" /> <!-- for non-retina devices -->', 1 );

            if ( $png )
                indent( 0, '<link rel="icon" type="image/png" href="' . esc_url( $png ) . '" /> <!-- standard favicon -->', 1 );
            if ( $ico )
                indent( 0, '<link rel="shortcut icon" href="' . esc_url( $ico ) . '" /><!-- IE favicon -->', 2 );

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

                $soc_shape = scm_field('select_social_shape', 'square', 'option');

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
// *      2.0 FRONT PAGINATION
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
//*      3.0 FRONT HEADER
//*****************************************************

    //Prints logo
    if ( ! function_exists( 'scm_logo' ) ) {

        function scm_logo() {

            global $SCM_indent;
            
            $logo_id = scm_field( 'id_branding', 'site-branding', 'option' );

            $follow = scm_field( 'select_disable_social_active', 0, 'option' );

            $logo_image = esc_url( scm_field( 'branding_header_logo', '', 'option' ) );
            $logo_height= numberToStyle( scm_field( 'branding_header_logo_height', 40, 'option' ) );
            $logo_align = scm_field( 'select_alignment_logo', 'left', 'option' );

            $logo_title = get_bloginfo( 'name' );
            $logo_slogan = get_bloginfo( 'description' );
            $show_slogan = scm_field( 'select_disable_branding_slogan', 0, 'option' );
            
            $logo_type = scm_field( 'select_branding_header', 'text', 'option' );

            $logo_class = 'header-column site-branding ';
            $logo_class .= ( ( $logo_align != 'center' || $follow ) ? 'half-width ' : 'full ' );
            $logo_class .= $logo_align . ' inlineblock';
            
            //SEO logo HTML tag
            $logo_tag = ( is_front_page() ? 'h1' : 'div' );

            $in = $SCM_indent + 1;
            
            indent( $in, '<div id="' . $logo_id . '" class="' . $logo_class . '">', 2 );

                indent( $in+1 , '<' . $logo_tag . ' class="site-title logo ' . $logo_type . '-only">' );
                    
                    indent( $in+2 , '<a href="' . home_url() . '" title="' . $logo_title . '" style="display:block;">' );
                    
                    if( 'img' == $logo_type )
                        indent( $in+3 , '<img src="' . $logo_image . '" alt="' . $logo_title . '" title="' . $logo_title . '" style="max-height:' . $logo_height . ';" />' );
                    
                        indent( $in+3 , '<span class="' . (  'img' == $logo_type ? 'invisible' : 'text-logo' ) . '">' . $logo_title . '</span>' );
                    
                    indent( $in+2 , '</a>' );
                
                indent( $in+1 , '</' . $logo_tag . '>', 2 );
                
            if( $show_slogan )
                indent( $in+1 , '<h2 class="site-description">' . $logo_slogan . '</h2>', 2 );

            indent( $in , '</div><!-- #site-branding -->', 2 );

        }
    }

    //Prints social follow menu
    if ( ! function_exists( 'scm_social_follow' ) ) {
        function scm_social_follow() {

            global $SCM_indent;

            $follow = scm_field( 'select_disable_social_active', 0, 'option' );

            if( !$follow || !shortcode_exists( 'feather_follow' ) )
                return;
            
            $follow_id = scm_field( 'id_social_follow', 'site-social-follow', 'option' );

            $follow_align = scm_field( 'select_alignment_social_follow', 'right', 'option' );
            $follow_size = scm_field( 'select_size_icon_social_follow', '64x64', 'option' );
            $follow_size = substr( $follow_size , strpos( $follow_size, 'x' ) + 1 );

            $follow_class = 'header-column site-social-follow ';
            $follow_class .= ( $follow_align != 'center' ? 'half-width ' : 'full ' );
            $follow_class .= $follow_align . ' inlineblock';

            $in = $SCM_indent + 1;

            indent( $in, '<div id="' . $follow_id . '" class="' . $follow_class . '">', 2 );
                
                indent( $in + 1, do_shortcode( '[feather_follow size="' . $follow_size . '"]' ), 2 );
            
            indent( $in, '</div><!-- #site-social-follow -->', 2 );

        }
    }

    //Prints menu
    if ( ! function_exists( 'scm_main_menu' ) ) {
        function scm_main_menu( $align = 'right', $position = 'inline' ) {

            $sticky = scm_field( 'select_sticky_active', 'no', 'option' );
            $offset = ( $sticky === 'self' ? 0 : (int)scm_field( 'offset_sticky_menu', 0, 'option' ) );
            $attach = ( $sticky === 'self' ? 'nav-top' : scm_field( 'select_sticky_attach', 'nav-top', 'option' ) );
            
            $menu = scm_field( 'select_menu', 'primary' );
            
            $id = scm_field( 'id_menu', 'site-navigation', 'option' );
            
            $site_align = scm_field( 'select_alignment_site', 'center', 'option' );

            $toggle_active = scm_field( 'select_responsive_up_toggle', 'smart', 'option' );
            $home_active = scm_field( 'select_home_active', 'no', 'option' );
            $image_active = scm_field( 'select_responsive_down_logo', 'no', 'option' );

            $menu_id = $id;
            $menu_class = 'navigation ';
            $menu_class .= ( scm_field( 'select_disable_overlay_menu', 0, 'option' ) ? 'overlay absolute ' : 'relative ' );

            $menu_layout = scm_field( 'select_layout_page', 'full', 'option' );
            $row_layout = scm_field( 'select_layout_menu', 'full', 'option' );
            
            if( $position == 'inline' ){
                $menu_class .= 'half-width float-' . $align;
                $row_class = 'full';
            }else{
                $menu_class .= $menu_layout . ' ' . $site_align;
                $row_class = $row_layout . ' ' . $align;
            }            

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
            ));

            if( $sticky != 'no' ){

                $sticky_id = $id . '-sticky';

                $sticky_layout = scm_field( 'select_layout_page', 'full', 'option' );
                $sticky_class = 'navigation sticky ' . ( ( $sticky && $sticky != 'no' ) ? $sticky . ' ' : '' ) . $sticky_layout . ' ' . $site_align;

                $sticky_row_layout = scm_field( 'select_layout_sticky_menu', 'full', 'option' );
                $sticky_row_class = $sticky_row_layout . ' ' . $align;

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
                
                global $SCM_indent;
                
                $ind = $SCM_indent + 3;

                if( !$depth ) $ind = $SCM_indent + 2;

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
                }else if( strpos( $url, SCM_DOMAIN ) === false ){
                    $type = 'external';
                }

                $has_children = getByValue( $object->classes, 'menu-item-has-children' );
                
                $link = '<a href="' . $url . '"' . $anchor . '>' . $content . '</a>';

                if( $has_children !== false ){
                    $data = 'data-toggle="true" ';
                    $class .= ' has-children toggle no-toggled';
                    $link = '<div class="toggle-button">' . $link . '</div>';
                }
                
                $output .= indent( $ind + $depth ) . '<li class="' . sanitize_title( $link ) . ' menu-item link-' . $type . $class . '"' . $data . '>' . $link;
            
            }

            function end_el( &$output, $object, $depth = 0, $args = array() ) {
                $output .= '</li>' . lbreak();
            }
        }



        function scm_get_menu( $id = 'site-navigation', $class = 'navigation full' , $row_class = 'full' , $toggle_active = 'smart', $home_active = 'false', $image_active = 'no', $menu = 'primary', $sticky = '', $type = 'self', $offset = 0, $attach = 'nav-top' ) {

            global $SCM_indent;

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
            );

            if( is_array( $id ) )
                extract( wp_parse_args( $id, $default ) );

            $perma = get_permalink();
            $home = get_home_url();

            //consoleLog($perma);
            //consoleLog($home);

            $toggle_link = ( strpos($perma, $home) !== false ? '#top' : $home );

            $toggle_icon = 'fa ' . scm_field( 'toggle_icon', 'fa-bars', 'option' );
            $home_icon = 'fa ' . scm_field( 'home_icon', 'fa-home', 'option' );
            $image_icon = scm_field( 'image_icon', '', 'option' );

            $ul_id = $id . '-menu';
            $ul_class = 'menu';

            $data = ( $sticky ? 
                'data-sticky="' . $sticky . '" 
                data-sticky-type="' . $type . '" 
                data-sticky-offset="' . $offset . '" 
                data-sticky-attach="' . $attach . '" ' : '' );

            $in = $SCM_indent + 1;

            $wrap = indent( $in ) . '<nav id="' . $id . '" class="' . $class . '" 
                data-toggle="true" 
                data-switch-toggle="' . $toggle_active . '" 
                ' . $data . '
            >' . lbreak();

                $wrap .= indent( $in + 1 ) . '<div class="row ' . $row_class . '">' . lbreak( 2 );

                    $wrap .= indent( $in + 2 ) . '<div class="toggle-button" data-switch="' . $toggle_active . '">' . lbreak(2);

                        $wrap .= indent( $in + 3 ) . '<i class="icon-toggle ' . $toggle_icon . '" data-toggle-button="off"></i>' . lbreak();
                        $wrap .= indent( $in + 3 ) . '<a href="' . $toggle_link . '" data-toggle-button="on"><i class="' . $home_icon . '"></i></a>' . lbreak();

                    $wrap .= indent( $in + 2 ) . '</div>' . lbreak(2);
                
                if( $home_active == 'true' ){
                
                    if( $image_active && $image_active != 'no' ){

                        $wrap .= indent( $in + 2 ) . '<a class="toggle-home" href="' . $toggle_link . '" data-switch><i class="' . $home_icon . '"></i></a>' . lbreak(2);
                        $wrap .= indent( $in + 2 ) . '<a class="toggle-image" href="' . $toggle_link . '" data-switch="' . $image_active . '"><img src="' . $image_icon . '" alt="" /></a>' . lbreak(2);
                    
                    }else{
                    
                        $wrap .= indent( $in + 2 ) . '<a class="toggle-home" href="' . $toggle_link . '" data-switch><i class="' . $home_icon . '"></i></a>' . lbreak(2);
                    
                    }

                }

                    $wrap .= indent( $in + 2 ) . '<ul class="toggle-content %2$s">' . lbreak(2);

                        $wrap .= '%3$s' . lbreak();

                    $wrap .= indent( $in + 2 ) . '</ul>' . lbreak(2);

                $wrap .= indent( $in + 1 ) . '</div>' . lbreak(2);

            $wrap .= indent( $in ) . '</nav><!-- #' . $id . ' -->' . lbreak( 2 );

            $SCM_indent += 2;

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

            $SCM_indent -= 2;

        }
    }


//*****************************************************
//*      4.0 FRONT CONTENT
//*****************************************************

    //Prints Element Flexible Contents
    if ( ! function_exists( 'scm_flexible_content' ) ) {
        function scm_flexible_content( $content ) {

            if( !$content )
                return;

            global $post, $SCM_indent;

            $SCM_indent += 1;

            foreach ($content as $cont) {

                $element = ( isset( $cont[ 'acf_fc_layout' ] ) ? $cont[ 'acf_fc_layout' ] : '' );

                switch ($element) {

                    case 'layout_divider':

                        $height = ( $cont['dimensione_divider'] ?: 1 );

                        indent( $SCM_indent, '<hr style="height:' . $height . $cont[ 'select_units_divider' ] . ';" />', 2 );

                    break;

                    case 'layout_archive':

                        $args = array(
                            'post_type' => $cont[ 'select_types_public_archive' ],
                            'orderby' => $cont[ 'orderby_archive' ],
                            'order' => $cont[ 'order_archive' ],
                            'posts_per_page' => ( (int)$cont[ 'all_archive' ] ? -1 : $cont[ 'max_archive' ] ),
                        );

                        if( $cont[ 'categories_archive' ] ){
                            $args[ 'tax_query' ] = array(
                                array(
                                    'taxonomy' => 'categories-' . $cont[ 'select_types_public_archive' ],
                                    'field'    => 'slug',
                                    'terms'    => explode( ' ', $cont[ 'categories_archive' ] ),
                                ),
                            );
                        }

                        Get_Template_Part::get_part( SCM_DIR_PARTS_SINGLE . '-archive.php', array(
                            'pargs' => $args,
                            'pagination' => ( (int)$cont['all_archive'] ? 'no' : $cont[ 'pagination_archive' ] ),
                            'layout' => $cont[ 'layout_archive' ],
                        ));

                    break;

                    case 'layout_galleria':

                        $single = $cont[ 'select_galleria' ];
                        if(!$single) continue;
                        $post = ( is_numeric( $single ) ? get_post( $single ) : $single );
                        setup_postdata( $post );
                        $single_type = $post->post_type;
                        Get_Template_Part::get_part( SCM_DIR_PARTS_SINGLE . '-' . $single_type . '.php', array(
                            'b_init'    => $cont[ 'module_galleria_init' ],
                            'b_type'    => $cont[ 'select_gallerie_button' ],
                            'b_img'     => $cont[ 'module_galleria_img_num' ],
                            'b_size'    => $cont[ 'dimensione_galleria' ],
                            'b_units'    => $cont[ 'select_units_galleria' ],
                            'b_txt'     => $cont[ 'module_galleria_txt' ],
                            'b_bg'      => $cont[ 'module_galleria_txt_bg' ],
                            'b_section' => $cont[ 'module_galleria_section' ],
                        ));

                    break;

                    case 'layout_soggetto':

                        $single = $cont[ 'select_soggetto' ];
                        if(!$single) continue;
                        $post = ( is_numeric( $single ) ? get_post( $single ) : $single );
                        setup_postdata( $post );
                        $single_type = $post->post_type;
                        $build = $cont[ 'flexible_soggetto' ];
                        $link = $cont[ 'select_soggetto_link' ];
                        $neg = $cont[ 'select_positive_negative_soggetto' ];
                        Get_Template_Part::get_part( SCM_DIR_PARTS_SINGLE . '-' . $single_type . '.php', array(
                            'soggetto_rows' => $build,
                            'soggetto_link' => $link,
                            'soggetto_neg' => $neg,
                        ));

                    break;

                    case 'layout_map':

                        $luoghi = $cont[ 'select_luogo' ];
                        if(!$luoghi) continue;
                        /*$width = ( isset( $cont[ 'dimensione_map' ] ) ? $cont[ 'dimensione_map' ] : 100);
                        $units = ( $cont[ 'select_units_map' ] ?: '%');
                        $zoom = ( isset( $cont[ 'zoom_map' ] ) ? $cont[ 'zoom_map' ] : 10);*/
                        $width = $cont[ 'dimensione_map' ];
                        $units = $cont[ 'select_units_map' ];
                        $zoom = $cont[ 'zoom_map' ];

                        Get_Template_Part::get_part( SCM_DIR_PARTS_SINGLE . '-map.php', array(
                            'map_luoghi' => $luoghi,
                            'map_width' => $width,
                            'map_units' => $units,
                            'map_zoom' => $zoom
                        ));

                    break;

                    case 'layout_luogo':

                        $luoghi = $cont[ 'select_luogo' ];
                        if(!$luoghi) continue;
                        $build = $cont[ 'build_cont_luogo' ];
                        $width = ( $cont[ 'larghezza_luogo' ] >= 0 ? $cont[ 'larghezza_luogo' ] : 100);
                        $legend = ( $cont[ 'legend_luogo' ] ?: 0);

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

                    case 'layout_contact_form':

                        $single = $cont[ 'select_contact_form' ];
                        if(!$single) continue;
                        $post = ( is_numeric( $single ) ? get_post( $single ) : $single );
                        setup_postdata( $post );
                        $single_type = $post->post_type;
                        get_template_part( SCM_DIR_PARTS_SINGLE, $single_type );

                    break;

                    case 'layout_login_form':

                        get_template_part( SCM_DIR_PARTS_SINGLE, 'login-form' );

                    break;

                    case 'layout_icon':

                        $icon_float = ( ( $cont[ 'select_float_icon' ] && $cont[ 'select_float_icon' ] != 'no' ) ? $cont[ 'select_float_icon' ] : 'no-float' );
                        $icon_float = ( $icon_float == 'float-center' ? 'float-center text-center' : $icon_float );
                        $icon = $cont[ 'cont_icon' ];
                        $icon_size = $cont[ 'dimensione_icon' ];
                        $icon_units = ( $cont[ 'select_units_icon' ] ?: 'px' );
                        $icon_class = 'scm-img img ' . $icon_float;
                        $icon_style = 'line-height:0;font-size:' . ( $icon_size ? $icon_size . $icon_units : 'inherit' );

                        indent( $SCM_indent, '<div class="' . $icon_class . '" style="' . $icon_style . '">', 1 );

                            indent( $SCM_indent+1, '<i class="fa ' . $icon . '"></i>', 1 );

                        indent( $SCM_indent, '</div><!-- icon -->', 2 );

                    break;

                    case 'layout_image':

                        $image = ( $cont[ 'cont_image' ] ?: '' );
                        $image_fissa = ( $cont[ 'select_image_format' ] ?: 'norm' );
                        
                        $image_float = ( ( $cont[ 'select_float_image' ] && $cont[ 'select_float_image' ] != 'no' ) ? $cont[ 'select_float_image' ] : 'no-float' );
                        $image_float = ( $image_float == 'float-center' ? 'float-center text-center' : $image_float );

                        $image_class = 'scm-img img ' . $image_float;
                        
                        switch ($image_fissa) {
                            case 'full':
                                $image_float = '';
                                $image_units = ( $cont[ 'select_units_image_full' ] ?: 'px' );
                                $image_height = ( isset( $cont[ 'dimensione_image_full' ] ) ? $cont[ 'dimensione_image_full' ] : 'initial' );
                                $image_height = ( is_numeric( $image_height ) ? $image_height . $image_units : ( $image_height ?: 'initial' ) );
                                $image_style = 'max-height:' . $image_height . ';';
                                $image_class = 'scm-full-image full-image mask full';
                            break;

                            case 'quad':
                                $image_units = ( $cont[ 'select_units_image' ] ?: 'px' );
                                $image_size = ( isset( $cont[ 'dimensione_image' ] ) ? $cont[ 'dimensione_image' ] : 'auto' );
                                $image_size = ( is_numeric( $image_size ) ? $image_size . $image_units : ( $image_size ?: 'auto' ) );
                                $image_style = 'width:' . $image_size . '; height:' . $image_size . ';';
                            break;
                            
                            default:
                                $image_units_w = ( $cont[ 'select_units_image_width' ] ?: '%' );
                                $image_units_h = ( $cont[ 'select_units_image_height' ] ?: '%' );
                                $image_width = ( isset( $cont[ 'dimensione_image_width' ] ) ? $cont[ 'dimensione_image_width' ] : 'auto' );
                                $image_height = ( isset( $cont[ 'dimensione_image_height' ] ) ? $cont[ 'dimensione_image_height' ] : $image_width );
                                $image_width = ( is_numeric( $image_width ) ? $image_width . $image_units_w : 'auto' );
                                $image_height = ( is_numeric( $image_height ) ? $image_height . $image_units_h : ( $image_height ?: $image_width ) );
                                $image_style = 'width:' . $image_width . '; height:' . $image_height . ';';
                            break;
                        }

                        if( !$image )
                            continue;

                        indent( $SCM_indent, '<div class="' . $image_class . '" style="' . $image_style . '">', 1 );

                            indent( $SCM_indent+1, '<img src="' . $image . '" alt="">', 1 );

                        indent( $SCM_indent, '</div><!-- image -->', 2 );

                    break;

                    case 'layout_title':

                        $text = $cont[ 'cont_title' ];
                        $text_default = ( $cont[ 'select_headings_complete_title' ] ?: '' );
                        $text_tag = ( strpos( $text_default, 'select_' ) === false ? $cont[ 'select_headings_complete_title' ] : scm_field( $text_default , 'h1', 'option') );
                        $text_align = ( $cont[ 'select_txt_alignment_title' ] != 'default' ? $cont[ 'select_txt_alignment_title' ] . ' ' : '' );
                        $text_class = scm_acf_field_choices_preset( 'select_headings_default',  $text_default ) . ' ';
                        $text_class .= $text_align . 'scm-title title clear';


                        if( strpos( $text_tag, '.' ) !== false ){
                            $text_class .= ' ' . substr( $text_tag, strpos($text_tag, '.') + 1 );
                            $text_tag = 'h1';
                        }

                        indent( $SCM_indent, '<' . $text_tag . ' class="' . $text_class . '">' . $text . '</' . $text_tag . '><!-- title -->', 2 );

                    break;

                    case 'layout_text':

                        $content = $cont['cont_text'];
                        if(!$content) continue;
                        indent( $SCM_indent, $content, 2 );

                    break;

                    case 'layout_section':

                        $single = $cont[ 'select_section' ];
                        if(!$single) continue;
                        $post = ( is_numeric( $single ) ? get_post( $single ) : $single );
                        setup_postdata( $post );
                        get_template_part( SCM_DIR_PARTS_SINGLE, 'sections' );

                    break;                    
                }
            }

            $SCM_indent -= 1;
        }
    }


//*****************************************************
//*      5.0 FRONT FOOTER
//*****************************************************

    //Prints copyright text
    if ( ! function_exists( 'scm_credits' ) ) {     // +++ todo: ENTRERÀ A FAR PARTE DEGLI ELEMENTI SELEZIONABILI DAL FLEXIBLE CONTENT
        function scm_credits() {

            $copyText = scm_field('footer_credits', '', 'option');
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
    if ( ! function_exists( 'scm_top_of_page' ) ) {     // +++ todo: SPOSTA DA [GENERAL OPTIONS] A [FOOTER OPTIONS]
        function scm_top_of_page() {

            global $SCM_indent;
            
            $id = scm_field( 'id_topofpage', 'site-topofpage', 'option' );
            $icon = scm_field( 'tools_topofpage_icon', 'fa-angle-up', 'option' );
            $text = scm_field( 'tools_topofpage_title', __( 'Inizio Pagina', SCM_THEME ), 'option' );
            $offset = scm_field( 'tools_topofpage_offset', 0, 'option' );
            $title = $text;

            indent( $SCM_indent+1, '<div id="' . $id . '" class="topofpage" data-affix="top" data-affix-offset="' . $offset . '">' );
                
                indent( $SCM_indent+2, '<a href="#top" title="' . $title . '">' );
                    
                    indent( $SCM_indent+3, '<i class="fa ' . $icon . '"></i>' );
                
                indent( $SCM_indent+2, '</a>' );
            
            indent( $SCM_indent+1, '</div>', 2 );

        }
    }

?>