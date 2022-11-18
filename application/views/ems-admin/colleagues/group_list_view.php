<?php

$CI = EMS_Controller::get_instance();

?>

<div class="breadcrumb">
  <ul>
    <li class="colleague"><a href="{base_url}ms-admin/clg/colleagues">Colleague</a></li>
    <li><span>Groups Listing</span></li>
  </ul>
</div>
<br/>
<div class="box3">
  <div class="permission_list group_list">
   
     <div id="add_group">
     
     </div>

   <form method="post" action="#" class="">
     <div class="row width1">
      <?=$CI->modules->get_tool_html('MT-CLG-GROUP-DELETE',$CI->active_module,'form-xhttp-request delete_button',"","data-confirm='yes' data-confirmmessage='Are you sure to delete ?'");?>
      <?=$CI->modules->get_tool_html('MT-CLG-ADD-GROUP',$CI->active_module,'top_ancher');?>
    </div>
    <table class="table report_table">
      <tr>
        <th><input type="checkbox" title="Select All groups" name="selectall" class="base-select" data-type='default' /></th>
        <th>Groups Name</th>
        <th>Groups Code</th>
        <th>Groups Status</th>
        <th>Actions</th>
        
        </tr>
        
       <?php foreach ($users as $users_group):	 ?>
             
      <tr>
            
            <td>
                <?php if($users_group->glevel!='primary'){ ?>
                <input type="checkbox"  title="Select All GroupId" data-base="selectall"  value="<?php echo $users_group->gid;?>" name="id[<?php echo $users_group->gid;?>]"  class="base-select" >
                <?php } ?>
            </td>
            
            <td><?php echo $users_group->ugname;?></td>
            
            <td><?php echo $users_group->gcode;?></td>
            
            <td><?php if($CI->modules->get_tool_config('MT-CLG-GROUP-EDIT',$this->active_module,true)!=''){ ?>

					<a href="{base_url}clg/update_group"  class="capital <?php echo $color[$users_group->status]?> click-xhttp-request" data-qr="output_position=content&module_name=clg&tlcode=MT-CLG-GROUP-EDIT&status=<?php echo $users_group->status;?>&id=<?php echo base64_encode($users_group->gid);?>">
                       <?php if($users_group->status=="active"){?><div class="inactive_status"></div><?php } else{ ?> <div class="active_status"></div> <?php }?>
                    
                    </a>
							
					
           <?php }else { if($users_group->status=="active"){?><div class="inactive_status"></div> <?php } else{ ?> <div class="active_status"></div><?php }}?>
                    
           </td>
           
           <td>
                <?php if($users_group->glevel!='primary'){ ?>
                   <?=$CI->modules->get_tool_html('MT-CLG-GROUP-EDIT',$CI->active_module,'edit_img',"?id=".base64_encode($users_group->gid));?>
           	   <?=$CI->modules->get_tool_html('MT-CLG-GROUP-DELETE',$CI->active_module,'click-xhttp-request delete_img',"?id=".base64_encode($users_group->gid),"data-confirm='yes' data-confirmmessage='Are you sure to delete ?'");?>
                <?php
          
                } ?>
           </td>
           
      </tr>
      <?php endforeach;?>
    </table>
        <div class="float_right">
                <span>Total groups  : <?php if(@$total_groups){ echo  $total_groups; } else{ echo"0";}?></span>
        </div>
    </form>
  </div>
</div>
  
