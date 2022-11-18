<script>cur_pcr_step(3);</script>



<div class="call_purpose_form_outer">

    <div class="head_outer"><h3 class="txt_clr2 width1">PATIENT HISTORY</h3> </div>


    <form method="post" name="patient_form" id="patient_form">



        <input type="hidden" name="ptn_id" value="<?php echo $ptn[0]->ptn_id; ?>">

        <input type="hidden" name="inc_id" value="<?php echo $inc_id; ?>">

        <input type="hidden" name="pcr_id" value="<?php echo $pcr_id; ?>">




        <div class="width100">

            <div class="cases">

                <div class="style6">Type of Case<span class="md_field">*</span></div>

                <div class="type_case">


                    <?php
                    $checked = array();

                    $cnt = 1;

                    if (!empty($case_type)) {

                        $ocs_opt = array('Other' => 'ptn_other_cs');

                        foreach ($case_type as $case) {

                            
                            if (($ptn[0]->ptn_gender == 'M' && strpos($case->case_type, 'Pregnancy') === false) || $ptn[0]->ptn_gender == 'F') {

                                $add_class = ($cnt <= 2) ? "bottom" : '';

                                if (!empty($cs_id)) {

                                    if (in_array($case->case_id, $cs_id)) {

                                        $checked[$case->case_id] = "checked";

                                        $oth_cs = ($case->case_type == 'Other') ? 'yes' : '';
                                    }
                                }


                                $cs_ids[] = "cs_" . $case->case_id;

                                ob_start();
                                ?>

                                <div class="display-inline-block res_ch">

                                    <label for="cs_<?php echo $case->case_id; ?>" class="chkbox_check <?php echo $add_class; ?>">

                                        <input name="his_cs[<?php echo $case->case_id; ?>]" class="check_input filter_either_or[(*:ids:*)] <?php echo $ocs_opt[$case->case_type]; ?>" value="<?php echo $case->case_id; ?>" data-errors="{filter_either_or:'should not be blank!'}" id="cs_<?php echo $case->case_id; ?>" type="checkbox" <?php echo $checked[$case->case_id]; ?> tabindex="<?php echo $tab++; ?>"><span class="chkbox_check_holder"></span><?php echo $case->case_type; ?>

                                    </label>


                                </div>

                                <?php
                                $cs_opt[] = ob_get_contents();

                                ob_get_clean();

                                $cnt++;
                            }
                        }


                        $html = join("", $cs_opt);

                        echo $html = str_replace("(*:ids:*)", join(",", $cs_ids), $html);
                    }
                    ?>

                    <?php if ($oth_cs == 'yes') { ?>


                        <div class="field_input">

                            <div class="input">

                                <input name="case_other" value="<?php echo $case_other; ?>" type="text" placeholder="Other Specify">

                            </div>

                        </div>


<?php } ?>



                </div>



                <div class="style6">Past Medical History<span class="md_field">*</span></div>

                <div class="check_outer past_med_his"> 


<?php
$checked = array();

if (!empty($med_his)) {

    foreach ($med_his as $his) {

        if ($his->dis_type == 'p') {

            $odis_opt = array('Other' => 'ptn_other_dis');

            if (!empty($mh_id)) {

                if (in_array($his->dis_id, $mh_id)) {

                    $checked[$his->dis_id] = "checked";

                    $oth_dis = ($his->dis_title == 'Other') ? 'yes' : '';
                }
            }


            $his_ids[] = "his_" . $his->dis_id;
            ob_start();
            ?>

                                <div class="display-inline-block res_ch">

                                    <label for="his_<?php echo $his->dis_id; ?>" class="chkbox_check">

                                        <input name="his_dis[<?php echo $his->dis_id; ?>]" class="check_input filter_either_or[(*:ids:*)]  <?php echo $odis_opt[$his->dis_title]; ?>" value="<?php echo $his->dis_id; ?>" data-errors="{filter_either_or:'should not be blank'}" id="his_<?php echo $his->dis_id; ?>" type="checkbox" <?php echo $checked[$his->dis_id]; ?> tabindex="<?php echo $tab++; ?>"><span class="chkbox_check_holder"></span><?php echo $his->dis_title; ?>


                                    </label>

                                </div>

            <?php
            $his_opt[] = ob_get_contents();

            ob_get_clean();
        }
    }
}


$html = join("", $his_opt);

echo $html = str_replace("(*:ids:*)", join(",", $his_ids), $html);
?>


                    <?php if ($oth_dis == 'yes') { ?>


                        <div class="field_input">

                            <div class="input">

                                <input name="his_odis" class=""  data-base="" value="<?php echo $his_past_odis; ?>" type="text" placeholder="Other Specify" tabindex="<?php $tab++; ?>">

                            </div>

                        </div>


<?php } else { ?>

                        <div class="form_field ex_label"><div class="label">&nbsp;</div></div>

                    <?php } ?>



                </div>

                <div class="style6">Current Medication<span class="md_field">*</span></div>
                <div class="input">

                    <textarea class="text_area width100 filter_required" name="his_cur_med" rows="4" cols="30" data-errors="{filter_required:'Medication should not be blank!'}" tabindex="<?php echo $tab++; ?>"><?php echo $cur_med[0]->med_title; ?></textarea>

                </div>
            </div>


            <div class="cf_comp">
                <div class="style6">Chief Complaint<span class="md_field">*</span></div>


                <div id="get_answer">      




<?php
$checked = array();

$cnt = 1;

if (!empty($chief_comp)) {

    foreach ($chief_comp as $com) {

        if (($ptn[0]->ptn_gender == 'M' && strpos($com->ct_type, 'Pregnancy') === false) || $ptn[0]->ptn_gender == 'F') {


            $add_class = '';

            if ($cnt % 2 != 0) {

                $add_class = "left";
            }

            $cco_opt = array('Other' => 'ptn_other_cc');

            if (!empty($cc_id)) {

                if (in_array($com->ct_id, $cc_id)) {

                    $checked[$com->ct_id] = "checked";

                    $oth_cc = ($com->ct_type == 'Other') ? 'yes' : '';
                }
            }


            $cc_ids[] = "cc_" . $com->ct_id;

            ob_start();
            ?>

                                <table class="style6">

                                    <tr class="check_table_input">
                                        <td>
                                            <div class="filed_input <?php echo $add_class; ?>">
                                                <input name="his_cc[<?php echo $com->ct_id; ?>]" class="check_input filter_either_or[(*:ids:*)]  <?php echo $cco_opt[$com->ct_type]; ?>" value="<?php echo $com->ct_id; ?>"  id="cc_<?php echo $com->ct_id; ?>" type="checkbox" data-errors="{filter_either_or:'should not be blank'}" <?php echo $checked[$com->ct_id]; ?> tabindex="<?php echo $tab++; ?>"><span class="chkbox_check_holder"></span>       
                                            </div>
                                        </td>     

                                        <td>
                                            <label for="cc_<?php echo $com->ct_id; ?>" class="chkbox_check"><?php echo $com->ct_type; ?></label>
                                        </td>
                                    </tr>

                                </table>

            <?php
            $cc_opt[] = ob_get_contents();

            ob_get_clean();
        }
    }
}
$html = join("", $cc_opt);

echo $html = str_replace("(*:ids:*)", join(",", $cc_ids), $html);
?>



                    <?php if ($oth_cc == 'yes') { ?>

                        <div class="form_field width50 float_left">
                            <br>
                            <div class="input">
                                <input name="his_occ" class="form_input filter_required" value="<?php echo $cc_other; ?>" data-errors="{filter_required:'Chief complaint should not be blank!'}" placeholder="Other chief complaint"  type="text" tabindex="<?php echo $tab++; ?>">
                            </div>
                        </div>

<?php } ?>




                </div>
            </div>


        </div>

        <div class="save_btn_wrapper float_left">


            <input type="button" name="accept" value="Accept" class="accept_btn form-xhttp-request" data-href='{base_url}/pcr/save_patient_history' data-qr='' tabindex="<?php echo $tab++; ?>">


        </div>




    </form>


</div>


<div class="next_pre_outer">
<?php
$step = $this->session->userdata('pcr_details');
if (!empty($step)) {
    ?>
        <a href="#" class="prev_btn btn float_left" onclick="load_next_prev_step(2)" tabindex="<?php echo $tab++; ?>"> < Prev </a>
        <a href="#" class="next_btn btn float_right" onclick="load_next_prev_step(4)" tabindex="<?php echo $tab++; ?>"> Next > </a>
    <?php } ?>
</div>