
<div class="inline_fields width100">

    <div class="form_field width17">

        <div class="label">Incident Id</div>

        <input name="inc_id" tabindex="7" id="cinc_id" class="form_input inc_id_filt" placeholder="Incident Id" type="text" data-base="search_btn">

    </div>

    <div class="form_field width17">

        <div class="label">Mobile Number</div>

        <div class="input"> 

            <input name="clr_mobile" tabindex="8" class="form_input filter_if_not_blank filter_number filter_minlength[9] filter_maxlength[11]"   data-errors="{filter_number:'Mobile number should be in numeric characters only.', filter_minlength:'Mobile number should be at least 10 digits long',filter_maxlength:'Mobile number should less then 11 digits.'}" placeholder="Mobile Number" type="text" data-base="search_btn">
        </div>

    </div>
 
    <div class="form_field width17">

        <div class="label">Incident City</div>

        <input  name="inc_cty" tabindex="9" class="form_input mi_autocomplete" data-href="{base_url}auto/city" placeholder="Incident City" type="text" data-base="search_btn" data-nonedit="yes">


    </div>

    <div class="form_field width17">

        <div class="label">Date Of Incidance<span class="md_field">*</span></div>

        <div class="input">

            <input name="inc_date" tabindex="10" class="form_input filter_required  mi_calender filter_date inc_date_filt" placeholder="YYYY-MM-DD" type="text" data-errors="{filter_required:'Incident date should not be blank',filter_date:'Date format is not valid'}" data-base="search_btn">

        </div>

    </div>

    <div class="form_field width17">

        <div class="label">Time Of Incidence<span class="md_field">*</span></div>

        <div class="input"> 

            <input name="inc_time" tabindex="11" class="mi_autocomplete filter_required filter_time inc_time_filt" placeholder="12 AM-12 PM" type="text" data-href="{base_url}auto/get_tinterval" data-errors="{filter_required:'Plase select time from dropdown list',filter_time:'Time format is not valid'}" data-base="search_btn" data-autocom="yes"> 

        </div>

    </div>


    <div class="form_field width_15">

        <div class="label">&nbsp;</div>

        <input name="search_btn"  tabindex="12" value="SEARCH" class="style3 base-xhttp-request common_search width100" data-href="{base_url}patients/pt_inc_list" data-qr="output_position=inc_details" type="button">



    </div> 


</div>