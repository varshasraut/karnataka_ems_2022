<div class="row">
<?php if ($this->session->flashdata('success')) { ?>
	<h3>
		<?php echo $this->session->flashdata('success'); ?>
	</h3>
<?php } ?>
<?php if ($this->session->flashdata('error')) { ?>
	<h3>
		<?php echo $this->session->flashdata('error'); ?>
	</h3>
<?php } ?>
      </div>
<form method="post" name="epcr_inc_form" id="job_closer_inc_list">

    <br>
    <a class="click-xhttp-request" style="visibility: hidden;" data-href="{base_url}clinical/clinical_list" data-qr="output_position=content&showprocess=no">refresh</a>
    <div id="amb_filters">

        <div class="width100">

            <div class="width_8 float_left">
                <h3 class="txt_clr5 width2 float_left" style="font-size:20px;">Search</h3>
            </div>
            <?php if ($clg_senior) { ?>
                <div class="width25 float_left">
                    <select id="dco_id" name="dco_id" class="" data-errors="{filter_required:'Please select PDA from dropdown list'}">
                        <option value="">Select DCO User</option>
                        <?php
                        foreach ($dco_clg as $purpose_of_call) {
                            if ($purpose_of_call->clg_ref_id == $dco_id) {
                                $selected = "selected";
                            } else {
                                $selected = "";
                            }
                            echo "<option value='" . $purpose_of_call->clg_ref_id . "'  $selected";

                            echo " >" . $purpose_of_call->clg_ref_id . "-" . $purpose_of_call->clg_first_name . " " . $purpose_of_call->clg_first_name;
                            echo "</option>";
                        }
                        ?>
                    </select>
                </div>
            <?php } ?>
            <div class="width_10 float_left">

                <select name="filter" class="dropdown_per_page width90" data-base="search" id="epcr_filter_list" hidden>
                    <option value="">Select</option>
                    <!-- <option value="inc_datetime" <?php if ($filter == 'inc_datetime') {
                                                        echo "selected";
                                                    } ?>>Date</option> -->
                    <!-- <option value="dst_name" <?php if ($filter == 'dst_name') {
                                                    echo "selected";
                                                } ?>>District</option> -->
                    <!-- <option value="hp_name" <?php if ($filter == 'hp_name') {
                                                echo "selected";
                                            } ?>>Base Location</option> -->
                    <!--    <option value="clg.clg_first_name"  <?php if ($filter == 'clg.clg_first_name') {
                                                                    echo "selected";
                                                                } ?>>EMT</option>-->
                    <!-- <option value="amb_reg_no" <?php if ($filter == 'amb_reg_no') {
                                                    echo "selected";
                                                } ?>>Ambulance No</option> -->
                    <!-- <option value="inc_ref_id" <?php if ($filter == 'inc.inc_ref_id') {
                                                    echo "selected";
                                                } ?>>Incident ID</option> -->
                    <option selected="selected" value="close_by_emt" <?php if ($filter == 'close_by_emt') {
                                                        echo "selected";
                                                    } ?>>Closed by EMT/Pilot</option>
                    <!-- <option value="reopen_id" <?php if ($filter == 'reopen_id') {
                                                    echo "selected";
                                                } ?>>Reopen Id</option> -->
                    <!--                     <option value="inc.inc_bvg_ref_number"  <?php if ($filter == 'inc.inc_bvg_ref_number') {
                                                                                            echo "selected";
                                                                                        } ?>>108 Ref ID</option>-->
                </select>
            </div>
            <?php // 
            ?>
            <!-- <div id="amb_list" class="width_10 float_left">
                <input name="amb_reg_id" class="mi_autocomplete dropdown_per_page width97" data-href="{base_url}auto/get_ambulance" placeholder="Select Ambulance" data-errors="{filter_required:'Please select state from dropdown list'}" tabindex="15" autocomplete="off" value="<?php echo $amb_reg_id; ?>" data-value="<?php echo $amb_reg_id; ?>">

            </div> -->

            <div id="district_list" class="width_10 float_left "><?php if ($district_id != '') {
                                                                                    $district_name = get_district_by_id($district_id);
                                                                                } ?>


                <input name="district_id" class="mi_autocomplete width97" data-href="{base_url}auto/get_district/<?php echo $default_state; ?>" placeholder="District" data-errors="{filter_required:'Please select state from dropdown list'}" tabindex="15" autocomplete="off" data-value="<?php echo $district_name; ?>" value="<?php echo $district_id; ?>">
            </div>
            <!-- <div id="baselocation_list" class="width_10 float_left ">

                <?php if ($hp_id != '') {
                    $hp_data = get_base_location_by_id($hp_id);
                    $hp_name = $hp_data[0]->hp_name;
                } ?>
                <input name="hp_id" tabindex="7.2" class="mi_autocomplete form_input " placeholder="Base Location" type="text" data-errors="{filter_required:'Please select hospital from dropdown list'}" data-href="{base_url}auto/get_hospital_with_ambu" data-value="<?php echo $hp_name; ?>" value="<?php echo $hp_id; ?>">
            </div> -->
            <div id="date_box" class="width_10 float_left " style="<?php if ($inc_date != '') {
                                                                        echo 'display:block;';
                                                                    } else {
                                                                        echo 'display:none;';
                                                                    } ?>">
                <input name="inc_date" tabindex="7.2" class="mi_calender form_input" placeholder="Date" type="text" data-errors="{filter_required:'Please select hospital from dropdown list'}" value="<?php echo $inc_date; ?>">
            </div>
            <div id="inc_id_box" class="width_10 float_left ">
                <input name="inc_id" tabindex="7.2" class=" form_input" placeholder="Incident ID" type="text" data-errors="{filter_required:'Please select hospital from dropdown list'}">
            </div>
            <div id="close_by_emt1" class="width_15 float_left">
                <input name="amb_reg_id_new" class="mi_autocomplete dropdown_per_page width97" data-href="{base_url}auto/get_ambulance" placeholder="Select Ambulance" data-errors="{filter_required:'Please select state from dropdown list'}" tabindex="15" autocomplete="off" value="<?php echo $amb_reg_id; ?>" data-value="<?php echo $amb_reg_id; ?>">
            </div>


            <div id="epcr_call_type" class="width_10 float_left">
                <?php
                if ($epcr_call_types == 1) {
                    $call_type  = "Patient Not Available";
                } elseif ($epcr_call_types == 2) {
                    $call_type  = "Patient Available";
                } elseif ($epcr_call_types == 3) {
                    $call_type  = "On Scene Care";
                }
                ?>
                <input name="epcr_call_type" tabindex="4" class="mi_autocomplete form_input " placeholder="Call Type" type="text" data-base="search_btn" data-errors="{filter_required:'Plase select provider from dropdown list'}" value="<?php echo @$epcr_call_types; ?>" data-value="<?php echo $call_type; ?>" data-href="{base_url}auto/get_call_type_epcr" data-qr="reopen=<?php echo $reopen; ?>" id="epcr_call_type">
            </div>
            <div id="provider_casetype" class="width_10 float_left">
                <?php if (@$provider_casetype != '') {
                    $provider_case = get_provider_case_type($provider_casetype);
                } ?>
                <input name="provider_casetype" tabindex="4" class="mi_autocomplete form_input " placeholder="Case Type" type="text" data-base="search_btn" data-errors="{filter_required:'Plase select Case type from dropdown list'}" value="<?= @$provider_casetype; ?>" data-value="<?= @$provider_case; ?>" data-href="{base_url}auto/get_providercase_type" data-qr="" id="provider_casetype">
            </div>
            <div id="provider_impression" class="width_10 float_left" >
                <?php if (@$provider_impressions != '') {
                    $provider_impressions_data = get_provider_impression(@$provider_impressions);
                } ?>

                <input name="provider_impressions" tabindex="4" class="mi_autocomplete form_input " placeholder="Provider Impressions" type="text" data-base="search_btn" data-errors="{filter_required:'Plase select provider from dropdown list'}" value="<?= @$provider_impressions; ?>" data-value="<?php echo $provider_impressions_data; ?>" data-href="{base_url}auto/get_provider_imp" data-qr="">
            </div>

            <div class="float_left">
                <input type="button" class="search_button float_left form-xhttp-request" name="" value="Search" data-href="{base_url}clinical/clinical_list" data-qr="output_position=content&amp;flt=true" id="job_closer_autoload" />
                <input class="search_button click-xhttp-request float_right" name="" value="Reset Filters" data-href="{base_url}clinical/clinical_list" data-qr="output_position=content&amp;filters=reset" type="button">
            </div>
        </div>

    </div>

    <div id="list_table">
      

        <table class="table report_table">
            <tr>
                <th nowrap>Date Of Incident</th>
                <th nowrap>Date Of Closure</th>
                <th>Incident ID</th>
                <th nowrap>Base Location</th>
                <th nowrap>Ambulance No</th>
                <th nowrap> District Name</th>
                <th nowrap> Default No</th>
                <th nowrap> Pilot No</th>
                <th nowrap>Patient Count</th>
                    <th nowrap>Call Type</th>
                    <th nowrap>Closed By</th>
                    <th nowrap>Remark</th>
                    <th nowrap>Patient Availability</th>
                
                <th>Action</th>
            </tr>



            <?php
            $closure_button = array();
            if (count(@$inc_info) > 0) {
                $inc_offset = $inc_offset + 1;
                $total = 0;
                foreach ($inc_info as $key => $inc) {
                    // var_dump($inc_info);die;
            ?>
                    <tr id="<?php echo $inc->inc_ref_id; ?>">


                        <td><?php echo date('d-m-y', strtotime($inc->inc_datetime)); ?></td>
                        <td><?php echo date('d-m-y', strtotime($inc->date)); ?></td>
                        <td><a href="{base_url}calls/single_record_view" class="onpage_popup" data-qr="output_position=popup_div&inc_ref_id=<?php echo $inc->inc_ref_id; ?>" style="color:#000;"> <?php echo $inc->inc_ref_id; ?></a></td>


                        <td><?php echo $inc->hp_name; ?></td>

                        <td><?php echo  $inc->amb_rto_register_no; ?></td>
                        <td><?php echo $inc->dst_name; ?></td>
                        <td><?php echo $inc->amb_default_mobile; ?></td>
                        <td><?php echo $inc->amb_pilot_mobile; ?></td>
                        <?php
                        $epcr_cnt = epcr_count($inc->inc_ref_id);
                        $ptn_count = ptn_count($inc->inc_ref_id);
                        ?>
                        <td align="Center"><?php echo $ptn_count; ?> </td>
                        <?php
                            $oper = explode(',', $inc->epcr_operateby);
                            $operateby = array();
                            foreach ($oper as $op) {

                                $operateby[] = get_clg_name_by_ref_id($op);
                            }

                        ?>
                            <td align="Center"><?php echo $inc->pname; ?></td>
                            <td align="Center"><?php echo implode(',', $operateby); ?> </td>
                            <td align="Center"><?php echo $inc->remark; ?></td>

                            <?php
                            if ($inc->patient_ava_or_not != NULL) {
                                $epcr_call_type = $inc->patient_ava_or_not;
                            } else {
                                $epcr_call_type = $inc->epcr_call_type;
                            }
                            if ($epcr_call_type == 'no') {
                                $e_call_typ = "Patient Not Available";
                            } else if ($epcr_call_type == 'yes') {
                                $e_call_typ = "Patient Available";
                            } else if ($epcr_call_type == '3') {
                                $e_call_typ = "On Scene Care";
                            }

                            ?>
                            <td align="Center"><?php echo $e_call_typ; ?><div class="hide"><?php echo $epcr_call_type; ?></div>
                            </td>
                       
        

                        <td>
                        
                           
                            <div class="user_action_box ">
                                <div class="colleagues_profile_actions_div"></div>
                                <ul class="profile_actions_list">
                                    <?php if($inc->status == ''){?>
                                    <li><a class="click-xhttp-request action_button" data-href="{base_url}clinical/ptn_record_view" data-qr="output_position=content&amp;tlcode=MT-REC-VIEW&amp;output_position=content&filters=reset&amp;inc_ref_id=<?php echo $inc->inc_ref_id; ?>&amp;action_type=View" data-popupwidth="1000" data-popupheight="350">Add</a></li>
                                    <?php }?>
                                    <?php if($inc->status == '1'){?>
                                    <li><a class="click-xhttp-request action_button" data-href="{base_url}clinical/get_clinical" data-qr="output_position=content&amp;tlcode=MT-REC-VIEW&amp;output_position=content&filters=reset&amp;inc_ref_id=<?php echo $inc->inc_ref_id; ?>&amp;action_type=View" data-popupwidth="1000" data-popupheight="350">View</a></li>
                                    <?php }?>
                                </ul>
                            </div>
                            
                        </td>
                    </tr>
                <?php } ?>
            <?php } else { ?>

                <tr>
                    <td colspan="14" class="no_record_text">No Record Found</td>
                </tr>
            <?php } ?>


        </table>

        <div class="bottom_outer">

            <div class="pagination"><?php echo $pagination; ?></div>

            <input type="hidden" name="submit_data" value="<?php if (@$data) {
                                                                echo $data;
                                                            } ?>">


            <div class="width30 float_right">


                <div class="record_per_pg">

                    <div class="per_page_box_wrapper">

                        <span class="dropdown_pg_txt float_left"> Records per page : </span>

                        <select name="pg_rec" class="dropdown_per_page float_left change-xhttp-request width60" data-href="{base_url}job_closer" data-qr="output_position=content&amp;flt=true"><?php echo rec_perpg($pg_rec); ?>
                        </select>

                    </div>

                    <div class="float_right">
                        <span> Total records: <?php if (@$total_count) {
                                                    echo $total_count;
                                                } else {
                                                    echo "0";
                                                } ?></span>


                    </div>
                </div>

            </div>



        </div>


</form>

<style>
    .alert-danger{
        padding: 10px;
        background-color: #f8d7da;
    border-color: #f5c6cb;
    }
    .alert-success{
        padding: 10px;
        background-color: #d4edda;
    border-color: #c3e6cb;
    }
</style>
<script>
    $(function() {

    
    $(".hide-it").hide(15000);

});
</script>