<?php
/**
 * SCM functions and definitions
 *
 * @package SCM
 */


if ( ! isset( $content_width ) ) {
	$content_width = 940;
}


/*
*****************************************************
*      GLOBAL
*****************************************************
*/


//Getting website data

	/*$SCM_parse			 = parse_url(site_url());
	$SCM_domain 		 = ( $SCM_parse["host"] == 'localhost' ? get_field( 'localhost', 'option' ) : $SCM_parse["host"] );
	$SCM_url			 = 'http://' . $SCM_domain . '/';*/

//Getting theme data
	$SCM_shortname 		 = sanitize_title(get_template());
	$SCM_data    		 = wp_get_theme( $SCM_shortname );
	$SCM_name    		 = $SCM_data->Name;
	$SCM_version 		 = $SCM_data->Version;
	$SCM_directory		 = get_template_directory();
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

// URLs
	/*define( 'SCM_DOMAIN',		      	$SCM_domain );
	define( 'SCM_URL',			      	$SCM_url);*/

//Directories
	define( 'SCM_DIR',			      	$SCM_directory );

	// THEMES - absolute
	define( 'SCM_THEMES',		      	substr( SCM_DIR, 0,strlen(SCM_DIR)-strlen(SCM_THEME) ) );
	// WP-CONTENT - absolute
	define( 'SCM_CONTENT',			    substr( SCM_THEMES, 0,strlen(SCM_THEMES)-1-strlen('themes') ) );
	// WP-CONTENT - relative
	define( 'SCM_REL_CONTENT',			'/wp-content/' );
	// THEMES - relative
	define( 'SCM_REL_THEMES',		    SCM_REL_CONTENT . 'themes/' );

	// ROOT - absolute
	define( 'SCM_ROOT',				    substr( SCM_CONTENT, 0,strlen(SCM_CONTENT)-1-strlen('wp-content') ) );

	// THEME - absolute
	define( 'SCM_DIR_THEME', 			SCM_THEMES . SCM_THEME . '/');
	// THEME - relative
	define( 'SCM_REL_THEME', 			SCM_REL_THEMES . SCM_THEME . '/' );

	// LANGUAGES THEME - absolute
	define( 'SCM_LANG_THEME',      		SCM_DIR_THEME . 'languages/' );
	// LANGUAGES THEME - relative
	define( 'SCM_REL_LANG_THEME',      		SCM_REL_THEME . 'languages/' );
	
	// CHILD - absolute
	define( 'SCM_DIR_CHILD', 			SCM_THEMES . SCM_THEME . '-child/' );
	// CHILD - relative
	define( 'SCM_REL_CHILD', 				SCM_REL_THEMES . SCM_THEME . '-child/' );

	// LANGUAGES CHILD - absolute
	define( 'SCM_LANG_CHILD',      		SCM_DIR_CHILD . 'languages/' );
	// LANGUAGES CHILD - relative
	define( 'SCM_REL_LANG_CHILD',      		SCM_REL_CHILD . 'languages/' );

	// ASSETS - absolute
	define( 'SCM_ASSETS',      			SCM_DIR_THEME . 'assets/' );
		define( 'SCM_CSS',      			SCM_ASSETS . 'css/' );
		define( 'SCM_JS',      				SCM_ASSETS . 'js/' );
		define( 'SCM_IMG',      			SCM_ASSETS . 'img/' );
		define( 'SCM_FONT',      			SCM_ASSETS . 'font/' );
	// ASSETS - relative
	define( 'SCM_REL_ASSETS',      			SCM_REL_THEME . 'assets/' );
		define( 'SCM_REL_CSS',      			SCM_REL_ASSETS . 'css/' );
		define( 'SCM_REL_JS',      				SCM_REL_ASSETS . 'js/' );
		define( 'SCM_REL_IMG',      			SCM_REL_ASSETS . 'img/' );
		define( 'SCM_REL_FONT',      			SCM_REL_ASSETS . 'font/' );

	// LIBRARY - absolute
	define( 'SCM_LIBRARY',      		SCM_DIR_THEME . 'library/' );
		define( 'SCM_CLASSES',      		SCM_LIBRARY . 'classes/' );
		define( 'SCM_SLIDERS',      		SCM_LIBRARY . 'sliders/' );
	// LIBRARY - relative
	define( 'SCM_REL_LIBRARY',      		SCM_REL_THEME . 'library/' );
		define( 'SCM_REL_CLASSES',      		SCM_REL_LIBRARY . 'classes/' );
		define( 'SCM_REL_SLIDERS',      		SCM_REL_LIBRARY . 'sliders/' );

	// PARTS - absolute
	define( 'SCM_PARTS',			    	'parts/content' );
		define( 'SCM_PARTS_SINGLE',		    'parts/single/single' );
		define( 'SCM_PARTS_ARCHIVE',	    'parts/archive/archive' );




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





require SCM_CLASSES . 'Get_Template_Part.php';
require SCM_CLASSES . 'Custom_Type.php';
require SCM_CLASSES . 'Custom_Taxonomy.php';

require SCM_LIBRARY . 'scm-functions.php';
require SCM_LIBRARY . 'scm-core.php';
require SCM_LIBRARY . 'scm-setup.php';
require SCM_LIBRARY . 'scm-admin.php';
require SCM_LIBRARY . 'scm-jquery.php';
require SCM_LIBRARY . 'scm-options.php';
require SCM_LIBRARY . 'scm-acf.php';

require SCM_LIBRARY . 'scm-shortcodes.php';

require SCM_LIBRARY . 'private.php';			// XXXXX



