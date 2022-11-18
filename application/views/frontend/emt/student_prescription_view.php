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

<div class="head_outer"><h3 class="txt_clr2 width1">Prescription
            <div class="form_field width25 float_right">
                        <div class="input">

                            <select name="hair" class="filter_required"  data-errors="{filter_required:'Please select hair color'}" data-base="" tabindex="6">
                                <option value="">Previous visit</option>
                                <option value="25_agu">25 Aug 2018</option>
                                <option value="25_agu">20 Aug 2018</option>
                                <option value="25_agu">15 Aug 2018</option>
                            </select>

                        </div>
        </div></h3> </div>

<form method="post" name="" id="patient_info">


    <input type="hidden" name="schedule_id" value="<?php echo $schedule_id; ?>">

    <input type="hidden" name="student_id" value="<?php echo $student_id; ?>">




    <div class="half_div_left">

        <div class="row display_inlne_block">
            <div class="form_field width100 select float_left">
                <div class="label">Diagnosis</div>
                        <div class="input top_left">
                            <input name="diagnosis_name" value="<?php echo $medical_data[0]->diagnosis_name; ?>"  class="form_input mi_autocomplete filter_required" placeholder="Diagnosis" data-href="{base_url}auto/get_auto_diagosis_code" data-errors="{filter_required:'Please select pulse from dropdown list'}" type="text" data-value="<?php echo $ins_procedure[0]->diagnosis_title; ?>" tabindex="6">

               </div>
            </div>

        </div>

    </div>

        
        <div class="display_inlne_block width100">
            <table class="student_screening">
                <tr>
                    <th>Drug name</th>
                    <th>Dose</th>
                    <th>Days</th>
                </tr>
                <?php foreach($drugs as $drug){ ?>
                <tr>
                    <td><?php echo $drug->drug_title; ?>
                        <input type="hidden" name="drug[<?php echo $drug->id; ?>]name]" value="<?php echo $drug->id; ?>">
                        <input type="hidden" name="drug[<?php echo $drug->id; ?>][id]" value="<?php echo $drug->id; ?>">
                    </td>
                    <td>
                       <select name="drug[<?php echo $drug->id; ?>][dose]" class=" width100"  data-errors="{filter_required:'Please select No of swollen joints'}" data-base="" tabindex="6">
                            <option value="">Select</option>
                            <option value="1-1-1">1-1-1</option>
                            <option value="1-1-0">1-1-0</option>
                            <option value="1-0-1">1-0-1</option>
                            <option value="1-0-0">1-0-0</option>
                            <option value="0-1-1">0-1-1</option>
                            <option value="0-1-0">0-1-0</option>
                            <option value="0-0-1">0-0-1</option>
                        </select>
                    </td>
                    <td>
                         <select name="drug[<?php echo $drug->id; ?>][days]" class=" width100"  data-errors="{filter_required:'Please select Days'}" data-base="" tabindex="6">
                            <option value="">Select</option>
                            <?php for($i=1;$i<=50;$i++){ ?>
                             <option value="<?php echo $i;?>"><?php echo $i;?></option>
                            <?php } ?>
                        </select>
                    </td>
                </tr>
                <?php } ?>
                

         
            </table>
        </div>




    <div class="save_btn_wrapper float_left">


        <input type="button" name="accept" value="Submit" class="accept_btn form-xhttp-request" data-href='{base_url}emt/save_prescription' data-qr="output_position=pat_details_block"  tabindex="25">


    </div>

    <div class="width100 float_left">
        <br>
    </div>



</form>
