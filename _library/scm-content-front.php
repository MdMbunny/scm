<?php

/**
* SCM echo front elements (head menu, pagination, footer credits ...).
*
* @link http://www.studiocreativo-m.it
*
* @package SCM
* @subpackage 5-Content/Front
* @since 1.0.0
*/

// ------------------------------------------------------
//
// 1.0 Front Pagination
// 2.0 Front Head
// 3.0 Front Content
// 4.0 Front Footer
//
// ------------------------------------------------------

// ------------------------------------------------------
// 1.0 FRONT PAGINATION
// ------------------------------------------------------

/**
* [ECHO|GET] Pagination
*
* @param {query} query Current query.
* @param {string=} page Query argument for pagination (default is 'paged').
* @param {bool=} echo Echo content if true, returns it otherwise (default is true).
* @return {string} HTML pagination.
*/
function scm_pagination( $query = NULL, $current = 1, $var = 'paged', $echo = true ) {

    global $wp_query, $SCM_indent;

    if ( $query ) $wp_query = $query;

    $pagination = array(
            'base'      => @add_query_arg( $var, '%#%' ),
            'format'    => '?' . $var . '=%#%',
            'current'   => max( 1, $current ),
            'total'     => $wp_query->max_num_pages,
            'prev_text' => '<i class="far fa-chevron-left"></i>',
            'next_text' => '<i class="far fa-chevron-right"></i>',
        );

    // Search page
    if ( get_query_var( 's' ) )
        $pagination['add_args'] = array( 's' => urlencode( get_query_var( 's' ) ) );

    // Remove ajax call
    $pagination['base'] = SCM_SITE . str_replace( SCM_AJAX, '', $pagination['base']);

    // Output
    $pag = '';
    if( 1 < $wp_query->max_num_pages )
        $pag = paginate_links( $pagination );

    if( $echo )
        indent( $SCM_indent + 1, $pag, 1 );
    else
        return $pag;
}

/**
* [ECHO|GET] Pagination More
*
* @param {query} query Current query.
* @param {string=} button HTML button content (default is '').
* @param {string=} page Query argument for pagination (default is 'paged').
* @param {bool=} echo Echo content if true, returns it otherwise (default is true).
* @return {string} HTML pagination.
*/
function scm_pagination_more( $query = NULL, $current = 1, $button = '', $var = 'paged', $echo = true ) {

    global $wp_query, $SCM_indent;

    if ( $query ) $wp_query = $query;

    $pagination = array(
            'base'      => @add_query_arg( $var, '%#%' ),
            'format'    => '?' . $var . '=%#%',
            'current'   => max( 1, $current ),
            'total'     => $wp_query->max_num_pages,
            'end_size'  => 1,
            'mid_size'  => 1,
            'prev_text' => '',
            'type'      => 'array',
            'next_text' => ( $button ?: '<i class="fa fa-chevron-down"></i>' ),
        );
    
    // Remove ajax call
    $pagination['base'] = str_replace( SCM_AJAX, '', $pagination['base']);

    $pag = array();
    if( $current < $wp_query->max_num_pages )
        $pag = paginate_links( $pagination );

    // Output
    if( $echo && sizeof($pag) )
        indent( $SCM_indent + 1, $pag[sizeof($pag)-1], 1 );
    else
        return $pag;
}

// ------------------------------------------------------
// 2.0 FRONT HEADER
// ------------------------------------------------------
// ------------------------------------------------------
// 2.1 LOGO
// ------------------------------------------------------

/**
* [ECHO] Echo head logo
*/
function scm_logo() {

    global $SCM_indent;

    $logo_id = 'site-branding';

    $logo_image = scm_field( 'brand-logo', '', 'option' );
    $logo_field = scm_field( 'brand-field', '', 'option' );
    $logo_field = ( $logo_field ? scm_field( $logo_field, '' ) : '' );
    $logo_image = ( $logo_field ?: $logo_image );
    if( is_numeric( $logo_image ) ){
        $logo_image = get_post( (int)$logo_image );
        $logo_image = $logo_image->guid;
        consoleLog('NOTE: save logo head option page');
    }else{
        $logo_image = esc_url( $logo_image );
    }
    $logo_height = scm_field( 'brand-height-number', '100%', 'option' );
    $logo_height = ( is_numeric( $logo_height ) ? $logo_height . scm_field( 'brand-height-units', 'px', 'option' ) : $logo_height );
    $logo_align = scm_field( 'brand-alignment', 'left', 'option' );

    $logo_title = get_bloginfo( 'name' );
    $logo_slogan = get_bloginfo( 'description' );
    $show_slogan = scm_field( 'brand-slogan', 0, 'option' );

    $logo_link = scm_field( 'brand-link', '', 'option' );

    $logo_type = scm_field( 'brand-head', 'text', 'option' );

    $logo_class = 'header-column site-branding ';
    $logo_class .= ( ( $logo_align != 'center' ) ? 'half-width float-' . $logo_align . ' ' : 'full ' );
    $logo_class .= $logo_align . ' inlineblock';

    $logo_tag = ( is_front_page() ? 'h1' : 'div' );

    $in = $SCM_indent + 1;

    indent( $in, '<div id="' . $logo_id . '" class="' . $logo_class . '">', 2 );

        indent( $in+1 , '<' . $logo_tag . ' class="site-title logo ' . $logo_type . '-only">' );

            if( $logo_link )
                indent( $in+2 , '<a href="' . home_url() . '" title="' . $logo_title . '" style="display:block;">' );

            if( 'img' == $logo_type )
                indent( $in+3 , '<img src="' . $logo_image . '" alt="' . $logo_title . '" title="' . $logo_title . '" style="max-height:' . $logo_height . ';" />' );

                indent( $in+3 , '<span class="' . (  'img' == $logo_type ? 'invisible' : 'text-logo' ) . '">' . $logo_title . '</span>' );

            if( $logo_link )
                indent( $in+2 , '</a>' );

        indent( $in+1 , '</' . $logo_tag . '>', 2 );

    if( $show_slogan )
        indent( $in+1 , '<h2 class="site-description">' . $logo_slogan . '</h2>', 2 );

    indent( $in , '</div><!-- #site-branding -->', 2 );
}

// ------------------------------------------------------
// 2.2 SOCIAL FOLLOW
// ------------------------------------------------------

/**
* [ECHO] Head social links
*/
function scm_social_follow() {

    global $SCM_indent;

    $follow = scm_field( 'follow-enabled', 0, 'option' );
    $follow_soggetto = scm_field( 'follow-soggetto', 0, 'option' );

    if( !$follow || !$follow_soggetto )
        return;

    $follow_align = scm_field( 'follow-alignment', 'right', 'option' );

    $follow_id = 'site-social-follow';
    $follow_class = 'header-column site-social-follow ';
    $follow_class .= ( $follow_align != 'center' ? 'half-width float-' . $follow_align . ' ' : 'full ' );
    $follow_class .= $follow_align . ' inlineblock';

    $in = $SCM_indent + 1;

    indent( $in, '<div id="' . $follow_id . '" class="' . $follow_class . '">', 2 );

        scm_contents( array(
        'acf_fc_layout' => 'layout-social_follow',
        'display' => 'inlineblock',
        'element' => $follow_soggetto,
        'alignment' => $follow_align,
        'size-number' => scm_field( 'follow-size-number', 16, 'option' ),
        'size-units' => scm_field( 'follow-size-units', 'px', 'option' ),
        'rgba-color' => scm_field( 'follow-rgba-color', '', 'option' ),
        'rgba-alpha' => scm_field( 'follow-rgba-alpha', 1, 'option' ),
        'shape' => scm_field( 'follow-shape', 'no', 'option' ),
        'shape-size' => scm_field( 'follow-shape-size', 'normal', 'option' ),
        'shape-angle' => scm_field( 'follow-shape-angle', 'all', 'option' ),
        'box-color' => scm_field( 'follow-box-rgba-color', '', 'option' ),
        'box-alpha' => scm_field( 'follow-box-rgba-alpha', 1, 'option' ),
    ) );

    indent( $in, '</div><!-- #site-social-follow -->', 2 );
}

// ------------------------------------------------------
// 2.3 MAIN MENU
// ------------------------------------------------------
// ------------------------------------------------------
// 2.3.1 SET MENU
// ------------------------------------------------------

/**
* [ECHO] Head menus
*
* @todo 1 - For each page with menu item linked, build auto sub menu items from sections #id:
```php
if( scm_field( 'menu-auto', '', 'option' ) ){
// Build auto menu
}
```
*
* @param {string=} align Menu alignment (default is 'right').
* @param {string=} position Menu position (default is 'inline').
* @param {bool=} just Just sticky menu (default is false).
* @return {bool} Usefull to header.php
*/
function scm_main_menu( $align = 'right', $position = 'inline', $just = false ) {

    $menu = scm_field( 'page-menu', 'default', SCM_PAGE_ID );
    if( !$menu ) return;

    $menu = ( $menu != 'default' ? $menu : scm_field( 'menu-wp', 'primary', 'option' ) );
    if( !$menu ) return;

    $numbers = scm_field( 'menu-numbers', false, 'option' );

    $out = scm_field( 'menu-sticky-out', '', 'option' );
    $sticky = scm_field( 'menu-sticky', '', 'option' );
    $offset = ( $sticky === 'self' ? 0 : (int)scm_field( 'menu-sticky-offset', 0, 'option' ) );
    $attach = ( $sticky === 'self' ? '' : scm_field( 'menu-sticky-attach', 'nav-top', 'option' ) );
    $anim = ( $sticky === 'self' ? '' : scm_field( 'menu-sticky-anim', 'top', 'option' ) );

    $id = 'site-navigation';

    $toggle_active = scm_field( 'menu-toggle', 'smart', 'option' );
    $home_active = scm_field( 'menu-home', '', 'option' );
    $image_active = scm_field( 'menu-home-logo', 'no', 'option' );

    if( !$just ){

        $menu_id = $id;
        $menu_class = 'navigation ';
        $menu_class .= ( scm_field( 'menu-overlay', 0, 'option' ) ? 'overlay absolute ' : 'relative ' );
        $menu_side = scm_field( 'side-enabled', '', 'option' );
        $menu_side_numbers = scm_field( 'side-numbers', '', 'option' );
        $menu_side_names = scm_field( 'side-names', '', 'option' );

        $menu_layout = scm_field( 'layout-page', 'full', 'option' );
        $row_layout = scm_field( 'layout-menu', 'full', 'option' );
        $row_class = '';

        if( $position == 'inline' && $align != 'center' ){
            $menu_class .= 'half-width float-' . $align;
            $row_class = 'full';
        }else{
            $menu_class .= $menu_layout . ' ' . SCM_SITE_ALIGN;
            $row_class = $row_layout . ' ' . $align;
        }

        $menu_data_toggle = $toggle_active;
        $menu_data_home = $home_active && $home_active != 'sticky';
        $menu_data_image = ( $menu_data_home ? $image_active : '' );

        // Print Main Menu
        scm_get_menu( array(
            'id' => $menu_id,
            'class' => $menu_class,
            'row_class' => $row_class,
            'toggle_active' => $menu_data_toggle,
            'home_active' => $menu_data_home,
            'image_active' => $menu_data_image,
            'menu' => $menu,
            'side' => $menu_side,
            'side_numbers' => $menu_side_numbers,
            'side_names' => $menu_side_names,
            'numbers' => $numbers,
        ));

        if ( !$sticky ) {
            return 0;
        }else if ( $sticky != 'head' && $out ) {
            return 1;
        }
    }

    if( $sticky && $sticky != 'head' ){
        $sticky_id = $id . '-sticky';

        $sticky_layout = scm_field( 'layout-page', 'full', 'option' );
        $sticky_class = 'navigation sticky ' . ( $sticky ? $sticky . ' ' : '' ) . ( $attach ? 'attach-' . $attach . ' ' : '' ) . ( $anim ? 'anim-' . $anim . ' ' : '' ) ;

        $sticky_row_layout = scm_field( 'layout-sticky', 'full', 'option' );
        $sticky_row_class = '';

        if( $position == 'inline' && $align != 'center' ){
            $sticky_row_class .= ' half-width float-' . $align . ' ' . $align;
        }else{
            $sticky_class .= $sticky_layout . ' ' . SCM_SITE_ALIGN;
            $sticky_row_class = $sticky_row_layout . ' ' . $align;
        }

        $sticky_data_toggle = $toggle_active;
        $sticky_data_home = $home_active && $home_active != 'menu';
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
            'anim' => $anim,
            'numbers' => $numbers,
        ));

        return 0;
    }
}

// ------------------------------------------------------
// 2.3.2 BUILD MENU
// ------------------------------------------------------

/**
* [ECHO] Head menu
*
* @param {string=} id (default is 'site-navigation' ).
* @param {string=} class (default is 'navigation full' ).
* @param {string=} row_class (default is 'full'  ).
* @param {string=} toggle_active (default is 'smart' ).
* @param {string=} home_active (default is 'false' ).
* @param {string=} image_active (default is 'no' ).
* @param {string=} menu (default is 'primary' ).
* @param {string=} sticky (default is '' ).
* @param {bool=} side (default is false ).
* @param {string=} type (default is 'self' ).
* @param {int=} offset (default is 0 ).
* @param {string=} attach (default is 'nav-top' ).
* @param {string=} anim (default is 'top' ).
*/
function scm_get_menu( $id = 'site-navigation', $class = 'navigation full' , $row_class = 'full' , $toggle_active = 'smart', $home_active = 0, $image_active = 'no', $menu = 'primary', $sticky = '', $side = false, $side_numbers = false, $side_names = false, $type = 'self', $offset = 0, $attach = 'nav-top', $numbers = false, $menu_id = '' ) {

    global $SCM_indent;

    $default = array(
        'id'               => 'site-navigation',
        'class'            => 'navigation full',
        'row_class'        => 'full',
        'toggle_active'    => 'smart',
        'home_active'      => 0,
        'image_active'     => 'no',
        'menu'             => 'primary',
        'menu_id'          => '',
        'sticky'           => '',
        'side'             => false,
        'side_numbers'     => false,
        'side_names'       => false,
        'type'             => 'self',
        'offset'           => 0,
        'attach'           => 'nav-top',
        'anim'             => 'top',
        'numbers'          => false,
    );

    if( is_array( $id ) )
        extract( wp_parse_args( $id, $default ) );    
    
    $data = ( $sticky ? 
        'data-sticky="' . $sticky . '" 
        data-sticky-type="' . $type . '" 
        data-sticky-offset="' . $offset . '" 
        data-sticky-attach="' . $attach . '" 
        data-sticky-anim="' . $anim . '" ' : '' );

    $in = $SCM_indent + 1;

    $auto = $menu == 'auto' || $menu == 'mono' || $menu == 'mini' || $menu == 'nosub';

    $content = ( $menu == 'nosub' ? scm_auto_menu( $numbers, true ) : ( $menu == 'auto' ? scm_auto_menu( $numbers ) : ( $menu == 'mono' ? scm_mono_menu( $numbers ) : ( $menu == 'mini' ? scm_mini_menu( $numbers ) : '%3$s' ) ) ) );

    $wrap = indent( $in ) . '<nav id="' . $id . '" class="' . $class . '" 
                data-toggle="true" 
                data-switch-toggle="' . $toggle_active . '" 
                ' . $data . '
            >' . lbreak();

        $wrap .= indent( $in + 1 ) . '<div class="row ' . $row_class . '">' . lbreak( 2 );

            $home = get_home_url();
            
            // TOGGLE BUTTON

            $toggle_top = scm_field( 'menu-toggle-top', false, 'option' );
            $toggle_home = scm_field( 'menu-toggle-home', false, 'option' );
            $toggle_link = ( $toggle_top && !$toggle_home ? '#top' : ( !$toggle_top && $toggle_home ? $home : ( $toggle_top && $toggle_home ? ( $sticky ? '#top' : $home ) : '' ) ) );
            $toggle_open = 'fa ' . scm_field( 'menu-toggle-icon-open', 'fa-bars', 'option' );
            $toggle_close = 'fa ' . scm_field( 'menu-toggle-icon-close', 'fa-arrow-circle-close', 'option' );
            
            $wrap .= indent( $in + 2 ) . '<div class="toggle-button" data-switch="' . $toggle_active . '">' . lbreak(2);

                $wrap .= indent( $in + 3 ) . '<i class="icon-toggle ' . $toggle_open . '" data-toggle-button="off"></i>' . lbreak();
                if( !$toggle_link )
                    $wrap .= indent( $in + 3 ) . '<i class="icon-home ' . $toggle_close . '" data-toggle-button="on"></i>' . lbreak(2);
                else
                    $wrap .= indent( $in + 3 ) . '<a class="icon-home" href="' . $toggle_link . '" data-toggle-button="on"><i class="' . $toggle_close . '"></i></a>' . lbreak(2);

            $wrap .= indent( $in + 2 ) . '</div>' . lbreak(2);

            // HOME BUTTON

            $home_icon = scm_field( 'menu-home-icon', '', 'option' );
            $home_image = scm_field( 'menu-home-image', '', 'option' );
            $home_text = scm_field( 'menu-home-text', '', 'option' );

            if( $home_active ){

                $wrap .= indent( $in + 2 ) . '<a class="home-button" href="' . $home . '">';

                    if( $home_icon )
                        $wrap .= '<i class="' . $home_icon . '"></i>';
                    if( $home_image )
                        $wrap .= '<img src="' . $home_image . '" alt="" />' . lbreak(2);
                    if( $home_text )
                        $wrap .= '<span>' . $home_text . '</span>';

                $wrap .= '</a>' . lbreak(2);
            }

            // MENU

            $wrap .= indent( $in + 2 ) . '<ul class="toggle-content menu ' . $menu . '">' . lbreak(2) . $content . lbreak() . indent( $in + 2 ) . '</ul>' . lbreak(2);

        $wrap .= indent( $in + 1 ) . '</div>' . lbreak(2);

        if( $side ){
            $wrap .= scm_side_menu( $side_numbers, $side_names );
        }

    $wrap .= indent( $in ) . '</nav><!-- #' . $id . ' -->' . lbreak( 2 );

    $SCM_indent += 2;

    // Print Auto Menu or Mono Menu
    if( $auto ){
        echo $wrap;
    // Print WP Menu
    }else{
        wp_nav_menu( array(
            'container' => false,
            'theme_location' => $menu,
            'menu' => $menu_id, // id, name or slug
            'items_wrap' => $wrap,
            'walker' => new Sublevel_Walker
        ) );
    }

    $SCM_indent -= 2;
}

// ------------------------------------------------------
// 2.3.3 MENU AUTO
// ------------------------------------------------------

/**
* [GET] Menu Auto + Span
*
* @param {string=} ret (default is '').
* @return {string} HTML tag.
*/
function scm_auto_menu_item( $icon = '', $link = '', $sub = '' ) {
    $ret = '';
    if( is_numeric( $icon ) )
        $ret .= scm_auto_menu_item_number( $icon );
    else
        $ret .= scm_auto_menu_item_icon( $icon );
    $ret .= $link;
    $ret .= scm_auto_menu_item_span( $sub );
    return $ret;
}

/**
* [GET] Menu Auto + Span
*
* @param {string=} ret (default is '').
* @return {string} HTML tag.
*/
function scm_auto_menu_item_span( $ret = '' ) {
    if( $ret )
        $ret = '<span class="sub">' . $ret . '</span>';
    return $ret;
}

/**
* [GET] Menu Auto + Icon
*
* @param {string=} ret (default is '').
* @return {string} HTML tag.
*/
function scm_auto_menu_item_icon( $ret = '' ) {
    if( $ret && $ret != 'fa-no' && $ret != 'no' )
        return '<span class="icon"><i class="fa ' . $ret . '"></i></span>';
    return '';
}

/**
* [GET] Menu Auto + Number
*
* @param {string=} ret (default is '').
* @return {string} HTML tag.
*/
function scm_auto_menu_item_number( $ret = '' ) {
    if( $ret ){
        $icon = $ret;
        $ret = '<span class="icon stack fa-stack fa-3x">';
        $ret .= '<i class="fa fa-circle fa-stack-2x"></i>';
        $ret .= '<strong class="fa-stack-1x fa-stack-text fa-inverse">' . $icon . '</strong>';
        $ret .= '</span>';
    }
    return $ret;
}

/**
* [GET] Menu Auto
*
* @param {int=} depth (default is 0).
* @return {string} HTML tag.
*/
function scm_auto_menu( $numbers = false, $nosub = false ) {
    global $post;
    $ret = '';
    $pages = subObject( get_pages( array( 'sort_column'=>'menu_order' ) ), 'menu_order', 0, true );
    $i = 0;

    $pages = apply_filters( 'scm_filter_menu_auto', $pages );

    $ret = apply_filters( 'scm_filter_menu_auto_first', $ret );

    $tot = sizeof( $pages );

    $lang = '';
    if( function_exists('pll_current_language') )
        $lang = pll_current_language();
    
    foreach ( $pages as $page ) {
        $id = $page->ID;
        if( $lang && $lang != pll_get_post_language( $id ) ) continue;
        $i++;
        $depth = 0;
        $url = getURL( 'page:' . $page->post_name );
        $link = scm_field( 'page-id', $page->post_title, $id, true );
        $icon = scm_field( 'page-icon', '', $id, true );
        $sub = scm_field( 'page-sub', '', $id, true );
        $content = scm_auto_menu_item( $icon, $link, $sub );
        $current = $id == $post->ID;

        $children = scm_field( 'sections', array(), $id, true );
        $has = scm_auto_menu_sub( $children, $depth + 1, 'auto', $numbers );
        $has_children = sizeof( $children ) && $has && !$nosub;

        $ret .= scm_get_menu_item_open( $depth, $url, $content, $has_children, $current, $page->post_name . ( $icon ? ' hasicon' : '' ) . ( $sub ? ' hassub' : '' ), $i, $tot, 'auto' );

            if( $has_children )
                $ret .= scm_get_submenu_open( $depth + 1 ) . $has . scm_get_submenu_close( $depth + 1 );

        $ret .= scm_get_menu_item_close( $depth );
        
    }

    $ret = apply_filters( 'scm_filter_menu_auto_last', $ret );

    return $ret;
}

/**
* [GET] Sub menu Mini for Menu Auto
*
* @param {array} children.
* @param {int=} depth (default is 0).
* @return {string} HTML tag.
*/
function scm_auto_menu_sub_mini( $children, $depth = 0, $menu = 'main', $numbers = false, $names = false ) {
    $ret = '';
    $i = 0;
    $tot = sizeof( $children );

    foreach ($children as $child ) {
        $i++;
        $ret .= scm_auto_menu_sub_item( $child, $depth, $i, $tot, 'mini', $numbers, $names );
    }
    return $ret;
}

/**
* [GET] Sub menu for Menu Auto
*
* @param {array} children.
* @param {int=} depth (default is 0).
* @return {string} HTML tag.
*/
function scm_auto_menu_sub( $children, $depth = 0, $menu = 'main', $numbers = false, $names = false ) {
    $ret = '';
    $i = $j = 0;
    $toti = sizeof( $children );
    

    //consoleLog( $menu . ' = numbers > ' . $numbers . ' & names > ' . $names );
    
    foreach ($children as $child ) {
        $i++;
        $ret .= scm_auto_menu_sub_item( $child, $depth, $i, $toti, $menu, $numbers, $names );
        $sections = ( $child['rows'] ?: array() );

        $sections = apply_filters( 'scm_filter_menu_sub_auto', $sections );
        $totj = sizeof( $sections );
        foreach ( $sections as $section ){
            $j++;
            $ret .= scm_auto_menu_sub_item( $section, $depth + 1, $j, $totj, $menu, $numbers, $names );
        }
    }
    return $ret;
}

/**
* [GET] Sub item for Menu Auto
*
* @param {array} item.
* @param {int=} depth (default is 0).
* @return {string} HTML tag.
*/
function scm_auto_menu_sub_item( &$item, $depth = 0, $count = 0, $tot = 0, $menu = 'main', $numbers = false, $names = false ) {
    if( !$item || !is_asso( $item ) || !array_key_exists( 'id', $item ) || ex_attr( $item, 'nomenu', 0 ) === true ) return '';
    $id = $item['id'];
    $icon = ex_attr( $item, 'icon', '' );
    $sub = ex_attr( $item, 'sub', '' );
    $content = '';
    if( startsWith( $id, 'field:' ) )
        $id = $item['id'] = scm_field( str_replace( 'field:', '', $id), '' );
    if( $id ){
        $content = scm_auto_menu_item( ( $numbers ? $count : $icon ), ( $names ? '' : $id ), $sub );
        $content = scm_get_menu_item_open( $depth, '#' . sanitize_title( $id ), $content, false, false, sanitize_title( $id ) . ( $icon ? ' hasicon' : '' ) . ( $sub ? ' hassub' : '' ), $count, $tot, $menu ) . scm_get_menu_item_close( $depth );
    }
    return $content;
}

// ------------------------------------------------------
// 2.3.4 MENU MONO
// ------------------------------------------------------

/**
* [GET] Menu Mono
*
* @return {string} HTML tag.
*/
function scm_mono_menu( $numbers = false ) {
    $ret = '';
    $id = SCM_PAGE_ID;

    $children = scm_field( 'sections', array(), $id, true );
    $has_children = sizeof( $children );

    $children = apply_filters( 'scm_filter_menu_mono', $children );

    if( $has_children ){
        $ret .= scm_auto_menu_sub( $children, 0, 'mono', $numbers );
    }
        
    return $ret;
}

// ------------------------------------------------------
// 2.3.5 MENU MINI
// ------------------------------------------------------

/**
* [GET] Menu Mini
*
* @return {string} HTML tag.
*/
function scm_mini_menu( $numbers = false ) {
    $ret = '';
    $id = SCM_PAGE_ID;

    $children = scm_field( 'sections', array(), $id, true );
    $has_children = sizeof( $children );

    $children = apply_filters( 'scm_filter_menu_mini', $children );

    if( $has_children ){
        $ret .= scm_auto_menu_sub_mini( $children, 0, 'mini', $numbers );
    }
        
    return $ret;
}

// ------------------------------------------------------
// 2.3.6 MENU SIDE
// ------------------------------------------------------

/**
* [GET] Menu Side
*
* @return {string} HTML tag.
*/
function scm_side_menu( $numbers = false, $names = false ) {
    global $SCM_indent;
    $children = scm_field( 'sections', array(), SCM_PAGE_ID, true );
    $ret = lbreak() . indent( $SCM_indent + 2 ) . '<div id="side-menu" class="' . ( $names ? 'no-name' : 'name' ) . '">' . lbreak();
        $ret .= lbreak() . indent( $SCM_indent + 3 ) . '<ul class="side-menu">' . lbreak();
            $ret .= scm_auto_menu_sub( $children, 0, 'side', $numbers, $names );
        $ret .= indent( $SCM_indent + 3 ) . '</ul>' . lbreak(2);
    $ret .= indent( $SCM_indent + 2 ) . '</div><!-- Side Menu -->' . lbreak(2);
        
    return $ret;
}

// ------------------------------------------------------
// 2.3.7 MENU WP
// ------------------------------------------------------

if ( ! class_exists( 'Sublevel_Walker' ) ) {
    /**
     * Sublevel_Walker.php
     *
     * Sub menu items class
     *
     * @link http://www.studiocreativo-m.it
     *
     * @package SCM
     * @subpackage 5-Content/Front
     * @since 1.0.0
     */
    class Sublevel_Walker extends Walker_Nav_Menu {
        function start_lvl( &$output, $depth = 0, $args = array() ) {
            $output .= scm_get_submenu_open( $depth );
        }

        function end_lvl( &$output, $depth = 0, $args = array() ) {
            $output .= scm_get_submenu_close( $depth );
        }

        function start_el( &$output, $object, $depth = 0, $args = array(), $current_object_id = 0 ) {
            $output .= scm_get_menu_item_open( $depth, getURL( $object->url ), $object->title, ( isset( $object->classes ) ? getByValue( $object->classes, 'menu-item-has-children' ) : false ), $object->current, sanitize_title( $object->title ) );
        }

        function end_el( &$output, $object, $depth = 0, $args = array() ) {
            $output .= scm_get_menu_item_close( $depth );
        }
    }
}

// ------------------------------------------------------
// 2.3.8 HTML TAGS
// ------------------------------------------------------

/**
* [GET] Open navigation item tag
*
* @param {int=} depth (default is 0).
* @param {string=} url (default is '#').
* @param {string=} content (default is '').
* @param {bool=} has_children (default is false).
* @param {bool=} current (default is false).
* @param {string=} class (default is '').
* @return {string} HTML tag.
*/
function scm_get_menu_item_open( $depth = 0, $url = '#', $content = '', $has_children = false, $current = false, $class = '', $count = 0, $tot = 0, $menu = 'main' ) {

    global $SCM_indent;
    $ind = $SCM_indent + 4 + $depth;
    //if( !$depth ) $ind = $SCM_indent + 2;

    $type = 'site';
    $attr = '';
    $class = ( $current ? $class . ' current' : $class );    
    if( $current ) $url = '#top';
    if( strpos( $url, '#') === 0 )
        $type = 'page';
    else if( strpos( $url, SCM_DOMAIN ) === false )
        $type = 'external';

    
    $link = '<a href="' . $url . '">';
    $link_cont = apply_filters( 'scm_filter_menu_item_before', '', $depth, $count, $content, $has_children, $menu );
    $link_cont .= $content;
    $link .= apply_filters( 'scm_filter_menu_item', $link_cont, $depth, $count, $content, $has_children, $menu );
    $link .= '</a>';
    
    if( $has_children ){
        $attr = 'data-toggle="true" ';
        $class .= ' has-children toggle no-toggled';
        $link = lbreak() . indent( $ind + $depth + 1 ) . '<div class="toggle-button">' . $link . '</div>';
    }    

    $class = apply_filters( 'scm_filter_menu_item_class', $class, $depth, $count, $content, $has_children, $menu );
    $attr = apply_filters( 'scm_filter_menu_item_attr', $attr, $depth, $count, $content, $has_children, $menu );

    $ret = indent( $ind + $depth ) . '<li class="' . ( $count ? 'item-' . $count . ' ' : '' ) . /*sanitize_title( $content ) .*/ 'menu-item link-' . $type . ' ' . $class . ' depth-' . $depth . '"' . ( $attr ? ' ' . $attr : '' ) . ' data-menu-item-width="1' . $tot . '">' . $link;
    return $ret;

}

/**
* [GET] Close navigation item tag
*
* @param {int=} depth (default is 0).
* @return {string} HTML tag.
*/
function scm_get_menu_item_close( $depth = 0 ) {
    return '</li>' . lbreak();
}

/**
* [GET] Open navigation sub-menu tag
*
* @param {int=} depth (default is 0).
* @return {string} HTML tag.
*/
function scm_get_submenu_open( $depth = 1 ) {
    global $SCM_indent;
    return lbreak() . indent( $SCM_indent + 4 + $depth ) . '<ul class="toggle-content sub-menu depth-' . $depth . '">' . lbreak();
}

/**
* [GET] Close navigation sub-menu tag
*
* @param {int=} depth (default is 0).
* @return {string} HTML tag.
*/
function scm_get_submenu_close( $depth = 1 ) {
    global $SCM_indent;
    return indent( $SCM_indent + 4 + $depth ) . '</ul>' . lbreak() . indent( 6 );
}

// ------------------------------------------------------
// 3.0 FRONT CONTENT
// ------------------------------------------------------

// ------------------------------------------------------
// 4.0 FRONT FOOTER
// ------------------------------------------------------

/**
* [ECHO] Footer top of page
*/
function scm_top_of_page() {

    global $SCM_indent;

    $id = 'site-topofpage';
    $icon = scm_field( 'opt-tools-topofpage-icon', 'fas fa-angle-up', 'option' );
    $text = scm_field( 'opt-tools-topofpage-title', __( 'Inizio Pagina', SCM_THEME ), 'option' );
    $offset = scm_field( 'opt-tools-topofpage-offset', 0, 'option' );
    $title = $text;

    echo lbreak(2);

    indent( $SCM_indent+2, '<div id="' . $id . '" class="topofpage" data-affix="top" data-affix-offset="' . $offset . '">' );

        indent( $SCM_indent+3, '<a href="#top" title="' . $title . '">' );

            indent( $SCM_indent+4, '<i class="fa ' . $icon . '"></i>' );

        indent( $SCM_indent+3, '</a>' );

    indent( $SCM_indent+2, '</div>', 2 );
}

?>