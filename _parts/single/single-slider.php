<?php
/**
 * @package SCM
 */

global $post, $SCM_indent;
$post_id = $post->ID;

$args = array(
    'acf_fc_layout' => 'layout-slider',
    'slider' => 0,
    'type' => 'nivo',
    /*'alignment' => 'top',
    'height-number' => 300,
    'height-units' => 'px',
    'theme' => 'scm',
    'effect' => 'sliceDown',
    'slices' => 30,
    'cols' => 8,
    'rows' => 8,
    'speed' => 1,
    'pause' => 'on',
    'start' => 0,
    'manual' => 'off',
    'direction' => 'on',
    'control' => 'off',
    'thumbs' => 'off',
    'prev' => 'fa-angle-left',
    'next' => 'fa-angle-right',*/
    'id' => '',
    'class' => '',
    'attributes' => '',
    'style' => '',
);

if( isset( $this ) )
    $args = ( isset( $this->cont ) ? array_merge( $args, toArray( $this->cont ) ) : array() );

/***************/

$class = 'slider scm-slider full mask ' . $args['class'];

$attributes = $args['attributes'];
$style = $args['style'];
$id = $args['id'];


/***************/

$slider = get_term( $args['slider'], 'sliders' );
// +++ todo:  diventa wp query? che poi chiama single-slide?
$slides = get_posts( array(
    'order' => 'ASC',
    'post_type' => 'slides',
    'numberposts' => -1,
    'taxonomy' => 'sliders',
    'term' => $slider->slug,
) );

$type = $args['type'];

$class .= ' ' . $type . ' ' . scm_field( 'alignment', 'top', $slider );

$height = scm_field( 'height-number', '', $slider );
$height = ( $height ? $height . scm_field( 'height-units', '', $slider ) : 'auto' );
$style .= ' height:' . $height . ';';

$theme = scm_field( 'theme', 'scm', $slider );

$effect = scm_field( 'effect', 'fold', $slider );
$slices = scm_field( 'slices', '15', $slider );
$cols = scm_field( 'cols', '8', $slider );
$rows = scm_field( 'rows', '4', $slider );
$speed = (float)scm_field( 'speed', '.5', $slider ) * 1000;
$time = (float)scm_field( 'pause', '5', $slider ) * 1000;
$start = scm_field( 'start', '0', $slider );
$random = 'false';
if( $start == -1 ){
	$start = '0';
	$random = 'true';
}
$hover = scm_field( 'hover', 'true', $slider );
$manual = scm_field( 'manual', 'false', $slider );
$direction = scm_field( 'direction', 'true', $slider );
$control = scm_field( 'control', 'false', $slider );
$thumbs = scm_field( 'thumbs', 'false', $slider );
$next = scm_field( 'next', 'fa-angle-right', $slider );
$prev = scm_field( 'prev', 'fa-angle-left', $slider );

$indent = $SCM_indent + 1;

$attributes .=  ' ' . lbreak() .
                indent( $indent + 3 ) . 'data-slider="' . $type . '" ' . lbreak() .
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
                indent( $indent + 3 ) . 'data-equal-max="height"' . lbreak() . indent( $indent + 2 );


/***************/


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
        $img = $slide[ 'slide-image' ];
        
        if( !$img )
            continue;

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
            $caption .= indent( $indent + 3 ) . openTag( 'div', $slide_id, $slide_class, $slide_style, '' ) . lbreak();

                //if( $slide[ 'select_disable_caption' ] == 'on' ){
                
                    $caption .= ( $slide['slide-caption-title'] ? indent( $indent + 4 ) . '<h3>' . $slide[ 'slide-caption-title' ] . '</h3>' . lbreak() : '' );
                    $caption .= indent( $indent + 4 ) . $slide['slide-caption-cont'];
                //}
                
            $caption .= indent( $indent + 3 ) . '</div>' . lbreak();

            $caption .= indent( $indent + 2 ) . '</div>' . lbreak();

        $title = ( sizeof( $slides ) > 1 ? ' title="#' . $caption_id . '"' : '' );
        
        $images .= indent( $indent + 3 );
        $images .= ( $link ? '<a href="' . $link . '">' : '' );
            $images .= '<img class="slide-image" src="' . $img . '" alt="" ' . $title . '>';
            //$images .= '<img class="slide-image" src="' . $img . '" data-thumb="' . $img . '" alt="" title="' . $title . '">';
        $images .= ( $link ? '</a>' : '' );
        $images .= lbreak();

        $captions .= $caption;

    }

    echo $images;

    echo lbreak() . indent( $indent + 2 ) . '</div>' . lbreak( 2 );   

    echo $captions . lbreak();


?>