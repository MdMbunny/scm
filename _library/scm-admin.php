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

show_admin_bar(false);

$SCM_MENU_ORDER = array(
    'scm' => array(
        'index.php', // Dashboard
        'scm-options-intro',
        'scm-default-types',
        'scm-templates-general',
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


// *****************************************************
// *      0.0 ACTIONS AND FILTERS
// *****************************************************

    //add_filter('login_redirect', 'scm_login_redirect', 10, 3 );
    add_action( 'admin_init', 'scm_admin_redirect' );
    add_action( 'admin_init', 'scm_admin_plugins' );

    add_filter( 'wp_mail_from', 'scm_admin_mail_from' );
    add_filter( 'wp_mail_from_name', 'scm_admin_mail_from_name' );

    
    add_action( 'admin_enqueue_scripts', 'scm_admin_register_assets', 998 );
    add_action( 'login_enqueue_scripts', 'scm_login_register_assets', 10 );    

    add_action( 'admin_action_scm_admin_duplicate_post', 'scm_admin_duplicate_post' );
    add_filter( 'page_row_actions', 'scm_admin_duplicate_post_link', 10, 2 );
    add_filter( 'post_row_actions', 'scm_admin_duplicate_post_link', 10, 2 );
    
    add_action( 'admin_menu', 'scm_admin_menu_remove' );
    add_action( 'admin_menu', 'scm_admin_menu');
    add_filter('custom_menu_order', 'scm_admin_menu_order');
    add_filter('menu_order', 'scm_admin_menu_order');

    add_action( 'wp_dashboard_setup', 'scm_admin_hide_dashboard_widgets' );
    add_action( 'admin_head', 'scm_admin_hide_from_users' );
    add_action( 'pre_user_query', 'scm_admin_hide_admin_from_users' );
    add_action( 'admin_bar_menu', 'scm_admin_hide_tools', 999 );

    //add_filter( 'wp_handle_upload_prefilter', 'scm_upload_pre', 2 );
    //add_filter( 'wp_handle_upload', 'scm_upload_post', 2 );
    add_filter( 'wp_handle_upload', 'scm_admin_upload_max_size', 3 );
    add_filter( 'option_uploads_use_yearmonth_folders', '__return_false', 100 );
    add_filter( 'intermediate_image_sizes_advanced', 'scm_admin_upload_def_sizes' );
    add_action( 'admin_init', 'scm_admin_upload_cust_sizes' );
    add_filter( 'image_size_names_choose', 'scm_admin_upload_cust_names' );
    add_filter( 'upload_dir', 'scm_admin_upload_dir', 2 );
    //add_action( 'before_delete_post', 'scm_admin_upload_delete' );   
    
    add_action( 'shutdown', 'scm_admin_debug_hooks');


/***********************/

    //add_action( 'after_setup_theme', 'scm_nav_auto_menu' ); // TESTING

    if ( ! function_exists( 'scm_nav_auto_menu' ) ) {
        function scm_nav_auto_menu(){

            /*if( !scm_field( 'menu-auto', 'options' ) )
                return;*/


            //$locations = get_nav_menu_locations();
            $locations = get_theme_mod('nav_menu_locations');
            $menu = get_term( $locations[ 'auto' ], 'nav_menu' );

            if( $menu && current_user_can( 'manage_options' ) && $pagenow == 'nav-menus.php' ){

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

                    /*$sub_item = wp_update_nav_menu_item($menu, 0, array(
                        'menu-item-title' => $subtitle,
                        'menu-item-url' => '#' . $subid,
                        'menu-item-type' => 'custom',
                        'menu-item-status' => 'publish',
                        'menu-item-parent-id' => $item,
                        )
                    );*/

                $locations[ 'auto' ] = $menu;
                set_theme_mod( 'nav_menu_locations', $locations );

            }
        }
    }
   

// *****************************************************
// *      1.0 FUNCTIONS
// *****************************************************

    /* Redirect hi cap Users to Admin when they log in */
    if ( ! function_exists( 'scm_login_redirect' ) ) {
        function scm_login_redirect( $url, $request, $user ){
            if( $user && is_object( $user ) && is_a( $user, 'WP_User' ) ) {
                if( $user->has_cap( 'administrator' ) ) {
                    return redirectUser('admin');
                } elseif( $user->has_cap( 'upload_files' ) && startsWith( $request, SCM_SITE . '/wp-admin' ) ) {
                    return redirectUser('staff');
                }
            }
            return redirectUser('');
        }
    }    

    /* Redirect low cap Users to Home Page when they log in*/
    if ( ! function_exists( 'scm_admin_redirect' ) ) {
        function scm_admin_redirect() {
            if (!current_user_can('upload_files') && $_SERVER['DOING_AJAX'] != '/wp-admin/admin-ajax.php') {
                redirectUser('user');
                exit;
            }
        }
    }

    if ( ! function_exists( 'scm_admin_mail_from_name' ) ) {
        function scm_admin_mail_from_name() {
            //$name = 'yourname';
            $name = get_option('blogname');
            $name = esc_attr($name);
            return $name;
        }
    }

    if ( ! function_exists( 'scm_admin_mail_from' ) ) {
        function scm_admin_mail_from() {
            $email = scm_field( 'opt-staff-email', '', 'option' );
            $email = is_email($email);
            return $email;
        }
    }


// *********************************************
//  Enqueue CSS and Scripts
// *********************************************

    if ( ! function_exists( 'scm_admin_register_assets' ) ) {
        function scm_admin_register_assets() {

            wp_register_style('font-awesome', SCM_URI_FONT . 'font-awesome-4.6.1/css/font-awesome.min.css', false, null );
            wp_enqueue_style( 'font-awesome' );

            wp_register_style( 'scm-admin', SCM_URI_CSS . 'scm-admin.css', false, SCM_SCRIPTS_VERSION );
            wp_enqueue_style('scm-admin');
            wp_register_style( 'scm-admin-child', SCM_URI_CSS_CHILD . 'admin.css', false, SCM_SCRIPTS_VERSION );
            wp_enqueue_style('scm-admin-child');

        }
    } 

    if ( ! function_exists( 'scm_login_register_assets' ) ) {
        function scm_login_register_assets() {

            wp_register_style( 'scm-login', SCM_URI_CSS . 'scm-login.css', false, SCM_SCRIPTS_VERSION );
            wp_enqueue_style('scm-login');
            
            wp_register_style( 'scm-login-child', SCM_URI_CSS_CHILD . 'login.css', false, SCM_SCRIPTS_VERSION );
            wp_enqueue_style('scm-login-child');            
            
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
            if( current_user_can( 'manage_options' ) || current_user_can( 'publish_' . $post->post_type ) ) {
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

// Set Menu Elements Order
    if ( ! function_exists( 'scm_admin_menu_order' ) ) {
        function scm_admin_menu_order($menu_ord) {
            if (!$menu_ord) return true;
            global $SCM_MENU_ORDER;

            $SCM_MENU_ORDER = apply_filters( 'scm_filter_admin_menu_order', $SCM_MENU_ORDER );

            return call_user_func_array('array_merge', $SCM_MENU_ORDER);

        }
    }

// Set Menu Elements
    if ( ! function_exists( 'scm_admin_menu' ) ) {
        function scm_admin_menu(){

            global $menu;
            ksort( $menu );

            $menu[] = array('','read',"separator3",'','wp-menu-separator');
            $menu[] = array('','read',"separator4",'','wp-menu-separator');
            $menu[] = array('','read',"separator5",'','wp-menu-separator');
            $menu[] = array('','read',"separator6",'','wp-menu-separator');
            $menu[] = array('','read',"separator7",'','wp-menu-separator');
            

            ksort( $menu );
        }
    }

// Remove Menu Elements
    if ( ! function_exists( 'scm_admin_menu_remove' ) ) {
        function scm_admin_menu_remove(){

            global $SCM_types;

            //global $submenu;


            remove_menu_page( 'index.php' );                                    //Dashboard
            remove_menu_page( 'edit.php' );                                     //Posts

            remove_menu_page( 'edit-comments.php' );                            //Comments
            remove_menu_page( 'link-manager.php' );                             //Links
            remove_menu_page( 'edit-tags.php?taxonomy=link_category' );         //Links

            remove_menu_page( 'edit-tags.php?taxonomy=category');               //Categories
            remove_menu_page( 'edit-tags.php?taxonomy=post_tag');               //Tags
            
        }
    }


// Remove Dashboard Widgets
    if ( ! function_exists( 'scm_admin_hide_dashboard_widgets' ) ) {
        function scm_admin_hide_dashboard_widgets(){
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
    if ( ! function_exists( 'scm_admin_hide_from_users' ) ) {
        function scm_admin_hide_from_users(){

            global $SCM_screen;
            if( $SCM_screen == '/wp-admin/options-media.php' ){
                echo '<style>

                    #wpbody-content .wrap form tr > td{
                        padding: 0;
                        margin: 0;
                    }

                    #wpbody-content .wrap form > h2,
                    #wpbody-content .wrap form > p,
                    #wpbody-content .wrap form tr > *:not(td),
                    #wpbody-content .wrap form tr > td > *:not(#oir-remove-image-sizes){
                        display: none;
                    }

                    #oir-remove-image-sizes, #oir-remove-image-sizes+p, #oir-remove-image-sizes+p+p{
                        display: block !important;
                    }

                </style>';

            }
           
            if( !current_user_can( 'manage_options' ) )
                echo '<style>#screen-meta-links{display: none !important;}</style>';

            if (!current_user_can('update_core')) {
                remove_action( 'admin_notices', 'update_nag', 3 );
            }            
        }
    }

// Hides Administrator From User List
    if ( ! function_exists( 'scm_admin_hide_admin_from_users' ) ) {
        function scm_admin_hide_admin_from_users($user_search) {
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
        }
    }


// *********************************************
// UPLOAD
// *********************************************
    
    /*if ( ! function_exists( 'scm_admin_upload_delete' ) ) {
        function scm_admin_upload_delete( $postid ){

            global $post_type;   
            if ( $post_type != 'gallerie' ) return;

            $gall = scm_field('galleria-images', $postid);
            foreach ($gall as $key => $value) {
                wp_delete_attachment( $value->ID, true );
            }

        }
    }*/

// Change the upload path to the one we want
    /*if ( ! function_exists( 'scm_upload_pre' ) ) {
        function scm_upload_pre( $file ){

            add_filter( 'upload_dir', 'scm_admin_upload_dir' );

            return $file;

        }
    }*/
 
// Change the upload path back to the one Wordpress uses by default
    /*if ( ! function_exists( 'scm_upload_post' ) ) {
        function scm_upload_post( $fileinfo ){

            remove_filter( 'upload_dir', 'scm_admin_upload_dir' );

            return $fileinfo;
        }
    }*/

    add_filter( 'wp_calculate_image_sizes', 'scm_admin_upload_adjust_sizes', 10 , 2 );

    if ( ! function_exists( 'scm_admin_upload_adjust_sizes' ) ) {
        function scm_admin_upload_adjust_sizes( $sizes, $size ) {

            $width = $size[0];

            840 <= $width && $sizes = '(max-width: 709px) 85vw, (max-width: 909px) 67vw, (max-width: 1362px) 62vw, 840px';
            840 > $width && 600 <= $width && $sizes = '(max-width: 709px) 85vw, (max-width: 909px) 67vw, (max-width: 984px) 61vw, (max-width: 1362px) 45vw, 600px';
            600 > $width && $sizes = '(max-width: ' . $width . 'px) 85vw, ' . $width . 'px';

            /*if ( 'page' === get_post_type() ) {
                840 > $width && $sizes = '(max-width: ' . $width . 'px) 85vw, ' . $width . 'px';
            } else {
                840 > $width && 600 <= $width && $sizes = '(max-width: 709px) 85vw, (max-width: 909px) 67vw, (max-width: 984px) 61vw, (max-width: 1362px) 45vw, 600px';
                600 > $width && $sizes = '(max-width: ' . $width . 'px) 85vw, ' . $width . 'px';
            }*/

            return $sizes;
        }
    }


                                                                                                
//Change the Upload Folder to a Type Folder
    if ( ! function_exists( 'scm_admin_upload_dir' ) ) {
        function scm_admin_upload_dir($args){

            $arr = thePost();
            //$to3 = scm_field('opt-to3-gallerie-folder', 0, 'options');

            $dir = '';
            
            if($arr){
                $id = $arr['ID'];
                $type = $arr['type'];        
                $slug = $arr['slug'];
                $tax = $arr['taxonomy'];
                if(gettype($tax) == 'array') $tax = implode('-', $tax);
                
                if( $type ){
                    
                    $dir .= '/' . $type;
                    
                    if( $tax )
                        $dir .= '/' . $tax;
                    
                    // Il problema è che quando crei una nuova Galleria e carichi delle foto, il post non esiste ancora e quindi senza slug non puoi creare una cartella apposta
                    //if( $to3 && $type == 'gallerie' && ( $slug || $id ) )
                        //$dir .= '/' . ( $slug ?: $id );

                }

            }else{

                $dir = '/options';
            }

            if( $dir ){

                $args['subdir']  = $dir;
                $args['path']   .= $dir; 
                $args['url']    .= $dir;

            }

            return $args;
        }
    }





//Managing Sizes for Uploaded Images

    if ( ! function_exists( 'scm_admin_upload_def_sizes' ) ) {
        function scm_admin_upload_def_sizes( $sizes ) {
            
            $sizes['thumbnail']['width'] = 300;
            $sizes['medium']['width'] = 1024;
            $sizes['large']['width'] = 1200;
            $sizes['thumbnail']['height'] = $sizes['medium']['height'] = $sizes['thumbnail']['large'] = 0;
             
            return $sizes;
        }
    }

    if ( ! function_exists( 'scm_admin_upload_cust_sizes' ) ) {
        function scm_admin_upload_cust_sizes(){

            add_image_size('small', 700, 0, false);
            //add_image_size('square', 700, 700, true);
            //add_image_size('square-medium', 500, 500, true);
            //add_image_size('square-small', 300, 300, true);
            //add_image_size('square-thumb', 150, 150, true);

        }
    }

    if ( ! function_exists( 'scm_admin_upload_cust_names' ) ) {
        function scm_admin_upload_cust_names( $sizes ) {

            return array_merge( $sizes, array(

                'small' => __( 'Small', SCM_THEME ),
                //'square' => __( 'Quadrata', SCM_THEME ),
                //'square-medium' => __( 'Quadrata Media', SCM_THEME ),
                //'square-small' => __( 'Quadrata Piccola', SCM_THEME ),
                //'square-thumb' => __( 'Quadrata Thumb', SCM_THEME ),

            ) );

        }
    }

//Set the Max Size for Uploaded Images and Delete Original Files
    if ( ! function_exists( 'scm_admin_upload_max_size' ) ) {
        function scm_admin_upload_max_size( $params ){
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
    }

//Checks if ACF Font Awesome Add On is active
    if ( ! function_exists( 'scm_admin_plugins' ) ) {
        function scm_admin_plugins(){
            global $SCM_plugin_fa;

            $SCM_plugin_fa = is_plugin_active( 'advanced-custom-fields-font-awesome/acf-font-awesome.php' );
            
        }
    }



// *********************************************
// DEBUG
// *********************************************

    if ( ! function_exists( 'scm_admin_debug_hooks' ) ) {
        function scm_admin_debug_hooks() {
            global $SCM_debug;
            if($SCM_debug){
                foreach( $GLOBALS['wp_actions'] as $action => $count )
                    consoleLog($action . ' > ' . $count);
            }

        }
    }


?>
