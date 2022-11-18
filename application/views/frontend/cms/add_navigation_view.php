<?php
    $CI = MS_Controller::get_instance();


?>
<div class="add_navigation_form">
            
                    <form method="post" method="post" enctype="multipart/form-data" id="ms_add_english_navigations">
                        <div class="width2 float_left">
                            <div class="row">
                               <div class="input_title">Navigation title*:</div>
                               <div class="input_field"><input type="text" name="nav_title" value="<?php if($navigation_details){ echo $navigation_details[0]->nav_tite;}?>" class="filter_required filter_string capital" data-activeerror="" data-errors="{filter_required:'Navigation title required',filter_string:'Special Charaters are not allowed!'}" placeholder="Navigation title"></div>
                           </div>
                           <div class="row">
                               <div class="input_title" style="width: 145px;">Navigation type:</div>
                                <div class="input_field"> 
                                    <select name="nav_type" class="filter_required" data-errors="{filter_required:'Navigation type should not be blank!'}">
                                        <option value="">Select type</option>
                                        <option value="dropdown" <?php if($navigation_details){ if($navigation_details[0]->nav_type == "dropdown"){ echo "Selected";  } } ?>>Dropdown</option>
                                        <option value="vertical" <?php if($navigation_details){ if($navigation_details[0]->nav_type == "vertical"){ echo "Selected";  } } ?>>Vertical</option>
                                        <option value="horizontal" <?php if($navigation_details){ if($navigation_details[0]->nav_type == "horizontal"){ echo "Selected";  } } ?>>Horizontal</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="width2 float_right">
                            <div class="row">
                                <div class="input_title">Navigation status:</div>
                                <div class="input_field"> 
                                    <?php @$status_selected [@$navigation_details[0]->nav_status] = 'selected="selected"';?>
                                    <select name="nav_status">
                                        <option value="active" <?php echo @$status_selected ['active'] ?> >Active</option>
                                        <option value="inactive" <?php  echo @$status_selected ['inactive'] ?>>Inactive</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">  
                                <input type="hidden" name="nav_id" value="<?= $navigation_id; ?>">
                                <input type="hidden" name="action" value="<?= $view; ?>">
                                <input type="button" name="submit_type" id="btnsave" value="Submit" class="btn submit_btn form-xhttp-request" data-href="{base_url}ms-admin/cms/add_navigation" data-qr="output_position=content">
                           </div>
                        </div>
                    </form>
                </div>
                
                
                
                
   