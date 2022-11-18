<script type="text/javascript">
    setInterval("my_function();", 12000);

    function my_function() {
        window.location = location.href;
    }
</script>

<form method="post" name="inc_list_form" id="inc_list">  
    <div class="width100" id="ero_dash">
        <div id="amb_filters">
            <div class="width100 float_left">                   

                <div class="search">

                        <div class="width100 float_left">
                            <div class="width_15 float_left">
                                <h4 class="txt_clr2 ">Manual Call</h4>
                            </div>
                            <div class="width4 float_left">
                                <input type="text"  class="controls amb_search mt-0" id="mob_no" name="call_search" value="<?php echo @$rg_no; ?>" placeholder="Search"/>
                            </div>

                            <div class="width_40 float_left">

                                <input type="button" class="search_button form-xhttp-request" name="" value="Search" data-href="{base_url}supervisor/fire_manual_calls" data-qr="output_position=content&amp;flt=true&amp;type=inc" />
                                <input name="" value="Reset Filters" data-href="{base_url}supervisor/fire_manual_calls" data-qr="output_position=content&amp;filters=reset" type="button" tabindex="3" autocomplete="off" class="search_button click-xhttp-request">
                            </div>               
                    </div>
                </div>

            </div>
        </div>

        <div id="list_table">

            <table class="table report_table table-bordered">
                <tr>                                     
                    <th nowrap>Date / Time</th>
                    <th nowrap> Caller Number </th>
                    <th nowrap>Caller Name</th>
                    <th nowrap>Fire Incident ID</th>

                    <th nowrap>District Name</th>
                    <th nowrap>Fire Station Name</th>
                    <th nowrap>FDA Name</th>

                </tr>
                <?php
                if (count(@$inc_info) > 0) {



                    $total = 0;

                    foreach ($inc_info as $key => $inc) {



                        if (($inc->ptn_mname == '') && ($inc->ptn_fname == '')) {
                            $inc->ptn_mname = "-";
                            $inc->ptn_fname = "-";
                        }

                        if ($inc->ptn_fullname != '') {
                            $patient_name = $inc->ptn_fullname;
                        } else {
                            $patient_name = $inc->ptn_fname . " " . $inc->ptn_mname . " " . $inc->ptn_lname;
                        }

                        if ($inc->clr_fullname != '') {
                            $caller_name = $inc->clr_fullname;
                        } else {
                            $caller_name = $inc->clr_fname . " " . $inc->clr_mname . " " . $inc->clr_lname;
                        }
                        ?>

                        <tr>

                            <td ><?php echo date("d-m-Y h:i:s", strtotime($inc->fc_added_date)); ?></td>
                            <td ><?php echo $inc->clr_mobile; ?></td>
                            <td ><?php echo ucwords($caller_name); ?></td>
                            <td ><?php echo $inc->fc_inc_ref_id; ?></td>

                            <td ><?php echo $inc->dst_name; ?></td>
                            <td ><?php echo $inc->fire_station_name; ?></td>
                            <td nowrap><?php echo ($inc->fc_added_by); ?></td>

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

                            <select name="pg_rec" class="dropdown_per_page float_left change-xhttp-request" data-href="{base_url}supervisor/fire_dispatch" data-qr="output_position=content&amp;flt=true&amp;type=inc">

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
<script>
    jQuery('#supervisor_container .sub_header_top_link #sub_incedence_steps li').on("click", function () {
        jQuery('#supervisor_container .sub_header_top_link #sub_incedence_steps li').removeClass("active_sub_supervisor_nav");
        jQuery(this).addClass("active_sub_supervisor_nav");
    });

</script>