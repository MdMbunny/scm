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
*   6.0 ACF Fields Installation
*   7.0 Plugins Installation
*
*****************************************************
*/

// *****************************************************
// *      0.0 ACTIONS AND FILTERS
// *****************************************************
   
	add_action( 'acf/include_fields', 'scm_install' );                                              // 1.0      Creo istanza Typekit class. Se prima installazione reindirizzo a principale pagina opzioni

    add_action( 'acf/include_fields', 'scm_option_pages_install' );                                 // 3.0      Creo Main Options Pages ( SCM, Types, Taxonomies )

    add_action('acf/include_fields', 'scm_acf_types_install');                                      // 6.0      Creo, registro e assegno Custom Fields a Custom Types e Taxonomies
    
    add_action( 'acf/include_fields', 'scm_types_install' );                                        // 2.0      Installo Default e Custom Types e Taxonomies
    
	add_action( 'acf/include_fields', 'scm_option_subpages_install' );                              // 3.0      Creo Sub Options Pages

    add_action('acf/include_fields', 'scm_acf_install');                                            // 6.0      Creo, registro e assegno Custom Fields a tutto il resto
    
    add_filter('acf/settings/dir', 'scm_acf_settings_dir');                                         // 4.0
    add_filter('acf/settings/path', 'scm_acf_settings_path');
    //add_filter('acf/settings/show_admin', '__return_false');                                      // Hide ACF from Admin
    add_filter( 'bfa_force_fallback', 'scm_force_fallback' );

    
    add_filter('acf/load_field', 'scm_acf_loadfield_hook_choices_get', 100);                             // 5.1
    add_filter('acf/load_field/type=repeater', 'scm_acf_loadfield_hook_template_list', 100);

    add_action('acf/save_post', 'scm_acf_savepost_hook_templates', 1);                                   // 5.2
    add_action('acf/save_post', 'scm_acf_savepost_hook_luoghi_latlng', 1);
    add_action('acf/save_post', 'scm_acf_savepost_hook_all_taxonomies', 1);

    add_action( 'tgmpa_register', 'scm_plugins_install' );                                          // 7.0


// *****************************************************
// *      1.0 THEME INSTALLATION
// *****************************************************

	if ( ! function_exists( 'scm_install' ) ) {
		function scm_install() {

            global $SCM_version, $SCM_typekit;

            $SCM_typekit = new Typekit();
            
            $themeStatus = get_option( 'scm-settings-installed' );
            $version = get_option( 'scm-version' );

            if( $SCM_version != $version )
                update_option( 'scm-version', $SCM_version );

			if ( ! $themeStatus ) {
				update_option( 'scm-settings-installed', 1 );
				header( 'Location: themes.php?page=' . SCM_SETTINGS_MAIN );		// Redirect alla pagina SCM Options
				die;
			}
		}
	}

// *****************************************************
// *      2.0 CUSTOM TYPES INSTALLATION
// *****************************************************

    if ( ! function_exists( 'scm_types_install' ) ) {
        function scm_types_install(){

            global $SCM_types;

            $SCM_types = array(
                'objects' => array(),
                'private' => array(),
                'public' => array(
                    'post'                  => 'Articoli',
                ),
                'all' => array(
                    'post'                  => 'Articoli',
                    'wpcf7_contact_form'    => 'Contact Form',
                ),
                'complete' => array(
                    'page'                  => 'Pagine',
                    'post'                  => 'Articoli',
                    'wpcf7_contact_form'    => 'Contact Form',
                ),
            );

            $saved_types = scm_field( 'types-list', array(), 'option' );
            $saved_taxonomies = scm_field( 'taxonomies-list', array(), 'option' );
            
			$default_types = array(
				'sections'				=> array( 'active' => 1,      'public' => 0,       'hidden' => 0,     	'singular' => __('Section', SCM_THEME), 				'plural' => __('Sections', SCM_THEME), 				'slug' => 'sections', 			'icon' => 'f489',      'orderby' => 'title',       'ordertype' => '',      'post' => 0 ),
				'slides'                => array( 'active' => 1,      'public' => 0,       'hidden' => 0,       'singular' => __('Slide', SCM_THEME),                   'plural' => __('Slides', SCM_THEME),                'slug' => 'slides',             'icon' => 'f128',      'orderby' => 'date',        'ordertype' => '' ),
                'soggetti'				=> array( 'active' => 1,      'public' => 1,       'hidden' => 0,       'singular' => __('Soggetto', SCM_THEME), 				'plural' => __('Soggetti', SCM_THEME), 				'slug' => 'soggetti', 			'icon' => 'f338',      'orderby' => 'title',       'ordertype' => '',      'post' => 0 ),
				'luoghi'				=> array( 'active' => 1,      'public' => 1,       'hidden' => 0,       'singular' => __('Luogo', SCM_THEME), 					'plural' => __('Luoghi', SCM_THEME), 				'slug' => 'luoghi', 			'icon' => 'f230',      'orderby' => 'title',       'ordertype' => '',      'post' => 0 ),
				'news'					=> array( 'active' => 0,      'public' => 1,       'hidden' => 0,       'singular' => __('News', SCM_THEME), 					'plural' => __('News', SCM_THEME), 					'slug' => 'news', 				'icon' => 'f488',      'orderby' => 'date',        'ordertype' => '' ),
				'documenti'				=> array( 'active' => 1,      'public' => 1,       'hidden' => 0,       'singular' => __('Documento', SCM_THEME), 				'plural' => __('Documenti', SCM_THEME), 			'slug' => 'documenti', 			'icon' => 'f322',      'orderby' => 'title',       'ordertype' => '' ),
				'gallerie'				=> array( 'active' => 1,      'public' => 1,       'hidden' => 0,       'singular' => __('Galleria', SCM_THEME), 				'plural' => __('Gallerie', SCM_THEME), 				'slug' => 'gallerie', 			'icon' => 'f161',      'orderby' => 'title',       'ordertype' => '' ),
				'video'					=> array( 'active' => 1,      'public' => 1,       'hidden' => 0,       'singular' => __('Video', SCM_THEME), 					'plural' => __('Video', SCM_THEME), 				'slug' => 'video', 				'icon' => 'f236',      'orderby' => 'title',       'ordertype' => '' ),
				'rassegne-stampa'		=> array( 'active' => 1,      'public' => 1,       'hidden' => 0,       'singular' => __('Rassegna Stampa', SCM_THEME),		    'plural' => __('Rassegne Stampa', SCM_THEME), 		'slug' => 'rassegne-stampa', 	'icon' => 'f336',      'orderby' => 'date',        'ordertype' => '',        'short-singular' => __('Rassegna', SCM_THEME),     'short-plural' => __('Rassegne', SCM_THEME), 	),
			);

            $default_taxonomies = array(
                'sliders'               => array( 'hierarchical' => 1,          'plural' => 'Sliders',         'singular' => 'Slider',         'slug' => 'sliders',                 'types' => [ 'slides' ] ),
                'soggetti-tipologie'    => array( 'hierarchical' => 1,          'plural' => 'Tipologie',       'singular' => 'Tipologia',      'slug' => 'soggetti-tipologie',      'types' => [ 'soggetti' ] ),
                'luoghi-categorie'      => array( 'hierarchical' => 1,          'plural' => 'Categorie',       'singular' => 'Categoria',      'slug' => 'soggetti-categorie',      'types' => [ 'luoghi' ] ),
                'documenti-tipologie'   => array( 'hierarchical' => 1,          'plural' => 'Tipologie',       'singular' => 'Tipologia',      'slug' => 'documenti-tipologie',     'types' => [ 'documenti' ] ),
                'video-categorie'       => array( 'hierarchical' => 1,          'plural' => 'Categorie',       'singular' => 'Categoria',      'slug' => 'video-categorie',         'types' => [ 'video' ] ),
                'gallerie-categorie'    => array( 'hierarchical' => 1,          'plural' => 'Categorie',       'singular' => 'Categoria',      'slug' => 'gallerie-categorie',      'types' => [ 'gallerie' ] ),
                'rassegne-categorie'    => array( 'hierarchical' => 1,          'plural' => 'Categorie',       'singular' => 'Categoria',      'slug' => 'rassegne-categorie',      'types' => [ 'rassegne-stampa' ] ),
                'rassegne-autori'       => array( 'hierarchical' => 0,          'plural' => 'Autori',          'singular' => 'Autore',         'slug' => 'rassegne-autori',         'types' => [ 'rassegne-stampa' ] ),
                'rassegne-testate'      => array( 'hierarchical' => 0,          'plural' => 'Testate',         'singular' => 'Testata',        'slug' => 'rassegne-testate',        'types' => [ 'rassegne-stampa' ] ),
            );

            $types = array_merge( $saved_types, $default_types );
            $taxonomies = array_merge( $saved_taxonomies, $default_taxonomies );

            foreach ( $types as $type ) {
                
                if( !isset( $type['plural'] ) )
                    continue;

                $plural = $type['plural'];

                $type['active'] = ( isset( $type['active'] ) && $type['active'] ? ( $type['active'] !== 'off' ? 1 : 0 ) : 0 );

                $type['public'] = ( isset( $type['public'] ) && $type['public'] ? ( $type['public'] !== 'off' ? 1 : 0 ) : 0 );

                $type['hidden'] = ( isset( $type['hidden'] ) ? $type['hidden'] : 0 );

                $type['orderby'] = ( isset( $type['orderby'] ) ? $type['orderby'] : 'title' );

                $type['ordertype'] = ( isset( $type['ordertype'] ) ? $type['ordertype'] : 'ASC' );

                $type['slug'] = ( isset( $type['slug'] ) && $type['slug'] ? sanitize_title( $type['slug'] ) : sanitize_title( $plural ) );

                $type['icon'] = ( isset( $type['icon'] ) && $type['icon'] ? '\\' . $type['icon'] : '' ) ;


                if( $type['active'] === 1 ){

                    $SCM_types['complete'][ $type['slug'] ] = $plural;

                    $obj = $SCM_types['objects'][ $type['slug'] ] = new Custom_Type( $type );
                    $obj->CT_register();

                    if( $type['public'] === 1 ){

                        $SCM_types['public'][ $type['slug'] ] = $plural;
                        $SCM_types['all'][ $type['slug'] ] = $plural;
                        $type['public'] = 0;
                        $type['hidden'] = 1;
                        $type['slug'] = $type['slug'] . '_temp';

                        $temp = $SCM_types['objects'][ $type['slug'] ] = new Custom_Type( $type );
                        $temp->CT_register();

                    }else{

                        $SCM_types['private'][ $type['slug'] ] = $plural;

                    }
                }
            }

            foreach ( $taxonomies as $tax ) {
                
                if( !isset( $tax['plural'] ) )
                    continue;

                $tplural = $tax['plural'];

                $tax['slug'] = ( isset( $tax['slug'] ) && $tax['slug'] ? sanitize_title( $tax['slug'] ) : sanitize_title( $tplural ) );

                if( $tax['hierarchical'] )
                    $SCM_types['taxonomies'][ $tax['slug'] ] = $SCM_types['categories'][ $tax['slug'] ] = new Custom_Taxonomy( $tax );
                else
                    $SCM_types['taxonomies'][ $tax['slug'] ] = $SCM_types['tags'][ $tax['slug'] ] = new Custom_Taxonomy( $tax );

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
            do_action( 'scm_action_acf_option_pages_before' );

            if( function_exists('acf_add_options_page') ) {

                acf_add_options_page(array(
                    'page_title'    => 'SCM Settings',
                    'menu_title'    => 'SCM',
                    'menu_slug'     => 'acf-options-general',
                    'position'      => '0.1',
                    'capability'    => 'administrator',
                    'redirect'      => true,
                ));

                acf_add_options_page(array(
                    'page_title'    => 'SCM Types',
                    'menu_title'    => 'SCM Types',
                    'menu_slug'     => 'acf-types-general',
                    'position'      => '0.2',
                    'capability'    => 'administrator',
                    'redirect'      => true,
                ));

                acf_add_options_page(array(
                    'page_title'    => 'SCM Templates',
                    'menu_title'    => 'SCM Templates',
                    'menu_slug'     => 'acf-templates-general',
                    'position'      => '0.3',
                    'capability'    => 'administrator',
                    'redirect'      => true,
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
                    'parent_slug'   => 'acf-options-general',
                ));

                acf_add_options_sub_page(array(
                    'page_title'    => 'SCM Layout Settings',
                    'menu_title'    => 'Layout',
                    'parent_slug'   => 'acf-options-general',
                ));

                acf_add_options_sub_page(array(
                    'page_title'    => 'SCM Design Settings',
                    'menu_title'    => 'Stili',
                    'parent_slug'   => 'acf-options-general',
                ));

                acf_add_options_sub_page(array(
                    'page_title'    => 'SCM Header Settings',
                    'menu_title'    => 'Header',
                    'parent_slug'   => 'acf-options-general',
                ));

                acf_add_options_sub_page(array(
                    'page_title'    => 'SCM Footer Settings',
                    'menu_title'    => 'Footer',
                    'parent_slug'   => 'acf-options-general',
                ));

                acf_add_options_sub_page(array(
                    'page_title'    => 'SCM Custom Types',
                    'menu_title'    => 'Types',
                    'menu_slug'     => 'acf-types-custom',
                    'parent_slug'   => 'acf-types-general',
                ));

                acf_add_options_sub_page(array(
                    'page_title'    => 'SCM Taxonomies Types',
                    'menu_title'    => 'Taxonomies',
                    'menu_slug'     => 'acf-types-taxonomies',
                    'parent_slug'   => 'acf-types-general',
                ));

                global $SCM_types;

                foreach ($SCM_types['public'] as $slug => $title) {
                    acf_add_options_sub_page(array(
                        'page_title'    => 'SCM ' . $title . ' Template',
                        'menu_title'    => $title,
                        'menu_slug'     => 'acf-templates-' . $slug,
                        'parent_slug'   => 'acf-templates-general',
                    ));
                }

            }

            // SCM Hook: After ACF Option Pages install
            do_action( 'scm_action_acf_option_pages' );
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
            }
            
            return $field;
        }
    }

    // REPEATER - REPEATER TEMPLATES
    if ( ! function_exists( 'scm_acf_loadfield_hook_template_list' ) ) {
        function scm_acf_loadfield_hook_template_list( $field ){

            if( !endsWith( $field['name'], '-templates' ) )
                return $field;

            $type = str_replace( '-templates', '_temp', $field['name'] );
            $posts = get_posts( [ 'post_type' => $type, 'orderby' => 'menu_order date' ] );

            foreach ( $posts as $p ) {

                $id = $p->post_name;

                $field['value'][ $id ] = [];

                foreach ($field['sub_fields'] as $v) {
                    if( endsWith( $v['key'], '-templates_id_text' ) ){
                        $field['value'][ $id ][ $v['key'] ] = $p->ID;
                    }

                    if( endsWith( $v['key'], '-templates_name_text' ) ){
                        $field['value'][ $id ][ $v['key'] ] = $p->post_title;
                    }
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
            if( $post_id != 'options' )
                return;

            $fields = $_POST['acf'];


            foreach ( $fields as $key => $value ) {
                $field = get_field_object($key, $post_id, false);
                if( $field['type'] == 'repeater' && endsWith( $field['name'], '-templates' ) ){
                    
                    $type = str_replace( '-templates', '_temp', $field['name']);

                    $posts = get_posts( [ 'post_type' => $type, 'orderby' => 'menu_order date' ] );
                    $pub = [];
                    foreach ( $posts as $p ) {
                        $pub[$p->ID] = $p->ID;
                    }

                    $i = sizeof( $value );

                    if( isset( $value ) && !empty( $value ) ){

                        foreach ( $value as $ui => $temp ) {

                            $i--;
                            $id = 0;
                            $name = '';
                            $id_key = '';

                            foreach ( $temp as $k => $v ) {
                                if( endsWith( $k, '-templates_id_text' ) )
                                    $id = (int)$v;

                                if( endsWith( $k, '-templates_name_text' ) )
                                    $name = $v;
                            }
                            
                            $name = ( $name ?: (string)$id );

                            $the_post = array(
                                'post_title'    => $name,
                                'post_name'     => $ui,
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

                    $_POST['acf'] = [];
                }
            }
        }
    }

    // LUOGHI - Lat and Lng
    // +++ todo: con jQuery aggiorni i campi dinamicamente, ogni volta che uno degli altri campi cambia
    if ( ! function_exists( 'scm_acf_savepost_hook_luoghi_latlng' ) ) {
        function scm_acf_savepost_hook_luoghi_latlng( $post_id ) {
           
            if( empty($_POST['acf']) || !isset( $_POST['post_type'] ) )
                return;
            if( $_POST['post_type'] != 'luoghi' )
                return;

            $fields = $_POST['acf'];
            
            $country = $fields['field_luoghi-single_luogo-paese_text'];
            $region = $fields['field_luoghi-single_luogo-regione_text'];
            $province = $fields['field_luoghi-single_luogo-provincia_text'];
            $code = $fields['field_luoghi-single_luogo-cap_text'];
            $city = $fields['field_luoghi-single_luogo-citta_text'];
            $town = $fields['field_luoghi-single_luogo-frazione_text'];
            $address = $fields['field_luoghi-single_luogo-indirizzo_text'];

            $google_address = $address . ' ' . $town . ' ' . $code . ' ' . $city . ' ' . $province . ' ' . $region;

            $ll = getGoogleMapsLatLng( $google_address, $country );
            $lat = $ll['lat'];
            $lng = $ll['lng'];

            $_POST['acf']['field_luoghi-single_luogo-lat_number'] = $lat;
            $_POST['acf']['field_luoghi-single_luogo-lng_number'] = $lng; 
        }
    }

    // ALL - TAXONOMIES LIST
    if ( ! function_exists( 'scm_acf_savepost_hook_all_taxonomies' ) ) {
        function scm_acf_savepost_hook_all_taxonomies( $post_id ) {

            if( empty( $_POST['acf'] ) )
                return;

            $fields = $_POST['acf'];

            $list = scm_field_objects( $post_id, $fields, 'taxonomy', [ 'load_save_terms' => 1, 'name' => 'terms' ] );
            $add = scm_field_objects( $post_id, $fields, 'text', [ 'name' => 'new-term' ] );

            foreach ($list as $field) {
                $tax = $field['taxonomy'];
                $name = str_replace( 'terms', '', $field['name']);
                $news = getByValueKey( $add, $name . 'new-term' );

                if( $news !== false ){
                    $key = $add[ $news ]['key'];
                    $value = $fields[ $key ];
                    $new = explode( ',', $value );
                    $_POST['acf'][ $key ] = '';
                    foreach ( $new as $term ) {

                        $term = ( strpos( $term, ' ') === 0 ? substr( $term, 1 ) : $term );

                        $t = wp_insert_term( $term, $tax );
                        if( !is_wp_error( $t ) )
                            $_POST['acf'][ $field['key'] ][] = $t['term_id'];
                    }
                }
            }
        }
    }


// *****************************************************
// *      6.0 ACF FIELDS INSTALLATION
// *****************************************************


    if ( ! function_exists( 'scm_acf_types_install' ) ) {
        function scm_acf_types_install() {

            if( function_exists('register_field_group') ) {

                $types = scm_acf_group( 'Types', 'types-options' );
                $types['location'][] = scm_acf_group_location( 'acf-types-custom', 1, 'options_page' );
                $types['fields'] = scm_acf_options_types();

                $groups[] = $types;
                
                // + TAXONOMIES
                $taxonomies = scm_acf_group( 'Taxonomies', 'taxonomies-options' );
                $taxonomies['location'][] = scm_acf_group_location( 'acf-types-taxonomies', 1, 'options_page' );
                $taxonomies['fields'] = scm_acf_options_taxonomies();

                $groups[] = $taxonomies;

                scm_acf_group_register( $types );
                scm_acf_group_register( $taxonomies );              

            }
        }
    }

    if ( ! function_exists( 'scm_acf_install' ) ) {
        function scm_acf_install() {
            if( function_exists('register_field_group') ) {

// SCM Filter: Passing empty Array - Receiving Array of Groups
                $groups = apply_filters( 'scm_filter_acf_register_before', array() );

// OPTIONS

                // + OPT GENERAL
                $general = scm_acf_group( 'Opzioni Stili', 'general-options' );
                $general['location'][] = scm_acf_group_location( 'acf-options-opzioni', 1, 'options_page' );
                $general['fields'] = scm_acf_options_general();

                $groups[] = $general;

                // + OPT STYLE
                $style = scm_acf_group( 'Stili', 'styles-options' );
                $style['location'][] = scm_acf_group_location( 'acf-options-stili', 1, 'options_page' );
                $style['fields'] = scm_acf_options_styles();

                $groups[] = $style;

                // + OPT STILI
                $options_default = scm_acf_group( 'Opzioni', 'style-options' );
                $options_default['location'][] = scm_acf_group_location( 'acf-options-stili', 1, 'options_page' );
                $options_default['fields'] = array_merge( $options_default['fields'], scm_acf_options_style() );

                $groups[] = $options_default;

                // + OPT LAYOUT
                $layout = scm_acf_group( 'Layout', 'layout-options' );
                $layout['location'][] = scm_acf_group_location( 'acf-options-layout', 1, 'options_page' );
                $layout['fields'] = scm_acf_options_layout();

                $groups[] = $layout;
                
                // + OPT HEAD
                $head = scm_acf_group( 'Header', 'head-options' );
                $head['location'][] = scm_acf_group_location( 'acf-options-header', 1, 'options_page' );
                $head['fields'] = array_merge( $head['fields'], scm_acf_options_head() );

                $groups[] = $head;

                // + OPT FOOTER
                $footer = scm_acf_group( 'Componi Footer', 'foot-options' );
                $footer['location'][] = scm_acf_group_location( 'acf-options-footer', 1, 'options_page' );
                $footer['fields'][] = scm_acf_options_foot();

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

                // + CONTATTO
                $contatto = scm_acf_group( 'Contatti', 'contatti-single' );
                $contatto['location'][] = scm_acf_group_location( 'luoghi' );
                $contatto['fields'] = scm_acf_fields_contatto();

                $groups[] = $contatto;

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

                // + PAGE
                $page = scm_acf_group( 'Componi Pagina', 'pages-single' );
                $page['location'][] = scm_acf_group_location( 'page' );
                $page['fields'] = scm_acf_fields_page();

                $groups[] = $page;

                // + SECTION
                $section = scm_acf_group( 'Componi Sezione', 'sections-single' );
                $section['location'][] = scm_acf_group_location( 'sections' );
                $section['fields'] = scm_acf_fields_section();

                $groups[] = $section;

// MODELLI

                global $SCM_types;

                foreach ($SCM_types['public'] as $slug => $title) {

                    $template = scm_acf_group( 'Componi Modello', 'template-' . $slug );
                    $template['location'][] = scm_acf_group_location( 'acf-templates-' . $slug, 1, 'options_page' );
                    $template['fields'][] = scm_acf_fields_template( $slug );

                    $groups[] = $template;

                    $template = scm_acf_group( 'Modello ' . $title, $slug . '_temp-single' );
                    $template['location'][] = scm_acf_group_location( $slug . '_temp' );
                    
                    $part = strpos( $slug, '-' );
                    $slug = ( $part !== false ? substr( $slug, 0, $part ) : $slug );

                    if( function_exists( 'scm_acf_layout_' . $slug ) )
                        $template['fields'] = array_merge( $template['fields'], call_user_func( 'scm_acf_layout_' . $slug ) );

                    $groups[] = $template;
                }

// OPTIONS SINGLE

                // + ATTACHMENTS
                $attachments = scm_acf_group( 'Allegati', 'attachments-single' );
                $attachments['location'][] = scm_acf_group_location( 'post' );
                $attachments['fields'][] = scm_acf_preset_repeater_files();

                $groups[] = $attachments;

                // + EXTERNAL LINKS
                $external = scm_acf_group( 'Link Esterni', 'externals-single' );
                $external['location'][] = scm_acf_group_location( 'post' );
                $external['fields'][] = scm_acf_preset_repeater_links();

                $groups[] = $external;

                // + INTERNAL LINKS
                /*$internal = scm_acf_group( 'Link Interni', 'internals-single' );
                $internal['location'][] = scm_acf_group_location( 'post' );
                $internal['fields'][] = scm_acf_field_internal_links( 'single', 1 );

                $groups[] = $internal;*/

                // + OPTIONS
                $options = scm_acf_group( 'Opzioni Stili', 'style-single' );
                $options['location'][] = scm_acf_group_location( 'sections' );
                $options['location'][] = scm_acf_group_location( 'page' );
                $options['fields'] = array_merge( $options['fields'], scm_acf_options_style( '', 1 ) );

                $groups[] = $options;

                // + OPTIONS SLIDER
                $slider = scm_acf_group( 'Opzioni Slider', 'slider-single' );
                $slider['location'][] = scm_acf_group_location( 'page' );

                //$slider['fields'][] = scm_acf_field( 'tab-options-slider', 'tab-left', 'Slider' );
                    $slider['fields'] = array_merge( $slider['fields'], scm_acf_options_slider( '', 1 ) );

                $groups[] = $slider;

// SCM Filter: Passing Array of Groups - Receiving Array of Groups

                $groups = apply_filters( 'scm_filter_acf_register', $groups );

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
                    'name'               => 'ACF PayPal', // The plugin name.
                    'slug'               => 'acf-paypal-field-master', // The plugin slug (typically the folder name).
                    'source'             => 'acf-paypal-field-master.zip', // The plugin source.
                    'required'           => true, // If false, the plugin is only 'recommended' instead of required.
                    'force_activation'   => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
                    'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
                ),

                array(
                    'name'               => 'ACF Font Awesome', // The plugin name.
                    'slug'               => 'advanced-custom-fields-font-awesome', // The plugin slug (typically the folder name).
                    'source'             => 'advanced-custom-fields-font-awesome.zip', // The plugin source.
                    'required'           => true, // If false, the plugin is only 'recommended' instead of required.
                    'force_activation'   => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
                    'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
                ),

                array(
                    'name'               => 'ACF Limiter', // The plugin name.
                    'slug'               => 'advanced-custom-fields-limiter-field', // The plugin slug (typically the folder name).
                    'source'             => 'advanced-custom-fields-limiter-field.zip', // The plugin source.
                    'required'           => true, // If false, the plugin is only 'recommended' instead of required.
                    'force_activation'   => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
                    'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
                ),

                array(
                    'name'               => 'ACF Date Time', // The plugin name.
                    'slug'               => 'acf-field-date-time-picker', // The plugin slug (typically the folder name).
                    'source'             => 'acf-field-date-time-picker.zip', // The plugin source.
                    'required'           => true, // If false, the plugin is only 'recommended' instead of required.
                    'force_activation'   => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
                    'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
                ),

                array(
                    'name'               => 'Contact Form 7', // The plugin name.
                    'slug'               => 'contact-form-7', // The plugin slug (typically the folder name).
                    'source'             => 'contact-form-7.zip', // The plugin source.
                    'required'           => true, // If false, the plugin is only 'recommended' instead of required.
                    'force_activation'   => true, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
                    'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
                ),

                array(
                    'name'               => 'Captcha 7', // The plugin name.
                    'slug'               => 'really-simple-captcha', // The plugin slug (typically the folder name).
                    'source'             => 'really-simple-captcha.zip', // The plugin source.
                    'required'           => false, // If false, the plugin is only 'recommended' instead of required.
                    'force_activation'   => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
                    'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
                ),

                array(
                    'name'               => 'Polylang', // The plugin name.
                    'slug'               => 'polylang', // The plugin slug (typically the folder name).
                    'source'             => 'polylang.zip', // The plugin source.
                    'required'           => false, // If false, the plugin is only 'recommended' instead of required.
                    'force_activation'   => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
                    'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
                ),

                array(
                    'name'               => 'Replace Media', // The plugin name.
                    'slug'               => 'enable-media-replace', // The plugin slug (typically the folder name).
                    'source'             => 'enable-media-replace.zip', // The plugin source.
                    'required'           => false, // If false, the plugin is only 'recommended' instead of required.
                    'force_activation'   => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
                    'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
                ),

                array(
                    'name'               => 'Thumbs Regenerator', // The plugin name.
                    'slug'               => 'regenerate-thumbnails', // The plugin slug (typically the folder name).
                    'source'             => 'regenerate-thumbnails.zip', // The plugin source.
                    'required'           => false, // If false, the plugin is only 'recommended' instead of required.
                    'force_activation'   => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
                    'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
                ),

                array(
                    'name'               => 'Browser Detection', // The plugin name.
                    'slug'               => 'php-browser-detection', // The plugin slug (typically the folder name).
                    'source'             => 'php-browser-detection.zip', // The plugin source.
                    'required'           => true, // If false, the plugin is only 'recommended' instead of required.
                    'force_activation'   => true, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
                    'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
                ),


                // +++ todo: elimina plugin social e renditi autonomo

                // - FOLLOW:    opzioni [ quali, link, stile ]         back - single Soggetti / Persone    [ quali, link, stile ]          front - single $post->Soggetti/Persone  [ attiva, dove ]
                // - SHARE:     opzioni [ quali, stile ]                                                                                   front - single $post->All               [ attiva, dove ]
                // - LIKES:     opzioni [ quali, stile ]                                                                                   front - single $post->All               [ attiva, dove ]

                array(
                    'name'               => 'Social Media Feather', // The plugin name.
                    'slug'               => 'social-media-feather', // The plugin slug (typically the folder name).
                    'source'             => 'social-media-feather.zip', // The plugin source.
                    'required'           => false, // If false, the plugin is only 'recommended' instead of required.
                    'force_activation'   => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
                    'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
                ),

                // +++

                array(
                    'name'               => 'Admin Menu Editor', // The plugin name.
                    'slug'               => 'admin-menu-editor', // The plugin slug (typically the folder name).
                    'source'             => 'admin-menu-editor.zip', // The plugin source.
                    'required'           => false, // If false, the plugin is only 'recommended' instead of required.
                    'force_activation'   => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
                    'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
                ),

                array(
                    'name'               => 'Optimize Database', // The plugin name.
                    'slug'               => 'rvg-optimize-database', // The plugin slug (typically the folder name).
                    'source'             => 'rvg-optimize-database.zip', // The plugin source.
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

            );

            $config = array(
                'default_path' => SCM_DIR_PLUGINS,         // Default absolute path to pre-packaged plugins.
                'menu'         => 'scm-install-plugins',   // Menu slug.
                'has_notices'  => true,                    // Show admin notices or not.
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