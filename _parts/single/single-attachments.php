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
	'files' => '',
	'links' => '',
	'objects' => '',
    'id' => '',
    'class' => '',
    'attributes' => '',
    'style' => '',
);

if( isset( $this ) )
	$args = ( isset( $this->cont ) ? array_merge( $args, toArray( $this->cont ) ) : array() );

$class = 'attachments scm-attachments scm-object object ' . $args['class'];

$attributes = $args['attributes'];
$style = $args['style'];
$id = $args['id'];

$post_type = ( $args['element'] ? get_post_type( $args['element'] ) : $post_type );
$post_id = ( $args['element'] ?: $post_id );
$files = ( $args['files'] ?: ( scm_field( 'files', '', $post_id ) ?: ( scm_field( $post_type . '-' . 'files', '', $post_id ) ?: array() ) ) );
$links = ( $args['links'] ?: ( scm_field( 'links', '', $post_id ) ?: ( scm_field( $post_type . '-' . 'links', '', $post_id ) ?: array() ) ) );
$objects = ( $args['objects'] ?: ( scm_field( 'objects', '', $post_id ) ?: ( scm_field( $post_type . '-' . 'objects', '', $post_id ) ?: array() ) ) );

if( empty($files) && empty($objects) && empty($links) ) return;

indent( $SCM_indent + 1, openTag( 'ul', $id, $class, $style, $attributes ), 2 );

if( !empty( $links ) ){
    foreach ($links as $link) {

        echo getLink( $link['link'], $link['name'], $SCM_indent + 2, 'li' );
        
    }
}
if( !empty( $files ) ){
    foreach ($files as $file) {

        consoleLog($file);
        
        echo getFile( $file['file'], $file['name'], $SCM_indent + 2, 'li' );

    }
}
if( !empty( $objects ) ){
    foreach ($objects as $media) {

        echo getAttachment( 'media', $media['object'], $media['name'], $SCM_indent + 2, 'li' );

    }
}

indent( $SCM_indent + 1, '</ul><!-- attachments -->', 2 );


?>