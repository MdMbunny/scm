<?php
/**
 * @package SCM
 */

// *****************************************************
// *    SCM INSTALL
// *****************************************************

/*
*****************************************************
*
*   0.0 Actions and Filters
*   1.0 Theme Installation
*   2.0 Custom Types Installation
*   3.0 Option Pages Installation
*   4.0 ACF Installation
*   5.0 ACF Hooks
**      5.1 Load Field
**      5.2 Save Post
**      5.3 Query Field
**      5.4 Format Value
*   6.0 ACF Fields Installation
*   7.0 Plugins Installation
*
*****************************************************
*/

// *****************************************************
// *      0.0 ACTIONS AND FILTERS
// *****************************************************


    remove_action( 'wp_head', 'print_emoji_detection_script', 7 );                                              // 0.0 Removing unused WP actions
    remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
    remove_action( 'wp_print_styles', 'print_emoji_styles' );
    remove_action( 'admin_print_styles', 'print_emoji_styles' );
    remove_action( 'wp_head', 'feed_links_extra', 3 );
    remove_action( 'wp_head', 'feed_links', 2 );
    remove_action( 'wp_head', 'wlwmanifest_link' );
    remove_action( 'wp_head', 'rsd_link' );
    remove_action( 'wp_head', 'wp_generator' );

    add_action( 'acf/include_fields', 'scm_typekit_install' );                                                  // 1.0      Creo istanza Typekit class. Se prima installazione reindirizzo a principale pagina opzioni
    add_action( 'acf/include_fields', 'scm_roles_install' );                                                    // 1.0      Assegno Ruoli
    
    add_action( 'acf/include_fields', 'scm_option_pages_install' );                                             // 3.0      Creo Main Options Pages ( SCM, Types, Taxonomies )
    
    add_action( 'acf/include_fields', 'scm_default_types_install' );                                            // 2.0      Installo Default Types e Taxonomies

    add_action( 'acf/include_fields', 'scm_acf_types_install' );                                                // 6.0      Creo, registro e assegno Custom Fields a Custom Types
    add_action( 'acf/include_fields', 'scm_custom_types_install' );                                             // 2.0      Installo Custom Types

    add_action( 'acf/include_fields', 'scm_acf_taxonomies_install' );                                           // 6.0      Creo, registro e assegno Custom Fields a Custom Taxonomies
    add_action( 'acf/include_fields', 'scm_custom_taxonomies_install' );                                        // 2.0      Installo Custom Taxonomies

    add_action( 'acf/include_fields', 'scm_types_capabilities' );
    
    add_action( 'acf/include_fields', 'scm_option_subpages_install' );                                          // 3.0      Creo Sub Options Pages

    add_action( 'acf/include_fields', 'scm_acf_install' );                                                      // 6.0      Creo, registro e assegno Custom Fields a tutto il resto
    
    //add_filter( 'acf/settings/dir', 'scm_acf_settings_dir' );                                                   // 4.0      Imposto ACF Plugin Directory
    //add_filter( 'acf/settings/path', 'scm_acf_settings_path' );                                                 // 4.0      Imposto ACF Plugin Path
    //add_filter('acf/settings/show_admin', '__return_false');                                                  // 4.0      Hide ACF from Admin
    add_filter( 'bfa_force_fallback', 'scm_force_fallback' );                                                   // 4.0      FA Add On Fix
    
    add_filter( 'acf/load_field', 'scm_acf_loadfield_hook_choices_get', 100) ;                                  // 5.1
    add_filter( 'acf/load_field/type=repeater', 'scm_acf_loadfield_hook_repeater_list', 100 );
    //add_filter( 'acf/load_field/type=flexible_content', 'scm_acf_loadfield_hook_flexible_list', 100 );
    
    add_filter( 'acf/load_field/type=font-awesome', 'scm_acf_loadfield_hook_fontawesome_list', 150 );
   

    //add_action( 'acf/save_post', 'scm_acf_savepost_hook_media', 1) ;   
    //add_action( 'acf/save_post', 'scm_acf_savepost_hook_templates_new', 100) ;
    add_action( 'acf/save_post', 'scm_acf_savepost_hook_templates', 11) ;                                       // 5.2
    //add_action( 'acf/save_post', 'scm_acf_savepost_hook_all_taxonomies', 10 );

    add_filter('acf/fields/post_object/query', 'scm_acf_queryfield_hook_objects', 10, 3);                       // 5.3

    add_filter( 'acf/format_value/type=text', 'scm_acf_formatvalue_hook_text', 10, 3 );                         // 5.4
    add_filter( 'acf/format_value/type=textarea', 'scm_acf_formatvalue_hook_editor', 10, 3 );
    add_filter( 'acf/format_value/type=limiter', 'scm_acf_formatvalue_hook_editor', 10, 3 );
    add_filter( 'acf/format_value/type=wysiwyg', 'scm_acf_formatvalue_hook_editor', 10, 3 );

    add_action( 'tgmpa_register', 'scm_plugins_install' );                                                      // 7.0      Installo Plugins
 
    add_action( 'after_setup_theme', 'scm_theme_install' );                                                     // 1.0      Attivazione SCM Theme


// *****************************************************
// *      1.0 THEME INSTALLATION
// *****************************************************


    if ( ! function_exists( 'scm_typekit_install' ) ) {
        function scm_typekit_install() {

// *** Install TypeKit

            global $SCM_typekit;

            $SCM_typekit = new Typekit();

        }
    }


            
// *** Adminitration Roles

    if ( ! function_exists( 'scm_roles_install' ) ) {
        function scm_roles_install() {

            // Crea una Option Page dove poter resettare i ruoli (cancellandoli tutti e ricreando quelli di default)

            /*remove_role('editor');
            remove_role('author');
            remove_role('contributor');
            remove_role('subscriber');
            remove_role('staff');
            remove_role('member');
            remove_role('utente');*/
            
            if( !get_role( 'staff' ) ){
                add_role(
                    'staff',
                    __( 'Staff', SCM_THEME ),
                    array(
                        'read' => true,
                        'read_private_pages' => true,
                        'read_private_posts' => true,
                        'list_users' => true,
                        'remove_users' => true,
                        'delete_users' => true,
                        'create_users' => true,
                        'edit_users' => true,
                        'upload_files' => true,
                        'manage_categories' => true,
                    )
                );                
            }
            
            if( !get_role( 'member' ) ){
                add_role(
                    'member',
                    __( 'Member', SCM_THEME ),
                    array(
                        'read' => true,
                        'read_private_pages' => true,
                        'read_private_posts' => true,
                        'upload_files' => true,
                        'manage_categories' => true,
                    )
                );                
            }

            if( !get_role( 'utente' ) ){
                add_role(
                    'utente',
                    __( 'Utente', SCM_THEME ),
                    array(
                        'read' => true,
                        'read_private_pages' => true,
                        'read_private_posts' => true,
                    )
                );
                
            }            
        }
    }
        
// *** Theme Activation

    if ( ! function_exists( 'scm_theme_install' ) ) {
        function scm_theme_install() {

            global $SCM_version, $SCM_types;

            //update_option( 'scm-version', '1.0' ); // DEBUG MODE: resets scm-version to set default capabilities

            $themeStatus = get_option( 'scm-settings-installed' );
            $version = get_option( 'scm-version' );

            if( $SCM_version != $version ){

                update_option( 'scm-version', $SCM_version );

                remove_role('editor');
                remove_role('author');
                remove_role('contributor');
                remove_role('subscriber');
                remove_role('staff');
                remove_role('member');
                remove_role('utente');

            }

            if ( ! $themeStatus ) {
                update_option( 'scm-settings-installed', 1 );
                wp_redirect(admin_url('themes.php?page=scm-install-plugins'));
                die;
            }
        }
    }

// *****************************************************
// *      2.0 CUSTOM TYPES INSTALLATION
// *****************************************************


    if ( ! function_exists( 'scm_default_types_install' ) ) {
        function scm_default_types_install(){

            // DEFAULT GLOBAL ARRAYS
 
            global $SCM_types;

            $SCM_types = array(
                'objects' => array(),
                'private' => array(),
                'public' => array(),
                'custom' => array(),
                'all' => array(
                    'wpcf7_contact_form'    => 'Contact Form',
                ),
                'complete' => array(
                    'page'                  => 'Pagine',
                    'wpcf7_contact_form'    => 'Contact Form',
                ),
            );

            // DEBUG - RESET DB

            /*update_field( 'types-list', array(), 'options' );
            update_field( 'taxonomies-list', array(), 'options' );*/

            // SET DEFAULT

            consoleDebug('install default types and taxes');

            $default_types = array(
                'sections'              => array( 'admin' => 1,      'custom' => 1,         'add_cap' => 0,         'active' => 1,      'public' => 0,       'hidden' => 0,      'post' => 0,       'singular' => __('Section', SCM_THEME),                'plural' => __('Sections', SCM_THEME),              'slug' => 'sections',           'icon' => 'schedule',           'orderby' => 'title',       'ordertype' => '',      'menupos' => 0,         'menu' => 'pages',                                                                                                           ),
                'modules'               => array( 'admin' => 0,      'custom' => 1,         'add_cap' => 0,         'active' => 1,      'public' => 0,       'hidden' => 0,      'post' => 0,       'singular' => __('Module', SCM_THEME),                 'plural' => __('Modules', SCM_THEME),               'slug' => 'modules',            'icon' => 'screenoptions',      'orderby' => 'title',       'ordertype' => '',      'menupos' => 0,         'menu' => 'pages',                                                                                                           ),
                'banners'               => array( 'admin' => 0,      'custom' => 1,         'add_cap' => 0,         'active' => 1,      'public' => 0,       'hidden' => 0,      'post' => 0,       'singular' => __('Banner', SCM_THEME),                 'plural' => __('Banners', SCM_THEME),               'slug' => 'banners',            'icon' => 'align-center',       'orderby' => 'title',       'ordertype' => '',      'menupos' => 0,         'menu' => 'pages',                                                                                                           ),
                'news'                  => array( 'admin' => 0,      'custom' => 1,         'add_cap' => 1,         'active' => 0,      'public' => 1,       'hidden' => 0,      'post' => 1,       'singular' => __('News', SCM_THEME),                   'plural' => __('News', SCM_THEME),                  'slug' => 'news',               'icon' => 'megaphone',          'orderby' => 'date',        'ordertype' => '',      'menupos' => 0,         'menu' => 'types',                                                                                                           ),
                'slides'                => array( 'admin' => 0,      'custom' => 1,         'add_cap' => 1,         'active' => 1,      'public' => 1,       'hidden' => 0,      'post' => 1,       'singular' => __('Slide', SCM_THEME),                  'plural' => __('Slides', SCM_THEME),                'slug' => 'slides',             'icon' => 'format-image',       'orderby' => 'date',        'ordertype' => '',      'menupos' => 0,         'menu' => 'media',                                                                                                           ),
                'gallerie'              => array( 'admin' => 0,      'custom' => 1,         'add_cap' => 1,         'active' => 1,      'public' => 1,       'hidden' => 0,      'post' => 1,       'singular' => __('Galleria', SCM_THEME),               'plural' => __('Gallerie', SCM_THEME),              'slug' => 'gallerie',           'icon' => 'format-gallery',     'orderby' => 'title',       'ordertype' => '',      'menupos' => 0,         'menu' => 'media',                                                                                                           ),
                'video'                 => array( 'admin' => 0,      'custom' => 1,         'add_cap' => 1,         'active' => 1,      'public' => 1,       'hidden' => 0,      'post' => 1,       'singular' => __('Video', SCM_THEME),                  'plural' => __('Video', SCM_THEME),                 'slug' => 'video',              'icon' => 'video-alt3',         'orderby' => 'title',       'ordertype' => '',      'menupos' => 0,         'menu' => 'media',                                                                                                           ),
                'documenti'             => array( 'admin' => 0,      'custom' => 1,         'add_cap' => 1,         'active' => 1,      'public' => 1,       'hidden' => 0,      'post' => 1,       'singular' => __('Documento', SCM_THEME),              'plural' => __('Documenti', SCM_THEME),             'slug' => 'documenti',          'icon' => 'portfolio',          'orderby' => 'title',       'ordertype' => '',      'menupos' => 0,         'menu' => 'media',                                                                                                           ),
                'rassegne-stampa'       => array( 'admin' => 0,      'custom' => 1,         'add_cap' => 1,         'active' => 1,      'public' => 1,       'hidden' => 0,      'post' => 1,       'singular' => __('Rassegna Stampa', SCM_THEME),        'plural' => __('Rassegne Stampa', SCM_THEME),       'slug' => 'rassegne-stampa',    'icon' => 'id',                 'orderby' => 'date',        'ordertype' => '',      'menupos' => 0,         'menu' => 'media',      'short-singular' => __('Rassegna', SCM_THEME),     'short-plural' => __('Rassegne', SCM_THEME),      ),
                'soggetti'              => array( 'admin' => 0,      'custom' => 1,         'add_cap' => 1,         'active' => 1,      'public' => 1,       'hidden' => 0,      'post' => 0,       'singular' => __('Soggetto', SCM_THEME),               'plural' => __('Soggetti', SCM_THEME),              'slug' => 'soggetti',           'icon' => 'groups',             'orderby' => 'title',       'ordertype' => '',      'menupos' => 1,         'menu' => 'contacts',                                                                                                        ),
                'luoghi'                => array( 'admin' => 0,      'custom' => 1,         'add_cap' => 1,         'active' => 1,      'public' => 1,       'hidden' => 0,      'post' => 0,       'singular' => __('Luogo', SCM_THEME),                  'plural' => __('Luoghi', SCM_THEME),                'slug' => 'luoghi',             'icon' => 'location',           'orderby' => 'title',       'ordertype' => '',      'menupos' => 1,         'menu' => 'contacts',                                                                                                        ),
            );

            $default_taxonomies = array(
                'sections-cat'          => array( 'template' => 0,       'add_cap' => 0,        'active' => 1,      'hierarchical' => 0,          'plural' => __('Categorie Sezioni', SCM_THEME),          'singular' => __('Categoria Sezioni', SCM_THEME),      'slug' => 'sections-cat',              'types' => array( 'sections' ),         ),
                'sliders'               => array( 'template' => 0,       'add_cap' => 0,        'active' => 1,      'hierarchical' => 1,          'plural' => __('Sliders', SCM_THEME),                    'singular' => __('Slider', SCM_THEME),                 'slug' => 'sliders',                   'types' => array( 'slides' )            ),
                'soggetti-tip'          => array( 'template' => 0,       'add_cap' => 0,        'active' => 1,      'hierarchical' => 1,          'plural' => __('Tipologie Soggetti', SCM_THEME),         'singular' => __('Tipologia Soggetti', SCM_THEME),     'slug' => 'soggetti-tip',              'types' => array( 'soggetti' )          ),
                'luoghi-tip'            => array( 'template' => 0,       'add_cap' => 0,        'active' => 1,      'hierarchical' => 1,          'plural' => __('Tipologie Luoghi', SCM_THEME),           'singular' => __('Tipologia Luoghi', SCM_THEME),       'slug' => 'luoghi-tip',                'types' => array( 'luoghi' ),           ),
                'luoghi-cat'            => array( 'template' => 0,       'add_cap' => 0,        'active' => 1,      'hierarchical' => 0,          'plural' => __('Categorie Luoghi', SCM_THEME),           'singular' => __('Categoria Luoghi', SCM_THEME),       'slug' => 'luoghi-cat',                'types' => array( 'luoghi' ),           ),
                'news-cat'              => array( 'template' => 0,       'add_cap' => 0,        'active' => 0,      'hierarchical' => 0,          'plural' => __('Categorie News', SCM_THEME),             'singular' => __('Categoria News', SCM_THEME),         'slug' => 'news-cat',                  'types' => array( 'news' ),             ),
                'documenti-cat'         => array( 'template' => 0,       'add_cap' => 0,        'active' => 1,      'hierarchical' => 0,          'plural' => __('Categorie Documenti', SCM_THEME),        'singular' => __('Categoria Documenti', SCM_THEME),    'slug' => 'documenti-cat',             'types' => array( 'documenti' ),        ),
                'video-cat'             => array( 'template' => 0,       'add_cap' => 0,        'active' => 1,      'hierarchical' => 0,          'plural' => __('Categorie Video', SCM_THEME),            'singular' => __('Categoria Video', SCM_THEME),        'slug' => 'video-cat',                 'types' => array( 'video' ),            ),
                'gallerie-cat'          => array( 'template' => 0,       'add_cap' => 0,        'active' => 1,      'hierarchical' => 0,          'plural' => __('Categorie Gallerie', SCM_THEME),         'singular' => __('Categoria Gallerie', SCM_THEME),     'slug' => 'gallerie-cat',              'types' => array( 'gallerie' ),         ),
                'rassegne-cat'          => array( 'template' => 0,       'add_cap' => 0,        'active' => 1,      'hierarchical' => 0,          'plural' => __('Categorie Rassegne', SCM_THEME),         'singular' => __('Categoria Rassegne', SCM_THEME),     'slug' => 'rassegne-cat',              'types' => array( 'rassegne-stampa' ),  ),
                'rassegne-autori'       => array( 'template' => 0,       'add_cap' => 0,        'active' => 1,      'hierarchical' => 0,          'plural' => __('Autori Rassegne', SCM_THEME),            'singular' => __('Autore Rassegne', SCM_THEME),        'slug' => 'autori',                    'types' => array( 'rassegne-stampa' ),  ),
                'rassegne-testate'      => array( 'template' => 0,       'add_cap' => 0,        'active' => 1,      'hierarchical' => 0,          'plural' => __('Testate Rassegne', SCM_THEME),           'singular' => __('Testata Rassegne', SCM_THEME),       'slug' => 'testate',                   'types' => array( 'rassegne-stampa' ),  ),
            );

            
            // FILTER DEFAULT

            $default_types = apply_filters( 'scm_filter_default_types', $default_types );
            $default_taxonomies = apply_filters( 'scm_filter_default_taxonomies', $default_taxonomies );


            // DISABLE DEFAULT OPTIONS

            $types = subArray( $default_types, 'plural', 0, array( 'admin' => 0 ) );

            $group_types = scm_acf_group( 'Disable Default Types', 'default-types-options' );
            $group_types['location'][] = scm_acf_group_location( 'scm-default-types', 'options_page' );
            $group_types['fields'] = scm_acf_options_default_types( $types, $types );

            scm_acf_group_register( $group_types );
            $saved_types = scm_field( 'default-types-list', 0, 'options' );
            if( isset( $saved_types ) && is_array( $saved_types ) ){
                foreach ($saved_types as $key => $value) {
                    $default_types[ $value ] = null;
                }
            }else{
                $default_types = subArray( $default_types, '', 0, array( 'admin' => 1 ) );
            }

            $taxes = subArray( $default_taxonomies, 'plural' );

            $group_taxonomies = scm_acf_group( 'Disable Default Taxonomies', 'default-taxonomies-options' );
            $group_taxonomies['location'][] = scm_acf_group_location( 'scm-default-taxonomies', 'options_page' );
            $group_taxonomies['fields'] = scm_acf_options_default_taxonomies( $taxes, $taxes );

            scm_acf_group_register( $group_taxonomies );
            $saved_taxonomies = scm_field( 'default-taxonomies-list', 0, 'options' );
            if( isset( $saved_taxonomies ) && is_array( $saved_taxonomies ) ){
                foreach ($saved_taxonomies as $key => $value) {
                    $default_taxonomies[ $value ] = null;
                }
            }else{
                $default_taxonomies = array();
            }
            


            // INSTALL

            scm_types_install( $default_types );
            scm_taxonomies_install( $default_taxonomies );

        }
    }

    if ( ! function_exists( 'scm_custom_types_install' ) ) {
        function scm_custom_types_install(){

            consoleDebug('install custom types');

            $saved_types = scm_field( 'custom-types-list', array(), 'options' );
            
            scm_types_install( $saved_types );
        }
    }

    if ( ! function_exists( 'scm_custom_taxonomies_install' ) ) {
        function scm_custom_taxonomies_install(){

            consoleDebug('install custom taxes');

            $saved_taxonomies = scm_field( 'custom-taxonomies-list', array(), 'options' );

            scm_taxonomies_install( $saved_taxonomies );

        }
    }


    if ( ! function_exists( 'scm_types_install' ) ) {
        function scm_types_install( $types = array() ){

            global $SCM_types;

            foreach ( $types as $type ) {
                
                if( !isset( $type['plural'] ) )
                    continue;

                $plural = $type['plural'];
                $type['admin'] = (int)( isset( $type['admin'] ) && $type['admin'] );
                $type['active'] = (int)( isset( $type['active'] ) && $type['active'] );
                $type['public'] = (int)( isset( $type['public'] ) && $type['public'] );
                $type['hidden'] = (int)( isset( $type['hidden'] ) && $type['hidden'] );
                $type['orderby'] = ( isset( $type['orderby'] ) ? $type['orderby'] : 'title' );
                $type['ordertype'] = ( isset( $type['ordertype'] ) ? $type['ordertype'] : 'ASC' );
                $type['singular'] = ( isset( $type['singular'] ) ? $type['singular'] : $plural );
                $type['slug'] = ( isset( $type['slug'] ) && $type['slug'] ? sanitize_title( $type['slug'] ) : sanitize_title( $plural ) );
                $type['icon'] = ( isset( $type['icon'] ) && $type['icon'] ? '\\' . $type['icon'] : '' ) ;

                if( $type['active'] === 1 ){

                    $SCM_types['complete'][ $type['slug'] ] = $plural;
                    $SCM_types['custom'][ $type['slug'] ] = $plural;
                    $obj = $SCM_types['objects'][ $type['slug'] ] = new Custom_Type( $type );
                    $obj->CT_register();                    

                    if( $type['public'] === 1 ){

                        $SCM_types['public'][ $type['slug'] ] = __( 'Modello', SCM_THEME ) . ' ' . $plural;
                        $SCM_types['all'][ $type['slug'] ] = __( 'Modello', SCM_THEME ) . ' ' . $plural;
                        $type['plural'] = __( 'Modello', SCM_THEME ) . ' ' . $plural;
                        $type['singular'] = __( 'Modello', SCM_THEME ) . ' ' . $obj->singular;
                        $type['public'] = 0;
                        $type['hidden'] = 1;
                        $type['admin'] = 1;
                        $type['slug'] = $type['slug'] . SCM_TEMPLATE_APP;
                        $type['menupos'] = 0;
                        $type['menu'] = 0;
                        $type['post'] = 0;

                        $temp = $SCM_types['objects'][ $type['slug'] ] = new Custom_Type( $type );
                        $temp->CT_register();

                    }else{

                        $SCM_types['private'][ $type['slug'] ] = $plural;

                    }
                }
            }
        }
    }

    if ( ! function_exists( 'scm_taxonomies_install' ) ) {
        function scm_taxonomies_install( $taxonomies = array() ){

            global $SCM_types;

            foreach ( $taxonomies as $tax ) {
                
                if( !isset( $tax['plural'] ) )
                    continue;

                $plural = $tax['plural'];

                $tax['singular'] = ( isset( $tax['singular'] ) ? $tax['singular'] : $plural );
                $tax['slug'] = ( isset( $tax['slug'] ) && $tax['slug'] ? sanitize_title( $tax['slug'] ) : sanitize_title( $plural ) );
                $tax['add_cap'] = (int)( isset( $tax['add_cap'] ) && $tax['add_cap'] );
                $tax['template'] = (int)( isset( $tax['template'] ) && $tax['template'] );
                $tax['active'] = (int)( isset( $tax['active'] ) && $tax['active'] );

                if( $tax['active'] === 1 ){

                    if( $tax['hierarchical'] )
                        $obj = $SCM_types['taxonomies'][ $tax['slug'] ] = $SCM_types['categories'][ $tax['slug'] ] = new Custom_Taxonomy( $tax );
                    else
                        $obj = $SCM_types['taxonomies'][ $tax['slug'] ] = $SCM_types['tags'][ $tax['slug'] ] = new Custom_Taxonomy( $tax );

                    if( $tax['template'] === 1 ){
                        
                        $tax_type = array();

                        $tax_type['plural'] = __( 'Modello', SCM_THEME ) . ' ' . $plural;
                        $tax_type['singular'] = __( 'Modello', SCM_THEME ) . ' ' . $obj->singular;
                        $tax_type['hidden'] = 1;
                        $tax_type['admin'] = 1;
                        $tax_type['slug'] = $tax['slug'] . SCM_TEMPLATE_APP;
                        $tax_type['menu'] = 0;
                        $tax_type['post'] = 0;

                        $tax_temp = $SCM_types['objects'][ $tax_type['slug'] ] = new Custom_Type( $tax_type );
                        $tax_temp->CT_register();
                    }
                }

            }

            //scm_save_posts();
        }
    }


    if ( ! function_exists( 'scm_types_capabilities' ) ) {
        function scm_types_capabilities(){
            
            global $pagenow;
            
            if( current_user_can( 'manage_options' ) && $pagenow == 'admin.php' && $_GET['page'] == 'scm-custom-types'){

                global $SCM_types;

                $objs = $SCM_types['objects'];

                if ( is_admin() ) {

                    $roles = array( 'member', 'staff', 'administrator');
                    
                    foreach($roles as $the_role) {

                        $role = get_role( $the_role );

                        if ( !$role )
                            continue;

                        foreach ($objs as $key => $obj) {

                            $singular = $obj->cap_singular;
                            $plural = $obj->cap_plural;
                            $admin = $obj->admin;
                            $add = $obj->add_cap;

                            if( $the_role != 'administrator' && $admin ){
                                
                                $role->remove_cap( 'read_private_' . $plural );
                                $role->remove_cap( 'edit_' . $plural );
                                $role->remove_cap( 'edit_private_' . $plural );
                                $role->remove_cap( 'edit_others_' . $plural );
                                $role->remove_cap( 'edit_published_' . $plural );

                                continue;

                            }

                            $role->add_cap( 'read_private_' . $plural );
                            $role->add_cap( 'edit_' . $plural );
                            $role->add_cap( 'edit_private_' . $plural );
                            $role->add_cap( 'edit_others_' . $plural );
                            $role->add_cap( 'edit_published_' . $plural );

                            if( $the_role != 'administrator' && ( !$add || $the_role == 'member' ) ){

                                $role->remove_cap( 'publish_' . $plural );
                                $role->remove_cap( 'delete_' . $plural );
                                $role->remove_cap( 'delete_others_' . $plural );
                                $role->remove_cap( 'delete_private_' . $plural );
                                $role->remove_cap( 'delete_published_' . $plural );

                                continue;

                            }

                            $role->add_cap( 'publish_' . $plural );
                            $role->add_cap( 'delete_' . $plural );
                            $role->add_cap( 'delete_others_' . $plural );
                            $role->add_cap( 'delete_private_' . $plural );
                            $role->add_cap( 'delete_published_' . $plural );

                        }

                        do_action( 'scm_action_role_' . $the_role, $role );
                    }
                }

                do_action( 'scm_action_roles' );
            }
        }
    }

// *****************************************************
// *      3.0 OPTIONS PAGES INSTALLATION
// *****************************************************

    if ( ! function_exists( 'scm_option_pages_install' ) ) {
        function scm_option_pages_install(){

            // SCM Hook: Before ACF Option Pages install
            do_action( 'scm_action_option_pages_before' );

            if( function_exists('acf_add_options_page') ) {

                acf_add_options_page(array(
                    'page_title'    => 'SCM Settings',
                    'menu_title'    => 'SCM',
                    'menu_slug'     => 'scm-options-general',
                    'icon_url'      => 'dashicons-carrot',
                    'capability'    => 'manage_options',
                    'redirect'      => true,
                ));

                acf_add_options_page(array(
                    'page_title'    => 'SCM Types',
                    'menu_title'    => 'SCM Types',
                    'menu_slug'     => 'scm-types-general',
                    'icon_url'      => 'dashicons-star-filled',
                    'capability'    => 'manage_options',
                    'redirect'      => true,
                ));

                acf_add_options_page(array(
                    'page_title'    => 'SCM Templates',
                    'menu_title'    => 'SCM Templates',
                    'menu_slug'     => 'scm-templates-general',
                    'icon_url'      => 'dashicons-art',
                    'capability'    => 'manage_options',
                    'redirect'      => false,
                ));
            }
        }
    }

    if ( ! function_exists( 'scm_option_subpages_install' ) ) {
        function scm_option_subpages_install(){

            if( function_exists('acf_add_options_sub_page') ) {

                acf_add_options_sub_page(array(
                    'page_title'    => 'SCM Intro',
                    'menu_title'    => __( 'Introduzione', SCM_THEME ),
                    'menu_slug'     => 'scm-options-intro',
                    'parent_slug'   => 'scm-options-general',
                    'capability'    => 'manage_options',
                ));

                acf_add_options_sub_page(array(
                    'page_title'    => 'SCM Main Settings',
                    'menu_title'    => __( 'Opzioni', SCM_THEME ),
                    'menu_slug'     => 'scm-options-opzioni',
                    'parent_slug'   => 'scm-options-general',
                    'capability'    => 'manage_options',
                ));

                acf_add_options_sub_page(array(
                    'page_title'    => 'SCM Layout Settings',
                    'menu_title'    => __( 'Layout', SCM_THEME ),
                    'menu_slug'     => 'scm-options-layout',
                    'parent_slug'   => 'scm-options-general',
                    'capability'    => 'manage_options',
                ));

                acf_add_options_sub_page(array(
                    'page_title'    => 'SCM Design Settings',
                    'menu_title'    => __( 'Stili', SCM_THEME ),
                    'menu_slug'     => 'scm-options-stili',
                    'parent_slug'   => 'scm-options-general',
                    'capability'    => 'manage_options',
                ));

                acf_add_options_sub_page(array(
                    'page_title'    => 'SCM Header Settings',
                    'menu_title'    => __( 'Header', SCM_THEME ),
                    'menu_slug'     => 'scm-options-header',
                    'parent_slug'   => 'scm-options-general',
                    'capability'    => 'manage_options',
                ));

                acf_add_options_sub_page(array(
                    'page_title'    => 'SCM Footer Settings',
                    'menu_title'    => __( 'Footer', SCM_THEME ),
                    'menu_slug'     => 'scm-options-footer',
                    'parent_slug'   => 'scm-options-general',
                    'capability'    => 'manage_options',
                ));

                acf_add_options_sub_page(array(
                    'page_title'    => 'SCM Default Types',
                    'menu_title'    => __( 'Default Types', SCM_THEME ),
                    'menu_slug'     => 'scm-default-types',
                    'parent_slug'   => 'scm-types-general',
                    'capability'    => 'manage_options',
                ));

                acf_add_options_sub_page(array(
                    'page_title'    => 'SCM Default Taxonomies',
                    'menu_title'    => __( 'Default Taxonomies', SCM_THEME ),
                    'menu_slug'     => 'scm-default-taxonomies',
                    'parent_slug'   => 'scm-types-general',
                    'capability'    => 'manage_options',
                ));

                acf_add_options_sub_page(array(
                    'page_title'    => 'SCM Custom Types',
                    'menu_title'    => __( 'Custom Types', SCM_THEME ),
                    'menu_slug'     => 'scm-custom-types',
                    'parent_slug'   => 'scm-types-general',
                    'capability'    => 'manage_options',
                ));

                acf_add_options_sub_page(array(
                    'page_title'    => 'SCM Custom Taxonomies',
                    'menu_title'    => __( 'Custom Taxonomies', SCM_THEME ),
                    'menu_slug'     => 'scm-custom-taxonomies',
                    'parent_slug'   => 'scm-types-general',
                    'capability'    => 'manage_options',
                ));

                global $SCM_types;
                reset($SCM_types);

                foreach ($SCM_types['public'] as $slug => $title) {
                    acf_add_options_sub_page(array(
                        'page_title'    => 'SCM ' . $title . ' Template',
                        'menu_title'    => $title,
                        'menu_slug'     => 'scm-templates-' . $slug,
                        'parent_slug'   => 'scm-templates-general',
                        'capability'    => 'manage_options',
                    ));
                }

            }

            // SCM Hook: After ACF Option Pages install
            do_action( 'scm_action_option_pages' );
        }
    }

// *****************************************************
// *      4.0 ACF INSTALLATION
// *****************************************************

    // *** PLUGIN SETTINGS

    // customize ACF plugin path
    if ( ! function_exists( 'scm_acf_settings_path' ) ) {
        function scm_acf_settings_path( $path ) {
            $path = SCM_DIR_ACF_PLUGIN;
            return $path;
        }   
    }
     
    // customize ACF plugin dir
    if ( ! function_exists( 'scm_acf_settings_dir' ) ) {
        function scm_acf_settings_dir( $dir ) {
            $dir = SCM_URI_ACF_PLUGIN;
            return $dir;
        }
    }

    // Font Awesome Field FIX
    if ( ! function_exists( 'scm_force_fallback' ) ) {
        function scm_force_fallback( $force_fallback ) {
            return true;
        }
    }


    //include( SCM_DIR_ACF_PLUGIN . 'acf.php' );


// *****************************************************
// *      5.0 ACF HOOKS
// *****************************************************


// *****************************************************
// *      5.1 LOAD FIELD
// *****************************************************

    // ALL - SELECT CHOICES
    // merge default choices with preset choices
    if ( ! function_exists( 'scm_acf_loadfield_hook_choices_get' ) ) {
        function scm_acf_loadfield_hook_choices_get( $field ){

            if( isset( $field['choices'] ) && isset( $field['preset'] ) ){

                $preset = scm_acf_field_choices_preset( $field['preset'], '' );

                if( $preset )           
                    $field['choices'] = array_merge( $field['choices'], $preset );

                if( getByKey( $field['choices'], $field['default_value'] ) === false ) {
                    
                    foreach ( $field['choices'] as $key => $value ) {
                        $field['choices'][ $key ] = $value . ' ' . $field['default_value'];
                    }

                    reset( $field['choices'] );
                    $default = key( $field['choices'] );

                    $field['default_value'] = $default;

                }
            }
            
            return $field;
        }
    }

    // REPEATER
    if ( ! function_exists( 'scm_acf_loadfield_hook_repeater_list' ) ) {
        function scm_acf_loadfield_hook_repeater_list( $field ){

        // TEMPLATES

            if( endsWith( $field['name'], '-templates' ) ){
                
                $type = str_replace( '-templates', SCM_TEMPLATE_APP, $field['name'] );
                $posts = get_posts( array( 'post_type' => $type, 'orderby' => 'menu_order date', 'posts_per_page' => -1 ) );

                foreach ( $posts as $p ) {

                    $id = $p->post_name;

                    $field['value'][ $id ] = array();

                    foreach ($field['sub_fields'] as $v) {
                        if( $v['name'] == 'id' ){
                            $field['value'][ $id ][ $v['key'] ] = $p->ID;
                        }

                        if( $v['name'] == 'name' ){
                            $field['value'][ $id ][ $v['key'] ] = $p->post_title;
                        }
                    }
                }
            }
            
            return $field;
        }
    }

    // FONT AWESOME - SELECTED ICONS (1.7.0)
    // filter FA icons using groups/presets
    if ( ! function_exists( 'scm_acf_loadfield_hook_fontawesome_list' ) ) {
        function scm_acf_loadfield_hook_fontawesome_list( $field ){

            global $SCM_plugin_fa;

            $choices = array();
            $new = array();

            if ( $SCM_plugin_fa ) {

                if( isset( $field['filter_group'] ) && isset( $field['filter'] ) ){
                    $choices = scm_acf_field_fa_preset( $field['filter_group'], $field['filter'] );
                }

                if( !empty( $choices ) ){

                    foreach ( $choices as $key) {

                        if( isset( $field['choices'][$key] ) )
                            $new[ $key ] = $field['choices'][$key];

                    }

                    if( !empty( $new ) )
                        $field['choices'] = $new;
                }

                if( isset($field['choices']) ){
                    foreach ( $field['choices'] as $key => $value) {
                        if( isset( $field['choices'][ $key ] ) )
                            $field['choices'][ $key ] = substr( $value, strpos( $value, ' fa-' ) + 4 );
                    }

                    if( isset( $field['no_option'] ) && $field['no_option'] )
                        $field['choices'] = array_merge( array( 'no' => 'No Icon' ), $field['choices'] );
                }

                
            }
            
            return $field;
        }
    }

// *****************************************************
// *      5.2 SAVE POST
// *****************************************************


    // TEMPLATES
    if ( ! function_exists( 'scm_acf_savepost_hook_templates' ) ) {
        function scm_acf_savepost_hook_templates( $post_id ) {

            if( empty($_POST['acf']) )
                return;

            if( $post_id == 'options'){

                $fields = $_POST['acf'];

                foreach ( $fields as $key => $value ) {

                    $field = get_field_object($key, $post_id, false);
                    if( $field['type'] == 'repeater' && endsWith( $field['name'], '-templates' ) ){
                        
                        $type = str_replace( '-templates', SCM_TEMPLATE_APP, $field['name']);

                        $key_id = $field['sub_fields'][ getByValueKey( $field['sub_fields'], 'id' ) ]['key'];
                        $key_name = $field['sub_fields'][ getByValueKey( $field['sub_fields'], 'name' ) ]['key'];;

                        $posts = get_posts( array( 'post_type' => $type, 'orderby' => 'menu_order date' ) );
                        $pub = array();
                        foreach ( $posts as $p ) {
                            $pub[$p->ID] = $p->ID;
                        }

                        if( isset( $value ) && !empty( $value ) ){

                            $i = sizeof( $value );


                            foreach ( $value as $ui => $temp ) {

                                $i--;
                                $id = (int)$temp[ $key_id ];
                                $name = $temp[ $key_name ];
                                
                                $the_post = array(
                                    'post_title'    => $name,
                                    'post_name'     => sanitize_title( $name ),
                                    'post_status'   => 'publish',
                                    'post_author'   => 1,
                                    'menu_order'    => $i,
                                );
                                
                               
                                if( $id ){
                                    
                                    $the_post['ID'] = $id;
                                    
                                    if( is_string( get_post_status( $id ) ) ){
                                        wp_update_post( $the_post );
                                        unset( $pub[ $id ] );
                                    }
                                }else{

                                    $the_post['post_type'] = $type;

                                    $id = wp_insert_post( $the_post );

                                }
                            }
                        }

                        foreach ($pub as $key => $value) {
                            wp_delete_post( $key, true );
                        }

                        $_POST['acf'] = array();
                    }
                }
            }
        }
    }


    // ALL - TAXONOMIES LIST
    if ( ! function_exists( 'scm_acf_savepost_hook_all_taxonomies' ) ) {
        function scm_acf_savepost_hook_all_taxonomies( $post_id ) {

            if( empty($_POST['acf']) )
                return;

            $type = $_POST['post_type'];
            $taxes = get_object_taxonomies( $type );

            if( isset( $type ) && $type != 'page' && sizeof( $taxes ) ){
                
                $fields = $_POST['acf'];

                $list = scm_field_objects( $post_id, $fields, 'taxonomy', array( 'add_term' => 0, 'load_save_terms' => 1 ) );

                if( isset( $list ) && is_numeric( sizeof( $list ) ) ){

                    foreach ($list as $field) {
                        $tax = $field['taxonomy'];
                        $terms = get_terms( $tax, array( 'fields' => 'name' ) );
                    }
                }
            }
        }
    }

// *****************************************************
// *      5.3 QUERY FIELD
// *****************************************************

    // POST OBJECT - HIDE DRAFT
    if ( ! function_exists( 'scm_acf_queryfield_hook_objects' ) ) {
        function scm_acf_queryfield_hook_objects( $options, $field, $the_post ) {
            
            $options['post_status'] = array('publish');

            return $options;

        }
    }

// *****************************************************
// *      5.4 FORMAT VALUE
// *****************************************************

    // TEXT - FORMAT TEXT
    if ( ! function_exists( 'scm_acf_formatvalue_hook_text' ) ) {
        function scm_acf_formatvalue_hook_text( $value, $post_id, $field ){

            return $value;

        }
    }

    // EDITOR + TEXTAREA + LIMITER - FORMAT TEXT
    if ( ! function_exists( 'scm_acf_formatvalue_hook_editor' ) ) {
        function scm_acf_formatvalue_hook_editor( $value, $post_id, $field ){

            $pattern = "/<[^\/>]*>([\s]?)*<\/[^>]*>/";

            $value = preg_replace( $pattern, '', $value );

            return $value;

        }
    }


// *****************************************************
// *      6.0 ACF FIELDS INSTALLATION
// *****************************************************


    if ( ! function_exists( 'scm_acf_types_install' ) ) {
        function scm_acf_types_install() {

            if( function_exists('register_field_group') ) {

                // Custom

                consoleDebug('install custom types repeater');

                $types = scm_acf_group( 'Types', 'custom-types-options' );
                $types['location'][] = scm_acf_group_location( 'scm-custom-types', 'options_page' );
                $types['fields'] = scm_acf_options_types( 'custom' );

                scm_acf_group_register( $types );

            }
        }
    }

    if ( ! function_exists( 'scm_acf_taxonomies_install' ) ) {
        function scm_acf_taxonomies_install() {

            if( function_exists('register_field_group') ) {

                consoleDebug('install custom taxes repeater');
               
                $taxonomies = scm_acf_group( 'Taxonomies', 'custom-taxonomies-options' );
                $taxonomies['location'][] = scm_acf_group_location( 'scm-custom-taxonomies', 'options_page' );
                $taxonomies['fields'] = scm_acf_options_taxonomies( 'custom' );

                scm_acf_group_register( $taxonomies );              

            }
        }
    }

    if ( ! function_exists( 'scm_acf_install' ) ) {
        function scm_acf_install() {
            if( function_exists('register_field_group') ) {

                global $SCM_types;

                consoleDebug('install');

// SCM Filter: Passing empty Array - Receiving Array of Groups
                $groups = apply_filters( 'scm_filter_register_before', array() );


                // + TAXONOMIES LUOGHI
                $tax_luoghi = scm_acf_group( __( 'Icona Mappe', SCM_THEME ), 'map-icon-options' );
                $tax_luoghi['location'][] = scm_acf_group_location( 'luoghi-tip', 'taxonomy' );
                $msg = __( 'Verrà utilizzata sulle mappe per indicare i <strong>Luoghi</strong> assegnati a questa <strong>Categoria</strong>. Comparirà anche nella legenda, se sulla mappa sono presenti più <strong>Luoghi</strong>.
                Selezionando l\'opzione <em>Default</em> dal menu a tendina <strong>Icona Mappa</strong>, verrà utilizzata un\'icona standard. Viene sostituita nei <strong>Luoghi</strong> ai quali è stata assegnata un\'icona specifica.', SCM_THEME );
                $tax_luoghi['fields'] = scm_acf_preset_map_icon( 'luogo-tip', 100, 0, 0, $msg );

                $groups[] = $tax_luoghi;

                // + TAXONOMIES SLIDERS
                $tax_sliders = scm_acf_group( __( 'Opzioni Slider', SCM_THEME ), 'slider-options' );
                $tax_sliders['location'][] = scm_acf_group_location( 'sliders', 'taxonomy' );
                $tax_sliders['fields'] = scm_acf_template_sliders();

                $groups[] = $tax_sliders;

// OPTIONS

                // + OPT INTRO
                $intro = scm_acf_group( __( 'Introduzione', SCM_THEME ), 'intro-options' );
                $intro['location'][] = scm_acf_group_location( 'scm-options-intro', 'options_page' );
                $intro['fields'] = scm_acf_options_intro();

                $groups[] = $intro;

                // + OPT GENERAL
                $general = scm_acf_group( __( 'Opzioni Stili', SCM_THEME ), 'general-options' );
                $general['location'][] = scm_acf_group_location( 'scm-options-opzioni', 'options_page' );
                $general['fields'] = scm_acf_options_general();

                $groups[] = $general;

                // + OPT STYLE
                $style = scm_acf_group( __( 'Stili', SCM_THEME ), 'styles-options' );
                $style['location'][] = scm_acf_group_location( 'scm-options-stili', 'options_page' );
                $style['fields'] = scm_acf_options_styles();

                $groups[] = $style;

                // + OPT LAYOUT
                $layout = scm_acf_group( __( 'Layout', SCM_THEME ), 'layout-options' );
                $layout['location'][] = scm_acf_group_location( 'scm-options-layout', 'options_page' );
                $layout['fields'] = scm_acf_options_layout();

                $groups[] = $layout;
                
                // + OPT HEAD
                $head = scm_acf_group( __( 'Header', SCM_THEME ), 'head-options' );
                $head['location'][] = scm_acf_group_location( 'scm-options-header', 'options_page' );
                $head['fields'] = array_merge( $head['fields'], scm_acf_options_head() );

                $groups[] = $head;

                // + OPT FOOTER
                $footer = scm_acf_group( __( 'Componi Footer', SCM_THEME ), 'foot-options' );
                $footer['location'][] = scm_acf_group_location( 'scm-options-footer', 'options_page' );
                $footer['fields'] = array_merge( $footer['fields'], scm_acf_options_foot() );

                $groups[] = $footer;

// EDIT SINGLE
                
                // + PAGE
                $page = scm_acf_group( __( 'Componi Pagina', SCM_THEME ), 'pages-single' );
                $page['location'][] = scm_acf_group_location( 'page' );
                $page['fields'] = scm_acf_fields_page();

                $groups[] = $page;

                // + PAGE FOOTER
                $page_footer = scm_acf_group( __( 'Opzioni Footer', SCM_THEME ), 'footer-single' );
                $page_footer['location'][] = scm_acf_group_location( 'page' );
                $page_footer['fields'][] = scm_acf_field_objects_rel( 'page-footer', 0, 'sections', 100, 0, 'Seleziona Sections' );

                $groups[] = $page_footer;


                foreach ($SCM_types['custom'] as $slug => $title) {
                    if($slug=='slides'){
                        $group = scm_acf_group( __( 'Opzioni Slider', SCM_THEME ), 'slider-single' );
                        $group['location'][] = scm_acf_group_location( 'page' );
                        $group['fields'] = scm_acf_options_slider( 'main', 1 );
                        $groups[] = $group;
                    }
                    
                    $fun = 'scm_acf_fields_' . str_replace( '-', '_', $slug );
                    if( function_exists( $fun ) ){
                        $obj = $SCM_types['objects'][$slug];
                        $group = scm_acf_group( __( 'Opzioni '. $obj->singular, SCM_THEME ), $slug . '-single' );
                        $group['location'][] = scm_acf_group_location( $slug );
                        $group['fields'] = call_user_func( $fun );
                        $group = apply_filters( 'scm_filter_register_' . str_replace( '_', '-', $slug ), $group );
                        $groups[] = $group;
                    }                    
                }


// TEMPLATES

                foreach ($SCM_types['public'] as $slug => $title) {

                    $template = scm_acf_group( __( 'Elenco Modelli', SCM_THEME ), 'template-' . $slug );
                    $template['location'][] = scm_acf_group_location( 'scm-templates-' . $slug, 'options_page' );
                    $template['fields'] = scm_acf_fields_template( $slug );

                    $groups[] = $template;

                    $template = scm_acf_group( __( 'Modello', SCM_THEME ) . ' ' . $title, $slug . '_temp-single' );
                    $template['location'][] = scm_acf_group_location( $slug . SCM_TEMPLATE_APP );
                    
                    $slug = str_replace( '-', '_', $slug );

                    //if( function_exists( 'scm_acf_element_' . $slug ) )
                        $template['fields'] = array_merge( $template['fields'], scm_acf_build_element( $slug ) );
                        //$template['fields'] = array_merge( $template['fields'], call_user_func( 'scm_acf_element_' . $slug ) );

                    $groups[] = $template;
                }


// SCM Filter: Passing Array of Groups - Receiving Array of Groups

                $groups = apply_filters( 'scm_filter_register', $groups );

// Register Groups

                for ( $i = 0; $i < sizeof( $groups ); $i++) {
                    $groups[$i]['menu_order'] = $i;
                    scm_acf_group_register( $groups[$i] );
                }
            }
        }
    }


// *****************************************************
// *      7.0 PLUGIN INSTALLATION
// *****************************************************

    if ( ! function_exists( 'scm_plugins_install' ) ) {
        function scm_plugins_install() {

            $plugins = array(

                array(
                    'name'               => 'ACF', // The plugin name.
                    'slug'               => 'advanced-custom-fields-pro', // The plugin slug (typically the folder name).
                    'source'             => 'advanced-custom-fields-pro.zip', // The plugin source.
                    'required'           => true, // If false, the plugin is only 'recommended' instead of required.
                    'force_activation'   => true, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
                    'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
                ),

                array(
                    'name'               => 'ACF Hidden Field',
                    'slug'               => 'acf-hidden',
                    'source'             => 'acf-hidden.zip',
                    'required'           => false,
                    'force_activation'   => false,
                    'force_deactivation' => false,
                ),

                /*array(
                    'name'               => 'ACF Google Fonts', // The plugin name.
                    'slug'               => 'acf-google-font-selector-field', // The plugin slug (typically the folder name).
                    //'source'             => 'acf-google-font-selector-field.zip', // The plugin source.
                    'required'           => false, // If false, the plugin is only 'recommended' instead of required.
                    'force_activation'   => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
                    'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
                ),*/

                /*array(
                    'name'               => 'ACF PayPal',
                    'slug'               => 'acf-paypal-field-master',
                    //'source'             => 'acf-paypal-field-master.zip',
                    'required'           => false,
                    'force_activation'   => false,
                    'force_deactivation' => false,
                ),*/

                array(
                    'name'               => 'ACF Font Awesome',
                    'slug'               => 'advanced-custom-fields-font-awesome',
                    //'source'             => 'advanced-custom-fields-font-awesome.zip', // 2.7.0 (check before update)
                    'required'           => false,
                    'force_activation'   => false,
                    'force_deactivation' => false,
                ),

                array(
                    'name'               => 'ACF Limiter',
                    'slug'               => 'advanced-custom-fields-limiter-field',
                    //'source'             => 'advanced-custom-fields-limiter-field.zip',
                    'required'           => false,
                    'force_activation'   => false,
                    'force_deactivation' => false,
                ),

                array(
                    'name'               => 'ACF Date Time',
                    'slug'               => 'acf-field-date-time-picker',
                    //'source'             => 'acf-field-date-time-picker.zip',
                    'required'           => false,
                    'force_activation'   => false,
                    'force_deactivation' => false,
                ),

                array(
                    'name'               => 'Contact Form 7',
                    'slug'               => 'contact-form-7',
                    //'source'             => 'contact-form-7.zip',
                    'required'           => false,
                    'force_activation'   => false,
                    'force_deactivation' => false,
                ),

                array(
                    'name'               => 'Captcha 7',
                    'slug'               => 'really-simple-captcha',
                    //'source'             => 'really-simple-captcha.zip',
                    'required'           => false,
                    'force_activation'   => false,
                    'force_deactivation' => false,
                ),

                array(
                    'name'               => 'Loco Translate',
                    'slug'               => 'loco-translate',
                    //'source'             => 'polylang.zip',
                    'required'           => false,
                    'force_activation'   => false,
                    'force_deactivation' => false,
                ),

                array(
                    'name'               => 'Polylang',
                    'slug'               => 'polylang',
                    //'source'             => 'polylang.zip',
                    'required'           => false,
                    'force_activation'   => false,
                    'force_deactivation' => false,
                ),

                array(
                    'name'               => 'Replace Media',
                    'slug'               => 'enable-media-replace',
                    //'source'             => 'enable-media-replace.zip',
                    'required'           => false,
                    'force_activation'   => false,
                    'force_deactivation' => false,
                ),

                array(
                    'name'               => 'Browser Detection',
                    'slug'               => 'php-browser-detection',
                    //'source'             => 'php-browser-detection.zip',
                    'required'           => false,
                    'force_activation'   => false,
                    'force_deactivation' => false,
                ),

                array(
                    'name'               => 'Optimize Database',
                    'slug'               => 'rvg-optimize-database',
                    //'source'             => 'php-browser-detection.zip',
                    'required'           => false,
                    'force_activation'   => false,
                    'force_deactivation' => false,
                ),

                array(
                    'name'               => 'WP Database Backup',
                    'slug'               => 'wp-db-backup',
                    //'source'             => 'php-browser-detection.zip',
                    'required'           => false,
                    'force_activation'   => false,
                    'force_deactivation' => false,
                ),

                array(
                    'name'               => 'Role Editor',
                    'slug'               => 'user-role-editor',
                    //'source'             => 'php-browser-detection.zip',
                    'required'           => false,
                    'force_activation'   => false,
                    'force_deactivation' => false,
                ),

                array(
                    'name'               => 'Share Buttons',
                    'slug'               => 'simple-share-buttons-adder',
                    //'source'             => 'php-browser-detection.zip',
                    'required'           => false,
                    'force_activation'   => false,
                    'force_deactivation' => false,
                ),

                array(
                    'name'               => 'GitHub Updater',
                    'slug'               => 'github-updater',
                    'source'             => 'github-updater.zip',
                    'required'           => false,
                    'force_activation'   => false,
                    'force_deactivation' => false,
                ),

            // PLUS

                array(
                    'name'               => 'PLUS - WP Optimizer',
                    'slug'               => 'wp-clean-up-optimizer',
                    //'source'             => 'regenerate-thumbnails.zip',
                    'required'           => false,
                    'force_activation'   => false,
                    'force_deactivation' => false,
                ),

                array(
                    'name'               => 'PLUS - Thumbs Regenerator',
                    'slug'               => 'regenerate-thumbnails',
                    //'source'             => 'regenerate-thumbnails.zip',
                    'required'           => false,
                    'force_activation'   => false,
                    'force_deactivation' => false,
                ),

                array(
                    'name'               => 'PLUS - WP Security',
                    'slug'               => 'better-wp-security',
                    //'source'             => 'php-browser-detection.zip',
                    'required'           => false,
                    'force_activation'   => false,
                    'force_deactivation' => false,
                ),

                array(
                    'name'               => 'PLUS - Menu Editor',
                    'slug'               => 'admin-menu-editor',
                    //'source'             => 'php-browser-detection.zip',
                    'required'           => false,
                    'force_activation'   => false,
                    'force_deactivation' => false,
                ),

                array(
                    'name'               => 'PLUS - Theme Check',
                    'slug'               => 'theme-check',
                    //'source'             => 'php-browser-detection.zip',
                    'required'           => false,
                    'force_activation'   => false,
                    'force_deactivation' => false,
                ),

                array(
                    'name'               => 'PLUS - Reset Database',
                    'slug'               => 'wordpress-database-reset',
                    //'source'             => 'php-browser-detection.zip',
                    'required'           => false,
                    'force_activation'   => false,
                    'force_deactivation' => false,
                ),

            );
            
            $msg = false;
            if ( current_user_can( 'manage_options' ) ) {
                $msg = true;
            }

            $config = array(
                'default_path' => SCM_DIR_PLUGINS,         // Default absolute path to pre-packaged plugins.
                'menu'         => 'scm-install-plugins',   // Menu slug.
                'has_notices'  => $msg,                    // Show admin notices or not.
                'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
                'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
                'is_automatic' => true,                    // Automatically activate plugins after installation or not.
                'message'      => '',                      // Message to output right before the plugins table.
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
    }


?>