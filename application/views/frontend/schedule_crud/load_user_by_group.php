<div class="width_10 float_left"><p>User ID <span class="md_field">*</span> : </p></div>
                    <div class="width_70 float_left">
                        <!-- <div class="shift width_30 float_left "><label for="sft2">User ID</label></div>                 -->

                        <!-- <div class="shift width70 float_left"> -->

                            <input name="crud[user_id]" class="mi_autocomplete filter_required" data-href="<?php echo base_url(); ?>auto/get_all_user?clg_group=<?php echo $clg_group;?>" data-value="<?= $inc_emp_info[0]->user_id; ?>" value="<?= $inc_emp_info[0]->user_id; ?>" type="text" tabindex="1" placeholder="User ID" data-callback-funct="show_all_user_data"  id="emt_list" data-errors="{filter_required:'User ID should not be blank!'}" <?php echo $view; ?> <?php echo $edit; ?>>

                        <!-- </div> -->
                    </div>