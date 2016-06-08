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
    add_action( 'init', 'scm_roles_admin_redirect' );
    add_filter( 'editable_roles', 'scm_roles_allowed_list' );
    add_filter( 'map_meta_cap', 'scm_roles_allowed_edit', 10, 4 );
    add_action( 'pre_user_query', 'scm_roles_allowed_show' );
    add_action( 'scm_action_types_capabilities', 'scm_roles_post_caps', 10, 3 );

      
// *** Install Roles

    if ( ! function_exists( 'scm_roles_install' ) ) {
        function scm_roles_install() {

            global $SCM_roles;

            // ++todo: Questo oggetto si deve costruire con dei valori dei default (prendi capabilities da costanti SCM_ROLE_)
            // ++todo: Ci vuole un plugin, o comunque una pagina opzioni, dove creare i Ruoli (Super e Visitatore non sono ruoli, Admin esiste già)
            // Dalle costanti SCM_ROLE_ scegli una cap di default (che attiva pure le sue superiori)
            // Scegli un livello tra 0 e 100 esclusi
            // Definisci un nome + slug
            // Aggiungi capabilities a quelle di default
            // Quelle di default saranno, per esempio: SCM_ROLE_PRIVATE = 'edit_private_pages', quindi aggiungi anche 'list_users', 'upload_files', ecc

            $SCM_roles = array( 
                'super'         => array( 0,        0,                              1 ),
                'administrator' => array( 10,       0,                              'update_core' ),
                'manager'       => array( 20,       __( 'Manager', SCM_THEME ),     array( 'edit_private_pages', 'edit_private_posts', 'edit_users', 'list_users', 'remove_users', 'delete_users', 'create_users', 'upload_files', 'manage_categories', 'read_private_pages', 'read_private_posts', 'read' ) ),
                'staff'         => array( 30,       __( 'Staff', SCM_THEME ),       array( 'manage_categories', 'list_users', 'edit_users', 'remove_users', 'delete_users', 'create_users', 'upload_files', 'read_private_pages', 'read_private_posts', 'read' ) ),
                'member'        => array( 40,       __( 'Member', SCM_THEME ),      array( 'upload_files', 'list_users', 'read_private_pages', 'read_private_posts', 'read' ) ),
                'utente'        => array( 50,       __( 'User', SCM_THEME ),        array( 'read_private_pages', 'read_private_posts' ) ),
                'iscritto'      => array( 60,       __( 'Subscriber', SCM_THEME ),  array('') ),
                'visitatore'    => array( 100,      0,                              0 ),
            );

            if( is_user_logged_in() ){            
                define( 'SCM_ROLE', scm_role_name() );
                define( 'SCM_LEVEL', scm_role_level() );
            }else{
                define( 'SCM_ROLE', 'visitatore' );
                define( 'SCM_LEVEL', 100 );
            }

    // ++todo: ADD: if RESET ROLES options is active (o qualcosa del genere)
    
            if( is_admin() && $_GET['page'] == 'scm-options-intro' ) 
                scm_roles_reset();
            else
                return;

    // +++

            foreach ( $SCM_roles as $role => $value) {
                
                if( !is_array( $value ) || get_role( $role ) )
                    continue;
                
                $level = ( isset( $value[0] ) ? $value[0] : 100 );
                $add = ( isset( $value[1] ) ? $value[1] : 0 );
                $cap = ( isset( $value[2] ) ? $value[2] : 0 );
                                
                if( isset( $add ) && $add && is_array( $cap ) ){
                    consoleDebug( 'install role: ' . $role );
                    $arr = array();
                    foreach ( $cap as $cp ){
                        if( $cp )
                            $arr[$cp] = true;
                    }
                    
                    $the_role = add_role(
                        $role,
                        $add,
                        $arr
                    );
                }
            }            
        }
    }

// *** Redirect low cap Users to Home Page when they log in
    
    if ( ! function_exists( 'scm_roles_admin_redirect' ) ) {
        function scm_roles_admin_redirect() {
            if( is_admin() && is_user_logged_in() && ( SCM_DASHBOARD || ( !current_user_can( SCM_ROLE_ENTER ) && !( defined( 'DOING_AJAX' ) && DOING_AJAX ) ) ) ){
                wp_redirect( scm_role_redirect('') );
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

            global $wpdb, $SCM_roles;
            $where = 'WHERE 1=1';

            // Temporarily remove this hook otherwise we might be stuck in an infinite loop
            remove_action( 'pre_user_query', 'scm_roles_allowed_show' );

            if( SCM_LEVEL > 0 ){

                $roles = get_editable_roles();
                $admin_ids = array( 1 );

                foreach ($SCM_roles as $role => $value) {

                    if( !$roles[$role] && SCM_ROLE != $role ){
                        foreach ( get_users( array( 'role' => $role ) ) as $user )
                            $admin_ids[] = $user->id;
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

// *** Add Custom Type Capabilities to Roles

    if ( ! function_exists( 'scm_roles_post_caps' ) ) {
        function scm_roles_post_caps( $type = '', $admin = 0, $cap = 0 ){

            //consoleLog($type);

            global $SCM_roles;

            foreach( $SCM_roles as $role => $value ) {

                $level = scm_role_level( $role );

                if(  ( 0 < $level ) && ( $level < 100 ) ){
                    scm_role_post_caps( $role, $type, $admin, $cap );
                }

            }

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
                if( $key != 'administrator' )
                    remove_role($key);
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
            }elseif ( user_can( ( $user ?: wp_get_current_user() ), SCM_ROLE_USERS ) ) {
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
            
            if( $level === 0 )
                return admin_url('themes.php?page=scm-install-plugins');
            elseif( current_user_can( SCM_ROLE_OPTIONS ) )
                return admin_url('admin.php?page=scm-options-intro');
            elseif( current_user_can( SCM_ROLE_USERS ) )
                return admin_url('users.php');
            
            return home_url();

        }
    }

    if ( ! function_exists( 'scm_role_highest_level' ) ) {
        function scm_role_highest_level( $roles = array() ){
            
            $arr = array();

            foreach ( $roles as $role)
                $arr[] = scm_role_level( $role );

            return min( ( isset($arr) && is_array($arr) && isset($arr[0]) ? $arr : 100) );

        }
    }

    if ( ! function_exists( 'scm_role_highest_name' ) ) {
        function scm_role_highest_name( $roles = array() ){

            $name = '';
            $level = 100;

            foreach ($roles as $role) {
                $lv = scm_role_level( $role );
                if( $lv < $level ){
                    $level = $lv;
                    $name = scm_role_by_level( $lv );
                }
            }

            return $name;

        }
    }

    if ( ! function_exists( 'scm_role_level' ) ) {
        function scm_role_level( $obj = '' ){
            global $SCM_roles;

            // Diventano funzioni getLast() e getFirst()
            end($SCM_roles);

            // -- PHP old
            $current = current($SCM_roles);
            $level = ( $current[0] ?: 100);
            // -- PHP new
            //$level = ( current($SCM_roles)[0] ?: 100);

            reset($SCM_roles);

            // -- PHP old
            $flevel = ( $current[0] ?: 0);
            // -- PHP new
            //$flevel = ( current($SCM_roles)[0] ?: 0);

            if( !isset($obj) || !$obj ){
                if( is_user_logged_in() )
                    $obj = wp_get_current_user();
                else
                    return $level;
            }

            if( is_string( $obj ) ){

                return $SCM_roles[ sanitize_title( $obj ) ][0];

            }elseif( is_array( $obj ) ){

                return scm_role_highest_level( $obj );

            }elseif ( get_class( $obj ) == 'WP_User' ){

                if( $obj->ID === 1 )
                    return $flevel;

                return scm_role_highest_level( $obj->roles );

            }elseif (get_class( $obj ) == 'WP_Role'){

                return $SCM_roles[ $obj->name ][0];

            }

            return $level;
        }
    }

    if ( ! function_exists( 'scm_role_name' ) ) {
        function scm_role_name( $obj = '' ){
            global $SCM_roles;

            end($SCM_roles);
            $role = ( key($SCM_roles) ?: '');
            reset($SCM_roles);
            $frole = ( key($SCM_roles) ?: 'super');

            if( !isset($obj) || !$obj ){
                if( is_user_logged_in() )
                    $obj = wp_get_current_user();
                else
                    return $role;
            }

            if( is_string( $obj ) ){

                return sanitize_title( $obj );

            }elseif( is_array( $obj ) ){

                return scm_role_highest_name( $obj );

            }elseif ( get_class( $obj ) == 'WP_User' ){

                if( $obj->ID === 1 )
                    return $frole;

                return scm_role_highest_name( $obj->roles );

            }elseif (get_class( $obj ) == 'WP_Role'){

                return $obj->name;

            }

            return $role;
        }
    }

    if ( ! function_exists( 'scm_role_by_level' ) ) {
        function scm_role_by_level( $lv = 100 ){
            global $SCM_roles;
            reset($SCM_roles);

            foreach ($SCM_roles as $role => $value) {
                if( $lv === $value[0] )
                    return $role;
            }
            
            return '';
        }
    }
         
    if ( ! function_exists( 'scm_role_post_caps' ) ) {
        function scm_role_post_caps( $role = '', $type = '', $admin = 0, $cap = 0 ){

            if ( !$role || !type )
                return;

            $role = ( is_string( $role ) ? get_role( $role ) : $role );

            $role->remove_cap( 'read_private_' . $type );
            $role->remove_cap( 'edit_' . $type );
            $role->remove_cap( 'edit_private_' . $type );
            $role->remove_cap( 'edit_others_' . $type );
            $role->remove_cap( 'edit_published_' . $type );
            $role->remove_cap( 'publish_' . $type );
            $role->remove_cap( 'delete_' . $type );
            $role->remove_cap( 'delete_others_' . $type );
            $role->remove_cap( 'delete_private_' . $type );
            $role->remove_cap( 'delete_published_' . $type );

            if ( !$role->has_cap( SCM_ROLE_READ ) || ( !$role->has_cap( SCM_ROLE_ADMIN ) && $admin ) )
                return $role;

            $role->add_cap( 'read_private_' . $type );

            if ( !$role->has_cap('read') )
                return $role;

            $role->add_cap( 'edit_' . $type );
            $role->add_cap( 'edit_private_' . $type );
            $role->add_cap( 'edit_others_' . $type );
            $role->add_cap( 'edit_published_' . $type );

            if ( !$role->has_cap( SCM_ROLE_TAX ) || ( $role->has_cap( SCM_ROLE_TAX ) && !$cap ) )
                return $role;

            $role->add_cap( 'publish_' . $type );
            $role->add_cap( 'delete_' . $type );
            $role->add_cap( 'delete_others_' . $type );
            $role->add_cap( 'delete_private_' . $type );
            $role->add_cap( 'delete_published_' . $type );

            return $role;

        }
    }


?>