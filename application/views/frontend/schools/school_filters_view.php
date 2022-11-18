<?php $CI = EMS_Controller::get_instance(); ?>

<div class="filters_groups">                   

    <div class="search">

        <div class="row list_actions">

            <div class="group_action_field_btns">
                <input type="button" name="Delete" value="Delete" class="delete_sms form-xhttp-request" data-href="{base_url}schools/del_school" data-qr="action=delete&amp;page_no=<?php echo @$page_no; ?>&amp;page_record=<?php echo $count_record; ?>" data-confirm='yes' data-confirmmessage="Are you sure to delete School ?"> 
            </div>

            <div class="grp_actions_width">

                <div class="group_action_field width40">
                    <input type="text"  class="controls mob_no" id="mob_no" name="mob_no" value="<?php echo @$mob_no; ?>" placeholder="Mobile Number"/>  
                </div>

                <div class="group_action_field width40">
                    <input type="text"  class="controls reg_no" id="school_name" name="school_name" value="<?php echo @$rg_no; ?>" placeholder="School Name"/>
                </div>

                <div class="srch_box width_20">
                    <!-- <input type="text" class="search_catalog" name="amb_item" value="" placeholder="Search"/> -->

                    <input type="button" class="search_button float_right form-xhttp-request" name="" value="Search" data-href="{base_url}schools/school_listing" data-qr="output_position=content&amp;flt=true" />
                </div>

            </div>
        </div>
    </div>

</div>

