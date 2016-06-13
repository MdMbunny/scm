<?php
/**
 * @package SCM
 */

// *****************************************************
// *    SCM INSTALL - ACF
// *****************************************************

/*
*****************************************************
*
*   0.0 Actions and Filters
*   1.0 Option Pages
*   2.0 ACF Hooks
**      2.1 ACF Installation
**      2.2 Load Field
**      2.3 Save Post
**      2.4 Query Field
**      2.5 Format Value
*   3.0 ACF Fields Installation
*
*****************************************************
*/

// *****************************************************
// *      0.0 ACTIONS AND FILTERS
// *****************************************************

    add_action( 'acf/include_fields', 'scm_acf_option_pages_install' );
    add_action( 'acf/include_fields', 'scm_acf_option_subpages_install' );
    add_filter( 'scm_filter_admin_ui_menu_order', 'scm_acf_option_menu_order' );  
    
    add_filter( 'acf/settings/show_admin', 'scm_acf_admin_hide' );
    //add_filter( 'bfa_force_fallback', 'scm_acf_fa_force_fallback' );

    add_action( 'acf/include_fields', 'scm_acf_install' );
    
    add_filter( 'acf/fields/post_object/query', 'scm_acf_queryfield_hook_objects', 10, 3 );
    
    add_filter( 'acf/load_field', 'scm_acf_loadfield_hook_choices_get', 100) ;
    add_filter( 'acf/load_field/type=repeater', 'scm_acf_loadfield_hook_repeater_list', 100 );
    add_filter( 'acf/load_field/type=font-awesome', 'scm_acf_loadfield_hook_fontawesome_list', 150 );
   
    add_filter( 'acf/format_value/type=text', 'scm_acf_formatvalue_hook_text', 10, 3 );
    add_filter( 'acf/format_value/type=textarea', 'scm_acf_formatvalue_hook_editor', 10, 3 );
    add_filter( 'acf/format_value/type=limiter', 'scm_acf_formatvalue_hook_editor', 10, 3 );
    add_filter( 'acf/format_value/type=wysiwyg', 'scm_acf_formatvalue_hook_editor', 10, 3 );
    
    add_action( 'acf/save_post', 'scm_acf_savepost_hook_templates', 11) ;   


// *****************************************************
// *      1.0 OPTION PAGES INSTALLATION
// *****************************************************

    if ( ! function_exists( 'scm_acf_option_pages_install' ) ) {
        function scm_acf_option_pages_install(){

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

    if ( ! function_exists( 'scm_acf_option_subpages_install' ) ) {
        function scm_acf_option_subpages_install(){

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

    // Admin Menu Order
    if ( ! function_exists( 'scm_acf_option_menu_order' ) ) {
        function scm_acf_option_menu_order( $menu_order ) {
            
            insertArray( $menu_order[ 'scm' ], 1, 'scm-options-intro' );
            insertArray( $menu_order[ 'scm' ], 2, 'scm-default-types' );
            insertArray( $menu_order[ 'scm' ], 3, 'scm-templates-general' );

            return $menu_order;

        }
    }

// *****************************************************
// *      2.0 ACF HOOKS
// *****************************************************

// *****************************************************
// *      2.1 ACF INSTALLATION
// *****************************************************

    // *** PLUGIN SETTINGS

    // Font Awesome Field FIX
    if ( ! function_exists( 'scm_acf_admin_hide' ) ) {
        function scm_acf_admin_hide() {
            if( SCM_LEVEL > 0 )
                return false;
            else
                return true;
        }
    }

    // Font Awesome Field FIX
    /*if ( ! function_exists( 'scm_acf_fa_force_fallback' ) ) {
        function scm_acf_fa_force_fallback( $force_fallback ) {
            return true;
        }
    }*/

// *****************************************************
// *      2.2 LOAD FIELD
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

    // FONT AWESOME - SELECTED ICONS
    // filter FA icons using groups/presets
    if ( ! function_exists( 'scm_acf_loadfield_hook_fontawesome_list' ) ) {
        function scm_acf_loadfield_hook_fontawesome_list( $field ){

            $choices = array();
            $new = array();

            if ( is_plugin_active( 'advanced-custom-fields-font-awesome/acf-font-awesome.php' ) ) {

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
// *      2.3 SAVE POST
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

// *****************************************************
// *      2.4 QUERY FIELD
// *****************************************************

    // POST OBJECT - HIDE DRAFT
    if ( ! function_exists( 'scm_acf_queryfield_hook_objects' ) ) {
        function scm_acf_queryfield_hook_objects( $options, $field, $the_post ) {
            
            $options['post_status'] = array('publish');

            return $options;

        }
    }

// *****************************************************
// *      2.5 FORMAT VALUE
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
// *      3.0 ACF FIELDS INSTALLATION
// *****************************************************


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
                $tax_sliders['fields'] = scm_acf_fields_sliders();
                //$tax_sliders['fields'] = scm_acf_template_sliders();

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
                $page_footer['fields'][] = scm_acf_field_objects( 'page-footer', array( 
                    'type'=>'rel-id', 
                    'types'=>'sections',
                    'label'=>__( 'Seleziona Sections', SCM_THEME ),
                ) );

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

    ?>