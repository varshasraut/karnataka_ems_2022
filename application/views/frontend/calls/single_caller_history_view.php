
<div> Caller No:<?php echo $clr_mobile ?> </div>
<form method="post" name="inc_list_form" id="inc_list">  
    <div class="width100" id="ero_dash">


        <div id="list_table">

            <table class="table report_table">
                <tr>                                     
                    <th nowrap>Date & Time</th>
                    <th nowrap>Incident ID</th>
                    <th nowrap>Mobile No</th>
                    <th nowrap>Caller Name</th>
                    <th nowrap>Patient Name</th>
                    <th nowrap>Added By</th>
                    <th nowrap>Call Type</th>
                    <!--<th nowrap>Follow-up Status</th>-->
                    <th nowrap>Chief Complaint/MCI Nature</th>
                </tr>

                <?php
                if (count(@$inc_info) > 0) {
                    $total = 0;

                    foreach ($inc_info as $key => $inc) {
                        //var_dump($inc->inc_type);
                        $caller_name = $inc->clr_fname . "  " . $inc->clr_lname;
                        ?>

                        <tr>
                            <td><?php echo date("d-m-Y h:i:s", strtotime($inc->inc_datetime)); ?></td>
                            <td><a href="<?php echo base_url();?>/calls/single_record_view" class="click-xhttp-request" data-qr="output_position=cboxLoadedContent&inc_ref_id=<?php echo $inc->inc_ref_id; ?>" style="color:#000;"><?php echo $inc->inc_ref_id; ?></a></td>
                            <td><?php echo $inc->clr_mobile; ?></td>
                            <td><?php echo ucwords($caller_name); ?></td>
                            <td><?php echo $inc->ptn_fname; ?></td>
                            <td><?php echo $inc->clg_first_name.' '.$inc->clg_last_name; ?></td>
                            
                            <td nowrap><?php echo ucwords($inc->pname); ?></td>
                            <!--<td nowrap>
                                <?php
                               /* if($inc->inc_type == 'NON_MCI_WITHOUT_AMB'){
                               echo follow_up_status( $inc->inc_ref_id);
                                } */
                                ?>  
                            </td>-->
                            <td nowrap>
                                <?php 
                if($inc->inc_complaint != '' || $inc->inc_complaint != 0){
                    echo get_cheif_complaint( $inc->inc_complaint);
                }else if($inc->inc_mci_nature != '' || $inc->inc_mci_nature != 0){
                    echo get_mci_nature_service( $inc->inc_mci_nature);
                }else{
                    echo '-';
                }
                ?></td>
                        </tr>

                    <?php } ?>

                <?php } else { ?>
                    <tr><td colspan="11" class="no_record_text">No Record Found</td></tr>
                <?php } ?>   
            </table>



            <div class="bottom_outer">
                <div class="pagination"><?php echo $pagination; ?></div>
                <input type="hidden" name="submit_data" value="<?php
                if (@$data) {
                    echo $data;
                }
                ?>">

                <div class="width33 float_right">

                    <div class="record_per_pg">

                        <div class="per_page_box_wrapper">

                            <span class="dropdown_pg_txt float_left"> Records per page : </span>

                            <select name="pg_rec" class="dropdown_per_page float_left change-xhttp-request" data-href="{base_url}calls/single_caller_history" data-qr="output_position=content&amp;flt=true&amp;type=inc&amp;mobile_no=<?php echo $clr_mobile; ?>">

<?php echo rec_perpg($pg_rec); ?>

                            </select>

                        </div>

                        <div class="float_right">
                            <span> Total records: <?php
                                if (@$total_count) {
                                    echo $total_count;
                                } else {
                                    echo"0";
                                }
                                ?> </span>
                        </div>
                    </div>

                </div>

            </div>

        </div>
    </div>
</form>