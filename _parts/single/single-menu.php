<?php

/**
 * single-menu.php
 *
 * Part Single Menu content.
 *
 * @link http://www.studiocreativo-m.it
 *
 * @package SCM
 * @subpackage Parts/Single/Menu
 * @since 1.0.0
 */

global $post, $SCM_indent;
$post_id = $post->ID;

$args = array(
	'location' => 'primary',
	'menu' => '',
	'id' => '',
    'class' => '',
    'attributes' => '',
    'style' => '',
);

if( isset( $this ) )
	$args = ( isset( $this->cont ) ? array_merge( $args, toArray( $this->cont ) ) : array() );

$class = 'menu scm-menu scm-object object ' . $args['class'];

$attributes = $args['attributes'];
$style = $args['style'];
$id = $args['id'];

 wp_nav_menu( array(
    'container' => false,
    'theme_location' => $args['location'],
    'menu' => $args['menu'],
    /*'items_wrap' => $wrap,*/
) );

?>