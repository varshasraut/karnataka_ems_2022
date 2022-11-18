<div class="width_25 float_right" style="margin-bottom: 10px;">
            <div class="button_field_row">
                <div class="button_box">
                    <form action="<?php echo base_url(); ?>erc_reports/<?php echo $weekly_function;?>" method="post" enctype="multipart/form-data" target="form_frame">
                        <input type="hidden" value="<?php echo $report_args['to_date'];?>" name="to_date">
                        <input type="hidden" value="<?php echo $report_args['from_date'];?>" name="from_date">
                        <input type="hidden" value="<?php echo $report_args['system'];?>" name="system">
                         <input type="hidden" value="<?php echo $single_date;?>" name="single_date">
                        <input type="hidden" value="<?php echo $report_args['inc_type'];?>" name="call_purpose">
                        <input type="submit" name="submit" value="Download" TABINDEX="3" class="float_right">
                    </form>
                </div>
                
            </div>
</div>   
<table class="table report_table">
    <tr>                              
        <?php
            // var_dump($days);
        foreach($header as $heading){?>
        <th style="line-height: 20px;"><?php echo $heading;?></th>
        <?php }?>
    </tr>
    <?php //foreach($daily_report_array as $key=>$daily_report){ 
    for($hh=0;$hh<24;$hh++){
    ?>

     <tr>         
        
        <td><?php echo $hours_key_array[$hh];?></td>
        <td><?php if(!empty($daily_report_array[$hh]['total_inc'])){
            $total_inc = count($daily_report_array[$hh]['total_inc']);
            echo $total_inc;
            //var_dump($days);
//            if($days > 0){
//                $avg_total_inc = ((int)$total_inc / (int)$days);
//                echo round($avg_total_inc,2);
//            }else{
//                $avg_total_inc = ((int)$total_inc);
//                echo count($daily_report_array[$hh]['total_inc']);
//            }
            $daily_count = $daily_count + $total_inc;
            
        }else{ 
            echo '0'; 

        } ?></td> 
        <td><?php if(!empty($daily_report_array[$hh]['dispatch_inc'])){ 
                $dispatch_inc = count($daily_report_array[$hh]['dispatch_inc']);
//                if($days > 0){
//                    $avg_dis_inc = ((int)$daily_report_array[$hh]['dispatch_inc']/(int)$days);
//                    echo round($avg_dis_inc,2);
//                }else{
//                    $avg_dis_inc = $dispatch_inc;
//                    echo count($daily_report_array[$hh]['dispatch_inc']); 
//                }
                echo $dispatch_inc;
            $dispatch_inc_total = $dispatch_inc_total + $dispatch_inc;
        }else{ echo '0'; } ?></td>
        <td><?php if(!empty($daily_report_array[$hh]['epcr_inc'])){ 
            
             $epcr_inc_inc = count($daily_report_array[$hh]['epcr_inc']);
//                if($days > 0){
//                    $avg_epcr_inc = ((int)$epcr_inc_inc/(int)$days);
//                    echo round($avg_epcr_inc,2);
//                }else{
//                     $avg_epcr_inc = $epcr_inc_inc;
//                    echo count($daily_report_array[$hh]['epcr_inc']); 
//                }
             echo $epcr_inc_inc;
               $epcr_inc = $epcr_inc + $epcr_inc_inc;
            }else{ 
                echo '0'; 

            } ?></td> 

    </tr>
    <?php }?>
    <tr>                               
        <td><strong>Total</strong></td>
        <td>
            <strong><?php
            $daily_count_total= $daily_count?$daily_count:0;
            //echo $daily_count_total;
//             if($days > 0){
//                    $daily_count_total_avg = ((int)$daily_count_total/(int)$days);
//                    echo round($daily_count_total_avg,2);
//                }else{
                    echo $daily_count_total; 
//                }
            ?></strong>
        </td> 
        <td>
            <strong><?php $dispatch_inc_total = $dispatch_inc_total?$dispatch_inc_total:0; 

//                if($days > 0){
//                    $dispatch_inc_total_avg = ((int)$dispatch_inc_total/(int)$days);
//                    echo round($dispatch_inc_total_avg,2);
//                }else{
                    echo $dispatch_inc_total; 
//                }
            ?></strong>
        </td>
        <td>
            <strong><?php $epcr_inc_total = $epcr_inc?$epcr_inc:0;
            //echo $epcr_inc_total;
//            if($days > 0){
//                    $epcr_inc_avg = ((int)$epcr_inc_total/(int)$days);
//                    echo round($epcr_inc_avg,2);
//                }else{
                    echo $epcr_inc_total; 
//                }
            ?></strong>
        </td>                   
    </tr>
</table>