<?php $CI = EMS_Controller::get_instance(); ?>

<!--<h3 class="txt_clr5 width2 float_left">ERO Dashboard</h3><br>-->

<div id="calls_inc_list">

    <form method="post" name="inc_list_form" id="inc_list">  
        <div class="width100" id="ero_dash">
            <div id="amb_filters">
                <div class="width100 float_left">                   

                    <div class="search">

                        <div class="row">

                            <div class="width100 float_left">
                                <div class="width_20 float_left">
                                    <h3 class="txt_clr2 ">Other Calls</h3>
                                </div>
                                <div class="width25 float_left">
                                    <input type="text"  class="controls amb_search" id="mob_no" name="call_search" value="<?php echo @$rg_no; ?>" placeholder="Search"/>
                                </div>

                                <div class="width_40 float_left">

                                    <input type="button" class="search_button form-xhttp-request" name="" value="Search" data-href="{base_url}supervisor/other_calls" data-qr="output_position=content&amp;flt=true&amp;type=inc" />
                                    <input name="" value="Reset Filters" data-href="{base_url}supervisor/other_calls" data-qr="output_position=content&amp;filters=reset" type="button" tabindex="3" autocomplete="off" class="search_button click-xhttp-request">
                                </div>

                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <div id="list_table">

                <table class="table report_table">
                    <tr>       
                        <th nowrap>Date / Time</th>
                        <th nowrap>Incident ID</th>
                        <th nowrap> Call Type </th>
                        <th nowrap>Caller Number</th>
                        <th nowrap>Caller Name</th>
                        <th nowrap>Call Duration</th>
                        <th nowrap>ERO Name</th>

                        <th nowrap>Action</th>


                    </tr>
                    <?php
                    if (count(@$inc_info) > 0) {



                        $total = 0;

                        foreach ($inc_info as $key => $inc) {



//                            if ($inc->clr_fullname != '') {
//                                $caller_name = $inc->clr_fullname;
//                            } else {
                            $caller_name = $inc->clr_fname . " " . $inc->clr_mname . " " . $inc->clr_lname;
//                            }
                            ?>

                            <tr>
                                <td nowrap><?php echo date("d-m-Y H:i:s", strtotime($inc->inc_datetime)); ?></td>
                                <td ><a href="{base_url}calls/single_record_view" class="onpage_popup" data-qr="output_position=popup_div&inc_ref_id=<?php echo $inc->inc_ref_id; ?>" style="color:#000;"><?php echo $inc->inc_ref_id; ?></a></td>
                                <td><?php echo ucwords($inc->pname); 
                                
                                 if ($inc->cl_name != '') {
                                ?> &nbsp; [ <?php echo ucwords($inc->cl_name); ?> ] <?php } ?> 
                               </td>


                                <td ><?php echo $inc->clr_mobile; ?></td>
                                <td ><?php echo ucwords($caller_name); ?></td>
                                <td nowrap><?php echo ($inc->inc_dispatch_time); ?></td>
                                <td nowrap><?php echo ucwords($inc->inc_added_by); ?></td>


                                <td> <a class="onpage_popup btn" data-href="{base_url}supervisor/other_call_action?inc_ref_id=<?php echo $inc->inc_ref_id; ?>" data-qr="output_position=popup_div" data-popupwidth="300" data-popupheight="300">Action</a></td>


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

                                <select name="pg_rec" class="dropdown_per_page float_left change-xhttp-request" data-href="{base_url}supervisor/other_calls" data-qr="output_position=content&amp;flt=true&amp;type=inc">

                                    <?php echo rec_perpg($pg_rec); ?>

                                </select>

                            </div>

                            <div class="float_right">
                                <span> Total records: <?php
                                    if (@$inc_total_count) {
                                        echo $inc_total_count;
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
</div>
