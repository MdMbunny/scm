<?php

//if( is_admin() ) :

// *****************************************************
// *      ACTIONS AND FILTERS
// *****************************************************

    add_action( 'admin_enqueue_scripts', 'scm_admin_assets', 998 );

    add_action( 'admin_menu', 'scm_admin_remove_menus' );
    add_action( 'wp_dashboard_setup', 'scm_admin_remove_dashboard_widgets' );
    add_action( 'pre_user_query','scm_admin_hide_from_users');

    //add_filter('wp_handle_upload_prefilter', 'scm_upload_hook_filename', 1, 1);
    //add_filter('wp_read_image_metadata', 'scm_upload_hook_meta', 1, 3);

    add_filter( 'upload_dir', 'scm_upload_set_directory' );
    add_filter( 'wp_handle_upload', 'scm_upload_set_size' );


// *****************************************************
// *      ASSETS
// *****************************************************

    if ( ! function_exists( 'scm_admin_assets' ) ) {
        function scm_admin_assets() {

            wp_enqueue_style('admin');
        }
    }    


// *****************************************************
// *      HOOKS
// *****************************************************

// *********************************************
// ***************************** ADMIN HOOKS ***
// *********************************************


    if ( ! function_exists( 'scm_admin_remove_menus' ) ) {
        function scm_admin_remove_menus(){

        // HAI UN PLUG IN per questi
            //remove_menu_page( 'index.php' );                  //Dashboard
            //remove_menu_page( 'edit-comments.php' );          //Comments
            //remove_menu_page( 'edit.php' );                   //Posts
            
            if(!current_user_can( 'administrator' )){

                remove_menu_page( 'themes.php' );                 //Appearance
                remove_menu_page( 'plugins.php' );                //Plugins
                remove_menu_page( 'tools.php' );                  //Tools
                remove_menu_page( 'options-general.php' );        //Settings
                remove_menu_page( 'wpcf7' );

                if(!current_user_can( 'editor' )){

                    remove_menu_page( 'upload.php' );                 //Media
                    remove_menu_page( 'edit.php?post_type=page' );    //Pages

                    if(!current_user_can( 'author' )){
                        remove_menu_page( 'users.php' );                  //Users
                    }
                }
            }
        }
    }

// Remove Dashboard Widgets
    if ( ! function_exists( 'scm_admin_remove_dashboard_widgets' ) ) {
        function scm_admin_remove_dashboard_widgets(){
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
    }

// Hide Administrator From User List
    if ( ! function_exists( 'scm_admin_hide_from_users' ) ) {
        function scm_admin_hide_from_users($user_search) {
            $user = wp_get_current_user();
            if (!is_admin()) { // Is Not Administrator - Remove Administrator
                //if (!current_user_can('administrator')) { // Is Not Administrator - Remove Administrator
                global $wpdb;

                $user_search->query_where = 
                str_replace('WHERE 1=1', 
                    "WHERE 1=1 AND {$wpdb->users}.ID IN (
                         SELECT {$wpdb->usermeta}.user_id FROM $wpdb->usermeta 
                            WHERE {$wpdb->usermeta}.meta_key = '{$wpdb->prefix}capabilities'
                            AND {$wpdb->usermeta}.meta_value NOT LIKE '%administrator%')", 
                    $user_search->query_where
                );
            }
        }
    }


// *********************************************
// **************************** UPLOAD HOOKS ***                                         <<  +++ todo:  dare nome post + index (post-type-01)
// *********************************************                                                    ottenere ID file e aggiungere {index, ID, nome originale} in tabella database (new post-type Files ?)
/*                                                                                                  quando carico nuovo file cerca in Files database [nome-originale], se lo trovo sostituisco File [index]
//Change the Name of the Uploaded File
function scm_upload_hook_filename($arr) {

    if (!isset($_REQUEST['post_id'])) {
        $id = (int)$_REQUEST['post_id'];
    }else{
        $id = ( isset( $_REQUEST['post_id'] ) ? $_REQUEST['post_id'] : '' );
    }

    if($id && is_numeric($id)) {
        $post_obj = get_post($id); 
        $slug = $post_obj->post_name;
        // variabile per slug o title
        if($post_slug) {
            // numero progressivo?
            $random_number = rand(10000,99999);
            // get estensione -> .jpg
            $arr['name'] = $post_slug . '-' . $random_number . '.jpg';
        }
    }
    return $arr;
}

//Change the Meta of the Uploaded File
function scm_upload_hook_meta($meta, $file, $sourceImageType) {

    if( isset($_REQUEST['post_id']) ) {
        $post_id = $_REQUEST['post_id'];
    } else {
        $post_id = false;
    }
    if($post_id && is_numeric($post_id)) {
        $post_title = get_the_title($post_id);
        if($post_title) {
            $meta['title'] = $post_title;
            $meta['caption'] = $post_title;
        }
    }
    return $meta;
}
*/


//Change the Upload Folder to a Type Folder
    if ( ! function_exists( 'scm_upload_set_directory' ) ) {
        function scm_upload_set_directory($args){
            global $SCM_types;
            
            $arr = thePost();

            if($arr){
                $type = $arr['type'];        
                $slug = $arr['slug'];
                $tax = $arr['taxonomy'];
                if(gettype($tax) == 'array') $tax = implode('-', $tax);

                /*$postname = $SCM_types[$type]->uploads_post_folder;
                if(!$postname) return $args;*/
                
                $newdir = '/' . $type;
                if($tax) $newdir .= '/' . $tax;
                /*if($postname)*/ //$newdir .= '/' . $slug;
                
                $args['path']    = str_replace( $args['subdir'], '', $args['path'] );
                $args['url']     = str_replace( $args['subdir'], '', $args['url'] );      
                $args['subdir']  = $newdir;
                $args['path']   .= $newdir; 
                $args['url']    .= $newdir; 

                return $args;
            }

            return $args;
        }
    }


//Set the Max Size for Uploaded Images and Delete Original Files
    if ( ! function_exists( 'scm_upload_set_size' ) ) {
        function scm_upload_set_size( $params ){
            $filePath = $params['file'];

            $image = wp_get_image_editor( $filePath );
            
            if ( ! is_wp_error( $image ) ) {
                $quality = get_field('uploads_quality', 'option');
                $largeWidth = get_field('uploads_width', 'option');
                $largeHeight = get_field('uploads_height', 'option');
                $size = $image->get_size();
                $oldWidth = $size['width'];
                $oldHeight = $size['height'];
                $new_size = wp_constrain_dimensions( $oldWidth, $oldHeight, $largeWidth, $largeHeight );
                $newWidth = $new_size[0];
                $newHeight = $new_size[1];
            
                $image->resize( $newWidth, $newHeight );
                $image->set_quality( $quality );
                $image->save( $filePath );

            }

            return $params;
        }
    }

//endif;

?>
