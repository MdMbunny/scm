<?php
/**
 * @package SCM
 */

// *****************************************************
// *    SCM FUNCTIONS
// *****************************************************

//
// Useful PHP Functions
//
// thePost:             get current id, post, type, slug and title
// printPre:            <pre>print_r(%array)</pre>
// alert:               JS alert - second parameter will be merged to the first one, separated by the third one (default ': ')
// consoleLog:          JS console.log
// is
// exists
// ifExists
// equal
// ifnotequal
// isNumber
// toArray
// copyArray
// openTag
// openDiv
// stringOperator       evalues 2 strings by a string operator
// startsWith           return true if string starts with $needle
// endsWith             return true if string ends with $needle
// getByValue:          get array by $value
// getByValueKey:       get array by $value and $key
// getByKey:            get array by $key       (exact $key)
// getAllByKey:         get arrays by $key      (exact $key)
// getByString:         get array by $string    (contains $string)
// getAllByString:      get arrays by $string   (contains $string)
// getByPrefix:         get array by $prefix    (starts with $prefix)
// getAllByPrefix:      get arrays by $prefix   (starts with $prefix)
// getTagContent:       get the content of a HTML tag
// indent:              return or echo n tab indent ( add optional line break )
// lbreak:              return n line break
// addHTTP:             add http:// to a link
// fontSizeLimiter:     add font-size based on #characters
// fileSizeConvert:     convert bytes to B, KB, MB, GB, TB
// numberToStyle:       convert a positive number to a string like "450px"
//                      convert a negative number to a string like "20%" ( -1 = "100%" | -2, -3, -11, ... = "20%", "30%", "110%", ...)
// hex2rgba:            converts a hexadecimal color to an array containing rgba values
// font2string:         converts an optional google webfont (eg Open Sans) + an optional default family list to comma separated string (add css font-family attribute if a third argument is true)

// Wordpress Functions

// updatePostMeta:      update, insert or delete post $id $meta with $value
// getGoogleMapsLatLng: get GM Lat and Lng from an address (es. "Address+Country+State")
// getYouTubeDuration:  get YT video duration (00:06:13)


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

function consoleLog( $obj ){
    ?>
    <script type='text/javascript'>
        console.log( <?php echo json_encode( $obj ); ?> );
    </script>
    <?php
}




function exists( $var = '' ){

    return $var || $var === 0 ;

}

// NO: '', 0, array(]
function is( $var = '', $fall = '', $pre = '', $app = '' ){

    if( !$var )
        return $fall;
        //return ( $fall ? ( is_string( $fall ) ? $pre . $fall . $app : ( is_numeric( $fall ) ? (int)$pre + $fall - (int)$app : $fall ) ) : '' );

    return ( is_string( $var ) ? $pre . $var . $app : ( is_numeric( $var ) ? (int)$pre + $var - (int)$app : $var ) );

}

// NO: '', array(] - SI: 0
function ifexists( $var = '', $fall = '', $pre = '', $app = '' ){

    if( !exists( $var ) )
        return $fall;
        //return ( $fall ? ( is_string( $fall ) ? $pre . $fall . $app : ( is_numeric( $fall ) ? (int)$pre + $fall - (int)$app : $fall ) ) : '' );

    return ( is_string( $var ) ? $pre . $var . $app : ( is_numeric( $var ) ? (int)$pre + $var - (int)$app : $var ) );

}

function isNumber( $var = '', $fall = '', $pre = 0, $app = 0 ){

    if( !exists( $var ) || !is_numeric( $var ) )
        return $fall;
        //return ( exists( $fall ) && is_numeric( $fall ) ? (int)$pre + $fall - (int)$app : 0 );

    return (int)$pre + $var - (int)$app;

}

function ifequal( $var = '', $equal = array(), $fall = '', $pre = '', $app = ''  ){

    if( !$var )
        return '';

    $equal = toArray( $equal );
    foreach ( $equal as $cond ) {
        if( $var === $cond )
            return ( is_string( $var ) ? $pre . $var . $app : ( is_numeric( $var ) ? (int)$pre + $var - (int)$app : $var ) );
    }

    return $fall;
    //return ( is( $fall ) ? ( is_string( $fall ) ? $pre . $fall . $app : ( is_numeric( $fall ) ? (int)$pre + $fall - (int)$app : $fall ) ) : '' );
    
}

function ifnotequal( $var = '', $equal = array(), $fall = '', $pre = '', $app = ''  ){

    if( !$var )
        return '';

    $equal = toArray( $equal );
    foreach ( $equal as $cond ) {
        if( $var === $cond )
            return $fall;
            //return ( is( $fall ) ? ( is_string( $fall ) ? $pre . $fall . $app : ( is_numeric( $fall ) ? (int)$pre + $fall - (int)$app : $fall ) ) : '' );
    }

    //return $fall;
    return ( is_string( $var ) ? $pre . $var . $app : ( is_numeric( $var ) ? (int)$pre + $var - (int)$app : $var ) );
}




function is_asso( $arr ){

    if( !is_array( $var ) )
        return null;

    foreach( array_keys( $arr ) as $key){    
        if ( !is_int( $key ) ) return true;
    }
    
    return false;
}

function toArray( $var, $asso ){

    if( !$asso )
        return ( is_array( $var ) ? $var : array( $var ) );
    else
        return ( is_asso( $var ) ? $var : array( $var ) );

}


function copyArray( $arr ){
    if( !isset( $arr ) || gettype( $arr ) != 'array' )
        return array();

    $new = array();

    foreach ( $arr as $k => $v ) {
        $new[$k] = clone $v;
    }

    return $new;
}




function openTag( $tag = 'div', $id = '', $class = '', $style = '', $attributes = '', $href = '', $target = '' ){

    // +++ todo: leva sta roba e integra la field Attributes per ogni elemento, con Select > Attributes, e tutte cose

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

function openDiv( $id = '', $class = '', $style = '', $attributes = '' ){

    return getTag( 'div', $id, $class, $style, $attributes );

}

function closeTag( $tag = 'div', $app = '' ){

    return '</' . $tag . '>' . $app;

}




function doublesp( $str = '' ){
    if( !$str )
        return '';
    return preg_replace( '/\s+/', ' ', $str );

}





/**
* Evalues 2 strings by a string operator
* @param misc $a
* @param string $op
* @param misc $b
* @return boolean
* @author SCM
*/
function stringOperator($a = '', $op = '==', $b = '') {

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
    }

    return false;
}


/**
* String Starts With
* @param string $str
* @param string $needle
* @return boolean
* @author SCM
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
* String Ends With
* @param string $str
* @param string $needle
* @return boolean
* @author SCM
*/
function endsWith($str, $needle) { // CHE CAZZO HAI FATTO?

    if( !is_string( $str ) )
        return false;

    return $needle === "" || (($temp = strlen($str) - strlen($needle)) >= 0 && strpos($str, $needle, $temp) !== FALSE);

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
    return false;
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
    return false;
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
    return false;
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
* Get HTML Tag Content
* @param string $string the string (html) where to search for $tagname
* @param string $tagname the html tag in $string where to search for content
* @author SCM
*/

function getTagContent( $string = '', $tagname = 'p' ){
    $pattern = "/<$tagname ?.*>(.*)<\/$tagname>/";
    preg_match($pattern, $string, $matches);
    return $matches[1];
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
        if( isset( $elem[$key] ) && $elem[$key] == $value ) return $index;
    }
    return false;
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
    return false;
}


/**
* Return $indent tab indents if one or none (=1) arguments are passed
* Echo $indent tab indents + $eco + $break line breaks
* @param int $indent number of tab indents
* @param string $eco string to be echoed
* @param int $break number of line breaks
* @author SCM
*/

function indent( $indent = 1, $eco = '', $break = 1 ){
    $str = str_repeat( '    ' , $indent);
    
    if(!$eco) return $str;
    
    $str .= $eco;

    $str .= str_repeat( PHP_EOL , $break );
    
    echo $str;
}

/**
* Return $break line breaks
* @param int $break number of line breaks, default = 1
* @author SCM
*/

function lbreak( $break = 1 ){
    return str_repeat( PHP_EOL, $break );
}


/**
* Add http:// if doesn't exist in $url
* @param string $url URL to check
* @author SCM
*/

function addHTTP($url){
    if(!$url) return;
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

    //Get Webfont + Family Font as a correct String (just comma separated families, or css attribute ready)
    if ( ! function_exists( 'font2string' ) ) {
        function font2string($webfont = array(), $family = 'default', $add = false) {

            $str = '';

            toArray( $webfont );
            foreach ( $webfont as $font ) {
                $str .= ( ( $font && $font != 'no' && $font != 'default' ) ? $font . ', ' : '' );
            }

            $str .= ( $family != 'default' ? str_replace( '_', ', ', $family ) : 'Helvetica, Arial, san-serif' );
            
            if( $add ){
                $str = 'font-family:' . $str . ';';
            }

            return str_replace( '"', '\'', $str );
        }
    }

    if ( ! function_exists( 'rstrpos' ) ) {
        function rstrpos( $haystack, $needle ){
            $size = strlen( $haystack );
            $pos = strpos( strrev( $haystack ), $needle );
            
            if( $pos === false )
                return false;
            
            return $size - $pos - 1;
        }
    }


/***********************/
/* Wordpress Functions */
/***********************/


function getURL( $url ){

    if( !$url )
        return;

    $add = '';

    if( $url == 'localhost' )
        return 'http://localhost:8888/_scm'; //$GLOBALS['localhost'];

    if( startsWith( $url, array( 'page:' ) ) !== false || startsWith( $url, array( 'page/' ) ) !== false || startsWith( $url, array( 'http://page/' ) ) !== false ){

        $url = str_replace( array( 'page:', 'page/', 'http://' ), '', $url );
        
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


?>