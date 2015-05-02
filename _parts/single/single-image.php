<?php
/**
 * @package SCM
 */

global $post, $SCM_indent;
$post_id = $post->ID;

$args = array(
	'acf_fc_layout' => 'layout-immagine',
	'image' => '',
	'format' => 'norm',
	'full-number' => '',
	'full-units' => '',
	'size-number' => '',
	'size-units' => '',
	'width-number' => '',
	'width-units' => '',
	'height-number' => '',
	'height-units' => '',
	'id' => '',
    'class' => '',
    'attributes' => '',
    'style' => '',
    'negative' => 'off',
);

if( isset( $this ) )
	$args = ( isset( $this->cont ) ? array_merge( $args, toArray( $this->cont ) ) : array() );

/***************/

$layout = $args['acf_fc_layout'];
$image = $args[ 'image' ];
$negative = $args['negative'] === 'on';

if( !$image ){
    if( $post->post_type === 'soggetti' ){
    	switch ( $layout ) {
    		case 'layout-logo':
				if( $negative )
			        $image = scm_field( 'soggetto-logo-neg', '', $post_id );
			    else
			    	$image = scm_field( 'soggetto-logo', '', $post_id );
    		break;
    		
    		case 'layout-logo-icona':
    			if( $negative )
			        $image = scm_field( 'soggetto-icona-neg', '', $post_id );
			    else
			    	$image = scm_field( 'soggetto-icona', '', $post_id );
    		break;
    	}
    	
        
        if( !$image )
    		return;
    }else{
    	return;
    }
}

/***************/


$class = 'image scm-image scm-object object ' . $args['class'];

$attributes = $args['attributes'];
$style = $args['style'];
$id = $args['id'];


/***************/


switch ( $args[ 'format' ] ) {
    case 'full':
        $image_height = scm_content_preset_size( $args[ 'full-number' ], $args[ 'full-units' ], 'initial' );
        $style .= ' max-height:' . $image_height . ';';
        $class .= ' mask full';
    break;

    case 'quad':
        $image_size = scm_content_preset_size( $args[ 'size-number' ], $args[ 'size-units' ] );
        $style .= ' width:' . $image_size . '; height:' . $image_size . ';';
    break;
    
    default:
        $image_width = scm_content_preset_size( $args[ 'width-number' ], $args[ 'width-units' ], 'auto' );
        $image_height = scm_content_preset_size( $args[ 'height-number' ], $args[ 'height-units' ], 'auto' );

        $style .= ' width:' . $image_width . '; height:' . $image_height . ';';
    break;
}



indent( $SCM_indent + 1, openTag( 'div', $id, $class, $style, $attributes ), 1 );

    indent( $SCM_indent + 2, '<img src="' . $image . '" style="max-width:100%;max-height:100%;" alt="">', 1 );

indent( $SCM_indent + 1, '</div><!-- image -->', 2 );



?>