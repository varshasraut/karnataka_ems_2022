<?php $CI = EMS_Controller::get_instance(); ?>

<div class="filters_groups">                   

    <div class="search">
        
        <div class="row  width100">
            
            <div class="width20 float_left">
                <input type="button" name="Delete" value="Delete" class="delete_sms form-xhttp-request mt-0" data-href="{base_url}hp/del_hp" data-qr="action=delete&amp;page_no=<?php echo @$page_no; ?>&amp;page_record=<?php echo $count_record; ?>" data-confirm='yes' data-confirmmessage="Are you sure to delete hospital ?"> 
            </div>
        
            
                    <div class=" width20 float_left">
                    <select id="mob_no" name="mob_no" >
                        <option value="">Select Status</option>
                        <option value="Active">Active</option>
                        <option value="Inactive">Inactive</option>
                    </select>
                        <!-- <input type="text"  class="controls mob_no" id="mob_no" name="mob_no" value="<?php echo @$mob_no; ?>" data-ignore="ignore" placeholder="Status"/>   -->
                    </div>

                    <div class=" width20 float_left">
                        <input type="text"  class="controls reg_no "  name="h_name" value="<?php echo @$h_name; ?>" data-ignore="ignore" placeholder="Hospital Name OR District OR Type"/>
                    </div>

                    <div class="width20 float_left">
                       <!-- <input type="text" class="search_catalog" name="hp_data" value="" placeholder="Search"/>-->
                        <input type="button" class="search_button form-xhttp-request mt-0" name="" value="Search" data-href="{base_url}hp/<?php echo $filter_function;?>" data-qr="output_position=content&amp;flt=true"/>
                    </div>

            
        </div>
    </div>

</div>

      