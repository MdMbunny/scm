<?php

global $post, $SCM_indent, $SCM_types;
$type = get_post_type();
$single = is_single();
$archive = is_archive();

// return none (back to home) if type is not public, or has not a template
if( $archive || ( $single &&
	( getByKey( $SCM_types['public'], $type ) === false || 
	  !locate_template( SCM_DIR_PARTS_SINGLE . '-' . $type . '.php' ) ) ) ) {
		get_template_part( SCM_DIR_PARTS, 'none' );
// build page + content, or page + single
}else{

	// WP Header
	get_header();

	$id = get_the_ID();
	
	$site_align = scm_field( 'layout-alignment', 'center', 'option' );

	$page_class = 'page scm-page object scm-object ' . $post->post_name;

	$page_id = scm_field( 'page-selectors-id', '', $id, 1, ' id="', '"' );
	$page_class .= scm_field( 'page-selectors-class', '', $id, 1, ' ' );
	
	//$page_style = scm_options_get_style( $id, 1 );
	
	$page_slider = scm_field( 'main-slider-active' );
	$page_slider_terms = scm_field( 'main-slider-terms' );


	if( $single ){
		$page_slider = scm_field( 'slider-enabled', 0, 'option', 1 ); // serve?
	}


	$SCM_indent += 1;
	indent( $SCM_indent, '<article' . $page_id . ' class="' . $page_class . '">', 2 );
		$SCM_indent += 1;

		
		// Page Header
		if( $page_slider ){

			indent( $SCM_indent, '<header class="header scm-header full ' . $site_align . '">', 2 );

				indent( $SCM_indent + 1, '<div class="row scm-row object scm-object responsive ' . scm_field( 'layout-content', 'full', 'option' ) . '">', 2 );

					scm_contents( [ [ 'acf_fc_layout' => 'layout-slider', 'slider' => $page_slider_terms, 'type' => $page_slider ] ] );
					//get_template_part( SCM_DIR_PARTS_SINGLE, 'slider' );

				indent( $SCM_indent + 1, '</div><!-- row -->', 2 );

			indent( $SCM_indent, '</header><!-- header -->', 2 );
		}

		if( $single ){

			indent( $SCM_indent + 1, '<div class="section scm-section object scm-object single-post full ' . $site_align . '">', 2 );
				indent( $SCM_indent + 2, '<div class="row scm-row object scm-object responsive ' . scm_options_get( 'align', 'option', 0 ) . '">', 2 );

					$SCM_indent += 3;
					scm_contents( [ 'acf_fc_layout' => 'layout-' . str_replace( '-', '_', $type ), 'single' => [ $id ] ] );
					$SCM_indent -= 3;

				indent( $SCM_indent + 2, '</div><!-- row -->', 2 );

			indent( $SCM_indent + 1, '</div><!-- section -->', 2 );
			
		}else{



			// Page Content
			//$repeater = scm_field( 'rows', [], $id, 1 );
			//scm_containers( $repeater, 'section' );
			scm_content( get_fields( $id ) );

		}

	$SCM_indent -= 1;
	echo lbreak(2);
	indent( $SCM_indent, '</article><!-- article -->', 2 );
	$SCM_indent -= 1;

	// WP Footer
	get_footer();

}

?>
