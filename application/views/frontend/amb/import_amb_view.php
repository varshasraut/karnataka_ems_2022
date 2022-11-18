<div class="register_outer_block">
    
    <div class="box3">
      
        <form enctype="multipart/form-data"  method="post" action="" id="manage_team">   
            <h3 class="txt_clr2 width1 txt_pro">Import Ambulance Details</h3>   
            
            
        
            
            <div class="field_row width100">

                <div class="width2 float_left">
                    <div class="shift width30 float_left"><h3>CSV File Format : </h3></div>                

                    <div class="shift width_60 float_left">
                    <a  href='<?php echo base_url();?>amb/download_sample_format'><strong style="color : blue;">Download  CSV format for Ambulance Import</strong></a>
                   
                    </div>
                </div>
                
            </div>
            <div class="field_row width100">
            <label style="color : red;font-weight:bold">Note : <label>
            <!--<label style="color : red;font-weight:bold">1. Wards ID : Only for Private ambulance  <a  href='<?php echo base_url();?>amb/download_sample_format_ward'><strong style="color : blue;">Download  CSV format for Ward ID</strong></a> <label>-->
            <label style="color : red;font-weight:bold">1. Working Area :<strong style="color : blue;"> 1.Rural 2.Urban </strong> <label>
            <label style="color : red;font-weight:bold">2. Division & district ID : <a  href='<?php echo base_url();?>amb/download_sample_format_div_dis'><strong style="color : blue;">Download  CSV format for division ID & district ID</strong></a>   <label>
            <label style="color : red;font-weight:bold">3. Ambulance Type: <a  href='<?php echo base_url();?>amb/download_sample_format_amb_type'><strong style="color : blue;">Download  CSV format for Ambulance Type</strong></a>   <label>
            <label style="color : red;font-weight:bold">4. Third Party : <strong style="color : blue;"> 1.JAES</strong><label>
            <label style="color : red;font-weight:bold">5. Base Location :  <a  href='<?php echo base_url();?>amb/download_sample_format_baseloc'><strong style="color : blue;">Download  CSV format for Base Location</strong></a> <label>
            <label style="color : red;font-weight:bold">6. Dont enter Same ambulance name it will no not import <label>
            <label style="color : red;font-weight:bold">7. Please fill up all fields, all are mandatory <label>
            </div>
            <div class="field_row width100">

                <div class="width2 float_left">
                    <div class="shift width20 float_left"><label for="sft2">Import file</label></div>                

                    <div class="shift width_78 float_left">
                        <input name="file" class="filter_required" value="" type="file" tabindex="1" placeholder="Import file" data-errors="{filter_required:'Import file should not blank'}">
                    </div>
                </div>
                
            </div>
            
            <div class="field_row width100">
                <div class="width30 margin_auto">
                <div class="button_field_row">
                    <div class="button_box"> 
                        <input type="button" name="submit" value="Submit" class="btn submit_btnt form-xhttp-request" data-href='<?php echo base_url();?>amb/save_import_amb' data-qr='page_no=<?php echo @$page_no; ?>&amp;output_position=content' >
                        <input type="reset" name="reset" value="Reset" class="btn reset_btn register_view_reset">
                    </div>
                </div>
            </div>
            </div>
            
        </form>                
    </div>       
</div>



<!--
<div class="register_outer_block">
    
    <div class="box3">
      
        <form enctype="multipart/form-data"  method="post" action="" id="manage_team">   
            <h1>Import Ambulance</h1>   
            
            
        
            
            <div class="field_row width100">

                <div class="width2 float_left">
                    <div class="shift width20 float_left"><label for="sft2">Import file</label></div>                

                    <div class="shift width_78 float_left">
                        <input name="file" class="filter_required" value="" type="file" tabindex="1" placeholder="Import file" data-errors="{filter_required:'Import file should not blank'}">
                    </div>
                </div>
                
            </div>
            <div class="field_row width100">
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
            </div>
            
            <div class="field_row width100">
                <div class="width30 margin_auto">
                <div class="button_field_row">
                    <div class="button_box"> 
                        <input type="hidden" name="submit_amb_team" value="sub_amb_team" />
                        <input type="button" name="submit" value="Submit" class="btn submit_btnt form-xhttp-request" data-href='<?php echo base_url();?>amb/save_import_amb' data-qr='page_no=<?php echo @$page_no; ?>&amp;output_position=content' >
                        <input type="reset" name="reset" value="Reset" class="btn reset_btn register_view_reset">
                    </div>
                </div>
            </div>
            </div>
            
        </form>                
    </div>       
</div>-->