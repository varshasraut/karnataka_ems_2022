<div class="width100">

    <form enctype="multipart/form-data" method="post">

        <div class="width_30 float_left">

            <div class="filed_select">
                <div class="width100 field_row drg float_left">
                    <div class="width100 float_left">
                        <div class="style6 float_left">Select District</div>
                    </div>
                    <div class="width100 float_left">  
                        <input name="district" class="mi_autocomplete width97" data-href="{base_url}auto/get_district/MH" placeholder="District" data-errors="{filter_required:'Please select state from dropdown list'}" tabindex="15" autocomplete="off" >
                    </div>
                </div>
            </div>
        </div>
        
        <div class="width_30 float_left">

            <div class="filed_select">
                <div class="width100 field_row drg float_left">
                    <div class="width100 float_left">
                        <div class="style6 float_left">Select </div>
                    </div>
                    <div class="width100 float_left">  
                        <select name="thirdparty_type"  class="change-base-xhttp-request"  data-qr="output_position=content">
                            <option value="">Select Type </option>
                               <?php echo get_third_party(); ?>
                          </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="width_40 float_left">

            <div class="filed_select">
                <div class="width100 field_row drg float_left">
                    <div class="width100 float_left">
                        <div class="style6 float_left">Select </div>
                    </div>
                    <div class="width100 float_left">  
                        <select name="date_month"  class="change-base-xhttp-request"  data-href="{base_url}erc_reports/summary_report_form" data-qr="output_position=content">
                            <option value="">Select Report </option>
                            <option value="1">Datewise</option>
                            <option value="2">Monthwise</option>
                          </select>
                    </div>
                </div>
            </div>
        </div>
      
       
    </form>
</div>


