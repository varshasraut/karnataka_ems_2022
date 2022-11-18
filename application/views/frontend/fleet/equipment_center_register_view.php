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
                        <div class="filed_lable float_left width47"><label for="station_name">Service Center Name<span class="md_field">*</span></label></div>

                        <div class="filed_input float_left width50">

                            <input id="station_name"   type="text" name="equi[es_service_center_name]" class="filter_required"  data-errors="{filter_required:'Station name should not be blank'}" value="<?= @$equip_center[0]->es_service_center_name ?>" TABINDEX="1" placeholder="Service Center Name" <?php
                            echo $view;
                            if (@$update) {
                                echo"disabled";
                            }
                            ?> style="width:99%">

                        </div>
                    </div>
                    <div class="width2 float_left">
                        <div class="field_lable float_left width49"> <label for="email">Email<span class="md_field"></span></label></div>


                        <div class="filed_input float_left width50">
                            <input  type="text" name="equi[es_email]" class=" filter_email filter_is_exists no_ucfirst"  data-errors="{filter_required:'Email should not be blank', filter_email:'Please enter a valid email'}"   value="<?= @$equip_center[0]->es_email; ?>"  TABINDEX="6"  <?php echo $view; ?>>

                        </div>
                    </div>



                </div>
                <div class="field_row width100">

                    <div class="field_lable float_left width_23"><label for="district">Address <span class="md_field">*</span></label></div>
                    <div class="filed_input float_left width75">

                        <?php
                        if (@$equip_center[0]->es_google_address) {
                            $equip_address = @$equip_center[0]->es_google_address;
                        }
                        ?>
                        <input name="equi[es_google_address]" value="<?php echo $equip_address; ?>" id="pac-input" class="incient filter_required"  data-errors="{filter_required:'Address should not be blank'}"tabindex="16" type="text" placeholder="Google location map address" data-state="yes" data-dist="yes" data-city="yes" data-area="yes" data-lmark="yes" data-lane="yes" data-pin="yes" data-rel="incient" data-auto="inc_auto_addr" style="width:100%"> 


                    </div>
                </div>
                <div class="field_row width100">

                    <div class="width2 float_left">
                        <div class="field_lable float_left width47"><label for="district">State<span class="md_field">*</span></label></div>
                        <div class="filed_input float_left width50"> <div id="incient_state">



                                <?php
                                if (@$equip_center[0]->es_state_code != '') {
                                    $st = array('st_code' => @$equip_center[0]->es_state_code, 'auto' => 'inc_auto_addr', 'rel' => 'incient', 'disabled' => '');
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
                                if (@$equip_center[0]->es_state_code != '') {
                                    $dt = array('dst_code' => @$equip_center[0]->es_district_code, 'st_code' => @$equip_center[0]->es_state_code, 'auto' => 'inc_auto_addr', 'rel' => 'incient', 'disabled' => '');
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

    <div class="field_lable float_left width47"><label for="district">Tehsil<span class="md_field">*</span></label></div>

    <div class="filed_input float_left width50"> <div id="incient_tahsil">

            <?php

            if ($equip_center[0]->es_state_code != '') {
            
                $st = array('thl_id' => $equip_center[0]->es_tahsil_code,'dst_code' => $equip_center[0]->es_district_code, 'auto' => 'inc_auto_addr', 'rel' => 'incient', 'disabled' => '');

            } else {

                $st = array('st_code' => '', 'auto' => 'inc_auto_addr', 'rel' => 'incient', 'disabled' => '');

            }
               echo get_tahshil($st);
                // var_dump(get_tahshil($st));
            ?>



        </div>



    </div>



</div>

<div class="width2 float_left">    

    <div class="field_lable float_left width49"><label for="district">City/Village<span class="md_field">*</span></label></div>   <div class="filed_input float_left width50">

        <div id="incient_city">

            <?php

            if ($equip_center[0]->es_city_code != '') {

                $dt = array('cty_id' => $equip_center[0]->es_city_code, 'thl_id' => $equip_center[0]->es_tahsil_code, 'auto' => 'inc_auto_addr', 'rel' => 'incient', 'disabled' => '');

            } else {

                $dt = array('dst_code' => '', 'st_code' => '', 'auto' => 'inc_auto_addr', 'rel' => 'incient', 'disabled' => '');

            }

           //var_dump($police_station[0]->p_city);



            echo get_city_tahsil($dt);

            ?>

        </div>











    </div>

</div>

</div>
             

<div class="field_row width100">

<div class="width2 float_left">

    <div class="filed_lable float_left width47"><label for="station_name">Landmark<span class="md_field"></span></label></div>



    <div class="filed_input float_left width50">



        <input id="station_name" data-base="<?= @$current_data[0]->clg_ref_id ?>"  type="text" name="equi[es_landmark]"    value="<?= @$equip_center[0]->es_landmark ?>" TABINDEX="1"  <?php

        echo $view;

        
        ?> >



    </div>

</div>  

  <div class="width2 float_left">

    <div class="filed_lable float_left width49"><label for="email">PinCode<span class="md_field"></span></label></div>



    <div class="filed_input float_left width50">



        <input    type="text" name="equi[es_pincode]"   data-errors="{filter_required:'Email should not be blank', filter_email:'Please enter a valid email'}"  value="<?= @$equip_center[0]->es_pincode ?>" TABINDEX="1"  <?php

        echo $view;

        

        ?> >



    </div>

</div> 



</div>

                <div class="field_row width100">
                    <div class="width2 float_left">
                        <div class="field_lable float_left width47"><label for="city">Status</label></div>

                        <div class="filed_input float_left width50">
                                   
                                <?php 
                        if($equip_center){
                            $selected[@$equip_center[0]->es_is_active] = "selected=selected";

                        }else{
                            $selected['0'] =  "selected=selected";
                            
                        } ?>  


                            <select id="filter_dropdown"  name="equi[es_is_active]" class="add_clg_sts filter_required" data-errors="{filter_required:'Status  Should not be blank'}" data-qr="output_position=content&amp;flt=true" <?php echo $view; ?>>

                                <option value="" >Select Status</option>

                                <option value="0" <?php echo $selected['0']; ?>>Active</option>

                                <option value="1" <?php echo $selected['1']; ?>>Inactive</option>



                            </select>
                        </div>
                    </div>
                    <div class="width2 float_left">

                        <div class="field_lable float_left width49"> <label for="mobile_no">Service Contact Number<span class="md_field">*</span></label></div>


                        <div class="filed_input float_left width50">
                            <input data-base="<?= @$current_data[0]->clg_ref_id ?>"  type="text" name="equi[es_station_mobile_no]" class="filter_required filter_number filter_minlength[8] filter_maxlength[13] filter_no_whitespace"  data-errors="{filter_required:'Mobile number should not be blank', filter_number:'Mobile number should be in numeric characters only', filter_minlength:'Mobile number should be at least 9 digits long', filter_maxlength:'Mobile number should less then 13 digits.', filter_no_whitespace:'No spaces allowed'}" value="<?= @$equip_center[0]->es_station_mobile_no ?>" TABINDEX="10"  <?php echo $view; ?>>
                        </div>
                    </div>
                </div>
                <div class="field_row width100">
                    <div class="width2 float_left">
                        <div class="field_lable float_left width47"> <label for="mobile_no">Contact Person</label></div>


                        <div class="filed_input float_left width50">
                            <input data-base="<?= @$current_data[0]->clg_ref_id ?>"  type="text" name="equi[es_contact_person]" class=""  data-errors="{filter_required:'Contact Person should not be blank'}" value="<?= @$equip_center[0]->es_contact_person ?>" TABINDEX="10"  <?php echo $view; ?>>
                        </div>
                    </div>
                    <div class="width2 float_left">
                        <div class="field_lable float_left width49"> <label for="mobile_no">Contact Number</label></div>


                        <div class="filed_input float_left width50">
                            <input  data-base="<?= @$current_data[0]->clg_ref_id ?>"  type="text" name="equi[es_mobile_no]" class="filter_if_not_blank filter_number filter_minlength[9] filter_maxlength[11] filter_no_whitespace"  data-errors="{filter_required:'Mobile number should not be blank', filter_number:'Mobile number should be in numeric characters only', filter_minlength:'Mobile number should be at least 10 digits long', filter_maxlength:'Mobile number should less then 11 digits.', filter_no_whitespace:'No spaces allowed'}" value="<?= @$equip_center[0]->es_mobile_no ?>" TABINDEX="10"  <?php echo $view; ?>>
                        </div>
                    </div>

                </div>
                <div class="field_row width100">
                    <div class="width100">
                        <div class="field_lable float_left width_23"> <label for="mobile_no">Address</label></div>


                        <div class="filed_input float_left width75">
                            <input data-base="<?= @$current_data[0]->clg_ref_id ?>"  type="text" name="equi[es_address]" class=" "  data-errors="{filter_required:'Address should not be blank'}" value="<?= @$equip_center[0]->es_address ?>" TABINDEX="10"   <?php
                            echo $view;
                            if (@$update) {
                                echo"disabled";
                            }
                            ?> style="width: 100%;">
                        </div>
                    </div>


                </div>

                <?php if ($update) { ?>  

                    <input type="hidden" name="equi[es_id]" id="ud_clg_id" value="<?= @$equip_center[0]->es_id ?>">

                <?php } ?>



                <?php if (!@$view_clg) { ?>
                    <div class="button_field_row width_25 margin_auto">
                        <div class="button_box">

                            <input type="button" name="submit" value="<?php if ($update) { ?>Update<?php } else { ?>Submit<?php } ?>" class="btn submit_btnt form-xhttp-request" data-href='<?php echo base_url(); ?>fleet/<?php if ($update) { ?>update_equipment_center_data<?php } else { ?>registration_equipment_center<?php } ?>' data-qr='output_position=content&amp;prof=<?php echo @$prof; ?>&amp;module_name=clg&amp;tlcode=<?php if ($update) { ?>MT-CLG-UPDATE<?php } else { ?>MT-CLG-ADD<?php } ?>&amp;page_no=<?php echo @$page_no; ?>'  TABINDEX="23" >
                            <?php if ($update) { ?>           
                            <?php } else { ?>
                                        <!--<input type="reset" name="reset" value="Reset" class="btn reset_btn register_view_reset"  TABINDEX="24">--> 
                            <?php } ?>

                        </div>
                    </div>

                <?php } ?>

                </form>

