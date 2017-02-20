<?php

/**
 * single-attachments.php
 *
 * Part Single Attachments content.
 *
 * @link http://www.studiocreativo-m.it
 *
 * @package SCM
 * @subpackage Parts/Single/Attachments
 * @since 1.0.0
 */

global $post, $SCM_indent;
$post_id = $post->ID;
$post_type = $post->post_type;

$args = array(
	'element' => 0,
	'title' => '',
	'files' => array(),
	'links' => array(),
	'objects' => array(),
);

if( isset( $this ) )
	$args = ( isset( $this->cont ) ? array_merge( $args, toArray( $this->cont ) ) : array() );

$element = ( $args['element'] ?: $post_id );

if( ( $args['files'] && !empty($args['files']) ) || ( $args['objects'] && !empty($args['objects']) ) || ( $args['links'] && !empty($args['links']) ) ){

	

	indent( $SCM_indent + 1, openTag( 'ul', '', 'attachments' ), 2 );

    if( $args['links'] && !empty($args['links']) ){
        foreach ($args['links'] as $link) {

            echo getLink( $link['link'], $link['name'], $indent = $SCM_indent + 2, $tag = 'li' );
            
            /*$ext = linkExtend( $link['link'], $link['name'] );            
            indent( $SCM_indent + 2, '<li class="attachment link link-' . $ext['type'] . '" data-href="' . $ext['link'] . '">', 1 );
                indent( $SCM_indent + 3, '<div class="icons">', 1 );
                    indent( $SCM_indent + 4, '<i class="fa fa-chevron-circle-right plus"></i>', 1 );
                    indent( $SCM_indent + 4, '<i class="fa fa-' . $ext['icon'] . '"></i>', 1 );
                indent( $SCM_indent + 3, '</div>', 1 );
                indent( $SCM_indent + 3, '<span>' . $ext['name'] . '</span>', 1 );
            indent( $SCM_indent + 2, '</li>', 1 );*/
        }
    }
    if( $args['files'] && !empty($args['files']) ){
        foreach ($args['files'] as $file) {
            
            echo getFile( $file['file'], $file['name'], $indent = $SCM_indent + 2, $tag = 'li' );

            /*$ext = fileExtend( $file['file'], $file['name'] );
            indent( $SCM_indent + 2, '<li class="attachment file file-' . $ext['icon'] . '" data-href="' . $ext['link'] . '">', 1 );
                indent( $SCM_indent + 3, '<div class="icons">', 1 );
                    indent( $SCM_indent + 4, '<i class="fa fa-chevron-circle-down plus"></i>', 1 );
                    indent( $SCM_indent + 4, '<i class="fa fa-' . $ext['icon'] . '"></i>', 1 );
                indent( $SCM_indent + 3, '</div>', 1 );
                indent( $SCM_indent + 3, '<span>' . $ext['name'] . '</span>', 1 );
            indent( $SCM_indent + 2, '</li>', 1 );*/
        }
    }
    if( $args['objects'] && !empty($args['objects']) ){
        foreach ($args['objects'] as $media) {

        	//$ext = fileExtend( $media['object'], $media['name'] );
        	//consoleLog($ext);
        	//$ext = linkExtend( $media['object'], $media['name'] );
        	//consoleLog($ext);

            echo getAttachment( 'media', $media['object'], $media['name'], $indent = $SCM_indent + 2, $tag = 'li' );
            
            /*$type = get_post_type( $media['object'] );
            indent( $SCM_indent + 2, '<li class="attachment media media-' . $type . '"' . scm_utils_link_post( '', $media['object'] ) . '>', 1 );
                indent( $SCM_indent + 3, '<div class="icons">', 1 );
                    indent( $SCM_indent + 4, '<i class="fa fa-plus-circle plus"></i>', 1 );
                    indent( $SCM_indent + 4, '<i class="fa fa-' . ( $type == 'video' ? 'youtube-play' : ( $type == 'gallerie' ? 'picture-o' : 'link' ) ) . '"></i>', 1 );
                indent( $SCM_indent + 3, '</div>', 1 );
                indent( $SCM_indent + 3, '<span>' . ( $media['name'] ?: get_the_title( $media['object'] ) ) . '</span>', 1 );
            indent( $SCM_indent + 2, '</li>', 1 );*/

        }
    }

    indent( $SCM_indent + 1, '</ul><!-- attachments -->', 2 );

}

?>