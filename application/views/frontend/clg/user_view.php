<?php 

if($group == 'UG-ERO'){
    $readonly = "readonly='readonly'";
}

?>
<div class="field_input float_left width_23">

                        <input id="clg_ref_id" type="text" name="clg[clg_ref_id]" class="<?php if (!$update) { ?>filter_required filter_string filter_is_exists<?php } ?>" data-errors="{filter_required:'Reference Id should not be blank', filter_string:'Invalid characters in Reference Id',filter_is_exists:'Reference Id already exists'}" data-base="<?= @$current_data[0]->clg_ref_id ?>" value="<?= $user_id ?>" TABINDEX="1" <?php
                        if (@$update) {
                            echo"disabled";
                        }
                        ?> data-exists="no" <?php echo $readonly;?>>

                        <?php if ($update) { ?>  

                            <input type="hidden" name="clg[clg_ref_id]" id="ud_clg_id" value="<?= @$current_data[0]->clg_ref_id ?>">

                        <?php } ?>

                    </div>