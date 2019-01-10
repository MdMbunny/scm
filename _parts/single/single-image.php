<?php

/**
 * single-image.php
 *
 * Part Single Image content.
 *
 * @link http://www.studiocreativo-m.it
 *
 * @package SCM
 * @subpackage Parts/Single/Image
 * @since 1.0.0
 */

global $post, $SCM_indent;
$post_id = $post->ID;

$args = array(
    'acf_fc_layout' => 'layout-immagine',
    'image' => '',
    'images' => '',
    'format' => 'norm',
    'align' => 'top',
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
    'thumb-size' => 'full',
    'link' => '',
    'title' => '',
);


if( isset( $this ) )
    $args = ( isset( $this->cont ) ? array_merge( $args, toArray( $this->cont ) ) : array() );

$layout = $args['acf_fc_layout'];
$image = ( $args[ 'image' ] ?: ( $args[ 'thumb' ] ?: scm_field( 'image', '', $post_id ) ) );
$images = ( $args[ 'images' ] ?: '' );
$negative = $args['negative'] === 'on';
$thumb = -2;
$size = $args['thumb-size'] ?: 'full';

if ( $layout == 'layout-thumbs' ) {

    $size = $args['thumb-size'] ?: 'medium';

    if( !$images )
        $images = ( $images ?: scm_field( 'galleria-images', array(), $post_id ) );

    $thumb = ( $image ? intval( $image ) : 0 );
    if( !$image ) $thumb = rand( 0, count( $images )-1 );

    if( $thumb >= 0 )
        $image = ( isset( $images[$thumb] ) ? $images[$thumb] : array() );
    else
        $image = $images;

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
            
            default:
                return;
            break;
        }
        
        
        if( !$image )
            return;

    }elseif( $post->post_type === 'luoghi' ){
        switch ( $layout ) {
            case 'layout-logo':
                if( $negative )
                    $image = scm_field( 'luogo-logo-neg', '', $post_id );
                else
                    $image = scm_field( 'luogo-logo', '', $post_id );
            break;
            
            default:
                return;
            break;
        }
        
        
        if( !$image )
            return;

    }elseif( $post->post_type === 'video' ){

        $vurl = scm_field( 'video-url', '', $post_id );
        $vimg = scm_field( 'video-image', '', $post_id );

        $image = $vimg ?: getVideoThumb( $vurl, $size );
        
        if( !$image ) return;

    }else{
        return;
    }

}

$image = toArray( $image, true );

$class = 'image scm-image scm-object object ' . $args['class'];

$attributes = $args['attributes'];
$style = $args['style'];
$id = $args['id'];
$title = '';

switch ( $args[ 'format' ] ) {
    case 'full':
        $image_height = scm_utils_preset_size( $args[ 'full-number' ], $args[ 'full-units' ], 'initial' );
        $style .= ' height:' . $image_height . ';';
        $class .= ( $image_height=='initial' ? '' : ' mask' ) . ' full';
    break;

    case 'quad':
        $image_size = scm_utils_preset_size( $args[ 'size-number' ], $args[ 'size-units' ], 'auto' );
        $style .= ' width:' . $image_size . '; height:' . $image_size . ';';
        $class .= ' mask full';
    break;

    case 'norm':
        $image_width = scm_utils_preset_size( $args[ 'width-number' ], $args[ 'width-units' ], 'auto' );
        $image_height = scm_utils_preset_size( $args[ 'height-number' ], $args[ 'height-units' ], 'auto' );

        $style .= ' width:' . $image_width . '; height:' . $image_height . ';';
        $class .= ( $image_width != 'auto' && $image_height != 'auto' ? ' mask full' : '' );
    break;
    
    default:
        $class .= ' image-banner';
        
        $image_width = scm_utils_preset_size( $args[ 'width-number' ], $args[ 'width-units' ], 'auto' );
        $image_height = scm_utils_preset_size( $args[ 'height-number' ], $args[ 'height-units' ], 'auto' );

        $style .= ' width:' . $image_width . '; height:' . $image_height . ';';
        $class .= ( $image_height != 'auto' ? ' mask' : '' );

    break;
}

if( $args['title'] ){
    $title = '<span>' . $args['title'] . '</span>';
    $class .= ' image-banner';
}

$align = ex_attr( $args, 'align', 'top' );
$class .= ' -' . $align;


for ( $i = 0; $i < sizeof( $image ); $i++ ) { 

    $att = $attributes;

    $value = $image[$i];

    $id = ( $id && sizeof( $image ) > 1 ? $id . '-' . $key : $id );

    if( $thumb >= -1 ){

        if( $thumb == -1 )
            $args['thumb'] = $i;

        if( $args['link'] == 'self' )
            $att .= scm_utils_link_post( $args );
        elseif ( $args['link'] && $args['link'] != 'no' )
            $att .= ' data-href="' . $args['link'] . '"';
        
        $class .= ' thumb';
    }

    if( is_array( $value ) )
        $value = wp_get_attachment_image( $value['ID'], $size );
    elseif( is_numeric( $value ) )
        $value = wp_get_attachment_image( $value, $size );
    elseif( $value )
        $value = '<img src="' . $value . '" alt="">';
    else
        return;
 
    indent( $SCM_indent + 1, openTag( 'div', $id, $class, $style, $att ), 1 );

        indent( $SCM_indent + 2, $value, 1 );
        if( $title )
            indent( $SCM_indent + 2, $title, 1 );

    indent( $SCM_indent + 1, '</div><!-- image -->', 2 );

}

?>