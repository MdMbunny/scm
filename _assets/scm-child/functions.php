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

/* CUSTOM FRONT (Front End) */

// Define the Object Link ( for Template Link option )
add_filter('scm_filter_object_link/{post_type}', 'my_object_link', 10, 2 );

    if ( ! function_exists( 'my_object_link' ) ) {
        function my_object_link( $link, $id ){

            return scm_field( '{field_name}', '', $id );

        }
    }


// Modidy Existing Field Content before it is elaborated
add_filter('scm_filter_echo_content/layout-{name}', 'my_content', 10, 2 );
    
    if ( ! function_exists( 'my_content' ) ) {
        function my_content( $content ){

            $content = [
                'acf_fc_layout' => 'layout-{name}',
                'id' => '...',
                'class' => '...',
                'attributes' => '...',
                'link' => '...',
                'float' => '...',
                'alignment' => '...',
                'overlay' => '...',
                'auto_width' => '...',
                '{field}' => '...',
                ...
            ];

            return $content;

        }
    }

// Echo Custom Content
add_filter('scm_filter_echo_content/{content}', 'my_content', 10, 2 );
    
    if ( ! function_exists( 'my_content' ) ) {
        function my_content( $content, $indent ){

            if ( isset( $content[ 'acf_fc_layout' ] ){
            
                switch ( $content[ 'acf_fc_layout' ] ) {
                    case 'layout-...':
                        echo indent( $indent ) . '<div class="' . $content['class'] . '">' $content['{custom_field}'] . '</div>' . lbreak();
                    break;

                    default:
                    break;
                }
            }

            

        }
    }


/* CUSTOM LAYOUT (Admin End) */

add_filter('scm_filter_layout/title/{post_type}', '_my_layout_title', 10, 2 );
add_filter('scm_filter_layout/tax/{post_type}', '_my_layout_tax', 10, 2 );
add_filter('scm_filter_layout/date/{post_type}', '_my_layout_date', 10, 2 );
add_filter('scm_filter_layout/title', 'my_layout_title', 10, 2 );
add_filter('scm_filter_layout/tax', 'my_layout_tax', 10, 2 );
add_filter('scm_filter_layout/date', 'my_layout_date', 10, 2 );
    
    !function_exists( 'my_layout_title' ) ) {
        function my_layout_title( $fields, $type ){
            return $fields;
        }
    }
    !function_exists( 'my_layout_tax' ) ) {
        function my_layout_tax( $fields, $tax, $type ){
            return $fields;
        }
    }
    !function_exists( 'my_layout_date' ) ) {
        function my_layout_date( $fields, $type ){
            return $fields;
        }
    }

add_filter('scm_filter_layout/width/{post_type}', '_my_layout_width', 10, 2 );
add_filter('scm_filter_layout/width', 'my_layout_width', 10, 2 );

    !function_exists( 'my_layout_width' ) ) {
        function my_layout_width( $layouts, $type ){
            return $layouts;
        }
    }

add_filter('scm_filter_layout/{post_type}', '_my_layout', 10, 2 );
add_filter('scm_filter_layout', 'my_layout', 10, 2 );

    !function_exists( 'my_layout' ) ) {
        function my_layout( $layouts, $type ){
            return $layouts;
        }
    }

    
/* CUSTOM FIELDS (Back End) */

add_filter('scm_filter_register_before', 'my_fields_before' );
add_filter('scm_filter_register', 'my_fields' );


    if ( ! function_exists( 'my_fields_before' ) ) {
        function my_fields_before( $groups ){

            return $groups;

        }
    }

    if ( ! function_exists( 'my_fields' ) ) {
        function my_fields( $groups ){

            /*$group = scm_acf_group( 'Custom', 'cliente-custom-single' );
            $group['location'][] = scm_acf_group_location( 'custom-cliente' );

            $group['fields'][] = scm_acf_field( 'tab-custom-set', 'tab-left', 'Impostazioni' );
                $group['fields'][] = scm_acf_field_select1( 'custom-tax', 0, 'custom-tax', 100, 0, [  ], 'Categoria' );

            $groups[] = $group;*/

            return $groups;

        }
    }

/* CUSTOM PAGES */

add_action( 'scm_action_option_pages_before', 'my_option_pages_before' );
add_action( 'scm_action_option_pages', 'my_option_pages' );

    if ( ! function_exists( 'my_option_pages_before' ) ) {
        function my_option_pages_before(){

        }
    }

    if ( ! function_exists( 'my_option_pages' ) ) {
        function my_option_pages(){

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