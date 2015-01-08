<?php
/**
 * @package SCM
 */

global $SCM_galleries, $post;

$type = get_post_type();
$title = get_the_title();

$b_init = ( isset( $this ) ? $this->b_init : 0 );
$b_type = ( isset( $this ) ? $this->b_type : 'img');
$b_img = ( isset( $this ) ? $this->b_img : 0 );
$b_size = ( isset( $this ) ? $this->b_size : '150px' );
$b_txt = ( isset( $this ) ? $this->b_txt : 'Galleria');
$b_bg = ( isset( $this ) ? $this->b_bg : '');
$b_mod = ( isset( $this ) ? $this->b_mod : '');

$gallery = get_field( 'gallerie_immagini' );

$style = ( $b_bg ? ' style="background-image: transparent url(\'' . $b_bg . '\') no-repeat center center;' : '' );

$SCM_galleries[$type . '-' . get_the_ID()] = array( 'init' => $b_init, 'title' => $title, 'gallery' => $gallery );


$classes = array(
	$type . '-' . $post->post_name,
	'clear'
);

echo '<div id="' . $type . '-' . get_the_ID() . '" class="pointer ' . SCM_PREFIX . 'object ' . implode( " ", $classes ) . ' ' . implode( " ", get_post_class() ) . '"' . $style . '>';

	switch ($b_type) {
		case 'img':
			echo '<img src="' . $gallery[$b_img]['sizes']['thumbnail'] . '" width="' . $b_size . '" height="' . $b_size . '" />';
		break;
		
		case 'txt':
			echo $b_txt;
		break;

		case 'module':
			if( !$b_mod ) break;
			$post = $b_mod;
			setup_postdata( $post );
			get_template_part( SCM_PARTS_SINGLE, 'scm' );

		break;
	}

echo '</div><!-- ' . $type . ' -->';

?>