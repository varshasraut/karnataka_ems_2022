<?php $CI = EMS_Controller::get_instance(); ?>
<div class="head_outer"><h3 class="txt_clr2 width1"><?php echo $title;?> </h3> </div>
<div class="width100">
    <div class="filed_select">
        <div class="field_row drg float_left">
            <div class="width100 float_left">
                <div class="style6 float_left">Select Report Type: </div>
            </div>
            <div class="width100 float_left">  
                <select name="report_type" class="change-base-xhttp-request" data-base="report_type" data-href="{base_url}erc_reports/load_shift_roster_sub_option_report_form" data-qr="output_position=content">
                    <option value="">Select Report</option>
                    <option value="1">Datewise </option>
<!--                    <option value="2">Monthwise</option>-->
                    <option value="3">Daily</option>
                </select>
            </div>
        </div>
    </div>
    
</div>
<div class="width70 float_left">
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