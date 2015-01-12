<?php

class Custom_Taxonomy {
 
    function __construct( $singular, $plural, $slug, $types = array(''), $tag = false) {

    	$this->attributes = array();
        
        $this->singular = $singular;
        $this->plural = $plural;
        $this->slug = $slug;
        $this->types = $types;
        $this->tag = $tag;

        $this->CT_taxonomy();
        register_taxonomy( $this->slug, $this->types, $this->attributes);
 
    }
 	
 	function CT_taxonomy() {
 		$this->attributes = array(
			'labels' => array(
				'name'                       => $this->plural,
				'singular_name'              => $this->singular,
				'menu_name'                  => $this->plural,
				'all_items'                  => __( 'Tutto', SCM_THEME ),
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
			'hierarchical'               => true,
			'public'                     => true,
			'show_ui'                    => true,
			'show_admin_column'          => false,
			'show_in_nav_menus'          => true,
			'show_tagcloud'              => false
		);

		if( isset( $tag ) && $tag == true){
			$array['hierarchical'] = false;
		}

 	}
}

?>