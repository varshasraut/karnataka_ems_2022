<?php
$CI = EMS_Controller::get_instance();
?>

<div class="msg"><?php echo $res; ?></div>
<div class="breadcrumb float_left">
    <ul>

        <li><span>Cross Audit</span></li>
    </ul>
</div>

<br>

<div class="box3">    

    <div class="permission_list group_list">

        <form method="post" action="#" name="quality_forms" class="quality_forms">  

            <div id="clg_filters">

                <div class="filters_groups">                   

                    <div class="search">
                        <div class="row list_actions clg_filt">

                            <div class="search_btn_width">
                                
                                <div class="filed_input float_left width_20">
                                    <div class="width100 float_left">
                                        <div class="style6 float_left">QA Name: </div>
                                    </div>
                                      <input name="qa_name" class="mi_autocomplete" data-href="<?php echo base_url();?>auto/get_auto_clg?clg_group=UG-Quality"  data-value="<?php echo $stud_sickroom[0]->qa_name ;?>" value="<?php echo $stud_sickroom[0]->qa_name ;?>" type="text" tabindex="2" placeholder="QA Name">
                                </div>    
                              
                                <div class="width_20 drg float_left">
                                    <div class="width100 float_left">
                                        <div class="style6 float_left">From: </div>
                                    </div>
                                    <div class="width100 float_left">
                                        <input name="from_date" tabindex="1" class="form_input filter_required" placeholder="From Date" type="text" data-base="search_btn" data-errors="{filter_required:'From Date should not be blank!',filter_time_hm:'Please enter valid time(H:i)'}" value="" readonly="readonly" id="from_date">
                                    </div>
                                </div>
                                <div class="width_20 drg float_left">
                                    <div class="width100 float_left">
                                        <div class="style6 float_left">To: </div>
                                    </div>
                                    <div class="width100 float_left">
                                        <input name="to_date" tabindex="2" class="form_input filter_required" placeholder="To Date" type="text" data-base="search_btn" data-errors="{filter_required:'To Date should not be blank!',filter_time_hm:'Please enter valid time(H:i)'}" value="" readonly="readonly" id="to_date">
                                    </div>
                                </div>


                                <div class="filed_input float_left width_30">  
                                   <div class="width100 float_left">
                                       <div class="style6 float_left">&nbsp;&nbsp;</div>
                                    </div>
                                    <div class="width80 float_left">
                                        <input type="button" name="search_btn" value="Search" class="btn clg_search form-xhttp-request float_left mt-0" data-href="{base_url}quality_forms/cross_audit_inc_list" data-qr="output_position=content&amp;filter_search=search&amp;module_name=clg&amp;tlcode=MT-CLG-ACTION-MULTI&amp;action_name=search_clgs" style="float:left !important;" >
                                        <input class="search_button click-xhttp-request float_right mt-0" name="" value="Reset Filters" data-href="{base_url}quality_forms/cross_audit" data-qr="filters=reset" type="button">

                                    </div>
                                   
                                </div>
                            </div>


                        </div>


                    </div>

                </div>

            </div>
        </form>
            <div id="list_table">



            </div>
        
    </div>
</div>
<script>;
    jQuery(document).ready(function () {

        var dateFormat = "mm/dd/yy",
                from = jQuery("#from_date")
                .datepicker({
                    defaultDate:  new Date(),
                    changeMonth: true,
                    numberOfMonths: 2
                })
                .on("change", function () {
                    to.datepicker("option", "minDate", getDate(this));
                }),
                to = jQuery("#to_date").datepicker({
            defaultDate:  new Date(),
            changeMonth: true,
            numberOfMonths: 2
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