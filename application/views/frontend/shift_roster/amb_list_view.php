<?php $CI = EMS_Controller::get_instance();?>
  
<div class="breadcrumb float_left">
        <ul>
            <!-- <li class="sms">
                <a class="click-xhttp-request" data-href="{base_url}shift_roster/shift_amb_list">Ambulance</a>
            </li> -->
            <li>
                <span><?php if($verify_status=="unapprove"){ ?>Unapproved<?php } ?>Shift-Roster</span>
            </li>

        </ul>
</div>

<div class="width2 float_left ">
        
     <?= $CI->modules->get_tool_html('MT-ADD-AMBU', $CI->active_module, 'onpage_popup add_catalog_btn float_right', "", "data-popupwidth=1000  data-popupheight=500"); ?>
   
    <!-- <input class="search_button click-xhttp-request float_right" name="" value="Reset Filters" data-href="{base_url}shift_roster/shift_amb_list" data-qr="output_position=content&amp;filters=reset" type="button"> -->
   
</div>

<br>

<div class="box3">    
    
    <div class="permission_list group_list">
      
        <form method="post" name="amb_form" id="amb_list">  
            
        <div id="amb_filters"></div>
            
            <div id="list_table">
            
            
                <table class="table report_table">

                    <tr>                
                        <th nowrap>Mobile Number</th>
                        <th nowrap>Register Number</th>
                        <th nowrap>Area</th>
                        <th>City</th>
                        <th>Type</th>
                        <th>Status</th> 
                        <th>Action</th> 
                        
                    </tr>

                    <?php  if(count($result)>0){  

                    $total = 0;
                    $cur_page_sr = ($cur_page-1) * 20;
                    foreach($result as $key=>$value){  
                       ?>
                    <tr>
                     
                        <td><?php echo $value->amb_default_mobile;?></td>
                        
                        <td><?php echo $value->amb_rto_register_no;?></td>
                     
                       <?php $ar_name = $cty_name = $ambt_name = $ambs_name ='';
                            if(count($get_data) > 0){                        
                                foreach($get_data as $type){ 
                                    if($value->amb_id == $type->amb_id ){
                                        $ar_name = $type->ar_name;
                                        $cty_name =  $type->cty_name;
                                        $ambt_name = $type->ambt_name;
                                        $ambs_name = $type->ambs_name;
                                    }
                                }
                            }    
                        ?>   
                        
                        <td><?php echo $ar_name;?> </td>                            
                        <td><?php echo $cty_name;?></td>    
                        <td><?php echo $ambt_name;?></td> 
                        <td><?php echo $ambs_name;?> </td>       
                        <td> 
                                
                            <div class="user_action_box">
                            
                                <div class="colleagues_profile_actions_div"></div>
                                
                                <ul class="profile_actions_list">
                                       <?php 

                                                if($CI->modules->get_tool_config('MT-SHIFT-MNG-TEAM',$this->active_module,true)!=''){?>
                                    <li>
                                        <a class="click-xhttp-request action_button" data-href="{base_url}shift_roster/manage_team"  data-qr="output_position=content&amp;tlcode=MT-PREV-MANT-VIEW&amp;module_name=shift_roster&amp;amb_id=<?php echo base64_encode($value->amb_id); ?>">Manage Team</a>
                                    </li>
                                                <?php }

                                                if($CI->modules->get_tool_config('MT-SHIFT-IMPORT-EXCEL',$this->active_module,true)!=''){?>
                                    <li><a class="click-xhttp-request action_button" data-href="{base_url}shift_roster/import_excel_team" data-qr="output_position=popup_div&amp;amb_id=<?php echo base64_encode($value->amb_id);?>&amp;amb_action=import" data-popupwidth="1000" data-popupheight="800">Import Excel</a>
                                    </li>
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

                                <select name="pg_rec" class="dropdown_per_page float_left change-xhttp-request" data-href="{base_url}shift_roster/shift_amb_list" data-qr="output_position=content&amp;flt=true">

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