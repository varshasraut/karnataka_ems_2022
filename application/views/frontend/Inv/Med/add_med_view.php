<?php

if($med_action=='view'){ $ftype='disabled'; }

(empty($med[0]))? $href="add" : ($href="edit") && ($data_qr.="med_id=".$med[0]->med_id."&amp;action=edit_med") ;

?>

<div class="width1 float_left">
   
<div class="box3">
        
    <form action="#" method="post" id="">
            
        <div class="width1 float_left">

                <h2 class="txt_clr2 width1 txt_pro hheadbg"> <?php echo ucfirst($med_action);?> Medicine</h2>
        
            
        
                <div class="field_row">
                    
                    <div class="field_lable">

                        <label>Medicine Name<span class="md_field">*</span> :</label>

                    </div>
                    
                    <div class="filed_input">

                         <input type="text" name="med_title" tabindex="1" value='<?php echo stripslashes($med[0]->med_title);?>' class="filter_required width_100" data-errors="{filter_required:'Medicine name should not be blank'}" <?php echo $ftype;?>>

                    </div>
                    
                </div>
                
                
                <div class="field_row">

                    <div class="field_lable">
                        
                        <label>Set Minimum Quantity<span class="md_field">*</span> :</label>
                        
                    </div>
                     
					<div class="filed_input">
                        
					   <input type="text" name="med_base_qty" tabindex="2" value="<?php echo $med[0]->med_base_quantity;?>"  class="filter_required filter_no_whitespace filter_number width_100" data-activeerror="" data-errors="{filter_required:'Minimum quantity should not be blank','filter_number':'Medicine minimum should be in numbers',filter_no_whitespace:'Item minimum should not be allowed blank space.'}" <?php echo $ftype;?>>
                       
				   </div>

                </div>
               
                
                <div class="field_row">
                
                    <div class="field_lable">
                        
                        <label>Unit Type<span class="md_field">*</span> :</label>
                        
                    </div>
                    
                    <div class="filed_input"> 
                        
                        <select id="classification" name="med_unit" tabindex="3" class="filter_required width_100"  data-errors="{filter_required:'Please select medicine unit'}" <?php echo $ftype;?>>
                            
                                <option value="" selected="" disabled>Type</option>

                                <?php echo get_unit('MED',$med[0]->med_quantity_unit); ?>

                        </select>

                    </div>

                </div>

                <div class="field_row">
                 
                    <div class="field_lable">
                        
                        <label>Manufacture Name :</label>
                        
                    </div>


                    <div class="filed_input">

                       <select  name="med_manid" tabindex="4" class="width_100"  data-errors="" <?php echo $ftype;?>>

                                        <option value="" selected="" disabled>Manufacture</option>

                                        <?php echo get_man($med[0]->med_manufacture); ?>


                        </select>

                    </div>

                </div>
                <div class="field_row">

                    <div class="field_lable">
                        
                         <label>Manufacture Date <span class="md_field">*</span> : </label>
                         
                    </div>
                    
                    <div class="filed_input"> 
                          <?php if( $med[0]->med_manufacturing_date != '' && $med[0]->med_manufacturing_date != 0000-00-00){ 
                            $med_manufacturing_date=  date('Y-m-d', strtotime($item[0]->med_manufacturing_date));    
                        }
                        ?> 
                        
                        <input name="inv_manufacturing_date" value="<?php echo $med_manufacturing_date;?>" class="form_input mi_calender filter_required" type="text" data-errors="{filter_required:'Manufacture Date should not be blank!'}" tabindex="3">

                    </div>

                </div>

                <div class="field_row">

                    <div class="field_lable">
                        
                         <label>Expiry Date <span class="md_field">*</span> : </label>
                         
                    </div>
                    
                    <div class="filed_input"> 
                            <?php if( $med[0]->med_exp_date != '' && $med[0]->med_exp_date != 0000-00-00 ){ 
                            $inv_exp_date=  date('Y-m-d', strtotime($med[0]->med_exp_date));    
                        }
                        ?> 
                        
                        <input name="inv_exp_date" value="<?php echo $inv_exp_date;?>" class="form_input mi_calender filter_required" type="text" data-errors="{filter_required:'Expiry date should not be blank!'}" tabindex="3">

                    </div>

                </div>

                    
                <?php if($ftype!='disabled'){ ?>
                    
                <div class="width2 margin_auto">
                    
                    <div class="button_field_row">
                
                        <div class="button_box">

                            <input type="hidden" name="submit_med" value="sub_med">

                            <input type="button" name="submit" id="btnsave" value="Submit" class="btn submit_btnt form-xhttp-request" data-href="{base_url}med/<?php echo $href;?>" data-qr="<?php echo $data_qr;?>">

                            <input type="reset" name="Reset" value="Reset" class="btn">

                        </div>
                        
                    </div>
                    
                </div>
                    
                <?php } ?>

            
 
        </div>
            
    </form>
        
</div>
    
</div>
            
            

