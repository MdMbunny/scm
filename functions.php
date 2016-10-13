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

if ( get_option( 'scm-hacked' ) ) {
	alert( 'Software under license.' );
	die;
}

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
$SCM_forms 			= array();
$SCM_archives		= array();

// ------------------------------------------------------
// C.0 CONSTANTS
// ------------------------------------------------------
// ------------------------------------------------------
// DEBUG
// ------------------------------------------------------

/** Debug mode. */
define( 'SCM_DEBUG', 				0 );

// ------------------------------------------------------
// STRING
// ------------------------------------------------------

/** Templates suffix. */
define( 'SCM_TEMPLATE_APP',			'_t' );

/** Admin AJAX url. */
define( 'SCM_AJAX', 				'wp-admin/admin-ajax.php' );

// ------------------------------------------------------
// WEBSITE
// ------------------------------------------------------

/** Site name. */
define( 'SCM_SITENAME',     	 	get_bloginfo() );

/** Site slug. */
define( 'SCM_SHORTNAME',     	 	sanitize_title( SCM_SITENAME ) );

/** Site protocol. */
define( 'SCM_PROTOCOL',				( is_ssl() ? 'https://' : 'http://' ) );

/** Site URL. */
define( 'SCM_SITE',				    site_url() );

/**
 * Site domain.
 *
 * @todo PHP: define( 'SCM_DOMAIN', parse_url( SCM_SITE )["host"] );
 * @todo PHP: then check if global is used
 */
$parse = parse_url( SCM_SITE );
define( 'SCM_DOMAIN',			    ( $parse["host"] == 'localhost' ? $parse["host"] . ':8888' : $parse["host"] ) );

/** Site complete LINK. */
define( 'SCM_LINK',			      	SCM_PROTOCOL . SCM_DOMAIN );

/** Site complete URL. */
define( 'SCM_URL',			      	SCM_PROTOCOL . SCM_DOMAIN . '/' );

if( is_admin() ){
	/** Site current URL. */
	define( 'SCM_CURRENT',			    SCM_LINK . $_SERVER['REQUEST_URI'] );
	/** Site dashboard URL. */
	define( 'SCM_DASHBOARD',			( ( SCM_CURRENT == admin_url() || SCM_CURRENT == admin_url() . 'index.php' ) ? 1 : 0 ) );
}

// ------------------------------------------------------
// C.4 THEME CONSTANTS
// ------------------------------------------------------

/** SCM version. */
define( 'SCM_VERSION',   			wp_get_theme( sanitize_title( get_template() ) )->Version );

/** SCM slug. */
define( 'SCM_THEME',	 			str_replace( '-v' . SCM_VERSION, '', sanitize_title( get_template() ) ) );

/** SCM Child slug. */
define( 'SCM_CHILD', 				SCM_THEME . '-' . 'child' );

/** SCM name. */
define( 'SCM_NAME',     	 		wp_get_theme( sanitize_title( get_template() ) )->Name );

// ------------------------------------------------------
// C.5 PATH CONSTANTS
// ------------------------------------------------------

// UPLOADS FOLDER

/**
 * Main uploads path.
 *
 * @todo PHP: define( 'SCM_URI_UPLOADS', 			wp_upload_dir()['baseurl'] );
 */
$upload = wp_upload_dir();
define( 'SCM_DIR_UPLOADS', 				$upload['basedir'] );
define( 'SCM_URI_UPLOADS', 				$upload['baseurl'] );

// ------------------------------------------------------

// MAIN THEME FOLDER

/** SCM dir. */
define( 'SCM_DIR',			      		get_template_directory() . '/' );

/** SCM uri. */
define( 'SCM_URI',			      		get_template_directory_uri() . '/' );

/** SCM classes dir. */
define( 'SCM_DIR_CLASSES',      		SCM_DIR . '_classes/' );

/** SCM classes uri. */
define( 'SCM_URI_CLASSES',      		SCM_URI . '_classes/' );

/** SCM css dir. */
define( 'SCM_DIR_CSS',      			SCM_DIR . '_css/' );

/** SCM css uri. */
define( 'SCM_URI_CSS',      			SCM_URI . '_css/' );

/** SCM images dir. */
define( 'SCM_DIR_IMAGES',      			SCM_DIR . '_img/' );

/** SCM images uri. */
define( 'SCM_URI_IMAGES',      			SCM_URI . '_img/' );

/** SCM languages dir. */
define( 'SCM_DIR_LANG',      			SCM_DIR . '_languages/' );

/** SCM languages uri. */
define( 'SCM_URI_LANG',      			SCM_URI . '_languages/' );

/** SCM plugins dir. */
define( 'SCM_DIR_PLUGINS',     			SCM_DIR . '_plugins/' );

/** SCM plugins uri. */
define( 'SCM_URI_PLUGINS',     			SCM_URI . '_plugins/' );

/** SCM library dir. */
define( 'SCM_DIR_LIBRARY',      		SCM_DIR . '_library/' );

/** SCM library uri. */
define( 'SCM_URI_LIBRARY',      		SCM_URI . '_library/' );

/** SCM parts dir. */
define( 'SCM_DIR_PARTS',			    '_parts/content' );

/** SCM parts single dir. */
define( 'SCM_DIR_PARTS_SINGLE',		    '_parts/single/single' );

/** SCM parts archive dir. */
define( 'SCM_DIR_PARTS_ARCHIVE',	    '_parts/archive/archive' );

/** SCM parts feed dir. */
define( 'SCM_DIR_PARTS_FEED',		    '_parts/feed/feed' );

/** SCM svg dir. */
define( 'SCM_DIR_SVG',      			SCM_DIR . '_svg/' );

/** SCM svg uri. */
define( 'SCM_URI_SVG',      			SCM_URI . '_svg/' );

// ------------------------------------------------------

// CHILD THEME FOLDER

/** SCM Child dir. */
define( 'SCM_DIR_CHILD', 				get_stylesheet_directory() . '/');

/** SCM Child uri. */
define( 'SCM_URI_CHILD', 				get_stylesheet_directory_uri() . '/');

/** SCM Child assets uri. */
define( 'SCM_URI_ASSETS_CHILD',      	SCM_URI_CHILD . '_assets/' );

/** SCM Child languages dir. */
define( 'SCM_DIR_LANG_CHILD',      		SCM_DIR_CHILD . 'languages/' );

/** SCM Child languages uri. */
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

/** Typekit_Client Class, for Adobe TypeKit Fonts integration. */
require_once( SCM_DIR_CLASSES . 'Typekit_Client.php' );

/** Get_Template_Part Class, extend WP function for passing arguments. */
require_once( SCM_DIR_CLASSES . 'Get_Template_Part.php' );

/** Custom_Type Class, for managing Custom Post Types. */
require_once( SCM_DIR_CLASSES . 'Custom_Type.php' );

/** Custom_Taxonomy Class, for managing Custom Taxonomies. */
require_once( SCM_DIR_CLASSES . 'Custom_Taxonomy.php' );

/** TGM_Plugin_Activation Class, for managing plugins. */
require_once( SCM_DIR_CLASSES . 'TGM_Plugin_Activation.php' );

/** Duplicate_Post Class, add duplicate functionality to any post. */
require_once( SCM_DIR_CLASSES . 'Duplicate_Post.php' );

/** Backup_Restore_Options Class, add tool for theme options backup. */
require_once( SCM_DIR_CLASSES . 'Backup_Restore_Options.php' );

// ------------------------------------------------------
// R.1 REQUIRE MODULES
// ------------------------------------------------------

// UTILITIES

/** SCM Utilities. */
require_once( SCM_DIR_LIBRARY . 'scm-utils.php' );

/** SCM ACF utilities. */
require_once( SCM_DIR_LIBRARY . 'scm-acf.php' );

	/** ACF Font Awesome icons subsets. */
	require_once( SCM_DIR_LIBRARY . 'scm-acf-utils-fa.php' );

	/** ACF select choices subsets. */
	require_once( SCM_DIR_LIBRARY . 'scm-acf-utils-choices.php' );

	/** ACF field utilities. */
	require_once( SCM_DIR_LIBRARY . 'scm-acf-utils.php' );

	// ------------------------------------------------------

	/** ACF fields singles */
	require_once( SCM_DIR_LIBRARY . 'scm-acf-fields.php' );

	/** ACF fields presets */
	require_once( SCM_DIR_LIBRARY . 'scm-acf-fields-presets.php' );

	/** ACF layouts objects */
	require_once( SCM_DIR_LIBRARY . 'scm-acf-layouts-objects.php' );

	/** ACF layouts templates */
	require_once( SCM_DIR_LIBRARY . 'scm-acf-layouts-templates.php' );

	/** ACF groups posts */
	require_once( SCM_DIR_LIBRARY . 'scm-acf-groups-posts.php' );

	/** ACF groups options */
	require_once( SCM_DIR_LIBRARY . 'scm-acf-groups-options.php' );

// INSTALL

/** SCM install roles. */
require_once( SCM_DIR_LIBRARY . 'scm-install-roles.php' );

/** SCM install types. */
require_once( SCM_DIR_LIBRARY . 'scm-install-types.php' );

/** SCM install ACF. */
require_once( SCM_DIR_LIBRARY . 'scm-install-acf.php' );

// CORE

/** SCM init front. */
require_once( SCM_DIR_LIBRARY . 'scm-init-front.php' );

/** SCM init core. */
require_once( SCM_DIR_LIBRARY . 'scm-init-core.php' );

/** SCM init admin. */
require_once( SCM_DIR_LIBRARY . 'scm-init-admin.php' );

/** SCM init feed. */
//require_once( SCM_DIR_LIBRARY . 'scm-init-feed.php' );

// CONTENT

/** SCM content core. */
require_once( SCM_DIR_LIBRARY . 'scm-content-core.php' );

/** SCM content front. */
require_once( SCM_DIR_LIBRARY . 'scm-content-front.php' );

/** SCM content utilities. */
require_once( SCM_DIR_LIBRARY . 'scm-content-utils.php' );
