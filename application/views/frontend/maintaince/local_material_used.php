 <div class="width2 float_left">
                        
                        <div class="field_lable float_left width33"><label for="mt_local_purchase">Local Purchase<span class="md_field">*</span></label></div>

                        <div class="filed_input float_left width50" >
<!--                              <input type="text" name="breakdown[mt_local_purchase]" value="" class="filter_required" placeholder="Local Purchase" data-errors="{filter_required:'Local Purchase should not be blank'}" TABINDEX="8" <?php echo $update; echo $approve; echo $rerequest;?> readonly='readonly'>-->
                              
                               <textarea style="height:60px;" name="breakdown[mt_local_purchase]" class="filter_required" TABINDEX="16" data-maxlen="1600"  data-errors="{filter_required:'Local Purchase should not be blank'}" <?php echo $update; echo $approve;?> <?php echo $view; echo $rerequest; ?> ><?= @$preventive[0]->mt_local_purchase; ?></textarea>
                              
                              
                           
                           
                        </div> 
 </div> 
<div class="width2 float_left">
    <div class="field_lable float_left width33"><label for="labor_cost">Local Purchase Cost<span class="md_field">*</span></label></div>

    <div class="filed_input float_left width50" >

        <input type="text" name="breakdown[part_cost]" id="local_purchase_cost" value="" class="filter_required filter_maxlength[7] filter_number" placeholder="Local Purchase Cost" data-errors="{filter_required:'Local Purchase Cost should not be blank',filter_maxlength:'Local Purchase Cost at max 6 digit long.',filter_number:'number shuold be integer'}" TABINDEX="8" onchange="cost_sum()">
    </div>
</div>