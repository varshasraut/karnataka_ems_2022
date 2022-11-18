<?php
$selected_group[$user_code] = 'selected="selected"';
$module_checked = array(0=>'',1=>'checked="checked"');

?>
<div class="breadcrumb">
  <ul>
    <li class="colleague"><a href="{base_url}module/permission">Colleague</a></li>
    <li><span>Permission Listing</span></li>
  </ul>
</div>
<br />
<div class="box3">
  <div class="permission_list">
    <h3 class="txt_clr5">Permission Listing</h3>
    <form method="post" action="{base_url}module/permission" method="post" class="group_permission_list">
    <div class="row">
      <div class="input_title">Users Group</div>
      <div class="input_field">
        <select name="user_group" id="user_group"  class="change-xhttp-request"  data-href="{base_url}module/permission" data-qr="output_position=content&amp;module_name=module&amp;tlcode=MT-SET-PERMISSION">
          <?php 
		  
		  foreach ($users as $users_data):?>
          <option value="<?php echo $users_data->gcode; ?>" <?php echo @$selected_group[$users_data->gcode]?> ><?php echo $users_data->ugname;?></option>
          <?php endforeach;?>
        </select>
      </div>
    </div>
    <div class="row">
      <div class="input_title">All Permission</div>
      <div class="input_field">
        <div class="checkbox_button_div">
          <input type="checkbox" title="Select All permission" name="selectall" class="base-select" data-type='default' >
        </div>
      </div>
    </div>
    <table class="table">
      <tr>
        <th>Modules</th>
        <th>Actions</th>
        <?php if(is_array($group_permissions)){
			 
			   foreach($group_permissions as $module){
				     $name = "modules[".$module->mcode."]";
			         $tools = json_decode("[".$module->tools."]");
			   ?>
      
      
      <tr>
        <td nowrap="nowrap" valign="top" class="width25"><input type="checkbox"  title="Select All Tools" data-base="selectall"  value="<?php echo $module->mcode;?>" name="<?php echo $name?>"  class="base-select" <?php echo $module_checked[$module->module_selected]?> >
          <label><?php echo $module->module?></label></td>
        <td valign="top"><?php 
			if(is_array($tools)){
				
				
			foreach($tools as $tool){
				 
			if(@$tool->tlcode != ""){
			?>
          <div class="module_tool">
            <input type="checkbox"  value="<?php  echo $tool->tlcode;?>" name="<?php echo $name?>[<?php  echo $tool->tlcode;?>]" data-base="selectall <?php echo $name?>" <?php echo $module_checked[$tool->tl_selected]?> >
            <label><?php echo $tool->tl_name?></label>
          </div>
          <?php }
			
			  }
			}
			?></td>
      </tr>
      <?php 
		        }
			}
			
			?>
    </table>
    <div class="button_field_row">
      <input type="button" name="submit_permission" id="btnsave" value="Submit" class="btn submit_btn form-xhttp-request" data-href="{base_url}module/permission" data-qr="output_position=content&amp;module_name=module&amp;tlcode=MT-SAVE-PERMISSION">
    </div>
    </form>
  </div>
</div>
