<?php  
$CI = MS_Controller::get_instance();

 $arr=array(
                       'page_no'=>@$page_number,
                       'records_per_page'=>@$report_load_count,                     
                       'select_users'=>@$select_users,
                       'page_limit'=>@$page_limit,   
                     
                       );
 
if(count(@$date)>0){  
 
    foreach($date as $key=>$value){                                //date_filter
        $arr[$key] = $value;
        $arr['filter'] = $key;
    }
}


   $data = base64_encode(json_encode($arr));
   $count_record = count(@$result);   

if(count($get_distance_form)>0){
    foreach($get_distance_form as $dist_from){ 
        $distance_from[$dist_from->report_id] =  $dist_from->medical_store_name;
    }
}

?>
            
                <table class="table report_table">

                    <tr>
                       
                        <th><input type="checkbox" title="Select All Users" name="selectall" class="base-select" data-type="default"></th>
                        
                        <th nowrap>Medical Store</th>
                        <th nowrap>Sales Person</th>
                        <th>Report Time</th>
                        <th nowrap>Distance From</th>
                        <th nowrap>Distance</th>
                        <th nowrap>Date</th>
                        <th>Feedback</th>      
                         <th>Action</th>
                    </tr>

                    <?php  if(count(@$result)>0){  
                        
                    $total = 0;
                    foreach($result as $value){  
                        
                       ?>
                    <tr>
                        <td><input type="checkbox" data-base="selectall" class="base-select" name="report_id[<?= $value->report_id; ?>]" value="<?=base64_encode($value->report_id);?>" title="Select All Discount"/></td><?php //}?>
                        
                        <td><?php echo $value->medical_store_name;?></td>
                        
                        <?php  $sales_person_name = $value->clg_first_name ." ".$value->clg_last_name; ?>
                     
                        <td><?php echo $sales_person_name;?></td>
                      
                        <td><?php echo $value->report_time;?></td>
                        
                        <td><?php   if(count(@$get_distance_form) > 0){
                        
                                        foreach($get_distance_form as $dist_from){  

                                              if($dist_from->report_id == $value->report_id){     

                                                if($dist_from->distance_form  =='1'){  
                                                    echo "Home";
                                                }else{ 
                                                    echo $distance_from[$dist_from->distance_form];
                                                }
                                              }

                                        }
                                        
                                    }?>
                        </td>
                        
                        <td><?php echo $value->distance;?>&nbsp;KM</td>
                        
                        <?php  $date = $value->date_of_report;?>
                          
                        
                        <td><?php echo date("j\<\s\u\p\>S\<\/\s\u\p\> M Y", strtotime($date)); ?></td>
                        
                        <td><?php $string_feedback = substr($value->report_feedback, 0,20); 
                         
                            if(strlen($value->report_feedback) >= 20){
                                 echo  ucfirst($string_feedback ."...");
                            }else{
                               echo $value->report_feedback ;
                            }
                           ?>
                         </td>
                      
                            <td> 
                                
                                <div style="position:relative;"> 
                                  <div class="store_actions_div"></div>
                                   <ul class="store_actions_list">
                                       
                                     <?php
                                    if($CI->modules->get_tool_config('MT-CLG-REPORT-VIEW',$this->active_module,true)!=''){
                                    ?>

                                     <li>

                                         <a class="onpage_popup action_button" data-href="{base_url}ms-admin/clg/report_operation" data-qr="action=edit&amp;output_position=popup&amp;module_name=clg&amp;report_id[0]=<?php echo base64_encode($value->report_id);?>&amp;clg_ref_id=<?php echo base64_encode($value->clg_ref_id);?>&amp;current_date=<?php echo $value->date_of_report;?>&amp;view='true'&amp;page_number=<?php echo @$page_number;?>&amp;page_record=<?php echo $count_record;?>&amp;report_data=<?php echo $data; ?>" data-popupwidth="549" data-popupheight="600">
                                             View
                                        </a>

                                     </li>

                                    <?php } ?>
                                     
                                    <?php
                                     
                                    if($CI->modules->get_tool_config('MT-CLG-REPORT-EDIT',$this->active_module,true)!=''){
                                       
                                    ?>

                                     <li>

                                         <a class="onpage_popup action_button" data-href="{base_url}ms-admin/clg/report_operation" data-qr="action=edit&amp;output_position=popup&amp;module_name=clg&amp;report_id[0]=<?php echo base64_encode($value->report_id);?>&amp;clg_ref_id=<?php echo base64_encode($value->clg_ref_id);?>&amp;select_users=<?php echo base64_encode(@$select_users);?>&amp;date_of_report=<?php echo $value->date_of_report;?>&amp;page_number=<?php echo @$page_number;?>&amp;page_record=<?php echo $count_record;?>&amp;report_data=<?php echo $data; ?>" data-popupwidth="549" data-popupheight="600">
                                             Edit
                                        </a>

                                     </li>

                                    <?php } ?>



                                    <?php  
                                    if($CI->modules->get_tool_config('MT-CLG-REPORT-DELETE',$this->active_module,true)!=''){
                                    ?>

                                    <li>

                                     <a class="action_button click-xhttp-request" data-href="{base_url}ms-admin/clg/report_operation" data-qr="action=delete&amp;module_name=sms&amp;tlcode=clg&amp;report_id[0]=<?php echo base64_encode($value->report_id);?>&amp;output_position=content&amp;page_number=<?php echo @$page_number;?>&amp;page_record=<?php echo $count_record;?>&amp;date_filter=true&amp;report_data=<?php echo $data; ?>&amp;select_users=<?php echo base64_encode(@$select_users); ?>&amp;report_date_filter=true" data-confirm="yes" data-confirmmessage="Are you sure to delete this report?">
                                         Delete
                                    </a>

                                    </li>

                                    <?php } ?>
                                   </ul>   
                            </td>
                        </tr>
                     <?php } ?>
                <?php }else{   ?>
                        
                    <tr><td colspan="9" class="no_record_text">No history Found</td></tr>


                 <?php } ?>   


                </table>
            
                    <div class="pagination">
                        <?php echo $pagination; ?>
                    </div>

                    <input type="hidden" name="report_data" value="<?php if(@$data){ echo $data; }?>">

                    <div class="float_right">
                      <span> Total visit Report: <?php if(@$total_count){ echo $total_count; }else{ echo"0";}?> </span>
                    </div>
      