<?php
/**
 * @package SCM
 */

global $post;

$type = get_post_type();

$show_map = true;
$show_address = 'no';
$map_width = "100%";
$map_height = "400px";
$address_separator = ' &mdash; ';
$province_prefix = '(';
$province_suffix = ')';

if( isset($this) ){
	$show_map = $this->luogo_show_map;
	$show_address = $this->luogo_show_address;
}

$country = ( get_field('luoghi_paese') ? get_field('luoghi_paese') : '' );
$region = ( get_field('luoghi_regione') ? get_field('luoghi_regione') : '' );
$province = ( get_field('luoghi_provincia') ? $province_prefix . get_field('luoghi_provincia') . $province_suffix : '' );
$code = ( get_field('luoghi_cap') ? get_field('luoghi_cap') : '' );
$city = ( get_field('luoghi_citta') ? get_field('luoghi_citta') : '' );
$town = ( get_field('luoghi_frazione') ? get_field('luoghi_frazione') : '' );
$address = ( get_field('luoghi_indirizzo') ? get_field('luoghi_indirizzo') : '' );

$lat = ( get_field('luoghi_lat') ? get_field('luoghi_lat') : '' );
$lng = ( get_field('luoghi_lng') ? get_field('luoghi_lng') : '' );

print('HERE');
print($lat);

$address = ( $address && ( $town || $city || $code || $province ) ? $address . $address_separator : $address );
$town = ( ( $town && ( $city || $code || $province ) ) ? $town . ' ' : $town );
$code = ( ( $code && ( $city || $province ) ) ? $code . ' ' : $code );
$city = ( ( $city && $province ) ? $city . ' ' : $city );
$province = ( ( $province && ( $region || $country ) ) ? $province . $address_separator : $province );
$region = ( ( $region && $country ) ? $region . ' ' : $region );

$inline_address = $address . $town . $code . $city . $province . $region . $country;

$classes = array(
	$type . '-' . $post->post_name,
	'clear'
);


echo '<div id="' . $type . '-' . get_the_ID() . '" class="' . SCM_PREFIX . 'object ' . implode( " ", $classes ) . ' ' . implode( " ", get_post_class() ) . '">';

	if($show_address == 'up'){
		echo '<div class="scm-address address">';
			echo $inline_address;
		echo '</div>';
	}

	if($show_map){

		if( $lat && $lng ){
			echo '<div class="scm-map map full">';
				echo '<div class="scm-marker marker" data-lat="' . $lat . '" data-lng="' . $lng . '"></div>';
			echo '</div>';
		}
		
	}

	if($show_address == 'dw'){
		echo '<div class="scm-address address">';
			echo $inline_address;
		echo '</div>';
	}

echo '</div><!-- ' . $type . ' -->';



?>