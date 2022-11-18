
                <div >
                    <?php
                    if (!isset($emt_details)) {
                        $cl_class = "width_11";
                    } else {

                        $cl_class = "width_16";
                    }
                    ?>

                    <div class="width100">


                    </div>


                       <?php if ($m_no == '') { ?>
                        <div class="width_17 lefterror float_left">
                            <div class="filed_lable float_left "><label for="station_name">Caller No<span class="md_field">*</span></label></div>
                            <div class="float_left">
                            <input id="caller_no" type="text" name="caller[cl_mobile_number]" value="<?php echo $m_no; ?>"  placeholder="Mobile No" class="width90 float_left small half-text filter_required filter_mobile filter_minlength[8] filter_no_whitespace filter_mobile change-base-xhttp-request" data-errors="{filter_required:'Phone no should not be blank', filter_mobile:'Only numbers are allowed.', filter_minlength:'Mobile number at least 10 digit long.',filter_no_whitespace:'Phone number should not be allowed blank space.', filter_mobile:'Phone number should be valid.'}" TABINDEX="1.2" data-base="caller[cl_purpose]" <?php echo $view; ?> data-href="{base_url}police_calls/get_police_caller_details" data-qr="output_position=content&amp;showprocess=no&amp;fcrel=yes">
                            <a class="soft_dial_mobile click-xhttp-request" data-href="{base_url}avaya_api/soft_dial" data-qr="mobile_no=<?php echo @$police_station[0]->p_station_mobile_no; ?>"></a>
                        </div>
                        </div>
                    <?php } else { ?>
                        <div class="width_17 lefterror float_left">
                               <div class="filed_lable float_left "><label for="station_name">Caller No<span class="md_field">*</span></label></div>
                            <div class="float_left">
                            <input id="caller_no" type="text" name="caller[cl_mobile_number]" value="<?php echo $m_no; ?>"  placeholder="Mobile No" class="width90 float_left small half-text filter_required filter_mobile filter_minlength[8] filter_no_whitespace filter_mobile change-base-xhttp-request" data-errors="{filter_required:'Phone no should not be blank', filter_mobile:'Only numbers are allowed.', filter_minlength:'Mobile number at least 10 digit long.',filter_no_whitespace:'Phone number should not be allowed blank space.', filter_mobile:'Phone number should be valid.'}" TABINDEX="1.2" data-base="caller[cl_purpose]" <?php echo $view; ?> data-href="{base_url}police_calls/get_police_caller_details" data-qr="output_position=content&amp;showprocess=no&amp;fcrel=yes">
                            <a class="soft_dial_mobile click-xhttp-request" data-href="{base_url}avaya_api/soft_dial" data-qr="mobile_no=<?php echo @$police_station[0]->p_station_mobile_no; ?>"></a>
                            </div>
                        </div>
                    <?php } ?>


                    <div id="clr_rcl">
                        <span></span>
                    </div>

                    <?php if (!isset($emt_details)) { ?>


                        <div class="width_16 float_left input" id="caller_relation_div">
                              <div class="filed_lable float_left "><label for="station_name">Relation<span class="md_field">*</span></label></div>
                            <div class="float_left">
                            <select id="caller_relation" name="caller[cl_relation]" class="filter_required" data-errors="{filter_required:'Caller relation should not be blank'}" <?php echo $view; ?> TABINDEX="1.3" data-qr="output_position=inc_details&amp;module_name=calls&amp;showprocess=no"  data-href="{base_url}police_calls/save_call_details" onchange="submit_caller_form()">
                                <option value="">Select Relation</option>   
                                <?php echo get_relation(); ?>
                            </select>
                        </div>
                        </div>
                    <?php } ?>
                    <div class="<?php echo $cl_class; ?> float_left input">
                        <input id="first_name" type="text" name="caller[cl_firstname]" class="filter_required ucfirst"  data-errors="{filter_required:'First Name should not be blank',filter_word:'Invalid input at first name. Numbers and special characters not allowed.'}" value="<?= @$caller_details->clr_fname ?>" placeholder="First Name" TABINDEX="1.4" >
                    </div>
                    <div class="<?php echo $cl_class; ?> float_left input">
                        <input id="middle_name" type="text" name="caller[cl_middlename]" class=" ucfirst"  data-errors="{filter_word:'Invalid input at middle name. Numbers and special characters not allowed.'}" value="<?= @$caller_details->clr_mname ?>" placeholder="Middle Name" TABINDEX=1.5">
                    </div> 
                    <div class="<?php echo $cl_class; ?> float_left input">
                        <input id="last_name" type="text" name="caller[cl_lastname]" class="float_left ucfirst"  data-errors="{filter_word:'Invalid input at last name. Numbers and special characters not allowed.'}" value="<?= @$caller_details->clr_lname ?>" placeholder="Last Name" TABINDEX="1.6" >

                        <input type="hidden" id="hidden_caller_id" name="caller[caller_id]" value="<?= @$caller_details->clr_id ?>" data-base="caller[cl_purpose]">
                        <input type="hidden" id="caller_call_id" name="caller[call_id]" value="<?= @$caller_details->cl_id ?>" data-base="caller[cl_purpose]">
                        <input type="button" id="caller_details_form" name="submit" data-qr="output_position=inc_details&amp;module_name=calls&amp;showprocess=no" data-href="{base_url}police_calls/save_call_details" class="form-xhttp-request" data-base="caller[cl_purpose]" style="visibility:hidden;">
                        <a id="submit_call" class="hide form-xhttp-request float_left" data-href="{base_url}police_calls/save_call_details" data-qr="output_position=content&module_name=calls&showprocess=no"></a>
                    </div>

                    <div  id="dis_timer_clock" class="<?php // echo $cl_class;   ?> width_17  float_left input">
                        <input type='text' id="timer_clock" value="" readonly="readonly" name="incient[dispatch_time]"/>

                        <div class="float_right input">

                            <div id="cur_date_time_clock"> <?php echo date('d-m-Y H:i:s', strtotime($attend_call_time)); ?></div>
                            <input type="hidden" name="caller[attend_call_time]" value="<?php echo $attend_call_time; ?>">
                        </div>
                    </div>


                </div>  
        </div>
    </div>      
</div>

