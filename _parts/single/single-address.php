<?php

/**
 * single-address.php
 *
 * Part Single Address content.
 *
 * @link http://www.studiocreativo-m.it
 *
 * @package SCM
 * @subpackage Parts/Single/Address
 * @since 1.0.0
 */

global $post, $SCM_indent;
$post_id = $post->ID;
$post_type = $post->post_type;

$args = array(
	'element' => 0,
	'googlemaps' => 0,
	'separator' => '-',
	'icon' => 'on',
	'alignment' => 'left',
	'id' => '',
    'class' => '',
    'attributes' => '',
    'style' => '',
);

if( isset( $this ) )
	$args = ( isset( $this->cont ) ? array_merge( $args, toArray( $this->cont ) ) : array() );

$element = ( $args['element'] ?: scm_field( 'luoghi', 0, $post_id ) );
if( !$element ){

	if( $post_type === 'luoghi' )
		$element = array( $post_id );
	else if( $post_type === 'soggetti' )
		$element = scm_field( 'soggetto-luoghi', array(), $post_id );
	else
		$element = scm_field( 'luoghi', array(), $post_id );

}else if( !is_array( $element ) ){
	if( is_numeric( $element ) )
		$element = array( $element );
	else
		$element = array( $element->ID );
}

$icon = ( $args['icon'] != 'no' ? $args['icon'] : '' );

$class = 'address scm-address scm-object object scm-list list ' . $icon . ' ' . $args['class'];

$attributes = $args['attributes'];
$googlemaps = $args['googlemaps'];
$style = $args['style'];
$id = $args['id'];

$align = ifnotequal( $args['alignment'], 'default', scm_field( 'style-txt-set-alignment', 'left', 'option' ) );

indent( $SCM_indent + 1, openTag( 'ul', $id, $class, $style, $attributes ), 2 );

if( is( $element ) ){

	foreach( $element as $luogo ){

		$fields = get_fields( $luogo );
		$marker = scm_utils_preset_map_marker( $luogo, $fields );

		$name = ex_attr( $fields, 'luogo-nome', '' );
		$country = ex_attr( $fields, 'luogo-paese', '' );
		$region = ex_attr( $fields, 'luogo-regione', '' );
		$province = ex_attr( $fields, 'luogo-provincia', '', '(', ')' );
		$code = ex_attr( $fields, 'luogo-cap', '' );
		$city = ex_attr( $fields, 'luogo-citta', '' );
		$town = ex_attr( $fields, 'luogo-frazione', '' );
		$address = ex_attr( $fields, 'luogo-indirizzo', '' );

		$town = ( ( $town && ( $city || $code || $province ) ) ? $town . ' ' : $town );
		$code = ( ( $code && ( $city || $province ) ) ? $code . ' ' : $code );
		$city = ( ( $city && $province ) ? $city . ' ' : $city );
		$region = ( ( $region && $country ) ? $region . ', ' : $region );
		$country = ( $country ? $country : '' );
		
		$inline_address = ( $name ? '<strong class="name">' . $name . '</strong><br>' : '' );
		
		if( $address ){
			$inline_address .= '<span class="street">' . $address . '</span>';
		}

		if( $town || $city || $code || $province ){
			$inline_address .= ( $args['separator'] ? '<span class="separator">' . $args['separator'] . '</span><span class="town">' : '<span class="float-none town">' );
			$inline_address .= $town . $code . $city . $province . '</span>';
		}

		if( $region || $country ){
			$inline_address .= ( $args['separator'] ? '<span class="separator">' . $args['separator'] . '</span><span class="country">' : '<span class="float-none country">' );
			$inline_address .= $region . $country . '</span>';
		}
		
		// +++ todo: questo LI deve diventare un BUTTON. Crea un file single-button e usalo anche in single-list (e dove altro serve)
		$li_class = 'button scm-button ' . $align;
		$li_attr = '';
		$i_style = ifnotequal( $marker['data'], 'img', '', ' color:', ';' );
		$i_class = 'bullet ' . ( $icon == 'inside' ? ' float-' . $align : '' );
		

		if( $googlemaps )
			$li_attr = ' data-href="' . googleMapsLink( $address . ' ' . $town . ' ' . $code . ' ' . $city . ' ' . $country ) . '"';

		indent( $SCM_indent, openTag( 'li', '', ( $icon == 'inside' ? $li_class : '' ), '', $li_attr ), 1 );

        if( $icon && $icon !== 'no' ){
        	if( !$i_style )
        		indent( $SCM_indent + 1, '<img src="' . $marker['icon'] . '" class="' . $i_class . '" />', 1 );
        	else
	            indent( $SCM_indent + 1, openTag( 'i', '', $i_class . ' fa ' . $marker['icon'], $i_style, '' ) . '</i>', 1 );
        }

        	indent( $SCM_indent + 1, openTag( 'span', '', ( $icon == 'outside' ? $li_class : '' ), '', '' ) . $inline_address . '</span>', 1 );

        indent( $SCM_indent, '</li>', 2 );
		
	}
}

indent( $SCM_indent, '</ul><!-- address -->' );

?>