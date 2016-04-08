<?php
/**
 * @package SCM
 */

// *****************************************************
// *    SCM WORDPRESS FUNCTIONS
// *****************************************************

// updatePostMeta:      update, insert or delete post $id $meta with $value
// getGoogleMapsLatLng: get GM Lat and Lng from an address (es. "Address+Country+State")
// getYouTubeDuration:  get YT video duration (00:06:13)
// ...


function resetRoles() {
    remove_role('editor');
    remove_role('author');
    remove_role('contributor');
    remove_role('subscriber');
    remove_role('staff');
    remove_role('member');
    remove_role('utente');
}

function redirectUser( $user = '' ) {
    
    global $SCM_capability;

    $user = ( $user ?: $SCM_capability );
    
    if( $user == 'super' )
        return admin_url('themes.php?page=scm-install-plugins');
    elseif( $user == 'admin' )
        return admin_url('admin.php?page=scm-options-intro');
    elseif( $user == 'staff' )
        return admin_url('users.php');
    
    return home_url();

}
   
function checkTaxes( $type = '' ) {
    return ( delArray( get_object_taxonomies( $type ), array( 'language', 'post_translations' ) ) ?: array() );
}


function isLoginPage() {

    return in_array($GLOBALS['pagenow'], array('wp-login.php', 'wp-register.php'));
    
}

function getURL( $url ){

    if( !$url )
        return;

    $add = '';

    if( $url == 'localhost' )
        return 'http://localhost:8888/_scm'; //$GLOBALS['localhost'];

    if( startsWith( $url, array( 'page:' ) ) !== false || startsWith( $url, array( 'page/' ) ) !== false || startsWith( $url, array( 'http://page/', 'https://page/' ) ) !== false ){

        $url = str_replace( array( 'page:', 'page/', 'http://', 'https://' ), '', $url );
        
        if( strpos( $url, '#' ) === 0 ){
            $add = $url;
            $url = str_replace( '#', '', $url);
            $url = substr( $url, 0, rstrpos( $url, '-' ) );
        }

        if( !is_numeric( $url ) )
            $url = get_page_by_path( $url )->ID;

        $page = get_page_link( $url );

        if( $page === get_the_permalink() )
            return $add;
        
        return $page . $add;
    }

    if( startsWith( $url, array( 'logout:', 'http://logout:', 'https://logout:' ) ) ) {
        $url = str_replace( array( 'logout:', 'http://logout:', 'https://logout:'), '', $url );
        $url = ( $url ?: site_url() );
        return wp_logout_url( $url );
    }

    if( startsWith( $url, array( 'skype:', 'mailto:', 'tel:', 'callto:', 'fax:' ) ) !== false )
        return $url;

    if( strpos( $url, '@' ) !== false )
        
        return 'mailto:' . $url;

    if ( is_numeric( $url ) ){

        if( !startsWith( $url, '+' ) !== false )
            return 'tel:+' . $url;

        return 'tel:' . $url;

    }

    str_replace( array( 'http://#', 'https://#' ), '#', $url);

    if ( !startsWith( $url, '#' ) && !preg_match( '~^(?:f|ht)tps?://~i', $url ) )
        return addHTTP( $url );

    return $url;
}


// updatePostMeta:      update, insert or delete post $id $meta with $value

function updatePostMeta( $id, $meta, $value = '' ){

    if ( empty( $value ) OR ! $value ){

        delete_post_meta( $id, $meta );

    }elseif ( ! get_post_meta( $id, $meta ) ){

        add_post_meta( $id, $meta, $value );

    }else{

        update_post_meta( $id, $meta, $value );

    }
    
}

/**
* Get Latitude and Longitude from an address string (es. "Address+Country+State")
*/

function getGoogleMapsLatLng($address = '', $country = ''){

    if( str_replace(' ', '', $address) === '' ){
        $address = 'Roma';
        if( !$country )
            $country = 'Italy';
    }

    $google_address = str_replace('  ', '+', $address);
    $google_address = str_replace(' ', '+', $google_address);



    $json = wp_remote_fopen("http://maps.google.com/maps/api/geocode/json?key=AIzaSyBZEApCxfzuavDWXdJ2DAVAftxbMjZWrVY?address=$google_address&sensor=false&region=$country");
    $json = json_decode($json);
    consoleLog($json);

    $ret = array(
        'lat'   => $json->{'results'}[0]->{'geometry'}->{'location'}->{'lat'},
        'lng'   => $json->{'results'}[0]->{'geometry'}->{'location'}->{'lng'},
    );

    return $ret;
}


/**
* Get the Duration of a YouTube Video from a URL
*/

function getYouTubeDuration($url){

    parse_str(parse_url($url,PHP_URL_QUERY),$arr);
    $video_id=$arr['v'];
    if(!$video_id)
        $video_id = $arr['amp;v'];
    if(!$video_id)
        return '';

    $data=wp_remote_fopen('http://gdata.youtube.com/feeds/api/videos/'.$video_id.'?v=2&alt=jsonc');
    if (false===$data) return false;

    $obj=json_decode($data);

    return $obj->data->duration;
}


    /* ***********************************************************************
    *   Written 7 June 2012 by Mason Fabel
    *  Revised 8 June 2012 by David Lim
    *  Revised 19 June 2014 by David Lim for Google Spreadsheets V3 API
    *
    *  V2 Description
    *   This function takes a url in the form:
    *   http://spreadsheets.google.com/feeds/cells/$KEY/1/public/values
    *   where $KEY is the key given to the published version of the
    *   spreadsheet.
    *
    *   To publish a spreadsheet in Google Drive (2012), open the
    *   spreadsheet. Under 'file', select 'Publish to the web...'
    *   The key will be a part of the GET portion of the URL listed
    * at the bottom of the dialog box (https://....?key=$KEY&...)
    *
    *   This function returns a multidimensional array in the form:
    *   $array[$row][$col] = $content
    *   where $row is a number and $col is a letter.
    *
    * Limitations
    * This only works for one sheet
    ************************************************************************ */
    /* Get a google spreadsheet and return its contents as an array */
    function google_spreadsheet_to_array($key) {
        // initialize URL
            $url = 'http://spreadsheets.google.com/feeds/cells/' . $key . '/1/public/values';
        // initialize curl
            $curl = curl_init();
        // set curl options
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_HEADER, 0);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
        // get the spreadsheet using curl
            $google_sheet = curl_exec($curl);
        // close the curl connection
            curl_close($curl);
        // import the xml file into a SimpleXML object
            $feed = new SimpleXMLElement($google_sheet);
        // get every entry (cell) from the xml object
            // extract the column and row from the cell's title
            // e.g. A1 becomes [1][A]
            $array = array();
            foreach ($feed->entry as $entry) {
                $location = (string) $entry->title;
                preg_match('/(?P<column>[A-Z]+)(?P<row>[0-9]+)/', $location, $matches);
            $array[$matches['row']][$matches['column']] = (string) $entry->content;
            }
        // return the array
        return $array;
    }
    /*
        Get a google spreadsheet and return its contents as an array
        For version 3.0 of the Google Spreadsheet API, this requires the spreadsheet worksheet
        to be published as a web page. This function will parse through the generated HTML table
        to extract spreadsheet contents.
        This is because API v3 requires authentication and we don't want to put credentials in code.
    */
    function google_spreadsheet_to_array_v3($url=NULL) {
        // make sure we have a URL
            if (is_null($url)) {
                return array();
            }
        // initialize curl
            $curl = curl_init();
        // set curl options
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_HEADER, 0);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
        // get the spreadsheet data using curl
            $google_sheet = curl_exec($curl);
        // close the curl connection
            curl_close($curl);
        // parse out just the html table
            preg_match('/(<table[^>]+>)(.+)(<\/table>)/', $google_sheet, $matches);
            $data = $matches['0'];
        // Convert the HTML into array (by converting into HTML, then JSON, then PHP array
            $cells_xml = new SimpleXMLElement($data);
            $cells_json = json_encode($cells_xml);
            $cells = json_decode($cells_json, TRUE);
        // Create the array
            $array = array();
            foreach ($cells['tbody']['tr'] as $row_number=>$row_data) {
                $column_name = 'A';
                foreach ($row_data['td'] as $column_index=>$column) {
                    $array[($row_number+1)][$column_name++] = $column;
                }
            }
        return $array;
    }

    function readCSV($csvFile){
        $file_handle = fopen($csvFile, 'r');
        while (!feof($file_handle) ) {
            $line_of_text[] = fgetcsv($file_handle, 1024);
        }
        fclose($file_handle);
        return $line_of_text;
    }


?>