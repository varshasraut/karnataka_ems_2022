     <form enctype="multipart/form-data" id="griveanance" action="#" method="post" >

<div class="field_row width100 padding_top_10 padding_btm_10">


    <div class="width33 float_left">    
        <div class="field_lable float_left width33"><label for="police_station">Complaint Type <span class="md_field">*</span></label></div>   <div class="filed_input float_left width50">
            <select name="gri[gc_complaint_type]" tabindex="8"  class="filter_required" id="gri_complaint_type"  data-errors="{filter_required:'Complaint type should not be blank!'}"  <?php echo $update; ?> > 
                <option value="" <?php echo $disabled; ?>>Select Complaint</option>
                <option value="external">External</option>
                <option value="internal" >Internal</option>
                <option value="e-complaint">E-Complaint</option>
                <option value="negative_news">Negative News</option>
                <option value="government_letter">Government letter</option>
            </select>

        </div>
    </div>
</div>
    <div id="complaint_type"></div>
    <div id="grivance_inc_filter"></div>
    <div id="inc_details"></div>
    <div id="grivience_info"></div>

</form>
