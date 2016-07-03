<?php

//phpinfo();

/**
 * @package SCM
 */

// *****************************************************
// *	FUNCTIONS
// *****************************************************

/*
*****************************************************
*
* 	0.0 Constants
* 	1.0 Requires
*
*****************************************************
*/

/*
*****************************************************
*      0.0 CONSTANTS
*****************************************************
*/

//Debug constants

	define( 'SCM_DEBUG', 0 );

//Append constants

	define( 'SCM_TEMPLATE_APP',			'_t' );
	
//Website constants
	define( 'SCM_SITENAME',     	 	get_bloginfo() );
	define( 'SCM_SHORTNAME',     	 	sanitize_title( SCM_SITENAME ) );
	define( 'SCM_PROTOCOL',				( is_ssl() ? 'https://' : 'http://' ) );
	define( 'SCM_SITE',				    site_url() );
	
	// -- PHP old
	$SCM_parse = parse_url( SCM_SITE );
	define( 'SCM_DOMAIN',			    $SCM_parse["host"] );
	// -- PHP new
	//define( 'SCM_DOMAIN',			    parse_url( SCM_SITE )["host"] );

	define( 'SCM_URL',			      	SCM_PROTOCOL . SCM_DOMAIN . '/' );
	define( 'SCM_SCREEN',			    $_SERVER['REQUEST_URI'] );
	define( 'SCM_CURRENT',			    SCM_SITE . SCM_SCREEN );
	define( 'SCM_DASHBOARD',			( ( SCM_CURRENT == admin_url() || SCM_CURRENT == admin_url() . 'index.php' ) ? 1 : 0 ) );

//Theme constants
	define( 'SCM_VERSION',   			wp_get_theme( sanitize_title( get_template() ) )->Version );
	define( 'SCM_THEME',	 			str_replace( '-v' . SCM_VERSION, '', sanitize_title( get_template() ) ) );
	define( 'SCM_CHILD', 				SCM_THEME . '-' . 'child' );
	define( 'SCM_NAME',     	 		wp_get_theme( sanitize_title( get_template() ) )->Name );
	
//Directories constants

	// UPLOADS FOLDER

	// -- PHP old
	$SCM_upload = wp_upload_dir();	
	define( 'SCM_URI_UPLOADS', 			$SCM_upload['baseurl'] );
	// -- PHP new
	//define( 'SCM_URI_UPLOADS', 			wp_upload_dir()['baseurl'] );
	
	// MAIN THEME
	define( 'SCM_DIR',			      	get_template_directory() . '/' );
	define( 'SCM_URI',			      	get_template_directory_uri() . '/' );

		// CLASSES
		define( 'SCM_DIR_CLASSES',      		SCM_DIR . '_classes/' );
		define( 'SCM_URI_CLASSES',      		SCM_URI . '_classes/' );

		// CSS
		define( 'SCM_DIR_CSS',      			SCM_DIR . '_css/' );
		define( 'SCM_URI_CSS',      			SCM_URI . '_css/' );

		// IMAGES
		define( 'SCM_DIR_IMAGES',      			SCM_DIR . '_img/' );
		define( 'SCM_URI_IMAGES',      			SCM_URI . '_img/' );

		// LANGUAGES
		define( 'SCM_DIR_LANG',      			SCM_DIR . '_languages/' );
		define( 'SCM_URI_LANG',      			SCM_URI . '_languages/' );

		// LIBRARY 
		define( 'SCM_DIR_LIBRARY',      		SCM_DIR . '_library/' );
		define( 'SCM_URI_LIBRARY',      		SCM_URI . '_library/' );

		// PARTS
		define( 'SCM_DIR_PARTS',			    '_parts/content' );
		define( 'SCM_DIR_PARTS_SINGLE',		    '_parts/single/single' );
		define( 'SCM_DIR_PARTS_ARCHIVE',	    '_parts/archive/archive' );
		define( 'SCM_DIR_PARTS_FEED',		    '_parts/feed/feed' );

		// SVG
		define( 'SCM_DIR_SVG',      			SCM_DIR . '_svg/' );
		define( 'SCM_URI_SVG',      			SCM_URI . '_svg/' );
	
	
	// CHILD THEME
	define( 'SCM_DIR_CHILD', 			get_stylesheet_directory() . '/');
	define( 'SCM_URI_CHILD', 			get_stylesheet_directory_uri() . '/');

		// ASSETS
		define( 'SCM_URI_ASSETS_CHILD',      	SCM_URI_CHILD . '_assets/' );

		// LANGUAGES
		define( 'SCM_DIR_LANG_CHILD',      		SCM_DIR_CHILD . 'languages/' );
		define( 'SCM_URI_LANG_CHILD',      		SCM_URI_CHILD . 'languages/' );		

//Roles constants
	define( 'SCM_ROLE_ADMIN',     	 	'update_core' );
	define( 'SCM_ROLE_OPTIONS',     	'manage_options' );
	define( 'SCM_ROLE_PRIVATE',   	 	'edit_private_pages' );
	define( 'SCM_ROLE_TAX',     	 	'manage_categories' );
	define( 'SCM_ROLE_EDIT',     	 	'upload_files' );
	define( 'SCM_ROLE_USERS',     	 	'list_users' );
	define( 'SCM_ROLE_ENTER',     	 	'read' );
	define( 'SCM_ROLE_READ',     	 	'read_private_pages' );

/*
*****************************************************
*      1.0 REQUIRES
*****************************************************
*/

require_once( SCM_DIR_CLASSES . 'Typekit_Client.php' );
require_once( SCM_DIR_CLASSES . 'Get_Template_Part.php' );
require_once( SCM_DIR_CLASSES . 'Custom_Type.php' );
require_once( SCM_DIR_CLASSES . 'Custom_Taxonomy.php' );

require_once( SCM_DIR_LIBRARY . 'scm-svg.php' );
require_once( SCM_DIR_LIBRARY . 'scm-functions-wp.php' );

require_once( SCM_DIR_LIBRARY . 'scm-acf-preset.php' );
require_once( SCM_DIR_LIBRARY . 'scm-acf.php' );

require_once( SCM_DIR_LIBRARY . 'scm-install.php' );
require_once( SCM_DIR_LIBRARY . 'scm-options.php' );
require_once( SCM_DIR_LIBRARY . 'scm-core.php' );
require_once( SCM_DIR_LIBRARY . 'scm-admin.php' );

require_once( SCM_DIR_LIBRARY . 'scm-content.php' );
require_once( SCM_DIR_LIBRARY . 'scm-front.php' );
//require_once( SCM_DIR_LIBRARY . 'scm-feed.php' ); -- da esaminare e capire


