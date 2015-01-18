<?php

// PER TUTTI
global $post;

$type = $post->post_type;

$id = $post->ID;
$slug = $post->post_name;
$class = get_post_class();

$custom_id = ( get_field('custom_id') ? get_field('custom_id') : $type . '-' . $id );
$custom_classes = ( get_field('custom_classes') ? get_field('custom_classes') . ' ' : '' );

// SERVE SOLO PER CUSTOM HEAD E FOOT, NO MODULE
$single = ( ( isset($this) && isset($this->single) ) ? ' ' . $this->single : 0 );

$custom = ( ( $type == 'page' || $single ) ? 1 : 0 );

// VIA CUSTOM HEAD E FOOT DA MODULE
$custom_head = ( ( !get_field( 'flexible_headers' ) && $single && get_field( 'flexible_headers_' . $type, 'option' ) ) ? '_' . $type : '' );
$custom_foot = ( ( !get_field( 'flexible_footers' ) && $single && get_field( 'flexible_footers_' . $type, 'option' ) ) ? '_' . $type : '' );

$header = ( get_field( 'flexible_headers' ) ? $id : ( $custom && sizeof( get_field( 'flexible_headers' . $custom_head, 'option' ) ) ? 'option' : null ) );
$footer = ( get_field( 'flexible_footers' ) ? $id : ( $custom && sizeof( get_field( 'flexible_footers' . $custom_foot, 'option' ) ) ? 'option' : null ) );

// OGNUNO IL SUO
$tag = ( $type == 'page' ? 'article' : ( $type == 'scm-sections' ? 'section' : 'div' ) );

// VERIFICA
$add_class = ( ( isset($this) && $this->add_class ) ? $this->add_class . ' ' : '' );
$full = ( $type != 'scm-modules' || ( $type == 'scm-modules' && !$add_class ) ? 'full ' : $add_class );

$style = scm_options_get_style( $id, 1 );

// SOLO SECTIONS
$sc_bg = scm_options_get( 'bg_image', array( 'type' => 'sc', 'target' => $id ), 1 );
if( $sc_bg ){
	$sc_bg .= scm_options_get( 'bg_repeat', array( 'type' => 'sc', 'target' => $id ), 1 );
	$sc_bg .= scm_options_get( 'bg_position', array( 'type' => 'sc', 'target' => $id ), 1 );
	$sc_bg .= scm_options_get( 'bg_size', array( 'type' => 'sc', 'target' => $id ), 1 );
}
$sc_bg .= scm_options_get( 'bg_color', array( 'type' => 'sc', 'target' => $id ), 1 );

$row_style = '';
$row_id = $custom_id . '-row';
$row_layout = ( get_field('select_layout_row') != 'default' ? get_field('select_layout_row') : ( get_field('select_layout_page', 'option') != 'responsive' ? ( get_field('select_layout_cont', 'option') ? get_field('select_layout_cont', 'option') : 'full' ) : 'full') );
$row_class = $row_layout . ' row ' . SCM_PREFIX . 'row ' . $type . '-row';

if( $tag == 'section' ){
	$row_style = ( $style ? $style : '' );
	$style = ( $sc_bg ? ' style="' . $sc_bg . '"' : '' );
}

// TUTTI
$classes =  $custom_classes . $full . implode( ' ', $class ) . ' ' . $slug . ' ' . SCM_PREFIX . 'object';

// PROBABILMENTE SOLO PER PAGE E SECTION, I MODULE e I LIGHT MODULE VENGONO COSTRUITI DA SECTION DOVE VENGONO CARICATI SOLO I CONTENUTI
echo '<' . $tag . ' id="' . $custom_id . '" class="' . $classes . '" ' . $style . '>';
	
	// --- Header
	
	// NO MODULE
	if( $header )
		scm_custom_header( $header, $type, $custom_head );

	// SOLO SECTION
	if( $type == 'scm-sections' )
		echo '<row id="' . $row_id . '" class="' . $row_class . '" ' . $row_style . '>';

	// --- Content
	// RIVEDI
	if( $type == 'scm-modules' )
		scm_flexible_content( get_field('flexible_content') );
	else
		get_template_part( SCM_DIR_PARTS_SINGLE, $type );

	// SOLO SECTION
	if( $type == 'scm-sections' )
		echo '</row><!-- ' . $type . '-row -->';

	// NO MODULE
	// --- Footer
	if( $footer )
		scm_custom_footer( $footer, $type, $custom_foot );

// PROBABILMENTE SOLO PER PAGE E SECTION, I MODULE e I LIGHT MODULE VENGONO COSTRUITI DA SECTION DOVE CENGONO CARICATI SOLO I CONTENUTI
echo '</' . $tag . '><!-- ' . $type . ' -->';


?>