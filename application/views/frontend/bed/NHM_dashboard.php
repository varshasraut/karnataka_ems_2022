<?php $CI = EMS_Controller::get_instance();
//var_dump($district_bed);die();
?>

<div id="tabs" >
  <ul style="font-weight:bold" >
  <li class="active" ><a  href="#tabs-1">Bed Avaibility</a></li>
    <li><a href="#tabs-2">Map</a></li>
    <li><a href="#tabs-3">PCMC</a></li>
    <li><a href="#tabs-4">PMC</a></li>
    
  </ul>
  <div class="tab-content">
  <div id="tabs-1">
  
    <?php 

    if($clg_group=='UG-DISTRICT-OPERATIONAL-HEAD'){
      include "nhm_bed_district_dashboard_view.php";
    }
    if($clg_group=='UG-NHM-DASHBOARD'){
       include "nhm_bed_dashboard_view.php";
    } 
    if($clg_group=='UG-DIVISIONAL-OPERATION-HEAD'){
      include "nhm_bed_division_dashboard_view.php";
    }
    ?>
    
    <div id="district_data">
    </div>
   <div id="hos_data">
   </div>
   <div id="hos_bed_data">
   </div>
   
  </div>
  
  <div id="tabs-2" style="min-height: 600px;">
    <?php include "nhm_all_amb_loc_view.php"; ?>
  </div>
  <div id="tabs-3" style="min-height: 600px;">
    <?php include "nhm_pcmc_amb_loc_view.php"; ?>
  </div>
  <div id="tabs-4" style="min-height: 600px;">
    <?php include "nhm_pmc_amb_loc_view.php"; ?>
  </div>
 
  </div>
</div>