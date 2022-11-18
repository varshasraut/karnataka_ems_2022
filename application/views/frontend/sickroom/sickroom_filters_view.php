<?php $CI = EMS_Controller::get_instance(); ?>

<div class="filters_groups">                   

    <div class="search">

        <div class="row list_actions">

            <div class="width2 float_right">



                <div class="width75 float_left">
                    <input type="text"  class="controls pre_search" id="sick_search" name="sick_search" value="<?php echo @$sick_search; ?>" placeholder="Search"/>
                </div>

                <div class="width_14 float_right">

                    <input type="button" class="search_button float_right form-xhttp-request" name="" value="Search" data-href="{base_url}sickroom/sickroom_stud_list" data-qr="output_position=content&amp;flt=true" />
                </div>

            </div>
        </div>
    </div>

</div>

