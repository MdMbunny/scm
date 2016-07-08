<?php

/**
 * scm-setup-constants.php.
 *
 * SCM setup constants.
 *
 * @link http://www.studiocreativo-m.it
 *
 * @package SCM
 * @subpackage Setup/Constants
 * @since 1.0.0
 */

// ------------------------------------------------------
// 1.0 DEBUG CONSTANTS
// ------------------------------------------------------

/** Debug mode. */
define( 'SCM_DEBUG', 				0 );

// ------------------------------------------------------
// 2.0 APPEND CONSTANTS
// ------------------------------------------------------

/** Templates suffix. */
define( 'SCM_TEMPLATE_APP',			'_t' );

// ------------------------------------------------------
// 3.0 WEBSITE CONSTANTS
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
 * @global string $SCM_parse
 *
 * @todo PHP: define( 'SCM_DOMAIN', parse_url( SCM_SITE )["host"] );
 * @todo PHP: then check if global is used
 */
$SCM_parse = parse_url( SCM_SITE );
define( 'SCM_DOMAIN',			    $SCM_parse["host"] );

/** Site complete URL. */
define( 'SCM_URL',			      	SCM_PROTOCOL . SCM_DOMAIN . '/' );

/** Site current page. */
define( 'SCM_SCREEN',			    $_SERVER['REQUEST_URI'] );

/** Site current URL. */
define( 'SCM_CURRENT',			    SCM_SITE . SCM_SCREEN );

/** Site dashboard URL. */
define( 'SCM_DASHBOARD',			( ( SCM_CURRENT == admin_url() || SCM_CURRENT == admin_url() . 'index.php' ) ? 1 : 0 ) );

// ------------------------------------------------------
// 4.0 THEME CONSTANTS
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
// 5.0 PATH CONSTANTS
// ------------------------------------------------------

// UPLOADS FOLDER

/**
 * Main uploads path.
 *
 * @todo PHP: define( 'SCM_URI_UPLOADS', 			wp_upload_dir()['baseurl'] );
 */
$SCM_upload = wp_upload_dir();	
define( 'SCM_URI_UPLOADS', 				$SCM_upload['baseurl'] );

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
// 6.0 ROLE CONSTANTS
// ------------------------------------------------------

/** Admin role. */
define( 'SCM_ROLE_ADMIN',     	 		'update_core' );

/** Options role. */
define( 'SCM_ROLE_OPTIONS',     		'manage_options' );

/** Private role. */
define( 'SCM_ROLE_PRIVATE',   	 		'edit_private_pages' );

/** Taxonomies role. */
define( 'SCM_ROLE_TAX',     	 		'manage_categories' );

/** Edit role. */
define( 'SCM_ROLE_EDIT',     	 		'upload_files' );

/** Users role. */
define( 'SCM_ROLE_USERS',     	 		'list_users' );

/** Enter role. */
define( 'SCM_ROLE_ENTER',     	 		'read' );

/** Read role. */
define( 'SCM_ROLE_READ',     	 		'read_private_pages' );

?>