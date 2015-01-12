<?php
/**
 * SCM functions and definitions
 *
 * @package SCM
 */


if ( ! isset( $content_width ) ) {
	$content_width = 1120;
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

//Option Pages

	define( 'SCM_SETTINGS_MAIN',		'scm-main-settings' );
	define( 'SCM_SETTINGS_TYPES',		'scm-types-settings' );

//Directories
	
	// PARENT THEME
	define( 'SCM_DIR',			      	$SCM_directory . '/');
	define( 'SCM_URI',			      	$SCM_uri . '/');
	
		// LANGUAGES PARENT
		define( 'SCM_DIR_LANG',      		SCM_DIR . '_languages/' );
		define( 'SCM_URI_LANG',      		SCM_URI . '_languages/' );
	
	// CHILD THEME
	define( 'SCM_DIR_CHILD', 			get_stylesheet_directory() . '/');
	define( 'SCM_URI_CHILD', 			get_stylesheet_directory_uri() . '/');

		// LANGUAGES CHILD
		define( 'SCM_DIR_LANG_CHILD',      	SCM_DIR_CHILD . 'languages/' );
		define( 'SCM_URI_LANG_CHILD',      	SCM_URI_CHILD . 'languages/' );

		// ASSETS
		define( 'SCM_DIR_ASSETS',      			SCM_DIR . '_assets/' );
			define( 'SCM_DIR_IMG',      			SCM_DIR_ASSETS . 'img/' );
		define( 'SCM_URI_ASSETS',      			SCM_URI . '_assets/' );
			define( 'SCM_URI_CSS',      			SCM_URI_ASSETS . 'css/' );
			define( 'SCM_URI_JS',      				SCM_URI_ASSETS . 'js/' );
			define( 'SCM_URI_IMG',      			SCM_URI_ASSETS . 'img/' );
			define( 'SCM_URI_FONT',      			SCM_URI_ASSETS . 'font/' );

		// LIBRARY 
		define( 'SCM_DIR_LIBRARY',      		SCM_DIR . '_library/' );
			define( 'SCM_DIR_CLASSES',      		SCM_DIR_LIBRARY . 'classes/' );
			define( 'SCM_DIR_SLIDERS',      		SCM_DIR_LIBRARY . 'sliders/' );

		// PARTS
		define( 'SCM_DIR_PARTS',			    	'_parts/content' );
			define( 'SCM_DIR_PARTS_SINGLE',		    	'_parts/single/single' );
			define( 'SCM_DIR_PARTS_ARCHIVE',	    	'_parts/archive/archive' );

		// PLUGINS
		define( 'SCM_DIR_PLUGINS',			    	SCM_DIR . '_plugins/' );

// ACF

		// ACF PLUGIN
		define( 'SCM_DIR_ACF',      		SCM_DIR . '_acf/' );
		define( 'SCM_URI_ACF',      		SCM_URI . '_acf/' );
			define( 'SCM_DIR_ACF_PLUGIN',      	SCM_DIR_ACF . 'acf-plugin/' );
			define( 'SCM_URI_ACF_PLUGIN',      	SCM_URI_ACF . 'acf-plugin/' );
			define( 'SCM_DIR_ACF_JSON',      		SCM_DIR_ACF . 'acf-json/' );
			define( 'SCM_URI_ACF_JSON',      		SCM_URI_ACF . 'acf-json/' );

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



    
require SCM_DIR_CLASSES . 'Get_Template_Part.php';
require SCM_DIR_CLASSES . 'Custom_Type.php';
require SCM_DIR_CLASSES . 'Custom_Taxonomy.php';
require SCM_DIR_CLASSES . 'class-tgm-plugin-activation.php';

require SCM_DIR_LIBRARY . 'scm-functions.php';

require SCM_DIR_LIBRARY . 'scm-install.php';
require SCM_DIR_LIBRARY . 'scm-acf.php';
require SCM_DIR_LIBRARY . 'scm-core.php';
require SCM_DIR_LIBRARY . 'scm-front.php';
require SCM_DIR_LIBRARY . 'scm-admin.php';


require SCM_DIR_LIBRARY . 'scm-jquery.php';

require SCM_DIR_LIBRARY . 'scm-shortcodes.php';

require SCM_DIR_LIBRARY . 'private.php';			// XXXXX

