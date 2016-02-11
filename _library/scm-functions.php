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
// getHREF
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
// fileExtensionConvert convert extensions (jpg, pdf, etc.) to file type ( 'Image', 'Text Document', 'Presentation', ... )
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

function consoleDebug( $obj ){
    global $SCM_debug;
    if( $SCM_debug )
        consoleLog( $obj );
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

    if( !is_array( $arr ) )
        return null;

    foreach( array_keys( $arr ) as $key){    
        if ( !is_int( $key ) ) return true;
    }
    
    return false;
}

function toArray( $var, $asso = false ){

    if( !$asso )
        return ( is_array( $var ) ? $var : array( $var ) );
    
    return ( is_asso( $var ) === false ? $var : array( $var ) );

}

// PHP 5.3.0
function insertArray(&$array, $offset, $object, $replace=false){
    
    if(is_array($array)){
        if($replace ){
            if($offset<0) $offset = 0;
            else if($offset > count($array)-1) $offset = count($array)-1;
            $array = array_replace($array, array($offset => $object));
        }else{            
            if($offset == 0){
                array_unshift($array, $object);
            }else if($offset >= count($array)){
                array_push($array, $object);
            }else{                
                $a1 = array_slice($array, 0, $offset);
                $a2 = array_slice($array, $offset);
                array_push($a1, $object);
                $array = array_merge($a1, $a2);
            }
        }
    }    
}
// PHP 4.0.0
/*function array_insert(&$array, $offset, $object, $replace=false){
    
    if(is_array($array)){
        if($replace ){
            if($offset<0) $offset = 0;
            else if($offset > count($array)-1) $offset = count($array)-1;
            $a1 = array_slice($array, 0, $offset);
            $a2 = array_slice($array, $offset+1);
            array_push($a1, $object);
            $array = array_merge($a1, $a2);
        }else{            
            if($offset == 0){
                array_unshift($array, $object);
            }else if($offset >= count($array)){
                array_push($array, $object);
            }else{                
                $a1 = array_slice($array, 0, $offset);
                $a2 = array_slice($array, $offset);
                array_push($a1, $object);
                $array = array_merge($a1, $a2);
            }
        }
    }    
}*/

function copyArray( $arr ){
    if( !isset( $arr ) || gettype( $arr ) != 'array' )
        return array();

    $new = array();

    foreach ( $arr as $k => $v ) {
        $new[$k] = clone $v;
    }

    return $new;
}

function arrayToHTML( $arr, $container = 'ul', $element = 'li', $first = 'strong', $second = 'span' ){

    if( !$arr )
        return '';

    $html = '<' . $container . '>' . lbreak();

    foreach ($arr as $key => $value) {

        $html .= indent() . '<' . $element . '>' . lbreak();
            $html .= indent(2) . '<' . $first . ' style="width: 20%; display: inline-block;">';
                $html .= (string)$key;
            $html .= ': </' . $first . '>' . lbreak();
            $html .= indent(2) . '<' . $second . ' style="font-weight: normal;">';
                $html .= (string)$value;
            $html .= '</' . $second . '>' . lbreak();
            
        $html .= indent() . '</' . $element . '>' . lbreak();
        
    }

    $html .= '</' . $container . '>' . lbreak(2);

    //consoleLog($html);
    
    return $html;

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


function getHREF( $type = 'web', $link, $data = 0 ){
    if( !$link )
        return '';

    $data = ( $data ? 'data-' : '' );

    switch ( $type ) {
        case 'media':
            return scm_post_link( array(), $link );
        break;

        case 'paypal':
        break;

        case 'phone':
            return ' ' . $data . 'href="tel:' . ( startsWith( $link, '+' ) ? $link : '+' . $link ) . '" ' . $data . 'target="_blank"';
        break;

        case 'fax':
            return ' ' . $data . 'href="fax:' . ( startsWith( $link, '+' ) ? $link : '+' . $link ) . '" ' . $data . 'target="_blank"';
        break;

        case 'email':
            return ' ' . $data . 'href="mailto:' . $link . '" ' . $data . 'target="_blank"';
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
        
        default:
            return ' ' . $data . 'href="' . getURL( $link ) . '"';
        break;
    }
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
* @param boolean $key returns $key if true. Default is false and returns $value. Returns $key and $value if 1. Returns $key without $prefix and $value if 2.
* @author SCM
*/

function getAllByPrefix( $arr, $prefix, $key = false ){
    $ar = array();
    foreach ($arr as $k => $v) {
        if( strpos($k, $prefix) === 0 ){
            if( $key === 1 ) $ar[$k] = $v;
            elseif( $key === 2 ) $ar[str_replace($prefix, '', $k)] = $v;
            elseif( $key === true ) $ar[] = $k;
            else $ar[] = $v;
        }
    }
    return $ar;
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

    if ( !is_array($arr))
        return false;
    
    foreach ($arr as $index => $elem) {
        if( isset( $elem[$key] ) && $elem[$key] == $value ) return $index;
    }
    return false;
}

/**
* Get All Elements by Value and Key
* @param array $arr the array where to search for
* @param string $value the value to be checked
* @param string $key the key to be searched for (default = 'name')
* @author SCM
*/

function getAllByValueKey( $arr, $value, $key = 'name' ){

    if ( !is_array($arr))
        return false;

    $new = array();
    
    foreach ($arr as $index => $elem) {
        if( isset( $elem[$key] ) && $elem[$key] == $value ) $new[] = $elem;
    }
    return $new;
}

/**
* Get All Elements by Value Prefix and Key
* @param array $arr the array where to search for
* @param string $value the value to be checked
* @param string $key the key to be searched for (default = 'name')
* @author SCM
*/

function getAllByValuePrefixKey( $arr, $prefix, $key = 'name' ){

    if ( !is_array($arr))
        return $new;

    $new = array();
    
    foreach ($arr as $index => $elem) {

        if( isset( $elem[$key] ) && strpos( $elem[$key], $prefix ) === 0 ) $new[] = $elem;
    }
    return $new;
}

/**
* Get Element by Value
* @param array $arr the array where to search for
* @param string $value the value to be checked
* @author SCM
*/

function getByValue($arr, $value){
    if ( !is_array($arr))
        return false;
    
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

function filemtime_remote($uri)
{
    $uri = parse_url($uri);
    $handle = @fsockopen($uri['host'],80);
    if(!$handle)
        return 0;

    fputs($handle,"GET $uri[path] HTTP/1.1\r\nHost: $uri[host]\r\n\r\n");
    $result = 0;
    while(!feof($handle))
    {
        $line = fgets($handle,1024);
        if(!trim($line))
            break;

        $col = strpos($line,':');
        if($col !== false)
        {
            $header = trim(substr($line,0,$col));
            $value = trim(substr($line,$col+1));
            if(strtolower($header) == 'last-modified')
            {
                $result = strtotime($value);
                break;
            }
        }
    }
    fclose($handle);
    return $result;
}


function fileExtend( $file, $name = '', $date = 'F d Y H:i:s'){

    if( !$file )
        return array();

    if( is_string( $file ) )
        $file = array( 'url' => $file );

    if( !is_array( $file ) )
        return array();

    $file['link'] = $file['url'];
    $file['URL'] = str_replace( ' ', '%20', $file['link'] );
    $file['filename'] = basename( $file['link'] );
    $file['name'] = ( $name ?: $file['filename'] );

    $file['modified'] = ( $file['modified'] ?: date ( $date, filemtime_remote( $file['URL'] ) ) );
    $file['date'] = ( $file['date'] ?: $file['modified'] );
    
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

    //printPre($file);

    return $file;
}


/** 
* Converts bytes into human readable file size. 
* 
* @param string $bytes 
* @return string human readable file size (2,87 МB)
* @author Mogilev Arseny 
*/ 
function fileSizeConvert($bytes, $dec = 0){
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