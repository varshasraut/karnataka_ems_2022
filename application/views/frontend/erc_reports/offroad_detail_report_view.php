<div class="width_25 float_right" style="margin-bottom: 10px;">
    <div class="button_field_row">
        <div class="button_box">
            <form action="<?php echo base_url(); ?>report_data/<?php echo $submit_function ?>" method="post" enctype="multipart/form-data" target="form_frame">
                
                <input type="hidden" value="<?php echo $report_args['to_date']; ?>" name="from_date">
                <input type="hidden" value="<?php echo $report_args['dist']; ?>" name="onroad_report_type_dist">
				<input type="hidden" value="<?php echo $maintenance_type; ?>" name="maintenance_type">
                
                <input type="submit" name="submit" value="Download" TABINDEX="3" class="float_right">
            </form>
        </div>

    </div>
</div>  

<div class="width100"><lable><?php echo $maint_type; ?></label></div>
<table class="table report_table">
    <tr>                              
        <?php foreach ($header as $heading) { ?>
        <th style="line-height: 20px;"><?php echo $heading; ?></th>
        <?php } ?>
    </tr>
    <?php
    $count = 1;
    if($general_offroad_re){
    foreach ($general_offroad_re as $main_data) { 
        if($main_data->mt_district_id!= ' '){
            $current_district = get_district_by_id($main_data->mt_district_id);
        }
        if($main_data->amb_type != '' || $main_data->amb_type != 0 ){ 
            $amb_type =  show_amb_type_name($main_data->amb_type);
        }
        $amb_model =  show_amb_model_name($main_data->mt_amb_no);
        //$amb_status =  show_amb_staus($main_data->mt_amb_no);
        if($main_data->amb_status == '1' || $main_data->amb_status=='2'){
            $amb_status = 'On-Road';
        }else{
            $amb_status = 'Off-Road';
        }
        $start_date = new DateTime(date('Y-m-d H:i:s',strtotime($main_data->mt_offroad_datetime)));  
        if($main_data->mt_offroad_datetime!='' && $main_data->mt_offroad_datetime != '1970-01-01 05:30:00' && $main_data->mt_offroad_datetime != '0000-00-00 00:00:00'){
            if($main_data->mt_onroad_datetime != '' && $main_data->mt_onroad_datetime != '1970-01-01 05:30:00' && $main_data->mt_onroad_datetime != '0000-00-00 00:00:00'){
                $end_date = new DateTime(date('Y-m-d H:i:s',strtotime($main_data->mt_onroad_datetime))); 
            }else{
                $end_date = new DateTime(date('Y-m-d H:i:s')); 
            }
            $duration = '0';
            if(strtotime($main_data->mt_offroad_datetime) < strtotime($main_data->mt_onroad_datetime)){
                $since_start = $start_date->diff($end_date);
                //$duration= $since_start->days;
                $duration_test= $since_start->days.'D '.$since_start->h.'H '. $since_start->i.'M '.$since_start->s.'S ';
                $duration_time = $since_start->format('%H:%I:%S');
                sscanf($duration_time, "%d:%d:%d", $hours, $minutes, $seconds);
                $time_seconds_min = isset($seconds) ? $hours * 3600 + $minutes * 60 + $seconds : $hours * 60 + $minutes;
                $time_seconds_hr = strtotime($since_start->days.' day', 0);
                $duration1 = $time_seconds_min + $time_seconds_hr ;

                $secs = $duration1 % 60;
                $hrs = $duration1 / 60;
                $mins = $hrs % 60;
                $hrs = $hrs / 60;
                $duration = ((int)$hrs . ":" . (int)$mins . ":" . (int)$secs);
            
            }else{
                $since_start = $start_date->diff($end_date);
                $duration_test= $since_start->days.'D '.$since_start->h.'H '. $since_start->i.'M '.$since_start->s.'S ';
                $duration_time = $since_start->format('%H:%I:%S');
                sscanf($duration_time, "%d:%d:%d", $hours, $minutes, $seconds);
                $time_seconds_min = isset($seconds) ? $hours * 3600 + $minutes * 60 + $seconds : $hours * 60 + $minutes;
                $time_seconds_hr = strtotime($since_start->days.' day', 0);
                $duration1 = $time_seconds_min + $time_seconds_hr ;

                $secs = $duration1 % 60;
                $hrs = $duration1 / 60;
                $mins = $hrs % 60;
                $hrs = $hrs / 60;
                $duration = ((int)$hrs . ":" . (int)$mins . ":" . (int)$secs);
            }
        }else{
            $duration = '0';
        }
        $added_by_name = $main_data->first_name." ".$main_data->mid_name." ". $main_data->last_name;
        if($main_data->mt_offroad_reason == 'Other')
        {
            $mt_offroad_reason=$main_data->mt_offroad_reason.'-'.$main_data->mt_other_offroad_reason;
        }
        else{
            $mt_offroad_reason=$main_data->mt_offroad_reason;
        }
        ?>
        <tr>  
            <td><?php echo $count; ?></td>
            <td><?php echo $main_data->mt_onoffroad_id; ?></td>
            <td><?php echo $main_data->mt_offroad_datetime; ?></td> 
            <td><?php echo $main_data->mt_amb_no; ?></td>
            <td><?php echo $amb_type; ?></td>
            <td><?php echo $current_district; ?></td>
            <td><?php echo $main_data->div_name; ?> </td>
            <td><?php echo $main_data->mt_base_loc; ?></td>
            <td><?php echo $amb_model; ?></td>
            <td><?php echo $main_data->mt_ambulance_status; ?></td>
            <td><?php echo $main_data->mt_remark; ?></td>
            <td><?php echo $mt_offroad_reason; ?></td>
            <td><?php echo 'General Offroad'; ?></td>
            <td><?php echo $main_data->mt_in_odometer; ?></td>
            <td><?php echo $main_data->mt_end_odometer; ?></td>
            <td><?php echo $main_data->mt_offroad_datetime; ?></td> 
            <td><?php echo $main_data->mt_onroad_datetime ; ?></td>
            <td><?php echo $duration; ?></td>
            
            <!--<td><?php //echo $duration_test; ?></td>-->
            <!--<td><?php //echo $since_start->days ?></td>-->
            <!--<td><?php //echo $time_seconds_hr ?></td>-->
            <!--<td><?php //echo $main_data->mt_ex_onroad_datetime; ?></td> 
            <td><?php //echo $main_data->mt_ambulance_status; ?></td>
            <td><?php //echo $main_data->mt_on_remark; ?></td> 
            <td><?php //echo $added_by_name; ?></td> 
            <td><?php //echo $amb_status; ?></td>
            <td><?php //echo $main_data->mt_on_remark; ?></td>-->
        </tr>
        <?php
        $count++;
    }
    }
    if($accidental_data_re){
    foreach ($accidental_data_re as $main_data) { 
        if($main_data->mt_district_id!= ' '){
            $current_district = get_district_by_id($main_data->mt_district_id);
        }
        if($main_data->amb_type != '' || $main_data->amb_type != 0 ){ 
            $amb_type =  show_amb_type_name($main_data->amb_type);
        }
        $amb_model =  show_amb_model_name($main_data->mt_amb_no);
        //$amb_status =  show_amb_staus($main_data->mt_amb_no);
        if($main_data->amb_status == '1' || $main_data->amb_status=='2'){
            $amb_status = 'On-Road';
        }else{
            $amb_status = 'Off-Road';
        }$start_date = new DateTime(date('Y-m-d H:i:s',strtotime($main_data->mt_offroad_datetime)));  
        if($main_data->mt_offroad_datetime!='' && $main_data->mt_offroad_datetime != '1970-01-01 05:30:00' && $main_data->mt_offroad_datetime != '0000-00-00 00:00:00'){
        if($main_data->mt_onroad_datetime != '' && $main_data->mt_onroad_datetime != '1970-01-01 05:30:00' && $main_data->mt_onroad_datetime != '0000-00-00 00:00:00'){
            $end_date = new DateTime(date('Y-m-d H:i:s',strtotime($main_data->mt_onroad_datetime))); 
        }else{
            $end_date = new DateTime(date('Y-m-d H:i:s')); 
        }
        $duration = '0';
        if(strtotime($main_data->mt_offroad_datetime) < strtotime($main_data->mt_onroad_datetime)){
            $since_start = $start_date->diff($end_date);
                $duration_test= $since_start->days.'D '.$since_start->h.'H '. $since_start->i.'M '.$since_start->s.'S ';
                $duration_time = $since_start->format('%H:%I:%S');
                sscanf($duration_time, "%d:%d:%d", $hours, $minutes, $seconds);
                $time_seconds_min = isset($seconds) ? $hours * 3600 + $minutes * 60 + $seconds : $hours * 60 + $minutes;
                $time_seconds_hr = strtotime($since_start->days.' day', 0);
                $duration1 = $time_seconds_min + $time_seconds_hr ;

                $secs = $duration1 % 60;
                $hrs = $duration1 / 60;
                $mins = $hrs % 60;
                $hrs = $hrs / 60;
                $duration = ((int)$hrs . ":" . (int)$mins . ":" . (int)$secs);
        }else{
            $since_start = $start_date->diff($end_date);
                $duration_test= $since_start->days.'D '.$since_start->h.'H '. $since_start->i.'M '.$since_start->s.'S ';
                $duration_time = $since_start->format('%H:%I:%S');
                sscanf($duration_time, "%d:%d:%d", $hours, $minutes, $seconds);
                $time_seconds_min = isset($seconds) ? $hours * 3600 + $minutes * 60 + $seconds : $hours * 60 + $minutes;
                $time_seconds_hr = strtotime($since_start->days.' day', 0);
                $duration1 = $time_seconds_min + $time_seconds_hr ;

                $secs = $duration1 % 60;
                $hrs = $duration1 / 60;
                $mins = $hrs % 60;
                $hrs = $hrs / 60;
                $duration = ((int)$hrs . ":" . (int)$mins . ":" . (int)$secs);
        }
    }else{
        $duration = '0';
    }
        $added_by_name = $main_data->first_name." ".$main_data->mid_name." ". $main_data->last_name;
        if($main_data->mt_offroad_reason == 'Other')
        {
            $mt_offroad_reason=$main_data->mt_offroad_reason.'-'.$main_data->mt_other_offroad_reason;
        }
        else{
            $mt_offroad_reason=$main_data->mt_offroad_reason;
        }
        ?>
        <tr>  
            <td><?php echo $count; ?></td>
            <td><?php echo $main_data->mt_accidental_id; ?></td>
            <td><?php echo $main_data->mt_offroad_datetime; ?></td> 
            <td><?php echo $main_data->mt_amb_no; ?></td>
            <td><?php echo $amb_type; ?></td>
            <td><?php echo $current_district; ?></td>
            <td><?php echo $main_data->div_name; ?> </td>
            <td><?php echo $main_data->mt_base_loc; ?></td>
            <td><?php echo $amb_model; ?></td>
            <td><?php echo $main_data->mt_ambulance_status; ?></td>
            <td><?php echo $main_data->mt_remark; ?></td>
            <td><?php echo $mt_offroad_reason; ?></td>
            <td><?php echo 'Accidental Offroad'; ?></td>
            <td><?php echo $main_data->mt_in_odometer; ?></td>
            <td><?php echo $main_data->mt_end_odometer; ?></td>
            <td><?php echo $main_data->mt_offroad_datetime; ?></td> 
            <td><?php echo $main_data->mt_onroad_datetime ; ?></td>
            <td><?php echo $duration; ?></td>
            <!--<td><?php //echo $main_data->mt_ex_onroad_datetime; ?></td> 
            <td><?php //echo $main_data->mt_ambulance_status; ?></td>
            <td><?php //echo $main_data->mt_on_remark; ?></td> 
            <td><?php //echo $added_by_name; ?></td> 
            <td><?php //echo $amb_status; ?></td>
            <td><?php //echo $main_data->mt_on_remark; ?></td>-->
        </tr>
        <?php
        $count++;
    }
    }
    if($preventive_data_re){
    foreach ($preventive_data_re as $main_data) { 
        if($main_data->mt_district_id!= ' '){
            $current_district = get_district_by_id($main_data->mt_district_id);
        }
        if($main_data->amb_type != '' || $main_data->amb_type != 0 ){ 
            $amb_type =  show_amb_type_name($main_data->amb_type);
        }
        $amb_model =  show_amb_model_name($main_data->mt_amb_no);
        //$amb_status =  show_amb_staus($main_data->mt_amb_no);
        if($main_data->amb_status == '1' || $main_data->amb_status=='2'){
            $amb_status = 'On-Road';
        }else{
            $amb_status = 'Off-Road';
        }$start_date = new DateTime(date('Y-m-d H:i:s',strtotime($main_data->mt_offroad_datetime)));  
        if($main_data->mt_offroad_datetime!='' && $main_data->mt_offroad_datetime != '1970-01-01 05:30:00' && $main_data->mt_offroad_datetime != '0000-00-00 00:00:00'){
        if($main_data->mt_onroad_datetime != '' && $main_data->mt_onroad_datetime != '1970-01-01 05:30:00' && $main_data->mt_onroad_datetime != '0000-00-00 00:00:00'){
            $end_date = new DateTime(date('Y-m-d H:i:s',strtotime($main_data->mt_onroad_datetime))); 
        }else{
            $end_date = new DateTime(date('Y-m-d H:i:s')); 
        }
        $duration = '0';
        if(strtotime($main_data->mt_offroad_datetime) < strtotime($main_data->mt_onroad_datetime)){
            $since_start = $start_date->diff($end_date);
            $duration_test= $since_start->days.'D '.$since_start->h.'H '. $since_start->i.'M '.$since_start->s.'S ';
                $duration_time = $since_start->format('%H:%I:%S');
                sscanf($duration_time, "%d:%d:%d", $hours, $minutes, $seconds);
                $time_seconds_min = isset($seconds) ? $hours * 3600 + $minutes * 60 + $seconds : $hours * 60 + $minutes;
                $time_seconds_hr = strtotime($since_start->days.' day', 0);
                $duration1 = $time_seconds_min + $time_seconds_hr ;

                $secs = $duration1 % 60;
                $hrs = $duration1 / 60;
                $mins = $hrs % 60;
                $hrs = $hrs / 60;
                $duration = ((int)$hrs . ":" . (int)$mins . ":" . (int)$secs);
        }else{
            $since_start = $start_date->diff($end_date);
            $duration_test= $since_start->days.'D '.$since_start->h.'H '. $since_start->i.'M '.$since_start->s.'S ';
                $duration_time = $since_start->format('%H:%I:%S');
                sscanf($duration_time, "%d:%d:%d", $hours, $minutes, $seconds);
                $time_seconds_min = isset($seconds) ? $hours * 3600 + $minutes * 60 + $seconds : $hours * 60 + $minutes;
                $time_seconds_hr = strtotime($since_start->days.' day', 0);
                $duration1 = $time_seconds_min + $time_seconds_hr ;

                $secs = $duration1 % 60;
                $hrs = $duration1 / 60;
                $mins = $hrs % 60;
                $hrs = $hrs / 60;
                $duration = ((int)$hrs . ":" . (int)$mins . ":" . (int)$secs);
        }}else{
            $duration = '0';
        }
        $added_by_name = $main_data->first_name." ".$main_data->mid_name." ". $main_data->last_name;
        if($main_data->mt_offroad_reason == 'Other')
        {
            $mt_offroad_reason=$main_data->mt_offroad_reason.'-'.$main_data->mt_other_offroad_reason;
        }
        else{
            $mt_offroad_reason=$main_data->mt_offroad_reason;
        }
        ?>
        <tr>  
        <td><?php echo $count; ?></td>
            <td><?php echo $main_data->mt_preventive_id; ?></td>
            <td><?php echo $main_data->mt_offroad_datetime; ?></td> 
            <td><?php echo $main_data->mt_amb_no; ?></td>
            <td><?php echo $amb_type; ?></td>
            <td><?php echo $current_district; ?></td>
            <td><?php echo $main_data->div_name; ?> </td>
            <td><?php echo $main_data->mt_base_loc; ?></td>
            <td><?php echo $amb_model; ?></td>
            <td><?php echo $main_data->mt_ambulance_status; ?></td>
            <td><?php echo $main_data->mt_remark; ?></td>
            <td><?php echo $mt_offroad_reason; ?></td>
            <td><?php echo 'Schedule Offroad'; ?></td>
            <td><?php echo $main_data->mt_in_odometer; ?></td>
            <td><?php echo $main_data->mt_end_odometer; ?></td>
            <td><?php echo $main_data->mt_offroad_datetime; ?></td> 
            <td><?php echo $main_data->mt_onroad_datetime ; ?></td>
            <td><?php echo $duration; ?></td>
            <!--<td><?php //echo $main_data->mt_ex_onroad_datetime; ?></td> 
            <td><?php //echo $main_data->mt_ambulance_status; ?></td>
            <td><?php //echo $main_data->mt_on_remark; ?></td> 
            <td><?php //echo $added_by_name; ?></td> 
            <td><?php //echo $amb_status; ?></td>
            <td><?php //echo $main_data->mt_on_remark; ?></td>-->
        </tr>
        <?php
        $count++;
    }
    }
    if($tyre_data_re){
    foreach ($tyre_data_re as $main_data) { 
        if($main_data->mt_district_id!= ' '){
            $current_district = get_district_by_id($main_data->mt_district_id);
        }
        if($main_data->amb_type != '' || $main_data->amb_type != 0 ){ 
            $amb_type =  show_amb_type_name($main_data->amb_type);
        }
        $amb_model =  show_amb_model_name($main_data->mt_amb_no);
        //$amb_status =  show_amb_staus($main_data->mt_amb_no);
        if($main_data->amb_status == '1' || $main_data->amb_status=='2'){
            $amb_status = 'On-Road';
        }else{
            $amb_status = 'Off-Road';
        }$start_date = new DateTime(date('Y-m-d H:i:s',strtotime($main_data->mt_offroad_datetime)));  
        if($main_data->mt_offroad_datetime!='' && $main_data->mt_offroad_datetime != '1970-01-01 05:30:00' && $main_data->mt_offroad_datetime != '0000-00-00 00:00:00'){
        if($main_data->mt_onroad_datetime != '' && $main_data->mt_onroad_datetime != '1970-01-01 05:30:00' && $main_data->mt_onroad_datetime != '0000-00-00 00:00:00'){
            $end_date = new DateTime(date('Y-m-d H:i:s',strtotime($main_data->mt_onroad_datetime))); 
        }else{
            $end_date = new DateTime(date('Y-m-d H:i:s')); 
        }
        $duration = '0';
        if(strtotime($main_data->mt_offroad_datetime) < strtotime($main_data->mt_onroad_datetime)){
            $since_start = $start_date->diff($end_date);
            $duration_test= $since_start->days.'D '.$since_start->h.'H '. $since_start->i.'M '.$since_start->s.'S ';
                $duration_time = $since_start->format('%H:%I:%S');
                sscanf($duration_time, "%d:%d:%d", $hours, $minutes, $seconds);
                $time_seconds_min = isset($seconds) ? $hours * 3600 + $minutes * 60 + $seconds : $hours * 60 + $minutes;
                $time_seconds_hr = strtotime($since_start->days.' day', 0);
                $duration1 = $time_seconds_min + $time_seconds_hr ;

                $secs = $duration1 % 60;
                $hrs = $duration1 / 60;
                $mins = $hrs % 60;
                $hrs = $hrs / 60;
                $duration = ((int)$hrs . ":" . (int)$mins . ":" . (int)$secs);
        }else{
            $since_start = $start_date->diff($end_date);
            $duration_test= $since_start->days.'D '.$since_start->h.'H '. $since_start->i.'M '.$since_start->s.'S ';
                $duration_time = $since_start->format('%H:%I:%S');
                sscanf($duration_time, "%d:%d:%d", $hours, $minutes, $seconds);
                $time_seconds_min = isset($seconds) ? $hours * 3600 + $minutes * 60 + $seconds : $hours * 60 + $minutes;
                $time_seconds_hr = strtotime($since_start->days.' day', 0);
                $duration1 = $time_seconds_min + $time_seconds_hr ;

                $secs = $duration1 % 60;
                $hrs = $duration1 / 60;
                $mins = $hrs % 60;
                $hrs = $hrs / 60;
                $duration = ((int)$hrs . ":" . (int)$mins . ":" . (int)$secs);
        }
    }else{
        $duration = '0';
    }
        $added_by_name = $main_data->first_name." ".$main_data->mid_name." ". $main_data->last_name;
        if($main_data->mt_offroad_reason == 'Other')
        {
            $mt_offroad_reason=$main_data->mt_offroad_reason.'-'.$main_data->mt_other_offroad_reason;
        }
        else{
            $mt_offroad_reason=$main_data->mt_offroad_reason;
        }
        ?>
        <tr>  
        <td><?php echo $count; ?></td>
            <td><?php echo $main_data->mt_tyre_id; ?></td>
            <td><?php echo $main_data->mt_offroad_datetime; ?></td> 
            <td><?php echo $main_data->mt_amb_no; ?></td>
            <td><?php echo $amb_type; ?></td>
            <td><?php echo $current_district; ?></td>
            <td><?php echo $main_data->div_name; ?> </td>
            <td><?php echo $main_data->mt_base_loc; ?></td>
            <td><?php echo $amb_model; ?></td>
            <td><?php echo $main_data->mt_ambulance_status; ?></td>
            <td><?php echo $main_data->mt_remark; ?></td>
            <td><?php echo $mt_offroad_reason; ?></td>
            <td><?php echo 'Tyre Offroad'; ?></td>
            <td><?php echo $main_data->mt_in_odometer; ?></td>
            <td><?php echo $main_data->mt_end_odometer; ?></td>
            <td><?php echo $main_data->mt_offroad_datetime; ?></td> 
            <td><?php echo $main_data->mt_onroad_datetime ; ?></td>
            <td><?php echo $duration; ?></td>
            <!--<td><?php //echo $main_data->mt_ex_onroad_datetime; ?></td> 
            <td><?php //echo $main_data->mt_ambulance_status; ?></td>
            <td><?php //echo $main_data->mt_on_remark; ?></td> 
            <td><?php //echo $added_by_name; ?></td> 
            <td><?php //echo $amb_status; ?></td>
            <td><?php //echo $main_data->mt_on_remark; ?></td>-->
        </tr>
        <?php
        $count++;
    }
    }
    if($breakdown_data_re){
    foreach ($breakdown_data_re as $main_data) { 
        if($main_data->mt_district_id!= ' '){
            $current_district = get_district_by_id($main_data->mt_district_id);
        }
        if($main_data->amb_type != '' || $main_data->amb_type != 0 ){ 
            $amb_type =  show_amb_type_name($main_data->amb_type);
        }
        $amb_model =  show_amb_model_name($main_data->mt_amb_no);
        //$amb_status =  show_amb_staus($main_data->mt_amb_no);
        if($main_data->amb_status == '1' || $main_data->amb_status=='2'){
            $amb_status = 'On-Road';
        }else{
            $amb_status = 'Off-Road';
        }
        $start_date = new DateTime(date('Y-m-d H:i:s',strtotime($main_data->mt_offroad_datetime)));  
        if($main_data->mt_offroad_datetime!='' && $main_data->mt_offroad_datetime != '1970-01-01 05:30:00' && $main_data->mt_offroad_datetime != '0000-00-00 00:00:00'){
            if($main_data->mt_onroad_datetime != '' && $main_data->mt_onroad_datetime != '1970-01-01 05:30:00' && $main_data->mt_onroad_datetime != '0000-00-00 00:00:00'){
                $end_date = new DateTime(date('Y-m-d H:i:s',strtotime($main_data->mt_onroad_datetime))); 
            }else{
                $end_date = new DateTime(date('Y-m-d H:i:s')); 
            }
            $duration = '0';
            if(strtotime($main_data->mt_offroad_datetime) < strtotime($main_data->mt_onroad_datetime)){
                $since_start = $start_date->diff($end_date);
                $duration_test= $since_start->days.'D '.$since_start->h.'H '. $since_start->i.'M '.$since_start->s.'S ';
                $duration_time = $since_start->format('%H:%I:%S');
                sscanf($duration_time, "%d:%d:%d", $hours, $minutes, $seconds);
                $time_seconds_min = isset($seconds) ? $hours * 3600 + $minutes * 60 + $seconds : $hours * 60 + $minutes;
                $time_seconds_hr = strtotime($since_start->days.' day', 0);
                $duration1 = $time_seconds_min + $time_seconds_hr ;

                $secs = $duration1 % 60;
                $hrs = $duration1 / 60;
                $mins = $hrs % 60;
                $hrs = $hrs / 60;
                $duration = ((int)$hrs . ":" . (int)$mins . ":" . (int)$secs);
            }else{
                $since_start = $start_date->diff($end_date);
                $duration_test= $since_start->days.'D '.$since_start->h.'H '. $since_start->i.'M '.$since_start->s.'S ';
                $duration_time = $since_start->format('%H:%I:%S');
                sscanf($duration_time, "%d:%d:%d", $hours, $minutes, $seconds);
                $time_seconds_min = isset($seconds) ? $hours * 3600 + $minutes * 60 + $seconds : $hours * 60 + $minutes;
                $time_seconds_hr = strtotime($since_start->days.' day', 0);
                $duration1 = $time_seconds_min + $time_seconds_hr ;

                $secs = $duration1 % 60;
                $hrs = $duration1 / 60;
                $mins = $hrs % 60;
                $hrs = $hrs / 60;
                $duration = ((int)$hrs . ":" . (int)$mins . ":" . (int)$secs);
            }
        }else{
            $duration = '0';
        }
        $added_by_name = $main_data->first_name." ".$main_data->mid_name." ". $main_data->last_name;
        if($main_data->mt_offroad_reason == 'Other')
        {
            $mt_offroad_reason=$main_data->mt_offroad_reason.'-'.$main_data->mt_other_offroad_reason;
        }
        else{
            $mt_offroad_reason=$main_data->mt_offroad_reason;
        }
        ?>
        <tr>  
        <td><?php echo $count; ?></td>
            <td><?php echo $main_data->mt_breakdown_id; ?></td>
            <td><?php echo $main_data->mt_offroad_datetime; ?></td> 
            <td><?php echo $main_data->mt_amb_no; ?></td>
            <td><?php echo $amb_type; ?></td>
            <td><?php echo $current_district; ?></td>
            <td><?php echo $main_data->div_name; ?> </td>
            <td><?php echo $main_data->mt_base_loc; ?></td>
            <td><?php echo $amb_model; ?></td>
            <td><?php echo $main_data->mt_ambulance_status; ?></td>
            <td><?php echo $main_data->mt_remark; ?></td>
            <td><?php echo $mt_offroad_reason; ?></td>
            <td><?php echo 'Breakdown Offroad'; ?></td>
            <td><?php echo $main_data->mt_in_odometer; ?></td>
            <td><?php echo $main_data->mt_end_odometer; ?></td>
            <td><?php echo $main_data->mt_offroad_datetime; ?></td> 
            <td><?php echo $main_data->mt_onroad_datetime ; ?></td>
            <td><?php echo $duration; ?></td>
            <!--<td><?php //echo $main_data->mt_ex_onroad_datetime; ?></td> 
            <td><?php //echo $main_data->mt_ambulance_status; ?></td>
            <td><?php //echo $main_data->mt_on_remark; ?></td> 
            <td><?php //echo $added_by_name; ?></td> 
            <td><?php //echo $amb_status; ?></td>
            <td><?php //echo $main_data->mt_on_remark; ?></td>-->
        </tr>
        <?php
        $count++;
    }
    }
    if($manpower_data_re){
    foreach ($manpower_data_re as $main_data) { 
        if($main_data->mt_district_id!= ' '){
            $current_district = get_district_by_id($main_data->mt_district_id);
        }
        if($main_data->amb_type != '' || $main_data->amb_type != 0 ){ 
            $amb_type =  show_amb_type_name($main_data->amb_type);
        }
        $amb_model =  show_amb_model_name($main_data->mt_amb_no);
        //$amb_status =  show_amb_staus($main_data->mt_amb_no);
        if($main_data->amb_status == '1' || $main_data->amb_status=='2'){
            $amb_status = 'On-Road';
        }else{
            $amb_status = 'Off-Road';
        }
        $start_date = new DateTime(date('Y-m-d H:i:s',strtotime($main_data->mt_offroad_date)));  
        if($main_data->mt_offroad_date!='' && $main_data->mt_offroad_date != '1970-01-01 05:30:00' && $main_data->mt_offroad_date != '0000-00-00 00:00:00'){
        if($main_data->mt_ex_onroad_datetime != '' && $main_data->mt_ex_onroad_datetime != '1970-01-01 05:30:00' && $main_data->mt_ex_onroad_datetime != '0000-00-00 00:00:00'){
            $end_date = new DateTime(date('Y-m-d H:i:s',strtotime($main_data->mt_ex_onroad_datetime))); 
        }else{
            $end_date = new DateTime(date('Y-m-d H:i:s')); 
        }
        $duration = '0';
        if(strtotime($main_data->mt_offroad_date) < strtotime($main_data->mt_ex_onroad_datetime)){
            $since_start = $start_date->diff($end_date);
            $duration_test= $since_start->days.'D '.$since_start->h.'H '. $since_start->i.'M '.$since_start->s.'S ';
                $duration_time = $since_start->format('%H:%I:%S');
                sscanf($duration_time, "%d:%d:%d", $hours, $minutes, $seconds);
                $time_seconds_min = isset($seconds) ? $hours * 3600 + $minutes * 60 + $seconds : $hours * 60 + $minutes;
                $time_seconds_hr = strtotime($since_start->days.' day', 0);
                $duration1 = $time_seconds_min + $time_seconds_hr ;

                $secs = $duration1 % 60;
                $hrs = $duration1 / 60;
                $mins = $hrs % 60;
                $hrs = $hrs / 60;
                $duration = ((int)$hrs . ":" . (int)$mins . ":" . (int)$secs);
        }else{
            $since_start = $start_date->diff($end_date);
            $duration_test= $since_start->days.'D '.$since_start->h.'H '. $since_start->i.'M '.$since_start->s.'S ';
                $duration_time = $since_start->format('%H:%I:%S');
                sscanf($duration_time, "%d:%d:%d", $hours, $minutes, $seconds);
                $time_seconds_min = isset($seconds) ? $hours * 3600 + $minutes * 60 + $seconds : $hours * 60 + $minutes;
                $time_seconds_hr = strtotime($since_start->days.' day', 0);
                $duration1 = $time_seconds_min + $time_seconds_hr ;

                $secs = $duration1 % 60;
                $hrs = $duration1 / 60;
                $mins = $hrs % 60;
                $hrs = $hrs / 60;
                $duration = ((int)$hrs . ":" . (int)$mins . ":" . (int)$secs);
        }
        }else{
            $duration = '0';
        }
        $added_by_name = $main_data->first_name." ".$main_data->mid_name." ". $main_data->last_name;
        if($main_data->mt_offroad_reason == 'Other')
        {
            $mt_offroad_reason=$main_data->mt_offroad_reason.'-'.$main_data->mt_other_offroad_reason;
        }
        else{
            $mt_offroad_reason=$main_data->mt_offroad_reason;
        }
        ?>
        <tr>  
        <td><?php echo $count; ?></td>
            <td><?php echo $main_data->mt_manpower_id; ?></td>
            <td><?php echo $main_data->mt_offroad_date; ?></td> 
            <td><?php echo $main_data->mt_amb_no; ?></td>
            <td><?php echo $amb_type; ?></td>
            <td><?php echo $current_district; ?></td>
            <td><?php echo $main_data->div_name; ?> </td>
            <td><?php echo $main_data->mt_base_loc; ?></td>
            <td><?php echo $amb_model; ?></td>
            <td><?php echo $main_data->mt_ambulance_status; ?></td>
            <td><?php echo $main_data->mt_remark; ?></td>
            <td><?php echo $mt_offroad_reason; ?></td>
            <td><?php echo 'Manpower Offroad'; ?></td>
            <td><?php echo $main_data->mt_in_odometer; ?></td>
            <td><?php echo $main_data->mt_end_odometer; ?></td>
            <td><?php echo $main_data->mt_offroad_date; ?></td> 
            <td><?php echo $main_data->mt_ex_onroad_datetime ; ?></td>
            <td><?php echo $duration; ?></td>
            <!--<td><?php //echo $main_data->mt_ex_onroad_datetime; ?></td> 
            <td><?php //echo $main_data->mt_ambulance_status; ?></td>
            <td><?php //echo $main_data->mt_on_remark; ?></td> 
            <td><?php //echo $added_by_name; ?></td> 
            <td><?php //echo $amb_status; ?></td>
            <td><?php //echo $main_data->mt_on_remark; ?></td>-->
        </tr>
        <?php
        $count++;
    }
    }
    /*foreach ($general_offroad_re as $main_data) 
    { 
        var_dump($main_data);
        if($main_data->mt_district_id!= ' '){
            $current_district = get_district_by_id($main_data->mt_district_id);
        }
        if($main_data->amb_type != '' || $main_data->amb_type != 0 ){ 
            $amb_type =  show_amb_type_name($main_data->amb_type);
        }
        $start_date = new DateTime(date('Y-m-d H:i:s',strtotime($main_data->mt_offroad_datetime)));  
        if($main_data->mt_onroad_datetime != '' && $main_data->mt_onroad_datetime != '1970-01-01 05:30:00' && $main_data->mt_onroad_datetime != '0000-00-00 00:00:00'){
            $end_date = new DateTime(date('Y-m-d H:i:s',strtotime($main_data->mt_onroad_datetime))); 
        }else{
            $end_date = new DateTime(date('Y-m-d H:i:s')); 
        }
        $duration = '0D 0H 0M 0S';
        if(strtotime($main_data->mt_offroad_datetime) < strtotime($main_data->mt_onroad_datetime)){
                $since_start = $start_date->diff($end_date);
                $duration= $since_start->days.'D '.$since_start->h.'H '. $since_start->i.'M '.$since_start->s.'S';
        }
        $added_by_name = $main_data->first_name." ".$main_data->mid_name." ". $main_data->last_name;
        $approve_by_name = $main_data->add_first." ".$main_data->add_mid." ". $main_data->add_last;
      
    ?>
    <tr>  
        <td><?php echo $count; ?></td>
        <td><?php echo $main_data->mt_onoffroad_id; ?></td>
        <td><?php echo $main_data->mt_amb_no; ?></td>
        <td><?php echo $main_data->mt_base_loc; ?></td>
        <td><?php echo $main_data->div_name; ?></td>
        <td><?php echo $current_district; ?></td>
        <td><?php echo $amb_type; ?></td>
        <td><?php echo $main_type; ?></td>
        <td><?php echo $main_data->mt_offroad_datetime; ?></td> 
         <td><?php echo $main_data->mt_remark; ?></td>
         <td><?php echo $main_data->mt_offroad_reason; ?></td>
         <td><?php echo $main_data->mt_ambulance_status; ?></td>
        <td><?php echo $main_data->added_date; ?></td>
          <td><?php echo $main_data->mt_onroad_datetime ; ?></td> 
        <td><?php echo $main_data->mt_ex_onroad_datetime; ?></td> 
        <td><?php echo $main_data->mt_on_remark; ?></td> 
        <td><?php echo $main_data->mt_prev_odo; ?></td> 
        <td><?php echo $main_data->mt_previos_odometer; ?></td> 
        <td><?php echo $main_data->mt_in_odometer; ?></td> 
        <td><?php echo $main_data->mt_end_odometer; ?></td> 
        <td><?php echo $main_data->added_by; ?></td> 
        <td><?php echo $added_by_name; ?></td> 
        <td><?php echo $main_data->approved_by; ?></td> 
        <td><?php echo $approve_by_name; ?></td> 
         <td><?php echo $duration; ?></td> 
     
    </tr>
    <?php
   // $count++; 
 // }
     }*/
     ?>
</table>
<iframe name="form_frame" style="height: 1px; width: 1px; border:0px; background: none;"></iframe>
