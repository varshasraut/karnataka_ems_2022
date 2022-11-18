<div class="filed_row">
    <div class="field_lable float_left width_10"><label for="clg_senior">Select Parent<span class="md_field">*</span></label></div>

    <div class="filed_input float_left width_23">
        <select id="group" name="clg[clg_senior]" data-base="<?= @$current_data[0]->clg_ref_id ?>"  class="<?php if($clg_group != 'UG-EMT' && $clg_group != 'UG-Pilot'){ echo 'filter_required'; } ?>" data-errors="{filter_required:'Parent Team Member should not blank'}" TABINDEX="7"  <?php echo $view; ?>>

            <option value="">Select Parent Team Member</option>


            <?php
            if (count($get_parent) > 0) {

                foreach ($get_parent as $team_member) {
                    ?>

                    <option value="<?php echo $team_member->clg_ref_id; ?>"><?php echo $team_member->clg_first_name . " " . $team_member->clg_last_name;
                    ; ?></option>

                <?php }
            }
            ?>
        </select>
    </div>
</div>
