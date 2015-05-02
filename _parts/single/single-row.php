<?php

// Global Variables
global $post, $SCM_indent;
$post_id = $post->ID;

$args = [
    'acf_fc_layout' => 'layout-section',
    'row' => 0,
    'id' => '',
    'class' => '',
    'attributes' => '',
    'style' => '',
    'layout' => 'responsive'

];

if( isset( $this ) )
    $args = ( isset( $this->cont ) ? array_merge( $args, toArray( $this->cont ) ) : [] );

/***************/

$module = $args[ 'row' ];
if( !$module ){

	if( $post->post_type === 'sections' )
		$module = $post_id;
	else
		return;

}else{

	if( !is_numeric( $module ) )
		$module = $module->ID;

	//$post = $module;
	//setup_postdata( get_post( $module ) );
}

/***************/


/*
$fields = get_fields( $module );

printPre( $args );
printPre( is( $fields['id'], 'no field' ) );
printPre( is( $args['id'], 'no arg' ) );*/

/*$columns = scm_field( 'columns', [], $module, 1 );
$args['modules'] = $columns;*/


scm_containers( $args, 'row' );


?>