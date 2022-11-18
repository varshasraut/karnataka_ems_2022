    <h2 class="txt_clr2 width1 txt_pro">View Information Form</h2>
<?php if($call_details){ 
    
    
foreach($call_details as $details){ ?>
    <div class="width1" style="">
        
         
            <div class="field_row width100  fleet">
                        <div class="single_record_back">Date:-<?php echo $details->follow_up_date;?></div>
            </div>
             <div class="field_row width2 float_left">

                 <div class="field_lable float_left width_25 strong">Date</div>

                 <div class="field_input float_left width2">
                     <?php echo $details->follow_up_date;?>
                 </div>

            </div>
            <div class="width2 float_left">
                <div class="field_row">

                    <div class="field_lable float_left width_25 strong">Full name</div>

                    <div class="field_input float_left width2">     
                         <?php echo $details->patient_name;?>
                     </div>

                </div>
            </div>
        <div class="width2 float_left">
                        <div class="field_row">
                            
                            <div class="field_lable width_25 strong float_left" >Patient age*</div>
                            
                            <div class="field_input width2 float_left">
                                <?php echo $details->patient_age;?>
                              
                             </div>
                            
                        </div>
                </div>
         <div class="width2 float_left">
                        <div class="field_row">
                            
                            <div class="field_lable float_left width_25 strong">Address*</div>
                            
                            <div class="field_input float_left">
                                 <?php echo $details->address;?>
                             </div>
                            
                        </div>
                </div>
        <div class="field_row width2 float_left">

                 <div class="field_lable float_left width_25 strong">Call Status</div>

                 <div class="field_input float_left width2">
                     <?php echo $details->is_phone_connected;?>
                 </div>

            </div>
            <div class="field_row width2 float_left">

                 <div class="field_lable float_left width_25 strong">Travel History</div>

                 <div class="field_input float_left width2">
                     <?php echo $details->travel_history;?>
                 </div>

            </div>
            <div class="field_row width2 float_left">

                 <div class="field_lable float_left width_25 strong">Travel Place</div>

                 <div class="field_input float_left width2">
                     <?php echo $details->travel_place;?>
                 </div>

            </div>
            <div class="width2 float_left">
                <div class="field_row">

                    <div class="field_lable float_left width_25 strong">Current Place</div>

                    <div class="field_input float_left width2">     
                         <?php echo $details->current_place;?>
                     </div>

                </div>
            </div>
          <div class="width2 float_left">
                <div class="field_row">

                    <div class="field_lable float_left width_25 strong">Current Place Address</div>

                    <div class="field_input float_left width2">     
                         <?php echo $details->current_place_address;?>
                     </div>

                </div>
            </div>
        <div class="width2 float_left">
                        <div class="field_row">
                            
                            <div class="field_lable float_left width_25 strong">ERO Summary</div>
                            <div class="field_input float_left">
                                 <?php echo $details->ero_summary;?>
                             </div>
                            
                        </div>
                </div>
                <div class="width2 float_left">
                        <div class="field_row">
                            
                            <div class="field_lable float_left width_25 strong">ERO Advice</div>
                            
                            <div class="field_input float_left">
                                 <?php echo $details->ero_note;?>
                             </div>
                            
                        </div>
                </div>

        <div class="width2 float_left">
                        <div class="field_row">
                            
                            <div class="field_lable float_left width_25 strong">Availability of Pulse Oxymeter</div>
                            <div class="field_input float_left">
                                 <?php echo $details->pulse_oxymeter;?>
                             </div>
                            
                        </div>
                </div>
                <div class="width2 float_left">
                        <div class="field_row">
                            
                            <div class="field_lable float_left width_25 strong">Oxygen Saturation Value</div>
                            
                            <div class="field_input float_left">
                                 <?php echo $details->oxygen_saturation_value;?>
                             </div>
                            
                        </div>
                </div>
        <div class="width2 float_left">
                        <div class="field_row">
                            
                            <div class="field_lable float_left width_25 strong">Audio</div>
                            
                            <div class="field_input float_left">
                                         <?php  
                                    $inc_datetime = date("Y-m-d", strtotime($details->avaya_unique_id ));
                                    $pic_path =  get_corona_recording($inc->inc_avaya_uniqueid,$inc_datetime);
                                     $pic_path = explode(';', $pic_path);
                                     if($pic_path != ""){ 
                                         
                                        if($clg_senior){ 
                                            $width = "width: 185px;";
                                            
                                        }else{
                                            $width = "width: 50px;";
                                        }
                                         if(is_array($pic_path)){ 
                                foreach($pic_path as $key=>$path){
                                             if($path != ""){ 
?>
                                 <strong  style="width: 100%; display: block;"> Call <?php echo $key;?>:</strong>
                                    <audio controls controlsList="nodownload" style="<?php echo $width; ?>">
                                        <source src="<?php echo $path;?>" type="audio/wav">
                                        Your browser does not support the audio element.
                                    </audio> 
                                         <?php } } }
                                    }

                                    ?>
                             </div>
                            
                        </div>
                </div>
        

              
            <div class="followup_details_box float_left width100">
                                <div class="width100">
                    <div class="field_lable"><strong>Co-mobid Conditions</strong></div>
                    <table class="report_table">
                        <tr><td style="width:100px; font-weight: bold; text-align: center;">Cardiocascular disease,hypertension, and CAD</td><td style="width:100px; font-weight: bold; text-align: center;">DM (Diabetes mellitus ) and other immumocompromised stated</td><td style="width:100px; font-weight: bold; text-align: center;">Chronic Lung / Kidney / Liver disease</td><td style="width:100px; font-weight: bold; text-align: center;">Cerebrivascular disease</td><td style="width:100px; font-weight: bold; text-align: center;">Obesity</td><td style="width:100px; font-weight: bold; text-align: center;">Any Other</td><tr>
                  <tr>
                      <td style="text-align: center;"><?php echo ucfirst($details->Cardiocascular_disease);?></td>
                      <td style="text-align: center;"><?php echo ucfirst($details->DM);?></td>
                      <td style="text-align: center;"><?php echo ucfirst($details->Chronic_lung);?></td>
                      <td style="text-align: center;"><?php echo ucfirst($details->cerebrivascular);?></td>
                      <td style="text-align: center;"><?php echo ucfirst($details->Obesity);?></td>
                      <td style="text-align: center;"><?php echo ucfirst($details->any_other);?></td>
                  <tr>

                    
                </table>
                    
                </div>  
                    <table class="report_table ">
                        <tr>
                            <td style="width:80px; font-weight: bold; text-align: center;">Body Pain/Joint Pain</td>
                            <td style="width:80px; font-weight: bold; text-align: center;">Fever</td>
                            <td style="width:80px; font-weight: bold; text-align: center;">Cough</td>
                            <td style="width:80px; font-weight: bold; text-align: center;">Diarrhoea</td>
                            <td style="width:100px; font-weight: bold; text-align: center;">Fatigue / Weakness</td>
                            <td style="width:80px; font-weight: bold; text-align: center;">Abdominal pain</td>
                            <td style="width:80px; font-weight: bold; text-align: center;">History of fever</td>
                            <td style="width:80px; font-weight: bold; text-align: center;">Breathlessness</td>
                            <td style="width:80px; font-weight: bold; text-align: center;">Nausea</td>
                            <td style="width:80px; font-weight: bold; text-align: center;">Vomiting</td>
                            <td style="width:80px; font-weight: bold; text-align: center;">Chest pain</td>
                            <td style="width:80px; font-weight: bold; text-align: center;">Sputum</td>
                            <td style="width:80px; font-weight: bold; text-align: center;">Nasal discharge</td>
<!--                            <td style="width:80px; font-weight: bold; text-align: center;">Call Connected</td>-->
                        <tr>
                  <tr>
                      <td style="text-align: center;"><?php echo ucfirst($details->body_pain);?></td>
                      <td style="text-align: center;"><?php echo ucfirst($details->fever);?></td>
                      <td style="text-align: center;"><?php echo ucfirst($details->cough);?></td>
                      <td style="text-align: center;"><?php echo ucfirst($details->diarrhoea);?></td>
                      <td style="text-align: center;"><?php echo ucfirst($details->Fatigue_weakness);?></td>
                      <td style="text-align: center;"><?php echo ucfirst($details->abdominal_pain);?></td>
                      <td style="text-align: center;"><?php echo ucfirst($details->history_of_fever);?></td>
                      <td style="text-align: center;"><?php echo ucfirst($details->breathlessness);?></td>
                      <td style="text-align: center;"><?php echo ucfirst($details->nausea);?></td>
                      <td style="text-align: center;"><?php echo ucfirst($details->vomiting);?></td>
                      <td style="text-align: center;"><?php echo ucfirst($details->chest_pain);?></td>
                      <td style="text-align: center;"><?php echo ucfirst($details->sputum);?></td>
                      <td style="text-align: center;"><?php echo ucfirst($details->nasal_discharge);?></td>
<!--                      <td style="text-align: center;"><?php echo ucfirst($details->is_phone_connected);?></td>-->
                      
                  <tr>

                    
                </table>

            </div>
        <div class="width2 float_left">
                        <div class="field_row">
                            
                            <div class="field_lable float_left width_25 strong">Doctor Consultation</div>
                            
                            <div class="field_input float_left">
                                 <?php echo $details->doctor_consultation;?>
                             </div>
                            
                        </div>
                </div>
         <div class="width2 float_left">
                        <div class="field_row">
                            
                            <div class="field_lable float_left width_25 strong">Doctor Name</div>
                            
                            <div class="field_input float_left">
                                 <?php  if($details->doctor_name != '') { echo get_corona_doctor($details->doctor_name); } ?>
                             </div>
                            
                        </div>
                </div>
         <div class="width2 float_left">
                        <div class="field_row">
                            
                            <div class="field_lable float_left width_25 strong">ERO Summary</div>
                            
                            <div class="field_input float_left">
                                 <?php  echo $details->ero_summary; ?>
                             </div>
                            
                        </div>
                </div>
         <div class="width2 float_left">
                        <div class="field_row">
                            
                            <div class="field_lable float_left width_25 strong">ERO Standard Remark</div>
                            
                            <div class="field_input float_left">
                                 <?php  if($details->ero_standard_remark != '') { echo get_corona_standard_remark($details->ero_standard_remark); }  ?>
                             </div>
                            
                        </div>
                </div>
         <div class="width2 float_left">
                        <div class="field_row">
                            
                            <div class="field_lable float_left width_25 strong">Close Call</div>
                            
                            <div class="field_input float_left">
                                 <?php  if($details->is_case_close == 0){ echo "Call Not Close"; }else{  echo "Call Close"; }  ?>
                             </div>
                            
                        </div>
                </div>
              
        </div>
  
<?php } } ?>
