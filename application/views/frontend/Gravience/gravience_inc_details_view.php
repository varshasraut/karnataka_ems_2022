
<div class="call_purpose_form_outer ercp_table" id="call_purpose_form_outer" >
    <div class="head_outer"><h4 class="txt_clr2 width1 txt_pro">Grievance Form</h4></div>


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
                                <td><?php echo $re_name; ?></td>

                            </tr>
                            <tr>
                                <td>ERO  Summary</td>
                                <td><?php echo ($cl_dtl[0]->inc_ero_summary) ? $cl_dtl[0]->inc_ero_summary : "-"; ?></td>
                                <td>Added By</td>
                                <td class="width_25"><?php echo $cl_dtl[0]->clg_first_name.' '.$cl_dtl[0]->clg_last_name; ?></td>
                               

                            </tr>
                            <tr>
                            <td>Added Date</td>
                            <td class="width_25"><?php echo $cl_dtl[0]->inc_datetime; ?></td>
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

  
    <div>
        <h3 class="txt_clr2 width1 txt_pro">Current call details</h3>
    </div>
    

    <form method="post" name="police_call_form" id="police_call_form">

        <input type="hidden" name="inc_ref_id" value="<?php echo $cl_dtl[0]->inc_ref_id ?>">


            <div class="field_row width100">


                <div class="width33 float_left">    
                    <div class="field_lable float_left width33"><label for="police_station">Complaint Type <span class="md_field">*</span></label></div>   <div class="filed_input float_left width50">
                        <select name="gri[gc_complaint_type]" tabindex="8"  class="filter_required" id="grivence_complaint"  data-errors="{filter_required:'Complaint type should not be blank!'}"  <?php echo $update; ?> > 
                            <option value="" <?php echo $disabled; ?>>Select Complaint</option>
                            <option value="external">External</option>
                            <option value="internal" >Internal</option>
                            <option value="e-complaint">E-Complaint</option>
                            <option value="negative_news">Negative News</option>
                        </select>

                    </div>
                </div>
            </div>
         <div id="grivance_inc_action">
            
        </div>
        
        <div id="grivance_inc_filter">
            
        </div>
            
        <div id="inc_details">


        </div>
        
         <div id="grivience_info">


        </div>




    </form>

</div>



