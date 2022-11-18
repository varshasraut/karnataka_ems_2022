<?php $CI = EMS_Controller::get_instance(); ?>



<div id="calls_inc_list">

    <form method="post" name="inc_list_form" id="inc_list">  
        <div class="width100" id="ero_dash">
            <div id="amb_filters">
                <div class="width_70 float_left">                   

                    <div class="search">

                                 <div class="width100 float_left">
                                        <div class="width100 float_left">
                                            <h4 class="txt_clr2 ">Manual Call</h4>
                                        </div>
                                        
                                        <?php //if($clg_senior){?>
                                             <div class="width15 float_left">
                                            <select id="pda_id" name="pda_id" class=""  data-errors="{filter_required:'Please select PDA from dropdown list'}">
                                                <option value="">Select PDA User</option>
                                                <?php
                                                foreach ($pda_clg as $purpose_of_call) {
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
                                        <?php // } ?>


                                        <div class="filed_input float_left width15">
                                                 <!--<input name="search1" type="text" class=" mi_calender " placeholder=" Search Date" ></div>-->
                                            <input name="from_date" tabindex="1" class="form_input  width50" placeholder="From Date" type="text" data-base="search_btn" data-errors="{filter_required:'From Date should not be blank!',filter_time_hm:'Please enter valid time(H:i)'}" value="" readonly="readonly" id="from_date">
                                        </div>
                                        <div class="filed_input float_left width15">
                                            <input name="to_date" tabindex="2" class="form_input  width50" placeholder="To Date" type="text" data-base="search_btn" data-errors="{filter_required:'To Date should not be blank!',filter_time_hm:'Please enter valid time(H:i)'}" value="" readonly="readonly" id="to_date">
                                        </div>
                                        <div class="filed_input float_left width15">
                                                 <!--<input name="search1" type="text" class=" mi_calender " placeholder=" Search Date" ></div>-->
                                            <input name="inc_ref_id" tabindex="1" class="form_input width50" placeholder="Incident Id" type="text" data-base="search_btn" data-errors="{filter_required:'Incident Id should not be blank!'}" value="">
                                        </div>
                                        <div class="filed_input float_left width15">
                                                 <!--<input name="search1" type="text" class=" mi_calender " placeholder=" Search Date" ></div>-->
                                            <input name="pc_inc_ref_id" tabindex="1" class="form_input width50" placeholder="Police Incident Id" type="text" data-base="search_btn" data-errors="{filter_required:'Incident Id should not be blank!'}" value="">
                                        </div>     
                                        <div class="filed_input float_left width_15">
                                                <input type="button" style="margin: auto;" name="search" value="Search" class="btn clg_search form-xhttp-request" data-href="{base_url}police_calls/manual_calls" data-qr="output_position=content&amp;filter_search=search&amp;module_name=clg&amp;tlcode=MT-CLG-ACTION-MULTI&amp;action_name=search_clgs" >
                                        </div>
                                        <div class="filed_input float_left width10">
                                                <input type="reset" style="margin: auto;" class="search_button float_left form-xhttp-request" name="" value="Reset Filter" data-href="{base_url}police_calls/manual_calls" data-qr="output_position=content&amp;flt=reset&amp;type=inc" tabindex="5" autocomplete="off">
                                        </div>
                                    </div>
                    </div>

                </div>
            </div>
            

            <form method="post" name="inc_list_form" id="inc_list">  
                <div class="width100" id="ero_dash">


                    <div id="list_table">

                        <table class="table report_table table-bordered">
                            <tr>                                     

                                <th>Dispatch Date & Time</th>
                                <th>Police Incident ID</th>
                                <th >Police Call Assign Time</th>
                                <th >Caller Name</th>
                                <th >District Name</th>
                                <th >Caller Mob No</th>
                                <th >Police Station Name</th>
                                <th >Police Station Number</th>
                                <th >Police station Receiver Name</th>
                                <th >Police Complaint</th>
                                <th >Action</th>
                            </tr>
                            <?php
                            if (count(@$inc_info) > 0) {



                                $total = 0;

                                foreach ($inc_info as $key => $inc) {


                                    $caller_name = $inc->clr_fname . "  " . $inc->clr_lname;
                                    ?>

                                    <tr>

                                        <td ><?php echo date("d-m-Y h:i:s", strtotime($inc->pc_added_date)); ?></td>

                                        <td ><a href="{base_url}calls/single_record_view" class="onpage_popup" data-qr="output_position=popup_div&pc_inc_ref_id=<?php echo $inc->pc_inc_ref_id; ?>" style="color:#000;"><?php echo $inc->pc_inc_ref_id; ?></a></td>
                                        <td ><?php echo $inc->pc_assign_time; ?></td>
                                        <td ><?php echo ucwords($caller_name); ?></td>
                                        <td ><?php echo $inc->dst_name; ?></td>
                                        <td ><?php echo $inc->clr_mobile; ?></td>
                                        <td ><?php echo $inc->police_station_name; ?></td>
                                        <td  nowrap><?php echo $inc->p_station_mobile_no; ?></td>
                                        <td ><?php echo ucwords($inc->pc_call_receiver_name); ?></td>
                                        <td ><?php echo ($inc->po_ct_name); ?></td>
                                        <td> 

                                            <div class="user_action_box fire_calls">

                                                <div class="colleagues_profile_actions_div"></div>

                                                <!--                                                        <ul class="profile_actions_list">
                                                                                                            <li><a class="onpage_popup action_button" data-href="{base_url}police_calls/police_manual_records_view" data-qr="output_position=content&amp;module_name=clg&amp;tlcode=MT-CLG-EDIT&amp;pc_inc_ref_id=<?php echo base64_encode($inc->pc_inc_ref_id) ?>&amp;inc_ref_id=<?php echo base64_encode($inc->pc_pre_inc_ref_id) ?>&amp;action=view_data&amp;action_type=View"  data-popupwidth="1000" data-popupheight="700">View</a></li>          
                                                
                                                
                                                
                                                                                                        </ul> -->

                                                <ul class="profile_actions_list">
                                                    <li><a class="onpage_popup action_button" data-href="{base_url}police_calls/police_manual_records_view" data-qr="output_position=content&amp;module_name=clg&amp;tlcode=MT-CLG-EDIT&amp;pc_inc_ref_id=<?php echo base64_encode($inc->pc_inc_ref_id) ?>&amp;inc_ref_id=<?php echo base64_encode($inc->inc_ref_id) ?>&amp;action=view_data&amp;action_type=View"  data-popupwidth="1200" data-popupheight="600">View</a></li>
                                                    <?php if ($inc->pc_is_close != '1') { ?>
                                                        <li><a class="onpage_popup action_button" data-href="{base_url}police_calls/police_manual_records_view" data-qr="output_position=content&amp;module_name=clg&amp;tlcode=MT-CLG-EDIT&amp;pc_inc_ref_id=<?php echo base64_encode($inc->pc_inc_ref_id) ?>&amp;inc_ref_id=<?php echo base64_encode($inc->inc_ref_id) ?>&amp;action=view_data&amp;action_type=Update"  data-popupwidth="1200" data-popupheight="600">Update</a></li> 

                                                    <?php } ?>

                                                </ul> 
                                            </div>
                                        </td>
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

                                        <select name="pg_rec" class="dropdown_per_page float_left change-xhttp-request" data-href="{base_url}police_calls/police_dash" data-qr="output_position=content&amp;flt=true&amp;type=inc">

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
</div>

<script>
    jQuery(document).ready(function () {

        var dateFormat = "mm/dd/yy",
                from = jQuery("#from_date")
                .datepicker({
                    defaultDate:  new Date(),
                    changeMonth: true,
                    numberOfMonths: 2
                })
                .on("change", function () {
                    to.datepicker("option", "minDate", getDate(this));
                }),
                to = jQuery("#to_date").datepicker({
            defaultDate:  new Date(),
            changeMonth: true,
            numberOfMonths: 2
        })
                .on("change", function () {
                    from.datepicker("option", "maxDate", getDate(this));
                });

        function getDate(element) {
            var date;
            try {
                date = $.datepicker.parseDate(dateFormat, element.value);
            } catch (error) {
                date = null;
            }
            return date;
        }
    });

</script>
