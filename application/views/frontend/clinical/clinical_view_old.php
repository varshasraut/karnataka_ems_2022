<div class="container">

    <div class="row">

        <div class="width10 float_left">
            <h3 class="txt_clr5 width2 float_left" style="font-size:20px;">Search</h3>
        </div>

        <div class="width25 float_left">

            <select name="filter" class="dropdown_per_page width90" data-base="search" id="epcr_filter_list">
                <option value="">Select</option>
                <option value="inc_datetime" <?php if ($filter == 'inc_datetime') {
                                                    echo "selected";
                                                } ?>>Date Of Incident</option>
                <option value="hp_name" <?php if ($filter == 'hp_name') {
                                            echo "selected";
                                        } ?>>Base Location</option>
                <option value="amb_reg_no" <?php if ($filter == 'amb_reg_no') {
                                                echo "selected";
                                            } ?>>Ambulance No</option>
                <option value="inc_ref_id" <?php if ($filter == 'inc.inc_ref_id') {
                                                echo "selected";
                                            } ?>>Incident ID</option>


            </select>
        </div>


        <div id="date_box" class="width_25 float_left " style="<?php if ($inc_date != '') {
                                                                    echo 'display:block;';
                                                                } else {
                                                                    echo 'display:none;';
                                                                } ?>">
            <input name="inc_date" tabindex="7.2" class="mi_calender form_input" placeholder="Date" type="text" data-errors="{filter_required:'Please select hospital from dropdown list'}">
        </div>

        <div id="baselocation_list" class="width_25 float_left " style="<?php if ($hp_id != '') {
                                                                            echo 'display:block;';
                                                                        } else {
                                                                            echo 'display:none;';
                                                                        } ?>">
            <input name="hp_id" tabindex="7.2" class="mi_autocomplete form_input " placeholder="Base Location" type="text" data-errors="{filter_required:'Please select hospital from dropdown list'}" data-href="{base_url}auto/get_hospital_with_ambu" data-value="<?php echo $hp_name; ?>" value="<?php echo $hp_id; ?>">
        </div>
        <div id="inc_id_box" class="width_25 float_left " style="<?php if ($inc_ref_id != '') {
                                                                        echo 'display:block;';
                                                                    } else {
                                                                        echo 'display:none;';
                                                                    } ?>">
            <input name="inc_id" tabindex="7.2" class=" form_input" placeholder="Incident ID" type="text" data-errors="{filter_required:'Please select hospital from dropdown list'}">
        </div>
        <div id="amb_list" class="width_25 float_left" style="<?php if ($amb_reg_id != '') {
                                                                    echo 'display:block;';
                                                                } else {
                                                                    echo 'display:none;';
                                                                } ?>">
            <input name="amb_reg_id" class="mi_autocomplete dropdown_per_page width97" data-href="{base_url}auto/get_ambulance" placeholder="Select Ambulance" data-errors="{filter_required:'Please select state from dropdown list'}" tabindex="15" autocomplete="off" value="<?php echo $amb_reg_id; ?>" data-value="<?php echo $amb_reg_id; ?>" </div>


        </div>

        <div class="width25 float_left">
            <input type="button" class="search_button float_left form-xhttp-request" name="" value="Search" data-href="{base_url}clinical/clinical_list" data-qr="output_position=content&amp;flt=true" />
            <!-- <input class="search_button click-xhttp-request float_right" name="" value="Reset Filters" data-href="{base_url}clinical/clinical_list" data-qr="output_position=content&amp;filters=reset" type="button"> -->
        </div>
        <div class="row">
            <div class="col-md-12">
                <table class="table table-bordered table-responsive">
                    <thead>
                        <tr>
                            <th scope="col">Sr.No</th>
                            <th scope="col">Date Of Incident</th>
                            <th scope="col">Date Of Closure</th>
                            <th scope="col">Incident ID</th>
                            <th scope="col">Base Location</th>
                            <th scope="col">Ambulance No</th>
                            <th scope="col">District Name</th>

                            <?php if (!isset($close_by_emt)) { ?>
                                <th nowrap>EMT Name</th>
                            <?php } ?>
                            <th nowrap> Mobile No 1</th>
                            <th nowrap> Mobile No 2</th>

                            <?php
                            if ($close_by_emt == '1') {
                            ?>
                                <th nowrap>Call Type</th>
                                <th nowrap>Closed By</th>
                                <th nowrap>Remark</th>
                                <th nowrap>Patient Availability</th>
                            <?php
                            } ?>

                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        //   var_dump($inc_list);die;
                        if (is_countable($inc_list)) {
                            $count = 1;
                            foreach ($inc_list as $key => $inc) { ?>
                                <tr>
                                    <td><?php echo $count++; ?></td>
                                    <td><?php echo date('d-m-y', strtotime($inc->inc_datetime)); ?></td>
                                    <td><?php echo date('d-m-y', strtotime($inc->date)); ?></td>
                                    <td><a href="{base_url}calls/single_record_view" class="onpage_popup" data-qr="output_position=popup_div&inc_ref_id=<?php echo $inc->inc_ref_id; ?>" style="color:#000;"> <?php echo $inc->inc_ref_id; ?></a></td>
                                    <td><?php echo  $inc->hp_name; ?></td>
                                    <td><?php echo  $inc->amb_rto_register_no; ?></td>
                                    <td><?php echo $inc->dst_name; ?></td>

                                    <?php
                                    if (!isset($close_by_emt)) { ?>
                                        <td><?php echo $inc->clg_first_name; ?> <?php echo $inc->clg_last_name; ?></td>
                                    <?php } ?>
                                    <td><?php echo $inc->amb_default_mobile; ?></td>
                                    <td><?php echo $inc->amb_pilot_mobile; ?></td>

                                    <?php
                                    if ($close_by_emt == '1') {
                                        $oper = explode(',', $inc->epcr_operateby);
                                        $operateby = array();
                                        foreach ($oper as $op) {

                                            $operateby[] = get_clg_name_by_ref_id($op);
                                        }

                                    ?>

                                        <td align="Center"><?php echo $inc->inc_type; ?></td>
                                        <td align="Center"><?php echo implode(',', $operateby); ?> </td>
                                        <td align="Center"><?php echo $inc->remark; ?></td>

                                        <?php
                                        if ($inc->patient_ava_or_not != '') {
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
                                    <?php
                                    } ?>

                                    <td>
                                        <div class="user_action_box">
                                            <div class="colleagues_profile_actions_div"></div>
                                            <ul class="profile_actions_list">
                                                <li><a class="click-xhttp-request action_button" data-href="{base_url}clinical/ptn_record_view" data-qr="output_position=content&amp;tlcode=MT-REC-VIEW&amp;output_position=content&filters=reset&amp;inc_ref_id=<?php echo $inc->inc_ref_id; ?>&amp;action_type=View" data-popupwidth="1000" data-popupheight="350">View</a></li>
                                            </ul>
                                        </div>
                                    </td>

                                </tr>
                            <?php } ?>

                        <?php } else { ?>
                            <tr>
                                <td colspan="7" class="no_record_text">No History Found</td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>

            </div>
        </div>

    </div>
    <style>
        table th {
            border: 2px solid whitesmoke !important;
        }

        table td {
            border: 2px solid grey !important;

        }

        #colorbox {
            /* left: 22px !important;
            width: 1289px !important;
            height: 713px !important;
            top: 80px !important; */
        }

        .linkbtn {
            color: #000;
            background: lightgrey;
            padding: 2px 15px 2px 15px;
        }

        .linkbtn2 {
            color: #000;
            background: lightgrey;
            padding: 2px 15px 2px 15px;
            margin-left: 20px;
        }
    </style>