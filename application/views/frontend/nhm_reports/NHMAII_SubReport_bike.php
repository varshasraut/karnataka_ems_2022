<?php $CI = EMS_Controller::get_instance();?>
<div class="head_outer">
    <h3 class="txt_clr2 width1"><?php echo $report_name;?></h3> 
</div>
<div class="width100">

    <form enctype="multipart/form-data"  action="<?php echo base_url(); ?>reports/<?php echo $submit_function;?>" method="post">
        
        <div class="width_25">

            <div class="filed_select">
                <div class="field_row drg float_left">
                    <div class="width100 float_left">
                        <div class="style6 float_left">Select NHM Report: </div>
                    </div>
                    <div class="width100 float_left">  
                        <select name="report_type" class="change-base-xhttp-request" data-base="report_type" data-href="{base_url}reports/load_NHMAll_subreport_form" data-qr="output_position=content">
                            <option value="">Select Report</option>
                            <option value="1">1. Stock position of Medicines & Consumables for the Month </option>
                            <option value="2">2. Vehicle wise Inventory Consumption and Replenishment Report </option>
                            <option value="3">3. 10 Vehicles  Detailed Inventory Consumption and Replenishment Report  </option>
                            <option value="4">4. Vehicles List </option>
                        </select>
                    </div>
                </div>
            </div>

        </div>
        <div class="width69 float_left">
            <div id="Sub_report_block_fields" style="">
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

<iframe name="form_frame" style="height: 1px; width: 1px; border:0px; background: none;"></iframe>