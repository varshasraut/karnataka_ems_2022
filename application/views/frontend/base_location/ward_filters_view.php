<?php $CI = EMS_Controller::get_instance(); ?>

<div class="filters_groups">                   

    <div class="search">
        
        <div class="row list_actions">
            
            <div class="group_action_field_btns">
                <input type="button" name="Delete" value="Delete" class="delete_sms form-xhttp-request " data-href="{base_url}base_location/del_hp" data-qr="action=delete&amp;page_no=<?php echo @$page_no; ?>&amp;page_record=<?php echo $count_record; ?>" data-confirm='yes' data-confirmmessage="Are you sure to delete hospital ?"> 
            </div>
        
            <div class="grp_actions_width">
                    <div class="group_action_field">
                        <input type="text"  class="controls mob_no" id="mob_no" name="mob_no" value="<?php echo @$mob_no; ?>" data-ignore="ignore" placeholder="Status"/>  
                    </div>

                    <div class="group_action_field">
                        <input type="text"  class="controls reg_no"  name="h_name" value="<?php echo @$h_name; ?>" data-ignore="ignore" placeholder="Hospital Name Or Mobile Number"/>
                    </div>

                    <div class="srch_box">
                       <!-- <input type="text" class="search_catalog" name="hp_data" value="" placeholder="Search"/>-->
                        <input type="button" class="search_button form-xhttp-request float_right mt-0" name="" value="Search" data-href="{base_url}base_location/ward_listing" data-qr="output_position=content&amp;flt=true"/>
                    </div>

            </div>
        </div>
    </div>

</div>

      