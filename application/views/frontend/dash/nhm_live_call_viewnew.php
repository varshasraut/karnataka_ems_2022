<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<!-- <div class="row">
    <div style="width:50%;padding:10px;">
        <div class="tc">TOTAL CALLS</div>
        <div class="left-half">
        <div class="row">
            <div class="col-md-6" style="padding: 4px;">
            <label for="" id="headtc">Total Calls</label>
            </div>
            <div class="col-md-6" style="padding: 4px;">
            <label for="" id="headec">Emergency Call</label>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6" id="box">
            <h2 class="number" id="total_calls_td" style="color:black"><?php echo $total_calls_td; ?></h2>
            <label for="" id="tcblk">Till Date</label>
            </div>
            <div class="col-md-6" id="box">
            <h2 class="number" id="non_eme_td" style="color:black"><?php echo $non_eme_td; ?></h2>
            <label for="" id="tcblk">Till Date</label>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6" id="box">
            <h2 class="number" id="total_calls_tm" style="color:black"><?php echo $total_calls_tm; ?></h2>
            <label for="" id="tcblk">This Month</label>
            </div>
            <div class="col-md-6" id="box">
            <h2 class="number" id="non_eme_tm" style="color:black"><?php echo $non_eme_tm; ?></h2>
            <label for="" id="tcblk">This Month</label>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6" id="box">
            <h2 class="number" id="total_calls_to_108" style="color:black"><?php echo $total_calls_to_108; ?></h2>
            <label for="" id="tcblk">Total Calls Today</label>
            </div>
            <div class="col-md-6" id="box">
            <h2 class="number" id="non_eme_to" style="color:black"><?php echo $non_eme_to; ?></h2>
            <label for="" id="tcblk">Total Calls Today</label>
            </div>
        </div>
        </div>
   </div>
   <div style="width:50%;padding: 10px;">
        <div class="tc">MANPOWER</div>
        <div class="left-half">
        <div class="row">
            <div class="col-md-6" style="padding: 4px;">
            <label for="" id="headtc">EMT</label>
            </div>
            <div class="col-md-6" style="padding: 4px;">
            <label for="" id="headec">Pilot</label>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6" id="box">
            <h2 class="number" id="total_calls_td" style="color:black">0</h2>
            <label for="" id="tcblk">Total On Board</label>
            </div>
            <div class="col-md-6" id="box">
            <h2 class="number" id="non_eme_td" style="color:black">0</h2>
            <label for="" id="tcblk">Total On Board</label>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6" id="box">
            <h2 class="number" id="total_calls_tm" style="color:black"><?php echo $total_calls_tm; ?></h2>
            <label for="" id="tcblk">Login In Count</label>
            </div>
            <div class="col-md-6" id="box">
            <h2 class="number" id="non_eme_tm" style="color:black"><?php echo $non_eme_tm; ?></h2>
            <label for="" id="tcblk">Login In Count</label>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6" id="box">
            <h2 class="number" id="total_calls_to_108" style="color:black"><?php echo $total_calls_to_108; ?>0</h2>
            <label for="" id="tcblk">Logout</label>
            </div>
            <div class="col-md-6" id="box">
            <h2 class="number" id="non_eme_to" style="color:black"><?php echo $non_eme_to; ?>0</h2>
            <label for="" id="tcblk">Logout</label>
            </div>
        </div>
        </div>
   </div>
   </div>  -->

<div class="container">

    <div class="row" id="tc">
        <div class="col-md-3">
            <div id="boxtc">
                <i id="iconsys" class="fa fa-phone-square" aria-hidden="true"></i>
                <label for="" id="tcblk">Total Calls</label>
            </div>
        </div>
        <div class="col-md-3">
            <div id="boxtc1">
                <label for="" id="tcblk1">Till Date</label>
                <h2 class="number iconsys" id="total_calls_td"><?php echo $total_calls_td; ?></h2>
            </div>
        </div>
        <div class="col-md-3">
            <div id="boxtc1">
                <label for="" id="tcblk1">This Month</label>
                <h2 class="number iconsys" id="total_calls_tm"><?php echo $total_calls_td; ?></h2>
            </div>
        </div>
        <div class="col-md-3">
            <div id="boxtc1">
                <label for="" id="tcblk1">Today</label>
                <h2 class="number iconsys" id="total_calls_to_108"><?php echo $total_calls_to_108; ?></h2>
            </div>
        </div>
    </div>

    <div class="row" id="tc">
        <div class="col-md-3">
            <div id="boxtc">
                <i id="iconsys1" class="fa fa-volume-control-phone" aria-hidden="true"></i>
                <div id="tcblk"><label>Emergency Calls</label></div>
            </div>
        </div>
        <div class="col-md-3">
            <div id="boxtc1">
                <label for="" id="tcblk1">Till Date</label>
                <h2 class="number iconsys" id="eme_calls_td"><?php echo $eme_calls_td; ?></h2>
            </div>
        </div>
        <div class="col-md-3">
            <div id="boxtc1">
                <label for="" id="tcblk1">This Month</label>
                <h2 class="number iconsys" id="eme_calls_tm"><?php echo $eme_calls_tm; ?></h2>
            </div>
        </div>
        <div class="col-md-3">
            <div id="boxtc1">
                <label for="" id="tcblk1">Today</label>
                <h2 class="number iconsys" id="eme_calls_to"><?php echo $eme_calls_to; ?></h2>
            </div>
        </div>
    </div>

    <div class="row" id="tc">
        <div class="col-md-3">
            <div id="boxtc">
                <i id="iconsys2" class="fa fa-volume-control-phone" aria-hidden="true"></i>
                <div id="tcblk"><label>Non Emergency Calls</label></div>
            </div>
        </div>
        <div class="col-md-3">
            <div id="boxtc1">
                <label for="" id="tcblk1">Till Date</label>
                <h2 class="number iconsys" id="non_eme_td"><?php echo $non_eme_td; ?></h2>
            </div>
        </div>
        <div class="col-md-3">
            <div id="boxtc1">
                <label for="" id="tcblk1">This Month</label>
                <h2 class="number iconsys" id="non_eme_tm"><?php echo $non_eme_tm; ?></h2>
            </div>
        </div>
        <div class="col-md-3">
            <div id="boxtc1">
                <label for="" id="tcblk1">Today</label>
                <h2 class="number iconsys" id="non_eme_to"><?php echo $non_eme_to; ?></h2>
            </div>
        </div>
    </div>

    <div class="row" id="tc">
        <div class="col-md-3">
            <div id="boxtc">
                <i id="iconsys3" class="fa fa-ambulance" aria-hidden="true"></i>
                <label for="" id="tcblk">Ambulance Dispatch </label>
            </div>
        </div>
        <div class="col-md-3">
            <div id="boxtc1">
                <label for="" id="tcblk1">Till Date</label>
                <h2 class="number iconsys" id="total_dispatch_all"><?php echo $total_dispatch_all; ?></h2>
            </div>
        </div>
        <div class="col-md-3">
            <div id="boxtc1">
                <label for="" id="tcblk1">This Month</label>
                <h2 class="number iconsys" id="total_dispatch_tm"><?php echo $total_dispatch_tm; ?></h2>
            </div>
        </div>
        <div class="col-md-3">
            <div id="boxtc1">
                <label for="" id="tcblk1">Today</label>
                <h2 class="number iconsys" id="">0</h2>
            </div>
        </div>
    </div>

    <div class="row" id="tc">
        <div class="col-md-3">
            <div id="boxtc">
                <i id="iconsys4" class="fa fa-hospital-o" aria-hidden="true"></i>
                <div id="tcblk"><label>Emergency Patient Served</label></div>
            </div>
        </div>
        <div class="col-md-3">
            <div id="boxtc1">
                <label for="" id="tcblk1">Till Date</label>
                <h2 class="number iconsys" id="total_calls_emps_td"><?php echo $total_calls_emps_td; ?></h2>
            </div>
        </div>
        <div class="col-md-3">
            <div id="boxtc1">
                <label for="" id="tcblk1">This Month</label>
                <h2 class="number iconsys" id="total_calls_emps_tm"><?php echo $total_calls_emps_tm; ?></h2>
            </div>
        </div>
        <div class="col-md-3">
            <div id="boxtc1">
                <label for="" id="tcblk1">Today</label>
                <h2 class="number iconsys" id="">0</h2>
            </div>
        </div>
    </div>

    <div class="row" id="tc">
        <div class="col-md-2">
            <div id="boxtc">
                <i id="iconsys5" class="fa fa-ambulance" aria-hidden="true"></i>
                <div id="tcblk"><label>Total Ambulance</label></div>
            </div>
        </div>
        <div class="col-md-2">
            <div id="boxtc1">
                <label for="" id="tcblk1">Total Ambulance</label>
                <h2 class="number iconsys" id="">0</h2>
            </div>
        </div>
        <div class="col-md-2">
            <div id="boxtc1">
                <label for="" id="tcblk1">Ambulance On Road</label>
                <h2 class="number iconsys" id="">0</h2>
            </div>
        </div>
        <div class="col-md-2">
            <div id="boxtc1">
                <label for="" id="tcblk1">In Maintenance</label>
                <h2 class="number iconsys" id="">0</h2>
            </div>
        </div>
        <div class="col-md-2">
            <div id="boxtc1">
                <label for="" id="tcblk1">EMT Login</label>
                <h2 class="number iconsys" id="">0</h2>
            </div>
        </div>
        <div class="col-md-2">
            <div id="boxtc1">
                <label for="" id="tcblk1">Pilot Login</label>
                <h2 class="number iconsys" id="">0</h2>
            </div>
        </div>
    </div>
    <div class="row" id="tc">
        <div class="col-md-2">
            <div id="boxtc">
                <i id="iconsys6" class="fa fa-ambulance" aria-hidden="true"></i>
                <div id="tcblk"><label>Dispatch Status</label></div>
            </div>
        </div>
        <div class="col-md-2">
            <div id="boxtc1">
                <label for="" id="tcblk1">Dispatch</label>
                <h2 class="number iconsys" id="">0</h2>
            </div>
        </div>
        <div class="col-md-2">
            <div id="boxtc1">
                <label for="" id="tcblk1">Start From Base</label>
                <h2 class="number iconsys" id="">0</h2>
            </div>
        </div>
        <div class="col-md-2">
            <div id="boxtc1">
                <label for="" id="tcblk1">At Scene</label>
                <h2 class="number iconsys" id="">0</h2>
            </div>
        </div>
        <div class="col-md-2">
            <div id="boxtc1">
                <label for="" id="tcblk1">At Destination</label>
                <h2 class="number iconsys" id="">0</h2>
            </div>
        </div>
        <div class="col-md-2">
            <div id="boxtc1">
                <label for="" id="tcblk1">Back To Base</label>
                <h2 class="number iconsys" id="">0</h2>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div><label>&nbsp;</label></div>
</div>
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


<style>
    #boxtc {
        border: 1px solid black;
        text-align: center;
        padding: 0px;
        width: 80%;
    }
    #boxtc1 {
        border: 1px solid black;
        text-align: center;
        padding: 0px;
       
    }

    #tc {
        padding: 10px 0px 20px 0px;
    }

    #tcblk {
        border-top: 1px solid black;
        width: 100%;
    }

    #iconsys {
        font-size: 50px;
        padding: 10px;
        color: green;
    }

    #iconsys1 {
        font-size: 50px;
        padding: 10px;
        color: red;
    }

    #iconsys2 {
        font-size: 50px;
        padding: 10px;
        color: #3c3c95;
    }

    #iconsys3 {
        font-size: 50px;
        padding: 10px;
        color: #55b09f;
    }

    #iconsys4 {
        font-size: 50px;
        padding: 10px;
        color: #bec01a;
    }

    #iconsys5 {
        font-size: 50px;
        padding: 10px;
        color: #ff4b5a;
    }
    #iconsys6 {
        font-size: 50px;
        padding: 10px;
        color: orange;
    }
    .iconsys{
       font-size: 42px;
       padding: 10px;
       border-top: 1px solid black;
        width: 100%;
    }
</style>