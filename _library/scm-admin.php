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
*   1.0 Users
*   2.0 Uploads
*   3.0 Debug
*
*****************************************************
*/

// *****************************************************
// *      0.0 ACTIONS AND FILTERS
// *****************************************************


    add_filter( 'wp_mail_from', 'scm_admin_mail_from' );
    add_filter( 'wp_mail_from_name', 'scm_admin_mail_from_name' );
        
    add_filter( 'wp_calculate_image_sizes', 'scm_admin_upload_adjust_sizes', 10 , 2 );
    add_filter( 'wp_handle_upload', 'scm_admin_upload_max_size', 3 );
    add_filter( 'option_uploads_use_yearmonth_folders', '__return_false', 100 );
    add_filter( 'intermediate_image_sizes_advanced', 'scm_admin_upload_def_sizes' );
    add_action( 'admin_init', 'scm_admin_upload_cust_sizes' );
    add_filter( 'image_size_names_choose', 'scm_admin_upload_cust_names' );
    add_filter( 'upload_dir', 'scm_admin_upload_dir', 2 );
    
    add_action( 'shutdown', 'scm_admin_debug_hooks');

/*********************** AUTO NAV - UNDER COSTRUCTION ***/

/*
    add_action( 'after_setup_theme', 'scm_nav_auto_menu' ); // TESTING

    if ( ! function_exists( 'scm_nav_auto_menu' ) ) {
        function scm_nav_auto_menu(){

            //if( !scm_field( 'menu-auto', 'options' ) )
                //return;


            //$locations = get_nav_menu_locations();
            $locations = get_theme_mod('nav_menu_locations');
            $menu = get_term( $locations[ 'auto' ], 'nav_menu' );

            if( $menu && SCM_LEVEL === SCM_ROLE_SUPER && $pagenow == 'nav-menus.php' ){

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

// *****************************************************
// *      1.0 USERS
// *****************************************************

    if ( ! function_exists( 'scm_admin_mail_from_name' ) ) {
        function scm_admin_mail_from_name() {
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

// *****************************************************
// *      2.0 UPLOAD
// *****************************************************

    if ( ! function_exists( 'scm_admin_upload_adjust_sizes' ) ) {
        function scm_admin_upload_adjust_sizes( $sizes, $size ) {

            $width = $size[0];

            if ( 'page' === get_post_type() ) {
                840 <= $width && $sizes = '(max-width: 709px) 85vw, (max-width: 909px) 67vw, (max-width: 1362px) 62vw, 840px';
            }else{
                840 > $width && 600 <= $width && $sizes = '(max-width: 709px) 85vw, (max-width: 909px) 67vw, (max-width: 984px) 61vw, (max-width: 1362px) 45vw, 600px';
                600 > $width && $sizes = '(max-width: ' . $width . 'px) 85vw, ' . $width . 'px';
            }

            return $sizes;
        }
    }
                                                                                                
//Change the Upload Folder to a Type Folder
    if ( ! function_exists( 'scm_admin_upload_dir' ) ) {
        function scm_admin_upload_dir($args){

            $arr = thePost();

            $dir = '';
            
            if($arr){
                $type = $arr['type'];        
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

// *****************************************************
// *      3.0 DEBUG
// *****************************************************

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
