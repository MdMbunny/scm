<?php

//phpinfo();

/**
 * @package SCM
 */

// *****************************************************
// *	FUNCTIONS
// *****************************************************

/*
*****************************************************
*
* 	1.0 Globals
* 	2.0 Constants
* 	3.0 Requires
* 	4.0 Functions
*
*****************************************************
*/

if ( ! isset( $content_width ) ) {
	$content_width = 1120;
}

/*
*****************************************************
*      1.0 GLOBAL
*****************************************************
*/

//Getting website data
	
	$SCM_capability 	 = is_admin();
	
	$SCM_site			 = site_url();
	$SCM_parse			 = parse_url($SCM_site);
	$SCM_domain 		 = $SCM_parse["host"];
	$SCM_url			 = 'http://' . $SCM_domain . '/';

//Getting theme data
	$SCM_shortname 		 = sanitize_title(get_template());
	$SCM_data    		 = wp_get_theme( $SCM_shortname );
	$SCM_name    		 = $SCM_data->Name;
	$SCM_version 		 = $SCM_data->Version;
	$SCM_directory		 = get_template_directory();
	$SCM_uri 			 = get_template_directory_uri();
	$SCM_page_templates	 = wp_get_theme()->get_page_templates();

	$SCM_shortname = str_replace( '-v' . $SCM_version, '', $SCM_shortname );

	if( ! $SCM_version ) {
		$SCM_version = '';
	}

	$SCM_uploads 		= wp_upload_dir();
	$SCM_current_screen;
	$SCM_types 			= array();
	$SCM_galleries 		= array();
	$SCM_acf_objects 	= array();
	$SCM_acf_elements 	= array();
	$SCM_acf_layouts 	= array();
	$SCM_fa 			= array();
	$SCM_plugin_fa 		= 0;
	
	$SCM_typekit;

	$SCM_indent 		= 1;

	$SCM_old	 		= false;
	$SCM_ie9	 		= false;
	
/*
*****************************************************
*      2.0 CONSTANTS
*****************************************************
*/

//TypeKit constants
	define( 'SCM_TYPEKIT',				'4c35897b4629b3d1335a774bde83fdc382585564' );

//Append constants

	define( 'SCM_TEMPLATE_APP',			'_t' );

//Basic constants
	define( 'SCM_SITE',				    $SCM_site );
	define( 'SCM_DOMAIN',			    $SCM_domain );
	define( 'SCM_URL',			      	$SCM_url );
	define( 'SCM_NAME',     	 		$SCM_name );
	define( 'SCM_THEME',	 			$SCM_shortname );
	define( 'SCM_CHILD', 				SCM_THEME . '-' . 'child' );
	define( 'SCM_VERSION',   			$SCM_version );
	define( 'SCM_SCRIPTS_VERSION',      trim( SCM_VERSION ) );

//Directories

	// UPLOADS FOLDER
	define( 'SCM_URI_UPLOADS', 			$SCM_uploads['baseurl'] );
	
	// PARENT THEME
	define( 'SCM_DIR',			      	$SCM_directory . '/' );
	define( 'SCM_URI',			      	$SCM_uri . '/' );
	
		// LANGUAGES PARENT
		define( 'SCM_DIR_LANG',      		SCM_DIR . '_languages/' );
		define( 'SCM_URI_LANG',      		SCM_URI . '_languages/' );
	
	// CHILD THEME
	define( 'SCM_DIR_CHILD', 			get_stylesheet_directory() . '/');
	define( 'SCM_URI_CHILD', 			get_stylesheet_directory_uri() . '/');

		// LANGUAGES CHILD
		define( 'SCM_DIR_LANG_CHILD',      	SCM_DIR_CHILD . 'languages/' );
		define( 'SCM_URI_LANG_CHILD',      	SCM_URI_CHILD . 'languages/' );

		// ASSETS
		define( 'SCM_DIR_ASSETS',      			SCM_DIR . '_assets/' );
			define( 'SCM_DIR_CLASSES',      		SCM_DIR_ASSETS . 'classes/' );
			define( 'SCM_DIR_SLIDERS',      		SCM_DIR_ASSETS . 'sliders/' );
			define( 'SCM_DIR_IMG',      			SCM_DIR_ASSETS . 'img/' );
			define( 'SCM_DIR_PLUGINS',			    SCM_DIR_ASSETS . 'plugins/' );
			define( 'SCM_DIR_ACF',      		SCM_DIR_ASSETS . 'acf/' );
				define( 'SCM_DIR_ACF_JSON',      		SCM_DIR_ACF . 'acf-json/' );
				define( 'SCM_DIR_ACF_PLUGIN',      	SCM_DIR_ACF . 'acf-plugin/' );
		define( 'SCM_URI_ASSETS',      			SCM_URI . '_assets/' );
		define( 'SCM_URI_ASSETS_CHILD',      	SCM_URI_CHILD . '_assets/' );
			define( 'SCM_URI_CSS',      			SCM_URI_ASSETS . 'css/' );
			define( 'SCM_URI_CSS_CHILD',      		SCM_URI_ASSETS_CHILD . 'css/' );
			define( 'SCM_URI_JS',      				SCM_URI_ASSETS . 'js/' );
			define( 'SCM_URI_JS_CHILD',      		SCM_URI_ASSETS_CHILD . 'js/' );
			define( 'SCM_URI_IMG',      			SCM_URI_ASSETS . 'img/' );
			define( 'SCM_URI_IMG_CHILD',      		SCM_URI_ASSETS_CHILD . 'img/' );
			define( 'SCM_URI_FONT',      			SCM_URI_ASSETS . 'font/' );
			define( 'SCM_URI_ACF',      		SCM_URI_ASSETS . 'acf/' );
				define( 'SCM_URI_ACF_PLUGIN',      	SCM_URI_ACF . 'acf-plugin/' );
				define( 'SCM_URI_ACF_JSON',      		SCM_URI_ACF . 'acf-json/' );

		// LIBRARY 
		define( 'SCM_DIR_LIBRARY',      		SCM_DIR . '_library/' );

		// PARTS
		define( 'SCM_DIR_PARTS',			    	'_parts/content' );
			define( 'SCM_DIR_PARTS_SINGLE',		    	'_parts/single/single' );
			define( 'SCM_DIR_PARTS_ARCHIVE',	    	'_parts/archive/archive' );


/*
*****************************************************
*      3.0 REQUIRES
*****************************************************
*/



require SCM_DIR_CLASSES . 'typekit-client.php';
require SCM_DIR_CLASSES . 'Get_Template_Part.php';
require SCM_DIR_CLASSES . 'Custom_Type.php';
require SCM_DIR_CLASSES . 'Custom_Taxonomy.php';
require SCM_DIR_CLASSES . 'class-tgm-plugin-activation.php';
require SCM_DIR_CLASSES . 'Backup_Restore_Options.php';

require SCM_DIR_LIBRARY . 'scm-svg.php';

require SCM_DIR_LIBRARY . 'scm-functions.php';

require SCM_DIR_LIBRARY . 'scm-acf-preset-fa.php';
require SCM_DIR_LIBRARY . 'scm-acf-preset.php';
require SCM_DIR_LIBRARY . 'scm-acf-layouts.php';
require SCM_DIR_LIBRARY . 'scm-acf-templates.php';
require SCM_DIR_LIBRARY . 'scm-acf-fields.php';
require SCM_DIR_LIBRARY . 'scm-acf.php';

require SCM_DIR_LIBRARY . 'scm-install.php';
require SCM_DIR_LIBRARY . 'scm-options.php';
require SCM_DIR_LIBRARY . 'scm-core.php';

require SCM_DIR_LIBRARY . 'scm-content-preset.php';
require SCM_DIR_LIBRARY . 'scm-content.php';
require SCM_DIR_LIBRARY . 'scm-front.php';

require SCM_DIR_LIBRARY . 'scm-admin.php';



// *****************************************************
// *      4.0 FUNCTIONS
// *****************************************************

    if ( ! function_exists( 'scm_save_posts' ) ) {
        function scm_save_posts(){
            //alert( 'Updating Posts');
            
            $my_types = get_post_types();
            $my_posts = get_posts( array( 'post_type' => $my_types, 'posts_per_page' => -1) );

            foreach ( $my_posts as $my_post ){
                wp_update_post( $my_post );
            }
            //alert( sizeof($my_posts) . ' Posts Updated' );
        }
    }