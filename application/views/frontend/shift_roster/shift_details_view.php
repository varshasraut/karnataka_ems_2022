<script>
if(typeof H != 'undefined'){
    init_auto_address();
}
</script>

<?php
$CI = EMS_Controller::get_instance();

$bgtype[$ptn[0]->ptn_bgroup_type] = "selected='selected'";

$rtncrd[$ptn[0]->ptn_ration_card] = "checked=''";
?>

<div class="head_outer"><h3 class="txt_clr2 width1">Add Shift</h3> </div>

<form method="post" name="" id="patient_info">

    <input type="hidden" name="amb_rto_register_no" value="<?php echo $amb_rto_register_no; ?>">

    <div class="field_row width100">

        <div class="width2 float_left">
            <div class="field_lable float_left width_30"><label for="shift">Shift</label></div>


            <div class="filed_input float_left width70">
                <input name="shift_name" tabindex="23" class="form_input filter_required" placeholder="Shift" type="text" data-base="search_btn" data-errors="{filter_required:'Shift should not be blank!'}" value="" >




            </div>
        </div>   
        <div class="width2 float_left"> <div class="field_lable float_left width_30"><label for="from_shift">From Time</label></div>

            <div class="filed_input float_left width70">

                <select name="form_shift" id="shift_from_time">
                    <option value="00:00:00">12:00 AM</option>
                    <option value="01:00:00">1:00 AM</option>
                    <option value="02:00:00">2:00 AM</option>
                    <option value="03:00:00">3:00 AM</option>
                    <option value="04:00:00">4:00 AM</option>
                    <option value="05:00:00">5:00 AM</option>
                    <option value="06:00:00">6:00 AM</option>
                    <option value="07:00:00">7:00 AM</option>
                    <option value="08:00:00">8:00 AM</option>
                    <option value="09:00:00">9:00 AM</option>
                    <option value="10:00:00">10:00 AM</option>
                    <option value="11:00:00">11:00 AM</option>
                    <option value="12:00:00">12:00 PM</option>
                    <option value="13:00:00">1:00 PM</option>
                    <option value="14:00:00">2:00 PM</option>
                    <option value="15:00:00">3:00 PM</option>
                    <option value="16:00:00">4:00 PM</option>
                    <option value="17:00:00">5:00 PM</option>
                    <option value="18:00:00">6:00 PM</option>
                    <option value="19:00:00">7:00 PM</option>
                    <option value="20:00:00">8:00 PM</option>
                    <option value="21:00:00">9:00 PM</option>
                    <option value="22:00:00">10:00 PM</option>
                    <option value="23:00:00">11:00 PM</option>
                </select>
            </div>
        </div>


    </div>
    <div class="width100 float_left">


        <div class="width2 float_left">
            <div class="field_lable float_left width_30"><label for="to_shift">To Time</label></div>


            <div class="filed_input float_left width70">

                <select name="to_shift" id="shift_to_time" >
                    <option value="00:00:00">12:00 AM</option>
                    <option value="01:00:00">1:00 AM</option>
                    <option value="02:00:00">2:00 AM</option>
                    <option value="03:00:00">3:00 AM</option>
                    <option value="04:00:00">4:00 AM</option>
                    <option value="05:00:00">5:00 AM</option>
                    <option value="06:00:00">6:00 AM</option>
                    <option value="07:00:00">7:00 AM</option>
                    <option value="08:00:00">8:00 AM</option>
                    <option value="09:00:00">9:00 AM</option>
                    <option value="10:00:00">10:00 AM</option>
                    <option value="11:00:00">11:00 AM</option>
                    <option value="12:00:00">12:00 PM</option>
                    <option value="13:00:00">1:00 PM</option>
                    <option value="14:00:00">2:00 PM</option>
                    <option value="15:00:00">3:00 PM</option>
                    <option value="16:00:00">4:00 PM</option>
                    <option value="17:00:00">5:00 PM</option>
                    <option value="18:00:00">6:00 PM</option>
                    <option value="19:00:00">7:00 PM</option>
                    <option value="20:00:00">8:00 PM</option>
                    <option value="21:00:00">9:00 PM</option>
                    <option value="22:00:00">10:00 PM</option>
                    <option value="23:00:00">11:00 PM</option>
                </select>
            </div>
        </div>
        <div class="width2 float_left">
            <div class="field_lable float_left width_30"><label for="from_shift">Total Hours</label></div>


            <div class="filed_input float_left width70">
                <input name="total_hours" id="shift_total_hours_time" tabindex="11"  placeholder="Total hours" type="text" > 
            </div>
        </div>
    </div> 

    <div class="field_row width100">
        <div class="width40 margin_auto">
            <div class="button_field_row">
                <div class="button_box text_align_center">
                    <input type="button" name="submit" value="Submit" class="btn submit_btnt form-xhttp-request" data-href='<?php echo base_url(); ?>shift_roster/add_shift_type' data-qr='page_no=<?php echo @$page_no; ?>&amp;output_position=content' >
                </div>
            </div>
        </div>
    </div>

</form>
