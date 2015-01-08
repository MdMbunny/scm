<?php

//*****************************************************
//*
//	IE fixes
//	Youtube Embed Fix
//	Toggle Menu
//	Sticky Menu
//	Smooth Scroll
//	Single Page Nav
//	Tabs
//	Accordions
//	Toggles
//	Slideshow
//	Isotope Filter
//	Active Class
//  Responsive Layout
//  Google Maps
//	Prettyphoto
//
//	Show Body
//*
//*****************************************************


// *****************************************************
// ******* ACTIONS AND FILTERS
// *****************************************************

	add_action('wp_footer', 'scm_jquery_ie_fixes');
	add_action('wp_footer', 'scm_jquery_youtube_fix');
	add_action('wp_footer', 'scm_jquery_toggle_menu');
	add_action('wp_footer', 'scm_jquery_sticky_menu');
	add_action('wp_footer', 'scm_jquery_smooth_scroll');
	add_action('wp_footer', 'scm_jquery_single_page_nav');
	add_action('wp_footer', 'scm_jquery_tabs');
	add_action('wp_footer', 'scm_jquery_accordion');
	add_action('wp_footer', 'scm_jquery_toggle');
	add_action('wp_footer', 'scm_jquery_slideshow');
	add_action('wp_footer', 'scm_jquery_isotope_filter');
	//add_action('wp_footer', 'scm_jquery_active_class');
	add_action('wp_footer', 'scm_responsive_layout');
	add_action('wp_footer', 'scm_jquery_google_map');
	add_action('wp_footer', 'scm_jquery_prettyphoto');

	add_action('wp_footer', 'scm_jquery_change_page');


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

			$menu = ( get_field('id_menu', 'option') ? get_field('id_menu', 'option') : 'site-navigation' );
			$sticky_menu = $menu . '-sticky';

		?>
			<script type="text/javascript">
			
				jQuery(document).ready(function($){

					var sticky_menu = '#' + <?php echo json_encode($sticky_menu); ?>;

					var container, button, menu;

					container = $( sticky_menu );

					if ( ! container ) {
						return;
					}

					button = $( '.menu-toggle' );

					if ( 'undefined' === typeof button ) {
						return;
					}

					menu = $( sticky_menu + ' ul' );

					// Hide menu toggle button if menu is empty and return early.
					if ( 'undefined' === typeof menu ) {
						$button.css( 'display', 'none' );
						return;
					}

					menu.attr( 'aria-expanded', 'false' );

					container.mouseover( toggleOn );
					container.mouseout( toggleOff );

					button.click( toggleOff );

					$( sticky_menu + ' row > ul > li > a' ).click( toggleOff );

					var now = (-90).toString();

					function toggleOn(){
						if( $('body').hasClass('smart') && !container.hasClass( 'toggled' ) ){

							$( '.sticky-toggle' ).css( 'display', 'none' );
							$( '.sticky-icon' ).css( 'display', 'inline-block' );

							container.addClass( 'toggled' );
							button.attr( 'aria-expanded', 'true' );
							menu.attr( 'aria-expanded', 'true' );
							container.css( 'cursor', 'pointer' );
						}
					}

					function toggleOff(){						
						if( $('body').hasClass('smart') && container.hasClass( 'toggled' ) ){

							$( '.sticky-toggle' ).css( 'display', 'inline-block' );
							$( '.sticky-icon' ).css( 'display', 'none' );

							container.removeClass( 'toggled' );
							button.attr( 'aria-expanded', 'false' );
							menu.attr( 'aria-expanded', 'false' );
							container.css( 'cursor', 'default' );
						}
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

			$sticky = ( get_field('active_sticky_menu', 'option') ? 1 : 0 );
			$anim = ( get_field('anim_sticky_menu', 'option') ? 1 : 0 );
			$offset = ( get_field('offset_sticky_menu', 'option') ? get_field('offset_sticky_menu', 'option') : 0 );
			$attach = ( get_field('attach_sticky_menu', 'option') ? get_field('attach_sticky_menu', 'option') : 'nav-top' );
			$menu = ( get_field('id_menu', 'option') ? get_field('id_menu', 'option') : 'site-navigation' );
			$sticky_menu = $menu . '-sticky';

		?>

			<script type="text/javascript">
			
				jQuery(document).ready(function($){
					
					var menu = '#' + <?php echo json_encode($menu); ?>;
					var sticky_menu = '#' + <?php echo json_encode($sticky_menu); ?>;
					var sticky = <?php echo json_encode($sticky); ?>;
					var anim = <?php echo json_encode($anim); ?>;
					var offset = <?php echo json_encode($offset); ?>;
					var attach = <?php echo json_encode($attach); ?>;
					
					if(sticky){
						
						$(sticky_menu).css( 'top', -$(sticky_menu).outerHeight() );
						
						if( anim ){
							$(sticky_menu).css({
								'visibility' : 'hidden',
							});
						}else{
							$(sticky_menu).css({
								'-webkit-transition' : 'none',
								'transition' : 'none',
							});
						}

						if( attach == 'nav-top'){
							offset += $(menu).offset().top;
						}else if( attach == 'nav-bottom'){
							offset += $(menu).offset().top + $(menu).outerHeight();
						}

						$(sticky_menu).affix(
							{ offset: { top: parseInt(offset) } }
						);

						var w = $(window).width();

						if( w < 701 ){
							$( '.sticky-toggle' ).css( 'display', 'inline-block' );
							$( '.sticky-icon' ).css( 'display', 'none' );
							$( '.sticky-image' ).css( 'display', 'none' );
						}else if( w < 941 ){
							$( '.sticky-toggle' ).css( 'display', 'none' );
							$( '.sticky-image' ).css( 'display', 'none' );
							$( '.sticky-icon' ).css( 'display', 'inline-block' );
						}else{
							$( '.sticky-toggle' ).css( 'display', 'none' );

							if( $( '.sticky-image' ) ){
								$( '.sticky-image' ).css( 'display', 'inline-block' );
								$( '.sticky-icon' ).css( 'display', 'none' );
							}else{
								$( '.sticky-icon' ).css( 'display', 'inline-block' );
								$( '.sticky-image' ).css( 'display', 'none' );
							}
						}

						$( 'body' ).on( 'responsiveSmart', function(){
							$( '.sticky-toggle' ).css( 'display', 'inline-block' );
							$( '.sticky-icon' ).css( 'display', 'none' );
							$( '.sticky-image' ).css( 'display', 'none' );
						} );

						$( 'body' ).on( 'responsiveTablet', function(){
							$( '.sticky-toggle' ).css( 'display', 'none' );
							$( '.sticky-image' ).css( 'display', 'none' );
							$( '.sticky-icon' ).css( 'display', 'inline-block' );
						} );

						$( 'body' ).on( 'responsiveDesktop', function(){
							$( '.sticky-toggle' ).css( 'display', 'none' );

							if( $( '.sticky-image' ) ){
								$( '.sticky-image' ).css( 'display', 'inline-block' );
								$( '.sticky-icon' ).css( 'display', 'none' );
							}else{
								$( '.sticky-icon' ).css( 'display', 'inline-block' );
								$( '.sticky-image' ).css( 'display', 'none' );
							}

						} );

					}

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
					
					$( 'a' ).click( function() {
						if ( location.pathname.replace( /^\//,'' ) === this.pathname.replace( /^\//,'' ) && location.hostname === this.hostname ) {

							var time = <?php echo json_encode($duration); ?>;
							var offset = <?php echo json_encode($offset); ?>;
							var ease = <?php echo json_encode($ease); ?>;
							
							var win = $( window ).height();
							var height = $( 'body' ).height();
							var position = $( 'body' ).scrollTop();

							var target = $( this.hash );
							var name = this.hash.slice( 1 );
							var destination;
							target = target.length ? target : $( '[name=' + name +']' );

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
					});

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

			$active = get_field( 'tools_singlepagenav_active', 'option' );
			$interval = get_field( 'tools_singlepagenav_interval', 'option' );
			$offset = get_field( 'tools_singlepagenav_offset', 'option' );

		?>
			<script type="text/javascript">
				jQuery(document).ready(function($){

					var active = <?php echo json_encode($active); ?>;
					var interval = <?php echo json_encode($interval); ?>;
					var offset = <?php echo json_encode($offset); ?>;

					$('#site-navigation-sticky').singlePageNav({
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
// *      SLIDESHOW
// *****************************************************

	//Slideshow
	if ( ! function_exists( 'scm_jquery_slideshow' ) ) {
		function scm_jquery_slideshow(){

		?>
			<script type="text/javascript">
				jQuery(document).ready(function($){

					if ( $().flexslider ) {
						var $containerF = $( '.slideshow.flexslider' ),
						    slideSpeed  = $containerF.data( 'time' );

						if ( $('html').hasClass('ie') ) {
							$containerF.flexslider( {
								animation      : "slide",
								easing         : "swing",
								direction      : "horizontal",
								slideshowSpeed : slideSpeed,
								smoothHeight   : true,
								animationSpeed : 400,
								pauseOnAction  : true,
								pauseOnHover   : true,
								useCSS         : true,
								touch          : true,
								video          : false,
								controlNav     : false,
								directionNav   : true,
								keyboard       : true,
								pausePlay      : false
							} );
						} else {
							$containerF.imagesLoaded( function() {
								$containerF.flexslider( {
									animation      : "slide",
									easing         : "swing",
									direction      : "horizontal",
									slideshowSpeed : slideSpeed,
									smoothHeight   : true,
									animationSpeed : 400,
									pauseOnAction  : true,
									pauseOnHover   : true,
									useCSS         : true,
									touch          : true,
									video          : false,
									controlNav     : false,
									directionNav   : true,
									keyboard       : true,
									pausePlay      : false
								} );
							} );
						}
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

							if( w < 1121 ) a += 'r940 ';
							else r += 'r940 ';

							if( w < 941 ){
								a += 'tablet r800 ';
								if ( !$( 'body' ).hasClass('tablet') || $( 'body' ).hasClass('smart') )
									$( 'body' ).trigger('responsiveTablet');
							}else{
								r += 'tablet r800 ';
								if ( $( 'body' ).hasClass('tablet') || !$( 'body' ).hasClass('desktop') )
									$( 'body' ).trigger('responsiveDesktop');
							}

							if( w < 801 ) a += 'r700 ';
							else r += 'r700 ';

						}else{

							a += 'tablet smart ';
							r += 'desktop r1400 r1120 r940 r800 r700 ';

							if ( !$( 'body' ).hasClass('smart') )
								$( 'body' ).trigger('responsiveSmart');

							if( w < 401 ) a += 'smartmicro ';
							else r += 'smartmicro ';

							if( w < 501 ) a += 'smartmin ';
							else r += 'smartmin ';
							
							if( w < 601 ) a += 'smartmid ';
							else r += 'smartmid ';

							if ( !$( 'body' ).hasClass('smart') )
								$( 'body' ).trigger('responsiveSmart');

						}

						$('body').removeClass( r );
						$('body').addClass( a );
					}

					responsiveClasses();

					$(window).resize( responsiveClasses );


					
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

				        var args = {
				        	center:new google.maps.LatLng(0, 0),
							zoom:4,
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
						
						map.markers = [];
						$markers.each(function(){
					    	add_marker( $(this), map );
						});

						center_map( map, 10 );
						
						google.maps.event.addListener(map, 'tilesloaded', function() {

							$( 'body' ).trigger( 'mapLoaded' );

						});
					}

					function add_marker( $marker, map ) {

						var latlng = new google.maps.LatLng( $marker.attr('data-lat'), $marker.attr('data-lng') );
						var marker = new google.maps.Marker({
							position	: latlng,
							map			: map
						});

						map.markers.push( marker );

						if( $marker.html() ){
							var infowindow = new google.maps.InfoWindow({
								content		: $marker.html()
							});

							google.maps.event.addListener(marker, 'click', function() {
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
							map.fitBounds( bounds );
						}
					}
					
					var mapClass = <?php echo json_encode($map_class); ?>;
					var markerClass = <?php echo json_encode($marker_class); ?>;

					$(window).load(function (){
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
// *      PRETTYPHOTO
// *****************************************************

	//Prettyphoto
    if ( ! function_exists( 'scm_jquery_prettyphoto' ) ) {
        function scm_jquery_prettyphoto(){
        	global $SCM_galleries;
        ?>
            <script type="text/javascript">

            jQuery(document).ready(function($){

            	var elements = $('.scm-gallerie');
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
// *      CHANGE PAGE
// *****************************************************

	//Change Page
    if ( ! function_exists( 'scm_jquery_change_page' ) ) {
        function scm_jquery_change_page(){

        	$map_class = '.scm-map';
        	$fader = (get_field('fader_active', 'option') ? get_field('fader_active', 'option') : 0);
        	$duration = (get_field('fader_duration', 'option') ? get_field('fader_duration', 'option') : 0);

        ?>
            <script type="text/javascript">

            jQuery(document).ready(function($){

            	var mapClass = <?php echo json_encode($map_class); ?>;
            	var fader = <?php echo json_encode($fader); ?>;
            	var duration = <?php echo json_encode($duration); ?>;

				if(!fader){
            	
	            	$( 'body' ).css({
	            		'opacity' : '1',
						'pointer-events' : 'all'
	            	});
					
					return;
				}
            	            	
            	if(!$(mapClass).length){
            		bodyIn();
        		}else{
	        		$( 'body' ).on( 'mapLoaded', bodyIn );
	        	}
			
            	$('a').click(function() {
            		if ( location.pathname.replace( /^\//,'' ) !== this.pathname.replace( /^\//,'' ) && location.hostname === this.hostname ) {
						bodyOut(this);
					}

				});

				function bodyIn(){
        			$('body').animate({
						opacity: 1,
					}, duration * 1100, function() {
						$('body').css('pointer-events', 'all');
					});
        		}

        		function bodyOut(a){
        			event.preventDefault();

					var link = String(a.href);

					$('body').css('pointer-events', 'none');

					$('body').animate({
						opacity: 0,
					}, duration * 1100, function() {
						location.href = link;
					});
        		}

			});
			
            </script>
         <?php
        }
    }


?>