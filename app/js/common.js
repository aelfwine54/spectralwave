$('.alert [data-dismiss="alert"]').click(function(){
		$(this).closest('.alert').slideUp(500);
});

function deleteCookie(c_name) {
    document.cookie = encodeURIComponent(c_name) + "=deleted; expires=" + new Date(0).toUTCString();
}

var getCookie = function(c_name) {
	var i, x, y, ARRcookies = document.cookie.split(";");
	for (i = 0; i < ARRcookies.length; i++) {
		x = ARRcookies[i].substr(0, ARRcookies[i].indexOf("="));
		y = ARRcookies[i].substr(ARRcookies[i].indexOf("=") + 1);
		x = x.replace(/^\s+|\s+$/g, "");
		if (x == c_name) {
			return unescape(y);
		}
	}
}

function parseDate(input) {
  var parts = input.match(/(\d+)/g);
  // new Date(year, month [, date [, hours[, minutes[, seconds[, ms]]]]])
  return new Date(parts[2], parts[1], parts[0], parts[3], parts[4]); // months are 0-based
}

/*
 * Show the alert located at the given selector. The alert will be shown for 5 seconds. A click remove the timeout.
 * A double click make it slideUp directly, without any timeout
 */
function alertSuccess(selector){
    $(selector).slideDown(500,function(){
        window.timeout = setTimeout(function(){
            $(selector).slideUp(500)},5000)
    });

    $(selector).click(function(){
        clearTimeout(window.timeout);
    });

    $(selector).dblclick(function(){
        clearTimeout(window.timeout);
        $(selector).slideUp(500);
    });

    $(selector+' .alert-close').click(function(){
    	$(selector).slideUp(500);
    })
}

function alertNotification(selector){
    $(selector).fadeIn(500,function(){
        window.timeout = setTimeout(function(){
            $(selector).fadeOut(500)},10000)
    });

    $(selector).click(function(){
        clearTimeout(window.timeout);
    });

    $(selector).dblclick(function(){
        clearTimeout(window.timeout);
        $(selector).fadeOut(500);
    });
}


/*
 * Show the alert located at the given selector with a slideDown effect
 */
function alertError(selector){
	$(selector).slideDown(500);

	$(selector+' .alert-close').click(function(){
		$(selector).slideUp(500);
		var scope = angular.element(selector).scope();
		scope.errorMessage = null;
	})
}	

function nl2br (str, is_xhtml) {
    // Converts newlines to HTML line breaks  

    var breakTag = (is_xhtml || typeof is_xhtml === 'undefined') ? '' : '<br>';
 
    return (str + '').replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g, '$1' + breakTag + '$2');
}

function findById(source, id) {
    return source.filter(function( obj ) {
        // coerce both obj.id and id to numbers 
        // for val & type comparison
        return +obj.id === +id;
    })[ 0 ];
}