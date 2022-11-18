<div class="call_purpose_form_outer">
<label class="headerlbl">Medical Advice EMT</label>

    <!-- <h3> Medical advice</h3> -->


    <form method="post" name="med_adv_form" id="med_adv">


        <input type="hidden" name="call_id" id="call_id" value="<?php echo $call_id; ?>">

        <input type="hidden" name="base_month" value="<?php echo $cl_base_month; ?>" data-base="search_btn">

        <input type="hidden" name="tah_id" id="tah_id" value="<?php echo $tahshil; ?>" data-base="search_btn">

        <input type="hidden" name="incient[caller_dis_timer]" id="caller_dis_timer" value="">

        <input type="hidden" name="incient[inc_recive_time]" value="<?php echo $attend_call_time; ?>">

        <input type="hidden" name="incient[inc_type]" id="inc_type" value="EMT_MED_AD">
        <input type="hidden" name="cl_purpose" id="inc_type" value="EMT_MED_AD" data-base="search_btn">


        <!--        <div class="inline_fields outer_med_details width50">

            <div class="form_field width50 outer_inc_id">

                <div class="label">Incident Id<span class="md_field">*</span></div>

                <div class="input">

                    <input name="inc_id" id="cmadv_incid" tabindex="6" value="<?php echo $inc_id[0]->inc_ref_id; ?>" class="form_input filter_required filter_no_whitespace" placeholder="Incident Id" type="text" data-base="search_btn" data-errors="{filter_required:'Incident Id should not be blank',filter_no_whitespace:'White space not allowed'}">

                </div>


            </div>


            <div class="form_field">

                <div class="label none_prop">&nbsp;</div>

                <input name="search_btn" tabindex="7" value="SEARCH" class="style3 base-xhttp-request" data-href="{base_url}medadv/petinfo" data-qr="output_position=adv_pt_info" type="button">

            </div> 

        </div>-->
        <div id="inc_filters">

            <div class="inline_fields width100">

                <div class="form_field width17">

                    <div class="label">Incident Id</div>

                    <input value="<?php echo date('Ymd'); ?>" name="inc_id" tabindex="7" id="cinc_id" class="form_input inc_id_filt" placeholder="Incident Id" type="text" data-base="search_btn">

                </div>

                <div class="form_field width17">

                    <div class="label">Mobile Number</div>

                    <div class="input">

                        <input name="clr_mobile" tabindex="8" class="form_input filter_if_not_blank filter_number filter_minlength[9] filter_maxlength[11]" data-errors="{filter_number:'Mobile number should be in numeric characters only.', filter_minlength:'Mobile number should be at least 10 digits long',filter_maxlength:'Mobile number should less then 11 digits.'}" placeholder="Mobile Number" type="text" data-base="search_btn">
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


                <div class="form_field width_30">

                    <div class="label">&nbsp;</div>
                    <input name="reset_filter" tabindex="12" value="RESET FILTER" class=" click-xhttp-request common_search width2 float_right mt-0" data-href="{base_url}patients/pt_inc_list" data-qr="output_position=inc_details&filter=true" type="reset" style="font-weight: bold; margin-top: 5px;">

                    <input name="search_btn" tabindex="12" value="SEARCH" class=" base-xhttp-request common_search width4 mt-0" data-href="{base_url}patients/pt_inc_list" data-qr="output_position=inc_details" type="button">
                    <!--  <input name="search_btn" tabindex="7" value="SEARCH" class="style3 base-xhttp-request" data-href="{base_url}medadv/petinfo" data-qr="output_position=adv_pt_info" type="button">-->




                </div>


            </div>
        </div>


        <div id="inc_details">


        </div>

        <div id="adv_pt_info">
            <div class="width100 enquiry_summary">
                <div class="ero_smr form_field float_left ">
                    <div class="label blue float_left width_25">ERO Summary<span class="md_field">*</span>&nbsp;</div>
                    <div class="width75 float_left">
                        <input type="text" name="incient[inc_ero_standard_summary]" data-value="<?= @$inc_details['inc_ero_standard_summary']; ?>" value="<?= @$inc_details['inc_ero_standard_summary_id']; ?>" class="mi_autocomplete filter_required width2" data-href="{base_url}auto/get_ero_standard_summary?call_type=EMT_MED_AD" placeholder="ERO Summary" data-errors="{filter_required:'Please select ERO Summary from dropdown list'}" data-callback-funct="ero_standard_summary_change" TABINDEX="8">
                    </div>

                </div>
                <div class="width2 form_field float_left">
                    <div class="label blue float_left width_16">ERO Note</div>

                    <div class=" float_left width75" id="ero_summary_other">
                        <textarea style="height:60px;" name="incient[inc_ero_summary]" class="width_100 " TABINDEX="16" data-maxlen="1600" data-errors="{filter_required:'ERO Summary should not be blank'}"><?= @$inc_details['inc_ero_summary']; ?></textarea>
                    </div>
                </div>

            </div>
        </div>

        <!--                <input type="hidden" name="incient[inc_ero_standard_summary]" value="<?php echo $common_data_form['inc_ero_standard_summary']; ?>">
                <input type="hidden" name="incient[inc_ero_summary]" value="<?php echo $common_data_form['inc_ero_summary']; ?>">-->
        <div class="width10 margin_auto" style="margin-bottom: 20px; height: 50px; clear: both;">
            <div id="fwdcmp_btn">

            </div>
        </div>

    </form>

</div>

<style>
    .ero_smr{
        width: 30% !important;
    }
</style>