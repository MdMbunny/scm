<?php

	//require( '_library/scm-functions.php' );
	//require( '_library/scm-options.php' );

	//require_once( SCM_DIR_LIBRARY . 'scm-functions.php' );

	//require_once( SCM_DIR_LIBRARY . 'scm-options.php' );
	

    header("Content-type: text/css; charset: UTF-8");


	/*$absolute_path = explode('wp-content', $_SERVER['SCRIPT_FILENAME']);
	$wp_load = $absolute_path[0] . 'wp-load.php';
	require_once($wp_load);

	header('Content-type: text/css');
	header('Cache-control: must-revalidate');*/


	$html = scm_options_get( 'bg_color', 'styles-loading', 1 );
	$html .= ( scm_options_get( 'bg_image', 'styles-loading', 1 ) ?: '' );
	$html .= scm_options_get( 'bg_size', 'styles-loading', 1 );

	$font = scm_options_get( 'font', 'option', 1 );
	//$font .= scm_options_get( 'size', 'option', 1 );
	$opacity = scm_options_get( 'opacity', 'option', 1 );
	$align = scm_options_get( 'align', 'option', 1 );
	$line_height = scm_options_get( 'line_height', 'option', 1 );

	$body = scm_options_get( 'size', 'option', 1 );
	$body .= scm_options_get( 'color', 'option', 1 );
	$body .= scm_options_get( 'weight', 'option', 1 );
	$body .= scm_options_get( 'shadow', 'option', 1 );
	$body .= scm_options_get( 'margin', 'option', 1 );
	$body .= scm_options_get( 'padding', 'option', 1 );

	$body .= scm_options_get( 'bg_image', 'option', 1 );
	$body .= scm_options_get( 'bg_repeat', 'option', 1 );
	$body .= scm_options_get( 'bg_position', 'option', 1 );
	$body .= scm_options_get( 'bg_size', 'option', 1 );
	$body .= scm_options_get( 'bg_color', 'option', 1 );

	$menu_font = scm_options_get( 'font', 'menu', 1 );

	$top_bg = scm_options_get( 'bg_color', 'opt-tools-topofpage-bg', 1 );
	$top_icon = scm_options_get( 'text_color', 'opt-tools-topofpage-txt', 1 );

	// Print Main Style

	$css = lbreak() . 'html{ ' . $html . ' }' . lbreak();

	$css .= '*, input, textarea{ ' . $font . ' }' . lbreak();

	$css .= 'body { ' . $body . ' }' . lbreak();

	$css .= '.site-page { ' . $opacity . ' }' . lbreak();

	$css .= '.scm-row { ' . $align . ' }' . lbreak();

	//$css .= '.site-content{ ' . $content . ' }' . lbreak();

	$css .= '.site-content, .site-footer{ ' . $line_height . ' }' . lbreak();

	$css .= '.navigation ul li a { ' . $menu_font . ' }' . lbreak();

	$css .= '.topofpage { ' . $top_bg . ' }' . lbreak();
	$css .= '.topofpage a i { ' . $top_icon . ' }' . lbreak();

	// Responsive

	$r_max = (int)scm_field( 'layout-max', '1400', 'option' );

	if( $r_max >= 1400 )
		$css .= '.r1400 .responsive { width: 1250px; }' . lbreak();
	else
		$css .= '.r1400 .responsive, ';

	if( $r_max >= 1120 )
		$css .= '.r1120 .responsive { width: 1120px; }' . lbreak();
	else
		$css .= '.r1120 .responsive, ';

	if( $r_max >= 1030 )
		$css .= '.r1030 .responsive { width: 1030px; }' . lbreak();
	else
		$css .= '.r1030 .responsive, ';

	if( $r_max >= 940 )
		$css .= '.r940 .responsive { width: 940px; }' . lbreak();
	else
		$css .= '.r940 .responsive, ';

	if( $r_max >= 800 )
		$css .= '.r800 .responsive { width: 800px; }' . lbreak();
	else
		$css .= '.r800 .responsive, ';

	if( $r_max >= 700 )
		$css .= '.r700 .responsive { width: 700px; }' . lbreak();

	$css .= '.tofull .responsive, .smart .responsive { width: 100%; }' . lbreak();

	$r_desktop = (int)scm_options_get( 'size', 'option' ) + (int)scm_field( 'styles-size-desktop', -1, 'option' );
	$css .= 'body.desktop { font-size: ' . $r_desktop . 'px; }' . lbreak();

	$r_wide = (int)scm_options_get( 'size', 'option' ) + (int)scm_field( 'styles-size-wide', 0, 'option' );
	$css .= 'body.wide { font-size: ' . $r_wide . 'px; }' . lbreak();

	$r_landscape = (int)scm_options_get( 'size', 'option' ) + (int)scm_field( 'styles-size-landscape', 1, 'option' );
	$css .= 'body.landscape { font-size: ' . $r_landscape . 'px; }' . lbreak();

	$r_portrait = (int)scm_options_get( 'size', 'option' ) + (int)scm_field( 'styles-size-portrait', 2, 'option' );
	$css .= 'body.portrait { font-size: ' . $r_portrait . 'px; }' . lbreak();

	$r_smart = (int)scm_options_get( 'size', 'option' ) + (int)scm_field( 'styles-size-smart', 3, 'option' );
	$css .= 'body.smart { font-size: ' . $r_smart . 'px; }' . lbreak();


	echo $css;

?>



