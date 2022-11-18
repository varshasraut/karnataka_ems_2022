<?php 
$CI = EMS_Controller::get_instance();

$hp_status = get_status();
$sts = get_rev_status();;

?>
  
<div class="breadcrumb float_left">
    <ul>
        <li class="sms"><a class="click-xhttp-request" data-href="{base_url}base_location/ward_listing">Ward</a></li>
        
        <li><span><?php if($verify_status=="unapprove"){ ?>Unapproved<?php } ?>Ward Location Listing</span></li>
    </ul>
</div>

<div class="width2 float_right">
                 
    
    
    <?php $CI->modules->get_tool_html('MT-ADD-HOSP', $CI->active_module, 'add_catalog_btn float_right', "", ''); ?>
    <input type="button" name="mt_add_hosp" class="click-xhttp-request float_right" data-href="{base_url}base_location/add_ward" data-qr="amp;tool_code=mt_add_hosp" value="Add Ward Location" tabindex="1" autocomplete="off">
    
    <input class="search_button click-xhttp-request float_right" name="" value="Reset Filters" data-href="{base_url}base_location/ward_listing" data-qr="output_position=content&amp;filters=reset" type="button">
           
            
</div>

<br>

<div class="box3">    
    
    <div class="permission_list group_list">
 
        <form method="post" name="hp_form" id="hp_list">  
            
        <div id="hosp_filters"> </div>
            
            <div id="list_table">
            
                <table class="table report_table">

                    <tr>                
                        <th><input type="checkbox" title="Select All Users" name="selectall" class="base-select" data-type="default"></th>                        
                        <th nowrap>Ward Name</th>
                        <th nowrap>Mobile Number</th>
                        <th nowrap>Address</th>
                        <th>District</th>
                        
                        <th>Status</th> 
                        <th>Action</th> 
                        
                    </tr>

                    <?php   if(count(@$result)>0){  

                                foreach($result as $value){ ?>
                       <?php //var_dump($value); ?>
                    <tr>
                                    <td><input type="checkbox" data-base="selectall" class="base-select" name="hp_id[<?= $value->hp_id; ?>]" value="<?=base64_encode($value->hp_id);?>" title="Select All Hospital"/></td><?php //}?>
                        
                                    <td><?php echo $value->ward_name;?></td>
                                    <td><?php echo $value->mob_no;?></td>
                        
                                    <?php $str_add= substr($value->wrd_address, 0,20); $hp_add = (strlen($value->wrd_address) >= 20) ?   ucfirst($str_add ."...") : $value->wrd_address ;?>
                         
                        
                                    <td class="max-width"><?php echo $hp_add;?></td>
                                    <?php $dst_name='';
                                        if(count($get_data1) > 0){ 
                                            //var_dump($get_data1);die;                       
                                            foreach($get_data1 as $dst){ 
                                               
                                                    $dst_name =  $dst->dst_name;
                                                
                                            }
                                        }      
                                    ?>
                                    <td class=""><?php echo $dst_name;?></td>
                                    <?php $cty_name='';
                                        if(count($get_data) > 0){                        
                                            foreach($get_data as $cty){ 
                                                if($value->hp_id == $cty->hp_id ){
                                                    $cty_name =  $cty->cty_name;
                                                }
                                            }
                                        }    
                                    ?>
                                   <!-- <td><?php //echo $cty_name;?></td> -->   
                                    
                                    <td><?php echo "<span class='".$hp_status[$value->status]."'>".$hp_status[$value->status]."</span>";?></td>               

                                    <td> 

                                        <div class="user_action_box">

                                            <div class="colleagues_profile_actions_div"></div>

                                            <ul class="profile_actions_list">

                                                <?php 

                                                if($CI->modules->get_tool_config('MT-VIEW-WARD',$this->active_module,true)!=''){?>

                                                 <li><a class="click-xhttp-request  action_button" data-href="{base_url}base_location/edit_wrd" data-qr="ward_id[0]=<?php echo base64_encode($value->ward_id);?>&amp;wrd_action=view"> View </a></li>

                                                 <?php }
                                                    
                                                 if($CI->modules->get_tool_config('MT-EDIT-WARD',$this->active_module,true)!=''){ ?> 

                                                 <li><a class="click-xhttp-request  action_button" data-href="{base_url}base_location/edit_wrd" data-qr="ward_id[0]=<?php echo base64_encode($value->ward_id);?>&amp;wrd_action=edit">Edit</a> </li>

                                                <?php } 
                                                if($CI->modules->get_tool_config('MT-DELETE-WARD',$this->active_module,true)!=''){?>

                                                <li><a class="action_button click-xhttp-request" data-href="{base_url}base_location/del_wrd" data-qr="ward_id[0]=<?php echo base64_encode($value->ward_id);?>&amp;output_position=content" data-confirm="yes" data-confirmmessage="Are you sure to delete this Ward?">Delete</a></li>

                                                <?php } 

                                                if($CI->modules->get_tool_config('UP-HOSP-STS',$this->active_module,true)!=''){ ?> 
                                               <!-- <li><a class="click-xhttp-request action_button" data-href="{base_url}base_location/up_hp_status" data-qr="output_position=content&amp;hp_id=<?php echo $value->hp_id;?>&amp;hp_sts=<?php echo $value->hp_status;?>"><?php echo $sts[$value->hp_status];?></a> </li>
                                                        -->
                                                 <?php }  ?>
                                             </ul>  

                                        </div>
                                    </td>
                    </tr>
                        <?php } ?>
                     <?php }else{   ?>

                    <tr><td colspan="9" class="no_record_text">No history Found</td></tr>
                    
                 <?php } ?>   

                </table>
                
                <div class="bottom_outer">
            
                    <div class="pagination"><?php echo $pagination; ?></div>

                    <input type="hidden" name="submit_data" value="<?php if($data){ echo $data; }?>">
 
                    <div class="width38 float_right">

                        <div class="record_per_pg">

                                <div class="per_page_box_wrapper">

                                 <span class="dropdown_pg_txt float_left">Records per page : </span>

                                    <select name="pg_rec" class="dropdown_per_page float_left change-xhttp-request" data-href="{base_url}base_location/bs_listing" data-qr="output_position=content&amp;flt=true">

                                         <?php echo rec_perpg($pg_rec); ?>

                                    </select>

                                </div>

                                <div class="float_right">
                                    <span> Total records: <?php if($total_count){ echo $total_count; }else{ echo"0";}?> </span>
                                </div>
                        </div>
                    </div>                    
                </div>      
            </div>
        </form>       
    </div>
   
</div>