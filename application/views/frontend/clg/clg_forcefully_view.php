<form enctype="multipart/form-data" action="#" method="post" id="add_colleague_registration_form">
     <h2 class="txt_clr2 width1 txt_pro">Forcefully Logout</h2>
                <div class="width2 float_left">
                    <div class="field_lable float_left width33"> <label for="remark">Remark<span class="md_field">*</span></label></div>

                <div class="width50 float_left">
                    <textarea  name="logout_remark" class="filter_required" TABINDEX="16" data-maxlen="1600"  data-errors="{filter_required:'Remark should not be blank'}"  <?php echo $disabled; ?>><?= @$scene_data[0]->cs_remark; ?></textarea>

                </div>
                </div>
                <div class="button_field_row width_25 margin_auto" style="clear:both;"> 
                    <div class="button_box margin_auto">
                        <input name="ref_id" value="<?php echo $ref_id;?>" type="hidden">
                        
                     
                        <input type="button" name="submit" value="Logout" class="btn submit_btnt form-xhttp-request float_left" data-href='<?php echo base_url(); ?>clg/save_force_logout' data-qr='output_position=content&amp;prof=<?php echo @$prof; ?>&amp;module_name=clg&amp;tlcode=<?php if ($update) { ?>MT-CLG-UPDATE<?php } else { ?>MT-CLG-ADD<?php } ?>&amp;page_no=<?php echo @$page_no; ?>&ampshowprocess=yes'  TABINDEX="23" id="<?php echo @$current_data[0]->clg_ref_id; ?>">
                       
                    </div>
                </div>
</form>