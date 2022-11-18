<div class="form_field width17">

                <div class="label float_left width_40">Patient Name</div>
                <div class="input top_left float_left width_60">
                     <select name="cdata[adv_cl_ptn_id]" tabindex="8" id="ercp_pat_id" class="filter_required" data-errors="{filter_required:'Patient ID should not be blank!'}" data-base="send_sms"> 
                        <option value="" <?php echo $disabled; ?>>Select patient id</option>
                        <?php foreach ($patient_info as $pt) { ?>
                            <option value="<?php echo $pt->ptn_id; ?>" <?php
                            if ($pt->ptn_id == $patient_id) {
                                echo "selected";
                            }
                            ?>><?php echo $pt->ptn_id . " - " . $pt->ptn_fname . " " . $pt->ptn_lname; ?></option>
                                <?php } ?>
                      <option value="0">Other</option>
                    </select>
                     <input class="add_button_hp onpage_popup  float_right mipopup" id="add_button_ercp" name="add_patient" value="Add" data-href="{base_url}medadv/ercp_patient_details" data-qr="filter_search=search&amp;tool_code=add_patient&showprocess=yes" type="button" data-popupwidth="1250" data-popupheight="1000" style="display:none;">
                </div>


</div>