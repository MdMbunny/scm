<?php
/**
 * @package SCM
 */

$SCM_typekit;

// *****************************************************
// *    SCM INSTALL
// *****************************************************

/*
*****************************************************
*
*   0.0 Require
*   1.0 Actions and Filters
*   2.0 Functions
*
*****************************************************
*/

// *****************************************************
// *      0.0 REQUIRE
// *****************************************************

    require_once( SCM_DIR_LIBRARY . 'scm-install-roles.php' );
    require_once( SCM_DIR_LIBRARY . 'scm-install-types.php' );
    require_once( SCM_DIR_LIBRARY . 'scm-install-acf.php' );

if ( ! function_exists( 'scm_admin_ui_init' ) ) {
    function scm_admin_ui_init() {

// *****************************************************
// *      1.0 ACTIONS AND FILTERS
// *****************************************************

    // Removing unused WP actions
    remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
    remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
    remove_action( 'wp_print_styles', 'print_emoji_styles' );
    remove_action( 'admin_print_styles', 'print_emoji_styles' );
    remove_action( 'wp_head', 'feed_links_extra', 3 );
    remove_action( 'wp_head', 'feed_links', 2 );
    remove_action( 'wp_head', 'wlwmanifest_link' );
    remove_action( 'wp_head', 'rsd_link' );
    remove_action( 'wp_head', 'wp_generator' );

    //add_action( 'after_setup_theme', 'scm_typekit_install' );
    add_action( 'after_switch_theme', 'scm_theme_activate' );
    add_action( 'upgrader_process_complete', 'scm_theme_update' );
    add_action( 'switch_theme', 'scm_theme_deactivate' );


// *****************************************************
// *      2.0 FUNCTIONS
// *****************************************************

// *** Install TypeKit
    //if ( ! function_exists( 'scm_typekit_install' ) ) {
        //function scm_typekit_install() {

            // todo: SOLO SE NECESSARIO

            global $SCM_typekit;
            $SCM_typekit = new Typekit_Client();
        //}
    //}

// *** Theme Activation
    if ( ! function_exists( 'scm_theme_activate' ) ) {
        function scm_theme_activate() {
            update_option( 'scm-settings-installed', 1 );
        }
    }

    if ( ! function_exists( 'scm_theme_update' ) ) {
        function scm_theme_update() {
            update_option( 'scm-version', SCM_VERSION );
        }
    }

    if ( ! function_exists( 'scm_theme_deactivate' ) ) {
        function scm_theme_deactivate() {
            update_option( 'scm-settings-installed', 0 );
        }
    }

}}
add_action( 'init', 'scm_admin_ui_init' );

?>