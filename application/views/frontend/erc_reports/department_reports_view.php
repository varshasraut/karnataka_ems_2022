
<div class="width100">
<form enctype="multipart/form-data"  action="<?php echo base_url(); ?>erc_reports/<?php echo $submit_function; ?>" method="post">

    <div class="field_row">

         <div class="field_row float_left width50">

            <div class="filed_select">
                <div class="width100 drg float_left">
                    <div class="width100 float_left">
                        <div class="style6 float_left">Select Date: </div>
                    </div>
                    <div class="width100 float_left" >
                        <input name="single_date" tabindex="20" class="form_input mi_calender filter_required" placeholder="Date" type="text"  data-errors="{filter_required:'Date should not be blank!'}" >
                    </div>
                </div>
            </div>

        </div>
        <div class="filed_select">
            <div class=" float_left">
                <div class="width100 float_left">
                    <div class="style6 float_left">Select Department: </div>
                </div>
                <div class="width100 float_left">
                    <select name="department_name" class="change-base-xhttp-request filter_required" data-errors="{filter_required:'Department should not be blank!'}" data-base="report_type" data-href="{base_url}erc_reports/load_employee_wise_report_form" data-qr="output_position=user_employee_report_block_fields&employee_report_type=<?php echo $report_type;?>" data-errors="{filter_required:'Report Type should not be blank!'}">
                        <option value="">Select Department</option>
                        <option value="UG-ERO">ERO</option>
                        <!--<option value="UG-BIKE-ERO">Bike ERO</option>-->
                        <!--<option value="UG-ERO-102">ERO-102</option>-->
                        <option value="UG-DCO">DCO</option>
                        <!--<option value="UG-DCO-102">DCO-102</option>-->
                        <option value="UG-ERCP">ERCP</option>
                        <option value="UG-Feedback">Feedback</option>
                        <option value="UG-Grievance">Grievance</option>
                        <option value="UG-PDA">PDA</option>
                        <option value="UG-FDA">FDA</option>
                        <option value="UG-Quality">Quality</option>
                        <option value="UG-OperationManager">Operational Manager</option>
                        <option value="UG-EROSupervisor">ERO Supervisor</option>
                        <option value="UG-DCOSupervisor">DCO Supervisor</option>
                        <option value="UG-PDASupervisor">PDA Supervisor</option>
                        <option value="UG-FDASupervisor">FDA Supervisor</option>
                        <option value="UG-ERCPSupervisor">ERCP Supervisor</option>
                         <option value="UG-ERCPSupervisor">ERCP Supervisor</option>
                         <option value="UG-REMOTE">Remote</option>
                        <option value="UG-ShiftManager">Shiftmanager</option>
                         <option value="UG-ERCTRAINING">ERCTRAINING</option>
                   
                    </select>
                </div>
            </div>

        </div>


    </div>
<!--     <div class="width_25 float_left" style="margin-top: 10px;">
        <div class="button_field_row">
            <div class="button_box">

                     <input type="submit" name="submit" value="Submit" TABINDEX="3">   
                <input type="button" name="submit"  value="Submit" data-qr="output_position=list_table&amp;reports=view&amp;module_name=reports&amp;showprocess=no" data-href="<?php echo base_url(); ?>erc_reports/<?php echo $submit_function; ?>" class="form-xhttp-request btn clg_search" >
            </div>
        </div>
    </div>-->
</form>
</div> 
<!--<iframe name="form_frame" style="height: 1px; width: 1px; border:0px; background: none;"></iframe>-->