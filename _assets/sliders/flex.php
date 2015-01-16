<?php
/*
*****************************************************
* WEBMAN'S WORDPRESS THEME FRAMEWORK
* Created by WebMan - www.webmandesign.eu
*
* Flex slider
*
* CONTENT:
* - 1) Actions and filters
* - 2) Settings
* - 3) Styles and scripts inclusion
* - 4) HTML generator
*****************************************************
*/





/*
*****************************************************
*      1) ACTIONS AND FILTERS
*****************************************************
*/
	//ACTIONS
		add_action( 'wp_enqueue_scripts', 'wm_slider_flex_assets', 100 );





/*
*****************************************************
*      2) SETTINGS
*****************************************************
*/
	/*
	Flex animation effects:
		fade
		slide
	*/
	//Default Flex slider settings
	$setFlexDefaults = array(
		'namespace'         => '"flex-"',        //{NEW} String => Prefix string attached to the class of every element generated by the plugin
		'selector'          => '".slides > li"', //{NEW} Selector => Must match a simple pattern. '{container} > {slide}' -- Ignore pattern at your own peril
		'animation'         => '"fade"',         //String => Select your animation type, "fade" or "slide"
		'easing'            => '"swing"',        //{NEW} String => Determines the easing method used in jQuery transitions. jQuery easing plugin is supported!
		'direction'         => '"horizontal"',   //String => Select the sliding direction, "horizontal" or "vertical"
		'reverse'           => 'false',          //{NEW} Boolean => Reverse the animation direction
		'animationLoop'     => 'true',           //Boolean => Should the animation loop? If false, directionNav will received "disable" classes at either end
		'smoothHeight'      => 'true',           //{NEW} Boolean => Allow height of the slider to animate smoothly in horizontal mode
		'startAt'           => 0,                //Integer => The slide that the slider should start on. Array notation (0 = first slide)
		'slideshow'         => 'true',           //Boolean => Animate slider automatically
		//'slideshowSpeed'  => 3000,             //Integer => Set the speed of the slideshow cycling, in milliseconds
		'animationSpeed'    => 400,              //Integer => Set the speed of animations, in milliseconds
		'initDelay'         => 0,                //{NEW} Integer => Set an initialization delay, in milliseconds
		'randomize'         => 'false',          //Boolean => Randomize slide order

		// Usability features
		'pauseOnAction'     => 'false',          //Boolean => Pause the slideshow when interacting with control elements, highly recommended.
		'pauseOnHover'      => 'false',          //Boolean => Pause the slideshow when hovering over slider, then resume when no longer hovering
		'useCSS'            => 'true',           //{NEW} Boolean => Slider will use CSS3 transitions if available
		'touch'             => 'true',           //{NEW} Boolean => Allow touch swipe navigation of the slider on touch-enabled devices
		'video'             => 'true',           //{NEW} Boolean => If using video in the slider, will prevent CSS3 3D Transforms to avoid graphical glitches

		// Primary Controls
		'controlNav'        => 'true',           //Boolean => Create navigation for paging control of each clide? Note => Leave true for manualControls usage
		'directionNav'      => 'true',           //Boolean => Create navigation for previous/next navigation? (true/false)
		'prevText'          => '"' . __( '&laquo; Precedente', SCM_THEME ) . '"',     //String => Set the text for the "previous" directionNav item
		'nextText'          => '"' . __( 'Successivo &raquo;', SCM_THEME ) . '"',         //String => Set the text for the "next" directionNav item

		// Secondary Navigation
		'keyboard'          => 'true',           //Boolean => Allow slider navigating via keyboard left/right keys
		'multipleKeyboard'  => 'false',          //{NEW} Boolean => Allow keyboard navigation to affect multiple sliders. Default behavior cuts out keyboard navigation with more than one slider present.
		'mousewheel'        => 'false',          //{UPDATED} Boolean => Requires jquery.mousewheel.js (https://github.com/brandonaaron/jquery-mousewheel) - Allows slider navigating via mousewheel
		'pausePlay'         => 'false',          //Boolean => Create pause/play dynamic element
		'pauseText'         => '"Pause"',        //String => Set the text for the "pause" pausePlay item
		'playText'          => '"Play"',         //String => Set the text for the "play" pausePlay item

		// Special properties
		'controlsContainer' => '""',             //{UPDATED} Selector => USE CLASS SELECTOR. Declare which container the navigation elements should be appended too. Default container is the FlexSlider element. Example use would be ".flexslider-container". Property is ignored if given element is not found.
		'manualControls'    => '""',             //Selector => Declare custom control navigation. Examples would be ".flex-control-nav li" or "#tabs-nav li img", etc. The number of elements in your controlNav should match the number of slides/tabs.
		'sync'              => '""',             //{NEW} Selector => Mirror the actions performed on this slider with another slider. Use with care.
		'asNavFor'          => '""',             //{NEW} Selector => Internal property exposed for turning the slider into a thumbnail navigation for another slider

		// Carousel Options
		'itemWidth'         => 0,                //{NEW} Integer => Box-model width of individual carousel items, including horizontal borders and padding.
		'itemMargin'        => 0,                //{NEW} Integer => Margin between carousel items.
		'minItems'          => 0,                //{NEW} Integer => Minimum number of carousel items that should be visible. Items will resize fluidly when below this.
		'maxItems'          => 0,                //{NEW} Integer => Maxmimum number of carousel items that should be visible. Items will resize fluidly when above this limit.
		'move'              => 0,                //{NEW} Integer => Number of carousel items that should move on animation. If 0, slider will move all visible items.

		// Callback API
		/*
		start               => function(){},     //Callback => function(slider) - Fires when the slider loads the first slide
		before              => function(){},     //Callback => function(slider) - Fires asynchronously with each slider animation
		after               => function(){},     //Callback => function(slider) - Fires after each slider animation completes
		end                 => function(){},     //Callback => function(slider) - Fires when the slider reaches the last slide (asynchronous)
		added               => function(){},     //{NEW} Callback => function(slider) - Fires after a slide is added
		removed             => function(){}      //{NEW} Callback => function(slider) - Fires after a slide is removed
		*/
	);





/*
*****************************************************
*      3) STYLES AND SCRIPTS INCLUSION
*****************************************************
*/
	/*
	* Assets to include in footer
	*/
	if ( ! function_exists( 'wm_slider_flex_assets' ) ) {
		function wm_slider_flex_assets() {
			$blogPageId = ( is_home() ) ? ( get_option( 'page_for_posts' ) ) : ( null );
			if (
				'flex' == wm_meta_option( 'slider-type', $blogPageId ) ||
				( wm_meta_option( 'project-type', $blogPageId ) && 'flex-project' == wm_meta_option( 'project-type', $blogPageId ) )
				) {
				//enqueue styles
				wp_enqueue_style( 'flex' );

				//enqueue scripts
				wp_enqueue_script( 'flex' );
				wp_enqueue_script( 'apply-flex' );
			}
		}
	} // /wm_slider_flex_assets





/*
*****************************************************
*      4) HTML GENERATOR
*****************************************************
*/
	/*
	* Slider generator
	*
	* $slidesCount   = # [number of slides to display]
	* $slidesContent = TEXT [type of slides content]
	* $slidesCat     = # [category from which slides content will be taken - only when using post or wm_slides as content]
	* $imageSize     = TEXT [image size in slider]
	* $width         = TEXT [normal or fullwidth]
	*/
	if ( ! function_exists( 'wm_slider_flex' ) ) {
		function wm_slider_flex( $slidesCount = 3, $slidesContent = null, $slidesCat = null, $imageSize = 'slide', $width = 'normal' ) {
			$out        = '';
			$prefix     = 'slider-flex-';
			$blogPageId = ( is_home() ) ? ( get_option( 'page_for_posts' ) ) : ( null );

			//Generating HTML output
			wp_reset_query();

			//Setting query
			if ( 'wm_slides' == $slidesContent && 0 < $slidesCat ) {

				//Slides custom posts with category specified
				$query_args = array(
						'post_type'      => $slidesContent,
						'posts_per_page' => $slidesCount,
						'tax_query'      => array( array(
								'taxonomy' => 'slide-category',
								'field'    => 'id',
								'terms'    => $slidesCat
							) ),
						'post__not_in'   => get_option( 'sticky_posts' )
					);
				$query_args = apply_filters( 'wmhook_slider_query_' . 'flex', $query_args );
				$query_args = apply_filters( 'wmhook_slider_query_' . 'flex' . '_cat_' . $slidesCat, $query_args );
				$slides = new WP_Query( $query_args );

			} elseif ( 'wm_slides' == $slidesContent ) {

				//Slides custom posts all
				$query_args = array(
						'post_type'      => $slidesContent,
						'posts_per_page' => $slidesCount,
						'post__not_in'   => get_option( 'sticky_posts' )
					);
				$query_args = apply_filters( 'wmhook_slider_query_' . 'flex', $query_args );
				$slides = new WP_Query( $query_args );

			} elseif ( 'gallery' == $slidesContent ) {

				//Post gallery images
				$slides = apply_filters( 'wmhook_slider_gallery_' . 'flex', wm_meta_option( 'slider-gallery-images', $blogPageId ), $blogPageId );

			}



			if ( 'gallery' != $slidesContent ) {

				if ( $slides->have_posts() ) {
					$duration = ' data-time="' . wm_option( 'slider-flex-slideshowSpeed' ) . '"';

					if ( 'fullwidth' === $width )
						$out .= '<div id="flex-slider" class="flexslider bg-ready slider-content"' . $duration . '><ul class="slides">';
					else
						$out .= '<div class="wrap-inner"><div class="twelve pane"><div id="flex-slider" class="flexslider bg-ready slider-content"' . $duration . '><ul class="slides">';

					while ( $slides->have_posts() ) {
						$slides->the_post();

						$out .= '<li data-style="' . wm_css_background_meta( 'slide-' ) . '">';

						//Image
						$link   = ( wm_meta_option( 'slide-link' ) ) ? ( esc_url( wm_meta_option( 'slide-link' ) ) ) : ( null );
						$target = '';

						//if video set, just link to it
						if ( wm_meta_option( 'slide-video' ) ) {
							$link   = esc_url( wm_meta_option( 'slide-video' ) );
							$target = ' target="_blank"';
						}

						$out .= ( $link ) ? ( '<a href="' . esc_url( $link ) . '"' . $target . '>' ) : ( '' );
						if ( has_post_thumbnail() ) {
							$attachment  = get_post( get_post_thumbnail_id() );
							$image       = get_the_post_thumbnail( get_the_ID(), $imageSize, array( 'title' => esc_attr( $attachment->post_title ) ) );
							$out        .= preg_replace( '/(width|height)=\"\d*\"\s/', "", $image );
						}
						$out .= ( $link ) ? ( '</a>' ) : ( '' );

						//Caption
						if ( get_the_content() ) {
							$layout = ( wm_meta_option( 'slide-caption-alignment' ) ) ? ( wm_meta_option( 'slide-caption-alignment' ) . wm_meta_option( 'slide-caption-padding' ) ) : ( ' column col-13 no-margin alignright' );

							if ( 0 < wm_meta_option( 'slide-caption-opacity' ) && 100 > wm_meta_option( 'slide-caption-opacity' ) )
								$bg  = 'url(' . WM_ASSETS_THEME . 'img/transparent/' . wm_meta_option( 'slide-caption-color' ) . '/' . wm_meta_option( 'slide-caption-opacity' ) . '.png)';
							else
								$bg  = ( 100 == wm_meta_option( 'slide-caption-opacity' ) ) ? ( wm_meta_option( 'slide-caption-color' ) ) : ( 'transparent; background:rgba(0,0,0, 0);' ); //the RGBA is for IE9 to work!
							$style = ( $bg ) ? ( ' style="background:' . $bg . '"' ) : ( '' );

							$iconsColorClass = ( 'black' == wm_meta_option( 'slide-caption-color' ) ) ? ( ' light-icons' ) : ( ' dark-icons' );

							$out .= '<div class="wrap-caption flex-caption">';
							$out .= '<div class="slider-caption-content">';
							$out .= ( $link ) ? ( '<a href="' . esc_url( $link ) . '"' . $target . '></a>' ) : ( '' );
							$out .= '<div class="caption-inner bg-' . wm_meta_option( 'slide-caption-color' ) . $iconsColorClass . $layout . '"' . $style . '><div class="caption-inner-centered">';
							$out .= apply_filters( 'wm_default_content_filters', get_the_content() );
							$out .= '</div></div></div>';
							$out .= '</div>';
						}

						$out .= '</li>';
					}

					if ( 'fullwidth' === $width )
						$out .= '</ul></div> <!-- /flex-slider -->';
					else
						$out .= '</ul></div></div></div> <!-- /flex-slider -->';

				} // /have_posts

			} elseif ( is_array( $slides ) && ! empty( $slides ) ) {

				$slides   = array_slice( $slides, 0, $slidesCount );
				$duration = ' data-time="' . wm_option( 'slider-flex-slideshowSpeed' ) . '"';

				if ( wm_meta_option( 'project-type', $blogPageId ) && 'flex-project' == wm_meta_option( 'project-type', $blogPageId ) ) {
					$duration = ' data-time="' . ( wm_meta_option( 'project-slider-duration', $blogPageId ) * 1000 ) . '"';
				}

				//Images
				if ( 'fullwidth' === $width )
					$out .= '<div id="flex-slider" class="flexslider slider-content"' . $duration . '><ul class="slides">';
				else
					$out .= '<div class="wrap-inner"><div class="twelve pane"><div id="flex-slider" class="flexslider slider-content"' . $duration . '><ul class="slides">';

				foreach ( $slides as $imageId) {
					$out .= '<li>';

					//Caption
					$attachment = get_post( $imageId );
					$link       = get_post_meta( $attachment->ID, 'image-url', true );

					$imageAlt   = get_post_meta( $imageId, '_wp_attachment_image_alt', true );
					$imageTitle = '';
					if ( is_object( $attachment ) && ! empty( $attachment ) ) {
						$imageTitle  = $attachment->post_title;
						$imageTitle .= ( $attachment->post_excerpt ) ? ( ' - ' . $attachment->post_excerpt ) : ( '' );
					}

					$imgUrl = wp_get_attachment_image_src( $imageId, $imageSize );
					$out .= ( $link ) ? ( '<a href="' . esc_url( $link ) . '">' ) : ( '' );
					$out .= '<img src="' . $imgUrl[0] . '" alt="' . esc_attr( $imageAlt ) . '" title="' . esc_attr( $imageTitle ) . '" />';
					$out .= ( $link ) ? ( '</a>' ) : ( '' );

					if ( $attachment ) {
						$content = '';
						$content .= ( $attachment->post_excerpt ) ? ( '<h2>' . wptexturize( $attachment->post_excerpt ) . '</h2>' ) : ( '' );
						$content .= ( $attachment->post_content ) ? ( wptexturize( $attachment->post_content ) ) : ( '' );

						$layout = ( get_post_meta( $attachment->ID, 'caption-alignment', true ) ) ? ( get_post_meta( $attachment->ID, 'caption-alignment', true ) . get_post_meta( $attachment->ID, 'caption-padding', true ) ) : ( ' column col-13 no-margin alignright' );
						if ( 0 < absint( get_post_meta( $attachment->ID, 'caption-opacity', true ) ) && 100 > absint( get_post_meta( $attachment->ID, 'caption-opacity', true ) ) )
							$bg = 'url(' . WM_ASSETS_THEME . 'img/transparent/' . get_post_meta( $attachment->ID, 'caption-color', true ) . '/' . absint( get_post_meta( $attachment->ID, 'caption-opacity', true ) ) . '.png)';
						else
							$bg = ( 100 == absint( get_post_meta( $attachment->ID, 'caption-opacity', true ) ) ) ? ( get_post_meta( $attachment->ID, 'caption-color', true ) ) : ( 'transparent; background:rgba(0,0,0, 0);' ); //the RGBA is for IE9 to work!
						$style = ( $bg ) ? ( ' style="background:' . $bg . '"' ) : ( '' );

						$iconsColorClass = ( 'black' == get_post_meta( $attachment->ID, 'caption-color', true ) ) ? ( ' light-icons' ) : ( ' dark-icons' );

						if ( $content ) {
							$out .= '<div class="wrap-caption flex-caption">';
							$out .= '<div class="slider-caption-content">';
							$out .= ( $link ) ? ( '<a href="' . esc_url( $link ) . '"></a>' ) : ( '' );
							$out .= '<div class="caption-inner bg-' . get_post_meta( $attachment->ID, 'caption-color', true ) . $iconsColorClass . $layout . '"' . $style . '><div class="caption-inner-centered">';
							$out .= apply_filters( 'wm_default_content_filters', $content );
							$out .= '</div></div></div>';
							$out .= '</div>';
						}
					}

					$out .= '</li>';
				}

				if ( 'fullwidth' === $width )
					$out .= '</ul></div> <!-- /flex-slider -->';
				else
					$out .= '</ul></div></div></div> <!-- /flex-slider -->';

			} // /slides gallery array

			wp_reset_query();

			$out = "\r\n\r\n" . $out;

			if ( $out )
				return $out;
			else
				return;
		}
	} // /wm_slider_flex

?>