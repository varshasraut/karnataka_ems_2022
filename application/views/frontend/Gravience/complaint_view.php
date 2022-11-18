
<?php
if (@$view_clg == 'view') {
    $view = 'disabled';
}
?>

<form enctype="multipart/form-data" action="#" method="post" id="add_colleague_registration_form">
    <div class="width1">
        <h2 class="txt_clr2 width1 txt_pro">
            <?php
            if ($action_type) {
                echo $action_type;
            }
            ?>
        </h2>

        <?php // var_dump($grievance_data);  ?>
        <div class="field_row width100  fleet" ><div class="single_record_back">Curent Information</div></div>
        <div class="field_row width100">
            <div class="width33 float_left">
                <div class="filed_lable float_left width33 strong"><label for="station_name">Complaint Date & Time </label></div>

              
                    
                      <div class="filed_input float_left width50">
                    <input name="gri[gc_date_time]" tabindex="20" class="form_input mi_timecalender filter_required" placeholder="Start Date / Time" type="text"  data-errors="{filter_required:'Start Date / Time should not be blank!'}" value="<?= @$grievance_data[0]->gc_date_time; ?>"   <?php echo $update; ?>>
                </div>
               
                </div>


            </div>
            <div class="width33 float_left">
                <div class="filed_lable float_left width33 strong"><label for="station_name">Complaint Register By</label></div>

                <div class="filed_input float_left width50">
                    <?= @$grievance_data[0]->gc_inc_ref_id; ?>
                </div>


            </div>
            <div class="width33 float_left">
                <div class="filed_lable float_left width33 strong"><label for="station_name">Caller Number</label></div>

                <div class="filed_input float_left width50">
                    <?= @$grievance_data[0]->gc_caller_number ?>
                </div>


            </div>

            <div class="width33 float_left">
                <div class="filed_lable float_left width33 strong"><label for="station_name">Caller Name</label></div>

                <div class="filed_input float_left width50">
                    <?= @$grievance_data[0]->gc_caller_name ?>
                </div>


            </div>
        </div>
        <div class="field_row width100">
            <div class="width33 float_left">
                <div class="filed_lable float_left width33 strong"><label for="station_name">District</label></div>

                <div class="filed_input float_left width50">
                    <?= @$grievance_data[0]->dst_name ?>
                </div>


            </div>
            <div class="width33 float_left">
                <div class="filed_lable float_left width33 strong"><label for="station_name">Ambulance Number</label><span class="md_field">*</span></div>

                <div class="filed_input float_left width50">
                    <?= @$grievance_data[0]->gc_ambulance_no ?>
                </div>


            </div>

            <div class="width33 float_left">
                <div class="filed_lable float_left width33 strong"><label for="station_name">Incident Number</label></div>

                <div class="filed_input float_left width50">
                    <?= @$grievance_data[0]->gc_pre_inc_ref_id ?>

                </div>


            </div>
        </div>
        <div class="field_row width100">
            <div class="width33 float_left">
                <div class="filed_lable float_left width33 strong"><label for="station_name">Patient Name</label></div>

                <div class="filed_input float_left width50">
                    <?= @$grievance_data[0]->gc_ptn_name ?>


                </div>


            </div>
            <div class="width33 float_left">   
                <div class=" blue float_left width33 strong">Chief Complaint</div>
                <div class="input  top_left float_left width50" >
                    <?= @$grievance_data[0]->ct_type; ?>
                </div>
            </div>

            <div class="width33 float_left">
                <div class="filed_lable float_left width33 strong"><label for="station_name">Grievance Type</label></div>

                <div class="filed_input float_left width50">
                    <?= @$grievance_data[0]->grievance_type; ?>
                </div>


            </div>
        </div>
        <div class="field_row width100">
            <div class="width33 float_left">
                <div class="filed_lable float_left width33 strong"><label for="station_name">Grievance Sub-Type</label></div>

                <div class="filed_input float_left width50">
                    <?= @$grievance_data[0]->grievance_sub_type; ?>

                </div>


            </div>
            <div class="width33 float_left">
                <div class="filed_lable float_left width33 strong"><label for="station_name">Grievance Details</label></div>

                <div class="filed_input float_left width50">
                    <?= @$grievance_data[0]->gc_grievance_details; ?>
                </div>


            </div>

            <div class="width33 float_left">
                <div class="filed_lable float_left width33 strong"><label for="station_name">EMT Name</label></div>

                <div class="filed_input float_left width50">
                    <?= @$grievance_data[0]->gc_emso_name; ?>
                </div>


            </div>
        </div>

        <div class="field_row width100">
            <div class="width33 float_left">
                <div class="filed_lable float_left width33 strong"><label for="station_name">Pilot Name</label></div>

                <div class="filed_input float_left width50">
                    <?= @$grievance_data[0]->gc_pilot_name; ?>


                </div>


            </div>
            <div class="width33 float_left">
                <div class="filed_lable float_left width33 strong"><label for="station_name">Complaint Register By</label></div>

                <div class="filed_input float_left width50">
                    <?= @$grievance_data[0]->gc_complaint_register_by; ?>
                </div>


            </div>
        </div>
        <?php if(@$grievance_data[0]->is_closed == '1'){ ?>
        <div class="field_row width100  fleet" ><div class="single_record_back">Current Info</div></div>
        <div class="field_row width100">
            <div class="width33 float_left">
                <div class="filed_lable float_left width33 strong"><label for="station_name">Action Taken</label></div>

                <div class="filed_input float_left width50">
                    <?= @$grievance_data[0]->gc_action_taken; ?>
                </div>


            </div>

            <div class="width33 float_left">
                <div class="filed_lable float_left width33 strong"><label for="station_name">Reply From</label></div>

                <div class="filed_input float_left width50">
                    <?php
                    if ($grievance_data[0]->gc_reply_from == 'ADM') {
                        echo "ADM";
                    } elseif ($grievance_data[0]->gc_reply_from == 'ZM') {
                        echo "ZM";
                    } elseif ($grievance_data[0]->gc_reply_from == 'DM') {
                        echo "DM";
                    } elseif ($grievance_data[0]->gc_reply_from == 'Supervisor') {
                        echo "Supervisor";
                    }
                    ?>

                </div>


            </div>
            <div class="width33 float_left">
                <div class="filed_lable float_left width33 strong"><label for="station_name">Close By</label></div>

                <div class="filed_input float_left width50">
                    <?php
                    if ($grievance_data[0]->gc_close_by == 'ADM') {
                        echo "ADM";
                    } elseif ($grievance_data[0]->gc_close_by == 'ZM') {
                        echo "ZM";
                    } elseif ($grievance_data[0]->gc_close_by == 'DM') {
                        echo "DM";
                    } elseif ($grievance_data[0]->gc_close_by == 'Supervisor') {
                        echo "Supervisor";
                    }
                    ?>

                </div>
            </div>
        </div>

        <div class="field_row width100">
            <div class="width33 float_left">
                <div class="filed_lable float_left width33 strong"><label for="station_name">Time Required To Resolve</label></div>

                <div class="filed_input float_left width50">
                    <?= $grievance_data[0]->gc_time_required ?>
                </div>
            </div>
            <div class="width33 float_left">
                <div class="field_lable float_left width33 strong"> <label for="date_time">Grievance Remark</label></div>
                <div class="filed_input float_left width50">
                    <?php
                    if ($grievance_data[0]->gc_standard_remark == 'complaint_close_sucessfully') {
                        echo "Complaint Close Sucessfully";
                    }
                    ?>

                </div>
            </div>
            <div class="width33 float_left">
                <div class="field_lable float_left width33 strong"> <label for="date_time">Closure Status</label></div>
                <div class="filed_input float_left width50">
                    <?php
                    if ($grievance_data[0]->gc_closure_status == 'complaint_open') {
                        echo "Complaint Open";
                    } elseif ($grievance_data[0]->gc_closure_status == 'complaint_close') {
                        echo "Complaint Close";
                    }
                    ?> 

                </div>
            </div>

        </div>
        <div class="field_row width100">

            <div class="width33 float_left">
                <div class="field_lable float_left width33 strong"> <label for="date_time">Close by</label></div>
                <div class="filed_input float_left width50">
                    <?php echo $grievance_data[0]->gc_emp_close_by; ?>
                </div>

            </div>
            <div class="width33 float_left">
                <div class="field_lable float_left width33 strong"> <label for="mobile_no">Remainder Mail</label></div>

                <div class="filed_input width2 float_left">

                    <?php
                    if ($grievance_data[0]->gc_reminder_mail == 'yes') {
                        echo "Yes";
                    } else {
                        echo "No";
                    }
                    ?>

                </div>
            </div>
            <div class="width33 float_left">
                <div class="field_lable float_left width33 strong"> <label for="mobile_no">Remainder Call</label></div>

                <div class="filed_input width2 float_left">

                    <?php
                    if ($grievance_data[0]->gc_reminder_call == 'yes') {
                        echo "Yes";
                    } else {
                        echo "No";
                    }
                    ?>

                </div>
            </div>
        </div>
        <div class="width100">
            <div class=" float_left">
                <div class="filed_lable float_left width33 strong"><label for="station_name">Caller satisfaction for closure remark</label></div>

                <div class="filed_input float_left width50">
                    <?= $grievance_data[0]->gc_caller_closure_remark ?>
                </div>
            </div>
        </div>

    </div>
        <?php } ?> 
</form>