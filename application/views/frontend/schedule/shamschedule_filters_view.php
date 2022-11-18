<?php $CI = EMS_Controller::get_instance(); ?>

<div class="filters_groups">                   

    <div class="search">

        <div class="row list_actions">

            <div class="group_action_field_btns">
                <input type="button" name="Delete" value="Delete" class="delete_sms form-xhttp-request" data-href="{base_url}schedule/del_schedule" data-qr="action=delete&amp;page_no=<?php echo @$page_no; ?>&amp;page_record=<?php echo $count_record; ?>" data-confirm='yes' data-confirmmessage="Are you sure to delete Schedule ?"> 
            </div>
        </div>
    </div>

</div>

