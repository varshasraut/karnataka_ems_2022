
<div class="width100 float_left">
                            <div class="label  field_lable float_left width30"><label for="clg_senior">Select DCO<span class="md_field">*</span></label></div>

                            <div class="filed_input float_left width70">
                                <select id="group" name="team_ero[]"  class="filter_required" data-errors="{filter_required:'Team Member should not blank'}" TABINDEX="7"  <?php echo $view; ?> multiple="multiple">

                                    <option value="">Select DCO</option>


                                    <?php
                                    if (count($clg_data) > 0) {

                                        foreach ($clg_data as $team_member) {
                                            $select_group[$current_data[0]->clg_senior] = "selected = selected";
                                            
                                            ?>

                                            <option selected value="<?php echo $team_member->clg_ref_id; ?>" <?php echo $select_group[$team_member->clg_ref_id];?>><?php echo $team_member->clg_first_name . " " . $team_member->clg_last_name;
                                            ; ?></option>

                                        <?php }
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>