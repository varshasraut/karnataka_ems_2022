<?php
?>
<div class="register_outer_block">
    
    <div class="box3">
      
        <form enctype="multipart/form-data"  method="post" action="" id="manage_team">   
            <h3 class="txt_clr2 width1 txt_pro">Import Hospital Details</h3>   
            
            
        
            
            <div class="field_row width100">

                <div class="width2 float_left">
                    <div class="shift width30 float_left"><h3>CSV File Format : </h3></div>                

                    <div class="shift width_48 float_left">
                    <a id="MH" href='<?php echo base_url();?>hp/download_sample_format'><strong style="color : blue;">Download  CSV format for Import</strong></a>
                   
                    </div>
                </div>
                
            </div>
            <div class="field_row width100">
             <label style="color : red;font-weight:bold">Note : Before uploading,Please make sure all counts are validate otherwise it will affect on dashboard & other functionality<label>
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
                        <input type="button" name="submit" value="Submit" class="btn submit_btnt form-xhttp-request" data-href='<?php echo base_url();?>hp/save_hospital_details' data-qr='page_no=<?php echo @$page_no; ?>&amp;output_position=content' >
                        <input type="reset" name="reset" value="Reset" class="btn reset_btn register_view_reset">
                    </div>
                </div>
            </div>
            </div>
            
        </form>                
    </div>       
</div>