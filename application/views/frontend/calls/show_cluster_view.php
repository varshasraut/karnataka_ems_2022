                        <div class="field_row ">
                            <div class="field_lable"><label for="schedule_clusterid">Cluster<span class="md_field">*</span></label></div>   

                            <div class="field_input">
                                <select name="incient[cluster_name]" class="" id="cluster_list_id" data-errors="{filter_required:'Cluster should not be blank'}" onchange="on_cluster_change_load_map(this)">
                                
                                    <option value="">Select Cluster</option>
                                    <?php foreach($cluster_data as $cluster){?>
                                     <option value="<?php echo $cluster->cluster_id;?>" data-lat="<?php echo $cluster->cluster_lat;?>" data-lng="<?php echo $cluster->cluster_long;?>"><?php echo $cluster->cluster_name;?></option>
                                    <?php }?>
                                   
                                </select>
<!--                                <input  name="schedule_clusterid" value="" class="mi_autocomplete width99 filter_required" data-href="{base_url}auto/get_auto_cluster_by_user" tabindex="7" data-value="<?php echo $update[0]->cluster_name; ?>" data-nonedit="yes" readonly="readonly" data-errors="{filter_required:'Cluster should not be blank'}"  id="clusterid" data-callback-funct="cluster_auto_address">-->
                            </div>
                        </div>