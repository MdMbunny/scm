<?php
/**
 * @package SCM
 */

// *****************************************************
// *    SCM ADMIN
// *****************************************************

/*
*****************************************************
*
*   0.0 Actions and Filters
*   1.0 Functions
**      Duplicate Post
*   2.0 Hooks
**      UI
**      Uploads
*
*****************************************************
*/


// *****************************************************
// *      0.0 ACTIONS AND FILTERS
// *****************************************************

    add_action( 'admin_action_scm_admin_duplicate_post', 'scm_admin_duplicate_post' );
    add_filter( 'page_row_actions', 'scm_admin_duplicate_post_link', 10, 2 );
    add_filter( 'post_row_actions', 'scm_admin_duplicate_post_link', 10, 2 );
    
    add_action( 'admin_menu', 'scm_admin_remove_menus' );
    add_action( 'wp_dashboard_setup', 'scm_admin_remove_dashboard_widgets' );
    add_action( 'pre_user_query','scm_admin_hide_from_users');
    

    add_filter( 'wp_handle_upload_prefilter', 'scm_upload_pre', 2 );
    add_filter( 'wp_handle_upload', 'scm_upload_post', 2 );
    add_filter( 'wp_handle_upload', 'scm_upload_set_size', 3 );

    add_action( 'admin_init', 'scm_upload_sizes' );
    add_filter( 'image_size_names_choose', 'scm_custom_sizes' );
    //add_filter('wp_handle_upload_prefilter', 'scm_upload_set_filename', 1, 1);
    //add_filter('wp_read_image_metadata', 'scm_upload_set_meta', 1, 3);    
    //add_filter( 'upload_dir', 'scm_upload_set_directory' );
    
// *****************************************************
// *      1.0 FUNCTIONS
// *****************************************************

// *********************************************
//  Duplicate Post
// *********************************************

// Function creates post duplicate as a draft and redirects then to the edit post screen
    if ( ! function_exists( 'scm_admin_duplicate_post' ) ) {
        function scm_admin_duplicate_post(){

            global $wpdb;

            if ( !( isset( $_GET['post']) || isset( $_POST['post']) || ( isset($_REQUEST['action']) && 'scm_admin_duplicate_post' == $_REQUEST['action'] ) ) ) {
                wp_die('No post to duplicate has been supplied!');
            }

            $post_id = ( isset( $_GET['post'] ) ? $_GET['post'] : $_POST['post'] );
            $post = get_post( $post_id );
            $current_user = wp_get_current_user();
            $new_post_author = $current_user->ID;
         
            if (isset( $post ) && $post != null) {

                $args = array(
                    'comment_status' => $post->comment_status,
                    'ping_status'    => $post->ping_status,
                    'post_author'    => $new_post_author,
                    'post_content'   => $post->post_content,
                    'post_excerpt'   => $post->post_excerpt,
                    'post_name'      => $post->post_name,
                    'post_parent'    => $post->post_parent,
                    'post_password'  => $post->post_password,
                    'post_status'    => 'draft',
                    'post_title'     => $post->post_title,
                    'post_type'      => $post->post_type,
                    'to_ping'        => $post->to_ping,
                    'menu_order'     => $post->menu_order
                );

                $new_post_id = wp_insert_post( $args );

                $taxonomies = get_object_taxonomies( $post->post_type );
                foreach ( $taxonomies as $taxonomy ) {

                    $post_terms = wp_get_object_terms( $post_id, $taxonomy, array( 'fields' => 'slugs' ) );
                    wp_set_object_terms( $new_post_id, $post_terms, $taxonomy, false );

                }

                $post_meta_infos = $wpdb->get_results( "SELECT meta_key, meta_value FROM $wpdb->postmeta WHERE post_id=$post_id" );
                
                if (count($post_meta_infos)!=0) {

                    $sql_query = "INSERT INTO $wpdb->postmeta (post_id, meta_key, meta_value) ";

                    foreach ( $post_meta_infos as $meta_info ) {
                        $meta_key = $meta_info->meta_key;
                        $meta_value = addslashes( $meta_info->meta_value );
                        $sql_query_sel[] = "SELECT $new_post_id, '$meta_key', '$meta_value'";
                    }

                    $sql_query.= implode( " UNION ALL ", $sql_query_sel );
                    $wpdb->query( $sql_query );

                }

                wp_redirect( admin_url( 'post.php?action=edit&post=' . $new_post_id ) );

                exit;

            } else {

                wp_die('Post creation failed, could not find original post: ' . $post_id);

            }
        }
    }

// Add the duplicate link to action list
    if ( ! function_exists( 'scm_admin_duplicate_post_link' ) ) {
        function scm_admin_duplicate_post_link( $actions, $post ) {
            if (current_user_can('edit_posts')) {
                $actions['duplicate'] = '<a href="admin.php?action=scm_admin_duplicate_post&amp;post=' . $post->ID . '" title="' . __( 'Duplica questo oggetto', SCM_THEME ) . '" rel="permalink">' . __( 'Duplica', SCM_THEME ) . '</a>';
            }
            return $actions;
        }
    }

 

// *****************************************************
// *      2.0 HOOKS
// *****************************************************

// *********************************************
//  UI
// *********************************************

// Remove Menu Elements
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
            remove_meta_box('synved_connect_dashboard_widget', 'dashboard', 'normal');   // Sociual Feather
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

        //$screen = get_current_screen();
        //alert( $screen->base );
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
// UPLOAD
// *********************************************
    
    add_action( 'current_screen', 'scm_current_screen' );

    if ( ! function_exists( 'scm_current_screen' ) ) {
        function scm_current_screen( $current_screen ){
            global $currentScreen;

            $currentScreen = $current_screen;

            //printPre( $current_screen );
        }
    }


// Change the upload path to the one we want
    if ( ! function_exists( 'scm_upload_pre' ) ) {
        function scm_upload_pre( $file ){

            add_filter( 'upload_dir', 'scm_upload_set_directory' );

            return $file;

        }
    }
 
// Change the upload path back to the one Wordpress uses by default
    if ( ! function_exists( 'scm_upload_post' ) ) {
        function scm_upload_post( $fileinfo ){

            remove_filter( 'upload_dir', 'scm_upload_set_directory' );

            return $fileinfo;
        }
    }
                                                                                                
//Change the Upload Folder to a Type Folder
    if ( ! function_exists( 'scm_upload_set_directory' ) ) {
        function scm_upload_set_directory($args){

            $arr = thePost();

            $dir = '';
            
            if($arr){
                $type = $arr['type'];        
                $slug = $arr['slug'];
                $tax = $arr['taxonomy'];
                if(gettype($tax) == 'array') $tax = implode('-', $tax);
                
                if( $type ){
                    
                    $dir .= '/' . $type;
                    
                    if( $tax )
                        $dir .= '/' . $tax;

                }

            }else{

                $dir = '/options';
            }

            if( $dir ){

                //$args['path']    = str_replace( $args['subdir'], '', $args['path'] );
                //$args['url']     = str_replace( $args['subdir'], '', $args['url'] );
                $args['subdir']  = $dir;
                $args['path']   .= $dir; 
                $args['url']    .= $dir;

            }

            return $args;
        }
    }


//Add Sizes for Uploaded Images
    if ( ! function_exists( 'scm_upload_sizes' ) ) {
        function scm_upload_sizes(){

            add_image_size('square', 700, 700, true);
            add_image_size('square-medium', 500, 500, true);
            add_image_size('square-small', 300, 300, true);
            add_image_size('square-thumb', 150, 150, true);
            //add_image_size('big', 700, 700, false);

        }
    }

    if ( ! function_exists( 'scm_custom_sizes' ) ) {
        function scm_custom_sizes( $sizes ) {
            return array_merge( $sizes, array(
                'square' => __( 'Quadrata', SCM_THEME ),
                'square-medium' => __( 'Quadrata Media', SCM_THEME ),
                'square-small' => __( 'Quadrata Piccola', SCM_THEME ),
                'square-thumb' => __( 'Quadrata Thumb', SCM_THEME ),
            ) );
        }
    }

    //Change the Name of the Uploaded File
    /*if ( ! function_exists( 'scm_admin_remove_dashboard_widgets' ) ) {
        function scm_upload_set_filename( $image ) {

            if ( isset( $_REQUEST['post_id'] ) ) {

                $id = absint( $_REQUEST['post_id'] );

                if( $id && is_numeric( $id ) ) {

                    $post_obj = get_post( $id ); 
                    $slug = $post_obj->post_name;

                    if( $post_slug ) {

                        $image[ 'name' ] = $post_slug . substr( $image[ 'name' ], 0, strpos( $image[ 'name' ], '.', -1 ) - 1 );

                    }

                }

            }

            return $image;
        }
    }*/
/*
//Change the Meta of the Uploaded File
function scm_upload_set_meta($meta, $file, $sourceImageType) {

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


//Set the Max Size for Uploaded Images and Delete Original Files
    if ( ! function_exists( 'scm_upload_set_size' ) ) {
        function scm_upload_set_size( $params ){
            $filePath = $params['file'];

            $image = wp_get_image_editor( $filePath );
            
            if ( ! is_wp_error( $image ) ) {
                $quality = scm_field('uploads_quality', 90, 'option');
                $largeWidth = scm_field('uploads_width', 1800, 'option');
                $largeHeight = scm_field('uploads_height', 1800, 'option');
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
    }

//endif;

?>
