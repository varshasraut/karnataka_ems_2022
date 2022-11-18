
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

                            <?= @$demo_data[0]->st_name ?>

                        </div>
                    </div>   <div class="width2 float_left">

                        <div class="field_lable float_left width33 strong"> <label for="district">District</label></div>
                        <div class="filed_input float_left width50">

                            <?= @$demo_data[0]->dst_name; ?>



                        </div>
                    </div>
                </div>

                <div class="field_row width100">

                    <div class="width2 float_left">
                        <div class="field_lable float_left width33 strong"><label for="district">Ambulance Number</label></div>
                        <div class="filed_input float_left width50"> <div id="incient_state">

                                <?= @$demo_data[0]->dt_amb_ref_no; ?>



                            </div>

                        </div>

                    </div>
                    <div class="width2 float_left">    
                        <div class="field_lable float_left width33 strong"><label for="district">Base Location</label></div> 
                        <div class="filed_input float_left width50">
                            <?= @$demo_data[0]->dt_base_location; ?>
                        </div>
                    </div>
                </div>
                <div class="field_row width100">
                    <div class="width2 float_left">

                        <div class="field_lable float_left width33 strong"> <label for="mobile_no">Shift Type</label></div>


                        <div class="filed_input float_left width50">
                            <?php echo show_shift_type(@$demo_data[0]->dt_shift_type); ?>


                        </div>
                    </div>
                    <div class="width2 float_left">

                        <div class="field_lable float_left width33 strong"> <label for="mobile_no">Pilot Id</label></div>


                        <div class="filed_input float_left width50">
                            <?= @$demo_data[0]->dt_pilot_id; ?>
                        </div>
                    </div>
                </div>
                <div class="field_row width100">
                    <div class="width2 float_left">
                        <div class="field_lable float_left width33 strong"> <label for="mobile_no">Pilot Name</label></div>


                        <div class="filed_input float_left width50">
                            <?= @$demo_data[0]->dt_pilot_name; ?>

                        </div>
                    </div>
                    <div class="width2 float_left">
                        <div class="field_lable float_left width33 strong"> <label for="mobile_no">EMT Id</label></div>


                        <div class="filed_input float_left width50">
                            <?= @$demo_data[0]->dt_emso_id; ?>

                        </div>
                    </div>

                </div>


                <div class="field_row width100">
                    <div class="width2 float_left">
                        <div class="field_lable float_left width33 strong"> <label for="mobile_no">EMT Name</label></div>


                        <div class="filed_input float_left width50">
                            <?= @$demo_data[0]->dt_emso_name; ?>

                        </div>
                    </div>
                    <div class="width2 float_left">
                        <div class="field_lable float_left width33 strong"> <label for="mobile_no">District Manager</label></div>


                        <div class="filed_input float_left width50">
                            <?= @$demo_data[0]->dt_district_manager; ?>


                        </div>
                    </div>


                </div>
                <div class="field_row width100">


                    <div class="field_lable float_left width_16 strong"> <label for="mobile_no">Place</label></div>


                    <div class="filed_input float_left width50">
                        <?= @$demo_data[0]->dt_place; ?>
                    </div>


                </div>
                <div class="field_row width100">
                    <div class="width2 float_left">
                        <div class="field_lable float_left width33 strong"> <label for="mobile_no">No of candidate</label></div>


                        <div class="filed_input float_left width50">
                            <?= @$demo_data[0]->dt_no_of_candidate; ?>

                        </div>
                    </div>
                    <div class="width2 float_left">
                        <div class="field_lable float_left width33 strong"> <label for="mobile_no">Pupose of training / Demo</label></div>


                        <div class="filed_input float_left width50">
                            <?= @$demo_data[0]->dt_pupose_of_training; ?>

                        </div>
                    </div>

                </div>
                <div class="field_row width100">
                    <div class="width2 float_left">
                        <div class="field_lable float_left width33 strong"> <label for="mobile_no">Date / Time </label></div>


                        <div class="filed_input float_left width50">
                            <?= @$demo_data[0]->dt_start_date_time; ?>

                        </div>
                    </div>
                    <div class="width2 float_left">
                        <div class="field_lable float_left width33 strong"> <label for="mobile_no">Previous Odometer</label></div>


                        <div class="filed_input float_left width50">
                            <?= @$demo_data[0]->dt_previous_odometer; ?>

                        </div>
                    </div>

                </div>
                <div class="field_row width100">
                    <div class="width2 float_left">
                        <div class="field_lable float_left width33 strong"> <label for="mobile_no">Current Odometer </label></div>


                        <div class="filed_input float_left width50">
                            <?= @$demo_data[0]->dt_in_odometer; ?>

                        </div>
                    </div>



                </div>

                <div class="field_row width100">
                    <div class="width2 float_left">
                        <div class="field_lable float_left width33 strong"> <label for="mobile_no">Standard Remark </label></div>


                        <div class="filed_input float_left width50">

                            <?php
                            if (@$demo_data[0]->dt_standard_remark == 'demo_training_register_sucessfully') {
                                echo "Demo Training Register Sucessfully";
                            }
                            ?>
                        </div>
                    </div>
                    <div class="width2 float_left">
                        <div class="field_lable float_left width33 strong"> <label for="mobile_no">Remark</label></div>


                        <div class="filed_input float_left width50">
                            <?= @$demo_data[0]->dt_remark; ?>

                        </div>
                    </div>

                </div>

                <div class="field_row width100">
                    <?php if (@$demo_data[0]->dt_end_odometer != '') { ?>
                        <div class="width2 float_left">
                            <div class="field_lable float_left width33 strong"> <label for="mobile_no">End Odometer</label></div>


                            <div class="filed_input float_left width50">
                                <?= @$demo_data[0]->dt_end_odometer;
                                ?>


                            </div>
                        </div>
                    <?php } ?>
                    
                    <?php if (@$demo_data[0]->dt_current_date_time != '') { ?>
                        <div class="width2 float_left">
                            <div class="field_lable float_left width33 strong"> <label for="mobile_no">Date Time</label></div>


                            <div class="filed_input float_left width50">
                                <?= @$demo_data[0]->dt_current_date_time;
                                ?>


                            </div>
                        </div>
                    <?php } ?>
                    
                      <?php if (@$demo_data[0]->dt_current_remark != '') { ?>
                        <div class="width2 float_left">
                            <div class="field_lable float_left width33 strong"> <label for="mobile_no">Remark</label></div>


                            <div class="filed_input float_left width50">
                                <?= @$demo_data[0]->dt_current_remark;
                                ?>


                            </div>
                        </div>
                    <?php } ?>
                </div>
                </form>

