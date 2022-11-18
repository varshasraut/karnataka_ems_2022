<div class="field_lable float_left width33"><label for="end_odometer">Oxygen Filling Type Remark<span class="md_field">*</span></label></div>
                    <div class="width2 float_left" >
                        
                       <textarea style="height:60px;" name="oxygen[of_case_type_remark]" class="" TABINDEX="16" data-maxlen="1600"  data-errors="{filter_required:'Remark should not be blank'}"  <?php if ($oxygen_data[0]->of_case_type_remark != '') { echo "disabled";} ?>> <?= @$oxygen_data[0]->of_case_type_remark; ?></textarea>
                        
                    </div>