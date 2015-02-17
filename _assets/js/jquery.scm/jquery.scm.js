( function($){

	jQuery(function($){


	// *****************************************************
	// *      TOGGLE MENU
	// *****************************************************

		$( '.navigation' ).on( 'toggledOn', function(e){

			$elems = $( this ).find( '[data-toggle="on"]' );
			$elems.css( 'transform', 'rotate(90deg)' );
			$elems.animate( { transform: 'rotate(0deg)' }, 200, 'linear' );

		} );

		$( '.navigation' ).on( 'toggledOff', function(e){

			$elems = $( this ).find( '[data-toggle="off"]' );
			$elems.css('transform', 'rotate(-90deg)');
			$elems.animate( { transform: 'rotate(0deg)' }, 200, 'linear' );

		} );

	});

} )( jQuery );