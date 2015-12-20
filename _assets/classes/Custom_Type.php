<?php

class Custom_Type {

    protected $menu_pos;
 
    function __construct( $build ) {
        
        if( !$build )
            return;

        $attr = array(
            'admin'                 => 0,
            'add_cap'               => 1,
            'public'                => 1,
            'hidden'                => 0,
            'post'                  => 1,
            'singular'              => '',
            'plural'                => '',
            'short-singular'        => '',
            'short-plural'          => '',
            'slug'                  => '',
            'icon'                  => 'f111',
            'orderby'               => 'title',
            'ordertype'             => '',
            'menupos'               => 0,
            'menu'                  => 0,
            'description'           => '',
        );

        if( is_array( $build ) )
            $attr = array_merge( $attr, $build );
        else if( is_string( $build ) )
            $attr['plural'] = $build;
        else
            return;

        $this->post = $attr['post'];

        $plural = $attr['plural'];
        $singular = ( $attr['singular'] ?: $plural );
        $slug = ( $attr['slug'] ?: sanitize_title($plural) );

        $this->attributes = array();

        $this->admin = $attr['admin'];
        $this->add_cap = $attr['add_cap'];
        $this->public = $attr['public'];
        $this->hidden = $attr['hidden'];
        
        $this->plural = $plural;
        $this->singular = $singular;
        $this->slug = $slug;
       
        $this->short_singular = ( $attr['short-singular'] ?: $singular );
        $this->short_plural = ( $attr['short-plural'] ?: $plural );
        
        $this->icon = ( strpos( $attr['icon'], 'dashicons-' ) === 0 ? $attr['icon'] : 'dashicons-' . $attr['icon'] );
        $this->supports = array( 'title' );
        $this->orderby = ( $attr['orderby'] ?: 'title' );
        $this->order = $attr['ordertype'];

        $this->menupos = $attr['menupos'];
        $this->menu = $attr['menu'];

        $this->description = $attr['description'];

        if( !$this->menupos ){

            switch ( $this->menu ) {
                                                        //          0.1 : SCM                 0.2 : SCM Types                 0.3 : SCM Templates                     1 > 3 : (empty)
                                                        // 4 -
                //case 0: $this->menupos = 6; break;      //          5 : Pages                   6 > 9 : (private)
                                                        // 10 -
                case 1: $this->menupos = 12; break;     //          12 > 19 : (empty)
                                                        // 20 - 
                case 2: $this->menupos = 22; break;     //          22 > 25 (empty)
                                                        // 26 -
                case 3: $this->menupos = 28; break;     //          27 : Media                   28 > 41 : (multimedia)
                                                        // 42 —
                case 4: $this->menupos = 44; break;     //          44 > 55 : (contacts)         56 : Users                  57 : CF7
                                                        // 59 —
                                                        // ...
                default: $this->menupos = 91; break;    //          91 > (empty)
                
            }
        }

        $this->cap_singular = sanitize_title( $this->singular );
        $this->cap_plural = sanitize_title( $this->plural );
        $this->cap_plural = ( $this->cap_plural == $this->cap_singular ? $this->cap_plural . 's' : $this->cap_plural );

        //add_action( 'publish_' . $this->slug, array( &$this, 'CT_default_term' ) );
        add_filter( 'manage_edit-' . $this->slug . '_columns', array( &$this, 'CT_admin_columns' ) ) ;
        add_action( 'manage_' . $this->slug . '_posts_custom_column', array( &$this, 'CT_manage_admin_columns' ), 10, 2 );
        //add_filter( 'manage_edit' . $this->slug . '_sortable_columns', array( &$this, 'CT_sort_admin_columns' ) );
        add_action( 'load-edit.php', array( &$this, 'CT_admin_edit_page_load' ) );
        add_action( 'admin_menu', array( &$this, 'CT_admin_menu_hide' ) );
        add_action( 'admin_head', array( &$this, 'CT_admin_elems_hide' ) );
        add_action( 'admin_bar_menu', array( &$this, 'CT_admin_bar_hide' ), 999 );

        $this->CT_type();
    }

    /*function CT_default_term( $post_id ) {
        global $wpdb;

        $taxes = get_object_taxonomies( get_post( $post_id ) );

        foreach ( $taxes as $tax_name ) {
            $tax = get_taxonomy( $tax_name );
            if( $tax->hierarchical ){
                $terms = get_object_terms( $post_id );
                consoleLog($terms);
            }
            
            
            //$terms = get_terms( $tax_name, [ 'fields' => 'name' ] );
            //consoleLog($terms);
        }

        

        //if( !has_term( '', 'default', $post_id ) ){
            //$cat = array(4);
            //wp_set_object_terms($post_id, $cat, 'category');
        //}
    }*/

    function CT_register() {
        register_post_type( $this->slug, $this->attributes);
        flush_rewrite_rules();

        //add_action('publish_stiwti', 'add_stiwti_category_automatically');
    }

    function CT_type() {
        $this->menu_pos++;

        $this->attributes = array(
            'labels'    => array(
                'name'                => $this->plural,
                'singular_name'       => $this->singular,
                'menu_name'           => $this->plural,
                'parent_item_colon'   => __( 'Genitore:', SCM_THEME ),
                'all_items'           => __( 'Elenco', SCM_THEME ),
                'view_item'           => __( 'Visualizza', SCM_THEME ) . ' ' . $this->short_singular,
                'add_new_item'        => __( 'Aggiungi', SCM_THEME ) . ' ' . $this->short_singular,
                'add_new'             => __( 'Aggiungi', SCM_THEME ),
                'edit_item'           => __( 'Modifica', SCM_THEME ) . ' ' . $this->short_singular,
                'update_item'         => __( 'Aggiorna', SCM_THEME ) . ' ' . $this->short_singular,
                'search_items'        => __( 'Cerca', SCM_THEME ) . ' ' . $this->short_plural,
                'not_found'           => $this->short_singular . ' ' . __( 'non trovato', SCM_THEME ),
                'not_found_in_trash'  => $this->short_singular . ' ' . __( 'non trovato nel Cestino', SCM_THEME ),
            ),
            'label'               => $this->slug,
            'description'         => $this->description,
            'supports'            => $this->supports,
            'hierarchical'        => ( !$this->post ? true : false ),
            //'taxonomies'          => $this->taxonomies,
            'public'              => true,
            'show_ui'             => !$this->hidden,
            'show_in_menu'        => !$this->hidden,
            'show_in_nav_menus'   => !$this->hidden,
            'show_in_admin_bar'   => !$this->hidden,
            'menu_position'       => $this->menupos,
            'menu_icon'           => $this->icon,
            'can_export'          => true,
            'has_archive'         => $this->public,
            'exclude_from_search' => !$this->public,
            'publicly_queryable'  => true,
            'capability_type'     => array( $this->cap_singular, $this->cap_plural ),
            'map_meta_cap'        => true,
        );
    }
    

    function CT_admin_columns( $columns ) {
            $columns['cb'] = '<input type="checkbox" />';
            $columns['id'] = __( 'ID', SCM_THEME );

            $taxonomies = get_object_taxonomies( $this->slug, 'objects' );
            foreach ( $taxonomies as $taxonomy_slug => $taxonomy ){
                if( $taxonomy_slug != 'language' && $taxonomy_slug != 'post_translations' )
                    $columns[ 'tax-' . $taxonomy_slug ] = $taxonomy->label;
            }

        return $columns;
    }

    function CT_manage_admin_columns( $column, $post_id ) {

        switch( $column ) {
            case 'id':
                echo $post_id;
            break;

            default:
                
                $tax = str_replace( 'tax-', '', $column );
                if( taxonomy_exists( $tax ) ){

                    

                    $terms = get_the_terms( $post_id, $tax );
                    
                    if ( !empty( $terms ) ) {

                        $out = array();

                        foreach ( $terms as $term ) {
                            $out[] = sprintf( '<a href="%s">%s</a>',
                                esc_url( add_query_arg( array( 'post_type' => get_post_type( $post_id ), $tax => $term->slug ), 'edit.php' ) ),
                                esc_html( sanitize_term_field( 'name', $term->name, $term->term_id, $tax, 'display' ) )
                            );
                        }

                        /* Join the terms, separating them with a comma. */
                        echo join( ', ', $out );

                        /*$tot = sizeof( $terms );
                        $i = 0;

                        foreach ( $terms as $term ) {

                            $i++;
                            echo $term->name;
                            if( $i == $tot )
                                continue;

                            echo ', ';

                        }*/
                    }
                }

            break;

        }
    }

    //function CT_sort_admin_columns( $columns ) {}


    function CT_admin_edit_page_load() {
    
        add_filter( 'request', array(&$this, 'CT_admin_orderby') );
    }

    function CT_admin_orderby( $vars ) {
        
        if ( isset( $vars['post_type'] ) && $this->slug == $vars['post_type'] ) {

            $vars = array_merge(
                $vars,
                array(
                    'orderby' => $this->orderby,
                    'order' => ( $this->order ? $this->order : ( $this->orderby == 'title' ? 'ASC' : 'DESC' ) )
                )
            );
        }

        return $vars;
    
    }

    function CT_admin_elems_hide(){

        if( current_user_can( 'publish_' . $this->cap_plural ) )
            return;

        global $current_screen;

        $current = $current_screen->id;

        if( $current == 'edit-' . $this->slug || $current == $this->slug )
            echo '<style>.page-title-action, #titlewrap, #edit-slug-box, .add-new-h2{display: none !important;}</style>';  
        
    }

    function CT_admin_bar_hide( $wp_admin_bar ){

        if( current_user_can( 'publish_' . $this->cap_plural ) )
            return;

        $wp_admin_bar->remove_node( 'new-' . $this->slug );
        
    }

    function CT_admin_menu_hide(){

        if( current_user_can( 'publish_' . $this->cap_plural ) )
            return;

        global $submenu;

        $sub = isset( $submenu[ 'edit.php?post_type=' . $this->slug ] ) ? $submenu[ 'edit.php?post_type=' . $this->slug ] : '';
        if( $sub ){
            $subind = isset( $sub[10] ) ? $sub[10] : '';
            if( $subind ){
                $subel = isset( $subind[1] ) ? $subind[1] : '';
                if( $subel )
                    $submenu['edit.php?post_type=' . $this->slug][10][1] = 'publish_' . $this->cap_plural;
            }

        }

    }

}

?>