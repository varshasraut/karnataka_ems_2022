<?php $CI = EMS_Controller::get_instance(); ?>

<div class="filters_groups">                   

    <div class="search">

        <div class="row list_actions">

            <div class="width2 float_right">



                <div class="width75 float_left">
                    <input type="text"  class="controls pre_search" id="pre_search" name="pre_search" value="<?php echo @$pre_search; ?>" placeholder="Search"/>
                </div>

                <div class="width_14 float_right">

                    <input type="button" class="search_button float_right form-xhttp-request" name="" value="Search" data-href="{base_url}medication/medication_list" data-qr="output_position=content&amp;flt=true" />
                </div>

            </div>
        </div>
    </div>

</div>

