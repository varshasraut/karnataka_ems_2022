<?php $CI = EMS_Controller::get_instance(); ?>
<div class="head_outer"><h3 class="txt_clr2 width1">  <?php echo $report_name ?> </h3> </div>
<div class="width100">

    <form enctype="multipart/form-data" method="post">

        <div class="width_25 float_left">

            <div class="filed_select">
                <div class="width100 field_row drg float_left">
                    <div class="width100 float_left">
                        <div class="style6 float_left">Select </div>
                    </div>
                    <div class="width100 float_left">  
                        <select name="b12_report_type"  class="change-base-xhttp-request"  data-href="{base_url}erc_reports/b12_report_form_new" data-qr="output_position=content">
                            <option value="">Select Report </option>
                            <option value="1">Datewise</option>
                            <option value="2">Monthwise</option>
                          </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="width50 float_left">
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