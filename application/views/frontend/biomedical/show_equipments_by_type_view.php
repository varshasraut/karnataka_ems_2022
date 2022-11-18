<!--  <input type="text" name="main[eq_equip_name]" tabindex="1"  class="mi_autocomplete width1" data-href="<?php echo base_url(); ?>auto/get_inv_eqp/dq/<?php echo $id; ?>" data-value="<?= @$preventive[0]->eqp_name; ?>" value="<?php echo @$equp_data[0]->eqp_id; ?>"  placeholder="Equipment Name" autocomplete="off" data-auto="EQP"  data-nonedit="yes" <?php echo $update; echo $Approve; echo $Re_request; ?> data-callback-funct="equipments_by_type" id="equipments_name1">-->
  
<select name="main[eq_equip_name]" class="filter_required" data-errors="{filter_required:'Equipment Name should not be blank'}" <?php echo $update; echo $Approve; echo $Re_request; ?> TABINDEX="5" id="equipments_name" onchange="equipments_by_type()" >

                                    <option value="">Select Equipment Name</option>
                                    <?php
                                    foreach($eqp as $eq){ ?>
                                    
                                    <option value="<?php echo $eq->eqp_id; ?>"><?php echo $eq->eqp_name; ?></option>
                                    
                                    <?php    
                                    }?>
                                </select>