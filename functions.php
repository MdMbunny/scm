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
	define( 'SCM_DOMAIN',			    parse_url( SCM_SITE )["host"] );
	define( 'SCM_URL',			      	SCM_PROTOCOL . SCM_DOMAIN . '/' );
	define( 'SCM_SCREEN',			    $_SERVER['REQUEST_URI'] );
	define( 'SCM_CURRENT',			    SCM_SITE . SCM_SCREEN );
	define( 'SCM_DASHBOARD',			( (string)SCM_CURRENT == (string)admin_url() ? 1 : 0 ) );

//Theme constants
	define( 'SCM_VERSION',   			wp_get_theme( sanitize_title( get_template() ) )->Version );
	define( 'SCM_THEME',	 			str_replace( '-v' . SCM_VERSION, '', sanitize_title( get_template() ) ) );
	define( 'SCM_CHILD', 				SCM_THEME . '-' . 'child' );
	define( 'SCM_NAME',     	 		wp_get_theme( sanitize_title( get_template() ) )->Name );
	
//Directories constants

	// UPLOADS FOLDER
	define( 'SCM_URI_UPLOADS', 			wp_upload_dir()['baseurl'] );
	
	// MAIN THEME
	define( 'SCM_DIR',			      	get_template_directory() . '/' );
	define( 'SCM_URI',			      	get_template_directory_uri() . '/' );

		// ASSETS
		define( 'SCM_DIR_ASSETS',      			SCM_DIR . '_assets/' );
		define( 'SCM_URI_ASSETS',      			SCM_URI . '_assets/' );

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
	
	
	// CHILD THEME
	define( 'SCM_DIR_CHILD', 			get_stylesheet_directory() . '/');
	define( 'SCM_URI_CHILD', 			get_stylesheet_directory_uri() . '/');

		// ASSETS
		define( 'SCM_URI_ASSETS_CHILD',      	SCM_URI_CHILD . '_assets/' );

		// LANGUAGES
		define( 'SCM_DIR_LANG_CHILD',      		SCM_DIR_CHILD . 'languages/' );
		define( 'SCM_URI_LANG_CHILD',      		SCM_URI_CHILD . 'languages/' );		


/*
*****************************************************
*      1.0 REQUIRES
*****************************************************
*/

require_once( SCM_DIR_ASSETS . 'php/Typekit_Client.php' );
require_once( SCM_DIR_ASSETS . 'php/Get_Template_Part.php' );
require_once( SCM_DIR_ASSETS . 'php/Custom_Type.php' );
require_once( SCM_DIR_ASSETS . 'php/Custom_Taxonomy.php' );

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


