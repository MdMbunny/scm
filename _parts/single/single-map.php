<?php
/**
 * @package SCM
 */

global $post, $SCM_indent;

$luoghi = array();
$width = 100;
$units = '%';
$zoom = 10;

if( isset($this) ){
	$luoghi = ( isset($this->map_luoghi) ? $this->map_luoghi : array() );
	$width = ( isset($this->map_width) ? $this->map_width : 100 ); // +++ todo: default o 100, quando i Template saranno pronti
	$units = ( isset($this->map_units) ? $this->map_units : '%' ); // +++ todo: default o %, quando i Template saranno pronti
	$zoom = ( isset($this->map_zoom) ? $this->map_zoom : 10 ); // +++ todo: default o 10, quando i Template saranno pronti
}

$classes = 'map scm-map scm-object object';

$indent = $SCM_indent + 1;

indent( $indent, '<div class="' . $classes . '" style="width:' . $width . $units ';" data-zoom="' . $zoom . '">' );

if($luoghi){

	foreach( $luoghi as $luogo ){

		$id = $luogo->ID;
		$lat = scm_field( 'luoghi_lat', 0, $id, 1 );
		$lng = scm_field( 'luoghi_lng', 0, $id, 1 );
		$img = scm_field( 'luoghi_marker', '', $id, 1 );
		$img = ( $img ?: scm_field( 'tools_gmap_marker', '', 'option' ) );

		$marker = ( $img ? ' data-img="' . $img . '"' : '' );

		if( $lat && $lng ){
			indent( $indent+1, '<div id="marker-' . $id . '" class="' . 'scm-marker marker" data-lat="' . $lat . '" data-lng="' . $lng . '"' . $marker . '>' );
					indent( $indent+2, '<strong>' . scm_field( 'luoghi_nome', '', $id, 1 ) . '</strong><br>' );
					indent( $indent+2, '<span>' . scm_field( 'luoghi_indirizzo', '', $id, 1 ) . ', ' . scm_field( 'luoghi_citta', '', $id, 1 ) . '</span>' );
			indent( $indent+1, '</div>' );
		}
	}
}

indent( $indent, '</div><!-- map -->' );

?>