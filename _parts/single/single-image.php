<?php
/**
 * @package SCM
 */

global $post, $SCM_indent;
$post_id = $post->ID;

$args = array(
	'acf_fc_layout' => 'layout-immagine',
	'image' => '',
    'images' => '',
	'format' => 'norm',
	'full-number' => '',
	'full-units' => '',
	'size-number' => '',
	'size-units' => '',
	'width-number' => '',
	'width-units' => '',
	'height-number' => '',
	'height-units' => '',
	'id' => '',
    'class' => '',
    'attributes' => '',
    'style' => '',
    'negative' => 'off',
    'thumb' => '',
    'thumb-size' => 'thumbnail',
    'link' => ''
);

if( isset( $this ) )
	$args = ( isset( $this->cont ) ? array_merge( $args, toArray( $this->cont ) ) : array() );

/***************/

$layout = $args['acf_fc_layout'];
$image = ( $args[ 'image' ] ?: ( $args[ 'thumb' ] ?: scm_field( 'image', '', $post_id ) ) );
$images = ( $args[ 'images' ] ?: '' );
//$url = scm_field( 'image', '', $post_id );
$negative = $args['negative'] === 'on';
$thumb = -2;

if ( $layout == 'layout-thumbs' ) {
    
    $thumb = ( $image ? intval( $image ) : 0 );

    $images = ( $images ?: scm_field( 'galleria-images', array(), $post_id ) );

    if( $thumb >= 0 ){

        $image = $images[$thumb];

    }else{

        $image = $images;

    }

}elseif( !$image ){
    if( $post->post_type === 'soggetti' ){
        switch ( $layout ) {
            case 'layout-logo':
                if( $negative )
                    $image = scm_field( 'soggetto-logo-neg', '', $post_id );
                else
                    $image = scm_field( 'soggetto-logo', '', $post_id );
            break;
            
            case 'layout-logo-icona':
                if( $negative )
                    $image = scm_field( 'soggetto-icona-neg', '', $post_id );
                else
                    $image = scm_field( 'soggetto-icona', '', $post_id );
            break;
        }
        
        
        if( !$image )
            return;

    }elseif( $post->post_type === 'video' ){

        $url = scm_field( 'video-url', '', $post_id );
        $id = substr( $url, strpos( $url, 'watch?v=' ) + 8 );
        if( !$id )
            return;
        
        global $SCM_protocol;
        $image = $SCM_protocol . 'img.youtube.com/vi/' . $id . '/1.jpg';

    }else{
        return;
    }

}

//consoleLog( $image );

//if( gettype( $image ) == 'string' )
    $image = toArray( $image, true );


/***************/


$class = 'image scm-image scm-object object ' . $args['class'];

$attributes = $args['attributes'];
$style = $args['style'];
$id = $args['id'];


/***************/


switch ( $args[ 'format' ] ) {
    case 'full':
        $image_height = scm_content_preset_size( $args[ 'full-number' ], $args[ 'full-units' ], 'initial' );
        $style .= ' max-height:' . $image_height . ';';
        $class .= ' mask full';
    break;

    case 'quad':
        $image_size = scm_content_preset_size( $args[ 'size-number' ], $args[ 'size-units' ] );
        $style .= ' width:' . $image_size . '; height:' . $image_size . ';';
    break;
    
    default:
        $image_width = scm_content_preset_size( $args[ 'width-number' ], $args[ 'width-units' ], 'auto' );
        $image_height = scm_content_preset_size( $args[ 'height-number' ], $args[ 'height-units' ], 'auto' );

        $style .= ' width:' . $image_width . '; height:' . $image_height . ';';
    break;
}

//consoleLog($image);

for ( $i = 0; $i < sizeof( $image ); $i++ ) { 

    $att = $attributes;

    $value = $image[$i];

    

    $id = ( $id && sizeof( $image ) > 1 ? $id . '-' . $key : $id );

    if( $thumb > -2 ){

        if( $thumb == -1 ){
            $args['thumb'] = $i;
        }
        
        $att .= scm_post_link( $args );

        if( $args['thumb-size'] )
            $value = ( gettype( $value ) == 'array' ? $value['sizes']['thumbnail'] : $value );
        else
            $value = ( gettype( $value ) == 'array' ? $value['url'] : $value );
        
        $class .= ' thumb';

    }else{
    
        $value = ( gettype( $value ) == 'array' ? $value['url'] : $value );

    }
 
    indent( $SCM_indent + 1, openTag( 'div', $id, $class, $style, $att ), 1 );

        indent( $SCM_indent + 2, '<img src="' . $value . '" style="max-width:100%;max-height:100%;" alt="">', 1 );

    indent( $SCM_indent + 1, '</div><!-- image -->', 2 );

}


?>