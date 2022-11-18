<?php $CI = EMS_Controller::get_instance(); ?>

<div class="width100">

    <form enctype="multipart/form-data"  action="<?php echo base_url(); ?>erc_reports/<?php echo $submit_function; ?>" method="post">


        <div class="filed_select">
            <div class="field_row drg float_left">
                <div class="width100 float_left">
                    <div class="style6 float_left">Select  </div>
                </div>
                <div class="width100 float_left">  
                    <select name="log_emp_report_type" class="change-base-xhttp-request filter_required" data-base="report_type" data-href="{base_url}erc_reports/load_employee_login_logout_report" data-qr="output_position=content" data-errors="{filter_required:'Report Type should not be blank!'}">
                        <option value="">Select Report</option>
                        <option value="1">Department </option>
                        <option value="2">Single Date Selection</option>
                    </select>
                </div>
            </div>
        </div>




    </form>
</div>

