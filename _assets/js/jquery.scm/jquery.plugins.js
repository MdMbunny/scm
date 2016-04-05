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

	if ( !$.fn.actualHeight ) {

		$.fn.actualHeight = function() {

			var top = this.css( 'top' ),
				overflow = this.css( 'overflow' ),
				height = this.css( 'height' );
			
			this.css( {
				top : 0,
				height : 0,
				overflow : 'scroll'
			} );

			var actual = this.prop( 'scrollHeight' );

			this.css( {
				//top : top,
				//height : height,
				overflow : overflow
			} );

			return actual;

		}
	}

	if ( !$.fn.getBoxShadow ) {

		$.fn.getBoxShadow = function() {
			var proceed = this.css('box-shadow');
			if( !proceed )
				return { color: 0, x: 0, y: 0, blur: 0, exp: 0 };
			var result = this.css('box-shadow').match(/(-?\d)|(rgba\(.+\))/g);
			if( !result )
				return { color: 0, x: 0, y: 0, blur: 0, exp: 0 };

			return { color: result[0], x: result[1], y: result[2], blur: result[3], exp: result[4] };
		}
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
					elems 		= ( $elem.data( 'equal' ) ? $elem.data( 'equal' ) : '' ),
					$elems 		= $elem.children( elems ),
					equal_max 	= $elem.data( 'equal-max' ),
					equal_min 	= ( $elem.data( 'equal-min' ) ? $elem.data( 'equal-min' ) : 'height' );

				if( !$elems.length )
					return this;

				var equal 			= ( !equal_max ? equal_min : equal_max ),
					current 	 	= ( !equal_max ? 0 : 9999999 ),
					max 			= !current,
					maxw 			= parseInt( $elem.data( 'max-width' ), 10 ),
					maxh 			= parseInt( $elem.data( 'max-height' ), 10 ),
					minw 			= parseInt( $elem.data( 'min-width' ), 10 ),
					minh 			= parseInt( $elem.data( 'min-height' ), 10 );

				$($elems).each( function( i ) {

					var $this 	= $( this ),
						m 		= 0;

					switch( equal ){
						case 'height': m = parseInt( $this.css( 'height' ), 10 ); break;
						case 'width': m = parseInt( $this.css( 'width' ), 10 ); break;
					}					

					if( !max )
						current = ( m < current ? m : current );
					else
						current = ( m > current ? m : current );
				
				});




				//current_max = ( current_max == 9999999 ? 'auto' : current_max );
				//current_min = ( current_min == 0 ? 'auto' : current_min );
				
				switch( equal ){
					case 'height':

						if( $.browser.msie && $.browser.version == 6.0 )
							$elem.css( 'height', current );
						
						if( !max ){
							if( !maxh || maxh > current ){
								$elem.css( 'height', current );
								$elem.css( 'max-height', current );
							}else{
								$elem.css( 'height', maxh );
								$elem.css( 'max-height', maxh );
							}
						}else{
							if( !minh || minh < current ){
								$elem.css( 'min-height', current );
							}else{
								$elem.css( 'min-height', minh );
							}
						}
						
					break;
					case 'width':
						
						if( $.browser.msie && $.browser.version == 6.0 )
							$elem.css( 'width', current );
						
						if( !max ){
							if( !maxw || maxw > current ){
								$elem.css( 'width', current );
								$elem.css( 'max-width', current );
							}else{
								$elem.css( 'width', maxw );
								$elem.css( 'max-width', maxw );
							}
						}else{
							if( !minw || minw < current ){
								$elem.css( 'min-width', current );
							}else{
								$elem.css( 'min-width', minw );
							}
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

	if ( !$.fn.outerHTML ) {

		$.fn.outerHTML = function(s) {
			return (s)
			? this.before(s).remove()
			: jQuery("<p>").append(this.eq(0).clone()).html();
		}
	}

	/*if ( !$.fn.goToLink ) {

		$.fn.goToLink = function( event, state, title, fallback ){

			var link 		= this.data( 'href' ),
				ext 		= ( this.attr('target') == '_blank' ? true : ( this.data( 'target' ) == '_blank' ? true : this.hasClass( 'external' ) ) ),
				title 		= ( typeof title !== 'undefined' ? title : 'Arrivederci!' );
				//ext 		= ( typeof this.attr( 'target' ) !== 'undefined' ? ( this.attr('target') == '_blank' ? true : false ) : this.hasClass( 'external' ) ),
			if( !link ){
				if ( fallback ) fallback();
				return this;
			}

			if( !ext || link.indexOf( 'mailto:' ) === 0 || link.indexOf( 'callto:' ) === 0 || link.indexOf( 'fax:' ) === 0 || link.indexOf( 'tel:' ) === 0 || link.indexOf( 'skype:' ) === 0 ){
				
				window.location = link;
				return false;

			}else{

				window.open( link, title );
				return this;

			}
			
			if ( fallback ) fallback();

			return this;

		};
	}*/

})( jQuery );
