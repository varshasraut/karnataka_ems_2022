
<div class="inline_fields width100">

    <div class="form_field width17">

        <div class="label">Incident Id</div>

        <input value="<?php echo date('Ymd'); ?>" name="inc_id" tabindex="7" id="cinc_id" class="form_input inc_id_filt" placeholder="Incident Id" type="text" data-base="search_btn">

    </div>

    <div class="form_field width17">

        <div class="label">Mobile Number</div>

        <div class="input"> 

            <input name="clr_mobile" tabindex="8" class="form_input filter_if_not_blank filter_number filter_minlength[9] filter_maxlength[13]"   data-errors="{filter_number:'Mobile number should be in numeric characters only.', filter_minlength:'Mobile number should be at least 10 digits long',filter_maxlength:'Mobile number should less then 13 digits.'}" placeholder="Mobile Number" type="text" data-base="search_btn">
        </div>

    </div>
    <div class="form_field width17">

                <div class="label">Ambulance No</div>
                 <input name="amb_reg_no" class="mi_autocomplete dropdown_per_page width97" data-href="{base_url}auto/get_ambulance" placeholder="Select Ambulance" data-errors="{filter_required:'Please select state from dropdown list'}" tabindex="15" autocomplete="off" value="<?php echo $amb_reg_id; ?>" data-value="<?php echo $amb_reg_id; ?>" data-base="search_btn">



            </div>
 
    <!-- <div class="form_field width10">

        <div class="label">Incident District</div>
        
 
        <input  name="inc_district" tabindex="9" class="form_input mi_autocomplete" data-href="{base_url}auto/get_district/<?php echo $default_state; ?>" placeholder="Incident District" type="text" data-base="search_btn" data-nonedit="yes">


    </div> -->

    <!-- <div class="form_field width17">

        <div class="label">Date of Incident
            
        </div>

        <div class="input">

            <input name="inc_date" tabindex="10" class="form_input filter_if_not_blank  mi_calender filter_date inc_date_filt" placeholder="YYYY-MM-DD" type="text" data-errors="{filter_required:'Incident date should not be blank',filter_date:'Date format is not valid'}" data-base="search_btn">

        </div>

    </div> -->

    <!-- <div class="form_field width17">

        <div class="label">Time Of Incident
        </div>

        <div class="input"> 

            <input name="inc_time" tabindex="11" class="mi_autocomplete filter_if_not_blank filter_time inc_time_filt" placeholder="12 AM-12 PM" type="text" data-href="{base_url}auto/get_tinterval" data-errors="{filter_required:'Plase select time from dropdown list',filter_time:'Time format is not valid'}" data-base="search_btn" data-autocom="yes"> 

        </div>

    </div> -->


    <div class="form_field width_50">

        <div class="label">&nbsp;</div>
        <input name="reset_filter"  tabindex="12" value="RESET FILTER" class=" click-xhttp-request common_search width2 float_right" data-href="{base_url}patients/pt_inc_list" data-qr="output_position=inc_details&filter=true" type="reset" style="font-weight: bold;">

        <input name="search_btn"  tabindex="12" value="SEARCH" class=" base-xhttp-request common_search width4" data-href="{base_url}patients/pt_inc_list" data-qr="output_position=inc_details" type="button">
      



    </div> 


</div>