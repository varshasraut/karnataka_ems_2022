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
    $count = 1;
    foreach ($inc_data as $inc) {
        // var_dump($inc_data);die();
        ?>

<tr>         <td><?php echo $count; ?></td> 
            <td><?php echo $inc['inc_datetime']; ?></td>
            <td><?php echo $inc['inc_purpose']; ?></td>
                         
            <td><?php echo $inc['inc_complaint'];?></td>

            <td><?php echo $inc['inc_ref_id']; ?></td>

            <td><?php  echo $inc['closing_sts_dco'] ?></td>
            <td><?php echo $inc['patient_ava_or_not_other_reason']; ?></td>
            <td><?php echo $inc['inc_area_type']; ?></td>
            
            <td><?php echo $inc['amb_rto_register_no']; ?></td>
            <td><?php echo $inc['amb_type']; ?></td>

            <td><?php echo $inc['amb_base_location']; ?></td>
            <td><?php echo $inc['amb_district']; ?></td> 
            <td><?php echo $inc['pilot_name']; ?></td>
           
           <td><?php echo $inc['emt_name']; ?></td>
            <td><?php echo $inc['amb_gps_imei_no']; ?></td>
            
            <td><?php echo $inc['amb_mdt_srn_no']; ?></td>
            
            <td><?php echo $inc['inc_div_id']; ?></td> 
            <td><?php echo $inc['inc_datetime']; ?></td>
            <?php
                
                $time2 =  date_create(date($inc['inc_recive_time']));
                
                $time1 = date_create(date($inc['inc_datetime']));
                $diff=date_diff($time2,$time1);
                $diff = $diff->format("%h:%i:%s");
                
            ?>
            <td><?php echo $inc['inc_recive_time']; ?></td>
            <td><?php echo $inc['inc_dispatch_time']; ?></td>

            
            <td><?php echo $inc['clg_first_name'].' '.$inc['clg_mid_name'].' '.$inc['clg_last_name']; ?></td>
            <td><?php echo strtoupper($inc['inc_added_by']); ?></td>
            <td><?php echo '-';// echo $inc['ptn_age']; ?></td> 
            <td><?php echo $inc['inc_datetime']; ?></td> 
            <td><?php echo $inc['inc_dispatch_time'];//echo $diff; ?></td> 
            <td><?php echo $inc['start_odo']; ?></td> 
            <td><?php echo $inc['start_odo']; ?></td>
            
            <td><?php echo $inc['dp_on_scene']; ?></td> 
            <td><?php echo $inc['scene_odometer']; ?></td>
            <td><?php echo $inc['at_scene_lat']; ?></td>
            <td><?php echo $inc['at_scene_lng']; ?></td> 
            <?php 

            $time3 =  date_create(date($inc['dp_on_scene']));
            

            
            // echo $time3;die;
            $B2STime =date_diff($time3,$time1);
            
                $B2STime =  date('H:i:s', strtotime($B2STime->format("%h:%i:%s")));

                if($inc['scene_odometer']=='' || $inc['scene_odometer']==null){ $scene_odo = 0;}
                else{ $scene_odo = (int)$inc['scene_odometer'];}

                if($inc['start_odo']=='' || $inc['start_odo']==null){ $start_odo = 0;}
                else{ $start_odo = (int)$inc['start_odo'];}

                
                $B2Skm = $scene_odo - $start_odo;

                if($inc['hospital_odometer']=='' || $inc['hospital_odometer']==null){ $hos_odo = 0;}
                else{ $hos_odo = (int)$inc['hospital_odometer'];}
                
                $B2Skm = $scene_odo - $start_odo;
                $S2Hkm = $hos_odo - $scene_odo;

                $time4 =  date_create(date($inc['dp_hosp_time']));
            $S2HTime = date_diff($time4,$time3);
            $S2HTime =  date('H:i:s', strtotime($S2HTime->format("%h:%i:%s")));
            $time5  =  date_create(date($inc['dp_back_to_loc']));
            $H2BTime = date_diff($time5,$time4);
            $H2BTime =  date('H:i:s', strtotime($H2BTime->format("%h:%i:%s")));

            $time6  =  date_create(date($inc['close_time']));
            $B2BTime = date_diff($time6,$time1);
            $B2BTime =  date('H:i:s', strtotime($B2BTime->format("%h:%i:%s")));

            ?>
            
            <td><?php  echo $B2Skm; ?></td>
            <!-- <td><?php //  echo $inc['dp_started_base_loc_km']; ?></td>  -->
            <td><?php  echo $B2STime; ?></td> 
            
            
            <td><?php echo $B2STime; //echo $inc['dp_started_base_loc']; ?></td>
            <td><?php echo $inc['dp_hosp_time']; ?></td>
            
            <td><?php echo $inc['hospital_odometer']; ?></td> 
            <td><?php echo $S2HKm; ?></td> 
            <td><?php echo $S2HTime; ?></td> 
            <td><?php echo $inc['dp_hosp_time']; ?></td>  
            <td><?php echo $inc['dp_back_to_loc']; ?></td> 
            <td><?php echo $inc['end_odometer']; ?></td> 
              
            <td><?php echo $inc['back_to_bs_loc_lat']; ?></td>
            <td><?php echo $inc['back_to_bs_loc_lng']; ?></td>
             
             <?php

            
                if($inc['hospital_odometer']=='' || $inc['hospital_odometer']==null){ $hos_odo = 0;}
                else{ $hos_odo = (int)$inc['hospital_odometer'];}
                $H2Bkm = (int)$inc['end_odometer'] - $hos_odo;
                $B2Bkm = (int)$inc['end_odometer'] - $start_odo;
             ?>
             
            <td><?php echo $H2Bkm; ?></td> 
             
            <td><?php echo $H2BTime; ?></td> 

            <?php

            ?>
            <td><?php echo $B2Bkm; ?></td>
            <!-- <td><?php // echo $inc['dp_back_to_loc_km']; ?></td>  -->
            <td><?php echo $B2Bkm; ?></td>
            <td><?php echo $B2BTime; ?></td>
            <td><?php echo $inc['close_time'];// echo $inc['inc_long']; ?></td>
            
            <td><?php echo $inc['dco_name'] ?></td>
            <td><?php echo ucwords($inc['caller_name']); ?></td>
            
            <td><?php echo $inc['caller_mobile'];?></td>
            <td><?php echo '-';// echo $inc['is_validate'];?></td>
            <td><?php echo $inc['inc_district_id'];?></td>
            <td><?php echo $inc['inc_tahsil_id'];?></td>
            <td><?php echo $inc['inc_address'];?></td>

            <td><?php echo ucwords($inc['hospital_name']);?></td>
            <td><?php echo strtoupper($inc['hos_type1']);?></td>
            <td><?php echo $inc['pat_com_to_hosp_reason']; ?></td> 
            <td><?php echo $inc['inc_patient_cnt']; ?></td> 

            <td><?php echo  ($inc['patient_name']);?></td>
            <td><?php echo $inc['ptn_gender'];?></td>
            <td><?php echo $inc['ptn_mob_no'];?></td>
            <td><?php echo $inc['ptn_age'];?></td>
            <td><?php echo $inc['inc_district_id'];?></td>

            <td><?php echo $inc['inc_tahsil_id'];?></td>
            <td><?php echo $inc['inc_address'];?></td>
            <td><?php echo ucwords($inc['remark']);?></td>
            <td><?php echo $inc['provider_impressions'];?></td>
            <td><?php  echo $inc['ayushman_id'];?></td>

            <td><?php echo $inc['drop_district'];?></td>
            <td><?php echo $inc['drop_home_address'];?></td>
            <td><?php echo '-';// echo $inc['division'];?></td>
            <td><?php echo '-';// echo $inc['valid_remark'];?></td>
            <td><?php echo $inc['inc_back_home_address'];?></td>

            <td><?php echo strtoupper($inc['hos_type1']);?></td>
            <td><?php echo '-';// echo $inc['is_validate'];?></td>
            <td><?php echo '-';// echo $inc['division'];?></td>
            <td><?php echo $inc['opd_no_txt'];?></td>
            <td><?php echo '-';// echo $inc['validate_date'];?></td>

            <td><?php echo $inc['pr_total_amount'];?></td>
        </tr>

        <?php
        $count++;
    }
    ?>

</table>

