<div class="width_25 float_right" style="margin-bottom: 10px;">
    <div class="button_field_row">
        <div class="button_box">
            <form action="<?php echo base_url(); ?>erc_reports/<?php echo $submit_funtion ?>" method="post" enctype="multipart/form-data" target="form_frame">
                <input type="hidden" value="<?php echo $report_args['to_date']; ?>" name="to_date">
                <input type="hidden" value="<?php echo $report_args['clg_group']; ?>" name="department_name">
                <input type="hidden" value="<?php echo $report_args['from_date']; ?>" name="from_date">
                <input type="hidden" value="<?php echo $user_id; ?>" name="ref_id">
                <input type="hidden" value="<?php echo $system; ?>" name="system">
               
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
        //var_dump($report_args['from_date']);die;
        $fr=$report_args['from_date'];
        $to=$report_args['to_date'];
        ?>
        <tr>     
           
            <td><?php echo  $count; ?></td> 
            
           
            <td><?php echo $inc['pname']; ?></td>
            <td><?php $calls_total = get_total_by_call_type($user_id,$inc['pcode'],$dur="ft",$fr,$to,$system); 
                        if($calls_total){
                           // var_dump($calls_total);die;
                            echo $calls_total;
                           
                        }else{
                            echo "0";
                        }
                        ?></td>
            <td> <?php  
                        
                        $thirdparty = '';
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
    <td></td>
<td><b><?php echo "Total Calls"; ?></b></td>
<td><b><?php  $calls_total = get_total_by_call_type($user_id,$inc['pcode']="",$dur="ft",$fr,$to,$system); 
                        if($calls_total){
                           // var_dump($calls_total);die;
                            echo $calls_total;
                           
                        }else{
                            echo "0";
                        } ?></b></td>
</table>