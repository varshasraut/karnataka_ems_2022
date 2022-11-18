<div class="width_25 float_right" style="margin-bottom: 10px;">
            <div class="button_field_row">
                <div class="button_box">
                    <form action="<?php echo base_url(); ?>reports/amb_onroad_offroad_report" method="post" enctype="multipart/form-data" target="form_frame">
                        <input type="hidden" value="<?php echo $report_args['to_date'];?>" name="to_date">
                        <input type="hidden" value="<?php echo $report_args['from_date'];?>" name="from_date">
                        <input type="submit" name="submit" value="Download" TABINDEX="3" class="float_right">
                    </form>
                </div>
                
            </div>
</div>   
<table class="table report_table">

                    <tr>                              
                        <?php foreach($header as $heading){?>
                        <th style="line-height: 20px;"><?php echo $heading;?></th>
                        <?php }?>
                    </tr>
                    <?php foreach($inc_data as $key=>$inc){ ?>
                         <tr>         
                        
                        <td><?php echo $key;?></td>
                         <!-- <td><?php echo $inc['hp_name'];?></td> -->
                        <td><?php   $on_road_seconds = $inc['on_road'];
                $on_H = floor($on_road_seconds / 3600);
                $on_i = ($on_road_seconds / 60) % 60;
                $on_s = $on_road_seconds % 60;
                $on_road = sprintf("%02d:%02d:%02d", $on_H, $on_i, $on_s); 
                echo $on_road; ?></td>
                <td>
                   <?php
                   $seconds_in_month = strtotime($report_args['to_date'] . ' 24:00:00') - strtotime($report_args['from_date'] . ' 00:00:00');
           
                   $H = floor($seconds_in_month / 3600);
                   $i = ($seconds_in_month / 60) % 60;
                   $s = $seconds_in_month % 60;
                   $totol_hour_in_month = sprintf("%02d:%02d:%02d", $H, $i, $s);
                   $on_per=($on_road/$totol_hour_in_month)*100;
                  // echo $on_per;
                   if (strpos($on_per, '.') == TRUE) {
                        echo number_format((float)$on_per, 2, '.', '');;
                }else{
                    echo $on_per;
                }
                   ?>
                </td>
                        <td><?php   $off_road_seconds = $inc['off_road'];
                $H = floor($off_road_seconds / 3600);
                $i = ($off_road_seconds / 60) % 60;
                $s = $off_road_seconds % 60;
                $off_road = sprintf("%02d:%02d:%02d", $H, $i, $s); echo $off_road; ?></td>
                <td>
                   <?php 
                    $seconds_in_month = strtotime($report_args['to_date'] . ' 24:00:00') - strtotime($report_args['from_date'] . ' 00:00:00');
           
                    $H = floor($seconds_in_month / 3600);
                    $i = ($seconds_in_month / 60) % 60;
                    $s = $seconds_in_month % 60;
                    $totol_hour_in_month = sprintf("%02d:%02d:%02d", $H, $i, $s);
                   $off_per=($off_road/$totol_hour_in_month)*100;
                   if (strpos($off_per, '.') == TRUE) {
                    echo number_format((float)$off_per, 2, '.', '');;
            }else{
                echo $off_per;
            }?>
                </td>
                        <!-- <td><?php  $off_road_seconds = $inc['off_road'];
                $H = floor($off_road_seconds / 3600);
                $i = ($off_road_seconds / 60) % 60;
                $s = $off_road_seconds % 60;
                $off_road = sprintf("%02d:%02d:%02d", $H, $i, $s); echo $off_road;?></td>  -->
                        <!-- <td><?php echo $inc['total_hour'];?></td> -->

                        
                         </tr>
                    <?php }?>

</table>