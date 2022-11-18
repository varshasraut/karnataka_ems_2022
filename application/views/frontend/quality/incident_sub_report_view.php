<?php $CI = EMS_Controller::get_instance(); ?>

<div class="width100">

  

        

            <div class="filed_select">
                <div class="field_row drg float_left">
                    <div class="width100 float_left">
                        <div class="style6 float_left">1Select Report: </div>
                    </div>
                    <div class="width100 float_left">  
                        <select name="type" class="change-base-xhttp-request" data-base="report_type" data-href="{base_url}quality_forms/<?php echo $submit_function; ?>" data-qr="output_position=content">
                            <option value="">Select Report</option>
                            <option value="1">Datewise </option>
                            <option value="2">Monthwise</option>
                        </select>
                    </div>
                </div>
            </div>

</div>

