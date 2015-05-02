

(function($) {

	// STRING

	// Escape regex chars with \
	$.escapeBS = function( text ) {
		return text.replace(/[-[\]{}()*+?.,\\^$|#\s]/g, "\\$&");
	};

	$.trailingSlash = function( str ) {

	    if( str.substr( -1 ) == '/')
	        return str.substr( 0, str.length - 1 );

	    return str;

	}

	$.getUrlData = function( str ) {

	    str = str.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");

	    var regex = new RegExp("[\\?&]" + str + "=([^&#]*)"),
	        results = regex.exec(location.search);

	    return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
	    
	}

	$.getUrlParameter = function( param ) {

	    var sPageURL = window.location.search.substring( 1 );
	    var sURLVariables = sPageURL.split( '&' );

	    for ( var i = 0; i < sURLVariables.length; i++ ) {

	        var sParameterName = sURLVariables[i].split( '=' );

	        if ( sParameterName[0] == param ) {

	            return sParameterName[1];

	        }
	    }

	} 

	// WORDPRESS
/*
	$.wpUpdateOption = function( name, value, fun ) {

		$.post(
		    $( 'body' ).data( 'site' ) + '/wp-admin/admin-ajax.php', 
		    {
		        'action': name,
		        'data':   value,
		    }, fun
		);

    }
*/
})( jQuery );