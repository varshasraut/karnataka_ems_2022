<?php $CI = EMS_Controller::get_instance();?>
  
<div class="breadcrumb float_left">
    <ul>
        <li>
            <h2>Student Listing</h2>
        </li>
   </ul>
</div>

<br><br>

<div class="box3">    
    
    <div class="permission_list group_list">
      
        <form method="post" name="amb_form" id="student_list">  
            
            <div id="amb_filters">
                   <?= $CI->modules->get_tool_html('MT-STUD-ADD', $CI->active_module, 'click-xhttp-request add_catalog_btn float_right', "", "data-popupwidth=1000  data-popupheight=800"); ?><br>
            </div><br>
            
            <div id="list_table">
            
            
                <table class="table report_table">

                    <tr>                                       
                        <th nowrap>Sr No</th>
                        <th nowrap>Registration No</th>
                        <th nowrap>Student Name</th>
                        <th nowrap>School Name</th>
                        <th nowrap>Status</th>
                        <th>Action</th> 
                        
                    </tr>

                    <?php  if(count($student_data)>0){  

                    $total = 0;
                    foreach($student_data as $key=>$value){  
                       ?>
                            <tr>
                        
                        <td><?php echo $key+1;?></td>
                     
                        <td><?php echo $value->stud_reg_no;?></td>
                        
                        <td><?php echo $value->stud_first_name;?> <?php echo $value->stud_last_name;?></td>
                        <td><?php echo $value->school_name;?></td>
                        <td><?php if ($value->stud_isapproved == 0){ echo "Approval Pending"; }else if($value->stud_isapproved == 1){ echo "Approved"; } else{ echo "Not Approved"; };?></td>      
                        <td> 
                         <div class="user_action_box">
                            
                                <div class="colleagues_profile_actions_div"></div>
                                
                                <ul class="profile_actions_list">
                                       
                                     <?php
                                    if($CI->modules->get_tool_config('MT-STUD-EDIT',$this->active_module,true)!=''){ ?>
                                       
                                        <li><a class="click-xhttp-request action_button" data-href="{base_url}students/edit_students" data-qr="output_position=popup_div&amp;stud_id[0]=<?php echo base64_encode($value->stud_id);?>&amp;stud_action=view" data-popupwidth="1000" data-popupheight="800">View</a></li>

                                    <?php } if($CI->modules->get_tool_config('MT-STUD-VIEW',$this->active_module,true)!=''){ ?>

                                        <li> <a class="click-xhttp-request action_button" data-href="{base_url}students/edit_students" data-qr="output_position=popup_div&amp;stud_id[0]=<?php echo base64_encode($value->stud_id);?>&amp;stud_action=edit" data-popupwidth="1000" data-popupheight="800">Edit</a></li>

                                    <?php } if($CI->modules->get_tool_config('MT-STUD-DEL',$this->active_module,true)!=''){ ?>
                                    
                                        <li><a class="action_button click-xhttp-request" data-href="{base_url}students/delete_students" data-qr="stud_id[0]=<?php echo base64_encode($value->stud_id);?>&amp;output_position=content&amp;page_no=<?php echo @$page_no;?>" data-confirm="yes" data-confirmmessage="Are you sure to delete this Student?">Delete</a></li>

                                    <?php } if($CI->modules->get_tool_config('MT-STUD-APPROVE',$this->active_module,true)!=''){ ?>
                                    
                                        <li><a class="action_button click-xhttp-request" data-href="{base_url}students/approve_students" data-qr="stud_id[0]=<?php echo base64_encode($value->stud_id);?>&amp;output_position=content&amp;page_no=<?php echo @$page_no;?>" data-confirm="yes" data-confirmmessage="Are you sure to approve this Student?">Approve</a></li>

                                    <?php } ?>
                                </ul> 
                            </div>  
                        </td>
                        
                    </tr>

                    <?php } }else{   ?>
                              
                    <tr><td colspan="9" class="no_record_text">No Student Found</td></tr>
                    
                 <?php } ?>   

                </table>
                
                <div class="bottom_outer">
            
                    <div class="pagination"><?php echo $pagination; ?></div>

                    <input type="hidden" name="submit_data" value="<?php if(@$data){ echo $data; }?>">
 
                    <div class="width38 float_right">

                        <div class="record_per_pg">

                            <div class="per_page_box_wrapper">

                                <span class="dropdown_pg_txt float_left"> Records per page : </span>

                                <select name="pg_rec" class="dropdown_per_page float_left change-xhttp-request" data-href="{base_url}students/student_listing" data-qr="output_position=content&amp;flt=true">

                                    <?php echo rec_perpg($pg_rec); ?>

                                </select>

                            </div>

                                <div class="float_right">
                                    <span> Total records: <?php echo (@$total_count) ?  $total_count : "0";?> </span>
                                </div>
                        </div>

                    </div>
                    
                </div>
      
            </div>
        </form>
    </div>
</div>