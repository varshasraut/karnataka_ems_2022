<?php $count_record = count(@$result);

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
    }
}


   $data =json_encode($arr);
   $data =base64_encode($data);
   
   $count_record = count(@$result);  
  
$distance_from = array();

if(count($get_distance_form)>0){
    foreach($get_distance_form as $dist_from){ 
        $distance_from[$dist_from->report_id] =  $dist_from->medical_store_name;
    }
}


?>
  
<div class="msg"><?php echo $res;?></div>
<div class="breadcrumb">
    <?php  if(@$visit_report =='true'){ ?>
        <ul>
            <li class="sms">
                <a href="{base_url}ms-admin/clg/report_list">Colleagues</a>
            </li>
            <li>
                <span><?php if($verify_status=="unapprove"){ ?>Unapproved<?php } ?>Visit Report Listing</span>
            </li>

        </ul>
    <?php }?>
</div>

<br>

<div id="popup_div"></div>

<div class="box3">    
    
    <div class="permission_list group_list">
        
         <h3 class="txt_clr5">Visit Report Listing</h3>
 
        <form method="post" name="report_form" class="report_list">  
            
            <div class="report_groups">
                   
                    <?= $CI->modules->get_tool_html('MT-CLG-REPORT-DEL',$CI->active_module,'form-xhttp-request delete_catalog_list',"","data-confirm='yes' data-confirmmessage='Are you sure to delete ?'");?>  
                     
                  
                    <input type="button" name="Delete" value="Delete History" class="delete_sms form-xhttp-request" data-href="{base_url}ms-admin/clg/report_operation" data-qr="action=delete&amp;page_number=<?php echo @$page_number;?>&amp;page_record=<?php echo $count_record;?>" data-confirm='yes' data-confirmmessage="Are you sure to delete SMS ?"> 
                      
                    <input class="add_button_sms onpage_popup" name="add_report" value="Add Report" data-href="{base_url}ms-admin/clg/report_operation" data-qr="action=add&amp;output_position=popup&amp;filter_search=search&amp;current_time=true" type="button" data-popupwidth="549" data-popupheight="560">
                    
                   
                                           
                    <select id="filter_dropdown"  name="filter" class="select_users_listing change-xhttp-request" data-qr="output_position=pages&amp;page=reporting" data-href="{base_url}ms-admin/clg/get_week_range">
                         
                                 <option value="" >List By</option>

                                 <option data-qr="output_position=pages&amp;filter=day&amp;page=reporting&amp;report_id=<?php echo base64_encode(@$report_id);?>&amp;visit_report=true&amp;clg_ref_id='<?php echo base64_encode(@$result[0]->clg_ref_id);?>" data-href="{base_url}ms-admin/clg/get_week_range" class="click-xhttp-request"  value="day" >DAYS</option>
                                <option data-qr="output_position=pages&amp;filter=week&amp;page=reporting&amp;report_id=<?php echo base64_encode(@$report_id);?>&amp;<?php if(@$visit_report!='true'){?>visit_report=true&amp;clg_ref_id='<?php echo base64_encode(@$result[0]->clg_ref_id);?><?php }?>" data-href="{base_url}ms-admin/clg/get_week_range" class="click-xhttp-request"  value="week" >WEEK</option>
                                                    
									<option data-qr="output_position=pages&amp;filter=month&amp;page=reporting&amp;report_id=<?php echo base64_encode(@$report_id);?>&amp;visit_report=true&amp;clg_ref_id='<?php echo base64_encode(@$result[0]->clg_ref_id);?>" data-href="{base_url}ms-admin/clg/get_week_range" class="click-xhttp-request"  value="month" >MONTH</option>
                        
                                    <option data-qr="output_position=pages&amp;filter=year&amp;page=reporting&amp;report_id=<?php echo base64_encode(@$report_id);?>&amp;visit_report=true&amp;clg_ref_id='<?php echo base64_encode(@$result[0]->clg_ref_id);?>" data-href="{base_url}ms-admin/clg/get_week_range" class="click-xhttp-request"  value="year" >YEAR</option>
                                
                   </select>
                    
                  
                    <div class="select_users_listing select" id="pages">
                        <select id="filter_dropdown"  name="week" class="">
                            <option value="">Page</option>
                        </select>
                    </div>
                
                 <?php  $filter=array(); if(@$users_type!=''){ $filter[$users_type['clg_first_name']." ".$users_type['clg_last_name']]="selected=selected";  }?>   
                    
                            
                    <div id="visit_select_users">               
                    
                        <select id="select_users"  name="select_users" class="select_users_listing">

                            <option value="" >Select Users</option>

                            <?php 
                
                           
                            if(count($all_users) > 0){ 
                                    foreach($all_users as $value){ 
                                        
                                    $sales_person_name = $value->clg_first_name . " ".$value->clg_last_name;
                               
                                   ?> 
                    

                                    <option data-href="{base_url}ms-admin/clg/report_list" class="form-xhttp-request" data-qr="output_position=list_table&amp;page_number=<?php echo @$page_number?>&amp;report_date_filter=true&amp;<?php if(@$visit_report=='true'){?>users=visit<?php }else{?>users=daily<?php }?>" value="<?php echo base64_encode($value->clg_ref_id); ?>"<?php echo $filter[$sales_person_name];?>><?php echo $sales_person_name; ?> </option>


                            <?php }}?>    

                        </select>
                    </div>
                    
                        <div class="float_right width2 record_top_div">
             
                        <div class="box_wrapper_record">
                       
                            <span class="dropdown_record"> Records per page : </span>
                 
                            <?php $pg_limit=array(); if(@$page_limit!=''){ $pg_limit[$page_limit]="selected='selected'"; } ?>
              
                              <select name="records_per_page" class="dropdown_per_page">

                                <option class='form-xhttp-request' data-href='{base_url}ms-admin/clg/report_list' data-qr='page_limit=10&amp;output_position=content&amp;report_date_filter=true' value='10' <?php echo $pg_limit['10']; ?>> 10 </option>

                                <option class='form-xhttp-request' data-href='{base_url}ms-admin/clg/report_list' data-qr='page_limit=20&amp;output_position=content&amp;report_date_filter=true' value='20'  <?php echo $pg_limit['20']; ?>> 20 </option>

                                <option class='form-xhttp-request' data-href='{base_url}ms-admin/clg/report_list' data-qr='page_limit=50&amp;output_position=content&amp;report_date_filter=true' value='50'  <?php echo $pg_limit['50']; ?>> 50 </option>

                                <option class='form-xhttp-request' data-href='{base_url}ms-admin/clg/report_list' data-qr='page_limit=100&amp;output_position=content&amp;report_date_filter=true' value='100'  <?php echo $pg_limit['100']; ?>> 100 </option>

                                <option class='form-xhttp-request' data-href='{base_url}ms-admin/clg/report_list' data-qr='page_limit=200&amp;output_position=content&amp;report_date_filter=true' value='200'  <?php echo $pg_limit['200']; ?>> 200 </option>
                     
                            </select>
                       
                        </div>
            
                    </div>

                    
                
            </div>
      
            
            <div id="list_table">
                
            
            
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

                                         <a class="onpage_popup action_button" data-href="{base_url}ms-admin/clg/report_operation" data-qr="action=edit&amp;output_position=popup&amp;module_name=clg&amp;report_id[0]=<?php echo base64_encode($value->report_id);?>&amp;clg_ref_id=<?php echo $value->clg_ref_id;?>&amp;current_date=<?php echo $value->date_of_report;?>&amp;view='true'&amp;page_number=<?php echo @$page_number;?>&amp;page_record=<?php echo $count_record;?>&amp;report_data=<?php echo $data; ?>" data-popupwidth="549" data-popupheight="600">
                                             View
                                        </a>

                                     </li>

                                    <?php } ?>
                                     
                                    <?php
                                    if($CI->modules->get_tool_config('MT-CLG-REPORT-EDIT',$this->active_module,true)!=''){
                                    ?>

                                     <li>

                                         <a class="onpage_popup action_button" data-href="{base_url}ms-admin/clg/report_operation" data-qr="action=edit&amp;output_position=popup&amp;module_name=clg&amp;report_id[0]=<?php echo base64_encode($value->report_id);?>&amp;clg_ref_id=<?php echo base64_encode($value->clg_ref_id);?>&amp;date_of_report=<?php echo $value->date_of_report;?>&amp;page_number=<?php echo @$page_number;?>&amp;page_record=<?php echo $count_record;?>&amp;report_data=<?php echo $data; ?>" data-popupwidth="549" data-popupheight="600">
                                             Edit
                                        </a>

                                     </li>

                                    <?php } ?>



                                    <?php  
                                    if($CI->modules->get_tool_config('MT-CLG-REPORT-DELETE',$this->active_module,true)!=''){
                                    ?>

                                    <li>

                                     <a class="action_button click-xhttp-request" data-href="{base_url}ms-admin/clg/report_operation" data-qr="action=delete&amp;module_name=sms&amp;tlcode=clg&amp;report_id[0]=<?php echo base64_encode($value->report_id);?>&amp;output_position=content&amp;page_number=<?php echo @$page_number;?>&amp;page_record=<?php echo $count_record;?>&amp;report_data=<?php echo $data; ?>" data-confirm="yes" data-confirmmessage="Are you sure to delete this report?">
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
      
            </div>
        </form>
        <div id="popup"></div>
    </div>
   
</div>