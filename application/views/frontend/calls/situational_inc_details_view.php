
<div class="call_purpose_form_outer ercp_table" id="call_purpose_form_outer" >
    <div class="head_outer"><h3 class="txt_clr2 width1">Situational Desk Form</h3></div>


    <div class="pan_box bottom_border float_left width100">


        <div class=" float_left width100">


            <?php
            if (!empty($cl_dtl[0])) {
//     var_dump($cl_dtl); 
                ?>

                <div class="width100">
                    <div class="width50 float_left ercp">

                        <table>
                            <tr class="single_record_back">
                                <td colspan="4">Incident Information</td>
                            </tr>
                            <tr>
                                <td class="width">Call Type</td>
                                <td class="width_25"><?php echo ucwords(get_purpose_of_call($cl_dtl[0]->inc_type)); ?></td>
                                <td class="width_25">Dispatch Date /Time</td>
                                <td class="width_25"><?php echo $cl_dtl[0]->inc_datetime; ?></td>
                            </tr>

                            <tr>                                  
                                <td class="width">Incident Id</td>
                                <td class="width_25"><?php echo ($cl_dtl[0]->inc_ref_id); ?></td>
                                <td>ERO Standard Summary</td>
                                <td><?php echo $cl_dtl[0]->fda_std_summary; ?></td>

                            </tr>
                            <tr>
                                <td>ERO  Summary</td>
                                <td><?php echo ($cl_dtl[0]->inc_ero_summary) ? $cl_dtl[0]->inc_ero_summary : "-"; ?></td>
                                <td>Forword By</td>
                                <td><?php echo ($cl_dtl[0]->inc_added_by) ? $cl_dtl[0]->inc_added_by : "-"; ?></td>
                                
                            </tr>


                        </table>
                    </div>
                    <div class="width50 float_right ercp">

                        <table>

                            <tr class="single_record_back">
                                <td colspan="4">Caller Information</td>
                            </tr>

                            <tr>
                                <td class="width_25">Caller Name</td>
                                <td><?php echo ucwords(($cl_dtl[0]->clr_fname) ? $cl_dtl[0]->clr_fname . " " . $cl_dtl[0]->clr_lname : "-"); ?></td>
                                <td>Caller Mobile</td>
                                <td><?php echo ($cl_dtl[0]->clr_mobile) ?></td>
                            </tr>
                            <tr>
                                <td>Caller Relation</td>
                                <td><?php echo get_relation_by_id($cl_dtl[0]->clr_ralation); ?></td>
                                <td></td>
                                <td></td>
                            </tr>

                        </table>

                    </div>
                </div>


            <?php } else { ?>

                <div class="width100 text_align_center"><span> No records found. </span></div>


            <?php } ?>

        </div>

    </div>

  
    <div>
        <h3 class="txt_clr2 width1 txt_pro">Detail Summery</h3>
    </div>
    

    <form method="post" name="police_call_form" id="supervisor_call_form">

        <input type="hidden" name="inc_ref_id" value="<?php echo $cl_dtl[0]->inc_ref_id ?>">
        <input name="es[pre_inc_ref_id]"  type="hidden"  value="<?= @$grievance_data[0]->es_inc_ref_id; ?>" >
        
        <div class="field_row width100">


            <div class="width2 form_field outer_smry">
                    <div class="label blue float_left">Note</div>

                     <div class="width100" id="ero_summary_other">
                         <textarea style="height:60px;" name="es[summary]" class="width_100 filter_required" TABINDEX="16" data-maxlen="1600"  data-errors="{filter_required:'ERO Supervisor Summary should not be blank'}"><?=@$inc_details['es_summary'];?></textarea>
                    </div>
            </div>
            <div class="width2 form_field float_left outer_btn">
                <div id="fwdcmp_btn">
                    <input type="button" name="submit" value="Save" class="btn submit_btnt form-xhttp-request" data-href='{base_url}calls/save_situational_call' data-qr='output_position=content'  TABINDEX="27">
                </div>
            </div>
        </div>


    </form>

</div>



