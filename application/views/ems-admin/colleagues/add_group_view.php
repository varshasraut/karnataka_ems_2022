<div class="add_group_form">
  
     <form method="post" action="#" method="post" class="add_grp_clg">
  
         
         <div class="width2 float_left">
         
		   <div class="row">
                <div class="input_title">Group Name * :</div>
                <div class="input_field"><input type="text" name="user_gname" value="<?php if(!empty($group_result)){echo $group_result[0]->ugname;}?>" class="filter_required filter_string filter_words" data-activeerror="" data-errors="{filter_required:'Group name should not be blank!',filter_string:'Group name should have alphabets.',filter_words:'Group name not allowed numbers'}"></div>
            </div>
             
         </div>
         
        <div class="width2 float_right">
         
            <div class="row">
                <div class="input_title">Group Code * :UG-</div>
                <div class="input_field"><input type="text" name="user_gcode" id="" class="gcode_capital filter_required" value="<?php if(!empty($group_result)){echo $group_result[0]->gcode;}?>" <?php if($group_id!=''){?> readonly="readonly"<?php }?>  data-errors="{filter_required:'Group code should not be blank!'}" /></div>
            </div>
         
        </div>
         
         <div class="width2 float_left">
             
            <div class="row">
                <div class="input_title">Group Status :</div>
                    <div class="input_field"> 
                    <?php @$status_selected [$group_result[0]->status] = 'selected="selected"';?>
                     <select name="user_gstatus">
                      <option value="active" <?php echo @$status_selected ['active'] ?> >Active</option>
                      <option value="inactive" <?php  echo @$status_selected ['inactive'] ?>>Inactive</option>
                    </select>
                    </div>
            </div>
             
         </div>
      
        
        <div class="width2 float_left">  

         <input type="hidden" name="group_id" value="<?php echo $group_id ?>">
         <input type="hidden" name="submit_group" value="submit_group">
         <input type="button" name="submit_group" id="btnsave" value="Submit" class="btn submit_btn form-xhttp-request" data-href="<?php echo $action['href']?>" data-qr="<?php echo $action['qr']."&output_position=content"?>" style="margin-top: 49px;">

        </div>
             
         
    </form>
            
     
 </div>