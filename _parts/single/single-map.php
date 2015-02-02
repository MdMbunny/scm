<?php
/**
 * @package SCM
 */

global $post;

$type = 'map';

$luoghi = array();
$width = 100;
$zoom = 10;

if( isset($this) ){
	$luoghi = ( isset($this->map_luoghi) ? $this->map_luoghi : array() );
	$width = ( isset($this->map_width) ? $this->map_width >= 0 : 100 );
	$zoom = ( isset($this->map_zoom) ? $this->map_zoom : 10 );
}

$id = uniqid( $type . '-' );
$classes = SCM_PREFIX . 'object ' . SCM_PREFIX . $type . ' ' . $type . ' full';

//echo '<div id="' . $id . '" class="' . $classes . '">';

	echo '<div class="' . $classes . '" data-zoom="' . $zoom . '">';	

	if($luoghi){

		$output = '';

		foreach( $luoghi as $luogo ){

			$id = $luogo->ID;
			$lat = get_field('luoghi_lat', $id);
			$lng = get_field('luoghi_lng', $id);

			$marker = ( get_field('luoghi_marker', $id) ? ' data-img="' . get_field('luoghi_marker', $id) . '"' : '' );

			if( $lat && $lng ){
				echo '<div id="marker-' . $id . '" class="' . SCM_PREFIX . 'marker marker" data-lat="' . $lat . '" data-lng="' . $lng . '"' . $marker . '>';
						echo '<strong>' . get_field('luoghi_nome', $id) . '</strong><br>';
						echo '<span>' . get_field('luoghi_indirizzo', $id) . ', ' . get_field('luoghi_citta', $id) . '</span>';
				echo '</div>';
			}
		}
	}

	echo '</div><!-- ' . SCM_PREFIX . $type . ' -->';

?>