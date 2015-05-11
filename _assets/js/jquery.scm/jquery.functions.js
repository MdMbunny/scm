

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

	$.getUrlParameter = function( param, url ) {

		if( !url )
	    	url = window.location.search.substring( 1 );
	    
	    var sURLVariables = url.split( '?' );

	    for ( var i = 1; i < sURLVariables.length; i++ ) {

	        var sParameterName = sURLVariables[i].split( '=' );

	        var name = sParameterName[0];
	        var num = sParameterName[1].split( '#' )[0];

	        if ( name == param ) {

	            return num;

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