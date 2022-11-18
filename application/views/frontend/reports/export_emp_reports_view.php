
<!--<h2>Export <?php echo $report_name; ?> Details</h2> -->
<div class="width100 float_left width69">
    <form enctype="multipart/form-data"  method="post" >
        <div class="field_row float_left width50">

            <div class="filed_select">
                <div class="width100 drg float_left">
                    <div class="width100 float_left">
                        <div class="style6 float_left">Select Month: </div>
                    </div>
                    <div class="width100 float_left" >

                    <select id="team_type" name="team_type"  class="filter_required" data-errors="{filter_required:'Team should not blank'}" TABINDEX="7"  <?php echo $view; ?>>
                                        <option value="">Select Team Type</option>
                                         <option value="UG-ERO">ERO-108</option>
                                        <option value="UG-ERO-102">ERO-102</option>
                                        <option value="UG-DCO">DCO-108</option>
                                        <option value="UG-DCO-102">DCO-102</option>
                                        <option value="UG-ERCP">ERCP</option>
                                        <option value="UG-GRIVIANCE">GRIEVANCE</option>
                                        <option value="UG-FEEDBACK">FEEDBACK</option>
                                        <option value="UG-FDA">FIRE</option>
                                        <option value="UG-PDA">POLICE</option>
                                        <option value="UG-Quality">Quality</option> 
                                        <option value="UG-QualityManager">Quality Manager</option> 
                                         </select>
                    </div>
                </div>
            </div>

        </div>
        <div class="width_25 float_left" style="margin-top: 10px;">
            <div class="button_field_row">
                <div class="button_box">
                <input type="button" name="submit" value="Submit" data-qr="output_position=list_table&amp;reports=view&amp;module_name=reports&amp;showprocess=no" data-href="<?php echo base_url(); ?>reports/<?php echo $submit_function; ?>" class="form-xhttp-request btn clg_search">
                </div>
            </div>
        </div>
    </form>
</div>
<div class="box3">    

    <div class="permission_list group_list">

        <div id="list_table" >


        </div>
    </div>
</div>
<!-- <div class="width100">
 
        <div class="field_row">
            <div class="filed_select">  
            
            </div>
        
        <div class="width_25 margin_auto">
            <div class="button_field_row">
                <div class="button_box">

                    <input type="button" name="submit"  value="Submit" data-qr="output_position=list_table&amp;reports=view&amp;module_name=reports&amp;showprocess=no" data-href="<?php echo base_url(); ?>reports/export_emp_report" class="form-xhttp-request btn clg_search" >
                </div>
            </div>
        </div>

</div></div>
<iframe name="form_frame" style="height: 1px; width: 1px; border:0px; background: none;"></iframe> -->