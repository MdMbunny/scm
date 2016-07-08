<?php

/**
 * single-icon.php
 *
 * Part Single Icon content.
 *
 * @link http://www.studiocreativo-m.it
 *
 * @package SCM
 * @subpackage Parts/Single/Icon
 * @since 1.0.0
 */

global $post, $SCM_indent;
$post_id = $post->ID;

$args = array(
	'icon' => '',
	'size-number' => '',
	'size-units' => '',
	'id' => '',
    'class' => '',
    'attributes' => '',
    'style' => '',
);

if( isset( $this ) )
	$args = ( isset( $this->cont ) ? array_merge( $args, toArray( $this->cont ) ) : array() );

$class = 'icon scm-icon scm-object object ' . $args['class'];

$attributes = $args['attributes'];
$style = $args['style'];
$id = $args['id'];

$icon = $args['icon'];
$icon_size = scm_preset_size( $args[ 'size-number' ], $args[ 'size-units' ], 'inherit' );
$style .= ' font-size:' . $icon_size . ';';

indent( $SCM_indent + 1, openTag( 'div', $id, $class, $style, $attributes ), 1 );

	indent( $SCM_indent + 2, '<i class="fa ' . $icon . '"></i>', 1 );

indent( $SCM_indent, '</div><!-- icon -->' );

?>