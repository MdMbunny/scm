<?php

/**
* SCM install ACF.
*
* @link http://www.studiocreativo-m.it
*
* @package SCM
* @subpackage 3-Install/ACF
* @since 1.0.0
*/

// ------------------------------------------------------
//
// ACTIONS AND FILTERS
//      0.2 ACF Option Pages
//      0.3 ACF Fields
//      0.4 ACF Admin Menu
// FILTERS
//      1.1 ACF / Load Field
//      1.2 ACF / Save Post
//      1.3 ACF / Query Field
//      1.4 ACF / Format Value
//
// ------------------------------------------------------

// ------------------------------------------------------
// ACTIONS AND FILTERS
// ------------------------------------------------------

add_action( 'acf/init', 'scm_hook_acf_libraries' );

add_action( 'acf/include_fields', 'scm_hook_acf_option_pages_install', 10 );
add_action( 'acf/include_fields', 'scm_hook_acf_option_subpages_install', 10 );

add_action( 'acf/include_fields', 'scm_hook_acf_install', 10 );

add_filter( 'scm_filter_admin_ui_menu_order', 'scm_hook_acf_option_menu_order' );
add_filter( 'acf/settings/show_admin', 'scm_hook_acf_admin_hide' );

add_filter( 'acf/load_field', 'scm_hook_acf_loadfield_hook_choices_get', 100) ;
add_filter( 'acf/load_field/type=repeater', 'scm_hook_acf_loadfield_hook_repeater_list', 100 );
add_filter( 'acf/load_field/type=font-awesome', 'scm_hook_acf_loadfield_hook_fontawesome_list', 150 );

add_filter( 'acf/fields/post_object/query', 'scm_hook_acf_queryfield_hook_objects', 10, 3 );

add_action( 'acf/save_post', 'scm_hook_acf_savepost_hook', 1);
add_action( 'acf/save_post', 'scm_hook_acf_savedpost_hook', 11);

add_filter( 'acf/format_value/type=textarea', 'scm_hook_acf_formatvalue_hook_editor', 10, 3 );
add_filter( 'acf/format_value/type=limiter', 'scm_hook_acf_formatvalue_hook_editor', 10, 3 );
add_filter( 'acf/format_value/type=wysiwyg', 'scm_hook_acf_formatvalue_hook_editor', 10, 3 );

// ------------------------------------------------------
// 0.1 ACF LIBRARIES
// ------------------------------------------------------

/**
* [SET] Set ACF Libraries
*
* Hooked by 'acf/init'
*
* @subpackage 3-Install/ACF/HOOKS
*/
function scm_hook_acf_libraries(){

    global $SCM_libraries, $SCM_typekit;
    
    $SCM_libraries = array(
        'colors' => array(),
        'fonts' => array(),
        'selectors' => array(),
    );

    $SCM_libraries['selectors']['colors'] = array( 'color-white', 'color-black', 'bg-color-white', 'bg-color-black' );
    $SCM_libraries['selectors']['text'] = array( 'text-min', 'text-minion', 'text-half', 'text-small', 'text-normal', 'text-medium', 'text-big', 'text-huge', 'text-max', 'text-double', 'text-triple', 'text-quadruple' );
    $SCM_libraries['selectors']['alignment'] = array( 'text-left', 'text-right', 'text-center', 'text-justify', 'align-left', 'align-right', 'align-center', 'align-none', 'clear-none', 'clearfix' );
    $SCM_libraries['selectors']['pointer'] = array( 'pointer', 'no-pointer' );
    $SCM_libraries['selectors']['layout'] = array( 'responsive', 'full-width', 'full-height', 'prepend', 'append', 'tocolumn', 'scm-object' );
    $SCM_libraries['selectors']['display'] = array( 'display-none', 'display-block', 'display-inline-block', 'display-inline', 'mask' );
    $SCM_libraries['selectors']['position'] = array( 'position-fixed', 'position-absolute', 'position-relative', 'fixed-top', 'absolute-top', 'relative-top', 'fixed-bottom', 'absolute-bottom', 'relative-bottom', 'fixed-left', 'absolute-left', 'relative-left', 'fixed-right', 'absolute-right', 'relative-right', 'middle', 'overlay', 'underlay' );
    $SCM_libraries['selectors']['shape'] = array( 'square', 'rounded', 'rounded-min', 'rounded-small', 'rounded-medium', 'rounded-big', 'rounded-max', 'circle', 'circle-min', 'circle-small', 'circle-medium', 'circle-big', 'circle-max', 'round-top', 'round-bottom', 'round-left', 'round-right', 'round-head', 'round-head-left', 'round-head-right', 'round-foot', 'round-foot-left', 'round-foot-right', 'round-leaf', 'round-leaf-left', 'round-leaf-right', 'round-petal', 'round-petal-left', 'round-petal-right', 'round-drop', 'round-drop-left', 'round-drop-right' );
    $SCM_libraries['selectors']['link'] = array( 'disabled', 'enabled', 'button', );

    $colors = scm_field( 'styles-colors', array(), 'option' );
    foreach ( $colors as $color ) {
        $slug = sanitize_title( $color['name'] );
        $SCM_libraries['colors'][ $slug ] = array(
            'name' => $color['name'],
            'color' => $color['rgba-color'],
            'alpha' => $color['rgba-alpha'],
        );
        $SCM_libraries['selectors']['colors'][] = 'color-' . $slug;
        $SCM_libraries['selectors']['colors'][] = 'bg-color-' . $slug;
    }

    $g_fonts = scm_field( 'styles-google', array(), 'option' );
    foreach ( $g_fonts as $g_font ) {
        $SCM_libraries['fonts'][ sanitize_title( $g_font['family'] ) ] = array(
            'family' => $g_font['family'],
            'style' => $g_font['style'],
            'type' => 'google'
        );
    }

    $a_fonts = scm_field( 'styles-adobe', array(), 'option' );
    if( $SCM_typekit ){
        foreach ( $a_fonts as $a_font ) {
            $kit = $SCM_typekit->get( $a_font['id'] );
            if( !$kit || !$kit['kit'] ) continue;
            foreach( $kit['kit']['families'] as $family){
                $choices[$family['slug']] = $family['name'];
                $SCM_libraries['fonts'][ $family['slug'] ] = array(
                    'family' => $family['family'],
                    'style' => $family['style'],
                    'type' => 'adobe'
                );
            }
        }
    }
}

// ------------------------------------------------------
// 0.2 ACF OPTION PAGES
// ------------------------------------------------------

/**
* [SET] Install ACF option pages
*
* Hooked by 'acf/include_fields'
*
* Hooks:
```php
// Before option pages are created
do_action( 'scm_action_option_pages_before' );
```
* @subpackage 3-Install/ACF/HOOKS
*/
function scm_hook_acf_option_pages_install(){

    do_action( 'scm_action_option_pages_before' );

    if( function_exists('acf_add_options_page') ) {

        consoleDebug('install acf pages');

        acf_add_options_page(array(
            'page_title'    => 'SCM Settings',
            'menu_title'    => 'SCM',
            'menu_slug'     => 'scm-options-general',
            'icon_url'      => 'dashicons-carrot',
            'capability'    => SCM_ROLE_OPTIONS,
            'redirect'      => true,
        ));

        acf_add_options_page(array(
            'page_title'    => 'SCM Types',
            'menu_title'    => 'SCM Types',
            'menu_slug'     => 'scm-types-general',
            'icon_url'      => 'dashicons-star-filled',
            'capability'    => SCM_ROLE_OPTIONS,
            'redirect'      => true,
        ));

        acf_add_options_page(array(
            'page_title'    => 'SCM Templates',
            'menu_title'    => 'SCM Templates',
            'menu_slug'     => 'scm-templates-general',
            'icon_url'      => 'dashicons-art',
            'capability'    => SCM_ROLE_OPTIONS,
            'redirect'      => false,
        ));
    }
}

/**
* [SET] Install ACF option sub pages
*
* Hooked by 'acf/include_fields'
*
* Hooks:
```php
// After option pages are created
do_action( 'scm_action_option_pages' );
```
* @subpackage 3-Install/ACF/HOOKS
*/
function scm_hook_acf_option_subpages_install(){

    if( function_exists('acf_add_options_sub_page') ) {

        consoleDebug('install acf sub-pages');

        acf_add_options_sub_page(array(
            'page_title'    => 'SCM Intro',
            'menu_title'    => __( 'Introduzione', SCM_THEME ),
            'menu_slug'     => 'scm-options-intro',
            'parent_slug'   => 'scm-options-general',
            'capability'    => SCM_ROLE_OPTIONS,
        ));

        acf_add_options_sub_page(array(
            'page_title'    => 'SCM General Settings',
            'menu_title'    => __( 'Generali', SCM_THEME ),
            'menu_slug'     => 'scm-options-settings',
            'parent_slug'   => 'scm-options-general',
            'capability'    => SCM_ROLE_OPTIONS,
        ));

        acf_add_options_sub_page(array(
            'page_title'    => 'SCM Navigation Settings',
            'menu_title'    => __( 'Navigation', SCM_THEME ),
            'menu_slug'     => 'scm-options-nav',
            'parent_slug'   => 'scm-options-general',
            'capability'    => SCM_ROLE_OPTIONS,
        ));

        acf_add_options_sub_page(array(
            'page_title'    => 'SCM Tools Settings',
            'menu_title'    => __( 'Strumenti', SCM_THEME ),
            'menu_slug'     => 'scm-options-tools',
            'parent_slug'   => 'scm-options-general',
            'capability'    => SCM_ROLE_OPTIONS,
        ));

        acf_add_options_sub_page(array(
            'page_title'    => 'SCM Design Settings',
            'menu_title'    => __( 'Stili', SCM_THEME ),
            'menu_slug'     => 'scm-options-stili',
            'parent_slug'   => 'scm-options-general',
            'capability'    => SCM_ROLE_OPTIONS,
        ));

        acf_add_options_sub_page(array(
            'page_title'    => 'SCM Library Settings',
            'menu_title'    => __( 'Library', SCM_THEME ),
            'menu_slug'     => 'scm-options-library',
            'parent_slug'   => 'scm-options-general',
            'capability'    => SCM_ROLE_OPTIONS,
        ));

        acf_add_options_sub_page(array(
            'page_title'    => 'SCM Default Types',
            'menu_title'    => __( 'Default Types', SCM_THEME ),
            'menu_slug'     => 'scm-default-types',
            'parent_slug'   => 'scm-types-general',
            'capability'    => SCM_ROLE_OPTIONS,
        ));

        acf_add_options_sub_page(array(
            'page_title'    => 'SCM Default Taxonomies',
            'menu_title'    => __( 'Default Taxonomies', SCM_THEME ),
            'menu_slug'     => 'scm-default-taxonomies',
            'parent_slug'   => 'scm-types-general',
            'capability'    => SCM_ROLE_OPTIONS,
        ));

        acf_add_options_sub_page(array(
            'page_title'    => 'SCM Custom Types',
            'menu_title'    => __( 'Custom Types', SCM_THEME ),
            'menu_slug'     => 'scm-custom-types',
            'parent_slug'   => 'scm-types-general',
            'capability'    => SCM_ROLE_OPTIONS,
        ));

        acf_add_options_sub_page(array(
            'page_title'    => 'SCM Custom Taxonomies',
            'menu_title'    => __( 'Custom Taxonomies', SCM_THEME ),
            'menu_slug'     => 'scm-custom-taxonomies',
            'parent_slug'   => 'scm-types-general',
            'capability'    => SCM_ROLE_OPTIONS,
        ));

        global $SCM_types;
        reset($SCM_types);

        foreach ($SCM_types['public'] as $slug => $title) {
            acf_add_options_sub_page( array(
                'page_title'    => 'SCM ' . $title . ' Template',
                'menu_title'    => $title,
                'menu_slug'     => 'scm-templates-' . $slug,
                'parent_slug'   => 'scm-templates-general',
                'capability'    => SCM_ROLE_OPTIONS,
            ));
        }
    }

    do_action( 'scm_action_option_pages' );
}

// ------------------------------------------------------
// 0.3 ACF FIELDS
// ------------------------------------------------------

/**
* [SET] Group and register
*
* @subpackage 3-Install/ACF/HOOKS
*/
function scm_hook_acf_install_helper( $group, $menu ) {
    $key = $group['key'];
    $group['menu_order'] = $menu;
    scm_acf_group_register( $group );
    do_action( 'scm_action_install_fields_' . $key );
}

/**
* [SET] Install ACF groups and fields
*
* Hooked by 'acf/include_fields'
*
* @subpackage 3-Install/ACF/HOOKS
*/
function scm_hook_acf_install() {
    if( function_exists('register_field_group') ) {

        consoleDebug('install acf fields');
        do_action( 'scm_action_install_fields' );

        scm_acf_install_options_fields();
        scm_acf_install_posts_fields();

        do_action( 'scm_action_fields_installed' );
        consoleDebug('acf fields installed!');

    }
}

/**
* [SET] Install Options groups and fields
*
* @subpackage 3-Install/ACF/HOOKS
*/
function scm_acf_install_options_fields() {
    
    $m = 0;

    // + OPT INTRO
    $intro = scm_acf_group( __( 'Introduzione', SCM_THEME ), 'intro-options' );
    $intro['location'][] = scm_acf_group_location( 'scm-options-intro', 'options_page' );
    $intro['fields'] = scm_acf_options_intro();
    scm_hook_acf_install_helper( $intro, $m );

    // + OPT GENERAL
    $general = scm_acf_group( __( 'Opzioni Generali', SCM_THEME ), 'general-options' );
    $general['location'][] = scm_acf_group_location( 'scm-options-settings', 'options_page' );
    $general['fields'] = scm_acf_options_general();
    scm_hook_acf_install_helper( $general, $m++ );

    // + OPT NAVIGATION
    $nav = scm_acf_group( __( 'Opzioni Navigazione', SCM_THEME ), 'nav-options' );
    $nav['location'][] = scm_acf_group_location( 'scm-options-nav', 'options_page' );
    $nav['fields'] = scm_acf_options_nav();
    scm_hook_acf_install_helper( $nav, $m++ );

    // + OPT TOOLS
    $tools = scm_acf_group( __( 'Opzioni Strumenti', SCM_THEME ), 'tools-options' );
    $tools['location'][] = scm_acf_group_location( 'scm-options-tools', 'options_page' );
    $tools['fields'] = scm_acf_options_tools();
    scm_hook_acf_install_helper( $tools, $m++ );

    // + OPT STYLE
    $style = scm_acf_group( __( 'Opzioni Stili', SCM_THEME ), 'styles-options' );
    $style['location'][] = scm_acf_group_location( 'scm-options-stili', 'options_page' );
    $style['fields'] = scm_acf_options_styles();
    scm_hook_acf_install_helper( $style, $m++ );

    // + OPT LIBRARY
    $library = scm_acf_group( __( 'Opzioni Libreria', SCM_THEME ), 'library-options' );
    $library['location'][] = scm_acf_group_location( 'scm-options-library', 'options_page' );
    $library['fields'] = scm_acf_options_library();
    scm_hook_acf_install_helper( $library, $m++ );

    do_action( 'scm_action_options_fields' );
}

/**
* [SET] Install Posts and Taxonomies groups and fields
*
* Hooks:
```php
// Filters fields list before initialized
$groups = apply_filters( 'scm_filter_register_before', array() );

// Filters fields list after single type fields are initialized
$group = apply_filters( 'scm_filter_register_{post_type}, $group );

// Filters fields list after initialized
$groups = apply_filters( 'scm_filter_register', $groups );
```
*
* @subpackage 3-Install/ACF/HOOKS
*/
function scm_acf_install_posts_fields() {

    $groups = array();

    // SCM Filter BEFORE
    $groups = apply_filters( 'scm_filter_register_before', $groups );

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
    $tax_sliders['fields'] = scm_acf_fields_sliders();
    $groups[] = $tax_sliders;

    // + PAGE
    $page = scm_acf_group( __( 'Componi Pagina', SCM_THEME ), 'pages-single' );
    $page['location'][] = scm_acf_group_location( 'page' );
    $page['fields'] = scm_acf_fields_page();
    $groups[] = $page;

    // + PAGE FOOTER
    $page_footer = scm_acf_group( __( 'Opzioni Footer', SCM_THEME ), 'footer-single' );
    $page_footer['location'][] = scm_acf_group_location( 'page' );
    $page_footer['fields'][] = scm_acf_field_objects( 'page-footer', array( 
        'type'=>'rel-id', 
        'types'=>'sections',
        'label'=>__( 'Seleziona Sections', SCM_THEME ),
    ) );
    $groups[] = $page_footer;

    // + CUSTOM TYPES
    global $SCM_types;
    foreach ($SCM_types['custom'] as $slug => $title) {
        if($slug=='slides'){
            $group = scm_acf_group( __( 'Opzioni Slider', SCM_THEME ), 'slider-single' );
            $group['location'][] = scm_acf_group_location( 'page' );
            $group['fields'] = scm_acf_options_slider();
            $groups[] = $group;
        }

        $fun = 'scm_acf_fields_' . str_replace( '-', '_', $slug );
        if( function_exists( $fun ) ){
            $obj = $SCM_types['objects'][$slug];
            $group = scm_acf_group( __( 'Opzioni '. $obj->singular, SCM_THEME ), $slug . '-single' );
            $group['location'][] = scm_acf_group_location( $slug );
            $group['fields'] = call_user_func( $fun );
            
            // SCM Filter TYPE
            $group = apply_filters( 'scm_filter_register_' . str_replace( '_', '-', $slug ), $group );
            $groups[] = $group;
        }
    }

    // + TEMPLATES
    foreach ($SCM_types['public'] as $slug => $title) {

        $template = scm_acf_group( __( 'Elenco Modelli', SCM_THEME ), 'template-' . $slug );
        $template['location'][] = scm_acf_group_location( 'scm-templates-' . $slug, 'options_page' );
        $template['fields'] = scm_acf_fields_templates( $slug );
        $groups[] = $template;

        $template = scm_acf_group( $title, $slug . '_temp-single' );
        $template['location'][] = scm_acf_group_location( $slug . SCM_TEMPLATE_APP );

        $slug = str_replace( '-', '_', $slug );

        $template['fields'] = array_merge( $template['fields'], scm_acf_fields_template( $slug ) );
        $groups[] = $template;
    }

    // SCM Filter AFTER
    $groups = apply_filters( 'scm_filter_register', $groups );

    // Register POSTS Groups
    for ( $i = 0; $i < sizeof( $groups ); $i++) 
        scm_hook_acf_install_helper( $groups[$i], $i );

    do_action( 'scm_action_posts_fields' );
            
}

// ------------------------------------------------------
// 0.4 ACF ADMIN MENU
// ------------------------------------------------------

/**
* [GET] SCM admin menu order
*
* Hooked by 'scm_filter_admin_ui_menu_order'
* @subpackage 3-Install/ACF/HOOKS
*
* @param {array} menu_order Menu list
* @return {array} Modified menu list
*/
function scm_hook_acf_option_menu_order( $menu_order ) {

    $menu_order[ 'scm' ] = arr_insert( $menu_order[ 'scm' ], 1, 'scm-options-intro' );
    $menu_order[ 'scm' ] = arr_insert( $menu_order[ 'scm' ], 2, 'scm-default-types' );
    $menu_order[ 'scm' ] = arr_insert( $menu_order[ 'scm' ], 3, 'scm-templates-general' );

    return $menu_order;

}

/**
* [GET] Current user ACF capability
*
* Hooked by 'acf/settings/show_admin'
* @subpackage 3-Install/ACF/HOOKS
*
* @return {bool} Current user has ACF capability.
*/
function scm_hook_acf_admin_hide() {
    if( SCM_LEVEL > 0 )
        return false;
    else
        return true;
}

// ------------------------------------------------------
// FILTERS
// ------------------------------------------------------

// ------------------------------------------------------
// 1.1 ACF / LOAD FIELD
// ------------------------------------------------------

/**
* [GET] Filter each load field
*
* Hooked by 'acf/load_field'
* @subpackage 3-Install/ACF/FILTERS
*
* 1 - Merge default choices with preset choices
*
* @param {array} field Field.
* @return {array} Filtered field.
*/
function scm_hook_acf_loadfield_hook_choices_get( $field ){

    // CHOICES
    if( isset( $field['choices'] ) && isset( $field['preset'] ) ){

        $preset = scm_acf_field_choices_preset( $field['preset'], '' );

        if( $preset )
            $field['choices'] = array_merge( $field['choices'], $preset );

        if( is_string( $field['default_value'] ) && is_null( getByKey( $field['choices'], $field['default_value'] ) ) ) {

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

/**
* [GET] Filter each repeater load field
*
* Hooked by 'acf/load_field/type=repeater'
* @subpackage 3-Install/ACF/FILTERS
*
* 1 - Filter template repeater field
*
* @param {array} field Field.
* @return {array} Filtered field.
*/
function scm_hook_acf_loadfield_hook_repeater_list( $field ){

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
                }else if( $v['name'] == 'name' ){
                    $field['value'][ $id ][ $v['key'] ] = $p->post_title;
                }
            }
        }
    }

    return $field;
}

/**
* [GET] Filter each FA load field
*
* Hooked by 'acf/load_field/type=font-awesome'
* @subpackage 3-Install/ACF/FILTERS
*
* 1 - Filter FA icons using groups/presets
*
* @param {array} field Field.
* @return {array} Filtered field.
*/
function scm_hook_acf_loadfield_hook_fontawesome_list( $field ){

    if ( is_plugin_active( 'advanced-custom-fields-font-awesome/acf-font-awesome.php' ) ) {

        $choices = array();
        $new = array();

        if( isset( $field['filter_group'] ) && isset( $field['filter'] ) ){
            $choices = scm_acf_field_fa( $field['filter_group'], $field['filter'] );
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

// ------------------------------------------------------
// 1.2 ACF / SAVE POST
// ------------------------------------------------------

/**
* [SET] Filter each save post (before post is saved)
*
* Hooked by 'acf/save_post'
* @subpackage 3-Install/ACF/FILTERS
*
* @param {int|string} post_id Post ID or 'options'.
*/
function scm_hook_acf_savepost_hook( $post_id ) {

    if( empty($_POST['acf']) )
        return;

    if( $post_id == 'options'){

        $opt_intro = isset( $_GET['page'] ) && $_GET['page'] == 'scm-options-intro';

        // - Options Intro
        if( $opt_intro ){

            foreach ( $_POST['acf'] as $key => $value ) {
                $field = get_field_object($key, $post_id, false);

                if( $field['name'] == 'admin-reset-roles' && $value ){
                    $_POST['acf'][$key] = 0;
                    //scm_roles_install();
                    update_option( 'scm-roles-installed', 0 );
                }
            }
        }
    }
}
        

/**
* [SET] Filter each save post (after post is saved)
*
* Hooked by 'acf/save_post'
* @subpackage 3-Install/ACF/FILTERS
*
* @param {int|string} post_id Post ID or 'options'.
*/
function scm_hook_acf_savedpost_hook( $post_id ) {

    if( empty($_POST['acf']) )
        return;

    if( $post_id == 'options'){

        $opt_types = isset( $_GET['page'] ) && in_array( $_GET['page'], array( 'scm-default-types', 'scm-default-taxonomies', 'scm-custom-types', 'scm-custom-taxonomies' ) );
        $opt_temp = isset( $_GET['page'] ) && startsWith( $_GET['page'], 'scm-templates' );
        
        // - Types
        if( $opt_types ){
            flush_rewrite_rules();
            update_option( 'scm-roles-installed', 0 );
        }

        // - Templates
        if( $opt_temp ){

            foreach ( $_POST['acf'] as $key => $value ) {
                $field = get_field_object($key, $post_id, false);
            
                if( $field['type'] == 'repeater' && endsWith( $field['name'], '-templates' ) ){

                    $type = str_replace( '-templates', SCM_TEMPLATE_APP, $field['name']);

                    $key_id = $field['sub_fields'][ getByValueKey( $field['sub_fields'], 'id' ) ]['key'];
                    $key_name = $field['sub_fields'][ getByValueKey( $field['sub_fields'], 'name' ) ]['key'];

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

                    foreach ( $pub as $key => $value ) {
                        wp_delete_post( $key, true );
                    }

                    $_POST['acf'] = array();
                }
            }
        }
    }
}

// ------------------------------------------------------
// 1.3 ACF / QUERY FIELD
// ------------------------------------------------------

/**
* [GET] Filter each field query
*
* Hooked by 'acf/fields/post_object/query'
* @subpackage 3-Install/ACF/FILTERS
*
* 1 - Hide drafts from query
*
* @param {array} options Query options.
* @param {array} field (not used).
* @param {Object} the_post (not used).
* @return {array} Modified query options.
*/
function scm_hook_acf_queryfield_hook_objects( $options, $field, $the_post ) {

    // HIDE DRAFT
    $options['post_status'] = array('publish');

    return $options;
}

// ------------------------------------------------------
// 1.4 ACF / FORMAT VALUE
// ------------------------------------------------------

/**
* [GET] Filter textarea, limiter and text editor value
*
* Hooked by 'acf/format_value/type=textarea'<br>
* Hooked by 'acf/format_value/type=limiter'<br>
* Hooked by 'acf/format_value/type=wysiwyg'
* @subpackage 3-Install/ACF/FILTERS
*
* 1 - Format textarea, limiter and editor content
*
* @param {string} value Field content.
* @param {int} post_id (not used).
* @param {array} field (not used).
* @return {string} Modified field content.
*/
function scm_hook_acf_formatvalue_hook_editor( $value, $post_id, $field ){

    // FORMAT CONTENT
    $pattern = "/<[^\/>]*>([\s]?)*<\/[^>]*>/";
    $value = preg_replace( $pattern, '', $value );

    return $value;
}

?>