var startPage;

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
		}

		// *****************************************************
		// *      TOUCH
		// *****************************************************

		var touchEvents = function(){

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
		}

		// *****************************************************
		// *      CHECK URL ANCHOR
		// *****************************************************

		var checkUrlAnchor = function(){
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
		}

		// *****************************************************
		// *      START EVENTS
		// *****************************************************

		startEvents = function(){
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

			$body.on( start, function(e){ $.bodyIn(e); } );
		}

		// *****************************************************
		// *      LAYOUT EVENTS
		// *****************************************************

		var layoutEvents = function(){
			$body.on( 'resizing resized imagesLoaded', function(e){
			
				$body.responsiveClasses( e );
				$( '[data-equal]' ).equalChildrenSize();
			
			} );

			
			$body.on( 'responsive', function( e, state ) {

				$( '[data-switch-toggle]' ).switchByData( state, 'switch-toggle', 'toggle', '.toggle-image, .toggle-home' );
				$( '[data-switch]' ).switchByData( state, 'switch' );
				$( '[data-sticky]' ).stickyMenu();
				$( '[data-affix]' ).affixIt();

			} );
		}

		// *****************************************************
		// *      TOGGLE MENU EVENTS
		// *****************************************************

		var navEvents = function(){
			$navigation.on( 'toggledOn', function(e){

				$elems = $( this ).find( '[data-toggle-button="on"]' );
				$elems.css( 'transform', 'rotate(90deg)' );
				$elems.animate( { transform: 'rotate(0deg)' }, 200, 'linear' );

			} );

			$navigation.on( 'toggledOff', function(e){

				$elems = $( this ).find( '[data-toggle-button="off"]' );
				$elems.css('transform', 'rotate(-90deg)');
				$elems.animate( { transform: 'rotate(0deg)' }, 200, 'linear' );

			} );

			$body.on( 'resizing', function(e){ $( '.toggled' ).toggledOff(e); } );
			$window.on( 'scroll', function(e){ $( '.toggled' ).toggledOff(e); } );
			$body.on( 'switchOn', '.toggle', function( e, state ){ $( this ).toggledOff( e, state ) } );
			$page.on( 'click', '.toggle-button', function(e){ $( this ).toggledIt(e); } );
			$page.on( 'mousedown', '*', function(e){ if( e.target == this ){ $( '.toggled' ).toggledOff(e); } } );
		}

		// *****************************************************
		// *      DEBUG
		// *****************************************************

		var debugEvents = function(){
			/*$body.on( 'documentDone', function(e){ $.log('document.done', touch); } );
			$body.on( 'imagesLoaded', function(e){ $.log('imagesLoaded', touch); } );
			$body.on( 'nivoLoaded', function(e){ $.log('nivoLoaded', touch); } );
			$body.on( 'mapLoaded', function(e){ $.log('mapLoaded', touch); } );
			$body.on( 'mapsLoaded', function(e){ $.log('mapsLoaded', touch); } );*/
		}

		// *****************************************************
		// *      TRIGGERS
		// *****************************************************

		var triggerEvents = function(){

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
			$body.eventLinks();
			$body.eventTools();
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

			$body.responsiveClasses();

		}

		// *****************************************************
		// *      START
		// *****************************************************

		startPage = function(){
			initPage();
			touchEvents();
			checkUrlAnchor();
			startEvents();
			layoutEvents();
			navEvents();
			debugEvents();
			triggerEvents();
		}

		startPage();

	// *****************************************************
	// *****************************************************
	// *****************************************************
		
	jQuery(function($){

		// Safari Fix **************************************

		window.onpageshow = function(event) {
		    if (event.persisted && $body.hasClass('safari')) {
		        window.location.reload() 
		    }
		};

	});

} )( jQuery );

