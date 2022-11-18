<ul class="dtl_block">
                    <li><h3 class="txt_clr2 width1 txt_pro">Previous Calls</h3></li>



                    
                        <li><a class=" expand_button expand_btn ptn_view" data-target="cl4"><span>CALL 1 : </span></a></li>


                        <div id="cl4" style="width: 100%; position: relative; padding-left: 20px; display: none;" class="expand_pan">

                            <div class="">
                                <div class="dtl_block">    <!--<ul class="dtl_block">-->

                                    <div class="field_row width100">

                                        <div class="width2 float_left">
                                            <div class="filed_lable float_left width33"><label for="station_name">Reply from<span class="md_field">*</span></label></div>

                                            <div class="filed_input float_left width50">


                                                <select name="gri[gc_reply_from]" tabindex="32" id="standard_remark" class="filter_required" data-errors="{filter_required:'Standard Remark should not be blank!'}" autocomplete="off"> 
                                                    <option value="">Select Reply from</option>
                                                    <option value="ADM" selected="">ADM </option>
                                                    <option value="ZM">ZM </option>
                                                    <option value="DM">DM </option>
                                                    <option value="Supervisor">Supervisor </option>

                                                </select>


                                            </div>


                                        </div>
                                        <div class="width2 float_left">
                                            <div class="field_lable float_left width33"> <label for="date_time">Employee Name<span class="md_field">*</span></label></div>
                                            <div class="filed_input float_left width50">


                                                <input type="text" name="gri[gc_emp_close_by]" class="filter_required" placholder="Complaint Register No" data-errors="{filter_required:'Station name should not be blank'}" value="t" tabindex="33" autocomplete="off">

                                            </div>

                                        </div>



                                    </div>
                                    <div class="field_row width100">

                                        <div class="width2 float_left">
                                            <div class="field_lable float_left width33"> <label for="date_time">Closure status<span class="md_field">*</span></label></div>
                                            <div class="filed_input float_left width50">
                                                <select name="gri[gc_closure_status]" tabindex="34" id="standard_remark" class="filter_required" data-errors="{filter_required:'Standard Remark should not be blank!'}" autocomplete="off"> 
                                                    <option value="">Select Standard Remark</option>

                                                    <option value="complaint_close">Complaint Close</option> 
                                                    <option value="complaint_pending" selected="">Complaint Pending</option> 

                                                </select>
                                            </div>
                                        </div>
                                        <div class="width2 float_left">
                                            <div class="field_lable float_left width33"> <label for="date_time">Grievance Remark<span class="md_field">*</span></label></div>
                                            <div class="filed_input float_left width50">
                                                <select name="gri[gc_standard_remark]" tabindex="35" id="standard_remark" class="filter_required" data-errors="{filter_required:'Standard Remark should not be blank!'}" autocomplete="off"> 
                                                    <option value="">Select Grievance Remark</option>
                                                    <option value="complaint_close_sucessfully">Complaint Close Sucessfully </option>
                                                       <option value="complaint_pending_sucessfully" selected="">Complaint Pending Sucessfully </option>
                                                </select>
                                            </div>
                                        </div>



                                    </div>


                                    <div class="field_row width100">


                                        <div class="width2 float_left">
                                            <div class="field_lable float_left width33"> <label for="mobile_no">Remainder mail<span class="md_field">*</span></label></div>

                                            <div class="filed_input width50 float_left">
                                           <!--                    <label for="gender">Gender<span class="md_field">*</span></label>-->
                                                
                                                <div class="radio_button_div1">
                                                    <label for="fire_y" class="radio_check float_left width50">  
                                                        <input data-base="" id="fire_y" type="radio" name="gri[gc_reminder_mail]" value="yes" class="radio_check_input filter_required" data-errors="{filter_required:'>Report To HO not be blank'}" checked="" tabindex="36" autocomplete="off"><span class="radio_check_holder"></span>Yes
                                                    </label>

                                                    <label for="fire_n" class="radio_check float_left width50">  
                                                        <input data-base="" id="fire_n" type="radio" name="gri[gc_reminder_mail]" value="no" class="radio_check_input" data-errors="{filter_required:'>Report To HO not be blank'}" tabindex="37" autocomplete="off"><span class="radio_check_holder filter_required"></span>No
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="width2 float_left">
                                            <div class="field_lable float_left width33"> <label for="mobile_no">Remainder call<span class="md_field">*</span></label></div>

                                            <div class="filed_input width2 float_left">
                                           <!--                    <label for="gender">Gender<span class="md_field">*</span></label>-->
                                                
                                                <div class="radio_button_div1">
                                                    <label for="fire_y1" class="radio_check float_left width50">  
                                                        <input data-base="" id="fire_y1" type="radio" name="gri[gc_reminder_call]" value="yes" class="radio_check_input filter_required" data-errors="{filter_required:'>Report To HO not be blank'}" checked="" tabindex="38" autocomplete="off"><span class="radio_check_holder"></span>Yes
                                                    </label>

                                                    <label for="fire_n1" class="radio_check float_left width50">  
                                                        <input data-base="" id="fire_n1" type="radio" name="gri[gc_reminder_call]" value="no" class="radio_check_input" data-errors="{filter_required:'>Report To HO not be blank'}" tabindex="39" autocomplete="off"><span class="radio_check_holder filter_required"></span>No
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="field_row width100">

                                        <div class="width2 float_left">
                                            <div class="filed_lable float_left width33"><label for="station_name">Action Taken<span class="md_field">*</span></label></div>

                                            <div class="filed_input float_left width2">

                                                <textarea style="height:60px;" name="gri[gc_action_taken]" class="filter_required" tabindex="40" data-maxlen="1600" data-errors="{filter_required:'Action should not be blank'}" autocomplete="off">  t  </textarea>

                                            </div>
                                        </div>
                                        <div class="width2 float_left">

                                            <div class="field_lable float_left width33"> <label for="mt_on_remark">Caller satisfaction for closure remark<span class="md_field">*</span></label></div>


                                            <div class="filed_input float_left width50">
                                                <textarea style="height:60px;" name="gri[gc_caller_closure_remark]" class="filter_required" tabindex="41" data-maxlen="1600" data-errors="{filter_required:'Caller satisfaction for closure remark should not be blank'}" autocomplete="off">t</textarea>

                                            </div>


                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                    
                        <li><a class=" expand_button expand_btn ptn_view" data-target="cl5"><span>CALL 2 : </span></a></li>


                        <div id="cl5" style="width: 100%; position: relative; padding-left: 20px;" class="expand_pan">

                            <div class="">
                                <div class="dtl_block">    <!--<ul class="dtl_block">-->

                                    <div class="field_row width100">

                                        <div class="width2 float_left">
                                            <div class="filed_lable float_left width33"><label for="station_name">Reply from<span class="md_field">*</span></label></div>

                                            <div class="filed_input float_left width50">


                                                <select name="gri[gc_reply_from]" tabindex="42" id="standard_remark" class="filter_required" data-errors="{filter_required:'Standard Remark should not be blank!'}" autocomplete="off"> 
                                                    <option value="">Select Reply from</option>
                                                    <option value="ADM" selected="">ADM </option>
                                                    <option value="ZM">ZM </option>
                                                    <option value="DM">DM </option>
                                                    <option value="Supervisor">Supervisor </option>

                                                </select>


                                            </div>


                                        </div>
                                        <div class="width2 float_left">
                                            <div class="field_lable float_left width33"> <label for="date_time">Employee Name<span class="md_field">*</span></label></div>
                                            <div class="filed_input float_left width50">


                                                <input type="text" name="gri[gc_emp_close_by]" class="filter_required" placholder="Complaint Register No" data-errors="{filter_required:'Station name should not be blank'}" value="t" tabindex="43" autocomplete="off">

                                            </div>

                                        </div>



                                    </div>
                                    <div class="field_row width100">

                                        <div class="width2 float_left">
                                            <div class="field_lable float_left width33"> <label for="date_time">Closure status<span class="md_field">*</span></label></div>
                                            <div class="filed_input float_left width50">
                                                <select name="gri[gc_closure_status]" tabindex="44" id="standard_remark" class="filter_required" data-errors="{filter_required:'Standard Remark should not be blank!'}" autocomplete="off"> 
                                                    <option value="">Select Standard Remark</option>

                                                    <option value="complaint_close">Complaint Close</option> 
                                                    <option value="complaint_pending" selected="">Complaint Pending</option> 

                                                </select>
                                            </div>
                                        </div>
                                        <div class="width2 float_left">
                                            <div class="field_lable float_left width33"> <label for="date_time">Grievance Remark<span class="md_field">*</span></label></div>
                                            <div class="filed_input float_left width50">
                                                <select name="gri[gc_standard_remark]" tabindex="45" id="standard_remark" class="filter_required" data-errors="{filter_required:'Standard Remark should not be blank!'}" autocomplete="off"> 
                                                    <option value="">Select Grievance Remark</option>
                                                    <option value="complaint_close_sucessfully">Complaint Close Sucessfully </option>
                                                       <option value="complaint_pending_sucessfully" selected="">Complaint Pending Sucessfully </option>
                                                </select>
                                            </div>
                                        </div>



                                    </div>


                                    <div class="field_row width100">


                                        <div class="width2 float_left">
                                            <div class="field_lable float_left width33"> <label for="mobile_no">Remainder mail<span class="md_field">*</span></label></div>

                                            <div class="filed_input width50 float_left">
                                           <!--                    <label for="gender">Gender<span class="md_field">*</span></label>-->
                                                
                                                <div class="radio_button_div1">
                                                    <label for="fire_y" class="radio_check float_left width50">  
                                                        <input data-base="" id="fire_y" type="radio" name="gri[gc_reminder_mail]" value="yes" class="radio_check_input filter_required" data-errors="{filter_required:'>Report To HO not be blank'}" checked="" tabindex="46" autocomplete="off"><span class="radio_check_holder"></span>Yes
                                                    </label>

                                                    <label for="fire_n" class="radio_check float_left width50">  
                                                        <input data-base="" id="fire_n" type="radio" name="gri[gc_reminder_mail]" value="no" class="radio_check_input" data-errors="{filter_required:'>Report To HO not be blank'}" tabindex="47" autocomplete="off"><span class="radio_check_holder filter_required"></span>No
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="width2 float_left">
                                            <div class="field_lable float_left width33"> <label for="mobile_no">Remainder call<span class="md_field">*</span></label></div>

                                            <div class="filed_input width2 float_left">
                                           <!--                    <label for="gender">Gender<span class="md_field">*</span></label>-->
                                                
                                                <div class="radio_button_div1">
                                                    <label for="fire_y1" class="radio_check float_left width50">  
                                                        <input data-base="" id="fire_y1" type="radio" name="gri[gc_reminder_call]" value="yes" class="radio_check_input filter_required" data-errors="{filter_required:'>Report To HO not be blank'}" checked="" tabindex="48" autocomplete="off"><span class="radio_check_holder"></span>Yes
                                                    </label>

                                                    <label for="fire_n1" class="radio_check float_left width50">  
                                                        <input data-base="" id="fire_n1" type="radio" name="gri[gc_reminder_call]" value="no" class="radio_check_input" data-errors="{filter_required:'>Report To HO not be blank'}" tabindex="49" autocomplete="off"><span class="radio_check_holder filter_required"></span>No
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="field_row width100">

                                        <div class="width2 float_left">
                                            <div class="filed_lable float_left width33"><label for="station_name">Action Taken<span class="md_field">*</span></label></div>

                                            <div class="filed_input float_left width2">

                                                <textarea style="height:60px;" name="gri[gc_action_taken]" class="filter_required" tabindex="50" data-maxlen="1600" data-errors="{filter_required:'Action should not be blank'}" autocomplete="off">  t    </textarea>

                                            </div>
                                        </div>
                                        <div class="width2 float_left">

                                            <div class="field_lable float_left width33"> <label for="mt_on_remark">Caller satisfaction for closure remark<span class="md_field">*</span></label></div>


                                            <div class="filed_input float_left width50">
                                                <textarea style="height:60px;" name="gri[gc_caller_closure_remark]" class="filter_required" tabindex="51" data-maxlen="1600" data-errors="{filter_required:'Caller satisfaction for closure remark should not be blank'}" autocomplete="off">t</textarea>

                                            </div>


                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                    
                        <li><a class=" expand_button expand_btn ptn_view" data-target="cl6"><span>CALL 3 : </span></a></li>


                        <div id="cl6" style="width:100%; position: relative; display:none;padding-left:20px;" class="expand_pan">

                            <div class="">
                                <div class="dtl_block">    <!--<ul class="dtl_block">-->

                                    <div class="field_row width100">

                                        <div class="width2 float_left">
                                            <div class="filed_lable float_left width33"><label for="station_name">Reply from<span class="md_field">*</span></label></div>

                                            <div class="filed_input float_left width50">


                                                <select name="gri[gc_reply_from]" tabindex="52" id="standard_remark" class="filter_required" data-errors="{filter_required:'Standard Remark should not be blank!'}" autocomplete="off"> 
                                                    <option value="">Select Reply from</option>
                                                    <option value="ADM" selected="">ADM </option>
                                                    <option value="ZM">ZM </option>
                                                    <option value="DM">DM </option>
                                                    <option value="Supervisor">Supervisor </option>

                                                </select>


                                            </div>


                                        </div>
                                        <div class="width2 float_left">
                                            <div class="field_lable float_left width33"> <label for="date_time">Employee Name<span class="md_field">*</span></label></div>
                                            <div class="filed_input float_left width50">


                                                <input type="text" name="gri[gc_emp_close_by]" class="filter_required" placholder="Complaint Register No" data-errors="{filter_required:'Station name should not be blank'}" value="t" tabindex="53" autocomplete="off">

                                            </div>

                                        </div>



                                    </div>
                                    <div class="field_row width100">

                                        <div class="width2 float_left">
                                            <div class="field_lable float_left width33"> <label for="date_time">Closure status<span class="md_field">*</span></label></div>
                                            <div class="filed_input float_left width50">
                                                <select name="gri[gc_closure_status]" tabindex="54" id="standard_remark" class="filter_required" data-errors="{filter_required:'Standard Remark should not be blank!'}" autocomplete="off"> 
                                                    <option value="">Select Standard Remark</option>

                                                    <option value="complaint_close">Complaint Close</option> 
                                                    <option value="complaint_pending" selected="">Complaint Pending</option> 

                                                </select>
                                            </div>
                                        </div>
                                        <div class="width2 float_left">
                                            <div class="field_lable float_left width33"> <label for="date_time">Grievance Remark<span class="md_field">*</span></label></div>
                                            <div class="filed_input float_left width50">
                                                <select name="gri[gc_standard_remark]" tabindex="55" id="standard_remark" class="filter_required" data-errors="{filter_required:'Standard Remark should not be blank!'}" autocomplete="off"> 
                                                    <option value="">Select Grievance Remark</option>
                                                    <option value="complaint_close_sucessfully">Complaint Close Sucessfully </option>
                                                       <option value="complaint_pending_sucessfully" selected="">Complaint Pending Sucessfully </option>
                                                </select>
                                            </div>
                                        </div>



                                    </div>


                                    <div class="field_row width100">


                                        <div class="width2 float_left">
                                            <div class="field_lable float_left width33"> <label for="mobile_no">Remainder mail<span class="md_field">*</span></label></div>

                                            <div class="filed_input width50 float_left">
                                           <!--                    <label for="gender">Gender<span class="md_field">*</span></label>-->
                                                
                                                <div class="radio_button_div1">
                                                    <label for="fire_y" class="radio_check float_left width50">  
                                                        <input data-base="" id="fire_y" type="radio" name="gri[gc_reminder_mail]" value="yes" class="radio_check_input filter_required" data-errors="{filter_required:'>Report To HO not be blank'}" checked="" tabindex="56" autocomplete="off"><span class="radio_check_holder"></span>Yes
                                                    </label>

                                                    <label for="fire_n" class="radio_check float_left width50">  
                                                        <input data-base="" id="fire_n" type="radio" name="gri[gc_reminder_mail]" value="no" class="radio_check_input" data-errors="{filter_required:'>Report To HO not be blank'}" tabindex="57" autocomplete="off"><span class="radio_check_holder filter_required"></span>No
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="width2 float_left">
                                            <div class="field_lable float_left width33"> <label for="mobile_no">Remainder call<span class="md_field">*</span></label></div>

                                            <div class="filed_input width2 float_left">
                                           <!--                    <label for="gender">Gender<span class="md_field">*</span></label>-->
                                                
                                                <div class="radio_button_div1">
                                                    <label for="fire_y1" class="radio_check float_left width50">  
                                                        <input data-base="" id="fire_y1" type="radio" name="gri[gc_reminder_call]" value="yes" class="radio_check_input filter_required" data-errors="{filter_required:'>Report To HO not be blank'}" checked="" tabindex="58" autocomplete="off"><span class="radio_check_holder"></span>Yes
                                                    </label>

                                                    <label for="fire_n1" class="radio_check float_left width50">  
                                                        <input data-base="" id="fire_n1" type="radio" name="gri[gc_reminder_call]" value="no" class="radio_check_input" data-errors="{filter_required:'>Report To HO not be blank'}" tabindex="59" autocomplete="off"><span class="radio_check_holder filter_required"></span>No
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="field_row width100">

                                        <div class="width2 float_left">
                                            <div class="filed_lable float_left width33"><label for="station_name">Action Taken<span class="md_field">*</span></label></div>

                                            <div class="filed_input float_left width2">

                                                <textarea style="height:60px;" name="gri[gc_action_taken]" class="filter_required" tabindex="60" data-maxlen="1600" data-errors="{filter_required:'Action should not be blank'}" autocomplete="off">  t  tttttttttt  </textarea>

                                            </div>
                                        </div>
                                        <div class="width2 float_left">

                                            <div class="field_lable float_left width33"> <label for="mt_on_remark">Caller satisfaction for closure remark<span class="md_field">*</span></label></div>


                                            <div class="filed_input float_left width50">
                                                <textarea style="height:60px;" name="gri[gc_caller_closure_remark]" class="filter_required" tabindex="61" data-maxlen="1600" data-errors="{filter_required:'Caller satisfaction for closure remark should not be blank'}" autocomplete="off">tttt</textarea>

                                            </div>


                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                    
                        <li><a class=" expand_button expand_btn ptn_view" data-target="cl7"><span>CALL 4 : </span></a></li>


                        <div id="cl7" style="width:100%; position: relative; display:none;padding-left:20px;" class="expand_pan">

                            <div class="">
                                <div class="dtl_block">    <!--<ul class="dtl_block">-->

                                    <div class="field_row width100">

                                        <div class="width2 float_left">
                                            <div class="filed_lable float_left width33"><label for="station_name">Reply from<span class="md_field">*</span></label></div>

                                            <div class="filed_input float_left width50">


                                                <select name="gri[gc_reply_from]" tabindex="62" id="standard_remark" class="filter_required" data-errors="{filter_required:'Standard Remark should not be blank!'}" autocomplete="off"> 
                                                    <option value="">Select Reply from</option>
                                                    <option value="ADM" selected="">ADM </option>
                                                    <option value="ZM">ZM </option>
                                                    <option value="DM">DM </option>
                                                    <option value="Supervisor">Supervisor </option>

                                                </select>


                                            </div>


                                        </div>
                                        <div class="width2 float_left">
                                            <div class="field_lable float_left width33"> <label for="date_time">Employee Name<span class="md_field">*</span></label></div>
                                            <div class="filed_input float_left width50">


                                                <input type="text" name="gri[gc_emp_close_by]" class="filter_required" placholder="Complaint Register No" data-errors="{filter_required:'Station name should not be blank'}" value="t" tabindex="63" autocomplete="off">

                                            </div>

                                        </div>



                                    </div>
                                    <div class="field_row width100">

                                        <div class="width2 float_left">
                                            <div class="field_lable float_left width33"> <label for="date_time">Closure status<span class="md_field">*</span></label></div>
                                            <div class="filed_input float_left width50">
                                                <select name="gri[gc_closure_status]" tabindex="64" id="standard_remark" class="filter_required" data-errors="{filter_required:'Standard Remark should not be blank!'}" autocomplete="off"> 
                                                    <option value="">Select Standard Remark</option>

                                                    <option value="complaint_close" selected="">Complaint Close</option> 
                                                    <option value="complaint_pending">Complaint Pending</option> 

                                                </select>
                                            </div>
                                        </div>
                                        <div class="width2 float_left">
                                            <div class="field_lable float_left width33"> <label for="date_time">Grievance Remark<span class="md_field">*</span></label></div>
                                            <div class="filed_input float_left width50">
                                                <select name="gri[gc_standard_remark]" tabindex="65" id="standard_remark" class="filter_required" data-errors="{filter_required:'Standard Remark should not be blank!'}" autocomplete="off"> 
                                                    <option value="">Select Grievance Remark</option>
                                                    <option value="complaint_close_sucessfully" selected="">Complaint Close Sucessfully </option>
                                                       <option value="complaint_pending_sucessfully">Complaint Pending Sucessfully </option>
                                                </select>
                                            </div>
                                        </div>



                                    </div>


                                    <div class="field_row width100">


                                        <div class="width2 float_left">
                                            <div class="field_lable float_left width33"> <label for="mobile_no">Remainder mail<span class="md_field">*</span></label></div>

                                            <div class="filed_input width50 float_left">
                                           <!--                    <label for="gender">Gender<span class="md_field">*</span></label>-->
                                                
                                                <div class="radio_button_div1">
                                                    <label for="fire_y" class="radio_check float_left width50">  
                                                        <input data-base="" id="fire_y" type="radio" name="gri[gc_reminder_mail]" value="yes" class="radio_check_input filter_required" data-errors="{filter_required:'>Report To HO not be blank'}" checked="" tabindex="66" autocomplete="off"><span class="radio_check_holder"></span>Yes
                                                    </label>

                                                    <label for="fire_n" class="radio_check float_left width50">  
                                                        <input data-base="" id="fire_n" type="radio" name="gri[gc_reminder_mail]" value="no" class="radio_check_input" data-errors="{filter_required:'>Report To HO not be blank'}" tabindex="67" autocomplete="off"><span class="radio_check_holder filter_required"></span>No
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="width2 float_left">
                                            <div class="field_lable float_left width33"> <label for="mobile_no">Remainder call<span class="md_field">*</span></label></div>

                                            <div class="filed_input width2 float_left">
                                           <!--                    <label for="gender">Gender<span class="md_field">*</span></label>-->
                                                
                                                <div class="radio_button_div1">
                                                    <label for="fire_y1" class="radio_check float_left width50">  
                                                        <input data-base="" id="fire_y1" type="radio" name="gri[gc_reminder_call]" value="yes" class="radio_check_input filter_required" data-errors="{filter_required:'>Report To HO not be blank'}" checked="" tabindex="68" autocomplete="off"><span class="radio_check_holder"></span>Yes
                                                    </label>

                                                    <label for="fire_n1" class="radio_check float_left width50">  
                                                        <input data-base="" id="fire_n1" type="radio" name="gri[gc_reminder_call]" value="no" class="radio_check_input" data-errors="{filter_required:'>Report To HO not be blank'}" tabindex="69" autocomplete="off"><span class="radio_check_holder filter_required"></span>No
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="field_row width100">

                                        <div class="width2 float_left">
                                            <div class="filed_lable float_left width33"><label for="station_name">Action Taken<span class="md_field">*</span></label></div>

                                            <div class="filed_input float_left width2">

                                                <textarea style="height:60px;" name="gri[gc_action_taken]" class="filter_required" tabindex="70" data-maxlen="1600" data-errors="{filter_required:'Action should not be blank'}" autocomplete="off">  t    </textarea>

                                            </div>
                                        </div>
                                        <div class="width2 float_left">

                                            <div class="field_lable float_left width33"> <label for="mt_on_remark">Caller satisfaction for closure remark<span class="md_field">*</span></label></div>


                                            <div class="filed_input float_left width50">
                                                <textarea style="height:60px;" name="gri[gc_caller_closure_remark]" class="filter_required" tabindex="71" data-maxlen="1600" data-errors="{filter_required:'Caller satisfaction for closure remark should not be blank'}" autocomplete="off">t</textarea>

                                            </div>


                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                    
                        <li><a class=" expand_button expand_btn ptn_view" data-target="cl8"><span>CALL 5 : </span></a></li>


                        <div id="cl8" style="width:100%; position: relative; display:none;padding-left:20px;" class="expand_pan">

                            <div class="">
                                <div class="dtl_block">    <!--<ul class="dtl_block">-->

                                    <div class="field_row width100">

                                        <div class="width2 float_left">
                                            <div class="filed_lable float_left width33"><label for="station_name">Reply from<span class="md_field">*</span></label></div>

                                            <div class="filed_input float_left width50">


                                                <select name="gri[gc_reply_from]" tabindex="72" id="standard_remark" class="filter_required" data-errors="{filter_required:'Standard Remark should not be blank!'}" autocomplete="off"> 
                                                    <option value="">Select Reply from</option>
                                                    <option value="ADM" selected="">ADM </option>
                                                    <option value="ZM">ZM </option>
                                                    <option value="DM">DM </option>
                                                    <option value="Supervisor">Supervisor </option>

                                                </select>


                                            </div>


                                        </div>
                                        <div class="width2 float_left">
                                            <div class="field_lable float_left width33"> <label for="date_time">Employee Name<span class="md_field">*</span></label></div>
                                            <div class="filed_input float_left width50">


                                                <input type="text" name="gri[gc_emp_close_by]" class="filter_required" placholder="Complaint Register No" data-errors="{filter_required:'Station name should not be blank'}" value="t" tabindex="73" autocomplete="off">

                                            </div>

                                        </div>



                                    </div>
                                    <div class="field_row width100">

                                        <div class="width2 float_left">
                                            <div class="field_lable float_left width33"> <label for="date_time">Closure status<span class="md_field">*</span></label></div>
                                            <div class="filed_input float_left width50">
                                                <select name="gri[gc_closure_status]" tabindex="74" id="standard_remark" class="filter_required" data-errors="{filter_required:'Standard Remark should not be blank!'}" autocomplete="off"> 
                                                    <option value="">Select Standard Remark</option>

                                                    <option value="complaint_close">Complaint Close</option> 
                                                    <option value="complaint_pending" selected="">Complaint Pending</option> 

                                                </select>
                                            </div>
                                        </div>
                                        <div class="width2 float_left">
                                            <div class="field_lable float_left width33"> <label for="date_time">Grievance Remark<span class="md_field">*</span></label></div>
                                            <div class="filed_input float_left width50">
                                                <select name="gri[gc_standard_remark]" tabindex="75" id="standard_remark" class="filter_required" data-errors="{filter_required:'Standard Remark should not be blank!'}" autocomplete="off"> 
                                                    <option value="">Select Grievance Remark</option>
                                                    <option value="complaint_close_sucessfully">Complaint Close Sucessfully </option>
                                                       <option value="complaint_pending_sucessfully" selected="">Complaint Pending Sucessfully </option>
                                                </select>
                                            </div>
                                        </div>



                                    </div>


                                    <div class="field_row width100">


                                        <div class="width2 float_left">
                                            <div class="field_lable float_left width33"> <label for="mobile_no">Remainder mail<span class="md_field">*</span></label></div>

                                            <div class="filed_input width50 float_left">
                                           <!--                    <label for="gender">Gender<span class="md_field">*</span></label>-->
                                                
                                                <div class="radio_button_div1">
                                                    <label for="fire_y" class="radio_check float_left width50">  
                                                        <input data-base="" id="fire_y" type="radio" name="gri[gc_reminder_mail]" value="yes" class="radio_check_input filter_required" data-errors="{filter_required:'>Report To HO not be blank'}" checked="" tabindex="76" autocomplete="off"><span class="radio_check_holder"></span>Yes
                                                    </label>

                                                    <label for="fire_n" class="radio_check float_left width50">  
                                                        <input data-base="" id="fire_n" type="radio" name="gri[gc_reminder_mail]" value="no" class="radio_check_input" data-errors="{filter_required:'>Report To HO not be blank'}" tabindex="77" autocomplete="off"><span class="radio_check_holder filter_required"></span>No
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="width2 float_left">
                                            <div class="field_lable float_left width33"> <label for="mobile_no">Remainder call<span class="md_field">*</span></label></div>

                                            <div class="filed_input width2 float_left">
                                           <!--                    <label for="gender">Gender<span class="md_field">*</span></label>-->
                                                
                                                <div class="radio_button_div1">
                                                    <label for="fire_y1" class="radio_check float_left width50">  
                                                        <input data-base="" id="fire_y1" type="radio" name="gri[gc_reminder_call]" value="yes" class="radio_check_input filter_required" data-errors="{filter_required:'>Report To HO not be blank'}" checked="" tabindex="78" autocomplete="off"><span class="radio_check_holder"></span>Yes
                                                    </label>

                                                    <label for="fire_n1" class="radio_check float_left width50">  
                                                        <input data-base="" id="fire_n1" type="radio" name="gri[gc_reminder_call]" value="no" class="radio_check_input" data-errors="{filter_required:'>Report To HO not be blank'}" tabindex="79" autocomplete="off"><span class="radio_check_holder filter_required"></span>No
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="field_row width100">

                                        <div class="width2 float_left">
                                            <div class="filed_lable float_left width33"><label for="station_name">Action Taken<span class="md_field">*</span></label></div>

                                            <div class="filed_input float_left width2">

                                                <textarea style="height:60px;" name="gri[gc_action_taken]" class="filter_required" tabindex="80" data-maxlen="1600" data-errors="{filter_required:'Action should not be blank'}" autocomplete="off"></textarea>

                                            </div>
                                        </div>
                                        <div class="width2 float_left">

                                            <div class="field_lable float_left width33"> <label for="mt_on_remark">Caller satisfaction for closure remark<span class="md_field">*</span></label></div>


                                            <div class="filed_input float_left width50">
                                                <textarea style="height:60px;" name="gri[gc_caller_closure_remark]" class="filter_required" tabindex="81" data-maxlen="1600" data-errors="{filter_required:'Caller satisfaction for closure remark should not be blank'}" autocomplete="off"></textarea>

                                            </div>


                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                                    </ul>