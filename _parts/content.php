<?php

/**
 * content.php
 *
 * Part content.
 *
 * @link http://www.studiocreativo-m.it
 *
 * @package SCM
 * @subpackage Parts
 * @since 1.0.0
 */

global $SCM_indent;

// Init
$scm = scm_front_init();

do_action( 'scm_action_content', $_SERVER['REQUEST_URI'] );

// Header
get_header();

switch ($scm['template']) {

// Content from Page, _Single Page or _Archive Page
	case 'page':
		do_action( 'scm_action_content_page', SCM_PAGE_ID );
		scm_content( get_fields( SCM_PAGE_ID ) );
	break;

// Content from Single Part or Archive Part
	case 'part':
		do_action( 'scm_action_content_part', $scm['part'] );
		get_template_part( $scm['part'], $scm['type'] );
	break;

// Content from Template
	default:
		do_action( 'scm_action_content_template', $scm['template'] );
		indent( $SCM_indent + 1, '<div id="post-' . SCM_PAGE_ID . '" class="section scm-section object scm-object single-post full ' . SCM_SITE_ALIGN . '">', 2 );
			indent( $SCM_indent + 2, '<div class="row scm-row object scm-object responsive ' . scm_utils_style_get( 'align', 'option', 0 ) . '">', 2 );
				$SCM_indent += 3;
				scm_contents( array( 'acf_fc_layout' => 'layout-' . str_replace( '-', '_', $scm['type'] ), 'template' => $scm['template'], 'type' => 'single', 'single' => array( SCM_PAGE_ID ) ) );
				$SCM_indent -= 3;
			indent( $SCM_indent + 2, '</div><!-- row -->', 2 );
		indent( $SCM_indent + 1, '</div><!-- section -->', 2 );
	break;

}

// Footer
get_footer();

?>
