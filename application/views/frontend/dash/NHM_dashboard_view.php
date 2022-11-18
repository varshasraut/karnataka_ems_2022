<?php
$CI = EMS_Controller::get_instance();
?><style>
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
</style>
<?php

if ($clg_ref_id == 'IT' || $clg_group == 'UG-Dashboard-view') {
?>

  <div id="tabs" style="margin-top: 10px;">
    <ul style="font-weight:bold">
      <!-- <li class="active" ><a href="#tabs-1" onClick="window.location.reload();">Home</a></li> -->
      <li class="active"><a href="#tabs-1">Home</a></li>
      <li><a href="#tabs-2">Map</a></li>
      <!-- <li><a href="<?php echo base_url(); ?>dashboard/B12_data">Patient Served</a></li>
    <li><a href="<?php echo base_url(); ?>dashboard/B12_data_New">Emergency Served</a></li>
    <li><a href="<?php echo base_url(); ?>dashboard/biomedical_data">Biomedical</a></li> -->
      <!--<li><a href="<?php echo base_url(); ?>dashboard/nhm_live_calls_dash">Live Calls</a></li>-->
      <li><a href="<?php echo base_url(); ?>dashboard/nhm_districtwise_emergency_patients_served_dash">Emergency Patients Served</a></li>
     <!-- <li><a href="<?php echo base_url(); ?>dashboard/nhm_total_dist_travelled_by_amb">Distance Travelled</a></li> -->
      <!-- <li><a href="<?php echo base_url(); ?>dashboard/responce_time">Response Time</a></li> -->
      <!--<li><a href="<?php echo base_url(); ?>dashboard/ambulance_tracking">Ambulance Tracking</a></li>-->
      <li><a href="<?php echo base_url(); ?>dashboard/nhm_amb_report_dash">MDT Tracking Report</a></li>
      <!--<li><a href="#" onmousedown="window.open('<?php echo base_url(); ?>screendashboard','_blank');">Overview</a></li>-->
      <!-- <li><a href="<?php echo base_url(); ?>dashboard/link" class="yourlink">Ambulance Movement Live</a> -->
      <li>
      <!-- <li><a href="<?php echo base_url(); ?>dashboard/Historical_dash" class="Historical_dash_data">Ambulance Movement Historical</a> -->
      <li>
      <!-- <li><a href="<?php echo base_url(); ?>dashboard/gio_dash_data" class="gio_dash_data">Geofencing</a> -->
      <li>


      <!-- <li><a href="<?php echo base_url(); ?>dashboard/ambulance_status">ONROAD/OFFROAD Ambulance Status</a> -->
      <li>
      <!-- <li><a href="<?php echo base_url(); ?>dashboard/get_dash_report">Dashboard Report</a> -->
      <li>
        <!-- <li><a href="<?php echo base_url(); ?>dashboard/ambulance_status_realtime" >ONROAD/OFFROAD Status Realtime</a><li> -->
        <!--<li><a href="<?php echo base_url(); ?>dashboard/B12_datatype" >B12 Data</a><li>-->
    </ul>
    <div class="tab-content" style="min-height:900px;">
      <div id="tabs-2" style="min-height:600px;"> <?php include "nhm_all_amb_loc_view.php"; ?></div>
      <div id="tabs-1"> <?php include "mems_dashboard_view.php"; ?></div>
      <!--<div id="tabs-1"> <?php  //include "nhm_live_call_view.php"; 
                            ?></div>
 <div id="tabs-4"> <?php //include "NHM_dash_view.php"; 
                    ?></div>-->

    </div>
  </div>
<?php
} else if ($clg_group == 'UG-EMSCOORDINATOR') { ?>
  <div id="tabs" style="margin-top: 10px;">
    <ul style="font-weight:bold">
      <li class="active"><a href="#tabs-1">MDT Tracking Report</a></li>

      <li><a href="<?php echo base_url(); ?>dashboard/link" class="yourlink">Ambulance Movement Live</a>
      <li>
      <li><a href="<?php echo base_url(); ?>dashboard/Historical_dash" class="Historical_dash_data">Ambulance Movement Historical</a>
      <li>
      <li><a href="<?php echo base_url(); ?>dashboard/ambulance_status">ONROAD/OFFROAD Ambulance Status</a>
      <li>
    </ul>
    <div class="tab-content" style="min-height:1200px;">
      <div id="tabs-1"> <?php include "nhm_amb_report_view.php"; ?></div>

    </div>
  </div>
  <div id="test_script">

  </div>

<?php } else { ?>
  <div id="tabs" style="margin-top: 10px;">
    <ul style="font-weight:bold">
      <!-- <li class="active" ><a href="#tabs-1" onClick="window.location.reload();">Home</a></li> -->
      <li class="active"><a href="#tabs-1">Home</a></li>
      <li><a href="#tabs-2">Map</a></li>
      <!--<li><a href="<?php echo base_url(); ?>dashboard/B12_data">Patient Served</a></li>-->
      <li><a href="<?php echo base_url(); ?>dashboard/B12_data_New">Emergency Served</a></li>

      <!-- <li><a href="<?php echo base_url(); ?>dashboard/biomedical_data">Biomedical</a></li> -->
      <!-- *<li><a href="<?php echo base_url(); ?>dashboard/B12_data">Emergency Served</a></li>
      <li><a href="<?php echo base_url(); ?>dashboard/nhm_live_calls_dash">Live Calls</a></li>
      <li><a href="<?php echo base_url(); ?>dashboard/nhm_districtwise_emergency_patients_served_dash">District-Wise Emergency Patients</a></li>
      <li><a href="<?php echo base_url(); ?>dashboard/nhm_total_distance_travelled_by_ambulance_dash">Distance Travelled</a></li>-->
      <!--<li><a href="<?php echo base_url(); ?>dashboard/responce_time">Response Time</a></li>-->
      <!--<li><a href="<?php echo base_url(); ?>dashboard/ambulance_tracking">Ambulance Tracking</a></li>-->
      <li><a href="<?php echo base_url(); ?>dashboard/nhm_amb_report_dash">MDT Tracking Report</a></li>
      <li><a href="<?php echo base_url(); ?>dashboard/link" class="yourlink">Ambulance Movement Live</a>
      <li>
      <li><a href="<?php echo base_url(); ?>dashboard/Historical_dash" class="Historical_dash_data">Ambulance Movement Historical</a>
      <li>
      <li><a href="<?php echo base_url(); ?>dashboard/gio_dash_data" class="gio_dash_data">Geofencing</a>
      <li>

      <li><a href="<?php echo base_url(); ?>dashboard/ambulance_status">ONROAD/OFFROAD Ambulance Status</a>
      <li>
      <li><a href="<?php echo base_url(); ?>file_nhm/file_nhm_report">NHM Monthly Report</a>
      <li>
      <li><a href="<?php echo base_url(); ?>dashboard/get_dash_report">Dashboard Report</a>
      <li>

        <!-- <li><a href="<?php echo base_url(); ?>dashboard/get_dash_report" >Dashboard Report</a><li> -->
        <!-- <li><a href="<?php echo base_url(); ?>dashboard/B12_datatype" >B12 Data</a><li>-->
        <!-- <li><a href="#" onmousedown="window.open('<?php echo base_url(); ?>screendashboard','_blank');">Overview</a></li>-->


    </ul>
    <div class="tab-content" style="min-height:1200px;">
      <div id="tabs-2" style="min-height:600px;"> <?php include "nhm_all_amb_loc_view.php"; ?></div>
      <!--<div id="tabs-1"> <?php // include "nhm_live_call_view.php"; 
                            ?></div>-->
      <div id="tabs-1"> <?php include "mems_dashboard_view.php"; ?></div>


    </div>
  </div>
  <div id="test_script">

  </div>
<?php }
?>


<script>
  $('a.yourlink').click(function(e) {

    setTimeout(function() {
      $(".mi_loader").fadeOut("slow");
    }, 1000);
    e.preventDefault();
    window.open('https://www.nuevastech.com/API/API_MEMsLiveAmbulanceDashboard.aspx?username=MEMSADMIN&accesskey=EC7206C53E1CEDA1D7B2');
    window.open('https://www.nuevastech.com/API/API_MEMsLiveAmbulanceDashboard.aspx?username=MEMSADMIN&accesskey=EC7206C53E1CEDA1D7B2');

  });
  $('a.Historical_dash_data').click(function(e) {

    setTimeout(function() {
      $(".mi_loader").fadeOut("slow");
    }, 1000);
    e.preventDefault();
    window.open('https://www.nuevastech.com/API/API_MEMSVehicleMap.aspx?username=MEMSADMIN&accesskey=EC7206C53E1CEDA1D7B2');
    window.open('https://www.nuevastech.com/API/API_MEMSVehicleMap.aspx?username=MEMSADMIN&accesskey=EC7206C53E1CEDA1D7B2');

  });

  $('a.gio_dash_data').click(function(e) {

    setTimeout(function() {
      $(".mi_loader").fadeOut("slow");
    }, 1000);
    e.preventDefault();
    window.open('http://210.212.165.118/DashboardNew.aspx');
    window.open('http://210.212.165.118/DashboardNew.aspx');

    // window.open('https://www.nuevastech.com/API/API_MEMSVehicleMap.aspx?username=MEMSADMIN&accesskey=EC7206C53E1CEDA1D7B2');

  });
</script>
<script>
  document.oncontextmenu = document.body.oncontextmenu = function() {
    return false;
  }
</script>
<script>
  jQuery(document).ready(function($) {
    $(document).keydown(function(event) {
      var pressedKey = String.fromCharCode(event.keyCode).toLowerCase();

      if (event.ctrlKey && (pressedKey == "u")) {
        // alert('Sorry, This Functionality Has Been Disabled!');
        //disable key press porcessing
        return false;
      }
    });
  });
</script>