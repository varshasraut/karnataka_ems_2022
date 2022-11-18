<div class="shift width20 float_left"><label for="sft1">Date <span class="md_field">*</span></label></div>

<div class="shift width_78 float_left">
    <input name="schedule_date[]" class="filter_required datetimepicker2" value="<?php echo $details->amb_rto_register_no;?>" type="text" tabindex="1" placeholder="Date" data-errors="{filter_required:'Date should not blank'}" id="manage_team_current_date">
</div>


<script type="text/javascript">
$(function() {
		//$( ".datetimepicker2" ).datepicker("destroy");
		$(".datetimepicker2").datepicker(
				{minDate: new Date(),
					onSelect: function(dateText, inst){
						var theDate = new Date(Date.parse($(this).datepicker('getDate')));
                     
						var $remark_input = $.datepicker.formatDate('yy-mm-dd', theDate);
                    
                        xhttprequest($(this), base_url + 'shift_roster/load_team_list', 'data-qr="schedule="'+$remark_input+'"');
                        
					}
				}
		);
		
	});
</script>