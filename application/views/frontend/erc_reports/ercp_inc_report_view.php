<div class="width_25 float_right" style="margin-bottom: 10px;">
    <div class="button_field_row">
        <div class="button_box">
            <form action="<?php echo base_url(); ?>erc_reports/<?php echo $submit_funtion ?>" method="post" enctype="multipart/form-data" target="form_frame">
                <input type="hidden" value="<?php echo $report_args['to_date']; ?>" name="to_date">
                <input type="hidden" value="<?php echo $report_args['clg_group']; ?>" name="department_name">
                <input type="hidden" value="<?php echo $report_args['from_date']; ?>" name="from_date">
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
    foreach ($inc_data as $inc) {
//var_dump($inc);  
if($row->atnd_date != '' ){
    $d1= new DateTime($row->atnd_date);
    

$d2=new DateTime($row->adv_cl_date);
$duration=$d2->diff($d1);
//var_dump($duration);die;
    }
   if($duration != NULL){
   $duration = $duration->h . ':' . $duration->i . ':' . $duration->s;
   }
   else{
       $duration= "00:00:00";
   }

        ?>
        <tr>         
            <td><?php echo $inc['adv_inc_ref_id']; ?></td> 
            <td><?php echo $inc['ptn_fullname']; ?></td> 
            <td><?php echo $inc['ptn_age']; ?></td>
            <td><?php echo $inc['ptn_gender']; ?></td>
            <td><?php echo get_purpose_of_call($inc['inc_type']); ?></td>
            <td><?php echo $inc['ct_type']; ?></td>
            <td><?php if($inc['atnd_date'] != NULL){ echo $inc['atnd_date'];} echo " "; ?></td>
            <!-- <td><?php echo $inc['clr_mobile']; ?></td> -->
            <td><?php echo $inc['dst_name']; ?></td>
            <td><?php echo $inc['adv_cl_ercp_addinfo']; ?></td>
<!--            <td></td>-->
            <td><?php echo ucwords($inc['adv_emt']); ?></td>
            <td><?php echo $inc['adv_cl_date']; ?></td>
            <td><?php echo $inc['duration']; ?></td>
            <td><?php if($inc['inc_pcr_status']=='1'){echo "Closed";} else{echo "Pending"; } ?></td>
        </tr>
        <?php
    }
    ?>

</table>