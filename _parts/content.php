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

// CHECK PAGE TYPE ------------------------------------------------------------------------

global $SCM_indent, $SCM_types, $post;

// If no page supplied (index.php) - Load Home Page
if( is_null( $post ) ){
	$post = get_post( get_option('page_on_front') );
	setup_postdata( $post );
}

$template = 'page';
$type = get_post_type();
$single = is_single();
$archive = is_archive();
$page = 0;
$part = '';

// Is Single or Archive
if( $single || $archive ){
	// IF Post Type not public - Load Home Page
	if( is_null( getByKey( $SCM_types['public'], $type ) ) ){
		get_template_part( SCM_DIR_PARTS, 'none' );
	}else{
		
		if( $single ){
			$page = get_page_by_path( '_single-' . $type );
			$part = SCM_DIR_PARTS_SINGLE;
		}elseif( $archive ){
			$page = get_page_by_path( '_archive-' . $type );
			$part = SCM_DIR_PARTS_ARCHIVE;
		}
		// If a template file '_parts/single/single-{post_type}.php' | '_parts/archive/archive-{post_type}.php' exists
		if( locate_template( $part . '-' . $type . '.php' ) ){
			$template = 'part';
		// If query arg ?template=XXX exists
		}elseif( !$page ){
			$template = SCM_PAGE_TEMPLATE;
			// IF Template not exists - Load Home Page
			// ++todo: 	se non esiste il template dovresti aver pronte delle parts per i type di default
			// 			e per i custom type tirar fuori almeno titolo, content e featured image (torna a quelli WP) ed eventuale link oggetto
			if( !$template ){
				get_template_part( SCM_DIR_PARTS, 'none' );
			}
		}
	}
}

// REDIRECT OLD BROWSER ------------------------------------------------------------------------

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

// CONSTANTS ------------------------------------------------------------


define( 'SCM_PAGE_ID',			    ( $page ? $page->ID : get_the_ID() ) );
define( 'SCM_PAGE_EDIT',			( scm_field( 'page-form', false ) ? ( is_user_logged_in() && SCM_LEVEL_EDIT ? ( get_query_var( 'action' ) != 'view' ? get_query_var( 'action' ) == 'edit' || get_option( 'scm-settings-edit-' . SCM_ID ) : 0 ) : 0 ) : 0 ) );
define( 'SCM_PAGE_TEMPLATE',		get_query_var( 'template', 0 ) );
define( 'SCM_SITE_ALIGN',			scm_field( 'layout-alignment', 'center', 'option' ) );

if( SCM_PAGE_EDIT )
	scm_hook_admin_ui_edit_mode();
else
	scm_hook_admin_ui_view_mode();


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
		get_template_part( $part, $type );
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
