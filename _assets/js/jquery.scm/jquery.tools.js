//*****************************************************
//*
//	IE fixes
//	Youtube Embed Fix
//	Toggle Menu
//	Sticky Menu
//	Smooth Scroll
//	Current Link Class
//  Top Of Page
//  Responsive Layout
//  Google Maps
//  Nivo Slider
//	Fancybox
//
//	Change Page
//*
//*****************************************************



( function($){

// ******************************************************
// ******************************************************
// *      jQuery INIT
// ******************************************************
// ******************************************************

	// *****************************************************
	// *      RESPONSIVE
	// *****************************************************

	$.fn.responsiveClasses = function( event ) {

		var w 		= $( window ).width();
			a 		= '',
			r 		= '',
			state 	= 'all',
			old 	= this.attr( 'class' );

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
			this.removeClass( r );
			this.addClass( a );
			if(old != this.attr( 'class' )){
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

			// +++ todo:
			// A: o delay è passato dalle opzioni in data-... + integri in jQuery l'animazione dei Toggle Menu e in CSS potrebbe esserci solo un display/visibility come fallback per i .no-js
			// B: o delay è = this... transition.duration ???

			// Comunque il setTimeout è da levare, al suo posto il toggledOff deve animare lui stesso il menu e avere un onComplete dove ficcarci il trigger('link').

			var delay = 400;

			if( result === false ){
				$this.trigger( 'link', [ state ] );
				return $this;
			}else{
				$toggled = $( '.toggled' );
				if( $toggled.length ){
					$toggled.toggledOff( event );
					setTimeout( function(){
						$this.trigger( 'link', [ state ] );
					}, delay );
				}else{
					$this.trigger( 'link', [ state ] );
				}
			}

		});
		
	}

	// *****************************************************
	// *      TOGGLE
	// *****************************************************

	$.fn.toggledIt = function( event, state ) {
		event.stopPropagation();

		return this.each(function() {

			var $this = $( this );

			if( !$this.hasClass( 'toggled' ) )
				return $this.toggledOn( event );
			else
				return $this.toggledOff( event );

		});

	}

	$.fn.toggledOn = function( event, state ) {

		return this.each(function() {

			var $this = $( this );

	        if( !$this.hasClass( 'toggle' ) )
	        	$this = $( this ).parents( '.toggle' );

			$this.data( 'done', false );
			
			$this.find( '.toggle-button' ).children( '[data-toggle-button="off"]' ).hide();
			$this.find( '.toggle-button' ).children( '[data-toggle-button="on"]' ).show();
			if( !$this.hasClass( 'toggled' ) ){
				$this.data( 'done', true );
				$this.addClass( 'toggled' );
				$this.removeClass( 'no-toggled' );
				$this.trigger( 'toggledOn' );

				// +++ todo: aggiungere qui animazione da this.data( 'toggle_in | toggle_out | toggle_in_time | toggle_out_time | toggle_in_ease | toggle_out_ease' )
			}

		} );

	}

	$.fn.toggledOff = function( event, state ) {

		return this.each(function() {

			var $this = $( this );

	        if( !$this.hasClass( 'toggle' ) )
	        	$this = $( this ).parents( '.toggle' );
			
			$this.data( 'done', false );
			
			$this.find( '.toggle-button' ).children( '[data-toggle-button="off"]' ).show();
			$this.find( '.toggle-button' ).children( '[data-toggle-button="on"]' ).hide();
			if( $this.hasClass( 'toggled' ) ){

				$this
					.data( 'done', true )
					.trigger( 'toggledOff' )
					.removeClass( 'toggled' )
					.addClass( 'no-toggled' );
				
				// +++ todo: aggiungere qui animazione da this.data( 'toggle_in | toggle_out | toggle_in_time | toggle_out_time | toggle_in_ease | toggle_out_ease' )

			}else if( !$this.hasClass( 'no-toggled' ) ){

				$this
					.addClass( 'no-toggled' )
					.data( 'done', true )
					.trigger( 'toggledOff' )
					.removeClass( 'toggled' )
					.addClass( 'no-toggled' );
			}

		} );
	}

// +++ todo: plugin


	$.fn.switchByData = function( data, name, classes ) {

		if( !name )
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
					}
					$this.trigger( 'switchOn' );
				}else{
					if( !classes ){
						$this.hide();
						$this.siblings( '[data-' + name + '=""]' ).show();
					}else{
						$this.removeClass( classes );
					}
					$this.trigger( 'switchOff' );
				}
			}

		} );

	}


	// *****************************************************
	// *      STICKY MENU
	// *****************************************************
	
	$.fn.stickyMenu = function(){

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

			if( sticky == 'plus' ){
				var result = $this.css('box-shadow').match(/(-?\d)|(rgba\(.+\))/g);
				var plus = 0;
				if( result ){
					var color = result[0],
					    x = result[1],
					    y = result[2],
					    blur = result[3],
					    exp = result[4];

					plus = parseFloat(y) + parseFloat(blur) + parseFloat(exp);
				}

				$this.css( 'top', -$this.outerHeight()-plus );
			}

			$menu.addClass( sticky );

			// Affix

			$this
				.attr( 'data-affix', 'top' )
				.attr( 'data-affix-offset', new_offset );
			
			$this
				.off( 'affixedOn' )
				.on( 'affixedOn', function () {
				    $menu.addClass( 'affix-' + sticky );
				});

			$this
				.off( 'affixedOff' )
				.on( 'affixedOff', function () {
				    $menu.removeClass( 'affix-' + sticky);
				});

		});

	}


	// *****************************************************
	// *      SMOOTH SCROLL
	// *****************************************************

	$.fn.smoothScroll = function( event, state ) {

		return this.each(function(){
					
			var $this 			= $( this ),
				link 			= $this.attr( 'href' ),
				$body 			= $( 'body' ),

				time 			= ( $body.data( 'smooth-duration' ) ? parseFloat( $body.data( 'smooth-duration' ) ) : 1 ),
				offset 			= ( $body.data( 'smooth-offset' ) ? parseFloat( $body.data( 'smooth-offset' ) ) : 0 ),
				ease 			= ( $body.data( 'smooth-ease' ) ? $body.data( 'smooth-ease' ) : 'swing' ),
				delay 			= ( $body.data( 'smooth-delay' ) ? parseFloat( $body.data( 'smooth-delay' ) ): 0 ),

				win 			= $( window ).height(),
				height 			= $body.height(),
				position 		= $body.scrollTop(),

				hash 			= this.hash,
				target 			= $( hash ),
				name 			= hash.slice( 1 ),
				destination 	= 0,
				difference 		= 0,
				duration 		= 0;

			var pageScroll = function(){

				$( 'html, body' ).animate( {

						scrollTop: destination

					}, parseFloat( duration ), ease, function() {

						$body.css( 'pointer-events', 'all' );
					}
				);
			};

			event.preventDefault();

			if( target.length ){

				destination = target.offset().top - parseInt( offset ) - $( '.sticky' ).getHighest() + 1;

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

			$this.data('done', false);
			$( 'body' ).css( 'pointer-events', 'none' );

			duration = time * difference / 1000;
			duration = ( duration < 500 ? 500 : ( duration > 1500 ? 1500 : duration ) );

			if( delay )
				setTimeout( pageScroll, delay );
			else
				pageScroll();	

			$this.data('done', true);

			return this;

		} );
	}

	// *****************************************************
	// *      CURRENT LINK CLASS
	// *****************************************************

	$.fn.currentLink = function( event, state ){

		return this.each(function() {

			var $elem 			= $( this ),
				elem 			= this,
				$body 			= $( 'body' ),
				currentClass 	= $elem.data( 'current-link' ),
	            offset 			= ( $elem.data( 'current-link-offset' ) ? $elem.data( 'current-link-offset' ) : 0 ),
	            threshold 		= ( $elem.data( 'current-link-threshold' ) ? $elem.data( 'current-link-threshold' ) : 0 ),
	            interval 		= ( $elem.data( 'current-link-interval' ) ? $elem.data( 'current-link-interval' ) : 250 ),
	            filter 			= ( $elem.data( 'current-link-filter' ) ? $elem.data( 'current-link-filter' ) : '' ),
	            $links 			= $elem.find( 'a[href^="#"]:not([data-anchor]), a[data-anchor]:not([href^="#"])' ).filter( ':not(.external) :not([href="#top"])' ),
	            $hash 			= [],
	            $anchors 		= [],
	            didScroll 		= true,
	            timer 			= null;

            if ( filter )
                $links = $links.filter( filter );

            if( !$links.length )
                return this;

            $links.each( function(){
                var hash, anchors;

                hash = $( this ).data( 'anchor' );
                if( !hash )
                    hash = this.hash;
                
                anchors = $body.find( hash );

                if( anchors.length ){
                    $anchors.push( anchors );
                    $hash.push( $( this ) );
                }

            } );

            if( !$hash.length )
            	return this;

			        
	        var setTimer = function() {
	            
	            $( window ).on( 'scroll.currentLink', function() {
	                didScroll = true;
	            });
	            
	            setActiveClass();
	            timer = setInterval( function() {

	                if ( didScroll ) {
	                    didScroll = false;
	                    setActiveClass();
	                }

	            }, interval );
	        };
	        
	        var clearTimer = function() {	          

	            clearInterval( timer );
	            $( window ).off( 'scroll.currentLink' );
	            didScroll = false;

	        };
	        
	        var setActiveClass = function() {
	            var i, coords, link, $link, $anchor;

	            var scrollPos = $( window ).scrollTop(),
	            	heightWin = $( window ).height(),
	            	heightBody = $( 'body' ).outerHeight();

	            for( i = 0; i < $anchors.length; i++ ) {

	                $anchor = $anchors[i];

	                coords = {
	                    top: Math.round( $anchor.offset().top ) - offset,
	                    bottom: Math.round( $anchor.offset().top + $anchor.outerHeight() ) - offset
	                };

	                link = $( $hash[i] ).parent();
	                $link = $( link );
	                
	                if ( scrollPos >= coords.top - threshold && scrollPos < coords.bottom - threshold )
	                    $link.addClass( currentClass );
	                else
	                    $link.removeClass( currentClass );

	            }

	            if ( scrollPos + heightWin >= heightBody ) {

	                link = $( $hash[$hash.length-1] ).parent();
	                $link = $( link );
	                $( $hash ).each( function(){
	                    $( this ).parent().removeClass( currentClass );
	                });
	                $link.addClass( currentClass );

	            }
	        }

	        didScroll = true;
            setTimer();
			    
		});

	}

	// *****************************************************
	// *      AFFIX IT
	// *****************************************************

	$.fn.affixIt = function(){

		return this.each(function() {

			var $this 	= $( this ),
				ref 	= $this.data( 'affix' ),
				offset 	= $this.data( 'affix-offset' );

			$this.off('.affix');
			$this
			    .removeClass("affix affix-top affix-bottom")
			    .removeData("bs.affix");
			
			switch( ref ){

				case 'top': $this.affix( { offset: { top: parseInt( offset ) } }); break;
				case 'bottom': $this.affix( { offset: { bottom: parseInt( offset ) } }); break;
				default: return this; break;

			}

			$this
				.on( 'affix.bs.affix', function () {
				    $this.trigger( 'affixedOn' );
				} )
				.on( 'affix-top.bs.affix affix-bottom.bs.affix', function () {
				    $this.trigger( 'affixedOff' );
				} );

		});

	}

	// *****************************************************
	// *      GOOGLE MAPS
	// *****************************************************


	$.fn.googleMap = function() {

		var $body = $( 'body' );
		var countMaps = 0;
		var totMaps = this.length;

		//$body.data( 'maps', totMaps );



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

				$body.trigger( 'mapLoaded' );
				countMaps++;
				if( countMaps >= totMaps )
					$body.trigger( 'mapsLoaded', [ totMaps ] );

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

	// +++ todo: passare data a figli (animazioni caption, più livelli, ecc)
	// queste 2 funzioni vengono riviste

	$.fn.captionMoveIn = function( state, slider ){	

		var $slider = $( slider );
		$slider.css( 'pointer-events', 'none' );

		return this.each( function() {

			var $this = $( this ),
				from = $( this ).outerWidth();

			$this.css( { left: from, opacity: 0 } );

			if ( $this.children().length ){
				
				$this.animate({
					left: 0,
					opacity: 1
				}, 1000, function(){ $slider.css( 'pointer-events', 'all' ); } );

			}else{
				$slider.css( 'pointer-events', 'all' );
			}
		});

	}

	$.fn.captionMoveOut = function( state, slider ){

		var $slider = $( slider );
		$slider.css( 'pointer-events', 'none' );
	
		return this.each( function() {

			var $this = $( this ),
				to = - $this.outerWidth();

			if ( $this.children().length ){

				$this.animate({
					left: to,
				}, 1000, function(){ $slider.css( 'pointer-events', 'all' ); } );

			}else{
				$slider.css( 'pointer-events', 'all' );
			}
		});

	}

	// *****************************************************
	// *      SLIDER
	// *****************************************************

	$.fn.initSlider = function() {

		return this.each( function() {

			var slides = $( this ).find( '.slide-image' );

			if( slides.length ){

				slides.css( 'display', 'none' );
				$( slides[0] ).css( 'display', 'inline-block' );

			}

		});

	}

	// *****************************************************
	// *      NIVO SLIDER
	// *****************************************************

	$.fn.setNivoSlider = function(){

		return this.each( function() {

			var $body 		= $( 'body' ),
				$this 		= $( this );

			if( $this.find( '.slide-image' ).length < 2 )
				return this;

			$this.parent().addClass( 'slider-wrapper theme-default' );
			$this.addClass( 'nivoSlider' );

			$this.find( 'img' ).each( function(){
				$( this ).css( 'display', 'inline-block' );
			});

			$this.nivoSlider( {
			    effect: 			$this.data( 'slider-effect' ), 		// sliceDown | sliceDownLeft | sliceUp | sliceUpLeft | sliceUpDown | sliceUpDownLeft | fold | fade | random | slideInRight | slideInLeft | boxRandom | boxRain | boxRainReverse | boxRainGrow | boxRainGrowReverse
			    slices: 			$this.data( 'slider-slices' ), 		// For slice animations
			    boxCols: 			$this.data( 'slider-cols' ), 		// For box animations
			    boxRows: 			$this.data( 'slider-rows' ), 		// For box animations
			    animSpeed: 			$this.data( 'slider-speed' ), 		// Slide transition speed
			    pauseTime: 			$this.data( 'slider-time' ), 		// How long each slide will show
			    startSlide: 		$this.data( 'slider-start' ), 		// Set starting Slide (0 index)
			    directionNav: 		$this.data( 'slider-direction' ), 	// Next & Prev navigation
			    controlNav: 		$this.data( 'slider-control' ), 	// 1,2,3... navigation
			    controlNavThumbs: 	$this.data( 'slider-thumbs' ), 		// Use thumbnails for Control Nav
			    pauseOnHover: 		$this.data( 'slider-hover' ), 		// Stop animation while hovering
			    manualAdvance: 		$this.data( 'slider-manual' ), 		// Force manual transitions
			    prevText: 			$this.data( 'slider-prev' ), 		// Prev directionNav text
			    nextText: 			$this.data( 'slider-next' ), 		// Next directionNav text
			    randomStart: 		$this.data( 'slider-random' ), 		// Start on a random slide
			    beforeChange: function( e ){       						// Triggers before a slide transition

			    	$this.find( '.nivo-caption' ).captionMoveOut( 'before', this );

			    },
			    afterChange: function( e ){        						// Triggers after a slide transition

			    	$this.find( '.nivo-caption' ).captionMoveIn( 'after', this );

			    },
			    slideshowEnd: function( e ){       						// Triggers after all slides have been shown

			    },
			    lastSlide: function( e ){          						// Triggers when last slide is shown

			    },
			    afterLoad: function( e ){          						// Triggers when slider has loaded
			    	
			    	$body.trigger( 'nivoLoaded', [ $this ] );
			    	$this.find( '.nivo-caption' ).addClass( 'box' ).captionMoveIn( 'load', this );
			    }
			});

			if( $body.hasClass( 'touch' ) ){

				$this.find( 'a.nivo-nextNav' ).css( 'visibility', 'hidden' );
				$this.find( 'a.nivo-prevNav' ).css( 'visibility', 'hidden' );

				$this.swipe( {
			
			        swipeLeft: function( event, direction, distance, duration, fingerCount ) {
			        	$this.find( 'img' ).data( 'transition','sliceDownLeft' );
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

			var $this 			= $( this ),
				id 				= $this.attr( 'id' ),
				init 			= ( $this.data( 'init' ) ? $this.data( 'init' ) : 0 ),
				name 			= ( $this.data( 'title' ) ? $this.data( 'title' ) : '' ),
				gallery 		= GALLERIES[ id ],
				images 			= [],
				titles 			= [],
				descriptions 	= [],
				i 				= 0;

			for ( i = 0; i < gallery.length; i++ ) {
				
				images.push( {
					href: gallery[i]['url'],
				});
				
				titles.push( gallery[i]['title'] );
				descriptions.push( gallery[i]['description'] );
			};

			$this.click( function() {

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

			var $this 	= $( this ),
				srcAtt 	= $this.attr( 'src' );

			if ( -1 == srcAtt.indexOf( '?' ) )
				srcAtt += '?wmode=transparent';
			else
				srcAtt += '&amp;wmode=transparent';
			$this.attr( 'src', srcAtt );

		});
	}


	// *****************************************************
	// *      CHANGE PAGE
	// *****************************************************

	$.fn.bodyIn = function( event ){

		var $body 			= $( 'body' ),
			duration 		= ( $body.data( 'fade-in' ) ? parseFloat( $body.data( 'fade-in' ) ) : 0 ),
			delay 			= ( $body.data( 'smooth-new' ) ? parseFloat( $body.data( 'smooth-new' ) ): 0 ),
			post 			= ( $body.data( 'smooth-post' ) ? $body.data( 'smooth-post' ) : 'all' ),
			anchor 			= $body.data( 'anchor' ),
			button 			= $( 'a[href="#' + anchor + '"]' ),
			$all 			= $( 'html, body' );

		var pageScroll = function(){

			var $anchor = $( '#' + anchor );

			if( button.length ){

				if( post != 'all' ){

					$body.css( 'pointer-events', 'all' );
					$all.scrollTop( $anchor.offset().top );

				}else{

					$( button[0] ).trigger( 'link', [ 'page' ] );
				}

			}else{

				$all.animate({
					scrollTop: $anchor.offset().top
				}, 1000, function() {
					$body.css( 'pointer-events', 'all' );
				});
			}

		};

		var checkScroll	= function(){

			if( anchor && anchor != 'none' ){
				if( delay ){
					setTimeout( pageScroll, delay );
				}else{
					pageScroll();
				}
				
			}else{

				$body.css( 'pointer-events', 'all' );
				$body.css( 'opacity', 1 );

			}
    	};

    	if( duration > 0 ){
        	$body.animate( {
        		opacity: 1
        	}, duration * 1000, checkScroll );
        }else{
        	$body.css({
        		'opacity' : 1
        	});
        	checkScroll();
        }
	}

	$.fn.bodyOut = function( event, state ){

		if( state == 'page' ){
			return;
		}

		var $body 		= $( 'body' ),
			$elem 		= this,
			link 		= $elem.attr( 'href' ),
			duration 	= ( $body.data( 'fade-out' ) ? parseFloat( $body.data( 'fade-out' ) ) : 0 ),
			wait 		= ( $body.data( 'fade-wait' ) ? $body.data( 'fade-wait' ) : 'no' ),
			opacity 	= ( wait != 'no' ? 0 : .6 );

		$elem.data( 'done', false );
		if( link )
			$elem.data( 'done', true );

		if( state != 'external' && duration > 0 ){

			$body.animate( {
        		opacity: opacity
        	}, duration * 1000, function() {
				$elem.goToLink( event, state, 'See You!' );
			});

		}else{

			$body.css( 'pointer-events', 'all' );
			$elem.goToLink( event, state, 'See You!' );

		}

	}

// ******************************************************			
// ******************************************************
	// jQuery READY
// ******************************************************
// ******************************************************

	jQuery(function($){

		var $window 	= $( window ),
			$html 		= $( 'html' ),
			$body 		= $( 'body' );

		$html.removeClass( 'no-js' );

// TOUCH CLASS

        if ( ( Modernizr && ( Modernizr.touchEvents || Modernizr.touch ) ) && ( $body.hasClass('is-iphone') || $body.hasClass('is-tablet') || $body.hasClass('is-mobile') ) ) {
            $body.addClass( 'touch' );
            $body.removeClass( 'mouse' );
        }else{
            $body.removeClass( 'touch' );
            $body.addClass( 'mouse' );
        }

        // For DEBUG - Touch active on Desktop
        //*$body.addClass( 'touch' );
        //$body.removeClass( 'mouse' );

// EVENTS
		
		$body.on( 'resizing resized imagesLoaded', function(e){
		
			$body.responsiveClasses( e );
			$( '[data-equal]' ).equalChildrenSize();
		
		} );
		
		$body.on( 'responsive', function( e, state ) {

			$( '[data-switch-toggle]' ).switchByData( state, 'switch-toggle', 'toggle' );
			$( '[data-switch]' ).switchByData( state, 'switch' );
			$( '[data-sticky]' ).stickyMenu();
			$( '[data-affix]' ).affixIt();

		} );

		switch( $body.data( 'fade-wait' ) ){
			case 'window':
				$body.on( 'windowLoaded', function(e){ $( this ).bodyIn(e); } );
			break;
			case 'images':
				$body.on( 'imagesLoaded', function(e){ $( this ).bodyIn(e); } );
			break;
			case 'sliders':
				if( $( '.nivoSlider' ).length )
					$body.on( 'nivoLoaded', function(e){ $( this ).bodyIn(e); } );
				else
					$body.on( 'imagesLoaded', function(e){ $( this ).bodyIn(e); } );
			break;
			case 'maps':
				if( $( '.scm-map' ).length )
					$body.on( 'mapsLoaded', function(e, tot){ $( this ).bodyIn(e, tot); } );
				else
					$body.on( 'imagesLoaded', function(e){ $( this ).bodyIn(e); } );
			break;
			default:
				$body.on( 'imagesLoaded', function(e){ $( this ).bodyIn(e); } );
				$body.css( 'opacity', .6 );
			break;
		}
		
		$window.on( 'scroll', function(e){ $( '.toggled' ).toggledOff(e); } );
		$body.on( 'switchOn', '.toggle', function( e, state ){ $( this ).toggledOff( e, state ) } );
		$( '.site-page' ).on( 'click', '.toggle-button', function(e){ $( this ).toggledIt(e); } );
		$( '.site-page' ).on( 'mousedown', '*', function(e){ if( e.target == this ){ $( '.toggled' ).toggledOff(e); } } );
		$( 'a, .navigation' ).on( 'mousedown', function(e){ e.stopPropagation(); } );
		$( 'a' ).on( 'click', function(e){
			var toggle = $( this ).parents( '.no-toggled' );

			var cont = 0;
			if( toggle.length )
				cont = $( toggle ).parents( '.toggle-content' ).length;

			if( !$body.hasClass( 'touch' ) || !cont || $( toggle ).parents( '.toggle' ).length ){
				$( this ).linkIt(e);
			}else{
				$( '.toggled' ).toggledOff(e);
				e.preventDefault();
			}

		} );

		$body.on( 'link', 'a', function( e, state ){
		
			if( state != 'page' )
				$( this ).bodyOut( e, state );
			else
				$( this ).smoothScroll( e, state );

		} );
			
		if( $body.hasClass( 'touch' ) ){

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

		$( '[data-gallery]' ).setFancybox();
		$( '[data-slider]' ).initSlider();
		$( '[data-current-link]' ).currentLink();
		$( 'iframe[src*="youtube.com"]' ).youtubeFix();


// *** DEBUG		

		$body.on( 'documentReady', function(e){ console.log('document.ready'); } );
		$body.on( 'windowLoaded', function(e){ console.log('window.load'); } );
		$body.on( 'imagesLoaded', function(e){ console.log('imagesLoaded'); } );
		$body.on( 'nivoLoaded', function(e){ console.log('nivoLoaded'); } );
		$body.on( 'mapLoaded', function(e){ console.log('mapLoaded'); } );
		$body.on( 'mapsLoaded', function(e){ console.log('mapsLoaded'); } );
		//$body.on( 'pageLoaded', function(e){ console.log('pageLoaded'); } );

		/*$body.imagesLoaded()
				.always( function( instance ) {
		    console.log('all images loaded');
		  })
		  	.done( function( instance ) {
		    console.log('all images successfully loaded');
		  })
		  	.fail( function() {
		    console.log('all images loaded, at least one is broken');
		  })
		  	.progress( function( instance, image ) {
		    var result = image.isLoaded ? 'loaded' : 'broken';
		    console.log( 'image is ' + result + ' for ' + image.img.src );
		  });*/


// TRIGGERS

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
		$body.trigger( 'documentReady' );

		// Trigger WINDOW LOADED event
		$(window).load(function(e){
			$body.trigger( 'windowLoaded' );
		});

		// Call NivoSlider and wait for NIVO LOADED event
		$body.imagesLoaded( function( instance ) {
		    $body.trigger( 'imagesLoaded' );
		    
		    $( '[data-slider="nivo"]' ).setNivoSlider();
		    $( '.scm-map' ).googleMap();

		    /*if( $nivo.length ){
		    	// +++ todo: anche le Slider come le Mappe vengono contate e restituiscono sliderLoaded e slidersLoaded
				$nivo.setNivoSlider();
				$body.on( 'nivoLoaded', function(){
					if( $maps.length ){

						$maps.googleMap();
						$body.on( 'mapsLoaded', function(e){
							$body.trigger( 'pageLoaded' );
						});
					}else{
						$body.trigger( 'pageLoaded' );
					}
				});

			}else if( $maps.length ){

				$maps.googleMap();
				$body.on( 'mapsLoaded', function(e){
					$body.trigger( 'pageLoaded' );
				});

			}else{

				$body.trigger( 'pageLoaded' );

			}*/

		});

		$( '[data-equal]' ).equalChildrenSize();
		$body.responsiveClasses();

	});

} )( jQuery );