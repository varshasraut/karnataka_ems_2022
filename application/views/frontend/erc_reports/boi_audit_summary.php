
<!--<h2>Export <?php echo $report_name; ?> Details</h2> -->
<div class="width100 float_left width69">
    <form enctype="multipart/form-data" action="#" method="post" id="reports_type">
        <div class="field_row float_left width30">

            <div class="filed_select">
                <div class="width100 drg float_left">
                    <div class="width100 float_left">
                        <div class="style6 float_left">Select Report type: </div>
                    </div>
                    <div class="width100 float_left" >

                        <select name="boi_summary_type" class="filter_required change-base-xhttp-request" data-errors="{filter_required:'Month should not be blank!'}" data-href="{base_url}erc_reports/load_boi_summary_type" data-qr="output_position=boi_summary_type">
                            <option value="">Select Type</option>
                            <option value=month_wise>Month Wise</option>
                            <option value="district_wise">District Wise</option>
                        </select>
                    </div>
                </div>


            </div>

        </div>
        <div  class="width50 float_left" id="boi_summary_type">
            
        </div>
    </form>
</div>
<div class="box3 width100">    

    <div class="permission_list group_list">

        <div id="list_table" >


        </div>
    </div>
</div>


<iframe name="form_frame" style="height: 1px; width: 1px; border:0px; background: none;"></iframe>
