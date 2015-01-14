<?php

global $post, $SCM_styles;

$type = $post->post_type;

$id = $post->ID;
$slug = $post->post_name;
$class = get_post_class();

$custom_id = ( get_field('custom_id') ? get_field('custom_id') : $type . '-' . $id );
$custom_classes = ( get_field('custom_classes') ? get_field('custom_classes') . ' ' : '' );

$single = ( ( isset($this) && isset($this->single) ) ? ' ' . $this->single : 0 );

$custom = ( ( $type == 'page' || $single ) ? 1 : 0 );

$custom_head = ( ( !get_field( 'flexible_headers' ) && $single && get_field( 'flexible_headers_' . $type, 'option' ) ) ? '_' . $type : '' );
$custom_foot = ( ( !get_field( 'flexible_footers' ) && $single && get_field( 'flexible_footers_' . $type, 'option' ) ) ? '_' . $type : '' );

$header = ( get_field( 'flexible_headers' ) ? $id : ( $custom && sizeof( get_field( 'flexible_headers' . $custom_head, 'option' ) ) ? 'option' : null ) );
$footer = ( get_field( 'flexible_footers' ) ? $id : ( $custom && sizeof( get_field( 'flexible_footers' . $custom_foot, 'option' ) ) ? 'option' : null ) );

$tag = ( $type == 'page' ? 'article' : ( $type == 'scm-sections' ? 'section' : 'div' ) );

// *** Content Styles (pages, rows, modules)
$txt_align = ( get_field( 'select_txt_alignment' ) != 'default' ? get_field( 'select_txt_alignment' ) : $SCM_styles['align'] );
$txt_size = ( get_field( 'select_txt_size' ) != 'default' ? get_field( 'select_txt_size' ) : $SCM_styles['size'] );

$color = ( get_field('text_color') != null ? 'color:rgba(' . hex2rgba( get_field('text_color'), get_field('text_alpha') ) . ');' : '' );
$opacity = ( get_field('text_opacity') != null ? 'opacity:' . get_field('text_opacity', 'option') . ';' : '' );
$shadow = ( get_field('text_shadow') ? 'text-shadow:' . get_field('text_shadow_x') . 'px ' . get_field('text_shadow_y') . 'px ' . get_field('text_shadow_size') . 'px rgba(' . hex2rgba( get_field('text_shadow_color'), get_field('text_shadow_alpha') ) . ');' : '' );
$font = font2string( get_field( 'select_webfonts_families' ), get_field( 'select_webfonts_default_families' ), true );

$bg_image = ( get_field('background_image') ? 'background-image: url(' . get_field('background_image') . ');' : '' );
$bg_repeat = ( ( $bg_image && get_field('select_bg_repeat') != 'default' ) ? 'background-repeat:' . get_field('select_bg_repeat') . ';' : '' );
$bg_position = ( ( $bg_image && get_field('background_position') != null ) ? 'background-position:' . get_field('background_position')  . ';' : '' );
$bg_size = ( ( $bg_image && get_field('background_size') != null ) ? 'background-size:' . get_field('background_size')  . ';' : '' );
$bg_color = ( ( $bg_image && get_field('background_color') != null ) ? 'background-color:rgba(' . hex2rgba( get_field('background_color'), get_field('background_alpha') ) . ');' : '' );

$margin = ( get_field('margin') != 'default' ? ( get_field('margin') ? 'margin: ' . get_field('margin') . ';' : '' ) : '');
$padding = ( get_field('padding') != 'default' ? ( get_field('padding') ? 'padding: ' . get_field('padding') . ';' : '' ) : '');


$add_class = ( ( isset($this) && isset($this->add_class) ) ? ' ' . $this->add_class : '' );
$full = ( $type != 'scm-modules' || ( $type == 'scm-modules' && !$add_class ) ? ' full' : $add_class );

// *** Container Styles (sections)

$sc_bg_image = ( get_field('background_image_sc') ? 'background-image: url(' . get_field('background_image_sc') . ');' : '' );
$sc_bg_repeat = ( ( $sc_bg_image && get_field('select_bg_repeat_sc') != 'default' ) ? 'background-repeat:' . get_field('select_bg_repeat_sc') . ';' : '' );
$sc_bg_position = ( ( $sc_bg_image && get_field('background_position_sc') != null ) ? 'background-position:' . get_field('background_position_sc')  . ';' : '' );
$sc_bg_size = ( ( $sc_bg_image && get_field('background_size_sc') != null ) ? 'background-size:' . get_field('background_size_sc')  . ';' : '' );
$sc_bg_color = ( ( $sc_bg_image && get_field('background_color_sc') != null ) ? 'background-color:rgba(' . hex2rgba( get_field('background_color_sc'), get_field('background_alpha_sc') ) . ');' : '' );
$sc_margin = ( get_field('margin_sc') ? ( get_field('margin_sc') ? 'margin: ' . get_field('margin_sc') . ';'  : '' ) : '');
$sc_padding = ( get_field('padding_sc') ? ( get_field('padding_sc') ? 'padding: ' . get_field('padding_sc') . ';' : '' ) : '');


$style = $color . $opacity . $shadow . $font . $bg_image . $bg_repeat . $bg_position . $bg_size . $bg_color . $margin . $padding;
$row_style = '';
$align = $txt_align;

$row_id = $custom_id . '-row';

$row_layout = ( get_field('select_layout_row') != 'default' ? get_field('select_layout_row') : ( get_field('select_layout_page', 'option') != 'responsive' ? ( get_field('select_layout_cont', 'option') ? get_field('select_layout_cont', 'option') : 'full' ) : 'full') );
$row_class = $txt_align . ' ' . $row_layout . ' row ' . SCM_PREFIX . 'row ' . $type . '-row';


if( $tag == 'section' ){
	$row_style = ( $style ? $style : '' );
	$style = $sc_bg_image . $sc_bg_repeat . $sc_bg_position . $sc_bg_size . $sc_bg_color . $sc_margin . $sc_padding;
	$align = ( get_field('select_alignment_site', 'option') ? get_field('select_alignment_site', 'option') : 'center' );
}

$classes =  $custom_classes . $align . ' ' . $txt_size . $full . ' ' . implode( ' ', $class ) . ' ' . $slug . ' ' . SCM_PREFIX . 'object';

echo '<' . $tag . ' id="' . $custom_id . '" class="' . $classes . '" style="' . $style . '"">';
	
	// --- Header

	if( $header )
		scm_custom_header( $header, $type, $custom_head );


	if( $type == 'scm-sections' )
		echo '<row id="' . $row_id . '" class="' . $row_class . '" style="' . $row_style . '">';

	// --- Content
	
	//$post = $value[0];
	//setup_postdata( $post );
	get_template_part( SCM_DIR_PARTS_SINGLE, $type );


	if( $type == 'scm-sections' )
		echo '</row><!-- ' . $type . '-row -->';


	// --- Footer
	if( $footer )
		scm_custom_footer( $footer, $type, $custom_foot, $txt_align );


echo '</' . $tag . '><!-- ' . $type . ' -->';


?>