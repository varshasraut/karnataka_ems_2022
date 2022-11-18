<script>//cur_pcr_step(1);</script>

<div class="float_left width100">
    <?php
    $CI = EMS_Controller::get_instance();

    if (@$th_id != '') {
        $th_id = @$th_id;
    }

    if (@$amb_dst != '') {
        $dst_id = @$amb_dst;
    }
 
    ?>
    <div class="head_outer"><h3 class="txt_clr2 width1">Job Closure Information</h3> </div>     
    <form method="post" name="" id="call_dls_info" >
        <div class="epcr">

            <div class="width50 float_left left_align">
                <div class="single_record_back">                                     
                    <h3>Incident Information</h3>
                </div>
                <div class="width100 float_left drg">
                    <div class="width_12 float_left">
                        <div class="style6 float_left">Date & Time<span class="md_field">*</span> :</div>
                    </div>
                    <div class="width_20 float_left" style="padding-top: 4px;">
                        <?php echo date('d-m-Y H:i:s', strtotime($inc_details_data[0]->inc_datetime)); ?>
                    </div>
                    <input name="date" tabindex="1" class="form_input filter_required " placeholder="Date" type="hidden" data-base="search_btn" data-errors="{filter_required:'Date should not be blank!'}" value="<?php echo date('d-m-Y', strtotime($inc_details_data[0]->inc_datetime)); ?>" readonly="readonly">
                    <input name="time" tabindex="2" class="form_input filter_required" placeholder="Time" type="hidden" data-base="search_btn" data-errors="{filter_required:'Time should not be blank!'}" value="<?php echo date("H:i:s", strtotime($inc_details_data[0]->inc_datetime)); ?>" readonly="readonly">
                    <!--<div class="width_16 float_left">
                        <div class="style6 float_left">Dispatch Time<span class="md_field">*</span> :</div>
                    </div>-->
                    <!--<div class="width_10 float_left" style="padding-top: 4px;">
                        <?php echo date("H:i:s", strtotime($inc_details_data[0]->inc_datetime)); ?>
                    </div>-->
                    <div class="width_13 float_left">
                        <div class="style6 float_left">Incident ID<span class="md_field">*</span> : </div>
                    </div>
                    <div class="width_20 float_left" style="padding-top: 4px;">
           
                   <div> <a href="{base_url}calls/single_record_view" class="onpage_popup" data-qr="output_position=popup_div&inc_ref_id=<?php echo $inc_ref_id; ?>" style="color:#000;"><?php echo $inc_ref_id; ?></a></div>
                        <input name="inc_ref_id" id="inc_ref_id" tabindex="5" class="form_input filter_required" placeholder=" Incident Id" type="hidden" data-base="send_sms" data-errors="{filter_required:'Incident Id should not be blank!'}" value="<?php echo $inc_ref_id; ?>" readonly="readonly">
                    </div>
                    <div class="width_12 float_left">
                        <div class="style6 float_left">Call  Type <span class="md_field">*</span> :</div>
                    </div>
                    <div class="width_20 float_left" style="padding-top: 4px;">
                        <?php echo $cl_type; ?>
                    </div>
                </div>
                <div class="width100 float_left drg">
                    <div class="width_20 float_left">
                        <div class="style6 float_left">Chief Complaint <span class="md_field">*</span> :</div>
                    </div>
                    <div class="width_50 float_left">
                        <?php echo $ct_type; ?>
                    </div>
                   <div class="width_18 float_left" style="padding-left:20px">
                        <div class="style6 float_left">Patient Count <span class="md_field">*</span> :</div>
                    </div>
                    <div class="width_11 float_left" style="padding-top: 4px;">
                        <?php echo $inc_details_data[0]->inc_patient_cnt; ?>
                    </div>
                    <div class="width_12 float_left">
                        <div class="style6 float_left">Assign By <span class="md_field">*</span> :</div>
                    </div>
                    <div class="width_11 float_left" style="padding-top: 4px;">
                        <?php echo $inc_added_by; ?>
                    </div>
                </div>
                <!--                <div class="width50 float_left drg">
                                    <div class="width33 float_left">
                                        <div class="style6 float_left">Time<span class="md_field">*</span> :</div>
                                    </div>
                                    <div class="width33 float_left">
                <?php echo date("H:i:s", strtotime($inc_details_data[0]->inc_datetime)); ?>
                                        <input name="time" tabindex="2" class="form_input filter_required" placeholder="Time" type="hidden" data-base="search_btn" data-errors="{filter_required:'Time should not be blank!'}" value="<?php echo date("H:i:s", strtotime($inc_details_data[0]->inc_datetime)); ?>" readonly="readonly">
                                    </div>
                                </div>
                                <div class="width50 float_left drg">
                                    <div class="width33 float_left">
                                        <div class="style6 float_left">Incident ID<span class="md_field">*</span> : </div>
                                    </div>
                                    <div class="width33 float_left">
                <?php echo $inc_ref_id; ?>
                                        <input name="inc_ref_id" tabindex="5" class="form_input filter_required" placeholder=" Incident Id" type="hidden" data-base="send_sms" data-errors="{filter_required:'Incident Id should not be blank!'}" value="<?php echo $inc_ref_id; ?>" readonly="readonly">
                                    </div>
                                </div>-->
                                <div id="amb_details_block">
                    <div class="width100">
                        <div class="single_record_back">                                     
                            <h3>Ambulance Details</h3>
                        </div>

                        <div class="width50 drg float_left">
                            <div class="width33 float_left">
                                <div class="style6 float_left">Ambulance No<span class="md_field">*</span> : </div>
                            </div>
                            <div class="width_62 float_left">
                                <select name="amb_reg_id" tabindex="22" id="pcr_amb_id1" class="filter_required" data-errors="{filter_required:'Ambulance should not be blank!'}"> 
                                    <option value="">Select Ambulance</option>
                                    <?php foreach ($vahicle_info as $amb) {
                                        ?>
                                        <option value="<?php echo $amb->amb_rto_register_no; ?>" <?php
                                        if ((trim($amb->amb_rto_register_no)) == (trim($inc_emp_info[0]->amb_rto_register_no))) {
                                            echo "selected";
                                        }
                                        ?>><?php echo $amb->amb_rto_register_no; ?></option>
                                            <?php } ?>

                                </select>
                                <input id="add_pcr_amb" class=" onpage_popup float_right" name="add_amb" value="Add Ambulance" data-href="{base_url}/amb/add_amb" data-qr="output_position=popup_div&amp;tool_code=add_ambu" data-popupwidth="1000" data-popupheight="800" type="button" style="display:none;">
                        </div>
                        </div>
                        <div class="width50 drg float_left">
                            <div class="width33 float_left">
                                <div class="style6 float_left">Ambulance Category<span class="md_field">*</span> : </div>
                            </div>
                            <div class="width_62 float_left">
                                <input name="category" id="amb_category" tabindex="29" class="form_input filter_required" placeholder=" Category" type="text" data-base="search_btn" data-errors="{filter_required:'Category should not be blank!'}" value="<?= @$inc_emp_info[0]->ar_name; ?>" readonly="readonly">
                            </div>

                        </div>

                    </div>
                    
                    <!--<div class="width100">
                        <div class="width50 drg float_left">
                            <div class="width33 float_left">
                                <div class="style6 float_left">EMT ID : </div>
                            </div>
                            <div class="width_62 float_left">
                                <input name="emt_id" class="mi_autocomplete" data-href="<?php echo base_url(); ?>auto/get_emso_id" data-value="<?= $inc_emp_info[0]->amb_emt_id; ?>" value="<?= $inc_emp_info[0]->amb_emt_id; ?>" type="text" tabindex="1" placeholder="EMT ID" data-callback-funct="show_emso_id"  id="emt_list" data-errors="{filter_required:'Ambulance should not be blank!'}">
                            </div>
                        </div>
                        <div class="width50 drg float_left">
                            <div class="width33 float_left">
                                <div class="style6 float_left">EMT Name : </div>
                            </div>
                            <div class="width_62 float_left" id="show_emso_name">
                                <input name="emt_name" id="emt_id_new" tabindex="25" class="form_input" placeholder="EMT Name" type="text" data-base="search_btn" data-errors="{filter_required:'Ambulance should not be blank!'}" value="<?= $inc_emp_info[0]->emt_name; ?> <?= $inc_emp_info[0]->e_last_name; ?>">
                                <input name="emt_id" tabindex="25" class="form_input"  type="hidden" value="<?= $inc_emp_info[0]->amb_emt_id; ?>">
                            </div>
                            
                        </div>

                    </div>
                    <div class="width100" id="emt_other_textbox">
                    </div>-->
                   <!-- <div class="width100">
                        <div class="width50 drg float_left">
                            <div class="width33 float_left">
                                <div class="style6 float_left">Pilot ID : </div>
                            </div>
                            <div class="width_62 float_left">
                                <input name="pilot_id"  class="mi_autocomplete" data-href="<?php echo base_url(); ?>auto/get_pilot_id" data-value="<?= $inc_emp_info[0]->amb_pilot_id; ?>" value="<?= $inc_emp_info[0]->amb_pilot_id; ?>" type="text" tabindex="1" placeholder="Pilot ID" data-callback-funct="show_pilot_idnew"  id="pilot_list" data-errors="{filter_required:'Pilot ID should not be blank!'}">
                            </div>
                          
                        </div>
                        <div class="width50 drg float_left">
                            <div class="width33 float_left">
                                <div class="style6 float_left">Pilot Name : </div>
                            </div>
                            <div class="width_62 float_left" id="show_pilot_name">
                                <input name="pilot_name" id="pilot_id_new" tabindex="25" class="form_input" placeholder="Pilot Name1" type="text" data-base="search_btn" data-errors="{filter_required:'Ambulance should not be blank!'}" value="<?= $inc_emp_info[0]->pilot_name; ?>  <?= $inc_emp_info[0]->p_last_name; ?>">
                                <input name="pilot_id" tabindex="25" class="form_input"  type="hidden" value="<?= $inc_emp_info[0]->amb_pilot_id; ?>">
                            </div>
                        </div>

                    </div>
                    <div class="width100" id="pilot_other_textbox">
                            </div>-->
                  
                    <?php if(($inc_emp_info[0]->hp_id == '' || $inc_emp_info[0]->hp_id == null || $inc_emp_info[0]->hp_id == 0) && $user_group != 'UG-BIKE-DCO'){
                        ?>
                         <div class="width100">
                         <div class="width50 drg float_left">
                            <div class="width33 float_left">
                                <div class="style6 float_left">Ambulance Type</div>
                            </div>
                            <div class="width_62 float_left">
                                <input name="amb_type_nm" id="amb_type_nm" tabindex="29" class="form_input" placeholder="Ambulance Type" type="text" data-base="search_btn"  value="<?= @$inc_emp_info[0]->ambt_name; ?>" readonly="readonly">
                            </div>
                            <input type="hidden" name="ambt_id" id= "ambt_id" value="<?= @$inc_emp_info[0]->ambt_id; ?>">
                        </div>
                        <div class="width50 drg float_left">
                            <div class="width_30 float_left">
                                <div class="style6 float_left">Ward Name<span class="md_field">*</span> : </div>
                            </div>
                            <div class="width_70 float_left base_location">
                                <input name="wrd_location" id="wrd_location" tabindex="23" class="form_input filter_required" placeholder=" Base Location" type="text" data-base="search_btn" data-errors="{filter_required:'Base Location should not be blank!'}" value="<?= $inc_emp_info[0]->ward_name; ?>" readonly="readonly">
                                <input name="wrd_location_id" tabindex="9" class="form_input filter_required" placeholder="Enter Base Location" type="hidden" data-base="search_btn" data-errors="{filter_required:'Base Location should not be blank!'}" value="<?= $inc_emp_info[0]->ward_id; ?>">
                            </div>
                        </div>

                    </div>   

                            <?php
                    }else{ ?>
                    <div class="width100">
                        <div class="width50 drg float_left">
                            <div class="width33 float_left">
                                <div class="style6 float_left">Ambulance Type</div>
                            </div>
                            <div class="width_62 float_left">
                                <input name="amb_type_nm" id="amb_type_nm" tabindex="29" class="form_input" placeholder="Ambulance Type" type="text" data-base="search_btn"  value="<?= @$inc_emp_info[0]->ambt_name; ?>" readonly="readonly">
                            </div>
                            <input type="hidden" name="ambt_id" id="ambt_id" value="<?= @$inc_emp_info[0]->ambt_id; ?>"></input>
                        </div>
                        <div class="width50 drg float_left">
                            <div class="width_30 float_left">
                                
                                <div class="style6 float_left">Base Location<span class="md_field">*</span> : </div>
                            </div>
                            <div class="width_70 float_left base_location">
                                <input name="base_location" tabindex="23" id="base_location" class="form_input filter_required" placeholder=" Base Location" type="text" data-base="search_btn" data-errors="{filter_required:'Base Location should not be blank!'}" value="<?= $inc_emp_info[0]->hp_name; ?>" readonly="readonly">
                                <input name="base_location_id" tabindex="9" class="form_input filter_required" placeholder="Enter Base Location" type="hidden" data-base="search_btn" data-errors="{filter_required:'Base Location should not be blank!'}" value="<?= $inc_emp_info[0]->hp_id; ?>">
                            </div>
                        </div>
                            </div> <?php } ?>
                            <div class="width100">
                         <div class="width50 drg float_left">
                            <div class="width33 float_left">
                                <div class="style6 float_left">Ambulance Mob</div>
                            </div>
                            <div class="width_62 float_left">
                                <input name="amb_type_nm" id="amb_type_nm" tabindex="29" class="form_input" placeholder="Ambulance No" type="text" data-base="search_btn"  value="<?= @$inc_emp_info[0]->amb_default_mobile; ?>" readonly="readonly">
                            </div>
                            
                        </div>
                      

                    </div>
                    
                    </div>


            </div>




            <div class="width50 float_left">
            <div class="width100">
                    <div class="single_record_back">                                     
                        <h3>Incident Address</h3>
                    </div>
                    <div class="row">
                    <div class="width100 float_left">
                        <!--<div class="width25 float_left">
                            <div class="style6 float_left">State<span class="md_field">*</span>  : </div>
                        </div>
                        <div class="width_25 float_left">
                            <div id="tc_dtl_state">


                                <?php
                                //var_dump( $inc_details_data[0]->inc_state_id);
                                //$state_id = $pt_info[0]->inc_state_id; 
                                $state_id = $inc_details_data[0]->inc_state_id;
                                ?>


                                <?php
                                $st = array('st_code' => $state_id, 'auto' => 'tc_auto_addr', 'rel' => 'tc_dtl', 'disabled' => '');

                                echo get_state($st);
                                ?>



                            </div>

                        </div>-->
                        <div class="width20 float_left">
                            <div class="style6 float_left">District<span class="md_field">*</span>  : </div>
                        </div>
                        <div class="width_20 float_left">
                            <div id="tc_dtl_dist">



                                <?php
                                $district_id = '';

// if ($inc_details[0]->inc_district_id == '') {
                                // $district_id = $pt_info[0]->ptn_district;
                                $district_id = $inc_details_data[0]->inc_district_id;
//  }
                                ?>

                                <?php
                                $dt = array('dst_code' => $district_id, 'st_code' => $state_id, 'auto' => 'tc_dtl', 'rel' => 'tc_dtl', 'disabled' => '');

                                echo get_district($dt);
                                ?>


                            </div>
                        </div>
                        <div class="width_20 float_left">
                                <div class="style6 float_left">Incident Address<span class="md_field">*</span> : </div>
                            </div>
                            <div class="width_40 float_left base_location" >
                                <input name="inc_address" tabindex="23" id="inc_address" class="form_input filter_required" placeholder="Incident Address" type="text" data-base="search_btn" data-errors="{filter_required:'Base Location should not be blank!'}" value="<?= $inc_details_data[0]->inc_address; ?>" readonly="readonly">
                            </div>
                    </div>
                    </div>
                    
                </div><br>
                <div class="width100">
                    <div class="width100 drg float_left">
                        <div class="single_record_back">     
                            <div class="style6 float_left">Patient Availability</div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="width_60 float_left">
                            <?php 
                            
                           if($inc_details[0]->calltypenm == NULL && $inc_details[0]->epcr_call_type != ''){
                           $inc_details[0]->calltypenm = get_call_type_name($inc_details[0]->epcr_call_type,$inc_details[0]->inc_type);
                           //var_dump($inc_details[0]->calltypenm);
                            }
                            ?>
                            <input name="epcr_call_type" tabindex="4" class="mi_autocomplete form_input filter_required" placeholder="Call Type" type="text" data-base="search_btn" data-errors="{filter_required:'Plase select provider from dropdown list'}" value="<?php echo @$inc_details[0]->epcr_call_type; ?>" data-value="<?php echo @$inc_details[0]->calltypenm; ?>" data-href="{base_url}auto/get_call_type_epcr?calltype=<?php echo $inc_details[0]->inc_type; ?>" data-qr="reopen=<?php echo $reopen;?>" id="epcr_call_type" data-callback-funct="epcr_view_change">
                        </div>
                    </div>
                </div>

 <input type="hidden" name="reopen" id="reopen" value="<?php echo $reopen;?>">
            </div>
            <div id="call_type_view"></div>
            <!--<div class="width100 text_center">
                <div class="text_center">
                    <div class="label">&nbsp;</div>
                    <input type="hidden" name="inc_datetime" id="inc_datetime" value="<?php echo $inc_details_data[0]->inc_datetime; ?>">
                    <input type="button" name="Save" value="SAVE PAGE" class="accept_btn form-xhttp-request" data-href='{base_url}job_closer/save_epcr' data-qr='' TABINDEX="33"><?php // }else{           ?>
    
                </div> 
            </div>-->
           
        </div>
         
    </form>
</div>
<div class="next_pre_outer">
   
    <?php
    $step = $this->session->userdata('pcr_details');
    if (!empty($step)) {
        ?>
        <!--        <a href="#" class="next_btn btn float_right" onclick="load_next_prev_step(2)"> Next > </a>-->
    <?php } ?>
</div>
<script>
    var jsDate = $("#inc_datetime").val();
    var $mindate = new Date(jsDate);

    $('.EndDate').datetimepicker({
        dateFormat: "yy-mm-dd",
        timeFormat: "HH:mm:ss",

        minDate: $mindate,
        maxDate: 0
        // minTime: jsDate[1],

    });
</script>
<script>
//    $(document).ready(function(){
//        document.getElementById("at_scene").disabled = true;
//        document.getElementById("from_scene").disabled = true;
//        document.getElementById("at_hospitals_ambulance1").disabled = true;
//        document.getElementById("hand_over").disabled = true;
//        document.getElementById("back_to_base").disabled = true;
//    });
    $('#start_from_base').on('change',function(){
        var start_from_base = $('#start_from_base').val();
        if(start_from_base != null){
            document.getElementById("at_scene").disabled = false;
        }else{
            document.getElementById("at_scene").disabled = true;
        }
    });
    $('#at_scene').on('change',function(){
        var start_from_base = $('#at_scene').val();
        if(start_from_base != null){
            document.getElementById("from_scene").disabled = false;
        }else{
            document.getElementById("from_scene").disabled = true;
        }
    });
    $('#from_scene').on('change',function(){
        var start_from_base = $('#from_scene').val();
        if(start_from_base != null){
            document.getElementById("at_hospitals_ambulance1").disabled = false;
        }else{
            document.getElementById("at_hospitals_ambulance1").disabled = true;
        }
    });
    $('#at_hospitals_ambulance1').on('change',function(){
        var start_from_base = $('#at_hospitals_ambulance1').val();
        if(start_from_base != null){
            document.getElementById("hand_over").disabled = false;
        }else{
            document.getElementById("hand_over").disabled = true;
        }
    });
    $('#hand_over').on('change',function(){
        var start_from_base = $('#hand_over').val();
        if(start_from_base != null){
            document.getElementById("back_to_base").disabled = false;
        }else{
            document.getElementById("back_to_base").disabled = true;
        }
    });
    
    function facility_new_details(ft) {

        if (ft == 'Other' || ft == 0) {

            xhttprequest($(this), base_url + 'bike/other_hospital_textbox', 'output_position=other_hospital_textbox');
        } else {
            $('#other_hospital_textbox').html('');
        }
        
    }

</script>