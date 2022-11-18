<div class="shift width20 float_left"><label for="sft1">Month Date <span class="md_field">*</span></label></div>

<div class="shift width_78 float_left">
    <input name="schedule_date[]" class="filter_required month-picker" value="<?php echo $details->amb_rto_register_no;?>" type="text" tabindex="1" placeholder="Month Date" data-errors="{filter_required:'Month Date should not blank'}" style="position: relative;" id="manage_team_monthly_date">
<!--    <div class="month-picker"></div>-->
    
</div>


<script type="text/javascript">
//$( ".month-picker" ).datepicker("destroy");
$('.month-picker').MonthPicker({ MinMonth:1, ShowIcon: false });
</script>