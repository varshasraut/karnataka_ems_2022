 <select id="call_purpose" name="caller[cl_purpose]" class="filter_required" data-href="{base_url}calls/save_call_details" data-qr="output_position=content&amp;module_name=calls&amp;showprocess=no" data-errors="{filter_required:'Purpose of call should not blank'}" data-base="caller[cl_mobile_number]" TABINDEX="1.1"  onchange="submit_caller_form()">
                                  <option value="">Purpose Of calls</option>
                                  <?php
                                  $select_group[$cl_purpose] = "selected = selected"; 
                                  

                                  foreach ($purpose_of_calls as $purpose_of_call) {
                                      echo "<option value='" . $purpose_of_call->pcode . "'  ";
                                      echo $select_group[$purpose_of_call->pcode];
                                      echo" >" . $purpose_of_call->pname;
                                      echo "</option>";
                                  }
                                  ?>
                              </select>