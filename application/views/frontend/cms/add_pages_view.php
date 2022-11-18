<?php

$CI = MS_Controller::get_instance();

?>

<div class="breadcrumb">
    <ul>
        <li class="goods">
            <a href="{base_url}ms-admin/cms/list_pages">Cms and Widgets</a>
        </li>
        <li>
            <span>Add Pages</span>
        </li>
    </ul>
</div>
<br/>
<div class="box3">
    <div class="permission_list group_list">
        <div id="ms_cms_add_page_container">
            
                            <h3 class="txt_clr5">Add pages</h3>
                            <form method="post" enctype="multipart/form-data" id="add_pages_form">
                                <input type="hidden" name="page_id" value="<?= $page_details[0]->id; ?>"/>
                                <input type="hidden" name="action" value="<?= $view; ?>"/>
                                <div class="width6 float_left">

                                    <div class="field_row">
                                        <div class="field_lable"><label for="page_title">Page title*</label></div>
                                        <div class="filed_input"><input type="text" name="page_title" placeholder="page title" id="page_title" class="filter_required" data-errors="{filter_required:' Page title should not be blank.'}" value="<?= $page_details[0]->title; ?>"/></div>
                                    </div>

                                    
                                    <div class="field_row page_description">
                                        <div class="field_lable"><label for="desc">Description*</label></div>
                                        <div class="filed_input page_desc">
                                            <div class="add_page_desc float_right"></div>
                                            <textarea name="page_desc" placeholder="description" id="desc" class="filter_required mi_editor" data-errors="{filter_required:' Page description should not be blank.'}" ><?= $page_details[0]->description; ?></textarea>
                                        </div>
                                     </div>

                                    
                                    <div class="width6 float_right">
                                        
                                        <div class="field_row">
                                            <div class="field_lable"><label for="meta_title">Meta title*</label></div>
                                            <div class="filed_input"><input type="text" name="meta_title" placeholder="meta title" id="meta_title" class="filter_required" data-errors="{filter_required:' Page meta title should not be blank.'}" value="<?= $page_details[0]->meta_title; ?>"/></div>
                                        </div>  
                                        
                                        <div class="field_row">
                                            <div class="field_lable"><label for="meta_keywords">Meta keywords*</label></div>
                                            <div class="filed_input"><input type="text" name="meta_keywords" placeholder="meta keywords" id="meta_keywords" class="filter_required" data-errors="{filter_required:' Page meta keywords should not be blank.'}" value="<?= $page_details[0]->meta_keywords; ?>"/></div>
                                        </div>  
                             

                                        <div class="field_row">
                                            <div class="field_lable"><label for="meta_desc">Meta discription*</label></div>
                                            <div class="filed_input">
                                                <textarea name="meta_desc" placeholder="meta description" id="meta_desc" class="filter_required width6" data-errors="{filter_required:' Meta description should not be blank.'}"><?= $page_details[0]->meta_desc; ?></textarea>
                                            </div>
                                        </div>
                                </div>
                                

                            

                                <div class="sms_btn_div">
                                    <input type="button" value="Save Details" class="btn submit_btnt form-xhttp-request" data-href="{base_url}ms-admin/cms/add_pages" data-qr="output_position=content">
                                </div>
                            </form>
                        </div>
                        
                        
                        
                        
                        
                    </div>
                </div>
            </div>
