<?php
$view = ($amb_action == 'view') ? 'disabled' : '';

if ($amb_action == 'edit') {
    $edit = 'disabled';
}

$CI = EMS_Controller::get_instance();

$title = ($amb_action == 'edit') ? " Edit Ambulance Details " : (($amb_action == 'view') ? "View Ambulance Details" : "Add Ambulance Details");
?>


<script>
    if (typeof H != 'undefined') {
        init_auto_address();
    }
</script>
<form enctype="multipart/form-data" action="#" method="post" id="usr_ad_form">
    <div class="register_outer_block">

        <div class="box3">


            <div class="width1 float_left ">
                <h2 class="txt_clr2 width1 txt_pro"><?php echo $title; ?></h2>
                <div class="store_details_box">
                    <div class="field_row width100">
                        <div class="width2 float_left">
                            <div class="field_lable float_left width33"> <label for="registration_number">Registration Number<span class="md_field">*</span></label></div>

                            <div class="filed_input float_left width50">

                                <input type="text" placeholder="Enter Ambulance No e.g AA-12-AA-0101" data-callback-funct="vehical_no" id="amb_validation" name="reg_no" class="filter_required filter_vehical_no" data-errors="{filter_required:'Registration Number should not be blank',filter_vehical_no:'Please enter valid Registration Number'}" value="<?php echo $update[0]->amb_rto_register_no; ?>" tabindex="1" autocomplete="off" <?php echo $view; ?> <?php echo $edit; ?>>


                            </div>
                        </div>
                        <div class="width2 float_left">
                            <div class="filed_lable float_left width33"><label for="amb_number">Ambulance Mobile Number<span class="md_field">*</span></label></div>
                            <div class="filed_input float_left width50 ">
                                <input type="text" name="mb_no" placeholder="Mobile Number" value="<?php echo $update[0]->amb_default_mobile; ?>" onkeyup="this.value=this.value.replace(/[^\d]/,'')" class="filter_required filter_number filter_minlength[9] filter_maxlength[11] filter_no_whitespace" data-errors="{filter_required:'Ambulance Mobile Number should not be blank', filter_number:'Ambulance Mobile Number should be in numeric characters only.', filter_minlength:'Ambulance Mobile Number should be at least 10 digits long',filter_maxlength:'Ambulance Mobile Number should less then 11 digits.',filter_no_whitespace:'Ambulance Mobile Number should not be allowed blank space.', filter_mobile:'Ambulance Mobile Number should be valid.'}" <?php echo $view; ?> TABINDEX="4" >
                            </div>

                        </div>
                    </div>
                    <div class="field_row width100">
                        <div class="width2 float_left">
                            <div class="field_lable float_left width33"> <label for="Pilot_Name">Pilot Name</label></div>

                            <div class="filed_input float_left width50">

                                <input type="text" name="pilot_nm" placeholder="Pilot Name" value="<?php echo $update[0]->pilot_nm; ?>" class="" onkeyup="this.value=this.value.replace(/[^\a-\z\A-\Z]/g,'')"  data-errors="{filter_required:'Pilot Name should not be blank', filter_name:'Pilot Name should be in characters only.'}" tabindex="1" <?php echo $view; ?>>


                            </div>
                        </div>
                        <div class="width2 float_left">
                            <div class="filed_lable float_left width33"><label for="amb_number">Pilot Mobile Number<span class="md_field"></span></label></div>

                            <div class="filed_input float_left width50 ">

                                <input type="text" name="pilot_mb_no" value="<?php echo $update[0]->amb_pilot_mobile; ?>" class="" onkeyup="this.value=this.value.replace(/[^\d]/,'')" data-errors="{filter_required:'Pilot Mobile Number should not be blank', filter_number:'Pilot Mobile Number should be in numeric characters only.', filter_minlength:'Pilot Mobile Number should be at least 10 digits long',filter_maxlength:'Pilot Mobile Number should less then 11 digits.',filter_no_whitespace:'Pilot Mobile Number should not be allowed blank space.', filter_mobile:'Pilot Mobile Number should be valid.'}" <?php echo $view; ?> TABINDEX="4" placeholder="Mobile Number" maxlength="10">

                            </div>

                        </div>

                    </div> <br>
                    <div class="field_row width100">
                        <div class="width2 float_left">
                            <div class="field_lable float_left width33"> <label for="Make">Make<span class="md_field">*</span></label></div>

                            <div class="filed_input float_left width50">

                                <select name="vehical_make" class="filter_required" data-errors="{filter_required:'Please select Make from dropdown list'}" <?php echo $view; ?> TABINDEX="5">

                                    <option value="">Select Make</option>

                                    <option value="Ashok Leyland" <?php if ($update[0]->vehical_make == 'Ashok Leyland') {
                                                                        echo "selected";
                                                                    } ?>>Ashok Leyland</option>
                                    <option value="Force" <?php if ($update[0]->vehical_make == 'Force') {
                                                                echo "selected";
                                                            } ?>>Force</option>
                                    <option value="Bajaj" <?php if ($update[0]->vehical_make == 'Bajaj') {
                                                                echo "selected";
                                                            } ?>>Bajaj</option>
                                    <option value="Ambulance" <?php if ($update[0]->vehical_make == 'Ambulance') {
                                                                    echo "selected";
                                                                } ?>>Ambulance</option>
                                    <option value="Force Traveller" <?php if ($update[0]->vehical_make == 'Force Traveller') {
                                                                        echo "selected";
                                                                    } ?>>Force Traveller</option>
                                    <option value="Tata Winger" <?php if ($update[0]->vehical_make == 'Tata Winger') {
                                                                    echo "selected";
                                                                } ?>>Tata Winger</option>
                                    <option value="LMV Bus" <?php if ($update[0]->vehical_make == 'LMV Bus') {
                                                                echo "selected";
                                                            } ?>>LMV Bus</option>
                                    <option value="Bajaj Tampo" <?php if ($update[0]->vehical_make == 'Bajaj Tampo') {
                                                                    echo "selected";
                                                                } ?>>Bajaj Tampo</option>
                                    <option value="TATA" <?php if ($update[0]->vehical_make == 'TATA') {
                                                                echo "selected";
                                                            } ?>>TATA</option>
                                    <option value="Force Motors" <?php if ($update[0]->vehical_make == 'Force Motors') {
                                                                        echo "selected";
                                                                    } ?>>Force Motors</option>

                                </select>




                            </div>
                        </div>
                        <div class="width2 float_left">
                            <div class="filed_lable float_left width33"><label for="Model">Ambulance Model<span class="md_field">*</span></label></div>

                            <div class="filed_input float_left width50 ">

                                <select name="vehical_model" class="filter_required" data-errors="{filter_required:'Please select Ambulance Model from dropdown list'}" <?php echo $view; ?> TABINDEX="5">

                                    <option value="">Select Ambulance Model</option>

                                    <option value="BS-III" <?php if ($update[0]->vehical_make_type == 'BS-III') {
                                                                echo "selected";
                                                            } ?>>BS-III</option>
                                    <option value="BS-IV" <?php if ($update[0]->vehical_make_type == 'BS-IV') {
                                                                echo "selected";
                                                            } ?>>BS-IV</option>
                                    <option value="BS-VI" <?php if ($update[0]->vehical_make_type == 'BS-VI') {
                                                                echo "selected";
                                                            } ?>>BS-VI</option>
                                </select>

                            </div>

                        </div>

                    </div> <br>


                    <div class="field_row width100">
                        <div class="width2 float_left">
                            <div class="filed_lable float_left width33"><label for="Model">Ambulance Owner<span class="md_field">*</span></label></div>

                            <div class="filed_input float_left width50 ">

                                <select name="amb_owner" id="amb_owner" class="filter_required" data-errors="{filter_required:'Please select Ambulance Owner from dropdown list'}" <?php echo $view; ?> TABINDEX="5">

                                    <option value="">Select Ambulance Owner</option>

                                    <option value="GOVT" <?php if ($update[0]->amb_owner == 'GOVT') {
                                                                echo "selected";
                                                            } ?>>Government</option>
                                    <option value="JAES" <?php if ($update[0]->amb_owner == 'JAES') {
                                                                echo "selected";
                                                            } ?>>JAES</option>
                                    <option value="PVT" <?php if ($update[0]->amb_owner == 'PVT') {
                                                            echo "selected";
                                                        } ?>>Private</option>
                                </select>

                            </div>

                        </div>
                        <div class="width2 float_left">
                            <div class="field_lable float_left width33"><label for="reg_local_address">Working Area<span class="md_field">*</span></label></div>
                            <div class="filed_select float_left filed_input width50">
                                <select name="working_area" class="amb_status filter_required" data-errors="{filter_required:'Working area should not be blank'}" <?php echo $view; ?> TABINDEX="4">
                                    <option value="">Select Area</option>
                                    <?php echo get_area_type($update[0]->amb_working_area); ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="field_row width100">
                        <div class="width2 float_left">
                            <div class="filed_lable float_left width33"><label for="Model">Model (Year)</label></div>
                            <div class="filed_input float_left width50 ">
                                <input type="text" name="model" value="<?php echo $update[0]->vehical_model; ?>" <?php echo $view; ?> TABINDEX="4" placeholder="Enter Model Year" maxlength="4">
                            </div>
                        </div>
                        <div class="width2 float_left">
                            <div class="field_lable float_left width33"><label for="amb_type">Ambulance Type<span class="md_field">*</span></label></div>
                            <div class="field_input float_left width50">
                                <select name="amb_type"  class="filter_required" data-errors="{filter_required:'Please select Ambulance Type from dropdown list'}" <?php echo $view; ?> TABINDEX="5">
                                    <option value="">Select Type</option>

                                    <?php echo get_amb_type($update_data[0]->ambt_name); ?>
                                </select>
                            </div>
                        </div>
                    </div><br>
                    <div class="field_row width100">
                        <div class="width2 float_left">
                            <div class="field_lable float_left width33"><label for="amb_cat">Ambulance Thirdparty<span class="md_field">*</span></label></div>

                            <div class="field_input float_left width50">
                                <select name="amb_cat" id="amb_type" class="filter_required" placeholder="Ambulance Thirdparty" data-errors="{filter_required:'Please select Ambulance Thirdparty  from dropdown list'}" <?php echo $view; ?> TABINDEX="5">
                                <option value="">Select Ambulance Thirdparty</option>
                                <?php echo get_third_party($update[0]->thirdparty); ?>
                                </select>
                            </div>

                        </div>
                        <div class="width2 float_left">
                            <div class="field_lable float_left width33"><label for="ambis_backup">Backup Ambulance<span class="md_field">*</span></label></div>

                            <div class="field_input float_left width50">
                                <select name="ambis_backup" class="filter_required" data-errors="{filter_required:'Please select Backup Ambulance from dropdown list'}" <?php echo $view; ?> TABINDEX="5">

                                    <option value="">Select Type</option>

                                    <option value="0" <?php if ($update[0]->ambis_backup == '0') {
                                                            echo "selected";
                                                        } ?>>No</option>
                                    <option value="1" <?php if ($update[0]->ambis_backup == '1') {
                                                            echo "selected";
                                                        } ?>>Yes</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="field_row width100">
                        <div class="width2 float_left" id="vendor" <?php if($update[0]->thirdparty != '2'){echo 'style="display:none;"';} ?>>
                            <div class="field_lable float_left width33"><label for="amb_vendor">Ambulance Vendor<span class="md_field">*</span></label></div>

                            <div class="field_input float_left width50">
                                <select name="amb_vendor" id="amb_vendor" class="filter_required" data-errors="{filter_required:'Please select Ambulance Vendor from dropdown list'}" <?php echo $view; ?> TABINDEX="5">

                                    <option value="">Select Ambulance Vendor</option>

                                    <?php echo get_amb_vendor($update[0]->amb_vendor); ?>
                                </select>
                            </div>
                        </div>
                        
                    </div>

                    <div class="field_row width100">
                        <div class="width2 float_left">
                            <div class="field_lable float_left width33"><label for="ambis_backup">Ambulance Serial No<span class="md_field">*</span></label></div>

                            <div class="field_input float_left width50">
                                <input type="text" name="amb_serial_no" value="<?php echo $update[0]->amb_serial_number; ?>" class="filter_required" TABINDEX="4" placeholder="Ambulance Serial No" data-errors="{filter_required:'Ambulance Serial No should not be blank.'}" <?php echo $view; ?>>
                            </div>
                        </div>
                        <div class="width2 float_left">
                            <div class="filed_lable float_left width33"><label for="amb_supervisor">Ambulance Supervisor<span class="md_field"></span></label></div>
                            <div class="filed_input float_left width50 ">
                                <?php 
                                    if($update[0]->amb_supervisor == ' '){
                                        $amb_supervisor = 'NA';
                                    }else{
                                        $amb_supervisor = $update[0]->amb_supervisor;
                                    }
                                 ?>
                                <input type="search" name="amb_supervisor" class="mi_autocomplete" data-href="<?php echo base_url(); ?>auto/get_auto_clg?clg_group=UG-DM" data-value="<?= $amb_supervisor; ?>" value="<?= $amb_supervisor; ?>" type="text" tabindex="1" data-errors="{filter_required:'Please select Ambulance supervisor from dropdown list'}" placeholder="Ambulance Supervisor" <?php echo $view; ?>>
                            </div>
                        </div>
                    </div>
                    <div class="field_row width100">
                        <div class="width2 float_left">
                            <div class="field_lable float_left width33"><label for="ambis_backup">Ambulance System Type<span class="md_field">*</span></label></div>

                            <div class="field_input float_left width50">
                                <select name="amb_sys_type" class="filter_required" data-errors="{filter_required:'Please select Ambulance System Type from dropdown list'}" <?php echo $view; ?> TABINDEX="5" onchange="showVendor();">

                                    <option value="">Select Type</option>

                                    <option value="108" <?php if ($update[0]->amb_user_type == '108') {
                                                            echo "selected";
                                                        } ?>>108</option>
                                    <option value="102" <?php if ($update[0]->amb_user_type == '102') {
                                                            echo "selected";
                                                        } ?>>JE [Janani Express]</option>
                                </select>
                            </div>
                        </div>
                        <div class="width2 float_left">
                            <div class="field_lable float_left width33"><label for="">Ambulance Category<span class="md_field">*</span></label></div>

                            <div class="filed_input  float_left width50 ">
                                <select name="amb_category" class="filter_required" tabindex="8" data-errors="{filter_required:'Ambulance Category should not blank'}" <?php echo $view; ?>>
                                    <option value="">Select System Type</option>
                                    <option value="A" <?php if ($update[0]->amb_category  == 'A') {
                                                            echo "selected";
                                                        } ?>>A</option>
                                    <option value="B" <?php if ($update[0]->amb_category  == 'B') {
                                                            echo "selected";
                                                        } ?>>B</option>
                                    <option value="C" <?php if ($update[0]->amb_category  == 'C') {
                                                            echo "selected";
                                                        } ?>>C</option>
                                    <option value="D" <?php if ($update[0]->amb_category  == 'D') {
                                                            echo "selected";
                                                        } ?>>D</option>
                                </select>
                            </div>
                        </div>
                    </div>                 

                    <div class="field_row width100">
                        <div class="width2 float_left">
                            <div class="field_lable float_left width33"><label for="ambis_backup">Ambulance GPS IMEI No<span class="md_field">*</span></label></div>
                            <div class="field_input float_left width50">
                                <input type="text" name="amb_gps_imei_no" value="<?php echo $update[0]->amb_gps_imei_no; ?>" TABINDEX="4" class="filter_required filter_number" placeholder="Ambulance GPS IMEI No" data-errors="{filter_required:'Ambulance GPS IMEI No should not be blank.', filter_number:'Ambulance GPS IMEI No should be in numeric only.'}" <?php echo $view; ?>>
                            </div>
                        </div>
                        <div class="width2 float_left">
                            <div class="field_lable float_left width33"><label for="ambis_backup">Ambulance GPS SIM No<span class="md_field">*</span></label></div>
                            <div class="field_input float_left width50">
                                <input type="text" name="amb_gps_sim_no" value="<?php echo $update[0]->amb_gps_sim_no; ?>" TABINDEX="4" class="filter_required filter_number" placeholder="Ambulance GPS SIM No" data-errors="{filter_required:'Ambulance GPS SIM No should not be blank.', filter_number:'Ambulance GPS SIM No should be in numeric only.'}" <?php echo $view; ?>>
                            </div>
                        </div>
                    </div>

                    <div class="field_row width100">
                        <div class="width2 float_left">
                            <div class="field_lable float_left width33"><label for="ambis_backup">Ambulance MDT Serial No<span class="md_field">*</span></label></div>
                            <div class="field_input float_left width50">
                                <input type="text" name="amb_mdt_srn_no" value="<?php echo $update[0]->amb_mdt_srn_no; ?>" TABINDEX="4" class="filter_required" placeholder="Ambulance MDT Serial No" data-errors="{filter_required:'Ambulance MDT Serial No should not be blank.'}" <?php echo $view; ?>>
                            </div>
                        </div>
                        <div class="width2 float_left">
                            <div class="field_lable float_left width33"><label for="ambis_backup">Ambulance MDT IMEI No<span class="md_field">*</span></label></div>
                            <div class="field_input float_left width50">
                                <input type="text" name="amb_mdt_imei_no" value="<?php echo $update[0]->amb_mdt_imei_no; ?>" TABINDEX="4" class="filter_required" placeholder="Ambulance MDT IMEI No" data-errors="{filter_required:'Ambulance MDT IMEI No should not be blank.'}" <?php echo $view; ?>>
                            </div>
                        </div>
                    </div>

                    <div class="field_row width100">
                        <div class="width2 float_left">
                            <div class="field_lable float_left width33"><label for="ambis_backup">Ambulance MDT SIM Contact No<span class="md_field">*</span></label></div>
                            <div class="field_input float_left width50">
                                <!-- <input type="text" name="amb_mdt_simcnt_no" value="<?php echo $update[0]->amb_mdt_simcnt_no; ?>" TABINDEX="4" class="filter_required" placeholder="Ambulance MDT SIM Contact No" data-errors="{filter_required:'Ambulance MDT SIM Contact No should not be blank.'}" <?php echo $view; ?>> -->
                                <input type="text" name="amb_mdt_simcnt_no" value="<?php echo $update[0]->amb_mdt_simcnt_no; ?>" TABINDEX="4" onkeyup="this.value=this.value.replace(/[^\d]/,'')" class="filter_required filter_number filter_minlength[9] filter_maxlength[11]" placeholder="Ambulance MDT SIM Contact No" data-errors="{filter_required:'Ambulance MDT SIM Contact No should not be blank.',filter_number:'Ambulance MDT SIM Contact No should be in numeric only.', filter_minlength:'Ambulance MDT SIM Contact No should be at least 10 digits long',filter_maxlength:'Ambulance MDT SIM Contact No should less then 11 digits.'}" <?php echo $view; ?>  maxlength="10">
                            </div>
                        </div> 
                        <div class="width2 float_left">
                            <div class="field_lable float_left width33"><label for="district">Base Location<span class="md_field">*</span></label></div>
                            <div class="filed_input float_left width50" id="amb_base_location">
                                <input name="base_location" tabindex="23" class="form_input filter_required mi_autocomplete" placeholder="Base Location" type="text" data-base="search_btn" data-value="<?= $update[0]->hp_name; ?>" value="<?= $update[0]->hp_id; ?>" data-errors="{filter_required:'Base Location should not be blank!'}" data-href="<?php echo base_url(); ?>auto/get_baselocation" <?php echo $view; ?>>
                            </div>
                        </div>
                    </div>
                    <div class="field_row width100">
                    <?php if (!(@$amb_action == 'edit')) { ?>
                        <div class="width2 float_left">
                            <div class="field_lable float_left width33"><label for="start_odo">Start ODO<span class="md_field">*</span></label></div>
                            <div class="field_input float_left width50">
                                <input type="text" name="start_odo" value="<?php echo $update[0]->start_odo; ?>" TABINDEX="4" onkeyup="this.value=this.value.replace(/[^\d]/,'')" class="filter_required filter_number filter_maxlength[8]" placeholder="Start ODO" data-errors="{filter_required:'Start ODO should not be blank.',filter_number:'Start ODO should be in numeric only.',filter_maxlength:'Start ODO should less then 7 digits.'}" <?php echo $view; ?>  maxlength="8">
                            </div>
                        </div>
                        <?php } ?>
                        <div class="width2 float_left">
                            <div class="field_lable float_left width33"><label for="chases_no">Chases No<span class="md_field">*</span></label></div>
                            <div class="field_input float_left width50">
                                <input type="text" name="chases_no" value="<?php echo $update[0]->chases_no; ?>" TABINDEX="4" onkeyup="" class="filter_required  filter_maxlength[19]" placeholder="Chases No" data-errors="{filter_required:'Chases No should not be blank.',filter_number:'Chases No should be in numeric only.',filter_maxlength:'Chases No should less then 18 digits.'}" <?php echo $view; ?>  maxlength="19">
                            </div>
                        </div> 
                        
                    </div>





                    <div class="add_details"> Base Location Address:</div>

                    <div class="width100">

                        <div class="field_row">

                            <div class="field_lable float_left width17"> <label for="address">Address<span class="md_field">*</span></label></div>

                            <div class="filed_input float_left width75">

                                <input name="hp_add" value="<?= @$update[0]->hp_address ?>" <?php echo $view; ?> id="pac-input" class="hp_dtl filter_required width97" TABINDEX="8" type="text" placeholder="Address" data-state="yes" data-dist="yes" data-city="yes" data-area="yes" data-lmark="yes" data-lane="yes" data-pin="yes" data-rel="hp_dtl" data-auto="hp_auto_addr" data-lat="yes" data-log="yes" data-errors="{filter_required:'Address should not be blank.'}">

                            </div>
                        </div>

                    </div>
                    <div class="field_row width100">

                        <div class="width2 float_left">
                            <div class="field_lable float_left width33"><label for="state">State<span class="md_field">*</span></label></div>


                            <div id="hp_dtl_state" class="float_left filed_input width50">

                                <?php
                                $st = array('st_code' => $update[0]->amb_state, 'auto' => 'hp_auto_addr', 'rel' => 'hp_dtl', 'disabled' => $view);

                                echo get_state($st);
                                ?>

                            </div>


                        </div>
                        <div class="width2 float_left">

                            <div class="field_lable  float_left width33"><label for="district">District<span class="md_field">*</span></label></div>

                            <div id="hp_dtl_dist" class="float_left filed_input width50">
                                <?php

                                $dt = array('dst_code' => $update[0]->amb_district, 'st_code' => $update[0]->amb_state, 'auto' => 'hp_auto_addr', 'rel' => 'hp_dtl', 'disabled' => $view);

                                echo get_district($dt);
                                ?>


                            </div>

                        </div>

                        <div class="width2 float_left">
                            <div class="field_lable  float_left width33"><label for="tahsil">Tehsil<span class="md_field">*</span></label></div>

                            <div id="hp_dtl_tahsil" class="float_left filed_input width50">
                                <?php

                                $thl = array('thl_id' => $update[0]->amb_tahsil, 'dst_code' => $update[0]->amb_district, 'st_code' => $update[0]->amb_state, 'auto' => 'hp_auto_addr', 'rel' => 'hp_dtl', 'disabled' => $view);

                                echo get_tahsil($thl);
                                ?>


                            </div>


                        </div>
                        <div class="width2 float_left">
                            <div class="field_lable float_left width33"><label for="state">City<span class="md_field">*</span></label></div>

                            <div id="hp_dtl_city" class="float_left filed_input width50">

                                <?php
                                $ct = array('cty_id' => $update[0]->amb_city, 'thl_id' => $update[0]->amb_tahsil, 'dst_code' => $update[0]->amb_district, 'auto' => 'hp_auto_addr', 'rel' => 'hp_dtl', 'disabled' => $view);
                                echo get_base_city($ct);
                                ?>


                            </div>


                        </div>
                    </div>
                    <!-- <div class="field_row width100">


                            <div class="width2 float_left">



                                <div class="field_lable  float_left width33"> <label for="area">Area/Locality</label></div>

                                <div class="float_left filed_input width50" id="hp_dtl_area">


                                    <input name="hp_dtl_area" value="<?= @$update[0]->hp_area ?>" <?php echo $view; ?> class="auto_area" type="text" placeholder="Area/Locality" TABINDEX="12">

                                </div>

                            </div>
                            <div class="width2 float_left">

                                <div class="field_lable float_left width33"><label for="landmark">Landmark</label></div>

                                <div class="float_left filed_input width50" id="hp_dtl_lmark">

                                    <input name="hp_dtl_lmark" value="<?= @$update[0]->hp_lmark ?>" <?php echo $view; ?> class="auto_lmark" data-base="" type="text" placeholder="Landmark" TABINDEX="12">

                                </div>
                            </div>

                        </div> -->
                    <!-- <div class="field_row width100">
                            <div class="width2 float_left">

                                <div class="field_lable float_left width33"><label for="landmark">Lane / Street</label></div>

                                <div class="float_left filed_input width50">

                                    <input name="hp_dtl_lane" value="<?= @$update[0]->hp_lane_street ?>" <?php echo $view; ?> class="" data-base="" type="text" placeholder="Lane / Street" TABINDEX="12">

                                </div>
                            </div>
                            <div class="width2 float_left">
                                <div class="field_lable  float_left width33"> <label for="pincode">Pin Code</label></div>

                                <div class="float_left filed_input width50" id="hp_dtl_pcode">


                                    <input name="hp_dtl_lat" value="<?= @$update[0]->hp_pincode ?>" <?php echo $view; ?> class="auto_pcode filter_if_not_blank filter_number" data-errors="{filter_number:'Pincode are allowed only number.'}" type="text" placeholder="Pincode" TABINDEX="15">

                                </div>

                            </div>

                        </div> -->
                    <div class="field_row width100">

                        <div class="width2 float_left">

                            <div class="field_lable float_left width33"><label for="lat">Latitude<span class="md_field">*</span></label></div>

                            <div class="float_left filed_input width50" id="hp_dtl_lat">

                                <input name="lttd" value="<?= @$update[0]->amb_lat ?>" <?php echo $view; ?> class="auto_lmark filter_required" data-errors="{filter_number:'Latitude are allowed only number.',filter_required:'Latitude should not be blank'}" data-base="" type="text" placeholder="Base Latitude" TABINDEX="12">

                            </div>
                        </div>
                        <div class="width2 float_left">
                            <div class="field_lable  float_left width33"> <label for="long">Longitude<span class="md_field">*</span></label></div>

                            <div class="float_left filed_input width50" id="hp_dtl_log">


                                <input name="lgtd" value="<?= @$update[0]->amb_log ?>" <?php echo $view; ?> class="filter_required" data-errors="{filter_number:'Longitude are allowed only number.',filter_required:'Longitude should not be blank'}" type="text" placeholder="Base Longitude" TABINDEX="15">

                            </div>

                        </div>
                    </div> <br>


                </div>

                <?php if (!(@$amb_action == 'view')) { ?>

                    <div class="width_11 margin_auto">
                        <div class="button_field_row">
                            <div class="button_box">
                                <input type="hidden" name="submit_amb" value="amb_reg" />
                                <input type="button" name="submit" value="Submit" class="form-xhttp-request" data-href='<?php echo base_url(); ?>amb/<?php if ($update) { ?>edit_amb<?php } else { ?>add_amb<?php } ?>' data-qr='amb_id[0]=<?php echo base64_encode($update[0]->amb_id); ?>&amp;page_no=<?php echo $page_no; ?>&amp;output_position=content' TABINDEX="12">
                            </div>
                        </div>
                    </div>

                <?php } ?>

            </div>
</form>

<script>
    $('#amb_type').change(function(){
        // alert();
        var amb_type = $(this).val();
        // alert(amb_type);
        if(amb_type == '2')
        {
            $('#vendor').show();
            $('#amb_vendor').addClass('filter_required','has_error');
        }
        else
        {
            $('#vendor').hide();
            $('#amb_vendor').val('');
            $('#amb_vendor').removeClass('filter_required','has_error');
        }
    });


    $('#amb_owner').change(function(){
        // alert();
        var owner = $('#amb_owner').val();
        if(owner == 'GOVT'){
            $('#amb_type').find('option').remove();
            $('#amb_vendor').val('');
    $('#amb_type').append("<option value=''>Select Ambulance Thirdparty</option><option value='1'>Govt</option>");
    var amb_type = $(this).val();
        // alert(amb_type);
        if(amb_type == '2')
        {
            $('#vendor').show();
            $('#amb_vendor').addClass('filter_required','has_error');
        }
        else
        {
            $('#vendor').hide();
            $('#amb_vendor').val('');
            $('#amb_vendor').removeClass('filter_required','has_error');
        }
        }
        else{
    $('#amb_type').find('option').remove();
    $('#amb_type').append("<option value=''>Select Ambulance Thirdparty</option><?php echo get_third_party($update[0]->thirdparty); ?>");
    var amb_type = $(this).val();
        // alert(amb_type);
        if(amb_type == '2')
        {
            $('#vendor').show();
            $('#amb_vendor').addClass('filter_required','has_error');
        }
        else
        {
            $('#vendor').hide();
            $('#amb_vendor').val('');
            $('#amb_vendor').removeClass('filter_required','has_error');
        }
        }
    });
    var owner = $('#amb_owner').val();
        if(owner == 'GOVT'){
            $('#amb_vendor').val('');
            $('#amb_vendor').removeClass('filter_required','has_error');
            $('#amb_type').find('option').remove();
    $('#amb_type').append("<option value=''>Select Ambulance Thirdparty</option><option value='1' selected>Govt</option>");
    
        }
        else{
            
    $('#amb_type').find('option').remove();
    $('#amb_type').append("<option value=''>Select Ambulance Thirdparty</option><?php echo get_third_party($update[0]->thirdparty); ?>");
        }
   
</script>