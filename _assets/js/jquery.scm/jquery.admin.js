( function($){

	jQuery.fn.setColumnWidth = function(){

		return this.each( function(){

			var $this = jQuery(this);
			var $row = $this.children( '.acf-fields' );
			var sel = [];
			if( $row.length ){
				var $select = $row.children( '.select2-columns_width' );
				sel = $select.find( '.select2-offscreen' );

			}else{		
				sel = $this.find( 'table > tbody > tr > .acf-fields > .select2-columns_width .select2-offscreen' );
			}

			if( sel[0] )
				var $sel = jQuery( sel[0] );
			else
				return this;

			var value = $sel.val();

			if( value == 'auto' )
				value = '1/1';

			if( value.indexOf( '/' ) > -1 ){
				value = ( value ? value : '1/1' );
				value = value.replace('/', '');

				if( !$this.hasClass( 'column' ) ){
					$this.addClass( 'column' );
					$this.children( '.acf-fields' ).css( 'width', '100%' );
				}
				
				$this.removeClass( function (index, css) {
				    return (css.match (/\bcolumn-\S+/g) || []).join(' ');
				} );

				$this.addClass( 'column-' + value );
			}

		} );

	}

	jQuery.fn.setLayoutWidth = function(){

		return this.each( function(){

			var $this = jQuery(this);
			var $row = $this.children( '.acf-fields' );
			var sel = [];
			if( $row.length ){
				var $select = $row.children( '.select2-layout_main' );
				sel = $select.find( '.select2-offscreen' );

			}else{		
				sel = $this.find( 'table > tbody > tr > .acf-fields > .select2-layout_main .select2-offscreen' );
			}

			if( sel[0] )
				var $sel = jQuery( sel[0] );
			else
				return this;

			var value = $sel.val();

			if( value.indexOf( 'responsive' ) > -1 ){
				$this.removeClass( 'full' );
			}else{
				$this.addClass( 'full' );
			}
					
		} );

	}


/**************************************************************/



		var $body = jQuery( 'body' ),
			$layout = jQuery('.layout' ),
			$rows = jQuery( '.acf-row' );


		$('.acf-field .acf-label label:empty').addClass('empty');


		$body.on( 'mouseenter', '.acf-field', function(e){
			var $this = jQuery(this);

			if( $this.hasClass( 'acf-field' ) ){
				jQuery( '.show-field-key' ).remove();
				if ( e.altKey ){
					e.stopPropagation();
					$this.append( '<div class="show-field-key">' + $this.attr( 'data-name' ) + '</div>' );
				}else if ( e.shiftKey){
					e.stopPropagation();
					$this.append( '<div class="show-field-key">' + $this.attr( 'data-key' ) + '</div>' );
				}
			}
		} );

		$body.on( 'mouseleave', '.acf-field', function(e){
			var $this = jQuery(this);
			if( $this.hasClass( 'acf-field' ) ){
				jQuery( '.show-field-key' ).remove();
			}
		} );

	    $body.on('click', function(e){
	    	var $this = jQuery( e.target );
			if( e.target.className.indexOf( 'show-field-key' ) > -1 ){
				if ( e.altKey || e.shiftKey ){
					e.stopPropagation();
					e.preventDefault();
			        var path = $this.html();
			        path = path.replace(/ &amp;gt; /g,".");
			        $path.val(path);
			        $wrap.addClass( 'opened' );
			        $path.focus();
			        $path.select();
		    	}else{
		    		$wrap.removeClass( 'opened' );
			    }
			}else{
				if( $this.attr('id') !== 'copypath' )
					$wrap.removeClass( 'opened' );

				// OPEN FIELDs COLUMN
				/*if( $this.hasClass( 'order' ) || $this.hasClass( 'fc-layout-order' ) ){
		    		e.stopPropagation();
					e.preventDefault();
					var $parent = jQuery( $this.parent( '.column' ) );
					if( !$parent.length )
						$parent = jQuery( $this.parent( '.acf-fc-layout-handle' ).parent( '.column' ) );
					if( $parent.length ){
						if( $parent.hasClass( 'full' ) ){
							//jQuery( '.acf-row' ).setColumnWidth();
							//$layout.setColumnWidth();
							$parent.removeClass( 'column-11' );
							$parent.removeClass( 'full' );						
						}else{
							$parent.addClass( 'column-11' );
							$parent.addClass( 'full' );
						}
					}*/
				//}
			}
	    });

		/*$('*').on('change', function(e) {
			var $elem = jQuery( e.target );
			if( $elem.hasClass('select2-offscreen') ){

				var $col = $elem.parent( '.select2-container' );
				if ( $col.length )
					$col = jQuery( $col ).parent( '.acf-input' ).parent( '.select2-columns_width' );
				else
					$col = $elem.parent( '.acf-input' ).parent( '.select2-columns_width' );
				if( $col.length ){
					e.stopPropagation();
					jQuery( '.acf-row' ).setColumnWidth();
					$layout.setColumnWidth();
				}
			}
		});*/

		/*$('*').on('change', function(e) {
			var $elem = jQuery( e.target );
			if( $elem.hasClass('select2-offscreen') ){

				var $col = $elem.parent( '.select2-container' );
				if ( $col.length )
					$col = jQuery( $col ).parent( '.acf-input' ).parent( '.select2-layout_main' );
				else
					$col = $elem.parent( '.acf-input' ).parent( '.select2-layout_main' );
				if( $col.length ){
					e.stopPropagation();
					//jQuery( '.acf-row' ).setLayoutWidth();
					$layout.setLayoutWidth();
				}


			}
		});*/


		// SHOW FIELD KEY
		
		var $path = jQuery('<textarea id="copypath"></textarea>'),
			$wrap = jQuery('<div id="toppathwrap"></div>'),
			$fields = jQuery( '.acf-field' );

		$wrap.append( $path );
		$body.append( $wrap );

		// COLUMNS WIDTH

		/*$rows.setColumnWidth();
		$layout.setColumnWidth();
		$layout.setLayoutWidth();*/

		// CONTROL MENU

		var $publish = jQuery( '#publishing-action, #edittag p.submit' );
		$publish.prepend( '<i class="fa fa-floppy-o"></i>' );
		$publish.prepend( '<i class="fa fa-spin fa-cog"></i>' );

		jQuery( '#major-publishing-actions' ).append( '<div id="options-action" style="cursor:pointer;"><i class="fa fa-bars"></i><div>' );
		jQuery( 'body:not(.post-new-php):not(.post-php) #options-action' ).css( 'display', 'none' );
		jQuery( 'body.post-php #save-action' ).css( 'display', 'none' );
		
		var $stuff = jQuery( '#poststuff' );

		var $options = jQuery( '#options-action' );
		$options.on( 'click', function(e){
			if( $stuff.hasClass( 'options' ) ){
				$stuff.removeClass( 'options' );
				$options.find( '.fa' ).addClass( 'fa-bars' ).removeClass( 'fa-times' );
			}else{
				$stuff.addClass( 'options' );
				$options.find( '.fa' ).addClass( 'fa-times' ).removeClass( 'fa-bars' );
			}
		} );


		jQuery( '#delete-action a' ).prepend( '<i class="fa fa-trash-o"></i>' );
		jQuery( '#delete-action a' ).prepend( '<i class="fa fa-spin fa-cog"></i>' );


		function htmlEntities(str) {
		    return String(str).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;');
		}
	

		var $save = jQuery( '#save-action' );
		if( $save.find( '.button' ).size() > 0 ){
			$save.prepend( '<i class="fa fa-file-o"></i>' );
			$save.prepend( '<i class="fa fa-spin fa-cog"></i>' );
		}

		jQuery( '#preview-action a' ).prepend( '<i class="fa fa-search"></i>' );


		jQuery( '#delete-action .deletion, #save-action .button, #publishing-action .button, #edittag p.submit' ).on( 'click', function(e){
			jQuery( 'div' ).remove( '.acf-error-message' );
			$body.addClass( 'loading' );
			checkDOMChange();
		});

		function checkDOMChange( cdc ){
		    
		    var $error = jQuery( '.acf-error-message' );
		    
		    if( !$error.length ){
			    setTimeout( checkDOMChange, 500 );
			    return;
			}

			$body.removeClass( 'loading' );

		}

		
		// TEMPLATES

		var $open_post = jQuery( '.posts-repeater .acf-row .order' );
		$open_post.on( 'click', function(e){
			var $this = jQuery( this );
			var $next = $this.next( '.acf-fields' );
			var id = $next.find( '[data-name="id"] input' ).val();
			window.location.href = 'post.php?post=' + id + '&action=edit';
		} );
		


		jQuery(window).load(function() {
			$body.addClass( 'loaded' );
		});


} )( jQuery );