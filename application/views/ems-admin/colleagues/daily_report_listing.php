<?php 



?>
  
<div class="msg"><?php echo $res;?></div>
<div class="breadcrumb">
    <ul>
        <li class="sms">
            <a href="{base_url}ms-admin/clg/daily_report_listing">Colleagues</a>
        </li>
        <li>
            <span><?php if($verify_status=="unapprove"){ ?>Unapproved<?php } ?>Daily Report Listing</span>
        </li>
       
    </ul>
</div>

<br>

<div id="popup_div"></div>

<div class="box3">    
    
    <div class="permission_list group_list">
        
        <h3 class="txt_clr5">Daily Report Listing</h3>
                     
        <form method="post" name="report_daily_form" class="daily_report_listing">  
            
            <?php foreach(@$dist_data as $report_id){
                    $report_id = $report_id->report_id;
            }
           ?>
            
            <div class="report_groups">
                   
                      
                    
                  
                                           
                    <select id="filter_dropdown"  name="filter" class="select_users_listing change-xhttp-request" data-qr="output_position=page&amp;page=dly_report" data-href="{base_url}ms-admin/clg/get_week_range">
                         
                        <option value="" >List By</option>

				        <option data-qr="output_position=pages&amp;filter=day&amp;page=dly_report&amp;daily_report=true" data-href="{base_url}ms-admin/clg/get_week_range" class="click-xhttp-request"  value="day" >DAYS</option>
                        <option data-qr="output_position=pages&amp;filter=week&amp;page=dly_report&amp;daily_report=true" data-href="{base_url}ms-admin/clg/get_week_range" class="click-xhttp-request"  value="week" >WEEK</option>
                                                    
						<option data-qr="output_position=pages&amp;filter=month&amp;page=dly_report&amp;daily_report=true" data-href="{base_url}ms-admin/clg/get_week_range" class="click-xhttp-request"  value="month" >MONTH</option>
                        
                       <option data-qr="output_position=pages&amp;filter=year&amp;page=dly_report&amp;daily_report=true" data-href="{base_url}ms-admin/clg/get_week_range" class="click-xhttp-request"  value="year" >YEAR</option>
                                
                   </select>
                   
                  
                    <div class="select_users_listing select" id="page">
                        <select id="filter_dropdown"  name="weekdays" class="">

                            <option value="" >Page</option>

                        </select>
                    </div>
                  <?php $filter=array(); if(@$user_type!='') { $filter[@$user_type]="selected='selected'";  }  ?>             
                <div id="daily_list_table1"> 
                    <select id="select_users"  name="select_users" class="select_users_listing">
                        
                        <option value="" >Select Users</option>
                        
                        <?php  
                        
                        foreach(@$sales_person as $value){ 
                           
                            $sales_person_name = $value->clg_first_name . " ".$value->clg_last_name;
                          
                          
                        ?>

                        <option data-href="{base_url}ms-admin/clg/daily_report_listing" class="form-xhttp-request" data-qr="output_position=daily_list_table&amp;clg_ref_id=<?php echo base64_encode($value->clg_ref_id);?>&amp;page_number=<?php echo @$page_number?>" value="<?php echo base64_encode($value->clg_ref_id); ?>"<?php echo $filter[$sales_person_name];?>><?php echo $sales_person_name; ?> </option>
                        
                        
                       <?php }?>    
                                    
                    </select>
                    
                </div>
                     
                    <div class="float_right width2 record_top_div">
             
                        <div class="box_wrapper_record" id="daily_record_per_page">
                
                            <span class="dropdown_record"> Records per page : </span>
                 
                            <?php $pg_limit=array(); if(@$page_limit!=''){ $pg_limit[$page_limit]="selected='selected'"; } ?>
              
                            <select name="records_per_page" class="dropdown_per_page">

                                <option class='form-xhttp-request' data-href='{base_url}ms-admin/clg/daily_report_listing' data-qr='page_limit=10&amp;output_position=content' value='10' <?php echo $pg_limit['10']; ?>> 10 </option>

                                <option class='form-xhttp-request' data-href='{base_url}ms-admin/clg/daily_report_listing' data-qr='page_limit=20&amp;output_position=content' value='20'  <?php echo $pg_limit['20']; ?>> 20 </option>

                                <option class='form-xhttp-request' data-href='{base_url}ms-admin/clg/daily_report_listing' data-qr='page_limit=50&amp;output_position=content' value='50'  <?php echo $pg_limit['50']; ?>> 50 </option>

                                <option class='form-xhttp-request' data-href='{base_url}ms-admin/clg/daily_report_listing' data-qr='page_limit=100&amp;output_position=content' value='100'  <?php echo $pg_limit['100']; ?>> 100 </option>

                                <option class='form-xhttp-request' data-href='{base_url}ms-admin/clg/daily_report_listing' data-qr='page_limit=200&amp;output_position=content' value='200'  <?php echo $pg_limit['200']; ?>> 200 </option>
                     
                            </select>

                        </div>
            
                    </div>
       
                
            </div>
        
            
            <div id="daily_list_table">
            
                <table class="table report_table">

                    <tr>
                        <th><input type="checkbox" title="Select All Users" name="selectall" class="base-select daily_ch" data-type="default"></th>
                        <th nowrap>Sales Person</th>
                        <th>Medical Store</th>
                        <th nowrap>Distance (KM)</th>
                        <th nowrap>Date</th>
                    </tr>

                    <?php  if(count(@$dist_data)>0){
                        
                    $total = 0;
                    foreach($dist_data as $value){  
                       ?>
                    <tr>
                        <td nowrap><input type="checkbox" data-base="selectall" class="base-select" name="report_id[<?= $value->report_id; ?>]" value="<?=base64_encode($value->report_id);?>" title="Select All Discount"/></td>
                        <?php $sales_person_name = $value->clg_first_name . " ".$value->clg_last_name;?>
                        <td><?php echo $sales_person_name;?></td>
                        <td>
                            <a href="<?php echo base_url();?>ms-admin/clg/daily_report_action_view" data-qr="output_position=popup&amp;page_number=<?php echo @$page_number;?>&amp;clg_ref_id=<?php echo base64_encode($value->clg_ref_id)?>&amp;daily_report=true&amp;post_data=<?php  ?>" class="view_link onpage_popup view_cpn_code" data-popupwidth="900" data-popupheight="700">View</a>
                        
                        </td>
                        
                        <td>
                        <?php foreach(@$sum_of_distance as $dist){   
                            
                                if($dist->clg_ref_id == $value->clg_ref_id){
                                   echo $dist->distance; ?>&nbsp;KM
                               
                        <?php  } }?>
                        
                        </td>
                                                  
                         
                         
                        <?php  $date = $value->date_of_report;?>
                    
                        <td><?php 
                                
                                  $date = $value->date_of_report;
                                                          
                                echo date("j\<\s\u\p\>S\<\/\s\u\p\> M Y", strtotime(date("Y-m-d"))); 
                           
                       ?></td>
                      

                    </tr>
                     <?php } ?>
                <?php }else{   ?>


                    <tr><td colspan="9" class="no_record_text">No history Found</td></tr>


                 <?php } ?>   


                </table>
            
                    <div class="pagination">
                        <?php echo $pagination; ?>
                    </div>


                    <div class="float_right">
                      <span> Total Daily Report: <?php if(@$total_count){ echo @$total_count; }else{ echo"0";}?> </span>
                    </div>
      
            </div>
        </form>
        <div id="popup"></div>
    </div>
   
</div>