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

<div class="head_outer"><h3 class="txt_clr2 width1">Sick Room Treatment</h3> </div>

<form method="post" name="" id="sick_room">

    <input type="hidden" name="schedule_id" value="<?php echo $schedule_id; ?>">

    <input type="hidden" name="student_id" value="<?php echo $student_id; ?>">



    <div class="width100">
                <div class="form_field width100 select float_left">
                        <div class="label">Doctor's notes</div>
                        <div class="input top_left">
                            
                            <textarea name="doctor_note"><?php echo $stud_sickroom[0]->doctor_note;?></textarea>

                        </div>
                </div>
                        <div class="form_field width100 select float_left">
                        <div class="label">Treatment Orders</div>
                        <div class="input top_left">
                            <textarea name="treatment_order"><?php echo $stud_sickroom[0]->treatment_order;?></textarea>
                        </div>
                </div>
           
        
    </div>
        <div class="save_btn_wrapper float_left">


        <input type="button" name="accept" value="Submit" class="accept_btn form-xhttp-request" data-href='{base_url}emt/save_sickroom' data-qr="output_position=content"  tabindex="25">


    </div>

    <div class="width100 float_left">
       
    </div>
</form>