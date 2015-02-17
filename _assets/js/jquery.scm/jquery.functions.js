
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

	// WORDPRESS

	$.wpUpdateOption = function( name, value, fun ) {

		$.post(
		    'http://www.mdmbunny.com/service/progefarm/wp-admin/admin-ajax.php', 
		    {
		        'action': name,
		        'data':   value
		    }, fun
		);
    }

})( jQuery );