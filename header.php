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

if( function_exists('get_browser_name') ) :
    if( is_ie() ) :
        if( get_browser_version() <= (int)scm_field( 'ie_version', '10', 'option' ) ) :
//[ 1 ]
?>
<meta http-equiv="refresh" content="0;url=<?php echo SCM_DIR_ASSETS . 'html/old_ie.html'; ?>" />
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
//[ 1 ]
?>
<!--[if lte IE <?php echo (int)scm_field( 'ie_version', '10', 'option' ); ?>]>
<meta http-equiv="refresh" content="0;url=<?php echo SCM_DIR_ASSETS . 'html/old_ie.html'; ?>" />
<![endif]-->
<?php
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
?>

<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />

<?php wp_head(); ?><!-- WP Header Hook -->

</head>

<?php

//********************************
//***************** END HEAD *****
//********************************

$skip = __( "Vai al contenuto", SCM_THEME );

$site_align = scm_field( 'select_alignment_site', 'center', 'option' );

$page_id = scm_field( 'id_page', 'site-page', 'option' );
$page_class = scm_field( 'select_layout_page', 'full', 'option' ) . ' float-' . $site_align . ' site-page hfeed site';

$fade_in = scm_field( 'fade_in', 0, 'option' );
$fade_out = scm_field( 'fade_out', 0, 'option' );
$fade_wait = scm_field( 'fade_wait', 'no', 'option' );

$smooth_duration = scm_field( 'tools_smoothscroll_duration', 0, 'option' );
$smooth_offset = scm_field( 'tools_smoothscroll_offset', 0, 'option' );
$smooth_ease = scm_field( 'select_ease_smoothscroll', 'swing', 'option' );
$smooth_delay = scm_field( 'tools_smoothscroll_delay', 0, 'option' );
$smooth_new = scm_field( 'tools_smoothscroll_delay_new', 0, 'option' );
$smooth_post = scm_field( 'tools_smoothscroll_where', 'all', 'option' );

$single_class = scm_field( 'tools_singlepagenav_activeclass', 'active', 'option' );
$single_interval = scm_field( 'tools_singlepagenav_interval', 1, 'option' );
$single_offset = scm_field( 'tools_singlepagenav_offset', 0, 'option' );
$single_threshold = scm_field( 'tools_singlepagenav_threshold', 0, 'option' );

$style_body = scm_options_get_style( get_queried_object_id(), 1, '_sc' );
$style_page = scm_options_get_style( get_queried_object_id(), 1, 'nobg' );

            
$head_id = scm_field( 'id_header', 'site-header', 'option' );
$head_row_id = $head_id . '-row';

$head_layout = ( scm_field( 'select_layout_page', 'full', 'option' ) === 'responsive' ? 'full' : scm_field( 'select_layout_head', 'full', 'option' ) );

$head_class = 'site-header full ' . $site_align;
$head_row_class = 'row scm-row ' . $head_layout . ' left';


$menu_position = scm_field( 'position_menu', 'inline', 'option' );
$menu_align = scm_field( 'select_alignment_menu', 'right', 'option' );

$follow_position = scm_field( 'position_social_follow', 'top', 'option' );

$cont_id = scm_field( 'id_content', 'site-content', 'option' );
$cont_layout = ( scm_field( 'select_layout_page', 'full', 'option' ) === 'responsive' ? 'full' : scm_field( 'select_layout_content', 'full', 'option' ) );
$cont_class = 'site-content full';

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
    <?php echo $style_body; ?>
>

<?php


// Page Wrapper
indent( 1, '<div id="' . $page_id . '" class="' . $page_class . '">', 2 );

    // Skip to Content Link
    indent( 2, '<a class="skip-link screen-reader-text" href="#' . $cont_id . '">' . $skip . '</a>', 2 );

    // Head
    indent( 2, '<header id="' . $head_id . '" class="' . $head_class . '" role="banner"
                    data-current-link="' . $single_class . '"
                    data-current-link-interval="' . $single_interval . '"
                    data-current-link-offset="' . $single_offset . '"
                    data-current-link-threshold="' . $single_threshold . '"
                >', 2 );

        // Menu above head
    if ( $menu_position == 'top' )
        scm_main_menu( $menu_align, $menu_position, 2 );

        // Menu row
        indent( 3, '<div id="' . $head_row_id . '" class="' . $head_row_class . '">', 2 );
    
            // Logo
            scm_logo( 4 );

            // Menu Inline above Social Menu
        if ( $menu_position == 'inline' && $follow_position == 'bottom' )
            scm_main_menu( $menu_align, $menu_position, 4 );

            // Social Menu
            scm_social_follow( 4 );

            // Menu Inline under Social Menu
        if ( $menu_position == 'inline' && $follow_position == 'top' )
            scm_main_menu( $menu_align, $menu_position, 4 );

        echo lbreak();
        indent( 3, '</div><!-- #site-header-row -->', 2 );

        // Menu under head
    if ( $menu_position == 'bottom' )
        scm_main_menu( $menu_align, $menu_position, 3 );

    indent( 2, '</header><!-- #site-header -->', 2 );
    
    // Content
    indent( 2, '<div id="' . $cont_id . '" class="' . $cont_class . '">', 2 );
        
        indent( 3, '<div id="primary" class="content-area">' );
            indent( 4, '<main id="main" class="site-main" role="main">', 2 );

?>