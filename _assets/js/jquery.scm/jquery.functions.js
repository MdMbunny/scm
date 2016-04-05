(function($) {

	$.consoleDebug = function( db, lg ){
		if (db)
			console.log( lg );
	}

	$.EmToPx = function( input ) {
	    var emSize = parseFloat($("body").css("font-size"));
	    return (emSize * input);
	}

	$.PxToEm = function( input ) {
	    var emSize = parseFloat($("body").css("font-size"));
	    return (input / emSize);
	}

	// STRING

	$.startsWith = function( str, arr ){
		for (var i = 0; i < arr.length; i++) {
			if( str.indexOf( arr[i] ) === 0 )
				return true;
		};

		return false;
	}

	$.log = function( message, touch ) {
		if ( !touch && window.console ) {
			console.log( new Date().getTime() - performance.timing.navigationStart + 'ms' );
			console.log( message );
			console.log('---');
		}
	} 

	// Escape regex chars with \
	$.escapeBS = function( text ) {
		return text.replace(/[-[\]{}()*+?.,\\^$|#\s]/g, "\\$&");
	}

	$.removeSlash = function( text ) {
		return text.replace( /\//g, '' );
	}

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

	/*$.getScript = function( url, options ) {

		options = $.extend( options || {}, {
			dataType: "script",
			cache: true,
			url: url
		});

		return $.ajax( options );
	};*/

	$.getScripts = function(arr, path) {

		if( typeof( arr ) == 'string' ){
			arr = [ arr ];
		}
	    var _arr = $.map(arr, function(scr) {
	        return $.getScript( (path||"") + scr );
	    });

	    _arr.push($.Deferred(function( deferred ){
	        $( deferred.resolve );
	    }));

	    return $.when.apply($, _arr);
	}

	/*$.getScripts = function( arr, callback ) {

		if( typeof( arr ) == 'string' ){
			arr = [ arr ];
		}

		var progress = 0;

	    var internalCallback = function () {

	        if ( ++progress == arr.length ) {
	        	callback();
	        }
	    };

	    arr.forEach( function( script ) {

	    	$.getScript( script, internalCallback );

	    });
	}*/
 

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