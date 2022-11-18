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
                    <div class="field_row width100">
                        <div class="width2 float_left">
                            <div class="field_lable float_left width33 strong"><label for="city">Shift Type<span class="md_field"></span></label></div>

                            <div class="filed_input float_left width50">

                                    <?php echo show_shift_type($preventive[0]->mt_shift_id);?>
                                

                            </div>
                        </div>
                        <div class="width2 float_left">
                            <div class="field_lable float_left width33 strong"><label for="work_shop">Select Tyre Type<span class="md_field"></span></label></div>

                            <div class="filed_input float_left width50">
                              
                         <?php 
                          $tyre_type = json_decode($preventive[0]->mt_tyre_type);
                               
                                    if(is_array($tyre_type)){
                                        $tyre_type = implode(',',$tyre_type); 
                                        echo $tyre_type; 
                                    } 
                         //echo $tyre_type[$preventive[0]->mt_tyre_type];?>
                            </div>
                        </div>

                    </div>

             
                                
                <div class="field_row width100">
                    <div class="width2 float_left">
                        
                        <div class="field_lable float_left width33 strong"><label for="mt_uid_no">UID No<span class="md_field"></span></label></div>

                        <div class="filed_input float_left width50" >
                            <?=@$preventive[0]->mt_uid_no;?>
                           
                        </div>
                    </div>
                    <div class="width2 float_left">
                        
                        <div class="field_lable float_left width33 strong"><label for="city">Tyre Model<span class="md_field"></span></label></div>

                        <div class="filed_input float_left width50" >
                          <?=@$preventive[0]->mt_tyre_model;?>
                        </div>
                    </div>
                </div>
                <div class="width100">
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
                    <div class="width2 float_left">
                        <div class="field_lable float_left width33 strong"><label for="mt_estimatecost">Estimate Cost<span class="md_field"></span></label></div>
                        <div class="filed_input float_left width50" >
                        <?=@$preventive[0]->mt_Estimatecost;?>
                        </div>
                    </div>
                </div>
                <div class="field_row width100">
                    <div class="width2 float_left">
                        
                        <div class="field_lable float_left width33 strong"><label for="mt_tyre_remark">Tyre Remark<span class="md_field"></span></label></div>

                        <div class="filed_input float_left width50" >
                            <?=@$preventive[0]->mt_tyre_remark;?>
                        </div>
                    </div>
                    <div class="width2 float_left">
                        
                        <div class="field_lable float_left width33 strong"><label for="mt_reported_date">Reported date<span class="md_field"></span></label></div>

                        <div class="filed_input float_left width50" >
                           <?=@$preventive[0]->mt_reported_date;?>
                        </div>
                    </div>
                </div>
                
                <div class="field_row width100">
                    <!-- <div class="width2 float_left">
                        
                        <div class="field_lable float_left width33 strong"><label for="mt_tyre_remark">Supervisor Name<span class="md_field">*</span></label></div>

                        <div class="filed_input float_left width50" >
                             <?=@$preventive[0]->mt_supervisor_name;?>
                           
                        </div>
                    </div> -->
                    <div class="width2 float_left">
                        
                        <div class="field_lable float_left width33 strong"><label for="mt_district_manager">District Manager<span class="md_field"></span></label></div>

                        <div class="filed_input float_left width50" >
                          <?=@$preventive[0]->mt_district_manager;?>
                        </div>
                    </div>
                </div>
                <div class="field_row width100" id="maintance_previous_odometer">
                    <div class="width2 float_left">
                        <div class="field_lable float_left width33 strong"><label for="previous_odometer">Last Updated Odometer <span class="md_field">*</span></label></div>

                        <div class="filed_input float_left width50" >
                           <?=@$preventive[0]->mt_previos_odometer;?>

                        </div>
                    </div>
                    <div class="width2 float_left">
                        <div class="field_lable float_left width33 strong"><label for="in_odometer">Current Odometer<span class="md_field">*</span></label></div>

                        <div class="filed_input float_left width50">
                             <?=@$preventive[0]->mt_in_odometer;?>


                        </div>
                    </div> 
                </div>
                <div class="field_row width100">
                    <div class="width2 float_left">
                        
                        <div class="field_lable float_left width33 strong"><label for="off_road_date">Off-road Date/Time<span class="md_field"></span></label></div>

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
                        <div class="field_lable float_left width33 strong"> <label for="mt_remark">Remark<span class="md_field"></span></label></div>


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
                            <div class="field_lable float_left width33 strong"><label for="end_odometer">Bill Number<span class="md_field"></span></label></div>

                            <div class="filed_input float_left width50" >
                                <?=@$preventive[0]->bill_number;?>


                            </div>
                        </div>
                        <div class="width2 float_left">

                            <div class="field_lable float_left width33 strong"><label for="mt_onroad_datetime">Tyre make<span class="md_field"></span></label></div>

                            <div class="filed_input float_left width50" >
                            <?=@$preventive[0]->mt_tyre_make;?>
                            </div>
                        </div>
                    </div>

                    <div class="field_row width100">
                        <div class="width2 float_left">
                            <div class="field_lable float_left width33 strong"><label for="end_odometer">Labour Cost<span class="md_field"></span></label></div>

                            <div class="filed_input float_left width50" >
                                <?=@$preventive[0]->labour_cost;?>


                            </div>
                        </div>
                        <div class="width2 float_left">

                            <div class="field_lable float_left width33 strong"><label for="mt_onroad_datetime">Tyre size<span class="md_field"></span></label></div>

                            <div class="filed_input float_left width50" >
                            <?=@$preventive[0]->mt_tyre_size;?>

                            </div>
                        </div>
                    </div>


                    <div class="field_row width100">
                        <div class="width2 float_left">
                            <div class="field_lable float_left width33 strong"><label for="end_odometer">End Odometer<span class="md_field"></span></label></div>

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
                                        echo "Ambulance On-Road";
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
                        <div class="filed_input float_left width2">

                            <div class="field_lable float_left width33">
                                <label for="photo" class="field_lable float_left width33 strong">Photo</label>
                            </div>
                            <div class="filed_input float_left width50">
                                <?php
                                if($media){
                                    foreach($media as $img){
                                $name = $img->media_name;

                                $pic_path = FCPATH . "uploads/ambulance/" . $name;

                                if (file_exists($pic_path)) {
                                    $pic_path1 = base_url() . "uploads/ambulance/" . $name;
                                }
                                $blank_pic_path = base_url() . "themes/backend/images/blank_profile_pic.png";
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
                           // $count = 1;
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
                                <th nowrap>Date</th>     
                                <th nowrap>Approve/Reject by</th>        
                                <th nowrap>Remark</th>
                                <th nowrap>On Road Date</th>        
                                <th nowrap>Status</th>
                            </tr>
                            <?php  //var_dump($his);
                            if (count($app_rej_his) > 0) {
                            $count = 1;
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
                    
    </div>         
</form>

