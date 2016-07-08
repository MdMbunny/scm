<?php

/**
* scm-install.php.
*
* SCM install functions.
*
* @link http://www.studiocreativo-m.it
*
* @package SCM
* @subpackage Install
* @since 1.0.0
*/

/** Install roles. */
require_once( SCM_DIR_LIBRARY . 'scm-install-roles.php' );

/** Install types. */
require_once( SCM_DIR_LIBRARY . 'scm-install-types.php' );

/** Install acf. */
require_once( SCM_DIR_LIBRARY . 'scm-install-acf.php' );

// ------------------------------------------------------

/**
* @var {object} SCM_typekit Global array to store Adobe Typekit kits
*/
$SCM_typekit;

// ------------------------------------------------------
//
// 0.0 Actions and Filters
//
// ------------------------------------------------------

//if ( ! function_exists( 'scm_admin_ui_init' ) ) {
//    function scm_admin_ui_init() {

// ------------------------------------------------------
// 0.0 ACTIONS AND FILTERS
// ------------------------------------------------------

/** Remove unused WP actions */
remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
remove_action( 'wp_print_styles', 'print_emoji_styles' );
remove_action( 'admin_print_styles', 'print_emoji_styles' );
remove_action( 'wp_head', 'feed_links_extra', 3 );
remove_action( 'wp_head', 'feed_links', 2 );
remove_action( 'wp_head', 'wlwmanifest_link' );
remove_action( 'wp_head', 'rsd_link' );
remove_action( 'wp_head', 'wp_generator' );

add_action( 'after_switch_theme', 'scm_hook_theme_activate' );
add_action( 'switch_theme', 'scm_hook_theme_deactivate' );
add_action( 'upgrader_process_complete', 'scm_hook_theme_update' );

// ------------------------------------------------------

/**
* [SET] 'scm-settings-installed' option to true.
*
* Hooked by 'after_switch_theme'
*/
function scm_hook_theme_activate() {
    update_option( 'scm-settings-installed', 1 );
}

/**
* [SET] 'scm-settings-installed' option to false.
*
* Hooked by 'switch_theme'
*/
function scm_hook_theme_deactivate() {
    update_option( 'scm-settings-installed', 0 );
}

/**
* [SET] 'scm-version' option to SCM_VERSION.
*
* Hooked by 'upgrader_process_complete'
*/
function scm_hook_theme_update() {
    update_option( 'scm-version', SCM_VERSION );
}

//}}
//add_action( 'init', 'scm_admin_ui_init' );

?>