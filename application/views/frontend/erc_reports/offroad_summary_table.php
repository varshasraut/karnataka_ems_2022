<div class="width_25 float_right" style="margin-bottom: 10px;">
    <div class="button_field_row">
        <div class="button_box">
            <form action="<?php echo base_url(); ?>erc_reports/<?php echo $submit_function; ?>" method="post" enctype="multipart/form-data" target="form_frame">
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
    $total = 0;
    foreach ($inc_data as $inc) {
        // print_r($inc); 
        ?>
        <tr>
            <td style="text-align:center"><?php echo $inc['name']; ?></td>
            <td style="text-align:center"><?php echo $inc['als']; ?></td>
            <td style="text-align:center"><?php echo $inc['bls']; ?></td>
            <td style="text-align:center"><?php echo $inc['je']; ?></td>
            <td style="text-align:center"><?php echo $inc['total']; ?></td>
        </tr>
        <?php
        $als += (int)$inc['als'];
        $bls += (int)$inc['bls'];
        $je += (int)$inc['je'];
        $total += (int)$inc['total'];
    }
    ?>
         <tr>
            <td style="text-align:center;font-weight:bold;">Grand Total</td>
            <td style="text-align:center;font-weight:bold;"><?php echo $als; ?></td>
            <td style="text-align:center;font-weight:bold;"><?php echo $bls; ?></td>
            <td style="text-align:center;font-weight:bold;"><?php echo $je; ?></td>
            <td style="text-align:center;font-weight:bold;"><?php echo $total; ?></td>
        </tr>

</table>

