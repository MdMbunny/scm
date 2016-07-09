<?php

/**
* scm-core-admin.php.
*
* SCM admin functions.
*
* @link http://www.studiocreativo-m.it
*
* @package SCM
* @subpackage Core/Admin
* @since 1.0.0
*/

// ------------------------------------------------------
//
// 0.0 Actions and Filters
//      0.1 Users
//      0.2 Menu
//      0.3 Hide
//      0.4 Uploads
//      0.5 Plugins
//      0.6 Debug
//
// ------------------------------------------------------

// ------------------------------------------------------
// 0.0 ACTIONS AND FILTERS
// ------------------------------------------------------

add_filter( 'wp_mail_from', 'scm_admin_mail_from' );
add_filter( 'wp_mail_from_name', 'scm_admin_mail_from_name' );

add_action( 'admin_menu', 'scm_hook_admin_ui_menu_remove' );
add_action( 'admin_menu', 'scm_hook_admin_ui_menu_add' );
add_filter( 'custom_menu_order', 'scm_hook_admin_ui_menu_order' );
add_filter( 'menu_order', 'scm_hook_admin_ui_menu_order' );

/** Always disable front end admin bar */
add_filter('show_admin_bar', '__return_false');
add_action( 'wp_dashboard_setup', 'scm_hook_admin_ui_hide_dashboard_widgets' );
add_action( 'admin_head', 'scm_hook_admin_ui_hide_from_users' );
add_action( 'admin_bar_menu', 'scm_hook_admin_ui_hide_tools', 999 );

/** Always disable year/month folders in upload */
add_filter( 'option_uploads_use_yearmonth_folders', '__return_false', 100 );
add_filter( 'wp_calculate_image_sizes', 'scm_hook_admin_upload_adjust_sizes', 10, 2 );
add_filter( 'wp_handle_upload', 'scm_hook_admin_upload_max_size', 3 );
add_filter( 'intermediate_image_sizes_advanced', 'scm_hook_admin_upload_def_sizes' );
add_action( 'admin_init', 'scm_hook_admin_upload_custom_sizes' );
add_filter( 'image_size_names_choose', 'scm_hook_admin_upload_custom_names' );
add_filter( 'upload_dir', 'scm_hook_admin_upload_dir', 2 );
add_filter( 'manage_media_columns', 'scm_hook_admin_upload_columns' );
add_action( 'manage_media_custom_column', 'scm_hook_admin_upload_custom_column',10, 2 );

add_action( 'plugins_loaded', 'scm_hook_admin_plugins_duplicate_post' );
add_action( 'plugins_loaded', 'scm_hook_admin_plugins_backup_restore_options' );
add_action( 'tgmpa_register', 'scm_hook_admin_plugins_tgm_plugin_activation' );

add_action( 'shutdown', 'scm_hook_admin_debug_hooks');

/*
// AUTO NAV - UNDER COSTRUCTION
add_action( 'after_setup_theme', 'scm_hook_nav_auto_menu' ); // TESTING

function scm_hook_nav_auto_menu(){

    //if( !scm_field( 'menu-auto', 0, 'option' ) )
        //return;

    //$locations = get_nav_menu_locations();
    $locations = get_theme_mod('nav_menu_locations');
    $menu = get_term( $locations[ 'auto' ], 'nav_menu' );

    if( $menu && SCM_LEVEL === 0 && $pagenow == 'nav-menus.php' ){

        $menu_name = $menu->name;
        unregister_nav_menu( 'auto' );
        wp_delete_nav_menu( $menu_name );

        $menu = wp_create_nav_menu($menu_name);

        //$pages = ;

        $title = 'Services';
        $slug = 'services';

        $item = wp_update_nav_menu_item($menu, 0, array(
            'menu-item-title' => $title,
            'menu-item-object' => 'page',
            'menu-item-object-id' => get_page_by_path( $slug )->ID,
            'menu-item-type' => 'post_type',
            'menu-item-status' => 'publish'
            )
        );

            //$sub_item = wp_update_nav_menu_item($menu, 0, array(
            //    'menu-item-title' => $subtitle,
            //    'menu-item-url' => '#' . $subid,
            //    'menu-item-type' => 'custom',
            //    'menu-item-status' => 'publish',
            //    'menu-item-parent-id' => $item,
            //    )
            //);

        $locations[ 'auto' ] = $menu;
        set_theme_mod( 'nav_menu_locations', $locations );
    }
}
}
*/

// ------------------------------------------------------
// 0.1 USERS
// ------------------------------------------------------

/**
* [GET] Mail from [website name]
*
* Hooked by 'wp_mail_from_name'
*
* @return {string} Website title
*/
function scm_hook_admin_mail_from_name() {
    $name = get_option('blogname');
    $name = esc_attr($name);
    return $name;
}

/**
* [GET] Mail from [opt-staff-email]
*
* Hooked by 'wp_mail_from'
*
* @return {string} Email from opt-staff-email option
*/
function scm_hook_admin_mail_from() {
    $email = scm_field( 'opt-staff-email', '', 'option' );
    $email = is_email($email);
    return $email;
}

// ------------------------------------------------------
// 0.2 MENU
// ------------------------------------------------------

/**
* [SET] Remove unused WP menu elements
*
* Hooked by 'admin_menu'
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
*/
function scm_hook_admin_ui_menu_add(){

    global $menu;
    ksort( $menu );

    $menu[] = array('','read',"separator3",'','wp-menu-separator');
    $menu[] = array('','read',"separator4",'','wp-menu-separator');
    $menu[] = array('','read',"separator5",'','wp-menu-separator');
}

/**
* [SET] Set WP menu order
*
* Hooked by 'custom_menu_order', 'menu_order'
*/
function scm_hook_admin_ui_menu_order( $menu_ord ) {
    
    if ( !$menu_ord ) return true;

    $menu_order = array(
        'scm' => array(
            'index.php', // Dashboard
        ),
        'separator1' => array( 'separator1' ),
        'pages' => array(
            'edit.php?post_type=page', // Pages
        ),
        'separator2' => array( 'separator2' ),
        'types' => array(
            'edit.php', // Posts
        ),
        'separator3' => array( 'separator3' ),
        'media' => array(
            'upload.php', // Media
        ),
        'separator4' => array( 'separator4' ),
        'contacts' => array(
            'edit-comments.php', // Comments
            'link-manager.php', // Links
            'users.php', // Users
            'wpcf7', // Forms
        ),
        'separator5' => array( 'separator5' ),
        'settings' => array(
            'themes.php', // Appearance
            'plugins.php', // Plugins
            'tools.php', // Tools
            'options-general.php', // Settings
        ),
        'separator-last' => array( 'separator-last' ),
    );

    $menu_order = apply_filters( 'scm_filter_admin_ui_menu_order', $menu_order );

    return call_user_func_array( 'array_merge', $menu_order );
}

// ------------------------------------------------------
// 0.3 HIDE
// ------------------------------------------------------

/**
* [SET] Remove WP dashboard widgets
*
* Hooked by 'wp_dashboard_setup'
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
*/
function scm_hook_admin_ui_hide_from_users(){
   
    if( !current_user_can( 'manage_options' ) )
        echo '<style>#screen-meta-links{display: none !important;}</style>';

    if (!current_user_can('update_core')) {
        remove_action( 'admin_notices', 'update_nag', 3 );
    }            
}

/**
* [SET] Remove tools from toolbar
*
* Hooked by 'admin_bar_menu'
*/
function scm_hook_admin_ui_hide_tools( $wp_admin_bar ) {
    $wp_admin_bar->remove_node( 'wp-logo' );
    $wp_admin_bar->remove_node( 'comments' );
    $wp_admin_bar->remove_node( 'new-post' );
    $wp_admin_bar->remove_node( 'new-media' );
    $wp_admin_bar->remove_node( 'new-page' );
    $wp_admin_bar->remove_node( 'view' );
}

// ------------------------------------------------------
// 0.4 UPLOADS
// ------------------------------------------------------

/**
* [GET] Calculate image responsive sizes
*
* Hooked by 'wp_calculate_image_sizes'
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
*
* @param {array=} sizes Original sizes array (default is empty array).
* @return {array} Modified sizes array.
*/
function scm_hook_admin_upload_def_sizes( $sizes = array() ) {

    $sizes['thumbnail']['width'] = 300;
    $sizes['medium']['width'] = 1024;
    $sizes['large']['width'] = 1200;
    $sizes['thumbnail']['height'] = $sizes['medium']['height'] = $sizes['thumbnail']['large'] = 0;

    return $sizes;
}

/**
* [SET] Add new sizes for uploaded images
*
* Hooked by 'admin_init'
*/
function scm_hook_admin_upload_custom_sizes(){
    add_image_size('small', 700, 0, false);
}

/**
* [GET] New size names for uploaded images
*
* Hooked by 'image_size_names_choose'
*
* @param {array=} sizes Original sizes array (default is empty array).
* @return {array} Modified sizes array.
*/
function scm_hook_admin_upload_custom_names( $sizes = array() ) {
    return array_merge( $sizes, array(
        'small' => __( 'Small', SCM_THEME ),
    ) );
}

/**
* [SET|GET] Set max size for uploading image and delete original files
*
* Hooked by 'wp_handle_upload'
*
* @param {array=} params Original image parameters (default is empty array).
* @return {array} Original image parameters.
*/
function scm_hook_admin_upload_max_size( $params = array() ){
    if( !isset( $params['file'] ) ) return $params;

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
*
* @param {array=} img Original image array (default is empty array).
* @return {array} Modified image array.
*/
function scm_hook_admin_upload_dir( $img = array() ){

    $type = thePost('type');
    $dir = '';

    if( $type )
        $dir .= '/' . $type;
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
        $meta = explode( '/', $meta['file'] );
        $folder = ucfirst( ( isset( $meta['file'] ) ? $meta[0] : 'uploads' ) );

        echo $folder;
    }
}

// ------------------------------------------------------
// 0.5 PLUGINS
// ------------------------------------------------------

/**
* [SET] Duplicate Post init
*
* Hooked by 'plugins_loaded'
*/
function scm_hook_admin_plugins_duplicate_post() {
    new Duplicate_Post( SCM_THEME );    
}

/**
* [SET] Backup Restore Options init
*
* Hooked by 'plugins_loaded'
*/
function scm_hook_admin_plugins_backup_restore_options() {
    new Backup_Restore_Options( SCM_THEME );
}

/**
* [SET] TGM Plugin Activation init
*
* Hooked by 'tgmpa_register'
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
            'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
        ),

        array(
            'name'               => 'SCM Assets',
            'slug'               => 'scm-assets',
            'source'             => 'scm-assets.zip',
            'required'           => true,
            'force_activation'   => true,
            'force_deactivation' => false,
        ),

        array(
            'name'               => 'SCM API',
            'slug'               => 'scm-api',
            'source'             => 'scm-api.zip',
            'required'           => true,
            'force_activation'   => true,
            'force_deactivation' => false,
        ),

        array(
            'name'               => 'GitHub Updater',
            'slug'               => 'github-updater',
            'source'             => 'github-updater.zip',
            'required'           => true,
            'force_activation'   => true,
            'force_deactivation' => false,
        ),

        array(
            'name'               => 'ACF Font Awesome',
            'slug'               => 'advanced-custom-fields-font-awesome',
            'required'           => true,
            'force_activation'   => true,
            'force_deactivation' => false,
        ),

        array(
            'name'               => 'ACF Limiter',
            'slug'               => 'advanced-custom-fields-limiter-field',
            'required'           => true,
            'force_activation'   => true,
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

        array(
            'name'               => 'Captcha 7',
            'slug'               => 'really-simple-captcha',
            'required'           => false,
            'force_activation'   => false,
            'force_deactivation' => false,
        ),

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
            'name'               => 'Browser Detection',
            'slug'               => 'php-browser-detection',
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
            'slug'               => 'wp-db-backup',
            'required'           => false,
            'force_activation'   => false,
            'force_deactivation' => false,
        ),

        array(
            'name'               => 'Share Buttons',
            'slug'               => 'simple-share-buttons-adder',
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
// 0.6 DEBUG
// ------------------------------------------------------

/**
* [SET] Console log hooks list
*
* Hooked by 'shutdown'
*/
function scm_hook_admin_debug_hooks() {
    global $SCM_debug;
    if( $SCM_debug ){
        foreach( $GLOBALS['wp_actions'] as $action => $count )
            consoleLog( $action . ' > ' . $count );
    }
}

?>
