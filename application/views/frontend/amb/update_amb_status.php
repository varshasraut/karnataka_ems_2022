
<h2>Ambulance Details</h2> 
<div class="width100">
    <div class="field_row width100">

    <div class="field_lable float_left"> RTO Reg No: </div> 

    <div class="field_input float_left">

        <?php echo $get_amb_details[0]->amb_rto_register_no; ?>

    </div>

</div>  
<div class="field_row width100">

    <div class="field_lable float_left">Mobile No:</div> 

    <div class="field_input float_left">

        <?php echo $get_amb_details[0]->amb_default_mobile; 
        ?>

    </div>

</div>  
<div class="field_row width100">

    <div class="field_lable float_left">Ambulance Status:</div> 

    <div class="field_input float_left">

        <?php echo $status; 
        ?>

    </div>

</div>  
<br><br> 
  <form enctype="multipart/form-data" action="#" method="post" id="usr_ad_form">
<div class="field_row">

                            <div class="filed_select">
                      
                                <select name="amb_status" class="amb_status filter_required" data-errors="{filter_required:'Ambulance status should not be blank'}" <?php echo $view;?> TABINDEX="6" id="update_amb_status">

                                    <option value="">Select Status</option>

                                        <?php //echo get_amb_status($status); ?>
                                     <?php echo get_amb_status_list($status); ?>
                                </select>
                                
                            </div>
                            
                        </div>
      
        <div class="field_row" id="ambu_start_end_record">
          
        </div>
           <div class="width_25 margin_auto">
                    <div class="button_field_row">
                        <div class="button_box">
                            <input type="hidden" name="amb_reg_no" id="amb_reg_no" value="<?php echo $get_amb_details[0]->amb_rto_register_no; ?>">
							<input type="button" name="submit" value="Submit" class="form-xhttp-request" data-href='<?php echo base_url(); ?>calls/save_change_status' data-qr='amb_id=<?php echo base64_encode($amb_id);?>&amp;output_position=content' TABINDEX="12">  
                        </div>
					</div>
               </div>
  </form>
</div>
