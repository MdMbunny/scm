<?php

/**
 * content.php
 *
 * Part content.
 *
 * @link http://www.studiocreativo-m.it
 *
 * @package SCM
 * @subpackage Parts
 * @since 1.0.0
 */

global $SCM_indent, $SCM_types;

$template = 'page';

$type = get_post_type();
$single = is_single();
$archive = is_archive();
$notpage = 0;
$page = 0;
$temp = '';

if( $single ){
	$notpage = 1;
	$page = get_page_by_path( '_single-' . $type );
	$temp = SCM_DIR_PARTS_SINGLE;
}elseif( $archive ){
	$notpage = 1;
	$page = get_page_by_path( '_archive-' . $type );
	$temp = SCM_DIR_PARTS_ARCHIVE;
}

// CONSTANTS ------------------------------------------------------------

define( 'SCM_PAGE_ID',			    ( $page ? $page->ID() : get_the_ID() ) );
define( 'SCM_PAGE_FORM',			scm_field( 'page-form', false ) );
define( 'SCM_SITE_ALIGN',			scm_field( 'layout-alignment', 'center', 'option' ) );


// IF OLD BROWSER ------------------------------------------------------------------------

if( function_exists( 'get_browser_version' ) ){

    $version = ( (int)get_browser_version() ?: 1000 );

    if( (is_ie() && $version < (int)scm_field( 'opt-ie-version', '10', 'option' )) ||
        (is_safari() && $version < (int)scm_field( 'opt-safari-version', '7', 'option' )) ||
        (is_firefox() && $version < (int)scm_field( 'opt-firefox-version', '38', 'option' )) ||
        (is_chrome() && $version < (int)scm_field( 'opt-chrome-version', '43', 'option' )) ||
        (is_opera() && $version < (int)scm_field( 'opt-opera-version', '23', 'option' )) ) {

        get_template_part( SCM_DIR_PARTS, 'old' );
        die();
    }
}

// IF not PAGE ---------------------------------------------------------------------------------

if( $notpage ){

// If Type is not Public
	if( is_null( getByKey( $SCM_types['public'], $type ) ) )
		get_template_part( SCM_DIR_PARTS, 'none' ); // (back to home) 
	
// If a Page named '_single-{post_type}' | '_archive-{post_type}' exists
	//if( $page ){
		//SCM_PAGE_ID = $SCM_page_id = $page->ID;

// If a template file '_parts/single/single-{post_type}.php' | '_parts/archive/archive-{post_type}.php' exists
	if( locate_template( $temp . '-' . $type . '.php' ) ){
		$template = 'part';

// If query arg ?template=XXX exists
	}elseif( !$page ){
		$template = get_query_var( 'template', 0 );
		// ++todo: 	se non esiste il template dovresti aver pronte delle parts per i type di default
		// 			e per i custom type tirar fuori almeno titolo, content e featured image (torna a quelli WP) ed eventuale link oggetto
		if( !$template )
			get_template_part( SCM_DIR_PARTS, 'none' ); // (back to home)
	}
}

// Build Contents ---------------------------------------------------------------------------------------------



// Header
get_header();

switch ($template) {

// Content from Page, _Single Page or _Archive Page
	case 'page':
		scm_content( get_fields( SCM_PAGE_ID ) );
		break;

// Content from Single Part or Archive Part
	case 'part':
		get_template_part( $temp, $type );
		break;

// Content from Template
	default:
		indent( $SCM_indent + 1, '<div id="post-' . SCM_PAGE_ID . '" class="section scm-section object scm-object single-post full ' . SCM_SITE_ALIGN . '">', 2 );
			indent( $SCM_indent + 2, '<div class="row scm-row object scm-object responsive ' . scm_utils_style_get( 'align', 'option', 0 ) . '">', 2 );
				$SCM_indent += 3;
				scm_contents( array( 'acf_fc_layout' => 'layout-' . str_replace( '-', '_', $type ), 'template' => $template, 'type' => 'single', 'single' => array( SCM_PAGE_ID ) ) );
				$SCM_indent -= 3;
			indent( $SCM_indent + 2, '</div><!-- row -->', 2 );
		indent( $SCM_indent + 1, '</div><!-- section -->', 2 );
	break;

}

// Footer
get_footer();

?>
