<?php
$CI = EMS_Controller::get_instance();
?>
<style>
    .button_print {

        border: none;
        color: white;
        padding: 10px 15px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 10px;
        margin: 1px 1px;
        cursor: pointer;
        background-color: #2F419B;

    }

    #print {
        text-align: right;
        padding-right: 10px;

    }


    /*
 CSS for the main interaction
*/


:root {
    --switches-bg-color: goldenrod;
    --switches-label-color: white ;
    --switch-bg-color: white;
    --switch-text-color: goldenrod ;
}


/* a container - decorative, not required */

/* p - decorative, not required */


/* container for all of the switch elements 
    - adjust "width" to fit the content accordingly 
*/
.switches-container {
    width: 16rem;
    position: relative;
    display: flex;
    padding: 0;
    position: relative;
    background: #2f419b;
    line-height: 3rem;
    border-radius: 3rem;
    /* margin-left: auto; */
    margin-right: auto;
}

/* input (radio) for toggling. hidden - use labels for clicking on */
.switches-container input {
    visibility: hidden;
    position: absolute;
    top: 0;
}

/* labels for the input (radio) boxes - something to click on */
.switches-container label {
    width: 50%;
    padding: 0;
    margin: 0;
    text-align: center;
    cursor: pointer;
    color: var(--switches-label-color);
}

/* switch highlighters wrapper (sliding left / right) 
    - need wrapper to enable the even margins around the highlight box
*/
.switch-wrapper {
    position: absolute;
    top: 0;
    bottom: 0;
    width: 50%;
    padding: 0.15rem;
    z-index: 3;
    transition: transform .5s cubic-bezier(.77, 0, .175, 1);
    /* transition: transform 1s; */
}

/* switch box highlighter */
.switch {
    border-radius: 3rem;
    background: #06e3e3;
    height: 100%;
    width: 100%;
}

/* switch box labels
    - default setup
    - toggle afterwards based on radio:checked status 
*/
.switch div {
    width: 100%;
    text-align: center;
    opacity: 0;
    display: block;
    color: var(--switch-text-color) ;
    transition: opacity .2s cubic-bezier(.77, 0, .175, 1) .125s;
    will-change: opacity;
    position: absolute;
    top: 0;
    left: 0;
}

/* slide the switch box from right to left */
.switches-container input:nth-of-type(1):checked~.switch-wrapper {
    transform: translateX(0%);
}

/* slide the switch box from left to right */
.switches-container input:nth-of-type(2):checked~.switch-wrapper {
    transform: translateX(100%);
}

/* toggle the switch box labels - first checkbox:checked - show first switch div */
.switches-container input:nth-of-type(1):checked~.switch-wrapper .switch div:nth-of-type(1) {
    opacity: 1;
}

/* toggle the switch box labels - second checkbox:checked - show second switch div */
.switches-container input:nth-of-type(2):checked~.switch-wrapper .switch div:nth-of-type(2) {
    opacity: 1;
}
</style>



<?php

 ?>
<div class="pt-3    ">
  <div class="switches-container">
    <input type="radio" id="switchMonthly" name="switchPlan" value="Home" checked="checked" />
    <input type="radio" id="switchYearly" name="switchPlan" value="EMS" />
    <label for="switchMonthly"><lable href="#" ><b>Home</b></lable></label>
    <label for="switchYearly"><lable href="#" ><b>EMS</b></lable></label>
    <div class="switch-wrapper">
      <div class="switch">
        <div onclick="displayHome();"><label href="#" ><b>Home</b></label></div>
        <div onclick="displayEMS();"><label href="#" ><b>EMS</b></label></div>
      </div>
    </div>
  </div>
  <div class="tab-content" style="min-height:400px;">

        <div id="tabs-1">
            <?php include "erc_dash.php"; ?>
        </div>
        <div id="tabs-2" style="display:none">
            <?php include "EMS.php"; ?>
        </div>
    </div>

</div>


<?php
?>




<!-- <?php


 ?>
<div id="tabs123" style="margin-top: 10px;">
    <ul style="font-weight:bold">
    
    
        <li class="active"><a href="#" onclick="displayHome();">Home</a></li>
        <li class=""><a href="#" onclick="displayEMS();">EMS</a></li>
         <li class=""><a href="<?php //echo base_url(); ?>Erc_dashboards/EMS_dash">EMS</a></li> -->
   <!-- </ul>
    <div class="tab-content" style="min-height:400px;">

        <div id="tabs-1">
            //?php// include "erc_dash.php"; ?>
        </div>
        <div id="tabs-2" style="display:none">
            //?php// include "EMS.php"; ?>
        </div>
    </div>

</div>
<div id="test_script">

</div>
<?php
?> -->

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

<script type="text/javascript">

$(document).ready(function() {
       
       // window.onload = erc_live_calls_dash_view();
        var refreshIntervalId = setInterval("erc_live_calls_dash_view()", 15000);
    });
    function erc_live_calls_dash_view() {
       // alert(base_url);
        $.ajax({

            type: 'POST',

            data: 'id=ss',

            cache: false,

            dataType: 'json',

            url: base_url + 'erc_dashboards/erc_live_calls_dash_view',

            success: function(result) {
                console.log(result.resourse_available);
                
                $("#ero_free").text(result.ero_free);
                $("#ero_atend").text(result.ero_atend);
                $("#ero_break").text(result.ero_break);
                $("#count_today").text(result.count_today);
                $("#closure_today").text(result.closure_today);

                $("#eme_count_today_date").text(result.eme_count_today_date);
                $("#noneme_count_today_date").text(result.noneme_count_today_date);
                $("#amb_total").text(result.amb_total);
                $("#amb_available").text(result.amb_available);
                $("#amb_busy").text(result.amb_busy);
                $("#amb_je").text(result.amb_je);
                $("#amb_als").text(result.amb_als);
                $("#amb_bls").text(result.amb_bls);

                $("#eme_count_till_month").text(result.eme_count_till_month);
                $("#dispatch_till_date").text(result.dispatch_till_date);
                $("#count_till_date").text(result.count_till_date);
                $("#count_till_month").text(result.count_till_month);
                $("#eme_count_till_date").text(result.eme_count_till_date);
                $("#dispatch_till_month").text(result.dispatch_till_month);
                $("#noneme_count_till_date").text(result.noneme_count_till_date);
                $("#noneme_count_till_month").text(result.noneme_count_till_month);
                $("#closure_till_date").text(result.closure_till_date);
                $("#closure_till_month").text(result.closure_till_month);
                $("#closure_till_month_dup").text(result.closure_till_month);



                
                
                

                $("#dispatch_this_month_tm").text(result.dispatch_this_month_tm);
                $("#dispatch_last_month_lm").text(result.dispatch_last_month_lm);
                $("#dispatch_till_date_td").text(result.dispatch_till_date_td);
                $("#dispatch_eme_count_today_date").text(result.dispatch_eme_count_today_date);

                $("#closed_mdt_count_lm").text(result.closed_mdt_count_lm);
                $("#closed_mdt_count_tm").text(result.closed_mdt_count_tm);
                $("#closed_mdt_count_td").text(result.closed_mdt_count_td);
                $("#closed_mdt_count_to").text(result.closed_mdt_count_to);

                $("#closed_dco_count_tm").text(result.closed_dco_count_tm);
                $("#closed_dco_count_lm").text(result.closed_dco_count_lm);
                $("#closed_dco_count_td").text(result.closed_dco_count_td);
                $("#closed_dco_count_to").text(result.closed_dco_count_to);

                $("#ercp_advice_taken_tm").text(result.ercp_advice_taken_tm);
                $("#ercp_advice_taken_lm").text(result.ercp_advice_taken_lm);
                $("#ercp_advice_taken_td").text(result.ercp_advice_taken_td);
                $("#ercp_advice_taken_to").text(result.ercp_advice_taken_to);

                $("#ercp_feedback_lm").text(result.ercp_feedback_lm);
                $("#ercp_feedback_tm").text(result.ercp_feedback_tm);
                $("#ercp_feedback_td").text(result.ercp_feedback_td);
                $("#ercp_feedback_to").text(result.ercp_feedback_to);

                $("#ercp_grievance_lm").text(result.ercp_grievance_lm);
                $("#ercp_grievance_tm").text(result.ercp_grievance_tm);
                $("#ercp_grievance_td").text(result.ercp_grievance_td);
                $("#ercp_grievance_to").text(result.ercp_grievance_to);

                $("#closed_validated_count_td").text(result.closed_validated_count_td);
                $("#closed_validated_count_lm").text(result.closed_validated_count_tlm);
                $("#closed_validated_count_tm").text(result.closed_validated_count_tm);
                $("#closed_validated_count_to").text(result.closed_validated_count_to);
                
                $("#eme_count_lm").text(result.eme_count_lm);
                
                $("#complaint_lm").text(result.complaint_lm);
                $("#complaint_tm").text(result.complaint_tm);
                $("#complaint_td").text(result.complaint_td);
                $("#complaint_to").text(result.complaint_to);

                $("#all_call_count_lm").text(result.all_call_count_lm);
                $("#all_call_count_tm").text(result.all_call_count_tm);
                $("#all_call_count_td").text(result.all_call_count_td);
                $("#all_call_count_to").text(result.all_call_count_to);
                
                $("#ercp_advice_taken_to").text(result.ercp_advice_taken_to);
                $("#ercp_feedback_to").text(result.ercp_feedback_to);


                $("#today_complete_closure").text(result.today_complete_closure);
                $("#this_month_complete_closure").text(result.this_month_complete_closure);
                $("#last_month_complete_closure").text(result.last_month_complete_closure);
                $("#till_date_complete_closure").text(result.till_date_complete_closure);
                
                                              
                $("#dco_count").text(result.dco_count);
                $("#pda_count").text(result.pda_count);
                $("#fda_count").text(result.fda_count);
                $("#ercp_count").text(result.ercp_count);
                $("#grievance_count").text(result.grievance_count);
                $("#feedback_count").text(result.feedback_count);
                $("#quality_count").text(result.quality_count);
                $("#dco_Tl_count").text(result.dco_Tl_count);
                $("#ero_Tl_count").text(result.ero_Tl_count);
                $("#SM_count").text(result.SM_count);
                $("#ero_count").text(result.ero_count);
                $("#ero104_count").text(result.ero104_count);
                $("#ercp_104_count").text(result.ercp_104_count);                
              
                $("#this_month_complete_closure").text(result.this_month_complete_closure);
                $("#last_month_complete_closure").text(result.last_month_complete_closure);
                $("#till_date_complete_closure").text(result.till_date_complete_closure);
                
                // $("#").text(result.closed_mdt_count_lm);
                
             }


        });

}

function displayHome(){
    $('#tabs-1').show();
    $('#tabs-2').hide();
}
function displayEMS(){
    $('#tabs-1').hide();
    $('#tabs-2').show();
}

$("button").click(function(){
  $("p").hide();
});


</script>

<script>
    $('a.yourlink').click(function (e) {

        setTimeout(function () {
            $(".mi_loader").fadeOut("slow");
        }, 1000);
        e.preventDefault();
        window.open('https://www.nuevastech.com/API/API_MEMsLiveAmbulanceDashboard.aspx?username=MEMSADMIN&accesskey=EC7206C53E1CEDA1D7B2');
        window.open('https://www.nuevastech.com/API/API_MEMsLiveAmbulanceDashboard.aspx?username=MEMSADMIN&accesskey=EC7206C53E1CEDA1D7B2');

    });
    $('a.Historical_dash_data').click(function (e) {

        setTimeout(function () {
            $(".mi_loader").fadeOut("slow");
        }, 1000);
        e.preventDefault();
        window.open('https://www.nuevastech.com/API/API_MEMSVehicleMap.aspx?username=MEMSADMIN&accesskey=EC7206C53E1CEDA1D7B2');
        window.open('https://www.nuevastech.com/API/API_MEMSVehicleMap.aspx?username=MEMSADMIN&accesskey=EC7206C53E1CEDA1D7B2');

    });

    $('a.gio_dash_data').click(function (e) {

        setTimeout(function () {
            $(".mi_loader").fadeOut("slow");
        }, 1000);
        e.preventDefault();
        window.open('http://210.212.165.118/DashboardNew.aspx');
        window.open('http://210.212.165.118/DashboardNew.aspx');

        // window.open('https://www.nuevastech.com/API/API_MEMSVehicleMap.aspx?username=MEMSADMIN&accesskey=EC7206C53E1CEDA1D7B2');

    });
</script>
<script>
    document.oncontextmenu = document.body.oncontextmenu = function () {
        return false;
    }
</script>
<script>
    jQuery(document).ready(function ($) {
        $(document).keydown(function (event) {
            var pressedKey = String.fromCharCode(event.keyCode).toLowerCase();

            if (event.ctrlKey && (pressedKey == "u")) {
                // alert('Sorry, This Functionality Has Been Disabled!');
                //disable key press porcessing
                return false;
            }
        });
    });

    $('input[name="switchPlan"]').change(function(){
        var x = $(this).val()
        if(x=="Home"){displayHome();}
        else{displayEMS();}
    });
</script>



