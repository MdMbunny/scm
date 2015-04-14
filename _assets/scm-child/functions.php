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


/* CUSTOM LAYOUT */

add_filter('scm_filter_element_before', 'scm_custom_element_before', 10, 2 );

    !function_exists( 'scm_custom_element_before' ) ) {
        function scm_custom_element_before( $layouts, $type ){
            return $layouts;
        }
    }

add_filter('scm_filter_element', 'scm_custom_element', 10, 2 );

    !function_exists( 'scm_custom_element' ) ) {
        function scm_custom_element( $layouts, $type ){
            return $layouts;
        }
    }

add_filter('scm_filter_acf_layout/title/link', 'scm_custom_layout_title_link', 10, 2 );
add_filter('scm_filter_acf_layout/tax/link', 'scm_custom_layout_tax_link', 10, 2 );
add_filter('scm_filter_acf_layout/date/link', 'scm_custom_layout_date_link', 10, 2 );
    
    !function_exists( 'scm_custom_layout_title_link' ) ) {
        function scm_custom_layout_title_link( $field, $type ){
            return $field;
        }
    }
    !function_exists( 'scm_custom_layout_tax_link' ) ) {
        function scm_custom_layout_tax_link( $field, $tax, $type ){
            return $field;
        }
    }
    !function_exists( 'scm_custom_layout_date_link' ) ) {
        function scm_custom_layout_date_link( $field, $type ){
            return $field;
        }
    }
add_filter('scm_filter_acf_layout/title', 'scm_custom_layout_title', 10, 2 );
add_filter('scm_filter_acf_layout/tax', 'scm_custom_layout_tax', 10, 2 );
add_filter('scm_filter_acf_layout/date', 'scm_custom_layout_date', 10, 2 );
    
    !function_exists( 'scm_custom_layout_title' ) ) {
        function scm_custom_layout_title( $fields, $type ){
            return $fields;
        }
    }
    !function_exists( 'scm_custom_layout_tax' ) ) {
        function scm_custom_layout_tax( $fields, $tax, $type ){
            return $fields;
        }
    }
    !function_exists( 'scm_custom_layout_date' ) ) {
        function scm_custom_layout_date( $fields, $type ){
            return $fields;
        }
    }

add_filter('scm_filter_acf_layout/width', 'scm_custom_layout_width', 10, 2 );

    !function_exists( 'scm_custom_layout_width' ) ) {
        function scm_custom_layout_width( $layouts, $type ){
            return $layouts;
        }
    }

add_filter('scm_filter_acf_layout', 'scm_custom_layout', 10, 2 );

    !function_exists( 'scm_custom_layout' ) ) {
        function scm_custom_layout( $layouts, $type ){
            return $layouts;
        }
    }

    
/* CUSTOM FIELDS */

add_filter('scm_filter_acf_register_before', 'scm_custom_fields_before' );
add_filter('scm_filter_acf_register', 'scm_custom_fields' );


    if ( ! function_exists( 'scm_custom_fields_before' ) ) {
        function scm_custom_fields_before( $groups ){

            return $groups;

        }
    }

    if ( ! function_exists( 'scm_custom_fields' ) ) {
        function scm_custom_fields( $groups ){

            /*$group = scm_acf_group( 'Custom', 'cliente-custom-single' );
            $group['location'][] = scm_acf_group_location( 'custom-cliente' );

            $group['fields'][] = scm_acf_field( 'tab-custom-set', 'tab-left', 'Impostazioni' );
                $group['fields'][] = scm_acf_field_select1( 'custom-tax', 0, 'custom-tax', 100, 0, [  ], 'Categoria' );

            $groups[] = $group;*/

            return $groups;

        }
    }

/* CUSTOM PAGES */

add_action( 'scm_action_acf_option_pages_before', 'scm_custom_option_pages_before' );
add_action( 'scm_action_acf_option_pages', 'scm_custom_option_pages' );

    if ( ! function_exists( 'scm_custom_option_pages_before' ) ) {
        function scm_custom_option_pages_before(){

        }
    }

    if ( ! function_exists( 'scm_custom_option_pages' ) ) {
        function scm_custom_option_pages(){

            /*if( function_exists('acf_add_options_page') ) {

                acf_add_options_page(array(
                    'page_title'    => 'Opzioni Cliente',
                    'menu_title'    => 'Cliente',
                    'menu_slug'     => 'cliente-settings',
                    'position'      => '1',
                    'capability'    => 'list_users',
                    'redirect'      => true,
                    'icon_url'      => SCM_URI_IMG_CHILD . '/icona_cliente.png'
                ));

            }

            if( function_exists('acf_add_options_sub_page') ) {

                acf_add_options_sub_page(array(
                    'page_title'    => 'Sub Page',
                    'menu_title'    => 'Sub',
                    'parent_slug'   => 'cliente-settings',
                    'menu_slug'     => 'cliente-sub',
                    'capability'    => 'list_users',
                ));

            }*/
        }
    }