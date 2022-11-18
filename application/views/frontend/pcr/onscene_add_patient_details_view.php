<script>
if(typeof H != 'undefined'){
    init_auto_address();
}

</script>

<?php
$CI = EMS_Controller::get_instance();

$bgtype[$ptn[0]->ptn_bgroup_type] = "selected='selected'";

$rtncrd[$ptn[0]->ptn_ration_card] = "checked=''";
?>

<div class="head_outer"><h3 class="txt_clr2 width1">PATIENT INFORMATION</h3> </div>

<form method="post" name="" id="patient_info">


    <input type="hidden" name="ptn_id" value="<?php echo $ptn_id; ?>">
    <input type="hidden" name="p_id" value="<?php echo $ptn_id; ?>">

    <input type="hidden" name="inc_id" value="<?php echo $inc_id; ?>">
    <input type="hidden" name="pt_count" id="pt_count_popup" value="<?php echo $pt_count; ?>">
    <input type="hidden" name="epcr_call_type" id="epcr_call_type_popup" value="<?php echo $epcr_call_type; ?>">
    <input type="hidden" name="pt_count_ero" id="pt_count_ero_popup" value="<?php echo $pt_count_ero; ?>">
    <?php
    $pt_count_ero = $pt_count_ero+5;
if($pt_count < $pt_count_ero)
{
    ?>
    


    <div class="epcr_patient">

        <div class="width100 patient_blk display_inlne_block">
            <div class="single_record_back">                                     
                <h3>Patient Information  </h3>
            </div>
            <!--<div class="style6">Patient Information<span class="md_field">*</span></div>-->
            <div class="float_left" style="width:3.00%" data-activeerror="">
            <label>1.</label>
            </div>
            <div class="width_10 float_left" data-activeerror="">
                <input name="ptn[0][ptn_fname]" value="<?php echo $ptn[0]->ptn_fname; ?>" class="filter_required ucfirst_letter filter_words" tabindex="1"  type="text" placeholder="First Name*"  data-errors="{filter_required:'Patient Name should not blank',filter_words:'First name not allowed number,spaces and special characters.'}" data-base="save_patient[0]">
            </div>




            <div class="width_10 float_left">

                <input name="ptn[0][ptn_lname]" value="<?php echo $ptn[0]->ptn_lname; ?>" class="filter_required ucfirst_letter filter_words" tabindex="3" type="text" placeholder="Last Name*" data-errors="{filter_required:'Last name should not blank',filter_words:'Last name not allowed number,spaces and special characters.'}" data-base="save_patient[0]">

            </div>
            <?php
            if($ptn_bd=='0000-00-00 00:00:00'){
                $ptn_bd='';
            }else{
                if($ptn[0]->ptn_birth_date=='0000-00-00 00:00:00'){

                }else{
                    $ptn_bd = explode(" ", $ptn[0]->ptn_birth_date);

                    $ptn_bd = date('d-m-Y', strtotime($ptn_bd[0]));
                }
            
            }
            ?>


            <div id= "ptn_age_outer" class="width_10 float_left">

                <input name="ptn[0][ptn_age]"  onkeyup="this.value=this.value.replace(/[^\d]/,'')" value="<?php echo $ptn[0]->ptn_age; ?>" class="filter_required filter_rangelength[0-120]" tabindex="4"  type="text" placeholder="Age" data-errors="{filter_required:'Age should not blank',filter_rangelength:'Age should be 0 to 120'}" data-base="save_patient[0]">

            </div>
            <div id= "ptn_age_outer" class="width_10 float_left">

                <select id="ptn_age_type" name="ptn[0][ptn_age_type]" data-base="save_patient[0]">
                <option value="Year" >Year</option>
                <option value="Month">Month</option>
                <option value="Day">Day</option>
                </select>
                    </div>
           

            <div class="width_10 float_left">
                <select name="ptn[0][ptn_gender]" class="filter_required"  data-errors="{filter_required:'Please select gender'}"  tabindex="6" data-base="save_patient[0]">
                    <option value="">Gender</option>

                    <?php echo get_gen_type($ptn[0]->ptn_gender); ?>

                </select>
            </div>
            <div class="width_10 drg float_left">
                       
                        <?php 
                
                        if($inc_details[0]->provider_casetype != ''){
                        if($user_group == 'UG-BIKE-DCO'){
                          ?>
                          <div class="width_100 float_left base_location">
                              <input name="epcr[0][provider_casetype]" tabindex="4" class="mi_autocomplete form_input filter_required" placeholder="Case Type" type="text" data-errors="{filter_required:'Plase select Case type from dropdown list'}" value="<?php echo $inc_details[0]->provider_casetype; ?>" data-value="<?php echo $inc_details[0]->case_name; ?>" data-href="<?php echo base_url();?>/auto/get_providercase_type_new?epcr_call_type=<?php echo $epcr_call_type;?>&patient_gender=<?php echo $pt_info[0]->ptn_gender; ?>" data-qr="" id="provider_casetype1" placeholder="Case Type" data-base="save_patient[0]">
                        </div>
                          <?php  
                            
                        }else{
                            ?>
                            <div class="width_100 float_left base_location">
                            <input name="epcr[0][provider_casetype]" tabindex="4" class="mi_autocomplete form_input filter_required" placeholder="Case Type" type="text" data-errors="{filter_required:'Plase select Case type from dropdown list'}" value=""<?php echo $inc_details[0]->provider_casetype; ?>" data-value="<?php echo $inc_details[0]->case_name; ?>" data-href="<?php echo base_url();?>/auto/get_providercase_type_new?epcr_call_type=<?php echo $epcr_call_type;?>&patient_gender=<?php echo $pt_info[0]->ptn_gender; ?>&patient_gender=<?php echo $pt_info[0]->ptn_gender; ?>" data-qr="" id="provider_casetype1" data-callback-funct="remove_mandatory_fields_new" data-base="save_patient[0]">
                        </div>
                            <?php
                        }
                    }else{

                        if($user_group == 'UG-BIKE-DCO'){
                            ?>
                            <div class="width_100 float_left base_location">
                              <input name="epcr[0][provider_casetype]" tabindex="4" class="mi_autocomplete form_input filter_required" placeholder="Case Type" type="text" data-errors="{filter_required:'Plase select Case type from dropdown list'}" value="30" data-value="Treatment On Scene" data-href="<?php echo base_url();?>/auto/get_providercase_type_new?epcr_call_type=<?php echo $epcr_call_type;?>&patient_gender=<?php echo $pt_info[0]->ptn_gender; ?>" data-qr="" id="provider_casetype1" data-base="save_patient[0]">
                          </div>
                            <?php  
                              
                          }else{
                              ?>
                              <div class="width_100 float_left base_location">
                              <input name="epcr[0][provider_casetype]" tabindex="4" class="mi_autocomplete form_input filter_required" placeholder="Case Type" type="text"  data-errors="{filter_required:'Plase select Case type from dropdown list'}" value="30" data-value="Treatment On Scene" data-href="<?php echo base_url();?>/auto/get_providercase_type_new?epcr_call_type=<?php echo $epcr_call_type;?>&patient_gender=<?php echo $pt_info[0]->ptn_gender; ?>&patient_gender=<?php echo $pt_info[0]->ptn_gender; ?>" data-qr="" id="provider_casetype" data-callback-funct="" data-base="save_patient[0]">
                          </div>
                              <?php
                          }
                    }
                    ?>
                        <div class="form_field width100 float_left hide" id='provider_casetype_other'>
                    <div class="style6 float_left">Other Case Type :</div>
                    <div class="width50 float_left base_location">
                    <input name="epcr[0][provider_casetype_other]" id="provider_casetype_other_text"   class="form_input" placeholder="Other Case Type"  type="text" value="<?php echo @$inc_details[0]->provider_casetype_other; ?>" tabindex="6" data-errors="{filter_required:'should not be blank!'}" data-base="save_patient[0]">
                    </div>
                </div> 
                    </div>
            <div class="width_10 drg float_left">
    
                        <div class="width_100 float_left base_location">
                            <input name="epcr[0][provider_impressions]" tabindex="4" class="mi_autocomplete form_input filter_required" placeholder="Provider Impressions" type="text" data-errors="{filter_required:'Plase select provider from dropdown list'}"  value="<?php echo @$inc_details[0]->provider_impressions; ?>" data-value="<?php echo @$inc_details[0]->pro_name; ?>" data-href="<?php echo base_url();?>/auto/get_provider_imp_new?epcr_call_type=<?php echo $epcr_call_type;?>&patient_gender=<?php echo $pt_info[0]->ptn_gender; ?>" data-qr="" id="provider_impressions" data-callback-funct="remove_mandatory_fields" placeholder="Provider Impressions" data-base="save_patient[0]">
                        </div>
                    </div>
            <div class="width_10 drg float_left">

                <div class="width_100 float_left base_location">
                   <input name="save_patient[0]" value="Save" class="style3 base-xhttp-request" data-href="<?php echo base_url();?>pcr/save_onscene_add_patient_details" data-qr="output_position=content" type="button">
                </div>
            </div>
            <div><a class="add_patient_more btn float_right" style="margin-right:30px;padding: 5px 5px; margin: 0px;">Add More</a></div>

            
               
              
        </div>


        
    </div>
   
    <div id="patient_add_more" class="hide">
    <div class="patient_blk blk patient_hide_class">
    <div class="width100 display_inlne_block">
    <div class="float_left" style="width:3.00%" data-activeerror="">
            <label><?php echo 'sr_idx'; ?></label>
            </div>
            <div class="width_10 float_left" data-activeerror="">
                <input name="ptn[indx][ptn_fname]" value="" class="flt_reg fil_wo" tabindex="1"  type="text" placeholder="Full Name*"  data-errors="{filter_required:'Patient Name should not blank',filter_words:'First name not allowed number,spaces and special characters.'}" data-base="save_patient[indx]">
            </div>

            <div class="width_10 float_left">

                <input name="ptn[indx][ptn_lname]" value="" class="flt_reg fil_wo" tabindex="3"  type="text" placeholder="Last Name*" data-errors="{filter_required:'Last name should not blank',filter_words:'Last name not allowed number,spaces and special characters.'}" data-base="save_patient[indx]">

            </div>
            <?php
            if($ptn_bd=='0000-00-00 00:00:00'){
                $ptn_bd='';
            }else{
                if($ptn[0]->ptn_birth_date=='0000-00-00 00:00:00'){

                }else{
                    $ptn_bd = explode(" ", $ptn[0]->ptn_birth_date);

                    $ptn_bd = date('d-m-Y', strtotime($ptn_bd[0]));
                }
            
            }
            ?>


            <div id= "ptn_age_outer" class="width_10 float_left">

                <input name="ptn[indx][ptn_age]"  onkeyup="this.value=this.value.replace(/[^\d]/,'')" value="" class="flt_reg filter_rangelength[0-120]" tabindex="4" type="text" placeholder="Age" data-errors="{filter_required:'Age should not blank',filter_rangelength:'Age should be 0 to 120'}" data-base="save_patient[indx]">

            </div>
                  
            <div id= "ptn_age_outer" class="width_10 float_left">

<select id="ptn_age_type" name="ptn[indx][ptn_age_type]" data-base="save_patient[indx]">
<option value="Year" >Year</option>
<option value="Month">Month</option>
<option value="Day">Day</option>
</select>
    </div>
           

            <div class="width_10 float_left">
                <select name="ptn[indx][ptn_gender]" class="flt_reg"  data-errors="{filter_required:'Please select gender'}"  tabindex="6" data-base="save_patient[indx]">
                    <option value="">Gender</option>

                    <?php echo get_gen_type($ptn[0]->ptn_gender); ?>

                </select>
            </div>
            <div class="width_10 drg float_left">
                       
                        <?php 
                
                        if($inc_details[0]->provider_casetype != ''){
                        if($user_group == 'UG-BIKE-DCO'){
                          ?>
                          <div class="width_100 float_left base_location">
                              <input name="epcr[indx][provider_casetype]" tabindex="4" class="autocls form_input filter_required" placeholder="Case Type" type="text"  data-errors="{filter_required:'Plase select Case type from dropdown list'}" value="<?php echo $inc_details[0]->provider_casetype; ?>" data-value="<?php echo $inc_details[0]->case_name; ?>" data-href="<?php echo base_url();?>/auto/get_providercase_type_new?epcr_call_type=<?php echo $epcr_call_type;?>&patient_gender=<?php echo $pt_info[0]->ptn_gender; ?>" data-qr="" id="provider_casetype1" placeholder="Case Type" data-base="save_patient[indx]">
                        </div>
                          <?php  
                            
                        }else{
                            ?>
                            <div class="width_100 float_left base_location">
                            <input name="epcr[indx][provider_casetype]" tabindex="4" class="autocls form_input filter_required" placeholder="Case Type" type="text" data-errors="{filter_required:'Plase select Case type from dropdown list'}" value=""<?php echo $inc_details[0]->provider_casetype; ?>" data-value="<?php echo $inc_details[0]->case_name; ?>" data-href="<?php echo base_url();?>/auto/get_providercase_type_new?epcr_call_type=<?php echo $epcr_call_type;?>&patient_gender=<?php echo $pt_info[0]->ptn_gender; ?>&patient_gender=<?php echo $pt_info[0]->ptn_gender; ?>" data-qr="" id="provider_casetype1" data-callback-funct="remove_mandatory_fields_new" data-base="save_patient[indx]">
                        </div>
                            <?php
                        }
                    }else{

                        if($user_group == 'UG-BIKE-DCO'){
                            ?>
                            <div class="width_100 float_left base_location">
                              <input name="epcr[indx][provider_casetype]" tabindex="4" class="autocls form_input filter_required" placeholder="Case Type" type="text"  data-errors="{filter_required:'Plase select Case type from dropdown list'}" value="30" data-value="Treatment On Scene" data-href="<?php echo base_url();?>/auto/get_providercase_type_new?epcr_call_type=<?php echo $epcr_call_type;?>&patient_gender=<?php echo $pt_info[0]->ptn_gender; ?>" data-qr="" id="provider_casetype1" data-base="save_patient[indx]">
                          </div>
                            <?php  
                              
                          }else{
                              ?>
                              <div class="width_100 float_left base_location">
                              <input name="epcr[indx][provider_casetype]" tabindex="4" class="autocls form_input filter_required" placeholder="Case Type" type="text"  data-errors="{filter_required:'Plase select Case type from dropdown list'}" value="30" data-value="Treatment On Scene" data-href="<?php echo base_url();?>/auto/get_providercase_type_new?epcr_call_type=<?php echo $epcr_call_type;?>&patient_gender=<?php echo $pt_info[0]->ptn_gender; ?>&patient_gender=<?php echo $pt_info[0]->ptn_gender; ?>" data-qr="" id="provider_casetype" data-callback-funct="" data-base="save_patient[indx]">
                          </div>
                              <?php
                          }
                    }
                    ?>
                        <div class="form_field width100 float_left hide" id='provider_casetype_other'>
                    <div class="style6 float_left">Other Case Type :</div>
                    <div class="width50 float_left base_location">
                    <input name="epcr[indx][provider_casetype_other]" id="provider_casetype_other_text"   class="form_input" placeholder="Other Case Type"  type="text" value="<?php echo @$inc_details[0]->provider_casetype_other; ?>" tabindex="6" data-errors="{filter_required:'should not be blank!'}" data-base="save_patient[indx]">
                    </div>
                </div> 
                    </div>
                    <div class="width_10 drg float_left">
    
                        <div class="width_100 float_left base_location">
                            <input name="epcr[indx][provider_impressions]" tabindex="4" class="autocls form_input filter_required" placeholder="Provider Impressions" type="text"  data-errors="{filter_required:'Plase select provider from dropdown list'}"  value="<?php echo @$inc_details[0]->provider_impressions; ?>" data-value="<?php echo @$inc_details[0]->pro_name; ?>" data-href="<?php echo base_url();?>/auto/get_provider_imp_new?epcr_call_type=<?php echo $epcr_call_type;?>&patient_gender=<?php echo $pt_info[0]->ptn_gender; ?>" data-qr="" id="provider_impressions" data-callback-funct="remove_mandatory_fields" placeholder="Provider Impressions" data-base="save_patient[indx]">
                        </div>
                    </div>
        <div class="width_10 drg float_left">
    
                        <div class="width_100 float_left base_location">
                           <input name="save_patient[indx]" value="Save" class="style3 base-xhttp-request" data-href="<?php echo base_url();?>pcr/save_onscene_add_patient_details" data-qr="output_position=content" type="button">
                        </div>
                    </div>
            <div></div>

        </div>
        </div>
        </div>

<div class="save_btn_wrapper float_left">


<!--        <input type="button" name="save_all_patient" value="Save All Patient" class="accept_btn form-xhttp-request" data-href='<?php echo base_url(); ?>/pcr/save_onscene_add_patient_details' data-qr="output_position=pat_details_block&showprocess=yes&reopen=<?php echo $reopen;?>"  tabindex="25">-->


    </div>
<?php }else{ ?>
    <span><?php echo $pt_count_ero;?> Patient Already added</span>    
<?php } ?>
</form>
