<?php

$CI = MS_Controller::get_instance();

?>



<div class="breadcrumb">
    <ul>
        <li class="">
            <a href="{base_url}ms-admin/cms/manage_navigation">Cms and Widgets</a>
        </li>
         
        <li>
            <span>Navigation List</span>
        </li>
    </ul>
</div>
<br/>
<div class="box3">
    <div class="permission_list group_list">
        <div id="ms_cms_add_page_container">
            <h3 class="txt_clr5">Navigation List</h3>
            
            <div id="ms_add_navigations"></div>
            
            <form method="post" name="manage_navigation" id="ms_manage_navigation">

                <div class="row">
                    
                     <?= $CI->modules->get_tool_html('MT-CMS-NAV-DEL-MUL',$CI->active_module,'form-xhttp-request delete_button',"","data-confirm='yes' data-confirmmessage='Are you sure to delete ?'");?>  
                    
                    <?= $CI->modules->get_tool_html('MT-CMS-NAV-ADD',$CI->active_module,'form-xhttp-request delete_button',"","");?>  
                    
                    
                </div>

                <table class="table report_table">
                    <tr>
                        <th><input type="checkbox" title="Select All Navigations" name="selectall" class="base-select" data-type="default"></th>
                        <th>Id</th>
                        <th>Title</th>
                        <th>Type</th>
                        <th>Status</th>
                        <th>Link Count</th>
                        <th>Action</th>
                    </tr>
                    <?php
                    if ($navigation_list) {
                        foreach ($navigation_list as $navigation) {
                            ?>
                            <tr>
                                <td><input type="checkbox" data-base="selectall" class="base-select" name="id[]" value="<?= $navigation->nav_id; ?>" title="Select All Navigations"/></td>
                                <td><?= $navigation->nav_id; ?></td>
                                <td><?= $navigation->nav_tite; ?></td>
                                <td><?= $navigation->nav_type; ?></td>
                                
                                
                             <!--///////////////////////////////////////////////////////////////////////////////-->   
                                
                                <td>
                                 <div id="status<?php echo $navigation->nav_id; ?>">  
                                
                                 <?php if($navigation->nav_status=="inactive"){ ?>
                             
                              
                                <a href="{base_url}ms-admin/cms/update_nav_status"  class="click-xhttp-request block_status" data-qr="status=<?php echo $navigation->nav_status;?>&nav_id=<?php echo base64_encode($navigation->nav_id); ?>&amp;output_position=status<?php echo $navigation->nav_id;?>">
                                    <div class="inactive_status"></div>
                                    </a>
                                   
                                    
                          
                               <?php }else{?>
                               
                                 
                          
                               <a href="{base_url}ms-admin/cms/update_nav_status"  class="click-xhttp-request block_status" data-qr="status=<?php echo $navigation->nav_status;?>&nav_id=<?php echo base64_encode($navigation->nav_id); ?>&amp;output_position=status<?php echo $navigation->nav_id;?>">
                          
                            
                                        <div class="active_status"></div>
                                        </a>
                               <?php }?>
                                 </div>
                                </td>
                                
                                <!--//////////////////////////////////////////////////////////////////////////////////////-->
                                
                                <td><?= $links_count[$navigation->nav_id]; ?></td>
                                <td>
                                    <div class="user_action_box">
                                        <div class="colleagues_profile_actions_div"></div>
                                        <ul class="profile_actions_list">
                                            
                                            
                                       <?php
                                              if($CI->modules->get_tool_config('MT-CMS-NAV-EDIT',$this->active_module,true)!=''){
                                        ?>
                                            <li>
                                                <a data-qr="output_position=ms_add_navigations&nav_id=<?= $navigation->nav_id; ?>" data-href="{base_url}ms-admin/cms/add_navigation" class="click-xhttp-request">Edit</a>
                                            </li>
                                            
                                            
                                        <?php } ?>   
                                            
                                            
                                            
                                         <?php
                                              if($CI->modules->get_tool_config('MT-CMS-NAV-DEL',$this->active_module,true)!=''){
                                        ?>   
                                            <li>
                                                <a data-qr="output_position=content&id=<?= $navigation->nav_id; ?>&delete_navigation=true" data-href="{base_url}ms-admin/cms/manage_navigation" class="click-xhttp-request" data-confirmmessage="Are you sure to delete ?" data-confirm="yes">Delete</a>
                                            </li>
                                       
                                         <?php } ?>   
                                            
                                            
                                            
                                        <?php
                                         if($CI->modules->get_tool_config('MT-CMS-NAV-ADD-LINKS',$this->active_module,true)!=''){
                                        ?>      
                                            <li>
                                                <a data-qr="output_position=content&nav_id=<?= $navigation->nav_id; ?>&nav_title=<?= $navigation->nav_tite;?>" data-href="{base_url}ms-admin/cms/add_navigation_links" class="click-xhttp-request">Add Links</a>
                                            </li>
                                              <?php } ?>      
                                            
                                            
                                            
                                        <?php
                                           if($CI->modules->get_tool_config('MT-CMS-NAV-VIEW-LNKS',$this->active_module,true)!=''){
                                        ?>  
                                            
                                            <li>
                                                <a data-qr="output_position=content&nav_id=<?= $navigation->nav_id; ?>&nav_title=<?= $navigation->nav_tite;?>" data-href="{base_url}ms-admin/cms/view_navigation_links" class="click-xhttp-request">View Links</a>
                                            </li>
                                            
                                            
                                       <?php } ?>      
                                            
                                            
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                            <?php
                        }
                    } else {
                        ?>
                        <tr><td colspan="7" style="text-align: center;">No navigations found</td></tr>

        <?php
    }
    ?>

                </table>
            </form>
        </div>
    </div>
</div>
