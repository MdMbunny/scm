<?php

if ( ! class_exists( 'Custom_Taxonomy' ) ) {

/**
 * Custom_Taxonomy.php
 *
 * Custom Taxonomies Class.
 *
 * Example usage:
 *
```php
$args = array(
    'template'              => 0,            // bool Active (1) or Deactive (0) template mode
    'active'                => 1,            // bool Active (1) or Deactive (0) Taxonomy
    'hierarchical'          => 1,            // bool Category (1) or Tag (0) hierarchical
    'add_cap'               => 1,            // bool Add (1) or Remove (0) capabilities for middle users
    'types'                 => array(),      // array List of Types to link with
    'singular'              => '',           // string Taxonomies singular name
    'plural'                => '',           // string Taxonomies plural name
    'slug'                  => '',           // string Taxonomies slug
    'theme'                 => '',           // string Theme slug for translations
);

$tax = new Custom_Taxonomy( $args );
```
 *
 * @param array $build The arguments to pass to this file. Optional.
 * Default empty array.
 *
 * @return object Custom Taxonomy object.
 *
 * @link http://www.studiocreativo-m.it
 *
 * @package SCM
 * @subpackage Classes
 * @since 1.0.0
 */
    class Custom_Taxonomy {
     
        function __construct( $build ) {

        	if( !$build )
                return;

            $default = array(
            	'template'              => 0,
                'active'                => 1,
                'hierarchical' 			=> 1,
                'singular'              => '',
                'plural'                => '',
                'slug'                  => '',
                'types' 				=> array(),
                'add_cap'               => 0,
                'theme'                 => '',
            );

            if( is_array( $build ) )
                $default = array_merge( $default, $build );
            else if( is_string( $build ) )
                $default['plural'] = $build;
            else
            	return;

        	$this->attributes = array();
            
            $this->theme = $attr['theme'];
            $this->plural = $default['plural'];
            $this->singular = ( $default['singular'] ?: $this->plural );
            $this->slug = ( $default['slug'] ?: sanitize_title( $this->plural ) );
            $this->types = $default['types'];
            $this->tag = $default['hierarchical'];
            $this->template = $default['template'];
            $this->active = $default['active'];
            $this->add_cap = ( !$default['add_cap'] ? 'manage_options' : ( $default['add_cap'] == 'member' ? 'upload_files' : 'list_users' ) );

            $this->CT_taxonomy();
            if( !empty( $this->types ) ){
                $arr = array();
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
    				'all_items'                  => __( 'Elenco', $this->theme ),
    				'parent_item'                => __( 'Genitore', $this->theme ),
    				'parent_item_colon'          => __( 'Genitore:', $this->theme ),
    				'new_item_name'              => __( 'Aggiungi', $this->theme ),
    				'add_new_item'               => __( 'Aggiungi', $this->theme ),
    				'edit_item'                  => __( 'Modifica', $this->theme ),
    				'update_item'                => __( 'Aggiorna', $this->theme ),
    				'separate_items_with_commas' => __( 'Separa gli elementi con una virgola', $this->theme ),
    				'search_items'               => __( 'Cerca', $this->theme ),
    				'add_or_remove_items'        => __( 'Aggiungi o Rimuovi', $this->theme ),
    				'choose_from_most_used'      => __( 'I pi&ugrave; usati', $this->theme ),
    				'not_found'                  => __( 'Non trovato', $this->theme )
    			),
    			'hierarchical'               => $this->tag,
    			'public'                     => true,
    			'show_ui'                    => true,
    			'show_admin_column'          => false,
    			'show_in_nav_menus'          => true,
    			'show_tagcloud'              => false,
                'capabilities' => array(
                    'manage_terms' => $this->add_cap,
                ),
    		);
     	}
    }
}

?>