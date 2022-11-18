<?php //var_dump($patient_info);?>
<div class="width100">
<div class="single_record_back">                                     
                        <h3>Patient Details  <?php echo '[Total Patient Count'.' '.$pt_count.''.']'; ?></h3>
                        </div>
    <div class="width25 float_left">
        <div class="width100 float_left">
            <div class="style6 float_left">Patient ID : </div>
        </div>
        <div class="width100 float_left">
            <select name="pat_id" tabindex="4" id="pcr_pat_id_new" class="filter_required" data-errors="{filter_required:'Patient ID should not be blank!'}"> 
                <option value="">Select patient id</option>
                <?php foreach ($patient_info as $pt) { ?>
                    <option value="<?php echo $pt->ptn_id; ?>" <?php
                    if ($pt->ptn_id == $pt_info[0]->ptn_id) {
                        echo "selected";
                    }
                    ?>><?php echo $pt->ptn_id . " - " . $pt->ptn_fname." ".$pt->ptn_lname; ?></option>
                        <?php } ?>
                        <?php 
                                            $count = $inc_details_data[0]->inc_patient_cnt + 5 ; 
                                            
                                            ?>
                                            <?php if($pt_count < $count ){
                                                ?>
                                                <option value="0">Add Patients</option>
                                                <?php
                                            }?>
                
            </select>

            <input class="add_button_hp click-xhttp-request float_right" id="add_button_pt" name="add_patient" value="Add" data-href="{base_url}pcr/add_patient_details?pt_count=<?php echo $pt_count; ?>&epcr_call_type=<?php echo $epcr_call_type;?>&pt_count_ero=<?php echo $inc_details_data[0]->inc_patient_cnt; ?>" data-qr="filter_search=search&amp;tool_code=add_patient&reopen=<?php echo $reopen;?>" type="button" data-popupwidth="1000" data-popupheight="800" style="display:none;">
        </div>
    </div>
    <div class="width25 float_left">
        <div class="width100 float_left">
            <div class="style6 float_left">Age: </div>
        </div>
        <div class="width100 float_left">
            <input name="patient_age" tabindex="6" class="filter_required form_input" placeholder=" Age" type="text" data-errors="{filter_required:'Patient Age is required'}" data-base="search_btn"  value="<?= $pt_info[0]->ptn_age; ?>" readonly="readonly">
        </div>
    </div>

    <div class="width25 float_left ">
    <div class="width100 float_left">
            <div class="style6 float_left">Age Type : </div>
        </div>
        <div class="width100 float_left"> 
    <select id="ptn_age_type" class="filter_required form_input" name="ptn[0][ptn_age_type]" readonly="readonly" data-errors="{filter_required:'Patient Age Type is required'}">
    <option value="<?php echo $pt_info[0]->ptn_age_type; ?>" ><?php echo $pt_info[0]->ptn_age_type; ?></option>
    </select>
                </div>
        
    </div>
    <div class="width25 float_left">
    <div class="width100 float_left">
            <div class="style6 float_left">Gender : </div>
        </div>
    <div class="width90 float_left">
<!--                        <input name="gender" tabindex="13" class="form_input filter_required" placeholder=" Pilot Name " type="text" data-base="search_btn" data-errors="{filter_required:'Patient gender should not be blank!'}" value="<?= get_gen($pt_info[0]->ptn_gender); ?>">-->
            <select id="patient_gender" name="gender" class="filter_required width100" data-errors="{filter_required:'Patient Gender is required'}" <?php echo $view; ?> TABINDEX="7" disabled="disabled">
                <option value=''>Gender</option>
                <option value="M" <?php
                if ($pt_info[0]->ptn_gender == 'M') {
                    echo "Selected";
                }
                ?>>Male</option> 
                <option value="F" <?php
                if ($pt_info[0]->ptn_gender == 'F') {
                    echo "Selected";
                }
                ?>>Female</option>
                <option value="O" <?php
                if ($pt_info[0]->ptn_gender == 'O') {
                    echo "Selected";
                }
                ?>>Other</option>
            </select>
        </div>
                </div>

</div>
<div class="width100">
    <div class="width25 float_left">
        <div class="width100 float_left">
            <div class="style6 float_left">Patient Name : </div>
        </div>
        <div class="width100 float_left">
            <input name="ptn_fname" tabindex="5" class="form_input filter_required ucfirst_letter" placeholder="Patient First Name " type="text" data-base="search_btn" data-errors="{filter_required:'Patient Name should not be blank!'}" value="<?= $pt_info[0]->ptn_fname; ?>" readonly="readonly">
        </div>
    </div>
   <!--<div class="width33 float_left">
        <div class="width100 float_left">
            <div class="style6 float_left">Patient Middle Name : </div>
        </div>
        <div class="width100 float_left">
            <input name="ptn_mname" tabindex="5" class="form_input" placeholder="Patient Middle Name " type="text" data-base="search_btn" data-errors="{filter_required:'Patient Name should not be blank!'}" value="<?= $pt_info[0]->ptn_mname; ?>" readonly="readonly">
        </div>
    </div>-->
    <div class="width25 float_left">
        <div class="width100 float_left">
            <div class="style6 float_left">Patient Last Name : </div>
        </div>
        <div class="width100 float_left">
            <input name="ptn_lname" tabindex="5" class="" placeholder="Patient Last Name " type="text" data-base="search_btn"  value="<?= $pt_info[0]->ptn_lname; ?>" readonly="readonly">
        </div>
    </div>
    <div class="width25 float_left">
        <div class="width100 float_left">
            <div class="style6 float_left">Patient Ayushman ID : </div>
        </div>
        <div class="width100 float_left">
            <input name="ptn_ayushman_id" tabindex="5" class="form_input" placeholder="Ayushman ID" type="text" data-base="search_btn" data-errors="{filter_required:'Patient Name should not be blank!'}" value="<?= $pt_info[0]->ayushman_id; ?>" readonly="readonly">
        </div>
    </div>
    <div class="width25 float_left">
        <div class="width100 float_left">
            <div class="style6 float_left">Patient Blood Group : </div>
        </div>
        <div class="width100 float_left">
            <input name="ptn_bgroup" tabindex="5" class="form_input" placeholder="Blood Group" type="text" data-base="search_btn" data-errors="{filter_required:'Patient Name should not be blank!'}" value="<?php echo get_blood_group_name($pt_info[0]->ptn_bgroup); ?>" readonly="readonly">
        </div>
    </div>
    

</div>
<!--<div class="width100">
    <h3>Patient Address : </h3>
    <div class="width50 float_left">
        <div class="width100 float_left">
            <div class="style6 float_left">State<span class="md_field">*</span>  : </div>
        </div>
        <div class="width100 float_left">
            <div id="tc_dtl_state">


                <?php $state_id = $pt_info[0]->ptn_state;  ?>


                <?php
                $st = array('st_code' => $state_id, 'auto' => 'tc_auto_addr', 'rel' => 'tc_dtl', 'disabled' => '');

                echo get_state($st);
                ?>



            </div>

        </div>
    </div>
    <div class="width50 float_left">
        <div class="width100 float_left">
            <div class="style6 float_left">District<span class="md_field">*</span>  : </div>
        </div>
        <div class="width100 float_left">
            <div id="tc_dtl_dist">



                <?php
                $district_id = '';

// if ($inc_details[0]->inc_district_id == '') {
                $district_id = $pt_info[0]->ptn_district;
//  }
                ?>

                <?php
                $dt = array('dst_code' => $district_id, 'st_code' => $state_id, 'auto' => 'tc_dtl', 'rel' => 'tc_dtl', 'disabled' => '');

                echo get_district($dt);
                ?>


            </div>
        </div>
    </div>

</div>
<div class="width100">
    <div class="width50 float_left">
        <div class="width100 float_left">
            <div class="style6 float_left">City/Village<span class="md_field">*</span> : </div>
        </div>
        <div class="width100 float_left">


            <div id="tc_dtl_city">      

                <?php
                $city_id = '';
                $city_id = $pt_info[0]->ptn_city;
                ?>


                <?php
                $ct = array('cty_id' => $city_id, 'dst_code' => $district_id, 'auto' => 'tc_auto_addr', 'rel' => 'tc_dtl', 'disabled' => '');
                echo get_city($ct);
                ?>
            </div>
        </div>
    </div>
    <div class="width50 float_left">
        <div class="width100 float_left">
            <div class="style6 float_left">Locality<span class="md_field">*</span>   : </div>
        </div>
        <div class="width100 float_left">
            <?php
//   if ($inc_details[0]->inc_address == '') {
            $inc_address = $pt_info[0]->ptn_address;
//  } 
            ?>
            <input name="locality" tabindex="33" class="form_input filter_required" placeholder="Locality" type="text" data-base="search_btn" data-errors="{filter_required:'Locality should not be blank!'}" value="<?= @$inc_address ?>">
        </div>
    </div>

</div>-->

<div class="width100">

    <div class="width50 float_left">


        <div id="ptn_form_lnk" class="width100 float_left">



        </div>

    </div>

</div>