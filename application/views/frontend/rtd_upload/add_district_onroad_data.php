<?php
?>
<div class="register_outer_block">
    
    <div class="box3">
    <div class="breadcrumb float_left">
            <ul>
                <li>
                    <span>District Wise OnRoad Report</span>
                </li>

            </ul>
        </div>
        <form enctype="multipart/form-data"  method="post" action="" id="manage_team">   
            
            <input type="hidden" name="rto_no" id="amb_id" value="<?php echo $get_amb_details[0]->amb_rto_register_no;?>">
            
            <div class="field_row width100">
                <div class="width2 float_left">
                <div class="shift width20 float_left"><label for="sft1"><b>Select Time :</b></label></div>

                    <div class="shift width_78 float_left">
                        <select name="select_time" class="filter_required" data-errors="{filter_required:'Select Time should not blank'}" >
                      <option value="">Select Time</option>
                       <option value="1" <?php if($report_args['select_time'] == '1'){ echo "selected"; }?> > 9 AM</option>
                       <option value="2" <?php if($report_args['select_time'] == '2'){ echo "selected"; }?>> 12 PM</option>
                       <option value="3" <?php if($report_args['select_time'] == '3'){ echo "selected"; }?>> 3 PM</option>
                       <option value="4" <?php if($report_args['select_time'] == '4'){ echo "selected"; }?>> 6 PM</option>
                  </select>
                    </div>
                </div>

                <div class="width2 float_left">
                <div class="shift width20 float_left"><label for="sft2"><b>Import File :</b></label></div>

                    <div class="shift width_78 float_left">
                        <input name="file" class="filter_required" value="" type="file" tabindex="1" placeholder="Import file" data-errors="{filter_required:'Import file should not blank'}">
                    </div>
                </div>
                
            </div>
            <div class="field_row width100">
                <h3>CSV file format</h3>
                
                <table class="table report_table">

                    <tr>                
                       <th nowrap>District</th>
                        <th nowrap>Base Location</th>
                        <th nowrap>Ambulance No</th>
                        <th nowrap>Vehicle Type</th>
                        
                    </tr>
                    <tr>
                        <td>Pune</th>  
                        <td>Pune</th>
                        <td>MH 01 DD 0000</td>
                        <td>ALS/BLS</td>    
                       
                  
                    </tr>
                    
                 </table>
            </div>
            
            <div class="field_row width100">
                <div class="width40 margin_auto">
                <div class="button_field_row">
                    <div class="button_box"> 
                        <input type="hidden" name="submit_amb_team" value="sub_amb_team" />
                        <input type="button" name="submit" value="Submit" class="btn submit_btnt form-xhttp-request" data-href='<?php echo base_url();?>rtd_upload/save_district_onroad_data' data-qr='page_no=<?php echo @$page_no; ?>&amp;output_position=content' >
                        <input type="reset" name="reset" value="Reset" class="btn reset_btn register_view_reset">
                    </div>
                </div>
            </div>
            </div>
            
        </form>                
    </div>       
</div>