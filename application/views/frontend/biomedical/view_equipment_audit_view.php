<script>
//if(typeof H != 'undefined'){
    //init_auto_address();
//}

</script>


    <div class="width1">
        <h2 class="txt_clr2 width1 txt_pro">View Equipment Audit</h2>


        <div class="joining_details_box">
            
            <div class="width100">

                <div class="field_row width100">

                    <div class="width2 float_left">
                        <div class="field_lable float_left width33"><label for="district">State<span class="md_field">*</span></label></div>
                        <div class="filed_input float_left width50"> <div id="ambulance_state">

Madhya Pradesh

                            </div>

                        </div>

                    </div>
                    <div class="width2 float_left">    
                        <div class="field_lable float_left width33"><label for="district">District<span class="md_field">*</span></label></div>   <div class="filed_input float_left width50">
                            <div id="incient_district">
                                <?php
                                echo get_district_by_id($eqp_audit[0]->district_id); ?>
                             
                                
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
                                echo $eqp_audit[0]->ambulance_no; ?>
                               

                            </div>

                        </div>

                    </div>

                    <div class="width2 float_left">
                        <div class="field_lable float_left width33"><label for="district">Base Location<span class="md_field">*</span></label></div>


                        <div class="filed_input float_left width50" id="amb_base_location">
                            <?php
                                echo $eqp_audit[0]->base_location; ?>

                        </div>


                    </div>
                </div>
                <div class="field_row width100">

                        <div class="width2 float_left">
                            <div class="field_lable float_left width33"><label for="amb_type">Ambulance Type<span class="md_field">*</span></label></div>   

                            <div class="field_input float_left width50" id="type_of_ambulance">
                                   <?php
                                echo show_amb_type_name($eqp_audit[0]->ambulance_type); ?>
                            </div>
                        </div>
                        <div class="width2 float_left">
                            <div class="field_lable float_left width33"> <label for="mobile_no">AOM<span class="md_field">*</span></label></div>
                            <div class="filed_input float_left width50">
                            <?php
                                echo $eqp_audit[0]->aom; ?>
                            </div>
                        </div>
                </div>
                <div class="width100">
                        <div class="width50 drg float_left">
                            <div class="width33 float_left">
                                <div class=" float_left">EMT ID<span class="md_field">*</span></div>
                            </div>
                            <div class="width50 float_left">
                              <?php
                                echo $eqp_audit[0]->emt_id; ?>
                            </div>
                        </div>
                        <div class="width50 drg float_left">
                            <div class="width33 float_left">
                                <div class=" float_left">EMT Name<span class="md_field">*</span></div>
                            </div>
                            <div class="width50 float_left" id="show_emso_name">
                               <?php
                                echo $eqp_audit[0]->emt_name; ?>
                                
                            </div>
                        </div>

                    </div>
                    <div class="width100">
                        <div class="width50 drg float_left">
                            <div class="width33 float_left">
                                <div class=" float_left">Pilot ID<span class="md_field">*</span></div>
                            </div>
                            <div class="width50 float_left">
                             
                               
                                 <?php
                                echo $eqp_audit[0]->pilot_id; ?>
                            </div>
                        </div>
                        <div class="width50 drg float_left">
                            <div class="width33 float_left">
                                <div class=" float_left">Pilot Name<span class="md_field">*</span></div>
                            </div>
                            <div class="width50 float_left" id="show_pilot_name">
                                 <?php echo $eqp_audit[0]->pilot_name; ?>
                            </div>
                        </div>

                    </div>
                 <div class="field_row width100">
                    
                     <div class="width2 float_left">
                        
                        <div class="field_lable float_left width33"><label for="breakdown_date">Previous Audit Date<span class="md_field">*</span></label></div>
                        <div class="filed_input float_left width50" >
                             
                               <?php echo $eqp_audit[0]->previous_audit_date; ?>
                           
                           
                        </div>
                    </div>
                     <div class="width2 float_left">
                        
                        <div class="field_lable float_left width33"><label for="breakdown_date">Current Audit Date<span class="md_field">*</span></label></div>
                        <div class="filed_input float_left width50" >
                            
                              
                           
                               <?php echo $eqp_audit[0]->current_audit_date; ?>
                           
                        </div>
                        
                    </div>
                 </div>
               
                <div class="field_row width100">
                    <table class="report_table">
                        <tr><td>S.No.</td><td>Item name</td><td>Availability</td><td>Working Status</td><td>Any Damage/Broken</td><td>If Not Working then Reason</td><td>If Damage / Broken then details</td><td>Other Remarks</tr>
                        <tr><td>1)</td><td>
                             <?php echo $equp_data[0]->item_name; ?>
                            </td>
                                <td>
         <?php echo $equp_data[0]->availability; ?>
    </td>
    <td>
         <?php echo $equp_data[0]->working_status; ?>
    </td>
    <td>
          <?php echo $equp_data[0]->damage_broken; ?>
    </td>
        <td> <?= @$equp_data[0]->not_working_reason; ?></td>
        <td>
            <?php echo $equp_data[0]->damage_reason; ?>
            
    </td>
    <td> <?php echo $equp_data[0]->other_remark; ?></td>
                        </tr>
                        <tr><td>2)</td><td>
                               <?php echo $equp_data[1]->item_name; ?>
                            </td>                          
                            <td>
         <?php echo $equp_data[1]->availability; ?>
    </td>
    <td>
         <?php echo $equp_data[1]->working_status; ?>
    </td>
    <td>
          <?php echo $equp_data[1]->damage_broken; ?>
    </td>
        <td> <?= @$equp_data[1]->not_working_reason; ?></td>
        <td>
            <?php echo $equp_data[1]->damage_reason; ?>
            
    </td>
    <td> <?php echo $equp_data[1]->other_remark; ?></td>
                        </tr>
<tr><td>3)</td>
    <td><?php echo $equp_data[2]->item_name; ?></td>    
    <td>
         <?php echo $equp_data[2]->availability; ?>
    </td>
    <td>
         <?php echo $equp_data[2]->working_status; ?>
    </td>
    <td>
          <?php echo $equp_data[2]->damage_broken; ?>
    </td>
        <td> <?= @$equp_data[2]->not_working_reason; ?></td>
        <td>
            <?php echo $equp_data[2]->damage_reason; ?>
            
    </td>
    <td> <?php echo $equp_data[2]->other_remark; ?></td>
</tr>
 <tr><td>4)</td><td>Wheel Chair</td> <td>
         <?php echo $equp_data[3]->availability; ?>
    </td>
    <td>
         <?php echo $equp_data[3]->working_status; ?>
    </td>
    <td>
          <?php echo $equp_data[3]->damage_broken; ?>
    </td>
        <td> <?= @$equp_data[3]->not_working_reason; ?></td>
        <td>
            <?php echo $equp_data[3]->damage_reason; ?>
            
    </td>
    <td> <?php echo $equp_data[3]->other_remark; ?></td></tr>
 <tr><td>5)</td><td>Nebulizer Machine</td> <td>
         <?php echo $equp_data[4]->availability; ?>
    </td>
    <td>
         <?php echo $equp_data[4]->working_status; ?>
    </td>
    <td>
          <?php echo $equp_data[4]->damage_broken; ?>
    </td>
        <td> <?= @$equp_data[4]->not_working_reason; ?></td>
        <td>
            <?php echo $equp_data[4]->damage_reason; ?>
            
    </td>
    <td> <?php echo $equp_data[4]->other_remark; ?></td></tr>
<tr><td>6)</td><td>Digital Thermometer</td><td>
         <?php echo $equp_data[5]->availability; ?>
    </td>
    <td>
         <?php echo $equp_data[5]->working_status; ?>
    </td>
    <td>
          <?php echo $equp_data[5]->damage_broken; ?>
    </td>
        <td> <?= @$equp_data[5]->not_working_reason; ?></td>
        <td>
            <?php echo $equp_data[5]->damage_reason; ?>
            
    </td>
    <td> <?php echo $equp_data[5]->other_remark; ?></td></tr>
<tr><td>7)</td><td>Glucometer Set</td><td>
         <?php echo $equp_data[6]->availability; ?>
    </td>
    <td>
         <?php echo $equp_data[6]->working_status; ?>
    </td>
    <td>
          <?php echo $equp_data[6]->damage_broken; ?>
    </td>
        <td> <?= @$equp_data[6]->not_working_reason; ?></td>
        <td>
            <?php echo $equp_data[6]->damage_reason; ?>
            
    </td>
    <td> <?php echo $equp_data[6]->other_remark; ?></td></tr>
<tr><td>8)</td><td>Stethoscope</td>
    <td>
         <?php echo $equp_data[7]->availability; ?>
    </td>
    <td>
         <?php echo $equp_data[7]->working_status; ?>
    </td>
    <td>
          <?php echo $equp_data[7]->damage_broken; ?>
    </td>
        <td> <?= @$equp_data[7]->not_working_reason; ?></td>
        <td>
            <?php echo $equp_data[7]->damage_reason; ?>
            
    </td>
    <td> <?php echo $equp_data[7]->other_remark; ?></td>
</tr>
<tr><td>9)</td><td>Handheld Suction Pump with Tubing</td>
   <td>
         <?php echo $equp_data[8]->availability; ?>
    </td>
    <td>
         <?php echo $equp_data[8]->working_status; ?>
    </td>
    <td>
          <?php echo $equp_data[8]->damage_broken; ?>
    </td>
        <td> <?= @$equp_data[8]->not_working_reason; ?></td>
        <td>
            <?php echo $equp_data[8]->damage_reason; ?>
            
    </td>
    <td> <?php echo $equp_data[8]->other_remark; ?></td></tr>
<tr><td>10)</td><td>AC/DC Suction Pump</td>
<td>
         <?php echo $equp_data[9]->availability; ?>
    </td>
    <td>
         <?php echo $equp_data[9]->working_status; ?>
    </td>
    <td>
          <?php echo $equp_data[9]->damage_broken; ?>
    </td>
        <td> <?= @$equp_data[9]->not_working_reason; ?></td>
        <td>
            <?php echo $equp_data[9]->damage_reason; ?>
            
    </td>
    <td> <?php echo $equp_data[9]->other_remark; ?></td></tr>
<tr><td>i</td><td>Filter</td><td>
         <?php echo $equp_data[10]->availability; ?>
    </td>
    <td>
         <?php echo $equp_data[10]->working_status; ?>
    </td>
    <td>
          <?php echo $equp_data[10]->damage_broken; ?>
    </td>
        <td> <?= @$equp_data[10]->not_working_reason; ?></td>
        <td>
            <?php echo $equp_data[10]->damage_reason; ?>
            
    </td>
    <td> <?php echo $equp_data[10]->other_remark; ?></td></tr>
<tr><td>ii</td><td>Tubing</td><td>
         <?php echo $equp_data[11]->availability; ?>
    </td>
    <td>
         <?php echo $equp_data[11]->working_status; ?>
    </td>
    <td>
          <?php echo $equp_data[11]->damage_broken; ?>
    </td>
        <td> <?= @$equp_data[11]->not_working_reason; ?></td>
        <td>
            <?php echo $equp_data[11]->damage_reason; ?>
            
    </td>
    <td> <?php echo $equp_data[11]->other_remark; ?></td></tr>
<tr><td>iii</td><td>Suction Jar</td><td>
         <?php echo $equp_data[12]->availability; ?>
    </td>
    <td>
         <?php echo $equp_data[12]->working_status; ?>
    </td>
    <td>
          <?php echo $equp_data[12]->damage_broken; ?>
    </td>
        <td> <?= @$equp_data[12]->not_working_reason; ?></td>
        <td>
            <?php echo $equp_data[12]->damage_reason; ?>
            
    </td>
    <td> <?php echo $equp_data[12]->other_remark; ?></td></tr>
<tr><td>11)</td><td>Sphygmomanometer</td>
 <td>
 <?php echo $equp_data[13]->availability; ?>
    </td>
    <td>
         <?php echo $equp_data[13]->working_status; ?>
    </td>
    <td>
          <?php echo $equp_data[13]->damage_broken; ?>
    </td>
        <td> <?= @$equp_data[13]->not_working_reason; ?></td>
        <td>
            <?php echo $equp_data[13]->damage_reason; ?>
            
    </td>
    <td> <?php echo $equp_data[13]->other_remark; ?></td>
</tr>
<tr><td>i</td><td>Adult cuff with Baloon</td>
    <td>
         <?php echo $equp_data[14]->availability; ?>
    </td>
    <td>
         <?php echo $equp_data[14]->working_status; ?>
    </td>
    <td>
          <?php echo $equp_data[14]->damage_broken; ?>
    </td>
        <td> <?= @$equp_data[14]->not_working_reason; ?></td>
        <td>
            <?php echo $equp_data[14]->damage_reason; ?>
            
    </td>
    <td> <?php echo $equp_data[14]->other_remark; ?></td>
</tr>
<tr><td>ii</td><td>Pead cuff with Baloon</td><td>
         <?php echo $equp_data[15]->availability; ?>
    </td>
    <td>
         <?php echo $equp_data[15]->working_status; ?>
    </td>
    <td>
          <?php echo $equp_data[15]->damage_broken; ?>
    </td>
        <td> <?= @$equp_data[15]->not_working_reason; ?></td>
        <td>
            <?php echo $equp_data[15]->damage_reason; ?>
            
    </td>
    <td> <?php echo $equp_data[15]->other_remark; ?></td></tr>
<tr><td>iii</td><td>Neonatal cuff with Baloon</td>
    <td>
 <?php echo $equp_data[16]->availability; ?>
    </td>
    <td>
         <?php echo $equp_data[16]->working_status; ?>
    </td>
    <td>
          <?php echo $equp_data[16]->damage_broken; ?>
    </td>
        <td> <?= @$equp_data[16]->not_working_reason; ?></td>
        <td>
            <?php echo $equp_data[16]->damage_reason; ?>
            
    </td>
    <td> <?php echo $equp_data[16]->other_remark; ?></td>
</tr>
<tr><td>12)</td><td>Transport Ventilator (Portable)</td>
<td>
 <?php echo $equp_data[17]->availability; ?>
    </td>
    <td>
         <?php echo $equp_data[17]->working_status; ?>
    </td>
    <td>
          <?php echo $equp_data[17]->damage_broken; ?>
    </td>
        <td> <?= @$equp_data[17]->not_working_reason; ?></td>
        <td>
            <?php echo $equp_data[17]->damage_reason; ?>
            
    </td>
    <td> <?php echo $equp_data[17]->other_remark; ?></td>
</tr>
<tr><td>i</td><td>Breathing Hose Pipe</td>
 <td>
 <?php echo $equp_data[18]->availability; ?>
    </td>
    <td>
         <?php echo $equp_data[18]->working_status; ?>
    </td>
    <td>
          <?php echo $equp_data[18]->damage_broken; ?>
    </td>
        <td> <?= @$equp_data[18]->not_working_reason; ?></td>
        <td>
            <?php echo $equp_data[18]->damage_reason; ?>
            
    </td>
    <td> <?php echo $equp_data[18]->other_remark; ?></td>
</tr>
<tr><td>ii</td><td>Test Lung</td>
 <td>
 <?php echo $equp_data[19]->availability; ?>
    </td>
    <td>
         <?php echo $equp_data[19]->working_status; ?>
    </td>
    <td>
          <?php echo $equp_data[19]->damage_broken; ?>
    </td>
        <td> <?= @$equp_data[19]->not_working_reason; ?></td>
        <td>
            <?php echo $equp_data[19]->damage_reason; ?>
            
    </td>
    <td> <?php echo $equp_data[19]->other_remark; ?></td>
</tr>
<tr><td>13)</td><td>Defibrillator</td> <td>
 <?php echo $equp_data[20]->availability; ?>
    </td>
    <td>
         <?php echo $equp_data[20]->working_status; ?>
    </td>
    <td>
          <?php echo $equp_data[20]->damage_broken; ?>
    </td>
        <td> <?= @$equp_data[20]->not_working_reason; ?></td>
        <td>
            <?php echo $equp_data[20]->damage_reason; ?>
            
    </td>
    <td> <?php echo $equp_data[20]->other_remark; ?></td></tr>
<tr><td>i</td><td>Spo2 sensor cable</td> <td>
 <?php echo $equp_data[21]->availability; ?>
    </td>
    <td>
         <?php echo $equp_data[21]->working_status; ?>
    </td>
    <td>
          <?php echo $equp_data[21]->damage_broken; ?>
    </td>
        <td> <?= @$equp_data[21]->not_working_reason; ?></td>
        <td>
            <?php echo $equp_data[21]->damage_reason; ?>
            
    </td>
    <td> <?php echo $equp_data[21]->other_remark; ?></td></tr>
<tr><td>ii</td><td>ECG cable</td> <td>
 <?php echo $equp_data[22]->availability; ?>
    </td>
    <td>
         <?php echo $equp_data[22]->working_status; ?>
    </td>
    <td>
          <?php echo $equp_data[22]->damage_broken; ?>
    </td>
        <td> <?= @$equp_data[22]->not_working_reason; ?></td>
        <td>
            <?php echo $equp_data[22]->damage_reason; ?>
            
    </td>
    <td> <?php echo $equp_data[22]->other_remark; ?></td></tr>
<tr><td>iii</td><td>NIBP Tube and Cuff</td> <td>
 <?php echo $equp_data[23]->availability; ?>
    </td>
    <td>
         <?php echo $equp_data[23]->working_status; ?>
    </td>
    <td>
          <?php echo $equp_data[23]->damage_broken; ?>
    </td>
        <td> <?= @$equp_data[23]->not_working_reason; ?></td>
        <td>
            <?php echo $equp_data[23]->damage_reason; ?>
            
    </td>
    <td> <?php echo $equp_data[23]->other_remark; ?></td></tr>
<tr><td>iv</td><td>Shock Paddles</td> <td>
 <?php echo $equp_data[24]->availability; ?>
    </td>
    <td>
         <?php echo $equp_data[24]->working_status; ?>
    </td>
    <td>
          <?php echo $equp_data[24]->damage_broken; ?>
    </td>
        <td> <?= @$equp_data[24]->not_working_reason; ?></td>
        <td>
            <?php echo $equp_data[24]->damage_reason; ?>
            
    </td>
    <td> <?php echo $equp_data[24]->other_remark; ?></td></tr>
<tr><td>14)</td><td>Pulse Oximeter</td> <td>
 <?php echo $equp_data[25]->availability; ?>
    </td>
    <td>
         <?php echo $equp_data[25]->working_status; ?>
    </td>
    <td>
          <?php echo $equp_data[25]->damage_broken; ?>
    </td>
        <td> <?= @$equp_data[25]->not_working_reason; ?></td>
        <td>
            <?php echo $equp_data[25]->damage_reason; ?>
            
    </td>
    <td> <?php echo $equp_data[25]->other_remark; ?></td></tr>
<tr><td>i</td><td>Handheld System</td> <td>
 <?php echo $equp_data[26]->availability; ?>
    </td>
    <td>
         <?php echo $equp_data[26]->working_status; ?>
    </td>
    <td>
          <?php echo $equp_data[26]->damage_broken; ?>
    </td>
        <td> <?= @$equp_data[26]->not_working_reason; ?></td>
        <td>
            <?php echo $equp_data[26]->damage_reason; ?>
            
    </td>
    <td> <?php echo $equp_data[26]->other_remark; ?></td></tr>
<tr><td>ii</td><td>Charging station</td>
    <td>
 <?php echo $equp_data[27]->availability; ?>
    </td>
    <td>
         <?php echo $equp_data[27]->working_status; ?>
    </td>
    <td>
          <?php echo $equp_data[27]->damage_broken; ?>
    </td>
        <td> <?= @$equp_data[27]->not_working_reason; ?></td>
        <td>
            <?php echo $equp_data[27]->damage_reason; ?>
            
    </td>
    <td> <?php echo $equp_data[27]->other_remark; ?></td></tr>
<tr><td>iii</td><td>Spo2 sensor cable</td>
   <td>
 <?php echo $equp_data[28]->availability; ?>
    </td>
    <td>
         <?php echo $equp_data[28]->working_status; ?>
    </td>
    <td>
          <?php echo $equp_data[28]->damage_broken; ?>
    </td>
        <td> <?= @$equp_data[28]->not_working_reason; ?></td>
        <td>
            <?php echo $equp_data[28]->damage_reason; ?>
            
    </td>
    <td> <?php echo $equp_data[28]->other_remark; ?></td></tr>
<tr><td>15)</td><td>Syringe Pump</td  
    <td>
 <?php echo $equp_data[29]->availability; ?>
    </td>
    <td>
         <?php echo $equp_data[29]->working_status; ?>
    </td>
    <td>
          <?php echo $equp_data[29]->damage_broken; ?>
    </td>
        <td> <?= @$equp_data[29]->not_working_reason; ?></td>
        <td>
            <?php echo $equp_data[29]->damage_reason; ?>
            
    </td>
    <td> <?php echo $equp_data[29]->other_remark; ?></td></tr>
<tr><td>16)</td><td>Oxygen Delivery system</td>
     <td>
 <?php echo $equp_data[30]->availability; ?>
    </td>
    <td>
         <?php echo $equp_data[30]->working_status; ?>
    </td>
    <td>
          <?php echo $equp_data[30]->damage_broken; ?>
    </td>
        <td> <?= @$equp_data[30]->not_working_reason; ?></td>
        <td>
            <?php echo $equp_data[30]->damage_reason; ?>
            
    </td>
    <td> <?php echo $equp_data[30]->other_remark; ?></td>
</tr>
<tr><td>i</td><td>ODS display</td>
   <td>
 <?php echo $equp_data[31]->availability; ?>
    </td>
    <td>
         <?php echo $equp_data[31]->working_status; ?>
    </td>
    <td>
          <?php echo $equp_data[31]->damage_broken; ?>
    </td>
        <td> <?= @$equp_data[31]->not_working_reason; ?></td>
        <td>
            <?php echo $equp_data[31]->damage_reason; ?>
            
    </td>
    <td> <?php echo $equp_data[31]->other_remark; ?></td></tr>
<tr><td>ii</td><td>Perflowmeter</td>
    <td>
 <?php echo $equp_data[32]->availability; ?>
    </td>
    <td>
         <?php echo $equp_data[32]->working_status; ?>
    </td>
    <td>
          <?php echo $equp_data[32]->damage_broken; ?>
    </td>
        <td> <?= @$equp_data[32]->not_working_reason; ?></td>
        <td>
            <?php echo $equp_data[32]->damage_reason; ?>
            
    </td>
    <td> <?php echo $equp_data[32]->other_remark; ?></td></tr>
<tr><td>iii</td><td>O2 Regulator</td>
  <td>
 <?php echo $equp_data[33]->availability; ?>
    </td>
    <td>
         <?php echo $equp_data[33]->working_status; ?>
    </td>
    <td>
          <?php echo $equp_data[33]->damage_broken; ?>
    </td>
        <td> <?= @$equp_data[33]->not_working_reason; ?></td>
        <td>
            <?php echo $equp_data[33]->damage_reason; ?>
            
    </td>
    <td> <?php echo $equp_data[33]->other_remark; ?></td>
</tr>
<tr><td>17)</td><td>Oxygen Cylinder D Type (2 Nos)</td>
   <td>
 <?php echo $equp_data[34]->availability; ?>
    </td>
    <td>
         <?php echo $equp_data[34]->working_status; ?>
    </td>
    <td>
          <?php echo $equp_data[34]->damage_broken; ?>
    </td>
        <td> <?= @$equp_data[34]->not_working_reason; ?></td>
        <td>
            <?php echo $equp_data[34]->damage_reason; ?>
            
    </td>
    <td> <?php echo $equp_data[34]->other_remark; ?></td>
</tr>
<tr><td>18)</td><td>Oxygen Cylinder AA (Portable)Type</td>
   <td>
 <?php echo $equp_data[35]->availability; ?>
    </td>
    <td>
         <?php echo $equp_data[35]->working_status; ?>
    </td>
    <td>
          <?php echo $equp_data[35]->damage_broken; ?>
    </td>
        <td> <?= @$equp_data[35]->not_working_reason; ?></td>
        <td>
            <?php echo $equp_data[35]->damage_reason; ?>
            
    </td>
    <td> <?php echo $equp_data[35]->other_remark; ?></td></tr>
<tr><td>i</td><td>Portable O2 Regulator with Humdifer Bottle</td>
     <td>
 <?php echo $equp_data[36]->availability; ?>
    </td>
    <td>
         <?php echo $equp_data[36]->working_status; ?>
    </td>
    <td>
          <?php echo $equp_data[36]->damage_broken; ?>
    </td>
        <td> <?= @$equp_data[36]->not_working_reason; ?></td>
        <td>
            <?php echo $equp_data[36]->damage_reason; ?>
            
    </td>
    <td> <?php echo $equp_data[36]->other_remark; ?></td>
</tr>
<tr><td>ii</td><td>Oxygen Key</td>
 <td>
 <?php echo $equp_data[37]->availability; ?>
    </td>
    <td>
         <?php echo $equp_data[37]->working_status; ?>
    </td>
    <td>
          <?php echo $equp_data[37]->damage_broken; ?>
    </td>
        <td> <?= @$equp_data[37]->not_working_reason; ?></td>
        <td>
            <?php echo $equp_data[37]->damage_reason; ?>
            
    </td>
    <td> <?php echo $equp_data[37]->other_remark; ?></td></tr>
<tr><td>19)</td><td>Cervical collar</td> <td>
 <?php echo $equp_data[38]->availability; ?>
    </td>
    <td>
         <?php echo $equp_data[38]->working_status; ?>
    </td>
    <td>
          <?php echo $equp_data[38]->damage_broken; ?>
    </td>
        <td> <?= @$equp_data[38]->not_working_reason; ?></td>
        <td>
            <?php echo $equp_data[38]->damage_reason; ?>
            
    </td>
    <td> <?php echo $equp_data[38]->other_remark; ?></td></tr>
<tr><td>20)</td><td>Splints</td><td>
 <?php echo $equp_data[39]->availability; ?>
    </td>
    <td>
         <?php echo $equp_data[39]->working_status; ?>
    </td>
    <td>
          <?php echo $equp_data[39]->damage_broken; ?>
    </td>
        <td> <?= @$equp_data[39]->not_working_reason; ?></td>
        <td>
            <?php echo $equp_data[39]->damage_reason; ?>
            
    </td>
    <td> <?php echo $equp_data[39]->other_remark; ?></td></tr>
<tr><td>21)</td><td>Laryngoscope</td><td>
 <?php echo $equp_data[40]->availability; ?>
    </td>
    <td>
         <?php echo $equp_data[40]->working_status; ?>
    </td>
    <td>
          <?php echo $equp_data[40]->damage_broken; ?>
    </td>
        <td> <?= @$equp_data[40]->not_working_reason; ?></td>
        <td>
            <?php echo $equp_data[40]->damage_reason; ?>
            
    </td>
    <td> <?php echo $equp_data[40]->other_remark; ?></td><</tr>
<tr><td>i</td><td>Blade 1</td><td>
 <?php echo $equp_data[41]->availability; ?>
    </td>
    <td>
         <?php echo $equp_data[41]->working_status; ?>
    </td>
    <td>
          <?php echo $equp_data[41]->damage_broken; ?>
    </td>
        <td> <?= @$equp_data[41]->not_working_reason; ?></td>
        <td>
            <?php echo $equp_data[41]->damage_reason; ?>
            
    </td>
    <td> <?php echo $equp_data[41]->other_remark; ?></td><</tr>
<tr><td>ii</td><td>Blade 2</td><td>
 <?php echo $equp_data[42]->availability; ?>
    </td>
    <td>
         <?php echo $equp_data[42]->working_status; ?>
    </td>
    <td>
          <?php echo $equp_data[42]->damage_broken; ?>
    </td>
        <td> <?= @$equp_data[42]->not_working_reason; ?></td>
        <td>
            <?php echo $equp_data[42]->damage_reason; ?>
            
    </td>
    <td> <?php echo $equp_data[42]->other_remark; ?></td><</tr>
<tr><td>iii</td><td> <?php echo $equp_data[43]->item_name; ?></td>    
    <td>
         <?php echo $equp_data[43]->availability; ?>
    </td>
    <td>
         <?php echo $equp_data[43]->working_status; ?>
    </td>
    <td>
          <?php echo $equp_data[43]->damage_broken; ?>
    </td>
        <td> <?= @$equp_data[43]->not_working_reason; ?></td>
        <td>
            <?php echo $equp_data[43]->damage_reason; ?>
            
    </td>
    <td> <?php echo $equp_data[43]->other_remark; ?></td>
</tr>
<tr><td>Iv</td><td>  <?php echo $equp_data[44]->item_name; ?></td>
    <td>
         <?php echo $equp_data[44]->availability; ?>
    </td>
    <td>
         <?php echo $equp_data[44]->working_status; ?>
    </td>
    <td>
          <?php echo $equp_data[44]->damage_broken; ?>
    </td>
        <td> <?= @$equp_data[44]->not_working_reason; ?></td>
        <td>
            <?php echo $equp_data[44]->damage_reason; ?>
            
    </td>
    <td> <?php echo $equp_data[44]->other_remark; ?></td>
</tr>
                    </table>
                    
                </div>
                
            </div>
        </div>
    </div>