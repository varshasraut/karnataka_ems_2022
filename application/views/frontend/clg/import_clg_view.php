<div class="register_outer_block">
    
    <div class="box3">
      
        <form enctype="multipart/form-data"  method="post" action="" id="manage_team">   
            <h3 class="txt_clr2 width1 txt_pro">Import New Employee Details</h3>   
            
            <div class="field_row width100">

                <div class="width2 float_left">
                    <div class="shift width30 float_left"><h3>CSV File Format : </h3></div>                

                    <div class="shift width_60 float_left">
                    <a  href='<?php echo base_url();?>clg/download_sample_format'><strong style="color : blue;">Download  CSV format for Employee Details Import</strong></a>
                   
                    </div>
                </div>
                
            </div>
            <div class="field_row width100">
            <label style="font-weight:bold">Note : <label>
            <label style=";font-weight:bold">1. Division & district ID : <a  href='<?php echo base_url();?>amb/download_sample_format_div_dis'><strong style="color : blue;">Download  CSV format for division ID & district ID</strong></a><label>
            <label style="font-weight:bold">2.Employee Group: <a  href='<?php echo base_url();?>clg/download_sample_format_clg_grp'><strong style="color : blue;">Download  CSV format for Employee Group</strong></a><label>
            <label style="font-weight:bold">3. Employee Category : <strong style="color : blue;"> 1.Govt 2.JAES </strong><label>
            <label style="font-weight:bold">4. Please do not enter duplicate User ID, JAESEMP ID and Moble Number, the sheet will not be uploaded.<label>
            <label style="font-weight:bold">5. Date format should be DD-MM-YYYY (Eg:23-Sep-2022).<label>
            <label style="font-weight:bold">6. User ID, Employee ID, Group, First Name, Last Name, Mobile Number, District should not be blank.<label>
            <label style="font-weight:bold">7. Mobile Number should be atleast 10 digits and Employee ID sholud be atleast 5 digits long.<label>
            </div>
            <div class="field_row width100">

                <div class="width2 float_left">
                    <div class="shift width20 float_left"><label for="sft2">Import file</label></div>                

                    <div class="shift width_78 float_left">
                        <input name="file" class="filter_required" value="" type="file" tabindex="1" placeholder="Import file" data-errors="{filter_required:'Import file should not blank'}" accept=".csv">
                    </div>
                </div>
                
            </div>
            
            <div class="field_row width100">
                <div class="width30 margin_auto">
                <div class="button_field_row">
                    <div class="button_box"> 
                        <input type="button" name="submit" value="Submit" class="btn submit_btnt form-xhttp-request" data-href='<?php echo base_url();?>clg/save_import_clg' data-qr='page_no=<?php echo @$page_no; ?>&amp;output_position=content' >
                        <input type="reset" name="reset" value="Reset" class="btn reset_btn register_view_reset click-xhttp-request" data-href="{base_url}clg/import_clg" data-qr="output_position=content&amp;filters=reset">
                    </div>
                </div>
            </div>
            </div>
            <div id="last_record"></div>
            <div id="duplicate_emp_id"></div>
        </form>                
    </div>       
</div>
