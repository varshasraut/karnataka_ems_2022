
<div class="width100">
<form enctype="multipart/form-data"  action="<?php echo base_url(); ?>erc_reports/<?php echo $submit_function; ?>" method="post">

    <div class="field_row">

        <div class="filed_select">
            <div class="width50 drg float_left">
                <div class="width100 float_left">
                    <div class="style6 float_left">Select User: </div>
                </div>
                <div class="width100 float_left">
              
<input name="user_id" class="mi_autocomplete" data-href="<?php echo base_url();?>auto/get_auto_clg?clg_group=<?php echo $department_name; ?>"  data-value="<?php echo $stud_sickroom[0]->qa_name ;?>" value="<?php echo $stud_sickroom[0]->qa_name ;?>" type="text" tabindex="2" placeholder="User Name">
                </div>
            </div>

        </div>


    </div>
     <div class="width_20 float_left" style="margin-top: 10px;">
        <div class="button_field_row">
            <div class="button_box">

                    <!-- <input type="submit" name="submit" value="Submit" TABINDEX="3">   -->
                <input type="button" name="submit"  value="Submit" data-qr="output_position=list_table&amp;reports=view&amp;module_name=reports&amp;showprocess=no" data-href="<?php echo base_url(); ?>erc_reports/<?php echo $submit_function; ?>" class="form-xhttp-request btn clg_search" >
            </div>
        </div>
    </div>
    </form>
</div> 
<iframe name="form_frame" style="height: 1px; width: 1px; border:0px; background: none;"></iframe>