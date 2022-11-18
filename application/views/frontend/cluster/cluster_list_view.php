<?php $CI = EMS_Controller::get_instance();?>
  
<div class="breadcrumb float_left">
        <ul>
            <li class="cluster">
                <a class="click-xhttp-request" data-href="{base_url}cluster/list_cluster">Cluster</a>
            </li>
            <li>
                <span>Cluster Listing</span>
            </li>

        </ul>
</div>

<div class="width2 float_right ">
       
     <?= $CI->modules->get_tool_html('MT-ADD-CLUSTER', $CI->active_module, 'click-xhttp-request add_catalog_btn float_right', "", "data-popupwidth=1000  data-popupheight=800"); ?>
  
</div>

<br>

<div class="box3">    
    
    <div class="permission_list group_list">
      
        <form method="post" name="amb_form" id="cluster_list">  
            
        <div id="cluster_filters"></div>
            
            <div id="list_table">
            
            
                <table class="table report_table">

                    <tr>                                       
                        <th nowrap>Sr No</th>
                        <th nowrap>Cluster Name</th>
                        <th nowrap>District</th>
                        <th nowrap>Tehsil</th>
                        <th>Action</th> 
                        
                    </tr>

                    <?php  if(count($cluster_list)>0){  

                    $total = 0;
                    foreach($cluster_list as $key=>$value){  
                        $key = $key+1;
                       ?>
                    <tr>
                        
                        <td><?php echo $offset+$key;?></td>
                     
                        <td><?php echo $value->cluster_name;?></td>
                        
                        <td><?php //echo $value->district;?><?php echo $value->dst_name;?></td>
                     

                        
                        <td><?php //echo $value->taluka;?><?php echo $value->thl_name;?></td>                            
   
                        <td> 
                                
                            <div class="user_action_box">
                            
                                <div class="colleagues_profile_actions_div"></div>
                                
                                <ul class="profile_actions_list">
                                       
                                     <?php
                                    if($CI->modules->get_tool_config('MT-VIEW-CLUSTER',$this->active_module,true)!=''){ ?>
                                       
                                        <li><a class="click-xhttp-request action_button" data-href="{base_url}cluster/edit_cluster" data-qr="output_position=popup_div&amp;cluster_id[0]=<?php echo base64_encode($value->cluster_id);?>&amp;clu_action=view" data-popupwidth="1000" data-popupheight="800">View</a></li>

                                    <?php } if($CI->modules->get_tool_config('MT-EDIT-CLUSTER',$this->active_module,true)!=''){ ?>

                                        <li> <a class="click-xhttp-request action_button" data-href="{base_url}cluster/edit_cluster" data-qr="output_position=popup_div&amp;cluster_id[0]=<?php echo base64_encode($value->cluster_id);?>&amp;clu_action=edit" data-popupwidth="1000" data-popupheight="800"> Edit</a></li>

                                    <?php } if($CI->modules->get_tool_config('MT-DEL-CLUSTER',$this->active_module,true)!=''){ ?>
                                    
                                        <li><a class="action_button click-xhttp-request" data-href="{base_url}cluster/delete_cluster" data-qr="cluster_id[0]=<?php echo base64_encode($value->cluster_id);?>&amp;output_position=content&amp;page_no=<?php echo @$page_no;?>" data-confirm="yes" data-confirmmessage="Are you sure to delete this Cluster?"> Delete</a></li>

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

                                <select name="pg_rec" class="dropdown_per_page float_left change-xhttp-request" data-href="{base_url}amb/amb_listing" data-qr="output_position=content&amp;flt=true">

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