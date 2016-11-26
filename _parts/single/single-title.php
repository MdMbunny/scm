<?php

/**
 * single-title.php
 *
 * Part Single Title content.
 *
 * @link http://www.studiocreativo-m.it
 *
 * @package SCM
 * @subpackage Parts/Single/Title
 * @since 1.0.0
 */

global $post, $SCM_indent;
$post_id = $post->ID;

$args = array(
    'acf_fc_layout' => 'layout-titolo',
    'title' => '',
    'tag' => 'h1',
    'prepend' => 'no',
    'append' => 'no',
    'id' => '',
    'class' => '',
    'attributes' => '',
    'style' => '',
);

if( isset( $this ) )
    $args = ( isset( $this->cont ) ? array_merge( $args, toArray( $this->cont ) ) : array() );

$class = 'title scm-title scm-object object ' . $args['class'];

$attributes = $args['attributes'];
$style = $args['style'];
$id = $args['id'];

$layout = $args['acf_fc_layout'];

if( $layout == 'layout-quote' ){
    $args['tag'] = 'blockquote';
}

$text = $args[ 'title' ];
$tag = $args[ 'tag' ];

if( strpos( $tag, '.' ) === 0 ){
    $class .= ' ' . str_replace( '.', '', $tag );
    $tag = 'div';
}

if( !$text ){
    if( $post->post_type === 'soggetti' ){

        switch ( $layout ) {
            
            case 'layout-copy':
                $text = 'YEAR';
            break;
            
            case 'layout-cf':
                $text = scm_field( 'soggetto-cf', '', $post_id );
            break;
            
            case 'layout-piva':
                $text = scm_field( 'soggetto-piva', '', $post_id );
            break;
            
            case 'layout-intestazione':
                $text = scm_field( 'soggetto-intestazione', '', $post_id );
            break;

            default:
                $text = get_the_title();
            break;

        }
        
        if( !$text )
            return;
        
    }else{
        switch ( $layout ) {
            
            case 'layout-excerpt':
                $text = scm_field( 'excerpt', '', $post_id );
            break;

            default:
                $text = get_the_title();
            break;

        }
        
    }
}

$prepend = ( $args['prepend'] && $args['prepend'] != 'no' ? ( $layout !== 'layout-quote' ? '<span class="prepend">' . $args['prepend'] . '</span>' : ( $args['prepend'] !== 'fa-no' ? '<i class="prepend fa ' . $args['prepend'] . '"></i>' : '' ) ) : '' );
$append = ( $args['append'] && $args['append'] != 'no' ? ( $layout !== 'layout-quote' ? '<span class="append">' . $args['append'] . '</span>' : ( $args['append'] !== 'fa-no' ? '<i class="append fa ' . $args['append'] . '"></i>' : '' ) ) : '' );

$text = ( startsWith( $text, '<p>' ) ? str_replace( '<p>', '', $text ) : $text );

// VAI A RIVEDERE FUNZIONE endsWith in scm-utils.php
$text = ( strpos( $text, '</p>' ) != false ? str_replace( '</p>', '', $text ) : $text );

$text = $prepend . $text . $append;

$replaceArray = array(
    '(space)' => ' ',

    '(c)'  => '&copy;',
    '(C)'  => '&copy;',

    '(r)'  => '&reg;',
    '(R)'  => '&reg;',

    '(tm)' => '&trade;',
    '(TM)' => '&trade;',

    '(Y)' => date( 'Y' ),
    'YEAR' => date( 'Y' ),

    'TITLE' => get_bloginfo( 'name' ),
);

$text = strtr( $text, $replaceArray );

indent( $SCM_indent, openTag( $tag, $id, $class, $style, $attributes ) . (string)$text . '</' . $tag . '><!-- title -->', 1 );

?>