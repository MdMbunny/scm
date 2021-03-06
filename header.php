<?php

/**
 * header.php
 *
 * Front end : <head> <body> <page> <header> -> containers
 *
 * @link http://www.studiocreativo-m.it
 *
 * @package SCM
 * @subpackage Root
 * @since 1.0.0
 */

// ACF Form
// ???
/*if( SCM_PAGE_EDIT )
    acf_form_head();*/

// POST
$classes = 'no-js scm-' . SCM_VERSION;
if( is_single() ){
    $classes .= " {$post->post_type}";
}
/*consoleLog( get_post( SCM_PAGE_ID ) );
consoleLog( get_post( $post->ID ) );
consoleLog( SCM_POST_TEMPLATE );
consoleLog( SCM_POST_TYPE );
consoleLog( SCM_POST_TEMP );
consoleLog( SCM_POST_TAX );
consoleLog( SCM_POST_PAGE );*/

$id = $post->ID;

$social_facebook = scm_field( 'opt-staff-facebook', '', 'option' );
$social_twitter = scm_field( 'opt-staff-twitter', '', 'option' );
$social_title = scm_field( 'socialmediacard-title', get_the_title( $id ), $id );
$social_description = scm_field( 'socialmediacard-description', '', $id );
$social_image = scm_field( 'socialmediacard-image', '', $id );
$social_image_full = $social_image ? $social_image['url'] : '';
$social_image_large = $social_image ? ex_attr( $social_image['sizes'], 'large', $social_image ) : '';
$social_image_small = $social_image ? ex_attr( $social_image['sizes'], 'smaller', $social_image_large ) : '';
$social_post = get_post( $id );
$social_date = $social_post->post_date;
$social_modified = $social_post->post_modified;
$social_url = is_front_page() ? SCM_URL : get_permalink( $id );
$social_site = SCM_SITENAME;

?><!DOCTYPE html>

<html class="<?php echo $classes; ?>" <?php language_attributes(); ?>>

<meta charset="<?php bloginfo( 'charset' ); ?>">

<meta name="DC.creator" content="Studio Creativo M - www.studiocreativo-m.it" />
<meta name="author" content="<?php bloginfo(); ?>" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />

<?php
if( $social_description ) indent( 1, '<meta name="description" content="' . $social_description . '" />', 1 );

indent( 1, '<meta itemprop="name" content="' . $social_title . '" />', 1 );
if( $social_description ) indent( 1, '<meta itemprop="description" content="' . $social_description . '" />', 1 );
if( $social_image ) indent( 1, '<meta itemprop="image" content="' . $social_image_large . '" />', 1 );

indent( 1, '<meta name="twitter:card" content="summary_large_image" />', 1 );
if( $social_twitter ) indent( 1, '<meta name="twitter:site" content="@' . $social_twitter . '" />', 1 );
indent( 1, '<meta name="twitter:title" content="' . $social_title . '" />', 1 );
if( $social_description ) indent( 1, '<meta name="twitter:description" content="' . $social_description . '" />', 1 );
if( $social_twitter ) indent( 1, '<meta name="twitter:creator" content="@' . $social_twitter . '" />', 1 );
if( $social_image_small ) indent( 1, '<meta name="twitter:image:src" content="' . $social_image_small . '" />', 1 );

indent( 1, '<meta property="og:title" content="' . $social_title . '" />', 1 );
indent( 1, '<meta property="og:type" content="article" />', 1 );
indent( 1, '<meta property="og:url" content="' . $social_url . '" />', 1 );
if( $social_image ) indent( 1, '<meta property="og:image" content="' . $social_image_large . '" />', 1 );
if( $social_description ) indent( 1, '<meta property="og:description" content="' . $social_description . '" />', 1 );
indent( 1, '<meta property="og:site_name" content="' . $social_site . '" />', 1 );

indent( 1, '<meta property="article:published_time" content="' . $social_date . '" />', 1 );
indent( 1, '<meta property="article:modified_time" content="' . $social_modified . '" />', 1 );

if( $social_facebook ) indent( 1, '<meta property="fb:admins" content="' . $social_facebook . '">', 1 );

?>

<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<link rel="alternate" type="application/rss+xml" title="SCM Feed" href="/feed.xml">

<?php wp_head(); ?><!-- WP Header Hook -->

</head>

<?php

// END HEAD

global $SCM_indent, $SCM_agent, $post;

//$txt_align = scm_utils_style_get( 'align', 'option', 0 );

$sticky_header = scm_field( 'menu-sticky', '', 'option' );

$wrap_id = 'site-page';
$wrap_layout = scm_field( 'page-layout', scm_field( 'layout-page', 'full', 'option' ), SCM_PAGE_ID );
$wrap_selectors = scm_field( 'page-selectors', array(), SCM_PAGE_ID );
$wrap_layout = ( $wrap_layout === 'full' ? 'full ' : 'responsive float-' );
$wrap_class = scm_field( 'page-class', '', SCM_PAGE_ID, true );
$wrap_class = 'site-page hfeed site ' . $wrap_layout . SCM_SITE_ALIGN . ( $sticky_header == 'head' ? ' sticky-header' : '' ) . ( $wrap_class ? ' ' . $wrap_class : '' ) . ' ' . implode( ' ', $wrap_selectors );

$full_height = scm_field( 'page-fullheight', scm_field( 'layout-fullheight', false, 'option' ), SCM_PAGE_ID );

$fade_in = scm_field( 'opt-tools-fade-in', 0, 'option' );
$fade_out = scm_field( 'opt-tools-fade-out', 0, 'option' );
$fade_opacity = scm_field( 'opt-tools-fade-opacity', 0, 'option' );
$fade_wait = scm_field( 'opt-tools-fade-waitfor', 'no', 'option' );

$smooth_duration = scm_field( 'opt-tools-smoothscroll-duration', 1, 'option' );
$smooth_offset = scm_field( 'opt-tools-smoothscroll-offset-number', 0, 'option' );
$smooth_units = scm_field( 'opt-tools-smoothscroll-offset-units', 0, 'option' );
$smooth_head = scm_field( 'opt-tools-smoothscroll-head', 0, 'option' );
$smooth_ease = scm_field( 'opt-tools-smoothscroll-ease', 'swing', 'option' );
$smooth_delay = scm_field( 'opt-tools-smoothscroll-delay', 0.1, 'option' );
$smooth_new = scm_field( 'opt-tools-smoothscroll-delay-new', 0.3, 'option' );
$smooth_page = scm_field( 'opt-tools-smoothscroll-page', 0, 'option' );

$single_class = scm_field( 'opt-tools-singlepagenav-activeclass', 'active', 'option' );
$single_interval = scm_field( 'opt-tools-singlepagenav-interval', 1, 'option' );
$single_offset = scm_field( 'opt-tools-singlepagenav-offset-number', 0, 'option' );
$single_units = scm_field( 'opt-tools-singlepagenav-offset-units', 'em', 'option' );
$single_threshold = scm_field( 'opt-tools-singlepagenav-threshold', 0, 'option' );

$tofull = scm_field( 'layout-tofull', '', 'option' );
$tocolumn = scm_field( 'layout-tocolumn', '', 'option' );
            
$head_id = 'site-header';

$head_layout = scm_field( 'layout-head', 'full', 'option' );
$head_layout = ( $wrap_layout === 'responsive' ? 'full ' : ( $head_layout === 'full' ? 'full ' : 'responsive float-' ) );

$head_class = 'site-header full ' . SCM_SITE_ALIGN . ( $sticky_header == 'head' ? ' sticky' : '' );
$head_row_class = 'row scm-row object scm-object ' . $head_layout . SCM_SITE_ALIGN;

$menu_position = scm_field( 'menu-position', 'inline', 'option' );
$menu_align = scm_field( 'menu-alignment', 'right', 'option' );

$follow_position = scm_field( 'follow-position', 'top', 'option' );

$cont_fade = scm_field( 'opt-tools-fadecontent', '', 'option' );
$cont_offset = scm_field( 'opt-tools-fadecontent-offset', '0%', 'option' );

$cont_id = 'site-content';
$cont_layout = scm_field( 'layout-content', 'full', 'option' );
$cont_layout = ( $wrap_layout === 'responsive' ? 'full ' : ( $cont_layout === 'full' ? 'full ' : 'responsive float-' ) );
$cont_class = 'site-content ' . $cont_layout . SCM_SITE_ALIGN . ( $cont_fade ? ' content-fade' : '' ) ;

$page_class = 'page scm-page object scm-object ' . $post->post_name;
$page_id = scm_field( 'page-selectors-id', '', SCM_PAGE_ID, 1, ' id="', '"' );
$page_class .= scm_field( 'page-selectors-class', '', SCM_PAGE_ID, 1, ' ' );
    
$page_slider = scm_field( 'main-slider-active', '', SCM_PAGE_ID );
$page_slider = ( $page_slider == 'yes' ? ( scm_field( 'opt-tools-nivo', '', 'option' ) ? 'nivo' : 'yes' ) : $page_slider );
$page_slider = ( $page_slider == 'yes' ? ( scm_field( 'opt-tools-bx', '', 'option' ) ? 'bx' : '' ) : $page_slider );

$page_slider_terms = scm_field( 'main-slider-terms', '', SCM_PAGE_ID );
$page_slider_field = scm_field( 'main-slider-field', '', SCM_PAGE_ID );
$page_slider_field = ( $page_slider_field ? scm_field( $page_slider_field, '' ) : '' );
$page_slider_terms = ( $page_slider_field ?: $page_slider_terms );

$has_slider = $page_slider && $page_slider_terms && wp_script_is( $page_slider );

$gmap = scm_field( 'opt-tools-map-api', '', 'option' );

//consoleLog( SCM_POST_TEMPLATE );
//consoleLog( SCM_POST_TYPE );
//consoleLog( SCM_POST_PAGE );

?>

<body <?php body_class(); ?> 
    data-fade-in="<?php echo $fade_in; ?>" 
    data-fade-out="<?php echo $fade_out; ?>" 
    data-fade-opacity="<?php echo $fade_opacity; ?>" 
    data-fade-wait="<?php echo $fade_wait; ?>"
    data-smooth-duration="<?php echo $smooth_duration; ?>"
    data-smooth-offset="<?php echo $smooth_offset; ?>"
    data-smooth-offset-units="<?php echo $smooth_units; ?>"
    data-smooth-head="<?php echo $smooth_head; ?>"
    data-smooth-ease="<?php echo $smooth_ease; ?>"
    data-smooth-delay="<?php echo $smooth_delay; ?>"
    data-smooth-new="<?php echo $smooth_new; ?>"
    data-smooth-page="<?php echo $smooth_page; ?>" 
    data-tofull="<?php echo $tofull; ?>" 
    data-tocolumn="<?php echo $tocolumn; ?>" 
    data-gmap="<?php echo $gmap; ?>" 
    data-ajax="<?php echo admin_url( 'admin-ajax.php' ); ?>" 
    data-has-slider="<?php echo $has_slider; ?>"
    data-fullheight="<?php echo $full_height; ?>"
>

<?php

// Page Wrapper
indent( $SCM_indent, '<div id="' . $wrap_id . '" class="' . $wrap_class . '"
        data-current-link="' . $single_class . '"
        data-current-link-interval="' . $single_interval . '"
        data-current-link-offset="' . $single_offset . '"
        data-current-link-offset-units="' . $single_units . '"
        data-current-link-threshold="' . $single_threshold . '" 
    >', 2 );
    
    $SCM_indent += 1;
    
    // Head
    indent( $SCM_indent, '<header id="' . $head_id . '" class="' . $head_class . '">', 2 );

    do_action( 'scm_action_prepend_header' );

    $just = 0;

        // Menu above head
    if ( $menu_position == 'top' )
        $just = scm_main_menu( $menu_align, $menu_position );

    $SCM_indent += 1;

        // Menu row
        indent( $SCM_indent, '<div class="' . $head_row_class . '">', 2 );

            // Logo
            scm_logo();

            // Menu Inline above Social Menu
        if ( $menu_position == 'inline' && $follow_position == 'bottom' )
            $just = scm_main_menu( $menu_align, $menu_position );

            // Social Menu
            scm_social_follow();

            // Menu Inline under Social Menu
        if ( $menu_position == 'inline' && $follow_position == 'top' )
            $just = scm_main_menu( $menu_align, $menu_position );

        indent( $SCM_indent, '</div><!-- .row -->', 2 );

    $SCM_indent -= 1;

    do_action( 'scm_action_append_header' );

        // Menu under head
    if ( $menu_position == 'bottom' )
        $just = scm_main_menu( $menu_align, $menu_position );

    indent( $SCM_indent, '</header><!-- #site-header -->', 2 );

    if( $just ){
        scm_main_menu( $menu_align, $menu_position, 1 );
    }
    
    // Page Containers
    indent( $SCM_indent, '<div id="' . $cont_id . '" class="' . $cont_class . '"
            data-content-fade="' . $cont_fade . '" 
            data-content-fade-offset="' . $cont_offset . '" >', 2 );

        $SCM_indent += 1;
        
        indent( $SCM_indent, '<div id="primary" class="content-area full">' );

            $SCM_indent += 1;
            
            indent( $SCM_indent, '<main id="main" class="site-main full">', 2 );

                // Page Content
                $SCM_indent += 1;
                indent( $SCM_indent, '<article' . $page_id . ' class="' . $page_class . '">', 2 );
                    $SCM_indent += 1;

                    do_action( 'scm_action_before_slider' );

                    // Page Header
                    if( $has_slider ){

                        indent( $SCM_indent, '<header class="header scm-header full ' . SCM_SITE_ALIGN . '">', 2 );

                            indent( $SCM_indent + 1, '<div class="row scm-row object scm-object ' . scm_field( 'layout-content', 'full', 'option' ) . '">', 2 );

                                scm_contents( array( 'acf_fc_layout' => 'layout-slider', 'slider' => $page_slider_terms, 'type' => $page_slider ) );

                            indent( $SCM_indent + 1, '</div><!-- row -->', 2 );

                        indent( $SCM_indent, '</header><!-- header -->', 2 );
                    }

?>