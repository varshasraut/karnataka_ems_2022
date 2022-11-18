<div class="inline_fields width100">

    <div class="form_field width17">

        <div class="label">Incident Id</div>

        <input name="inc_id" tabindex="2" class="form_input" placeholder="Enter Incident Id" type="text" data-base="search_btn">

    </div>

    <div class="form_field width17">

        <div class="label">Mobile Number</div>

        <input name="clr_mobile" tabindex="3" class="form_input" placeholder="Enter Mobile Number" type="text" data-base="search_btn">

    </div>

    <div class="form_field width17">

        <div class="label">Incident City</div>

        <input name="inc_cty" tabindex="4" class="mi_autocomplete form_input filter_required" value=""  data-href="{base_url}auto/city" placeholder="Enter Incident City" type="text" data-base="search_btn">


        
    </div>

    <div class="form_field width17">

        <div class="label">Date Of Incidance*</div>

        <input name="inc_date" tabindex="5" class="form_input filter_if_not_blank filter_date" placeholder="YYYY-MM-DD" type="text" data-errors="{filter_date:'Date format is not valid'}" data-base="search_btn">

    </div>

    <div class="form_field width17">

        <div class="label">Time Of Incidence*</div>

        <input name="inc_time" tabindex="6" class="form_input filter_if_not_blank filter_time" placeholder="12AM-12PM" type="text" data-errors="{filter_time:'Time format is not valid'}" data-base="search_btn"> 

    </div> 


    <div class="form_field">

        <div class="label">&nbsp;</div>

        <input name="search_btn" value="SEARCH" class="style3 change-base-xhttp-request" data-href="{base_url}patients/pt_inc_list" data-qr="output_position=inc_details" type="button">



    </div> 


</div>