<?php

/**
 * function.php
 *
 * SCM Main Theme File.
 *
 * @link http://www.studiocreativo-m.it
 *
 * @package SCM
 * @since 1.0.0
 */

// ???
/*if ( get_option( 'scm-hacked' ) ) {
	alert( 'Software under license.' );
	die;
}*/

// ------------------------------------------------------
//
// G.0 Globals
// C.0 Constants
// R.0 Require Classes
// R.1 Require Modules
//
// ------------------------------------------------------

// ------------------------------------------------------
// G.0 GLOBALS
// ------------------------------------------------------

$SCM_indent         = 1;
$SCM_types 			= array();
$SCM_libraries 		= array();
//$SCM_forms 			= array(); // ???
$SCM_archives		= array();
//$SCM_settings 		= array();
//$SCM_options 		= wp_load_alloptions();

// ------------------------------------------------------
// C.0 CONSTANTS
// ------------------------------------------------------
// ------------------------------------------------------
// DEBUG
// ------------------------------------------------------

define( 'SCM_DEBUG', 				0 );

// ------------------------------------------------------
// STRING
// ------------------------------------------------------

define( 'SCM_TEMPLATE_APP',			'_t' );
define( 'SCM_AJAX', 				'wp-admin/admin-ajax.php' );

// ------------------------------------------------------
// WEBSITE
// ------------------------------------------------------

define( 'SCM_SITENAME',     	 	get_bloginfo() );
define( 'SCM_SHORTNAME',     	 	sanitize_title( SCM_SITENAME ) );
define( 'SCM_PROTOCOL',				( is_ssl() ? 'https://' : 'http://' ) );
define( 'SCM_SITE',				    site_url() );

// Site domain.
// @todo PHP: define( 'SCM_DOMAIN', parse_url( SCM_SITE )["host"] );
// @todo PHP: then check if global is used
$parse = parse_url( SCM_SITE );
define( 'SCM_DOMAIN',			    ( $parse["host"] == 'localhost' ? $parse["host"] . ':8888' : $parse["host"] ) );
define( 'SCM_LINK',			      	SCM_PROTOCOL . SCM_DOMAIN );
define( 'SCM_URL',			      	SCM_PROTOCOL . SCM_DOMAIN . '/' );

if( is_admin() ){
	define( 'SCM_CURRENT',			    SCM_LINK . $_SERVER['REQUEST_URI'] );
	define( 'SCM_DASHBOARD',			( ( SCM_CURRENT == admin_url() || SCM_CURRENT == admin_url() . 'index.php' ) ? 1 : 0 ) );
}

// ------------------------------------------------------
// C.4 THEME CONSTANTS
// ------------------------------------------------------

define( 'SCM_VERSION',   			wp_get_theme( sanitize_title( get_template() ) )->Version );
define( 'SCM_THEME',	 			str_replace( '-v' . SCM_VERSION, '', sanitize_title( get_template() ) ) );
define( 'SCM_CHILD', 				SCM_THEME . '-' . 'child' );
define( 'SCM_NAME',     	 		wp_get_theme( sanitize_title( get_template() ) )->Name );

// ------------------------------------------------------
// C.5 PATH CONSTANTS
// ------------------------------------------------------

// UPLOADS FOLDER

// Main uploads path.
// @todo PHP: define( 'SCM_URI_UPLOADS', 			wp_upload_dir()['baseurl'] );
$upload = wp_upload_dir();
define( 'SCM_DIR_UPLOADS', 				$upload['basedir'] );
define( 'SCM_URI_UPLOADS', 				$upload['baseurl'] );

// ------------------------------------------------------

// MAIN THEME FOLDER

define( 'SCM_DIR',			      		get_template_directory() . '/' );
define( 'SCM_URI',			      		get_template_directory_uri() . '/' );
define( 'SCM_DIR_CLASSES',      		SCM_DIR . '_classes/' );
define( 'SCM_URI_CLASSES',      		SCM_URI . '_classes/' );
define( 'SCM_DIR_CSS',      			SCM_DIR . '_css/' );
define( 'SCM_URI_CSS',      			SCM_URI . '_css/' );
define( 'SCM_DIR_IMAGES',      			SCM_DIR . '_img/' );
define( 'SCM_URI_IMAGES',      			SCM_URI . '_img/' );
define( 'SCM_DIR_LANG',      			SCM_DIR . '_languages/' );
define( 'SCM_URI_LANG',      			SCM_URI . '_languages/' );
define( 'SCM_DIR_PLUGINS',     			SCM_DIR . '_plugins/' );
define( 'SCM_URI_PLUGINS',     			SCM_URI . '_plugins/' );
define( 'SCM_DIR_LIBRARY',      		SCM_DIR . '_library/' );
define( 'SCM_URI_LIBRARY',      		SCM_URI . '_library/' );
define( 'SCM_DIR_PARTS',			    '_parts/content' );
define( 'SCM_DIR_PARTS_SINGLE',		    '_parts/single/single' );
define( 'SCM_DIR_PARTS_ARCHIVE',	    '_parts/archive/archive' );
define( 'SCM_DIR_PARTS_TAX',		    '_parts/tax/tax' );
define( 'SCM_DIR_PARTS_FEED',		    '_parts/feed/feed' );
define( 'SCM_DIR_SVG',      			SCM_DIR . '_svg/' );
define( 'SCM_URI_SVG',      			SCM_URI . '_svg/' );

// ------------------------------------------------------

// CHILD THEME FOLDER

define( 'SCM_DIR_CHILD', 				get_stylesheet_directory() . '/');
define( 'SCM_URI_CHILD', 				get_stylesheet_directory_uri() . '/');
define( 'SCM_URI_ASSETS_CHILD',      	SCM_URI_CHILD . '_assets/' );
define( 'SCM_DIR_LANG_CHILD',      		SCM_DIR_CHILD . 'languages/' );
define( 'SCM_URI_LANG_CHILD',      		SCM_URI_CHILD . 'languages/' );		

// ------------------------------------------------------
// C.6 ROLE CONSTANTS
// ------------------------------------------------------

define( 'SCM_ROLE_ADMIN',     	 		'update_core' );
define( 'SCM_ROLE_OPTIONS',     		'manage_options' );
define( 'SCM_ROLE_PRIVATE',   	 		'edit_private_pages' );
define( 'SCM_ROLE_TAX',     	 		'manage_categories' );
define( 'SCM_ROLE_EDIT',     	 		'upload_files' );
define( 'SCM_ROLE_USERS',     	 		'list_users' );
define( 'SCM_ROLE_ENTER',     	 		'read' );
define( 'SCM_ROLE_READ',     	 		'read_private_pages' );


// ------------------------------------------------------
// C.7 LEVEL CONSTANTS
// ------------------------------------------------------

//define( 'SCM_LEVEL_ADVANCED',  	 		0 );

/*define( 'SCM_ROLE_ADMIN',               scm_field( 'role-admin', 'update_core', 'options' ) );
define( 'SCM_ROLE_OPTIONS',             scm_field( 'role-options', 'manage_options', 'options' ) );
define( 'SCM_ROLE_PRIVATE',             scm_field( 'role-private', 'edit_private_pages', 'options' ) );
define( 'SCM_ROLE_TAX',                 scm_field( 'role-tax', 'manage_categories', 'options' ) );
define( 'SCM_ROLE_EDIT',                scm_field( 'role-edit', 'upload_files', 'options' ) );
define( 'SCM_ROLE_USERS',               scm_field( 'role-users', 'list_users', 'options' ) );
define( 'SCM_ROLE_ENTER',               scm_field( 'role-enter', 'read', 'options' ) );
define( 'SCM_ROLE_READ',                scm_field( 'role-read', 'read_private_pages', 'options' ) );
define( 'SCM_LEVEL_ADVANCED',           scm_field( 'level-advanced', 1, 'options' ) );*/


// ------------------------------------------------------
// R.0 REQUIRE CLASSES
// ------------------------------------------------------

// Typekit_Client Class, for Adobe TypeKit Fonts integration.
require_once( SCM_DIR_CLASSES . 'Typekit_Client.php' );

// Get_Template_Part Class, extend WP function for passing arguments.
require_once( SCM_DIR_CLASSES . 'Get_Template_Part.php' );

// Custom_Type Class, for managing Custom Post Types.
require_once( SCM_DIR_CLASSES . 'Custom_Type.php' );

// Custom_Taxonomy Class, for managing Custom Taxonomies.
require_once( SCM_DIR_CLASSES . 'Custom_Taxonomy.php' );

// TGM_Plugin_Activation Class, for managing plugins.
require_once( SCM_DIR_CLASSES . 'TGM_Plugin_Activation.php' );

// Duplicate_Post Class, add duplicate functionality to any post.
require_once( SCM_DIR_CLASSES . 'Duplicate_Post.php' );

//require_once( SCM_DIR_CLASSES . 'ColorThief/ColorThief.php' );
//require_once( SCM_DIR_CLASSES . 'GetMostCommonColors.php' );

// ------------------------------------------------------
// R.1 REQUIRE MODULES
// ------------------------------------------------------

// UTILITIES

// SCM Utilities.

require_once( SCM_DIR_LIBRARY . 'scm-utils.php' );
require_once( SCM_DIR_LIBRARY . 'scm-utils-wp.php' );
require_once( SCM_DIR_LIBRARY . 'scm-utils-wpdb.php' );

// SCM ACF

require_once( SCM_DIR_LIBRARY . 'scm-acf.php' );
require_once( SCM_DIR_LIBRARY . 'scm-acf-utils-fa.php' );
require_once( SCM_DIR_LIBRARY . 'scm-acf-utils-choices.php' );
require_once( SCM_DIR_LIBRARY . 'scm-acf-utils.php' );
require_once( SCM_DIR_LIBRARY . 'scm-acf-fields.php' );
require_once( SCM_DIR_LIBRARY . 'scm-acf-fields-presets.php' );
require_once( SCM_DIR_LIBRARY . 'scm-acf-layouts-objects.php' );
require_once( SCM_DIR_LIBRARY . 'scm-acf-layouts-templates.php' );
require_once( SCM_DIR_LIBRARY . 'scm-acf-groups-posts.php' );
require_once( SCM_DIR_LIBRARY . 'scm-acf-groups-options.php' );

// INSTALL

require_once( SCM_DIR_LIBRARY . 'scm-install-roles.php' );
require_once( SCM_DIR_LIBRARY . 'scm-install-types.php' );
require_once( SCM_DIR_LIBRARY . 'scm-install-acf.php' );

// CORE

require_once( SCM_DIR_LIBRARY . 'scm-init-front.php' );
require_once( SCM_DIR_LIBRARY . 'scm-init-core.php' );
require_once( SCM_DIR_LIBRARY . 'scm-init-admin.php' );
//require_once( SCM_DIR_LIBRARY . 'scm-init-feed.php' );

// CONTENT

require_once( SCM_DIR_LIBRARY . 'scm-content-core.php' );
require_once( SCM_DIR_LIBRARY . 'scm-content-front.php' );
require_once( SCM_DIR_LIBRARY . 'scm-content-utils.php' );
