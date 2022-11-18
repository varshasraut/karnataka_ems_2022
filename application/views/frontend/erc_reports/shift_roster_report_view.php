<div class="width_25 float_right" style="margin-bottom: 10px;">
    <div class="button_field_row">
        <div class="button_box">
            <form action="<?php echo base_url(); ?>erc_reports/<?php echo $submit_function ?>" method="post" enctype="multipart/form-data" target="form_frame">
                <input type="hidden" value="<?php echo $report_args['to_date']; ?>" name="to_date">
                <input type="hidden" value="<?php echo $report_args['from_date']; ?>" name="from_date">
                <input type="hidden" value="<?php echo $report_args['time']; ?>" name="time">
                <input type="hidden" value="<?php echo $report_type; ?>" name="report_type">

				 <input type="submit" name="submit" value="Download" TABINDEX="3" class="float_right">
            </form>
        </div>

    </div>
</div>   

<table class="table report_table">
    <tr>                              
        <?php foreach ($header as $heading) { ?>
        <th style="line-height: 20px;"><?php echo $heading; ?></th>
        <?php } ?>
    </tr>
    <?php
 
   if($shift_roster){
        $total_records = count($shift_roster);
       $count = 1;
       $brk_resonse_time = 0;
       $total_eme_non =0;
       $total_eme =0;
       $total_trans =0;
       $total_quality_score=0;
    foreach ($shift_roster as $main_data) 
    {
        //var_dump($shift_roster);die();
        $clg_data=get_clg_data_by_ref_id($main_data['user_id']);
       // $total_count=$main_data['Emergency'] + $main_data['Non_Emergency'];
       //var_dump($clg_data);
//                    $brk_hours   = floor($main_data['brk_resonse_time'] / 3600);
//                    $brk_minutes = $main_data['brk_resonse_time'] / 60 % 60;
//                    $brk_seconds = $main_data['brk_resonse_time'] % 60;
//
//                    $hours_brk   = str_pad($brk_hours,   2, '0', STR_PAD_LEFT);
//                    $minutes_brk = str_pad($brk_minutes, 2, '0', STR_PAD_LEFT);
//                    $seconds_brk = str_pad($brk_seconds, 2, '0', STR_PAD_LEFT);
//
//                    $brk_resonse_time = $hours_brk.':'.$minutes_brk.':'.$seconds_brk;
    ?>
    <tr>  
        <td style="text-align: center;"><?php echo $count; ?></td>
        <td style="text-align: center;"> <?php echo ucwords($clg_data[0]->clg_first_name." ".$clg_data[0]->clg_last_name); ?></td>
        <td style="text-align: center;"><?php echo $clg_data[0]->clg_avaya_id; ?></td>
        <td style="text-align: center;"><?php
        echo $main_data['Emergency']?$main_data['Emergency']:0 ;
        $total_eme = $total_eme+$main_data['Emergency'];
        ?></td>
        <td style="text-align: center;"><?php echo $main_data['Non_Emergency']?$main_data['Non_Emergency']:0 ; 
        $total_eme_non = $total_eme_non + $main_data['Non_Emergency'];
        ?></td> 
        <td style="text-align: center;"><?php echo $main_data['Transfer_call']?$main_data['Transfer_call']:0 ; 
        $total_trans = $total_trans + $main_data['Transfer_call'];
        ?></td> 
        <td style="text-align: center;"><?php echo $main_data['total_count'];
            $total_calls =  $total_calls + $main_data['total_count'];
            ?></td> 
        <td style="text-align: center;"><?php echo $main_data['Emergency']?$main_data['Emergency']:0 ; ?></td> 
        <td style="text-align: center;"><?php if($main_data['quality_count'] > 0) { 
            $score_quality =  round($main_data['quality_score']/$main_data['quality_count'],2); 
            echo $score_quality.'%';
            $total_quality_score = $total_quality_score + $score_quality;
        }else{ echo "0%"; } ?></td>
        <td style="text-align: center;"><?php echo $main_data['fetal_count'];
        $fetal_count = $fetal_count+$main_data['fetal_count'];
        ?></td> 
        <td style="text-align: center;"><?php echo $main_data['total_time']; 
        sscanf($main_data['total_time'], "%d:%d:%d", $hours, $minutes, $seconds);

        $login_time_seconds = isset($hours) ? $hours * 3600 + $minutes * 60 + $seconds : $minutes * 60 + $seconds;
        $login_time_seconds_total = $login_time_seconds +$login_time_seconds_total;
        ?></td>
        <td style="text-align: center;"><?php echo $main_data['brk_resonse_time']; 
        
        sscanf($main_data['brk_resonse_time'], "%d:%d:%d", $b_hours, $b_minutes, $b_seconds);

        $break_time_seconds = isset($b_hours) ? $b_hours * 3600 + $b_minutes * 60 + $b_seconds : $b_minutes * 60 + $b_seconds;
        $break_time_seconds_total = $break_time_seconds_total+$break_time_seconds;
        
        ?></td>
    </tr>
    <?php
    $count++; 
   } } ?>
    <tr>
        <td colspan="3" style="text-align: center; font-weight: bold;">Total</td>
        <td style="text-align: center; font-weight: bold;"><?php echo $total_eme;?></td>
        <td style="text-align: center; font-weight: bold;"><?php echo $total_eme_non;?></td>
        <td style="text-align: center; font-weight: bold;"><?php echo $total_trans;?></td>
        <td style="text-align: center; font-weight: bold;"><?php echo $total_calls;?></td>
        <td style="text-align: center; font-weight: bold;"><?php echo $total_eme;?></td>
        <td style="text-align: center; font-weight: bold;"><?php echo $total_quality_score;?></td>
        <td style="text-align: center; font-weight: bold;"><?php echo $fetal_count;?></td>
        <td style="text-align: center; font-weight: bold;"><?php 
         $login_hours   = floor($login_time_seconds_total / 3600);
                $login_minutes = $login_time_seconds_total / 60 % 60;
                $login_seconds = $login_time_seconds_total % 60;
                $hours   = str_pad( $login_hours,   2, '0', STR_PAD_LEFT);
                $minutes = str_pad( $login_minutes, 2, '0', STR_PAD_LEFT);
                $seconds = str_pad( $login_seconds, 2, '0', STR_PAD_LEFT);
                $resonse_time = $hours.':'.$minutes.':'.$seconds;
                echo $resonse_time;
        ?></td>
        <td style="text-align: center; font-weight: bold;"><?php 
         $break_hours   = floor($break_time_seconds_total / 3600);
                $break_minutes = $break_time_seconds_total / 60 % 60;
                $break_seconds = $break_time_seconds_total % 60;
                $hours_b   = str_pad( $break_hours,   2, '0', STR_PAD_LEFT);
                $minutes_b = str_pad( $break_minutes, 2, '0', STR_PAD_LEFT);
                $seconds_b = str_pad( $break_seconds, 2, '0', STR_PAD_LEFT);
                $break_resonse_time = $hours_b.':'.$minutes_b.':'.$seconds_b;
                echo $break_resonse_time;
        ?></td>
    </tr>
    
    
</table>
<iframe name="form_frame" style="height: 1px; width: 1px; border:0px; background: none;"></iframe>
