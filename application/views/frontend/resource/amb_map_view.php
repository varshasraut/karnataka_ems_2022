<div id="add_inc_details" >  
    <div class="width50 float_left" id="inc_recomended_ambu" style="clear:both;">
                        
             </div>
    <div class="width100 float_left">

                                <div class="label strong">Search Address type</div>

                                <label for="inc_manual_add" class="radio_check width2 float_left">
                                    <input id="inc_manual_add" type="radio" name="addtess_type" class="addtess_type radio_check_input filter_either_or[inc_google_add,inc_manual_add]" value="manual_address" data-errors="{filter_either_or:'Answer is required'}" tabindex="32" autocomplete="off">
                                    <span class="radio_check_holder"></span>Manual Address
                                </label>

                                <label for="inc_google_add" class="radio_check width2 float_left" >
                                    <input id="inc_google_add" type="radio" name="addtess_type" class="addtess_type radio_check_input filter_either_or[inc_google_add,inc_manual_add]" value="google_addres" data-errors="{filter_either_or:'Questions answer is required'}" tabindex="33" autocomplete="off" checked>
                                    <span class="radio_check_holder"></span>Map 
                                </label>
                        </div>
    <input type="hidden" name="incient[amb_type]" id="inc_type" value="add_sup">
                       <?php if($agent_mobile == 'yes'){?>

                 <div class="address_bar">
                              <input id="inc_map_address" placeholder="Enter your address" type="text" class="width_100" style="border-radius:0px !important; width:100% !important; border:7px solid #4688f1" name="incient[place]" TABINDEX="17" data-ignore="ignore" data-state="yes" data-thl="yes" data-dist="yes" data-rel="incient" data-auto="inc_auto_addr" value="<?php echo ($pt_info[0]->inc_address) ? $pt_info[0]->inc_address : "-"; ?>">>
                        </div>
                        <div class="col-md-3" id="search_amb" style="display:none">
                            <input name="amb_reg_id"  id="amb_id" class="mi_autocomplete dropdown_per_page width97" data-href="{base_url}auto/get_ambulance" placeholder="Search Ambulance"  tabindex="2" autocomplete="off" value="" data-value="" data-callback-funct="serch_by_amb_no">
                        </div>

                   <?php } ?>
        <div class="width_100 map_block_outer">
            

<!--            <div class="map_inc_button"><div class="bullet">INCIDENT ADDRESS</div></div>-->
            
            <div class="map_box_inner float_left" id="INCIDENT_MAP">
                
            </div>
            
            <div class="ambulance_box float_left">
                  <?php if($agent_mobile == 'no'){?>
                             <div class="address_bar">
                                 <input id="inc_map_address" placeholder="Enter your address"  type="text" class="width_100" style="border-radius:0px !important; width:100% !important; border: 1px solid #ccc;" name="incient[place]" TABINDEX="11" data-ignore="ignore" value="<?php echo ($pt_info[0]->inc_address) ? $pt_info[0]->inc_address : "-"; ?>">
             </div>
             <div class="col-md-3" id="search_amb" style="display:none">
                            <input name="amb_reg_id"  id="amb_id" class="mi_autocomplete dropdown_per_page width97" data-href="{base_url}auto/get_ambulance" placeholder="Search Ambulance"  tabindex="2" autocomplete="off" value="" data-value="" data-callback-funct="serch_by_amb_no">
                        </div>
                  <?php } ?>
                <a class="click-xhttp-request" style="display: none;" data-href="{base_url}inc/get_inc_ambu?lat=<?=@$inc_details[0]->inc_lat;?>&lng=<?=@$inc_details[0]->inc_long;?>&inc_ref_id=<?=@$inc_details[0]->inc_ref_id;?>" data-qr="module_name=inc&inc_type=add_sup&lat=<?=@$inc_details[0]->inc_lat;?>&lng=<?=@$inc_details[0]->inc_long;?>&inc_ref_id=<?=@$inc_details[0]->inc_ref_id;?>" id="get_ambu_details">get_ambu</a>
                <div id="inc_map_details"></div>
            </div>
            
        </div>
        <div class="width_100 add_outer">
            <div class="width_16 float_left">
                <div id="incient_state">
                    <?php
                    //var_dump($inc_details[0]->inc_state_id);
                    $st = array('st_code' => 'MP', 'auto' => 'inc_auto_addr', 'rel' => 'incient', 'disabled' => '');

                    //echo get_state($st);
                    ?>
                </div>
                <input name="incient_state" value="MP"  class=" width97 filter_required"  style="display: none;">
<!--                <input type="text" name="incient[state]" value="" class=" width100" placeholder="Enter State" data-auto="" id="inc_state" TABINDEX="12">-->
            </div>
            <div class="width_16 float_left">
                <div id="incient_dist">
                            <?php
                            $dt = array('dst_code' => $inc_details[0]->inc_district_id, 'st_code' => $inc_details[0]->inc_state_id, 'auto' => 'inc_auto_addr', 'rel' => 'incient', 'disabled' => '');

                            echo get_district($dt);
                            ?>
                </div>
<!--                <input type="text" name="incient[inc_district]"  value="" class=" width100" placeholder="Enter District" data-auto="" id="inc_district" TABINDEX="13">-->
            </div>
             <div class="width_16 float_left">
                        <div id="incient_tahsil">
                            <?php
                            $thl = array('thl_code' => $inc_details[0]->inc_tahshil_id, 'dst_code' => $inc_details[0]->inc_district_id, 'st_code' => $inc_details[0]->inc_state_id, 'auto' => 'inc_auto_addr', 'rel' => 'incient', 'disabled' => '');

                            echo get_tahshil($thl);
                            ?>
                        </div>
                    </div>
            <div class="width_16 float_left">
<!--                <input type="text" name="incient[inc_city]" value="" class="" placeholder="City / Vilage / Town" data-auto="" id="inc_city" TABINDEX="14">-->
                <div id="incient_city">
                    <?php
                    if($inc_details[0]->inc_city_id == '' || $inc_details[0]->inc_city_id == 0){
                         $city_id = '';
                    }else {
                        $city_id = $inc_details[0]->inc_city_id;
                    }
                    $city = array('cty_id' =>$city_id, 'dst_code' => $district_id,'cty_thshil_code' => $tahsil_id, 'st_code' => $state, 'auto' => 'inc_auto_addr', 'rel' => 'incient', 'disabled' => '');

                    echo get_city_tahsil($city);
                    ?>
                </div>
            </div>
            <div class="width_16 float_left">
                <input type="text" name="incient[area]"  value="" class=" " placeholder="Area / Location" data-auto="" id="area_location" TABINDEX="15">
            </div>
            <div class="width_16 float_left">
                <input type="text" name="incient[landmark]" value="" class=" " placeholder="Landmark" data-auto="" id="street_number" TABINDEX="16">
            </div>
             <!--<div class="width_16 float_left">
                <input type="text" name="incient[lane]" value="" class=" " placeholder="Lane / Street" data-auto="" id="route" TABINDEX="17">
            </div>-->
            
        </div>
        <div class="width_100 add_outer">
            
           <!-- <div class="width_16 float_left">
                <input type="text" name="incient[h_no]" value="" class=" " placeholder="House Number" data-auto="" TABINDEX="18">
            </div>
             <div class="width_16 float_left">
                <input type="text" name="incient[pincode]" value="" class=" " placeholder="PinCode" data-auto="" id="postal_code" TABINDEX="19">
            </div>-->
            <div class="width2 float_left">
                <input type="text" name="incient[google_location]" value="" class="width_100" placeholder="google location map address" data-auto="" id="google_formated_add" style="width: 98%;" TABINDEX="20">
            </div>
</div>
                    <div class="width50 form_field float_left ">
                        <div class="label blue float_left width14">ERO Summary<span class="md_field">*</span>&nbsp;</div>
                        <div class="width50 float_left">
                            <input type="text" name="incient[inc_ero_standard_summary]" data-value="<?= @$inc_details['inc_ero_standard_summary']; ?>" value="<?= @$inc_details['inc_ero_standard_summary_id']; ?>" class="mi_autocomplete filter_required width2"  data-href="{base_url}auto/get_ero_standard_summary?call_type=AD_SUP_REQ"  placeholder="ERO Summary" data-errors="{filter_required:'Please select ERO Summary from dropdown list'}" data-callback-funct="ero_standard_summary_change" TABINDEX="8" >
                        </div>
                    </div>
                    <div class="width50 form_field float_left ">
                        <div class="label blue float_left">ERO Note</div>

                        <div class="width97" id="ero_summary_other">
                            <textarea style="height:60px;" name="incient[inc_ero_summary]" class="" TABINDEX="16" data-maxlen="1600"  data-errors="{filter_required:'ERO Summary should not be blank'}"><?= @$inc_details['inc_ero_summary']; ?></textarea>
                        </div>
                    </div>
            <div class="width_100">
                     
                <div id="SelectedAmbulance" data-ambu_default="1">
          
                  
                </div>
                <div id="StandbyAmbulance">

                </div>
                <?php 
                if($inc_amb){
                    $default_selected_amb = array();
                    foreach($inc_amb as $amb){
                        $default_selected_amb[] = $amb->amb_rto_register_no;
                    } 
                }?>
<!--                <input type="hidden" id="DefaultSelectedAmb" value='<?php echo json_encode($default_selected_amb);?>' >-->
            <input type="hidden" id="DefaultSelectedAmb" value='' >
                <input type="hidden" name="incient[lat]" id="lat" value="">
                <input type="hidden" name="incient[lng]" id="lng" value="">
                <input type="hidden" name="incient[mci_nature]" value="<?php $pt_info[0]->ntr_nature;?>">
                <input type="hidden" name="incient[chief_complete]" value="<?php $pt_info[0]->ct_type;?>">
                
                <!--<input type="hidden" name="call_id" id="call_id" value="<?php // echo $call_id; ?>">-->
                <input type="hidden" name="incient[caller_dis_timer]" id="caller_dis_timer" value="">
                <input type="hidden" name="incient[inc_recive_time]" value="<?php echo $attend_call_time;?>">
                
                <input type="hidden" name="incient[inc_google_add]" id="google_id" value="">
                
  <!--              
                <input type="hidden" name="incient[inc_ero_standard_summary]" value="<?php echo $common_data_form['inc_ero_standard_summary'];?>">
                <input type="hidden" name="incient[inc_ero_summary]" value="<?php echo $common_data_form['inc_ero_summary'];?>">-->
<!--                <div id="fwdcmp_btn"><input name="search_btn" value="FORWARD TO SUPERVISER" class="style4 form-xhttp-request" data-href="{base_url}inc/save_inc?cl_type=forword" data-qr="output_position=content" tabindex="22" type="button"></div>-->
                
            </div>
    </div>

<!--<script type="text/javascript">
    initIncidentMap();
    get_address_ambulance(); 
</script>-->
  <script>
      
    setTimeout(function(){ 
        if(!(google)){
            $("#inc_manual_add").click();
            xhttprequest($(this),base_url+'inc/get_inc_ambu?inc_ref_id=<?=@$inc_details[0]->inc_ref_id;?>','data-qr=""');  
        }
        
    },100);
    
     xhttprequest($(this),base_url+'inc/get_inc_ambu?inc_type=add_sup&lat=<?=@$inc_details[0]->inc_lat;?>&lng=<?=@$inc_details[0]->inc_long;?>&inc_ref_id=<?=@$inc_details[0]->inc_ref_id;?>','data-qr=module_name=inc&inc_type=add_sup&lat=<?=@$inc_details[0]->inc_lat;?>&lng=<?=@$inc_details[0]->inc_long;?>&inc_ref_id=<?=@$inc_details[0]->inc_ref_id;?>');
    
   
    if(typeof H != 'undefined'){
        initIncidentMap();
        // get_tahshil_ambulance();
     }
    </script>