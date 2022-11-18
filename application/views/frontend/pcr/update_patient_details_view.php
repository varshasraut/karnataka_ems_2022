<script>
if(typeof H != 'undefined'){
   // init_auto_address();
}

</script>

<?php
$CI = EMS_Controller::get_instance();

$bgtype[$ptn[0]->ptn_bgroup_type] = "selected='selected'";

$rtncrd[$ptn[0]->ptn_ration_card] = "checked=''";
?>

<div class="head_outer"><h3 class="txt_clr2 width1">PATIENT INFORMATION</h3> </div>

<form method="post" name="" id="patient_info">


    <input type="hidden" name="ptn_id" value="<?php echo trim($ptn_id); ?>">
    <input type="hidden" name="p_id" value="<?php echo trim($ptn_id); ?>">

    <input type="hidden" name="inc_id" value="<?php echo $inc_id; ?>">
    <input type="hidden" name="inc_ref_id" value="<?php echo $inc_id; ?>">



    <div class="epcr_patient">

        <div class="width100 patient_blk display_inlne_block">
            <div class="single_record_back">                                     
                <h3>Patient Information  </h3>
            </div>
            <!--<div class="style6">Patient Information<span class="md_field">*</span></div>-->

            <div class="add_pat_width float_left" data-activeerror="">
                <input name="ptn[ptn_fname]" value="<?php echo $ptn[0]->ptn_fname; ?>" class="filter_required ucfirst_letter filter_words" tabindex="1" data-base="" type="text" placeholder="First Name*"  data-errors="{filter_required:'Patient Name should not blank',filter_words:'First name not allowed number,spaces and special characters.'}">
            </div>



            <div class="add_pat_width">

                <input name="ptn[ptn_lname]" value="<?php echo $ptn[0]->ptn_lname; ?>" class=" " tabindex="3" data-base="" type="text" placeholder="Last Name" >

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


            <div id= "ptn_age_outer" class="add_pat_width">

                <input name="ptn[ptn_age]"  onkeyup="this.value=this.value.replace(/[^\d]/,'')" value="<?php echo $ptn[0]->ptn_age; ?>" class="filter_required  filter_rangelength[0-120]" tabindex="4" data-base="" type="text" placeholder="Age" data-errors="{filter_required:'Age should not blank',filter_rangelength:'Age should be 0 to 120',filter_words:'Store name not allowed number,spaces and special characters.'}">

                    </div>

                  
    <div id= "ptn_age_outer" class="add_pat_width">

<select id="ptn_age_type" name="ptn[ptn_age_type]">
<option selected value="Year" >Year</option>
<option value="Month">Month</option>
<option value="Day">Day</option>
</select>
    </div>

            <div class="add_pat_width">
                <select name="ptn[ptn_gender]" class="filter_required"  data-errors="{filter_required:'Please select gender'}" data-base="" tabindex="6">
                    <option value="">Gender</option>

                    <?php echo get_gen_type($ptn[0]->ptn_gender); ?>

                </select>
            </div>

            <div class="add_pat_width">
                <input name="ptn[ayushman_id]" value="<?php echo $ptn[0]->ayushman_id; ?>" class="" tabindex="3" data-base="" type="text" placeholder="Ayushman ID" >
            </div>
            
            <div class="add_pat_width">
                <select name="ptn[ptn_bgroup]"    data-base="" tabindex="6">
               
                <?php 
                if($ptn[0]->ptn_bgroup != ' '){
                    ?>
                    <option value="<?php echo $ptn[0]->ptn_bgroup; ?>"><?php echo get_blood_group_name($ptn[0]->ptn_bgroup); ?></option> 
                    <?php 
                }else{
                    ?>
                     <option value="">Blood Group</option>
                    <?php
                }
                ?>
                
                <?php foreach ($blood_gp as $bg) {
                    echo '<option value="' . $bg->bldgrp_id . '">' . $bg->bldgrp_name . '</option>';
                }
                ?>
            </select>
            </div>
            <div class="add_pat_width" data-activeerror="">
                <input name="ptn[ptn_opd_id]" value="<?php echo $ptn[0]->ptn_opd_id; ?>" class="" tabindex="1" data-base="" type="text" placeholder="OPD ID"  >
            </div>
            <div class="add_pat_width" data-activeerror="">
                <input name="ptn[ptn_pcf_no]" value="<?php echo $ptn[0]->ptn_pcf_no; ?>" class="" tabindex="1" data-base="" type="text" placeholder="PCF NO"  >
            </div>
            </div>


        
    </div>
   


<div class="save_btn_wrapper float_left">


        <input type="button" name="save_all_patient" value="Save Patient" class="accept_btn form-xhttp-request" data-href='<?php echo base_url(); ?>/pcr/save_add_patient_details' data-qr="output_position=pat_details_block&showprocess=yes&reopen=<?php echo $reopen;?>"  tabindex="25">


    </div>

</form>
