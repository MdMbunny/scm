<?php

// *****************************************************
// *      ACTIONS AND FILTERS
// *****************************************************

    add_action( 'tgmpa_register', 'scm_plugins_install' );

	add_action( 'after_setup_theme', 'scm_install' );
    add_action( 'after_setup_theme', 'scm_types_install' );
	add_action( 'after_setup_theme', 'scm_option_pages_install' );

    add_action( 'upgrader_process_complete', 'scm_save_posts_onupdate', 10, 2 );


// *****************************************************
// *      SAVE ALL POSTS
// *****************************************************

    if ( ! function_exists( 'scm_save_posts' ) ) {
        function scm_save_posts(){

            alert( 'Updating Posts');
            
            $my_types = get_post_types();
            $my_posts = get_posts( array( 'post_type' => $my_types, 'posts_per_page' => -1) );

            foreach ( $my_posts as $my_post ){
                wp_update_post( $my_post );
            }
            alert( sizeof($my_posts) . ' Posts Updated' );

        }
        //scm_save_posts();
    }

// *****************************************************
// *      THEME INSTALLATION
// *****************************************************

	if ( ! function_exists( 'scm_install' ) ) {
		function scm_install() {
            
            $themeStatus = get_option( 'scm-settings-installed' );

			if ( ! $themeStatus ) {
                alert('SCM theme installed');
				update_option( 'scm-settings-installed', 1 );
				header( 'Location: themes.php?page=' . SCM_SETTINGS_MAIN );		// Redirect alla pagina SCM Options
				die;
			}
		}
	}

// *****************************************************
// *      THEME UPDATE - SAVE ALL POSTS
// *****************************************************

    if ( ! function_exists( 'scm_save_posts_onupdate' ) ) {
        function scm_save_posts_onupdate($upgrader_object, $options){

            if ( !empty($upgrader_object->result['destination_name']) ){
                scm_save_posts();
            }else{
                return false;
            }
        }  

    }

// *****************************************************
// *      CUSTOM TYPES INSTALLATION
// *****************************************************

    if ( ! function_exists( 'scm_types_install' ) ) {
        function scm_types_install(){
            global $SCM_types;

            $SCM_types = array(
                'objects' => array(),
                'private' => array(),
                'public' => array(
                    'post'                  => 'Articoli',
                ),
                'all' => array(
                    'post'                  => 'Articoli',
                    'wpcf7_contact_form'    => 'Contact Form',
                ),
                'complete' => array(
                    'page'                  => 'Pagine',
                    'post'                  => 'Articoli',
                    'wpcf7_contact_form'    => 'Contact Form',
                ),
            );
			
            $saved_types = scm_field( 'types_list', array(), 'option' );
            //alert();
            
			$default_types = array(
				'sections'				=> array( 'public' => 0,   'active' => 1,		 'singular' => __('Section', SCM_THEME), 				'plural' => __('Sections', SCM_THEME), 				'slug' => 'scm-sections', 			'categories' => 1, 	'tags' => 0, 	'icon' => 'f489',      'orderby' => 'title',       'order' => '' ),
				'slides'                => array( 'public' => 0,   'active' => 1,        'singular' => __('Slide', SCM_THEME),                  'plural' => __('Slides', SCM_THEME),                'slug' => 'scm-slides',             'categories' => 1,  'tags' => 1,    'icon' => 'f128',      'orderby' => 'date',        'order' => '',        'categories_plural' => 'Sliders',                   'categories_singular' => 'Slider' ),
                'soggetti'				=> array( 'public' => 1,   'active' => 1,		 'singular' => __('Soggetto', SCM_THEME), 				'plural' => __('Soggetti', SCM_THEME), 				'slug' => 'scm-soggetti', 			'categories' => 1, 	'tags' => 0, 	'icon' => 'f338',      'orderby' => 'title',       'order' => '' ),
				'luoghi'				=> array( 'public' => 1,   'active' => 1,		 'singular' => __('Luogo', SCM_THEME), 					'plural' => __('Luoghi', SCM_THEME), 				'slug' => 'scm-luoghi', 			'categories' => 1, 	'tags' => 0, 	'icon' => 'f230',      'orderby' => 'title',       'order' => '' ),
				'news'					=> array( 'public' => 1,   'active' => 0,		 'singular' => __('News', SCM_THEME), 					'plural' => __('News', SCM_THEME), 					'slug' => 'scm-news', 				'categories' => 1, 	'tags' => 0, 	'icon' => 'f488',      'orderby' => 'date',        'order' => '' ),
				'documenti'				=> array( 'public' => 1,   'active' => 0,		 'singular' => __('Documento', SCM_THEME), 				'plural' => __('Documenti', SCM_THEME), 			'slug' => 'scm-documenti', 			'categories' => 1, 	'tags' => 0, 	'icon' => 'f109',      'orderby' => 'title',       'order' => '' ),
				'gallerie'				=> array( 'public' => 1,   'active' => 0,		 'singular' => __('Galleria', SCM_THEME), 				'plural' => __('Gallerie', SCM_THEME), 				'slug' => 'scm-gallerie', 			'categories' => 1, 	'tags' => 0, 	'icon' => 'f161',      'orderby' => 'title',       'order' => '' ),
				'video'					=> array( 'public' => 1,   'active' => 0,		 'singular' => __('Video', SCM_THEME), 					'plural' => __('Video', SCM_THEME), 				'slug' => 'scm-video', 				'categories' => 0, 	'tags' => 0, 	'icon' => 'f236',      'orderby' => 'title',       'order' => '' ),
				'rassegne-stampa'		=> array( 'public' => 1,   'active' => 0,		 'singular' => __('Rassegna Stampa', SCM_THEME),		'plural' => __('Rassegne Stampa', SCM_THEME), 		'slug' => 'scm-rassegne-stampa', 	'categories' => 0,	'tags' => 0, 	'icon' => 'f336',      'orderby' => 'date',        'order' => '',        'singular_short' => __('Rassegna', SCM_THEME),     'plural_short' => __('Rassegne', SCM_THEME), 	),
			);


            foreach ($default_types as $default => $value) {
                $elem = getByValueKey( $saved_types, $value['slug'], 'slug' );
                if( isset($elem) ){
                    if( $default == 'sections' ){
                        $saved_types[$elem]['active'] = 1;
                    }
                }else{
                    $saved_types[] = $value;
                }
            }

            update_field( 'types_list', $saved_types, 'option' );

            $types = scm_field( 'types_list', array(), 'option' );

            foreach ( $types as $type ) {

                $active = $type['active'];
                $public = $type['public'];
                $slug = $type['slug'];
                if( !$slug )
                    $slug = SCM_PREFIX . sanitize_title($type['plural']);
                if( substr($slug, 0, 4) != SCM_PREFIX )
                    $slug = SCM_PREFIX . $slug;

                $type['icon'] = '\\' . $type['icon'];

                if( $active ){
                    if( $public ){
                        $SCM_types['public'][$slug] = $type['plural'];
                        $SCM_types['all'][$slug] = $type['plural'];
                    }else{
                        $SCM_types['private'][$slug] = $type['plural'];
                    }
                    $SCM_types['complete'][$slug] = $type['plural'];
                    $SCM_types['objects'][$slug] = new Custom_Type( $type );
                }
            }
        }
    }

// *****************************************************
// *      OPTIONS PAGES INSTALLATION
// *****************************************************

    if ( ! function_exists( 'scm_option_pages_install' ) ) {
        function scm_option_pages_install(){

            global $SCM_types, $SCM_custom_fields;

            if( function_exists('acf_add_options_page') ) {

                acf_add_options_page(array(
                    'page_title'    => 'SCM Settings',
                    'menu_title'    => 'SCM',
                    'menu_slug'     => SCM_SETTINGS_MAIN,
                    'position'      => '0.1',
                    'capability'    => 'administrator',
                    'redirect'      => false,
                ));

                acf_add_options_page(array(
                    'page_title'    => 'SCM Types',
                    'menu_title'    => 'Types',
                    'menu_slug'     => SCM_SETTINGS_TYPES,
                    'position'      => '0.2',
                    'capability'    => 'administrator',
                    'redirect'      => false
                ));         
            }

            if( function_exists('acf_add_options_sub_page') ) {

                acf_add_options_sub_page(array(
                    'page_title'    => 'SCM Site Settings',
                    'menu_title'    => 'Layout',
                    'parent_slug'   => SCM_SETTINGS_MAIN,
                ));

                acf_add_options_sub_page(array(
                    'page_title'    => 'SCM Site Settings',
                    'menu_title'    => 'Stili',
                    'parent_slug'   => SCM_SETTINGS_MAIN,
                ));

                acf_add_options_sub_page(array(
                    'page_title'    => 'SCM Header Settings',
                    'menu_title'    => 'Header',
                    'parent_slug'   => SCM_SETTINGS_MAIN,
                ));

                acf_add_options_sub_page(array(
                    'page_title'    => 'SCM Footer Settings',
                    'menu_title'    => 'Footer',
                    'parent_slug'   => SCM_SETTINGS_MAIN,
                ));

                /*if( isset( $SCM_custom_fields['header'] ) ){

                    foreach ($SCM_types['public'] as $slug => $title) {

                        acf_add_options_sub_page(array(
                            'page_title'    => 'Template ' . $title,
                            'menu_title'    => 'Template',
                            'menu_slug'     => 'acf-options-template-' . $slug,
                            'parent_slug'   => 'edit.php' . ( $slug == 'post' ? '' : '?post_type=' . $slug ),
                        ));



                        scm_acf_fields_group_duplicate( $SCM_custom_fields['header'], $title, $slug, array( array( array ( 'param' => 'options_page', 'operator' => '==', 'value' => 'acf-options-template-' . $slug ) ) ) );
                    }
                }*/
            }
        }
    }

// *****************************************************
// *      DUPLICATE FIELDS GROUP
// *****************************************************

    /*if ( ! function_exists( 'scm_acf_fields_group_duplicate' ) ) {
        function scm_acf_fields_group_duplicate( $group, $title, $slug, $location = array( array( array( 'param' => 'post_type', 'operator' => '==', 'value' => 'post' ) ) ) ) {

            $group['title'] .= ' ' . $title;
            $group['key'] .= '_' . $slug;
            $group['location'] = $location;

            for ($i = 0; $i < sizeof($group['fields']); $i++) {
                $group['fields'][$i]['key'] .= '_' . $slug;
                $group['fields'][$i]['name'] .= '_' . $slug;
            }

            if( function_exists('register_field_group') )
                register_field_group( $group );
        }
    }*/

// *****************************************************
// *      PLUGIN INSTALLATION
// *****************************************************

    if ( ! function_exists( 'scm_plugins_install' ) ) {
        function scm_plugins_install() {

            $plugins = array(

                array(
                    'name'               => 'ACF Hidden Field', // The plugin name.
                    'slug'               => 'acf-hidden-master', // The plugin slug (typically the folder name).
                    'source'             => 'acf-hidden-master.zip', // The plugin source.
                    'required'           => true, // If false, the plugin is only 'recommended' instead of required.
                    'force_activation'   => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
                    'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
                ),

                array(
                    'name'               => 'ACF CF7', // The plugin name.
                    'slug'               => 'acf-cf7-master', // The plugin slug (typically the folder name).
                    'source'             => 'acf-cf7-master.zip', // The plugin source.
                    'required'           => true, // If false, the plugin is only 'recommended' instead of required.
                    'force_activation'   => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
                    'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
                ),

                array(
                    'name'               => 'ACF PayPal', // The plugin name.
                    'slug'               => 'acf-paypal-field-master', // The plugin slug (typically the folder name).
                    'source'             => 'acf-paypal-field-master.zip', // The plugin source.
                    'required'           => true, // If false, the plugin is only 'recommended' instead of required.
                    'force_activation'   => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
                    'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
                ),

                array(
                    'name'               => 'ACF Font Awesome', // The plugin name.
                    'slug'               => 'advanced-custom-fields-font-awesome', // The plugin slug (typically the folder name).
                    'source'             => 'advanced-custom-fields-font-awesome.zip', // The plugin source.
                    'required'           => true, // If false, the plugin is only 'recommended' instead of required.
                    'force_activation'   => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
                    'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
                ),

                array(
                    'name'               => 'ACF Limiter', // The plugin name.
                    'slug'               => 'advanced-custom-fields-limiter-field', // The plugin slug (typically the folder name).
                    'source'             => 'advanced-custom-fields-limiter-field.zip', // The plugin source.
                    'required'           => true, // If false, the plugin is only 'recommended' instead of required.
                    'force_activation'   => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
                    'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
                ),

                array(
                    'name'               => 'Contact Form 7', // The plugin name.
                    'slug'               => 'contact-form-7', // The plugin slug (typically the folder name).
                    'source'             => 'contact-form-7.zip', // The plugin source.
                    'required'           => true, // If false, the plugin is only 'recommended' instead of required.
                    'force_activation'   => true, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
                    'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
                ),

                array(
                    'name'               => 'Captcha 7', // The plugin name.
                    'slug'               => 'really-simple-captcha', // The plugin slug (typically the folder name).
                    'source'             => 'really-simple-captcha.zip', // The plugin source.
                    'required'           => false, // If false, the plugin is only 'recommended' instead of required.
                    'force_activation'   => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
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
                    'force_activation'   => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
                    'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
                ),

                array(
                    'name'               => 'Social Media Feather', // The plugin name.
                    'slug'               => 'social-media-feather', // The plugin slug (typically the folder name).
                    'source'             => 'social-media-feather.zip', // The plugin source.
                    'required'           => false, // If false, the plugin is only 'recommended' instead of required.
                    'force_activation'   => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
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
                    'force_activation'   => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
                    'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
                ),

                array(
                    'name'               => 'Optimize Database', // The plugin name.
                    'slug'               => 'rvg-optimize-database', // The plugin slug (typically the folder name).
                    'source'             => 'rvg-optimize-database.zip', // The plugin source.
                    'required'           => false, // If false, the plugin is only 'recommended' instead of required.
                    'force_activation'   => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
                    'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
                ),
                
                array(
                    'name'               => 'Theme Check', // The plugin name.
                    'slug'               => 'theme-check', // The plugin slug (typically the folder name).
                    'source'             => 'theme-check.zip', // The plugin source.
                    'required'           => false, // If false, the plugin is only 'recommended' instead of required.
                    'force_activation'   => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
                    'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
                ),

                array(
                    'name'               => 'GitHub Updater', // The plugin name.
                    'slug'               => 'github-updater', // The plugin slug (typically the folder name).
                    'source'             => 'github-updater.zip', // The plugin source.
                    'required'           => false, // If false, the plugin is only 'recommended' instead of required.
                    'force_activation'   => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
                    'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
                ),

                array(
                    'name'               => 'Thumbs Regenerator', // The plugin name.
                    'slug'               => 'regenerate-thumbnails', // The plugin slug (typically the folder name).
                    'source'             => 'regenerate-thumbnails.zip', // The plugin source.
                    'required'           => false, // If false, the plugin is only 'recommended' instead of required.
                    'force_activation'   => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
                    'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
                ),

                array(
                    'name'               => 'Browser Detection', // The plugin name.
                    'slug'               => 'php-browser-detection', // The plugin slug (typically the folder name).
                    'source'             => 'php-browser-detection.zip', // The plugin source.
                    'required'           => true, // If false, the plugin is only 'recommended' instead of required.
                    'force_activation'   => true, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
                    'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
                ),

                array(
                    'name'               => 'WP Security', // The plugin name.
                    'slug'               => 'better-wp-security', // The plugin slug (typically the folder name).
                    'source'             => 'better-wp-security.zip', // The plugin source.
                    'required'           => false, // If false, the plugin is only 'recommended' instead of required.
                    'force_activation'   => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
                    'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
                ),

            );

            $config = array(
                'default_path' => SCM_DIR_PLUGINS,         // Default absolute path to pre-packaged plugins.
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