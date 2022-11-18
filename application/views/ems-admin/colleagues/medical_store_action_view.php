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
        $arr['filter'] = $key;
        
    }
}
   $data =base64_encode(json_encode($arr)); 
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
  
        <form method="post" name="medical_store_action" class="medical_store_action">  
            
            <div class="report_groups">
                 
                    <div class="float_right width2 record_top_div">
             
                        <div class="box_wrapper_record">
                       
                            <span class="dropdown_record"> Records per page : </span>
                 
                            <?php $pg_limit=array(); if(@$page_limit!=''){ $pg_limit[$page_limit]="selected='selected'"; } ?>
              
                            <select name="records_on_page" class="dropdown_per_page">

                                <option class='form-xhttp-request' data-href='{base_url}ms-admin/clg/daily_report_action_view' data-qr='page_limit=10&amp;output_position=popup<?php if(!@$current_date){?>&amp;report_date_filter=true<?php }?>&amp;clg_ref_id=<?php echo base64_encode(@$clg_ref_id);?>&amp;filter_data=<?php echo $data;?>' value='10' <?php echo $pg_limit['10']; ?>> 10 </option>

                                <option class='form-xhttp-request' data-href='{base_url}ms-admin/clg/daily_report_action_view' data-qr='page_limit=20&amp;output_position=popup<?php if(!@$current_date){?>&amp;report_date_filter=true<?php }?>&amp;clg_ref_id=<?php echo base64_encode(@$clg_ref_id);?>&amp;filter_data=<?php echo $data;?>' value='20'  <?php echo $pg_limit['20']; ?>> 20 </option>

                                <option class='form-xhttp-request' data-href='{base_url}ms-admin/clg/daily_report_action_view' data-qr='page_limit=50&amp;output_position=popup<?php if(!@$current_date){?>&amp;report_date_filter=true<?php }?>&amp;clg_ref_id=<?php echo base64_encode(@$clg_ref_id);?>&amp;filter_data=<?php echo $data;?>' value='50'  <?php echo $pg_limit['50']; ?>> 50 </option>

                                <option class='form-xhttp-request' data-href='{base_url}ms-admin/clg/daily_report_action_view' data-qr='page_limit=100&amp;output_position=popup<?php if(!@$current_date){?>&amp;report_date_filter=true<?php }?>&amp;clg_ref_id=<?php echo base64_encode(@$clg_ref_id);?>&amp;filter_data=<?php echo $data;?>' value='100'  <?php echo $pg_limit['100']; ?>> 100 </option>

                                <option class='form-xhttp-request' data-href='{base_url}ms-admin/clg/daily_report_action_view' data-qr='page_limit=200&amp;output_position=popup<?php if(!@$current_date){?>&amp;report_date_filter=true<?php }?>&amp;clg_ref_id=<?php echo base64_encode(@$clg_ref_id);?>&amp;filter_data=<?php echo $data;?>' value='200'  <?php echo $pg_limit['200']; ?>> 200 </option>
                     
                            </select>
                      

                        </div>
            
                    </div>
       
                
            </div>
      
            
            <div id="list_table">
            
                <table class="table report_table">

                    <tr>
                    
                        <th nowrap>Medical Store</th>
                       
                        <th>Report Time</th>
                        <th nowrap>Distance From</th>
                        <th nowrap>Distance</th>
                        <th nowrap>Date</th>
                        <th>Feedback</th>      
                       
                    </tr>

                    <?php  if(count(@$result)>0){  
                        
                    $total = 0;
                    foreach($result as $value){  
                       ?>
                    <tr>
                         
                        
                        
                        <td><?php echo $value->medical_store_name;?></td>
                        
                       
                        
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
                      <span> Total visit Report: <?php if(@total_count){ echo @$total_count; }else{ echo"0";}?> </span>
                    </div>
      
            </div>
        </form>
        <div id="popup"></div>
    </div>
   
</div>