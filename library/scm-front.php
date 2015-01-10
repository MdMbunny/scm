<?php

// *****************************************************
// *      ACTIONS AND FILTERS
// *****************************************************

    add_action( 'wp_enqueue_scripts', 'scm_site_assets_favicon' );
    add_action( 'wp_enqueue_scripts', 'scm_site_assets_webfonts' );
    add_action( 'wp_enqueue_scripts', 'scm_site_assets_styles' );
    add_action( 'wp_enqueue_scripts', 'scm_site_assets_scripts' );

    add_filter('body_class','scm_body_hook_class');
    //add_filter( 'pre_get_posts', 'scm_post_hook_pagination' );
    add_filter('synved_social_skin_image_list', 'scm_custom_social_icons');

// *****************************************************
// *      ASSETS
// *****************************************************

    //fonts
    if ( ! function_exists( 'scm_site_assets_webfonts' ) ) {
        function scm_site_assets_webfonts() {
            $fonts =  ( get_field('webfonts', 'option') ? get_field('webfonts', 'option') : array() );
            foreach ($fonts as $value) {                
                $family = str_replace( ' ', '+', $value['family'] );
                $styles = implode( ',', $value['select_webfonts_styles'] );
                wp_register_style( 'webfonts', 'http://fonts.googleapis.com/css?family=' . $family . ':' . $styles, false, SCM_SCRIPTS_VERSION, 'screen' );
                wp_enqueue_style( 'webfonts' );
                
            }
        }
    }

    //styles
    if ( ! function_exists( 'scm_site_assets_styles' ) ) {
        function scm_site_assets_styles() {

            wp_enqueue_style( 'animate' );
            
            //+++ todo: if Fancybox is on page
            wp_enqueue_style( 'fancybox' );
            wp_enqueue_style( 'fancybox-thumbs' );

            wp_enqueue_style( 'global' );            
            wp_enqueue_style( 'style' );
            wp_enqueue_style( 'child' );
            
            //wp_enqueue_style( 'print' ); // +++ todo: if html header is PRINT
            wp_enqueue_style( 'fontawesome' );

        }
    }

    // See scm-styles.php for inline styles 
    
    //scripts
    if ( ! function_exists( 'scm_site_assets_scripts' ) ) {
        function scm_site_assets_scripts() {

            wp_enqueue_script( 'scm-functions' );
            //wp_enqueue_script( 'imagesloaded' ); // +++ todo: check if needed
            wp_enqueue_script( 'single-page-nav' );
            wp_enqueue_script( 'skip-link-focus-fix' );

            //+++ todo: if Fancybox is on page
            wp_enqueue_script( 'fancybox' );
            wp_enqueue_script( 'fancybox-thumbs' );
            
            //+++ todo: if Google Map is on page
            wp_enqueue_script( 'gmapapi' );

            wp_enqueue_script('jquery-effects-core');
            wp_enqueue_script( 'bootstrap' );

        }
    }

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


/*
*****************************************************
*      CONTENTS
*****************************************************
*/

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

    
    
    //Prints copyright text
    if ( ! function_exists( 'scm_credits' ) ) {
        function scm_credits() {

            $copyText = get_field('branding_footer_credits', 'option');
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