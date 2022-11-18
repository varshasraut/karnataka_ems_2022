<?php $CI = EMS_Controller::get_instance(); ?>


<div class="filters_groups">   


    <div class="search">


        <div class="row list_actions">

            <div class="grp_actions_width">


                <div class="group_action_field">    
                       <input name="med_amb" class="mi_autocomplete dropdown_per_page width97" data-href="{base_url}auto/get_ambulance" placeholder="Select Ambulance" data-errors="{filter_required:'Please select state from dropdown list'}" tabindex="15" autocomplete="off" value="<?php echo $med_amb; ?>" data-value="<?php echo $med_amb; ?>">

                </div>




                <div class="srch_box">
                    <input type="button" class="search_button form-xhttp-request" name="" value="Search" data-href="{base_url}med/medlist_amb" data-qr="flt=true"/>

                    <input type="hidden" name="pg_no" value="<?php echo $cur_page; ?>">

                </div>

            </div>

        </div>

    </div>

</div>

