<?php $CI = EMS_Controller::get_instance(); ?>

 <div class="filters_groups">                   
    <div class="search">
        <div class="row list_actions">
            <?php if($show_approve == 1){?>
                <div class="float_left width20">
                     <input type="button" class="search_button float_left form-xhttp-request" name="" value="Approve" data-href="{base_url}schedule/approve_schedule" data-qr="output_position=content&isaprove=1" />
                </div>
            <?php }?>
            <div class="float_left width40">
                <div class="float_left width50">
                    <input type="text"  class="controls schedule_item" id="schedule_item" name="schedule_item" value="<?php echo @$schedule_item; ?>" placeholder="Search"/>  
                </div>
                <div class="width_33 float_left">
                    <input type="button" class="search_button float_left form-xhttp-request" name="" value="Search" data-href="{base_url}schedule/schedule_listing" data-qr="output_position=content&amp;flt=true" />
                      <input class="search_button click-xhttp-request float_right" name="" value="Reset Filters" data-href="{base_url}schedule/schedule_listing" data-qr="output_position=content&amp;filters=reset" type="button">
                </div>
            </div>
            <div class="float_left width40">
                <div class="float_left width50">
     
                    <select name="filter">
                        <option value="">Select Filter</option>
                        <option value="0" <?php if($filter=='0'){ echo "selected"; } ?>>Not Approve</option>
                        <option value="1"  <?php if($filter=='1'){ echo "selected"; } ?>>Approve</option>
                    </select>
                </div>
                <div class="width_33 float_left">
                    <input type="button" class="search_button float_right form-xhttp-request" name="" value="Filter" data-href="{base_url}schedule/schedule_listing" data-qr="output_position=content&amp;flt=true" />
                </div>

            </div>

        </div>
    </div>
</div>