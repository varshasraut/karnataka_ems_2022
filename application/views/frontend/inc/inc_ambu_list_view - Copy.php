<ul class="inc_ambu_list">
    <table class="border">  
        <tr>
            <th class="amb_h3">Base Location</th>
            <th class="amb_h3">RTO Reg. No</th>
            <th class="amb_h3">Type</th>
            <th class="amb_h3">Distance</th>
            <th class="amb_h3">ETA</th>
            <th class="amb_h3">Mobile 1</th>
            <th class="amb_h3">Mobile 2</th>
            <th class="amb_h3">Status</th>
            <th class="amb_h3">Action</th>
        </tr>
    <?php
    $key = 1;
    if($ambu_data){
        $grouped = array();
            foreach($ambu_data as $item){ 
                $grouped[$item->amb_status][] = $item;
            }
    if($grouped[1]){ ?>
         <tr style="height: 3px; border-top:3px solid #2acfca;"></tr>
    
    <?php
        foreach($grouped[1] as $amb_key=>$ambu){ 
        $tap_index = 0;
        $tap_index_st = $tap_index+1;
        ?>
    <?php  // "ambu_item" this class is used in inc_map.js for ambulance search ?>
    <tr id="Search_Amb_<?php echo trim($ambu->amb_id);?>" class="searched_ambu_item" data-amb_id="<?php echo trim($ambu->amb_id);?>"  data-rto-no="<?php echo trim($ambu->amb_rto_register_no);?>" data-lat="<?php echo $ambu->amb_lat ?>" data-lng="<?php echo $ambu->amb_log ?>" data-title="<?php echo $ambu->hp_name ?>" data-amb_status="<?php echo $ambu->amb_status; ?>" data-amb_geofence="<?php echo $ambu->geo_fence ?>" style="clear: both; width: 100%;">
            
     
            <td><?php echo $ambu->hp_name; ?></td>
            <td class="width15"><?php echo $ambu->amb_rto_register_no; ?></td>
            <td><?php echo $ambu->ambt_name; ?></td>
            <td class="width10"><?php echo $ambu->road_distance; ?></td>
            <td><?php echo $ambu->duration; ?></td>
            <td class="width10"><?php echo $ambu->amb_default_mobile; ?></td>
            <td class="width10"><?php echo $ambu->amb_pilot_mobile; ?></td>
            <td class="width10"><?php echo $ambu->ambs_name; ?></td>
            <td class="width15">            
                <input type="checkbox" name="select_amb" value="" class="amb_check_box float_left" <?php if($ambu->amb_status == 6){ echo "disabled"; }?> id="check<?php echo trim($ambu->amb_id);?>" style="margin-top:9px;"><label for="check<?php echo trim($ambu->amb_id);?>" tabindex="17.<?php echo $tap_index;?>">Assign</label>
             
                 
             <?php if($inc_type == 'mci' || $inc_type == 'add_sup' ){?>
             <input type="checkbox" name="standby_amb" value="" data-stand_amb_id="<?php echo trim($ambu->amb_id);?>" class="float_left amb_stand_check_box" id="check_St<?php echo trim($ambu->amb_id);?>" style="margin-top:9px;"><label for="check_St<?php echo trim($ambu->amb_id);?>" tabindex="17.<?php echo $tap_index_st;?>">Stand</label>
             <?php } ?>


       
        <div class="ambu_pin_info" style="display: none;">
            
            <?php   $amb_map_box  = "";
                    $amb_map_box .=  '<strong>'.$ambu->hp_name.'</strong>'; 
                    $amb_map_box .= '<br>';
                    $amb_map_box .=  '<strong>Distance: </strong>'. $ambu->road_distance; 
                    $amb_map_box .= '<br>';
                    $amb_map_box .=  '<strong>Duration: </strong>'.$ambu->duration; 
                    $amb_map_box .= '<br>';
                    $amb_map_box .= '<strong>RTO No: </strong>'.$ambu->amb_rto_register_no; 
                    $amb_map_box .= '<br>';
               echo $amb_map_box .= '<strong>Mobile No: </strong>'.$ambu->amb_default_mobile; ?>
            
        </div></td>
    </tr>
   <?php } 
    }
   
    if($grouped[2]){?>
    <tr style="height: 3px; border-top:3px solid #FFFF00;"></tr>
       <?php foreach($grouped[2] as $ambu){ 
        $tap_index = 5;
        $tap_index_st = $tap_index+1;
        ?>
    <?php  // "ambu_item" this class is used in inc_map.js for ambulance search ?>
    <tr id="Search_Amb_<?php echo trim($ambu->amb_id);?>" class="searched_ambu_item" data-amb_id="<?php echo trim($ambu->amb_id);?>"  data-rto-no="<?php echo trim($ambu->amb_rto_register_no);?>" data-lat="<?php echo $ambu->amb_lat ?>" data-lng="<?php echo $ambu->amb_log ?>" data-title="<?php echo $ambu->hp_name ?>" data-amb_status="<?php echo $ambu->amb_status; ?>" data-amb_geofence="<?php echo $ambu->geo_fence ?>" style=" clear: both; width: 100%;">

            <td><?php echo $ambu->hp_name; ?></td>
            <td><?php echo $ambu->amb_rto_register_no; ?></td>
            <td><?php echo $ambu->ambt_name; ?></td>
            <td><?php echo $ambu->road_distance; ?></td> 
            <td><?php echo $ambu->duration; ?></td>
            <td><?php echo $ambu->amb_default_mobile; ?></td>
            <td><?php echo $ambu->amb_pilot_mobile; ?></td>
            <td><?php echo $ambu->ambs_name;  ?>

       
        <div class="ambu_pin_info" style="display: none;">
            
            <?php   $amb_map_box  = "";
                    $amb_map_box .=  '<strong>'.$ambu->hp_name.'</strong>'; 
                    $amb_map_box .= '<br>';
                    $amb_map_box .=  '<strong>Distance: </strong>'. $ambu->road_distance; 
                    $amb_map_box .= '<br>';
                    $amb_map_box .=  '<strong>Duration: </strong>'.$ambu->duration; 
                    $amb_map_box .= '<br>';
                    $amb_map_box .= '<strong>RTO No: </strong>'.$ambu->amb_rto_register_no; 
                    $amb_map_box .= '<br>';
               echo $amb_map_box .= '<strong>Mobile No: </strong>'.$ambu->amb_default_mobile; ?>
            
        </div></td>
                <td class="width15">
             <input type="checkbox" name="select_amb" value="" class="amb_check_box float_left" <?php if($ambu->amb_status == 6){ echo "disabled"; }?> id="check<?php echo trim($ambu->amb_id);?>" style="margin-top:9px;"><label for="check<?php echo trim($ambu->amb_id);?>" tabindex="17.<?php echo $tap_index;?>">Assign</label>
             
                 
             <?php if($inc_type == 'mci' || $inc_type == 'add_sup'){?>
             <input type="checkbox" name="standby_amb" value="" data-stand_amb_id="<?php echo trim($ambu->amb_id);?>" class="float_left amb_stand_check_box" id="check_St<?php echo trim($ambu->amb_id);?>" style="margin-top:9px;"><label for="check_St<?php echo trim($ambu->amb_id);?>" tabindex="17.<?php echo $tap_index_st;?>">Stand</label>
             <?php } ?>
       </td>
    </tr>
   <?php } 
    }
    if($grouped[3]){?>
    <tr style="height: 3px; border-top:3px solid #FAAE31;"></tr>
    <?php
        foreach($grouped[3] as $ambu){ 
         $tap_index = 10;
         $tap_index_st = $tap_index+1;
         ?>
     <?php  // "ambu_item" this class is used in inc_map.js for ambulance search ?>
     <tr id="Search_Amb_<?php echo trim($ambu->amb_id);?>" class="searched_ambu_item" data-amb_id="<?php echo trim($ambu->amb_id);?>"  data-rto-no="<?php echo trim($ambu->amb_rto_register_no);?>" data-lat="<?php echo $ambu->amb_lat ?>" data-lng="<?php echo $ambu->amb_log ?>" data-title="<?php echo $ambu->hp_name ?>" data-amb_status="<?php echo $ambu->amb_status; ?>" data-amb_geofence="<?php echo $ambu->geo_fence ?>" style=" clear: both; width: 100%;">

             <td><?php echo $ambu->hp_name; ?></td>
             <td><?php echo $ambu->amb_rto_register_no; ?></td>
             <td><?php echo $ambu->ambt_name; ?></td>
             <td><?php echo $ambu->road_distance; ?></td> 
             <td><?php echo $ambu->duration; ?></td>
             <td><?php echo $ambu->amb_default_mobile; ?></td>
             <td><?php echo $ambu->amb_pilot_mobile; ?></td>
             <td><?php echo $ambu->ambs_name; ?></td>
             <td> <input type="checkbox" name="select_amb" value="" class="amb_check_box float_left" <?php if($ambu->amb_status == 6){ echo "disabled"; }?> id="check<?php echo trim($ambu->amb_id);?>" style="margin-top:9px;"><label for="check<?php echo trim($ambu->amb_id);?>" tabindex="17.<?php echo $tap_index;?>">Assign</label>


              <?php if($inc_type == 'mci' || $inc_type == 'add_sup'){?>
              <input type="checkbox" name="standby_amb" value="" data-stand_amb_id="<?php echo trim($ambu->amb_id);?>" class="float_left amb_stand_check_box" id="check_St<?php echo trim($ambu->amb_id);?>" style="margin-top:9px;"><label for="check_St<?php echo trim($ambu->amb_id);?>" tabindex="17.<?php echo $tap_index_st;?>">Stand</label>
              <?php } ?>


         <div class="ambu_pin_info" style="display: none;">

             <?php   $amb_map_box  = "";
                     $amb_map_box .=  '<strong>'.$ambu->hp_name.'</strong>'; 
                     $amb_map_box .= '<br>';
                     $amb_map_box .=  '<strong>Distance: </strong>'. $ambu->road_distance; 
                     $amb_map_box .= '<br>';
                     $amb_map_box .=  '<strong>Duration: </strong>'.$ambu->duration; 
                     $amb_map_box .= '<br>';
                     $amb_map_box .= '<strong>RTO No: </strong>'.$ambu->amb_rto_register_no; 
                     $amb_map_box .= '<br>';
                echo $amb_map_box .= '<strong>Mobile No: </strong>'.$ambu->amb_default_mobile; ?>

         </div></td>
     </tr>
    <?php } 
    }
    if($grouped[6]){ ?>
     <tr style="height: 3px; border-top:3px solid #FAAE31;"></tr>
     <?php
        foreach($grouped[6] as $ambu){ 
        $tap_index = 20;
        $tap_index_st = $tap_index+1;
        ?>
    <?php  // "ambu_item" this class is used in inc_map.js for ambulance search ?>
    <tr id="Search_Amb_<?php echo trim($ambu->amb_id);?>" class="searched_ambu_item" data-amb_id="<?php echo trim($ambu->amb_id);?>"  data-rto-no="<?php echo trim($ambu->amb_rto_register_no);?>" data-lat="<?php echo $ambu->amb_lat ?>" data-lng="<?php echo $ambu->amb_log ?>" data-title="<?php echo $ambu->hp_name ?>" data-amb_status="<?php echo $ambu->amb_status; ?>" data-amb_geofence="<?php echo $ambu->geo_fence ?>" style=" clear: both; width: 100%;">


            <td><?php echo $ambu->hp_name; ?></td>
            <td><?php echo $ambu->amb_rto_register_no; ?></td>
            <td><?php echo $ambu->ambt_name; ?></td>
            <td><?php echo $ambu->road_distance; ?></td>
            <td><?php echo $ambu->duration; ?></td>
            <td><?php echo $ambu->amb_default_mobile; ?></td>
            <td><?php echo $ambu->amb_pilot_mobile; ?></td>
            <td><?php echo $ambu->ambs_name; ?></td>
            <td>
                   <input type="checkbox" name="select_amb" value="" class="amb_check_box float_left" <?php if($ambu->amb_status == 6){ echo "disabled"; }?> id="check<?php echo trim($ambu->amb_id);?>" style="margin-top:9px;"><label for="check<?php echo trim($ambu->amb_id);?>" tabindex="17,<?php echo $tap_index;?>">Assign</label>
             
                 
             <?php if($inc_type == 'mci'){?>
             <input type="checkbox" name="standby_amb" value="" data-stand_amb_id="<?php echo trim($ambu->amb_id);?>" class="float_left amb_stand_check_box" id="check_St<?php echo trim($ambu->amb_id);?>" style="margin-top:9px;"><label for="check_St<?php echo trim($ambu->amb_id);?>" tabindex="17.<?php echo $tap_index_st;?>">Stand</label>
             <?php } ?>

       
        <div class="ambu_pin_info" style="display: none;">
            
            <?php   $amb_map_box  = "";
                    $amb_map_box .=  '<strong>'.$ambu->hp_name.'</strong>'; 
                    $amb_map_box .= '<br>';
                    $amb_map_box .=  '<strong>Distance: </strong>'. $ambu->road_distance; 
                    $amb_map_box .= '<br>';
                    $amb_map_box .=  '<strong>Duration: </strong>'.$ambu->duration; 
                    $amb_map_box .= '<br>';
                    $amb_map_box .= '<strong>RTO No: </strong>'.$ambu->amb_rto_register_no; 
                    $amb_map_box .= '<br>';
               echo $amb_map_box .= '<strong>Mobile No: </strong>'.$ambu->amb_default_mobile; ?>
            
        </div></td>
    </tr>
   <?php } 
    }
   
           $key++;  }
   else { ?>
    <tr><td colspan="9" class="text_align_center">No record Found</td></tr>
   <?php } ?>
     </table>   
</ul>
<script>
   update_ambulance_inc_map();
</script>