<div class="float_left width75">
    <span class="strong">Name :</span> <?php echo $clg_name ?> 
</div>
<div class="width_25 float_right">
    <div class="button_field_row">
        <div>
            <form action="{base_url}shiftmanager/search_break_details" method="post" enctype="multipart/form-data" target="form_frame">
                <input type="hidden" value="<?php echo $search_date; ?>" name="from_date">
                <input type="hidden" value="<?php echo $search_date2; ?>" name="to_date">
                <input type="submit" name="submit" value="Download"  class="float_right">
                
            </form>
        </div>
    </div>
</div> 
<table class="table report_table">
    <tr>  
        <th nowrap>User Name</th>    
        <th nowrap>User ID</th>
        <th nowrap>Break  Time</th>
        <th nowrap>Break To Back Time</th>
        <th nowrap>Break Duration</th>
        <th nowrap>Break Reason</th>

    </tr>

    <?php
    if (count(@$inc_info) > 0) {
        $total = 0;
        $total_time = 0;
        foreach ($inc_info as $key => $inc) {
           
            
             if($inc->clg_back_to_break_time != "0000-00-00 00:00:00"){ 

                $d_start = strtotime($inc->clg_break_time);
                $d_end   = strtotime($inc->clg_back_to_break_time);
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
                <td><?php echo ucwords($inc->clg_first_name.' '.$inc->clg_middle_name.' '.$inc->clg_last_name); ?></td>
                <td><?php echo strtoupper($inc->clg_ref_id); ?></td>
                <td><?php echo date("d-m-Y H:i:s", strtotime($inc->clg_break_time)); ?></td>
                <td><?php if($inc->clg_back_to_break_time == "0000-00-00 00:00:00"){ echo "On Break"; }else{echo date("d-m-Y H:i:s", strtotime($inc->clg_back_to_break_time)); } ?></td>
                <td><?php echo $resonse_time; ?></td>
                <td><?php echo $inc->break_name; ?></td>

            </tr>
            <?php
        }
        //if($ref_id != ""){?>
            <td></td>
            <td></td>
            <td></td>
            <td><strong>Total Time</strong></td>
            <td><?php 
                     $hours   = floor( $total_time / 3600);
$minutes = $total_time / 60 % 60;
$seconds = $total_time % 60;
echo $hours.':'.$minutes.':'.$seconds;
           
            ?></td>
            <td></td>
        <?php //}
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

                <select name="pg_rec" class="dropdown_per_page float_left change-xhttp-request" data-href="{base_url}shiftmanager/pg_brk_details" data-qr="output_position=content&amp;flt=true">

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