<div class="width_25 float_right" style="margin-bottom: 10px;">
    <div class="button_field_row">
        <div class="button_box">
            <form action="<?php echo base_url(); ?>erc_reports/<?php echo $submit_function ?>" method="post" enctype="multipart/form-data" target="form_frame">
            <input type="hidden" value="<?php echo $report_args['from_date']; ?>" name="from_date">
            <input type="hidden" value="<?php echo $report_args['to_date']; ?>" name="to_date">
                <input type="hidden" value="<?php echo $report_args['divs']; ?>" name="onroad_report_type_divs">
                <input type="hidden" value="<?php echo $report_args['dist']; ?>" name="onroad_report_type_dist">
				<input type="hidden" value="<?php echo $maintenance_type; ?>" name="maintenance_type">
                
                <input type="submit" name="submit" value="Download" TABINDEX="3" class="float_right">
            </form>
        </div>

    </div>
</div>  

<div class="width100"><lable><?php echo $maint_type; ?></label></div>
<table class="table report_table">
    <tr>                              
        <?php foreach ($header as $heading) { ?>
        <th style="line-height: 20px;"><?php echo $heading; ?></th>
        <?php } ?>
    </tr>
    <?php
    $count = 1;
    if($general_offroad_re){
    foreach ($general_offroad_re as $main_data) { 
        //  var_dump($main_data->prilimnary_inform);die();
        // print_r($main_data);die();
        
        if($main_data->ins_amb_current_status == 'amb_onroad' || $main_data->ins_amb_current_status=='amb_offroad'){
            $ins_amb_current_status = 'On-Road';
        }else{
            $ins_amb_current_status = 'Off-Road';
        }
        if($main_data->status == 'Available' || $main_data->status == 'Not_Available'){
            $status = 'Available';
        }else{
            $status = 'Not Available';
        }

       
        if($main_data->eqp_cat == '1'){
            $eqp_cat = $main_data->cri_eqp_name;
        }elseif($main_data->eqp_cat == '2'){
            $eqp_cat = $main_data->maj_eqp_name;
        }elseif($main_data->eqp_cat == '3'){
            $eqp_cat = $main_data->min_eqp_name;
        }

        $start_date = new DateTime(date('Y-m-d H:i:s',strtotime($main_data->mt_offroad_datetime)));  
        if($main_data->mt_offroad_datetime!='' && $main_data->mt_offroad_datetime != '1970-01-01 05:30:00' && $main_data->mt_offroad_datetime != '0000-00-00 00:00:00'){
            if($main_data->mt_onroad_datetime != '' && $main_data->mt_onroad_datetime != '1970-01-01 05:30:00' && $main_data->mt_onroad_datetime != '0000-00-00 00:00:00'){
                $end_date = new DateTime(date('Y-m-d H:i:s',strtotime($main_data->mt_onroad_datetime))); 
            }else{
                $end_date = new DateTime(date('Y-m-d H:i:s')); 
            }
            $duration = '0';
            if(strtotime($main_data->mt_offroad_datetime) < strtotime($main_data->mt_onroad_datetime)){
                $since_start = $start_date->diff($end_date);
                $duration= $since_start->days;
            }else{
                $since_start = $start_date->diff($end_date);
                $duration= $since_start->days;
            }
        }else{
            $duration = '0';
        }
        if($main_data->prilimnari_inform =='1'){
            $prilimnari_inform = 'Manager';
        }
       
        ?>
        <tr>  
            <td style="text-align: center;"><?php echo $count; ?></td>
            <td><?php echo $main_data->griv_name ; ?> </td>
            <td><?php echo $main_data->gri_sub_type; ?></td>
            <td><?php echo $prilimnari_inform; ?></td>
            <td><?php echo $main_data->remark; ?></td>
            <td><?php echo $main_data->added_date; ?></td>
            <td><?php echo $main_data->clg_first_name. ' '.$main_data->clg_mid_name. ' '.$main_data->clg_last_name; ?></td>
           
        </tr>
        <?php
        $count++;
    }
    }
     ?>
</table>
<iframe name="form_frame" style="height: 1px; width: 1px; border:0px; background: none;"></iframe>
