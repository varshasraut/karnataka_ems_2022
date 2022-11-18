<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
<ul class="inc_ambu_list">
    <table class="border" style="margin-top:0px;">
        <tr>
            <th class="amb_h3">District</th>
            <th class="amb_h3">Base Location</th>
            <th class="amb_h3">Ambulance No</th>
            <th class="amb_h3">Type</th>
            <th class="amb_h3">Distance</th>
            <th class="amb_h3" width="80">ETA</th>
            <th class="amb_h3">EMT</th>
            <th class="amb_h3">Pilot</th>
            <th class="amb_h3">GPS Date Time</th>
            <th class="amb_h3">Show</th>
            <th class="amb_h3">Status</th>
            <!--            <th class="amb_h3">Type</th>-->
            <th class="amb_h3">Action </th>

        </tr>
        <?php
        $key = 1;
    
        if ($ambu_data) {
            $grouped = array();
            foreach ($ambu_data as $item) {
                $grouped[$item->amb_status][] = $item;
            } ?>
            <!--         <tr style="height: 3px; border-top:3px solid #2acfca;"></tr>-->

            <?php
            foreach ($ambu_data as $amb_key => $ambu) {



                $tap_index = 0;
                $tap_index_st = $tap_index + 1;
                $emso_id = get_amb_login_status($ambu->amb_id);

                $pilot_no = '';
                $emso_no = '';
                if ($emso_id) {
                    foreach ($emso_id as $emso) {
                        if ($emso->login_type == 'D') {
                            $pilot_no = $emso->clg_mobile_no;
                        } else if ($emso->login_type == 'P') {
                            $emso_no = $emso->clg_mobile_no;
                        }
                    }
                }

            ?>
                <?php  // "ambu_item" this class is used in inc_map.js for ambulance search 
                ?>
                <tr id="Search_Amb_<?php echo trim($ambu->amb_id); ?>" class="searched_ambu_item" data-amb_id="<?php echo trim($ambu->amb_id); ?>" data-rto-no="<?php echo trim($ambu->amb_rto_register_no); ?>" data-lat="<?php echo $ambu->amb_lat ?>" data-lng="<?php echo $ambu->amb_log ?>" data-title="<?php echo $ambu->hp_name ?>" data-amb_type="<?php echo trim($ambu->amb_type); ?>" data-amb_status="<?php echo trim($ambu->amb_type); ?><?php echo $ambu->amb_status; ?>" data-amb_geofence="<?php echo $ambu->geo_fence ?>" style="clear: both; width: 100%;">

                    <td><?php echo get_district_by_id($ambu->amb_district); ?></td>
                    <td><?php if ($ambu->hp_name == '') {
                            echo $ambu->mumbai_wrd_nm;
                        } else {
                            echo $ambu->hp_name;
                        } ?></td>
                    <td class="width15"><?php echo $ambu->amb_rto_register_no; ?></td>
                    <td><?php echo $ambu->ambt_name; ?></td>
                    <td class="width10"><?php echo $ambu->road_distance ?></td>
                    <td><?php echo $ambu->duration; ?></td>
                    <td class="width10">

                        <?php


                        $incoming_call_ip_phone = $this->session->userdata('incoming_call_ip_phone');
                        // var_dump($incoming_call_ip_phone);
                        if ($ambu->amb_default_mobile != '') {
                            if ($incoming_call_ip_phone == 'no') {
                        ?>(O)-
<!--                        <a class="click-xhttp-request" data-href="{base_url}api_v2/soft_dial" data-qr="output_position=content&mobile_no=00<?php echo $ambu->amb_default_mobile; ?>"><?php echo $ambu->amb_default_mobile; ?></a>-->
                        <?php if($call_action == 'C'){?>
                         <a class="click-xhttp-request" onclick1="copy_text('<?php echo $ambu->amb_id;?>_amb_default_mobile')" id="<?php echo $ambu->amb_id;?>_amb_default_mobile" data-href="{base_url}api_v2/conference_call" data-qr="output_position=content&mobile_no=<?php echo $ambu->amb_default_mobile; ?>"><?php echo $ambu->amb_default_mobile; ?></a>
                        <?php }{ ?>
                        <a class="click-xhttp-request" onclick1="copy_text('<?php echo $ambu->amb_id;?>_amb_default_mobile')" id="<?php echo $ambu->amb_id;?>_amb_default_mobile" data-href="{base_url}api_v2/soft_dial" data-qr="output_position=content&mobile_no=<?php echo $ambu->amb_default_mobile; ?>"><?php echo $ambu->amb_default_mobile; ?></a>
                        <?php  } ?>
                        <a onclick="copy_text('<?php echo $ambu->amb_id;?>_pilot_no')" class="copy_text_icon"></a>
                    <?php } else { ?>
                        (O)- <?php if($call_action == 'C'){?>
                        <a class="click-xhttp-request" onclick1="copy_text('<?php echo $ambu->amb_id;?>_amb_default_mobile')" id="<?php echo $ambu->amb_id;?>_amb_default_mobile"  data-href="{base_url}api_v2/conference_call" data-qr="output_position=content&mobile_no=<?php echo $ambu->amb_default_mobile; ?>"><?php echo $ambu->amb_default_mobile; ?></a>
                            <?php }else{ ?>
                        <a class="click-xhttp-request" onclick1="copy_text('<?php echo $ambu->amb_id;?>_amb_default_mobile')" id="<?php echo $ambu->amb_id;?>_amb_default_mobile"  data-href="{base_url}api_v2/soft_dial" data-qr="output_position=content&mobile_no=<?php echo $ambu->amb_default_mobile; ?>"><?php echo $ambu->amb_default_mobile; ?></a>
                            <?php } ?>
                        <a onclick="copy_text('<?php echo $ambu->amb_id;?>_pilot_no')" class="copy_text_icon"></a>
                        <?php }
                        }

                        if ($emso_no != '') {
                            if ($incoming_call_ip_phone == 'no') {
                        ?>(P)-
<!--                        <a class="click-xhttp-request" data-href="{base_url}api_v2/soft_dial" data-qr="output_position=content&mobile_no=00<?php echo $emso_no; ?>"><?php echo $emso_no; ?></a>-->
                       <?php if($call_action == 'C'){?>
                        <a class="click-xhttp-request" onclick1="copy_text('<?php echo $ambu->amb_id;?>_emso_number')" id="<?php echo $ambu->amb_id;?>_emso_number" data-href="{base_url}api_v2/conference_call" data-qr="output_position=content&mobile_no=<?php echo $emso_no; ?>"><?php echo $emso_no; ?></a>
                            <?php }else{ ?> <a class="click-xhttp-request" onclick1="copy_text('<?php echo $ambu->amb_id;?>_emso_number')" id="<?php echo $ambu->amb_id;?>_emso_number" data-href="{base_url}api_v2/soft_dial" data-qr="output_position=content&mobile_no=<?php echo $emso_no; ?>"><?php echo $emso_no; ?></a>
                            <?php } ?>
                        <a onclick="copy_text('<?php echo $ambu->amb_id;?>_pilot_no')" class="copy_text_icon"></a>
                    <?php } else { ?>
                        (P)-
<!--                        <a class="click-xhttp-request " data-href="{base_url}api_v2/soft_dial" data-qr="output_position=content&mobile_no=00<?php echo $emso_no; ?>"><?php echo $emso_no; ?></a>-->
                        <?php if($call_action == 'C'){?>
                        <a class="click-xhttp-request" onclick1="copy_text('<?php echo $ambu->amb_id;?>_emso_number')" id="<?php echo $ambu->amb_id;?>_emso_number" data-href="{base_url}api_v2/conference_call" data-qr="output_position=content&mobile_no=<?php echo $emso_no; ?>"><?php echo $emso_no; ?></a>
                        
                            <?php }else{ ?> <a class="click-xhttp-request" onclick1="copy_text('<?php echo $ambu->amb_id;?>_emso_number')" id="<?php echo $ambu->amb_id;?>_emso_number" data-href="{base_url}api_v2/soft_dial" data-qr="output_position=content&mobile_no=<?php echo $emso_no; ?>"><?php echo $emso_no; ?></a> <?php } ?>
                        
                        <a onclick="copy_text('<?php echo $ambu->amb_id;?>_pilot_no')" class="copy_text_icon"></a>
                <?php }
                        }
                ?>
                    </td>
                    <td class="width10">
                        <?php
                        if ($ambu->amb_pilot_mobile != '') {
                            if ($incoming_call_ip_phone == 'no') {
                                //$pilot = get_clg_data_by_ref_id($ambu->tm_pilot_id); 

                                //echo $pilot[0]->clg_mobile_no;    
                        ?>
<!--                                <a id="pilot_no" class="click-xhttp-request" data-href="{base_url}api_v2/soft_dial" data-qr="output_position=content&mobile_no=00<?php echo $ambu->amb_pilot_mobile; ?>"><?php echo $ambu->amb_pilot_mobile; ?>(O)</a>-->
                          <?php if($call_action == 'C'){?>
                       <a class="click-xhttp-request" id="<?php echo $ambu->amb_id;?>_pilot_no" onclick1="copy_text('<?php echo $ambu->amb_id;?>_pilot_no')"  data-href="{base_url}api_v2/conference_call" data-qr="output_position=content&mobile_no=<?php echo $ambu->amb_pilot_mobile; ?>"><?php echo $ambu->amb_pilot_mobile; ?>(O)</a>
                            <?php }else{ ?>
                         <a class="click-xhttp-request" id="<?php echo $ambu->amb_id;?>_pilot_no" onclick1="copy_text('<?php echo $ambu->amb_id;?>_pilot_no')"  data-href="{base_url}api_v2/soft_dial" data-qr="output_position=content&mobile_no=<?php echo $ambu->amb_pilot_mobile; ?>"><?php echo $ambu->amb_pilot_mobile; ?>(O)</a>
                            <?php } ?>
                         <a onclick="copy_text('<?php echo $ambu->amb_id;?>_pilot_no')" class="copy_text_icon"></a>
                            <?php } else { ?>

                         (O)- <?php if($call_action == 'C'){?>
                       <a class="click-xhttp-request" id="<?php echo $ambu->amb_id;?>_pilot_no" onclick1="copy_text('<?php echo $ambu->amb_id;?>_pilot_no')"  data-href="{base_url}api_v2/conference_call" data-qr="output_position=content&mobile_no=<?php echo $ambu->amb_pilot_mobile; ?>"><?php echo $ambu->amb_pilot_mobile; ?></a>
                            <?php }else{ ?><a class="click-xhttp-request" id="<?php echo $ambu->amb_id;?>_pilot_no" onclick1="copy_text('<?php echo $ambu->amb_id;?>_pilot_no')"  data-href="{base_url}api_v2/soft_dial" data-qr="output_position=content&mobile_no=<?php echo $ambu->amb_pilot_mobile; ?>"><?php echo $ambu->amb_pilot_mobile; ?></a>
                            <?php } ?>
                         <a onclick="copy_text('<?php echo $ambu->amb_id;?>_pilot_no')" class="copy_text_icon"></a>
<!--                                <a class="click-xhttp-request" data-href="{base_url}api_v2/soft_dial" data-qr="output_position=content&mobile_no=00<?php echo $ambu->amb_pilot_mobile; ?>"><?php echo $ambu->amb_pilot_mobile; ?></a>-->
                                <!--                     <a class="click-xhttp-request " data-href="{base_url}api_v2/soft_dial" data-qr="output_position=content&mobile_no=00<?php echo $ambu->amb_pilot_mobile; ?>"><?php echo $ambu->amb_pilot_mobile; ?>(O)</a>-->
                        <?php }
                        } ?><br>
                        <?php

                        if ($pilot_no != '') {
                            if ($incoming_call_ip_phone == 'no') {
                                //$pilot = get_clg_data_by_ref_id($ambu->tm_pilot_id); 

                                //echo $pilot[0]->clg_mobile_no;    
                        ?>
                                (P)-
<!--                                <a class="click-xhttp-request" data-href="{base_url}api_v2/soft_dial" data-qr="output_position=content&mobile_no=00<?php echo $pilot_no; ?>"><?php echo $pilot_no; ?></a>-->
                                <?php if($call_action == 'C'){?>
                       <a class="click-xhttp-request" id="<?php echo $ambu->amb_id;?>_pilot_mo_no" onclick1="copy_text('<?php echo $ambu->amb_id;?>_pilot_mo_no')" data-href="{base_url}api_v2/conference_call" data-qr="output_position=content&mobile_no=<?php echo $pilot_no; ?>"><?php echo $pilot_no; ?></a>
                            <?php }else{ ?>
                                 <a class="click-xhttp-request" id="<?php echo $ambu->amb_id;?>_pilot_mo_no" onclick1="copy_text('<?php echo $ambu->amb_id;?>_pilot_mo_no')" data-href="{base_url}api_v2/soft_dial" data-qr="output_position=content&mobile_no=<?php echo $pilot_no; ?>"><?php echo $pilot_no; ?></a>
                            <?php } ?>
                                  <a onclick="copy_text('<?php echo $ambu->amb_id;?>_pilot_no')" class="copy_text_icon"></a>
                            <?php } else { ?>
                                (P)-
                                <?php if($call_action == 'C'){?>
                   <a class="click-xhttp-request" id="<?php echo $ambu->amb_id;?>_pilot_mo_no" onclick1="copy_text('<?php echo $ambu->amb_id;?>_pilot_mo_no')"data-href="{base_url}api_v2/conference_call" data-qr="output_position=content&mobile_no=<?php echo $pilot_no; ?>"><?php echo $pilot_no; ?></a>
                            <?php }else{ ?>
                                <a class="click-xhttp-request" id="<?php echo $ambu->amb_id;?>_pilot_mo_no" onclick1="copy_text('<?php echo $ambu->amb_id;?>_pilot_mo_no')"data-href="{base_url}api_v2/soft_dial" data-qr="output_position=content&mobile_no=<?php echo $pilot_no; ?>"><?php echo $pilot_no; ?></a>
                            <?php } ?>
                                 <a onclick="copy_text('<?php echo $ambu->amb_id;?>_pilot_no')" class="copy_text_icon"></a>
<!--                                <a class="click-xhttp-request" data-href="{base_url}api_v2/soft_dial" data-qr="output_position=content&mobile_no=00<?php echo $pilot_no; ?>"><?php echo $pilot_no; ?></a>-->
                                <!--                     <a class="click-xhttp-request " data-href="{base_url}api_v2/soft_dial" data-qr="output_position=content&mobile_no=00<?php echo $ambu->amb_pilot_mobile; ?>"><?php echo $pilot_no; ?>(P)</a>-->
                        <?php }
                        } ?>

                    </td>
                    <td class="width10"><?php echo $ambu->gps_date_time; ?></td>
                    <td class="width10"><a class="click-xhttp-request pending_closure" data-href="{base_url}inc/show_amb_inc_details" data-qr="output_position=content&amb_reg_no=<?php echo $ambu->amb_rto_register_no; ?>"></a></td>
                    <td class="width10"><?php echo $ambu->ambs_name; ?></td>
                    <!--            <td class="width10">
                <?php if ($ambu->amb_user_type == 'bike') {
                    echo "Bike";
                } else if ($ambu->amb_user_type == 'tdd') {
                    echo "TDD";
                } else if ($ambu->amb_user_type == '108') {
                    echo "MEMS";
                } ?>
            </td>-->
                    <td class="width15">
                        <?php // var_dump($ambu); 
                        ?>
                        <?php
                        if ($user_group == 'UG-ERO-102') {
                            if ($ambu->amb_type != '2') {
                                $disabled = "readonly=readonly";
                            }
                        }
                        //var_dump($ambu->assign);
                        if ($ambu->assign  == 'assign') {
                            $checked = "checked";
                        } else {
                            $checked = "";
                        }

                        if ($ambu->assign  == 'standby') {
                            $checked1 = "checked";
                        } else {
                            $checked1 = "";
                        }

                        ?>
                        <input type="checkbox" name="select_amb" value="" class="amb_check_box float_left" <?php if ($ambu->amb_status == 6) {
                                                                                                                echo "disabled";
                                                                                                            } ?> id="check<?php echo trim($ambu->amb_id); ?>" style="margin-top:9px;" <?php $disabled; ?> <?php echo $checked; ?>><label for="check<?php echo trim($ambu->amb_id); ?>" tabindex="17.<?php echo $tap_index; ?>">Assign</label> <br>
                        <input type="checkbox" name="select_amb1" value="" onclick="denialamb('<?php echo $ambu->amb_rto_register_no ?>','<?php echo $ambu->amb_district ?>','<?php echo $ambu->hp_name ?>','<?php echo $ambu->amb_default_mobile; ?>','<?php echo $ambu->amb_pilot_mobile; ?>');" class="amb_check_box1 float_left deniel" <?php if ($ambu->amb_status == 6) {
                                                                                                                                                                                                                                                                                                                                                echo "disabled";
                                                                                                                                                                                                                                                                                                                                            } ?> id="check_de<?php echo trim($ambu->amb_id); ?>" style="margin-top:9px;" <?php $disabled; ?> <?php echo $checked; ?>><label for="check_de<?php echo trim($ambu->amb_id); ?>" tabindex="17.<?php echo $tap_index; ?>">Denial</label><br>

                        <?php
                        if ($inc_type == 'MCI') { ?>
                            <input type="checkbox" name="standby_amb" value="" data-stand_amb_id="<?php echo trim($ambu->amb_id); ?>" class="float_left amb_stand_check_box" id="check_St<?php echo trim($ambu->amb_id); ?>" style="margin-top:9px;" <?php echo $checked1; ?>><label for="check_St<?php echo trim($ambu->amb_id); ?>" tabindex="17.<?php echo $tap_index_st; ?>">Standby</label>
                        <?php } ?>



                        <div class="ambu_pin_info" style="display: none;">
                            <div style="width:250px;">

                                <?php $amb_map_box  = "";
                                $amb_map_box .=  '<strong>' . $ambu->hp_name . '</strong>';
                                $amb_map_box .= '<br>';
                                $amb_map_box .=  '<strong>Distance: </strong>' . $ambu->road_distance;
                                $amb_map_box .= '<br>';
                                $amb_map_box .=  '<strong>Duration: </strong>' . $ambu->duration;
                                $amb_map_box .= '<br>';
                                $amb_map_box .= '<strong>RTO No: </strong>' . $ambu->amb_rto_register_no;
                                $amb_map_box .= '<br>';
                                echo $amb_map_box .= '<strong>Mobile No: </strong>' . $ambu->amb_default_mobile; ?>
                            </div>
                        </div>
                    </td>
                </tr>
            <?php }
        } else { ?>
            <tr>
                <td colspan="9" class="text_align_center">No record Found</td>
            </tr>
        <?php } ?>
    </table>

    <div class="modal loginmodal denial_block" tabindex="-1" role="dialog" id="savereason" style="backdrop-filter: blur(2px);">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" style="font-weight: bold;color:whitesmoke">Denial Reasons</h5>

                    <button type="button" class="close" onclick="hidepopup()" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" style="color: whitesmoke;">&times;</span>
                </div>
                <div class="modal-body">
                    <div>
                        <!-- <label for="" style="color: whitesmoke;">Ambulance No :</label>
                        <label id='amb_no' style="color: whitesmoke;"></label> -->

                        <label for="" style="color: whitesmoke;">Base Location :</label>
                        <label id='hp_name' style="color: whitesmoke;"></label>
                        <!-- <label for="" style="color: whitesmoke;">ERO Name :</label> -->
                        <input type="hidden" id="amb_no" name="amb_no">
                        <input type="hidden" id="amb_district" name="amb_district">
                        <input type="hidden" id="amb_default_mobile" name="amb_default_mobile">
                        <input type="hidden" id="amb_pilot_mobile" name="amb_pilot_mobile">

                    </div>
                     <div id="conversation_done_emso">
                         <select id="conversation_done" name="conversation_done" onchange="show_conv('hidden_div', this)">
                            <option value="">Select Conversation Done With</option>
                            <option value="emso">EMT</option>
                            <option value="pilot">Pilot</option>
                            <option value="other">Other</option>
                        </select>
                    </div>
<!--                    <div id="conversation_emso">
                        <input style="margin-top: 10px;" name="conversation_name"  class="mi_autocomplete" data-href="<?php echo base_url(); ?>auto/get_all_user" data-value="<?php echo $inc_details[0]->emso_id; ?>" value="<?php echo $inc_details[0]->emso_id; ?>" type="text" tabindex="1" placeholder="Conversation Done With"  data-errors="{filter_required:'Conversation Done With should not be blank!'}" id="conversation_name" data-qr="clg_group=UG-EMT">
                    </div>-->
                    <div id="checkedValue">
                        <input type="checkbox" class="check_class" id="challenge1" onclick="showerc()" name="challenge1" value="EMT Related Challenges">
                        <label for="challenge1" id="clg1">EMT Related Challenges</label><br>
                        <input type="checkbox" class="check_class" id="challenge2" onclick="showprc()" name="challenge1" value="Pilot Related Challenges">
                        <label for="challenge2" id="clg2">Pilot Related Challenges</label><br>
                        <input type="checkbox" class="check_class" id="challenge3" onclick="showeqrc()" name="challenge1" value="Equipment Related Challenges">
                        <label for="challenge3" id="clg3">Equipment Related Challenges</label><br>
                        <input type="checkbox" class="check_class" id="challenge4" onclick="showtrc()" name="challenge1" value="Ambulance & Technical Related Challenges">
                        <label for="challenge4" id="clg4">Ambulance & Technical Related Challenges </label><br><br>
                        <!-- <select id="challenges" name="challenges" onchange="showDiv('hidden_div', this)">
                            <option value="1">EMT Related Challenges</option>
                            <option value="2">Pilot Related Challenges</option>
                            <option value="3">Equipment Related Challenge</option>
                            <option value="4">Ambulance & Technical Related Challenge</option>
                        </select> -->
                    </div>

                    <div id="erc_pilot">
                         <input name="pilot_id"  class="mi_autocomplete" data-href="<?php echo base_url(); ?>auto/get_ambulance_login_pilot/D" data-value="<?php echo $inc_details[0]->pilot_id; ?>" value="<?php echo $inc_details[0]->pilot_id; ?>" type="text" tabindex="1" placeholder="PILOT"   data-errors="{filter_required:'PILOT should not be blank!'}" id="pilot_id">
                    </div>
                    <div id="erc_emso">
                        <input name="emso_id"  class="mi_autocomplete" data-href="<?php echo base_url(); ?>auto/get_ambulance_login_pilot/P" data-value="<?php echo $inc_details[0]->emso_id; ?>" value="<?php echo $inc_details[0]->emso_id; ?>" type="text" tabindex="1" placeholder="EMT"  data-errors="{filter_required:'EMT should not be blank!'}" id="emso_id">
                    </div>
                    <div id="erc">
                        <select style="width: 95%;" TABINDEX="7" id="emso_challenge">
                            <option value="">Select Challenge</option>
                            <?php 
                            foreach ($emso_challenge as $emso) { ?>
                                <option value="<?php echo $emso->id; ?>"><?php echo $emso->meaning; ?></option>
                            <?php } ?>

                        </select>
                    </div>
                    <div id="prc">
                        <select style="width: 95%;" TABINDEX="7" id="pilot_challenge">
                            <option value="">Select Challenge</option>
                            <?php foreach ($pilot_challenge as $pilot) { ?>
                                <option value="<?php echo $pilot->id; ?>"><?php echo $pilot->meaning; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div id="eqrc">
                        <select style="width: 95%;" TABINDEX="7" id="equipment_challenge">
                            <option value="">Select Challenge</option>
                            <?php foreach ($equipment_challenge as $equi) { ?>
                                <option value="<?php echo $equi->id; ?>"><?php echo $equi->meaning; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div id="trc">
                        <select style="width: 95%;" TABINDEX="7" id="tech_challenge">
                            <option value="">Select Challenge</option>
                            <?php foreach ($tech_challenge as $tech) { ?>
                                <option value="<?php echo $tech->id; ?>"><?php echo $tech->meaning; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                     <div id="other">
                         <textarea style="height:60px; margin-top: 10px;" id="denial_remark" name="denial_remark" class="width_100 " TABINDEX="16" data-maxlen="1600" placeholder="Kindly mentioned the confirmed by name and Designation"  data-errors="{filter_required:'Remark should not be blank'}"></textarea>
                    </div>
                    <div class="beforeunload" style="text-align: center;padding-top:10px;">
                        <input class="remove_beforeunload" type="button" name="save" value="Submit" onclick="submit_denial()" style="background:whitesmoke;color:black !important;">

                    </div>
                </div>
            </div>
        </div>

    </div>

</ul>
<script>
    update_ambulance_inc_map();
</script>

<style>
    #clg1,
    #clg2,
    #clg3,
    #clg4 {
        color: whitesmoke;
    }

    input[type=checkbox]:checked+label {
        color: red;
    }

    .modal-dialog {
        padding-top: 50px !important;
        max-width: 400px !important;

    }

    .modal-content {
        background-color: #085b80;
    }
</style>

<script>

</script>