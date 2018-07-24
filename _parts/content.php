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
$scm = apply_filters( 'scm_filter_content', $scm );

/*define( 'SCM_POST_TEMPLATE',			$scm['template'] );
define( 'SCM_POST_TYPE',				$scm['type'] );
define( 'SCM_POST_PAGE',				$scm['part'] );*/

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

// Content from Taxonomy Part
	case 'part-tax':
		do_action( 'scm_action_content_part', $scm['part'] );
		get_template_part( $scm['part'], $scm['tax'] );
	break;

// Content from Template
	default:

		do_action( 'scm_action_content_template', $scm['template'] );

	// Content from Single Template
		/*if( $scm['temp'] == 'single' ){

			indent( $SCM_indent + 1, '<div id="post-' . SCM_PAGE_ID . '" class="section scm-section object scm-object single-post full ' . SCM_SITE_ALIGN . '">', 2 );
				//indent( $SCM_indent + 2, '<div class="row scm-row object scm-object responsive ' . scm_field( 'field_5a82944c3680b94427d9e520c3b7b9fb454bc37d', 'left', 'option' ) . '">', 2 );
				indent( $SCM_indent + 2, '<div class="row scm-row object scm-object responsive ' . scm_utils_style_get( 'align', 'option', 0 ) . '">', 2 );
					$SCM_indent += 3;

					if( $scm['template'] == 'function' )
						call_user_func( $scm['part'] );
					else
						scm_contents( array( 'acf_fc_layout' => 'layout-' . str_replace( '-', '_', $scm['type'] ), 'template' => $scm['template'], 'type' => 'single', 'single' => array( SCM_PAGE_ID ) ) );

					$SCM_indent -= 3;
				indent( $SCM_indent + 2, '</div><!-- row -->', 2 );
			indent( $SCM_indent + 1, '</div><!-- section -->', 2 );

	
		}else{

	// Content from Archive Template
			if( $scm['temp'] == 'archive' ){
	
				echo 'ARCHIVE';
	
	// Content from Taxonomy Template
			}elseif( $scm['temp'] == 'tax' ){
	
				echo 'TAX';
			}
		}*/

		indent( $SCM_indent + 1, '<div id="post-' . SCM_PAGE_ID . '" class="section scm-section object scm-object ' . $scm['temp'] . '-post full ' . SCM_SITE_ALIGN . '">', 2 );

			$id = ( $scm['temp'] != 'single' ? 'archive-' . $scm['type'] . ( $scm['tax'] ? '-' . $scm['tax'] . ( $scm['term'] ? '-' . $scm['term'] : '' ) : '' ) : '' );


		
			switch ( $scm['temp'] ) {
				case 'archive':

					do_action( 'scm_action_echo_container_before_archive', $scm, $scm['type'] );

				break;

				case 'tax':

					if( $scm['term_obj'] ){
						do_action( 'scm_action_echo_container_before_term', $scm, $scm['term_obj'] );
					}

				break;
				
				default:

					do_action( 'scm_action_echo_container_before_single', $scm, $scm['type'] );

				break;
			}

			indent( $SCM_indent + 2, '<div class="row scm-row object scm-object responsive ' . scm_utils_style_get( 'align', 'option', 0 ) . '">', 2 );
				$SCM_indent += 3;

				if( $scm['template'] == 'function' ){
					call_user_func( $scm['part'] );
				}else{
					$contents = array();
					$contents['acf_fc_layout'] = 'layout-' . str_replace( '-', '_', $scm['type'] );
					$contents['template'] = $scm['template'];

					if( $scm['temp'] == 'single' ){
						$contents['type'] = 'single';
						$contents['single'] = array( SCM_PAGE_ID );
					}else{
						$contents['type'] = 'archive';
						$contents['archive-complete'] = 'archive';
						$contents['archive-pagination'] = 'yes';
						$contents['archive-perpage'] = 1;
						$contents['archive-orderby'] = 'title';
						$contents['archive-ordertype'] = 'ASC';
						
                    	$contents['archive-paginated'] = $id;
						
						if( $scm['temp'] == 'tax' && $scm['term_obj'] ){
							$contents['archive-relation'] = 'AND';
							$archive = 'archive-' . $scm['tax'] . '-terms';
							$contents[$archive] = array( $scm['term_obj']->term_id );
						}
						indent( $SCM_indent + 3, '<div' . ( $id ? ' id="' . $id . '"' : '' ) . ' class="scm-archive object scm-object">', 2 );

						if( $scm['temp'] == 'tax' )
							$contents = apply_filters( 'scm_filter_echo_content_' . $scm['tax'], $contents, $scm );
						
					}
					$contents = apply_filters( 'scm_filter_echo_content_' . $scm['temp'], $contents );
    				$contents = apply_filters( 'scm_filter_echo_content_' . $scm['temp'] . '_' . $scm['type'], $contents );
					scm_contents( $contents );
					if( $scm['temp'] != 'single' )
						indent( $SCM_indent + 3, '</div>', 2 );

				}

				$SCM_indent -= 3;
			indent( $SCM_indent + 2, '</div><!-- row -->', 2 );
		indent( $SCM_indent + 1, '</div><!-- section -->', 2 );

	break;

}

// Footer
get_footer();

?>
