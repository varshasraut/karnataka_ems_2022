<?php $CI = EMS_Controller::get_instance();
//var_dump($district_bed);die();
?>
<div id="tabs" >
  <ul style="font-weight:bold" >
    <li class="active" ><a  href="#tabs-1">Dispatch</a></li>
    <li><a href="#tabs-2">Map</a></li>
    <li><a href="#tabs-3">B12 Data</a></li>
    <li><a href="<?php echo base_url();?>screendashboard" target="_blank">Overview</a></li>
  </ul>
  <div class="tab-content">
  <div id="tabs-2" style="min-height: 700px;"><?php include "nhm_all_amb_loc_view.php"; ?></div>
  <div id="tabs-1"> <?php  include "nhm_dispatch_view.php"; ?></div>
  <div id="tabs-3"><?php include "nhm_b12_reports_view.php"; ?></div>
<!--  <div id="tabs-4"><?php include "Overview_ScreenDashboard.php"; ?></div>-->
  
</div>
</div>