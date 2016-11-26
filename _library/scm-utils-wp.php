<?php

/**
 * SCM WORDPRESS utilities.
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

// ------------------------------------------------------

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

function getPosts( $type = 'post', $status = 'any', $lang = '' ){
    $posts = get_posts(array(
        'post_type' => $type,
        'posts_per_page' => -1,
        'post_status' => $status,
        'lang' => $lang,
    ));

    if( empty($posts) ) return 0;
    return $posts;
}

function getPost( $slug = '', $type = 'post', $status = 'any', $lang = '' ){

    $posts = get_posts( array(
        'post_type' => $type,
        'name' => $slug,
        'posts_per_page' => 1,
        'post_status' => $status,
        'lang' => $lang,
    ));

    if( empty($posts) ) return 0;
    return $posts[0];
}

/**
* Determine if a post exists based on post_name and post_type
*
* @param {string=} post_name Unique post name (defaults is ''). 
* @param {string=} post_type Post type (defaults is '').
*/
/*function postExists( $post_name = '', $post_type = '' ) {
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
}*/


/**
 * [GET] Get Custom Posts from $wpdb
 *
 * @subpackage 1-Utilities/WPDB
 *
 * @param {string=} type Custom Post Type (default is '').
 * @return {array} Query posts list.
 */
/*function customPosts( $type = '', $status = 'any', $lang = '' ){
    if( !$type ) return $array();
    
    $args = array(
        'post_type' => $type,
        'posts_per_page' => -1,
        'post_status' => 'any',
        'lang' => '',
    );
    $posts = new WP_Query( $args );
    return $posts->posts;
}*/

// ------------------------------------------------------

function attachmentBySlug( $slug = '' ) {
    if( !$slug ) return 0;
    return getPost( trim( $slug ), 'attachment' );
}

function attachmentByFilename( $filename = '' ) {
    if( !$filename ) return 0;
    global $wpdb;
    $slug = sanitize_title( preg_replace( '/\.[^.]+$/', '', $filename ) );
    $posts = $wpdb->get_results( "SELECT * FROM $wpdb->posts WHERE post_name = '$slug' AND post_type = 'attachment' ", OBJECT );
    return ex_index( $posts, 0, 0);
    //return getPost( sanitize_title( preg_replace( '/\.[^.]+$/', '', $filename ) ), 'attachment' );
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
function attachmentFromURL( $path = '', $postid = 0, $echo = false, $debug = 0 ) {

    $attachment_id = 0;
    
    if( !$path ) return $attachment_id;

    $filename = basename($path);
    $exist = attachmentByFilename( $filename );
    $debug = (int)$debug;

    if( $exist ){

        if( $echo ) echo 'File Name Already Exists: ' . $filename;
        if( $debug > 1 ) consoleLog( $filename . ' EXISTS' );
        $attachment_id = $exist->ID;
        if( !$exist->post_parent ){
            consoleLog( $filename . ' LINKED TO PARENT ' . $postid );
            if( !$debug ){
                $attachment = array(
                    'ID' => $attachment_id,
                    'post_parent' => $postid,
                );
                $attachment_id = wp_update_post( $attachment );
            }
        }

    }else{

        if( $echo ) echo 'File Name: ' . $filename;

        consoleLog( $filename . ' NOT EXISTS' );

        if( !$debug ){

            $new_post = ( $postid ? get_post( $postid ) : array() );
            
            if( !empty( $new_post ) ){
                global $post;
                $post = $new_post;
                setup_postdata( $post );
            }

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

            if( !empty( $new_post ) ) wp_reset_postdata();
        }

        
    }
    
    if( $echo ) echo '<br>';

    return $attachment_id;

}

// ------------------------------------------------------

function postBySlug( $slug = '', $type = 'post', $status = 'any', $lang = '' ){
    if( !$slug ) return 0;
    return getPost( $slug, $type, $status, $lang );
}

function resetSlugs( $type = 'post', $status = 'any', $lang = '' ){

    $posts = getPosts( $type, $status, $lang );
    if( !$posts ) return;

    foreach ($posts as $value) {
        resetSlug( $value );
    }
}

function resetSlug( $post = 0 ){

    if( !$post ) return;

    $slug = $post->post_name;
    $new_slug = sanitize_title( $post->post_title );
    if( $slug != $new_slug ){
        wp_update_post( array(
            'ID' => $post->ID,
            'post_name' => ''
        ));
    }
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
    switch( $type ){
        case 'page':
            return ( !$link ? getURL( 'page:' . SCM_PAGE_ID ) : ( is_int( $link ) || ( (int)$link > 1 ) ? getURL( 'page:' . $link ) : $link ) );
        break;

        case 'admin':
            return ( $link ? site_url( '/wp-admin/' . $link ) : site_url('/wp-admin/users.php') );
        break;

        case 'self':
            return get_permalink();
        break;
        
        default:
            return ( $link ?: site_url( '/wp-admin/users.php' ) );
        break;
    }        
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

?>