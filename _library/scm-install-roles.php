<?php
/**
 * @package SCM
 */

$SCM_roles = array();

// *****************************************************
// *    SCM INSTALL - ROLES
// *****************************************************

/*
*****************************************************
*
*   0.0 Actions and Filters
*   1.0 Functions
*
*****************************************************
*/

// *****************************************************
// *      0.0 ACTIONS AND FILTERS
// *****************************************************

    add_action( 'after_setup_theme', 'scm_roles_install' );
    add_action( 'after_setup_theme', 'scm_roles_admin_redirect' );
    add_filter( 'editable_roles', 'scm_roles_allowed_list' );
    add_filter( 'map_meta_cap', 'scm_roles_allowed_edit', 10, 4 );
    add_action( 'pre_user_query', 'scm_roles_allowed_show' );
    
      
// *** Install Roles

    if ( ! function_exists( 'scm_roles_install' ) ) {
        function scm_roles_install() {

            global $SCM_roles, $pagenow;

            $user = wp_get_current_user();

            $SCM_roles = array( 
                'super'         => array( 0,        0,                              1 ),
                'administrator' => array( 10,       0,                              'update_core' ),
                'manager'       => array( 20,       __( 'Manager', SCM_THEME ),     array( 'manage_options', 'edit_users', 'list_users', 'remove_users', 'delete_users', 'create_users', 'upload_files', 'manage_categories', 'read_private_pages', 'read_private_posts', 'read' ) ),
                'staff'         => array( 30,       __( 'Staff', SCM_THEME ),       array( 'edit_users', 'list_users', 'remove_users', 'delete_users', 'create_users', 'upload_files', 'manage_categories', 'read_private_pages', 'read_private_posts', 'read' ) ),
                'member'        => array( 40,       __( 'Member', SCM_THEME ),      array( 'upload_files', 'manage_categories', 'read_private_pages', 'read_private_posts', 'read' ) ),
                'utente'        => array( 50,       __( 'User', SCM_THEME ),        array( 'read_private_pages', 'read_private_posts' ) ),
                'iscritto'      => array( 60,       __( 'Subscriber', SCM_THEME ),  array('') ),
                'visitatore'    => array( 100,      0,                              0 ),
            );

            if( $pagenow == 'admin.php' && $_GET['page'] == 'scm-options-intro' ) // ++todo: ADD: if RESET ROLES options is active (o qualcosa del genere)
                scm_roles_reset();

            $cur_rl = '';
            $cur_lv = 100;

            foreach ( $SCM_roles as $role => $value) {
                
                if( !is_array( $value ) )
                    continue;
                
                $level = ( isset( $value[0] ) ? $value[0] : 100 );
                $add = ( isset( $value[1] ) ? $value[1] : 0 );
                $cap = ( isset( $value[2] ) ? $value[2] : 0 );
                
                define( 'SCM_ROLE_' . strtoupper( $role ), $level );
                
                if( isset( $add ) && $add && is_array( $cap ) && !get_role( $role ) ){
                    consoleDebug( 'install role: ' . $role );
                    $arr = array();
                    foreach ( $cap as $cp )
                        $arr[$cp] = true;
                    
                    $the_role = add_role(
                        $role,
                        $add,
                        $arr
                    );

                }

                if( $cur_lv > $level && $cap && (
                ( is_string( $cap ) && $user->has_cap( $cap ) ) ||
                ( is_array( $cap ) && $user->has_cap( $cap[0] ) ) ||
                ( is_numeric( $cap ) && $user->ID === $cap ) ) ){
                    consoleDebug( 'current role: ' . $role );
                    $cur_rl = $role;
                    $cur_lv = $level;
                }
            }

            define( 'SCM_CAPABILITY', $cur_rl );
            define( 'SCM_LEVEL', $cur_lv );
        }
    }

// *** Redirect low cap Users to Home Page when they log in
    
    if ( ! function_exists( 'scm_roles_admin_redirect' ) ) {
        function scm_roles_admin_redirect() {
            
            if( SCM_DASHBOARD ){
                wp_redirect( scm_role_redirect('') );
                die;
            }

            if ( SCM_LEVEL >= SCM_ROLE_UTENTE && !defined( 'DOING_AJAX' ) ) { 
                wp_redirect( scm_role_redirect('user') );
                die;
            }
        }
    }

// *** Filter Roles
    
    if ( ! function_exists( 'scm_roles_allowed_list' ) ) {
        function scm_roles_allowed_list( $roles ) {
            
            if ( $user = wp_get_current_user() ) {
                
                $allowed = scm_roles_allowed( $user );

                foreach ( $roles as $role => $caps ) {
                    if ( ! in_array( $role, $allowed ) )
                        unset( $roles[ $role ] );
                }
            }

            return $roles;
        }
    }

    if ( ! function_exists( 'scm_roles_allowed_edit' ) ) {
        function scm_roles_allowed_edit( $caps, $cap, $user_ID, $args ) {

            if ( ( $cap === 'edit_user' || $cap === 'delete_user' ) && $args ) {
                $the_user = get_userdata( $user_ID ); // The user performing the task
                $user     = get_userdata( $args[0] ); // The user being edited/deleted

                if ( $the_user && $user && $the_user->ID != $user->ID ) {
                    $allowed = scm_roles_allowed( $the_user );

                    if ( array_diff( $user->roles, $allowed ) ) {
                        $caps[] = 'not_allowed';
                    }
                }
            }

            return $caps;
        }
    }

    if ( ! function_exists( 'scm_roles_allowed_show' ) ) {
        function scm_roles_allowed_show( $user_search ) {

            global $wpdb;
            $user = wp_get_current_user();
            $user->get_role_caps();
            $where = 'WHERE 1=1';

            // Temporarily remove this hook otherwise we might be stuck in an infinite loop
            remove_action( 'pre_user_query', 'scm_roles_allowed_show' );


            if( SCM_LEVEL > SCM_ROLE_SUPER ){

                $admin_ids = array( 1 );

                if( SCM_LEVEL >= SCM_ROLE_MANAGER ){
                    
                    foreach ( get_users( array( 'role' => 'administrator' ) ) as $admin )
                        $admin_ids[] = $admin->id;                    

                    if( SCM_LEVEL >= SCM_ROLE_STAFF ){
                        
                        foreach ( get_users( array( 'role' => 'manager' ) ) as $admin )
                            $admin_ids[] = $admin->id;

                        if( SCM_LEVEL >= SCM_ROLE_MEMBER ){
                            
                            foreach ( get_users( array( 'role' => 'staff' ) ) as $admin )
                                $admin_ids[] = $admin->id;

                        }

                    }

                }

                $where .= ' AND '.$wpdb->users.'.ID NOT IN ('.implode(',', $admin_ids).')';
                
            }

            $user_search->query_where = str_replace(
                'WHERE 1=1',
                $where,
                $user_search->query_where
            );

            // Re-add the hook
            add_action( 'pre_user_query', 'scm_roles_allowed_show' );

        }
    }


// *****************************************************
// *      1.0 FUNCTIONS
// *****************************************************

// *** ALL

    if ( ! function_exists( 'scm_roles_reset' ) ) {
        function scm_roles_reset() {

            consoleDebug( 'reset roles' );

            global $SCM_roles;

            remove_role('editor');
            remove_role('author');
            remove_role('contributor');
            remove_role('subscriber');
            foreach ( $SCM_roles as $key => $value) {
                if( scm_role_level( $key ) >= SCM_ROLE_MANAGER )
                    remove_role('key');
            }
        }
    }

    if ( ! function_exists( 'scm_roles_allowed' ) ) {
        function scm_roles_allowed( $user ) {

            global $SCM_roles;

            $level = ( $user ? scm_role_level( $user ) : SCM_LEVEL );
            
            $allowed = array();

            if ( $level === 0 ) {
                $allowed = array_keys( $GLOBALS['wp_roles']->roles );
            }elseif ( $level < SCM_ROLE_UTENTE ) {
                foreach ($SCM_roles as $role => $value) {
                    if( scm_role_level( $role ) > $level )
                        $allowed[] = $role;
                }
            }

            

            return $allowed;
        }
    }

// *** SINGLE

    if ( ! function_exists( 'scm_role_redirect' ) ) {
        function scm_role_redirect( $user ) {
            
            $level = ( $user ? scm_role_level( $user ) : SCM_LEVEL );
            $user = ( $user ?: SCM_CAPABILITY );

            
            if( $level === 0 )
                return admin_url('themes.php?page=scm-install-plugins');
            elseif( $level < SCM_ROLE_STAFF )
                return admin_url('admin.php?page=scm-options-intro');
            elseif( $level < SCM_ROLE_UTENTE )
                return admin_url('users.php');
            
            return home_url();

        }
    }

    if ( ! function_exists( 'scm_role_highest_level' ) ) {
        function scm_role_highest_level( $roles = array() ){
            $arr = array();
            foreach ($roles as $role) {
                $arr[] = scm_role_level( $role );
            }
            return min( $arr );
        }
    }

    if ( ! function_exists( 'scm_role_level' ) ) {
        function scm_role_level( $obj = '' ){
            global $SCM_roles;

            if( !isset($obj) || !$obj )
                return 100;

            if( is_string( $obj ) ){

                $obj = $SCM_roles[ $obj ];

            }elseif ( get_class( $obj ) == 'WP_User' ){

                if( $obj->ID === 1 )
                    return 0;

                return scm_role_highest_level( $obj->roles );

            }elseif (get_class( $obj ) == 'WP_Role'){

                $obj = $SCM_roles[ $obj->name ];

            }

            if( isset($obj) && isset($obj[0]) )
                return $obj[0];

            return 100;
        }
    }
         
    if ( ! function_exists( 'scm_role_caps' ) ) {
        function scm_role_caps( $role, $obj ){

            if ( !$role || !obj )
                return;

            $role = ( is_string( $role ) ? get_role( $role ) : $role );

            $singular = $obj->cap_singular;
            $plural = $obj->cap_plural;
            $admin = $obj->admin;
            $add = $obj->add_cap;
            $level = scm_role_level( $role );

            if( $level >= SCM_ROLE_ISCRITTO || ( $level >= SCM_ROLE_STAFF && $admin ) ){
                
                $role->remove_cap( 'read_private_' . $plural );
                $role->remove_cap( 'edit_' . $plural );
                $role->remove_cap( 'edit_private_' . $plural );
                $role->remove_cap( 'edit_others_' . $plural );
                $role->remove_cap( 'edit_published_' . $plural );
                $role->remove_cap( 'publish_' . $plural );
                $role->remove_cap( 'delete_' . $plural );
                $role->remove_cap( 'delete_others_' . $plural );
                $role->remove_cap( 'delete_private_' . $plural );
                $role->remove_cap( 'delete_published_' . $plural );

            }else{

                $role->add_cap( 'read_private_' . $plural );
                $role->add_cap( 'edit_' . $plural );
                $role->add_cap( 'edit_private_' . $plural );
                $role->add_cap( 'edit_others_' . $plural );
                $role->add_cap( 'edit_published_' . $plural );

                if( $level >= SCM_ROLE_MEMBER || ( !$add && $level >= SCM_ROLE_STAFF ) ){

                    $role->remove_cap( 'publish_' . $plural );
                    $role->remove_cap( 'delete_' . $plural );
                    $role->remove_cap( 'delete_others_' . $plural );
                    $role->remove_cap( 'delete_private_' . $plural );
                    $role->remove_cap( 'delete_published_' . $plural );

                }else{

                    $role->add_cap( 'publish_' . $plural );
                    $role->add_cap( 'delete_' . $plural );
                    $role->add_cap( 'delete_others_' . $plural );
                    $role->add_cap( 'delete_private_' . $plural );
                    $role->add_cap( 'delete_published_' . $plural );

                }
            }

            do_action( 'scm_action_role_caps', $role );

        }
    }



?>