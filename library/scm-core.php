<?php



// *****************************************************
// *      REQUIRED FILES
// *****************************************************


//Slider generator functions
	//require_once( SCM_SLIDERS . 'flex.php' );
	//require_once( SCM_SLIDERS . 'nivo.php' );
	//require_once( SCM_SLIDERS . 'roundabout.php' );



// *****************************************************
// *      ACTIONS AND FILTERS
// *****************************************************

	//ACTIONS
		add_action( 'init', 'scm_register_assets' );
		add_action( 'widgets_init', 'scm_widgets_default' );



// *****************************************************
// *      REGISTER STYLES AND SCRIPTS
// *****************************************************


if ( ! function_exists( 'scm_register_assets' ) ) {
	function scm_register_assets() {
		$protocol = ( is_ssl() ? 'https' : 'http' );

//STYLES

		wp_register_style( 'animate', SCM_REL_CSS . 'animate.css', false, SCM_SCRIPTS_VERSION, 'screen' );

		wp_register_style( 'global', SCM_REL_THEME . 'style.css', false, SCM_SCRIPTS_VERSION, 'screen' );
		wp_register_style( 'style', SCM_REL_CSS . 'main.css', false, SCM_SCRIPTS_VERSION, 'screen' );
		
		wp_register_style( 'child', SCM_REL_CHILD . 'style.css', false, SCM_SCRIPTS_VERSION, 'screen' );
		wp_register_style( 'print', SCM_REL_CSS . 'print.css', false, SCM_SCRIPTS_VERSION, 'screen' );

		if(is_admin()){
			wp_register_style( 'admin', SCM_REL_CSS . 'admin.css', false, SCM_SCRIPTS_VERSION, 'screen' );
			wp_register_style( 'options', SCM_REL_CSS . 'options.css', false, SCM_SCRIPTS_VERSION, 'screen' );
		}

	//for jquery plugins
		wp_register_style( 'fancybox', SCM_REL_JS . 'fancybox/source/jquery.fancybox.css', false, SCM_SCRIPTS_VERSION, 'screen' );
		wp_register_style( 'fancybox-thumbs', SCM_REL_JS . 'fancybox/source/helpers/jquery.fancybox-thumbs.css', false, SCM_SCRIPTS_VERSION, 'screen' );
		wp_register_style( 'color-picker', SCM_REL_CSS . 'colorpicker.css', false, SCM_SCRIPTS_VERSION, 'screen' );

	//sliders
		wp_register_style( 'flex', SCM_REL_CSS . 'flex/flex.css', false, SCM_SCRIPTS_VERSION, 'all' );
		wp_register_style( 'nivo', SCM_REL_CSS . 'nivo/nivo.css', false, SCM_SCRIPTS_VERSION, 'all' );
		wp_register_style( 'roundabout', SCM_REL_CSS . 'roundabout/roundabout.css', false, SCM_SCRIPTS_VERSION, 'all' );

	//fonts
		wp_register_style('fontawesome', SCM_REL_FONT . 'font-awesome/css/font-awesome.min.css', false, SCM_SCRIPTS_VERSION, 'screen' );

//SCRIPTS
	//backend
		wp_register_script( 'scm-functions', SCM_REL_JS . 'scm-functions.js', array( 'jquery' ), SCM_SCRIPTS_VERSION, true );
		/*wp_register_script( 'navigation', SCM_REL_JS . 'navigation.js', array( 'jquery' ), SCM_SCRIPTS_VERSION, true );*/
		wp_register_script( 'skip-link-focus-fix', SCM_REL_JS . 'skip-link-focus-fix.js', array( 'jquery' ), SCM_SCRIPTS_VERSION, true );
		wp_register_script( 'single-page-nav', SCM_REL_JS . 'jquery.singlePageNav.min.js', array( 'jquery' ), SCM_SCRIPTS_VERSION, true );
		wp_register_script( 'easing', SCM_REL_JS . 'jquery.easing/jquery.easing-1.3.pack.js', array( 'jquery' ), SCM_SCRIPTS_VERSION, true );
		wp_register_script( 'drag', SCM_REL_JS . 'jquery.dragdrop/jquery.event.drag.min.js', array( 'jquery' ), SCM_SCRIPTS_VERSION, true );
		wp_register_script( 'drop', SCM_REL_JS . 'jquery.dragdrop/jquery.event.drop.min.js', array( 'jquery' ), SCM_SCRIPTS_VERSION, true );
		wp_register_script( 'fancybox', SCM_REL_JS . 'fancybox/source/jquery.fancybox.js', array( 'jquery' ), SCM_SCRIPTS_VERSION, true );
		wp_register_script( 'fancybox-thumbs', SCM_REL_JS . 'fancybox/source/helpers/jquery.fancybox-thumbs.js', array( 'jquery' ), SCM_SCRIPTS_VERSION, true );
		wp_register_script( 'color-picker', SCM_REL_JS . 'colorpicker.js', array( 'jquery' ), SCM_SCRIPTS_VERSION, true);
		wp_register_script( 'jquery-cookies', SCM_REL_JS . 'jquery.cookies.js', array( 'jquery' ), SCM_SCRIPTS_VERSION, true );

	//sliders
		wp_register_script( 'flex', SCM_REL_JS . 'flex/jquery.flexslider-min.js', array( 'jquery' ), SCM_SCRIPTS_VERSION, true );
		wp_register_script( 'apply-flex', SCM_REL_JS . 'flex/apply-flex.js.php', array( 'jquery', 'flex' ), SCM_SCRIPTS_VERSION, true );
		wp_register_script( 'nivo', SCM_REL_JS . 'nivo/jquery.nivo.slider.pack.js', array( 'jquery' ), SCM_SCRIPTS_VERSION, true );
		wp_register_script( 'apply-nivo', SCM_REL_JS . 'nivo/apply-nivo.js.php', array( 'jquery', 'nivo' ), SCM_SCRIPTS_VERSION, true );
		wp_register_script( 'roundabout', SCM_REL_JS . 'roundabout/jquery.roundabout.min.js', array( 'jquery' ), SCM_SCRIPTS_VERSION, true );
		wp_register_script( 'roundabout-shapes', SCM_REL_JS . 'roundabout/jquery.roundabout-shapes.min.js', array( 'jquery', 'roundabout' ), SCM_SCRIPTS_VERSION, true );
		wp_register_script( 'apply-roundabout', SCM_REL_JS . 'roundabout/apply-roundabout.js.php', array( 'jquery', 'roundabout' ), SCM_SCRIPTS_VERSION, true );

	//frontend
		wp_register_script( 'bootstrap', SCM_REL_JS . 'bootstrap-3.1.1.min.js', array( 'jquery' ), SCM_SCRIPTS_VERSION, true );
		wp_register_script( 'imagesloaded', SCM_REL_JS . 'imagesloaded/jquery.imagesloaded.min.js', array( 'jquery' ), SCM_SCRIPTS_VERSION, true );
		wp_register_script( 'lwtCountdown', SCM_REL_JS . 'lwtCountdown/jquery.lwtCountdown-1.0.js', array( 'jquery' ), SCM_SCRIPTS_VERSION, true );
		wp_register_script( 'gmapapi', 'https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false', false, '', true );
		
	}
}



// *****************************************************
// *      WIDGETS
// *****************************************************

if ( ! function_exists( 'scm_widgets_default' ) ) {
	function scm_widgets_default() {
		register_sidebar( array(
			'name'          => __( 'Barra Laterale', SCM_THEME ),
			'id'            => 'sidebar-1',
			'description'   => '',
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget'  => '</aside>',
			'before_title'  => '<h1 class="widget-title">',
			'after_title'   => '</h1>',
		) );
	}
}



// *************************************************************************************************
// *************************************************************************************************
// *************************************************************************************************




// *****************************************************
// *      PAGINATION
// *****************************************************

	if ( ! function_exists( 'scm_pagination' ) ) {
		function scm_pagination( $query = null, $atts = array() ) {
			$atts = wp_parse_args( $atts, array(
					'label_previous' => __( 'Precedente', SCM_THEME ),
					'label_next'     => __( 'Prossima', SCM_THEME),
					'before_output'  => '<div class="pagination">',
					'after_output'   => '</div> <!-- /pagination -->',
					'print'          => true
				) );
			
			//$atts = apply_filters( 'wmhook_pagination_atts', $atts );

			//WP-PageNavi plugin support (http://wordpress.org/plugins/wp-pagenavi/)
			if ( function_exists( 'wp_pagenavi' ) ) {
				//Set up WP-PageNavi attributes
					$atts_pagenavi = array(
							'echo' => false,
						);
					if ( $query ) {
						$atts_pagenavi['query'] = $query;
					}
					//$atts_pagenavi = apply_filters( 'wmhook_wppagenavi_atts', $atts_pagenavi );

				//Output
					if ( $atts['print'] ) {
						echo $atts['before_output'] . wp_pagenavi( $atts_pagenavi ) . $atts['after_output'];
						return;
					} else {
						return $atts['before_output'] . wp_pagenavi( $atts_pagenavi ) . $atts['after_output'];
					}
			}

			global $wp_query, $wp_rewrite;

			//Override global WordPress query if custom used
				if ( $query ) {
					$wp_query = $query;
				}

			//WordPress pagination settings
				$pagination = array(
						'base'      => @add_query_arg( 'paged', '%#%' ),
						'format'    => '',
						'current'   => max( 1, get_query_var( 'paged' ) ),
						'total'     => $wp_query->max_num_pages,
						'prev_text' => $atts['label_previous'],
						'next_text' => $atts['label_next'],
					);

			//Nice URLs
				if ( $wp_rewrite->using_permalinks() ) {
					$pagination['base'] = user_trailingslashit( trailingslashit( remove_query_arg( 's', get_pagenum_link( 1 ) ) ) . 'page/%#%/', 'paged' );
				}

			//Search page
				if ( get_query_var( 's' ) ) {
					$pagination['add_args'] = array( 's' => urlencode( get_query_var( 's' ) ) );
				}

			//Output
				if ( 1 < $wp_query->max_num_pages ) {
					if ( $atts['print'] ) {
						echo $atts['before_output'] . paginate_links( $pagination ) . $atts['after_output'];
					} else {
						return $atts['before_output'] . paginate_links( $pagination ) . $atts['after_output'];
					}
				}
		}
	}

/*
*****************************************************
*      HEADER INCLUDE FONTS
*****************************************************
*/

	//Get Webfont + Family Font as a correct String
	if ( ! function_exists( 'scm_fontsToString' ) ) {
		function scm_fontsToString($webfont = '', $family = 'default', $att = false) {
			$webfont = ( ( $webfont && $webfont != 'no' ) ? $webfont . ', ' : '' );
			$family = ( $family != 'default' ? str_replace( '_', ', ', $family ) : 'Helvetica, Arial, san-serif' );
			if( $att ){
				$webfont = 'font-family:' . $webfont;
				$family .= ';';
			}
			return str_replace( '"', '\'', $webfont . $family );
		}
	}

	//Include Google Web Fonts
	if ( ! function_exists( 'scm_webfonts' ) ) {
		function scm_webfonts() {
			$fonts =  ( get_field('webfonts', 'option') ? get_field('webfonts', 'option') : array() );
			foreach ($fonts as $value) {				
				$family = str_replace( ' ', '+', $value['family'] );
				$styles = implode( ',', $value['select_webfonts_styles'] );
				echo '<link href="http://fonts.googleapis.com/css?family=' . $family . ':' . $styles . '" rel="stylesheet" type="text/css">';
			}
		}
	}

/*
*****************************************************
*      HEADER STYLES
*****************************************************
*/

	//Set Default family-font Styles
	if ( ! function_exists( 'scm_default_styles' ) ) {
		function scm_default_styles() {
			global $SCM_styles;

			$alpha = ( get_field('text_alpha', 'option') != null ? get_field('text_alpha', 'option') : 0 );
			$color = 'rgba(' . hex2rgba( ( get_field('text_color', 'option') ? get_field('text_color', 'option') : '#000000' ), $alpha ) . ')';
			$opacity = ( get_field('text_opacity', 'option') != null ? get_field('text_opacity', 'option') : 1);
			$shadow = ( get_field('text_shadow', 'option') ? get_field('text_shadow_x', 'option') . 'px ' . get_field('text_shadow_y', 'option') . 'px ' . get_field('text_shadow_size', 'option') . 'px rgba(' . hex2rgba( get_field('text_shadow_color', 'option'), get_field('text_shadow_alpha', 'option'), true ) . ')' : 'none' );
			
			$heading_color = ( get_field('styling_heading_color', 'option') ? get_field('styling_heading_color', 'option') : '#000000');
			$heading_font = ( get_field( 'select_webfonts_families_heading', 'option' ) != 'no' ? get_field( 'select_webfonts_families_heading', 'option' ) . ',' . str_replace( '_', ', ', get_field( 'select_webfonts_default_families_heading', 'option' ) ) : str_replace( '_', ', ', get_field( 'select_webfonts_default_families_heading', 'option' ) ) );
			$heading_weight = ( get_field('select_font_weight', 'option') ? get_field('select_font_weight', 'option') : '700');

			$font = scm_fontsToString( get_field( 'select_webfonts_families', 'option' ), get_field( 'select_webfonts_default_families', 'option' ) );
			$menu_font = scm_fontsToString( get_field( 'select_webfonts_families_menu', 'option' ), get_field( 'select_webfonts_default_families_menu', 'option' ) );
			$sticky_font = scm_fontsToString( get_field( 'select_webfonts_families_sticky_menu', 'option' ), get_field( 'select_webfonts_default_families_sticky_menu', 'option' ) );

			$bg_image = ( get_field('background_image', 'option') ? 'url(' . get_field('background_image', 'option') . ')' : 'none' );
			$bg_repeat = ( get_field('select_bg_repeat', 'option') != 'default' ? get_field('select_bg_repeat', 'option') : 'no-repeat' );
			$bg_position = ( get_field('select_bg_position', 'option') != 'default' ? get_field('select_bg_position', 'option') : 'center center' );
			$bg_size = ( get_field('background_size', 'option') != null ? get_field('background_size', 'option') : 'auto' );
			$bg_color = ( get_field('background_color', 'option') != null ? get_field('background_color', 'option') : '#FFFFFF');
			$margin = ( get_field('margin', 'option') ? get_field('margin', 'option') : '0');
			$padding = ( get_field('padding', 'option') ? get_field('padding', 'option') : '0');

			/*$fader = ( get_field('fader_active', 'option') ? get_field('fader_active', 'option') : 0 );*/
			/*$body_opacity = ( $fader ? 0 : 1 );
			$body_pointer = ( $fader ? 'none' : 'all' );
			$body_trans = ( $fader ? 'opacity ' . get_field('fader_duration', 'option') . 's' : 'none' );*/

			array_merge( $SCM_styles, array(
				'alpha' => $alpha,
				'color' => $color,
				'opacity' => $opacity,
				'shadow' => $shadow,
				'font' => $font,
				'heading_color' => $heading_color,
				'heading_font' => $heading_font,
				'heading_weight' => $heading_weight,
				'menu_font' => $menu_font,
				'bg_image' => $bg_image,
				'bg_repeat' => $bg_repeat,
				'bg_position' => $bg_position,
				'bg_size' => $bg_size,
				'bg_color' => $bg_color,
				'margin' => $margin,
				'padding' => $padding,
			));

			$output = '
			<style type="text/css" media="screen">

			    *, input, textarea{
			        font-family: ' . $font . ';
			        color: ' . $color . ';
			    }

			    body {
			    	background-color: ' . $bg_color . ';
			    	background-image: ' . $bg_image . ';
			    	background-repeat: ' . $bg_repeat . ';
			    	background-position: ' . $bg_position . ';
			    	background-size: ' . $bg_size . ';
			    	text-shadow: ' . $shadow . ';
			    	margin: ' . $margin . ';
			    	padding: ' . $padding . ';
			    	
			    }

			    #page {
			    	opacity: ' . $opacity . ';
				}

			    h1, h2, h3, h4, h5, h6, .h7, .h8, .h9, .h0 {
			        font-family: ' . $heading_font . ';
			        color: ' . $heading_color . ';
			        font-weight: ' . $heading_weight . ';
			    }

			    header i {
			    	color: ' . $heading_color . ';
			    }

			    #site-navigation {
			        font-family: ' . $menu_font . ';
			    }

			    #site-navigation-sticky row {
			        font-family: ' . $sticky_font . ';
			    }
			</style>';
			echo $output;
		}
	}

/*
*****************************************************
*      FAVICON
*****************************************************
*/

	//Sets favicon and touch icon
	if ( ! function_exists( 'scm_favicon' ) ) {
		function scm_favicon() {

			$out = '';

			if ( get_field('branding_header_icon_144', 'option') )
				$out .= '<link rel="apple-touch-icon-precomposed" sizes="144x144" href="' . esc_url( get_field('branding_header_icon_144', 'option') ) . '" /> <!-- for retina iPad -->' . "\r\n";
			if ( get_field('branding_header_icon_114', 'option') )
				$out .= '<link rel="apple-touch-icon-precomposed" sizes="114x114" href="' . esc_url( get_field('branding_header_icon_114', 'option') ) . '" /> <!-- for retina iPhone -->' . "\r\n";
			if ( get_field('branding_header_icon_72', 'option') )
				$out .= '<link rel="apple-touch-icon-precomposed" href="' . esc_url( get_field('branding_header_icon_72', 'option') ) . '" /> <!-- for legacy iPad -->' . "\r\n";
			if ( get_field('branding_header_icon_54', 'option') )
				$out .= '<link rel="apple-touch-icon-precomposed" href="' . esc_url( get_field('branding_header_icon_54', 'option') ) . '" /> <!-- for non-retina devices -->' . "\r\n";

			if ( get_field('branding_header_favicon_png', 'option') )
				$out .= '<link rel="icon" type="image/png" href="' . esc_url( get_field('branding_header_favicon_png', 'option') ) . '" /> <!-- standard favicon -->' . "\r\n";
			if ( get_field('branding_header_favicon_ico', 'option') )
				$out .= '<link rel="shortcut icon" href="' . esc_url( get_field('branding_header_favicon_ico', 'option') ) . '" /> <!-- IE favicon -->' . "\r\n";

			if ( $out )
				$out = "<!-- icons and favicon -->\r\n$out\r\n";

			echo $out;
		}
	}


/*
*****************************************************
*      CONTENTS
*****************************************************
*/

	//Prints logo
	if ( ! function_exists( 'scm_logo' ) ) {
		function scm_logo( $align = 'right' ) {

			$logo_id = ( get_field( 'id_branding', 'option' ) ? get_field( 'id_branding', 'option' ) : 'site-branding' );

			$follow = ( get_field('active_social_follow', 'option') ? 1 : 0 );

			$logo_image = esc_url(get_field('branding_header_logo', 'option'));
			$logo_height= numberToStyle(get_field('branding_header_logo_height', 'option'));
			$logo_align = ( $align == 'center' ? 'center' : ( get_field( 'select_alignment_logo', 'option' ) ? get_field( 'select_alignment_logo', 'option' ) : 'left' ) );

			$logo_title = get_bloginfo( 'name' );
			$logo_slogan = get_bloginfo( 'description' );
			$show_slogan = ( get_field('branding_header_slogan', 'option') ? 1 : 0 );
			
			$logo_type = ( get_field('branding_header_type', 'option') ? get_field('branding_header_type', 'option') : 'text' );

			$logo_class = 'header-column site-branding ';
			$logo_class .= ( ( $align != 'center' || $follow ) ? 'half-width ' : 'full ' );
			$logo_class .= $logo_align . ' inlineblock';
			
			//SEO logo HTML tag
			$logo_tag = ( is_front_page() ? 'h1' : 'div' );
			
			//output
			$out = '';

			$out .= '<div id="' . $logo_id . '" class="' . $logo_class . '">';

				$out .= '<' . $logo_tag . ' class="site-title logo ' . $logo_type . '-only">';
					
					$out .= '<a href="' . home_url() . '" title="' . $logo_title . '" style="display:block;">';
					
						$out .= ( 'img' == $logo_type  ? '<img src="' . $logo_image . '" alt="' . $logo_title . '" title="' . $logo_title . '" style="max-height:' . $logo_height . ';" />' : '' );
					
						$out .= '<span class="' . (  'img' == $logo_type ? 'invisible' : 'text-logo' ) . '">' . $logo_title . '</span>';
					
					$out .= '</a>';
				
				$out .= '</' . $logo_tag . '>';
				
				$out .= ( $show_slogan ? '<h2 class="site-description">' . $logo_slogan . '</h2>' : '' );

			$out .= '</div><!-- #site-branding -->';

			echo $out;
		}
	}

	//Prints social follow menu
	if ( ! function_exists( 'scm_social_follow' ) ) {
		function scm_social_follow( $align = 'right' ) {

			$follow = ( get_field('active_social_follow', 'option') ? 1 : 0 );

			if( !$follow || !shortcode_exists( 'feather_follow' ) )
				return;
			
			$follow_id = ( get_field( 'id_social_follow', 'option' ) ? get_field( 'id_social_follow', 'option' ) : 'site-social-follow' );

			$follow_align = ( $align == 'center' ? 'center' : ( get_field('select_alignment_social_follow', 'option') ? get_field('select_alignment_social_follow', 'option') : 'right' ) );
			$follow_size = ( get_field('social_follow_size', 'option') ? get_field('social_follow_size', 'option') : 64 );

			$follow_class = 'header-column site-social-follow ';
			$follow_class .= ( $align != 'center' ? 'half-width ' : 'full ' );
			$follow_class .= $follow_align . ' inlineblock';
			

			//output
			$out = '';

			$out .= '<div id="' . $follow_id . '" class="' . $follow_class . '">';
            	
            	$out .= do_shortcode( '[feather_follow size="' . $follow_size . '"]' );
	        
	        $out .= '</div><!-- #site-social-follow -->';

	        echo $out;

		}
	}

	//Prints main menu
	if ( ! function_exists( 'scm_main_menu' ) ) {
		function scm_main_menu( $align = 'right', $position = 'inline' ) {

			$menu_id = ( get_field( 'id_menu', 'option' ) ? get_field( 'id_menu', 'option' ) : 'site-navigation' );
			
			$menu_class = 'navigation ';
			$menu_class .= ( ( $align == 'center' || $position != 'inline' ) ? 'full ' : 'half-width ' );
			$menu_class .= $align;

			$out = '';

			$out .= '<row class="' . $menu_class . '">';
			
				$out .= '<ul id="%1$s" class="%2$s">%3$s</ul>';

			$out .= '</row>';

			$menu_wrap = $out;

            wp_nav_menu( array(
                "container" => "nav",
                "container_id" => $menu_id,
                "container_class" => $menu_class,
                "menu_id" => "menu-main-menu",
                "menu_class" => "menu",
                "theme_location" => "primary",
                'menu' => '', // id, name or slug
	            /*'items_wrap' => $menu_wrap,*/
            ) );
            
            echo '<!-- #site-navigation -->';
		}
	}

	//Prints sticky menu
	if ( ! function_exists( 'scm_sticky_menu' ) ) {
		function scm_sticky_menu() {

			$sticky = ( get_field( 'active_sticky_menu' ) == 'on' ? 1 : 0 );
			$sticky = ( !$sticky ? ( get_field( 'active_sticky_menu', 'option' ) ? 1 : 0 ) : $sticky );

			if( !$sticky )
				return;

			$sticky_id = ( get_field( 'id_menu', 'option' ) ? get_field( 'id_menu', 'option' ) . '-sticky' : 'site-navigation-sticky' );

			$sticky_layout = ( get_field('select_layout_page', 'option') ? get_field('select_layout_page', 'option') : 'full' );
			$sticky_align = ( get_field('select_alignment_site', 'option') ? get_field('select_alignment_site', 'option') : 'center');
			
			$sticky_menu = ( get_field( 'menu_sticky_menu', 'option' ) ? get_field( 'menu_sticky_menu', 'option' ) : 'primary' );
			$sticky_link = ( get_field( 'link_sticky_menu', 'option' ) == 'top' ? '#top' : home_url() );
			$sticky_toggle = ( get_field( 'toggle_sticky_menu', 'option' ) ? 'fa ' . get_field( 'toggle_sticky_menu', 'option' ) : 'fa-bars' );
			$sticky_icon = ( get_field( 'icon_sticky_menu', 'option' ) ? 'fa ' . get_field( 'icon_sticky_menu', 'option' ) : 'fa-home' );
			$sticky_image = ( get_field( 'image_sticky_menu', 'option' ) ? get_field( 'image_sticky_menu', 'option' ) : '' );
			
			$sticky_class = $sticky_layout . ' ' . $sticky_align . ' navigation sticky';
			

			$row_layout = ( get_field('select_layout_sticky_menu', 'option') ? get_field('select_layout_sticky_menu', 'option') : 'full' );                    
			$row_align = ( get_field('select_alignment_sticky', 'option') ? get_field('select_alignment_sticky', 'option') : 'right');
			
			$row_class = $row_layout . ' ' . $row_align;

			$toggle_class = ( $row_align == 'center' ? 'block' : 'float-' . ( $row_align == 'left' ? 'right' : 'left' ) );

			$out = '';

			$out .= '<row class="' . $row_class . '">';
			
	        	$out .= '<a href="' . $sticky_link . '" class="menu-toggle ' . $toggle_class . '" aria-controls="menu" aria-expanded="false">';
						$out .= '<i class="sticky-toggle ' . $sticky_toggle . '"></i>';
						$out .= '<i class="sticky-icon ' . $sticky_icon . '"></i>';
						if($sticky_image)
							$out .= '<img class="sticky-image" src="' . $sticky_image . '" height=100% />';
	            $out .= '</a>';
			
				$out .= '<ul id="%1$s" class="%2$s">%3$s</ul>';

			$out .= '</row>';

			$sticky_wrap = $out;

			wp_nav_menu( array(
	            'container' => 'nav',
	            'container_id' => $sticky_id,
	            'container_class' => $sticky_class,
	            'menu_id' => 'menu-sticky-menu',
	            'menu_class' => 'menu',
	            'theme_location' => $sticky_menu,
	            'menu' => '', // id, name or slug
	            'items_wrap' => $sticky_wrap,
	        ) );

	        echo '<!-- #site-navigation-sticky -->';

		}
	}

	
	
	//Prints copyright text
	if ( ! function_exists( 'scm_credits' ) ) {
		function scm_credits() {

			$copyText = get_field('branding_footer_credits', 'option');
			if(!$copyText){
				return;
			}

			$replaceArray = array(
				'(c)'  => '&copy;',
				'(C)'  => '&copy;',

				'(r)'  => '&reg;',
				'(R)'  => '&reg;',

				'(tm)' => '&trade;',
				'(TM)' => '&trade;',

				'YEAR' => date( 'Y' ),

				'TITLE' => get_bloginfo( 'name' ),
			);
			$copyText = strtr( $copyText, $replaceArray );
			?>
			<!-- CREDITS -->
			<div class="credits">
				<?php echo $copyText; ?>
			</div>
			<?php
		}
	}
	
	//Prints top-of-page link
	if ( ! function_exists( 'scm_top_of_page' ) ) {
		function scm_top_of_page() {
			
			$offset = get_field('tools_topofpage_offset', 'option');
			$icon = get_field('tools_topofpage_icon', 'option');
			$title = __( 'Inizio Pagina', SCM_THEME );

			$output = 	'<div class="scroll-to-top" data-spy="affix" data-offset-top="' . $offset . '">';
			$output .= 		'<a href="#top" class="smooth-scroll" title="' . $title . '" alt="' . $title . '">';
			$output .=			'<i class="fa ' . $icon . '"></i>';
			$output .=		'</a>';
			$output .= 	'</div>';

			echo $output;
		}
	}
?>