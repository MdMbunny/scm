<?php
/**
 * @package SCM
 */

if( have_rows('flexible_content') ):

	global $post;

	$contents = array();

    while ( have_rows('flexible_content') ) : the_row();
		
		$layout = get_row_layout();

		switch ($layout) {

			case 'text_element':
				$content = get_sub_field('testo');
				if(!$content) continue;
				echo $content;

			break;

			case 'galleria_element':

				$single = get_sub_field( 'select_galleria' );
				if(!$single) continue;
				$single_type = $single->post_type;
				$post = $single;
				setup_postdata( $post );
				Get_Template_Part::get_part( SCM_DIR_PARTS_SINGLE . '-' . $single_type . '.php', array(
					'b_init' 	=> get_sub_field( 'module_galleria_init' ),
					'b_type' 	=> get_sub_field( 'module_galleria_type' ),
					'b_img' 	=> get_sub_field( 'module_galleria_img_num' ),
					'b_size' 	=> get_sub_field( 'module_galleria_img_size' ),
					'b_txt' 	=> get_sub_field( 'module_galleria_txt' ),
					'b_bg' 		=> get_sub_field( 'module_galleria_txt_bg' ),
					'b_mod' 	=> get_sub_field( 'module_galleria_module' ),
				));

			break;

			case 'soggetto_element':

				$single = get_sub_field( 'select_soggetto' );
				if(!$single) continue;
				$single_type = $single->post_type;
				$build = get_sub_field('flexible_soggetto');
				$post = $single;
				setup_postdata( $post );
				Get_Template_Part::get_part( SCM_DIR_PARTS_SINGLE . '-' . $single_type . '.php', array(
				   'soggetto_rows' => $build,
				));

			break;

			case 'contact_form_element':

				$single = get_sub_field( 'select_contact_form' );
				if(!$single) continue;
				$single_type = $single->post_type;
				$post = $single;
				setup_postdata( $post );
				get_template_part( SCM_DIR_PARTS_SINGLE, $single_type );

			break;

			case 'login_form_element':

				get_template_part( SCM_DIR_PARTS_SINGLE . 'login-form' );

			break;
			
		}

    endwhile;

else :

    // no layouts found

endif;

?>