<?php

/**
 * Front end : <head> <body> <page> <header> -> containers
 *
 * @package SCM
 */
//header("Access-Control-Allow-Origin: *");

global $SCM_protocol, $SCM_old, $SCM_ie9, $is_IE;

if( function_exists('get_browser_name') ){

    $version = ( (int)get_browser_version() ?: 1000 );

    if( (is_ie() && $version < (int)scm_field( 'opt-ie-version', '10', 'option' )) ||
        (is_safari() && $version < (int)scm_field( 'opt-safari-version', '7', 'option' )) ||
        (is_firefox() && $version < (int)scm_field( 'opt-firefox-version', '38', 'option' )) ||
        (is_chrome() && $version < (int)scm_field( 'opt-chrome-version', '43', 'option' )) ||
        (is_opera() && $version < (int)scm_field( 'opt-opera-version', '23', 'option' )) ) {

        $SCM_old = true;

    }elseif( is_ie() && get_browser_version() <= 9 ){

        $SCM_ie9 = true;
    }
}

if( $SCM_old ) :

    get_template_part( SCM_DIR_PARTS, 'old' );
    die();

endif;


?><!DOCTYPE html>

<html class="scm no-js" <?php language_attributes(); ?>>

<meta charset="<?php bloginfo( 'charset' ); ?>">

<meta name="DC.creator" content="Studio Creativo M - www.studiocreativo-m.it" />
<meta name="author" content="<?php bloginfo(); ?>'" />

<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />

<?php if( $SCM_ie9 ) : ?>

    <script src="<?php echo $SCM_protocol; ?>://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
    <script>window.html5 || document.write('<script src="<?php echo SCM_URI_JS; ?>html5.js"><\/script>')</script>
    <script src="<?php echo $SCM_protocol; ?>://css3-mediaqueries-js.googlecode.com/svn/trunk/css3-mediaqueries.js"></script>

<?php endif; ?>

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
$type = $post->post_type;

if( is_single() ){

    // If a Page named '_single-{post_type}' exists
    $page = get_page_by_path( '_single-' . $type );
    if( $page )
        $id = $page->ID;
}

$skip = __( "Vai al contenuto", SCM_THEME );

$site_align = scm_field( 'layout-alignment', 'center', 'option' );
$txt_align = scm_options_get( 'align', 'option', 0 );

$page_id = 'site-page';
$page_layout = scm_field( 'page-layout', scm_field( 'layout-page', 'full', 'option' ), $id );
$page_layout = ( $page_layout === 'full' ? 'full ' : 'responsive float-' );
$page_class = 'site-page hfeed site ' . $page_layout . $site_align;

$fade_in = scm_field( 'opt-tools-fade-in', 0, 'option' );
$fade_out = scm_field( 'opt-tools-fade-out', 0, 'option' );
$fade_wait = scm_field( 'opt-tools-fade-waitfor', 'no', 'option' );

$smooth_duration = scm_field( 'opt-tools-smoothscroll-duration', 0, 'option' );
$smooth_offset = scm_field( 'opt-tools-smoothscroll-offset', 0, 'option' );
$smooth_ease = scm_field( 'opt-tools-smoothscroll-ease', 'swing', 'option' );
$smooth_delay = scm_field( 'opt-tools-smoothscroll-delay', 0, 'option' );
$smooth_new = scm_field( 'opt-tools-smoothscroll-delay-new', 0, 'option' );
$smooth_post = scm_field( 'opt-tools-smoothscroll-page', 'on', 'option' );

$single_class = scm_field( 'opt-tools-singlepagenav-activeclass', 'active', 'option' );
$single_interval = scm_field( 'opt-tools-singlepagenav-interval', 1, 'option' );
$single_offset = scm_field( 'opt-tools-singlepagenav-offset', 0, 'option' );
$single_threshold = scm_field( 'opt-tools-singlepagenav-threshold', 0, 'option' );

$tofull = scm_field( 'layout-tofull', '', 'option' );
$tocolumn = scm_field( 'layout-tocolumn', '', 'option' );
            
$head_id = 'site-header';

$head_layout = scm_field( 'layout-head', 'full', 'option' );
$head_layout = ( $page_layout === 'responsive' ? 'full ' : ( $head_layout === 'full' ? 'full ' : 'responsive float-' ) );

$head_class = 'site-header full ' . $site_align;
$head_row_class = 'row scm-row object scm-object ' . $head_layout . $site_align;

$menu_position = scm_field( 'menu-position', 'inline', 'option' );
$menu_align = scm_field( 'menu-alignment', 'right', 'option' );

$follow_position = scm_field( 'follow-position', 'top', 'option' );

$cont_id = 'site-content';
$cont_layout = scm_field( 'layout-content', 'full', 'option' );
$cont_layout = ( $page_layout === 'responsive' ? 'full ' : ( $cont_layout === 'full' ? 'full ' : 'responsive float-' ) );
$cont_class = 'site-content ' . $cont_layout . $site_align ;
?>

<body <?php body_class(); ?> 
    onunload="" 
    data-fade-in="<?php echo $fade_in; ?>" 
    data-fade-out="<?php echo $fade_out; ?>" 
    data-fade-wait="<?php echo $fade_wait; ?>"
    data-smooth-duration="<?php echo $smooth_duration; ?>"
    data-smooth-offset="<?php echo $smooth_offset; ?>"
    data-smooth-ease="<?php echo $smooth_ease; ?>"
    data-smooth-delay="<?php echo $smooth_delay; ?>"
    data-smooth-new="<?php echo $smooth_new; ?>"
    data-smooth-post="<?php echo $smooth_post; ?>" 
    data-tofull="<?php echo $tofull; ?>" 
    data-tocolumn="<?php echo $tocolumn; ?>"
    <?php /*echo $style_body; echo lbreak();*/ ?>
>

<?php

// Page Wrapper
indent( $SCM_indent, '<div id="' . $page_id . '" class="' . $page_class . '"
            data-current-link="' . $single_class . '"
            data-current-link-interval="' . $single_interval . '"
            data-current-link-offset="' . $single_offset . '"
            data-current-link-threshold="' . $single_threshold . '" 
        >', 2 );
    
    $SCM_indent += 1;
    
    // Skip to Content Link
    indent( $SCM_indent, '<a class="skip-link screen-reader-text" href="#' . $cont_id . '">' . $skip . '</a>', 2 );

    // Head
    indent( $SCM_indent, '<header id="' . $head_id . '" class="' . $head_class . '" role="banner"
        >', 2 );


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
    
    // Content
    indent( $SCM_indent, '<div id="' . $cont_id . '" class="' . $cont_class . '">', 2 );

        $SCM_indent += 1;
        
        indent( $SCM_indent, '<div id="primary" class="content-area full">' );

            $SCM_indent += 1;
            
            indent( $SCM_indent, '<main id="main" class="site-main full" role="main">', 2 );

?>