                                <select id="group" name="clg[clg_district_id][]" data-base="<?= @$current_data[0]->clg_ref_id ?>"  class="filter_required" data-errors="{filter_required:'District name should not blank'}" TABINDEX="7"  <?php if(($current_data[0]->clg_group) != "UG-DIS-FILD-MANAGER" ){ if (@$update) {echo "disabled";}}?>> 

                                        <option value=""> Select District </option>

                                            <?php
                                            if (count($district_list) > 0) {

                                                foreach ($district_list as $district) {
                                                    
                                                    $selected_dist = json_decode($current_data[0]->clg_district_id);
                                                    if(in_array($district->dst_code, $selected_dist)){
                                                        $select_group[$district->dst_code] = "selected = selected";
                                                    }
                                                    ?>

                                                <option value="<?php echo $district->dst_code; ?>" <?php echo $select_group[$district->dst_code]; ?>><?php echo $district->dst_name; ?></option>

        <?php
        }
    }
    ?>
                                    </select>