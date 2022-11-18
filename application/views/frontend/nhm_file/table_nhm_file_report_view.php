
   <script>
        $(".mi_loader").fadeOut("slow");
    </script>
    <style>
#colorbox{
     background: #fff;
}
</style>
<!--<h2>Export <?php echo $report_name; ?> Details</h2> -->
<div class="width100 float_left width69">
    <form enctype="multipart/form-data" action="#" method="post" id="reports_type">
        <div class="field_row float_left width100">

            <div class="width_50 float_left">
                
                <div class="width100 drg float_left">
                    <div class="width100 float_left">
                        <div class="style6 float_left">Select Year: </div>
                    </div>
                    <div class="width100 float_left" >

                        <select name="from_year" class="filter_required" data-errors="{filter_required:'Month should not be blank!'}">
                            <option value="">Select Year</option>
                            <option value="2015">2015</option>
                            <option value="2016">2016</option>
                            <option value="2017">2017</option>
                            <option value="2018">2018</option>
                            <option value="2019">2019</option>
                            <option value="2020">2020</option>
                            <option value="2021">2021</option>
                            <option value="2022">2022</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="width_50 float_left">
                
                <div class="width100 drg float_left">
                    <div class="width100 float_left">
                        <div class="style6 float_left">Select Month: </div>
                    </div>
                    <div class="width100 float_left" >

                        <select name="from_date" class="filter_required" data-errors="{filter_required:'Month should not be blank!'}">
                            <option value="">Select Month</option>
                            <option value="January">January</option> 
                            <option value="February">February</option>	 
                            <option value="March">March</option>
                            <option value="April">April</option>
                            <option value="May">May</option>	
                            <option value="June">June</option> 
                            <option value="July">July</option> 
                            <option value="August">August</option>
                            <option value="September">September</option>
                            <option value="October">October</option>                                 
                            <option value="November">November</option> 
                            <option value="December">December</option>
                        </select>
                    </div>
                </div>
            </div>

       
        <div class="width_25 float_left" style="margin-top: 10px;">
            <div class="button_field_row">
                <div class="button_box">
                    <input type="button" name="submit" value="Submit" data-qr="output_position=list_table&amp;reports=view&amp;module_name=reports&amp;showprocess=yes" data-href="<?php echo base_url(); ?>file_nhm/<?php echo $submit_function; ?>" class="form-xhttp-request btn clg_search">
                </div>
            </div>
        </div>
        </div>
     </form>
         <div class="field_row float_left width100">
           
            <div id="report_listing">
            </div>
         </div>
   
</div>
<style>
    .width_50{
        width: 10% !important;
    }
    table{border-collapse: inherit;}
    td{
        /* font-weight: bold !important; */
        border: 2px solid black;
    }
    th{
        border: 2px solid black;
    }
</style>