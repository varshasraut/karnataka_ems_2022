<?php
?>
<div class="register_outer_block">
    
    <div class="box3">
      
        <form enctype="multipart/form-data"  method="post" action="" id="manage_team">   
            <h1>Corona Call Upload</h1>   
            
            <input type="hidden" name="rto_no" id="amb_id" value="<?php echo $get_amb_details[0]->amb_rto_register_no;?>">
            
            <div class="field_row width100">
<!--                <div class="width2 float_left">
                    <div class="shift width_30 float_left "><label for="sft2">Select Date</label></div>                

                    <div class="shift width70 float_left">
                        <input name="rtd_date" class="filter_required mi_cur_date"  value="" type="text" tabindex="1" placeholder="Select Date" data-errors="{filter_required:'Register Number should not blank'}">
                    </div>
                </div>-->

                <div class="width2 float_left">
                    <div class="shift width20 float_left"><label for="sft2">Import file</label></div>                

                    <div class="shift width_78 float_left">
                        <input name="file" class="filter_required" value="" type="file" tabindex="1" placeholder="Import file" data-errors="{filter_required:'Import file should not blank'}">
                    </div>
                </div>
                
            </div>
<!--            <div class="field_row width100">
                <h3>CSV file format</h3>
                
                <table class="table">

                    <tr>                
                        <th nowrap>Incident ID</th>
                        <th nowrap>District</th>
                        <th nowrap>Ambulance No</th>
                        <th nowrap>Date</th>
                        <th nowrap>Type of Emeregency</th>
                        <th>Assign Time</th>
<th>Ambulance Start from Base</th>
                        <th>Ambulance Reach at Scene</th> 
                        <th>Area</th>
                        <th>Remarks</th> 
                    </tr>
                    <tr>
                        <td>202007300001</td> 
                        <td>Anantnag</th>  
                        <td>MH 09 DD 1111</th>
                        <td>2020-07-30</td>
                        <td>Emergency Call</td>    
<td>2020-07-30 12:25:09</td>
                        <td>2020-07-30 12:25:09</td> 
                        <td>2020-07-30 12:25:09</td> 
                        <td>Urban</th> 
                        <td>Test remark</td> 
                    </tr>
                    
                 </table>
            </div>-->
            
            <div class="field_row width100">
                <div class="width40 margin_auto">
                <div class="button_field_row">
                    <div class="button_box save_btn_wrapper"> 
                        <input type="hidden" name="submit_amb_team" value="sub_amb_team" />
                        <input type="button" name="submit" value="Submit" class="btn submit_btnt form-xhttp-request accept_btn" data-href='<?php echo base_url();?>corona/save_upload_corona_calls' data-qr='page_no=<?php echo @$page_no; ?>&amp;output_position=content' >
                        <input type="reset" name="reset" value="Reset" class="btn reset_btn register_view_reset">
                    </div>
                </div>
            </div>
            </div>
            
        </form>                
    </div>       
</div>