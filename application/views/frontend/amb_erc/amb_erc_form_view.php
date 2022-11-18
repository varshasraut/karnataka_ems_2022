<div class="call_purpose_form_outer">

<!--    <h3>Call TO ERC</h3>-->
     <!-- <h3>EMS Professional Call</h3> -->
     <label class="headerlbl">EMS Professional Call</label>
     <div id="totalnon_div">

<div id="nonleft_half">
    

    <form method="post" name="complnt_call_form" id="complnt_form">

        <input type="hidden" name="caller_id" id="caller_id" value="<?php echo $caller_id; ?>">

        <input type="hidden" name="call_id" id="call_id" value="<?php echo $call_id; ?>">

        <input type="hidden" name="base_month" value="<?php echo $cl_base_month; ?>">

        <input type="hidden" name="incient[caller_dis_timer]" id="caller_dis_timer" value="">

        <input type="hidden" name="incient[inc_recive_time]" value="<?php echo $attend_call_time; ?>">

        <input type="hidden" name="incient[inc_type]" id="inc_type" value="AMB_TO_ERC">


        <div class="width100 float_left">

            <div class=" width100 form_field ">

                <div class="label width_20 blue float_left">Department <span class="md_field">*</span></div>

                <div class=" float_left width75">

<!--                    <select name="dept_name" class="filter_required" data-errors="{filter_required:'Please select department from dropdown list'}">
                        <?php foreach ($users as $users_data): ?>
                            <option value="<?php echo $users_data->gcode; ?>" <?php echo @$selected_group[$users_data->gcode] ?> ><?php echo $users_data->ugname; ?></option>
                        <?php endforeach; ?>
                    </select>-->
                    
                    <select name="dept_name" class="filter_required" data-errors="{filter_required:'Please select department from dropdown list'}" tabindex="10" autocomplete="off">
                        <option value="UG-ShiftManager">Shift Manager</option>
                        <option value="UG-EROSupervisor">ERO Team Leader</option>
                        <option value="UG-DCOSupervisor">DCO Team Leader</option>
                        <!--<option value="UG-PDASupervisor">PDA Team Leader</option>
                        <option value="UG-FDASupervisor">FDA Team Leader</option>-->
                        <option value="UG-DCO">Dispatch Closure Officer</option>
                        <option value="UG-PDA">Police Desk</option>
                        <option value="UG-FDA">Fire Desk</option>
                        <option value="UG-ERCP">ERCP Desk</option>
                        <option value="UG-HELPDESK">Opeation Supoort Desk</option>
                        <option value="UG-EMT">EMT</option>
                        <option value="UG-PILOT">Pilot</option>
                        <option value="UG-ERCManager">ERC Manager</option>
                        <option value="UG-ERCHead">ERC Head</option>
                       <!-- <option value="UG-FleetManagement">Fleet Management</option>-->
                    </select>

<!--                    <input type="text" name="dept_name" value="" id="deptname" class="mi_autocomplete filter_required"  data-href="{base_url}module/permission"  placeholder="Department" data-errors="{filter_required:'Please select department from dropdown list'}">-->


                </div>

            </div> 

        </div>

        <div class="width100 enquiry_summary">
            <div class="width100 form_field float_left ">
                <div class="label blue float_left width_20">ERO Summary<span class="md_field">*</span>&nbsp;</div>
                <div class="width75 float_left">
                    <input type="text" name="incient[inc_ero_standard_summary]" data-value="<?= @$inc_details['inc_ero_standard_summary']; ?>" value="<?= @$inc_details['inc_ero_standard_summary_id']; ?>" class="mi_autocomplete filter_required width2"  data-href="{base_url}auto/get_ero_standard_summary?call_type=AMB_TO_ERC"  placeholder="ERO Summary" data-errors="{filter_required:'Please select ERO Summary from dropdown list'}" data-callback-funct="ero_standard_summary_change" TABINDEX="8" >
                </div>

            </div>
            </div>
            <div class="width100 enquiry_summary">
            <div class="width100 form_field float_left">
                <div class="label blue float_left width_20">ERO Note</div>

                <div class=" float_left width75" id="ero_summary_other">
                    <textarea style="height:60px;" name="incient[inc_ero_summary]" class="width_100 " TABINDEX="16" data-maxlen="1600"  data-errors="{filter_required:'ERO Summary should not be blank'}"><?= @$inc_details['inc_ero_summary']; ?></textarea>
                </div>
            </div>

        </div>
        <div class="width100 enquiry_summary beforeunload">
            <div class="button_field_row  text_align_center ">

                <div class="button_box enquiry_button" style="width: 200px; display: inline-block; height: 50px; margin: 0 auto; position: relative;">

                <input type="hidden" name="submit" value="sub_enq" />
                <input name="fwd_btn" value="FORWARD TO DESK" class="style4  form-xhttp-request" data-href="{base_url}ambercp/confirm_save"  data-qr="output_position=summary_div" type="button" tabindex="13" autocomplete="off">
  <!--             <input name="fwd_btn" value="Save" class="style5 form-xhttp-request" data-href="{base_url}ambercp/confirm_save" data-qr="forword=yes" type="button" tabindex="8">-->


            </div>

        </div>
            
        </div>

        

    </form>


</div>
<div id="nonright_half">
            <table id="script_table">
                <tr>
                    <td id="script_table_td">1. Standard Remarks Hindi</td>
                    <td>यदि ईआरसी में इ. एम. टी./पायलट कॉल करता है, तो ड्रॉप डाउन से कॉल को डेस्क पर स्थानांतरित करने के विकल्प का चयन करें और इ.आर.ओ नोट में आईडी लिखें।</td>

                </tr>
                <tr>
                    <td id="script_table_td">2. Standard Remarks Hindi</td>
                    <td>किसी इ. एम. टी. या आईआरटीएस अधिकारी द्वारा 108 संजीवनी पर कॉल करने की स्थिति में, कॉल को संबंधित विभाग/डेस्क को स्थानांतरित कर दिया जाना चाहिए और उनका नाम और पदनाम इ.आर.ओ नोट में लिखा जाना चाहिए।</td>

                </tr>
                <!-- <tr>
                    <td id="script_table_td">1. Standard Remarks Hindi</td>
                    <td>कॉलर ने मोबाइल एप्लिकेशन सपोर्ट के लिए कॉल किया है| </td>

                </tr>
                <tr>
                    <td id="script_table_td">2. Standard Remarks Hindi</td>
                    <td>कॉलर ने वेब एप्लिकेशन सपोर्ट के लिए कॉल किया है|</td>

                </tr> -->
                
                <!--<tr>
                    <td id="script_table_td">Call Type Wise Handling Script in Marathi</td>
                    <td>मला आपला ऍम्ब्युलन्स नंबर कळू शकेल का? माहिती साठी धन्यवाद. मी आपला कॉल (--ज्या डेस्क ला कॉल ट्रान्सफर करायचा आहे--) डेस्क ला ट्रान्सफर करत आहे काही सेकंद प्रतीक्षा करू शकता का?
                    </td>
                </tr>-->
                <tr>
                    <td id="script_table_td">Call Type Wise Handling Script In Hindi</td>
                    <td>क्या मैं आपका एम्बुलेंस नंबर जान सकता हूँ? जानकारी के लिए धन्यवाद। मैं आपकी कॉल को स्थानांतरित कर रहा हूं (जिस डेस्क पर कॉल स्थानांतरित की जानी है--) क्या आप कुछ सेकंड प्रतीक्षा कर सकते हैं?
                    </td>
                </tr>


            </table>
        </div>
</div>
</div>