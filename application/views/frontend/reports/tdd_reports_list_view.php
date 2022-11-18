<?php $CI = EMS_Controller::get_instance();?>

<div class="width100">
   <h2>Reports</h2><br>
    <form enctype="multipart/form-data"  action="<?php echo base_url(); ?>tdd_reports/<?php echo $submit_function;?>" method="post">
        
        <div class="width_25">

            <div class="filed_select">
                <div class="field_row drg float_left">
                    <div class="width100 float_left">
                        <div class="style6 float_left">Select Report: </div>
                    </div>
                    <div class="width100 float_left">  
                        <select name="report_type" class="change-base-xhttp-request" data-base="report_type" data-href="{base_url}tdd_reports/load_report_form" data-qr="output_position=content">
                            <option value="">Select Report</option>
                            <option value="monthly_screening_report">Monthly Screening Report</option>
                            <option value="ambulance_distance_Reports">District wise Distance Covered by Ambulance Report</option>  
                            <option value="Patient_Reports">Patient Reports</option>
                            <option value="ambulance_equipment_report">Ambulance Equipment Report</option>
                            <option value="sickroom_equipment_report">Sick Room Equipment Report</option>
                            <option value="Incident_Reports">Emergency Call Details</option>
                            <option value="amb_onroad_offroad_report">Ambulance On-road / Off-road data Report</option>
                            <option value="ambulance_stock_report">Ambulance Stock Report</option>
                            <option value="sickroom_stock_report">Sick Room Stock Report</option>
                            
                        </select>
                    </div>
                </div>
            </div>

        </div>
        <div class="width75 float_left">
            <div id="report_block_fields" style="">
            </div>
        </div>

    </form>
</div>
<div class="box3">    
    
    <div class="permission_list group_list">
            
        <div id="list_table" style="width:100%; overflow-x: scroll;">
            

        </div>
    </div>
</div>