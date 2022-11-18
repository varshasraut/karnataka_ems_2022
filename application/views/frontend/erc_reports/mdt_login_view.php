<?php $CI = EMS_Controller::get_instance(); ?>
<div class="head_outer">
    <h3 class="txt_clr2 width1"> <?php echo $report_name ?> </h3>
</div>
<div class="width100">

    <form action="<?php echo base_url(); ?>master_report/mdt_login_report_view" method="post" enctype="multipart/form-data"
        target="form_frame">
        <div class="field_row float_left width100">

            <!-- <div class="filed_select">
                <div class="width100 drg float_left">
                    <div class="width100 float_left">
                        <div class="style6 float_left">From Date: </div>
                    </div>
                    <div class="width100 float_left">
                        <input name="from_date" tabindex="20" class="form_input  filter_required" placeholder="Date"
                            type="text" data-errors="{filter_required:'Date should not be blank!'}" id="from_date">
                    </div>
                </div>
            </div> -->

           <!-- <div class="field_row float_left width_20">

            <div class="filed_select">
                <div class="width100 drg float_left">
                    <div class="width100 float_left">
                        <div class="style6 float_left">To Date: </div>
                    </div>
                    <div class="width100 float_left">
                        <input name="to_date" tabindex="20" class="form_input filter_required" placeholder="Date"
                            type="text" data-errors="{filter_required:'Date should not be blank!'}" id="to_date">
                    </div>
                </div>
            </div>

        </div> -->
        <?php if($clg_group == "UG-DM" || $clg_group == "UG-ZM" ) {?>
        
            <div class="filed_select width30">
                <div class="field_row drg float_left">
                    <div class="width80 float_left">
                        <div class="style6 float_left">Select User : </div>
                    </div>
                    <div class="width50 float_left">  
                        <select name="login_type"  class="">
                            
                            <option value="">All</option>
                            <?php if($clg_group != "UG-NHM"){ ?>
                            <option value="P">EMT</option>
                            <option value="D">Pilot</option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
            </div>
     <?php } else {?>
        <div class="width_10 drg float_left">
                <div class="width100 float_left">
                    <div class="style6 float_left">Select Zonewise : </div>
                </div>
                <div class="width100 float_left">  
                    <select name="mdt_login" id="divs"  class="change-base-xhttp-request" data-base='mdt_login_report_view'  >
                    <option value="All">All</option>
                        <?php foreach($zones as $dvs){ ?>  
                        <option value="<?php echo $dvs->div_code; ?>"><?php echo $dvs->div_name;?></option>
                        <?php }?>
                    </select>
                </div>
        </div> 
        <div class="filed_select width30" >
                <div class="field_row drg float_left" style="margin-left:20px;">
                    <div class="width80 float_left">
                        <div class="style6 float_left">Select User : </div>
                    </div>
                    <div class="width50 float_left">  
                        <select name="login_type"  class="">
                            
                            <option value="">All</option>
                            <?php if($clg_group != "UG-NHM"){ ?>
                            <option value="P">EMT</option>
                            <option value="D">Pilot</option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
            </div>
            <?php }?>

        <div class="width20 float_left">
            <div class="button_field_row">
                <div class="button_box">
                    <input type="submit" name="submit" value="Download" TABINDEX="3" class="float_right">
                    <!-- <input type="reset"  value="Reset Filters"> -->
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

<iframe name="form_frame" style="height: 1px; width: 1px; border:0px; background: none;"></iframe>
<!-- <script>;
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

</script>        -->