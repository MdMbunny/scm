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

    $id = $post->ID;

    $template = 'page';
    $type = get_post_type();
    $single = is_single();
    $archive = is_archive();
    $istax = is_tax();
    $tax = get_query_var( 'taxonomy' );
    $term = get_query_var( 'term' );
    $term_obj = ( $term && $tax ? get_term_by( 'slug', $term, $tax ) : 0 );
    $page = 0;
    $part = '';
    $temp = '';
    $lang = '';

    if( function_exists( 'pll_current_language' ) ){
        $lang = ( pll_current_language() != pll_default_language() ? '-' . pll_current_language() : '' );
    }

    // INIT SINGLE or ARCHIVE or TAXONOMY ---------------------------------------------------------------------------------

    if( $single || $archive || $istax ){
        // IF Post Type not public - Load Home Page
        if( !$istax && is_null( getByKey( $SCM_types['public'], $type ) ) ){
            get_template_part( SCM_DIR_PARTS, 'none' );
        }else{
            
            if( $istax ){
                $page = get_page_by_path( '_tax-' . $tax . $lang );
                $part = SCM_DIR_PARTS_TAX;
                $temp = 'tax';
            }elseif( $single ){
                $page = get_page_by_path( '_single-' . $type . $lang );
                $part = SCM_DIR_PARTS_SINGLE;
                $temp = 'single';
            }elseif( $archive ){
                $page = get_page_by_path( '_archive-' . $type . $lang );
                $part = SCM_DIR_PARTS_ARCHIVE;
                $temp = 'archive';
            }
            // If a template file '_parts/single/single-{post_type}.php' | '_parts/archive/archive-{post_type}.php' exists
            if( !$istax && locate_template( $part . '-' . $type . '.php' ) ){
                $template = 'part';
                $page = 0;
            // If a template file '_parts/tax/tax-{taxonomy}.php' exists
            }elseif( locate_template( $part . '-' . $tax . '.php' ) ){
                $template = 'part-tax';
                $page = 0;
            // If query arg ?template=XXX exists
            }elseif( !$page ){
                
                $template = get_query_var( 'template', 0 );
                
                // IF {$type}-templates exists - Pick up the first template from the list
                //if( !$template ){

                $template = scm_utils_get_template_id( $type, $template, !$single );

                    /*$template = scm_field( $type . '-templates', '', 'option' );
                    
                    if( !empty( $template ) )
                        $template = (int)$template[0]['id'];*/
                    
                // IF Template not exists - Load Home Page
                if( !$template ){
                    if( function_exists( 'scm_echo_' . $type ) ){
                        $template = 'function';
                        $part = 'scm_echo_' . $type;
                    }else{
                        get_template_part( SCM_DIR_PARTS, 'none' );
                    }
                }

                    // Possibilmente se non ci sono Template, tira fuori Titolo e se esiste content/editor
                //}
            }

            if( $page ){
                $id = $page->ID;
            }elseif( $term_obj ){
                $id = $term_obj->term_taxonomy_id . '-' . $term_obj->term_id;
            }elseif( $temp == 'archive' ){
                $id = $type;
            }else{
                $id = get_the_ID();
            }
        }
    }

    // INIT USER -----------------------------------------------------------------

    

    // INIT CONSTANTS ------------------------------------------------------------

    define( 'SCM_PAGE_ID',              $id );
    //define( 'SCM_PAGE_EDIT',            ( scm_field( 'page-form', false ) ? ( is_user_logged_in() && SCM_LEVEL_EDIT ? ( get_query_var( 'action' ) != 'view' ? get_query_var( 'action' ) == 'edit' || get_option( 'scm-settings-edit-' . SCM_ID ) : 0 ) : 0 ) : 0 ) ); // ???
    define( 'SCM_SITE_ALIGN',           scm_field( 'layout-alignment', 'center', 'option' ) );

    define( 'SCM_ACTION', ( isset( $_GET['action'] ) ? $_GET['action'] : false ) );
    define( 'SCM_SUCCESS', ( isset( $_GET['success'] ) ? $_GET['success'] : false ) );
    define( 'SCM_FAILED', ( isset( $_GET['failed'] ) ? $_GET['failed'] : false ) );

    // ???
    /*if( SCM_PAGE_EDIT )
        scm_hook_admin_ui_edit_mode();
    else
        scm_hook_admin_ui_view_mode();*/

    return array( 'temp'=>$temp, 'template'=>$template, 'part'=>$part, 'type'=>$type, 'tax'=>$tax, 'term'=>$term, 'term_obj'=>$term_obj );
}

?>