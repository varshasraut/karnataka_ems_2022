<div id="dublicate_id"></div>

<?php
if ($type == 'Update') {
    $update = 'disabled';
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
                        <div class="field_lable float_left width33 strong"><label for="district">State<span class="md_field">*</span></label></div>
                        <div class="filed_input float_left width50"> <div id="ambulance_state">



                                <?php
                                echo $preventive[0]->st_name;
                                 
                                ?>

                            </div>

                        </div>

                    </div>
                    <div class="width2 float_left">    
                        <div class="field_lable float_left width33 strong "><label for="district">District<span class="md_field">*</span></label></div>   
                        <div class="filed_input float_left width50">
                            <div id="maintaince_dist">
                               <?php
                                echo $preventive[0]->dst_name;
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="field_row width100">

                    <div class="width2 float_left">
                        <div class="field_lable float_left width33 strong"><label for="district">Ambulance Number<span class="md_field">*</span></label></div>
                        <div class="filed_input float_left width50">
                            <div id="maintaince_ambulance">

                                <?php echo $preventive[0]->mt_amb_no;?>

                            </div>

                        </div>

                    </div>

                    <div class="width2 float_left">
                        <div class="field_lable float_left width33 strong"><label for="district">Base Location<span class="md_field">*</span></label></div>


                        <div class="filed_input float_left width50" id="amb_base_location">
                           <?= @$preventive[0]->mt_base_loc; ?>

                        </div>


                    </div>
                    <div class="field_row width100">
                    <div class="width2 float_left">
                        <div class="field_lable float_left width33 strong"><label for="district">Ambulance Make<span class="md_field">*</span></label></div>
                        <div class="filed_input float_left width50"> <div id="ambulance_state">



                                <?php
                                echo $preventive[0]->mt_make;
                                 
                                ?>

                            </div>

                        </div>

                    </div>
                    <div class="width2 float_left">    
                        <div class="field_lable float_left width33 strong "><label for="district">Ambulance Model<span class="md_field">*</span></label></div>   
                        <div class="filed_input float_left width50">
                            <div id="maintaince_dist">
                               <?php
                                echo $preventive[0]->mt_module;
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="width100">
                
                    <div class="width2 float_left">
                        <div class="field_lable float_left width33 strong"><label for="mt_estimatecost">Estimate Cost<span class="md_field"></span></label></div>
                        <div class="filed_input float_left width50" >
                        <?=@$preventive[0]->mt_Estimatecost;?>
                        </div>
                    </div>
                    
                    <div class="width2 float_left">
                        
                        <div class="field_lable float_left width33 strong"><label for="informed_to">Informed To<span class="md_field"></span></label></div>

                        <div class="filed_input float_left width50" >
                            <?php   $informed_to = json_decode($preventive[0]->informed_to);
                               
                                    if(is_array($informed_to)){
                                        $informed_to = implode(',',$informed_to); 
                                        echo $informed_to; 
                                    } ?>
                        </div>
                    </div>
                </div>
                <div class="field_row width100">

<div class="width2 float_left">

    <div class="field_lable float_left width33 strong"> <label for="mobile_no">Pilot Id<span class="md_field">*</span></label></div>


    <div class="filed_input float_left width50">
        <?= @$preventive[0]->mt_pilot_id; ?>
    </div>
</div>
<div class="width2 float_left">
    <div class="field_lable float_left width33 strong"> <label for="mobile_no">Pilot Name<span class="md_field">*</span></label></div>


    <div class="filed_input float_left width50">
        <?= @$preventive[0]->mt_pilot_name; ?>

    </div>
</div>
</div>
                    <div class="field_row width100">
                        <!-- <div class="width2 float_left">
                            <div class="field_lable float_left width33 strong"><label for="city">Shift Type<span class="md_field"></span></label></div>

                            <div class="filed_input float_left width50">

                                    <?php echo show_shift_type($preventive[0]->mt_shift_id);?>
                                

                            </div>
                        </div> -->
                        <div class="width2 float_left">
                            <div class="field_lable float_left width33 strong"><label for="work_shop">Workshop Name<span class="md_field"></span></label></div>

                            <div class="filed_input float_left width50">
                              
                         <?=@$preventive[0]->ws_station_name;?>
                            </div>
                        </div>

                    </div>

                </div>
                
                
                <div class="field_row width100" id="maintance_previous_odometer">
                    
                    <div class="width2 float_left">
                        <div class="field_lable float_left width33 strong"><label for="in_odometer">Preventive Maintenance Previous Odometer<span class="md_field">*</span></label></div>

                        <div class="filed_input float_left width50">
                             <?=@$preventive[0]->mt_preventive_previos_odometer;?>


                        </div>
                    </div>
                    <div class="width2 float_left">
                        <div class="field_lable float_left width33 strong"><label for="previous_odometer">Last Updated Odometer<span class="md_field">*</span></label></div>

                        <div class="filed_input float_left width50" >
                           <?=@$preventive[0]->mt_previos_odometer;?>

                        </div>
                    </div>
                     <div class="width2 float_left">
                        <div class="field_lable float_left width33 strong"><label for="previous_odometer">Current Odometer<span class="md_field">*</span></label></div>

                        <div class="filed_input float_left width50" >
                           <?=@$preventive[0]->mt_in_odometer;?>

                        </div>
                    </div>
                     <div class="width2 float_left">
                        <div class="field_lable float_left width33 strong"><label for="previous_odometer">Odo meter Difference<span class="md_field">*</span></label></div>

                        <div class="filed_input float_left width50" >
                           <?=@$preventive[0]->mt_odometer_diff;?>

                        </div>
                    </div>
                </div>
                <div class="field_row width100">
                    <div class="width2 float_left">
                        
                        <div class="field_lable float_left width33 strong"><label for="city">Schedule Service<span class="md_field"></span></label></div>

                        <div class="filed_input float_left width50" >
                            
                           <?php if($preventive[0]->mt_schedule_service == 'free'){ echo "Free"; } ?>
                           <?php if($preventive[0]->mt_schedule_service == 'paid'){ echo "Paid"; } ?>
                                    
                        
                           
                        </div>
                    </div>
                    
                    <div class="width2 float_left">
                        
                        <div class="field_lable float_left width33 strong"><label for="city">Previous Maintenance date<span class="md_field"></span></label></div>

                        <div class="filed_input float_left width50" >
                             <?=@$preventive[0]->mt_pre_maintenance_date;?>

                        </div>
                    </div>
                </div>
                <div class="field_row width100">
                    <div class="width2 float_left">
                        
                        <div class="field_lable float_left width33 strong"><label for="off_road_date">Off-road  Date/Time<span class="md_field">*</span></label></div>

                        <div class="filed_input float_left width50" >
                              <?=@$preventive[0]->mt_offroad_datetime;?>

                        </div>
                    </div>
                    <div class="width2 float_left">
                        
                        <div class="field_lable float_left width33 strong"><label for="mt_ex_onroad_datetime">Expected On-road Date/Time<span class="md_field">*</span></label></div>

                        <div class="filed_input float_left width50" >
                              <?=@$preventive[0]->mt_ex_onroad_datetime;?>
                        </div>
                    </div>
                </div>
               <div class="field_row width100">

                 

                        <div class="filed_input float_left width2">
                           
                            <div class="field_lable float_left width33 strong"> <label for="mt_stnd_remark">Standard Remark<span class="md_field"></span></label></div>


                            <div class="filed_input float_left width50">
                               <?php 
                                    if (@$preventive[0]->mt_stnd_remark == 'Ambulance_offroad') {
                                        echo "Ambulance Off-road";
                                    }
                                    ?> 
                            </div>
                        </div>
                      

                   
                    <div class="width2 float_left">
                        <div class="field_lable float_left width33 strong"> <label for="mt_remark">Remark<span class="md_field">*</span></label></div>


                        <div class="filed_input float_left width50">
                           <?= @$preventive[0]->mt_remark; ?>
                        </div>
                    </div>
                   <div class="width2 float_left">
                        <div class="field_lable float_left width33 strong"><label for="mt_estimatecost">Added By<span class="md_field"></span></label></div>
                       

                        <div class="filed_input float_left width50" >
                            <?php if(empty($preventive)){
                                $clg_ref_id = $clg_ref_id ;
                            }else{
                                 $clg_ref_id = $preventive[0]->added_by ;
                            }?>
                           <?=@$clg_ref_id;?>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <div class="field_row width100">
                        <div class="width2 float_left">
                            <div class="field_lable float_left width33 strong"><label for="end_odometer">Tax Invoice/Bill Number<span class="md_field"></span></label></div>

                            <div class="filed_input float_left width50" >
                                <?=@$preventive[0]->bill_number;?>


                            </div>
                        </div>
                        <div class="width2 float_left">

                            <div class="field_lable float_left width33 strong"><label for="mt_onroad_datetime">Cost Of Spare Parts in Rs<span class="md_field"></span></label></div>

                            <div class="filed_input float_left width50" >
                            <?=@$preventive[0]->part_cost;?>
                            </div>
                        </div>
                    </div>

                    <div class="field_row width100">
                        <div class="width2 float_left">
                            <div class="field_lable float_left width33 strong"><label for="end_odometer">Labour Cost in Rs<span class="md_field"></span></label></div>

                            <div class="filed_input float_left width50" >
                                <?=@$preventive[0]->labour_cost;?>


                            </div>
                        </div>
                        <div class="width2 float_left">

                            <div class="field_lable float_left width33 strong"><label for="mt_onroad_datetime">Total Repairing Cost in Rs<span class="md_field"></span></label></div>

                            <div class="filed_input float_left width50" >
                            <?=@$preventive[0]->total_cost;?>

                            </div>
                        </div>
                    </div>

                    <div class="field_row width100">
                        <div class="width2 float_left">
                            <div class="field_lable float_left width33 strong"><label for="end_odometer">Odometer At The Time of On Road<span class="md_field">*</span></label></div>

                            <div class="filed_input float_left width50" >
                                <?=@$preventive[0]->mt_end_odometer;?>


                            </div>
                        </div>
                        <div class="width2 float_left">

                            <div class="field_lable float_left width33 strong"><label for="mt_onroad_datetime">On-road Date/Time<span class="md_field"></span></label></div>

                            <div class="filed_input float_left width50" >
                                   <?php if($preventive[0]->mt_onroad_datetime != '0000-00-00 00:00:00' && $preventive[0]->mt_onroad_datetime != '' && $preventive[0]->mt_onroad_datetime != '1970-01-01 00:00:00'){ echo $preventive[0]->mt_onroad_datetime;}?>

                            </div>
                        </div>
                    </div>
                    <div class="field_row width100">
                        <div class="filed_input float_left width2">
                           
                            <div class="field_lable float_left width33 strong"> <label for="mt_stnd_remark">Standard Remark<span class="md_field"></span></label></div>


                            <div class="filed_input float_left width50">
                                
                                    <?php 
                                    if (@$preventive[0]->mt_on_stnd_remark == 'ambulance_onroad') {
                                        echo "Ambulance On-road";
                                    }
                                    ?>
                                
                            </div>
                        </div>
                        <div class="width2 float_left">
                        <div class="field_lable float_left width33 strong"> <label for="mt_on_remark">Remark<span class="md_field"></span></label></div>


                        <div class="filed_input float_left width50">
                            <?= @$preventive[0]->mt_on_remark; ?>
                        </div>
                        </div>
                    </div>
        <div class="field_row width100">
                        <div class="filed_input float_left width100">

                            <div class="field_lable float_left width10">
                                <label for="photo" class="field_lable float_left width33 strong">Photo</label>
                            </div>
                            <div class="filed_input float_left width90">
                                <?php
                                if($media){
                                    foreach($media as $img){
                                $name = $img->media_name;

                                $pic_path = FCPATH . "uploads/ambulance/" . $name;
                               // echo $pic_path;

                               // if (file_exists($pic_path)) {
                                    $pic_path1 = base_url() . "uploads/ambulance/".$name;
                              //  }
                                $blank_pic_path = base_url() . "themes/backend/images/blank_profile_pic.png";
                                //echo $pic_path1;
                                ?>
                                
                                <a class="ambulance_photo" target="blank" href="<?php
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
                                ?>') no-repeat left center; background-size: contain;  float:left; margin:5px;"  <?php echo $view; ?>></a>
                                <?php
                                    }
                                } ?>
                            </div>
                        </div>
                    </div>
                <div class="field_row width100">
                        <div class="filed_input float_left width2">

                            <div class="field_lable float_left width33">
                                <label for="photo" class="field_lable float_left width33 strong">Jobcard/Invoice Photo</label>
                            </div>
                            <div class="filed_input float_left width50">
                                <?php
                                if($job_media){
                                    foreach($job_media as $img){
                                $name = $img->media_name;

                                $pic_path = FCPATH . "uploads/ambulance/" . $name;
                               // echo $pic_path;

                               // if (file_exists($pic_path)) {
                                    $pic_path1 = base_url() . "uploads/ambulance/".$name;
                              //  }
                                $blank_pic_path = base_url() . "themes/backend/images/blank_profile_pic.png";
                                //echo $pic_path1;
                                ?>
                                
                                <a class="ambulance_photo" target="blank" href="<?php
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
                                ?>') no-repeat left center; background-size: contain; height: 75px; width:100px; float:left; margin:5px;"  <?php echo $view; ?>></a>
                                <?php
                                    }
                                } ?>
                            </div>
                        </div>
                    </div>
        
                <div class="field_row width100">
                        <div class="filed_input float_left width2">

                            <div class="field_lable float_left width33">
                                <label for="photo" class="field_lable float_left width33 strong">Other Photo</label>
                            </div>
                            <div class="filed_input float_left width50">
                                <?php
                                if($invoice_media){
                                    foreach($invoice_media as $img){
                                $name = $img->media_name;

                                $pic_path = FCPATH . "uploads/ambulance/" . $name;
                               // echo $pic_path;

                               // if (file_exists($pic_path)) {
                                    $pic_path1 = base_url() . "uploads/ambulance/".$name;
                              //  }
                                $blank_pic_path = base_url() . "themes/backend/images/blank_profile_pic.png";
                                //echo $pic_path1;
                                ?>
                                
                                <a class="ambulance_photo" target="blank" href="<?php
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
                                ?>') no-repeat left center; background-size: contain; height: 75px; width:100px; float:left; margin:5px;"  <?php echo $view; ?>></a>
                                <?php
                                    }
                                } ?>
                            </div>
                        </div>
                    </div>
           <?php if ($used_invitem) {  ?>
                    <div class="field_row width100  fleet">
                        <div class="single_record_back">Used Part Information</div>
                        <table class="table report_table">

                            <tr>   
                                <th nowrap>Part Name</th>     
                                <th nowrap>Quantity</th>        

                            </tr>
                            <?php  //var_dump($his);
                            if ($used_invitem > 0) {
                            //$count = 1;
                           foreach ($used_invitem as $used) { ?>
                               
                            <tr>
                                <td><?php echo $used->mt_part_title; ?></td>  
                                <td><?php echo $used->as_item_qty; ?></td>
                            </tr>
                            <?php
                        }
                    } else { ?>

                        <tr><td colspan="3" class="no_record_text">No history Found</td></tr>

                    <?php } ?>   

                </table>
            </div>
                 <?php } ?>
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


                    <div class="field_row width100  fleet">
                        <div class="single_record_back">Approve & Reject Information</div>
                        <table class="table report_table">

                            <tr>   
                                <th >Date</th>     
                                <th >Approve/Reject by</th>        
                                <th >Remark</th>
                                <th >On Road Date</th>  
                                <th >Approved Estimate Amount</th> 
                                <th >Work Shop</th> 
                                <th >Other Work Shop</th> 
                                
                                <th nowrap>Status</th>
                            </tr>
                            <?php 
                            if (count($app_rej_his) > 0) {
                            $count = 1;
                           foreach ($app_rej_his as $stat_data) { 
                               if($stat_data->re_approval_status=="1"){$re_approval_status="Approved";}else{$re_approval_status="Reject";}?>
                            <tr>
                                <td><?php echo $stat_data->re_rejected_date; ?></td>  
                                <td><?php echo $stat_data->re_rejected_by; ?></td>
                                <td><?php echo $stat_data->re_remark; ?></td> 
                                <td><?php echo $stat_data->re_app_onroad_datetime; ?></td> 
                                <td><?php echo $preventive[0]->mt_app_est_amt; ?></td> 
                                 <td><?php if($preventive[0]->mt_app_work_shop != '' || $preventive[0]->mt_app_work_shop != 0) { echo show_work_shop_by_id($preventive[0]->mt_app_work_shop); } ?></td> 
                                  <td><?php echo $preventive[0]->ws_app_other_station_name ; ?></td> 
                               
                                <td><?php echo $re_approval_status; ?></td> 
                            </tr>
                            <?php
                        }
                    } else { ?>

                        <tr><td colspan="3" class="no_record_text">No history Found</td></tr>

                    <?php } ?>   

                </table>
                    </div>
    </div>         
</form>
