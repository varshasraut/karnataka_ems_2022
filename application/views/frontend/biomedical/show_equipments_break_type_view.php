<!--  <input type="text" name="breakdown[mt_breakdown_type]" tabindex="1"  class="mi_autocomplete width1" data-href="<?php echo base_url(); ?>auto/get_inv_eqp_break_type/<?php echo $id; ?>" data-value="<?= @$preventive[0]->eqp_name; ?>" value="<?php echo @$equp_data[0]->eqp_id; ?>"  placeholder="Breakdown type" autocomplete="off" data-auto="EQP"  data-nonedit="yes" <?php echo $update; echo $Approve; echo $Re_request; ?> >-->

<!--<select name="breakdown[mt_breakdown_type][]" class="filter_required" data-errors="{filter_required:'Problem observed*should not be blank'}" <?php echo $update; echo $Approve; echo $Re_request; ?> TABINDEX="5"  multiple="multiple">

                                    <option>Select Problem observed*</option>
                                    <?php
                                    foreach($eqp as $eq){ ?>
                                    
                                    <option value="<?php echo $eq->eb_type_id; ?>"><?php echo $eq->eb_name; ?></option>
                                    
                                    <?php    
                                    }?>
                                      <option value="Missing" <?php echo $selected;?>>Missing </option>
                                </select>-->

   <div class="width100 float_left non_unit_drags">

<!--                          <input name="non_unit_drags" tabindex="22" class="form_input" placeholder="Non Units" type="text" data-base="search_btn" data-errors="{filter_required:'Drugs and consumables used should not be blank!'}" onclick="show_non_unit_box()">-->
                            <input name="non_unit_drags" tabindex="7" class="form_input" placeholder="Non Units" type="text" data-base="search_btn" data-errors="{filter_required:'Drugs and consumables used should not be blank!'}">
                            <div id="non_unit_drugs_box">

                                <?php
                                $med_inv_data[0] = array();

                                if ($pcr_na_med_inv_data) {


                                    foreach ($pcr_na_med_inv_data as $pcr_med) {
                                        //var_dump($pcr_med);

                                        $med_inv_data[$pcr_med->as_item_id] = $pcr_med;
                                    }
                                }
                                ?>

                                <div class="unit_drugs_box">
                                    <?php if ($eqp_obs) { ?>
                                        <ul class="width100">
                                            <?php foreach ($eqp_obs as $eq) { ?>
                                                <li class="unit_block">
                                                    <label for="unit_<?php echo $eq->eb_type_id; ?>" class="chkbox_check">
                                                        <input type="checkbox" name="breakdown[mt_breakdown_type][<?php echo $eq->eb_type_id; ?>][id]" class="check_input unit_checkbox" value="<?php echo $eq->eb_type_id; ?>" id="unit_<?php echo $eq->eb_type_id; ?>" <?php
                                                        if (is_array($med_inv_data) && array_key_exists($eq->eb_type_id, $med_inv_data)) {
                                                            echo "checked";
                                                        }
                                                        ?> data-base="non_unit_iteam" onclick="show_non_unit_box();">
                                                        <span class="chkbox_check_holder"></span><?php echo stripslashes($eq->eb_name); ?><br>
                                                    </label>
                                                </li>
                                                  <input name="non_unit_iteam" id="show_non_unit_drugs_box" style="display: none;" value="SEARCH" class="style3 base-xhttp-request" data-href="<?php echo base_url(); ?>/biomedical/show_problem_observed" data-qr="output_position=show_selected_unit_item" type="button">
                                            <?php } ?>
<!--                                                  <li class="unit_block">
                                                    <label for="unit_na" class="chkbox_check">


                                                        <input type="checkbox" name="unit['other'][id]" class="check_input unit_checkbox" value="other"  id="unit_na" data-base="non_unit_iteam">


                                                        <span class="chkbox_check_holder"></span>Other<br>
                                                    </label>
                                                </li>-->
                                                <li class="unit_block">
                                                    <label for="unit_na" class="chkbox_check">


                                                        <input type="checkbox" name="unit['missing'][id]" class="check_input unit_checkbox" value="missing"  id="unit_missing" data-base="non_unit_iteam">


                                                        <span class="chkbox_check_holder"></span>Missing<br>
                                                    </label>
                                                </li>
                                        </ul>
                                    
                                    <?php } ?>
                                </div>


                            </div>  
                            <div style="width:95%" id="show_selected_unit_item">
                            </div>
                        </div>