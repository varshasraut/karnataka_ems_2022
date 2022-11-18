<?php
    $CI = MS_Controller::get_instance();
    $link_users = explode(",", str_replace("'", "", $link_details[0]->lnk_for_users));
?>

<div class="breadcrumb">
    <ul>
        <li class="goods">
            <a href="">Cms and Widgets</a>
        </li>
        <li>
            <span>Add Links For <?= ucwords($nav_details[0]->nav_tite); ?> </span>
        </li>
    </ul>
</div>
<br/>
<div class="box3">
    <div class="permission_list group_list">
        <div id="ms_cms_add_page_container">
       
                            <h3 class="txt_clr5">Add Links For <?= ucwords($nav_details[0]->nav_tite); ?></h3>
                            <form method="post" method="post" enctype="multipart/form-data" id="ms_add_navigation_links">
                                <input type="hidden" name="save_details" value="yes"/>
                                <input type="hidden" name="nav_id" value="<?= $navigation_id ?>"/>
                                <input type="hidden" name="lnk_id" value="<?= $link_id ?>"/>
                                <div class="navigation_link_details">
                                    <h4 class="txt_clr2">Link Details:</h4>
                                    <div class="width2 float_left">
                                        <div class="field_row">
                                            <div class="field_lable"><label for="gname">Link Name*:</label></div>
                                            <div class="filed_input">
                                               <input type="text" name="link_name" class="filter_required filter_string capital" data-errors="{filter_required:'Link name should not be blank!',filter_string:'Special Charaters are not allowed!'}" placeholder="link name" value="<?= $link_details[0]->lnk_name; ?>">
                                            </div>
                                        </div>
                                        <div class="field_row" id="ms_link_slug">
                                           <div class="field_lable"><label for="gname">Link Slug*:</label></div>
                                            <div class="filed_input">
                                                <input type="text" placeholder="link slug" readonly="" value="<?= $link_details[0]->lnk_slug; ?>">
                                           </div>
                                        </div>
                                        <div class="field_row" id="ms_link_section_row">
                                           <div class="field_lable"><label for="gname">Link Section*:</label></div>
                                            <div class="filed_input">
                                                <select disabled="">
                                                    <option value="">Select link section</option>
                                                </select>
                                            </div>
                                        </div>
                                    

                                        <div class="field_row">
                                            <div class="field_lable"><label for="gname">Link Format:</label></div>
                                            <div class="filed_input">
                                                <select disabled="">
                                                    <option value="external_link">External Link</option>
                                                    <option value="internal_link">Internal Link</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="width2 float_right">
                                        <div class="field_row">
                                           <div class="field_lable"><label for="gname">Link Type*:</label></div>
                                            <div class="filed_input">
                                                <select disabled="">
                                                    <option value="">Select link type</option>
                                                    <option value="http">http</option>
                                                    <option value="httpajax">httpajax</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="field_row" id="ms_link_url_row">
                                            <div class="field_lable"><label for="gname">Link Url*:</label></div>
                                            <div class="filed_input">
                                                <input type="text" placeholder="link url" readonly="" value="<?= $link_details[0]->lnk_url; ?>">
                                            </div>
                                        </div>
                                        <div class="field_row">
                                            <div class="field_lable"><label for="gname">Link Query String:</label></div>
                                            <div class="filed_input">
                                                <input type="text" placeholder="link query string" readonly="" value="<?= $link_details[0]->lnk_url; ?>">
                                            </div>
                                        </div>
                                        <div class="field_row">
                                            <div class="field_lable"><label for="gname">Link User Type*:</label></div>
                                            <div class="filed_input">
                                                <select name="link_user_type[]" class="multiple_select filter_required" data-errors="{filter_required:'Link user type should not be blank!'}" multiple="multiple">
                                                    <option value="seller" <?php if(in_array("Support",$link_users)): ?> selected="selected"<?php endif; ?>>
                                                        Support
                                                    </option>
                                                    <option value="buyer"<?php if(in_array("Sales",$link_users)): ?> selected="selected"<?php endif; ?>>Sales</option>
                                                </select>
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
                                                <input type="text" placeholder="link meta title" readonly="" >
                                           </div>
                                        </div>
                                        <div class="field_row">
                                           <div class="field_lable"><label for="gname">Link Meta Description*:</label></div>
                                            <div class="filed_input">
                                                <input type="text" placeholder="link meta description" readonly="">
                                           </div>
                                        </div>
                                    </div>
                                    <div class="width2 float_right">
                                        <div class="field_row">
                                            <div class="field_lable"><label for="gname">Link Meta Keywords*:</label></div>
                                            <div class="filed_input">
                                                <input type="text" placeholder="link meta keywords" readonly="">
                                           </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="field_row cms_btn_container">  
                                    <input type="button" name="add_links" value="Submit" class="btn submit_btn form-xhttp-request" data-href="{base_url}ms-admin/cms/update_navigation_links" data-qr="output_position=content">
                                </div>
                            </form>
                        </div>
                        
                    </div>
                </div>
            </div>
            
            
            
            <div id="ms_navigation_link_other_section" style="display: none;">
                <div class="filed_input other_link_section">
                    <input type="text" name="link_section" placeholder="link section" class="filter_required" data-errors="{filter_required:'Link section should not be blank!'}">
                </div>
            </div>
        </div>
    </div>
</div>

