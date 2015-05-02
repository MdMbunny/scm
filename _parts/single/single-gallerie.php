<?php
/**
 * @package SCM
 */


global $SCM_galleries, $SCM_indent, $post;

printPre('GALLERIA ' . $post->ID);

/*

$id = $post->ID;
$type = $post->post_type;
$title = get_the_title();


$b_init = ( isset( $this ) ? $this->b_init : 0 );
$b_type = ( isset( $this ) ? $this->b_type : 'img');
$b_img = ( isset( $this ) ? $this->b_img : 0 );
$b_size = ( isset( $this ) ? $this->b_size : 150 );
$b_units = ( isset( $this ) ? $this->b_units : 'px' );
$b_txt = ( isset( $this ) ? $this->b_txt : 'Galleria');
$b_bg = ( isset( $this ) ? $this->b_bg : '');
$b_section = ( isset( $this ) ? $this->b_section : '');

$gallery = scm_field( 'gallerie_immagini', '', $id, 1 );

$style = ( $b_bg ? ' style="background-image: transparent url(\'' . $b_bg . '\') no-repeat center center;' : '' );

$custom_id = uniqid( 'gallery-' );
$section_class = 'gallery scm-gallery object scm-object ' . $post->post_name . ' pointer';

$SCM_galleries[ $custom_id ] = $gallery;

$indent = $SCM_indent + 1;

indent( $indent, '<div id="' . $custom_id . '" class="' . $classes . '"' . $style . '
			data-gallery="' . $custom_id . '" 
			data-init="' . $b_init . '" 
			data-title="' .$title . '"
		>' );

	switch ($b_type) {
		case 'img':
			indent( $indent+1, '<img src="' . $gallery[$b_img]['sizes']['thumbnail'] . '" width="' . $b_size . $b_units '" height="' . $b_size . b_units '" alt="" />' );
		break;
		
		case 'txt':
			indent( $indent+1, $b_txt );
		break;

		case 'section':
			if( !$b_section ) break;

			$SCM_indent += 1;

			$post = $b_section;
			setup_postdata( $post );
			get_template_part( SCM_DIR_PARTS_SINGLE, 'row' );

			$SCM_indent -= 1;

		break;
	}

indent( $indent, '</div><!-- ' . $type . ' -->' );
*/
?>