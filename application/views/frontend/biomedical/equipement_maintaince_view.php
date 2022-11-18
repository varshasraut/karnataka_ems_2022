<script>

    // initAutocomplete();

</script>


<div id="dublicate_id"></div>

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
                        <div class="filed_lable float_left width33 strong"><label for="station_name">State</div>

                        <div class="filed_input float_left width50">

                            <?= @$equipment_data[0]->st_name ?>

                        </div>
                    </div>   <div class="width2 float_left">

                        <div class="field_lable float_left width33 strong"> <label for="district">District</label></div>
                        <div class="filed_input float_left width50">

                            <?= @$equipment_data[0]->dst_name; ?>



                        </div>
                    </div>
                </div>

                <div class="field_row width100">

                    <div class="width2 float_left">
                        <div class="field_lable float_left width33 strong"><label for="district">Ambulance Number</label></div>
                        <div class="filed_input float_left width50"> <div id="incient_state">

                                <?= @$equipment_data[0]->eq_amb_ref_no; ?>



                            </div>

                        </div>

                    </div>
                    <div class="width2 float_left">    
                        <div class="field_lable float_left width33 strong"><label for="district">Base Location</label></div> 
                        <div class="filed_input float_left width50">
                            <?= @$equipment_data[0]->eq_base_location; ?>
                        </div>
                    </div>
                </div>
                <div class="field_row width100">
                <div class="width2 float_left">
                            <div class="field_lable float_left width33 strong"><label for="city">Breakdown date<span class="md_field">*</span></label></div>

                            <div class="filed_input float_left width50">

                                    <?= @$equipment_data[0]->mt_breakdown_date;?>
                                

                            </div>
                        </div>
                        <div class="width2 float_left">
                            <div class="field_lable float_left width33 strong"><label for="work_shop">Estimate Cost<span class="md_field">*</span></label></div>

                            <div class="filed_input float_left width50">
                              
                            <?= @$equipment_data[0]->mt_estimatecost;?>
                            </div>
                        </div>

                    </div>
                <div class="field_row width100">
                    <div class="width2 float_left">

                        <div class="field_lable float_left width33 strong"> <label for="mobile_no">Shift Type</label></div>


                        <div class="filed_input float_left width50">
                            <?php echo show_shift_type(@$equipment_data[0]->eq_shift_type); ?>


                        </div>
                    </div> 
                    <div class="width2 float_left">

                        <div class="field_lable float_left width33 strong"> <label for="equipment">Equipments</label></div>


                        <div class="filed_input float_left width50">
                            <?= @$equipment_data[0]->eqp_name; ?>
                        </div>
                    </div> 
                </div>



                <div class="field_row width100">

                    <div class="width2 float_left">
                        <div class="field_lable float_left width33 strong"> <label for="mobile_no">Due Date Time</label></div>


                        <div class="filed_input float_left width50">
                            <?= @$equipment_data[0]->eq_due_date_time; ?>

                        </div>
                    </div>
                    <div class=" float_left width2">

                        <div class="field_lable float_left width33 strong"> <label for="mt_stnd_remark">Standard Remark</label></div>


                        <div class="filed_input float_left width50">

                            <?php
                            if (@$equipment_data[0]->eq_standard_remark == 'request_send') {
                                echo "Equipment Maintenance send sucessfully.";
                            }
                            ?>
                        </div>
                    </div>


                </div>
                <div class="field_row width100">




                    <?php if (@$equipment_data[0]->mt_on_remark != '') { ?>
                        <div class="width2 float_left">
                            <div class="field_lable float_left width33 strong"> <label for="mt_on_remark">Remark</label></div>


                            <div class="filed_input float_left width50" >

                                <?= @$equipment_data[0]->eq_other_remark; ?>
                            </div>
                        </div>
                    <?php } ?>
                </div>




                <div class="field_row width100">

                    <?php if (@$equipment_data[0]->eq_completed_date_time != '') { ?>
                        <div class="width2 float_left">

                            <div class="field_lable float_left width33 strong"><label for="mt_onroad_datetime">Completed Date/Time</label></div>

                            <div class="filed_input float_left width50" >
                                <?= @$equipment_data[0]->eq_completed_date_time; ?>



                            </div>
                        </div>
                    <?php } ?>

                    <?php if (@$equipment_data[0]->eq_manager_name != '') { ?>
                        <div class="width2 float_left">

                            <div class="field_lable float_left width33 strong"><label for="mt_onroad_datetime">Manager name</label></div>

                            <div class="filed_input float_left width50" >
                                <?= @$equipment_data[0]->eq_manager_name; ?>



                            </div>
                        </div>
                    <?php } ?>
                </div>
                <div class="field_row width100">
                    <?php if (@$equipment_data[0]->eq_remark != '') { ?>
                        <div class="width2 float_left">
                            <div class="field_lable float_left width33 strong"> <label for="mt_on_remark">Remark</label></div>
                            <div class="filed_input float_left width50" >
                                <?= @$equipment_data[0]->eq_remark; ?>
                            </div>
                        </div>
                    <?php } ?>
                </div>
                </form>

