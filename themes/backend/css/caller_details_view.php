<?php   
$view = "";
//if($m_no != ''){ $view='disabled'; }

$CI = EMS_Controller::get_instance();

?>
<script>jQuery("#call_purpose").focus();</script>
<div class="caller_details" id="caller_details">
    <form enctype="multipart/form-data" action="#" method="post" id="add_caller_details">
        <div class="call_bx">
            <?php
            if (!isset($emt_details)) {
                $cl_class = "width_14";
            } else {

                $cl_class = "width_16";
            }
            ?>

            <div class="width100">
                <div class="<?php echo $cl_class; ?> float_left outer_caller_dl"> <h3>CALLER DETAILS</h3></div>
                
                    <div class="input_call_outer">
                        <div class="<?php echo $cl_class; ?> float_left">
                          <div id="purpose_of_calls" class="input">
      <?php //$this->load->view('frontend/calls/purpose_of_calls_view');  ?>
                              <select id="call_purpose" name="caller[cl_purpose]" class="filter_required" data-href="{base_url}calls/save_call_details" data-qr="output_position=content&amp;module_name=calls&amp;showprocess=no" data-errors="{filter_required:'Purpose of call should not blank'}" data-base="caller[cl_mobile_number]" TABINDEX="1.1"  onchange="submit_caller_form()">
                                  <option value="">Purpose Of calls</option>
                                  <?php
                                  $select_group[$cl_purpose] = "selected = selected"; 

                                  foreach ($purpose_of_calls as $purpose_of_call) {
                                      echo "<option value='" . $purpose_of_call->pcode . "'  ";
                                      echo $select_group[$purpose_of_call->pcode];
                                      echo" >" . $purpose_of_call->pname;
                                      echo "</option>";
                                  }
                                  ?>
                              </select>
                          </div>


                  </div>
                <?php if($m_no == ''){?>
                            <div class="<?php echo $cl_class; ?> float_left">
                                  <input id="caller_no" type="text" name="caller[cl_mobile_number]" value="+91<?php echo $m_no; ?>"  placeholder="Mobile No" class="small half-text filter_required filter_mobile filter_minlength[9] filter_no_whitespace filter_mobile change-base-xhttp-request" data-errors="{filter_required:'Phone no should not be blank', filter_mobile:'Only numbers are allowed.', filter_minlength:'Mobile number should be at least 10 digit long.',filter_no_whitespace:'Phone number should not be allowed blank space.', filter_mobile:'Phone number should be valid.'}" TABINDEX="1.2" data-base="caller[cl_purpose]" <?php echo $view;?> data-href="{base_url}calls/get_caller_details" data-qr="output_position=content&amp;module_name=calls&amp;showprocess=no" >

                           </div>
                <?php } else { ?>
                            <div class="<?php echo $cl_class; ?> float_left">
                              <input id="caller_no" type="text" name="caller[cl_mobile_number]" value="+91<?php echo $m_no; ?>"  placeholder="Mobile No" class="small half-text filter_required filter_mobile filter_minlength[9] filter_no_whitespace filter_mobile change-base-xhttp-request" data-errors="{filter_required:'Phone no should not be blank', filter_mobile:'Only numbers are allowed.', filter_minlength:'Mobile number should be at least 10 digit long.',filter_no_whitespace:'Phone number should not be allowed blank space.', filter_mobile:'Phone number should be valid.'}" TABINDEX="1.2" data-base="caller[cl_purpose]" <?php echo $view;?> data-href="{base_url}calls/get_caller_details">
                            </div>
                <?php } ?>
<?php if (!isset($emt_details)) { ?>


                            <div class="<?php echo $cl_class; ?> float_left input" id="caller_relation_div">
                                <select id="caller_relation" name="caller[cl_relation]" class="" data-errors="{filter_required:'Caller relation should not be blank'}" <?php echo $view; ?> TABINDEX="1.3" data-qr="output_position=inc_details&amp;module_name=calls&amp;showprocess=no"  data-href="{base_url}calls/save_call_details" onchange="submit_caller_form()">
                                    <option value="">Select Relation</option>   
                                    <?php echo get_relation();?>
                                </select>
                            </div>
<?php } ?>
                            <div class="<?php echo $cl_class; ?> float_left input">
                                <input id="first_name" type="text" name="caller[cl_firstname]" class=" ucfirst"  data-errors="{filter_word:'Invalid input at first name. Numbers and special characters not allowed.'}" value="<?= @$caller_details->clr_fname ?>" placeholder="First Name" TABINDEX="1.4" >
                            </div>
                            <div class="<?php echo $cl_class; ?> float_left input">
                                <input id="middle_name" type="text" name="caller[cl_middlename]" class=" ucfirst"  data-errors="{filter_word:'Invalid input at middle name. Numbers and special characters not allowed.'}" value="<?= @$caller_details->clr_mname ?>" placeholder="Middle Name" TABINDEX=1.5">
                            </div>
                            <div class="<?php echo $cl_class; ?> float_left input">
                                <input id="last_name" type="text" name="caller[cl_lastname]" class=" ucfirst"  data-errors="{filter_word:'Invalid input at last name. Numbers and special characters not allowed.'}" value="<?= @$caller_details->clr_lname ?>" placeholder="Last Name" TABINDEX="1.6" >

                            <input type="hidden" id="hidden_caller_id" name="caller[caller_id]" value="<?= @$caller_details->clr_id ?>" data-base="caller[cl_purpose]">
                            <input type="hidden" id="caller_call_id" name="caller[call_id]" value="<?= @$caller_details->cl_id ?>" data-base="caller[cl_purpose]">
                            <input type="button" id="caller_details_form" name="submit" data-qr="output_position=inc_details&amp;module_name=calls&amp;showprocess=no" data-href="{base_url}calls/save_call_details" class="form-xhttp-request" data-base="caller[cl_purpose]" style="visibility:hidden;">
                                    <a id="submit_call" class="hide form-xhttp-request" data-href="{base_url}calls/save_call_details" data-qr="output_position=inc_details&module_name=calls&showprocess=no"></a>
                         </div>
                </div>
            </div>
        </div>        
    </form>    

</div>

<div id="call_purpose_form">

</div>

<div id="common_call_script_view">

</div>





