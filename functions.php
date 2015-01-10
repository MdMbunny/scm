<?php
/**
 * SCM functions and definitions
 *
 * @package SCM
 */

/*if ( !is_plugin_active( 'advanced-custom-fields-pro/acf.php' ) ) {
  echo '<br/><h3>INSTALLA E ATTIVA IL PLUGIN ADVANCED CUSTOM FIELD PRO PER UTILIZZARE QUESTO TEMA</h3><br/>';
  return;
}*/

/*
if( !function_exists( get_field ) )
	return;*/


if ( ! isset( $content_width ) ) {
	$content_width = 940;
}


/*
*****************************************************
*      GLOBAL
*****************************************************
*/


//Getting website data

/*	$SCM_parse			 = parse_url(site_url());
	$SCM_domain 		 = $SCM_parse["host"];
	$SCM_url			 = 'http://' . $SCM_domain . '/';*/

//Getting theme data
	$SCM_shortname 		 = sanitize_title(get_template());
	$SCM_data    		 = wp_get_theme( $SCM_shortname );
	$SCM_name    		 = $SCM_data->Name;
	$SCM_version 		 = $SCM_data->Version;
	$SCM_directory		 = get_template_directory();
	$SCM_uri 			 = get_template_directory_uri();
	$SCM_page_templates	 = wp_get_theme()->get_page_templates();

	$SCM_shortname = str_replace( '-v' . $SCM_version, '', $SCM_shortname );

	if( ! $SCM_version ) {
		$SCM_version = '';
	}

	$SCM_styles = array();
	$SCM_types = array();
	$SCM_types_slug = array();
	$SCM_galleries = array();

/*
*****************************************************
*      CONSTANTS
*****************************************************
*/

//Basic constants
	define( 'SCM_NAME',     	 		$SCM_name );
	define( 'SCM_THEME',	 			$SCM_shortname );
	define( 'SCM_PREFIX', 				SCM_THEME . '-' );
	define( 'SCM_CHILD', 				SCM_PREFIX . 'child' );
	define( 'SCM_VERSION',   			$SCM_version );
	define( 'SCM_SCRIPTS_VERSION',      trim( SCM_VERSION ) );

//Directories
	
	// PARENT THEME
	define( 'SCM_DIR',			      	$SCM_directory . '/');
	define( 'SCM_URI',			      	$SCM_uri . '/');
	
		// LANGUAGES PARENT
		define( 'SCM_DIR_LANG',      		SCM_DIR . 'languages/' );
		define( 'SCM_URI_LANG',      		SCM_URI . 'languages/' );
	
	// CHILD THEME
	define( 'SCM_DIR_CHILD', 			get_stylesheet_directory() . '/');
	define( 'SCM_URI_CHILD', 			get_stylesheet_directory_uri() . '/');

		// LANGUAGES CHILD
		define( 'SCM_DIR_LANG_CHILD',      	SCM_DIR_CHILD . 'languages/' );
		define( 'SCM_URI_LANG_CHILD',      	SCM_URI_CHILD . 'languages/' );

		// ASSETS
		define( 'SCM_DIR_ASSETS',      			SCM_DIR . 'assets/' );
		define( 'SCM_URI_ASSETS',      			SCM_URI . 'assets/' );
			define( 'SCM_URI_CSS',      			SCM_URI_ASSETS . 'css/' );
			define( 'SCM_URI_JS',      				SCM_URI_ASSETS . 'js/' );
			define( 'SCM_URI_IMG',      			SCM_URI_ASSETS . 'img/' );
			define( 'SCM_URI_FONT',      			SCM_URI_ASSETS . 'font/' );

		// LIBRARY 
		define( 'SCM_DIR_LIBRARY',      		SCM_DIR . 'library/' );
			define( 'SCM_DIR_CLASSES',      		SCM_DIR_LIBRARY . 'classes/' );
			define( 'SCM_DIR_SLIDERS',      		SCM_DIR_LIBRARY . 'sliders/' );

		// PARTS
		define( 'SCM_DIR_PARTS',			    	'parts/content' );
			define( 'SCM_DIR_PARTS_SINGLE',		    'parts/single/single' );
			define( 'SCM_DIR_PARTS_ARCHIVE',	    'parts/archive/archive' );

// ACF

		// ACF PLUGIN
		define( 'SCM_DIR_ACF',      		SCM_DIR . '_acf/' );
		define( 'SCM_URI_ACF',      		SCM_URI . '_acf/' );
			define( 'SCM_DIR_ACF_PLUGIN',      	SCM_DIR_ACF . 'acf-plugin/' );
			define( 'SCM_URI_ACF_PLUGIN',      	SCM_URI_ACF . 'acf-plugin/' );
			define( 'SCM_DIR_ACF_JSON',      		SCM_DIR . '_acf/acf-json' );
			define( 'SCM_URI_ACF_JSON',      		SCM_URI . '_acf/acf-json' );

		// ACF - fields keys ( modify them when field group LUOGO fields are deleted and recreated )
		define( 'SCM_ACF_LUOGO_COUNTRY', 	'field_548f253744f97' );
		define( 'SCM_ACF_LUOGO_REGION', 	'field_548f25f644f98' );
		define( 'SCM_ACF_LUOGO_PROVINCE', 	'field_548f265644f99' );
		define( 'SCM_ACF_LUOGO_CODE', 		'field_548ee4b8fd2bc' );
		define( 'SCM_ACF_LUOGO_CITY', 		'field_548ee4cbfd2bd' );
		define( 'SCM_ACF_LUOGO_TOWN', 		'field_548ee501fd2bf' );
		define( 'SCM_ACF_LUOGO_ADDRESS', 	'field_548ee49dfd2bb' );
		define( 'SCM_ACF_LUOGO_LATITUDE', 	'field_548fe73047972' );
		define( 'SCM_ACF_LUOGO_LONGITUDE', 	'field_54945fd9fdd3e' );



// *****************************************************
// *  Default Types
// *****************************************************

	$SCM_default_types = array(
		'sections'				=> array( 'active' => 1,		 'singular' => __('Section', SCM_THEME), 				'plural' => __('Sections', SCM_THEME), 				'slug' => 'scm-sections', 				'categories' => true, 	'tags' => false, 	'icon' => 'f116', 	'post' => true, 	'pagination' => -1, 	'archive' => -1, 	'folder' => false 	),
		'modules'				=> array( 'active' => 1,		 'singular' => __('Module', SCM_THEME), 				'plural' => __('Modules', SCM_THEME), 				'slug' => 'scm-modules', 				'categories' => true, 	'tags' => true, 	'icon' => 'f119', 	'post' => true, 	'pagination' => -1, 	'archive' => -1, 	'folder' => false 	),
		'soggetti'				=> array( 'active' => 1,		 'singular' => __('Soggetto', SCM_THEME), 				'plural' => __('Soggetti', SCM_THEME), 				'slug' => 'scm-soggetti', 				'categories' => true, 	'tags' => false, 	'icon' => 'f338', 	'post' => true, 	'pagination' => -1, 	'archive' => -1, 	'folder' => false 	),
		'luoghi'				=> array( 'active' => 1,		 'singular' => __('Luogo', SCM_THEME), 					'plural' => __('Luoghi', SCM_THEME), 				'slug' => 'scm-luoghi', 				'categories' => true, 	'tags' => false, 	'icon' => 'f230', 	'post' => true, 	'pagination' => -1, 	'archive' => -1, 	'folder' => false 	),
		'news'					=> array( 'active' => 0,		 'singular' => __('News', SCM_THEME), 					'plural' => __('News', SCM_THEME), 					'slug' => 'scm-news', 					'categories' => true, 	'tags' => false, 	'icon' => 'f488', 	'post' => true, 	'pagination' => -1, 	'archive' => -1, 	'folder' => true 	),
		'documenti'				=> array( 'active' => 0,		 'singular' => __('Documento', SCM_THEME), 				'plural' => __('Documenti', SCM_THEME), 			'slug' => 'scm-documenti', 				'categories' => true, 	'tags' => false, 	'icon' => 'f109', 	'post' => true, 	'pagination' => -1, 	'archive' => -1, 	'folder' => false 	),
		'gallerie'				=> array( 'active' => 1,		 'singular' => __('Galleria', SCM_THEME), 				'plural' => __('Gallerie', SCM_THEME), 				'slug' => 'scm-gallerie', 				'categories' => true, 	'tags' => false, 	'icon' => 'f161', 	'post' => true, 	'pagination' => -1, 	'archive' => -1, 	'folder' => true 	),
		'video'					=> array( 'active' => 0,		 'singular' => __('Video', SCM_THEME), 					'plural' => __('Video', SCM_THEME), 				'slug' => 'scm-video', 					'categories' => false, 	'tags' => false, 	'icon' => 'f236', 	'post' => true, 	'pagination' => -1, 	'archive' => -1, 	'folder' => false 	),
		'rassegne-stampa'		=> array( 'active' => 0,		 'singular' => __('Rassegna Stampa', SCM_THEME),		'plural' => __('Rassegne Stampa', SCM_THEME), 		'slug' => 'scm-rassegne-stampa', 		'categories' => false,	'tags' => false, 	'icon' => 'f336', 	'post' => true, 	'pagination' => -1, 	'archive' => -1, 	'folder' => false 	),
	);



    
require SCM_DIR_CLASSES . 'Get_Template_Part.php';
require SCM_DIR_CLASSES . 'Custom_Type.php';
require SCM_DIR_CLASSES . 'Custom_Taxonomy.php';

require SCM_DIR_LIBRARY . 'scm-acf.php';
include_once( SCM_DIR_ACF_PLUGIN . 'acf.php' );

require SCM_DIR_LIBRARY . 'scm-functions.php';
require SCM_DIR_LIBRARY . 'scm-core.php';
require SCM_DIR_LIBRARY . 'scm-front.php';
require SCM_DIR_LIBRARY . 'scm-style.php';
require SCM_DIR_LIBRARY . 'scm-admin.php';
require SCM_DIR_LIBRARY . 'scm-options.php';

require SCM_DIR_LIBRARY . 'scm-jquery.php';

require SCM_DIR_LIBRARY . 'scm-shortcodes.php';

require SCM_DIR_LIBRARY . 'private.php';			// XXXXX

