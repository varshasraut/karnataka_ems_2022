 <div class="field_row width100">
<!--        <h3>Response Time  Dashboard</h3><br>       -->
                <table class="table table-bordered NHM_Dashboard ">
                    <tr>              
                        <th style="width: 50px;" >District</th>
                        <th style="width: 50px;">Ambulance No</th>
                        <th style="width: 50px;">Base Location</th>
                        <th style="width: 30px;">Type of Ambulance</th>
                        <th style="width: 40px;">Speed</th>
                        <th style="width: 40px;">Ignition Status</th>
                        <th style="width: 30px;">Track</th> 
                    </tr>
                    <?php if($amb_data){
                        foreach($amb_data as $amb){ //var_dump($amb); ?>
                      <tr>
                          
                        <td style="width: 50px;"><?php echo get_district_by_id($amb->amb_district);?></td>
                        <td style="width: 50px;"><?php echo $amb->amb_rto_register_no;?></td>
                        <td style="width: 50px;"><?php  $base = get_base_location_by_id($amb->amb_base_location);
                        echo $base[0]->hp_name;
                        ?></td>   
                        <td style="width: 30px;"><?php echo show_amb_type_name($amb->amb_type) ;?></td>    
                        <td style="width: 40px;"><?php echo $amb->amb_speed;?></td> 
                        <td style="width: 40px;"><?php $ignition = $amb->amb_Ignition_status;
                        if($ignition == 'Ignition Off'){
                            $checked = "";
                        }else{
                            $checked = "checked";
                        }
                        ?>
                        <label class="switch">
                            <input type="checkbox" disabled="disabled" <?php echo $checked;?>>
                            <span class="slider round"></span>
                        </label>
                        </td> 
                        <td style="width: 30px;"><a class="onpage_popup btn" data-href="{base_url}dashboard/track_amb" data-qr="output_position=popup_div&amb_reg=<?php echo $amb->amb_rto_register_no; ?>" data-popupwidth="1000" data-popupheight="800"> Track</a>
                        </td> 
                    </tr>
                            
                    <?php    }
                    } ?>
                  
                    
                 </table>
<br><br><br><br>
            </div>