<select name="user_id" id="ero_list_qality">
    <option value="">Select ERO</option>
    <option value="all">All Colleuage</option>
    <?php //var_dump($tl_data); die();
    foreach($tl_data as $new) { ?>
                <!-- <option value="">hii</option> -->

        <option value="<?php echo $new->clg_ref_id; ?>"><?php echo $new->clg_first_name." ".$new->clg_last_name." (".$new->clg_ref_id.")"; ?></option> -->
   <?php }?>
</select>