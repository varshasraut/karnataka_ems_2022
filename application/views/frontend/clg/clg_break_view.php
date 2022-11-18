<style>
    .hheadbg{
        background-color : #2F419B !important;
    }
    .hheadbg1{
        background-color : #2F419B !important;
    }
    .hheadbg1:hover{
        background-color : #8786fb !important;
    }
    #colorbox{
        height: 250px !important;
    }
</style>

<div class="width100">                
    <div class="text_align_center">                    
        <a href="{base_url}"> <div class="ems_logo margin_auto"></div>                    
        </a>                
    </div>                
    <div class="text_align_center">                    
        <h2 class="txt_clr2 width1 txt_pro hheadbg">Break</h2>                
    </div>               
    <div class="login_inner_box">                    <!--<h2></h2>-->                    
        <?php echo @$message; ?>
        <form action='#' method='post' class='break_form' id="break_function">                
                            <div class="form_field mt-2">                        
                                <select name="break_type" data-setfocus="true"  class="width100 filter_required" data-errors="{filter_required:'Please select break'}"  TABINDEX="1" id="break_list">                                    
                                    <option value="">Select Break</option>                            
                                    <?php foreach ($break_type as $break_name):
                                        
                                        $total_time = gmdate("H:i:s", $break_name->break_total_time);
                                        $total_time_minutes = gmdate("i", $break_name->break_total_time);
                                     if($break_name->break_time <= $total_time_minutes){
                                         //$disabled = "disabled";
                                         $note = "This break time is over";
                                         
                                         
                                     }else{
                                          $disabled = "";
                                          $note = "";
                                     }
                                        ?>   
                                    <option value="<?php echo $break_name->break_id; ?>" <?php echo $disabled;?>><?php echo $break_name->break_name; ?> / Break time <?php echo $total_time;?><?php echo $note;?></option>                           
                                    <?php endforeach; ?>                        
                                </select>                    
                            </div>   
                            <div class="form_field" id="other_break_textbox">  
                            </div>
            

        <div class="text_align_center button_box save_btn_wrapper">                 
                            <input type="button" name="submit" value="Submit" class="btn hheadbg1 hheadbg submit_btnt accept_btn form-xhttp-request inc_confirm_button" data-href='<?php echo base_url();?>clg/save_break' data-qr='output_position=content'  TABINDEX="2" id="<?php echo @$current_data[0]->clg_ref_id; ?>" >
<!--            <a href="#" id="lock_screen_btn" class="lnk_icon_btns click-xhttp-request break_lnk" data-qr="">Break</a>
            <input type="button" name="login[btn_submit]" value="Login" class="validate-form style1" >                    -->
        </div>                    
</form>                
    </div>            
</div>   


       