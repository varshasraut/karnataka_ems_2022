<div class="field_lable"><label for="team_member">Parent Team Member<span class="md_field">*</span></label></div>
<select id="group" name="clg[cluster_id][]"  class="filter_required" data-errors="{filter_required:'Cluster should not blank'}" TABINDEX="7"  <?php echo $view;?> multiple="multiple">
    
        <option value="">Select Cluster</option>
       
         
         <?php  if(count($cluster_list)>0){ 
    
                    foreach($cluster_list as $cluster){  
                        ?>
         
                        <option value="<?php echo $cluster->cluster_id;?>"><?php echo $cluster->cluster_name;?></option>
         
          <?php    }
          
                } ?>
</select>