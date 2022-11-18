<?php $CI = EMS_Controller::get_instance(); ?>
<!--<div class="head_outer"><h3 class="txt_clr2 width1">  <?php echo $report_name ?> </h3> </div>-->


<div class="width100">

    <form enctype="multipart/form-data"  action="<?php echo base_url(); ?>quality/<?php echo $submit_function; ?>" method="post">
        
        <div class="width8 float_left">

            <div class="filed_select">
                <div class="field_row drg float_left">
                    <div class="width100 float_left">
                        <div class="style6 float_left">Select SM: </div>
                    </div>
                    <div class="width100 float_left">  
                    <select name="shiftmanager" id="sm_list">
                    <option value="" selected>Select Shiftmanager</option>
                    <option value="all_sm">All SM</option>
                    <?php foreach($sm as $new) { ?>
                            <option value="<?php echo $new->clg_ref_id; ?>"><?php echo $new->clg_first_name." ".$new->clg_last_name; ?></option>
                        <?php }?>
                    </select>
                    </div>
                </div>
            </div>

        </div>
        <div class="width8 float_left">

            <div class="filed_select">
                <div class=" drg float_left">
                    <div class="width100 float_left">
                        <div class="style6 float_left">Select TL: </div>
                    </div>
                    <div class="width100 float_left" id="tl_outer">  
                    <!-- <input name="tl_name" id="tl_list" class="mi_autocomplete "  type="text" tabindex="1" placeholder="TL"    data-errors="{filter_required:'User ID should not be blank!'}" > -->
                    <select name="tl_name" id="tl_list">
                    <!-- <option value="" >Select TL</option> -->
                    <option value="all_tl" selected>All TL</option>
                    
                    </select>
                    </div>
                </div>
            </div>

        </div>
        <div class="width8 float_left">

            <div class="filed_select">
                <div class="field_row drg float_left">
                    <div class="width100 float_left">
                        <div class="style6 float_left">Select System: </div>
                    </div>
                    <div class="width100 float_left" id="system_type_quality">   
                    <select id="system_type" name="system_type"  class="" data-errors="{filter_required:'Team should not blank'}" TABINDEX="7"  <?php echo $view; ?>>

                                        <option value="">Select Team Type</option>
                                        <option value="all">All</option>
                                        <!--<option value="UG-ERO-102">ERO 102</option>-->
                                        <option value="UG-ERO">ERO 108</option>
                                        <option value="UG-ERO-104">UG-ERO-104</option>                            
                                    </select>
                    </div>
                </div>
            </div>

        </div>
        <div class="width8 float_left">

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
        <div class="width10 float_left">

            <div class="filed_select">
                <div class="field_row drg float_left">
                    <div class="width100 float_left">
                        <div class="style6 float_left">Select Call types: </div>
                    </div>
   
                    
                        <select name="call_type" class="change-base-xhttp-request" data-base="report_type"> <!-- data-href="{base_url}erc_reports/load_incident_subreport_form" data-qr="output_position=content"> -->
                        <option value="all">All Call Types</option>
                        <?php foreach($purpose_calls as $new) { ?>
                            <option value="<?php echo $new->pcode; ?>"><?php echo $new->pname; ?></option>
                        <?php }?>
                        </select>
                  
                </div>
            </div>
        </div>
        <div class="width8 float_left">

        <div class="width100 form_field ">
                    <div class="width100 float_left">         
                        <div class="width100 label blue float_left strong">TNA:&nbsp;</div>
                        <div class="width100 float_left">
                            <select id="group" name="tna"  class="" data-errors="{filter_required:'TNA should not blank'}" TABINDEX="7">
                                <option  value="">Select TNA</option>
                                <option  value="" selected>All TNA</option>
                                <option value="communication skill" <?php
                                if ($audit_details[0]->tna == 'communication skill') {
                                    echo "selected";
                                }
                                ?>>Communication Skill</option>
                                <option value="soft skills" <?php
                                if ($audit_details[0]->tna == 'soft skills') {
                                    echo "selected";
                                }
                                ?>>Soft Skills</option>
                                <option value="call handling skill"  <?php
                                if ($audit_details[0]->tna == 'call handling skill') {
                                    echo "selected";
                                }
                                ?>>Call Handling Skill</option>
                                <option value="process knowledge"  <?php
                                if ($audit_details[0]->tna == 'process knowledge') {
                                    echo "selected";
                                }
                                ?>>Process Knowledge</option>
                                <option value="avaya handling"  <?php
                                if ($audit_details[0]->tna == 'avaya handling') {
                                    echo "selected";
                                }
                                ?>>Ameyo Handling</option>
                                <option value="system navigation"  <?php
                                if ($audit_details[0]->tna == 'system navigation') {
                                    echo "selected";
                                }
                                ?>>System Navigation</option>
                                <option value="probing skill"  <?php
                                if ($audit_details[0]->tna == 'probing skill') {
                                    echo "selected";
                                }
                                ?>>Probing Skills</option>
                                <option value="Remark Writings"  <?php
                                if ($audit_details[0]->tna == 'Remark Writings') {
                                    echo "selected";
                                }
                                ?>>Remark Writings</option>
                            </select>
                        </div>
                    </div>
        </div>
        </div>
        
        <div class="width8 float_left">

            <div class="width100 form_field ">
                    <div class="width100 float_left">         
                        <div class="width100 label blue strong">Fatal Error:&nbsp;</div>
                        <div class="width100 float_left">
                            <select id="fatal_group" name="fatal_error_indicator"  class="" data-errors="{filter_required:'Team should not blank'}" TABINDEX="7" >


                                <option  value="">Select</option>
                                <option  value="" selected>All Fatal Error</option>
                                <option value="Verbiages" <?php
                                if ($audit_details[0]->fetal_error_indicator == 'Verbiages') {
                                    echo "selected";
                                }
                                ?>>Verbiages</option>
                                <option value="Procedures" <?php
                                if ($audit_details[0]->fetal_error_indicator == 'Procedures') {
                                    echo "selected";
                                }
                                ?>>Procedures</option>
                                <option value="Information Validations" <?php
                                if ($audit_details[0]->fetal_error_indicator == 'Information Validations') {
                                    echo "selected";
                                }
                                ?>>Information Validations</option>
                                <option value="Tagging" <?php
                                if ($audit_details[0]->fetal_error_indicator == 'Tagging') {
                                    echo "selected";
                                }
                                ?>>Tagging</option>
                                <option value="Incomplete information" <?php
                                if ($audit_details[0]->fetal_error_indicator == 'Incomplete information') {
                                    echo "selected";
                                }
                                ?>>Incomplete information</option>
                                <option value="Behavioral" <?php
                                if ($audit_details[0]->fetal_error_indicator == 'Behavioral') {
                                    echo "selected";
                                }
                                ?>>Behavioral</option>
                                <option value="Incorrect Information" <?php
                                if ($audit_details[0]->fetal_error_indicator == 'Incorrect Information') {
                                    echo "selected";
                                }
                                ?>>Incorrect Information</option>
                                <option value="other" <?php
                                if ($audit_details[0]->fetal_error_indicator == 'other') {
                                    echo "selected";
                                }
                                ?>>Other</option>
                            </select>
                        </div>
                    </div>
                    </div>
                    </div>
                    <div class="width8 float_left">
                        <div  id='other_fatal_indicator'>

                            <?php
                           
                            if ($audit_details[0]->other_fatal_error_inc != '' && $audit_details[0]->other_fatal_error_inc != NULL) {
                                ?>
                                <div class="style6 float_left width100">Other Fatal Error</div>

                                <div class="width100  float_left">
                                    <input name="other_fatal_inc_error" class="" value="<?php echo $audit_details[0]->other_fatal_error_inc; ?>" type="text" tabindex="2" placeholder="Fatal Indicator Error" data-errors="{filter_required:'Fatal Indicator Error should not be blank!'}">
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                    
        

            <div class=" width10 float_left">
                <div class="width50 drg float_left">
                    <div class="width100 float_left">
                        <div class="style6 float_left">From: </div>
                    </div>
                    <div class="width100 float_left">
                        <input name="from_date" tabindex="1" class="form_input" placeholder="From Date" type="text" data-base="search_btn" data-errors="{filter_required:'From Date should not be blank!',filter_time_hm:'Please enter valid time(H:i)'}" value="" readonly="readonly" id="from_date">
                    </div>
                </div>
                <div class="width50 drg float_left">
                    <div class="width100 float_left">
                        <div class="style6 float_left">To : </div>
                    </div>
                    <div class="width100 float_left">
                        <input name="to_date" tabindex="2" class="form_input " placeholder="To Date" type="text" data-base="search_btn" data-errors="{filter_required:'To Date should not be blank!',filter_time_hm:'Please enter valid time(H:i)'}" value="" readonly="readonly" id="to_date">
                    </div>
                </div>
</div>
        <div class=" width10 float_left">
                <div class="width100 drg float_left">
                    <div class="width100 float_left">
                        <div class="style6 float_left">Select Month: </div>
                    </div>
                    <div class="width100 float_left" >

                        <select name="month_date" class="" data-errors="{filter_required:'Month should not be blank!'}">
                            <option value="">Select Month</option>
                            <?php
                            for ($i = 0; $i <= 20; $i++) {
                                $current_date = time();
                                $month = date('M Y', strtotime('-' . $i . ' Months', $current_date));
                                $month_value = date('Y-m-01', strtotime('-' . $i . ' Months', $current_date));

                                echo '<option value="' . $month_value . '">' . $month . '</option>';
                            }
                            ?>

                        </select>
                    </div>
                </div>
            </div>
<!--                <div class=" width10 float_left">
                <div class="width100 drg float_left">
                    <div class="width100 float_left">
                        <div class="style6 float_left">Shift: </div>
                    </div>
                    <div class="width100 float_left">
                    <select id="shift" name="shift"  class="" data-errors="{filter_required:'Team should not blank'}" TABINDEX="7"  >

                  <option value="">Select Shift</option>
                     <option value="M">Morning</option>
                      <option value="E">Afternoon</option>
                      <option value="N">Night</option>
                      <option value="OFF">Off</option>
                      <option value="G">General</option>

</select>                    </div>
                </div>
                </div>-->
           

            

       <!-- <div class="width100 float_left">
            <div id="Sub_report_block_fields" style="">
            </div>
        </div>
        <div class="width100 ">
            <div id="Sub_date_report_block_fields" style="">
            </div>
        </div> -->
        
        
       
        <div class=" float_left" style="margin-top: 10px;">
        <div class="button_field_row">
                        <div class="button_box">
                             <input type="button" name="submit" value="Submit" data-qr="output_position=list_table&amp;reports=view&amp;module_name=reports&amp;showprocess=no" data-href="<?php echo base_url(); ?>quality_forms/<?php echo $submit_function; ?>" class="form-xhttp-request btn clg_search float_left">
                            <?php if( $submit_function == 'view_quality_master_report'){ ?>
                                <input type="reset" class="search_button float_left form-xhttp-request" name="" value="Reset Filter" data-href="{base_url}quality_forms/quality_filter_report" data-qr="output_position=content&amp;flt=reset&reports=view&form_type=quality_master_report" />
                            <?php } ?>
                        </div>
                    </div> 
    </form>
</div>


<!-- <iframe name="form_frame" style="height: 1px; width: 1px; border:0px; background: none;"></iframe>  -->
<script>
    jQuery(document).ready(function () {

        var dateFormat = "mm/dd/yy",
                from = jQuery("#from_date")
                .datepicker({
                    defaultDate: new Date(),
                    changeMonth: true,
                    changeYear: true,
                    numberOfMonths: 1
                })
                .on("change", function () {
                    to.datepicker("option", "minDate", getDate(this));
                }),
                to = jQuery("#to_date").datepicker({
            defaultDate:  new Date(),
            changeMonth: true,
            changeYear: true,
            numberOfMonths: 1
        })
                .on("change", function () {
                    from.datepicker("option", "maxDate", getDate(this));
                });

        function getDate(element) {
            var date;
            try {
                date = $.datepicker.parseDate(dateFormat, element.value);
            } catch (error) {
                date = null;
            }
            return date;
        }
    });

</script>