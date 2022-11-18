<?php $CI = EMS_Controller::get_instance(); ?>

<div class="width100">
<div class="head_outer"><h3 class="txt_clr2 width1"><?php echo $title;?> </h3> </div>
    <form enctype="multipart/form-data"  action="<?php echo base_url(); ?>quality/<?php echo $submit_function; ?>" method="post">

        <div class="width10 ">

            <div class="filed_select">
                <div class="field_row drg float_left">
                    <div class="width100 float_left">
                        <div class="style6 float_left">Select Report: </div>
                    </div>
                    <div class="width100 float_left">  
                        <select name="report_type" id="report_type" class="change-base-xhttp-request" data-base="report_type" data-href="{base_url}quality_forms/<?php echo $submit_function; ?>" data-qr="output_position=content&form_type=<?php echo $form_type;?>" tabindex="7">
                            <option value="">Select Report</option>
                            <option value="ERO">ERO Report</option>
                            <option value="DCO">DCO Report</option>
                            <!-- <option value="ERCP">ERCP Report</option>
                            <option value="Fire">Fire Report</option>
                            <option value="Police">Police Report</option>
                            <option value="Griviance">Griviance Report</option>
                            <option value="Feedback">Feedback Report</option> -->
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
        <div class="width90 float_left">
            <div id="Sub_report_block_fields" >
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