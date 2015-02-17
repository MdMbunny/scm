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
//  Responsive Layout
//  Google Maps
//  Nivo Slider
//	Fancybox
//
//	Change Page
//*
//*****************************************************



( function($){

// *      jQuery on INIT

	// *****************************************************
	// *      RESPONSIVE
	// *****************************************************

	$.fn.responsiveClasses = function( event, state ) {

		//console.log('RESP');

		var w = $( window ).width();
		var a = '';
		var r = '';

		if( w > 700 ){

			a += 'desktop r1400 ';
			r += 'smart smartmid smartmin smartmicro ';

			if( w < 1401 ){
				a += 'r1120 ';
				r += 'wide ';
			}else{
				r += 'r1120 ';
				a += 'wide ';
			}

			if( w < 1121 ) a += 'tablet r1030 ';
			else r += 'tablet r1030 ';

			if( w < 1121 && w > 800 ) a += 'landscape ';
			else r += 'landscape ';

			if( w < 1031 ) a += 'notebook r940 ';
			else r += 'notebook r940 ';

			if( w < 941 ) a += 'r800 ';
			else r += 'r800 ';

			if( w < 801 ) a += 'portrait r700 ';
			else r += 'portrait r700 ';

		}else{

			a += 'tablet smart ';
			r += 'wide desktop landscape notebook portrait r1400 r1120 r1030 r940 r800 r700 ';							

			if( w < 401 ) a += 'smartmicro ';
			else r += 'smartmicro ';

			if( w < 501 ) a += 'smartmin ';
			else r += 'smartmin ';
			
			if( w < 601 ) a += 'smartmid ';
			else r += 'smartmid ';

		}

		if( event != 'init' ){
			var cl1 = this.attr( 'class' );
			this.removeClass( r );
			this.addClass( a );
			var cl2 = this.attr( 'class' );
			if(cl1 != cl2){
				var state = 'all';
				if ( this.hasClass( 'smart' ) )			state = 'smart';
				else if( this.hasClass( 'portrait' ) )	state = 'portrait';
				else if( this.hasClass( 'landscape' ) )	state = 'landscape';
				else if( this.hasClass( 'wide' ) )		state = 'wide';
				else if( this.hasClass( 'desktop' ) )	state = 'desktop';

				this.trigger( 'responsive', [ state ] );
			}
		}else{
			return a;
		}

	}

	// *****************************************************
	// *      LINK
	// *****************************************************

	$.fn.linkIt = function( event, state ){

		return this.each(function() {

		    var $this 		= $( this );
		    	link 		= $this.attr( 'href' ),
				ext 		= ( typeof $this.attr( 'target' ) !== 'undefined' ? ( $this.attr( 'target' ) == '_blank' ? true : false ) : $this.hasClass( 'external' ) ),
				title 		= ( typeof title !== 'undefined' ? title : 'Arrivederci!' ),
				current 	= document.URL,
		        parent 		= $this.parents( '.sub-menu' ),
		        a_parent 	= $( parent ).siblings().find( 'a' ),
		        url_parent 	= $( a_parent ).attr( 'href' ),
		        result 		= true;

		    if( !link )
		    	return;

		    event.preventDefault();
			event.stopPropagation();
			$( 'body' ).css( 'pointer-events', 'none' );

	        if( current.indexOf( link ) === 0 )
	            $this.attr( 'href', '#top' );
	        else if( link.indexOf( '#' ) === 0 && url_parent && ( current.indexOf( url_parent ) < 0 && url_parent != '#top' ) )
	            $this.attr( 'href', url_parent + link );

	        var elem 		= $this.context,
				lochost		= location.hostname,
				host 		= elem.hostname,
				locpath		= location.pathname.replace( /^\//,'' ),
				path 		= elem.pathname.replace( /^\//,'' );

			if( lochost === host ){
				if ( locpath !== path ){
					result = $this.trigger( 'linkSite' ).data( 'done' );
					state = 'site';
				}else if ( locpath === path ){
					result = $this.trigger( 'linkPage' ).data( 'done' );
					state = 'page';
				}
			}else{
				result = $this.trigger( 'linkExternal' ).data( 'done' );
				state = 'external';
			}

			$this.trigger( 'link', [ state ] );

			if( result === false )
				return $this;

			$( '.toggled' ).toggledOff( event );

		});
		
	}

	// *****************************************************
	// *      TOGGLE
	// *****************************************************

	$.fn.toggledIt = function( event, state ) {
		event.stopPropagation();

		if( !this.hasClass( 'toggled' ) )
			return this.toggledOn( event );
		else
			return this.toggledOff( event );

	}

	$.fn.toggledOn = function( event, state ) {

		return this.each(function() {

			var $elem = $( this );

	        if( !$elem.hasClass( 'toggle' ) )
	        	$elem = $( this ).parents( '.toggle' );

			$elem.data( 'done', false );
			
			$elem.find( '.toggle-button' ).children( '[data-toggle-button="off"]' ).hide();
			$elem.find( '.toggle-button' ).children( '[data-toggle-button="on"]' ).show();
			if( !$elem.hasClass( 'toggled' ) ){
				$elem.data( 'done', true );
				$elem.addClass( 'toggled' );
				$elem.removeClass( 'no-toggled' );
				$elem.trigger( 'toggledOn' );
				// +++ todo: aggiungere qui animazione da this.data( 'toggle_in | toggle_out | toggle_in_time | toggle_out_time | toggle_in_ease | toggle_out_ease' )
			}

		} );

	}

	$.fn.toggledOff = function( event, state ) {

		//alert( event.type );
		//console.log( state );

		return this.each(function() {

			var $elem = $( this );

	        if( !$elem.hasClass( 'toggle' ) )
	        	$elem = $( this ).parents( '.toggle' );
			
			$elem.data( 'done', false );
			
			$elem.find( '.toggle-button' ).children( '[data-toggle-button="off"]' ).show();
			$elem.find( '.toggle-button' ).children( '[data-toggle-button="on"]' ).hide();
			if( $elem.hasClass( 'toggled' ) ){
				$elem.data( 'done', true );
				$elem.trigger( 'toggledOff' );
				$elem.removeClass( 'toggled' );
				$elem.addClass( 'no-toggled' );
				// +++ todo: aggiungere qui animazione da this.data( 'toggle_in | toggle_out | toggle_in_time | toggle_out_time | toggle_in_ease | toggle_out_ease' )
			}else if( !$elem.hasClass( 'no-toggled' ) ){
				$elem.addClass( 'no-toggled' );
				$elem.data( 'done', true );
				$elem.trigger( 'toggledOff' );
				$elem.removeClass( 'toggled' );
				$elem.addClass( 'no-toggled' );
			}

		} );
	}

	/*$.fn.tapIt = function( event ){

		this.data( 'done', false );


		this.data( 'done', true );
		return this;

	}*/

// +++ todo: plugin


	$.fn.switchByData = function( data, name, classes ) {

		name = ( classes ? name : 'switch' );

		return this.each(function() {

			var $this 	= $( this ),
				act 	= $this.data( name );

			if( act && act != '' ){

				if( act.indexOf( data ) >= 0 ){
					if( !classes ){
						$this.show();
						$this.siblings( '[data-' + name + '=""]' ).hide();
					}else{
						$this.addClass( classes );
						$this.trigger( 'switchOn' );
					}
				}else{
					if( !classes ){
						$this.hide();
						$this.siblings( '[data-' + name + '=""]' ).show();
					}else{
						$this.removeClass( classes );
						$this.trigger( 'switchOff' );
					}
				}
			}

		} );

	}


	// *****************************************************
	// *      STICKY MENU
	// *****************************************************
	
	$.fn.setSticky = function( event, state ){


		return this.each(function() {

			var $this 			= $( this ),
				new_offset 		= 0,
				sticky 			= $this.data('sticky-type'),
				offset 			= $this.data('sticky-offset'),
				attach 			= $this.data('sticky-attach'),
				menu 			= $this.data('sticky'),
				$menu 			= $( '#' + menu );

			if( !$menu.length )
				return;

			if( attach == 'nav-top'){
				new_offset = offset + $menu.offset().top;
			}else if( attach == 'nav-bottom'){
				new_offset = offset + $menu.offset().top + $menu.outerHeight();
			}

			$(window).off('.affix');
			$this
			    .removeClass("affix affix-top affix-bottom")
			    .removeData("bs.affix");
			
			$this.affix(
				{ offset: { top: parseInt(new_offset) } }
			);

			if( sticky == 'plus' ){
				var result = $this.css('box-shadow').match(/(-?\d)|(rgba\(.+\))/g);
				var color = result[0],
				    x = result[1],
				    y = result[2],
				    blur = result[3],
				    exp = result[4];
				var plus = parseFloat(y) + parseFloat(blur) + parseFloat(exp);

				$this.css( 'top', -$this.outerHeight()-plus );
			}

			$this.on('affix.bs.affix', function () {
			     $(menu).addClass('affix-' + sticky);
			});
			$this.on('affix-top.bs.affix', function () {
			     $(menu).removeClass('affix-' + sticky);
			});

		});

	}

	// *****************************************************
	// *      OVERLAY
	// *****************************************************

	$.fn.setOverlay = function( event, state ) {

		return this.each(function(){

			var h = $( this ).outerHeight();
			
			$( this ).css( 'margin-bottom', - h );

		});
		
	}

	// *****************************************************
	// *      SMOOTH SCROLL
	// *****************************************************

	$.fn.smoothScroll = function( event, state ) {

		return this.each(function(){
					
			var $elem 			= $( this ),
				elem 			= this,
				link 			= $elem.attr( 'href' ),

				time 			= ( $( 'body' ).data( 'smooth-duration' ) ? parseFloat( $( 'body' ).data( 'smooth-duration' ) ) : 1 ),
				offset 			= ( $( 'body' ).data( 'smooth-offset' ) ? parseFloat( $( 'body' ).data( 'smooth-offset' ) ) : 0 ),
				ease 			= ( $( 'body' ).data( 'smooth-ease' ) ? $( 'body' ).data( 'smooth-ease' ) : 'swing' ),
				delay 			= ( $( 'body' ).data( 'smooth-delay' ) ? parseFloat( $( 'body' ).data( 'smooth-delay' ) ): 0 );

				
				win 			= $( window ).height(),
				height 			= $( 'body' ).height(),
				position 		= $( 'body' ).scrollTop(),

				target 			= $( elem.hash ),
				name 			= elem.hash.slice( 1 ),
				destination 	= 0,
				difference 		= 0,
				duration 		= 0,

				pageScroll 		= function(){

					$( 'html, body' ).animate( {

							scrollTop: destination

						}, parseFloat( duration ), ease, function() {

							$( 'body' ).css( 'pointer-events', 'all' );
						}
					);
				};

			event.preventDefault();

			if( target.length ){

				destination = target.offset().top - parseInt( offset );

				if( height - destination < win ){
					destination = height - win;
				}

			}else if( name == 'top' ){
				destination = 0;
			}else{
				$( 'body' ).css( 'pointer-events', 'all' );
				return this;
			}

			difference = Math.abs( destination - position );
			if( !difference ){
				$( 'body' ).css( 'pointer-events', 'all' );
				return this;
			}

			$elem.data('done', false);
			$( 'body' ).css( 'pointer-events', 'none' );

			duration = time * difference / 1000;
			duration = ( duration < 500 ? 500 : ( duration > 1500 ? 1500 : duration ) );

			//if ( time > 0 && difference > 0 && ( target.length || destination === 0 ) ) {

			if( delay )
				setTimeout( pageScroll, delay );
			else
				pageScroll();	

			/*}else{

				$( 'body' ).css( 'pointer-events', 'all' );
				return this;
			}*/

			$elem.data('done', true);

			return this;

		} );
	}

	// *****************************************************
	// *      TOP OF PAGE
	// *****************************************************

	$.fn.topOfPage = function( event, state ){

		return this.each(function() {

			var $this = $( this );

			$this.removeClass( 'affix affix-top affix-bottom' )
			    .removeData( 'bs.affix' )
			    .affix( {
					offset: {
						top: parseInt( $this.data( 'offset' ) )
					}
				});
		});

	}

	// *****************************************************
	// *      GOOGLE MAPS
	// *****************************************************

	$.fn.googleMap = function() {

		$( 'body' ).data( 'maps', this.length );

		return this.each(function() {

			var $this 		= $( this ),
				markers 	= $this.children( '.scm-marker' ),
				zoom 		= parseFloat( $this.data( 'zoom' ) ),
				style 		= [],
				args 		= [],
				map 		= [];

			style = [
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

	        args = {
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
			
			map = new google.maps.Map( this, args);

			infowindow = new google.maps.InfoWindow({
				content		: '',
				maxWidth	: 500
			});

			map.markers = [];
			
			$( markers ).markerMap( map, infowindow );

			$this.centerMap( map, zoom );
			
			google.maps.event.addListener( map, 'tilesloaded', function() {

				$( 'body' ).trigger( 'mapLoaded' );

			});

		});
	}

	$.fn.markerMap = function( map, infowindow ) {

		return this.each(function() {

			var $this 		= $( this ),
				latlng 		= new google.maps.LatLng( $this.data( 'lat' ), $this.data( 'lng' ) ),
				marker_img 	= $this.data( 'img' ),
				marker 		= [];
			
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

			marker = new google.maps.Marker({
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

			if( $this.html() ){
				google.maps.event.addListener( marker, 'click', function() {
					infowindow.close();
					infowindow.setContent($this.html());
					infowindow.open( map, marker );
				});
			}
		});
	}

	$.fn.centerMap = function( map, zoom ) {

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
			        google.maps.event.addListener(map, 'bounds_changed', function( event ) {

			            if ( this.getZoom() > zoom && this.initialZoom == true ) {
			                // Change max/min zoom here
			                this.setZoom( zoom );
			                this.initialZoom = false;
			            }

			        google.maps.event.removeListener( zoomChangeBoundsListener );

			    });
			});

			map.initialZoom = true;
			map.fitBounds( bounds );

		}
	}
	
	// *****************************************************
	// *      SLIDER CAPTION
	// *****************************************************

	// +++ todo: passare data a Nivo Slider (velocità, pausa, controlli) e figli (animazioni caption, più livelli, ecc)
	// queste 2 funzioni vengono riviste (o spostate...)

	$.fn.captionMoveIn = function( state ){
		
		//this.removeClass( 'from-left' );
		//this.addClass( 'from-right' );
		//this.removeClass( 'from-right', 500 );
		return this.each( function() {

			$from = $( 'body' ).outerWidth() + $( this ).outerWidth();
			$( this ).css( { left: $from, opacity: 0 } ).animate({
				left: $( this ).parent( '.slider' ).position().left,
				opacity: 1
			}, 1000);

		});

	}

	$.fn.captionMoveOut = function( state ){
	
		//this.addClass( 'from-left', 500 );

		return this.each( function() {

			//$( this ).css( { left: -250 } );
			w = - $( this ).outerWidth();

			$( this ).animate({
				left: w,
				//opacity: 0
			}, 1000);

		});

	}

	// *****************************************************
	// *      NIVO SLIDER
	// *****************************************************
	
	$.fn.initSlider = function() {

		return this.each( function() {

			var slides = $( this ).find( '.nivo-image' );

			if( slides.length ){

				slides.css( 'display', 'none' );

				var img = slides[0];

				$( img ).css( 'display', 'inline-block' );

			}

		});

	}

	$.fn.initNivoSlider = function() {

		return this.each( function() {
			
			var slides = $( this ).find( '.nivo-image' ).length;

			if( slides > 1 ){
				$( this ).parent().addClass( 'slider-wrapper theme-default' );
				$( this ).addClass( 'nivoSlider' );
			}else{
				//$( this ).find( '.nivo-caption' ).css( 'display', 'inline-block' );
			}

		});

	}

	$.fn.setNivoSlider = function(){

		return this.each( function() {

			var $this = $( this );

			$this.find( 'img' ).each( function(){
				$( this ).css( 'display', 'inline-block' );
			});

			$this.nivoSlider( {
			    effect: 'fold',        // Specify sets like: 'fold,fade,sliceDown'
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
			    beforeChange: function( e ){       // Triggers before a slide transition

			    	$this.find( '.nivo-caption' ).captionMoveOut( 'before' );

			    },
			    afterChange: function( e ){        // Triggers after a slide transition

			    	$this.find( '.nivo-caption' ).captionMoveIn( 'after' );

			    },
			    slideshowEnd: function( e ){       // Triggers after all slides have been shown

			    },
			    lastSlide: function( e ){          // Triggers when last slide is shown

			    },
			    afterLoad: function( e ){          // Triggers when slider has loaded
			    	

			    	$( 'body' ).trigger( 'nivoLoaded', [ $this ] );
			    	$this.find( '.nivo-caption' ).addClass( 'box' ).captionMoveIn( 'load' );
			    }
			});

			if( $( 'body' ).hasClass( 'touch' ) ){

				$this.find( 'a.nivo-nextNav' ).css( 'visibility', 'hidden' );
				$this.find( 'a.nivo-prevNav' ).css( 'visibility', 'hidden' );

				$this.swipe( {
			
			        swipeLeft: function( event, direction, distance, duration, fingerCount ) {
						$this.find( 'a.nivo-nextNav' ).trigger( 'click' );
						event.stopPropagation();

			        },
			        swipeRight: function( event, direction, distance, duration, fingerCount ) {
			        	$this.find( 'img' ).data( 'transition','sliceDown' );
		                $this.find( 'a.nivo-prevNav' ).trigger( 'click' );
		                $this.find( 'img' ).data( 'transition','sliceDownLeft' );
			        	event.stopPropagation();

			        },
			        threshold: 10,
			        excludedElements: ''
					
				});

			}
			
		});

	}

	// *****************************************************
	// *      FANCYBOX
	// *****************************************************

	$.fn.setFancybox = function() {

		return this.each( function() {

			var $this = $( this ),
				id 				= $this.attr( 'id' ),
				init 			= $this.data( 'init' ),
				name 			= $this.data( 'title' ),
				gallery 		= GALLERIES[ id ],
				images 			= [],
				titles 			= [],
				descriptions 	= [];

			for (var i = 0; i < gallery.length; i++) {
				images.push( {
					href: gallery[i]['url'],
				});
				titles.push(gallery[i]['title']);
				descriptions.push(gallery[i]['description']);
			};

			$this.click(function() {

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
				   		afterLoad: function() {
						
						    var list = $( '#fancybox-links' );
						    
						    if (!list.length) {  

						        list = $( '<ul id="fancybox-links">' );
						        for (var i = 0; i < this.group.length; i++) {
						        	var item = '<li data-index="' + i + '"><label></label></li>';
						            $( item ).click( function() {

						            	$.fancybox.jumpto( $( this ).data( 'index' ) );

						            }).appendTo( list );
						        }
						        
						        list.appendTo( 'body' );
						    }

						    list.find( 'li' ).removeClass( 'active' ).eq( this.index ).addClass( 'active' );
						},
						beforeClose: function() {

						    $( '#fancybox-links' ).remove();  

						},
			    	}
			    );
			    
			    return false;
			});
		});
	}

	// *****************************************************
	// *      YOUTUBE EMBED FIX
	// *****************************************************

	$.fn.youtubeFix = function(){

		return this.each( function() {

			var srcAtt = $( this ).attr( 'src' );
			if ( -1 == srcAtt.indexOf( '?' ) )
				srcAtt += '?wmode=transparent';
			else
				srcAtt += '&amp;wmode=transparent';
			$( this ).attr( 'src', srcAtt );

		});
	}


	// *****************************************************
	// *      CHANGE PAGE
	// *****************************************************

	$.fn.bodyIn = function( event ){

		var duration 		= ( $( 'body' ).data( 'fade-in' ) ? parseFloat( $( 'body' ).data( 'fade-in' ) ) : 0 ),
			delay 			= ( $( 'body' ).data( 'smooth-new' ) ? parseFloat( $( 'body' ).data( 'smooth-new' ) ): 0 ),
			post 			= ( $( 'body' ).data( 'smooth-post' ) ? $( 'body' ).data( 'smooth-post' ) : 'all' ),
			anchor 			= $( 'body' ).data( 'anchor' ),
			button 			= $( 'a[href="#' + anchor + '"]' ),

			pageScroll 		= function(){

				var $anchor = $( '#' + anchor );

				if( button.length ){

					if( post != 'all' ){

						$( 'body' ).css( 'pointer-events', 'all' );
						$( 'html, body' ).scrollTop( $anchor.offset().top );

					}else{

						$( button[0] ).trigger( 'link', [ 'page' ] );
					}

				}else{

					$( 'html, body' ).animate({
						scrollTop: $anchor.offset().top
					}, 1000, function() {
						$( 'body' ).css( 'pointer-events', 'all' );
					});
				}

			},

    		checkScroll 	= function(){

    			//anchor = $.urlData( 'anchor' );

				//if( anchor && anchor.indexOf( '#' ) === 0 ){
				if( anchor && anchor != 'none' ){
					if( delay ){
						setTimeout( pageScroll, delay );
					}else{
						pageScroll();
					}
					
				}else{

					$( 'body' ).css( 'pointer-events', 'all' );
					$( 'body' ).css( 'opacity', 1 );

				}
        	};

    	if( duration > 0 ){
        	$( 'body' ).animate( {
        		opacity: 1
        	}, duration * 1000, checkScroll );
        }else{
        	$( 'body' ).css({
        		'opacity' : 1
        	});
        	checkScroll();
        }
	}

	$.fn.bodyOut = function( event, state ){

		if( state == 'page' ){
			return;
		}

		var $elem 		= this,
			link 		= $elem.attr( 'href' ),
			duration 	= ( $( 'body' ).data( 'fade-out' ) ? parseFloat( $( 'body' ).data( 'fade-out' ) ) : 0 ),
			wait 		= ( $( 'body' ).data( 'fade-wait' ) ? $( 'body' ).data( 'fade-wait' ) : 'no' ),
			opacity 	= ( wait != 'no' ? 0 : .6 );

		$elem.data( 'done', false );
		if( link )
			$elem.data( 'done', true );

		if( duration > 0 ){

			$( 'body' ).animate( {
        		opacity: opacity
        	}, duration * 1000, function() {
				$elem.goToLink( event, state, 'See You!' );
			});

		}else{

			$elem.goToLink( event, state, 'See You!' );

		}

	}

			

	// jQuery on READY

	jQuery(function($){

		$( 'html' ).removeClass( 'no-js' );
		
		// *****************************************************
		// *****************************************************
		// *****************************************************
		// *      SETTINGS
		// *****************************************************
		// *****************************************************
		// *****************************************************

// TOUCH CLASS

        if ( ( Modernizr && ( Modernizr.touchEvents || Modernizr.touch ) ) && ( $('body').hasClass('is-iphone') || $('body').hasClass('is-tablet') || $('body').hasClass('is-mobile') ) ) {
            $( 'body' ).addClass( 'touch' );
            $( 'body' ).removeClass( 'mouse' );
        }else{
            $( 'body' ).removeClass( 'touch' );
            $( 'body' ).addClass( 'mouse' );
        }

        /*$( 'body' ).addClass( 'touch' );
        $( 'body' ).removeClass( 'mouse' );*/

// EVENTS
		
		$( 'body' ).on( 'resizing resized documentReady', function(e){
			$( '.slider' ).equalChildrenSize();
			$( this ).responsiveClasses();
		} );

		$( 'body' ).on( 'responsive', function( e, state ) {

			$( '[data-switch-toggle]' ).switchByData( state, 'switch-toggle', 'toggle' );
			$( '[data-switch]' ).switchByData( state, 'switch' );
			$( '[data-sticky]' ).setSticky( e, state );
			$( '.overlay' ).setOverlay( e, state );
			$( '.topofpage' ).topOfPage( e, state );

		} );

		switch( $( 'body' ).data( 'fade-wait' ) ){
			case 'window':
				$( 'body' ).on( 'windowLoaded', function(e){ $( this ).bodyIn(e); } );
			break;
			case 'images':
				$( 'body' ).imagesLoaded( function(e){ $( this ).bodyIn(e); } );
			break;
			case 'sliders':
				if( $( '.nivoSlider' ).length )
					$( 'body' ).on( 'nivoLoaded', function(e){ $( this ).bodyIn(e); } );
				else
					$( 'body' ).imagesLoaded( function(e){ $( this ).bodyIn(e); } );
			break;
			case 'maps':
				if( $( '.scm-map' ).length )
					$( 'body' ).on( 'mapsLoaded', function(e, tot){ $( this ).bodyIn(e, tot); } );
				else
					$( 'body' ).imagesLoaded( function(e){ $( this ).bodyIn(e); } );
			break;
			default:
				$( 'body' ).imagesLoaded( function(e){ $( this ).bodyIn(e); } );
				$( 'body' ).css( 'opacity', .6 );
				
			break;
		}
		
		
		$( 'body' ).on( 'switchOn', '.toggle', function( e, state ){ $( this ).toggledOff( e, state ) } );
		
		
		$( window ).on( 'scroll', function(e){ $( '.toggled' ).toggledOff(e); } );
				

		$( '.site-page' ).on( 'click', '.toggle-button', function(e){ $( this ).toggledIt(e); } );
		$( '.site-page' ).on( 'mousedown', '*', function(e){ if( e.target == this ){ $( '.toggled' ).toggledOff(e); } } );
		$( 'a, .navigation' ).on( 'mousedown', function(e){ e.stopPropagation(); } );
		$( 'a' ).on( 'click', function(e){
			var toggle = $( this ).parents( '.no-toggled' );

			var cont = 0;
			if( toggle.length )
				cont = $( toggle ).parents( '.toggle-content' ).length;

			if( !$( 'body' ).hasClass( 'touch' ) || !cont || $( toggle ).parents( '.toggle' ).length ){
				$( this ).linkIt(e);
			}else{
				$( '.toggled' ).toggledOff(e);
				e.preventDefault();
			}

		} );

		$( 'body' ).on( 'link', 'a', function( e, state ){
		
			if( state != 'page' )
				$( this ).bodyOut( e, state );
			else
				$( this ).smoothScroll( e, state );

		} );



			
		if( $( 'body' ).hasClass( 'touch' ) ){

			$( '.navigation[data-toggle="true"]' ).swipe( {

		        swipeDown: function( e, direction, distance, duration, fingerCount ) {

		        	var $this = $( this );
		        	
		        	var toggle = ( $( e.target ).hasClass( '.toggle' ) ? 1 : $( e.target ).parents( '.toggle' ).length );
		        	if( toggle ){
	        			$this.toggledOn( e );
	        			e.stopPropagation();
	        		}
	        		
		        },

		        swipeUp: function( e, direction, distance, duration, fingerCount ) {

		        	var $this = $( this );

		        	var toggle = ( $( e.target ).hasClass( '.toggle' ) ? 1 : $( e.target ).parents( '.toggle' ).length );
		        	
		        	if( toggle ){
	        			$this.toggledOff( e );
	        			e.stopPropagation();
	        		}

		        },

		        threshold: 10,
		        excludedElements: '',
		        //allowPageScroll: 'auto'
				
			});
		}

// TOOLS

		
		$( '.scm-gallerie' ).setFancybox();
		$( '.slider' ).initSlider();
		$( 'iframe[src*="youtube.com"]' ).youtubeFix();
		$( '.site-main' ).singlePageNav({
			filter: ':not(.external) :not([href="#top"])',
			currentClass: $( 'body' ).data( 'single-class' ),
			offset: $( 'body' ).data( 'single-offset' ),
	        threshold: $( 'body' ).data( 'single-threshold' ),
	        interval: $( 'body' ).data( 'single-interval' ),
	        data: true
		});


// *** DEBUG		

		$( 'body' ).on( 'documentReady', function(e){ console.log('document.ready'); } );
		$( 'body' ).on( 'windowLoaded', function(e){ console.log('window.load'); } );
		$( 'body' ).imagesLoaded( function(e){ console.log('imagesLoaded'); } );
		$( 'body' ).on( 'nivoLoaded', function(e){ console.log('nivoLoaded'); } );
		$( 'body' ).on( 'mapLoaded', function(e){ console.log('mapLoaded'); } );


// TRIGGERS

		// Trigger WINDOW RESIZED event
		var interval, resizing;
		$( window ).resize( function(e){

			$( 'body' ).trigger( 'resizing' );

			resizing = true;
			clearInterval( interval );
			interval = setInterval( function(){
				if ( resizing ){
					resizing = false;
					$( 'body' ).trigger( 'resized' );
					clearInterval( interval );
				}
			}, 100 );

		} );

		// Trigger DOCUMENT READY event
		$( 'body' ).trigger( 'documentReady' );

		// Trigger WINDOW LOADED event
		$(window).load(function(e){
			$( 'body' ).trigger( 'windowLoaded' );
			/*$( '.slider.nivo' ).initNivoSlider();
			$( '.nivoSlider' ).setNivoSlider();
			$( '.scm-map' ).googleMap();*/
		});

		// Call NivoSlider and wait for NIVO LOADED event
		$( 'body' ).imagesLoaded( function(){
			$( '.slider.nivo' ).initNivoSlider();
			$( '.nivoSlider' ).setNivoSlider();
			$( '.scm-map' ).googleMap();
		});

		// Call GoogleMaps and wait for MAPS LOADED event
		/*$( 'body' ).on( 'nivoLoaded', function(){
			$( '.scm-map' ).googleMap();
		});*/

		// Call Single Map and wait for MAP LOADED event
		var countMaps = 0;
		$( 'body' ).on( 'mapLoaded', function(e){
			var totMaps = $( 'body' ).data( 'maps' );
			countMaps++;
			if( countMaps >= totMaps )
				$( 'body' ).trigger( 'mapsLoaded', [ totMaps ] );
		});

		//$( this ).responsiveClasses();
		$( '.slider' ).equalChildrenSize();
			$( this ).responsiveClasses();

	});

} )( jQuery );