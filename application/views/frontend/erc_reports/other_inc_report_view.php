<div class="width_25 float_right" style="margin-bottom: 10px;">
    <div class="button_field_row">
        <div class="button_box">
            <form action="<?php echo base_url(); ?>erc_reports/other_incident_report" method="post" enctype="multipart/form-data" target="form_frame">
                <input type="hidden" value="<?php echo $report_args['to_date']; ?>" name="to_date">
                <input type="hidden" value="<?php echo $report_args['from_date']; ?>" name="from_date">
                <input type="hidden" value="<?php echo $report_args['system']; ?>" name="system">
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
    $count = 1;
    foreach ($inc_data as $inc) {

        if($inc->inc_recive_time != '' ){
            $d1= new DateTime($inc->inc_recive_time);
            
        
        $d2=new DateTime($inc->inc_datetime);
        $duration=$d2->diff($d1);
       // var_dump($duration);
            }
           if($duration != NULL){
           $duration = $duration->h . ':' . $duration->i . ':' . $duration->s;
          $duration = date('H:i:s', strtotime($duration));
                   }
           else{
               $duration= "00:00:00";
           }
           $clg_full_name = $inc->clg_first_name . ' ' . $inc->clg_mid_name . ' ' . $inc->clg_last_name;
        ?>

        <tr>         
            <td><?php echo $count; ?></td>
            <td><?php echo $inc->inc_recive_time; ?></td>
            <td><?php echo $inc->inc_ref_id; ?></td>
            <td><?php echo ucfirst($inc->pname); ?></td>
            <td><?php echo $inc->clr_mobile; ?></td> 
            <td><?php echo ucfirst($inc->clr_fname); ?> <?php echo ucfirst($inc->clr_lname); ?></td> 
            <td><?php echo $inc->re_name; ?></td> 
            <td><?php echo $inc->inc_ero_summary; ?></td> 
            <td><?php echo $inc->inc_datetime; ?></td>
            <td><?php echo $duration; ?></td> 
            <td><?php echo ucwords($inc->inc_added_by); ?></td> 
            <td><?php echo $clg_full_name ?></td>
            <!--<td><?php echo $inc->thirdparty_name;?> </td>-->


        </tr>

        <?php
        $count++;
    }
    ?>

</table>