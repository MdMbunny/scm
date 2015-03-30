<?php

/*
 Theme Name:   SCM Child
 Theme URI:    http://studiocreativo-m.it
 Description:  SCM Child Theme
 Author:       SCM
 Author URI:   http://studiocreativo-m.it
 Template:     scm
 Version:      1.0.0
 Tags:         scm
 Text Domain:  scm-child
*/


add_filter('scm_filter_acf_register_before', 'scm_custom_fields_before' );
add_filter('scm_filter_acf_register', 'scm_custom_fields' );

    if ( ! function_exists( 'scm_custom_fields_before' ) ) {
        function scm_custom_fields_before( $groups ){

            return $groups;

        }
    }

    if ( ! function_exists( 'scm_custom_fields' ) ) {
        function scm_custom_fields( $groups ){

            return $groups;

        }
    }

add_action( 'scm_action_acf_option_pages_before', 'scm_custom_option_pages_before' );
add_action( 'scm_action_acf_option_pages', 'scm_custom_option_pages' );

    if ( ! function_exists( 'scm_action_acf_option_pages_before' ) ) {
        function scm_action_acf_option_pages_before(){

        }
    }

	if ( ! function_exists( 'scm_custom_option_pages' ) ) {
        function scm_custom_option_pages(){

        }
    }