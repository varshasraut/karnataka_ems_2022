


 <div class="width_25 float_right" style="margin-bottom: 10px;">
            <div class="button_field_row">
                <div class="button_box">
                    <form action="<?php echo base_url(); ?>erc_reports/amb_avail_hourly_report" method="post" enctype="multipart/form-data" target="form_frame">
                    
                        <input type="hidden" value="<?php echo $report_args['from_date'];?>" name="from_date">
                         <input type="hidden" value="<?php echo $single_date;?>" name="single_date">
                        <input type="submit" name="submit" value="Download" TABINDEX="3" class="float_right">
                    </form>
                </div>
                
            </div>
</div>   
<table class="table report_table">
    <tr>                              
        <?php
        foreach($header as $heading){?>
        <th style="line-height: 20px;"><?php echo $heading;?></th>
        <?php }?>
    </tr>
    <?php 
    for($hh=0;$hh<24;$hh++){
    ?>

     <tr>         

        <td><?php echo $hours_key_array[$hh];?></td>
        
        <td><?php if(!empty($daily_report_array[$hh]['available_count'])){
            $available = $daily_report_array[$hh]['available_count'];
        
            $available_count  =  $available[0] ; 
            echo $available_count ;
            $total_available_count = $total_available_count + $available_count;
 
            }else{ 
                 echo '0'; 

            } ?>
        </td> 


        <td><?php if(!empty($daily_report_array[$hh]['busy_count']))
        { 
            $busy = $daily_report_array[$hh]['busy_count'];
            $busy_count = $busy[0] ; 
            echo $busy_count;
            $total_busy_count =  $total_busy_count + $busy_count;

        } 
        else 
        { 
            echo '0'; 
        } ?>

           
       </td>
        <td><?php if(!empty($daily_report_array[$hh]['inactive_count']))
        {
           $inactive = $daily_report_array[$hh]['inactive_count'];
           $inactive_count = $inactive[0] ;
           echo $inactive_count ;
           $total_inactive_count = $total_inactive_count + $inactive_count;   
        } 
        else 
        { 
            echo '0'; 

        } ?>   
        </td> 
       

    </tr>
    <?php }?>
    <tr>                               
        <td><strong>Total</strong></td>
        <td>
            <strong><?php
            echo   $total_available_count;
            ?></strong>
        </td> 

        <td>
            <strong><?php
            echo  $total_busy_count ;
            ?></strong>
        </td>
        <td>
            <strong><?php
            echo $total_inactive_count;
            ?></strong>
        </td>                   
    </tr>
</table>