<?php $CI = EMS_Controller::get_instance(); ?>
<style>
td, th {
  border: 1px solid #dddddd;
  text-align: left;
  padding: 8px;
}
</style>
<div class="width100">
   <h2>Reports</h2><br>

<form enctype="multipart/form-data"  method="post">
    <div class="NHM_report_tables">
        <table>
            <tr>   
                <th>Report</th>
                <th>Action</th>
            </tr>
            <?php 
            $inc_report = $CI->modules->get_tool_config('MT-ERC-REPORTS-INCIDENT', 'M-REPORTS', true);
            if($inc_report){?>
            <tr>
                <td>Incident Reports</td>
                <td><a class="onpage_popup btn"  data-href="{base_url}erc_reports/load_erc_report_form" data-qr="output_position=popup_div&report_type=Incident_Reports" data-popupwidth="2500" data-popupheight="800">View</a></td>

            </tr>
            <?php } 
            $inc_report = $CI->modules->get_tool_config('MT-ERC-REPORTS-INCIDENT-PVT-HOS', 'M-REPORTS', true);
            if($inc_report){?>
            <tr>
                <td>Incident Pvt Hospital Reports</td>
                <td><a class="onpage_popup btn"  data-href="{base_url}erc_reports/load_erc_report_form" data-qr="output_position=popup_div&report_type=Incident_Pvt_Hos_Reports" data-popupwidth="2500" data-popupheight="800">View</a></td>

            </tr>
            <?php }
             $closure_report = $CI->modules->get_tool_config('MT-ERC-REPORTS-CLOSURE', 'M-REPORTS', true);
            if($closure_report){
            ?>
            <tr>
                <td>Closure Report</td>
                <td><a class="onpage_popup btn"  data-href="{base_url}erc_reports/load_erc_report_form" data-qr="output_position=popup_div&report_type=Closure_Reports" data-popupwidth="2500" data-popupheight="800">View</a></td>
            </tr>
            <?php } 
             $closure_report = $CI->modules->get_tool_config('MT-ERC-REPORTS-LAT-LONG-CLOSURE', 'M-REPORTS', true);
             if($closure_report){
             ?>
             <tr>
                 <td>Closure Lat Long Report</td>
                 <td><a class="onpage_popup btn"  data-href="{base_url}erc_reports/load_erc_report_form" data-qr="output_position=popup_div&report_type=Closure_lat_long_Reports" data-popupwidth="2500" data-popupheight="800">View</a></td>
             </tr>
             <?php }
            $base_location_report = $CI->modules->get_tool_config('MT-BASE_AMB', 'M-REPORTS', true);
            if($base_location_report){
            ?>
            <tr>
                <td>Base Location Report</td>
                <td><a class="onpage_popup btn"  data-href="{base_url}erc_reports/base_location_report" data-qr="output_position=popup_div&report_type=Base_Location_Report" data-popupwidth="2500" data-popupheight="800">View</a></td>
            </tr>
            <?php } 
             $validation_report = $CI->modules->get_tool_config('MT-ERC-REPORTS-CLOSURE-VALIDATION', 'M-REPORTS', true);
            if($validation_report){
            ?>
            <tr>
                <td>Closure Validation Report</td>
                <td><a class="onpage_popup btn"  data-href="{base_url}erc_reports/load_erc_report_form" data-qr="output_position=popup_div&report_type=Closure_Validation_Reports" data-popupwidth="2500" data-popupheight="800">View</a></td>
            </tr>
            <?php } 
            $patient_transport_report = $CI->modules->get_tool_config('MT-ERC-REPORTS-PATIENT_TRANSPORT', 'M-REPORTS', true);
            if($patient_transport_report){ ?>
            <tr>
                <td>Patient Transport Report</td>
                <td><a class="onpage_popup btn"  data-href="{base_url}erc_reports/load_erc_report_form" data-qr="output_position=popup_div&report_type=Patient_Transport_Reports" data-popupwidth="2500" data-popupheight="800">View</a></td>

            </tr>
               <?php } 
            $ambulance_report = $CI->modules->get_tool_config('MT-ERC-REPORTS-AMBULANCE', 'M-REPORTS', true);
            if($ambulance_report){ ?>
            <tr>
                 <td>Ambulance Report</td>
                <td><a class="onpage_popup btn"  data-href="{base_url}erc_reports/load_erc_report_form" data-qr="output_position=popup_div&report_type=ambulance_report" data-popupwidth="2500" data-popupheight="800">View</a></td>
            </tr>
              <?php }
              $ambulance_report_list = $CI->modules->get_tool_config('MT-ERC-REPORTS-AMBULANCE-LIST', 'M-REPORTS', true);
              if($ambulance_report_list){ ?>
              <tr>
                   <td>Ambulance Listing Report</td>
                  <td><a class="onpage_popup btn"  data-href="{base_url}erc_reports/load_erc_report_form" data-qr="output_position=popup_div&report_type=ambulance_listing_report" data-popupwidth="2500" data-popupheight="800">View</a></td>
              </tr>
                <?php } 
                $ambulance_master_report = $CI->modules->get_tool_config('MT-ERC-REPORTS-ALL-AMBULANCE-MASTER-REPORT', 'M-REPORTS', true);
                if($ambulance_master_report){ ?>
                <tr>
                     <td>All Ambulance Master Report</td>
                    <td><a class="onpage_popup btn"  data-href="{base_url}erc_reports/load_erc_report_form" data-qr="output_position=popup_div&report_type=ambulance_master_report" data-popupwidth="2500" data-popupheight="800">View</a></td>
                </tr>
                  <?php } 
                  $ambulance_logout_report = $CI->modules->get_tool_config('MT-ERC-REPORTS-AMBULANCE-LOGOUT-REPORT', 'M-REPORTS', true);
                  if($ambulance_logout_report){ ?>
                  <tr>
                       <td>MDT Logout Report</td>
                      <td><a class="onpage_popup btn"  data-href="{base_url}erc_reports/load_erc_report_form" data-qr="output_position=popup_div&report_type=ambulance_logout_report" data-popupwidth="2500" data-popupheight="800">View</a></td>
                  </tr>
                    <?php } 
                $nhm_104_report = $CI->modules->get_tool_config('MT-ERC-REPORTS-104-REPORT', 'M-REPORTS', true);
                if($nhm_104_report){ ?>
                <tr>
                     <td>104 Report</td>
                    <td><a class="onpage_popup btn"  data-href="{base_url}erc_reports/load_erc_report_form" data-qr="output_position=popup_div&report_type=nhm_104_report" data-popupwidth="2500" data-popupheight="800">View</a></td>
                </tr>
                  <?php }
            $employee_report = $CI->modules->get_tool_config('MT-ERC-REPORTS-EMPLOYEE', 'M-REPORTS', true);
            if($employee_report){ ?>
            <tr>
                <td>Employee Report</td>
                <td><a class="onpage_popup btn"  data-href="{base_url}erc_reports/load_erc_report_form" data-qr="output_position=popup_div&report_type=employee_report" data-popupwidth="2500" data-popupheight="800">View</a></td>
            </tr>
                <?php } 

            $employee_details_report = $CI->modules->get_tool_config('MT-ERC-REPORTS-EMPLOYEE-DETAILS', 'M-REPORTS', true);
            if($employee_details_report){ ?>
            <tr>
                <td>Employee Details Report</td>
                <td><a class="onpage_popup btn"  data-href="{base_url}erc_reports/load_erc_report_form" data-qr="output_position=popup_div&report_type=employee_details_report" data-popupwidth="2500" data-popupheight="800">View</a></td>
            </tr>
                <?php }       

            $daily_report = $CI->modules->get_tool_config('MT-ERC-REPORTS-DAILY', 'M-REPORTS', true);
            if($daily_report){ ?>
            <tr>
                <td>Daily</td>
                <td><a class="onpage_popup btn"  data-href="{base_url}erc_reports/load_erc_report_form" data-qr="output_position=popup_div&report_type=daily_report" data-popupwidth="2500" data-popupheight="800">View</a></td>
            </tr>
              <?php } 
            $onroad_offroad_report = $CI->modules->get_tool_config('MT-ERC-REPORTS-ON-OFF-ROAD', 'M-REPORTS', true);
            if($onroad_offroad_report){ ?>
            <tr>
                <td>On-road - Off-road Report</td>
                <td><a class="onpage_popup btn"  data-href="{base_url}erc_reports/load_erc_report_form" data-qr="output_position=popup_div&report_type=onroad_offroad_report" data-popupwidth="2500" data-popupheight="800">View</a></td>
            </tr>
              <?php } 
               $inspection_details_report = $CI->modules->get_tool_config('MT-ERC-REPORTS-INSPECTION-DETAILS', 'M-REPORTS', true);
               if($inspection_details_report){ ?>
               <tr>
                   <td>Inspection Details Report</td>
                   <td><a class="onpage_popup btn"  data-href="{base_url}erc_reports/load_erc_report_form" data-qr="output_position=popup_div&report_type=inspection_details_report" data-popupwidth="2500" data-popupheight="800">View</a></td>
               </tr>
                 <?php }
            $b12_report = $CI->modules->get_tool_config('MT-ERC-REPORTS-B12', 'M-REPORTS', true);
            if($b12_report){ ?>
            <tr>
                <td>B12 Report</td>
                <td><a class="onpage_popup btn"  data-href="{base_url}erc_reports/load_erc_report_form" data-qr="output_position=popup_div&report_type=b12_report" data-popupwidth="2500" data-popupheight="800">View</a></td>
            </tr>
              <?php } 
              $b12_report_new = $CI->modules->get_tool_config('MT-ERC-REPORTS-B12-NEW', 'M-REPORTS', true);
              if($b12_report_new){ ?>
              <tr>
                  <td>B12 Report New</td>
                  <td><a class="onpage_popup btn"  data-href="{base_url}erc_reports/load_erc_report_form" data-qr="output_position=popup_div&report_type=b12_report_new" data-popupwidth="2500" data-popupheight="800">View</a></td>
              </tr>
                <?php }
            $pda_report = $CI->modules->get_tool_config('MT-ERC-REPORTS-PDA', 'M-REPORTS', true);
            if($pda_report){ ?>
            
            <tr>
                <td>PDA Report</td>
                <td><a class="onpage_popup btn"  data-href="{base_url}erc_reports/load_erc_report_form" data-qr="output_position=popup_div&report_type=pda_report" data-popupwidth="2500" data-popupheight="800">View</a></td>
            </tr>
            <?php } 
            $fda_report = $CI->modules->get_tool_config('MT-ERC-REPORTS-FDA', 'M-REPORTS', true);
            if($fda_report){ ?>
            <tr>
                <td>FDA Report</td>
                <td><a class="onpage_popup btn"  data-href="{base_url}erc_reports/load_erc_report_form" data-qr="output_position=popup_div&report_type=fda_report" data-popupwidth="2500" data-popupheight="800">View</a></td>
            </tr>
             <?php } 
            $grieviance_report = $CI->modules->get_tool_config('MT-ERC-REPORTS-GRIEVANCE', 'M-REPORTS', true);
            if($grieviance_report){ ?>
             <tr>
                <td>Grievance Report</td>
                <td><a class="onpage_popup btn"  data-href="{base_url}erc_reports/load_erc_report_form" data-qr="output_position=popup_div&report_type=grieviance_report" data-popupwidth="2500" data-popupheight="800">View</a></td>
            </tr>
             <?php } 
            $feedback_report = $CI->modules->get_tool_config('MT-ERC-REPORTS-FEEDBACK', 'M-REPORTS', true);
            if($feedback_report){ ?>
             <tr>
                <td>Feedback Report</td>
                <td><a class="onpage_popup btn"  data-href="{base_url}erc_reports/load_erc_report_form" data-qr="output_position=popup_div&report_type=feedback_report" data-popupwidth="2500" data-popupheight="800">View</a></td>
            </tr>
             <?php } 
            $ercp_report = $CI->modules->get_tool_config('MT-ERC-REPORTS-ERCP', 'M-REPORTS', true);
            if($ercp_report){ ?>
              <tr>
               <td>ERCP Report</td>
                <td><a class="onpage_popup btn"  data-href="{base_url}erc_reports/load_erc_report_form" data-qr="output_position=popup_div&report_type=ercp_report" data-popupwidth="2500" data-popupheight="800">View</a></td>
            </tr>
              <?php } 
            $quality_report = $CI->modules->get_tool_config('MT-ERC-REPORTS-QUALITY', 'M-REPORTS', true);
            if($quality_report){ ?>
            <tr>
                <td>Quality Report</td>
                <td><a class="onpage_popup btn"  data-href="{base_url}quality_forms/quality_report" data-qr="output_position=popup_div&report_type=quality_report" data-popupwidth="2500" data-popupheight="800">View</a></td>
            </tr>
             <?php } 
            $master_report = $CI->modules->get_tool_config('MT-ERC-REPORTS-MASTER', 'M-REPORTS', true);
            if($master_report){ ?>
            <tr>
                <td>Master Report</td>
                <td><a class="onpage_popup btn"  data-href="{base_url}erc_reports/load_erc_report_form" data-qr="output_position=popup_div&report_type=master_report" data-popupwidth="2500" data-popupheight="800">View</a></td>
            </tr>
             <?php } 
            $quality_master_report = $CI->modules->get_tool_config('MT-ERC-REPORTS-QUALITY-MASTER', 'M-REPORTS', true);
            if($quality_master_report){ ?>
            <tr>
                <td>Quality Master Report</td>
                <td><a class="onpage_popup btn"  data-href="{base_url}quality_forms/quality_report" data-qr="output_position=popup_div&report_type=quality_master_report" data-popupwidth="2500" data-popupheight="800">View</a></td>
            </tr>
             <?php } 
            $ambulance_maintenance_report = $CI->modules->get_tool_config('MT-ERC-REPORTS-AMB-MAINTENANCE', 'M-REPORTS', true);
            if($ambulance_maintenance_report){ ?>
            <tr>
                <td>Ambulance Maintenance Report</td>
                <td><a class="onpage_popup btn"  data-href="{base_url}quality_forms/ambulance_maintenance_report" data-qr="output_position=popup_div&report_type=ambulance_maintenance_report" data-popupwidth="2500" data-popupheight="800">View</a></td>
            </tr>
              <?php } 
            $shift_roster_report = $CI->modules->get_tool_config('MT-ERC-REPORTS-SHIFT-ROSTER', 'M-REPORTS', true);
            if($shift_roster_report){ ?>
            <tr>
            <td>Shift Roster Report</td>
                <td><a class="onpage_popup btn"  data-href="{base_url}quality_forms/shift_roster_report" data-qr="output_position=popup_div&report_type=shift_roster_report" data-popupwidth="2500" data-popupheight="800">View</a></td>
            </tr>
             <?php } 
            $call_count_aht_report = $CI->modules->get_tool_config('MT-ERC-REPORTS-CALL-COUNT-AHT', 'M-REPORTS', true);
            if($call_count_aht_report){ ?>
            <tr>
                 <td>Call Count/AHT Report</td>
                <td><a class="onpage_popup btn"  data-href="{base_url}erc_reports/load_erc_report_form" data-qr="output_position=popup_div&report_type=call_count_aht_report" data-popupwidth="2500" data-popupheight="800">View</a></td>
            </tr>
            <?php } 
            $fuel_filling_report = $CI->modules->get_tool_config('MT-ERC-REPORTS-FUEL-FILLING', 'M-REPORTS', true);
            if($fuel_filling_report){ ?>
            <tr>
                <td>Fuel Filling Report</td>
                <td><a class="onpage_popup btn"  data-href="{base_url}erc_reports/load_erc_report_form" data-qr="output_position=popup_div&report_type=fuel_filling_report" data-popupwidth="2500" data-popupheight="800">View</a></td>
            </tr>
            <?php } $patient_served_report = $CI->modules->get_tool_config('MT-ERC-REPORTS-SERVED-ASSIGN-AMB', 'M-REPORTS', true);
            if($patient_served_report){?>
            <tr>
                <td>Patient Served Report</td>
                <td><a class="onpage_popup btn"  data-href="{base_url}erc_reports/load_erc_report_form" data-qr="output_position=popup_div&report_type=patient_serverd_count_report" data-popupwidth="2500" data-popupheight="800">View</a></td>
            </tr>
             <?php }
             $patient_served_report = $CI->modules->get_tool_config('MT-UNABLE-TO-DISPATCH-REPORT', 'M-REPORTS', true);
            if($patient_served_report){?>
            <tr>
                <td>Unable To Dispatch Report</td>
                <td><a class="onpage_popup btn"  data-href="{base_url}erc_reports/load_erc_report_form" data-qr="output_position=popup_div&report_type=unable_to_dispatch_report" data-popupwidth="2500" data-popupheight="800">View</a></td>
            </tr>
            <?php } ?>
            <?php 
            $daily_dst_report = $CI->modules->get_tool_config('MT-ERC-REPORTS-DAILY-DIST', 'M-REPORTS', true);
            if($daily_dst_report){?>
            <tr>
                 <td>Daily District wise Report</td>
                <td><a class="onpage_popup btn"  data-href="{base_url}erc_reports/load_erc_report_form" data-qr="output_position=popup_div&report_type=daily_dist_report" data-popupwidth="2500" data-popupheight="800">View</a></td>

            </tr><?php } ?>
               <?php 
            $amb_cons_report = $CI->modules->get_tool_config('MT-AMB-CONS-REPORT', 'M-REPORTS', true);
            if($amb_cons_report){?>
            <tr>
                <td>Ambulance wise Consumable Report</td>
                <td><a class="onpage_popup btn"  data-href="{base_url}erc_reports/load_erc_report_form" data-qr="output_position=popup_div&report_type=ambulance_wise_cons_report" data-popupwidth="2500" data-popupheight="800">View</a></td>

            </tr><?php } ?>
            <?php 
          /*  $patient_served = $CI->modules->get_tool_config('MT-PATIENT-SERVED-REPORT', 'M-REPORTS', true);
            if($patient_served){?>
            <tr>
                <td>24</td>
                <td>Patient Served Report</td>
                <td><a class="onpage_popup btn"  data-href="{base_url}erc_reports/load_erc_report_form" data-qr="output_position=popup_div&report_type=patient_serverd_count_report" data-popupwidth="2500" data-popupheight="800">View</a></td>

            </tr><?php } */?>
            <?php 
            $daily_report_mcgm = $CI->modules->get_tool_config('MT-DAILY-REPORT-MCGM', 'M-REPORTS', true);
            if($daily_report_mcgm){?>
            <tr>
                <td>Daily Report - MCGM 108 Desk</td>
                <td><a class="onpage_popup btn"  data-href="{base_url}erc_reports/load_erc_report_form" data-qr="output_position=popup_div&report_type=daily_report_mcgm" data-popupwidth="2500" data-popupheight="800">View</a></td>

            </tr><?php } ?>
            <?php 
            $amb_avail = $CI->modules->get_tool_config('MT-ERC-REPORTS-AMBULANCE-AVAIL', 'M-REPORTS', true);
            if($amb_avail){?>
            <tr>
                <td>Ambulance Availability Report</td>
                <td><a class="onpage_popup btn"  data-href="{base_url}erc_reports/load_erc_report_form" data-qr="output_position=popup_div&report_type=daily_report_mcgm" data-popupwidth="2500" data-popupheight="800">View</a></td>

            </tr><?php }
             $inc_report = $CI->modules->get_tool_config('MT-ERC-REPORTS-AMB-APP-LOGIN', 'M-REPORTS', true);
             if($inc_report){ ?>
           <td>Ambulance Details MDT</td>
            <td><a class="onpage_popup btn"  data-href="{base_url}erc_reports/load_erc_report_form" data-qr="output_position=popup_div&report_type=ambulance_login_report" data-popupwidth="2500" data-popupheight="800">View</a></td>
             </tr>
             
             <?php } ?> <?php
             $inc_report = $CI->modules->get_tool_config('MT-ERC-REPORTS-PTA-RPT', 'M-REPORTS', true);
             if($inc_report){ ?>
            <td>Summary Report</td>
            <td><a class="onpage_popup btn"  data-href="{base_url}erc_reports/load_erc_report_form" data-qr="output_position=popup_div&report_type=pta_summery_report" data-popupwidth="2500" data-popupheight="800">View</a></td>
            </tr>
            <?php } ?>
            <?php 
            $provide_imp_report = $CI->modules->get_tool_config('MT-PROVIDE-IMP-REPORT', 'M-REPORTS', true);
            if($provide_imp_report){?>
            <tr>
                <td>Provider Impressions Districtwise Report</td>
                <td><a class="onpage_popup btn"  data-href="{base_url}erc_reports/load_erc_report_form" data-qr="output_position=popup_div&report_type=provide_imp_dist_report" data-popupwidth="2500" data-popupheight="800">View</a></td>

            </tr><?php  } ?>
            <?php 
            $report_res_time = $CI->modules->get_tool_config('MT-108-REPORTS-RESPONSE-TIME', 'M-REPORTS', true);
            if($report_res_time){ ?>
            <tr>
                <td>Response time report for 108</td>
                <td><a class="onpage_popup btn"  data-href="{base_url}erc_reports/load_erc_report_form" data-qr="output_position=popup_div&report_type=reports_response_time_108" data-popupwidth="2500" data-popupheight="800">View</a></td>

            </tr><?php } ?>
              <?php 
            $corona_summary_report = $CI->modules->get_tool_config('MT-Corona-summary-report', 'M-REPORTS', true);
            if($corona_summary_report){ ?>
            <tr>
                <td>Corona Summary Report</td>
                <td><a class="onpage_popup btn"  data-href="{base_url}erc_reports/corona_call_summary" data-qr="output_position=popup_div&report_type=corona_summary_report" data-popupwidth="2500" data-popupheight="800">View</a></td>

            </tr><?php } ?>
            <?php 
            $corona_details_report = $CI->modules->get_tool_config('MT-Corona-Details-report', 'M-REPORTS', true);
            if($corona_details_report){ ?>
            <tr>
                <td>Corona Details Report</td>
                <td><a class="onpage_popup btn"  data-href="{base_url}erc_reports/corona_call_details" data-qr="output_position=popup_div&report_type=corona_details_report" data-popupwidth="2500" data-popupheight="800">View</a></td>

            </tr><?php } ?>
            <?php 
            $corona_details_report = $CI->modules->get_tool_config('MT-Corona-responce-type-report', 'M-REPORTS', true);
            if($corona_details_report){ ?>
            <tr>
                <td>Corona Call Responce Type Report</td>
                <td><a class="onpage_popup btn"  data-href="{base_url}erc_reports/corona_call_responce_type_report" data-qr="output_position=popup_div&report_type=corona_details_report" data-popupwidth="2500" data-popupheight="800">View</a></td>

            </tr><?php } ?>
            <?php 
            $pre_maintaince_details_report = $CI->modules->get_tool_config('MT-PREV-Maintainance-report', 'M-REPORTS', true);
            if($pre_maintaince_details_report){ ?>
            <tr>
                <td>Preventive Maintenance Report</td>
                <td><a class="onpage_popup btn"  data-href="{base_url}erc_reports/pre_maintaince_details_report" data-qr="output_position=popup_div&report_type=corona_details_report" data-popupwidth="2500" data-popupheight="800">View</a></td>

            </tr><?php } ?>
            <?php 
            $HPCL_Report = $CI->modules->get_tool_config('MT-ERC-REPORTS-HPCLREPORT', 'M-REPORTS', true);
            if($HPCL_Report){ ?>
            <tr>
                <td>HPCL Ambulance Report</td>
                <td><a class="onpage_popup btn"  data-href="{base_url}erc_reports/load_erc_report_form" data-qr="output_position=popup_div&report_type=hpcl_ambulance_report" data-popupwidth="2500" data-popupheight="800">View</a></td>
            </tr><?php } ?>
             <?php 
            $cons_Report = $CI->modules->get_tool_config('MT-AMB-CONS-REP', 'M-REPORTS', true);
           // var_dump($cons_Report);
            if($cons_Report){ ?>
            <tr>
                 <td>Ambulance Consumption Report</td>
                <td><a class="onpage_popup btn"  data-href="{base_url}erc_reports/load_erc_report_form" data-qr="output_position=popup_div&report_type=cons_ambulance_report" data-popupwidth="2500" data-popupheight="800">View</a></td>
            </tr><?php } ?>
                 <?php 
            $fuel_report = $CI->modules->get_tool_config('MT-fuel-filling-report', 'M-REPORTS', true);
            if($fuel_report){
                ?>
            <tr>
                <td>Fuel Consumption Report</td>
                <td><a class="onpage_popup btn"  data-href="{base_url}erc_reports/load_erc_report_form" data-qr="output_position=popup_div&report_type=fuel_report" data-popupwidth="2500" data-popupheight="800">View</a></td>

            </tr><?php  } ?>
             <?php 
            $fuel_report = $CI->modules->get_tool_config('MT-vehicle-fuel-report', 'M-REPORTS', true);
            if($fuel_report){
                ?>
            <tr>
                <td>Vehicle Wise Fuel Consumption Data</td>
                <td><a class="onpage_popup btn"  data-href="{base_url}erc_reports/load_erc_report_form" data-qr="output_position=popup_div&report_type=vahicle_fuel_report" data-popupwidth="2500" data-popupheight="800">View</a></td>

            </tr><?php  } ?>
             <?php 
            $fuel_report = $CI->modules->get_tool_config('MT-DCO-validation-report', 'M-REPORTS', true);
            if($fuel_report){
                ?>
            <tr>
                <td>DCO validation report</td>
                <td><a class="onpage_popup btn"  data-href="{base_url}erc_reports/load_erc_report_form" data-qr="output_position=popup_div&report_type=dco_validation_report" data-popupwidth="2500" data-popupheight="800">View</a></td>

            </tr><?php  } ?>
            <?php 
            $denial_report = $CI->modules->get_tool_config('MT-ERC-REPORTS-AMBULANCE-DENIAL-REPORT', 'M-REPORTS', true);
            if($denial_report){
                ?>
            <tr>
                <td>Ambulance Denial report</td>
                <td><a class="onpage_popup btn"  data-href="{base_url}erc_reports/load_erc_report_form" data-qr="output_position=popup_div&report_type=denial_report" data-popupwidth="2500" data-popupheight="800">View</a></td>

            </tr><?php  } ?>
            
                        <?php 
            $indent_oxy_report = $CI->modules->get_tool_config('MT-INDENT-REQUEST-DIS', 'M-REPORTS', true);
            if($indent_oxy_report){
                ?>
            <tr>
           
                <td>Indent Request dispatch and receive Report</td>
                <td><a class="onpage_popup btn"  data-href="{base_url}erc_reports/load_erc_report_form" data-qr="output_position=popup_div&report_type=indent_dispatch_receive_report" data-popupwidth="2500" data-popupheight="800">View</a></td>

            </tr><?php  } ?>
               
            <?php 
            $amb_boi_audit_report = $CI->modules->get_tool_config('MT-AMB-BOI-AUDIT', 'M-REPORTS', true);
            if($amb_boi_audit_report){
                ?>
            <tr>
           
                <td>Ambulance Biomedical Audit report</td>
                <td><a class="onpage_popup btn"  data-href="{base_url}erc_reports/amb_biomedical_audit" data-qr="output_position=popup_div&report_type=amb_biomedical_audit" data-popupwidth="2500" data-popupheight="800">View</a></td>

            </tr><?php  } ?>
                        <?php 
            $amb_boi_audit_summary_report = $CI->modules->get_tool_config('MT-AMB-BOI-AUDIT-SUMMARY', 'M-REPORTS', true);
            if($amb_boi_audit_summary_report){
                ?>
            <tr>
         
                <td>Ambulance Biomedical Audit Summary report</td>
                <td><a class="onpage_popup btn"  data-href="{base_url}erc_reports/load_erc_report_form" data-qr="output_position=popup_div&report_type=amb_boi_audit_summary_report" data-popupwidth="2500" data-popupheight="800">View</a></td>

            </tr><?php  } ?>
             <?php 
            $bpcl_download_report = $CI->modules->get_tool_config('MT-BPCL-REPORT','M-REPORTS', true);
            if($bpcl_download_report){
                ?>
            <tr>
                <td>BPCL Ambulance report</td>
                <td><a class="onpage_popup btn"  data-href="{base_url}erc_reports/load_erc_report_form" data-qr="output_position=popup_div&report_type=bpcl_report" data-popupwidth="2500" data-popupheight="800">View</a></td>
            </tr><?php  } ?>

            <?php 
            $nhm_mis_report = $CI->modules->get_tool_config('MT-MIS-REPORTS', 'M-REPORTS', true);
            if($nhm_mis_report){ ?>
              <tr>
               <td>NHM MIS Report</td>
                <td><a class="onpage_popup btn"  data-href="{base_url}erc_reports/load_erc_report_form" data-qr="output_position=popup_div&report_type=nhm_mis_report" data-popupwidth="2500" data-popupheight="800">View</a></td>
            </tr>
              <?php } ?>


            <?php 
            $amb_case_report = $CI->modules->get_tool_config('MT-ERC-REPORTS-ERCP', 'M-REPORTS', true);
            if($amb_case_report){ ?>
            <tr>
                <td>Ambulance Case Report</td>
                <td><a class="onpage_popup btn"  data-href="{base_url}erc_reports/load_erc_report_form" data-qr="output_position=popup_div&report_type=amb_case_report" data-popupwidth="2500" data-popupheight="800">View</a></td>
            </tr>
                <?php } ?>

              <?php 
            // $all_call_format = $CI->modules->get_tool_config('MT-MIS-REPORTS', 'M-REPORTS', true);
            // if($all_call_format){ ?>
              <!-- <tr>
               <td>All Call Format</td>
                <td><a class="onpage_popup btn"  data-href="{base_url}erc_reports/load_erc_report_form" data-qr="output_position=popup_div&report_type=all_call_report" data-popupwidth="2500" data-popupheight="800">View</a></td>
            </tr> -->
              <?php 
            // } ?>

<!--  -->
            <?php 
            $amb_distance_report = $CI->modules->get_tool_config('MT-ERC-REPORTS-ERCP', 'M-REPORTS', true);
            if($amb_distance_report){ ?>
            <tr>
                <td>Ambulance distance Report</td>
                <td><a class="onpage_popup btn"  data-href="{base_url}erc_reports/load_erc_report_form" data-qr="output_position=popup_div&report_type=amb_distance_report" data-popupwidth="2500" data-popupheight="800">View</a></td>
            </tr>
            <?php } ?>
<!--  -->
              

            <?php
            // $offroad_sum_report = $CI->modules->get_tool_config('MT-ERC-REPORTS-OFFROAD_SUM', 'M-REPORTS', true);
            $offroad_sum_report = $CI->modules->get_tool_config('MT-OFFROAD-SUMMARY-REPORTS', 'M-REPORTS', true);
            if($offroad_sum_report){
            ?>
            <tr>
                <td>Offroad Summary Report</td>
                <td><a class="onpage_popup btn"  data-href="{base_url}erc_reports/load_erc_report_form" data-qr="output_position=popup_div&report_type=Offroad_Sum_Reports" data-popupwidth="2500" data-popupheight="800">View</a></td>
            </tr>
            <?php } 
            ?>
            <?php
            // $offroad_sum_report = $CI->modules->get_tool_config('MT-ERC-REPORTS-OFFROAD_SUM', 'M-REPORTS', true);
            $pending_closure_report = $CI->modules->get_tool_config('MT-ERC-REPORTS-PENDING-CLOSURE', 'M-REPORTS', true);
            if($pending_closure_report){
            ?>
            <tr>
                <td>Pending For Closure Report</td>
                <td><a class="onpage_popup btn"  data-href="{base_url}erc_reports/load_erc_report_form" data-qr="output_position=popup_div&report_type=pending_closure_report" data-popupwidth="2500" data-popupheight="800">View</a></td>
            </tr>
            <?php } 
            ?>

            <?php
            $pending_validation_report = $CI->modules->get_tool_config('MT-ERC-REPORTS-PENDING-VALIDATION', 'M-REPORTS', true);
            if($pending_validation_report){
            ?>
            <tr>
                <td>Pending For Validation Report</td>
                <td><a class="onpage_popup btn"  data-href="{base_url}erc_reports/load_erc_report_form" data-qr="output_position=popup_div&report_type=pending_validation_report" data-popupwidth="2500" data-popupheight="800">View</a></td>
            </tr>
            <?php } 
            ?>

            <?php
            $mdt_login_report = $CI->modules->get_tool_config('MT-ERC-REPORTS-MDT-LOGIN-REPORT', 'M-REPORTS', true);
            if($mdt_login_report){
            ?>
            <tr>
                <td>MDT Login Report</td>
                <td><a class="onpage_popup btn"  data-href="{base_url}erc_reports/load_erc_report_form" data-qr="output_position=popup_div&report_type=mdt_login_report" data-popupwidth="2500" data-popupheight="800">View</a></td>
            </tr>
            <?php } 
            ?>

            <?php
            $responsetime_sum_report = $CI->modules->get_tool_config('MT-REPONSE-TIME-SUMMARY-REPORTS', 'M-REPORTS', true);
            if($responsetime_sum_report){
            ?>
            <tr>
                <td>Response Time Summary Report</td>
                <td><a class="onpage_popup btn"  data-href="{base_url}erc_reports/load_erc_report_form" data-qr="output_position=popup_div&report_type=response_time_Sum_Reports" data-popupwidth="2500" data-popupheight="800">View</a></td>
            </tr>
            <?php } 
            ?>

            <?php
            $all_cases_report = $CI->modules->get_tool_config('MT-ERC-REPORTS-CASES', 'M-REPORTS', true);
            if($all_cases_report){
            ?>
            <tr>
                <td>Assigned Closed and Pending for Closure Report</td>
                <td><a class="onpage_popup btn"  data-href="{base_url}pending_reports/load_erc_report_form" data-qr="output_position=popup_div&report_type=all_cases_report" data-popupwidth="2500" data-popupheight="800">View</a></td>
            </tr>
            <?php } 
            ?>
            <?php
            $offroad_detail_report = $CI->modules->get_tool_config('MT-OFFROAD-DETAIL-REPORTS', 'M-REPORTS', true);
            if($offroad_detail_report){
            ?>
            <tr>
                <td>Off Road Detail Report</td>
                <td><a class="onpage_popup btn"  data-href="{base_url}report_data/load_report_form" data-qr="output_position=popup_div&report_type=Offroad_Detail_Reports" data-popupwidth="2500" data-popupheight="800">View</a></td>
            </tr>
            <?php } 
            ?>
            <?php
            $dmdclogin = $CI->modules->get_tool_config('MT-DM-DC-LOGIN-REPORTS', 'M-REPORTS', true);
            // $dmdclogin = $CI->modules->get_tool_config('MT-ERC-REPORTS-INCIDENT', 'M-REPORTS', true);
            if($dmdclogin){
            ?>
            <tr>
                <td>DM/DC Login Report</td>
                <td><a class="onpage_popup btn"  data-href="{base_url}report_data/load_report_form" data-qr="output_position=popup_div&report_type=DM_DC_Login_Report" data-popupwidth="2500" data-popupheight="800">View</a></td>
            </tr>
            <?php } 
            ?>
            <?php $dispatch_closure_summary = $CI->modules->get_tool_config('MT-ERC-REPORTS-DETAIL-DISPATCH-CLOSURE-REPORT', 'M-REPORTS', true);
              if($dispatch_closure_summary){ ?>
              <tr>
                  <td>Dispatch / Closure Suammary Report </td>
                  <td><a class="onpage_popup btn"  data-href="{base_url}erc_reports/load_erc_report_form" data-qr="output_position=popup_div&report_type=dispatch_closure_summary" data-popupwidth="2500" data-popupheight="800">View</a></td>
              </tr>
            <?php } ?>
            <?php $gps_report = $CI->modules->get_tool_config('MT-GPS-REPORT', 'M-REPORTS', true);
              if($gps_report){ ?>
              <tr>
                  <td>MDT Odometer Report</td>
                  <td><a class="onpage_popup btn"  data-href="{base_url}erc_reports/load_erc_report_form" data-qr="output_position=popup_div&report_type=gps_report" data-popupwidth="2500" data-popupheight="800">View</a></td>
              </tr>
            <?php } ?>
            <?php $gps_report = $CI->modules->get_tool_config('MT-ERC-INS-AUDIT-REPORTS', 'M-REPORTS', true);
              if($gps_report){ ?>
              <tr>
                  <td>Inspection Audit Report</td>
                  <td><a class="onpage_popup btn"  data-href="{base_url}erc_reports/load_erc_report_form" data-qr="output_position=popup_div&report_type=ins_audit_report" data-popupwidth="2500" data-popupheight="800">View</a></td>
              </tr>
            <?php } ?>
            <?php $amb_distance_travel_report = $CI->modules->get_tool_config('MT-ERC-AMB-DISTANCE-REPORT', 'M-REPORTS', true);
              if($amb_distance_travel_report){ ?>
              <tr>
                  <td>Ambulance Distance Travel Report</td>
                  <td><a class="onpage_popup btn"  data-href="{base_url}erc_reports/load_erc_report_form" data-qr="output_position=popup_div&report_type=amb_distance_travel_report" data-popupwidth="2500" data-popupheight="800">View</a></td>
              </tr>
            <?php } ?>
        </table>
    </div>
</form>
</div>