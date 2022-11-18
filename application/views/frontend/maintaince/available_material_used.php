 <div class="field_row width100">
                <div class="width2 float_left unit_drags">

    <div class="field_lable float_left width33"><label for="mt_onroad_datetime">Maintenance Parts</label></div>
    
    <input name="unit_drags" tabindex="6" class="form_input unit_drags_input width2" placeholder="Maintenance Parts" type="text" data-base="search_btn" data-errors="{filter_required:'Maintenance Parts used should not be blank!'}" style="width:50%;" id="maintananace_part_input" oninput="maintananace_part_search()">

                            <div id="unit_drugs_box">

                                <?php
                                //  var_dump($pcr_med_inv_data);
                                if ($pcr_med_inv_data) {
                                    $med_inv_data = array();


                                    foreach ($pcr_med_inv_data as $pcr_med) {

                                        $med_inv_data[$pcr_med->as_item_id] = $pcr_med;
                                    }
                                }
                                if ($pcr_med_data) {
                                    $med_data = array();


                                    foreach ($pcr_med_data as $pcr_med) {

                                        $med_data[$pcr_med->as_item_id] = $pcr_med;
                                    }
                                }
                                ?>

                                <div class="unit_drugs_box" id="unit_drugs_box_list">
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
                                                                                                                                                            <input type="text" name="unit[<?php echo $item->mt_part_id; ?>][value]" value="<?php echo $med_inv_data[$item->mt_part_id]->as_item_qty ?>" class="filter_if_not_blank filter_float width50" data-errors="{filter_float:'Only numbers are allowed.'}" data-base="unit_iteam" onchange="show_ca_unit_box();">
                                                                                                                                                            <input type="hidden" name="unit[<?php echo $item->mt_part_id; ?>][type]" value="<?php echo $item->mt_part_type; ?>" class="width50" data-base="unit_iteam" >
                                                                                                                                                        </div>
                                                    <?php } else { ?>
                                              <div class="unit_div hide">
                                                                                                                                                            <input type="text" name="unit[<?php echo $item->mt_part_id; ?>][value]" value="" class="width50 filter_if_not_blank filter_float" data-errors="{filter_float:'Only numbers are allowed.'}" data-base="unit_iteam"  onchange="show_ca_unit_box();">
                                                                                                                                                            <input type="hidden" name="unit[<?php echo $item->mt_part_id; ?>][type]" value="<?php echo $item->mt_part_type; ?>" class="width50" data-base="unit_iteam">
                                                                                                                                                        </div>
                                                    <?php } ?>
                                                </li>
                                            <?php } ?>


                                        <?php } ?>
                                                                               
                                    </ul>
                                </div>
                                <input name="unit_iteam" id="show_unit_box_selected_ca" style="display: none;" value="Done" class="style3 base-xhttp-request" data-href="<?php echo base_url();?>ambulance_maintaince/show_maintanance_part_list" data-qr="output_position=show_selected_unit_item_ca" type="button">     
                               
                                <div id="show_selected_unit_item_ca" style="width:95%">
                                </div>



                            </div>  

                        </div>
            </div>