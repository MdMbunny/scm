<?php

global $post, $SCM_styles;

$type = $post->post_type;
$id = $post->ID;
$slug = $post->post_name;
$class = get_post_class();

$custom_id = ( get_field('custom_id') ? get_field('custom_id') : $type . '-' . $id );

$tag = ( $type == 'page' ? 'article' : ( $type == 'scm-sections' ? 'section' : 'div' ) );

// *** Content Styles (pages, rows, modules)
$txt_align = ( get_field( 'select_txt_alignment' ) != 'default' ? get_field( 'select_txt_alignment' ) : $SCM_styles['align'] );
$txt_size = ( get_field( 'select_txt_size' ) != 'default' ? get_field( 'select_txt_size' ) : $SCM_styles['size'] );

$color = ( get_field('text_color') != null ? 'color:rgba(' . hex2rgba( get_field('text_color'), get_field('text_alpha') ) . ');' : '' );
$opacity = ( get_field('text_opacity') != null ? 'opacity:' . get_field('text_opacity', 'option') . ';' : '' );
$shadow = ( get_field('text_shadow') ? 'text-shadow:' . get_field('text_shadow_x') . 'px ' . get_field('text_shadow_y') . 'px ' . get_field('text_shadow_size') . 'px rgba(' . hex2rgba( get_field('text_shadow_color'), get_field('text_shadow_alpha') ) . ');' : '' );
$font = scm_fontsToString( get_field( 'select_webfonts_families' ), get_field( 'select_webfonts_default_families' ), true );

$bg_image = ( get_field('background_image') ? 'background-image: url(' . get_field('background_image') . ');' : '' );
$bg_repeat = ( ( $bg_image && get_field('select_bg_repeat') != 'default' ) ? 'background-repeat:' . get_field('select_bg_repeat') . ';' : '' );
$bg_position = ( ( $bg_image && get_field('background_position') != null ) ? 'background-position:' . get_field('background_position')  . ';' : '' );
$bg_size = ( ( $bg_image && get_field('background_size') != null ) ? 'background-size:' . get_field('background_size')  . ';' : '' );
$bg_color = ( ( $bg_image && get_field('background_color') != null ) ? 'background-color:rgba(' . hex2rgba( get_field('background_color'), get_field('background_alpha') ) . ');' : '' );

$margin = ( get_field('margin') != 'default' ? 'margin: ' . get_field('margin') . ';' : '');
$padding = ( get_field('padding') != 'default' ? 'padding: ' . get_field('padding') . ';' : '');

// *** Container Styles (sections)

$sc_bg_image = ( get_field('background_image_sc') ? 'background-image: url(' . get_field('background_image_sc') . ');' : '' );
$sc_bg_repeat = ( ( $sc_bg_image && get_field('select_bg_repeat_sc') != 'default' ) ? 'background-repeat:' . get_field('select_bg_repeat_sc') . ';' : '' );
$sc_bg_position = ( ( $sc_bg_image && get_field('background_position_sc') != null ) ? 'background-position:' . get_field('background_position_sc')  . ';' : '' );
$sc_bg_size = ( ( $sc_bg_image && get_field('background_size_sc') != null ) ? 'background-size:' . get_field('background_size_sc')  . ';' : '' );
$sc_bg_color = ( ( $sc_bg_image && get_field('background_color_sc') != null ) ? 'background-color:rgba(' . hex2rgba( get_field('background_color_sc'), get_field('background_alpha_sc') ) . ');' : '' );
$sc_margin = ( get_field('margin_sc') ? 'margin: ' . get_field('margin_sc') . ';' : '');
$sc_padding = ( get_field('padding_sc') ? 'padding: ' . get_field('padding_sc') . ';' : '');


$style = $color . $opacity . $shadow . $font . $bg_image . $bg_repeat . $bg_position . $bg_size . $bg_color . $margin . $padding;
$row_style = '';
$align = $txt_align;

$row_id = $custom_id . '-row';

$row_layout = ( get_field('select_layout_row') != 'default' ? get_field('select_layout_row') : ( get_field('select_layout_page', 'option') != 'responsive' ? ( get_field('select_layout_cont', 'option') ? get_field('select_layout_cont', 'option') : 'full' ) : 'full') );
$row_class = $txt_align . ' ' . $row_layout . ' row ' . SCM_PREFIX . 'row ' . $type . '-row';


if( $tag == 'section' ){
	$row_style = ( $style ? ' style="' . $style . '"' : '' );
	$style = $sc_bg_image . $sc_bg_repeat . $sc_bg_position . $sc_bg_size . $sc_bg_color . $sc_margin . $sc_padding;
	$align = ( get_field('select_alignment_site', 'option') ? get_field('select_alignment_site', 'option') : 'center' );
}

$style = ( $style ? ' style="' . $style . '"' : '' );


echo '<' . $tag . ' id="' . $custom_id . '" class="' . $align . ' ' . $txt_size . ( $type != 'scm-modules' ? ' full' : '' ) . ( isset($this) ? ' ' . $this->add_class : '' ) . ' ' . implode( " ", $class ) . ' ' . $slug . ' ' . SCM_PREFIX . 'object"' . $style . '>';

	if( have_rows('flexible_headers') ):

		echo '<header class="full ' . SCM_PREFIX . 'header ' . $type . '-header">';

			while ( have_rows('flexible_headers') ) : the_row();

				$layout = get_row_layout();

				$float = ( ( get_sub_field('select_float_img') && get_sub_field('select_float_img') != 'no' ) ? get_sub_field('select_float_img') : ( $txt_align == 'center' ? 'float-center' : 'no-float' ) );
				$float = ( $float == 'float-center' ? 'float-center text-center' : $float );

				switch ($layout) {
					case 'icon_element':
						$icon = get_sub_field('icona');
						$icon_size = get_sub_field('dimensione');

						echo 	'<div class="' . SCM_PREFIX . 'img ' . $layout . ' ' . $float . '" style="line-height:0;font-size:' . $icon_size . 'px;">
									<i class="fa ' . $icon . '"></i>
								</div><!-- ' . $type . '-icon -->';
					break;

					case 'image_element':
						$image = ( get_sub_field('immagine') ? get_sub_field('immagine') : '' );
						$image_fissa = ( get_sub_field('fissa') ? get_sub_field('fissa') : 'norm' );
						$image_size = ( get_sub_field('dimensione') ? get_sub_field('dimensione') . 'px' : '' );
						$image_width = ( get_sub_field('larghezza') ? get_sub_field('larghezza') . 'px' : 'auto' );
						$image_height = ( get_sub_field('altezza') ? get_sub_field('altezza') . 'px' : $image_width );

						$style = ( $image_fissa == 'quad' ? 'width:' . $image_size . '; height:' . $image_size . ';' : 'width:' . $image_width . '; height:' . $image_height . ';' );



						echo 	'<div class="' . SCM_PREFIX . 'img ' . $layout . ' ' . $float . '" style="' . $style . '">
									<img src="' . $image . '">
								</div><!-- ' . $type . '-icon-image -->';
					break;

					case 'full_element':
						$image = get_sub_field('immagine');
						$image_height = get_field('altezza');

						$style = '';
						$mask = '';
						if($image_height){
							$style = ' style="height:' . $image_height . 'px;"';
							$mask = ' mask';
						}

						echo	'<div class="' . SCM_PREFIX . 'img ' . $layout . ' ' . $float . $mask . '"' . $style . '>
									<img src="' . $image . '" class="full">
								</div><!-- ' . $type . '-image -->';
					break;

					case 'title_element':
						$text = get_sub_field('testo');
						$text_tag = ( get_sub_field('select_headings') != 'default' ? get_sub_field('select_headings') : get_field( 'select_headings' . '_1' , 'option') );
						$text_align = ( get_sub_field('select_txt_alignment_title') != 'default' ? get_sub_field('select_txt_alignment_title') . ' ' : '' );
						
						$class = '';

						if( strpos( $text_tag, '.' ) !== false ){
							$class = ' ' . substr( $text_tag, strpos($text_tag, '.') + 1 );
							$text_tag = 'h1';
						}

						echo '<' . $text_tag . ' class="' . $text_align . SCM_PREFIX . 'title ' . $type . '-title ' . $layout . ' clear' . $class . '">' . $text . '</' . $text_tag . '><!-- ' . $type . '-title -->';
					break;
				}

			endwhile;

		echo '</header><!-- ' . $type . '-header -->';
	endif;

	$back_query = $post;

	if( $type == 'scm-sections' )
		echo '<row id="' . $row_id . '" class="' . $row_class . '" style="' . $row_style . '"">';

	// --- Content
	get_template_part( SCM_PARTS_SINGLE, $type );


	if( $type == 'scm-sections' )
		echo '</row><!-- ' . $type . '-row -->';


	// --- Footer

	$post = $back_query;
	setup_postdata($post);


	if( have_rows('flexible_footers') ):

		echo '<footer class="full ' . SCM_PREFIX . 'footer ' . $type . '-footer">';

			while ( have_rows('flexible_footers') ) : the_row();

				$layout = get_row_layout();

				switch ($layout) {
					case 'text_element':

						$content = get_sub_field('testo');
						if(!$content) continue;
						echo $content;
							
					break;
				}

				endwhile;

		echo '</footer><!-- ' . $type . '-footer -->';
	endif;


echo '</' . $tag . '><!-- ' . $type . ' -->';


?>