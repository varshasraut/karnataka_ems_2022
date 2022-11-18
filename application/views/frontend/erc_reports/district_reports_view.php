
<div class="width100">

    <div class="field_row">

        <div class="filed_select">
            <div class="width30 drg float_left">
                <div class="width100 float_left">
                    <div class="style6 float_left">Select District: </div>
                </div>
                <div class="width100 float_left">


                    <select name="incient_district" class="filter_required" data-errors="{filter_required:'District should not be blank!'}">
                        <option value="">Select District</option>
                        <?php foreach ($district_data as $key) { ?>
                            <option value="<?php echo $key->dst_code ?>"><?php echo $key->dst_name ?></option>
                        <?php }
                        ?>

                    </select>
                </div>
            </div>

        </div>


    </div>
    <div class="field_row float_left width30">

            <div class="filed_select">
                <div class="width100 drg float_left">
                    <div class="width100 float_left">
                        <div class="style6 float_left">Select Month: </div>
                    </div>
                    <div class="width100 float_left" >

                        <select name="from_date" class="filter_required" data-errors="{filter_required:'Month should not be blank!'}">
                            <option value="">Select Month</option>
                            <?php
                            for ($i = 0; $i <= 1; $i++) {
                                $current_date = time();
                                $month = date('M Y', strtotime('-' . $i . ' Months', $current_date));
                                $month_value = date('Y-m-01', strtotime('-' . $i . ' Months', $current_date));

                                echo '<option value="' . $month_value . '">' . $month . '</option>';
                            }
                            ?>

                        </select>
                    </div>
                </div>
            </div>

        </div>
    <div class="width_25 float_left" style="margin-top: 10px;">
        <div class="button_field_row">
            <div class="button_box">

<!--                    <input type="submit" name="submit" value="Submit" TABINDEX="3">  -->
                <input type="button" name="submit"  value="Submit" data-qr="output_position=list_table&amp;reports=view&amp;module_name=reports&amp;showprocess=yes" data-href="<?php echo base_url(); ?>erc_reports/<?php echo $submit_function; ?>" class="form-xhttp-request btn clg_search" >
            </div>
        </div>
    </div>
</div>
<iframe name="form_frame" style="height: 1px; width: 1px; border:0px; background: none;"></iframe>