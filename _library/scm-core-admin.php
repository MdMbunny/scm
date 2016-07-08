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
//      0.2 Uploads
//      0.3 Debug
//
// ------------------------------------------------------

// ------------------------------------------------------
// 0.0 ACTIONS AND FILTERS
// ------------------------------------------------------

add_filter( 'wp_mail_from', 'scm_admin_mail_from' );
add_filter( 'wp_mail_from_name', 'scm_admin_mail_from_name' );

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
// 0.2 UPLOADS
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

    $arr = thePost();
    $dir = '';

    if($arr){
        $type = $arr['type'];
        $tax = $arr['taxonomy'];
        if(gettype($tax) == 'array')
            $tax = implode('-', $tax);
        if( $type ){
            $dir .= '/' . $type;
            if( $tax )
                $dir .= '/' . $tax;
        }

    }else{
        $dir = '/options';
    }

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
// 0.3 DEBUG
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
