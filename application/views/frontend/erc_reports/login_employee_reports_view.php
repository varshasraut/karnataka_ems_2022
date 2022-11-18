<?php $CI = EMS_Controller::get_instance(); ?>
<div class="head_outer"><h3 class="txt_clr2 width1">  <?php echo $report_name ?> </h3> </div>
<div class="width100">

    <form enctype="multipart/form-data" method="post">

        <div class="width_25 ">

            <div class="filed_select">
                <div class="field_row drg float_left">
                    <div class="width100 float_left">
                        <div class="style6 float_left">Select Employee Report: </div>
                    </div>
                    <div class="width100 float_left">  
                        <select name="emp_report_type"  class="change-base-xhttp-request"  data-href="{base_url}erc_reports/load_login_employee_report_form" data-qr="output_position=content">
                            <option value="">Select Report</option>
                            <option value="1">Employee Report</option>
                            <option value="2">Employee Login And Logout Report</option>
                            <option value="3">Employee Breaks Report</option>
                            <option value="4">Employee Calls Status Report </option>
                        </select>
                    </div>
                </div>
            </div>

        </div>
        <div class=" float_left">
            <div id="Sub_report_block_fields" >
            </div>
        </div>
        <div class="width_30  float_left">
            <div id="Sub_employee_report_block_fields" >
            </div>
        </div>
         <div class="width_40  float_left">
            <div id="user_employee_report_block_fields">
                
            </div>
        </div>
    </form>
</div>
<div class="box3">    

    <div class="permission_list group_list">

        <div id="list_table" >


        </div>
    </div>
</div>

<iframe name="form_frame" style="height: 1px; width: 1px; border:0px; background: none;"></iframe>