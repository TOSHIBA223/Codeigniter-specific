(function ($) {
"use strict";
   var base_url = $("#base_url").val();
	
    var segment = $("#segment").val();
    var language = $("#language").val();
    $("#cid").on("change", function(event) {
        event.preventDefault();

        var inputdata = $('#buy_form').serialize();

        $.ajax({
            url: base_url+"/customer/buy/buypayable",
            type: "post",
            data: inputdata,
            success: function(data) {
                $( ".buy_payable").html(data);
                $( "#buy_amount" ).prop( "disabled", false );
            },
            error: function(){
            }
        });
    });

    $("#buy_amount").on("keyup", function(event) {
        event.preventDefault();
        var buy_amount = parseFloat($("#buy_amount").val())|| 0;
        var cid = $("#cid").val()|| 0;

        if (cid=="") {
            alert(lan['please_select_cryptocurrency_first'][language]);
            return false;
        } else {

            var inputdata = $('#buy_form').serialize();

            $.ajax({
                url: base_url+"/customer/buy/buypayable",
                type: "post",
                data: inputdata,
                success: function(data) {
                    $( ".buy_payable").html(data);
                },
                error: function(){
                    return false;
                }
            });
        }
    });

    $("#payment_method").on("change", function(event) {
        event.preventDefault();
        $.getJSON(base_url+'/customer/internal_api/gateway', function(data){
            var payment_method = $("#payment_method").val()|| 0;
            var cid            = $("#cid").val()|| 0;

            if (payment_method==='bitcoin' && cid==1) {
                alert(lan['please_select_diffrent_payment_method'][language]);
                $('#payment_method option:selected').removeAttr('selected');
                return false;
            }

            if (payment_method==='phone') {
                $( ".payment_info").html("<div class='form-group row'><label for='send_money' class='col-sm-4 col-form-label'>"+lan['send_money'][language]+"</label><div class='col-sm-8'><h2><a href='tel:"+data.public_key+"'>"+data.public_key+"</a></h2></div></div><div class='form-group row'><label for='om_name' class='col-sm-4 col-form-label'>"+lan['om_name'][language]+"</label><div class='col-sm-8'><input name='om_name' class='form-control om_name' type='text' id='om_name' autocomplete='off'></div></div><div class='form-group row'><label for='om_mobile' class='col-sm-4 col-form-label'>"+lan['om_mobile_no'][language]+"</label><div class='col-sm-8'><input name='om_mobile' class='form-control om_mobile' type='text' id='om_mobile' autocomplete='off'></div></div><div class='form-group row'><label for='transaction_no' class='col-sm-4 col-form-label'>"+lan['transaction_no'][language]+"</label><div class='col-sm-8'><input name='transaction_no' class='form-control transaction_no' type='text' id='transaction_no' autocomplete='off'></div></div><div class='form-group row'><label for='idcard_no' class='col-sm-4 col-form-label'>"+lan['idcard_no'][language]+"</label><div class='col-sm-8'><input name='idcard_no' class='form-control idcard_no' type='text' id='idcard_no' autocomplete='off'></div></div>");
            }
            else{
                $( ".payment_info").html("<div class='form-group row'><label for='comments' class='col-sm-4 col-form-label'>"+lan['comments'][language]+"</label><div class='col-sm-8'><textarea name='comments' class='form-control editor' placeholder='' type='text' id='comments' autocomplete='off'></textarea></div></div>");
            }
        });
    });

    $("#sell_cid").on("change", function(event) {
        event.preventDefault();
        var inputdata = $('#sell_form').serialize();

        $.ajax({
            url: base_url+"/customer/sell/sellpayable",
            type: "post",
            data: inputdata,
            success: function(data) {
                $( ".sell_payable").html(data);
                $( "#sell_amount" ).prop( "disabled", false );
            },
            error: function(x){
                return false;
            }
        });
    });

    $("#sell_amount").on("keyup", function(event) {
        event.preventDefault();

        var sell_amount = parseFloat($("#sell_amount").val())|| 0;
        var cid = $("#sell_cid").val()|| 0;

        if (cid=="") {
            alert(lan['please_select_cryptocurrency_first'][language]);
            return false;
        } else {
            
            var inputdata = $('#sell_form').serialize();
             $.ajax({
                url: base_url+"/customer/sell/sellpayable",
                type: "post",
                data: inputdata,
                success: function(data) {
                    $( ".sell_payable").html(data);
                },
                error: function(){
                    return false;
                }
            });
        }
    });

    $("#sell_payment_method").on("change", function(event) {
        event.preventDefault();
        $.getJSON(base_url+'/customer/internal_api/gateway', function(data){

            var payment_method = $("#sell_payment_method").val()|| 0;

            if (payment_method==='bitcoin') {
                $( ".payment_info").html("<div class='form-group row'><label for='comments' class='col-sm-4 col-form-label comments_level'>"+lan['bitcoin_wallet_id'][language]+"</label><div class='col-sm-8'><textarea name='comments' class='form-control editor' placeholder='' type='text' id='comments' autocomplete='off'></textarea></div></div>");
            }else if(payment_method==='payeer'){
               $( ".payment_info").html("<div class='form-group row'><label for='comments' class='col-sm-4 col-form-label comments_level'>"+lan['payeer_wallet_id'][language]+"</label><div class='col-sm-8'><textarea name='comments' class='form-control editor' placeholder='' type='text' id='comments' autocomplete='off'></textarea></div></div>");
            }else if(payment_method==='phone'){
                $( ".payment_info").html("<div class='form-group row'><label for='send_money' class='col-sm-4 col-form-label'>"+lan['send_money'][language]+"</label><div class='col-sm-8'><h2><a href='tel:"+data.public_key+"'>"+data.public_key+"</a></h2></div></div><div class='form-group row'><label for='om_name' class='col-sm-4 col-form-label'>"+lan['om_name'][language]+"</label><div class='col-sm-8'><input name='om_name' class='form-control om_name' type='text' id='om_name' autocomplete='off'></div></div><div class='form-group row'><label for='om_mobile' class='col-sm-4 col-form-label'>"+lan['om_mobile_no'][language]+"</label><div class='col-sm-8'><input name='om_mobile' class='form-control om_mobile' type='text' id='om_mobile' autocomplete='off'></div></div><div class='form-group row'><label for='transaction_no' class='col-sm-4 col-form-label'>"+lan['transaction_no'][language]+"</label><div class='col-sm-8'><input name='transaction_no' class='form-control transaction_no' type='text' id='transaction_no' autocomplete='off'></div></div><div class='form-group row'><label for='idcard_no' class='col-sm-4 col-form-label'>"+lan['idcard_no'][language]+"</label><div class='col-sm-8'><input name='idcard_no' class='form-control idcard_no' type='text' id='idcard_no' autocomplete='off'></div></div>");               
            }
            else{
                $( ".payment_info").html("<div class='form-group row'><label for='comments' class='col-sm-4 col-form-label comments_level'>"+lan['account_info'][language]+"</label><div class='col-sm-8'><textarea name='comments' class='form-control editor' placeholder='' type='text' id='comments' autocomplete='off'></textarea></div></div>");
            }
        });
    });
    

}(jQuery));