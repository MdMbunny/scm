<?php

/**
* SCM install roles.
*
* @link http://www.studiocreativo-m.it
*
* @package SCM
* @subpackage 3-Install/Roles
* @since 1.0.0
*/

// ------------------------------------------------------
//
// ACTIONS AND FILTERS
// FUNCTIONS
//
// ------------------------------------------------------

// ------------------------------------------------------
// ACTIONS AND FILTERS
// ------------------------------------------------------

add_action( 'after_setup_theme', 'scm_hook_roles_install' );
add_action( 'scm_action_install_fields_intro-options', 'scm_hook_roles_advanced' );
add_action( 'init', 'scm_hook_roles_admin_redirect' );
add_filter( 'editable_roles', 'scm_hook_roles_allowed_list' );
add_filter( 'map_meta_cap', 'scm_hook_roles_allowed_edit', 10, 4 );
add_action( 'pre_user_query', 'scm_hook_roles_allowed_show' );
add_action( 'scm_action_types_capabilities', 'scm_hook_roles_post_caps', 10, 3 );

// ------------------------------------------------------

/**
* [SET] Install roles
*
* Hooked by 'after_setup_theme'
* @subpackage 3-Install/Roles/HOOKS
*
* @todo 1 - Aggiungi un'opzione per resettare i ruoli quando vuoi, eliminando il reset attuale:
```php
if( is_admin() && isset( $_GET['page'] ) && $_GET['page'] == 'scm-options-intro' ) 
scm_roles_reset();
```
*/
function scm_hook_roles_install() {    

    if( is_user_logged_in() ){
        define( 'SCM_ID', wp_get_current_user()->ID );
        define( 'SCM_ROLE', scm_role_name() );
        define( 'SCM_LEVEL', scm_role_level() );
    }else{
        define( 'SCM_ID', 0 );
        define( 'SCM_ROLE', 'visitatore' );
        define( 'SCM_LEVEL', 100 );
    }

    if( !get_option( 'scm-roles-installed' ) )
        scm_roles_install();

}

function scm_roles_install() {

    $roles_list = scm_roles_reset();

    foreach ( $roles_list as $role => $value) {

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

    foreach ( get_users() as $user ) {
        $color = get_user_option( 'admin_color', $user->ID );
        if( $color != 'default' )
            update_user_option( $user->ID, 'admin_color', 'default' );
    }

    do_action( 'scm_action_install_roles' );

    update_option( 'scm-roles-installed', 1 );

    consoleDebug('roles installed!');
}

/**
* [SET] Define Andvanced Constants
*
* Hooked by 'scm_action_option_pages'
* @subpackage 3-Install/Roles/HOOKS
*/
function scm_hook_roles_advanced() {
    /** Advanced options. */
    define( 'SCM_LEVEL_EDIT',           SCM_LEVEL <= scm_field( 'admin-level-edit', 10, 'option' ) );
    define( 'SCM_LEVEL_ADVANCED',       SCM_LEVEL <= scm_field( 'admin-level-advanced', 0, 'option' ) );
    define( 'SCM_ADVANCED_OPTIONS',     ( SCM_LEVEL_ADVANCED ? 'scm-advanced-options' : 'scm-options' ) );
}

/**
* [SET] Redirect low cap Users to Home Page on log in
*
* Hooked by 'init'
* @subpackage 3-Install/Roles/HOOKS
*/
function scm_hook_roles_admin_redirect() {
    if( is_admin() && is_user_logged_in() && ( SCM_DASHBOARD || ( !current_user_can( SCM_ROLE_ENTER ) && !( defined( 'DOING_AJAX' ) && DOING_AJAX ) ) ) ){
        wp_redirect( scm_role_redirect('') );
        die;
    }
}

/**
* [GET] Role capabilities allowed to list posts
*
* Hooked by 'editable_roles'
* @subpackage 3-Install/Roles/HOOKS
*
* @param {array} roles List of Roles.
* @return {array} Filtered list of allowed roles.
*/
function scm_hook_roles_allowed_list( $roles ) {
    if ( $user = wp_get_current_user() ) {
        $allowed = scm_roles_allowed( $user );
        foreach ( $roles as $role => $caps ) {
            if ( ! in_array( $role, $allowed ) )
                unset( $roles[ $role ] );
        }
    }
    return $roles;
}

/**
* [GET] Role capabilities allowed to edit users
*
* Hooked by 'map_meta_cap'
* @subpackage 3-Install/Roles/HOOKS
*
* @param {array} caps List of capabilities.
* @param {string=} cap Capability [edit_user|delete_user] (default is '').
* @param {int=} user_ID Used ID (default is 0).
* @param {array=} args List of arguments (default is empty array).
* @return {array} Filtered list of capabilities.
*/
function scm_hook_roles_allowed_edit( $caps, $cap = '', $user_ID = 0, $args = array() ) {
    if ( ( $cap === 'edit_user' || $cap === 'delete_user' ) && !empty( $args ) ) {
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

/**
* [SET] Filter users list
*
* Hooked by 'pre_user_query'
* @subpackage 3-Install/Roles/HOOKS
*
* @param {Object} user_search Users query.
*/
function scm_hook_roles_allowed_show( $user_search ) {

    if( is_admin() ){

        global $wpdb;
        $where = 'WHERE 1=1';

        // Temporarily remove this hook otherwise we might be stuck in an infinite loop
        remove_action( 'pre_user_query', 'scm_hook_roles_allowed_show' );

        if( SCM_LEVEL > 0 ){

            //$roles = get_editable_roles();
            $admin_ids = array( 1 );

            foreach ( scm_roles_list() as $role => $value ) {

                //if( !isset($roles[$role]) && SCM_ROLE != $role ){
                if( SCM_ROLE != $role ){
                    foreach ( get_users( array( 'role' => $role ) ) as $user )
                        $admin_ids[] = $user->ID;
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
        add_action( 'pre_user_query', 'scm_hook_roles_allowed_show' );

    }
}

/**
* [SET] Add custom type capabilities to roles
*
* Hooked by 'scm_action_types_capabilities'
* @subpackage 3-Install/Roles/HOOKS
*
* @param {string=} type Custom type slug (default is '').
* @param {boolean=} admin Admin caps (default is false).
* @param {boolean=} cap Extra caps (default is false).
*/
function scm_hook_roles_post_caps( $type = '', $admin = false, $cap = false ){

    foreach( scm_roles_list() as $role => $value ) {

        $level = scm_role_level( $role );

        if(  ( 0 < $level ) && ( $level < 100 ) ){
            scm_role_post_caps( $role, $type, $admin, $cap );
        }
    }
}

// ------------------------------------------------------
// FUNCTIONS
// ------------------------------------------------------

/**
* [GET] SCM roles list
*
* @subpackage 3-Install/Roles/FUNCTIONS
*
* @todo Array restituito da sostituire con uno dinamico, con valori di default (prendi capabilities da costanti SCM_ROLE_)<br>
*       Ci vuole una pagina opzioni dove creare i Ruoli (Super e Visitatore non sono ruoli, Admin esiste già)<br>
*       - Dalle costanti SCM_ROLE_ scegli una cap di default (che attiva pure le sue superiori)<br>
*       - Scegli un livello tra 0 e 100 esclusi<br>
*       - Definisci un nome + slug<br>
*       - Aggiungi capabilities a quelle di default<br>
*       - Quelle di default saranno, per esempio: SCM_ROLE_PRIVATE = 'edit_private_pages', quindi aggiungi anche 'list_users', 'upload_files', ecc.<br>
*
* @return {array} SCM roles list.
*/
function scm_roles_list() {
    return array( 
        'super'         => array( 0,        0,                              1 ),
        'administrator' => array( 10,       0,                              'update_core' ),
        'manager'       => array( 20,       __( 'Manager', SCM_THEME ),     array( 'edit_private_pages', 'edit_private_posts', 'edit_users', 'list_users', 'remove_users', 'delete_users', 'create_users', 'upload_files', 'manage_categories', 'read_private_pages', 'read_private_posts', 'read' ) ),
        'staff'         => array( 30,       __( 'Staff', SCM_THEME ),       array( 'manage_categories', 'list_users', 'edit_users', 'remove_users', 'delete_users', 'create_users', 'upload_files', 'read_private_pages', 'read_private_posts', 'read' ) ),
        'member'        => array( 40,       __( 'Member', SCM_THEME ),      array( 'upload_files', 'list_users', 'read_private_pages', 'read_private_posts', 'read' ) ),
        'utente'        => array( 50,       __( 'User', SCM_THEME ),        array( 'read_private_pages', 'read_private_posts' ) ),
        'iscritto'      => array( 60,       __( 'Subscriber', SCM_THEME ),  array('') ),
        'visitatore'    => array( 100,      0,                              0 ),
    );
}

/**
* [GET] User allowed roles
*
* @subpackage 3-Install/Roles/FUNCTIONS
*
* @param {Object=} user User object (default is current user).
* @return {array} User allowed roles list.
*/
function scm_roles_allowed( $user ) {

    $roles_list = scm_roles_list();
    $level = ( $user ? scm_role_level( $user ) : SCM_LEVEL );
    $allowed = array();

    if ( $level === 0 ) {
        $allowed = array_keys( $GLOBALS['wp_roles']->roles );
    }elseif ( user_can( ( $user ?: wp_get_current_user() ), SCM_ROLE_USERS ) ) {
        foreach ($roles_list as $role => $value) {
            if( scm_role_level( $role ) > $level )
                $allowed[] = $role;
        }
    }

    return $allowed;
}

/**
* [GET] Admin redirect by user roles
*
* @subpackage 3-Install/Roles/FUNCTIONS
*
* @param {Object=} user User object (default is current user).
* @return {string} Redirect admin URL.
*/
function scm_role_redirect( $user ) {

    $level = ( $user ? scm_role_level( $user ) : SCM_LEVEL );

    if( $level === 0 )
        return admin_url('themes.php?page=scm-install-plugins');
    elseif( current_user_can( SCM_ROLE_OPTIONS ) )
        return admin_url('admin.php?page=scm-install-plugins');
    elseif( current_user_can( SCM_ROLE_USERS ) )
        return admin_url('users.php');

    return home_url();
}

/**
* [GET] Highest role level
*
* @subpackage 3-Install/Roles/FUNCTIONS
*
* @param {array=} roles List of roles (default is empty array).
* @return {int} Highest role level.
*/
function scm_role_highest_level( $roles = array() ){
    $arr = array();
    foreach ( $roles as $role)
        $arr[] = scm_role_level( $role );
    return min( !empty( $arr ) ? $arr : 100 );
}

/**
* [GET] Highest role name
*
* @subpackage 3-Install/Roles/FUNCTIONS
*
* @param {array=} roles List of roles (default is empty array).
* @return {string} Highest role name.
*/
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

/**
* [GET] Role level
*
* @subpackage 3-Install/Roles/FUNCTIONS
*
* @todo 1 - Diventano funzioni getLast() e getFirst()
*
* @param {string|array|WP_User|WP_Role} obj Role name | List of roles | User object | Role object.
* @return {int} Role level.
*/
function scm_role_level( $obj = NULL ){
    $roles_list = scm_roles_list();

    // ++todo 1
    end($roles_list);

    // -- PHP old
    $current = current($roles_list);
    $level = ( $current[0] ?: 100);
    // -- PHP new
    //$level = ( current($roles_list)[0] ?: 100);

    reset($roles_list);

    // -- PHP old
    $current = current($roles_list);
    $flevel = ( $current[0] ?: 0);
    // -- PHP new
    //$flevel = ( current($roles_list)[0] ?: 0);

    if( is_null($obj) || !$obj ){
        if( is_user_logged_in() )
            $obj = wp_get_current_user();
        else
            return $level;
    }

    if( is_string( $obj ) ){

        return $roles_list[ sanitize_title( $obj ) ][0];

    }elseif( is_array( $obj ) ){

        return scm_role_highest_level( $obj );

    }elseif ( get_class( $obj ) == 'WP_User' ){

        if( $obj->ID === 1 )
            return $flevel;

        return scm_role_highest_level( $obj->roles );

    }elseif (get_class( $obj ) == 'WP_Role'){

        return $roles_list[ $obj->name ][0];

    }
    return $level;
}

/**
* [GET] Role name
*
* @subpackage 3-Install/Roles/FUNCTIONS
*
* @param {string|array|WP_User|WP_Role} obj Role name | List of roles | User object | Role object.
* @return {string} Role name.
*/
function scm_role_name( $obj = '' ){

    $roles_list = scm_roles_list();

    end($roles_list);
    $role = ( key($roles_list) ?: '');
    reset($roles_list);
    $frole = ( key($roles_list) ?: 'super');

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

/**
* [GET] Role by level
*
* @subpackage 3-Install/Roles/FUNCTIONS
*
* @param {int=} lv Level (default is 100).
* @return {string} Role name.
*/
function scm_role_by_level( $lv = 100 ){

    $roles_list = scm_roles_list();
    reset($roles_list);

    foreach ($roles_list as $role => $value) {
        if( $lv === $value[0] )
            return $role;
    }
    return '';
}

/**
* [SET] Remove every role
*
* @subpackage 3-Install/Roles/FUNCTIONS
*/
function scm_roles_reset() {

    consoleDebug( 'reset roles' );

    $roles_list = scm_roles_list();

    remove_role('editor');
    remove_role('author');
    remove_role('contributor');
    remove_role('subscriber');
    foreach ( $roles_list as $key => $value) {
        if( $key != 'administrator' )
            remove_role($key);
    }
    return $roles_list;
}

/**
* [SET] Add post type capabilities to role
*
* @subpackage 3-Install/Roles/FUNCTIONS
*
* @param {string} role Role name.
* @param {string} type Custom type slug.
* @param {boolean=} admin Admin caps (default is false).
* @param {boolean=} cap Extra caps (default is false).
*/
function scm_role_post_caps( $role = NULL, $type = NULL, $adm = false, $cap = false ){

    if ( is_null( $role ) || !$role || is_null( $type ) || !$type ) return;

    $name = ( is_string( $role ) ? ( $role=='super' ? 'administrator' : $role ) : '' );
    $role = ( is_string( $role ) ? get_role( $name ) : $role );

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

    $admin = $name == 'administrator';
    $iscritto = $name == 'iscritto';
    $utente = $name == 'utente';
    $member = $name == 'member';
    $staff = $name == 'staff';
    $manager = $name == 'manager';
    
    if( $iscritto || ( !$admin && !$manager && !$staff && $adm ) )
        return $role;
    
    $role->add_cap( 'read_private_' . $type );

    if( $utente || ( !$admin && !$manager && $adm ) )
        return $role;

    $role->add_cap( 'edit_' . $type );
    $role->add_cap( 'edit_published_' . $type );

    if( $member )
        return $role;

    $role->add_cap( 'edit_private_' . $type );
    $role->add_cap( 'edit_others_' . $type );

    if( !$admin && $adm && !$cap )
        return $role;

    $role->add_cap( 'publish_' . $type );
    $role->add_cap( 'delete_' . $type );
    $role->add_cap( 'delete_others_' . $type );
    $role->add_cap( 'delete_private_' . $type );
    $role->add_cap( 'delete_published_' . $type );

    return $role;
}

?>