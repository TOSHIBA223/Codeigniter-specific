(function ($) {
"use strict";
	var base_url = $("#base_url").val();
	
    var segment = $("#segment").val();
    var language = $("#language").val();
   
    
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
    if($('#ajaxdeposittableform').length){
        var table;
        var ajaxdeposittableform = JSON.stringify($('#ajaxdeposittableform').serializeArray());
        var formdata          = $.parseJSON(ajaxdeposittableform);
        var inputname         = formdata[0]['name'];
        var inputval          = formdata[0]['value'];
        var user_id           = $('#user_id').val();

        //datatables
        table = $('#deposittable').DataTable({ 

            "processing": true, //Feature control the processing indicator.
            "serverSide": true, //Feature control DataTables' server-side processing mode.
            "order": [],        //Initial no order.
            "pageLength": 10,   // Set Page Length
            //"lengthMenu":[[5,10, 25, 50, 100, -1], [5,10, 25, 50, 100, "All"]],
            "paging": true,
            "searching": true,
            dom: "<'row'<'col-sm-3'l><'col-sm-3'B><'col-sm-3'f>>tp", 
            dom: 'Bfrtip',
            "buttons": [
            {
                        extend: 'copy',
                        text: '<i class="far fa-copy"></i>',
                        titleAttr: 'Copy',
                        className: 'btn-success'
                    },
                            {
                        extend: 'csv',
                        text: '<i class="fas fa-file-csv"></i>',
                        titleAttr: 'CSV',
                        className: 'btn-success'
                    },
                    {
                        extend: 'excel',
                         text: '<i class="far fa-file-excel"></i>',
                        titleAttr: 'Excel',
                        className: 'btn-success'
                    },
                    {
                        extend: 'pdf',
                        text: '<i class="far fa-file-pdf"></i>',
                        titleAttr: 'PDF',
                        className: 'btn-success'
                    },
                    {
                        extend: 'print',
                          text: '<i class="fa fa-print" aria-hidden="true"></i>',
                        titleAttr: 'Print',
                        className: 'btn-success'
                    }
        ],
            // Load data for the table's content from an Ajax source
            "ajax": {
                "url": base_url+'/customer/deposit/deposit_list/'+user_id,
                "type": "POST",
                "data": {csrf_test_name:inputval}
            },

            //Set column definition initialisation properties.
            "columnDefs": [
            { 
                "targets": [ 0 ], //first column / numbering column
                "orderable": false, //set not orderable
            },
            ],
           "fnInitComplete": function (oSettings, response) {
          }

        });

        $.fn.dataTable.ext.errMode = 'none';
    }
    if($('#ajaxwithdrawtableform').length){
        var table;
        var ajaxwithdrawtableform = JSON.stringify($('#ajaxwithdrawtableform').serializeArray());
        var formdata          = $.parseJSON(ajaxwithdrawtableform);
        var inputname         = formdata[0]['name'];
        var inputval          = formdata[0]['value'];
        var user_id           = $('#user_id').val();
        
        //datatables
        table = $('#withdrawtable').DataTable({ 

            "processing": true, //Feature control the processing indicator.
            "serverSide": true, //Feature control DataTables' server-side processing mode.
            "order": [],        //Initial no order.
            "pageLength": 7,   // Set Page Length
            //"lengthMenu":[[5,10, 25, 50, 100, -1], [5,10, 25, 50, 100, "All"]],
            "paging": true,
            "searching": true,
            dom: "<'row'<'col-sm-3'l><'col-sm-3'B><'col-sm-3'f>>tp", 
            dom: 'Bfrtip',
            "buttons": [
            {
                        extend: 'copy',
                        text: '<i class="far fa-copy"></i>',
                        titleAttr: 'Copy',
                        className: 'btn-success'
                    },
                            {
                        extend: 'csv',
                        text: '<i class="fas fa-file-csv"></i>',
                        titleAttr: 'CSV',
                        className: 'btn-success'
                    },
                    {
                        extend: 'excel',
                         text: '<i class="far fa-file-excel"></i>',
                        titleAttr: 'Excel',
                        className: 'btn-success'
                    },
                    {
                        extend: 'pdf',
                        text: '<i class="far fa-file-pdf"></i>',
                        titleAttr: 'PDF',
                        className: 'btn-success'
                    },
                    {
                        extend: 'print',
                          text: '<i class="fa fa-print" aria-hidden="true"></i>',
                        titleAttr: 'Print',
                        className: 'btn-success'
                    }
        ],
            // Load data for the table's content from an Ajax source
            "ajax": {
                "url": base_url+'/customer/withdraw/withdraw_ajax_list/'+user_id,
                "type": "POST",
                "data": {csrf_test_name:inputval}
            },

            //Set column definition initialisation properties.
            "columnDefs": [
            { 
                "targets": [ 0 ], //first column / numbering column
                "orderable": false, //set not orderable
            },
            ],
           "fnInitComplete": function (oSettings, response) {
          }

        });

        $.fn.dataTable.ext.errMode = 'none';
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
    $('#receiver_id').on('blur',function(){
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

}(jQuery));