<?php $CI = EMS_Controller::get_instance();?>
  
<div class="breadcrumb float_left">
        <ul>
            <li class="sms">
                <a class="click-xhttp-request" data-href="{base_url}schools/school_listing">Schools</a>
            </li>
            <li>
                Schools Listing
            </li>

        </ul>
</div>

<div class="width2 float_right ">
        
     <?= $CI->modules->get_tool_html('MT-ADD-SCHO', $CI->active_module, 'click-xhttp-request add_catalog_btn float_right', "", "data-popupwidth=1000  data-popupheight=800"); ?>
   
    <input class="search_button click-xhttp-request float_right" name="" value="Reset Filters" data-href="{base_url}schools/school_listing" data-qr="output_position=content&amp;filters=reset" type="button">
   
</div>

<br><br>

<div class="box3">    
    
    <div class="permission_list group_list">
      
        <form method="post" name="school_form" id="school_list">  
            
        <div id="amb_filters"></div>
            
            <div id="list_table">
            
            
                <table class="table report_table">

                    <tr>                
                        <th><input type="checkbox" title="Select All Users" name="selectall" class="base-select" data-type="default"></th>                        
                        <th nowrap>School Name</th>
                        <th nowrap>Register Number</th>
                        <th nowrap>Mobile Number</th>
                        <th nowrap>Head Master</th>
                        <th nowrap>Cluster Name</th>
                        <th>Action</th> 
                        
                    </tr>

                    <?php  if(count($result)>0){  

                    $total = 0;
                    foreach($result as $value){  
                       ?>
                    <tr>
                        <td><input type="checkbox" data-base="selectall" class="base-select" name="school_id[<?= $value->school_id; ?>]" value="<?=base64_encode($value->school_id);?>" title="Select All Schools"/></td><?php //}?>
                        
                        <td><?php echo $value->school_name;?></td>
                     
                        <td><?php echo $value->school_reg_no;?></td>
                        
                        <td><?php echo $value->school_mobile;?></td>
                        <td><?php echo $value->clg_first_name;?> <?php echo $value->clg_mid_name;?> <?php echo $value->clg_last_name;?></td>
                        <td><?php echo $value->cluster_name;?></td>
                             
                        <td> 
                                
                            <div class="user_action_box">
                            
                                <div class="colleagues_profile_actions_div"></div>
                                
                                <ul class="profile_actions_list">
                                       
                                     <?php
                                    if($CI->modules->get_tool_config('MT-VIEW-SCHO',$this->active_module,true)!=''){ ?>
                                       
                                        <li><a class="click-xhttp-request action_button" data-href="{base_url}schools/edit_school" data-qr="output_position=popup_div&amp;school_id[0]=<?php echo base64_encode($value->school_id);?>&amp;school_action=view" data-popupwidth="1000" data-popupheight="800">View</a></li>

                                    <?php } if($CI->modules->get_tool_config('MT-EDIT-SCHO',$this->active_module,true)!=''){ ?>

                                        <li> <a class="click-xhttp-request action_button" data-href="{base_url}schools/edit_school" data-qr="output_position=popup_div&amp;school_id[0]=<?php echo base64_encode($value->school_id);?>&amp;school_action=edit" data-popupwidth="1000" data-popupheight="800"> Edit</a></li>

                                    <?php } if($CI->modules->get_tool_config('MT-DEL-SCHO',$this->active_module,true)!=''){ ?>
                                    
                                        <li><a class="action_button click-xhttp-request" data-href="{base_url}schools/del_school" data-qr="school_id[0]=<?php echo base64_encode($value->school_id);?>&amp;output_position=content&amp;page_no=<?php echo @$page_no;?>" data-confirm="yes" data-confirmmessage="Are you sure to delete this Schools?"> Delete</a></li>

                                    <?php } ?>
                                </ul> 
                            </div>
                        </td>
                    </tr>
                     <?php } }else{   ?>

                    <tr><td colspan="9" class="no_record_text">No history Found</td></tr>
                    
                 <?php } ?>   

                </table>
                
                <div class="bottom_outer">
            
                    <div class="pagination"><?php echo $pagination; ?></div>

                    <input type="hidden" name="submit_data" value="<?php if(@$data){ echo $data; }?>">
 
                    <div class="width38 float_right">

                        <div class="record_per_pg">

                            <div class="per_page_box_wrapper">

                                <span class="dropdown_pg_txt float_left"> Records per page : </span>

                                <select name="pg_rec" class="dropdown_per_page float_left change-xhttp-request" data-href="{base_url}school/school_listing" data-qr="output_position=content&amp;flt=true">

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