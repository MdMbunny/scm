<?php

/**
 * single-map.php
 *
 * Part Single Map content.
 *
 * @link http://www.studiocreativo-m.it
 *
 * @package SCM
 * @subpackage Parts/Single/Map
 * @since 1.0.0
 */

global $post, $SCM_indent;
$post_id = $post->ID;

$args = array(
	'element' => 0,
	'zoom' => 10,
	'both' => false,
	'template' => '',
	'id' => '',
    'class' => '',
    'attributes' => '',
    'style' => '',
);

if( isset( $this ) )
	$args = ( isset( $this->cont ) ? array_merge( $args, toArray( $this->cont ) ) : array() );

$element = $args[ 'element' ];
$cat = ( isset( $args[ 'luoghi-cat-terms' ] ) ? $args[ 'luoghi-cat-terms' ] : array() );

if( !$element ){

	if( $post->post_type === 'luoghi' )
		$element = array( $post_id );
	else if( $post->post_type === 'soggetti' )
		$element = scm_field( 'soggetto-luoghi', array(), $post_id );
	else
		$element = scm_field( 'luoghi', array(), $post_id );

	if( post_type_exists('luoghi') ){
		if( empty($cat) ) {
			$element = get_posts( array( 'post_type' => 'luoghi', 'posts_per_page' => -1 ) );
		}else{
			$element = get_posts(
				array( 
					'posts_per_page' => -1,
					'post_type' => 'luoghi',
				    'tax_query' => array( array( 'taxonomy' => 'luoghi-cat', 'field' => 'term_id', 'terms' => $cat ) )
				)
			);
		}
	}else{
		return;
	}

}else if( !is_array( $element ) ){
	if( is_numeric( $element ) )
		$element = array( $element );
	else
		$element = array( $element->ID );
}

$class = 'map scm-map scm-object object full' . $args['class'];

$fa = scm_field( 'opt-tools-map-icon-fa', 'fa-map-marker', 'option' );
$color = scm_utils_style_get_color( 'opt-tools-map-', 'option' );
$icon = array( 'icon' => $fa, 'data' => $color );
$marker = ' data-icon="' . $fa . '" data-icon-color="' . $color . '" ';

$attributes = ' data-zoom="' . ifexists( $args[ 'zoom' ], 10 ) . '" data-infowidth="' . ifexists( $args[ 'infowidth' ], 500 ) . '" ' . $marker . $args['attributes'];
$style = $args['style'];
$id = $args['id'];
$latlng = array();
$luoghi = array();

indent( $SCM_indent + 1, openTag( 'div', $id, $class, $style, $attributes ), 2 );

if( is( $element ) ){

	foreach( $element as $luogo_id ){

		$luogo = array();
		$luogo['strongs'] = array();
		$luogo['strings'] = array();

		$luogo_id = ( is_numeric( $luogo_id ) ? $luogo_id : $luogo_id->ID );

		$fields = get_fields( $luogo_id );

		$lat = get_post_meta( $luogo_id, 'latitude', true );//( isset( $fields['luogo-lat'] ) ? $fields['luogo-lat'] : 0 );
		$lng = get_post_meta( $luogo_id, 'longitude', true );//( isset( $fields['luogo-lng'] ) ? $fields['luogo-lng'] : 0 );
		$indirizzo = ( isset( $fields['luogo-indirizzo'] ) ? $fields['luogo-indirizzo'] : '' );
		$citta = ( isset( $fields['luogo-citta'] ) ? $fields['luogo-citta'] : '' ) . ( isset($fields['luogo-paese']) ? ' (' . $fields['luogo-paese'] . ')' : '' );
		$title = get_the_title( $luogo_id );
		$name = ex_attr( $fields, 'luogo-nome', '' );
		
		$attr = '';

		$template = $args['template'];
		$link = '';
		if( $template )
			$link = ' ' . scm_utils_link_post( array( 'link-type'=>'popup', 'template'=>$template ), $luogo_id );

		$strong = '<strong' . $link . '>' . ( $args['both'] ? $title . ( $name ? ' <i>' . $name . '</i>' : '' ) : ( $name ?: $title ) ) . '</strong>';
		
		if( $lat && $lng ){
			$ind = getByValueKey( $latlng, $lat, 'lat' );
			if( !is_null( $ind ) ){
				if( $latlng[$ind]['lng'] == $lng ){
					$luoghi[$ind]['strongs'][] = $strong;
					continue;
				}
			}
			$luogo['lat'] = $lat;
			$luogo['lng'] = $lng;
			$latlng[$luogo_id] = array( 'lat'=>$lat, 'lng'=>$lng );
			$attr = ' data-lat="' . $lat . '" data-lng="' . $lng . '"';
		}else{
			$luogo['address'] = str_replace( array( ',', '-' ), '', $indirizzo ) . ( $citta ? ' ' . $citta : '' );
		}
		
		$luogo['strongs'][] = $strong;
		$luogo['strings'][] = '<span>' . $indirizzo . '</span>';
		$luogo['strings'][] = '<span>' . $citta . '</span>';
		
		$luoghi[$luogo_id] = $luogo;
	}
	foreach( $luoghi as $luogo ){

		$fields = get_fields( $luogo_id );

		//$luogo_id = $luogo['id'];

		$contatti = ( isset( $fields['luogo-contatti'] ) ? $fields['luogo-contatti'] : array() );
		$marker = scm_utils_preset_map_marker( $luogo_id, $fields, 1 );

		if( isset( $luogo['lat'] ) && isset( $luogo['lng'] ) ){
			$attr = ' data-lat="' . $luogo['lat'] . '" data-lng="' . $luogo['lng'] . '" ';
		}elseif( isset( $luogo['address'] ) ){
			$attr = ' data-address="' . $luogo['address'] . '" ';
		}

		indent( $SCM_indent+1, '<div class="scm-marker marker marker-' . $luogo_id . '"' . $attr . $marker . '>' );
				
				foreach ($luogo['strongs'] as $value) {
					indent( $SCM_indent+2, $value );
				}
				foreach ($luogo['strings'] as $value) {
					indent( $SCM_indent+2, $value );
				}
				
				if( !empty( $contatti ) ){
					indent( $SCM_indent+2, '<div class="map-contacts">' );
					foreach ($contatti as $contatto) {
						if( $contatto['onmap'] ){
							$href = getHREF( str_replace( 'layout-', '', $contatto['acf_fc_layout']), (string)$contatto['link'] );
							indent( $SCM_indent+2, '<a ' . $href . '>' . ( $contatto['name'] ?: (string)$contatto['link'] ) . '</a>' );
						}
					}
					indent( $SCM_indent+2, '</div>' );
				}
		indent( $SCM_indent+1, '</div>' );
	}
}

indent( $SCM_indent, '</div><!-- map -->' );

?>