
<link href="<?php echo base_url(); ?>assets/css/font-face.css" rel="stylesheet" media="all">
<link href="<?php echo base_url(); ?>assets/vendor/mdi-font/css/material-design-iconic-font.min.css" rel="stylesheet" media="all">
<link href="<?php echo base_url(); ?>assets/vendor/bootstrap-4.1/bootstrap.min.css" rel="stylesheet" media="all">
<script type="text/javascript" > var base_url = '{base_url}'; </script>
<script src="<?php echo base_url(); ?>assets/js/gijgo.min.js" type="text/javascript"></script>
<link href="<?php echo base_url(); ?>assets/css/gijgo.min.css" rel="stylesheet" type="text/css" /> 
  
    
<link href="<?php echo base_url(); ?>assets/vendor/animsition/animsition.min.css" rel="stylesheet" media="all">     <link href="<?php echo base_url(); ?>assets/vendor/bootstrap-progressbar/bootstrap-progressbar-3.3.4.min.css" rel="stylesheet" media="all">
<link href="<?php echo base_url(); ?>assets/css/theme.css" rel="stylesheet" media="all">

<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css">

<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
<script src="http://www.instinctcoder.com/wp-content/uploads/2014/02/tabnavi.js"></script>


    <script>
  jQuery(function () {
    jQuery( "#tabs" ).tabs();
 
  });

jQuery( "#tabs #ui-id-2" ).on( "mouseup", function() {
     setTimeout(function(){
                              loadmap();
							 },1000);

} );
 </script>

<style>

.paddindOverRide{
    padding: 0px 1px;
   
}    
    .NHM_Dashboard {
  font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
  border-collapse: collapse;
  width: 100%;
  padding: 2px;  
  height: 100%;
}
.NHM_Dashboard td, #NHM_Dashboard th {
  border: 1px solid black;
  text-align: center;
  width: 36%;
  padding-top: 8px;
}
.footer {
    position: fixed;
   left: 0;
   bottom: 0;
   width: 100%;
 
   color: white;
   text-align: center;
}

.NHM_Dashboard tr:nth-child(even){background-color: #f2f2f2;}
.NHM_Dashboard tr:nth-child(odd){background-color: #f2f2f2;}

.NHM_Dashboard tr:hover {background-color: #ddd;}

.NHM_Dashboard th {
  padding-top: 12px;
  padding-bottom: 12px;
  text-align: center;
  background-color: #085B80;
  color: white;
  font-weight:normal;
  font-size:17px;
  border: 1px solid black;
  
}

.NHM_Dashboard_report{
  font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
  border-collapse: collapse;
  width: 100%;
  padding: 2px;  
  height: 100%;
}
.NHM_Dashboard_report td, #NHM_Dashboard_report th {
  border: 1px solid black;
  text-align: center;
  width: 20%;
  padding-top: 8px;
}
.NHM_Dashboard_report tr:nth-child(even){background-color: #f2f2f2;}
.NHM_Dashboard_report tr:nth-child(odd){background-color: #f2f2f2;}

.NHM_Dashboard_report tr:hover {background-color: #ddd;}

.NHM_Dashboard_report th {
  padding-top: 12px;
  padding-bottom: 12px;
  text-align: center;
  background-color: #1ABC9C;
  color: white;
  font-weight:normal;
  font-size:17px;
  border: 1px solid black;
  
}

#popup_div .txt_clr2 {
    margin-top:0px !important;
}
#popup_div table > tbody > tr > td {
   min-height: 30px;
}
#popup_div table > tbody > tr:nth-child(2n) > td {
    background-color: #F3F3F3;
}
#content .field_row .filed_input, #popup_div .field_row .filed_input {
    position: relative;
}
#content .field_row .filed_input input[type="file"], #popup_div .field_row .filed_input input[type="file"], #catalog_file {
    height: 33px;
    margin-top: 10px;
}
a.lnk_icon_btns {
    border: 1px solid #ffffff;
    padding: 5px 7px 5px 7px;
    border-radius: 50px;
    font-size: 14px;
    background: #ffffff!important;
    color: #085b80;
}
.head .profile_content .profile_box .head_links a.break_lnk{
    background: url('../images/break.png') no-repeat 10px 5px;
}

.mi_autocomplete {
    background: rgb(255,255,255) url('../images/drop_down_arrow.png') right center no-repeat !important;
    background-position: 97% !important;
    padding-right: 27px !important;
}
.mi_loader {
    border: 6px solid #00FFFF;
    border-top: 6px solid #085b80;
    border-bottom: 6px solid #085b80;
    background-color: #FFFFFF;
    border-radius: 50%;
    width: 50px;
    height: 50px;
    text-align: center;
    animation: spiner 2s linear infinite;
    -webkit-box-shadow: 0px 0px 10px 1px rgba(64,64,64,1);
    -moz-box-shadow: 0px 0px 10px 1px rgba(64,64,64,1);
    box-shadow: 0px 0px 10px 1px rgba(64,64,64,1);
    position: fixed;
    left: calc(-50vw - 45px);
    right: calc(-50vw - 45px);
    top: calc(-50vh - 40px);
    bottom: calc(-50vh - 40px);
    margin: auto;
    z-index: 99999;
}
</style>
<div id="tabs" >
  <ul style="font-weight:bold" >
  <li class="active" ><a  href="#tabs-1">Bed Avaibility</a></li>
  <li><a href="#tabs-2">Map</a></li>
  <!--<li><a href="#tabs-3">Report</a></li>-->
  <li><a href="<?php echo base_url();?>bed/nhm_dash_report">Report</a></li>
  <li><a href="<?php echo base_url();?>bed/vehical_tracking">Vehicle Monitoring</a></li>
  
    
  </ul>
  <div class="tab-content">
  <div id="tabs-1">
  
    <?php include "nhm_bed_district_dashboard_view.php";

    
       //include "nhm_bed_dashboard_view.php";
   
    ?>
      
    
    <div id="district_data">
    </div>
   <div id="hos_data">
   </div>
   <div id="hos_bed_data">
   </div>
   
  </div>
  <div id="tabs-2" style="min-height: 600px;">
    <?php include "nhm_all_amb_loc_remote_view.php"; ?>
  </div>
  <!--<div id="tabs-3" style="min-height: 600px;">
    <?php //include "nhm_report_view.php"; ?>
  </div>-->
      
   
 
  </div>
</div>