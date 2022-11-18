


    <form name="com_call_fwd" method="post" id="dispatch_call_forms">
        <div class="form_field width100 hide" id="termination_reason_other">
            <div class="label blue float_left width30">Other Termination Reason</div>
            <div class="input nature top_left float_left width_66">
                <input type="text" name="termination_reason_other" value="" class="" placeholder="Other Termination Reason" data-errors="{filter_required:'Other Termination Reason is required'}" TABINDEX="73">
            </div>
        </div>

        <br>
        <br>
    </form>
</div>
<?php
$current_user_group = $this->session->userdata['current_user']->clg_group;
if ($current_user_group == 'UG-ERO') {
    $system = "108";
} else {
    $system = "102";
}
?>
<div class="call_purpose_form_outer">

    <!-- <h3>Service Not required Call</h3> -->
    <label class="headerlbl">Ambulance Not Assigned Call</label>
    <div id="totalnon_div">

        <div id="nonleft_half">

            <form method="post" name="complnt_call_form" id="complnt_form">
               
                <input type="hidden" name="incient[inc_type]" id="inc_type" value="AMB_NT_ASSIGND">
                <input type="hidden" name="cl_purpose" value="AMB_NT_ASSIGND" data-base="search_btn">

                <div class="inline_fields width100" id="inc_filters">
                    <div class="form_field width20">
                        <div class="label width100">Incident District</div>
                        <input name="inc_district_id" id="inc_district"  tabindex="9" class="form_input mi_autocomplete" data-href="<?php echo base_url(); ?>auto/get_district/<?php echo $default_state; ?>" data-callback-funct="district_wise_ambulance" placeholder="Incident District" type="text">
                    </div>
                    <div class="form_field width_30">
                    
                    <div class="label width100">Incident Ambulance</div>
                    <div class="multiselect"   id="ambulancelist">
                        <select>
                            <option></option>
                        </select>
                    </div>
                    </div>
                    <div class="width100 form_field float_left ">
                        <div class="label blue float_left width_20">Non-Assignment Ambulance Reason<span class="md_field">*</span>&nbsp;</div>
                        <div class="width75 float_left">
                        <textarea style="height:60px;" id="inc_amb_not_assgn_reason"  name="inc_amb_not_assgn_reason" class="filter_required width_100 " TABINDEX="16" data-maxlen="1600" data-errors="{filter_required:'Reason should not be blank'}">
                        </textarea>
                        </div>
                    </div>
                    <div class="width100 form_field float_left ">
                        <div class="label blue float_left width_20">Incident Place<span class="md_field">*</span>&nbsp;</div>
                        <div class="width75 float_left">
                        <textarea style="height:60px;" id="inc_place" name="inc_place" class="filter_required width_100 " TABINDEX="16" data-maxlen="1600" data-errors="{filter_required:'Place should not be blank'}">
                        </textarea>
                        </div>
                    </div>
                </div>
                
                <div class="button_field_row  text_align_center">
                    <div class="button_box enquiry_button">
                        <input type="hidden" name="submit" value="sub_enq" />
                        <input type="hidden" name="non_eme_call[cl_type]" value="<?php echo $cl_type; ?>" />
                        <input type="hidden" name="call_id" id="call_id" value="<?php echo $call_id; ?>">
                        <input type="hidden" id="hidden_caller_id" name="caller_id" value="<?php echo $caller_id; ?>">
                        <input type="hidden" name="incient[caller_dis_timer]" id="caller_dis_timer" value="">
                        <input type="hidden" name="incient[inc_recive_time]" value="<?php echo $attend_call_time; ?>">
                        <input type="hidden" name="incient[CallUniqueID]" value="<?php echo $CallUniqueID; ?>">
                        <?php if ($cl_type == "NON_MCI") {?>
                            <input name="fwd_btn" id="fwd_btn" value="SAVE" class=" form-xhttp-request" data-href="<?php echo base_url(); ?>inc/amb_not_assi_save" data-qr="output_position=summary_div" type="button" tabindex="13" autocomplete="off">
                        <?php }elseif($cl_type == "DROP_BACK"){?>
                            <input name="fwd_btn" id="fwd_btn" value="SAVE" class=" form-xhttp-request" data-href="<?php echo base_url(); ?>inc102/amb_drop_back_not_assi_save" data-qr="output_position=summary_div" type="button" tabindex="13" autocomplete="off">
                        <?php }elseif($cl_type == "IN_HO_P_TR"){?>
                            <input name="fwd_btn" id="fwd_btn" value="SAVE" class=" form-xhttp-request" data-href="<?php echo base_url(); ?>inc/amb_inter_hos_not_assi_save" data-qr="output_position=summary_div" type="button" tabindex="13" autocomplete="off">
                        <?php }elseif($cl_type == "MCI"){?>
                            <input name="fwd_btn" id="fwd_btn" value="SAVE" class=" form-xhttp-request" data-href="<?php echo base_url(); ?>inc/amb_inter_hos_not_assi_save" data-qr="output_position=summary_div" type="button" tabindex="13" autocomplete="off">
                        <?php }elseif($cl_type == "PICK_UP"){?>
                            <input name="fwd_btn" id="fwd_btn" value="SAVE" class=" form-xhttp-request" data-href="<?php echo base_url(); ?>inc/amb_inter_hos_not_assi_save" data-qr="output_position=summary_div" type="button" tabindex="13" autocomplete="off">
                        <?php }elseif($cl_type == "VIP_CALL"){?>
                            <input name="fwd_btn" id="fwd_btn" value="SAVE" class=" form-xhttp-request" data-href="<?php echo base_url(); ?>inc/amb_inter_hos_not_assi_save" data-qr="output_position=summary_div" type="button" tabindex="13" autocomplete="off">
                        <?php }?>
                    </div>
                </div>
                <!-- <div id="fwdcmp_btn">
                        
                </div> -->
            </form>
        </div>
        <div id="nonright_half">
                    <div id="Details" class="width100 form_field float_left">
                    <table class='table' id="table">
                        <thead>
                            <tr>
                                <!-- <th scope='col'>#</th> -->
                                <th>Ambulance No</th>
                                <th>Status</th>
                                <th>EMT</th>
                                <th>Pilot</th>
                                <th>Base-Location</th>
                            </tr>
                        </thead>
                        <tbody id='bidders'>

                        </tbody>
                    </table>   
                    </div>
        </div>
    </div>
</div>
<script>
$('document').ready(function()
{
    $('#inc_place').each(function(){
            $(this).val($(this).val().trim());
        }
    );
    $('#inc_amb_not_assgn_reason').each(function(){
            $(this).val($(this).val().trim());
        }
    );
});

</script>