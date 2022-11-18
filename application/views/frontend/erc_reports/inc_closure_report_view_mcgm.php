<div class="width_25 float_right" style="margin-bottom: 10px;">
    <div class="button_field_row">
        <div class="button_box">
            <form action="<?php echo base_url(); ?>erc_reports/closure_dco_report_mcgm" method="post" enctype="multipart/form-data" target="form_frame">
                <input type="hidden" value="<?php echo $report_args['to_date']; ?>" name="to_date">
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
    $count = 1;
    $inc_data_arr = array();
    foreach ($inc_data as $inc) {
        $incident_date=$inc['inc_datetime'];
        if (in_array($inc['inc_ref_id'],$inc_data_arr)){
            $inc['inc_datetime'] = '-';
            $inc['dp_on_scene'] = '-';
            $inc['responce_time'] = '-';
        }else{
            array_push($inc_data_arr,$inc['inc_ref_id']);
        }
    ?>

        <tr>         

            <td><?php echo $inc['inc_ref_id']; ?></td> 
            <td><?php echo $incident_date; ?></td> 
            <td><?php echo $inc['caller_mobile']; ?></td> 
            <td><?php echo $inc['caller_name']; ?></td> 
            <td><?php echo $inc['patient_name']; ?></td> 
            <td><?php echo $inc['ptn_gender']; ?></td> 
            <td><?php echo $inc['ptn_age']; ?></td> 
            <td><?php echo $inc['amb_rto_register_no']; ?></td>
            <td><?php echo $inc['amb_base_location']; ?></td>
            <td><?php echo $inc['wrd_location']; ?></td>
            <td><?php echo $inc['parameter']; ?></td>
            <td><?php echo $inc['inc_purpose']; ?></td>
            <td><?php echo $inc['base_location']; ?></td> 
            <td><?php echo $inc['inc_datetime']; ?></td> 
            <td><?php echo $inc['dp_on_scene']; ?></td> 
            <td><?php echo $inc['responce_time']; ?></td> 
            <td>
                <?php   
                         $thirdparty = '';
            if($inc['third_party'] != ''){
                $thirdparty = get_third_party_name($inc['third_party']);
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