<?php $CI = EMS_Controller::get_instance(); ?>

<div class="width100">
<div class="head_outer"><h3 class="txt_clr2 width1"><?php echo $title;?> </h3> </div>
    <form enctype="multipart/form-data"  action="<?php echo base_url(); ?>quality/<?php echo $submit_function; ?>" method="post">

        <div class="width30 ">

            <div class="filed_select">
                <div class="field_row drg float_left">
                    <div class="width100 float_left">
                        <div class="style8 float_left">Select Type: </div>
                    </div>
                    <div class="width100 float_left">  
                        <!--<select name="maintenance_type" id="maintenance_type" class="change-base-xhttp-request" data-base="report_type" data-href="{base_url}quality_forms/<?php echo $submit_function; ?>" data-qr="output_position=content&form_type=<?php echo $form_type;?>" tabindex="7">-->
                        <select name="maintenance_type" class="change-base-xhttp-request" data-base="report_type" data-href="{base_url}erc_reports/load_maintenance_sub_report_form" data-qr="output_position=content">
                            <option value="">Select Maintenance Report Type</option>
<!--                            <option value="all">All Maintenance</option>-->
                            <option value="preventive_maintenance">Preventive Maintenance</option>
                            <option value="onroad_offroad_maintenance">On-road Off-road Maintenance</option>
                            <option value="breakdown_maintenance">Breakdown Maintenance</option>
                            <option value="tyre_life_maintenance">Tyre Life Maintenance</option>
                            <option value="accidental_maintenance">Accidental Maintenance</option>
                        </select>
                    </div>
                </div>
            </div>

        </div>
        <!-- <div class="width50 float_left">
            <div id="Sub_date_report_block_fields" >
            </div>
        </div> -->
        <!-- <div class="width15 float_left">
            <div id="Sub_date_report_block_fields22" >
            </div>
        </div>-->
        <div class="width30 float_left">
            <div id="Sub_report_block_fields" >
            </div>
        </div> 
        <div class="width30 float_left">
            <div id="Sub_date_report_block_fields" >
            </div>
        </div> 
    </form>
</div>
<div class="box3">    

    <div class="permission_list group_list">

        <div id="list_table" >


        </div>
    </div>
</div>

<iframe name="form_frame" style="height: 1px; width: 1px; border:0px; background: none;"></iframe>