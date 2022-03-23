(function ($) {
"use strict";

 if($("#weekly_roi").length){
        var weekly_roi      = parseFloat($("#weekly_roi").val())|| 0;
        if (weekly_roi>0) {
            $( "#weekly_roi" ).prop( "disabled", false);
        }
    }

    $("#package_amount").on("keyup", function(event) {
        event.preventDefault();
        var package_amount  = parseFloat($("#package_amount").val())|| 0;

        if (package_amount>0) {

            $( "#weekly_roi" ).prop( "disabled", false);

            var package_amount  = parseFloat($("#package_amount").val())|| 0;
            var weekly_roi      = parseFloat($("#weekly_roi").val())|| 0;
            var monthly_roi     = parseFloat($("#monthly_roi").val())|| 0;
            var yearly_roi      = parseFloat($("#yearly_roi").val())|| 0;
            var total_percent   = parseFloat($("#total_percent").val())|| 0;

            if (weekly_roi>0) {
                if (package_amount) {
                    monthly_roi     = (365/12)/7*weekly_roi;
                    yearly_roi      = monthly_roi*12;
                    total_percent   = (100*yearly_roi)/package_amount;

                    $("#monthly_roi").val(Math.round(monthly_roi));
                    $("#yearly_roi").val(Math.round(yearly_roi));
                    $("#total_percent").val(Math.round(total_percent));

                }else{
                    alert("Please Enter Package amount!");
                    return false;

                }
            }else{
                $("#daily_roi").val(0);
                $("#weekly_roi").val(0);
                $("#monthly_roi").val(0);
                $("#yearly_roi").val(0);
                $("#total_percent").val(0);
            }

        }
        else{
            $( "#weekly_roi" ).prop( "disabled", true);
            
        }
    });

    $("#weekly_roi").on("keyup", function(event) {
        event.preventDefault();
        var package_amount  = parseFloat($("#package_amount").val())|| 0;
        var weekly_roi      = parseFloat($("#weekly_roi").val())|| 0;
        var monthly_roi     = parseFloat($("#monthly_roi").val())|| 0;
        var yearly_roi      = parseFloat($("#yearly_roi").val())|| 0;
        var total_percent   = parseFloat($("#total_percent").val())|| 0;


        if (package_amount) {
            monthly_roi     = (365/12)/7*weekly_roi;
            yearly_roi      = monthly_roi*12;
            total_percent   = (100*yearly_roi)/package_amount;

            $("#monthly_roi").val(monthly_roi.toFixed(4));
            $("#yearly_roi").val(yearly_roi.toFixed(4));
            $("#total_percent").val(total_percent.toFixed(4));

        }else{
            alert("Please Enter Package amount!");
            return false;
        }
    });


}(jQuery));