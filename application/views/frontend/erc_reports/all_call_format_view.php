<?php $CI = EMS_Controller::get_instance(); ?>
<div class="head_outer"><h3 class="txt_clr2 width1">  <?php echo $report_name ?> </h3> </div>


<div class="width100">

    <form enctype="multipart/form-data"  action="<?php echo base_url(); ?>erc_reports/<?php echo $submit_function; ?>" method="post">

        <div class="width_25 ">

            <div class="filed_select">
                <div class="field_row drg float_left">
                    <div class="width100 float_left">
                        <div class="style6 float_left">Select Incident Report: </div>
                    </div>
                    <div class="width100 float_left">  
                        <select name="report_type_name" class="change-base-xhttp-request" data-base="report_type" data-href="{base_url}erc_reports/load_incident_subreport_form2" data-qr="output_position=content">
                            <option value="">Select Report</option>
                            <option value="1">All Call Format</option>
                        </select>
                    </div>
                </div>
            </div>

        </div>
<!--        <div class="width_16 float_left">
            <div id="Sub_report_block_fields" style="">
            </div>
        </div>
        <div class="width100 ">
            <div id="Sub_date_report_block_fields" style="">
            </div>
        </div>-->
        
         <div class="width_16 float_left">
            <div id="Sub_report_block_fields" >
            </div>
        </div>
        <div class="width50  float_left">
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