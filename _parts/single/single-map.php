<?php
/**
 * @package SCM
 */

global $post, $SCM_indent;

$luoghi = array();
$width = 100;
$zoom = 10;

if( isset($this) ){
	$luoghi = ( isset($this->map_luoghi) ? $this->map_luoghi : array() );
	$width = ( isset($this->map_width) ? $this->map_width >= 0 : 100 );
	$zoom = ( isset($this->map_zoom) ? $this->map_zoom : 10 );
}

$classes = 'map scm-map scm-object full';

$indent = $SCM_indent + 1;

indent( $indent, '<div class="' . $classes . '" data-zoom="' . $zoom . '">' );

if($luoghi){

	$output = '';

	foreach( $luoghi as $luogo ){

		$id = $luogo->ID;
		$lat = scm_field( 'luoghi_lat', 0, $id, 1 );
		$lng = scm_field( 'luoghi_lng', 0, $id, 1 );
		$img = scm_field( 'luoghi_marker', '', $id, 1 );
		$img = ( $img ?: scm_field( 'tools_gmap_marker', '', 'option' ) );

		$marker = ( $img ? ' data-img="' . $img . '"' : '' );

		if( $lat && $lng ){
			indent( $indent+1, '<div id="marker-' . $id . '" class="' . SCM_PREFIX . 'marker marker" data-lat="' . $lat . '" data-lng="' . $lng . '"' . $marker . '>' );
					indent( $indent+2, '<strong>' . scm_field( 'luoghi_nome', '', $id, 1 ) . '</strong><br>' );
					indent( $indent+2, '<span>' . scm_field( 'luoghi_indirizzo', '', $id, 1 ) . ', ' . scm_field( 'luoghi_citta', '', $id, 1 ) . '</span>' );
			indent( $indent+1, '</div>' );
		}
	}
}

indent( $indent, '</div><!-- scm-map -->' );

?>