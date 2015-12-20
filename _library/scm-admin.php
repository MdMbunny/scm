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
**          Duplicate Post
*   2.0 Hooks
**          UI
**          Uploads
*
*****************************************************
*/


// *****************************************************
// *      0.0 ACTIONS AND FILTERS
// *****************************************************

    add_filter('login_redirect', 'scm_login_redirect', 10, 3 );
    add_action('admin_init', 'scm_admin_redirect');


    add_filter( 'wp_mail_from', 'scm_mail_from' );
    add_filter( 'wp_mail_from_name', 'scm_mail_from_name' );

    
    add_action( 'admin_enqueue_scripts', 'scm_admin_assets', 998 );
    add_action( 'login_enqueue_scripts', 'scm_login_assets', 10 );    

    add_action( 'admin_action_scm_admin_duplicate_post', 'scm_admin_duplicate_post' );
    add_filter( 'page_row_actions', 'scm_admin_duplicate_post_link', 10, 2 );
    add_filter( 'post_row_actions', 'scm_admin_duplicate_post_link', 10, 2 );
    
    add_action( 'admin_menu', 'scm_admin_menu_remove' );
    add_action( 'admin_menu', 'scm_admin_menu');

    add_action( 'wp_dashboard_setup', 'scm_admin_remove_dashboard_widgets' );
    add_action( 'admin_head', 'scm_admin_remove_meta' );
    add_action( 'pre_user_query', 'scm_admin_hide_from_users' );
    add_action( 'admin_bar_menu', 'scm_admin_hide_tools', 999 );

    //add_action( 'current_screen', 'scm_current_screen' );
    add_filter( 'wp_handle_upload_prefilter', 'scm_upload_pre', 2 );
    add_filter( 'wp_handle_upload', 'scm_upload_post', 2 );
    add_filter( 'wp_handle_upload', 'scm_upload_set_size', 3 );
    add_action( 'admin_init', 'scm_admin_plugins' );

    add_action( 'admin_init', 'scm_admin_upload_sizes' );
    add_filter( 'image_size_names_choose', 'scm_admin_custom_sizes' );
    //add_filter('wp_handle_upload_prefilter', 'scm_upload_set_filename', 1, 1);
    //add_filter('wp_read_image_metadata', 'scm_upload_set_meta', 1, 3);    
    //add_filter( 'upload_dir', 'scm_upload_set_directory' );

   

// *****************************************************
// *      1.0 FUNCTIONS
// *****************************************************

    if ( ! function_exists( 'scm_login_redirect' ) ) {
        function scm_login_redirect( $url, $request, $user ){
            if( $user && is_object( $user ) && is_a( $user, 'WP_User' ) ) {
                if( $user->has_cap( 'administrator' ) ) {
                    $url = admin_url('admin.php?page=scm-options-intro');
                } elseif( $user->has_cap( 'upload_files' ) && startsWith( $request, SCM_SITE . '/wp-admin' ) ) {
                    $url = admin_url('users.php');
                }
            }
            return $url;
        }
    }    

    if ( ! function_exists( 'scm_admin_redirect' ) ) {
        function scm_admin_redirect() {
            if (!current_user_can('upload_files') && $_SERVER['DOING_AJAX'] != '/wp-admin/admin-ajax.php') {
                
                wp_redirect( home_url() );
                exit;

            }
        }
    }

    if ( ! function_exists( 'scm_mail_from_name' ) ) {
        function scm_mail_from_name() {
            //$name = 'yourname';
            $name = get_option('blogname');
            $name = esc_attr($name);
            return $name;
        }
    }

    if ( ! function_exists( 'scm_mail_from' ) ) {
        function scm_mail_from() {
            $email = scm_field( 'opt-staff-email', '', 'option' );
            $email = is_email($email);
            return $email;
        }
    }


// *********************************************
//  Enqueue CSS and Scripts
// *********************************************

    if ( ! function_exists( 'scm_admin_assets' ) ) {
        function scm_admin_assets() {

            /*wp_register_script( 'gmapapi', 'https://maps.googleapis.com/maps/api/js?v=3.exp?key=AIzaSyBZEApCxfzuavDWXdJ2DAVAftxbMjZWrVY&sensor=false', false, '', true );
            wp_enqueue_script( 'gmapapi' );*/

            wp_register_style( 'scm-admin', SCM_URI_CSS . 'scm-admin.css', false, SCM_SCRIPTS_VERSION, 'screen' );
            wp_enqueue_style('scm-admin');
            wp_register_style( 'scm-admin-child', SCM_URI_CHILD . 'admin.css', false, SCM_SCRIPTS_VERSION, 'screen' );
            wp_enqueue_style('scm-admin-child');

            wp_register_script( 'jquery-scm-admin', SCM_URI_JS . 'jquery.scm/jquery.admin.js', array( 'jquery' ), SCM_SCRIPTS_VERSION, true );
            wp_enqueue_script( 'jquery-scm-admin' );

            wp_register_script( 'jquery-scm-admin-child', SCM_URI_JS_CHILD . 'jquery.admin.js', array( 'jquery' ), SCM_SCRIPTS_VERSION, true );
            wp_enqueue_script( 'jquery-scm-admin-child' );
            
        }
    } 

    if ( ! function_exists( 'scm_login_assets' ) ) {
        function scm_login_assets() {

            /*wp_register_script( 'gmapapi', 'https://maps.googleapis.com/maps/api/js?v=3.exp?key=AIzaSyBZEApCxfzuavDWXdJ2DAVAftxbMjZWrVY&sensor=false', false, '', true );
            wp_enqueue_script( 'gmapapi' );*/

            wp_register_style( 'scm-login', SCM_URI_CSS . 'scm-login.css', false, SCM_SCRIPTS_VERSION, 'screen' );
            wp_enqueue_style('scm-login');
            
            wp_register_style( 'scm-login-child', SCM_URI_CSS_CHILD . 'login.css', false, SCM_SCRIPTS_VERSION, 'screen' );
            wp_enqueue_style('scm-login-child');

            wp_register_script( 'jquery-scm-login', SCM_URI_JS . 'jquery.scm/jquery.login.js', array( 'jquery' ), SCM_SCRIPTS_VERSION, true );
            wp_enqueue_script( 'jquery-scm-login' );

            wp_register_script( 'jquery-scm-login-child', SCM_URI_JS_CHILD . 'jquery.login.js', array( 'jquery' ), SCM_SCRIPTS_VERSION, true );
            wp_enqueue_script( 'jquery-scm-login-child' );

            
            
        }
    }

// *********************************************
//  Duplicate Post
// *********************************************

// Function creates post duplicate as a draft and redirects then to the edit post screen
    if ( ! function_exists( 'scm_admin_duplicate_post' ) ) {
        function scm_admin_duplicate_post(){

            global $wpdb;

            if ( !( isset( $_GET['post']) || isset( $_POST['post']) || ( isset($_REQUEST['action']) && 'scm_admin_duplicate_post' == $_REQUEST['action'] ) ) ) {
                wp_die( __( 'No post to duplicate has been supplied!', SCM_THEME ) );
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
            if( current_user_can( 'publish_' . $post->post_type ) ) {
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


// Set Menu Elements
    if ( ! function_exists( 'scm_admin_menu' ) ) {
        function scm_admin_menu(){

            global $menu;
            ksort( $menu );

            $media = $menu[10];
            $pages = $menu[20];
            if( isset( $menu[26] ) && isset( $menu[26][0] ) && $menu[26][0] == 'C F 7' ){
                $cf7 = $menu[26];
                $menu[57] = $cf7;
            }

            if( isset( $menu['80.025'] ) ){
                $acf = $menu['80.025'];
                unset( $menu['80.025'] );
                $menu[83] = $acf;
            }
            
            $users = $menu[70];
            
            $menu[5] = $pages;
            $menu[10] = array('','read',"separator3",'','wp-menu-separator');
            $menu[20] = array('','read',"separator4",'','wp-menu-separator');
            $menu[26] = array('','read',"separator5",'','wp-menu-separator');
            $menu[27] = $media;
            $menu[42] = array('','read',"separator6",'','wp-menu-separator');
            
            $menu[56] = $users;
            unset( $menu[70] );
            $menu[81] = array('','read',"separator7",'','wp-menu-separator');
            

            ksort( $menu );
        }
    }

// Remove Menu Elements
    if ( ! function_exists( 'scm_admin_menu_remove' ) ) {
        function scm_admin_menu_remove(){

            global $SCM_types;

            //global $submenu;


            remove_menu_page( 'index.php' );                  //Dashboard
            remove_menu_page( 'edit.php' );                   //Posts

            remove_menu_page( 'edit-comments.php' );          //Comments
            remove_menu_page( 'link-manager.php' );           //Links
            remove_menu_page( 'edit-tags.php?taxonomy=link_category' );           //Links

            //remove_submenu_page ('upload.php', 'upload.php');
            //remove_submenu_page ('upload.php', 'media-new.php');
            //remove_submenu_page ('users.php', 'users.php');
            //remove_submenu_page ('users.php', 'user-new.php');
            //remove_submenu_page ('users.php', 'profile.php');
            
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

// Removes Screen Meta Links to Users
    if ( ! function_exists( 'scm_admin_remove_meta' ) ) {
        function scm_admin_remove_meta(){

            if( current_user_can( 'manage_options' ) )
                return;

            echo '<style>#screen-meta-links{display: none !important;}</style>';
        }
    }

// Hides Administrator From User List
    if ( ! function_exists( 'scm_admin_hide_from_users' ) ) {
        function scm_admin_hide_from_users($user_search) {
            $user = wp_get_current_user();
            if ($user->ID!=1) { // Is not administrator, remove administrator
                global $wpdb;
                $user_search->query_where = str_replace('WHERE 1=1',
                    "WHERE 1=1 AND {$wpdb->users}.ID<>1",$user_search->query_where);
            }
        }
    }

// Hides Tools from Toolbar (Top Bar)
    if ( ! function_exists( 'scm_admin_hide_tools' ) ) {
        function scm_admin_hide_tools( $wp_admin_bar ) {
            $wp_admin_bar->remove_node( 'wp-logo' );
            $wp_admin_bar->remove_node( 'comments' );
            $wp_admin_bar->remove_node( 'new-post' );
            $wp_admin_bar->remove_node( 'new-media' );
            $wp_admin_bar->remove_node( 'new-page' );
            $wp_admin_bar->remove_node( 'view' );
            //$wp_admin_bar->remove_node( 'new-sections' );
        }
    }


// *********************************************
// UPLOAD
// *********************************************
    

    /*if ( ! function_exists( 'scm_current_screen' ) ) {
        function scm_current_screen( $current_screen ){
            global $SCM_current_screen;

            $SCM_current_screen = $current_screen;

            //printPre( $current_screen );
        }
    }*/


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
    if ( ! function_exists( 'scm_admin_upload_sizes' ) ) {
        function scm_admin_upload_sizes(){

            add_image_size('square', 700, 700, true);
            add_image_size('square-medium', 500, 500, true);
            add_image_size('square-small', 300, 300, true);
            add_image_size('square-thumb', 150, 150, true);
            //add_image_size('big', 700, 700, false);

        }
    }

    if ( ! function_exists( 'scm_admin_custom_sizes' ) ) {
        function scm_admin_custom_sizes( $sizes ) {
            return array_merge( $sizes, array(
                'square' => __( 'Quadrata', SCM_THEME ),
                'square-medium' => __( 'Quadrata Media', SCM_THEME ),
                'square-small' => __( 'Quadrata Piccola', SCM_THEME ),
                'square-thumb' => __( 'Quadrata Thumb', SCM_THEME ),
            ) );
        }
    }

    //Change the Name of the Uploaded File
    /*if ( ! function_exists( 'scm_upload_set_filename' ) ) {
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

//Checks if ACF Font Awesome Add On is active
    if ( ! function_exists( 'scm_admin_plugins' ) ) {
        function scm_admin_plugins(){
            global $SCM_plugin_fa;

            $SCM_plugin_fa = is_plugin_active( 'advanced-custom-fields-font-awesome/acf-font-awesome.php' );
            
        }
    }

?>
