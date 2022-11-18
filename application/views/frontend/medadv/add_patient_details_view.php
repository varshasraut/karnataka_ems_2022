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
            <div class="add_pat_width float_left" data-activeerror="">
                <input name="ptn[0][ptn_fname]" value="<?php echo $ptn[0]->ptn_fname; ?>" class="filter_required ucfirst_letter filter_words" tabindex="1" data-base="" type="text" placeholder="First Name*"  data-errors="{filter_required:'Patient Name should not blank',filter_words:'First name not allowed number,spaces and special characters.'}">
            </div>




            <div class="add_pat_width">

                <input name="ptn[0][ptn_lname]" value="<?php echo $ptn[0]->ptn_lname; ?>" class="filter_required ucfirst_letter filter_words" tabindex="3" data-base="" type="text" placeholder="Last Name*" data-errors="{filter_required:'Last name should not blank',filter_words:'Last name not allowed number,spaces and special characters.'}">

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

                <input name="ptn[0][ptn_age]"  onkeyup="this.value=this.value.replace(/[^\d]/,'')" value="<?php echo $ptn[0]->ptn_age; ?>" class="filter_required filter_rangelength[0-120]" tabindex="4" data-base="" type="text" placeholder="Age" data-errors="{filter_required:'Age should not blank',filter_rangelength:'Age should be 0 to 120'}">

                    </div>
                    <div id= "ptn_age_outer" class="add_pat_width">

                <select id="ptn_age_type" name="ptn[0][ptn_age_type]">
                <option value="Year" >Year</option>
                <option value="Month">Month</option>
                <option value="Day">Day</option>
                </select>
                    </div>
           

            <div class="add_pat_width">
                <select name="ptn[0][ptn_gender]" class="filter_required"  data-errors="{filter_required:'Please select gender'}" data-base="" tabindex="6">
                    <option value="">Gender</option>

                    <?php echo get_gen_type($ptn[0]->ptn_gender); ?>

                </select>
            </div>
            <div class="add_pat_width">
                <input name="ptn[0][ayushman_id]" value="<?php echo $ptn[0]->ayushman_id; ?>" class="" tabindex="3" data-base="" type="text" placeholder="Ayushman ID" >
            </div>
            <div class="add_pat_width">
                <select name="ptn[0][ptn_bgroup]"    data-base="" tabindex="6">
                <option value="">Blood Group</option>
                <?php
                foreach ($blood_gp as $bg) {
                    echo '<option value="' . $bg->bldgrp_id . '">' . $bg->bldgrp_name . '</option>';
                }
                ?>
            </select>
            </div>
            <div class="add_pat_width float_left" data-activeerror="">
                <input name="ptn[0][ptn_opd_id]" value="<?php echo $ptn[0]->ptn_opd_id; ?>" class="" tabindex="1" data-base="" type="text" placeholder="OPD ID"  >
            </div>
            <div class="add_pat_width float_left" data-activeerror="">
                <input name="ptn[0][ptn_pcf_no]" value="<?php echo $ptn[0]->ptn_pcf_no; ?>" class="" tabindex="1" data-base="" type="text" placeholder="PCF NO"  >
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
            <div class="add_pat_width float_left" data-activeerror="">
                <input name="ptn[indx][ptn_fname]" value="" class="flt_reg fil_wo" tabindex="1" data-base="" type="text" placeholder="Full Name*"  data-errors="{filter_required:'Patient Name should not blank',filter_words:'First name not allowed number,spaces and special characters.'}">
            </div>




            <div class="add_pat_width">

                <input name="ptn[indx][ptn_lname]" value="" class="flt_reg fil_wo" tabindex="3" data-base="" type="text" placeholder="Last Name*" data-errors="{filter_required:'Last name should not blank',filter_words:'Last name not allowed number,spaces and special characters.'}">

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

                <input name="ptn[indx][ptn_age]"  onkeyup="this.value=this.value.replace(/[^\d]/,'')" value="" class="flt_reg filter_rangelength[0-120]" tabindex="4" data-base="" type="text" placeholder="Age" data-errors="{filter_required:'Age should not blank',filter_rangelength:'Age should be 0 to 120'}">

                    </div>
                  
    <div id= "ptn_age_outer" class="add_pat_width">

<select id="ptn_age_type" name="ptn[indx][ptn_age_type]">
<option value="Year" >Year</option>
<option value="Month">Month</option>
<option value="Day">Day</option>
</select>
    </div>
           

            <div class="add_pat_width">
                <select name="ptn[indx][ptn_gender]" class="flt_reg"  data-errors="{filter_required:'Please select gender'}" data-base="" tabindex="6">
                    <option value="">Gender</option>

                    <?php echo get_gen_type($ptn[0]->ptn_gender); ?>

                </select>
            </div>
            <div class="add_pat_width">
                <input name="ptn[indx][ayushman_id]" value="<?php echo $ptn[0]->ayushman_id; ?>" class="" tabindex="3" data-base="" type="text" placeholder="Ayushman ID" >
            </div>
            <div class="add_pat_width">
                <select name="ptn[indx][ptn_bgroup]"    data-base="" tabindex="6">
                <option value="">Blood Group</option>
                <?php
                foreach ($blood_gp as $bg) {
                    echo '<option value="' . $bg->bldgrp_id . '">' . $bg->bldgrp_name . '</option>';
                }
                ?>
            </select>
            </div>
            <div class="add_pat_width" data-activeerror="">
                <input name="ptn[indx][ptn_opd_id]" value="<?php echo $ptn[0]->ptn_opd_id; ?>" class="" tabindex="1" data-base="" type="text" placeholder="OPD ID"  >
            </div>
            <div class="add_pat_width" data-activeerror="">
                <input name="ptn[indx][ptn_pcf_no]" value="<?php echo $ptn[0]->ptn_pcf_no; ?>" class="" tabindex="1" data-base="" type="text" placeholder="PCF No"  >
            </div>
            <div><a class="remove_patient_more btn" style="margin-right:30px; padding: 5px 5px;">Remove</a></div>

        </div>
        </div>
        </div>

<div class="save_btn_wrapper float_left">


        <input type="button" name="save_all_patient" value="Save All Patient" class="accept_btn form-xhttp-request" data-href='<?php echo base_url(); ?>/medadv/ercp_save_patient_details' data-qr="output_position=pat_details_block&showprocess=yes&reopen=<?php echo $reopen;?>"  tabindex="25">


    </div>
<?php }else{ ?>
    <span><?php echo $pt_count_ero;?> Patient Already added</span>    
<?php } ?>
</form>

<style>
    .add_pat_width{
        width: 12.50% !important;
    float: left;
    }
</style>
