

<form method="post" name="inc_list_form" id="inc_list">  
    <div class="width100" id="ero_dash">

        <div id="amb_filters">
            <div class="width100 float_left">                   

                <div class="search">

                    <div class="row">

                        <div class="width100 float_left">
                            <div class="width100 float_left">
                                <h3 class="txt_clr2 ">EMS Professional Call</h3>
                            </div>
                            <?php if($clg_senior){?>
                                             <div class="width20 float_left">
                                            <select id="ero_id" name="ero_id" class=""  data-errors="{filter_required:'Please select ERO from dropdown list'}">
                                                <option value="">Select ERO User</option>
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
                                        <div class="filed_input float_left width20">
                                                 <!--<input name="search1" type="text" class=" mi_calender " placeholder=" Search Date" ></div>-->
                                            <input name="from_date" tabindex="1" class="form_input  width50" placeholder="From Date" type="text" data-base="search_btn" data-errors="{filter_required:'From Date should not be blank!',filter_time_hm:'Please enter valid time(H:i)'}" value="" readonly="readonly" id="from_date">
                                        </div>
                                        <div class="filed_input float_left width20">
                                            <input name="to_date" tabindex="2" class="form_input  width50" placeholder="To Date" type="text" data-base="search_btn" data-errors="{filter_required:'To Date should not be blank!',filter_time_hm:'Please enter valid time(H:i)'}" value="" readonly="readonly" id="to_date">
                                        </div>

                            <div class="width20 float_left">
                                <input type="text"  class="controls amb_search" id="mob_no" name="call_search" value="<?php echo @$rg_no; ?>" placeholder="Search"/>
                            </div>

                            <div class="width40 float_left">

                                <input type="button" class="search_button float_left form-xhttp-request" name="" value="Search" data-href="{base_url}ambercp/eme_professional_call" data-qr="output_position=content&amp;flt=true&amp;type=inc" />
                                
                                 <input type="reset" class="search_button float_left form-xhttp-request" name="" value="Reset Filter" data-href="{base_url}ambercp/eme_professional_call" data-qr="output_position=content&amp;flt=reset&amp;type=inc" />
                                
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="list_table">

            <table class="table report_table">
                <tr>                                     

                    <th>Date & Time</th>
                    <th>Incident ID</th>
                    <th>Caller Name</th>
                    <th>Caller Mobile No</th>
                    <th>Attended By</th>
                    <th>Audio File</th>
                    <th>Call Time</th>
                    <th>Call Type</th>
                    <th>Action</th>
                </tr>

                <?php
                if (count(@$inc_info) > 0) {
                    $total = 0;

                    foreach ($inc_info as $key => $inc) {


                        if (($inc->ptn_mname == '') && ($inc->ptn_fname == '')) {
                            $inc->ptn_mname = "-";
                            $inc->ptn_fname = "-";
                        }

//                           if($inc->ptn_fullname != ''){
//                               $patient_name = $inc->ptn_fullname;
//                           }else{
                        $patient_name = $inc->ptn_fname . " " . $inc->ptn_mname . " " . $inc->ptn_lname;
                        // }

//                        if ($inc->clr_fullname != '') {
//                            $caller_name = $inc->clr_fullname;
//                        } else {
                            $caller_name = $inc->clr_fname . "  " . $inc->clr_lname;
//                        }
                        ?>

                        <tr>
                            <td ><?php echo date("d-m-Y h:i:s", strtotime($inc->inc_datetime)); ?></td>

                            <td ><a href="{base_url}calls/single_record_view" class="onpage_popup" data-qr="output_position=popup_div&inc_ref_id=<?php echo $inc->inc_ref_id; ?>" style="color:#000;"><?php echo $inc->inc_ref_id; ?></a></td>

                            <td ><?php echo ucwords($caller_name); ?></td>

                            <td ><?php echo $inc->clr_mobile; ?></td>
                            <td nowrap><?php echo $inc->inc_added_by; ?></td>
                            <td>
                                    <?php  
                                    $inc_datetime = date("Y-m-d", strtotime($inc->inc_datetime));
                                    $pic_path =  $inc->inc_audio_file; 
                                    $pic_path =   get_inc_recording($inc->inc_avaya_uniqueid,$inc_datetime);
                                        
                                    if($pic_path != ''){
                                        ?>
                                    <audio controls  controlsList="nodownload" style="width: 185px;">
                                      <source src="<?php echo $pic_path;?>" type="audio/wav">
                                    Your browser does not support the audio element.
                                    </audio> 
                                <?php  } ?>
                                   
                            </td>
                            <td><?php echo ($inc->inc_dispatch_time); ?></td>
                            <td><?php echo ucwords($inc->pname); ?></td>
                            <td>
<!--                                <a class="click-xhttp-request btn" data-href="{base_url}clg/edit_clg" data-qr="output_position=popup_div&amp;module_name=eme_professional_call&amp;ref_id=<?php echo $inc->inc_ref_id; ?>&amp;action=view">View</a>-->
                                <a class="click-xhttp-request btn" data-href="{base_url}ambercp/view_professional_call" data-qr="output_position=popup_div&amp;module_name=eme_professional_call&amp;ref_id=<?php echo $inc->inc_ref_id; ?>&amp;action=view">View</a>
                            </td>
                          
                            <?php //} ?>
                        </tr>

                    <?php } ?>

                <?php } else { ?>
                        <?php if($clg_senior){ ?>
                            <tr><td colspan="16" class="no_record_text">No Record Found</td></tr>
                        <?php }else{ ?>
                             <tr><td colspan="16" class="no_record_text">No Record Found</td></tr>
                        <?php }?>
                <?php } ?>   





            </table>



            <div class="bottom_outer">

                <div class="pagination"><?php echo $pagination; ?></div>

                <input type="hidden" name="submit_data" value="<?php if (@$data) {
                    echo $data;
                } ?>">

                <div class="width33 float_right">

                    <div class="record_per_pg">

                        <div class="per_page_box_wrapper">

                            <span class="dropdown_pg_txt float_left"> Records per page : </span>

                            <select name="pg_rec" class="dropdown_per_page float_left change-xhttp-request" data-href="{base_url}ambercp/eme_professional_call" data-qr="output_position=content&amp;flt=true&amp;type=inc">

<?php echo rec_perpg($pg_rec); ?>

                            </select>

                        </div>

                        <div class="float_right">
                            <span> Total records: <?php if (@$inc_total_count) {
    echo $inc_total_count;
} else {
    echo"0";
} ?> </span>
                        </div>
                    </div>

                </div>

            </div>

        </div>
    </div>
</form>
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