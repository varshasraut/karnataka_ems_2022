    <div class="head_outer background-color-new">
        <h3 class="txt_clr2 width1">Caller History</h3>
    </div>
 
    <form method="post" name="" id="call_dls_info">

        <div class="inline_fields width100">

            <div class="form_field width100 pos_rel">

                <div class="outer_id width100">

                    <div class="float_left width10 hide">
                        <h3>Caller Number <span class="md_field">*</span></h3>
                    </div>
                    <div class="input float_left width10">
                        <input onkeyup="this.value=this.value.replace(/[^\d]/,'')" value="<?php echo $mobile_no; ?>" name="mobile_no" tabindex="1" id="inc_ref_id" class="form_input " placeholder="Enter Caller Number" type="text" data-base="search_btn" data-errors="{filter_required:' Caller Number should not be blank!',filter_either_or:'Mobile numbers or purpose of call should not be blank.'}" autocomplete="off">
                    </div>
                    <div class="input float_left width10">
                        <input type="text" class="form_input filter_if_not_blank filter_word" name="search_caller_details" data-base="search_btn" placeholder="Enter Caller Details" tabindex="6" autocomplete="off" data-errors="{filter_required:'Caller Details should not be blank', filter_word:'Invalid input at Caller Details. Numbers and special characters not allowed.'}">
                    </div>
                    <!--<div class="width10 float_left">
                        <div class="width100 float_left">
                            <select name="h_call_status" placeholder="Select Call Status" class="form_input " style="color:#666666" data-errors="{filter_required:'Call Status should not blank'}" data-base="search_btn" tabindex="2">
                                <option value='all' selected>All call</option>
                                <option value='0'>Active</option>
                                <option value='2'>Terminated</option>

                            </select>
                        </div>
                    </div>-->
                    <div class="input float_left width10">

                        <select id="parent_call_purpose" name="h_call_purpose" class="form_input " data-errors="{filter_required:'Purpose of call should not blank',filter_either_or:'Mobile numbers or purpose of call should not be blank.'}" data-base="search_btn" tabindex="2" data-base="search_btn">
                            <option value=''>Select Purpose of call</option>
                            <option value='all' selected>All call</option>

                            <?php


                            foreach ($all_purpose_of_calls as $purpose_of_call) {
                                echo "<option value='" . $purpose_of_call->pcode . "'  ";
                                echo $select_group[$purpose_of_call->pcode];
                                echo " >" . $purpose_of_call->pname;
                                echo "</option>";
                            }
                            ?>
                        </select>

                    </div>
                    <div class="input float_left width10">
                        <select id="clg_id" name="clg_id" class="form_input " data-base="search_btn" tabindex="2" data-base="search_btn">
                            <option value=''>Select ERO ID</option>


                            <?php


                            foreach ($clg_list as $clg_list_all) {
                                echo "<option value='" . $clg_list_all->clg_ref_id . "'  ";
                                echo $select_group[$clg_list_all->clg_ref_id];
                                echo " >" . $clg_list_all->clg_ref_id;
                                echo "</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="filed_input float_left width10">
                        <input name="h_from_date" tabindex="1" class="form_input  width50" placeholder="From Date" type="text" data-base="search_btn" data-errors="{filter_required:'From Date should not be blank!',filter_time_hm:'Please enter valid time(H:i)'}" value="<?php echo $from_date; ?>" readonly="readonly" id="from_date">
                    </div>
                    <div class="filed_input float_left width10">
                        <input name="h_to_date" tabindex="2" class="form_input  width50" placeholder="To Date" type="text" data-base="search_btn" data-errors="{filter_required:'To Date should not be blank!',filter_time_hm:'Please enter valid time(H:i)'}" value="<?php echo $to_date; ?>" readonly="readonly" id="to_date">
                    </div>
                    <div class="width10 float_left ">
                        <input name="h_district_id" class="mi_autocomplete width97" data-href="<?php echo base_url(); ?>auto/get_district/<?php echo $default_state; ?>" placeholder="District" data-errors="{filter_required:'Please select state from dropdown list'}" tabindex="15" autocomplete="off" data-base="search_btn">
                    </div>

                    <div class="float_left width_20 ">

                        <!--                    <div class="label">&nbsp;</div>-->
                        <!-- <input name="search_btn" value="Search" class="style3 base-xhttp-request float_left button_color" data-href="<?php echo base_url(); ?>calls/single_caller_history" data-qr="output_position=single_record_details" type="button" style="float:left; margin-top: 0px;"> -->
                        <input name="search_btn" value="Search" class="base-xhttp-request float_left button_color" data-href="<?php echo base_url(); ?>calls/single_caller_history" data-qr="output_position=single_record_details" type="button" style="float:left; margin-top: 0px;">
                        <!--                       <input name="search_btn" value="SEARCH" class="style3 base-xhttp-request" data-href="http://mulikas4/spero_ems_2019/medadv/call_details" data-qr="output_position=content" type="button" tabindex="2" autocomplete="off">-->
                        <input name="reset_filter" tabindex="19" value="Reset Filter" class=" click-xhttp-request style3 float_left button_color_reset" data-href="<?php echo base_url(); ?>calls/caller_record_reset" data-qr="output_position=inc_details&amp;filter=true" type="reset" style=" margin-top: 0px;" autocomplete="off">

                    </div>
                </div>
            </div>
        </div>
    </form>
    <div id="caller_single_record_details">
    </div>