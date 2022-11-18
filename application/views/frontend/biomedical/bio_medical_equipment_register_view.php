<script>
    //if(typeof H != 'undefined'){
    //init_auto_address();
    //}
</script>


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
                <div class="field_row width100  fleet">
                    <div class="single_record_back">Previous Info</div>
                </div>
            <?php } ?>
            <div class="width100">

                <div class="field_row width100">

                    <div class="width2 float_left">
                        <div class="field_lable float_left width33"><label for="district">State<span class="md_field">*</span></label></div>
                        <div class="filed_input float_left width50">
                            <div id="ambulance_state">



                                <?php
                                if (@$oxygen_data[0]->of_state_code != '') {
                                    $st = array('st_code' => @$oxygen_data[0]->of_state_code, 'auto' => 'inc_auto_addr', 'rel' => 'incient', 'disabled' => 'disabled');
                                } else {
                                    $st = array('st_code' => '', 'auto' => 'amb_auto_addr', 'rel' => 'incient', 'disabled' => '');
                                }


                                echo get_state_clo_comp_ambulance($st);
                                ?>

                            </div>

                        </div>

                    </div>
                    <div class="width2 float_left">
                        <div class="field_lable float_left width33"><label for="district">District<span class="md_field">*</span></label></div>
                        <div class="filed_input float_left width50">
                            <div id="incient_district">
                                <?php
                                if (@$oxygen_data[0]->of_state_code != '') {
                                    $dt = array('dst_code' => @$oxygen_data[0]->of_district_code, 'st_code' => @$oxygen_data[0]->of_state_code, 'auto' => 'inc_auto_addr', 'rel' => 'incient', 'disabled' => 'disabled');
                                } else {
                                    $dt = array('dst_code' => '', 'st_code' => '', 'auto' => 'amb_auto_addr', 'rel' => 'incient', 'disabled' => '');
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
                                if (@$oxygen_data[0]->of_state_code != '') {
                                    $dt = array('dst_code' => @$oxygen_data[0]->of_district_code, 'st_code' => @$oxygen_data[0]->of_state_code, 'amb_ref_no' => @$oxygen_data[0]->req_amb_reg_no, 'auto' => 'inc_auto_addr', 'rel' => 'incient', 'disabled' => 'disabled');
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
                            <input name="req[req_base_location]" tabindex="23" class="form_input filter_required" placeholder=" Base Location" type="text" data-base="search_btn" data-errors="{filter_required:'Base Location should not be blank!'}" value="<?= @$oxygen_data[0]->hp_name; ?>" readonly="readonly" <?php echo $update; ?>>

                        </div>


                    </div>
                    <div class="width2 float_left">
                        <div class="field_lable float_left width33"><label for="district">Ambulance Type<span class="md_field">*</span></label></div>


                        <div class="filed_input float_left width50" id="amb_type_div">
                            <select name="amb_type" class="filter_required" data-errors="{filter_required:'Ambulance type should not be blank'}" <?php echo $view; ?> TABINDEX="5">

                                <option value="">Select Type</option>

                                <?php echo get_amb_type($preventive[0]->ambt_name); ?>
                            </select>


                        </div>



                    </div>

                    <div class="width2 float_left">
                        <div class="field_lable float_left width33"><label for="city">Shift Type<span class="md_field">*</span></label></div>

                        <div class="filed_input float_left width50">
                            <select name="eqiup[req_shift_type]" tabindex="8" class="filter_required" data-errors="{filter_required:'Supervisor Name should not be blank!'}" <?php echo $update; ?>>
                                <option value="" <?php echo $disabled; ?>>Select Shift Type</option>
                                <?php echo get_shift_type(@$oxygen_data[0]->of_shift_type); ?>
                            </select>

                        </div>
                    </div>
                    <div class="field_row width100">

                        <div class="width1 float_left stock_req_form">

                            <div class="width90 float_left">


                                <fieldset>

                                    <legend>Equipments</legend>

                                    <div class="EQP_item text_align_center">

                                        <div class="EQP_blk">

                                            <div class="field_row">

                                                <div class="filed_input">


                                                    <input type="text" name="item[EQP][0][id]" tabindex="1" value="" class="mi_autocomplete filter_required" data-href="<?php echo base_url(); ?>auto/get_inv_eqp/dq/<?php echo $eqp_type; ?>" data-errors="{filter_required:'Equipments should not be blank!'}" placeholder="Equipment Name" autocomplete="off" data-auto="EQP" data-nonedit="yes" id="EQPI_0" data-callback-funct="EQPReq">


                                                </div>

                                            </div>


                                            <div class="field_row">

                                                <div class="filed_input">

                                                    <input type="text" name="item[EQP][0][qty]" tabindex="1" value="" class="filter_if_not_empty[EQPI_0] filter_required filter_number" data-errors="{filter_if_not_empty:'Item quantity should not be blank',filter_required:'Item quantity should not be blank','filter_number':'Item quantity should be in numbers'}" placeholder="Equipment Quantity">

                                                </div>

                                            </div>

                                        </div>


                                    </div>

                                    <div class="width1 text_align_center add_more_ind">

                                        <a class="EQP_more">Add more equipment +</a>

                                    </div>

                                </fieldset>



                            </div>

                        </div>
                    </div>

                    <div class="field_row width100">

                        <div class="width2 float_left">
                            <div class="field_lable float_left width33"> <label for="amount">Expected Date of delivery<span class="md_field">*</span></label></div>
                            <div class="width50 float_left">

                                <input id="offroad_datetime" name="eqiup[req_expected_date_time]" tabindex="20" class="form_input mi_timecalender filter_required  " placeholder="Date Time" type="text" data-errors="{filter_required:'Expected Date of Delivery should not be blank!'}" value="<?= $oxygen_data[0]->of_card_date; ?>" <?php echo $update; ?>>

                            </div>
                        </div>
                        <div class="width2 float_left">
                            <div class="field_lable float_left width33"> <label for="amount">Current Date & Time<span class="md_field">*</span></label></div>
                            <div class="width50 float_left">
                                <input id="mt_onroad_datetime" name="eqiup[req_cur_date_time]" tabindex="20" class="form_input mi_timecalender filter_required" placeholder="Date Time" type="text" data-errors="{filter_required:'Current date & time should not be blank!'}" value="<?php
                                                                                                                                                                                                                                                                                        if ($oxygen_data[0]->req_cur_date_time == '') {
                                                                                                                                                                                                                                                                                            echo date('Y-m-d h:i:s');
                                                                                                                                                                                                                                                                                        } else {
                                                                                                                                                                                                                                                                                            echo $oxygen_data[0]->req_cur_date_time;
                                                                                                                                                                                                                                                                                        }
                                                                                                                                                                                                                                                                                        ?>" <?php echo $update; ?>>
                            </div>
                        </div>

                    </div>
                    <div class="field_row width100">
                        <div class="width2 float_left">
                            <div class="field_lable float_left width33"> <label for="supervisor">Supervisor<span class="md_field">*</span></label></div>
                            <div class="filed_input float_left width50">
                                <!--                                <input name="eqiup[req_supervisor]" tabindex="20" class="form_input  filter_required" placeholder="Supervisor" type="text"  data-errors="{filter_required:'Supervisor should not be blank!'}" value="<?= @$oxygen_data[0]->of_filling_date; ?>"   <?php echo $update; ?>>-->
                                <?php if ($oxygen_data[0]->req_supervisor != '') {
                                    $req_supervisor_name = get_clg_name_by_ref_id($oxygen_data[0]->req_supervisor);
                                } ?>
                                <input name="eqiup[req_supervisor]" class="mi_autocomplete filter_required" data-href="<?php echo base_url(); ?>auto/get_auto_clg_dm?clg_group=UG-ZM" data-value="<?php echo $req_supervisor_name; ?>" value="<?= @$indent_data[0]->req_supervisor; ?>" type="text" tabindex="1" placeholder="Supervisor" data-errors="{filter_required:'Supervisor should not be blank!'}" data-qr='clg_group=UG-BioMedicalManagerSupervisor&amp;output_position=content' <?php echo $update; ?>>
                            </div>
                        </div>
                        <div class="width2 float_left">
                            <div class="field_lable float_left width33"> <label for="amount">District Manager<span class="md_field">*</span></label></div>
                            <div class="width50 float_left">

                                <!--                                <input name="eqiup[req_district_manager]" tabindex="20" class="form_input  filter_required" placeholder="District Manager" type="text"  data-errors="{filter_required:'District Manager should not be blank!'}" value="<?= @$oxygen_data[0]->of_card_date; ?>"  <?php echo $update; ?>>-->

                                <?php if ($oxygen_data[0]->req_district_manager != '') {
                                    $req_district_manager_name = get_clg_name_by_ref_id($oxygen_data[0]->req_district_manager);
                                } ?>
                                <input name="eqiup[req_district_manager]" class="mi_autocomplete filter_required" data-href="<?php echo base_url(); ?>auto/get_auto_clg_dm?clg_group=UG-DM" data-value="<?php echo $req_district_manager_name; ?>" value="<?= @$indent_data[0]->req_district_manager; ?>" type="text" tabindex="1" placeholder="District Manager" data-errors="{filter_required:'District Manager should not be blank!'}" data-qr='clg_group=UG-DIS-FILD-MANAGER&amp;output_position=content' <?php echo $update; ?>>

                            </div>
                        </div>

                    </div>
                    <div class="field_row width100">
                        <div class="filed_input float_left width2">

                            <div class="field_lable float_left width33"> <label for="mt_stnd_remark">Standard Remark<span class="md_field">*</span></label></div>


                            <div class="filed_input float_left width50">
                                <select name="eqiup[req_standard_remark]" tabindex="8" id="standard_remark" class="filter_required" data-errors="{filter_required:'Standard Remark should not be blank!'}">
                                    <option value="" <?php echo $disabled; ?>>Select Standard Remark</option>
                                    <option value="request_send" <?php
                                                                    if (@$oxygen_data[0]->req_standard_remark == 'request_send') {
                                                                        echo "selected";
                                                                    }
                                                                    ?>>Equipment request send successfully.</option>
                                    <!--                                    <option value="other"  <?php
                                                                                                    if (@$vehical_data[0]->req_standard_remark == 'other') {
                                                                                                        echo "selected";
                                                                                                    }
                                                                                                    ?>>other</option> -->
                                </select>
                            </div>
                        </div>
                        <div class="width2 float_left">
                            <div id="remark_other_textbox">
                            </div>
                        </div>
                    </div>




                    <div class="button_field_row  margin_auto float_left width100 text_align_center">
                        <div class="button_box">
                            <input type="hidden" name="eqiup[req_group]" value="EQUP">
                            <input type="button" name="submit" value="<?php if ($update) { ?>Update<?php } else { ?>Send Request<?php } ?>" class="btn submit_btnt form-xhttp-request" data-href='<?php echo base_url(); ?>biomedical/<?php if ($update) { ?>update_oxygen_filling<?php } else { ?>send_equipment_request<?php } ?>' data-qr='output_position=content&amp;prof=<?php echo @$prof; ?>&amp;module_name=clg&amp;tlcode=<?php if ($update) { ?>MT-CLG-UPDATE<?php } else { ?>MT-CLG-ADD<?php } ?>&amp;page_no=<?php echo @$page_no; ?>' TABINDEX="23">
                            <!--<input type="reset" name="reset" value="Reset" class="btn reset_btn register_view_reset"  TABINDEX="24">-->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

<div id="EQP_tmp" class="hide">

    <div class="EQP_blk blk ind_class">
        <div class="width100 display_inlne_block">
            <div class="remove_button_ind" style="float:right; cursor: pointer; height: 20px; width: 70px;">Remove</div>
        </div>
        <div class="field_row">
            <div class="filed_input"><input type="text" name="item[EQP][indx][id]" tabindex="1" value="" class="autocls width1" data-href="<?php echo base_url() ?>auto/get_inv_eqp/dq/<?php echo $eqp_type; ?>" placeholder="Equipment Name" autocomplete="off" data-auto="EQP" data-nonedit="yes" id="EQPI_indx" data-callback-funct="EQPReq"></div>
        </div>
        <div class="field_row">
            <div class="filed_input"><input type="text" name="item[EQP][indx][qty]" tabindex="1" value="" class="filter_if_not_empty[EQPI_indx] filter_required filter_number" data-errors="{filter_if_not_empty:'Item quantity should not be blank',filter_required:'Item quantity should not be blank','filter_number':'Item quantity should be in numbers'}" placeholder="Equipment Quantity"></div>
        </div>
    </div>

</div>
<script>
    jQuery(document).ready(function() {
        var $min = new Date();

        $('#offroad_datetime').datetimepicker({
            dateFormat: "yy-mm-dd ",
            // timeFormat: "hh:mm:ss",
            minDate: $min,
            // minTime: jsDate[1],

        });

        var jsDate = $("#offroad_datetime").val();
        var $mindate = new Date(jsDate);


        $('#mt_onroad_datetime').datetimepicker({
            dateFormat: "yy-mm-dd",
            minDate: $mindate,
            // minTime: jsDate[1],

        });
        $("#offroad_datetime").change(function() {


            var jsDate = $("#offroad_datetime").val();
            var $mindate = new Date(jsDate);


            $('.OnroadDate').datetimepicker({
                dateFormat: "yy-mm-dd ",
                minDate: $mindate,
                // minTime: jsDate[1],

            });
        });
    });
</script>