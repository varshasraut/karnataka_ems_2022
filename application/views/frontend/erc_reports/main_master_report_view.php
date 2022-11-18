<div class="width_25 float_right" style="margin-bottom: 10px;">
    <div class="button_field_row">
        <div class="button_box">
            <form action="<?php echo base_url(); ?>master_report/view_master_report" method="post" enctype="multipart/form-data" target="form_frame">
                <input type="hidden" value="<?php echo $report_args['from_date']; ?>" name="from_date">
                <input type="hidden" value="<?php echo $report_args['to_date']; ?>" name="to_date">
                <input type="hidden" value="<?php echo $report_args['inc_added_by']; ?>" name="user_id">
                <input type="hidden" value="<?php echo $report_args['team_type']; ?>" name="team_type">
                <input type="submit" name="submit" value="Download" TABINDEX="3" class="float_right">
            </form>
        </div>

    </div>
</div>   
<table class="table report_table">

    <tr>                              
        <?php foreach ($header as $heading) { ?>
            <th style="line-height: 20px; font-size: 11px;"><?php echo $heading; ?></th>
            <?php } ?>
    </tr>
    <?php
    $count = 1;
    foreach ($inc_data as $inc) {
        if($inc->ptn_gender=='M'){
            $gender = 'Male';
       }else if($inc->ptn_gender='F')
       {
            $gender = 'Female';
       }else{
            $gender = 'Other';
       }
        ?>
        
        <tr style="font-size: 11px;">         
            <td><?php echo date("F, Y", strtotime($report_args['to_date'])); ?></td>
            <td><?php echo $inc->inc_datetime; ?></td>
           
<!--            <td><?php echo date("H:i:s", strtotime($inc->inc_datetime)); ?></td>-->
            <td>
            <?php echo $inc->inc_ref_id; ?></td>
            <td>
                <?php
                if($inc->inc_added_by != ''){ 
               
                $ero = get_clg_data_by_ref_id($inc->inc_added_by);?>
                
                <?php echo $ero[0]->clg_first_name; ?> <?php echo $ero[0]->clg_mid_name; ?> <?php echo $ero[0]->clg_last_name; ?>
                <?php } ?>
             </td>
             <td><?php echo $inc->clg_avaya_id; ?></td> 
            <td><?php echo $inc->inc_recive_time; ?></td>
            <td><?php echo $inc->inc_datetime; ?></td>
            <td><?php 
            
            $date_a = new DateTime($inc->inc_recive_time);
            $date_b = new DateTime($inc->inc_datetime);

            $interval = date_diff($date_a,$date_b);

            echo $interval->format('%h:%i:%s');
          //  echo  $inc->call_duration; 
            
            ?></td>
            <td><?php echo get_parent_purpose_of_call($inc->inc_type); ?></td>
            <td><?php echo get_purpose_of_call($inc->inc_type); ?></td>
            <td><?php echo get_cheif_complaint($inc->inc_complaint); ?></td>
            <td><?php echo $inc->clr_mobile; ?></td> 
            <td><?php echo $inc->clr_fname; ?> <?php echo $inc->clr_lname; ?></td> 
            <td><?php echo get_relation_by_id($inc->clr_ralation); ?></td> 
            <td><?php echo $inc->ptn_fname; ?> <?php echo $inc->ptn_lname; ?></td> 
            <td><?php echo $gender; ?></td> 
            <td><?php echo $inc->ptn_age; ?></td> 
            <td><?php
                   //  echo $inc->dst_name; 

            if($inc->inc_district_id != '0' && !empty($inc->inc_district_id)){ echo get_district_by_id($inc->inc_district_id); } ?></td> 
            <td><?php
      
            if($inc->current_district != '0' && !empty($inc->current_district)){ 
                
                echo get_district_by_id($inc->current_district); 
                
            } //echo $inc->current_district; ?></td>
            <td><?php if($inc->facility != NULL && $inc->facility != '0' ){
           $facility = get_hospital_by_id($inc->facility);
             $facility1 =$facility[0]->hp_name; 
             echo $facility1;
            }
            // echo $inc->facility; ?></td>
            <td><?php echo $inc->rpt_doc; ?></td>
            <td><?php echo $inc->mo_no; ?></td>
            <td><?php if($inc->new_district != '0' && !empty($inc->new_district)){ echo get_district_by_id($inc->new_district); } //echo $inc->new_district; ?></td>
            <td><?php  if($inc->new_facility != NULL && $inc->new_facility != '0' ){
             $new_facility = get_hospital_by_id($inc->new_facility);
    $new_f= $new_facility[0]->hp_name; 
    echo $new_f;
            } //echo $inc->new_facility; ?></td>
            <td><?php echo $inc->new_rpt_doc; ?></td>
            <td><?php echo $inc->new_mo_no; ?></td>
            <td><?php  //echo $inc->amb_base_location; ?>
            <?php 
             //if($inc->amb_base_location != '0' && $inc->amb_base_location !=''){
            if($inc->amb_base_location != '' && !empty($inc->amb_base_location)){
            $amb_base_location = get_base_location_by_id($inc->amb_base_location);
            //var_dump($amb_base_location);
            $hi = $amb_base_location[0]->hp_name; 
             echo $hi;
           } 
            ?></td> 
            <td><?php
          
            if($inc->amb_type != ''){
                $amb_type = array('ambt_id'=>$inc->amb_type);
                echo show_amb_type_name($inc->amb_type); 
               
            }
            ?></td> 
            <td><?php echo $inc->amb_rto_register_no; ?></td> 
            <td><?php if($inc->amb_working_area != ""){ echo show_area_type_name($inc->amb_working_area); } ?></td> 
            <td><?php echo $inc->inc_dispatch_time;  ?></td> 
            <td><?php if($inc->start_from_base != NULL){
            echo date("H:i:s", strtotime($inc->start_from_base)); }
           // echo $inc->start_from_base; 
            ?></td> 
            <td><?php echo $inc->dp_on_scene; ?></td>
            <td><?php echo $inc->dp_reach_on_scene; ?></td>
            <td><?php echo $inc->dp_hosp_time; ?></td>
            <td><?php echo $inc->dp_hand_time; ?></td>
            <td><?php echo $inc->dp_back_to_loc; ?></td>
            <td><?php 
            if($inc->rec_hospital_name != NULL && $inc->rec_hospital_name != '0' ){
                $rec_hospital = get_hospital_by_id($inc->rec_hospital_name);
                $rec_hospital = $rec_hospital[0]->hp_name;
                echo $rec_hospital;
            }elseif( $inc->rec_hospital_name == '0')
            { echo 'Other'; }
            ?></td>
            <td><?php echo $inc->other_receiving_host; ?></td>
            <td><?php echo $inc->start_odometer; ?></td>
            <td><?php echo $inc->start_odometer; ?></td>
            <td><?php echo $inc->scene_odo; ?></td>
            <td><?php echo $inc->hospital_odo; ?></td>
            <td><?php echo $inc->end_odometer; ?></td>
			<td><?php echo $inc->remark; ?></td>
            <td>
                 <?php echo $inc->amb_emt_id; ?>
            </td>
            <td>
                <?php
                if($inc->amb_emt_id != ''){
                $emt = get_clg_data_by_ref_id($inc->amb_emt_id); ?>
                <?php echo $emt[0]->clg_first_name; ?> <?php echo $emt[0]->clg_mid_name; ?> <?php echo $emt[0]->clg_last_name; ?>
                <?php } ?>
            </td>
            <td><?php echo $inc->amb_pilot_id; ?></td>
            <td> <?php
                 if($inc->amb_pilot_id != ''){
            $pilot = get_clg_data_by_ref_id($inc->amb_pilot_id); ?>
                <?php echo $pilot[0]->clg_first_name; ?> <?php echo $pilot[0]->clg_mid_name; ?> <?php echo $pilot[0]->clg_last_name; ?>
               <?php } ?>
            </td>
            <td><?php if($inc->provider_impressions != ''){ echo get_provider_impression($inc->provider_impressions); } ?></td>
            <td><?php echo $inc->other_provider_img; ?></td>
            <td><?php if($inc->date != ''){ echo date('Y-m-d',strtotime($inc->date)); } ?></td>
             <td><?php if($inc->ercp_advice=='advice_Yes'){ echo 'YES'; } else { 'NO'; } ?></td>
            <td><?php echo $inc->clg_first_name.' '.$inc->clg_mid_name.' '.$inc->clg_last_name; ?></td>
            <td><?php echo strtoupper($inc->operate_by); ?></td>
            
            <td><?php 
            if($inc->operate_by != ''){
            $dco = get_clg_data_by_ref_id($inc->operate_by); ?>
                <?php echo $dco[0]->clg_first_name; ?> <?php echo $dco[0]->clg_mid_name; ?> <?php echo $dco[0]->clg_last_name; ?>
            <?php } ?>
            </td>
            <td>
                <?php  
                $thirdparty = '';
                if($inc->inc_thirdparty  != ''){
                    $thirdparty = get_third_party_name($inc->inc_thirdparty );
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