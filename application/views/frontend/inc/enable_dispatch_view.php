<div class="width100">
     <div class="width2 float_left">    
          <div class="label blue float_left">Ambulance<span class="md_field">*</span>&nbsp;</div>   
          <div class="width2 float_left">
         <input name="incient[enable_ambulance][0]" class="mi_autocomplete dropdown_per_page width97 filter_required" data-href="{base_url}auto/get_ambulance_by_type/102" placeholder="Select Ambulance" data-errors="{filter_required:'Please select Ambulance from dropdown list'}" tabindex="15" autocomplete="off">
          </div>

    </div>
    <div class="width2 form_field float_left">
        <div class="label blue float_left">Unable Dispatch Remark<span class="md_field">*</span>&nbsp;</div>
        <div class="width2 float_left">
              <?php //var_dump($inc_details); ?>
         <input type="text" name="incient[enable_standard_summary][0]" data-value="<?php if($inc_details['inc_ero_standard_summary'] != ''){ get_ero_remark($inc_details['enable_standard_summary']); } ?>" value="<?= @$inc_details['inc_ero_standard_summary']; ?>" class="mi_autocomplete filter_required width2"  data-href="{base_url}auto/get_ero_standard_summary?call_type=ENABLE_DISPATCH"  placeholder="ERO Summary" data-errors="{filter_required:'Please select Unable Dispatch Remark dropdown list'}" data-callback-funct="ero_standard_summary_change" TABINDEX="8" >
          </div>
    </div>
</div>
<div class="width100">
     <div class="width2 float_left">    
          <div class="label blue float_left">Ambulance<span class="md_field">*</span>&nbsp;</div>   
          <div class="width2 float_left">
         <input name="incient[enable_ambulance][1]" class="mi_autocomplete dropdown_per_page width97 filter_required" data-href="{base_url}auto/get_ambulance_by_type/102" placeholder="Select Ambulance" data-errors="{filter_required:'Please Ambulance from dropdown list'}" tabindex="15" autocomplete="off">
          </div>

    </div>
    <div class="width2 form_field float_left">
        <div class="label blue float_left">Unable Dispatch Remark<span class="md_field">*</span>&nbsp;</div>
        <div class="width2 float_left">
              <?php //var_dump($inc_details); ?>
         <input type="text" name="incient[enable_standard_summary][1]" data-value="<?php if($inc_details['inc_ero_standard_summary'] != ''){ get_ero_remark($inc_details['enable_standard_summary']); } ?>" value="<?= @$inc_details['inc_ero_standard_summary']; ?>" class="mi_autocomplete filter_required width2"  data-href="{base_url}auto/get_ero_standard_summary?call_type=ENABLE_DISPATCH"  placeholder="ERO Summary" data-errors="{filter_required:'Please select Unable Dispatch Remark from dropdown list'}" data-callback-funct="ero_standard_summary_change" TABINDEX="8" >
          </div>
    </div>
</div>
<div class="width100">
     <div class="width2 float_left">    
          <div class="label blue float_left">Ambulance<span class="md_field">*</span>&nbsp;</div>   
          <div class="width2 float_left">
         <input name="incient[enable_ambulance][2]" class="mi_autocomplete dropdown_per_page width97 filter_required" data-href="{base_url}auto/get_ambulance_by_type/102" placeholder="Select Ambulance" data-errors="{filter_required:'Please select Ambulance from dropdown list'}" tabindex="15" autocomplete="off">
          </div>

    </div>
    <div class="width2 form_field float_left">
        <div class="label blue float_left">Unable Dispatch Remark<span class="md_field">*</span>&nbsp;</div>
        <div class="width2 float_left">
              <?php //var_dump($inc_details); ?>
         <input type="text" name="incient[enable_standard_summary][2]" data-value="<?php if($inc_details['inc_ero_standard_summary'] != ''){ get_ero_remark($inc_details['enable_standard_summary']); } ?>" value="<?= @$inc_details['inc_ero_standard_summary']; ?>" class="mi_autocomplete filter_required width2"  data-href="{base_url}auto/get_ero_standard_summary?call_type=ENABLE_DISPATCH"  placeholder="ERO Summary" data-errors="{filter_required:'Please select Unable Dispatch Remark from dropdown list'}" data-callback-funct="ero_standard_summary_change" TABINDEX="8" >
          </div>
    </div>
</div>
  <input type="button" name="submit" value="Submit" class="btn submit_btnt form-xhttp-request" data-href='{base_url}inc102/confirm_dropback_save' data-qr='output_position=content&amp;module_name=inc&amp;tlcode=MT-INC-ADD&amp;call_type=enable_dispatch'  TABINDEX="21">