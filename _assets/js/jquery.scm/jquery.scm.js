( function($){

// ******************************************************			
// ******************************************************
	// jQuery READY
// ******************************************************
// ******************************************************

		var GOOGLE_API_KEY;

		var $window;
		var $html;
		var $head;
		var $body;
		var $location;
		var $navigation;
		var $page;

		var href;
		var start;
		var touch;


		// *****************************************************
		// *      INIT
		// *****************************************************

		var initPage = function(){
			$.consoleDebug( DEBUG, '- initPage Start');
			GOOGLE_API_KEY = 'AIzaSyBZEApCxfzuavDWXdJ2DAVAftxbMjZWrVY';

			$window 	= $( window );
			$html 		= $( 'html' );
			$head 		= $( 'head' );
			$body 		= $( 'body' );
			$location 	= $( location );
			$navigation = $( '.navigation' );
			$page 		= $( '.site-page' );

			href 		= $location.attr( 'href' );
			start 		= 'imagesLoaded';
			touch 		= ( typeof Modernizr !== 'undefined' && ( Modernizr.touchEvents || Modernizr.touch ) ) && ( $body.hasClass('is-iphone') || $body.hasClass('is-tablet') || $body.hasClass('is-mobile') );

			$html.removeClass( 'no-js' );

			$body.trigger( 'documentJquery' );
			$.consoleDebug( DEBUG, '- initPage End');
		}

		// *****************************************************
		// *      TOUCH
		// *****************************************************

		var touchEvents = function(){
			$.consoleDebug( DEBUG, '- touchEvents Start');

	        if ( touch ) {
	            $body.addClass( 'touch' );
	            $body.removeClass( 'mouse' );
	        }else{
	            $body.removeClass( 'touch' );
	            $body.addClass( 'mouse' );
	        }

	        if( touch ){

				if( $navigation.attr( 'data-toggle' ) == "true" ){

					$navigation.swipe( {				

				        swipeDown: function( e, direction, distance, duration, fingerCount ) {

				        	var $this 		= $( this ),
				        		$target 	= $( e.target ),
				        		toggle = ( $target.hasClass( '.toggle' ) ? 1 : $target.parents( '.toggle' ).length );

				        	if( toggle ){
			        			$this.toggledOn( e );
			        			e.stopPropagation();
			        		}
			        		
				        },

				        swipeUp: function( e, direction, distance, duration, fingerCount ) {

				        	var $this = $( this ),
				        		$target 	= $( e.target ),
								toggle = ( $target.hasClass( '.toggle' ) ? 1 : $target.parents( '.toggle' ).length );
				        	
				        	if( toggle ){
			        			$this.toggledOff( e );
			        			e.stopPropagation();
			        		}

				        },

				        threshold: 10,
				        excludedElements: '',

				    });
				
				}
				
			}
			$.consoleDebug( DEBUG, '- touchEvents End');
		}

		// *****************************************************
		// *      CHECK URL ANCHOR
		// *****************************************************

		var checkUrlAnchor = function(){
			$.consoleDebug( DEBUG, '- checkUrlAnchor Start');
			if( href.indexOf( '#' ) > -1 ){
				var split = href.split('#')
				$('body').data( 'anchor', split[1] );

				if ( typeof window.history.replaceState == 'function' ) {
					history.replaceState(null, null, split[0]);
					//window.history.replaceState({}, '', location.href.slice(0, -1));
				}else{
					window.location.replace("#");
				}
			}
			$.consoleDebug( DEBUG, '- checkUrlAnchor End');
		}

		// *****************************************************
		// *      START EVENTS
		// *****************************************************

		var startEvents = function(){
			$.consoleDebug( DEBUG, '- startEvents Start');
			switch( $body.data( 'fade-wait' ) ){
				case 'images': break;
				case 'sliders':
					if( $( '.nivoSlider' ).length ) start = 'nivoLoaded';
				break;
				case 'maps':
					if( $( '.scm-map' ).length ) start = 'mapsLoaded';
				break;
				default:
					start = 'documentDone';
				break;
			}

			$body.off( start).on( start, function(e){ $.bodyIn(e); } );
			$.consoleDebug( DEBUG, '- startEvents End');
		}

		// *****************************************************
		// *      LAYOUT EVENTS
		// *****************************************************

		var layoutEvents = function(){
			$.consoleDebug( DEBUG, '- layoutEvents Start');
			$body.off('resizing resized imagesLoaded').on( 'resizing resized imagesLoaded', function(e){
			
				$body.responsiveClasses( e );
				$( '[data-equal]' ).equalChildrenSize();
			
			} );

			
			$body.off('responsive').on( 'responsive', function( e, state ) {
				$( '[data-switch-toggle]' ).switchByData( state, 'switch-toggle', 'toggle', '.toggle-image, .toggle-home' );
				$( '[data-switch]' ).switchByData( state, 'switch' );
				$( '[data-sticky]' ).stickyMenu();
				$( '[data-affix]' ).affixIt();

			} );

			$.consoleDebug( DEBUG, '- layoutEvents End');
		}

		// *****************************************************
		// *      TOGGLE MENU EVENTS
		// *****************************************************

		var navEvents = function(){
			$.consoleDebug( DEBUG, '- navEvents Start');
			$navigation.off( 'toggledOn').on( 'toggledOn', function(e){

				$elems = $( this ).find( '[data-toggle-button="on"]' );
				$elems.css( 'transform', 'rotate(90deg)' );
				$elems.animate( { transform: 'rotate(0deg)' }, 200, 'linear' );

			} );

			$navigation.off( 'toggledOff').on( 'toggledOff', function(e){

				$elems = $( this ).find( '[data-toggle-button="off"]' );
				$elems.css('transform', 'rotate(-90deg)');
				$elems.animate( { transform: 'rotate(0deg)' }, 200, 'linear' );

			} );

			$body.on( 'resizing', function(e){ $( '.toggled' ).toggledOff(e); } );
			$window.off( 'scroll').on( 'scroll', function(e){ $( '.toggled' ).toggledOff(e); } );
			$body.off( 'switchOn').on( 'switchOn', '.toggle', function( e, state ){ $( this ).toggledOff( e, state ) } );
			$page.off( 'click').on( 'click', '.toggle-button', function(e){ $( this ).toggledIt(e); } );
			$page.off( 'mousedown').on( 'mousedown', '*', function(e){ if( e.target == this ){ $( '.toggled' ).toggledOff(e); } } );
			$.consoleDebug( DEBUG, '- navEvents End');
		}

		// *****************************************************
		// *      DEBUG
		// *****************************************************

		var debugEvents = function(){
			$.consoleDebug( DEBUG, '- debugEvents Start');
			/*$body.off('documentDone').on( 'documentDone', function(e){ $.log('document.done', touch); } );
			$body.off('imagesLoaded').on( 'imagesLoaded', function(e){ $.log('imagesLoaded', touch); } );
			$body.off('nivoLoaded').on( 'nivoLoaded', function(e){ $.log('nivoLoaded', touch); } );
			$body.off('mapLoaded').on( 'mapLoaded', function(e){ $.log('mapLoaded', touch); } );
			$body.off('mapsLoaded').on( 'mapsLoaded', function(e){ $.log('mapsLoaded', touch); } );*/
			$.consoleDebug( DEBUG, '- debugEvents End');
		}

		// *****************************************************
		// *      TRIGGERS
		// *****************************************************

		var triggerEvents = function(){
			$.consoleDebug( DEBUG, '- triggerEvents Start');
			// Trigger WINDOW RESIZED event
			var interval, resizing;
			$window.resize( function(e){

				$body.trigger( 'resizing' );
								
				resizing = true;

				clearTimeout( interval );
				interval = setTimeout( function(){
					if ( resizing ){
						resizing = false;
						$body.trigger( 'resized' );
						clearInterval( interval );
					}
				}, 250 );

			} );
			
			// Trigger DOCUMENT READY event
			$body.trigger( 'documentDone' );
			$body.addClass('ready');

			// Set tools
			$body.eventTools();
			$body.eventLinks();
			$body.currentSection();
			$body.checkCss();

			// Load NivoSlider and trigger
			// Call EqualChildrenSize function
			// Load GoogleMaps and trigger
			$body.imagesLoaded( function( instance ) {

			    $body.trigger( 'imagesLoaded' );
			    
			    $( '[data-slider="nivo"]' ).setNivoSlider();
			    
			    $( '[data-equal]' ).equalChildrenSize();

			    var $maps = $( '.scm-map' );

			    if( $maps.length > 0 ){

			    	window.initialize = function() {
					    script = document.createElement('script');
						script.type = 'text/javascript';
						script.src = 'http://google-maps-utility-library-v3.googlecode.com/svn/trunk/markerwithlabel/src/markerwithlabel.js';
						// dovesse dar problemi, getScript markerwithlabel, on done ...
						document.body.appendChild( script );
						$maps.googleMap();
					}
			    	    			    	
					var script = document.createElement('script');
					script.type = 'text/javascript';
					script.src = 'https://maps.googleapis.com/maps/api/js?key=' + GOOGLE_API_KEY + '&callback=initialize';
					script.async = 'async';
					script.defer = 'defer';		

					document.body.appendChild( script );
								
				}

			});

			$body.responsiveClasses('force');
			$.consoleDebug( DEBUG, '- triggerEvents End');

		}

		// *****************************************************
		// *      START
		// *****************************************************

		STARTPAGE = function(){
			$.consoleDebug( DEBUG, '--- startPage Start');
			initPage();
			touchEvents();
			checkUrlAnchor();
			startEvents();
			layoutEvents();
			navEvents();
			debugEvents();
			triggerEvents();
			$.consoleDebug( DEBUG, '--- startPage Done');
		}

		//$.consoleDebug( DEBUG, 'Orig startPage Call');
		STARTPAGE();

	// *****************************************************
	// *****************************************************
	// *****************************************************
		
	jQuery(function($){

		// Safari Fix **************************************

		window.onpageshow = function(event) {
		    if (event.persisted && $body.hasClass('safari')) {
		    	$.bodyIn(event);
		        //window.location.reload()
		    }
		};

	});

} )( jQuery );

