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



    <div class="half_div_left epcr">

        <div class=" display_inlne_block">
            <div class="single_record_back">                                     
                <h3>Patient Information  </h3>
            </div>
            <!--<div class="style6">Patient Information<span class="md_field">*</span></div>-->

            <div class="pat_width float_left" data-activeerror="">
                <input name="ptn[ptn_fname]" value="<?php echo $ptn[0]->ptn_fname; ?>" class="filter_required" tabindex="1" data-base="" type="text" placeholder="Full Name*"  data-errors="{filter_required:'Patient Name should not blank'}">
            </div>


            <div class="pat_width">
                <input name="ptn[ptn_mname]" value="<?php echo $ptn[0]->ptn_mname; ?>" class="" tabindex="2" data-base="" type="text" placeholder="Middle Name" data-errors="{filter_required:'Middle name should not blank'}">

            </div>

            <div class="pat_width">

                <input name="ptn[ptn_lname]" value="<?php echo $ptn[0]->ptn_lname; ?>" class="filter_required" tabindex="3" data-base="" type="text" placeholder="Last Name*" data-errors="{filter_required:'Last name should not blank'}">

            </div>

            <div id= "ptn_age_outer" class="pat_width">

                <input name="ptn[ptn_age]"  value="<?php echo $ptn[0]->ptn_age; ?>" class="filter_required" tabindex="4" data-base="" type="text" placeholder="Age*" data-errors="{filter_required:'Age should not blank'}">

            </div>

            <?php
            if ($ptn[0]->ptn_birth_date) {

                $ptn_bd = explode(" ", $ptn[0]->ptn_birth_date);

                $ptn_bd = date('d-m-Y', strtotime($ptn_bd[0]));
            }
            ?>

            <div class="pat_width">

                <input id= "ptn_dob" data-fname="ptn[ptn_age]"  name="ptn[ptn_birth_date]" value="<?php echo $ptn_bd; ?>" class="mi_cur_date" tabindex="5" data-base="" type="text" placeholder="DOB:yyyy-mm-dd" >

            </div>

            <div class="pat_width">
                <select name="ptn[ptn_gender]" class="filter_required"  data-errors="{filter_required:'Please select gender'}" data-base="" tabindex="6">
                    <option value="">Gender</option>

                    <?php echo get_gen_type($ptn[0]->ptn_gender); ?>

                </select>
            </div>

        </div>

        <div class="width100 display_inlne_block">
          <div class="width50 float_left drg">
                        
                <div class=" width33 float_left style6">Occupation</div>
                <div  class=" width_60 float_left input" data-activeerror="">
                    <input  name="ptn[ptn_occupation]" value="<?php echo $ptn[0]->ptn_occupation; ?>" class="mi_autocomplete width97" data-href="<?php echo base_url(); ?>auto/pet_occup" data-errors="" data-base="" tabindex="7" data-value="<?php echo $ptn[0]->occ_type; ?>" data-nonedit="yes">                    </select>
                </div>

         
                        </div>
            <div class="width50 float_left drg">
                       
                <div class=" width_40 float_left style6">Blood Group</div>
                <div  class=" width_60 float_left input" data-activeerror="">
                    <div class="bld_grp_lft">
                <div id="purpose_of_calls" class="input" data-activeerror="">


                    <select name="ptn[ptn_bgroup]" class=""  data-errors="" data-base="" tabindex="8">
                        <option value="">Select</option>
                        <?php echo get_bgroup($ptn[0]->ptn_bgroup); ?>

                    </select>


                </div>

            </div>



            <div class="bld_grp_rt">

                <div id="purpose_of_calls" class="input" data-activeerror="">


                    <select name="ptn[ptn_bgroup_type]" class=""  data-base="" tabindex="9">
                        <option value="">Select</option>

                        <option value="p" <?php echo $bgtype['p']; ?>>+VE</option>

                        <option value="n" <?php echo $bgtype['n']; ?>>-VE</option>

                    </select>


                </div>

            </div>
                </div>

         
                        </div>
<!--            <div class="ocupation">
                <div class="style6">Occupation</div>
                <div  class="input" data-activeerror="">
                    <input  name="ptn[ptn_occupation]" value="<?php echo $ptn[0]->ptn_occupation; ?>" class="mi_autocomplete width97" data-href="<?php echo base_url(); ?>auto/pet_occup" data-errors="" data-base="" tabindex="7" data-value="<?php echo $ptn[0]->occ_type; ?>" data-nonedit="yes">                    </select>
                </div>

            </div>-->

<!--
            <div class="style6">Blood Group</div>

            <div class="bld_grp_lft">
                <div id="purpose_of_calls" class="input" data-activeerror="">


                    <select name="ptn[ptn_bgroup]" class=""  data-errors="" data-base="" tabindex="8">
                        <option value="">Select</option>
                        <?php echo get_bgroup($ptn[0]->ptn_bgroup); ?>

                    </select>


                </div>

            </div>



            <div class="bld_grp_rt">

                <div id="purpose_of_calls" class="input" data-activeerror="">


                    <select name="ptn[ptn_bgroup_type]" class=""  data-base="" tabindex="9">
                        <option value="">Select</option>

                        <option value="p" <?php echo $bgtype['p']; ?>>+VE</option>

                        <option value="n" <?php echo $bgtype['n']; ?>>-VE</option>

                    </select>


                </div>

            </div>-->


        </div>

        <div class="iden_mark">

            <div class="width33 float_left style6">Identification Mark</div>

            <div class="width33 float_left">

                <div id="purpose_of_calls" class="input">
                    <input name="ptn[ptn_id_mark1]" value="<?php echo $ptn[0]->ptn_id_mark1; ?>" class="" tabindex="10" data-base="" type="text" placeholder="Mark 1"  data-errors="">

                </div>

            </div>

            <div class="width33 float_left">

                <div id="purpose_of_calls" class="input">


                    <input name="ptn[ptn_id_mark2]" value="<?php echo $ptn[0]->ptn_id_mark2; ?>" class="" tabindex="11" data-base="" type="text" placeholder="Mark 2 " data-errors="">


                </div>

            </div>

        </div>
    </div>


    <div class="half_div_right">


        <div class="display_inlne_block width100">

            <div class="width50 float_left">

                <div class="style6">Adhaar No</div>

                <div id="purpose_of_calls" class="input">
                    <input name="ptn[ptn_adhar_no]" value="<?php echo (strlen($ptn[0]->ptn_adhar_no) > 11) ? $ptn[0]->ptn_adhar_no : ""; ?>" class="filter_if_not_blank filter_minlength[11] filter_maxlength[13]" tabindex="12" data-base="" type="text" data-errors="{filter_minlength:'Adhar number should be at least 12 digit long',filter_maxlength:'Adhar number should be 12 digit long'}">

                </div>

            </div>

            <div class="width50 float_left">

                <div class="style6">Ration Card</div>

                <div class="display_inlne_block width100">

                    <label for="ptrcy" class="radio_check float_left width33">


                        <input type="radio" name="ptn[ptn_ration_card]" id="ptrcy" value="yellow" class="radio_check_input" tabindex="13" data-errors="" <?php echo $rtncrd['yellow']; ?>>

                        <span class="radio_check_holder"></span>Yellow


                    </label>

                    <label for="ptrcs" class="radio_check float_left width33">


                        <input type="radio" id="ptrcs" name="ptn[ptn_ration_card]" value="saffron" class="radio_check_input" class="radio_check_input filter_either_or[ptrcy,ptrcs,ptrcw]" tabindex="14" data-errors=""  <?php echo $rtncrd['saffron']; ?>>

                        <span class="radio_check_holder"></span>Saffron


                    </label>


                    <label for="ptrcw" class="radio_check width33 float_right">


                        <input type="radio" id="ptrcw" name="ptn[ptn_ration_card]" value="white" class="radio_check_input" class="radio_check_input filter_required" tabindex="15" data-errors="" <?php echo $rtncrd['white']; ?>>

                        <span class="radio_check_holder"></span>White


                    </label>
                </div>

            </div>

        </div>


        <div class="row display_inlne_block">

            <div class="style6">Patient Information<span class="md_field">*</span></div>

            <div class="outer_address float_left">   
                <?php
                if (empty($ptn[0]->ptn_address)) {
                    $ptn_address = $inc['ptn_address'];
                } else {
                    $ptn_address = $ptn[0]->ptn_address;
                }
                ?>
                <input name="ptn[ptn_address]" value="<?php echo $ptn_address; ?>" id="pac-input" class="ptn_dtl filter_required"  data-errors="{filter_required:'Address should not be blank'}"tabindex="16" type="text" placeholder="Google location map address" data-state="yes" data-dist="yes" data-city="yes" data-area="yes" data-lmark="yes" data-lane="yes" data-pin="yes" data-rel="ptn_dtl" data-auto="ptn_auto_addr"> 

            </div>


            <div class="pat_width" data-activeerror="">

                <div id="ptn_dtl_state">

                    <?php
                    if (empty($ptn[0]->ptn_state)) {
                        $state = $inc['ptn_state'];
                    } else {
                        $state = $ptn[0]->ptn_state;
                    }

                    $st = array('st_code' => $state, 'auto' => 'ptn_auto_addr', 'rel' => 'ptn_dtl', 'disabled' => '');

                    echo get_state($st);
                    ?>

                </div>


            </div>


            <div class="pat_width">

                <div id="ptn_dtl_dist">
                    <?php
                    if (empty($ptn[0]->ptn_district)) {
                        $ptn_district = $inc['ptn_district'];
                    } else {
                        $ptn_district = $ptn[0]->ptn_district;
                    }

                    $dt = array('dst_code' => $ptn_district, 'st_code' => $state, 'auto' => 'ptn_auto_addr', 'rel' => 'ptn_dtl', 'disabled' => '');

                    echo get_district($dt);
                    ?>



                </div>

            </div>

            <div class="pat_width">

                <div id="ptn_dtl_city">      

                    <?php
                    if (empty($ptn[0]->ptn_city)) {
                        $ptn_city = $inc['ptn_city'];
                    } else {
                        $ptn_city = $ptn[0]->ptn_city;
                    }

                    $ct = array('cty_id' => $ptn_city, 'dst_code' => $ptn_district, 'auto' => 'ptn_auto_addr', 'rel' => 'ptn_dtl', 'disabled' => '');
                    echo get_city($ct);
                    ?>


                </div>

            </div>


            <div class="pat_width" id="ptn_dtl_area">
                <input name="ptn_dtl_area" value="<?php echo $ptn[0]->ptn_area; ?>" class="auto_area" data-base="" type="text" placeholder="Area/Location" tabindex="20">

            </div>

            <div class="pat_width" id="ptn_dtl_lmark">

                <input name="ptn_dtl_lmark" value="<?php echo $ptn[0]->ptn_landmark; ?>" class="auto_lmark" data-base="" type="text" placeholder="Landmark" tabindex="21">

            </div>

            <div class="pat_width" id="ptn_dtl_lane">            
                <input name="ptn_dtl_lane" value="<?php echo $ptn[0]->ptn_lane; ?>" class="auto_lane" data-base="" type="text" placeholder="Lane/Street" tabindex="22">
            </div>





        </div>

        <div class="pin_house">

            <div class="pat_width" id="ptn_dtl_hno">            
                <input name="ptn_dtl_hno" value="<?php echo $ptn[0]->ptn_house_no; ?>" class="auto_hno" data-base="" type="text" placeholder="House Number" tabindex="23">
            </div>
            <div class="pat_width" id="ptn_dtl_pcode">            
                <input name="ptn_dtl_pincode" value="<?php echo $ptn[0]->ptn_pincode; ?>" class="auto_pcode" data-base="" type="text" placeholder="Pincode" tabindex="24">
            </div> 

        </div>

        <div class="float_right">

            <div class="map_logo float_right"></div>

        </div>


    </div>






    <div class="width100 float_left">


        <input value="<?php echo $ptn[0]->ptn_ltd; ?>" id="drag" class="map_drag_edit" data-errors="{filter_required:'Move Drag Location'}" type="hidden">


        <div class="map_box">

            <div id="googleMap" class="load_googleMap" style="width: 100%; height: 250px; background: #5A8E4A; "></div>



            <script>
                var i = 0;
                var drag;
                if (i == 0) {

                    setTimeout(function () { 
                        var map_obj = document.getElementById('googleMap');
                        console.log(i);
                        

<?php
if ($ptn[0]->ptn_ltd && $ptn[0]->ptn_lng) {

    $lat = $ptn[0]->ptn_ltd;
    $lng = $ptn[0]->ptn_lng;
} else if ($inc['ptn_ltd'] && $inc['ptn_lng']) {
    $lat = $inc['ptn_ltd'];
    $lng = $inc['ptn_lng'];
} else {
    $lat = 18.5204;
    $lng = 73.8567;
}
?>

                        var ltlng = {lat:<?= $lat ?>, lng:<?= $lng ?>};

                        initMap(ltlng, map_obj);


                    }, 1000);

                    i++;
                }
            </script>



            <input type="hidden" name="ptn[ptn_ltd]" value="<?php echo $lat; ?>" id="lttd" class="">

            <input type="hidden" name="ptn[ptn_lng]" value="<?php echo $lng; ?>" id="lgtd" class="">    




        </div>


    </div>



    <div class="save_btn_wrapper float_left">


        <input type="button" name="accept" value="Accept" class="accept_btn form-xhttp-request" data-href='<?php echo base_url(); ?>medadv/ercp_save_patient_details' data-qr="output_position=pat_details_block&showprocess=yes"  tabindex="25">


    </div>

    <div class="width100 float_left">
        <br>
    </div>



</form>
