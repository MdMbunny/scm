<?php

global $SCM_types;
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

	global $post, $SCM_indent;

	$id = get_the_ID();
	
	$site_align = scm_field( 'layout-alignment', 'center', 'option' );
	
	$tempA = SCM_DIR_PARTS;
	$tempB = 'sections';
	//$page_id = '';
	$page_class = 'page scm-page object scm-object ' . $post->post_name;
	//$head_active = 0;

	$page_id = scm_field( 'page-selectors-id', '', $id, 1, ' id="', '"' );
	$page_class .= scm_field( 'page-selectors-class', '', $id, 1, ' ' );
	
	$page_style = scm_options_get_style( $id, 1 );
	
	$head_active = scm_field( 'slider-enabled', 0, $id, 1 );
	
	if( $single ){

		// QUI I TEMPLATES
		
		$tempA = SCM_DIR_PARTS_SINGLE;
		$tempB = $type;
		$head_active = scm_field( 'slider-enabled', 0, 'option', 1 ); // DA TEMPLATE
		//$page_id = '';		// Da TEMPLATE
		//$page_class .= '';	// Da TEMPLATE
		//$head_active = 0;		// Da TEMPLATE
	}


	$SCM_indent += 1;
	indent( $SCM_indent, '<article' . $page_id . ' class="' . $page_class . '" ' . $page_style . '>', 2 );
		$SCM_indent += 1;

		
		// Page Header
		if( $head_active ){

			indent( $SCM_indent, '<header class="header scm-header full ' . $site_align . '">', 2 );

				get_template_part( SCM_DIR_PARTS_SINGLE, 'slider' );

			indent( $SCM_indent, '</header><!-- header -->', 2 );
		}

		if( $single ){

			$site_align = scm_field( 'layout-alignment', 'center', 'option' );

			indent( $SCM_indent + 1, '<div class="section scm-section object scm-object full ' . $site_align . '">', 2 );
				indent( $SCM_indent + 2, '<div class="row scm-row object scm-object responsive ' . scm_options_get( 'align', 'option', 0 ) . '">', 2 );

					$SCM_indent += 3;
					scm_flexible_content( [ [ 'acf_fc_layout' => 'layout-' . str_replace( '-', '_', $type ), 'single' => [ $id ] ] ] );
					$SCM_indent -= 3;

				indent( $SCM_indent + 2, '</div><!-- row -->', 2 );

			indent( $SCM_indent + 1, '</div><!-- section -->', 2 );
			
		}else{

			// Page Content
			// if single o archive crea <section><row>
			// if single chiama flexible_content( [ 'acf_fc_layout' => 'layout-' . $type ] )
			get_template_part( $tempA, $tempB );
		}


	$SCM_indent -= 1;
	echo lbreak(2);
	indent( $SCM_indent, '</article><!-- article -->', 2 );
	$SCM_indent -= 1;

	// WP Footer
	get_footer();

}

?>
