<div class="width_25 float_right" style="margin-bottom: 10px;">
    <div class="button_field_row">
        <div class="button_box">
            <form action="<?php echo base_url(); ?>erc_reports/amb_district_onroad_offroad_report" method="post" enctype="multipart/form-data" target="form_frame">
                <input type="hidden" value="<?php echo $report_args['to_date']; ?>" name="to_date">
                <input type="hidden" value="<?php echo $report_args['from_date']; ?>" name="from_date">
                <input type="hidden" value="<?php echo $report_args['dist']; ?>" name="onroad_report_type_dist">
                <input type="hidden" value="<?php echo $report_args['zone']; ?>" name="onroad_report_type_divs">
                <input type="submit" name="submit" value="Download" TABINDEX="3" class="float_right">
            </form>
        </div>

    </div>
</div>   
<table class="table report_table1">

    <tr>                              
        <?php foreach ($header as $heading) { ?>
            <th style="line-height: 25px;"><?php echo $heading; ?></th>
            <?php } ?>
    </tr>
    <?php 
    $count = 1;
    foreach ($inc_data as $key => $inc) {
      
        ?>
        <tr style="text-align: center;">         
            <td><?php echo $count; ?></td>
<!--            <td><?php echo $key; ?></td>-->
            <td><?php echo $inc['div_name']; ?></td>
            <td><?php echo $inc['dst_name']; ?></td>
            <td><?php echo $inc['hp_name']; ?></td>
            <td><?php echo $key; ?></td>
            <td><?php echo $inc['ambt_name']; ?></td>
            <td><?php echo $inc['total_hour']; ?></td>

            <td><?php
                $off_road_seconds = $inc['off_road'];
                $H = floor($off_road_seconds / 3600);
                $i = ($off_road_seconds / 60) % 60;
                $s = $off_road_seconds % 60;
                $off_road = sprintf("%02d:%02d:%02d", $H, $i, $s);
                echo $off_road;
                ?></td>
            <td><?php
                $on_road_seconds = $inc['on_road'];
                $on_H = floor($on_road_seconds / 3600);
                $on_i = ($on_road_seconds / 60) % 60;
                $on_s = $on_road_seconds % 60;
                $on_road = sprintf("%02d:%02d:%02d", $on_H, $on_i, $on_s);
                echo $on_road;
                ?></td> 
            <td><?php 
             $up_time = $inc['up_time'];
            $Hs = floor($up_time / 3600);
            $is = ($up_time / 60) % 60;
            $ss = $up_time % 60;
            $off_road = sprintf("%02d:%02d:%02d", $Hs, $is, $ss);
            echo round($up_time,2);
            ?>%</td>
    <!--            <td><?php
            $off_road_seconds = $inc['off_road'];
            $H = floor($off_road_seconds / 3600);
            $i = ($off_road_seconds / 60) % 60;
            $s = $off_road_seconds % 60;
            $off_road = sprintf("%02d:%02d:%02d", $H, $i, $s);
            echo $off_road;
            ?></td> -->
        </tr>
        <?php
        $count++;
    }
    ?>

</table>

<style> table.report_table1, .report_table1 td { border: 1px solid gray; border-collapse: collapse; } </style>
