<?php $CI = EMS_Controller::get_instance(); ?>

<div class="width100">
    <h2>NHM Reports</h2><br>
<!--    <form enctype="multipart/form-data"  action="<?php echo base_url(); ?>reports/<?php echo $submit_function; ?>" method="post">

        <div class="width_25">

            <div class="filed_select">
                <div class="field_row drg float_left">
                    <div class="width100 float_left">
                        <div class="style6 float_left">Select NHM Report: </div>
                    </div>
                    <div class="width100 float_left">  
                        <select name="report_type" class="change-base-xhttp-request" data-base="report_type" data-href="{base_url}reports/load_NHM_report_form" data-qr="output_position=content">
                            <option value="">Select Report</option>
                            <option value="1">1. Annex B-III Patient Details - Bike</option>
                            <option value="2">2. Annexure A -II -bike</option>
                            <option value="3">3. Annexure A-I - bike</option>
                            <option value="4">4. Annexure B-I Distance Running Statement bike</option>
                            <option value="5">5. Annexure B-II-A (Emergency Call Details) -bike</option>
                            <option value="6">6. Annexure B-II-B (Non-Emergency)_ -bike</option>
                            <option value="7">7. Annexure B-V Ambulance staff performance Report's  - bike</option>
                            <option value="8">8. Annexure B-VII Vehicle Status Info Report -bike</option>
                            <option value="9">9. Summeray Report</option>
                        </select>
                    </div>
                </div>
            </div>

        </div>
        <div class="width69 float_left">
            <div id="report_block_fields" style="">
            </div>
        </div>

    </form>-->
</div>
<!--<div class="box3">    

    <div class="permission_list group_list">

        <div id="list_table" style="width:100%; overflow-x: scroll;">


        </div>
    </div>
</div>-->
<style>
td, th {
  border: 1px solid #dddddd;
  text-align: left;
  padding: 8px;
}
</style>
<form enctype="multipart/form-data"  method="post">
    <div class="NHM_report_tables">
        <table>
            <tr>   
                <th>Sr No</th>
                <th>Report</th>
                <th>Action</th>
            </tr>
            <?php 
            $patient_report = $CI->modules->get_tool_config('MT-NHM-REPORTS-PATIENT-DETAILS', 'M-REPORTS', true);
            if($patient_report){?>
            <tr>
                <td>1</td>
                <td>Annex B-III Patient Details</td>
                <td><a class="onpage_popup btn"  data-href="{base_url}reports/load_NHM_report_form" data-qr="output_position=popup_div&report_type=1" data-popupwidth="1200" data-popupheight="800">View</a></td>

            </tr>
             <?php }
             $annexure_2_report = $CI->modules->get_tool_config('MT-NHM-REPORTS-ANNEXURE-AII', 'M-REPORTS', true);
            if($annexure_2_report){
            ?>
            <tr>
                <td >2</td>
                <td>Annexure A -II</td>
                <td><a class="onpage_popup btn"  data-href="{base_url}reports/load_NHM_report_form" data-qr="output_position=popup_div&report_type=2" data-popupwidth="1200" data-popupheight="800">View</a></td>
            </tr>
            <?php }
             $annexure_3_report = $CI->modules->get_tool_config('MT-NHM-REPORTS-ANNEXURE-AI', 'M-REPORTS', true);
            if($annexure_3_report){
            ?>
            <tr>
                <td>3</td>
                <td>Annexure A-I</td>
                <td><a class="onpage_popup btn"  data-href="{base_url}reports/load_NHM_report_form" data-qr="output_position=popup_div&report_type=3" data-popupwidth="1200" data-popupheight="800">View</a></td>

            </tr>
             <?php }
             $annexure_4_report = $CI->modules->get_tool_config('MT-NHM-REPORTS-DISTANCE-RUNNING-STATEMENT-BI', 'M-REPORTS', true);
            if($annexure_4_report){
            ?>
            <tr>
                <td>4</td>
                <td>Annexure B-I Distance Running Statement</td>
                <td><a class="onpage_popup btn"  data-href="{base_url}reports/load_NHM_report_form" data-qr="output_position=popup_div&report_type=4" data-popupwidth="1200" data-popupheight="800">View</a></td>
            </tr>
            <?php }
             $annexure_5_report = $CI->modules->get_tool_config('MT-NHM-REPORTS-BII-EMERGENCY-CALL', 'M-REPORTS', true);
            if($annexure_5_report){
            ?>
            <tr>
                <td>5</td>
                <td>Annexure B-II-A (Emergency Call Details)</td>
                <td><a class="onpage_popup btn"  data-href="{base_url}reports/load_NHM_report_form" data-qr="output_position=popup_div&report_type=5" data-popupwidth="1200" data-popupheight="800">View</a></td>
            </tr>
 <?php }
             $annexure_6_report = $CI->modules->get_tool_config('MT-NHM-REPORTS-BII-NON-EMERGENCY-CALL', 'M-REPORTS', true);
            if($annexure_6_report){
            ?>
            <tr>
                <td>6</td>
                <td>Annexure B-II-B (Non-Emergency)</td>
                <td><a class="onpage_popup btn"  data-href="{base_url}reports/load_NHM_report_form" data-qr="output_position=popup_div&report_type=6" data-popupwidth="1200" data-popupheight="800">View</a></td>
            </tr>
             <?php }
             $annexure_7_report = $CI->modules->get_tool_config('MT-NHM-REPORTS-AMBULANCE-STAFF-PERFORMANCE', 'M-REPORTS', true);
            if($annexure_7_report){
            ?>
            <tr>
                <td>7</td>
                <td>Annexure B-V Ambulance staff performance Report's</td>
                <td><a class="onpage_popup btn"  data-href="{base_url}reports/load_NHM_report_form" data-qr="output_position=popup_div&report_type=7" data-popupwidth="1200" data-popupheight="800">View</a></td>
            </tr>
             <?php }
             $annexure_8_report = $CI->modules->get_tool_config('MT-NHM-REPORTS-VEHICAL-STATUS', 'M-REPORTS', true);
            if($annexure_8_report){
            ?>
            <tr>
                <td>8</td>
                <td>Annexure B-VII Vehicle Status Info Report</td>
                <td><a class="onpage_popup btn"  data-href="{base_url}reports/load_NHM_report_form" data-qr="output_position=popup_div&report_type=8" data-popupwidth="1200" data-popupheight="800">View</a></td>
            </tr>
              <?php }
             $annexure_9_report = $CI->modules->get_tool_config('MT-NHM-REPORTS-SUMMERY-REPORT', 'M-REPORTS', true);
            if($annexure_9_report){
            ?>
            <tr>
                <td>9</td>
                <td>Summary Report</td>
                <td><a class="onpage_popup btn"  data-href="{base_url}reports/load_NHM_report_form" data-qr="output_position=popup_div&report_type=9" data-popupwidth="1200" data-popupheight="800">View</a></td>
            </tr>
             <?php }
             $annexure_10_report = $CI->modules->get_tool_config('MT-NHM-REPORTS-DISTRICTWISE-PATIENT-SERVED', 'M-REPORTS', true);
            if($annexure_10_report){
            ?>
            <tr>
                <td>10</td>
                <td>District wise Emergency Patient Served</td>
                <td><a class="onpage_popup btn"  data-href="{base_url}erc_reports/load_erc_report_form" data-qr="output_position=popup_div&report_type=district_wise_patient_served" data-popupwidth="2500" data-popupheight="800">View</a></td>
            </tr>
            <?php }
             $annexure_11_report = $CI->modules->get_tool_config('MT-NHM-REPORTS-RESPONSE-TIME', 'M-REPORTS', true);
            if($annexure_11_report){
            ?>
            <tr>
                <td>11</td>
                <td>Response time report</td>
                <td><a class="onpage_popup btn"  data-href="{base_url}reports/response_time_report" data-qr="output_position=popup_div&report_type=district_wise_patient_served" data-popupwidth="2500" data-popupheight="800">View</a></td>
            </tr>
            <?php } ?>
                        <tr>
                <td>12</td>
                <td>D - III Vehicle Status Information report For Ambulance</td>
                <td><a class="onpage_popup btn"  data-href="{base_url}reports/load_NHM_report_form" data-qr="output_position=popup_div&report_type=vahicle_status_report" data-popupwidth="2500" data-popupheight="800">View</a></td>
            </tr>
              <tr>
                <td>13</td>
                <td>C - II ERC Staff, EMT & EA attendacne</td>
                <td><a class="onpage_popup btn"  data-href="{base_url}reports/load_NHM_report_form" data-qr="output_position=popup_div&report_type=erc_staff" data-popupwidth="2500" data-popupheight="800">View</a></td>
            </tr>
            <!--<tr>
                <td>14</td>
                <td>NHM Report</td>
                <td><a class="onpage_popup btn"  data-href="{base_url}reports/load_nhm_report" data-qr="output_position=popup_div&report_type=erc_staff" data-popupwidth="2500" data-popupheight="800">View</a></td>
            </tr>-->
        </table>
    </div>
</form>