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

                            <?= @$fuel_data[0]->st_name; ?>

                        </div>
                    </div>   <div class="width2 float_left">

                        <div class="field_lable float_left width33 strong"> <label for="district">District</label></div>
                        <div class="filed_input float_left width50">

                            <?= @$fuel_data[0]->dst_name; ?>



                        </div>
                    </div>
                </div>

                <div class="field_row width100">

                    <div class="width2 float_left">
                        <div class="field_lable float_left width33 strong"><label for="district">Ambulance Number</label></div>
                        <div class="filed_input float_left width50"> <div id="incient_state">

                                <?= @$fuel_data[0]->ff_amb_ref_no; ?>



                            </div>

                        </div>

                    </div>
                    <div class="width2 float_left">    
                        <div class="field_lable float_left width33 strong"><label for="district">Base Location</label></div> 
                        <div class="filed_input float_left width50">
                            <?= @$fuel_data[0]->ff_base_location; ?>
                        </div>
                    </div>
                </div>
                <div class="field_row width100">

                    <div class="width2 float_left">

                        <div class="field_lable float_left width33 strong"> <label for="mobile_no">Pilot Id</label></div>


                        <div class="filed_input float_left width50">
                            <?= @$fuel_data[0]->ff_pilot_id; ?>
                        </div>
                    </div>
                    <div class="width2 float_left">
                        <div class="field_lable float_left width33 strong"> <label for="mobile_no">Pilot Name</label></div>


                        <div class="filed_input float_left width50">
                            <?= @$fuel_data[0]->ff_pilot_name; ?>

                        </div>
                    </div>
                </div>
                <div class="field_row width100">

                    <div class="width2 float_left">
                        <div class="field_lable float_left width33 strong"> <label for="mobile_no">EMT Id</label></div>


                        <div class="filed_input float_left width50">
                            <?= @$fuel_data[0]->ff_emso_id; ?>

                        </div>
                    </div>
                    <div class="width2 float_left">
                        <div class="field_lable float_left width33 strong"> <label for="mobile_no">EMT Name</label></div>


                        <div class="filed_input float_left width50">
                            <?= @$fuel_data[0]->ff_emso_name; ?>

                        </div>
                    </div>

                </div>


                <div class="field_row width100">

                    <div class="width2 float_left">
                        <div class="field_lable float_left width33 strong"> <label for="mobile_no">Fuel Station Name<span class="md_field">*</span></label></div>


                        <div class="filed_input float_left width50">
                            <?= @$fuel_data[0]->f_station_name; ?>


                        </div>
                    </div>
                    <div class="width2 float_left">
                        <div class="field_lable float_left width33 strong"> <label for="mobile_no">Other Fuel Station Name</label></div>


                        <div class="filed_input float_left width50">
                            <?= @$fuel_data[0]->ff_other_fuel_station; ?>


                        </div>
                    </div>
                    </div>
                    <div class="field_row width100">
                    <div class="width2 float_left">

                        <div class="field_lable float_left width33 strong"> <label for="mobile_no">Address</label></div>


                        <div class="filed_input float_left width50">
                            <?= @$fuel_data[0]->ff_fuel_address; ?>
                        </div>
                    </div>


                </div>

                <div class="field_row width100">
                    <div class="width2 float_left">
                        <div class="field_lable float_left width33 strong"> <label for="mobile_no">Mobile No</label></div>


                        <div class="filed_input float_left width50">
                            <?= @$fuel_data[0]->ff_fuel_mobile_no; ?>

                        </div>
                    </div>
                    <div class="width2 float_left">
                        <div class="field_lable float_left width33 strong"> <label for="mobile_no">KMPL</label></div>


                        <div class="filed_input float_left width50">
                            <?= @$fuel_data[0]->kmpl; ?>

                        </div>
                    </div>
                 

                </div>
                <div class="field_row width100">
                <div class="width2 float_left">
                        <div class="field_lable float_left width33 strong"> <label for="mobile_no">Fuel Filling Previous Odometer</label></div>


                        <div class="filed_input float_left width50">
                            <?= @$fuel_data[0]->ff_fuel_previous_odometer; ?>

                        </div>
                    </div>
                    <div class="width2 float_left">
                        <div class="field_lable float_left width33 strong"> <label for="mobile_no">Last Updated Odometer</label></div>


                        <div class="filed_input float_left width50">
                            <?= @$fuel_data[0]->ff_previous_odometer; ?>

                        </div>
                    </div>
                    <div class="width2 float_left">
                        <div class="field_lable float_left width33 strong"> <label for="mobile_no">Current Odometer</label></div>


                        <div class="filed_input float_left width50">
                            <?= @$fuel_data[0]->ff_current_odometer; ?>

                        </div>
                    </div>

                </div>
                <div class="field_row width100">
                    <div class="width2 float_left">
                        <div class="field_lable float_left width33 strong"> <label for="mobile_no">Distance Travelled</label></div>


                        <div class="filed_input float_left width50">
                            <?= @$fuel_data[0]->distance_travelled; ?>

                        </div>
                    </div>
                   

                </div>
                <div class="field_row width100">
                    <div class="width2 float_left">
                        <div class="field_lable float_left width33 strong"> <label for="mobile_no">Fuel Filling Date / Time </label></div>


                        <div class="filed_input float_left width50">
                            <?= @$fuel_data[0]->ff_fuel_date_time; ?>

                        </div>
                    </div>
                    <div class="width2 float_left">
                        <div class="field_lable float_left width33 strong"> <label for="mobile_no">Fuel Quantity</label></div>


                        <div class="filed_input float_left width50">
                            <?= @$fuel_data[0]->ff_fuel_quantity; ?>

                        </div>
                    </div>
                    



                </div>

                <div class="field_row width100">
                    <div class="width2 float_left">
                        <div class="field_lable float_left width33 strong"> <label for="mobile_no">Amount</label></div>


                        <div class="filed_input float_left width50">
                            <?= @$fuel_data[0]->ff_amount; ?>

                        </div>
                    </div>
                    <div class="width2 float_left">
                        <div class="field_lable float_left width33 strong"> <label for="mobile_no">Payment Mode</label></div>


                        <div class="filed_input float_left width50">

                            <?php
                            if (@$fuel_data[0]->ff_payment_mode == 'fleet_card_payment') {
                                echo "Fleet Card Payment";
                            } else if (@$fuel_data[0]->ff_payment_mode == 'voucher_payment') {
                                echo "Voucher Payment";
                            }
                            ?>


                        </div>
                    </div>

                </div>
                <div class="field_row width100">
                    <div class="width2 float_left">
                        <div class="field_lable float_left width33 strong"> <label for="mobile_no">Bill No</label></div>


                        <div class="filed_input float_left width50">
                            <?= @$fuel_data[0]->ff_voucher_no; ?>

                        </div>
                    </div>
                    <div class="width2 float_left">
                        <div class="field_lable float_left width33 strong"> <label for="mobile_no">Standard Remark</label></div>


                        <div class="filed_input float_left width50">
                            <?php
                            if (@$fuel_data[0]->ff_standard_remark == 'ambulance_fuel_filling') {
                                echo "Ambulance fuel filling";
                            }
                            ?>


                        </div>
                    </div>

                </div>
                <!-- <div class="field_row width100">
                    <div class="width2 float_left">
                        <div class="field_lable float_left width33 strong"> <label for="mobile_no">Higher Autority Name</label></div>


                        <div class="filed_input float_left width50">
                            <?= @$fuel_data[0]->ff_higher_autority_name; ?>

                        </div>
                    </div>
                    <div class="width2 float_left">
                        <div class="field_lable float_left width33 strong"> <label for="mobile_no">Name</label></div>


                        <div class="filed_input float_left width50">
                            <?= @$fuel_data[0]->ff_authority_name; ?>

                        </div>
                    </div>

                </div> -->

                <div class="field_row width100">
                    <?php if (@$fuel_data[0]->ff_end_odometer != '') { ?>
                        <div class="width2 float_left">
                            <div class="field_lable float_left width33 strong"><label for="end_odometer">End Odometer</label></div>

                            <div class="filed_input float_left width50" >

                                <?= @$fuel_data[0]->ff_end_odometer; ?>
                            </div>
                        </div>
                    <?php } ?>
                    <?php if (@$fuel_data[0]->ff_on_road_ambulance != '') { ?>
                        <div class="width2 float_left">

                            <div class="field_lable float_left width33 strong"><label for="mt_onroad_datetime">Date/Time</label></div>
                            <div class="filed_input float_left width50" >
                                <?= @$fuel_data[0]->ff_on_road_ambulance; ?>
                            </div>
                        </div>
                    <?php } ?>
                </div>
                <div class="field_row width100">
                        <?php if (@$fuel_data[0]->mt_on_stnd_remark != '') { ?>
                    <div class="filed_input float_left width2">

                        <div class="field_lable float_left width33 strong"> <label for="mt_stnd_remark">Standard Remark</label></div>


                        <div class="filed_input float_left width50">

                            <?php
                            if (@$fuel_data[0]->mt_on_stnd_remark == 'ambulance_fuel_fill_done') {
                                echo "Ambulance fuel filling done";
                            }
                            ?>

                        </div>
                    </div>
                      <?php } ?>
                    
                       <?php if (@$fuel_data[0]->mt_on_remark != '') { ?>
                    <div class="width2 float_left">
                        <div class="field_lable float_left width33 strong"> <label for="mt_on_remark">Remark</label></div>


                        <div class="filed_input float_left width50" >

                            <?= @$fuel_data[0]->mt_on_remark; ?>
                        </div>
                    </div>
                     <?php } ?>
                </div>
                
                <div class="field_row width100">
                    <div class="float_left width2">
                    <div class="field_lable float_left width33 strong"> <label for="gps_odometer">GPS Odometer</label></div>
                    <div class="filed_input float_left width50" >

                            <?= @$fuel_data[0]->ff_gps_odometer; ?>
                        </div>
                    </div>
                </div>
                <div class="field_row width100">
                    <div class="float_left width2">

                        <div class="field_lable float_left width33"> <label for="nozzle_slip">Nozzle Slip Image</label></div>


                        <div class="filed_input float_left width50">
                        <?php                                                 
       
        
            //var_dump($img);
            $name = $fuel_data[0]->ff_nozzle_image;
        $pic_path = FCPATH . $name;
        if (file_exists($pic_path)) {
            $pic_path1 = base_url() .  $name;
           
        }else{
            $blank_pic_path = base_url() . "themes/backend/images/blank_profile_pic.png";
        }
        ?>
         <div class="images_block vid_img" id="image_<?php echo $img;?>">
               <a class="ambulance_photo float_left" target="blank" href="<?php
                if (file_exists($pic_path)) {
                    echo $pic_path1;
                } else {
                    echo $blank_pic_path;
                }
            ?>" style="background: url('<?php
            if (file_exists($pic_path)) {
                echo $pic_path1;
            } else {
                echo $blank_pic_path;
            }
            ?>') no-repeat left center; background-size: cover; min-height: 75px;" <?php echo $view; ?>></a>
        
        </div>
                        <!-- <img src="<?php echo FCPATH . $fuel_data[0]->ff_nozzle_image; ?>" alt="" style="height:120px;width:120px;"> -->
                        </div>
                    </div>
                   
                </div>
                </form>

