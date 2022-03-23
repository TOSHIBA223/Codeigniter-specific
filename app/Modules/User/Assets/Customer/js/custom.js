(function ($) {
"use strict";
	$('#profile_confirm_btn').on('click',function(){
        confirm_profile();
    });
    
    function confirm_profile(){
        
        var inputdata = $('#verify').serialize();
        var base_url = $("#base_url").val();
	
	    var segment = $("#segment").val();
	    var language = $("#language").val();
        swal({
            title: 'Please Wait......',
            type: 'warning',
            showConfirmButton: false,
            onOpen: function () {
                swal.showLoading()
              }
        });

        $.ajax({
            url: base_url+'/customer/profile/profile_update',
            type: 'POST', //the way you want to send data to your URL
            data: inputdata,
            success: function(data) { 
                
                if(data =='1'){

                    swal({
                        title: "Good job!",
                        text: "Profile Update Successfully",
                        type: "success",
                        showConfirmButton: false,
                        timer: 1500,

                    });
                    window.location.href = base_url+"/customer/profile/edit_profile"; 
                } else if(data=='2'){
                    swal({
                        title: "Wops!",
                        text: lan['wrong_verification_code'][language],
                        type: "error",
                        showConfirmButton: false,
                        timer: 1500
                    });

                }
            }
        });
    }

}(jQuery));