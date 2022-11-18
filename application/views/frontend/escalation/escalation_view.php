<div class="call_purpose_form_outer ercp_table" id="call_purpose_form_outer" >
    <div class="head_outer"><h3 class="txt_clr2 width1">Call Form</h3></div>


    <div class="pan_box bottom_border float_left width100">


        <div class=" float_left width100">
  

            <?php
            if (!empty($cl_dtl[0])) {
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
                                <td><?php echo $re_name; ?></td>

                            </tr>
                            <tr>
                                <td>ERO  Summary</td>
                                <td><?php echo ($cl_dtl[0]->inc_ero_summary) ? $cl_dtl[0]->inc_ero_summary : "-"; ?></td>

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
                                <td><?php echo ($cl_dtl[0]->clr_fname) ? $cl_dtl[0]->clr_fname . " " . $cl_dtl[0]->clr_lname : "-"; ?></td>
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
</div>