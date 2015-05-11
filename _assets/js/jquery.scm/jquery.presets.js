(function($) {

	$.iconLoading = function( dimension, classes, icon ) {

		dimension = ( dimension ? dimension : 'quadruple' );
		classes = ( classes ? classes : 'relative middle' );
		icon = ( icon ? icon : 'spinner' );

		return '<div class="scm-loading loading ' + dimension + ' ' + classes + '""><i class="fa fa-spin fa-' + icon + '""></i></div>';

	}

})( jQuery );