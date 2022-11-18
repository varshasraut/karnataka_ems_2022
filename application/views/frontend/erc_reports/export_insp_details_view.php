<div class="width_25 float_right" style="margin-bottom: 10px;">
    <div class="button_field_row">
        <div class="button_box">
            <form action="<?php echo base_url(); ?>erc_reports/<?php echo $submit_function ?>" method="post"
                enctype="multipart/form-data" target="form_frame">
                <input type="hidden" value="<?php echo $report_args['divs']; ?>" name="onroad_report_type_divs">
                <input type="hidden" value="<?php echo $report_args['dist']; ?>" name="onroad_report_type_dist">
                <input type="hidden" value="<?php echo $report_args['from_date']; ?>" name="from_date">
                <input type="hidden" value="<?php echo $report_args['to_date']; ?>" name="to_date">

                <input type="hidden" value="<?php echo $maintenance_type; ?>" name="maintenance_type">

                <input type="submit" name="submit" value="Download" TABINDEX="3" class="float_right">
            </form>
        </div>

    </div>
</div>

<div class="width100">
    <lable><?php echo $maint_type; ?></label>
</div>
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
        if($main_data->prilimnari_inform =='1'){
            $prilimnari_inform = 'Manager';
        }  


        //  var_dump($main_data->amb_type_on);die();
        // print_r($main_data);die();
        // if($main_data->mt_district_id!= ' '){
        //     $current_district = get_district_by_id($main_data->mt_district_id);
        // }
        // if($main_data->amb_type != '' || $main_data->amb_type != 0 ){ 
        //     $amb_type =  show_amb_type_name($main_data->amb_type);
        // }
        // $amb_model =  show_amb_model_name($main_data->mt_amb_no);
        //$amb_status =  show_amb_staus($main_data->mt_amb_no);
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

        // if($main_data->med_status == 'Y' || $main_data->med_status == 'N'){
        //     $med_status = 'Yes';
        // }else{
        //     $med_status = 'No';
        // }

        // if($main_data->ins_amb_type == '1') 
        // {$ins_amb_type = 'ALS';} 

        // elseif($main_data->ins_amb_type == '2') 
        // {$ins_amb_type = 'BLS';}

        // elseif($row->ins_amb_type == '3') 
        // {$ins_amb_type = 'JE';}

        if($main_data->eqp_type == '1'){
            $cri_eqp_name = $main_data->cri_eqp_name;
            $cri_status = $main_data->cri_status;
            $cri_oprational = $main_data->cri_oprational;
            $cri_date_from = $main_data->cri_date_from;
            $cri_remark = $main_data->eqp_critical_remark;    
        }elseif($main_data->eqp_type == '2'){
            $maj_eqp_name = $main_data->maj_eqp_name;
            $maj_status = $main_data->maj_status;
            $maj_oprational = $main_data->maj_oprational;
            $maj_date_from = $main_data->maj_date_from;
            $maj_remark = $main_data->eqp_major_remark;
        }elseif($main_data->eqp_type == '3'){
            $min_eqp_name = $main_data->min_eqp_name;
            $min_status = $main_data->min_status;
            $min_oprational = $main_data->min_oprational;
            $min_date_from = $main_data->min_date_from;
            $min_remark = $main_data->eqp_minor_remark;
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
       
        ?>
    <tr>
        <td style="text-align: center;"><?php echo $count; ?></td>
        <td><?php echo $main_data->div_name; ?> </td>
        <td><?php echo $main_data->dst_name; ?></td>
        <td><?php echo $main_data->ins_baselocation; ?></td>
        <td><?php echo $main_data->ins_amb_no; ?></td>
        <td><?php echo $main_data->ins_amb_model; ?></td>
        <td><?php echo $main_data->amb_type_on; ?></td>
        <td><?php echo $ins_amb_current_status; ?></td>
        <td><?php echo $main_data->ins_gps_status; ?></td>
        <td><?php echo $main_data->ins_pilot; ?></td>
        <td><?php echo $main_data->ins_emso; ?></td>
        <td><?php echo $main_data->ins_odometer; ?></td>
        <td style="text-align: center;">
            <?php if($main_data->ins_main_date == "0000-00-00 00:00:00"){$insdate="-";}else{$insdate=$main_data->ins_main_date;} echo $insdate; ?>
        </td>
        <td><?php echo $main_data->ins_main_due_status; ?></td>
        <td><?php echo $main_data->ins_main_status; ?></td>
        <td><?php echo $main_data->ins_main_remark; ?></td>
        <!-- <td><?php echo $main_data->ins_clean_date; ?></td> -->
        <td style="text-align: center;">
            <?php if($main_data->ins_clean_date == "0000-00-00 00:00:00"){$cleandate="-";}else{$cleandate=$main_data->ins_clean_date;} echo $cleandate; ?>
        </td>
        <td><?php echo $main_data->ins_clean_status; ?></td>
        <td><?php echo $main_data->ins_clean_remark; ?></td>
        <td><?php echo $main_data->ac_status; ?></td>
        <!-- <td><?php echo $main_data->ac_working_date; ?></td> -->
        <td style="text-align: center;">
            <?php if($main_data->ac_working_date == "0000-00-00 00:00:00"){$acdate="-";}else{$acdate=$main_data->ac_working_date;} echo $acdate; ?>
        </td>
        <td><?php echo $main_data->ac_remark; ?></td>
        <td><?php echo $main_data->tyre_status; ?></td>
        <!-- <td><?php echo $main_data->tyre_working_date; ?></td> -->
        <td style="text-align: center;">
            <?php if($main_data->tyre_working_date == "0000-00-00 00:00:00"){$tyredate="-";}else{$tyredate=$main_data->tyre_working_date;} echo $tyredate; ?>
        </td>
        <td><?php echo $main_data->tyre_remark; ?></td>
        <td><?php echo $main_data->siren_status; ?></td>
        <!-- <td><?php echo $main_data->siren_working_date; ?></td> -->
        <td style="text-align: center;">
            <?php if($main_data->siren_working_date == "0000-00-00 00:00:00"){$sirendate="-";}else{$sirendate=$main_data->siren_working_date;} echo $sirendate; ?>
        </td>
        <td><?php echo $main_data->inv_remark; ?></td>
        <td><?php echo $main_data->inv_status; ?></td>
        <!-- <td><?php echo $main_data->inv_working_date; ?></td> -->
        <td style="text-align: center;">
            <?php if($main_data->inv_working_date == "0000-00-00 00:00:00"){$invdate="-";}else{$invdate=$main_data->inv_working_date;} echo $invdate; ?>
        </td>
        <td><?php echo $main_data->inv_remark; ?></td>
        <td><?php echo $main_data->batt_status; ?></td>
        <!-- <td><?php echo $main_data->batt_working_date; ?></td> -->
        <td style="text-align: center;">
            <?php if($main_data->batt_working_date == "0000-00-00 00:00:00"){$batdate="-";}else{$batdate=$main_data->batt_working_date;} echo $batdate; ?>
        </td>
        <td><?php echo $main_data->batt_remark; ?></td>
        <td><?php echo $main_data->gps_status; ?></td>
        <!-- <td><?php echo $main_data->gps_working_date; ?></td> -->
        <td style="text-align: center;">
            <?php if($main_data->gps_working_date == "0000-00-00 00:00:00"){$gpsdate="-";}else{$gpsdate=$main_data->gps_working_date;} echo $gpsdate; ?>
        </td>
        <td><?php echo $main_data->gps_remark; ?></td>
        <!-- <td><?php echo $main_data->ins_pcs_stock_date; ?></td> -->
        <td style="text-align: center;">
            <?php if($main_data->ins_pcs_stock_date == "0000-00-00"){$pcrdate="-";}else{$pcrdate=$main_data->ins_pcs_stock_date;} echo $pcrdate; ?>
        </td>
        <td><?php echo $main_data->ins_pcs_stock_status; ?></td>
        <td><?php echo $main_data->ins_pcs_stock_remark; ?></td>
        <!-- <td><?php echo $main_data->ins_sign_attnd_date; ?></td> -->
        <td style="text-align: center;">
            <?php if($main_data->ins_sign_attnd_date == "0000-00-00"){$sindate="-";}else{$sindate=$main_data->ins_sign_attnd_date;} echo $sindate; ?>
        </td>
        <td><?php echo $main_data->ins_sign_attnd_due_status; ?></td>
        <td><?php echo $main_data->ins_sign_attnd_status; ?></td>
        <td><?php echo $main_data->ins_sign_attnd_remark; ?></td>

        <!-- <td><?php echo $main_data->med_title; ?></td>
        <td><?php echo $main_data->exp_stock; ?></td>
        <td><?php echo $main_data->med_status; ?></td>
        <td><?php echo $main_data->med_qty; ?></td>
        <td><?php echo $main_data->med_Remark; ?></td> -->

         <td><?php echo $main_data->eqp_name; ?></td>
        <td><?php echo $main_data->status; ?></td>
        <td><?php echo $main_data->oprational; ?></td>
        <td style="text-align: center;">
        <?php if($main_data->date_from == "0000-00-00"){$cridate="-";}else{$cridate=$main_data->date_from;} echo $cridate; ?>
        </td>
        <td><?php echo $main_data->remark; ?></td>

        <!-- <td><?php echo $cri_eqp_name; ?></td>
        <td><?php echo $main_data->cri_status; ?></td>
        <td><?php echo $main_data->cri_oprational; ?></td>
        <td style="text-align: center;">
            <?php if($main_data->cri_date_from == "0000-00-00"){$cridate="-";}else{$cridate=$main_data->cri_date_from;} echo $cridate; ?>
        </td>
        <td><?php echo $main_data->cri_remark; ?></td> -->

        <!-- <td><?php echo $maj_eqp_name; ?></td>
        <td><?php echo $main_data->maj_status; ?></td>
        <td><?php echo $main_data->maj_oprational; ?></td>
        <td style="text-align: center;">
            <?php if($main_data->maj_date_from == "0000-00-00"){$majdate="-";}else{$majdate=$main_data->maj_date_from;} echo $majdate; ?>
        </td>
        <td><?php echo $main_data->maj_remark; ?></td> -->

        <!-- <td><?php echo $min_eqp_name; ?></td>
        <td><?php echo $main_data->min_status; ?></td>
        <td><?php echo $main_data->min_oprational; ?></td>
        <td style="text-align: center;">
            <?php if($main_data->min_date_from == "0000-00-00"){$mindate="-";}else{$mindate=$main_data->min_date_from;} echo $mindate; ?>
        </td>
        <td><?php echo $main_data->min_remark; ?></td> -->

        <td><?php echo $main_data->added_date; ?></td>
        <td><?php echo $main_data->ins_first_name. ' '.$main_data->ins_mid_name. ' '.$main_data->ins_last_name 
; ?></td>

        <td><?php echo $main_data->griv_name ; ?> </td>
        <td><?php echo $main_data->gri_sub_type; ?></td>
        <td><?php echo $prilimnari_inform; ?></td>
        <td><?php echo $main_data->griv_remark; ?></td>
        <td><?php echo $main_data->griv_date; ?></td>
        <td><?php echo $main_data->gri_first_name. ' '.$main_data->gri_mid_name. ' '.$main_data->gri_last_name; ?></td>
    </tr>
    <?php
        $count++;
    }
    }
     ?>
</table>
<iframe name="form_frame" style="height: 1px; width: 1px; border:0px; background: none;"></iframe>