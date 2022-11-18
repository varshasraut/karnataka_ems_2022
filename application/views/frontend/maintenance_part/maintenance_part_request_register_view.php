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
            <div class="width100">

                <div class="field_row width100">

                    <div class="width2 float_left">
                        <div class="field_lable float_left width33"><label for="district">State<span class="md_field">*</span></label></div>
                        <div class="filed_input float_left width50"> <div id="ambulance_state">



                                <?php
                               // var_dump($indent_data);
                                
                                if (@$indent_data[0]->req_state_code != '') {
                                    $st = array('st_code' => @$indent_data[0]->req_state_code, 'auto' => 'inc_auto_addr', 'rel' => 'incient', 'disabled' => 'disabled');
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
                                    $dt = array('dst_code' => @$indent_data[0]->req_district_code, 'st_code' => @$indent_data[0]->req_district_code, 'auto' => 'inc_auto_addr', 'rel' => 'incient', 'disabled' => 'disabled','amb_type'=>'108');
                                } else {
                                    $dt = array('dst_code' => '', 'st_code' => 'MP', 'auto' => 'amb_auto_addr', 'rel' => 'incient', 'disabled' => '');
                                }

                                echo get_district_closer_amb($dt);
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="field_row width100">
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

                    <div class="width2 float_left">
                        <div class="field_lable float_left width33"><label for="district">Base Location<span class="md_field">*</span></label></div>


                        <div class="filed_input float_left width50" id="amb_base_location">
                            <input name="req[req_base_location]" tabindex="23" class="form_input filter_required" placeholder=" Base Location" type="text" data-base="search_btn" data-errors="{filter_required:'Base Location should not be blank!'}" value="<?= @$indent_data[0]->hp_name; ?>" readonly="readonly"   <?php echo $update; ?>>

                        </div>


                    </div>
                    
                    
                </div>
                <div class="field_row width100">
                    <div id="maintance_request_previous_odometer">
                        <div class="width2 float_left" >
                            <div class="field_lable float_left width33"><label for="previous_odometer">Previous Odometer<span class="md_field">*</span></label></div>

                            <div class="filed_input float_left width50" >
                                <input type="text" name="previous_odometer" value="<?= @$previous_odometer; ?>" class="filter_required filter_number filter_maxlength[7]" placeholder="Previous Odometer" data-errors="{filter_required:'Please select Previous Odometer',filter_maxlength:'Previous Odometer at max 6 digit long.',filter_number:'number shuold be integer'}" TABINDEX="8">


                            </div>
                        </div>
                        <div class="width2 float_left" >
                            <div class="field_lable float_left width33"><label for="current_odometer">Current Odometer<span class="md_field">*</span></label></div>

                            <div class="filed_input float_left width50" >
                                <input type="text" name="in_odometer" value="" class="filter_required filter_number filter_maxlength[7]" placeholder="Current Odometer" data-errors="{filter_required:'Please select Current Odometer',filter_maxlength:'Previous Odometer at max 6 digit long.',filter_number:'number shuold be integer'}" TABINDEX="8">


                            </div>
                        </div>
                        </div>
                         <div class="width2 float_left" >
                            <div class="field_lable float_left width33"><label for="current_odometer">Maintenance type<span class="md_field">*</span></label></div>

                            <div class="filed_input float_left width50" >
                                <select name="ind[req_maintanance_type]" tabindex="8" <?php echo $update; ?> id="maintance_type" class="filter_required" data-errors="{filter_required:'Please select Maintenance type'}"> 
                                    <option value="" <?php echo $disabled; ?>>Select Maintenance type</option>
                                    <option value="Preventive">Preventive</option>
                                    <option value="Breakdown">Breakdown</option>
                                    <option value="Accidental">Accidental</option>
                                    <option value="Tyre">Tyre</option>
                                    
                                </select>
                            </div>
                        </div>
                    
                </div>
                
                
                <div class="field_row width100" id="maintananace_part_list_block">

                    <div class="width33 float_left stock_req_form">

                        <div class="width_78 float_left">

                            <fieldset>

                                <legend>Force</legend>

                                <div class="CA_item text_align_center">
                                    <input type="hidden" class="item_type" name="item_type" value="CA">

                                    <div class="CA_blk">

                                        <div class="field_row">

                                            <div class="filed_input" >

                                                <input  type="text" name="req[Force][0][id]" tabindex="1"   value="" class="mi_autocomplete width100 caauto filter_required consumables_drugs" data-href="<?php echo base_url(); ?>auto/get_maintance_part_items/Force/dp"  data-qr="output_position=forcecode_0"  placeholder="Item Name" data-auto="Force" data-nonedit="yes" id="ForceI_0" data-callback-funct="forceReq" data-errors="{filter_required:'At least one field is required'}">

                                            </div>

                                        </div>
<!--                                            <div class="field_row">

                                            <div class="filed_input forcecode" id="forcecode_0">

                                                <input type="text" name="req[Force][0][item_code]" tabindex="1" value="" class="width1 filter_if_not_empty[ForceI_0] filter_required filter_number" placeholder="Item Code" data-errors="{filter_if_not_empty:'Item quantity should not be blank',filter_required:'Item quantity should not be blank','filter_number':'Item quantity should be in numbers'}">  

                                            </div>

                                         </div>-->

                                        <div class="field_row">

                                            <div class="filed_input">

                                                <input type="text" name="req[Force][0][qty]" tabindex="1" value="" class="width1 filter_if_not_empty[ForceI_0] filter_required filter_number" placeholder="Item Quantity" data-errors="{filter_if_not_empty:'Item quantity should not be blank',filter_required:'Item quantity should not be blank','filter_number':'Item quantity should be in numbers'}">  

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

                                <legend>Ashok Leyland</legend>


                                <div class="NCA_item text_align_center">
                                    <input type="hidden" class="item_type" name="item_type" value="NCA">

                                    <div class="NCA_blk">

                                        <div class="field_row">

                                            <div class="filed_input" >

                                                <input  type="text" name="req[Ashok_Leyland][0][id]" tabindex="1" value="" class="mi_autocomplete width100 filter_required non_consumable_drugs" data-href="<?php echo base_url(); ?>auto/get_maintance_part_items/Ashok Leyland/dp"  data-qr="" placeholder="Item Name" data-auto="Ashok_Leyland" data-nonedit="yes" id="NCAI_0" data-callback-funct="NCAReq" data-errors="{filter_required:'At least one field is required!'}" >

                                            </div>

                                        </div>
<!--                                            <div class="field_row">

                                            <div class="filed_input" >

                                                <input type="text" name="req[Ashok_Leyland][0][item_code]" tabindex="1" value="" class="width1 filter_if_not_empty[ForceI_0] filter_required filter_number" placeholder="Item Code" data-errors="{filter_if_not_empty:'Item code should not be blank',filter_required:'Item code should not be blank','filter_number':'Item code should be in numbers'}">  

                                            </div>

                                         </div>-->


                                        <div class="field_row">

                                            <div class="filed_input">

                                                <input type="text" name="req[Ashok_Leyland][0][qty]" tabindex="1" value="" class="width1 filter_if_not_empty[NCAI_0] filter_required filter_number" data-errors="{filter_if_not_empty:'Item quantity should not be blank',filter_required:'Item quantity should not be blank','filter_number':'Item quantity should be in numbers'}" placeholder="Item Quantity" >

                                            </div>

                                        </div>

                                    </div>


                                </div>


                                <div class="width1 text_align_center add_more_ind">

                                    <a class="NCA_more">Add more item +</a>

                                </div>

                            </fieldset>

                        </div>

                    </div>

                </div>
                <div class="field_row width100">

                    <div class="field_row width100">

                        <div class="width2 float_left">
                            <div class="field_lable float_left width33"> <label for="amount">Expected Date of Delivery<span class="md_field">*</span></label></div>
                            <div class="width50 float_left">

                                <input name="ind[req_expected_date_time]" tabindex="20" class="form_input mi_timecalender filter_required" placeholder="Date Time" type="text"  data-errors="{filter_required:'Expected Date of delivery should not be blank!'}" value="<?= @$indent_data[0]->of_card_date; ?>"  <?php echo $update; ?>>

                            </div>
                        </div>
                        <div class="width2 float_left">
                            <div class="field_lable float_left width33"> <label for="mt_remark">Remark<span class="md_field"></span></label></div>


                            <div class="filed_input float_left width50" >
                                <textarea style="height:60px;" name="maintaince[mt_remark]" class="" TABINDEX="16" data-maxlen="1600"  data-errors="{filter_required:'Remark should not be blank'}" <?php echo $update;
                        echo $approve; ?>><?= @$preventive[0]->mt_remark; ?></textarea>
                            </div>
                        </div>

                    </div>

                    <div class="button_field_row  margin_auto float_left width100 text_align_center">
                        <div class="button_box">

                            <input type="button" name="submit" value="<?php if ($update) { ?>Update<?php } else { ?>Submit<?php } ?>" class="btn submit_btnt1 form-xhttp-request accept_btn1 inc_confirm_button1" data-href='<?php echo base_url(); ?>maintenance_part/<?php if ($update) { ?>edit_indent_request<?php } else { ?>maintenance_part_request_save<?php } ?>' data-qr='output_position=content&amp;prof=<?php echo @$prof; ?>&amp;module_name=clg&amp;tlcode=<?php if ($update) { ?>MT-CLG-UPDATE<?php } else { ?>MT-CLG-ADD<?php } ?>&amp;page_no=<?php echo @$page_no; ?>&ampshowprocess=yes'  TABINDEX="23" id="<?php echo @$current_data[0]->clg_ref_id; ?>">
                            <!--<input type="reset" name="reset" value="Reset" class="btn reset_btn register_view_reset"  TABINDEX="24">-->       

                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
</form>
<div id="hidden_maintence_part">
<div id="CA_tmp" class="hide">



    <div class="CA_blk blk ind_class"><div class="width100 display_inlne_block"><div class="remove_button_ind" style="float:right; cursor: pointer; height: 20px; width: 70px;">Remove</div></div><div class="field_row"><div class="filed_input"><input type="text" name="req[Force][indx][id]" tabindex="1" value="" class="autocls width100" data-href="<?php echo base_url() ?>auto/get_maintance_part_items/Force/dp"  data-qr="output_position=content" placeholder="Item Name" data-auto="CA" data-nonedit="yes" id="CAI_indx" data-callback-funct="CAReq"></div></div><div class="field_row"><div class="filed_input"><input type="text" name="req[Force][indx][qty]" tabindex="1" value="" class="width1 filter_if_not_empty[CAI_indx] filter_required filter_number" data-errors="{filter_if_not_empty:'Item quantity should not be blank',filter_required:'Item quantity should not be blank','filter_number':'Item quantity should be in numbers'}" placeholder="Item Quantity" ></div></div></div>

</div>

<div id="NCA_tmp" class="hide">

    <div class="NCA_blk blk ind_class"><div class="width100 display_inlne_block"><div class="remove_button_ind" style="float:right; cursor: pointer; height: 20px; width: 70px;">Remove</div></div><div class="field_row"><div class="filed_input"><input type="text" name="req[Ashok_Leyland][indx][id]" tabindex="1" value="" class="autocls width100" data-href="<?php echo base_url() ?>auto/get_maintance_part_items/Ashok Leyland/dp"  data-qr="" placeholder="Item Name" data-auto="NCA" data-nonedit="yes" id="NCAI_indx" data-callback-funct="NCAReq"></div></div><div class="field_row"><div class="filed_input"><input type="text" name="req[Ashok_Leyland][indx][qty]" tabindex="1" value="" class="width1 filter_if_not_empty[NCAI_indx] filter_required filter_number" data-errors="{filter_if_not_empty:'Item quantity should not be blank',filter_required:'Item quantity should not be blank','filter_number':'Item quantity should be in numbers'}" placeholder="Item Quantity"></div></div></div>

</div>
</div>