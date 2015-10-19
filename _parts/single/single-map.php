<?php
/**
 * @package SCM
 */

global $post, $SCM_indent;
$post_id = $post->ID;

$args = array(
	'element' => 0,
	'zoom' => 10,
	'id' => '',
    'class' => '',
    'attributes' => '',
    'style' => '',
);

if( isset( $this ) )
	$args = ( isset( $this->cont ) ? array_merge( $args, toArray( $this->cont ) ) : array() );

/***************/


$element = $args[ 'element' ];
$cat = ( isset( $args[ 'luoghi-cat-terms' ] ) ? $args[ 'luoghi-cat-terms' ] : array() );

if( !$element ){

	if( $post->post_type === 'luoghi' )
		$element = array( $post_id );
	else if( $post->post_type === 'soggetti' )
		$element = scm_field( 'soggetto-luoghi', array(), $post_id );
	

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



/***************/


$class = 'map scm-map scm-object object full' . $args['class'];


$attributes = ' data-zoom="' . ifexists( $args[ 'zoom' ], 10 ) . '"' . $args['attributes'];
$style = $args['style'];
$id = $args['id'];


/***************/


indent( $SCM_indent + 1, openTag( 'div', $id, $class, $style, $attributes ), 2 );

if( is( $element ) ){



	foreach( $element as $luogo ){

		$luogo = ( is_numeric( $luogo ) ? $luogo : $luogo->ID );

		$fields = get_fields( $luogo );

		$lat = is( $fields['luogo-lat'], 0 );
		$lng = is( $fields['luogo-lng'], 0 );
		$indirizzo = is( $fields['luogo-indirizzo'], '' );
		$citta = is( $fields['luogo-citta'], '' ) . ( $fields['luogo-paese'] ? ' (' . $fields['luogo-paese'] . ')' : '' );
		$contatti = is( $fields['luogo-contatti'], array() );
		$attr = '';

		$marker = scm_content_preset_marker( $luogo, $fields, 1 );

		if( $lat && $lng ){
			$attr = ' data-lat="' . $lat . '" data-lng="' . $lng . ' "';
		}else{
			$attr = ' data-address="' . $indirizzo . ( $citta ? ', ' . $citta : '') . '" ';
		}

		indent( $SCM_indent+1, '<div class="scm-marker marker marker-' . $luogo . '"' . $attr . $marker . '>' );
				indent( $SCM_indent+2, '<strong>' . is( $fields['luogo-nome'], get_the_title( $luogo ) ) . '</strong><br>' );
				indent( $SCM_indent+2, '<span>' . $indirizzo . '</span><br>' );
				indent( $SCM_indent+2, '<span>' . $citta . '</span>' );
				if( !empty( $contatti ) ){
					indent( $SCM_indent+2, '<div class="map-contacts">' );
					foreach ($contatti as $contatto) {
						if( $contatto['onmap'] ){
							$href = getHREF( str_replace( 'layout-', '', $contatto['acf_fc_layout']), (string)$contatto['link'] );
							indent( $SCM_indent+2, '<a ' . $href . '>' . ( $contatto['name'] ?: (string)$contatto['link'] ) . '</a>' );
							//indent( $SCM_indent+2, '<div ' . $href . ' data-target="_blank">' . ( $contatto['name'] ?: (string)$contatto['link'] ) . '</div>' );
						}
					}
					indent( $SCM_indent+2, '</div>' );
				}
		indent( $SCM_indent+1, '</div>' );
		
	}
}

indent( $SCM_indent, '</div><!-- map -->' );

?>