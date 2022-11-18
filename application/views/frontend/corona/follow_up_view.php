
<?php

if(@$view_clg=='view'){ $view='disabled'; }?>

    <form enctype="multipart/form-data" action="#" method="post" id="add_colleague_registration_form">
        <div class="width1">
             <h2 class="txt_clr2 width1 txt_pro">Add Information Form</h2>
             <input type="hidden" name="corona_id" value="<?php echo $corona_patient[0]->corona_id ?>">
<!--             <input type="hidden" name="corona_id" value="<?php echo $corona_patient[0]->corona_id ?>">-->
             <div class="field_row width_20 float_left">
                 <div class="field_lable"><label for="current_date">Date</label></div>
                 <div class="field_input">
                     <input type="text" name="current_date" class="filter_required" data-errors="{filter_required:'Reference Id should not be blank', filter_string:'Invalid characters in Reference Id'}" value="<?php echo date('Y-m-d'); ?>" TABINDEX="1" disabled="">
                 </div>
             </div>
             <div class="field_row width_20 float_left">
                 <div class="field_lable"><label for="test_date">Test Date</label></div>
                 <div class="field_input">
                     <input type="text" name="carona_test_date" class="filter_required" data-errors="{filter_required:'Reference Id should not be blank', filter_string:'Invalid characters in Reference Id'}" value="<?php echo date('Y-m-d', strtotime($corona_patient[0]->carona_test_date)); ?>" TABINDEX="1" disabled="">
                 </div>
             </div>
             <div class="field_row width_20 float_left">
                 <div class="field_lable"><label for="current_date">Mobile No</label></div>
                 <div class="field_input">
                     <input type="text" name="mobile_no" class="filter_required float_left" data-errors="{filter_required:'Mobile No should not be blank', filter_string:'Invalid characters in Reference Id'}" value="<?php echo $corona_patient[0]->mobile_no;?>" TABINDEX="1" readonly="readonly" style="width: 90%;"><a class="click-xhttp-request soft_dial_mobile" data-href="{base_url}avaya_api/hd_soft_dial" data-qr="output_position=content&mobile_no=0<?php echo $corona_patient[0]->mobile_no;?>"></a>
                 </div>
                 <div id="avaya_unique_id">
                     
                 </div>
             </div>
                             <div class="width_20 float_left">
                        <div class="field_row">
                            
                            <div class="field_lable"><label for="ref_id">Full name*</label></div>
                            
                            <div class="field_input">
                                <input type="text" name="follow[0][patient_name]" class="filter_required" data-errors="{filter_required:'Full name should not be blank', filter_string:'Invalid characters in Reference Id'}" value="<?php echo $corona_patient[0]->full_name?>" TABINDEX="1" readonly="readonly">
                             </div>
                            
                        </div>
                </div>
                <div class="width_20 float_left">
                        <div class="field_row">
                            
                            <div class="field_lable"><label for="ref_id">Patient age*</label></div>
                            
                            <div class="field_input">
                                <input type="text" name="follow[0][patient_age]" class="filter_required" data-errors="{filter_required:'Patient age should not be blank', filter_string:'Invalid characters in Reference Id'}" value="<?php echo $corona_patient[0]->patient_age?>" TABINDEX="1">
                             </div>
                            
                        </div>
                </div>
              
            <div class="followup_details_box width100 float_left">
                
                <div class="followup_blk">
                    
                <div class="width2 float_left">
                        <div class="field_row">
                            
                            <div class="field_lable"><label for="ref_id">Call Status</label></div>
                            
                            <div class="field_input">
<!--                                <textarea name="follow[0][is_phone_connected]" class="filter_required" data-errors="{filter_required:'Call Status should not be blank'}"  TABINDEX="1"></textarea>-->
                                <select name="follow[0][is_phone_connected]" class="filter_required corana_call_status" data-errors="{filter_required:'Call Status should not be blank'}"  TABINDEX="1" >
                                    <option value="">Select Call Status</option>
                                    <option value="Call Answered">Call Answered</option>
                                    <option value="Call Not Answered">Call Not Answered</option>
                                    <option value="Not Connected Calls">Not Connected Calls</option>                         
                                    <option value="Switched Off">Switched Off</option>
                                    <option value="Not Reachable">Not Reachable</option>
                                    <option value="Wrong Number">Wrong Number</option>
                                    <option value="Incoming Not Available">Incoming Not Available</option>
                                </select>
                             </div>
                            
                        </div>
                </div>

                <div class="width2 float_left">
                        <div class="field_row">
                            
                            <div class="field_lable"><label for="ref_id">Travel History*</label></div>
                            
                            <div class="field_input">
                                  <select name="follow[0][travel_history]" class="filter_required travel_place" data-errors="{filter_required:'Travel History should not be blank'}" TABINDEX="1" data-index="0">
                                    <option value="">Select Travel History</option>
                                    <option value="Yes">Yes</option>
                                    <option value="No">No</option>
                                  </select>
                             </div>
                            
                        </div>
                </div>
                <div class="width2 float_left hide" id="travel_place_0" >
                        <div class="field_row">
                            
                            <div class="field_lable"><label for="ref_id">Travel Place</label></div>
                            
                            <div class="field_input">
                                <input type="text" name="follow[0][travel_place]" class="" data-errors="{filter_required:'Travel Place should not be blank'}"  TABINDEX="1">
                             </div>
                            
                        </div>
                </div>
                <div class="width2 float_left">
                        <div class="field_row">
                            
                            <div class="field_lable"><label for="ref_id">Current Place*</label></div>
                            
                            <div class="field_input">
                                 <select name="follow[0][current_place]" class="filter_required current_place" data-errors="{filter_required:'Current Place should not be blank'}" TABINDEX="1"  data-index="0">
                                    <option value="">Select Current Place</option>
                                    <option value="Home">Home</option>
                                    <option value="Hospital">Hospital</option>
                                    <option value="Quarantine Center">Quarantine Center</option>
                                    <option value="Covid Care Center">Covid Care Center</option>
                                    <option value="Defense Camp">Defense Camp</option>
                                  </select>
                             </div>
                            
                        </div>
                </div>
                <div class="width2 float_left hide" id="current_place_0" >
                        <div class="field_row">
                            
                            <div class="field_lable"><label for="ref_id">Current Place</label></div>
                            
                            <div class="field_input">
                                <input type="text" name="follow[0][current_place_address]" class="" data-errors="{filter_required:'Current Place should not be blank'}"  TABINDEX="1">
                             </div>
                            
                        </div>
                </div>
                <div class="width2 float_left">
                        <div class="field_row">
                            
                            <div class="field_lable"><label for="ref_id">Treatment*</label></div>
                            
                            <div class="field_input">
                                 <select name="follow[0][treatment]" class="filter_required treatment_place" data-errors="{filter_required:'Treatment should not be blank'}" TABINDEX="1" data-index="0">
                                    <option value="">Select Treatment</option>
                                    <option value="Home Isolation/Home Quarantine">Home Isolation/Home Quarantine</option>
                                    <option value="Treatment at Hospital Ward">Treatment at Hospital Ward</option>
                                    <option value="Treatment at Hospital ICU">Treatment at Hospital ICU</option>
                                    <option value="Treatment at Defense Hosptal / Instutution">Treatment at Defense Hospital / Institution</option>
                                  </select>
                             </div>
                            
                        </div>
                </div> 
                <div class="width2 float_left hide" id="treatment_place_0" >
                        <div class="field_row">
                            
                            <div class="field_lable"><label for="ref_id">Treatment Place</label></div>
                            
                            <div class="field_input">
                                <input type="text" name="follow[0][treatment_place]" class="" data-errors="{filter_required:'Current Place should not be blank'}"  TABINDEX="1">
                             </div>
                            
                        </div>
                </div>
                    
                <div class="width100">
                    <div class="field_lable"><strong>Co-mobid Conditions</strong></div>
                    <table class="report_table">
                        <tr><td style="width:100px; font-weight: bold; text-align: center;">Cardiocascular disease,hypertension, and CAD</td><td style="width:100px; font-weight: bold; text-align: center;">DM (Diabetes mellitus ) and other immumocompromised stated</td><td style="width:100px; font-weight: bold; text-align: center;">Chronic Lung / Kidney / Liver disease</td><td style="width:100px; font-weight: bold; text-align: center;">Cerebrivascular disease</td><td style="width:100px; font-weight: bold; text-align: center;">Obesity</td><td style="width:100px; font-weight: bold; text-align: center;">Any Other</td><tr>
                  <tr>
                      <td style="text-align: center;"><input type="checkbox" name="follow[0][Cardiocascular_disease]" value="yes"></td>
                      <td style="text-align: center;"><input type="checkbox" name="follow[0][DM]" value="yes"></td>
                      <td style="text-align: center;"><input type="checkbox" name="follow[0][Chronic_lung]" value="yes"></td>
                      <td style="text-align: center;"><input type="checkbox" name="follow[0][cerebrivascular]" value="yes"></td>
                      <td style="text-align: center;"><input type="checkbox" name="follow[0][Obesity]" value="yes"></td>
                      <td style="text-align: center;"><input type="text" name="follow[0][any_other]" value=""></td>
                     
                  <tr>

                    
                </table>
                    
                </div>    
               
                <div class="width100">
                         <div class="field_lable"><strong>Symptoms</strong></div>
                    <table class="report_table">
                        <tr><td style="width:100px; font-weight: bold; text-align: center;">Body Pain/Joint Pain</td><td style="width:100px; font-weight: bold; text-align: center;">Fever</td><td style="width:100px; font-weight: bold; text-align: center;">Cough</td><td style="width:100px; font-weight: bold; text-align: center;">Diarrhoea</td><td style="width:100px; font-weight: bold; text-align: center;">Fatigue / Weakness</td><td style="width:100px; font-weight: bold; text-align: center;">Abdominal pain</td>
<!--                            <td style="width:100px; font-weight: bold; text-align: center;">History of fever</td>-->
                            <td style="width:100px; font-weight: bold; text-align: center;">Breathlessness</td><td style="width:100px; font-weight: bold; text-align: center;">Nausea</td><td style="width:100px; font-weight: bold; text-align: center;">Vomiting</td><td style="width:100px; font-weight: bold; text-align: center;">Chest pain</td><td style="width:100px; font-weight: bold; text-align: center;">Sputum</td><td style="width:100px; font-weight: bold; text-align: center;">Nasal discharge</td>
<!--                            <td style="width:100px; font-weight: bold; text-align: center;">Call Connected</td>-->
                            <td style="width:120px; font-weight: bold; text-align: center;">Action</td><tr>
                  <tr>
                      <td style="text-align: center;"><input type="checkbox" name="follow[0][body_pain]" value="yes"></td>
                     <td style="text-align: center;"><input type="checkbox" name="follow[0][fever]" value="yes"></td>-
                      <td style="text-align: center;"><input type="checkbox" name="follow[0][cough]" value="yes"></td>
                      <td style="text-align: center;"><input type="checkbox" name="follow[0][diarrhoea]" value="yes"></td>
                      <td style="text-align: center;"><input type="checkbox" name="follow[0][Fatigue_weakness]" value="yes"></td>
                      <td style="text-align: center;"><input type="checkbox" name="follow[0][abdominal_pain]" value="yes"></td>
<!--                      <td style="text-align: center;"><input type="checkbox" name="follow[0][history_of_fever]" value="yes"></td>-->
                      <td style="text-align: center;"><input type="checkbox" name="follow[0][breathlessness]" value="yes"></td>
                      <td style="text-align: center;"><input type="checkbox" name="follow[0][nausea]" value="yes"></td>
                      <td style="text-align: center;"><input type="checkbox" name="follow[0][vomiting]" value="yes"></td>
                      <td style="text-align: center;"><input type="checkbox" name="follow[0][chest_pain]" value="yes"></td>
                      <td style="text-align: center;"><input type="checkbox" name="follow[0][sputum]" value="yes"></td>
                      <td style="text-align: center;"><input type="checkbox" name="follow[0][nasal_discharge]" value="yes"></td>
<!--                      <td style="text-align: center;"><input type="checkbox" name="follow[0][is_phone_connected]" value="yes" checked=""></td>-->
                      <td style="text-align: center;"><div class="width1 text_align_center add_more_follow">

                              <a class="followup_more btn float_right" style="padding: 5px 5px; margin: 0px;">Add +</a>

               </div></td>
                  <tr>

                    
                </table>
                    
                </div>
                <div class="width100 pulse_oxymeter">
                    <div class="width2 float_left">
                        <div class="field_row">
                            
                            <div class="field_lable"><label for="ref_id">Availability of Pulse Oxymeter</label></div>
                            
                            <div class="field_input pulse_oxymeter">
                                <input type="radio" name="follow[0][pulse_oxymeter]" value="no" checked="checked">No
                               <input type="radio" name="follow[0][pulse_oxymeter]" value="yes">Yes
                               
                            </div>
                            
                        </div>
                    </div>
                    <div class="width2 float_left " >
                            <div class="field_row oxygen_saturation_value hide" >

                                <div class="field_lable"><label >Oxygen Saturation Value</label></div>

                                <div class="field_input">
<!--                                    <textarea name="follow[0][oxygen_saturation_value]" class="" data-errors="{filter_required:'Oxygen Saturation Value should not be blank', filter_string:'Invalid characters in Reference Id'}" TABINDEX="1"></textarea>-->
                                    <input type="text" name="follow[0][oxygen_saturation_value]" class="filter_if_not_blank filter_minlength[0] filter_maxlength[4] filter_number" data-errors="{filter_required:'Oxygen Saturation Value should not be blank', filter_number:'Invalid characters in Oxygen Saturation Value', filter_minlength:'Oxygen Saturation Value should be at least 1 digits long', filter_maxlength:'Oxygen Saturation Value should less then 4 digits.', filter_no_whitespace:'No spaces allowed'}" value="" TABINDEX="1" >
                                 </div>

                            </div>
                    </div>
                </div>
                    
                        <div class="width100">
               <div class="width100">
            <div class="width2 float_left">
                        <div class="field_row">
                            
                            <div class="field_lable"><label for="ref_id">Doctor Consultation*</label></div>
                            
                            <div class="field_input">
                                  <select name="follow[0][doctor_consultation]" class="filter_required doctor_consultation" data-errors="{filter_required:'Doctor Consultation should not be blank'}" TABINDEX="1" >
                                    <option value="">Select Doctor Consultation</option>
                                    <option value="Yes">Yes</option>
                                    <option value="No">No</option>
                                  </select>
                             </div>
                            
                        </div>
                </div>
                <div class="width2 float_left hide" id="doctor_name" >
                        <div class="field_row">
                            
                            <div class="field_lable"><label for="ref_id">Doctor Name</label></div>
                            
                            <div class="field_input">
                                 <input name="follow[0][doctor_name]" tabindex="17" class="mi_autocomplete  form_input" placeholder="Doctor Name" type="text"  data-errors="{filter_required:'Doctor Name should not be blank!'}" data-href="{base_url}auto/corona_doctor" >
                             </div>
                            
                        </div>
                </div>
          
                   <div class="width2 float_left">
                        <div class="field_row">
                            
                            <div class="field_lable"><label for="ref_id">ERO Summary*</label></div>
                            
                            <div class="field_input">
                                <textarea name="follow[0][ero_summary]" id="corona_ero_summary" class="filter_required" data-errors="{filter_required:'ERO Summary should not be blank', filter_string:'Invalid characters in Reference Id'}"  TABINDEX="1"></textarea>
                             </div>
                            
                        </div>
                </div>
                <div class="width2 float_left">
                        <div class="field_row">
                            
                            <div class="field_lable"><label for="ref_id">ERO Standard Remark*</label></div>
                            
                            <div class="field_input">
                                
                                 <input name="follow[0][ero_standard_remark]" tabindex="17" class="mi_autocomplete  form_input filter_required corona_standard_remark" placeholder="ERO Standard Remark" type="text"  data-errors="{filter_required:'ERO Standard Remark should not be blank!'}" data-href="{base_url}auto/corona_standard_remark" >
                             </div>
                            
                        </div>
                </div>
                     <div class="width2 float_left">
                             <div class="field_row">

                                 <div class="field_lable"><label for="ref_id">Close Call</label></div>

                                 <div class="field_input">
                                     <select name="is_case_close" class="filter_required" data-errors="{filter_required:'Close Call should not be blank'}"  TABINDEX="1" > 
                                        <option value="0">Not Close Call</option>
                                        <option value="1">Close Call</option>
                                     </select>
                                  </div>

                             </div>
            </div>
<!--                <div class="width2 float_left">
                        <div class="field_row">
                            
                            <div class="field_lable"><label >Call Not Connected Reason</label></div>
                            
                            <div class="field_input">
                                <textarea name="follow[0][call_connected_reason]" id="call_connected_reason" class="" data-errors="{filter_required:'ERO Note should not be blank', filter_string:'Invalid characters in Reference Id'}" TABINDEX="1"></textarea>
                             </div>
                            
                        </div>
                </div>-->

               </div>
        </div>
                 </div>
            </div>
              
        </div>
    

        <div class="width1">
            <strong style="display:block; text-align: center;">You are humbly requested to follow the Covid-19 SOP's and Guidelines issued by Health Department</strong>
            <?php if(!@$view_clg){ ?>
                <div class="button_field_row save_btn_wrapper width_25 margin_auto">
                    <div class="button_box">
                    <input type="button" name="submit" value="Submit" class="btn submit_btnt accept_btn form-xhttp-request" data-href='{base_url}corona/save_follow_up' TABINDEX="23" >
                    <input type="reset" name="reset" value="Reset" class="btn reset_btn register_view_reset"  TABINDEX="24">              <input type="hidden" name="clg_data" value=<?php echo $data; ?>>
                    </div>
                </div>
        
            <?php }?>
        </div>

    </form>

<div id="corona_add_more" class="hide">
    <div class="followup_blk blk followup_class">
       <div class="width100">
            <div class="field_row width100  fleet">
                        <div class="single_record_back">Patient Details</div>
            </div>
                <div class="width_25 float_left">
                        <div class="field_row">
                            
                            <div class="field_lable"><label for="ref_id">Full name*</label></div>
                            
                            <div class="field_input">
                                <input type="text" name="follow[indx][patient_name]" class="filter_required" data-errors="{filter_required:'Full nameshould not be blank', filter_string:'Invalid characters in Reference Id'}" value="" TABINDEX="1">
                            
                             </div>
                            
                        </div>
                </div>
                <div class="width_25 float_left">
                        <div class="field_row">
                            
                            <div class="field_lable"><label for="ref_id">Patient age*</label></div>
                            
                            <div class="field_input">
                                <input type="text" name="follow[indx][patient_age]" class="filter_required" data-errors="{filter_required:'Patient age should not be blank', filter_string:'Invalid characters in Reference Id'}" value="" TABINDEX="1">
                             </div>
                            
                        </div>
                </div>
           <div class="field_row width_25 float_left">
                 <div class="field_lable"><label for="mobile_date">Mobile No</label></div>
                 <div class="field_input">
                     <input type="text" name="follow[indx][mobile_no]" class="filter_required" data-errors="{filter_required:'Mobile No should not be blank', filter_string:'Invalid characters in Reference Id'}" value="" TABINDEX="1">
                 </div>
             </div>
            <div class="width2 float_left">
                             <div class="field_row">

                                 <div class="field_lable"><label for="ref_id">Call Status</label></div>

                                 <div class="field_input">
     <!--                                <textarea name="follow[0][is_phone_connected]" class="filter_required" data-errors="{filter_required:'Call Status should not be blank'}"  TABINDEX="1"></textarea>-->
                                     <select name="follow[indx][is_phone_connected]" class="filter_required" data-errors="{filter_required:'Call Status should not be blank'}"  TABINDEX="1" >
                                         <option value="">Select Call Status</option>
                                         <option value="Call Answered">Call Answered</option>
                                         <option value="Call Not Answered">Call Not Answered</option>
                                         <option value="Switched Off">Switched Off</option>
                                         <option value="Not Reachable">Not Reachable</option>
                                         <option value="Wrong Number">Wrong Number</option>
                                         <option value="Incoming Not Available">Incoming Not Available</option>
                                     </select>
                                  </div>

                             </div>
                     </div>
                <div class="width2 float_left">
                        <div class="field_row">
                            
                            <div class="field_lable"><label for="ref_id">Travel History*</label></div>
                            
                            <div class="field_input">
                                 <select name="follow[indx][travel_history]" class="filter_required travel_place" data-errors="{filter_required:'Travel History should not be blank'}" TABINDEX="1" data-index="indx">
                                    <option value="">Select Travel History</option>
                                    <option value="Yes">Yes</option>
                                    <option value="No">No</option>
                                  </select>
                             </div>
                            
                        </div>
                </div>
                <div class="width2 float_left hide" id="travel_place_indx" >
                        <div class="field_row">
                            
                            <div class="field_lable"><label for="ref_id">Travel Place*</label></div>
                            
                            <div class="field_input">
                                <input type="text" name="follow[indx][travel_place]" class="" data-errors="{filter_required:'Travel Place should not be blank'}"  TABINDEX="1">
                             </div>
                            
                        </div>
                </div>
                <div class="width2 float_left">
                        <div class="field_row">
                            
                            <div class="field_lable"><label for="ref_id">Current Place*</label></div>
                            
                            <div class="field_input">
                                  <select name="follow[indx][current_place]" class="filter_required current_place" data-errors="{filter_required:'Current Place should not be blank'}" TABINDEX="1" data-index="indx"> >
                                    <option value="">Select Current Place</option>
                                    <option value="Home">Home</option>
                                    <option value="Hospital">Hospital</option>
                                    <option value="Quarantine Center">Quarantine Center</option>
                                    <option value="Covid Care Center">Covid Care Center</option>
                                    <option value="Defense Camp">Defense Camp</option>
                                  </select>
                             </div>
                            
                        </div>
                </div>
           <div class="width2 float_left hide" id="current_place_indx" >
                        <div class="field_row">
                            
                            <div class="field_lable"><label for="ref_id">Current Place </label></div>
                            
                            <div class="field_input">
                                <input type="text" name="follow[indx][current_place_address]" class="" data-errors="{filter_required:'Current Place should not be blank'}"  TABINDEX="1">
                             </div>
                            
                        </div>
                </div>
                 <div class="width2 float_left">
                        <div class="field_row">
                            
                            <div class="field_lable"><label for="ref_id">Treatment*</label></div>
                            
                            <div class="field_input">
                                 <select name="follow[indx][treatment]" class="filter_required treatment_place" data-errors="{filter_required:'Treatment should not be blank'}" TABINDEX="1" data-index="indx">
                                    <option value="">Select Treatment</option>
                                    <option value="Home Isolation/Home Quarantine">Home Isolation/Home Quarantine</option>
                                    <option value="Treatment at Hospital Ward">Treatment at Hospital Ward</option>
                                    <option value="Treatment at Hospital ICU">Treatment at Hospital ICU</option>
                                    <option value="Treatment at Defense Hosptal / Instutution">Treatment at Defense Hospital / Institution</option>
                                  </select>
                             </div>
                            
                        </div>
                </div> 
                <div class="width2 float_left hide" id="treatment_place_indx">
                        <div class="field_row">
                            
                            <div class="field_lable"><label for="ref_id">Treatment Place </label></div>
                            
                            <div class="field_input">
                                <input type="text" name="follow[indx][treatment_place]" class="" data-errors="{filter_required:'Treatment Place should not be blank'}"  TABINDEX="1">
                             </div>
                            
                        </div>
                </div>
             <div class="width100">
                                  <div class="field_lable"><strong>Co-mobid Conditions</strong></div>
                    <table class="report_table">
                        <tr><td style="width:100px; font-weight: bold; text-align: center;">Cardiocascular disease,hypertension, and CAD</td><td style="width:100px; font-weight: bold; text-align: center;">DM (Diabetes mellitus ) and other immumocompromised stated</td><td style="width:100px; font-weight: bold; text-align: center;">Chronic Lung / Kidney / Liver disease</td><td style="width:100px; font-weight: bold; text-align: center;">Cerebrivascular disease</td><td style="width:100px; font-weight: bold; text-align: center;">Obesity</td><td style="width:100px; font-weight: bold; text-align: center;">Any Other</td><tr>
                  <tr>
                      <td style="text-align: center;"><input type="checkbox" name="follow[indx][Cardiocascular_disease]" value="yes"></td>
                      <td style="text-align: center;"><input type="checkbox" name="follow[indx][DM]" value="yes"></td>
                      <td style="text-align: center;"><input type="checkbox" name="follow[indx][Chronic_lung]" value="yes"></td>
                      <td style="text-align: center;"><input type="checkbox" name="follow[indx][cerebrivascular]" value="yes"></td>
                      <td style="text-align: center;"><input type="checkbox" name="follow[indx][Obesity]" value="yes"></td>
                      <td style="text-align: center;"><input type="text" name="follow[indx][any_other]" value=""></td>
                     
                  <tr>

                    
                </table>
                    
                </div>  
                <div class="width100">
                    <div class="field_lable"><strong>Symptoms</strong></div>
                    <table class="report_table">
                        <tr>
                           
                            <td style="width:100px; font-weight: bold; text-align: center;"> Body Pain/Joint Pain</td>
                            <td style="width:100px; font-weight: bold; text-align: center;">Fever</td>
                            <td style="width:100px; font-weight: bold; text-align: center;">Cough</td>
                            <td style="width:100px; font-weight: bold; text-align: center;">Diarrhoea</td>
                            <td style="width:100px; font-weight: bold; text-align: center;">Fatigue / Weakness</td>    
                            <td style="width:100px; font-weight: bold; text-align: center;">Abdominal pain</td>
<!--                            <td style="width:100px; font-weight: bold; text-align: center;">History of fever</td>-->
                            <td style="width:100px; font-weight: bold; text-align: center;">Breathlessness</td>
                            <td style="width:100px; font-weight: bold; text-align: center;">Nausea</td>
                            <td style="width:100px; font-weight: bold; text-align: center;">Vomiting</td>
                            <td style="width:100px; font-weight: bold; text-align: center;">Chest pain</td>
                            <td style="width:100px; font-weight: bold; text-align: center;">Sputum</td>
                            <td style="width:100px; font-weight: bold; text-align: center;">Nasal discharge</td>
<!--                            <td style="width:100px; font-weight: bold; text-align: center;">Call Connected</td>-->
                            <td style="width:100px; font-weight: bold; text-align: center;">Action</td>
                        <tr>
                        <tr>

                            <td style="text-align: center;"><input type="checkbox" name="follow[indx][body_pain]" value="yes"></td>
                            <td style="text-align: center;"><input type="checkbox" name="follow[indx][fever]" value="yes"></td>
                            <td style="text-align: center;"><input type="checkbox" name="follow[indx][cough]" value="yes"></td>
                            <td style="text-align: center;"><input type="checkbox" name="follow[indx][diarrhoea]" value="yes"></td>
                             <td style="text-align: center;"><input type="checkbox" name="follow[indx][Fatigue_weakness]" value="yes"></td>
                            <td style="text-align: center;"><input type="checkbox" name="follow[indx][abdominal_pain]" value="yes"></td>
<!--                            <td style="text-align: center;"><input type="checkbox" name="follow[indx][history_of_fever]" value="yes"></td>-->
                            <td style="text-align: center;"><input type="checkbox" name="follow[indx][breathlessness]" value="yes"></td>
                            <td style="text-align: center;"><input type="checkbox" name="follow[indx][nausea]" value="yes"></td>
                            <td style="text-align: center;"><input type="checkbox" name="follow[indx][vomiting]" value="yes"></td>
                            <td style="text-align: center;"><input type="checkbox" name="follow[indx][chest_pain]" value="yes"></td>
                            <td style="text-align: center;"><input type="checkbox" name="follow[indx][sputum]" value="yes"></td>
                            <td style="text-align: center;"><input type="checkbox" name="follow[indx][nasal_discharge]" value="yes"></td>
<!--                            <td style="text-align: center;"><input type="checkbox" name="follow[indx][is_phone_connected]" value="yes"></td>-->
                            <td style="text-align: center;"><div class="width100 display_inlne_block"><a class="remove_button_followup btn" style="float:right; padding: 5px 5px;">Remove</a></div>
                            </td>
                       <tr>

                    
                </table>
                </div>
           <div class="width100 pulse_oxymeter">
                    <div class="width2 float_left">
                        <div class="field_row">
                            
                            <div class="field_lable"><label for="ref_id">Availability of Pulse Oxymeter</label></div>
                            
                            <div class="field_input pulse_oxymeter">
                                <input type="radio" name="follow[indx][pulse_oxymeter]" value="no" checked="checked">No
                               <input type="radio" name="follow[indx][pulse_oxymeter]" value="yes">Yes
                               
                            </div>
                            
                        </div>
                    </div>
                    <div class="width2 float_left " >
                            <div class="field_row oxygen_saturation_value hide" >

                                <div class="field_lable"><label >Oxygen Saturation Value</label></div>

                                <div class="field_input">
                                    <input type="text" name="follow[indx][oxygen_saturation_value]" class="filter_if_not_blank filter_minlength[0] filter_maxlength[4] filter_number" data-errors="{filter_required:'Oxygen Saturation Value should not be blank', filter_number:'Invalid characters in Oxygen Saturation Value', filter_minlength:'Oxygen Saturation Value should be at least 1 digits long', filter_maxlength:'Oxygen Saturation Value should less then 4 digits.', filter_no_whitespace:'No spaces allowed'}" value="" TABINDEX="1" >
                                 </div>

                            </div>
                    </div>
                </div>
                <div class="width100">
               <div class="width100">
            <div class="width2 float_left">
                        <div class="field_row">
                            
                            <div class="field_lable"><label for="ref_id">Doctor Consultation*</label></div>
                            
                            <div class="field_input">
                                  <select name="follow[indx][doctor_consultation]" class="filter_required" data-errors="{filter_required:'Doctor Consultation should not be blank'}" TABINDEX="1" id="doctor_consultation">
                                    <option value="">Select Doctor Consultation</option>
                                    <option value="Yes">Yes</option>
                                    <option value="No">No</option>
                                  </select>
                             </div>
                            
                        </div>
                </div>
                <div class="width2 float_left hide" id="doctor_name" >
                        <div class="field_row">
                            
                            <div class="field_lable"><label for="ref_id">Doctor Name</label></div>
                            
                            <div class="field_input">
                                 <input name="follow[indx][doctor_name]" tabindex="17" class="mi_autocomplete form_input" placeholder="Doctor Name" type="text"  data-errors="{filter_required:'Doctor Name should not be blank!'}" data-href="{base_url}auto/corona_doctor" >
                             </div>
                            
                        </div>
                </div>
<!--            <div class="width2 float_left">
                             <div class="field_row">

                                 <div class="field_lable"><label for="ref_id">Close Call</label></div>

                                 <div class="field_input">
                                     <select name="is_case_close" class="filter_required" data-errors="{filter_required:'Call Status should not be blank'}"  TABINDEX="1" > 
                                        <option value="0">Not Close Call</option>
                                        <option value="1">Close Call</option>
                                     </select>
                                  </div>

                             </div>
            </div>-->
                   <div class="width2 float_left">
                        <div class="field_row">
                            
                            <div class="field_lable"><label for="ref_id">ERO Summary*</label></div>
                            
                            <div class="field_input">
                                <textarea name="follow[indx][ero_summary]" id="corona_ero_summary" class="filter_required" data-errors="{filter_required:'ERO Summary should not be blank', filter_string:'Invalid characters in Reference Id'}"  TABINDEX="1"></textarea>
                             </div>
                            
                        </div>
                </div>
                <div class="width2 float_left">
                        <div class="field_row">
                            
                            <div class="field_lable"><label for="ref_id">ERO Standard Remark*</label></div>
                            
                            <div class="field_input">
                                
                                 <input name="follow[indx][ero_standard_remark]" tabindex="17" class="autocls form_input filter_required" placeholder="ERO Standard Remark" type="text" data-errors="{filter_required:'ERO Standard Remark should not be blank!'}" data-href="{base_url}auto/corona_standard_remark" >
                             </div>
                            
                        </div>
                </div>

               </div>
        </div>
           
              
                
                
            </div>
       
    </div>
</div>