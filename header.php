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
if( SCM_PAGE_EDIT )
    acf_form_head();

?><!DOCTYPE html>

<html class="scm-<?php echo SCM_VERSION; echo ( SCM_PAGE_EDIT ? ' edit' : '' ); ?> no-js" <?php language_attributes(); ?>>

<meta charset="<?php bloginfo( 'charset' ); ?>">

<meta name="DC.creator" content="Studio Creativo M - www.studiocreativo-m.it" />
<meta name="author" content="<?php bloginfo(); ?>'" />

<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />

<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<link rel="alternate" type="application/rss+xml" title="SCM Feed" href="/feed.xml">

<?php wp_head(); ?><!-- WP Header Hook -->

</head>

<?php

// END HEAD

global $SCM_indent, $post;

$txt_align = scm_utils_style_get( 'align', 'option', 0 );

$wrap_id = 'site-page';
$wrap_layout = scm_field( 'page-layout', scm_field( 'layout-page', 'full', 'option' ), SCM_PAGE_ID );
$wrap_selectors = scm_field( 'page-selectors', array(), SCM_PAGE_ID );
$wrap_layout = ( $wrap_layout === 'full' ? 'full ' : 'responsive float-' );
$wrap_class = scm_field( 'page-class', '', SCM_PAGE_ID, true );
$wrap_class = 'site-page hfeed site ' . $wrap_layout . SCM_SITE_ALIGN . ( scm_field( 'menu-sticky', '', 'option' ) == 'head' ? ' sticky-header' : '' ) . ( $wrap_class ? ' ' . $wrap_class : '' ) . ' ' . implode( ' ', $wrap_selectors );

$fade_in = scm_field( 'opt-tools-fade-in', 0, 'option' );
$fade_out = scm_field( 'opt-tools-fade-out', 0, 'option' );
$fade_opacity = scm_field( 'opt-tools-fade-opacity', 0, 'option' );
$fade_wait = scm_field( 'opt-tools-fade-waitfor', 'no', 'option' );

$smooth_duration = scm_field( 'opt-tools-smoothscroll-duration', 0, 'option' );
$smooth_offset = scm_field( 'opt-tools-smoothscroll-offset-number', 0, 'option' );
$smooth_units = scm_field( 'opt-tools-smoothscroll-offset-units', 0, 'option' );
$smooth_ease = scm_field( 'opt-tools-smoothscroll-ease', 'swing', 'option' );
$smooth_delay = scm_field( 'opt-tools-smoothscroll-delay', 0, 'option' );
$smooth_new = scm_field( 'opt-tools-smoothscroll-delay-new', 0, 'option' );
$smooth_post = scm_field( 'opt-tools-smoothscroll-page', 1, 'option' );

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

$head_class = 'site-header full ' . SCM_SITE_ALIGN . ( scm_field( 'menu-sticky', '', 'option' ) == 'head' ? ' sticky' : '' );
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
$page_slider_terms = scm_field( 'main-slider-terms', '', SCM_PAGE_ID );

?>

<body <?php body_class(); ?> 
    data-fade-in="<?php echo $fade_in; ?>" 
    data-fade-out="<?php echo $fade_out; ?>" 
    data-fade-opacity="<?php echo $fade_opacity; ?>" 
    data-fade-wait="<?php echo $fade_wait; ?>"
    data-smooth-duration="<?php echo $smooth_duration; ?>"
    data-smooth-offset="<?php echo $smooth_offset; ?>"
    data-smooth-offset-units="<?php echo $smooth_units; ?>"
    data-smooth-ease="<?php echo $smooth_ease; ?>"
    data-smooth-delay="<?php echo $smooth_delay; ?>"
    data-smooth-new="<?php echo $smooth_new; ?>"
    data-smooth-post="<?php echo $smooth_post; ?>" 
    data-tofull="<?php echo $tofull; ?>" 
    data-tocolumn="<?php echo $tocolumn; ?>"
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
    indent( $SCM_indent, '<header id="' . $head_id . '" class="' . $head_class . '" role="banner">', 2 );

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
            
            indent( $SCM_indent, '<main id="main" class="site-main full" role="main">', 2 );

                // Page Content
                $SCM_indent += 1;
                indent( $SCM_indent, '<article' . $page_id . ' class="' . $page_class . '">', 2 );
                    $SCM_indent += 1;
                    
                    // Page Header
                    if( $page_slider ){

                        indent( $SCM_indent, '<header class="header scm-header full ' . SCM_SITE_ALIGN . '">', 2 );

                            indent( $SCM_indent + 1, '<div class="row scm-row object scm-object responsive ' . scm_field( 'layout-content', 'full', 'option' ) . '">', 2 );

                                scm_contents( array( 'acf_fc_layout' => 'layout-slider', 'slider' => $page_slider_terms, 'type' => $page_slider ) );

                            indent( $SCM_indent + 1, '</div><!-- row -->', 2 );

                        indent( $SCM_indent, '</header><!-- header -->', 2 );
                    }

?>