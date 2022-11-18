<?php
    $CI = EMS_Controller::get_instance();
     
    $link_users = explode(",", str_replace("'", "", $link_details[0]->lnk_for_users));
    
    $link_format = explode(",", str_replace("'", "", $link_details[0]->lnk_format));
    
    $link_type = explode(",", str_replace("'", "", $link_details[0]->lnk_type));
    
    $link_section = explode(",", str_replace("'", "", $link_details[0]->lnk_section));
    
?>

<div class="breadcrumb">
    <ul>
        <li class="goods">
            <a href="{base_url}ms-admin/cms/manage_navigation">Cms and Widgets</a>
        </li>
        <li class="">
            <a href="{base_url}ms-admin/cms/manage_navigation">Manage navigation</a>
        </li>
        <li>
            <span><?php if(!$link_details) { ?>Add <?php } else{ ?> Edit <?php } ?> Links For <?php echo @$nav_title; ?> </span>
        </li>
    </ul>
</div>
<br>
<div class="box3">
    <div class="permission_list group_list">
        <div id="ms_cms_add_page_container">
            <div class="register_block">
            <h3 class="txt_clr5"><?php if(!$link_details) { ?> Add <?php } else{ ?> Edit <?php } ?> Links</h3>
            <form method="post" method="post" enctype="multipart/form-data" id="medistore_add_navigation_links">
                <input type="hidden" name="add_navigation_links" value="true"/>
                <input type="hidden" name="nav_id" value="<?= $navigation_id ?>"/>
                
                  <input type="hidden" name="save_details" value="yes"/>
                  <input type="hidden" name="nav_id" value="<?= $navigation_id ?>"/>
                  <input type="hidden" name="lnk_id" value="<?= $link_id ?>"/>
                
                
                <div class="navigation_link_details">
                    <h4 class="txt_clr2">Link Details:</h4>
                    <div class="width2 float_left">
                         <div class="field_row">
                            <div class="field_lable"><label for="gname">Link Format:</label></div>
                            <div class="filed_input">
                                <select id="navigation_link_format" name="link_format">
                                    
                                    <option value="external_link" <?php if(in_array("external_link",$link_format)): ?> selected="selected"<?php endif; ?>>External Link</option>
                                    
                                    <option value="internal_link" <?php if(in_array("internal_link",$link_format)): ?> selected="selected"<?php endif; ?>>Internal Link</option>
                                    
                                </select>
                            </div>
                        </div>
                    
                        <div class="field_row">
                            <div class="field_lable"><label for="gname">Link Name*:</label></div>
                            <div class="filed_input">
                               <input type="text" name="link_name" class="filter_required filter_string capital" data-errors="{filter_required:'Link name should not be blank!',filter_string:'Special Charaters are not allowed!'}" placeholder="Link name" value="<?php if( $link_details[0]->lnk_name){ echo $link_details[0]->lnk_name;} ?>">
                            </div>
                        </div>
                        <div class="field_row" id="ms_link_slug">
                           <div class="field_lable"><label for="gname">Link Slug*:</label></div>
                            <div class="filed_input">
                               <input type="text" name="link_slug" class="filter_required" data-errors="{filter_required:'Link slug should not be blank!'}" placeholder="link slug" value="<?php if( $link_details[0]->lnk_slug){ echo $link_details[0]->lnk_slug; } ?>">
                           </div>
                        </div>
                        <div class="field_row" id="ms_link_page" style="display: none;">
                           <div class="field_lable"><label for="gname">Link page*:</label></div>
                            <div class="filed_input">
                                <select>
                                    <option value="">Select link page</option>
                                    <?php foreach($page_list as $page): ?>
                                        <option value="<?= $page->title." ".$page->id; ?>">
                                            <?= ucwords($page->title); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                           </div>
                        </div>
                        <div class="field_row" id="ms_link_section_row">
                           <div class="field_lable"><label for="gname">Link Section*:</label></div>
                            <div class="filed_input">
                                <select name="link_section" class="filter_required" data-errors="{filter_required:'Link section should not be blank!'}" id="link_section_select_box">
                                    <option value="" class="sec">Select link section</option>
                                    <?php foreach($link_sections as $section): ?>
                                    
                                    
                                        <option value="<?= $section; ?>" class="sec" <?php if(in_array($section,$link_section)): ?> selected="selected"<?php endif; ?>> <?= ucwords($section); ?></option>
                                        
                                        
                                        
                                    <?php endforeach; ?>
                                    <option value="ede" id="other_section">Other section</option>
                                </select>
                            </div>
                        </div>
                        
                        
                        
                        <div id="ms_navigation_link_other_section">
                            <div class="filed_input other_link_section" id="other_section_text_box">
                               
                            </div>
                        </div>
                        
                        
              
                        
                        
                         <div class="field_row" id="">
                            <div class="field_lable"><label for="lnk-parent">Link parent:</label></div>
                            <div class="filed_input">
                               <input type="text" name="link_parent" class="" data-errors="" placeholder="link url" value="<?php if($link_details[0]->lnk_parent){ echo $link_details[0]->lnk_parent; } ?>">
                            </div>
                        </div>
                 
                        
                        
                    </div>

                    <div class="width2 float_right">
                        <div class="field_row">
                           <div class="field_lable"><label for="gname">Link Type*:</label></div>
                            <div class="filed_input">
                                <select name="link_type" class="filter_required" data-errors="{filter_required:'Link type should not be blank!'}">
                                    <option value="">Select link type</option>
                                    <option value="http" <?php if(in_array("http",$link_type)): ?> selected="selected"<?php endif; ?>>http</option>
                                    <option value="httpajax" <?php if(in_array("httpajax",$link_type)): ?> selected="selected"<?php endif; ?>>httpajax</option>
                                </select>
                            </div>
                        </div>
                        <div class="field_row" id="ms_link_url_row">
                            <div class="field_lable"><label for="gname">Link Url*:</label></div>
                            <div class="filed_input">
                               <input type="text" name="link_url" class="filter_required" data-errors="{filter_required:'Link url should not be blank!'}" placeholder="link url" value="<?php if($link_details[0]->lnk_url){ echo $link_details[0]->lnk_url; } ?>">
                            </div>
                        </div>
                        
                        <div class="field_row">
                            <div class="field_lable"><label for="gname">Link Query String:</label></div>
                            <div class="filed_input">
                               <input type="text" name="link_query_string" placeholder="link query string" value="<?php if($link_details[0]->lnk_query_string){ echo $link_details[0]->lnk_query_string; } ?>">
                            </div>
                        </div>
                        
                        <div class="field_row">
                            <div class="field_lable"><label for="gname">Link User Type*:</label></div>
                            <div class="input_field">
                                <select name="link_user_type[]" class="multiple_select filter_required" data-errors="{filter_required:'Link user type should not be blank!'}" multiple="multiple">
                                    
                                    <option value="Pharmasist" <?php if(in_array("Pharmasist",$link_users)): ?> selected="selected"<?php endif; ?>>Pharmasist</option>
                                    
                                    <option value="Advertiser" <?php if(in_array("Advertiser",$link_users)): ?> selected="selected"<?php endif; ?>>Advertiser</option>
                                         
                                    <option value="User" <?php if(in_array("User",$link_users)): ?> selected="selected"<?php endif; ?>>User</option>
                                    <option value="End_user" <?php if(in_array("End_user",$link_users)): ?> selected="selected"<?php endif; ?>>End User</option>
                                    
                                </select>
                            </div>
                       </div>
                        
                        
                        <div class="field_row" id="">
                            <div class="field_lable"><label for="lnk-parent">Is dropdown :</label>
                            
                               <input type="checkbox" name="is_dropdown[]" value="yes" <?php if($link_details[0]->is_dropdown=="yes"){ echo "checked";}?>>
                            </div>
                        </div>
                    </div>
                </div>
                
         
                <div class="navigation_link_seo_details">
                    <h4 class="txt_clr2">SEO Details:</h4>
                    <div class="width2 float_left">
                        <div class="field_row">
                            <div class="field_lable"><label for="gname">Link Meta Title*:</label></div>
                            <div class="filed_input">
                               <input type="text" name="link_meta_title" class="filter_required" data-errors="{filter_required:'Link meta title should not be blank!'}" placeholder="link meta title" value="<?php if( $link_details[0]->lnk_meta_title){ echo $link_details[0]->lnk_meta_title; }?>">
                           </div>
                        </div>
                        <div class="field_row">
                           <div class="field_lable"><label for="gname">Link Meta Description*:</label></div>
                            <div class="filed_input">
                               <input type="text" name="link_meta_desc" class="filter_required" data-errors="{filter_required:'Link meta description should not be blank!'}" placeholder="link meta description" value="<?php if( $link_details[0]->lnk_meta_description){ echo $link_details[0]->lnk_meta_description; }?>">
                           </div>
                        </div>
                    </div>
                    <div class="width2 float_right">
                        <div class="field_row">
                            <div class="field_lable"><label for="gname">Link Meta Keywords*:</label></div>
                            <div class="filed_input">
                               <input type="text" name="link_meta_keywords" class="filter_required" data-errors="{filter_required:'Link meta keywords should not be blank!'}" placeholder="link meta keywords" value="<?php if( $link_details[0]->lnk_meta_keywords){ echo $link_details[0]->lnk_meta_keywords; }?>">
                           </div>
                        </div>
                    </div>
                </div>
                
                <div class="width6">
                <div class="button_field_row">  
                    <div class="button_box">
                    <input type="button" name="add_links" value="Submit" class="btn submit_btn form-xhttp-request" data-href="{base_url}ms-admin/cms/<?php if(@$update_nav_links!=''){ echo 'update_navigation_links'; }else{ echo 'add_navigation_links'; } ?>" data-qr="output_position=content<?php if(@$update_nav_links!=''):?>&save_details=yes<?php endif;?>">
                    </div>
                    <input name="reset" value="Reset" class="btn reset_btn register_view_reset" tabindex="24" type="reset">
                </div>
                </div>
            </form>
            </div>
        </div>
    </div>
</div>

