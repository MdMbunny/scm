( function($){

	jQuery.fn.setColumnWidth = function(e){

		return this.each( function(){

			var $this = jQuery(this);
			var $parent = $this.closest('.acf-row');
			var value = $this.val();

			if( $parent.hasClass( 'column-' + value ) )
				return this;
			
			$parent.removeClass( function (index, css) {
			    return (css.match (/\bcolumn-\S+/g) || []).join(' ');
			} );

			$parent.addClass( 'column-' + value );

		} );

	}

	jQuery(function($){

		jQuery(document).ready(function(){

			var $elem = jQuery('div[data-name=select_columns_width] .acf-input input[type=hidden].select2-offscreen');
			$elem.setColumnWidth();

			jQuery( 'body' ).mouseenter( function(e){
				e.stopPropagation();
				jQuery('div[data-name=select_columns_width] .acf-input input[type=hidden].select2-offscreen').setColumnWidth(e);
				return false;
			});

		});
	});

} )( jQuery );