
<div class="call_purpose_form_outer">
<label class="headerlbl">Additional Resources</label>
    <!-- <h3>Additional Resources</h3> -->
    
            
    <form method="post" name="add_resource_form" id="add_res_view">
            
        <input type="hidden" name="call_id" id="call_id" value="<?php echo $call_id;?>">
         <input type="hidden" name="incient[CallUniqueID]" value="<?php echo $CallUniqueID;?>">
            
        <input type="hidden" name="base_month"  value="<?php echo $cl_base_month ;?>" data-base="search_btn">
        <div id="patient_hidden_div">
            <input type="hidden" name="patient[full_name]" value="<?php echo $common_data_form['full_name'];?>">
            <input type="hidden" name="patient[first_name]" value="<?php echo $common_data_form['first_name'];?>">
            <input type="hidden" name="patient[middle_name]" value="<?php echo $common_data_form['middle_name'];?>">
            <input type="hidden" name="patient[last_name]" value="<?php echo $common_data_form['last_name'];?>">
            <input type="hidden" name="patient[dob]" value="<?php echo $common_data_form['dob'];?>">
            <input type="hidden" name="patient[age]" value="<?php echo $common_data_form['age'];?>">  
            <input type="hidden" name="patient[gender]" value="<?php echo $common_data_form['gender'];?>">
        </div>
                        
<!--        <div class="inline_fields outer_id">
            
            <div class="add_res_outer">

              
                    
                <div class="outer_inp_search width100">
                    <div class="form_field width17">
                        <div class="label">Incident Id<span class="md_field">*</span></div>
                        <div class="input float_left ">

                            <input name="inc_id" tabindex="1" class="form_input filter_required" placeholder="Enter Incident Id" type="text" data-base="search_btn" data-errors="{filter_required:'Id should not be blank!'}" TABINDEX="">


                        </div>
                    </div>

                    <div class="search_btn_inp">

                        <input name="search_btn" value="SEARCH" class="style3 base-xhttp-request" data-href="{base_url}resource/petinfo" data-qr="output_position=adv_pt_info" type="button">



                    </div> 
                    
                 </div>
                    
            </div>
                
        </div>-->
        <div class="inline_fields width100" id="inc_filters">

            <div class="form_field width17">

                <div class="label">Incident Id</div>

                <input value="<?php echo date('Ymd'); ?>" name="inc_id" tabindex="7" id="cinc_id" class="form_input inc_id_filt filter_either_or[ad_mobile_number,amb_reg_no,cinc_id]" placeholder="Incident Id" type="text" data-base="search_btn" data-errors="{filter_required:'Please select state from dropdown list',filter_either_or:'one field is required'}">

            </div>

            <div class="form_field width17">

                <div class="label">Mobile Number</div>

                <div class="input"> 

                    <input name="clr_mobile"  onkeyup="this.value=this.value.replace(/[^\d]/,'')" id="ad_mobile_number" tabindex="8" class="form_input filter_either_or[ad_mobile_number,amb_reg_no,cinc_id]" data-errors="{filter_number:'Mobile number should be in numeric characters only.', filter_minlength:'Mobile number should be at least 10 digits long',filter_maxlength:'Mobile number should less then 11 digits.',filter_either_or:'one field is required'}" placeholder="Mobile Number" type="text" data-base="search_btn">
                </div>

            </div>

            <div class="form_field width17">

                <div class="label">Ambulance Reg no</div>
                 <input name="amb_reg_no" id="amb_reg_no" class="mi_autocomplete dropdown_per_page width97 filter_either_or[ad_mobile_number,amb_reg_no,cinc_id]" data-href="{base_url}auto/get_ambulance" placeholder="Select Ambulance" data-errors="{filter_required:'Please select state from dropdown list',filter_either_or:'one field is required'}" tabindex="15" autocomplete="off" value="<?php echo $amb_reg_id; ?>" data-value="<?php echo $amb_reg_id; ?>" data-base="search_btn">



            </div>


            <div class="form_field width_30">

                <div class="label">&nbsp;</div>
                <input name="reset_filter"  tabindex="12" value="Reset Filter" class=" click-xhttp-request float_right mt-0" data-href="{base_url}patients/pt_adv_inc_list" data-qr="output_position=inc_details&filter=true&inc_type=AD_SUP_REQ" type="reset" style="font-weight: bold; margin-top: 5px;">
                <input name="search_btn"  tabindex="12" value="Search" class="mt-0 base-xhttp-request" data-href="{base_url}patients/pt_adv_inc_list" data-qr="output_position=inc_details" type="button" style="padding: 5px 20px !important;">




            </div> 


        </div>
            
        <div class="outer_type width100">
            
            <div class="float_left width20">
                
                
                <label for="rcmed" class="chkbox_check">

                                
                    <input type="checkbox" name="resource_type[medical]" class="filter_either_or[rcmed,rcpol,rcfir] check_input" value="medical" data-errors="{filter_either_or:'Type should not be blank!'}" id="rcmed" onclick="GetCheckedService();" data-base="search_btn">

                                   
                    <span class="chkbox_check_holder"></span>Medical


                </label>

          
            </div>
            
            <div class="float_left width20">
                
                <label for="rcpol" class="chkbox_check">

                                
                     <input type="checkbox" name="resource_type[police]" class="filter_either_or[rcmed,rcpol,rcfir] check_input" value="police" data-errors="{filter_either_or:'Type should not be blank!'}" id="rcpol" data-base="search_btn">

                                   
                    <span class="chkbox_check_holder"></span>Police


                </label>
                
             
            </div>
            
            <div class="float_left width20">
                
                
                
                 <label for="rcfir" class="chkbox_check">

                                
                     <input type="checkbox" name="resource_type[fire]" class="filter_either_or[rcmed,rcpol,rcfir] check_input" value="fire" data-errors="{filter_either_or:'Type should not be blank!'}" id="rcfir" data-base="search_btn">

                                   
                    <span class="chkbox_check_holder"></span>Fire


                </label>
                
             
            </div>
            
            
        </div>            
            
       <div id="inc_details">


        </div>
        <div id="inc_pt_info ">
                
        </div>
       
              
    </form>
           
</div>
    <script type="text/javascript">
        function GetCheckedService () {
            var input = document.getElementById ("rcmed");
            var isChecked = input.checked;
            isChecked = (isChecked)? "checked" : "not checked";

                 xhttprequest($(this),base_url+'resource/load_amb_view','checked='+isChecked);  
            
           
        }
    </script>

<style>
    body{
        font-size: 14px !important;
    }
</style>