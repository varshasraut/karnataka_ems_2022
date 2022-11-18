
                    <div class="width2 float_left">
                        
                        <div class="field_lable float_left width33"><label for="type_model">Type/Model<span class="md_field">*</span></label></div>
                        <div class="filed_input float_left width50" >
                              <input type="text" name="main[type_model]"  value="<?= @$equp_data[0]->eqp_type_model; ?>" class=""  placeholder="Type/Model" data-errors="{filter_required:'Type/Model should not be blank'}" TABINDEX="8" <?php echo $update; echo $Approve; echo $Re_request; ?>>
                              
                           
                           
                        </div>
                    </div>
                    <div class="width2 float_left">
                        
                        <div class="field_lable float_left width33"><label for="type_model">Manufacturer<span class="md_field">*</span></label></div>
                        <div class="filed_input float_left width50" >
                              <input type="text" name="main[manufacturer]" value="<?= @$equp_data[0]->eqp_manufacturer; ?>" class=" "  placeholder="Manufacturer" data-errors="{filter_required:'Type/Model should not be blank'}" TABINDEX="8" <?php echo $update; echo $Approve; echo $Re_request; ?>>
                              
                           
                           
                        </div>
                    </div>
                    <div class="width2 float_left">
                        
                        <div class="field_lable float_left width33"><label for="serial_number">Serial Number<span class="md_field">*</span></label></div>
                        <div class="filed_input float_left width50" >
                              <input type="text" name="main[serial_number]" value="<?= @$equp_data[0]->eqp_serial_number; ?>" class=" "  placeholder="Serial Number" data-errors="{filter_required:'Serial Number should not be blank'}" TABINDEX="8" <?php echo $update; echo $Approve; echo $Re_request; ?>>
                              
                           
                           
                        </div>
                    </div>
                    <div class="width2 float_left">
                        
                        <div class="field_lable float_left width33"><label for="supplier_name">Supplier Name<span class="md_field">*</span></label></div>
                        <div class="filed_input float_left width50" >
                              <input type="text" name="main[supplier_name]" value="<?= @$equp_data[0]->eqp_supplier_name; ?>" class=" "  placeholder="Supplier Name" data-errors="{filter_required:'Supplier Name should not be blank'}" TABINDEX="8" <?php echo $update; echo $Approve; echo $Re_request; ?>>
                              
                           
                           
                        </div>
                    </div>
                    <div class="width2 float_left">
                        
                        <div class="field_lable float_left width33"><label for="supplier_number">Supplier Contact Number<span class="md_field">*</span></label></div>
                        <div class="filed_input float_left width50" >
                              <input type="text" name="main[supplier_number]" value="<?= @$equp_data[0]->eqp_supplier_number; ?>" class=" "  placeholder="Supplier Contact Number" data-errors="{filter_required:'Supplier Contact Number should not be blank'}" TABINDEX="8" <?php echo $update; echo $Approve; echo $Re_request; ?>>
                              
                           
                           
                        </div>
                    </div>