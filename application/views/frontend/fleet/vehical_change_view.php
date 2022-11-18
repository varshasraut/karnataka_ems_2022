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

                            <?= $vehical_data[0]->st_name ?>

                        </div>
                    </div>   <div class="width2 float_left">

                        <div class="field_lable float_left width33 strong"> <label for="district">District</label></div>
                        <div class="filed_input float_left width50">

                            <?= $vehical_data[0]->dst_name; ?>



                        </div>
                    </div>
                </div>

                <div class="field_row width100">

                    <div class="width2 float_left">
                        <div class="field_lable float_left width33 strong"><label for="district">Ambulance Number</label></div>
                        <div class="filed_input float_left width50"> <div id="incient_state">

                                <?= $vehical_data[0]->vl_amb_ref_no; ?>



                            </div>

                        </div>

                    </div>
                    <div class="width2 float_left">    
                        <div class="field_lable float_left width33 strong"><label for="district">Base Location</label></div> 
                        <div class="filed_input float_left width50">
                            <?= $vehical_data[0]->vl_base_location; ?>
                        </div>
                    </div>
                </div>
                <div class="field_row width100">
                    <div class="width2 float_left">

                        <div class="field_lable float_left width33 strong"> <label for="mobile_no">Shift Type</label></div>


                        <div class="filed_input float_left width50">
                            <?php echo show_shift_type($vehical_data[0]->vl_shift_type); ?>


                        </div>
                    </div> 

                    <div class="width2 float_left">
                        <div class="field_lable float_left width33 strong"> <label for="mobile_no">Address</label></div>


                        <div class="filed_input float_left width50">
                            <?= $vehical_data[0]->vl_google_address; ?>


                        </div>
                    </div>

                </div>



                <div class="field_row width100">


                    <div class="field_lable float_left width_16 strong"> <label for="mobile_no">Reason for Change</label></div>


                    <div class="filed_input float_left width50">
                        <?= $vehical_data[0]->vl_reason_for_change; ?>
                    </div>


                </div>
                <div class="field_row width100">
                    <div class="width2 float_left">
                        <div class="field_lable float_left width33 strong"> <label for="mobile_no">Expected Date / Time</label></div>


                        <div class="filed_input float_left width50">
                            <?= $vehical_data[0]->vl_expecteed_date_time; ?>

                        </div>
                    </div>
                    <div class="width2 float_left">
                        <div class="field_lable float_left width33 strong"> <label for="mobile_no">Standard Remark</label></div>


                        <div class="filed_input float_left width50">
                            <?php
                            if ($vehical_data[0]->vl_standard_remark == 'ambulance_location_change') {
                                echo 'Ambulance location Changed';
                            }
                            ?>


                        </div>
                    </div>

                </div>
                <div class="field_row width100">

                    <div class="width2 float_left">
                        <div class="field_lable float_left width33 strong"> <label for="mobile_no">Previous Odometer</label></div>


                        <div class="filed_input float_left width50">
<?= $vehical_data[0]->vl_previous_odometer; ?>

                        </div>
                    </div>
                    <div class="width2 float_left">
                        <div class="field_lable float_left width33 strong"> <label for="mobile_no">In Odometer </label></div>


                        <div class="filed_input float_left width50">
<?= $vehical_data[0]->vl_in_odometer; ?>

                        </div>
                    </div>


                </div>


                <div class="field_row width100">
<?php if ($vehical_data[0]->vl_end_odometer != '') { ?>
                        <div class="width2 float_left">
                            <div class="field_lable float_left width33 strong"> <label for="mobile_no">End Odometer</label></div>


                            <div class="filed_input float_left width50">
    <?= $vehical_data[0]->vl_end_odometer; ?>

                            </div>
                        </div>
<?php } ?>

                </div>

                <div class="field_row width100">

<?php if ($vehical_data[0]->vl_on_road_ambulance != '' && $vehical_data[0]->vl_on_road_ambulance != '0000-00-00 00:00:00') { ?>
                        <div class="width2 float_left">
                            <div class="field_lable float_left width33 strong"> <label for="mobile_no">Date Time</label></div>


                            <div class="filed_input float_left width50">
    <?= $vehical_data[0]->vl_on_road_ambulance;
    ?>


                            </div>
                        </div>
                    <?php } ?>

<?php if ($vehical_data[0]->vl_on_remark != '') { ?>
                        <div class="width2 float_left">
                            <div class="field_lable float_left width33 strong"> <label for="mobile_no">Remark</label></div>


                            <div class="filed_input float_left width50">
    <?= $vehical_data[0]->vl_on_remark;
    ?>


                            </div>
                        </div>
<?php } ?>
                </div>
                <div class="field_row width100">


<?php if ($vehical_data[0]->vl_current_google_address != '') { ?>
                        <div class="width2 float_left">
                            <div class="field_lable float_left width33 strong"> <label for="mobile_no">Current Address</label></div>


                            <div class="filed_input float_left width50">
    <?= $vehical_data[0]->vl_current_google_address;
    ?>


                            </div>
                        </div>
<?php } ?>
                </div>
                </form>

