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
   
	add_action( 'acf/include_fields', 'scm_typekit_install' );                                                  // 1.0      Creo istanza Typekit class. Se prima installazione reindirizzo a principale pagina opzioni
    add_action( 'acf/include_fields', 'scm_roles_install' );                                                    // 1.0      Assegno Ruoli
    
    add_action( 'acf/include_fields', 'scm_option_pages_install' );                                             // 3.0      Creo Main Options Pages ( SCM, Types, Taxonomies )

    add_action( 'acf/include_fields', 'scm_acf_types_install' );                                                // 6.0      Creo, registro e assegno Custom Fields a Custom Types
    add_action( 'acf/include_fields', 'scm_default_types_install' );                                            // 2.0      Installo Default Types e Taxonomies
    add_action( 'acf/include_fields', 'scm_custom_types_install' );                                             // 2.0      Installo Custom Types

    add_action( 'acf/include_fields', 'scm_acf_taxonomies_install' );                                           // 6.0      Creo, registro e assegno Custom Fields a Custom Taxonomies
    add_action( 'acf/include_fields', 'scm_custom_taxonomies_install' );                                        // 2.0      Installo Custom Taxonomies
	
    add_action( 'acf/include_fields', 'scm_option_subpages_install' );                                          // 3.0      Creo Sub Options Pages

    add_action( 'acf/include_fields', 'scm_acf_install' );                                                      // 6.0      Creo, registro e assegno Custom Fields a tutto il resto
    
    add_filter( 'acf/settings/dir', 'scm_acf_settings_dir' );                                                   // 4.0      Imposto ACF Plugin Directory
    add_filter( 'acf/settings/path', 'scm_acf_settings_path' );                                                 // 4.0      Imposto ACF Plugin Path
    //add_filter('acf/settings/show_admin', '__return_false');                                                  // 4.0      Hide ACF from Admin
    add_filter( 'bfa_force_fallback', 'scm_force_fallback' );                                                   // 4.0      FA Add On Fix
    
    add_filter( 'acf/load_field', 'scm_acf_loadfield_hook_choices_get', 100) ;                                  // 5.1
    add_filter( 'acf/load_field/type=repeater', 'scm_acf_loadfield_hook_repeater_list', 100 );
    //add_filter( 'acf/load_field/type=flexible_content', 'scm_acf_loadfield_hook_flexible_list', 100 );
    
    add_filter( 'acf/load_field/type=font-awesome', 'scm_acf_loadfield_hook_fontawesome_list', 150 );
   
    //add_action( 'acf/save_post', 'scm_acf_savepost_hook_templates_new', 100) ;
    add_action( 'acf/save_post', 'scm_acf_savepost_hook_templates', 10) ;                                       // 5.2
    add_action( 'acf/save_post', 'scm_acf_savepost_hook_luoghi_latlng', 10 );
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
            if( !get_role( 'staff' ) ){
                add_role(
                    'staff',
                    'Staff',
                    array(
                        'read' => true,
                        'read_private_pages' => true,
                        'read_private_posts' => true,
                        'list_users' => true,
                        'remove_users' => true,
                        'add_users' => true,
                        'upload_files' => true,
                        'manage_categories' => true,
                    )
                );
                
            }
            //remove_role('staff');

            if( !get_role( 'utente' ) ){
                add_role(
                    'utente',
                    'Utente',
                    array(
                        'read' => true,
                        'read_private_pages' => true,
                        'read_private_posts' => true,
                    )
                );
                
            }
            //remove_role('utente');

            
        }
    }
        
// *** Theme Activation

    if ( ! function_exists( 'scm_theme_install' ) ) {
        function scm_theme_install() {

            global $SCM_version;

            $themeStatus = get_option( 'scm-settings-installed' );
            $version = get_option( 'scm-version' );

            if( $SCM_version != $version )
                update_option( 'scm-version', $SCM_version );

			if ( ! $themeStatus ) {
				update_option( 'scm-settings-installed', 1 );
				header( 'Location: themes.php?page=scm-options-opzioni' );		// Redirect alla pagina SCM Options
				die;
			}
		}
	}

// *****************************************************
// *      2.0 CUSTOM TYPES INSTALLATION
// *****************************************************

    if ( ! function_exists( 'scm_types_capabilities' ) ) {
        function scm_types_capabilities( $objs ){

            if ( is_admin() ) {
                                
                $roles = array('staff', 'administrator');
                
                foreach($roles as $the_role) {

                    $role = get_role( $the_role );

                    if ( !$role )
                        continue;

                    foreach ($objs as $key => $obj) {
                    
                        $singular = $obj->cap_singular;
                        $plural = $obj->cap_plural;
                        $admin = $obj->admin;
                        $add = $obj->add_cap;

                        if( $the_role != 'administrator' && ( $admin || !isset( $role->capabilities[ 'manage_categories' ] ) || !$role->capabilities[ 'manage_categories' ] ) )
                            continue;

                        $role->add_cap( 'read_private_' . $plural );
                        $role->add_cap( 'edit_' . $plural );
                        $role->add_cap( 'edit_private_' . $plural );
                        $role->add_cap( 'edit_others_' . $plural );
                        $role->add_cap( 'edit_published_' . $plural );                        

                        if( $the_role != 'administrator' && !$add )
                            continue;

                        $role->add_cap( 'publish_' . $plural );
                        $role->add_cap( 'delete_' . $plural );
                        $role->add_cap( 'delete_others_' . $plural );
                        $role->add_cap( 'delete_private_' . $plural );
                        $role->add_cap( 'delete_published_' . $plural );

                    }
                }
            }
        }
    }

    if ( ! function_exists( 'scm_default_types_install' ) ) {
        function scm_default_types_install(){
 
            global $SCM_types;

            $SCM_types = array(
                'objects' => array(),
                'private' => array(),
                'public' => array(
                    //'post'                  => 'Articoli',
                ),
                'all' => array(
                    //'post'                  => 'Articoli',
                    'wpcf7_contact_form'    => 'Contact Form',
                ),
                'complete' => array(
                    'page'                  => 'Pagine',
                    //'post'                  => 'Articoli',
                    'wpcf7_contact_form'    => 'Contact Form',
                ),
            );

			$default_types = array(
				'sections'				=> array( 'admin' => 1,      'add_cap' => 0,         'active' => 1,      'public' => 0,       'hidden' => 0,      'post' => 0,       'singular' => __('Section', SCM_THEME), 				'plural' => __('Sections', SCM_THEME), 				'slug' => 'sections', 			'icon' => 'schedule',           'orderby' => 'title',       'ordertype' => '',      'menupos' => 6,         'menu' => 0,                                                                                                           ),
				'modules'               => array( 'admin' => 0,      'add_cap' => 0,         'active' => 1,      'public' => 0,       'hidden' => 0,      'post' => 0,       'singular' => __('Module', SCM_THEME),                 'plural' => __('Modules', SCM_THEME),               'slug' => 'modules',            'icon' => 'screenoptions',      'orderby' => 'title',       'ordertype' => '',      'menupos' => 7,         'menu' => 0,                                                                                                           ),
                'banners'               => array( 'admin' => 0,      'add_cap' => 0,         'active' => 1,      'public' => 0,       'hidden' => 0,      'post' => 0,       'singular' => __('Banner', SCM_THEME),                 'plural' => __('Banners', SCM_THEME),               'slug' => 'banners',            'icon' => 'align-center',       'orderby' => 'title',       'ordertype' => '',      'menupos' => 8,         'menu' => 0,                                                                                                           ),
                'slides'                => array( 'admin' => 0,      'add_cap' => 1,         'active' => 1,      'public' => 1,       'hidden' => 0,      'post' => 1,       'singular' => __('Slide', SCM_THEME),                  'plural' => __('Slides', SCM_THEME),                'slug' => 'slides',             'icon' => 'format-image',       'orderby' => 'date',        'ordertype' => '',      'menupos' => 0,         'menu' => 3,                                                                                                           ),
                'gallerie'              => array( 'admin' => 0,      'add_cap' => 1,         'active' => 1,      'public' => 1,       'hidden' => 0,      'post' => 1,       'singular' => __('Galleria', SCM_THEME),               'plural' => __('Gallerie', SCM_THEME),              'slug' => 'gallerie',           'icon' => 'format-gallery',     'orderby' => 'title',       'ordertype' => '',      'menupos' => 0,         'menu' => 3,                                                                                                           ),
				'video'					=> array( 'admin' => 0,      'add_cap' => 1,         'active' => 1,      'public' => 1,       'hidden' => 0,      'post' => 1,       'singular' => __('Video', SCM_THEME), 				    'plural' => __('Video', SCM_THEME), 				'slug' => 'video', 				'icon' => 'video-alt3',         'orderby' => 'title',       'ordertype' => '',      'menupos' => 0,         'menu' => 3,                                                                                                           ),
                'news'                  => array( 'admin' => 0,      'add_cap' => 1,         'active' => 0,      'public' => 1,       'hidden' => 0,      'post' => 1,       'singular' => __('News', SCM_THEME),                   'plural' => __('News', SCM_THEME),                  'slug' => 'news',               'icon' => 'megaphone',          'orderby' => 'date',        'ordertype' => '',      'menupos' => 0,         'menu' => 3,                                                                                                           ),
                'documenti'             => array( 'admin' => 0,      'add_cap' => 1,         'active' => 1,      'public' => 1,       'hidden' => 0,      'post' => 1,       'singular' => __('Documento', SCM_THEME),              'plural' => __('Documenti', SCM_THEME),             'slug' => 'documenti',          'icon' => 'portfolio',          'orderby' => 'title',       'ordertype' => '',      'menupos' => 0,         'menu' => 3,                                                                                                           ),
				'rassegne-stampa'		=> array( 'admin' => 0,      'add_cap' => 1,         'active' => 1,      'public' => 1,       'hidden' => 0,      'post' => 1,       'singular' => __('Rassegna Stampa', SCM_THEME),		'plural' => __('Rassegne Stampa', SCM_THEME), 		'slug' => 'rassegne-stampa', 	'icon' => 'id',                 'orderby' => 'date',        'ordertype' => '',      'menupos' => 0,         'menu' => 3,      'short-singular' => __('Rassegna', SCM_THEME),     'short-plural' => __('Rassegne', SCM_THEME), 	   ),
                'soggetti'              => array( 'admin' => 0,      'add_cap' => 1,         'active' => 1,      'public' => 1,       'hidden' => 0,      'post' => 0,       'singular' => __('Soggetto', SCM_THEME),               'plural' => __('Soggetti', SCM_THEME),              'slug' => 'soggetti',           'icon' => 'groups',             'orderby' => 'title',       'ordertype' => '',      'menupos' => 0,         'menu' => 4,                                                                                                           ),
                'luoghi'                => array( 'admin' => 0,      'add_cap' => 1,         'active' => 1,      'public' => 1,       'hidden' => 0,      'post' => 0,       'singular' => __('Luogo', SCM_THEME),                  'plural' => __('Luoghi', SCM_THEME),                'slug' => 'luoghi',             'icon' => 'location',           'orderby' => 'title',       'ordertype' => '',      'menupos' => 0,         'menu' => 4,                                                                                                           ),
			);

            $default_taxonomies = array(
                'sections-cat'          => array( 'template' => 0,       'manage' => 1,     'hierarchical' => 0,          'plural' => 'Categorie Sezioni',          'singular' => 'Categoria Sezioni',      'slug' => 'sections-cat',              'types' => array( 'sections' ),         ),
                'sliders'               => array( 'template' => 0,       'manage' => 1,     'hierarchical' => 1,          'plural' => 'Sliders',                    'singular' => 'Slider',                 'slug' => 'sliders',                   'types' => array( 'slides' )            ),
                'soggetti-tip'          => array( 'template' => 0,       'manage' => 1,     'hierarchical' => 1,          'plural' => 'Tipologie Soggetti',         'singular' => 'Tipologia Soggetti',     'slug' => 'soggetti-tip',              'types' => array( 'soggetti' )          ),
                'luoghi-tip'            => array( 'template' => 0,       'manage' => 1,     'hierarchical' => 1,          'plural' => 'Tipologie Luoghi',           'singular' => 'Tipologia Luoghi',       'slug' => 'luoghi-tip',                'types' => array( 'luoghi' ),           ),
                'luoghi-cat'            => array( 'template' => 0,       'manage' => 1,     'hierarchical' => 0,          'plural' => 'Categorie Luoghi',           'singular' => 'Categoria Luoghi',       'slug' => 'luoghi-cat',                'types' => array( 'luoghi' ),           ),
                'documenti-cat'         => array( 'template' => 0,       'manage' => 1,     'hierarchical' => 0,          'plural' => 'Categorie Documenti',        'singular' => 'Categoria Documenti',    'slug' => 'documenti-cat',             'types' => array( 'documenti' ),        ),
                'video-cat'             => array( 'template' => 0,       'manage' => 1,     'hierarchical' => 0,          'plural' => 'Categorie Video',            'singular' => 'Categoria Video',        'slug' => 'video-cat',                 'types' => array( 'video' ),            ),
                'gallerie-cat'          => array( 'template' => 0,       'manage' => 1,     'hierarchical' => 0,          'plural' => 'Categorie Gallerie',         'singular' => 'Categoria Gallerie',     'slug' => 'gallerie-cat',              'types' => array( 'gallerie' ),         ),
                'rassegne-cat'          => array( 'template' => 0,       'manage' => 1,     'hierarchical' => 0,          'plural' => 'Categorie Rassegne',         'singular' => 'Categoria Rassegne',     'slug' => 'rassegne-cat',              'types' => array( 'rassegne-stampa' ),  ),
                'rassegne-autori'       => array( 'template' => 0,       'manage' => 1,     'hierarchical' => 0,          'plural' => 'Autori Rassegne',            'singular' => 'Autore Rassegne',        'slug' => 'autori',                    'types' => array( 'rassegne-stampa' ),  ),
                'rassegne-testate'      => array( 'template' => 0,       'manage' => 1,     'hierarchical' => 0,          'plural' => 'Testate Rassegne',           'singular' => 'Testata Rassegne',       'slug' => 'testate',                   'types' => array( 'rassegne-stampa' ),  ),
            );

            //$types = array_merge( $saved_types, $default_types );
            //$taxonomies = array_merge( $saved_taxonomies, $default_taxonomies );

            scm_types_install( $default_types );
            scm_taxonomies_install( $default_taxonomies );

        }
    }

    if ( ! function_exists( 'scm_custom_types_install' ) ) {
        function scm_custom_types_install(){

            global $SCM_types;

            $saved_types = scm_field( 'types-list', array(), 'option' );
            scm_types_install( $saved_types );
            scm_types_capabilities( $SCM_types['objects'] );
        }
    }

    if ( ! function_exists( 'scm_custom_taxonomies_install' ) ) {
        function scm_custom_taxonomies_install(){

            $saved_taxonomies = scm_field( 'taxonomies-list', array(), 'option' );
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

                $type['admin'] = ( isset( $type['admin'] ) && $type['admin'] ? ( $type['admin'] !== 'off' ? 1 : 0 ) : 0 );

                $type['active'] = ( isset( $type['active'] ) && $type['active'] ? ( $type['active'] !== 'off' ? 1 : 0 ) : 0 );

                $type['public'] = ( isset( $type['public'] ) && $type['public'] ? ( $type['public'] !== 'off' ? 1 : 0 ) : 0 );

                $type['hidden'] = ( isset( $type['hidden'] ) ? $type['hidden'] : 0 );

                $type['orderby'] = ( isset( $type['orderby'] ) ? $type['orderby'] : 'title' );

                $type['ordertype'] = ( isset( $type['ordertype'] ) ? $type['ordertype'] : 'ASC' );

                $type['slug'] = ( isset( $type['slug'] ) && $type['slug'] ? sanitize_title( $type['slug'] ) : sanitize_title( $plural ) );

                $type['icon'] = ( isset( $type['icon'] ) && $type['icon'] ? '\\' . $type['icon'] : '' ) ;


                if( $type['active'] === 1 ){

                    $SCM_types['complete'][ $type['slug'] ] = $plural;
                    
                    //printPre($SCM_types['complete'][ $type['slug'] ]);

                    $obj = $SCM_types['objects'][ $type['slug'] ] = new Custom_Type( $type );
                    $obj->CT_register();                    

                    if( $type['public'] === 1 ){

                        $SCM_types['public'][ $type['slug'] ] = 'Modello ' . $plural;
                        $SCM_types['all'][ $type['slug'] ] = 'Modello ' . $plural;
                        $type['plural'] = 'Modello ' . $plural;
                        $type['singular'] = 'Modello ' . $obj->singular;
                        $type['public'] = 0;
                        $type['hidden'] = 1;
                        $type['admin'] = 1;
                        $type['slug'] = $type['slug'] . SCM_TEMPLATE_APP;
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

                $tax['slug'] = ( isset( $tax['slug'] ) && $tax['slug'] ? sanitize_title( $tax['slug'] ) : sanitize_title( $plural ) );

                if( $tax['hierarchical'] )
                    $obj = $SCM_types['taxonomies'][ $tax['slug'] ] = $SCM_types['categories'][ $tax['slug'] ] = new Custom_Taxonomy( $tax );
                else
                    $obj = $SCM_types['taxonomies'][ $tax['slug'] ] = $SCM_types['tags'][ $tax['slug'] ] = new Custom_Taxonomy( $tax );

                $tax['template'] = ( isset( $tax['template'] ) && $tax['template'] ? ( $tax['template'] !== 'off' ? 1 : 0 ) : 0 );

                if( $tax['template'] ){

                    //printPre($plural);
                    
                    $tax_type = array();
                                        
                    //$SCM_types['public'][ $tax['slug'] ] = $plural;
                    //$SCM_types['all'][ $tax['slug'] ] = $plural;

                    $tax_type['plural'] = $plural;
                    $tax_type['singular'] = $obj->singular;
                    $tax_type['public'] = 0;
                    $tax_type['hidden'] = 1;
                    $tax_type['admin'] = 1;
                    $tax_type['slug'] = $tax['slug'] . SCM_TEMPLATE_APP;
                    $tax_type['menu'] = 0;
                    $tax_type['post'] = 0;

                    //printPre($tax_type['slug']);

                    $tax_temp = $SCM_types['objects'][ $tax_type['slug'] ] = new Custom_Type( $tax_type );
                    $tax_temp->CT_register();
                }

            }

            

            //scm_save_posts();
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
                    'position'      => '0.1',
                    'capability'    => 'manage_options',
                    'redirect'      => true,
                ));

                acf_add_options_page(array(
                    'page_title'    => 'SCM Types',
                    'menu_title'    => 'SCM Types',
                    'menu_slug'     => 'scm-types-general',
                    'icon_url'      => 'dashicons-star-filled',
                    'position'      => '0.2',
                    'capability'    => 'manage_options',
                    'redirect'      => true,
                ));

                acf_add_options_page(array(
                    'page_title'    => 'SCM Templates',
                    'menu_title'    => 'SCM Templates',
                    'menu_slug'     => 'scm-templates-general',
                    'icon_url'      => 'dashicons-art',
                    'position'      => '0.3',
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
                    'page_title'    => 'SCM Main Settings',
                    'menu_title'    => 'Opzioni',
                    'menu_slug'     => 'scm-options-opzioni',
                    'parent_slug'   => 'scm-options-general',
                    'capability'    => 'manage_options',
                ));

                acf_add_options_sub_page(array(
                    'page_title'    => 'SCM Layout Settings',
                    'menu_title'    => 'Layout',
                    'menu_slug'     => 'scm-options-layout',
                    'parent_slug'   => 'scm-options-general',
                    'capability'    => 'manage_options',
                ));

                acf_add_options_sub_page(array(
                    'page_title'    => 'SCM Design Settings',
                    'menu_title'    => 'Stili',
                    'menu_slug'     => 'scm-options-stili',
                    'parent_slug'   => 'scm-options-general',
                    'capability'    => 'manage_options',
                ));

                acf_add_options_sub_page(array(
                    'page_title'    => 'SCM Header Settings',
                    'menu_title'    => 'Header',
                    'menu_slug'     => 'scm-options-header',
                    'parent_slug'   => 'scm-options-general',
                    'capability'    => 'manage_options',
                ));

                acf_add_options_sub_page(array(
                    'page_title'    => 'SCM Footer Settings',
                    'menu_title'    => 'Footer',
                    'menu_slug'     => 'scm-options-footer',
                    'parent_slug'   => 'scm-options-general',
                    'capability'    => 'manage_options',
                ));

                acf_add_options_sub_page(array(
                    'page_title'    => 'SCM Custom Types',
                    'menu_title'    => 'Types',
                    'menu_slug'     => 'scm-types-custom',
                    'parent_slug'   => 'scm-types-general',
                    'capability'    => 'manage_options',
                ));

                acf_add_options_sub_page(array(
                    'page_title'    => 'SCM Taxonomies Types',
                    'menu_title'    => 'Taxonomies',
                    'menu_slug'     => 'scm-types-taxonomies',
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


    include( SCM_DIR_ACF_PLUGIN . 'acf.php' );


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

    // REPEATER - TEMPLATES
    if ( ! function_exists( 'scm_acf_loadfield_hook_repeater_list' ) ) {
        function scm_acf_loadfield_hook_repeater_list( $field ){

            if( !endsWith( $field['name'], '-templates' ) )
                return $field;

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
            
            return $field;
        }
    }

    // FONT AWESOME - SELECTED ICONS
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

                foreach ( $field['choices'] as $key => $value) {
                    if( isset( $field['choices'][ $key ] ) )
                        $field['choices'][ $key ] = substr( $value, strpos( $value, ' fa-' ) + 4 );
                }

                if( isset( $field['no_option'] ) && $field['no_option'] )
                    $field['choices'] = array( 'no' => 'No Icon' ) + $field['choices'];
            }
            
            return $field;
        }
    }

// *****************************************************
// *      5.2 SAVE POST
// *****************************************************

    // TEMPLATES
    if ( ! function_exists( 'scm_acf_savepost_hook_templates_new' ) ) {
        function scm_acf_savepost_hook_templates_new( $post_id ) {

            if( empty($_POST['acf']) )
                return;

            if( $post_id != 'options' && isset( $_POST['post_type'] ) && $_POST['post_type'] == 'sections'){

                $fields = $_POST['acf'];
                $k_rows = scm_field_key( $post_id, $fields, 'section-elem' );
                $rows =  ( isset( $fields[ $k_rows ] ) ? $fields[ $k_rows ] : '' );
                //$rows =  $fields[ 'field_2fb85b5b0a317e54b2097bd6ee143726fada32f7' ];

                if( isset( $rows ) && !empty( $rows ) ){

                    foreach ( $rows as $layout => $row ) {
                        
                        //$k_cont = '';
                        $k_name = scm_field_key( $post_id, $row, 'name' );
                        $k_model = scm_field_key( $post_id, $row, 'new', 'build' );

                        if( $k_model === false )
                            continue;

                        if( $k_name /*&& $k_cont*/ && $k_model ){
                            $type = str_replace( 'layout-', '', $row['acf_fc_layout'] );
                            $type .= SCM_TEMPLATE_APP;

                            $name = $row[ $k_name ];
                            //$cont = $row[ $k_cont ];

                            //if( is_array( $cont ) && sizeof( $cont ) > 0 ){
                            if( isset( $name ) && is_string( $name ) && $name ){

                                $the_post = array(
                                    'post_title'    => $name,
                                    'post_type'     => $type,
                                    'post_name'     => sanitize_title( $name ),
                                    'post_status'   => 'publish',
                                    'post_author'   => 1,
                                );

                                $id = wp_insert_post( $the_post );
                                $new_post = get_post( $id );
                            
                                // INSERISCI META
                                // for( $cont ){
                                //  updatePostMeta( $id, $meta, $value );
                                // }
                                
                                $_POST['acf'][ $k_rows ][$layout][ $k_model ] = $new_post->post_name;
                                $_POST['acf'][ $k_rows ][$layout][ $k_name ] = '';
                                //$_POST['acf'][ $k_rows ][$layout][ $k_cont ] = array();

                            }

                        }else{
                            $_POST['acf'][ $k_rows ][$layout][ $k_model ] = 'build';
                            $_POST['acf'][ $k_rows ][$layout][ $k_name ] = '';
                            //$_POST['acf'][ $k_rows ][$layout][ $k_cont ] = array();
                        }                        
                    }
                }
            }
        }
    }

    // TEMPLATES
    if ( ! function_exists( 'scm_acf_savepost_hook_templates' ) ) {
        function scm_acf_savepost_hook_templates( $post_id ) {

            if( empty($_POST['acf']) )
                return;

            if( $post_id == 'options'){

                $fields = $_POST['acf'];

                //$repeater = scm_field_key( $post_it, $fields, [ 'ends', '-templates' ], [ '==', 'repeater', 'value' ] );
                //if( $repeater ){

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


    // LUOGHI - Lat and Lng
    // +++ todo: con jQuery aggiorni i campi dinamicamente, ogni volta che uno degli altri campi cambia
    if ( ! function_exists( 'scm_acf_savepost_hook_luoghi_latlng' ) ) {
        function scm_acf_savepost_hook_luoghi_latlng( $post_id ) {
           
            if( empty($_POST['acf']) )
                return;

            if( isset( $_POST['post_type'] ) && $_POST['post_type'] == 'luoghi' && !isset( $_POST['taxonomy'] ) ){

                $fields = $_POST['acf'];
               
                $country = $fields[ scm_field_key( $post_id, $fields, 'luogo-paese' ) ];
                $region = $fields[ scm_field_key( $post_id, $fields, 'luogo-regione' ) ];
                $province = $fields[ scm_field_key( $post_id, $fields, 'luogo-provincia' ) ];
                $code = $fields[ scm_field_key( $post_id, $fields, 'luogo-cap' ) ];
                $city = $fields[ scm_field_key( $post_id, $fields, 'luogo-citta' ) ];
                $town = $fields[ scm_field_key( $post_id, $fields, 'luogo-frazione' ) ];
                $address = $fields[ scm_field_key( $post_id, $fields, 'luogo-indirizzo' ) ];

                $google_address = $address . ' ' . $town . ' ' . $code . ' ' . $city . ' ' . $province . ' ' . $region;

                $ll = getGoogleMapsLatLng( $google_address, $country );
                $lat = $ll['lat'];
                $lng = $ll['lng'];

                $_POST['acf'][ scm_field_key( $post_id, $fields, 'luogo-lat' ) ] = $lat;
                $_POST['acf'][ scm_field_key( $post_id, $fields, 'luogo-lng' ) ] = $lng;

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
                //$add = scm_field_objects( $post_id, $fields, 'text', [ 'name' => 'add' ] );

                if( isset( $list ) && is_numeric( sizeof( $list ) ) ){

                    foreach ($list as $field) {
                        $tax = $field['taxonomy'];
                        $terms = get_terms( $tax, array( 'fields' => 'name' ) );
                        //printPre($terms);

                        /// *   * * * * * * ***    ** * *

                        /*
                        if( !$_POST['acf'][ $field['key'] ] ){

                            $_POST['acf'][ $field['key'] ] = 'Altro';*/
                            
                            //printPre($terms);
                            /*if( sizeof( $terms ) ){
                                if( getByValue( $terms, 'altro' ) )
                                    $_POST['acf'][ $field['key'] ]['value'] = 'altro';
                                else                                    
                                    $_POST['acf'][ $field['key'] ]['value'] = $terms[0];
                            }*/
                        //}
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

            //consoleLog($value);
            //consoleLog(sanitize_text_field( $value ));

            return $value;

            //return sanitize_text_field( $value );

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

                $types = scm_acf_group( 'Types', 'types-options' );
                $types['location'][] = scm_acf_group_location( 'scm-types-custom', 'options_page' );
                $types['fields'] = scm_acf_options_types();

                scm_acf_group_register( $types );

            }
        }
    }

    if ( ! function_exists( 'scm_acf_taxonomies_install' ) ) {
        function scm_acf_taxonomies_install() {

            if( function_exists('register_field_group') ) {
               
                $taxonomies = scm_acf_group( 'Taxonomies', 'taxonomies-options' );
                $taxonomies['location'][] = scm_acf_group_location( 'scm-types-taxonomies', 'options_page' );
                $taxonomies['fields'] = scm_acf_options_taxonomies();

                scm_acf_group_register( $taxonomies );              

            }
        }
    }

    if ( ! function_exists( 'scm_acf_install' ) ) {
        function scm_acf_install() {
            if( function_exists('register_field_group') ) {

// SCM Filter: Passing empty Array - Receiving Array of Groups
                $groups = apply_filters( 'scm_filter_register_before', array() );


                // + TAXONOMIES LUOGHI
                $tax_luoghi = scm_acf_group( 'Icona Mappe', 'map-icon-options' );
                $tax_luoghi['location'][] = scm_acf_group_location( 'luoghi-tip', 'taxonomy' );
                $msg = 'Verrà utilizzata sulle mappe per indicare i <strong>Luoghi</strong> assegnati a questa <strong>Categoria</strong>. Comparirà anche nella legenda, se sulla mappa sono presenti più <strong>Luoghi</strong>.
                Selezionando l\'opzione <em>Default</em> dal menu a tendina <strong>Icona Mappa</strong>, verrà utilizzata un\'icona standard. Viene sostituita nei <strong>Luoghi</strong> ai quali è stata assegnata un\'icona specifica.';
                $tax_luoghi['fields'] = scm_acf_preset_map_icon( 'luogo-tip-mappa', 1,  100, 100, 0, 'Icona Mappa specifica per questa Categoria', $msg );

                $groups[] = $tax_luoghi;

                // + TAXONOMIES SLIDERS
                $tax_sliders = scm_acf_group( 'Opzioni Slider', 'slider-options' );
                $tax_sliders['location'][] = scm_acf_group_location( 'sliders', 'taxonomy' );
                $tax_sliders['fields'] = scm_acf_template_sliders();

                $groups[] = $tax_sliders;

// OPTIONS

                // + OPT GENERAL
                $general = scm_acf_group( 'Opzioni Stili', 'general-options' );
                $general['location'][] = scm_acf_group_location( 'scm-options-opzioni', 'options_page' );
                $general['fields'] = scm_acf_options_general();

                $groups[] = $general;

                // + OPT STYLE
                $style = scm_acf_group( 'Stili', 'styles-options' );
                $style['location'][] = scm_acf_group_location( 'scm-options-stili', 'options_page' );
                $style['fields'] = scm_acf_options_styles();

                $groups[] = $style;

                // + OPT STILI
                $options_default = scm_acf_group( 'Opzioni', 'style-options' );
                $options_default['location'][] = scm_acf_group_location( 'scm-options-stili', 'options_page' );
                $options_default['fields'] = array_merge( $options_default['fields'], scm_acf_options_style() );

                $groups[] = $options_default;

                // + OPT LAYOUT
                $layout = scm_acf_group( 'Layout', 'layout-options' );
                $layout['location'][] = scm_acf_group_location( 'scm-options-layout', 'options_page' );
                $layout['fields'] = scm_acf_options_layout();

                $groups[] = $layout;
                
                // + OPT HEAD
                $head = scm_acf_group( 'Header', 'head-options' );
                $head['location'][] = scm_acf_group_location( 'scm-options-header', 'options_page' );
                $head['fields'] = array_merge( $head['fields'], scm_acf_options_head() );

                $groups[] = $head;

                // + OPT FOOTER
                $footer = scm_acf_group( 'Componi Footer', 'foot-options' );
                $footer['location'][] = scm_acf_group_location( 'scm-options-footer', 'options_page' );
                $footer['fields'] = array_merge( $footer['fields'], scm_acf_options_foot() );

                $groups[] = $footer;

// EDIT SINGLE

                // + SLIDES
                $slide = scm_acf_group( 'Slide', 'slides-single' );
                $slide['location'][] = scm_acf_group_location( 'slides' );
                $slide['fields'] = scm_acf_fields_slide();

                $groups[] = $slide;
                
                // + ARTICOLI
                $article = scm_acf_group( 'Articolo', 'posts-single' );
                $article['location'][] = scm_acf_group_location( 'post' );
                $article['fields'] = scm_acf_fields_articolo();

                $groups[] = $article;

                // + VIDEO
                $video = scm_acf_group( 'Video', 'videos-single' );
                $video['location'][] = scm_acf_group_location( 'video' );
                $video['fields'] = scm_acf_fields_video();

                $groups[] = $video;

                // + DOCUMENTO
                $documento = scm_acf_group( 'Documento', 'documenti-single' );
                $documento['location'][] = scm_acf_group_location( 'documenti' );
                $documento['fields'] = scm_acf_fields_documento();

                $groups[] = $documento;

                // + GALLERY
                $gallery = scm_acf_group( 'Gallery', 'gallery-single' );
                $gallery['location'][] = scm_acf_group_location( 'gallerie' );
                $gallery['fields'] = scm_acf_fields_galleria();

                $groups[] = $gallery;

                // + RASSEGNA STAMPA
                $rassegna = scm_acf_group( 'Rassegna Stampa', 'rassegne-single' );
                $rassegna['location'][] = scm_acf_group_location( 'rassegne-stampa' );
                $rassegna['fields'] = scm_acf_fields_rassegna();

                $groups[] = $rassegna;

                // + LUOGO
                $luogo = scm_acf_group( 'Luogo', 'luoghi-single' );
                $luogo['location'][] = scm_acf_group_location( 'luoghi' );
                $luogo['fields'] = scm_acf_fields_luogo();

                $groups[] = $luogo;

                // + SOGGETTO
                $soggetto = scm_acf_group( 'Soggetto', 'soggetti-single' );
                $soggetto['location'][] = scm_acf_group_location( 'soggetti' );
                $soggetto['fields'] = scm_acf_fields_soggetto();

                $groups[] = $soggetto;

                // + PAGE SLIDER
                $slider = scm_acf_group( 'Opzioni Slider', 'slider-single' );
                $slider['location'][] = scm_acf_group_location( 'page' );
                $slider['fields'] = scm_acf_options_slider( 'main', 1 );

                $groups[] = $slider;

                // + PAGE
                $page = scm_acf_group( 'Componi Pagina', 'pages-single' );
                $page['location'][] = scm_acf_group_location( 'page' );
                $page['fields'] = scm_acf_fields_page();

                $groups[] = $page;

                // + PAGE FOOTER
                $page_footer = scm_acf_group( 'Opzioni Footer', 'footer-single' );
                $page_footer['location'][] = scm_acf_group_location( 'page' );
                $page_footer['fields'][] = scm_acf_field_objects_rel( 'page-footer', 0, 'sections', 100, 0, 'Seleziona Sections' );

                $groups[] = $page_footer;

                // + SECTION
                $section = scm_acf_group( 'Componi Sezione', 'sections-single' );
                $section['location'][] = scm_acf_group_location( 'sections' );
                $section['fields'] = scm_acf_fields_section();

                $groups[] = $section;

                // + MODULE
                $module = scm_acf_group( 'Componi Modulo', 'modules-single' );
                $module['location'][] = scm_acf_group_location( 'modules' );
                $module['fields'] = scm_acf_fields_module();

                $groups[] = $module;

                // + BANNER
                $module = scm_acf_group( 'Componi Banner', 'banners-single' );
                $module['location'][] = scm_acf_group_location( 'banners' );
                $module['fields'] = scm_acf_fields_banner();

                $groups[] = $module;

// MODELLI

                global $SCM_types;

                foreach ($SCM_types['public'] as $slug => $title) {

                    $template = scm_acf_group( 'Elenco Modelli', 'template-' . $slug );
                    $template['location'][] = scm_acf_group_location( 'scm-templates-' . $slug, 'options_page' );
                    $template['fields'] = scm_acf_fields_template( $slug );

                    $groups[] = $template;

                    $template = scm_acf_group( 'Modello ' . $title, $slug . '_temp-single' );
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
                    'name'               => 'ACF Hidden Field', // The plugin name.
                    'slug'               => 'acf-hidden', // The plugin slug (typically the folder name).
                    'source'             => 'acf-hidden.zip', // The plugin source.
                    'required'           => false, // If false, the plugin is only 'recommended' instead of required.
                    'force_activation'   => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
                    'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
                ),

                array(
                    'name'               => 'ACF PayPal', // The plugin name.
                    'slug'               => 'acf-paypal-field-master', // The plugin slug (typically the folder name).
                    //'source'             => 'acf-paypal-field-master.zip', // The plugin source.
                    'required'           => false, // If false, the plugin is only 'recommended' instead of required.
                    'force_activation'   => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
                    'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
                ),

                array(
                    'name'               => 'ACF Font Awesome', // The plugin name.
                    'slug'               => 'advanced-custom-fields-font-awesome', // The plugin slug (typically the folder name).
                    //'source'             => 'advanced-custom-fields-font-awesome.zip', // The plugin source.
                    'required'           => false, // If false, the plugin is only 'recommended' instead of required.
                    'force_activation'   => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
                    'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
                ),

                array(
                    'name'               => 'ACF Limiter', // The plugin name.
                    'slug'               => 'advanced-custom-fields-limiter-field', // The plugin slug (typically the folder name).
                    //'source'             => 'advanced-custom-fields-limiter-field.zip', // The plugin source.
                    'required'           => false, // If false, the plugin is only 'recommended' instead of required.
                    'force_activation'   => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
                    'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
                ),

                array(
                    'name'               => 'ACF Date Time', // The plugin name.
                    'slug'               => 'acf-field-date-time-picker', // The plugin slug (typically the folder name).
                    //'source'             => 'acf-field-date-time-picker.zip', // The plugin source.
                    'required'           => false, // If false, the plugin is only 'recommended' instead of required.
                    'force_activation'   => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
                    'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
                ),

                array(
                    'name'               => 'Contact Form 7', // The plugin name.
                    'slug'               => 'contact-form-7', // The plugin slug (typically the folder name).
                    //'source'             => 'contact-form-7.zip', // The plugin source.
                    'required'           => false, // If false, the plugin is only 'recommended' instead of required.
                    'force_activation'   => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
                    'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
                ),

                array(
                    'name'               => 'Captcha 7', // The plugin name.
                    'slug'               => 'really-simple-captcha', // The plugin slug (typically the folder name).
                    //'source'             => 'really-simple-captcha.zip', // The plugin source.
                    'required'           => false, // If false, the plugin is only 'recommended' instead of required.
                    'force_activation'   => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
                    'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
                ),

                array(
                    'name'               => 'Polylang', // The plugin name.
                    'slug'               => 'polylang', // The plugin slug (typically the folder name).
                    //'source'             => 'polylang.zip', // The plugin source.
                    'required'           => false, // If false, the plugin is only 'recommended' instead of required.
                    'force_activation'   => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
                    'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
                ),

                array(
                    'name'               => 'Replace Media', // The plugin name.
                    'slug'               => 'enable-media-replace', // The plugin slug (typically the folder name).
                    //'source'             => 'enable-media-replace.zip', // The plugin source.
                    'required'           => false, // If false, the plugin is only 'recommended' instead of required.
                    'force_activation'   => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
                    'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
                ),

                array(
                    'name'               => 'Browser Detection', // The plugin name.
                    'slug'               => 'php-browser-detection', // The plugin slug (typically the folder name).
                    //'source'             => 'php-browser-detection.zip', // The plugin source.
                    'required'           => false, // If false, the plugin is only 'recommended' instead of required.
                    'force_activation'   => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
                    'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
                ),

                array(
                    'name'               => 'Optimize Database', // The plugin name.
                    'slug'               => 'rvg-optimize-database', // The plugin slug (typically the folder name).
                    //'source'             => 'php-browser-detection.zip', // The plugin source.
                    'required'           => false, // If false, the plugin is only 'recommended' instead of required.
                    'force_activation'   => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
                    'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
                ),

                array(
                    'name'               => 'Share Buttons', // The plugin name.
                    'slug'               => 'simple-share-buttons-adder', // The plugin slug (typically the folder name).
                    //'source'             => 'php-browser-detection.zip', // The plugin source.
                    'required'           => false, // If false, the plugin is only 'recommended' instead of required.
                    'force_activation'   => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
                    'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
                ),

                array(
                    'name'               => 'GitHub Updater', // The plugin name.
                    'slug'               => 'github-updater', // The plugin slug (typically the folder name).
                    'source'             => 'github-updater.zip', // The plugin source.
                    'required'           => false, // If false, the plugin is only 'recommended' instead of required.
                    'force_activation'   => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
                    'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
                ),

            // PLUS

                array(
                    'name'               => 'PLUS - WP Optimizer', // The plugin name.
                    'slug'               => 'wp-clean-up-optimizer', // The plugin slug (typically the folder name).
                    //'source'             => 'regenerate-thumbnails.zip', // The plugin source.
                    'required'           => false, // If false, the plugin is only 'recommended' instead of required.
                    'force_activation'   => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
                    'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
                ),

                array(
                    'name'               => 'PLUS - Thumbs Regenerator', // The plugin name.
                    'slug'               => 'regenerate-thumbnails', // The plugin slug (typically the folder name).
                    //'source'             => 'regenerate-thumbnails.zip', // The plugin source.
                    'required'           => false, // If false, the plugin is only 'recommended' instead of required.
                    'force_activation'   => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
                    'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
                ),

                array(
                    'name'               => 'PLUS - WP Security', // The plugin name.
                    'slug'               => 'better-wp-security', // The plugin slug (typically the folder name).
                    //'source'             => 'php-browser-detection.zip', // The plugin source.
                    'required'           => false, // If false, the plugin is only 'recommended' instead of required.
                    'force_activation'   => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
                    'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
                ),

                array(
                    'name'               => 'PLUS - Menu Editor', // The plugin name.
                    'slug'               => 'admin-menu-editor', // The plugin slug (typically the folder name).
                    //'source'             => 'php-browser-detection.zip', // The plugin source.
                    'required'           => false, // If false, the plugin is only 'recommended' instead of required.
                    'force_activation'   => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
                    'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
                ),

                array(
                    'name'               => 'PLUS - Theme Check', // The plugin name.
                    'slug'               => 'theme-check', // The plugin slug (typically the folder name).
                    //'source'             => 'php-browser-detection.zip', // The plugin source.
                    'required'           => false, // If false, the plugin is only 'recommended' instead of required.
                    'force_activation'   => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
                    'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
                ),

                array(
                    'name'               => 'PLUS - Role Editor', // The plugin name.
                    'slug'               => 'user-role-editor', // The plugin slug (typically the folder name).
                    //'source'             => 'php-browser-detection.zip', // The plugin source.
                    'required'           => false, // If false, the plugin is only 'recommended' instead of required.
                    'force_activation'   => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
                    'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
                ),

                array(
                    'name'               => 'PLUS - Reset Database', // The plugin name.
                    'slug'               => 'wordpress-database-reset', // The plugin slug (typically the folder name).
                    //'source'             => 'php-browser-detection.zip', // The plugin source.
                    'required'           => false, // If false, the plugin is only 'recommended' instead of required.
                    'force_activation'   => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
                    'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
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