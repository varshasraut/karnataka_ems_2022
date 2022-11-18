

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
                        
                        <?= @$statutory_data[0]->st_name ?>

                        </div>
   </div>   <div class="width2 float_left">
                       
                        <div class="field_lable float_left width33 strong"> <label for="district">District</label></div>
                          <div class="filed_input float_left width50">
                    
                          <?= @$statutory_data[0]->dst_name; ?>
                              

                    
                </div>
   </div>
                </div>
                    
                  <div class="field_row width100">
                      
                        <div class="width2 float_left">
                             <div class="field_lable float_left width33 strong"><label for="district">Ambulance Number</label></div>
                     <div class="filed_input float_left width50"> <div id="incient_state">

   <?= @$statutory_data[0]->sc_amb_ref_number; ?>
                                    </div>
                     </div>
                   
                        </div>
                      <div class="width2 float_left">    
                        <div class="field_lable float_left width33 strong"><label for="district">Base Location</label></div> 
                        <div class="filed_input float_left width50">
                            <?= @$statutory_data[0]->sc_base_location; ?>
                        </div>
                    </div>
                       
                  </div>
                       <div class="field_row width100">
                            <div class="width2 float_left">    
                            <div class="field_lable float_left width33 strong"><label for="district">Pilot Id</label></div>   <div class="filed_input float_left width50">
                            
                          <?= @$statutory_data[0]->sc_pilot_id; ?>

                 
                          

                    </div>
                        </div>
                        <div class="width2 float_left">
                             
                     <div class="field_lable float_left width33 strong"> <label for="mobile_no">Pilot Name</label></div>


                    <div class="filed_input float_left width50">
                          <?= @$statutory_data[0]->sc_pilot_name; ?>
                      
                    </div>
                        </div>
                       
                  </div>
                   <div class="field_row width100">
                        <div class="width2 float_left">
                        
                     <div class="field_lable float_left width33 strong"> <label for="mobile_no">EMT Id</label></div>


                    <div class="filed_input float_left width50">
                          <?= @$statutory_data[0]->sc_emso_id; ?>
                      
                    </div>
                        </div>
                        <div class="width2 float_left">
                       <div class="field_lable float_left width33 strong"> <label for="mobile_no">EMT Name</label></div>


                    <div class="filed_input float_left width50">
                           <?= @$statutory_data[0]->sc_emso_name; ?>
                        
                    </div>
                        </div>
                        <div class="width2 float_left">
                         <div class="field_lable float_left width33 strong"> <label for="mobile_no">Supervisor Name</label></div>


                    <div class="filed_input float_left width50">
                         <?= @$statutory_data[0]->sc_supervisor_name; ?>
                      
                    </div>
                        </div>
                       
                  </div>
            <?php      if($statutory_data[0]->sc_supervisor_other_nam != ''){?>
                 
                         <div class="field_row width100">
                        <div class="width2 float_left">
                       <div class="field_lable float_left width33 strong"> <label for="mobile_no">Other Supervisor Name</label></div>


                    <div class="filed_input float_left width50">
                         <?= @$statutory_data[0]->sc_supervisor_other_name; ?>
                      
                    </div>
                        </div>
                       
                       
            </div><?php }?>
                           <div class="field_row width100">
                        <div class="width2 float_left">
                       <div class="field_lable float_left width33 strong"> <label for="mobile_no">Complaint Type</label></div>


                    <div class="filed_input float_left width50">
                         <?php 
                            if(@$statutory_data[0]->sc_complaint_type =='insurance'){
                                echo 'Insurance';
                            }else if(@$statutory_data[0]->sc_complaint_type =='rto'){
                                echo 'RTO';
                           }else if(@$statutory_data[0]->sc_complaint_type =='clearance'){
                                echo 'Clearance';
                           }else if(@$statutory_data[0]->sc_complaint_type =='driver_licence'){
                                echo 'Driver Licence';
                           } else if(@$statutory_data[0]->sc_complaint_type =='puc'){
                                echo 'PUC';
                           }else if(@$statutory_data[0]->sc_complaint_type =='puc'){
                                echo 'PUC';
                           
                           }else if(@$statutory_data[0]->sc_complaint_type =='doctor_licence'){
                                echo 'Doctor Licence';
                           }else if(@$statutory_data[0]->sc_complaint_type =='equipment_insurance'){
                                echo 'Equipment Insurance';
                           }
?>   
    
                     
                        
                    </div>
                        </div>
                        <div class="width2 float_left">
                         <div class="field_lable float_left width33 strong"> <label for="mobile_no">Compliance</label></div>


                    <div class="filed_input float_left width50">
                          <?php 
                            if(@$statutory_data[0]->sc_compliance =='Yes'){
                                echo 'Yes';
                            }else{
                                echo 'No';
                            }
?>   
                      
                      
                    </div>
                        </div>
                       
                  </div>
                   <div class="field_row width100">
                        <div class="width2 float_left">
                       <div class="field_lable float_left width33 strong"> <label for="mobile_no">Date Of Renovation</label></div>


                    <div class="filed_input float_left width50">
                           <?= @$statutory_data[0]->sc_date_of_renovation; ?>
                        
                    </div>
                        </div>
                        <div class="width2 float_left">
                         <div class="field_lable float_left width33 strong"> <label for="mobile_no">Standard Remark</label></div>


                    <div class="filed_input float_left width50">
                          <?php
                            if (@$statutory_data[0]->sc_standard_remark == 'statutory_compliance_successfully') {
                                echo "Statutory compliance successfully";
                            }
                            ?>
                      
                    </div>
                        </div>
                       
                  </div>
                  <div class="field_row width100">
                        <div class="width2 float_left">
                       <div class="field_lable float_left width33 strong"> <label for="mobile_no">Remark</label></div>


                    <div class="filed_input float_left width50">
                           <?= @$statutory_data[0]->sc_remark; ?>
                        
                    </div>
                        </div>
                       
                       
                  </div>
                  
                      <div class="field_row width100">
                          
                       <?php if (@$statutory_data[0]->sc_next_date_of_renovation != '') { ?>
                    <div class="width2 float_left">
                        <div class="field_lable float_left width33 strong"> <label for="sc_next_date_of_renovation">Next Date Of Renovation</label></div>


                        <div class="filed_input float_left width50" >

                            <?= @$statutory_data[0]->sc_next_date_of_renovation; ?>
                        </div>
                    </div>
                     <?php } ?>
                           <?php if (@$statutory_data[0]->sc_cur_date_time != '') { ?>
                    <div class="filed_input float_left width2">

                        <div class="field_lable float_left width33 strong"> <label for="mt_stnd_remark">Current Date Time</label></div>


                        <div class="filed_input float_left width50">

                           <?= @$statutory_data[0]->sc_cur_date_time; ?>

                        </div>
                    </div>
                      <?php } ?>
                        <?php if (@$statutory_data[0]->sc_stand_remark != '') { ?>
                    <div class="filed_input float_left width2">

                        <div class="field_lable float_left width33 strong"> <label for="mt_stnd_remark">Standard Remark</label></div>


                        <div class="filed_input float_left width50">

                            <?php
                            if (@$statutory_data[0]->sc_stand_remark == 'solve_complaiance') {
                                echo "Solve complaiance";
                            }
                            ?>

                        </div>
                    </div>
                      <?php } ?>
                    
                </div>
                  

</form>
