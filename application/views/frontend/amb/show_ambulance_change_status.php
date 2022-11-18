<div class="width100">
                    <div class="width50 drg float_left">
                        <div class="width33 float_left">
                            <div class="style6 float_left">Date<span class="md_field">*</span> : </div>
                        </div>
                        <div class="width50 float_left">
                            <input name="odometer_date" tabindex="0" class="form_input filter_required mi_calender" placeholder="Date" type="text" data-base="search_btn" value=""  data-errors="{filter_required:'Date should not be blank!'}" readonly="readonly">
                        </div>
                    </div>
                    <div class="width50 drg float_left">
                        <div class="width33 float_left">
                            <div class="style6 float_left">Time<span class="md_field">*</span> : </div>
                        </div>
                        <div class="width50 float_left">
                            <input name="odometer_time" tabindex="0" class="form_input filter_required mi_timepicker" placeholder="Time" type="text" data-base="search_btn" value=""  data-errors="{filter_required:'Time should not be blank!'}" readonly="readonly">
                        </div>
                    </div>
                    <div class="width50 drg float_left">
                        <div class="width33 float_left">
                            <div class="style6 float_left">Standard Remark<span class="md_field">*</span> : </div>
                        </div>
                        <div class="width50 float_left">
						
                        <input name="remark"  id="remark_input" class="mi_autocomplete filter_required" data-href="{base_url}auto/get_odometer_remark" data-value="" value="" type="text" tabindex="2" placeholder="Remark" data-callback-funct="show_other_odometer" data-errors="{filter_required:'Remark should not be blank!'}">
                        </div>
                        <div id="odometer_remark_other_textbox">
                            
                        </div>
                    </div>
                    <div class="width50 drg float_left">
                        <div class="width33 float_left">
                            <div class="style6 float_left">Remark<span class="md_field">*</span> : </div>
                        </div>
                        <div class="width50 float_left">
						
                    <input name="common_remark_other" class="filter_required"  value="" type="text" tabindex="2" placeholder="Other Remark" data-errors="{filter_required:' Other Remark should not be blank!'}" >
                        </div>
                    </div>

                </div>