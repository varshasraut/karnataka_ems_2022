<?php // var_dump($grievance_info); ?>
<?php if ($grievance_info) { ?>

    <div class="width100 single_record">

        <div id="list_table">

            <table class="table report_table">


                <tr class="single_record_back">                                     
                    <td colspan="6">Grievance Information</td>
                </tr>
                <tr>
                    <td class="width_16 strong">Complaint Register No</td>
                    <td class="width_16"><?php echo $grievance_info[0]->gc_inc_ref_id; ?></td>
                    <td class="width_16 strong">Complaint Date Time</td>
                    <td><?php echo $grievance_info[0]->gc_date_time; ?></td> 
                    <td class="width_16 strong">Complaint Type</td>
                    <td><?php echo ucwords($grievance_info[0]->gc_complaint_type); ?></td> 

                </tr>
                <tr>
                 
                    <td class="width_16 strong">Grievance Type</td>
                    <td><?php echo $grievance_info[0]->grievance_type; ?></td>
                    <td class="width_16 strong">Grievance Sub-Type </td>
                    <td><?php echo $grievance_info[0]->grievance_sub_type; ?></td>
                     <td class="width_16 strong">Grievance Details</td>
                    <td><?php echo $grievance_info[0]->gc_grievance_details; ?></td>

                </tr>
                <tr>
                   
                    <td class="width_16 strong">Incident Id</td>
                    <td><?php echo $grievance_info[0]->gc_pre_inc_ref_id; ?></td>
                   
                </tr>

                <tr class="single_record_back">                                     
                    <td colspan="6">Caller Details</td>
                </tr>
                <tr>
                    <td class="width_16 strong">Caller No</td>
                    <td><?php echo $grievance_info[0]->gc_caller_number; ?></td>
                    <td class="width_16 strong">Caller Name</td>
                    <td colspan="3"><?php echo $grievance_info[0]->gc_caller_name; ?> </td>

                </tr>
                <tr class="single_record_back">                                     
                    <td colspan="6">Previous Calls</td>
                </tr>
                <?php
                if (!empty($cl_dtl)) {
                    $CALL = 1;

                    foreach ($cl_dtl as $cll_dtl) {
                        ?><tr>

                            <td colspan="7"><a class=" expand_button expand_btn gri_view"  data-target="<?php echo "cl" . $cll_dtl->gc_id; ?>"><span class="strong"><?php echo "CALL " . $CALL++; ?> : <?php ?></span></a>
                            </td>
                        </tr>
                        <tr id="<?php echo "cl" . $cll_dtl->gc_id; ?>"  style="width:100%; position: relative; display:none;padding-left:20px;" class="expand_pan">

                            <td  class="no_before" colspan="7">
                                <!--<ul class="dtl_block">-->

                                <div class="dtl_block">
                                    <div class="width1">
                                        <ul>
                                            <li class="float_left width_16 strong">Reply from</li>
                                            <li class="float_left width_16"> <?php if( $cll_dtl->gc_reply_from != '') { echo $cll_dtl->gc_reply_from; }else { echo '-'; } ?> </li>
                                            <li class="float_left width_16 strong">Employee Name</li>
                                            <li class="float_left width_16"><?php if($cll_dtl->gc_emp_close_by != '' ){echo $cll_dtl->gc_emp_close_by;}else{ echo '-';} ?></li>
                                            <li class="float_left width_16 strong">Closure status</li>
                                            <li class="float_left width_16"><?php
                                                if ($cll_dtl->gc_closure_status == 'complaint_close') {
                                                    echo "Complaint Close";
                                                } else if ($cll_dtl->gc_closure_status == 'complaint_open') {
                                                    echo "Complaint Open";
                                                } else {
                                                    echo "Complaint Pending";
                                                }
                                                ?></li>

                                            <li class="float_left width_16 strong">Grievance Remark</li>
                                            <li class="float_left width_16"> <?php
                                                if ($cll_dtl->gc_standard_remark == 'complaint_close_sucessfully') {
                                                    echo "Complaint Close Sucessfully";
                                                }else{
                                                    echo '-';
                                                }
                                                ?> </li>
                                            <li class="float_left width_16 strong">Action Taken</li>
                                            <li class="float_left width_16"><?php if($cll_dtl->gc_action_taken != ''){ echo $cll_dtl->gc_action_taken; }else{
                                                 echo '-';
                                            } ?></li>
                                            <li class="float_left width_16 strong">Caller satisfaction for closure remark</li>
                                            <li class="float_left width_16"><?php 
                                            if($cll_dtl->gc_caller_closure_remark != ''){
                                                
                                            echo $cll_dtl->gc_caller_closure_remark;
                                                
                                            }else{
                                                echo '-';
                                            }
                                    ?></li>


                                        </ul></div>

                                </div>

                            </td>
                        </tr>
            <?php
        }
    }
    ?>


            </table>
        </div>

    </div>
<?php } else { ?>
    <div class="width100">
        <div class="width100 strong"> No Record Founds </div>
    </div>
    <?php
}
?>