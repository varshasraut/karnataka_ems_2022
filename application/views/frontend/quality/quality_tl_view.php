<select name="tl_name" id="tl_list">
   <option value="">Select TL</option>
   <option value="">All TL</option>
    <?php // var_dump($tl_data);
    foreach($tl_data as $new) { //var_dump($new); die();?>
        <option value="<?php echo $new->clg_ref_id; ?>"><?php echo $new->clg_first_name." ".$new->clg_last_name; ?></option>
   <?php }?>
</select>