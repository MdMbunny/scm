<?php

global $SCM_types;
$type = get_post_type();
$single = is_single();

// return none (back to home) if type is not public, or has not a template
if( $single &&
	( getByKey( $SCM_types['public'], $type ) === false || 
	  !locate_template( SCM_DIR_PARTS_SINGLE . '-' . $type . '.php' ) ) ){
		get_template_part( SCM_DIR_PARTS, 'none' );

// build page + content, or page + single
}else{

	// WP Header
	get_header();

	global $post, $SCM_indent;

	$id = $post->ID;
	
	$site_align = scm_field( 'select_alignment_site', 'center', 'option' );
	
	$tempA = SCM_DIR_PARTS;
	$tempB = 'sections';
	//$page_id = '';
	$page_class = 'page scm-page object scm-object ' . $post->post_name;
	//$head_active = 0;

	$page_id = scm_field( 'id_page', '', $id, 1, ' id="', '"' );
	$page_class .= scm_field( 'class_page', '', $id, 1, ' ' );
	$head_active = scm_field( 'select_disable_slider', 0, $id, 1 );

	
	if( $single ){
		
		$tempA = SCM_DIR_PARTS_SINGLE;
		$tempB = $type;
		$head_active = scm_field( 'active_slider', 0, 'option', 1 ); // DA TEMPLATE
		//$page_id = '';		// Da TEMPLATE
		//$page_class .= '';	// Da TEMPLATE
		//$head_active = 0;		// Da TEMPLATE
	}

	// +++ todo: pesca e assegna Style (vedi section), solo bg contenitore, perché bg viene pescato dalle row (dalle row???)


	$SCM_indent += 1;
	indent( $SCM_indent, '<article' . $page_id . ' class="' . $page_class . '">', 2 );
		$SCM_indent += 1;

		
		// Page Header
		if( $head_active ){

			indent( $SCM_indent, '<header class="header scm-header full ' . $site_align . '">', 2 );

				get_template_part( SCM_DIR_PARTS_SINGLE, 'slider' );

			indent( $SCM_indent, '</header><!-- header -->', 2 );
		}

		// Page Content
		get_template_part( $tempA, $tempB );


	$SCM_indent -= 1;
	echo lbreak(2);
	indent( $SCM_indent, '</article><!-- article -->', 2 );
	$SCM_indent -= 1;

	// WP Footer
	get_footer();

}

?>
