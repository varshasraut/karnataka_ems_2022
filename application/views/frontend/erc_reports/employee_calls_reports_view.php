<?php $CI = EMS_Controller::get_instance(); ?>
<!--<div class="head_outer"><h3 class="txt_clr2 width1">  <?php echo $report_name ?> </h3> </div>-->


<div class="width100">

    <form enctype="multipart/form-data"  action="<?php echo base_url(); ?>quality/<?php echo $submit_function; ?>" method="post">
        
        
        <div class="width30 float_left">

            <div class="filed_select">
                <div class="field_row drg float_left">
                    <div class="width100 float_left">
                        <div class="style6 float_left">Select System: </div>
                    </div>
                    <div class="width100 float_left" id="system_type_qualiy1">   
                    <select id="system" name="system"  class="" data-errors="{filter_required:'Team should not blank'}" TABINDEX="7"  <?php echo $view; ?>>

                                        <option value="">Select Team Type</option>
                                        <option value="UG-ERO-104">ERO 104</option>
                                        <option value="UG-ERO">ERO 108</option>
                                       
                                    </select>
                    </div>
                </div>
            </div>

        </div>
        <div class="width30 float_left">

            <div class="filed_select">
                <div class="field_row drg float_left">
                    <div class="width100 float_left">
                        <div class="style6 float_left">Select Name: </div>
                    </div>
                    <div class="width100 float_left" id="ero_list_outer_qality">   
                    <!-- <input name="user_id" class="mi_autocomplete " data-href="<?php //echo base_url(); ?>auto/get_eros_data" data-value="<?= $inc_emp_info[0]->user_id; ?>" value="<?= $inc_emp_info[0]->user_id; ?>" type="text" tabindex="1" placeholder="User ID"   id="emt_list" data-errors="{filter_required:'User ID should not be blank!'}" > -->
                    <select name="user_id" id="ero_list">
                    <option value="" >Select ERO</option>
                    <option value="" selected>All Clg</option>
                    
                    </select>
                    </div>
                </div>
            </div>

        </div>
        
        <div class="width30 float_left">

<div class="filed_select">
    <div class="field_row drg float_left">
        <div class="width100 float_left">
            <div class="style6 float_left">Select Report: </div>
        </div>
        <div class="width100 float_left" id="ero_list_outer_qality">   
        <!-- <input name="user_id" class="mi_autocomplete " data-href="<?php //echo base_url(); ?>auto/get_eros_data" data-value="<?= $inc_emp_info[0]->user_id; ?>" value="<?= $inc_emp_info[0]->user_id; ?>" type="text" tabindex="1" placeholder="User ID"   id="emt_list" data-errors="{filter_required:'User ID should not be blank!'}" > -->
        <select name="user_id" id="ero_list">
        <option value="" >Select Report</option>
        <option value="1">Monthwise</option>
        <option value="2">Datewise</option>
                                       
        
        </select>
        </div>
    </div>
</div>

</div>
        
                          

        
        
        <div class="width20 float_left" style="margin-top: 10px;">
        <div class="button_field_row">
                        <div class="button_box">
                            <input type="button" name="submit" value="Submit" data-qr="output_position=list_table&amp;reports=view&amp;module_name=reports&amp;showprocess=no" data-href="<?php echo base_url(); ?>quality_forms/<?php echo $submit_function; ?>" class="form-xhttp-request btn clg_search">
                        </div>
                    </div> 
    </form>
</div>


<!-- <iframe name="form_frame" style="height: 1px; width: 1px; border:0px; background: none;"></iframe>  -->
