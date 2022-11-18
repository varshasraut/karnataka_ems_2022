<?php $CI = EMS_Controller::get_instance(); ?>

<div class="filters_groups">                   

    <div class="search">

        <div class="row list_actions">

            <div class="group_action_field_btns">
                <input type="button" name="Delete" value="Delete" class="delete_sms form-xhttp-request mt-0" data-href="{base_url}amb/del_amb" data-qr="action=delete&amp;page_no=<?php echo @$page_no; ?>&amp;page_record=<?php echo $count_record; ?>" data-confirm='yes' data-confirmmessage="Are you sure to delete ambulance ?"> 
            </div>

            <div class="grp_actions_width">

                <div class="group_action_field">
                    <input type="text"  class="controls mob_no"  name="amb_search" value="<?php echo @$mob_no; ?>" data-ignore="ignore" placeholder="Search Status Or Type"/>  
                </div>

                <div class="group_action_field">
                    <input type="text"  class="controls reg_no" name="search_amb" value="<?php echo @$rg_no; ?>" data-ignore="ignore" placeholder="Search"/>
                </div>
                
                
                
                
<!--                     <div class="group_action_field">
                    <input type="text"  class="controls reg_no" name="amb_search" value="<?php echo @$rg_no; ?>" data-ignore="ignore" placeholder="Search Status Or Type"/>
                </div>-->

                <div class="srch_box">
                    <!-- <input type="text" class="search_catalog" name="amb_item" value="" placeholder="Search"/> -->

                    <input type="button" class="search_button float_right form-xhttp-request mt-0" name="" value="Search" data-href="{base_url}amb/amb_listing" data-qr="output_position=content&amp;flt=true" />
                </div>

            </div>
        </div>
    </div>

</div>

