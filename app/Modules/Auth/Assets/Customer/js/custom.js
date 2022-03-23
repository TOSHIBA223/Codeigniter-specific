(function ($) {
"use strict";
 	$('.copy').on('click',function(){
        myFunction();
    });
	function myFunction() {
	    var copyText = document.getElementById("copyed");
	    copyText.select();
	    document.execCommand("Copy");
	}

}(jQuery));