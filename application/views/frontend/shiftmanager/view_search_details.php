<div class="float_left width75">
<!--    <span class="strong">Name :</span> <?php echo $clg_name ?> -->
</div>
<div class="width_25 float_right">
    <div class="button_field_row">
        <div>
            <form action="{base_url}shiftmanager/search_login_details" method="post" enctype="multipart/form-data" target="form_frame">
                <input type="hidden" value="<?php echo $to_date; ?>" name="to_date">
                <input type="hidden" value="<?php echo $from_date; ?>" name="from_date">
                <input type="hidden" value="<?php echo $team_type; ?>" name="team_type">
                <input type="hidden" value="<?php echo $ref_id; ?>" name="user_id">
                
                <input type="submit" name="submit" value="Download"  class="float_right">
            </form>
        </div>
    </div>
</div> 
<table class="table report_table">
    <tr>      
        <th nowrap>Login User name</th>
        <th nowrap>User Group</th>
        <th nowrap>Login Time</th>
        <th nowrap>Logout Time</th>
        <th nowrap>Total Hours</th>
    </tr>

    <?php
    if (count(@$inc_info) > 0) {
        $total = 0;
$total_time =0;
        foreach ($inc_info as $key => $inc) {
            //var_dump($inc);

            $caller_name = ucwords($inc->clg_first_name . "  " . $inc->clg_last_name);

            if($inc->clg_logout_time != "0000-00-00 00:00:00"){ 

                $d_start = strtotime($inc->clg_login_time);
                $d_end   = strtotime($inc->clg_logout_time);
                $time_diff = $d_end - $d_start;
                $total_time = $total_time + $time_diff;
                
                $hours   = floor( $time_diff / 3600);
                $minutes = $time_diff / 60 % 60;
                $seconds = $time_diff % 60;
                
                $hours   = str_pad( $hours,   2, '0', STR_PAD_LEFT);
                $minutes = str_pad( $minutes, 2, '0', STR_PAD_LEFT);
                $seconds = str_pad( $seconds, 2, '0', STR_PAD_LEFT);
                
                $resonse_time = $hours.':'.$minutes.':'.$seconds;
                
            }
            


            ?>
            <tr>
                <td><?php echo $caller_name;//date("d-m-Y h:i:s", strtotime($inc->clg_login_time)); ?></td>
                <td><?php echo $inc->clg_group;//date("d-m-Y h:i:s", strtotime($inc->clg_login_time)); ?></td>
                <td><?php echo $inc->clg_login_time;//date("d-m-Y h:i:s", strtotime($inc->clg_login_time)); ?></td>
                <td><?php if($inc->clg_logout_time == "0000-00-00 00:00:00"){ echo "Currently Login"; }else{echo $inc->clg_logout_time;}//date("d-m-Y h:i:s", strtotime($inc->clg_logout_time)); ?></td>
                <td><?php if($inc->clg_logout_time == "0000-00-00 00:00:00"){ echo "Currently Login"; }else{echo $resonse_time;} ?></td>

            </tr>
            <?php
        }?>
            <td></td>
            <td></td>
            <td></td>
            <td><strong>Total Time</strong></td>
            <td><?php 
           // echo $total_time;
           // floor($dtd->total_sec/60)
          // echo gmdate("H:i:s", $total_time);  
            $hours   = floor( $total_time / 3600);
$minutes = $total_time / 60 % 60;
$seconds = $total_time % 60;
echo $hours.':'.$minutes.':'.$seconds;
           
            ?></td>
      
       <?php
    } else {
        ?>

        <tr><td colspan="9" class="no_record_text">No history Found</td></tr>

    <?php } ?>   

</table>

<div class="bottom_outer">

    <div class="pagination"><?php echo $pagination; ?></div>

    <input type="hidden" name="submit_data" value="<?php
    if (@$data) {
        echo $data;
    }
    ?>">

    <div class="width38 float_right">

        <div class="record_per_pg">

            <div class="per_page_box_wrapper">

                <span class="dropdown_pg_txt float_left"> Records per page : </span>

                <select name="pg_rec" class="dropdown_per_page float_left change-xhttp-request" data-href="{base_url}shiftmanager/pagination_login_details" data-qr="output_position=content&amp;flt=true&from_date=<?php echo $from_date;?>&to_date=<?php echo $to_date;?>&pg_rec=<?php echo $pg_rec;?>&team_type=<?php echo $team_type;?>">

                    <?php echo rec_perpg($pg_rec); ?>

                </select>

            </div>

            <div class="float_right">
                <span> Total records: <?php
                    if (@$inc_total_count) {
                        echo $inc_total_count;
                    } else {
                        echo"0";
                    }
                    ?> </span>
            </div>

        </div>

    </div>

</div>