<?php
if (empty($_POST["gender"])) {
    $genderErr = "Gender is required";
} else {
    $gender = test_input($_POST["gender"]);
}
?>

<div id="dublicate_id"></div>

<?php
if ($type == 'Update') {
    $update = 'disabled';
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
            <?php if ($update) {
                ?>  
                <div class="field_row width100  fleet" ><div class="single_record_back">Previous  Info</div></div>
            <?php } ?>
            <div class="width100">

                <div class="field_row width100">

                    <div class="width2 float_left" hidden>
                        <div class="field_lable float_left width33"><label for="district">State<span class="md_field">*</span></label></div>
                        <div class="filed_input float_left width50"> <div id="ambulance_state">



                                <?php
                               // var_dump($indent_data);
                                
                                if (@$indent_data[0]->req_state_code != '') {
                                    $st = array('st_code' => 'MP', 'auto' => 'inc_auto_addr', 'rel' => 'incient', 'disabled' => 'disabled');
                                } else {
                                    $st = array('st_code' => 'MP', 'auto' => 'amb_auto_addr', 'rel' => 'incient', 'disabled' => '');
                                }


                                echo get_state_clo_comp_ambulance($st);
                                ?>

                            </div>

                        </div>

                    </div>
                    <div class="width2 float_left">    
                        <div class="field_lable float_left width33"><label for="district">District<span class="md_field">*</span></label></div>   <div class="filed_input float_left width50">
                            <div id="incient_district">
                                <?php
                                if (@$indent_data[0]->req_district_code != '') {
                                    $dt = array('dst_code' => @$indent_data[0]->req_district_code, 'st_code' => 'MP', 'auto' => 'inc_auto_addr', 'rel' => 'incient', 'disabled' => 'disabled','amb_type'=>'108');
                                } else {
                                    $dt = array('dst_code' => '', 'st_code' => 'MP', 'auto' => 'amb_auto_addr', 'rel' => 'incient', 'disabled' => '');
                                }

                                echo get_district_closer_amb($dt);
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="width2 float_left">
                        <div class="field_lable float_left width33"><label for="district">Ambulance Number<span class="md_field">*</span></label></div>
                        <div class="filed_input float_left width50">
                            <div id="incient_ambulance">



                                <?php
                                if (@$indent_data[0]->req_state_code != '') {
                                    $dt = array('dst_code' => @$indent_data[0]->req_district_code, 'st_code' => @$indent_data[0]->req_state_code, 'amb_ref_no' => @$indent_data[0]->req_amb_reg_no, 'auto' => 'inc_auto_addr', 'rel' => 'incient', 'disabled' => 'disabled');
                                } else {
                                    $dt = array('dst_code' => '', 'st_code' => '', 'auto' => 'amb_auto_addr', 'rel' => 'incient', 'disabled' => '');
                                }


                                echo get_clo_comp_ambulance($dt);
                                ?>

                            </div>

                        </div>

                    </div>
                </div>
                <div class="field_row width100">

                  

                    <div class="width2 float_left">
                        <div class="field_lable float_left width33"><label for="district">Base Location<span class="md_field">*</span></label></div>


                        <div class="filed_input float_left width50" id="amb_base_location">
                            <input name="req[req_base_location]" tabindex="23" class="form_input filter_required" placeholder=" Base Location" type="text" data-base="search_btn" data-errors="{filter_required:'Base Location should not be blank!'}" value="<?= @$indent_data[0]->hp_name; ?>" readonly="readonly"   <?php echo $update; ?>>

                        </div>


                    </div>
                    <div class="width2 float_left">

                        <div class="field_lable float_left width33"><label for="city">Shift Type</label></div>

                        <div class="filed_input float_left width50">
                            <select name="ind[req_shift_type]" tabindex="8"    <?php echo $update; ?>> 
                                <option value="" <?php echo $disabled; ?>>Select Shift Type</option>
                                <?php echo get_shift_type(@$indent_data[0]->req_shift_type); ?>
                            </select>

                        </div>



                    </div>
                    <div class="field_row width100">

                        <div class="width33 float_left stock_req_form">

                            <div class="width_78 float_left">

                                <fieldset>

                                    <legend>Consumables<span class="md_field">*</span></legend>

                                    <div class="CA_item text_align_center">
                                        <input type="hidden" class="item_type" name="item_type" value="CA">

                                        <div class="CA_blk">

                                            <div class="field_row">

                                                <div class="filed_input">

                                                    <input  type="text" name="req[CA][0][id]" tabindex="1"   value="" class="mi_autocomplete width100 caauto filter_required consumables_drugs" data-href="<?php echo base_url(); ?>auto/get_inv_items/CA/dq"  data-qr="output_position=content"  placeholder="Item Name" data-auto="CA" data-nonedit="yes" id="CAI_0" data-callback-funct="CAReq" data-errors="{filter_required:'At least one field is required'}">

                                                </div>

                                            </div>


                                            <div class="field_row">

                                                <div class="filed_input">

                                                    <input type="text" name="req[CA][0][qty]" tabindex="1" value="" class="width1 filter_if_not_empty[CAI_0] filter_required filter_number" placeholder="Item Quantity" data-errors="{filter_if_not_empty:'Item quantity should not be blank',filter_required:'Item quantity should not be blank','filter_number':'Item quantity should be in numbers'}">  

                                                </div>

                                            </div>

                                        </div>

                                    </div>

                                    <div class="width1 text_align_center add_more_ind">

                                        <a class="CA_more">Add more item +</a>

                                    </div>

                                </fieldset>

                            </div>

                        </div>

                        <div class="width33 float_left stock_req_form">


                            <div class="width_78 float_left">

                                <fieldset>

                                    <legend>Non Consumables</legend>


                                    <div class="NCA_item text_align_center">
                                        <input type="hidden" class="item_type" name="item_type" value="NCA">

                                        <div class="NCA_blk">

                                            <div class="field_row">

                                                <div class="filed_input" >

                                                    <input  type="text" name="req[NCA][0][id]" tabindex="1" value="" class="mi_autocomplete width100 filter_required non_consumable_drugs" data-href="<?php echo base_url(); ?>auto/get_inv_items/NCA/dq"  data-qr="" placeholder="Item Name" data-auto="NCA" data-nonedit="yes" id="NCAI_0" data-callback-funct="NCAReq" data-errors="{filter_required:'At least one field is required!'}" >

                                                </div>

                                            </div>


                                            <div class="field_row">

                                                <div class="filed_input">

                                                    <input type="text" name="req[NCA][0][qty]" tabindex="1" value="" class="width1 filter_if_not_empty[NCAI_0] filter_required filter_number" data-errors="{filter_if_not_empty:'Item quantity should not be blank',filter_required:'Item quantity should not be blank','filter_number':'Item quantity should be in numbers'}" placeholder="Item Quantity" >

                                                </div>

                                            </div>

                                        </div>


                                    </div>


                                    <div class="width1 text_align_center add_more_ind">

                                        <a class="NCA_more">Add more item +</a>

                                    </div>

                                </fieldset>

                            </div>

                            <!--</div>-->
                        </div>
                        <div class=" width33 float_right stock_req_form">

                            <div class="width_78 float_left">

                                <fieldset>

                                    <legend>Medicines<span class="md_field">*</span></legend>

                                    <div class="MED_item text_align_center">
                                        <input type="hidden" class="item_type" name="item_type" value="MED">


                                        <div class="MED_blk">

                                            <div class="field_row">

                                                <div class="filed_input" >

                                                    <input  type="text" name="req[MED][0][id]" tabindex="1" value="" class="mi_autocomplete width100 filter_required medicine_drugs" data-href="<?php echo base_url(); ?>auto/get_inv_med/dq"  placeholder="Medicine Name" autocomplete="off" data-auto="MED" data-nonedit="yes"  id="MEDI_0" data-callback-funct="MEDReq" data-errors="{filter_required:'At least one field is required'}" > 

                                                </div>

                                            </div>


                                            <div class="field_row">

                                                <div class="filed_input">

                                                    <input type="text" name="req[MED][0][qty]" tabindex="1" value="" class="width1 filter_if_not_empty[MEDI_0] filter_required filter_number" data-errors="{filter_if_not_empty:'Item quantity should not be blank',filter_required:'Item quantity should not be blank','filter_number':'Item quantity should be in numbers'}"   placeholder="Medicine Quantity">

                                                </div>

                                            </div>

                                        </div>


                                    </div> 


                                    <div class="width1 text_align_center add_more_ind">

                                        <a class="MED_more">Add more medicines +</a>

                                    </div>
                                </fieldset>
                            </div>
                        </div>

                        <div class="field_row width100">

                            <div class="width2 float_left">
                                <div class="field_lable float_left width33"> <label for="amount">Expected Date of Delivery<span class="md_field">*</span></label></div>
                                <div class="width50 float_left">

                                    <input name="ind[req_expected_date_time]" tabindex="20" class="form_input mi_timecalender filter_required" placeholder="Date Time" type="text"  data-errors="{filter_required:'Expected Date of delivery should not be blank!'}" value="<?= @$indent_data[0]->of_card_date; ?>"  <?php echo $update; ?>>

                                </div>
                            </div>
<!--                            <div class="width2 float_left">
                                <div class="field_lable float_left width33"> <label for="supervisor">Supervisor<span class="md_field">*</span></label></div>
                                <div class="filed_input float_left width50">
                                    <input name="ind[req_supervisor]" tabindex="20" class="form_input  filter_required" placeholder="Supervisor" type="text"  data-errors="{filter_required:'Supervisor should not be blank!'}" value="<?= @$indent_data[0]->of_filling_date; ?>"   <?php echo $update; ?>>
                                    
                                    <input name="ind[req_supervisor]" class="mi_autocomplete filter_required" data-href="<?php echo base_url(); ?>auto/get_auto_clg?clg_group=UG-EROSupervisor" data-value="<?= @$indent_data[0]->of_filling_date; ?>" value="<?= @$indent_data[0]->of_filling_date; ?>" type="text" tabindex="1" placeholder="Supervisor Manager" data-errors="{filter_required:'ERO-Supervisor Name should not be blank!'}" <?php echo $view; ?> <?php echo $edit; ?> data-qr='clg_group=UG-EROSupervisor&amp;output_position=content'>
                                    
                                </div>
                            </div>-->


                        </div>
                        <div class="field_row width100">

                            <div class="width2 float_left">
                                <div class="field_lable float_left width33"> <label for="amount">District Manager<span class="md_field">*</span></label></div>
                                <div class="width50 float_left">

<!--                                <input name="ind[req_district_manager]" tabindex="20" class="form_input  filter_required" placeholder="District Manager" type="text"  data-errors="{filter_required:'District Manager should not be blank!'}" value="<?= @$indent_data[0]->of_card_date; ?>"  <?php echo $update; ?>>-->
                                    <input name="ind[req_district_manager]" class="mi_autocomplete filter_required" data-href="<?php echo base_url(); ?>auto/get_auto_clg_dm?clg_group=UG-DM" data-value="<?= @$indent_data[0]->of_card_date; ?>" value="<?= @$indent_data[0]->of_card_date; ?>" type="text" tabindex="1" placeholder="District Manager" data-errors="{filter_required:'District Manage should not be blank!'}" data-qr='clg_group=UG-DIS-FILD-MANAGER&amp;output_position=content'  <?php echo $update; ?>>
                                </div>
                            </div>
                            <div class="filed_input float_left width2">

                                <div class="field_lable float_left width33"> <label for="mt_stnd_remark">Standard Remark<span class="md_field">*</span></label></div>


                                <div class="filed_input float_left width50">
                                    <select name="ind[req_standard_remark]" tabindex="8"  id="standard_remark" class="filter_required" data-errors="{filter_required:'Standard Remark should not be blank!'}"  > 
                                        <option value=""<?php echo $disabled; ?>>Select Standard Remark</option>
                                        <option value="ambulance_oxygen_filling"  <?php
                                        if (@$indent_data[0]->req_standard_remark == 'ambulance_oxygen_filling') {
                                            echo "selected";
                                        }
                                        ?>>Indent request send sucessfully.</option>  
                                        <option value="other"  <?php
                                        if (@$vehical_data[0]->req_standard_remark == 'other') {
                                            echo "selected";
                                        }
                                        ?>>Other</option> 
                                    </select>
                                </div>
                            </div>


                        </div>
                        <div class="field_row width100">
                            <div class="width2 float_left">
                                <div id="remark_other_textbox">
                                </div>
                            </div>
                        </div>

                        <?php
                        if ($update) {
                            $previous_odo = @$indent_data[0]->of_prevoius_odometer;
                            ?>  
                            <div class="field_row width100  fleet" ><div class="single_record_back">Current Info</div></div>

                            <input type="hidden" name="previos_odometer" value="<?= @$indent_data[0]->of_prevoius_odometer; ?>">
                            <input type="hidden" name="maintaince_ambulance" value="<?= @$indent_data[0]->of_amb_ref_no; ?>">

                            <div class="field_row width100">
                                <div class="width2 float_left">
                                    <div class="field_lable float_left width33"><label for="end_odometer">End Odometer<span class="md_field">*</span></label></div>

                                    <div class="filed_input float_left width50" >
                                        <input type="text" name="mt_end_odometer" value="<?= @$indent_data[0]->of_end_odometer; ?>" class="filter_required filter_valuegreaterthan[<?php echo $previous_odo; ?>] filter_maxlength[8]" placeholder="End Odometer" data-errors="{filter_required:'End Odometer should not be blank',filter_valuegreaterthan:'In Odometer should greater than or equlto Previous Odometer',filter_rangelength:'END Odometer should <?php echo $previous_odometer; ?>',filter_maxlength:'END Odometer at max 7 digit long.'}" TABINDEX="8" <?php
                                        if (@$indent_data[0]->of_end_odometer != '') {
                                            echo "disabled";
                                        }
                                        ?>>


                                    </div>
                                </div>
                                <div class="width2 float_left">

                                    <div class="field_lable float_left width33"><label for="mt_onroad_datetime"> Date/Time<span class="md_field">*</span></label></div>

                                    <div class="filed_input float_left width50" >
                                        <input type="text" name="oxygen[of_on_road_ambulance]"  value=" <?php
                                        if (@$indent_data[0]->of_on_road_ambulance != '0000-00-00 00:00:00' && @$indent_data[0]->of_on_road_ambulance != '') {
                                            echo @$indent_data[0]->of_on_road_ambulance;
                                        }
                                        ?>" class="filter_required mi_timecalender" placeholder="On-Road Date/Time" data-errors="{filter_required:'On-Road Date/Time should not be blank'}" TABINDEX="8" <?php
                                               if (@$indent_data[0]->of_on_road_ambulance != '0000-00-00 00:00:00' && @$indent_data[0]->of_on_road_ambulance != '') {
                                                   echo "disabled";
                                               }
                                               ?>>



                                    </div>
                                </div>
                            </div>
                            <div class="field_row width100">
                                <div class="filed_input float_left width2">

                                    <div class="field_lable float_left width33"> <label for="mt_stnd_remark">Standard Remark<span class="md_field">*</span></label></div>


                                    <div class="filed_input float_left width50">
                                        <select name="oxygen[mt_on_stnd_remark]" tabindex="8" class="filter_required" data-errors="{filter_required:'Standard Remark should not be blank!'}"  > 
                                            <option value="">Select Standard Remark</option>
                                            <?php if ($update) { ?>  <option value="ambulance_oxygen_filling"  <?php
                                                if (@$indent_data[0]->mt_on_stnd_remark == 'ambulance_oxygen_filling') {
                                                    echo "selected";
                                                }
                                                ?>>Ambulance Oxygen Filling Done</option>  <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="width2 float_left">
                                    <div class="field_lable float_left width33"> <label for="mt_on_remark">Remark<span class="md_field">*</span></label></div>


                                    <div class="filed_input float_left width50" >
                                        <textarea style="height:60px;" name="oxygen[mt_on_remark]" class="filter_required" TABINDEX="16" data-maxlen="1600"  data-errors="{filter_required:'Remark should not be blank'}"><?= @$indent_data[0]->mt_on_remark; ?></textarea>
                                    </div>
                                </div>
                            </div>


                        <?php } ?>

                        <?php if ($update) { ?>  

                            <input type="hidden" name="oxygen[of_id]"  value="<?= @$indent_data[0]->of_id ?>">

                        <?php } ?>



                        <div class="button_field_row  margin_auto float_left width100 text_align_center">
                            <div class="button_box">

                                <input type="button" name="submit" value="<?php if ($update) { ?>Update<?php } else { ?>Submit<?php } ?>" class="btn submit_btnt1 form-xhttp-request accept_btn1 inc_confirm_button1" data-href='<?php echo base_url(); ?>fleet/<?php if ($update) { ?>edit_indent_request<?php } else { ?>register_indent_request<?php } ?>' data-qr='output_position=content&amp;prof=<?php echo @$prof; ?>&amp;module_name=clg&amp;tlcode=<?php if ($update) { ?>MT-CLG-UPDATE<?php } else { ?>MT-CLG-ADD<?php } ?>&amp;page_no=<?php echo @$page_no; ?>&ampshowprocess=yes'  TABINDEX="23" id="<?php echo @$current_data[0]->clg_ref_id; ?>">
                                <!--<input type="reset" name="reset" value="Reset" class="btn reset_btn register_view_reset"  TABINDEX="24">-->       

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

<div id="CA_tmp" class="hide">



    <div class="CA_blk blk ind_class"><div class="width100 display_inlne_block"><div class="remove_button_ind" style="float:right; cursor: pointer; height: 20px; width: 70px;">Remove</div></div><div class="field_row"><div class="filed_input"><input type="text" name="req[CA][indx][id]" tabindex="1" value="" class="autocls width100" data-href="<?php echo base_url() ?>auto/get_inv_items/CA/dq"  data-qr="output_position=content" placeholder="Item Name" data-auto="CA" data-nonedit="yes" id="CAI_indx" data-callback-funct="CAReq"></div></div><div class="field_row"><div class="filed_input"><input type="text" name="req[CA][indx][qty]" tabindex="1" value="" class="width1 filter_if_not_empty[CAI_indx] filter_required filter_number" data-errors="{filter_if_not_empty:'Item quantity should not be blank',filter_required:'Item quantity should not be blank','filter_number':'Item quantity should be in numbers'}" placeholder="Item Quantity" ></div></div></div>

</div>

<div id="NCA_tmp" class="hide">

    <div class="NCA_blk blk ind_class"><div class="width100 display_inlne_block"><div class="remove_button_ind" style="float:right; cursor: pointer; height: 20px; width: 70px;">Remove</div></div><div class="field_row"><div class="filed_input"><input type="text" name="req[NCA][indx][id]" tabindex="1" value="" class="autocls width100" data-href="<?php echo base_url() ?>auto/get_inv_items/NCA/dq"  data-qr="" placeholder="Item Name" data-auto="NCA" data-nonedit="yes" id="NCAI_indx" data-callback-funct="NCAReq"></div></div><div class="field_row"><div class="filed_input"><input type="text" name="req[NCA][indx][qty]" tabindex="1" value="" class="width1 filter_if_not_empty[NCAI_indx] filter_required filter_number" data-errors="{filter_if_not_empty:'Item quantity should not be blank',filter_required:'Item quantity should not be blank','filter_number':'Item quantity should be in numbers'}" placeholder="Item Quantity"></div></div></div>

</div>

<div id="MED_tmp" class="hide">

    <div class="MED_blk blk ind_class"><div class="width100 display_inlne_block"><div class="remove_button_ind" style="float:right; cursor: pointer; height: 20px; width: 70px;">Remove</div></div><div class="field_row"><div class="filed_input"><input type="text" name="req[MED][indx][id]" tabindex="1" value="" class="autocls width1" data-href="<?php echo base_url() ?>auto/get_inv_med/dq"  placeholder="Medicine Name" autocomplete="off" data-auto="MED" data-nonedit="yes" id="MEDI_indx" data-callback-funct="MEDReq"></div></div><div class="field_row"><div class="filed_input"><input type="text" name="req[MED][indx][qty]" tabindex="1" value="" class="width1 filter_if_not_empty[MEDI_indx] filter_required filter_number" data-errors="{filter_if_not_empty:'Item quantity should not be blank',filter_required:'Item quantity should not be blank','filter_number':'Item quantity should be in numbers'}" placeholder="Medicine Quantity"></div></div></div>

</div> 


<style>
    #cboxLoadedContent{
        width: 1086px ;
    overflow: auto;
    height: 400px ;
    }
    #cboxContent{
        float: left;
    width: 1080px ;
    height: 400px ;
    }
    #colorbox{
        width: 1080px ;
        left: 120px ;
        height: 420px ;
    }
</style>

