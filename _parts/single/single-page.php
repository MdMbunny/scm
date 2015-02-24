<?php

global $post;

$type = $post->post_type;
$slug = $post->post_name;

$id = $post->ID;

$site_align = scm_field( 'select_alignment_site', 'center', 'option' );

$page_id = scm_field( 'custom_id', '', $id, 1, ' id="', '"' );
$page_class = 'page scm-page scm-object';
$page_class .= scm_field( 'custom_classes', '', $id, 1, ' ' );

$single = ( ( isset($this) && isset($this->single) ) ? $this->single : 0 );

// +++ todo: pesca e assegna Style (vedi section), solo bg contenitore, perché bg viene pescato dalle row (dalle row???)

indent( 5, '<article' . $page_id . ' class="' . $page_class . '">', 2 );
	
	// --- Header

	$active = scm_field( 'active_slider', 0, $id, 1 );

	if( $active ){

		indent( 6, '<header class="header scm-header full ' . $site_align . '">', 2 );

				Get_Template_Part::get_part( SCM_DIR_PARTS_SINGLE . '-scm-slider.php', array(
		            'indent' => 5
		        ));

		indent( 6, '</header><!-- header -->', 2 );
	}

	if( $single ){

        get_template_part( SCM_DIR_PARTS_SINGLE, $type );

	}else{

		Get_Template_Part::get_part( SCM_DIR_PARTS_SINGLE . '-scm-sections.php', array(
            'indent' => 5
        ));
		
	}

indent( 5, '</article><!-- article -->', 2 );

?>
