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

<form enctype="multipart/form-data" action="#" method="post" id="add_vendor_registration_form">
    <div class="width1">
        <h2 class="txt_clr2 width1 txt_pro">
            <?php
            if ($action_type) {
                echo $action_type;
            }
            ?>
            </h2>

        <div class="joining_details_box">

            <div class="width100">

                <div class="field_row width100">
                <div class="width2 float_left">
                    
                        <div class="filed_lable float_left width33"><label for="station_name">Vendor Name<span class="md_field">*</span></label></div>

                        <div class="filed_input float_left width50">

                            <input  type="text" name="vendor_name" class="filter_required filter_character" onkeyup="this.value=this.value.replace(/[\d]/,'')" data-errors="{filter_required:'Vendor Name should not be blank', filter_character:'Please enter a name'}" value="<?= @$vendor[0]->vendor_name ?>" TABINDEX="1" placeholder="Vendor Name" <?php
                            echo $view;
                            if (@$update) {
                                echo"enable";
                            }
                            ?>>

                        </div>
                     </div>
                
                
                    <div class="width2 float_left">
                        <div class="field_lable float_left width33"> <label for="email">Email</label></div>


                        <div class="filed_input float_left width50">
                           <input  type="text"name="vendor_email" class="filter_if_not_blank filter_email filter_is_exists no_ucfirst"  data-errors="{filter_required:'Email should not be blank', filter_email:'Please enter a valid email'}"   value="<?= @$vendor[0]->vendor_email; ?>"  TABINDEX="6"  <?php echo $view; ?>>

                        </div>
                    </div>
                    <!-- <div class="width2 float_left">
                        <div class="filed_lable float_left width33"> <label for="vendor_id">Vendor<span class="md_field">*</span></label></div>


                        <div class="filed_input float_left width50">
                           <select name="work[vendor_id]" class="filter_required" data-errors="{filter_required:'Vendor  should not be blank'}" <?php //echo $view; ?> TABINDEX="5">
                                        <option value="">Select Vendor</option>
                                        <?php //echo get_clg_data('UG-VENDOR', $vendor[0]->vendor_id); ?>
                                    </select>

                        </div>
                    </div> -->
                   </div>
                  <!-- <div class="field_row width100">
                      
                        <div class="field_lable float_left width_16"><label for="district">Address <span class="md_field">*</span></label></div>
                          <div class="filed_input float_left width75">
                    
                        <?php
                        //if ($vendor[0]->ws_google_address) {
                          //$work_address= $vendor[0]->ws_google_address;
                        //}
                        ?>
                              <input name="work[ws_google_address]" value="<?php //echo $work_address; ?>" id="pac-input" class="incient filter_required"  data-errors="{filter_required:'Address should not be blank'}"tabindex="16" type="text" placeholder="Google location map address" data-state="yes" data-dist="yes" data-city="yes" data-area="yes" data-lmark="yes" data-lane="yes" data-pin="yes" data-rel="incient" data-auto="inc_auto_addr" style="width:109%"> 

                    
                </div>
                  </div> -->
                <div class="field_row width100">

                    <!-- <div class="width2 float_left">
                        <div class="field_lable float_left width33"><label for="district">State<span class="md_field">*</span></label></div>
                        <div class="filed_input float_left width50"> <div id="incient_state">



                                <?php
                                if ($vendor[0]->vendor_state != '') {
                                    $st = array('st_code' => $vendor[0]->vendor_state, 'auto' => 'inc_auto_addr', 'rel' => 'incient', 'disabled' => '');
                                } else {
                                    $st = array('auto' => 'inc_auto_addr', 'rel' => 'incient', 'disabled' => '');
                                    // $st = array('st_code' => 'MP','auto' => 'inc_auto_addr', 'rel' => 'incient', 'disabled' => '');
                                }


                                echo get_state_tahsil_vendor($st);
                                ?>

                            </div>

                        </div>

                    </div> -->
                    <div class="width2 float_left">    
                        <div class="field_lable float_left width33"><label for="district">District<span class="md_field">*</span></label></div>   <div class="filed_input float_left width50">
                         <div id="incient_dist">
                                <?php
                                if ($vendor[0]->vendor_district != '') {
                                    $dt = array('dst_code' => $vendor[0]->vendor_district, 'st_code' => $vendor[0]->vendor_state, 'auto' => 'inc_auto_addr', 'rel' => 'incient', 'disabled' => '');
                                } else {
                                    $dt = array('dst_code' => '', 'st_code' => 'MP', 'auto' => 'inc_auto_addr', 'rel' => 'incient', 'disabled' => '');
                                }


                                echo get_district_tahsil($dt);
                                ?>
                            </div>





                        </div>
                    </div>
                    <div class="width2 float_left">
                        <div class="field_lable float_left width33"><label for="district">Tehsil<span class="md_field">*</span></label></div>
                        <div class="filed_input float_left width50"> <div id="incient_tahsil">



                                <?php
                                if ($vendor[0]->vendor_tehshil != '') {
                                    $st = array('thl_id' => $vendor[0]->vendor_tehshil, 'dst_code'=>$vendor[0]->vendor_district, 'auto' => 'inc_auto_addr', 'rel' => 'incient', 'disabled' => '');
                                } else {
                                    $st = array('st_code' => '', 'auto' => 'inc_auto_addr', 'rel' => 'incient', 'disabled' => '');
                                }


                                echo get_tahshil($st);
                                ?>

                            </div>

                        </div>

                    </div>
                </div>
                <div class="field_row width100">
                    <div class="width2 float_left">    
                        <div class="field_lable float_left width33"><label for="district">City<span class="md_field">*</span></label></div>  
                         <div class="filed_input float_left width50"> <div id="incient_city">

                                <?php
                                if ($vendor[0]->vendor_city != '') {
                                    $dt = array('cty_id' => $vendor[0]->vendor_city, 'thl_id' => $vendor[0]->vendor_tehshil, 'auto' => 'inc_auto_addr', 'rel' => 'incient', 'disabled' => '');
                                } else {
                                    $dt = array('dst_code' => '', 'st_code' => '', 'auto' => 'inc_auto_addr', 'rel' => 'incient', 'disabled' => '');
                                }


                                echo get_city_tahsil_vendor($dt);
                                ?>
                            </div>





                        </div>
                    </div>
                    <div class="width2 float_left">
                    <div class="field_lable float_left width33"><label for="district">Area</label></div>
                    <div class="filed_input float_left width50"> <div id="area">


                    <input id="area" type="text" name="vendor_area" class=""  data-errors="" value="<?= @$vendor[0]->vendor_area ?>" TABINDEX="1"  <?php
                        echo $view;
                        ?> >

                        </div>

                    </div>

                </div>
                </div>  

                <div class="field_row width100">
                <div class="width2 float_left">    
                    <div class="field_lable float_left width33"><label for="pincode">Pincode</label></div>  
                     <div class="filed_input float_left width50">
                        <div id="pincode">
                        <input id="pincode" type="text"  name="vendor_pincode" class="filter_if_not_blank filter_number filter_minlength[5] filter_maxlength[7] filter_no_whitespace"  data-errors="{filter_required:'Pin Code should not be blank', filter_number:'Pin Code should be in Number only', filter_minlength:'Pin Code should be at least 6 digits long', filter_maxlength:'Pin Code should less then 6 digits.', filter_no_whitespace:'No spaces allowed'}" value="<?= @$vendor[0]->vendor_pincode ?>" TABINDEX="1">
                       
                       
                        </div>
                    </div>
                </div>
                     <div class="width2 float_left">
                        <div class="field_lable float_left "style="width: 33.33%;"> <label for="mobile_no">Mobile Number <span class="md_field">*</span></label></div>


                        <div class="filed_input float_left width50">
                            <input type="text" name="vendor_mob_number"  class="filter_number filter_required filter_minlength[9] filter_maxlength[11] filter_no_whitespace"  data-errors="{filter_required:'Mobile number should not be blank', filter_number:'Mobile number should be in Number only', filter_minlength:'Mobile number should be at least 9 digits long', filter_maxlength:'Mobile number should less then 10 digits.', filter_no_whitespace:'No spaces allowed'}" value="<?= @$vendor[0]->vendor_mob_number ?>" TABINDEX="10"  <?php echo $view; ?>>
                        </div>
                    </div> 

                </div>
                <input type="hidden" name="vendor_state" value="MP">

                </div>

                  <?php if ($update) { ?>  

                            <input type="hidden" name="vendor_id" id="ud_clg_id" value="<?= @$vendor[0]->vendor_id ?>">

                        <?php } ?>


<?php if (!@$view_clg) { ?>
                    <div class="button_field_row width_25 margin_auto" style="margin-top: 50px;width: 10%;">
                        <div class="button_box">
                            <input type="hidden" name="hasfiles" value="yes" />
                            <input type="hidden" name="formid" value="add_vendor_registration_form" />
                            <input type="button" name="submit" value="<?php if ($update) { ?>Update<?php } else { ?>Submit<?php } ?>" class="btn submit_btnt form-xhttp-request" data-href='<?php echo base_url(); ?>fleet/<?php if ($update) { ?>update_vendor_data<?php } else { ?>registration_vendor<?php } ?>' data-qr='output_position=content&amp;prof=<?php echo @$prof; ?>&amp;module_name=clg&amp;tlcode=<?php if ($update) { ?>MT-CLG-UPDATE<?php } else { ?>MT-CLG-ADD<?php } ?>&amp;page_no=<?php echo @$page_no; ?>'  TABINDEX="23" id="<?php echo @$current_data[0]->vendor_id; ?>">
                            <?php if ($update) { ?>           
                            <?php } else { ?>
                                <!--<input type="reset" name="reset" value="Reset" class="btn reset_btn register_view_reset"  TABINDEX="24">--> 
                            <?php } ?>
                        </div>
                    </div>

<?php } ?>

                </form>

