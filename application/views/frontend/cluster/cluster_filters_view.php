<?php $CI = EMS_Controller::get_instance(); ?>

<div class="filters_groups">                   

    <div class="search">

        <div class="row list_actions">


            <div class="float_right width2">

<!--                <div class="group_action_field width30 float_left">
                    <input type="text"  class="controls mob_no" id="mob_no" name="mob_no" value="<?php echo @$mob_no; ?>" placeholder="Mobile Number"/>  
                </div>-->

                <div class=" width2 float_left">
                    <input type="text"  class="controls reg_no" id="cluster_search" name="cluster_search" value="<?php echo @$rg_no; ?>" placeholder="Search" style="width: 90%"/>
                </div>

                <div class=" width2 float_right">
                    <input type="button" class="search_button float_left form-xhttp-request" name="" value="Search" data-href="{base_url}cluster/list_cluster" data-qr="output_position=content&amp;flt=true" />
                        <input class="search_button click-xhttp-request float_right" name="" value="Reset Filters" data-href="{base_url}cluster/list_cluster" data-qr="output_position=content&amp;filters=reset" type="button">
                </div>

            </div>
        </div>
    </div>

</div>

