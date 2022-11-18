<?php
////var_dump($m_no);
//die(); 
?>

<style>.width05{width :5%;}</style>
<div class="call_common_info">
    <div class="float_left width100">
        <div class="width_11 float_left">
            <div class="label blue" style="font-size: 14px;"><b>Patient Information</b></div>
        </div>
        <!-- <div class="label blue"><b>Patient Information</b></div> -->
        <!--                         <div class="width75 float_left">
                        <input id="first_name"  type="text" name="patient[full_name]" class="filter_required ucfirst"  data-errors="{filter_required:'Patient name should not be blank', filter_word:'Invalid input at first name. Numbers and special characters not allowed.'}" value="<?= @$caller_details_data['clr_full_name']; ?>" placeholder="Patient Full Name" TABINDEX="11">
                    </div>-->
        <div class="width_11 float_left">
            <input id="ptn_first_name" type="text" name="patient[first_name]" class="filter_required ucfirst_letter filter_if_not_blank filter_word" data-errors="{filter_required:'First name should not be blank', filter_word:'Invalid input at first name. Numbers and special characters not allowed.'}" value="<?php if ($caller_details_data['clr_fname'] == '') {
                                                                                                                                                                                                                                                                                                                            echo 'Unknown';
                                                                                                                                                                                                                                                                                                                        } else {
                                                                                                                                                                                                                                                                                                                            echo $caller_details_data['clr_fname'];
                                                                                                                                                                                                                                                                                                                        } ?>" placeholder="First Name" TABINDEX="11" onchange="submit_caller_form()">
        </div>
        <!--                    <div class="width_16 float_left">
                        <input id="ptn_middle_name" type="text" name="patient[middle_name]" class="ucfirst filter_if_not_blank filter_word"  data-errors="{filter_required:'Middle name should not be blank', filter_word:'Invalid input at first name. Numbers and special characters not allowed.'}" value="<?= @$caller_details_data['clr_mname']; ?>" placeholder="Middle Name" TABINDEX="12"  onchange="submit_caller_form()">
                    </div>-->
        <div class="width_11 float_left">
            <input id="ptn_last_name" type="text" name="patient[last_name]" class="ucfirst_letter filter_if_not_blank filter_word" data-errors="{filter_required:'Last name should not be blank', filter_word:'Invalid input at first name. Numbers and special characters not allowed.'}" value="<?= @$caller_details_data['clr_lname']; ?>" placeholder="Last Name" TABINDEX="13" onchange="submit_caller_form()">
        </div>
        <div class="width_11 float_left">
                                        <input id="ptn_mob_no" type="text" pattern="[7-9]{1}[0-9]{9}" onkeyup="this.value=this.value.replace(/[^\d]/,'')" name="patient[ptn_mob_no]" class="" value="" placeholder="Alternate Mob No" TABINDEX="13" onchange="submit_caller_form()" data-base="caller[ptn_mob_no]" maxlength="10">
                                    </div> 
        <!--                  <div class="width_16 float_left">
                      <input id="ptn_dob" data-fname="patient[age]" type="text" name="patient[dob]" class="mi_cur_date"  data-errors="{filter_required:'DOB should not be blank',filter_number:'Age should be in numbers'}" value="<?= @$caller_details_data['patient_age']; ?>" placeholder="DOB" TABINDEX="14" readonly="readonly" onchange="submit_caller_form()">
                    </div>-->
        <div class="width_11 float_left" id="ptn_age_outer">
            <input id="ptn_age" type="text" name="patient[age]" class="filter_required filter_rangelength[0-100]" data-errors="{filter_required:'Age should not be blank',filter_rangelength:'Age should be 0 to 100',filter_number:'Age should be in numbers'}" value="<?= @$caller_details_data['patient_age']; ?>" placeholder="Age" TABINDEX="14" onchange="submit_caller_form()" onkeyup="this.value=this.value.replace(/[^\d]/,'')" maxlength="3">
        </div>
        <div class="width_11 float_left"">
                                                        <select id=" age_type" name="patient[age_type]" class="<?php if ($m_no != '') {
                                                                                                                    echo "filter_required has_error";
                                                                                                                } ?>" <?php echo $view; ?> TABINDEX="15" data-errors="{filter_required:'Gender should not be blank'}" onchange="submit_caller_form()" data-base="caller[cl_mobile_number]">
            <!--<option value="">Age Type</option>-->
            <option value="Years" <?php if ($caller_details_data['age_type'] == 'Years' || $caller_details_data['age_type'] == 'Years') {
                                        echo "selected";
                                    } ?>>Years</option>
            <option value="Months" <?php if ($caller_details_data['age_type'] == 'Months' || $caller_details_data['age_type'] == 'Months') {
                                        echo "selected";
                                    } ?>>Months</option>
            <option value="Days" <?php if ($caller_details_data['age_type'] == 'Days' || $caller_details_data['age_type'] == 'Days') {
                                        echo "selected";
                                    } ?>>Days</option>
            </select>
        </div>
        <div class="width_11 float_left">
            <input id="ptn_ayu_id" type="text" name="patient[ayu_id]" class="" value="" placeholder="Ayushman ID" TABINDEX="13" onchange="submit_caller_form()" data-base="caller[cl_mobile_number]">
        </div>
        <div class="width_11 float_left">
            <select id="ptn_bld_gp" name="patient[blood_gp]" class="" data-base="caller[cl_mobile_number]" TABINDEX="1.1" onchange="submit_caller_form()">
                <option value="">Blood Group</option>
                <?php
                foreach ($blood_gp as $bg) {
                    echo '<option value="' . $bg->bldgrp_id . '">' . $bg->bldgrp_name . '</option>';
                }
                ?>
            </select>
        </div>
        <div class="width_11 float_left" id="non_mci_patient_gender">
            <select id="patient_gender" name="patient[gender]" class="filter_required" <?php echo $view; ?> TABINDEX="15" onchange="submit_caller_form()" data-errors="{filter_required:'Gender should not be blank'}">
                <option value="">Gender</option>
                <option value="M" <?php if ($caller_details_data['patient_gender'] == 'Male' || $caller_details_data['patient_gender'] == 'M') {
                                        echo "selected";
                                    } ?>>Male</option>
                <option value="F" <?php if ($caller_details_data['patient_gender'] == 'Female' || $caller_details_data['patient_gender'] == 'F') {
                                        echo "selected";
                                    } ?>>Female</option>
                <option value="O" <?php if ($caller_details_data['patient_gender'] == 'Other' || $caller_details_data['patient_gender'] == 'O') {
                                        echo "selected";
                                    } ?>>Transgender</option>
            </select>
        </div>
     
                                    

                              

    </div>

    <!--                    <div class="width2 form_field outer_smry float_left">
                        <div class="label blue float_left">ERO Summary<span class="md_field">*</span>&nbsp;</div>
                          <div class="width100 float_left">
                         <input type="text" name="patient[inc_ero_standard_summary]" data-value="<?= @$inc_details['inc_ero_standard_summary']; ?>" value="<?= @$inc_details['inc_ero_standard_summary_id']; ?>" class="mi_autocomplete filter_required width2"  data-href="{base_url}auto/get_ero_standard_summary"  placeholder="ERO Summary" data-errors="{filter_required:'Please select ERO Summary from dropdown list'}" data-callback-funct="ero_standard_summary_change" TABINDEX="8" >
                          </div>
                         <div class="width100" id="ero_summary_other">
                        <textarea name="incient[inc_ero_summary]" class="width_100 " TABINDEX="16" data-maxlen="800"  data-errors="{filter_required:'ERO Summary should not be blank'}"><?= @$inc_details['inc_ero_summary']; ?></textarea>
                        </div>
                    </div>
                    <div class="width2 form_field outer_smry float_left">
                        <div class="label blue float_left">ERO Note</div>
      
                         <div class="width100" id="ero_summary_other">
                             <textarea style="height:60px;" name="patient[inc_ero_summary]" class="width_100 " TABINDEX="16" data-maxlen="1600"  data-errors="{filter_required:'ERO Summary should not be blank'}"><?= @$inc_details['inc_ero_summary']; ?></textarea>
                        </div>
                    </div>-->
</div>
<div class="width_11 float_left" style="margin-left:100px" id="non_mci_patient_gender">
                                    </div>
                                    <div class="width05 float_left"><label>State</label></div>
                                    <div class="width15 float_left"> 
                                            <div id="incient_state">
                                            <?php
                                                if($inc_details['state_id'] == ''){
                                                    $state_id = '';
                                                }else {
                                                    $state_id = $inc_details['state_id'];
                                                }
                                                
                                                // $st = array('st_code' => $state_id, 'auto' => 'incient_auto_addr', 'rel' => 'incient', 'disabled' => '');
                                                $st = array('st_code' => 'MP', 'auto' => 'incient_auto_addr', 'rel' => 'incient', 'disabled' => '');
                                                echo get_state_tahsil_104($st);
                                                ?>

                                        </div>

                                    </div>


<style>
    .disabled_div{
    pointer-events: none;
    opacity: 0.4;
}
</style>
                                    <div class="width05 float_left hide_show"><label>District</label></div>
                                    <div class="width15 float_left hide_show">
                                    
                        <div id="incient_dist">
                            <?php
                            if($inc_details['district_id'] == '' || $inc_details['district_id'] == 0){
                                 $district_id = '';
                            }else {
                                $district_id = $inc_details['district_id'];
                            }
                            
                            $dt = array('dst_code' => $district_id, 'st_code' => 'MP', 'auto' => 'inc_auto_addr', 'rel' => 'incient', 'disabled' => '');

                            echo get_district_tahsil($dt);
                            ?>
                        </div>
                    </div>
                    <div class="width05 float_left hide_show"><label>Tehsil</label></div>
                    <div class="width15 float_left hide_show">
                        <div id="incient_tahsil">
                            <?php
                            if($inc_details['tahsil_id'] == '' || $inc_details['tahsil_id'] == 0){
                                 $tahsil_id = '';
                            }else {
                                $tahsil_id = $inc_details['tahsil_id'];
                            }
                            $thl = array('thl_id' =>$tahsil_id, 'dst_code' => $district_id, 'st_code' => $state, 'auto' => 'inc_auto_addr', 'rel' => 'incient', 'disabled' => '');

                            echo get_tahshil($thl);
                            ?>
                        </div>
                    </div>
                    <div class="width05 float_left"><label>Area</label></div>
                                    <div class="width15 float_left" id="incient_area">
                        <input type="text" name="area" TABINDEX="73" value="<?=@$inc_details['area'];?>" class="filter_required stauto" data-errors="{filter_required:'Area/Location is required'}" placeholder="Area/Location" data-auto="" id="area_location">
                    </div>

                    <script>
    function check_state(){
        var state = $("input[name='incient_state']").val();
        // alert(state);
        if(state!='MP')
        {
            $("input[name='incient_district']").prop( "disabled", true ); 
            // $('#incient_dist').addClass('disabled_div');
            $('#incient_dist').removeClass('field_error');
            $("input[name='incient_tahsil']").prop( "disabled", true );
            $("input[name='incient_district']").val('');
            $("input[name='incient_district']").removeClass('filter_required has_error'); 
            // $('#incient_tahsil').addClass('disabled_div');
            $('#incient_tahsil').removeClass('field_error');
            $('#incient_tahsil').removeClass('field_error_show');
            $("input[name='incient_tahsil']").val('');
            $("input[name='incient_tahsil']").removeClass('filter_required has_error');
            // $('#incient_dist').hide();
            // $('#incient_tahsil').hide();
            $('.hide_show').hide();

        }
        else
        {
            $("input[name='incient_district']").prop( "disabled", false );
            // $('#incient_dist').removeClass('disabled_div');
            $('#incient_dist').addClass('field_error');
            $("input[name='incient_tahsil']").prop( "disabled", false );
            // $('#incient_tahsil').removeClass('disabled_div');
            $('#incient_tahsil').addClass('field_error');
            $('#incient_tahsil').removeClass('field_error_show');
            // $('#incient_dist').show();
            // $('#incient_tahsil').show();
            $('.hide_show').show();
        }
    }
</script>