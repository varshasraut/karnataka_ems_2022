<select name="user_id" id="ero_list">
    <option value="">Select ERO</option>
    
    <?php // var_dump($tl_data);
    foreach($tl_data as $new) { //var_dump($new); die();?>
        <option value="<?php echo $new->clg_ref_id; ?>"><?php echo $new->clg_first_name." ".$new->clg_last_name." ".$new->clg_ref_id; ?></option>
   <?php }?>
</select>