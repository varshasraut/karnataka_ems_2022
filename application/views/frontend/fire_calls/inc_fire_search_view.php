<div class="filed_input width1 float_left">
    <div class="radio_button_div">
        <input data-base="<?= @$current_data[0]->clg_ref_id ?>"  onchange="on_change_incident_search();" type="radio" name="incident" value="incident_search"  class="" data-errors="{}" TABINDEX="14"  <?php echo $view; ?>> Incident Search
    </div>

    <div class="radio_button_div">
        <input data-base="<?= @$current_data[0]->clg_ref_id ?>"   onchange="on_change_manual_call();" type="radio" name="incident" value="manual_call"   class="" TABINDEX="15"  <?php echo $view; ?>> Manual Call 
    </div>

</div>
<!--




<script>cur_pcr_step(1);</script>

<div class="call_purpose_form_outer">

    <div class="head_outer"><h3 class="txt_clr2 width1">CALL INFORMATION</h3> </div>

    <form method="post" name="" id="call_dls_info">

        <div class="inline_fields width100">

            <div class="form_field width100 pos_rel">

                <div class="outer_id width100">

                    <div class="float_left width_10"><h3>Incident Id <span class="md_field">*</span></h3></div>


                    <div class="input float_left width_16">

                        <input name="inc_ref_id" tabindex="1" class="form_input filter_required" placeholder="Enter Incident Id" type="text" data-base="search_btn" data-errors="{filter_required:'Incident Id should not be blank!'}" >

                    </div>
                    <div class="float_left  ">

                        <input name="search_btn" value="SEARCH" class="style3 base-xhttp-request" data-href="{base_url}fire_calls/fire_call_details" data-qr="output_position=content" type="button">

                    </div> 
                </div>





            </div>

        </div>



    </form>


</div>-->
<script>

    function  on_change_incident_search() {
        xhttprequest($(this), base_url + 'fire_calls/fire_incident_search', 'f_id=' + '1');
    }

    function  on_change_manual_call() {
        xhttprequest($(this), base_url + 'fire_calls/fire_manual_call', 'f_id=' + '1');
    }
</script>