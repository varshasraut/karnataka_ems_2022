<select name="user_id" id="ero_list_qality" class="" data-errors="{filter_required:'User should not blank'}">
    <option value="">Select User</option>
    <option value="all">All Colleague</option>
    <?php //var_dump($tl_data); die();
    foreach($tl_data as $new) { ?>
                <!-- <option value="">hii</option> -->

        <option value="<?php echo $new->clg_ref_id; ?>"><?php echo $new->clg_first_name." ".$new->clg_last_name; ?></option> 
   <?php }?>
</select>