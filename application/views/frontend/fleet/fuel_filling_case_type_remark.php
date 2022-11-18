<div class="field_lable float_left width33"><label for="end_odometer">Fuel Filling Type Remark<span class="md_field">*</span></label></div>
                    <div class="width2 float_left" >
                        
                       <textarea style="height:60px;"  name="fuel[ff_case_type_remark]" id="fuel[ff_case_type_remark]" class="filter_required" TABINDEX="16" data-maxlen="1600"  data-errors="{filter_required:'Remark should not be blank'}"  <?php if ($fuel_data[0]->ff_case_type_remark != '') { echo "disabled";} ?>> <?= @$fuel_data[0]->ff_case_type_remark; ?></textarea>
                        
                    </div>