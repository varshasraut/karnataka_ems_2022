<!DOCTYPE HTML>

<html>
    <head>

        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta content="utf-8" http-equiv="encoding">

        <meta http-equiv="content-type" content="text/html; charset=utf-8" />
        <meta http-equiv="cache-control" content="max-age=0" />
        <meta http-equiv="cache-control" content="no-cache" />
        <meta http-equiv="expires" content="0" />
        <meta http-equiv="expires" content="Tue, 01 Jan 1980 1:00:00 GMT" />

        <meta http-equiv="pragma" content="no-cache" />
        <!-- <meta http-equiv="refresh" content="60">-->

        <title>Emergency Medical Services</title>

        <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300italic,300,400italic,600,700,800' rel='stylesheet' type='text/css'>
        <link rel="shortcut icon" href="{base_url}themes/backend/images/favicon.ico" type="image/x-icon" />
        <link href="{base_url}themes/backend/css/style.css" rel="stylesheet" type="text/css" />
        <link href="{base_url}themes/backend/css/style_pages.css" rel="stylesheet" type="text/css" />
        <link href="{base_url}themes/backend/css/style_responsive_common.css" rel="stylesheet" type="text/css" />
        <link href="{base_url}themes/backend/css/style_responsive.css" rel="stylesheet" type="text/css" />

        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

        <!-- jQuery library -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

        <!-- Latest compiled JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>
        <script type="text/javascript">
            setInterval("my_function();", 120000);

            function my_function() {
                window.location = location.href;
            }
        </script>
    </head>

    <body id="container" class="" data-ng-controller="NotificationCenter"  style="background:#f7f7f7;">  

        <div class="header" style="position: relative;">
       
                    <div class="head width100" style="background:#fff;  border-bottom: 0px solid #085b80; ">

                        <div id="section_title" class="" style="font-size:25px;  width: 100%; text-align: center; background:#fff; height: 16vh;">
                            <img src="<?php echo base_url(); ?>assets/images/BVG_Logo_big.png" alt="BVG"  style="float:left; margin-left: 20px; height: calc( 100% - 40px); width: auto; margin-top: 20px;"/>
                            <div class="text-centre" style="font-size:6vh; width: 80%; border-left: 0px; color:#c00000; display: block; font-weight: bold;  float: left;">
                                Madhya Pradesh EMS LIVE SUMMARY
                                 <span class="text-centre" style="font-size:4vh; width: 100%; border-left: 0px; color:#085b80; font-weight: bold; display: block;">
                                <?php echo date("F j, Y, g:i a"); ?>
                                </span>
                            </div>
                            <img src="<?php echo base_url(); ?>assets/images/Logo_Govt_05.jpg" alt="BVG"  style="float:right; margin-right: 20px; height: calc( 100% - 40px); width: auto; margin-top: 20px;" />
                           

                        </div>





                    </div>

        </div>

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
                           <!--  <li><div class="header_text_block"> Total Call 108: </div><div class="header_count_block"><?php echo $total_calls_td_108; ?></div><div class="header_percentage_count"><?php echo round(($total_calls_td_108 / $total_calls_td) * 100, 2); ?>%</div></li>
                           <li><div class="header_text_block"> Total Call 102: </div><div class="header_count_block"><?php echo $total_calls_td_102; ?></div><div class="header_percentage_count"><?php echo round(($total_calls_td_102 / $total_calls_td) * 100, 2); ?>%</div></li>-->
                        </ul>
                        <ul class="dashboard_count_outer">
<?php $total_noneme = $total_calls_td - $total_dispatch_108; ?>
                            <li><div class="header_text_block"> EM Cases 108: </div><div class="header_count_block"><?php echo $total_dispatch_108; ?></div><div class="header_percentage_count"><?php echo round(($total_dispatch_108 / $total_calls_td) * 100, 2); ?>%</div></li>
                            <li><div class="header_text_block"> Non EM Cases 108: </div><div class="header_count_block"><?php echo $total_noneme; ?></div><div class="header_percentage_count"><?php echo round(($total_noneme / $total_calls_td) * 100, 2); ?>%</div></li>
    <!--                        <li><div class="header_text_block"> EM Cases 102: </div><div class="header_count_block"><?php echo $total_dispatch_102; ?></div><div class="header_percentage_count"><?php echo round(($total_dispatch_102 / $total_calls_td) * 100, 2); ?>%</div></li>-->
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
                                    $call_avg = ($per_min_calls/60)*100;
                                    ?>
                            <div class="flow_108">
                                <div class="call_flow_text">
                                    108 Call Flow: <span> <?php echo $per_min_calls; ?>  Call / Min</span>
                                </div>
                                <div class="call_flow_process">
                                   
                                    <div class="dash_progress_bar">
                                        <div class="dash_progress" style="width: <?php echo $call_avg;?>%;">
                                          <?php echo $per_min_calls; ?> Calls
                                        </div>
                                    </div>
<!--                                    <div class="progress">
                                        <div class="progress-bar progress-bar-striped active" role="progressbar"
                                             aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width:40%">
                                            3 Call
                                        </div>
                                    </div> -->
                                </div>
                            </div>
                        </div>


                    </div>

                </div>

            </div>
        
        <footer class="footer" style="background: #002957; height: 11vh">
            <img src="<?php echo base_url(); ?>assets/images/Bvg_spero.png" alt="BVG" style="float:right; margin-left: 20px; margin-top: 5px; margin-right: 5px; height: calc( 100% - 20px); width: auto;"/>
        </footer> 
                <script>
<?php 
$chart_value = array($today_dispatch_108,$today_noneme_108);
$chart_color = array('#01ff00','#c00000');
$chart_label = array('Emergency',' Non Emergency');
?>
var $data = {
  datasets: [{
    data: <?php echo json_encode($chart_value);?>,
    backgroundColor:  <?php echo json_encode($chart_color);?>
  }],
  labels:  <?php echo json_encode($chart_label);?>,
};
  //console.log($data);
    var canvas = document.getElementById("pie-chart");
    var ctx = canvas.getContext("2d");
    var myNewChart = new Chart(ctx, {
      type: 'pie',
      data: $data,
      options:{
          title: {
        display: true,
        text: ''
      },
          onClick:function($ev,$ele){ 
              var $_index = $ele[0]['_index'];
              var $click_id = $data['ids'][$_index];
              $('#atc_'+$click_id).click();
          }
      }
    });
        </script>


    </body>
    <style>
    li{
        padding-top: 3px;
    }
    </style>
</html>