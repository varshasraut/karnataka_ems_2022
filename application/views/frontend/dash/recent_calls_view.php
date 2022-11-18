<?php

$CI = EMS_Controller::get_instance();

 
$arr=array(
  'page_no'=>@$page_no,
  'records_on_page'=>@$page_load_count,
  'dashboard'=>'yes'
  );
    

$data=json_encode($arr);
$data=base64_encode($data);

?> 


<div class="dashboard_content_container">
<div class="dashboard_page_content">
                    <div class="content_box_heading">Recent Calls :<a data-qr="output_position=content" href="{base_url}store/store_list" class="heading_view_all click-xhttp-request">View All</a></div>
                    <div class="permission_list table">
                        <table class="table report_table">
                            
                            <tr>
                                <th>Name</th>
                                <th>Owner</th>
                                <th>Phone</th>
                                <th>Registration Date</th>
                                <th>City</th>
                                <th>Action</th>
                            </tr>
                            
                            <?php if(@$recent_stores){ foreach($recent_stores as $store): ?>
                            
                            <tr>
                                
                                <td><span class='<?php echo strtolower($store->sub_name)."_store";?> float_left'></span><span class='float_left'><?= $store->usr_ms_name; ?></span></td>
                                
                                <td><?= $store->usr_ms_owner_name; ?></td>
                                
                                <td><?= $store->usr_ms_phone_no; ?></td>
                                
                                <td><?= date("jS M Y",strtotime($store->usr_reg_date)); ?></td>
                                
                                <td><?= $store->usr_ms_city; ?></td>  
                                
                                
                                <td>
                        
                        <div style="position:relative;">             
                                    
                        <div class="store_actions_div"></div>
                        
                        <ul class="store_actions_list">
                            
                            
                            <?php
                            if($CI->modules->get_tool_config('MT-STORE-VIEW',$this->active_module,true)!=''){
                            ?>
                            <li>
 
                            <a class="onpage_popup action_button" data-href="{base_url}store/store_usr_profile"  data-qr="output_position=popup_div&amp;module_name=store&amp;data-popupwidth=500&amp;ref_id=<?php echo base64_encode($store->usr_ref_id); ?>&amp;dashboard=true&amp;action=view_profile" data-popupwidth="1240" data-popupheight="980">
                                View
                           
                            </a>
                        

                             </li>
                             
                             <?php } ?>
                               
                            <?php
                            if($CI->modules->get_tool_config('MT-SORE-EDIT',$this->active_module,true)!=''){
                            ?> 
                             <li>

                                 <a class="onpage_popup action_button" data-href="{base_url}store/edit_profile" data-qr="output_position=popup_div&amp;module_name=store&amp;data-popupwidth=500&amp;ref_id=<?php echo base64_encode($store->usr_ref_id); ?>&amp;dashboard=yes&amp;store_data=<?php echo $data; ?>" data-popupwidth="1240" data-popupheight="980">
                                     Edit
                                </a>


                             </li>
                             <?php } ?>

                             
                             <?php
                            if($CI->modules->get_tool_config('MT-STORE-DEL-USR',$this->active_module,true)!=''){
                            ?>  
                             
                            <li>

                             <a class="action_button click-xhttp-request" data-href="{base_url}store/delete_user" data-qr="amp;module_name=store&amp;tlcode=MT-STORE-DEL-USR&amp;usr_ref_id[0]=<?php echo base64_encode($store->usr_ref_id); ?>&amp;dashboard=yes&amp;action=view_profile&amp;store_data=<?php echo $data; ?>" data-popupwidth="900" data-popupheight="850" data-confirm="yes" data-confirmmessage="Are you sure to delete this store?">
                                 Delete
                            </a>
                            
                            </li>
                            <?php } ?>
                            
                            
                            <?php
                            if($CI->modules->get_tool_config('MT-STORE-MNG-SUB',$this->active_module,true)!=''){
                            ?>
                            
                             <li>

                             <a class="action_button click-xhttp-request onpage_popup" data-href="{base_url}store/usr_sub_details" data-qr="output_position=popup_div&amp;module_name=store&amp;usr_ref_id=<?php echo base64_encode($store->usr_ref_id); ?>&amp;dashboard=yes&amp;store_data=<?php echo $data; ?>" data-popupwidth="900" data-popupheight="850">
                                 Manage Subscription
                            </a>
                                

                            </li>
                             <?php } ?>
                            
                            
                            <?php
                            if($CI->modules->get_tool_config('MT-STORE-ADD-MED',$this->active_module,true)!=''){
                            ?>
                             <li>

                             <a class="action_button click-xhttp-request onpage_popup" data-href="{base_url}store/add_medicine" data-qr="output_position=popup_div&amp;module_name=store&amp;usr_ref_id=<?php echo base64_encode($store->usr_ref_id); ?>&amp;dashboard=yes&amp;store_data=<?php echo $data; ?>" data-popupwidth="740" data-popupheight="479">
                                 Add Medicines
                            </a>
                                

                            </li>
                            <?php } ?>
                            
                            <?php
                            if($CI->modules->get_tool_config('MT-STORE-MED-HIS',$this->active_module,true)!=''){
                            ?>
                            
                            <li>

                             <a class="action_button click-xhttp-request onpage_popup" data-href="{base_url}store/search_history" data-qr="output_position=popup_div&amp;module_name=store&amp;usr_ref_id=<?php echo base64_encode($store->usr_ref_id); ?>&amp;dashboard=yes&amp;store_data=<?php echo $data; ?>" data-popupwidth="930" data-popupheight="579">
                                 Search history
                            </a>
                                

                            </li>
                            
                            <?php } ?>
                            
                            <?php
                            if($CI->modules->get_tool_config('MT-STORE-STOCK-DTLS',$this->active_module,true)!=''){
                            ?>
                            
                             <li>

                             <a class="action_button click-xhttp-request onpage_popup" data-href="{base_url}store/store_request_details" data-qr="output_position=popup_div&amp;module_name=store&amp;usr_ref_id=<?php echo base64_encode($store->usr_ref_id); ?>&ampstore_data=<?php echo $data;?>" data-popupwidth="850" data-popupheight="479">
                                 Stock request
                            </a>
                                

                            </li>
                            
                            <?php } ?>
                         
                        </ul>
                        </div>
                    </td>
                                    
                            </tr>
                            
                            <?php endforeach; }else{?>
                            
                              <tr><td colspan="9" class="no_record_text">No record Found</td></tr>
                            
                            
                            <?php } ?>
                            
                        </table>
                        
                        <div class="pagination">
                            <?php echo $pagination; ?>
                        </div>
                        
                         <div class="float_right">
                            <span> Total stores : <?php if(@$total_stores){ echo $total_stores; }?> </span>
                        </div>
                    </div>
</div>
                    
                </div>