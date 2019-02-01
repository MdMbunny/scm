<?php

/**
 * single-share.php
 *
 * Part Single Share content.
 *
 * @link http://www.studiocreativo-m.it
 *
 * @package SCM
 * @subpackage Parts/Single/Share
 * @since 1.0.0
 */

global $post, $SCM_indent;

$args = array(
	'social' => array(
		array( 'social' => 'facebook', 		'icon' => 1, 		'color' => ''	 ),
		array( 'social' => 'twitter', 		'icon' => 0, 		'color' => ''	 ),
		array( 'social' => 'google', 		'icon' => 1, 		'color' => ''	 ),
		array( 'social' => 'linkedin', 		'icon' => 0, 		'color' => ''	 ),
		array( 'social' => 'email', 		'icon' => 0, 		'color' => ''	 ),
		array( 'social' => 'link',	 		'icon' => 'fa-link', 	'color' => ''	 ),
	),
	'shape' => 'circle', // 'square, rounded, circle, round-petal, round-leaf, ...' see main style.css
	'type' => 'fill', // 'fill, stroke'
	'size-number' => '2',
	'size-units' => 'em',
	'post' => 0,
	'id' => '',
    'class' => '',
    'attributes' => '',
    'style' => '',
);

if( isset( $this ) )
	$args = ( isset( $this->cont ) ? array_merge( $args, toArray( $this->cont ) ) : array() );

$post_id = $args['post'] ?: $post->ID;

$class = 'share-buttons scm-share-buttons scm-object object ' . $args['class'];

$attributes = $args['attributes'];
$style = $args['style'];
$id = $args['id'];

$social = $args['social'];
$shape = $args['shape'];
$type = $args['type'];
$icon_size = scm_utils_preset_size( $args[ 'size-number' ], $args[ 'size-units' ], '' );
$style .= $icon_size ? ' font-size:' . $icon_size . ';' : '';

indent( $SCM_indent + 1, openTag( 'div', $id, $class, $style, $attributes ), 1 );

$groups = scm_acf_field_fa_preset( 'social' );
//$current = SCM_SITE . '?p=' . $post_id;
$permalink = get_permalink( $post_id );
$title = get_the_title( $post_id );
$current = urlencode($permalink);

	foreach ($social as $value) {

		$group = ex_attr( $groups, $value['social'], '' );
		$url = '';

		if( $group ){
			$icons = $group['choices'];
			$icon = is_string( $value['icon'] ) ? $value['icon'] : $icons[ $value['icon'] ];
			$color = $value['color'] ?: $group['color'];
			$name = 'Share on ' . $group['name'];

			switch( $value['social'] ) {
				case 'facebook': $url = 'https://www.facebook.com/sharer.php?u=' . $current; break;
				case 'twitter': $url = 'https://twitter.com/intent/tweet?url=' . $current . '&text=' . $title; break;
				case 'google': $url = 'https://plus.google.com/share?url=' . $current; break;
				case 'linkedin': $url = 'https://www.linkedin.com/shareArticle?mini=true&url=' . $current . '&title=' . $title; break;
				case 'email': $url = 'mailto:?subject=' . $title . '&body=' . $current; break;
				
				default:
				break;
			}

			
		}else{

			$icon = is_string( $value['icon'] ) ? $value['icon'] : '';
			$color = $value['color'] ?: '#AAA';
			$name = 'Share URL';

			switch( $value['social'] ) {
				case 'link': $url = $permalink; break;
				
				default:
				break;
			}

		}

		indent( $SCM_indent + 2, '<a class="share-button share-' . $value['social'] . ' ' . $type . ' ' . $shape . '" title="' . $name . '" href="' . $url . '" target="_blank" style="background-color:' . $color . ';color:' . $color . ';border-color:' . $color . ';">', 1 );
			indent( $SCM_indent + 3, '<i class="fa ' . $icon . '"></i>', 1 );
		indent( $SCM_indent + 2, '</a>', 1 );
	}

indent( $SCM_indent, '</div><!-- icon -->' );

?>