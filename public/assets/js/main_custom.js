/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
"use strict";
var lan;
(function ($) {
    
    "use strict";
    function language() {
        var base_url = $("#base_url").val();
        var segment = $("#segment").val();
        var language = $("#language").val();
        var alllanguage='';
        $.ajax({url: base_url+'/public/assets/js/language.json',
            async: false,
            method:'post',
            dataType: 'json',
            global: false,
            contentType: 'application/json',
            success: function (data) {
                var lngdata = JSON.stringify(data);
                alllanguage = lngdata;
            }
        });
        lan = $.parseJSON(alllanguage);
        
        return lan;
    }
    language();


/*$('#receiver_id').on('blur',function(){
        var receiver_id = $(this).val();
         
        ReciverChack(receiver_id);
    });

    function ReciverChack(receiver_id){
       var csrf_test_name = document.forms['transfer_form'].elements['csrf_test_name'].value;
        if((receiver_id)!= ''){
            $.ajax({
                url: base_url+'/customer/ajaxload/checke_reciver_id',
                type: 'POST', //the way you want to send data to your URL
                data: {'receiver_id': receiver_id,'csrf_test_name':csrf_test_name },
                success: function(data) { 
                    
                        if(data!=0){
                        $('#user_id').css("border","1px green solid");
                        $('.suc').css("border","none green solid");
                        $('.suc').html("<span class='text-success fas fa-check'></span>");
                        $(".btn-success").prop('disabled', false);
                        } else {
                             $(".btn-success").prop('disabled', true);
                             $('#user_id').css("border","1px red solid");
                             $('.suc').html("<span class='text-danger fas fa-times'></span>");
                             $('.suc').css("border","none red solid");
                        }  

                    
                },
            });
        }
    }

$('#transfer_confirm_btn').on('click',function(){
        confirm_transfer();
    });

    function confirm_transfer(){

        var inputdata = $('#verify').serialize();

        swal({
            title: 'Please Wait......',
            type: 'warning',
            showConfirmButton: false,
            onOpen: function () {
                swal.showLoading()
              }
        });

        $.ajax({
            url: base_url+'/customer/transfer/transfer_verify',
            type: 'POST', //the way you want to send data to your URL
            data: inputdata,
            success: function(data) { 

                if(data!='' && data !=0){

                    var url      = $(location).attr('href');
                    var segments = url.split( '/' );
                    var tx_id    = segments[7];

                    swal({
                        title: "Good job!",
                        text: "Your Custom Email Send Successfully",
                        type: "success",
                        showConfirmButton: false,
                        timer: 1500,

                    });
                    window.location.href = base_url+"/customer/transfer/transfer_recite/"+tx_id; 
                } else {

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
$('#withdraw_payment_method').on('change',function(){
        withdraw($(this).val());
    });

    function withdraw(method){
        
        var csrf_test_name = document.forms['withdraw'].elements['csrf_test_name'].value;

        if (method=='phone') { method = 'phone'; }
       
        $.ajax({
            'url': base_url+'/customer/ajaxload/walletid',
            'type': 'POST', //the way you want to send data to your URL
            'data': {'method': method,'csrf_test_name':csrf_test_name },
            'dataType':'JSON',
            'success': function(data) { 
               
                if(data){

                    $('[name="walletid"]').val(data.wallet_id);
                    $('button[type=submit]').prop('disabled', false);
                    $('#walletidis').text('Your Wallet Id Is '+data.wallet_id);
                
                } else {
                    $('button[type=submit]').prop('disabled', true);
                    $('#walletidis').text('Your Have No Wallet Id ');
                }  
            }
        });
    }
    
$('#confirm_withdraw_btn').on('click',function(){
        confirm_withdraw();
       
    });

    //confirm withdraw
    function confirm_withdraw(){

        var inputdata = $('#verify').serialize();
        swal({
            title: 'Please Wait......',
            type: 'warning',
            showConfirmButton: false,
            onOpen: function () {
                swal.showLoading();
              }
        });

        $.ajax({
            url: base_url+'/customer/withdraw/withdraw_verify',
            type: 'POST', //the way you want to send data to your URL
            data: inputdata,
            success: function(data) { 
                if(data != ''){
                    swal({
                        title: "Good job!",
                        text: "Your Custom Email Send Successfully",
                        type: "success",
                        showConfirmButton: false,
                        timer: 1500

                    });

                   window.location.href = base_url+"/customer/withdraw/withdraw_details/"+data;
                    
                } else {

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
    
    $('#deposit_amount').on('keyup',function(){
        deposit_Fee();
    });
    $('#deposit_payment_method').on('change',function(){
        deposit_Fee();
    });

    function deposit_Fee(){ 
        
        var amount = document.forms['deposit_form'].elements['amount'].value;
        var method = document.forms['deposit_form'].elements['method'].value;
        var level = document.forms['deposit_form'].elements['level'].value;
       // alert(amount);

        if (amount!="" || amount==0) {
            $("#deposit_payment_method" ).prop("disabled", false);
        }
        if (amount=="" || amount==0) {
            $('#fee').text("Fees is "+0);
        }
        if (amount!="" && method!=""){

            //var inputdata = $('#deposit_form').serialize();

            //console.log(inputdata);
            var csrf_test_name = document.forms['deposit_form'].elements['csrf_test_name'].value;
          
            $.ajax({
                'url': base_url+'/customer/ajaxload/fees_load',
                'headers': {'X-Requested-With': 'XMLHttpRequest'},
                'type': 'POST', //the way you want to send data to your URL
                'data': {'amount':amount,'level':level,"csrf_test_name":csrf_test_name},
                'dataType': "JSON",
                'success': function(data) { 
                    if(data){
                        //remove from here, show amount after deduct fees as like fees
                        $('[name="fees"]').val(data.fees);
                        $('#fee').text("Fees is "+data.fees);                    
                    } else {
                        alert('Error!');
                    }  
                }
            });
        } 
    }

    $("#deposit_payment_method").on("change", function(event) {
        event.preventDefault();
        $.getJSON(base_url+'/customer/internal_api/gateway', function(data){
            var payment_method = $("#deposit_payment_method").val()|| 0;
            if (payment_method=='phone') {
                $( ".payment_info").html("<div class='form-group row'><label for='send_money' class='col-sm-4 col-form-label'>Send Money</label><div class='col-sm-8'><h2><a href='tel:"+data.public_key+"'>"+data.public_key+"</a></h2></div></div><div class='form-group row'><label for='om_name' class='col-sm-4 col-form-label'>"+lan['om_name'][language]+"</label><div class='col-sm-8'><input name='om_name' class='form-control om_name' type='text' id='om_name' autocomplete='off'></div></div><div class='form-group row'><label for='om_mobile' class='col-sm-4 col-form-label'>"+lan['om_mobile_no'][language]+"</label><div class='col-sm-8'><input name='om_mobile' class='form-control om_mobile' type='text' id='om_mobile' autocomplete='off'></div></div><div class='form-group row'><label for='transaction_no' class='col-sm-4 col-form-label'>"+lan['transaction_no'][language]+"</label><div class='col-sm-8'><input name='transaction_no' class='form-control transaction_no' type='text' id='transaction_no' autocomplete='off'></div></div><div class='form-group row'><label for='idcard_no' class='col-sm-4 col-form-label'>"+lan['idcard_no'][language]+"</label><div class='col-sm-8'><input name='idcard_no' class='form-control idcard_no' type='text' id='idcard_no' autocomplete='off'></div></div>");
            }
            else{
                $( ".payment_info").html("<div class='form-group row'><label for='comments' class='col-sm-4 col-form-label'>"+lan['comments'][language]+"</label><div class='col-sm-8'><textarea name='comments' class='form-control editor' placeholder='' type='text' id='comments'></textarea></div></div>");
            }
        });
    });

   

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
    $('#profile_confirm_btn').on('click',function(){
        confirm_profile();
    });
    
    function confirm_profile(){
        
        var inputdata = $('#verify').serialize();
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
                
                if(data!=''){

                    swal({
                        title: "Good job!",
                        text: "Your Custom Email Send Successfully",
                        type: "success",
                        showConfirmButton: false,
                        timer: 1500,

                    });
                    window.location.href = base_url+"/customer/profile/edit_profile"; 
                } else {
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
    $('.copy').on('click',function(){
        myFunction();
    });
    function myFunction() {
      var copyText = document.getElementById("copyed");
      copyText.select();
      document.execCommand("Copy");
    }*/
}(jQuery));