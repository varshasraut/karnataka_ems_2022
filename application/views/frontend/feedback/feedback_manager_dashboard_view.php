<?php $CI = EMS_Controller::get_instance(); ?>

<!--<h3 class="txt_clr5 width2 float_left">Dashboard</h3><br>-->
<div class="width100"> 
   <form method="post" name="inc_list_form" id="inc_list">  
    <div class="width_16 float_left">   <h3 class="txt_clr2  float_left">Dashboard</h3> </div>
    
    <div class="width25 float_left">
        <select id="ercp_id" name="feedback_id" class=""  data-errors="{filter_required:'Please select Call Type from dropdown list'}">
            <option value="">Select Feedback User</option>
            <?php
            foreach ($feedback_clg as $purpose_of_call) {
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
    <div class="width_16 float_left">

        <select name="filter" class="dropdown_per_page width90" data-base="search" id="feedback_filter_list">
            <option value="">Select</option> 
            <option value="call_type" <?php
            if ($filter == 'call_type') {
                echo "selected";
            }
            ?>>Call Type</option>

            <option value="date" 
            <?php
//                                  
            ?>>Date</option>


            <option value="inc_id" 
            <?php
//                                  
            ?>>Incident ID</option>

        </select>
    </div>
    <?php //    ?>
    <div id="call_list" class="width_16 float_left" style="<?php
    if ($call_type != '') {
        echo 'display:block;';
    } else {
        echo 'display:none;';
    }
    ?>">
        <select name="call_type" class="dropdown_per_page width97" data-base="search" >
            <option value="">Select Call Type</option>
            <?php foreach ($purpose_calls as $calls) { ?>
                <option value="<?php echo $calls->pcode ?>" ><?php echo $calls->pname ?></option>
                    <?php } ?>


        </select>     
    </div>
   
    <div id="inc_id_box" class="width_16 float_left " style="<?php
    if ($inc_id != '') {
        echo 'display:block;';
    } else {
        echo 'display:none;';
    }
    ?>">
        <input name="inc_id" tabindex="7.2" class=" form_input" placeholder="Incident ID" type="text"  data-errors="{filter_required:'Please select hospital from dropdown list'}" >
    </div>
    
      <div id="inc_date" class="width_16 float_left " style="<?php
    if ($date != '') {
        echo 'display:block;';
    } else {
        echo 'display:none;';
    }
    ?>">
        <input name="date" tabindex="7.2" class="form_input mi_calender" placeholder="date" type="text"  data-errors="{filter_required:'Please select hospital from dropdown list'}" >
    </div>

    <div class="float_left">
        <input type="button" class="search_button float_left form-xhttp-request" name="" value="Search" data-href="{base_url}feedback/feedback_manager" data-qr="output_position=content&amp;flt=true" />  
        <input class="search_button click-xhttp-request float_right" name="" value="Reset Filters" data-href="{base_url}feedback/feedback_manager" data-qr="output_position=content&amp;filters=reset" type="button">
    </div>
   </form>
</div>

<form method="post" name="feedback_dash_form" id="feedack_dash">  


    <div id="list_table">
        <table class="table report_table">
            <tr>                                     
                <th>Date & Time</th>
                <th>Incident ID</th>
<!--                <th>Chief Complaint</th>-->
                <th>Call Type</th>
                <!--<th nowrap>Base location</th>-->
                <th>Caller Number</th>
                <!--<th>Destination hospital</th>-->
                <th>Caller Name</th>
                <th>Action</th> 
            </tr>

            <?php
            if ($inc_info) {

                $key = 1;
                foreach ($inc_info as $inc) {

//                    var_dump($inc);
                    ?>
                    <tr>

                        <td><?php echo date("d-m-Y h:m:i", strtotime($inc->inc_datetime)); ?></td>

                        <td><?php echo $inc->inc_ref_id; ?></td>

                        <?php
                        if ($inc->inc_mci_nature != '') {
                            ?>
                                                                            <!--<td ><?php echo get_mci_nature_service($inc->inc_mci_nature); ?></td>-->
                        <?php } else { ?>
                                                                            <!--<td ><?php echo get_cheif_complaint($inc->inc_complaint); ?></td>-->
                        <?php } ?>


                        <td><?php
                            echo $inc->pname;
                            if ($inc->cl_name != '') {
                                ?> &nbsp; [ <?php echo $inc->cl_name; ?> ] <?php } ?> </td>                          
                        <!--<td nowrap><?php echo $inc->hp_name; ?></td>-->
                        <td><?php echo $inc->clr_mobile; ?></td>    


                        <td ><?php echo ucwords($inc->clr_fname); ?> </td>
                        <td> 

                            <div class="user_action_box fire_calls">

                                <div class="colleagues_profile_actions_div"></div>

                                <ul class="profile_actions_list">
                                    <!--
                                                                                <li><a class="onpage_popup action_button" data-href="{base_url}grievance/view_complaint"  data-qr="output_position=content&amp;module_name=clg&amp;tlcode=MT-CLG-EDIT&amp;gc_id=<?php echo base64_encode($inc->gc_id) ?>&amp;gc_complaint_type=<?php echo base64_encode($inc->gc_complaint_type); ?>&amp;action_type=View Work Station" data-popupwidth="1000" data-popupheight="600">View</a></li>-->

                                    <li><a class="onpage_popup action_button" data-href="{base_url}feedback/report_view" data-qr="output_position=content&inc_ref_id=<?php echo base64_encode($inc->inc_ref_id) ?>&action=edit_data&action_type=Update"  data-popupwidth="1300" data-popupheight="700">View</a></li>          



                                </ul> 
                            </div>
                        </td>

                    </tr>

                    <?php
                }
            } else {
                ?>

                <tr><td colspan="7" class="no_record_text">No Record Found</td></tr>

            <?php } ?>   


        </table>

        <div class="bottom_outer">

            <div class="pagination"><?php echo $pagination; ?></div>

            <div class="width33 float_right">

                <div class="record_per_pg">

                    <div class="per_page_box_wrapper">

                        <span class="dropdown_pg_txt float_left"> Records per page : </span>

                        <select name="pg_rec" class="dropdown_per_page float_left change-xhttp-request" data-href="{base_url}feedback/feedback_manager" data-qr="output_position=content&amp;flt=true">

                            <?php echo rec_perpg($pg_rec); ?>

                        </select>

                    </div>

                    <div class="float_right">
                        <span> Total records: <?php echo ($total_count > 0) ? $total_count : "0"; ?> </span>
                    </div>

                </div>

            </div>

        </div>



    </div>
</form>