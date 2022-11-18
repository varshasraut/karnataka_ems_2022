  
<form method="post" name="inc_list_form" id="inc_list">  
    <div class="width100" id="ero_dash">

        <div id="amb_filters">
            <div class="width2 float_left">                   

                <div class="search">

                    <div class="row">

                        <div class="width100 float_left">
                            <div class="width_16 float_left">
                                <h3 class="txt_clr2 ">Call Details</h3>
                            </div>

                            <div class="width4 float_left">
                                <input type="text"  class="controls amb_search" id="mob_no" name="call_search" value="<?php echo @$rg_no; ?>" placeholder="Search"/>
                            </div>

                            <div class="width_14 float_left">

                                <input type="button" class="search_button float_right form-xhttp-request" name="" value="Search" data-href="{base_url}calls/ero_dash" data-qr="output_position=content&amp;flt=true&amp;type=inc" />
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="list_table">

            <table class="table report_table">
                <tr>                                     

                    <th nowrap>Date & Time</th>
                    <th nowrap>Incident ID</th>
                    <th nowrap>Caller Name</th>
                    <th nowrap>District</th>
<!--                           <th nowrap>Patient Name</th>-->
<!--                          <th nowrap>108 Ref ID</th>-->
                    <th nowrap>Caller Mobile No</th>
<!--                           <th width="18%">Incident Address</th>-->
                    <th nowrap>Doctor NAME</th>
                    <th nowrap>Doctor Mobile</th>
                    <th nowrap>Pilot</th>
                    <th nowrap>Pilot Mobile</th>
                    <th nowrap>Ambulance</th>
                    <th nowrap>Call Time</th>
                    <th nowrap>Call Type</th>
                </tr>

                <?php
                if (count(@$inc_info) > 0) {
                    $total = 0;

                    foreach ($inc_info as $key => $inc) {


                        if (($inc->ptn_mname == '') && ($inc->ptn_fname == '')) {
                            $inc->ptn_mname = "-";
                            $inc->ptn_fname = "-";
                        }

//                           if($inc->ptn_fullname != ''){
//                               $patient_name = $inc->ptn_fullname;
//                           }else{
                        $patient_name = $inc->ptn_fname . " " . $inc->ptn_mname . " " . $inc->ptn_lname;
                        // }

//                        if ($inc->clr_fullname != '') {
//                            $caller_name = $inc->clr_fullname;
//                        } else {
                            $caller_name = $inc->clr_fname . "  " . $inc->clr_lname;
//                        }
                        ?>

                        <tr>




                            <td ><?php echo date("d-m-Y h:m:i", strtotime($inc->inc_datetime)); ?></td>

                            <td ><?php echo $inc->inc_ref_id; ?></td>

                            <td ><?php echo ucwords($caller_name); ?></td>

                            <td ><?php echo $inc->dst_name; ?></td>
        <!--                           <td ><?php echo ucwords($patient_name); ?></td>-->
        <!--                           <td  style="background: #FFD4A2;;"><?php echo $inc->inc_bvg_ref_number; ?></td>-->
                            <td ><?php echo $inc->clr_mobile; ?></td>

        <!--                           <td ><?php echo $inc->inc_address; ?></td>-->


                            <td ><?php echo $inc->amb_emt_id; ?><?php //echo ucwords($inc->emt_first_name." ".$inc->emt_last_name); ?></td>
                            <td  nowrap><?php echo $inc->amb_default_mobile; ?></td>
                            <td ><?php echo $inc->amb_pilot_id; ?><?php //echo ucwords($inc->clg_first_name." ".$inc->clg_last_name); ?></td>
                            <td ><?php echo $inc->amb_pilot_mobile; ?><?php //echo ucwords($inc->clg_first_name." ".$inc->clg_last_name); ?></td>

                            <td  nowrap><?php echo $inc->amb_rto_register_no; ?></td>


                            <td ><?php echo ($inc->inc_dispatch_time); ?></td>
     <td nowrap><?php echo ucwords($inc->pname); ?></td>





                        </tr>

                    <?php } ?>

                <?php } else { ?>



                    <tr><td colspan="11" class="no_record_text">No Record Found</td></tr>



                <?php } ?>   





            </table>



            <div class="bottom_outer">

                <div class="pagination"><?php echo $pagination; ?></div>

                <input type="hidden" name="submit_data" value="<?php if (@$data) {
                    echo $data;
                } ?>">

                <div class="width33 float_right">

                    <div class="record_per_pg">

                        <div class="per_page_box_wrapper">

                            <span class="dropdown_pg_txt float_left"> Records per page : </span>

                            <select name="pg_rec" class="dropdown_per_page float_left change-xhttp-request" data-href="{base_url}calls/ero_dash" data-qr="output_position=content&amp;flt=true&amp;type=inc">

<?php echo rec_perpg($pg_rec); ?>

                            </select>

                        </div>

                        <div class="float_right">
                            <span> Total records: <?php if (@$inc_total_count) {
    echo $inc_total_count;
} else {
    echo"0";
} ?> </span>
                        </div>
                    </div>

                </div>

            </div>

        </div>
    </div>
</form>