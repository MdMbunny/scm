<?php

/**
 * SCM WPDB utilities.
 *
 * @link http://www.studiocreativo-m.it
 *
 * @package SCM
 * @subpackage 1-Utilities
 * @since 1.0.0
 */

// ------------------------------------------------------
//
// 0.0 
//
// ------------------------------------------------------

// ------------------------------------------------------
// 0.0
// ------------------------------------------------------

/**
 * [SET] Set $wpdb to external database
 *
 * @subpackage 1-Utilities/WPDB
 *
 * @param {string=} db Database Table name (default is '').
 * @param {string=} prefix Optional database prefix (default is 'wp_').
 * @param {string=} user Optional database user (default is 'root').
 * @param {string=} password Optional database password (default is 'root').
 * @param {string=} host Optional database host (default is 'localhost').
 * @return {NULL|wpdb} NULL or new wpdb.
 */
function newWPDB( $db = '', $prefix = 'wp_', $user = 'root', $password = 'root', $host = 'localhost' ){
    if( !$db ) return NULL;

    global $wpdb;
    $wpdb_backup = $wpdb;
    $wpdb = new wpdb( $user, $password, $db, $host );
    $wpdb->set_prefix( $prefix );
    $wpdb->show_errors();

    return $wpdb_backup;

}

/**
 * [SET] Set $wpdb to database
 *
 * @subpackage 1-Utilities/WPDB
 *
 * @param {wpdb=} db Wordpress Database (default is NULL).
 */
function setWPDB( $db = NULL ){
    if( is_null( $db ) || !$db ) return;
    global $wpdb;
    $wpdb = $db;
}

function wpdbInsertPosts( $posts = array(), $option = '', $debug = -1 ){

    $new_posts = array();
    $options = get_option( $option, array() );

    if( $debug == -1 ){

        foreach ( $posts as $id => $post ) {

            $new_post = wpdbInsertPost( $post );
            if( $new_post )
                $new_posts[$id] = $new_post;
        }
    }else{
        $new_post = wpdbInsertPost( $posts[$debug] );
        if( $new_post )
            $new_posts[$debug] = $new_post;
    }

    update_option( $option, $options + $new_posts );
    return $new_posts;
}

function wpdbInsertPost( $post = NULL ){

    if( is_null( $post ) ) return;


    if( !postExists( $post['post_name'], $post['post_type'] ) ){
        $att_post = array();
        $tax_post = array();
        if( $post['meta_input'] ){
            foreach ($post['meta_input'] as $k => $v) {
                if( ($v instanceof WP_Post && $v->post_type == 'attachment') || (is_array( $v ) && $v[0] instanceof WP_Post && $v[0]->post_type == 'attachment') ){
                    $att_post[ $k ] = $v;
                    $post['meta_input'][$k] = '';
                }
            }
        }

        if( $post['tax_input'] ){
            foreach( $post['tax_input'] as $tax => $terms ) {
                for ($i=0; $i < sizeof($terms); $i++) {
                    $name = $terms[$i];
                    if( is_string( $terms[$i] ) ){
                        $term = term_exists( sanitize_title($name), $tax );
                        if( $term ){
                            $post['tax_input'][$tax][$i] = $term;
                        }elseif( $name ){
                            $temp = wp_insert_term( $name, $tax );
                            $post['tax_input'][$tax][$i] = $temp['term_id'];
                        }
                    }
                    if( $post['meta_input'] ){
                        foreach ($post['meta_input'] as $field => $value) {
                            if( endsWith( $field, $tax . '-terms' ) ){
                                $ind = getByValue( $value, $name );
                                if( !is_null($ind) )
                                    $post['meta_input'][$field][$ind] = $post['tax_input'][$tax][$i];
                            }
                        }
                    }
                }
            }
        }

        $new_post = wp_insert_post( $post );

        if( sizeof( $att_post ) ){
            
            foreach ($att_post as $key => $value) {
                if( !is_array($value) ){
                    update_field( $key, attachmentFromURL( $value->guid, $new_post, true ), $new_post );
                }else{
                    $arr = array();
                    foreach ($value as $att)
                        $arr[] = attachmentFromURL( $att->guid, $new_post, true );
                    
                    update_field( $key, $arr, $new_post );
                }
            }                    
        }

        return $new_post;

    }else{

        consoleLog( $post['post_name'] . ' -> already exists in [' . $post['post_type'] . ']' );
        return;
    }    
}

/**
 * [GET] Get Custom Posts from $wpdb
 *
 * @subpackage 1-Utilities/WPDB
 *
 * @param {string=} type Custom Post Type (default is '').
 * @return {array} Query posts list.
 */
function wpdbCustomPosts( $type = '' ){
    if( !$type ) return $array();
    
    $args = array(
        'post_type' => $type,
        'posts_per_page' => -1,
    );
    $posts = new WP_Query( $args );
    return $posts->posts;
}

/**
 * [GET] Get Attachments from $wpdb
 *
 * @subpackage 1-Utilities/WPDB
 *
 * @return {array} Query posts list.
 */
function wpdbAttachments(){
    $arr = array();
    $args = array(
        'post_status' => 'any',
        'post_type' => 'attachment',
        'posts_per_page' => -1,
    );
    $posts = new WP_Query( $args );
    foreach( $posts->posts as $post ){
        $arr[ $post->ID ] = $post;
    }
    return $arr;
}

function wpdbNewCustomPosts( $old = '', $new = '', $attachments = array(), $fields = array(), $taxes = array() ){

    $new_posts = array();

    if( !$old || !$new ) return $new_posts;

    $old_posts = wpdbCustomPosts( $old );
    foreach ( $old_posts as $post) {

        $new_post = array(
            'post_type' => $new,
            'post_status' => $post->post_status,
            'post_title' => $post->post_title,
            'post_name' => sanitize_title( $post->post_title ),
            'post_date' => $post->post_date,
            'post_date_gmt' => $post->post_date_gmt,
            'post_modified' => $post->post_modified,
            'post_modified_gmt' => $post->post_modified_gmt,
            'post_content' => $post->post_content,
            'post_content_filtered' => $post->post_content_filtered,
            'post_excerpt' => $post->post_excerpt,
            'post_password' => $post->post_password,
            'post_parent' => $post->post_parent,
            'post_mime_type' => $post->post_mime_type,
            'menu_order' => $post->menu_order,
            'comment_status' => 'closed',
            'ping_status' => $post->ping_status,
            'pinged' => $post->pinged,
            'to_ping' => $post->post_content,
            'tax_input' => array(),
        );

        if( $taxes && is_array($taxes) && !empty($taxes) ){

            foreach( $taxes as $key => $value ){
                if( !is_list( $value ) || !sizeof( $value ) > 1 || !is_string($value[0]) || !is_array( $value[1] ) )
                    continue;
                $new_post = wpdbTaxonomy( $post, $new_post, $key, $value[0], $value[1] );
            }
        }

        $new_post['meta_input'] = array();
        if( $fields && !empty( $fields ) ){
            foreach ($fields as $key => $value) {
                
                $fld = $opt = $temp = '';
                if( is_array( $value ) && isset( $value[1] ) && is_string( $value[1] ) ){

                    $fld = $value[0];
                    $opt = $value[1];

                    if( startsWith( $opt, '_import-' ) ){
                        
                        switch ($opt) {
                            case '_import-date':
                                $temp = strtolower( get_post_meta( $post->ID, $fld, true ) );
                                if( $temp && !is_numeric( substr( $temp, 1 ) ) )
                                    $temp = '01 ' . $temp;
                            break;
                            case '_import-tolow':
                                $temp = strtolower( get_post_meta( $post->ID, $fld, true ) );
                            break;

                            case '_import-terms':
                                if( ex_attr( $new_post['tax_input'], $fld ) )
                                    $temp = $new_post['tax_input'][$fld];
                            break;

                            case '_import-gallery':
                                $temp = get_post_meta( $post->ID, $fld, true );
                                //$temp = get_field( $fld, $post->ID );
                                
                                if( $attachments && !empty($attachments) ){
                                    $atts = array();
                                    foreach ( $temp as $v ) {
                                     if( (int)$v )
                                        $atts[] = $attachments[(int)$v];
                                    }
                                    $temp = $atts;
                                }
                            break;
                            
                            case '_import-attachment':
                            default:
                                $temp = get_post_meta( $post->ID, $fld, true );
                                //$temp = get_field( $fld, $post->ID );
                                if( $attachments && !empty($attachments) && (int)$temp )
                                    $temp = $attachments[(int)$temp];
                            break;
                        }
                    }elseif( startsWith( $opt, '_set' ) ){
                        $temp = $fld;
                        if( startsWith( $opt, '_set-' ) )
                            $new_post['tax_input'][ str_replace( '_set-', '', $opt) ] = $fld;
                    }

                }elseif( $value ){
                    $temp = get_post_meta( $post->ID, $value, true );
                    //$temp = get_field( $value, $post->ID );
                }                

                $new_post['meta_input'][$key] = $temp;                
            }  
        }

        $new_posts[$post->ID] = $new_post;
    }

    return $new_posts;
}

function wpdbTaxonomy( $post, $args = array(), $old = '', $new_tax = '', $terms = array() ){
    if( empty( $args ) ) return $args;

    $new_terms = array();
    if( $new_tax && $old && $terms && !empty( $terms ) ){
        
        $old_terms = get_post_meta( $post->ID, $old, true );

        $old_terms = ( $old_terms && is_array( $old_terms ) ? $old_terms : array( $old_terms ) );
        foreach( $terms as $key => $value ) {
            foreach ($old_terms as $t) {
                if( !$t ) continue(1);
                $t = ( is_numeric($t) ? (int)$t : $t );
                if( is_string( $t ) ){
                    $term = ex_attr( $value, sanitize_title( $t ) );
                    if( $term ){
                        $new_terms[] = $term;
                        continue(1);
                    }else{
                        $new_terms[] = $t;
                        continue(1);
                    }
                }
                if( $key === (int)$t ){
                    $new_terms[] = $value;
                    continue(1);
                }
            }
        }
    }

    if( !ex_attr( $args, 'tax_input' ) )
        $args['tax_input'] = array();

    $args['tax_input'][$new_tax] = $new_terms;
    return $args;
} 

/**
 * [SET] Imports file from URL as new Attachment. Optionally attaches it to an existent Post
 *
 * @subpackage 1-Utilities/WP
 *
 * @param {string=} path Path to File (default is '').
 * @param {int=} postid Optional Post ID to link to the new Attachment (default is 0).
 * @param {bool=} echo Echo File and Attachment data (default is false).
 * @return {int} New Attachment ID or 0.
 */
function attachmentFromURL( $path = '', $postid = 0, $echo = false ) {

    $attachment_id = 0;
    
    if( !$path ) return $attachment_id;

    $new_post = get_post( $postid );
    
    if( !empty( $new_post ) ){
        global $post;
        $post = $new_post;
        setup_postdata( $post );
    }

    $filename = basename($path);

    if( $echo ) echo 'File Name: ' . $filename;

    $upload_file = wp_upload_bits($filename, null, file_get_contents($path));
    if (!$upload_file['error']) {
        $wp_filetype = wp_check_filetype($filename, null );
        
        if( $echo ) echo ' > File Type: ' . $wp_filetype['type'] . lbreak();
        
        $attachment = array(
            'post_mime_type' => $wp_filetype['type'],
            'post_parent' => $postid,
            'post_title' => preg_replace('/\.[^.]+$/', '', $filename),
            'post_content' => '',
            'post_status' => 'inherit'
        );
        
        if( $echo ) echo ' > Attachment Path: ' . $upload_file['file'] . lbreak();
        
        $attachment_id = wp_insert_attachment( $attachment, $upload_file['file'], $postid );
        
        if( $echo ) echo ' > Attachment ID: ' . $attachment_id . lbreak();
        
        if ( !is_wp_error( $attachment_id ) ) {
            require_once( ABSPATH . 'wp-admin/includes/image.php' );
            $attachment_data = wp_generate_attachment_metadata( $attachment_id, $upload_file['file'] );
            wp_update_attachment_metadata( $attachment_id, $attachment_data );
        }else{
            $attachment_id = 0;
        }
    }

    if( $echo ) echo '<br>';

    wp_reset_postdata();

    return $attachment_id;

}

?>