<?php

/**
 * Front end : <head> <body> <page> <header> -> containers
 *
 * @package SCM
 */

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
        if( get_browser_version() <= (int)get_field( 'ie_version', 'option' ) ) :
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
<!--[if lte IE <?php echo (int)get_field('ie_version', 'option'); ?>]>
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

$site_align = ( get_field( 'select_alignment_site', 'option' ) ?: 'center' );

$page_id = ( get_field( 'id_page', 'option' ) ?: 'site-page' );
$page_class = ( get_field('select_layout_page', 'option') ?: 'full' ) . ' float-' . $site_align . ' site-page hfeed site';

$fade_in = ( get_field( 'fade_in', 'option' ) ?: 0 );
$fade_out = ( get_field( 'fade_out', 'option' ) ?: 0 );
$fade_wait = ( get_field( 'fade_wait', 'option' ) ?: 'no' );

$smooth_duration = ( get_field( 'tools_smoothscroll_duration', 'option' ) ?: 0 );
$smooth_offset = ( get_field( 'tools_smoothscroll_offset', 'option' ) ?: 0 );
$smooth_ease = ( get_field( 'select_ease_smoothscroll', 'option' ) ?: 'swing' );
$smooth_delay = ( get_field( 'tools_smoothscroll_delay', 'option' ) ?: 0 );
$smooth_new = ( get_field( 'tools_smoothscroll_delay_new', 'option' ) ?: 0 );
$smooth_post = ( get_field( 'tools_smoothscroll_where', 'option' ) ?: 'all' );

$single_class = ( get_field( 'tools_singlepagenav_activeclass', 'option' ) ?: 'active' );
$single_interval = ( get_field( 'tools_singlepagenav_interval', 'option' ) ?: 1 );
$single_offset = ( get_field( 'tools_singlepagenav_offset', 'option' ) ?: 0 );
$single_threshold = ( get_field( 'tools_singlepagenav_threshold', 'option' ) ?: 0 );

$style_body = scm_options_get_style( get_queried_object_id(), 1, '_sc' );
$style_page = scm_options_get_style( get_queried_object_id(), 1, 'nobg' );

            
$head_id = ( get_field( 'id_header', 'option' ) ? get_field( 'id_header', 'option' ) : 'site-header' );
$head_row_id = $head_id . '-row';

$head_layout = ( get_field('select_layout_page', 'option') != 'responsive' ? ( get_field('select_layout_head', 'option') ?: 'full' ) : 'full' );

$head_class = 'site-header full';
$head_row_class = 'row ' . $head_layout . ' float-' . $site_align . ' left row scm-row';


$menu_position = ( get_field( 'position_menu', 'option' ) ? get_field( 'position_menu', 'option' ) : 'inline' );
$menu_align = ( get_field( 'select_alignment_menu', 'option' ) ? get_field( 'select_alignment_menu', 'option' ) : 'right' );

$follow_position = ( get_field('position_social_follow', 'option') ? get_field('position_social_follow', 'option') : 'top' );

$cont_id = ( get_field( 'id_content', 'option' ) ?: 'site-content' );
$cont_layout = ( get_field('select_layout_page', 'option') != 'responsive' ? ( get_field('select_layout_content', 'option') ?: 'full' ) : 'full' );
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
    indent( 2, '<header id="' . $head_id . '" class="' . $head_class . '" role="banner">', 2 );

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
            indent( 4, '<main id="main" class="site-main" role="main"
                            data-single-class="' . $single_class . '"
                            data-single-interval="' . $single_interval . '"
                            data-single-offset="' . $single_offset . '"
                            data-single-threshold="' . $single_threshold . '"
                        >', 2 );

?>