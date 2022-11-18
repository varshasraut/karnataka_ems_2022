     <?php
                if (!empty($get_odometer)) {

                    $previous_odometer = $get_odometer[0]->start_odmeter;
                }
                ?>
                <div class="width100">
                    <div class="width100 single_record_back">                                     

                        <h3 class=" width_25 float_left">Odometer :</h3>
                        <span class=" float_left" style="    margin-top: 3px;">Previous Odometer: <?php echo @$previous_odometer; ?> </span>
                    </div>

                
                </div>
                <?php
                $odo_disabled = "";
                $previous_odo = $previous_odometer + 1;
                $filter_greterthan = "filter_valuegreaterthan[" . $previous_odo . "]";
                $odometer = $previous_odometer . '-' . $previous_odometer;

                $filter_rangelength = "filter_rangelength[" . $odometer . "]";

                if (!empty($get_odometer)) {

                    $odo_disabled = "readonly='readonly'";
                    $filter_greterthan = "";
                    $filter_rangelength = "";
                }
                ?>
                <div class="width100">
                    <div class="width50 drg float_left">
                        <div class="width50 float_left">
                            <div class="style6 float_left">Start Odometer<span class="md_field">*</span> : </div>
                        </div>
                        <div class="width50 float_left">
                            <input name="start_odmeter" tabindex="20" class="filter_required form_input <?php echo $filter_rangelength; ?> filter_maxlength[8]" placeholder="Enter Start Odometer" type="text" data-base="search_btn" value="<?php echo $get_odometer[0]->start_odmeter; ?>"  data-errors="{filter_required:'Start Odometer should not be blank!',filter_valuegreaterthan:'Start Odometer should greater than or equlto Previous Odometer',filter_rangelength:'Start Odometer should <?php echo $previous_odometer; ?>',filter_maxlength:'Start Odometer at max 7 digit long.'}" id="start_odometer_pcr" <?php echo $odo_disabled; ?>>
                        </div>
                    </div>
                    <div class="width50 drg float_left">
                        <div class="width50 float_left">
                            <div class="style6 float_left">END Odometer<span class="md_field">*</span> : </div>
                        </div>
                        <div class="width50 float_left" id="end_odometer_textbox">
                            <input name="end_odmeter" tabindex="21" id="end_odometer_input" class="filter_required form_input filter_greterthan[start_odometer_pcr] filter_maxlength[8]" placeholder="Enter END Odometer" type="text" data-base="search_btn" value="<?php echo $get_odometer[0]->end_odmeter; ?>"  data-errors="{filter_required:'END Odometer should not be blank!',filter_valuegreaterthan:'End Odometer should greater than Start Odometer',filter_maxlength:'END Odometer at max 7 digit long.'}" <?php echo $odo_disabled; ?>>
                        </div>
                    </div>
                    <div class="width100">

                        <div id="remark_textbox">
                        </div>

                        <div id="odometer_remark_other_textbox">
                        </div>

                    </div>
                    <div class="width100">

                        <div id="show_remark_end_odometer">
                        </div>

                        <div id="end_odometer_remark_other_textbox">
                        </div>

                    </div>
                </div>