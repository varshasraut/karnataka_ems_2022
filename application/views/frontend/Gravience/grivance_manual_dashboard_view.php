<div id="calls_inc_list">

    <form method="post" name="inc_list_form" id="inc_list">  
        <div class="width100" id="ero_dash">
            <!--   <div id="amb_filters">
                                    <div class="width2 float_left">                   
            
                                        <div class="search">
            
                                            <div class="row">-->

            <!--                                    <div class="width100 float_left">
                                                    <div class="width_40 float_left">
                                                        <h3 class="txt_clr2 ">Previous incident Calls</h3>
                                                    </div>
            
                                                </div>-->
            <div id="amb_filters">

                <div class="width100"> 

                    <div class="width_16 float_left">   <h3 class="txt_clr2  float_left">Manual Calls</h3> </div>
                                                <?php if($clg_senior){?>
                                <div class="width20 float_left">
                                    <select id="ero_id" name="ero_id" class=""  data-errors="{filter_required:'Please select Grievance from dropdown list'}">
                                        <option value="">Select Grievance User</option>
                                        <?php
                                        foreach ($ero_clg as $purpose_of_call) {
                                            if ($purpose_of_call->clg_ref_id == $feedback_id) {
                                                $selected = "selected";
                                            } else {
                                                $selected = "";
                                            }
                                            echo "<option value='" . $purpose_of_call->clg_ref_id . "'  $selected";

                                            echo" >" . $purpose_of_call->clg_ref_id . "-" . $purpose_of_call->clg_first_name . " " . $purpose_of_call->clg_first_name;
                                            echo "</option>";
                                        }
                                        ?>
                                    </select>
                                </div>   
                             <?php } ?>
                    <div class="width_16 float_left">

                        <select name="filter" class="dropdown_per_page width90" data-base="search" id="grievance_filter_list">
                            <option value="">Select</option> 
                            <option value="complaint_type" <?php
                            if ($filter == 'complaint_type') {
                                echo "selected";
                            }
                            ?>>Complaint Type</option>
                            <option value="dst_name"  <?php
                            if ($filter == 'dst_name') {
                                echo "selected";
                            }
                            ?>>District</option>
                            <option value="status"  <?php
                            if ($filter == 'status') {
                                echo "selected";
                            }
                            ?>>Status</option>


                            <option value="complaint_id" 
                            <?php
//                                    if ($filter == 'complaint_id') {
//                                        echo "selected";
//                                    }
                            ?>>Complaint ID</option>
                            <option value="Date" 
                                    <?php
//                                    if ($filter == 'complaint_id') {
//                                        echo "selected";
//                                    }
                                    ?>>Date</option>
                        </select>
                    </div>
                    <?php //    ?>
                    <div id="complaint_list" class="width_16 float_left" style="<?php
                    if ($complaint_type != '') {
                        echo 'display:block;';
                    } else {
                        echo 'display:none;';
                    }
                    ?>">
                        <select name="complaint_type" class="dropdown_per_page width97" data-base="search" id="grievance_sub_filter_list">
                            <option value="">Select Complaint Type</option>

                            <option value="internal" <?php
//                                    if ($amb_reg_id == $amb->amb_rto_register_no) {
//                                        echo 'selected';
//                                    }
                            ?>>Internal</option>
                            <option value="external" <?php
//                                    if ($amb_reg_id == $amb->amb_rto_register_no) {
//                                        echo 'selected';
//                                    }
                            ?>>External</option>
                            <option value="e_complaint" <?php
//                                    if ($amb_reg_id == $amb->amb_rto_register_no) {
//                                        echo 'selected';
//                                    }
                            ?>>E-Complaint</option>
                            <option value="negative_news" <?php
//                                    if ($amb_reg_id == $amb->amb_rto_register_no) {
//                                        echo 'selected';
//                                    }
                            ?>>Negative News</option>

                        </select>     
                    </div>
                    <div id="district_list" class="width_16 float_left " style="<?php
                    if ($district_id != '') {
                        echo 'display:block;';
                    } else {
                        echo 'display:none;';
                    }
                    ?>">
                        <input name="district_id" class="mi_autocomplete width97" data-href="{base_url}auto/get_district/<?php echo $default_state;?>" placeholder="District" data-errors="{filter_required:'Please select state from dropdown list'}" tabindex="15" autocomplete="off" >
                    </div>
                    <div id="status_list" class="width_16 float_left " style="<?php
                    if ($status != '') {
                        echo 'display:block;';
                    } else {
                        echo 'display:none;';
                    }
                    ?>">
                        <select name="status" class="dropdown_per_page width97" data-base="search" >
                            <option value="">Select Status</option>

                            <option value="complaint_close" <?php
//                                    if ($amb_reg_id == $amb->amb_rto_register_no) {
//                                        echo 'selected';
//                                    }
                            ?>>Closed Complaint</option>
                            <option value="complaint_open" <?php
//                                    if ($amb_reg_id == $amb->amb_rto_register_no) {
//                                        echo 'selected';
//                                    }
                            ?>>Open Complaint</option>
                            <option value="complaint_pending" <?php
                            ?>>Pending Complaint</option>


                        </select> 
                    </div>

                    <div id="inc_id_box" class="width_16 float_left " style="<?php
                    if ($complaint_id != '') {
                        echo 'display:block;';
                    } else {
                        echo 'display:none;';
                    }
                    ?>">
                        <input name="complaint_id" tabindex="7.2" class=" form_input" placeholder="Complaint ID" type="text"  data-errors="{filter_required:'Please select hospital from dropdown list'}" >
                    </div>
                    <div id="gri_date" class="width_16 float_left " style="<?php
                            if ($gri_date_serach != '') {
                                echo 'display:block;';
                            } else {
                                echo 'display:none;';
                            }
                            ?>">
                                <input name="gri_date_serach" tabindex="7.2" class=" form_input mi_cur_timecalender " placeholder="Date" type="text"  data-errors="{filter_required:'Please select date'}" >
                            </div>
                            <div id="E_Complaint" class="width_16 float_left " style="<?php
                            if ($E_Complaint != '') {
                                echo 'display:block;';
                            } else {
                                echo 'display:none;';
                            }
                            ?>">
                                <input name="gri_E_Complaint" tabindex="7.2" class=" form_input " placeholder="Enter E-Complaint ID" type="text"  data-errors="{filter_required:'Please Enter E-Complaint'}" >
                            </div>
                    <div class="float_left">
                        <input type="button" class="search_button float_left form-xhttp-request" name="" value="Search" data-href="{base_url}grievance/grievance_manual_calls" data-qr="output_position=content&amp;flt=true" />  
                        <input class="search_button click-xhttp-request float_right" name="" value="Reset Filters" data-href="{base_url}grievance/grievance_manual_calls" data-qr="output_position=content&amp;filters=reset" type="button">
                    </div>
                </div>

            </div>
        </div>
        <div id="calls_inc_list">

            <form method="post" name="inc_list_form" id="inc_list">  
                <div class="width100" id="ero_dash">

                    <div id="list_table">

                        <table class="table report_table">
                            <tr>                                     

                                <th >Complaint Date & Time</th>
                                <th >Complaint Register No</th>
                                <th >Caller No</th>
                                <th >Name </th>
                                <th >District</th>
                                <th >Complaint</th>
                                <th >Complaint Added by </th>
                                <th >Complaint Closed by</th>
                                <th >Status </th>
                                <th >Action </th>

                            </tr>
                            <?php
                            if (count(@$inc_info) > 0) {

                                $total = 0;

                                foreach ($inc_info as $key => $inc) {

                                    $caller_name = $inc->clr_fname . "  " . $inc->clr_lname;
                                         $type = $inc->gc_complaint_type;
                                    ?>

                                    <tr>
                                        <td ><?php echo date("d-m-Y h:i:s", strtotime($inc->gc_added_date)); ?></td>
                                        <td ><a href="{base_url}calls/single_record_view" class="onpage_popup" data-qr="output_position=popup_div&inc_ref_id=<?php echo $inc->gc_inc_ref_id; ?>" style="color:#000;"><?php echo $inc->gc_inc_ref_id; ?></td>
                                        <td ><?php echo $inc->gc_caller_number; ?></td>
                                        <td ><?php echo ucwords($inc->gc_caller_name); ?></td>
                                        <td ><?php echo $inc->dst_name; ?></td>
                                             <td ><?php  echo ucwords($type); ?></td>
                                        <td ><?php echo ucwords($inc->gc_added_by); ?></td>
                                        <td  ><?php echo ucwords($inc->gc_modify_by); ?></td>
                                        <td ><?php
                                            if ($inc->gc_closure_status == 'complaint_open') {
                                                echo "Complaint Open";
                                            } else if ($inc->gc_closure_status == 'complaint_close') {
                                                echo "Complaint Close";
                                            } else if ($inc->gc_closure_status == 'complaint_pending' && $inc->gc_is_closed == '1') {
                                                echo "Complaint Close";
                                            } else if ($inc->gc_closure_status == 'complaint_pending' && $inc->gc_is_closed == '0') {
                                                echo "Complaint Pending";
                                            }
                                            ?></td>

                                        <td> 

                                            <div class="user_action_box fire_calls">

                                                <div class="colleagues_profile_actions_div"></div>

                                                   <ul class="profile_actions_list">

                                                            <li><a class="onpage_popup action_button" data-href="{base_url}grievance/view_complaint"  data-qr="output_position=content&amp;module_name=clg&amp;tlcode=MT-CLG-EDIT&amp;gc_id=<?php echo base64_encode($inc->gc_id) ?>&amp;gc_complaint_type=<?php echo base64_encode($inc->gc_complaint_type); ?>&amp;gc_inc_ref_id=<?php echo base64_encode($inc->gc_inc_ref_id) ?>&amp;action_type=View Work Station" data-popupwidth="1000" data-popupheight="600">View</a></li>
                                                            <?php if ($inc->gc_is_closed != '1') { ?>
                                                                <li><a class="onpage_popup action_button" data-href="{base_url}grievance/close_complaint" data-qr="output_position=content&amp;module_name=clg&amp;tlcode=MT-CLG-EDIT&amp;gc_id=<?php echo base64_encode($inc->gc_id) ?>&amp;gc_complaint_type=<?php echo base64_encode($inc->gc_complaint_type); ?>&amp;gc_inc_ref_id=<?php echo base64_encode($inc->gc_inc_ref_id) ?>&amp;action=edit_data&amp;action_type=Update"  data-popupwidth="1000" data-popupheight="580">Open</a></li>          



                                                            </ul> 
                                                </div>
                                            </td>
                                        </tr>

                                    <?php }
                                }
                                ?>

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

                                        <select name="pg_rec" class="dropdown_per_page float_left change-xhttp-request" data-href="{base_url}fire_calls/ero_dash" data-qr="output_position=content&amp;flt=true&amp;type=inc">

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
        </div>
</div>
</div>