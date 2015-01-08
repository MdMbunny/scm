<?php

/*
$SCM_options_x = array(
'fields'			=> array(							// Verranno sostituiti da Dynamic Fileds creation
		'file'		=>	array('file','attachment'),
		'link'		=>	array('url','link','link_interno', 'link_esterno','video','link_pagina','link_attivita','link_media'),
		'image'		=>	array('image','logo','immagine'),
		'excerpt'	=>	array('excerpt','presentazione','riassunto'),
		'content'	=>	array('content','contenuto','cont','corpo')
	),

'media' => array(										// Sposta in Dynamic Types creation > diventano Settings per i Media > scm-media-settings
	'formats' => array(
			'video' => array(	'name' => 'video'	, 'target' => '_self'	, 'icon' => 'file-video-o'	, 'title' => 'Video'	, 'ext' => 'vid'	, 'popup' => 1	, 'islink' => 0	, 'isfile' => 0	, 'perma' => 0 ),
			'gallerie' => array(	'name' => 'gallery', 'target' => '_self'	, 'icon' => 'file-image-o'	, 'title' => 'Galleria'	, 'ext' => 'img'	, 'popup' => 1	, 'islink' => 0	, 'isfile' => 0	, 'perma' => 0 ),
			'file' => array(	'name' => 'file'	, 'target' => '_blank'	, 'icon' => 'file-o'		, 'title' => 'Download'	, 'ext' => 'dwl'	, 'popup' => 0	, 'islink' => 0	, 'isfile' => 1	, 'perma' => 0 ),
			'internal' => array(	'name' => 'int'		, 'target' => '_self'	, 'icon' => 'link'			, 'title' => 'Link'		, 'ext' => 'int'	, 'popup' => 0	, 'islink' => 1	, 'isfile' => 0	, 'perma' => 1 ),
			'external' => array(	'name' => 'ext'		, 'target' => '_blank'	, 'icon' => 'external-link'	, 'title' => 'Link'		, 'ext' => 'ext'	, 'popup' => 0	, 'islink' => 1	, 'isfile' => 0	, 'perma' => 0 ),
			'article' => array(	'name' => 'article'	, 'target' => '_self'	, 'icon' => 'pencil'		, 'title' => 'Read'		, 'ext' => 'nws'	, 'popup' => 0	, 'islink' => 1	, 'isfile' => 0	, 'perma' => 1 ),
		),
	),
);*/



// *****************************************************
// *      OPTIONS PAGES
// *****************************************************

if( function_exists('acf_add_options_page') ) {

	acf_add_options_page(array(
		'page_title' 	=> 'SCM Types',
		'menu_title'	=> 'Types',
		'menu_slug' 	=> 'scm-types-settings',
		'position'		=> '0.2',
		'capability'	=> 'administrator',
		'redirect'		=> false
	));
	
	acf_add_options_page(array(
		'page_title' 	=> 'SCM Settings',
		'menu_title'	=> 'SCM',
		'menu_slug' 	=> 'scm-main-settings',
		'position'		=> '0.1',
		'capability'	=> 'administrator',
		'redirect'		=> false
	));

	acf_add_options_sub_page(array(
		'page_title' 	=> 'SCM Site Settings',
		'menu_title'	=> 'Layout',
		'parent_slug'	=> 'scm-main-settings',
	));

	acf_add_options_sub_page(array(
		'page_title' 	=> 'SCM Site Settings',
		'menu_title'	=> 'Stili',
		'parent_slug'	=> 'scm-main-settings',
	));

	acf_add_options_sub_page(array(
		'page_title' 	=> 'SCM Header Settings',
		'menu_title'	=> 'Header',
		'parent_slug'	=> 'scm-main-settings',
	));

	acf_add_options_sub_page(array(
		'page_title' 	=> 'SCM Footer Settings',
		'menu_title'	=> 'Footer',
		'parent_slug'	=> 'scm-main-settings',
	));

}


// *****************************************************
// *      ACTIONS AND FILTERS
// *****************************************************

	add_action( 'after_setup_theme', 'scm_install' );
	add_action( 'init', 'scm_types_install' );

// *****************************************************
// *      THEME INSTALLATION
// *****************************************************

	
	//Theme installation
	if ( ! function_exists( 'scm_install' ) ) {
		function scm_install() {

			$themeStatus = get_option( 'scm-settings-installed' );

			if ( ! $themeStatus ) {

				update_option( 'scm-settings-installed', 1 );
				header( "Location: themes.php?page=scm-main-settings" );		// Redirect alla pagina del Theme
				die;
			}
		}
	}

// *****************************************************
// *      CUSTOM TYPES
// *****************************************************

    if ( ! function_exists( 'scm_types_install' ) ) {
        function scm_types_install(){
            global $SCM_types, $SCM_types_slug, $SCM_default_types;

            $SCM_types = [];
            $SCM_types_slug = [];
			
			$saved_types = ( get_field('types_list', 'option') ? get_field('types_list', 'option') : array() );
            
            $types = array_merge( $SCM_default_types, $saved_types);
           
            foreach ( $types as $type ) {

                $active = $type['active'];
                $slug = $type['slug'];
                if(!$slug)
                    $slug = 'scm-' . sanitize_title($type['plural']);
                $type['icon'] = '\\' . $type['icon'];

                if( $active ){
                    $SCM_types_slug[$slug] = $type['plural'];
                    $SCM_types[$slug] = new Custom_Type( $type );
                }
            }
        }
    }

?>