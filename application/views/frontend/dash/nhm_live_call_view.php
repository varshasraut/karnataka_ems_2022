<div class="row">
    <div style="width:50%;">
        <div class="vheader-container">TOTAL CALLS</div>
        <div class="blok">
            <div class="statistic__item statistic__item--green">
                <div class="black-head1" style="background-color:#006371;">
                    <p class="small_text">Till Date</p>
                </div>
                <h2 class="number" id="total_calls_td" style="color:white"><?php echo $total_calls_td; ?></h2>
            </div>
        </div>
        <div class="blok">
            <div class="statistic__item statistic__item--green">
                <div class="black-head1" style="background-color:#006371;">
                    <p class="small_text">This Month</p>
                </div>
                <h2 class="number" id="total_calls_tm" style="color:white"><?php echo $total_calls_tm; ?></h2>
            </div>
        </div>
        <div class="vheader-container">NON EMERGENCY </div>
        <div class="blok">
            <div class="statistic__item statistic__item--orange1">
                <div class="black-head1" style="background-color:#a92215;">
                    <p class="small_text">Till Date</p>
                </div>
                <h2 class="number" id="non_eme_td" style="color:white"><?php echo $non_eme_td; ?></h2>
            </div>
        </div>
        <div class="blok">
            <div class="statistic__item statistic__item--orange1">
                <div class="black-head1" style="background-color:#a92215;">
                    <p class="small_text">This Month</p>
                </div>
                <h2 class="number" id="non_eme_tm" style="color:white"><?php echo $non_eme_tm; ?></h2>
            </div>
        </div>

    </div>
    <div style="width:50%;">
        <div class="vheader-container">EMERGENCY</div>
        <div class="blok">
            <div class="statistic__item statistic__item--red">
                <div class="black-head1" style="background-color:#500d27;">
                    <p class="small_text">Till Date</p>
                </div>
                <h2 class="number" id="eme_calls_td" style="color:white"><?php echo $eme_calls_td; ?></h2>
            </div>
        </div>
        <div class="blok">
            <div class="statistic__item statistic__item--red">
                <div class="black-head1" style="background-color:#500d27;">
                    <p class="small_text">This Month</p>
                </div>
                <h2 class="number" id="eme_calls_tm" style="color:white"><?php echo $eme_calls_tm; ?></h2>
            </div>
        </div>
        <div class="vheader-container"> DISPATCHES</div>
        <div class="blok">
            <div class="statistic__item statistic__item--bluesh">
                <div class="black-head1" style="background-color:#17404a">
                    <p class="small_text">Till Date</p>
                </div>
                <h2 class="number" id="total_dispatch_all" style="color:white"><?php echo $total_dispatch_all; ?></h2>
            </div>
        </div>
        <div class="blok">
            <div class="statistic__item statistic__item--bluesh">
                <div class="black-head1" style="background-color:#17404a">
                    <p class="small_text">This Month</p>
                </div>
                <h2 class="number" id="total_dispatch_tm" style="color:white"><?php echo $total_dispatch_tm; ?></h2>
            </div>
        </div>
    </div>
    <div style="width:100%;">
        <div class="vheader-container" style="width:99%;">EMERGENCY PATIENTS SERVED</div>
        <div class="blok" style="width: 49%;">
            <div class="statistic__item statistic__item--yellow">
                <div class="black-head1" style="background-color:#638206;">
                    <p class="small_text">Till Date</p>
                </div>
                <h2 class="number" id="total_calls_emps_td" style="color:white"><?php echo $total_calls_emps_td; ?></h2>
            </div>
        </div>
        <div class="blok" style="width: 49%;">
            <div class="statistic__item statistic__item--yellow">
                <div class="black-head1" style="background-color:#638206;">
                    <p class="small_text">This Month</p>
                </div>
                <h2 class="number" id="total_calls_emps_tm" style="color:white"><?php echo $total_calls_emps_tm; ?></h2>
            </div>
        </div>
        </div>
    
    <!--<div style="width:50%;">
        <div class="vheader-container">CLOSURE</div>
        <div class="blok">
            <div class="statistic__item statistic__item--skyblue">
                <div class="black-head1" style="background-color:#2d1f44;">
                    <p class="small_text">Till Date</p>
                </div>
                <h2 class="number" id="total_closure_td" style="color:white"><?php echo $total_calls_emps_td; ?></h2>

            </div>
        </div>
        <div class="blok">
            <div class="statistic__item statistic__item--skyblue">
                <div class="black-head1" style="background-color:#2d1f44;">
                    <p class="small_text">This Month</p>
                </div>
                <h2 class="number" id="total_closure_tm" style="color:white"><?php echo $total_calls_emps_tm; ?></h2>
            </div>
        </div>
    </div>-->
</div>
<!--
<div class="row">
<div style="width:33.32%;">
    <div class="vheader-container">Total Calls Today</div>
    <div class="blok" style="width: 47%;">
        <div class="statistic__item statistic__item--c4" style="text-align: center;">

            <i class="zmdi zmdi-phone-end" style="font-size: 80px;color:white;padding-top:10px;"></i>

        </div>
    </div>
    <div class="blok" style="width: 47%;">
        <div class="statistic__item statistic__item--c4">

            <h2 id="total_calls_to_108" style="color:white;"></h2>

        </div>
    </div>
</div>

<div style="width:33.32%;">
    <div class="vheader-container">Emergency And Dispatch Calls Today</div>
    <div class="blok" style="width: 47%;">
        <div class="statistic__item statistic__item--c5" style="text-align: center;">
            <i class="zmdi zmdi-hospital" style="font-size: 80px;color:white;padding-top:10px;"></i>
        </div>
    </div>
    <div class="blok" style="width: 47%;">
        <div class="statistic__item statistic__item--c5">
        <h2 id="eme_calls_to" style="color:white;"></h2>
        </div>
    </div>
    </div>

<div style="width:33.32%;">
    <div class="vheader-container">Non Emergency Calls Today</div>
    <div class="blok" style="width: 47%;">
        <div class="statistic__item statistic__item--c3" style="text-align: center;">
            <i class="zmdi zmdi-phone-ring" style="font-size: 80px;color:white;padding-top:10px;"></i>
        </div>
    </div>
    <div class="blok" style="width: 47%;">
        <div class="statistic__item statistic__item--c3">
            <h2 id="non_eme_to" style="color:white;"></h2>
        </div>
    </div>
</div>
</div>-->



  <div class="row p-t-8 mx-auto col-lg-8">

    <div class="col-sm-6 col-lg-4">
        <div class="overview-item overview-item--c4">
            <div class="overview__inner">
                <div class="overview-box clearfix">
                    <div class="icon">
                        <i class="zmdi zmdi-phone-end"></i>
                    </div>
                    <div class="text">
                        <h2 id="total_calls_to_108"></h2>
                        <span>Total Calls <br>Today</span>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="col-sm-6 col-lg-4">
        <div class="overview-item overview-item--c2">
            <div class="overview__inner">
                <div class="overview-box clearfix">
                    <div class="icon">
                        <i class="zmdi zmdi-phone-ring"></i>
                    </div>
                    <div class="text">
                        <h2 id="eme_calls_to"></h2>
                        <span>Emergency Calls<br>Today</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-lg-4">
        <div class="overview-item overview-item--c3">
            <div class="overview__inner">
                <div class="overview-box clearfix">
                    <div class="icon">
                        <i class="zmdi zmdi-phone-ring"></i>
                    </div>
                    <div class="text">
                        <h2 id="non_eme_to"></h2>
                        <span>Non Emergency<br>Calls Today</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>  
<div class="row">
    <label for="">&nbsp;</label>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        window.onload = ajaxcall();
        setInterval("nhm_live_calls_dash_vew()", 10000);
    });

    function nhm_live_calls_dash_vew() {

        $.ajax({

            type: 'GET',

            data: 'id=ss',

            cache: false,

            dataType: 'json',

            url: base_url + 'dashboard/view',

            success: function(result) {
                //alert(result);

                $("#total_calls_td").text(result.total_calls_td);
                $("#total_calls_tm").text(result.total_calls_tm);


                $("#eme_calls_td").text(result.eme_calls_td);
                $("#eme_calls_tm").text(result.eme_calls_tm);
                $("#eme_calls_to").text(result.eme_calls_to);
                $("#non_eme_td").text(result.non_eme_td);
                $("#non_eme_tm").text(result.non_eme_tm);
                $("#non_eme_to").text(result.non_eme_to);

                $("#available_agents").text(result.available_agents);
                $("#oncall_agents").text(result.oncall_agents);
                $("#break_agents").text(result.break_agents);

                $("#total_calls_this_month").html(result.total_calls_this_month);

                $("#total_calls_today").text(result.total_calls_today);

                $("#total_calls_today_108").text(result.total_calls_today_108);

                $("#total_calls_today_102").text(result.total_calls_today_102);

                $("#total_calls_to_108").text(result.total_calls_to_108);

                $("#total_calls_to_102").text(result.total_calls_to_102);

                $("#total_calls_tm_108").text(result.total_calls_tm_108);

                $("#total_calls_tm_102").text(result.total_calls_tm_102);

                $("#total_calls_emps_td").text(result.total_calls_emps_td);

                $("#total_calls_emps_td_108").text(result.total_calls_emps_td_108);

                $("#total_calls_emps_td_102").text(result.total_calls_emps_td_102);

                $("#total_calls_emps_tm").text(result.total_calls_emps_tm);
                $("#total_closure_tm").text(result.total_closure_tm);
                $("#total_closure_td").text(result.total_closure_td);

                $("#total_calls_emps_tm_108").text(result.total_calls_emps_tm_108);

                $("#total_calls_emps_tm_102").text(result.total_calls_emps_tm_102);

                $("#total_calls_emps_to").text(result.total_calls_emps_to);

                $("#total_calls_emps_to_108").text(result.total_calls_emps_to_108);

                $("#total_calls_emps_to_102").text(result.total_calls_emps_to_102);

                $("#total_calls_handled").text(result.total_calls_handled);

                $("#total_dispatch_all").text(result.total_dispatch_all);

                $("#total_dispatch_tm").text(result.total_dispatch_tm);

                $("#total_dispatch_108").text(result.total_dispatch_108);

                $("#total_dispatch_102").text(result.total_dispatch_102);

                $("#agents_available").text(result.agents_available);

                $("#agents_available_108").text(result.agents_available_108);

                $("#agents_available_102").text(result.agents_available_102);


                $("#non_eme_calls").text(result.non_eme_calls);

                $("#total_closed_call_108").text(result.closed_calls_108);

                $("#total_closed_call_102").text(result.closed_calls_102);

                $("#total_calls_108").text(result.total_calls_108);

                $("#total_calls_102").text(result.total_calls_102);



            }


        });

    }
</script>

<!--<script type="text/javascript">
$(document).ready(function() {
window.onload=ajaxcall();
setInterval("ajaxcall()",2000); 
});
</script>-->