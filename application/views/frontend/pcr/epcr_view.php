<div class="float_left width100">
    <?php $CI = EMS_Controller::get_instance(); 
    
    if(@$th_id!=''){ $th_id = @$th_id;} 

    if(@$amb_dst!='') { $dst_id = @$amb_dst;}   

    ?>
      <div class="head_outer"><h3 class="txt_clr2 width1">E-PCR (Tablet closure information)</h3> </div>     
    <form method="post" name="" id="call_dls_info">
        <div class="width100">
            <div class="width50 float_left">
                <div class="width40 float_left">
                    <div class="style6 float_left">Date : </div>
                </div>
                <div class="width60 float_left">
                    <input name="date" tabindex="1" class="form_input filter_required" placeholder="Enter Date" type="text" data-base="search_btn" data-errors="{filter_required:'Date should not be blank!'}" value="<?php echo date('d/m/Y'); ?>" >
                </div>
            </div>
            <div class="width50 float_left">
                <div class="width40 float_left">
                    <div class="style6 float_left">Time : </div>
                </div>
                <div class="width60 float_left">
                    <input name="time" tabindex="2" class="form_input filter_required" placeholder="Enter Time" type="text" data-base="search_btn" data-errors="{filter_required:'Time should not be blank!'}" value="<?php echo date('H:i'); ?>">
                </div>
            </div>

        </div>
        <div class="width100">
            <div class="width50 float_left">
                <div class="width40 float_left">
                    <div class="style6 float_left">Incident ID : </div>
                </div>
                <div class="width60 float_left">
                    <input name="inc_ref_id" tabindex="3" class="form_input filter_required" placeholder="Enter Incident Id" type="text" data-base="search_btn" data-errors="{filter_required:'Incident Id should not be blank!'}" value="<?php echo $inc_ref_id; ?>">
                </div>
            </div>

        </div>
        <div id="pat_details_block">
            <div class="width100">
                <h3>Patient Details : </h3>
                <div class="width50 float_left">
                    <div class="width40 float_left">
                        <div class="style6 float_left">Patient ID : </div>
                    </div>
                    <div class="width60 float_left">
                        <select name="pat_id" tabindex="4" id="pcr_pat_id" class="filter_required" data-errors="{filter_required:'Patient ID should not be blank!'}"> 
                            <option value="">Select patient id</option>
                            <?php foreach ($patient_info as $pt) { ?>
                            <option value="<?php echo $pt->ptn_id; ?>" <?php if( $pt->ptn_id == $pt_info[0]->ptn_id ){ echo "selected"; }?>><?php echo $pt->ptn_id . " - " . $pt->ptn_fname . " " . $pt->ptn_lname; ?></option>
                            <?php } ?>
                            <option value="0" class="onpage_popup" href="{base_url}pcr/patient_details" data-qr="output_position=popup_div"  data-popupwidth="1250" data-popupheight="850">Other</option>
                        </select>

                        <input class="add_button_hp onpage_popup float_right" id="add_button_pt" name="add_patient" value="Add" data-href="{base_url}pcr/patient_details" data-qr="output_position=popup_div&amp;filter_search=search&amp;tool_code=add_patient" type="button" data-popupwidth="1000" data-popupheight="800" style="display:none;">
                    </div>
                </div>
                <div class="width50 float_left">
                    <div class="width40 float_left">
                        <div class="style6 float_left">Patient Name : </div>
                    </div>
                    <div class="width60 float_left">
                        <input name="patient_name" tabindex="5" class="form_input filter_required" placeholder="Enter Patient Name " type="text" data-base="search_btn" data-errors="{filter_required:'Patient Name should not be blank!'}" value="<?= $pt_info[0]->ptn_fname; ?>">
                    </div>
                </div>
            </div>
            <div class="width100">

                <div class="width50 float_left">
                    <div class="width40 float_left">
                        <div class="style6 float_left">Age (YY/MM/DD): </div>
                    </div>
                    <div class="width60 float_left">
                        <input name="patient_age" tabindex="6" class="form_input filter_required" placeholder="Enter Age" type="text" data-base="search_btn" data-errors="{filter_required:'Patient Age should not be blank!'}" value="<?= $pt_info[0]->ptn_age; ?>">
                    </div>
                </div>

                <div class="width50 float_left">
                    <div class="width40 float_left">
                        <div class="style6 float_left">Gender : </div>
                    </div>
                    <div class="width60 float_left">
<!--                        <input name="gender" tabindex="13" class="form_input filter_required" placeholder="Enter Pilot Name " type="text" data-base="search_btn" data-errors="{filter_required:'Patient gender should not be blank!'}" value="<?= get_gen($pt_info[0]->ptn_gender); ?>">-->
                             <select id="patient_gender" name="gender" class="filter_required" data-errors="{filter_required:'Patient Gender is required'}" <?php echo $view; ?> TABINDEX="7">
                                <option value=''>Gender</option>
                                <option value="M" <?php if($pt_info[0]->ptn_gender == 'M'){ echo "Selected";}?>>Male</option> 
                                <option value="F" <?php if($pt_info[0]->ptn_gender == 'F'){ echo "Selected";}?>>Female</option>
                                <option value="O" <?php if($pt_info[0]->ptn_gender == 'O'){ echo "Selected";}?>>Other</option>
                            </select>
                    </div>
                </div>

            </div>

            <div class="width100">

                <div class="width50 float_left">

                    <div class="width40 float_left">
                        &nbsp;
                    </div> 

                    <div id="ptn_form_lnk" class="width100 float_left">



                    </div>

                </div>

            </div>

        </div>

        <div id="amb_details_block">
            <div class="width100">
                <h3>Ambulance Details : </h3>
                <div class="width50 float_left">
                    <div class="width40 float_left">
                        <div class="style6 float_left">Ambulance No : </div>
                    </div>
                    <div class="width60 float_left">
                        <select name="amb_reg_id" tabindex="8" id="pcr_amb_id" class="filter_required" data-errors="{filter_required:'Ambulance should not be blank!'}"> 
                            <option value="">Select Ambulance</option>
                            <?php foreach ($vahicle_info as $amb) { ?>
                                <option value="<?php echo $amb->amb_rto_register_no; ?>" <?php if( $amb->amb_rto_register_no == $inc_emp_info[0]->amb_rto_register_no ){ echo "selected"; }?>><?php echo $amb->amb_rto_register_no; ?></option>
                            <?php } ?>
                            <option value="0">Other</option>
                        </select>
                        <input id="add_pcr_amb" class=" onpage_popup float_right" name="add_amb" value="Add Ambulance" data-href="{base_url}/amb/add_amb" data-qr="output_position=popup_div&amp;tool_code=add_ambu" data-popupwidth="1000" data-popupheight="800" type="button" style="display:none;">
<!--                              <input name="amb_reg_id" tabindex="5" class="form_input filter_required" placeholder="Enter Ambulance No" type="text" data-base="search_btn" data-errors="{filter_required:'Ambulance No should not be blank!'}" value="<?= @$inc_emp_info[0]->amb_rto_register_no; ?>">-->
                    </div>
                </div>
                <div class="width50 float_left">
                    <div class="width40 float_left">
                        <div class="style6 float_left">Base Location : </div>
                    </div>
                    <div class="width60 float_left">
                        <input name="base_location" tabindex="9" class="form_input filter_required" placeholder="Enter Base Location" type="text" data-base="search_btn" data-errors="{filter_required:'Base Location should not be blank!'}" value="<?= $inc_emp_info[0]->hp_name; ?>">
                        <input name="base_location_id" tabindex="9" class="form_input filter_required" placeholder="Enter Base Location" type="text" data-base="search_btn" data-errors="{filter_required:'Base Location should not be blank!'}" value="<?= $inc_emp_info[0]->hp_id; ?>">
                    </div>
                </div>

            </div>
            <div class="width100">
                <div class="width50 float_left">
                    <div class="width40 float_left">
                        <div class="style6 float_left">SHP Name : </div>
                    </div>
                    <div class="width60 float_left">
                        <input name="emt_name" tabindex="10" class="form_input filter_required" placeholder="Enter SHP Name" type="text" data-base="search_btn" data-errors="{filter_required:'SHP Name should not be blank!'}" value="<?= $inc_emp_info[0]->emt_name; ?>">
                    </div>
                </div>
                <div class="width50 float_left">
                    <div class="width40 float_left">
                        <div class="style6 float_left">SHP ID : </div>
                    </div>
                    <div class="width60 float_left">
                        <input name="emt_id" tabindex="11" class="form_input filter_required" placeholder="Enter EMT ID" type="text" data-base="search_btn" data-errors="{filter_required:'SHP ID should not be blank!'}" value="<?= $inc_emp_info[0]->amb_emt_id; ?>">
                    </div>
                </div>

            </div>
            <div class="width100">
                <div class="width50 float_left">
                    <div class="width40 float_left">
                        <div class="style6 float_left">Pilot Name : </div>
                    </div>
                    <div class="width60 float_left">
                        <input name="pilot_name" tabindex="12" class="form_input filter_required" placeholder="Enter Pilot Name " type="text" data-base="search_btn" data-errors="{filter_required:'Pilot Name should not be blank!'}"  value="<?= $inc_emp_info[0]->pilot_name; ?>">
                    </div>
                </div>
                <div class="width50 float_left">
                    <div class="width40 float_left">
                        <div class="style6 float_left">Pilot ID : </div>
                    </div>
                    <div class="width60 float_left">
                        <input name="pilot_id" tabindex="13" class="form_input filter_required" placeholder="Enter Pilot ID" type="text" data-base="search_btn" data-errors="{filter_required:'Pilot ID should not be blank!'}" value="<?= $inc_emp_info[0]->amb_pilot_id; ?>">
                    </div>
                </div>

            </div>

            <div class="width100">
                <div class="width50 float_left">
                    <div class="width40 float_left">
                        <div class="style6 float_left">Category : </div>
                    </div>
                    <div class="width60 float_left">
                        <input name="category" tabindex="14" class="form_input filter_required" placeholder="Enter Category" type="text" data-base="search_btn" data-errors="{filter_required:'Category should not be blank!'}" value="<?= @$inc_emp_info[0]->ar_name; ?>" >
                    </div>
                </div>

            </div>
        </div>
<div class="width100">
            <h3>Incident Details : </h3>
            <div class="width50 float_left">
                <div class="width40 float_left">
                    <div class="style6 float_left">District  : </div>
                </div>
                <div class="width60 float_left">
<!--                    <input name="district" tabindex="15" class="mi_autocomplete form_input filter_required" placeholder="Enter District" type="text" data-base="search_btn" data-errors="{filter_required:'District should not be blank!'}" data-href="{base_url}auto/get_district" data-value="<?= @$inc_details[0]->inc_district_id; ?>">-->

                     <select id="district" tabindex="15" name="district" class="change-base-xhttp-request filter_required width_full" data-href="{base_url}auto/get_cty_view" data-qr="output_position=get_cities" data-base="ms_city" data-errors="{filter_required:'District should not be blank'}" <?php echo $view; ?>>
                                        <option value="" >Please select district</option>  
                                        
                                        <?php echo get_district(@$inc_details[0]->inc_district_id);?>


                                    </select>
                </div>
            </div>
            <div class="width50 float_left">
                <div class="width40 float_left">
                    <div class="style6 float_left">Mandal/Taluka : </div>
                </div>
                <div class="width60 float_left">
                    <input name="taluka" tabindex="16" class="mi_autocomplete form_input " placeholder="Enter Mandal/Taluka" type="text" data-base="search_btn" data-errors="{filter_required:'Mandal/Taluka should not be blank!'}"  data-href="{base_url}auto/get_tal" data-value="<?= @$inc_details[0]->inc_tahshil; ?>">
<!--                    <select id="tahshil"  name="tahshil" class="amb_status filter_required change-base-xhttp-request" data-base="ms_city" data-href="{base_url}amb/get_cty_view" data-qr="output_position=get_cities" data-errors="{filter_required:'Tahshil should not be blank'}" <?php echo $view;?>>

                                        <option value="" >Please select district to load tahshil</option>

                                          <?php //echo get_amb_tahshil(@$inc_details[0]->inc_tahshil);?>
                                    </select>-->
                </div>
            </div>

        </div>
        <div class="width100">
            <div class="width50 float_left">
                <div class="width40 float_left">
                    <div class="style6 float_left">City/Village : </div>
                </div>
                <div class="width60 float_left">
          
<!--                    <input name="city" tabindex="17" class="mi_autocomplete  form_input filter_required" placeholder="Enter City/Village " type="text" data-base="search_btn" data-errors="{filter_required:'City/Village should not be blank!'}" data-href="{base_url}auto/city" data-value="<?= @$inc_details[0]->inc_city_id; ?>">-->
                    
        <select id="get_cities" tabindex="17" name="ms_city" data-href="{base_url}auto/city" class="map_canvas controls filter_required change-base-xhttp-request" data-errors="{filter_required:'City should not be blank'}" <?php echo $view;?> data-qr="output_position=get_cities">


                                           <option value="" >Please select city</option>

                                            <?php echo get_city(@$inc_details[0]->inc_district_id,@$inc_details[0]->inc_city_id); ?>

                                         </select>
                </div>
            </div>
            <div class="width50 float_left">
                <div class="width40 float_left">
                    <div class="style6 float_left">Locality   : </div>
                </div>
                <div class="width60 float_left">
                    <input name="locality" tabindex="18" class="form_input filter_required" placeholder="Enter Provider Impressions " type="text" data-base="search_btn" data-errors="{filter_required:'Locality should not be blank!'}" value="<?= @$inc_details[0]->inc_address; ?>" data-value="<?= @$inc_details[0]->inc_address; ?>">
                </div>
            </div>

        </div>
        <div class="width100">
           
            <div class="width50 float_left">
                <div class="width40 float_left">
                    <div class="style6 float_left">LOC : </div>
                </div>
                <div class="width60 float_left">
                     <input name="loc" tabindex="17" class="mi_autocomplete form_input filter_required" placeholder="Enter LOC " type="text" data-base="search_btn" data-errors="{filter_required:'LOC should not be blank!'}" data-href="{base_url}auto/loc_level" value="<?php echo @$inc_details[0]->loc;?>"  data-value="<?= @$inc_details[0]->level_type; ?>">
<!--                     <input type="text" name="asst[asst_loc]"  value="<?php echo $asst[0]->asst_loc;?>" class="mi_autocomplete filter_required ucfirst" data-href="{base_url}auto/loc_level"  placeholder="Enter LOC level" data-errors="{filter_required:'LOC level should not be blank'}" data-value="<?php echo $asst[0]->level_type; ?>" tabindex="1">-->
<!--                    <input name="loc" tabindex="19" class="form_input filter_required" placeholder="Enter LOC " type="text" data-base="search_btn" data-errors="{filter_required:'LOC should not be blank!'}" value="<?= @$inc_details[0]->loc; ?>">-->
                </div>
            </div>
            <div class="width50 float_left">
                <div class="width40 float_left">
                    <div class="style6 float_left">Provider Impressions  : </div>
                </div>
                <div class="width60 float_left">
                    <input name="provider_impressions" tabindex="20" class="form_input filter_required" placeholder="Enter Provider Impressions " type="text" data-base="search_btn" data-errors="{filter_required:'Provider Impressions should not be blank!'}" value="<?= @$inc_details[0]->provider_impressions; ?>">
                </div>
            </div>

        </div>
        <div class="width100">
            <div class="width50 float_left">
                <div class="width40 float_left">
                    <div class="style6 float_left drg">Drugs and consumables used (Separate for Unit and Non  Unit) : </div>
                </div>
                <div class="width60 float_left">
                    <input name="drags" tabindex="21" class="form_input filter_required" placeholder="Enter Drugs and consumables used" type="text" data-base="search_btn" data-errors="{filter_required:'Drugs and consumables used should not be blank!'}" value="<?=$inc_details[0]->drugs ?>">
                </div>
            </div>
            <div class="width50 float_left">
                <div class="width40 float_left">
                    <div class="style6 float_left">Interventions done : </div>
                </div>
                <div class="width60 float_left">
                    <input name="interventions" tabindex="22" class="form_input filter_required" placeholder="Enter Interventions done" type="text" data-base="search_btn" data-errors="{filter_required:'Interventions done should not be blank!'}" value="<?= @$inc_details[0]->interventions_done; ?>">
                </div>
            </div>

        </div>
        <div class="width100">
            <div class="width50 float_left">
                <div class="width40 float_left">
                    <div class="style6 float_left">Name of Receiving Hospital: </div>
                </div>
                <div class="width60 float_left">
                    <input name="receiving_host" tabindex="23" class="mi_autocomplete form_input filter_required" placeholder="Enter Name of Receiving Hospital" type="text" data-base="search_btn" data-errors="{filter_required:'Receiving Hospital Name should not be blank!'}" data-href="{base_url}auto/get_hospital" data-value="<?= @$inc_details[0]->hp_name; ?>" value="<?= @$inc_details[0]->hp_id; ?>">
                </div>
            </div>
            <div class="width50 float_left">
                <div class="width40 float_left">
                    <div class="style6 float_left">Address of Receiving Hospital: </div>
                </div>
                <div class="width60 float_left">
                    <input name="rec_hos_add" tabindex="24" class="form_input filter_required" placeholder="Enter Address of Receiving Hospital" type="text" data-base="search_btn" data-errors="{filter_required:'Address of Receiving Hospital should not be blank!'}" value="<?= @$inc_details[0]->rec_hospital_add; ?>">
                </div>
            </div>

        </div>
        <div class="width100">
            <h3>Driver Parameters : </h3>
            <div class="width50 float_left">
                <div class="width40 float_left">
                    <div class="style6 float_left">Call received: </div>
                </div>
                <div class="width60 float_left">
                    <input name="call_rec_time" tabindex="25" class="form_input filter_required mi_timepicker" placeholder="H:i:s" type="text" data-base="search_btn" data-errors="{filter_required:'Call received should not be blank!'}" value="<?= @$inc_details[0]->call_received; ?>">
                </div>
            </div>
            <div class="width50 float_left">
                <div class="width40 float_left">
                    <div class="style6 float_left">At scene: </div>
                </div>
                <div class="width60 float_left">
                    <input name="at_scene" tabindex="26" class="form_input filter_required mi_timepicker" placeholder="H:i:s" type="text" data-base="search_btn" data-errors="{filter_required:'At scene should not be blank!'}" value="<?= @$inc_details[0]->at_scene; ?>">
                </div>
            </div>

        </div>
        <div class="width100">
            <div class="width50 float_left">
                <div class="width40 float_left">
                    <div class="style6 float_left">From Scene: </div>
                </div>
                <div class="width60 float_left">
                    <input name="from_scene" tabindex="27" class="form_input filter_required mi_timepicker" placeholder="H:i:s" type="text" data-base="search_btn" data-errors="{filter_required:'From Scene should not be blank!'}" value="<?= @$inc_details[0]->from_scene; ?>">
                </div>
            </div>
            <div class="width50 float_left">
                <div class="width40 float_left">
                    <div class="style6 float_left">At Hospital: </div>
                </div>
                <div class="width60 float_left">

                    <input name="at_hospital" tabindex="28" class=" form_input filter_required mi_timepicker" placeholder="H:i:s" type="text" data-base="search_btn" data-errors="{filter_required:'At Hospital should not be blank!'}"  value="<?= @$inc_details[0]->at_hospital; ?>">
                </div>
            </div>

        </div>
        <div class="width100">
            <div class="width50 float_left">
                <div class="width40 float_left">
                    <div class="style6 float_left">Hand over : </div>
                </div>
                <div class="width60 float_left">
                    <input name="hand_over" tabindex="29" class="form_input filter_required mi_timepicker" placeholder="H:i:s" type="text" data-base="search_btn" data-errors="{filter_required:'Hand over  should not be blank!'}" value="<?= @$inc_details[0]->hand_over; ?>">
                </div>
            </div>
            <div class="width50 float_left">
                <div class="width40 float_left">
                    <div class="style6 float_left">Back to base: </div>
                </div>
                <div class="width60 float_left">
                    <input name="back_to_base" tabindex="30" class="form_input mi_timepicker" placeholder="H:i:s" type="text" data-base="search_btn" value="<?= @$inc_details[0]->back_to_base; ?>">
                </div>
            </div>

        </div>
        <div class="width100">
            <div class="width50 float_left">
                <div class="width40 float_left">
                    <div class="style6 float_left">Start Odometer : </div>
                </div>
                <div class="width60 float_left">
                    <input name="start_odmeter" tabindex="31" class="form_input" placeholder="Enter Start Odometer" type="text" data-base="search_btn" value="<?= @$inc_details[0]->start_odometer; ?>">
                </div>
            </div>
            <div class="width50 float_left">
                <div class="width40 float_left">
                    <div class="style6 float_left">END Odometer : </div>
                </div>
                <div class="width60 float_left">
                    <input name="end_odmeter" tabindex="32" class="form_input" placeholder="Enter END Odometer" type="text" data-base="search_btn" value="<?= @$inc_details[0]->end_odometer; ?>">
                </div>
            </div>

        </div>
        <div class="width15 margin_auto">
            <div class=" margin_auto">

                <div class="label">&nbsp;</div>

    <!--                    <input name="search_btn" value="Save" class="style3 base-xhttp-request" data-href="{base_url}/pcr/epcr" data-qr="output_position=content" type="button">-->
                <input type="button" name="Save" value="Save" class="accept_btn form-xhttp-request" data-href='{base_url}/pcr/save_epcr' data-qr='' TABINDEX="33">
            </div> 
        </div>
    </form>
</div>
<script type="text/javascript">

</script>
