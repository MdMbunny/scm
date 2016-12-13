<?php

/**
* SCM front init.
*
* @link http://www.studiocreativo-m.it
*
* @package SCM
* @subpackage 4-Init/Front
* @since 1.0.0
*/

// ------------------------------------------------------
//
// ------------------------------------------------------


/**
* [SET] Init Front End
*
* @subpackage 4-Init/Front
*/
function scm_front_init() {

    global $SCM_indent, $SCM_types, $SCM_agent, $post;

    // REDIRECT OLD BROWSER ------------------------------------------------------------------------

    $ver = ( $SCM_agent['browser']['ver'] && $SCM_agent['browser']['ver'] != 'unknown' ?: 1000 );
    $slug = $SCM_agent['browser']['slug'];

    if( ( $slug == 'ie' && $ver < (int)scm_field( 'opt-ie-version', '10', 'option' )) ||
        ( $slug == 'safari' && $ver < (int)scm_field( 'opt-safari-version', '7', 'option' )) ||
        ( $slug == 'firefox' && $ver < (int)scm_field( 'opt-firefox-version', '38', 'option' )) ||
        ( $slug == 'chrome' && $ver < (int)scm_field( 'opt-chrome-version', '43', 'option' )) ||
        ( $slug == 'opera' && $ver < (int)scm_field( 'opt-opera-version', '23', 'option' )) ) {

        get_template_part( SCM_DIR_PARTS, 'old' );
        die();
    }

    // REDIRECT index.php ------------------------------------------------------------------------

    if( is_null( $post ) ){
        $post = get_post( get_option('page_on_front') );
        setup_postdata( $post );
    }

    // INIT ------------------------------------------------------------------------

    $template = 'page';
    $type = get_post_type();
    $single = is_single();
    $archive = is_archive();
    $page = 0;
    $part = '';

    // INIT SINGLE or ARCHIVE ------------------------------------------------------------------------

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
                $template = get_query_var( 'template', 0 );
                
                // IF {$type}-templates exists - Pick up the first template from the list
                if( !$template ){

                    $template = scm_field( $type . '-templates', '', 'option' );
                    
                    if( !empty( $template ) )
                        $template = (int)$template[0]['id'];
                    
                    // IF Template not exists - Load Home Page
                    if( empty( $template ) )
                        get_template_part( SCM_DIR_PARTS, 'none' );
                }
            }
        }
    }

    // INIT CONSTANTS ------------------------------------------------------------

    define( 'SCM_PAGE_ID',              ( $page ? $page->ID : get_the_ID() ) );
    define( 'SCM_PAGE_EDIT',            ( scm_field( 'page-form', false ) ? ( is_user_logged_in() && SCM_LEVEL_EDIT ? ( get_query_var( 'action' ) != 'view' ? get_query_var( 'action' ) == 'edit' || get_option( 'scm-settings-edit-' . SCM_ID ) : 0 ) : 0 ) : 0 ) );
    define( 'SCM_SITE_ALIGN',           scm_field( 'layout-alignment', 'center', 'option' ) );

    if( SCM_PAGE_EDIT )
        scm_hook_admin_ui_edit_mode();
    else
        scm_hook_admin_ui_view_mode();

    return array( 'template'=>$template, 'part'=>$part, 'type'=>$type );
}

?>