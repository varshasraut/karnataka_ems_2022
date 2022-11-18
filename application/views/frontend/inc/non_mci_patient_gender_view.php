<?php 
if (strstr($chief_comps_services[0]->ct_type, "pregnancy") || strstr($chief_comps_services[0]->ct_type, "Pregnancy") || strstr($chief_comps_services[0]->ct_type, "pregnant")) { ?>
<select id="patient_gender" name="patient[gender]" class="" data-errors="{filter_required:'Patient Gender is required'}" <?php echo $view; ?> TABINDEX="15" disabled="disabled">
                                <option value="">Gender</option>
                                <option value="M" >Male</option> 
                                <option value="F" selected="selected">Female</option>
                                <option value="O">Other</option>
                            </select>
<?php }else{?>
<select id="patient_gender" name="patient[gender]" class="" data-errors="{filter_required:'Patient Gender is required'}" <?php echo $view; ?> TABINDEX="15">
                                <option value="">Gender</option>
                                <option value="M" <?php if($caller_details_data['patient_gender'] == 'Male' || $caller_details_data['patient_gender'] == 'M'){ echo "selected"; }?>>Male</option> 
                                <option value="F"  <?php if($caller_details_data['patient_gender'] == 'Female' || $caller_details_data['patient_gender'] == 'F'){ echo "selected"; }?>>Female</option>
                                <option value="O"  <?php if($caller_details_data['patient_gender'] == 'Other' || $caller_details_data['patient_gender'] == 'O'){ echo "selected"; }?>>Other</option>
                            </select>
<?php } ?>

