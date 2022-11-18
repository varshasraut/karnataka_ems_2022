<div class="width_25 float_right" style="margin-bottom: 10px;">
    <div class="button_field_row">
        <div class="button_box">
            <form action="<?php echo base_url(); ?>erc_reports/<?php echo $submit_funtion ?>" method="post" enctype="multipart/form-data" target="form_frame">
                <input type="hidden" value="<?php echo $report_args['to_date']; ?>" name="to_date">
                <input type="hidden" value="<?php echo $report_args['clg_group']; ?>" name="department_name">
                <input type="hidden" value="<?php echo $report_args['from_date']; ?>" name="from_date">
                <input type="hidden" value="<?php echo $report_args['single_date']; ?>" name="single_date">
                <input type="hidden" value="<?php echo $report_args['clg_ref_id']; ?>" name="user_id">

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
        $d_start = new DateTime($inc['clg_login_time']);
                $d_end = new DateTime($inc['clg_logout_time']);
                $resonse_time = $d_start->diff($d_end);
                //var_dump($resonse_time);die;
                $resonse_time1 = $resonse_time->h . ':' . $resonse_time->i . ':' . $resonse_time->s;
                 //print_r($resonse_time1);
        ?>
        <tr>         
            <td><?php echo $inc['clg_login_time']; ?></td> 
            <td><?php echo ucwords($inc['clg_first_name'] . ' ' . $inc['clg_mid_name'] . ' ' . $inc['clg_last_name']); ?></td> 
            <td><?php echo $inc['clg_login_time']; ?></td>
            <td><?php if($inc['clg_logout_time'] == "0000-00-00 00:00:00"){ echo "Currently Login"; }else{echo $inc['clg_logout_time'];}//date("d-m-Y h:i:s", strtotime($inc->clg_logout_time)); ?></td>
            <td><?php  echo $resonse_time1;//date("d-m-Y h:i:s", strtotime($inc->clg_logout_time)); ?></td>
            <td> <?php     $thirdparty = '';
            if($inc['clg_third_party'] != ''){
                $thirdparty = get_third_party_name($inc['clg_third_party']);
            }
            echo $thirdparty;
                ?> 
            </td>
        </tr>
        <?php
        $count++;
    }
    ?>

</table>