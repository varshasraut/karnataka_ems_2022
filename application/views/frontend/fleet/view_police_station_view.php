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
                    <div class="filed_lable float_left width33 strong"><label for="station_name">Station Name</label>

                    </div>

                      <div class="filed_input float_left width50">
                          
                          <?= @$police_station[0]->police_station_name ?>

                      </div>
                    </div>   
                </div>
                       <div class="field_row width100">
                      
                        <div class="field_lable float_left width_16 strong"> <label for="district">Address </label></div>
                          <div class="filed_input float_left width75">
                    
                        <?php
                        if (@$police_station[0]->p_google_address) {
                          $fuel_address= @$police_station[0]->p_google_address;
                        }
                      echo $fuel_address;
                        ?>
                              

                    
                </div>
                  </div>
                  <div class="field_row width100">
                      
                        <div class="width2 float_left">
                             <div class="field_lable float_left width33 strong"><label for="district">State</label></div>
                     <div class="filed_input float_left width50"> <div id="incient_state">

   <?= @$police_station[0]->st_name; ?>

                          

                                    </div>
                        
                     </div>
                   
                        </div>
                        <div class="width2 float_left">    
                            <div class="field_lable float_left width33 strong"><label for="district">District</label></div>   <div class="filed_input float_left width50">
                            
                          <?= @$police_station[0]->dst_name; ?>

                 
                          

                    </div>
                        </div>
                  </div>
                  <div class="field_row width100">
                      
                      <div class="width2 float_left">
                           <div class="field_lable float_left width33 strong"><label for="district">Tehsil</label></div>
                   <div class="filed_input float_left width50"> <div id="incient_tahsil">

 <?= @$police_station[0]->thl_name; ?>

                        

                                  </div>
                      
                   </div>
                 
                      </div>
                      <div class="width2 float_left">    
                          <div class="field_lable float_left width33 strong"><label for="district">City/Village</label></div>   <div class="filed_input float_left width50">
                          
                        <?= @$police_station[0]->cty_name; ?>

               
                        

                  </div>
                      </div>
                </div>
                <div class="field_row width100">
                      
                      <div class="width2 float_left">
                           <div class="field_lable float_left width33 strong"><label for="district">Landmark</label></div>
                   <div class="filed_input float_left width50"> <div id="incient_landmark">

 <?= @$police_station[0]->p_landmark; ?>

                        

                                  </div>
                      
                   </div>
                 
                      </div>
                      <div class="width2 float_left">    
                          <div class="field_lable float_left width33 strong"><label for="district">PinCode</label></div>   <div class="filed_input float_left width50">
                          
                        <?= @$police_station[0]->p_pincode; ?>

               
                        

                  </div>
                      </div>
                </div>
                       <div class="field_row width100">
                        <div class="width2 float_left">
                         <div class="field_lable float_left width33 strong"><label for="city">Status</label></div>

                        <div class="filed_input float_left width50">

           <?php 
                            if(@$police_station[0]->p_is_active =='0'){
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
                          <?= @$police_station[0]->p_station_mobile_no; ?>
                      
                    </div>
                        </div>
                  </div>
                  
                   <div class="field_row width100">
                        <div class="width2 float_left">
                       <div class="field_lable float_left width33 strong"> <label for="mobile_no">Contact Person</label></div>


                    <div class="filed_input float_left width50">
                           <?= @$police_station[0]->p_contact_person; ?>
                        
                    </div>
                        </div>
                        <div class="width2 float_left">
                         <div class="field_lable float_left width33 strong"> <label for="mobile_no">Mobile No</label></div>


                    <div class="filed_input float_left width50">
                         <?= @$police_station[0]->p_mobile_no; ?>
                      
                    </div>
                        </div>
                       
                  </div>
                       <div class="field_row width100">
                        <div class="width100">
                       <div class="field_lable float_left width_16 strong"> <label for="mobile_no">Address</label></div>


                    <div class="filed_input float_left width75">
                            <?= @$police_station[0]->p_address; ?>
                        
                    </div>
                        </div>
                  </div>

</form>

