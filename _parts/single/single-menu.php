<?php

/**
 * single-menu.php
 *
 * Part Single Menu content.
 *
 * @link http://www.studiocreativo-m.it
 *
 * @package SCM
 * @subpackage Parts/Single/Menu
 * @since 1.0.0
 */

global $post, $SCM_indent;
$post_id = $post->ID;

$args = array(
	'id' => '',
    'class' => '',
    'attributes' => '',
    'style' => '',

    'row_class'        => 'full',
    'toggle_active'    => '',
    'home_active'      => 0,
    'image_active'     => 'no',
    'menu'             => 'primary',
    'menu_id'          => '',
    'sticky'           => '',
    'side'             => false,
    'side_numbers'     => false,
    'side_names'       => false,
    'type'             => 'self',
    'offset'           => 0,
    'attach'           => 'nav-top',
    'anim'             => 'top',
    'numbers'          => false,
    
);

if( isset( $this ) )
	$args = ( isset( $this->cont ) ? array_merge( $args, toArray( $this->cont ) ) : array() );

$args['class'] = 'navigation navigation-' . $args['menu'] . ' scm-object object ' . $args['class'];
$args['id'] = $args['id'] ?: 'navigation-' . $args['menu'] . '-' . $post_id;
/*$auto = true;*/

scm_get_menu( $args );

/*switch( $args['location'] ){
    case 'auto':
        $content = scm_auto_menu();
    break;
    case 'mono':
        $content = scm_mono_menu();
    break;
    case 'mini':
        $content = scm_mini_menu();
    default:
        $content = '%3$s';
        $auto = false;
    break;
}

$wrap = indent( $SCM_indent + 1 ) . '<ul class="toggle-content menu ' . $args['location'] . '">' . lbreak(2) . $content . lbreak() . indent( $SCM_indent + 1 ) . '</ul>' . lbreak(2);

if( $auto )
    echo $wrap;
else
    wp_nav_menu( array(
        'container' => false,
        'theme_location' => $args['location'],
        'menu' => $args['menu'],
        'items_wrap' => $wrap,
    ));*/

?>