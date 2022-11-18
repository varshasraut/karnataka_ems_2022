<?php
if (@$view_clg == 'view') {
    $view = 'disabled';
}
?>
<div class="call_purpose_form_outer">

    <div class="width100">

        <h3>ERCP Team</h3>

        <div class="incident_details">

            <form enctype="multipart/form-data" action="#" method="post" id="add_inc_details">

                <div class="width100 float_left">
                    <div class="width100 form_field outer_smry">
                        
                        <div class="width100 float_left">         
                            <div class="width30 label blue float_left">QA Name<span class="md_field">*</span>&nbsp;</div>
                            <div class="width70 float_left">
                               <input name="team[qa_name]" class="mi_autocomplete" data-href="<?php echo base_url();?>auto/get_auto_clg?clg_group=UG-Quality"  data-value="<?php echo $stud_sickroom[0]->qa_name ;?>" value="<?php echo $stud_sickroom[0]->qa_name ;?>" type="text" tabindex="2" placeholder="QA Name">
                            </div>
                        </div>

                        <div class="width100 float_left">
                            <div class="label blue float_left width30">ERCP Supervisor</div>

                            <div class="width2 float_left width70" id="ero_supervisor">
                                 <input name="team[ero_supervisor]" class="mi_autocomplete" data-href="<?php echo base_url();?>auto/get_auto_clg?clg_group=UG-ERCPSupervisor"  data-value="<?php echo $stud_sickroom[0]->ero_supervisor ;?>" value="<?php echo $stud_sickroom[0]->ero_supervisor ;?>" type="text" tabindex="2" placeholder="ERCP Supervisor" data-callback-funct="load_ercp_by_supervisor">
                            </div>
                        </div>
                    </div>
                    <div id="ERO_list">
                    </div>
                </div>
                
<?php if (!@$view_clg) { ?>
        <div class="button_field_row width2 margin_auto">
            <div class="button_box">
                <input type="button" name="submit" value="<?php if ($update) { ?>Update<?php } else { ?>Submit<?php } ?>" class="btn submit_btnt form-xhttp-request" data-href='<?php echo base_url();?>quality/<?php if ($update) { ?>update_ercp_team<?php } else { ?>save_ercp_team<?php } ?>' data-qr='output_position=content&amp;prof=<?php echo @$prof; ?>&amp;module_name=quality' TABINDEX="23" id="<?php echo @$current_data[0]->clg_ref_id; ?>">
                <input type="reset" name="reset" value="Reset" class="btn reset_btn register_view_reset"  TABINDEX="24">              <input type="hidden" name="clg_data" value=<?php echo $data; ?>>
            </div>
        </div>

<?php } ?>
            </form>
        </div>
    </div>
</div>
