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

			//for (var i = sel.length - 1; i >= 0; i--) {
				//$sel = jQuery( sel[i] );

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
					
					/*if( $this.hasClass( 'column-' + value ) )
						return this;*/
					
					$this.removeClass( function (index, css) {
					    return (css.match (/\bcolumn-\S+/g) || []).join(' ');
					} );

					$this.addClass( 'column-' + value );
				}

			//};

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

	jQuery(function($){

		jQuery(document).ready(function(){

			// SHOW FIELD KEY

			jQuery( 'body' ).append( '<div id="toppathwrap"><textarea id="copypath"></textarea></div>' );
			var $wrap = jQuery('#toppathwrap');
			var $path = jQuery('#copypath');
			var $fields = jQuery( '.acf-field' );

			/*jQuery( 'body' ).keydown( function(e){
				if ( e.which == 18 ) {
					jQuery( 'body' ).trigger( 'mouseenter' );
					//e.stopPropagation();
				}
			} );

			jQuery( 'body' ).keyup( function(e){
				if ( e.which == 18 ) {
					jQuery( 'body' ).trigger( 'mouseleave' );
					//e.stopPropagation();
				}
			} );*/

			jQuery( 'body' ).on( 'mouseenter', '.acf-field', function(e){
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

			jQuery( 'body' ).on( 'mouseleave', '.acf-field', function(e){
				var $this = jQuery(this);
				if( $this.hasClass( 'acf-field' ) ){
					jQuery( '.show-field-key' ).remove();
				}
			} );

		    jQuery( 'body' ).on('click', function(e){
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
				}else if( $this.attr('id') !== 'copypath' ){
					$wrap.removeClass( 'opened' );
				}
		    });

		    // OPEN FIELDs COLUMN

		    jQuery( 'body' ).on('click', function(e){
		    	var $this = jQuery( e.target );
		    	if( $this.hasClass( 'order' ) || $this.hasClass( 'fc-layout-order' ) ){
		    		e.stopPropagation();
					e.preventDefault();
					var $parent = jQuery( $this.parent( '.column' ) );
					if( !$parent.length )
						$parent = jQuery( $this.parent( '.acf-fc-layout-handle' ).parent( '.column' ) );
					if( $parent.length ){
						if( $parent.hasClass( 'full' ) ){
							//jQuery( '.acf-row' ).setColumnWidth();
							//jQuery('.layout' ).setColumnWidth();
							$parent.removeClass( 'column-11' );
							$parent.removeClass( 'full' );						
						}else{
							$parent.addClass( 'column-11' );
							$parent.addClass( 'full' );
						}
					}
				}

		    });

		    //jQuery( '.special-repeater > .acf-input > .acf-repeater > table > tbody > .acf-row > td.order' ).setColumnWidth();

			// COLUMNS WIDTH

			jQuery( '.acf-row' ).setColumnWidth();
			jQuery('.layout' ).setColumnWidth();

			//jQuery( '.acf-row' ).setLayoutWidth();
			jQuery('.layout' ).setLayoutWidth();

			$('*').on('change', function(e) {
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
						jQuery('.layout' ).setColumnWidth();
					}
				}
			});

			// ROWS WIDTH

			$('*').on('change', function(e) {
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
						jQuery('.layout' ).setLayoutWidth();
					}


				}
			});

			// CONTROL MENU

			var $publish = jQuery( '#publishing-action, #edittag p.submit' );
			$publish.prepend( '<i class="fa fa-floppy-o"></i>' );
			$publish.prepend( '<i class="fa fa-spin fa-cog"></i>' );

			jQuery( '#major-publishing-actions' ).append( '<div id="options-action" style="cursor:pointer;"><i class="fa fa-bars"></i><div>' );
			jQuery( 'body:not(.post-new-php):not(.post-php) #options-action' ).css( 'display', 'none' );
			jQuery( 'body.post-php #save-action' ).css( 'display', 'none' );
			
			//jQuery( '#delete-action' ).prepend( '<i class="fa fa-trash-o"></i>' );

			var $stuff = jQuery( '#poststuff' );
			/*$stuff.addClass( 'options' );*/

			var $options = jQuery( '#options-action' );
			$options.on( 'click', function(e){
				if( $stuff.hasClass( 'options' ) ){
					$stuff.removeClass( 'options' );
					$options.find( '.fa' ).addClass( 'fa-bars' ).removeClass( 'fa-times' );
					//$wrap.css( 'margin-bottom', '-200px' );
				}else{
					$stuff.addClass( 'options' );
					$options.find( '.fa' ).addClass( 'fa-times' ).removeClass( 'fa-bars' );
				}
			} );

			/*jQuery( 'body' ).on('mousedow', function(e){
		    	var $this = jQuery( e.target );
				if( $this.attr('id') !== 'postbox-container-1' ){
					if( $stuff.hasClass( 'options' ) )
					$stuff.removeClass( 'options' );
				}
		    });*/

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
				jQuery( 'body' ).addClass( 'loading' );
				checkDOMChange();
			});

			function checkDOMChange( cdc ){
			    
			    var $error = jQuery( '.acf-error-message' );
			    
			    if( !$error.length ){
				    setTimeout( checkDOMChange, 500 );
				    return;
				}

				jQuery( 'body' ).removeClass( 'loading' );

			}

			

			jQuery(window).load(function() {
				jQuery( 'body' ).addClass( 'loaded' );
			});

			// TEMPLATES

			var $open_post = jQuery( '.posts-repeater .acf-row .order' );
			$open_post.on( 'click', function(e){
				var $this = jQuery( this );
				var $next = $this.next( '.acf-fields' );
				var id = $next.find( '[data-name="id"] input' ).val();
				window.location.href = 'post.php?post=' + id + '&action=edit';
			} );
			
			//jQuery(window).load(function() {
				/*var $duplicate_post = jQuery( '.posts-repeater .acf-row .acf-repeater-add-row' );
				$duplicate_post.each( function(){
					var $this = jQuery( this );
					var $prev = $this.parents( 'td' ).prev( '.acf-fields' );
					var id = $prev.find( '[data-name="id"] input' ).val();
					$this.attr( 'title', 'Duplica questo oggetto' ).attr( 'rel', 'permalink' );
				});*/
			//});

			/*$duplicate_post.on( 'click', function(e){
				e.preventDefault();
				e.stopPropagation();
				var $this = jQuery( this );
				var $prev = $this.parents( 'td' ).prev( '.acf-fields' );
				var id = $prev.find( '[data-name="id"] input' ).val();
				window.location.href = 'admin.php?action=scm_admin_duplicate_post&amp;post=' . id;
			} );*/

			// ADMIN MENU

			/*var $sub_menus = jQuery( '#adminmenu li.wp-has-submenu' );
			$sub_menus.each( function(){

				var $this = jQuery( this );
				var $link = $this.children( 'a.wp-has-submenu' );
				var href = '';
				if( $link.length )
					href = $link.attr( 'href' );

				if( href.indexOf( 'edit.php?' ) === 0 ){
					var $links = $this.find( '.wp-submenu .wp-first-item' );
					if( $links.length ){
						$links.css( 'display', 'none' );
						//$links.next( 'li' ).find( 'a' ).html( '+' ).css({ 'text-align' : 'center', 'font-size' : '2em', 'line-height' : '1em' });
					}

				}



			});*/

			// HIDE LABEL IF PREPEND

			//var $prep = jQuery( '.acf-input-prepend, .acf-color_picker' ).parent( '.acf-input' ).siblings( '.acf-label' ).css( 'display', 'none' );


		});
	});

} )( jQuery );