<div class="avaya_setting_block">    
    <div class="width100">    
        <h3>Ameyo Setting </h3>        
        <form enctype="multipart/form-data" action="#" method="post" id="avaya_setting">        
            <div class="width15 float_left form_field">            
                <div class="label float_left">Activate Ameyo:</div>        
            </div>        
            <div class="width33 float_left form_field" style="margin-top: 10px;">                            
                <label for="avaya_yes" class="radio_check width2 float_left">                                
                    <input id="avaya_yes" type="radio" name="avaya" class="radio_check_input filter_either_or[avaya_no,avaya_yes]" value="Yes" data-errors="{filter_either_or:'Activate Avaya is required'}" TABINDEX="2" <?php if ($avaya_data == 'Yes') {echo "checked";} ?> ><span class="radio_check_holder" ></span>Yes</label>                           
                <label for="avaya_no" class="radio_check width2 float_left"> <input id="avaya_no" type="radio" name="avaya" class="radio_check_input filter_either_or[avaya_no,avaya_yes]" value="No" data-errors="{filter_either_or:'Activate Avaya required'}" <?php if ($avaya_data == 'No') { echo "checked";} ?> TABINDEX="1"><span class="radio_check_holder" ></span>No </label>                        
            </div>        
            <div class="width33 ">                                
                <input type="button" name="submit" value="Save" class="btn submit_btnt form-xhttp-request" data-href='{base_url}setting/save_avaya' data-qr='output_position=content&amp;module_name=setting&amp;MT-SET-AVAYA-SETTING'  TABINDEX="3">                  
            </div>            
        </form>    
    </div>
</div>