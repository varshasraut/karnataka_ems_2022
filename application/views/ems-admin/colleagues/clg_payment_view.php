<div class="add_group_form manage_subscription_form">
 
    <form method="post" action="#">
    
        <div class="width2 float_left">
        
            <div class="field_row">
                    <div class="field_lable">
                        <label for="payment_date">Payment Date</label>
                    </div>                            
                    <div class="filed_input">
                            <input type="text" id="payment_date" name="payment_date"  tabindex="8"  value="<?php if(@$manage_subscription){echo @$manage_subscription[0]->payment_date;}?>" class="mi_calender"  >
                    </div>
             </div>  
            
            
            <div class="field_row">
            
                <div class="field_lable">
                    <label for="payment_status">Payment Status</label>
                </div>
            
                <div class="filed_input">
                
                    <?php $status_select[$manage_subscription[0]->payment_status]="selected=selected";?>
                
                    <select id="payment_status" name="payment_status" class="filter_required"  data-errors="{filter_required:'Please select payment status'}"  style="width:96%;">
                        <option value="1" <?=$status_select['1']?> >Paid</option>
                        <option value="0"  <?=$status_select['0']?> >Unpaid</option>
                      
                    </select>
            
                </div>
        
            </div>
            
            
        </div>    

        
        <div class="width2 float_right">    
           
            
            
            
             <div class="field_row">
            
                <div class="field_lable">
                    <label for="payment_account">Payment Bank & Account</label>
               </div>
                
                <div class="filed_input">
                   <?php if(@$manage_subscription){
                       $select_bank[$manage_subscription[0]->usr_sub_account]="selected=selected";
                   }
                   ?>
                    <select name="payment_account" id="payment_account" style="width:96%;"  class="filter_required"  data-errors="{filter_required:'Please select bank details'}">
                        <option value="">Select Bank Details</option>
                         <?php for($i=0;$i< count($bank_details['gb_name']);$i++){ 
                                 $bank= $bank_details['gb_bank'][$i].":".$bank_details['gb_account_no'][$i];
                             ?>
                             
                            <option value="<?php echo $bank;?>"   <?php echo $select_bank[$bank];?> > <?php echo $bank;?></option>
                          <?php } ?>
                    </select>
                     <!--<input type="text" name="payment_account" id="payment_account" value="<?php // if(@$manage_subscription){echo $manage_subscription[0]->usr_sub_account;}?>"/>-->
                  
                </div>
            
            </div>
            
            
        </div>    
             
        
        

            
       
        
        <div class="button_field_row submit_subscription_button float_left" style="width:100%;">  
         
             <input type="hidden" name="group_id" id="group_id" value="<?php if(@$group_id){echo $group_id;}?>">
         
            <input type="button" name="clg_payment_submit" id="btnsave" value="Submit" class=" form-xhttp-request" data-href="{base_url}gb-admin/colleagues/pay_payment" data-qr="output_position=sales_earning_list&tool_code=mt_clg_pmnt_pay&module_name=colleagues" style="margin-top:20px;">
       </div>     
   
         </div>     
    </form>
</div>    

