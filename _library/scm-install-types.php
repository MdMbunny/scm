<?php

/**
* SCM install types.
*
* @link http://www.studiocreativo-m.it
*
* @package SCM
* @subpackage 3-Install/Types
* @since 1.0.0
*/

// ------------------------------------------------------
//
// ACTIONS AND FILTERS
// FUNCTIONS
//
// ------------------------------------------------------

// ------------------------------------------------------
// ACTIONS AND FILTERS
// ------------------------------------------------------

add_action( 'acf/include_fields', 'scm_hook_types_fields' );
add_action( 'acf/include_fields', 'scm_hook_types_default' );
add_action( 'acf/include_fields', 'scm_hook_types_custom' );
add_action( 'acf/include_fields', 'scm_hook_types_capabilities' );

// ------------------------------------------------------

/**
* [SET] Custom types and taxonomies fields
*
* Hooked by 'acf/include_fields'
* @subpackage 3-Install/Types/HOOKS
*
*/
function scm_hook_types_fields() {

    if( function_exists('register_field_group') ) {

        consoleDebug('install custom types fields');

        $types = scm_acf_group( 'Types', 'types-options' );
        $types['location'][] = scm_acf_group_location( 'scm-custom-types', 'options_page' );
        $types['fields'] = scm_acf_options_types();

        scm_acf_group_register( $types );

        consoleDebug('install custom taxes fields');

        $taxonomies = scm_acf_group( 'Taxonomies', 'taxonomies-options' );
        $taxonomies['location'][] = scm_acf_group_location( 'scm-custom-taxonomies', 'options_page' );
        $taxonomies['fields'] = scm_acf_options_taxonomies();

        scm_acf_group_register( $taxonomies );
    }
}

/**
* [SET] Default types and taxonomies
*
* Hooked by 'acf/include_fields'
* @subpackage 3-Install/Types/HOOKS
*
* Hooks:
```php
// Filters default types before installed
$default_types = apply_filters( 'scm_filter_default_types', $default_types );

// Filters default taxonomies before installed
$default_taxonomies = apply_filters( 'scm_filter_default_taxonomies', $default_taxonomies );
```
*/
function scm_hook_types_default(){

    // DEFAULT GLOBAL ARRAY
    global $SCM_types;

    $SCM_types = array(
        'objects' => array(),
        'private' => array(),
        'public' => array(),
        'custom' => array(),
        'settings' => array(),
        'all' => array(
            'wpcf7_contact_form'    => 'Contact Form',
        ),
        'complete' => array(
            'page'                  => 'Pagine',
            'wpcf7_contact_form'    => 'Contact Form',
        ),
    );

    // SET DEFAULT
    consoleDebug('install default types and taxes');

    $default_types = array(
        'sections'              => array(
            'admin' => 1,
            'custom' => 1,
            'add_cap' => 0,
            'active' => 1,
            'public' => 0,
            'hidden' => 0,
            'post' => 0,
            'link' => '',
            'link-field' => '',
            'singular' => __('Section', SCM_THEME),
            'plural' => __('Sections', SCM_THEME),
            'slug' => 'sections',
            'fa-icon' => 'fa-columns-s',
            'icon' => 'schedule',
            'orderkey' => '',
            'orderby' => 'title',
            'ordertype' => '',
            'menupos' => 0,
            'menu' => 'pages',
        ),
        'modules'               => array(
            'admin' => 0,
            'custom' => 1,
            'add_cap' => 0,
            'active' => 1,
            'public' => 0,
            'hidden' => 0,
            'post' => 0,
            'link' => '',
            'link-field' => '',
            'singular' => __('Module', SCM_THEME),
            'plural' => __('Modules', SCM_THEME),
            'slug' => 'modules',
            'fa-icon' => 'fa-table-s',
            'icon' => 'screenoptions',
            'orderkey' => '',
            'orderby' => 'title',
            'ordertype' => '',
            'menupos' => 0,
            'menu' => 'pages',
        ),
        'banners'               => array(
            'admin' => 0,
            'custom' => 1,
            'add_cap' => 0,
            'active' => 1,
            'public' => 0,
            'hidden' => 0,
            'post' => 0,
            'link' => '',
            'link-field' => '',
            'singular' => __('Banner', SCM_THEME),
            'plural' => __('Banners', SCM_THEME),
            'slug' => 'banners',
            'fa-icon' => 'fa-list-alt-s',
            'icon' => 'align-center',
            'orderkey' => '',
            'orderby' => 'title',
            'ordertype' => '',
            'menupos' => 0,
            'menu' => 'pages',
        ),
        'eventi'                => array(
            'admin' => 0,
            'custom' => 1,
            'add_cap' => 1,
            'active' => 1,
            'public' => 1,
            'hidden' => 0,
            'post' => 1,
            'link' => 'popup',
            'link-field' => '',
            'singular' => __('Evento', SCM_THEME),
            'plural' => __('Eventi', SCM_THEME),
            'slug' => 'eventi',
            'fa-icon' => 'fa-thumb-tack-s',
            'icon' => 'calendar-alt',
            'orderkey' => 'start-date', 
            'orderby' => 'meta_value',
            'ordertype' => '',
            'menupos' => 0,
            'menu' => 'types',
        ),
        'news'                  => array(
            'admin' => 0,
            'custom' => 1,
            'add_cap' => 1,
            'active' => 1,
            'public' => 1,
            'hidden' => 0,
            'post' => 1,
            'link' => 'popup',
            'link-field' => '',
            'singular' => __('News', SCM_THEME),
            'plural' => __('News', SCM_THEME),
            'slug' => 'news',
            'fa-icon' => 'fa-bullhorn-s',
            'icon' => 'megaphone',
            'orderkey' => '',
            'orderby' => 'date',
            'ordertype' => '',
            'menupos' => 0,
            'menu' => 'types',
        ),
        'articoli'              => array(
            'admin' => 0,
            'custom' => 1,
            'add_cap' => 1,
            'active' => 1,
            'public' => 1,
            'hidden' => 0,
            'post' => 1,
            'link' => 'popup',
            'link-field' => '',
            'singular' => __('Articolo', SCM_THEME),
            'plural' => __('Articoli', SCM_THEME),
            'slug' => 'articoli',
            'fa-icon' => 'fa-newspaper-s',
            'icon' => 'admin-post',
            'orderkey' => '',
            'orderby' => 'date',
            'ordertype' => '',
            'menupos' => 0,
            'menu' => 'types',
        ),
        'slides'                => array(
            'admin' => 0,
            'custom' => 1,
            'add_cap' => 1,
            'active' => 1,
            'public' => 1,
            'hidden' => 0,
            'post' => 1,
            'link' => '',
            'link-field' => '',
            'singular' => __('Slide', SCM_THEME),
            'plural' => __('Slides', SCM_THEME),
            'slug' => 'slides',
            'fa-icon' => 'fa-image-s',
            'icon' => 'format-image',
            'orderkey' => '',
            'orderby' => 'date',
            'ordertype' => '',
            'menupos' => 0,
            'menu' => 'media',
        ),
        'gallerie'              => array(
            'admin' => 0,
            'custom' => 1,
            'add_cap' => 1,
            'active' => 1,
            'public' => 1,
            'hidden' => 0,
            'post' => 1,
            'link' => 'gallery',
            'link-field' => 'galleria-images',
            'singular' => __('Galleria', SCM_THEME),
            'plural' => __('Gallerie', SCM_THEME),
            'slug' => 'gallerie',
            'fa-icon' => 'fa-camera-retro-s',
            'icon' => 'format-gallery',
            'orderkey' => '',
            'orderby' => 'title',
            'ordertype' => '',
            'menupos' => 0,
            'menu' => 'media',
        ),
        'video'                 => array(
            'admin' => 0,
            'custom' => 1,
            'add_cap' => 1,
            'active' => 1,
            'public' => 1,
            'hidden' => 0,
            'post' => 1,
            'link' => 'video',
            'link-field' => 'video-url',
            'singular' => __('Video', SCM_THEME),
            'plural' => __('Video', SCM_THEME),
            'slug' => 'video',
            'fa-icon' => 'fa-youtube-b',
            'icon' => 'video-alt3',
            'orderkey' => '',
            'orderby' => 'title',
            'ordertype' => '',
            'menupos' => 0,
            'menu' => 'media',
        ),
        'documenti'             => array(
            'admin' => 0,
            'custom' => 1,
            'add_cap' => 1,
            'active' => 1,
            'public' => 1,
            'hidden' => 0,
            'post' => 1,
            'link' => 'file',
            'link-field' => 'documento-file',
            'singular' => __('Documento', SCM_THEME),
            'plural' => __('Documenti', SCM_THEME),
            'slug' => 'documenti',
            'fa-icon' => 'fa-file-s',
            'icon' => 'portfolio',
            'orderkey' => '',
            'orderby' => 'title',
            'ordertype' => '',
            'menupos' => 0,
            'menu' => 'media',
        ),
        'rassegne-stampa'       => array(
            'admin' => 0,
            'custom' => 1,
            'add_cap' => 1,
            'active' => 1,
            'public' => 1,
            'hidden' => 0,
            'post' => 1,
            'link' => 'link',
            'link-field' => array( 'rassegna-type' => array( 'file'=>'rassegna-file', 'link'=>'rassegna-link' ) ),
            'singular' => __('Rassegna Stampa', SCM_THEME),
            'plural' => __('Rassegne Stampa', SCM_THEME),
            'slug' => 'rassegne-stampa',
            'fa-icon' => 'fa-file-text-s',
            'icon' => 'id',
            'orderkey' => '',
            'orderby' => 'date',
            'ordertype' => '',
            'menupos' => 0,
            'menu' => 'media',
            'short-singular' => __('Rassegna', SCM_THEME),
            'short-plural' => __('Rassegne', SCM_THEME),
        ),
        'soggetti'              => array(
            'admin' => 0,
            'custom' => 1,
            'add_cap' => 1,
            'active' => 1,
            'public' => 1,
            'hidden' => 0,
            'post' => 0,
            'link' => 'link',
            'link-field' => 'soggetto-link',
            'singular' => __('Soggetto', SCM_THEME),
            'plural' => __('Soggetti', SCM_THEME),
            'slug' => 'soggetti',
            'fa-icon' => 'fa-users-s',
            'icon' => 'groups',
            'orderkey' => '',
            'orderby' => 'title',
            'ordertype' => '',
            'menupos' => 1,
            'menu' => 'contacts',
        ),
        'luoghi'                => array(
            'admin' => 0,
            'custom' => 1,
            'add_cap' => 1,
            'active' => 1,
            'public' => 1,
            'hidden' => 0,
            'post' => 0,
            'link' => 'link',
            'link-field' => 'map',
            'singular' => __('Luogo', SCM_THEME),
            'plural' => __('Luoghi', SCM_THEME),
            'slug' => 'luoghi',
            'fa-icon' => 'fa-map-marker-alt-s',
            'icon' => 'location',
            'orderkey' => '',
            'orderby' => 'title',
            'ordertype' => '',
            'menupos' => 1,
            'menu' => 'contacts',
        ),
    );

    $default_taxonomies = array(
        'sections-cat'          => array( 'template' => 0,       'add_cap' => 0,        'active' => 1,      'hierarchical' => 0,          'plural' => __('Categorie Sezioni', SCM_THEME),          'singular' => __('Categoria Sezioni', SCM_THEME),      'slug' => 'sections-cat',              'types' => array( 'sections' ),         ),
        'sliders'               => array( 'template' => 0,       'add_cap' => 0,        'active' => 1,      'hierarchical' => 1,          'plural' => __('Sliders', SCM_THEME),                    'singular' => __('Slider', SCM_THEME),                 'slug' => 'sliders',                   'types' => array( 'slides' )            ),
        'soggetti-tip'          => array( 'template' => 0,       'add_cap' => 0,        'active' => 1,      'hierarchical' => 1,          'plural' => __('Tipologie Soggetti', SCM_THEME),         'singular' => __('Tipologia Soggetti', SCM_THEME),     'slug' => 'soggetti-tip',              'types' => array( 'soggetti' )          ),
        'luoghi-tip'            => array( 'template' => 0,       'add_cap' => 0,        'active' => 1,      'hierarchical' => 1,          'plural' => __('Tipologie Luoghi', SCM_THEME),           'singular' => __('Tipologia Luoghi', SCM_THEME),       'slug' => 'luoghi-tip',                'types' => array( 'luoghi' ),           ),
        'luoghi-cat'            => array( 'template' => 0,       'add_cap' => 0,        'active' => 1,      'hierarchical' => 0,          'plural' => __('Categorie Luoghi', SCM_THEME),           'singular' => __('Categoria Luoghi', SCM_THEME),       'slug' => 'luoghi-cat',                'types' => array( 'luoghi' ),           ),
        'eventi-cat'            => array( 'template' => 0,       'add_cap' => 0,        'active' => 1,      'hierarchical' => 0,          'plural' => __('Categorie Eventi', SCM_THEME),           'singular' => __('Categoria Eventi', SCM_THEME),       'slug' => 'eventi-cat',                'types' => array( 'eventi' ),           ),
        'news-cat'              => array( 'template' => 0,       'add_cap' => 0,        'active' => 1,      'hierarchical' => 0,          'plural' => __('Categorie News', SCM_THEME),             'singular' => __('Categoria News', SCM_THEME),         'slug' => 'news-cat',                  'types' => array( 'news' ),             ),
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

    // CREATE DEFAULT TYPES FIELDS
    consoleDebug('install default types fields');
    $types = subArray( $default_types, 'plural', '', array( 'admin' => 0 ) );
    $group_types = scm_acf_group( 'Disable Default Types', 'default-types-options' );
    $group_types['location'][] = scm_acf_group_location( 'scm-default-types', 'options_page' );
    $group_types['fields'] = scm_acf_options_default_types( $types, $types );
    scm_acf_group_register( $group_types );

    $saved_types = scm_field( 'default-types-list', 0, 'option' );
    if( isset( $saved_types ) && is_array( $saved_types ) ){
        foreach ($saved_types as $key => $value) {
            unset( $default_types[ $value ] );
        }
    }

    // CREATE DEFAULT TAXONOMIES FIELDS
    consoleDebug('install default taxes fields');
    $taxes = subArray( $default_taxonomies, 'plural' );
    $group_taxonomies = scm_acf_group( 'Disable Default Taxonomies', 'default-taxonomies-options' );
    $group_taxonomies['location'][] = scm_acf_group_location( 'scm-default-taxonomies', 'options_page' );
    $group_taxonomies['fields'] = scm_acf_options_default_taxonomies( $taxes, $taxes );
    scm_acf_group_register( $group_taxonomies );

    $saved_taxonomies = scm_field( 'default-taxonomies-list', 0, 'option' );
    if( isset( $saved_taxonomies ) && is_array( $saved_taxonomies ) ){
        foreach ($saved_taxonomies as $key => $value) {
            unset( $default_taxonomies[ $value ] );
        }
    }

    // INSTALL
    scm_types_install( $default_types );
    scm_taxonomies_install( $default_taxonomies );
}

/**
* [SET] Custom types and taxonomies
*
* Hooked by 'acf/include_fields'
* @subpackage 3-Install/Types/HOOKS
*
*/
function scm_hook_types_custom(){

    consoleDebug('install custom types and taxes');

    $saved_types = scm_field( 'types-list', array(), 'option' );
    $saved_types = apply_filters( 'scm_filter_custom_types', $saved_types );
    scm_types_install( $saved_types );

    $saved_taxonomies = scm_field( 'taxonomies-list', array(), 'option' );
    $saved_taxonomies = apply_filters( 'scm_filter_custom_taxonomies', $saved_taxonomies );
    scm_taxonomies_install( $saved_taxonomies );
}

/**
* [SET] Roles capabilities for types and taxonomies
*
* Hooked by 'acf/include_fields'
* @subpackage 3-Install/Types/HOOKS
*
* Hooks:
```php
// Custom type capabilities
do_action( 'scm_action_types_capabilities', $obj->cap_plural, $obj->admin, $obj->add_cap );
```
*/
function scm_hook_types_capabilities(){

    if( is_admin() && !get_option( 'scm-capabilities-installed' ) ){
        update_option( 'scm-capabilities-installed', 1 );
        
        global $SCM_types;
        $objs = $SCM_types['objects'];

        foreach ($objs as $key => $obj)
            do_action( 'scm_action_types_capabilities', $obj->cap_plural, $obj->admin, $obj->add_cap );
    }
}

// ------------------------------------------------------
// 1.0 FUNCTIONS
// ------------------------------------------------------

/**
* [SET] Install types
*
* @subpackage 3-Install/Types/FUNCTIONS
*
* @param {array} types List of types.
*/
function scm_types_install( $types = NULL ){

    if( !class_exists('Custom_Type') || is_null($types) || !isset($types) || !is_array($types) || sizeof($types) === 0 ) return;

    global $SCM_types;

    foreach ( $types as $type ) {

        if( !isset( $type['plural'] ) )
            continue;

        $SCM_types['settings'][ $type['slug'] ] = $type;

        $plural = $type['plural'];
        $type['admin'] = (int)is_attr( $type, 'admin', 0 );
        $type['active'] = (int)is_attr( $type, 'active', 0 );
        $type['public'] = (int)is_attr( $type, 'public', 0 );
        $type['hidden'] = (int)is_attr( $type, 'hidden', 0 );
        $type['orderby'] = is_attr( $type, 'orderby', 'title' );
        $type['orderby'] = ( $type['orderby'] == 'meta_value' ? is_attr( $type, 'orderkey', 'title' ) : $type['orderby'] );
        $type['ordertype'] = is_attr( $type, 'ordertype', 'ASC' );
        $type['singular'] = is_attr( $type, 'singular', $plural );
        $type['slug'] = sanitize_title( is_attr( $type, 'slug', $plural ) );
        $type['icon'] = is_attr( $type, 'icon', '', '\\' );
        $type['fa-icon'] = is_attr( $type, 'fa-icon', '' );

        if( $type['active'] === 1 ){

            $SCM_types['complete'][ $type['slug'] ] = $plural;
            $SCM_types['custom'][ $type['slug'] ] = $plural;
            $obj = $SCM_types['objects'][ $type['slug'] ] = new Custom_Type( $type, SCM_THEME );
            $obj->register();

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

                $temp = $SCM_types['objects'][ $type['slug'] ] = new Custom_Type( $type, SCM_THEME );
                $temp->register();

            }else{

                $SCM_types['private'][ $type['slug'] ] = $plural;

            }
        }
    }
    //flush_rewrite_rules();
}

/**
* [SET] Install taxonomies
*
* @subpackage 3-Install/Types/FUNCTIONS
*
* @param {array} taxonomies List of taxonomies.
*/
function scm_taxonomies_install( $taxonomies = NULL ){

    if( !class_exists('Custom_Taxonomy') || is_null($taxonomies) || !isset($taxonomies) || !is_array($taxonomies) || sizeof($taxonomies) === 0 ) return;

    global $SCM_types;

    foreach ( $taxonomies as $tax ) {

        if( !isset( $tax['plural'] ) )
            continue;

        $plural = $tax['plural'];

        $tax['singular'] = is_attr( $tax, 'singular', $plural );
        $tax['slug'] = sanitize_title( is_attr( $tax, 'slug', $plural ) );
        $tax['add_cap'] = (int)is_attr( $tax, 'add_cap', 0 );
        $tax['template'] = (int)is_attr( $tax, 'template', 0 );
        $tax['active'] = (int)is_attr( $tax, 'active', 0 );

        if( $tax['active'] === 1 ){

            $obj = $SCM_types['taxonomies'][ $tax['slug'] ] = $SCM_types[ ( $tax['hierarchical'] ? 'categories' : 'tags' ) ][ $tax['slug'] ] = new Custom_Taxonomy( $tax, SCM_THEME );
            $obj->register();

            if( $tax['template'] === 1 ){

                $tax_type = array();

                $tax_type['plural'] = __( 'Modello', SCM_THEME ) . ' ' . $plural;
                $tax_type['singular'] = __( 'Modello', SCM_THEME ) . ' ' . $obj->singular;
                $tax_type['hidden'] = 1;
                $tax_type['admin'] = 1;
                $tax_type['slug'] = $tax['slug'] . SCM_TEMPLATE_APP;
                $tax_type['menu'] = 0;
                $tax_type['post'] = 0;

                $tax_temp = $SCM_types['objects'][ $tax_type['slug'] ] = new Custom_Type( $tax_type, SCM_THEME );
                $tax_temp->register();
            }
        }
    }
}

?>