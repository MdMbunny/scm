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

	if ( !$.fn.equalChildrenSize ) {

		$.fn.equalChildrenSize = function( options ) {

			var defaults = {
				attribute : 'height',
				max : false,
				include : 'img',
			};

			var options = $.extend( {}, defaults, options );
			if( options.attribute != 'height' && options.attribute != 'width' )
				options.attribute = 'height';

			return this.each( function() {

				var $this 		= $( this ),
					elems 		= $this.children( options.include );
					current 	= ( !options.max ? 9999999 : 0 );
					maxw 		= parseInt( $this.data( 'max-width' ), 10 ),
					maxh 		= parseInt( $this.data( 'max-height' ), 10 ),
					minw 		= parseInt( $this.data( 'min-width' ), 10 ),
					minh 		= parseInt( $this.data( 'min-height' ), 10 );

				$( elems ).each( function( i ) {

					var h = parseInt( $( this ).css( 'height' ), 10 );
					var w = parseInt( $( this ).css( 'width' ), 10 );

					switch( options.attribute ){
						case 'height':

							if( !options.max ){
								if ( h && h < current )
									current = h;
							}else{
								if ( h && h > current )
									current = h;
							}
						
						break;

						case 'width':

							if( !options.max ){
								if ( w && w < current )
									current = w;
							}else{
								if ( w && w > current )
									current = w;
							}						
						
						break;

					}
				});

				current = ( current == 9999999 ? 'auto' : current );
				
				switch( options.attribute ){
					case 'height':

						if( $.browser.msie && $.browser.version == 6.0 )
							$this.css( 'height', current );
						
						if( !options.max ){
							if( !maxh || maxh > current ){
								$this.css( 'height', current );
								$this.css( 'max-height', current );
							}else{
								$this.css( 'height', maxh );
								$this.css( 'max-height', maxh );
							}
						}else{
							if( !minh || minh < current ){
								$this.css( 'min-height', current );
							}else{
								$this.css( 'min-height', minh );
							}
						}

					break;

					case 'width':

						if( $.browser.msie && $.browser.version == 6.0 )
							$this.css( 'width', current );
						
						if( !options.max ){
							if( !maxw || maxw > current ){
								$this.css( 'width', current );
								$this.css( 'max-width', current );
							}else{
								$this.css( 'width', maxw );
								$this.css( 'max-width', maxw );
							}
						}else{
							if( !minw || minw < current ){
								$this.css( 'min-width', current );
							}else{
								$this.css( 'min-width', minw );
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
