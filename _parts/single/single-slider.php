<?php

/**
 * single-slider.php
 *
 * Part Single Slider content.
 *
 * @link http://www.studiocreativo-m.it
 *
 * @package SCM
 * @subpackage Parts/Single/Slider
 * @since 1.0.0
 */

global $post, $SCM_indent;
$post_id = $post->ID;

$args = array(
    'acf_fc_layout' => 'layout-slider',
    'slider' => 0,
    'slider-terms' => 0,
    'meta_key' => 0,
    'meta_value' => '',
    'type' => 'nivo',
    'slides' => 0,
    'theme' => 'scm',
    'alignment' => 'top',
    'height-number' => 300,
    'height-units' => 'px',
    'effect' => 'fade',
    //'slices' => 30,
    //'cols' => 8,
    //'rows' => 8,
    'speed' => 1,
    'pause' => 3,
    'start' => 0,
    'hover' => 'true',
    'manual' => 'false',
    'direction' => 'true',
    'control' => 'false',
    //'thumbs' => 'off',
    'prev' => 'fa-angle-left',
    'next' => 'fa-angle-right',
    'id' => '',
    'class' => '',
    'attributes' => '',
    'style' => '',
);

if( isset( $this ) )
    $args = ( isset( $this->cont ) ? array_merge( $args, toArray( $this->cont ) ) : array() );

$class = 'slider scm-slider full mask ' . $args['class'];

$attributes = $args['attributes'];
$style = $args['style'];
$id = $args['id'];
$slides = $args['slides'];
$slider = $args['slider'];

if( !$slides ){
    if( $args['meta_key'] && $args['meta_value'] ){
        $slides = get_posts( array(
            'order' => 'DESC',
            'post_type' => 'slides',
            'posts_per_page' => -1,
            'meta_query' => array (
                array (
                    'key' => $args['meta_key'],
                    'value' => $args['meta_value'],
                    'compare' => 'LIKE'
                )
            )
        ) );
    }else{
        $slider = get_term( ( $args['slider'] ?: $args['slider-terms'] ), 'sliders' );
        // +++ todo:  diventa wp query? che poi chiama single-slide?
        $slides = get_posts( array(
            'order' => 'DESC',
            'post_type' => 'slides',
            'posts_per_page' => -1,
            'taxonomy' => 'sliders',
            'term' => $slider->slug,
        ) );
    }
}

$type = $args['type'];

$class .= ' ' . $type . ' ' . scm_field( 'alignment', $args['alignment'], $slider );
$height = scm_field( 'height-number', $args['height-number'], $slider );
$height = ( $height ? $height . scm_field( 'height-units', $args['height-units'], $slider ) : 'auto' );
$style .= ' height:' . $height . ';';

//$theme = scm_field( 'theme', 'scm', $slider );
$theme = $args['theme'];

$effect = 'fade';// scm_field( 'effect', $args['effect'], $slider );
//$slices = scm_field( 'slices', $args['slices'], $slider );
/*$cols = scm_field( 'cols', '8', $slider );
$rows = scm_field( 'rows', '4', $slider );*/
$speed = (float)scm_field( 'speed', $args['speed'], $slider ) * 1000;
$time = (float)scm_field( 'pause', $args['pause'], $slider ) * 1000;
$start = scm_field( 'start', $args['start'], $slider );
$random = 'false';
if( $start == -1 ){
	$start = '0';
	$random = 'true';
}
$hover = scm_field( 'hover', $args['hover'], $slider );
$manual = scm_field( 'manual', $args['manual'], $slider );
$direction = scm_field( 'direction', $args['direction'], $slider );
$control = scm_field( 'control', $args['control'], $slider );
//$thumbs = scm_field( 'thumbs', $args['thumbs'], $slider );
$next = scm_field( 'next', $args['next'], $slider );
$prev = scm_field( 'prev', $args['prev'], $slider );

$indent = $SCM_indent + 1;

$attributes .=  ' ' . lbreak() .
                indent( $indent + 3 ) . 'data-slider="' . $type . '" ' . lbreak() .
                indent( $indent + 3 ) . 'data-slider-theme="' . $theme . '" ' . lbreak() .
                indent( $indent + 3 ) . 'data-slider-effect="' . $effect . '" ' . lbreak() .
                //indent( $indent + 3 ) . 'data-slider-slices="' . $slices . '" ' . lbreak() .
                /*indent( $indent + 3 ) . 'data-slider-cols="' . $cols . '" ' . lbreak() .
                indent( $indent + 3 ) . 'data-slider-rows="' . $rows . '" ' . lbreak() .*/
                indent( $indent + 3 ) . 'data-slider-speed="' . $speed . '" ' . lbreak() .
                indent( $indent + 3 ) . 'data-slider-time="' . $time . '" ' . lbreak() .
                indent( $indent + 3 ) . 'data-slider-start="' . $start . '" ' . lbreak() .
                indent( $indent + 3 ) . 'data-slider-random="' . $random . '" ' . lbreak() .
                indent( $indent + 3 ) . 'data-slider-hover="' . $hover . '" ' . lbreak() .
                indent( $indent + 3 ) . 'data-slider-manual="' . $manual . '" ' . lbreak() .
                indent( $indent + 3 ) . 'data-slider-direction="' . $direction . '" ' . lbreak() .
                indent( $indent + 3 ) . 'data-slider-control="' . $control . '" ' . lbreak() .
                //indent( $indent + 3 ) . 'data-slider-thumbs="' . $thumbs . '" ' . lbreak() .
                indent( $indent + 3 ) . 'data-slider-prev="' . $prev . '" ' . lbreak() .
                indent( $indent + 3 ) . 'data-slider-next="' . $next . '" ' . lbreak() .
                indent( $indent + 3 ) . 'data-max-height="' . $height . '" ' . lbreak() .
                indent( $indent + 3 ) . 'data-equal="img" ' . lbreak() .
                indent( $indent + 3 ) . 'data-equal-max="height"' . lbreak() . indent( $indent + 2 );

indent( $indent + 2, openTag( 'div', $id, $class, $style, $attributes ), 2 );

    $captions = '';
    $images = '';
	
	$i = 0;

    foreach ($slides as $elem) {
        $elem = ( is_numeric( $elem ) ? $elem : $elem->ID );
        $slide = array(
            'slide-image' => '',
            'slide-link' => 'page',
            'slide-internal' => '',
            'slide-external' => '',
            'selectors-id' => '',
            'selectors-class' => '',
            'slide-caption-top' => '',
            'slide-caption-right' => '',
            'slide-caption-bottom' => '',
            'slide-caption-left' => '',
            'slide-caption-title' => '',
            'slide-caption-cont' => '',
        );

        $slide = array_merge( $slide, get_fields($elem) );
        $i++;
        $img = ( $slide[ 'slide-image' ] ?: SCM_URI_IMG . 'empty.png' );

        $link = ( $slide[ 'slide-link' ] == 'page' ? $slide[ 'slide-internal' ] : ( $slide[ 'slide-link' ] == 'link' ? $slide[ 'slide-external' ] : '' ) );
        $caption = '';
        $slide_id = $slide[ 'selectors-id' ];
        $slide_class = 'caption box center ' . $slide[ 'selectors-class' ];
        $title = '';

        $top = is( $slide[ 'slide-caption-top' ], '', '', '%' );
        $right = is( $slide[ 'slide-caption-right' ], '', '', '%' );
        $bottom = is( $slide[ 'slide-caption-bottom' ], '', '', '%' );
        $left = is( $slide[ 'slide-caption-left' ], '', '', '%' );
        $slide_style = ' top:' . is( $top, 'initial' ) . '; right:' . is( $right, 'initial' ) . '; bottom:' . is( $bottom, 'initial' ) . '; left:' . is( $left, 'initial' ) . ';';

        $caption_id = uniqid();
        $caption_class = 'slide-' . $post_id . ' nivo-html-caption count-' . $i;

        	$caption = indent( $indent + 2 ) . openTag( 'div', $caption_id, $caption_class ) . lbreak();
            
            if( ex_attr( $slide, 'slide-caption', '' ) ){

                $caption .= indent( $indent + 3 ) . openTag( 'div', $slide_id, $slide_class, $slide_style, '' ) . lbreak();
                    
                    $caption .= ( $slide['slide-caption-title'] ? indent( $indent + 4 ) . '<h3>' . $slide[ 'slide-caption-title' ] . '</h3>' . lbreak() : '' );
                    $caption .= indent( $indent + 4 ) . $slide['slide-caption-cont'];                
                
                $caption .= indent( $indent + 3 ) . '</div>' . lbreak();
            
            }

            $caption .= indent( $indent + 2 ) . '</div>' . lbreak();

        $title = ( sizeof( $slides ) > 1 ? ' title="#' . $caption_id . '"' : '' );
        
        $images .= indent( $indent + 3 );
        $images .= ( $link ? '<a href="' . $link . '">' : '' );
            $images .= ( $img ? '<img class="slide-image" src="' . $img . '" alt="" ' . $title . '>' : '' );
        $images .= ( $link ? '</a>' : '' );
        $images .= lbreak();

        $captions .= $caption;

    }

    echo $images;

    echo lbreak() . indent( $indent + 2 ) . '</div>' . lbreak( 2 );   

    echo $captions . lbreak();


?>