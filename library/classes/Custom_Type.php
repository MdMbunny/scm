<?php

class Custom_Type {

    protected $menu_pos;
    protected $categories;
    protected $tags;
 
    function __construct( $singular, $plural = '', $slug = '', $categories = 0, $tags = 0, $icon = '', $post = 1, $pagination = -1, $archive = -1, $folder = 0, $editor = 0 ) {
        
        $default = array(
            'singular'      => null,
            'plural'        => null,
            'slug'          => null,
            'categories'    => 0,
            'tags'          => 0,
            'icon'          => '',
            'post'          => 1,
            'pagination'    => -1,
            'archive'       => -1,
            'folder'        => 0,
            'editor'        => 0
        );

        if(is_array($singular))
            extract( wp_parse_args( $singular, $default ) );

        if(!$singular || !$plural)
            return;

        if(!$slug)
            $slug = sanitize_title($plural);

        $this->attributes = array();
        $this->taxonomies = array();
        
        $this->singular = $singular;
        $this->plural = $plural;
        $this->slug = $slug;
        $this->icon = $icon;
        $this->post = $post;
        $this->pagination = $pagination;
        $this->pagination_short = $archive;
        $this->uploads_post_folder = $folder;
        $this->supports = array( 'title' );
        if( $editor )
            $this->supports[] = 'editor';

        //$this->menu_pos = 9;

        if($categories){
            $this->categories = new Custom_Taxonomy('Categoria','Categorie','categories-' . $slug, array($slug), false);
            $this->taxonomies[] = 'categories-' . $slug;
            add_action( 'admin_menu', array(&$this, 'CT_remove_cat_metabox') );
        }
        if( isset( $tags ) ){
            $this->tags = new Custom_Taxonomy('Tag','Tags','tags-' . $slug, array($slug), true);
            $this->taxonomies[] = 'tags-' . $slug;
            add_action( 'admin_menu', array(&$this, 'CT_remove_tag_metabox') );
        }

        add_filter( 'manage_edit-' . $this->slug . '_columns', array(&$this, 'CT_admin_columns') ) ;
        add_action( 'manage_' . $this->slug . '_posts_custom_column', array(&$this, 'CT_manage_admin_columns'), 10, 2 );

        if($this->icon) { add_action( 'admin_head', array(&$this, 'CT_admin_icon') ); }

        $this->CT_type();
        register_post_type( $this->slug, $this->attributes);
        flush_rewrite_rules();
    }

    function CT_default( $args = array() ) {
        
        $default = array(
            'singular'      => null,
            'plural'        => null,
            'slug'          => null,
            'categories'    => 0,
            'tags'          => 0,
            'icon'          => '',
            'post'          => 1,
            'pagination'    => -1,
            'archive'       => -1,
            'folder'        => 0,
        );

        return $default;
            
    }

    function CT_type() {
        $this->menu_pos++;


        $this->attributes = array(
            'labels'    => array(
                'name'                => $this->plural,
                'singular_name'       => $this->singular,
                'menu_name'           => $this->plural,
                'parent_item_colon'   => __( 'Genitore:', SCM_THEME ),
                'all_items'           => __( 'Tutti', SCM_THEME ),
                'view_item'           => __( 'Visualizza', SCM_THEME ),
                'add_new_item'        => __( 'Aggiungi', SCM_THEME ),
                'add_new'             => __( 'Aggiungi', SCM_THEME ),
                'edit_item'           => __( 'Modifica', SCM_THEME ),
                'update_item'         => __( 'Aggiorna', SCM_THEME ),
                'search_items'        => __( 'Cerca', SCM_THEME ),
                'not_found'           => __( 'Non trovato', SCM_THEME ),
                'not_found_in_trash'  => __( 'Non trovato nel Cestino', SCM_THEME ),
            ),
            'label'               => $this->slug,
            'description'         => __( 'Descrizione', SCM_THEME ),
            'supports'            => $this->supports,
            'hierarchical'        => false,
            'taxonomies'          => $this->taxonomies,
            'public'              => true,
            'show_ui'             => true,
            'show_in_menu'        => true,
            'show_in_nav_menus'   => true,
            'show_in_admin_bar'   => true,
            //'menu_position'       => $this->menu_pos,
            'can_export'          => true,
            'has_archive'         => true,
            'exclude_from_search' => false,
            'publicly_queryable'  => true,
            'capability_type'     => 'post',
        );

        if($this->post == false){
            //$this->attributes['supports'] = array('title','editor','page-attributes');
            $this->attributes['capability_type'] = 'page';
            $this->attributes['hierarchical'] = true;
        }
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

    function CT_admin_icon(){
        echo '
        <style>
        #adminmenu #menu-posts-' . $this->slug . ' .menu-icon-post div.wp-menu-image:before {
          content: "' . $this->icon . '";
        }
        </style>';
    }

    function CT_remove_cat_metabox() {
        remove_meta_box('categories-' . $this->slug . 'div', $this->slug, 'side');
    }

    function CT_remove_tag_metabox() {
        remove_meta_box('tags-' . $this->slug . 'div', $this->slug, 'side');
    }
}

?>