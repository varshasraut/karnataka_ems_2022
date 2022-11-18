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
                    <div class="filed_lable float_left width33 strong"><label for="station_name">Oxygen Name</div>

                    <div class="filed_input float_left width50">
                        
                        <?= @$oxygen_center[0]->os_oxygen_name ?>

                        </div>
   </div>   <div class="width2 float_left">
                       
                        <div class="field_lable float_left width33 strong"> <label for="district">Google Address </label></div>
                          <div class="filed_input float_left width50">
                    
                        <?php
                        if (@$oxygen_center[0]->os_google_address) {
                          @$oxygen_address= @$oxygen_center[0]->os_google_address;
                        }
                      echo @$oxygen_address;
                        ?>
                              

                    
                </div>
   </div>
                </div>
                    
                  <div class="field_row width100">
                      
                        <div class="width2 float_left">
                             <div class="field_lable float_left width33 strong"><label for="district">State</label></div>
                     <div class="filed_input float_left width50"> <div id="incient_state">

   <?= @$oxygen_center[0]->st_name; ?>

                          

                                    </div>
                        
                     </div>
                   
                        </div>
                        <div class="width2 float_left">    
                            <div class="field_lable float_left width33 strong"><label for="district">District</label></div>   <div class="filed_input float_left width50">
                            
                          <?= @$oxygen_center[0]->dst_name; ?>

            
                          

                    </div>
                        </div>
                  </div>
                  <div class="field_row width100">
                      
                      <div class="width2 float_left">
                           <div class="field_lable float_left width33 strong"><label for="district">Tehsil</label></div>
                   <div class="filed_input float_left width50"> <div id="incient_state">

 <?= @$oxygen_center[0]->thl_name; ?>

                        

                                  </div>
                      
                   </div>
                 
                      </div>
                      <div class="width2 float_left">    
                          <div class="field_lable float_left width33 strong"><label for="district">City/Village</label></div>   <div class="filed_input float_left width50">
                          
                        <?= @$oxygen_center[0]->cty_name; ?>

               
                        

                  </div>
                      </div>
                </div>
                <div class="field_row width100">
                    
                      <div class="width2 float_left">
                           <div class="field_lable float_left width33 strong"><label for="district">Landmark</label></div>
                   <div class="filed_input float_left width50"> <div id="incient_state">

 <?= @$oxygen_center[0]->os_landmark; ?>

                        

                                  </div>
                      
                   </div>
                 
                      </div>
                      <div class="width2 float_left">    
                          <div class="field_lable float_left width33 strong"><label for="district">Pincode</label></div>   <div class="filed_input float_left width50">
                          
                        <?= @$oxygen_center[0]->os_pincode; ?>

               
                        

                  </div>
                      </div>
                </div>
                       <div class="field_row width100">
                        <div class="width2 float_left">
                         <div class="field_lable float_left width33 strong"><label for="city">Status</label></div>

                        <div class="filed_input float_left width50">

    <?php 
                            if(@$oxygen_center[0]->os_is_active =='0'){
                                echo 'Active';
                            }else{
                                echo 'Inactive';
                            }
?>   
                        
                        </div>
                        </div>
                        <div class="width2 float_left">
                        
                     <div class="field_lable float_left width33 strong"> <label for="mobile_no">Station Mobile No</label></div>


                    <div class="filed_input float_left width50">
                          <?= @$oxygen_center[0]->os_station_mobile_no; ?>
                      
                    </div>
                        </div>
                  </div>
                   <div class="field_row width100">
                        <div class="width2 float_left">
                       <div class="field_lable float_left width33 strong"> <label for="mobile_no">Contact Person</label></div>


                    <div class="filed_input float_left width50">
                           <?= @$oxygen_center[0]->os_contact_person; ?>
                        
                    </div>
                        </div>
                        <div class="width2 float_left">
                         <div class="field_lable float_left width33 strong"> <label for="mobile_no">Mobile No</label></div>


                    <div class="filed_input float_left width50">
                         <?= @$oxygen_center[0]->os_mobile_no; ?>
                      
                    </div>
                        </div>
                       
                  </div>
                   <div class="field_row width100">
                    <div class="width2 float_left">
                        <div class="field_lable float_left width33 strong"> <label for="email">Email</label></div>
                        <div class="filed_input float_left width50">
                            <?= @$oxygen_center[0]->os_email; ?>
                        </div>
                    </div>


                </div>
                       <div class="field_row width100">
                        <div class="width100">
                       <div class="field_lable float_left width_16 strong"> <label for="mobile_no">Address</label></div>


                    <div class="filed_input float_left width75">
                            <?= @$oxygen_center[0]->os_address; ?>
                        
                    </div>
                        </div>
                    
                       
                  </div>

</form>

