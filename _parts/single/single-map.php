<?php
/**
 * @package SCM
 */

global $post, $SCM_indent;
$post_id = $post->ID;

$args = array(
	'element' => 0,
	'zoom' => 10,
	'address' => 'no',
	'id' => '',
    'class' => '',
    'attributes' => '',
    'style' => '',
);

if( isset( $this ) )
	$args = ( isset( $this->cont ) ? array_merge( $args, toArray( $this->cont ) ) : array() );

/***************/


$element = $args[ 'element' ];
if( !$element ){

	if( $post->post_type === 'luoghi' )
		$element = array( $post_id );
	else if( $post->post_type === 'soggetti' )
		$element = scm_field( 'soggetto-luoghi', array(), $post_id );
	else
		return;

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

		$fields = get_fields( $luogo );

		$lat = is( $fields['luogo-lat'], 0 );
		$lng = is( $fields['luogo-lng'], 0 );
		$indirizzo = is( $fields['luogo-indirizzo'], '' ) . ', ' . is( $fields['luogo-citta'], '' );
		$attr = '';

		$marker = scm_content_preset_marker( $luogo, $fields, 1 );

		if( $lat && $lng ){
			$attr = ' data-lat="' . $lat . '" data-lng="' . $lng . ' "';
		}else{
			$attr = ' data-address="' . $indirizzo . '" ';
		}

		indent( $SCM_indent+1, '<div class="scm-marker marker marker-' . $luogo . '"' . $attr . $marker . '>' );
				indent( $SCM_indent+2, '<strong>' . is( $fields['luogo-nome'], '' ) . '</strong><br>' );
				indent( $SCM_indent+2, '<span>' . $indirizzo . '</span>' );
		indent( $SCM_indent+1, '</div>' );
		
	}
}

indent( $SCM_indent, '</div><!-- map -->' );

?>