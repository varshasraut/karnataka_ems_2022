<div class="register_outer_block">

    <div class="box3">

        <form method="post" action="" id="manage_team">   
        <div class="breadcrumb float_left">
    <ul>

        <li><span>Manage Team  </span></li>
    </ul>
</div>   

            <input type="hidden" name="rto_no" id="amb_id" value="<?php echo $get_amb_details[0]->amb_rto_register_no; ?>">

            <div class="field_row width100">
                <div class="width2 float_left">
                    <div class="shift width_30 float_left "><label for="sft2">Register Number</label></div>                

                    <div class="shift width70 float_left">

                        <input name="amb_rto_register_no" class="filter_required"  value="<?php echo $get_amb_details[0]->amb_rto_register_no; ?>" type="text" tabindex="1" placeholder="Register Number" data-errors="{filter_required:'Register Number should not blank'}" disabled="">
                    </div>
                </div>

                <div class="width2 float_left">
                    <div class="shift width20 float_left"><label for="sft2">Schedule <span class="md_field">*</span></label></div>                

                    <div class="shift width_78 float_left">
                        <select name="manage_team_schedule" class="filter_required" tabindex="8" id="team_schedule_type" data-errors="{filter_required:'Register Number should not blank'}"> 
                            <option value="">Select Status</option>
                            <option value="daily">Daily</option>
                            <option value="weekly">Weekly</option>
                            <option value="monthly">Monthly</option>
                        </select>
                    </div>
                </div>

            </div>

            <div class="field_row width100">
                <div class="width2 float_left">
                
                    <div class="shift width_30 float_left"><label for="sft1">Shift <span class="md_field">*</span></label></div>

                    <div class="shift width70 float_left">
                        <select name="manage_team_shift" class="filter_required" tabindex="8" id="shift_id" data-errors="{filter_required:'Register Number should not blank'}"> 
                            <option value="">Select Status</option>
                            <?php
                            foreach ($shift_info as $shift) {
                                echo "<option value='" . $shift->shift_id . "'  ";
                                echo" > " . $shift->shift_name;
                                echo "</option>";
                            }
                            ?>

                        </select>
                    </div>
                    <div class="width100" id="shift_time">
                    </div>
                </div>
                <div class="width2 float_left" id="canlender_div_outer">

                </div>




            </div>
            <div class="width100">

                <div id="ptn_form_lnk" class="style6 float_left">

                    <a data-href='<?php echo base_url(); ?>shift_roster/amb_shift_details' class='click-xhttp-request style1' data-qr='amb_rto_register_no=<?php echo $get_amb_details[0]->amb_rto_register_no ?>' data-popupwidth='1250' data-popupheight='870'>( Add shift )</a>

                </div>

            </div>
            <div id="shift_districts_id">
            <div class="field_row width100">
                <div class="width2 float_left">    
                    <div class="field_lable float_left width_30"><label for="district">District <span class="md_field">*</span></label></div>
                    <div class="filed_input float_left width70">

                        <input type="text" name="gri[gc_district_code]" data-value="<?= @$grievance_data[0]->dst_name ?>" value="<?= @$grievance_data[0]->dst_code; ?>" class="mi_autocomplete "  data-href="<?php echo base_url() ?>auto/get_district/MP"  placeholder="District" TABINDEX="8" <?php echo $autofocus; ?>  <?php echo $update; ?> <?php echo $view; ?> data-callback-funct="get_base_location">
                    </div>
                </div>

                <div class="width2 float_left">
                    <div class="field_lable float_left width20"><label for="district">Base Location <span class="md_field">*</span></label></div>
                    <div class="filed_input float_left width_78" id="amb_base_location">
                        <input name="stat[sc_base_location]" tabindex="23" class="form_input filter_required" placeholder=" Base Location" type="text" data-base="search_btn" data-errors="{filter_required:'Base Location should not be blank!'}" value="<?= @$fuel_data[0]->hp_name; ?>" readonly="readonly"   <?php echo $update; ?>>
                    </div>
                </div>

            </div>
            </div>
            <div id="team_listing_block">
            </div>

            <div class="field_row width100">
                <div class="width40 margin_auto">
                    <div class="button_field_row text_center">
                        <div class="button_box">
                            <input type="hidden" name="submit_amb_team" value="sub_amb_team" />
                            <input type="button" name="submit" value="Submit" class="btn submit_btnt form-xhttp-request" data-href='<?php echo base_url(); ?>shift_roster/add_manage_team' data-qr='page_no=<?php echo @$page_no; ?>&amp;output_position=content' >
                            <input type="reset" name="reset" value="Reset" class="btn reset_btn register_view_reset">
                        </div>
                    </div>
                </div>
            </div>

        </form>                
    </div>       
</div>