<?php

/**
* scm-content-front.php.
*
* SCM front end functions.
*
* @link http://www.studiocreativo-m.it
*
* @package SCM
* @subpackage Content/Front
* @since 1.0.0
*/

/**
* @global int $SCM_indent Used for formatting HTML
*/
$SCM_indent         = 1;

/**
* @global int $SCM_page_id Current page id
*/
$SCM_page_id        = 0;

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
* [GET] Pagination
*
* @param {query} query Current query.
* @param {string=} page Query argument for pagination (default is 'paged').
* @param {string=} anchor Optional anchor attached (default is '').
* @return {string} HTML pagination.
*/
function scm_pagination( $query = NULL, $page = 'paged', $anchor = '' ) {

    global $wp_query, $wp_rewrite;

    //Override global WordPress query if custom used
    if ( $query ) $wp_query = $query;

    $paged = $wp_query->query['paged'];

    //WordPress pagination settings
    $pagination = array(
            'base'      => @add_query_arg( $page, '%#%' ),
            'format'    => '?' . $page . '=%#%',
            'current'   => max( 1, $paged ),
            'total'     => $wp_query->max_num_pages,
            'prev_text' => '<i class="fa fa-chevron-left"></i>',
            'next_text' => '<i class="fa fa-chevron-right"></i>',
            //'add_args'  => array( $page => urlencode( $paged ) ),
        );

    //Nice URLs
    /*if ( $wp_rewrite->using_permalinks() ) {
        $pagination['base'] = user_trailingslashit( trailingslashit( remove_query_arg( 's', get_pagenum_link( 1 ) ) ) . 'page' . $type . '/%#%/', $page );
    }*/

    //Search page
    if ( get_query_var( 's' ) ) {
        $pagination['add_args'] = array( 's' => urlencode( get_query_var( 's' ) ) );
    }

    $pagination['base'] .=  $anchor;

    //Output
    if( 1 < $wp_query->max_num_pages )
        return paginate_links( $pagination );

    return '';
}

// ------------------------------------------------------
// 2.0 FRONT HEADER
// ------------------------------------------------------

/**
* [GET] Echo head logo
*/
function scm_logo() {

    global $SCM_indent;

    $logo_id = 'site-branding';

    //$follow = scm_field( 'follow-enabled', 0, 'option' );

    $logo_image = esc_url( scm_field( 'brand-logo', '', 'option' ) );
    $logo_height = scm_field( 'brand-height-number', '100%', 'option' );
    $logo_height = ( is_numeric( $logo_height ) ? $logo_height . scm_field( 'brand-height-units', 'px', 'option' ) : $logo_height );
    //$logo_height= numberToStyle( scm_field( 'branding_header_logo_height', 40, 'option' ) );
    $logo_align = scm_field( 'brand-alignment', 'left', 'option' );

    $logo_title = get_bloginfo( 'name' );
    $logo_slogan = get_bloginfo( 'description' );
    $show_slogan = scm_field( 'brand-slogan', 0, 'option' );

    $logo_link = scm_field( 'brand-link', '', 'option' );

    $logo_type = scm_field( 'brand-head', 'text', 'option' );

    $logo_class = 'header-column site-branding ';
    $logo_class .= ( ( $logo_align != 'center' ) ? 'half-width float-' . $logo_align . ' ' : 'full ' );
    $logo_class .= $logo_align . ' inlineblock';

    //SEO logo HTML tag
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

/**
* [GET] Echo head social links
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

/**
* [SET|GET] Echo head menu
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

    global $SCM_page_id;;
    $id = $SCM_page_id;

    $menu = scm_field( 'page-menu', 'default', $id );
    if( !$menu ) return;

    $menu = ( $menu != 'default' ? $menu : scm_field( 'menu-wp', 'primary', 'option' ) );
    if( !$menu ) return;

    $out = scm_field( 'menu-sticky-out', '', 'option' );
    $sticky = scm_field( 'menu-sticky', '', 'option' );
    $offset = ( $sticky === 'self' ? 0 : (int)scm_field( 'menu-sticky-offset', 0, 'option' ) );
    $attach = ( $sticky === 'self' ? 'nav-top' : scm_field( 'menu-sticky-attach', 'nav-top', 'option' ) );

    $id = 'site-navigation';

    $site_align = scm_field( 'layout-alignment', 'center', 'option' );

    $toggle_active = scm_field( 'menu-toggle', 'smart', 'option' );
    $home_active = scm_field( 'menu-home', '', 'option' );
    $image_active = scm_field( 'menu-home-logo', 'no', 'option' );

    if( !$just ){

        $menu_id = $id;
        $menu_class = 'navigation ';
        $menu_class .= ( scm_field( 'menu-overlay', 0, 'option' ) ? 'overlay absolute ' : 'relative ' );

        $menu_layout = scm_field( 'layout-page', 'full', 'option' );
        $row_layout = scm_field( 'layout-menu', 'full', 'option' );
        $row_class = '';

        if( $position == 'inline' && $align != 'center' ){
            $menu_class .= 'half-width float-' . $align;
            $row_class = 'full';
        }else{
            $menu_class .= $menu_layout . ' ' . $site_align;
            $row_class = $row_layout . ' ' . $align;
        }

        $menu_data_toggle = $toggle_active;
        $menu_data_home = ( ( $home_active == 'both' || $home_active == 'menu' ) ? 'true' : 'false' );
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
        ));

        if( !$sticky ){
            return 0;
        }else{
            if( $out ){
                return 1;
            }
        }
    }

    if( $sticky && $sticky != 'head' ){
        $sticky_id = $id . '-sticky';

        $sticky_layout = scm_field( 'layout-page', 'full', 'option' );
        $sticky_class = 'navigation sticky ' . ( $sticky ? $sticky . ' ' : '' );

        $sticky_row_layout = scm_field( 'layout-sticky', 'full', 'option' );
        $sticky_row_class = '';

        if( $position == 'inline' && $align != 'center' ){
            $sticky_row_class .= ' half-width float-' . $align . ' ' . $align;
        }else{
            $sticky_class .= $sticky_layout . ' ' . $site_align;
            $sticky_row_class = $sticky_row_layout . ' ' . $align;
        }

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

        return 0;
    }
}

/**
* [GET] Head menu
*
* @param {string=} id (default is 'site-navigation' ).
* @param {string=} class (default is 'navigation full' ).
* @param {string=} row_class (default is 'full'  ).
* @param {string=} toggle_active (default is 'smart' ).
* @param {string=} home_active (default is 'false' ).
* @param {string=} image_active (default is 'no' ).
* @param {string=} menu (default is 'primary' ).
* @param {string=} sticky (default is '' ).
* @param {string=} type (default is 'self' ).
* @param {int=} offset (default is 0 ).
* @param {string=} attach (default is 'nav-top' ).
*/
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

    $home = get_home_url();
    $toggle_link = ( $sticky ? '#top' : $home );
    $toggle_icon = 'fa ' . scm_field( 'menu-toggle-icon-open', 'fa-bars', 'option' );
    $home_icon = 'fa ' . ( $sticky ? scm_field( 'menu-toggle-icon-close', 'fa-arrow-circle-close', 'option' ) : scm_field( 'menu-home-icon', 'fa-home', 'option' ) );
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
                $wrap .= indent( $in + 3 ) . '<a class="icon-home" href="' . $toggle_link . '" data-toggle-button="on"><i class="' . $home_icon . '"></i></a>' . lbreak();

            $wrap .= indent( $in + 2 ) . '</div>' . lbreak(2);

        if( $home_active == 'true' ){

            if( $image_active && $image_active != 'no' ){

                $wrap .= indent( $in + 2 ) . '<a class="toggle-image" href="' . $toggle_link . '" data-switch="' . $image_active . '" data-switch-with=".toggle-home"><img src="' . $image_icon . '" alt="" /></a>' . lbreak(2);
                $wrap .= indent( $in + 2 ) . '<a class="toggle-home" href="' . $toggle_link . '"><i class="' . $home_icon . '"></i></a>' . lbreak(2);

            }else{

                $wrap .= indent( $in + 2 ) . '<a class="toggle-home" href="' . $toggle_link . '" data-switch><i class="' . $home_icon . '"></i></a>' . lbreak(2);

            }
        }

            $wrap .= indent( $in + 2 ) . '<ul class="toggle-content %2$s">' . lbreak(2) . '%3$s' . lbreak() . indent( $in + 2 ) . '</ul>' . lbreak(2);

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

if ( ! class_exists( 'Sublevel_Walker' ) ) {
    /**
     * Sublevel_Walker.php
     *
     * Sub menu items class
     *
     * @link http://www.studiocreativo-m.it
     *
     * @package SCM
     * @subpackage Content/Front
     * @since 1.0.0
     */
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

            $url = getURL( $object->url );

            $content = $object->title;
            $type = 'site';
            $button = '';
            $data = '';

            if( $current )
                $url = '#top';

            if( strpos( $url, '#') === 0 ){
                $type = 'page';
            }else if( strpos( $url, SCM_DOMAIN ) === false ){
                $type = 'external';
            }

            $link = '<a href="' . $url . '">' . $content . '</a>';

            $classes = $object->classes;
            $has_children = ( isset( $classes ) ? getByValue( $object->classes, 'menu-item-has-children' ) : NULL );

            if( !is_null( $has_children ) ){
                $data = ' data-toggle="true" ';
                $class .= ' has-children toggle no-toggled';
                $link = '<div class="toggle-button">' . $link . '</div>';
            }

            $output .= indent( $ind + $depth ) . '<li class="' . sanitize_title( $link ) . ' menu-item link-' . $type . $class . '"' . $data . '>' . $link;

        }

        function end_el( &$output, $object, $depth = 0, $args = array() ) {
            $output .= '</li>' . lbreak();
        }
    }
}

// ------------------------------------------------------
// 3.0 FRONT CONTENT
// ------------------------------------------------------

/**
* [GET] Column data
*
* @param {int=} counter Column counter (default is 0).
* @param {int=} size Column counter size (default is 0).
* @return {array} Array containing 'count' and 'data'.
*/
function scm_column_data( $counter = 0, $size = 0 ) {

    if( $counter == 1 && $size == 1 )
        return array( 'count' => 0, 'data' => 'solo' );
    elseif( $counter == $size || $counter > 1 )
        return array( 'count' => $counter, 'data' => 'first' );
    elseif( $counter == 1 )
        return array( 'count' => 0, 'data' => 'last' );
    else
        return array( 'count' => $counter, 'data' => 'middle' );
}

/**
* [GET] Column class
*
* @param {int=} current Current column (default is 0).
* @param {int=} total Column total (default is 0).
* @return {string} String class.
*/
function scm_count_class( $current = 0, $total = 0 ) {

    $class = '';

    if( $current == 1 )
        $class .= ' first';
    if( $current == $total )
        $class .= ' last';

    $class .= ' count-' . ( $current );

    return $class;
}

// ------------------------------------------------------
// 4.0 FRONT FOOTER
// ------------------------------------------------------

/**
* [SET] Echo footer credits
*/
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

/**
* [SET] Echo footer top of page
*/
function scm_top_of_page() {

    global $SCM_indent;

    $id = 'site-topofpage';
    $icon = scm_field( 'opt-tools-topofpage-icon', 'fa-angle-up', 'option' );
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