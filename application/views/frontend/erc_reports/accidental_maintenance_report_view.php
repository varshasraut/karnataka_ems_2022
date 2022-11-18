<div class="width_25 float_right" style="margin-bottom: 10px;">
    <div class="button_field_row">
        <div class="button_box">
            <form action="<?php echo base_url(); ?>erc_reports/<?php echo $submit_function ?>" method="post" enctype="multipart/form-data" target="form_frame">
                <input type="hidden" value="<?php echo $report_args['to_date']; ?>" name="to_date">
                <input type="hidden" value="<?php echo $report_args['from_date']; ?>" name="from_date">
				<input type="hidden" value="<?php echo $maintenance_type; ?>" name="maintenance_type">
                
                <input type="submit" name="submit" value="Download" TABINDEX="3" class="float_right">
            </form>
        </div>

    </div>
</div>  
<?php if($maintenance_type=='accidental_maintenance'){
            $maint_type="Accidental Maintenance";
        }
        elseif($maintenance_type=='breakdown_maintenance'){
            $maint_type="Breakdown Maintenance";
        }
        elseif($maintenance_type=='preventive_maintenance'){
            $maint_type="Preventive Maintenance";
        }
        elseif($maintenance_type=='tyre'){
            $maint_type="Tyre Maintenance";
        }
        elseif($maintenance_type=='onroad_offroad_maintenance'){
            $maint_type="Onroad/offroad Maintenance";
        }
        ?>
<div class="width100"><lable><?php echo $maint_type; ?></label></div>
<table class="table report_table">
    <tr>                              
        <?php foreach ($header as $heading) { ?>
        <th style="line-height: 20px;"><?php echo $heading; ?></th>
        <?php } ?>
    </tr>
    <?php
    $count = 1;
    
       
    foreach ($maintenance_data as $main_data) 
    { //var_dump($maintenance_data);
        if($main_data->mt_type=='accidental'){
            $main_type="Accidental Maintenance";
        }
        elseif($main_data->mt_type=='breakdown'){
            $main_type="Breakdown Maintenance";
        }
        elseif($main_data->mt_type=='preventive'){
            $main_type="Preventive Maintenance";
        }
        elseif($main_data->mt_type=='tyre'){
            $main_type="Tyre Maintenance";
        }
        elseif($main_data->mt_type=='onroad_offroad'){
            $main_type="Onroad/offroadMaintenance";
        }
        if($main_data->mt_district_id!= ' '){
        $current_district = get_district_by_id($main_data->mt_district_id);
        }
        
      
       if($main_data->amb_type != '' || $main_data->amb_type != 0 ){ 
        $amb_type =  show_amb_type_name($main_data->amb_type);
       // var_dump($amb_type);
       }
      
      $start_date = new DateTime(date('Y-m-d h:i:s',strtotime($main_data->mt_offroad_datetime)));                         
                               if($main_data->mt_onroad_datetime != '' && $main_data->mt_onroad_datetime != '1970-01-01 05:30:00' && $main_data->mt_onroad_datetime != '0000-00-00 00:00:00'){
                                    
                                     $end_date = new DateTime(date('Y-m-d h:i:s',strtotime($main_data->mt_onroad_datetime))); 
                                }else{
                                    $end_date = new DateTime(date('Y-m-d h:i:s')); 
                                }
                                $since_start = $start_date->diff($end_date);
                                $duration= $since_start->days.'D '.$since_start->h.'H '. $since_start->i.'M '.$since_start->s.'S';
                                
                                //var_dump($main_data);
        
    ?>
    <tr>  
        <td><?php echo $count; ?></td>
        <td><?php echo $current_district; ?></td>
        <td><?php echo $main_data->mt_amb_no; ?></td>
        <td><?php echo $main_data->added_date; ?></td>
        <td><?php echo $main_data->approved_date; ?></td>  
        <td><?php echo $main_data->modify_date; ?></td>
        <td><?php echo $main_data->mt_accidentdate ; ?></td>
        <td><?php echo $main_data->mt_Estimatecost; ?></td>
        <td><?php if($main_data->mt_shift_id != ''){ echo show_shift_type_by_id($main_data->mt_shift_id); } ?></td>
        <td><?php if($main_data->mt_work_shop != ''){ echo show_work_shop_by_id($main_data->mt_work_shop); }  ?></td>
        <td><?php echo $main_data->mt_pilot_name; ?></td>
        <td><?php echo $main_data->mt_pilot_id; ?></td>
        <td><?php echo $main_data->mt_previos_odometer ; ?></td>
        <td><?php echo $main_data->mt_in_odometer; ?></td>
        <td><?php echo $main_data->mt_accidental_severity; ?></td>
        <td><?php echo $main_data->mt_ex_onroad_datetime; ?></td>
        <td><?php echo $main_data->mt_accidental_type; ?></td>
        <td><?php $informed_to = json_decode($main_data->informed_to); 
        if(is_array($informed_to)){
            //echo implode(',', $informed_to);
        }
         $group_name = array();
        if(is_array($informed_to)){
           // echo implode(',', $informed_to);
       
            foreach($informed_to as $inform){
                $group_name[]=get_EMS_title($inform);
            }
            
        }
        echo implode(',', $group_name);
        ?></td>
        <td><?php echo $main_data->mt_towing_required ; ?></td>
        <td><?php echo $main_data->mt_fire_on_scene ; ?></td>
       <td><?php echo $main_data->mt_stnd_remark; ?></td> 
        <td><?php echo $main_data->mt_remark ; ?></td>
        
        <td><?php echo $main_data->approved_by ; ?></td>
        <td><?php echo $main_data->approved_date; ?></td>
         <td><?php
         //if($main_data->mt_approval == 0){ echo "Approval Pending"; }else if($main_data->mt_approval == 1){ echo "Approved"; }else if($main_data->mt_approval == 2){ echo "Not Approve"; }
          echo $main_data->mt_ambulance_status;
         ?></td> 
        <td><?php echo $main_data->mt_onroad_datetime; ?></td>
        <td><?php echo $main_data->mt_app_est_amt; ?></td> 
        <td><?php echo $main_data->mt_app_rep_time ; ?></td> 
        <td><?php if($main_data->mt_app_work_shop != ''){ echo show_work_shop_by_id($main_data->mt_app_work_shop); }  ?></td>
         <td><?php echo $main_data->bill_number; ?></td> 
        <td><?php echo $main_data->part_cost; ?></td> 
        <td><?php echo $main_data->labour_cost; ?></td>
         <td><?php echo $main_data->total_cost; ?></td>
         <td><?php echo $main_data->mt_end_odometer; ?></td>
         
         <td><?php echo $main_data->mt_on_stnd_remark; ?></td> 
        <td><?php echo $main_data->mt_on_remark; ?></td>
    </tr>
    <?php
    $count++; 
 // }
     }?>
</table>
<iframe name="form_frame" style="height: 1px; width: 1px; border:0px; background: none;"></iframe>
