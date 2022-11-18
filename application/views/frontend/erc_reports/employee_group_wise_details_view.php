<style>
    .clg_search{
        margin:25px 0 0 70px !important;
    }
    .filter_required{
        margin-left:20px !important;
        width:120% !important;
    }    
    .table {
        table-layout:auto !important;
        width:170% !important;
}

.table td {
    text-align: center !important;
}
</style>
<?php $CI = EMS_Controller::get_instance(); ?>
<!-- <div class="head_outer"><h3 class="txt_clr2 width1">  <?php echo $report_name ?> </h3> </div> -->
<div class="width100">

    <form enctype="multipart/form-data" method="post">

        

            <div class="filed_select">
                <div class=" float_left">
                <div class="width100 float_left">
                    <div class="style6 float_left" style="margin-left:20px;">Select Group: </div>
                </div>
                <div class="width100 float_left">
                    <select name="department_name" class="change-base-xhttp-request filter_required" data-errors="{filter_required:'Department should not be blank!'}" data-base="report_type" data-href="{base_url}erc_reports/load_employee_report1" data-qr="output_position=user_employee_report_block_fields&employee_report_type=<?php echo $report_type;?>" data-errors="{filter_required:'Report Type should not be blank!'}">
                        <option value="">Select Group</option>
                        <!-- <option value="UG-SuperAdmin">Super Admin</option> -->
                        <option value="all">All</option>
                        <option value="UG-ERO">ERO</option>
                        <!--<option value="UG-ERO-102">ERO-102</option>-->
                        <option value="UG-DCO">DCO</option>
                        <!--<option value="UG-DCO-102">DCO-102</option>-->
                        <option value="UG-ERCP">ERCP</option>
                        <option value="UG-Pilot">Pilot</option>
                        <option value="UG-EMT">EMT</option>
                        <option value="UG-Feedback">Feedback</option>
                        <option value="UG-Grievance">Grievance</option>
                        <option value="UG-PDA">PDA</option>
                        <option value="UG-FDA">FDA</option>
                        <option value="UG-Quality">Quality</option>
                        <option value="UG-ERCHead">ERC-Head</option>
                        <option value="UG-ERCManager">ERC Manager</option>
                        <option value="UG-ShiftManager">Shiftmanager</option>
                        <option value="UG-OperationManager">Operational Manager</option>
                        <option value="UG-QualityManager">Quality Manager</option>
                        <option value="UG-FeedbackManager">Feedback Manager</option>
                        <option value="UG-GrievianceManager">Grievance Manager</option>
                        <option value="UG-FleetManagement">Fleet Desk Manager</option>
                        <option value="UG-FleetManagementHR">FleetManagement HR</option>
                        <option value="UG-SupplyChainManage">Supply Chain Manager</option>
                        <option value="UG-ZM">Zonal Manager</option>
                        <option value="UG-DM">District Manager</option>
                        <option value="UG-BioMedicalManager">Bio-Medical Manager</option>
                        <option value="UG-BioMedicalengineer">Bio-Medical Engineer</option>
                        <option value="UG-ShiftRoster">Shift-Roster</option>
                        <option value="UG-EROSupervisor">ERO Supervisor</option>
                        <option value="UG-DCOSupervisor">DCO Supervisor</option>
                        <option value="UG-PDASupervisor">PDA Supervisor</option>
                        <option value="UG-FDASupervisor">FDA Supervisor</option>
                        <option value="UG-ERCPSupervisor">ERCP Supervisor</option>
                        <option value="UG-ERCTRAINING">ERCTRAINING</option>
                        <option value="UG-DIS-FILD-MANAGER">District Field Manager</option>
                        <option value="UG-ZON-FILD-MANAGER">Zonal Field Manager</option>
                        <option value="UG-HELPDESK">Helpdesk</option>
                   
                    </select>

                </div>
            </div>
               <!-- <input type="submit" name="submit" value="Submit" TABINDEX="3">   -->
               <input type="button" name="submit"  value="Submit" data-qr="output_position=list_table&amp;reports=view&amp;module_name=reports&amp;showprocess=no" data-href="<?php echo base_url(); ?>erc_reports/<?php echo $submit_function; ?>" class="form-xhttp-request btn clg_search" >

            
    </form>
</div>

