 <div class="field_lable float_left width_10"><label for="email">Ameyo ID<?php if($clg_group != 'UG-EMT' && $clg_group != 'UG-Pilot'){ ?><span class="md_field">*</span><?php } ?></label></div>

                        <div class="filed_input float_left width_23">

                            <input  type="text" data-base="<?= @$current_data[0]->clg_ref_id ?>"  name="clg[clg_avaya_agentid]" class="<?php if($clg_group != 'UG-EMT' && $clg_group != 'UG-Pilot'){ echo 'filter_required'; } ?>"  data-errors="{filter_required:'Avaya should not be blank'}" value="<?= @$current_data[0]->clg_avaya_agentid ?>" TABINDEX="6" <?php echo $view; if (@$update) {
    //echo"disabled";
} ?>>
                        </div>