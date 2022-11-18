<div class="shift width20 float_left"><label for="sft1">Week Date <span class="md_field">*</span></label></div>

<div class="shift width_78 float_left">
    <input name="schedule_date[]" class="filter_required week-picker" value="<?php echo $details->amb_rto_register_no;?>" type="text" tabindex="1" placeholder="Week Date" data-errors="{filter_required:'Week Date should not blank'}" id="manage_team_weekly_date">
<!--    <div class="week-picker"></div>-->
    <br /><br />
    <label>Week :</label> 
    <input id="startDate" name="schedule_date[]" class="filter_required width_40" value="<?php echo $details->amb_rto_register_no;?>" type="text" tabindex="1" placeholder="Week Start Date" data-errors="{filter_required:'Week Start Date should not blank'}" disabled="">
    -
    <input id="endDate" name="schedule_date[]" class="filter_required width_40" value="<?php echo $details->amb_rto_register_no;?>" type="text" tabindex="1" placeholder="Week End Date" data-errors="{filter_required:'Week End Date should not blank'}" disabled="">
</div>


<script type="text/javascript">
$(function() {
    var startDate;
    var endDate;
    
    var selectCurrentWeek = function() {
        window.setTimeout(function () {
            $('.week-picker').find('.ui-datepicker-current-day a').addClass('ui-state-active')
        }, 1);
    }
    
    var manage_team_week =  function () {
        $remark_input = $("#manage_team_weekly_date").val();
        var $week_start_date = $("#startDate").val();
        var $week_end_date   = $("#endDate").val();
        if ($remark_input != "") {
            xhttprequest($(this), base_url + 'shift_roster/load_team_list', "schedule_start_week="+$week_start_date+"&schedule_end_week="+$week_end_date);
           // xhttprequest($(this), base_url + 'shift_roster/load_team_list', 'data-qr="schedule="'+$remark_input+'"');
        }else{
            $("#manage_team_date").html('');
        }
    }
    
    //$( ".week-picker" ).datepicker("destroy");
    $('.week-picker').datepicker( {
        showOtherMonths: true,
        selectOtherMonths: true,
        firstDay: 1,
        onSelect: function(dateText, inst) { 
            var date = $(this).datepicker('getDate');
            startDate = new Date(date.getFullYear(), date.getMonth(), date.getDate() - date.getDay() + 1);
            endDate = new Date(date.getFullYear(), date.getMonth(), date.getDate() - date.getDay() + 7);
            var dateFormat = inst.settings.dateFormat || $.datepicker._defaults.dateFormat;
            $('#startDate').val($.datepicker.formatDate( dateFormat, startDate, inst.settings ));
            $('#endDate').val($.datepicker.formatDate( dateFormat, endDate, inst.settings ));
            
            selectCurrentWeek();
            
            var $week_start_date = $.datepicker.formatDate( dateFormat, startDate, inst.settings );
            var $week_end_date   = $.datepicker.formatDate( dateFormat, endDate, inst.settings );
            
            xhttprequest($(this), base_url + 'shift_roster/load_team_list', "schedule_start_week="+$week_start_date+"&schedule_end_week="+$week_end_date);
        },
        beforeShowDay: function(date) {
            var cssClass = '';
            if(date >= startDate && date <= endDate)
                cssClass = 'ui-datepicker-current-day';
            return [true, cssClass];
        },
        onChangeMonthYear: function(year, month, inst) {
            selectCurrentWeek();
        }
    });
    
    $('.week-picker .ui-datepicker-calendar tr').live('mousemove', function() { $(this).find('td a').addClass('ui-state-hover'); });
    $('.week-picker .ui-datepicker-calendar tr').live('mouseleave', function() { $(this).find('td a').removeClass('ui-state-hover'); });
});
</script>