 <div class="field_lable float_left width_10"><label for="email">JAES EMP ID<span class="md_field">*</span></label></div>

                        <div class="filed_input float_left width_23">

                            <input  type="text" data-base="<?= @$current_data[0]->clg_ref_id ?>"  name="clg[clg_jaesemp_id]" class="filter_required filter_minlength[5]"  data-errors="{filter_required:'JAES EMP ID should not be blank',filter_minlength:'JAES EMP ID at min 5 digit long.'}" value="<?= @$current_data[0]->clg_jaesemp_id ?>" maxlength="15" TABINDEX="" <?php echo $view; if (@$update) {
    //echo"disabled";
} ?>>
                        </div>