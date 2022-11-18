
<!--<h2>Export <?php echo $report_name;?> Details</h2> -->
<div class="width100">
        <div class="field_row float_left width75">

            <div class="filed_select">
                <div class="width30 drg float_left">
                    <div class="width100 float_left">
                        <div class="style6 float_left">From: </div>
                    </div>
                    <div class="width100 float_left">
                        <input name="from_date" tabindex="1" class="form_input filter_required" placeholder="From Date" type="text" data-base="search_btn" data-errors="{filter_required:'From Date should not be blank!',filter_time_hm:'Please enter valid time(H:i)'}" value="" readonly="readonly" id="from_date">
                    </div>
                </div>
                 <div class="width30 drg float_left">
                    <div class="width100 float_left">
                        <div class="style6 float_left">To : </div>
                    </div>
                    <div class="width100 float_left">
                        <input name="to_date" tabindex="2" class="form_input filter_required" placeholder="To Date" type="text" data-base="search_btn" data-errors="{filter_required:'To Date should not be blank!',filter_time_hm:'Please enter valid time(H:i)'}" value="" readonly="readonly" id="to_date">
                    </div>
                </div>
                 <div class="width30 drg float_left">
                    <div class="width100 float_left">
                        <div class="style6 float_left">Sick Room : </div>
                    </div>
                    <div class="width100 float_left">
                       <input name="school_id" value="<?=@$amb[0]->school_id;?>" class="mi_autocomplete width99 filter_required" data-href="{base_url}auto/get_school_by_clusterid?cluster_id=<?php echo $cluster_id;?>"  data-base="" tabindex="7" data-value="<?php echo $amb[0]->school_name; ?>" data-nonedit="yes" readonly="readonly" data-errors="{filter_required:'School should not be blank'}"  >
                            
                    </div>
                </div>
<!--                <div class="width25 drg float_left">
                    <div class="width100 float_left">
                        <div class="style6 float_left">Type Of Inventory : </div>
                    </div>
                    <div class="width100 float_left">
                       <select name="inv_type" class="dropdown_per_page" data-base="search" >
                            <option value="">Select Inventory</option>
                            <option value="CA">Consumables</option>
                            <option value="NCA">Non Consumables</option>
                            <option value="MED">Medicine</option>
                            <option value="EQP">Equipment</option>
                       </select>  
                    </div>
                </div>-->


            </div>

        </div>
        <div class="width25 float_left" style="margin-top: 10px;">
            <div class="button_field_row">
                <div class="button_box">

<!--                    <input type="submit" name="submit" value="Submit" TABINDEX="3">  -->
                    <input type="button" name="submit"  value="Submit" data-qr="output_position=list_table&amp;reports=view&amp;module_name=reports&amp;showprocess=no" data-href="<?php echo base_url(); ?>tdd_reports/<?php echo $submit_function;?>" class="form-xhttp-request btn clg_search" >
                </div>
            </div>
        </div>
</div>
<iframe name="form_frame" style="height: 1px; width: 1px; border:0px; background: none;"></iframe>
<script>;
    jQuery(document).ready(function(){  
        
    var dateFormat = "mm/dd/yy",
      from = jQuery( "#from_date" )
        .datepicker({
          defaultDate:  new Date(),
          changeMonth: true,
          numberOfMonths: 2
        })
        .on( "change", function() {
          to.datepicker( "option", "minDate", getDate( this ) );
        }),
      to = jQuery( "#to_date" ).datepicker({
        defaultDate:  new Date(),
        changeMonth: true,
        numberOfMonths: 2
      })
      .on( "change", function() {
        from.datepicker( "option", "maxDate", getDate( this ) );
      });
 
    function getDate( element ) {
      var date;
      try {
        date = $.datepicker.parseDate( dateFormat, element.value );
      } catch( error ) {
        date = null;
      }
      return date;
    }
  } );

</script>