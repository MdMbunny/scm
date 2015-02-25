<?php

// +++ todo: Slide diventa un nuovo Post Type e avrà il suo ID

global $post;

$type = $post->post_type;
$slug = $post->post_name;

$id = $post->ID;

$slides = scm_field( 'flexible_headers', array() );

$default = ( scm_field( 'select_layout_page', 'full', 'option' ) === 'responsive' ? 'full' : scm_field( 'select_layout_head', 'responsive', 'option' ) );
$layout = scm_field( 'select_layout_slider', $default );

$slider = scm_field( 'select_slider', 'nivo', 'option' );
$slider_class = 'slider ' . $slider . ' ' . $layout . ' mask';

$height = scm_field( 'height_slider', 'initial' );

$theme = scm_field( 'themes_slider', 'scm' );

$effect = scm_field( 'select_effect_nivo', 'fold' );
$slices = scm_field( 'slices_options_slider', '15' );
$cols = scm_field( 'cols_options_slider', '8' );
$rows = scm_field( 'rows_options_slider', '4' );
$speed = (float)scm_field( 'speed_options_slider', '.5' ) * 1000;
$time = (float)scm_field( 'pause_options_slider', '5' ) * 1000;
$start = scm_field( 'start_options_slider', '0' );
$random = 'false';
if( $start == -1 ){
	$start = '0';
	$random = 'true';
}
$hover = scm_field( 'hover_options_slider', 'true' );
$manual = scm_field( 'manual_options_slider', 'false' );
$direction = scm_field( 'direction_options_slider', 'true' );
$control = scm_field( 'control_options_slider', 'false' );
$thumbs = scm_field( 'thumbs_options_slider', 'false' );
$next = scm_field( 'next_options_slider', 'fa-angle-right' );
$prev = scm_field( 'prev_options_slider', 'fa-angle-left' );
    
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
	
	$i = 0;
    foreach ($slides as $slide) {
        $i++;
        $img = $slide[ 'immagine' ];
        $link = ( $slide[ 'slide_link' ] == 'page' ? $slide[ 'slide_internal' ] : ( $slide[ 'slide_link' ] == 'link' ? $slide[ 'slide_external' ] : '' ) );
        $caption = '';
        $slide_id = $slide[ 'slide_id' ];
        $slide_class = $slide[ 'slide_class' ];
        $title = '';

        $caption_id = 'caption-' . $id . '-' . $i;

        $top = ( $slide[ 'caption_top' ] != '' ? $slide[ 'caption_top' ] . '%' : 'initial' );
        $right = ( $slide[ 'caption_right' ] != '' ? $slide[ 'caption_right' ] . '%' : 'initial' );
        $bottom = ( $slide[ 'caption_bottom' ] != '' ? $slide[ 'caption_bottom' ] . '%' : 'initial' );
        $left = ( $slide[ 'caption_left' ] != '' ? $slide[ 'caption_left' ] . '%' : 'initial' );
        $class = 'box center' . ( $slide_class ? ' ' . $slide_class : '' );
        $style = ' style="top:' . $top . ';right:' . $right . ';bottom:' . $bottom . ';left:' . $left . ';"';
            
            
            if( $slide[ 'active_caption' ] ){

            	$caption = indent( $indent + 2 ) . '<div id="' . $caption_id . '" class="nivo-html-caption' . ( $slide_class ? ' ' . $slide_class : '' ) . ' count-' . $i . '">' . lbreak();
                $caption .= indent( $indent + 3 ) . '<div' . ( $slide_id ? ' id="' . $slide_id . '"' : '' ) . ' class="' . $class . '"' . $style . '>' . lbreak();
                    
                        $caption .= ( $slide[ 'caption_title'] ? indent( $indent + 4 ) . '<h3>' . $slide[ 'caption_title' ] . '</h3>' . lbreak() : '' );
                        $caption .= indent( $indent + 4 ) . $slide['caption'];
                    
                $caption .= indent( $indent + 3 ) . '</div>' . lbreak();

                $caption .= indent( $indent + 2 ) . '</div>' . lbreak();
            }

        

        $title = ( $caption ? ' title="#' . $caption_id . '"' : '' );
        
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