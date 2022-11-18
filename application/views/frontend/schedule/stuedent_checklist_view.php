<?php $view = ($schedule_action == 'view') ? 'disabled' : ''; ?>
<div class="width100 float_left">
                <div class="style6"><strong>Student List</strong></div>
<!--                <div class="checkbox_input"></div>-->
                <div class="hide_screening_checkbox1 checkbox_div1">
                    <table class="style3 width100">
                         <tr>
                             <td>
                                  <div class="checkbox_button_div">
                                      <label for="student_selectall" class="chkbox_check">
                                          <input name="selectall" class="base-select" data-type='default' id="student_selectall" type="checkbox" <?php echo $view; ?> data-base="selectall" style="margin-right: -15px;"><span class="chkbox_check_holder"></span> Select All
                                      </label>
                                  </div>
                             </td>
                         </tr>
                                        <?php
                $tab = 34;

                if (!empty($students)) {

                    foreach ($students as $key=>$dig) {


                       $stud_opt = array('Others - specify' => 'birth_eff_other');

                        if (!empty($students_seleted)) {
                           foreach($students_seleted as $sel_stud){
                                if ($dig->stud_id == $sel_stud->stud_id) {

                                    $checked[$dig->stud_id] = "checked";

                                    $oth_dig = ($dig->stud_id == 'Others - specify') ? 'yes' : '';
                                }
                          }
                        }else if( $key < 50 ){
                             $checked[$dig->stud_id] = "checked";
                        }

                        $student_ids[] = "student_" . $dig->stud_id;
                        ob_start();
                        ?>

                        <tr>

                            <td>
                            <label for="student_<?php echo $dig->stud_id; ?>" class="chkbox_check">
                                <input name="student_[<?php echo $dig->stud_id; ?>]" class="check_input filter_either_or[(*:ids:*)] <?php echo $stud_opt[$dig->stud_first_name]; ?>" value="<?php echo $dig->stud_id; ?>" data-errors="{filter_either_or:'should not be blank!'}" id="student_<?php echo $dig->stud_id; ?>" type="checkbox" <?php echo $checked[$dig->stud_id]; ?> tabindex="<?php echo $tab++; ?>" <?php echo $view;?> data-base="selectall" ><span class="chkbox_check_holder"></span><?php echo $key+1;?>. <?php echo $dig->stud_first_name; ?> <?php echo $dig->stud_middle_name; ?> <?php echo $dig->stud_last_name; ?>
                            </label>
                            </td>
                        </tr>

                        <?php
                        $student_opt[] = ob_get_contents();

                        ob_get_clean();
                    }
              


                $html = join("", $student_opt);

                echo $html = str_replace("(*:ids:*)", join(",", $student_ids), $html);
                  }else{ ?>
                       <tr>

                           <td>No Student</td>
                       </tr>
                   
                      <?php
                  }
                ?>
                    </table>



            </div>
                    </div>
           