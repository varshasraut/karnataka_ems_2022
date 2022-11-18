
<?php
if (@$view_clg == 'view') {
    $view = 'disabled';
}
?>

<form enctype="multipart/form-data" action="#" method="post" id="add_colleague_registration_form">
    <div class="width1">
        <h2 class="txt_clr2 width1 txt_pro"><?php
            if ($action_type) {
                echo $action_type;
            }
            ?></h2>


        <div class="joining_details_box">

            <div class="width100">



                <div class="field_row width100">
                    <div class="width2 float_left">
                        <div class="field_lable float_left width33"><label for="city">Type<span class="md_field">*</span></label></div>

                        <div class="filed_input float_left width50">

                            <?php $selected[@$sugg_data[0]->su_type] = "selected=selected"; ?>   

                            <select  name="sugg[su_type]" id="other_police_type" class="add_clg_sts filter_required" data-errors="{filter_required:'Type Name should not be blank!'}" data-qr="output_position=content&amp;flt=true" <?php echo $view; ?>>

                                <option value="" >Select Status</option>

                                <option value="police" <?php echo $selected['police']; ?>>Police</option>

                                <option value="work" <?php echo $selected['work']; ?>>Work</option>

                                <option value="other" <?php echo $selected['other']; ?>>Other</option>



                            </select>
                        </div>
                    </div>
                    <div  class="width2 float_left">
                         <div id="other_type_textbox"></div>
                    </div>
                    <div class="width2 float_left">
                       
                        <div class="field_lable float_left width33"> <label for="mobile_no">Suggestion Remark<span class="md_field">*</span></label></div>


                        <div class="filed_input float_left width50">
                            <input data-base="<?= @$current_data[0]->clg_ref_id ?>"  type="text" name="sugg[su_suggetion_remark]" class="filter_required "  data-errors="{filter_required:'Suggetion Remark should not be blank'}" value="<?= @$sugg_data[0]->su_suggetion_remark ?>" TABINDEX="10"  <?php echo $view; ?>>
                        </div>
                    </div>
                </div>
                <div class="field_row width100">
                    <div class="width2 float_left">
                        <div class="field_lable float_left width33"> <label for="mobile_no">Report To HO<span class="md_field">*</span></label></div>

                        <div class="filed_input width2 float_left">
                       <!--                    <label for="gender">Gender<span class="md_field">*</span></label>-->
                            <?php $report[@$sugg_data[0]->su_report_to_ho] = "checked"; ?>

                            <div class="radio_button_div1">
                                <label for="fire_y" class="radio_check float_left width50">  
                                    <input  data-base="<?= @$current_data[0]->clg_ref_id ?>"  id="fire_y" type="radio" name="sugg[su_report_to_ho]" value="yes" class="radio_check_input filter_required" data-errors="{filter_required:'>Report To HO not be blank'}" <?php echo $report['yes']; ?> TABINDEX="16" checked  <?php echo $view; ?>><span class="radio_check_holder"></span>Yes
                                </label>

                                <label for="fire_n" class="radio_check float_left width50">  
                                    <input data-base="<?= @$current_data[0]->clg_ref_id ?>"  id="fire_n" type="radio" name="sugg[su_report_to_ho]" value="no" <?php echo $report['no']; ?> class="radio_check_input" data-errors="{filter_required:'>Report To HO not be blank'}" TABINDEX="17"  <?php echo $view; ?>><span class="radio_check_holder filter_required"></span>No
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="width2 float_left">
                        <div class="field_lable float_left width33"> <label for="mobile_no">Date/Time<span class="md_field">*</span></label></div>


                        <div class="filed_input float_left width50">
                            <input name="sugg[su_date_time]" tabindex="20" class="form_input mi_timecalender filter_required" placeholder="Date Time" type="text"  data-errors="{filter_required:'Date should not be blank!'}" value="<?= @$sugg_data[0]->su_date_time; ?>" >
                        </div>
                    </div>

                </div>

                <div class="field_row width100">
                    <div class="width2 float_left">
                        <div class="field_lable float_left width33"> <label for="mobile_no">Standard Remark<span class="md_field">*</span></label></div>


                        <div class="filed_input float_left width50">

                            <select name="sugg[su_standard_remark]" tabindex="8"  class="filter_required" data-errors="{filter_required:'Standard Remark should not be blank!'}"   <?php echo $update; ?>> 
                                <option value="" <?php echo $disabled; ?>>Select Standard Remark</option>
                                <option value="suggestion_register"  <?php
                                if ($fuel_data[0]->ff_standard_remark == 'suggestion_register') {
                                    echo "selected";
                                }
                                ?>  >Suggestion register sucessfully</option>
                            </select>
                        </div>
                    </div>
                    <div class="width2 float_left">
                        <div class="field_lable float_left width33"> <label for="mobile_no">Remark</label></div>


                        <!--<div class="filed_input float_left width50" >-->
                        <div class="width50 float_left">
                            <textarea  name="sugg[su_remark]" class="" TABINDEX="16" data-maxlen="1600"  ><?= @$sugg_data[0]->su_remark; ?></textarea>
                            <!--</div>-->
                        </div>
                    </div>

                </div>


                <?php if ($update) { ?>  

                    <input type="hidden" name="sugg[su_id]" id="ud_clg_id" value="<?= @$sugg_data[0]->su_id ?>">

                <?php } ?>


                <?php if (!@$view_clg) { ?>
                    <div class="button_field_row width_25 margin_auto">
                        <div class="button_box">
                            <input type="hidden" name="hasfiles" value="yes" />
                            <input type="hidden" name="formid" value="add_colleague_registration" />
                            <input type="button" name="submit" value="<?php if ($update) { ?>Update<?php } else { ?>Submit<?php } ?>" class="btn submit_btnt form-xhttp-request" data-href='<?php echo base_url(); ?>fleet/<?php if ($update) { ?>update_suggestion_data<?php } else { ?>registration_suggestions<?php } ?>' data-qr='output_position=content&amp;prof=<?php echo @$prof; ?>&amp;module_name=clg&amp;tlcode=<?php if ($update) { ?>MT-CLG-UPDATE<?php } else { ?>MT-CLG-ADD<?php } ?>&amp;page_no=<?php echo @$page_no; ?>'  TABINDEX="23" id="<?php echo @$current_data[0]->clg_ref_id; ?>">
                            <input type="reset" name="reset" value="Reset" class="btn reset_btn register_view_reset"  TABINDEX="24">              <input type="hidden" name="clg_data" value=<?php echo $data; ?>>
                        </div>
                    </div>

                <?php } ?>

                </form>

