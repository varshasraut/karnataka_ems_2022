<script type="text/javascript">
   // setInterval("my_function();", 12000);

    function my_function() {
        window.location = location.href;
    }
</script>
<?php $CI = EMS_Controller::get_instance(); ?>

<!--<h3 class="txt_clr5 width2 float_left">ERO Dashboard</h3><br>-->



<form method="post" name="inc_list_form" id="inc_list">  
    <div class="width100" id="ero_dash">
        <div id="amb_filters">
            <div class="width2 float_left">                   

                <div class="search">

                    <div class="row">

                        <div class="sub_header_top_link">

                            <ul id="sub_incedence_steps">
                                <li class='active_sub_supervisor_nav'><a class="click-xhttp-request "  href="{base_url}supervisor/fire_incident_calls" data-qr="output_position=content">Incident Call</a></li>
                                <li><a class="click-xhttp-request"  href="{base_url}supervisor/fire_manual_calls" data-qr="output_position=content">Manual Call</a></li>

                                <div class="list_icon float_left"><img src="{base_url}themes/backend/images/icon_img.png" class="nav_icon" alt="Menu"> <a class="hide menu_titile">MENU</a></div>
                            </ul>



                        </div>

                        <!--                            <div class="width100 float_left">
                                                        <div class="width_40 float_left">
                                                            <h3 class="txt_clr2 ">Fire Dispatch Queue</h3>
                                                        </div>
                                                        <div class="width4 float_left">
                                                            <input type="text"  class="controls amb_search" id="mob_no" name="call_search" value="<?php echo @$rg_no; ?>" placeholder="Search"/>
                                                        </div>
                        
                                                        <div class="width_14 float_left">
                        
                                                            <input type="button" class="search_button float_right  form-xhttp-request" name="" value="Search" data-href="{base_url}supervisor/fire_dispatch" data-qr="output_position=content&amp;flt=true&amp;type=inc" />
                                                        </div>
                        
                                                    </div>-->
                    </div>
                </div>

            </div>
        </div>
        <div id="calls_inc_list">
            <div class="width100" id="ero_dash">
                <div id="amb_filters">
                    <div class="width100 float_left">                   

                        <div class="search">

                            <div class="row">


                                <div class="width100 float_left">
                                    <div class="width_15 float_left">
                                        <h3 class="txt_clr2 ">Incident Call</h3>
                                    </div>
                                    <div class="width4 float_left">
                                        <input type="text"  class="controls amb_search" id="mob_no" name="call_search" value="<?php echo @$rg_no; ?>" placeholder="Search"/>
                                    </div>

                                    <div class="width_40 float_left">

                                        <input type="button" class="search_button form-xhttp-request" name="" value="Search" data-href="{base_url}supervisor/fire_incident_calls" data-qr="output_position=content&amp;flt=true&amp;type=inc" />
                                        <input name="" value="Reset Filters" data-href="{base_url}supervisor/fire_dispatch" data-qr="output_position=content&amp;filters=reset" type="button" tabindex="3" autocomplete="off" class="search_button click-xhttp-request">
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
                            <th nowrap> Caller Number </th>
                            <th nowrap>Caller Name</th>
                            <th nowrap>Fire Incident ID</th>
                            <th nowrap>Incident ID</th>
                            <th nowrap>District Name</th>
                            <th nowrap>Ambulance No</th>
                            <th nowrap>Call Duration</th>
                            <th nowrap>ERO Name</th>
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
                                    <td ><a href="{base_url}calls/single_record_view" class="onpage_popup" data-qr="output_position=popup_div&fc_inc_ref_id=<?php echo $inc->fc_inc_ref_id; ?>" style="color:#000;"><?php echo $inc->fc_inc_ref_id; ?></a></td>
                                    <td ><a href="{base_url}calls/single_record_view" class="onpage_popup" data-qr="output_position=popup_div&inc_ref_id=<?php echo $inc->inc_ref_id; ?>" style="color:#000;"><?php echo $inc->inc_ref_id; ?></a></td>
                                    <td ><?php echo $inc->dst_name; ?></td>
                                    <td  nowrap><?php echo $inc->amb_rto_register_no; ?></td>
                                    <td ><?php echo ($inc->inc_dispatch_time); ?></td>
                                    <td nowrap><?php echo ucwords(strtolower($inc->inc_added_by)); ?></td>
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
        </div>
        <script>
            jQuery('#supervisor_container .sub_header_top_link #sub_incedence_steps li').on("click", function () {
                jQuery('#supervisor_container .sub_header_top_link #sub_incedence_steps li').removeClass("active_sub_supervisor_nav");
                jQuery(this).addClass("active_sub_supervisor_nav");
            });

        </script>