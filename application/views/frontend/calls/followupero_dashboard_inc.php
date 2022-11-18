<form method="post" name="inc_list_form" id="inc_list">  
        <div class="width100" id="ero_dash">
            <div id="amb_filters">
                <div class="width100 float_left">                   

                    <div class="search">

                        <div class="row">
                        <h3 class="txt_clr2 ">Call Details</h3>
                         </div>  
                            
                                   <?php if($clg_senior){?>
                        
                        <div class="width10 float_left">
                       
                                    <select id="team_type" name="team_type"  class="" data-errors="{filter_required:'Team should not blank'}" TABINDEX="7"  <?php echo $view; ?>>

                                        <option value="">Select Team Type</option>
                                   <option value='all' <?php if($team_type == '' || $team_type == 'all'){ echo "Selected"; } ?>>All</option>
                                        <option value="UG-ERO-102" <?php if($team_type != '' && $team_type == 'UG-ERO-102'){ echo "Selected"; } ?>>ERO 102</option>
                                        <option value="UG-ERO" <?php if($team_type != '' && $team_type == 'UG-ERO'){ echo "Selected"; } ?>>ERO 108</option>
                                       
                                    </select>
                               </div>
                                             <div class="width10 float_left" id="ero_list_outer_qality">
                                            
                                            <select id="ero_id" name="user_id" class=""  data-errors="{filter_required:'Please select ERO from dropdown list'}">
                                                <option value="">Select ERO User</option>
                                                <option value="all" <?php if($user_id == 'all'){ echo "selected"; }?>>All User</option>
                                                
                                                <?php
                                                foreach ($ero_clg as $purpose_of_call) {
                                                    if ($purpose_of_call->clg_ref_id == $user_id) {
                                                        $selected = "selected";
                                                    } else {
                                                        $selected = "";
                                                    }
                                                    echo "<option value='" . $purpose_of_call->clg_ref_id . "'  $selected";

                                                    echo" >". $purpose_of_call->clg_first_name . " " . $purpose_of_call->clg_last_name;
                                                    echo "</option>";
                                                }
                                                ?>
                                            </select>
                                        </div>  
                                        
                                        <?php } ?>
                                        <div class="filed_input float_left width10">
                                                 <!-- <input name="search1" type="text" class=" mi_calender " placeholder=" Search Date" ></div> -->
                                            <input name="from_date" tabindex="1" class="form_input  width50" placeholder="From Date" type="text" data-base="search_btn" data-errors="{filter_required:'From Date should not be blank!',filter_time_hm:'Please enter valid time(H:i)'}" value="<?php echo $from_date;?>" readonly="readonly" id="from_date">
                                        </div>
                                        <div class="filed_input float_left width10">
                                            <input name="to_date" tabindex="2" class="form_input  width50" placeholder="To Date" type="text" data-base="search_btn" data-errors="{filter_required:'To Date should not be blank!',filter_time_hm:'Please enter valid time(H:i)'}" value="<?php echo $to_date;?>" readonly="readonly" id="to_date">
                                        </div>
                                       
                                        
                                                     
                                <div class="width10 float_left">
                                    <input type="text"  class="controls amb_search" id="mob_no" name="call_search" value="<?php echo @$rg_no; ?>" placeholder="Search"/>
                                </div>
                         
                        

                                <div class="width25 float_left">

                                    <input type="button" class="search_button float_left  form-xhttp-request" name="" value="Search" data-href="{base_url}calls/followupero_dash" data-qr="output_position=content&amp;flt=true&amp;type=inc"  style="margin-top:0px;"/>
                                   <input type="reset" class="search_button float_left form-xhttp-request" name="" value="Reset Filter" data-href="{base_url}calls/followupero_dash" data-qr="output_position=content&amp;flt=reset&amp;type=inc"  style="margin-top:0px;"/>
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
                        <th>District Name</th>
<!--                       <th nowrap>Patient Name</th>-->
<!--                    <th nowrap>108 Ref ID</th>-->
                        <th>Caller Mobile No</th>
<!--                    <th width="18%">Incident Address</th>-->
                        
                        <th>ERO Name</th>
                        <th>Audio File</th>
                        <th>Call Duration</th>
                        <th>Call Type</th>
                        <th>Followup Reason</th>
                        <th>View</th>
                        

                    </tr>
                    <?php //print_r($inc_info); die;
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

//        if ($inc->clr_fullname != '') {
//            $caller_name = $inc->clr_fullname;
//        } else {
                            $caller_name = $inc->clr_fname . "  " . $inc->clr_mname. "  " . $inc->clr_lname;
//        }
                            ?>

                            <tr>
                                <td ><?php echo date("d-m-Y H:i:s", strtotime($inc->inc_datetime)); ?></td>
                                <td >
<!--                                    <a href="{base_url}calls/single_record_view" class="onpage_popup" data-qr="output_position=popup_div&inc_ref_id=<?php echo $inc->inc_ref_id; ?>" style="color:#000;"  data-popupwidth="1300"  data-popupheight="600" target="blank"><?php echo $inc->inc_ref_id; ?></a>-->
                                <a class="" style="margin-right:10px;" href="#" onclick="open_extend_map('{base_url}calls/single_record_view');return false;"><?php echo $inc->inc_ref_id; ?></a>
                                </td>
                                <td ><?php echo ucwords($caller_name); ?></td>
                                <td ><?php echo $inc->dst_name; ?></td>
        <!--                    <td ><?php echo ucwords($patient_name); ?></td>-->
        <!--                        <td  style="background: #FFD4A2;;"><?php echo $inc->inc_bvg_ref_number; ?></td>-->
                               <td ><a href="{base_url}calls/caller_history_number" class="onpage_popup" data-qr="output_position=popup_div&mobile_no=<?php echo $inc->clr_mobile; ?>" style="color:#000;" data-popupwidth="1300"  data-popupheight="600"><?php echo $inc->clr_mobile; ?></a></td>
        <!--                    <td ><?php echo $inc->inc_address; ?></td>-->
                                <td  nowrap><?php echo ucwords(strtolower($inc->clg_first_name." ".$inc->clg_last_name)); ?></td>

                                <td>
                                    <?php  
                                    //var_dump($inc);
    
                                        //$pic_path =  $inc->inc_audio_file;
                                    $inc_datetime = date("Y-m-d", strtotime($inc->inc_datetime));
                                    $pic_path =  get_inc_recording($inc->inc_avaya_uniqueid,$inc_datetime);
                                   //var_dump($clg_group);
                                    if($pic_path != ""){  
                                        if($clg_senior){ 
                                            $width = "width: 185px;";
                                            
                                        }else{
                                            $width = "width: 50px;";
                                        }
                                        ?>
                                    <audio controls controlsList="nodownload" style="<?php echo $width;?>">
                                        <source src="<?php echo $pic_path;?>" type="audio/wav">
                                        Your browser does not support the audio element.
                                    </audio> 
                                    <?php
                                    }

                                    ?>
                                   
                                </td>
                                <td ><?php echo ($inc->inc_dispatch_time); ?></td>
                                <td ><?php echo ucwords($inc->pname); ?></td>
                                <td ><?php 
                                if($inc->flw_reason=='Other'){
                                    echo $inc->flw_reason.'-'.$inc->flw_reason;
                                }else{
                                    echo $inc->flw_reason;
                                }
                                 ?>
                                </td>
                                 <td >
                                <a href="{base_url}calls/single_record_view" class="btn onpage_popup" data-qr="output_position=content&inc_ref_id=<?php echo $inc->inc_ref_id; ?>" data-popupwidth="1400" data-popupheight="900"> view </a>
                                <!-- <a href="{base_url}calls/single_record_view" class="btn onpage_popup" data-qr="output_position=content&inc_ref_id=<?php echo $inc->inc_ref_id; ?>" data-popupwidth="1400" data-popupheight="900"> View </a> -->
                                <?php if($inc->followup_reason == '7'){  ?>
                                    <a href="{base_url}calls/followupactionpopup" class="btn onpage_popup" data-qr="output_position=content&inc_ref_id=<?php echo $inc->inc_ref_id; ?>&followup_reason=<?php echo $inc->followup_reason; ?>" data-popupwidth="1400" data-popupheight="800"> Action </a>
                                <?php
                                }else{
                                    ?>
                                    <a href="{base_url}calls/followupactionpopup" class="btn onpage_popup" data-qr="output_position=content&inc_ref_id=<?php echo $inc->inc_ref_id; ?>&followup_reason=<?php echo $inc->followup_reason; ?>" data-popupwidth="700" data-popupheight="400"> Action </a>
                                <?php
                                } ?>
                                <!--<a href="{base_url}calls/incident_Current_Status_Deatis" class="onpage_popup" data-qr="output_position=popup_div&dispatch_status=<?php echo $disptched; ?>&inc_ref_id=<?php echo $inc->inc_ref_id; ?>" style="color:#000;" data-popupwidth="1300"  data-popupheight="600"><?php echo $disptched; ?></a>
                                --></td>
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

                    <input type="hidden" name="submit_data" value="<?php
                    if (@$data) {
                        echo $data;
                    }
                    ?>">

                    <div class="width33 float_right">

                        <div class="record_per_pg">

                            <div class="per_page_box_wrapper">

                                <span class="dropdown_pg_txt float_left"> Records per page : </span>

                                <select name="pg_rec" class="dropdown_per_page float_left change-xhttp-request" data-href="{base_url}calls/ero_dash" data-qr="output_position=content&amp;flt=true&amp;type=inc">

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
   <div class="hide">
       <?php echo $clg_senior;?>
   </div>
<?php if($clg_senior){?>
<script>
    
    jQuery(document).ready(function () {

        var dateFormat = "mm/dd/yy",
                from = jQuery("#from_date")
                .datepicker({
                    defaultDate: -1,
                    changeMonth: true,
                    numberOfMonths: 1,
                    maxDate: new Date()
                })
                .on("change", function () {
                    to.datepicker("option", "minDate", getDate(this));
                }),
                to = jQuery("#to_date").datepicker({
            defaultDate:  new Date(),
            changeMonth: true,
            numberOfMonths: 1,
            maxDate: new Date()
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
 <?php }else{ ?>

<script>
    
    jQuery(document).ready(function () {

        var dateFormat = "mm/dd/yy",
                from = jQuery("#from_date")
                .datepicker({
                    defaultDate: -1,
                    changeMonth: true,
                    numberOfMonths: 1,
                    maxDate: new Date(),
                    minDate:'-1d',
                })
                .on("change", function () {
                    to.datepicker("option", "minDate", getDate(this));
                }),
                to = jQuery("#to_date").datepicker({
            defaultDate:  new Date(),
            changeMonth: true,
            numberOfMonths: 1,
            maxDate: new Date(),
            minDate:'-1d',
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
<?php } ?>


