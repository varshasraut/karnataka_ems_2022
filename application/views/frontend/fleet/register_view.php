<script>
if(typeof H != 'undefined'){
    init_auto_address();
}

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
                        <div class="filed_lable float_left width33"><label for="station_name">Station Name<span class="md_field">*</span></label></div>

                        <div class="filed_input float_left width50">

                            <input id="station_name" data-base="<?= @$current_data[0]->clg_ref_id ?>"  type="text" name="fuel[f_station_name]" class="filter_required"  data-errors="{filter_required:'Station name should not be blank'}" value="<?= @$fuel_station[0]->f_station_name ?>" TABINDEX="1"  <?php
                            echo $view;
                            if (@$update) {
                                echo"disabled";
                            }
                            ?> >

                        </div>
                    </div>   <div class="width2 float_left">
                        <div class="field_lable float_left width49"> <label for="co_orportion">Oil Corporation<span class="md_field">*</span></label></div>

                        <div class="filed_input float_left width50">

                            <input id="co_orportion" data-base="<?= @$current_data[0]->clg_ref_id ?>"  type="text" name="fuel[f_oil_co_orportion]" class="filter_required" data-errors="{filter_required:'Oil Corporation should not be blank'}" value="<?= @$fuel_station[0]->f_oil_co_orportion ?>" TABINDEX="1"   <?php
                            echo $view;
                            if (@$update) {
                                echo"disabled";
                            }
                            ?>>

                        </div>

                    </div>
                </div>
                <div class="field_row width100">

                    <div class="field_lable float_left width_16"><label for="district">Address <span class="md_field">*</span></label></div>
                    <div class="filed_input float_left width75">

                        <?php
                        if ($fuel_station[0]->f_google_address) {
                            $fuel_address = $fuel_station[0]->f_google_address;
                        }
                        ?>
                        <input name="fuel[f_google_address]" value="<?php echo $fuel_address; ?>" id="pac-input" class="incient filter_required"  data-errors="{filter_required:'Address should not be blank'}"tabindex="16" type="text" placeholder="Google location map address" data-state="yes" data-dist="yes" data-city="yes" data-area="yes" data-lmark="yes" data-lane="yes" data-pin="yes" data-rel="incient" data-auto="inc_auto_addr" style="width:109%"> 


                    </div>
                </div>
                <div class="field_row width100">

                    <div class="width2 float_left">
                        <div class="field_lable float_left width33"><label for="district">State<span class="md_field">*</span></label></div>
                        <div class="filed_input float_left width50"> <div id="incient_state">



                                <?php
                                if ($fuel_station[0]->f_state_code != '') {
                                    $st = array('st_code' => $fuel_station[0]->f_state_code, 'auto' => 'inc_auto_addr', 'rel' => 'incient', 'disabled' => '');
                                } else {
                                    $st = array('st_code' => '', 'auto' => 'inc_auto_addr', 'rel' => 'incient', 'disabled' => '');
                                }


                                echo get_state_tahsil($st);
                                ?>

                            </div>

                        </div>

                    </div>
                    <div class="width2 float_left">    
                        <div class="field_lable float_left width49"><label for="district">District<span class="md_field">*</span></label></div>   <div class="filed_input float_left width50">
                            <div id="incient_dist">
                                <?php
                                if ($fuel_station[0]->f_state_code != '') {
                                    $dt = array('dst_code' => $fuel_station[0]->f_district_code, 'st_code' => $fuel_station[0]->f_state_code, 'auto' => 'inc_auto_addr', 'rel' => 'incient', 'disabled' => '');
                                } else {
                                    $dt = array('dst_code' => '', 'st_code' => '', 'auto' => 'inc_auto_addr', 'rel' => 'incient', 'disabled' => '');
                                }


                                echo get_district_tahsil($dt);
                                ?>
                            </div>





                        </div>
                    </div>
                </div>

                <div class="field_row width100">

                    <div class="width2 float_left">
                        <div class="field_lable float_left width33"><label for="district">Tehsil<span class="md_field">*</span></label></div>
                        <div class="filed_input float_left width50"> <div id="incient_tahsil">



                                <?php
                                if ($fuel_station[0]->f_district_code != '') {
                                    $st = array('thl_id' => $fuel_station[0]->f_tahsil, 'dst_code'=>$fuel_station[0]->f_district_code, 'auto' => 'inc_auto_addr', 'rel' => 'incient', 'disabled' => '');
                                } else {
                                    $st = array('st_code' => '', 'auto' => 'inc_auto_addr', 'rel' => 'incient', 'disabled' => '');
                                }


                                echo get_tahshil($st);
                                ?>

                            </div>

                        </div>

                    </div>
                    <div class="width2 float_left">    
                        <div class="field_lable float_left width49"><label for="City">City<span class="md_field">*</span></label></div>   <div class="filed_input float_left width50">
                            <div id="incient_city">
                                <?php
                                if ($fuel_station[0]->f_city != '') {
                                    $dt = array('cty_id' => $fuel_station[0]->f_city, 'thl_id' => $fuel_station[0]->f_tahsil, 'auto' => 'inc_auto_addr', 'rel' => 'incient', 'disabled' => '');
                                } else {
                                    $dt = array('dst_code' => '', 'st_code' => '', 'auto' => 'inc_auto_addr', 'rel' => 'incient', 'disabled' => '');
                                }


                                echo get_city_tahsil($dt);
                                ?>
                            </div>





                        </div>
                    </div>
                </div>
                <div class="field_row width100">

                    <div class="width2 float_left">
                        <div class="field_lable float_left width33"><label for="district">Landmark</label></div>
                        <div class="filed_input float_left width50"> <div id="landmark">


                        <input id="landmark" data-base="<?= @$current_data[0]->clg_ref_id ?>"  type="text" name="fuel[f_landmark]" class=""  data-errors="" value="<?= @$fuel_station[0]->f_landmark ?>" TABINDEX="1"  <?php
                            echo $view;
                            ?> >

                            </div>

                        </div>

                    </div>
                    <div class="width2 float_left">    
                        <div class="field_lable float_left width49"><label for="pincode">Pincode</label></div>   <div class="filed_input float_left width50">
                            <div id="pincode">
                            <input id="Pincode" data-base="<?= @$current_data[0]->clg_ref_id ?>"  type="text" name="fuel[f_pincode]" class=""  data-errors="" value="<?= @$fuel_station[0]->f_pincode ?>" TABINDEX="1"  <?php
                            echo $view;
                            ?> >
                            </div>
                        </div>
                    </div>
                </div>

                <div class="field_row width100">
                <div class="width2 float_left">
                        <div class="field_lable float_left width33"> <label for="email">Email</label></div>


                        <div class="filed_input float_left width50">
                           <input  type="text" name="fuel[f_email]" class="filter_if_not_blank filter_email  no_ucfirst"  data-errors="{filter_required:'Email should not be blank', filter_email:'Please enter a valid email'}"  value="<?= @$fuel_station[0]->f_email ?>"  TABINDEX="6"  <?php echo $view; ?>>

                        </div>
                    </div>
                    </div>
                    <div class="width2 float_left">

                        <div class="field_lable float_left width49"> <label for="mobile_no">Station Contact Number<span class="md_field">*</span></label></div>


                        <div class="filed_input float_left width50">
                            <input data-base="<?= @$current_data[0]->clg_ref_id ?>"  type="text" name="fuel[f_station_mobile_no]" class="filter_required filter_number filter_minlength[8] filter_maxlength[13] filter_no_whitespace"  data-errors="{filter_required:'Mobile number should not be blank', filter_number:'Mobile number should be in numeric characters only', filter_minlength:'Mobile number should be at least 9 digits long', filter_maxlength:'Mobile number should less then 13 digits.', filter_no_whitespace:'No spaces allowed'}" value="<?= @$fuel_station[0]->f_station_mobile_no ?>" TABINDEX="10"  <?php echo $view; ?>>
                        </div>
                    </div>
                </div>
                <div class="field_row width100">
                <div class="width2 float_left">
                        <div class="field_lable float_left width33"><label for="city">Status<span class="md_field">*</span></label></div>

                        <div class="filed_input float_left width50">

                            <?php //$selected[@$fuel_station[0]->f_is_active] = "selected=selected"; ?>   
                                     <?php //$selected[@$fire_station[0]->f_is_active] = "selected=selected"; ?>   
                                <?php 
                        if($fuel_station){
                            $selected[@$fuel_station[0]->f_is_active] = "selected=selected";

                        }else{
                            $selected['0'] =  "selected=selected";
                            
                        } ?>  


                            <select id="filter_dropdown"  name="fuel[f_is_active]" class="add_clg_sts" data-errors="{filter_required:'Status  Should not be blank'}" data-qr="output_position=content&amp;flt=true" <?php echo $view; ?>>

                                <option value="" >Select Status</option>

                                <option value="0" <?php echo $selected['0']; ?>>Active</option>

                                <option value="1" <?php echo $selected['1']; ?>>Inactive</option>

                            </select>
                        </div>
                    </div>
                    </div>
                <div class="field_row width100">
                    <div class="width2 float_left">
                        <div class="field_lable float_left width33"> <label for="mobile_no">Contact Person</label></div>


                        <div class="filed_input float_left width50">
                            <input data-base="<?= @$current_data[0]->clg_ref_id ?>"  type="text" name="fuel[f_contact_person]" class=" "  data-errors="{filter_required:'Contact Person should not be blank'}" value="<?= @$fuel_station[0]->f_contact_person ?>" TABINDEX="10"  <?php echo $view; ?>>
                        </div>
                    </div>
                    <div class="width2 float_left">
                        <div class="field_lable float_left width49"> <label for="mobile_no">Mobile No</label></div>


                        <div class="filed_input float_left width50">
                            <input  data-base="<?= @$current_data[0]->clg_ref_id ?>"  type="text" name="fuel[f_mobile_no]" class="filter_if_not_blank filter_number filter_minlength[8] filter_maxlength[13] filter_no_whitespace"  data-errors="{filter_required:'Mobile number should not be blank', filter_number:'Mobile number should be in numeric characters only', filter_minlength:'Mobile number should be at least 9 digits long', filter_maxlength:'Mobile number should less then 13 digits.', filter_no_whitespace:'No spaces allowed'}" value="<?= @$fuel_station[0]->f_mobile_no ?>" TABINDEX="10"  <?php echo $view; ?>>
                        </div>
                    </div>

                </div>
                 
                <div class="field_row width100">
                    <div class="width100">
                        <div class="field_lable float_left width_16"> <label for="mobile_no">Address</label></div>


                        <div class="filed_input float_left width75">
                            <input data-base="<?= @$current_data[0]->clg_ref_id ?>"  type="text" name="fuel[f_address]" class=" "  data-errors="{filter_required:'Address should not be blank'}" value="<?= @$fuel_station[0]->f_address ?>" TABINDEX="10"   <?php
                            echo $view;
                            if (@$update) {
                                echo"disabled";
                            }
                            ?> style="width: 109%;">
                        </div>
                    </div>


                </div>

                <?php if ($update) { ?>  

                    <input type="hidden" name="fuel[f_id]" id="ud_clg_id" value="<?= @$fuel_station[0]->f_id ?>">

                <?php } ?>



                <?php if (!@$view_clg) { ?>
                    <div class="button_field_row width_11 margin_auto">
                        <div class="button_box">
                            <input type="hidden" name="hasfiles" value="yes" />
                            <input type="hidden" name="formid" value="add_colleague_registration" />
                            <input type="button" name="submit" value="<?php if ($update) { ?>Update<?php } else { ?>Submit<?php } ?>" class="btn submit_btnt form-xhttp-request" data-href='<?php echo base_url(); ?>fleet/<?php if ($update) { ?>update_fuel_station_data<?php } else { ?>registration_fuel_station<?php } ?>' data-qr='output_position=content&amp;prof=<?php echo @$prof; ?>&amp;module_name=clg&amp;tlcode=<?php if ($update) { ?>MT-CLG-UPDATE<?php } else { ?>MT-CLG-ADD<?php } ?>&amp;page_no=<?php echo @$page_no; ?>'  TABINDEX="23" id="<?php echo @$current_data[0]->clg_ref_id; ?>">
                            <?php if ($update) { ?>           
                            <?php } else { ?>
                                <!--<input type="reset" name="reset" value="Reset" class="btn reset_btn register_view_reset"  TABINDEX="24">--> 
                            <?php } ?>


                        </div>
                    </div>

                <?php } ?>

                </form>

