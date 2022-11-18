<?php $CI = EMS_Controller::get_instance(); ?>


<div class="filters_groups">

    <div class="search">


        <div class="row list_actions">


            <div class="group_action_field_btns">

                <?php if (!$eqp_amb) { ?>

                    <?= $CI->modules->get_tool_html('MT-DEL-INV-EQP', $CI->active_module, 'form-xhttp-request add_catalog_btn float_left', "", "data-confirm='yes' data-confirmmessage='Are you sure to delete ?'"); ?> 

                <?php } ?>

            </div>

            <div class="grp_actions_width">


                <div class="group_action_field">&nbsp;</div>

<!--                <div class="group_action_field">    
                    <select id="filter_dropdown"  name="eqp_amb" class="list_medicines change-xhttp-request float_right" data-href="{base_url}eqp/eqplist" data-qr="output_position=content&amp;flt=true">

                        <option value="" selected="">Select Ambulance</option>

                        <?php echo get_all_amb($eqp_amb); ?>

                    </select>

                </div>-->


                <div class="srch_box">

                    <input type="text" class="search_catalog width_50" name="eqp_name" value="<?php echo $eqp_name; ?>" placeholder="Search"/>

                    <input type="button" class="search_button form-xhttp-request" name="" value="Search" data-href="{base_url}eqp/eqplist" data-qr="flt=true"/>

                    <input type="hidden" name="pg_no" value="<?php echo $cur_page; ?>">


                </div>

            </div>

        </div>

    </div>

</div>


