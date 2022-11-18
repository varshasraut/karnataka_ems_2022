<?php $CI = EMS_Controller::get_instance();?>

<div class="width100">
   <h2>Reports</h2><br>
<!--    <form enctype="multipart/form-data"  action="<?php echo base_url(); ?>reports/<?php echo $submit_function;?>" method="post">
        
        <div class="width_25">

            <div class="filed_select">
                <div class="field_row drg float_left">
                    <div class="width100 float_left">
                        <div class="style6 float_left">Select Report: </div>
                    </div>
                    <div class="width100 float_left">  
                        <select name="report_type" class="change-base-xhttp-request" data-base="report_type" data-href="{base_url}reports/load_report_form" data-qr="output_position=content">
                            <option value="">Select Report</option>
                            <option value="Incident_Reports">Incident Reports</option>
                            <option value="Patient_Reports">Patient Reports</option>
                            <option value="Patient_Transport_Reports">Annex E-1 Patient Transport Reports</option>
                            <option value="monthly_distance_Reports">Annex E-2 Distance Travelled Report</option>
                            <option value="ambulance_distance_Reports">District wise Distance Covered by Ambulance Report</option>
                            <option value="district_distance">Annex E-3 District Wise Distance Covered by Ambulance</option>
                            <option value="employee_report">Employee Reports</option>
                            <option value="epcr_report">E-PCR Reports</option>
                            <option value="incident_daily_hourly_report">Hourly Daily Hourly Report</option>
                            <option value="amb_onroad_offroad_report">Ambulance On-road / Off road data Report</option>
                            <option value="b12_type_report">B12 type report</option>
                            <option value="monthly_screening_report">Monthly Screening Report</option>
                            <option value="ambulance_stock_report">Ambulance Stock Report</option>
                            <option value="annex_biii_patient_details">Annexure B-III Patient Details </option>
                        </select>
                    </div>
                </div>
            </div>

        </div>
        <div class="width75 float_left">
            <div id="report_block_fields" style="">
            </div>
        </div>

    </form>-->
<!--</div>
<div class="box3">    
    
    <div class="permission_list group_list">
            
        <div id="list_table" style="width:100%; overflow-x: scroll;">
            

            </div>
    </div>
</div>-->

<form enctype="multipart/form-data"  method="post">
    <div class="NHM_report_tables">
        <table class="report_table">
            <tr>   
                <th>Sr No</th>
                <th>Report</th>
                <th>Action</th>
            </tr>
            <tr>
                <td>1</td>
                <td>Incident Reports</td>
                <td><a class="onpage_popup btn"  data-href="{base_url}reports/load_report_form" data-qr="output_position=popup_div&report_type=Incident_Reports" data-popupwidth="1000" data-popupheight="500">View</a></td>

            </tr>
            <tr>
                <td >2</td>
                <td>Patient Reports</td>
                <td><a class="onpage_popup btn"  data-href="{base_url}reports/load_report_form" data-qr="output_position=popup_div&report_type=Patient_Reports" data-popupwidth="1000" data-popupheight="500">View</a></td>
            </tr>
            <tr>
                <td>3</td>
                <td>Annex E-1 Patient Transport Reports</td>
                <td><a class="onpage_popup btn"  data-href="{base_url}reports/load_report_form" data-qr="output_position=popup_div&report_type=Patient_Transport_Reports" data-popupwidth="1000" data-popupheight="500">View</a></td>

            </tr>
            <tr>
                <td>4</td>
                <td>Annex E-2 Distance Travelled Report</td>
                <td><a class="onpage_popup btn"  data-href="{base_url}reports/load_report_form" data-qr="output_position=popup_div&report_type=monthly_distance_Reports" data-popupwidth="1000" data-popupheight="500">View</a></td>
            </tr>
            <tr>
                <td>5</td>
                <td>District wise Distance Covered by Ambulance Report</td>
                <td><a class="onpage_popup btn"  data-href="{base_url}reports/load_report_form" data-qr="output_position=popup_div&report_type=ambulance_distance_Reports" data-popupwidth="1000" data-popupheight="500">View</a></td>
            </tr>

            <tr>
                <td>6</td>
                <td>Annex E-3 District Wise Distance Covered by Ambulance </td>
                <td><a class="onpage_popup btn"  data-href="{base_url}reports/load_report_form" data-qr="output_position=popup_div&report_type=district_distance" data-popupwidth="1000" data-popupheight="500">View</a></td>
            </tr>
            <tr>
                <td>7</td>
                <td>Employee Reports</td>
                <td><a class="onpage_popup btn"  data-href="{base_url}reports/load_report_form" data-qr="output_position=popup_div&report_type=employee_report" data-popupwidth="1000" data-popupheight="500">View</a></td>
            </tr>
            <tr>
                <td>8</td>
                <td>E-PCR Reports</td>
                <td><a class="onpage_popup btn"  data-href="{base_url}reports/load_report_form" data-qr="output_position=popup_div&report_type=epcr_report" data-popupwidth="1000" data-popupheight="500">View</a></td>
            </tr>
            <tr>
                <td>9</td>
                <td>Hourly Daily Hourly Report</td>
                <td><a class="onpage_popup btn"  data-href="{base_url}reports/load_report_form" data-qr="output_position=popup_div&report_type=incident_daily_hourly_report" data-popupwidth="1000" data-popupheight="500">View</a></td>
            </tr>
               <tr>
                <td>10</td>
                <td>Ambulance On-road / Off road data Report</td>
                <td><a class="onpage_popup btn"  data-href="{base_url}reports/load_report_form" data-qr="output_position=popup_div&report_type=amb_onroad_offroad_report" data-popupwidth="1000" data-popupheight="500">View</a></td>
            </tr>
             <tr>
                <td>11</td>
                <td>B12 type report</td>
                <td><a class="onpage_popup btn"  data-href="{base_url}reports/load_report_form" data-qr="output_position=popup_div&report_type=b12_type_report" data-popupwidth="1000" data-popupheight="500">View</a></td>
            </tr>
             <tr>
                <td>11</td>
                <td>Ambulance Stock Report</td>
                <td><a class="onpage_popup btn"  data-href="{base_url}reports/load_report_form" data-qr="output_position=popup_div&report_type=ambulance_stock_report" data-popupwidth="1000" data-popupheight="500">View</a></td>
            </tr>
              <tr>
                <td>12</td>
                <td>Annexure B-III Patient Details</td>
                <td><a class="onpage_popup btn"  data-href="{base_url}reports/load_report_form" data-qr="output_position=popup_div&report_type=annex_biii_patient_details" data-popupwidth="1000" data-popupheight="500">View</a></td>
            </tr>
        </table>
    </div>
</form>