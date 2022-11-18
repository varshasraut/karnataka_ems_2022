<?php
//$CI = EMS_Controller::get_instance();
//$title =  "Import Employee Schedule ";
?>

<div class="register_outer_block">
    
    <div class="box3">
      
        <form enctype="multipart/form-data"  method="post" action="" id="manage_team">   
            <h1>Import Schedule</h1>  
            
            <!-- <input type="text" name="schedule_month" class="form_input " value="" /> -->
            <!-- <input type="text" name="schedule_year" class="form_input" value="" /> -->
            <!-- <select id=""  name="schedule_type" class="select_users_listing">
                <option value="" >Select Schedule Type</option>
                <option value="" ></option>
                <option value="" >Weekly</option>
                <option value="" >Monthly</option>
            </select> -->
            <div class="field_row width100">
            <div class="width2 float_left"> 
                <select id=""  name="schedule_month" class="select_users_listing">
                    <option value="" >Select Schedule Month</option>
                    <option value="01" >January</option>
                    <option value="02" >February</option>
                    <option value="03" >March</option>
                    <option value="04" >April</option>
                    <option value="05" >May</option>
                    <option value="06" >June</option>
                    <option value="07" >July</option>
                    <option value="08" >August</option>
                    <option value="09" >September</option>
                    <option value="10" >October</option>
                    <option value="11" >November</option>
                    <option value="12" >December</option>
                </select> 
            </div>
            <div class="width2 float_left">
                <select id=""  name="schedule_year" class="select_users_listing">
                    <option value="" >Select Schedule Year</option>
                    <option value="2019" >2019</option>
                    <option value="2020" >2020</option>
                    <option value="2021" >2021</option>
                    <option value="2022" >2022</option>
                    <option value="2023" >2023</option>
                    <option value="2024" >2024</option>
                    <option value="2025" >2025</option>
                    <option value="2026" >2026</option>
                    <option value="2027" >2027</option>
                    <option value="2028" >2028</option>
                    <option value="2029" >2029</option>
                    <option value="2030" >2030</option>
                </select> 
            </div>
            </div>
            <div class="field_row width100">

                <div class="width2 float_left">
                    <div class="shift width20 float_left"><label for="sft2">Import file<span class="md_field">*</span></label></div>                

                    <div class="shift width_78 float_left">
                        <input name="file" class="filter_required" value="" type="file" tabindex="1" placeholder="Import file" data-errors="{filter_required:'Import file should not blank'}">
                    </div>
                </div>
                
            </div>
            
 <!--            <div class="field_row width100">
                <h3>CSV file format</h3>
                 <table class="table report_table">

                    <tr>                
                        <th>Ambulance no</th>
                        <th>Default mobile</th>
                        <th>Pilot mobile</th>
                        <th>Ambulance sr. no</th>
                        <th>Ambulance working Area</th>
                        <th>Google Address</th> 
                        <th>State</th> 
                        <th>District</th>
                        <th>City</th>
                        <th>lat</th>
                        <th>lng</th>
                        <th>Ambulance Type</th>
                        <th>Ambulance Status</th>
                        <th>Base Location</th>
                        <th>Deleted</th>
                        <th>User type</th>
                    </tr>
                    <tr>
                        <td>MH 14 CL 0767</td>                            
                        <td>8669987574</td> 
                        <td>8669987574</td> 
                        <td>1</td> 
                        <td>1</td> 
                        <td>MH</td> 
                        <td>1</td> 
                        <td>518</td>
                        <td>518</td>
                        <td>21.551198</td>
                        <td>76.89411</td>
                        <td>1</td>
                        <td>1</td>
                        <td>1</td>
                        <td>0</td> 
                        <td>bike</td> 
                    </tr>
                    
                 </table>
                <span> <strong>Ambulance status:-</strong>
                    1 =>Available,
2 =>Busy,
3 =>Stand By,
4 =>Change Location,
5 =>Deleted/Inactive,
6 =>In Maintenance On Road,
7 =>In Maintenance-OFF Road,
8 =>Stand by Oxygen Filling,
9 =>Stand by Fuel Filling,
10 =>Stand by Demo Traning</span>
            </div>-->
            
            <div class="field_row width100">
                <div class="width30 margin_auto">
                <div class="button_field_row">
                    <div class="button_box"> 
                        <input type="hidden" name="submit_amb_team" value="sub_amb_team" />
                        <input type="button" name="submit" value="Submit" class="btn submit_btnt form-xhttp-request" data-href='<?php echo base_url();?>schedule_crud/save_import_crud' data-qr='page_no=<?php echo @$page_no; ?>&amp;output_position=content' >
                        <input type="reset" name="reset" value="Reset" class="btn reset_btn register_view_reset">
                    </div>
                </div>
            </div>
            </div>
            
        </form>                 
    </div>       
</div>