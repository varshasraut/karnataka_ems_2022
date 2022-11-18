<div class="shift width20 float_left"><label for="sft1">Date</label></div>

<div class="shift width_78 float_left">
    <input name="schedule_date" class="filter_required datetimepicker_schedule" value="<?php echo $details->amb_rto_register_no;?>" type="text" tabindex="1" placeholder="Date" data-errors="{filter_required:'Date should not blank'}" id="add_team_monthly_date">
</div>


<script type="text/javascript">
$(function() {
		$(".datetimepicker_schedule" ).datepicker("destroy");
		$(".datetimepicker_schedule").datepicker(
				{minDate: new Date(),
					onSelect: function(dateText, inst){
						var theDate = new Date(Date.parse($(this).datepicker('getDate')));
                     
						var $remark_input = $.datepicker.formatDate('yy-mm-dd', theDate);
                    
                        xhttprequest($(this), base_url + 'schedule_crud/load_team_list', 'data-qr="schedule="'+$remark_input+'"');
                        
					}
				}
		);
		
	});
</script>