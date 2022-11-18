<style>
    .switch {
        position: relative;
        display: inline-block;
        width: 50px;
        height: 25px;
    }

    .switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }

    .slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #ccc;
        -webkit-transition: .4s;
        transition: .4s;
    }

    .slider:before {
        position: absolute;
        content: "";
        height: 17px;
        width: 18px;
        left: 4px;
        bottom: 4px;
        background-color: white;
        -webkit-transition: .4s;
        transition: .4s;
    }

    input:checked+.slider {
        background-color: #2196F3;
    }

    input:focus+.slider {
        box-shadow: 0 0 1px #2196F3;
    }

    input:checked+.slider:before {
        -webkit-transform: translateX(26px);
        -ms-transform: translateX(26px);
        transform: translateX(26px);
    }

    /* Rounded sliders */
    .slider.round {
        border-radius: 34px;
    }

    .slider.round:before {
        border-radius: 50%;
    }
</style>


<?php
$view = ($action == 'view') ? 'disabled' : '';

if ($action == 'edit') {
    $edit = 'disabled';
}
//var_dump($update);
$CI = EMS_Controller::get_instance();

$title = ($action == 'edit') ? " Edit Inspection Details " : (($action == 'view') ? "View Inspection Details" : "Add Inspection Details");
?>


<script>
    if (typeof H != 'undefined') {
        init_auto_address();
    }
</script>
<form enctype="multipart/form-data" action="#" method="post" id="usr_ad_form" style="position:relative; top:0; bottom:0;">
    <div class="register_outer_block">

        <div class="box3">


            <div class="width1 float_left ">
                <h2 class="txt_clr2 width1 txt_pro"><?php echo $title; ?></h2>
                <div class="store_details_box">


                    <div class="field_row width100">
                        <div class="width2 float_left">
                            <div class="field_lable float_left width33"><label for="district">State<span class="md_field">*</span></label></div>
                            <div class="filed_input float_left width50">
                                <div id="ambulance_state">



                                    <?php
                                    if (@$result[0]->ins_state != '') {
                                        $st = array('st_code' => @$result[0]->ins_state, 'auto' => 'inc_auto_addr', 'rel' => 'maintaince', 'disabled' => 'disabled');
                                    } else {
                                        $st = array('st_code' => 'MP', 'auto' => 'amb_auto_addr', 'rel' => 'inspection', 'disabled' => '');
                                    }


                                    echo get_inspection_ambulance($st);
                                    ?>

                                </div>

                            </div>
                        </div>
                        <div class="width2 float_left">
                            <div class="field_lable float_left width33"><label for="district">District<span class="md_field">*</span></label></div>
                            <div class="filed_input float_left width50">
                                <div id="maintaince_district">
                                    <?php

                                    if (@$result[0]->ins_amb_no != '') {
                                        $dt = array('dst_code' => @$result[0]->ins_dist, 'st_code' => @$result[0]->ins_state, 'amb_ref_no' => @$result[0]->ins_amb_no, 'auto' => 'inc_auto_addr', 'rel' => 'maintaince', 'disabled' => 'disabled');
                                    } else {
                                        $dt = array('dst_code' => '', 'st_code' => 'MP', 'auto' => 'amb_auto_addr', 'rel' => 'inspection', 'disabled' => '');
                                    }

                                    echo get_district_inspection_amb($dt);
                                    ?>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="field_row width100">
                        <div class="width2 float_left">
                            <div class="field_lable float_left width33"><label for="district">Ambulance Number<span class="md_field">*</span></label></div>
                            <div class="filed_input float_left width50">
                                <div id="inspection_ambulance">



                                    <?php
                                    if (@$result[0]->ins_amb_no != '') {

                                        $dt = array('dst_code' => @$result[0]->ins_dist, 'st_code' => @$result[0]->ins_state, 'amb_ref_no' => @$result[0]->ins_amb_no, 'auto' => 'inc_auto_addr', 'rel' => 'maintaince', 'disabled' => 'disabled');

                                        echo get_break_maintaince_ambulance($dt);
                                    } else {
                                        $dt = array('dst_code' => '', 'st_code' => '', 'auto' => 'amb_auto_addr', 'rel' => 'inspection', 'disabled' => '');
                                        echo get_clo_comp_ambulance($dt);
                                    }


                                    ?>

                                </div>

                            </div>
                        </div>
                        <div class="width2 float_left">
                            <div class="field_lable float_left width33"><label for="district">Base Location<span class="md_field">*</span></label></div>


                            <div class="filed_input float_left width50" id="amb_base_location">
                                <input name="ins_baselocation" tabindex="23" class="form_input filter_required mi_autocomplete" placeholder="Base Location" type="text" data-base="search_btn" data-errors="{filter_required:'Base Location should not be blank!'}" data-value="<?= @$result[0]->ins_baselocation; ?>" <?php echo $view; ?> value="<?= @$result[0]->ins_baselocation; ?>" readonly="readonly" <?php echo $update;
                                                                                                                                                                                                                                                                                                                                                                                                                echo $approve;
                                                                                                                                                                                                                                                                                                                                                                                                                echo $rerequest; ?> data-callback-funct="load_baselocation_ambulance" data-href="<?php echo base_url(); ?>auto/get_hospital">

                                <!--                            <input name="base_location" class="mi_autocomplete " data-href="{base_url}auto/get_hospital" value="<?php echo $result[0]->ins_baselocation; ?>" data-value="<?php echo $hp_name; ?>" type="text" <?php echo $view; ?> TABINDEX="10"  data-nonedit="no" data-callback-funct="load_baselocation_address" id="baselocation_address" <?php //echo $edit; 
                                                                                                                                                                                                                                                                                                                                                                                                    ?> > -->

                            </div>

                        </div>

                    </div> <br>
                    <div class="field_row width100">
                        <div class="width2 float_left">
                            <div class="field_lable float_left width33"><label for="district">Ambulance Type<span class="md_field">*</span></label></div>


                            <div class="filed_input float_left width50" id="amb_type_div_outer">

                                <select name="ins_amb_type" class="filter_required" data-errors="{filter_required:'Ambulance type should not be blank'}" <?php echo $view; ?> TABINDEX="5">

                                    <option value="">Select Type</option>

                                    <?php echo get_amb_type_by_id($result[0]->ins_amb_type); ?>
                                </select>


                            </div>


                        </div>
                        <div class="width2 float_left">
                            <div class="field_lable float_left width33"><label for="district">Ambulance Model<span class="md_field"></span></label></div>


                            <div class="filed_input float_left width50" id="amb_amb_model">


                                <input name="ins_amb_model" tabindex="23" class="form_input " placeholder="Model" type="text" data-errors="{filter_required:'Estimate cost should not be blank!',filter_maxlength:'Amount at max 6 digit long',filter_number:'Amount in a number format'}" value="<?= @$result[0]->ins_amb_model; ?>" <?php echo $view; ?> <?php echo $view; ?> <?php echo $update;
                                                                                                                                                                                                                                                                                                                                                                                echo $approve;
                                                                                                                                                                                                                                                                                                                                                                                echo $rerequest; ?>>
                            </div>


                        </div>
                    </div><br>
                    <div class="field_row width100">
                        <div class="width2 float_left">
                            <div class="field_lable float_left width33"><label for="work_shop">Vehicle Current Status<span class="md_field">*</span></label></div>

                            <div class="filed_input float_left width50">

                                <select name="ins_amb_current_status" id="vehsts" tabindex="8" class="filter_required " data-errors="{filter_required:'Current Status should not be blank!'}" <?php echo $view; ?> <?php echo $update;
                                                                                                                                                                                                                            echo $approve;
                                                                                                                                                                                                                            echo $rerequest; ?>>
                                    <option value="">Select Current status</option>
                                    <option value="amb_onroad" <?php if ($result[0]->ins_amb_current_status == 'amb_onroad') {
                                                                    echo "selected";
                                                                } ?>>Ambulance On-Road</option>
                                    <option value="amb_offroad" <?php if ($result[0]->ins_amb_current_status == 'amb_offroad') {
                                                                    echo "selected";
                                                                } ?>>Ambulance Off-Road</option>


                                </select>

                            </div>
                        </div>
                        <div class="width2 float_left">
                            <div class="field_lable float_left width33"><label for="work_shop">GPS Device Working<span class="md_field">*</span></label></div>

                            <div class="filed_input float_left width50">

                                <select name="ins_gps_status" tabindex="8" class="filter_required" data-errors="{filter_required:'GPS Device Working should not be blank!'}" <?php echo $view; ?> <?php echo $view; ?> <?php echo $update;
                                                                                                                                                                                                                        echo $approve;
                                                                                                                                                                                                                        echo $rerequest; ?>>
                                    <option value="">Select Current status</option>
                                    <option value="Yes" <?php if ($result[0]->ins_gps_status == 'Yes') {
                                                            echo "selected";
                                                        } ?>>Yes</option>
                                    <option value="No" <?php if ($result[0]->ins_gps_status == 'No') {
                                                            echo "selected";
                                                        } ?>>No</option>


                                </select>

                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="field_row width100">
                        <div class="width2 float_left">
                            <div class="field_lable float_left width33"><label for="work_shop">PILOT<span class="md_field">*</span></label></div>

                            <div class="filed_input float_left width50">

                                <select name="ins_pilot" tabindex="8" id="pilotsts" class="filter_required " data-errors="{filter_required:'Should not be blank!'}" <?php echo $view; ?> <?php echo $view; ?> <?php echo $update;
                                                                                                                                                                                                                    echo $approve;
                                                                                                                                                                                                                    echo $rerequest; ?>>
                                    <option value="">Select Option</option>
                                    <option value="present" <?php if ($result[0]->ins_pilot == 'present') {
                                                                echo "selected";
                                                            } ?>>Present</option>
                                    <option value="absent" <?php if ($result[0]->ins_pilot == 'absent') {
                                                                echo "selected";
                                                            } ?>>Absent</option>


                                </select>

                            </div>
                        </div>
                        <div class="width2 float_left">
                            <div class="field_lable float_left width33"><label for="work_shop">EMT</label></div>

                            <div class="filed_input float_left width50">

                                <select name="ins_emso" tabindex="8" id="emsosts" class="" data-errors="{filter_required:'Should not be blank!'}" <?php echo $view; ?> <?php echo $view; ?> <?php echo $update;
                                                                                                                                                                                                                    echo $approve;
                                                                                                                                                                                                                    echo $rerequest; ?>>
                                    <option value="">Select Option</option>
                                    <option value="present" <?php if ($result[0]->ins_emso == 'present') {
                                                                echo "selected";
                                                            } ?>>Present</option>
                                    <option value="absent" <?php if ($result[0]->ins_emso == 'absent') {
                                                                echo "selected";
                                                            } ?>>Absent</option>
                                    <option value="NA" <?php if ($result[0]->ins_emso == 'NA') {
                                                                echo "selected";
                                                            } ?>>Not Applicable</option>


                                </select>

                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="field_row width100">
                        <div class="width2 float_left">
                            <div class="field_lable float_left width33"> <label for="mt_estimatecost">Kilometer Reading (Odometer)<span class="md_field"></span></label></div>


                            <div class="filed_input float_left width50">
                                <input name="ins_odometer" tabindex="23" class="form_input filter_if_not_blank filter_maxlength[8] filter_number" placeholder="Enter Odometer" type="text" data-errors="{filter_required:'Estimate cost should not be blank!',filter_maxlength:'Amount at max 7 digit long',filter_number:'Enter only number only.'}" value="<?= @$result[0]->ins_odometer; ?>" <?php echo $view; ?> <?php echo $view; ?> <?php echo $update;
                                                                                                                                                                                                                                                                                                                                                                                                                                            echo $approve;
                                                                                                                                                                                                                                                                                                                                                                                                                                            echo $rerequest; ?>>
                            </div>
                        </div>
                        <!--<div class="width2 float_left">
                    <div class="field_lable float_left width33"><label for="work_shop">Maintenance Of Ambulance<span class="md_field">*</span></label></div>
                    <div class="filed_input float_left width50" id="amb_base_location">
                            <!--<input name="maintace_of_amb" tabindex="23" class="form_input filter_required mi_autocomplete" placeholder="Select Maintenance" type="text" data-base="search_btn" data-errors="{filter_required:'Maintaince should not be blank!'}" data-value="<?= @$result[0]->mt_base_loc; ?>" value="<?= @$result[0]->mt_base_loc; ?>" readonly="readonly"   <?php echo $update;
                                                                                                                                                                                                                                                                                                                                                                                    echo $approve;
                                                                                                                                                                                                                                                                                                                                                                                    echo $rerequest; ?>  data-callback-funct="load_inspection_ambulance_main_type" data-href="<?php echo base_url(); ?>auto/get_maintainance_amb">-->
                        <!-- <input name="maintace_of_amb" tabindex="23" class="form_input filter_required mi_autocomplete" placeholder="Select Maintenance" type="text" data-base="search_btn" data-errors="{filter_required:'Maintaince should not be blank!'}" data-value="<?= @$result[0]->mt_base_loc; ?>" value="<?= @$result[0]->mt_base_loc; ?>" readonly="readonly"   <?php echo $update;
                                                                                                                                                                                                                                                                                                                                                                                echo $approve;
                                                                                                                                                                                                                                                                                                                                                                                echo $rerequest; ?>   data-href="<?php echo base_url(); ?>auto/get_maintainance_amb">
                    </div>
                    </div>-->

                    </div><br>
                    <div class="hideon">
                        <div class="width100 float_left open_greet_quality">

                            <div class="width100 float_left blue_bar_new " id="bgchange1">
                                <div class="width50 float_left ">
                                    <div class="label  float_left   white strong">&nbsp;&nbsp; Maintenance of Vehicle</div>
                                </div>
                                <div class="width20 float_left ">
                                    <div class="label  float_left   white strong">Complete&nbsp;&nbsp; &nbsp;&nbsp; </div>
                                    <label class="switch">
                                        <?php
                                        if ($result != '') { ?>
                                            <input type="checkbox" id="check1" onclick="checkfuc1()" disabled>
                                            <span class="slider round"></span>

                                        <?php } else {
                                        ?>
                                            <input type="checkbox" id="check1" onclick="checkfuc1()">
                                            <span class="slider round"></span>

                                        <?php  } ?>




                                    </label>
                                </div>

                                <div class="width30 float_left">
                                    <div class="quality_arrow_back"></div>
                                </div>
                            </div><br>
                            <div class="checkbox_div hide">
                                <div class="field_row width100"><br>
                                    <div class="width2 float_left">
                                        <div class="field_lable float_left width33"> <label for="mt_estimatecost">Date Of Maintenance<span class="md_field">*</span></label></div>
                                        <div class="filed_input float_left width50">
                                            <input type="text" name="main[ins_main_date]" value=" <?php if ($result[0]->ins_main_date == '' || $result[0]->ins_main_date == "0000-00-00 00:00:00") {
                                                                                                        echo " ";
                                                                                                    } else {
                                                                                                        echo $result[0]->ins_main_date;
                                                                                                    } ?>" class="filter_required OnroadDate removedt1 classremoval" placeholder="Please select date" data-errors="{filter_required:' Date should not be blank'}" TABINDEX="8" <?php if ($result[0]->ins_main_date != '') {
                                                                                                                                                                                                                                                                                                                            echo "disabled";
                                                                                                                                                                                                                                                                                                                        } ?> id="mvdate">
                                        </div>
                                    </div>
                                    <div class="width2 float_left">
                                        <div class="field_lable float_left width33"><label for="work_shop">Maintenance done on due date or not<span class="md_field">*</span></label></div>
                                        <div class="filed_input float_left width50" id="amb_base_location">
                                            <select name="main[ins_main_due_status]" tabindex="8" class="filter_required classremoval" id="main1" data-errors="{filter_required:'Maintenance Due Date should not be blank!'}" <?php echo $view; ?> <?php echo $view; ?> <?php echo $update;
                                                                                                                                                                                                                                                                        echo $approve;
                                                                                                                                                                                                                                                                        echo $rerequest; ?>>
                                                <option value="">Select Option</option>
                                                <option value="Yes" <?php if ($result[0]->ins_main_due_status == 'Yes') {
                                                                        echo "selected";
                                                                    } ?>>Yes</option>
                                                <option value="No" <?php if ($result[0]->ins_main_due_status == 'No') {
                                                                        echo "selected";
                                                                    } ?>>No</option>

                                            </select>
                                        </div>
                                    </div>
                                </div><br>
                                <div class="field_row width100">
                                    <div class="width2 float_left">
                                        <div class="field_lable float_left width33"> <label for="mt_estimatecost">Present Status<span class="md_field">*</span></label></div>
                                        <div class="filed_input float_left width50">
                                            <select name="main[ins_main_status]" tabindex="8" class="filter_required classremoval" id="status1" data-errors="{filter_required:'Present Status should not be blank!'}" <?php echo $view; ?> <?php echo $view; ?> <?php echo $update;
                                                                                                                                                                                                                                                                echo $approve;
                                                                                                                                                                                                                                                                echo $rerequest; ?>>
                                                <option value="">Select Option</option>
                                                <option value="Completed" <?php if ($result[0]->ins_main_status == 'Completed') {
                                                                                echo "selected";
                                                                            } ?>>Maintenance Completed</option>
                                                <option value="In_Progress" <?php if ($result[0]->ins_main_status == 'In_Progress') {
                                                                                echo "selected";
                                                                            } ?>>Maintenance In-Progress</option>
                                                <option value="Pending" <?php if ($result[0]->ins_main_status == 'Pending') {
                                                                            echo "selected";
                                                                        } ?>>Maintenance Pending</option>

                                            </select>
                                        </div>
                                    </div>
                                    <div class="width2 float_left">
                                        <div class="field_lable float_left width33"><label for="work_shop">Remark<span class="md_field">*</span></label></div>
                                        <div class="filed_input float_left width50" id="amb_base_location">
                                            <input name="main[ins_main_remark]" tabindex="23" class="form_input  filter_required classremoval" placeholder="Enter Remark" id="remark1" type="text" onchange="changebg()" data-errors="{filter_required:'Remark should not be blank!'}" value="<?= @$result[0]->ins_main_remark; ?>" <?php echo $view; ?> <?php echo $view; ?> <?php echo $update;
                                                                                                                                                                                                                                                                                                                                                                                echo $approve;
                                                                                                                                                                                                                                                                                                                                                                                echo $rerequest; ?>>
                                        </div>
                                    </div>
                                </div><br>

                            </div>
                        </div>
                        <div class="width100 float_left open_greet_quality">

                            <div class="width100 float_left blue_bar_new " id="bgchange2">
                                <div class="width50 float_left ">
                                    <div class="label  float_left   white strong">&nbsp;&nbsp;Cleanliness of ambulance</div>
                                </div>
                                <div class="width20 float_left ">
                                    <div class="label  float_left   white strong">Complete&nbsp;&nbsp; &nbsp;&nbsp; </div>
                                    <label class="switch">
                                        <?php if ($result != '') { ?>
                                            <input type="checkbox" id="check2" onclick="checkfuc2()" disabled>
                                            <span class="slider round"></span>

                                        <?php } else {
                                        ?>
                                            <input type="checkbox" id="check2" onclick="checkfuc2()">
                                            <span class="slider round"></span>

                                        <?php  } ?>

                                    </label>
                                </div>
                                <div class="width30 float_left">
                                    <div class="quality_arrow_back"></div>
                                </div>
                            </div><br>
                            <div class="checkbox_div hide">
                                <div class="field_row width100"><br>
                                    <div class="width2 float_left">
                                        <div class="field_lable float_left width33"> <label for="mt_estimatecost">Date Of Maintenance<span class="md_field">*</span></label></div>
                                        <div class="filed_input float_left width50">
                                            <input type="text" name="clean[ins_clean_date]" value=" <?php if ($result[0]->ins_clean_date == '' || $result[0]->ins_clean_date == "0000-00-00 00:00:00") {
                                                                                                        echo "";
                                                                                                    } else {
                                                                                                        echo $result[0]->ins_clean_date;
                                                                                                    } ?>" class="filter_required OnroadDate removedt2 classremoval" placeholder="Select date" data-errors="{filter_required:'Date should not be blank'}" TABINDEX="8" <?php if ($result[0]->ins_clean_date != '') {
                                                                                                                                                                                                                                                                                                                    echo "disabled";
                                                                                                                                                                                                                                                                                                                } ?> id="mvdate2">
                                        </div>
                                    </div>

                                    <div class="width2 float_left">
                                        <div class="field_lable float_left width33"> <label for="mt_estimatecost">Present Status<span class="md_field">*</span></label></div>
                                        <div class="filed_input float_left width50">
                                            <select name="clean[ins_clean_status]" tabindex="8" class="filter_required classremoval" id="status2" data-errors="{filter_required:'Present Status should not be blank!'}" <?php echo $view; ?> <?php echo $update;
                                                                                                                                                                                                                                                echo $approve;
                                                                                                                                                                                                                                                echo $rerequest; ?>>
                                                <option value="">Select Option</option>
                                                <option value="Yes" <?php if ($result[0]->ins_clean_status == 'Yes') {
                                                                        echo "selected";
                                                                    } ?>>Yes</option>
                                                <option value="No" <?php if ($result[0]->ins_clean_status == 'No') {
                                                                        echo "selected";
                                                                    } ?>>No</option>


                                            </select>
                                        </div>
                                    </div>
                                </div><br>
                                <div class="field_row width100">

                                    <div class="width2 float_left">
                                        <div class="field_lable float_left width33"><label for="work_shop">Remark<span class="md_field">*</span></label></div>
                                        <div class="filed_input float_left width50" id="amb_base_location">
                                            <input name="clean[ins_clean_remark]" tabindex="23" class="form_input filter_required classremoval" id="remark2" onchange="changebg2()" placeholder="Enter Remark" type="text" data-errors="{filter_required:'Remark should not be blank!'}" value="<?= @$result[0]->ins_clean_remark; ?>" <?php echo $view; ?> <?php echo $update;
                                                                                                                                                                                                                                                                                                                                                            echo $approve;
                                                                                                                                                                                                                                                                                                                                                            echo $rerequest; ?>>
                                        </div>
                                    </div>
                                </div><br>

                            </div>
                        </div>

                        <div class="width100 float_left open_greet_quality">

                            <div class="width100 float_left blue_bar_new " id="bgchange3">
                                <div class="width50 float_left ">
                                    <div class="label  float_left   white strong">&nbsp;&nbsp;Maintenance of AC ,Tyre ,Siren ,Invertor,Battery And GPS </div>
                                </div>
                                <div class="width20 float_left ">
                                    <div class="label  float_left   white strong">Complete&nbsp;&nbsp; &nbsp;&nbsp; </div>
                                    <label class="switch">
                                        <?php if ($result != '') { ?>
                                            <input type="checkbox" id="check3" onclick="checkfuc3()" disabled>
                                            <span class="slider round"></span>

                                        <?php } else {
                                        ?>
                                            <input type="checkbox" id="check3" onclick="checkfuc3()">
                                            <span class="slider round"></span>

                                        <?php  } ?>

                                    </label>
                                </div>
                                <div class="width30 float_left">
                                    <div class="quality_arrow_back"></div>
                                </div>
                            </div><br>
                            <div class="checkbox_div hide">
                                <div class="field_row width100"><br>


                                    <div class="field_lable float_left width10"> <label for="mt_estimatecost"><b>AC</b><span class="md_field">*</span></label></div>

                                    <div class="field_lable float_left width15"> <label for="mt_estimatecost">Working Status<span class="md_field">*</span></label></div>
                                    <div class="filed_input float_left width15">
                                        <select name="main_med_stock[ac_status]" id="comp1" onchange="ac_main()" tabindex="8" class="filter_required classremoval" data-errors="{filter_required:'Present Status should not be blank!'}" <?php echo $view; ?> <?php echo $update;
                                                                                                                                                                                                                                                                echo $approve;
                                                                                                                                                                                                                                                                echo $rerequest; ?>>
                                            <option value="">Select Option</option>
                                            <option value="Working" <?php if ($result[0]->ac_status == 'Working') {
                                                                        echo "selected";
                                                                    } ?>>Working</option>
                                            <option value="Not_Working" <?php if ($result[0]->ac_status == 'Not_Working') {
                                                                            echo "selected";
                                                                        } ?>>Not Working</option>
                                                                        


                                        </select>
                                    </div>
                                    <div class="field_lable float_left width15"> <label for="mt_estimatecost">Not Working From (Date)<span class="md_field">*</span></label></div>
                                    <div class="filed_input float_left width15">
                                        <input type="text" name="main_med_stock[ac_working_date]" value=" <?php if ($result[0]->ac_working_date == '' || $result[0]->ac_working_date == "0000-00-00 00:00:00") {
                                                                                                                echo " ";
                                                                                                            } else {
                                                                                                                echo $result[0]->ac_working_date;
                                                                                                            } ?>" class="filter_required OnroadDate removedt3 classremoval stschange1" placeholder="Date/Time" data-errors="{filter_required:'Date should not be blank'}" TABINDEX="8" <?php if ($result[0]->ac_working_date != '') {
                                                                                                                                                                                                                                                                                                                                        echo "disabled";
                                                                                                                                                                                                                                                                                                                                    } ?> id="">
                                    </div>

                                    <div class="field_lable float_left width10"><label for="work_shop">Remark<span class="md_field">*</span></label></div>
                                    <div class="filed_input float_left width20" id="amb_base_location">
                                        <input name="main_med_stock[ac_remark]" tabindex="23" class="form_input filter_required classremoval" placeholder="Enter Remark" id="remcomp1" type="text" data-errors="{filter_required:'Remark should not be blank!'}" value="<?= @$result[0]->ac_remark; ?>" <?php echo $view; ?> <?php echo $update;
                                                                                                                                                                                                                                                                                                                                echo $approve;
                                                                                                                                                                                                                                                                                                                                echo $rerequest; ?>>
                                    </div>
                                </div><br>

                                <div class="field_row width100"><br>


                                    <div class="field_lable float_left width10"> <label for="mt_estimatecost"><b>Tyre</b><span class="md_field">*</span></label></div>

                                    <div class="field_lable float_left width15"> <label for="mt_estimatecost">Status<span class="md_field">*</span></label></div>
                                    <div class="filed_input float_left width15">
                                        <select name="main_med_stock[tyre_status]" id="comp2" tabindex="8" class="filter_required classremoval" onchange="tyre_main()" data-errors="{filter_required:'Present Status should not be blank!'}" <?php echo $view; ?> <?php echo $update;
                                                                                                                                                                                                                                                                    echo $approve;
                                                                                                                                                                                                                                                                    echo $rerequest; ?>>
                                            <option value="">Select Option</option>
                                            <option value="Replaced" <?php if ($result[0]->tyre_status == 'Replaced') {
                                                                            echo "selected";
                                                                        } ?>>Replaced</option>
                                            <option value="Not_Replaced" <?php if ($result[0]->tyre_status == 'Not_Replaced') {
                                                                                echo "selected";
                                                                            } ?>>Not Replaced</option>
                                             <option value="NA" <?php if ($result[0]->tyre_status == 'NA') {
                                                                                echo "selected";
                                                                            } ?>>Not Applicable</option>


                                        </select>
                                    </div>
                                    <div class="field_lable float_left width15"> <label for="mt_estimatecost">Date of Replacement<span class="md_field">*</span></label></div>
                                    <div class="filed_input float_left width15">
                                        <input type="text" name="main_med_stock[tyre_working_date]" value=" <?php if ($result[0]->tyre_working_date == '' || $result[0]->tyre_working_date == "0000-00-00 00:00:00") {
                                                                                                                echo "";
                                                                                                            } else {
                                                                                                                echo $result[0]->tyre_working_date;
                                                                                                            } ?>" class="filter_required OnroadDate removedt3 classremoval stschange2" placeholder="Date/Time" data-errors="{filter_required:'Date should not be blank'}" TABINDEX="8" <?php if ($result[0]->tyre_working_date != '') {
                                                                                                                                                                                                                                                                                                                                        echo "disabled";
                                                                                                                                                                                                                                                                                                                                    } ?> id="">
                                    </div>

                                    <div class="field_lable float_left width10"><label for="work_shop">Remark<span class="md_field">*</span></label></div>
                                    <div class="filed_input float_left width20" id="amb_base_location">
                                        <input name="main_med_stock[tyre_remark]" tabindex="23" class="form_input filter_required classremoval" placeholder="Enter Remark" id="remcomp2" type="text" data-errors="{filter_required:'Remark should not be blank!'}" value="<?= @$result[0]->tyre_remark; ?>" <?php echo $view; ?> <?php echo $update;
                                                                                                                                                                                                                                                                                                                                    echo $approve;
                                                                                                                                                                                                                                                                                                                                    echo $rerequest; ?>>
                                    </div>
                                </div><br>

                                <div class="field_row width100"><br>


                                    <div class="field_lable float_left width10"> <label for="mt_estimatecost"><b>Siren</b><span class="md_field">*</span></label></div>

                                    <div class="field_lable float_left width15"> <label for="mt_estimatecost">Working Status<span class="md_field">*</span></label></div>
                                    <div class="filed_input float_left width15">
                                        <select name="main_med_stock[siren_status]" tabindex="8" id="comp3" class="filter_required classremoval" onchange="siren_main()" data-errors="{filter_required:'Present Status should not be blank!'}" <?php echo $view; ?> <?php echo $update;
                                                                                                                                                                                                                                                                    echo $approve;
                                                                                                                                                                                                                                                                    echo $rerequest; ?>>
                                            <option value="">Select Option</option>
                                            <option value="Working" <?php if ($result[0]->siren_status == 'Working') {
                                                                        echo "selected";
                                                                    } ?>>Working</option>
                                            <option value="Not_Working" <?php if ($result[0]->siren_status == 'Not_Working') {
                                                                            echo "selected";
                                                                        } ?>>Not Working</option>


                                        </select>
                                    </div>
                                    <div class="field_lable float_left width15"> <label for="mt_estimatecost">Not Working From (Date)<span class="md_field">*</span></label></div>
                                    <div class="filed_input float_left width15">
                                        <input type="text" name="main_med_stock[siren_working_date]" value=" <?php if ($result[0]->siren_working_date == '' || $result[0]->siren_working_date == "0000-00-00 00:00:00") {
                                                                                                                    echo " ";
                                                                                                                } else {
                                                                                                                    echo $result[0]->siren_working_date;
                                                                                                                } ?>" class="filter_required OnroadDate removedt3 classremoval stschange3" placeholder="Date/Time" data-errors="{filter_required:'Date should not be blank'}" TABINDEX="8" <?php if ($result[0]->siren_working_date != '') {
                                                                                                                                                                                                                                                                                                                                            echo "disabled";
                                                                                                                                                                                                                                                                                                                                        } ?> id="">
                                    </div>

                                    <div class="field_lable float_left width10"><label for="work_shop">Remark<span class="md_field">*</span></label></div>
                                    <div class="filed_input float_left width20" id="amb_base_location">
                                        <input name="main_med_stock[siren_remark]" tabindex="23" class="form_input filter_required classremoval" placeholder="Enter Remark" id="remcomp3" type="text" data-errors="{filter_required:'Remark should not be blank!'}" value="<?= @$result[0]->siren_remark; ?>" <?php echo $view; ?> <?php echo $update;
                                                                                                                                                                                                                                                                                                                                    echo $approve;
                                                                                                                                                                                                                                                                                                                                    echo $rerequest; ?>>
                                    </div>
                                </div><br>

                                <div class="field_row width100"><br>


                                    <div class="field_lable float_left width10"> <label for="mt_estimatecost"><b>Invertor</b><span class="md_field">*</span></label></div>

                                    <div class="field_lable float_left width15"> <label for="mt_estimatecost">Working Status<span class="md_field">*</span></label></div>
                                    <div class="filed_input float_left width15">
                                        <select name="main_med_stock[inv_status]" tabindex="8" id="comp4" class="filter_required classremoval" onchange="inv_main()" data-errors="{filter_required:'Present Status should not be blank!'}" <?php echo $view; ?> <?php echo $update;
                                                                                                                                                                                                                                                                echo $approve;
                                                                                                                                                                                                                                                                echo $rerequest; ?>>
                                            <option value="">Select Option</option>
                                            <option value="Working" <?php if ($result[0]->inv_status == 'Working') {
                                                                        echo "selected";
                                                                    } ?>>Working</option>
                                            <option value="Not_Working" <?php if ($result[0]->inv_status == 'Not_Working') {
                                                                            echo "selected";
                                                                        } ?>>Not Working</option>


                                        </select>
                                    </div>
                                    <div class="field_lable float_left width15"> <label for="mt_estimatecost">Not Working From (Date)<span class="md_field">*</span></label></div>
                                    <div class="filed_input float_left width15">
                                        <input type="text" name="main_med_stock[inv_working_date]" value=" <?php if ($result[0]->inv_working_date == '' || $result[0]->inv_working_date == "0000-00-00 00:00:00") {
                                                                                                                echo " ";
                                                                                                            } else {
                                                                                                                echo $result[0]->inv_working_date;
                                                                                                            } ?>" class="filter_required OnroadDate removedt3 classremoval stschange4" placeholder="Date/Time" data-errors="{filter_required:'Date should not be blank'}" TABINDEX="8" <?php if ($result[0]->inv_working_date != '') {
                                                                                                                                                                                                                                                                                                                                        echo "disabled";
                                                                                                                                                                                                                                                                                                                                    } ?> id="">
                                    </div>

                                    <div class="field_lable float_left width10"><label for="work_shop">Remark<span class="md_field">*</span></label></div>
                                    <div class="filed_input float_left width20" id="amb_base_location">
                                        <input name="main_med_stock[inv_remark]" tabindex="23" class="form_input filter_required classremoval" placeholder="Enter Remark" id="remcomp4" type="text" data-errors="{filter_required:'Remark should not be blank!'}" value="<?= @$result[0]->inv_remark; ?>" <?php echo $view; ?> <?php echo $update;
                                                                                                                                                                                                                                                                                                                                echo $approve;
                                                                                                                                                                                                                                                                                                                                echo $rerequest; ?>>
                                    </div>
                                </div><br>

                                <div class="field_row width100"><br>


                                    <div class="field_lable float_left width10"> <label for="mt_estimatecost"><b>Battery</b><span class="md_field">*</span></label></div>

                                    <div class="field_lable float_left width15"> <label for="mt_estimatecost">Working Status<span class="md_field">*</span></label></div>
                                    <div class="filed_input float_left width15">
                                        <select name="main_med_stock[batt_status]" tabindex="8" id="comp5" class="filter_required classremoval" onchange="batt_main()" data-errors="{filter_required:'Present Status should not be blank!'}" <?php echo $view; ?> <?php echo $update;
                                                                                                                                                                                                                                                                    echo $approve;
                                                                                                                                                                                                                                                                    echo $rerequest; ?>>
                                            <option value="">Select Option</option>
                                            <option value="Working" <?php if ($result[0]->batt_status == 'Working') {
                                                                        echo "selected";
                                                                    } ?>>Working</option>
                                            <option value="Not_Working" <?php if ($result[0]->batt_status == 'Not_Working') {
                                                                            echo "selected";
                                                                        } ?>>Not Working</option>


                                        </select>
                                    </div>
                                    <div class="field_lable float_left width15"> <label for="mt_estimatecost">Not Working From (Date)<span class="md_field">*</span></label></div>
                                    <div class="filed_input float_left width15">
                                        <input type="text" name="main_med_stock[batt_working_date]" value=" <?php if ($result[0]->batt_working_date == '' || $result[0]->batt_working_date == "0000-00-00 00:00:00") {
                                                                                                                echo " ";
                                                                                                            } else {
                                                                                                                echo $result[0]->batt_working_date;
                                                                                                            } ?>" class="filter_required OnroadDate removedt3 classremoval stschange5" placeholder="Date/Time" data-errors="{filter_required:'Date should not be blank'}" TABINDEX="8" <?php if ($result[0]->batt_working_date != '') {
                                                                                                                                                                                                                                                                                                                                        echo "disabled";
                                                                                                                                                                                                                                                                                                                                    } ?> id="">
                                    </div>

                                    <div class="field_lable float_left width10"><label for="work_shop">Remark<span class="md_field">*</span></label></div>
                                    <div class="filed_input float_left width20" id="amb_base_location">
                                        <input name="main_med_stock[batt_remark]" tabindex="23" class="form_input filter_required classremoval" placeholder="Enter Remark" id="remcomp5" type="text" data-errors="{filter_required:'Remark should not be blank!'}" value="<?= @$result[0]->batt_remark; ?>" <?php echo $view; ?> <?php echo $update;
                                                                                                                                                                                                                                                                                                                                    echo $approve;
                                                                                                                                                                                                                                                                                                                                    echo $rerequest; ?>>
                                    </div>
                                </div><br>

                                <div class="field_row width100"><br>


                                    <div class="field_lable float_left width10"> <label for="mt_estimatecost"><b>GPS</b><span class="md_field">*</span></label></div>

                                    <div class="field_lable float_left width15"> <label for="mt_estimatecost">Working Status<span class="md_field">*</span></label></div>
                                    <div class="filed_input float_left width15">
                                        <select name="main_med_stock[gps_status]" tabindex="8" id="comp6" class="filter_required classremoval" onchange="gps_main()" data-errors="{filter_required:'Present Status should not be blank!'}" <?php echo $view; ?> <?php echo $update;
                                                                                                                                                                                                                                                                echo $approve;
                                                                                                                                                                                                                                                                echo $rerequest; ?>>
                                            <option value="">Select Option</option>
                                            <option value="Working" <?php if ($result[0]->gps_status == 'Working') {
                                                                        echo "selected";
                                                                    } ?>>Working</option>
                                            <option value="Not_Working" <?php if ($result[0]->gps_status == 'Not_Working') {
                                                                            echo "selected";
                                                                        } ?>>Not Working</option>


                                        </select>
                                    </div>
                                    <div class="field_lable float_left width15"> <label for="mt_estimatecost">Not Working From (Date)<span class="md_field">*</span></label></div>
                                    <div class="filed_input float_left width15">
                                        <input type="text" name="main_med_stock[gps_working_date]" value=" <?php if ($result[0]->gps_working_date == '' || $result[0]->gps_working_date == "0000-00-00 00:00:00") {
                                                                                                                echo " ";
                                                                                                            } else {
                                                                                                                echo $result[0]->gps_working_date;
                                                                                                            } ?>" class="filter_required OnroadDate removedt3 classremoval stschange6" placeholder="Date/Time" data-errors="{filter_required:'Date should not be blank'}" TABINDEX="8" <?php if ($result[0]->gps_working_date != '') {
                                                                                                                                                                                                                                                                                                                                        echo "disabled";
                                                                                                                                                                                                                                                                                                                                    } ?> id="">
                                    </div>

                                    <div class="field_lable float_left width10"><label for="work_shop">Remark<span class="md_field">*</span></label></div>
                                    <div class="filed_input float_left width20" id="amb_base_location">
                                        <input name="main_med_stock[gps_remark]" tabindex="23" class="form_input filter_required classremoval" placeholder="Enter Remark" id="remcomp6" onchange="changebg3()" type="text" data-errors="{filter_required:'Remark should not be blank!'}" value="<?= @$result[0]->gps_remark; ?>" <?php echo $view; ?> <?php echo $update;
                                                                                                                                                                                                                                                                                                                                                        echo $approve;
                                                                                                                                                                                                                                                                                                                                                        echo $rerequest; ?>>
                                    </div>
                                </div><br>


                            </div>
                        </div>

                        <div class="width100 float_left open_greet_quality">

                            <div class="width100 float_left blue_bar_new " id="bgchange4">
                                <div class="width50 float_left ">
                                    <div class="label  float_left   white strong">&nbsp;&nbsp;Maintenance of PCR Register </div>
                                </div>
                                <div class="width20 float_left ">
                                    <div class="label  float_left   white strong">Complete&nbsp;&nbsp; &nbsp;&nbsp; </div>
                                    <label class="switch">
                                        <?php if ($result != '') { ?>
                                            <input type="checkbox" id="check4" onclick="checkfuc4()" disabled>
                                            <span class="slider round"></span>

                                        <?php } else {
                                        ?>
                                            <input type="checkbox" id="check4" onclick="checkfuc4()">
                                            <span class="slider round"></span>

                                        <?php  } ?>

                                    </label>
                                </div>
                                <div class="width30 float_left">
                                    <div class="quality_arrow_back"></div>
                                </div>
                            </div><br>
                            <div class="checkbox_div hide">
                                <div class="field_row width100"><br>
                                    <div class="width2 float_left">
                                        <div class="field_lable float_left width33"> <label for="mt_estimatecost">Date<span class="md_field">*</span></label></div>
                                        <div class="filed_input float_left width50">
                                            <input type="text" name="main_pcs_stock_reg[ins_pcs_stock_date]" value=" <?php if ($result[0]->ins_pcs_stock_date == '' || $result[0]->ins_pcs_stock_date == "0000-00-00 00:00:00") {
                                                                                                                            echo " ";
                                                                                                                        } else {
                                                                                                                            echo $result[0]->ins_pcs_stock_date;
                                                                                                                        } ?>" class="filter_required OnroadDate removedt4 classremoval" placeholder="Date" data-errors="{filter_required:'Date should not be blank'}" TABINDEX="8" <?php if ($result[0]->ins_pcs_stock_date != '') {
                                                                                                                                                                                                                                                                                                                                        echo "disabled";
                                                                                                                                                                                                                                                                                                                                    } ?> id="mvdate4">
                                        </div>
                                    </div>
                                    <div class="width2 float_left">
                                        <div class="field_lable float_left width33"> <label for="mt_estimatecost">Present Status<span class="md_field">*</span></label></div>
                                        <div class="filed_input float_left width50">
                                            <select name="main_pcs_stock_reg[ins_pcs_stock_status]" tabindex="8" id="status4" class="filter_required classremoval" data-errors="{filter_required:'Present Status should not be blank!'}" <?php echo $view; ?> <?php echo $update;
                                                                                                                                                                                                                                                                echo $approve;
                                                                                                                                                                                                                                                                echo $rerequest; ?>>
                                                <option value="">Select Option</option>
                                                <option value="Completed" <?php if ($result[0]->ins_pcs_stock_status == 'Completed') {
                                                                                echo "selected";
                                                                            } ?>>Completed</option>
                                                <option value="In_Progress" <?php if ($result[0]->ins_pcs_stock_status == 'In_Progress') {
                                                                                echo "selected";
                                                                            } ?>>In-Progress</option>
                                                <option value="Pending" <?php if ($result[0]->ins_pcs_stock_status == 'Pending') {
                                                                            echo "selected";
                                                                        } ?>>Pending</option>

                                            </select>
                                        </div>
                                    </div>
                                </div><br>
                                <div class="field_row width100">

                                    <div class="width2 float_left">
                                        <div class="field_lable float_left width33"><label for="work_shop">Remark<span class="md_field">*</span></label></div>
                                        <div class="filed_input float_left width50" id="amb_base_location">
                                            <input name="main_pcs_stock_reg[ins_pcs_stock_remark]" tabindex="23" id="remark4" onchange="changebg4()" class="form_input filter_required classremoval" placeholder="Enter Remark" type="text" data-errors="{filter_required:'Remark should not be blank!',filter_maxlength:'Amount at max 7 digit long',filter_number:'Enter only number only.'}" value="<?= @$result[0]->ins_pcs_stock_remark; ?>" <?php echo $view; ?> <?php echo $update;
                                                                                                                                                                                                                                                                                                                                                                                                                                                                        echo $approve;
                                                                                                                                                                                                                                                                                                                                                                                                                                                                        echo $rerequest; ?>>
                                        </div>
                                    </div>
                                </div><br>

                            </div>
                        </div>
                        <div class="width100 float_left open_greet_quality">

                            <div class="width100 float_left blue_bar_new " id="bgchange5">
                                <div class="width50 float_left ">
                                    <div class="label  float_left   white strong">&nbsp;&nbsp;Signature of attendance sheet</div>
                                </div>
                                <div class="width20 float_left ">
                                    <div class="label  float_left   white strong">Complete&nbsp;&nbsp; &nbsp;&nbsp; </div>
                                    <label class="switch">
                                        <?php if ($result != '') { ?>
                                            <input type="checkbox" id="check5" onclick="checkfuc5()" disabled>
                                            <span class="slider round"></span>

                                        <?php } else {
                                        ?>
                                            <input type="checkbox" id="check5" onclick="checkfuc5()">
                                            <span class="slider round"></span>

                                        <?php  } ?>

                                    </label>
                                </div>
                                <div class="width30 float_left">
                                    <div class="quality_arrow_back"></div>
                                </div>
                            </div><br>
                            <div class="checkbox_div hide">
                                <div class="field_row width100"><br>
                                    <div class="width2 float_left">
                                        <div class="field_lable float_left width33"> <label for="mt_estimatecost">Date<span class="md_field">*</span></label></div>
                                        <div class="filed_input float_left width50">
                                            <input type="text" name="sign_attnd_sheet[ins_sign_attnd_date]" value=" <?php if ($result[0]->ins_sign_attnd_date == '' || $result[0]->ins_sign_attnd_date == "0000-00-00 00:00:00") {
                                                                                                                        echo " ";
                                                                                                                    } else {
                                                                                                                        echo $result[0]->ins_sign_attnd_date;
                                                                                                                    } ?>" class="filter_required OnroadDate removedt5 classremoval" placeholder="Date/Time" data-errors="{filter_required:'Date/Time should not be blank'}" TABINDEX="8" <?php if ($result[0]->ins_sign_attnd_date != '') {
                                                                                                                                                                                                                                                                                                                                            echo "disabled";
                                                                                                                                                                                                                                                                                                                                        } ?> id="mvdate5">
                                        </div>
                                    </div>
                                    <div class="width2 float_left">
                                        <div class="field_lable float_left width33"><label for="work_shop">Is Attendance sheet Maintained or not<span class="md_field">*</span></label></div>
                                        <div class="filed_input float_left width50" id="amb_base_location">
                                            <select name="sign_attnd_sheet[ins_sign_attnd_due_status]" tabindex="8" class="filter_required classremoval" id="main2" data-errors="{filter_required:'Is Attendance sheet Maintained or not should not be blank!'}" <?php echo $view; ?> <?php echo $update;
                                                                                                                                                                                                                                                                                        echo $approve;
                                                                                                                                                                                                                                                                                        echo $rerequest; ?>>
                                                <option value="">Select Option</option>
                                                <option value="Yes" <?php if ($result[0]->ins_sign_attnd_due_status == 'Yes') {
                                                                        echo "selected";
                                                                    } ?>>Yes</option>
                                                <option value="No" <?php if ($result[0]->ins_sign_attnd_due_status == 'No') {
                                                                        echo "selected";
                                                                    } ?>>No</option>

                                            </select>
                                        </div>
                                    </div>
                                </div><br>
                                <div class="field_row width100">
                                    <div class="width2 float_left">
                                        <div class="field_lable float_left width33"> <label for="mt_estimatecost">Present Status<span class="md_field">*</span></label></div>
                                        <div class="filed_input float_left width50">
                                            <select name="sign_attnd_sheet[ins_sign_attnd_status]" tabindex="8" class="filter_required classremoval" id="status5" data-errors="{filter_required:'Present Status should not be blank!'}" <?php echo $view; ?> <?php echo $update;
                                                                                                                                                                                                                                                                echo $approve;
                                                                                                                                                                                                                                                                echo $rerequest; ?>>
                                                <option value="">Select Option</option>
                                                <option value="Completed" <?php if ($result[0]->ins_sign_attnd_status == 'Completed') {
                                                                                echo "selected";
                                                                            } ?>>Completed</option>
                                                <option value="In_Progress" <?php if ($result[0]->ins_sign_attnd_status == 'In_Progress') {
                                                                                echo "selected";
                                                                            } ?>>In-Progress</option>
                                                <option value="Pending" <?php if ($result[0]->ins_sign_attnd_status == 'Pending') {
                                                                            echo "selected";
                                                                        } ?>>Pending</option>

                                            </select>
                                        </div>
                                    </div>
                                    <div class="width2 float_left">
                                        <div class="field_lable float_left width33"><label for="work_shop">Remark<span class="md_field">*</span></label></div>
                                        <div class="filed_input float_left width50" id="amb_base_location">
                                            <input name="sign_attnd_sheet[ins_sign_attnd_remark]" tabindex="23" class="form_input filter_required classremoval" id="remark5" onchange="changebg5()" placeholder="Enter Remark" type="text" data-errors="{filter_required:'Remark should not be blank!'}" value="<?= @$result[0]->ins_sign_attnd_remark; ?>" <?php echo $view; ?> <?php echo $update;
                                                                                                                                                                                                                                                                                                                                                                                    echo $approve;
                                                                                                                                                                                                                                                                                                                                                                                    echo $rerequest; ?>>
                                        </div>
                                    </div>
                                </div><br>

                            </div>
                        </div>
                        <div class="width100 float_left open_greet_quality" id="amb_medicine_model">

                            <div class="width100 float_left blue_bar_new " id="open_greet_ques_outer">
                                <div class="width70 float_left ">
                                    <div class="label  float_left   white strong">&nbsp;&nbsp;Medicine Status</div>
                                </div>
                                <div class="width30 float_left">
                                    <div class="quality_arrow_back"></div>
                                </div>
                            </div><br>
                            <div class="checkbox_div hide"><br>
                                <div class="width25 float_left">
                                    <label class="" for=""><b>Medicin List</b></label>
                                </div>
                                <div class="width10 float_left">
                                <label class="" for=""><b>Stock</b></label>
                                </div>
                                <div class="width15 float_left">
                                    <div class="width50 float_left">
                                    <label class="" for=""><b>Status</b></label>
                                    </div>
                                    <div class="width50 float_left">
                                    <label class="" for=""><b>Available Stock    </b></label>
                                    </div>
                                </div>

                                <div class="width25 float_left">
                                    <label class="" for=""><b>Medicin List</b></label>
                                </div>
                                <div class="width10 float_left">
                                <label class="" for=""><b>Stock</b></label>
                                </div>
                                <div class="width15 float_left">
                                    <div class="width50 float_left">
                                    <label class="" for=""><b>Status</b></label>
                                    </div>
                                    <div class="width50 float_left">
                                    <label class="" for=""><b>Available Stock    </b></label>
                                    </div>
                                </div>

                                <?php foreach ($medicine_list as $medicine) {
                                    if ($result[0]->id != '') {
                                        $medicine_data = get_ins_med_records(array('ins_id' => $result[0]->id, 'med_id' => $medicine->med_id));
                                    }

                                    if($medicine_data){

                                ?>
                                    <div class="width25 float_left">
                                        <label><?php echo $medicine->med_title; ?></label>
                                    </div>
                                    <div class="width10 float_left">
                                        <label><?php echo $medicine->exp_stock; ?></label>
                                    </div>
                                    <div class="width15 float_left">

                                        <div class="width50 float_left">
                                            <label for="open_<?php echo $medicine->med_title; ?>_yes" class="radio_check width2 float_left">
                                                <input id="open_<?php echo $medicine->med_title; ?>_yes" <?php echo $read; ?> type="radio" name="ins_med[<?php echo $medicine->med_id; ?>][med]" class="radio_check_input" value="Y" data-errors="{filter_either_or:'Answer is required'}" TABINDEX="10.<?php echo $key; ?>" <?php
                                                                                                                                                                                                                                                                                                                                if ($medicine_data->med_status == 'Y') {
                                                                                                                                                                                                                                                                                                                                    echo "checked=checked disabled";
                                                                                                                                                                                                                                                                                                                                }

                                                                                                                                                                                                                                                                                                                                ?>>
                                                <span class="radio_check_holder"></span><span>Yes</span>
                                            </label>
                                            <label for="open_<?php echo $medicine->med_title; ?>_no" class="radio_check width2 float_left">
                                                <input id="open_<?php echo $medicine->med_title; ?>_no" type="radio" name="ins_med[<?php echo $medicine->med_id; ?>][med]" class="radio_check_input" value="N" data-errors="{filter_either_or:'Answer is required'}" TABINDEX="10.<?php echo $key; ?>" <?php
                                                                                                                                                                                                                                                                                                        if ($medicine_data->med_status == 'N') {
                                                                                                                                                                                                                                                                                                            echo "checked=checked disabled";
                                                                                                                                                                                                                                                                                                        }
                                                                                                                                                                                                                                                                                                        ?> <?php echo $read; ?>>
                                                <span class="radio_check_holder"></span><span>No</span>
                                            </label>
                                        </div>
                                        <div class="width50 float_left">

                                            <input name="ins_med[<?php echo $medicine->med_id; ?>][qty]" tabindex="23" class="form_input filter_if_not_blank filter_maxlength[8] filter_number" placeholder="Enter Qty" type="text" data-errors="{filter_required:'Estimate cost should not be blank!',filter_maxlength:'Amount at max 7 digit long',filter_number:'Enter only number only.'}" value="<?= @$medicine_data->med_qty; ?>" <?php echo $view; ?> <?php echo $update;
                                                                                                                                                                                                                                                                                                                                                                                                                                                                echo $approve;
                                                                                                                                                                                                                                                                                                                                                                                                                                                                echo $rerequest; ?>>
                                        </div>
                                    </div> <?php } }?>


                                <div class="width100">
                                    <div class="field_lable float_left width33"><label for="">Remark<span class="md_field">*</span></label></div>
                                    <div class="width50 float_left">

                                        <input name="med_Remark" tabindex="23" class="form_input Remark filter_required classremoval" placeholder="Enter Remark" type="text" data-errors="{filter_required:'Remark should not be blank!',filter_maxlength:'Amount at max 7 digit long',filter_number:'Enter only number only.'}" value="<?= @$result[0]->med_Remark; ?>" <?php echo $view; ?> <?php echo $update;
                                                                                                                                                                                                                                                                                                                                                                                                echo $approve;
                                                                                                                                                                                                                                                                                                                                                                                                echo $rerequest; ?>>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="width100 float_left open_greet_quality"  id="amb_equipment_model">

                            <div class="width100 float_left blue_bar_new " id="open_greet_ques_outer">
                                <div class="width70 float_left ">
                                    <div class="label  float_left   white strong">&nbsp;&nbsp;Equipment Status </div>
                                </div>
                                <div class="width30 float_left">
                                    <div class="quality_arrow_back">
                                    </div>
                                </div>
                            </div><br>

                            <div class="checkbox_div hide">
                                <div class="width100 float_left open_greet_quality_new">
                                    <div class="width100 float_left  green_bar" id="open_greet_ques_outer">
                                        <div class="width50 float_left ">
                                            <div class="label  float_left   white strong">&nbsp;&nbsp;Critical Equipment Status </div>
                                        </div>
                                        <!-- <div class="width20 float_left ">
                                            <div class="label  float_left   white strong">Complete&nbsp;&nbsp; &nbsp;&nbsp; </div>
                                            <label class="switch">
                                                <?php if ($result != '') { ?>
                                                    <input type="checkbox" id="check6" onclick="checkfuc6()" disabled>
                                                    <span class="slider round"></span>

                                                <?php } else {
                                                ?>
                                                    <input type="checkbox" id="check6" onclick="checkfuc6()">
                                                    <span class="slider round"></span>

                                                <?php  } ?>

                                            </label>
                                        </div> -->
                                        <div class="width50 float_left">
                                            <div class="quality_arrow_back_new">
                                            </div>
                                        </div>
                                    </div><br>
                                    <div class="checkbox_div_new hide"><br>
                                        <div class="width50 float_left">
                                            <div class="width40 float_left">
                                                <label for="" >Equipment List</label>
                                            </div>
                                            <div class="width60 float_left">
                                                <div class="width25 float_left">
                                                    <label class="lblhead_eqp" for="" >Availability Status</label>
                                                </div>
                                                <div class="width25 float_left">
                                                    <label class="lblhead_eqp" for="" >Functional Status</label>
                                                </div>
                                                <div class="width50 float_left">
                                                    <label class="lblhead_eqp" for="" >Date</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="width50 float_left">
                                            <div class="width40 float_left">
                                                <label class="lblhead_eqp" for="">Equipment List</label>
                                            </div>
                                            <div class="width60 float_left">
                                                <div class="width25 float_left">
                                                    <label class="lblhead_eqp" for="" >Availability Status</label>
                                                </div>
                                                <div class="width25 float_left">
                                                    <label class="lblhead_eqp" for="" >Functional Status</label>
                                                </div>
                                                <div class="width50 float_left">
                                                    <label class="lblhead_eqp" for="" >Date</label>
                                                </div>
                                            </div>
                                        </div>

                                        <?php foreach ($equipment_list_critical as $key => $equipment_critical) {
                                            if (!empty($result[0]->id)) {
                                                $ec_data =  show_critical_data_para($equipment_critical->eqp_id, $result[0]->id);
                                                $ec_ope =  show_oprational_data_para($equipment_critical->eqp_id, $result[0]->id);
                                                $ec_dt =  show_date_data_para($equipment_critical->eqp_id, $result[0]->id);

                                            }
                                            //var_dump($data);

                                            if($ec_data) {
                                        ?>
                                            <div class="width50 float_left" style="border-left:3px solid black;">
                                                <div class="width40 float_left">
                                                    <label><?php echo $equipment_critical->eqp_name; ?></label>
                                                </div>
                                                <div class="width60 float_left">
                                                    <div class="width25 float_left">
                                                        <select name="critical_eqp_status[<?php echo $equipment_critical->eqp_id; ?>][status]" tabindex="8" id="critsts<?php echo $equipment_critical->eqp_id; ?>" class="filter_required classremoval" data-errors="{filter_required:'Equipment Status should not be blank!'}" <?php echo $view; ?> <?php echo $update;
                                                                                                                                                                                                                                                                                                                                                        echo $approve;
                                                                                                                                                                                                                                                                                                                                                        echo $rerequest; ?>>
                                                            <option value="">Select Option</option>

                                                            <option value="Available" <?php if ($ec_data == 'Available') {
                                                                                            echo "selected";
                                                                                        } ?>>Available</option>
                                                            <option value="Not_Available" <?php if ($ec_data == 'Not_Available') {
                                                                                                echo "selected";
                                                                                            } ?>>Not Available</option>

                                                        </select>
                                                    </div>
                                                    <div class="width25 float_left">
                                                        <select name="critical_eqp_status[<?php echo $equipment_critical->eqp_id; ?>][oprational]" id="critopl<?php echo $equipment_critical->eqp_id; ?>" tabindex="8" class="filter_required imp_select classremoval" data-id="<?= $equipment_critical->eqp_id ?>" data-errors="{filter_required:'Equipment Critical Status should not be blank!'}" <?php echo $view; ?> <?php echo $update;
                                                                                                                                                                                                                                                                                                                                                                                                                            echo $approve;
                                                                                                                                                                                                                                                                                                                                                                                                                            echo $rerequest; ?>>
                                                            <option value="">Select Option</option>
                                                            <option value="Functional" <?php if ($ec_ope == 'Functional') {
                                                                                            echo "selected";
                                                                                        } ?>>Functional</option>
                                                            <option value="Non_Functional" <?php if ($ec_ope == 'Non_Functional') {
                                                                                                echo "selected";
                                                                                            } ?>>Non-Functional</option>

                                                        </select>
                                                    </div>
                                                    <div class="width50 float_left">
                                                        <div class="field_lable float_left width20"> <label for="mt_estimatecost">Date<span class="md_field"></span></label></div>
                                                        <div class="filed_input float_left width70">
                                                            <input type="text" name="critical_eqp_status[<?php echo $equipment_critical->eqp_id; ?>][date_from]" value=" <?php if ($ec_dt != '0000-00-00 00:00:00' && $ec_dt != '') {
                                                                                                                                                                                echo $ec_dt;
                                                                                                                                                                            } ?>" class="OnroadDate imp_class removedt6 disdate" placeholder="Please select date" data-errors="{filter_required:' Date should not be blank'}" TABINDEX="8" <?php if ($ec_dt != '0000-00-00 00:00:00' && $ec_dt != '') {
                                                                                                                                                                                                                                                                                                                                                echo "disabled";
                                                                                                                                                                                                                                                                                                                                            } ?> id="">
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        <?php } }?>
                                        <input type="text" id="critical" value="<?= $key + 1 ?>" hidden>
                                        <div class="width100">
                                            <div class="width50 float_left">
                                                <input name="critical_eqp_status_remark" tabindex="23" class="form_input Remark filter_required classremoval" id="critrem" placeholder="Enter Remark*" type="text" data-errors="{filter_required:'Remark should not be blank!'}" value="<?= $result_equip[0]->remark; ?>" <?php echo $view; ?> <?php echo $update;
                                                                                                                                                                                                                                                                                                                                                echo $approve;
                                                                                                                                                                                                                                                                                                                                                $rerequest; ?>>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="width100 float_left open_greet_quality_new">
                                    <div class="width100 float_left green_bar " id="open_greet_ques_outer">
                                        <div class="width50 float_left ">
                                            <div class="label  float_left   white strong">&nbsp;&nbsp;Major Equipment Status </div>
                                        </div>
                                        <!-- <div class="width20 float_left ">
                                            <div class="label  float_left   white strong">Complete&nbsp;&nbsp; &nbsp;&nbsp; </div>
                                            <label class="switch">
                                                <?php if ($result != '') { ?>
                                                    <input type="checkbox" id="check7" onclick="checkfuc7()" disabled>
                                                    <span class="slider round"></span>

                                                <?php } else {
                                                ?>
                                                    <input type="checkbox" id="check7" onclick="checkfuc7()">
                                                    <span class="slider round"></span>

                                                <?php  } ?>

                                            </label>
                                        </div> -->
                                        <div class="width50 float_left">
                                            <div class="quality_arrow_back_new">
                                            </div>
                                        </div>
                                    </div><br>
                                    <div class="checkbox_div_new hide"><br>
                                        <div class="width50 float_left">
                                            <div class="width40 float_left">
                                                <label class="lblhead_eqp" for="" >Equipment List</label>
                                            </div>
                                            <div class="width60 float_left">
                                                <div class="width25 float_left">
                                                    <label class="lblhead_eqp" for="" >Availability Status</label>
                                                </div>
                                                <div class="width25 float_left">
                                                    <label class="lblhead_eqp" for="" >Functional Status</label>
                                                </div>
                                                <div class="width50 float_left">
                                                    <label class="lblhead_eqp" for="" >Date</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="width50 float_left">
                                            <div class="width40 float_left">
                                                <label class="lblhead_eqp" for="" >Equipment List</label>
                                            </div>
                                            <div class="width60 float_left">
                                                <div class="width25 float_left">
                                                    <label class="lblhead_eqp" for="" >Availability Status</label>
                                                </div>
                                                <div class="width25 float_left">
                                                    <label class="lblhead_eqp" for="" >Functional Status</label>
                                                </div>
                                                <div class="width50 float_left">
                                                    <label class="lblhead_eqp" for="" >Date</label>
                                                </div>
                                            </div>
                                        </div>
                                        <?php foreach ($equipment_list_major as $key => $equipment_major) {
                                            if (!empty($result[0]->id)) {
                                                $em_data =  show_critical_data_para($equipment_major->eqp_id, $result[0]->id);
                                                $em_ope =  show_oprational_data_para($equipment_major->eqp_id, $result[0]->id);
                                                $em_dt =  show_date_data_para($equipment_major->eqp_id, $result[0]->id);
                                            }

                                            if($em_data){

                                        ?>
                                            <div class="width50 float_left" style="border-left:3px solid black;">
                                                <div class="width40 float_left">
                                                    <label><?php echo $equipment_major->eqp_name; ?></label>
                                                </div>
                                                <div class="width60 float_left">
                                                    <div class="width25 float_left">
                                                        <select name="major_eqp_status[<?php echo $equipment_major->eqp_id; ?>][status]" tabindex="8" id="majorsts<?php echo $equipment_major->eqp_id; ?>" class="filter_required classremoval" data-errors="{filter_required:'Equipment Major Status should not be blank!'}" <?php echo $view; ?> <?php echo $update;
                                                                                                                                                                                                                                                                                                                                                    echo $approve;
                                                                                                                                                                                                                                                                                                                                                    echo $rerequest; ?>>
                                                            <option value="">Select Option</option>
                                                            <option value="Available" <?php if ($em_data  == 'Available') {
                                                                                            echo "selected";
                                                                                        } ?>>Available</option>
                                                            <option value="Not_Available" <?php if ($em_data  == 'Not_Available') {
                                                                                                echo "selected";
                                                                                            } ?>>Not Available</option>

                                                        </select>
                                                    </div>

                                                    <div class="width25 float_left">
                                                        <select name="major_eqp_status[<?php echo $equipment_major->eqp_id; ?>][oprational]" tabindex="8" id="majoropl<?php echo $equipment_major->eqp_id; ?>" class="filter_required imp_select classremoval" data-id="<?= $equipment_major->eqp_id ?>" data-errors="{filter_required:'Equipment Status should not be blank!'}" <?php echo $view; ?> <?php echo $update;
                                                                                                                                                                                                                                                                                                                                                                                                        echo $approve;
                                                                                                                                                                                                                                                                                                                                                                                                        echo $rerequest; ?>>
                                                            <option value="">Select Option</option>
                                                            <option value="Functional" <?php if ($em_ope == 'Functional') {
                                                                                            echo "selected";
                                                                                        } ?>>Functional</option>
                                                            <option value="Non_Functional" <?php if ($em_ope == 'Non_Functional') {
                                                                                                echo "selected";
                                                                                            } ?>>Non-Functional</option>

                                                        </select>
                                                    </div>
                                                    <div class="width50 float_left">
                                                        <div class="field_lable float_left width20"> <label for="mt_estimatecost">Date<span class="md_field"></span></label></div>
                                                        <div class="filed_input float_left width70">
                                                            <input type="text" name="major_eqp_status[<?php echo $equipment_major->eqp_id; ?>][date_from]" value=" <?php if ($em_dt != '0000-00-00 00:00:00' && $em_dt != '') {
                                                                                                                                                                        echo $em_dt;
                                                                                                                                                                    } ?>" class="OnroadDate imp_class2 removedt7" placeholder="Please select date" data-errors="{filter_required:' Date should not be blank'}" TABINDEX="8" <?php if ($em_dt != '0000-00-00 00:00:00' && $em_dt != '') {
                                                                                                                                                                                                                                                                                                                                echo "disabled";
                                                                                                                                                                                                                                                                                                                            } ?> id="">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div> <?php } } ?>
                                        <input type="text" id="major" value="<?= $key + 1 ?>" hidden>

                                        <div class="width100">
                                            <div class="width50 float_left">
                                                <input name="major_eqp_status_remark" tabindex="23" class="form_input filter_required classremoval" id="majorrem" placeholder="Enter Remark*" type="text" data-errors="{filter_required:'Remark should not be blank!'}" value="<?= $result_equip[0]->remark; ?>" <?php echo $view; ?> <?php echo $update;
                                                                                                                                                                                                                                                                                                                                        echo $approve;
                                                                                                                                                                                                                                                                                                                                        echo $rerequest; ?>>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="width100 float_left open_greet_quality_new">
                                    <div class="width100 float_left green_bar " id="open_greet_ques_outer">
                                        <div class="width50 float_left ">
                                            <div class="label  float_left   white strong">&nbsp;&nbsp;Minor Status </div>
                                        </div>
                                        <!-- <div class="width20 float_left ">
                                                <div class="label  float_left   white strong">Complete&nbsp;&nbsp; &nbsp;&nbsp; </div>
                                                <label class="switch">
                                                    <?php if ($result != '') { ?>
                                                        <input type="checkbox" id="check8" onclick="checkfuc8()" disabled>
                                                        <span class="slider round"></span>

                                                    <?php } else {
                                                    ?>
                                                        <input type="checkbox" id="check8" onclick="checkfuc8()">
                                                        <span class="slider round"></span>

                                                    <?php  } ?>

                                                </label>
                                            </div> -->
                                        <div class="width50 float_left">
                                            <div class="quality_arrow_back_new">
                                            </div>
                                        </div>
                                    </div><br>
                                    <div class="checkbox_div_new hide"><br>
                                        <div class="width50 float_left">
                                            <div class="width40 float_left">
                                                <label class="lblhead_eqp" for="" >Equipment List</label>
                                            </div>
                                            <div class="width60 float_left">
                                                <div class="width25 float_left">
                                                    <label class="lblhead_eqp" for="" >Availability Status</label>
                                                </div>
                                                <div class="width25 float_left">
                                                    <label class="lblhead_eqp" for="" >Functional Status</label>
                                                </div>
                                                <div class="width50 float_left">
                                                    <label class="lblhead_eqp" for="" >Date</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="width50 float_left">
                                            <div class="width40 float_left">
                                                <label class="lblhead_eqp" for="" >Equipment List</label>
                                            </div>
                                            <div class="width60 float_left">
                                                <div class="width25 float_left">
                                                    <label class="lblhead_eqp" for="" >Availability Status</label>
                                                </div>
                                                <div class="width25 float_left">
                                                    <label class="lblhead_eqp" for="" >Functional Status</label>
                                                </div>
                                                <div class="width50 float_left">
                                                    <label class="lblhead_eqp" for="" >Date</label>
                                                </div>
                                            </div>
                                        </div>
                                        <?php foreach ($equipment_list_minor as $key => $equipment_minor) {
                                            // var_dump($result[0]->id);
                                            if (!empty($result[0]->id)) {
                                                $eq_data =  show_critical_data_para($equipment_minor->eqp_id, $result[0]->id);
                                                $eq_dt =  show_date_data_para($equipment_minor->eqp_id, $result[0]->id);

                                                $eq_ope =  show_oprational_data_para($equipment_minor->eqp_id, $result[0]->id);
                                            }

                                            if($eq_data){
                                        ?>
                                            <div class="width50 float_left" style="border-left:3px solid black;">
                                                <div class="width40 float_left">
                                                    <label><?php echo $equipment_minor->eqp_name; ?></label>
                                                </div>
                                                <div class="width60 float_left">
                                                    <div class="width25 float_left">
                                                        <select name="minor_eqp_status[<?php echo $equipment_minor->eqp_id; ?>][status]" id="minor<?php echo $equipment_minor->eqp_id; ?>" tabindex="8" class="filter_required minorsts classremoval" data-errors="{filter_required:'Equipment Status should not be blank!'}" <?php echo $view; ?> <?php echo $update;
                                                                                                                                                                                                                                                                                                                                                    echo $approve;
                                                                                                                                                                                                                                                                                                                                                    echo $rerequest; ?>>
                                                            <option value="">Select Option</option>
                                                            <?php if ($key == 1) { ?>

                                                            <?php } ?>
                                                            <option value="Available" <?php if ($eq_data === 'Available') {
                                                                                            echo "selected";
                                                                                        } ?>>Available</option>
                                                            <option value="Not_Available" <?php if ($eq_data === 'Not_Available') {
                                                                                                echo "selected";
                                                                                            } ?>>Not Available</option>

                                                        </select>
                                                    </div>
                                                    <div class="width25 float_left">
                                                        <select name="minor_eqp_status[<?php echo $equipment_minor->eqp_id; ?>][oprational]" id="minor<?php echo $equipment_minor->eqp_id; ?>" tabindex="8" class="filter_required imp_select3 minoropl classremoval" data-id="<?= $equipment_minor->eqp_id ?>" data-errors="{filter_required:'Equipment Status should not be blank!'}" <?php echo $view; ?> <?php echo $update;
                                                                                                                                                                                                                                                                                                                                                                                                                echo $approve;
                                                                                                                                                                                                                                                                                                                                                                                                                echo $rerequest; ?>>
                                                            <option value="">Select Option</option>
                                                            <option value="Functional" <?php if ($eq_ope == 'Functional') {
                                                                                            echo "selected";
                                                                                        } ?>>Functional</option>
                                                            <option value="Non_Functional" <?php if ($eq_ope == 'Non_Functional') {
                                                                                                echo "selected";
                                                                                            } ?>>Non-Functional</option>

                                                        </select>
                                                    </div>
                                                    <div class="width50 float_left">
                                                        <div class="field_lable float_left width20"> <label for="mt_estimatecost">Date<span class="md_field"></span></label></div>
                                                        <div class="filed_input float_left width70">
                                                            <input type="text" name="minor_eqp_status[<?php echo $equipment_minor->eqp_id; ?>][date_from]" value=" <?php if ($eq_dt != '0000-00-00 00:00:00' && $eq_dt != '') {
                                                                                                                                                                        echo $eq_dt;
                                                                                                                                                                    } ?>" class="OnroadDate imp_class3 removedt8" placeholder="Please select date" data-errors="{filter_required:' Date should not be blank'}" TABINDEX="8" <?php if ($eq_dt != '0000-00-00 00:00:00' && $eq_dt != '') {
                                                                                                                                                                                                                                                                                                                                echo "disabled";
                                                                                                                                                                                                                                                                                                                            } ?> id="">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div> <?php } }?>
                                        <input type="text" id="minor" value="<?= $key + 1 ?>" hidden>

                                        <div class="width100">
                                            <div class="width50 float_left">
                                                <input name="minor_eqp_status_remark" tabindex="23" class="form_input filter_required classremoval" id="minorrem" placeholder="Enter Remark*" type="text" data-errors="{filter_required:'Remark should not be blank!'}" value="<?= $result_equip[0]->remark; ?>" <?php echo $view; ?> <?php echo $update;
                                                                                                                                                                                                                                                                                                                                        echo $approve;
                                                                                                                                                                                                                                                                                                                                        echo $rerequest; ?>>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div>

                                </div>


                            </div>

                            <!--<div id="maintaince_ambulance_type_view">
                            </div>-->
                        </div>
                        <br><br><br>
                    </div>
                    <div class="width100 float_left " style="margin-top: 20px;">
                        <div class="field_lable float_left width15"><label for="work_shop">Remark<span class="md_field">*</span></label></div>
                        <div class="filed_input float_left width50" id="amb_base_location">
                            <input name="remark" tabindex="23" class="form_input filter_required" placeholder="Enter Remark" type="text" data-errors="{filter_required:'Remark should not be blank!',filter_maxlength:'Amount at max 7 digit long',filter_number:'Enter only number only.'}" value="<?= @$result[0]->remark; ?>" <?php echo $view; ?> <?php echo $update;
                                                                                                                                                                                                                                                                                                                                                        echo $approve;
                                                                                                                                                                                                                                                                                                                                                        echo $rerequest; ?>>
                        </div>
                    </div>
                    <div class="width100 float_left " style="margin-top: 20px;">
                        <div class="field_lable float_left width15"><label for="work_shop">Forword To Grievance<span class="md_field">*</span></label></div>
                        <div class="filed_input float_left width30" id="amb_base_location">
                            <select name="forword_grievance" tabindex="8" class="filter_required" data-errors="{filter_required:'Maintenance Due Date should not be blank!'}" <?php echo $view; ?> <?php echo $update;
                                                                                                                                                                                                    echo $approve;
                                                                                                                                                                                                    echo $rerequest; ?>>
                                <option value="">Select Option</option>
                                <option value="2" <?php if ($result[0]->forword_grievance == '2') {
                                                        echo "selected";
                                                    } ?>>Yes</option>
                                <option value="1" <?php if ($result[0]->forword_grievance == '1') {
                                                        echo "selected";
                                                    } ?>>No</option>

                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <!-- <?php if ((@$amb_action == 'view')) { ?>
        <div class="filed_input outer_clg_photo width100">
                    <div class="images_main_block width1" id="images_main_block">
                        <div class="upload_images_block">
                            <div class="images_upload_block">
    <?php                                                 
        $name1 = $result_media[0]->upload_img_path;
        $name1 = (explode(",",$name1));
       //var_dump($name1);
        foreach($name1 as $img) {
            //var_dump($img);
            $name = $img;
        $pic_path = FCPATH . "inspection_api/insp_upload_file/" . $name;
        if (file_exists($pic_path)) {
            $pic_path1 = base_url() . "inspection_api/insp_upload_file/" . $name;
           
        }else{
            $blank_pic_path = base_url() . "themes/backend/images/blank_profile_pic.png";
        }
        ?>
         <div class="images_block vid_img" id="image_<?php echo $img;?>">
               <a class="ambulance_photo float_left" target="blank" href="<?php
                if (file_exists($pic_path)) {
                    echo $pic_path1;
                } else {
                    echo $blank_pic_path;
                }
            ?>" style="background: url('<?php
            if (file_exists($pic_path)) {
                echo $pic_path1;
            } else {
                echo $blank_pic_path;
            }
            ?>') no-repeat left center; background-size: cover; min-height: 75px;" <?php echo $view; ?>></a>
        <?php } ?>
        </div>
    </div>
    </div>
    </div>
    </div>
    <?php }else{ ?>
        <div class="field_row width100">
        <div class="field_row width100 float_left">
            <div class="field_row width100 float_left">
                <div class="field_lable float_left width33">
                    <label for="photo">Photo</label>
                </div>
                <div class="filed_input outer_clg_photo width100">
                    <div class="images_main_block width1" id="images_main_block">
                        <div class="upload_images_block">
                            <div class="images_upload_block">
                                <input multiple="multiple" type="file" name="ins_photo[]" accept="image/jpg,image/jpeg,image/png" TABINDEX="18"  <?php echo $view; if($type == 'Rerequest' && $clg_group == 'UG-FLEETDESK'){ echo $mo_rerequest; }else{ echo $rerequest; } ?>  class="files_amb_photo">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php } ?>
    <?php if ((@$amb_action == 'view')) { ?>
        <div class="filed_input outer_clg_photo width100">
                    <div class="images_main_block width1" id="images_main_block">
                        <div class="upload_images_block">
                            <div class="images_upload_block">
    <?php                                                 
        $name1 = $result_media[0]->upload_video_path;
        $name1 = (explode(",",$name1));
       //var_dump($name1);
        foreach($name1 as $img) {
            //var_dump($img);
            $name = $img;
        $pic_path = FCPATH . "inspection_api/insp_upload_file/" . $name;
        if (file_exists($pic_path)) {
            $pic_path1 = base_url() . "inspection_api/insp_upload_file/" . $name;
           
        }else{
            $blank_pic_path = base_url() . "themes/backend/images/blank_profile_pic.png";
        }
        ?>
         <div class="images_block vid_img" id="image_<?php echo $img;?>">
               <a class="ambulance_photo float_left" target="blank" href="<?php
                if (file_exists($pic_path)) {
                    echo $pic_path1;
                } else {
                    echo $blank_pic_path;
                }
            ?>" style="background: url('<?php
            if (file_exists($pic_path)) {
                echo $pic_path1;
            } else {
                echo $blank_pic_path;
            }
            ?>') no-repeat left center; background-size: cover; min-height: 75px;" <?php echo $view; ?>></a>
        <?php } ?>
        </div>
    </div>
    </div>
    </div>
    </div>
    <?php }else{ ?>
    <div class="field_row width100">
        <div class="field_row width100 float_left">
            <div class="field_row width100 float_left">
                <div class="field_lable float_left width33">
                    <label for="photo">Video</label>
                </div>
                <div class="images_main_block width1" id="images_main_block">
                    <div class="upload_images_block">
                        <div class="images_upload_block">
                            <input  type="file" name="ins_video[]" accept="image/jpg,image/jpeg,image/png,video/mp4,video/mp3" TABINDEX="18"  <?php echo $view; echo $rerequest; ?> <?php echo $update; ?>  class="amb_files_amb_photo" multiple="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php } ?> -->
        <?php if (!(@$amb_action == 'view')) { ?>

            <div class="width_11 margin_auto">
                <div class="button_field_row">
                    <div class="button_box save_btn_wrapper">

                        <input type="hidden" name="submit_amb" value="amb_reg" />


                        <?php if ($result != '') { ?>
                            <input type="button" name="submit" value="Submit" class="accept_btn form-xhttp-request" data-href='<?php echo base_url(); ?>inspection/<?php if ($update) { ?>edit_amb<?php } else { ?>save_inspection<?php } ?>' data-qr='amb_id[0]=<?php echo base64_encode($update[0]->amb_id); ?>&amp;page_no=<?php echo $page_no; ?>&amp;output_position=content' TABINDEX="12" disabled>
                        <?php } else {
                        ?>
                            <input type="button" name="submit" value="Submit" class="accept_btn form-xhttp-request" data-href='<?php echo base_url(); ?>inspection/<?php if ($update) { ?>edit_amb<?php } else { ?>save_inspection<?php } ?>' data-qr='amb_id[0]=<?php echo base64_encode($update[0]->amb_id); ?>&amp;page_no=<?php echo $page_no; ?>&amp;output_position=content' TABINDEX="12">
                        <?php  } ?>


                    </div>
                </div>
            </div>

        <?php } ?>

    </div>
</form>

<style>
    .lblhead_eqp{
        text-align: center !important;
        font-weight: bold !important;
    }
</style>
<script>
    jQuery(document).ready(function() {
        var jsDate = $("#offroad_datetime").val();
        var $mindate = new Date(jsDate);

        $('.OnroadDate').datepicker({
            dateFormat: "yy-mm-dd",
            minDate: $mindate,
            // minTime: jsDate[1],

        });
        $("#offroad_datetime").change(function() {
            var jsDate = $("#offroad_datetime").val();
            var $mindate = new Date(jsDate);
        });

        $('input[type=radio][name="app[mt_approval]"]').change(function() {
            //$("#ap").show();
            var app = $("input[name='app[mt_approval]']:checked").val();
            if (app == "1") {
                $(".ap").show();
            } else {
                $(".ap").hide();
            }
        });



    });

    $('#vehsts').change(function() {
        var vehsts = $("#vehsts").val();
        if (vehsts == 'amb_offroad') {

            $('.hideon').hide();
            $(".classremoval").removeClass("filter_required");

        } else {
            $('.hideon').show();
            $(".classremoval").addClass("filter_required");
        }
    });

    function checkfuc1() {
        var checkBox1 = document.getElementById("check1");
        var text1 = "Done";
        if (checkBox1.checked == true) {
            document.getElementById("main1").selectedIndex = "1";
            document.getElementById("status1").selectedIndex = "1";
            document.getElementById("remark1").value = text1;
            $(".removedt1").removeClass("filter_required");

        } else {
            document.getElementById("main1").selectedIndex = "";
            document.getElementById("status1").selectedIndex = "";
            document.getElementById("remark1").value = "";
            $(".removedt1").addClass("filter_required");

        }
    }

    function checkfuc2() {
        var checkBox2 = document.getElementById("check2");
        var text1 = "Done";
        if (checkBox2.checked == true) {
            document.getElementById("status2").selectedIndex = "1";
            document.getElementById("remark2").value = text1;
            $(".removedt2").removeClass("filter_required");

        } else {
            document.getElementById("status2").selectedIndex = "";
            document.getElementById("remark2").value = "";
            $(".removedt2").addClass("filter_required");

        }
    }

    function checkfuc3() {
        var checkBox3 = document.getElementById("check3");
        var text1 = "Done";
        if (checkBox3.checked == true) {
            document.getElementById("comp1").selectedIndex = "1";
            document.getElementById("comp2").selectedIndex = "1";
            document.getElementById("comp3").selectedIndex = "1";
            document.getElementById("comp4").selectedIndex = "1";
            document.getElementById("comp5").selectedIndex = "1";
            document.getElementById("comp6").selectedIndex = "1";
            document.getElementById("remcomp1").value = text1;
            document.getElementById("remcomp2").value = text1;
            document.getElementById("remcomp3").value = text1;
            document.getElementById("remcomp4").value = text1;
            document.getElementById("remcomp5").value = text1;
            document.getElementById("remcomp6").value = text1;
            $(".removedt3").removeClass("filter_required");

        } else {
            document.getElementById("comp1").selectedIndex = "";
            document.getElementById("comp2").selectedIndex = "";
            document.getElementById("comp3").selectedIndex = "";
            document.getElementById("comp4").selectedIndex = "";
            document.getElementById("comp5").selectedIndex = "";
            document.getElementById("comp6").selectedIndex = "";
            document.getElementById("remcomp1").value = "";
            document.getElementById("remcomp2").value = "";
            document.getElementById("remcomp3").value = "";
            document.getElementById("remcomp4").value = "";
            document.getElementById("remcomp5").value = "";
            document.getElementById("remcomp6").value = "";
            $(".removedt3").addClass("filter_required");

        }
    }

    function checkfuc4() {
        var checkBox4 = document.getElementById("check4");
        var text1 = "Done";
        if (checkBox4.checked == true) {
            document.getElementById("status4").selectedIndex = "1";
            document.getElementById("remark4").value = text1;
            $(".removedt4").removeClass("filter_required");

        } else {
            document.getElementById("status4").selectedIndex = "";
            document.getElementById("remark4").value = "";
            $(".removedt4").addClass("filter_required");

        }
    }

    function checkfuc5() {
        var checkBox5 = document.getElementById("check5");
        var text1 = "Done";
        if (checkBox5.checked == true) {
            document.getElementById("main2").selectedIndex = "1";

            document.getElementById("status5").selectedIndex = "1";
            document.getElementById("remark5").value = text1;
            $(".removedt5").removeClass("filter_required");

        } else {
            document.getElementById("main2").selectedIndex = "";

            document.getElementById("status5").selectedIndex = "";
            document.getElementById("remark5").value = "";
            $(".removedt5").addClass("filter_required");

        }
    }

    function checkfuc6() {
        var checkBox6 = document.getElementById("check6");
        var text1 = "Done";
        var critical = $('#critical').val();
        if (checkBox6.checked == true) {
            for (var i = 1; i <= critical; i++) {
                var critopl1 = "critopl" + i;
                var critopl2 = "critsts" + i;
                document.getElementById(critopl1).selectedIndex = "1";
                document.getElementById(critopl2).selectedIndex = "1";

            }
            document.getElementById("critrem").value = text1;
            $(".removedt6").removeClass("filter_required");
            $(".disdate").attr("disabled", "disabled");


        } else {
            for (var i = 1; i <= critical; i++) {
                var critopl1 = "critopl" + i;
                var critopl2 = "critsts" + i;
                document.getElementById(critopl1).selectedIndex = "";
                document.getElementById(critopl2).selectedIndex = "";

            }
            document.getElementById("critrem").value = "";
            $(".removedt6").addClass("filter_required");
            $(".disdate").removeAttr("disabled");


        }
    }

    function checkfuc7() {
        var checkBox7 = document.getElementById("check7");
        var text1 = "Done";
        var major = $('#major').val();

        if (checkBox7.checked == true) {
            for (var i = 1; i <= major; i++) {
                var majorsts1 = "majorsts" + i;
                var majoropl2 = "majoropl" + i;
                console.log(majorsts1);
                document.getElementById(majorsts1).selectedIndex = "1";
                document.getElementById(majoropl2).selectedIndex = "1";

            }
            document.getElementById("majorrem").value = text1;
            $(".removedt7").removeClass("filter_required");

        } else {
            for (var i = 1; i <= major; i++) {
                var majorsts1 = "majorsts" + i;
                var majoropl2 = "majoropl" + i;
                document.getElementById(majorsts1).selectedIndex = "";
                document.getElementById(majoropl2).selectedIndex = "";

            }
            document.getElementById("majorrem").value = "";
            $(".removedt7").addClass("filter_required");

        }
    }

    function checkfuc8() {
        var checkBox8 = document.getElementById("check8");
        var text1 = "Done";
        var major = $('#minor').val();
        if (checkBox8.checked == true) {
            for (var i = 1; i <= minor; i++) {
                var minorsts1 = "minorsts" + i;
                var minoropl2 = "minoropl" + i;
                document.getElementById(minorsts1).selectedIndex = "1";
                document.getElementById(minoropl2).selectedIndex = "1";

            }
            document.getElementById("minorrem").value = text1;
            $(".removedt8").removeClass("filter_required");

        } else {
            for (var i = 1; i <= minor; i++) {
                var minorsts1 = "minorsts" + i;
                var minoropl2 = "minoropl" + i;
                ss
                document.getElementById(minorsts1).selectedIndex = "";
                document.getElementById(minoropl2).selectedIndex = "";

            }
            document.getElementById("minorrem").value = "";
            $(".removedt8").addClass("filter_required");

        }
    }

    function sum() {
        var txtFirstNumberValue = document.getElementById('part_cost').value;
        var txtSecondNumberValue = document.getElementById('labour_cost').value;
        var result = parseInt(txtSecondNumberValue) + parseInt(txtFirstNumberValue);
        if (!isNaN(result)) {
            document.getElementById('total_cost').value = result;
        }
    }

    function ac_main() {
        var ac_sts = document.getElementById('comp1').value;

        if (ac_sts == "Working") {
            // alert(ac_sts);
            $(".stschange1").attr("disabled", "disabled");
            $(".stschange1").removeClass("filter_required");

        } else {
            $(".stschange1").removeAttr("disabled");
            $(".stschange1").addClass("filter_required");
        }
    }

    function tyre_main() {
        var tyre_sts = document.getElementById('comp2').value;

        if (tyre_sts == "Replaced" ||tyre_sts == "NA"  ) {
            // alert(ac_sts);
            $(".stschange2").attr("disabled", "disabled");
            $(".stschange2").removeClass("filter_required");

        } else {
            $(".stschange2").removeAttr("disabled");
            $(".stschange2").addClass("filter_required");
        }
    }

    function siren_main() {
        var siren_sts = document.getElementById('comp3').value;

        if (siren_sts == "Working") {
            // alert(ac_sts);
            $(".stschange3").attr("disabled", "disabled");
            $(".stschange3").removeClass("filter_required");

        } else {
            $(".stschange3").removeAttr("disabled");
            $(".stschange3").addClass("filter_required");
        }
    }

    function inv_main() {
        var inv_sts = document.getElementById('comp4').value;

        if (inv_sts == "Working") {
            // alert(ac_sts);
            $(".stschange4").attr("disabled", "disabled");
            $(".stschange4").removeClass("filter_required");

        } else {
            $(".stschange4").removeAttr("disabled");
            $(".stschange4").addClass("filter_required");
        }
    }

    function batt_main() {
        var batt_sts = document.getElementById('comp5').value;

        if (batt_sts == "Working") {
            // alert(ac_sts);
            $(".stschange5").attr("disabled", "disabled");
            $(".stschange5").removeClass("filter_required");

        } else {
            $(".stschange5").removeAttr("disabled");
            $(".stschange5").addClass("filter_required");
        }
    }

    function gps_main() {
        var gps_sts = document.getElementById('comp6').value;

        if (gps_sts == "Working") {
            // alert(ac_sts);
            $(".stschange6").attr("disabled", "disabled");
            $(".stschange6").removeClass("filter_required");

        } else {
            $(".stschange6").removeAttr("disabled");
            $(".stschange6").addClass("filter_required");
        }
    }
</script>
<script>
    function changebg() {
        var cng1 = document.getElementById('mvdate').value;
        var main1 = document.getElementById('main1').value;
        var status1 = document.getElementById('status1').value;
        var remark1 = document.getElementById('remark1').value;
        if (cng1 != " " && main1 != " " && status1 != " " && remark1 != " ") {
            document.getElementById("bgchange1").style.backgroundColor = "rgb(213 140 140)";
        } else {
            document.getElementById("bgchange1").style.backgroundColor = "#0ab9b9";
        }
    };

    function changebg2() {
        var cng2 = document.getElementById('mvdate2').value;
        var status2 = document.getElementById('status2').value;
        var remark2 = document.getElementById('remark2').value;
        if (cng2 != " " && status2 != " " && remark2 != " ") {
            document.getElementById("bgchange2").style.backgroundColor = "rgb(213 140 140)";
        } else {
            document.getElementById("bgchange2").style.backgroundColor = "#0ab9b9";
        }
    };

    function changebg3() {
        var comp1 = document.getElementById('comp1').value;
        var comp2 = document.getElementById('comp2').value;
        var comp3 = document.getElementById('comp3').value;
        var comp4 = document.getElementById('comp4').value;
        var comp5 = document.getElementById('comp5').value;
        var comp6 = document.getElementById('comp6').value;

        var stschange1 = document.getElementsByClassName('stschange1').value;
        var stschange2 = document.getElementsByClassName('stschange2').value;
        var stschange3 = document.getElementsByClassName('stschange3').value;
        var stschange4 = document.getElementsByClassName('stschange4').value;
        var stschange5 = document.getElementsByClassName('stschange5').value;
        var stschange6 = document.getElementsByClassName('stschange6').value;

        var remcomp1 = document.getElementById('remcomp1').value;
        var remcomp2 = document.getElementById('remcomp2').value;
        var remcomp3 = document.getElementById('remcomp3').value;
        var remcomp4 = document.getElementById('remcomp4').value;
        var remcomp5 = document.getElementById('remcomp5').value;
        var remcomp6 = document.getElementById('remcomp6').value;


        if (comp1 == " " || comp1 != " " && comp2 == " " || comp2 != " " && comp3 == " " || comp3 != " " && comp4 == " " || comp4 != " " && comp5 == " " || comp5 != " " && comp6 == " " || comp6 != " " &&
            stschange1 != " " && stschange2 != " " && stschange3 != " " && stschange4 != " " && stschange5 != " " && stschange6 != " " &&
            remcomp1 != " " && remcomp2 != " " && remcomp3 != " " && remcomp4 != " " && remcomp5 != " " && remcomp6 != " ") {
            document.getElementById("bgchange3").style.backgroundColor = "rgb(213 140 140)";
        } else {
            document.getElementById("bgchange3").style.backgroundColor = "#0ab9b9";
        }
    };

    function changebg4() {
        var cng4 = document.getElementById('mvdate4').value;
        var status4 = document.getElementById('status4').value;
        var remark4 = document.getElementById('remark4').value;
        if (cng4 != " " && status4 != " " && remark4 != " ") {
            document.getElementById("bgchange4").style.backgroundColor = "rgb(213 140 140)";
        } else {
            document.getElementById("bgchange4").style.backgroundColor = "#0ab9b9";
        }
    };

    function changebg5() {
        var cng5 = document.getElementById('mvdate5').value;
        var main5 = document.getElementById('main2').value;
        var status5 = document.getElementById('status5').value;
        var remark5 = document.getElementById('remark5').value;
        if (cng5 != " " && main5 != " " && status5 != " " && remark5 != " ") {
            // alert("hiii");
            document.getElementById("bgchange5").style.backgroundColor = "rgb(213 140 140)";
        } else {
            document.getElementById("bgchange5").style.backgroundColor = "#0ab9b9";
        }
    };
    $(".imp_select").change(function() {
        var id = $(this).attr("data-id");
        var a = 'critical_eqp_status[' + id + '][oprational]';
        var na = 'critical_eqp_status[' + id + '][date_from]';

        var status1 = (document.getElementsByName(a)[0].value);

        if (status1 == "Functional") {
            $("input[name='" + na + "']").removeClass("filter_required");
            $("input[name='" + na + "']").removeClass("has_error");

        } else if (status1 == "Non_Functional") {

            $("input[name='" + na + "']").addClass("filter_required");
            // $('.imp_class').addClass("filter_required");
            $("input[name='" + na + "']").addClass("has_error");
        } else if (status1 == "   ") {
            $("input[name='" + na + "']").removeClass("filter_required");
            $("input[name='" + na + "']").removeClass("has_error");

        } else {
            $("input[name='" + na + "']").removeClass("filter_required");
            $("input[name='" + na + "']").removeClass("has_error");
        }
    });

    $(".imp_select2").change(function() {
        var id = $(this).attr("data-id");
        var a = 'major_eqp_status[' + id + '][oprational]';
        var na = 'major_eqp_status[' + id + '][date_from]';

        var status2 = (document.getElementsByName(a)[0].value);

        if (status2 == "Functional") {
            $("input[name='" + na + "']").removeClass("filter_required");
            $("input[name='" + na + "']").removeClass("has_error");

        } else if (status2 == "Non_Functional") {
            $("input[name='" + na + "']").addClass("filter_required");
            $("input[name='" + na + "']").addClass("has_error");

        } else if (status2 == "") {
            $("input[name='" + na + "']").removeClass("filter_required");
            $("input[name='" + na + "']").removeClass("has_error");

        } else {
            $("input[name='" + na + "']").removeClass("filter_required");
            $("input[name='" + na + "']").removeClass("has_error");

        }
    });

    $(".imp_select3").change(function() {
        var id = $(this).attr("data-id");
        var a = 'minor_eqp_status[' + id + '][oprational]';
        var na = 'minor_eqp_status[' + id + '][date_from]';

        var status3 = (document.getElementsByName(a)[0].value);


        if (status3 == "Functional") {
            $("input[name='" + na + "']").removeClass("filter_required");
            $("input[name='" + na + "']").removeClass("has_error");
        } else if (status3 == "Non_Functional") {
            $("input[name='" + na + "']").addClass("filter_required");
            $("input[name='" + na + "']").addClass("has_error");

        } else if (status3 == " ") {
            $("input[name='" + na + "']").removeClass("filter_required");
            $("input[name='" + na + "']").removeClass("has_error");

        } else {
            $("input[name='" + na + "']").removeClass("filter_required");
            $("input[name='" + na + "']").removeClass("has_error");

        }
    });
</script>