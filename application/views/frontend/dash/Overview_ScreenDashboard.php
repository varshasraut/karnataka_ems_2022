<style>
.dashboard_scroll{
    background: #f7f7f7;
    line-height: 85px;
    height: 80px;
    display: inline-block;
    width: 100%;
    margin-top: 15px;
}
.dashboard_scroll marquee{
    
/*    background: url('../images/dash_amb.jpg') no-repeat left center #000;*/
    height: 75px;
    width: 100%;
    clear: both;
    color:#c00000;
    background: #f7f7f7;
    font-size: 4vh;
    line-height: 65px;
    font-weight: bold; 
}
.dashboard_border_box{
    border:2px solid #e8e8e8;
    border-radius: 10px;
    width: 95%;
    margin-left: 30px;
    -webkit-box-shadow: 0 0 22px -18px rgba(0,0,0,0.75);
    -moz-box-shadow: 0 0 22px -18px rgba(0,0,0,0.75);
    box-shadow: 0 0 22px -18px rgba(0,0,0,0.75);
    margin-bottom: 30px;
    background: #fff;
    padding: 30px;
}
.dashboard_count_outer{
    width: 100%;
    font-weight: bold;
    font-size: 28px;
    color:#fff;
    padding-top: 5px;
    display: inline-block;
}

.dashboard_count_outer li{
    color:#fff;
    display: inline-block; 
    width: 100%;
    line-height: 1.2;
}
.dashboard_count_outer li .header_text_block{
    color:#085b80;
    float: left;
    width: 50%;
    font-size: 4vh;
}
.dashboard_count_outer li .header_count_block{
    color:#085b80;
    float: left;
    min-width: 150px;
    font-size: 4vh;
}
.dashboard_count_outer li .header_percentage_count{
    color:green;
    float: left;
     font-size: 4vh;
}
.today_count_block_outer{
    min-height: 180px;
    display: inline-block;
}
.today_count_block_outer .today_count_block{
   
    width: 100%;
    min-height: 210px;
    margin:  10px;
    padding-left: 20px;
    padding-right: 20px;
    color:#fff;
    display: inline-block;
}
.today_count_block_outer .today_count_block h3{
    color:#c00000;
    text-align: center;
    font-weight: bold;
    font-size: 6vh;
}
.today_count_block_outer .today_count_block .small_black{
    width: 100%;

}
.today_count_block_outer .today_count_block .today_count_block_102,
.today_count_block_outer .today_count_block .today_count_block_108{
    color: #085b80;
    font-size: 28px;
    padding: 20px;
    font-weight: bold;
    text-align: center;
    padding-top: 10px;
}
.today_count_block_outer .today_count_block .today_count_block_102 h4,
.today_count_block_outer .today_count_block .today_count_block_108 h4{
    color:#feff99;
    font-size: 25px;
    text-align: center;
    font-weight: bold;
}
.call_flow_block{
    width: 90%;
   margin: 0 auto;
    
}
.call_flow_block .flow_108 .call_flow_text,
.call_flow_block .flow_102 .call_flow_text{
    font-size: 3vh;
    color:#085b80;
    font-weight: bold;
}
.call_flow_block .flow_108 .call_flow_text span,
.call_flow_block .flow_102 .call_flow_text span{
    font-size: 3vh;
    color:#ff0905;
    padding-left: 10px;
    font-weight: bold;
    font-style: italic;
    
}
.call_flow_block .dash_progress_bar{
    position: relative;
    width: 100%;
}
.call_flow_block .dash_progress{
    background: #0695d1;
    width: 50%;
    height: 20px;
    line-height: 20px;
    text-align: center;
    color: #fff;
    position: relative;
}
.call_flow_block .dash_progress_bar::before{
    background: #c0eefd;
    width: 100%;
    height: 10px;
    content: "";
    position: absolute;
    margin-top: 5px;
    
}
</style>


<!--<div class="header" style="position: relative;">

    <div class="head width100" style="background:#fff;  border-bottom: 0px solid #085b80; ">

        <div id="section_title" class="" style="font-size:25px;  width: 100%; text-align: center; background:#fff; height: 16vh;">
            <img src="<?php echo base_url(); ?>assets/images/BVG_Logo_big.png" alt="BVG"  style="float:left; margin-left: 20px; height: calc( 100% - 40px); width: auto; margin-top: 20px;"/>
            <div class="text-centre" style="font-size:6vh; width: 80%; border-left: 0px; color:#c00000; display: block; font-weight: bold;  float: left;">
                JAMMU AND KASHMIR EMS LIVE SUMMARY
                <span class="text-centre" style="font-size:4vh; width: 100%; border-left: 0px; color:#085b80; font-weight: bold; display: block;">
                    <?php echo date("F j, Y, g:i a"); ?>
                </span>
            </div>
            <img src="<?php echo base_url(); ?>assets/images/Logo_Govt_05.jpg" alt="BVG"  style="float:right; margin-right: 20px; height: calc( 100% - 40px); width: auto; margin-top: 20px;" />


        </div>
    </div>

</div>-->

<div class="content" align="left" style="background:#f7f7f7;  height: calc( 100vh - 27vh ); box-sizing: border-box;">
    <div class="dashboard_scroll">
        <marquee width = "100%" direction = "left"> <img src="<?php echo base_url(); ?>assets/images/Bvg_03.png" alt="BVG" height="" width="100" style="float: left; margin-right: 20px;" /> <?php
            if ($current_accident > 0) {
                echo $current_accident . " ACCIDENT REPORTED IN LAST 30 MINUTES";
            } else {
                echo "NO ACCIDENT REPORTED IN LAST 30 MINUTES";
            }
            ?></marquee>

    </div>
    <div class="width2 float_left">
        <div class="dashboard_border_box">
            <ul class="dashboard_count_outer">
                <li><div class="header_text_block"> Total Call: </div><div class="header_count_block"><?php echo $total_calls_td; ?></div></li>
                <li><div class="header_text_block"> Total Call 108: </div><div class="header_count_block"><?php echo $total_calls_td_108; ?></div><div class="header_percentage_count"><?php echo round(($total_calls_td_108 / $total_calls_td) * 100, 2); ?>%</div></li>
                <li><div class="header_text_block"> Total Call 102: </div><div class="header_count_block"><?php echo $total_calls_td_102; ?></div><div class="header_percentage_count"><?php echo round(($total_calls_td_102 / $total_calls_td) * 100, 2); ?>%</div></li>
            </ul>
            <ul class="dashboard_count_outer">
                <li><div class="header_text_block"> EM Cases 108: </div><div class="header_count_block"><?php echo $total_dispatch_108; ?></div><div class="header_percentage_count"><?php echo round(($total_dispatch_108 / $total_calls_td) * 100, 2); ?>%</div></li>
                <li><div class="header_text_block"> EM Cases 102: </div><div class="header_count_block"><?php echo $total_dispatch_102; ?></div><div class="header_percentage_count"><?php echo round(($total_dispatch_102 / $total_calls_td) * 100, 2); ?>%</div></li>
            </ul>
            <ul class="dashboard_count_outer">
                <li><div class="header_text_block"> Corona Cases : </div><div class="header_count_block"><?php echo $corona_calls; ?></div><div class="header_percentage_count"><?php echo round(($corona_calls / $total_calls_td) * 100, 2); ?>%</div></li>
                <li><div class="header_text_block"> Pregnancy: </div><div class="header_count_block"><?php echo $preganancy_calls; ?></div><div class="header_percentage_count"><?php echo round(($preganancy_calls / $total_calls_td) * 100, 2); ?>%</div></li>
                <li><div class="header_text_block"> Birth Assisted: </div><div class="header_count_block"><?php echo $assists_calls; ?></div><div class="header_percentage_count"><?php echo round(($assists_calls / $total_calls_td) * 100, 2); ?>%</div></li>
            </ul>
            <ul class="dashboard_count_outer">
                <li><div class="header_text_block">Injury : </div></li>
                <li><div class="header_text_block"> a) RTA: </div><div class="header_count_block"><?php echo $rta_calls; ?></div><div class="header_percentage_count"><?php echo round(($rta_calls / $total_calls_td) * 100, 2); ?>%</div></li>
                <li><div class="header_text_block"> b) Non Vehicular: </div><div class="header_count_block"><?php echo $non_vahicular_calls; ?></div><div class="header_percentage_count"><?php echo round(($non_vahicular_calls / $total_calls_td) * 100, 2); ?>%</div></li>
            </ul>
        </div>


    </div>
    <div class="width2 float_left">
        <div class="today_count_block_outer dashboard_border_box">
            <div class="today_count_block">
                <h3>TODAY</h3>
                <canvas id="pie-chart" width="400" height="150"></canvas>
            </div>
            <div class="call_flow_block">
                <?php
                $per_min_calls = round($call_per_minute[0]->avg_calls);
                $call_avg = ($per_min_calls / 60) * 100;
                ?>
                <div class="flow_108">
                    <div class="call_flow_text">
                        108 Call Flow: <span> <?php echo $per_min_calls; ?>  Call / Min</span>
                    </div>
                    <div class="call_flow_process">

                        <div class="dash_progress_bar">
                            <div class="dash_progress" style="width: <?php echo $call_avg; ?>%;">
                                <?php echo $per_min_calls; ?> Calls
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="call_flow_block">
                <?php
                $call_per_minute_102 = round($call_per_minute_102[0]->avg_calls);
                $call_avg_102 = ($call_per_minute_102 / 60) * 100;
                ?>
                <div class="flow_108">
                    <div class="call_flow_text">
                        102 Call Flow: <span> <?php echo $call_per_minute_102; ?>  Call / Min</span>
                    </div>
                    <div class="call_flow_process">

                        <div class="dash_progress_bar">
                            <div class="dash_progress" style="width: <?php echo $call_avg_102; ?>%;">
                                <?php echo $call_per_minute_102; ?> Calls
                            </div>
                        </div>
                    </div>
                </div>
            </div>


        </div>

    </div>

</div>

<script>
<?php
$chart_value = array($today_dispatch_108, $today_noneme_108);
$chart_color = array('#01ff00', '#c00000');
$chart_label = array('Emergency', ' Non Emergency');
?>
    var $data = {
        datasets: [{
                data: <?php echo json_encode($chart_value); ?>,
                backgroundColor: <?php echo json_encode($chart_color); ?>
            }],
        labels: <?php echo json_encode($chart_label); ?>,
    };
    //console.log($data);
    var canvas = document.getElementById("pie-chart");
    var ctx = canvas.getContext("2d");
    var myNewChart = new Chart(ctx, {
        type: 'pie',
        data: $data,
        options: {
            title: {
                display: true,
                text: ''
            },
            onClick: function ($ev, $ele) {
                var $_index = $ele[0]['_index'];
                var $click_id = $data['ids'][$_index];
                $('#atc_' + $click_id).click();
            }
        }
    });
</script>