<ul class="width100">
    <?php if ($invitem) { ?>

        <?php foreach ($invitem as $item) { ?>
            <li class="unit_block">
                <label for="unit_<?php echo $item->mt_part_id; ?>" class="chkbox_check">


                    <input type="checkbox" name="unit[<?php echo $item->mt_part_id; ?>][id]" class="check_input unit_checkbox" value="<?php echo $item->mt_part_id; ?>"  id="unit_<?php echo $item->mt_part_id; ?>" onclick="GetCheckedUnit(this);" <?php
                    if (is_array($med_inv_data) && array_key_exists($item->mt_part_id, $med_inv_data)) {
                        echo "checked";
                    }
                    ?> data-base="unit_iteam">


                    <span class="chkbox_check_holder"></span><?php echo stripslashes($item->Item_Code); ?> - <?php echo stripslashes($item->mt_part_title); ?><br>
                </label>
        <!--            <input type="checkbox" value="<?php echo $item->med_id ?>" name="unit[<?php echo $item->mt_part_id; ?>][id]" class="unit_checkbox"><?php echo $item->mt_part_title; ?><br>-->
                <?php if (isset($med_inv_data[$item->mt_part_id])) {
                    ?>
                    <div class="unit_div">
                        <input type="text" name="unit[<?php echo $item->mt_part_id; ?>][value]" value="<?php echo $med_inv_data[$item->mt_part_id]->as_item_qty ?>" class="width50 filter_if_not_blank filter_float" data-errors="{filter_float:'Only numbers are allowed.'}" data-base="unit_iteam" onchange="show_ca_unit_box();">
                        <input type="hidden" name="unit[<?php echo $item->mt_part_id; ?>][type]" value="<?php echo $item->mt_part_type; ?>" class="width50" data-base="unit_iteam" >
                    </div>
                <?php } else { ?>
                    <div class="unit_div hide">
                        <input type="text" name="unit[<?php echo $item->mt_part_id; ?>][value]" value="" class="filter_if_not_blank filter_float width50" data-errors="{filter_float:'Only numbers are allowed.'}" data-base="unit_iteam"  onchange="show_ca_unit_box();">
                        <input type="hidden" name="unit[<?php echo $item->mt_part_id; ?>][type]" value="<?php echo $item->mt_part_type; ?>" class="width50" data-base="unit_iteam">
                    </div>
                <?php } ?>
            </li>
        <?php } ?>


    <?php } ?>
</ul>