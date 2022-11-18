
<form enctype="multipart/form-data" action="#" method="post" id="usr_ad_form">
<h2 class="txt_clr2 width1 txt_pro">Odometer Change Details</h2>
    <div class="field_input float_left width50">
        <select name="odometer_change_type" id="odometer_change_type" class="filter_required" placeholder="Select Option" data-errors="{filter_required:'Please select dropdown list'}" onchange="Odometer_change_display()"  TABINDEX="1">
            <option value="">Select Odometer Update Type</option>
            <option value="2">New odometer fitted</option>
            <option value="1">Closure odometer change</option>
        </select>
    </div>
    <input type="hidden" id="date" name="date" value="<?php echo date('Y-m-d H:i:s'); ?>" />
    <input type="hidden" id="submit_amb" name="submit_amb" value="amb_reg" />
    <input type="hidden" id="amb" name="amb" class="filter_required" data-errors="{filter_required:'Registration Number should not be blank'}" value="<?php echo $update[0]->amb_rto_register_no; ?>" tabindex="1" autocomplete="off">
   <div id="odo_view">
   </div>
   <div id="odo_view_case_closure">
   </div>
   
</form>



