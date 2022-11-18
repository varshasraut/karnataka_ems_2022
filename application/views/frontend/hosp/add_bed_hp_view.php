<script>
    if(typeof H != 'undefined'){
        init_auto_address();
    }
</script>


<?php
$CI = EMS_Controller::get_instance();


?> 
<form enctype="multipart/form-data" action="#" method="post" id="hp_form">

<div class="width1 float_left">

    <div class="box3">
    <?php 
    if($clg_group=='UG-ERO')
    { 
      $disabled = 'disabled' ;
    } 
?>
  <input type="hidden" value="<?php echo $hp_id ; ?>" name="hp_id">  

            <h2 class="txt_clr2 width1 txt_pro"><?php echo $title; ?></h2>
            <div class="store_details_box">
                <div class="field_row width100">
                    <div class="field_lable float_left width10"> <label for="hp_name">Hospital Name<span class="md_field">*</span></label></div>
                    <div class="filed_input float_left width30">
                    <input <?php echo $disabled; ?> id="hp_name" type="text" name="hp_name" class="filter_required controls"  data-errors="{filter_required:'Facility name should not be blank'}" value="<?php echo $hp_name; ?>"placeholder="Hospital Name" TABINDEX="1" >
                    </div>
                    <div class="field_lable float_left width10"> <label for="hp_name">Date & Time<span class="md_field">*</span></label></div>
                    <div class="filed_input float_left width20">
                    <input  id="date_time" value="<?php echo $hospital_data[0]->actual_datetime; ?>" type="text" name="date_time" class="filter_required mi_timecalender" data-errors="{filter_required:'Date & time should not be blank'}" placeholder="Select Date time" TABINDEX="1"  <?php echo $disabled; ?> >
                    </div>
                    <div class="field_lable float_left width10"> <label for="hp_name">Added by Name<span class="md_field">*</span></label></div>
                    <div class="filed_input float_left width20">
                    <input  id="added_name" value="<?php echo $hospital_data[0]->added_name; ?>" type="text" name="added_name" class="filter_required"  data-errors="{filter_required:'Name should not be blank'}" placeholder="Enter Name" TABINDEX="1" <?php echo $disabled; ?> >
                    </div>
                </div>
                
                <table class="table report_table">

                    <tr>                
                        <th width="20%">Name</th>
                        <th width="35%">Type</th>
                        <th>Total Beds</th>
                        <th>Occupied</th>
                        <th>Vacant</th>
                        <th width="20%">Remarks</th>
                       
                    </tr>
                    
                    <tr>
                        <td>Type of facility required</td>                            
                        <td>COVID-19</td> 
                        <td style="padding-top:7px;"> <input readonly  onkeyup="this.value=this.value.replace(/[^\d]/,'')"  id="C19_Total_Beds" type="text" name="bed[C19_Total_Beds]" TABINDEX="1" placeholder="Enter Total Bed" value="<?php  echo $hospital_data[0]->C19_Total_Beds; ?>" <?php echo $disabled; ?>></td> 
                        <td  style="padding-top:7px;"> <input readonly  onkeyup="this.value=this.value.replace(/[^\d]/,'')"  id="C19_Occupied" type="text" name="bed[C19_Occupied]" TABINDEX="2" placeholder="Enter Occupied Bed" value="<?php echo $hospital_data[0]->C19_Occupied; ?>" <?php echo $disabled; ?>></td> 
                        <td  style="padding-top:7px;"> <input  readonly  onkeyup="this.value=this.value.replace(/[^\d]/,'')"  id="C19_Vacant" type="text" name="bed[C19_Vacant]"  TABINDEX="3" placeholder="Enter Vacant Bed" value="<?php echo $hospital_data[0]->C19_Vacant; ?>" <?php echo $disabled; ?>></td> 
                        <td  style="padding-top:7px;"> <input readonly  id="C19_Remarks" type="text" name="bed[C19_Remarks]"  TABINDEX="4" placeholder="Enter Remark" value="<?php echo $hospital_data[0]->C19_Remarks; ?>" <?php echo $disabled; ?>></td> 
                    </tr>
                  <!--  <tr>
                        <td></td>                            
                        <td>Non-COVID-19</td> 
                        <td> <input onkeyup="this.value=this.value.replace(/[^\d]/,'')"  id="NonC19_Total_Beds" type="text" name="bed[NonC19_Total_Beds]" TABINDEX="5" placeholder="Enter Total Bed" value="<?php echo $hospital_data[0]->NonC19_Total_Beds; ?>" <?php echo $disabled; ?>></td> 
                        <td> <input onkeyup="this.value=this.value.replace(/[^\d]/,'')"  id="NonC19_Occupied" type="text" name="bed[NonC19_Occupied]" TABINDEX="6" placeholder="Enter Occupied Bed" value="<?php echo $hospital_data[0]->NonC19_Occupied; ?>" <?php echo $disabled; ?>></td> 
                        <td> <input onkeyup="this.value=this.value.replace(/[^\d]/,'')"  id="NonC19_Vacant" type="text" name="bed[NonC19_Vacant]"  TABINDEX="7" placeholder="Enter Vacant Bed" value="<?php echo $hospital_data[0]->NonC19_Vacant; ?>" <?php echo $disabled; ?>></td> 
                        <td> <input  id="NonC19_Remarks" type="text" name="bed[NonC19_Remarks]"  TABINDEX="8" placeholder="Enter Remark" value="<?php echo $hospital_data[0]->NonC19_Remarks; ?>" <?php echo $disabled; ?>></td> 
                    </tr>-->
                    <tr>
                        <td>ICU beds without ventilator</td>                            
                        <td></td> 
                        <td> <input onkeyup="this.value=this.value.replace(/[^\d]/,'')"  id="ICUWoVenti_Total_Beds" type="text" name="bed[ICUWoVenti_Total_Beds]" TABINDEX="9" placeholder="Enter Total Bed" value="<?php echo $hospital_data[0]->ICUWoVenti_Total_Beds; ?>" <?php echo $disabled; ?>></td> 
                        <td> <input class="filter_lessthan[ICUWoVenti_Total_Beds]" data-errors="{filter_lessthan:'Less than Total Beds'}" dataonkeyup="this.value=this.value.replace(/[^\d]/,'')"  id="ICUWoVenti_Occupied" type="text" name="bed[ICUWoVenti_Occupied]" TABINDEX="10" placeholder="Enter Occupied Bed" value="<?php echo $hospital_data[0]->ICUWoVenti_Occupied; ?>" <?php echo $disabled; ?>></td> 
                        <td> <input readonly onkeyup="this.value=this.value.replace(/[^\d]/,'')"  id="ICUWoVenti_Vacant" type="text" name="bed[ICUWoVenti_Vacant]"  TABINDEX="11" placeholder="Enter Vacant Bed" value="<?php echo $hospital_data[0]->ICUWoVenti_Vacant; ?>" <?php echo $disabled; ?>></td> 
                        <td> <input  id="ICUWoVenti_Remarks" type="text" name="bed[ICUWoVenti_Remarks]"  TABINDEX="12" placeholder="Enter Remark" value="<?php echo $hospital_data[0]->ICUWoVenti_Remarks; ?>" <?php echo $disabled; ?>></td> 
                     </tr>
                    <tr>
                        <td>ICU beds with ventilator</td>                            
                        <td></td> 
                        <td> <input onkeyup="this.value=this.value.replace(/[^\d]/,'')"  id="ICUwithVenti_Total_Beds" type="text" name="bed[ICUwithVenti_Total_Beds]" TABINDEX="13" placeholder="Enter Total Bed" value="<?php echo $hospital_data[0]->ICUwithVenti_Total_Beds; ?>" <?php echo $disabled; ?>></td> 
                        <td> <input class="filter_lessthan[ICUwithVenti_Total_Beds]" data-errors="{filter_lessthan:'Less than Total Beds'}" onkeyup="this.value=this.value.replace(/[^\d]/,'')"  id="ICUwithVenti_Occupied" type="text" name="bed[ICUwithVenti_Occupied]" TABINDEX="14" placeholder="Enter Occupied Bed" value="<?php echo $hospital_data[0]->ICUwithVenti_Occupied; ?>" <?php echo $disabled; ?>></td> 
                        <td> <input readonly onkeyup="this.value=this.value.replace(/[^\d]/,'')"  id="ICUwithVenti_Vacant" type="text" name="bed[ICUwithVenti_Vacant]"  TABINDEX="15" placeholder="Enter Vacant Bed" value="<?php echo $hospital_data[0]->ICUwithVenti_Vacant; ?>" <?php echo $disabled; ?>></td> 
                        <td> <input   id="ICUwithVenti_Remarks" type="text" name="bed[ICUwithVenti_Remarks]"  TABINDEX="16" placeholder="Enter Remark" value="<?php echo $hospital_data[0]->ICUwithVenti_Remarks; ?>" <?php echo $disabled; ?>></td> 
                     </tr>
                    <tr>
                        <td>Dialysis bed</td>                            
                        <td></td> 
                        <td> <input onkeyup="this.value=this.value.replace(/[^\d]/,'')"  id="ICUwithdialysisBed_Total_Beds" type="text" name="bed[ICUwithdialysisBed_Total_Beds]" TABINDEX="17" placeholder="Enter Total Bed" value="<?php echo $hospital_data[0]->ICUwithdialysisBed_Total_Beds; ?>" <?php echo $disabled; ?>></td> 
                        <td> <input class="filter_lessthan[ICUwithdialysisBed_Total_Beds]" data-errors="{filter_lessthan:'Less than Total Beds'}" onkeyup="this.value=this.value.replace(/[^\d]/,'')"  id="ICUwithdialysisBed_Occupied" type="text" name="bed[ICUwithdialysisBed_Occupied]" TABINDEX="18" placeholder="Enter Occupied Bed" value="<?php echo $hospital_data[0]->ICUwithdialysisBed_Occupied; ?>" <?php echo $disabled; ?>></td> 
                        <td> <input readonly onkeyup="this.value=this.value.replace(/[^\d]/,'')"  id="ICUwithdialysisBed_Vacant" type="text" name="bed[ICUwithdialysisBed_Vacant]"  TABINDEX="19" placeholder="Enter Vacant Bed" value="<?php echo $hospital_data[0]->ICUwithdialysisBed_Vacant; ?>" <?php echo $disabled; ?>></td> 
                        <td> <input   id="ICUwithdialysisBed_Remarks" type="text" name="bed[ICUwithdialysisBed_Remarks]"  TABINDEX="20" placeholder="Enter Remark" value="<?php echo $hospital_data[0]->ICUwithdialysisBed_Remarks; ?>" <?php echo $disabled; ?>></td> 
                     </tr>
                    <tr>
                    <tr>
                        <td>Ward</td>                            
                        <td></td> 
                        <td><input onkeyup="this.value=this.value.replace(/[^\d]/,'')"  id="C19Ward_Total_Beds" type="text" name="bed[C19Ward_Total_Beds]" TABINDEX="17" placeholder="Enter Total Bed" value="<?php echo $hospital_data[0]->C19Ward_Total_Beds; ?>" <?php echo $disabled; ?>></td> 
                        <td><input class="filter_lessthan[C19Ward_Total_Beds]" data-errors="{filter_lessthan:'Less than Total Beds'}" onkeyup="this.value=this.value.replace(/[^\d]/,'')"  id="C19Ward_Occupied" type="text" name="bed[C19Ward_Occupied]" TABINDEX="18" placeholder="Enter Occupied Bed" value="<?php echo $hospital_data[0]->C19Ward_Occupied; ?>" <?php echo $disabled; ?>></td> 
                        <td><input readonly onkeyup="this.value=this.value.replace(/[^\d]/,'')"  id="C19Ward_Vacant" type="text" name="bed[C19Ward_Vacant]"  TABINDEX="19" placeholder="Enter Vacant Bed" value="<?php echo $hospital_data[0]->C19Ward_Vacant; ?>" <?php echo $disabled; ?>></td> 
                        <td><input   id="C19Ward_Remarks" type="text" name="bed[C19Ward_Remarks]"  TABINDEX="20" placeholder="Enter Remark" value="<?php echo $hospital_data[0]->C19Ward_Remarks; ?>" <?php echo $disabled; ?>></td> 
                     </tr>
                     <tr>
                        <td>Isolation beds </td>                            
                        <td>COVID19 positive</td> 
                        <td> <input onkeyup="this.value=this.value.replace(/[^\d]/,'')"  id="C19Positive_Total_Beds" type="text" name="bed[C19Positive_Total_Beds]" TABINDEX="21" placeholder="Enter Total Bed" value="<?php echo $hospital_data[0]->C19Positive_Total_Beds; ?>" <?php echo $disabled; ?>></td>
                        <td> <input class="filter_lessthan[C19Positive_Total_Beds]" data-errors="{filter_lessthan:'Less than Total Beds'}" onkeyup="this.value=this.value.replace(/[^\d]/,'')"  id="C19Positive_Occupied" type="text" name="bed[C19Positive_Occupied]" TABINDEX="22" placeholder="Enter Occupied Bed" value="<?php echo $hospital_data[0]->C19Positive_Occupied; ?>" <?php echo $disabled; ?>></td> 
                        <td> <input readonly onkeyup="this.value=this.value.replace(/[^\d]/,'')"  id="C19Positive_Vacant" type="text" name="bed[C19Positive_Vacant]"  TABINDEX="23" placeholder="Enter Vacant Bed" value="<?php echo $hospital_data[0]->C19Positive_Vacant; ?>" <?php echo $disabled; ?>></td> 
                        <td> <input  id="C19Positive_Remarks" type="text" name="bed[C19Positive_Remarks]"  TABINDEX="24" placeholder="Enter Remark" value="<?php echo $hospital_data[0]->C19Positive_Remarks; ?>" <?php echo $disabled; ?>></td> 
                     </tr>
                     <tr>
                        <td></td>                            
                        <td>Central Oxygen</td> 
                        <td> <input onkeyup="this.value=this.value.replace(/[^\d]/,'')"  id="central_oxygen_Total_Beds" type="text" name="bed[central_oxygen_Total_Beds]" TABINDEX="21" placeholder="Enter Total Bed" value="<?php echo $hospital_data[0]->central_oxygen_Total_Beds; ?>" <?php echo $disabled; ?>></td>
                        <td> <input class="filter_lessthan[central_oxygen_Total_Beds]" data-errors="{filter_lessthan:'Less than Total Beds'}" onkeyup="this.value=this.value.replace(/[^\d]/,'')"  id="central_oxygen_Occupied" type="text" name="bed[central_oxygen_Occupied]" TABINDEX="22" placeholder="Enter Occupied Bed" value="<?php echo $hospital_data[0]->central_oxygen_Occupied; ?>" <?php echo $disabled; ?>></td> 
                        <td> <input readonly onkeyup="this.value=this.value.replace(/[^\d]/,'')"  id="central_oxygen_Vacant" type="text" name="bed[central_oxygen_Vacant]"  TABINDEX="23" placeholder="Enter Vacant Bed" value="<?php echo $hospital_data[0]->central_oxygen_Vacant; ?>" <?php echo $disabled; ?>></td> 
                        <td> <input  id="central_oxygen_Remarks" type="text" name="bed[central_oxygen_Remarks]"  TABINDEX="24" placeholder="Enter Remark" value="<?php echo $hospital_data[0]->central_oxygen_Remarks; ?>" <?php echo $disabled; ?>></td> 
                     </tr>
                    <tr>
                        <td>Quarantine Ward </td>                            
                        <td>Suspected COVID</td> 
                        <td> <input onkeyup="this.value=this.value.replace(/[^\d]/,'')"  id="SspectC19_Total_Beds" type="text" name="bed[SspectC19_Total_Beds]" TABINDEX="25" placeholder="Enter Total Bed" value="<?php echo $hospital_data[0]->SspectC19_Total_Beds; ?>" <?php echo $disabled; ?>></td> 
                        <td> <input class="filter_lessthan[SspectC19_Total_Beds]" data-errors="{filter_lessthan:'Less than Total Beds'}" onkeyup="this.value=this.value.replace(/[^\d]/,'')"  id="SspectC19_Occupied" type="text" name="bed[SspectC19_Occupied]" TABINDEX="26" placeholder="Enter Occupied Bed" value="<?php echo $hospital_data[0]->SspectC19_Occupied; ?>" <?php echo $disabled; ?>></td> 
                        <td> <input readonly onkeyup="this.value=this.value.replace(/[^\d]/,'')"  id="SspectC19_Vacant" type="text" name="bed[SspectC19_Vacant]"  TABINDEX="27" placeholder="Enter Vacant Bed" value="<?php echo $hospital_data[0]->SspectC19_Vacant; ?>" <?php echo $disabled; ?>></td> 
                        <td> <input   id="SspectC19_Remarks" type="text" name="bed[SspectC19_Remarks]"  TABINDEX="28" placeholder="Enter Remark" value="<?php echo $hospital_data[0]->SspectC19_Remarks; ?>" <?php echo $disabled; ?>></td> 
                    </tr>
                    <tr>
                        <td>CCC1 - </td>                            
                        <td>Suspected Symptomatic without Comorbidity</td> 
                        <td> <input onkeyup="this.value=this.value.replace(/[^\d]/,'')"  id="SspectSymptWoComorbid_Total_Beds" type="text" name="bed[SspectSymptWoComorbid_Total_Beds]" TABINDEX="29" placeholder="Enter Total Bed" value="<?php echo $hospital_data[0]->SspectSymptWoComorbid_Total_Beds; ?>" <?php echo $disabled; ?>></td> 
                        <td> <input class="filter_lessthan[SspectSymptWoComorbid_Total_Beds]" data-errors="{filter_lessthan:'Less than Total Beds'}" onkeyup="this.value=this.value.replace(/[^\d]/,'')"  id="SspectSymptWoComorbid_Occupied" type="text" name="bed[SspectSymptWoComorbid_Occupied]" TABINDEX="30" placeholder="Enter Occupied Bed" value="<?php echo $hospital_data[0]->SspectSymptWoComorbid_Occupied; ?>" <?php echo $disabled; ?>></td> 
                        <td> <input readonly onkeyup="this.value=this.value.replace(/[^\d]/,'')"  id="SspectSymptWoComorbid_Vacant" type="text" name="bed[SspectSymptWoComorbid_Vacant]"  TABINDEX="31" placeholder="Enter Vacant Bed" value="<?php echo $hospital_data[0]->SspectSymptWoComorbid_Vacant; ?>" <?php echo $disabled; ?>></td> 
                        <td> <input   id="SspectSymptWoComorbid_Remarks" type="text" name="bed[SspectSymptWoComorbid_Remarks]"  TABINDEX="32" placeholder="Enter Remark" value="<?php echo $hospital_data[0]->SspectSymptWoComorbid_Remarks; ?>" <?php echo $disabled; ?>></td> 
                   </tr>
                    <tr>
                        <td></td>                            
                        <td>Suspected Asymptomatic without Comorbidity</td> 
                        <td> <input onkeyup="this.value=this.value.replace(/[^\d]/,'')"  id="SspectASymptWoComorbid_Total_Beds" type="text" name="bed[SspectASymptWoComorbid_Total_Beds]" TABINDEX="33" placeholder="Enter Total Bed" value="<?php echo $hospital_data[0]->SspectASymptWoComorbid_Total_Beds; ?>" <?php echo $disabled; ?>></td>
                        <td> <input class="filter_lessthan[SspectASymptWoComorbid_Total_Beds]" data-errors="{filter_lessthan:'Less than Total Beds'}" onkeyup="this.value=this.value.replace(/[^\d]/,'')"  id="SspectASymptWoComorbid_Occupied" type="text" name="bed[SspectASymptWoComorbid_Occupied]" TABINDEX="34" placeholder="Enter Occupied Bed" value="<?php echo $hospital_data[0]->SspectASymptWoComorbid_Occupied; ?>" <?php echo $disabled; ?>></td> 
                        <td> <input readonly onkeyup="this.value=this.value.replace(/[^\d]/,'')"  id="SspectASymptWoComorbid_Vacant" type="text" name="bed[SspectASymptWoComorbid_Vacant]"  TABINDEX="35" placeholder="Enter Vacant Bed" value="<?php echo $hospital_data[0]->SspectASymptWoComorbid_Vacant; ?>" <?php echo $disabled; ?>></td>
                        <td> <input   id="SspectASymptWoComorbid_Remarks" type="text" name="bed[SspectASymptWoComorbid_Remarks]"  TABINDEX="36" placeholder="Enter Remark" value="<?php echo $hospital_data[0]->SspectASymptWoComorbid_Remarks; ?>" <?php echo $disabled; ?>></td> 
                         </tr>
                    <tr>
                        <td>CCC2 - </td>                            
                        <td>Positive Symptomatic without Comorbidity</td> 
                        <td> <input onkeyup="this.value=this.value.replace(/[^\d]/,'')"  id="PositiveSymptWoComorbid_Total_Beds" type="text" name="bed[PositiveSymptWoComorbid_Total_Beds]" TABINDEX="37" placeholder="Enter Total Bed" value="<?php echo $hospital_data[0]->PositiveSymptWoComorbid_Total_Beds; ?>" <?php echo $disabled; ?>></td> 
                        <td> <input class="filter_lessthan[PositiveSymptWoComorbid_Total_Beds]" data-errors="{filter_lessthan:'Less than Total Beds'}" onkeyup="this.value=this.value.replace(/[^\d]/,'')"  id="PositiveSymptWoComorbid_Occupied" type="text" name="bed[PositiveSymptWoComorbid_Occupied]" TABINDEX="38" placeholder="Enter Occupied Bed" value="<?php echo $hospital_data[0]->PositiveSymptWoComorbid_Occupied; ?>" <?php echo $disabled; ?>></td> 
                        <td> <input readonly onkeyup="this.value=this.value.replace(/[^\d]/,'')"  id="PositiveSymptWoComorbid_Vacant" type="text" name="bed[PositiveSymptWoComorbid_Vacant]"  TABINDEX="39" placeholder="Enter Vacant Bed" value="<?php echo $hospital_data[0]->PositiveSymptWoComorbid_Vacant; ?>" <?php echo $disabled; ?>></td> 
                        <td> <input   id="PositiveSymptWoComorbid_Remarks" type="text" name="bed[PositiveSymptWoComorbid_Remarks]"  TABINDEX="40" placeholder="Enter Remark" value="<?php echo $hospital_data[0]->PositiveSymptWoComorbid_Remarks; ?>" <?php echo $disabled; ?>></td> 
                    </tr>
                    <tr>
                        <td></td>                            
                        <td>Positive Asymptomatic without Comorbidity</td> 
                        <td> <input onkeyup="this.value=this.value.replace(/[^\d]/,'')"  id="PositiveASymptWoComorbid_Total_Beds" type="text" name="bed[PositiveASymptWoComorbid_Total_Beds]" TABINDEX="41" placeholder="Enter Total Bed" value="<?php echo $hospital_data[0]->PositiveASymptWoComorbid_Total_Beds; ?>" <?php echo $disabled; ?>></td> 
                        <td> <input class="filter_lessthan[PositiveASymptWoComorbid_Total_Beds]" data-errors="{filter_lessthan:'Less than Total Beds'}" onkeyup="this.value=this.value.replace(/[^\d]/,'')"  id="PositiveASymptWoComorbid_Occupied" type="text" name="bed[PositiveASymptWoComorbid_Occupied]" TABINDEX="42" placeholder="Enter Occupied Bed" value="<?php echo $hospital_data[0]->PositiveASymptWoComorbid_Occupied; ?>" <?php echo $disabled; ?>></td> 
                        <td> <input readonly onkeyup="this.value=this.value.replace(/[^\d]/,'')"  id="PositiveASymptWoComorbid_Vacant" type="text" name="bed[PositiveASymptWoComorbid_Vacant]"  TABINDEX="43" placeholder="Enter Vacant Bed" value="<?php echo $hospital_data[0]->PositiveASymptWoComorbid_Vacant; ?>" <?php echo $disabled; ?>></td> 
                        <td> <input  id="PositiveASymptWoComorbid_Remarks" type="text" name="bed[PositiveASymptWoComorbid_Remarks]"  TABINDEX="44" placeholder="Enter Remark" value="<?php echo $hospital_data[0]->PositiveASymptWoComorbid_Remarks; ?>" <?php echo $disabled; ?>></td> 
                   </tr>
                    <tr>
                        <td>DCHC - </td>                            
                        <td>Asymptomatic COVID suspected with Comorbidity stable</td> 
                        <td> <input onkeyup="this.value=this.value.replace(/[^\d]/,'')"  id="ASymptC19SspectwithComorbidStable_Total_Beds" type="text" name="bed[ASymptC19SspectwithComorbidStable_Total_Beds]" TABINDEX="45" placeholder="Enter Total Bed" value="<?php echo $hospital_data[0]->ASymptC19SspectwithComorbidStable_Total_Beds; ?>" <?php echo $disabled; ?>></td> 
                        <td> <input class="filter_lessthan[ASymptC19SspectwithComorbidStable_Total_Beds]" data-errors="{filter_lessthan:'Less than Total Beds'}" onkeyup="this.value=this.value.replace(/[^\d]/,'')"  id="ASymptC19SspectwithComorbidStable_Occupied" type="text" name="bed[ASymptC19SspectwithComorbidStable_Occupied]" TABINDEX="46" placeholder="Enter Occupied Bed" value="<?php echo $hospital_data[0]->ASymptC19SspectwithComorbidStable_Occupied; ?>" <?php echo $disabled; ?>></td> 
                        <td> <input readonly onkeyup="this.value=this.value.replace(/[^\d]/,'')"  id="ASymptC19SspectwithComorbidStable_Vacant" type="text" name="bed[ASymptC19SspectwithComorbidStable_Vacant]"  TABINDEX="47" placeholder="Enter Vacant Bed" value="<?php echo $hospital_data[0]->ASymptC19SspectwithComorbidStable_Vacant; ?>" <?php echo $disabled; ?>></td> 
                        <td> <input   id="ASymptC19SspectwithComorbidStable_Remarks" type="text" name="bed[ASymptC19SspectwithComorbidStable_Remarks]"  TABINDEX="48" placeholder="Enter Remark" value="<?php echo $hospital_data[0]->ASymptC19SspectwithComorbidStable_Remarks; ?>" <?php echo $disabled; ?>></td> 
                  </tr>
                    <tr>
                        <td></td>                            
                        <td>Symptomatic COVID suspected with Comorbidity stable</td> 
                        <td> <input onkeyup="this.value=this.value.replace(/[^\d]/,'')"  id="SymptC19SspectwithComorbidStable_Total_Beds" type="text" name="bed[SymptC19SspectwithComorbidStable_Total_Beds]" TABINDEX="49" placeholder="Enter Total Bed" value="<?php echo $hospital_data[0]->SymptC19SspectwithComorbidStable_Total_Beds; ?>" <?php echo $disabled; ?>></td> 
                        <td> <input class="filter_lessthan[SymptC19SspectwithComorbidStable_Total_Beds]" data-errors="{filter_lessthan:'Less than Total Beds'}" onkeyup="this.value=this.value.replace(/[^\d]/,'')"  id="SymptC19SspectwithComorbidStable_Occupied" type="text" name="bed[SymptC19SspectwithComorbidStable_Occupied]" TABINDEX="50" placeholder="Enter Occupied Bed" value="<?php echo $hospital_data[0]->SymptC19SspectwithComorbidStable_Occupied; ?>" <?php echo $disabled; ?>></td> 
                       <!--<td> <input onkeyup="this.value=this.value.replace(/[^\d]/,'')"  id="SymptC19SspectwithComorbidStable_Vacant" type="text" name="bed[SymptC19SspectwithComorbidStable_Vacant ]"  TABINDEX="51" placeholder="Enter Vacant Bed" value="<?php echo $hospital_data[0]->SymptC19SspectwithComorbidStable_Vacant; ?>" <?php echo $disabled; ?>></td>-->
                       <td> <input readonly onkeyup="this.value=this.value.replace(/[^\d]/,'')"  id="SymptC19SspectwithComorbidStable_Vacant" type="text" name="bed[SymptC19SspectwithComorbidStable_Vacant]"  TABINDEX="52" placeholder="Enter Remark" value="<?php echo $hospital_data[0]->SymptC19SspectwithComorbidStable_Vacant; ?>" <?php echo $disabled; ?>></td> 
                        <td> <input   id="SymptC19SspectwithComorbidStable_Remarks" type="text" name="bed[SymptC19SspectwithComorbidStable_Remarks]"  TABINDEX="52" placeholder="Enter Remark" value="<?php echo $hospital_data[0]->SymptC19SspectwithComorbidStable_Remarks; ?>" <?php echo $disabled; ?>></td> 
                 </tr>
                    <tr>
                        <td></td>                            
                        <td>Asymptomatic positive with  Comorbidity stable</td> 
                        <td> <input onkeyup="this.value=this.value.replace(/[^\d]/,'')"  id="ASymptPositivewithComorbidStable_Total_Beds" type="text" name="bed[ASymptPositivewithComorbidStable_Total_Beds]" TABINDEX="53" placeholder="Enter Total Bed" value="<?php echo $hospital_data[0]->ASymptPositivewithComorbidStable_Total_Beds; ?>" <?php echo $disabled; ?>></td> 
                        <td> <input class="filter_lessthan[ASymptPositivewithComorbidStable_Total_Beds]" data-errors="{filter_lessthan:'Less than Total Beds'}" onkeyup="this.value=this.value.replace(/[^\d]/,'')"  id="ASymptPositivewithComorbidStable_Occupied" type="text" name="bed[ASymptPositivewithComorbidStable_Occupied]" TABINDEX="54" placeholder="Enter Occupied Bed" value="<?php echo $hospital_data[0]->ASymptPositivewithComorbidStable_Occupied; ?>" <?php echo $disabled; ?>></td> 
                        <td> <input readonly onkeyup="this.value=this.value.replace(/[^\d]/,'')"  id="ASymptPositivewithComorbidStable_Vacant" type="text" name="bed[ASymptPositivewithComorbidStable_Vacant]"  TABINDEX="55" placeholder="Enter Vacant Bed" value="<?php echo $hospital_data[0]->ASymptPositivewithComorbidStable_Vacant; ?>" <?php echo $disabled; ?>></td> 
                        <td> <input   id="ASymptPositivewithComorbidStable_Remarks" type="text" name="bed[ASymptPositivewithComorbidStable_Remarks]"  TABINDEX="56" placeholder="Enter Remark" value="<?php echo $hospital_data[0]->ASymptPositivewithComorbidStable_Remarks; ?>" <?php echo $disabled; ?>></td> 
                  </tr>
                    <tr>
                        <td></td>                            
                        <td>Symptomatic positive with  Comorbidity stable   </td> 
                        <td> <input onkeyup="this.value=this.value.replace(/[^\d]/,'')"  id="SymptPositivewithComorbidStable_Total_Beds" type="text" name="bed[SymptPositivewithComorbidStable_Total_Beds]" TABINDEX="57" placeholder="Enter Total Bed" value="<?php echo $hospital_data[0]->SymptPositivewithComorbidStable_Total_Beds; ?>" <?php echo $disabled; ?>></td> 
                        <td> <input class="filter_lessthan[SymptPositivewithComorbidStable_Total_Beds]" data-errors="{filter_lessthan:'Less than Total Beds'}" onkeyup="this.value=this.value.replace(/[^\d]/,'')"  id="SymptPositivewithComorbidStable_Occupied" type="text" name="bed[SymptPositivewithComorbidStable_Occupied]" TABINDEX="58" placeholder="Enter Occupied Bed" value="<?php echo $hospital_data[0]->SymptPositivewithComorbidStable_Occupied; ?>" <?php echo $disabled; ?>></td> 
                        <td> <input readonly onkeyup="this.value=this.value.replace(/[^\d]/,'')"  id="SymptPositivewithComorbidStable_Vacant" type="text" name="bed[SymptPositivewithComorbidStable_Vacant]"  TABINDEX="59" placeholder="Enter Vacant Bed" value="<?php echo $hospital_data[0]->SymptPositivewithComorbidStable_Vacant; ?>" <?php echo $disabled; ?>></td> 
                        <td> <input   id="SymptPositivewithComorbidStable_Remarks" type="text" name="bed[SymptPositivewithComorbidStable_Remarks]"  TABINDEX="60" placeholder="Enter Remark" value="<?php echo $hospital_data[0]->SymptPositivewithComorbidStable_Remarks; ?>" <?php echo $disabled; ?>></td> 
                 </tr>
                    <tr>
                        <td>DCH -  </td>                            
                        <td>Asymptomatic COVID suspected with Comorbidity Critical</td> 
                        <td> <input onkeyup="this.value=this.value.replace(/[^\d]/,'')"  id="ASymptC19SspectwithComorbidCritical_Total_Beds" type="text" name="bed[ASymptC19SspectwithComorbidCritical_Total_Beds]" TABINDEX="61" placeholder="Enter Total Bed" value="<?php echo $hospital_data[0]->ASymptC19SspectwithComorbidCritical_Total_Beds; ?>" <?php echo $disabled; ?>></td> 
                        <td> <input class="filter_lessthan[ASymptC19SspectwithComorbidCritical_Total_Beds]" data-errors="{filter_lessthan:'Less than Total Beds'}" onkeyup="this.value=this.value.replace(/[^\d]/,'')"  id="ASymptC19SspectwithComorbidCritical_Occupied" type="text" name="bed[ASymptC19SspectwithComorbidCritical_Occupied]" TABINDEX="62" placeholder="Enter Occupied Bed" value="<?php echo $hospital_data[0]->ASymptC19SspectwithComorbidCritical_Occupied; ?>" <?php echo $disabled; ?>></td> 
                        <td> <input readonly onkeyup="this.value=this.value.replace(/[^\d]/,'')"  id="ASymptC19SspectwithComorbidCritical_Vacant" type="text" name="bed[ASymptC19SspectwithComorbidCritical_Vacant]"  TABINDEX="63" placeholder="Enter Vacant Bed" value="<?php echo $hospital_data[0]->ASymptC19SspectwithComorbidCritical_Vacant; ?>" <?php echo $disabled; ?>></td> 
                        <td> <input   id="ASymptC19SspectwithComorbidCritical_Remarks" type="text" name="bed[ASymptC19SspectwithComorbidCritical_Remarks]"  TABINDEX="64" placeholder="Enter Remark" value="<?php echo $hospital_data[0]->ASymptC19SspectwithComorbidCritical_Remarks; ?>" <?php echo $disabled; ?>></td> 
                  </tr>
                    <tr>
                        <td></td>                            
                        <td>Symptomatic COVID suspected with Comorbidity Critical</td> 
                        <td> <input onkeyup="this.value=this.value.replace(/[^\d]/,'')"  id="SymptC19SspectwithComorbidCritical_Total_Beds" type="text" name="bed[SymptC19SspectwithComorbidCritical_Total_Beds]" TABINDEX="65" placeholder="Enter Total Bed" value="<?php echo $hospital_data[0]->SymptC19SspectwithComorbidCritical_Total_Beds; ?>" <?php echo $disabled; ?>></td> 
                        <td> <input class="filter_lessthan[SymptC19SspectwithComorbidCritical_Total_Beds]" data-errors="{filter_lessthan:'Less than Total Beds'}" onkeyup="this.value=this.value.replace(/[^\d]/,'')"  id="SymptC19SspectwithComorbidCritical_Occupied" type="text" name="bed[SymptC19SspectwithComorbidCritical_Occupied]" TABINDEX="66" placeholder="Enter Occupied Bed" value="<?php echo $hospital_data[0]->SymptC19SspectwithComorbidCritical_Occupied; ?>" <?php echo $disabled; ?>></td> 
                        <td> <input readonly onkeyup="this.value=this.value.replace(/[^\d]/,'')"  id="SymptC19SspectwithComorbidCritical_Vacant" type="text" name="bed[SymptC19SspectwithComorbidCritical_Vacant]"  TABINDEX="67" placeholder="Enter Vacant Bed" value="<?php echo $hospital_data[0]->SymptC19SspectwithComorbidCritical_Vacant; ?>" <?php echo $disabled; ?>></td> 
                        <td> <input   id="SymptC19SspectwithComorbidCritical_Remarks" type="text" name="bed[SymptC19SspectwithComorbidCritical_Remarks]"  TABINDEX="68" placeholder="Enter Remark" value="<?php echo $hospital_data[0]->SymptC19SspectwithComorbidCritical_Remarks; ?>" <?php echo $disabled; ?>></td> 
                  </tr>
                    <tr>
                        <td></td>                            
                        <td>Asymptomatic COVID Positive with Comorbidity Critical</td> 
                        <td> <input onkeyup="this.value=this.value.replace(/[^\d]/,'')"  id="ASymptC19PositivewithComorbidCritical_Total_Beds" type="text" name="bed[ASymptC19PositivewithComorbidCritical_Total_Beds]" TABINDEX="69" placeholder="Enter Total Bed" value="<?php echo $hospital_data[0]->ASymptC19PositivewithComorbidCritical_Total_Beds; ?>" <?php echo $disabled; ?>></td> 
                        <td> <input class="filter_lessthan[ASymptC19PositivewithComorbidCritical_Total_Beds]" data-errors="{filter_lessthan:'Less than Total Beds'}" onkeyup="this.value=this.value.replace(/[^\d]/,'')"  id="ASymptC19PositivewithComorbidCritical_Occupied" type="text" name="bed[ASymptC19PositivewithComorbidCritical_Occupied]" TABINDEX="70" placeholder="Enter Occupied Bed" value="<?php echo $hospital_data[0]->ASymptC19PositivewithComorbidCritical_Occupied; ?>" <?php echo $disabled; ?>></td> 
                        <td> <input readonly onkeyup="this.value=this.value.replace(/[^\d]/,'')"  id="ASymptC19PositivewithComorbidCritical_Vacant" type="text" name="bed[ASymptC19PositivewithComorbidCritical_Vacant]"  TABINDEX="71" placeholder="Enter Vacant Bed" value="<?php echo $hospital_data[0]->ASymptC19PositivewithComorbidCritical_Vacant; ?>" <?php echo $disabled; ?>></td> 
                        <td> <input   id="ASymptC19PositivewithComorbidCritical_Remarks" type="text" name="bed[ASymptC19PositivewithComorbidCritical_Remarks]"  TABINDEX="72" placeholder="Enter Remark" value="<?php echo $hospital_data[0]->ASymptC19PositivewithComorbidCritical_Remarks; ?>" <?php echo $disabled; ?>></td> 
                   </tr>
                    <tr>
                        <td></td>                            
                        <td>Symptomatic COVID Positive with Comorbidity Critical</td> 
                        <td> <input onkeyup="this.value=this.value.replace(/[^\d]/,'')"  id="SymptC19PositivewithComorbidCritical_Total_Beds" type="text" name="bed[SymptC19PositivewithComorbidCritical_Total_Beds]" TABINDEX="73" placeholder="Enter Total Bed" value="<?php echo $hospital_data[0]->SymptC19PositivewithComorbidCritical_Total_Beds; ?>" <?php echo $disabled; ?>></td> 
                        <td> <input class="filter_lessthan[SymptC19PositivewithComorbidCritical_Total_Beds]" data-errors="{filter_lessthan:'Less than Total Beds'}" onkeyup="this.value=this.value.replace(/[^\d]/,'')"  id="SymptC19PositivewithComorbidCritical_Occupied" type="text" name="bed[SymptC19PositivewithComorbidCritical_Occupied]" TABINDEX="74" placeholder="Enter Occupied Bed" value="<?php echo $hospital_data[0]->SymptC19PositivewithComorbidCritical_Occupied; ?>" <?php echo $disabled; ?>></td> 
                        <td> <input readonly onkeyup="this.value=this.value.replace(/[^\d]/,'')"  id="SymptC19PositivewithComorbidCritical_Vacant" type="text" name="bed[SymptC19PositivewithComorbidCritical_Vacant]"  TABINDEX="75" placeholder="Enter Vacant Bed" value="<?php echo $hospital_data[0]->SymptC19PositivewithComorbidCritical_Vacant; ?>"<?php echo $disabled; ?> ></td> 
                        <td> <input  id="SymptC19PositivewithComorbidCritical_Remarks" type="text" name="bed[SymptC19PositivewithComorbidCritical_Remarks]"  TABINDEX="76" placeholder="Enter Remark" value="<?php echo $hospital_data[0]->SymptC19PositivewithComorbidCritical_Remarks; ?>" <?php echo $disabled; ?>></td> 
                   </tr>
                    <tr>
                        <td>Mortury Beds</td>                            
                        <td></td> 
                        <td> <input onkeyup="this.value=this.value.replace(/[^\d]/,'')"  id="MorturyBeds_Total_Beds" type="text" name="bed[MorturyBeds_Total_Beds]" TABINDEX="77" placeholder="Enter Total Bed" value="<?php echo $hospital_data[0]->MorturyBeds_Total_Beds; ?>" <?php echo $disabled; ?>></td> 
                        <td> <input class="filter_lessthan[MorturyBeds_Total_Beds]" data-errors="{filter_lessthan:'Less than Total Beds'}" onkeyup="this.value=this.value.replace(/[^\d]/,'')"  id="MorturyBeds_Occupied" type="text" name="bed[MorturyBeds_Occupied]" TABINDEX="78" placeholder="Enter Occupied Bed" value="<?php echo $hospital_data[0]->MorturyBeds_Occupied; ?>" <?php echo $disabled; ?>></td> 
                        <td> <input readonly onkeyup="this.value=this.value.replace(/[^\d]/,'')"  id="MorturyBeds_Vacant" type="text" name="bed[MorturyBeds_Vacant]"  TABINDEX="79" placeholder="Enter Vacant Bed" value="<?php echo $hospital_data[0]->MorturyBeds_Vacant; ?>" <?php echo $disabled; ?>></td> 
                        <td> <input   id="MorturyBeds_Remarks" type="text" name="bed[MorturyBeds_Remarks]"  TABINDEX="80" placeholder="Enter Remark" value="<?php echo $hospital_data[0]->MorturyBeds_Remarks; ?>" <?php echo $disabled; ?>></td> 
                   </tr>
                    <tr>
                        <td>Other</td>                            
                        <td></td> 
                        <td> <input onkeyup="this.value=this.value.replace(/[^\d]/,'')"  id="Others_Total_Beds" type="text" name="bed[Others_Total_Beds]" TABINDEX="81" placeholder="Enter Total Bed" value="<?php echo $hospital_data[0]->Others_Total_Beds; ?>" <?php echo $disabled; ?>></td> 
                        <td> <input class="filter_lessthan[Others_Total_Beds]" data-errors="{filter_lessthan:'Less than Total Beds'}" onkeyup="this.value=this.value.replace(/[^\d]/,'')"  id="Others_Occupied" type="text" name="bed[Others_Occupied]" TABINDEX="82" placeholder="Enter Occupied Bed" value="<?php echo $hospital_data[0]->Others_Occupied; ?>" <?php echo $disabled; ?>></td> 
                        <td> <input readonly onkeyup="this.value=this.value.replace(/[^\d]/,'')"  id="Others_Vacant" type="text" name="bed[Others_Vacant]"  TABINDEX="83" placeholder="Enter Vacant Bed" value="<?php echo $hospital_data[0]->Others_Vacant; ?>" <?php echo $disabled; ?>></td> 
                        <td> <input   id="Others_Remarks" type="text" name="bed[Others_Remarks]"  TABINDEX="84" placeholder="Enter Remark" value="<?php echo $hospital_data[0]->Others_Remarks; ?>" <?php echo $disabled; ?>></td> 
                   </tr>
                </table>
                <table class="table report_table">
                <tr>                
                        <th width="20%">Name</th>
                        <th width="35%">Type</th>
                        <th>Total Beds</th>
                        <th>Occupied</th>
                        <th>Vacant</th>
                        <th width="20%">Remarks</th>
                       
                    </tr>
                    <tr>
                        <td>Type of facility required</td>                            
                        <td>Non-COVID-19</td> 
                        <td style="padding-top:7px;"> <input readonly onkeyup="this.value=this.value.replace(/[^\d]/,'')"  id="NonC19_Total_Beds" type="text" name="bed[NonC19_Total_Beds]" TABINDEX="5" placeholder="Enter Total Bed" value="<?php echo $hospital_data[0]->NonC19_Total_Beds; ?>" <?php echo $disabled; ?>></td> 
                        <td style="padding-top:7px;"> <input readonly onkeyup="this.value=this.value.replace(/[^\d]/,'')"  id="NonC19_Occupied" type="text" name="bed[NonC19_Occupied]" TABINDEX="6" placeholder="Enter Occupied Bed" value="<?php echo $hospital_data[0]->NonC19_Occupied; ?>" <?php echo $disabled; ?>></td> 
                        <td style="padding-top:7px;"> <input readonly onkeyup="this.value=this.value.replace(/[^\d]/,'')"  id="NonC19_Vacant" type="text" name="bed[NonC19_Vacant]"  TABINDEX="7" placeholder="Enter Vacant Bed" value="<?php echo $hospital_data[0]->NonC19_Vacant; ?>" <?php echo $disabled; ?>></td> 
                        <td style="padding-top:7px;"> <input readonly  id="NonC19_Remarks" type="text" name="bed[NonC19_Remarks]"  TABINDEX="8" placeholder="Enter Remark" value="<?php echo $hospital_data[0]->NonC19_Remarks; ?>" <?php echo $disabled; ?>></td> 
                    </tr>
                    <tr>
                        <td>ICU beds without ventilator</td>                            
                        <td></td> 
                        <td> <input onkeyup="this.value=this.value.replace(/[^\d]/,'')"  id="NonC19ICUWoVenti_Total_Beds" type="text" name="bed[NonC19ICUWoVenti_Total_Beds]" TABINDEX="9" placeholder="Enter Total Bed" value="<?php echo $hospital_data[0]->NonC19ICUWoVenti_Total_Beds; ?>" <?php echo $disabled; ?>></td> 
                        <td> <input class="filter_lessthan[NonC19ICUWoVenti_Total_Beds]" data-errors="{filter_lessthan:'Less than Total Beds'}" onkeyup="this.value=this.value.replace(/[^\d]/,'')"  id="NonC19ICUWoVenti_Occupied" type="text" name="bed[NonC19ICUWoVenti_Occupied]" TABINDEX="10" placeholder="Enter Occupied Bed" value="<?php echo $hospital_data[0]->NonC19ICUWoVenti_Occupied; ?>" <?php echo $disabled; ?>></td> 
                        <td> <input readonly onkeyup="this.value=this.value.replace(/[^\d]/,'')"  id="NonC19ICUWoVenti_Vacant" type="text" name="bed[NonC19ICUWoVenti_Vacant]"  TABINDEX="11" placeholder="Enter Vacant Bed" value="<?php echo $hospital_data[0]->NonC19ICUWoVenti_Vacant; ?>" <?php echo $disabled; ?>></td> 
                        <td> <input  id="NonC19ICUWoVenti_Remarks" type="text" name="bed[NonC19ICUWoVenti_Remarks]"  TABINDEX="12" placeholder="Enter Remark" value="<?php echo $hospital_data[0]->NonC19ICUWoVenti_Remarks; ?>" <?php echo $disabled; ?>></td> 
                     </tr>
                    <tr>
                        <td>ICU bedswith ventilator</td>                            
                        <td></td> 
                        <td> <input onkeyup="this.value=this.value.replace(/[^\d]/,'')"  id="NonC19ICUwithVenti_Total_Beds" type="text" name="bed[NonC19ICUwithVenti_Total_Beds]" TABINDEX="13" placeholder="Enter Total Bed" value="<?php echo $hospital_data[0]->NonC19ICUwithVenti_Total_Beds; ?>" <?php echo $disabled; ?>></td> 
                        <td> <input class="filter_lessthan[NonC19ICUwithVenti_Total_Beds]" data-errors="{filter_lessthan:'Less than Total Beds'}" onkeyup="this.value=this.value.replace(/[^\d]/,'')"  id="NonC19ICUwithVenti_Occupied" type="text" name="bed[NonC19ICUwithVenti_Occupied]" TABINDEX="14" placeholder="Enter Occupied Bed" value="<?php echo $hospital_data[0]->NonC19ICUwithVenti_Occupied; ?>" <?php echo $disabled; ?>></td> 
                        <td> <input readonly onkeyup="this.value=this.value.replace(/[^\d]/,'')"  id="NonC19ICUwithVenti_Vacant" type="text" name="bed[NonC19ICUwithVenti_Vacant]"  TABINDEX="15" placeholder="Enter Vacant Bed" value="<?php echo $hospital_data[0]->NonC19ICUwithVenti_Vacant; ?>" <?php echo $disabled; ?>></td> 
                        <td> <input   id="NonC19ICUwithVenti_Remarks" type="text" name="bed[NonC19ICUwithVenti_Remarks]"  TABINDEX="16" placeholder="Enter Remark" value="<?php echo $hospital_data[0]->NonC19ICUwithVenti_Remarks; ?>" <?php echo $disabled; ?>></td> 
                     </tr>
                    <tr>
                        <td>Dialysis bed</td>                            
                        <td></td> 
                        <td> <input onkeyup="this.value=this.value.replace(/[^\d]/,'')"  id="NonC19ICUwithdialysisBed_Total_Beds" type="text" name="bed[NonC19ICUwithdialysisBed_Total_Beds]" TABINDEX="17" placeholder="Enter Total Bed" value="<?php echo $hospital_data[0]->NonC19ICUwithdialysisBed_Total_Beds; ?>" <?php echo $disabled; ?>></td> 
                        <td> <input class="filter_lessthan[NonC19ICUwithdialysisBed_Total_Beds]" data-errors="{filter_lessthan:'Less than Total Beds'}" onkeyup="this.value=this.value.replace(/[^\d]/,'')"  id="NonC19ICUwithdialysisBed_Occupied" type="text" name="bed[NonC19ICUwithdialysisBed_Occupied]" TABINDEX="18" placeholder="Enter Occupied Bed" value="<?php echo $hospital_data[0]->NonC19ICUwithdialysisBed_Occupied; ?>" <?php echo $disabled; ?>></td> 
                        <td> <input readonly onkeyup="this.value=this.value.replace(/[^\d]/,'')"  id="NonC19ICUwithdialysisBed_Vacant" type="text" name="bed[NonC19ICUwithdialysisBed_Vacant]"  TABINDEX="19" placeholder="Enter Vacant Bed" value="<?php echo $hospital_data[0]->NonC19ICUwithdialysisBed_Vacant; ?>" <?php echo $disabled; ?>></td> 
                        <td> <input   id="NonC19ICUwithdialysisBed_Remarks" type="text" name="bed[NonC19ICUwithdialysisBed_Remarks]"  TABINDEX="20" placeholder="Enter Remark" value="<?php echo $hospital_data[0]->NonC19ICUwithdialysisBed_Remarks; ?>" <?php echo $disabled; ?>></td> 
                     </tr>
                     <tr>
                        <td>Ward</td>                            
                        <td></td> 
                        <td><input onkeyup="this.value=this.value.replace(/[^\d]/,'')"  id="NonC19Ward_Total_Beds" type="text" name="bed[NonC19Ward_Total_Beds]" TABINDEX="17" placeholder="Enter Total Bed" value="<?php echo $hospital_data[0]->NonC19Ward_Total_Beds; ?>" <?php echo $disabled; ?>></td> 
                        <td><input class="filter_lessthan[NonC19Ward_Total_Beds]" data-errors="{filter_lessthan:'Less than Total Beds'}" onkeyup="this.value=this.value.replace(/[^\d]/,'')"  id="NonC19Ward_Occupied" type="text" name="bed[NonC19Ward_Occupied]" TABINDEX="18" placeholder="Enter Occupied Bed" value="<?php echo $hospital_data[0]->NonC19Ward_Occupied; ?>" <?php echo $disabled; ?>></td> 
                        <td><input readonly onkeyup="this.value=this.value.replace(/[^\d]/,'')"  id="NonC19Ward_Vacant" type="text" name="bed[NonC19Ward_Vacant]"  TABINDEX="19" placeholder="Enter Vacant Bed" value="<?php echo $hospital_data[0]->NonC19Ward_Vacant; ?>" <?php echo $disabled; ?>></td> 
                        <td><input   id="NonC19Ward_Remarks" type="text" name="bed[NonC19Ward_Remarks]"  TABINDEX="20" placeholder="Enter Remark" value="<?php echo $hospital_data[0]->NonC19Ward_Remarks; ?>" <?php echo $disabled; ?>></td> 
                     </tr>
                </table>
            </div>   
        </div>

    <?php 
     if($clg_group!='UG-ERO')
     {

     
    ?>
    <div class="width_25 margin_auto">
        <div class="button_field_row text_center">
            <div class="button_box">
                <?php // if ($clg_group == 'UG-ShiftManager') { ?>
                        <input type="button" name="submit" value="Submit" class="form-xhttp-request" data-href='<?php echo base_url(); ?>hp/add_bed_availability'  data-qr='hp_id[0]=<?php echo $hp_id; ?>&amp;page_no=<?php echo $page_no; ?>&amp;req=<?php echo @$req; ?>&amp;fc_type=<?php echo @$fc_type; ?>&amp;output_position=content' TABINDEX="12">
                <?php //} ?>
            </div>
        </div>
    </div>  
                <?php } ?>
</div>
</form>
