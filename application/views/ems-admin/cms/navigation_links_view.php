<?php

$CI = EMS_Controller::get_instance();

?>

<div class="breadcrumb">
    <ul>
        <li class="goods">
            <a href="{base_url}cms/manage_navigation">Cms and Widgets</a>
        </li>
        <li class="">
            <a href="{base_url}cms/manage_navigation">Manage navigation</a>
        </li>
        <li>
            <span>Links of <?php echo @$navigation_details[0]->nav_tite; ?></span>
        </li>
    </ul>
</div>
<br/>>
<div class="box3">
    <div class="permission_list group_list">
        <div id="ms_cms_add_page_container">
            <h3 class="txt_clr5">List Of Links</h3>
            <form method="post" name="link_list_form" id="ms_link_list_form">
                <input type="hidden" name="nav_id" value="<?= $navigation_id ?>"/>
                <div class="row">
                    
                     <?= $CI->modules->get_tool_html('MT-CMS-NAV-DEL-LNK-M',$CI->active_module,'form-xhttp-request delete_button',"","data-confirm='yes' data-confirmmessage='Are you sure to delete ?'");?>  
                    
                    
                </div>

                <table class="table report_table">
                    <tr>
                        <th><input type="checkbox" title="Select All Pages" name="selectall" class="base-select" data-type="default"></th>
                        <th>Name</th>
                        <th>Type</th>
                        <th>Slug</th>
                        <th>Section</th>
                        <th>Link User Type</th>
                        <th>Action</th>
                    </tr>
                    <?php
                    if ($navigation_links) {
                        foreach ($navigation_links as $link) { // var_dump($link);
                            ?>
                            <tr>
                                <td><input type="checkbox" data-base="selectall" class="base-select" name="id[<?= $link->lnk_id; ?>]" value="<?= $link->lnk_id; ?>" title="Select All Links"/></td>
                                <td><?= $link->lnk_name; ?></td>
                                <td><?= $link->lnk_type; ?></td>
                                <td><?= $link->lnk_slug; ?></td>
                                <td><?= $link->lnk_section; ?></td>
                                <td><?= $link->lnk_for_users; ?></td>
                                <td>
                                    <div class="user_action_box">
                                        <div class="colleagues_profile_actions_div"></div>
                                        <ul class="profile_actions_list">
                                            
                                        <?php
                                              if($CI->modules->get_tool_config('MT-CMS-NAV-DEL-LNK',$this->active_module,true)!=''){
                                        ?>   
                                            
                                            <li>
                                                <a data-confirmmessage="Are you sure to delete ?" data-confirm="yes" data-qr="output_position=content&id=<?= $link->lnk_id; ?>&nav_id=<?= $navigation_id ?>&delete_links=true" data-href="{base_url}cms/view_navigation_links" class="click-xhttp-request">Delete</a>
                                            </li>
                                          
                                            
                                           <?php } ?>   
                                                
                                            
                                         <?php
                                            if($CI->modules->get_tool_config('MT-CMS-NAV-EDIT-LNK',$this->active_module,true)!=''){
                                        ?>   
                                            
                                            <li>
                                                <a data-qr="output_position=content&nav_id=<?= $navigation_id ?>&lnk_id=<?= $link->lnk_id; ?>" data-href="{base_urlcms/update_navigation_links" class="click-xhttp-request">Edit</a>
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
                        <tr><td colspan="9" style="text-align: center;">No links found</td></tr>

        <?php
    }
    ?>

                </table>
            </form>
        </div>
    </div>
</div>
