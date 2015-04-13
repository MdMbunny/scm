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
*   (4.0 Front Content) moved to scm-content.php
*   5.0 Front Footer
*
*****************************************************
*/

// *****************************************************
// *      0.0 ACTIONS AND FILTERS
// *****************************************************

    add_action( 'wp_enqueue_scripts', 'scm_site_assets_favicon' );
    add_filter('body_class','scm_body_hook_class');

// *****************************************************
// *      1.0 FRONT HOOKS
// *****************************************************

//************************ FAVICON ***

    //favicon / touch-icons
    if ( ! function_exists( 'scm_site_assets_favicon' ) ) {
        function scm_site_assets_favicon() {

            $ico144 = scm_field('opt-branding-144', '', 'option');
            $ico114 = scm_field('opt-branding-114', '', 'option');
            $ico72 = scm_field('opt-branding-72', '', 'option');
            $ico54 = scm_field('opt-branding-54', '', 'option');
            $png = scm_field('opt-branding-png', '', 'option');
            $ico = scm_field('opt-branding-ico', '', 'option');

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
            
            $logo_id = scm_field( 'opt-ids-branding', 'site-branding', 'option' );

            $follow = scm_field( 'follow-enabled', 0, 'option' );

            $logo_image = esc_url( scm_field( 'brand-logo', '', 'option' ) );
            $logo_height = scm_field( 'brand-height-number', 'auto', 'option' );
            $logo_height = ( is_numeric( $logo_height ) ? $logo_height . scm_field( 'brand-height-units', 'px', 'option' ) : $logo_height );
            //$logo_height= numberToStyle( scm_field( 'branding_header_logo_height', 40, 'option' ) );
            $logo_align = scm_field( 'brand-alignment', 'left', 'option' );

            $logo_title = get_bloginfo( 'name' );
            $logo_slogan = get_bloginfo( 'description' );
            $show_slogan = scm_field( 'brand-slogan', 0, 'option' );
            
            $logo_type = scm_field( 'brand-head', 'text', 'option' );

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

            global $SCM_indent, $SCM_fa;

            $follow = scm_field( 'follow-enabled', 0, 'option' );
            $follow_soggetto = scm_field( 'follow-soggetto', 0, 'option' );
            
            if( !$follow || !$follow_soggetto )
                return;
            
            $follow_id = scm_field( 'opt-ids-social-follow', 'site-social-follow', 'option' );

            $follow_align = scm_field( 'follow-alignment', 'right', 'option' );
            $follow_size = scm_field( 'follow-size-number', 16, 'option' );
            $follow_size = ( is_numeric( $follow_size ) ? $follow_size . scm_field( 'follow-size-units', 'px', 'option' ) : $follow_size );

            $follow_color = scm_field( 'follow-rgba-color', '', 'option' );
            $follow_color = ( $follow_color ? hex2rgba( $follow_color, scm_field( 'follow-rgba-alpha', 1, 'option' ) ) : '' );

            $follow_shape = scm_field( 'follow-shape', 'no', 'option' );

            $follow_shape_size = ( $follow_shape != 'square' ? ' ' . scm_field( 'follow-shape-size', 'normal', 'option' ) : '' );
            $follow_shape_angle = ( $follow_shape != 'square' ? ' ' . scm_field( 'follow-shape-angle', 'all', 'option' ) : '' );

            //printPre($follow_shape);

            $follow_bg = scm_field( 'follow-box-color', '', 'option' );
            $follow_bg = ( $follow_bg ? hex2rgba( $follow_bg, scm_field( 'follow-box-alpha', 1, 'option' ) ) : 'transparent' );

            $follow_social = get_field( 'soggetto-follow-contatti', $follow_soggetto->ID );


            $follow_class = 'button-list horizontal header-column site-social-follow ';
            $follow_class .= ( $follow_align != 'center' ? 'half-width float-' . $follow_align . ' ' : 'full ' );
            $follow_class .= $follow_align . ' inlineblock';

            $in = $SCM_indent + 1;

            indent( $in, '<ul id="' . $follow_id . '" class="' . $follow_class . '">', 2 );

            foreach ($follow_social as $social) {

                if( !$follow_color ){
                    foreach ($SCM_fa['social'] as $value) {
                        $index = getByValue( $value['choices'], $social['icon'] );
                        if( $index !== false ){
                            $social['color'] = ( $value['color'] ?: $follow_color );
                            break;
                        }
                    }
                }else{
                    $social['color'] = $follow_color;
                }

                $style = 'font-size:' . $follow_size . '; color:' . $social['color'] . '; background-color:' . $follow_bg . ';';

                $class = 'social-follow button-icon';
                $class .= ( $follow_shape != 'no' ? ' button ' . $follow_shape . $follow_shape_size . $follow_shape_angle : '' );
                
                indent( $in + 1, '<li><a class="' . $class . '" style="' . $style . '" href="' . $social['link'] . '" target="_blank" title="' . ( $social['name'] ?: '' ) . '" alt="' . $social['link'] . '"><i class="fa ' . $social['icon'] . '"></i></a></li>', 2 );
            
            }

            indent( $in, '</ul><!-- #site-social-follow -->', 2 );

            // +++ todo: in scm-front.php dove costruisco i vari elementi, ci sarebbe da aggiungere il .button (forse per ora anche il .social-follow)
            // così in casi come questo creo solo il div che conterrà una lista di .button

            // +++ todo: devi creare un elemento button-icon (e button-image) in scm-acf-fields.php, o forse in scm-acf-layouts.php
            // che conterrà ICON, TEXT e LINK, come ora i social e i contacts

        }
    }

    //Prints menu
    if ( ! function_exists( 'scm_main_menu' ) ) {
        function scm_main_menu( $align = 'right', $position = 'inline' ) {


            $sticky = scm_field( 'menu-sticky', 'no', 'option' );
            $offset = ( $sticky === 'self' ? 0 : (int)scm_field( 'menu-sticky-offset', 0, 'option' ) );
            $attach = ( $sticky === 'self' ? 'nav-top' : scm_field( 'menu-sticky-attach', 'nav-top', 'option' ) );

            $menu = scm_field( 'page-menu', '' );
            $menu = ( $menu ?: scm_field( 'menu-wp', 'primary', 'option' ) );
            
            $id = scm_field( 'opt-ids-menu', 'site-navigation', 'option' );
            
            $site_align = scm_field( 'layout-alignment', 'center', 'option' );

            $toggle_active = scm_field( 'menu-toggle', 'smart', 'option' );
            $home_active = scm_field( 'menu-home', 'no', 'option' );
            $image_active = scm_field( 'menu-home-logo', 'no', 'option' );

            $menu_id = $id;
            $menu_class = 'navigation ';
            $menu_class .= ( scm_field( 'menu-overlay', 0, 'option' ) ? 'overlay absolute ' : 'relative ' );

            $menu_layout = scm_field( 'layout-page', 'full', 'option' );
            $row_layout = scm_field( 'layout-menu', 'full', 'option' );
            
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

                $sticky_layout = scm_field( 'layout-page', 'full', 'option' );
                $sticky_class = 'navigation sticky ' . ( ( $sticky && $sticky != 'no' ) ? $sticky . ' ' : '' ) . $sticky_layout . ' ' . $site_align;

                $sticky_row_layout = scm_field( 'layout-sticky', 'full', 'option' );
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

            $toggle_icon = 'fa ' . scm_field( 'menu-toggle-icon', 'fa-bars', 'option' );
            $home_icon = 'fa ' . scm_field( 'menu-home-icon', 'fa-home', 'option' );
            $image_icon = scm_field( 'menu-home-image', '', 'option' );

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

                    $wrap .= indent( $in + 2 ) . '<ul class="toggle-content %2$s">%3$s</ul>' . lbreak(2);

                        /*$wrap .= '%3$s' . lbreak();

                    $wrap .= indent( $in + 2 ) . '</ul>' . lbreak(2);*/

                $wrap .= indent( $in + 1 ) . '</div>' . lbreak(2);

            $wrap .= indent( $in ) . '</nav><!-- #' . $id . ' -->' . lbreak( 2 );

            $SCM_indent += 2;

            //consoleLog($wrap);

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


// vedi scm-content.php

    if ( ! function_exists( 'scm_column_data' ) ) {
        function scm_column_data( $counter = 0, $size = 0 ) {

            if( $counter == 1 && $size == 1 )
                return [ 'count' => 0, 'data' => 'solo' ];
            elseif( $counter == $size || $counter > 1 )
                return [ 'count' => $counter, 'data' => 'first' ];
            elseif( $counter == 1 )
                return [ 'count' => 0, 'data' => 'last' ];
            else
                return [ 'count' => $counter, 'data' => 'middle' ];

        }
    }


    if ( ! function_exists( 'scm_count_class' ) ) {
        function scm_count_class( $current = 0, $total = 0 ) {

            $class = '';

            if( $current == 1 )
                $class .= ' first';
            if( $current == $total )
                $class .= ' last';

            $class .= ' count-' . ( $current );

            return $class;

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

            echo lbreak(2);

            indent( $SCM_indent+2, '<div id="' . $id . '" class="topofpage" data-affix="top" data-affix-offset="' . $offset . '">' );
                
                indent( $SCM_indent+3, '<a href="#top" title="' . $title . '">' );
                    
                    indent( $SCM_indent+4, '<i class="fa ' . $icon . '"></i>' );
                
                indent( $SCM_indent+3, '</a>' );
            
            indent( $SCM_indent+2, '</div>', 2 );

        }
    }

?>