<!--<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Browser da aggiornare</title>-->

<?php

    $logo_image = esc_url( scm_field( 'opt-fallback-logo', scm_field( 'brand-logo', SCM_URI_IMG . '/logo.png', 'option' ), 'option' ) );
    $html = scm_options_get( 'bg_color', 'styles-loading', 1 );

?>

<style>
/***********************************************************************************************/

/*** LANDING IE ***/

body{
    <?php echo $html; ?>
}

img{
    max-width: 100%;
}

.landing{
	font-family: Helvetica, Arial, san-serif;
    width: 500px;
    margin: 30px auto 50px auto;
    text-align: center;
    background-color: #fff;
    padding: 30px;
    color: #000;
}

.landing p{
    font-size: 2em;
    line-height: 1em;
    margin: 60px 0;
}

.landing br{
    display: none;
}

.landing a{
    padding-bottom: 40px;
    display: block;
    padding-top: 20px;
}

.landing a.mail{
    
}

.landing #browsers{
    display: block;
    width: 100%;
    line-height: 0px;
    list-style: none !important;
}

.landing #browsers .browser{
    display: inline;
    height: 120px;
    width: 120px;
    list-style: none !important;
}


/***********************************************************************************************/
</style>
</head>

<body>
<div class="block landing">
<img src="<?php echo $logo_image ?>" />

<?php
echo '<p>' . __( 'Update your browser or download one of the following to correctly see this website.', SCM_THEME ) . '</p>';
?>

<div id="browsers">
<!--<a href="http://windows.microsoft.com/it-it/internet-explorer/download-ie" target="_blank"><img src="<?php echo SCM_URI_IMG ?>/landing_ie_icon_ie.png" /></a>-->
<a class="browser" href="http://www.mozilla.org/it/firefox/new/" target="_blank"><img src="<?php echo SCM_URI_IMG ?>/landing_ie_icon_firefox.png" /></a>
<a class="browser" href="https://www.google.com/intl/en/chrome/browser/" target="_blank"><img src="<?php echo SCM_URI_IMG ?>/landing_ie_icon_chrome.png" /></a>
<!--<a class="browser" href="http://support.apple.com/downloads/#safari" target="_blank"><img src="<?php echo SCM_URI_IMG ?>/landing_ie_icon_safari.png" /></a>-->
<a class="browser" href="http://www.opera.com/it/computer/windows" target="_blank"><img src="<?php echo SCM_URI_IMG ?>/landing_ie_icon_opera.png" /></a>
</div>
</div>
</body>
</html>
