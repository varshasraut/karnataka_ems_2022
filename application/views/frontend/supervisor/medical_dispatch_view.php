<script type="text/javascript">
    //setInterval("my_function();", 12000);

    function my_function() {
        window.location = location.href;
    }
</script>
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
                                    <h3 class="txt_clr2 ">Medical Dispatch Queue</h3>
                                </div>
                                <div class="width25 float_left">
                                    <input type="text"  class="controls amb_search" id="mob_no1" name="call_search" value="<?php echo @$rg_no; ?>" placeholder="Search"/>
                                </div>

                                <div class="width40 float_left">

                                    <input type="button" class="search_button form-xhttp-request" name="" value="Search" data-href="{base_url}supervisor/ero_dash" data-qr="output_position=content&amp;flt=true&amp;type=inc" />
                                    <input name="" value="Reset Filters" data-href="{base_url}supervisor/medical_dispatch" data-qr="output_position=content&amp;filters=reset" type="button" tabindex="3" autocomplete="off" class="search_button click-xhttp-request">
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
                        <th style="width:30%">Call Type</th>
                        <th nowrap> Caller Number </th>
                        <th nowrap>Caller Name</th>
                        <th nowrap>Incident ID</th>
                        <!--<th nowrap>Incident Address</th>-->
                        <th nowrap>District Name</th>
                        <th nowrap>Ambulance No</th>
                        <th nowrap>Base Location</th>
                        <th nowrap>Call Duration</th>
                        <th nowrap>Ameyo ID</th>
                        <th nowrap>ERO Name</th>

                    </tr>
                    <?php
                    if (count(@$inc_info) > 0) {



                        $total = 0;

                        foreach ($inc_info as $key => $inc) {

//var_dump($inc);

                            if (($inc->ptn_mname == '') && ($inc->ptn_fname == '')) {
                                $inc->ptn_mname = "-";
                                $inc->ptn_fname = "-";
                            }

                            if ($inc->ptn_fullname != '') {
                                $patient_name = $inc->ptn_fullname;
                            } else {
                                $patient_name = $inc->ptn_fname . " " . $inc->ptn_mname . " " . $inc->ptn_lname;
                            }

//                            if ($inc->clr_fullname != '') {
//                                $caller_name = $inc->clr_fullname;
//                            } else {
                            $caller_name = $inc->clr_fname . " " . $inc->clr_mname . " " . $inc->clr_lname;
//                            }
                            ?>

                            <tr>




                                <td nowrap><?php echo date("d-m-Y H:i:s", strtotime($inc->inc_datetime)); ?></td>
                                <td ><?php echo ucwords($inc->pname); ?></td>
                                <td nowrap><?php echo $inc->clr_mobile; ?></td>
                                <td nowrap><?php echo ucwords($caller_name); ?></td>
                                <td nowrap><a href="{base_url}calls/single_record_view" class="onpage_popup" data-qr="output_position=popup_div&inc_ref_id=<?php echo $inc->inc_ref_id; ?>" style="color:#000;"><?php echo $inc->inc_ref_id; ?></a></td>

                                <!--<td style='width:50% !important;'><?php // echo $inc->inc_address;    ?></td>-->
                                <td nowrap><?php echo $inc->dst_name; ?></td>
                                <td  nowrap><?php echo $inc->amb_rto_register_no; ?></td>
                                <td  style='width:50% !important;'><?php echo $inc->hp_name; ?></td>

                                <td nowrap><?php echo ($inc->inc_dispatch_time); ?></td>
                                <td nowrap><?php echo $inc->clg_avaya_id; ?></td>
                                <td nowrap><?php echo ucwords(strtolower($inc->clg_first_name." ".$inc->clg_last_name)); ?></td>

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

                                <select name="pg_rec" class="dropdown_per_page float_left change-xhttp-request" data-href="{base_url}supervisor/ero_dash" data-qr="output_position=content&amp;flt=true&amp;type=inc">

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
<script type="text/javascript">
    setInterval("my_function();", 120000);

    function my_function() {
        window.location = location.href;
    }
</script>