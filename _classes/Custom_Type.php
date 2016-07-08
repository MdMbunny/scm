<?php

if ( ! class_exists( 'Custom_Type' ) ) {

/**
 * Custom_Type.php
 *
 * Custom Types Class.
 *
 * Example usage:
 *
```php
$args = array(
    'admin'             => 0,         // bool Admin (1) or Everyone (0) use
    'add_cap'           => 1,         // bool Add (1) or Remove (0) capabilities for middle users
    'public'            => 1,         // bool Public (1) or Private (0) use
    'hidden'            => 0,         // bool Hide (1) or Show (0) from administration area
    'post'              => 1,         // bool Post (1) or Page (0) type
    'singular'          => '',        // string Type singular name
    'plural'            => '',        // string Type plural name
    'short-singular'    => '',        // string Type singular short name
    'short-plural'      => '',        // string Type plural short name
    'slug'              => '',        // string Type slug
    'icon'              => 'f111',    // string Type icon ({@link https://developer.wordpress.org/resource/dashicons})
    'orderby'           => 'title',   // string Type order by: title | date | modified | name | type | rand | meta_value
    'ordertype'         => '',        // string Type order: ASC | DESC
    'menu'              => '',        // string Type menu area: scm | pages | types | contacts | settings | '' [plugin area]
    'menupos'           => 0,         // int Type menu position: To end (0), First position (1), Second position (2), ...
    'description'       => '',        // string Type description
    'theme'             => '',        // string Theme slug for translations
);
 
$type = new Custom_Type( $args );
```
 * @param array $build The arguments to pass to this file. Optional.
 * Default empty array.
 *
 * @return object Custom Type object.
 *
 * @link http://www.studiocreativo-m.it
 *
 * @package SCM
 * @subpackage Classes
 * @since 1.0.0
 */
    class Custom_Type {

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
                'menu'                  => '',
                'description'           => '',
                'theme'                 => '',
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

            $this->theme = $attr['theme'];

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
            
            $this->menu = ( $attr['menu'] ?: '' );
            $this->menupos = ( $attr['menupos'] ?: 0 );
            
            $this->description = $attr['description'];       

            $this->cap_singular = sanitize_title( $this->singular );
            $this->cap_plural = sanitize_title( $this->plural );
            $this->cap_plural = ( $this->cap_plural == $this->cap_singular ? $this->cap_plural . 's' : $this->cap_plural );

            $this->attributes = array(
                'labels'    => array(
                    'name'                => $this->plural,
                    'singular_name'       => $this->singular,
                    'menu_name'           => $this->plural,
                    'parent_item_colon'   => __( 'Genitore:', $this->theme ),
                    'all_items'           => __( 'Elenco', $this->theme ),
                    'view_item'           => __( 'Visualizza', $this->theme ) . ' ' . $this->short_singular,
                    'add_new_item'        => __( 'Aggiungi', $this->theme ) . ' ' . $this->short_singular,
                    'add_new'             => __( 'Aggiungi', $this->theme ),
                    'edit_item'           => __( 'Modifica', $this->theme ) . ' ' . $this->short_singular,
                    'update_item'         => __( 'Aggiorna', $this->theme ) . ' ' . $this->short_singular,
                    'search_items'        => __( 'Cerca', $this->theme ) . ' ' . $this->short_plural,
                    'not_found'           => $this->short_singular . ' ' . __( 'non trovato', $this->theme ),
                    'not_found_in_trash'  => $this->short_singular . ' ' . __( 'non trovato nel Cestino', $this->theme ),
                ),
                'label'               => $this->slug,
                'description'         => $this->description,
                'supports'            => $this->supports,
                'hierarchical'        => ( !$this->post ? true : false ),
                'public'              => true,
                'show_ui'             => true,
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

            add_filter( 'scm_filter_admin_ui_menu_order', array( &$this, 'CT_admin_menu_order' ) );
            add_filter( 'manage_edit-' . $this->slug . '_columns', array( &$this, 'CT_admin_columns' ) ) ;
            add_action( 'manage_' . $this->slug . '_posts_custom_column', array( &$this, 'CT_manage_admin_columns' ), 10, 2 );
            add_action( 'load-edit.php', array( &$this, 'CT_admin_edit_page_load' ) );
            add_action( 'admin_menu', array( &$this, 'CT_admin_menu_hide' ) );
            add_action( 'admin_head', array( &$this, 'CT_admin_elems_hide' ) );
            add_action( 'admin_bar_menu', array( &$this, 'CT_admin_bar_hide' ), 999 );

        }

        function CT_register() {

            register_post_type( $this->slug, $this->attributes );
            flush_rewrite_rules();
            
        }

        function CT_admin_columns( $columns ) {

                //$columns['cb'] = '<input type="checkbox" />';
                $columns['id'] = __( 'ID', $this->theme );

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

                            echo join( ', ', $out );

                        }
                    }

                break;

            }
        }

        function CT_admin_edit_page_load() {
        
            add_filter( 'request', array( &$this, 'CT_admin_orderby' ) );

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

        function CT_admin_menu_order( $menu_order ) {

            $scm_menu = ( $this->menu && is_array( $menu_order[ $this->menu ] ) ? $menu_order[ $this->menu ] : 0 );
            $this->menupos = ( $this->menupos ?: sizeof( $scm_menu ?: array() ) + 1 ) - 1;
            
            if( $scm_menu )
                insertArray( $menu_order[ $this->menu ], $this->menupos, 'edit.php?post_type=' . $this->slug );

            return $menu_order;

        }
    }
}

?>