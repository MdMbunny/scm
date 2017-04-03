<?php

if ( ! class_exists( 'Duplicate_Post' ) ) {

/**
 * Duplicate_Post.php
 *
 * Duplicate Post service.
 * Apply to posts and pages.
 *
 * @link http://www.studiocreativo-m.it
 *
 * @package SCM
 * @subpackage 4-Init/Admin/7-PLUGINS
 * @since 1.0.0
 */
    class Duplicate_Post {

        /**
         * Duplicate Post init
         *
         * Add actions and filters:<br>
         * @see duplicate() in 'admin_action_{duplicate}' action from query var
         * @see add_link() in 'page_row_actions' filter
         * @see add_link() in 'post_row_actions' filter
         *
         * @param {string=} lang Theme slug for translations (default is theme slug).
         */
    	public function __construct( $lang = '' ) {

    		$this->lang = ( $lang ?: sanitize_title( get_bloginfo() ) );

    		add_action( 'admin_action_duplicate', array(&$this, 'duplicate' ) );
        	add_filter( 'page_row_actions', array(&$this, 'add_link' ), 10, 2 );
        	add_filter( 'post_row_actions', array(&$this, 'add_link' ), 10, 2 );
    	}
        public function Duplicate_Post( $lang = '' ) {
            self::__construct( $lang );
        }


// ------------------------------------------------------
// ADMIN HOOKS
// ------------------------------------------------------

        /**
         * Duplicate Post action
         * Duplicates post as draft, redirects to the edit post screen.
         *
         * Hooked by 'admin_action_duplicate'
         */
        function duplicate(){

            global $wpdb;

            if ( !( isset( $_GET['post']) || isset( $_POST['post']) || ( isset($_REQUEST['action']) && 'duplicate' == $_REQUEST['action'] ) ) ) {
                wp_die( __( 'No post to duplicate has been supplied!', $this->lang ) );
            }

            $post_id = ( isset( $_GET['post'] ) ? $_GET['post'] : $_POST['post'] );
            $post = get_post( $post_id );
            $current_user = wp_get_current_user();
            $new_post_author = $current_user->ID;
         
            if (isset( $post ) && $post != null) {

                $args = array(
                    'comment_status' => $post->comment_status,
                    'ping_status'    => $post->ping_status,
                    'post_author'    => $new_post_author,
                    'post_content'   => $post->post_content,
                    'post_excerpt'   => $post->post_excerpt,
                    'post_name'      => $post->post_name,
                    'post_parent'    => $post->post_parent,
                    'post_password'  => $post->post_password,
                    'post_status'    => 'draft',
                    'post_title'     => $post->post_title,
                    'post_type'      => $post->post_type,
                    'to_ping'        => $post->to_ping,
                    'menu_order'     => $post->menu_order
                );

                $new_post_id = wp_insert_post( $args );

                $taxonomies = get_object_taxonomies( $post->post_type );
                foreach ( $taxonomies as $taxonomy ) {

                    $post_terms = wp_get_object_terms( $post_id, $taxonomy, array( 'fields' => 'slugs' ) );
                    wp_set_object_terms( $new_post_id, $post_terms, $taxonomy, false );

                }

                $post_meta_infos = $wpdb->get_results( "SELECT meta_key, meta_value FROM $wpdb->postmeta WHERE post_id=$post_id" );
                
                if (count($post_meta_infos)!=0) {

                    $sql_query = "INSERT INTO $wpdb->postmeta (post_id, meta_key, meta_value) ";

                    foreach ( $post_meta_infos as $meta_info ) {
                        $meta_key = $meta_info->meta_key;
                        $meta_value = addslashes( $meta_info->meta_value );
                        $sql_query_sel[] = "SELECT $new_post_id, '$meta_key', '$meta_value'";
                    }

                    $sql_query.= implode( " UNION ALL ", $sql_query_sel );
                    $wpdb->query( $sql_query );

                }

                wp_redirect( admin_url( 'post.php?action=edit&post=' . $new_post_id ) );

                exit;

            } else {

                wp_die( __( 'Post creation failed, could not find original post', $this->lang ) . ': ' . $post_id);

            }
        }
    
        /**
         * Duplicate Post link
         * Adds duplicate link to action list.
         *
         * Hooked by 'page_row_actions', 'post_row_actions'
         *
         * @param {array} actions List of actions (default is empty array).
         * @param {Object} post Post object.
         * @return {array} Modified list of actions.
         */
        function add_link( $actions = array(), $post = NULL ) {
            if( is_null( $post ) ) return $actions;
            if( current_user_can( 'manage_options' ) || current_user_can( 'publish_' . $post->post_type ) ) {
                $actions['duplicate'] = '<a href="admin.php?action=duplicate&amp;post=' . $post->ID . '" title="' . __( 'Duplica questo oggetto', $this->lang ) . '" rel="permalink">' . __( 'Duplica', $this->lang ) . '</a>';
            }
            return $actions;
        }

    }
    
}

?>