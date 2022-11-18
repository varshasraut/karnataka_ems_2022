<div class="inline_fields width100" id="inc_filters">

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

                <div class="label">Ambulance No</div>


                <select name="amb_reg_no" class="" data-errors="{filter_required:'Please select ambulance'}" data-base="search_btn">
                                    <option value="">Select Ambulance</option>

                                    <?php $all_amb =  get_all_amb();
                                    foreach($all_amb as $amb){?>
                                        <option value="<?php echo $amb->amb_rto_register_no; ?>"><?php echo $amb->amb_rto_register_no; ?></option>
                                    <?php }
                                    ?>


                </select>


            </div>


            <div class="form_field width_15">

                <div class="label">&nbsp;</div>
                <input name="reset_filter"  tabindex="12" value="RESET FILTER" class=" click-xhttp-request  width2 float_right mt-0" data-href="{base_url}patients/pt_adv_inc_list" data-qr="output_position=inc_details&filter=true&inc_type=AD_SUP_REQ" type="reset" style="font-weight: bold; margin-top: 5px;">
                <input name="search_btn"  tabindex="12" value="SEARCH" class=" base-xhttp-request  width4 mt-0" data-href="{base_url}patients/pt_adv_inc_list" data-qr="output_position=inc_details" type="button" style="padding: 5px !important;">




            </div> 


        </div>