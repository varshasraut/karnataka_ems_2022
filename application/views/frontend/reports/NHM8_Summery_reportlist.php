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
                        <select name="report_type" class="change-base-xhttp-request" data-base="report_type" data-href="{base_url}reports/load_NHM8_summeryreport" data-qr="output_position=content">
                            <option value="">Select Report</option>
                            <option value="1">1. C - I Distance travelled by Bike Ambulance </option>
                            <option value="2">2. C - II Bike Ambulance EMT </option>
                            <option value="3">3. C- III Utilization of Bike Ambulances </option>
                            <option value="4">4. D-I Bike Ambulance Response time - Golden Hour</option>
							<option value="5">4. D - II calls details</option>
							<option value="6">D - III Vehicle Status Information report For Bike Ambulance</option>
							<option value="7">( E )  Formats for Performance Appraisal</option>
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

