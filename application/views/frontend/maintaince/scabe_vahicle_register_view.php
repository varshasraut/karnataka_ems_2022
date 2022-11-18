<div id="dublicate_id"></div>

<?php
$approve = '';
$update = '';
$rerequest = '';
$mo_rerequest = '';

if ($type == 'Update') {
    $update = 'disabled';
} elseif ($type == 'Approve') {
    $approve = 'disabled';
} elseif ($type == 'Rerequest') {
    $rerequest = 'disabled';
}

?>

<form enctype="multipart/form-data" action="#" method="post" id="add_colleague_registration_form" style="position:relative; top:0px; bottom:0px;">
    <div class="width1">
        <h2 class="txt_clr2 width1 txt_pro"><?php
            if ($action_type) {
                echo $action_type;
            }
            ?></h2>


        <div class="joining_details_box">

            <div class="width100">
                <?php if ($update) {
                    ?>  
                    <div class="field_row width100  fleet" ><div class="single_record_back">Previous Information</div></div>
                <?php } ?>
                <input type="hidden" name="mt_id" value="<?= @$preventive[0]->mt_id ?>">
                <!--<div class="field_row width100  fleet"><div class="single_record_back">Previous Info</div></div>-->
                <div class="field_row width100">

                    <div class="width2 float_left">    
                        <div class="field_lable float_left width33"><label for="district">District<span class="md_field">*</span></label></div>   
                        <div class="filed_input float_left width50">
                            <div id="maintaince_district">
                                <?php
                                if (@$preventive[0]->mt_amb_no != '') {
                                    $dt = array('dst_code' => @$preventive[0]->mt_district_id, 'st_code' => @$preventive[0]->mt_state_id, 'amb_ref_no' => @$preventive[0]->mt_amb_no, 'auto' => 'inc_auto_addr', 'rel' => 'maintaince', 'disabled' => 'disabled');
                                } else {
                                    $dt = array('dst_code' => '', 'st_code' => 'MP', 'auto' => 'amb_auto_addr', 'rel' => 'maintaince', 'disabled' => '');
                                }

                                echo get_district_preventive_amb($dt);
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="field_row width100">

                    <div class="width2 float_left">
                        <div class="field_lable float_left width33"><label for="district">Ambulance Number<span class="md_field">*</span></label></div>
                        <div class="filed_input float_left width50">

                            <div id="maintaince_ambulance">



                                <?php
                                if (@$preventive[0]->mt_state_id != '') {
                                    $amd_dt = array('dst_code' => @$preventive[0]->mt_district_id, 'st_code' => @$preventive[0]->mt_state_id, 'amb_ref_no' => $preventive[0]->mt_amb_no, 'auto' => 'inc_auto_addr', 'rel' => 'maintaince', 'disabled' => 'disabled');
                                    echo get_break_maintaince_ambulance($amd_dt);
                                } else {
                                    $amd_dt = array('dst_code' => '', 'st_code' => '', 'auto' => 'inc_auto_addr', 'rel' => 'maintaince', 'disabled' => '');
                                    echo get_clo_comp_ambulance($amd_dt);
                                }
                                ?>

                            </div>

                        </div>

                    </div>

                    <div class="width2 float_left">
                        <div class="field_lable float_left width33"><label for="district">Base Location<span class="md_field">*</span></label></div>


                        <div class="filed_input float_left width50" id="amb_base_location">
<!--                            <input name="base_location" tabindex="23" class="form_input filter_required" placeholder="Base Location" type="text" data-base="search_btn" data-errors="{filter_required:'Base Location should not be blank!'}" value="<?= @$preventive[0]->mt_base_loc; ?>" readonly="readonly"   <?php echo $update; ?>>-->
                            <input name="base_location" tabindex="23" class="form_input filter_required mi_autocomplete" placeholder="Base Location" type="text" data-base="search_btn" data-errors="{filter_required:'Base Location should not be blank!'}" data-value="<?= @$preventive[0]->mt_base_loc; ?>" value="<?= @$preventive[0]->mt_base_loc; ?>" readonly="readonly"   <?php echo $update;
                                echo $approve;
                                echo $rerequest; ?>  data-callback-funct="load_baselocation_ambulance" data-href="<?php echo base_url(); ?>auto/get_hospital">

                        </div>


                    </div>
                    <div class="width2 float_left">
                        <div class="field_lable float_left width33"><label for="district">Ambulance Type<span class="md_field">*</span></label></div>


                        <div class="filed_input float_left width50" id="amb_type_div_outer">

                            <?php //var_dump($preventive[0]->amb_type); ?>
                            <select name="amb_type" class="filter_required" data-errors="{filter_required:'Ambulance type should not be blank'}" <?php echo $approve;
                            echo $rerequest;
                            echo $update; ?> readonly="readonly" TABINDEX="5">

                                <option value="">Select Type</option>

<?php echo get_amb_type_by_id($preventive[0]->amb_type); ?>
                            </select>


                        </div>


                    </div>
                    <div class="width2 float_left">
                        <div class="field_lable float_left width33"><label for="district">Ambulance Owner</label></div>


                        <div class="filed_input float_left width50" id="amb_owner">


                            <input name="amb_model" tabindex="23" class="form_input " placeholder="Owner" type="text"  data-errors="{filter_required:'Estimate cost should not be blank!',filter_maxlength:'Amount at max 6 digit long',filter_number:'Amount in a number format'}" value="<?= @$preventive[0]->mt_owner; ?>"    <?php echo $update;
echo $approve;
echo $rerequest; ?>>
                        </div>


                    </div>
                    <div class="width2 float_left">
                        <div class="field_lable float_left width33"><label for="district">Ambulance Make<span class="md_field"></span></label></div>


                        <div class="filed_input float_left width50" id="amb_type_div">

                            <input name="ambt_make" tabindex="23" class="form_input " placeholder="Make" type="text"  data-errors="{filter_required:'Ambulance Make should not be blank!',filter_maxlength:'Amount at max 6 digit long',filter_number:'Amount in a number format'}" value="<?= @$preventive[0]->mt_make; ?>"    <?php echo $update;
echo $approve;
echo $rerequest; ?>>

                        </div>


                    </div>
                                    <div class="field_row width100" id="maintance_scrape_odometer">

                    <div class="width2 float_left">

                        <div class="field_lable float_left width33"><label for="mt_ex_onroad_datetime">Previous Odometer<span class="md_field">*</span></label></div>

                        <div class="filed_input float_left width50" >
                            <input type="text" name="previous_odometer" id="previous_odometer" onkeyup="sum();"  value="<?= $preventive[0]->mt_previos_odometer; ?>" class="filter_required" placeholder="Previous Odometer" data-errors="{filter_required:'Previous Odometer should not be blank'}" TABINDEX="8" <?php echo $update;
                    echo $approve;
                    echo $rerequest; ?>>



                        </div> 
                    </div> 
                    <div class="width2 float_left">
                        <div class="field_lable float_left width33"><label for="previous_odometer">Current Odometer<span class="md_field">*</span></label></div>

                        <div class="filed_input float_left width50" >
                            <input type="text" name="in_odometer"  value="<?= @$preventive[0]->mt_in_odometer; ?>" class="filter_required" placeholder="Previous Odometer" data-errors="{filter_required:'Please select Workshop Name from dropdown list'}" TABINDEX="8"  <?php echo $update; echo $approve; ?>>


                        </div>
                    </div>
                </div>


                    <div class="field_row width100">
                   
<!--                   <div class="filed_input float_left width2">

                        <div class="field_lable float_left width33"> <label for="mt_stnd_remark">Scrap Ambulance Inactive<span class="md_field">*</span></label></div>


                        <div class="filed_input float_left width50">

                            <select name="maintaince[mt_inactive]" tabindex="8" class="filter_required" data-errors="{filter_required:'Scrap Ambulance should not be blank!'}" <?php echo $update; echo $approve;?> > 
                                <option value="" >Select Standard Remark</option>
                                <option value="Inactive" <?php if (@$preventive[0]->mt_inactive == 'Inactive') { echo "selected=selected"; }?> >Inactive</option>
                                  <option value="Active" <?php if (@$preventive[0]->mt_inactive == 'Active') { echo "selected=selected"; }?> >Active</option> 
                            </select>
                        </div>
                    </div>-->
                    <div class="width2 float_left">
                    <div class="field_lable float_left width33"><label for="off_road_date">Scrap Added Date/Time<span class="md_field">*</span></label></div>
                    <div class="filed_input float_left width50" >
                        <input type="text" name="maintaince[mt_scrap_added_date]"  value="<?= @$preventive[0]->mt_scrap_added_date; ?>" class="mi_timecalender filter_required" placeholder="Scrap Added Date/Time" data-errors="{filter_required:'Scrap Added Date/Time should not be blank'}" TABINDEX="8" <?php echo $update; echo $approve;?>>
                    </div>
                </div>
                                      <div class="width2 float_left">

<div class="field_lable float_left width33"><label for="mt_ex_onroad_datetime">Expected Onroad Date/Time <span class="md_field"></span></label></div>

<div class="filed_input float_left width50" >
    <input type="text" name="maintaince[mt_ex_onroad_datetime]"  value="<?= @$preventive[0]->mt_ex_onroad_datetime; ?>" class="mi_timecalender  <?php if($type == 'Rerequest' && ( $clg_group == 'UG-FLEETDESK' || $clg_group =='UG-FleetManagement')){ echo "filter_required"; } ?>" placeholder="Expected On-Road Date/Time" data-errors="{filter_required:'Expected On-Road Date/Time should not be blank'}" TABINDEX="8" <?php echo $update; echo $approve; if($type == 'Rerequest' && ( $clg_group == 'UG-FLEETDESK' || $clg_group =='UG-FleetManagement')){ echo $mo_rerequest; }else{ echo $rerequest; } ?>>



</div>
</div>
                    </div>

                    <div class="field_row width100">



                        <div class="width2 float_left">
                            <div class="field_lable float_left width33"> <label for="mt_remark">Remark<span class="md_field"></span></label></div>


                            <div class="filed_input float_left width50" >
                                <textarea style="height:60px;" name="maintaince[mt_remark]" class="" TABINDEX="16" data-maxlen="1600"  data-errors="{filter_required:'Remark should not be blank'}" <?php echo $update;
echo $approve;
if ($type == 'Rerequest' && ( $clg_group == 'UG-FLEETDESK' || $clg_group == 'UG-FleetManagement')) {
    echo $mo_rerequest;
} else {
    echo $rerequest;
} ?>><?= @$preventive[0]->mt_remark; ?></textarea>
                            </div>
                        </div>


                        <div class="">
                            <div class="width2 float_left">
                                <div class="field_lable float_left width33"> <label for="added_by">Added By<span class="md_field"></span></label></div>


                                <div class="filed_input float_left width50" >
<?php
if (empty($preventive)) {
    $clg_ref_id = $clg_ref_id;
} else {
    $clg_ref_id = $preventive[0]->added_by;
}
?>
                                    <input id="added_by" type="text" name="accidental[added_by]" class=""  data-errors="{filter_either_or:'Answer is required'}" TABINDEX="10.<?php echo $key; ?>" value="<?= @$clg_ref_id; ?>" disabled="disabled">
                                </div>
                            </div>

                        </div>
                    </div>

                </div>
            </div>


<?php
if ($update) {
    // $previous_odo = $preventive[0]->mt_in_odometer;
    // $previous_odo_end =$preventive[0]->mt_in_odometer+300;
    ?>
                <div class="field_row width100  fleet"><div class="single_record_back">Closer Report</div></div>

                 <input type="hidden" name="previous_odometer" value="<?= @$preventive[0]->mt_in_odometer ; ?>">
                <input type="hidden" name="maintaince[mt_id]" id="ud_mt_id" value="<?= @$preventive[0]->mt_id ?>">
                <input type="hidden" name="maintaince[mt_district_id]" id="ud_mt_id" value="<?= @$preventive[0]->mt_district_id ?>">
                        <input type="hidden" name="maintaince_ambulance" value="<?= @$preventive[0]->mt_amb_no; ?>">
          

                <div class="field_row width100">
                    <div class="width2 float_left">
                    <div class="field_lable float_left width33"><label for="end_odometer">End Odometer<span class="md_field">*</span></label></div>

                    <div class="filed_input float_left width50" >
                        <input type="text" name="mt_end_odometer" value="<?php if ($preventive[0]->mt_end_odometer != 0) { echo $preventive[0]->mt_end_odometer; } ?>" class="filter_required filter_valuegreaterthan[<?= @$preventive[0]->mt_in_odometer; ?>] filter_maxlength[7]" placeholder="End Odometer" data-errors="{filter_required:'End Odometer should not be blank',filter_valuegreaterthan:'In Odometer should greater than or equlto Previous Odometer'filter_valuegreaterthan:'End Odometer should greater than or equlto Previous Odometer'}" TABINDEX="8" <?php if ($preventive[0]->mt_end_odometer != 0) {
            echo "disabled";
        } ?>>


                    </div>
                </div>
                    <div class="width2 float_left">
                        <div class="field_lable float_left width33"> <label for="mt_on_remark">Remark</label></div>


                        <div class="filed_input float_left width50" >
                            <textarea style="height:60px;" name="maintaince[mt_on_remark]" class="" TABINDEX="16" data-maxlen="1600"  data-errors="{filter_required:'Remark should not be blank'}"><?= @$preventive[0]->mt_on_remark; ?></textarea>
                        </div>
                    </div>
                </div>



<?php } ?>

<?php if ($approve) { ?>

                <div class="field_row width100  fleet"><div class="single_record_back">Approval Information</div></div>
                <input type="hidden" name="app[mt_id]" id="ud_mt_id" value="<?= @$preventive[0]->mt_id ?>">
              
                <input type="hidden" name="maintaince_ambulance" value="<?= @$preventive[0]->mt_amb_no; ?>">
                                <input type="hidden" name="mt_inactive" value="<?= @$preventive[0]->mt_inactive; ?>">

                
                <div class="field_row width100 hide_underprocess_remark">
                     <div class="field_row width100">
                        <div class="width2 float_left">
                            <div class="field_lable float_left width33"><label for="end_odometer">Approval<span class="md_field">*</span></label></div>

                            <div class="filed_input float_left width50" >
                            
                            
                        
                        <div class="radio_button_div">
                            <input  data-base="<?=@$current_data[0]->clg_ref_id?>"  id="approve" type="radio" name="app[mt_approval]" value="1" class="approve" data-errors="{}" <?php echo $gender['male'];?> TABINDEX="16" checked  <?php echo $view;?>>Accepted
                        </div>
                        <div class="radio_button_div">
                            <input data-base="<?=@$current_data[0]->clg_ref_id?>"  id="approve" type="radio" name="app[mt_approval]" value="2" <?php echo $gender['female'];?> class="approve" data-errors="{filter_required:'Gender should not be blank'}" TABINDEX="17"  <?php echo $view;?>>Rejected
                        </div>

                            </div>
                        </div>
                     </div>
                    <div class="width100 float_left">
                        <div class="field_lable float_left" style="width: 16.5%;"><label for="end_odometer">Remark<span class="md_field">*</span></label></div>

                        <div class="filed_input float_left" style="width: 78%;">

                            <textarea style="height:60px;" name="app[mt_app_remark]" class="filter_required" TABINDEX="16" data-maxlen="1600"  data-errors="{filter_required:'Remark should not be blank'}" <?php echo $update; ?>><?= @$preventive[0]->mt_app_remark; ?></textarea>

                        </div>
                    </div>

                </div>


            </div>

<?php } ?>  
<?php if ($rerequest) { ?>


            <div class="field_row width100  fleet"><div class="single_record_back">Modify-Request Information</div></div>
            <input type="hidden" name="app[mt_id]" id="ud_mt_id" value="<?= @$preventive[0]->mt_id ?>">
            <input type="hidden" name="previous_odometer" value="<?= @$preventive[0]->mt_previos_odometer; ?>">
            <input type="hidden" name="maintaince_ambulance" value="<?= @$preventive[0]->mt_amb_no; ?>">
            <div class="field_row width100">


                <div class="field_row width100">
                    <div class="width100 float_left">
                        <div class="field_lable float_left" style="width: 16.5%;"><label for="end_odometer">Remark<span class="md_field">*</span></label></div>

                        <div class="filed_input float_left" style="width: 78%;">

                            <textarea style="height:60px;" name="re_request[re_request_remark]" class="filter_required" TABINDEX="16" data-maxlen="1600"  data-errors="{filter_required:'Remark should not be blank'}" <?php echo $update; ?>><?= @$preventive[0]->re_request_remark; ?></textarea>

                        </div>
                    </div>

                </div>

                <div class="field_row width100 ap">
                    <div class="field_lable float_left" style="width: 16.5%;"><label for="end_odometer">Photo<span class="md_field">*</span></label></div>
                    <div class="filed_input float_left" style="width: 50%;">
                        <input data-base="<?= @$current_data[0]->clg_ref_id ?>" id="rerequest_reset_img" type="file" name="amb_photo[]" accept="image/jpg,image/jpeg,image/png" TABINDEX="18"  <?php echo $view; ?> multiple="multiple"  <?php echo $update; ?>> 
                    </div>
                </div>
            </div>
            <div class="field_row width100 ap">
                <div class="button_box field_lable float_left" style="width: 60%;">
                    <input type="button" name="Reset" value="Reset Image" class="btn" id="remove_reset_img">
                </div>
            </div>

<?php } ?> 



<?php if (!@$view_clg) { ?>
            <div class="button_field_row width100 margin_auto save_btn_wrapper">
                <div class="button_box">
                    <input type="button" name="submit" value="<?php if ($update) { ?>Update<?php } elseif ($approve) { ?>Approve<?php } elseif ($rerequest) { ?>Modify-Request<?php } else { ?>Submit<?php } ?>" class="btn submit_btnt form-xhttp-request accept_btn " data-href='<?php echo base_url(); ?>ambulance_maintaince/<?php if ($update) { ?>update_scrape_vahicle<?php } elseif ($approve) { ?>approve_scrape_vahicle<?php } elseif ($rerequest) { ?>update_re_request_preventive_maintaince<?php } else { ?>save_scrape_vahicle<?php } ?>' data-qr='output_position=content&amp;module_name=clg&amp;page_no=<?php echo @$page_no; ?>'  TABINDEX="23" id="prev_<?php echo @$preventive[0]->mt_id; ?>">

        <!--<input type="reset" name="reset" value="Reset" class="btn reset_btn register_view_reset"  TABINDEX="24">-->
                </div>
            </div>

<?php } ?>



    </div>    
  
</form>
<style>
    .mi_loader{
        display: none !important;
    }
</style>
