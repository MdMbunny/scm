<?php

if ( ! class_exists( 'Duplicate_Post' ) ) {

    class Duplicate_Post {

    	function Duplicate_Post( $lang = '' ) {

    		$this->lang = $lang;

    		add_action( 'admin_action_DP_duplicate', array(&$this, 'DP_duplicate' ) );
        	add_filter( 'page_row_actions', array(&$this, 'DP_add_link' ), 10, 2 );
        	add_filter( 'post_row_actions', array(&$this, 'DP_add_link' ), 10, 2 );
    	}

	// Function creates post duplicate as a draft and redirects then to the edit post screen
        function DP_duplicate(){

            global $wpdb;

            if ( !( isset( $_GET['post']) || isset( $_POST['post']) || ( isset($_REQUEST['action']) && 'DP_duplicate' == $_REQUEST['action'] ) ) ) {
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
    

	// Add the duplicate link to action list
        function DP_add_link( $actions, $post ) {
            if( current_user_can( 'manage_options' ) || current_user_can( 'publish_' . $post->post_type ) ) {
                $actions['duplicate'] = '<a href="admin.php?action=DP_duplicate&amp;post=' . $post->ID . '" title="' . __( 'Duplica questo oggetto', $this->lang ) . '" rel="permalink">' . __( 'Duplica', $this->lang ) . '</a>';
            }
            return $actions;
        }

    }
    
}

?>