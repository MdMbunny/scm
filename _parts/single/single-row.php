<?php

/**
 * single-row.php
 *
 * Part Single Row content.
 *
 * @link http://www.studiocreativo-m.it
 *
 * @package SCM
 * @subpackage Parts/Single/Row
 * @since 1.0.0
 */

// Global Variables
global $post, $SCM_indent;
$post_id = $post->ID;

$args = array(
    'acf_fc_layout' => 'layout-section',
    'row' => 0,
    'id' => '',
    'class' => '',
    'attributes' => '',
    'style' => '',
    'layout' => 'responsive'
);

if( isset( $this ) )
    $args = ( isset( $this->cont ) ? array_merge( $args, toArray( $this->cont ) ) : array() );

$module = $args[ 'row' ];
if( !$module ){

	if( $post->post_type === 'sections' )
		$module = $post_id;
	else
		return;

}else{

	if( !is_numeric( $module ) )
		$module = $module->ID;
}

scm_containers( $args, 'row' );


?>