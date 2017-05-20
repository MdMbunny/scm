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

function wpdbInsertLangs( $posts = array(), $language = array(), $update = false, $specific = array(), $debug = false ){

    $new_posts = array();
    $def = key( $language );
    $langs = current( $language );

    $defs = getAllByValueKey( $posts, $def, 'lang_input', true );
    $new_posts = wpdbInsertPosts( $defs, array(), $update, $specific, $debug );

    consoleLog( $def . ' (default)' );

    foreach ($langs as $lang) {
        if( $lang === $def ) continue;
        $trans = getAllByValueKey( $posts, $lang, 'lang_input', true );
        consoleLog($trans);
        $lang_posts = wpdbInsertPosts( $trans, $new_posts, $update, $specific, $debug );
        if( $debug ) consoleLog( $lang );
        $new_posts = array_merge( $new_posts, $lang_posts );
    }

    consoleLog( 'TOTAL POSTS: ' . sizeof( $new_posts ) );

    return $new_posts;
}

function wpdbInsertPosts( $posts = array(), $language = array(), $update = false, $specific = array(), $debug = false ){

    $new_posts = array();

    if( !$specific || is_array( $specific ) ){
        $specific = ( $specific ?: array() );
        $from = ( !ex_index( $specific, 1, 0 ) ? 0 : ex_index( $specific, 0, 0 ) );
        $to = ex_index( $specific, 1, sizeof( $posts ) );
        $posts = array_slice( $posts, $from, $to, true );

        foreach ( $posts as $id => $post ) {
            $new_post = wpdbInsertPost( $post, $language, $update, $debug );
            if( $new_post )
                $new_posts[$id] = $new_post;
        }
    }else{
        $new_post = wpdbInsertPost( $posts[$specific], $language, $update, $debug );
        if( $new_post )
            $new_posts[$specific] = $new_post;
    }

    if( $debug ) consoleLog( 'POSTS: ' . sizeof( $new_posts ) );

    return $new_posts;
}

function wpdbInsertPost( $post = NULL, $language = array(), $update = false, $debug = 0 ){

    if( is_null( $post ) ) return;

    $old = postBySlug( $post['post_name'], $post['post_type'] );

    $new_post = 0;
    $skip = $old && !$update;
    $update = $old && $update;
    $new = !$old;

    $save = !$skip && !$debug;
    
    $debug = max( 0, (int)$debug );

    if( $old ) $post['ID'] = $old->ID;
    else $post['ID'] = 0;

    consoleLog($post['ID']);

    if( $debug > 1 || $new ) consoleLog( $post['post_title'] );

    if( $update ) consoleLog( '--> [ UPDATING ] - ' . $post['post_status'] );
    elseif( $new ) consoleLog( '--> [ CREATING ] - ' . $post['post_status'] );
    elseif( $skip && $debug > 1 ) consoleLog( '--> [ ALREADY EXISTS ] - ' . $post['post_status'] );

    if( $debug || $save ){

        $att_post = array();
        $tax_post = array();
        $rep_post = array();
        $fld_post = array();
        $trm_post = array();
        if( $post['meta_input'] ){
            foreach ($post['meta_input'] as $k => $v) {

                if( endsWith( $k, '-terms' ) ){
                    $trm_post[ $k ] = $v;
                }elseif( wpdbIsAttachment( $v ) ){
                    $att_post[ $k ] = $v;
                }elseif( is_list( $v ) ){
                    $rep_post[ $k ] = $v;
                }else{
                    $fld_post[ $k ] = $v;
                }
                unset($post['meta_input'][$k]);
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
                    
                    foreach( $trm_post as $field => $value) {
                        if( endsWith( $field, $tax . '-terms' ) ){
                            $ind = getByValue( $value, $name );
                            if( !is_null($ind) )
                                $post['meta_input'][$field][$ind] = $post['tax_input'][$tax][$i];
                        }
                    }                    
                }

            }
            if( $debug ) consoleLog( $post['meta_input'] );
        }

        if( $save )
            $new_post = ( $update ? wp_update_post( $post ) : wp_insert_post( $post ) );
        else
            $new_post = $post['ID'];

        if( sizeof( $fld_post ) ){
            foreach( $fld_post as $fld => $val ){
                if( $save ) update_field( $fld, $val, $new_post );
            }
        }

        if( sizeof( $rep_post ) ){

            foreach( $rep_post as $rep => $rows ){
                
                if( $debug > 2 ) consoleLog( '- Updating Repeater' );

                $nrows = array();
                if( $save ) update_field( $rep, $nrows, $new_post );
                
                foreach( $rows as $row => $fields ){
                    
                    if( $debug > 3 ) consoleLog( '-- Row ' . $row );

                    $nfields = array();
                    
                    foreach( $fields as $key => $value ){

                        if( wpdbIsAttachment( $value ) )
                            $value = wpdbUpdateAttachments( $key, $value, $new_post, $debug );
                        
                        if( $debug > 3 ) consoleLog( array( $key, $value ) );
                        $nfields[$key] = $value;
                    }

                    $nrows[] = $nfields;
                }
                
                if( $save ) update_field( $rep, $nrows, $new_post );
            }
        }

        if( sizeof( $att_post ) ){
            
            foreach( $att_post as $key => $value ){
                
                $value = wpdbUpdateAttachments( $key, $value, $new_post, $debug );

                if( $debug > 2 ) consoleLog( '- Updating Attachment: ' . $value );
                if( $save ) update_field( $key, $value, $new_post );
            }
        }

        if( $post['lang_input'] ){

            if( $debug > 2 ) consoleLog( '- Updating Language: ' . $post['lang_input'] );
            if( $save ) pll_set_post_language( $new_post, $post['lang_input'] );

            if( $post['trans_input'] ){
                
                if( $debug > 2 ) consoleLog( '- Updating Translation: ' . $post['trans_input'] );
                if( $save ) {
                    if( !empty( $language ) ){
 
                        $def = ex_index( $language, $post['trans_input'] );
                        if( $def ){
                            $lang = array();
                            $lang[ pll_get_post_language( $def ) ] = $def;
                            $lang[ $post['lang_input'] ] = $new_post;
                            consoleLog( $lang );
                            pll_save_post_translations( $lang );
                        }else{
                            consoleLog( $post['trans_input'] . ' not in $language' );
                        }
                    }
                }
            }
        }
    }
    
    if( !$skip || $debug > 1 ) consoleLog( '---------' );
    
    if( $skip ) return 1;
    return $new_post;

}

function wpdbAttachments(){
    $arr = array();
    $posts = getPosts( 'attachment' );
    foreach( $posts as $post ){
        $arr[ $post->ID ] = $post;
    }
    return $arr;
}

function wpdbIsAttachment( $value = '' ){
    return ( $value instanceof WP_Post && $value->post_type == 'attachment' ) || ( is_list( $value ) && isset( $value[0] ) && $value[0] instanceof WP_Post && $value[0]->post_type == 'attachment' );
}

function wpdbUpdateAttachments( $key = '', $value = '', $new_post = 0, $debug = false ){

    if( !is_array($value) ){
        return attachmentFromURL( $value->guid, '', $new_post, false, $debug );
    }else{
        $arr = array();
        foreach ($value as $ind => $att)
            $arr[] = attachmentFromURL( $att->guid, '', $new_post, false, $debug );
        
        return $arr;
    }
}

function wpdbNewCustomPosts( $old = '', $new = '', $attachments = array(), $fields = array(), $taxes = array(), $language = array(), $keepslug = false ){

    $new_posts = array();

    if( !$old || !$new ) return $new_posts;

    $old_posts = getPosts( $old, 'publish' );
    foreach ( $old_posts as $post) {

        $new_post = array(
            'featured' => get_post_thumbnail_id( $post->ID ),
            'post_type' => $new,
            'post_status' => $post->post_status,
            'post_title' => $post->post_title,
            'post_name' => ( !$keepslug ? sanitize_title( $post->post_title ) : $post->post_name ),
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
            'lang_input' => '',
            'trans_input' => '',
            'old_id' => $post->ID,
        );

        if( $taxes && is_array($taxes) && !empty($taxes) ){

            foreach( $taxes as $key => $value ){
                if( !is_list( $value ) || !sizeof( $value ) > 1 || !is_string($value[0]) || !is_array( $value[1] ) )
                    continue;
                $new_post = wpdbTaxonomy( $post->ID, $new_post, $key, $value[0], $value[1] );
            }

        }

        if( !empty( $language ) ){
            $def = key( $language );
            $langs = current( $language );
            $lang = pll_get_post_language( $post->ID ) ?: $def;
            
            $new_post['lang_input'] = $def;
            $new_post['trans_input'] = 0;
            if( $lang != $def ){
                $new_post['lang_input'] = $lang;
                $trans = pll_get_post( $post->ID, $def );
                if( $trans ){
                    $new_post['trans_input'] = $trans;
                }
            }
        }

        $new_post['meta_input'] = wpdbGetFields( $new_post, $post->ID, $fields, $attachments, '', $new_post['tax_input'] );
        
        $new_posts[$post->ID] = $new_post;
    }

    return $new_posts;
}

function wpdbGetFields( $new_post = array(), $id = 0, $fields = array(), $attachments = array(), $prepend = '', &$tax = '' ){

    $arr = array();
    $tax_input = ex_attr( $new_post, 'tax_input', array() );
    if( $fields && !empty( $fields ) ){
        foreach ($fields as $key => $value) {
            
            $fld = $opt = $temp = '';
            if( is_array( $value ) && isset( $value[1] ) && is_string( $value[1] ) ){

                $fld = $prepend . ( ex_index( $value, 0, '' ) ?: '' );
                $opt = ex_index( $value, 1, '' );
                $rep = ( ex_index( $value, 2, '' ) ?: array() );

                if( startsWith( $opt, '_import-' ) ){
                    
                    switch ($opt) {

                        case '_import-date':
                            $temp = strtolower( get_post_meta( $id, $fld, true ) );
                            if( $temp && !is_numeric( substr( $temp, 1 ) ) )
                                $temp = '01 ' . $temp;
                        break;
                        case '_import-tolow':
                            $temp = strtolower( get_post_meta( $id, $fld, true ) );
                        break;

                        case '_import-terms':
                            if( ex_attr( $tax_input, $fld ) )
                                $temp = $tax_input[$fld];
                        break;

                        case '_import-gallery':
                            $temp = get_post_meta( $id, $fld, true );
                            
                            if( $attachments && !empty($attachments) ){
                                $atts = array();
                                foreach ( $temp as $v ) {
                                 if( (int)$v )
                                    $atts[] = $attachments[(int)$v];
                                }
                                $temp = $atts;
                            }
                        break;

                        case '_import-repeater':                                            
                            $temp = array();
                            for ($i=0; $i < (int)get_post_meta( $id, $fld, true ); $i++) {
                                $temp[] = wpdbGetFields( $new_post, $id, $rep, $attachments, $fld . '_' . $i . '_' );
                            }            
                        break;
                        
                        case '_import-attachment':
                        default:
                            if( $fld === '_featured' )
                                $temp = $new_post['featured'];
                            else
                                $temp = get_post_meta( $id, $fld, true );
                            if( $attachments && !empty($attachments) && (int)$temp )
                                $temp = $attachments[(int)$temp];
                        break;
                    }
                }elseif( startsWith( $opt, '_set' ) ){
                    $temp = $fld;
                    if( $tax && startsWith( $opt, '_set-' ) )
                        $tax[ str_replace( '_set-', '', $opt) ] = $fld;
                }

            }elseif( $value === '_content' ){
                $temp = $new_post['post_content'];
            }elseif( $value ){
                $temp = get_post_meta( $id, $prepend . $value, true );
            }                

            $arr[$key] = $temp;                
        }  
    }

    return $arr;
}

function wpdbTaxonomy( $post, $args = array(), $old = '', $new_tax = '', $terms = array() ){
    if( empty( $args ) ) return $args;

    $new_terms = array();
    if( $new_tax && $old && $terms && !empty( $terms ) ){
        
        global $wpdb;
        $querystr = "
            SELECT * FROM $wpdb->terms
            LEFT JOIN $wpdb->term_taxonomy
                ON( $wpdb->terms.term_id = $wpdb->term_taxonomy.term_id )
            LEFT JOIN $wpdb->term_relationships ON($wpdb->term_taxonomy.term_taxonomy_id = $wpdb->term_relationships.term_taxonomy_id)
            WHERE $wpdb->term_relationships.object_id = " . $post . "
            
        ";
        $old_terms = $wpdb->get_results($querystr, OBJECT);
        foreach( $terms as $key => $value ) {
            foreach ($old_terms as $t) {
                if( !$t || empty($t) || $t->taxonomy != $old ) continue(1);

                if( $key === $t->slug ){
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


?>