<?php if($_SERVER['HTTP_HOST'] != 'www.mhems.in'){ ?>
<script>   

    
        stop_incoming_call_event();
   </script>     
<?php  } ?>
<div class="caller_details emt_caller">
    <form enctype="multipart/form-data" action="#" method="post" id="add_caller_details">
        <div class="call_bx">


            <div class=" width100">
                <div class="width15 float_left"><h3>AMBULANCE DETAILS</h3></div>
                <div class="width15 float_left">
                    <div id="purpose_of_calls" class="input">

                        <select id="call_purpose" name="caller[cl_purpose]" class="filter_required change-base-xhttp-request" data-href="{base_url}calls/save_call_details" data-qr="output_position=content&amp;module_name=calls&amp;showprocess=no" data-errors="{filter_required:'Purpose of call should not blank'}" data-base="caller[cl_purpose]" TABINDEX="6">
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

                        <input id="caller_no" type="hidden" name="caller[cl_mobile_number]" value="<?php echo $m_no; ?>"  data-base="caller[cl_purpose]">

                    </div>

                </div>

                <div class="amb_details float_left" style="color:#000 !important; ">

                    <ul class="dtl_row">

                        <li  style="color:#000 !important;">RTO No: <span style="color:#000 !important; "><?php echo $emt_details->amb_rto_register_no; ?></span></li>
                        <li  style="color:#000 !important;">Type: <span style="color:#000 !important; "><?php echo $emt_details->ambt_name; ?></span></li>
                        <li  style="color:#000 !important;">Mobile No:  <span style="color:#000 !important; "> <?php echo "  " . $emt_details->amb_default_mobile; ?></span></li>
                        <li  style="color:#000 !important;">District: <span style="color:#000 !important; "><?php echo $emt_details->dst_name; ?></span></li>
                    </ul>

                    <ul class="dtl_row">


                        <li  style="color:#000 !important; ">Base Location: <span><?php echo $emt_details->hp_name; ?></span></li>

                    </ul>

                </div>
                 <div class="<?php echo $cl_class; ?> float_left input"><input type='text' id="timer_clock" value="" readonly="readonly" name="incient[dispatch_time]"/></div>



                <input type="hidden" id="hidden_caller_id" name="caller[caller_id]" value="<?= @$caller_details->clr_id ?>" data-base="caller[cl_purpose]">
                <input type="hidden" id="caller_call_id" name="caller[call_id]" value="<?= @$caller_details->cl_id ?>" data-base="caller[cl_purpose]">

            </div>
        </div>
    </form>    



</div>






<div id="call_purpose_form">

</div>

<div id="common_call_script_view">

</div>


    <?php  $dispatch_time = $this->session->userdata('dispatch_time'); 
    $current_time = time();
    ?>
<script>
    StopTimerFunction();
       clock_timer('timer_clock','<?php echo $dispatch_time; ?>','<?php echo $current_time; ?>')
</script>



