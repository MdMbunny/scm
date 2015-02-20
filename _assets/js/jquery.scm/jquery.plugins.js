/*
*****************************************************
*      SCRIPTS
*****************************************************
*/

(function($) {

	if ( !$.fn.style ) {
	
		// For those who need them (< IE 9), add support for CSS functions
		var isStyleFuncSupported = !!CSSStyleDeclaration.prototype.getPropertyValue;
		if (!isStyleFuncSupported) {

			CSSStyleDeclaration.prototype.getPropertyValue = function(a) {
				return this.getAttribute(a);
			};
		
			CSSStyleDeclaration.prototype.setProperty = function(styleName, value, priority) {
				this.setAttribute(styleName, value);
				var priority = typeof priority != 'undefined' ? priority : '';
				if (priority != '') {
					// Add priority manually
					var rule = new RegExp($.escapeBS(styleName) + '\\s*:\\s*' + $.escapeBS(value) +
					'(\\s*;)?', 'gmi');
					this.cssText =
					this.cssText.replace(rule, styleName + ': ' + value + ' !' + priority + ';');
				}
			};
			
			CSSStyleDeclaration.prototype.removeProperty = function(a) {
				return this.removeAttribute(a);
			};
		
			CSSStyleDeclaration.prototype.getPropertyPriority = function(styleName) {
				var rule = new RegExp($.escapeBS(styleName) + '\\s*:\\s*[^\\s]*\\s*!important(\\s*;)?', 'gmi');
				return rule.test(this.cssText) ? 'important' : '';
			}

		}

		// The style function
		$.fn.style = function(styleName, value, priority) {
			// DOM node
			var node = this.get(0);
			// Ensure we have a DOM node
			if (typeof node == 'undefined') {
				return this;
			}
			// CSSStyleDeclaration
			var style = this.get(0).style;
			// Getter/Setter
			if (typeof styleName != 'undefined') {
				if (typeof value != 'undefined') {
					// Set style property
					priority = typeof priority != 'undefined' ? priority : '';
					style.setProperty(styleName, value, priority);
					return this;
				} else {
					// Get style property
					return style.getPropertyValue(styleName);
				}
			} else {
				// Get CSSStyleDeclaration
				return style;
			}
		};
	}

	if ( !$.fn.getHighest ) {

		$.fn.getHighest = function( elem ) {

			var t_height = 0;
			var t_elem;

			if( !this.length )
				return 0;

			this.each( function () {

			    $this = $(this);

			    if ( $this.outerHeight() > t_height ) {

			        t_elem=this;
			        t_height = $this.outerHeight();
			    }

			} );

			if ( elem )
				return t_elem;

			return t_height;

		};

	}

	if ( !$.fn.equalChildrenSize ) {

		$.fn.equalChildrenSize = function() {

			return this.each( function() {

				var elem 		= this,
					$elem 		= $( this ),
					equal 		= $elem.data( 'equal' ),
					elems 		= $elem.children( equal ),
					equal_max 	= $elem.data( 'equal-max' ),
					equal_min 	= $elem.data( 'equal-min' );

				if( !equal || !$( elems ).length )
					return this;

				var current_max 	= ( !equal_max ? 9999999 : 0 );
					current_min 	= ( !equal_min ? 0 : 9999999 );
					maxw 			= parseInt( $elem.data( 'max-width' ), 10 ),
					maxh 			= parseInt( $elem.data( 'max-height' ), 10 ),
					minw 			= parseInt( $elem.data( 'min-width' ), 10 ),
					minh 			= parseInt( $elem.data( 'min-height' ), 10 );

				$( elems ).each( function( i ) {

					var h = parseInt( $( this ).css( 'height' ), 10 );
					var w = parseInt( $( this ).css( 'width' ), 10 );

					switch( equal_max ){
						case 'height': if ( h && h > current_max ) current_max = h; break;
						case 'width': if ( w && w > current_max ) current_max = w; break;
					}
				
					switch( equal_min ){
						case 'height': if ( h && h < current_min ) current_min = h; break;
						case 'width': if ( w && w < current_min ) current_min = w; break;
					}

				});

				current_max = ( current_max == 9999999 ? 'auto' : current_max );
				current_min = ( current_min == 9999999 ? 'auto' : current_min );
				
				switch( equal_max ){
					case 'height':
						if( $.browser.msie && $.browser.version == 6.0 )
							$elem.css( 'height', current_max );

						if( !minh || minh < current_max )
							$elem.css( 'min-height', current_max );
						else
							$elem.css( 'min-height', minh );
						
					break;
					case 'width':
						if( $.browser.msie && $.browser.version == 6.0 )
							$elem.css( 'width', current_max );

						if( !minw || minw < current_max )
							$elem.css( 'min-width', current_max );
						else
							$elem.css( 'min-width', minw );
						
					break;
				}
			
				switch( equal_min ){
					case 'height':
						if( $.browser.msie && $.browser.version == 6.0 )
							$elem.css( 'height', current_min );

						if( !maxh || maxh > current_min ){
							$elem.css( 'height', current_min );
							$elem.css( 'max-height', current_min );
						}else{
							$elem.css( 'height', maxh );
							$elem.css( 'max-height', maxh );
						}
						
					break;
					case 'width':
						if( $.browser.msie && $.browser.version == 6.0 )
							$elem.css( 'width', current_min );

						if( !maxw || maxw > current_min ){
							$elem.css( 'width', current_min );
							$elem.css( 'max-width', current_min );
						}else{
							$elem.css( 'width', maxw );
							$elem.css( 'max-width', maxw );
						}
						
					break;
				}

			});
		};

	}

	if ( !$.fn.closestChild ) {

		// Get Nearest Child
		$.fn.closestChild = function( filter ) {

	        var $found = $(),
	            $currentSet = this;

	        while ($currentSet.length) {
	            $found = $currentSet.filter(filter);
	            if ($found.length) break;
	            
	            $currentSet = $currentSet.children();
	        }

	        return $found.first();
	    };

	}

	if ( !$.fn.goBack ) {

		//Go Back
		$.fn.goBack = function( e ) {

			window.history.back();

		};

	}

	if ( !$.fn.goToLink ) {

		$.fn.goToLink = function( event, state, title ){

			var link 		= this.attr( 'href' ),
				state 		= ( state ? state : 'site' ),
				ext 		= ( typeof this.attr( 'target' ) !== 'undefined' ? ( this.attr('target') == '_blank' ? true : false ) : this.hasClass( 'external' ) ),
				title 		= ( typeof title !== 'undefined' ? title : 'Arrivederci!' );
				urlHash 	= link.split("#"),
				url 		= urlHash[0],
				hash 		= ( state != 'external' ? ( urlHash[1] ? urlHash[1] : 'none' ) : 'none' );

			if( !link )
				return this;
			
			if( hash && hash != 'none' && hash !== '' )
				$.wpUpdateOption( 'scm_anchor', hash, function(r){
					if( r )
						window.location.replace( url )
					else
						window.location.replace( link )
				} );
			else if( !ext )
				window.location.replace( link );
			else
				window.open( link, title );

			return this;

		};
	}

})( jQuery );
