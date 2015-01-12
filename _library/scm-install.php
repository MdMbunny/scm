<?php

// *****************************************************
// *      ACTIONS AND FILTERS
// *****************************************************

	add_action( 'after_setup_theme', 'scm_plugins_install' );
    add_action( 'tgmpa_register', 'scm_reccomended_plugins_install' );

	add_action( 'after_setup_theme', 'scm_install' );
	add_action( 'init', 'scm_types_install' );
	add_action( 'admin_init', 'scm_option_pages_install' );

// *****************************************************
// *      THEME INSTALLATION
// *****************************************************

	if ( ! function_exists( 'scm_install' ) ) {
		function scm_install() {

			$themeStatus = get_option( 'scm-settings-installed' );

			if ( ! $themeStatus ) {

				update_option( 'scm-settings-installed', 1 );
				header( 'Location: themes.php?page=' . SCM_SETTINGS_MAIN );		// Redirect alla pagina del Tema
				die;
			}
		}
	}

// *****************************************************
// *      OPTIONS PAGES INSTALLATION
// *****************************************************

	if ( ! function_exists( 'scm_option_pages_install' ) ) {
	    function scm_option_pages_install(){

			if( function_exists('acf_add_options_page') ) {

				acf_add_options_page(array(
					'page_title' 	=> 'SCM Settings',
					'menu_title'	=> 'SCM',
					'menu_slug' 	=> SCM_SETTINGS_MAIN,
					'position'		=> '0.1',
					'capability'	=> 'administrator',
					'redirect'		=> false
				));

				acf_add_options_page(array(
					'page_title' 	=> 'SCM Types',
					'menu_title'	=> 'Types',
					'menu_slug' 	=> SCM_SETTINGS_TYPES,
					'position'		=> '0.2',
					'capability'	=> 'administrator',
					'redirect'		=> false
				));			
			}

			if( function_exists('acf_add_options_page') ) {

				acf_add_options_sub_page(array(
					'page_title' 	=> 'SCM Site Settings',
					'menu_title'	=> 'Layout',
					'parent_slug'	=> SCM_SETTINGS_MAIN,
				));

				acf_add_options_sub_page(array(
					'page_title' 	=> 'SCM Site Settings',
					'menu_title'	=> 'Stili',
					'parent_slug'	=> SCM_SETTINGS_MAIN,
				));

				acf_add_options_sub_page(array(
					'page_title' 	=> 'SCM Header Settings',
					'menu_title'	=> 'Header',
					'parent_slug'	=> SCM_SETTINGS_MAIN,
				));

				acf_add_options_sub_page(array(
					'page_title' 	=> 'SCM Footer Settings',
					'menu_title'	=> 'Footer',
					'parent_slug'	=> SCM_SETTINGS_MAIN,
				));

			}
		}
	}

// *****************************************************
// *      CUSTOM TYPES INSTALLATION
// *****************************************************

    if ( ! function_exists( 'scm_types_install' ) ) {
        function scm_types_install(){
            global $SCM_types, $SCM_types_slug;

            $SCM_types = [];
            $SCM_types_slug = [];
			
			$saved_types = ( get_field('types_list', 'option') ? get_field('types_list', 'option') : array() );
            
			$default_types = array(
				'sections'				=> array( 'active' => 1,		 'singular' => __('Section', SCM_THEME), 				'plural' => __('Sections', SCM_THEME), 				'slug' => 'scm-sections', 				'categories' => true, 	'tags' => false, 	'icon' => 'f116', 	'post' => true, 	'pagination' => -1, 	'archive' => -1, 	'folder' => false 	),
				'modules'				=> array( 'active' => 1,		 'singular' => __('Module', SCM_THEME), 				'plural' => __('Modules', SCM_THEME), 				'slug' => 'scm-modules', 				'categories' => true, 	'tags' => true, 	'icon' => 'f119', 	'post' => true, 	'pagination' => -1, 	'archive' => -1, 	'folder' => false 	),
				'soggetti'				=> array( 'active' => 1,		 'singular' => __('Soggetto', SCM_THEME), 				'plural' => __('Soggetti', SCM_THEME), 				'slug' => 'scm-soggetti', 				'categories' => true, 	'tags' => false, 	'icon' => 'f338', 	'post' => true, 	'pagination' => -1, 	'archive' => -1, 	'folder' => false 	),
				'luoghi'				=> array( 'active' => 1,		 'singular' => __('Luogo', SCM_THEME), 					'plural' => __('Luoghi', SCM_THEME), 				'slug' => 'scm-luoghi', 				'categories' => true, 	'tags' => false, 	'icon' => 'f230', 	'post' => true, 	'pagination' => -1, 	'archive' => -1, 	'folder' => false 	),
				'news'					=> array( 'active' => 0,		 'singular' => __('News', SCM_THEME), 					'plural' => __('News', SCM_THEME), 					'slug' => 'scm-news', 					'categories' => true, 	'tags' => false, 	'icon' => 'f488', 	'post' => true, 	'pagination' => -1, 	'archive' => -1, 	'folder' => true 	),
				'documenti'				=> array( 'active' => 0,		 'singular' => __('Documento', SCM_THEME), 				'plural' => __('Documenti', SCM_THEME), 			'slug' => 'scm-documenti', 				'categories' => true, 	'tags' => false, 	'icon' => 'f109', 	'post' => true, 	'pagination' => -1, 	'archive' => -1, 	'folder' => false 	),
				'gallerie'				=> array( 'active' => 1,		 'singular' => __('Galleria', SCM_THEME), 				'plural' => __('Gallerie', SCM_THEME), 				'slug' => 'scm-gallerie', 				'categories' => true, 	'tags' => false, 	'icon' => 'f161', 	'post' => true, 	'pagination' => -1, 	'archive' => -1, 	'folder' => true 	),
				'video'					=> array( 'active' => 0,		 'singular' => __('Video', SCM_THEME), 					'plural' => __('Video', SCM_THEME), 				'slug' => 'scm-video', 					'categories' => false, 	'tags' => false, 	'icon' => 'f236', 	'post' => true, 	'pagination' => -1, 	'archive' => -1, 	'folder' => false 	),
				'rassegne-stampa'		=> array( 'active' => 0,		 'singular' => __('Rassegna Stampa', SCM_THEME),		'plural' => __('Rassegne Stampa', SCM_THEME), 		'slug' => 'scm-rassegne-stampa', 		'categories' => false,	'tags' => false, 	'icon' => 'f336', 	'post' => true, 	'pagination' => -1, 	'archive' => -1, 	'folder' => false 	),
			);

            $types = array_merge( $default_types, $saved_types);
           
            foreach ( $types as $type ) {

                $active = $type['active'];
                $slug = $type['slug'];
                if(!$slug)
                    $slug = 'scm-' . sanitize_title($type['plural']);
                $type['icon'] = '\\' . $type['icon'];

                if( $active ){
                    $SCM_types_slug[$slug] = $type['plural'];
                    $SCM_types[$slug] = new Custom_Type( $type );
                }
            }
        }
    }

// *****************************************************
// *      PLUGIN INSTALLATION
// *****************************************************

    if ( ! function_exists( 'scm_plugins_install' ) ) {
        function scm_plugins_install() {

            if (!function_exists('include_field_types_cf7'))
                include_once( SCM_DIR_PLUGINS . 'default/acf-cf7-master/acf-cf7.php' );

            if (!class_exists('acf_field_paypal_item_plugin'))
                include_once( SCM_DIR_PLUGINS . 'default/acf-paypal-field-master/acf-paypal.php' );

            if (!function_exists('include_field_types_font_awesome'))
                include_once( SCM_DIR_PLUGINS . 'default/advanced-custom-fields-font-awesome/acf-font-awesome.php' );

            if (!function_exists('include_field_types_limiter'))
                include_once( SCM_DIR_PLUGINS . 'default/advanced-custom-fields-limiter-field/acf-limiter.php' );
        }
    }

    if ( ! function_exists( 'scm_reccomended_plugins_install' ) ) {
        function scm_reccomended_plugins_install() {

            $plugins = array(

                array(
                    'name'               => 'Contact Form 7', // The plugin name.
                    'slug'               => 'contact-form-7', // The plugin slug (typically the folder name).
                    'source'             => 'contact-form-7.zip', // The plugin source.
                    'required'           => false, // If false, the plugin is only 'recommended' instead of required.
                    'force_activation'   => true, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
                    'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
                ),

                array(
                    'name'               => 'Captcha 7', // The plugin name.
                    'slug'               => 'really-simple-captcha', // The plugin slug (typically the folder name).
                    'source'             => 'really-simple-captcha.zip', // The plugin source.
                    'required'           => false, // If false, the plugin is only 'recommended' instead of required.
                    'force_activation'   => true, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
                    'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
                ),

                array(
                    'name'               => 'Polylang', // The plugin name.
                    'slug'               => 'polylang', // The plugin slug (typically the folder name).
                    'source'             => 'polylang.zip', // The plugin source.
                    'required'           => false, // If false, the plugin is only 'recommended' instead of required.
                    'force_activation'   => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
                    'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
                ),

                array(
                    'name'               => 'Post Duplicator', // The plugin name.
                    'slug'               => 'post-duplicator', // The plugin slug (typically the folder name).
                    'source'             => 'post-duplicator.zip', // The plugin source.
                    'required'           => false, // If false, the plugin is only 'recommended' instead of required.
                    'force_activation'   => true, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
                    'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
                ),

                array(
                    'name'               => 'Social Media Feather', // The plugin name.
                    'slug'               => 'social-media-feather', // The plugin slug (typically the folder name).
                    'source'             => 'social-media-feather.zip', // The plugin source.
                    'required'           => false, // If false, the plugin is only 'recommended' instead of required.
                    'force_activation'   => true, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
                    'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
                ),

                array(
                    'name'               => 'Social Login Widget', // The plugin name.
                    'slug'               => 'fb-login-widget-pro', // The plugin slug (typically the folder name).
                    'source'             => 'fb-login-widget-pro.zip', // The plugin source.
                    'required'           => false, // If false, the plugin is only 'recommended' instead of required.
                    'force_activation'   => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
                    'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
                ),

                array(
                    'name'               => 'Admin Menu Editor', // The plugin name.
                    'slug'               => 'admin-menu-editor', // The plugin slug (typically the folder name).
                    'source'             => 'admin-menu-editor.zip', // The plugin source.
                    'required'           => false, // If false, the plugin is only 'recommended' instead of required.
                    'force_activation'   => true, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
                    'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
                ),

                array(
                    'name'               => 'Optimize Database', // The plugin name.
                    'slug'               => 'rvg-optimize-database', // The plugin slug (typically the folder name).
                    'source'             => 'rvg-optimize-database.zip', // The plugin source.
                    'required'           => false, // If false, the plugin is only 'recommended' instead of required.
                    'force_activation'   => true, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
                    'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
                ),
                
                array(
                    'name'               => 'Theme Check', // The plugin name.
                    'slug'               => 'theme-check', // The plugin slug (typically the folder name).
                    'source'             => 'theme-check.zip', // The plugin source.
                    'required'           => false, // If false, the plugin is only 'recommended' instead of required.
                    'force_activation'   => true, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
                    'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
                ),

                array(
                    'name'               => 'GitHub Updater', // The plugin name.
                    'slug'               => 'github-updater-develop', // The plugin slug (typically the folder name).
                    'source'             => 'github-updater-develop.zip', // The plugin source.
                    'required'           => true, // If false, the plugin is only 'recommended' instead of required.
                    'force_activation'   => true, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
                    'force_deactivation' => true, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
                ),

            );

            $config = array(
                'default_path' => SCM_DIR_PLUGINS . 'reccomended/',         // Default absolute path to pre-packaged plugins.
                'menu'         => 'scm-install-plugins',   // Menu slug.
                'has_notices'  => true,                    // Show admin notices or not.
                'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
                'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
                'is_automatic' => true,                    // Automatically activate plugins after installation or not.
                'message'      => '',                      // Message to output right before the plugins table.
                'strings'      => array(
                    'page_title'                      => __( 'Install Required Plugins', SCM_THEME ),
                    'menu_title'                      => __( 'Install Plugins', SCM_THEME ),
                    'installing'                      => __( 'Installing Plugin: %s', SCM_THEME ), // %s = plugin name.
                    'oops'                            => __( 'Something went wrong with the plugin API.', SCM_THEME ),
                    'notice_can_install_required'     => _n_noop( 'This theme requires the following plugin: %1$s.', 'This theme requires the following plugins: %1$s.' ), // %1$s = plugin name(s).
                    'notice_can_install_recommended'  => _n_noop( 'This theme recommends the following plugin: %1$s.', 'This theme recommends the following plugins: %1$s.' ), // %1$s = plugin name(s).
                    'notice_cannot_install'           => _n_noop( 'Sorry, but you do not have the correct permissions to install the %s plugin. Contact the administrator of this site for help on getting the plugin installed.', 'Sorry, but you do not have the correct permissions to install the %s plugins. Contact the administrator of this site for help on getting the plugins installed.' ), // %1$s = plugin name(s).
                    'notice_can_activate_required'    => _n_noop( 'The following required plugin is currently inactive: %1$s.', 'The following required plugins are currently inactive: %1$s.' ), // %1$s = plugin name(s).
                    'notice_can_activate_recommended' => _n_noop( 'The following recommended plugin is currently inactive: %1$s.', 'The following recommended plugins are currently inactive: %1$s.' ), // %1$s = plugin name(s).
                    'notice_cannot_activate'          => _n_noop( 'Sorry, but you do not have the correct permissions to activate the %s plugin. Contact the administrator of this site for help on getting the plugin activated.', 'Sorry, but you do not have the correct permissions to activate the %s plugins. Contact the administrator of this site for help on getting the plugins activated.' ), // %1$s = plugin name(s).
                    'notice_ask_to_update'            => _n_noop( 'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.', 'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.' ), // %1$s = plugin name(s).
                    'notice_cannot_update'            => _n_noop( 'Sorry, but you do not have the correct permissions to update the %s plugin. Contact the administrator of this site for help on getting the plugin updated.', 'Sorry, but you do not have the correct permissions to update the %s plugins. Contact the administrator of this site for help on getting the plugins updated.' ), // %1$s = plugin name(s).
                    'install_link'                    => _n_noop( 'Begin installing plugin', 'Begin installing plugins' ),
                    'activate_link'                   => _n_noop( 'Begin activating plugin', 'Begin activating plugins' ),
                    'return'                          => __( 'Return to Required Plugins Installer', SCM_THEME ),
                    'plugin_activated'                => __( 'Plugin activated successfully.', SCM_THEME ),
                    'complete'                        => __( 'All plugins installed and activated successfully. %s', SCM_THEME ), // %s = dashboard link.
                    'nag_type'                        => 'updated' // Determines admin notice type - can only be 'updated', 'update-nag' or 'error'.
                )
            );

            tgmpa( $plugins, $config );

        }
    }


?>