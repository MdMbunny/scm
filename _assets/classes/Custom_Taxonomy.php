<?php

class Custom_Taxonomy {
 
    function __construct( $build ) {

    	if( !$build )
            return;

        $default = array(
        	'hierarchical' 			=> 1,
            'singular'              => '',
            'plural'                => '',
            'slug'                  => '',
            'types' 				=> [],
        );

        if( is_array( $build ) )
            $default = array_merge( $default, $build );
        else if( is_string( $build ) )
            $default['plural'] = $build;
        else
        	return;

    	$this->attributes = array();
        
        $this->plural = $default['plural'];
        $this->singular = ( $default['singular'] ?: $this->plural );
        $this->slug = ( $default['slug'] ?: sanitize_title( $this->plural ) );
        $this->types = $default['types'];
        $this->tag = $default['hierarchical'];

        $this->CT_taxonomy();
        if( !empty( $this->types ) ){
            $arr = [];
            foreach ( $this->types as $key ) {
                if( post_type_exists( $key . '_temp' ) )
                    $arr[] = $key . '_temp';
            }
            $this->types = array_merge( $this->types, $arr );
	        register_taxonomy( $this->slug, $this->types, $this->attributes);
	        add_action( 'admin_menu', array( &$this, 'CT_remove_metaboxes' ) );	        
	    }
    }

    function CT_remove_metaboxes() {
        foreach ($this->types as $type) {
            remove_meta_box( $this->slug . 'div', $type, 'side');
            remove_meta_box( 'tagsdiv-' . $this->slug, $type, 'side');
        }
    }
 	
 	function CT_taxonomy() {
 		$this->attributes = array(
			'labels' => array(
				'name'                       => $this->plural,
				'singular_name'              => $this->singular,
				'menu_name'                  => $this->plural,
				'all_items'                  => __( 'Elenco', SCM_THEME ),
				'parent_item'                => __( 'Genitore', SCM_THEME ),
				'parent_item_colon'          => __( 'Genitore:', SCM_THEME ),
				'new_item_name'              => __( 'Aggiungi', SCM_THEME ),
				'add_new_item'               => __( 'Aggiungi', SCM_THEME ),
				'edit_item'                  => __( 'Modifica', SCM_THEME ),
				'update_item'                => __( 'Aggiorna', SCM_THEME ),
				'separate_items_with_commas' => __( 'Separa gli elementi con una virgola', SCM_THEME ),
				'search_items'               => __( 'Cerca', SCM_THEME ),
				'add_or_remove_items'        => __( 'Aggiungi o Rimuovi', SCM_THEME ),
				'choose_from_most_used'      => __( 'I pi&ugrave; usati', SCM_THEME ),
				'not_found'                  => __( 'Non trovato', SCM_THEME )
			),
			'hierarchical'               => $this->tag,
			'public'                     => true,
			'show_ui'                    => true,
			'show_admin_column'          => false,
			'show_in_nav_menus'          => true,
			'show_tagcloud'              => false
		);

 	}
}

?>