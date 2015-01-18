<?php

// ***************************************
// *                                     *
// * SCM Functions                       *
// *                                     *
// ***************************************
//
// Useful General Functions
//
// thePost:             get current id, post, type, slug and title
// printPre:            <pre>print_r(%array)</pre>
// alert:               JS alert - second parameter will be merged to the first one, separated by the third one (default ': ')
// getByValue:          get array by $value
// getByValueKey:       get array by $value and $key
// getByKey:            get array by $key       (exact $key)
// getAllByKey:         get arrays by $key      (exact $key)
// getByString:         get array by $string    (contains $string)
// getAllByString:      get arrays by $string   (contains $string)
// getByPrefix:         get array by $prefix    (starts with $prefix)
// getAllByPrefix:      get arrays by $prefix   (starts with $prefix)
// addHTTP:             add http:// to a link
// fontSizeLimiter:     add font-size based on #characters
// getGoogleMapsLatLng: get GM Lat and Lng from an address (es. "Address+Country+State")
// getYouTubeDuration:  get YT video duration (00:06:13)
// fileSizeConvert:     convert bytes to B, KB, MB, GB, TB
// numberToStyle:       convert a positive number to a string like "450px"
//                      convert a negative number to a string like "20%" ( -1 = "100%" | -2, -3, -11, ... = "20%", "30%", "110%", ...)
// hex2rgba:            converts a hexadecimal color to an array containing rgba values
// font2string:         converts an optional google webfont (eg Open Sans) + an optional default family list to comma separated string (add css font-family attribute if a third argument is true)
//
//


/**
* Get current Id, Post, Type and Slug ('id' => %int, 'post' => %object, 'type' => %string, 'slug' => %string, 'title' => %string)
* @param string $key name of the property to be returned (optional)
* @author SCM
*/

function thePost($key=null){
    $id = null;
    $req = isset($_REQUEST['post_id']) ? $_REQUEST['post_id'] : '';
    //$req = $_REQUEST['post_id'];
    if ($req) {
        $id = (int)$req;
    }else{
        $id = $req;
    }
    $is = 'post';
    if(!$id){
        $id = get_the_ID();
        $ispost = 0;
    }
    if($id && is_numeric($id)){
        $type = get_post_type( $id );
        $the_post = get_post( $id );  
        $slug = $the_post->post_name;
        $title = $the_post->post_title;
        $tax = get_query_var( 'taxonomy' );
        $term = get_query_var( 'term' );

        $a = array('id' => $id, 'post' => $the_post, 'type' => $type, 'slug' => $slug, 'taxonomy' => $tax, 'term' => $term, 'title' => $title);
        if(!$key) return $a;
        else return $a[$key];
    }
    return null;
}

/**
* Print an array into a <pre>
* @param array $arr
* @author SCM
*/

function printPre( $arr ){
    echo '<pre>';
    print_r($arr);
    echo '</pre>';
}

function alert( $str, $more = '', $divider = ': ' ){
    if( !$more )
        $divider = '';
    echo '<script>alert("' . $str . $divider . $more . '");</script>';
}

/**
* Get Element by Key
* @param array $arr the array where to search for
* @param string $key the key to be checked
* @author SCM
*/

function getByKey( $arr, $key ){
    foreach ($arr as $k => $v) {
        if( $k == $key ) return $v;
    }
    return null;
}

/**
* Get Elements by Key
* @param array $arr the array where to search for
* @param string $key the key to be checked
* @author SCM
*/

function getAllByKey( $arr, $key ){
    $arr = array();
    foreach ($arr as $k => $v) {
        if( $k == $key ) $arr[] = $v;
    }
    return array();
}

/**
* Get Element by String
* @param array $arr the array where to search for
* @param string $string the string to be checked
* @param boolean $key returns $key if true. Default is false and returns $value.
* @author SCM
*/

function getByString( $arr, $string, $key = false ){
    foreach ($arr as $k => $v) {
        if( strpos($k, $string) !== false ){
            if( $key ) return $k;
            return $v;
        }
    }
    return null;
}

/**
* Get Elements by String
* @param array $arr the array where to search for
* @param string $string the string to be checked
* @param boolean $key returns $key if true. Default is false and returns $value.
* @author SCM
*/

function getAllByString( $arr, $string, $key = false ){
    $arr = array();
    foreach ($arr as $k => $v) {
        if( strpos($k, $string) !== false ) $arr[] = $v;
    }
    return array();
}

/**
* Get Element by Prefix
* @param array $arr the array where to search for
* @param string $prefix the prefix to be checked
* @param boolean $key returns $key if true. Default is false and returns $value.
* @author SCM
*/

function getByPrefix( $arr, $prefix, $key = false, $exist = true ){
    foreach ($arr as $k => $v) {
        if( strpos($k, $prefix) === 0 ){
            if( $key ){
                if ( ( $v && $exist ) || !$exist )
                    return $k;
            }else{
                return $v;
            }
        }
    }
    return null;
}

/**
* Get Elements by Prefix
* @param array $arr the array where to search for
* @param string $prefix the prefix to be checked
* @param boolean $key returns $key if true. Default is false and returns $value.
* @author SCM
*/

function getAllByPrefix( $arr, $prefix, $key = false ){
    $arr = array();
    foreach ($arr as $k => $v) {
        if( strpos($k, $prefix) === 0 ){
            if( $key ) $arr[] = $k;
            else $arr[] = $v;
        }
    }
    return $arr;
}

/**
* Get Element by Value and Key
* @param array $arr the array where to search for
* @param string $value the value to be checked
* @param string $key the key to be searched for (default = 'name')
* @author SCM
*/

function getByValueKey( $arr, $value, $key = 'name' ){
    foreach ($arr as $index => $elem) {
        if( $elem[$key] == $value ) return $index;
    }
    return null;
}

/**
* Get Element by Value
* @param array $arr the array where to search for
* @param string $value the value to be checked
* @author SCM
*/

function getByValue($arr, $value){
    foreach ($arr as $key => $elem) {
        if( $elem == $value ) return $key;
    }
    return -1;
}


/**
* Add http:// if doesn't exist in $url
* @param string $url URL to check
* @author SCM
*/

function addHTTP($url){
    if(!$url) return;
    if($url == 'localhost') return 'http://localhost:8888/_scm'; //$GLOBALS['localhost'];
    if (!preg_match("~^(?:f|ht)tps?://~i", $url)) {
        $url = "http://" . $url;
    }
    return $url;
}


/**
* Set the font-size based on number of characters
* @param string $txt string to check
* @param array $char {num char, num char, ...}
* @param array $size {font-size, font-size, ...}
* @return string font-size: %n px
* @author SCM
*/

function fontSizeLimiter($txt, $char, $size){
	$str = '';
	$lng = strlen($txt);
	foreach ($size as $key => $value) {
		if($lng > $char[$key]) $str = 'font-size:' . $value . 'px;';
	}
	return $str;
}

/**
* Get Latitude and Longitude from an address string (es. "Address+Country+State")
*/

function getGoogleMapsLatLng($address, $country){

    $google_address = str_replace('  ', '+', $address);
    $google_address = str_replace(' ', '+', $google_address);

    $json = wp_remote_fopen("http://maps.google.com/maps/api/geocode/json?address=$google_address&sensor=false&region=$country");
    $json = json_decode($json);

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

/** 
* Converts bytes into human readable file size. 
* 
* @param string $bytes 
* @return string human readable file size (2,87 МB)
* @author Mogilev Arseny 
*/ 
function fileSizeConvert($bytes, $dec = 0)
{
    $bytes = floatval($bytes);
        $arBytes = array(
            0 => array(
                "UNIT" => "TB",
                "VALUE" => pow(1024, 4)
            ),
            1 => array(
                "UNIT" => "GB",
                "VALUE" => pow(1024, 3)
            ),
            2 => array(
                "UNIT" => "MB",
                "VALUE" => pow(1024, 2)
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

    foreach($arBytes as $arItem)
    {
        if($bytes >= $arItem["VALUE"])
        {
            $result = $bytes / $arItem["VALUE"];
            $result = str_replace(".", "," , strval(round($result, $dec)))." ".$arItem["UNIT"];
            $result = $result;
            break;
        }
    }
    return $result;
}

/**
* Converts a number to a string "450px" if positive or "100%" if negative
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
* Converts a hexadecimal color to a rgba array
*/

function hex2rgba( $hex, $alpha = 1, $toarr = false ){

    $hex = str_replace("#", "", $hex);

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

    //Get Webfont + Family Font as a correct String (just comma separated families, or css attribute ready)
    if ( ! function_exists( 'font2string' ) ) {
        function font2string($webfont = '', $family = 'default', $add = false) {

            $webfont = ( ( $webfont && $webfont != 'no' && $webfont != 'default' ) ? $webfont : '' );
            $family = ( $family != 'default' ? str_replace( '_', ', ', $family ) : 'Helvetica, Arial, san-serif' );
            $font = ( $webfont ? $webfont . ( $family ? ', ' : '' ) : '' ) . $family;
            if( $add ){
                $font = 'font-family:' . $font . ';';
            }

            return str_replace( '"', '\'', $font );
        }
    }



?>