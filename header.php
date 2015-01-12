<?php
/**
 * The header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package SCM
 */

/*if ( !is_plugin_active( 'advanced-custom-fields-pro/acf.php' ) ) {
  return;
}*/


global $is_opera, $is_IE;

$opera      = ( $is_opera ) ? ( ' browser-opera' ) : ( '' );
$protocol   = ( is_ssl() ) ? ( 'https' ) : ( 'http' );


?><!DOCTYPE html>

<?php if ( $is_IE ) : ?>

    <!--[if lte IE 7]> <html class="ie ie7 lie8 lie7 no-js" <?php language_attributes(); ?>> <![endif]-->
    <!--[if IE 8]>     <html class="ie ie8 lie8 no-js" <?php language_attributes(); ?>> <![endif]-->
    <!--[if IE 9]>     <html class="ie ie9 no-js" <?php language_attributes(); ?>> <![endif]-->
    <!--[if gt IE 9]><!--><html class="no-js<?php echo $opera; ?>" <?php language_attributes(); ?>><!--<![endif]-->

<?php else : ?>

    <html class="scm" <?php language_attributes(); ?>>

<?php endif; ?>

<head>

<meta charset="<?php bloginfo( 'charset' ); ?>">

<title><?php echo wp_title(' &#124; ', true, 'right') ?></title>

<meta name="author" content="Studio Creativo M - www.studiocreativo-m.it'" />
<meta name="DC.creator" content="Studio Creativo M - www.studiocreativo-m.it" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />

<?php if ( $is_IE ) : ?>

    <?php /* REDIRECT TO _assets/html/old_ie.html IF IE < scm-settings-general['browser-version'] */ ?>

    <!--[if lte IE <?php echo get_field('ie_version', 'option'); ?>]>
    <meta http-equiv="refresh" content="0;url=<?php echo SCM_DIR_ASSETS . 'html/old_ie.html'; ?>" />
    <![endif]-->

    <?php /* HTML5 SUPPORT IF IE < 9 */ ?>

    <!--[if lt IE 9]>
    <script src="<?php echo $protocol; ?>://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
    <script>window.html5 || document.write('<script src="<?php echo SCM_URI_JS; ?>html5.js"><\/script>')</script>
    <script src="<?php echo $protocol; ?>://css3-mediaqueries-js.googlecode.com/svn/trunk/css3-mediaqueries.js"></script>
    <![endif]-->

<?php endif; ?>

<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />

<?php wp_head(); ?><!-- WP Header Hook -->

</head>

<?php

$site_align = ( get_field( 'select_alignment_site', 'option' ) ? get_field( 'select_alignment_site', 'option' ) : 'center' );

$page_id = ( get_field( 'id_page', 'option' ) ? get_field( 'id_page', 'option' ) : 'site-page' );
$page_class = ( get_field('select_layout_page', 'option') ? get_field('select_layout_page', 'option') : 'full' ) . ' float-' . $site_align . ' site-page hfeed site';


?>

    <body <?php body_class(); ?>>
    <div id="<?php echo $page_id; ?>" class="<?php echo $page_class; ?>">
        <a class="skip-link screen-reader-text" href="#site-content"><?php _e( "Skip to content", SCM_THEME ); ?></a>

        <?php
            
            $head_id = ( get_field( 'id_header', 'option' ) ? get_field( 'id_header', 'option' ) : 'site-header' );
            $head_row_id = $head_id . '-row';

            $head_layout = ( get_field('select_layout_page', 'option') != 'responsive' ? ( get_field('select_layout_head', 'option') ? get_field('select_layout_head', 'option') : 'full' ) : 'full' );

            $head_class = $site_align . ' site-header full';
            $head_row_class = $head_layout . ' left row scm-row';


            $menu_position = ( get_field( 'position_menu', 'option' ) ? get_field( 'position_menu', 'option' ) : 'inline' );
            $menu_align = ( get_field( 'select_alignment_menu', 'option' ) ? get_field( 'select_alignment_menu', 'option' ) : 'right' );

            $follow_position = ( get_field('position_social_follow', 'option') ? get_field('position_social_follow', 'option') : 'top' );

        ?>

        <header id="<?php echo $head_id; ?>" class="<?php echo $head_class; ?>" role="banner">

            <row id="<?php echo $head_row_id; ?>" class="<?php echo $head_row_class; ?>">

                    <?php 

                    if ( $menu_position == 'top' ) {

                        scm_main_menu( $menu_align, $menu_position );
                        scm_logo();
                        scm_social_follow();

                    }elseif ( $menu_position == 'bottom' ) {

                        scm_logo();
                        scm_social_follow();
                        scm_main_menu( $menu_align, $menu_position );

                    }elseif ( $menu_align == 'center' ) {

                        scm_logo( $menu_align );

                        if ( $follow_position == 'top' )
                            scm_social_follow( $menu_align );

                        scm_main_menu( $menu_align, $menu_position );

                        if ( $follow_position == 'bottom' )
                            scm_social_follow( $menu_align );

                    }else{

                        if ( $menu_align == 'right' )
                            scm_logo();

                        if ( $follow_position == 'top' )
                            scm_social_follow();

                        scm_main_menu( $menu_align, $menu_position );
                        
                        if ( $follow_position == 'bottom' )
                            scm_social_follow();
                        
                        if ( $menu_align == 'left' )
                            scm_logo();

                    }

                    scm_sticky_menu();

                    ?>



                </row><!-- #site-header-row -->

        </header><!-- #site-header -->

<?php

        $cont_id = ( get_field( 'id_content', 'option' ) ? get_field( 'id_content', 'option' ) : 'site-content' );
        $cont_class = 'site-content full';

?>

        <div id="<?php echo $cont_id; ?>" class="<?php echo $cont_class; ?>">
            
                <div id="primary" class="content-area">
                    <main id="main" class="site-main" role="main">
