
<?php

if(@$view_clg=='view'){ $view='disabled'; }?>

    <form enctype="multipart/form-data" action="#" method="post" id="add_colleague_registration_form">
        <div class="width1">
             <h2 class="txt_clr2 width1 txt_pro">Add Information Form</h2>
             <input type="hidden" name="corona_id" value="<?php echo $corona_patient[0]->corona_id ?>">
             <div class="field_row width_25 float_left">
                 <div class="field_lable"><label for="current_date">Date</label></div>
                 <div class="field_input">
                     <input type="text" name="current_date" class="filter_required" data-errors="{filter_required:'Reference Id should not be blank', filter_string:'Invalid characters in Reference Id'}" value="<?php echo date('Y-m-d'); ?>" TABINDEX="1" disabled="">
                 </div>
             </div>
             <div class="field_row width_25 float_left">
                 <div class="field_lable"><label for="current_date">Mobile No</label></div>
                 <div class="field_input">
                     <input type="text" name="mobile_no" class="filter_required float_left" data-errors="{filter_required:'Mobile No should not be blank', filter_string:'Invalid characters in Reference Id'}" value="<?php echo $corona_patient[0]->mobile_no;?>" TABINDEX="1" readonly="readonly" style="width: 90%;"><a class="click-xhttp-request soft_dial_mobile" data-href="{base_url}avaya_api/hd_soft_dial" data-qr="output_position=content&mobile_no=0<?php echo $corona_patient[0]->mobile_no;?>"></a>
                 </div>
                 <div id="avaya_unique_id">
                     
                 </div>
             </div>
                             <div class="width_25 float_left">
                        <div class="field_row">
                            
                            <div class="field_lable"><label for="ref_id">Full name*</label></div>
                            
                            <div class="field_input">
                                <input type="text" name="follow[0][patient_name]" class="filter_required" data-errors="{filter_required:'Full name should not be blank', filter_string:'Invalid characters in Reference Id'}" value="<?php echo $corona_patient[0]->full_name?>" TABINDEX="1" readonly="readonly">
                             </div>
                            
                        </div>
                </div>
                <div class="width_25 float_left">
                        <div class="field_row">
                            
                            <div class="field_lable"><label for="ref_id">Patient age*</label></div>
                            
                            <div class="field_input">
                                <input type="text" name="follow[0][patient_age]" class="filter_required" data-errors="{filter_required:'Patient age should not be blank', filter_string:'Invalid characters in Reference Id'}" value="<?php echo $corona_patient[0]->patient_age?>" TABINDEX="1" readonly="readonly">
                             </div>
                            
                        </div>
                </div>
              
            <div class="followup_details_box width100 float_left">
                
                <div class="followup_blk">

                <div class="width2 float_left">
                        <div class="field_row">
                            
                            <div class="field_lable"><label for="ref_id">Travel History*</label></div>
                            
                            <div class="field_input">
                                <textarea name="follow[0][travel_history]" class="filter_required" data-errors="{filter_required:'Travel History should not be blank', filter_string:'Invalid characters in Reference Id'}"></textarea>
                             </div>
                            
                        </div>
                </div>
                <div class="width2 float_left">
                        <div class="field_row">
                            
                            <div class="field_lable"><label for="ref_id">Current Place*</label></div>
                            
                            <div class="field_input">
                                <textarea  name="follow[0][current_place]" class="filter_required" data-errors="{filter_required:'Current Place should not be blank', filter_string:'Invalid characters in Reference Id'}"  TABINDEX="1"></textarea>
                             </div>
                            
                        </div>
                </div>
                <div class="width2 float_left">
                        <div class="field_row">
                            
                            <div class="field_lable"><label for="ref_id">ERO Summary*</label></div>
                            
                            <div class="field_input">
                                <textarea name="follow[0][ero_summary]" class="filter_required" data-errors="{filter_required:'ERO Summary should not be blank', filter_string:'Invalid characters in Reference Id'}"  TABINDEX="1"></textarea>
                             </div>
                            
                        </div>
                </div>
                <div class="width2 float_left">
                        <div class="field_row">
                            
                            <div class="field_lable"><label for="ref_id">ERO Advice*</label></div>
                            
                            <div class="field_input">
                                <textarea name="follow[0][ero_note]" class="filter_required" data-errors="{filter_required:'ERO Note should not be blank', filter_string:'Invalid characters in Reference Id'}" TABINDEX="1"></textarea>
                             </div>
                            
                        </div>
                </div>
                <div class="width100">
                    <table class="report_table">
                        <tr><td style="width:100px; font-weight: bold; text-align: center;">Fever</td><td style="width:100px; font-weight: bold; text-align: center;">Cough</td><td style="width:100px; font-weight: bold; text-align: center;">Diarrhoea</td><td style="width:100px; font-weight: bold; text-align: center;">Abdominal pain</td><td style="width:100px; font-weight: bold; text-align: center;">History of fever</td><td style="width:100px; font-weight: bold; text-align: center;">Breathlessness</td><td style="width:100px; font-weight: bold; text-align: center;">Nausea</td><td style="width:100px; font-weight: bold; text-align: center;">Vomiting</td><td style="width:100px; font-weight: bold; text-align: center;">Chest pain</td><td style="width:100px; font-weight: bold; text-align: center;">Sputum</td><td style="width:100px; font-weight: bold; text-align: center;">Nasal discharge</td><td style="width:100px; font-weight: bold; text-align: center;">Call Connected</td><td style="width:120px; font-weight: bold; text-align: center;">Action</td><tr>
                  <tr>
                      <td style="text-align: center;"><input type="checkbox" name="follow[0][fever]" value="yes"></td>
                      <td style="text-align: center;"><input type="checkbox" name="follow[0][cough]" value="yes"></td>
                      <td style="text-align: center;"><input type="checkbox" name="follow[0][diarrhoea]" value="yes"></td>
                      <td style="text-align: center;"><input type="checkbox" name="follow[0][abdominal_pain]" value="yes"></td>
                      <td style="text-align: center;"><input type="checkbox" name="follow[0][history_of_fever]" value="yes"></td>
                      <td style="text-align: center;"><input type="checkbox" name="follow[0][breathlessness]" value="yes"></td>
                      <td style="text-align: center;"><input type="checkbox" name="follow[0][nausea]" value="yes"></td>
                      <td style="text-align: center;"><input type="checkbox" name="follow[0][vomiting]" value="yes"></td>
                      <td style="text-align: center;"><input type="checkbox" name="follow[0][chest_pain]" value="yes"></td>
                      <td style="text-align: center;"><input type="checkbox" name="follow[0][sputum]" value="yes"></td>
                      <td style="text-align: center;"><input type="checkbox" name="follow[0][nasal_discharge]" value="yes"></td>
                      <td style="text-align: center;"><input type="checkbox" name="follow[0][is_phone_connected]" value="yes" checked=""></td>
                      <td style="text-align: center;"><div class="width1 text_align_center add_more_follow">

                              <a class="followup_more btn float_right" style="padding: 5px 5px;">Add +</a>

               </div></td>
                  <tr>

                    
                </table>
                    
                </div>
                 </div>
            </div>
              
        </div>
    
        <div class="width1">
            <?php if(!@$view_clg){ ?>
                <div class="button_field_row width_25 margin_auto">
                    <div class="button_box">
                    <input type="button" name="submit" value="Submit" class="btn submit_btnt form-xhttp-request" data-href='{base_url}corona/save_follow_up' TABINDEX="23" >
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
                 <div class="field_lable"><label for="current_date">Mobile No</label></div>
                 <div class="field_input">
                     <input type="text" name="follow[indx][mobile_no]" class="filter_required" data-errors="{filter_required:'Mobile No should not be blank', filter_string:'Invalid characters in Reference Id'}" value="" TABINDEX="1">
                 </div>
             </div>
                <div class="width2 float_left">
                        <div class="field_row">
                            
                            <div class="field_lable"><label for="ref_id">Travel History*</label></div>
                            
                            <div class="field_input">
                                <textarea name="follow[indx][travel_history]" class="filter_required" data-errors="{filter_required:'Travel History should not be blank', filter_string:'Invalid characters in Reference Id'}"></textarea>
                             </div>
                            
                        </div>
                </div>
                <div class="width2 float_left">
                        <div class="field_row">
                            
                            <div class="field_lable"><label for="ref_id">Current Place*</label></div>
                            
                            <div class="field_input">
                                <textarea name="follow[indx][current_place]" class="filter_required" data-errors="{filter_required:'Current Place should not be blank', filter_string:'Invalid characters in Reference Id'}"></textarea>
                             </div>
                            
                        </div>
                </div>
                <div class="width2 float_left">
                        <div class="field_row">
                            
                            <div class="field_lable"><label for="ref_id">ERO Summary*</label></div>
                            
                            <div class="field_input">
                                <textarea name="follow[indx][ero_summary]" class="filter_required" data-errors="{filter_required:'ERO Summary should not be blank', filter_string:'Invalid characters in Reference Id'}"></textarea>
                             </div>
                            
                        </div>
                </div>
                <div class="width2 float_left">
                        <div class="field_row">
                            
                            <div class="field_lable"><label for="ref_id">ERO Advice*</label></div>
                            
                            <div class="field_input">
                                <textarea name="follow[indx][ero_note]" class="filter_required" data-errors="{filter_required:'ERO Note should not be blank', filter_string:'Invalid characters in Reference Id'}"></textarea>
                             </div>
                            
                        </div>
                </div>
                <div class="width100">
                    <table class="report_table">
                        <tr><td style="width:100px; font-weight: bold; text-align: center;">Fever</td>
                            <td style="width:100px; font-weight: bold; text-align: center;">Cough</td>
                            <td style="width:100px; font-weight: bold; text-align: center;">Diarrhoea</td>
                            <td style="width:100px; font-weight: bold; text-align: center;">Abdominal pain</td>
                            <td style="width:100px; font-weight: bold; text-align: center;">History of fever</td>
                            <td style="width:100px; font-weight: bold; text-align: center;">Breathlessness</td>
                            <td style="width:100px; font-weight: bold; text-align: center;">Nausea</td>
                            <td style="width:100px; font-weight: bold; text-align: center;">Vomiting</td>
                            <td style="width:100px; font-weight: bold; text-align: center;">Chest pain</td>
                            <td style="width:100px; font-weight: bold; text-align: center;">Sputum</td>
                            <td style="width:100px; font-weight: bold; text-align: center;">Nasal discharge</td>
                            <td style="width:100px; font-weight: bold; text-align: center;">Call Connected</td>
                            <td style="width:100px; font-weight: bold; text-align: center;">Action</td>
                        <tr>
                        <tr>
                            <td style="text-align: center;"><input type="checkbox" name="follow[indx][fever]" value="yes"></td>
                            <td style="text-align: center;"><input type="checkbox" name="follow[indx][cough]" value="yes"></td>
                            <td style="text-align: center;"><input type="checkbox" name="follow[indx][diarrhoea]" value="yes"></td>
                            <td style="text-align: center;"><input type="checkbox" name="follow[indx][abdominal_pain]" value="yes"></td>
                            <td style="text-align: center;"><input type="checkbox" name="follow[indx][history_of_fever]" value="yes"></td>
                            <td style="text-align: center;"><input type="checkbox" name="follow[indx][breathlessness]" value="yes"></td>
                            <td style="text-align: center;"><input type="checkbox" name="follow[indx][nausea]" value="yes"></td>
                            <td style="text-align: center;"><input type="checkbox" name="follow[indx][vomiting]" value="yes"></td>
                            <td style="text-align: center;"><input type="checkbox" name="follow[indx][chest_pain]" value="yes"></td>
                            <td style="text-align: center;"><input type="checkbox" name="follow[indx][sputum]" value="yes"></td>
                            <td style="text-align: center;"><input type="checkbox" name="follow[indx][nasal_discharge]" value="yes"></td>
                            <td style="text-align: center;"><input type="checkbox" name="follow[indx][is_phone_connected]" value="yes"></td>
                            <td style="text-align: center;"><div class="width100 display_inlne_block"><a class="remove_button_followup btn" style="float:right; padding: 5px 5px;">Remove</a></div>
                            </td>
                       <tr>

                    
                </table>
                </div>
                
                
            </div>
       
    </div>
</div>