<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style>


@media print {
   body { font-size: 8pt;
    font-weight: normal; }
 }
 @media  print {
   body { 
     font-size: 8px;
     font-weight: normal;}
 }
 @media  print {
   body { line-height: 1.0;
    font-weight: normal; }
 }
</style>
   
<div id="print">
   <button class="button_print" onclick="window.print()">Download</button>
   </div>
   
<div class="section1" >
<div class="row" id="tc">
    <div class="col-md-3">
        <div id="headmems"><label for="">IRTS 108</label></div>
        <div id="boxtc">
            <i id="iconsys" class="fa fa-phone-square" aria-hidden="true"></i>
            <label for="" id="tcblk">Total Calls</label>
        </div>
    </div>
    <div class="col-md-3">
        <div id="headmems1"><label for="" id="">Till Date</label></div>
        <div id="boxtc1">
            <h2 class="number iconsys" id="total_calls_td"><?php echo $total_calls_td;?></h2>
        </div>
    </div>
    <div class="col-md-3">
        <div id="headmems1"><label for="" id="">This Month</label></div>
        <div id="boxtc1">
            <h2 class="number iconsys" id="total_calls_tm"><?php echo $total_calls_tm;?></h2>
        </div>
    </div>
    <div class="col-md-3">
        <div id="headmems1"><label for="" id="">Today</label></div>
        <div id="boxtc1">
            <h2 class="number iconsys" id="total_calls_to_108"><?php echo $total_calls_today;?></h2>
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
            <!-- <label for="" id="tcblk1">Till Date</label> -->
            <h2 class="number iconsys2" id="eme_calls_td"><?php echo $eme_calls_td;?></h2>
        </div>
    </div>
    <div class="col-md-3">
        <div id="boxtc1">
            <!-- <label for="" id="tcblk1">This Month</label> -->
            <h2 class="number iconsys2" id="eme_calls_tm"><?php echo $eme_calls_tm;?></h2>
        </div>
    </div>
    <div class="col-md-3">
        <div id="boxtc1">
            <!-- <label for="" id="tcblk1">Today</label> -->
            <h2 class="number iconsys2" id="eme_calls_to"><?php echo $eme_calls_to;?></h2>
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
            <!-- <label for="" id="tcblk1">Till Date</label> -->
            <h2 class="number iconsys2" id="non_eme_td"><?php echo $non_eme_td;?></h2>
        </div>
    </div>
    <div class="col-md-3">
        <div id="boxtc1">
            <!-- <label for="" id="tcblk1">This Month</label> -->
            <h2 class="number iconsys2" id="non_eme_tm"><?php echo $non_eme_tm;?></h2>
        </div>
    </div>
    <div class="col-md-3">
        <div id="boxtc1">
            <!-- <label for="" id="tcblk1">Today</label> -->
            <h2 class="number iconsys2" id="non_eme_to"><?php echo $non_eme_to;?></h2>
        </div>
    </div>
</div>

<div class="row" id="tc">
    <div class="col-md-3">
        <div id="boxtc">
            <i id="iconsys3" class="fa fa-ambulance" aria-hidden="true"></i>
            <label for="" id="tcblk">Ambulance Dispatch</label>
        </div>
    </div>
    <div class="col-md-3">
        <div id="boxtc1">
            <!-- <label for="" id="tcblk1">Till Date</label> -->
            <h2 class="number iconsys2" id="total_dispatch_all"><?php echo $eme_calls_td;?></h2>
        </div>
    </div>
    <div class="col-md-3">
        <div id="boxtc1">
            <!-- <label for="" id="tcblk1">This Month</label> -->
            <h2 class="number iconsys2" id="total_dispatch_tm"><?php echo $eme_calls_tm;?></h2>
        </div>
    </div>
    <div class="col-md-3">
        <div id="boxtc1">
            <!-- <label for="" id="tcblk1">Today</label> -->
            <h2 class="number iconsys2"  id="total_dispatch_to"><?php echo $eme_calls_to;?></h2>
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
            <!-- <label for="" id="tcblk1">Till Date</label> -->
            <h2 class="number iconsys2" id="total_calls_emps_td"><?php echo $total_closure_td;?></h2>
        </div>
    </div>
    <div class="col-md-3">
        <div id="boxtc1">
            <!-- <label for="" id="tcblk1">This Month</label> -->
            <h2 class="number iconsys2" id="total_calls_emps_tm"><?php echo $total_closure_tm;?></h2>
        </div>
    </div>
    <div class="col-md-3">
        <div id="boxtc1">
            <!-- <label for="" id="tcblk1">Today</label> -->
            <h2 class="number iconsys2" id="total_closure_to"><?php echo $total_closure_to;?></h2>
        </div>
    </div>
</div>

<div class="row" id="tc">
    <div class="col-md-4">
        <div id="headmems2"><label style="font-size:15px;"> Utilization Per Day/Per Ambulance (May 2022)</label> </div>
    </div>
    <div class="col-md-8">
    <div id="headmems2"><label for="">Response Time</label></div>
    </div>
</div>
<div class="row" id="tc">
    <div class="col-md-4">
    <div id="boxtc1" style="padding: 12px;">
        <div class="number iconsys"><h2 class="number iconsys" id="">4.5</h2></div>
        </div>
    </div>
    <div class="col-md-4">
        <div id="headmems2"><label for="" id="">Average Rural (May 2022)</label></div>
        <div id="boxtc1">
            <h2 class="number iconsys" id="">00:22:29</h2>
        </div>
    </div>
    <div class="col-md-4">
        <div id="headmems2"><label for="" id="">Average Urban (May 2022)</label></div>
        <div id="boxtc1">
            <h2 class="number iconsys" id="">00:18:06</h2>
        </div>
    </div>
    <!-- <div class="col-md-3">
        <div id="headmems2"><label for="" id="">Tribal</label></div>
        <div id="boxtc1">
            <h2 class="number iconsys" id="">0</h2>
        </div>
    </div> -->
</div>




<div class="row" id="tc">
    <div class="col-md-2">
        <div id="boxtc1">
            <i id="iconsys5" class="fa fa-ambulance" aria-hidden="true"></i>
            <div id="tcblk2"><label>Ambulance</label></div>
        </div>
    </div>
    <div class="col-md-2">
        <div id="headmems3"><label for="">Total Ambulance</label></div>
        <div id="boxtc1">
            <!-- <label for="" id="tcblk1">Total Ambulance</label> -->
            <h2 class="number iconsys3" id="total_amb_count">0</h2>
        </div>
    </div>
    <div class="col-md-2">
        <div id="headmems3"><label for="">Ambulance On Road</label></div>
        <div id="boxtc1">
            <!-- <label for="" id="tcblk1">Ambulance On Road</label> -->
            <a id="onroad" href="<?php echo base_url();?>dashboard/ambulance_onroad_popup" target="_blank"><h2 class="number iconsys3" id="total_amb_onroad">0</h2></a>
        </div>
    </div>
    <div class="col-md-2">
        <div id="headmems3"><label for="">In Maintenance</label></div>
        <div id="boxtc1">
            <!-- <label for="" id="tcblk1">In Maintenance</label> -->
            <a id="offroad" href="<?php echo base_url();?>dashboard/ambulance_status_popup" target="_blank"><h2 class="number iconsys3" id="total_total_offroad">0</h2></a>
        </div>
    </div>
    <div class="col-md-2">
        <div id="headmems3"><label for="">EMT Present</label></div>
        <div id="boxtc1">
            <!-- <label for="" id="tcblk1">EMT Login</label> -->
            <h2 class="number iconsys3" id="total_login_emso">0</h2>
        </div>
    </div>
    <div class="col-md-2">
        <div id="headmems3"><label for="">Pilot Present</label></div>
        <div id="boxtc1">
            <!-- <label for="" id="tcblk1">Pilot Login</label> -->
            <h2 class="number iconsys3" id="total_login_pilot">0</h2>
        </div>
    </div>
</div>
<div class="row" id="tc" >
    <div class="col-md-2">
        <div id="boxtc1">
            <i id="iconsys6" class="fa fa-ambulance" aria-hidden="true"></i>
            <div id="tcblk2"><label>Dispatch Status</label></div>
        </div>
    </div>
    <div class="col-md-2">
        <div id="headmems4"><label for="">Dispatch</label></div>
        <div id="boxtc1">
            <!-- <label for="" id="tcblk1">Dispatch</label> -->
            <h2 class="number iconsys3" id="total_dispatch_today">0</h2>
        </div>
    </div>
    <div class="col-md-2">
        <div id="headmems4"><label for="">Start From Base</label></div>
        <div id="boxtc1">
            <!-- <label for="" id="tcblk1">Start From Base</label> -->
            <h2 class="number iconsys3" id="start_from_base_count">0</h2>
        </div>
    </div>
    <div class="col-md-2">
        <div id="headmems4"><label for="">At Scene</label></div>
        <div id="boxtc1">
            <!-- <label for="" id="tcblk1">At Scene</label> -->
            <h2 class="number iconsys3" id="at_scene_count">0</h2>
        </div>
    </div>
    <div class="col-md-2">
        <div id="headmems4"><label for="">At Destination</label></div>
        <div id="boxtc1">
            <!-- <label for="" id="tcblk1">At Destination</label> -->
            <h2 class="number iconsys3" id="from_scene_count">0</h2>
        </div>
    </div>
    <div class="col-md-2">
        <div id="headmems4" class="btob"><label for="">Back To Base</label></div>
        <div id="boxtc1">
            <!-- <label for="" id="tcblk1">B To B And Case Closed</label> -->
            <h2 class="number iconsys" id="back_to_base_count">0</h2>
        </div>
    </div>
</div>

<!-- <div class="row" id="vstrcnt">
<div class="col-md-6" style="display: flex;">
        <div id="headvstr"><label for="">Total Visitors Today</label></div>
        <div id="boxvstr">
            <label class="" id="visitors_count">0</label>
        </div>
    </div>
</div>  -->
</div>  

<script type="text/javascript">
    $(document).ready(function() {
        window.onload = nhm_live_calls_dash_vew();
        var refreshIntervalId = setInterval("nhm_live_calls_dash_vew()", 300000);
    });

    function nhm_live_calls_dash_vew() {

        $.ajax({

            type: 'GET',

            data: 'id=ss',

            cache: false,

            dataType: 'json',

            url: base_url + 'dashboard/mems_dash',

            success: function(result) {
                // console.log(result);
                // alert(result);

                $("#start_from_base_count").text(result.start_from_base_count);
                $("#at_scene_count").text(result.at_scene_count);
                $("#from_scene_count").text(result.from_scene_count);
                $("#at_hospital_count").text(result.eme_calls_tm);
                $("#handover_count").text(result.handover_count);
                $("#back_to_base_count").text(result.back_to_base_count);
                $("#total_dispatch_today").text(result.total_dispatch_today);

                $("#total_calls_td").text(result.total_calls_td);
                $("#total_calls_tm").text(result.total_calls_tm);
                $("#total_amb_count").text(result.total_amb_count);
                $("#total_dispatch_to").text(result.total_dispatch_to);
                $("#eme_calls_td").text(result.eme_calls_td);
                $("#eme_calls_tm").text(result.eme_calls_tm);
                $("#eme_calls_to").text(result.eme_calls_to);
                $("#non_eme_td").text(result.non_eme_td);
                $("#non_eme_tm").text(result.non_eme_tm);
                $("#non_eme_to").text(result.non_eme_to);
                $("#available_agents").text(result.available_agents);
                $("#oncall_agents").text(result.oncall_agents);
                $("#break_agents").text(result.break_agents);
                $("#total_total_offroad").text(result.total_total_offroad);
                $("#total_amb_onroad").text(result.total_amb_onroad);
                $("#total_login_emso").text(result.total_login_emso);
                $("#total_login_pilot").text(result.total_login_pilot);

                $("#visitors_count").text(result.visitors_count);
                $("#visitors_count_mb").text(result.visitors_count_mb);

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
                $("#total_closure_to").text(result.total_closure_to);

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
    .section1{
        padding: 0px 10px 50px 10px;

    }
    #headmems {
        border: 2px solid grey;
        border-bottom: none;
        text-align: center;
        background-color: #2F419B;
        color: white;
        font-weight: bold;
        font-family: Lucida Grande,Lucida Sans,Arial,sans-serif;
    }

    #headmems1,#headmems2,#headmems3,#headmems4{
        border: 2px solid grey;
        border-bottom: none;
        text-align: center;
        background-color: #2F419B;
        color: white;
        font-weight: bold;
        font-size: 17px;
        padding-top: 4px;
        font-family: Lucida Grande,Lucida Sans,Arial,sans-serif;
    }
    #boxtc {
        border: 2px solid grey;
        text-align: center;
        padding: 0px;
        display: flex;
    }
    /* #headvstr{
        border: 2px solid grey;
        text-align: center;
        background-color: #085B80;
        color: white;
        font-weight: bold;
        font-size: 17px;
        width: 50%;
        padding-top: 7px;
        height: 50px;
        font-family: Lucida Grande,Lucida Sans,Arial,sans-serif;
    } */

    #boxtc1 {
        border: 2px solid grey;
        text-align: center;
        padding: 0px;
    }
    /* #boxvstr{
        border: 2px solid grey;
        text-align: center;
        font-size: 30px;
        padding: 0px;
        width: 50%;
        height: 50px;
    }
    #numvstr{
        font-size: 50px;
        padding-top: 5px;
    } */

    #tc {
        padding: 3px 0px 3px 0px;
    }

    #tcblk {
        width: 100%;
        padding: 15px 5px 5px 5px;
        text-align: left;
        font-weight: bold;
        font-size: 17px;
        font-family: Lucida Grande,Lucida Sans,Arial,sans-serif;
        color:black;
    }
    #tcblk2 {
        border-top: 2px solid grey;
        font-weight: bold;
        font-size: 17px;
        font-family: Lucida Grande,Lucida Sans,Arial,sans-serif;
        color:black;
    }

    #iconsys {
        font-size: 50px;
        padding: 4px;
        color: green;
        width: 25%;
    }

    #iconsys1 {
        font-size: 50px;
        padding: 4px;
        color: red;
        width: 25%;
    }

    #iconsys2 {
        font-size: 50px;
        padding: 4px;
        color: #3c3c95;
        width: 25%;
    }

    #iconsys3 {
        font-size: 50px;
        padding: 4px;
        color: #55b09f;
        width: 25%;
    }

    #iconsys4 {
        font-size: 50px;
        padding: 4px;
        color: #bec01a;
        width: 20%;
    }

    #iconsys5 {
        font-size: 50px;
        padding: 4px;
        color: #ff4b5a;
    }

    #iconsys6 {
        font-size: 50px;
        padding: 4px;
        color: orange;
    }

    .iconsys {
        font-size: 35px;
        padding: 8px;
        width: 100%;
        font-weight: normal;
    }

    .iconsys2 {
        font-size: 35px;
        padding: 8px;
        font-weight: normal;
    }

    .iconsys3 {
        font-size: 35px;
        padding: 8px;
        width: 100%;
        font-weight: normal;
    }
    label {
    margin-bottom: .3rem;
}
/* #vstrcnt{
    padding:0px 0px 30px 0px;
} */
</style>