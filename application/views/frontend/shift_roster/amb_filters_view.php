<?php $CI = EMS_Controller::get_instance(); ?>

<div class="filters_groups">                   

    <div class="search">

        <div class="">

            <div class="row width100 float_left">

                <div class="width_20 float_left">
                    <input type="text"  class="controls mob_no" id="mob_no" name="mob_no" value="<?php echo @$mob_no; ?>" data-ignore="ignore" placeholder="Mobile Number"/>  
                </div>

                <div class="width_20 float_left">
                    <input type="text"  class="controls reg_no" id="mob_no" name="rg_no" value="<?php echo @$rg_no; ?>" data-ignore="ignore" placeholder="Register Number"/>
                </div>

                <div class="width_40 float_left">
                    <!-- <input type="text" class="search_catalog" name="amb_item" value="" placeholder="Search"/> -->

                    <input type="button" class="search_button form-xhttp-request mt-0" name="" value="Search" data-href="{base_url}shift_roster/shift_amb_list" data-qr="output_position=content&amp;flt=true" />
                    <input class="search_button click-xhttp-request mt-0" name="" value="Reset Filters" data-href="{base_url}shift_roster/shift_amb_list" data-qr="output_position=content&amp;filters=reset" type="button">

                </div>

            </div>
        </div>
    </div>

</div>

