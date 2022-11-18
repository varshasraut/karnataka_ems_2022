<?php
    $CI = MS_Controller::get_instance();


?>
<div class="breadcrumb">
    <ul>
        <li class="goods">
            <a href="{base_url}ms-admin/cms/list_pages">Cms and Widgets</a>
        </li>
        <li>
            <span>Pages List</span>
        </li>
    </ul>
</div>
<br/>

<div class="box3">
    <div class="permission_list group_list">
        <div id="ms_cms_add_page_container">
            
            <h3 class="txt_clr5">Pages List</h3>
            <form action="#" method="post" name="category_form">

                <div class="row">

                    
                      <?= $CI->modules->get_tool_html('MT-CMS-DEL-PAGES',$CI->active_module,'form-xhttp-request delete_button',"","data-confirm='yes' data-confirmmessage='Are you sure to delete ?'");?>  
                      
                </div>

                <table class="table report_table">
                    <tr>
                        <th><input type="checkbox" title="Select All Pages" name="selectall" class="base-select" data-type="default"></th>
                        <th>Page id</th>
                        <th nowrap>Title</th>
                        <th>Keywords</th>
                        <th nowrap>Meta Description</th>
                        <th>Created</th>
                        <th>Updated</th>
                        <th>Action</th>
                    </tr>
                    <?php
                    if ($page_list) {
                        foreach ($page_list as $page) {
                            ?>
                            <tr>
                                <td><input type="checkbox" data-base="selectall" class="base-select" name="id[]" value="<?= $page->id; ?>" title="Select All Pages"/></td>
                                
                                <td>
                                    
                                                    <?php echo $page->id; ?>
                                    
                                </td>
                                
                                <td>
                                                    <?php echo $page->title; ?>
                                    
                                </td>
                              
                                <td>
                                    <?php if(strlen($page->meta_keywords) > 10): ?>
                                        <?=mb_substr($page->meta_keywords, 0, 10)."..."; ?>
                                    <?php else: ?>
                                        <?=$page->meta_keywords;?>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if(strlen($page->meta_desc) > 10): ?>
                                        <?=mb_substr($page->meta_desc, 0, 10)."..."; ?>
                                    <?php else: ?>
                                        <?=$page->meta_desc;?>
                                    <?php endif; ?>
                                </td>
                                <td><?= date("d M Y",strtotime($page->created_at)); ?></td>
                                <td><?= date("d M Y",strtotime($page->updated_at)); ?></td>
                                <td>
                                    <div class="user_action_box">
                                        <div class="colleagues_profile_actions_div"></div>
                                        <ul class="profile_actions_list">
                                            
                                        <?php
                                              if($CI->modules->get_tool_config('MT-CMS-EDIT-PAGE',$this->active_module,true)!=''){
                                        ?>
                                            <li>
                                                <a data-qr="output_position=content&page_id=<?= $page->id; ?>" data-href="{base_url}ms-admin/cms/add_pages" class="click-xhttp-request">Edit</a>
                                            </li>
                                              <?php } ?>
                                            
                                        <?php
                                            if($CI->modules->get_tool_config('MT-CMS-DEL-PAGE',$this->active_module,true)!=''){
                                        ?>
                                            
                                            <li>
                                                <a data-confirmmessage="Are you sure to delete ?" data-confirm="yes" data-qr="output_position=content&id=<?= $page->id; ?>&delete_page=true" data-href="{base_url}ms-admin/cms/list_pages" class="click-xhttp-request">Delete</a>
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
                        <tr><td colspan="7" style="text-align: center;">No pages found<td></tr>

        <?php
    }
    ?>

                </table>
            </form>
        </div>
    </div>
</div>
