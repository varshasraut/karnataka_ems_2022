<?php
$ftype='';
if($action=='view'){ $ftype='disabled'; }

(empty($item[0]))? $href="add" : ($href="edit") && ($data_qr.="invid=".$item[0]->inv_id."&amp;action=edit_inv");

?>


<div class="width1 float_left">
        
    <form action="#" method="post" id="">
        
     <div class="width1 float_left">
          
          <h2 class="txt_clr2 width1 txt_pro hheadbg"> <?php echo ucfirst($action); ?> Item</h2>
        
            
            
        
                
                <div class="field_row">

                    <div class="field_lable">
                        
                        <label>Item Name<span class="md_field">*</span> :</label>
                        
                    </div>
                    
					<div class="filed_input">
                        
					   <input type="text" name="inv_title" tabindex="1" value='<?php echo stripslashes(trim($item[0]->inv_title));?>' class="filter_required" data-errors="{filter_required:'Item name should not be blank'}" <?php echo $ftype;?> >
                       
				   </div>

                </div>
                
                <div class="field_row">

                    <div class="field_lable">

                        <label>Set Minimum Quantity<span class="md_field">*</span> :</label>

                    </div>
                    
					<div class="filed_input">
                        
					   <input type="text" name="inv_base_qty" tabindex="2" value="<?php echo $item[0]->inv_base_quantity;?>"  class="filter_required filter_no_whitespace filter_number" data-activeerror="" data-errors="{filter_required:'Item minimum should not be blank','filter_number':'Item minimum should be in numbers',filter_no_whitespace:'Item minimum should not be allowed blank space.'}" <?php echo $ftype;?>>
                       
				   </div>

                </div>
                
                
                <div class="field_row">

                    <div class="field_lable">
                        
                         <label>Unit Type<span class="md_field">*</span> : </label>
                         
                    </div>
                    
                    <div class="filed_input"> 
                        
                        <select id="classification" name="inv_unit" tabindex="3" class="filter_required"  data-errors="{filter_required:'Please select item unit'}" <?php echo $ftype;?> >
                            
                                <option value="" selected="" disabled>Type</option>

                                <?php echo get_unit($inv_type,$item[0]->inv_unit); ?>

                        </select>

                    </div>

                </div>

                <div class="field_row">
                    
                    <div class="field_lable">
                        <label>Manufacture Name :</label>
                    </div>
                   
                    <div class="filed_input">

                       <select  name="inv_manid" tabindex="4" class=""  data-errors="" <?php echo $ftype;?>>

                                        <option value="" selected="" disabled>Manufacture</option>

                                        <?php echo get_man($item[0]->inv_manufacture); ?>


                        </select>

                    </div>

                </div>
                <div class="field_row">

                    <div class="field_lable">
                        
                         <label>Manufacture Date <span class="md_field">*</span> : </label>
                         
                    </div>
                    
                    <div class="filed_input"> 
                        <?php
                       
                        if( $item[0]->inv_manufacturing_date != '' && $item[0]->inv_manufacturing_date != 0000-00-00 ){ 
                              
                            $manu_date =  date('Y-m-d', strtotime($item[0]->inv_manufacturing_date));    
                        }
                        ?> 
                        <input name="inv_manufacturing_date" class="form_input mi_calender filter_required" data-errors="{filter_required:'Please select Manufacture date from date format'}" value="<?php echo $manu_date; ?>" class="mi_calender" type="text" tabindex="3" <?php echo $ftype;?>>

                    </div>

                </div>

                <div class="field_row">

                    <div class="field_lable">
                        
                         <label>Expiry Date <span class="md_field">*</span> : </label>
                         
                    </div>
                    
                    <div class="filed_input"> 
                         <?php if( $item[0]->inv_exp_date != '' && $item[0]->inv_exp_date != 0000-00-00 ){ 
                            $inv_exp_date=  date('Y-m-d', strtotime($item[0]->inv_exp_date));    
                        }
                        ?> 
                        <input name="inv_exp_date" value="<?php echo $inv_exp_date; ?>" class="form_input mi_calender filter_required" data-errors="{filter_required:'Please select Expiry date from date format'}" type="text" tabindex="3" <?php echo $ftype;?>>

                    </div>

                </div>

                    
                <?php if($ftype!='disabled'){ ?>
                    
                <div class="width2 margin_auto">
                      
                    <div class="button_field_row">
                 
                        <div class="button_box">

                            <input type="hidden" name="submit_inv" value="sub_inv">

                            <input type="button" name="submit" id="btnsave" value="Submit" class="btn submit_btnt form-xhttp-request" data-href="{base_url}inv/<?php echo $href;?>" data-qr="<?php echo $data_qr;?>">

                            <input type="reset" name="Reset" value="Reset" class="btn">

                        </div>
                           
                    </div>
                </div>
                    
                <?php } ?>

            
          
        </div>
                
    </form>
    
</div>