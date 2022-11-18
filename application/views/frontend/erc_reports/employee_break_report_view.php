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
        $break_date =date('Y-m-d', strtotime($inc['clg_break_time']));
        $break_time=date('H:i:s', strtotime($inc['clg_break_time']));
        ?>
        <tr>         
            <td><?php echo $break_date; ?></td> 
            <td><?php echo $break_time; ?></td> 
            <td><?php echo ucwords($inc['clg_first_name'] . ' ' . $inc['clg_mid_name'] . ' ' . $inc['clg_last_name']);?></td> 
            <td><?php echo $inc['break_name']; ?></td>
            <td><?php echo $inc['clg_break_time']; ?></td>
            <td><?php echo $inc['clg_back_to_break_time']; ?></td>
            <td><?php echo $inc['break_time']; ?></td>
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