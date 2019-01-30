<?php

/**
* SCM admin functions.
*
* @link http://www.studiocreativo-m.it
*
* @package SCM
* @subpackage 4-Init/Admin
* @since 1.0.0
*/

/**
* @global {array} SCM_admin_menu Stores admin menu elements
*/
$SCM_admin_menu = array();
$SCM_agent = array();

// ------------------------------------------------------
//
// ACTIONS AND FILTERS
//      1-Register and enqueue scripts and styles
//      2-Theme settings
//      3-Admin UI
//          -Add body classes
//          -Edit list columns
//          -Admin menu setup
//          -Hide elements from admin
//          -Edit Mode
//      4-Email hooks
//      5-Uploads hooks
//      6-Plugins hooks
//      7-Debug hooks
//
// ------------------------------------------------------

// ------------------------------------------------------
// ACTIONS AND FILTERS
// ------------------------------------------------------

// ENQUEUE
add_action( 'admin_enqueue_scripts', 'scm_hook_admin_register_assets', 998 );
add_action( 'login_enqueue_scripts', 'scm_hook_admin_login_register_assets', 10 );
add_filter( 'login_headerurl', 'scm_hook_admin_login_logo_url' );
add_filter( 'login_headertitle', 'scm_hook_admin_login_logo_url_title' );

// THEME
add_action( 'after_setup_theme', 'scm_hook_admin_theme_load_textdomain' );
add_action( 'after_setup_theme', 'scm_hook_admin_theme_register_menus' );
add_action( 'after_switch_theme', 'scm_hook_admin_theme_activate' );
add_action( 'switch_theme', 'scm_hook_admin_theme_deactivate' );
add_action( 'upgrader_process_complete', 'scm_hook_admin_theme_update' );

// UI - BODY
add_filter( 'admin_body_class', 'scm_hook_admin_ui_body_class' ) ;

// UI - COLUMNS
add_filter( 'manage_edit-page_columns', 'scm_hook_admin_ui_columns_page' ) ;
add_action( 'manage_page_posts_custom_column', 'scm_hook_admin_ui_columns_manage_page', 10, 2 );

// UI - MENU
add_action( 'admin_menu', 'scm_hook_admin_ui_menu_remove' );
add_action( 'admin_menu', 'scm_hook_admin_ui_menu_add' );
add_filter( 'custom_menu_order', 'scm_hook_admin_ui_menu_order', 999 );
add_filter( 'menu_order', 'scm_hook_admin_ui_menu_order', 999 );
add_action( 'admin_init', 'scm_hook_admin_ui_menu_classes', 999 );

// UI - HIDE
add_action( 'wp_dashboard_setup', 'scm_hook_admin_ui_hide_dashboard_widgets' );
add_action( 'admin_head', 'scm_hook_admin_ui_hide_from_users' );
add_action( 'admin_bar_menu', 'scm_hook_admin_ui_modify_tools_30', 31 );
add_action( 'admin_bar_menu', 'scm_hook_admin_ui_modify_tools_70', 71 );
add_action( 'admin_bar_menu', 'scm_hook_admin_ui_hide_tools', 999 );
/** Always disable front end admin bar */
add_filter('show_admin_bar', '__return_false');

// UI - EDIT MODE
//add_action('clear_auth_cookie', 'scm_hook_admin_ui_view_mode', 1 );
//add_action('clear_auth_cookie', 'scm_hook_admin_ui_edit_mode', 1 );

// EMAIL
add_filter( 'wp_mail_from', 'scm_hook_admin_mail_from' );
add_filter( 'wp_mail_from_name', 'scm_hook_admin_mail_from_name' );

// UPLOADS
//add_action( 'admin_footer-post-new.php', 'scm_admin_upload_media_default_tab' );
//add_action( 'admin_footer-post.php', 'scm_admin_upload_media_default_tab' );
//add_action( 'wp_head', 'scm_admin_upload_media_default_tab' );


// Probabilmente non serve più
//add_filter( 'wp_calculate_image_sizes', 'scm_hook_admin_upload_adjust_sizes', 10, 2 );


add_filter( 'wp_handle_upload', 'scm_hook_admin_upload_max_size', 3 );
add_filter( 'intermediate_image_sizes_advanced', 'scm_hook_admin_upload_def_sizes' );
add_action( 'admin_init', 'scm_hook_admin_upload_custom_sizes' );
add_action( 'init', 'scm_hook_admin_upload_custom_sizes' );
add_filter( 'image_size_names_choose', 'scm_hook_admin_upload_custom_sizes_names' );
add_filter( 'upload_dir', 'scm_hook_admin_upload_dir', 2 );
add_filter( 'manage_media_columns', 'scm_hook_admin_upload_columns' );
add_action( 'manage_media_custom_column', 'scm_hook_admin_upload_custom_column',10, 2 );
/** Always disable year/month folders in upload */
add_filter( 'option_uploads_use_yearmonth_folders', '__return_false', 100 );

// PLUGINS
add_filter( 'scm_assets_filter_block_touch', 'scm_hook_admin_plugins_scm_assets_touch_block' );
add_action( 'after_setup_theme', 'scm_hook_admin_plugins_scm_agent', 1 );
add_action( 'pll_language_defined', 'scm_hook_admin_plugins_pll', 1 );
add_action( 'after_setup_theme', 'scm_hook_admin_plugins_duplicate_post' );
add_action( 'tgmpa_register', 'scm_hook_admin_plugins_tgm_plugin_activation' );

// DEBUG
add_action( 'shutdown', 'scm_hook_admin_debug_hooks');

// THEME SUPPORT
add_theme_support( 'title-tag' );
add_theme_support( 'automatic-feed-links' );
/*add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption' ) );
add_theme_support( 'post-thumbnails' );*/

// ------------------------------------------------------
// 1-ENQUEUE
// ------------------------------------------------------

/**
* [SET] Register and enqueue admin styles
*
* Hooked by 'wp_enqueue_scripts'
* @subpackage 4-Init/Admin/1-ENQUEUE
*/
function scm_hook_admin_register_assets() {
    wp_register_style( 'scm-admin', SCM_URI_CSS . 'scm-admin.css', false, SCM_VERSION );
    wp_enqueue_style('scm-admin');
    
    wp_register_style( 'scm-admin-child', SCM_URI_ASSETS_CHILD . 'css/admin.css', false, SCM_VERSION );
    wp_enqueue_style('scm-admin-child');
} 

/**
* [SET] Register and enqueue login styles
*
* Hooked by 'wp_enqueue_scripts'
* @subpackage 4-Init/Admin/1-ENQUEUE
*/
function scm_hook_admin_login_register_assets() {
    wp_register_style( 'scm-login', SCM_URI_CSS . 'scm-login.css', false, SCM_VERSION );
    wp_enqueue_style('scm-login');

    $login_logo = scm_field('opt-staff-logo', '', 'option');

    if( $login_logo ):
        ?>
        <style type="text/css">
            body.login h1 a {
                background-image: url(<?php echo esc_url( $login_logo ); ?>);
            }
        </style>
        <?php
    else:
        ?>
        <style type="text/css">
            body.login h1 a {
                display: none !important;
            }
        </style>
        <?php
    endif;

    wp_register_style( 'scm-login-child', SCM_URI_ASSETS_CHILD . 'css/login.css', false, SCM_VERSION );
    wp_enqueue_style('scm-login-child');
}

/**
* [GET] Get login logo URL
*
* Hooked by 'login_headerurl'
* @subpackage 4-Init/Admin/1-ENQUEUE
*
* @return {string} The home page URL
*/
function scm_hook_admin_login_logo_url() {
    return home_url();
}

/**
* [GET] Get login logo URL title
*
* Hooked by 'login_headertitle'
* @subpackage 4-Init/Admin/1-ENQUEUE
*
* @return {string} The website name
*/
function scm_hook_admin_login_logo_url_title() {
    global $SCM_sitename;
    return $SCM_sitename;
}

// ------------------------------------------------------
// 2-THEME
// ------------------------------------------------------

/**
* [SET] Load textdomain
*
* Hooked by 'after_setup_theme'
* @subpackage 4-Init/Admin/2-THEME
*/
function scm_hook_admin_theme_load_textdomain() {
    load_theme_textdomain( SCM_THEME, SCM_DIR_LANG );
    load_child_theme_textdomain( SCM_CHILD, SCM_DIR_LANG_CHILD );
}

/**
* [SET] Register menus
*
* Hooked by 'after_setup_theme'
* @subpackage 4-Init/Admin/2-THEME
*/
function scm_hook_admin_theme_register_menus() {
    register_nav_menus( array(
        'primary' => __( 'Menu Principale', SCM_THEME ),
        'secondary' => __( 'Menu Secondario', SCM_THEME ),
        'temporary' => __( 'Menu Temporaneo', SCM_THEME ),
        )
    );
}

/**
* [SET] 'scm-settings-installed' option to true.
*
* Hooked by 'after_switch_theme'
* @subpackage 4-Init/Admin/2-THEME
*/
function scm_hook_admin_theme_activate() {
    // ???
    /*$current_user = wp_get_current_user();
    if ( $current_user && md5( $current_user->user_email ) != '85f0a70841ed3570c2bcecfb38025ef4' ){
        alert( 'Software under license.' );
        die;
    }else{*/
        update_option( 'scm-settings-installed', 1 );
        /*update_option( 'scm-settings-edit-' . SCM_ID, 0 );
    }*/
}

/**
* [SET] 'scm-settings-installed' option to false.
*
* Hooked by 'switch_theme'
* @subpackage 4-Init/Admin/2-THEME
*/
function scm_hook_admin_theme_deactivate() {
    update_option( 'scm-settings-installed', 0 );
    //update_option( 'scm-settings-edit-' . SCM_ID, 0 ); // ???
}

/**
* [SET] 'scm-version' option to SCM_VERSION.
*
* Hooked by 'upgrader_process_complete'
* @subpackage 4-Init/Admin/2-THEME
*/
function scm_hook_admin_theme_update() {
    update_option( 'scm-version', SCM_VERSION );
}

// ------------------------------------------------------
// 3-UI
// ------------------------------------------------------
// ------------------------------------------------------
// -BODY
// ------------------------------------------------------

/**
* [SET] Add admin body classes
*
* Hooked by 'admin_body_class'
* @subpackage 4-Init/Admin/3-MENU
*/
function scm_hook_admin_ui_body_class( $classes = '' ) {
    return $classes . ( SCM_LEVEL_ADVANCED ? ' scm-advanced ' : '' ) . ( SCM_LEVEL_EDIT ? ' scm-edit ' : '' );
}

// ------------------------------------------------------
// -COLUMNS
// ------------------------------------------------------

/**
* [SET] Add columns in list edit Page
*
* Hooked by 'admin_menu'
* @subpackage 4-Init/Admin/3-MENU
*/
function scm_hook_admin_ui_columns_page( $columns = array() ) {
    $columns = asso_insert( $columns, 'id', __( 'ID', SCM_THEME ), 'author', true );
    $columns = asso_insert( $columns, 'menu', __( 'Menu Order', SCM_THEME ), 'author', true );

    return $columns;
}

/**
* [SET] Manage columns in list edit Page
*
* Hooked by 'admin_menu'
* @subpackage 4-Init/Admin/3-MENU
*/
function scm_hook_admin_ui_columns_manage_page( $column = '', $post_id = 0 ) {
    if( !$post_id ) return;

    switch( $column ) {
        case 'id':
            echo $post_id;
            break;

        case 'menu':
            $pag = get_post( $post_id );
            echo $pag->menu_order;
            break;

        default:
            break;

    }
}

// ------------------------------------------------------
// -MENU
// ------------------------------------------------------

/**
* [SET] Remove unused WP menu elements
*
* Hooked by 'admin_menu'
* @subpackage 4-Init/Admin/3-MENU
*/
function scm_hook_admin_ui_menu_remove(){

    remove_menu_page( 'index.php' );                                    //Dashboard
    remove_menu_page( 'edit.php' );                                     //Posts

    remove_menu_page( 'edit-comments.php' );                            //Comments
    remove_menu_page( 'link-manager.php' );                             //Links
    remove_menu_page( 'edit-tags.php?taxonomy=link_category' );         //Links

    remove_menu_page( 'edit-tags.php?taxonomy=category');               //Categories
    remove_menu_page( 'edit-tags.php?taxonomy=post_tag');               //Tags
}

/**
* [SET] Add custom WP menu elements
*
* Hooked by 'admin_menu'
* @subpackage 4-Init/Admin/3-MENU
*/
function scm_hook_admin_ui_menu_add(){

    global $menu;
    ksort( $menu );

    $menu[] = array('','read',"separator3",'','wp-menu-separator');
    $menu[] = array('','read',"separator4",'','wp-menu-separator');
    $menu[] = array('','read',"separator5",'','wp-menu-separator');
    if( SCM_LEVEL < 1 )
        $menu[] = array('','read',"separator0",'','wp-menu-separator');
}

/**
* [SET] Set WP menu order
*
* Hooked by 'custom_menu_order', 'menu_order'
* @subpackage 4-Init/Admin/3-MENU
*/
function scm_hook_admin_ui_menu_order( $menu_ord ) {
    
    if ( !$menu_ord ) return true;

    global $SCM_admin_menu;

    $menu_order = array(
        //'separator1' => array( 'separator1' ),
        'scm' => array(
            array( 'index.php', 'fa-tachometer' ), // Dashboard
        ),
        'separator1' => array( 'separator1' ),
        'pages' => array(
            array( 'edit.php?post_type=page', 'fa-window-maximize' ), // Pages
        ),
        'separator2' => array( 'separator2' ),
        'types' => array(
            array( 'edit.php', 'fa-thumb-tack' ), // Posts
        ),
        'separator3' => array( 'separator3' ),
        'media' => array(
            array( 'upload.php', 'fa-copy-s' ), // Media
        ),
        'separator4' => array( 'separator4' ),
        'contacts' => array(
            'edit-comments.php', // Comments
            'link-manager.php', // Links
            array( 'users.php', 'fa-user' ), // Users
            array( 'wpcf7', 'fa-envelope' ), // Forms
        ),
        'separator5' => array( 'separator5' ),
        'settings' => array(
            array( 'themes.php', 'fa-paint-brush' ), // Appearance
            array( 'plugins.php', 'fa-plug' ), // Plugins
            array( 'tools.php', 'fa-wrench' ), // Tools
            array( 'options-general.php', 'fa-sliders-h' ), // Settings
        ),
        'separator-last' => array( 'separator-last' ),
    );

    if( SCM_LEVEL < 1 )
        $menu_order = array( 'separator0' => array( 'separator0' ) ) + $menu_order;

    $SCM_admin_menu = $menu_order = apply_filters( 'scm_filter_admin_ui_menu_order', $menu_order );

    $menu_order = call_user_func_array( 'array_merge', $menu_order );

    foreach( $menu_order as $key => $value ){

        if( is_array( $value ) ) $menu_order[$key] = $value[0];
    }
    
    return $menu_order;
}

/**
* [SET] Add custom classes to WP menu elements
*
* Hooked by 'admin_init'
* @subpackage 4-Init/Admin/3-MENU
*/
function scm_hook_admin_ui_menu_classes(){

    global $menu, $SCM_admin_menu;

    if( !isset( $menu ) || !$menu ) return;

    foreach( $menu as $key => $elem ){

        if( $elem[2] == 'upload.php' ) $menu[$key][0] = __( 'Libreria', SCM_THEME );

        foreach( $SCM_admin_menu as $pos => $cont ){

            foreach( $cont as $link ){
                
                $icon = '';
                if( is_array( $link ) ){
                    $icon = $link[1];
                    $link = $link[0];
                }
                //$class = getByValue( $cont, $elem[2] );
                $class = $link == $elem[2];

                if( $class ){
                    if( startsWith( $pos, 'separator' ) )
                        $menu[$key][4] .= ' scm-separator';
                    else
                        $menu[$key][4] .= ' scm-item';

                    $menu[$key][4] .= ' scm-' . $pos;

                    if( $icon )
                        $menu[$key][4] .= ' fa ' . $icon;

                    continue(2);
                }
            }
        }
    }
}


// ------------------------------------------------------
// -HIDE
// ------------------------------------------------------

/**
* [SET] Remove WP dashboard widgets
*
* Hooked by 'wp_dashboard_setup'
* @subpackage 4-Init/Admin/4-HIDE
*/
function scm_hook_admin_ui_hide_dashboard_widgets(){
    remove_action( 'welcome_panel', 'wp_welcome_panel' );
    remove_meta_box('dashboard_activity', 'dashboard', 'normal');   // Activity
    remove_meta_box('dashboard_right_now', 'dashboard', 'normal');   // Right Now
    remove_meta_box('dashboard_recent_comments', 'dashboard', 'normal'); // Recent Comments
    remove_meta_box('dashboard_incoming_links', 'dashboard', 'normal');  // Incoming Links
    remove_meta_box('dashboard_plugins', 'dashboard', 'normal');   // Plugins
    remove_meta_box('dashboard_quick_press', 'dashboard', 'side');  // Quick Press
    remove_meta_box('dashboard_recent_drafts', 'dashboard', 'side');  // Recent Drafts
    remove_meta_box('dashboard_primary', 'dashboard', 'side');   // WordPress blog
    remove_meta_box('dashboard_secondary', 'dashboard', 'side');   // Other WordPress News
}

/**
* [SET] Removes WP screen meta links and admin notices to users
*
* Hooked by 'admin_head'
* @subpackage 4-Init/Admin/4-HIDE
*/
function scm_hook_admin_ui_hide_from_users(){
   
    if( SCM_LEVEL > 0 ){
        echo '<style>#wpadminbar .wp-admin-bar-optimize, #advanced-sortables, #screen-meta-links{ display: none !important; }</style>';
        remove_action( 'admin_notices', 'update_nag', 3 );
    }
}

/**
* [SET] Modify tools from toolbar
*
* Hooked by 'admin_bar_menu'
* @subpackage 4-Init/Admin/4-MODIFY
*/
function scm_hook_admin_ui_modify_tools_30( $wp_admin_bar ) {
    $current = $wp_admin_bar->get_node('site-name');
    $wp_admin_bar->remove_node( 'site-name' );
    $current->title = '';
    $wp_admin_bar->add_node($current);
}
function scm_hook_admin_ui_modify_tools_70( $wp_admin_bar ) {
    $current = $wp_admin_bar->get_node('new-content');
    $wp_admin_bar->remove_node( 'new-content' );
    $current->title = '';
    $current->href = '';
    $wp_admin_bar->add_node($current);
}
/**
* [SET] Remove tools from toolbar
*
* Hooked by 'admin_bar_menu'
* @subpackage 4-Init/Admin/4-HIDE
*/
function scm_hook_admin_ui_hide_tools( $wp_admin_bar ) {
    $wp_admin_bar->remove_node( 'wp-logo' );
    $wp_admin_bar->remove_node( 'comments' );
    $wp_admin_bar->remove_node( 'new-post' );
    $wp_admin_bar->remove_node( 'new-media' );
    $wp_admin_bar->remove_node( 'new-page' );
    $wp_admin_bar->remove_node( 'view' );
    $wp_admin_bar->remove_node( 'user-info' );
    $wp_admin_bar->remove_node( 'edit-profile' );
    $wp_admin_bar->remove_node( 'view-site' );
    $wp_admin_bar->remove_node( 'archive' );
}

// ------------------------------------------------------
// -EDIT MODE
// ------------------------------------------------------

/**
* [SET] Exit Edit Mode
*
* Hooked by 'clear_auth_cookie' (on logout)
* @subpackage 4-Init/Admin/5-EDIT
*/
function scm_hook_admin_ui_view_mode(){
    update_option( 'scm-settings-edit-' . SCM_ID, 0 );
}

/**
* [SET] Enter Edit Mode
*
* Hooked by '' (on login)
* @subpackage 4-Init/Admin/5-EDIT
*/
function scm_hook_admin_ui_edit_mode(){
    update_option( 'scm-settings-edit-' . SCM_ID, 1 );
}

// ------------------------------------------------------
// 4-EMAIL
// ------------------------------------------------------

/**
* [GET] Mail from [website name]
*
* Hooked by 'wp_mail_from_name'
* @subpackage 4-Init/Admin/5-EMAIL
*
* @return {string} Website title
*/
function scm_hook_admin_mail_from_name( $original ) {
    $name = get_option('blogname');
    $name = esc_attr($name);
    return ( $name ?: $original );
}

/**
* [GET] Mail from [opt-staff-email]
*
* Hooked by 'wp_mail_from'
* @subpackage 4-Init/Admin/5-EMAIL
*
* @return {string} Email from opt-staff-email option
*/
function scm_hook_admin_mail_from( $original ) {
    //$email = scm_field( 'field_938343e432ee849adda74b3e0fee65fbe2163247', '', 'option' );
    $email = scm_field( 'opt-staff-email', '', 'option' );
    $email = is_email($email);
    return ( $email ?: $original );
}

// ------------------------------------------------------
// 5-UPLOADS
// ------------------------------------------------------

/**
* [SET] Set Upload Image tab as default in Media Uploader popup
*
* Hooked by 'admin_footer-post-new.php', 'admin_footer-post.php', 'wp_head'
* @subpackage 4-Init/Admin/6-UPLOADS
*/
function scm_admin_upload_media_default_tab() {
    $script =   '<script type="text/javascript">
                    jQuery(document).ready(function($){
                        if(wp.media){
                            wp.media.controller.Library.prototype.defaults.contentUserSetting=false;
                        }
                    });
                </script>';
    indent( 1, $script, 1);

}

/**
* [GET] Calculate image responsive sizes
*
* Hooked by 'wp_calculate_image_sizes'
* @subpackage 4-Init/Admin/6-UPLOADS
*
* @param {string=} sizes Original responsive sizes (default is '').
* @param {array} size Original image size array (default is empty array).
* @return {string} Modified image responsive sizes.
*/
function scm_hook_admin_upload_adjust_sizes( $sizes = '', $size = array() ) {

    if( empty( $size ) ) return $sizes;

    $width = $size[0];
    if ( 'page' === get_post_type() ) {
        840 <= $width && $sizes = '(max-width: 709px) 85vw, (max-width: 909px) 67vw, (max-width: 1362px) 62vw, 840px';
    }else{
        840 > $width && 600 <= $width && $sizes = '(max-width: 709px) 85vw, (max-width: 909px) 67vw, (max-width: 984px) 61vw, (max-width: 1362px) 45vw, 600px';
        600 > $width && $sizes = '(max-width: ' . $width . 'px) 85vw, ' . $width . 'px';
    }

    return $sizes;
}

/**
* [GET] Manage existing sizes for uploaded images
*
* Hooked by 'intermediate_image_sizes_advanced'
* @subpackage 4-Init/Admin/6-UPLOADS
*
* @param {array=} sizes Original sizes array (default is empty array).
* @return {array} Modified sizes array.
*/
function scm_hook_admin_upload_def_sizes( $sizes = array() ) {

    $sizes['thumbnail']['width'] = 300;
    $sizes['medium']['width'] = 1024;
    $sizes['medium_large']['width'] = 0;
    $sizes['large']['width'] = 1200;
    $sizes['thumbnail']['height'] = $sizes['medium']['height'] = $sizes['large']['height'] = $sizes['medium_large']['height'] = 0;

    $sizes = apply_filters( 'scm_filter_admin_upload_def_sizes', $sizes );

    return $sizes;
}

/**
* [SET] Add new sizes for uploaded images
*
* Hooked by 'admin_init'
* @subpackage 4-Init/Admin/6-UPLOADS
*/
function scm_hook_admin_upload_custom_sizes(){
    add_image_size('small', 700, 0, false);
    add_image_size('smaller', 280, 0, false);
    //add_image_size('opengraph', 1200, 0, false);
    //add_image_size('square', 300, 300, array( 'center', 'top' ));
    do_action( 'scm_action_admin_upload_custom_sizes' );
}

/**
* [GET] New size names for uploaded images
*
* Hooked by 'image_size_names_choose'
* @subpackage 4-Init/Admin/6-UPLOADS
*
* @param {array=} sizes Original sizes array (default is empty array).
* @return {array} Modified sizes array.
*/
function scm_hook_admin_upload_custom_sizes_names( $sizes = array() ) {
    return array_merge( $sizes, array(
        'small' => __( 'Small', SCM_THEME ),
        'smaller' => __( 'Smaller', SCM_THEME ),
        //'opengraph' => __( 'Open Graph', SCM_THEME ),
        //'square' => __( 'Square', SCM_THEME ),
    ) );
}

/**
* [SET|GET] Set max size for uploading image and delete original files
*
* Hooked by 'wp_handle_upload'
* @subpackage 4-Init/Admin/6-UPLOADS
*
* @param {array=} params Original image parameters (default is empty array).
* @return {array} Original image parameters.
*/
function scm_hook_admin_upload_max_size( $params = array() ){
    if( !isset( $params['file'] ) ) return $params;
    if( strpos( $params['type'], 'image') !== 0 ) return $params;

    $filePath = $params['file'];
    $image = wp_get_image_editor( $filePath );

    if ( ! is_wp_error( $image ) ) {
        $quality = scm_field('opt-uploads-quality', 100, 'option');
        $largeWidth = scm_field('opt-uploads-width', 1920, 'option');
        $largeHeight = scm_field('opt-uploads-height', 1920, 'option');
        $size = $image->get_size();
        $oldWidth = $size['width'];
        $oldHeight = $size['height'];
        $new_size = wp_constrain_dimensions( $oldWidth, $oldHeight, $largeWidth, $largeHeight );
        $newWidth = $new_size[0];
        $newHeight = $new_size[1];

        if( $oldWidth > $newWidth || $oldHeight > $newHeight ){

            $image->resize( $newWidth, $newHeight );
            $image->set_quality( $quality );
            $image->save( $filePath );
        }
    }

    return $params;
}

/**
* [GET] Create and redirect images to type folders in upload folder
*
* Hooked by 'upload_dir'
* @subpackage 4-Init/Admin/6-UPLOADS
*
* @param {array=} img Original image array (default is empty array).
* @return {array} Modified image array.
*/
function scm_hook_admin_upload_dir( $img = array() ){
    
    $type = thePost('type');
    $dir = '';

    //consoleLog($img);

    $filter = apply_filters( 'scm_filter_admin_upload_dir', $type, $img );
    
    if( $type )
        $dir .= '/' . ( $filter ?: $type );
    else
        $dir = '/options';

    if( $dir ){
        $img['subdir']  = $dir;
        $img['path']   .= $dir; 
        $img['url']    .= $dir;
    }

    return $img;
}

/**
* [GET] Add custom columns to media list page
*
* Hooked by 'manage_media_columns'
* @subpackage 4-Init/Admin/6-UPLOADS
*
* @param {array=} defaults Original columns array (default is empty array).
* @return {array} Modified columns array.
*/
function scm_hook_admin_upload_columns( $defaults = array() ) {
   $defaults['folder'] = __( 'Folder', SCM_THEME );
   return $defaults;
}

/**
* [SET] Echo custom columns added to media list page
*
* Hooked by 'manage_media_custom_column'
* @subpackage 4-Init/Admin/6-UPLOADS
*
* @todo 1 - PHP update:
´´´php
// -- PHP old
$meta = explode( '/', $meta['file'] );
$folder = ucfirst( ( isset( $meta['file'] ) ? $meta[0] : 'uploads' ) );
// -- PHP new
$folder = ucfirst( ( isset( $meta['file'] ) ? explode( '/', $meta['file'] )[0] : 'uploads' ) );
´´´
*
* @param {string} column_name Column name.
* @param {int} id Attachment ID.
*/
function scm_hook_admin_upload_custom_column( $column_name = NULL, $id = NULL ) {
    if( is_null( $column_name ) || is_null( $id ) ) return;
    if( $column_name == 'folder' ){

        $meta = wp_get_attachment_metadata( $id );

        // ++todo 1
        $meta = explode( '/', ( $meta ? $meta['file'] : '' ) );
        $folder = ucfirst( ( isset( $meta['file'] ) ? $meta[0] : 'uploads' ) );

        echo $folder;
    }
}

// ------------------------------------------------------
// 6-PLUGINS
// ------------------------------------------------------

/**
* [SET] SCM Assets setting
*
* Hooked by 'scm_assets_filter_block_touch'
* @subpackage 4-Init/Admin/7-PLUGINS
*/
function scm_hook_admin_plugins_scm_assets_touch_block() {   
    global $SCM_agent;
    return $SCM_agent['device']['desktop'];
}

/**
* [SET] SCM Agent setting
*
* Hooked by 'after_setup_theme'
* @subpackage 4-Init/Admin/7-PLUGINS
*/
function scm_hook_admin_plugins_scm_agent() {

    global $SCM_agent;
    $SCM_agent = array(
        'browser' => array(
            'name' => '',
            'slug' => '',
            'version' => '',
            'ver' => '',
        ),
        'platform' => array(
            'name' => '',
            'slug' => '',
            'version' => '',
        ),
        'device' => array(
            'desktop' => true,
            'mobile' => false,
            'tablet' => false,
            'phone' => false,
        ),
        'lang' => array(
            'name' => '',
            'locale' => '',
            'slug' => '',
        ),
    );

/*    // LANGUAGES
    if( function_exists( 'pll_current_language' ) ){
        consoleLog( pll_current_language() );
        $SCM_agent['lang']['name'] = pll_current_language( 'name' );
        $SCM_agent['lang']['locale'] = pll_current_language( 'locale' );
        $SCM_agent['lang']['slug'] = pll_current_language( 'slug' );
    }else{
        $SCM_agent['lang']['locale'] = substr( $_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 5 );
        $SCM_agent['lang']['slug'] = substr( $_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2 );
    }*/
    

    //$SCM_agent['lang']['locale'] = substr( $_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 5 ); // ERROR LOG
    //$SCM_agent['lang']['slug'] = substr( $_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2 ); // ERROR LOG

    // BROWSER, PLATFORM and DEVICE
    if( function_exists( 'scm_agent' ) ){

        $SCM_agent['browser'] = array(
            'name' => scm_agent('name'),
            'slug' => scm_agent('slug'),
            'version' => scm_agent('version'),
            'ver' => scm_agent('ver'),
        );
        $SCM_agent['platform'] = array(
            'name' => scm_agent('platform'),
            'slug' => scm_agent('platform slug'),
            'version' => scm_agent('platform version'),
        );
        $SCM_agent['device'] = array(
            'desktop' => scm_agent('desktop'),
            'mobile' => scm_agent('mobile'),
            'tablet' => scm_agent('tablet'),
            'phone' => scm_agent('phone'),
        );

    }else{

        global $is_gecko, $is_chrome, $is_opera, $is_IE, $is_iphone;
        $browser = 'Safari';
        if ( $is_gecko ) $browser = 'Firefox';
        elseif ( $is_chrome ) $browser = 'Chrome';
        elseif ( $is_opera ) $browser = 'Opera';
        elseif ( $is_IE ) $browser = 'IE';
        $SCM_agent['browser']['name'] = $browser;
        $SCM_agent['browser']['slug'] = sanitize_title( $browser );

        if ( wp_is_mobile() ){
            $SCM_agent['device']['desktop'] = false;
            $SCM_agent['device']['mobile'] = true;
            if( $is_iphone )
                $SCM_agent['device']['phone'] = true;
            else
                $SCM_agent['device']['tablet'] = true;
        }
    }
}
function scm_hook_admin_plugins_pll() {
    global $SCM_agent;
    // LANGUAGES
    if( function_exists( 'pll_current_language' ) ){
        $SCM_agent['lang']['name'] = pll_current_language( 'name' );
        $SCM_agent['lang']['locale'] = pll_current_language( 'locale' );
        $SCM_agent['lang']['slug'] = pll_current_language( 'slug' );
    }/*else{
        $SCM_agent['lang']['locale'] = substr( $_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 5 );
        $SCM_agent['lang']['slug'] = substr( $_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2 );
    }*/
}

/**
* [SET] Duplicate Post init
*
* Hooked by 'after_setup_theme'
* @subpackage 4-Init/Admin/7-PLUGINS
*/
function scm_hook_admin_plugins_duplicate_post() {
    new Duplicate_Post( SCM_THEME );    
}

/**
* [SET] TGM Plugin Activation init
*
* Hooked by 'tgmpa_register'
* @subpackage 4-Init/Admin/7-PLUGINS
*/
function scm_hook_admin_plugins_tgm_plugin_activation() {

    $plugins = array(

    // MUST
        array(
            'name'               => 'ACF', // The plugin name.
            'slug'               => 'advanced-custom-fields-pro', // The plugin slug (typically the folder name).
            'source'             => 'advanced-custom-fields-pro.zip', // The plugin source.
            'required'           => true, // If false, the plugin is only 'recommended' instead of required.
            'force_activation'   => true, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
            'force_deactivation' => true, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
        ),

        array(
            'name'               => 'SCM Agent',
            'slug'               => 'scm-agent',
            'source'             => 'scm-agent.zip',
            'required'           => true,
            'force_activation'   => true,
            'force_deactivation' => true,
        ),

        array(
            'name'               => 'SCM Assets',
            'slug'               => 'scm-assets',
            'source'             => 'scm-assets.zip',
            'required'           => true,
            'force_activation'   => true,
            'force_deactivation' => true,
        ),

        array(
            'name'               => 'SCM API',
            'slug'               => 'scm-api',
            'source'             => 'scm-api.zip',
            'required'           => false,
            'force_activation'   => false,
            'force_deactivation' => false,
        ),

        array(
            'name'               => 'GitHub Updater',
            'slug'               => 'github-updater',
            'source'             => 'github-updater.zip',
            'required'           => true,
            'force_activation'   => true,
            'force_deactivation' => true,
        ),

        array(
            'name'               => 'ACF Font Awesome',
            'slug'               => 'advanced-custom-fields-font-awesome',
            'required'           => true,
            'force_activation'   => true,
            'force_deactivation' => true,
        ),

        array(
            'name'               => 'ACF Limiter',
            'slug'               => 'advanced-custom-fields-limiter-field',
            'required'           => true,
            'force_activation'   => true,
            'force_deactivation' => true,
        ),

// ADMIN
        array(
            'name'               => 'SEO',
            'slug'               => 'all-in-one-seo-pack',
            'required'           => false,
            'force_activation'   => false,
            'force_deactivation' => false,
        ),


// UTILITIES
        array(
            'name'               => 'Contact Form 7',
            'slug'               => 'contact-form-7',
            'required'           => false,
            'force_activation'   => false,
            'force_deactivation' => false,
        ),

        /*array(
            'name'               => 'Captcha 7',
            'slug'               => 'really-simple-captcha',
            'required'           => false,
            'force_activation'   => false,
            'force_deactivation' => false,
        ),*/

        array(
            'name'               => 'Loco Translate',
            'slug'               => 'loco-translate',
            'required'           => false,
            'force_activation'   => false,
            'force_deactivation' => false,
        ),

        array(
            'name'               => 'Polylang',
            'slug'               => 'polylang',
            'required'           => false,
            'force_activation'   => false,
            'force_deactivation' => false,
        ),

        array(
            'name'               => 'Replace Media',
            'slug'               => 'enable-media-replace',
            'required'           => false,
            'force_activation'   => false,
            'force_deactivation' => false,
        ),

        array(
            'name'               => 'Optimize Database',
            'slug'               => 'rvg-optimize-database',
            'required'           => false,
            'force_activation'   => false,
            'force_deactivation' => false,
        ),

        array(
            'name'               => 'WP Database Backup',
            'slug'               => 'wp-database-backup',
            'required'           => false,
            'force_activation'   => false,
            'force_deactivation' => false,
        ),

        array(
            'name'               => 'WP Control',
            'slug'               => 'wp-control',
            'required'           => false,
            'force_activation'   => false,
            'force_deactivation' => false,
        ),

    // PLUS

        array(
            'name'               => 'PLUS - Role Editor',
            'slug'               => 'user-role-editor',
            'required'           => false,
            'force_activation'   => false,
            'force_deactivation' => false,
        ),

        array(
            'name'               => 'PLUS - WP Asset Clean Up',
            'slug'               => 'wp-asset-clean-up',
            'required'           => false,
            'force_activation'   => false,
            'force_deactivation' => false,
        ),


        array(
            'name'               => 'PLUS - AJAX Thumbnail Rebuild',
            'slug'               => 'ajax-thumbnail-rebuild',
            'required'           => false,
            'force_activation'   => false,
            'force_deactivation' => false,
        ),

        array(
            'name'               => 'PLUS - Thumbs Regenerator',
            'slug'               => 'regenerate-thumbnails',
            'required'           => false,
            'force_activation'   => false,
            'force_deactivation' => false,
        ),

        array(
            'name'               => 'PLUS - Theme Check',
            'slug'               => 'theme-check',
            'required'           => false,
            'force_activation'   => false,
            'force_deactivation' => false,
        ),

        array(
            'name'               => 'PLUS - Reset Database',
            'slug'               => 'wordpress-database-reset',
            'required'           => false,
            'force_activation'   => false,
            'force_deactivation' => false,
        ),

    );
    
    $config = array(
        'default_path' => SCM_DIR_PLUGINS,      // Default absolute path to pre-packaged plugins.
        'menu'         => 'scm-install-plugins',            // Menu slug.
        'has_notices'  => false,                            // Show admin notices or not.
        'dismissable'  => true,                             // If false, a user cannot dismiss the nag message.
        'dismiss_msg'  => '',                               // If 'dismissable' is false, this message will be output at top of nag.
        'is_automatic' => true,                             // Automatically activate plugins after installation or not.
        'message'      => '',                               // Message to output right before the plugins table.
        'strings'      => array(
            'page_title'                      => __( 'Install Required Plugins', SCM_THEME ),
            'menu_title'                      => __( 'Install Plugins', SCM_THEME ),
            'installing'                      => __( 'Installing Plugin: %s', SCM_THEME ), // %s = plugin name.
            'oops'                            => __( 'Something went wrong with the plugin API.', SCM_THEME ),
            'notice_can_install_required'     => _n_noop( 'This theme requires the following plugin: %1$s.', 'This theme requires the following plugins: %1$s.' ), // %1$s = plugin name(s).
            'notice_can_install_recommended'  => _n_noop( 'This theme recommends the following plugin: %1$s.', 'This theme recommends the following plugins: %1$s.' ), // %1$s = plugin name(s).
            'notice_cannot_install'           => _n_noop( 'Sorry, but you do not have the correct permissions to install the %s plugin. Contact the administrator of this site for help on getting the plugin installed.', 'Sorry, but you do not have the correct permissions to install the %s plugins. Contact the administrator of this site for help on getting the plugins installed.' ), // %1$s = plugin name(s).
            'notice_can_activate_required'    => _n_noop( 'The following required plugin is currently inactive: %1$s.', 'The following required plugins are currently inactive: %1$s.' ), // %1$s = plugin name(s).
            'notice_can_activate_recommended' => _n_noop( 'The following recommended plugin is currently inactive: %1$s.', 'The following recommended plugins are currently inactive: %1$s.' ), // %1$s = plugin name(s).
            'notice_cannot_activate'          => _n_noop( 'Sorry, but you do not have the correct permissions to activate the %s plugin. Contact the administrator of this site for help on getting the plugin activated.', 'Sorry, but you do not have the correct permissions to activate the %s plugins. Contact the administrator of this site for help on getting the plugins activated.' ), // %1$s = plugin name(s).
            'notice_ask_to_update'            => _n_noop( 'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.', 'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.' ), // %1$s = plugin name(s).
            'notice_cannot_update'            => _n_noop( 'Sorry, but you do not have the correct permissions to update the %s plugin. Contact the administrator of this site for help on getting the plugin updated.', 'Sorry, but you do not have the correct permissions to update the %s plugins. Contact the administrator of this site for help on getting the plugins updated.' ), // %1$s = plugin name(s).
            'install_link'                    => _n_noop( 'Begin installing plugin', 'Begin installing plugins' ),
            'activate_link'                   => _n_noop( 'Begin activating plugin', 'Begin activating plugins' ),
            'return'                          => __( 'Return to Required Plugins Installer', SCM_THEME ),
            'plugin_activated'                => __( 'Plugin activated successfully.', SCM_THEME ),
            'complete'                        => __( 'All plugins installed and activated successfully. %s', SCM_THEME ), // %s = dashboard link.
            'nag_type'                        => 'updated' // Determines admin notice type - can only be 'updated', 'update-nag' or 'error'.
        )
    );

    tgmpa( $plugins, $config );
}

// ------------------------------------------------------
// 7-DEBUG
// ------------------------------------------------------

/**
* [SET] Console log hooks list
*
* Hooked by 'shutdown'
* @subpackage 4-Init/Admin/8-DEBUG
*/
function scm_hook_admin_debug_hooks() {
    do_action( 'scm_action_ready' );
    global $SCM_debug;
    if( $SCM_debug ){
        foreach( $GLOBALS['wp_actions'] as $action => $count )
            consoleLog( $action . ' > ' . $count );
    }
}

?>
