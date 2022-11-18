<div id="dublicate_id"></div>

<?php
if ($type == 'Update') {
    $update = 'disabled';
}if ($type == 'Approve') {
    $Approve = 'disabled';
}if ($type == 'Re_request') {
    $Re_request = 'disabled';
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
            <?php if ($update) {
                ?>  
                <div class="field_row width100  fleet" ><div class="single_record_back">Previous  Info</div></div>
            <?php } ?>
            <div class="width100">

                <div class="field_row width100">

                    <div class="width2 float_left">
                        <div class="field_lable float_left width33"><label for="district">State<span class="md_field">*</span></label></div>
                        <div class="filed_input float_left width50"> <div id="ambulance_state">



                                <?php
                               // var_dump($equp_data[0]->eq_state_code);
                                if ($equp_data[0]->eq_state_code != '') {
                                    $st = array('st_code' => $equp_data[0]->eq_state_code, 'auto' => 'inc_auto_addr', 'rel' => 'incient', 'disabled' => 'disabled');
                                } else {
                                    $st = array('st_code' => '', 'auto' => 'amb_auto_addr', 'rel' => 'incient', 'disabled' => '');
                                   // $st='ojmo';
                                }


                                echo get_state_clo_comp_ambulance($st);
                                ?>

                            </div>

                        </div>

                    </div>
                    <div class="width2 float_left">    
                        <div class="field_lable float_left width33"><label for="district">District<span class="md_field">*</span></label></div>   <div class="filed_input float_left width50">
                            <div id="incient_district">
                                <?php
                                if (@$equp_data[0]->eq_state_code != '') {
                                    $dt = array('dst_code' => @$equp_data[0]->eq_district_code, 'st_code' => @$equp_data[0]->eq_state_code, 'auto' => 'inc_auto_addr', 'rel' => 'incient', 'disabled' => 'disabled');
                                } else {
                                    $dt = array('dst_code' => '', 'st_code' => '', 'auto' => 'amb_auto_addr', 'rel' => 'incient', 'disabled' => '');
                                }

                                echo get_district_closer_amb($dt);
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="field_row width100">

                    <div class="width2 float_left">
                        <div class="field_lable float_left width33"><label for="district">Ambulance Number<span class="md_field">*</span></label></div>
                        <div class="filed_input float_left width50">
                            <div id="incient_ambulance">



                                <?php
                                if (@$equp_data[0]->eq_state_code != '') {
                                    $dt = array('dst_code' => @$oxygen_data[0]->eq_district_code, 'st_code' => @$equp_data[0]->eq_state_code, 'amb_ref_no' => @$equp_data[0]->eq_amb_ref_no, 'auto' => 'inc_auto_addr', 'rel' => 'incient', 'disabled' => 'disabled');
                                } else {
                                    $dt = array('dst_code' => '', 'st_code' => '', 'auto' => 'amb_auto_addr', 'rel' => 'incient', 'disabled' => '');
                                }


                                echo get_clo_comp_ambulance($dt);
                                ?>

                            </div>

                        </div>

                    </div>

                    <div class="width2 float_left">
                        <div class="field_lable float_left width33"><label for="district">Base Location<span class="md_field">*</span></label></div>


                        <div class="filed_input float_left width50" id="amb_base_location">
                            <input name="main[eq_base_location]" tabindex="23" class="form_input filter_required" placeholder=" Base Location" type="text" data-base="search_btn" data-errors="{filter_required:'Base Location should not be blank!'}" value="<?= @$equp_data[0]->hp_name; ?>" readonly="readonly"   <?php echo $update; echo $Approve; echo $Re_request; ?>>

                        </div>


                    </div>
                      <div class="width2 float_left">
                        <div class="field_lable float_left width33"><label for="district">Ambulance Make<span class="md_field">*</span></label></div>


                        <div class="filed_input float_left width50" id="amb_type_div">
                           
                            <input name="ambt_make" tabindex="23" class="form_input " placeholder="Make" type="text"  data-errors="{filter_required:'Estimate cost should not be blank!',filter_maxlength:'Amount at max 6 digit long',filter_number:'Amount in a number format'}" value="<?= @$preventive[0]->amb_model; ?>"    <?php echo $update; echo $approve; echo $rerequest;?>>

                        </div>


                    </div>
                    <div class="width2 float_left">
                        <div class="field_lable float_left width33"><label for="district">Ambulance Model<span class="md_field">*</span></label></div>


                        <div class="filed_input float_left width50" id="amb_amb_model">
                            

                            <input name="amb_model" tabindex="23" class="form_input " placeholder="Model" type="text"  data-errors="{filter_required:'Estimate cost should not be blank!',filter_maxlength:'Amount at max 6 digit long',filter_number:'Amount in a number format'}" value="<?= @$preventive[0]->amb_model; ?>"    <?php echo $update; echo $approve; echo $rerequest;?>>
                        </div>


                    </div>
                    <div class="field_row width100">
                <div class="width2 float_left">
                        
                        <div class="field_lable float_left width33"><label for="breakdown_date">Breakdown Date<span class="md_field">*</span></label></div>

                        <div class="filed_input float_left width50" >
                              <input type="text" name="breakdown_date"  value="<?= @$equp_data[0]->mt_breakdown_date; ?>" class="filter_required mi_timecalender" id="breakdown_date" placeholder="Breakdown date and time" data-errors="{filter_required:'Accident date should not be blank'}" TABINDEX="8" <?php echo $update; echo $Approve; echo $Re_request; ?>>
                              
                           
                           
                        </div>
                    </div>
                    <div class="width2 float_left">
                        <div class="field_lable float_left width33"> <label for="estimatecost">Estimate cost<span class="md_field">*</span></label></div>


                        <div class="filed_input float_left width50" >
                        <input name="Estimatecost" tabindex="23" class="form_input filter_required" placeholder="Estimate cost" type="text"  data-errors="{filter_required:'Estimate cost should not be blank!'}" value="<?= @$equp_data[0]->mt_estimatecost; ?>"    <?php echo $update; echo $Approve; echo $Re_request; ?>>
                     </div>
                    </div>
                </div>
                    <div class="field_row width100">
                        <div class="width2 float_left">
                            <div class="field_lable float_left width33"><label for="city">Shift Type<span class="md_field">*</span></label></div>

                            <div class="filed_input float_left width50">
                                <select name="main[eq_shift_type]" tabindex="8"  class="filter_required" data-errors="{filter_required:'Supervisor Name should not be blank!'}"  <?php echo $update; echo $Approve; echo $Re_request; ?>> 
                                    
                                    <option value="" <?php echo $disabled; ?>>Select Shift Type</option>
                                    <?php echo get_shift_type(@$equp_data[0]->eq_shift_type); ?>
                                </select>

                            </div>
                        </div>
                        <div class="width2 float_left">
                            <div class="field_lable float_left width33"><label for="city">Equipments<span class="md_field">*</span></label></div>
                            <div class="filed_input float_left width50">
                                <input type="text" name="main[eq_equip_name]" tabindex="1"  class="mi_autocomplete width1 filter_required" data-href="<?php echo base_url(); ?>auto/get_inv_eqp/dq/<?php echo $equp_data[0]->eqp_id; ?>" data-value="<?= @$equp_data[0]->eqp_name; ?>" value="<?php echo @$equp_data[0]->eqp_id; ?>" data-errors="{filter_required:'Equipments should not be blank!'}" placeholder="Equipment Name" autocomplete="off" data-auto="EQP"  data-nonedit="yes" <?php echo $update; echo $Approve; echo $Re_request; ?> >
                                
                            </div>
                        </div>

                    </div>

                    <div class="field_row width100">

                        <div class="width2 float_left">
                            <div class="field_lable float_left width33"> <label for="amount">Due Date Time<span class="md_field">*</span></label></div>
                            <div class="width50 float_left">

                                <input name="main[eq_due_date_time]" tabindex="20" class="form_input mi_timecalender filter_required" placeholder="Date Time" type="text"  data-errors="{filter_required:'Expected Date of Delivery should not be blank!'}" value="<?= @$equp_data[0]->eq_due_date_time; ?>"  <?php echo $update; echo $Approve; echo $Re_request; ?>>

                            </div>
                        </div>
                        <div class="filed_input float_left width2">

                            <div class="field_lable float_left width33"> <label for="mt_stnd_remark">Standard Remark<span class="md_field">*</span></label></div>


                            <div class="filed_input float_left width50">
                                <select name="main[eq_standard_remark]" tabindex="8"  id="standard_remark" class="filter_required" data-errors="{filter_required:'Standard Remark should not be blank!'}"   <?php echo $update; echo $Approve; echo $Re_request; ?>> 
                                    <option value=""<?php echo $disabled; ?>>Select Standard Remark</option>
                                    <option value="request_send"  <?php
                                    if (@$equp_data[0]->eq_standard_remark == 'request_send') {
                                        echo "selected";
                                    }
                                    ?>>Equipment Maintenance send sucessfully.</option>  
                                    <option value="other"  <?php
                                    if (@$equp_data[0]->eq_standard_remark == 'other') {
                                        echo "selected";
                                    }
                                    ?>>other</option> 
                                </select>
                            </div>
                        </div>

                    </div>

                    <div class="field_row width100">
                        <div class="width2 float_left">
                            <div id="remark_other_textbox">
                            </div>
                        </div>
                    </div>

                    <input type="hidden" name="main[eq_id]"  value="<?= @$equp_data[0]->eq_id ?>">

                    <?php
                    if ($update) {
                        ?>  
                        <div class="field_row width100  fleet" ><div class="single_record_back">Current Info</div></div>

                        <div class="field_row width100">

                            <div class="width2 float_left">

                                <div class="field_lable float_left width33"><label for="completed_datetime">Completed Date/Time<span class="md_field">*</span></label></div>

                                <div class="filed_input float_left width50" >
                                    <input type="text" name="main[eq_completed_date_time]"  value=" <?php
                                    if (@$equp_data[0]->eq_completed_date_time != '0000-00-00 00:00:00' && @$equp_data[0]->eq_completed_date_time != '') {
                                        echo @$equp_data[0]->of_on_road_ambulance;
                                    }
                                    ?>" class="filter_required mi_timecalender" placeholder=" Date/Time" data-errors="{filter_required:' Date/Time should not be blank'}" TABINDEX="8" <?php
                                           if (@$equp_data[0]->eq_completed_date_time != '0000-00-00 00:00:00' && @$equp_data[0]->eq_completed_date_time != '') {
                                               echo "disabled";
                                           }
                                           ?>>



                                </div>
                            </div>
                            <div class="filed_input float_left width2">

                                <div class="field_lable float_left width33"> <label for="manager_name">Manager Name<span class="md_field">*</span></label></div>


                                <div class="filed_input float_left width50">
                                    <input name="main[eq_manager_name]" tabindex="20" class="form_input  filter_required" placeholder="Manager Name" type="text"  data-errors="{filter_required:'Manager Name should not be blank!'}" value="<?= @$equp_data[0]->of_card_date; ?>"  >
                                </div>
                            </div>
                        </div>
                        <div class="field_row width100">

                            <div class="width2 float_left">
                                <div class="field_lable float_left width33"> <label for="mt_on_remark">Remark<span class="md_field">*</span></label></div>


                                <div class="filed_input float_left width50" >
                                    <textarea style="height:60px;" name="main[eq_remark]" class="filter_required" TABINDEX="16" data-maxlen="1600"  data-errors="{filter_required:'Remark should not be blank'}"><?= @$oxygen_data[0]->mt_on_remark; ?></textarea>
                                </div>
                            </div>
                        </div>


                    <?php } ?>

                    <div class="width100">
                     <div class="field_row width100">
                    <div class="field_row width100 float_left">

                         <div class="field_row width100 float_left">
                             
                                <div class="field_lable float_left width15">
                                    <label for="photo">Photo</label>
                                </div>
                                
                                <div class="button_box">
                                <input type="button" name="Reset" value="Reset Image" class="btn" id="reset_img">
                                </div>

                                <div class="field_row filter_width">

                                    <div class="field_lable">

<?php if (@$update) { ?>

                                            <div class="prev_profile_pic_box">

                                                <div class="clg_photo_field edit_form_pic_box" >

                                                    <?php
                                                    $name = $preventive[0]->mt_amb_photo;

                                                    $pic_path = FCPATH . "uploads/ambulance/" . $name;

                                                    if (file_exists($pic_path)) {
                                                        $pic_path1 = base_url() . "uploads/ambulance/" . $name;
                                                    }
                                                    $blank_pic_path = base_url() . "themes/backend/images/blank_profile_pic.png";
                                                    ?>

                                                </div>

                                            </div>

                                        </div>
                            <?php } ?>

                                </div>
                            </div>
                            
                            <div class="filed_input outer_clg_photo field">
<!--                                <input type="hidden" name="prev_photo" value="<?= @$current_data[0]->clg_photo ?>"  <?php echo $update;?>/>-->
                                <input data-base="<?= @$current_data[0]->clg_ref_id ?>" id="files" type="file" name="amb_photo[]" accept="image/jpg,image/jpeg,image/png" TABINDEX="18"  <?php echo $view; ?> multiple="multiple"  <?php echo $update;?>>
                                
        <?php if ($update) {
            //var_dump($media);
            foreach($media as $img) {
                
                $name = $img->media_name;
                   $pic_path = FCPATH . "uploads/ambulance/" . $name;

                                                    if (file_exists($pic_path)) {
                                                        $pic_path1 = base_url() . "uploads/ambulance/" . $name;
                                                    }
                                                    $blank_pic_path = base_url() . "themes/backend/images/blank_profile_pic.png";
            ?>
            

                                        <div class="clg_photo float_right" style="background: url('<?php
            if (file_exists($pic_path)) {
                echo $pic_path1;
            } else {
                echo $blank_pic_path;
            }
            ?>') no-repeat left center; background-size: cover; min-height: 75px;"  <?php echo $view; ?>></div>


        <?php } } ?>
              </div>
                </div>
                </div>
                </div>


                <?php if($Approve)
                            {  ?>
                               <div class="field_row width100  fleet">
                        <div class="single_record_back">Re-Request Information</div>
                        <table class="table report_table">

                            <tr>   
                                <th nowrap>Request Date</th>     
                                <th nowrap>Request by</th>        
                                <th nowrap>Re-Request Remark</th>
                                <th colspan="5" >Photo</th>
                            </tr>
                            <?php  
                            if ($his > 0) {
                            //$count = 1;
                           foreach ($his as $stat_data) {
                              /// var_dump($stat_data);
                              // die();
                           
                            ?>
                            <tr>
                                <td><?php echo $stat_data->re_request_date; ?></td>  
                                <td><?php echo $stat_data->re_requestby; ?></td>
                                <td><?php echo $stat_data->re_request_remark; ?></td> 
                                <?php /*
                                    $stat_data->re_request_remark;
                                */ 
                                     if($stat_data->his_photo){
                                        foreach($stat_data->his_photo as $img){

                                        foreach($img as $im){
                                           
                                            $name = $im->media_name;
                                            //print_r($img);
                                            $pic_path = FCPATH . "uploads/ambulance/" . $name;
                                            if (file_exists($pic_path)) {
                                                $pic_path1 = base_url() . "uploads/ambulance/" . $name;
                                            }
                                            $blank_pic_path = base_url() . "themes/backend/images/blank_profile_pic.png";
                                 ?>
                                <td><a class="ambulance_photo" target="blank" href="<?php if (file_exists($pic_path)) { echo $pic_path1; } else { echo $blank_pic_path; } ?>" style="background: url('<?php if (file_exists($pic_path)) { echo $pic_path1;  } else { echo $blank_pic_path; }  ?>') no-repeat left center; background-size: contain; height: 75px; width:100px;margin:5px;float:left;"  <?php echo $view; ?>></a></td>
                                        <?php }
                                        }}
                                ?>
                            </tr>
                            <?php
                        }
                    } else { ?>

                        <tr><td colspan="3" class="no_record_text">No history Found</td></tr>

                    <?php } ?>   

                </table>
                    </div>




                    <div class="field_row width100  fleet"><div class="single_record_back">Approval Information</div></div>
                    <input type="hidden" name="app[eq_id]" id="eq_id" value="<?= @$equp_data[0]->eq_id; ?>">
                    <input type="hidden" name="previos_odometer" value="<?=@$preventive[0]->mt_in_odometer;?>">
                    <input type="hidden" name="maintaince_ambulance" value="<?=@$preventive[0]->mt_amb_no;?>">
                    <div class="field_row width100">
                        <div class="width2 float_left">
                            <div class="field_lable float_left width33"><label for="end_odometer">Approval<span class="md_field">*</span></label></div>

                            <div class="filed_input float_left width50" >
                            <?php //$gender[@$current_data[0]->clg_gender] = "checked"; ?>
                        
                        <div class="radio_button_div">
                            <input  data-base="<?=@$current_data[0]->clg_ref_id?>"  id="approve" type="radio" name="app[mt_approval]" value="1" class="approve" data-errors="{}" <?php echo $gender['male'];?> TABINDEX="16" checked  <?php echo $view;?>>Accepted
                        </div>
                        <div class="radio_button_div">
                            <input data-base="<?=@$current_data[0]->clg_ref_id?>"  id="approve" type="radio" name="app[mt_approval]" value="0" <?php echo $gender['female'];?> class="approve" data-errors="{filter_required:'Gender should not be blank'}" TABINDEX="17"  <?php echo $view;?>>Rejected
                        </div>

                            </div>
                        </div>
                        <div class="width2 float_left">

                            <div class="field_lable float_left width33"><label for="mt_onroad_datetime">On-road Date/Time<span class="md_field">*</span></label></div>

                            <div class="filed_input float_left width50" >
                               
                                  <input type="text" name="app[mt_app_onroad_datetime]"  value=" <?php if($preventive[0]->mt_onroad_datetime != '0000-00-00 00:00:00' && $preventive[0]->mt_onroad_datetime != ''){ echo $preventive[0]->mt_onroad_datetime;}?>" class="filter_required OnroadDate" placeholder="On-road Date/Time" data-errors="{filter_required:'On-road Date/Time should not be blank'}" TABINDEX="8" <?php if($preventive[0]->mt_onroad_datetime != '0000-00-00 00:00:00' && $preventive[0]->mt_onroad_datetime != ''){ echo "disabled";}?> id="mt_onroad_datetime">



                            </div>
                        </div>
                    </div>

                    <div class="field_row width100">
                        <div class="width100 float_left">
                            <div class="field_lable float_left" style="width: 16.5%;"><label for="end_odometer">Remark<span class="md_field">*</span></label></div>

                            <div class="filed_input float_left" style="width: 78%;">
                            
                            <textarea style="height:60px;" name="app[mt_app_remark]" class="filter_required" TABINDEX="16" data-maxlen="1600"  data-errors="{filter_required:'Remark should not be blank'}" <?php echo $update;?>><?= @$preventive[0]->mt_remark; ?></textarea>

                            </div>
                        </div>
           
                    </div>
                    
                    <div class="field_row width100 ap">
                        <div class="width2 float_left">
                            <div class="field_lable float_left width33"><label for="end_odometer">Approved Estimate Amount<span class="md_field"></span></label></div>

                            <div class="filed_input float_left width50" >
                            
                            <input type="text" name="app[mt_app_est_amt]"  value=" <?php if($preventive[0]->mt_onroad_datetime != '0000-00-00 00:00:00' && $preventive[0]->mt_onroad_datetime != ''){ echo $preventive[0]->mt_onroad_datetime;}?>" class=" OnroadDate" placeholder="On-road Date/Time" data-errors="{filter_required:'On-road Date/Time should not be blank'}" TABINDEX="8" <?php if($preventive[0]->mt_onroad_datetime != '0000-00-00 00:00:00' && $preventive[0]->mt_onroad_datetime != ''){ echo "disabled";}?> id="mt_onroad_datetime">

                            </div>
                        </div>
                        <div class="width2 float_left">

                            <div class="field_lable float_left width33"><label for="mt_onroad_datetime">Repairing Time<span class="md_field">*</span></label></div>

                            <div class="filed_input float_left width50" >
                               
                                  <input type="text" name="app[mt_app_rep_time]"  value=" <?php if($preventive[0]->mt_onroad_datetime != '0000-00-00 00:00:00' && $preventive[0]->mt_onroad_datetime != ''){ echo $preventive[0]->mt_onroad_datetime;}?>" class=" OnroadDate" placeholder="Repairing Time" data-errors="{filter_required:'On-road Date/Time should not be blank'}" TABINDEX="8" <?php if($preventive[0]->mt_onroad_datetime != '0000-00-00 00:00:00' && $preventive[0]->mt_onroad_datetime != ''){ echo "disabled";}?> id="mt_onroad_datetime">



                            </div>
                        </div>
                    </div>
 </div> 
                                

                           <?php } ?>
                           <?php if ($Re_request) {  ?>
                    
                    <div class="field_row width100  fleet">
                        <div class="single_record_back">Approve & Reject Information</div>
                        <table class="table report_table">

                            <tr>   
                                <th nowrap>Date</th>     
                                <th nowrap>Approve/Reject by</th>        
                                <th nowrap>Remark</th>
                                <th nowrap>On Road Date</th>        
                                <th nowrap>Status</th>
                            </tr>
                            <?php  //var_dump($his);
                            if ($app_rej_his > 0) {
                            //$count = 1;
                           foreach ($app_rej_his as $stat_data) { 
                               if($stat_data->re_approval_status=="1"){$re_approval_status="Approved";}else{$re_approval_status="Reject";}?>
                            <tr>
                                <td><?php echo $stat_data->re_rejected_date; ?></td>  
                                <td><?php echo $stat_data->re_rejected_by; ?></td>
                                <td><?php echo $stat_data->re_remark; ?></td> 
                                <td><?php echo $stat_data->re_app_onroad_datetime; ?></td> 
                                <td><?php echo $re_approval_status; ?></td> 
                            </tr>
                            <?php
                        }
                    } else { ?>

                        <tr><td colspan="3" class="no_record_text">No history Found</td></tr>

                    <?php } ?>   

                </table>
                    </div>

                    <div class="field_row width100  fleet"><div class="single_record_back">Re-Request Information</div></div>
                    <input type="hidden" name="app[mt_id]" id="ud_mt_id" value="<?= @$preventive[0]->mt_id ?>">
                    <input type="hidden" name="previos_odometer" value="<?=@$preventive[0]->mt_in_odometer;?>">
                    <input type="hidden" name="maintaince_ambulance" value="<?=@$preventive[0]->mt_amb_no;?>">
                    <div class="field_row width100">
                        
                      
                    <div class="field_row width100">
                        <div class="width100 float_left">
                            <div class="field_lable float_left" style="width: 16.5%;"><label for="end_odometer">Remark<span class="md_field">*</span></label></div>

                            <div class="filed_input float_left" style="width: 78%;">
                            
                            <textarea style="height:60px;" name="app[re_request_remark]" class="filter_required" TABINDEX="16" data-maxlen="1600"  data-errors="{filter_required:'Remark should not be blank'}" <?php echo $update;?>><?= @$preventive[0]->re_remark; ?></textarea>

                            </div>
                        </div>
           
                    </div>
                    
                    <div class="field_row width100 ap">
                    <div class="field_lable float_left" style="width: 16.5%;"><label for="end_odometer">Photo<span class="md_field">*</span></label></div>
                    <div class="filed_input float_left" style="width: 50%;">
                        <input data-base="<?= @$current_data[0]->clg_ref_id ?>" id="rerequest_reset_img" type="file" name="amb_photo[]" accept="image/jpg,image/jpeg,image/png" TABINDEX="18"  <?php echo $view; ?> multiple="multiple"  <?php echo $update;?>> 
                    </div>
                     </div>
                    </div>
                    <div class="field_row width100 ap">
                    <div class="button_box field_lable float_left" style="width: 60%;">
                        <input type="button" name="Reset" value="Reset Image" class="btn" id="remove_reset_img">
                    </div>
                    </div>
                <?php } ?> 


                    <div class="button_field_row  margin_auto float_left width100 text_align_center">
                        <div class="button_box">
                            <input type="hidden" name="eqiup[req_group]"  value="EQUP">
                            <input type="button" name="submit" value="<?php if ($update) { ?>Update<?php } elseif($Approve){ ?>Approve<?php } elseif($Re_request){ ?>Re-Request<?php } else { ?>Save<?php } ?>" class="btn submit_btnt form-xhttp-request" data-href='<?php echo base_url(); ?>biomedical/<?php if ($update) { ?>update_equipment_maintaince<?php } elseif($Approve){ ?>update_approve_equipment_maintaince<?php } elseif($Re_request){ ?>update_re_request_equipment_maintaince<?php } else { ?>register_equipment_maintaince<?php } ?>' data-qr='output_position=content&amp;prof=<?php echo @$prof; ?>&amp;module_name=clg&amp;tlcode=<?php if ($update) { ?>MT-CLG-UPDATE<?php } else { ?>MT-CLG-ADD<?php } ?>&amp;page_no=<?php echo @$page_no; ?>'  TABINDEX="23" >
                            <input type="reset" name="reset" value="Reset" class="btn reset_btn register_view_reset"  TABINDEX="24"></div>
                    </div>
                </div>
            </div>
        </div>
    </div></form>

<div id="EQP_tmp" class="hide">

    <div class="EQP_blk blk ind_class"><div class="width100 display_inlne_block"><div class="remove_button_ind" style="float:right; cursor: pointer; height: 20px; width: 70px;">Remove</div></div><div class="field_row"><div class="filed_input"><input type="text" name="item[EQP][indx][id]" tabindex="1" value="" class="autocls width1" data-href="<?php base_url() ?>auto/get_inv_eqp/dq/<?php echo $eqp_type; ?>"  placeholder="Equipment Name" autocomplete="off" data-auto="EQP" data-nonedit="yes" id="EQPI_indx" data-callback-funct="EQPReq"></div></div><div class="field_row"><div class="filed_input"><input type="text" name="item[EQP][indx][qty]" tabindex="1" value="" class="width1 filter_if_not_empty[EQPI_indx] filter_required filter_number" data-errors="{filter_if_not_empty:'Item quantity should not be blank',filter_required:'Item quantity should not be blank','filter_number':'Item quantity should be in numbers'}" placeholder="Equipment Quantity"></div></div></div>

</div> 

<script>

$(document).ready(function() {
    

    if (window.File && window.FileList && window.FileReader) {

$("#rerequest_reset_img").on("change", function(e) {
    //alert();
  var files = e.target.files,
    filesLength = files.length;
  for (var i = 0; i < filesLength; i++) {
    var f = files[i]
    var fileReader = new FileReader();
    fileReader.onload = (function(e) {
      var file = e.target;
      $("<span class=\"pip\">" +
        "<img class=\"imageThumb\" src=\"" + e.target.result + "\" title=\"" + file.name + "\"/>" +
         +
        "</span>").insertAfter("#rerequest_reset_img");
        $("#remove_reset_img").click(function(){
    $("#rerequest_reset_img").val("");
    $("span[class=pip]").remove();
});
      $(".remove").click(function(){
        
      });
      
      
      // Old code here
      /*$("<img></img>", {
        class: "imageThumb",
        src: e.target.result,
        title: file.name + " | Click to remove"
      }).insertAfter("#files").click(function(){$(this).remove();});*/
      
    });
    fileReader.readAsDataURL(f);
  }
});
} else {
alert("Your browser doesn't support to File API")
}    

  if (window.File && window.FileList && window.FileReader) {

    $("#files").on("change", function(e) {
      var files = e.target.files,
        filesLength = files.length;
      for (var i = 0; i < filesLength; i++) {
        var f = files[i]
        var fileReader = new FileReader();
        fileReader.onload = (function(e) {
          var file = e.target;
          $("<span class=\"pip\">" +
            "<img class=\"imageThumb\" src=\"" + e.target.result + "\" title=\"" + file.name + "\"/>" +
             +
            "</span>").insertAfter("#files");
            $("#reset_img").click(function(){
        $("#files").val("");
        $("span[class=pip]").remove();
    });
          $(".remove").click(function(){
            
          });
          
          
          // Old code here
          /*$("<img></img>", {
            class: "imageThumb",
            src: e.target.result,
            title: file.name + " | Click to remove"
          }).insertAfter("#files").click(function(){$(this).remove();});*/
          
        });
        fileReader.readAsDataURL(f);
      }
    });
  } else {
    alert("Your browser doesn't support to File API")
  }
});
    
    jQuery(document).ready(function () {
    var jsDate = $("#offroad_datetime").val();
        var $mindate = new Date(jsDate);


        $('#mt_onroad_datetime').datetimepicker({
            dateFormat: "yy-mm-dd",
            minDate: $mindate,
            // minTime: jsDate[1],

        });
   $("#offroad_datetime").change(function(){
        var jsDate = $("#offroad_datetime").val();
        var $mindate = new Date(jsDate);


        $('.OnroadDate').datetimepicker({
            dateFormat: "yy-mm-dd ",
            minDate: $mindate,
            // minTime: jsDate[1],

        });
    });

    $('input[type=radio][name="app[mt_approval]"]').change(function(){
        //$("#ap").show();
        var app = $("input[name='app[mt_approval]']:checked").val();
        if(app == "1"){
            $(".ap").show();
        }else{
            $(".ap").hide();
        }
    });
    });

</script>