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
	'strongs' => array(),
	'strings' => array(),
	'zoom' => 10,
	'control-drag' => 1,
	'control-zoom' => 1,
	'control-streetview' => 1,
	'infowidth' => 500,
	'both' => false,
	'template' => '',
	'id' => '',
    'class' => '',
    'attributes' => '',
    'style' => '',
);

if( isset( $this ) )
	$args = ( isset( $this->cont ) ? array_merge( $args, toArray( $this->cont ) ) : array() );

$element = ( isset( $args[ 'element' ] ) ? $args[ 'element' ] : 0 );
$cat = ( isset( $args[ 'luoghi-cat-terms' ] ) ? $args[ 'luoghi-cat-terms' ] : array() );
$strongs = ( isset( $args[ 'strongs' ] ) ? $args[ 'strongs' ] : array() );
$strings = ( isset( $args[ 'strings' ] ) ? $args[ 'strings' ] : array() );

if( !$element ){

	if( $post->post_type === 'luoghi' )
		$element = array( $post_id );
	else if( $post->post_type === 'soggetti' )
		$element = scm_field( 'soggetto-luoghi', array(), $post_id );
	else
		$element = scm_field( 'luoghi', 0, $post_id );

	if( !$element && post_type_exists('luoghi') ){
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
	}
	
	if( !$element )
		return;

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
$marker = ' data-icon="' . $fa . '"' . ( $color ? '" data-icon-color="' . $color . '" ' : '' );

$attributes = ' data-control-drag="' . ex_attr( $args, 'control-drag', 1 ) . '" data-control-zoom="' . ex_attr( $args, 'control-zoom', 1 ) . '" data-control-streetview="' . ex_attr( $args, 'control-streetview', 1 ) . '" data-zoom="' . ex_attr( $args, 'zoom', 10 ) . '" data-infowidth="' . ex_attr( $args, 'infowidth', 500 ) . '" ' . $marker . $args['attributes'];
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
		$indirizzo = ex_attr( $fields, 'luogo-indirizzo', '' );
		$citta = ex_attr( $fields, 'luogo-citta', '' ) . ex_attr( $fields, 'luogo-paese', '', ' (' , ')' );
		$title = get_the_title( $luogo_id );
		$name = ex_attr( $fields, 'luogo-nome', '' );
		
		$attr = '';

		$tit = ( $args['both'] ? $title . ( $name ? ' <i>' . $name . '</i>' : '' ) : ( $name ?: $title ) );

		$template = $args['template'];
//$strong = '<a href="' . scm_utils_link_post( array( 'link-type'=>'self', 'template'=>$template ), $luogo_id ) . '">' . $tit . '</a>';
	
		if( $template )
			$strong = '<a href="' . get_permalink( $luogo_id ) . '?template=' . $template . '">' . $tit . '</a>';
		else
			$strong = '<strong>' . $tit . '</strong>';
		
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
		
		if( ex_index( $strongs, $luogo_id, 0 ) )
			$luogo['strongs'] = array_merge( $strongs[$luogo_id], array( $strong ) );
		else
			$luogo['strongs'][] = $strong;

		if( ex_index( $strings, $luogo_id, 0 ) ){
			$luogo['strings'][] = $strings[$luogo_id];
		}else{
			$luogo['strings'][] = '<span>' . $indirizzo . '</span>';
			$luogo['strings'][] = '<span>' . $citta . '</span>';
		}
		
		$luoghi[$luogo_id] = $luogo;
	}

	foreach ($luoghi as $luogo_id => $luogo) {

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
					$open = 0;
					foreach ($contatti as $contatto) {
						if( $contatto['onmap'] ){
							if( !$open ){
								$open = 1;
								indent( $SCM_indent+2, '<div class="map-contacts">' );
							}
							$href = getHREF( str_replace( 'layout-', '', $contatto['acf_fc_layout']), (string)$contatto['link'] );
							indent( $SCM_indent+2, '<a ' . $href . '>' . ( $contatto['name'] ?: ( $contatto['icon'] ? '<i class="fa ' . $contatto['icon'] . '"></i>' : (string)$contatto['link'] ) ) . '</a>' );
						}
					}
					if( $open )
						indent( $SCM_indent+2, '</div>' );
				}
		indent( $SCM_indent+1, '</div>' );
	}
}

indent( $SCM_indent, '</div><!-- map -->' );

?>