<?php

/**
 * @package SCM
 */

	if( isset($this) ){

		$paged = ( is_front_page() ? 'page' : 'paged' );

		$args = $this->pargs;
		$args['paged'] = ( $this->pagination == 'yes' ? ( get_query_var( $paged ) ? get_query_var( $paged ) : 1 ) : 1 );
		$type = $args['post_type'];
		$layout = $this->layout;
		$paginationType = $this->pagination;

		$loop = new WP_Query( $args );

		$pagination = ( $paginationType == 'yes' ? scm_pagination( $loop ) : '' );
		$paginationClass = ( $pagination ? ' paginated' : '' );

		$odd = '';

		echo '<ul class="archive archive-' . $type . $paginationClass . '">';

		while ( $loop->have_posts() ) : $loop->the_post();

			global $post;

			$id = $type . '-' . get_the_ID();
			$classes = $type . ' layout-' . $layout . ' ' . $post->post_name;

			$odd = ( $odd ? '' : ' odd' );
			$classes .= $odd;

			echo '<li id="' . $id . '" class="' . $classes . '">';

				Get_Template_Part::get_part( SCM_DIR_PARTS_SINGLE . '-' . $type . '.php', array(
	                'layout' => $layout,
	            ));

			echo '</li>';

		endwhile;

		echo '</ul>';

		echo $pagination;

		wp_reset_query();

	}else{

		get_template_part( SCM_DIR_PARTS, 'none' );

	}

?>
