<div class="head_outer"><h3 class="txt_clr2 width1">  <?php echo $report_name ?> </h3> </div>
<div class="width100 float_left width69">
    <form enctype="multipart/form-data" action="#" method="post" id="reports_type">
        
         <div class="width_25 float_left ">

            <div class="filed_select width100">
                <div class="field_row drg float_left width100">
                    <div class="width100 float_left">
                        <div class="style6 float_left">Select </div>
                    </div>
                    <div class="width100 float_left">  
                        <select name="ercp_report_type"  class="change-base-xhttp-request"  data-href="{base_url}erc_reports/availability_hourly_report_form" data-qr="output_position=content">
                            <option value="">Select Report </option>
                            <option value="1">Datewise</option>

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