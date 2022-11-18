
<div class="call_purpose_form_outer">
            
    <h3>UNRECOGNIZED CALL</h3>
            
    <form method="post" name="unrecog_form" id="unrecog_form">
                
        <input type="hidden" name="call_id" id="call_id" value="<?php echo $call_id;?>">
            
        <input type="hidden" name="base_month" id="cl_base_month" value="<?php echo $cl_base_month;?>">

        <div class="width100">

            <div class="style6">Type of Call<span class="md_field">*</span></div>                    
                    
            <div class="filed_select width50">
                <select name="cl_type" class="filter_required" data-errors="{filter_required:'Please select type of call for dropdown list'}" <?php echo $view;?> TABINDEX="7">

                    <option value="">Type Of Call</option>
                    <?php echo get_type_of_call();?>
                </select>    
            </div>                             
        </div>
            
        <div class="width100 display_inlne_block pos_rel">
            
            <div class="width2 float_left">

                <div class="form_field">

                    <div class="label">ERO Notes<span class="md_field">*</span></div>

                    <div class="input">
                        
                        <textarea tabindex="8" class="text_area width100 filter_required" name="ero_notes" rows="5" cols="30" data-errors="{filter_required:'ERO notes should not be blank!'}" TABINDEX="8"></textarea>
                        
                    </div>
                </div> 
            </div>            
            
           <div id="fwdcmp_btn"><input name="search_btn" value="FORWARD TO SUPERVISER" class="style4 form-xhttp-request" data-href="{base_url}unrecog/confirm_save" data-qr="output_position=content" type="button" TABINDEX="9"></div>
                
        </div>   
    </form>
</div>