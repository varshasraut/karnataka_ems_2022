


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
                                if($preventive[0]->mt_district_id == 'Backup'){ echo "Backup"; }else{ echo $preventive[0]->dst_name; }
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


                        <div class="filed_input float_left width50" >
                           <?= @$preventive[0]->mt_base_loc; ?>

                        </div>


                    </div>
                    <div class="field_row width100">
                        <div class="width50  float_left">
                           
                            <div class="field_lable float_left width33 strong"><label for="work_shop">EMT ID <span class="md_field">*</span></label></div>
                           
                            <div class="filed_input width50 float_left">
                               <?php echo @$preventive[0]->mt_emt_id; ?>
                            </div>
                        </div>
                        <div class="width50 float_left">
                            
                                <div class="field_lable float_left width33 strong"><label for="work_shop">EMT Name <span class="md_field">*</span></label></div>
                            <div class="filed_input width50 float_left">
                                <?php echo @$preventive[0]->mt_emt_name; ?>
                            </div>
                        </div>

                    </div>
                    <div class="field_row width100">
                        <div class="width50 float_left">
                              
                            <div class="field_lable float_left width33 strong"><label for="work_shop">Pilot ID <span class="md_field">*</span></label></div>
                                
                           
                            <div class="width50 float_left">
  
                                <div class="filed_input width50 float_left" >
                               <?php echo @$preventive[0]->mt_pilot_id; ?>
                                
                            </div>
                            </div>
                        </div>
                        <div class="width50 float_left">
                            
                                <div class="field_lable float_left width33 strong"><label for="work_shop">Pilot Name <span class="md_field">*</span></label></div>
                                
                            <div class="filed_input width50 float_left">
                               <?php echo @$preventive[0]->mt_pilot_name; ?>
                                
                            </div>
                        </div>

                    </div>
                    <div class="field_row width100">
                        <div class="width2 float_left">
                            <div class="field_lable float_left width33 strong"><label for="city">Breakdown date<span class="md_field">*</span></label></div>

                            <div class="filed_input float_left width50">

                                    <?=@$preventive[0]->mt_breakdown_date;?>
                                

                            </div>
                        </div>
                        <div class="width2 float_left">
                            <div class="field_lable float_left width33 strong"><label for="work_shop">Estimate Cost<span class="md_field">*</span></label></div>

                            <div class="filed_input float_left width50">
                              
                         <?=@$preventive[0]->mt_estimatecost;?>
                            </div>
                        </div>

                    </div>
                    
                    <div class="field_row width100">
                        <div class="width2 float_left">
                            <div class="field_lable float_left width33 strong"><label for="city">Shift Type<span class="md_field">*</span></label></div>

                            <div class="filed_input float_left width50">

                                    <?php echo show_shift_type($preventive[0]->mt_shift_id);?>
                                

                            </div>
                        </div>
                        <div class="width2 float_left">
                            <div class="field_lable float_left width33 strong"><label for="work_shop">Servcie Center<span class="md_field">*</span></label></div>

                            <div class="filed_input float_left width50">
                              
                         <?=@$preventive[0]->es_service_center_name;?>
                            </div>
                        </div>

                    </div>

                </div>
                <div class="field_row width100">
                    <div class="width2 float_left">
                        
                        <div class="field_lable float_left width33 strong"><label for="city">Breakdown Severity<span class="md_field">*</span></label></div>

                        <div class="filed_input float_left width50" >
                            
                           <?php if($preventive[0]->mt_brakdown_severity == 'Major'){ echo "Major"; } ?>
                           <?php if($preventive[0]->mt_brakdown_severity == 'Minor'){ echo "Minor"; } ?>
                                    
                        
                           
                        </div>
                    </div>
                    <div class="width2 float_left">
                        
                        <div class="field_lable float_left width33 strong"><label for="city">Problem observed<span class="md_field">*</span></label></div>

                        <div class="filed_input float_left width50" >
                            
                              <?php
                                $pro = array();
                                if($eqp_obs){
                                    foreach($eqp_obs as $eq){ 
                                        
                                          $selected = "";
                                          $mt_breakdown_type = array();
                                          $mt_breakdown_type = unserialize($preventive[0]->mt_breakdown_type);
                                          //var_dump($mt_breakdown_type);
                                          
                                        if(is_array($mt_breakdown_type)){
                                        if(array_key_exists($eq->eb_type_id,$mt_breakdown_type)){
                                            $selected = "Selected=selected";
                                     
                                    
                                  $pro[] = $eq->eb_name; 
                                    
                                        }  
                                        }
                                    }
                                }
                                    echo implode(',', $pro);
                                   // echo $preventive[0]->mt_breakdown_type;
                                    ?>
                

                        </div>
                    </div>
                </div>
                <div class="field_row width100">

                 

                        <div class="filed_input float_left width2">
                           
                            <div class="field_lable float_left width33 strong"> <label for="mt_stnd_remark">Standard Remark<span class="md_field">*</span></label></div>


                            <div class="filed_input float_left width50">
                              Ambulance Equipment Maintenance
                            </div>
                        </div>
                      

                   
                    <div class="width2 float_left">
                        <div class="field_lable float_left width33 strong"> <label for="mt_remark">Remark<span class="md_field">*</span></label></div>


                        <div class="filed_input float_left width50">
                           <?= @$preventive[0]->mt_remark; ?>
                        </div>
                    </div>

                </div>
                <div class="field_row width100">
                    <div class="width2 float_left">
                        <div class="field_lable float_left width33 strong"><label for="city">Equipments<span class="md_field">*</span></label></div>
                        <div class="filed_input float_left width50">
                            
                                 <?php
                                 $eqp_name = array();
                                 if($eqp){
                                    foreach($eqp as $eq){
                                           
                                        $eq_equip_name = unserialize($preventive[0]->eq_equip_name);
                                        
                                      
                                         $selected = "";
                                         
                                        if(is_array($eq_equip_name)){
                                        if(in_array($eq->eqp_id,$eq_equip_name)){
                                           
                                             $eqp_name[] = $eq->eqp_name; 
                                        }
                                        }
                                      
                                        
                                    }
                                 }
                                    echo implode(',', $eqp_name);
                                    ?>
                        
                        </div>

                    </div>
                    <div class="width2 float_left">
                        <div class="field_lable float_left width33 strong"> <label for="is_amb_offroad">Off-road Ambulance<span class="md_field">*</span></label></div>


                        <div class="filed_input float_left width50">
                            <?= @$preventive[0]->is_amb_offroad; ?>
                        </div>
                    </div>



                </div>   
                <?php if(@$preventive[0]->is_amb_offroad == 'yes'){?>
                <div class="field_row width100">
                    <div class="width2 float_left">
                        
                        <div class="field_lable float_left width33 strong"><label for="off_road_date">Off-road  Date/Time<span class="md_field">*</span></label></div>

                        <div class="filed_input float_left width50" >
                              <?=@$preventive[0]->mt_offroad_datetime;?>

                        </div>
                    </div>
                    <div class="width2 float_left">
                        
                        <div class="field_lable float_left width33 strong"><label for="mt_ex_onroad_datetime">Exp On-Road Date/Time<span class="md_field">*</span></label></div>

                        <div class="filed_input float_left width50" >
                              <?=@$preventive[0]->mt_ex_onroad_datetime;?>
                        </div>
                    </div>
                </div>
  
            </div>
        </div>
        
             <div class="field_row width100" id="maintance_previous_odometer">
                    <div class="width2 float_left">
                        <div class="field_lable float_left width33 strong"><label for="previous_odometer">Previous Breakdown Equipment Odometer<span class="md_field">*</span></label></div>

                        <div class="filed_input float_left width50" >
                           <?=@$preventive[0]->mt_previous_breakdown_odmeter;?>

                        </div>
                    </div>
                    <div class="width2 float_left">
                        <div class="field_lable float_left width33 strong"><label for="last_updated_odometer">Last Latest Odometer<span class="md_field">*</span></label></div>

                        <div class="filed_input float_left width50">
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
                            <div class="field_lable float_left width33 strong"><label for="end_odometer">Off-Road Standard Remark<span class="md_field">*</span></label></div>

                            <div class="filed_input float_left width50" >
                               <?php
                              // echo $preventive[0]->mt_off_stnd_remark;
                               if($preventive[0]->mt_off_stnd_remark != ''){
                               echo get_eqp_breakdown_standard_remark($preventive[0]->mt_off_stnd_remark);
                               }
                               ?>


                            </div>
                        </div>
                        <div class="width2 float_left">

                            <div class="field_lable float_left width33 strong"><label for="mt_onroad_datetime">Remark<span class="md_field">*</span></label></div>

                            <div class="filed_input float_left width50" >
                                   <?php  echo $preventive[0]->common_remark_other; ?>

                            </div>
                        </div>
                    </div>


            <div class="field_row width100">
                        <div class="width2 float_left">
                            <div class="field_lable float_left width33 strong"><label for="end_odometer">End Odometer<span class="md_field">*</span></label></div>

                            <div class="filed_input float_left width50" >
                                <?=@$preventive[0]->mt_end_odometer;?>


                            </div>
                        </div>
                        <div class="width2 float_left">

                            <div class="field_lable float_left width33 strong"><label for="mt_onroad_datetime">On-Road Date/Time<span class="md_field">*</span></label></div>

                            <div class="filed_input float_left width50" >
                                   <?php if($preventive[0]->mt_onroad_datetime != '0000-00-00 00:00:00' && $preventive[0]->mt_onroad_datetime != '' && $preventive[0]->mt_onroad_datetime != '1970-01-01 00:00:00'){ echo $preventive[0]->mt_onroad_datetime;}?>

                            </div>
                        </div>
                    </div>
        <?php } ?>
         <div class="field_row width100">
            <div class="width2 float_left">
                <div class="field_lable float_left width33 strong"><label for="end_odometer">Bill Number<span class="md_field">*</span></label></div>

                <div class="filed_input float_left width50" >
                  
                     <?php echo @$preventive[0]->mt_bill_number; ?>


                </div>
            </div>
            <div class="width2 float_left">

                <div class="field_lable float_left width33 strong"><label for="mt_onroad_datetime">Spare Parts details<span class="md_field">*</span></label></div>

                <div class="filed_input float_left width50" >
                   <?php echo @$preventive[0]->mt_part_cost; ?>


                </div>
            </div>
        </div>
        <div class="field_row width100">
            <div class="width2 float_left">
                <div class="field_lable float_left width33 strong"><label for="end_odometer">Labour Cost<span class="md_field">*</span></label></div>

                <div class="filed_input float_left width50" >
                  
                     <?php echo @$preventive[0]->mt_labour_cost; ?>


                </div>
            </div>
            <div class="width2 float_left">

                <div class="field_lable float_left width33 strong"><label for="mt_onroad_datetime">Total Amount<span class="md_field">*</span></label></div>

                <div class="filed_input float_left width50" >
                   <?php echo @$preventive[0]->mt_total_cost; ?>


                </div>
            </div>
        </div>
                    <div class="field_row width100">
                        <div class="filed_input float_left width2">
                           
                            <div class="field_lable float_left width33 strong"> <label for="mt_on_stnd_remark">On-Road Standard Remark<span class="md_field">*</span></label></div>


                            <div class="filed_input float_left width50">
                                <?php 
                                    if (trim($preventive[0]->mt_on_stnd_remark) != '') {
                                     
                                   echo get_eqp_breakdown_standard_remark($preventive[0]->mt_on_stnd_remark);
                                 
                                    }
                                ?> 
                            </div>
                        </div>
                        <div class="width2 float_left">
                        <div class="field_lable float_left width33 strong"> <label for="mt_on_remark">Remark<span class="md_field">*</span></label></div>


                        <div class="filed_input float_left width50">
                            <?= @$preventive[0]->mt_on_remark; ?>
                        </div>
                        </div>
                    </div>
      
</form>

