<?php $CI = EMS_Controller::get_instance(); ?>
<div class="head_outer"><h3 class="txt_clr2 width1"><?php echo $title;?> </h3> </div>
<input type="hidden" value="<?php echo $report_type_new; ?>" name="report_type_new">
<div class="width30">
    <div class="filed_select">
        <div class="field_row drg float_left">
            <div class="width100 float_left">
                <div class="style6 float_left">Select Report Type: </div>
            </div>
            <div class="width100 float_left">  
                <select name="report_type_new" class="change-base-xhttp-request" data-base="report_type" data-href="{base_url}erc_reports/load_patient_served_sub_option_report_form_new" data-qr="output_position=content">
                    <option value="">Select Report</option>
                    <option value="1">Patient Served Count</option>
                    <option value="2">Ambulance Assign Patient</option>
                    
                </select>
            </div>
        </div>
    </div>
    
</div>

<div class="width30 float_left">
        <div id="report_block_fields" >
        </div>
</div>
<div class="width40 float_left">
        <div id="Sub_date_report_block_fields" >
        </div>
</div>
  
<div class="box3">    

    <div class="permission_list group_list">

        <div class="width100 float_left" id="list_table" >


        </div>
    </div>
</div>

<iframe name="form_frame" style="height: 1px; width: 1px; border:0px; background: none;"></iframe>