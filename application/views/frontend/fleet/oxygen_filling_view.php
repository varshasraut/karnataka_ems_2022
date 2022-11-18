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

                            <?= @$oxygen_data[0]->st_name; ?>

                        </div>
                    </div>   <div class="width2 float_left">

                        <div class="field_lable float_left width33 strong"> <label for="district">District</label></div>
                        <div class="filed_input float_left width50">

                            <?= @$oxygen_data[0]->dst_name; ?>



                        </div>
                    </div>
                </div>

                <div class="field_row width100">

                    <div class="width2 float_left">
                        <div class="field_lable float_left width33 strong"><label for="district">Ambulance Number</label></div>
                        <div class="filed_input float_left width50"> <div id="incient_state">

                                <?= @$oxygen_data[0]->of_amb_ref_no; ?>



                            </div>

                        </div>

                    </div>
                    <div class="width2 float_left">    
                        <div class="field_lable float_left width33 strong"><label for="district">Base Location</label></div> 
                        <div class="filed_input float_left width50">
                            <?= @$oxygen_data[0]->of_base_location; ?>
                        </div>
                    </div>
                </div>
                <div class="field_row width100">
                    <div class="width2 float_left">

                        <div class="field_lable float_left width33 strong"> <label for="mobile_no">Shift Type</label></div>


                        <div class="filed_input float_left width50">
                            <?php echo show_shift_type(@$oxygen_data[0]->of_shift_type); ?>


                        </div>
                    </div> 

                    <div class="width2 float_left">
                        <div class="field_lable float_left width33 strong"> <label for="mobile_no">Oxygen station</label></div>


                        <div class="filed_input float_left width50">
                            <?= @$oxygen_data[0]->os_oxygen_name; ?>


                        </div>
                    </div>

                </div>

                <div class="field_row width100">

<div class="width2 float_left">

    <div class="field_lable float_left width33 strong"> <label for="mobile_no">Pilot Id</label></div>


    <div class="filed_input float_left width50">
        <?= @$oxygen_data[0]->of_pilot_id; ?>
    </div>
</div>
<div class="width2 float_left">
    <div class="field_lable float_left width33 strong"> <label for="mobile_no">Pilot Name</label></div>


    <div class="filed_input float_left width50">
        <?= @$oxygen_data[0]->of_pilot_name; ?>

    </div>
</div>
</div>

                <div class="field_row width100">

                    <div class="width2 float_left">
                        <div class="field_lable float_left width33 strong"> <label for="mobile_no">Cylinder Type</label></div>


                        <div class="filed_input float_left width50">
                            <?= @$oxygen_data[0]->of_cylinder_type; ?>
                        </div>
                    </div>
                    <div class="width2 float_left">
                        <div class="field_lable float_left width33 strong"> <label for="mobile_no">Oxygen amount</label></div>


                        <div class="filed_input float_left width50">
                            <?= @$oxygen_data[0]->of_oxygen_amount; ?>

                        </div>
                    </div>


                </div>
                <div class="field_row width100">

                    <div class="width2 float_left">
                        <div class="field_lable float_left width33 strong"> <label for="mobile_no">Oxygen Quantity</label></div>


                        <div class="filed_input float_left width50">
                            <?= @$oxygen_data[0]->of_oxygen_quantity; ?>

                        </div>
                    </div>
                    <div class="width2 float_left">
                        <div class="field_lable float_left width33 strong"> <label for="mobile_no">Filling date</label></div>


                        <div class="filed_input float_left width50">
                            <?= @$oxygen_data[0]->of_filling_date; ?>

                        </div>
                    </div>
                     

                </div>
                <div class="field_row width100">
                   
                    <div class="width2 float_left">
                        <div class="field_lable float_left width33 strong"> <label for="mobile_no">Previous Odometer</label></div>


                        <div class="filed_input float_left width50">
                            <?= @$oxygen_data[0]->of_prevoius_odometer; ?>

                        </div>
                    </div>
                     <div class="width2 float_left">
                        <div class="field_lable float_left width33 strong"> <label for="mobile_no">Current Odometer </label></div>


                        <div class="filed_input float_left width50">
                            <?= @$oxygen_data[0]->of_in_odometer; ?>

                        </div>
                    </div>


                </div>
            

                <div class="field_row width100">
                    
                        <!-- <div class="width2 float_left">
                        <div class="field_lable float_left width33 strong"> <label for="mobile_no">Card Date</label></div>


                        <div class="filed_input float_left width50">
                            <?= @$oxygen_data[0]->of_card_date; ?>

                        </div>
                    </div> -->
                    <div class="width2 float_left">
                        <div class="field_lable float_left width33 strong"> <label for="mobile_no">Payment Mode</label></div>


                        <div class="filed_input float_left width50">
                            <?= @$oxygen_data[0]->of_payment_mode; ?>

                        </div>
                    </div>
                    <div class="width2 float_left">
                        <div class="field_lable float_left width33 strong"> <label for="mobile_no">Voucher No</label></div>


                        <div class="filed_input float_left width50">
                            <?= @$oxygen_data[0]->of_voucher_no; ?>

                        </div>
                    </div>
                </div>
                <div class="field_row width100">
                
                   
                     <div class="width2 float_left">
                        <div class="field_lable float_left width33 strong"> <label for="mobile_no">District Manager</label></div>


                        <div class="filed_input float_left width50">
                            <?= @$oxygen_data[0]->clg_first_name." ".@$oxygen_data[0]->clg_last_name ; ?>

                        </div>
                    </div>

                </div>
                   <div class="field_row width100">
                    <?php if (@$oxygen_data[0]->of_end_odometer != '') { ?>
                        <div class="width2 float_left">
                            <div class="field_lable float_left width33 strong"><label for="end_odometer">End Odometer</label></div>

                            <div class="filed_input float_left width50" >

                                <?= @$oxygen_data[0]->of_end_odometer; ?>
                            </div>
                        </div>
                    <?php } ?>
                    <?php if (@$oxygen_data[0]->of_on_road_ambulance != '') { ?>
                        <div class="width2 float_left">

                            <div class="field_lable float_left width33 strong"><label for="mt_onroad_datetime">Date/Time</label></div>

                            <div class="filed_input float_left width50" >
                                <?= @$oxygen_data[0]->of_on_road_ambulance; ?>



                            </div>
                        </div>
                    <?php } ?>
                </div>
                <div class="field_row width100">
                        <?php if (@$oxygen_data[0]->mt_on_stnd_remark != '') { ?>
                    <div class="filed_input float_left width2">

                        <div class="field_lable float_left width33 strong"> <label for="mt_stnd_remark">Standard Remark</label></div>


                        <div class="filed_input float_left width50">

                            <?php
                            if (@$oxygen_data[0]->mt_on_stnd_remark == 'ambulance_oxygen_filling') {
                                echo "Ambulance Oxygen Filling Done";
                            }
                            ?>
                        </div>
                    </div>
                      <?php } ?>
                    
                       <?php if (@$oxygen_data[0]->mt_on_remark != '') { ?>
                    <div class="width2 float_left">
                        <div class="field_lable float_left width33 strong"> <label for="mt_on_remark">Remark</label></div>


                        <div class="filed_input float_left width50" >

                            <?= @$oxygen_data[0]->mt_on_remark; ?>
                        </div>
                    </div>
                     <?php } ?>
                </div>
            
                </form>

