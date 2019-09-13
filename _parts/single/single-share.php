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
		array( 'social' => 'facebook', 		'icon' => 'fab fa-facebook-f', 		'color' => '#3b5998'	 ),
		array( 'social' => 'twitter', 		'icon' => 'fab fa-twitter', 		'color' => '#55acee'	 ),
		//array( 'social' => 'google', 		'icon' => 1, 		'color' => ''	 ),
		array( 'social' => 'linkedin', 		'icon' => 'fab fa-linkedin-in', 		'color' => '#4875B4'	 ),
		array( 'social' => 'email', 		'icon' => 'fas fa-envelope', 		'color' => '#4cb300'	 ),
		array( 'social' => 'link',	 		'icon' => 'fas fa-link', 	'color' => '#AAA'	 ),
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

//$groups = scm_acf_field_fa_preset( 'social' );
//$current = SCM_SITE . '?p=' . $post_id;
$permalink = get_permalink( $post_id );
$title = get_the_title( $post_id );
$current = urlencode($permalink);

	foreach ($social as $value) {

		//$group = ex_attr( $groups, $value['social'], '' );
		$url = '';

		//if( $group ){
			//$icons = $group['choices'];
			//$icon = is_string( $value['icon'] ) ? $value['icon'] : $icons[ $value['icon'] ];
			$icon = is_string( $value['icon'] ) ? $value['icon'] : '';
			$color = $value['color'] ?: '#AAA';// $group['color'];
			//$name = 'Share on ' . $group['name'];
			$name = 'Share';

			switch( $value['social'] ) {
				case 'facebook': $name = $name . ' on Facebook'; $url = 'https://www.facebook.com/sharer.php?u=' . $current; break;
				case 'twitter': $name = $name . ' on Twitter'; $url = 'https://twitter.com/intent/tweet?url=' . $current . '&text=' . $title; break;
				case 'google': $name = $name . ' on Google Plus'; $url = 'https://plus.google.com/share?url=' . $current; break;
				case 'linkedin': $name = $name . ' on LinkedIn'; $url = 'https://www.linkedin.com/shareArticle?mini=true&url=' . $current . '&title=' . $title; break;
				case 'email': $name = $name . ' on Email'; $url = 'mailto:?subject=' . $title . '&body=' . $current; break;
				case 'link': $name = $name . ' URL'; $url = $permalink; break;
				default:
				break;
			}

			
		/*}else{

			$icon = is_string( $value['icon'] ) ? $value['icon'] : '';
			$color = $value['color'] ?: '#AAA';
			$name = 'Share URL';

			switch( $value['social'] ) {
				
				
				default:
				break;
			}

		}*/

		indent( $SCM_indent + 2, '<a class="share-button share-' . $value['social'] . ' ' . $type . ' ' . $shape . '" title="' . $name . '" href="' . $url . '" target="_blank" style="background-color:' . $color . ';color:' . $color . ';border-color:' . $color . ';">', 1 );
			indent( $SCM_indent + 3, '<i class="fa ' . $icon . '"></i>', 1 );
		indent( $SCM_indent + 2, '</a>', 1 );
	}

indent( $SCM_indent, '</div><!-- icon -->' );

?>