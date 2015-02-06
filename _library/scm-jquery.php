<?php

//*****************************************************
//*
//	IE fixes
//	Youtube Embed Fix
//	Toggle Menu
//	Sticky Menu
//	Smooth Scroll
//	Single Page Nav
//  Top Of Page
//  Overlay
//	Tabs
//	Accordions
//	Toggles
//	Slideshow
//	Isotope Filter
//	Active Class
//  Responsive Layout
//  Google Maps
//  Nivo Slider
//	Fancybox
//
//	Show Body
//*
//*****************************************************


// *****************************************************
// ******* ACTIONS AND FILTERS
// *****************************************************

// +++ todo:	A > if script is needed, then add_action
//				B > merge everything in one single script as functions (maybe a JS Class with Methods), then call functions/methods only if needed

	
	
	

	add_action('wp_footer', 'scm_jquery_ie_fixes');
	add_action('wp_footer', 'scm_jquery_youtube_fix');
	add_action('wp_footer', 'scm_jquery_toggle_menu');
	add_action('wp_footer', 'scm_jquery_sticky_menu');
	add_action('wp_footer', 'scm_jquery_smooth_scroll');
	add_action('wp_footer', 'scm_jquery_single_page_nav');
	add_action('wp_footer', 'scm_jquery_top_of_page');
	add_action('wp_footer', 'scm_jquery_overlay');

	add_action('wp_footer', 'scm_jquery_tabs');
	add_action('wp_footer', 'scm_jquery_accordion');
	add_action('wp_footer', 'scm_jquery_toggle');
	add_action('wp_footer', 'scm_jquery_isotope_filter');
	//add_action('wp_footer', 'scm_jquery_active_class');
	
	add_action('wp_footer', 'scm_jquery_google_map');
	add_action('wp_footer', 'scm_jquery_nivoslider');
	add_action('wp_footer', 'scm_jquery_fancybox');

	add_action('wp_footer', 'scm_responsive_layout');
	add_action('wp_footer', 'scm_jquery_events');
	add_action('wp_footer', 'scm_jquery_change_page');	

	
	



// *****************************************************
// *      EVENTS
// *****************************************************

	//Link Events
    if ( ! function_exists( 'scm_jquery_events' ) ) {
        function scm_jquery_events(){
        	global $is_iphone, $is_gecko;

        ?>
			<script type="text/javascript">
	        	jQuery(document).ready(function($){

	        		$(window).load(function(){
						$( 'body' ).trigger('windowLoaded');
					});

	        		var istouch = false;
	        		var is_iphone = <?php echo json_encode($is_iphone); ?>;
	        		var is_gecko = <?php echo json_encode($is_gecko); ?>;

		        	if ( Modernizr.touchEvents || Modernizr.touch || is_iphone ) {   
					    istouch = true;
					    
					    <?php
						    wp_register_script( 'jquerymobile', SCM_URI_JS . 'jquery.mobile/jquery.mobile.touchevents.min.js', array( 'jquery' ), SCM_SCRIPTS_VERSION, true );
	            			wp_enqueue_script( 'jquerymobile' );
	            			wp_register_script( 'jqueryswipe', SCM_URI_JS . 'jquery.touchSwipe/jquery.touchSwipe.min.js', array( 'jquery' ), SCM_SCRIPTS_VERSION, true );
	            			wp_enqueue_script( 'jqueryswipe' );
            			?>

					}	

					function linkIt( elem, link ){

						if( $( '.toggled' ).length > 0 )
							toggleIt();

						$('body').trigger( 'link', [ elem, link ] );

	            		if ( location.pathname.replace( /^\//,'' ) !== elem.pathname.replace( /^\//,'' ) && location.hostname === elem.hostname ) {
							$('body').trigger( 'linkSite', [ elem, link ] );
						}else if ( location.pathname.replace( /^\//,'' ) === elem.pathname.replace( /^\//,'' ) && location.hostname === elem.hostname ) {
							$('body').trigger( 'linkPage', [ elem, link ] );
						}else{
							$('body').trigger( 'linkExternal', [ elem, link ] );
						}
						
					}

					function toggleIt( event, elem ) {

						if( 'undefined' === typeof elem )
							elem = $('.toggle');
						else if( !$( elem ).hasClass( 'toggle' ) )
							elem = $( elem ).parents( '.toggle' );

						var $this = $( elem );

						if( !$this.hasClass( 'toggled' ) )
							toggleOn( event, elem );
						else
							toggleOff( event, elem );

					}

					function toggleOn( event, elem ) {

						if( 'undefined' === typeof elem )
							elem = $('.toggle');
						else if( !$( elem ).hasClass( 'toggle' ) )
							elem = $( elem ).parents( '.toggle' );

						var $this = $( elem );
						
						if( !$this.hasClass( 'toggled' ) ){
							$this.find( '.menu-toggle' ).data( 'tapped', true );
							$this.addClass( 'toggled' );
							$this.trigger( 'toggled', [ elem, 1 ] );
						}
					}

					function toggleOff( event, elem ) {

						if( 'undefined' === typeof elem )
							elem = $('.toggle');
						else if( !$( elem ).hasClass( 'toggle' ) )
							elem = $( elem ).parents( '.toggle' );

						var $this = $( elem );

						if( $this.hasClass( 'toggled' ) ){
							$this.find( '.menu-toggle' ).data( 'tapped', false );
							//alert( $this.find( '.menu-toggle' ).data( 'tapped' ) );
							$this.removeClass( 'toggled' );
							$this.trigger( 'toggled', [ elem, 0 ] );
						}
					}

					function resetEvents( event, elem, on){

		        		if( !istouch || is_gecko ){

			        		$('a').click(function(event) {

			        			event.preventDefault();
			        			
			        			var link = String(this.href);

			        			linkIt(this, link);

							});

							$('.toggle').mouseenter( function(event) {
								toggleOn( event, this );
							});

							$('.toggle').mouseleave( function(event) {
								toggleOff( event, this );
							});

			        	}

			        	if( istouch ){

			        		$('a').on('tap', function(event) {

			        			event.preventDefault();

			        			if(this.href != undefined){

			        				var link = String(this.href);

			        				//alert($( this ).data( 'tapped' ));
							    
								    if( $( this ).data( 'tapped' ) ) {
								    	// If it is already TAPPED go Link
								        $( '*' ).data( 'tapped', false );
								        linkIt( this, link );

								    } else {
								    	
								    	var menu = $( this ).parent().children( '.sub-menu' );

								    	if( $( menu ).length == 0 ){

								    		var inside = $( this ).parents().hasClass( 'sub-menu' );
								    		// If it is not inside TAPPABLE go Reset
											if( !inside )
												$( '*' ).data( 'tapped', false );

											// If it is Home Button in Toggle Menu go Tap
											if( $( this ).hasClass( 'menu-toggle' ) && $( this ).parents( '.toggle' ).length > 0 ){

												toggleOn( event, this );

											// If it is not TAPPABLE go Link
											}else{
											
									        	linkIt( this, link );

									        }

								        }else if( $( menu ).css( 'display' ) != 'none' ){
								        	// If it is TAPPABLE and not already TAPPED go Tap
								        	$( this ).data( 'tapped', true );
								        	$( 'body' ).trigger( 'linkTap', [ this, link ] );

								        }else{

								        	linkIt( this, link );

								        }
								    }
								}else{
									//alert('TAPPED');
								}

								event.stopPropagation();
								
							});


							$( '.toggle' ).on( 'tap', function( event ) {
								//event.stopPropagation();
								toggleIt( event, this );
								return false;
							});


							$( '.toggle' ).swipe( {
								
						        swipeDown: function( event, direction, distance, duration, fingerCount ) {
						        	toggleOn( event, this );
						        	event.stopPropagation();

						        },
						        swipeUp: function( event, direction, distance, duration, fingerCount ) {
						        	toggleOff( event, this );
						        	event.stopPropagation();

						        },
						        threshold: 10,
						        excludedElements: ''
								
							});

							$('.menu-toggle').on('vmouseup', function(event) {
								$( this ).css('opacity', 1);
							});

							$('.toggle').on('vmousedown', function(event) {
								event.preventDefault();
								event.stopPropagation();
							});
							
							$(':not(.toggle) a').on('vmousedown', function(event) {
								event.preventDefault();
								event.stopPropagation();
							});
							
							$('*:not(a):not(a *):not(.toggle):not(.toggle *)').on('vmousedown', function(event) {
								//alert($(this).find('.menu-toggle').data('tapped'));
								//alert('PIPPO');
								$('*').data( 'tapped', false );
								toggleOff( event );
								//event.preventDefault();
						        event.stopPropagation();

							});

						}
					}

					$( '.navigation' ).on( 'toggle', resetEvents );
					resetEvents();

				});

				
			</script>
		<?php
		}
	}



// *****************************************************
// *      IE FIXES
// *****************************************************

	//IE fixes
	if ( ! function_exists( 'scm_jquery_ie_fixes' ) ) {
		function scm_jquery_ie_fixes(){

		?>
			<script type="text/javascript">
				jQuery(document).ready(function($){

					$( '.no-js' ).removeClass( 'no-js' );	
					$( '.lie8 img[height]' ).removeAttr( 'height' );
					$( 'html.lie8 .price-spec li:nth-child(even)' ).addClass( 'even' );

				});
			</script>
		<?php
		}
	}


// *****************************************************
// *      YOUTUBE EMBED FIX
// *****************************************************

	//YouTube Embed Fix
	if ( ! function_exists( 'scm_jquery_youtube_fix' ) ) {
		function scm_jquery_youtube_fix(){

		?>
			<script type="text/javascript">
				jQuery(document).ready(function($){

					$( 'iframe[src*="youtube.com"]' ).each( function( item ) {
						var srcAtt = $( this ).attr( 'src' );
						if ( -1 == srcAtt.indexOf( '?' ) )
							srcAtt += '?wmode=transparent';
						else
							srcAtt += '&amp;wmode=transparent';
						$( this ).attr( 'src', srcAtt );
					} );

				});
			</script>
		<?php
		}
	}

// *****************************************************
// *      TOGGLE MENU
// *****************************************************

	// Toggle Menu
	if ( ! function_exists( 'scm_jquery_toggle_menu' ) ) {
		function scm_jquery_toggle_menu(){

			$menu = ( get_field('id_menu', 'option') ?: 'site-navigation' );
			$sticky_menu = $menu . '-sticky';

		?>
			<script type="text/javascript">
			
				jQuery(document).ready(function($){

					var menu = $( '#' + <?php echo json_encode($menu); ?> );
					var sticky_menu = $( '#' + <?php echo json_encode($sticky_menu); ?> );

					if( 'undefined' !== typeof menu )
						setToggle( menu );
					if( 'undefined' !== typeof sticky_menu )
						setToggle( sticky_menu );


					function toggleMenu( event, elem, on ) {

						var $this = $(elem);
						var $menu = $this.find( '.menu' );
						var $toggle = $this.find( '.menu-toggle' );
						var $icon = $this.find( '.icon-toggle' );
						var $home = $this.find( '.icon-home' );

						if( on ){

							$icon.css( 'display', 'none' );
							$home.css( 'display', 'inline-block' );
							/*$home.css({
						        transform: 'rotate(90deg)'
						    });
							$({deg: 0}).animate({deg: -90}, {
						        duration: 300,
						        step: function(now) {
						            $toggle.css({
						                transform: 'rotate(' + now + 'deg)'
						            });

						        }
						    });*/

							//$toggle.css( 'pointer-events', 'auto' );
							$toggle.attr( 'aria-expanded', 'true' );
							$menu.attr( 'aria-expanded', 'true' );
							$this.css( 'cursor', 'pointer' );

						}else{

							$icon.css( 'display', 'inline-block' );
							$home.css( 'display', 'none' );

							/*$({deg: -90}).animate({deg: 0}, {
						        duration: 300,
						        step: function(now) {
						            $toggle.css({
						                transform: 'rotate(' + now + 'deg)'
						            });

						        }
						    });*/

							//$toggle.css( 'pointer-events', 'none' );
							$toggle.attr( 'aria-expanded', 'false' );
							$menu.attr( 'aria-expanded', 'false' );
							$this.css( 'cursor', 'default' );

						}

					}

					function switchMenu( event, state ) {
						var nav = $( event.data.nav );
						//var menu = $( nav ).find( '.menu' );
						var button = $( nav ).find( '.menu-toggle' );
						var toggle = $( nav ).find( '.icon-toggle' );
						var home = $( nav ).find( '.icon-home' );
						var image = $( nav ).find( '.icon-image' );

						var toggle_act, home_act, image_act;

						toggle_act = $( button ).attr( 'data-toggle' );
						home_act = $( button ).attr( 'data-home' );
						image_act = $( button ).attr( 'data-image' );

						var toggle_st, home_st, image_st;
						
						toggle_st = 'inline-block';
						home_st = 'none';
						image_st = 'none';

						switch( state ){

							case 'portrait':
								if( toggle_act == 'smart' ){
									toggle_st = 'none';
									if( home_act == 'true' ){
										if ( image_act == 'portrait' || image_act == 'landscape' || image_act == 'desktop' )
											image_st = 'inline-block';
										else
											home_st = 'inline-block';
									}
								}

							break;

							case 'landscape':
								if( toggle_act != 'desktop' && toggle_act != 'landscape' ){
									toggle_st = 'none';
									if( home_act == 'true' ){
										if ( image_act == 'landscape' || image_act == 'desktop' )
											image_st = 'inline-block';
										else
											home_st = 'inline-block';
									}
								}
							break;

							case 'desktop':
								if( toggle_act != 'desktop' ){
									toggle_st = 'none';
									if( home_act == 'true' ){
										if ( image_act == 'desktop' )
											image_st = 'inline-block';
										else
											home_st = 'inline-block';
									}
								}
							break;
						}

						if( toggle_st != 'none' ){
							$( nav ).addClass( 'toggle' );
							$( nav ).trigger( 'toggle', [ nav, 1 ] );
						}else{
							$( nav ).removeClass( 'toggle' );
							$( nav ).trigger( 'toggle', [ nav, 0 ] );
						}

						if( toggle ) $( toggle ).css( 'display', toggle_st );
						if( home ) $( home ).css( 'display', home_st );
						if( image ) $( image ).css( 'display', image_st );

					}

					function setToggle( nav ){

						var button, menu;
						
						button = $( nav ).find( '.menu-toggle' );
				
						if ( 'undefined' === typeof button ) {
							return;
						}

						menu = $( nav ).find( 'row > ul' );

						if ( 'undefined' === typeof menu ) {
							$( button ).css( 'display', 'none' );
							return;
						}

						$( menu ).attr( 'aria-expanded', 'false' );

						var toggle, home, image;

						toggle = $( button ).find( 'icon-toggle' );
						home = $( button ).find( 'icon-home' );
						image = $( button ).find( 'icon-image' );

						$( 'body' ).on( 'responsive', {nav: nav}, switchMenu);


						$( nav ).on( 'toggled', toggleMenu );

						//$( nav ).mouseleave( toggleOff );
						//$(window).on('swipe', toggleOff );
						//$(window).on('tap', toggleOff );
					
						/*$( '.toggled .menu-toggle' ).on( 'link', toggleOff );
						$( nav ).find('row > ul > li > a' ).on( 'link', toggleOff );*/

					}
				});

			</script>
		<?php
		}
	}

// *****************************************************
// *      STICKY MENU
// *****************************************************

	// Sticky Menu Affix
	if ( ! function_exists( 'scm_jquery_sticky_menu' ) ) {
		function scm_jquery_sticky_menu(){

			$sticky = ( get_field('active_sticky_menu', 'option') ?: 'no' );

			if( $sticky == 'no' )
				return;

			$offset = ( get_field('offset_sticky_menu', 'option') ?: 0 );
			$attach = ( get_field('attach_sticky_menu', 'option') ?: 'nav-top' );
			$menu = ( get_field('id_menu', 'option') ?: 'site-navigation' );
			$sticky_menu = $menu . '-sticky';
			if( $sticky == 'self' )
				$attach = 'nav-top';
		?>

			<script type="text/javascript">
			
				jQuery(document).ready(function($){
					
					var menu = '#' + <?php echo json_encode($menu); ?>;
					var sticky_menu = '#' + <?php echo json_encode($sticky_menu); ?>;
					var offset = parseFloat( <?php echo json_encode($offset); ?> );
					var attach = <?php echo json_encode($attach); ?>;
					var sticky = <?php echo json_encode($sticky); ?>;
					
					function setSticky( event, state ){

						var new_offset = 0;

						if( attach == 'nav-top'){
							new_offset = offset + $(menu).offset().top;
						}else if( attach == 'nav-bottom'){
							new_offset = offset + $(menu).offset().top + $(menu).outerHeight();
						}

						$(window).off('.affix');
						$(sticky_menu)
						    .removeClass("affix affix-top affix-bottom")
						    .removeData("bs.affix");
						
						$(sticky_menu).affix(
							{ offset: { top: parseInt(new_offset) } }
						);

						if( sticky == 'plus' ){
							var result = $(sticky_menu).css('box-shadow').match(/(-?\d)|(rgba\(.+\))/g)
							var color = result[0],
							    x = result[1],
							    y = result[2],
							    blur = result[3],
							    exp = result[4];
							var plus = parseFloat(y) + parseFloat(blur) + parseFloat(exp);

							$(sticky_menu).css( 'top', -$(sticky_menu).outerHeight()-plus );
						}

						$(sticky_menu).on('affix.bs.affix', function () {
						     $(menu).addClass('affix-' + sticky);
						});
						$(sticky_menu).on('affix-top.bs.affix', function () {
						     $(menu).removeClass('affix-' + sticky);
						});

					}

					$( 'body' ).on( 'responsive', setSticky );

				});
			</script>
		<?php
		}
	}


// *****************************************************
// *      SMOOTH SCROLL
// *****************************************************

	//Smooth Scroll
	if ( ! function_exists( 'scm_jquery_smooth_scroll' ) ) {
		function scm_jquery_smooth_scroll(){

			$duration = get_field( 'tools_smoothscroll_duration', 'option' );
			$offset = get_field( 'tools_smoothscroll_offset', 'option' );
			$ease = get_field( 'select_ease_smoothscroll', 'option' );

		?>
			<script type="text/javascript">
				jQuery(document).ready(function($){

					var time = <?php echo json_encode($duration); ?>;
					var offset = <?php echo json_encode($offset); ?>;
					var ease = <?php echo json_encode($ease); ?>;

					function smoothScroll( event, elem, link ) {

						event.preventDefault();
							
						var win = $( window ).height();
						var height = $( 'body' ).height();
						var position = $( 'body' ).scrollTop();

						var target = $( elem.hash );
						var name = elem.hash.slice( 1 );
						var destination;

						target = target.length ? target : $( '[id=' + name +']' );

						if ( name == 'top' ){								
							destination = 0;
						}else{
							destination = target.offset().top - parseInt( offset );
							if( height - destination < win ){
								destination = height - win;
							}
						}

						var difference = Math.abs( destination - position );
						var duration = time * difference / 1000;

						duration = ( duration < 500 ? 500 : duration );
						duration = ( duration > 1500 ? 1500 : duration );

						if ( target.length || destination == 0 ) {
							$( 'body' ).css( 'pointer-events', 'none' );
							$( 'html, body' ).animate( { scrollTop: destination }, parseInt( duration ), ease, function(){ $( this ).css( 'pointer-events', 'all' ); } );
							return false;
						}
					}

					$( 'body' ).on( 'linkPage', smoothScroll );

				});
			</script>
		<?php
		}
	}

// *****************************************************
// *      SINGLE PAGE NAV
// *****************************************************

	//Single Page Nav
	if ( ! function_exists( 'scm_jquery_single_page_nav' ) ) {
		function scm_jquery_single_page_nav(){

			$active = get_field( 'tools_singlepagenav_activeclass', 'option' );
			$interval = get_field( 'tools_singlepagenav_interval', 'option' );
			$offset = get_field( 'tools_singlepagenav_offset', 'option' );

		?>
			<script type="text/javascript">
				jQuery(document).ready(function($){

					var active = <?php echo json_encode($active); ?>;
					var interval = <?php echo json_encode($interval); ?>;
					var offset = <?php echo json_encode($offset); ?>;

					$('.navigation').singlePageNav({
					//$('.navigation').singlePageNav({
						filter: ':not(.external) :not([href="#top"])',
						currentClass: active,
						offset: offset,
				        threshold: 120,
				        interval: interval
					});

				});
			</script>
		<?php
		}
	}

// *****************************************************
// *      TOP OF PAGE
// *****************************************************

	// Top Of Page
	if ( ! function_exists( 'scm_jquery_top_of_page' ) ) {
		function scm_jquery_top_of_page(){

			$offset = ( get_field('tools_topofpage_offset', 'option') ?: '0' );
			$topofpage = ( get_field('id_topofpage', 'option') ?: 'site-topofpage' );

		?>
			<script type="text/javascript">
				
				jQuery(document).ready(function($){
					
					var topofpage = '#' + <?php echo json_encode($topofpage); ?>;
					var offset = parseFloat( <?php echo json_encode($offset); ?> );

					function setTopOfPage( event, state ){

						$(topofpage)

						    .removeClass("affix affix-top affix-bottom")
						    .removeData("bs.affix");

						$(topofpage).affix(

							{ offset: { top: parseInt(offset) } }

						);

					}

					$( 'body' ).on( 'responsive', setTopOfPage );
				
				});
			</script>
		<?php
		}
	}

// *****************************************************
// *      OVERLAY
// *****************************************************

	// Overlay
	if ( ! function_exists( 'scm_jquery_overlay' ) ) {
		function scm_jquery_overlay(){

		?>
			<script type="text/javascript">
				
				jQuery(document).ready(function($){
					
					var overlay = $('.overlay-menu');
					
					if( overlay ){

						function setOverlay( event, state){

							overlay.each(function(){
								var h = $(this).outerHeight();
								$(this).css( 'margin-bottom', - h );
							});
							
						}
						$( 'body' ).on( 'responsive', setOverlay );
					}
				
				});
			</script>
		<?php
		}
	}

// *****************************************************
// *      TABS
// *****************************************************

	//Tabs
	if ( ! function_exists( 'scm_jquery_tabs' ) ) {
		function scm_jquery_tabs(){

		?>
			<script type="text/javascript">
				jQuery(document).ready(function($){

					if ( $( 'div.tabs-wrapper' ).length ) {

						(function() {
							var tabObject = $( 'div.tabs-wrapper > ul' );

							i = 0;
							tabObject.each( function( item ) {
								var out         = '';
								    tabsWrapper = $( this ),
								    tabsCount   = tabsWrapper.children( 'li' ).length;

								tabsWrapper.find( '.tab-heading' ).each( function( subitem ) {
									i++;
									var tabItem      = $( this ),
									    tabItemId    = tabItem.closest( 'li' ).attr( 'id', 'tab-item-' + i ),
									    tabItemTitle = tabItem.html(),
									    tabLast      = ( tabsCount === i ) ? ( ' last' ) : ( '' );

									tabItem.addClass( 'hide' );
									if ( tabItem.closest( 'div.tabs-wrapper' ).hasClass( 'fullwidth' ) )
										out += '<li class="column col-1' + tabsCount + tabLast + ' no-margin"><a href="#tab-item-' + i + ' ">' + tabItemTitle + '</a></li>';
									else
										out += '<li><a href="#tab-item-' + i + '">' + tabItemTitle + '</a></li>';
								} );

								tabsWrapper.before( '<ul class="tabs clearfix">' + out + '</ul>' );
							} );

						})();

						var tabsWrapper        = $( '.tabs ' ),
						    tabsContentWrapper = $( '.tabs + ul' );

						tabsWrapper.find( 'li:first-child' ).addClass( 'active' ); //make first tab active
						tabsContentWrapper.children().hide();
						tabsContentWrapper.find( 'li:first-child' ).show();

						tabsWrapper.find( 'a' ).click( function() {
							var $this     = $( this ),
							    targetTab = $this.attr( 'href' ).replace(/.*#(.*)/, "#$1"); //replace is for IE7

							$this.parent().addClass( 'active' ).siblings( 'li' ).removeClass( 'active' );
							$( 'li' + targetTab ).fadeIn().siblings( 'li' ).hide();

							return false;
						} );


						//tour
						if ( $( 'div.tabs-wrapper.vertical.tour' ).length ) {
							$( '<div class="tour-nav"><span class="prev" data-index="-1"></span><span class="next" data-index="1"></span></div>' ).prependTo( '.tabs-wrapper.tour ul.tabs + ul > li' );

							var step02 = $( '.tabs-wrapper.tour ul.tabs li.active' ).next( 'li' ).html();
							$( '.tour-nav .next' ).html( step02 );
							$( '.tour-nav .next a' ).prepend( '<i class="icon-hand-right"></i> ' );

							//change when tab clicked
							$( '.tabs-wrapper.tour ul.tabs a' ).click( function() {
								var $parentWrap   = $( this ).closest( '.tabs-wrapper' ),
								    tourTabActive = $parentWrap.find( 'ul.tabs li.active' ),
								    prevTourTab   = tourTabActive.prev( 'li' ),
								    nextTourTab   = tourTabActive.next( 'li' );

								if ( prevTourTab.length ) {
									$parentWrap.find( '.tour-nav .prev' ).html( prevTourTab.html() ).attr( 'data-index', prevTourTab.index() );
									$parentWrap.find( '.tour-nav .prev a' ).append( ' <i class="icon-hand-left"></i>' );
								} else {
									$parentWrap.find( '.tour-nav .prev' ).html( '' );
								}

								if ( nextTourTab.length ) {
									$parentWrap.find( '.tour-nav .next' ).html( nextTourTab.html() ).attr( 'data-index', nextTourTab.index() );
									$parentWrap.find( '.tour-nav .next a' ).prepend( '<i class="icon-hand-right"></i> ' );
								} else {
									$parentWrap.find( '.tour-nav .next' ).html( '' );
								}
							} );

							//change when tour nav clicked
							$( '.tour-nav span' ).click( function() {
								var $this       = $( this ),
								    $parentWrap = $this.closest( '.tabs-wrapper' ),
								    targetIndex = $this.data( 'index' ),
								    prevTourTab = $parentWrap.find( 'ul.tabs li' ).eq( targetIndex ).prev( 'li' ),
								    nextTourTab = $parentWrap.find( 'ul.tabs li' ).eq( targetIndex ).next( 'li' );
								    targetTab   = $this.find( 'a' ).attr( 'href' );

								$parentWrap.find( 'ul.tabs li' ).eq( targetIndex ).addClass( 'active' ).siblings( 'li' ).removeClass( 'active' );
								$parentWrap.find( 'li' + targetTab ).fadeIn().siblings( 'li' ).hide();

								if ( prevTourTab.length ) {
									$parentWrap.find( '.tour-nav .prev' ).html( prevTourTab.html() ).attr( 'data-index', prevTourTab.index() );
									$parentWrap.find( '.tour-nav .prev a' ).append( ' <i class="icon-hand-left"></i>' );
								} else {
									$parentWrap.find( '.tour-nav .prev' ).html( '' );
								}

								if ( nextTourTab.length ) {
									$parentWrap.find( '.tour-nav .next' ).html( nextTourTab.html() ).attr( 'data-index', nextTourTab.index() );
									$parentWrap.find( '.tour-nav .next a' ).prepend( '<i class="icon-hand-right"></i> ' );
								} else {
									$parentWrap.find( '.tour-nav .next' ).html( '' );
								}

								return false;
							});
						}
					}

				});
			</script>
		<?php
		}
	}


// *****************************************************
// *      ACCORDIONS
// *****************************************************

	//Accordions
	if ( ! function_exists( 'scm_jquery_accordion' ) ) {
		function scm_jquery_accordion(){

			$duration = get_field('tools_accordion_duration', 'option');

		?>
			<script type="text/javascript">
				jQuery(document).ready(function($){

					var duration = <?php echo json_encode($duration); ?>;

					if ( $( 'div.accordion-wrapper' ).length ) {

						(function() {
							var accordionObject = $( 'div.accordion-wrapper > ul > li' );

							accordionObject.each( function( item ) {
								$( this ).find( '.accordion-heading' ).siblings().wrapAll( '<div class="accordion-content" />' );
							} );

						})();

						$( '.accordion-content' ).slideUp();
						$( 'div.accordion-wrapper > ul > li:first-child .accordion-content' ).slideDown().parent().addClass( 'active' );

						$( '.accordion-heading' ).click( function() {
							var $this = $( this );

							$this.next( '.accordion-content' ).slideDown().parent().addClass( 'active' ).siblings( 'li' ).removeClass( 'active' );
							$this.closest( '.accordion-wrapper' ).find( 'li:not(.active) > .accordion-content' ).slideUp();
						} );

						//Automatic accordion
						var hoveringElements = $( 'div.accordion-wrapper.auto > ul' ),
						    notHovering      = true;

						hoveringElements.hover( function() {
							notHovering = false;
						}, function() {
							notHovering = true;
						});

						function autoAccordionFn() {
							if ( notHovering === true ) {

							var $this         = $( 'div.accordion-wrapper.auto > ul' ),
							    count         = $this.children().length,
							    currentActive = $this.find( 'li.active' ),
							    currentIndex  = currentActive.index() + 1,
							    nextIndex     = ( currentIndex + 1 ) % count;

							$this.find( 'li' ).eq( nextIndex - 1 ).find( '.accordion-heading' ).trigger( 'click' );

							}
						} // /autoAccordionFn

						var autoAccordion = setInterval( autoAccordionFn, duration );
					}

				});
			</script>
		<?php
		}
	}


// *****************************************************
// *      TOGGLE
// *****************************************************

	//Toggle
	if ( ! function_exists( 'scm_jquery_toggle' ) ) {
		function scm_jquery_toggle(){

		?>
			<script type="text/javascript">
				jQuery(document).ready(function($){

					if ( $( 'div.toggle-wrapper' ).length ) {

						(function() {
							var toggleObject = $( 'div.toggle-wrapper' );

							toggleObject.each( function( item ) {
								$( this ).find( '.toggle-heading' ).siblings().wrapAll( '<div class="toggle-content" />' );
							} );

						})();

						$( 'div.toggle-wrapper' ).not( '.active' ).find( 'div.toggle-content' ).slideUp();

						$( '.toggle-heading' ).click( function() {
							var $this = $( this );

							if ( $this.hasClass( 'animation-fade' ) )
								$this.next( 'div.toggle-content' ).toggle().css({ opacity: 0 }).animate({ opacity: 1 }, 800 ).parent().toggleClass( 'active' );
							else
								$this.next( 'div.toggle-content' ).slideToggle().parent().toggleClass( 'active' );
						});
					}

				});
			</script>
		<?php
		}
	}


// *****************************************************
// *      ISOTOPE FILTER
// *****************************************************

	//Isotope Filter
	if ( ! function_exists( 'scm_jquery_isotope_filter' ) ) {
		function scm_jquery_isotope_filter(){

		?>
			<script type="text/javascript">
				jQuery(document).ready(function($){

					if ( $().isotope ) {
						var $filteredContent  = $( '.filter-this' ),
						    isotopeLayoutMode = $filteredContent.data( 'layout-mode' );

						if ( $filteredContent.hasClass( 'wrap-projects' ) ) {
							var itemWidth = $filteredContent.find( 'article:first-child' ).outerWidth();
							$filteredContent.width( '101%' ).find( 'article' ).width( itemWidth );
						}

						function runIsotope() {
							$filteredContent.isotope( {
									layoutMode : isotopeLayoutMode
								} );

							//filter items when filter link is clicked
							$( '.wrap-filter a' ).click( function() {
									var $this = $( this ),
									    selector = $this.data( 'filter' );

									$this.closest( '.filterable-content' ).find( '.filter-this' ).isotope( { filter: selector } );
									$this.addClass( 'active' ).parent( 'li' ).siblings( 'li' ).find( 'a' ).removeClass( 'active' );

									return false;
								} );

							$( '.filter-this .toggle-wrapper' ).click( function() {
									$( '.filter-this' ).isotope( 'layout' );
								} );
						}; // /runIsotope

						if ( $( 'html' ).hasClass( 'ie' ) ) {
							runIsotope();
						} else {
							$filteredContent.imagesLoaded( function() {
								runIsotope();
							} );
						}
					}

				});
			</script>
		<?php
		}
	}

// *****************************************************
// *      ACTIVE CLASS
// *****************************************************

	//Active Class
    if ( ! function_exists( 'scm_jquery_active_class' ) ) {
        function scm_jquery_active_class(){

            //$active = scm_option('directory','active');
            //$lang = ( function_exists('pll_current_language') ? pll_current_language() : '' );
            //$url = 'a[href="' . SCM_URL;
            
        ?>
            <script type="text/javascript">
				jQuery(document).ready(function($){

				// Assegno classe .active a pulsanti che portano alla pagina archivio caricata
                    var anchor = window.location.toString().split('?')[0];
                    anchor = anchor.split('page')[0];
                    var obj = $('a[href="' + anchor + '"]');

                    if(obj){
                        obj.addClass("active");
                    }

                    if(anchor.charAt(anchor.length-1) == '/') anchor = anchor.substring(0,anchor.length-1);
                    obj = $('a[href="' + anchor + '"]');
                    if(obj){
                        obj.addClass("active");
                    }
                       /*       
                // Assegno classe .active da scm_option('directory','active')
                    var url = <?php echo json_encode($url); ?>;
                    var lang = <?php echo json_encode($lang); ?>;
                    var active = <?php echo json_encode($active); ?>;
                    
                    for (var key in active) {

                        var slugs = active[key];
                        var slug = null;
                        for (var i=0; i < slugs.length; i++) {
                            if(anchor.search(slugs[i]) >= 0){   // DA RIVEDERE - CUSTOM TYPE potrebbe avere un campo LEGAME e quindi diventare ACTIVE quando una pagina LEGATA attiva...
                                slug = 1;
                                break;
                            }
                        }
                        if(!slug) return;

                        var objA = $(url + key + '"]');
                        var objB = $(url + key + '/"]');
                        if(!objA && !objB){
                            objA = $(url + lang + '/' + key + '"]');
                            objB = $(url + lang + '/' + key + '/"]');
                            if(!objA && !objB) return;
                        }

                        if(objA) objA.addClass("active");
                        if(objB) objB.addClass("active");
                    }*/
                     
                });
            </script>
         <?php
        }
    }

// *****************************************************
// *      GOOGLE MAPS
// *****************************************************

	//Google Maps
	if ( ! function_exists( 'scm_jquery_google_map' ) ) {
		function scm_jquery_google_map(){

			$map_class = '.scm-map';
			$marker_class = '.scm-marker';
			$marker_img = ( get_field( 'tools_gmap_marker', 'option' ) ?: false );

		?>
			<script type="text/javascript">

				jQuery(document).ready(function($){

					function render_map( $el, $marker_class ) {

						var style = [
							{
								featureType: 'all',
								elementType: 'all',
								stylers: [
									{ saturation: -30 },
									{ visibility: 'simplified' }
								]
							},
							{
								featureType: 'all',
								elementType: 'labels.icon',
								stylers: [
								  { visibility: 'off' }
								]
							},
							{
								featureType: 'administrative.province',
								elementType: 'all',
								stylers: [
									{ visibility: 'off' }
								]
							},
							{
								featureType: 'administrative.country',
								elementType: 'labels',
								stylers: [
								  { visibility: 'off' },
								]
							},
							{
								featureType: 'administrative.neighborhood',
								elementType: 'labels',
								stylers: [
								  { visibility: 'off' },
								]
							},
							{
								featureType: 'administrative.locality',
								elementType: 'labels',
								stylers: [
								  { visibility: 'on' },
									{ weight: 1 },
									{ saturation: -100 },
									{ lightness: 30 },
								]
							},
							{
								featureType: 'administrative.land_parcel',
								elementType: 'labels',
								stylers: [
								  { visibility: 'off' },
								]
							},
							{
								featureType: 'road',
								elementType: 'geometry',
								stylers: [
									{ weight: 1 },
									{ saturation: -100 },
									{ lightness: 50 },
								]
							},
				        ];

				        var zoom = parseFloat($el.attr('data-zoom'));

				        var args = {
				        	center: new google.maps.LatLng(0, 0),
							zoom: zoom,
							draggableCursor : 'crosshair',
						    draggingCursor  : 'crosshair',
						    styles                : style,
						    panControl            : false,
						    zoomControl           : true,
						    mapTypeControl        : false,
						    scaleControl          : false,
						    streetViewControl     : true,
						    overviewMapControl    : true,
						    rotateControl         : true,
						    scrollwheel           : false,
						    zoomControlOptions    : {
						        style    : google.maps.ZoomControlStyle.SMALL,
						        position : google.maps.ControlPosition.RIGHT_CENTER
						      },							
				        };

				        var $markers = $el.find($marker_class);

						var map = new google.maps.Map( $el[0], args);

						var infowindow = new google.maps.InfoWindow({
							content		: '',
							maxWidth	: 500
						});

						map.markers = [];
						$markers.each(function(){
					    	add_marker( $(this), map, infowindow );
						});

						center_map( map, zoom );
						
						google.maps.event.addListener(map, 'tilesloaded', function() {
							$( 'body' ).trigger( 'mapLoaded' );
						});
					}

					function add_marker( $marker, map, infowindow ) {

						var latlng = new google.maps.LatLng( $marker.attr('data-lat'), $marker.attr('data-lng') );

						// +++ todo: Markers personalizzabili
						// if not data-img in scm-marker, then get it from general options

						var marker_A = $marker.attr('data-img');
						var marker_B = <?php echo json_encode($marker_img); ?>;

						var marker_img = false;
						if( marker_A )
							marker_img = marker_A;
						else if( marker_B )
							marker_img = marker_B;
						
						//var image = new google.maps.MarkerImage(
								//marker_img
								//<?php echo json_encode(SCM_URI_CHILD); ?> + 'assets/img/marker.png',
								/*new google.maps.Size( 24, 42 ),
								new google.maps.Point( 0, 0 ),
								new google.maps.Point( 12, 42 )*/
							//);
						/*
						var shadow = new google.maps.MarkerImage(
								themeImgs + 'map/marker-shadow.png',
								new google.maps.Size( 58, 44 ),
								new google.maps.Point( 0, 0 ),
								new google.maps.Point( 16, 44 )
							);

						var shape = {
								coord : [20,0,23,1,24,2,25,3,27,4,27,5,28,6,29,7,29,8,30,9,30,10,31,11,31,12,31,13,31,14,31,15,31,16,31,17,31,18,31,19,31,20,31,21,30,22,30,23,29,24,29,25,28,26,28,27,27,28,27,29,26,30,25,31,25,32,24,33,23,34,22,35,22,36,21,37,20,38,20,39,19,40,18,41,17,42,16,43,15,43,14,42,13,41,12,40,11,39,11,38,10,37,9,36,9,35,8,34,7,33,6,32,6,31,5,30,4,29,4,28,3,27,3,26,2,25,2,24,1,23,1,22,0,21,0,20,0,19,0,18,0,17,0,16,0,15,0,14,0,13,0,12,0,11,1,10,1,9,2,8,2,7,3,6,4,5,4,4,6,3,7,2,8,1,11,0,20,0],
								type  : 'poly'
							};
						*/

						var marker = new google.maps.Marker({
							raiseOnDrag : false,
							clickable   : true,
							//icon        : image,
							//shadow      : shadow,
							//shape       : shape,
							cursor      : 'pointer',
							animation   : google.maps.Animation.BOUNCE,
							position	: latlng,
							map			: map
						});

						if ( marker_img )
							marker.setIcon( marker_img );

						map.markers.push( marker );

						if( $marker.html() ){
							google.maps.event.addListener(marker, 'click', function() {
								infowindow.close();
								infowindow.setContent($marker.html());
								infowindow.open( map, marker );
							});
						}
					}

					function center_map( map, zoom ) {

						var bounds = new google.maps.LatLngBounds();

						$.each( map.markers, function( i, marker ){
							var latlng = new google.maps.LatLng( marker.position.lat(), marker.position.lng() );
							bounds.extend( latlng );
						});

						if( map.markers.length == 1 ){
						    map.setCenter( bounds.getCenter() );
						    map.setZoom( zoom );
						}else{
							google.maps.event.addListener(map, 'zoom_changed', function() {
							    zoomChangeBoundsListener = 
							        google.maps.event.addListener(map, 'bounds_changed', function(event) {
							            if (this.getZoom() > zoom && this.initialZoom == true) {
							                // Change max/min zoom here
							                this.setZoom(zoom);
							                this.initialZoom = false;
							            }
							        google.maps.event.removeListener(zoomChangeBoundsListener);
							    });
							});
							map.initialZoom = true;
							map.fitBounds(bounds);
						}
					}
					
					var mapClass = <?php echo json_encode($map_class); ?>;
					var markerClass = <?php echo json_encode($marker_class); ?>;

					$(window).load(function(){

						if( $(mapClass).length ){
							<?php wp_enqueue_script( 'gmapapi' ); ?>		// ENQUEUE GM SCRIPT IF MAP IS ON PAGE
						}

						$(mapClass).each(function(){

							render_map( $(this) , markerClass );

						});
					});

				});
			</script>
		<?php
		}
	}

// *****************************************************
// *      NIVO SLIDER
// *****************************************************

	//Nivo Slider
    if ( ! function_exists( 'scm_jquery_nivoslider' ) ) {
        function scm_jquery_nivoslider(){
        	if( !get_field( 'tools_nivo_active', 'option' ) )
        		return;
        	global $is_iphone, $is_gecko;

        ?>
            <script type="text/javascript">

            	jQuery(document).ready(function($){

            		$('.slider').each(function(){
            			var slides = $(this).find('img').length;
            			if( slides > 0 ){
            				$(this).find('img').css( 'display', 'none' );
            				var img = $(this).find('img')[0];
	            			$(img).css( 'display', 'block' );
	            		}
            		});

            		$(window).load( setNivoSlider );
            		//$( 'body' ).on( 'windowLoaded', setNivoSlider );

            		function captionMoveIn(elem,pos) {

						$(elem + ' .nivo-caption').removeClass( 'from-left' );
						$(elem + ' .nivo-caption').addClass( 'from-right' );
						$(elem + ' .nivo-caption').removeClass( 'from-right', 500 );

					};

					function captionMoveOut(elem,pos) {
						
						$(elem + ' .nivo-caption').addClass( 'from-left', 500 );

					};

					function setNivoSlider(){

						var is_iphone = <?php echo json_encode($is_iphone); ?>;
	        			var is_gecko = <?php echo json_encode($is_gecko); ?>;

		        		var touch = ( Modernizr.touchEvents || Modernizr.touch || is_iphone );

						$('.slider').each(function(){
	            			var slides = $(this).find('img').length;
	            			if( slides > 1 )
	            				$(this).addClass('nivoSlider');
	            		});
						$('.nivoSlider').each(function(){
							$(this).find('img').css( 'display', 'block' );
							var id = '#' + $(this).attr( 'id' );
	        				$(this).nivoSlider({
							    effect: 'sliceDownLeft',            // Specify sets like: 'fold,fade,sliceDown'
							    slices: 15,                     // For slice animations
							    boxCols: 8,                     // For box animations
							    boxRows: 4,                     // For box animations
							    animSpeed: 500,                 // Slide transition speed
							    pauseTime: 5000,                // How long each slide will show
							    startSlide: 0,                  // Set starting Slide (0 index)
							    directionNav: true,             // Next & Prev navigation
							    controlNav: false,              // 1,2,3... navigation
							    controlNavThumbs: false,        // Use thumbnails for Control Nav
							    pauseOnHover: true,             // Stop animation while hovering
							    manualAdvance: false,           // Force manual transitions
							    prevText: 'Prev',               // Prev directionNav text
							    nextText: 'Next',               // Next directionNav text
							    randomStart: false,             // Start on a random slide
							    beforeChange: function(){       // Triggers before a slide transition

							    	captionMoveOut( id, 'before' );

							    },
							    afterChange: function(){        // Triggers after a slide transition

							    	captionMoveIn( id, 'after' );

							    },
							    slideshowEnd: function(){       // Triggers after all slides have been shown

							    },
							    lastSlide: function(){          // Triggers when last slide is shown

							    },
							    afterLoad: function(){          // Triggers when slider has loaded
							    	//$(this).on('swipeleft', toggleOff );
							    	captionMoveIn( id, 'load' );
							    	$( 'body' ).trigger( 'nivoLoaded', [ this ] );

							    }
							});

							if( touch && !is_gecko ){

								$('a.nivo-nextNav').css('visibility', 'hidden');
								$('a.nivo-prevNav').css('visibility', 'hidden');
							}

							$( this ).swipe( {
							
						        swipeLeft: function( event, direction, distance, duration, fingerCount ) {
						        	//$(this).find('img').attr("data-transition","sliceDownLeft");
									$('a.nivo-nextNav').trigger('click');
									event.stopPropagation();

						        },
						        swipeRight: function( event, direction, distance, duration, fingerCount ) {
						        	$(this).find('img').attr("data-transition","sliceDown");
					                $('a.nivo-prevNav').trigger('click');
					                $(this).find('img').attr("data-transition","sliceDownLeft");
						        	event.stopPropagation();

						        },
						        threshold: 10,
						        excludedElements: ''
								
							});
							
		        		});

	            	}
            	});

			</script>
		<?php
		}
	}

// *****************************************************
// *      FANCYBOX
// *****************************************************

	//Fancybox
    if ( ! function_exists( 'scm_jquery_fancybox' ) ) {
        function scm_jquery_fancybox(){
        	
        	if( !get_field( 'tools_fancybox_active', 'option' ) )
        		return;

        	global $SCM_galleries;

        ?>
            <script type="text/javascript">

            jQuery(document).ready(function($){

            	var elements = $('.scm-gallerie');
            	
            	if( !elements.length )
            		return false;

				var galleries = <?php echo json_encode( $SCM_galleries ); ?>;

				function addLinks() {
				    var list = $("#fancybox-links");
				    
				    if (!list.length) {    
				        list = $('<ul id="fancybox-links">');
				    
				        for (var i = 0; i < this.group.length; i++) {
				            $('<li data-index="' + i + '"><label></label></li>').click(function() { $.fancybox.jumpto( $(this).data('index'));}).appendTo( list );
				        }
				        
				        list.appendTo( 'body' );
				    }

				    list.find('li').removeClass('active').eq( this.index ).addClass('active');
				}

				function removeLinks() {
				    $("#fancybox-links").remove();    
				}

				elements.map(function(index) {
					var id = this.id;
					
					var elem = galleries[id];
					var init = elem['init'];
					var name = elem['title'];
					var gallery = elem['gallery'];

					var images = [];
					var titles = [];
					var descriptions = [];

					for (var i = 0; i < gallery.length; i++) {
						images.push( {
							href: gallery[i]['url'],
						});
						titles.push(gallery[i]['title']);
						descriptions.push(gallery[i]['description']);
					};

					$(this).click(function() {
	    
					    $.fancybox.open(
					    	images,
					    	{
					    		padding: 0,
					    		helpers: {
					    			overlay: {
					    				css : {
							                'background' : 'rgba(0, 0, 0, 0.85)',
							            },
					    			},
						   		},
						   		openEffect: 'elastic',
						   		closeEffect: 'elastic',
						   		nextEffect: 'elastic',
						   		prevEffect: 'elastic',
						   		openEasing: 'easeOutSine',
						   		closeEasing: 'easeInSine',
						   		nextEasing: 'easeOutSine',
						   		prevEasing: 'linear',
						   		openSpeed: 250,
						   		closeSpeed: 250,
						   		nextSpeed: 550,
						   		prevSpeed: 200,
						   		openOpacity: false,
						   		closeOpacity: false,
						   		tpl: {
						   			wrap: '<div class="fancybox-wrap" tabIndex="-1"><h1 class="text-center">' + name + '</h1><div class="fancybox-skin"><div class="fancybox-outer"><div class="fancybox-inner"></div></div></div></div>',
						   		},
						   		afterLoad: addLinks,
	    						beforeClose: removeLinks,
					    	}
					    );
					    
					    return false;
					    
					});
				});
			});
			
            </script>
         <?php
        }
    }

// *****************************************************
// *      RESPONSIVE LAYOUT
// *****************************************************

	//Responsive Layout On Resize Window
	if ( ! function_exists( 'scm_responsive_layout' ) ) {
	    function scm_responsive_layout() {
		?>
			<script type="text/javascript">
				jQuery(document).ready(function($){

					function responsiveClasses(){

						var w = $(window).width();
						var a = '';
						var r = '';

						if( w > 700 ){

							a += 'desktop r1400 ';
							r += 'smart smartmid smartmin smartmicro ';

							if( w < 1401 ) a += 'r1120 ';
							else r += 'r1120 ';

							if( w < 1121 ) a += 'tablet landscape r1030 ';
							else r += 'tablet landscape r1030 ';

							if( w < 1031 ) a += 'r940 ';
							else r += 'r940 ';

							if( w < 941 ) a += 'r800 ';
							else r += 'r800 ';

							if( w < 801 ) a += 'portrait r700 ';
							else r += 'portrait r700 ';

						}else{

							a += 'tablet smart ';
							r += 'desktop landscape portrait r1400 r1120 r1030 r940 r800 r700 ';							

							if( w < 401 ) a += 'smartmicro ';
							else r += 'smartmicro ';

							if( w < 501 ) a += 'smartmin ';
							else r += 'smartmin ';
							
							if( w < 601 ) a += 'smartmid ';
							else r += 'smartmid ';

						}

						/*if ( !$( 'body' ).hasClass('smart') && a.indexOf('smart') >= 0 )
							$( 'body' ).trigger( 'responsiveSmart', [ 'smart' ] );
						else if( (!$( 'body' ).hasClass('portrait') && a.indexOf('portrait') >= 0) || ($( 'body' ).hasClass('smart') && r.indexOf('smart') >= 0) )
							$( 'body' ).trigger( 'responsivePortrait', [ 'portrait' ] );
						else if( (!$( 'body' ).hasClass('landscape') && a.indexOf('landscape') >= 0) || ($( 'body' ).hasClass('portrait') && r.indexOf('portrait') >= 0) )
							$( 'body' ).trigger( 'responsiveLandscape', [ 'landscape' ] );
						else if( (!$( 'body' ).hasClass('desktop') && a.indexOf('desktop') >= 0) || ($( 'body' ).hasClass('landscape') && r.indexOf('landscape') >= 0) )
							$( 'body' ).trigger( 'responsiveDesktop', [ 'desktop' ] );*/

						

						var cl1 = $('body').attr('class');

						$('body').removeClass( r );
						$('body').addClass( a );

						var cl2 = $('body').attr('class');

						if(cl1 != cl2){
							var state = 'all';
							if ( $( 'body' ).hasClass( 'smart' ) )			state = 'smart';
							else if( $( 'body' ).hasClass( 'portrait' ) )	state = 'portrait';
							else if( $( 'body' ).hasClass( 'landscape' ) )	state = 'landscape';
							else if( $( 'body' ).hasClass( 'desktop' ) )	state = 'desktop';

							$( 'body' ).trigger( 'responsive', [ state ] );
						}

					}
					

					responsiveClasses();

					$(window).resize( responsiveClasses );

				});
			</script>

		<?php
		}
	}

// *****************************************************
// *      CHANGE PAGE
// *****************************************************

	//Change Page
    if ( ! function_exists( 'scm_jquery_change_page' ) ) {
        function scm_jquery_change_page(){

        	$map_class = '.scm-map';
        	$fadeIn = (get_field('fader_active', 'option') ?: 0);
        	$fadeOut = (get_field('fader_out_active', 'option') ?: 0);
        	$duration = (get_field('fader_duration', 'option') ?: 0);
			$waitfor = (get_field('fader_waitfor', 'option') ?: '');

        ?>
            <script type="text/javascript">

            jQuery(document).ready(function($){

            	var mapClass = <?php echo json_encode($map_class); ?>;
            	var fadeIn = <?php echo json_encode($fadeIn); ?>;
            	var fadeOut = <?php echo json_encode($fadeOut); ?>;
            	var duration = <?php echo json_encode($duration); ?>;
            	var waitfor = <?php echo json_encode($waitfor); ?>;


            	function bodyLink(link){
            		window.location.replace( link );
            	}

            	function bodyIn(event){
					
					if( fadeIn ){

		            	$('body').animate({
							opacity: 1,
						}, duration * 1000, function() {
							$('body').css('pointer-events', 'all');
						});

	            	}else{

						$( 'body' ).css({
		            		'opacity' : '1',
							'pointer-events' : 'all'
		            	});

	        		}

        		}

        		function bodyOut(event, elem, link){
        			
        			event.preventDefault();

        			$('body').css('pointer-events', 'none');

        			if(fadeOut){
						$('body').animate({
							opacity: 0,
						}, duration * 1000, function() {
							bodyLink(link);
						});
					}else{
						bodyLink(link);
					}
        		}

				switch( waitfor ){
					case 'window':
						$( 'body' ).on( 'windowLoaded', bodyIn );
					break;
					case 'images':
						$( 'body' ).imagesLoaded( bodyIn );
					break;
					case 'sliders':
						if( $( '.nivoSlider' ).length )
							$( 'body' ).on( 'nivoLoaded', bodyIn );
						else
							$( 'body' ).imagesLoaded( bodyIn );
					break;
					case 'maps':
						if( $( mapClass ).length > 0 )
							$( 'body' ).on( 'mapLoaded', bodyIn );
						else
							$( 'body' ).imagesLoaded( bodyIn );
					break;
					default:
						bodyIn();
					break;
				}
				
				$( 'body' ).on( 'linkSite', bodyOut );

			});
			
            </script>
         <?php
        }
    }


?>