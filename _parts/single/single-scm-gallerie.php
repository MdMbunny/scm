<?php
/**
 * @package SCM
 */

global $SCM_galleries, $post;

$id = $post->ID;
$type = $post->post_type;
$title = get_the_title();


$b_init = ( isset( $this ) ? $this->b_init : 0 );
$b_type = ( isset( $this ) ? $this->b_type : 'img');
$b_img = ( isset( $this ) ? $this->b_img : 0 );
$b_size = ( isset( $this ) ? $this->b_size : '150px' );
$b_txt = ( isset( $this ) ? $this->b_txt : 'Galleria');
$b_bg = ( isset( $this ) ? $this->b_bg : '');
$b_section = ( isset( $this ) ? $this->b_section : '');

$gallery = scm_field( 'gallerie_immagini', '', $id, 1 );

$style = ( $b_bg ? ' style="background-image: transparent url(\'' . $b_bg . '\') no-repeat center center;' : '' );

$custom_id = uniqid( 'gallery-' );
$section_class = 'gallery scm-gallery scm-object pointer';

$SCM_galleries[ $custom_id ] = $gallery;


echo '<div id="' . $custom_id . '" class="' . $classes . '"' . $style . ' 
			data-gallery="' . $b_type . '" 
			data-init="' . $b_init . '" 
			data-title="' .$title . '"
		>';

	switch ($b_type) {
		case 'img':
			echo '<img src="' . $gallery[$b_img]['sizes']['thumbnail'] . '" width="' . $b_size . '" height="' . $b_size . '" alt="" />';
		break;
		
		case 'txt':
			echo $b_txt;
		break;

		case 'section':
			if( !$b_section ) break;
			$post = $b_section;
			setup_postdata( $post );
			get_template_part( SCM_DIR_PARTS_SINGLE, 'scm-section' );

		break;
	}

echo '</div><!-- ' . $type . ' -->';

?>