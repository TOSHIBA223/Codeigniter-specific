(function ($) {
"use strict";
var base_url = $("#base_url").val();
	$("#receving_status").on("click", function(event) {
        if ($('#receving_status').is(':checked')){
            window.setTimeout(function(){
                
                $( ".receving_complete .i-check").html("<label for='receving_status_confirm'><input tabindex='5' type='checkbox' id='receving_status_confirm' name='receving_status_confirm' value='resconf'>Confirm <i class='fa fa-spinner fa-spin' style='font-size:24px'></i><span class='checkmark'></span></label>");

                $("#receving_status_confirm").on("click", function(event) {
                    if ($('#receving_status_confirm').is(':checked')){

                        var inputdata = $('#exchange_form').serialize();

                        $.ajax({
                            url: base_url+"/backend/exchange/receiveConfirm",
                            type: "post",
                            data: inputdata,
                            success: function(data) {
                                $( ".receving_complete .i-check").html(data);
                                location.reload();
                            },
                            error: function(){
                               $( ".receving_complete").html("<h1>Error</h1>");
                               location.reload();
                            }
                        });
                    }
                });
            }, 500);
        }
    });

    $("#payment_status").on("click", function(event) {
        if ($('#payment_status').is(':checked')){
           window.setTimeout(function(){
               
                $( ".payment_complete .i-check").html("<label for='payment_status_confirm'><input tabindex='5' type='checkbox' id='payment_status_confirm' name='payment_status_confirm' value='resconf'>Confirm <i class='fa fa-spinner fa-spin' style='font-size:24px'></i><span class='checkmark'></span></label>");

                $("#payment_status_confirm").on("click", function(event) {
                    if ($('#payment_status_confirm').is(':checked')){

                        var inputdata = $('#exchange_payment_form').serialize();
                        
                        $.ajax({
                            url: base_url+"/backend/exchange/receiveConfirm",
                            type: "post",
                            data: inputdata,
                            success: function(data) {
                                $( ".payment_complete .i-check").html(data);
                                location.reload();
                            },
                            error: function(){
                               $( ".payment_complete").html("<h1>Error</h1>");
                               location.reload();
                            }
                        });
                    }
                });
            }, 500);
        }
    });
}(jQuery));