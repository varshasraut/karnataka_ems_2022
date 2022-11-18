<?php

if($action=='view'){ $ftype='disabled'; }

(empty($item[0]))? $href="add" : ($href="edit") && ($data_qr.="invid=".$item[0]->inv_id."&amp;action=edit_inv") ;


?>


<div class="width1 float_left">
        
    <form action="#" method="post" id="">
        
     <div class="width1 float_left">
          
          <h2> <?php echo ucfirst($action); ?> Maintenance Part</h2>
        
            
            
        
                
                <div class="field_row">

                    <div class="field_lable">
                        
                        <label>Item Name<span class="md_field">*</span> :</label>
                        
                    </div>
                    
					<div class="filed_input">
                        
					   <input type="text" name="mt_part_title" tabindex="1" value='<?php echo stripslashes(trim($item[0]->mt_part_title));?>' class="filter_required" data-errors="{filter_required:'Item name should not be blank'}" <?php echo $ftype;?>>
                       
				   </div>

                </div>
                
                <div class="field_row">

                    <div class="field_lable">

                        <label>Set Minimum Quantity<span class="md_field">*</span> :</label>

                    </div>
                    
					<div class="filed_input">
                        
					   <input type="text" name="mt_part_base_quantity" tabindex="2" value="<?php echo $item[0]->mt_part_base_quantity;?>"  class="filter_required filter_no_whitespace filter_number" data-activeerror="" data-errors="{filter_required:'Item minimum should not be blank','filter_number':'Item minimum should be in numbers',filter_no_whitespace:'Item minimum should not be allowed blank space.'}" <?php echo $ftype;?>>
                       
				   </div>

                </div>
                
                
                <div class="field_row">

                    <div class="field_lable">
                        
                         <label>Item Code<span class="md_field">*</span> : </label>
                         
                    </div>
                    
                    <div class="filed_input"> 
                        
                       <input type="text" name="Item_Code" tabindex="2" value="<?php echo $item[0]->Item_Code;?>"  class="filter_required filter_no_whitespace" data-activeerror="" data-errors="{filter_required:'Item minimum should not be blank','filter_number':'Item minimum should be in numbers',filter_no_whitespace:'Item minimum should not be allowed blank space.'}" <?php echo $ftype;?>>

                    </div>

                </div>

                 <div class="field_row">

                    <div class="field_lable">
                        
                        <label>Part Type<span class="md_field">*</span> :</label>
                        
                    </div>
                    
					<div class="filed_input">
                        
					   <input type="text" name="mt_part_type" tabindex="1" value='<?php echo stripslashes(trim($item[0]->mt_part_type));?>' class="filter_required" data-errors="{filter_required:'Part type should not be blank'}" <?php echo $ftype;?>>
                       
				   </div>

                </div>
          <div class="field_row">

                    <div class="field_lable">
                        
                         <label>Make<span class="md_field">*</span> : </label>
                         
                    </div>
                    
                    <div class="filed_input"> 
                        
                        <select id="classification" name="make" tabindex="3" class="filter_required"  data-errors="{filter_required:'Please select item unit'}" <?php echo $ftype;?>>
                            
                                <option value="" selected="" >Type</option>
                                <option value="BSIII">BSIII</option>
                                <option value="BSIV">BSIV</option>
                        </select>

                    </div>

                </div>



                    
                <?php if($ftype!='disabled'){ ?>
                    
                <div class="width2 margin_auto">
                      
                    <div class="button_field_row">
                 
                        <div class="button_box">

                            <input type="hidden" name="submit_inv" value="sub_inv">

                            <input type="button" name="submit" id="btnsave" value="Submit" class="btn submit_btnt form-xhttp-request" data-href="{base_url}maintenance_part/add_maintenance_part" data-qr="<?php echo $data_qr;?>">

                            <input type="reset" name="Reset" value="Reset" class="btn">

                        </div>
                           
                    </div>
                </div>
                    
                <?php } ?>

            
          
        </div>
                
    </form>
    
</div>
 



