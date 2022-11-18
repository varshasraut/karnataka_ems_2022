<div class="width100">                
    <div class="text_align_center">                    
        <a href="{base_url}"> <div class="ems_logo margin_auto"></div>                    
        </a>                
    </div>                
    <div class="text_align_center">                    
        <h2 class="txt_clr2 width1 txt_pro">Remark</h2>                
    </div>               
    <div class="login_inner_box">                          
    
        <form action='#' method='post' class='break_form' id="break_function">                
                         
            <div class="field_row">

                    <div class="field_lable  "><label for="joining_date">Supervisor remark<span class="md_field">*</span></label></div>

                    <div class="filed_input  ">

                       <textarea class="form_input filter_required" name="supervisor_remark" rows="3" data-errors="{filter_required:'Supervisor remark should not be blank!'}" style="text-transform: lowercase;"><?= $medadv_info[0]->adv_cl_addinfo; ?></textarea>
                    </div>
                   
                       <input type="hidden" name="inc_ref_id" value="<?php echo $inc_ref_id;?>">


                </div>

        <div class="text_align_center button_box">                 
                            <input type="button" name="submit" value="Submit" class="btn submit_btnt form-xhttp-request" data-href='{base_url}supervisor/delete_record' data-qr='output_position=content'  TABINDEX="2" id="<?php echo @$current_data[0]->clg_ref_id; ?>">

        </div>                    
</form>                
    </div>            
</div>      

       