<?php

class Custom_Type {

    protected $menu_pos;
 
    function __construct( $build ) {
        
        if( !$build )
            return;

        $attr = array(
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
            'ordertype'             => ''
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

        $this->public = $attr['public'];
        $this->hidden = $attr['hidden'];
        
        $this->plural = $plural;
        $this->singular = $singular;
        $this->slug = $slug;
        
        $this->short_singular = ( $attr['short-singular'] ?: $singular );
        $this->short_plural = ( $attr['short-plural'] ?: $plural );
        
        $this->icon = $attr['icon'];
        $this->supports = array( 'title' );
        $this->orderby = ( $attr['orderby'] ?: 'title' );
        $this->order = $attr['ordertype'];

        //$this->menu_pos = 9;

        add_filter( 'manage_edit-' . $this->slug . '_columns', array(&$this, 'CT_admin_columns') ) ;
        add_action( 'manage_' . $this->slug . '_posts_custom_column', array(&$this, 'CT_manage_admin_columns'), 10, 2 );
        add_action( 'load-edit.php', array(&$this, 'CT_admin_edit_page') );
                
        if($this->icon) { add_action( 'admin_head', array(&$this, 'CT_admin_icon') ); }

        $this->CT_type();
    }

    function CT_register() {
        register_post_type( $this->slug, $this->attributes);
        flush_rewrite_rules();
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
                'view_item'           => __( 'Visualizza', SCM_THEME ),
                'add_new_item'        => __( 'Aggiungi', SCM_THEME ),
                'add_new'             => __( 'Aggiungi', SCM_THEME ),
                'edit_item'           => __( 'Modifica', SCM_THEME ),
                'update_item'         => __( 'Aggiorna', SCM_THEME ),
                'search_items'        => __( 'Cerca ', SCM_THEME ) . $this->short_plural,
                'not_found'           => __( 'Non trovato', SCM_THEME ),
                'not_found_in_trash'  => __( 'Non trovato nel Cestino', SCM_THEME ),
            ),
            'label'               => $this->slug,
            'description'         => __( 'Descrizione', SCM_THEME ),
            'supports'            => $this->supports,
            'hierarchical'        => ( !$this->post ? true : false ),
            //'taxonomies'          => $this->taxonomies,
            'public'              => true,
            'show_ui'             => !$this->hidden,
            'show_in_menu'        => !$this->hidden,
            'show_in_nav_menus'   => !$this->hidden,
            'show_in_admin_bar'   => !$this->hidden,
            'menu_position'       => 60,
            'can_export'          => true,
            'has_archive'         => $this->public,
            'exclude_from_search' => !$this->public,
            'publicly_queryable'  => true,
            'capability_type'     => ( !$this->post ? 'page' : 'post' ),
        );

    }

    function CT_admin_columns( $columns ) {
            $columns['cb'] = '<input type="checkbox" />';
            $columns['id'] = __( 'ID', SCM_THEME );
        return $columns;
    }

    function CT_manage_admin_columns( $column, $post_id ) {
        global $post;
        switch( $column ) {
            case 'id' : echo $post_id; break;
            default : break;
        }
    }

    function CT_admin_edit_page() {
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

    function CT_admin_icon(){
        echo '
        <style>
        #adminmenu #menu-posts-' . $this->slug . ' .menu-icon-post div.wp-menu-image:before {
          content: "' . $this->icon . '";
        }
        </style>';
    }
}

?>