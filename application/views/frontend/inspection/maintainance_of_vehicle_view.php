<div class="field_row width100">
    <div class="width2 float_left">
        <div class="field_lable float_left width33"> <label for="mt_estimatecost">Date Of Maintenance<span class="md_field"></span></label></div>
        <div class="filed_input float_left width50" >
        <input type="text" name="app[mt_app_onroad_datetime]"  value=" <?php if($preventive[0]->mt_onroad_datetime != '0000-00-00 00:00:00' && $preventive[0]->mt_onroad_datetime != ''){ echo $preventive[0]->mt_onroad_datetime;}?>" class="filter_required OnroadDate" placeholder="On-Road Date/Time" data-errors="{filter_required:'On-Road Date/Time should not be blank'}" TABINDEX="8" <?php if($preventive[0]->mt_onroad_datetime != '0000-00-00 00:00:00' && $preventive[0]->mt_onroad_datetime != ''){ echo "disabled";}?> id="mt_onroad_datetime">
        </div>
    </div>
    <div class="width2 float_left">
        <div class="field_lable float_left width33"><label for="work_shop">Maintenance done on due date or not<span class="md_field">*</span></label></div>
        <div class="filed_input float_left width50" id="amb_base_location">
            <input name="maintace_of_amb" tabindex="23" class="form_input filter_required mi_autocomplete" placeholder="Select Maintenance" type="text" data-base="search_btn" data-errors="{filter_required:'Maintaince should not be blank!'}" data-value="<?= @$preventive[0]->mt_base_loc; ?>" value="<?= @$preventive[0]->mt_base_loc; ?>" readonly="readonly"   <?php echo $update; echo $approve; echo $rerequest; ?>  data-callback-funct="load_inspection_ambulance_main_type" data-href="<?php echo base_url();?>auto/get_maintainance_amb">
        </div>
    </div>
</div><br>
<div class="field_row width100">
    <div class="width2 float_left">
        <div class="field_lable float_left width33"> <label for="mt_estimatecost">Present Status<span class="md_field"></span></label></div>
        <div class="filed_input float_left width50" >
        <select name="accidental[mt_insurance]" tabindex="8" class="" data-errors="{filter_required:'Current Status should not be blank!'}"  <?php echo $update; echo $approve; echo $rerequest;?>> 
            <option value="">Select Option</option>
            <option value="Valid" <?php if($preventive[0]->mt_insurance == 'Valid'){ echo "selected"; } ?>>Maintenance Completed</option>
            <option value="In-Valid" <?php if($preventive[0]->mt_insurance == 'In-Valid'){ echo "selected"; } ?>>Maintenance In-Progress</option>
            <option value="In-Valid" <?php if($preventive[0]->mt_insurance == 'In-Valid'){ echo "selected"; } ?>>Maintenance Pending</option>                    
                                    
        </select>
        </div>
    </div>
    <div class="width2 float_left">
        <div class="field_lable float_left width33"><label for="work_shop">Remark<span class="md_field">*</span></label></div>
        <div class="filed_input float_left width50" id="amb_base_location">
        <input name="repair_Estimatecost" tabindex="23" class="form_input filter_if_not_blank filter_maxlength[8] filter_number" placeholder="Enter Odometer" type="text"  data-errors="{filter_required:'Estimate cost should not be blank!',filter_maxlength:'Amount at max 7 digit long',filter_number:'Enter only number only.'}" value="<?= @$preventive[0]->mt_repair_Estimatecost; ?>"    <?php echo $update; echo $approve; echo $rerequest;?>>
        </div>
    </div>
</div><br>
<div class="field_row width100">
<h3>Medicine Status</h3>
</div>
<div class="field_row width100">
<div class="width2 float_left">
        <div class="field_lable float_left width33"> <label for="mt_estimatecost">Medicine1<span class="md_field"></span></label></div>
        <div class="filed_input float_left width50" >
        <select name="accidental[mt_insurance]" tabindex="8" class="" data-errors="{filter_required:'Current Status should not be blank!'}"  <?php echo $update; echo $approve; echo $rerequest;?>> 
            <option value="">Select Option</option>
            <option value="Valid" <?php if($preventive[0]->mt_insurance == 'Valid'){ echo "selected"; } ?>>Yes</option>
            <option value="In-Valid" <?php if($preventive[0]->mt_insurance == 'In-Valid'){ echo "selected"; } ?>>No</option>
        </select>
        </div>
</div>
<div class="width2 float_left">
        <div class="field_lable float_left width33"><label for="work_shop">Remark<span class="md_field">*</span></label></div>
        <div class="filed_input float_left width50" id="amb_base_location">
        <input name="repair_Estimatecost" tabindex="23" class="form_input filter_if_not_blank filter_maxlength[8] filter_number" placeholder="Enter Odometer" type="text"  data-errors="{filter_required:'Estimate cost should not be blank!',filter_maxlength:'Amount at max 7 digit long',filter_number:'Enter only number only.'}" value="<?= @$preventive[0]->mt_repair_Estimatecost; ?>"    <?php echo $update; echo $approve; echo $rerequest;?>>
        </div>
    </div>
</div>
<div class="field_row width100">
<div class="width2 float_left">
        <div class="field_lable float_left width33"> <label for="mt_estimatecost">Medicine2<span class="md_field"></span></label></div>
        <div class="filed_input float_left width50" >
        <select name="accidental[mt_insurance]" tabindex="8" class="" data-errors="{filter_required:'Current Status should not be blank!'}"  <?php echo $update; echo $approve; echo $rerequest;?>> 
            <option value="">Select Option</option>
            <option value="Valid" <?php if($preventive[0]->mt_insurance == 'Valid'){ echo "selected"; } ?>>Yes</option>
            <option value="In-Valid" <?php if($preventive[0]->mt_insurance == 'In-Valid'){ echo "selected"; } ?>>No</option>
        </select>
        </div>
</div>
<div class="width2 float_left">
        <div class="field_lable float_left width33"><label for="work_shop">Remark<span class="md_field">*</span></label></div>
        <div class="filed_input float_left width50" id="amb_base_location">
        <input name="repair_Estimatecost" tabindex="23" class="form_input filter_if_not_blank filter_maxlength[8] filter_number" placeholder="Enter Odometer" type="text"  data-errors="{filter_required:'Estimate cost should not be blank!',filter_maxlength:'Amount at max 7 digit long',filter_number:'Enter only number only.'}" value="<?= @$preventive[0]->mt_repair_Estimatecost; ?>"    <?php echo $update; echo $approve; echo $rerequest;?>>
        </div>
    </div>
</div>
<div class="field_row width100">
<h3>Equipment Status</h3>

</div>
<div class="field_row width100">
<div class="width2 float_left">
        <div class="field_lable float_left width33"> <label for="mt_estimatecost">Equipment1<span class="md_field"></span></label></div>
        <div class="filed_input float_left width50" >
        <select name="accidental[mt_insurance]" tabindex="8" class="" data-errors="{filter_required:'Current Status should not be blank!'}"  <?php echo $update; echo $approve; echo $rerequest;?>> 
            <option value="">Select Option</option>
            <option value="Valid" <?php if($preventive[0]->mt_insurance == 'Valid'){ echo "selected"; } ?>>Available</option>
            <option value="In-Valid" <?php if($preventive[0]->mt_insurance == 'In-Valid'){ echo "selected"; } ?>>Not Available</option>
        </select>
        </div>
</div>
<div class="width2 float_left">
        <div class="field_lable float_left width33"><label for="work_shop">Operation<span class="md_field">*</span></label></div>
        <div class="filed_input float_left width50" id="amb_base_location">
        <select name="accidental[mt_insurance]" tabindex="8" class="" data-errors="{filter_required:'Current Status should not be blank!'}"  <?php echo $update; echo $approve; echo $rerequest;?>> 
            <option value="">Select Option</option>
            <option value="Valid" <?php if($preventive[0]->mt_insurance == 'Valid'){ echo "selected"; } ?>>Functional</option>
            <option value="In-Valid" <?php if($preventive[0]->mt_insurance == 'In-Valid'){ echo "selected"; } ?>>Non Functional</option>
        </select>
        </div>
    </div>
    <div class="width2 float_left">
        <div class="field_lable float_left width33"><label for="work_shop">Remark<span class="md_field">*</span></label></div>
        <div class="filed_input float_left width50" id="amb_base_location">
        <input name="repair_Estimatecost" tabindex="23" class="form_input filter_if_not_blank filter_maxlength[8] filter_number" placeholder="Enter Odometer" type="text"  data-errors="{filter_required:'Estimate cost should not be blank!',filter_maxlength:'Amount at max 7 digit long',filter_number:'Enter only number only.'}" value="<?= @$preventive[0]->mt_repair_Estimatecost; ?>"    <?php echo $update; echo $approve; echo $rerequest;?>>
        </div>
    </div>
</div>
<div class="field_row width100">
<div class="width2 float_left">
        <div class="field_lable float_left width33"> <label for="mt_estimatecost">Equipment2<span class="md_field"></span></label></div>
        <div class="filed_input float_left width50" >
        <select name="accidental[mt_insurance]" tabindex="8" class="" data-errors="{filter_required:'Current Status should not be blank!'}"  <?php echo $update; echo $approve; echo $rerequest;?>> 
            <option value="">Select Option</option>
            <option value="Valid" <?php if($preventive[0]->mt_insurance == 'Valid'){ echo "selected"; } ?>>Available</option>
            <option value="In-Valid" <?php if($preventive[0]->mt_insurance == 'In-Valid'){ echo "selected"; } ?>>Not Available</option>
        </select>
        </div>
</div>
<div class="width2 float_left">
        <div class="field_lable float_left width33"><label for="work_shop">Operation<span class="md_field">*</span></label></div>
        <div class="filed_input float_left width50" id="amb_base_location">
        <select name="accidental[mt_insurance]" tabindex="8" class="" data-errors="{filter_required:'Current Status should not be blank!'}"  <?php echo $update; echo $approve; echo $rerequest;?>> 
            <option value="">Select Option</option>
            <option value="Valid" <?php if($preventive[0]->mt_insurance == 'Valid'){ echo "selected"; } ?>>Functional</option>
            <option value="In-Valid" <?php if($preventive[0]->mt_insurance == 'In-Valid'){ echo "selected"; } ?>>Non Functional</option>
        </select>
        </div>
    </div>
    <div class="width2 float_left">
        <div class="field_lable float_left width33"><label for="work_shop">Remark<span class="md_field">*</span></label></div>
        <div class="filed_input float_left width50" id="amb_base_location">
        <input name="repair_Estimatecost" tabindex="23" class="form_input filter_if_not_blank filter_maxlength[8] filter_number" placeholder="Enter Odometer" type="text"  data-errors="{filter_required:'Estimate cost should not be blank!',filter_maxlength:'Amount at max 7 digit long',filter_number:'Enter only number only.'}" value="<?= @$preventive[0]->mt_repair_Estimatecost; ?>"    <?php echo $update; echo $approve; echo $rerequest;?>>
        </div>
    </div>
</div>
<div class="field_row width100">
<div class="width2 float_left">
        <div class="field_lable float_left width33"> <label for="mt_estimatecost">Equipment3<span class="md_field"></span></label></div>
        <div class="filed_input float_left width50" >
        <select name="accidental[mt_insurance]" tabindex="8" class="" data-errors="{filter_required:'Current Status should not be blank!'}"  <?php echo $update; echo $approve; echo $rerequest;?>> 
            <option value="">Select Option</option>
            <option value="Valid" <?php if($preventive[0]->mt_insurance == 'Valid'){ echo "selected"; } ?>>Available</option>
            <option value="In-Valid" <?php if($preventive[0]->mt_insurance == 'In-Valid'){ echo "selected"; } ?>>Not Available</option>
        </select>
        </div>
</div>
<div class="width2 float_left">
        <div class="field_lable float_left width33"><label for="work_shop">Operation<span class="md_field">*</span></label></div>
        <div class="filed_input float_left width50" id="amb_base_location">
        <select name="accidental[mt_insurance]" tabindex="8" class="" data-errors="{filter_required:'Current Status should not be blank!'}"  <?php echo $update; echo $approve; echo $rerequest;?>> 
            <option value="">Select Option</option>
            <option value="Valid" <?php if($preventive[0]->mt_insurance == 'Valid'){ echo "selected"; } ?>>Functional</option>
            <option value="In-Valid" <?php if($preventive[0]->mt_insurance == 'In-Valid'){ echo "selected"; } ?>>Non Functional</option>
        </select>
        </div>
    </div>
    <div class="width2 float_left">
        <div class="field_lable float_left width33"><label for="work_shop">Remark<span class="md_field">*</span></label></div>
        <div class="filed_input float_left width50" id="amb_base_location">
        <input name="repair_Estimatecost" tabindex="23" class="form_input filter_if_not_blank filter_maxlength[8] filter_number" placeholder="Enter Odometer" type="text"  data-errors="{filter_required:'Estimate cost should not be blank!',filter_maxlength:'Amount at max 7 digit long',filter_number:'Enter only number only.'}" value="<?= @$preventive[0]->mt_repair_Estimatecost; ?>"    <?php echo $update; echo $approve; echo $rerequest;?>>
        </div>
    </div>
</div>
<div class="field_row width100">
<div class="width2 float_left">
        <div class="field_lable float_left width33"> <label for="mt_estimatecost">Equipment3<span class="md_field"></span></label></div>
        <div class="filed_input float_left width50" >
        <textarea></textarea>
        </div>
</div>
</div>
<div class="field_row width100">
<h3>Grievance</h3>
</div>
<script>

    
    jQuery(document).ready(function () {
    var jsDate = $("#offroad_datetime").val();
        var $mindate = new Date(jsDate);


        $('#mt_onroad_datetime').datetimepicker({
            dateFormat: "yy-mm-dd",
            minDate: $mindate,
            // minTime: jsDate[1],

        });
   $("#offroad_datetime").change(function(){
        var jsDate = $("#offroad_datetime").val();
        var $mindate = new Date(jsDate);


        $('.OnroadDate').datetimepicker({
            dateFormat: "yy-mm-dd ",
            minDate: $mindate,
            // minTime: jsDate[1],
            
        });
    });

    $('input[type=radio][name="app[mt_approval]"]').change(function(){
        //$("#ap").show();
        var app = $("input[name='app[mt_approval]']:checked").val();
        if(app == "1"){
            $(".ap").show();
        }else{
            $(".ap").hide();
        }
    });
    });
    function sum() {
      var txtFirstNumberValue = document.getElementById('part_cost').value;
      var txtSecondNumberValue = document.getElementById('labour_cost').value;
      var result =  parseInt(txtSecondNumberValue) + parseInt(txtFirstNumberValue);
      if (!isNaN(result)) {
         document.getElementById('total_cost').value = result;
      }
}
</script>