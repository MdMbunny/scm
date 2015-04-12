<?php

global $post, $SCM_indent;

$type = $post->post_type;
$slug = $post->post_name;

$id = $post->ID;

$default = ( scm_field( 'layout-page', 'full', 'option' ) === 'responsive' ? 'full' : scm_field( 'layout-head', 'responsive', 'option' ) );
$layout = scm_field( 'slider-layout', $default );

$terms = scm_field( 'slider-slides-terms', '' );
$slides = get_posts( array( 'order' => 'ASC', 'post_type' => 'slides', 'taxonomies' => 'sliders', 'terms' => $terms ) );

$slider = scm_field( 'opt-tools-slider', 'nivo', 'option' );
$slider_class = 'slider ' . $slider . ' ' . $layout . ' mask';

$height = scm_field( 'slider-height-number', '' );
$height = ( $height ? $height . scm_field( 'slider-height-units', '' ) : 'auto' );

$theme = scm_field( 'slider-theme', 'scm' );

$effect = scm_field( 'select_effect_nivo', 'fold' );
$slices = scm_field( 'slider-slices', '15' );
$cols = scm_field( 'slider-cols', '8' );
$rows = scm_field( 'slider-rows', '4' );
$speed = (float)scm_field( 'slider-speed', '.5' ) * 1000;
$time = (float)scm_field( 'slider-pause', '5' ) * 1000;
$start = scm_field( 'slider-start', '0' );
$random = 'false';
if( $start == -1 ){
	$start = '0';
	$random = 'true';
}
$hover = scm_field( 'slider-pause', 'true' );
$manual = scm_field( 'slider-manual', 'false' );
$direction = scm_field( 'slider-direction', 'true' );
$control = scm_field( 'slider-control', 'false' );
$thumbs = scm_field( 'slider-thumbs', 'false' );
$next = scm_field( 'slider-next', 'fa-angle-right' );
$prev = scm_field( 'slider-prev', 'fa-angle-left' );

$indent = $SCM_indent + 1;
    
    echo indent( $indent + 2 ) . '<div class="' . $slider_class . '" ' . lbreak() .
            indent( $indent + 3 ) . 'data-slider="' . $slider . '" ' . lbreak() .
            indent( $indent + 3 ) . 'data-slider-theme="' . $theme . '" ' . lbreak() .
            indent( $indent + 3 ) . 'data-slider-effect="' . $effect . '" ' . lbreak() .
            indent( $indent + 3 ) . 'data-slider-slices="' . $slices . '" ' . lbreak() .
            indent( $indent + 3 ) . 'data-slider-cols="' . $cols . '" ' . lbreak() .
            indent( $indent + 3 ) . 'data-slider-rows="' . $rows . '" ' . lbreak() .
            indent( $indent + 3 ) . 'data-slider-speed="' . $speed . '" ' . lbreak() .
            indent( $indent + 3 ) . 'data-slider-time="' . $time . '" ' . lbreak() .
            indent( $indent + 3 ) . 'data-slider-start="' . $start . '" ' . lbreak() .
            indent( $indent + 3 ) . 'data-slider-random="' . $random . '" ' . lbreak() .
            indent( $indent + 3 ) . 'data-slider-hover="' . $hover . '" ' . lbreak() .
            indent( $indent + 3 ) . 'data-slider-manual="' . $manual . '" ' . lbreak() .
            indent( $indent + 3 ) . 'data-slider-direction="' . $direction . '" ' . lbreak() .
            indent( $indent + 3 ) . 'data-slider-control="' . $control . '" ' . lbreak() .
            indent( $indent + 3 ) . 'data-slider-thumbs="' . $thumbs . '" ' . lbreak() .
            indent( $indent + 3 ) . 'data-slider-prev="' . $prev . '" ' . lbreak() .
            indent( $indent + 3 ) . 'data-slider-next="' . $next . '" ' . lbreak() .
            indent( $indent + 3 ) . 'data-max-height="' . $height . '" ' . lbreak() .
            indent( $indent + 3 ) . 'data-equal="img" ' . lbreak() .
            indent( $indent + 3 ) . 'data-equal-max="height" ' . lbreak() .
        indent( $indent + 2 ) . '>' . lbreak( 2 );

    $captions = '';
    $images = '';
	
	$i = 0;

    foreach ($slides as $elem) {
        $elem = ( is_numeric( $elem ) ? $elem : $elem->ID );
        $slide = get_fields($elem);
        $i++;
        $img = $slide[ 'slide-image' ];
        $link = ( $slide[ 'slide-link' ] == 'page' ? $slide[ 'slide-internal' ] : ( $slide[ 'slide-link' ] == 'link' ? $slide[ 'slide-external' ] : '' ) );
        $caption = '';
        $slide_id = ( $slide[ 'selectors-id' ] ? ' id="' . $slide[ 'selectors-id' ] . '"' : '' );
        $slide_class = 'caption box center' . ( $slide[ 'selectors-class' ] ? ' ' . $slide[ 'selectors-class' ] : '' );
        $title = '';

        $top = ( $slide[ 'slide-caption-top' ] != '' ? $slide[ 'slide-caption-top' ] . '%' : 'initial' );
        $right = ( $slide[ 'slide-caption-right' ] != '' ? $slide[ 'slide-caption-right' ] . '%' : 'initial' );
        $bottom = ( $slide[ 'slide-caption-bottom' ] != '' ? $slide[ 'slide-caption-bottom' ] . '%' : 'initial' );
        $left = ( $slide[ 'slide-caption-left' ] != '' ? $slide[ 'slide-caption-left' ] . '%' : 'initial' );
        $style = ' style="top:' . $top . ';right:' . $right . ';bottom:' . $bottom . ';left:' . $left . ';"';
            
        $caption_id = 'slide-' . $id . '-' . $i;
            
        	$caption = indent( $indent + 2 ) . '<div id="' . $caption_id . '" class="nivo-html-caption count-' . $i . '">' . lbreak();
            $caption .= indent( $indent + 3 ) . '<div' . $slide_id . ' class="' . $slide_class . '"' . $style . '>' . lbreak();

                //if( $slide[ 'select_disable_caption' ] == 'on' ){
                
                    $caption .= ( $slide[ 'slide-caption-title'] ? indent( $indent + 4 ) . '<h3>' . $slide[ 'slide-caption-title' ] . '</h3>' . lbreak() : '' );
                    $caption .= indent( $indent + 4 ) . $slide['slide-caption-cont'];
                //}
                
            $caption .= indent( $indent + 3 ) . '</div>' . lbreak();

            $caption .= indent( $indent + 2 ) . '</div>' . lbreak();

        $title = ( sizeof( $slides ) > 1 ? ' title="#' . $caption_id . '"' : '' );
        
        $images .= indent( $indent + 3 );
        $images .= ( $link ? '<a href="' . $link . '">' : '' );
            $images .= '<img class="slide-image" src="' . $img . '" alt=""' . $title . '>';
            //$images .= '<img class="slide-image" src="' . $img . '" data-thumb="' . $img . '" alt="" title="' . $title . '">';
        $images .= ( $link ? '</a>' : '' );
        $images .= lbreak();

        $captions .= $caption;

    }

    echo $images;

    echo lbreak() . indent( $indent + 2 ) . '</div>' . lbreak( 2 );   

    echo $captions . lbreak();


?>