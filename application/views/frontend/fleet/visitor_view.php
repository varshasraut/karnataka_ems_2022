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

                            <?= @$visitor_data[0]->st_name ?>

                        </div>
                    </div>   <div class="width2 float_left">

                        <div class="field_lable float_left width33 strong"> <label for="district">District</label></div>
                        <div class="filed_input float_left width50">

                            <?= @$visitor_data[0]->dst_name; ?>



                        </div>
                    </div>
                </div>

                <div class="field_row width100">

                    <div class="width2 float_left">
                        <div class="field_lable float_left width33 strong"><label for="district">Ambulance Number</label></div>
                        <div class="filed_input float_left width50"> <div id="incient_state">

                                <?= @$visitor_data[0]->vs_amb_ref_number; ?>



                            </div>

                        </div>

                    </div>
                    <div class="width2 float_left">    
                        <div class="field_lable float_left width33 strong"><label for="district">Base Location</label></div> 
                        <div class="filed_input float_left width50">
                            <?= @$visitor_data[0]->vs_base_location; ?>
                        </div>
                    </div>
                </div>
                <div class="field_row width100">
                    <div class="width2 float_left">

                        <div class="field_lable float_left width33 strong"> <label for="mobile_no">Shift Type</label></div>


                        <div class="filed_input float_left width50">

                            <?php echo show_shift_type(@$visitor_data[0]->vs_shift_type); ?>

                        </div>
                    </div>
                    <div class="width2 float_left">

                        <div class="field_lable float_left width33 strong"> <label for="mobile_no">Visitor Name</label></div>


                        <div class="filed_input float_left width50">
                            <?= @$visitor_data[0]->vs_visitor_name; ?>
                        </div>
                    </div>
                </div>
                <div class="field_row width100">
                    <div class="width2 float_left">
                        <div class="field_lable float_left width33 strong"> <label for="mobile_no">Desigation</label></div>


                        <div class="filed_input float_left width50">
                            <?= @$visitor_data[0]->vs_designation; ?>

                        </div>
                    </div>
                    <div class="width2 float_left">
                        <div class="field_lable float_left width33 strong"> <label for="mobile_no">Organisation</label></div>


                        <div class="filed_input float_left width50">
                            <?= @$visitor_data[0]->vs_oragnization; ?>

                        </div>
                    </div>

                </div>


                <div class="field_row width100">
                    <div class="width2 float_left">
                        <div class="field_lable float_left width33 strong"> <label for="mobile_no">Contact Number</label></div>


                        <div class="filed_input float_left width50">
                            <?= @$visitor_data[0]->vs_contact_number; ?>

                        </div>
                    </div>
                    <div class="width2 float_left">
                        <div class="field_lable float_left width33 strong"> <label for="mobile_no">Email</label></div>


                        <div class="filed_input float_left width50">
                            <?= @$visitor_data[0]->vs_email; ?>


                        </div>
                    </div>


                </div>
                <div class="field_row width100">


                    <div class="field_lable float_left width_16 strong"> <label for="mobile_no">Address</label></div>


                    <div class="filed_input float_left width50">
                        <?= @$visitor_data[0]->vs_addres; ?>
                    </div>


                </div>
                <div class="field_row width100">
                    <div class="width2 float_left">
                        <div class="field_lable float_left width33 strong"> <label for="mobile_no">Supervisor</label></div>


                        <div class="filed_input float_left width50">
                            <?= @$visitor_data[0]->vs_supervisor; ?>

                        </div>
                    </div>
                    <div class="width2 float_left">
                        <div class="field_lable float_left width33 strong"> <label for="mobile_no">District Manager</label></div>


                        <div class="filed_input float_left width50">
                            <?= @$visitor_data[0]->vs_district_manager; ?>

                        </div>
                    </div>

                </div>
                <div class="field_row width100">
                    <div class="width2 float_left">
                        <div class="field_lable float_left width33 strong"> <label for="mobile_no">Purpose Of Visit </label></div>


                        <div class="filed_input float_left width50">
                            <?= @$visitor_data[0]->vs_purposr_visit; ?>

                        </div>
                    </div>
                    <div class="width2 float_left">
                        <div class="field_lable float_left width33 strong"> <label for="mobile_no">Visited Date Time</label></div>


                        <div class="filed_input float_left width50">
                            <?= @$visitor_data[0]->vs_visited_datetime; ?>

                        </div>
                    </div>

                </div>
                <div class="field_row width100">
                    <div class="width2 float_left">
                        <div class="field_lable float_left width33 strong"> <label for="mobile_no">Standard Remark </label></div>


                        <div class="filed_input float_left width50">
                            <?php
                            if ($visitor_data[0]->vs_standard_remark == 'visitor_update') {
                                echo 'Visitor Updated';
                            } else {
                                echo 'other';
                            }
                            ?>


                        </div>
                    </div>
                    <div class="width2 float_left">
                        <div class="field_lable float_left width33 strong"> <label for="mobile_no">Remark</label></div>


                        <div class="filed_input float_left width50">
                            <?= @$visitor_data[0]->vs_remark; ?>

                        </div>
                    </div>

                </div>
                </form>

