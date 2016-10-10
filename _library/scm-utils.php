<?php

/**
 * SCM utilities.
 *
 * @link http://www.studiocreativo-m.it
 *
 * @package SCM
 * @subpackage 1-Utilities
 * @since 1.0.0
 */

// ------------------------------------------------------
//
// X.X WPDB
// 0.0 WORDPRESS
// 1.0 DEBUG
// 2.0 MISC
// 3.0 STRING
// 4.0 ARRAY
// 5.0 HTML
// 6.0 STYLE
// 7.0 FILE
// 8.0 SVG
// 9.0 DATE and TIME
//
// ------------------------------------------------------

// ------------------------------------------------------
// X.X WPDB
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

// ------------------------------------------------------
// 0.0 WORDPRESS
// ------------------------------------------------------

/**
* Determine if a post exists based on post_name and post_type
*
* @param {string=} post_name Unique post name (defaults is ''). 
* @param {string=} post_type Post type (defaults is '').
*/
function postExists( $post_name = '', $post_type = '' ) {
    global $wpdb;

    $query = "SELECT ID FROM $wpdb->posts WHERE 1=1";
    $args = array();

    if ( $post_name ) {
         $query .= " AND post_name LIKE '%s' ";
         $args[] = $post_name;
    }
    if ( $post_type ) {
         $query .= " AND post_type = '%s' ";
         $args[] = $post_type;
    }

    if ( !empty ( $args ) )
         return $wpdb->get_var( $wpdb->prepare($query, $args) );

    return 0;
}

/**
 * [SET] Print javascript console messages
 *
 * @subpackage 1-Utilities/WP
 *
 * @param {misc} var Value to console.
 * @param {bool} deb Active console logging.
 */
function consoleDebug( $var, $deb = SCM_DEBUG ){
    if( $deb )
        consoleLog( $var );
}

/**
 * [GET] Combined multiple __( 'text', theme )
 *
 * @subpackage 1-Utilities/WP
 *
 * @param {string|array} var String or array of strings.
 * @param {string=} sep Separator (default is ' ').
 * @param {string=} theme Theme (default is SCM_THEME).
 * @return {string} Combined strings.
 */
function multiText( $var, $sep = ' ', $theme = SCM_THEME ){
    $txt = '';
    foreach ( toArray( $var ) as $wrd) {
        $txt .= __( $wrd, $theme ) . $sep;
    }
    return trim( $txt, $sep );
}

/**
* [GET] Post data from $_REQUEST or current post
*
* @subpackage 1-Utilities/WP
*
* @param {string} key Optional. Specific attribute.
* @return {array|misc} Post attributes array or specific attribute.
*/
function thePost( $key = NULL ){
    $the_post = array();
    $id = 0;
    $req = ( isset( $_REQUEST['post_id'] ) ? $_REQUEST['post_id'] : '' );
    if( $req ) $id = (int)$req;
    else $id = get_the_ID();

    if ( $id && is_numeric( $id ) ) {
        $the_post['id'] = $id;
        $the_post['post'] = get_post( $id );  
        $the_post['type'] = get_post_type( $id );
        $the_post['slug'] = $the_post['post']->post_name;
        $the_post['title'] = $the_post['post']->post_title;
        $the_post['taxonomy'] = get_query_var( 'taxonomy' );
        $the_post['term'] = get_query_var( 'term' );

        if( is_null( $key ) ) return $the_post;
        return $the_post[ $key ];
    }

    return NULL;
}

/**
 * [GET] Post type taxonomies exluding $taxes
 *
 * @subpackage 1-Utilities/WP
 *
 * @param {string} type Post type.
 * @param {array=} taxes Excluded taxonomies (default is ['language', 'post_translations']).
 * @return {array} List of taxonomies.
 */
function checkTaxes( $type, $taxes = array( 'language', 'post_translations' ) ) {
    if( !$type ) return array();
    return ( delArray( get_object_taxonomies( $type ), $taxes ) ?: array() );
}

/**
 * [GET] Get Taxonomy Terms IDs
 *
 * @subpackage 1-Utilities/WP
 *
 * @param {string} tax Taxonomy slug.
 * @return {array} List of IDs.
 */
function getTermsId( $tax = '' ) {
    $terms = get_terms( array(
        'taxonomy' => $tax,
        'hide_empty' => false,
    ) );
    $arr = array();
    foreach ($terms as $value) {
        $arr[ $value->slug ] = $value->term_id;
    }
    return $arr;
}

/**
 * [SET] Update, insert or delete post meta value
 *
 * @subpackage 1-Utilities/WP
 *
 * @param {int} id Post id.
 * @param {string} meta Post meta.
 * @param {misc=} value Post meta value for adding or updating, NULL for deleting (default is NULL).
 */
function updatePostMeta( $id, $meta, $value = NULL ){

    if ( is_null( $value ) )
        delete_post_meta( $id, $meta );
    elseif ( ! get_post_meta( $id, $meta ) )
        add_post_meta( $id, $meta, $value );
    else
        update_post_meta( $id, $meta, $value );
}

/**
 * [GET] Login Redirect
 *
 * @subpackage 1-Utilities/WP
 *
 * @param {string=} type Redirect type [page|admin|link] (default is 'page').
 * @param {int|string=} link URL, admin page URL, page ID (default is '').
 * @return {string} Filtered URL.
 */
function loginRedirect( $type = 'page', $link = '' ){
    if( $type == 'page' )
        return ( !$link ? getURL( 'page:' . SCM_PAGE_ID ) : ( is_int( $link ) || ( (int)$link > 1 ) ? getURL( 'page:' . $link ) : $link ) );
    elseif( $type == 'admin' )
        return ( $link ? site_url( '/wp-admin/' . $link ) : site_url('/wp-admin/users.php') );
    else
        return ( $link ?: site_url( '/wp-admin/users.php' ) );
}


/**
 * [GET] Filter URL
 *
 * @subpackage 1-Utilities/WP
 *
 * @param {string} url URL to be filtered.
 * @return {string} Filtered URL.
 */
function getURL( $url ){

    if( !$url ) return;

    $add = '';

    if( $url == 'localhost' )
        return 'http://localhost:8888/_scm';

    if( startsWith( $url, array( 'page:' ) ) !== false || startsWith( $url, array( 'page/' ) ) !== false || startsWith( $url, array( 'http://page/', 'https://page/' ) ) !== false ){

        $url = str_replace( array( 'page:', 'page/', 'http://', 'https://' ), '', $url );

        if( strpos( $url, '#' ) === 0 ){
            $add = $url;
            $url = str_replace( '#', '', $url);
            $url = substr( $url, 0, rstrpos( $url, '-' ) );
        }elseif( strpos( $url, '#' ) > 0 ){
            $add = explode( '#', $url );
            $url = $add[0];
            $add = '#' . $add[1];
        }

        if( !is_numeric( $url ) ){
            $page = get_page_by_path( $url );
            $id = $page->ID;
        }else{
            $id = $url;
            $page = get_post( $id );
        }

        $slug = $page->post_name;
        //$link = get_page_link( $id );
        $link = SCM_SITE . '/' . $slug;

        if( $link === get_the_permalink() && $add ) // toccato
            return $add;

        return $link . $add;
    }

    if( startsWith( $url, array( 'logout:', 'http://logout:', 'https://logout:' ) ) ) {
        $url = str_replace( array( 'logout:', 'http://logout:', 'https://logout:'), '', $url );
        $url = ( $url ?: site_url() );
        return wp_logout_url( $url );
    }

    if( startsWith( $url, 'map:' ) !== false )
        return googleMapsLink( $url );

    if( startsWith( $url, array( 'skype:', 'mailto:', 'tel:', 'callto:', 'fax:' ) ) !== false )
        return encodeEmail( $url );

    if( filter_var( $url, FILTER_VALIDATE_EMAIL ) )
        return 'mailto:' . encodeEmail( $url );

    if ( is_numeric( $url ) )
        return 'tel:' . ( startsWith( $url, '+' ) ? '' : '+' ) . $url;

    str_replace( array( 'http://#', 'https://#' ), '#', $url);

    if ( !startsWith( $url, '#' ) && !preg_match( '~^(?:f|ht)tps?://~i', $url ) )
        return addHTTP( $url );

    return $url;
}

/**
 * [GET] Get link data
 *
 * @subpackage 1-Utilities/WP
 *
 * @param {array|string} link Array containing 'url' attribute, or link url as string.
 * @param {string=} name New name (default is '').
 * @return {array} Empty array if fail, otherwise it returns a list of link data: url,link,name,icon,type.
 */
function linkExtend( $link, $name = '' ){
    
    if( !$link )
        return array();

    if( is_string( $link ) )
        $link = array( 'url' => $link );

    if( !is_array( $link ) )
        return array();

    if( !ex_attr($link, 'url', '') )
        return array();

    $link['link'] = getURL( $link['url'] );
    $link['name'] = ( $name ?: $link['url'] );
    $link['icon'] = 'globe';
    $link['type'] = 'external';
    
    if( startsWith( $link['link'], 'mailto:' ) ){
        $link['icon'] = 'envelope';
        $link['type'] = 'mail';
    }elseif( startsWith( $link['link'], 'tel:' ) ){
        $link['icon'] = 'phone';
        $link['type'] = 'phone';
    }elseif( startsWith( $link['link'], '#' ) ){
        $link['icon'] = 'hashtag';
        $link['type'] = 'page';
    }elseif( startsWith( $link['link'], SCM_SITE ) ){
        $link['icon'] = 'link';
        $link['type'] = 'site';
    }else{
        $parse = urlExtend( $link['link'] );
        if( $parse['sub'] == 'plus' && $parse['domain'] == 'google' )
            $link['icon'] = $link['type'] = 'google-plus';
        elseif( scm_fa_exists( 'social', $parse['domain'] ) )
            $link['icon'] = $link['type'] = $parse['domain'];
    }

    return $link;
}

/**
 * [GET] Get url data
 *
 * @subpackage 1-Utilities/WP
 *
 * @param {string} url URL as string.
 * @param {string=} name New name (default is '').
 * @return {array} Empty array if fail, otherwise it returns a list of link data: url,link,name,icon,type.
 */
function urlExtend( $url = '', $name = '' ){

    $parse = parse_url( $url );
    $parse['name'] = $name;
    $domain = strtolower( $parse['host'] );
    if( $domain == '' ) $domain = $url;
    $points = substr_count( $domain, '.' );

    if( $points > 0 ){

        //preg_match( '/^.+\.([a-z0-9\.\-]+\.[a-z]{2,4})$/', $domain, $domain );

        $domain = explode( '.', $domain );

        if( $points > 1 )
            $parse['sub'] = $domain[0];

        $parse['domain'] = $domain[$points-1];
        $parse['ext'] = $domain[$points];

        /*if( startsWith( $parse['domain'], 'www.' ) ){
            $parse['sub'] = 'www';
            $parse['domain'] = str_replace( 'www.', '', $parse['domain'] );
        }*/

        if( !$name )
            $parse['name'] = $parse['domain'];
    }

    return $parse;
}

/**
 * [GET] List of Roles
 *
 * @subpackage 1-Utilities/WP
 *
 * @return {array} Array containing Roles slugs.
 */
function getRoles(){

    $roles = array();

    $users = get_editable_roles();
    $users = $users['administrator'];
    $users = $users['capabilities'];

    foreach ( $users as $role => $value ) {
        $roles[$role] = $role;
    }

    return $roles;

}

// ------------------------------------------------------
// 0.1 WORDPRESS GOOGLE
// ------------------------------------------------------

/**
 * [GET] Latitude and longitude from address string
 *
 * @subpackage 1-Utilities/WP
 *
 * @param {string=} address Address string (default is '').
 * @param {string=} country Country string (default is '').
 * @return {array} Array containing 'lat' and 'lng' attributes.
 */
function getGoogleMapsLatLng( $address = '', $country = '' ){

    if( str_replace( ' ', '', $address ) === '' ){
        $address = 'Roma';
        $country = ( $country ?: 'Italy' );
    }

    $google_address = str_replace(' ', '+', doublesp( $google_address ) );

    $json = wp_remote_fopen( 'http://maps.google.com/maps/api/geocode/json?key=AIzaSyBZEApCxfzuavDWXdJ2DAVAftxbMjZWrVY?address=$google_address&sensor=false&region=$country' );
    $json = json_decode( $json );
    consoleLog( $json );

    $ret = array(
        'lat'   => $json->{'results'}[0]->{'geometry'}->{'location'}->{'lat'},
        'lng'   => $json->{'results'}[0]->{'geometry'}->{'location'}->{'lng'},
    );

    return $ret;
}

/**
 * [GET] YouTube video duration from URL
 *
 * @subpackage 1-Utilities/WP
 *
 * @param {string=} url Youtube video URL (default is '').
 * @return {string} Video duration.
 */
function getYouTubeDuration( $url = '' ){
    parse_str( parse_url( $url, PHP_URL_QUERY ), $arr );
    $video_id = ( $arr[ 'v' ] ?: $arr[ 'amp;v' ] );
    if( !$video_id ) return '';

    $data = wp_remote_fopen( 'http://gdata.youtube.com/feeds/api/videos/' . $video_id . '?v=2&alt=jsonc' );
    if ( false === $data ) return false;
    $obj = json_decode( $data );
    return $obj->data->duration;
}

/**
 * [GET] Google spreadsheet as an array
 *
 * Written 7 June 2012 by Mason Fabel
 * Revised 8 June 2012 by David Lim
 * Revised 19 June 2014 by David Lim for Google Spreadsheets V3 API
 *
 * V2 Description
 * This function takes a url in the form:
 * http://spreadsheets.google.com/feeds/cells/$KEY/1/public/values
 * where $KEY is the key given to the published version of the
 * spreadsheet.
 *
 * To publish a spreadsheet in Google Drive (2012), open the
 * spreadsheet. Under 'file', select 'Publish to the web...'
 * The key will be a part of the GET portion of the URL listed
 * at the bottom of the dialog box (https://....?key=$KEY&...)
 *
 * This function returns a multidimensional array in the form:
 * $array[$row][$col] = $content
 * where $row is a number and $col is a letter.
 *
 * Limitations
 * This only works for one sheet
 *
 * @subpackage 1-Utilities/WP
 *
 * @param {string} key Google spreadsheet key.
 * @return {array} Spreadsheet as array.
 */
function googleSpreadsheetToArray( $key = NULL ) {
// make sure we have a key
    if ( is_null( $url ) ) return array();
// initialize URL
    $url = 'http://spreadsheets.google.com/feeds/cells/' . $key . '/1/public/values';
// initialize curl
    $curl = curl_init();
// set curl options
    curl_setopt( $curl, CURLOPT_URL, $url );
    curl_setopt( $curl, CURLOPT_HEADER, 0 );
    curl_setopt( $curl, CURLOPT_RETURNTRANSFER, TRUE );
// get the spreadsheet using curl
    $google_sheet = curl_exec( $curl );
// close the curl connection
    curl_close( $curl );
// import the xml file into a SimpleXML object
    $feed = new SimpleXMLElement( $google_sheet );
// get every entry (cell) from the xml object
// extract the column and row from the cell's title
// e.g. A1 becomes [1][A]
    $array = array();
    foreach ( $feed->entry as $entry ) {
        $location = (string)$entry->title;
        preg_match( '/(?P<column>[A-Z]+)(?P<row>[0-9]+)/', $location, $matches );
    $array[ $matches['row'] ][$matches['column'] ] = (string)$entry->content;
    }
// return the array
    return $array;
}

/**
 * [GET] Google spreadsheet V3 as an array.
 *
 * For version 3.0 of the Google Spreadsheet API, this requires the spreadsheet worksheet
 * to be published as a web page. This function will parse through the generated HTML table
 * to extract spreadsheet contents.
 * This is because API v3 requires authentication and we don't want to put credentials in code.
 *
 * @subpackage 1-Utilities/WP
 *
 * @param {string} url Google spreadsheet URL.
 * @return {array} Spreadsheet as array.
 */
function googleSpreadsheetToArrayV3( $url=NULL ) {
// make sure we have a URL
    if ( is_null( $url ) ) return array();
// initialize curl
    $curl = curl_init();
// set curl options
    curl_setopt( $curl, CURLOPT_URL, $url );
    curl_setopt( $curl, CURLOPT_HEADER, 0 );
    curl_setopt( $curl, CURLOPT_RETURNTRANSFER, TRUE );
// get the spreadsheet data using curl
    $google_sheet = curl_exec( $curl );
// close the curl connection
    curl_close( $curl );
// parse out just the html table
    preg_match( '/(<table[^>]+>)(.+)(<\/table>)/', $google_sheet, $matches );
    $data = $matches['0'];
// Convert the HTML into array (by converting into HTML, then JSON, then PHP array
    $cells_xml = new SimpleXMLElement( $data );
    $cells_json = json_encode( $cells_xml );
    $cells = json_decode( $cells_json, TRUE );
// Create the array
    $array = array();
    foreach ( $cells['tbody']['tr'] as $row_number=>$row_data ) {
        $column_name = 'A';
        foreach ( $row_data['td'] as $column_index=>$column ) {
            $array[ ( $row_number + 1 ) ][ $column_name++ ] = $column;
        }
    }
    return $array;
}

/**
 * [GET] CSV file as an array.
 *
 * @subpackage 1-Utilities/WP
 *
 * @param {string} csvFile CSV file.
 * @return {array} CSV file as array.
 */
function readCSV( $csvFile = NULL ){
    if ( is_null( $csvFile ) ) return array();
    $file_handle = fopen( $csvFile, 'r' );
    while ( !feof( $file_handle ) ) {
        $line_of_text[] = fgetcsv( $file_handle, 1024 );
    }
    fclose( $file_handle );
    return $line_of_text;
}

// ------------------------------------------------------
// 1.0 DEBUG
// ------------------------------------------------------

/**
 * [SET] Echo array into PRE tag
 *
 * @subpackage 1-Utilities/DEBUG
 *
 * @param {array} arr Array to print.
 */
function printPre( $arr ){
    echo '<pre>';
    print_r($arr);
    echo '</pre>';
}

/**
 * [SET] Echo javascript alert()
 *
 * @subpackage 1-Utilities/DEBUG
 *
 * @param {string} str String to print.
 * @param {string=} more String to append (default is '').
 * @param {string=} divider String to divide str and more (default is ': ').
 */
function alert( $str, $more = '', $divider = ': ' ){
    echo '<script>alert("' . $str . ( $more ? $divider : '' ) . $more . '");</script>';
}

/**
 * [SET] Echo javascript console.log()
 *
 * @subpackage 1-Utilities/DEBUG
 *
 * @param {misc} obj Item to print.
 */
function consoleLog( $obj ){
    ?>
    <script type='text/javascript'>
        console.log( <?php echo json_encode( $obj ); ?> );
    </script>
    <?php
}

// ------------------------------------------------------
// 2.0 MISC
// ------------------------------------------------------

/**
 * [GET] Value exists (0 is not), or fallback
 *
 * @subpackage 1-Utilities/MISC
 *
 * @param {misc} var Value to check.
 * @param {misc=} fall Fallback (default is '').
 * @param {misc=} pre Prepend (default is '').
 * @param {misc=} app Append (default is '').
 * @return {misc} Current $var if exists, fallback if not.
 */
function is( $var = NULL, $fall = '', $pre = '', $app = '' ){
    if( is_null($var) || !$var || empty($var) ) return $fall;
    return ( is_string( $var ) ? $pre . $var . $app : ( is_numeric( $var ) ? (int)$pre + $var - (int)$app : $var ) );
}

/**
 * [GET] Value exists (0 is)
 *
 * @subpackage 1-Utilities/MISC
 *
 * @param {misc} var Value to check.
 * @return {bool} Value exists.
 */
function exists( $var = '' ){
    return !is_null($var) && ( $var || $var === 0 ) ;
}

/**
 * [GET] Value exists (0 is), or fallback
 *
 * @subpackage 1-Utilities/MISC
 *
 * @param {misc} var Value to check.
 * @param {misc=} fall Fallback (default is '').
 * @param {misc=} pre Prepend (default is '').
 * @param {misc=} app Append (default is '').
 * @return {misc} Current $var if exists, fallback if not.
 */
function ifexists( $var = NULL, $fall = '', $pre = '', $app = '' ){
    if( !exists( $var ) ) return $fall;
    return ( is_string( $var ) ? $pre . $var . $app : ( is_numeric( $var ) ? (int)$pre + $var - (int)$app : $var ) );
}

/**
 * [GET] Value is number, or fallback
 *
 * @subpackage 1-Utilities/MISC
 *
 * @param {misc} var Value to check.
 * @param {misc=} fall Fallback (default is '').
 * @param {int=} pre Add (default is 0).
 * @param {int=} app Subtract (default is 0).
 * @return {int} Value plus $pre minus $app if value is number, otherwise it returns $fall.
 */
function isNumber( $var = NULL, $fall = 0, $pre = 0, $app = 0 ){
    if( is_null( $var ) || !is_numeric( $var ) ) return $fall;
    return (int)$pre + $var - (int)$app;
}

/**
 * [GET] Value A is equal to value B, or fallback
 *
 * @subpackage 1-Utilities/MISC
 *
 * @param {misc} var First value to compare.
 * @param {misc=} equal Second value to compare, or a list of values (default is empty array).
 * @param {misc=} fall Fallback (default is '').
 * @param {misc=} pre Prepend (default is '').
 * @param {misc=} app Append (default is '').
 * @return {misc} Current $var if equal to $equal, $fall otherwise.
 */
function ifequal( $var = NULL, $equal = array(), $fall = '', $pre = '', $app = ''  ){
    if( is_null( $var ) ) return $fall;
    $equal = toArray( $equal );
    foreach ( $equal as $cond ) {
        if( $var === $cond )
            return ( is_string( $var ) ? $pre . $var . $app : ( is_numeric( $var ) ? (int)$pre + $var - (int)$app : $var ) );
    }
    return $fall;
}

/**
 * [GET] Value A is not equal to value B, or fallback
 *
 * @subpackage 1-Utilities/MISC
 *
 * @param {misc} var First value to compare.
 * @param {misc} equal Second value to compare, or a list of values (default is empty array).
 * @param {misc} fall Fallback (default is '').
 * @param {misc} pre Prepend (default is '').
 * @param {misc} app Append (default is '').
 * @return {misc} Current var if not equal, fallback if equal, '' if $var is NULL.
 */
function ifnotequal( $var = NULL, $equal = array(), $fall = '', $pre = '', $app = ''  ){
    if( is_null( $var ) ) return '';
    $equal = toArray( $equal );
    foreach ( $equal as $cond ) {
        if( $var === $cond )
            return $fall;
    }
    return ( is_string( $var ) ? $pre . $var . $app : ( is_numeric( $var ) ? (int)$pre + $var - (int)$app : $var ) );
}

/**
 * [GET] Compare two values
 *
 * @subpackage 1-Utilities/MISC
 *
 * @param {misc} a First value.
 * @param {string=} op Operator [==|===|!=|!==|>|>=|>|>=|ends|starts] (default is '==').
 * @param {misc} b Second value.
 * @return {boolean} %a is %op to %b.
 */
function compare($a = NULL, $op = '==', $b = NULL) {
    if( is_null($a) || is_null($b) ) return false;
    switch ( $op ) {
        case '==': return $a == $b; break;
        case '===': return $a === $b; break;
        case '!=': return $a != $b; break;
        case '!==': return $a !== $b; break;
        case '>': return $a > $b; break;
        case '>=': return $a >= $b; break;
        case '<': return $a < $b; break;
        case '<=': return $a <= $b; break;
        case 'ends': return endsWith( $a, $b ); break;
        case 'starts': return startsWith( $a, $b ); break;
        default: return false;
    }
    return false;
}

/**
 * [GET] Get Query var
 *
 * @subpackage 1-Utilities/MISC
 *
 * @param {string=} var Var name (default is '').
 * @param {misc=} fallback Fallback (default is '').
 * @return {misc} Query var value or fallback.
 */
function getQueryVar( $var = '', $fallback = '' ) {
    return isset( $_GET[ $var ] ) ? $_GET[ $var ] : ( isset( $_POST[ $var ] ) ? $_POST[ $var ] : $fallback );
}

// ------------------------------------------------------
// 3.0 STRING
// ------------------------------------------------------

/**
 * [GET] String ends at position
 *
 * Acts like strpos() {@link http://php.net/manual/en/function.strpos.php}
 * adding string length to result.
 *
 * @subpackage 1-Utilities/STRING
 *
 * @param {string} haystack String to check.
 * @param {string=} needle String to look for (default is '').
 * @return {int} Needle end position in string.
 */
function rstrpos( $haystack, $needle = '' ){
    $size = strlen( $haystack );
    $pos = strpos( strrev( $haystack ), $needle );

    if( $pos === false )
        return false;

    return $size - $pos - 1;
}

/**
 * [GET] Remove double spaces
 *
 * @subpackage 1-Utilities/STRING
 *
 * @param {string=} str String where to look for double spaces (default is '').
 * @return {string} String without double spaces.
 */
function doublesp( $str = '' ){
    if( !$str ) return '';
    return preg_replace( '/\s+/', ' ', $str );
}

/**
 * [GET] Remove multiple spaces
 *
 * @subpackage 1-Utilities/STRING
 *
 * @param {string=} str String where to look for multiple spaces (default is '').
 * @return {string} String without multiple spaces.
 */
function multisp( $str = '' ){
    if( !$str ) return '';
    return preg_replace( '!\s+!', ' ', $str );
}

/**
 * [GET] Check if string starts with needle
 *
 * @subpackage 1-Utilities/STRING
 *
 * @param {string} str String to check.
 * @param {string=} needle String to look for (default is '').
 * @return {boolean} String starts with needle.
 */
function startsWith( $str, $needle = '' ) {

    $needle = toArray( $needle );

    if( !is_string( $str ) )
        return false;

    foreach ( $needle as $value ) {
        if( !$value || strrpos($str, $value, -strlen($str)) !== FALSE )
            return true;
    }

    return false;
}

/**
 * [GET] Check if string ends with needle
 *
 * @subpackage 1-Utilities/STRING
 *
 * @todo Check it out if it actually works
 *
 * @param {string} str String to check.
 * @param {string=} needle String to look for (default is '').
 * @return {boolean} String ends with needle.
 */
function endsWith($str, $needle = '') {

    if( !is_string( $str ) )
        return false;

    return $needle === '' || ( ( $temp = strlen( $str ) - strlen( $needle ) ) >= 0 && strpos( $str, $needle, $temp ) !== FALSE );

}

// ------------------------------------------------------
// 4.0 ARRAY
// ------------------------------------------------------

/**
 * [GET] Average between values
 *
 * @subpackage 1-Utilities/ARRAY
 *
 * @param {array} arr Array or Object to check.
 * @return {number} Average
 */
function array_average( $arr ) {
    $tot = count( $arr );
    if (!$tot)
        return 0;
    return array_sum( $arr ) / $tot;
}

/**
 * [GET] Is array or object
 *
 * @subpackage 1-Utilities/ARRAY
 *
 * @param {array} arr Array or Object to check.
 * @return {bool} Is array or object
 */
function is_arr( $arr ){

    if( !is_array( $arr ) && !is_object( $arr ) )
        return false;

    return true;
}

/**
 * [GET] Is indexed array, associative array or object
 *
 * @subpackage 1-Utilities/ARRAY
 *
 * @param {array} arr Array or Object to check.
 * @return {string} Is indexed array, associative array or object [arr|asso|obj]
 */
function is_list( $arr ){

    if( !is_arr( $arr ) )
        return '';

    if( is_object( $arr ) )
        return 'obj';

    if( is_asso( $arr ) )
        return 'asso';

    return 'arr';
}

/**
 * [GET] Is associative array
 *
 * Example usage:
 *
```php
$var = 'string';
$array = [ 'John', 'Smith', 'New York' ];
$asso = [ 'name'=>'John', 'surname'=>'Smith', 'city'=>'New York' ];

print( is_asso( $var ) ) // NULL
print( is_asso( $array ) ) // false
print( is_asso( $asso ) ) // true
```
 *
 * @subpackage 1-Utilities/ARRAY
 *
 * @param {array} arr Array to check.
 * @return {bool|null} NULL if arr is not an array. It returns true if array is associative, otherwise it returns false.
 */
function is_asso( $arr ){

    if( !is_arr( $arr ) )
        return null;

    foreach( array_keys( $arr ) as $key){
        if ( !is_int( $key ) ) return true;
    }

    return false;
}

/**
 * [GET] To associative array
 *
 * @subpackage 1-Utilities/ARRAY
 *
 * @param {array} arr Array to convert.
 * @return {array|null} NULL if arr is not an array. It returns an associative array.
 */
function array_to_asso( $arr ){

    if( !is_arr( $arr ) )
        return null;

    $new = array();
    foreach( $arr as $value ){
        $new[ $value ] = $value;
    }

    return $new;
}

/**
 * [GET] Associative array attribute exists, or fallback
 *
 * @subpackage 1-Utilities/ARRAY
 *
 * @param {array} var Array to check.
 * @param {string} attr Attribute to look for.
 * @param {string=} fall Fallback (default is '').
 * @param {string=} pre Prepend (default is '').
 * @param {string=} app Append (default is '').
 * @return {string} Array attribute if exists, fallback if not.
 */
function ex_attr( $var, $attr = '', $fall = '', $pre = '', $app = '' ){
    $ret = '';
    if( !isset( $var ) || !is_asso( $var ) || !$attr || !is_string( $attr ) || !isset( $var[$attr] ) )
        $ret = $fall;
    else
        $ret = $var[$attr];
    if( $ret && ( $pre || $app ) )
        $ret = $pre . (string)$ret . $app;

    return $ret;
}

/**
 * [GET] Associative array attribute is, or fallback
 *
 * @subpackage 1-Utilities/ARRAY
 *
 * @param {array} var Array to check.
 * @param {string} attr Attribute to look for.
 * @param {string=} fall Fallback (default is '').
 * @param {string=} pre Prepend (default is '').
 * @param {string=} app Append (default is '').
 * @return {string} Array attribute if exists, fallback if not.
 */
function is_attr( $var, $attr, $fall = '', $pre = '', $app = '' ){
    $ret = '';
    if( !isset($var) || !is_asso($var) || !isset($attr) || !exists($attr) || !is_string($attr) || !isset($var[$attr]) || !$var[$attr] )
        $ret = $fall;
    else
        $ret = $var[$attr];
    if( $pre || $app )
        $ret = $pre . (string)$ret . $app;

    return $ret;
}

/**
 * [GET] Convert item to array
 *
 * Example usage:
 *
```php
// Anything to array
$var = 'variable';
$new = toArray( $var );
print( $new ) // [ 'variable' ]

// Empty to array
$var = '';
$new = toArray( $var );
print( $new ) // ['']

// Empty to array ($empty=true)
$emp = '';
$new = toArray( $emp, false, true );
print( $new ) // ''

// Indexed array to array
$array = [ 'value' ];
$new = toArray( $array );
print( $new ) // [ 'value' ]

// Associative array to array
$asso = [ 'key' => 'value' ];
$new = toArray( $asso );
print( $new ) // [ 'key' => 'value' ]

// Associative array to array ($asso=true)
$asso = [ 'key' => 'value' ];
$new = toArray( $asso, true );
print( $new ) // [ [ 'key' => 'value' ] ]
```
 *
 * @subpackage 1-Utilities/ARRAY
 *
 * @param {misc=} var Item to convert (default is '').
 * @param {bool=} asso New indexed array if var is associative array (default is false).
 * @param {bool=} empty Break function returning '' if var is '' (default is false).
 * @return {array} Array containing var, otherwise it returns var if already an array.
 */
function toArray( $var = '', $asso = false, $empty = false ){

    if( $empty && $var === '' )
        return '';

    if( !$asso )
        return ( is_array( $var ) ? $var : array( $var ) );

    return ( is_asso( $var ) === false ? $var : array( $var ) );

}

/**
 * [GET] Copy array with removed items
 *
 * Example usage:
 *
```php
$arr = [ 'name'=>'John', 'surname'=>'Smith', 'city'=>'New York' ];
$new = delArray( $arr, [ 'surname' ] );
print( $new ) // [ 'name'=>'John', 'city'=>'New York' ]
```
 *
 * @subpackage 1-Utilities/ARRAY
 *
 * @param {array} arr Array to copy.
 * @param {array} elems Array of items to be removed.
 * @return {array} Modified copy of the array.
 */
function delArray( $arr, $elems ){
    $new = array();
    if( !isset( $arr ) || !is_array( $arr ) ) return $new;
    $new = copyArray( $arr );
    $elems = toArray( $elems );
    foreach ($elems as $k => $v) {
        if( ( $key = array_search( $v, $new ) ) !== false ) {
            unset($new[$k]);
        }
    }

    return $new;
}

/**
 * [GET] Copy array with selected items
 *
 * Example usage:
 *
```php
$arr = [ [ 'id'=>'JN','num'=>'one','cat'=>0 ], [ 'id'=>'PT','num'=>'two','cat'=>1 ], [ 'id'=>'SM','num'=>'three','cat'=>1 ]];

// With $filter (include)
$sub = subArray( $arr, '', '', [ 'cat'=>1 ] );
print( $sub ) // [ [ 'id'=>'PT', 'num'=>'two', 'cat'=>1 ], [ 'id'=>'SM', 'num'=>'three', 'cat'=>1 ] ]

// With $filter (exclude)
$sub = subArray( $arr, '', '', [ 'cat'=>1 ], true );
print( $sub ) // [ [ 'id'=>'JN','num'=>'one','cat'=>0 ] ]

// With $att_v and $att_k
$sub = subArray( $arr, 'id', 'num' );
print( $sub ) // [ 'one'=>'JN', 'two'=>'PT', 'three'=>'SM' ]

// If one only argument is passed it acts like @see copyArray().
$sub = subArray( $arr );
print( $sub ) 
```
 *
 * @subpackage 1-Utilities/ARRAY
 *
 * @param {array} arr Array where to subtract items.
 * @param {int|string=} att_v Item index|attribute to pick up as new values (default is '').
 * @param {int|string=} att_k Item index|attribute to pick up as new keys (default is '').
 * @param {array=} filter Filter items by key and value (default is empty array).
 * @return {array} New subtracted array.
 */
function subArray( $arr, $att_v = '', $att_k = '', $filter = array(), $exclude = false ){
    $new = array();
    if( !isset( $arr ) || !is_array( $arr ) ) return $new;
    foreach ( $arr as $key => $value ) {
        if ( !empty( $filter ) ) {
            foreach ( $filter as $k => $v ) {
                if( !$exclude ){
                    if ( !array_key_exists( $k, $value ) || ( array_key_exists( $k, $value ) && $value[$k] !== $v ) )
                        continue(2);
                }else{
                    if ( array_key_exists( $k, $value ) && $value[$k] == $v )
                        continue(2);
                }
            }
        }
        $key = ( $att_k ? $value[$att_k] : $key );
        $value = ( $att_v ? $value[$att_v] : $value );
        $new[$key] = $value;
    }
    return $new;
}

/**
 * [GET] Copy object with selected items
 *
 * @see subArray()
 *
 * @subpackage 1-Utilities/ARRAY
 *
 * @param {array} arr Array where to subtract items.
 * @param {key} filter Filter items by key and value (default is '').
 * @param {misc=} filter Filter items by key and value (default is '').
 * @return {array} New subtracted array.
 */
function subObject( $arr, $key = '', $filter = NULL, $exclude = false ){
    if( !$key || !is_string( $key ) ) return $arr;
    $new = array();
    if( !isset( $arr ) || !is_array( $arr ) ) return $new;
    foreach ( $arr as $obj ) {
        if( property_exists( $obj, $key ) ){
            if ( is_null( $filter ) || ( ( !$exclude && $obj->$key == $filter ) || ( $exclude && $obj->$key != $filter ) ) )
                $new[] = $obj;
        }
    }
    return $new;
}

/**
 * [GET] Copy array
 *
 * Example usage:
 *
```php
$arr = [ 'key'=>'value' ];
$new = copyArray( $arr );
print( $new ) // [ 'key'=>'value' ]
```
 *
 * @subpackage 1-Utilities/ARRAY
 *
 * @param {array} arr Array to copy.
 * @return {array} Copy of the array.
 */
function copyArray( $arr ){
    $new = array();
    if( !isset( $arr ) || !is_array( $arr ) ) return $new;
    foreach ( $arr as $k => $v ) {
        if(is_asso($v))
            $new[$k] = clone $v;
        else
            $new[$k] = $v;
    }

    return $new;
}

/**
* [SET] Inserts a new value before any index in the array.
*
* @subpackage 1-Utilities/ARRAY
*
* @param {array=} $arr An array to insert in to (default is empty array).
* @param {misc} $value The value to insert.
* @return {array} The new array.
*
* @see asso_push()
*/
function arr_unshift( $arr = array(), $value = NULL ){
    if( is_null( $value ) ) return $arr;
    return array_merge( array( $value ), $arr );
}

/**
* [SET] Inserts a new value after any index in the array.
*
* @subpackage 1-Utilities/ARRAY
*
* @param {array=} $arr An array to insert in to (default is empty array).
* @param {misc} $value The value to insert.
* @return {array} The new array.
*
* @see asso_unshift()
*/
function arr_push( $arr = array(), $value = NULL ){
    if( is_null( $value ) ) return $arr;
    return array_merge( $arr, array( $value ) );
}

/**
 * [SET] Insert or replace value in array
 *
 * Example usage:
 *
```php
$arr = [ 'insert', 'element' ];

// Insert item in array
$arr = arr_insert( $arr, 1, 'an' );
print( $arr ) // [ 'insert', 'an', 'element' ]

// Replace item in array
$arr = arr_insert( $arr, 2, 'elephant', true );
print( $arr ) // [ 'insert', 'an', 'elephant' ]
```
 *
 * @subpackage 1-Utilities/ARRAY
 *
 * @param {array=} $arr An array to insert in to (default is empty array).
 * @param {int=} offset Index where to insert value (default is 0).
 * @param {misc=} value Value to be insered (default is '').
 * @param {boolean=} replace Replace value at index with the new one (default is false).
 */
function arr_insert( $arr = array(), $offset = 0, $value = '', $replace = false ){

    if( isset( $arr ) && is_arr( $arr ) ){
        if( $replace ){
            $offset = ( $offset < 0 ? 0 : ( $offset > count( $arr ) - 1 ? count( $arr ) - 1 : $offset ) );
            return array_replace( $arr, array( $offset => $value ) );
        }else{
            if( $offset == 0 ){
                return arr_unshift( $arr, $value );
            }else if( $offset >= count( $arr ) ){
                return arr_push( $arr, $value );
            }else{
                $a1 = array_slice( $arr, 0, $offset );
                $a2 = array_slice( $arr, $offset );
                $a1 = arr_push( $a1, $value );
                return array_merge( $a1, $a2 );
            }
        }
    }

    return $arr;
}

/**
 * [SET] Insert or replace value in array (deprecated)
 *
 * @deprecated Use arr_insert()
 * @see arr_insert()
 * @return WARNING: this function does not return a new array. The original array is altered.
 */
function insertArray( &$arr, $offset = 0, $value = '', $replace = false ){

    consoleLog( 'insertArray() is deprecated. Switching to arr_insert().' );
    consoleLog( debug_backtrace() );

    $arr = arr_insert( $arr, $offset, $value, $replace );
}

/**
* [SET] Inserts a new key/value before any key in the array.
*
* @subpackage 1-Utilities/ARRAY
*
* @param {array=} $arr An array to insert in to (default is empty array).
* @param {string} $key The key to insert.
* @param {misc} $value The value to insert.
* @return {array} The new array.
*
* @see asso_push()
*/
function asso_unshift( $arr = array(), $key = NULL, $value = NULL ){
    if( is_null( $key ) || !is_string( $key ) || is_null( $value ) ) return $arr;
    return array_merge( array( $key=>$value ), $arr );
}

/**
* [SET] Inserts a new key/value after any key in the array.
*
* @subpackage 1-Utilities/ARRAY
*
* @param {array=} $arr An array to insert in to (default is empty array).
* @param {string} $key The key to insert.
* @param {misc} $value The value to insert.
* @return {array} The new array.
*
* @see asso_unshift()
*/
function asso_push( $arr = array(), $key = NULL, $value = NULL ){
    if( is_null( $key ) || !is_string( $key ) || is_null( $value ) ) return $arr;
    return array_merge( $arr, array( $key=>$value ) );
}

/**
* [SET] Inserts a new key/value before the key in the array.
*
* @subpackage 1-Utilities/ARRAY
*
* @param {array=} $arr An array to insert in to (default is empty array).
* @param {string} $offset The key to insert before.
* @param {string} $key The key to insert.
* @param {misc} $value An value to insert.
* @return {array} The new array.
*
* @see asso_insert_after()
*/
function asso_insert_before( $arr = array(), $offset, $key, $value ) {
    if ( array_key_exists( $offset, $arr ) ) {
        $new = array();
        foreach ( $arr as $k => $v ) {
            if ( $k === $offset )
            $new[ $key ] = $value;
            $new[ $k ] = $v;
        }
        return $new;
    }
    return $arr;
}

/**
* [SET] Inserts a new key/value after the key in the array.
*
* @subpackage 1-Utilities/ARRAY
*
* @param {array=} $arr An array to insert in to (default is empty array).
* @param {string} $offset The key to insert after.
* @param {string} $key The key to insert.
* @param {misc} $value An value to insert.
* @return {array} The new array.
*
* @see asso_insert_before()
*/
function asso_insert_after( $arr = array(), $offset, $key, $value ) {
    if ( array_key_exists( $offset, $arr ) ) {
        $new = array();
        foreach ( $arr as $k => $v ) {
            $new[ $k ] = $v;
            if ( $k === $offset )
            $new[ $key ] = $value;
        }
        return $new;
    }
    return arr;
}

/**
* [SET] Insert element in associative array after or before a specific key
 *
 * Example usage:
 *
```php
$arr = [ 'name' => 'John', 'surname' => 'Smith' ];

// Insert item in associative array after key
asso_insert( $arr, 'nickname', 'Johnny', 'name' );
print( $arr ) // [ 'name' => 'John', 'nickname' => 'Johnny', 'surname' => 'Smith' ];

// Insert item in associative array before key
asso_insert( $arr, 'id', 123, 'name', true );
print( $arr ) // [ 'id' => 123, 'name' => 'John', 'surname' => 'Smith' ];
```
*
* @subpackage 1-Utilities/ARRAY
*
* @param {array} arr Associative array where to insert value.
* @param {string} key Index to be insered.
* @param {misc} value Value to be insered.
* @param {string=} offset Index where to insert value (default is '').
* @param {boolean=} before Insert before the offset if true (default is false).
*/
function asso_insert( $arr, $key = NULL, $value = NULL, $offset = '', $before = false ){
    if( is_null( $key ) || !is_string( $key ) || is_null( $value ) ) return $arr;
    if( isset( $arr ) && is_asso( $arr ) ){
        if( !$offset || !array_key_exists( $offset, $arr ) )
            return asso_unshift( $arr, $key, $value );
        else if( $before )
            return asso_insert_before( $arr, $offset, $key, $value );
        else
            return asso_insert_after( $arr, $offset, $key, $value );
    }
    return $arr;
}

/**
 * [GET] Value by key
 *
 * Example usage:
 *
```php
$arr = ['key'=>'value', 'other'=>'element'];
$val = getByKey( $arr, 'key' );
print( $val ) // 'value'
```
 *
 * @subpackage 1-Utilities/ARRAY
 *
 * @param {array} arr Array where to look for.
 * @param {string} key Key to look for.
 * @return {misc|null} NULL if the key does not exist, otherwise it returns the value of the key.
 */
function getByKey( $arr, $key ){
    if( !isset( $arr ) || !is_arr( $arr ) ) return NULL;
    foreach ($arr as $k => $v) {
        if( $k == $key ) return $v;
    }
    return NULL;
}

/**
 * [GET] Key by value
 *
 * Example usage:
 *
```php
$arr = ['key'=>'value', 'other'=>'element'];
$key = getByValue( $arr, 'value' );
print( $key ) // 'key'
```
 *
 * @subpackage 1-Utilities/ARRAY
 *
 * @param {array} arr Array where to look for.
 * @param {string} value Value to look for.
 * @return {misc|null} NULL if the value does not exist, otherwise it returns the key of the value.
 */
function getByValue( $arr, $value ){
    if( !isset( $arr ) || !is_array( $arr ) ) return NULL;
    foreach ($arr as $key => $elem) {
        if( $elem == $value ) return $key;
    }
    return NULL;
}

/**
 * [GET] Key or value by needle
 *
 * Example usage:
 *
```php
$arr = ['my_key_1'=>'my_value_1', 'other'=>'element'];

// Retrive key from array
$key = getByString( $arr, 'key', true );
print( $key ) // 'my_key_1'

// Retrive value from array
$val = getByString( $arr, 'key' );
print( $val ) // 'my_value_1'
```
 *
 * @subpackage 1-Utilities/ARRAY
 *
 * @param {array} arr Array where to look for
 * @param {string} string Needle to look for
 * @param {boolean=} key Return the key (default is false).
 * @return {misc|null} NULL if the needle is not found, otherwise it returns the found key or its value.
 */
function getByString( $arr, $string, $key = false ){
    if( !isset( $arr ) || !is_array( $arr ) ) return NULL;
    foreach ($arr as $k => $v) {
        if( strpos($k, $string) !== false ){
            if( $key ) return $k;
            return $v;
        }
    }
    return NULL;
}

/**
 * [GET] Keys or values by string
 *
 * Example usage:
 *
```php
$arr = ['my_key_1'=>'my_value_1', 'my_key_2'=>'my_value_2', 'other'=>'element'];

// Retrive keys from array
$key = getAllByString( $arr, 'key', true );
print( $key ) // ['my_key_1', 'my_key_2']

// Retrive values from array
$val = getAllByString( $arr, 'key' );
print( $val ) // ['my_value_1','my_value_2']
```
 *
 * @subpackage 1-Utilities/ARRAY
 *
 * @param {array} arr Array where to look for
 * @param {string} string Needle to look for
 * @param {boolean=} key Return the keys (default is false).
 * @return {array} Empty array if the needle is not found, otherwise it returns an array of values.
 */
function getAllByString( $arr, $string, $key = false ){
    $new = array();
    if( !isset( $arr ) || !is_array( $arr ) ) return $new;
    foreach ($arr as $k => $v) {
        if( strpos($k, $string) !== false ) $new[] = $v;
    }
    return $new;
}

/**
 * [GET] Key or value by prefix
 *
 * Example usage:
 *
```php
$arr = ['my_key_1'=>'my_value_1', 'other'=>'element'];

// Retrive key from array
$key = getByPrefix( $arr, 'my_key', true );
print( $key ) // 'my_key_1'

// Retrive value from array
$val = getByPrefix( $arr, 'my_key' );
print( $val ) // 'my_value_1'
```
 *
 * @subpackage 1-Utilities/ARRAY
 *
 * @param {array} arr Array where to look for
 * @param {string} prefix Prefix to look for
 * @param {boolean=} key Return the key (default is false).
 * @return {misc|null} NULL if the prefix is not found, otherwise it returns the found key or its value.
 */
function getByPrefix( $arr, $prefix, $key = false ){
    if( !isset( $arr ) || !is_array( $arr ) ) return NULL;
    foreach ($arr as $k => $v) {
        if( strpos($k, $prefix) === 0 ){
            if( $key )
                return $k;
            else
                return $v;
        }
    }
    return NULL;
}

/**
 * [GET] Keys, values or filtered array by prefix
 *
 * Example usage:
 *
```php
$arr = ['my_key_1'=>'my_value_1', 'my_key_2'=>'my_value_2', 'other'=>'element'];

// Retrive keys from array
$key = getAllByPrefix( $arr, 'my_key', true );
print( $key ) // [ 'my_key_1', 'my_key_2' ]

// Retrive values from array
$val = getAllByPrefix( $arr, 'my_key' );
print( $val ) // [ 'my_value_1', 'my_value_2' ]

// Retrive keys and values from array
$arr1 = getAllByPrefix( $arr, 'my_key', 1 );
print( $arr1 ) // [ 'my_key_1'=>'my_value_1', 'my_key_2'=>'my_value_2' ]

// Retrive keys without prefix and values from array
$arr1 = getAllByPrefix( $arr, 'my_', 2 );
print( $arr1 ) // [ 'key_1'=>'my_value_1', 'key_2'=>'my_value_2' ]
```
 *
 * @subpackage 1-Utilities/ARRAY
 *
 * @param {array} arr Array where to look for
 * @param {string} prefix Prefix to look for
 * @param {boolean=|int} key Return the keys if true (default is false). If set to 1 it returns keys and values. If set to 2 it returns keys without prefix and values.
 * @return {array} Empty array if the prefix is not found, otherwise it returns a filtered array (see top examples).
 */
function getAllByPrefix( $arr, $prefix, $key = false ){
    $new = array();
    if( !isset( $arr ) || !is_array( $arr ) ) return $new;
    foreach ($arr as $k => $v) {
        if( strpos($k, $prefix) === 0 ){
            if( $key === 1 ) $new[$k] = $v;
            elseif( $key === 2 ) $new[str_replace($prefix, '', $k)] = $v;
            elseif( $key === true ) $new[] = $k;
            else $new[] = $v;
        }
    }
    return $new;
}

/**
 * [GET] Array by value and key
*
 * Example usage:
 *
```php
$arr = [ [ 'name'=>'value' ], [ 'other'=>'element' ] ];

// Get item index by 'name' key and value from array
$ind = getByValueKey( $arr, 'value' );
print( $ind ) // 0

// Get item index by key and value from array
$ind = getByValueKey( $arr, 'element', 'other' );
print( $ind ) // 1
```
 *
 * @subpackage 1-Utilities/ARRAY
 *
 * @param {array} arr Array where to look for
 * @param {string} value Value to look for
 * @param {string=} key Key to look for (default is 'name').
 * @return {int|null} NULL if the value is not found, otherwise it returns the found element index.
 */
function getByValueKey( $arr, $value, $key = 'name' ){
    if( !isset( $arr ) || !is_array( $arr ) ) return NULL;
    foreach ($arr as $index => $elem) {
        if( is_array($elem) && isset( $elem[$key] ) && $elem[$key] == $value ) return $index;
    }
    return NULL;
}

/**
 * [GET] Arrays or objects by value and key
 *
 * Example usage:
 *
```php
$arr = [ [ 'name'=>'Jack', 'sur'=>'Black' ], [ 'name'=>'John', 'sur'=>'Black' ], [ 'name'=>'John', 'sur'=>'White' ] ];

// Get items by 'name' key and value from array
$res = getAllByValueKey( $arr, 'John' );
print( $res ) // [ [ 'name'=>'John', 'sur'=>'Black' ], [ 'name'=>'John', 'sur'=>'White' ] ]

// Get items by key and value from array
$res = getAllByValueKey( $arr, 'Black', 'sur' );
print( $res ) // [ [ 'name'=>'Jack', 'sur'=>'Black' ], [ 'name'=>'John', 'sur'=>'Black' ] ]
```
 *
 * @subpackage 1-Utilities/ARRAY
 *
 * @param {array} arr Array where to look for
 * @param {string} value Value to look for
 * @param {string=} key Key to look for (default is 'name').
 * @return {array} Empty array if the value is not found, otherwise it returns the found elements.
 */
function getAllByValueKey( $arr, $value, $key = 'name' ){
    $new = array();
    if( !isset( $arr ) || !is_array( $arr ) ) return $new;
    foreach ($arr as $index => $elem) {
        if( is_array($elem) && isset( $elem[$key] ) && $elem[$key] == $value ) $new[] = $elem;
    }
    return $new;
}

/**
 * [GET] Arrays or objects by value prefix and key
 *
 * Example usage:
 *
```php
$arr = [ [ 'name'=>'Jack', 'sur'=>'Mc Key' ], [ 'name'=>'John', 'sur'=>'Mc Val' ], [ 'name'=>'Mc Al', 'sur'=>'White' ] ];

// Filter arrays by 'name' key and value prefix
$res = getAllByValuePrefixKey( $arr, 'Mc' );
print( $res ) // [ [ 'name'=>'Mc Al', 'sur'=>'White' ] ]

// Filter arrays by key and value prefix
$res = getAllByValuePrefixKey( $arr, 'Mc', 'sur' );
print( $res ) // [ [ 'name'=>'Jack', 'sur'=>'Mc Key' ], [ 'name'=>'John', 'sur'=>'Mc Key' ] ]
```
 *
 * @subpackage 1-Utilities/ARRAY
 *
 * @param {array} arr Array where to look for
 * @param {string} prefix Prefix to look for
 * @param {string=} key Key to look for (default is 'name').
 * @return {array} Empty array if the prefix is not found, otherwise it returns the found elements.
 */
function getAllByValuePrefixKey( $arr, $prefix, $key = 'name' ){
    $new = array();
    if( !isset( $arr ) || !is_array( $arr ) ) return $new;
    foreach ($arr as $index => $elem) {
        if( is_array($elem) && isset( $elem[$key] ) && strpos( $elem[$key], $prefix ) === 0 ) $new[] = $elem;
    }
    return $new;
}

/**
 * [GET] Transform array in HTML
 *
 * Example usage:
 *
```php
$arr = [ 'key'=>'value' ];
$att = [
'container' => 'ul',
'element' => 'li',
'key' => 'strong',
'value' => 'span',
];
$html = arrayToHTML( $arr, 0, 0, $att );

print( $html )
```
```html
<ul>
<li>
<strong>key</strong><span>value</span>
</li>
</ul>
```
 *
 * @subpackage 1-Utilities/ARRAY
 *
 * @param {array} arr Array to transform.
 * @param {int=} indent Indents in HTML code (default is 1).
 * @param {int=} block Array depth level to go though (default is 1).
 * @param {array=} cont Array containing tag settings (default is empty array).
 * @return {string} Array in form of formatted HTML.
 */
function arrayToHTML( $arr, $indent = 1, $block = 1, $cont = array(), $sort = -1 ){

    if( !$arr )
        return '';

    $att = array_merge( array(
        'container' => 'ul',
        'element' => 'li',
        'key' => 'strong',
        'value' => 'span',
    ), $cont );
    
    if( $sort === 0 && is_asso( $arr ) ) arsort( $arr );

    $html = '<' . $att['container'] . '>' . lbreak();

    foreach ($arr as $key => $value) {

        $html .= indent( $indent ) . '<' . $att['element'] . '>' . lbreak();
            $html .= indent( $indent + 1 ) . '<' . $att['key'] . ' style="width: 20%; display: inline-block;">';
                $html .= (string)$key;
            $html .= ': </' . $att['key'] . '>' . lbreak();

                if( is_array( $value ) && $block > 0 ){
                    $sub = array(
                        'container' => $att['container'] . ' class="sub" style="padding-left:' . $block . 'em;"',
                        'element' => $att['element'],
                        'key' => $att['key'],
                        'value' => $att['value'],
                    );

                    $html .= lbreak();
                    $html .= arrayToHTML( $value, $indent + 1, $block - 1, $sub, $sort - 1 );

                }else{
                    $html .= indent( $indent + 1 ) . '<' . $att['value'] . ' style="font-weight: normal;">';
                        if( !is_scalar($value) )
                            $html .= gettype( $value );
                        else
                            $html .= (string)$value;
                    $html .= '</' . $att['value'] . '>' . lbreak();
                }

        $html .= indent( $indent ) . '</' . $att['element'] . '>' . lbreak();
    }

    $html .= '</' . $att['container'] . '>' . lbreak(2);

    return $html;

}

// ------------------------------------------------------
// 5.0 HTML
// ------------------------------------------------------

/**
 * [GET|SET] Return or echo HTML indents
 *
 * @subpackage 1-Utilities/HTML
 *
 * @param {int=} indent Amount of indents (default is 1).
 * @param {string=} echo Appended to indents. Returns final string if empty (default is '').
 * @param {int=} break Amount of line breaks appended (default is 1). Not used if $echo is empty.
 * @return {string} If $echo is empty, otherwise the string is echoed.
 */
function indent( $indent = 1, $echo = '', $break = 1 ){
    $str = str_repeat( '    ' , $indent);

    if(!$echo) return $str;

    $str .= $echo;
    $str .= str_repeat( PHP_EOL , $break );
    echo $str;
}

/**
 * [GET] Return line breaks
 *
 * @subpackage 1-Utilities/HTML
 *
 * @param {int=} Amount of line breaks (default is 1).
 * @return {string} String containing line breaks.
 */
function lbreak( $break = 1 ){
    return str_repeat( PHP_EOL, $break );
}

/**
 * [GET] Get HTML Tag Content
 *
 * @subpackage 1-Utilities/HTML
 *
 * @param {string} string String (html) where to look for $tagname.
 * @param {string=} tagname HTML tag to look for (default is 'p').
 * @return {string} First HTML tag found in $string.
 */
function getTagContent( $string = '', $tagname = 'p' ){
    $pattern = "/<$tagname ?.*>(.*)<\/$tagname>/";
    preg_match($pattern, $string, $matches);
    return $matches[1]; // Shouldn't be [0]?
}

/**
 * [GET] Open new HTML tag
 *
 * @subpackage 1-Utilities/HTML
 *
 * @todo Integra data attributes per ogni elemento, con Select > Attributes
 *
 * @param {string=} string Tag to be opened (default is 'div').
 * @param {string=} id ID attribute (default is '').
 * @param {string=} class Class attribute (default is '').
 * @param {string=} style Style attribute (default is '').
 * @param {string=} attributes Data attributes (default is '').
 * @param {string=} href Href attribute (default is '').
 * @param {string=} target Target attribute (default is '').
 * @return {string} String containing opened tag.
 */
function openTag( $tag = 'div', $id = '', $class = '', $style = '', $attributes = '', $href = '', $target = '' ){

    $str = 'data-href="';
    $len = strlen( $str );
    $start = strpos( $attributes, 'data-href="' );

    if( $start !== false ){

        $url = substr( $attributes, $start + $len );
        $url = substr( $url, 0, strpos( $url, '"' ) );
        $attributes = str_replace( $url, getURL( $url ), $attributes);
    }

    return str_replace( array( ' " ', '=" ', '< ', ' >', ' ">' ), array( '" ', '="', '<', '>', '">' ), '<' . $tag . is( $href, '', ' href="', '"' ) . is( $target, '', ' target="', '"' ) . is( $id, '', ' id="', '"' ) . doublesp( is( $class, '', ' class="', '"' ) ) . is( $style, '', ' style="', '"' ) . is( $attributes ) . ( $tag === 'hr' ? ' /' : '' ) . '>' );
}

/**
 * [GET] Open new HTML div tag
 *
 * @subpackage 1-Utilities/HTML
 *
 * @param {string=} id ID attribute (default is '').
 * @param {string=} class Class attribute (default is '').
 * @param {string=} style Style attribute (default is '').
 * @param {string=} attributes Data attributes (default is '').
 * @return {string} String containing opened div tag.
 */
function openDiv( $id = '', $class = '', $style = '', $attributes = '' ){
    return getTag( 'div', $id, $class, $style, $attributes );
}

/**
 * [GET] Close HTML tag
 *
 * @subpackage 1-Utilities/HTML
 *
 * @param {string=} tag HTML tag (default is 'div').
 * @param {string=} app String to be appended (default is '').
 * @return {string} String containing closed tag.
 */
function closeTag( $tag = 'div', $app = '' ){
    return '</' . $tag . '>' . $app;
}

/**
 * [GET] Encode email address
 *
 * @subpackage 1-Utilities/HTML
 *
 * @param {string=} email Email address to be encoded (default is '').
 * @return {string} Encoded email address.
 */
function googleMapsLink( $address = '' ){
    return 'https://maps.google.com/?q=' . str_replace( ' ', '+', str_replace( ' - ', '+', str_replace( 'map:', '', doublesp( $address ) ) ) ) ;
}

/**
 * [GET] Encode email address
 *
 * @subpackage 1-Utilities/HTML
 *
 * @param {string=} email Email address to be encoded (default is '').
 * @return {string} Encoded email address.
 */
function encodeEmail( $email = '' ){
    return str_replace( '@', '()', str_replace( '.', ',', $email ) );
}

/**
 * [GET] Add http:// if a protocol doesn't exist
 *
 * @subpackage 1-Utilities/HTML
 *
 * @param {string=} url URL to check (default is '').
 * @return {string} Modified URL.
 */
function addHTTP( $url = '' ){
    if( !$url ) return '';
    if ( !preg_match( "~^(?:f|ht)tps?://~i", $url ) ) {
        $url = "http://" . $url;
    }
    return $url;
}

/**
 * [GET] Filter HREF
 *
 * @subpackage 1-Utilities/HTML
 *
 * @param {string=} type Link type [media|paypal|phone|fax|skype|skype-call|skype-phone|web] (default is 'web').
 * @param {string} link Link to be insered.
 * @param {bool} data Use data-href and data-target instead of href and target.
 * @return {string} HTML attributes.
 */
function getHREF( $type = 'web', $link, $data = false ){
    if( !$link )
        return '';

    $data = ( $data ? 'data-' : '' );

    switch ( $type ) {
        case 'media':
            return scm_utils_link_post( array(), $link );
        break;

        case 'paypal':
        break;

        case 'phone':
            return ' ' . $data . 'href="tel:+' . preg_replace( '/\D+/', '', $link ) . '" ' . $data . 'target="_blank"';
        break;

        case 'fax':
            return ' ' . $data . 'href="fax:+' . preg_replace( '/\D+/', '', $link ) . '" ' . $data . 'target="_blank"';
        break;

        case 'email':
            return ' ' . $data . 'href="mailto:' . encodeEmail( $link ) . '" ' . $data . 'target="_blank"';
        break;

        case 'skype':
            return ' ' . $data . 'href="skype:' . $link . '?chat" ' . $data . 'target="_blank"';
        break;

        case 'skype-call':
            return ' ' . $data . 'href="skype:' . $link . '?call" ' . $data . 'target="_blank"';
        break;

        case 'skype-phone':
            return ' ' . $data . 'href="callto://+' . $link . '" ' . $data . 'target="_blank"';
        break;

        case 'web':
            return ' ' . $data . 'href="' . getURL( $link ) . '" ' . $data . 'target="_blank"';
        break;

        case 'map':
            return ' ' . $data . 'href="' . googleMapsLink( $link ) . '" ' . $data . 'target="_blank"';
        break;

        default:
            return ' ' . $data . 'href="' . getURL( $link ) . '"';
        break;
    }
}

// ------------------------------------------------------
// 6.0 STYLE
// ------------------------------------------------------

/**
 * [GET] Converts a number to a style measure
 *
 * @subpackage 1-Utilities/STYLE
 *
 * @param {float} value Number to convert.
 * @return {string} Style measure in pixel (4 becomes '4px'), otherwise it returns style measure in percentage (-4 becomes'40%') if $value is negative.
 */
function numberToStyle( $value ){
    if( isset( $value ) ){
        if ($value < 0) {
            if ($value == -1) return '100%';
            else return (string)$value * -10 . '%';
        }else{
            return (string)$value . 'px';
        }
    }
    return '';
}

/**
 * [GET] Converts hexadecimal color into rgba color
 *
 * @subpackage 1-Utilities/STYLE
 *
 * @param {string=} hex Hexadecimal color (default is '').
 * @param {float=} alpha Alpha value (default is 1).
 * @param {bool=} toarr Returns an array (default is false).
 * @return {string|array} RGBA string in style format, otherwise it returns an array if $toarr is true. Returns 'transparent' if no $hex and 0 $alpha are supplied.
 */
function hex2rgba( $hex = '', $alpha = 1, $toarr = false ){

    if( $hex ){
        $hex = str_replace('#', '', $hex);

        if(strlen($hex) == 3) {
            $r = hexdec(substr($hex,0,1).substr($hex,0,1));
            $g = hexdec(substr($hex,1,1).substr($hex,1,1));
            $b = hexdec(substr($hex,2,1).substr($hex,2,1));
            $a = (float)$alpha;
        } else {
            $r = hexdec(substr($hex,0,2));
            $g = hexdec(substr($hex,2,2));
            $b = hexdec(substr($hex,4,2));
            $a = (float)$alpha;
        }

        $rgba = array($r, $g, $b, $a);

        if( !$toarr )
            return 'rgba(' . implode(",", $rgba) . ')'; // returns the rgb values separated by commas

        return $rgba; // returns an array with the rgba values
    }

    if( $alpha === 0 )
        return 'transparent';

    return '';
}

/**
 * [GET] Get webfont and family font as a correct string (just comma separated families, or css attribute ready)
 *
 * @subpackage 1-Utilities/STYLE
 *
 * @param {array=} webfont List of webfonts (default is empty array).
 * @param {string=} family Fallback font family (default is '').
 * @param {bool=} add Insert result into font-family attribute (default is false).
 * @return {string} List of formatted font families, optionally wrapped in font-family attribute.
 */
function font2string( $webfont = array(), $family = '', $add = false ) {

    global $SCM_libraries;

    $str = '';

    $webfont = toArray( $webfont );
    foreach ( $webfont as $font ) {
        if( $font && $font != 'no' && $font != 'default' ){
            $lib = $SCM_libraries['fonts'][$font];
            $str .= ( isset( $lib ) ? $lib['family'] : $font ) . ', ';
        }
    }

    $str .= ( $family ? str_replace( '_', ', ', $family ) : 'Helvetica, Arial, san-serif' );

    if( $add ){
        $str = 'font-family:' . $str . ';';
    }

    return str_replace( '"', '\'', $str );
}

/**
 * [GET] Set font-size based on amount of characters
 *
 * @subpackage 1-Utilities/STYLE
 *
 * @param {string} txt String to check
 * @param {array} char List of characters amounts [ num char, num char, ... ].
 * @param {array} size List of font size [ font-size, font-size, ... ].
 * @return {string} Font size in pixel wrapped in font-size attribute.
 */
function fontSizeLimiter( $txt, $char, $size ){
    $str = '';
    $lng = strlen( $txt );
    $char = toArray( $char );
    foreach ( toArray( $size ) as $key => $value ) {
        if( $lng > $char[$key] ) $str = 'font-size:' . $value . 'px;';
    }
    return $str;
}

// ------------------------------------------------------
// 7.0 FILE
// ------------------------------------------------------

/**
 * [GET] Get file date
 *
 * @subpackage 1-Utilities/FILE
 *
 * @param {string} uri File URI
 * @return {string} File date
 */
function filemtimeRemote( $uri ){
    $uri = parse_url( $uri );
    $handle = @fsockopen( $uri['host'], 80 );
    if(!$handle)
        return 0;

    fputs( $handle,"GET $uri[path] HTTP/1.1\r\nHost: $uri[host]\r\n\r\n" );
    $result = 0;
    while( !feof( $handle ) ){
        $line = fgets( $handle, 1024 );
        if( !trim( $line ) )
            break;

        $col = strpos( $line,':' );
        if ( $col !== false ) {
            $header = trim( substr( $line,0,$col ) );
            $value = trim( substr( $line,$col+1 ) );
            if ( strtolower( $header ) == 'last-modified' ) {
                $result = strtotime( $value );
                break;
            }
        }
    }
    fclose( $handle );
    return $result;
}

/**
 * [GET] Get file data
 *
 * @subpackage 1-Utilities/FILE
 *
 * @param {array|string} file Array containing 'url' attribute, or file url as string.
 * @param {string=} name New name (default is '').
 * @param {string=} date Date format (default is 'F d Y H:i:s').
 * @return {array} Empty array if fail, otherwise it returns a list of file data: link,URL,filename,name,modified,date,bytes,size,SIZE,extension,type,TYPE,icon.
 */
function fileExtend( $file, $name = '', $date = 'F d Y H:i:s'){

    if( !$file )
        return array();

    if( is_string( $file ) )
        $file = array( 'url' => $file );

    if( !is_array( $file ) )
        return array();

    if( !ex_attr($file, 'url', '') )
        return array();

    $file['link'] = $file['url'];
    $file['URL'] = str_replace( ' ', '%20', $file['link'] );
    $file['filename'] = basename( $file['link'] );
    $file['name'] = ( $name ?: $file['filename'] );

    $file['modified'] = ex_attr($file, 'modified', date( $date, filemtimeRemote( $file['URL'] ) ) );
    $file['date'] = ex_attr($file, 'date', $file['modified']);

    $ch = curl_init( $file['URL'] );
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_HEADER, TRUE);
    curl_setopt($ch, CURLOPT_NOBODY, TRUE);
    $data = curl_exec($ch);

    $file['bytes'] = curl_getinfo($ch, CURLINFO_CONTENT_LENGTH_DOWNLOAD);
    $file['SIZE'] = fileSizeConvert( $file['bytes'] );
    $file['extension'] = pathinfo( $file['filename'], PATHINFO_EXTENSION );
    $file['TYPE'] = fileExtensionConvert( $file['extension'] );

    curl_close($ch);

    $file['size'] = $file['SIZE'] . ' (' . $file['bytes'] . ' bytes)';
    $file['type'] = $file['TYPE'] . ' (' . $file['extension'] . ')';
    $file['icon'] = fileExtensionToIcon( $file['extension'] );

    return $file;
}

/** 
 * [GET] Converts bytes into human readable file size
 *
 * @subpackage 1-Utilities/FILE
 *
 * @param {float|string} bytes Bytes to convert.
 * @param {int=} dec Round decimal (default is 0).
 * @return {string} Human readable file size (2,87 МB).
 */ 
function fileSizeConvert($bytes, $dec = 0){
    $bytes = floatval( $bytes );
        $arBytes = array(
            0 => array(
                "UNIT" => "TB",
                "VALUE" => pow( 1024, 4 )
            ),
            1 => array(
                "UNIT" => "GB",
                "VALUE" => pow( 1024, 3 )
            ),
            2 => array(
                "UNIT" => "MB",
                "VALUE" => pow( 1024, 2 )
            ),
            3 => array(
                "UNIT" => "KB",
                "VALUE" => 1024
            ),
            4 => array(
                "UNIT" => "B",
                "VALUE" => 1
            ),
        );

    foreach ( $arBytes as $arItem ) {
        if ( $bytes >= $arItem[ 'VALUE' ] ) {
            $result = $bytes / $arItem[ 'VALUE' ];
            $result = str_replace( '.', ',', strval( round( $result, $dec ) ) ) . ' ' . $arItem[ 'UNIT' ];
            break;
        }
    }
    return $result;
}

/** 
 * [GET] Converts file extension to a general file type
 *
 * @subpackage 1-Utilities/FILE
 *
 * @param {string} ext Extension to convert.
 * @return {string} File type (i.e. 'doc' or 'txt' are converted to 'Text Document').
 */ 
function fileExtensionConvert( $ext ){

    $name = '';
    $ext = str_replace( '.', '', strtolower( $ext ) );

    switch( $ext ) {
        case 'jpg':
        case 'jpeg':
        case 'gif':
        case 'png':

            $name = __( 'Immagine', SCM_THEME );

        break;

        case 'ppt':
        case 'pptx':
        case 'keynote':

            $name = __( 'Presentazione', SCM_THEME );

        break;

        case 'doc':
        case 'docx':
        case 'pages':
        case 'txt':
        case 'rtf':

            $name = __( 'Documento di testo', SCM_THEME );

        break;

        case 'xls':
        case 'xlsx':
        case 'numbers':

            $name = __( 'Foglio di calcolo', SCM_THEME );

        break;

        case 'pdf':

            $name = __( 'Documento PDF', SCM_THEME );

        break;

        case 'zip':
        case 'rar':

            $name = __( 'Archivio compresso', SCM_THEME );

        break;

        case 'mov':
        case 'avi':
        case 'wmv':

            $name = __( 'File video', SCM_THEME );

        break;

        case 'mp3':
        case 'm4a':
        case 'aif':
        case 'aiff':
        case 'wav':
        case 'wma':

            $name = __( 'File audio', SCM_THEME );

        break;

        default:
            $name = __( 'File', SCM_THEME );
        break;
    }

    return $name;
}

/** 
 * [GET] Converts file extension to Font Awesome icon
 *
 * @subpackage 1-Utilities/FILE
 *
 * @param {string} ext Extension to convert.
 * @return {string} FA icon without 'fa-' prefix (i.e. 'jpg' or 'png' are converted to 'file-image-o').
 */ 
function fileExtensionToIcon( $ext ){

    $name = '';
    $ext = str_replace( '.', '', strtolower( $ext ) );

    switch( $ext ) {
        case 'jpg':
        case 'jpeg':
        case 'gif':
        case 'png':

            $name = 'file-image-o';

        break;

        case 'ppt':
        case 'pptx':
        case 'keynote':

            $name = 'file-powerpoint-o';

        break;

        case 'doc':
        case 'docx':
        case 'pages':

            $name = 'file-word-o';

        break;

        case 'txt':
        case 'rtf':

            $name = 'file-text-o';

        break;

        case 'xls':
        case 'xlsx':
        case 'numbers':

            $name = 'file-excel-o';

        break;

        case 'pdf':

            $name = 'file-pdf-o';

        break;

        case 'zip':
        case 'rar':

            $name = 'file-archive-o';

        break;

        case 'mov':
        case 'avi':
        case 'wmv':

            $name = 'file-video-o';

        break;

        case 'mp3':
        case 'm4a':
        case 'aif':
        case 'aiff':
        case 'wav':
        case 'wma':

            $name = 'file-audio-o';

        break;

        default:
            $name = 'file-o';
        break;
    }

    return $name;
}

// ------------------------------------------------------
// 8.0 SVG
// ------------------------------------------------------

/**
 * [SET] Create SVG line
 *
 * @subpackage 1-Utilities/SVG
 *
 * @param {array=} attr Attributes (default is empty array).
 * @param {string=} type Line type (default is 'solid').
 * @param {int=} indent Indents (default is 0).
 */
function svgLine( $attr = array(), $type = 'solid', $indent = 0 ) {

    $default = array(
        'width' => '100%',
        'height' => '',
        'x1' => '',
        'x2' => '100%',
        'y1' => '',
        'y2' => '',
        'color' => '#ddd',
        'stroke' => '1',
        'cap' => 'butt',
        'space' => '19',
        'dash' => '0.1',
    );

    $attr = array_merge( $default, $attr );
    $type = str_replace( 'line', 'solid', $type );

    $attr['height'] = ( $attr['height'] ?: $attr['stroke'] );
    $attr['y1'] = ( $attr['y1'] ?: (int)$attr['stroke'] * .5 );
    $attr['y2'] = ( $attr['y2'] ?: (int)$attr['stroke'] * .5 );
    $attr['x1'] = ( $attr['x1'] ?: ( $attr['cap'] == 'butt' ? '0' : (int)$attr['stroke'] * .5 ) );
    $attr['dash'] = ( $type == 'dotted' ? $attr['stroke'] : $attr['dash'] );

    indent( $indent + 1, '<svg width="' . $attr['width'] . '" height="' . $attr['height'] . '">', 1 );
    if( $type == 'solid' )
        indent( $indent + 2, '<line x1="' . $attr['x1'] . '" x2="' . $attr['x2'] . '" y1="' . $attr['y1'] . '" y2="' . $attr['y2'] . '" stroke="' . $attr['color'] . '" stroke-width="' . $attr['stroke'] . '" stroke-linecap="' . $attr['cap'] . '"></line>', 1 );
    else
        indent( $indent + 2, '<line x1="' . $attr['x1'] . '" x2="' . $attr['x2'] . '" y1="' . $attr['y1'] . '" y2="' . $attr['y2'] . '" stroke="' . $attr['color'] . '" stroke-width="' . $attr['stroke'] . '" stroke-linecap="' . $attr['cap'] . '" stroke-dasharray="' . $attr['dash'] . ', ' . $attr['space'] . '"></line>', 1 );
    indent( $indent + 1, '</svg>', 2 );
}

// ------------------------------------------------------
// 9.0 DATE and TIME
// ------------------------------------------------------

function dayDiff( $old, $new, $ext = false ) {
    if( $ext ){
        $datetime1 = new DateTime( date( 'm/d/Y', $old ) );
        $datetime2 = new DateTime( date( 'm/d/Y', $new ) );
        $diff = $datetime1->diff($datetime2);
        $y = $diff->y;
        $m = $diff->m;
        $d = $diff->d;
        $yy = ( $y === 1 ? 'year' : 'years' );
        $mm = ( $m === 1 ? 'month' : 'months' );
        $dd = ( $d === 1 ? 'day' : 'days' );
        return ( $y ? $y . ' ' . $yy . ( $m || $d ? ', ' : '' ) : '' ) . ( $m ? $m . ' ' . $mm . ( $d ? ', ' : '' ) : '' ) . ( $d ? $d . ' ' . $dd : '' );
        
    }
    return floor( $new - $old / (60 * 60 * 24) );
}

function timeToSec($time) {
    $sec = 0;
    foreach (array_reverse(explode(':', $time)) as $k => $v) $sec += pow(60, $k) * $v;
    return $sec;
}

?>