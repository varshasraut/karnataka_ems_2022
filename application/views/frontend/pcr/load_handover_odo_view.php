<div class="width100 float_left">
<!--        <input name="hospiatl_odometer" onkeyup="this.value=this.value.replace(/[^\d]/,'')" tabindex="20" class="  form_input filter_maxlength[8]" placeholder="Enter hospital Odometer" type="text" data-base="search_btn" value="<?php echo $get_odometer[0]->hospital_odmeter; ?>"  data-errors="{filter_required:'hospital Odometer should not be blank!',filter_valuegreaterthan:'hospital Odometer should greater than or equlto scene Odometer',filter_rangelength:'Hospital Odometer should <?php echo $get_odometer[0]->hospital_odmeter; ?>',filter_maxlength:'Hospital Odometer number at max 7 digit long.'}" id="hospital_odometer_pcr"  <?php echo $odo_hospital_disabled; ?> >-->
        
         <input name="handover_odometer" onkeyup="this.value=this.value.replace(/[^\d]/,'')" tabindex="20" class="form_input filter_maxlength[8] " placeholder="Enter Scene Odometer" type="text" data-base="search_btn" value="<?php echo $get_odometer[0]->handover_odometer; ?>"  data-errors="{filter_required:'Scene Odometer should not be blank!',filter_valuegreaterthan:'Scene Odometer should greater than or equlto Previous Odometer',filter_rangelength:'Scene Odometer should <?php echo $get_odometer[0]->handover_odometer; ?>',filter_maxlength:'Scene Odometer number at max 7 digit long.'}" id="handover_odometer_pcr"  <?php echo $handover_odometer; ?> >
</div>

