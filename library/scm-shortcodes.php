<?php

// ***************************************
// *                                     *
// * SCM Shortcodes                      *
// *                                     *
// ***************************************

// Needs:
//		scm-functions.php

//
// Useful Shortcodes
//
// back-button:         class = ''
// 						title = 'Go Back'
//
//


add_shortcode( 'back-button', 'scm_back_shortcode' );



/*** SHORTCODE - back-button - A button to backpage */
function scm_back_shortcode( $atts, $content = null ) {
	$a = shortcode_atts( array(
    	'class' => '',
    	'title' => __('Indietro', SCM_THEME),
    ), $atts );
	$class = $a['class'];
	$title = $a['title'];

	$cont = $content;
	if(!$cont) $cont = $title;
	$title = $cont; 	// needs text_domain

	$ret = '<a href="#" onclick="goBack()" alt="' . $title . '" title="' . $title . '" class="back ' . $class . '">' . $title . '</a>';
	return $ret;

}


?>