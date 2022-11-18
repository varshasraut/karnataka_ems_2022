<?php $CI = EMS_Controller::get_instance(); ?>

<div class="filters_groups">                   

    <div class="search">
         <div class="row list_actions clg_filt">
             
             <div class="group_action_field_btns">

                
                <?php if($CI->modules->get_tool_config('MT-CLG-ACTION-MULTI',$this->active_module,true)!=''){ ?>  

                <input type="button" name="Delete" value="Delete" id="del_clg" class="btn form-xhttp-request" data-href="{base_url}clg/delete_clg" data-qr="output_position=content&amp;module_name=clg&amp;tlcode=MT-CLG-ACTION-MULTI&amp;action=delete&amp;page_no=<?php echo @$page_no;?>" data-confirm='yes' data-confirmmessage="Are you sure to delete colleagues?">

                <?php } ?>


             </div>

            <div class="search_btn_width">
                

                <div class="srch_box_fuel">



                    <input type="text" id="search_clg" placeholder="Search Name" value="<?php echo @$search;?>" name="search">



                    <label for="search_clg">



                        <input type="button" name="search_btn" value="Search" class="btn clg_search form-xhttp-request mt-0" data-href="{base_url}fleet/fire_station" data-qr="output_position=content&amp;filter_search=search&amp;module_name=clg&amp;tlcode=MT-CLG-ACTION-MULTI&amp;action_name=search_clgs" >



                    </label>



                </div>



            </div>
             

        </div>
        
            
    </div>

</div>

      