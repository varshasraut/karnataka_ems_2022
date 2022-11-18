<div class="field_lable float_left width_10"><label for="group">Designation<span class="md_field">*</span></label></div>
                    <div class="filed_input float_left width_23">
                        <select  name="clg[clg_designation]"  data-base="<?= @$current_data[0]->clg_ref_id ?>"  class="filter_required "  data-qr="output_position=parent_member&amp;module_name=clg " data-errors="{filter_required:'Designation name should not blank'}" TABINDEX="1"  <?php
                       if(( $clg_group1 != 'UG-SuperAdmin') && ( $clg_group1 != 'UG-ShiftManager') && ( $clg_group1 != 'UG-OperationHR') && ( $clg_group1 != 'UG-HelpDesk')){
                       if (@$update) {
                        echo"disabled";
                        
                    }}
                        ?>>
                      <?php  if($clg_designation !=''){
                          ?> <option value="<?php echo $clg_designation; ?>"><?php echo $clg_designation_name; ?></option> <?php
                      }else{ ?>
                            <option value="">Select Designation</option>
                            <?php
                            //  var_dump($current_data[0]->clg_designation);die();                     
                            $select_group1[$current_data[0]->clg_designation] = "selected = selected";


                            foreach ($group_info as $group) {
//                                if (empty($update)) {
//                                    if (($clg_group != $group->gparent) && !in_array($clg_group, $super_groups)) {
//                                        continue;
//                                    }
//                                }
                                //if(trim($group->gparent) != ''){ continue; }


                                echo "<option value='" . $group->ugname . "'  ";
                                echo $select_group1[$group->ugname];
                                echo" >" . $group->ugname;
                                echo "</option>";

                                foreach ($group_info as $group_l1) {

                                    if (trim($group->ugname) != trim($group_l1->gparent)) {
                                        continue;
                                    }


                                    echo "<option value='" . $group_l1->ugname . "'  ";
                                    echo $select_group1[$group_l1->ugname];
                                    echo" > " . $group_l1->ugname;
                                    echo "</option>";

                                    foreach ($group_info as $group_l2) {

                                        if (trim($group_l1->ugname) != trim($group_l2->gparent)) {
                                            continue;
                                        }


                                        echo "<option value='" . $group_l2->ugname . "'  ";
                                        echo $select_group1[$group_l2->ugname];
                                        echo" >" . $group_l2->ugname;
                                        echo "</option>";

                                        foreach ($group_info as $group_l3) {

                                            if (trim($group_l2->ugname) != trim($group_l3->gparent)) {
                                                continue;
                                            }


                                            echo "<option value='" . $group_l3->ugname . "'  ";
                                            echo $select_group1[$group_l3->ugname];
                                            echo" > " . $group_l3->ugname;
                                            echo "</option>";
                                        }
                                    }
                                }
                            }
                         } ?>
                        </select>
                    </div>
                    </div>