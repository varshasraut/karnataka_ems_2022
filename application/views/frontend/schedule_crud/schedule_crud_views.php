<div class="register_outer_block">

    <div class="box3">
 
            <h1>View Employee Schedule</h1>   


            <div class="field_row width100">
                <div class="width2 float_left line_height">
                    <div class="shift width_30 float_left strong">User ID:</div>                

                    <div class="shift width70 float_left">

                        <?= $inc_emp_info[0]->user_id; ?>

                    </div>
                </div>
            

                <div class="width2 float_left line_height">
                    <div class="shift width_30 float_left strong">User Name: </div>
                    <div class="shift width70 float_left">
                        <?= $inc_emp_info[0]->user_name; ?>
                       
                    </div>
                </div>
                
           

            </div>

            <div class="field_row width100 ">
                <div class="width2 float_left line_height">
                    <div class="shift width_30 float_left strong">User Group: </div>
                    
                    <div class="shift width70 float_left">
                        <?= $inc_emp_info[0]->user_group; ?>
                        
                    </div>
                </div>
                
                <div class="width2 float_left line_height">
                    <div class="shift width_30 float_left strong">Schedule Type:</div>                

                    <div class="shift width70 float_left ">
                        
                        <?php  echo $inc_emp_info[0]->schedule_type;?>
                            
                    </div>
                </div>
                
            </div>
            <!-- <div class="filed_select width100 field_row">
                <div class="width2 float_left line_height">

                    <div class="shift width_30 float_left strong">Shift:</div>

                    <div class="shift width70 float_left">
                        <?php //echo $inc_emp_info[0]->shift_name;?>
                    </div>
                </div>
                <div class="width50 float_left line_height">
                    <div class="width_30 float_left shift">
                        <div class="float_left strong">From: </div>
                    </div>
                    <div class="width70 float_left shift">
                        <?php echo date("d-m-Y", strtotime($inc_emp_info[0]->from_date)); ?>
                    </div>
                </div>

            </div>
            <div class="filed_select width100 field_row">
                  <div class="width50 float_left line_height">
                    <div class="width_30 float_left">
                        <div class="shift float_left strong">To: </div>
                    </div>
                    <div class="shift width70 float_left">
                        <?php echo date("d-m-Y", strtotime($inc_emp_info[0]->to_date)); ?>
                    </div>
                </div>
                <div class="width50 float_left line_height">
                    <div class="width_30 float_left shift">
                        <div class="float_left strong">ERO-Supervisor Name: </div>
                    </div>
                    <div class="width70 float_left shift">
                        <?= $inc_emp_info[0]->ero_supervisor; ?>
                    </div>
                </div>
                
            </div>
            <div class="filed_select width100 field_row">
                <div class="width50 float_left line_height">
                    <div class="width_30 float_left shift">
                        <div class=" float_left strong">Shift-Manager Name: </div>
                    </div>
                    <div class="width70 float_left shift">
                        <?= $inc_emp_info[0]->shift_supervisor; ?>
                    </div>
                </div>
                <div class="width50 float_left line_height">
                    <div class="width_30 float_left shift">
                        <div class="float_left strong">Remark: </div>
                    </div>
                    <div class="width70 float_left shift">
                        <?= $inc_emp_info[0]->remark; ?>
                    </div>
                </div>
            </div>  -->
            <?php if($cal){ ?>
            <div class="cal">
                <?php echo $cal; ?>
            </div>   
            <?php }else{ ?> 
                <div class="no_record_text">No history Found</div>
           <?php } ?>               
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