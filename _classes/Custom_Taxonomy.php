<?php

if ( ! class_exists( 'Custom_Taxonomy' ) ) {

/**
 * Create Custom Taxonomies
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
);

$tax = new Custom_Taxonomy( $args );
```
 *
 * @link http://www.studiocreativo-m.it
 *
 * @package SCM
 * @subpackage 3-Install/Types
 * @since 1.0.0
 */
    class Custom_Taxonomy {

        /**
        * [GET] Custom Taxonomy init
        *
        * @param {array} build Required. List of arguments.
        * @param {string=} lang Theme slug for translations (default is theme slug).
        * @return {Object} Custom taxonomy object.
        */
        public function __construct( $build, $lang = '' ) {

        	if( !$build ) return;

            $this->lang = ( $lang ?: sanitize_title( get_bloginfo() ) );

            $default = array(
            	'template'              => 0,
                'active'                => 1,
                'hierarchical' 			=> 1,
                'singular'              => '',
                'plural'                => '',
                'slug'                  => '',
                'types' 				=> array(),
                'add_cap'               => 0,
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
            $this->template = $default['template'];
            $this->active = $default['active'];
            $this->add_cap = ( !$default['add_cap'] ? 'manage_options' : ( $default['add_cap'] == 'member' ? 'upload_files' : 'list_users' ) );

            $this->attributes = array(
                'labels' => array(
                    'name'                       => $this->plural,
                    'singular_name'              => $this->singular,
                    'menu_name'                  => $this->plural,
                    'all_items'                  => __( 'Elenco', $this->lang ),
                    'parent_item'                => __( 'Genitore', $this->lang ),
                    'parent_item_colon'          => __( 'Genitore:', $this->lang ),
                    'new_item_name'              => __( 'Aggiungi', $this->lang ),
                    'add_new_item'               => __( 'Aggiungi', $this->lang ),
                    'edit_item'                  => __( 'Modifica', $this->lang ),
                    'update_item'                => __( 'Aggiorna', $this->lang ),
                    'separate_items_with_commas' => __( 'Separa gli elementi con una virgola', $this->lang ),
                    'search_items'               => __( 'Cerca', $this->lang ),
                    'add_or_remove_items'        => __( 'Aggiungi o Rimuovi', $this->lang ),
                    'choose_from_most_used'      => __( 'I pi&ugrave; usati', $this->lang ),
                    'not_found'                  => __( 'Non trovato', $this->lang )
                ),
                'hierarchical'               => $this->tag,
                'public'                     => true,
                'show_ui'                    => true,
                'show_in_menu'               => true,//( !current_user_can( 'update_core' ) && !$this->tag ? false : true ),
                'show_admin_column'          => false,
                'show_in_nav_menus'          => true,
                'show_tagcloud'              => false,
                'capabilities' => array(
                    'manage_terms' => $this->add_cap,
                ),
            );
        }
        public function Custom_Taxonomy( $build, $lang = '' ) {
            self::__construct( $build, $lang );
        }

// ------------------------------------------------------
// PUBLIC
// ------------------------------------------------------

        /**
        * [SET] Registers Custom Taxonomy
        */
        function register(){
            if( !empty( $this->types ) ){
                add_action( 'admin_menu', array( &$this, 'remove_metaboxes' ) );

                $arr = array();
                foreach ( $this->types as $key ) {
                    if( post_type_exists( $key . '_temp' ) )
                        $arr[] = $key . '_temp';
                }

                $this->types = array_merge( $this->types, $arr );
                register_taxonomy( $this->slug, $this->types, $this->attributes);
            }
        }

// ------------------------------------------------------
// ADMIN HOOKS
// ------------------------------------------------------

        /**
        * [SET] Removes default WP taxonomy metaboxes from edit page
        *
        * Hooked by 'admin_menu'
        */
        function remove_metaboxes() {
            foreach ($this->types as $type) {
                remove_meta_box( $this->slug . 'div', $type, 'side');
                remove_meta_box( 'tagsdiv-' . $this->slug, $type, 'side');
            }
        }
    }
}

?>