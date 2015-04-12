<?php

/**
 * Front end : <head> <body> <page> <header> -> containers
 *
 * @package SCM
 */
//header("Access-Control-Allow-Origin: *");
?><!DOCTYPE html>

<html class="scm no-js" <?php language_attributes(); ?>>

<!-- <meta http-equiv="Cache-control" content="public"> -->

<meta charset="<?php bloginfo( 'charset' ); ?>">

<meta name="author" content="Studio Creativo M - www.studiocreativo-m.it'" />
<meta name="DC.creator" content="Studio Creativo M - www.studiocreativo-m.it" />

<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />

<?php

// [ 1 ] = REDIRECT TO _assets/html/old_ie.html IF IE < scm-settings-general['browser-version']
// [ 2 ] = HTML5 SUPPORT IF IE < 9

$protocol   = ( is_ssl() ) ? ( 'https' ) : ( 'http' );
$redirect = scm_field( 'opt-ie-redirect', '', 'option' );
$redirect = ( get_permalink() === $redirect ? '' : ( $redirect ?: SCM_URI_ASSETS_CHILD . 'html/old_ie.html' ) );

if( function_exists('get_browser_name') ) :
    if( is_ie() ) :
        if( get_browser_version() <= (int)scm_field( 'opt-ie-version', '10', 'option' ) && $redirect ) :
//[ 1 ]
?>
<meta http-equiv="refresh" content="0;url=<?php echo $redirect; ?>" />
<?php
        elseif( get_browser_version() <= 9 ) :
//[ 2 ]
?>
<script src="<?php echo $protocol; ?>://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
<script>window.html5 || document.write('<script src="<?php echo SCM_URI_JS; ?>html5.js"><\/script>')</script>
<script src="<?php echo $protocol; ?>://css3-mediaqueries-js.googlecode.com/svn/trunk/css3-mediaqueries.js"></script>
<?php
        endif;
    endif;
else :
    global $is_IE;

    if( $is_IE ) :
        if( $redirect ) :
//[ 1 ]
?>
<!--[if lte IE <?php echo (int)scm_field( 'opt-ie-version', '10', 'option' ); ?>]>
<meta http-equiv="refresh" content="0;url=<?php echo $redirect; ?>" />
<![endif]-->
<?php
        else :
//[ 2 ]
?>
<!--[if lt IE 9]>
<script src="<?php echo $protocol; ?>://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
<script>window.html5 || document.write('<script src="<?php echo SCM_URI_JS; ?>html5.js"><\/script>')</script>
<script src="<?php echo $protocol; ?>://css3-mediaqueries-js.googlecode.com/svn/trunk/css3-mediaqueries.js"></script>
<![endif]-->
<?php
        endif;
    endif;
endif;
?>

<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />

<?php wp_head(); ?><!-- WP Header Hook -->

</head>

<?php

//********************************
//***************** END HEAD *****
//********************************

global $SCM_indent, $post;

$id = $post->ID;

$skip = __( "Vai al contenuto", SCM_THEME );

$site_align = scm_field( 'layout-alignment', 'center', 'option' );

$page_id = scm_field( 'opt-ids-pagina', 'site-page', 'option' );
$page_layout = scm_field( 'page-layout', 'full', $id );
$page_layout = ( $page_layout != 'default' ? $page_layout : scm_field( 'layout-page', 'full', 'option' ) );
$page_class = $page_layout . ' float-' . $site_align . ' site-page hfeed site';

$fade_in = scm_field( 'opt-tools-fade-in', 0, 'option' );
$fade_out = scm_field( 'opt-tools-fade-out', 0, 'option' );
$fade_wait = scm_field( 'opt-tools-fade-waitfor', 'no', 'option' );

$smooth_duration = scm_field( 'opt-tools-smoothscroll-duration', 0, 'option' );
$smooth_offset = scm_field( 'opt-tools-smoothscroll-offset', 0, 'option' );
$smooth_ease = scm_field( 'opt-tools-smoothscroll-ease', 'swing', 'option' );
$smooth_delay = scm_field( 'opt-tools-smoothscroll-delay', 0, 'option' );
$smooth_new = scm_field( 'opt-tools-smoothscroll-delay_new', 0, 'option' );
$smooth_post = scm_field( 'opt-tools-smoothscroll-page', 'on', 'option' );

$single_class = scm_field( 'opt-tools-singlepagenav-activeclass', 'active', 'option' );
$single_interval = scm_field( 'opt-tools-singlepagenav-interval', 1, 'option' );
$single_offset = scm_field( 'opt-tools-singlepagenav-offset', 0, 'option' );
$single_threshold = scm_field( 'opt-tools-singlepagenav-threshold', 0, 'option' );

//$style_body = scm_options_get_style( get_queried_object_id(), 1, 'bg' );
//$style_page = scm_options_get_style( get_queried_object_id(), 1, 'nobg' );
            
$head_id = scm_field( 'opt-ids-header', 'site-header', 'option' );

$head_layout = ( $page_layout === 'responsive' ? 'full' : scm_field( 'layout-head', 'full', 'option' ) );

$head_class = 'site-header full ' . $site_align;
$head_row_class = 'row scm-row object scm-object ' . $head_layout . ' left';

$menu_position = scm_field( 'head-menu-position', 'inline', 'option' );
$menu_align = scm_field( 'head-menu-alignment', 'right', 'option' );

$follow_position = scm_field( 'head-follow-position', 'top', 'option' );

$cont_id = scm_field( 'opt-ids-content', 'site-content', 'option' );
$cont_layout = ( $page_layout === 'responsive' ? 'full' : scm_field( 'layout-content', 'full', 'option' ) );
$cont_class = 'site-content ' . $cont_layout;

?>

<body <?php body_class(); ?> 
    data-fade-in="<?php echo $fade_in; ?>" 
    data-fade-out="<?php echo $fade_out; ?>" 
    data-fade-wait="<?php echo $fade_wait; ?>"
    data-smooth-duration="<?php echo $smooth_duration; ?>"
    data-smooth-offset="<?php echo $smooth_offset; ?>"
    data-smooth-ease="<?php echo $smooth_ease; ?>"
    data-smooth-delay="<?php echo $smooth_delay; ?>"
    data-smooth-new="<?php echo $smooth_new; ?>"
    data-smooth-post="<?php echo $smooth_post; ?>"
    <?php /*echo $style_body; echo lbreak();*/ ?>
>

<?php

// Page Wrapper
indent( $SCM_indent, '<div id="' . $page_id . '" class="' . $page_class . '">', 2 );
    
    $SCM_indent += 1;
    
    // Skip to Content Link
    indent( $SCM_indent, '<a class="skip-link screen-reader-text" href="#' . $cont_id . '">' . $skip . '</a>', 2 );

    // Head
    indent( $SCM_indent, '<header id="' . $head_id . '" class="' . $head_class . '" role="banner"
            data-current-link="' . $single_class . '"
            data-current-link-interval="' . $single_interval . '"
            data-current-link-offset="' . $single_offset . '"
            data-current-link-threshold="' . $single_threshold . '"
        >', 2 );

    

        // Menu above head
    if ( $menu_position == 'top' )
        scm_main_menu( $menu_align, $menu_position );

    $SCM_indent += 1;

        // Menu row
        indent( $SCM_indent, '<div class="' . $head_row_class . '">', 2 );

            // Logo
            scm_logo();

            // Menu Inline above Social Menu
        if ( $menu_position == 'inline' && $follow_position == 'bottom' )
            scm_main_menu( $menu_align, $menu_position );

            // Social Menu
            scm_social_follow();

            // Menu Inline under Social Menu
        if ( $menu_position == 'inline' && $follow_position == 'top' )
            scm_main_menu( $menu_align, $menu_position );

        indent( $SCM_indent, '</div><!-- .row -->', 2 );

    $SCM_indent -= 1;

        // Menu under head
    if ( $menu_position == 'bottom' )
        scm_main_menu( $menu_align, $menu_position );

    indent( $SCM_indent, '</header><!-- #site-header -->', 2 );
    
    // Content
    indent( $SCM_indent, '<div id="' . $cont_id . '" class="' . $cont_class . '">', 2 );

        $SCM_indent += 1;
        
        indent( $SCM_indent, '<div id="primary" class="content-area full">' );

            $SCM_indent += 1;
            
            indent( $SCM_indent, '<main id="main" class="site-main full" role="main">', 2 );

?>