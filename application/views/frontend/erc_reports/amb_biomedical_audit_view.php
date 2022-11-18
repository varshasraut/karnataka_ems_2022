<!--<form>-->
<?php $CI = EMS_Controller::get_instance(); ?>
<div class="head_outer"><h3 class="txt_clr2 width1">  <?php echo $report_name ?> </h3> </div>
<div class="width100">
    <form enctype="multipart/form-data"  action="<?php echo base_url(); ?>erc_reports/<?php echo $submit_function; ?>" method="post">

    
        <div class="field_row float_left width70">

            <div class="filed_select">
                <div class="width25 drg float_left">
                    <div class="width100 float_left">
                        <div class="style6 float_left">Select Ambulance: </div>
                    </div>
                    <div class="width100 float_left">
                      <select id="system" name="amb_no" class="filter_required change-xhttp-request" data-errors="{filter_required:'Ambulance should not blank'}" TABINDEX="7" data-href="{base_url}erc_reports/load_amb_audit_date" data-qr="output_position=content&amp;module_name=login_agents&amp;tlcode=MT-AGENTS-LOGIN-LIST" >

                            <option value="">Select Ambulance</option>
                            <?php if($ambulance){
                                $amb_no = array();
                               foreach($ambulance as $amb){
                                 
                                    if(!in_array( $amb->ambulance_no,$amb_no)){
                                     $amb_no[] = $amb->ambulance_no;
                                   ?>
                            <option value="<?php echo $amb->ambulance_no;?>"><?php echo $amb->ambulance_no;?></option>
                            <?php
                                    }
                               } 
                            }?>
                        </select>
                    </div>
                </div>
                <div class="width25 drg float_left">
                    <div class="width100 float_left">
                        <div class="style6 float_left">Select Audit Date: </div>
                    </div>
                    <div class="width100 float_left" id="audit_date_outer">
                       <select id="audit_date" name="audit_date" class="filter_required" data-errors="{filter_required:'Audit Date should not blank'}" TABINDEX="7" data-href="{base_url}erc_reports/load_amb_audit_date" data-qr="output_position=content&amp;module_name=reports" >

                            <option value="">Select Date</option>
                            <?php if($ambulance){
                             
                               foreach($ambulance as $amb_date){
                                  
                                   
                                   ?>
                            <option value="<?php echo $amb_date->current_audit_date;?>"><?php echo $amb_date->current_audit_date;?></option>
                            <?php
                               } 
                            }?>
                        </select>
                    </div>
                </div>
               

            </div>

        </div>
        <div class=" float_left" style="margin-top: 10px;">
            <div class="button_field_row">
                <div class="button_box">

<!--                    <input type="submit" name="submit" value="Submit" TABINDEX="3">  -->
                    <input type="button" name="submit"  value="Submit" data-qr="output_position=list_table&amp;reports=view&amp;module_name=reports&amp;showprocess=yes" data-href="<?php echo base_url(); ?>erc_reports/<?php echo $submit_function; ?>" class="form-xhttp-request btn clg_search float_left" >
                    
                </div>
            </div>
        </div>
    </form>
 </div>
 <div class="box3 width100">    

    <div class="permission_list group_list">

        <div id="list_table">


        </div>
    </div>
</div>
<!--</form>-->

<iframe name="form_frame" style="height: 1px; width: 1px; border:0px; background: none;"></iframe>
<script>;
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