<?php

global $SCM_indent, $SCM_types, $SCM_page_id;

$id = get_the_ID();
$SCM_page_id = $id;
$type = get_post_type();
$site_align = scm_field( 'layout-alignment', 'center', 'option' );
$single = is_single();
$archive = is_archive();
$template = 'page';
$notpage = 0; $page = 0; $temp = '';
if( $single ){
	$notpage = 1;
	$page = get_page_by_path( '_single-' . $type );
	$temp = SCM_DIR_PARTS_SINGLE;
}elseif( $archive ){
	$notpage = 1;
	$page = get_page_by_path( '_archive-' . $type );
	$temp = SCM_DIR_PARTS_ARCHIVE;
}

// Check if is PAGE, SINGLE or ARCHIVE ------------------------------------------------------------------------

if( $notpage ){

// If Type is not Public
	if( getByKey( $SCM_types['public'], $type ) === false )
		get_template_part( SCM_DIR_PARTS, 'none' ); // (back to home) 
	
// If a Page named '_single-{post_type}' | '_archive-{post_type}' exists
	if( $page ){
		$id = $SCM_page_id = $page->ID;

// If a template file '_parts/single/single-{post_type}.php' | '_parts/archive/archive-{post_type}.php' exists
	}elseif( locate_template( $temp . '-' . $type . '.php' ) ){
		$template = 'part';

// If query arg ?template=XXX exists
	}else{
		$template = get_query_var( 'template', 0 );
		if( !$template )
			get_template_part( SCM_DIR_PARTS, 'none' ); // (back to home)
	}
}

// Build Contents ---------------------------------------------------------------------------------------------

// Header
//acf_form_head(); <-- se esiste acf_form in pagina / se opzione acf_form attiva / soprattutto se utente è loggato
get_header();

switch ($template) {

// Content from Page, _Single Page or _Archive Page
	case 'page':
		scm_content( get_fields( $id ) );
		break;

// Content from Single Part or Archive Part
	case 'part':
		get_template_part( $temp, $type );
		break;

// Content from Template
	default:
		indent( $SCM_indent + 1, '<div id="post-' . $id . '" class="section scm-section object scm-object single-post full ' . $site_align . '">', 2 );
			indent( $SCM_indent + 2, '<div class="row scm-row object scm-object responsive ' . scm_options_get( 'align', 'option', 0 ) . '">', 2 );
				$SCM_indent += 3;
				scm_contents( array( 'acf_fc_layout' => 'layout-' . str_replace( '-', '_', $type ), 'template' => $template, 'type' => 'single', 'single' => array( $id ) ) );
				$SCM_indent -= 3;
			indent( $SCM_indent + 2, '</div><!-- row -->', 2 );
		indent( $SCM_indent + 1, '</div><!-- section -->', 2 );
	break;

}

//acf_form(array( 'id'=>$post->ID, 'fields'=>array('page-layout','page-id','page-class','page-menu') )); <-- moooolto interessante

// Footer
get_footer();

?>
