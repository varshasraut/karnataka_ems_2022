<!--
            <div class="width100">
                <h3>Ambulance Details : </h3>
                <div class="width50 float_left">
                    <div class="width100 float_left">
                        <div class="style6 float_left">Ambulance No : </div>
                    </div>
                    <div class="width100 float_left">
                        <select name="amb_reg_id" tabindex="8" id="pcr_amb_id" class="filter_required" data-errors="{filter_required:'Ambulance should not be blank!'}"> 
                            <option value="">Select Ambulance</option>
                            <?php foreach ($vahicle_info as $amb) { ?>
                                <option value="<?php echo $amb->amb_rto_register_no; ?>" <?php if( $amb->amb_rto_register_no == $inc_emp_info[0]->amb_rto_register_no ){ echo "selected"; }?>><?php echo $amb->amb_rto_register_no; ?></option>
                            <?php } ?>
                         
                        </select>
                        <input id="add_pcr_amb" class=" onpage_popup float_right" name="add_amb" value="Add Ambulance" data-href="{base_url}/amb/add_amb" data-qr="output_position=popup_div&amp;tool_code=add_ambu" data-popupwidth="1000" data-popupheight="800" type="button" style="display:none;" >
                              <input name="amb_reg_id" tabindex="5" class="form_input filter_required" placeholder=" Ambulance No" type="text" data-base="search_btn" data-errors="{filter_required:'Ambulance No should not be blank!'}" value="<?= @$inc_emp_info[0]->amb_rto_register_no; ?>">
                    </div>
                </div>
                <div class="width50 float_left">
                    <div class="width100 float_left">
                        <div class="style6 float_left">Base Location : </div>
                    </div>
                    <div class="width100 float_left">
                        <input name="base_location" tabindex="9" class="form_input filter_required" placeholder=" Base Location" type="text" data-base="search_btn" data-errors="{filter_required:'Base Location should not be blank!'}" value="<?= $inc_emp_info[0]->hp_name; ?>" readonly="readonly">
                    </div>
                </div>

            </div>
            <div class="width100">
                <div class="width50 float_left">
                    <div class="width100 float_left">
                        <div class="style6 float_left">SHP Name : </div>
                    </div>
                    <div class="width100 float_left">
                        <input name="emt_name" tabindex="10" class="form_input filter_required" placeholder="SHP Name" type="text" data-base="search_btn" data-errors="{filter_required:'SHP Name should not be blank!'}" value="<?= $inc_emp_info[0]->emt_name; ?>" readonly="readonly">
                    </div>
                </div>
                <div class="width50 float_left">
                    <div class="width100 float_left">
                        <div class="style6 float_left">SHP ID : </div>
                    </div>
                    <div class="width100 float_left">
                        <input name="emt_id" tabindex="11" class="form_input filter_required" placeholder=" SHP ID" type="text" data-base="search_btn" data-errors="{filter_required:'SHP ID should not be blank!'}" value="<?= $inc_emp_info[0]->amb_emt_id; ?>" readonly="readonly">
                    </div>
                </div>

            </div>
            <div class="width100">
                <div class="width50 float_left">
                    <div class="width100 float_left">
                        <div class="style6 float_left">Pilot Name : </div>
                    </div>
                    <div class="width100 float_left">
                        <input name="pilot_name" tabindex="12" class="form_input filter_required" placeholder=" Pilot Name " type="text" data-base="search_btn" data-errors="{filter_required:'Pilot Name should not be blank!'}"  value="<?= $inc_emp_info[0]->pilot_name; ?>" readonly="readonly">
                    </div>
                </div>
                <div class="width50 float_left">
                    <div class="width100 float_left">
                        <div class="style6 float_left">Pilot ID : </div>
                    </div>
                    <div class="width100 float_left">
                        <input name="pilot_id" tabindex="13" class="form_input filter_required" placeholder=" Pilot ID" type="text" data-base="search_btn" data-errors="{filter_required:'Pilot ID should not be blank!'}" value="<?= $inc_emp_info[0]->amb_pilot_id; ?>" readonly="readonly">
                    </div>
                </div>

            </div>

            <div class="width100">
                <div class="width50 float_left">
                    <div class="width100 float_left">
                        <div class="style6 float_left">Ambulance Category : </div>
                    </div>
                    <div class="width100 float_left">
                        <input name="category" tabindex="14" class="form_input filter_required" placeholder=" Category" type="text" data-base="search_btn" data-errors="{filter_required:'Category should not be blank!'}" value="<?= @$inc_emp_info[0]->ar_name; ?>" readonly="readonly">
                    </div>
                </div>

            </div>-->
  <div id="amb_details_block">
                    <div class="width100">
                        <div class="single_record_back">                                     
                            <h3>Ambulance Details</h3>
                        </div>

                        <div class="width50 drg float_left">
                            <div class="width33 float_left">
                                <div class="style6 float_left">Ambulance No<span class="md_field">*</span> : </div>
                            </div>
                            <div class="width_62 float_left">
                                <select name="amb_reg_id" tabindex="22" id="pcr_amb_id" class="filter_required" data-errors="{filter_required:'Ambulance should not be blank!'}"> 
                                    <option value="">Select Ambulance</option>
                                    <?php foreach ($vahicle_info as $amb) {
                                        ?>
                                        <option value="<?php echo $amb->amb_rto_register_no; ?>" <?php
                                        if ((trim($amb->amb_rto_register_no)) == (trim($inc_emp_info[0]->amb_rto_register_no))) {
                                            echo "selected";
                                        }
                                        ?>><?php echo $amb->amb_rto_register_no; ?></option>
                                            <?php } ?>

                                </select>
                                <input id="add_pcr_amb" class=" onpage_popup float_right" name="add_amb" value="Add Ambulance" data-href="{base_url}/amb/add_amb" data-qr="output_position=popup_div&amp;tool_code=add_ambu" data-popupwidth="1000" data-popupheight="800" type="button" style="display:none;">
        <!--                              <input name="amb_reg_id" tabindex="5" class="form_input filter_required" placeholder=" Ambulance No" type="text" data-base="search_btn" data-errors="{filter_required:'Ambulance No should not be blank!'}" value="<?= @$inc_emp_info[0]->amb_rto_register_no; ?>">-->
                            </div>
                        </div>
                        <div class="width50 drg float_left">
                            <div class="width33 float_left">
                                <div class="style6 float_left">Ambulance Category<span class="md_field">*</span> : </div>
                            </div>
                            <div class="width_62 float_left">
                                <input name="category" tabindex="29" class="form_input filter_required" placeholder=" Category" type="text" data-base="search_btn" data-errors="{filter_required:'Category should not be blank!'}" value="<?= @$inc_emp_info[0]->ar_name; ?>" readonly="readonly">
                            </div>

                        </div>

                    </div>
                    <div class="width100">
                        <div class="width50 drg float_left">
                            <div class="width33 float_left">
                                <div class="style6 float_left">Doctor ID<span class="md_field">*</span> : </div>
                            </div>
                            <div class="width_62 float_left">
                                <?php //var_dump($inc_emp_info); ?>
<!--                                <input name="emt_name" tabindex="24" class="form_input filter_required" placeholder="EMT Name" type="text" data-base="search_btn" data-errors="{filter_required:'EMT Name should not be blank!'}" value="<?= $inc_emp_info[0]->emt_name; ?>" >-->
                                <input name="emt_id" class="mi_autocomplete filter_required" data-href="<?php echo base_url(); ?>auto/get_emso_id?emt=true" data-value="<?= $inc_emp_info[0]->amb_emt_id; ?>" value="<?= $inc_emp_info[0]->amb_emt_id; ?>" type="text" tabindex="1" placeholder="Doctor ID" data-callback-funct="show_emso_id" id="emt_list" data-errors="{filter_required:'Doctor Name should not be blank!'}">
                            </div>
                        </div>
                        <div class="width50 drg float_left">
                            <div class="width33 float_left">
                                <div class="style6 float_left">Doctor Name<span class="md_field">*</span> : </div>
                            </div>
                            <div class="width_62 float_left" id="show_emso_name">
                                <input name="emt_name" tabindex="25" class="form_input filter_required" placeholder="Doctor Name" type="text" data-base="search_btn" data-errors="{filter_required:'Doctor Name should not be blank!'}" value="<?= $inc_emp_info[0]->emt_name; ?>">
                                <input name="emt_id" tabindex="25" class="form_input"  type="hidden" value="<?= $inc_emp_info[0]->amb_emt_id; ?>">
                            </div>
                        </div>

                    </div>
                    <div class="width100">
                        <div class="width50 float_left drg">
                            <div class="width33 float_left">
                                <div class="style6 float_left">Pilot ID<span class="md_field">*</span> : </div>
                            </div>
                            <div class="width_62 float_left" id="show_pilot_id">
                                <input name="pilot_id" tabindex="27" class="form_input " placeholder=" Pilot ID" type="text" data-base="search_btn" data-errors="{filter_required:'Pilot ID should not be blank!'}" value="<?= $inc_emp_info[0]->amb_pilot_id; ?>" readonly="readonly">
                            </div>
                        </div>
                        <div class="width50 drg float_left">
                            <div class="width33 float_left">
                                <div class="style6 float_left">Pilot Name<span class="md_field">*</span> : </div>
                            </div>
                            <div class="width_62 float_left">
                                <?php //var_dump($inc_emp_info); ?>
<!--                                <input name="pilot_name" tabindex="26" class="form_input filter_required" placeholder=" Pilot Name " type="text" data-base="search_btn" data-errors="{filter_required:'Pilot Name should not be blank!'}"  value="<?= $inc_emp_info[0]->pilot_name; ?>" readonly="readonly">-->
                                <input name="pilot_name" class="mi_autocomplete " data-href="<?php echo base_url(); ?>auto/get_clg_pilot" data-value="<?= $inc_emp_info[0]->pilot_name; ?>" value="<?= $inc_emp_info[0]->pilot_name; ?>" type="text" tabindex="1" placeholder="Pilot Name" data-callback-funct="show_pilot_id" id="pilot_name_list" data-errors="{filter_required:'Pilot Name should not be blank!'}">
                            </div>
                        </div>


                    </div>

                    <div class="width100">
                        <div class="width100 drg float_left">
                            <div class="width_16 float_left">
                                <div class="style6 float_left">Base Location<span class="md_field">*</span> : </div>
                            </div>
                            <div class="width_83 float_left base_location">
                                <input name="base_location" tabindex="23" class="form_input filter_required" placeholder=" Base Location" type="text" data-base="search_btn" data-errors="{filter_required:'Base Location should not be blank!'}" value="<?= $inc_emp_info[0]->hp_name; ?>" readonly="readonly">
                                 <input name="base_location_id" tabindex="9" class="form_input filter_required" placeholder="Enter Base Location" type="hidden" data-base="search_btn" data-errors="{filter_required:'Base Location should not be blank!'}" value="<?= $inc_emp_info[0]->hp_id; ?>">
                            </div>
                        </div>

                    </div>
                </div>