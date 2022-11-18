<div class="filed_lable float_left width33"><label for="station_name">Grievance Sub-type <span class="md_field">*</span></label></div>

<div class="filed_input float_left width50">
<!--<select class="mi_autocomplete_input filter_required     ui-autocomplete-input" name="gri[gc_grievance_sub_type]" id="Gri_sub_type" >                           
<option>Select Grievance Sub-Type</option>
<?php // foreach ($gri_data as $key => $gri) {
?>
 <option value="<?php //echo $gri->g_id ; ?>" ><?php//echo $gri->grievance_sub_type; ?></option>
<?php 
//} ?>
</select>-->
<?php //var_dump($id);die(); 
 ?>
<input type="text" name="gri[gc_grievance_sub_type]" id="chief_complete" data-value="<?= @$inc_details['chief_complete']; ?>" value="<?= @$inc_details['chief_complete_id']; ?>" class="mi_autocomplete filter_required" data-errors="{filter_required:'Grievance Sub-type should not be blank'}"  data-href="{base_url}auto/get_grievance_sub_type/<?php echo $id; ?>"  placeholder="Grievance type" TABINDEX="8" <?php echo $autofocus; ?>>
</div>