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

                            <?= @$scene_data[0]->st_name ?>

                        </div>
                    </div>   <div class="width2 float_left">

                        <div class="field_lable float_left width33 strong"> <label for="district">District</label></div>
                        <div class="filed_input float_left width50">

                            <?= @$scene_data[0]->dst_name; ?>



                        </div>
                    </div>
                </div>

                <div class="field_row width100">

                    <div class="width2 float_left">
                        <div class="field_lable float_left width33 strong"><label for="district">Ambulance Number</label></div>
                        <div class="filed_input float_left width50"> <div id="incient_state">

                                <?= @$scene_data[0]->cs_amb_ref_no; ?>



                            </div>

                        </div>

                    </div>
                    <div class="width2 float_left">    
                        <div class="field_lable float_left width33 strong"><label for="district">Base Location</label></div> 
                        <div class="filed_input float_left width50">
                            <?= @$scene_data[0]->cs_base_location; ?>
                        </div>
                    </div>
                </div>
                       <div class="field_row width100">
                    <div class="width2 float_left">

                        <div class="field_lable float_left width33 strong"> <label for="mobile_no">Add Challenge</label></div>


                        <div class="filed_input float_left width50">
                            <?= @$scene_data[0]->cs_challenge; ?>
                        </div>
                    </div>
                   
                </div>
                <div class="field_row width100">
                    <div class="width2 float_left">

                        <div class="field_lable float_left width33 strong"> <label for="mobile_no">Shift Type</label></div>


                        <div class="filed_input float_left width50">
                            <?php echo show_shift_type(@$scene_data[0]->cs_shift_type); ?>
                        </div>
                    </div>
                    <div class="width2 float_left">

                        <div class="field_lable float_left width33 strong"> <label for="mobile_no">Pilot Id</label></div>


                        <div class="filed_input float_left width50">
                            <?= @$scene_data[0]->cs_pilot_id; ?>
                        </div>
                    </div>
                </div>
         
                <div class="field_row width100">
                    <div class="width2 float_left">
                        <div class="field_lable float_left width33 strong"> <label for="mobile_no">Pilot Name</label></div>


                        <div class="filed_input float_left width50">
                            <?= @$scene_data[0]->cs_pilot_name; ?>

                        </div>
                    </div>
                    <div class="width2 float_left">
                        <div class="field_lable float_left width33 strong"> <label for="mobile_no">EMT Id</label></div>


                        <div class="filed_input float_left width50">
                            <?= @$scene_data[0]->cs_emso_id; ?>

                        </div>
                    </div>

                </div>


                <div class="field_row width100">
                    <div class="width2 float_left">
                        <div class="field_lable float_left width33 strong"> <label for="mobile_no">EMT Name</label></div>


                        <div class="filed_input float_left width50">
                            <?= @$scene_data[0]->cs_emso_name; ?>

                        </div>
                    </div>
                    <div class="width2 float_left">
                        <div class="field_lable float_left width33 strong"> <label for="mobile_no">Supervisor Name</label></div>


                        <div class="filed_input float_left width50">
                            <?= @$scene_data[0]->cs_supervisor_mananger; ?>


                        </div>
                    </div>


                </div>
                <div class="field_row width100">

                    <div class="width2 float_left">
                        <div class="field_lable float_left width_16 strong"> <label for="mobile_no">Place</label></div>


                        <div class="filed_input float_left width50">
                            <?= @$scene_data[0]->cs_place; ?>
                        </div> </div>
                    <div class="width2 float_left">
                        <div class="field_lable float_left width33 strong"> <label for="mobile_no">Incident type</label></div>


                        <div class="filed_input float_left width50">
                            <?= @$scene_data[0]->cs_incident_type; ?>

                        </div>
                    </div>

                </div>
                <div class="field_row width100">

                    <div class="width2 float_left">
                        <div class="field_lable float_left width33 strong"> <label for="mobile_no">No of patients</label></div>


                        <div class="filed_input float_left width50">
                            <?= @$scene_data[0]->cs_no_of_patient; ?>

                        </div>
                    </div>
                    <div class="width2 float_left">
                        <div class="field_lable float_left width33 strong"> <label for="mobile_no">Police </label></div>


                        <div class="filed_input float_left width50">
                            <?= @$scene_data[0]->cs_police; ?>

                        </div>
                    </div>

                </div>
                <div class="field_row width100">

                    <div class="width2 float_left">
                        <div class="field_lable float_left width33 strong"> <label for="mobile_no">Fire</label></div>


                        <div class="filed_input float_left width50">
                            <?= @$scene_data[0]->cs_fire; ?>

                        </div>
                    </div>
                    <div class="width2 float_left">
                        <div class="field_lable float_left width33 strong"> <label for="mobile_no">Relatives </label></div>


                        <div class="filed_input float_left width50">
                            <?= @$scene_data[0]->cs_relatives; ?>

                        </div>
                    </div>

                </div>
                <div class="field_row width100">

                    <div class="width2 float_left">
                        <div class="field_lable float_left width33 strong"> <label for="mobile_no">By-stander </label></div>


                        <div class="filed_input float_left width50">
                            <?= @$scene_data[0]->cs_by_stander; ?>

                        </div>
                    </div><div class="width2 float_left">
                        <div class="field_lable float_left width33 strong"> <label for="mobile_no">Action Taken </label></div>
                        <div class="filed_input float_left width50">
                            <?= @$scene_data[0]->cs_action_taken; ?>
                        </div>
                    </div>


                </div>

                <div class="field_row width100">
                    <div class="width2 float_left">
                        <div class="field_lable float_left width33 strong"> <label for="mobile_no">Standard Remark </label></div>


                        <div class="filed_input float_left width50">
                            <?php
                            if (@$scene_data[0]->cs_standard_remark == 'scene_challeges_register') {
                                echo "Scene Challenges Register";
                            }
                            ?>


                        </div>
                    </div>
                    <div class="width2 float_left">
                        <div class="field_lable float_left width33 strong"> <label for="mobile_no">Remark</label></div>


                        <div class="filed_input float_left width50">
                            <?= @$scene_data[0]->cs_remark; ?>

                        </div>
                    </div>

                </div>
                <div class="field_row width100">
                    <?php if (@$scene_data[0]->cs_date_time != '') { ?>
                        <div class="width2 float_left">
                            <div class="field_lable float_left width33 strong"> <label for="mobile_no">Date Time</label></div>


                            <div class="filed_input float_left width50">
                                <?= @$scene_data[0]->cs_date_time;
                                ?>


                            </div>
                        </div>
                    <?php
                    }
                    if (@$scene_data[0]->cs_action != '') {
                        ?>
                        <div class="width2 float_left">
                            <div class="field_lable float_left width33 strong"> <label for="mobile_no">Action</label></div>


                            <div class="filed_input float_left width50">
    <?= @$scene_data[0]->cs_action; ?>

                            </div>
                        </div>
<?php } ?>
                </div>
                <div class="field_row width100">
<?php if (@$scene_data[0]->cs_district_manager != '') { ?>
                        <div class="width2 float_left">
                            <div class="field_lable float_left width33 strong"> <label for="mobile_no">District Manager Name</label></div>


                            <div class="filed_input float_left width50">
                                <?= @$scene_data[0]->cs_district_manager;
                                ?>


                            </div>
                        </div>
                    <?php } ?>
<?php if (@$scene_data[0]->cs_cur_remark != '') { ?>
                        <div class="width2 float_left">
                            <div class="field_lable float_left width33 strong"> <label for="mobile_no">Remark</label></div>


                            <div class="filed_input float_left width50">
                                <?= @$scene_data[0]->cs_cur_remark;
                                ?>


                            </div>
                        </div>
<?php } ?>
                </div>
                </form>

