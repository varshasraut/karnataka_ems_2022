


<div class="call_purpose_form_outer">

    <h3>FEEDBACK CALL</h3>


    <form method="post" name="feedback_call_form" id="feedback_form">

        <input type="hidden" name="cl_purpose" id="" value="<?php echo $cl_purpose; ?>" data-base="search_btn">

        <input type="hidden" name="call_id" id="call_id" value="<?php echo $call_id; ?>">

        <input type="hidden" name="base_month"  value="<?php echo $cl_base_month; ?>" data-base="search_btn">
        <input type="hidden" name="incient[CallUniqueID]" value="<?php echo $CallUniqueID;?>">

        <div class="width100 float_left">

            <div class="form_field width25">

                <div class="label">Type Of Feedback<span class="md_field">*</span></div>

                <div class="input">

                    <input type="text" name="fed_type" id="cftype" tabindex="6" value="" class="mi_autocomplete filter_required" data-href="{base_url}auto/feedback_type"  placeholder="Feedback Type" data-errors="{filter_required:'Please select feedback from dropdown list'}" data-callback-funct="get_fque">

                </div>

            </div> 

        </div>


        <div id="inc_filters">


        </div>


        <div id="inc_details">


        </div>


        <div class="width100">

            <div class="width2 float_left">

                <div class="form_field">

                    <div class="label">Feedback Details<span class="md_field">*</span></div>

                    <div class="input">

                        <textarea tabindex="13" class="text_area width100 filter_required" name="fed_details" rows="5" cols="30" data-errors="{filter_required:'Feedback details should not be blank!'}" data-maxlen="400"></textarea>

                    </div>

                </div> 

            </div>


        </div>


        <div id="fdqa_table">

        </div>




        
       
        <div id="fwdcmp_btn" class="save_btn_wrapper">

        </div>





    </form>


</div>