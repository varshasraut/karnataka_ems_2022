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

                            <?= @$ptn_data[0]->st_name ?>

                        </div>
                    </div>   <div class="width2 float_left">

                        <div class="field_lable float_left width33 strong"> <label for="district">District</label></div>
                        <div class="filed_input float_left width50">

                            <?= @$ptn_data[0]->dst_name; ?>



                        </div>
                    </div>
                </div>

                <div class="field_row width100">

                    <div class="width2 float_left">
                        <div class="field_lable float_left width33 strong"><label for="district">Ambulance Number</label></div>
                        <div class="filed_input float_left width50"> <div id="incient_state">

                                <?= @$ptn_data[0]->ph_amb_ref_no; ?>



                            </div>

                        </div>

                    </div>
                    <div class="width2 float_left">    
                        <div class="field_lable float_left width33 strong"><label for="district">Base Location</label></div> 
                        <div class="filed_input float_left width50">
                            <?= @$ptn_data[0]->ph_base_location; ?>
                        </div>
                    </div>
                </div>
                <div class="field_row width100">
                    <div class="width2 float_left">

                        <div class="field_lable float_left width33 strong"> <label for="mobile_no">Shift Type</label></div>


                        <div class="filed_input float_left width50">
                             <?php echo show_shift_type(@$ptn_data[0]->ph_shift_type); ?>
                        </div>
                    </div>
                    <div class="width2 float_left">

                        <div class="field_lable float_left width33 strong"> <label for="mobile_no">Pilot Id</label></div>


                        <div class="filed_input float_left width50">
                            <?= @$ptn_data[0]->ph_pilot_id; ?>
                        </div>
                    </div>
                </div>
                <div class="field_row width100">
                    <div class="width2 float_left">
                        <div class="field_lable float_left width33 strong"> <label for="mobile_no">Pilot Name</label></div>


                        <div class="filed_input float_left width50">
                            <?= @$ptn_data[0]->ph_pilot_name; ?>

                        </div>
                    </div>
                    <div class="width2 float_left">
                        <div class="field_lable float_left width33 strong"> <label for="mobile_no">EMT Id</label></div>


                        <div class="filed_input float_left width50">
                            <?= @$ptn_data[0]->ph_emso_id; ?>

                        </div>
                    </div>

                </div>


                <div class="field_row width100">
                    <div class="width2 float_left">
                        <div class="field_lable float_left width33 strong"> <label for="mobile_no">EMT Name</label></div>


                        <div class="filed_input float_left width50">
                            <?= @$ptn_data[0]->ph_emso_name; ?>

                        </div>
                    </div>
                    <div class="width2 float_left">
                        <div class="field_lable float_left width33 strong"> <label for="mobile_no">Manager Name</label></div>


                        <div class="filed_input float_left width50">
                                 <?= @$ptn_data[0]->ph_mananger_name; ?>


                        </div>
                    </div>


                </div>
                <div class="field_row width100">
                   
              <div class="width2 float_left">
                        <div class="field_lable float_left width_16 strong"> <label for="mobile_no">Hospital Name</label></div>


                        <div class="filed_input float_left width50">
                              <?= @$ptn_data[0]->hp_name; ?>
                        </div>
              </div>
                     <div class="width2 float_left">
                        <div class="field_lable float_left width33 strong"> <label for="mobile_no">Issue Type</label></div>


                        <div class="filed_input float_left width50">
                            <?= @$ptn_data[0]->ph_issue_type; ?>

                        </div>
                    </div>

                </div>
                <div class="field_row width100">
                   
                    <div class="width2 float_left">
                        <div class="field_lable float_left width33 strong"> <label for="mobile_no">Patient Name</label></div>


                        <div class="filed_input float_left width50">
                    <?= @$ptn_data[0]->ph_patient_name; ?>

                        </div>
                    </div>

                    <div class="width2 float_left">
                        <div class="field_lable float_left width33 strong"> <label for="mobile_no">Action </label></div>


                        <div class="filed_input float_left width50">
                            <?= @$ptn_data[0]->ph_action; ?>
	
                        </div>
                    </div>
                </div>
                <div class="field_row width100">
                    
                    <div class="width2 float_left">
                        <div class="field_lable float_left width33 strong"> <label for="mobile_no">Report To</label></div>


                        <div class="filed_input float_left width50">
                            <?= @$ptn_data[0]->ph_report_to; ?>

                        </div>
                    </div>
                    <div class="width2 float_left">
                        <div class="field_lable float_left width33 strong"> <label for="mobile_no">Communicated to Hospital </label></div>


                        <div class="filed_input float_left width50">
                            <?= @$ptn_data[0]->ph_comm_to_hosp; ?>
	
                        </div>
                    </div>

                </div>
                
                
                
                <div class="field_row width100">
                    <div class="width2 float_left">
                        <div class="field_lable float_left width33 strong"> <label for="mobile_no">Standard Remark </label></div>


                        <div class="filed_input float_left width50">
                              <?php
                            if (@$ptn_data[0]->ph_standard_remark == 'patient_handover_issue') {
                                echo "Patient handover issue register sucessfully";
                            }
                            ?>

                        </div>
                    </div>
                    <div class="width2 float_left">
                        <div class="field_lable float_left width33 strong"> <label for="mobile_no">Remark</label></div>


                        <div class="filed_input float_left width50">
                            <?= @$ptn_data[0]->ph_remark; ?>

                        </div>
                    </div>

                </div>
                 <div class="field_row width100">
                     <?php if (@$ptn_data[0]->ph_date_time != '') { ?>
                    <div class="width2 float_left">
                        <div class="field_lable float_left width33 strong"> <label for="mobile_no">Date Time</label></div>


                        <div class="filed_input float_left width50">
                            <?= @$ptn_data[0]->ph_date_time;                           
                            ?>


                        </div>
                    </div>
                        <?php }
                        if(@$ptn_data[0]->ph_update_action != ''){
                        ?>
                    <div class="width2 float_left">
                        <div class="field_lable float_left width33 strong"> <label for="mobile_no">Action</label></div>


                        <div class="filed_input float_left width50">
                            <?= @$ptn_data[0]->ph_update_action; ?>

                        </div>
                    </div>
                        <?php } ?>
                </div>
                 <div class="field_row width100">
                     <?php if (@$ptn_data[0]->ph_district_manager != '') { ?>
                    <div class="width2 float_left">
                        <div class="field_lable float_left width33 strong"> <label for="mobile_no">District Manager Name</label></div>


                        <div class="filed_input float_left width50">
                            <?= @$ptn_data[0]->ph_district_manager;                           
                            ?>


                        </div>
                    </div>
                        <?php }?>
                 </div>
                </form>

